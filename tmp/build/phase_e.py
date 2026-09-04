# -*- coding: utf-8 -*-
"""Phase E: bài viết blog, danh mục, thẻ."""
import lib
import pages_data as P
import services_data as S
from lib import row
from phase_c import html

NOW = "2026-09-04 08:00:00"
USER = "Botble\\ACL\\Models\\User"

# id, tên VI, tên EN, mô tả VI, mô tả EN
CATEGORIES = [
    (1, "Ưu đãi", "Offers",
     "Các gói ưu đãi lưu trú và ẩm thực đang áp dụng tại The Malibu Hotel.",
     "Current stay and dining packages at The Malibu Hotel."),
    (2, "Tiện nghi", "Facilities",
     "M Pool, M Spa, M Gym và các tiện ích khác trong khách sạn.",
     "M Pool, M Spa, M Gym and the hotel's other facilities."),
    (3, "Ẩm thực", "Dining",
     "Nhà hàng Vela, Carina và The Lux Café.",
     "Vela and Carina restaurants and The Lux Café."),
    (4, "Hội nghị &amp; Sự kiện", "Meetings &amp; Events",
     "Hội nghị, hội thảo và tiệc tại The Malibu Hotel.",
     "Conferences, seminars and banquets at The Malibu Hotel."),
    (5, "Khám phá Vũng Tàu", "Explore Vung Tau",
     "Điểm đến và trải nghiệm quanh The Malibu Hotel.",
     "Destinations and experiences around The Malibu Hotel."),
]

TAGS = [
    (1, "Malibu Hotel"), (2, "Vũng Tàu"), (3, "Ưu đãi"),
    (4, "Ẩm thực"), (5, "Nghỉ dưỡng"),
]

# Bài lấy lại từ trang tiện ích của Malibu: (id dịch vụ, id danh mục, slug, tag ids)
FROM_SERVICES = [
    (1, 2, "m-pool-ho-boi-ngoai-troi", "m-pool-outdoor-pool", [1, 2, 5]),
    (2, 2, "m-spa-cham-soc-va-tri-lieu", "m-spa-health-care-and-treatment", [1, 5]),
    (3, 2, "m-gym-phong-tap-the-hinh", "m-gym-fitness-centre", [1, 5]),
    (4, 3, "vela-restaurant-buffet-sang", "vela-restaurant-breakfast-buffet", [1, 4]),
    (5, 3, "carina-restaurant-am-thuc-a-au", "carina-restaurant-fusion-cuisine", [1, 4]),
    (6, 3, "the-lux-cafe", "the-lux-cafe", [1, 4]),
    (7, 4, "conference-hoi-nghi-hoi-thao", "conference-meetings-and-seminars", [1, 2]),
    (8, 2, "kid-zone-khu-vui-choi-tre-em", "kid-zone-childrens-playground", [1, 5]),
    (9, 2, "entertainment-khu-giai-tri", "entertainment-area", [1, 5]),
    (10, 2, "billiard-foosball", "billiard-and-foosball", [1, 5]),
    (11, 2, "private-laundry-giat-ui-khep-kin", "private-laundry", [1]),
    (12, 2, "gift-shop-cua-hang-qua-tang", "gift-shop", [1, 2]),
]

# Hai gói ưu đãi lấy nguyên văn từ web Malibu
OFFERS = [
    dict(
        id=13, cat=1, tags=[1, 3, 4, 5], featured=1, pinned=1,
        slug_vi="gourmet-stay-package", slug_en="gourmet-stay-package",
        image=P.BLOG + "free_updrage.png",
        name_vi="Gourmet Stay Package – Nghỉ dưỡng kết hợp ẩm thực",
        name_en="Gourmet Stay Package",
        desc_vi="Từ 2.330.000++ VND/phòng: 01 đêm tại Premier Room, buffet sáng mỗi ngày, "
                "01 bữa trưa hoặc tối theo thực đơn chọn lọc, ưu đãi giặt ủi và M Spa.",
        desc_en="From 2,330,000++ VND/room: one night in a Premier Room, daily breakfast "
                "buffet, one set lunch or dinner, plus laundry and M Spa discounts.",
        body_vi=[
            ("", "Giữa nhịp sống bận rộn, đôi khi điều chúng ta cần không phải là một chuyến "
                 "đi dài, mà là một khoảng dừng đủ chất lượng – nơi mọi trải nghiệm đã được "
                 "chuẩn bị sẵn để bạn chỉ việc tận hưởng."),
            ("", "The Malibu Hotel giới thiệu <strong>Gourmet Stay Package</strong> – một "
                 "chương trình nghỉ dưỡng kết hợp ẩm thực, được thiết kế dành cho những ai "
                 "trân trọng sự tinh tế, tiện nghi và cảm giác trọn vẹn trong từng khoảnh "
                 "khắc lưu trú."),
            ("Từ 2.330.000++ VND/phòng, quý khách sẽ trải nghiệm", None),
            ("", "01 đêm nghỉ tại Premier Room sang trọng<br>"
                 "Buffet sáng mỗi ngày tại nhà hàng<br>"
                 "01 bữa ăn trưa hoặc tối theo thực đơn chọn lọc<br>"
                 "Ưu đãi 15% dịch vụ giặt ủi<br>"
                 "Ưu đãi 20% liệu trình M Spa"),
            ("Gói Fullboard – 2.859.000++ VND/phòng", None),
            ("", "Bao gồm 02 bữa ăn (trưa và tối), mang đến hành trình ẩm thực phong phú hơn."),
            ("", "Gourmet Stay Package là lựa chọn lý tưởng cho kỳ nghỉ cuối tuần, "
                 "staycation hay chuyến đi tái tạo năng lượng ngắn ngày."),
            ("Đặt gói", "Hotline: 0941 871 644 &nbsp;|&nbsp; Email: res@malibuhotel.com.vn"),
        ],
        body_en=[
            ("", "Amid the pace of modern life, true indulgence lies in a well-considered "
                 "pause – where every element is carefully arranged, allowing guests to "
                 "relax and enjoy without distraction."),
            ("", "The Malibu Hotel proudly presents the <strong>Gourmet Stay Package</strong>, "
                 "a stay-and-dine experience curated for guests who value refinement, "
                 "comfort and meaningful moments throughout their stay."),
            ("From 2,330,000++ VND/room, the package includes", None),
            ("", "One night in a refined Premier Room<br>"
                 "Daily breakfast buffet at the restaurant<br>"
                 "One set lunch or dinner<br>"
                 "15% off laundry service<br>"
                 "20% off M Spa treatments"),
            ("Fullboard package – 2,859,000++ VND/room", None),
            ("", "Includes two meals (lunch and dinner) for a richer culinary journey."),
            ("", "The Gourmet Stay Package is an ideal choice for a weekend break, "
                 "a staycation or a short restorative trip."),
            ("Reservations",
             "Hotline: (+84) 941 871 644 &nbsp;|&nbsp; Email: res@malibuhotel.com.vn"),
        ],
    ),
    dict(
        id=14, cat=1, tags=[1, 2, 3], featured=1, pinned=0,
        slug_vi="long-stay-uu-dai-luu-tru-dai-ngay",
        slug_en="long-stay-offers",
        image=P.BLOG + "LONG_STAY_HOTEL_2024_vuong-02.png",
        name_vi="Long Stay – Ưu đãi lưu trú dài ngày",
        name_en="Long Stay Offers",
        desc_vi="Từ 1.050.000 VNĐ++: phòng tiêu chuẩn kèm buffet sáng hơn 40 món, giảm 20% "
                "giặt ủi và nhà hàng, voucher F&amp;B 1.000.000 VNĐ.",
        desc_en="From 1,050,000 VND++: a standard room with a 40-dish breakfast buffet, "
                "20% off laundry and dining, plus a 1,000,000 VND F&amp;B voucher.",
        body_vi=[
            ("The Malibu Hotel – Điểm đến cho những chuyến công tác đầy phong cách", None),
            ("", "Bắt nhịp cùng xu hướng \"workcation\" với vị trí lý tưởng ngay trung tâm "
                 "thành phố Vũng Tàu, The Malibu Hotel mang đến cho bạn một chuyến công tác "
                 "đầy phong cách với nhiều trải nghiệm thú vị trong từng khoảnh khắc."),
            ("Ưu đãi Long Stay từ 1.050.000 VNĐ++", None),
            ("", "Phòng tiêu chuẩn kèm buffet sáng hơn 40 món<br>"
                 "Giảm 20% dịch vụ giặt ủi và dịch vụ nhà hàng<br>"
                 "Voucher F&amp;B trị giá 1.000.000 VNĐ<br>"
                 "Trà, cà phê và nước suối miễn phí mỗi ngày"),
            ("", "Đừng ngần ngại đặt phòng tại The Malibu Hotel – lựa chọn hoàn hảo cho "
                 "chuyến công tác của bạn."),
            ("Đặt phòng",
             "Hotline: 0941 871 644 &nbsp;|&nbsp; Tổng đài: (0254) 7305 779<br>"
             "263 Lê Hồng Phong, P. Thắng Tam, TP. Vũng Tàu"),
        ],
        body_en=[
            ("The Malibu Hotel – the stylish business trip destination", None),
            ("", "In tune with the trend of \"workcation\", and with an ideal location in "
                 "Vung Tau city, The Malibu Hotel brings you a stylish business trip with "
                 "many exciting experiences at every moment."),
            ("Long Stay offer from 1,050,000 VND++", None),
            ("", "Standard room with a breakfast buffet of over 40 dishes<br>"
                 "20% discount on laundry and restaurant services<br>"
                 "F&amp;B gift voucher worth 1,000,000 VND<br>"
                 "Daily complimentary tea, coffee and mineral water"),
            ("", "Do not hesitate to book at The Malibu Hotel, which promises to be the "
                 "perfect choice for your business trip."),
            ("Reservations",
             "Hotline: (+84) 941 871 644 &nbsp;|&nbsp; Main hotel: (0254) 7305 779<br>"
             "263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City"),
        ],
    ),
]


def build_posts():
    """Trả về (posts, translations, post_categories, post_tags, slug_specs)."""
    svc = {s["id"]: s for s in S.SERVICES}
    posts, tr, pc, pt, slugs = [], [], [], [], []
    for sid, cat, slug_vi, slug_en, tags in FROM_SERVICES:
        s = svc[sid]
        pid = sid
        posts.append(dict(
            id=pid, name_vi=s["name_vi"], name_en=s["name_en"],
            desc_vi=s["desc_vi"], desc_en=s["desc_en"],
            body_vi=html(s["body_vi"]), body_en=html(s["body_en"]),
            image=S.CDN + s["image"], cat=cat, tags=tags,
            featured=1 if sid in (1, 2, 4, 5) else 0, pinned=0,
            slug_vi=slug_vi, slug_en=slug_en,
        ))
    for o in OFFERS:
        posts.append(dict(
            id=o["id"], name_vi=o["name_vi"], name_en=o["name_en"],
            desc_vi=o["desc_vi"], desc_en=o["desc_en"],
            body_vi=html(o["body_vi"]), body_en=html(o["body_en"]),
            image=o["image"], cat=o["cat"], tags=o["tags"],
            featured=o["featured"], pinned=o["pinned"],
            slug_vi=o["slug_vi"], slug_en=o["slug_en"],
        ))
    return posts


POSTS = build_posts()


def apply(sql):
    sql = lib.replace(sql, "categories", [
        row(cid, vi, 0, dvi, "published", 1, USER, None, i, 1 if i < 3 else 0,
            1 if cid == 1 else 0, NOW, NOW)
        for i, (cid, vi, en, dvi, den) in enumerate(CATEGORIES)])
    sql = lib.replace(sql, "categories_translations", [
        row("en_US", cid, en, den) for cid, vi, en, dvi, den in CATEGORIES])
    sql = lib.autoinc(sql, "categories", len(CATEGORIES) + 1)

    sql = lib.replace(sql, "tags", [
        row(tid, name, 1, USER, None, "published", NOW, NOW) for tid, name in TAGS])
    sql = lib.replace(sql, "tags_translations", [
        row("en_US", tid, name, None) for tid, name in TAGS],
        cols=["lang_code", "tags_id", "name", "description"])
    sql = lib.autoinc(sql, "tags", len(TAGS) + 1)

    sql = lib.replace(sql, "posts", [
        row(p["id"], p["name_vi"], p["desc_vi"], p["body_vi"], "published",
            1, USER, p["featured"], p["pinned"], p["image"], 0, None, NOW, NOW)
        for p in POSTS])
    sql = lib.replace(sql, "posts_translations", [
        row("en_US", p["id"], p["name_en"], p["desc_en"], p["body_en"], None)
        for p in POSTS])
    sql = lib.replace(sql, "post_categories",
                      [row(p["cat"], p["id"]) for p in POSTS])
    sql = lib.replace(sql, "post_tags",
                      [row(t, p["id"]) for p in POSTS for t in p["tags"]],
                      cols=["tag_id", "post_id"])
    sql = lib.autoinc(sql, "posts", len(POSTS) + 1)
    return sql


if __name__ == "__main__":
    lib.save(apply(lib.load(lib.DST)))
    print("Phase E xong: %d bài viết, %d danh mục" % (len(POSTS), len(CATEGORIES)))
