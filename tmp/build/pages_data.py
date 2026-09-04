# -*- coding: utf-8 -*-
"""Nội dung trang tĩnh, menu và slider cho The Malibu Hotel."""

CDN = "https://malibuhotel.com.vn"
HDR = CDN + "/files/sites/site_70/site_70_header/"
SITE = CDN + "/files/sites/70/"
BLOG = CDN + "/files/blog/46_1815/"
G1 = CDN + "/files/sites/site_70/site_70_gallery_muc1/"
G4 = CDN + "/files/sites/site_70/site_70_gallery_muc4/"

HOTLINE = "0941 871 644"
EMAIL = "res@malibuhotel.com.vn"
ADDRESS_VI = "263 Lê Hồng Phong, P. Thắng Tam, TP. Vũng Tàu, Bà Rịa - Vũng Tàu"
ADDRESS_EN = ("263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City, "
              "Ba Ria - Vung Tau Province, Vietnam")


def sc(name, **attrs):
    """Sinh một shortcode của theme riorelax."""
    parts = " ".join('%s="%s"' % (k.replace("_", "-") if k.startswith("data_") else k, v)
                     for k, v in attrs.items() if v is not None)
    body = "[%s%s][/%s]" % (name, (" " + parts) if parts else "", name)
    return "<shortcode>%s</shortcode>" % body


# --------------------------------------------------------------- Trang chủ
HOME_VI = "".join([
    sc("simple-slider", key="TRANG BÌA"),
    sc("check-availability-form"),
    sc("about-us",
       subtitle="The Malibu Hotel",
       title="Live Beautifully – Sống trọn từng khoảnh khắc",
       description=(
           "The Malibu Hotel toạ lạc tại 263 Lê Hồng Phong, ngay trung tâm thành phố "
           "biển Vũng Tàu. Đi vào hoạt động từ tháng 4/2016, khách sạn là toà nhà 23 tầng "
           "gồm 2 tầng hầm và 6 tầng dịch vụ, với tổng cộng 197 phòng nghỉ. Kiến trúc lấy "
           "cảm hứng từ châu Âu sang trọng và hiện đại; tất cả phòng đều có tầm nhìn hướng "
           "ra đại dương và ôm trọn một phần thành phố Vũng Tàu."),
       highlights="197 phòng nghỉ hướng biển ; Toà nhà 23 tầng, 6 tầng dịch vụ ; "
                  "Lễ tân và an ninh phục vụ 24/7",
       style="style-1",
       top_left_image=SITE + "DSC00316.jpg"),
    sc("service-list", limit="6"),
    sc("featured-rooms",
       subtitle="Các hạng phòng",
       title="Phòng nghỉ &amp; Suite tại Malibu",
       description=(
           "197 phòng nghỉ trải trên 4 hạng Premier, Diamond, Suite và President – "
           "từ phòng 40 m² hướng thành phố và biển đến Presidential Suite 250 m² "
           "với tầm nhìn toàn cảnh Vũng Tàu."),
       room_ids="2,5,6,7,8,10"),
    sc("feature-area",
       subtitle="Hội nghị &amp; Sự kiện",
       title="7 phòng hội nghị, sức chứa tới 450 khách",
       description=(
           "Phòng Malibu Grand có thể ngăn thành 3 phòng nhỏ 120 khách mỗi phòng. "
           "Âm thanh chuẩn quốc tế, màn hình LED và máy chiếu hiện đại, nội thất cao cấp, "
           "cùng đội ngũ hỗ trợ kỹ thuật chuyên nghiệp và các gói tiệc linh hoạt."),
       image=HDR + "conference-header.jpg",
       button_primary_label="TÌM HIỂU THÊM",
       button_primary_url="/hoi-nghi-su-kien"),
    sc("booking-form",
       subtitle="Đặt phòng ngay",
       title="Kỳ nghỉ của bạn bắt đầu tại Malibu",
       image=SITE + "DSC00703.jpg"),
])

HOME_EN = "".join([
    sc("simple-slider", key="TRANG BÌA"),
    sc("check-availability-form"),
    sc("about-us",
       subtitle="The Malibu Hotel",
       title="Live Beautifully",
       description=(
           "The Malibu Hotel stands at 263 Le Hong Phong Street, in the heart of the "
           "coastal city of Vung Tau. Opened in April 2016, the hotel is a 23-storey tower "
           "with two basement levels and six service floors, offering 197 guest rooms. "
           "Its architecture draws on luxurious, modern European design, and every room "
           "looks out over the ocean and part of the Vung Tau cityscape."),
       highlights="197 ocean-view rooms ; 23-storey tower with 6 service floors ; "
                  "24/7 front desk and security",
       style="style-1",
       top_left_image=SITE + "DSC00316.jpg"),
    sc("service-list", limit="6"),
    sc("featured-rooms",
       subtitle="Rooms &amp; Suites",
       title="Rooms &amp; Suites at Malibu",
       description=(
           "197 guest rooms across four categories – Premier, Diamond, Suite and "
           "President – from 40 sqm rooms facing the city and the sea to the 250 sqm "
           "Presidential Suite with panoramic views over Vung Tau."),
       room_ids="2,5,6,7,8,10"),
    sc("feature-area",
       subtitle="Meetings &amp; Events",
       title="Seven conference rooms for up to 450 guests",
       description=(
           "The Malibu Grand room can be divided into three rooms of 120 guests each. "
           "International-standard sound systems, modern LED screens and projectors, "
           "high-class interiors, professional technical support and flexible catering "
           "packages."),
       image=HDR + "conference-header.jpg",
       button_primary_label="LEARN MORE",
       button_primary_url="/en/hoi-nghi-su-kien"),
    sc("booking-form",
       subtitle="Book now",
       title="Your stay begins at Malibu",
       image=SITE + "DSC00703.jpg"),
])


def article(blocks):
    out = ['<div class="about-area5 about-p p-relative">',
           '<div class="container pt-60 pb-90">',
           '<div class="service-detail"><div class="content-box">']
    for head, body in blocks:
        if head:
            out.append("<h2>%s</h2>" % head)
        if body:
            out.append("<p>%s</p>" % body)
    out.append("</div></div></div></div>")
    return "".join(out)


# --------------------------------------------------------------- Về chúng tôi
ABOUT_VI = "".join([
    article([
        ("Về The Malibu Hotel",
         "Khách sạn Malibu đi vào hoạt động tháng 4/2016 với cơ cấu toà nhà 23 tầng gồm "
         "2 tầng hầm và 6 tầng dịch vụ – trong đó có sảnh hội nghị/tiệc, spa, pool bar, "
         "hồ bơi, phòng gym, khu giải trí – cùng khu lưu trú với tổng số 197 phòng nghỉ."),
        ("Kiến trúc",
         "Khách sạn được thiết kế từ nguồn cảm hứng kiến trúc châu Âu sang trọng, hiện đại. "
         "Tất cả các phòng tại khách sạn đều có tầm nhìn hướng ra đại dương và một phần "
         "ôm trọn thành phố Vũng Tàu xinh đẹp."),
        ("Tầm nhìn",
         "Tầm nhìn của khách sạn trong 5 năm tới là mở rộng thành một chuỗi khách sạn tại "
         "miền Đông Nam Bộ, với giá trị cốt lõi là đội ngũ nhân sự tâm huyết yêu nghề và "
         "hệ thống quản trị chuyên nghiệp."),
    ]),
    sc("why-choose-us",
       subtitle="Vì sao chọn Malibu",
       title="Những điều làm nên The Malibu Hotel",
       description="Kiến trúc châu Âu hiện đại, dịch vụ đạt chuẩn quốc tế và "
                   "vị trí ngay trung tâm thành phố biển Vũng Tàu.",
       right_image=G1 + "DSC00703.jpg",
       background_color="#16192C"),
    sc("hotel-places", limit="6"),
])

ABOUT_EN = "".join([
    article([
        ("About The Malibu Hotel",
         "The Malibu Hotel opened in April 2016 as a 23-storey tower with two basement "
         "levels and six service floors – housing conference and banquet halls, a spa, "
         "a pool bar, the swimming pool, a gym and an entertainment area – alongside "
         "197 guest rooms."),
        ("Architecture",
         "The hotel is designed from an inspiration of luxurious, modern European "
         "architecture. Every room looks out over the ocean and embraces part of the "
         "beautiful city of Vung Tau."),
        ("Vision",
         "Over the next five years the hotel intends to grow into a chain across the "
         "south-east of Vietnam, built on core values of a dedicated team and a "
         "professional management system."),
    ]),
    sc("why-choose-us",
       subtitle="Why Malibu",
       title="What makes The Malibu Hotel",
       description="Modern European architecture, international-standard service and "
                   "a location in the heart of the coastal city of Vung Tau.",
       right_image=G1 + "DSC00703.jpg",
       background_color="#16192C"),
    sc("hotel-places", limit="6"),
])

# --------------------------------------------------------------- Tiện ích
FACILITIES_VI = "".join([
    sc("service-list", limit="12"),
    sc("featured-amenities",
       subtitle="Tiện nghi trong phòng",
       title="Tiện nghi tiêu chuẩn tại mọi hạng phòng",
       description="Điều hoà, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt, "
                   "minibar, ấm đun nước cùng trà và cà phê, bộ đồ dùng phòng tắm cao cấp."),
    sc("newsletter",
       subtitle="Bản tin",
       title="Nhận ưu đãi mới nhất từ Malibu",
       description="Đăng ký để luôn được cập nhật thông tin và chương trình ưu đãi mới nhất.",
       background_color="#F7F5F1"),
])

FACILITIES_EN = "".join([
    sc("service-list", limit="12"),
    sc("featured-amenities",
       subtitle="In-room amenities",
       title="Standard amenities in every room category",
       description="Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, "
                   "in-room safe, minibar, kettle with tea and coffee, and premium "
                   "bathroom amenities."),
    sc("newsletter",
       subtitle="Newsletter",
       title="Get the latest offers from Malibu",
       description="Subscribe to stay up to date with our news and latest offers.",
       background_color="#F7F5F1"),
])

# --------------------------------------------------------------- Ẩm thực
DINE_VI = "".join([
    article([
        ("Nhà hàng &amp; Giải trí tại The Malibu Hotel",
         "Tận hưởng trải nghiệm ẩm thực tuyệt vời tại các nhà hàng của Malibu. "
         "Hãy khám phá Vela Restaurant và Carina Restaurant &amp; Entertainment – nơi "
         "hương vị tinh tế hoà quyện cùng không gian sang trọng, mang đến những khoảnh "
         "khắc đáng nhớ."),
    ]),
    sc("feature-area",
       subtitle="Tầng 3",
       title="Vela Restaurant",
       description="Buffet sáng hơn 40 món Á – Âu, sức chứa 350 khách, phục vụ à la carte, "
                   "buffet và tiệc Gala. Buffet sáng 06:30 – 10:00, tiệc 11:00 – 22:00.",
       image=BLOG + "Anh_1_4_1.jpg",
       button_primary_label="CHI TIẾT",
       button_primary_url="/services/vela-restaurant"),
    sc("feature-area",
       subtitle="Tầng 6",
       title="Carina Restaurant",
       description="Ẩm thực giao thoa Âu – Á với tầm nhìn đặc biệt, sức chứa 60 khách và "
                   "phòng VIP 20 khách. Phục vụ hằng ngày 11:00 – 22:00.",
       image=BLOG + "CARINA-MALIBU_HOTEL_1.jpg",
       button_primary_label="CHI TIẾT",
       button_primary_url="/services/carina-restaurant"),
    sc("feature-area",
       subtitle="Sảnh khách sạn",
       title="The Lux Café",
       description="Quán cà phê thiết kế như một góc phố Milan, có cây đàn piano nơi sảnh. "
                   "Phục vụ hằng ngày 07:00 – 22:00.",
       image=BLOG + "800x600_1__1.png",
       button_primary_label="CHI TIẾT",
       button_primary_url="/services/the-lux-cafe"),
])

DINE_EN = "".join([
    article([
        ("Dining &amp; Entertainment at The Malibu Hotel",
         "Enjoy a remarkable culinary experience at Malibu's restaurants. Discover Vela "
         "Restaurant and Carina Restaurant &amp; Entertainment, where refined flavours meet "
         "elegant surroundings for moments worth remembering."),
    ]),
    sc("feature-area",
       subtitle="3rd floor",
       title="Vela Restaurant",
       description="A breakfast buffet of more than 40 Asian and European dishes, seating "
                   "350 guests, serving à la carte, buffet and gala. Breakfast buffet "
                   "6:30 – 10:00 am, banquet 11:00 am – 10:00 pm.",
       image=BLOG + "Anh_1_4_1.jpg",
       button_primary_label="DETAILS",
       button_primary_url="/en/services/vela-restaurant"),
    sc("feature-area",
       subtitle="6th floor",
       title="Carina Restaurant",
       description="European-Asian fusion cuisine with an extraordinary view, seating "
                   "60 guests plus a 20-seat VIP room. Open daily 11:00 am – 10:00 pm.",
       image=BLOG + "CARINA-MALIBU_HOTEL_1.jpg",
       button_primary_label="DETAILS",
       button_primary_url="/en/services/carina-restaurant"),
    sc("feature-area",
       subtitle="Hotel lobby",
       title="The Lux Café",
       description="A café designed like a corner of a Milan street, with a piano in the "
                   "lobby. Open daily 7:00 am – 10:00 pm.",
       image=BLOG + "800x600_1__1.png",
       button_primary_label="DETAILS",
       button_primary_url="/en/services/the-lux-cafe"),
])

# --------------------------------------------------------------- Hội nghị
CONFERENCE_VI = article([
    ("Hội nghị &amp; Sự kiện",
     "The Malibu Hotel có 7 phòng hội nghị với sức chứa lên đến 450 khách. Phòng Malibu "
     "Grand có thể ngăn thành 3 phòng nhỏ, mỗi phòng 120 khách, bằng hệ thống vách ngăn "
     "linh hoạt."),
    ("Trang thiết bị",
     "Hệ thống âm thanh chuẩn quốc tế, màn hình LED và máy chiếu hiện đại, nội thất cao "
     "cấp – sẵn sàng đáp ứng mọi nhu cầu của quý khách. Chúng tôi cung cấp dịch vụ hỗ trợ "
     "kỹ thuật chuyên nghiệp cùng các gói thiết bị và tiệc linh hoạt."),
    ("Tiệc cưới",
     "Từ tiệc cưới ấm cúng đến đại tiệc, đội ngũ của Malibu đồng hành cùng bạn trong từng "
     "chi tiết: thực đơn, trang trí, âm thanh ánh sáng và sơ đồ tiệc. Không gian tiệc linh "
     "hoạt, phục vụ từ 50 đến 450 khách."),
    ("Liên hệ",
     "Điện thoại: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn"),
])

CONFERENCE_EN = article([
    ("Meetings &amp; Events",
     "The Malibu Hotel has seven conference rooms for up to 450 guests. The Malibu Grand "
     "room can be separated into three smaller rooms of 120 guests each by a flexible "
     "partition system."),
    ("Facilities",
     "International-standard sound systems, modern LED screens and projectors and "
     "high-class interiors are ready to meet every need. We also provide professional "
     "technical support and flexible equipment and catering packages."),
    ("Weddings",
     "From an intimate wedding to a grand celebration, the Malibu team works with you on "
     "every detail: menu, decoration, sound and lighting, and the floor plan. Our flexible "
     "event spaces host from 50 to 450 guests."),
    ("Contact",
     "Phone: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn"),
])

# --------------------------------------------------------------- Tuyển dụng
CAREERS_VI = article([
    ("Tuyển dụng tại The Malibu Hotel",
     "Giá trị cốt lõi của Malibu là đội ngũ nhân sự tâm huyết, yêu nghề và một hệ thống "
     "quản trị chuyên nghiệp. Chúng tôi luôn tìm kiếm những cộng sự cùng chia sẻ tinh thần "
     "\"Live Beautifully\" cho các bộ phận: tiền sảnh, buồng phòng, ẩm thực, bếp, kỹ thuật, "
     "kinh doanh và spa."),
    ("Nộp hồ sơ",
     "Gửi hồ sơ về địa chỉ email tuyendung@malibuhotel.com.vn hoặc liên hệ trực tiếp "
     "số điện thoại (0254) 3 523 523."),
])

CAREERS_EN = article([
    ("Careers at The Malibu Hotel",
     "Malibu's core value is a dedicated team supported by a professional management "
     "system. We are always looking for colleagues who share the \"Live Beautifully\" "
     "spirit across front office, housekeeping, food and beverage, kitchen, engineering, "
     "sales and spa."),
    ("How to apply",
     "Please send your application to tuyendung@malibuhotel.com.vn or call "
     "(0254) 3 523 523."),
])

# --------------------------------------------------------------- Malibu Group
GROUP_VI = article([
    ("Malibu Group",
     "Bên cạnh The Malibu Hotel Vũng Tàu, Malibu Group còn phát triển các sản phẩm lưu trú "
     "khác trong khu vực miền Đông Nam Bộ."),
    ("The Malibu House", "Mô hình lưu trú nhỏ gọn, ấm cúng."),
    ("The Malibu Hotel Sài Gòn", "Khách sạn của Malibu tại Thành phố Hồ Chí Minh."),
    ("The Malibu Villa Long Cung", "Villa nghỉ dưỡng tại khu Long Cung, Vũng Tàu."),
    ("Sanctuary Villa Hồ Tràm", "Villa nghỉ dưỡng ven biển tại Hồ Tràm."),
])

GROUP_EN = article([
    ("Malibu Group",
     "Alongside The Malibu Hotel Vung Tau, Malibu Group develops other hospitality "
     "products across south-east Vietnam."),
    ("The Malibu House", "A compact, welcoming accommodation concept."),
    ("The Malibu Hotel Sai Gon", "Malibu's hotel in Ho Chi Minh City."),
    ("The Malibu Villa Long Cung", "A resort villa in the Long Cung area of Vung Tau."),
    ("Sanctuary Villa Ho Tram", "A beachfront resort villa in Ho Tram."),
])

# --------------------------------------------------------------- Liên hệ
CONTACT_VI = "".join([
    sc("contact-form",
       display_fields="phone,email,subject,address",
       mandatory_fields="phone,email",
       title="Gửi tin nhắn cho chúng tôi",
       button_label="Gửi",
       address_icon="far fa-map", address_label="Địa chỉ", address_detail=ADDRESS_VI,
       email_icon="far fa-envelope-open", email_label="Email", email_detail=EMAIL,
       phone_icon="far fa-phone", phone_label="Hotline", phone_detail=HOTLINE),
    article([
        ("The Malibu Hotel",
         "Công ty TNHH Thương mại Dịch vụ Du lịch Nguyên Hà<br>" + ADDRESS_VI),
        ("Văn phòng kinh doanh tại TP. Hồ Chí Minh",
         "353 - 355 Đường số 1, P. Bình Trị Đông, Q. Bình Tân, TP. Hồ Chí Minh"),
        ("Liên hệ",
         "Tổng đài khách sạn: (0254) 7305 779<br>"
         "Hotline đặt phòng: 0941 871 644<br>"
         "Email đặt phòng: res@malibuhotel.com.vn<br>"
         "Website: www.malibuhotel.com.vn"),
        ("Email theo bộ phận",
         "Đặt phòng: res@malibuhotel.com.vn<br>"
         "Giám đốc kinh doanh: dos@malibuhotel.com.vn<br>"
         "Thông tin chung: info@malibuhotel.com.vn<br>"
         "Quản lý vận hành: om@malibuhotel.com.vn<br>"
         "Quản lý tiền sảnh: fom@malibuhotel.com.vn<br>"
         "Quản lý buồng phòng: hskm@malibuhotel.com.vn"),
    ]),
])

CONTACT_EN = "".join([
    sc("contact-form",
       display_fields="phone,email,subject,address",
       mandatory_fields="phone,email",
       title="Send us a message",
       button_label="Send",
       address_icon="far fa-map", address_label="Address", address_detail=ADDRESS_EN,
       email_icon="far fa-envelope-open", email_label="Email", email_detail=EMAIL,
       phone_icon="far fa-phone", phone_label="Hotline", phone_detail="(+84) 941 871 644"),
    article([
        ("The Malibu Hotel",
         "Nguyen Ha Tourism Service Trading Co., Ltd<br>" + ADDRESS_EN),
        ("Sales office in Ho Chi Minh City",
         "353 - 355 No.1 Street, Binh Tri Dong Ward, Binh Tan District, "
         "Ho Chi Minh City"),
        ("Contact",
         "Main hotel: (0254) 7305 779<br>"
         "Reservations hotline: (+84) 941 871 644<br>"
         "Reservations email: res@malibuhotel.com.vn<br>"
         "Website: www.malibuhotel.com.vn"),
        ("Email by department",
         "Room reservations: res@malibuhotel.com.vn<br>"
         "Director of Sales: dos@malibuhotel.com.vn<br>"
         "General information: info@malibuhotel.com.vn<br>"
         "Operation Manager: om@malibuhotel.com.vn<br>"
         "Front Desk Manager: fom@malibuhotel.com.vn<br>"
         "Housekeeping Manager: hskm@malibuhotel.com.vn"),
    ]),
])

# --------------------------------------------------------------- Pháp lý
PRIVACY_VI = article([
    ("Chính sách bảo mật",
     "The Malibu Hotel (Công ty TNHH Thương mại Dịch vụ Du lịch Nguyên Hà) tôn trọng và "
     "cam kết bảo vệ thông tin cá nhân của quý khách. Chính sách này mô tả cách chúng tôi "
     "thu thập, sử dụng và bảo vệ dữ liệu khi quý khách sử dụng website và dịch vụ "
     "của khách sạn."),
    ("Thông tin chúng tôi thu thập",
     "Họ tên, số điện thoại, địa chỉ email, thông tin giấy tờ tuỳ thân khi làm thủ tục "
     "nhận phòng, thông tin đặt phòng và thanh toán, cùng dữ liệu kỹ thuật của trình duyệt "
     "khi quý khách truy cập website."),
    ("Mục đích sử dụng",
     "Xử lý và xác nhận đặt phòng, làm thủ tục nhận và trả phòng, xuất hoá đơn, chăm sóc "
     "khách hàng, gửi thông tin ưu đãi khi quý khách đồng ý, và thực hiện các nghĩa vụ "
     "khai báo lưu trú theo quy định pháp luật Việt Nam."),
    ("Chia sẻ thông tin",
     "Chúng tôi không bán hay cho thuê thông tin cá nhân của quý khách. Thông tin chỉ được "
     "chia sẻ với các đơn vị thanh toán, đối tác đặt phòng và cơ quan nhà nước có thẩm "
     "quyền trong phạm vi cần thiết."),
    ("Bảo mật và lưu trữ",
     "Dữ liệu được lưu trữ trên hệ thống có kiểm soát truy cập và chỉ được giữ trong thời "
     "gian cần thiết cho mục đích đã nêu hoặc theo yêu cầu của pháp luật."),
    ("Quyền của quý khách",
     "Quý khách có quyền yêu cầu truy cập, chỉnh sửa hoặc xoá thông tin cá nhân, và rút "
     "lại sự đồng ý nhận thông tin tiếp thị bất cứ lúc nào bằng cách liên hệ "
     "info@malibuhotel.com.vn."),
    ("Cookie",
     "Website sử dụng cookie để ghi nhớ tuỳ chọn của quý khách và cải thiện trải nghiệm "
     "duyệt web. Quý khách có thể tắt cookie trong cài đặt trình duyệt."),
    ("Liên hệ",
     "Mọi thắc mắc về chính sách bảo mật, vui lòng liên hệ info@malibuhotel.com.vn hoặc "
     "(0254) 7305 779."),
])

PRIVACY_EN = article([
    ("Privacy Policy",
     "The Malibu Hotel (Nguyen Ha Tourism Service Trading Co., Ltd) respects and is "
     "committed to protecting your personal information. This policy describes how we "
     "collect, use and safeguard your data when you use our website and services."),
    ("Information we collect",
     "Name, phone number, email address, identity document details provided at check-in, "
     "reservation and payment information, and technical browser data when you visit "
     "our website."),
    ("How we use it",
     "To process and confirm reservations, handle check-in and check-out, issue invoices, "
     "provide guest services, send offers where you have consented, and meet the "
     "residency-declaration obligations required by Vietnamese law."),
    ("Sharing",
     "We do not sell or rent your personal information. Data is shared only with payment "
     "providers, booking partners and competent state authorities, and only to the extent "
     "necessary."),
    ("Security and retention",
     "Data is stored on access-controlled systems and kept only as long as needed for the "
     "stated purposes or as required by law."),
    ("Your rights",
     "You may request access to, correction of, or deletion of your personal data, and "
     "withdraw consent to marketing communications at any time by contacting "
     "info@malibuhotel.com.vn."),
    ("Cookies",
     "Our website uses cookies to remember your preferences and improve your browsing "
     "experience. You may disable cookies in your browser settings."),
    ("Contact",
     "For any question about this policy, please contact info@malibuhotel.com.vn or "
     "(0254) 7305 779."),
])

TERMS_VI = article([
    ("Điều khoản và điều kiện",
     "Khi đặt phòng hoặc sử dụng dịch vụ của The Malibu Hotel, quý khách đồng ý với các "
     "điều khoản dưới đây."),
    ("Đặt phòng và thanh toán",
     "Đặt phòng chỉ được xác nhận sau khi khách sạn gửi thư xác nhận. Khách sạn có thể yêu "
     "cầu thông tin thẻ tín dụng hoặc tiền đặt cọc để đảm bảo giữ phòng. Giá phòng được "
     "niêm yết bằng VND và chưa bao gồm thuế, phí dịch vụ trừ khi có ghi chú khác."),
    ("Nhận và trả phòng",
     "Nhận phòng từ 14:00 và trả phòng trước 12:00. Nhận phòng sớm hoặc trả phòng muộn "
     "tuỳ thuộc tình trạng phòng trống và có thể phát sinh phụ thu."),
    ("Huỷ và thay đổi",
     "Điều kiện huỷ và thay đổi phụ thuộc vào loại giá đã đặt và được nêu rõ trong thư xác "
     "nhận đặt phòng. Trường hợp khách không đến (no-show), khách sạn có thể thu phí "
     "tương đương một đêm lưu trú."),
    ("Giấy tờ và số lượng khách",
     "Quý khách vui lòng xuất trình hộ chiếu (khách quốc tế) hoặc CMND/CCCD (khách Việt "
     "Nam) còn hiệu lực khi làm thủ tục. Số lượng khách lưu trú phải đúng theo hạng phòng "
     "đã đặt; phụ thu áp dụng cho khách thêm người hoặc trẻ em."),
    ("Nội quy khách sạn",
     "Không hút thuốc trong phòng, không mang vật nuôi, không mang chất cháy nổ, vũ khí "
     "hoặc thực phẩm có mùi nồng vào phòng nghỉ. Quý khách chịu trách nhiệm bồi thường "
     "với thiệt hại gây ra cho tài sản của khách sạn."),
    ("Trách nhiệm",
     "Khách sạn có két sắt trong phòng và an ninh 24/7. Khách sạn không chịu trách nhiệm "
     "với tài sản có giá trị không được ký gửi hoặc cất giữ trong két sắt."),
    ("Luật áp dụng",
     "Các điều khoản này được điều chỉnh bởi pháp luật Việt Nam."),
])

TERMS_EN = article([
    ("Terms and Conditions",
     "By making a reservation or using the services of The Malibu Hotel, you agree to the "
     "terms set out below."),
    ("Reservations and payment",
     "A reservation is confirmed only once the hotel issues a confirmation. The hotel may "
     "request credit card details or a deposit to guarantee the booking. Rates are quoted "
     "in VND and exclude taxes and service charges unless otherwise stated."),
    ("Check-in and check-out",
     "Check-in from 14:00 and check-out before 12:00. Early check-in and late check-out "
     "are subject to availability and may incur a surcharge."),
    ("Cancellation and amendment",
     "Cancellation and amendment conditions depend on the rate booked and are stated in "
     "your confirmation. In the event of a no-show, the hotel may charge the equivalent "
     "of one night's stay."),
    ("Identification and occupancy",
     "Please present a valid passport (international guests) or ID card (Vietnamese "
     "guests) at check-in. Occupancy must match the room type booked; surcharges apply "
     "for extra guests or children."),
    ("House rules",
     "No smoking in guest rooms, no pets, and no flammables, weapons or strong-smelling "
     "food in the rooms. Guests are responsible for any damage caused to hotel property."),
    ("Liability",
     "In-room safes and 24/7 security are provided. The hotel is not liable for valuables "
     "that are not deposited or kept in the in-room safe."),
    ("Governing law",
     "These terms are governed by the laws of Vietnam."),
])

# id, slug VI, slug EN, template, tên VI, tên EN, mô tả VI, mô tả EN, nội dung VI/EN, ảnh
PAGES = [
    (1, "trang-chu", "home", "full-width", "Trang chủ", "Home",
     "The Malibu Hotel Vũng Tàu – Live Beautifully.",
     "The Malibu Hotel Vung Tau – Live Beautifully.",
     HOME_VI, HOME_EN, None),
    (5, "ve-chung-toi", "about-us", "full-width", "Về chúng tôi", "About Us",
     "Lịch sử, kiến trúc và tầm nhìn của The Malibu Hotel.",
     "The history, architecture and vision of The Malibu Hotel.",
     ABOUT_VI, ABOUT_EN, HDR + "about-header.jpg"),
    (6, "tien-nghi-dich-vu", "facilities", "full-width",
     "Tiện nghi &amp; Dịch vụ", "Facilities &amp; Services",
     "M Pool, M Spa, M Gym, Kid Zone, Gift Shop và các tiện ích khác tại Malibu.",
     "M Pool, M Spa, M Gym, the Kid Zone, the Gift Shop and more at Malibu.",
     FACILITIES_VI, FACILITIES_EN, HDR + "entertainment-header.jpg"),
    (7, "thu-vien-anh", "gallery", "full-width", "Thư viện ảnh", "Gallery",
     "Hình ảnh khách sạn, phòng nghỉ, nhà hàng, hồ bơi và khu giải trí.",
     "Photos of the hotel, rooms, restaurants, pool and entertainment areas.",
     sc("galleries", limit="12"), sc("galleries", limit="12"),
     HDR + "malibu-group-header.jpg"),
    (8, "cau-hoi-thuong-gap", "hotel-faqs", "full-width",
     "Câu hỏi thường gặp", "Hotel FAQs",
     "Những câu hỏi thường gặp về lưu trú tại The Malibu Hotel.",
     "Frequently asked questions about staying at The Malibu Hotel.",
     sc("faqs", category_ids="1,2,3,4,5"), sc("faqs", category_ids="1,2,3,4,5"),
     HDR + "faqs-header.jpg"),
    (9, "am-thuc", "dine", "full-width", "Ẩm thực", "Dine",
     "Vela Restaurant, Carina Restaurant và The Lux Café.",
     "Vela Restaurant, Carina Restaurant and The Lux Café.",
     DINE_VI, DINE_EN, HDR + "restaurant-header.jpg"),
    (10, "tin-tuc", "news", "blog-sidebar", "Tin tức", "News",
     "Tin tức, ưu đãi và sự kiện tại The Malibu Hotel.",
     "News, offers and events at The Malibu Hotel.",
     sc("blog-posts", paginate="12"), sc("blog-posts", paginate="12"),
     HDR + "banquet-header.jpg"),
    (11, "lien-he", "contact", "full-width", "Liên hệ", "Contact",
     "Địa chỉ, hotline và email của The Malibu Hotel Vũng Tàu.",
     "Address, hotline and email for The Malibu Hotel Vung Tau.",
     CONTACT_VI, CONTACT_EN, HDR + "contact-header.jpg"),
    (12, "chinh-sach-bao-mat", "privacy-policy", "full-width",
     "Chính sách bảo mật", "Privacy Policy",
     "Cách The Malibu Hotel thu thập, sử dụng và bảo vệ thông tin cá nhân.",
     "How The Malibu Hotel collects, uses and protects personal information.",
     PRIVACY_VI, PRIVACY_EN, None),
    (13, "dieu-khoan-va-dieu-kien", "terms-and-conditions", "full-width",
     "Điều khoản và điều kiện", "Terms and Conditions",
     "Điều khoản đặt phòng, huỷ phòng và nội quy lưu trú.",
     "Booking, cancellation and house-rule terms.",
     TERMS_VI, TERMS_EN, None),
    (18, "hoi-nghi-su-kien", "conference-events", "full-width",
     "Hội nghị &amp; Sự kiện", "Meetings &amp; Events",
     "7 phòng hội nghị sức chứa tới 450 khách và dịch vụ tiệc cưới.",
     "Seven conference rooms for up to 450 guests, plus wedding services.",
     CONFERENCE_VI, CONFERENCE_EN, HDR + "conference-header.jpg"),
    (19, "malibu-group", "malibu-group", "full-width", "Malibu Group", "Malibu Group",
     "Các sản phẩm lưu trú khác của Malibu Group.",
     "Other hospitality products from Malibu Group.",
     GROUP_VI, GROUP_EN, HDR + "malibu-group-header.jpg"),
    (22, "tuyen-dung", "careers", "full-width", "Tuyển dụng", "Careers",
     "Cơ hội nghề nghiệp tại The Malibu Hotel Vũng Tàu.",
     "Career opportunities at The Malibu Hotel Vung Tau.",
     CAREERS_VI, CAREERS_EN, HDR + "wedding-header.jpg"),
]
