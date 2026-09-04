# -*- coding: utf-8 -*-
"""Phase G: ảnh banner (meta_boxes + theme options), icon tiện nghi,
và trang chi tiết 3 điểm ẩm thực."""
import json

import dining_data as D
import lib
import services_data as S
from lib import row
from phase_a import unescape

NOW = "2026-09-04 08:00:00"
PAGE = "Botble\\Page\\Models\\Page"
AMENITY = "Botble\\Hotel\\Models\\Amenity"

# Ảnh banner. LƯU Ý: bộ ảnh site_70_header/*.jpg trên web Malibu chỉ là
# thumbnail 300x200 (~12 KB) nên vỡ khi phóng lên nền breadcrumb rộng.
# Các đường dẫn dưới đây đã đo thật, rộng 1000-2560px, nặng 160-800 KB.
CDN = "https://malibuhotel.com.vn"
LAND = CDN + "/files/sites/site_70/site_70_gallery_muc1/"
ROOM = CDN + "/files/sites/site_70/site_70_gallery_muc2/"
REST = CDN + "/files/sites/site_70/site_70_gallery_muc3/"
MEET = CDN + "/files/sites/site_70/site_70_gallery_muc4/"

EXTERIOR = LAND + "MALIBU-HOTEL1.jpg"                 # 1000x668  – mặt tiền khách sạn
EXTERIOR2 = LAND + "MALIBU-HOTEL2.jpg"                # 1000x800
LANDSCAPE = LAND + "M-POOL-MALIBU-HOTEL-159.jpg"      # 1000x667
LOBBY = LAND + "M-POOL-MALIBU-HOTEL-160.jpg"          # 1000x749
RESTAURANT = REST + "M-POOL-MALIBU-HOTEL-70.jpg"      # 1000x632
EVENTS = MEET + "M-POOL-MALIBU-HOTEL-04.jpg"          # 1000x563 (16:9)
EVENTS2 = MEET + "M-POOL-MALIBU-HOTEL-19.jpg"         # 1000x563 (16:9)
BALLROOM = CDN + "/files/sites/70/meeting-3.jpg"      # 2560x1707 – phòng hội nghị
FACILITIES = CDN + "/files/blog/46_1815/ENTERTAINMENT.jpg"   # 2048x1366
CONTACT = (CDN + "/files/sites/70/"
           "346498570_1304832573402425_3861313240524634359_n.jpg")  # 1440x960
BEDROOM = ROOM + "DSC05931-HDR.jpg"                   # 1000x667

# Theme lấy ảnh này qua $page->getMetaData('breadcrumb_background')
# trong views/page.blade.php:4 -> lưu ở meta_boxes, KHÔNG phải cột pages.image.
PAGE_BANNER = {
    1: None,              # trang chủ không hiện breadcrumb
    5: EXTERIOR,          # Về chúng tôi
    6: FACILITIES,        # Tiện nghi & Dịch vụ
    7: LANDSCAPE,         # Thư viện ảnh
    8: LOBBY,             # Câu hỏi thường gặp
    9: RESTAURANT,        # Ẩm thực
    10: EVENTS,           # Tin tức
    11: CONTACT,          # Liên hệ
    12: EXTERIOR2,        # Chính sách bảo mật
    13: EXTERIOR2,        # Điều khoản
    18: BALLROOM,         # Hội nghị & Sự kiện
    19: EXTERIOR,         # Malibu Group
    22: EVENTS2,          # Tuyển dụng
}

# Ảnh đại diện của trang (cột pages.image) – dùng ở danh sách và thẻ chia sẻ
PAGE_IMAGE = dict(PAGE_BANNER)
PAGE_IMAGE[1] = EXTERIOR

# Ảnh banner mặc định theo loại trang (theme option)
THEME_BANNERS = {
    "breadcrumb_background_image": EXTERIOR,
    "breadcrumb_background_image_room": BEDROOM,
    "breadcrumb_background_image_gallery": LANDSCAPE,
    "breadcrumb_background_image_blog": EVENTS,
    "breadcrumb_background_image_product": RESTAURANT,
}

# icon cho ht_amenities (id -> tên icon mdi trên iconify)
AMENITY_ICONS = {
    1: "air-conditioner", 2: "wifi", 3: "safe", 4: "food-croissant",
    5: "television", 6: "fridge", 7: "kettle", 8: "shower",
    9: "bathtub", 10: "balcony", 11: "hair-dryer", 12: "desk",
    13: "broom", 14: "spray-bottle", 15: "headset", 16: "waves",
}
ICON_URL = ("https://api.iconify.design/mdi/%s.svg?width=64&color=%%23E4762C")


def meta_rows():
    """Sinh các bản ghi meta_boxes cần thiết."""
    rows, mid = [], 1
    for pid, image in sorted(PAGE_BANNER.items()):
        # breadcrumb: 0 = ẩn (trang chủ), 1 = hiện
        show = "0" if pid == 1 else "1"
        rows.append((mid, "breadcrumb", json.dumps([show]), pid, PAGE))
        mid += 1
        if image:
            rows.append((mid, "breadcrumb_background",
                         json.dumps([image]), pid, PAGE))
            mid += 1
    for aid, icon in sorted(AMENITY_ICONS.items()):
        rows.append((mid, "icon_image", json.dumps([ICON_URL % icon]),
                     aid, AMENITY))
        mid += 1
    return rows


def theme_option_rows():
    """(key, value) cho cả bản tiếng Việt và tiếng Anh của theme."""
    out = []
    for key, image in THEME_BANNERS.items():
        out.append(("theme-riorelax-" + key, image))
        out.append(("theme-riorelax-en_US-" + key, image))
    return out


def dining_rows():
    """Nội dung mới cho 3 dịch vụ ẩm thực: (id, content_vi, content_en)."""
    return [(sid, vi, en) for sid, (vi, en) in sorted(D.CONTENT.items())]


def apply(sql):
    sql = lib.replace(sql, "meta_boxes", [
        row(mid, key, value, ref, rtype, NOW, NOW)
        for mid, key, value, ref, rtype in meta_rows()])
    sql = lib.autoinc(sql, "meta_boxes", len(meta_rows()) + 1)

    # cập nhật giá trị theme option trong bảng settings
    updates = dict(theme_option_rows())
    import re
    m = re.search(lib.INSERT_RE % "settings", sql)
    rows_out, seen = [], set()
    pattern = r"\((\d+), '((?:[^'\\]|\\.)*)', (NULL|'(?:[^'\\]|\\.)*'),"
    for rid, key, val in re.findall(pattern, m.group("body")):
        seen.add(key)
        v = updates[key] if key in updates else (
            None if val == "NULL" else unescape(val[1:-1]))
        rows_out.append((int(rid), key, v))
    nid = max(r[0] for r in rows_out) + 1
    for key, v in updates.items():
        if key not in seen:
            rows_out.append((nid, key, v))
            nid += 1
    sql = lib.replace(sql, "settings",
                      [row(i, k, v, None, NOW) for i, k, v in rows_out])
    sql = lib.autoinc(sql, "settings", nid)

    # ảnh đại diện của trang: thay thumbnail 300x200 bằng ảnh độ phân giải cao.
    # check_data.read trả về chuỗi vẫn còn escape -> phải giải escape trước khi
    # quote lại, nếu không sẽ escape hai lần.
    from check_data import read as _read
    u = lambda v: None if v is None else unescape(v)
    pages = []
    for r in _read(sql, "pages")[1]:
        pid = int(r["id"])
        pages.append(row(
            pid, u(r["name"]), u(r["content"]), u(r["content_mode"]),
            u(r["custom_html"]), int(r["user_id"]), PAGE_IMAGE.get(pid),
            u(r["template"]), u(r["description"]), u(r["status"]),
            u(r["created_at"]), NOW))
    sql = lib.replace(sql, "pages", pages)

    # nội dung chi tiết 3 điểm ẩm thực
    from phase_c import html
    services, services_tr = [], []
    for s in S.SERVICES:
        override = D.CONTENT.get(s["id"])
        content_vi = override[0] if override else html(s["body_vi"])
        content_en = override[1] if override else html(s["body_en"])
        services.append(row(
            s["id"], s["name_vi"], s["desc_vi"], content_vi,
            0, "contact", None, S.CDN + s["image"], None,
            "published", NOW, NOW))
        services_tr.append(row(
            "en_US", s["id"], s["name_en"], s["desc_en"], content_en, None))
    sql = lib.replace(sql, "ht_services", services)
    sql = lib.replace(sql, "ht_services_translations", services_tr)
    return sql


if __name__ == "__main__":
    lib.save(apply(lib.load(lib.DST)))
    print("Phase G xong: %d meta_boxes, %d theme option, %d trang ẩm thực"
          % (len(meta_rows()), len(theme_option_rows()), len(dining_rows())))
