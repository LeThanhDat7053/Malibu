# -*- coding: utf-8 -*-
"""Phase D: trang tĩnh, menu, slider, FAQ, widget."""
import lib
import pages_data as P
import rooms_data as R
import services_data as S
from lib import row

NOW = "2026-09-04 08:00:00"
PAGE = "Botble\\Page\\Models\\Page"

# --------------------------------------------------------------- slider
SLIDES = [
    ("MALIBU HOTEL VŨNG TÀU", "MALIBU HOTEL VUNG TAU",
     "Live Beautifully – 197 phòng nghỉ hướng biển giữa lòng thành phố",
     "Live Beautifully – 197 ocean-view rooms in the heart of the city",
     P.G1 + "DSC00316.jpg"),
    ("PHÒNG NGHỈ &amp; SUITE", "ROOMS &amp; SUITES",
     "Từ Premier 40 m² đến Presidential Suite 250 m²",
     "From the 40 sqm Premier to the 250 sqm Presidential Suite",
     P.CDN + "/files/sites/site_70/site_70_gallery_muc2/DSC05931-HDR.jpg"),
    ("M POOL", "M POOL",
     "Hồ bơi ngoài trời tầng 6 với tầm nhìn toàn cảnh Vũng Tàu",
     "The 6th-floor outdoor pool with panoramic views over Vung Tau",
     P.CDN + "/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-36.jpg"),
    ("HỘI NGHỊ &amp; SỰ KIỆN", "MEETINGS &amp; EVENTS",
     "7 phòng hội nghị, sức chứa tới 450 khách",
     "Seven conference rooms for up to 450 guests",
     P.G4 + "z7304583041023_6639f72ca0fe6cc33e22cbd47eedd674.jpg"),
]

# --------------------------------------------------------------- FAQ
FAQ_CATEGORIES = [
    (1, "Thông tin chung", "General Information"),
    (2, "Phòng nghỉ &amp; Tiện nghi", "Accommodations and Amenities"),
    (3, "Hội nghị &amp; Sự kiện", "Meetings and Events"),
    (4, "An toàn &amp; Sức khoẻ", "Safety and Health"),
    (5, "Khám phá Vũng Tàu", "Exploring Vung Tau"),
]

FAQS = [
    (1, 1,
     "The Malibu Hotel nằm ở đâu?",
     "Khách sạn toạ lạc tại 263 Lê Hồng Phong, P. Thắng Tam, TP. Vũng Tàu – ngay trung tâm "
     "thành phố và chỉ vài phút đi bộ tới bãi biển Bãi Sau.",
     "Where is The Malibu Hotel located?",
     "The hotel is at 263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City – in the "
     "centre of the city and a few minutes' walk from Back Beach."),
    (2, 1,
     "Khách sạn có bao nhiêu phòng?",
     "The Malibu Hotel có 197 phòng nghỉ trong toà nhà 23 tầng, chia thành 4 hạng: "
     "Premier, Diamond, Suite và President.",
     "How many rooms does the hotel have?",
     "The Malibu Hotel has 197 guest rooms in a 23-storey tower, across four categories: "
     "Premier, Diamond, Suite and President."),
    (3, 1,
     "Giờ nhận và trả phòng là mấy giờ?",
     "Nhận phòng từ 14:00 và trả phòng trước 12:00. Nhận phòng sớm hoặc trả phòng muộn "
     "tuỳ thuộc tình trạng phòng trống và có thể phát sinh phụ thu.",
     "What are the check-in and check-out times?",
     "Check-in is from 14:00 and check-out is before 12:00. Early check-in and late "
     "check-out are subject to availability and may incur a surcharge."),
    (4, 1,
     "Khách sạn có nhận thú cưng không?",
     "Để bảo đảm tiêu chuẩn vệ sinh và sự thoải mái cho tất cả khách lưu trú, khách sạn "
     "không nhận thú cưng.",
     "Are pets allowed at the hotel?",
     "To maintain hygiene standards and the comfort of all guests, pets are not permitted "
     "at the hotel."),
    (5, 1,
     "Khách sạn có bãi đỗ xe không?",
     "Có. Khách sạn có 2 tầng hầm đỗ xe dành cho khách lưu trú, có bảo vệ trực 24/7.",
     "Is there parking at the hotel?",
     "Yes. The hotel has two basement parking levels for guests, with security on duty 24/7."),
    (6, 2,
     "Giá phòng đã bao gồm bữa sáng chưa?",
     "Giá phòng bao gồm buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), cùng quyền sử "
     "dụng hồ bơi M Pool và phòng tập M Gym.",
     "Is breakfast included in the room rate?",
     "Room rates include a breakfast buffet of more than 40 dishes at Vela Restaurant "
     "(3rd floor), plus access to the M Pool and M Gym."),
    (7, 2,
     "Phòng nào có bồn tắm?",
     "Các hạng Diamond, Suite và President đều có bồn tắm riêng. Hạng Premier sử dụng "
     "phòng tắm vòi sen.",
     "Which rooms have a bathtub?",
     "The Diamond, Suite and President categories all have a private bathtub. Premier "
     "rooms have a shower."),
    (8, 2,
     "Khách sạn có Wi-Fi miễn phí không?",
     "Có. Internet tốc độ cao được cung cấp miễn phí trong phòng và toàn bộ khu vực "
     "công cộng của khách sạn.",
     "Is Wi-Fi free?",
     "Yes. Complimentary high-speed internet is available in all rooms and throughout the "
     "public areas of the hotel."),
    (9, 2,
     "Hồ bơi và phòng gym mở cửa giờ nào?",
     "M Pool mở cửa 07:00 – 19:00 hằng ngày. M Gym mở cửa 06:00 – 22:00. M Spa phục vụ "
     "từ 10:00 đến 20:00.",
     "What are the pool and gym hours?",
     "M Pool is open 7:00 am – 7:00 pm daily, M Gym 6:00 am – 10:00 pm, and M Spa serves "
     "from 10:00 am to 8:00 pm."),
    (10, 3,
     "Khách sạn có bao nhiêu phòng hội nghị?",
     "Khách sạn có 7 phòng hội nghị với sức chứa lên đến 450 khách. Phòng Malibu Grand "
     "có thể ngăn thành 3 phòng nhỏ, mỗi phòng 120 khách.",
     "How many conference rooms are there?",
     "The hotel has seven conference rooms for up to 450 guests. The Malibu Grand room "
     "can be divided into three rooms of 120 guests each."),
    (11, 3,
     "Khách sạn có tổ chức tiệc cưới không?",
     "Có. Malibu phục vụ tiệc cưới từ 50 đến 450 khách, hỗ trợ trọn gói từ thực đơn, "
     "trang trí đến âm thanh ánh sáng. Liên hệ dos@malibuhotel.com.vn để nhận báo giá.",
     "Do you host weddings?",
     "Yes. Malibu hosts weddings from 50 to 450 guests with full support for menus, "
     "decoration, sound and lighting. Contact dos@malibuhotel.com.vn for a proposal."),
    (12, 4,
     "Khách sạn có an ninh 24/7 không?",
     "Có. Khách sạn duy trì lễ tân và an ninh trực 24/7, hệ thống camera giám sát và "
     "két sắt trong từng phòng để quý khách bảo quản tài sản có giá trị.",
     "Is there 24/7 security?",
     "Yes. The hotel maintains a 24/7 front desk and security team, CCTV coverage and an "
     "in-room safe in every room for your valuables."),
    (13, 4,
     "Dịch vụ giặt ủi được xử lý như thế nào?",
     "Khách sạn vận hành xưởng giặt khép kín của riêng mình, không dùng dịch vụ bên thứ "
     "ba. Toàn bộ đồ vải được phân loại, giặt, tiệt trùng và hấp kỹ lưỡng, phục vụ 24/24.",
     "How is laundry handled?",
     "The hotel runs its own fully closed-cycle laundry without any third-party service. "
     "All fabrics are sorted, washed, pasteurised and steamed thoroughly, available 24/7."),
    (14, 5,
     "Từ khách sạn tới bãi biển bao xa?",
     "Bãi Sau (Thuỳ Vân) chỉ cách khách sạn khoảng 450 m, tương đương 6 phút đi bộ.",
     "How far is the beach?",
     "Back Beach (Thuy Van) is about 450 m from the hotel, roughly a 6-minute walk."),
    (15, 5,
     "Gần khách sạn có những điểm tham quan nào?",
     "Tượng Chúa Kitô Vua, Ngọn Hải Đăng Vũng Tàu, Bạch Dinh, khu du lịch Hồ Mây và chợ "
     "hải sản Xóm Lưới đều nằm trong bán kính 5 km từ khách sạn.",
     "What attractions are nearby?",
     "The Christ the King statue, Vung Tau Lighthouse, Bach Dinh, Ho May Park and the "
     "Xom Luoi seafood market are all within 5 km of the hotel."),
]


def menu_nodes():
    """Sinh menu chính (VI id 1, EN id 15) và menu chân trang."""
    nodes = []
    nid = [1]

    def add(menu, parent, title, url, ref=None, pos=0, icon=""):
        i = nid[0]
        nid[0] += 1
        nodes.append(dict(id=i, menu=menu, parent=parent, ref=ref, title=title,
                          url=url, pos=pos, icon=icon))
        return i

    for menu, pre, T in ((1, "", "vi"), (15, "/en", "en")):
        L = (lambda vi, en: vi if T == "vi" else en)
        add(menu, 0, L("Trang chủ", "Home"), "", ref=1, pos=0, icon="fa fa-home")
        rooms = add(menu, 0, L("Phòng nghỉ", "Rooms"), pre + "/rooms", pos=1)
        for ci, (cid, cvi, cen, cslug, corder) in enumerate(R.CATEGORIES):
            cat = add(menu, rooms, L(cvi, cen),
                      "%s/room-categories/%s" % (pre, cslug), pos=ci)
            kids = [r for r in R.ROOMS if r["cat"] == cid]
            for ri, r in enumerate(kids):
                add(menu, cat, L(r["name_vi"], r["name_en"]),
                    "%s/rooms/%s" % (pre, r["slug_vi"] if T == "vi" else r["slug_en"]),
                    pos=ri)
        svc = add(menu, 0, L("Tiện nghi &amp; Dịch vụ", "Facilities"), pre + "/tien-nghi-dich-vu",
                  ref=6, pos=2)
        for si, s in enumerate(S.SERVICES[:6]):
            add(menu, svc, L(s["name_vi"], s["name_en"]),
                "%s/services/%s" % (pre, s["slug_vi"] if T == "vi" else s["slug_en"]),
                pos=si)
        add(menu, 0, L("Ẩm thực", "Dine"), pre + "/am-thuc", ref=9, pos=3)
        add(menu, 0, L("Hội nghị &amp; Sự kiện", "Meetings &amp; Events"),
            pre + "/hoi-nghi-su-kien", ref=18, pos=4)
        add(menu, 0, L("Thư viện ảnh", "Gallery"), pre + "/thu-vien-anh", ref=7, pos=5)
        add(menu, 0, L("Tin tức", "News"), pre + "/tin-tuc", ref=10, pos=6)
        add(menu, 0, L("Liên hệ", "Contact"), pre + "/lien-he", ref=11, pos=7)

    # chân trang: liên kết
    for menu, pre, T in ((2, "", "vi"), (24, "/en", "en")):
        L = (lambda vi, en: vi if T == "vi" else en)
        for i, (vi, en, url, ref) in enumerate([
            ("Về chúng tôi", "About Us", "/ve-chung-toi", 5),
            ("Malibu Group", "Malibu Group", "/malibu-group", 19),
            ("Tuyển dụng", "Careers", "/tuyen-dung", 22),
            ("Câu hỏi thường gặp", "Hotel FAQs", "/cau-hoi-thuong-gap", 8),
            ("Liên hệ", "Contact", "/lien-he", 11),
        ]):
            add(menu, 0, L(vi, en), pre + url, ref=ref, pos=i)

    # chân trang: chính sách
    for menu, pre, T in ((3, "", "vi"), (25, "/en", "en")):
        L = (lambda vi, en: vi if T == "vi" else en)
        for i, (vi, en, url, ref) in enumerate([
            ("Chính sách bảo mật", "Privacy Policy", "/chinh-sach-bao-mat", 12),
            ("Điều khoản và điều kiện", "Terms and Conditions",
             "/dieu-khoan-va-dieu-kien", 13),
        ]):
            add(menu, 0, L(vi, en), pre + url, ref=ref, pos=i)
    return nodes


MENUS = [
    (1, "Main menu", "main-menu"),
    (2, "Liên kết", "our-links"),
    (3, "Chính sách", "our-services"),
    (15, "Main menu EN", "main-menu-en"),
    (24, "Our Links", "link"),
    (25, "Policy", "policy"),
]


def apply(sql):
    # ------------------------------------------------ trang tĩnh
    pages, pages_tr = [], []
    for (pid, svi, sen, tpl, nvi, nen, dvi, den, cvi, cen, img) in P.PAGES:
        pages.append(row(pid, nvi, cvi, "blocks", None, 1, img, tpl, dvi,
                         "published", NOW, NOW))
        pages_tr.append(row("en_US", pid, nen, den, cen, "blocks", None))
    sql = lib.replace(sql, "pages", pages)
    sql = lib.replace(sql, "pages_translations", pages_tr)
    sql = lib.autoinc(sql, "pages", max(p[0] for p in P.PAGES) + 1)
    sql = lib.replace(sql, "meta_boxes", [])
    sql = lib.autoinc(sql, "meta_boxes", 1)

    # ------------------------------------------------ menu
    sql = lib.replace(sql, "menus",
                      [row(i, n, s, "published", NOW, NOW) for i, n, s in MENUS])
    sql = lib.autoinc(sql, "menus", max(m[0] for m in MENUS) + 1)
    nodes = menu_nodes()
    has_child = {n["parent"] for n in nodes}
    sql = lib.replace(sql, "menu_nodes", [
        row(n["id"], n["menu"], n["parent"], n["ref"] or 0,
            PAGE if n["ref"] else None, n["url"], n["icon"], n["pos"], n["title"],
            "", "_self", 1 if n["id"] in has_child else 0, NOW, NOW)
        for n in nodes])
    sql = lib.autoinc(sql, "menu_nodes", len(nodes) + 1)

    # ------------------------------------------------ slider
    sql = lib.replace(sql, "simple_sliders", [
        row(3, "Home slider", "home-slider-vn", "", "published", NOW, NOW),
        row(4, "Trang bìa", "TRANG BÌA", "", "published", NOW, NOW),
    ])
    sql = lib.replace(sql, "simple_sliders_translations", [
        row("en_US", 3, "Home slider", ""),
        row("en_US", 4, "Cover slider", ""),
    ])
    items, items_tr = [], []
    iid = 1
    for sid in (3, 4):
        for order, (tvi, ten, dvi, den, img) in enumerate(SLIDES):
            items.append(row(iid, sid, tvi, img, "", dvi, order, NOW, NOW))
            items_tr.append(row("en_US", iid, ten, "", den))
            iid += 1
    sql = lib.replace(sql, "simple_slider_items", items)
    sql = lib.replace(sql, "simple_slider_items_translations", items_tr)
    sql = lib.autoinc(sql, "simple_slider_items", iid)
    sql = lib.autoinc(sql, "simple_sliders", 5)

    # ------------------------------------------------ FAQ
    sql = lib.replace(sql, "faq_categories", [
        row(cid, vi, i, "published", NOW, NOW, None)
        for i, (cid, vi, en) in enumerate(FAQ_CATEGORIES)])
    sql = lib.replace(sql, "faq_categories_translations", [
        row("en_US", cid, en) for cid, vi, en in FAQ_CATEGORIES])
    sql = lib.replace(sql, "faqs", [
        row(fid, qvi, avi, cid, "published", NOW, NOW)
        for fid, cid, qvi, avi, qen, aen in FAQS])
    sql = lib.replace(sql, "faqs_translations", [
        row("en_US", fid, qen, aen)
        for fid, cid, qvi, avi, qen, aen in FAQS])
    sql = lib.autoinc(sql, "faqs", len(FAQS) + 1)
    sql = lib.autoinc(sql, "faq_categories", len(FAQ_CATEGORIES) + 1)

    # ------------------------------------------------ widget: số điện thoại
    sql = sql.replace('\\"phone\\":\\"917052101786\\"', '\\"phone\\":\\"0941871644\\"')
    sql = sql.replace(
        '\\"title\\":\\"If You Need Any Help Contact Us\\"',
        '\\"title\\":\\"C\\\\u1ea7n h\\\\u1ed7 tr\\\\u1ee3? Li\\\\u00ean h\\\\u1ec7 ch\\\\u00fang t\\\\u00f4i\\"')
    return sql


if __name__ == "__main__":
    lib.save(apply(lib.load(lib.DST)))
    print("Phase D xong: %d trang, %d node menu, %d FAQ"
          % (len(P.PAGES), len(menu_nodes()), len(FAQS)))
