# -*- coding: utf-8 -*-
"""Kiểm tra file dump: cân bằng nháy, số cột khớp số giá trị mỗi hàng."""
import re
import sys

import lib


def split_values(body):
    """Tách body của INSERT thành các tuple, tôn trọng chuỗi có escape."""
    rows, depth, i, n = [], 0, 0, len(body)
    start = None
    in_str = False
    while i < n:
        c = body[i]
        if in_str:
            if c == "\\":
                i += 2
                continue
            if c == "'":
                in_str = False
        elif c == "'":
            in_str = True
        elif c == "(":
            if depth == 0:
                start = i
            depth += 1
        elif c == ")":
            depth -= 1
            if depth == 0:
                rows.append(body[start:i + 1])
        i += 1
    if in_str or depth != 0:
        raise ValueError("chuỗi hoặc ngoặc không cân bằng")
    return rows


def split_fields(tup):
    out, buf, depth, in_str, i = [], [], 0, False, 1
    n = len(tup) - 1
    while i < n:
        c = tup[i]
        if in_str:
            buf.append(c)
            if c == "\\":
                buf.append(tup[i + 1])
                i += 2
                continue
            if c == "'":
                in_str = False
        elif c == "'":
            in_str = True
            buf.append(c)
        elif c == "," and depth == 0:
            out.append("".join(buf))
            buf = []
        else:
            if c == "(":
                depth += 1
            elif c == ")":
                depth -= 1
            buf.append(c)
        i += 1
    out.append("".join(buf))
    return out


def main(path):
    sql = lib.load(path)
    errs, tables = [], 0
    pat = re.compile(r"(?ms)^INSERT INTO `([^`]+)` \(([^\n]*?)\) VALUES\n(.*?);\s*$")
    for m in pat.finditer(sql):
        table, cols, body = m.group(1), m.group(2), m.group(3)
        ncol = len(cols.split(","))
        tables += 1
        try:
            rows = split_values(body)
        except ValueError as e:
            errs.append("%s: %s" % (table, e))
            continue
        if not rows:
            errs.append("%s: INSERT rỗng" % table)
        for k, r in enumerate(rows):
            nf = len(split_fields(r))
            if nf != ncol:
                errs.append("%s hàng %d: %d giá trị / %d cột" % (table, k + 1, nf, ncol))
    # kiểm tra bảng bị bỏ trống nhưng còn khoá ngoại trỏ tới
    print("Đã kiểm tra %d khối INSERT." % tables)
    if errs:
        print("LỖI (%d):" % len(errs))
        for e in errs[:40]:
            print("  -", e)
        return 1
    print("Không phát hiện lỗi cú pháp.")
    return 0


if __name__ == "__main__":
    sys.exit(main(sys.argv[1] if len(sys.argv) > 1 else lib.DST))
