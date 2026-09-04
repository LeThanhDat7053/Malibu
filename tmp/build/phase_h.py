# -*- coding: utf-8 -*-
"""Phase H: chuyển 3 điểm ẩm thực sang plugin `restaurant`.

Giữ bản dump đầy đủ khớp với file SQL tăng trưởng malibu_update_nha_hang.sql:
thêm bảng ht_restaurants, bỏ 3 mục khỏi ht_services, bỏ trang "Ẩm thực",
và trỏ node menu vào /nha-hang.
"""
import json
import re

import emit_restaurant as E
import lib
import restaurants_data as R
from check_data import read
from lib import row
from phase_a import unescape

NOW = E.NOW
MODEL = "Botble\\Restaurant\\Models\\Restaurant"   # dạng PHP thật (chưa escape SQL)


def u(value):
    return None if value is None else unescape(value)


def apply(sql):
    # ---------------------------------------------------- thêm hai bảng mới
    if "CREATE TABLE `ht_restaurants`" not in sql:
        block = (
            "\n-- --------------------------------------------------------\n\n"
            "--\n-- Cấu trúc bảng cho bảng `ht_restaurants`\n--\n\n"
            "DROP TABLE IF EXISTS `ht_restaurants`;\n"
            + E.create_tables().replace("CREATE TABLE IF NOT EXISTS", "CREATE TABLE")
            + "\n"
        )
        anchor = sql.index("--\n-- Các ràng buộc cho các bảng đã đổ")
        sql = sql[:anchor] + block + "\n" + sql[anchor:]

    # ---------------------------------------------------- dữ liệu nhà hàng
    rows, trs = [], []
    for r in R.RESTAURANTS:
        rows.append(row(
            r["id"], r["name_vi"], r["desc_vi"], r["content_vi"],
            json.dumps(r["images"], ensure_ascii=False), "[]", None,
            r["location_vi"], r["capacity_vi"] or None, r["hours_vi"],
            r["cuisine_vi"], R.PHONE, R.EMAIL,
            r["featured"], r["order"], "published", NOW, NOW,
        ))
        trs.append(row(
            "en_US", r["id"], r["name_en"], r["desc_en"], r["content_en"],
            r["location_en"], r["capacity_en"] or None, r["hours_en"],
            r["cuisine_en"],
        ))
    sql = lib.replace(sql, "ht_restaurants", rows)
    sql = lib.replace(sql, "ht_restaurants_translations", trs)

    # ---------------------------------------------------- thư viện ảnh
    meta = []
    for r in read(sql, "gallery_meta")[1]:
        meta.append(row(int(r["id"]), u(r["images"]), int(r["reference_id"]),
                        u(r["reference_type"]), u(r["created_at"]), u(r["updated_at"])))
    for i, r in enumerate(R.RESTAURANTS):
        images = json.dumps(
            [{"img": url, "description": "", "type": "image"} for url in r["images"]],
            ensure_ascii=False)
        meta.append(row(E.META_ID_BASE + i, images, r["id"], MODEL, NOW, NOW))
    sql = lib.replace(sql, "gallery_meta", meta)
    sql = lib.autoinc(sql, "gallery_meta", E.META_ID_BASE + len(R.RESTAURANTS) + 1)

    # ---------------------------------------------------- dịch vụ: bỏ 3 mục
    keep = [str(i) for i in range(1, 13) if i not in R.REMOVED_SERVICE_IDS]
    services = [
        row(int(r["id"]), u(r["name"]), u(r["description"]), u(r["content"]),
            float(r["price"]), u(r["price_type"]), None, u(r["image"]),
            u(r["custom_url"]), u(r["status"]), u(r["created_at"]), u(r["updated_at"]))
        for r in read(sql, "ht_services")[1] if r["id"] in keep
    ]
    sql = lib.replace(sql, "ht_services", services)
    sql = lib.replace(sql, "ht_services_translations", [
        row("en_US", int(r["ht_services_id"]), u(r["name"]), u(r["description"]),
            u(r["content"]), u(r["custom_url"]))
        for r in read(sql, "ht_services_translations")[1]
        if r["ht_services_id"] in keep
    ])

    # ---------------------------------------------------- trang "Ẩm thực"
    sql = lib.replace(sql, "pages", [
        row(int(r["id"]), u(r["name"]), u(r["content"]), u(r["content_mode"]),
            u(r["custom_html"]), int(r["user_id"]), u(r["image"]), u(r["template"]),
            u(r["description"]), u(r["status"]), u(r["created_at"]), u(r["updated_at"]))
        for r in read(sql, "pages")[1] if int(r["id"]) != R.OLD_PAGE_ID
    ])
    sql = lib.replace(sql, "pages_translations", [
        row("en_US", int(r["pages_id"]), u(r["name"]), u(r["description"]),
            u(r["content"]), u(r["content_mode"]), u(r["custom_html"]))
        for r in read(sql, "pages_translations")[1]
        if int(r["pages_id"]) != R.OLD_PAGE_ID
    ])
    sql = lib.replace(sql, "meta_boxes", [
        row(int(r["id"]), u(r["meta_key"]), u(r["meta_value"]), int(r["reference_id"]),
            u(r["reference_type"]), u(r["created_at"]), u(r["updated_at"]))
        for r in read(sql, "meta_boxes")[1]
        if not (int(r["reference_id"]) == R.OLD_PAGE_ID and "Page" in r["reference_type"])
    ])

    # ---------------------------------------------------- slug
    drop_slug_ids = set(R.REMOVED_SERVICE_SLUG_IDS) | {R.OLD_PAGE_SLUG_ID}
    slugs = [
        row(int(r["id"]), u(r["key"]), int(r["reference_id"]), u(r["reference_type"]),
            u(r["prefix"]), u(r["created_at"]), u(r["updated_at"]))
        for r in read(sql, "slugs")[1] if int(r["id"]) not in drop_slug_ids
    ]
    slug_trs = [
        row("en_US", int(r["slugs_id"]), u(r["key"]), u(r["prefix"]))
        for r in read(sql, "slugs_translations")[1]
        if int(r["slugs_id"]) not in drop_slug_ids
    ]
    for i, r in enumerate(R.RESTAURANTS):
        sid = E.SLUG_ID_BASE + i
        slugs.append(row(sid, r["slug_vi"], r["id"], MODEL, E.SLUG_PREFIX, NOW, NOW))
        slug_trs.append(row("en_US", sid, r["slug_en"], E.SLUG_PREFIX))
    sql = lib.replace(sql, "slugs", slugs)
    sql = lib.replace(sql, "slugs_translations", slug_trs)
    sql = lib.autoinc(sql, "slugs", E.SLUG_ID_BASE + len(R.RESTAURANTS) + 1)

    # ---------------------------------------------------- menu
    dead_urls = {
        "/services/vela-restaurant", "/services/carina-restaurant",
        "/services/the-lux-cafe", "/en/services/vela-restaurant",
        "/en/services/carina-restaurant", "/en/services/the-lux-cafe",
    }
    nodes = []
    for r in read(sql, "menu_nodes")[1]:
        nid = int(r["id"])
        if u(r["url"]) in dead_urls:
            continue
        title, url = u(r["title"]), u(r["url"])
        ref, ref_type, css, child = int(r["reference_id"]), u(r["reference_type"]), \
            u(r["css_class"]), int(r["has_child"])
        if nid in R.MENU_NODES:
            title, prefix = R.MENU_NODES[nid]
            url = prefix + "/" + E.SLUG_PREFIX
            ref, ref_type, css, child = 0, None, "auto-restaurants", 1
        nodes.append(row(nid, int(r["menu_id"]), int(r["parent_id"]), ref, ref_type,
                         url, u(r["icon_font"]), int(r["position"]), title, css,
                         u(r["target"]), child, u(r["created_at"]), u(r["updated_at"])))
    sql = lib.replace(sql, "menu_nodes", nodes)

    # ---------------------------------------------------- bật plugin
    def add_plugin(match):
        value = match.group(1)
        if "restaurant" in value:
            return match.group(0)
        return match.group(0).replace(value, value[:-1] + ',\\"restaurant\\"]')

    sql = re.sub(r"\(4, 'activated_plugins', '(\[[^']*\])'", add_plugin, sql, count=1)
    return sql


if __name__ == "__main__":
    lib.save(apply(lib.load(lib.DST)))
    print("Phase H xong: %d nhà hàng" % len(R.RESTAURANTS))
