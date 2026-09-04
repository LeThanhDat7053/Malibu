# -*- coding: utf-8 -*-
"""Nội dung HTML chi tiết cho 3 điểm ẩm thực của The Malibu Hotel.

Ràng buộc: nội dung đi qua HTMLPurifier của Botble (BaseHelper::clean).
- Thẻ và thuộc tính `class` được giữ nguyên -> dùng được class Bootstrap của theme.
- Theme dùng Bootstrap 5.0.2: KHÔNG có `fw-semibold` (5.1+).
- CSS inline chỉ còn các thuộc tính trong danh sách cho phép:
  color, background-color, border, padding*, margin*, font-*, text-align,
  width, height, max-width, line-height, list-style, text-decoration.
  Bị loại bỏ: display, flex, gap, border-radius, box-shadow, background-image.
  -> Bo góc/đổ bóng/flex phải dùng class Bootstrap (rounded-3, shadow-sm, d-flex).
"""

CDN = "https://malibuhotel.com.vn"
BLOG = CDN + "/files/blog/46_1815/"
G3 = CDN + "/files/sites/site_70/site_70_gallery_muc3/"

ORANGE = "#e4762c"
NAVY = "#16192c"
CREAM = "#faf7f2"


def hero(image, eyebrow, title, tagline):
    return (
        '<div class="mb-5">'
        '<img src="%s" alt="%s" class="img-fluid rounded-3 w-100 mb-4">'
        '<p class="text-uppercase mb-1" style="color:%s;'
        'font-size:13px">%s</p>'
        '<h2 class="text-uppercase fw-bold mb-2" style="color:%s">%s</h2>'
        '<p class="lead mb-0" style="color:#6b7280">%s</p>'
        "</div>" % (image, title, ORANGE, eyebrow, NAVY, title, tagline)
    )


def facts(rows):
    """Bảng thông số: [(nhãn, giá trị)] -> lưới 2 cột."""
    cells = []
    for label, value in rows:
        cells.append(
            '<div class="col-md-6">'
            '<div class="p-4 rounded-3 h-100" style="background-color:%s;'
            'border:1px solid #ece4d8">'
            '<p class="text-uppercase mb-1" style="color:%s;'
            'font-size:12px">%s</p>'
            '<p class="mb-0 fw-bold" style="color:%s;font-size:17px">%s</p>'
            "</div></div>" % (CREAM, ORANGE, label, NAVY, value)
        )
    return '<div class="row g-3 mb-5">%s</div>' % "".join(cells)


def prose(paragraphs):
    return "".join(
        '<p class="mb-3" style="line-height:1.9;color:#4b5563">%s</p>' % p
        for p in paragraphs
    )


def heading(text):
    return ('<h3 class="text-uppercase fw-bold mb-3 mt-5" '
            'style="color:%s;font-size:20px">%s</h3>' % (NAVY, text))


def highlights(title, items):
    lis = "".join(
        '<li class="mb-2" style="line-height:1.8;color:#4b5563">%s</li>' % i
        for i in items)
    return (
        '<div class="p-4 rounded-3 mb-5 border-start border-4" '
        'style="background-color:%s;border-color:%s">'
        '<p class="text-uppercase fw-bold mb-3" style="color:%s;'
        'font-size:13px">%s</p>'
        '<ul class="mb-0" style="padding-left:18px">%s</ul>'
        "</div>" % (CREAM, ORANGE, NAVY, title, lis)
    )


def gallery(images):
    cols = "".join(
        '<div class="col-6 col-md-4">'
        '<img src="%s" alt="" class="img-fluid rounded-3 w-100"></div>' % i
        for i in images)
    return '<div class="row g-3 mb-5">%s</div>' % cols


def cta(title, note, label_phone, phone, tel, email):
    return (
        '<div class="p-4 p-md-5 rounded-3 text-center" '
        'style="background-color:%s">'
        '<h3 class="text-uppercase fw-bold text-white mb-2" '
        'style="font-size:20px">%s</h3>'
        '<p class="mb-4" style="color:#b9bdc9">%s</p>'
        '<p class="mb-2 text-white" style="font-size:18px">%s '
        '<a href="tel:%s" style="color:%s;text-decoration:none">'
        '<strong>%s</strong></a></p>'
        '<p class="mb-0"><a href="mailto:%s" '
        'style="color:#b9bdc9;text-decoration:underline">%s</a></p>'
        "</div>" % (NAVY, title, note, label_phone, tel, ORANGE, phone,
                    email, email)
    )


# --------------------------------------------------------------------------
VELA_VI = "".join([
    hero(BLOG + "Anh_1_4_1.jpg", "Tầng 3", "Vela Restaurant",
         "Buffet sáng hơn 40 món Á – Âu, sức chứa 350 khách"),
    facts([
        ("Vị trí", "Tầng 3, The Malibu Hotel"),
        ("Sức chứa", "350 khách"),
        ("Buffet sáng", "06:30 – 10:00 hằng ngày"),
        ("Tiệc &amp; à la carte", "11:00 – 22:00"),
    ]),
    prose([
        "Một sáng thức dậy tại Malibu, nghe bản nhạc du dương, nhấp ngụm cà phê và "
        "dùng bữa sáng tại nhà hàng Vela với hơn 40 món buffet trải từ Á sang Âu – "
        "trước khi bắt đầu ngày mới đầy hứng khởi cho chuyến công tác, hay một ngày "
        "rong chơi ở thành phố biển.",
        "Đội ngũ ẩm thực của khách sạn chăm chút từng món ăn, từ khâu chọn nguyên liệu "
        "tươi ngon đến chế biến – cho một bữa sáng tràn năng lượng, một bữa trưa nhẹ "
        "nhàng, hay những món đặc biệt dành cho đêm Gala ấn tượng.",
    ]),
    heading("Không gian"),
    prose([
        "Nhà hàng được thiết kế rộng rãi theo phong cách hiện đại, trải thảm cao cấp, "
        "sức chứa lên đến 350 khách. Vela phục vụ cả ba hình thức: gọi món à la carte, "
        "buffet và tiệc Gala – phù hợp cho bữa sáng của khách lưu trú lẫn tiệc công ty "
        "quy mô lớn.",
    ]),
    highlights("Điểm nổi bật", [
        "Hơn 40 món buffet sáng, luân phiên món Á và món Âu mỗi ngày",
        "Sức chứa 350 khách – lớn nhất trong các nhà hàng của khách sạn",
        "Phục vụ tiệc Gala, tiệc cưới và tiệc công ty theo thực đơn đặt riêng",
        "Buffet sáng đã bao gồm trong giá phòng của mọi hạng phòng",
    ]),
    gallery([G3 + "M-POOL-MALIBU-HOTEL-70.jpg", BLOG + "Anh_1_4_1.jpg",
             BLOG + "CARINA-MALIBU_HOTEL_1.jpg"]),
    cta("Đặt bàn tại Vela Restaurant",
        "Vui lòng đặt trước với tiệc từ 20 khách trở lên.",
        "Hotline:", "0254 3 577 789", "02543577789", "res@malibuhotel.com.vn"),
])

VELA_EN = "".join([
    hero(BLOG + "Anh_1_4_1.jpg", "3rd floor", "Vela Restaurant",
         "A breakfast buffet of 40+ Asian and European dishes, seating 350"),
    facts([
        ("Location", "3rd floor, The Malibu Hotel"),
        ("Capacity", "350 guests"),
        ("Breakfast buffet", "6:30 – 10:00 am daily"),
        ("Banquet &amp; à la carte", "11:00 am – 10:00 pm"),
    ]),
    prose([
        "One morning waking up at Malibu, listening to melodious music, sipping a cup "
        "of coffee and having breakfast at Vela Restaurant with more than 40 buffet "
        "dishes from Asia to Europe – before starting a new day of enthusiasm for a "
        "business trip or a day out in the beautiful coastal city.",
        "Our culinary team, knowledgeable in the quintessence of cuisine, takes care of "
        "every dish from choosing fresh ingredients to cooking – for an energetic "
        "breakfast, a light lunch, or special dishes for an impressive gala night.",
    ]),
    heading("The space"),
    prose([
        "The restaurant is designed in a spacious modern style with high-quality carpet "
        "and accommodates up to 350 guests. Vela serves à la carte, buffet and gala – "
        "suitable for in-house breakfast as well as large corporate banquets.",
    ]),
    highlights("Highlights", [
        "More than 40 breakfast buffet dishes, rotating Asian and European menus daily",
        "Seating for 350 guests – the largest of the hotel's restaurants",
        "Gala dinners, weddings and corporate events with bespoke menus",
        "The breakfast buffet is included in every room rate",
    ]),
    gallery([G3 + "M-POOL-MALIBU-HOTEL-70.jpg", BLOG + "Anh_1_4_1.jpg",
             BLOG + "CARINA-MALIBU_HOTEL_1.jpg"]),
    cta("Reserve a table at Vela Restaurant",
        "Advance booking is required for parties of 20 or more.",
        "Hotline:", "(+84) 254 3 577 789", "+842543577789",
        "res@malibuhotel.com.vn"),
])

# --------------------------------------------------------------------------
CARINA_VI = "".join([
    hero(BLOG + "CARINA-MALIBU_HOTEL_1.jpg", "Tầng 6", "Carina Restaurant",
         "Ẩm thực giao thoa Âu – Á trong không gian có tầm nhìn đặc biệt"),
    facts([
        ("Vị trí", "Tầng 6, The Malibu Hotel"),
        ("Sức chứa", "60 khách + phòng VIP 20 khách"),
        ("Giờ phục vụ", "11:00 – 22:00 hằng ngày"),
        ("Phong cách", "Fusion Âu – Á"),
    ]),
    prose([
        "Toạ lạc tại tầng 6 của khách sạn với tầm nhìn đặc biệt ra thành phố và biển, "
        "Carina Restaurant mang thiết kế hiện đại cùng âm nhạc thư thái, đem đến cho "
        "thực khách một trải nghiệm ẩm thực đẳng cấp.",
        "Nhà hàng có sức chứa khoảng 60 khách, cùng một phòng VIP dành riêng cho 20 "
        "khách – lý tưởng cho những buổi tiệc riêng tư, thanh lịch và các sự kiện đặc "
        "biệt. Đây cũng là lựa chọn đẹp cho những buổi hẹn hò lãng mạn.",
    ]),
    heading("Thực đơn"),
    prose([
        "Thực đơn lấy cảm hứng từ sự giao thoa giữa ẩm thực châu Âu và châu Á, tuyển "
        "chọn từ nguyên liệu thượng hạng. Cùng với tâm huyết của những đầu bếp tài hoa, "
        "công thức riêng và sự tỉ mỉ trong từng khâu phục vụ, Carina tạo nên những trải "
        "nghiệm vị giác rất riêng.",
    ]),
    highlights("Phù hợp cho", [
        "Bữa tối lãng mạn với tầm nhìn ra thành phố biển về đêm",
        "Tiệc riêng tư trong phòng VIP 20 khách",
        "Sự kiện kỷ niệm, sinh nhật và tiệc thân mật của doanh nghiệp",
        "Thực đơn set menu theo yêu cầu cho nhóm khách",
    ]),
    gallery([BLOG + "CARINA-MALIBU_HOTEL_1.jpg", G3 + "M-POOL-MALIBU-HOTEL-70.jpg",
             BLOG + "_THP4305-HDR_1.jpg"]),
    cta("Đặt bàn tại Carina Restaurant",
        "Phòng VIP cần đặt trước tối thiểu 24 giờ.",
        "Hotline:", "0254 3 577 789", "02543577789", "res@malibuhotel.com.vn"),
])

CARINA_EN = "".join([
    hero(BLOG + "CARINA-MALIBU_HOTEL_1.jpg", "6th floor", "Carina Restaurant",
         "European-Asian fusion cuisine with an extraordinary view"),
    facts([
        ("Location", "6th floor, The Malibu Hotel"),
        ("Capacity", "60 guests + a 20-seat VIP room"),
        ("Hours", "11:00 am – 10:00 pm daily"),
        ("Style", "European-Asian fusion"),
    ]),
    prose([
        "Located on the 6th floor with an extraordinary view over the city and the sea, "
        "Carina Restaurant features modern design and relaxed music, providing guests "
        "with a classy dining experience.",
        "The restaurant seats around 60 guests, with a VIP room reserved for 20 – ideal "
        "for private, elegant celebrations and special events, and a beautiful choice "
        "for a romantic evening.",
    ]),
    heading("The menu"),
    prose([
        "The menu is inspired by the fusion of European and Asian cuisine, selected from "
        "the finest ingredients. Together with the enthusiasm of talented chefs, unique "
        "recipes and meticulous attention to detail in serving, Carina creates flavours "
        "entirely its own.",
    ]),
    highlights("Ideal for", [
        "A romantic dinner overlooking the coastal city by night",
        "Private celebrations in the 20-seat VIP room",
        "Anniversaries, birthdays and intimate corporate gatherings",
        "Bespoke set menus for groups",
    ]),
    gallery([BLOG + "CARINA-MALIBU_HOTEL_1.jpg", G3 + "M-POOL-MALIBU-HOTEL-70.jpg",
             BLOG + "_THP4305-HDR_1.jpg"]),
    cta("Reserve a table at Carina Restaurant",
        "The VIP room requires at least 24 hours' notice.",
        "Hotline:", "(+84) 254 3 577 789", "+842543577789",
        "res@malibuhotel.com.vn"),
])

# --------------------------------------------------------------------------
LUX_VI = "".join([
    hero(BLOG + "800x600_1__1.png", "Sảnh khách sạn", "The Lux Café",
         "Một góc phố Milan giữa sảnh khách sạn, có cả cây đàn piano"),
    facts([
        ("Vị trí", "Sảnh The Malibu Hotel"),
        ("Giờ phục vụ", "07:00 – 22:00 hằng ngày"),
        ("Phong cách", "Cà phê &amp; trà, bánh ngọt, kem"),
        ("Điểm nhấn", "Piano tại sảnh"),
    ]),
    prose([
        "Trước khi trở lại với công việc, hãy ghé The Lux Café ở sảnh khách sạn để "
        "thưởng thức một ly kem hay tách cà phê trong lúc làm thủ tục trả phòng.",
        "Được thiết kế như một góc phố Milan tráng lệ mà không kém phần thời thượng, "
        "The Lux Café khiến bạn như đang đắm mình trong hơi thở của kinh đô thời trang.",
    ]),
    heading("Một lời mời"),
    prose([
        "Và nếu có thể, hãy để lại một bản concerto cho Malibu và những vị khách khác "
        "bên cây đàn piano nơi sảnh – một thói quen nhỏ đã trở thành nét riêng của "
        "buổi chiều tại đây.",
    ]),
    highlights("Gợi ý", [
        "Cà phê Việt Nam và các loại cà phê Ý pha máy",
        "Trà và bánh ngọt phục vụ cả ngày",
        "Kem và đồ uống mát cho buổi trưa Vũng Tàu",
        "Không gian yên tĩnh, phù hợp cho một cuộc hẹn công việc ngắn",
    ]),
    gallery([BLOG + "800x600_1__1.png", G3 + "M-POOL-MALIBU-HOTEL-70.jpg",
             BLOG + "DSC00288_1.jpg"]),
    cta("Ghé The Lux Café",
        "Không cần đặt chỗ – mời quý khách ghé bất cứ lúc nào trong giờ mở cửa.",
        "Hotline:", "0254 3 577 789", "02543577789", "res@malibuhotel.com.vn"),
])

LUX_EN = "".join([
    hero(BLOG + "800x600_1__1.png", "Hotel lobby", "The Lux Café",
         "A corner of a Milan street in the lobby, piano included"),
    facts([
        ("Location", "The Malibu Hotel lobby"),
        ("Hours", "7:00 am – 10:00 pm daily"),
        ("Style", "Coffee &amp; tea, pastries, ice cream"),
        ("Signature", "Lobby piano"),
    ]),
    prose([
        "Before we take you back to work, please pass by The Lux Café in the hotel lobby "
        "to enjoy a glass of ice cream or a coffee while checking out.",
        "Designed like a magnificent corner of a Milan street but no less fashionable, "
        "The Lux Café will make you feel as though you are immersed in the breath of the "
        "fashion capital.",
    ]),
    heading("An invitation"),
    prose([
        "And if you can, leave a concerto for Malibu and our other guests at the lobby "
        "piano – a small habit that has become part of the character of an afternoon "
        "here.",
    ]),
    highlights("Suggestions", [
        "Vietnamese coffee alongside Italian espresso-based classics",
        "Tea and pastries served all day",
        "Ice cream and cold drinks for a Vung Tau afternoon",
        "A quiet corner well suited to a short business meeting",
    ]),
    gallery([BLOG + "800x600_1__1.png", G3 + "M-POOL-MALIBU-HOTEL-70.jpg",
             BLOG + "DSC00288_1.jpg"]),
    cta("Visit The Lux Café",
        "No reservation needed – you are welcome any time during opening hours.",
        "Hotline:", "(+84) 254 3 577 789", "+842543577789",
        "res@malibuhotel.com.vn"),
])

# id dịch vụ -> (nội dung VI, nội dung EN)
CONTENT = {
    4: (VELA_VI, VELA_EN),
    5: (CARINA_VI, CARINA_EN),
    6: (LUX_VI, LUX_EN),
}
