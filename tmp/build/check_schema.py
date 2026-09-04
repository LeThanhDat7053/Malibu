# -*- coding: utf-8 -*-
"""Kiểm tra khoá chính trùng và giá trị vượt độ dài cột so với CREATE TABLE."""
import re
import sys

import lib
from check_data import read

UNESC = {"n": "\n", "r": "\r", "t": "\t", "0": "\x00", "Z": "\x1a"}


def unescape(s):
    out, i = [], 0
    while i < len(s):
        if s[i] == "\\" and i + 1 < len(s):
            out.append(UNESC.get(s[i + 1], s[i + 1]))
            i += 2
        else:
            out.append(s[i])
            i += 1
    return "".join(out)


def schema(sql):
    """{bảng: {cột: (kiểu, độ dài, cho phép NULL)}} + khoá chính."""
    out = {}
    for m in re.finditer(r"(?s)CREATE TABLE `([^`]+)` \((.*?)\n\) ENGINE", sql):
        table, body = m.group(1), m.group(2)
        cols = {}
        for line in body.split("\n"):
            c = re.match(r"\s*`([^`]+)` (\w+)(?:\((\d+)[^)]*\))?(.*)", line)
            if not c:
                continue
            cols[c.group(1)] = (c.group(2).lower(),
                                int(c.group(3)) if c.group(3) else None,
                                "NOT NULL" not in c.group(4))
        out[table] = cols
    # khoá chính từ ALTER TABLE
    pk = {}
    for m in re.finditer(r"(?s)ALTER TABLE `([^`]+)`\n((?:  ADD[^;]*?);)", sql):
        t, body = m.group(1), m.group(2)
        p = re.search(r"ADD PRIMARY KEY \(([^)]*)\)", body)
        if p:
            pk[t] = [x.strip().strip("`") for x in p.group(1).split(",")]
        for u in re.finditer(r"ADD UNIQUE KEY `[^`]+` \(([^)]*)\)", body):
            pk.setdefault(t + "\x00unique", []).append(
                [x.strip().strip("`") for x in u.group(1).split(",")])
    return out, pk


TEXTY = {"varchar", "char"}


def main():
    sql = lib.load(lib.DST)
    sch, pk = schema(sql)
    err = []
    for table in re.findall(r"^INSERT INTO `([^`]+)`", sql, re.M):
        cols, rows = read(sql, table)
        spec = sch.get(table, {})
        keys = pk.get(table)
        seen = set()
        for n, r in enumerate(rows, start=1):
            if keys and all(k in r for k in keys):
                kv = tuple(r[k] for k in keys)
                if kv in seen:
                    err.append("%s: khoá chính trùng %s" % (table, kv))
                seen.add(kv)
            for uniq in pk.get(table + "\x00unique", []):
                pass
            for col, val in r.items():
                t, length, nullable = spec.get(col, (None, None, True))
                if val is None:
                    if not nullable and col != "id":
                        err.append("%s.%s hàng %d: NULL nhưng cột NOT NULL"
                                   % (table, col, n))
                    continue
                if t in TEXTY and length:
                    real = len(unescape(val))
                    if real > length:
                        err.append("%s.%s hàng %d: %d ký tự > %s(%d)"
                                   % (table, col, n, real, t, length))
    print("Đã kiểm tra %d bảng." % len(set(re.findall(r"^INSERT INTO `([^`]+)`", sql, re.M))))
    if err:
        print("VẤN ĐỀ (%d):" % len(err))
        for e in err[:40]:
            print("  -", e)
        return 1
    print("Không có khoá trùng, không có giá trị vượt độ dài cột.")
    return 0


if __name__ == "__main__":
    sys.exit(main())
