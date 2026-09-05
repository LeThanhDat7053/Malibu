-- =============================================================================
-- Layout mới cho trang Nhà hàng (theo mẫu botonbluehotels.com/dining)
--
-- Chạy toàn bộ file này một lần. Các lệnh đều chạy lại được nhiều lần.
-- =============================================================================

-- -----------------------------------------------------------------------------
-- 1. Cột mới cho bảng nhà hàng
--
--    banner_image : ảnh hero khổ lớn ở đầu trang chi tiết (tách khỏi gallery)
--    vr360_embed  : URL nhúng iframe — điền vào là hero tự đổi thành khung VR360
--    menu_images  : JSON danh sách ảnh thực đơn cho khối "Our Menu"
--    subtitle     : dòng nhãn nhỏ phía trên tên nhà hàng
--    menu_heading : dòng phụ dưới chữ "Our Menu"
-- -----------------------------------------------------------------------------

ALTER TABLE `ht_restaurants`
    ADD COLUMN `subtitle`     VARCHAR(160) NULL DEFAULT NULL AFTER `name`,
    ADD COLUMN `banner_image` VARCHAR(400) NULL DEFAULT NULL AFTER `images`,
    ADD COLUMN `menu_images`  TEXT         NULL DEFAULT NULL AFTER `banner_image`,
    ADD COLUMN `menu_heading` VARCHAR(160) NULL DEFAULT NULL AFTER `menu_images`,
    ADD COLUMN `vr360_embed`  VARCHAR(500) NULL DEFAULT NULL AFTER `vr360_url`;

ALTER TABLE `ht_restaurants_translations`
    ADD COLUMN `subtitle`     VARCHAR(160) NULL DEFAULT NULL,
    ADD COLUMN `menu_heading` VARCHAR(160) NULL DEFAULT NULL;

-- -----------------------------------------------------------------------------
-- 2. Banner + tiêu đề cho trang danh sách /nha-hang
-- -----------------------------------------------------------------------------

DELETE FROM `settings` WHERE `key` IN (
    'theme-riorelax-restaurants_banner_image',
    'theme-riorelax-restaurants_banner_title'
);

INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
    ('theme-riorelax-restaurants_banner_image',
     'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg',
     NOW(), NOW()),
    ('theme-riorelax-restaurants_banner_title', 'Ẩm thực Malibu', NOW(), NOW());

-- -----------------------------------------------------------------------------
-- 3. Nội dung 3 nhà hàng
--
--    Ảnh lấy từ malibuhotel.com.vn giống phần còn lại của site.
--    `menu_images` hiện dùng tạm ảnh không gian — thay bằng ảnh chụp thực đơn
--    thật khi có, chỉ cần sửa đúng chuỗi JSON bên dưới.
-- -----------------------------------------------------------------------------

-- 3.1 Vela Restaurant
UPDATE `ht_restaurants` SET
    `subtitle`     = 'The Malibu Hotel',
    `banner_image` = 'https://malibuhotel.com.vn/files/blog/46_1815/Anh_1_4_1.jpg',
    `menu_heading` = 'Buffet Á – Âu',
    `menu_images`  = JSON_ARRAY(
        'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg',
        'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-62.jpg',
        'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-64.jpg'
    )
WHERE `id` = 1;

-- 3.2 Carina Restaurant
UPDATE `ht_restaurants` SET
    `subtitle`     = 'The Malibu Hotel',
    `banner_image` = 'https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg',
    `menu_heading` = 'Signature Dishes',
    `menu_images`  = JSON_ARRAY(
        'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-65.jpg',
        'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-66.jpg',
        'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-67.jpg'
    )
WHERE `id` = 2;

-- 3.3 The Lux Café
UPDATE `ht_restaurants` SET
    `subtitle`     = 'The Malibu Hotel',
    `banner_image` = 'https://malibuhotel.com.vn/files/blog/46_1815/800x600_1__1.png',
    `menu_heading` = 'Coffee & Pastry',
    `menu_images`  = JSON_ARRAY(
        'https://malibuhotel.com.vn/files/blog/46_1815/DSC00288_1.jpg',
        'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-59.jpg',
        'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-61.jpg'
    )
WHERE `id` = 3;

-- -----------------------------------------------------------------------------
-- 4. (Về sau) Bật khung VR360 thay cho ảnh hero
--
--    Điền `vr360_embed` là hero tự đổi sang iframe, không phải sửa code.
--    Bỏ comment và thay URL thật:
-- -----------------------------------------------------------------------------

-- UPDATE `ht_restaurants` SET `vr360_embed` = 'https://vr360.example.com/vela' WHERE `id` = 1;
-- UPDATE `ht_restaurants` SET `vr360_embed` = 'https://vr360.example.com/carina' WHERE `id` = 2;
-- UPDATE `ht_restaurants` SET `vr360_embed` = 'https://vr360.example.com/lux-cafe' WHERE `id` = 3;

-- -----------------------------------------------------------------------------
-- 5. Kiểm tra
-- -----------------------------------------------------------------------------

SELECT `id`, `name`, `subtitle`, `banner_image`, `menu_heading`,
       JSON_LENGTH(`menu_images`) AS `so_anh_menu`
FROM `ht_restaurants`
ORDER BY `order`, `id`;
