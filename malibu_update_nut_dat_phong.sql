-- The Malibu Hotel — dua nut "DAT PHONG" ra Theme Options
-- Chay SAU khi da upload code.
-- An toan khi chay lai nhieu lan.
--
-- Sau khi chay, vao Dashboard > Appearance > Theme Options > Nut dat phong
-- de doi nhan, duong dan va mau bat cu luc nao.

SET NAMES utf8mb4;
START TRANSACTION;

INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
  ('theme-riorelax-booking_button_enabled', 'yes', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-booking_button_url', '', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-booking_button_new_tab', 'yes', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-booking_button_bg_color', 'rgb(228, 118, 44)', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-booking_button_text_color', '#ffffff', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-booking_button_hover_bg_color', 'rgb(190, 92, 26)', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-booking_panel_bg_color', 'rgb(22, 25, 44)', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-en_US-booking_button_enabled', 'yes', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-en_US-booking_button_url', '', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-en_US-booking_button_new_tab', 'yes', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-en_US-booking_button_bg_color', 'rgb(228, 118, 44)', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-en_US-booking_button_text_color', '#ffffff', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-en_US-booking_button_hover_bg_color', 'rgb(190, 92, 26)', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-en_US-booking_panel_bg_color', 'rgb(22, 25, 44)', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-booking_button_label', 'ĐẶT PHÒNG', NULL, '2026-09-04 08:00:00'),
  ('theme-riorelax-en_US-booking_button_label', 'BOOK NOW', NULL, '2026-09-04 08:00:00')
ON DUPLICATE KEY UPDATE `value` = VALUES(`value`), `updated_at` = VALUES(`updated_at`);

COMMIT;

-- Kiem tra lai
SELECT `key`, `value` FROM `settings` WHERE `key` LIKE '%booking\_button\_%' OR `key` LIKE '%booking\_panel\_%' ORDER BY `key`;

-- Sau khi chay xong, tren server chay: php artisan optimize:clear
