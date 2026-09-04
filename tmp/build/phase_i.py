# -*- coding: utf-8 -*-
"""Phase I: viết lại nội dung 6 trang ở chân trang."""
import footer_pages_data as F
import lib
from check_data import read
from lib import row
from phase_a import unescape

NOW = "2026-09-04 08:00:00"


def u(value):
    return None if value is None else unescape(value)


def apply(sql):
    pages = []
    for r in read(sql, "pages")[1]:
        pid = int(r["id"])
        content = F.CONTENT[pid][0] if pid in F.CONTENT else u(r["content"])
        pages.append(row(
            pid, u(r["name"]), content, u(r["content_mode"]), u(r["custom_html"]),
            int(r["user_id"]), u(r["image"]), u(r["template"]), u(r["description"]),
            u(r["status"]), u(r["created_at"]), NOW if pid in F.CONTENT else u(r["updated_at"]),
        ))
    sql = lib.replace(sql, "pages", pages)

    translations = []
    for r in read(sql, "pages_translations")[1]:
        pid = int(r["pages_id"])
        content = F.CONTENT[pid][1] if pid in F.CONTENT else u(r["content"])
        translations.append(row(
            "en_US", pid, u(r["name"]), u(r["description"]), content,
            u(r["content_mode"]), u(r["custom_html"]),
        ))
    sql = lib.replace(sql, "pages_translations", translations)
    return sql


if __name__ == "__main__":
    lib.save(apply(lib.load(lib.DST)))
    print("Phase I xong: %d trang" % len(F.CONTENT))
