# -*- coding: utf-8 -*-
"""Phase F: slug (VI + EN), liên kết ngôn ngữ, dọn bảng còn sót."""
import hashlib

import lib
import pages_data as P
import phase_d
import phase_e
import rooms_data as R
import services_data as S
from lib import row

NOW = "2026-09-04 08:00:00"

M = "Botble\\%s"
T_PAGE = M % "Page\\Models\\Page"
T_ROOM = M % "Hotel\\Models\\Room"
T_ROOMCAT = M % "Hotel\\Models\\RoomCategory"
T_SERVICE = M % "Hotel\\Models\\Service"
T_PLACE = M % "Hotel\\Models\\Place"
T_GALLERY = M % "Gallery\\Models\\Gallery"
T_POST = M % "Blog\\Models\\Post"
T_CAT = M % "Blog\\Models\\Category"
T_TAG = M % "Blog\\Models\\Tag"
T_MENU = M % "Menu\\Models\\Menu"
T_MENULOC = M % "Menu\\Models\\MenuLocation"
T_MENUNODE = M % "Menu\\Models\\MenuNode"


def ascii_slug(text):
    """Bỏ dấu tiếng Việt và chuyển thành slug."""
    table = str.maketrans(
        "àáảãạăằắẳẵặâầấẩẫậèéẻẽẹêềếểễệìíỉĩịòóỏõọôồốổỗộơờớởỡợ"
        "ùúủũụưừứửữựỳýỷỹỵđ",
        "a" * 17 + "e" * 11 + "i" * 5 + "o" * 17 + "u" * 11 + "y" * 5 + "d")
    s = text.lower().translate(table)
    out = []
    for ch in s:
        out.append(ch if ch.isalnum() else "-")
    slug = "".join(out)
    while "--" in slug:
        slug = slug.replace("--", "-")
    return slug.strip("-")


def origin(*parts):
    return hashlib.md5("|".join(str(p) for p in parts).encode()).hexdigest()


def collect():
    """[(reference_id, reference_type, prefix, key_vi, key_en)]"""
    items = []
    for pid, svi, sen, tpl, nvi, nen, dvi, den, cvi, cen, img in P.PAGES:
        items.append((pid, T_PAGE, "", svi, sen))
    for cid, vi, en, slug, order in R.CATEGORIES:
        items.append((cid, T_ROOMCAT, "room-categories", slug, slug))
    for r in R.ROOMS:
        items.append((r["id"], T_ROOM, "rooms", r["slug_vi"], r["slug_en"]))
    for s in S.SERVICES:
        items.append((s["id"], T_SERVICE, "services", s["slug_vi"], s["slug_en"]))
    for p in S.PLACES:
        items.append((p["id"], T_PLACE, "places", p["slug_vi"], p["slug_en"]))
    for gid, key, nvi, nen, dvi, den in S.GALLERIES:
        items.append((gid, T_GALLERY, "galleries", ascii_slug(nvi), ascii_slug(nen)))
    for cid, vi, en, dvi, den in phase_e.CATEGORIES:
        items.append((cid, T_CAT, "news", ascii_slug(vi), ascii_slug(en)))
    for tid, name in phase_e.TAGS:
        items.append((tid, T_TAG, "tag", ascii_slug(name), ascii_slug(name)))
    for p in phase_e.POSTS:
        items.append((p["id"], T_POST, "news", p["slug_vi"], p["slug_en"]))
    return items


def j(**kw):
    """JSON một dòng, escape unicode giống Botble lưu."""
    import json
    return json.dumps(kw, ensure_ascii=True)


def build_widgets():
    """Bộ widget sạch cho hai bản ngôn ngữ của theme riorelax."""
    rows, wid = [], 1
    contact_vi = j(id="ContactInformationMenuWidget",
                   phone_number=P.HOTLINE, email=P.EMAIL, address=P.ADDRESS_VI)
    contact_en = j(id="ContactInformationMenuWidget",
                   phone_number="(+84) 941 871 644", email=P.EMAIL,
                   address=P.ADDRESS_EN)
    plan = [
        ("riorelax", contact_vi, "Liên kết", "our-links", "Chính sách", "our-services",
         "Đăng ký nhận bản tin của chúng tôi", "Cần hỗ trợ? Liên hệ chúng tôi",
         "Form đặt phòng"),
        ("riorelax-en_US", contact_en, "Our Links", "link", "Policy", "policy",
         "Subscribe To Our Newsletter", "Need any help? Contact us",
         "Booking form"),
    ]
    blog = [("BlogSearchWidget", "Blog Search"), ("BlogSocialsWidget", "Blog Socials"),
            ("BlogCategoriesWidget", "Blog Categories"), (None, None),
            ("BlogTagsWidget", "Blog Tags")]
    for (theme, contact, n1, m1, n2, m2, news, help_title, book_title) in plan:
        for pos, data in enumerate([
            ("ContactInformationMenuWidget", contact),
            ("CustomMenuWidget", j(id="CustomMenuWidget", name=n1, menu_id=m1)),
            ("CustomMenuWidget", j(id="CustomMenuWidget", name=n2, menu_id=m2)),
            ("NewsletterWidget", j(id="NewsletterWidget", title=news)),
        ]):
            rows.append(row(wid, data[0], "footer_sidebar", theme, pos, data[1],
                            NOW, NOW))
            wid += 1
        for pos, (name, label) in enumerate(blog, start=1):
            if name is None:
                data = j(id="BlogPostsWidget", name="Blog Posts", type="recent", limit=5)
                name = "BlogPostsWidget"
            else:
                data = j(id=name, name=label)
            rows.append(row(wid, name, "blog_sidebar", theme, pos, data, NOW, NOW))
            wid += 1
        for sidebar in ("room_sidebar", "service_sidebar"):
            rows.append(row(wid, "RoomContactWidget", sidebar, theme, 0,
                            j(id="RoomContactWidget", title=help_title,
                              phone="0941871644"), NOW, NOW))
            wid += 1
        rows.append(row(wid, "CheckAvailabilityForm", "rooms_sidebar", theme, 0,
                        j(id="CheckAvailabilityForm", title=book_title), NOW, NOW))
        wid += 1
    return rows


def apply(sql):
    items = collect()
    slugs, slugs_tr = [], []
    seen_vi, seen_en, dupes = set(), set(), []
    for i, (ref, rtype, prefix, kvi, ken) in enumerate(items, start=1):
        for key, seen in ((kvi, seen_vi), (ken, seen_en)):
            if (prefix, key) in seen:
                dupes.append("%s/%s" % (prefix, key))
            seen.add((prefix, key))
        slugs.append(row(i, kvi, ref, rtype, prefix, NOW, NOW))
        slugs_tr.append(row("en_US", i, ken, prefix))
    sql = lib.replace(sql, "slugs", slugs)
    sql = lib.replace(sql, "slugs_translations", slugs_tr)
    sql = lib.autoinc(sql, "slugs", len(items) + 1)

    # ------------------------------------------------ liên kết ngôn ngữ
    meta = []
    mid = [1]

    def pair(vi_id, en_id, rtype, tag):
        o = origin(rtype, tag)
        for code, ref in (("vi", vi_id), ("en_US", en_id)):
            meta.append(row(mid[0], code, o, ref, rtype))
            mid[0] += 1

    for vi_menu, en_menu in ((1, 15), (2, 24), (3, 25)):
        pair(vi_menu, en_menu, T_MENU, "menu-%d" % vi_menu)

    nodes = phase_d.menu_nodes()
    by_menu = {}
    for n in nodes:
        by_menu.setdefault(n["menu"], []).append(n)
    for vi_menu, en_menu in ((1, 15), (2, 24), (3, 25)):
        vi_nodes, en_nodes = by_menu.get(vi_menu, []), by_menu.get(en_menu, [])
        for k, (a, b) in enumerate(zip(vi_nodes, en_nodes)):
            pair(a["id"], b["id"], T_MENUNODE, "node-%d-%d" % (vi_menu, k))

    locations = [row(1, 1, "main-menu", NOW, NOW), row(2, 15, "main-menu", NOW, NOW)]
    pair(1, 2, T_MENULOC, "loc-main")
    sql = lib.replace(sql, "menu_locations", locations)
    sql = lib.autoinc(sql, "menu_locations", 3)
    sql = lib.replace(sql, "language_meta", meta,
                      cols=["lang_meta_id", "lang_meta_code", "lang_meta_origin",
                            "reference_id", "reference_type"])
    sql = lib.autoinc(sql, "language_meta", len(meta) + 1)

    # ------------------------------------------------ widget chân trang / sidebar
    sql = lib.replace(sql, "widgets", build_widgets())
    sql = lib.autoinc(sql, "widgets", 100)

    # ------------------------------------------------ tên cơ sở dữ liệu
    sql = sql.replace("`travellink_ruby68hotel`", "`travellink_malibu`")

    # ------------------------------------------------ dọn phần còn lại
    for table in ("ht_foods", "ht_food_types", "ht_foods_translations",
                  "ht_food_types_translations", "ht_products",
                  "ht_products_translations", "ht_product_categories",
                  "ht_product_categories_translations"):
        sql = lib.replace(sql, table, [])
        sql = lib.autoinc(sql, table, 1)

    if dupes:
        print("  ! slug trùng:", ", ".join(sorted(set(dupes))))
    return sql


if __name__ == "__main__":
    lib.save(apply(lib.load(lib.DST)))
    print("Phase F xong: %d slug" % len(collect()))
