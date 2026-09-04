# -*- coding: utf-8 -*-
"""Sinh file SQL cho tính năng Nhà hàng (plugin `restaurant`).

Chạy thủ công trên server sau khi đã upload code.
"""
import json
import os

import lib
import restaurants_data as R
from lib import q

OUT = os.path.join(lib.ROOT, "malibu_update_nha_hang.sql")
NOW = "2026-09-04 08:00:00"
MODEL = "Botble\\\\Restaurant\\\\Models\\\\Restaurant"      # dạng đã escape cho SQL
SLUG_PREFIX = "nha-hang"

# id bắt đầu cho slug và gallery_meta mới, chọn cao để không đụng dữ liệu sẵn có
SLUG_ID_BASE = 200
META_ID_BASE = 200


def line(title):
    bar = "-- " + "-" * 70
    return "\n%s\n-- %s\n%s\n" % (bar, title, bar)


def create_tables():
    return """
CREATE TABLE IF NOT EXISTS `ht_restaurants` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `videos` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vr360_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_hours` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuisine` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ht_restaurants_status_index` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ht_restaurants_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_restaurants_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capacity` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_hours` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cuisine` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`, `ht_restaurants_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
""".strip()


def build():
    p = []
    p.append("-- The Malibu Hotel — tinh nang Nha hang (plugin `restaurant`)")
    p.append("-- Chay SAU khi da upload code len server.")
    p.append("-- An toan khi chay lai nhieu lan.")
    p.append("")
    p.append("SET NAMES utf8mb4;")
    p.append("START TRANSACTION;")

    p.append(line("1. Tao bang"))
    p.append(create_tables())

    p.append(line("2. Du lieu 3 nha hang"))
    p.append("DELETE FROM `ht_restaurants_translations` WHERE `ht_restaurants_id` IN (1, 2, 3);")
    p.append("DELETE FROM `ht_restaurants` WHERE `id` IN (1, 2, 3);")
    p.append("")
    p.append("INSERT INTO `ht_restaurants` (`id`, `name`, `description`, `content`, `images`, "
             "`videos`, `vr360_url`, `location`, `capacity`, `opening_hours`, `cuisine`, "
             "`phone`, `email`, `is_featured`, `order`, `status`, `created_at`, `updated_at`) VALUES")
    rows = []
    for r in R.RESTAURANTS:
        rows.append("  (%s, %s, %s, %s, %s, '[]', NULL, %s, %s, %s, %s, %s, %s, %d, %d, "
                    "'published', %s, %s)" % (
                        r["id"], q(r["name_vi"]), q(r["desc_vi"]), q(r["content_vi"]),
                        q(json.dumps(r["images"], ensure_ascii=False)),
                        q(r["location_vi"]), q(r["capacity_vi"] or None),
                        q(r["hours_vi"]), q(r["cuisine_vi"]),
                        q(R.PHONE), q(R.EMAIL),
                        r["featured"], r["order"], q(NOW), q(NOW)))
    p.append(",\n".join(rows) + ";")
    p.append("")
    p.append("INSERT INTO `ht_restaurants_translations` (`lang_code`, `ht_restaurants_id`, "
             "`name`, `description`, `content`, `location`, `capacity`, `opening_hours`, "
             "`cuisine`) VALUES")
    rows = []
    for r in R.RESTAURANTS:
        rows.append("  ('en_US', %s, %s, %s, %s, %s, %s, %s, %s)" % (
            r["id"], q(r["name_en"]), q(r["desc_en"]), q(r["content_en"]),
            q(r["location_en"]), q(r["capacity_en"] or None),
            q(r["hours_en"]), q(r["cuisine_en"])))
    p.append(",\n".join(rows) + ";")

    p.append(line("3. Thu vien anh (bang gallery_meta, dung chung voi Room)"))
    p.append("DELETE FROM `gallery_meta` WHERE `reference_type` = '%s';" % MODEL)
    p.append("")
    p.append("INSERT INTO `gallery_meta` (`id`, `images`, `reference_id`, `reference_type`, "
             "`created_at`, `updated_at`) VALUES")
    rows = []
    for i, r in enumerate(R.RESTAURANTS):
        images = json.dumps(
            [{"img": u, "description": "", "type": "image"} for u in r["images"]],
            ensure_ascii=False)
        rows.append("  (%d, %s, %d, '%s', %s, %s)" % (
            META_ID_BASE + i, q(images), r["id"], MODEL, q(NOW), q(NOW)))
    p.append(",\n".join(rows) + ";")

    p.append(line("4. Duong dan (slug) cho 3 nha hang"))
    p.append("DELETE FROM `slugs_translations` WHERE `slugs_id` IN (%s);"
             % ", ".join(str(SLUG_ID_BASE + i) for i in range(len(R.RESTAURANTS))))
    p.append("DELETE FROM `slugs` WHERE `reference_type` = '%s';" % MODEL)
    p.append("")
    p.append("INSERT INTO `slugs` (`id`, `key`, `reference_id`, `reference_type`, `prefix`, "
             "`created_at`, `updated_at`) VALUES")
    rows = []
    for i, r in enumerate(R.RESTAURANTS):
        rows.append("  (%d, %s, %d, '%s', %s, %s, %s)" % (
            SLUG_ID_BASE + i, q(r["slug_vi"]), r["id"], MODEL,
            q(SLUG_PREFIX), q(NOW), q(NOW)))
    p.append(",\n".join(rows) + ";")
    p.append("")
    p.append("INSERT INTO `slugs_translations` (`lang_code`, `slugs_id`, `key`, `prefix`) VALUES")
    rows = []
    for i, r in enumerate(R.RESTAURANTS):
        rows.append("  ('en_US', %d, %s, %s)" % (
            SLUG_ID_BASE + i, q(r["slug_en"]), q(SLUG_PREFIX)))
    p.append(",\n".join(rows) + ";")

    p.append(line("5. Bo 3 muc nay khoi Tien nghi & Dich vu (ht_services)"))
    ids = ", ".join(str(i) for i in R.REMOVED_SERVICE_IDS)
    p.append("DELETE FROM `ht_services_translations` WHERE `ht_services_id` IN (%s);" % ids)
    p.append("DELETE FROM `ht_services` WHERE `id` IN (%s);" % ids)
    p.append("DELETE FROM `slugs_translations` WHERE `slugs_id` IN (%s);"
             % ", ".join(str(i) for i in R.REMOVED_SERVICE_SLUG_IDS))
    p.append("DELETE FROM `slugs` WHERE `id` IN (%s);"
             % ", ".join(str(i) for i in R.REMOVED_SERVICE_SLUG_IDS))

    p.append(line("6. Bo trang 'Am thuc' cu, menu tro thang vao /nha-hang"))
    p.append("DELETE FROM `pages_translations` WHERE `pages_id` = %d;" % R.OLD_PAGE_ID)
    p.append("DELETE FROM `pages` WHERE `id` = %d;" % R.OLD_PAGE_ID)
    p.append("DELETE FROM `slugs_translations` WHERE `slugs_id` = %d;" % R.OLD_PAGE_SLUG_ID)
    p.append("DELETE FROM `slugs` WHERE `id` = %d;" % R.OLD_PAGE_SLUG_ID)
    p.append("DELETE FROM `meta_boxes` WHERE `reference_id` = %d "
             "AND `reference_type` = 'Botble\\\\Page\\\\Models\\\\Page';" % R.OLD_PAGE_ID)
    p.append("")
    p.append("-- Node menu: doi ten, tro vao /nha-hang va bat tu dong do danh sach")
    for node_id, (title, prefix) in sorted(R.MENU_NODES.items()):
        p.append("UPDATE `menu_nodes` SET `title` = %s, `url` = %s, `reference_id` = 0, "
                 "`reference_type` = NULL, `css_class` = 'auto-restaurants', "
                 "`has_child` = 1, `updated_at` = %s WHERE `id` = %d;"
                 % (q(title), q(prefix + "/" + SLUG_PREFIX), q(NOW), node_id))
    p.append("")
    p.append("-- Node con tro toi trang chi tiet dich vu cu (neu con) khong con dung nua")
    p.append("DELETE FROM `menu_nodes` WHERE `url` IN "
             "('/services/vela-restaurant', '/services/carina-restaurant', "
             "'/services/the-lux-cafe', '/en/services/vela-restaurant', "
             "'/en/services/carina-restaurant', '/en/services/the-lux-cafe');")

    p.append(line("7. Bat plugin Nha hang"))
    p.append("UPDATE `settings` SET `value` = JSON_ARRAY_APPEND(`value`, '$', 'restaurant'), "
             "`updated_at` = %s WHERE `key` = 'activated_plugins' "
             "AND JSON_SEARCH(`value`, 'one', 'restaurant') IS NULL;" % q(NOW))

    p.append("")
    p.append("COMMIT;")
    p.append("")
    p.append("-- Sau khi chay xong, tren server chay: php artisan optimize:clear")
    return "\n".join(p) + "\n"


if __name__ == "__main__":
    sql = build()
    open(OUT, "w", encoding="utf-8", newline="\n").write(sql)
    print("da ghi %s (%.1f KB)" % (OUT, len(sql.encode("utf-8")) / 1024))
