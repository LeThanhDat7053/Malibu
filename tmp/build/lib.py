# -*- coding: utf-8 -*-
"""Khung chuyển dump Ruby68 -> Malibu."""
import os
import re

ROOT = r"c:\laragon\www\malibu"
SRC = os.path.join(ROOT, "travellink_ruby68hotel.sql")
DST = os.path.join(ROOT, "travellink_malibu.sql")

INSERT_RE = r"(?ms)^INSERT INTO `%s` \((?P<cols>[^\n]*?)\) VALUES\n(?P<body>.*?);\s*$"


def load(path=SRC):
    return open(path, encoding="utf-8").read()


def columns(sql, table):
    m = re.search(INSERT_RE % re.escape(table), sql)
    if m:
        return [c.strip().strip("`") for c in m.group("cols").split(",")]
    c = re.search(r"(?s)CREATE TABLE `%s` \((.*?)\n\) ENGINE" % re.escape(table), sql)
    if not c:
        return []
    return [x.group(1) for x in re.finditer(r"^\s*`([^`]+)`", c.group(1), re.M)]


def replace(sql, table, rows, cols=None):
    """rows == [] -> xoá sạch dữ liệu bảng; rows is None -> giữ nguyên."""
    if rows is None:
        return sql
    if cols is None:
        cols = columns(sql, table)
    block = None
    if rows:
        header = "INSERT INTO `%s` (%s) VALUES\n" % (
            table, ", ".join("`%s`" % c for c in cols))
        block = header + ",\n".join(rows) + ";"

    pat = re.compile(INSERT_RE % re.escape(table))
    found = list(pat.finditer(sql))
    if not found:
        if not rows:
            return sql
        anchor = re.search(
            r"(?s)(CREATE TABLE `%s` \(.*?\n\) ENGINE[^;]*;\n)" % re.escape(table), sql)
        if not anchor:
            raise KeyError("Không tìm thấy bảng " + table)
        return sql[:anchor.end(1)] + "\n" + block + "\n" + sql[anchor.end(1):]

    out, last = [], 0
    for i, m in enumerate(found):
        out.append(sql[last:m.start()])
        if i == 0 and block:
            out.append(block)
        last = m.end()
        if (i > 0 or not block) and last < len(sql) and sql[last] == "\n":
            last += 1
    out.append(sql[last:])
    return "".join(out)


def autoinc(sql, table, value):
    pat = r"(?ms)^(ALTER TABLE `%s`\n  MODIFY `[^`]+` [^;]*?AUTO_INCREMENT=)\d+;" % re.escape(table)
    return re.sub(pat, lambda m: m.group(1) + str(value) + ";", sql)


ESCAPES = [
    ("\\", "\\\\"),
    ("'", "\\'"),
    ('"', '\\"'),
    ("\n", "\\n"),
    ("\r", "\\r"),
    ("\x00", "\\0"),
    ("\x1a", "\\Z"),
]


def q(v):
    """Escape giá trị thành literal SQL kiểu mysqldump."""
    if v is None:
        return "NULL"
    if isinstance(v, bool):
        return "1" if v else "0"
    if isinstance(v, (int, float)):
        return repr(v)
    s = str(v)
    for a, b in ESCAPES:
        s = s.replace(a, b)
    return "'" + s + "'"


def row(*vals):
    return "(" + ", ".join(q(v) for v in vals) + ")"


def save(sql, path=DST):
    open(path, "w", encoding="utf-8", newline="\n").write(sql)
    return len(sql)
