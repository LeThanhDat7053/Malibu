# -*- coding: utf-8 -*-
"""Tiện ích, nhà hàng và địa điểm lân cận của The Malibu Hotel."""

CDN = "https://malibuhotel.com.vn"
B = "/files/blog/46_1815/"

# id, slug VI, slug EN, tên VI, tên EN, ảnh, giờ mở cửa VI, giờ mở cửa EN,
# mô tả VI, mô tả EN, nội dung chi tiết VI, nội dung chi tiết EN
SERVICES = [
    dict(
        id=1, order=0, image=B + "M-POOL-MALIBU-HOTEL_1__1.jpg",
        slug_vi="m-pool", slug_en="m-pool",
        name_vi="M Pool – Hồ bơi ngoài trời", name_en="M Pool – Outdoor Pool",
        desc_vi="Hồ bơi ngoài trời tầng 6 với tầm nhìn toàn cảnh thành phố Vũng Tàu, "
                "quầy bar phục vụ tại hồ và hệ thống điện phân muối tự nhiên.",
        desc_en="A rooftop outdoor pool on the 6th floor with panoramic views over Vung Tau, "
                "a full-service lounge bar and a natural-salt electrolysis system.",
        body_vi=[
            ("", "M Pool là ốc đảo giữa lòng thành phố biển. Bơi một vòng trong làn nước "
                 "trong xanh, nhâm nhi ly vang và ngắm Vũng Tàu trải dài dưới nắng chiều – "
                 "mỗi trải nghiệm tại Malibu là một mảnh ghép của cảm xúc."),
            ("Thông tin hồ bơi", None),
            ("", "Sức chứa: 30 khách mỗi lượt. Hệ thống điện phân từ muối tự nhiên để khử khuẩn. "
                 "Hồ người lớn 195 m², độ sâu 1,4 m. Hồ trẻ em 105 m², độ sâu 0,9 m."),
            ("Giờ mở cửa", None),
            ("", "Hằng ngày: 07:00 – 19:00"),
        ],
        body_en=[
            ("", "A true oasis in the heart of Vung Tau, M Pool offers breath-taking panoramic "
                 "views of the city, beautiful modern design and a full-service lounge bar. "
                 "Take a refreshing swim, then enjoy a glass of wine as you overlook the "
                 "coastal city and bask in the afternoon sun."),
            ("Pool information", None),
            ("", "Capacity: 30 guests per session. Electrolyte system using natural salt to "
                 "disinfect the water. Adults' pool 195 sqm, 1.4 m deep. Children's pool "
                 "105 sqm, 0.9 m deep."),
            ("Hours", None),
            ("", "Everyday: 7:00 am – 7:00 pm"),
        ],
    ),
    dict(
        id=2, order=1, image=B + "M-SPA-MALIBU_HOTEL_1.jpg",
        slug_vi="m-spa", slug_en="m-spa",
        name_vi="M Spa – Chăm sóc và trị liệu", name_en="M Spa – Health Care &amp; Treatment",
        desc_vi="Không gian trị liệu yên tĩnh với đội ngũ kỹ thuật viên lành nghề, sử dụng "
                "thảo dược tự nhiên và y học cổ truyền.",
        desc_en="A quiet treatment space with skilled therapists using natural herbs and "
                "traditional medicine.",
        body_vi=[
            ("", "Sau những hoạt động khám phá thành phố biển, M Spa giúp bạn tái tạo năng "
                 "lượng cho một tuần mới. Đội ngũ kỹ thuật viên lành nghề, tận tâm sử dụng "
                 "y học cổ truyền và thảo dược quý từ thiên nhiên để mỗi phút giây tại đây "
                 "đều đáng giá."),
            ("", "Chỉ cần thả mình vào không gian tĩnh lặng, cảm nhận tuần hoàn trong từng "
                 "mạch máu, thư giãn và hồi phục trọn vẹn trong khoảng 2 giờ."),
            ("Dịch vụ", None),
            ("", "Xông hơi khô, xông hơi ướt, gội đầu dưỡng sinh và massage trị liệu."),
            ("Giờ mở cửa", None),
            ("", "Hằng ngày: 10:00 – 20:00"),
        ],
        body_en=[
            ("", "After discovery activities around the coastal city, M Spa helps you renew "
                 "your energy for the week ahead. Our team of skilled and dedicated therapists "
                 "uses traditional medicine and precious herbs from nature to make every "
                 "moment here worthwhile."),
            ("", "Simply settle into the quiet, feel the circulation in your blood, relax and "
                 "regenerate completely over about two hours."),
            ("Services", None),
            ("", "Sauna, steam bath, hair washing and therapeutic massage."),
            ("Hours", None),
            ("", "Everyday: 10:00 am – 8:00 pm"),
        ],
    ),
    dict(
        id=3, order=2, image=B + "Asset_23@4x_1.png",
        slug_vi="m-gym", slug_en="m-gym",
        name_vi="M Gym – Phòng tập thể hình", name_en="M Gym – Fitness Centre",
        desc_vi="Phòng gym 100 m² tại khu dịch vụ tầng 6 với trang thiết bị hiện đại "
                "chuẩn phòng tập chuyên nghiệp.",
        desc_en="A 100 sqm gym in the 6th-floor service area with modern equipment matching "
                "professional fitness centres.",
        body_vi=[
            ("", "Dành cho những ai duy trì thói quen luyện tập, Malibu bố trí phòng gym cao "
                 "cấp tại khu dịch vụ giải trí tầng 6, trang thiết bị hiện đại đáp ứng mọi "
                 "nhu cầu như các phòng tập chuyên nghiệp."),
            ("Thông tin", None),
            ("", "Diện tích phòng tập: 100 m²."),
            ("Giờ mở cửa", None),
            ("", "Hằng ngày: 06:00 – 22:00"),
        ],
        body_en=[
            ("", "For those who keep up an exercise routine, Malibu offers a high-class gym in "
                 "the entertainment service area on the 6th floor, with modern equipment to "
                 "meet all your needs just like professional gyms."),
            ("Information", None),
            ("", "Gym area: 100 sqm."),
            ("Hours", None),
            ("", "Everyday: 6:00 am – 10:00 pm"),
        ],
    ),
    dict(
        id=4, order=3, image=B + "Anh_1_4_1.jpg",
        slug_vi="vela-restaurant", slug_en="vela-restaurant",
        name_vi="Vela Restaurant – Buffet sáng", name_en="Vela Restaurant – Breakfast Buffet",
        desc_vi="Nhà hàng tầng 3 sức chứa 350 khách, buffet sáng hơn 40 món Á – Âu, "
                "phục vụ à la carte, buffet và tiệc Gala.",
        desc_en="A 3rd-floor restaurant seating 350 guests, with a breakfast buffet of more "
                "than 40 Asian and European dishes, à la carte, buffet and gala service.",
        body_vi=[
            ("", "Một sáng thức dậy tại Malibu, nghe bản nhạc du dương, nhấp ngụm cà phê và "
                 "dùng bữa sáng tại nhà hàng Vela tầng 3 với hơn 40 món buffet từ Á sang Âu, "
                 "trước khi bắt đầu ngày mới đầy hứng khởi cho chuyến công tác hay một ngày "
                 "rong chơi ở thành phố biển."),
            ("", "Đội ngũ ẩm thực của khách sạn chăm chút từng món ăn, từ khâu chọn nguyên "
                 "liệu tươi ngon đến chế biến – cho một bữa sáng tràn năng lượng, một bữa "
                 "trưa nhẹ nhàng, hay những món đặc biệt cho đêm Gala ấn tượng."),
            ("", "Nhà hàng được thiết kế rộng rãi, hiện đại, trải thảm cao cấp, sức chứa lên "
                 "đến 350 khách, phục vụ à la carte, buffet và tiệc Gala."),
            ("Giờ phục vụ", None),
            ("", "Buffet sáng: 06:30 – 10:00 &nbsp;|&nbsp; Tiệc: 11:00 – 22:00"),
        ],
        body_en=[
            ("", "One morning waking up at Malibu, listening to melodious music, sipping a cup "
                 "of coffee and having breakfast at Vela Restaurant on the 3rd floor with more "
                 "than 40 buffet dishes from Asia to Europe, before starting a new day of "
                 "enthusiasm for a business trip or a fun day out in the beautiful coastal city."),
            ("", "Our culinary team, knowledgeable in the quintessence of cuisine, takes care of "
                 "every dish from choosing fresh ingredients to cooking – for an energetic "
                 "breakfast, a light lunch, or even special dishes for an impressive gala night."),
            ("", "The restaurant is designed in a spacious modern style with high-quality "
                 "carpet. It accommodates up to 350 guests and serves à la carte, buffet "
                 "and gala."),
            ("Hours of operation", None),
            ("", "Breakfast buffet: 6:30 am – 10:00 am &nbsp;|&nbsp; Banquet: 11:00 am – 10:00 pm"),
        ],
    ),
    dict(
        id=5, order=4, image=B + "CARINA-MALIBU_HOTEL_1.jpg",
        slug_vi="carina-restaurant", slug_en="carina-restaurant",
        name_vi="Carina Restaurant – Ẩm thực Á Âu",
        name_en="Carina Restaurant – Fusion Cuisine",
        desc_vi="Nhà hàng tầng 6 với tầm nhìn đặc biệt, sức chứa 60 khách và phòng VIP "
                "20 khách, ẩm thực giao thoa Âu – Á.",
        desc_en="A 6th-floor restaurant with an extraordinary view, seating 60 guests plus a "
                "20-seat VIP room, serving European-Asian fusion cuisine.",
        body_vi=[
            ("", "Toạ lạc tại tầng 6 của khách sạn Malibu với tầm nhìn đặc biệt, Carina "
                 "Restaurant mang thiết kế hiện đại cùng âm nhạc thư thái, đem đến cho thực "
                 "khách trải nghiệm ẩm thực đẳng cấp."),
            ("", "Nhà hàng có sức chứa khoảng 60 khách, cùng một phòng VIP dành riêng cho 20 "
                 "khách – lý tưởng cho những buổi tiệc riêng tư, thanh lịch và các sự kiện đặc "
                 "biệt. Đây cũng là lựa chọn đẹp cho những buổi hẹn hò lãng mạn."),
            ("", "Thực đơn lấy cảm hứng từ sự giao thoa giữa ẩm thực châu Âu và châu Á, tuyển "
                 "chọn từ nguyên liệu thượng hạng, cùng tâm huyết của những đầu bếp tài hoa, "
                 "công thức riêng và sự tỉ mỉ trong phục vụ."),
            ("Giờ phục vụ", None),
            ("", "Hằng ngày: 11:00 – 22:00"),
        ],
        body_en=[
            ("", "Located on the 6th floor of the Malibu Hotel with an extraordinary view, the "
                 "restaurant features modern design and chilling music, providing guests with "
                 "a classy dining experience."),
            ("", "The restaurant has a capacity of around 60 guests, with a VIP room reserved "
                 "for 20 guests. It is ideal for private and elegant celebrations and special "
                 "events, and a good choice for romantic dates."),
            ("", "The menu is inspired by fusion cuisine between European and Asian dishes, "
                 "selected from the best ingredients, along with the enthusiasm of talented "
                 "chefs, unique recipes and meticulous attention to detail in serving."),
            ("Hours of operation", None),
            ("", "Everyday: 11:00 am – 10:00 pm"),
        ],
    ),
    dict(
        id=6, order=5, image=B + "800x600_1__1.png",
        slug_vi="the-lux-cafe", slug_en="the-lux-cafe",
        name_vi="The Lux Café – Cà phê &amp; trà",
        name_en="The Lux Café – Coffee &amp; Tea",
        desc_vi="Quán cà phê tại sảnh khách sạn, thiết kế như một góc phố Milan, "
                "có cả cây đàn piano cho những phút ngẫu hứng.",
        desc_en="A café in the hotel lobby designed like a corner of a Milan street, "
                "complete with a piano for spontaneous moments.",
        body_vi=[
            ("", "Trước khi trở lại với công việc, hãy ghé The Lux Café ở sảnh khách sạn để "
                 "thưởng thức một ly kem trong lúc làm thủ tục trả phòng."),
            ("", "Được thiết kế như một góc phố Milan tráng lệ mà không kém phần thời thượng, "
                 "The Lux Café khiến bạn như đang đắm mình trong hơi thở của kinh đô thời trang."),
            ("", "Và nếu có thể, hãy để lại một bản concerto cho Malibu và những vị khách khác "
                 "bên cây đàn piano nơi sảnh."),
            ("Giờ phục vụ", None),
            ("", "Hằng ngày: 07:00 – 22:00"),
        ],
        body_en=[
            ("", "Before we take you back to work, please pass by The Lux Café in the hotel "
                 "lobby to enjoy a glass of ice cream while checking out."),
            ("", "Designed like a magnificent corner of a Milan street but no less fashionable, "
                 "The Lux Café will make you feel like you are immersing yourself in the "
                 "breath of the fashion world capital."),
            ("", "And if possible, leave a concerto for Malibu and other guests with the piano "
                 "in the lobby."),
            ("Hours of operation", None),
            ("", "Everyday: 7:00 am – 10:00 pm"),
        ],
    ),
    dict(
        id=7, order=6, image=B + "Asset_51@4x_1.png",
        slug_vi="conference", slug_en="conference",
        name_vi="Conference – Hội nghị &amp; hội thảo",
        name_en="Conference – Meetings &amp; Seminars",
        desc_vi="7 phòng hội nghị sức chứa tới 450 khách, phòng Malibu Grand chia được "
                "thành 3 phòng nhỏ 120 khách mỗi phòng.",
        desc_en="Seven conference rooms for up to 450 guests; the Malibu Grand room can be "
                "divided into three rooms of 120 guests each.",
        body_vi=[
            ("", "The Malibu Hotel có 7 phòng hội nghị với sức chứa lên đến 450 khách. Phòng "
                 "Malibu Grand có thể ngăn thành 3 phòng nhỏ, mỗi phòng 120 khách, bằng hệ "
                 "thống vách ngăn linh hoạt."),
            ("", "Hệ thống âm thanh chuẩn quốc tế, màn hình LED và máy chiếu hiện đại, nội "
                 "thất cao cấp – sẵn sàng đáp ứng mọi nhu cầu của quý khách."),
            ("", "Chúng tôi cung cấp dịch vụ hỗ trợ kỹ thuật chuyên nghiệp cùng các gói thiết "
                 "bị và tiệc linh hoạt, bảo đảm mỗi sự kiện diễn ra suôn sẻ và thành công."),
            ("Liên hệ", None),
            ("", "Điện thoại: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn"),
        ],
        body_en=[
            ("", "The Malibu Hotel has 7 conference rooms for up to 450 guests. The Malibu "
                 "Grand room can be separated into 3 smaller rooms with a capacity of 120 "
                 "guests each by a flexible partition system."),
            ("", "With an international-standard sound system, modern LED screens and "
                 "projectors and high-class interiors, we are ready to meet the needs of all "
                 "our guests."),
            ("", "We also offer professional technical support and flexible equipment and "
                 "catering packages, ensuring each of your events runs smoothly and "
                 "successfully."),
            ("Contact", None),
            ("", "Phone: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn"),
        ],
    ),
    dict(
        id=8, order=7, image=B + "KID-ZONE-MALIBU_-_HOTEL_1.jpg",
        slug_vi="kid-zone", slug_en="kid-zone",
        name_vi="Kid Zone – Khu vui chơi trẻ em", name_en="Kid Zone – Children's Playground",
        desc_vi="Khu vui chơi an toàn, rộng rãi với trò chơi giáo dục và nhân viên "
                "trông coi tận tình.",
        desc_en="A safe, spacious play area with educational games and attentive staff.",
        body_vi=[
            ("", "Kid Zone là nơi lý tưởng để các bé thư giãn và vui chơi an toàn, sáng tạo "
                 "trong lúc bố mẹ nghỉ ngơi tại khách sạn."),
            ("", "Khu vui chơi được thiết kế riêng với nhiều trò chơi và hoạt động đa dạng, từ "
                 "trò chơi vận động đến trò chơi giáo dục, để các bé vừa vui vừa học. Đội ngũ "
                 "nhân viên chuyên nghiệp, chu đáo luôn có mặt để trông coi và hỗ trợ các bé."),
            ("Giờ mở cửa", None),
            ("", "Hằng ngày: 09:00 – 17:00"),
        ],
        body_en=[
            ("", "Our Kid Zone is the perfect place for children to relax and enjoy safe and "
                 "creative playtime while you unwind at the hotel."),
            ("", "It is specially designed with a variety of games and activities, ranging from "
                 "active games to educational ones, ensuring children have both fun and "
                 "enriching experiences. Our professional and attentive staff are always "
                 "available to supervise and assist."),
            ("Hours", None),
            ("", "Everyday: 9:00 am – 5:00 pm"),
        ],
    ),
    dict(
        id=9, order=8, image=B + "ENTERTAINMENT.jpg",
        slug_vi="entertainment", slug_en="entertainment",
        name_vi="Entertainment – Khu giải trí", name_en="Entertainment",
        desc_vi="Khu giải trí tầng 6 với hệ thống golf 3D mô phỏng nhiều sân tập khác nhau.",
        desc_en="A 6th-floor entertainment area with a 3D golf system simulating a range of "
                "practice courses.",
        body_vi=[
            ("", "Chơi golf không chỉ thoả niềm đam mê mà còn giúp bạn nâng trình nhanh chóng "
                 "và mang lại những phút giây thư giãn tuyệt vời sau một ngày làm việc căng "
                 "thẳng."),
            ("", "Golf 3D là hệ thống mô phỏng và tái hiện khung cảnh cùng các hoạt động giống "
                 "như golf thật. Điểm đặc biệt là với golf 3D, người chơi có thể chọn nhiều "
                 "loại sân tập khác nhau để cải thiện sự linh hoạt của mình."),
            ("Giờ mở cửa", None),
            ("", "Vui lòng liên hệ lễ tân để biết giờ hoạt động mới nhất."),
        ],
        body_en=[
            ("", "Practising golf not only satisfies golfers' passion for the game, it also "
                 "helps you improve quickly and brings wonderful moments of relaxation after "
                 "a stressful day of work."),
            ("", "3D Golf is a system that simulates and recreates scenes and activities "
                 "similar to real golf. A special feature is that with 3D golf, golfers can "
                 "choose different types of practice courses to improve their flexibility."),
            ("Hours", None),
            ("", "Please contact the front desk for the most current hours of operation."),
        ],
    ),
    dict(
        id=10, order=9, image=B + "_THP4305-HDR_1.jpg",
        slug_vi="billiard-foosball", slug_en="billiard-foosball",
        name_vi="Billiard &amp; Foosball", name_en="Billiard &amp; Foosball",
        desc_vi="Bàn billiard và bàn bi lắc tại khu giải trí tầng 6, dành cho những "
                "buổi tối thư giãn cùng bạn bè và gia đình.",
        desc_en="Billiard and foosball tables in the 6th-floor entertainment area, for "
                "relaxed evenings with friends and family.",
        body_vi=[
            ("", "Khu Billiard &amp; Foosball nằm trong tổ hợp giải trí tầng 6 của The Malibu "
                 "Hotel – nơi bạn có thể cùng bạn bè, đồng nghiệp hay gia đình có những giờ "
                 "phút thư giãn sau một ngày dài."),
            ("", "Bàn billiard tiêu chuẩn và bàn bi lắc được bảo dưỡng thường xuyên, không "
                 "gian thoáng đãng ngay cạnh hồ bơi M Pool và phòng tập M Gym."),
            ("Giờ mở cửa", None),
            ("", "Hằng ngày: 07:00 – 22:00"),
        ],
        body_en=[
            ("", "The Billiard &amp; Foosball area sits within the 6th-floor entertainment "
                 "complex of The Malibu Hotel – a place to unwind with friends, colleagues or "
                 "family after a long day."),
            ("", "Standard billiard tables and foosball tables are regularly maintained, in an "
                 "airy space right beside the M Pool and M Gym."),
            ("Hours", None),
            ("", "Everyday: 7:00 am – 10:00 pm"),
        ],
    ),
    dict(
        id=11, order=10, image=B + "Hotel-Laundry-Services-101-Is-It-Worth-It-04012022-735x491.jpg.webp",
        slug_vi="private-laundry", slug_en="private-laundry",
        name_vi="Private Laundry – Giặt ủi khép kín",
        name_en="Private Laundry",
        desc_vi="Xưởng giặt khép kín của riêng khách sạn, không sử dụng dịch vụ bên thứ ba, "
                "hoạt động 24/24.",
        desc_en="A fully in-house, closed-cycle laundry that uses no third-party services, "
                "open 24/7.",
        body_vi=[
            ("", "Xưởng giặt của The Malibu Hotel vận hành theo chu trình khép kín hoàn toàn, "
                 "không sử dụng dịch vụ của bất kỳ bên thứ ba nào."),
            ("", "Nhờ vậy, toàn bộ khăn, ga, gối và đồ vải phục vụ khách đều được phân loại, "
                 "giặt, tiệt trùng và hấp kỹ lưỡng, giữ hương thơm tự nhiên dễ chịu và tuyệt "
                 "đối an toàn – bảo đảm tiêu chuẩn vệ sinh và sự thoải mái cho khách."),
            ("Giờ phục vụ", None),
            ("", "24/24 mỗi ngày"),
        ],
        body_en=[
            ("", "The Malibu Hotel laundry runs on a completely closed and unique cycle, "
                 "without using the services of any third party."),
            ("", "As a result, all the fabrics used to serve guests are classified, washed, "
                 "pasteurised and steamed very thoroughly, with a comfortable natural scent "
                 "that is absolutely safe – ensuring the criteria of health and comfort "
                 "for our guests."),
            ("Hours", None),
            ("", "24/7"),
        ],
    ),
    dict(
        id=12, order=11, image=B + "DSC00288_1.jpg",
        slug_vi="gift-shop", slug_en="gift-shop",
        name_vi="Gift Shop – Cửa hàng quà tặng", name_en="Gift Shop",
        desc_vi="Cửa hàng quà tặng và đồ lưu niệm mở cửa 24/24 ngay trong khách sạn.",
        desc_en="A gift and souvenir shop inside the hotel, open 24/7.",
        body_vi=[
            ("", "Gift Shop của khách sạn là không gian mua sắm độc đáo và đa dạng, nơi bạn có "
                 "thể tìm thấy món quà phù hợp cho gia đình, bạn bè – hoặc cho chính mình."),
            ("", "Từ trang sức tinh xảo đến đồ thủ công mỹ nghệ và quà lưu niệm đặc trưng, "
                 "chúng tôi mang đến trải nghiệm mua sắm đáng nhớ, trọn vẹn cho hành trình "
                 "của bạn."),
            ("", "Đội ngũ nhân viên luôn sẵn sàng tư vấn để bạn chọn được sản phẩm ưng ý nhất."),
            ("Giờ mở cửa", None),
            ("", "24/24 mỗi ngày"),
        ],
        body_en=[
            ("", "Our gift shop is a unique and diverse shopping space where you can find the "
                 "perfect gift for family, friends, or even yourself."),
            ("", "With a wide range of high-quality products, from elegant jewellery to unique "
                 "handcrafted items and special souvenirs, we are committed to providing you "
                 "with a memorable shopping experience that complements your travel journey."),
            ("", "Our staff are always available to help you choose the most suitable products."),
            ("Hours", None),
            ("", "Everyday: 24/7"),
        ],
    ),
]

# Địa điểm lân cận (khoảng cách tính từ 263 Lê Hồng Phong, P. Thắng Tam)
PLACES = [
    dict(id=1, slug_vi="bai-sau-vung-tau", slug_en="back-beach-vung-tau",
         name_vi="Bãi Sau (Thuỳ Vân)", name_en="Back Beach (Thuy Van)",
         dist_vi="khoảng 450 m | 6 phút đi bộ", dist_en="approx. 450 m | 6 min walk",
         desc_vi="Bãi biển dài và thoải nhất Vũng Tàu, chỉ vài phút đi bộ từ khách sạn.",
         desc_en="Vung Tau's longest and gentlest beach, a few minutes' walk from the hotel.",
         image="/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg"),
    dict(id=2, slug_vi="tuong-chua-kito-vua", slug_en="christ-the-king-statue",
         name_vi="Tượng Chúa Kitô Vua", name_en="Christ the King Statue",
         dist_vi="khoảng 2,5 km | 8 phút lái xe", dist_en="approx. 2.5 km | 8 min drive",
         desc_vi="Bức tượng 32 m trên đỉnh Núi Nhỏ với 811 bậc thang và tầm nhìn toàn cảnh "
                 "thành phố biển.",
         desc_en="A 32-metre statue atop Nui Nho mountain, reached by 811 steps, with "
                 "panoramic views over the coastal city.",
         image="/files/sites/site_70/site_70_gallery_muc1/DSC00703.jpg"),
    dict(id=3, slug_vi="ngon-hai-dang-vung-tau", slug_en="vung-tau-lighthouse",
         name_vi="Ngọn Hải Đăng Vũng Tàu", name_en="Vung Tau Lighthouse",
         dist_vi="khoảng 3,5 km | 10 phút lái xe", dist_en="approx. 3.5 km | 10 min drive",
         desc_vi="Hải đăng hơn 100 năm tuổi trên Núi Nhỏ, điểm ngắm hoàng hôn đẹp nhất "
                 "Vũng Tàu.",
         desc_en="A century-old lighthouse on Nui Nho hill and the finest sunset viewpoint "
                 "in Vung Tau.",
         image="/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg"),
    dict(id=4, slug_vi="bach-dinh", slug_en="bach-dinh-white-palace",
         name_vi="Bạch Dinh", name_en="Bach Dinh (White Palace)",
         dist_vi="khoảng 4,5 km | 12 phút lái xe", dist_en="approx. 4.5 km | 12 min drive",
         desc_vi="Dinh thự Pháp cổ xây năm 1898 bên sườn Núi Lớn, nay là bảo tàng cổ vật.",
         desc_en="A French colonial villa built in 1898 on the slope of Nui Lon, now an "
                 "antiquities museum.",
         image="/files/sites/site_70/site_70_gallery_muc1/DSC00703.jpg"),
    dict(id=5, slug_vi="ho-may-park", slug_en="ho-may-park",
         name_vi="Khu du lịch Hồ Mây", name_en="Ho May Park",
         dist_vi="khoảng 4 km | 12 phút lái xe", dist_en="approx. 4 km | 12 min drive",
         desc_vi="Công viên trên đỉnh Núi Lớn với cáp treo, hồ nước và khu vui chơi "
                 "cho cả gia đình.",
         desc_en="A hilltop park on Nui Lon with a cable car, a lake and family "
                 "attractions.",
         image="/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg"),
    dict(id=6, slug_vi="cho-xom-luoi", slug_en="xom-luoi-seafood-market",
         name_vi="Chợ hải sản Xóm Lưới", name_en="Xom Luoi Seafood Market",
         dist_vi="khoảng 4 km | 11 phút lái xe", dist_en="approx. 4 km | 11 min drive",
         desc_vi="Khu chợ hải sản tươi sống nổi tiếng, nhộn nhịp nhất vào sáng sớm "
                 "và buổi tối.",
         desc_en="Vung Tau's best-known fresh seafood market, busiest at dawn and "
                 "in the evening.",
         image="/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg"),
]

# Thư viện ảnh: id, khoá trong gallery.json, tên VI, tên EN, mô tả VI, mô tả EN
GALLERIES = [
    (6, "LANDSCAPE", "Toàn cảnh khách sạn", "Hotel Landscape",
     "Toà nhà 23 tầng bên bờ biển Vũng Tàu và những góc nhìn đẹp nhất của Malibu.",
     "The 23-storey tower by the Vung Tau shoreline and the finest views of Malibu."),
    (7, "ROOM", "Phòng nghỉ", "Rooms &amp; Suites",
     "197 phòng nghỉ từ Premier đến Presidential Suite, tất cả đều hướng biển.",
     "197 guest rooms from Premier to the Presidential Suite, all facing the sea."),
    (8, "RESTAURANT", "Nhà hàng", "Restaurants",
     "Vela Restaurant, Carina Restaurant và The Lux Café.",
     "Vela Restaurant, Carina Restaurant and The Lux Café."),
    (9, "MEETING", "Hội nghị &amp; sự kiện", "Meetings &amp; Events",
     "7 phòng hội nghị linh hoạt, sức chứa tới 450 khách.",
     "Seven flexible conference rooms for up to 450 guests."),
    (10, "POOL", "Hồ bơi M Pool", "M Pool",
     "Hồ bơi ngoài trời tầng 6 với tầm nhìn toàn cảnh thành phố.",
     "The 6th-floor outdoor pool with panoramic city views."),
    (11, "GYM", "Phòng tập M Gym", "M Gym",
     "Phòng tập 100 m² với trang thiết bị hiện đại.",
     "A 100 sqm gym with modern equipment."),
    (12, "SPA", "M Spa", "M Spa",
     "Không gian trị liệu yên tĩnh với thảo dược tự nhiên.",
     "A quiet treatment space using natural herbs."),
    (13, "ENTERTAINMENT", "Giải trí", "Entertainment",
     "Golf 3D, billiard, bi lắc và khu vui chơi trẻ em.",
     "3D golf, billiards, foosball and the children's play area."),
]
