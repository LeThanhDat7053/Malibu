# -*- coding: utf-8 -*-
"""Phase B: hạng phòng, phòng, tiện nghi, đặc điểm nổi bật, slug."""
import json
import os

import lib
import rooms_data as R
from lib import row

NOW = "2026-09-04 08:00:00"
CRAWL = os.path.join(R.__file__.rsplit("build", 1)[0], "malibu_crawl", "rooms.json")

# --------------------------------------------------------------- ảnh phòng
# Web Malibu chỉ có đúng 1 ảnh cho Vice President và Presidential Suite.
ONLY_IMAGE = {
    "917": "/files/hotels/269_917/Asset_3@4x.png",
    "918": "/files/hotels/269_918/PRESIDENT.jpg",
}


def room_images():
    """map mã phòng trên web Malibu -> danh sách URL tuyệt đối."""
    out = {}
    for r in json.load(open(CRAWL, encoding="utf-8")):
        if r["id"] in ONLY_IMAGE:
            out[r["id"]] = [R.CDN + ONLY_IMAGE[r["id"]]]
        elif r["images"]:
            out[r["id"]] = [R.CDN + p for p in r["images"]]
    return out


IMAGES = room_images()

# --------------------------------------------------------------- tiện nghi
AMENITIES = [
    (1, "Điều hoà nhiệt độ", "Air Conditioning", "fal fa-snowflake"),
    (2, "Wi-Fi tốc độ cao miễn phí", "Complimentary High-speed Wi-Fi", "fal fa-wifi"),
    (3, "Két sắt an toàn", "In-room Safe", "fal fa-key"),
    (4, "Buffet sáng tại nhà hàng Vela", "Breakfast Buffet at Vela Restaurant", "fal fa-utensils"),
    (5, "TV màn hình phẳng truyền hình cáp", "Flat-screen TV with Cable Channels", "fal fa-tv"),
    (6, "Minibar", "Minibar", "fal fa-glass-martini"),
    (7, "Ấm đun nước, trà và cà phê", "Electric Kettle, Tea &amp; Coffee", "fal fa-mug-hot"),
    (8, "Phòng tắm vòi sen", "Shower", "fal fa-shower"),
    (9, "Bồn tắm", "Bathtub", "fal fa-bath"),
    (10, "Ban công riêng", "Private Balcony", "fal fa-door-open"),
    (11, "Máy sấy tóc", "Hair Dryer", "fal fa-wind"),
    (12, "Bàn làm việc", "Work Desk", "fal fa-laptop"),
    (13, "Dọn phòng hằng ngày", "Daily Housekeeping", "fal fa-broom"),
    (14, "Đồ dùng phòng tắm cao cấp", "Premium Bathroom Amenities", "fal fa-pump-soap"),
    (15, "Lễ tân hỗ trợ 24/7", "24/7 Front Desk Assistance", "fal fa-headphones-alt"),
    (16, "Tầm nhìn hướng biển", "Sea View", "fal fa-water"),
]

# --------------------------------------------------------------- điểm nổi bật
FEATURES = [
    (1, "flaticon-rating", 1,
     "Khách sạn 5 sao trung tâm Vũng Tàu",
     "Toà nhà 23 tầng với 197 phòng nghỉ, kiến trúc châu Âu hiện đại, "
     "toạ lạc ngay trung tâm thành phố biển Vũng Tàu.",
     "Five-star Hotel in Downtown Vung Tau",
     "A 23-storey tower with 197 guest rooms and modern European architecture, "
     "right in the heart of the coastal city of Vung Tau."),
    (2, "flaticon-location-pin", 1,
     "Mọi phòng đều hướng biển",
     "Tất cả phòng nghỉ tại Malibu đều có tầm nhìn hướng ra đại dương và "
     "một phần ôm trọn thành phố Vũng Tàu.",
     "Ocean Views from Every Room",
     "Every room at Malibu looks out over the ocean and embraces part of "
     "the Vung Tau cityscape."),
    (3, "flaticon-clock", 1,
     "6 tầng dịch vụ trọn vẹn",
     "Hồ bơi M Pool, M Spa, M Gym, Kid Zone, Gift Shop và khu giải trí "
     "phục vụ suốt kỳ nghỉ của bạn.",
     "Six Floors of Facilities",
     "M Pool, M Spa, M Gym, the Kid Zone, the Gift Shop and the entertainment "
     "area serve you throughout your stay."),
    (4, "flaticon-clock-1", 0,
     "Lễ tân và an ninh 24/7",
     "Đội ngũ lễ tân trực 24 giờ mỗi ngày cùng hệ thống an ninh giám sát "
     "liên tục toàn khuôn viên.",
     "24/7 Front Desk and Security",
     "Our front desk is staffed around the clock, with security monitoring "
     "the property continuously."),
    (5, "flaticon-credit-card", 0,
     "7 phòng hội nghị, sức chứa 450 khách",
     "Hệ thống phòng họp linh hoạt với âm thanh chuẩn quốc tế, màn hình LED "
     "và máy chiếu hiện đại.",
     "7 Conference Rooms for up to 450 Guests",
     "Flexible meeting spaces with international-standard sound systems, "
     "modern LED screens and projectors."),
    (6, "flaticon-discount", 0,
     "Ẩm thực Vela &amp; Carina",
     "Buffet sáng hơn 40 món tại Vela Restaurant và ẩm thực Á – Âu "
     "tại Carina Restaurant tầng 6.",
     "Dining at Vela &amp; Carina",
     "A breakfast buffet of more than 40 dishes at Vela Restaurant and "
     "Asian-European cuisine at Carina Restaurant on the 6th floor."),
]


# --------------------------------------------------------------- nội dung phòng
def content_vi(r):
    facilities = [
        "Diện tích %d m²" % r["size"],
        r["bed_vi"],
        r["view_vi"],
        "Tối đa %d người lớn và %d trẻ em" % (r["adults"], r["children"]),
    ]
    if r["bathtub"]:
        facilities.append("Bồn tắm riêng")
    items = "".join("<li>%s</li>" % f for f in facilities)
    return (
        '<div class="room-detail">'
        "<p>%s</p>"
        "<h3>Thông tin phòng</h3><ul>%s</ul>"
        "<h3>Tiện nghi tiêu chuẩn</h3>"
        "<p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, "
        "minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng "
        "phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p>"
        "<h3>Bao gồm trong giá phòng</h3>"
        "<p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời "
        "M Pool và phòng tập M Gym (tầng 6).</p>"
        "<h3>Liên hệ đặt phòng</h3>"
        "<p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; "
        "Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p>"
        "</div>" % (R.DESC_VI[r["id"]], items)
    )


def content_en(r):
    facilities = [
        "%d sqm" % r["size"],
        r["bed_en"],
        r["view_en"],
        "Up to %d adults and %d children" % (r["adults"], r["children"]),
    ]
    if r["bathtub"]:
        facilities.append("Private bathtub")
    items = "".join("<li>%s</li>" % f for f in facilities)
    return (
        '<div class="room-detail">'
        "<p>%s</p>"
        "<h3>Room information</h3><ul>%s</ul>"
        "<h3>Standard amenities</h3>"
        "<p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, "
        "minibar, electric kettle with tea and coffee, hair dryer, work desk and premium "
        "bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p>"
        "<h3>Included in the room rate</h3>"
        "<p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and "
        "access to the M Pool outdoor swimming pool and M Gym (6th floor).</p>"
        "<h3>Reservations</h3>"
        "<p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; "
        "Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p>"
        "</div>" % (R.DESC_EN[r["id"]], items)
    )


def amenity_ids(r):
    ids = list(R.BASE_AMENITIES)
    if r["bathtub"]:
        ids.append(R.BATHTUB_ID)
    ids.append(R.BALCONY_ID)
    if "biển" in r["view_vi"]:
        ids.append(R.SEAVIEW_ID)
    return sorted(set(ids))


def apply(sql):
    # ---- hạng phòng
    cats, cats_tr, slugs, slugs_tr = [], [], [], []
    for cid, vi, en, slug, order in R.CATEGORIES:
        cats.append(row(cid, vi, "published", NOW, NOW, order, 1))
        cats_tr.append(row("en_US", cid, en))
    sql = lib.replace(sql, "ht_room_categories", cats)
    sql = lib.replace(sql, "ht_room_categories_translations", cats_tr)
    sql = lib.autoinc(sql, "ht_room_categories", 9)

    # ---- phòng
    rooms, rooms_tr, links = [], [], []
    missing = []
    for r in R.ROOMS:
        imgs = IMAGES.get(r["src"], [])
        if not imgs:
            missing.append(r["name_vi"])
        rooms.append(row(
            r["id"], r["name_vi"], R.DESC_VI[r["id"]], content_vi(r), r["featured"],
            json.dumps(imgs, ensure_ascii=False), "[]", None, None,
            0, 3, r["rooms"], r["beds"], r["size"], r["adults"], r["children"],
            r["cat"], 1, "published", NOW, NOW, r["order"],
        ))
        rooms_tr.append(row(
            "en_US", r["id"], r["name_en"], R.DESC_EN[r["id"]], content_en(r), None,
        ))
        for aid in amenity_ids(r):
            links.append(row(aid, r["id"], None, None))
    sql = lib.replace(sql, "ht_rooms", rooms)
    sql = lib.replace(sql, "ht_rooms_translations", rooms_tr)
    sql = lib.replace(sql, "ht_rooms_amenities", links)
    sql = lib.autoinc(sql, "ht_rooms", len(R.ROOMS) + 1)

    # ---- tiện nghi
    am, am_tr = [], []
    for aid, vi, en, icon in AMENITIES:
        am.append(row(aid, vi, "", icon, "published", NOW, NOW))
        am_tr.append(row("en_US", aid, en, None))
    sql = lib.replace(sql, "ht_amenities", am)
    sql = lib.replace(sql, "ht_amenities_translations", am_tr)
    sql = lib.autoinc(sql, "ht_amenities", len(AMENITIES) + 1)

    # ---- điểm nổi bật
    fe, fe_tr = [], []
    for fid, icon, feat, nvi, dvi, nen, den in FEATURES:
        fe.append(row(fid, nvi, dvi, icon, feat, "published", NOW, NOW))
        fe_tr.append(row("en_US", fid, nen, den))
    sql = lib.replace(sql, "ht_features", fe)
    sql = lib.replace(sql, "ht_features_translations", fe_tr,
                      cols=["lang_code", "ht_features_id", "name", "description"])
    sql = lib.autoinc(sql, "ht_features", len(FEATURES) + 1)

    if missing:
        print("  ! chưa có ảnh:", ", ".join(missing))
    return sql, (slugs, slugs_tr)


if __name__ == "__main__":
    sql = lib.load(lib.DST)
    sql, _ = apply(sql)
    lib.save(sql)
    print("Phase B xong. Số phòng: %d, hạng: %d, tiện nghi: %d"
          % (len(R.ROOMS), len(R.CATEGORIES), len(AMENITIES)))
