# -*- coding: utf-8 -*-
"""Sinh SQL cho nút "Đặt phòng": đưa nhãn, link và màu ra Theme Options.

Lấy đúng bộ giá trị đã khai trong phase_a nên hai file không thể lệch nhau.
"""
import os

import lib
import phase_a as A
from lib import q

OUT = os.path.join(lib.ROOT, "malibu_update_nut_dat_phong.sql")
NOW = A.NOW

KEYS = (["theme-riorelax-" + k for k in A.BOOKING_BUTTON]
        + ["theme-riorelax-en_US-" + k for k in A.BOOKING_BUTTON]
        + ["theme-riorelax-booking_button_label",
           "theme-riorelax-en_US-booking_button_label"])


def build():
    p = []
    p.append("-- The Malibu Hotel — dua nut \"DAT PHONG\" ra Theme Options")
    p.append("-- Chay SAU khi da upload code.")
    p.append("-- An toan khi chay lai nhieu lan.")
    p.append("--")
    p.append("-- Sau khi chay, vao Dashboard > Appearance > Theme Options > Nut dat phong")
    p.append("-- de doi nhan, duong dan va mau bat cu luc nao.")
    p.append("")
    p.append("SET NAMES utf8mb4;")
    p.append("START TRANSACTION;")
    p.append("")
    p.append("INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES")
    rows = []
    for key in KEYS:
        rows.append("  (%s, %s, NULL, %s)" % (q(key), q(A.NEW[key]), q(NOW)))
    p.append(",\n".join(rows))
    p.append("ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), "
             "`updated_at` = VALUES(`updated_at`);")
    p.append("")
    p.append("COMMIT;")
    p.append("")
    p.append("-- Kiem tra lai")
    p.append("SELECT `key`, `value` FROM `settings` "
             "WHERE `key` LIKE '%booking\\_button\\_%' OR `key` LIKE '%booking\\_panel\\_%' "
             "ORDER BY `key`;")
    p.append("")
    p.append("-- Sau khi chay xong, tren server chay: php artisan optimize:clear")
    return "\n".join(p) + "\n"


if __name__ == "__main__":
    sql = build()
    open(OUT, "w", encoding="utf-8", newline="\n").write(sql)
    print("da ghi %s (%d dong, %d khoa)"
          % (OUT, sql.count("\n"), len(KEYS)))
