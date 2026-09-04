# -*- coding: utf-8 -*-
"""Sinh SQL viết lại nội dung 6 trang ở chân trang."""
import os

import footer_pages_data as F
import lib
from lib import q

OUT = os.path.join(lib.ROOT, "malibu_update_trang_chan_trang.sql")
NOW = "2026-09-04 08:00:00"

NAMES = {
    5: "Ve chung toi",
    8: "Cau hoi thuong gap",
    12: "Chinh sach bao mat",
    13: "Dieu khoan va dieu kien",
    19: "Malibu Group",
    22: "Tuyen dung",
}


def build():
    p = []
    p.append("-- The Malibu Hotel — viet lai noi dung 6 trang o chan trang")
    p.append("-- Chay tren database dang dung cua website.")
    p.append("-- An toan khi chay lai nhieu lan.")
    p.append("--")
    p.append("-- Noi dung dung class Bootstrap cua theme nen KHONG can upload file nao.")
    p.append("")
    p.append("SET NAMES utf8mb4;")
    p.append("START TRANSACTION;")

    for pid in sorted(F.CONTENT):
        vi, en = F.CONTENT[pid]
        p.append("")
        p.append("-- ---------------------------------------------------------------")
        p.append("-- Trang %d — %s" % (pid, NAMES[pid]))
        p.append("-- ---------------------------------------------------------------")
        p.append("UPDATE `pages` SET `content` = %s, `content_mode` = 'blocks', "
                 "`updated_at` = %s WHERE `id` = %d;" % (q(vi), q(NOW), pid))
        p.append("UPDATE `pages_translations` SET `content` = %s, "
                 "`content_mode` = 'blocks' "
                 "WHERE `pages_id` = %d AND `lang_code` = 'en_US';" % (q(en), pid))

    p.append("")
    p.append("COMMIT;")
    p.append("")
    p.append("-- Kiem tra: do dai noi dung tung trang (truoc day deu duoi 3.000 ky tu)")
    p.append("SELECT `id`, `name`, CHAR_LENGTH(`content`) AS so_ky_tu "
             "FROM `pages` WHERE `id` IN (%s) ORDER BY `id`;"
             % ", ".join(str(i) for i in sorted(F.CONTENT)))
    p.append("")
    p.append("-- Sau khi chay xong, tren server chay: php artisan optimize:clear")
    return "\n".join(p) + "\n"


if __name__ == "__main__":
    sql = build()
    open(OUT, "w", encoding="utf-8", newline="\n").write(sql)
    print("da ghi %s (%.1f KB, %d trang)"
          % (OUT, len(sql.encode("utf-8")) / 1024, len(F.CONTENT)))
