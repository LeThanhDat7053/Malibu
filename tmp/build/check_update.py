# -*- coding: utf-8 -*-
"""Kiểm tra file SQL tăng trưởng: cân bằng nháy, số câu lệnh, ảnh 200."""
import concurrent.futures as cf
import os
import re
import sys

import check_images
import lib

PATH = os.path.join(lib.ROOT, "malibu_update_banner_amthuc.sql")
BACKSLASH = chr(92)


def statements(s):
    out, i, in_str, start = [], 0, False, 0
    while i < len(s):
        c = s[i]
        if in_str:
            if c == BACKSLASH:
                i += 2
                continue
            if c == "'":
                in_str = False
        elif c == "'":
            in_str = True
        elif c == ";":
            out.append(s[start:i + 1])
            start = i + 1
        i += 1
    return out, in_str, s[start:]


def main():
    s = open(PATH, encoding="utf-8").read()
    stmts, unterminated, tail = statements(s)
    print("số câu lệnh SQL: %d" % len(stmts))
    if unterminated:
        print("LỖI: chuỗi nháy đơn không đóng")
        return 1
    leftover = re.sub(r"(?m)^\s*--.*$", "", tail).strip()
    if leftover:
        print("LỖI: còn nội dung sau câu lệnh cuối: %r" % leftover[:80])
        return 1

    kinds = {}
    for st in stmts:
        verb = st.strip().split(None, 1)[0].upper()
        kinds[verb] = kinds.get(verb, 0) + 1
    print("theo loại: %s" % ", ".join("%s=%d" % kv for kv in sorted(kinds.items())))

    urls = sorted(set(u.replace(BACKSLASH + "/", "/")
                      for u in re.findall(r"https://[a-z0-9.\-]+/files/[^\\\"' )]+", s)))
    print("số URL ảnh: %d" % len(urls))
    bad = []
    with cf.ThreadPoolExecutor(max_workers=10) as ex:
        for url, status, info in ex.map(check_images.head, urls):
            if status != 200 or not info.startswith("image"):
                bad.append((url, status))
    if bad:
        print("ẢNH HỎNG:")
        for u, st in bad:
            print("  %s [%s]" % (u, st))
        return 1
    print("Tất cả ảnh trả về 200. File hợp lệ.")
    return 0


if __name__ == "__main__":
    sys.exit(main())
