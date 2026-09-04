# -*- coding: utf-8 -*-
"""Kiểm tra tính nhất quán dữ liệu trong dump Malibu."""
import re
import sys

import lib
from validate import split_fields, split_values


def read(sql, table):
    m = re.search(lib.INSERT_RE % re.escape(table), sql)
    cols = lib.columns(sql, table)
    if not m:
        return cols, []
    rows = []
    for t in split_values(m.group("body")):
        vals = []
        for f in split_fields(t):
            f = f.strip()
            vals.append(None if f == "NULL" else
                        (f[1:-1] if f.startswith("'") else f))
        rows.append(dict(zip(cols, vals)))
    return cols, rows


def main():
    sql = lib.load(lib.DST)
    err = []

    def ids(table, col="id"):
        return {r[col] for r in read(sql, table)[1]}

    rooms = ids("ht_rooms")
    cats = ids("ht_room_categories")
    services = ids("ht_services")
    places = ids("ht_places")
    galleries = ids("galleries")
    posts = ids("posts")
    blogcats = ids("categories")
    tags = ids("tags")
    pages = ids("pages")
    amenities = ids("ht_amenities")
    users = ids("users")
    faqcats = ids("faq_categories")

    for r in read(sql, "ht_rooms")[1]:
        if r["room_category_id"] not in cats:
            err.append("ht_rooms %s -> hạng phòng %s không tồn tại"
                       % (r["id"], r["room_category_id"]))
    for r in read(sql, "ht_rooms_amenities")[1]:
        if r["room_id"] not in rooms:
            err.append("ht_rooms_amenities -> phòng %s không tồn tại" % r["room_id"])
        if r["amenity_id"] not in amenities:
            err.append("ht_rooms_amenities -> tiện nghi %s không tồn tại" % r["amenity_id"])
    for r in read(sql, "post_categories")[1]:
        if r["post_id"] not in posts:
            err.append("post_categories -> bài %s không tồn tại" % r["post_id"])
        if r["category_id"] not in blogcats:
            err.append("post_categories -> danh mục %s không tồn tại" % r["category_id"])
    for r in read(sql, "post_tags")[1]:
        if r["post_id"] not in posts or r["tag_id"] not in tags:
            err.append("post_tags %s/%s không hợp lệ" % (r["tag_id"], r["post_id"]))
    for r in read(sql, "faqs")[1]:
        if r["category_id"] not in faqcats:
            err.append("faqs %s -> danh mục %s không tồn tại" % (r["id"], r["category_id"]))
    for r in read(sql, "gallery_meta")[1]:
        if r["reference_id"] not in galleries:
            err.append("gallery_meta -> thư viện %s không tồn tại" % r["reference_id"])
    for r in read(sql, "role_users")[1]:
        if r["user_id"] not in users:
            err.append("role_users -> user %s không tồn tại" % r["user_id"])

    # slug trỏ đúng bản ghi
    universe = {
        "Botble\\\\Page\\\\Models\\\\Page": pages,
        "Botble\\\\Hotel\\\\Models\\\\Room": rooms,
        "Botble\\\\Hotel\\\\Models\\\\RoomCategory": cats,
        "Botble\\\\Hotel\\\\Models\\\\Service": services,
        "Botble\\\\Hotel\\\\Models\\\\Place": places,
        "Botble\\\\Gallery\\\\Models\\\\Gallery": galleries,
        "Botble\\\\Blog\\\\Models\\\\Post": posts,
        "Botble\\\\Blog\\\\Models\\\\Category": blogcats,
        "Botble\\\\Blog\\\\Models\\\\Tag": tags,
    }
    slug_ids = set()
    for r in read(sql, "slugs")[1]:
        pool = universe.get(r["reference_type"])
        if pool is None:
            err.append("slug %s: kiểu %s lạ" % (r["id"], r["reference_type"]))
        elif r["reference_id"] not in pool:
            err.append("slug '%s' -> %s #%s không tồn tại"
                       % (r["key"], r["reference_type"].split("\\\\")[-1], r["reference_id"]))
        slug_ids.add(r["id"])
    for r in read(sql, "slugs_translations")[1]:
        if r["slugs_id"] not in slug_ids:
            err.append("slugs_translations -> slug %s không tồn tại" % r["slugs_id"])

    # menu trỏ đúng trang
    menus = ids("menus")
    node_ids = {r["id"] for r in read(sql, "menu_nodes")[1]}
    for r in read(sql, "menu_nodes")[1]:
        if r["menu_id"] not in menus:
            err.append("menu_nodes %s -> menu %s không tồn tại" % (r["id"], r["menu_id"]))
        if r["parent_id"] != "0" and r["parent_id"] not in node_ids:
            err.append("menu_nodes %s -> parent %s không tồn tại" % (r["id"], r["parent_id"]))
        if r["reference_type"] and r["reference_id"] not in pages:
            err.append("menu_nodes %s -> trang %s không tồn tại" % (r["id"], r["reference_id"]))
    for r in read(sql, "menu_locations")[1]:
        if r["menu_id"] not in menus:
            err.append("menu_locations -> menu %s không tồn tại" % r["menu_id"])

    # bản dịch trỏ đúng bản gốc
    for table, col, pool, label in [
        ("pages_translations", "pages_id", pages, "trang"),
        ("posts_translations", "posts_id", posts, "bài viết"),
        ("ht_rooms_translations", "ht_rooms_id", rooms, "phòng"),
        ("ht_services_translations", "ht_services_id", services, "dịch vụ"),
        ("ht_places_translations", "ht_places_id", places, "địa điểm"),
        ("galleries_translations", "galleries_id", galleries, "thư viện"),
        ("categories_translations", "categories_id", blogcats, "danh mục"),
        ("ht_amenities_translations", "ht_amenities_id", amenities, "tiện nghi"),
        ("ht_room_categories_translations", "ht_room_categories_id", cats, "hạng phòng"),
    ]:
        for r in read(sql, table)[1]:
            if r[col] not in pool:
                err.append("%s -> %s %s không tồn tại" % (table, label, r[col]))

    # shortcode room_ids / category_ids trỏ đúng
    for r in read(sql, "pages")[1] + read(sql, "pages_translations")[1]:
        for m in re.finditer(r'room_ids=\\"([0-9,]+)\\"', r.get("content") or ""):
            for rid in m.group(1).split(","):
                if rid not in rooms:
                    err.append("trang %s: shortcode featured-rooms trỏ phòng %s không tồn tại"
                               % (r.get("id") or r.get("pages_id"), rid))
        for m in re.finditer(r'category_ids=\\"([0-9,]+)\\"', r.get("content") or ""):
            for cid in m.group(1).split(","):
                if cid not in faqcats:
                    err.append("trang %s: shortcode faqs trỏ danh mục %s không tồn tại"
                               % (r.get("id") or r.get("pages_id"), cid))

    # dấu vết Ruby còn sót
    ruby = sorted(set(re.findall(
        r"[^\n]{0,60}(?:[Rr]uby ?68|ruby68hotel|Võ Thị Sáu|Vo Thi Sau)[^\n]{0,60}", sql)))
    if ruby:
        err.append("Còn %d chỗ nhắc tới Ruby 68:" % len(ruby))
        err.extend("    " + x.strip() for x in ruby[:10])

    print("Bảng có dữ liệu: %d" % len(re.findall(r"^INSERT INTO", sql, re.M)))
    if err:
        print("VẤN ĐỀ (%d):" % len(err))
        for e in err[:60]:
            print("  -", e)
        return 1
    print("Dữ liệu nhất quán, không còn dấu vết Ruby 68.")
    return 0


if __name__ == "__main__":
    sys.exit(main())
