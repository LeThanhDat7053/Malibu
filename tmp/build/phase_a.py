# -*- coding: utf-8 -*-
"""Phase A: dọn dữ liệu vận hành của Ruby68 + đặt danh tính Malibu."""
import re
import lib
from lib import row

NOW = "2026-09-04 08:00:00"
PWD = "$2y$12$cuMBS02jVEznQ.k1Ww/YieYBKBOCRuOPzKZNa23NQ3K1gtZFWWVj."  # Malibu@2026

# Bảng làm rỗng hoàn toàn
PURGE = [
    # log & lịch sử
    "audit_histories", "revisions", "ai_translation_logs", "ai_training_contexts",
    "admin_notifications", "dashboard_widget_settings", "user_meta",
    # dữ liệu khách hàng Ruby
    "ht_bookings", "ht_booking_addresses", "ht_booking_rooms", "ht_booking_services",
    "ht_booking_foods", "ht_invoices", "ht_invoice_items",
    "ht_customers", "ht_customer_password_resets",
    "contacts", "contact_replies", "newsletters",
    "ht_product_orders", "ht_product_order_items",
    "ht_room_calendars", "ht_room_dates", "ht_ical_sync_logs", "ht_coupons",
    # phiên & hàng đợi
    "sessions", "cache", "cache_locks", "jobs", "failed_jobs",
    "personal_access_tokens", "social_logins", "password_reset_tokens", "activations",
    # thư viện media để trống: ảnh lấy trực tiếp từ malibuhotel.com.vn
    "media_files", "media_folders",
    # dữ liệu giả
    "teams", "teams_translations", "testimonials", "testimonials_translations",
]

# ---------------------------------------------------------------- users
USERS = [row(
    1, "admin@malibuhotel.com.vn", "0941871644", NOW, PWD, None,
    NOW, NOW, "Malibu", "Admin", "admin", None, 1, 1, None, None, None,
)]
ROLE_USERS = [row(1, 1, NOW, NOW)]
ACTIVATIONS = [row(1, 1, "malibu" + "0" * 26, 1, NOW, NOW, NOW)]

# ---------------------------------------------------------------- settings
NEW = {
    "hotel_company_logo_for_invoicing": "",
    "hotel_company_address_for_invoicing":
        "263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City, "
        "Ba Ria - Vung Tau Province, Vietnam",
    "hotel_company_email_for_invoicing": "res@malibuhotel.com.vn",
    "hotel_company_phone_for_invoicing": "(0254) 7305 779",

    "license_domain": "vietnamtourist.gomenu.vn",
    "admin_title": "Malibu Hotel",

    "theme-riorelax-site_title": "The Malibu Hotel Vũng Tàu",
    "theme-riorelax-copyright": "Copyright © 2026 The Malibu Hotel. All rights reserved.",
    "theme-riorelax-email": "res@malibuhotel.com.vn",
    "theme-riorelax-address":
        "263 Lê Hồng Phong, P. Thắng Tam, TP. Vũng Tàu, Bà Rịa - Vũng Tàu",
    "theme-riorelax-hotline": "0941 871 644",
    "theme-riorelax-opening_hours": "",
    "theme-riorelax-seo_title":
        "The Malibu Hotel Vũng Tàu – Khách sạn 5 sao trung tâm thành phố biển",
    "theme-riorelax-seo_description":
        "The Malibu Hotel Vũng Tàu – 197 phòng nghỉ hướng biển trong toà nhà 23 tầng, "
        "kiến trúc châu Âu hiện đại. Hồ bơi M Pool, M Spa, M Gym, nhà hàng Vela & Carina, "
        "7 phòng hội nghị sức chứa 450 khách. Live Beautifully.",

    # ảnh: để trống, sẽ điền URL Malibu ở phase sau hoặc bạn tự upload
    "theme-riorelax-logo": "",
    "theme-riorelax-favicon": "",
    "theme-riorelax-admin_logo": "",
    "theme-riorelax-admin_favicon": "",
    "theme-riorelax-background_footer": "",
    "theme-riorelax-breadcrumb_background_image": "",
    "theme-riorelax-404_page_image": "",
    "theme-riorelax-authentication_login_background_image": "",
    "theme-riorelax-authentication_register_background_image": "",
    "theme-riorelax-authentication_forgot_password_background_image": "",
    "theme-riorelax-authentication_reset_password_background_image": "",
    "theme-riorelax-seo_og_image": "",

    # bảng màu Malibu (cam chủ đạo trên nền navy)
    "theme-riorelax-primary_color": "rgb(228, 118, 44)",
    "theme-riorelax-primary_color_hover": "rgb(190, 92, 26)",
    "theme-riorelax-secondary_color": "rgb(22, 25, 44)",
    "theme-riorelax-cookie_consent_background_color": "rgb(22, 25, 44)",

    "theme-riorelax-social_links": (
        '[[{"key":"name","value":"Facebook"},'
        '{"key":"social-icon","value":"fab fa-facebook-f"},'
        '{"key":"url","value":"https:\\/\\/www.facebook.com\\/themalibuhoteI"}],'
        '[{"key":"name","value":"Instagram"},'
        '{"key":"social-icon","value":"fab fa-instagram"},'
        '{"key":"url","value":"https:\\/\\/www.instagram.com\\/malibuhotelvungtau\\/"}],'
        '[{"key":"name","value":"TikTok"},'
        '{"key":"social-icon","value":"fab fa-tiktok"},'
        '{"key":"url","value":"https:\\/\\/www.tiktok.com\\/@malibuhotelvt"}],'
        '[{"key":"name","value":"YouTube"},'
        '{"key":"social-icon","value":"fab fa-youtube"},'
        '{"key":"url","value":"https:\\/\\/www.youtube.com\\/@malibuhotel8000"}],'
        '[{"key":"name","value":"Zalo"},'
        '{"key":"social-icon","value":"fas fa-comment-dots"},'
        '{"key":"url","value":"https:\\/\\/zalo.me\\/0941871601"}]]'
    ),

    "theme-riorelax-hotel_rules": (
        "<ul>"
        "<li><strong>Thời gian nhận/trả phòng:</strong> Nhận phòng từ <strong>14:00</strong>, "
        "trả phòng trước <strong>12:00</strong>.</li>"
        "<li><strong>Giấy tờ tuỳ thân:</strong> Xuất trình Hộ chiếu (khách quốc tế) hoặc "
        "CMND/CCCD (khách Việt Nam) còn hiệu lực khi làm thủ tục.</li>"
        "<li><strong>Chính sách thanh toán:</strong> Cung cấp thông tin thẻ tín dụng hoặc "
        "thanh toán đặt cọc để đảm bảo giữ phòng.</li>"
        "<li><strong>Tiện ích miễn phí:</strong> Nước suối, trà, cà phê mỗi ngày; buffet sáng "
        "tại nhà hàng Vela; hồ bơi M Pool và phòng gym M Gym.</li>"
        "<li><strong>Wi-Fi:</strong> Internet tốc độ cao miễn phí trong toàn bộ khuôn viên.</li>"
        "<li><strong>Hút thuốc:</strong> Không hút thuốc trong phòng; vui lòng sử dụng ban công "
        "hoặc khu vực quy định.</li>"
        "<li><strong>Vật nuôi:</strong> Không mang theo vật nuôi vào khách sạn.</li>"
        "<li><strong>An toàn:</strong> Sử dụng két sắt trong phòng để bảo quản tài sản có giá trị; "
        "khách sạn có an ninh và lễ tân trực 24/7.</li>"
        "<li><strong>Số lượng khách:</strong> Lưu trú đúng số người theo hạng phòng đã đặt; "
        "phụ thu áp dụng cho khách thêm người hoặc trẻ em.</li>"
        "<li><strong>Hành lý cấm:</strong> Không mang chất cháy nổ, vũ khí hoặc thực phẩm có mùi "
        "nồng vào phòng nghỉ.</li>"
        "</ul>"
    ),
}

# ---- nhóm nút chat nổi + email hệ thống
NEW.update({
    "theme-riorelax-chat_btn_facebook": "https://www.facebook.com/themalibuhoteI",
    "theme-riorelax-chat_btn_zalo": "https://zalo.me/0941871601",
    "theme-riorelax-chat_btn_instagram": "https://www.instagram.com/malibuhotelvungtau/",
    "theme-riorelax-chat_btn_tiktok": "https://www.tiktok.com/@malibuhotelvt",
    "theme-riorelax-chat_btn_telegram": None,
    "theme-riorelax-chat_btn_whatsapp": None,

    "email_from_name": "The Malibu Hotel",
    "email_from_address": "res@malibuhotel.com.vn",
    "email_username": "",
    "email_password": "",
    "admin_email": '["admin@malibuhotel.com.vn"]',

    "ai_translator_prompt":
        "You are an expert luxury hospitality translator for The Malibu Hotel, "
        "a 5-star international hotel in Vung Tau, Vietnam.\r\n\r\n"
        "TRANSLATION STYLE:\r\n"
        "- Use elegant, sophisticated and refined language befitting a world-class hotel\r\n"
        "- Evoke feelings of luxury, relaxation, exclusivity and impeccable service\r\n"
        "- Maintain a warm yet prestigious tone that makes guests feel valued\r\n"
        "- Keep the brand voice \"Live Beautifully\"\r\n"
        "- Keep proper nouns unchanged: Malibu, Vung Tau, M Pool, M Spa, M Gym, "
        "Vela Restaurant, Carina Restaurant, The Lux Cafe, Premier, Diamond, Suite, President\r\n"
        "- Preserve all HTML tags and attributes exactly as they appear",

    "media_folders_can_add_watermark": "[]",
})

# ---- bản tiếng Anh của theme (theme-riorelax-en_US-*)
NEW.update({
    "theme-riorelax-en_US-site_title": "The Malibu Hotel Vung Tau",
    "theme-riorelax-en_US-copyright":
        "Copyright © 2026 The Malibu Hotel. All rights reserved.",
    "theme-riorelax-en_US-email": "res@malibuhotel.com.vn",
    "theme-riorelax-en_US-hotline": "(+84) 941 871 644",
    "theme-riorelax-en_US-address":
        "263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City, "
        "Ba Ria - Vung Tau Province, Vietnam",
    "theme-riorelax-en_US-seo_title":
        "The Malibu Hotel Vung Tau – 5-Star Hotel in the Heart of the Coastal City",
    "theme-riorelax-en_US-seo_description":
        "The Malibu Hotel Vung Tau offers 197 ocean-view rooms in a 23-storey tower with "
        "modern European architecture. M Pool, M Spa, M Gym, Vela & Carina restaurants and "
        "7 conference rooms for up to 450 guests. Live Beautifully.",
    "theme-riorelax-en_US-chat_btn_facebook": "https://www.facebook.com/themalibuhoteI",
    "theme-riorelax-en_US-chat_btn_zalo": "https://zalo.me/0941871601",
    "theme-riorelax-en_US-chat_btn_instagram":
        "https://www.instagram.com/malibuhotelvungtau/",
    "theme-riorelax-en_US-chat_btn_tiktok": "https://www.tiktok.com/@malibuhotelvt",
    "theme-riorelax-en_US-chat_btn_telegram": None,
    "theme-riorelax-en_US-chat_btn_whatsapp": None,
    "theme-riorelax-en_US-primary_color": NEW["theme-riorelax-primary_color"],
    "theme-riorelax-en_US-primary_color_hover": NEW["theme-riorelax-primary_color_hover"],
    "theme-riorelax-en_US-secondary_color": NEW["theme-riorelax-secondary_color"],
    "theme-riorelax-en_US-cookie_consent_background_color":
        NEW["theme-riorelax-cookie_consent_background_color"],
    "theme-riorelax-en_US-social_links": NEW["theme-riorelax-social_links"],
    "theme-riorelax-en_US-hotel_rules": (
        "<ul>"
        "<li><strong>Check-in / check-out:</strong> Check-in from <strong>14:00</strong>, "
        "check-out before <strong>12:00</strong>.</li>"
        "<li><strong>Identification:</strong> A valid passport (international guests) or "
        "ID card (Vietnamese guests) is required at check-in.</li>"
        "<li><strong>Payment policy:</strong> A credit card or a deposit is required to "
        "guarantee the reservation.</li>"
        "<li><strong>Complimentary:</strong> Daily bottled water, tea and coffee; "
        "breakfast buffet at Vela Restaurant; access to M Pool and M Gym.</li>"
        "<li><strong>Wi-Fi:</strong> Complimentary high-speed internet throughout the hotel.</li>"
        "<li><strong>Smoking:</strong> Non-smoking rooms; please use the balcony or the "
        "designated areas.</li>"
        "<li><strong>Pets:</strong> Pets are not allowed in the hotel.</li>"
        "<li><strong>Safety:</strong> Please use the in-room safe for valuables; "
        "security and front desk operate 24/7.</li>"
        "<li><strong>Occupancy:</strong> Please respect the maximum occupancy of your room "
        "type; surcharges apply for extra guests or children.</li>"
        "<li><strong>Prohibited items:</strong> Flammables, weapons and strong-smelling food "
        "are not permitted in guest rooms.</li>"
        "</ul>"
    ),
})

# ảnh của bản tiếng Anh cũng để trống
for _k in ("logo", "favicon", "background_footer", "breadcrumb_background_image",
           "404_page_image", "seo_og_image", "popup_banner_image",
           "authentication_login_background_image",
           "authentication_register_background_image",
           "authentication_forgot_password_background_image",
           "authentication_reset_password_background_image",
           "breadcrumb_background_image_room", "breadcrumb_background_image_product",
           "breadcrumb_background_image_gallery", "breadcrumb_background_image_blog"):
    NEW["theme-riorelax-en_US-" + _k] = ""
    NEW.setdefault("theme-riorelax-" + _k, "")

# ---- nút "Đặt phòng" nổi ở cạnh màn hình (Theme Options > Nút đặt phòng)
BOOKING_BUTTON = {
    "booking_button_enabled": "yes",
    "booking_button_url": "",
    "booking_button_new_tab": "yes",
    "booking_button_bg_color": "rgb(228, 118, 44)",
    "booking_button_text_color": "#ffffff",
    "booking_button_hover_bg_color": "rgb(190, 92, 26)",
    "booking_panel_bg_color": "rgb(22, 25, 44)",
}

for _k, _v in BOOKING_BUTTON.items():
    NEW["theme-riorelax-" + _k] = _v
    NEW["theme-riorelax-en_US-" + _k] = _v

NEW["theme-riorelax-booking_button_label"] = "ĐẶT PHÒNG"
NEW["theme-riorelax-en_US-booking_button_label"] = "BOOK NOW"

_UNESC = {"n": "\n", "r": "\r", "t": "\t", "0": "\x00", "Z": "\x1a"}


def unescape(s):
    out, i = [], 0
    while i < len(s):
        if s[i] == "\\" and i + 1 < len(s):
            out.append(_UNESC.get(s[i + 1], s[i + 1]))
            i += 2
        else:
            out.append(s[i])
            i += 1
    return "".join(out)


def rebuild_settings(sql):
    m = re.search(lib.INSERT_RE % "settings", sql)
    rows, seen = [], set()
    pattern = r"\((\d+), '((?:[^'\\]|\\.)*)', (NULL|'(?:[^'\\]|\\.)*'),"
    for rid, key, val in re.findall(pattern, m.group("body")):
        seen.add(key)
        if key in NEW:
            v = NEW[key]
        else:
            v = None if val == "NULL" else unescape(val[1:-1])
        rows.append((int(rid), key, v))
    nid = max(r[0] for r in rows) + 1
    for key, v in NEW.items():
        if key not in seen:
            rows.append((nid, key, v))
            nid += 1
    return [row(i, k, v, None, NOW) for i, k, v in rows], nid


def apply(sql):
    for t in PURGE:
        sql = lib.replace(sql, t, [])
        sql = lib.autoinc(sql, t, 1)

    sql = lib.replace(sql, "users", USERS)
    sql = lib.autoinc(sql, "users", 2)
    sql = lib.replace(sql, "role_users", ROLE_USERS)
    sql = lib.replace(sql, "activations", ACTIVATIONS)
    sql = lib.autoinc(sql, "activations", 2)

    srows, nid = rebuild_settings(sql)
    sql = lib.replace(sql, "settings", srows)
    sql = lib.autoinc(sql, "settings", nid)
    return sql


if __name__ == "__main__":
    src = lib.load()
    out = apply(src)
    lib.save(out)
    print("trước: %.2f MB -> sau: %.2f MB" % (len(src) / 1048576, len(out) / 1048576))
