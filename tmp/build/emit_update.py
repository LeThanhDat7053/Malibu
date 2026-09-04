# -*- coding: utf-8 -*-
"""Sinh file SQL tăng trưởng để chạy thủ công trên server.

Chỉ chứa phần thay đổi của Phase G: ảnh banner, icon tiện nghi,
và nội dung chi tiết 3 điểm ẩm thực.
"""
import os

import dining_data as D
import lib
import phase_g as G
import services_data as S
from lib import q

OUT = os.path.join(lib.ROOT, "malibu_update_banner_amthuc.sql")
NOW = G.NOW


def section(title):
    line = "-- " + "-" * 70
    return "\n%s\n-- %s\n%s\n" % (line, title, line)


def build():
    p = []
    p.append("-- Cập nhật The Malibu Hotel: ảnh banner + trang chi tiết ẩm thực")
    p.append("-- Chạy trên cơ sở dữ liệu đang dùng của website.")
    p.append("-- An toàn khi chạy lại nhiều lần.")
    p.append("")
    p.append("SET NAMES utf8mb4;")
    p.append("START TRANSACTION;")

    # ---------------------------------------------------------- meta_boxes
    p.append(section("1. Ảnh banner từng trang + icon tiện nghi (bảng meta_boxes)"))
    p.append("-- Xoá các bản ghi cùng loại trước để chạy lại được nhiều lần.")
    p.append("DELETE FROM `meta_boxes` WHERE `meta_key` IN "
             "('breadcrumb', 'breadcrumb_background') "
             "AND `reference_type` = 'Botble\\\\Page\\\\Models\\\\Page';")
    p.append("DELETE FROM `meta_boxes` WHERE `meta_key` = 'icon_image' "
             "AND `reference_type` = 'Botble\\\\Hotel\\\\Models\\\\Amenity';")
    p.append("")
    rows = G.meta_rows()
    p.append("INSERT INTO `meta_boxes` "
             "(`meta_key`, `meta_value`, `reference_id`, `reference_type`, "
             "`created_at`, `updated_at`) VALUES")
    values = []
    for _mid, key, value, ref, rtype in rows:
        values.append("  (%s, %s, %s, %s, %s, %s)"
                      % (q(key), q(value), ref, q(rtype), q(NOW), q(NOW)))
    p.append(",\n".join(values) + ";")

    # ---------------------------------------------------------- settings
    p.append(section("2. Ảnh banner mặc định trong Theme Options (bảng settings)"))
    p.append("-- Dashboard > Appearance > Theme Options > Breadcrumb background image")
    p.append("INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES")
    values = []
    for key, value in G.theme_option_rows():
        values.append("  (%s, %s, NULL, %s)" % (q(key), q(value), q(NOW)))
    p.append(",\n".join(values))
    p.append("ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), "
             "`updated_at` = VALUES(`updated_at`);")

    # ---------------------------------------------------------- pages.image
    p.append(section("3. Ảnh đại diện của trang (cột pages.image)"))
    p.append("-- Trước đây trỏ vào thumbnail 300x200 của web Malibu.")
    for pid, image in sorted(G.PAGE_IMAGE.items()):
        p.append("UPDATE `pages` SET `image` = %s, `updated_at` = %s "
                 "WHERE `id` = %d;" % (q(image), q(NOW), pid))

    # ---------------------------------------------------------- ht_services
    p.append(section("4. Nội dung chi tiết 3 điểm ẩm thực (Vela, Carina, The Lux Café)"))
    names = {s["id"]: s["name_vi"] for s in S.SERVICES}
    for sid, content_vi, content_en in G.dining_rows():
        p.append("-- %s (id %d)" % (names[sid], sid))
        p.append("UPDATE `ht_services` SET `content` = %s, `updated_at` = %s "
                 "WHERE `id` = %d;" % (q(content_vi), q(NOW), sid))
        p.append("UPDATE `ht_services_translations` SET `content` = %s "
                 "WHERE `ht_services_id` = %d AND `lang_code` = 'en_US';"
                 % (q(content_en), sid))
        p.append("")

    p.append("COMMIT;")
    p.append("")
    p.append("-- Sau khi chạy xong, trên server chạy: php artisan cache:clear")
    return "\n".join(p)


if __name__ == "__main__":
    sql = build()
    open(OUT, "w", encoding="utf-8", newline="\n").write(sql)
    print("đã ghi %s (%.1f KB)" % (OUT, len(sql.encode("utf-8")) / 1024))
