# -*- coding: utf-8 -*-
"""Dữ liệu 3 nhà hàng của The Malibu Hotel cho plugin `restaurant`.

Khác với bản cũ nằm trong ht_services: thông tin vị trí / sức chứa / giờ phục vụ
/ phong cách nay là CỘT RIÊNG, chỉnh được trong dashboard. Phần `content` chỉ còn
văn xuôi; bố cục do view của theme dựng, nên sau này thay ảnh bằng VR360 không
phải sửa HTML.
"""

CDN = "https://malibuhotel.com.vn"
BLOG = CDN + "/files/blog/46_1815/"
G3 = CDN + "/files/sites/site_70/site_70_gallery_muc3/"

PHONE = "0254 3 577 789"
EMAIL = "res@malibuhotel.com.vn"


def prose(paragraphs):
    return "".join("<p>%s</p>" % p for p in paragraphs)


def section(title, paragraphs):
    return "<h3>%s</h3>%s" % (title, prose(paragraphs))


RESTAURANTS = [
    dict(
        id=1, order=0, featured=1,
        slug_vi="vela-restaurant", slug_en="vela-restaurant",
        name_vi="Vela Restaurant", name_en="Vela Restaurant",
        location_vi="Tầng 3", location_en="3rd floor",
        capacity_vi="350 khách", capacity_en="350 guests",
        hours_vi="Buffet sáng 06:30 – 10:00 · Tiệc 11:00 – 22:00",
        hours_en="Breakfast buffet 6:30 – 10:00 am · Banquet 11:00 am – 10:00 pm",
        cuisine_vi="Buffet Á – Âu", cuisine_en="Asian &amp; European buffet",
        desc_vi="Buffet sáng hơn 40 món Á – Âu trong không gian rộng 350 chỗ, "
                "phục vụ cả à la carte và tiệc Gala.",
        desc_en="A breakfast buffet of more than 40 Asian and European dishes in a "
                "350-seat room, also serving à la carte and gala dinners.",
        images=[BLOG + "Anh_1_4_1.jpg", G3 + "M-POOL-MALIBU-HOTEL-70.jpg",
                G3 + "M-POOL-MALIBU-HOTEL-62.jpg", G3 + "M-POOL-MALIBU-HOTEL-64.jpg"],
        content_vi="".join([
            prose([
                "Một sáng thức dậy tại Malibu, nghe bản nhạc du dương, nhấp ngụm cà phê "
                "và dùng bữa sáng tại Vela với hơn 40 món buffet trải từ Á sang Âu – "
                "trước khi bắt đầu ngày mới đầy hứng khởi cho chuyến công tác, hay một "
                "ngày rong chơi ở thành phố biển.",
                "Đội ngũ ẩm thực của khách sạn chăm chút từng món ăn, từ khâu chọn "
                "nguyên liệu tươi ngon đến chế biến – cho một bữa sáng tràn năng lượng, "
                "một bữa trưa nhẹ nhàng, hay những món đặc biệt cho đêm Gala ấn tượng.",
            ]),
            section("Không gian", [
                "Nhà hàng được thiết kế rộng rãi theo phong cách hiện đại, trải thảm "
                "cao cấp, sức chứa lên đến 350 khách. Vela phục vụ cả ba hình thức: "
                "gọi món à la carte, buffet và tiệc Gala – phù hợp cho bữa sáng của "
                "khách lưu trú lẫn tiệc công ty quy mô lớn.",
            ]),
            section("Điểm nổi bật", [
                "Hơn 40 món buffet sáng, luân phiên món Á và món Âu mỗi ngày. "
                "Sức chứa lớn nhất trong các nhà hàng của khách sạn. Nhận đặt tiệc "
                "Gala, tiệc cưới và tiệc công ty theo thực đơn riêng. Buffet sáng đã "
                "bao gồm trong giá phòng của mọi hạng phòng.",
            ]),
        ]),
        content_en="".join([
            prose([
                "One morning waking up at Malibu, listening to melodious music, sipping "
                "a cup of coffee and having breakfast at Vela with more than 40 buffet "
                "dishes from Asia to Europe – before starting a new day of enthusiasm "
                "for a business trip or a day out in the beautiful coastal city.",
                "Our culinary team takes care of every dish, from choosing fresh "
                "ingredients to cooking – for an energetic breakfast, a light lunch, or "
                "special dishes for an impressive gala night.",
            ]),
            section("The space", [
                "The restaurant is designed in a spacious modern style with high-quality "
                "carpet and accommodates up to 350 guests. Vela serves à la carte, "
                "buffet and gala – suitable for in-house breakfast as well as large "
                "corporate banquets.",
            ]),
            section("Highlights", [
                "More than 40 breakfast buffet dishes, rotating Asian and European "
                "menus daily. The largest of the hotel's restaurants. Gala dinners, "
                "weddings and corporate events with bespoke menus. The breakfast buffet "
                "is included in every room rate.",
            ]),
        ]),
    ),
    dict(
        id=2, order=1, featured=1,
        slug_vi="carina-restaurant", slug_en="carina-restaurant",
        name_vi="Carina Restaurant", name_en="Carina Restaurant",
        location_vi="Tầng 6", location_en="6th floor",
        capacity_vi="60 khách · phòng VIP 20 khách",
        capacity_en="60 guests · 20-seat VIP room",
        hours_vi="11:00 – 22:00 hằng ngày", hours_en="11:00 am – 10:00 pm daily",
        cuisine_vi="Fusion Âu – Á", cuisine_en="European-Asian fusion",
        desc_vi="Ẩm thực giao thoa Âu – Á trên tầng 6 với tầm nhìn đặc biệt ra thành "
                "phố và biển, có phòng VIP riêng cho 20 khách.",
        desc_en="European-Asian fusion cuisine on the 6th floor with an extraordinary "
                "view over the city and the sea, plus a private 20-seat VIP room.",
        images=[BLOG + "CARINA-MALIBU_HOTEL_1.jpg", G3 + "M-POOL-MALIBU-HOTEL-65.jpg",
                G3 + "M-POOL-MALIBU-HOTEL-66.jpg", G3 + "M-POOL-MALIBU-HOTEL-67.jpg"],
        content_vi="".join([
            prose([
                "Toạ lạc tại tầng 6 của khách sạn với tầm nhìn đặc biệt ra thành phố và "
                "biển, Carina Restaurant mang thiết kế hiện đại cùng âm nhạc thư thái, "
                "đem đến cho thực khách một trải nghiệm ẩm thực đẳng cấp.",
                "Nhà hàng có sức chứa khoảng 60 khách, cùng một phòng VIP dành riêng "
                "cho 20 khách – lý tưởng cho những buổi tiệc riêng tư, thanh lịch và "
                "các sự kiện đặc biệt. Đây cũng là lựa chọn đẹp cho những buổi hẹn hò "
                "lãng mạn.",
            ]),
            section("Thực đơn", [
                "Thực đơn lấy cảm hứng từ sự giao thoa giữa ẩm thực châu Âu và châu Á, "
                "tuyển chọn từ nguyên liệu thượng hạng. Cùng với tâm huyết của những "
                "đầu bếp tài hoa, công thức riêng và sự tỉ mỉ trong từng khâu phục vụ, "
                "Carina tạo nên những trải nghiệm vị giác rất riêng.",
            ]),
            section("Phù hợp cho", [
                "Bữa tối lãng mạn với tầm nhìn ra thành phố biển về đêm. Tiệc riêng tư "
                "trong phòng VIP 20 khách. Sự kiện kỷ niệm, sinh nhật và tiệc thân mật "
                "của doanh nghiệp. Thực đơn set menu theo yêu cầu cho nhóm khách.",
            ]),
        ]),
        content_en="".join([
            prose([
                "Located on the 6th floor with an extraordinary view over the city and "
                "the sea, Carina Restaurant features modern design and relaxed music, "
                "providing guests with a classy dining experience.",
                "The restaurant seats around 60 guests, with a VIP room reserved for 20 "
                "– ideal for private, elegant celebrations and special events, and a "
                "beautiful choice for a romantic evening.",
            ]),
            section("The menu", [
                "The menu is inspired by the fusion of European and Asian cuisine, "
                "selected from the finest ingredients. Together with the enthusiasm of "
                "talented chefs, unique recipes and meticulous attention to detail in "
                "serving, Carina creates flavours entirely its own.",
            ]),
            section("Ideal for", [
                "A romantic dinner overlooking the coastal city by night. Private "
                "celebrations in the 20-seat VIP room. Anniversaries, birthdays and "
                "intimate corporate gatherings. Bespoke set menus for groups.",
            ]),
        ]),
    ),
    dict(
        id=3, order=2, featured=0,
        slug_vi="the-lux-cafe", slug_en="the-lux-cafe",
        name_vi="The Lux Café", name_en="The Lux Café",
        location_vi="Sảnh khách sạn", location_en="Hotel lobby",
        capacity_vi="", capacity_en="",
        hours_vi="07:00 – 22:00 hằng ngày", hours_en="7:00 am – 10:00 pm daily",
        cuisine_vi="Cà phê, trà &amp; bánh ngọt",
        cuisine_en="Coffee, tea &amp; pastries",
        desc_vi="Quán cà phê ở sảnh khách sạn, thiết kế như một góc phố Milan, "
                "có cây đàn piano cho những phút ngẫu hứng.",
        desc_en="A café in the hotel lobby designed like a corner of a Milan street, "
                "with a piano for spontaneous moments.",
        images=[BLOG + "800x600_1__1.png", BLOG + "DSC00288_1.jpg",
                G3 + "M-POOL-MALIBU-HOTEL-59.jpg", G3 + "M-POOL-MALIBU-HOTEL-61.jpg"],
        content_vi="".join([
            prose([
                "Trước khi trở lại với công việc, hãy ghé The Lux Café ở sảnh khách sạn "
                "để thưởng thức một ly kem hay tách cà phê trong lúc làm thủ tục trả "
                "phòng.",
                "Được thiết kế như một góc phố Milan tráng lệ mà không kém phần thời "
                "thượng, The Lux Café khiến bạn như đang đắm mình trong hơi thở của "
                "kinh đô thời trang.",
            ]),
            section("Một lời mời", [
                "Và nếu có thể, hãy để lại một bản concerto cho Malibu và những vị "
                "khách khác bên cây đàn piano nơi sảnh – một thói quen nhỏ đã trở thành "
                "nét riêng của buổi chiều tại đây.",
            ]),
            section("Gợi ý", [
                "Cà phê Việt Nam và các loại cà phê Ý pha máy. Trà và bánh ngọt phục vụ "
                "cả ngày. Kem và đồ uống mát cho buổi trưa Vũng Tàu. Không gian yên "
                "tĩnh, phù hợp cho một cuộc hẹn công việc ngắn.",
            ]),
        ]),
        content_en="".join([
            prose([
                "Before we take you back to work, please pass by The Lux Café in the "
                "hotel lobby to enjoy a glass of ice cream or a coffee while checking "
                "out.",
                "Designed like a magnificent corner of a Milan street but no less "
                "fashionable, The Lux Café will make you feel as though you are immersed "
                "in the breath of the fashion capital.",
            ]),
            section("An invitation", [
                "And if you can, leave a concerto for Malibu and our other guests at the "
                "lobby piano – a small habit that has become part of the character of an "
                "afternoon here.",
            ]),
            section("Suggestions", [
                "Vietnamese coffee alongside Italian espresso-based classics. Tea and "
                "pastries served all day. Ice cream and cold drinks for a Vung Tau "
                "afternoon. A quiet corner well suited to a short business meeting.",
            ]),
        ]),
    ),
]

# Bảng ht_services sẽ bỏ 3 mục này (id 4, 5, 6) vì đã chuyển sang plugin Nhà hàng.
REMOVED_SERVICE_IDS = [4, 5, 6]
REMOVED_SERVICE_SLUG_IDS = [31, 32, 33]

# Trang "Ẩm thực" (id 9) và slug của nó bị bỏ; menu trỏ thẳng vào /nha-hang.
OLD_PAGE_ID = 9
OLD_PAGE_SLUG_ID = 6
MENU_NODES = {24: ("Nhà hàng", ""), 52: ("Dine", "/en")}
