# -*- coding: utf-8 -*-
"""Dữ liệu 10 loại phòng của The Malibu Hotel (lấy từ malibuhotel.com.vn)."""

CDN = "https://malibuhotel.com.vn"

# Hạng phòng: id -> (tên VI, tên EN, slug, thứ tự)
CATEGORIES = [
    (5, "Premier", "Premier", "premier", 0),
    (6, "Diamond", "Diamond", "diamond", 1),
    (7, "Suite", "Suite", "suite", 2),
    (8, "President", "President", "president", 3),
]

# id, mã phòng trên web Malibu (thư mục ảnh), hạng, slug VI, slug EN
# tên VI / tên EN, diện tích, giường, số phòng, người lớn, trẻ em, nổi bật
ROOMS = [
    dict(
        id=1, src="846", cat=5, order=0, featured=1,
        slug_vi="phong-premier-twin", slug_en="premier-twin-room",
        name_vi="Phòng Premier Twin", name_en="Premier Twin",
        size=40, beds=2, rooms=40, adults=2, children=2,
        bed_vi="02 giường đơn 1m4", bed_en="2 single beds (1.4m)",
        view_vi="Hướng thành phố và biển", view_en="City &amp; Sea view",
        bathtub=False,
    ),
    dict(
        id=2, src="843", cat=5, order=1, featured=1,
        slug_vi="phong-premier-king", slug_en="premier-king-room",
        name_vi="Phòng Premier King", name_en="Premier King",
        size=40, beds=1, rooms=45, adults=2, children=2,
        bed_vi="01 giường King 1m8", bed_en="1 King bed (1.8m)",
        view_vi="Hướng thành phố và biển", view_en="City &amp; Sea view",
        bathtub=False,
    ),
    dict(
        id=3, src="845", cat=5, order=2, featured=0,
        slug_vi="phong-premier-queen", slug_en="premier-queen-room",
        name_vi="Phòng Premier Queen", name_en="Premier Queen",
        size=40, beds=2, rooms=35, adults=2, children=2,
        bed_vi="02 giường 1,6m x 2m ghép đôi", bed_en="2 joined beds (1.6m x 2m)",
        view_vi="Hướng thành phố và biển", view_en="City &amp; Sea view",
        bathtub=False,
    ),
    dict(
        id=4, src="886", cat=5, order=3, featured=0,
        slug_vi="phong-premier-family", slug_en="premier-family-room",
        name_vi="Phòng Premier Family", name_en="Premier Family",
        size=50, beds=2, rooms=20, adults=4, children=2,
        bed_vi="02 giường King 1m8", bed_en="2 King beds (1.8m)",
        view_vi="Hướng thành phố", view_en="City view",
        bathtub=False,
    ),
    dict(
        id=5, src="844", cat=6, order=0, featured=1,
        slug_vi="phong-diamond-king", slug_en="diamond-king-room",
        name_vi="Phòng Diamond King", name_en="Diamond King",
        size=46, beds=1, rooms=25, adults=2, children=2,
        bed_vi="01 giường King 1m8", bed_en="1 King bed (1.8m)",
        view_vi="Hướng thành phố", view_en="City view",
        bathtub=True,
    ),
    dict(
        id=6, src="847", cat=6, order=1, featured=1,
        slug_vi="phong-diamond-family", slug_en="diamond-family-room",
        name_vi="Phòng Diamond Family", name_en="Diamond Family",
        size=50, beds=2, rooms=15, adults=4, children=2,
        bed_vi="01 giường King 1m8 và 01 giường đơn 1m2",
        bed_en="1 King bed (1.8m) and 1 single bed (1.2m)",
        view_vi="Hướng thành phố và biển", view_en="City &amp; Sea view",
        bathtub=True,
    ),
    dict(
        id=7, src="885", cat=7, order=0, featured=1,
        slug_vi="malibu-suite", slug_en="malibu-suite",
        name_vi="Malibu Suite", name_en="Malibu Suite",
        size=60, beds=1, rooms=8, adults=2, children=2,
        bed_vi="01 giường King 1m8", bed_en="1 King bed (1.8m)",
        view_vi="Hướng thành phố và biển", view_en="City &amp; Sea view",
        bathtub=True,
    ),
    dict(
        id=8, src="887", cat=7, order=1, featured=1,
        slug_vi="family-suite", slug_en="family-suite",
        name_vi="Family Suite", name_en="Family Suite",
        size=60, beds=2, rooms=5, adults=4, children=2,
        bed_vi="02 giường King 1m8", bed_en="2 King beds (1.8m)",
        view_vi="Hướng thành phố và biển", view_en="City &amp; Sea view",
        bathtub=True,
    ),
    dict(
        id=9, src="917", cat=8, order=0, featured=0,
        slug_vi="vice-president-suite", slug_en="vice-president-suite",
        name_vi="Vice President Suite", name_en="Vice President Suite",
        size=120, beds=1, rooms=3, adults=4, children=2,
        bed_vi="01 giường King hoặc 02 giường Queen",
        bed_en="1 King bed or 2 Queen beds",
        view_vi="Hướng biển toàn cảnh", view_en="Panoramic sea view",
        bathtub=True,
    ),
    dict(
        id=10, src="918", cat=8, order=1, featured=1,
        slug_vi="presidential-suite", slug_en="presidential-suite",
        name_vi="Presidential Suite", name_en="Presidential Suite",
        size=250, beds=1, rooms=1, adults=4, children=2,
        bed_vi="01 giường King hoặc 02 giường Queen",
        bed_en="1 King bed or 2 Queen beds",
        view_vi="Hướng biển toàn cảnh", view_en="Panoramic sea view",
        bathtub=True,
    ),
]

# Mô tả ngắn
DESC_VI = {
    1: "Phòng 40m² với hai giường đơn 1m4, ban công hướng thành phố và biển – lựa chọn "
       "lý tưởng cho hai người bạn đồng hành hoặc chuyến công tác.",
    2: "Phòng 40m² với giường King 1m8, tầm nhìn ôm trọn thành phố Vũng Tàu và đại dương.",
    3: "Phòng 40m² với hai giường 1,6m x 2m ghép đôi, linh hoạt cho cả cặp đôi lẫn nhóm bạn.",
    4: "Phòng gia đình 50m² với hai giường King 1m8, hướng thành phố, thoải mái cho 4 người lớn.",
    5: "Phòng 46m² hạng Diamond với giường King 1m8 và bồn tắm riêng, hướng thành phố.",
    6: "Phòng gia đình 50m² hạng Diamond với bồn tắm, một giường King và một giường đơn, "
       "hướng thành phố và biển.",
    7: "Suite 60m² với giường King 1m8, phòng khách riêng và bồn tắm, tầm nhìn thành phố và biển.",
    8: "Suite gia đình 60m² với hai giường King 1m8 và bồn tắm, tầm nhìn thành phố và biển.",
    9: "Suite hạng Phó Tổng Thống với không gian tiếp khách riêng và tầm nhìn biển toàn cảnh.",
    10: "Presidential Suite 250m² – căn phòng lớn nhất khách sạn với tầm nhìn toàn cảnh "
        "Vũng Tàu, không gian tiếp khách và tiện nghi cao cấp nhất.",
}

DESC_EN = {
    1: "A 40sqm room with two single beds and a balcony overlooking the city and the sea – "
       "ideal for travelling companions or a business trip.",
    2: "A 40sqm room with a King bed and views embracing Vung Tau city and the ocean.",
    3: "A 40sqm room with two joined 1.6m x 2m beds, flexible for couples and friends alike.",
    4: "A 50sqm family room with two King beds and city views, comfortable for four adults.",
    5: "A 46sqm Diamond room with a King bed, private bathtub and city views.",
    6: "A 50sqm Diamond family room with a bathtub, one King bed and one single bed, "
       "facing the city and the sea.",
    7: "A 60sqm suite with a King bed, separate living area and bathtub, overlooking the "
       "city and the sea.",
    8: "A 60sqm family suite with two King beds and a bathtub, overlooking the city and the sea.",
    9: "The Vice President Suite offers a private reception area and panoramic sea views.",
    10: "The 250sqm Presidential Suite – the largest room in the hotel, with panoramic views "
        "over Vung Tau, a private reception area and the finest amenities.",
}

# Tiện nghi phòng gán cho từng hạng (id trong ht_amenities)
BASE_AMENITIES = [1, 2, 3, 4, 5, 6, 7, 8, 11, 12, 13, 14, 15]
BATHTUB_ID = 9
BALCONY_ID = 10
SEAVIEW_ID = 16
