# -*- coding: utf-8 -*-
"""Nội dung đầy đủ cho 6 trang ở chân trang của The Malibu Hotel."""

import page_blocks as B

CDN = "https://malibuhotel.com.vn"
L1 = CDN + "/files/sites/site_70/site_70_gallery_muc1/"
L2 = CDN + "/files/sites/site_70/site_70_gallery_muc2/"
L3 = CDN + "/files/sites/site_70/site_70_gallery_muc3/"
L4 = CDN + "/files/sites/site_70/site_70_gallery_muc4/"
L5 = CDN + "/files/sites/site_70/site_70_gallery_muc5/"
L7 = CDN + "/files/sites/site_70/site_70_gallery_muc7/"
BLOG = CDN + "/files/blog/46_1815/"

EXTERIOR = L1 + "MALIBU-HOTEL1.jpg"
EXTERIOR2 = L1 + "MALIBU-HOTEL2.jpg"
LANDSCAPE = L1 + "M-POOL-MALIBU-HOTEL-159.jpg"
LOBBY = L1 + "M-POOL-MALIBU-HOTEL-160.jpg"
ROOM = L2 + "DSC05931-HDR.jpg"
RESTAURANT = L3 + "M-POOL-MALIBU-HOTEL-70.jpg"
EVENTS = L4 + "M-POOL-MALIBU-HOTEL-04.jpg"
POOL = L5 + "M-POOL-MALIBU-HOTEL-36.jpg"
SPA = L7 + "M-POOL-MALIBU-HOTEL-52.jpg"
BALLROOM = CDN + "/files/sites/70/meeting-3.jpg"

HOTLINE = "0941 871 644"
TEL = "tel:0941871644"
EMAIL_RES = "res@malibuhotel.com.vn"
EMAIL_INFO = "info@malibuhotel.com.vn"
EMAIL_HR = "tuyendung@malibuhotel.com.vn"
UPDATED_VI = "Cập nhật lần cuối: ngày 04 tháng 9 năm 2026."
UPDATED_EN = "Last updated: 4 September 2026."


def sc(name, **attrs):
    parts = " ".join('%s="%s"' % (k, v) for k, v in attrs.items())
    return "<shortcode>[%s%s][/%s]</shortcode>" % (
        name, (" " + parts) if parts else "", name)


# ══════════════════════════════════════════════════════ 5. Về chúng tôi
ABOUT_VI = B.container(
    B.hero(EXTERIOR, "The Malibu Hotel", "Về chúng tôi",
           "Live Beautifully — sống trọn từng khoảnh khắc. Một toà nhà 23 tầng bên "
           "bờ biển Vũng Tàu, nơi kiến trúc châu Âu gặp nhịp sống của thành phố biển."),
    B.stats([("197", "Phòng nghỉ"), ("23", "Tầng"),
             ("6", "Tầng dịch vụ"), ("2016", "Năm hoạt động")]),
    B.section("Lịch sử", [
        "Khách sạn Malibu đi vào hoạt động từ tháng 4 năm 2016, với cơ cấu toà nhà 23 "
        "tầng gồm 2 tầng hầm và 6 tầng dịch vụ — trong đó có sảnh hội nghị và tiệc, "
        "spa, pool bar, hồ bơi, phòng gym, khu giải trí — cùng khu lưu trú với tổng số "
        "197 phòng nghỉ.",
        "Gần một thập kỷ đón khách, Malibu đã trở thành một trong những địa chỉ quen "
        "thuộc của du khách trong nước và quốc tế mỗi khi đặt chân tới Vũng Tàu, cũng "
        "như của các doanh nghiệp chọn nơi đây làm điểm tổ chức hội nghị và sự kiện.",
    ]),
    B.section("Kiến trúc", [
        "Khách sạn được thiết kế từ nguồn cảm hứng kiến trúc châu Âu sang trọng và hiện "
        "đại. Khối nhà cong mềm mại ôm lấy đường bờ biển, mặt kính lớn đón sáng tự "
        "nhiên suốt ngày.",
        "Tất cả các phòng tại khách sạn đều có tầm nhìn hướng ra đại dương và một phần "
        "ôm trọn thành phố Vũng Tàu xinh đẹp — từ hạng Premier 40 m² cho tới "
        "Presidential Suite 250 m² trên tầng cao nhất.",
    ]),
    B.section("Tầm nhìn", [
        "Tầm nhìn của khách sạn trong 5 năm tới là mở rộng thành một chuỗi khách sạn "
        "tại miền Đông Nam Bộ, với giá trị cốt lõi là đội ngũ nhân sự tâm huyết yêu "
        "nghề và hệ thống quản trị chuyên nghiệp.",
    ]),
    B.highlight("Điều làm nên Malibu", [
        "<strong>Vị trí trung tâm</strong> — 263 Lê Hồng Phong, cách bãi biển Bãi Sau "
        "khoảng 450 m, đi bộ chừng 6 phút.",
        "<strong>Mọi phòng đều hướng biển</strong> — không có phòng nào quay lưng lại "
        "với đại dương.",
        "<strong>Sáu tầng dịch vụ</strong> — M Pool, M Spa, M Gym, Kid Zone, Gift Shop "
        "và khu giải trí phục vụ suốt kỳ nghỉ.",
        "<strong>Ẩm thực tại chỗ</strong> — Vela Restaurant, Carina Restaurant và "
        "The Lux Café.",
        "<strong>Hội nghị quy mô lớn</strong> — 7 phòng họp, sức chứa tới 450 khách.",
        "<strong>Vận hành khép kín</strong> — xưởng giặt riêng, an ninh và lễ tân "
        "trực 24/7.",
    ]),
    B.section("Không gian tại Malibu", []),
    B.cards([
        (ROOM, "Phòng nghỉ", "197 phòng trải trên 4 hạng Premier, Diamond, Suite và "
                             "President, tất cả đều hướng biển.", "Lưu trú"),
        (RESTAURANT, "Ẩm thực", "Buffet sáng hơn 40 món tại Vela, ẩm thực fusion tại "
                                "Carina và cà phê ở The Lux Café.", "Nhà hàng"),
        (POOL, "M Pool", "Hồ bơi ngoài trời tầng 6 với tầm nhìn toàn cảnh thành phố, "
                         "hệ thống điện phân muối tự nhiên.", "Thư giãn"),
        (BALLROOM, "Hội nghị &amp; Sự kiện", "7 phòng hội nghị linh hoạt, phòng Malibu "
                                             "Grand chia được thành 3 phòng nhỏ.", "Sự kiện"),
    ]),
    B.section("Vị trí", [
        "The Malibu Hotel toạ lạc tại 263 Lê Hồng Phong, phường Thắng Tam, thành phố "
        "Vũng Tàu — ngay trung tâm, thuận tiện di chuyển tới hầu hết điểm tham quan "
        "nổi tiếng của thành phố biển.",
    ]),
    B.cta("Liên hệ với chúng tôi",
          "Đội ngũ của Malibu sẵn sàng hỗ trợ quý khách 24/7.",
          [(HOTLINE, TEL), (EMAIL_RES, "mailto:" + EMAIL_RES)]),
) + sc("hotel-places", limit="6")

ABOUT_EN = B.container(
    B.hero(EXTERIOR, "The Malibu Hotel", "About Us",
           "Live Beautifully. A 23-storey tower on the Vung Tau shoreline, where "
           "European architecture meets the rhythm of a coastal city."),
    B.stats([("197", "Guest rooms"), ("23", "Floors"),
             ("6", "Service floors"), ("2016", "Opened")]),
    B.section("History", [
        "The Malibu Hotel opened in April 2016 as a 23-storey tower with two basement "
        "levels and six service floors — housing conference and banquet halls, a spa, "
        "a pool bar, the swimming pool, a gym and an entertainment area — alongside "
        "197 guest rooms.",
        "After almost a decade of welcoming guests, Malibu has become a familiar "
        "address for domestic and international travellers arriving in Vung Tau, and "
        "for companies choosing a venue for conferences and events.",
    ]),
    B.section("Architecture", [
        "The hotel is designed from an inspiration of luxurious, modern European "
        "architecture. The gently curved building follows the shoreline, and generous "
        "glazing draws in natural light throughout the day.",
        "Every room looks out over the ocean and embraces part of the beautiful city "
        "of Vung Tau — from the 40 sqm Premier to the 250 sqm Presidential Suite on "
        "the top floor.",
    ]),
    B.section("Vision", [
        "Over the next five years the hotel intends to grow into a chain across the "
        "south-east of Vietnam, built on core values of a dedicated team and a "
        "professional management system.",
    ]),
    B.highlight("What makes Malibu", [
        "<strong>A central location</strong> — 263 Le Hong Phong, about 450 m from "
        "Back Beach, a six-minute walk.",
        "<strong>Ocean views from every room</strong> — not a single room turns its "
        "back on the sea.",
        "<strong>Six service floors</strong> — M Pool, M Spa, M Gym, the Kid Zone, the "
        "Gift Shop and the entertainment area.",
        "<strong>Dining on site</strong> — Vela Restaurant, Carina Restaurant and "
        "The Lux Café.",
        "<strong>Large-scale conferences</strong> — seven meeting rooms for up to "
        "450 guests.",
        "<strong>Self-contained operations</strong> — our own laundry, with security "
        "and front desk on duty 24/7.",
    ]),
    B.section("Spaces at Malibu", []),
    B.cards([
        (ROOM, "Rooms &amp; Suites", "197 rooms across four categories — Premier, "
                                     "Diamond, Suite and President — all facing the sea.", "Stay"),
        (RESTAURANT, "Dining", "A 40-dish breakfast buffet at Vela, fusion cuisine at "
                               "Carina and coffee at The Lux Café.", "Restaurants"),
        (POOL, "M Pool", "A 6th-floor outdoor pool with panoramic city views and a "
                         "natural-salt electrolysis system.", "Relax"),
        (BALLROOM, "Meetings &amp; Events", "Seven flexible conference rooms; the "
                                            "Malibu Grand divides into three.", "Events"),
    ]),
    B.section("Location", [
        "The Malibu Hotel stands at 263 Le Hong Phong Street, Thang Tam Ward, Vung Tau "
        "City — central, and within easy reach of most of the coastal city's "
        "best-known attractions.",
    ]),
    B.cta("Get in touch",
          "The Malibu team is here to help, around the clock.",
          [("(+84) 941 871 644", TEL), (EMAIL_RES, "mailto:" + EMAIL_RES)]),
) + sc("hotel-places", limit="6")


# ══════════════════════════════════════════════════════ 19. Malibu Group
GROUP_VI = B.container(
    B.hero(EXTERIOR2, "Malibu Group", "Hệ thống Malibu Group",
           "Bên cạnh The Malibu Hotel Vũng Tàu, Malibu Group phát triển thêm nhiều "
           "sản phẩm lưu trú khác trong khu vực miền Đông Nam Bộ."),
    B.prose([
        "Mỗi cơ sở mang một tính cách riêng — từ khách sạn thành phố tới villa nghỉ "
        "dưỡng ven biển — nhưng cùng chung một tinh thần phục vụ và một hệ thống quản "
        "trị. Quý khách lưu trú tại bất kỳ điểm nào trong hệ thống đều nhận được tiêu "
        "chuẩn dịch vụ như nhau.",
    ]),
    B.cards([
        (EXTERIOR, "The Malibu Hotel Vũng Tàu",
         "Khách sạn chính của hệ thống: 23 tầng, 197 phòng nghỉ hướng biển, 7 phòng "
         "hội nghị và đầy đủ tiện ích spa, hồ bơi, phòng gym.", "Vũng Tàu"),
        (LOBBY, "The Malibu House",
         "Mô hình lưu trú nhỏ gọn và ấm cúng, phù hợp với khách đi lẻ hoặc gia đình "
         "nhỏ muốn một không gian riêng tư hơn.", "Vũng Tàu"),
        (EXTERIOR2, "The Malibu Hotel Sài Gòn",
         "Cơ sở của Malibu tại Thành phố Hồ Chí Minh, phục vụ khách công tác và khách "
         "quá cảnh trước khi ra biển.", "TP. Hồ Chí Minh"),
        (LANDSCAPE, "The Malibu Villa Long Cung",
         "Villa nghỉ dưỡng tại khu Long Cung, Vũng Tàu — không gian rộng rãi dành cho "
         "nhóm bạn và gia đình nhiều thế hệ.", "Vũng Tàu"),
        (SPA, "Sanctuary Villa Hồ Tràm",
         "Villa ven biển tại Hồ Tràm, hướng tới những kỳ nghỉ dài ngày yên tĩnh, tách "
         "khỏi nhịp sống đô thị.", "Hồ Tràm"),
    ], per_row=3),
    B.cta("Đặt phòng trong hệ thống Malibu",
          "Liên hệ để được tư vấn cơ sở phù hợp nhất với chuyến đi của quý khách.",
          [(HOTLINE, TEL), (EMAIL_RES, "mailto:" + EMAIL_RES)]),
)

GROUP_EN = B.container(
    B.hero(EXTERIOR2, "Malibu Group", "The Malibu Group",
           "Alongside The Malibu Hotel Vung Tau, Malibu Group develops a range of "
           "hospitality products across south-east Vietnam."),
    B.prose([
        "Each property has a character of its own — from a city hotel to a beachfront "
        "villa — but they share one spirit of service and one management system. "
        "Guests staying anywhere in the group receive the same standard of care.",
    ]),
    B.cards([
        (EXTERIOR, "The Malibu Hotel Vung Tau",
         "The group's flagship: 23 storeys, 197 ocean-view rooms, seven conference "
         "rooms and a full set of spa, pool and gym facilities.", "Vung Tau"),
        (LOBBY, "The Malibu House",
         "A compact, welcoming accommodation concept suited to independent travellers "
         "and small families who want more privacy.", "Vung Tau"),
        (EXTERIOR2, "The Malibu Hotel Sai Gon",
         "Malibu's property in Ho Chi Minh City, serving business travellers and "
         "guests in transit before heading to the coast.", "Ho Chi Minh City"),
        (LANDSCAPE, "The Malibu Villa Long Cung",
         "A resort villa in the Long Cung area of Vung Tau — generous space for groups "
         "of friends and multi-generation families.", "Vung Tau"),
        (SPA, "Sanctuary Villa Ho Tram",
         "A beachfront villa in Ho Tram, made for long, quiet stays away from the pace "
         "of the city.", "Ho Tram"),
    ], per_row=3),
    B.cta("Book across the Malibu Group",
          "Contact us and we will help you choose the property that fits your trip.",
          [("(+84) 941 871 644", TEL), (EMAIL_RES, "mailto:" + EMAIL_RES)]),
)


# ══════════════════════════════════════════════════════ 22. Tuyển dụng
CAREERS_VI = B.container(
    B.hero(LOBBY, "Tuyển dụng", "Làm việc tại Malibu",
           "Giá trị cốt lõi của Malibu là đội ngũ nhân sự tâm huyết yêu nghề và một hệ "
           "thống quản trị chuyên nghiệp. Chúng tôi luôn tìm những cộng sự cùng chia sẻ "
           "tinh thần Live Beautifully."),
    B.section("Môi trường làm việc", [
        "Malibu là khách sạn vận hành khép kín: từ bếp, buồng phòng cho tới xưởng giặt "
        "đều do đội ngũ của khách sạn đảm nhiệm. Điều đó có nghĩa là mỗi vị trí đều "
        "được đào tạo bài bản và có lộ trình phát triển rõ ràng trong nội bộ.",
        "Chúng tôi đón khách trong nước lẫn quốc tế quanh năm, nên đây cũng là nơi tốt "
        "để rèn ngoại ngữ và làm quen với tiêu chuẩn phục vụ quốc tế.",
    ]),
    B.highlight("Quyền lợi", [
        "Lương thoả thuận theo năng lực, xét tăng định kỳ.",
        "Đóng bảo hiểm xã hội, y tế và thất nghiệp đầy đủ theo quy định.",
        "Phụ cấp ca, ăn giữa ca tại căng tin nhân viên.",
        "Đồng phục và giặt là do khách sạn lo.",
        "Đào tạo nghiệp vụ định kỳ, ưu tiên đề bạt nội bộ.",
        "Thưởng lễ, Tết và các chế độ theo quy định của khách sạn.",
    ]),
    B.section("Các bộ phận thường tuyển", []),
    B.cards([
        (None, "Tiền sảnh", "Lễ tân, đặt phòng, hành lý, tổng đài — bộ mặt đầu tiên "
                            "khách gặp khi tới Malibu.", "Front Office"),
        (None, "Buồng phòng", "Dọn phòng, khu vực công cộng, kho vải và xưởng giặt "
                              "khép kín của khách sạn.", "Housekeeping"),
        (None, "Ẩm thực &amp; Bếp", "Nhà hàng Vela, Carina, The Lux Café và bộ phận "
                                    "tiệc — từ phục vụ tới bếp nóng, bếp bánh.", "F&amp;B"),
        (None, "Kinh doanh &amp; Marketing", "Bán phòng, chăm sóc khách doanh nghiệp, "
                                             "tổ chức sự kiện và truyền thông.", "Sales"),
        (None, "Kỹ thuật", "Vận hành, bảo trì hệ thống điện, nước, điều hoà và thiết bị "
                           "hội nghị.", "Engineering"),
        (None, "Spa &amp; Giải trí", "M Spa, M Gym, M Pool và Kid Zone — chăm sóc trải "
                                     "nghiệm nghỉ dưỡng của khách.", "Recreation"),
    ], per_row=3),
    B.section("Quy trình ứng tuyển", []),
    B.steps([
        ("Gửi hồ sơ", "Gửi CV kèm vị trí ứng tuyển về "
                      "<strong>" + EMAIL_HR + "</strong>, hoặc nộp trực tiếp tại quầy "
                      "lễ tân khách sạn."),
        ("Sàng lọc", "Bộ phận Nhân sự xem xét và phản hồi trong vòng 5 ngày làm việc "
                     "kể từ khi nhận hồ sơ."),
        ("Phỏng vấn", "Gặp trưởng bộ phận và Nhân sự. Một số vị trí có thêm bài kiểm "
                      "tra nghiệp vụ hoặc ngoại ngữ."),
        ("Nhận việc", "Thoả thuận điều kiện làm việc, ký hợp đồng và tham gia chương "
                      "trình hội nhập dành cho nhân viên mới."),
    ]),
    B.cta("Nộp hồ sơ ứng tuyển",
          "Bộ phận Nhân sự tiếp nhận hồ sơ từ thứ Hai đến thứ Bảy.",
          [(EMAIL_HR, "mailto:" + EMAIL_HR), ("0254 3 523 523", "tel:02543523523")]),
)

CAREERS_EN = B.container(
    B.hero(LOBBY, "Careers", "Working at Malibu",
           "Malibu's core value is a dedicated team supported by a professional "
           "management system. We are always looking for colleagues who share the "
           "Live Beautifully spirit."),
    B.section("Our workplace", [
        "Malibu runs as a self-contained hotel: the kitchen, housekeeping and even the "
        "laundry are handled by our own team. That means every role comes with proper "
        "training and a clear path to grow within the hotel.",
        "We welcome both domestic and international guests year round, so this is also "
        "a good place to practise languages and learn international service standards.",
    ]),
    B.highlight("What we offer", [
        "Salary negotiated on merit, with regular reviews.",
        "Full social, health and unemployment insurance as required by law.",
        "Shift allowance and staff canteen meals.",
        "Uniform and laundry provided by the hotel.",
        "Regular professional training, with internal promotion preferred.",
        "Holiday and Tet bonuses under the hotel's policy.",
    ]),
    B.section("Departments we hire for", []),
    B.cards([
        (None, "Front Office", "Reception, reservations, bell desk and switchboard — "
                               "the first faces guests meet at Malibu.", "Front Office"),
        (None, "Housekeeping", "Guest rooms, public areas, linen store and the hotel's "
                               "own closed-cycle laundry.", "Housekeeping"),
        (None, "Food &amp; Beverage", "Vela, Carina, The Lux Café and banquets — from "
                                      "service to hot kitchen and pastry.", "F&amp;B"),
        (None, "Sales &amp; Marketing", "Room sales, corporate accounts, event "
                                        "organisation and communications.", "Sales"),
        (None, "Engineering", "Operating and maintaining electrical, plumbing, HVAC and "
                              "conference equipment.", "Engineering"),
        (None, "Spa &amp; Recreation", "M Spa, M Gym, M Pool and the Kid Zone — "
                                       "looking after the guest experience.", "Recreation"),
    ], per_row=3),
    B.section("How to apply", []),
    B.steps([
        ("Send your application", "Email your CV and the role you are applying for to "
                                  "<strong>" + EMAIL_HR + "</strong>, or drop it off at "
                                  "the hotel reception."),
        ("Screening", "Our HR team reviews applications and replies within five working "
                      "days of receipt."),
        ("Interview", "Meet the department head and HR. Some roles include a practical "
                      "or language assessment."),
        ("Joining", "Agree terms, sign the contract and take part in our onboarding "
                    "programme for new colleagues."),
    ]),
    B.cta("Send us your application",
          "Our HR team receives applications Monday to Saturday.",
          [(EMAIL_HR, "mailto:" + EMAIL_HR), ("(0254) 3 523 523", "tel:02543523523")]),
)


# ══════════════════════════════════════════════════════ 8. Câu hỏi thường gặp
FAQ_VI = B.container(
    B.hero(LANDSCAPE, "Hỗ trợ", "Câu hỏi thường gặp",
           "Những thắc mắc khách lưu trú hay hỏi nhất về Malibu — từ giờ nhận phòng, "
           "bữa sáng, hồ bơi cho tới điểm tham quan quanh khách sạn."),
) + sc("faqs", category_ids="1,2,3,4,5") + B.container(
    B.cta("Chưa tìm thấy câu trả lời?",
          "Lễ tân của Malibu trực 24/7 và luôn sẵn sàng hỗ trợ quý khách.",
          [(HOTLINE, TEL), (EMAIL_INFO, "mailto:" + EMAIL_INFO)]),
)

FAQ_EN = B.container(
    B.hero(LANDSCAPE, "Support", "Hotel FAQs",
           "The questions our guests ask most often — from check-in times and "
           "breakfast to the pool and what to see around the hotel."),
) + sc("faqs", category_ids="1,2,3,4,5") + B.container(
    B.cta("Still have a question?",
          "Our front desk is staffed 24/7 and always happy to help.",
          [("(+84) 941 871 644", TEL), (EMAIL_INFO, "mailto:" + EMAIL_INFO)]),
)


# ══════════════════════════════════════════════════════ 12. Chính sách bảo mật
PRIVACY_VI = B.container(
    B.hero(None, "Pháp lý", "Chính sách bảo mật",
           "The Malibu Hotel tôn trọng và cam kết bảo vệ thông tin cá nhân của quý "
           "khách. Chính sách này mô tả cách chúng tôi thu thập, sử dụng, lưu trữ và "
           "bảo vệ dữ liệu."),
    B.section("1. Phạm vi áp dụng", [
        "Chính sách này áp dụng cho website www.malibuhotel.com.vn và cho mọi dịch vụ "
        "do Công ty TNHH Thương mại Dịch vụ Du lịch Nguyên Hà cung cấp tại The Malibu "
        "Hotel, 263 Lê Hồng Phong, phường Thắng Tam, thành phố Vũng Tàu.",
        "Khi quý khách đặt phòng, sử dụng dịch vụ hoặc truy cập website của chúng tôi, "
        "quý khách đồng ý với các nội dung được nêu tại đây.",
    ]),
    B.section("2. Thông tin chúng tôi thu thập", []),
    B.definitions([
        ("Thông tin định danh", "Họ tên, ngày sinh, quốc tịch, số hộ chiếu hoặc "
                                "CMND/CCCD — thu thập khi làm thủ tục nhận phòng theo "
                                "quy định về khai báo lưu trú."),
        ("Thông tin liên hệ", "Số điện thoại, địa chỉ email và địa chỉ thư tín."),
        ("Thông tin đặt phòng", "Ngày đến, ngày đi, hạng phòng, số lượng khách, yêu "
                                "cầu đặc biệt và lịch sử lưu trú."),
        ("Thông tin thanh toán", "Thông tin thẻ hoặc chứng từ chuyển khoản phục vụ "
                                 "việc giữ phòng và thanh toán. Chúng tôi không lưu "
                                 "trữ số thẻ đầy đủ trên hệ thống của mình."),
        ("Dữ liệu kỹ thuật", "Địa chỉ IP, loại trình duyệt, thiết bị và các trang quý "
                             "khách đã xem trên website."),
    ]),
    B.section("3. Mục đích sử dụng", [
        "Chúng tôi sử dụng thông tin của quý khách để xử lý và xác nhận đặt phòng; làm "
        "thủ tục nhận và trả phòng; xuất hoá đơn và chứng từ; cung cấp dịch vụ trong "
        "thời gian lưu trú; xử lý yêu cầu và phản ánh; cải thiện chất lượng dịch vụ; "
        "gửi thông tin ưu đãi khi quý khách đã đồng ý nhận; và thực hiện nghĩa vụ khai "
        "báo lưu trú theo quy định của pháp luật Việt Nam.",
    ]),
    B.section("4. Cơ sở pháp lý", [
        "Việc xử lý dữ liệu dựa trên: sự đồng ý của quý khách; việc thực hiện hợp đồng "
        "lưu trú giữa quý khách và khách sạn; nghĩa vụ pháp lý của khách sạn (đặc biệt "
        "là quy định về khai báo tạm trú cho khách lưu trú); và lợi ích hợp pháp của "
        "khách sạn trong việc bảo đảm an ninh và chất lượng dịch vụ.",
    ]),
    B.section("5. Chia sẻ thông tin", [
        "Chúng tôi <strong>không bán, không cho thuê và không trao đổi</strong> thông "
        "tin cá nhân của quý khách với bên thứ ba vì mục đích thương mại.",
        "Thông tin chỉ được chia sẻ trong phạm vi cần thiết với: đơn vị xử lý thanh "
        "toán; các kênh và đại lý đặt phòng mà quý khách đã sử dụng để đặt; đơn vị "
        "cung cấp dịch vụ kỹ thuật cho website; và cơ quan nhà nước có thẩm quyền khi "
        "có yêu cầu hợp pháp.",
    ]),
    B.section("6. Bảo mật và thời gian lưu trữ", [
        "Dữ liệu được lưu trên hệ thống có kiểm soát truy cập, chỉ nhân sự có trách "
        "nhiệm mới được phép tiếp cận. Website sử dụng kết nối mã hoá HTTPS.",
        "Chúng tôi chỉ giữ dữ liệu trong thời gian cần thiết cho các mục đích nêu trên, "
        "hoặc trong thời hạn mà pháp luật về lưu trú, kế toán và thuế yêu cầu.",
    ]),
    B.section("7. Quyền của quý khách", [
        "Quý khách có quyền yêu cầu truy cập, chỉnh sửa hoặc xoá thông tin cá nhân; "
        "yêu cầu ngừng xử lý dữ liệu; và rút lại sự đồng ý nhận thông tin tiếp thị bất "
        "cứ lúc nào. Mọi yêu cầu xin gửi về <strong>" + EMAIL_INFO + "</strong>; chúng "
        "tôi phản hồi trong vòng 30 ngày.",
    ]),
    B.section("8. Cookie", [
        "Website sử dụng cookie để ghi nhớ tuỳ chọn ngôn ngữ, giữ phiên đăng nhập và "
        "đo lường lượt truy cập nhằm cải thiện trải nghiệm. Quý khách có thể tắt cookie "
        "trong cài đặt trình duyệt, nhưng một số chức năng như đặt phòng trực tuyến có "
        "thể hoạt động không đầy đủ.",
    ]),
    B.section("9. Trẻ em", [
        "Website không hướng tới trẻ em dưới 16 tuổi và chúng tôi không chủ động thu "
        "thập dữ liệu của trẻ em. Thông tin của trẻ em đi cùng chỉ được ghi nhận qua "
        "cha mẹ hoặc người giám hộ khi làm thủ tục nhận phòng.",
    ]),
    B.section("10. Thay đổi chính sách", [
        "Chúng tôi có thể cập nhật chính sách này khi cần. Bản mới nhất luôn được đăng "
        "tại trang này kèm ngày cập nhật.",
    ]),
    B.cta("Câu hỏi về quyền riêng tư",
          "Liên hệ bộ phận phụ trách dữ liệu của khách sạn.",
          [(EMAIL_INFO, "mailto:" + EMAIL_INFO), ("(0254) 7305 779", "tel:02547305779")]),
    B.note(UPDATED_VI),
)

PRIVACY_EN = B.container(
    B.hero(None, "Legal", "Privacy Policy",
           "The Malibu Hotel respects and is committed to protecting your personal "
           "information. This policy explains how we collect, use, store and safeguard "
           "your data."),
    B.section("1. Scope", [
        "This policy covers www.malibuhotel.com.vn and all services provided by Nguyen "
        "Ha Tourism Service Trading Co., Ltd at The Malibu Hotel, 263 Le Hong Phong "
        "Street, Thang Tam Ward, Vung Tau City.",
        "By making a reservation, using our services or visiting our website, you "
        "agree to the terms set out here.",
    ]),
    B.section("2. Information we collect", []),
    B.definitions([
        ("Identity information", "Name, date of birth, nationality and passport or ID "
                                 "card number — collected at check-in as required by "
                                 "residency-declaration rules."),
        ("Contact information", "Phone number, email address and postal address."),
        ("Reservation information", "Arrival and departure dates, room type, number of "
                                    "guests, special requests and stay history."),
        ("Payment information", "Card details or transfer records used to guarantee "
                                "and settle your booking. We do not store full card "
                                "numbers on our systems."),
        ("Technical data", "IP address, browser type, device and the pages you view on "
                           "our website."),
    ]),
    B.section("3. How we use it", [
        "We use your information to process and confirm reservations; handle check-in "
        "and check-out; issue invoices and receipts; deliver services during your stay; "
        "handle requests and complaints; improve our service; send offers where you "
        "have consented; and meet the residency-declaration obligations required by "
        "Vietnamese law.",
    ]),
    B.section("4. Legal basis", [
        "We process data on the basis of your consent; performance of the accommodation "
        "contract between you and the hotel; the hotel's legal obligations (in "
        "particular temporary-residence declaration for guests); and the hotel's "
        "legitimate interest in maintaining security and service quality.",
    ]),
    B.section("5. Sharing", [
        "We <strong>do not sell, rent or trade</strong> your personal information to "
        "third parties for commercial purposes.",
        "Data is shared only as far as necessary with: payment processors; the booking "
        "channels or agents you used to reserve; technical service providers for our "
        "website; and competent state authorities on lawful request.",
    ]),
    B.section("6. Security and retention", [
        "Data is held on access-controlled systems, reachable only by staff who need "
        "it. Our website uses encrypted HTTPS connections.",
        "We keep data only as long as needed for the purposes above, or for the period "
        "required by residency, accounting and tax law.",
    ]),
    B.section("7. Your rights", [
        "You may request access to, correction of, or deletion of your personal data; "
        "ask us to stop processing it; and withdraw consent to marketing at any time. "
        "Please write to <strong>" + EMAIL_INFO + "</strong> — we respond within "
        "30 days.",
    ]),
    B.section("8. Cookies", [
        "Our website uses cookies to remember your language preference, keep you signed "
        "in and measure visits so we can improve the experience. You can disable "
        "cookies in your browser, though some features such as online booking may not "
        "work fully.",
    ]),
    B.section("9. Children", [
        "Our website is not directed at children under 16 and we do not knowingly "
        "collect their data. Information about accompanying children is recorded only "
        "through a parent or guardian at check-in.",
    ]),
    B.section("10. Changes to this policy", [
        "We may update this policy from time to time. The current version is always "
        "published on this page with its date.",
    ]),
    B.cta("Privacy questions",
          "Contact the hotel team responsible for personal data.",
          [(EMAIL_INFO, "mailto:" + EMAIL_INFO), ("(0254) 7305 779", "tel:02547305779")]),
    B.note(UPDATED_EN),
)


# ══════════════════════════════════════════════════════ 13. Điều khoản
TERMS_VI = B.container(
    B.hero(None, "Pháp lý", "Điều khoản và điều kiện",
           "Các điều khoản áp dụng khi quý khách đặt phòng, lưu trú hoặc sử dụng dịch "
           "vụ của The Malibu Hotel."),
    B.section("1. Định nghĩa", []),
    B.definitions([
        ("Khách sạn", "The Malibu Hotel, do Công ty TNHH Thương mại Dịch vụ Du lịch "
                      "Nguyên Hà vận hành, địa chỉ 263 Lê Hồng Phong, phường Thắng Tam, "
                      "thành phố Vũng Tàu."),
        ("Quý khách", "Cá nhân hoặc tổ chức đặt phòng, lưu trú hoặc sử dụng dịch vụ "
                      "của khách sạn."),
        ("Đặt phòng", "Yêu cầu lưu trú đã được khách sạn xác nhận bằng thư xác nhận "
                      "hoặc mã đặt phòng."),
        ("Giá phòng", "Số tiền cho mỗi đêm lưu trú theo hạng phòng và điều kiện giá "
                      "được nêu trong thư xác nhận."),
    ]),
    B.section("2. Đặt phòng và thanh toán", [
        "Đặt phòng chỉ có hiệu lực sau khi khách sạn gửi thư xác nhận. Khách sạn có "
        "thể yêu cầu thông tin thẻ tín dụng hoặc tiền đặt cọc để đảm bảo giữ phòng.",
        "Giá phòng niêm yết bằng đồng Việt Nam. Trừ khi có ghi chú khác, giá chưa bao "
        "gồm thuế giá trị gia tăng và phí phục vụ. Các khoản phát sinh trong thời gian "
        "lưu trú được thanh toán khi trả phòng.",
    ]),
    B.section("3. Nhận phòng và trả phòng", [
        "Nhận phòng từ <strong>14:00</strong>, trả phòng trước <strong>12:00</strong>. "
        "Nhận phòng sớm hoặc trả phòng muộn tuỳ thuộc tình trạng phòng trống tại thời "
        "điểm đó và có thể phát sinh phụ thu.",
        "Quý khách vui lòng xuất trình hộ chiếu (khách quốc tế) hoặc CMND/CCCD (khách "
        "Việt Nam) còn hiệu lực khi làm thủ tục, theo quy định về khai báo lưu trú.",
    ]),
    B.section("4. Huỷ và thay đổi", [
        "Điều kiện huỷ và thay đổi phụ thuộc vào loại giá đã đặt và được nêu rõ trong "
        "thư xác nhận đặt phòng. Với các mức giá không hoàn huỷ, khách sạn không hoàn "
        "tiền trong mọi trường hợp huỷ.",
        "Trường hợp quý khách không đến và không thông báo trước (no-show), khách sạn "
        "có thể thu phí tương đương một đêm lưu trú.",
    ]),
    B.section("5. Số lượng khách và trẻ em", [
        "Số người lưu trú phải đúng theo hạng phòng đã đặt. Phụ thu áp dụng cho khách "
        "thêm người. Trẻ em đi cùng cha mẹ được áp dụng chính sách riêng của khách sạn "
        "tại từng thời điểm; vui lòng liên hệ bộ phận đặt phòng để biết chi tiết.",
    ]),
    B.section("6. Nội quy khách sạn", [
        "Không hút thuốc trong phòng nghỉ; vui lòng sử dụng ban công hoặc khu vực quy "
        "định. Không mang theo vật nuôi. Không mang chất cháy nổ, vũ khí hoặc thực phẩm "
        "có mùi nồng vào phòng.",
        "Vui lòng giữ yên tĩnh sau 22:00 để tôn trọng các khách lưu trú khác. Quý khách "
        "chịu trách nhiệm bồi thường đối với thiệt hại gây ra cho tài sản của khách sạn.",
    ]),
    B.section("7. Tài sản và trách nhiệm", [
        "Mỗi phòng đều được trang bị két sắt; khách sạn có an ninh và lễ tân trực 24/7. "
        "Khách sạn không chịu trách nhiệm đối với tiền mặt, trang sức và tài sản có giá "
        "trị không được cất trong két sắt hoặc không ký gửi tại quầy lễ tân.",
        "Khách sạn không chịu trách nhiệm với các gián đoạn dịch vụ do sự kiện bất khả "
        "kháng như thiên tai, mất điện diện rộng hoặc quyết định của cơ quan nhà nước.",
    ]),
    B.section("8. Sử dụng website", [
        "Toàn bộ nội dung, hình ảnh và thương hiệu trên website thuộc quyền sở hữu của "
        "khách sạn, không được sao chép hoặc sử dụng cho mục đích thương mại nếu chưa "
        "có sự đồng ý bằng văn bản.",
    ]),
    B.section("9. Luật áp dụng", [
        "Các điều khoản này được điều chỉnh bởi pháp luật Việt Nam. Mọi tranh chấp sẽ "
        "được ưu tiên giải quyết bằng thương lượng; nếu không đạt được thoả thuận, "
        "tranh chấp sẽ được đưa ra toà án có thẩm quyền tại tỉnh Bà Rịa - Vũng Tàu.",
    ]),
    B.cta("Cần làm rõ điều khoản nào?",
          "Bộ phận đặt phòng của khách sạn sẵn sàng giải thích chi tiết.",
          [(EMAIL_RES, "mailto:" + EMAIL_RES), ("(0254) 7305 779", "tel:02547305779")]),
    B.note(UPDATED_VI),
)

TERMS_EN = B.container(
    B.hero(None, "Legal", "Terms and Conditions",
           "The terms that apply when you book, stay or use the services of "
           "The Malibu Hotel."),
    B.section("1. Definitions", []),
    B.definitions([
        ("The hotel", "The Malibu Hotel, operated by Nguyen Ha Tourism Service Trading "
                      "Co., Ltd, at 263 Le Hong Phong Street, Thang Tam Ward, "
                      "Vung Tau City."),
        ("You / the guest", "The individual or organisation booking, staying or using "
                            "the hotel's services."),
        ("Reservation", "A stay request confirmed by the hotel through a confirmation "
                        "letter or booking reference."),
        ("Room rate", "The amount charged per night for the room type and rate "
                      "conditions stated in your confirmation."),
    ]),
    B.section("2. Reservations and payment", [
        "A reservation takes effect only once the hotel issues a confirmation. The "
        "hotel may request credit card details or a deposit to guarantee the booking.",
        "Rates are quoted in Vietnamese dong. Unless stated otherwise, they exclude "
        "value added tax and service charge. Charges incurred during your stay are "
        "settled at check-out.",
    ]),
    B.section("3. Check-in and check-out", [
        "Check-in from <strong>14:00</strong>, check-out before <strong>12:00</strong>. "
        "Early check-in and late check-out depend on availability at the time and may "
        "incur a surcharge.",
        "Please present a valid passport (international guests) or ID card (Vietnamese "
        "guests) at check-in, as required by residency-declaration rules.",
    ]),
    B.section("4. Cancellation and amendment", [
        "Cancellation and amendment conditions depend on the rate booked and are stated "
        "in your confirmation. Non-refundable rates are not refunded under any "
        "cancellation.",
        "If you do not arrive and have not notified us (no-show), the hotel may charge "
        "the equivalent of one night's stay.",
    ]),
    B.section("5. Occupancy and children", [
        "The number of guests must match the room type booked. Surcharges apply for "
        "extra guests. Children accompanying their parents are subject to the hotel's "
        "policy in force at the time; please contact reservations for details.",
    ]),
    B.section("6. House rules", [
        "No smoking in guest rooms; please use the balcony or designated areas. No "
        "pets. No flammables, weapons or strong-smelling food in the rooms.",
        "Please keep noise down after 22:00 out of respect for other guests. You are "
        "responsible for any damage caused to hotel property.",
    ]),
    B.section("7. Belongings and liability", [
        "Every room has a safe, and the hotel maintains security and front desk cover "
        "24/7. The hotel accepts no liability for cash, jewellery or valuables not kept "
        "in the in-room safe or deposited at reception.",
        "The hotel is not liable for service interruptions caused by force majeure such "
        "as natural disaster, wide-area power failure or decisions of state authorities.",
    ]),
    B.section("8. Use of this website", [
        "All content, images and branding on this website belong to the hotel and may "
        "not be copied or used commercially without written consent.",
    ]),
    B.section("9. Governing law", [
        "These terms are governed by the laws of Vietnam. Disputes will first be "
        "addressed through negotiation; failing agreement, they will be referred to "
        "the competent court in Ba Ria - Vung Tau province.",
    ]),
    B.cta("Need a term clarified?",
          "Our reservations team is happy to explain the details.",
          [(EMAIL_RES, "mailto:" + EMAIL_RES), ("(0254) 7305 779", "tel:02547305779")]),
    B.note(UPDATED_EN),
)


# id trang -> (nội dung VI, nội dung EN)
CONTENT = {
    5: (ABOUT_VI, ABOUT_EN),
    8: (FAQ_VI, FAQ_EN),
    12: (PRIVACY_VI, PRIVACY_EN),
    13: (TERMS_VI, TERMS_EN),
    19: (GROUP_VI, GROUP_EN),
    22: (CAREERS_VI, CAREERS_EN),
}
