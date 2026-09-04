-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th9 03, 2026 lúc 09:15 PM
-- Phiên bản máy phục vụ: 10.6.5-MariaDB
-- Phiên bản PHP: 8.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `travellink_malibu`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `activations`
--

DROP TABLE IF EXISTS `activations`;
CREATE TABLE `activations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'malibu00000000000000000000000000', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00', '2026-09-04 08:00:00');

--
-- Đang đổ dữ liệu cho bảng `activations`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin_notifications`
--

DROP TABLE IF EXISTS `admin_notifications`;
CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permission` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ai_training_contexts`
--

DROP TABLE IF EXISTS `ai_training_contexts`;
CREATE TABLE `ai_training_contexts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `source_language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `target_language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `source_term` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_term` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `context_instruction` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ai_translation_logs`
--

DROP TABLE IF EXISTS `ai_translation_logs`;
CREATE TABLE `ai_translation_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source_language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_language` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `field_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `input_tokens` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `output_tokens` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `ai_model` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estimated_cost` decimal(10,6) NOT NULL DEFAULT 0.000000,
  `api_key_hash` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ai_translation_logs`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `audit_histories`
--

DROP TABLE IF EXISTS `audit_histories`;
CREATE TABLE `audit_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'Botble\\ACL\\Models\\User',
  `module` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actor_id` bigint(20) UNSIGNED NOT NULL,
  `actor_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'Botble\\ACL\\Models\\User',
  `reference_id` bigint(20) UNSIGNED NOT NULL,
  `reference_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `audit_histories`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Botble\\ACL\\Models\\User',
  `icon` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_featured` tinyint(4) NOT NULL DEFAULT 0,
  `is_default` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `description`, `status`, `author_id`, `author_type`, `icon`, `order`, `is_featured`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Ưu đãi', 0, 'Các gói ưu đãi lưu trú và ẩm thực đang áp dụng tại The Malibu Hotel.', 'published', 1, 'Botble\\ACL\\Models\\User', NULL, 0, 1, 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'Tiện nghi', 0, 'M Pool, M Spa, M Gym và các tiện ích khác trong khách sạn.', 'published', 1, 'Botble\\ACL\\Models\\User', NULL, 1, 1, 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'Ẩm thực', 0, 'Nhà hàng Vela, Carina và The Lux Café.', 'published', 1, 'Botble\\ACL\\Models\\User', NULL, 2, 1, 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'Hội nghị &amp; Sự kiện', 0, 'Hội nghị, hội thảo và tiệc tại The Malibu Hotel.', 'published', 1, 'Botble\\ACL\\Models\\User', NULL, 3, 0, 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'Khám phá Vũng Tàu', 0, 'Điểm đến và trải nghiệm quanh The Malibu Hotel.', 'published', 1, 'Botble\\ACL\\Models\\User', NULL, 4, 0, 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories_translations`
--

DROP TABLE IF EXISTS `categories_translations`;
CREATE TABLE `categories_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `categories_translations` (`lang_code`, `categories_id`, `name`, `description`) VALUES
('en_US', 1, 'Offers', 'Current stay and dining packages at The Malibu Hotel.'),
('en_US', 2, 'Facilities', 'M Pool, M Spa, M Gym and the hotel\'s other facilities.'),
('en_US', 3, 'Dining', 'Vela and Carina restaurants and The Lux Café.'),
('en_US', 4, 'Meetings &amp; Events', 'Conferences, seminars and banquets at The Malibu Hotel.'),
('en_US', 5, 'Explore Vung Tau', 'Destinations and experiences around The Malibu Hotel.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_fields` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_custom_fields`
--

DROP TABLE IF EXISTS `contact_custom_fields`;
CREATE TABLE `contact_custom_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeholder` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 999,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_custom_fields_translations`
--

DROP TABLE IF EXISTS `contact_custom_fields_translations`;
CREATE TABLE `contact_custom_fields_translations` (
  `contact_custom_fields_id` bigint(20) UNSIGNED NOT NULL,
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placeholder` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_custom_field_options`
--

DROP TABLE IF EXISTS `contact_custom_field_options`;
CREATE TABLE `contact_custom_field_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `custom_field_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT 999,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_custom_field_options_translations`
--

DROP TABLE IF EXISTS `contact_custom_field_options_translations`;
CREATE TABLE `contact_custom_field_options_translations` (
  `contact_custom_field_options_id` bigint(20) UNSIGNED NOT NULL,
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contact_replies`
--

DROP TABLE IF EXISTS `contact_replies`;
CREATE TABLE `contact_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `contact_replies`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dashboard_widgets`
--

DROP TABLE IF EXISTS `dashboard_widgets`;
CREATE TABLE `dashboard_widgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dashboard_widgets`
--

INSERT INTO `dashboard_widgets` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'widget_total_themes', '2026-03-13 01:29:32', '2026-03-13 01:29:32'),
(2, 'widget_total_users', '2026-03-13 01:29:32', '2026-03-13 01:29:32'),
(3, 'widget_total_plugins', '2026-03-13 01:29:32', '2026-03-13 01:29:32'),
(4, 'widget_total_pages', '2026-03-13 01:29:32', '2026-03-13 01:29:32'),
(5, 'widget_posts_recent', '2026-03-13 01:29:32', '2026-03-13 01:29:32'),
(6, 'widget_audit_logs', '2026-03-13 01:29:32', '2026-03-13 01:29:32'),
(7, 'widget_analytics_general', '2026-04-27 02:34:13', '2026-04-27 02:34:13'),
(8, 'widget_analytics_page', '2026-04-27 02:34:13', '2026-04-27 02:34:13'),
(9, 'widget_analytics_browser', '2026-04-27 02:34:13', '2026-04-27 02:34:13'),
(10, 'widget_analytics_referrer', '2026-04-27 02:34:13', '2026-04-27 02:34:13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dashboard_widget_settings`
--

DROP TABLE IF EXISTS `dashboard_widget_settings`;
CREATE TABLE `dashboard_widget_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `widget_id` bigint(20) UNSIGNED NOT NULL,
  `order` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dashboard_widget_settings`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `category_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'The Malibu Hotel nằm ở đâu?', 'Khách sạn toạ lạc tại 263 Lê Hồng Phong, P. Thắng Tam, TP. Vũng Tàu – ngay trung tâm thành phố và chỉ vài phút đi bộ tới bãi biển Bãi Sau.', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'Khách sạn có bao nhiêu phòng?', 'The Malibu Hotel có 197 phòng nghỉ trong toà nhà 23 tầng, chia thành 4 hạng: Premier, Diamond, Suite và President.', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'Giờ nhận và trả phòng là mấy giờ?', 'Nhận phòng từ 14:00 và trả phòng trước 12:00. Nhận phòng sớm hoặc trả phòng muộn tuỳ thuộc tình trạng phòng trống và có thể phát sinh phụ thu.', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'Khách sạn có nhận thú cưng không?', 'Để bảo đảm tiêu chuẩn vệ sinh và sự thoải mái cho tất cả khách lưu trú, khách sạn không nhận thú cưng.', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'Khách sạn có bãi đỗ xe không?', 'Có. Khách sạn có 2 tầng hầm đỗ xe dành cho khách lưu trú, có bảo vệ trực 24/7.', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'Giá phòng đã bao gồm bữa sáng chưa?', 'Giá phòng bao gồm buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), cùng quyền sử dụng hồ bơi M Pool và phòng tập M Gym.', 2, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 'Phòng nào có bồn tắm?', 'Các hạng Diamond, Suite và President đều có bồn tắm riêng. Hạng Premier sử dụng phòng tắm vòi sen.', 2, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 'Khách sạn có Wi-Fi miễn phí không?', 'Có. Internet tốc độ cao được cung cấp miễn phí trong phòng và toàn bộ khu vực công cộng của khách sạn.', 2, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 'Hồ bơi và phòng gym mở cửa giờ nào?', 'M Pool mở cửa 07:00 – 19:00 hằng ngày. M Gym mở cửa 06:00 – 22:00. M Spa phục vụ từ 10:00 đến 20:00.', 2, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 'Khách sạn có bao nhiêu phòng hội nghị?', 'Khách sạn có 7 phòng hội nghị với sức chứa lên đến 450 khách. Phòng Malibu Grand có thể ngăn thành 3 phòng nhỏ, mỗi phòng 120 khách.', 3, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 'Khách sạn có tổ chức tiệc cưới không?', 'Có. Malibu phục vụ tiệc cưới từ 50 đến 450 khách, hỗ trợ trọn gói từ thực đơn, trang trí đến âm thanh ánh sáng. Liên hệ dos@malibuhotel.com.vn để nhận báo giá.', 3, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 'Khách sạn có an ninh 24/7 không?', 'Có. Khách sạn duy trì lễ tân và an ninh trực 24/7, hệ thống camera giám sát và két sắt trong từng phòng để quý khách bảo quản tài sản có giá trị.', 4, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, 'Dịch vụ giặt ủi được xử lý như thế nào?', 'Khách sạn vận hành xưởng giặt khép kín của riêng mình, không dùng dịch vụ bên thứ ba. Toàn bộ đồ vải được phân loại, giặt, tiệt trùng và hấp kỹ lưỡng, phục vụ 24/24.', 4, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(14, 'Từ khách sạn tới bãi biển bao xa?', 'Bãi Sau (Thuỳ Vân) chỉ cách khách sạn khoảng 450 m, tương đương 6 phút đi bộ.', 5, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(15, 'Gần khách sạn có những điểm tham quan nào?', 'Tượng Chúa Kitô Vua, Ngọn Hải Đăng Vũng Tàu, Bạch Dinh, khu du lịch Hồ Mây và chợ hải sản Xóm Lưới đều nằm trong bán kính 5 km từ khách sạn.', 5, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faqs_translations`
--

DROP TABLE IF EXISTS `faqs_translations`;
CREATE TABLE `faqs_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faqs_id` bigint(20) UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `faqs_translations` (`lang_code`, `faqs_id`, `question`, `answer`) VALUES
('en_US', 1, 'Where is The Malibu Hotel located?', 'The hotel is at 263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City – in the centre of the city and a few minutes\' walk from Back Beach.'),
('en_US', 2, 'How many rooms does the hotel have?', 'The Malibu Hotel has 197 guest rooms in a 23-storey tower, across four categories: Premier, Diamond, Suite and President.'),
('en_US', 3, 'What are the check-in and check-out times?', 'Check-in is from 14:00 and check-out is before 12:00. Early check-in and late check-out are subject to availability and may incur a surcharge.'),
('en_US', 4, 'Are pets allowed at the hotel?', 'To maintain hygiene standards and the comfort of all guests, pets are not permitted at the hotel.'),
('en_US', 5, 'Is there parking at the hotel?', 'Yes. The hotel has two basement parking levels for guests, with security on duty 24/7.'),
('en_US', 6, 'Is breakfast included in the room rate?', 'Room rates include a breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor), plus access to the M Pool and M Gym.'),
('en_US', 7, 'Which rooms have a bathtub?', 'The Diamond, Suite and President categories all have a private bathtub. Premier rooms have a shower.'),
('en_US', 8, 'Is Wi-Fi free?', 'Yes. Complimentary high-speed internet is available in all rooms and throughout the public areas of the hotel.'),
('en_US', 9, 'What are the pool and gym hours?', 'M Pool is open 7:00 am – 7:00 pm daily, M Gym 6:00 am – 10:00 pm, and M Spa serves from 10:00 am to 8:00 pm.'),
('en_US', 10, 'How many conference rooms are there?', 'The hotel has seven conference rooms for up to 450 guests. The Malibu Grand room can be divided into three rooms of 120 guests each.'),
('en_US', 11, 'Do you host weddings?', 'Yes. Malibu hosts weddings from 50 to 450 guests with full support for menus, decoration, sound and lighting. Contact dos@malibuhotel.com.vn for a proposal.'),
('en_US', 12, 'Is there 24/7 security?', 'Yes. The hotel maintains a 24/7 front desk and security team, CCTV coverage and an in-room safe in every room for your valuables.'),
('en_US', 13, 'How is laundry handled?', 'The hotel runs its own fully closed-cycle laundry without any third-party service. All fabrics are sorted, washed, pasteurised and steamed thoroughly, available 24/7.'),
('en_US', 14, 'How far is the beach?', 'Back Beach (Thuy Van) is about 450 m from the hotel, roughly a 6-minute walk.'),
('en_US', 15, 'What attractions are nearby?', 'The Christ the King statue, Vung Tau Lighthouse, Bach Dinh, Ho May Park and the Xom Luoi seafood market are all within 5 km of the hotel.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faq_categories`
--

DROP TABLE IF EXISTS `faq_categories`;
CREATE TABLE `faq_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` tinyint(4) NOT NULL DEFAULT 0,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `faq_categories`
--

INSERT INTO `faq_categories` (`id`, `name`, `order`, `status`, `created_at`, `updated_at`, `description`) VALUES
(1, 'Thông tin chung', 0, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', NULL),
(2, 'Phòng nghỉ &amp; Tiện nghi', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', NULL),
(3, 'Hội nghị &amp; Sự kiện', 2, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', NULL),
(4, 'An toàn &amp; Sức khoẻ', 3, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', NULL),
(5, 'Khám phá Vũng Tàu', 4, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', NULL);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faq_categories_translations`
--

DROP TABLE IF EXISTS `faq_categories_translations`;
CREATE TABLE `faq_categories_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faq_categories_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `faq_categories_translations` (`lang_code`, `faq_categories_id`, `name`) VALUES
('en_US', 1, 'General Information'),
('en_US', 2, 'Accommodations and Amenities'),
('en_US', 3, 'Meetings and Events'),
('en_US', 4, 'Safety and Health'),
('en_US', 5, 'Exploring Vung Tau');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `galleries`
--

DROP TABLE IF EXISTS `galleries`;
CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `order` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `galleries`
--

INSERT INTO `galleries` (`id`, `name`, `description`, `is_featured`, `order`, `image`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(6, 'Toàn cảnh khách sạn', '<p>Toà nhà 23 tầng bên bờ biển Vũng Tàu và những góc nhìn đẹp nhất của Malibu.</p>', 1, 0, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 'Phòng nghỉ', '<p>197 phòng nghỉ từ Premier đến Presidential Suite, tất cả đều hướng biển.</p>', 1, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05931-HDR.jpg', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 'Nhà hàng', '<p>Vela Restaurant, Carina Restaurant và The Lux Café.</p>', 1, 2, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 'Hội nghị &amp; sự kiện', '<p>7 phòng hội nghị linh hoạt, sức chứa tới 450 khách.</p>', 1, 3, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/z7304583041023_6639f72ca0fe6cc33e22cbd47eedd674.jpg', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 'Hồ bơi M Pool', '<p>Hồ bơi ngoài trời tầng 6 với tầm nhìn toàn cảnh thành phố.</p>', 0, 4, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-36.jpg', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 'Phòng tập M Gym', '<p>Phòng tập 100 m² với trang thiết bị hiện đại.</p>', 0, 5, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc6/M-POOL-MALIBU-HOTEL-56.jpg', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 'M Spa', '<p>Không gian trị liệu yên tĩnh với thảo dược tự nhiên.</p>', 0, 6, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-52.jpg', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, 'Giải trí', '<p>Golf 3D, billiard, bi lắc và khu vui chơi trẻ em.</p>', 0, 7, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc8/M-POOL-MALIBU-HOTEL-37.jpg', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `galleries_translations`
--

DROP TABLE IF EXISTS `galleries_translations`;
CREATE TABLE `galleries_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `galleries_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `galleries_translations`
--

INSERT INTO `galleries_translations` (`lang_code`, `galleries_id`, `name`, `description`) VALUES
('en_US', 6, 'Hotel Landscape', '<p>The 23-storey tower by the Vung Tau shoreline and the finest views of Malibu.</p>'),
('en_US', 7, 'Rooms &amp; Suites', '<p>197 guest rooms from Premier to the Presidential Suite, all facing the sea.</p>'),
('en_US', 8, 'Restaurants', '<p>Vela Restaurant, Carina Restaurant and The Lux Café.</p>'),
('en_US', 9, 'Meetings &amp; Events', '<p>Seven flexible conference rooms for up to 450 guests.</p>'),
('en_US', 10, 'M Pool', '<p>The 6th-floor outdoor pool with panoramic city views.</p>'),
('en_US', 11, 'M Gym', '<p>A 100 sqm gym with modern equipment.</p>'),
('en_US', 12, 'M Spa', '<p>A quiet treatment space using natural herbs.</p>'),
('en_US', 13, 'Entertainment', '<p>3D golf, billiards, foosball and the children\'s play area.</p>');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gallery_meta`
--

DROP TABLE IF EXISTS `gallery_meta`;
CREATE TABLE `gallery_meta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gallery_meta`
--

INSERT INTO `gallery_meta` (`id`, `images`, `reference_id`, `reference_type`, `created_at`, `updated_at`) VALUES
(6, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00288.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00671_edit.png\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00703.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-162.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-159.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-160.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL1.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL2.jpg\", \"description\": \"\"}]', 6, 'Botble\\Gallery\\Models\\Gallery', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05931-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05872-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05856-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05759-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05756-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05807-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05787-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05734-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05937-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05958-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05961-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05955-HDR.jpg\", \"description\": \"\"}]', 7, 'Botble\\Gallery\\Models\\Gallery', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-69.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-68.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-67.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-66.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-65.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-64.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-63.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-62.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-61.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-60.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-59.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-58.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-57.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/VELA.png\", \"description\": \"\"}]', 8, 'Botble\\Gallery\\Models\\Gallery', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/z7304583041023_6639f72ca0fe6cc33e22cbd47eedd674.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/DSC00228.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-86.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-83.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-91.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-89.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-80.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-75.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-71.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-74.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-19.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-22.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-21.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-06.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-05.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-04.jpg\", \"description\": \"\"}]', 9, 'Botble\\Gallery\\Models\\Gallery', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-36.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-26.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-25.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-37.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-38.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-39.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-35.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-34.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-32.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-33.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-27.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-28.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-23.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-24.jpg\", \"description\": \"\"}]', 10, 'Botble\\Gallery\\Models\\Gallery', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc6/M-POOL-MALIBU-HOTEL-56.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc6/M-POOL-MALIBU-HOTEL-55.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc6/M-POOL-MALIBU-HOTEL-54.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc6/image-gym.jpg\", \"description\": \"\"}]', 11, 'Botble\\Gallery\\Models\\Gallery', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-52.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-53.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-50.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-51.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-49.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-48.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-47.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-46.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-45.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-44.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-43.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-42.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-41.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-40.jpg\", \"description\": \"\"}]', 12, 'Botble\\Gallery\\Models\\Gallery', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc8/M-POOL-MALIBU-HOTEL-37.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc8/M-POOL-MALIBU-HOTEL-29.jpg\", \"description\": \"\"}]', 13, 'Botble\\Gallery\\Models\\Gallery', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gallery_meta_translations`
--

DROP TABLE IF EXISTS `gallery_meta_translations`;
CREATE TABLE `gallery_meta_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_meta_id` bigint(20) UNSIGNED NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `gallery_meta_translations`
--

INSERT INTO `gallery_meta_translations` (`lang_code`, `gallery_meta_id`, `images`) VALUES
('en_US', 6, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00288.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00671_edit.png\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00703.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-162.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-159.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-160.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL1.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL2.jpg\", \"description\": \"\"}]'),
('en_US', 7, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05931-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05872-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05856-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05759-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05756-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05807-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05787-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05734-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05937-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05958-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05961-HDR.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05955-HDR.jpg\", \"description\": \"\"}]'),
('en_US', 8, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-69.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-68.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-67.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-66.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-65.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-64.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-63.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-62.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-61.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-60.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-59.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-58.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-57.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/VELA.png\", \"description\": \"\"}]'),
('en_US', 9, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/z7304583041023_6639f72ca0fe6cc33e22cbd47eedd674.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/DSC00228.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-86.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-83.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-91.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-89.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-80.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-75.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-71.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-74.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-19.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-22.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-21.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-06.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-05.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-04.jpg\", \"description\": \"\"}]'),
('en_US', 10, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-36.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-26.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-25.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-37.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-38.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-39.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-35.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-34.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-32.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-33.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-27.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-28.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-23.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-24.jpg\", \"description\": \"\"}]'),
('en_US', 11, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc6/M-POOL-MALIBU-HOTEL-56.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc6/M-POOL-MALIBU-HOTEL-55.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc6/M-POOL-MALIBU-HOTEL-54.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc6/image-gym.jpg\", \"description\": \"\"}]'),
('en_US', 12, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-52.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-53.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-50.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-51.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-49.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-48.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-47.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-46.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-45.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-44.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-43.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-42.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-41.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc7/M-POOL-MALIBU-HOTEL-40.jpg\", \"description\": \"\"}]'),
('en_US', 13, '[{\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc8/M-POOL-MALIBU-HOTEL-37.jpg\", \"description\": \"\"}, {\"img\": \"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc8/M-POOL-MALIBU-HOTEL-29.jpg\", \"description\": \"\"}]');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_amenities`
--

DROP TABLE IF EXISTS `ht_amenities`;
CREATE TABLE `ht_amenities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_amenities`
--

INSERT INTO `ht_amenities` (`id`, `name`, `description`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Điều hoà nhiệt độ', '', 'fal fa-snowflake', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'Wi-Fi tốc độ cao miễn phí', '', 'fal fa-wifi', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'Két sắt an toàn', '', 'fal fa-key', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'Buffet sáng tại nhà hàng Vela', '', 'fal fa-utensils', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'TV màn hình phẳng truyền hình cáp', '', 'fal fa-tv', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'Minibar', '', 'fal fa-glass-martini', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 'Ấm đun nước, trà và cà phê', '', 'fal fa-mug-hot', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 'Phòng tắm vòi sen', '', 'fal fa-shower', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 'Bồn tắm', '', 'fal fa-bath', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 'Ban công riêng', '', 'fal fa-door-open', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 'Máy sấy tóc', '', 'fal fa-wind', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 'Bàn làm việc', '', 'fal fa-laptop', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, 'Dọn phòng hằng ngày', '', 'fal fa-broom', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(14, 'Đồ dùng phòng tắm cao cấp', '', 'fal fa-pump-soap', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(15, 'Lễ tân hỗ trợ 24/7', '', 'fal fa-headphones-alt', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(16, 'Tầm nhìn hướng biển', '', 'fal fa-water', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_amenities_translations`
--

DROP TABLE IF EXISTS `ht_amenities_translations`;
CREATE TABLE `ht_amenities_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_amenities_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_amenities_translations`
--

INSERT INTO `ht_amenities_translations` (`lang_code`, `ht_amenities_id`, `name`, `description`) VALUES
('en_US', 1, 'Air Conditioning', NULL),
('en_US', 2, 'Complimentary High-speed Wi-Fi', NULL),
('en_US', 3, 'In-room Safe', NULL),
('en_US', 4, 'Breakfast Buffet at Vela Restaurant', NULL),
('en_US', 5, 'Flat-screen TV with Cable Channels', NULL),
('en_US', 6, 'Minibar', NULL),
('en_US', 7, 'Electric Kettle, Tea &amp; Coffee', NULL),
('en_US', 8, 'Shower', NULL),
('en_US', 9, 'Bathtub', NULL),
('en_US', 10, 'Private Balcony', NULL),
('en_US', 11, 'Hair Dryer', NULL),
('en_US', 12, 'Work Desk', NULL),
('en_US', 13, 'Daily Housekeeping', NULL),
('en_US', 14, 'Premium Bathroom Amenities', NULL),
('en_US', 15, '24/7 Front Desk Assistance', NULL),
('en_US', 16, 'Sea View', NULL);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_bookings`
--

DROP TABLE IF EXISTS `ht_bookings`;
CREATE TABLE `ht_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL,
  `sub_total` decimal(15,2) UNSIGNED NOT NULL,
  `coupon_amount` decimal(15,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_amount` decimal(15,2) NOT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `requests` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `arrival_time` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_guests` int(11) DEFAULT NULL,
  `number_of_children` int(11) NOT NULL DEFAULT 0,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_booking_addresses`
--

DROP TABLE IF EXISTS `ht_booking_addresses`;
CREATE TABLE `ht_booking_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_booking_foods`
--

DROP TABLE IF EXISTS `ht_booking_foods`;
CREATE TABLE `ht_booking_foods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `food_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_booking_rooms`
--

DROP TABLE IF EXISTS `ht_booking_rooms`;
CREATE TABLE `ht_booking_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `room_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `number_of_rooms` int(11) NOT NULL DEFAULT 1,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_booking_services`
--

DROP TABLE IF EXISTS `ht_booking_services`;
CREATE TABLE `ht_booking_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_coupons`
--

DROP TABLE IF EXISTS `ht_coupons`;
CREATE TABLE `ht_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(8,2) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `total_used` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `expires_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_coupons`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_currencies`
--

DROP TABLE IF EXISTS `ht_currencies`;
CREATE TABLE `ht_currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbol` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_prefix_symbol` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `decimals` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_default` tinyint(4) NOT NULL DEFAULT 0,
  `exchange_rate` double NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_currencies`
--

INSERT INTO `ht_currencies` (`id`, `title`, `symbol`, `is_prefix_symbol`, `decimals`, `order`, `is_default`, `exchange_rate`, `created_at`, `updated_at`) VALUES
(1, 'USD', '$', 1, 2, 0, 1, 1, '2025-06-10 10:38:04', '2025-06-10 10:38:04'),
(2, 'EUR', '€', 0, 2, 1, 0, 0.91, '2025-06-10 10:38:04', '2025-06-10 10:38:04'),
(3, 'VND', '₫', 0, 0, 2, 0, 23717.5, '2025-06-10 10:38:04', '2025-06-10 10:38:04');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_customers`
--

DROP TABLE IF EXISTS `ht_customers`;
CREATE TABLE `ht_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_customers`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_customer_password_resets`
--

DROP TABLE IF EXISTS `ht_customer_password_resets`;
CREATE TABLE `ht_customer_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_features`
--

DROP TABLE IF EXISTS `ht_features`;
CREATE TABLE `ht_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_features`
--

INSERT INTO `ht_features` (`id`, `name`, `description`, `icon`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Khách sạn 5 sao trung tâm Vũng Tàu', 'Toà nhà 23 tầng với 197 phòng nghỉ, kiến trúc châu Âu hiện đại, toạ lạc ngay trung tâm thành phố biển Vũng Tàu.', 'flaticon-rating', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'Mọi phòng đều hướng biển', 'Tất cả phòng nghỉ tại Malibu đều có tầm nhìn hướng ra đại dương và một phần ôm trọn thành phố Vũng Tàu.', 'flaticon-location-pin', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, '6 tầng dịch vụ trọn vẹn', 'Hồ bơi M Pool, M Spa, M Gym, Kid Zone, Gift Shop và khu giải trí phục vụ suốt kỳ nghỉ của bạn.', 'flaticon-clock', 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'Lễ tân và an ninh 24/7', 'Đội ngũ lễ tân trực 24 giờ mỗi ngày cùng hệ thống an ninh giám sát liên tục toàn khuôn viên.', 'flaticon-clock-1', 0, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, '7 phòng hội nghị, sức chứa 450 khách', 'Hệ thống phòng họp linh hoạt với âm thanh chuẩn quốc tế, màn hình LED và máy chiếu hiện đại.', 'flaticon-credit-card', 0, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'Ẩm thực Vela &amp; Carina', 'Buffet sáng hơn 40 món tại Vela Restaurant và ẩm thực Á – Âu tại Carina Restaurant tầng 6.', 'flaticon-discount', 0, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_features_translations`
--

DROP TABLE IF EXISTS `ht_features_translations`;
CREATE TABLE `ht_features_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_features_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ht_features_translations` (`lang_code`, `ht_features_id`, `name`, `description`) VALUES
('en_US', 1, 'Five-star Hotel in Downtown Vung Tau', 'A 23-storey tower with 197 guest rooms and modern European architecture, right in the heart of the coastal city of Vung Tau.'),
('en_US', 2, 'Ocean Views from Every Room', 'Every room at Malibu looks out over the ocean and embraces part of the Vung Tau cityscape.'),
('en_US', 3, 'Six Floors of Facilities', 'M Pool, M Spa, M Gym, the Kid Zone, the Gift Shop and the entertainment area serve you throughout your stay.'),
('en_US', 4, '24/7 Front Desk and Security', 'Our front desk is staffed around the clock, with security monitoring the property continuously.'),
('en_US', 5, '7 Conference Rooms for up to 450 Guests', 'Flexible meeting spaces with international-standard sound systems, modern LED screens and projectors.'),
('en_US', 6, 'Dining at Vela &amp; Carina', 'A breakfast buffet of more than 40 dishes at Vela Restaurant and Asian-European cuisine at Carina Restaurant on the 6th floor.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_foods`
--

DROP TABLE IF EXISTS `ht_foods`;
CREATE TABLE `ht_foods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,0) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `food_type_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_foods`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_foods_translations`
--

DROP TABLE IF EXISTS `ht_foods_translations`;
CREATE TABLE `ht_foods_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_foods_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_food_types`
--

DROP TABLE IF EXISTS `ht_food_types`;
CREATE TABLE `ht_food_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_food_types`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_food_types_translations`
--

DROP TABLE IF EXISTS `ht_food_types_translations`;
CREATE TABLE `ht_food_types_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_food_types_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_ical_sync_logs`
--

DROP TABLE IF EXISTS `ht_ical_sync_logs`;
CREATE TABLE `ht_ical_sync_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `calendar_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_invoices`
--

DROP TABLE IF EXISTS `ht_invoices`;
CREATE TABLE `ht_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_total` decimal(15,2) UNSIGNED NOT NULL,
  `tax_amount` decimal(15,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `amount` decimal(15,2) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_invoices`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_invoice_items`
--

DROP TABLE IF EXISTS `ht_invoice_items`;
CREATE TABLE `ht_invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `sub_total` decimal(15,2) UNSIGNED NOT NULL,
  `tax_amount` decimal(15,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `amount` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_invoice_items`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_places`
--

DROP TABLE IF EXISTS `ht_places`;
CREATE TABLE `ht_places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distance` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_places`
--

INSERT INTO `ht_places` (`id`, `name`, `distance`, `description`, `content`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bãi Sau (Thuỳ Vân)', 'khoảng 450 m | 6 phút đi bộ', 'Bãi biển dài và thoải nhất Vũng Tàu, chỉ vài phút đi bộ từ khách sạn.', '<div class=\"service-detail\"><p>Bãi biển dài và thoải nhất Vũng Tàu, chỉ vài phút đi bộ từ khách sạn.</p><h3>Khoảng cách</h3><p>khoảng 450 m | 6 phút đi bộ từ The Malibu Hotel.</p></div>', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'Tượng Chúa Kitô Vua', 'khoảng 2,5 km | 8 phút lái xe', 'Bức tượng 32 m trên đỉnh Núi Nhỏ với 811 bậc thang và tầm nhìn toàn cảnh thành phố biển.', '<div class=\"service-detail\"><p>Bức tượng 32 m trên đỉnh Núi Nhỏ với 811 bậc thang và tầm nhìn toàn cảnh thành phố biển.</p><h3>Khoảng cách</h3><p>khoảng 2,5 km | 8 phút lái xe từ The Malibu Hotel.</p></div>', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00703.jpg', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'Ngọn Hải Đăng Vũng Tàu', 'khoảng 3,5 km | 10 phút lái xe', 'Hải đăng hơn 100 năm tuổi trên Núi Nhỏ, điểm ngắm hoàng hôn đẹp nhất Vũng Tàu.', '<div class=\"service-detail\"><p>Hải đăng hơn 100 năm tuổi trên Núi Nhỏ, điểm ngắm hoàng hôn đẹp nhất Vũng Tàu.</p><h3>Khoảng cách</h3><p>khoảng 3,5 km | 10 phút lái xe từ The Malibu Hotel.</p></div>', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'Bạch Dinh', 'khoảng 4,5 km | 12 phút lái xe', 'Dinh thự Pháp cổ xây năm 1898 bên sườn Núi Lớn, nay là bảo tàng cổ vật.', '<div class=\"service-detail\"><p>Dinh thự Pháp cổ xây năm 1898 bên sườn Núi Lớn, nay là bảo tàng cổ vật.</p><h3>Khoảng cách</h3><p>khoảng 4,5 km | 12 phút lái xe từ The Malibu Hotel.</p></div>', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00703.jpg', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'Khu du lịch Hồ Mây', 'khoảng 4 km | 12 phút lái xe', 'Công viên trên đỉnh Núi Lớn với cáp treo, hồ nước và khu vui chơi cho cả gia đình.', '<div class=\"service-detail\"><p>Công viên trên đỉnh Núi Lớn với cáp treo, hồ nước và khu vui chơi cho cả gia đình.</p><h3>Khoảng cách</h3><p>khoảng 4 km | 12 phút lái xe từ The Malibu Hotel.</p></div>', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'Chợ hải sản Xóm Lưới', 'khoảng 4 km | 11 phút lái xe', 'Khu chợ hải sản tươi sống nổi tiếng, nhộn nhịp nhất vào sáng sớm và buổi tối.', '<div class=\"service-detail\"><p>Khu chợ hải sản tươi sống nổi tiếng, nhộn nhịp nhất vào sáng sớm và buổi tối.</p><h3>Khoảng cách</h3><p>khoảng 4 km | 11 phút lái xe từ The Malibu Hotel.</p></div>', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_places_translations`
--

DROP TABLE IF EXISTS `ht_places_translations`;
CREATE TABLE `ht_places_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_places_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distance` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ht_places_translations` (`lang_code`, `ht_places_id`, `name`, `distance`, `description`, `content`) VALUES
('en_US', 1, 'Back Beach (Thuy Van)', 'approx. 450 m | 6 min walk', 'Vung Tau\'s longest and gentlest beach, a few minutes\' walk from the hotel.', '<div class=\"service-detail\"><p>Vung Tau\'s longest and gentlest beach, a few minutes\' walk from the hotel.</p><h3>Distance</h3><p>approx. 450 m | 6 min walk from The Malibu Hotel.</p></div>'),
('en_US', 2, 'Christ the King Statue', 'approx. 2.5 km | 8 min drive', 'A 32-metre statue atop Nui Nho mountain, reached by 811 steps, with panoramic views over the coastal city.', '<div class=\"service-detail\"><p>A 32-metre statue atop Nui Nho mountain, reached by 811 steps, with panoramic views over the coastal city.</p><h3>Distance</h3><p>approx. 2.5 km | 8 min drive from The Malibu Hotel.</p></div>'),
('en_US', 3, 'Vung Tau Lighthouse', 'approx. 3.5 km | 10 min drive', 'A century-old lighthouse on Nui Nho hill and the finest sunset viewpoint in Vung Tau.', '<div class=\"service-detail\"><p>A century-old lighthouse on Nui Nho hill and the finest sunset viewpoint in Vung Tau.</p><h3>Distance</h3><p>approx. 3.5 km | 10 min drive from The Malibu Hotel.</p></div>'),
('en_US', 4, 'Bach Dinh (White Palace)', 'approx. 4.5 km | 12 min drive', 'A French colonial villa built in 1898 on the slope of Nui Lon, now an antiquities museum.', '<div class=\"service-detail\"><p>A French colonial villa built in 1898 on the slope of Nui Lon, now an antiquities museum.</p><h3>Distance</h3><p>approx. 4.5 km | 12 min drive from The Malibu Hotel.</p></div>'),
('en_US', 5, 'Ho May Park', 'approx. 4 km | 12 min drive', 'A hilltop park on Nui Lon with a cable car, a lake and family attractions.', '<div class=\"service-detail\"><p>A hilltop park on Nui Lon with a cable car, a lake and family attractions.</p><h3>Distance</h3><p>approx. 4 km | 12 min drive from The Malibu Hotel.</p></div>'),
('en_US', 6, 'Xom Luoi Seafood Market', 'approx. 4 km | 11 min drive', 'Vung Tau\'s best-known fresh seafood market, busiest at dawn and in the evening.', '<div class=\"service-detail\"><p>Vung Tau\'s best-known fresh seafood market, busiest at dawn and in the evening.</p><h3>Distance</h3><p>approx. 4 km | 11 min drive from The Malibu Hotel.</p></div>');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_products`
--

DROP TABLE IF EXISTS `ht_products`;
CREATE TABLE `ht_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) UNSIGNED DEFAULT 0.00,
  `original_price` decimal(15,2) UNSIGNED DEFAULT NULL,
  `sale_start_date` date DEFAULT NULL,
  `sale_end_date` date DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_sold` int(10) UNSIGNED DEFAULT 0,
  `is_featured` tinyint(3) UNSIGNED DEFAULT 0,
  `enable_booking` tinyint(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Enable date/time booking for this product',
  `service_start_time` time DEFAULT NULL COMMENT 'Service start time (e.g. 08:00)',
  `service_end_time` time DEFAULT NULL COMMENT 'Service end time (e.g. 22:00)',
  `service_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Available days of week: 0=Sun,1=Mon,...,6=Sat' CHECK (json_valid(`service_days`)),
  `time_slot_duration` int(10) UNSIGNED NOT NULL DEFAULT 60 COMMENT 'Time slot duration in minutes',
  `order` int(10) UNSIGNED DEFAULT 0,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_products_translations`
--

DROP TABLE IF EXISTS `ht_products_translations`;
CREATE TABLE `ht_products_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_products_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_products_translations`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_product_categories`
--

DROP TABLE IF EXISTS `ht_product_categories`;
CREATE TABLE `ht_product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(10) UNSIGNED DEFAULT 0,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_product_categories_translations`
--

DROP TABLE IF EXISTS `ht_product_categories_translations`;
CREATE TABLE `ht_product_categories_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_product_categories_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_product_orders`
--

DROP TABLE IF EXISTS `ht_product_orders`;
CREATE TABLE `ht_product_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_date` date DEFAULT NULL COMMENT 'Customer selected service date',
  `service_time` time DEFAULT NULL COMMENT 'Customer selected service time',
  `total_amount` decimal(15,2) UNSIGNED DEFAULT 0.00,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_product_orders`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_product_order_items`
--

DROP TABLE IF EXISTS `ht_product_order_items`;
CREATE TABLE `ht_product_order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` decimal(15,2) UNSIGNED DEFAULT 0.00,
  `quantity` int(10) UNSIGNED DEFAULT 1,
  `service_date` date DEFAULT NULL COMMENT 'Service date for this item',
  `service_time` time DEFAULT NULL COMMENT 'Service time for this item',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_rooms`
--

DROP TABLE IF EXISTS `ht_rooms`;
CREATE TABLE `ht_rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `images` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `videos` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vr360_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_rate_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,0) UNSIGNED DEFAULT NULL,
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `number_of_rooms` int(10) UNSIGNED DEFAULT 0,
  `number_of_beds` int(10) UNSIGNED DEFAULT 0,
  `size` int(10) UNSIGNED DEFAULT 0,
  `max_adults` int(11) DEFAULT 0,
  `max_children` int(11) DEFAULT 0,
  `room_category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_rooms`
--

INSERT INTO `ht_rooms` (`id`, `name`, `description`, `content`, `is_featured`, `images`, `videos`, `vr360_url`, `external_rate_id`, `price`, `currency_id`, `number_of_rooms`, `number_of_beds`, `size`, `max_adults`, `max_children`, `room_category_id`, `tax_id`, `status`, `created_at`, `updated_at`, `order`) VALUES
(1, 'Phòng Premier Twin', 'Phòng 40m² với hai giường đơn 1m4, ban công hướng thành phố và biển – lựa chọn lý tưởng cho hai người bạn đồng hành hoặc chuyến công tác.', '<div class=\"room-detail\"><p>Phòng 40m² với hai giường đơn 1m4, ban công hướng thành phố và biển – lựa chọn lý tưởng cho hai người bạn đồng hành hoặc chuyến công tác.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 40 m²</li><li>02 giường đơn 1m4</li><li>Hướng thành phố và biển</li><li>Tối đa 2 người lớn và 2 trẻ em</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 1, '[\"https://malibuhotel.com.vn/files/hotels/269/DSC05872-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_846/DSC05868-HDR_1_.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_846/DSC05887-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_846/DSC05881-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_846/DSC05875-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_846/DSC05872-HDR.jpg\"]', '[]', NULL, NULL, 0, 3, 40, 2, 40, 2, 2, 5, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 0),
(2, 'Phòng Premier King', 'Phòng 40m² với giường King 1m8, tầm nhìn ôm trọn thành phố Vũng Tàu và đại dương.', '<div class=\"room-detail\"><p>Phòng 40m² với giường King 1m8, tầm nhìn ôm trọn thành phố Vũng Tàu và đại dương.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 40 m²</li><li>01 giường King 1m8</li><li>Hướng thành phố và biển</li><li>Tối đa 2 người lớn và 2 trẻ em</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 1, '[\"https://malibuhotel.com.vn/files/hotels/269/DSC05859-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_843/DSC05862-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_843/DSC05868-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_843/DSC05859-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_843/DSC05856-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_843/DSC05853-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_843/DSC05847-HDR.jpg\"]', '[]', NULL, NULL, 0, 3, 45, 1, 40, 2, 2, 5, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 1),
(3, 'Phòng Premier Queen', 'Phòng 40m² với hai giường 1,6m x 2m ghép đôi, linh hoạt cho cả cặp đôi lẫn nhóm bạn.', '<div class=\"room-detail\"><p>Phòng 40m² với hai giường 1,6m x 2m ghép đôi, linh hoạt cho cả cặp đôi lẫn nhóm bạn.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 40 m²</li><li>02 giường 1,6m x 2m ghép đôi</li><li>Hướng thành phố và biển</li><li>Tối đa 2 người lớn và 2 trẻ em</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 0, '[\"https://malibuhotel.com.vn/files/hotels/269/DSC05955-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_845/DSC05964-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_845/DSC05958-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_845/DSC05961-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_845/DSC05955-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_845/DSC05949-HDR.jpg\"]', '[]', NULL, NULL, 0, 3, 35, 2, 40, 2, 2, 5, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 2),
(4, 'Phòng Premier Family', 'Phòng gia đình 50m² với hai giường King 1m8, hướng thành phố, thoải mái cho 4 người lớn.', '<div class=\"room-detail\"><p>Phòng gia đình 50m² với hai giường King 1m8, hướng thành phố, thoải mái cho 4 người lớn.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 50 m²</li><li>02 giường King 1m8</li><li>Hướng thành phố</li><li>Tối đa 4 người lớn và 2 trẻ em</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 0, '[\"https://malibuhotel.com.vn/files/hotels/269/DSC05897-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_886/DSC05912-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_886/DSC05903-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_886/DSC05900-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_886/DSC05897-HDR.jpg\"]', '[]', NULL, NULL, 0, 3, 20, 2, 50, 4, 2, 5, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 3),
(5, 'Phòng Diamond King', 'Phòng 46m² hạng Diamond với giường King 1m8 và bồn tắm riêng, hướng thành phố.', '<div class=\"room-detail\"><p>Phòng 46m² hạng Diamond với giường King 1m8 và bồn tắm riêng, hướng thành phố.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 46 m²</li><li>01 giường King 1m8</li><li>Hướng thành phố</li><li>Tối đa 2 người lớn và 2 trẻ em</li><li>Bồn tắm riêng</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 1, '[\"https://malibuhotel.com.vn/files/hotels/269/DSC05629-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_844/DSC05687-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_844/DSC05683-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_844/DSC05674-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_844/DSC05664-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_844/DSC05635-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_844/DSC05647-HDR.jpg\"]', '[]', NULL, NULL, 0, 3, 25, 1, 46, 2, 2, 6, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 0),
(6, 'Phòng Diamond Family', 'Phòng gia đình 50m² hạng Diamond với bồn tắm, một giường King và một giường đơn, hướng thành phố và biển.', '<div class=\"room-detail\"><p>Phòng gia đình 50m² hạng Diamond với bồn tắm, một giường King và một giường đơn, hướng thành phố và biển.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 50 m²</li><li>01 giường King 1m8 và 01 giường đơn 1m2</li><li>Hướng thành phố và biển</li><li>Tối đa 4 người lớn và 2 trẻ em</li><li>Bồn tắm riêng</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 1, '[\"https://malibuhotel.com.vn/files/hotels/269/DSC05741-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_847/DSC05762-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_847/DSC05759-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_847/DSC05756-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_847/DSC05750-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_847/DSC05741-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_847/DSC05744-HDR.jpg\"]', '[]', NULL, NULL, 0, 3, 15, 2, 50, 4, 2, 6, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 1),
(7, 'Malibu Suite', 'Suite 60m² với giường King 1m8, phòng khách riêng và bồn tắm, tầm nhìn thành phố và biển.', '<div class=\"room-detail\"><p>Suite 60m² với giường King 1m8, phòng khách riêng và bồn tắm, tầm nhìn thành phố và biển.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 60 m²</li><li>01 giường King 1m8</li><li>Hướng thành phố và biển</li><li>Tối đa 2 người lớn và 2 trẻ em</li><li>Bồn tắm riêng</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 1, '[\"https://malibuhotel.com.vn/files/hotels/269/DSC05779-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_885/DSC05838-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_885/DSC05832-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_885/DSC05814-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_885/DSC05807-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_885/DSC05801-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_885/DSC05787-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_885/DSC05779-HDR.jpg\"]', '[]', NULL, NULL, 0, 3, 8, 1, 60, 2, 2, 7, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 0),
(8, 'Family Suite', 'Suite gia đình 60m² với hai giường King 1m8 và bồn tắm, tầm nhìn thành phố và biển.', '<div class=\"room-detail\"><p>Suite gia đình 60m² với hai giường King 1m8 và bồn tắm, tầm nhìn thành phố và biển.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 60 m²</li><li>02 giường King 1m8</li><li>Hướng thành phố và biển</li><li>Tối đa 4 người lớn và 2 trẻ em</li><li>Bồn tắm riêng</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 1, '[\"https://malibuhotel.com.vn/files/hotels/269/DSC05707-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_887/DSC05737-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_887/DSC05734-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_887/DSC05728-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_887/DSC05719-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_887/DSC05716-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_887/DSC05707-HDR.jpg\", \"https://malibuhotel.com.vn/files/hotels/269_887/DSC05713-HDR.jpg\"]', '[]', NULL, NULL, 0, 3, 5, 2, 60, 4, 2, 7, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 1),
(9, 'Vice President Suite', 'Suite hạng Phó Tổng Thống với không gian tiếp khách riêng và tầm nhìn biển toàn cảnh.', '<div class=\"room-detail\"><p>Suite hạng Phó Tổng Thống với không gian tiếp khách riêng và tầm nhìn biển toàn cảnh.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 120 m²</li><li>01 giường King hoặc 02 giường Queen</li><li>Hướng biển toàn cảnh</li><li>Tối đa 4 người lớn và 2 trẻ em</li><li>Bồn tắm riêng</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 0, '[\"https://malibuhotel.com.vn/files/hotels/269_917/Asset_3@4x.png\"]', '[]', NULL, NULL, 0, 3, 3, 1, 120, 4, 2, 8, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 0),
(10, 'Presidential Suite', 'Presidential Suite 250m² – căn phòng lớn nhất khách sạn với tầm nhìn toàn cảnh Vũng Tàu, không gian tiếp khách và tiện nghi cao cấp nhất.', '<div class=\"room-detail\"><p>Presidential Suite 250m² – căn phòng lớn nhất khách sạn với tầm nhìn toàn cảnh Vũng Tàu, không gian tiếp khách và tiện nghi cao cấp nhất.</p><h3>Thông tin phòng</h3><ul><li>Diện tích 250 m²</li><li>01 giường King hoặc 02 giường Queen</li><li>Hướng biển toàn cảnh</li><li>Tối đa 4 người lớn và 2 trẻ em</li><li>Bồn tắm riêng</li></ul><h3>Tiện nghi tiêu chuẩn</h3><p>Điều hoà nhiệt độ, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt an toàn, minibar, ấm đun nước cùng trà và cà phê, máy sấy tóc, bàn làm việc và bộ đồ dùng phòng tắm cao cấp. Dọn phòng hằng ngày, lễ tân hỗ trợ 24/7.</p><h3>Bao gồm trong giá phòng</h3><p>Buffet sáng hơn 40 món tại nhà hàng Vela (tầng 3), sử dụng hồ bơi ngoài trời M Pool và phòng tập M Gym (tầng 6).</p><h3>Liên hệ đặt phòng</h3><p>Hotline: <a href=\"tel:0941871644\">0941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', 1, '[\"https://malibuhotel.com.vn/files/hotels/269_918/PRESIDENT.jpg\"]', '[]', NULL, NULL, 0, 3, 1, 1, 250, 4, 2, 8, 1, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 1);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_rooms_amenities`
--

DROP TABLE IF EXISTS `ht_rooms_amenities`;
CREATE TABLE `ht_rooms_amenities` (
  `amenity_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_rooms_amenities`
--

INSERT INTO `ht_rooms_amenities` (`amenity_id`, `room_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL),
(2, 1, NULL, NULL),
(3, 1, NULL, NULL),
(4, 1, NULL, NULL),
(5, 1, NULL, NULL),
(6, 1, NULL, NULL),
(7, 1, NULL, NULL),
(8, 1, NULL, NULL),
(10, 1, NULL, NULL),
(11, 1, NULL, NULL),
(12, 1, NULL, NULL),
(13, 1, NULL, NULL),
(14, 1, NULL, NULL),
(15, 1, NULL, NULL),
(16, 1, NULL, NULL),
(1, 2, NULL, NULL),
(2, 2, NULL, NULL),
(3, 2, NULL, NULL),
(4, 2, NULL, NULL),
(5, 2, NULL, NULL),
(6, 2, NULL, NULL),
(7, 2, NULL, NULL),
(8, 2, NULL, NULL),
(10, 2, NULL, NULL),
(11, 2, NULL, NULL),
(12, 2, NULL, NULL),
(13, 2, NULL, NULL),
(14, 2, NULL, NULL),
(15, 2, NULL, NULL),
(16, 2, NULL, NULL),
(1, 3, NULL, NULL),
(2, 3, NULL, NULL),
(3, 3, NULL, NULL),
(4, 3, NULL, NULL),
(5, 3, NULL, NULL),
(6, 3, NULL, NULL),
(7, 3, NULL, NULL),
(8, 3, NULL, NULL),
(10, 3, NULL, NULL),
(11, 3, NULL, NULL),
(12, 3, NULL, NULL),
(13, 3, NULL, NULL),
(14, 3, NULL, NULL),
(15, 3, NULL, NULL),
(16, 3, NULL, NULL),
(1, 4, NULL, NULL),
(2, 4, NULL, NULL),
(3, 4, NULL, NULL),
(4, 4, NULL, NULL),
(5, 4, NULL, NULL),
(6, 4, NULL, NULL),
(7, 4, NULL, NULL),
(8, 4, NULL, NULL),
(10, 4, NULL, NULL),
(11, 4, NULL, NULL),
(12, 4, NULL, NULL),
(13, 4, NULL, NULL),
(14, 4, NULL, NULL),
(15, 4, NULL, NULL),
(1, 5, NULL, NULL),
(2, 5, NULL, NULL),
(3, 5, NULL, NULL),
(4, 5, NULL, NULL),
(5, 5, NULL, NULL),
(6, 5, NULL, NULL),
(7, 5, NULL, NULL),
(8, 5, NULL, NULL),
(9, 5, NULL, NULL),
(10, 5, NULL, NULL),
(11, 5, NULL, NULL),
(12, 5, NULL, NULL),
(13, 5, NULL, NULL),
(14, 5, NULL, NULL),
(15, 5, NULL, NULL),
(1, 6, NULL, NULL),
(2, 6, NULL, NULL),
(3, 6, NULL, NULL),
(4, 6, NULL, NULL),
(5, 6, NULL, NULL),
(6, 6, NULL, NULL),
(7, 6, NULL, NULL),
(8, 6, NULL, NULL),
(9, 6, NULL, NULL),
(10, 6, NULL, NULL),
(11, 6, NULL, NULL),
(12, 6, NULL, NULL),
(13, 6, NULL, NULL),
(14, 6, NULL, NULL),
(15, 6, NULL, NULL),
(16, 6, NULL, NULL),
(1, 7, NULL, NULL),
(2, 7, NULL, NULL),
(3, 7, NULL, NULL),
(4, 7, NULL, NULL),
(5, 7, NULL, NULL),
(6, 7, NULL, NULL),
(7, 7, NULL, NULL),
(8, 7, NULL, NULL),
(9, 7, NULL, NULL),
(10, 7, NULL, NULL),
(11, 7, NULL, NULL),
(12, 7, NULL, NULL),
(13, 7, NULL, NULL),
(14, 7, NULL, NULL),
(15, 7, NULL, NULL),
(16, 7, NULL, NULL),
(1, 8, NULL, NULL),
(2, 8, NULL, NULL),
(3, 8, NULL, NULL),
(4, 8, NULL, NULL),
(5, 8, NULL, NULL),
(6, 8, NULL, NULL),
(7, 8, NULL, NULL),
(8, 8, NULL, NULL),
(9, 8, NULL, NULL),
(10, 8, NULL, NULL),
(11, 8, NULL, NULL),
(12, 8, NULL, NULL),
(13, 8, NULL, NULL),
(14, 8, NULL, NULL),
(15, 8, NULL, NULL),
(16, 8, NULL, NULL),
(1, 9, NULL, NULL),
(2, 9, NULL, NULL),
(3, 9, NULL, NULL),
(4, 9, NULL, NULL),
(5, 9, NULL, NULL),
(6, 9, NULL, NULL),
(7, 9, NULL, NULL),
(8, 9, NULL, NULL),
(9, 9, NULL, NULL),
(10, 9, NULL, NULL),
(11, 9, NULL, NULL),
(12, 9, NULL, NULL),
(13, 9, NULL, NULL),
(14, 9, NULL, NULL),
(15, 9, NULL, NULL),
(16, 9, NULL, NULL),
(1, 10, NULL, NULL),
(2, 10, NULL, NULL),
(3, 10, NULL, NULL),
(4, 10, NULL, NULL),
(5, 10, NULL, NULL),
(6, 10, NULL, NULL),
(7, 10, NULL, NULL),
(8, 10, NULL, NULL),
(9, 10, NULL, NULL),
(10, 10, NULL, NULL),
(11, 10, NULL, NULL),
(12, 10, NULL, NULL),
(13, 10, NULL, NULL),
(14, 10, NULL, NULL),
(15, 10, NULL, NULL),
(16, 10, NULL, NULL);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_rooms_translations`
--

DROP TABLE IF EXISTS `ht_rooms_translations`;
CREATE TABLE `ht_rooms_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_rooms_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vr360_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_rooms_translations`
--

INSERT INTO `ht_rooms_translations` (`lang_code`, `ht_rooms_id`, `name`, `description`, `content`, `vr360_url`) VALUES
('en_US', 1, 'Premier Twin', 'A 40sqm room with two single beds and a balcony overlooking the city and the sea – ideal for travelling companions or a business trip.', '<div class=\"room-detail\"><p>A 40sqm room with two single beds and a balcony overlooking the city and the sea – ideal for travelling companions or a business trip.</p><h3>Room information</h3><ul><li>40 sqm</li><li>2 single beds (1.4m)</li><li>City &amp; Sea view</li><li>Up to 2 adults and 2 children</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 2, 'Premier King', 'A 40sqm room with a King bed and views embracing Vung Tau city and the ocean.', '<div class=\"room-detail\"><p>A 40sqm room with a King bed and views embracing Vung Tau city and the ocean.</p><h3>Room information</h3><ul><li>40 sqm</li><li>1 King bed (1.8m)</li><li>City &amp; Sea view</li><li>Up to 2 adults and 2 children</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 3, 'Premier Queen', 'A 40sqm room with two joined 1.6m x 2m beds, flexible for couples and friends alike.', '<div class=\"room-detail\"><p>A 40sqm room with two joined 1.6m x 2m beds, flexible for couples and friends alike.</p><h3>Room information</h3><ul><li>40 sqm</li><li>2 joined beds (1.6m x 2m)</li><li>City &amp; Sea view</li><li>Up to 2 adults and 2 children</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 4, 'Premier Family', 'A 50sqm family room with two King beds and city views, comfortable for four adults.', '<div class=\"room-detail\"><p>A 50sqm family room with two King beds and city views, comfortable for four adults.</p><h3>Room information</h3><ul><li>50 sqm</li><li>2 King beds (1.8m)</li><li>City view</li><li>Up to 4 adults and 2 children</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 5, 'Diamond King', 'A 46sqm Diamond room with a King bed, private bathtub and city views.', '<div class=\"room-detail\"><p>A 46sqm Diamond room with a King bed, private bathtub and city views.</p><h3>Room information</h3><ul><li>46 sqm</li><li>1 King bed (1.8m)</li><li>City view</li><li>Up to 2 adults and 2 children</li><li>Private bathtub</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 6, 'Diamond Family', 'A 50sqm Diamond family room with a bathtub, one King bed and one single bed, facing the city and the sea.', '<div class=\"room-detail\"><p>A 50sqm Diamond family room with a bathtub, one King bed and one single bed, facing the city and the sea.</p><h3>Room information</h3><ul><li>50 sqm</li><li>1 King bed (1.8m) and 1 single bed (1.2m)</li><li>City &amp; Sea view</li><li>Up to 4 adults and 2 children</li><li>Private bathtub</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 7, 'Malibu Suite', 'A 60sqm suite with a King bed, separate living area and bathtub, overlooking the city and the sea.', '<div class=\"room-detail\"><p>A 60sqm suite with a King bed, separate living area and bathtub, overlooking the city and the sea.</p><h3>Room information</h3><ul><li>60 sqm</li><li>1 King bed (1.8m)</li><li>City &amp; Sea view</li><li>Up to 2 adults and 2 children</li><li>Private bathtub</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 8, 'Family Suite', 'A 60sqm family suite with two King beds and a bathtub, overlooking the city and the sea.', '<div class=\"room-detail\"><p>A 60sqm family suite with two King beds and a bathtub, overlooking the city and the sea.</p><h3>Room information</h3><ul><li>60 sqm</li><li>2 King beds (1.8m)</li><li>City &amp; Sea view</li><li>Up to 4 adults and 2 children</li><li>Private bathtub</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 9, 'Vice President Suite', 'The Vice President Suite offers a private reception area and panoramic sea views.', '<div class=\"room-detail\"><p>The Vice President Suite offers a private reception area and panoramic sea views.</p><h3>Room information</h3><ul><li>120 sqm</li><li>1 King bed or 2 Queen beds</li><li>Panoramic sea view</li><li>Up to 4 adults and 2 children</li><li>Private bathtub</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 10, 'Presidential Suite', 'The 250sqm Presidential Suite – the largest room in the hotel, with panoramic views over Vung Tau, a private reception area and the finest amenities.', '<div class=\"room-detail\"><p>The 250sqm Presidential Suite – the largest room in the hotel, with panoramic views over Vung Tau, a private reception area and the finest amenities.</p><h3>Room information</h3><ul><li>250 sqm</li><li>1 King bed or 2 Queen beds</li><li>Panoramic sea view</li><li>Up to 4 adults and 2 children</li><li>Private bathtub</li></ul><h3>Standard amenities</h3><p>Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, electric kettle with tea and coffee, hair dryer, work desk and premium bathroom amenities. Daily housekeeping and 24/7 front desk assistance.</p><h3>Included in the room rate</h3><p>A breakfast buffet of more than 40 dishes at Vela Restaurant (3rd floor) and access to the M Pool outdoor swimming pool and M Gym (6th floor).</p><h3>Reservations</h3><p>Hotline: <a href=\"tel:+84941871644\">(+84) 941 871 644</a> &nbsp;|&nbsp; Email: <a href=\"mailto:res@malibuhotel.com.vn\">res@malibuhotel.com.vn</a></p></div>', NULL);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_room_calendars`
--

DROP TABLE IF EXISTS `ht_room_calendars`;
CREATE TABLE `ht_room_calendars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_synced_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_room_categories`
--

DROP TABLE IF EXISTS `ht_room_categories`;
CREATE TABLE `ht_room_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` tinyint(4) NOT NULL DEFAULT 0,
  `is_featured` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_room_categories`
--

INSERT INTO `ht_room_categories` (`id`, `name`, `status`, `created_at`, `updated_at`, `order`, `is_featured`) VALUES
(5, 'Premier', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 0, 1),
(6, 'Diamond', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 1, 1),
(7, 'Suite', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 2, 1),
(8, 'President', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00', 3, 1);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_room_categories_translations`
--

DROP TABLE IF EXISTS `ht_room_categories_translations`;
CREATE TABLE `ht_room_categories_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_room_categories_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_room_categories_translations`
--

INSERT INTO `ht_room_categories_translations` (`lang_code`, `ht_room_categories_id`, `name`) VALUES
('en_US', 5, 'Premier'),
('en_US', 6, 'Diamond'),
('en_US', 7, 'Suite'),
('en_US', 8, 'President');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_room_dates`
--

DROP TABLE IF EXISTS `ht_room_dates`;
CREATE TABLE `ht_room_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `value` decimal(15,2) DEFAULT NULL,
  `value_type` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'fixed',
  `max_guests` tinyint(4) DEFAULT NULL,
  `active` tinyint(4) DEFAULT 0,
  `note_to_customer` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note_to_admin` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_rooms` smallint(6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_services`
--

DROP TABLE IF EXISTS `ht_services`;
CREATE TABLE `ht_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,0) UNSIGNED DEFAULT NULL,
  `price_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'once',
  `currency_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_services`
--

INSERT INTO `ht_services` (`id`, `name`, `description`, `content`, `price`, `price_type`, `currency_id`, `image`, `custom_url`, `status`, `created_at`, `updated_at`) VALUES
(1, 'M Pool – Hồ bơi ngoài trời', 'Hồ bơi ngoài trời tầng 6 với tầm nhìn toàn cảnh thành phố Vũng Tàu, quầy bar phục vụ tại hồ và hệ thống điện phân muối tự nhiên.', '<div class=\"service-detail\"><p>M Pool là ốc đảo giữa lòng thành phố biển. Bơi một vòng trong làn nước trong xanh, nhâm nhi ly vang và ngắm Vũng Tàu trải dài dưới nắng chiều – mỗi trải nghiệm tại Malibu là một mảnh ghép của cảm xúc.</p><h3>Thông tin hồ bơi</h3><p>Sức chứa: 30 khách mỗi lượt. Hệ thống điện phân từ muối tự nhiên để khử khuẩn. Hồ người lớn 195 m², độ sâu 1,4 m. Hồ trẻ em 105 m², độ sâu 0,9 m.</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 07:00 – 19:00</p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/M-POOL-MALIBU-HOTEL_1__1.jpg', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'M Spa – Chăm sóc và trị liệu', 'Không gian trị liệu yên tĩnh với đội ngũ kỹ thuật viên lành nghề, sử dụng thảo dược tự nhiên và y học cổ truyền.', '<div class=\"service-detail\"><p>Sau những hoạt động khám phá thành phố biển, M Spa giúp bạn tái tạo năng lượng cho một tuần mới. Đội ngũ kỹ thuật viên lành nghề, tận tâm sử dụng y học cổ truyền và thảo dược quý từ thiên nhiên để mỗi phút giây tại đây đều đáng giá.</p><p>Chỉ cần thả mình vào không gian tĩnh lặng, cảm nhận tuần hoàn trong từng mạch máu, thư giãn và hồi phục trọn vẹn trong khoảng 2 giờ.</p><h3>Dịch vụ</h3><p>Xông hơi khô, xông hơi ướt, gội đầu dưỡng sinh và massage trị liệu.</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 10:00 – 20:00</p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/M-SPA-MALIBU_HOTEL_1.jpg', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'M Gym – Phòng tập thể hình', 'Phòng gym 100 m² tại khu dịch vụ tầng 6 với trang thiết bị hiện đại chuẩn phòng tập chuyên nghiệp.', '<div class=\"service-detail\"><p>Dành cho những ai duy trì thói quen luyện tập, Malibu bố trí phòng gym cao cấp tại khu dịch vụ giải trí tầng 6, trang thiết bị hiện đại đáp ứng mọi nhu cầu như các phòng tập chuyên nghiệp.</p><h3>Thông tin</h3><p>Diện tích phòng tập: 100 m².</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 06:00 – 22:00</p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/Asset_23@4x_1.png', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'Vela Restaurant – Buffet sáng', 'Nhà hàng tầng 3 sức chứa 350 khách, buffet sáng hơn 40 món Á – Âu, phục vụ à la carte, buffet và tiệc Gala.', '<div class=\"mb-5\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/Anh_1_4_1.jpg\" alt=\"Vela Restaurant\" class=\"img-fluid rounded-3 w-100 mb-4\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:13px\">Tầng 3</p><h2 class=\"text-uppercase fw-bold mb-2\" style=\"color:#16192c\">Vela Restaurant</h2><p class=\"lead mb-0\" style=\"color:#6b7280\">Buffet sáng hơn 40 món Á – Âu, sức chứa 350 khách</p></div><div class=\"row g-3 mb-5\"><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Vị trí</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">Tầng 3, The Malibu Hotel</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Sức chứa</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">350 khách</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Buffet sáng</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">06:30 – 10:00 hằng ngày</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Tiệc &amp; à la carte</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">11:00 – 22:00</p></div></div></div><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Một sáng thức dậy tại Malibu, nghe bản nhạc du dương, nhấp ngụm cà phê và dùng bữa sáng tại nhà hàng Vela với hơn 40 món buffet trải từ Á sang Âu – trước khi bắt đầu ngày mới đầy hứng khởi cho chuyến công tác, hay một ngày rong chơi ở thành phố biển.</p><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Đội ngũ ẩm thực của khách sạn chăm chút từng món ăn, từ khâu chọn nguyên liệu tươi ngon đến chế biến – cho một bữa sáng tràn năng lượng, một bữa trưa nhẹ nhàng, hay những món đặc biệt dành cho đêm Gala ấn tượng.</p><h3 class=\"text-uppercase fw-bold mb-3 mt-5\" style=\"color:#16192c;font-size:20px\">Không gian</h3><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Nhà hàng được thiết kế rộng rãi theo phong cách hiện đại, trải thảm cao cấp, sức chứa lên đến 350 khách. Vela phục vụ cả ba hình thức: gọi món à la carte, buffet và tiệc Gala – phù hợp cho bữa sáng của khách lưu trú lẫn tiệc công ty quy mô lớn.</p><div class=\"p-4 rounded-3 mb-5 border-start border-4\" style=\"background-color:#faf7f2;border-color:#e4762c\"><p class=\"text-uppercase fw-bold mb-3\" style=\"color:#16192c;font-size:13px\">Điểm nổi bật</p><ul class=\"mb-0\" style=\"padding-left:18px\"><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Hơn 40 món buffet sáng, luân phiên món Á và món Âu mỗi ngày</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Sức chứa 350 khách – lớn nhất trong các nhà hàng của khách sạn</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Phục vụ tiệc Gala, tiệc cưới và tiệc công ty theo thực đơn đặt riêng</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Buffet sáng đã bao gồm trong giá phòng của mọi hạng phòng</li></ul></div><div class=\"row g-3 mb-5\"><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/Anh_1_4_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div></div><div class=\"p-4 p-md-5 rounded-3 text-center\" style=\"background-color:#16192c\"><h3 class=\"text-uppercase fw-bold text-white mb-2\" style=\"font-size:20px\">Đặt bàn tại Vela Restaurant</h3><p class=\"mb-4\" style=\"color:#b9bdc9\">Vui lòng đặt trước với tiệc từ 20 khách trở lên.</p><p class=\"mb-2 text-white\" style=\"font-size:18px\">Hotline: <a href=\"tel:02543577789\" style=\"color:#e4762c;text-decoration:none\"><strong>0254 3 577 789</strong></a></p><p class=\"mb-0\"><a href=\"mailto:res@malibuhotel.com.vn\" style=\"color:#b9bdc9;text-decoration:underline\">res@malibuhotel.com.vn</a></p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/Anh_1_4_1.jpg', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'Carina Restaurant – Ẩm thực Á Âu', 'Nhà hàng tầng 6 với tầm nhìn đặc biệt, sức chứa 60 khách và phòng VIP 20 khách, ẩm thực giao thoa Âu – Á.', '<div class=\"mb-5\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg\" alt=\"Carina Restaurant\" class=\"img-fluid rounded-3 w-100 mb-4\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:13px\">Tầng 6</p><h2 class=\"text-uppercase fw-bold mb-2\" style=\"color:#16192c\">Carina Restaurant</h2><p class=\"lead mb-0\" style=\"color:#6b7280\">Ẩm thực giao thoa Âu – Á trong không gian có tầm nhìn đặc biệt</p></div><div class=\"row g-3 mb-5\"><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Vị trí</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">Tầng 6, The Malibu Hotel</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Sức chứa</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">60 khách + phòng VIP 20 khách</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Giờ phục vụ</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">11:00 – 22:00 hằng ngày</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Phong cách</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">Fusion Âu – Á</p></div></div></div><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Toạ lạc tại tầng 6 của khách sạn với tầm nhìn đặc biệt ra thành phố và biển, Carina Restaurant mang thiết kế hiện đại cùng âm nhạc thư thái, đem đến cho thực khách một trải nghiệm ẩm thực đẳng cấp.</p><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Nhà hàng có sức chứa khoảng 60 khách, cùng một phòng VIP dành riêng cho 20 khách – lý tưởng cho những buổi tiệc riêng tư, thanh lịch và các sự kiện đặc biệt. Đây cũng là lựa chọn đẹp cho những buổi hẹn hò lãng mạn.</p><h3 class=\"text-uppercase fw-bold mb-3 mt-5\" style=\"color:#16192c;font-size:20px\">Thực đơn</h3><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Thực đơn lấy cảm hứng từ sự giao thoa giữa ẩm thực châu Âu và châu Á, tuyển chọn từ nguyên liệu thượng hạng. Cùng với tâm huyết của những đầu bếp tài hoa, công thức riêng và sự tỉ mỉ trong từng khâu phục vụ, Carina tạo nên những trải nghiệm vị giác rất riêng.</p><div class=\"p-4 rounded-3 mb-5 border-start border-4\" style=\"background-color:#faf7f2;border-color:#e4762c\"><p class=\"text-uppercase fw-bold mb-3\" style=\"color:#16192c;font-size:13px\">Phù hợp cho</p><ul class=\"mb-0\" style=\"padding-left:18px\"><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Bữa tối lãng mạn với tầm nhìn ra thành phố biển về đêm</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Tiệc riêng tư trong phòng VIP 20 khách</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Sự kiện kỷ niệm, sinh nhật và tiệc thân mật của doanh nghiệp</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Thực đơn set menu theo yêu cầu cho nhóm khách</li></ul></div><div class=\"row g-3 mb-5\"><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/_THP4305-HDR_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div></div><div class=\"p-4 p-md-5 rounded-3 text-center\" style=\"background-color:#16192c\"><h3 class=\"text-uppercase fw-bold text-white mb-2\" style=\"font-size:20px\">Đặt bàn tại Carina Restaurant</h3><p class=\"mb-4\" style=\"color:#b9bdc9\">Phòng VIP cần đặt trước tối thiểu 24 giờ.</p><p class=\"mb-2 text-white\" style=\"font-size:18px\">Hotline: <a href=\"tel:02543577789\" style=\"color:#e4762c;text-decoration:none\"><strong>0254 3 577 789</strong></a></p><p class=\"mb-0\"><a href=\"mailto:res@malibuhotel.com.vn\" style=\"color:#b9bdc9;text-decoration:underline\">res@malibuhotel.com.vn</a></p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'The Lux Café – Cà phê &amp; trà', 'Quán cà phê tại sảnh khách sạn, thiết kế như một góc phố Milan, có cả cây đàn piano cho những phút ngẫu hứng.', '<div class=\"mb-5\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/800x600_1__1.png\" alt=\"The Lux Café\" class=\"img-fluid rounded-3 w-100 mb-4\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:13px\">Sảnh khách sạn</p><h2 class=\"text-uppercase fw-bold mb-2\" style=\"color:#16192c\">The Lux Café</h2><p class=\"lead mb-0\" style=\"color:#6b7280\">Một góc phố Milan giữa sảnh khách sạn, có cả cây đàn piano</p></div><div class=\"row g-3 mb-5\"><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Vị trí</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">Sảnh The Malibu Hotel</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Giờ phục vụ</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">07:00 – 22:00 hằng ngày</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Phong cách</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">Cà phê &amp; trà, bánh ngọt, kem</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Điểm nhấn</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">Piano tại sảnh</p></div></div></div><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Trước khi trở lại với công việc, hãy ghé The Lux Café ở sảnh khách sạn để thưởng thức một ly kem hay tách cà phê trong lúc làm thủ tục trả phòng.</p><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Được thiết kế như một góc phố Milan tráng lệ mà không kém phần thời thượng, The Lux Café khiến bạn như đang đắm mình trong hơi thở của kinh đô thời trang.</p><h3 class=\"text-uppercase fw-bold mb-3 mt-5\" style=\"color:#16192c;font-size:20px\">Một lời mời</h3><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Và nếu có thể, hãy để lại một bản concerto cho Malibu và những vị khách khác bên cây đàn piano nơi sảnh – một thói quen nhỏ đã trở thành nét riêng của buổi chiều tại đây.</p><div class=\"p-4 rounded-3 mb-5 border-start border-4\" style=\"background-color:#faf7f2;border-color:#e4762c\"><p class=\"text-uppercase fw-bold mb-3\" style=\"color:#16192c;font-size:13px\">Gợi ý</p><ul class=\"mb-0\" style=\"padding-left:18px\"><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Cà phê Việt Nam và các loại cà phê Ý pha máy</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Trà và bánh ngọt phục vụ cả ngày</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Kem và đồ uống mát cho buổi trưa Vũng Tàu</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Không gian yên tĩnh, phù hợp cho một cuộc hẹn công việc ngắn</li></ul></div><div class=\"row g-3 mb-5\"><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/800x600_1__1.png\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/DSC00288_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div></div><div class=\"p-4 p-md-5 rounded-3 text-center\" style=\"background-color:#16192c\"><h3 class=\"text-uppercase fw-bold text-white mb-2\" style=\"font-size:20px\">Ghé The Lux Café</h3><p class=\"mb-4\" style=\"color:#b9bdc9\">Không cần đặt chỗ – mời quý khách ghé bất cứ lúc nào trong giờ mở cửa.</p><p class=\"mb-2 text-white\" style=\"font-size:18px\">Hotline: <a href=\"tel:02543577789\" style=\"color:#e4762c;text-decoration:none\"><strong>0254 3 577 789</strong></a></p><p class=\"mb-0\"><a href=\"mailto:res@malibuhotel.com.vn\" style=\"color:#b9bdc9;text-decoration:underline\">res@malibuhotel.com.vn</a></p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/800x600_1__1.png', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 'Conference – Hội nghị &amp; hội thảo', '7 phòng hội nghị sức chứa tới 450 khách, phòng Malibu Grand chia được thành 3 phòng nhỏ 120 khách mỗi phòng.', '<div class=\"service-detail\"><p>The Malibu Hotel có 7 phòng hội nghị với sức chứa lên đến 450 khách. Phòng Malibu Grand có thể ngăn thành 3 phòng nhỏ, mỗi phòng 120 khách, bằng hệ thống vách ngăn linh hoạt.</p><p>Hệ thống âm thanh chuẩn quốc tế, màn hình LED và máy chiếu hiện đại, nội thất cao cấp – sẵn sàng đáp ứng mọi nhu cầu của quý khách.</p><p>Chúng tôi cung cấp dịch vụ hỗ trợ kỹ thuật chuyên nghiệp cùng các gói thiết bị và tiệc linh hoạt, bảo đảm mỗi sự kiện diễn ra suôn sẻ và thành công.</p><h3>Liên hệ</h3><p>Điện thoại: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn</p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/Asset_51@4x_1.png', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 'Kid Zone – Khu vui chơi trẻ em', 'Khu vui chơi an toàn, rộng rãi với trò chơi giáo dục và nhân viên trông coi tận tình.', '<div class=\"service-detail\"><p>Kid Zone là nơi lý tưởng để các bé thư giãn và vui chơi an toàn, sáng tạo trong lúc bố mẹ nghỉ ngơi tại khách sạn.</p><p>Khu vui chơi được thiết kế riêng với nhiều trò chơi và hoạt động đa dạng, từ trò chơi vận động đến trò chơi giáo dục, để các bé vừa vui vừa học. Đội ngũ nhân viên chuyên nghiệp, chu đáo luôn có mặt để trông coi và hỗ trợ các bé.</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 09:00 – 17:00</p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/KID-ZONE-MALIBU_-_HOTEL_1.jpg', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 'Entertainment – Khu giải trí', 'Khu giải trí tầng 6 với hệ thống golf 3D mô phỏng nhiều sân tập khác nhau.', '<div class=\"service-detail\"><p>Chơi golf không chỉ thoả niềm đam mê mà còn giúp bạn nâng trình nhanh chóng và mang lại những phút giây thư giãn tuyệt vời sau một ngày làm việc căng thẳng.</p><p>Golf 3D là hệ thống mô phỏng và tái hiện khung cảnh cùng các hoạt động giống như golf thật. Điểm đặc biệt là với golf 3D, người chơi có thể chọn nhiều loại sân tập khác nhau để cải thiện sự linh hoạt của mình.</p><h3>Giờ mở cửa</h3><p>Vui lòng liên hệ lễ tân để biết giờ hoạt động mới nhất.</p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/ENTERTAINMENT.jpg', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 'Billiard &amp; Foosball', 'Bàn billiard và bàn bi lắc tại khu giải trí tầng 6, dành cho những buổi tối thư giãn cùng bạn bè và gia đình.', '<div class=\"service-detail\"><p>Khu Billiard &amp; Foosball nằm trong tổ hợp giải trí tầng 6 của The Malibu Hotel – nơi bạn có thể cùng bạn bè, đồng nghiệp hay gia đình có những giờ phút thư giãn sau một ngày dài.</p><p>Bàn billiard tiêu chuẩn và bàn bi lắc được bảo dưỡng thường xuyên, không gian thoáng đãng ngay cạnh hồ bơi M Pool và phòng tập M Gym.</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 07:00 – 22:00</p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/_THP4305-HDR_1.jpg', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 'Private Laundry – Giặt ủi khép kín', 'Xưởng giặt khép kín của riêng khách sạn, không sử dụng dịch vụ bên thứ ba, hoạt động 24/24.', '<div class=\"service-detail\"><p>Xưởng giặt của The Malibu Hotel vận hành theo chu trình khép kín hoàn toàn, không sử dụng dịch vụ của bất kỳ bên thứ ba nào.</p><p>Nhờ vậy, toàn bộ khăn, ga, gối và đồ vải phục vụ khách đều được phân loại, giặt, tiệt trùng và hấp kỹ lưỡng, giữ hương thơm tự nhiên dễ chịu và tuyệt đối an toàn – bảo đảm tiêu chuẩn vệ sinh và sự thoải mái cho khách.</p><h3>Giờ phục vụ</h3><p>24/24 mỗi ngày</p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/Hotel-Laundry-Services-101-Is-It-Worth-It-04012022-735x491.jpg.webp', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 'Gift Shop – Cửa hàng quà tặng', 'Cửa hàng quà tặng và đồ lưu niệm mở cửa 24/24 ngay trong khách sạn.', '<div class=\"service-detail\"><p>Gift Shop của khách sạn là không gian mua sắm độc đáo và đa dạng, nơi bạn có thể tìm thấy món quà phù hợp cho gia đình, bạn bè – hoặc cho chính mình.</p><p>Từ trang sức tinh xảo đến đồ thủ công mỹ nghệ và quà lưu niệm đặc trưng, chúng tôi mang đến trải nghiệm mua sắm đáng nhớ, trọn vẹn cho hành trình của bạn.</p><p>Đội ngũ nhân viên luôn sẵn sàng tư vấn để bạn chọn được sản phẩm ưng ý nhất.</p><h3>Giờ mở cửa</h3><p>24/24 mỗi ngày</p></div>', 0, 'contact', NULL, 'https://malibuhotel.com.vn/files/blog/46_1815/DSC00288_1.jpg', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_services_translations`
--

DROP TABLE IF EXISTS `ht_services_translations`;
CREATE TABLE `ht_services_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ht_services_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_services_translations`
--

INSERT INTO `ht_services_translations` (`lang_code`, `ht_services_id`, `name`, `description`, `content`, `custom_url`) VALUES
('en_US', 1, 'M Pool – Outdoor Pool', 'A rooftop outdoor pool on the 6th floor with panoramic views over Vung Tau, a full-service lounge bar and a natural-salt electrolysis system.', '<div class=\"service-detail\"><p>A true oasis in the heart of Vung Tau, M Pool offers breath-taking panoramic views of the city, beautiful modern design and a full-service lounge bar. Take a refreshing swim, then enjoy a glass of wine as you overlook the coastal city and bask in the afternoon sun.</p><h3>Pool information</h3><p>Capacity: 30 guests per session. Electrolyte system using natural salt to disinfect the water. Adults\' pool 195 sqm, 1.4 m deep. Children\'s pool 105 sqm, 0.9 m deep.</p><h3>Hours</h3><p>Everyday: 7:00 am – 7:00 pm</p></div>', NULL),
('en_US', 2, 'M Spa – Health Care &amp; Treatment', 'A quiet treatment space with skilled therapists using natural herbs and traditional medicine.', '<div class=\"service-detail\"><p>After discovery activities around the coastal city, M Spa helps you renew your energy for the week ahead. Our team of skilled and dedicated therapists uses traditional medicine and precious herbs from nature to make every moment here worthwhile.</p><p>Simply settle into the quiet, feel the circulation in your blood, relax and regenerate completely over about two hours.</p><h3>Services</h3><p>Sauna, steam bath, hair washing and therapeutic massage.</p><h3>Hours</h3><p>Everyday: 10:00 am – 8:00 pm</p></div>', NULL),
('en_US', 3, 'M Gym – Fitness Centre', 'A 100 sqm gym in the 6th-floor service area with modern equipment matching professional fitness centres.', '<div class=\"service-detail\"><p>For those who keep up an exercise routine, Malibu offers a high-class gym in the entertainment service area on the 6th floor, with modern equipment to meet all your needs just like professional gyms.</p><h3>Information</h3><p>Gym area: 100 sqm.</p><h3>Hours</h3><p>Everyday: 6:00 am – 10:00 pm</p></div>', NULL),
('en_US', 4, 'Vela Restaurant – Breakfast Buffet', 'A 3rd-floor restaurant seating 350 guests, with a breakfast buffet of more than 40 Asian and European dishes, à la carte, buffet and gala service.', '<div class=\"mb-5\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/Anh_1_4_1.jpg\" alt=\"Vela Restaurant\" class=\"img-fluid rounded-3 w-100 mb-4\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:13px\">3rd floor</p><h2 class=\"text-uppercase fw-bold mb-2\" style=\"color:#16192c\">Vela Restaurant</h2><p class=\"lead mb-0\" style=\"color:#6b7280\">A breakfast buffet of 40+ Asian and European dishes, seating 350</p></div><div class=\"row g-3 mb-5\"><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Location</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">3rd floor, The Malibu Hotel</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Capacity</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">350 guests</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Breakfast buffet</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">6:30 – 10:00 am daily</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Banquet &amp; à la carte</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">11:00 am – 10:00 pm</p></div></div></div><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">One morning waking up at Malibu, listening to melodious music, sipping a cup of coffee and having breakfast at Vela Restaurant with more than 40 buffet dishes from Asia to Europe – before starting a new day of enthusiasm for a business trip or a day out in the beautiful coastal city.</p><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Our culinary team, knowledgeable in the quintessence of cuisine, takes care of every dish from choosing fresh ingredients to cooking – for an energetic breakfast, a light lunch, or special dishes for an impressive gala night.</p><h3 class=\"text-uppercase fw-bold mb-3 mt-5\" style=\"color:#16192c;font-size:20px\">The space</h3><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">The restaurant is designed in a spacious modern style with high-quality carpet and accommodates up to 350 guests. Vela serves à la carte, buffet and gala – suitable for in-house breakfast as well as large corporate banquets.</p><div class=\"p-4 rounded-3 mb-5 border-start border-4\" style=\"background-color:#faf7f2;border-color:#e4762c\"><p class=\"text-uppercase fw-bold mb-3\" style=\"color:#16192c;font-size:13px\">Highlights</p><ul class=\"mb-0\" style=\"padding-left:18px\"><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">More than 40 breakfast buffet dishes, rotating Asian and European menus daily</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Seating for 350 guests – the largest of the hotel\'s restaurants</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Gala dinners, weddings and corporate events with bespoke menus</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">The breakfast buffet is included in every room rate</li></ul></div><div class=\"row g-3 mb-5\"><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/Anh_1_4_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div></div><div class=\"p-4 p-md-5 rounded-3 text-center\" style=\"background-color:#16192c\"><h3 class=\"text-uppercase fw-bold text-white mb-2\" style=\"font-size:20px\">Reserve a table at Vela Restaurant</h3><p class=\"mb-4\" style=\"color:#b9bdc9\">Advance booking is required for parties of 20 or more.</p><p class=\"mb-2 text-white\" style=\"font-size:18px\">Hotline: <a href=\"tel:+842543577789\" style=\"color:#e4762c;text-decoration:none\"><strong>(+84) 254 3 577 789</strong></a></p><p class=\"mb-0\"><a href=\"mailto:res@malibuhotel.com.vn\" style=\"color:#b9bdc9;text-decoration:underline\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 5, 'Carina Restaurant – Fusion Cuisine', 'A 6th-floor restaurant with an extraordinary view, seating 60 guests plus a 20-seat VIP room, serving European-Asian fusion cuisine.', '<div class=\"mb-5\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg\" alt=\"Carina Restaurant\" class=\"img-fluid rounded-3 w-100 mb-4\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:13px\">6th floor</p><h2 class=\"text-uppercase fw-bold mb-2\" style=\"color:#16192c\">Carina Restaurant</h2><p class=\"lead mb-0\" style=\"color:#6b7280\">European-Asian fusion cuisine with an extraordinary view</p></div><div class=\"row g-3 mb-5\"><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Location</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">6th floor, The Malibu Hotel</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Capacity</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">60 guests + a 20-seat VIP room</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Hours</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">11:00 am – 10:00 pm daily</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Style</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">European-Asian fusion</p></div></div></div><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Located on the 6th floor with an extraordinary view over the city and the sea, Carina Restaurant features modern design and relaxed music, providing guests with a classy dining experience.</p><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">The restaurant seats around 60 guests, with a VIP room reserved for 20 – ideal for private, elegant celebrations and special events, and a beautiful choice for a romantic evening.</p><h3 class=\"text-uppercase fw-bold mb-3 mt-5\" style=\"color:#16192c;font-size:20px\">The menu</h3><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">The menu is inspired by the fusion of European and Asian cuisine, selected from the finest ingredients. Together with the enthusiasm of talented chefs, unique recipes and meticulous attention to detail in serving, Carina creates flavours entirely its own.</p><div class=\"p-4 rounded-3 mb-5 border-start border-4\" style=\"background-color:#faf7f2;border-color:#e4762c\"><p class=\"text-uppercase fw-bold mb-3\" style=\"color:#16192c;font-size:13px\">Ideal for</p><ul class=\"mb-0\" style=\"padding-left:18px\"><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">A romantic dinner overlooking the coastal city by night</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Private celebrations in the 20-seat VIP room</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Anniversaries, birthdays and intimate corporate gatherings</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Bespoke set menus for groups</li></ul></div><div class=\"row g-3 mb-5\"><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/_THP4305-HDR_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div></div><div class=\"p-4 p-md-5 rounded-3 text-center\" style=\"background-color:#16192c\"><h3 class=\"text-uppercase fw-bold text-white mb-2\" style=\"font-size:20px\">Reserve a table at Carina Restaurant</h3><p class=\"mb-4\" style=\"color:#b9bdc9\">The VIP room requires at least 24 hours\' notice.</p><p class=\"mb-2 text-white\" style=\"font-size:18px\">Hotline: <a href=\"tel:+842543577789\" style=\"color:#e4762c;text-decoration:none\"><strong>(+84) 254 3 577 789</strong></a></p><p class=\"mb-0\"><a href=\"mailto:res@malibuhotel.com.vn\" style=\"color:#b9bdc9;text-decoration:underline\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 6, 'The Lux Café – Coffee &amp; Tea', 'A café in the hotel lobby designed like a corner of a Milan street, complete with a piano for spontaneous moments.', '<div class=\"mb-5\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/800x600_1__1.png\" alt=\"The Lux Café\" class=\"img-fluid rounded-3 w-100 mb-4\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:13px\">Hotel lobby</p><h2 class=\"text-uppercase fw-bold mb-2\" style=\"color:#16192c\">The Lux Café</h2><p class=\"lead mb-0\" style=\"color:#6b7280\">A corner of a Milan street in the lobby, piano included</p></div><div class=\"row g-3 mb-5\"><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Location</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">The Malibu Hotel lobby</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Hours</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">7:00 am – 10:00 pm daily</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Style</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">Coffee &amp; tea, pastries, ice cream</p></div></div><div class=\"col-md-6\"><div class=\"p-4 rounded-3 h-100\" style=\"background-color:#faf7f2;border:1px solid #ece4d8\"><p class=\"text-uppercase mb-1\" style=\"color:#e4762c;font-size:12px\">Signature</p><p class=\"mb-0 fw-bold\" style=\"color:#16192c;font-size:17px\">Lobby piano</p></div></div></div><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Before we take you back to work, please pass by The Lux Café in the hotel lobby to enjoy a glass of ice cream or a coffee while checking out.</p><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">Designed like a magnificent corner of a Milan street but no less fashionable, The Lux Café will make you feel as though you are immersed in the breath of the fashion capital.</p><h3 class=\"text-uppercase fw-bold mb-3 mt-5\" style=\"color:#16192c;font-size:20px\">An invitation</h3><p class=\"mb-3\" style=\"line-height:1.9;color:#4b5563\">And if you can, leave a concerto for Malibu and our other guests at the lobby piano – a small habit that has become part of the character of an afternoon here.</p><div class=\"p-4 rounded-3 mb-5 border-start border-4\" style=\"background-color:#faf7f2;border-color:#e4762c\"><p class=\"text-uppercase fw-bold mb-3\" style=\"color:#16192c;font-size:13px\">Suggestions</p><ul class=\"mb-0\" style=\"padding-left:18px\"><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Vietnamese coffee alongside Italian espresso-based classics</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Tea and pastries served all day</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">Ice cream and cold drinks for a Vung Tau afternoon</li><li class=\"mb-2\" style=\"line-height:1.8;color:#4b5563\">A quiet corner well suited to a short business meeting</li></ul></div><div class=\"row g-3 mb-5\"><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/800x600_1__1.png\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div><div class=\"col-6 col-md-4\"><img src=\"https://malibuhotel.com.vn/files/blog/46_1815/DSC00288_1.jpg\" alt=\"\" class=\"img-fluid rounded-3 w-100\"></div></div><div class=\"p-4 p-md-5 rounded-3 text-center\" style=\"background-color:#16192c\"><h3 class=\"text-uppercase fw-bold text-white mb-2\" style=\"font-size:20px\">Visit The Lux Café</h3><p class=\"mb-4\" style=\"color:#b9bdc9\">No reservation needed – you are welcome any time during opening hours.</p><p class=\"mb-2 text-white\" style=\"font-size:18px\">Hotline: <a href=\"tel:+842543577789\" style=\"color:#e4762c;text-decoration:none\"><strong>(+84) 254 3 577 789</strong></a></p><p class=\"mb-0\"><a href=\"mailto:res@malibuhotel.com.vn\" style=\"color:#b9bdc9;text-decoration:underline\">res@malibuhotel.com.vn</a></p></div>', NULL),
('en_US', 7, 'Conference – Meetings &amp; Seminars', 'Seven conference rooms for up to 450 guests; the Malibu Grand room can be divided into three rooms of 120 guests each.', '<div class=\"service-detail\"><p>The Malibu Hotel has 7 conference rooms for up to 450 guests. The Malibu Grand room can be separated into 3 smaller rooms with a capacity of 120 guests each by a flexible partition system.</p><p>With an international-standard sound system, modern LED screens and projectors and high-class interiors, we are ready to meet the needs of all our guests.</p><p>We also offer professional technical support and flexible equipment and catering packages, ensuring each of your events runs smoothly and successfully.</p><h3>Contact</h3><p>Phone: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn</p></div>', NULL),
('en_US', 8, 'Kid Zone – Children\'s Playground', 'A safe, spacious play area with educational games and attentive staff.', '<div class=\"service-detail\"><p>Our Kid Zone is the perfect place for children to relax and enjoy safe and creative playtime while you unwind at the hotel.</p><p>It is specially designed with a variety of games and activities, ranging from active games to educational ones, ensuring children have both fun and enriching experiences. Our professional and attentive staff are always available to supervise and assist.</p><h3>Hours</h3><p>Everyday: 9:00 am – 5:00 pm</p></div>', NULL),
('en_US', 9, 'Entertainment', 'A 6th-floor entertainment area with a 3D golf system simulating a range of practice courses.', '<div class=\"service-detail\"><p>Practising golf not only satisfies golfers\' passion for the game, it also helps you improve quickly and brings wonderful moments of relaxation after a stressful day of work.</p><p>3D Golf is a system that simulates and recreates scenes and activities similar to real golf. A special feature is that with 3D golf, golfers can choose different types of practice courses to improve their flexibility.</p><h3>Hours</h3><p>Please contact the front desk for the most current hours of operation.</p></div>', NULL),
('en_US', 10, 'Billiard &amp; Foosball', 'Billiard and foosball tables in the 6th-floor entertainment area, for relaxed evenings with friends and family.', '<div class=\"service-detail\"><p>The Billiard &amp; Foosball area sits within the 6th-floor entertainment complex of The Malibu Hotel – a place to unwind with friends, colleagues or family after a long day.</p><p>Standard billiard tables and foosball tables are regularly maintained, in an airy space right beside the M Pool and M Gym.</p><h3>Hours</h3><p>Everyday: 7:00 am – 10:00 pm</p></div>', NULL),
('en_US', 11, 'Private Laundry', 'A fully in-house, closed-cycle laundry that uses no third-party services, open 24/7.', '<div class=\"service-detail\"><p>The Malibu Hotel laundry runs on a completely closed and unique cycle, without using the services of any third party.</p><p>As a result, all the fabrics used to serve guests are classified, washed, pasteurised and steamed very thoroughly, with a comfortable natural scent that is absolutely safe – ensuring the criteria of health and comfort for our guests.</p><h3>Hours</h3><p>24/7</p></div>', NULL),
('en_US', 12, 'Gift Shop', 'A gift and souvenir shop inside the hotel, open 24/7.', '<div class=\"service-detail\"><p>Our gift shop is a unique and diverse shopping space where you can find the perfect gift for family, friends, or even yourself.</p><p>With a wide range of high-quality products, from elegant jewellery to unique handcrafted items and special souvenirs, we are committed to providing you with a memorable shopping experience that complements your travel journey.</p><p>Our staff are always available to help you choose the most suitable products.</p><h3>Hours</h3><p>Everyday: 24/7</p></div>', NULL);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ht_taxes`
--

DROP TABLE IF EXISTS `ht_taxes`;
CREATE TABLE `ht_taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `percentage` float DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ht_taxes`
--

INSERT INTO `ht_taxes` (`id`, `title`, `percentage`, `priority`, `status`, `created_at`, `updated_at`) VALUES
(1, 'VAT', 10, 1, 'published', '2025-06-10 10:38:11', '2025-06-10 10:38:11'),
(2, 'None', 0, 2, 'published', '2025-06-10 10:38:11', '2025-06-10 10:38:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `lang_id` bigint(20) UNSIGNED NOT NULL,
  `lang_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_locale` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_flag` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_is_default` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `lang_order` int(11) NOT NULL DEFAULT 0,
  `lang_is_rtl` tinyint(3) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `languages`
--

INSERT INTO `languages` (`lang_id`, `lang_name`, `lang_locale`, `lang_code`, `lang_flag`, `lang_is_default`, `lang_order`, `lang_is_rtl`) VALUES
(1, 'English', 'en', 'en_US', 'us', 0, 1, 0),
(2, 'Tiếng Việt', 'vi', 'vi', 'vn', 1, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `language_meta`
--

DROP TABLE IF EXISTS `language_meta`;
CREATE TABLE `language_meta` (
  `lang_meta_id` bigint(20) UNSIGNED NOT NULL,
  `lang_meta_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_meta_origin` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint(20) UNSIGNED NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `language_meta`
--

INSERT INTO `language_meta` (`lang_meta_id`, `lang_meta_code`, `lang_meta_origin`, `reference_id`, `reference_type`) VALUES
(1, 'vi', '87a0f3fb42441aabd09075803fe43aed', 1, 'Botble\\Menu\\Models\\Menu'),
(2, 'en_US', '87a0f3fb42441aabd09075803fe43aed', 15, 'Botble\\Menu\\Models\\Menu'),
(3, 'vi', '633bb60f5f9defd6269ee2d27094b0ad', 2, 'Botble\\Menu\\Models\\Menu'),
(4, 'en_US', '633bb60f5f9defd6269ee2d27094b0ad', 24, 'Botble\\Menu\\Models\\Menu'),
(5, 'vi', 'bf0e9301a31215b2dd254378c4c153c7', 3, 'Botble\\Menu\\Models\\Menu'),
(6, 'en_US', 'bf0e9301a31215b2dd254378c4c153c7', 25, 'Botble\\Menu\\Models\\Menu'),
(7, 'vi', 'a08aee515b21cf29ba175e8372821330', 1, 'Botble\\Menu\\Models\\MenuNode'),
(8, 'en_US', 'a08aee515b21cf29ba175e8372821330', 29, 'Botble\\Menu\\Models\\MenuNode'),
(9, 'vi', 'c67e374d6cc02900e54760ffbcd5d1a3', 2, 'Botble\\Menu\\Models\\MenuNode'),
(10, 'en_US', 'c67e374d6cc02900e54760ffbcd5d1a3', 30, 'Botble\\Menu\\Models\\MenuNode'),
(11, 'vi', '4654cd96408262869b9a2aab186f0ab1', 3, 'Botble\\Menu\\Models\\MenuNode'),
(12, 'en_US', '4654cd96408262869b9a2aab186f0ab1', 31, 'Botble\\Menu\\Models\\MenuNode'),
(13, 'vi', '781f9fbb73db2f43ee700eeabf82f02d', 4, 'Botble\\Menu\\Models\\MenuNode'),
(14, 'en_US', '781f9fbb73db2f43ee700eeabf82f02d', 32, 'Botble\\Menu\\Models\\MenuNode'),
(15, 'vi', '2c254dead4883b5faf23329ee5c94c44', 5, 'Botble\\Menu\\Models\\MenuNode'),
(16, 'en_US', '2c254dead4883b5faf23329ee5c94c44', 33, 'Botble\\Menu\\Models\\MenuNode'),
(17, 'vi', '9453bf1b8c60a5953aaca8ff529fb120', 6, 'Botble\\Menu\\Models\\MenuNode'),
(18, 'en_US', '9453bf1b8c60a5953aaca8ff529fb120', 34, 'Botble\\Menu\\Models\\MenuNode'),
(19, 'vi', 'd100c478c622826bae32fa5ca599f1fb', 7, 'Botble\\Menu\\Models\\MenuNode'),
(20, 'en_US', 'd100c478c622826bae32fa5ca599f1fb', 35, 'Botble\\Menu\\Models\\MenuNode'),
(21, 'vi', '5c68e6d74ffecb84ff6bac91ff11998a', 8, 'Botble\\Menu\\Models\\MenuNode'),
(22, 'en_US', '5c68e6d74ffecb84ff6bac91ff11998a', 36, 'Botble\\Menu\\Models\\MenuNode'),
(23, 'vi', 'a659bef5f7c5b85b0a41759e55de9eaa', 9, 'Botble\\Menu\\Models\\MenuNode'),
(24, 'en_US', 'a659bef5f7c5b85b0a41759e55de9eaa', 37, 'Botble\\Menu\\Models\\MenuNode'),
(25, 'vi', 'de25f807400688afc730b081445e7e16', 10, 'Botble\\Menu\\Models\\MenuNode'),
(26, 'en_US', 'de25f807400688afc730b081445e7e16', 38, 'Botble\\Menu\\Models\\MenuNode'),
(27, 'vi', '90d9a144a362c8be393bea52c13192cc', 11, 'Botble\\Menu\\Models\\MenuNode'),
(28, 'en_US', '90d9a144a362c8be393bea52c13192cc', 39, 'Botble\\Menu\\Models\\MenuNode'),
(29, 'vi', 'b112507bb26eb418c0a06b9a634bb554', 12, 'Botble\\Menu\\Models\\MenuNode'),
(30, 'en_US', 'b112507bb26eb418c0a06b9a634bb554', 40, 'Botble\\Menu\\Models\\MenuNode'),
(31, 'vi', 'a77192aaf9a09872d04d242ac1080001', 13, 'Botble\\Menu\\Models\\MenuNode'),
(32, 'en_US', 'a77192aaf9a09872d04d242ac1080001', 41, 'Botble\\Menu\\Models\\MenuNode'),
(33, 'vi', 'c554cfecc610d176f97c3fa785edc9ec', 14, 'Botble\\Menu\\Models\\MenuNode'),
(34, 'en_US', 'c554cfecc610d176f97c3fa785edc9ec', 42, 'Botble\\Menu\\Models\\MenuNode'),
(35, 'vi', 'dac2d55178ccb65337d806c8e72190a8', 15, 'Botble\\Menu\\Models\\MenuNode'),
(36, 'en_US', 'dac2d55178ccb65337d806c8e72190a8', 43, 'Botble\\Menu\\Models\\MenuNode'),
(37, 'vi', '3af39dae2fe32eaed189c710a13f9cbd', 16, 'Botble\\Menu\\Models\\MenuNode'),
(38, 'en_US', '3af39dae2fe32eaed189c710a13f9cbd', 44, 'Botble\\Menu\\Models\\MenuNode'),
(39, 'vi', 'b8ea70e937f220499670ee6272044db2', 17, 'Botble\\Menu\\Models\\MenuNode'),
(40, 'en_US', 'b8ea70e937f220499670ee6272044db2', 45, 'Botble\\Menu\\Models\\MenuNode'),
(41, 'vi', 'c3cdb22c9b986dcf6636ff0fa08f41d9', 18, 'Botble\\Menu\\Models\\MenuNode'),
(42, 'en_US', 'c3cdb22c9b986dcf6636ff0fa08f41d9', 46, 'Botble\\Menu\\Models\\MenuNode'),
(43, 'vi', '04a4505a2759c4855b2f335b63930e4c', 19, 'Botble\\Menu\\Models\\MenuNode'),
(44, 'en_US', '04a4505a2759c4855b2f335b63930e4c', 47, 'Botble\\Menu\\Models\\MenuNode'),
(45, 'vi', '72f33cb0de50201820611356e4a7b81f', 20, 'Botble\\Menu\\Models\\MenuNode'),
(46, 'en_US', '72f33cb0de50201820611356e4a7b81f', 48, 'Botble\\Menu\\Models\\MenuNode'),
(47, 'vi', 'b34053bcd13f71636aa614e4c9fa5f5e', 21, 'Botble\\Menu\\Models\\MenuNode'),
(48, 'en_US', 'b34053bcd13f71636aa614e4c9fa5f5e', 49, 'Botble\\Menu\\Models\\MenuNode'),
(49, 'vi', '01d0e37e23297ec8c033960ce711591a', 22, 'Botble\\Menu\\Models\\MenuNode'),
(50, 'en_US', '01d0e37e23297ec8c033960ce711591a', 50, 'Botble\\Menu\\Models\\MenuNode'),
(51, 'vi', '02eefc99268de13ba94031c6e79015c0', 23, 'Botble\\Menu\\Models\\MenuNode'),
(52, 'en_US', '02eefc99268de13ba94031c6e79015c0', 51, 'Botble\\Menu\\Models\\MenuNode'),
(53, 'vi', '4996e85b337bdd9362b747f5cffff2a8', 24, 'Botble\\Menu\\Models\\MenuNode'),
(54, 'en_US', '4996e85b337bdd9362b747f5cffff2a8', 52, 'Botble\\Menu\\Models\\MenuNode'),
(55, 'vi', '2dccb728a763890cee6e1f47f9177165', 25, 'Botble\\Menu\\Models\\MenuNode'),
(56, 'en_US', '2dccb728a763890cee6e1f47f9177165', 53, 'Botble\\Menu\\Models\\MenuNode'),
(57, 'vi', 'b292e27ca7096202e7f5df45fd7d8ff8', 26, 'Botble\\Menu\\Models\\MenuNode'),
(58, 'en_US', 'b292e27ca7096202e7f5df45fd7d8ff8', 54, 'Botble\\Menu\\Models\\MenuNode'),
(59, 'vi', '6e23ddc5b2a871f8563c41b891b26107', 27, 'Botble\\Menu\\Models\\MenuNode'),
(60, 'en_US', '6e23ddc5b2a871f8563c41b891b26107', 55, 'Botble\\Menu\\Models\\MenuNode'),
(61, 'vi', '9c9db40e7b7caf8da8699e302e0377c0', 28, 'Botble\\Menu\\Models\\MenuNode'),
(62, 'en_US', '9c9db40e7b7caf8da8699e302e0377c0', 56, 'Botble\\Menu\\Models\\MenuNode'),
(63, 'vi', 'df06950164b91e3c2ae9197247d1e143', 57, 'Botble\\Menu\\Models\\MenuNode'),
(64, 'en_US', 'df06950164b91e3c2ae9197247d1e143', 62, 'Botble\\Menu\\Models\\MenuNode'),
(65, 'vi', '1f3c38e8e2ff7bfe6d087e0a1c84dca0', 58, 'Botble\\Menu\\Models\\MenuNode'),
(66, 'en_US', '1f3c38e8e2ff7bfe6d087e0a1c84dca0', 63, 'Botble\\Menu\\Models\\MenuNode'),
(67, 'vi', '7b147e2435c987c33f1fe3b98e855d15', 59, 'Botble\\Menu\\Models\\MenuNode'),
(68, 'en_US', '7b147e2435c987c33f1fe3b98e855d15', 64, 'Botble\\Menu\\Models\\MenuNode'),
(69, 'vi', 'da6ae34e348a820d6546d3074e105a82', 60, 'Botble\\Menu\\Models\\MenuNode'),
(70, 'en_US', 'da6ae34e348a820d6546d3074e105a82', 65, 'Botble\\Menu\\Models\\MenuNode'),
(71, 'vi', '25d9069b13b31f8576a4f366c56e32d8', 61, 'Botble\\Menu\\Models\\MenuNode'),
(72, 'en_US', '25d9069b13b31f8576a4f366c56e32d8', 66, 'Botble\\Menu\\Models\\MenuNode'),
(73, 'vi', 'ce5866542fdf01c6a16720f17573c3f2', 67, 'Botble\\Menu\\Models\\MenuNode'),
(74, 'en_US', 'ce5866542fdf01c6a16720f17573c3f2', 69, 'Botble\\Menu\\Models\\MenuNode'),
(75, 'vi', '3b568ca46ebe27f7c9088ad297e3a18e', 68, 'Botble\\Menu\\Models\\MenuNode'),
(76, 'en_US', '3b568ca46ebe27f7c9088ad297e3a18e', 70, 'Botble\\Menu\\Models\\MenuNode'),
(77, 'vi', '849d897ccbc872c2e4c398ed6924e8ea', 1, 'Botble\\Menu\\Models\\MenuLocation'),
(78, 'en_US', '849d897ccbc872c2e4c398ed6924e8ea', 2, 'Botble\\Menu\\Models\\MenuLocation');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `media_files`
--

DROP TABLE IF EXISTS `media_files`;
CREATE TABLE `media_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `mime_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(11) NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `visibility` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `media_files`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `media_folders`
--

DROP TABLE IF EXISTS `media_folders`;
CREATE TABLE `media_folders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `media_folders`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `media_settings`
--

DROP TABLE IF EXISTS `media_settings`;
CREATE TABLE `media_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `media_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `media_settings`
--

INSERT INTO `media_settings` (`id`, `key`, `value`, `media_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'recent_items', '[{\"id\":2518,\"is_folder\":false},{\"id\":2474,\"is_folder\":false},{\"id\":2473,\"is_folder\":false},{\"id\":2475,\"is_folder\":false},{\"id\":2476,\"is_folder\":false},{\"id\":2478,\"is_folder\":false},{\"id\":2477,\"is_folder\":false},{\"id\":2494,\"is_folder\":false},{\"id\":2487,\"is_folder\":false},{\"id\":2486,\"is_folder\":false},{\"id\":2488,\"is_folder\":false},{\"id\":2493,\"is_folder\":false},{\"id\":2492,\"is_folder\":false},{\"id\":2491,\"is_folder\":false},{\"id\":2489,\"is_folder\":false},{\"id\":2490,\"is_folder\":false},{\"id\":2482,\"is_folder\":false},{\"id\":2480,\"is_folder\":false},{\"id\":2429,\"is_folder\":false},{\"id\":2275,\"is_folder\":false}]', NULL, 1, '2026-03-13 01:54:10', '2026-07-12 14:48:51'),
(2, 'recent_items', '[{\"id\":63,\"is_folder\":true},{\"id\":1027,\"is_folder\":false},{\"id\":206,\"is_folder\":true},{\"id\":1026,\"is_folder\":false},{\"id\":205,\"is_folder\":true}]', NULL, 2, '2026-03-28 08:38:09', '2026-03-28 08:38:46'),
(3, 'recent_items', '[{\"id\":2543,\"is_folder\":false},{\"id\":2541,\"is_folder\":false},{\"id\":2540,\"is_folder\":false},{\"id\":2542,\"is_folder\":false},{\"id\":2539,\"is_folder\":false},{\"id\":2538,\"is_folder\":false},{\"id\":2537,\"is_folder\":false},{\"id\":2536,\"is_folder\":false},{\"id\":2535,\"is_folder\":false},{\"id\":2534,\"is_folder\":false},{\"id\":2533,\"is_folder\":false},{\"id\":2532,\"is_folder\":false},{\"id\":2531,\"is_folder\":false},{\"id\":2525,\"is_folder\":false},{\"id\":2530,\"is_folder\":false},{\"id\":2524,\"is_folder\":false},{\"id\":2526,\"is_folder\":false},{\"id\":2521,\"is_folder\":false},{\"id\":2520,\"is_folder\":false},{\"id\":2519,\"is_folder\":false}]', NULL, 3, '2026-08-04 02:34:57', '2026-09-03 06:42:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `menus`
--

INSERT INTO `menus` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Main menu', 'main-menu', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'Liên kết', 'our-links', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'Chính sách', 'our-services', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(15, 'Main menu EN', 'main-menu-en', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(24, 'Our Links', 'link', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(25, 'Policy', 'policy', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu_locations`
--

DROP TABLE IF EXISTS `menu_locations`;
CREATE TABLE `menu_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `menu_locations`
--

INSERT INTO `menu_locations` (`id`, `menu_id`, `location`, `created_at`, `updated_at`) VALUES
(1, 1, 'main-menu', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 15, 'main-menu', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu_nodes`
--

DROP TABLE IF EXISTS `menu_nodes`;
CREATE TABLE `menu_nodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_font` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `css_class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `has_child` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `menu_nodes`
--

INSERT INTO `menu_nodes` (`id`, `menu_id`, `parent_id`, `reference_id`, `reference_type`, `url`, `icon_font`, `position`, `title`, `css_class`, `target`, `has_child`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 1, 'Botble\\Page\\Models\\Page', '', 'fa fa-home', 0, 'Trang chủ', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 1, 0, 0, NULL, '/rooms', '', 1, 'Phòng nghỉ', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 1, 2, 0, NULL, '/room-categories/premier', '', 0, 'Premier', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 1, 3, 0, NULL, '/rooms/phong-premier-twin', '', 0, 'Phòng Premier Twin', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 1, 3, 0, NULL, '/rooms/phong-premier-king', '', 1, 'Phòng Premier King', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 1, 3, 0, NULL, '/rooms/phong-premier-queen', '', 2, 'Phòng Premier Queen', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 1, 3, 0, NULL, '/rooms/phong-premier-family', '', 3, 'Phòng Premier Family', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 1, 2, 0, NULL, '/room-categories/diamond', '', 1, 'Diamond', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 1, 8, 0, NULL, '/rooms/phong-diamond-king', '', 0, 'Phòng Diamond King', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 1, 8, 0, NULL, '/rooms/phong-diamond-family', '', 1, 'Phòng Diamond Family', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 1, 2, 0, NULL, '/room-categories/suite', '', 2, 'Suite', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 1, 11, 0, NULL, '/rooms/malibu-suite', '', 0, 'Malibu Suite', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, 1, 11, 0, NULL, '/rooms/family-suite', '', 1, 'Family Suite', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(14, 1, 2, 0, NULL, '/room-categories/president', '', 3, 'President', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(15, 1, 14, 0, NULL, '/rooms/vice-president-suite', '', 0, 'Vice President Suite', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(16, 1, 14, 0, NULL, '/rooms/presidential-suite', '', 1, 'Presidential Suite', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(17, 1, 0, 6, 'Botble\\Page\\Models\\Page', '/tien-nghi-dich-vu', '', 2, 'Tiện nghi &amp; Dịch vụ', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(18, 1, 17, 0, NULL, '/services/m-pool', '', 0, 'M Pool – Hồ bơi ngoài trời', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(19, 1, 17, 0, NULL, '/services/m-spa', '', 1, 'M Spa – Chăm sóc và trị liệu', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(20, 1, 17, 0, NULL, '/services/m-gym', '', 2, 'M Gym – Phòng tập thể hình', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(21, 1, 17, 0, NULL, '/services/vela-restaurant', '', 3, 'Vela Restaurant – Buffet sáng', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(22, 1, 17, 0, NULL, '/services/carina-restaurant', '', 4, 'Carina Restaurant – Ẩm thực Á Âu', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(23, 1, 17, 0, NULL, '/services/the-lux-cafe', '', 5, 'The Lux Café – Cà phê &amp; trà', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(24, 1, 0, 9, 'Botble\\Page\\Models\\Page', '/am-thuc', '', 3, 'Ẩm thực', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(25, 1, 0, 18, 'Botble\\Page\\Models\\Page', '/hoi-nghi-su-kien', '', 4, 'Hội nghị &amp; Sự kiện', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(26, 1, 0, 7, 'Botble\\Page\\Models\\Page', '/thu-vien-anh', '', 5, 'Thư viện ảnh', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(27, 1, 0, 10, 'Botble\\Page\\Models\\Page', '/tin-tuc', '', 6, 'Tin tức', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(28, 1, 0, 11, 'Botble\\Page\\Models\\Page', '/lien-he', '', 7, 'Liên hệ', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(29, 15, 0, 1, 'Botble\\Page\\Models\\Page', '', 'fa fa-home', 0, 'Home', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(30, 15, 0, 0, NULL, '/en/rooms', '', 1, 'Rooms', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(31, 15, 30, 0, NULL, '/en/room-categories/premier', '', 0, 'Premier', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(32, 15, 31, 0, NULL, '/en/rooms/premier-twin-room', '', 0, 'Premier Twin', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(33, 15, 31, 0, NULL, '/en/rooms/premier-king-room', '', 1, 'Premier King', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(34, 15, 31, 0, NULL, '/en/rooms/premier-queen-room', '', 2, 'Premier Queen', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(35, 15, 31, 0, NULL, '/en/rooms/premier-family-room', '', 3, 'Premier Family', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(36, 15, 30, 0, NULL, '/en/room-categories/diamond', '', 1, 'Diamond', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(37, 15, 36, 0, NULL, '/en/rooms/diamond-king-room', '', 0, 'Diamond King', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(38, 15, 36, 0, NULL, '/en/rooms/diamond-family-room', '', 1, 'Diamond Family', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(39, 15, 30, 0, NULL, '/en/room-categories/suite', '', 2, 'Suite', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(40, 15, 39, 0, NULL, '/en/rooms/malibu-suite', '', 0, 'Malibu Suite', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(41, 15, 39, 0, NULL, '/en/rooms/family-suite', '', 1, 'Family Suite', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(42, 15, 30, 0, NULL, '/en/room-categories/president', '', 3, 'President', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(43, 15, 42, 0, NULL, '/en/rooms/vice-president-suite', '', 0, 'Vice President Suite', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(44, 15, 42, 0, NULL, '/en/rooms/presidential-suite', '', 1, 'Presidential Suite', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(45, 15, 0, 6, 'Botble\\Page\\Models\\Page', '/en/tien-nghi-dich-vu', '', 2, 'Facilities', '', '_self', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(46, 15, 45, 0, NULL, '/en/services/m-pool', '', 0, 'M Pool – Outdoor Pool', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(47, 15, 45, 0, NULL, '/en/services/m-spa', '', 1, 'M Spa – Health Care &amp; Treatment', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(48, 15, 45, 0, NULL, '/en/services/m-gym', '', 2, 'M Gym – Fitness Centre', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(49, 15, 45, 0, NULL, '/en/services/vela-restaurant', '', 3, 'Vela Restaurant – Breakfast Buffet', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(50, 15, 45, 0, NULL, '/en/services/carina-restaurant', '', 4, 'Carina Restaurant – Fusion Cuisine', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(51, 15, 45, 0, NULL, '/en/services/the-lux-cafe', '', 5, 'The Lux Café – Coffee &amp; Tea', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(52, 15, 0, 9, 'Botble\\Page\\Models\\Page', '/en/am-thuc', '', 3, 'Dine', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(53, 15, 0, 18, 'Botble\\Page\\Models\\Page', '/en/hoi-nghi-su-kien', '', 4, 'Meetings &amp; Events', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(54, 15, 0, 7, 'Botble\\Page\\Models\\Page', '/en/thu-vien-anh', '', 5, 'Gallery', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(55, 15, 0, 10, 'Botble\\Page\\Models\\Page', '/en/tin-tuc', '', 6, 'News', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(56, 15, 0, 11, 'Botble\\Page\\Models\\Page', '/en/lien-he', '', 7, 'Contact', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(57, 2, 0, 5, 'Botble\\Page\\Models\\Page', '/ve-chung-toi', '', 0, 'Về chúng tôi', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(58, 2, 0, 19, 'Botble\\Page\\Models\\Page', '/malibu-group', '', 1, 'Malibu Group', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(59, 2, 0, 22, 'Botble\\Page\\Models\\Page', '/tuyen-dung', '', 2, 'Tuyển dụng', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(60, 2, 0, 8, 'Botble\\Page\\Models\\Page', '/cau-hoi-thuong-gap', '', 3, 'Câu hỏi thường gặp', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(61, 2, 0, 11, 'Botble\\Page\\Models\\Page', '/lien-he', '', 4, 'Liên hệ', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(62, 24, 0, 5, 'Botble\\Page\\Models\\Page', '/en/ve-chung-toi', '', 0, 'About Us', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(63, 24, 0, 19, 'Botble\\Page\\Models\\Page', '/en/malibu-group', '', 1, 'Malibu Group', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(64, 24, 0, 22, 'Botble\\Page\\Models\\Page', '/en/tuyen-dung', '', 2, 'Careers', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(65, 24, 0, 8, 'Botble\\Page\\Models\\Page', '/en/cau-hoi-thuong-gap', '', 3, 'Hotel FAQs', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(66, 24, 0, 11, 'Botble\\Page\\Models\\Page', '/en/lien-he', '', 4, 'Contact', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(67, 3, 0, 12, 'Botble\\Page\\Models\\Page', '/chinh-sach-bao-mat', '', 0, 'Chính sách bảo mật', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(68, 3, 0, 13, 'Botble\\Page\\Models\\Page', '/dieu-khoan-va-dieu-kien', '', 1, 'Điều khoản và điều kiện', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(69, 25, 0, 12, 'Botble\\Page\\Models\\Page', '/en/chinh-sach-bao-mat', '', 0, 'Privacy Policy', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(70, 25, 0, 13, 'Botble\\Page\\Models\\Page', '/en/dieu-khoan-va-dieu-kien', '', 1, 'Terms and Conditions', '', '_self', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `meta_boxes`
--

DROP TABLE IF EXISTS `meta_boxes`;
CREATE TABLE `meta_boxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `meta_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `meta_boxes` (`id`, `meta_key`, `meta_value`, `reference_id`, `reference_type`, `created_at`, `updated_at`) VALUES
(1, 'breadcrumb', '[\"0\"]', 1, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'breadcrumb', '[\"1\"]', 5, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL1.jpg\"]', 5, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'breadcrumb', '[\"1\"]', 6, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/blog/46_1815/ENTERTAINMENT.jpg\"]', 6, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'breadcrumb', '[\"1\"]', 7, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-159.jpg\"]', 7, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 'breadcrumb', '[\"1\"]', 8, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-160.jpg\"]', 8, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 'breadcrumb', '[\"1\"]', 9, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg\"]', 9, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 'breadcrumb', '[\"1\"]', 10, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-04.jpg\"]', 10, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(14, 'breadcrumb', '[\"1\"]', 11, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(15, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/70/346498570_1304832573402425_3861313240524634359_n.jpg\"]', 11, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(16, 'breadcrumb', '[\"1\"]', 12, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(17, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL2.jpg\"]', 12, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(18, 'breadcrumb', '[\"1\"]', 13, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(19, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL2.jpg\"]', 13, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(20, 'breadcrumb', '[\"1\"]', 18, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(21, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/70/meeting-3.jpg\"]', 18, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(22, 'breadcrumb', '[\"1\"]', 19, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(23, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL1.jpg\"]', 19, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(24, 'breadcrumb', '[\"1\"]', 22, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(25, 'breadcrumb_background', '[\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-19.jpg\"]', 22, 'Botble\\Page\\Models\\Page', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(26, 'icon_image', '[\"https://api.iconify.design/mdi/air-conditioner.svg?width=64&color=%23E4762C\"]', 1, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(27, 'icon_image', '[\"https://api.iconify.design/mdi/wifi.svg?width=64&color=%23E4762C\"]', 2, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(28, 'icon_image', '[\"https://api.iconify.design/mdi/safe.svg?width=64&color=%23E4762C\"]', 3, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(29, 'icon_image', '[\"https://api.iconify.design/mdi/food-croissant.svg?width=64&color=%23E4762C\"]', 4, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(30, 'icon_image', '[\"https://api.iconify.design/mdi/television.svg?width=64&color=%23E4762C\"]', 5, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(31, 'icon_image', '[\"https://api.iconify.design/mdi/fridge.svg?width=64&color=%23E4762C\"]', 6, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(32, 'icon_image', '[\"https://api.iconify.design/mdi/kettle.svg?width=64&color=%23E4762C\"]', 7, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(33, 'icon_image', '[\"https://api.iconify.design/mdi/shower.svg?width=64&color=%23E4762C\"]', 8, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(34, 'icon_image', '[\"https://api.iconify.design/mdi/bathtub.svg?width=64&color=%23E4762C\"]', 9, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(35, 'icon_image', '[\"https://api.iconify.design/mdi/balcony.svg?width=64&color=%23E4762C\"]', 10, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(36, 'icon_image', '[\"https://api.iconify.design/mdi/hair-dryer.svg?width=64&color=%23E4762C\"]', 11, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(37, 'icon_image', '[\"https://api.iconify.design/mdi/desk.svg?width=64&color=%23E4762C\"]', 12, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(38, 'icon_image', '[\"https://api.iconify.design/mdi/broom.svg?width=64&color=%23E4762C\"]', 13, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(39, 'icon_image', '[\"https://api.iconify.design/mdi/spray-bottle.svg?width=64&color=%23E4762C\"]', 14, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(40, 'icon_image', '[\"https://api.iconify.design/mdi/headset.svg?width=64&color=%23E4762C\"]', 15, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(41, 'icon_image', '[\"https://api.iconify.design/mdi/waves.svg?width=64&color=%23E4762C\"]', 16, 'Botble\\Hotel\\Models\\Amenity', '2026-09-04 08:00:00', '2026-09-04 08:00:00');

--
-- Đang đổ dữ liệu cho bảng `meta_boxes`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '2013_04_09_032329_create_base_tables', 1),
(3, '2013_04_09_062329_create_revisions_table', 1),
(4, '2014_10_12_000000_create_users_table', 1),
(5, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(6, '2016_06_10_230148_create_acl_tables', 1),
(7, '2016_06_14_230857_create_menus_table', 1),
(8, '2016_06_28_221418_create_pages_table', 1),
(9, '2016_10_05_074239_create_setting_table', 1),
(10, '2016_11_28_032840_create_dashboard_widget_tables', 1),
(11, '2016_12_16_084601_create_widgets_table', 1),
(12, '2017_05_09_070343_create_media_tables', 1),
(13, '2017_11_03_070450_create_slug_table', 1),
(14, '2019_01_05_053554_create_jobs_table', 1),
(15, '2019_08_19_000000_create_failed_jobs_table', 1),
(16, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(17, '2021_08_05_134214_fix_social_link_theme_options', 1),
(18, '2022_04_20_100851_add_index_to_media_table', 1),
(19, '2022_04_20_101046_add_index_to_menu_table', 1),
(20, '2022_07_10_034813_move_lang_folder_to_root', 1),
(21, '2022_08_04_051940_add_missing_column_expires_at', 1),
(22, '2022_09_01_000001_create_admin_notifications_tables', 1),
(23, '2022_10_14_024629_drop_column_is_featured', 1),
(24, '2022_11_18_063357_add_missing_timestamp_in_table_settings', 1),
(25, '2022_12_02_093615_update_slug_index_columns', 1),
(26, '2023_01_30_024431_add_alt_to_media_table', 1),
(27, '2023_02_16_042611_drop_table_password_resets', 1),
(28, '2023_04_23_005903_add_column_permissions_to_admin_notifications', 1),
(29, '2023_05_10_075124_drop_column_id_in_role_users_table', 1),
(30, '2023_08_21_090810_make_page_content_nullable', 1),
(31, '2023_09_14_021936_update_index_for_slugs_table', 1),
(32, '2023_12_07_095130_add_color_column_to_media_folders_table', 1),
(33, '2023_12_17_162208_make_sure_column_color_in_media_folders_nullable', 1),
(34, '2024_04_04_110758_update_value_column_in_user_meta_table', 1),
(35, '2024_05_12_091229_add_column_visibility_to_table_media_files', 1),
(36, '2024_07_07_091316_fix_column_url_in_menu_nodes_table', 1),
(37, '2024_07_12_100000_change_random_hash_for_media', 1),
(38, '2024_09_30_024515_create_sessions_table', 1),
(39, '2024_04_27_100730_improve_analytics_setting', 2),
(40, '2015_06_29_025744_create_audit_history', 3),
(41, '2023_11_14_033417_change_request_column_in_table_audit_histories', 3),
(42, '2025_05_05_000001_add_user_type_to_audit_histories_table', 3),
(43, '2015_06_18_033822_create_blog_table', 4),
(44, '2021_02_16_092633_remove_default_value_for_author_type', 4),
(45, '2021_12_03_030600_create_blog_translations', 4),
(46, '2022_04_19_113923_add_index_to_table_posts', 4),
(47, '2023_08_29_074620_make_column_author_id_nullable', 4),
(48, '2024_07_30_091615_fix_order_column_in_categories_table', 4),
(49, '2025_01_06_033807_add_default_value_for_categories_author_type', 4),
(50, '2016_06_17_091537_create_contacts_table', 5),
(51, '2023_11_10_080225_migrate_contact_blacklist_email_domains_to_core', 5),
(52, '2024_03_20_080001_migrate_change_attribute_email_to_nullable_form_contacts_table', 5),
(53, '2024_03_25_000001_update_captcha_settings_for_contact', 5),
(54, '2024_04_19_063914_create_custom_fields_table', 5),
(55, '2018_07_09_221238_create_faq_table', 6),
(56, '2021_12_03_082134_create_faq_translations', 6),
(57, '2023_11_17_063408_add_description_column_to_faq_categories_table', 6),
(58, '2016_10_13_150201_create_galleries_table', 7),
(59, '2021_12_03_082953_create_gallery_translations', 7),
(60, '2022_04_30_034048_create_gallery_meta_translations_table', 7),
(61, '2023_08_29_075308_make_column_user_id_nullable', 7),
(62, '2020_09_02_033611_hotel_create_table', 8),
(63, '2021_06_25_084734_fix_theme_options', 8),
(64, '2021_08_18_011425_add_column_order_into_rooms', 8),
(65, '2021_08_25_153801_update_table_ht_room_categories', 8),
(66, '2021_08_29_031421_add_translations_tables_for_hotel', 8),
(67, '2023_04_09_083713_update_hotel_customers_table', 8),
(68, '2023_04_17_033111_add_booking_number_of_guests', 8),
(69, '2023_08_11_090349_add_column_password_customers_table', 8),
(70, '2023_08_14_090449_create_reset_password_table', 8),
(71, '2023_08_16_063152_update_ht_booking_room_table', 8),
(72, '2023_08_18_022454_add_new_field_to_ht_customers_table', 8),
(73, '2023_08_23_022361_create_ht_invoices_table', 8),
(74, '2023_08_23_041912_create_hotel_review_table', 8),
(75, '2023_08_23_443543_add_sub_total_to_booking_table', 8),
(76, '2023_08_23_904382_update_field_customer_id_to_invoice_table', 8),
(77, '2023_08_24_534892_add_fields_to_invoice_table', 8),
(78, '2023_08_24_745332_add_field_description_to_invoice_table', 8),
(79, '2023_08_25_061510_add_adjust_type_and_amount_column', 8),
(80, '2023_09_05_083354_create_ht_coupons_table', 8),
(81, '2023_09_06_062315_add_coupon_columns_to_booking_table', 8),
(82, '2023_10_18_024658_add_price_type_column_to_services_table', 8),
(83, '2023_10_24_014726_drop_unique_in_room_name', 8),
(84, '2024_06_10_000000_add_content_ht_services_translations', 8),
(85, '2024_07_11_052139_add_number_of_children_column_to_ht_bookings_table', 8),
(86, '2024_07_16_234051_add_booking_number_into_table_ht_bookings', 8),
(87, '2024_12_10_140304_fix_wrong_customer_account', 8),
(88, '2025_01_22_031331_add_field_content_for_ht_foods_table', 8),
(89, '2025_03_31_111809_create_ht_booking_foods', 8),
(90, '2025_05_16_000001_create_room_calendars_table', 8),
(91, '2025_05_16_000002_create_ical_sync_logs_table', 8),
(92, '2016_10_03_032336_create_languages_table', 9),
(93, '2023_09_14_022423_add_index_for_language_table', 9),
(94, '2021_10_25_021023_fix-priority-load-for-language-advanced', 10),
(95, '2021_12_03_075608_create_page_translations', 10),
(96, '2023_07_06_011444_create_slug_translations_table', 10),
(97, '2017_10_24_154832_create_newsletter_table', 11),
(98, '2024_03_25_000001_update_captcha_settings_for_newsletter', 11),
(109, '2017_07_11_140018_create_simple_slider_table', 13),
(110, '2025_04_08_040931_create_social_logins_table', 14),
(111, '2022_11_02_092723_team_create_team_table', 15),
(112, '2023_08_11_094574_update_team_table', 15),
(113, '2023_11_30_085354_add_missing_description_to_team', 15),
(114, '2024_10_02_030027_add_more_columns_to_teams_translations_table', 15),
(115, '2018_07_09_214610_create_testimonial_table', 16),
(116, '2021_12_03_083642_create_testimonials_translations', 16),
(117, '2016_10_07_193005_create_translations_table', 17),
(118, '2023_12_12_105220_drop_translations_table', 17),
(119, '2025_07_06_030754_add_phone_to_users_table', 18),
(120, '2024_01_01_000000_create_ai_translator_tables', 19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'subscribed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `newsletters`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_mode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_html` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pages`
--

INSERT INTO `pages` (`id`, `name`, `content`, `content_mode`, `custom_html`, `user_id`, `image`, `template`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Trang chủ', '<shortcode>[simple-slider key=\"TRANG BÌA\"][/simple-slider]</shortcode><shortcode>[check-availability-form][/check-availability-form]</shortcode><shortcode>[about-us subtitle=\"The Malibu Hotel\" title=\"Live Beautifully – Sống trọn từng khoảnh khắc\" description=\"The Malibu Hotel toạ lạc tại 263 Lê Hồng Phong, ngay trung tâm thành phố biển Vũng Tàu. Đi vào hoạt động từ tháng 4/2016, khách sạn là toà nhà 23 tầng gồm 2 tầng hầm và 6 tầng dịch vụ, với tổng cộng 197 phòng nghỉ. Kiến trúc lấy cảm hứng từ châu Âu sang trọng và hiện đại; tất cả phòng đều có tầm nhìn hướng ra đại dương và ôm trọn một phần thành phố Vũng Tàu.\" highlights=\"197 phòng nghỉ hướng biển ; Toà nhà 23 tầng, 6 tầng dịch vụ ; Lễ tân và an ninh phục vụ 24/7\" style=\"style-1\" top_left_image=\"https://malibuhotel.com.vn/files/sites/70/DSC00316.jpg\"][/about-us]</shortcode><shortcode>[service-list limit=\"6\"][/service-list]</shortcode><shortcode>[featured-rooms subtitle=\"Các hạng phòng\" title=\"Phòng nghỉ &amp; Suite tại Malibu\" description=\"197 phòng nghỉ trải trên 4 hạng Premier, Diamond, Suite và President – từ phòng 40 m² hướng thành phố và biển đến Presidential Suite 250 m² với tầm nhìn toàn cảnh Vũng Tàu.\" room_ids=\"2,5,6,7,8,10\"][/featured-rooms]</shortcode><shortcode>[feature-area subtitle=\"Hội nghị &amp; Sự kiện\" title=\"7 phòng hội nghị, sức chứa tới 450 khách\" description=\"Phòng Malibu Grand có thể ngăn thành 3 phòng nhỏ 120 khách mỗi phòng. Âm thanh chuẩn quốc tế, màn hình LED và máy chiếu hiện đại, nội thất cao cấp, cùng đội ngũ hỗ trợ kỹ thuật chuyên nghiệp và các gói tiệc linh hoạt.\" image=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_header/conference-header.jpg\" button_primary_label=\"TÌM HIỂU THÊM\" button_primary_url=\"/hoi-nghi-su-kien\"][/feature-area]</shortcode><shortcode>[booking-form subtitle=\"Đặt phòng ngay\" title=\"Kỳ nghỉ của bạn bắt đầu tại Malibu\" image=\"https://malibuhotel.com.vn/files/sites/70/DSC00703.jpg\"][/booking-form]</shortcode>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL1.jpg', 'full-width', 'The Malibu Hotel Vũng Tàu – Live Beautifully.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'Về chúng tôi', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Về The Malibu Hotel</h2><p>Khách sạn Malibu đi vào hoạt động tháng 4/2016 với cơ cấu toà nhà 23 tầng gồm 2 tầng hầm và 6 tầng dịch vụ – trong đó có sảnh hội nghị/tiệc, spa, pool bar, hồ bơi, phòng gym, khu giải trí – cùng khu lưu trú với tổng số 197 phòng nghỉ.</p><h2>Kiến trúc</h2><p>Khách sạn được thiết kế từ nguồn cảm hứng kiến trúc châu Âu sang trọng, hiện đại. Tất cả các phòng tại khách sạn đều có tầm nhìn hướng ra đại dương và một phần ôm trọn thành phố Vũng Tàu xinh đẹp.</p><h2>Tầm nhìn</h2><p>Tầm nhìn của khách sạn trong 5 năm tới là mở rộng thành một chuỗi khách sạn tại miền Đông Nam Bộ, với giá trị cốt lõi là đội ngũ nhân sự tâm huyết yêu nghề và hệ thống quản trị chuyên nghiệp.</p></div></div></div></div><shortcode>[why-choose-us subtitle=\"Vì sao chọn Malibu\" title=\"Những điều làm nên The Malibu Hotel\" description=\"Kiến trúc châu Âu hiện đại, dịch vụ đạt chuẩn quốc tế và vị trí ngay trung tâm thành phố biển Vũng Tàu.\" right_image=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00703.jpg\" background_color=\"#16192C\"][/why-choose-us]</shortcode><shortcode>[hotel-places limit=\"6\"][/hotel-places]</shortcode>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL1.jpg', 'full-width', 'Lịch sử, kiến trúc và tầm nhìn của The Malibu Hotel.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'Tiện nghi &amp; Dịch vụ', '<shortcode>[service-list limit=\"12\"][/service-list]</shortcode><shortcode>[featured-amenities subtitle=\"Tiện nghi trong phòng\" title=\"Tiện nghi tiêu chuẩn tại mọi hạng phòng\" description=\"Điều hoà, Wi-Fi tốc độ cao miễn phí, TV màn hình phẳng, két sắt, minibar, ấm đun nước cùng trà và cà phê, bộ đồ dùng phòng tắm cao cấp.\"][/featured-amenities]</shortcode><shortcode>[newsletter subtitle=\"Bản tin\" title=\"Nhận ưu đãi mới nhất từ Malibu\" description=\"Đăng ký để luôn được cập nhật thông tin và chương trình ưu đãi mới nhất.\" background_color=\"#F7F5F1\"][/newsletter]</shortcode>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/blog/46_1815/ENTERTAINMENT.jpg', 'full-width', 'M Pool, M Spa, M Gym, Kid Zone, Gift Shop và các tiện ích khác tại Malibu.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 'Thư viện ảnh', '<shortcode>[galleries limit=\"12\"][/galleries]</shortcode>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-159.jpg', 'full-width', 'Hình ảnh khách sạn, phòng nghỉ, nhà hàng, hồ bơi và khu giải trí.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 'Câu hỏi thường gặp', '<shortcode>[faqs category_ids=\"1,2,3,4,5\"][/faqs]</shortcode>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-160.jpg', 'full-width', 'Những câu hỏi thường gặp về lưu trú tại The Malibu Hotel.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 'Ẩm thực', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Nhà hàng &amp; Giải trí tại The Malibu Hotel</h2><p>Tận hưởng trải nghiệm ẩm thực tuyệt vời tại các nhà hàng của Malibu. Hãy khám phá Vela Restaurant và Carina Restaurant &amp; Entertainment – nơi hương vị tinh tế hoà quyện cùng không gian sang trọng, mang đến những khoảnh khắc đáng nhớ.</p></div></div></div></div><shortcode>[feature-area subtitle=\"Tầng 3\" title=\"Vela Restaurant\" description=\"Buffet sáng hơn 40 món Á – Âu, sức chứa 350 khách, phục vụ à la carte, buffet và tiệc Gala. Buffet sáng 06:30 – 10:00, tiệc 11:00 – 22:00.\" image=\"https://malibuhotel.com.vn/files/blog/46_1815/Anh_1_4_1.jpg\" button_primary_label=\"CHI TIẾT\" button_primary_url=\"/services/vela-restaurant\"][/feature-area]</shortcode><shortcode>[feature-area subtitle=\"Tầng 6\" title=\"Carina Restaurant\" description=\"Ẩm thực giao thoa Âu – Á với tầm nhìn đặc biệt, sức chứa 60 khách và phòng VIP 20 khách. Phục vụ hằng ngày 11:00 – 22:00.\" image=\"https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg\" button_primary_label=\"CHI TIẾT\" button_primary_url=\"/services/carina-restaurant\"][/feature-area]</shortcode><shortcode>[feature-area subtitle=\"Sảnh khách sạn\" title=\"The Lux Café\" description=\"Quán cà phê thiết kế như một góc phố Milan, có cây đàn piano nơi sảnh. Phục vụ hằng ngày 07:00 – 22:00.\" image=\"https://malibuhotel.com.vn/files/blog/46_1815/800x600_1__1.png\" button_primary_label=\"CHI TIẾT\" button_primary_url=\"/services/the-lux-cafe\"][/feature-area]</shortcode>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg', 'full-width', 'Vela Restaurant, Carina Restaurant và The Lux Café.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 'Tin tức', '<shortcode>[blog-posts paginate=\"12\"][/blog-posts]</shortcode>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-04.jpg', 'blog-sidebar', 'Tin tức, ưu đãi và sự kiện tại The Malibu Hotel.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 'Liên hệ', '<shortcode>[contact-form display_fields=\"phone,email,subject,address\" mandatory_fields=\"phone,email\" title=\"Gửi tin nhắn cho chúng tôi\" button_label=\"Gửi\" address_icon=\"far fa-map\" address_label=\"Địa chỉ\" address_detail=\"263 Lê Hồng Phong, P. Thắng Tam, TP. Vũng Tàu, Bà Rịa - Vũng Tàu\" email_icon=\"far fa-envelope-open\" email_label=\"Email\" email_detail=\"res@malibuhotel.com.vn\" phone_icon=\"far fa-phone\" phone_label=\"Hotline\" phone_detail=\"0941 871 644\"][/contact-form]</shortcode><div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>The Malibu Hotel</h2><p>Công ty TNHH Thương mại Dịch vụ Du lịch Nguyên Hà<br>263 Lê Hồng Phong, P. Thắng Tam, TP. Vũng Tàu, Bà Rịa - Vũng Tàu</p><h2>Văn phòng kinh doanh tại TP. Hồ Chí Minh</h2><p>353 - 355 Đường số 1, P. Bình Trị Đông, Q. Bình Tân, TP. Hồ Chí Minh</p><h2>Liên hệ</h2><p>Tổng đài khách sạn: (0254) 7305 779<br>Hotline đặt phòng: 0941 871 644<br>Email đặt phòng: res@malibuhotel.com.vn<br>Website: www.malibuhotel.com.vn</p><h2>Email theo bộ phận</h2><p>Đặt phòng: res@malibuhotel.com.vn<br>Giám đốc kinh doanh: dos@malibuhotel.com.vn<br>Thông tin chung: info@malibuhotel.com.vn<br>Quản lý vận hành: om@malibuhotel.com.vn<br>Quản lý tiền sảnh: fom@malibuhotel.com.vn<br>Quản lý buồng phòng: hskm@malibuhotel.com.vn</p></div></div></div></div>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/70/346498570_1304832573402425_3861313240524634359_n.jpg', 'full-width', 'Địa chỉ, hotline và email của The Malibu Hotel Vũng Tàu.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 'Chính sách bảo mật', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Chính sách bảo mật</h2><p>The Malibu Hotel (Công ty TNHH Thương mại Dịch vụ Du lịch Nguyên Hà) tôn trọng và cam kết bảo vệ thông tin cá nhân của quý khách. Chính sách này mô tả cách chúng tôi thu thập, sử dụng và bảo vệ dữ liệu khi quý khách sử dụng website và dịch vụ của khách sạn.</p><h2>Thông tin chúng tôi thu thập</h2><p>Họ tên, số điện thoại, địa chỉ email, thông tin giấy tờ tuỳ thân khi làm thủ tục nhận phòng, thông tin đặt phòng và thanh toán, cùng dữ liệu kỹ thuật của trình duyệt khi quý khách truy cập website.</p><h2>Mục đích sử dụng</h2><p>Xử lý và xác nhận đặt phòng, làm thủ tục nhận và trả phòng, xuất hoá đơn, chăm sóc khách hàng, gửi thông tin ưu đãi khi quý khách đồng ý, và thực hiện các nghĩa vụ khai báo lưu trú theo quy định pháp luật Việt Nam.</p><h2>Chia sẻ thông tin</h2><p>Chúng tôi không bán hay cho thuê thông tin cá nhân của quý khách. Thông tin chỉ được chia sẻ với các đơn vị thanh toán, đối tác đặt phòng và cơ quan nhà nước có thẩm quyền trong phạm vi cần thiết.</p><h2>Bảo mật và lưu trữ</h2><p>Dữ liệu được lưu trữ trên hệ thống có kiểm soát truy cập và chỉ được giữ trong thời gian cần thiết cho mục đích đã nêu hoặc theo yêu cầu của pháp luật.</p><h2>Quyền của quý khách</h2><p>Quý khách có quyền yêu cầu truy cập, chỉnh sửa hoặc xoá thông tin cá nhân, và rút lại sự đồng ý nhận thông tin tiếp thị bất cứ lúc nào bằng cách liên hệ info@malibuhotel.com.vn.</p><h2>Cookie</h2><p>Website sử dụng cookie để ghi nhớ tuỳ chọn của quý khách và cải thiện trải nghiệm duyệt web. Quý khách có thể tắt cookie trong cài đặt trình duyệt.</p><h2>Liên hệ</h2><p>Mọi thắc mắc về chính sách bảo mật, vui lòng liên hệ info@malibuhotel.com.vn hoặc (0254) 7305 779.</p></div></div></div></div>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL2.jpg', 'full-width', 'Cách The Malibu Hotel thu thập, sử dụng và bảo vệ thông tin cá nhân.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, 'Điều khoản và điều kiện', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Điều khoản và điều kiện</h2><p>Khi đặt phòng hoặc sử dụng dịch vụ của The Malibu Hotel, quý khách đồng ý với các điều khoản dưới đây.</p><h2>Đặt phòng và thanh toán</h2><p>Đặt phòng chỉ được xác nhận sau khi khách sạn gửi thư xác nhận. Khách sạn có thể yêu cầu thông tin thẻ tín dụng hoặc tiền đặt cọc để đảm bảo giữ phòng. Giá phòng được niêm yết bằng VND và chưa bao gồm thuế, phí dịch vụ trừ khi có ghi chú khác.</p><h2>Nhận và trả phòng</h2><p>Nhận phòng từ 14:00 và trả phòng trước 12:00. Nhận phòng sớm hoặc trả phòng muộn tuỳ thuộc tình trạng phòng trống và có thể phát sinh phụ thu.</p><h2>Huỷ và thay đổi</h2><p>Điều kiện huỷ và thay đổi phụ thuộc vào loại giá đã đặt và được nêu rõ trong thư xác nhận đặt phòng. Trường hợp khách không đến (no-show), khách sạn có thể thu phí tương đương một đêm lưu trú.</p><h2>Giấy tờ và số lượng khách</h2><p>Quý khách vui lòng xuất trình hộ chiếu (khách quốc tế) hoặc CMND/CCCD (khách Việt Nam) còn hiệu lực khi làm thủ tục. Số lượng khách lưu trú phải đúng theo hạng phòng đã đặt; phụ thu áp dụng cho khách thêm người hoặc trẻ em.</p><h2>Nội quy khách sạn</h2><p>Không hút thuốc trong phòng, không mang vật nuôi, không mang chất cháy nổ, vũ khí hoặc thực phẩm có mùi nồng vào phòng nghỉ. Quý khách chịu trách nhiệm bồi thường với thiệt hại gây ra cho tài sản của khách sạn.</p><h2>Trách nhiệm</h2><p>Khách sạn có két sắt trong phòng và an ninh 24/7. Khách sạn không chịu trách nhiệm với tài sản có giá trị không được ký gửi hoặc cất giữ trong két sắt.</p><h2>Luật áp dụng</h2><p>Các điều khoản này được điều chỉnh bởi pháp luật Việt Nam.</p></div></div></div></div>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL2.jpg', 'full-width', 'Điều khoản đặt phòng, huỷ phòng và nội quy lưu trú.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(18, 'Hội nghị &amp; Sự kiện', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Hội nghị &amp; Sự kiện</h2><p>The Malibu Hotel có 7 phòng hội nghị với sức chứa lên đến 450 khách. Phòng Malibu Grand có thể ngăn thành 3 phòng nhỏ, mỗi phòng 120 khách, bằng hệ thống vách ngăn linh hoạt.</p><h2>Trang thiết bị</h2><p>Hệ thống âm thanh chuẩn quốc tế, màn hình LED và máy chiếu hiện đại, nội thất cao cấp – sẵn sàng đáp ứng mọi nhu cầu của quý khách. Chúng tôi cung cấp dịch vụ hỗ trợ kỹ thuật chuyên nghiệp cùng các gói thiết bị và tiệc linh hoạt.</p><h2>Tiệc cưới</h2><p>Từ tiệc cưới ấm cúng đến đại tiệc, đội ngũ của Malibu đồng hành cùng bạn trong từng chi tiết: thực đơn, trang trí, âm thanh ánh sáng và sơ đồ tiệc. Không gian tiệc linh hoạt, phục vụ từ 50 đến 450 khách.</p><h2>Liên hệ</h2><p>Điện thoại: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn</p></div></div></div></div>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/70/meeting-3.jpg', 'full-width', '7 phòng hội nghị sức chứa tới 450 khách và dịch vụ tiệc cưới.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(19, 'Malibu Group', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Malibu Group</h2><p>Bên cạnh The Malibu Hotel Vũng Tàu, Malibu Group còn phát triển các sản phẩm lưu trú khác trong khu vực miền Đông Nam Bộ.</p><h2>The Malibu House</h2><p>Mô hình lưu trú nhỏ gọn, ấm cúng.</p><h2>The Malibu Hotel Sài Gòn</h2><p>Khách sạn của Malibu tại Thành phố Hồ Chí Minh.</p><h2>The Malibu Villa Long Cung</h2><p>Villa nghỉ dưỡng tại khu Long Cung, Vũng Tàu.</p><h2>Sanctuary Villa Hồ Tràm</h2><p>Villa nghỉ dưỡng ven biển tại Hồ Tràm.</p></div></div></div></div>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL1.jpg', 'full-width', 'Các sản phẩm lưu trú khác của Malibu Group.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(22, 'Tuyển dụng', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Tuyển dụng tại The Malibu Hotel</h2><p>Giá trị cốt lõi của Malibu là đội ngũ nhân sự tâm huyết, yêu nghề và một hệ thống quản trị chuyên nghiệp. Chúng tôi luôn tìm kiếm những cộng sự cùng chia sẻ tinh thần \"Live Beautifully\" cho các bộ phận: tiền sảnh, buồng phòng, ẩm thực, bếp, kỹ thuật, kinh doanh và spa.</p><h2>Nộp hồ sơ</h2><p>Gửi hồ sơ về địa chỉ email tuyendung@malibuhotel.com.vn hoặc liên hệ trực tiếp số điện thoại (0254) 3 523 523.</p></div></div></div></div>', 'blocks', NULL, 1, 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-19.jpg', 'full-width', 'Cơ hội nghề nghiệp tại The Malibu Hotel Vũng Tàu.', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pages_translations`
--

DROP TABLE IF EXISTS `pages_translations`;
CREATE TABLE `pages_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pages_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content_mode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `custom_html` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pages_translations`
--

INSERT INTO `pages_translations` (`lang_code`, `pages_id`, `name`, `description`, `content`, `content_mode`, `custom_html`) VALUES
('en_US', 1, 'Home', 'The Malibu Hotel Vung Tau – Live Beautifully.', '<shortcode>[simple-slider key=\"TRANG BÌA\"][/simple-slider]</shortcode><shortcode>[check-availability-form][/check-availability-form]</shortcode><shortcode>[about-us subtitle=\"The Malibu Hotel\" title=\"Live Beautifully\" description=\"The Malibu Hotel stands at 263 Le Hong Phong Street, in the heart of the coastal city of Vung Tau. Opened in April 2016, the hotel is a 23-storey tower with two basement levels and six service floors, offering 197 guest rooms. Its architecture draws on luxurious, modern European design, and every room looks out over the ocean and part of the Vung Tau cityscape.\" highlights=\"197 ocean-view rooms ; 23-storey tower with 6 service floors ; 24/7 front desk and security\" style=\"style-1\" top_left_image=\"https://malibuhotel.com.vn/files/sites/70/DSC00316.jpg\"][/about-us]</shortcode><shortcode>[service-list limit=\"6\"][/service-list]</shortcode><shortcode>[featured-rooms subtitle=\"Rooms &amp; Suites\" title=\"Rooms &amp; Suites at Malibu\" description=\"197 guest rooms across four categories – Premier, Diamond, Suite and President – from 40 sqm rooms facing the city and the sea to the 250 sqm Presidential Suite with panoramic views over Vung Tau.\" room_ids=\"2,5,6,7,8,10\"][/featured-rooms]</shortcode><shortcode>[feature-area subtitle=\"Meetings &amp; Events\" title=\"Seven conference rooms for up to 450 guests\" description=\"The Malibu Grand room can be divided into three rooms of 120 guests each. International-standard sound systems, modern LED screens and projectors, high-class interiors, professional technical support and flexible catering packages.\" image=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_header/conference-header.jpg\" button_primary_label=\"LEARN MORE\" button_primary_url=\"/en/hoi-nghi-su-kien\"][/feature-area]</shortcode><shortcode>[booking-form subtitle=\"Book now\" title=\"Your stay begins at Malibu\" image=\"https://malibuhotel.com.vn/files/sites/70/DSC00703.jpg\"][/booking-form]</shortcode>', 'blocks', NULL),
('en_US', 5, 'About Us', 'The history, architecture and vision of The Malibu Hotel.', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>About The Malibu Hotel</h2><p>The Malibu Hotel opened in April 2016 as a 23-storey tower with two basement levels and six service floors – housing conference and banquet halls, a spa, a pool bar, the swimming pool, a gym and an entertainment area – alongside 197 guest rooms.</p><h2>Architecture</h2><p>The hotel is designed from an inspiration of luxurious, modern European architecture. Every room looks out over the ocean and embraces part of the beautiful city of Vung Tau.</p><h2>Vision</h2><p>Over the next five years the hotel intends to grow into a chain across the south-east of Vietnam, built on core values of a dedicated team and a professional management system.</p></div></div></div></div><shortcode>[why-choose-us subtitle=\"Why Malibu\" title=\"What makes The Malibu Hotel\" description=\"Modern European architecture, international-standard service and a location in the heart of the coastal city of Vung Tau.\" right_image=\"https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00703.jpg\" background_color=\"#16192C\"][/why-choose-us]</shortcode><shortcode>[hotel-places limit=\"6\"][/hotel-places]</shortcode>', 'blocks', NULL),
('en_US', 6, 'Facilities &amp; Services', 'M Pool, M Spa, M Gym, the Kid Zone, the Gift Shop and more at Malibu.', '<shortcode>[service-list limit=\"12\"][/service-list]</shortcode><shortcode>[featured-amenities subtitle=\"In-room amenities\" title=\"Standard amenities in every room category\" description=\"Air conditioning, complimentary high-speed Wi-Fi, flat-screen TV, in-room safe, minibar, kettle with tea and coffee, and premium bathroom amenities.\"][/featured-amenities]</shortcode><shortcode>[newsletter subtitle=\"Newsletter\" title=\"Get the latest offers from Malibu\" description=\"Subscribe to stay up to date with our news and latest offers.\" background_color=\"#F7F5F1\"][/newsletter]</shortcode>', 'blocks', NULL),
('en_US', 7, 'Gallery', 'Photos of the hotel, rooms, restaurants, pool and entertainment areas.', '<shortcode>[galleries limit=\"12\"][/galleries]</shortcode>', 'blocks', NULL),
('en_US', 8, 'Hotel FAQs', 'Frequently asked questions about staying at The Malibu Hotel.', '<shortcode>[faqs category_ids=\"1,2,3,4,5\"][/faqs]</shortcode>', 'blocks', NULL),
('en_US', 9, 'Dine', 'Vela Restaurant, Carina Restaurant and The Lux Café.', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Dining &amp; Entertainment at The Malibu Hotel</h2><p>Enjoy a remarkable culinary experience at Malibu\'s restaurants. Discover Vela Restaurant and Carina Restaurant &amp; Entertainment, where refined flavours meet elegant surroundings for moments worth remembering.</p></div></div></div></div><shortcode>[feature-area subtitle=\"3rd floor\" title=\"Vela Restaurant\" description=\"A breakfast buffet of more than 40 Asian and European dishes, seating 350 guests, serving à la carte, buffet and gala. Breakfast buffet 6:30 – 10:00 am, banquet 11:00 am – 10:00 pm.\" image=\"https://malibuhotel.com.vn/files/blog/46_1815/Anh_1_4_1.jpg\" button_primary_label=\"DETAILS\" button_primary_url=\"/en/services/vela-restaurant\"][/feature-area]</shortcode><shortcode>[feature-area subtitle=\"6th floor\" title=\"Carina Restaurant\" description=\"European-Asian fusion cuisine with an extraordinary view, seating 60 guests plus a 20-seat VIP room. Open daily 11:00 am – 10:00 pm.\" image=\"https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg\" button_primary_label=\"DETAILS\" button_primary_url=\"/en/services/carina-restaurant\"][/feature-area]</shortcode><shortcode>[feature-area subtitle=\"Hotel lobby\" title=\"The Lux Café\" description=\"A café designed like a corner of a Milan street, with a piano in the lobby. Open daily 7:00 am – 10:00 pm.\" image=\"https://malibuhotel.com.vn/files/blog/46_1815/800x600_1__1.png\" button_primary_label=\"DETAILS\" button_primary_url=\"/en/services/the-lux-cafe\"][/feature-area]</shortcode>', 'blocks', NULL),
('en_US', 10, 'News', 'News, offers and events at The Malibu Hotel.', '<shortcode>[blog-posts paginate=\"12\"][/blog-posts]</shortcode>', 'blocks', NULL),
('en_US', 11, 'Contact', 'Address, hotline and email for The Malibu Hotel Vung Tau.', '<shortcode>[contact-form display_fields=\"phone,email,subject,address\" mandatory_fields=\"phone,email\" title=\"Send us a message\" button_label=\"Send\" address_icon=\"far fa-map\" address_label=\"Address\" address_detail=\"263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City, Ba Ria - Vung Tau Province, Vietnam\" email_icon=\"far fa-envelope-open\" email_label=\"Email\" email_detail=\"res@malibuhotel.com.vn\" phone_icon=\"far fa-phone\" phone_label=\"Hotline\" phone_detail=\"(+84) 941 871 644\"][/contact-form]</shortcode><div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>The Malibu Hotel</h2><p>Nguyen Ha Tourism Service Trading Co., Ltd<br>263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City, Ba Ria - Vung Tau Province, Vietnam</p><h2>Sales office in Ho Chi Minh City</h2><p>353 - 355 No.1 Street, Binh Tri Dong Ward, Binh Tan District, Ho Chi Minh City</p><h2>Contact</h2><p>Main hotel: (0254) 7305 779<br>Reservations hotline: (+84) 941 871 644<br>Reservations email: res@malibuhotel.com.vn<br>Website: www.malibuhotel.com.vn</p><h2>Email by department</h2><p>Room reservations: res@malibuhotel.com.vn<br>Director of Sales: dos@malibuhotel.com.vn<br>General information: info@malibuhotel.com.vn<br>Operation Manager: om@malibuhotel.com.vn<br>Front Desk Manager: fom@malibuhotel.com.vn<br>Housekeeping Manager: hskm@malibuhotel.com.vn</p></div></div></div></div>', 'blocks', NULL),
('en_US', 12, 'Privacy Policy', 'How The Malibu Hotel collects, uses and protects personal information.', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Privacy Policy</h2><p>The Malibu Hotel (Nguyen Ha Tourism Service Trading Co., Ltd) respects and is committed to protecting your personal information. This policy describes how we collect, use and safeguard your data when you use our website and services.</p><h2>Information we collect</h2><p>Name, phone number, email address, identity document details provided at check-in, reservation and payment information, and technical browser data when you visit our website.</p><h2>How we use it</h2><p>To process and confirm reservations, handle check-in and check-out, issue invoices, provide guest services, send offers where you have consented, and meet the residency-declaration obligations required by Vietnamese law.</p><h2>Sharing</h2><p>We do not sell or rent your personal information. Data is shared only with payment providers, booking partners and competent state authorities, and only to the extent necessary.</p><h2>Security and retention</h2><p>Data is stored on access-controlled systems and kept only as long as needed for the stated purposes or as required by law.</p><h2>Your rights</h2><p>You may request access to, correction of, or deletion of your personal data, and withdraw consent to marketing communications at any time by contacting info@malibuhotel.com.vn.</p><h2>Cookies</h2><p>Our website uses cookies to remember your preferences and improve your browsing experience. You may disable cookies in your browser settings.</p><h2>Contact</h2><p>For any question about this policy, please contact info@malibuhotel.com.vn or (0254) 7305 779.</p></div></div></div></div>', 'blocks', NULL),
('en_US', 13, 'Terms and Conditions', 'Booking, cancellation and house-rule terms.', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Terms and Conditions</h2><p>By making a reservation or using the services of The Malibu Hotel, you agree to the terms set out below.</p><h2>Reservations and payment</h2><p>A reservation is confirmed only once the hotel issues a confirmation. The hotel may request credit card details or a deposit to guarantee the booking. Rates are quoted in VND and exclude taxes and service charges unless otherwise stated.</p><h2>Check-in and check-out</h2><p>Check-in from 14:00 and check-out before 12:00. Early check-in and late check-out are subject to availability and may incur a surcharge.</p><h2>Cancellation and amendment</h2><p>Cancellation and amendment conditions depend on the rate booked and are stated in your confirmation. In the event of a no-show, the hotel may charge the equivalent of one night\'s stay.</p><h2>Identification and occupancy</h2><p>Please present a valid passport (international guests) or ID card (Vietnamese guests) at check-in. Occupancy must match the room type booked; surcharges apply for extra guests or children.</p><h2>House rules</h2><p>No smoking in guest rooms, no pets, and no flammables, weapons or strong-smelling food in the rooms. Guests are responsible for any damage caused to hotel property.</p><h2>Liability</h2><p>In-room safes and 24/7 security are provided. The hotel is not liable for valuables that are not deposited or kept in the in-room safe.</p><h2>Governing law</h2><p>These terms are governed by the laws of Vietnam.</p></div></div></div></div>', 'blocks', NULL),
('en_US', 18, 'Meetings &amp; Events', 'Seven conference rooms for up to 450 guests, plus wedding services.', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Meetings &amp; Events</h2><p>The Malibu Hotel has seven conference rooms for up to 450 guests. The Malibu Grand room can be separated into three smaller rooms of 120 guests each by a flexible partition system.</p><h2>Facilities</h2><p>International-standard sound systems, modern LED screens and projectors and high-class interiors are ready to meet every need. We also provide professional technical support and flexible equipment and catering packages.</p><h2>Weddings</h2><p>From an intimate wedding to a grand celebration, the Malibu team works with you on every detail: menu, decoration, sound and lighting, and the floor plan. Our flexible event spaces host from 50 to 450 guests.</p><h2>Contact</h2><p>Phone: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn</p></div></div></div></div>', 'blocks', NULL),
('en_US', 19, 'Malibu Group', 'Other hospitality products from Malibu Group.', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Malibu Group</h2><p>Alongside The Malibu Hotel Vung Tau, Malibu Group develops other hospitality products across south-east Vietnam.</p><h2>The Malibu House</h2><p>A compact, welcoming accommodation concept.</p><h2>The Malibu Hotel Sai Gon</h2><p>Malibu\'s hotel in Ho Chi Minh City.</p><h2>The Malibu Villa Long Cung</h2><p>A resort villa in the Long Cung area of Vung Tau.</p><h2>Sanctuary Villa Ho Tram</h2><p>A beachfront resort villa in Ho Tram.</p></div></div></div></div>', 'blocks', NULL),
('en_US', 22, 'Careers', 'Career opportunities at The Malibu Hotel Vung Tau.', '<div class=\"about-area5 about-p p-relative\"><div class=\"container pt-60 pb-90\"><div class=\"service-detail\"><div class=\"content-box\"><h2>Careers at The Malibu Hotel</h2><p>Malibu\'s core value is a dedicated team supported by a professional management system. We are always looking for colleagues who share the \"Live Beautifully\" spirit across front office, housekeeping, food and beverage, kitchen, engineering, sales and spa.</p><h2>How to apply</h2><p>Please send your application to tuyendung@malibuhotel.com.vn or call (0254) 3 523 523.</p></div></div></div></div>', 'blocks', NULL);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `is_pinned` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `format_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `name`, `description`, `content`, `status`, `author_id`, `author_type`, `is_featured`, `is_pinned`, `image`, `views`, `format_type`, `created_at`, `updated_at`) VALUES
(1, 'M Pool – Hồ bơi ngoài trời', 'Hồ bơi ngoài trời tầng 6 với tầm nhìn toàn cảnh thành phố Vũng Tàu, quầy bar phục vụ tại hồ và hệ thống điện phân muối tự nhiên.', '<div class=\"service-detail\"><p>M Pool là ốc đảo giữa lòng thành phố biển. Bơi một vòng trong làn nước trong xanh, nhâm nhi ly vang và ngắm Vũng Tàu trải dài dưới nắng chiều – mỗi trải nghiệm tại Malibu là một mảnh ghép của cảm xúc.</p><h3>Thông tin hồ bơi</h3><p>Sức chứa: 30 khách mỗi lượt. Hệ thống điện phân từ muối tự nhiên để khử khuẩn. Hồ người lớn 195 m², độ sâu 1,4 m. Hồ trẻ em 105 m², độ sâu 0,9 m.</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 07:00 – 19:00</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 1, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/M-POOL-MALIBU-HOTEL_1__1.jpg', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'M Spa – Chăm sóc và trị liệu', 'Không gian trị liệu yên tĩnh với đội ngũ kỹ thuật viên lành nghề, sử dụng thảo dược tự nhiên và y học cổ truyền.', '<div class=\"service-detail\"><p>Sau những hoạt động khám phá thành phố biển, M Spa giúp bạn tái tạo năng lượng cho một tuần mới. Đội ngũ kỹ thuật viên lành nghề, tận tâm sử dụng y học cổ truyền và thảo dược quý từ thiên nhiên để mỗi phút giây tại đây đều đáng giá.</p><p>Chỉ cần thả mình vào không gian tĩnh lặng, cảm nhận tuần hoàn trong từng mạch máu, thư giãn và hồi phục trọn vẹn trong khoảng 2 giờ.</p><h3>Dịch vụ</h3><p>Xông hơi khô, xông hơi ướt, gội đầu dưỡng sinh và massage trị liệu.</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 10:00 – 20:00</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 1, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/M-SPA-MALIBU_HOTEL_1.jpg', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'M Gym – Phòng tập thể hình', 'Phòng gym 100 m² tại khu dịch vụ tầng 6 với trang thiết bị hiện đại chuẩn phòng tập chuyên nghiệp.', '<div class=\"service-detail\"><p>Dành cho những ai duy trì thói quen luyện tập, Malibu bố trí phòng gym cao cấp tại khu dịch vụ giải trí tầng 6, trang thiết bị hiện đại đáp ứng mọi nhu cầu như các phòng tập chuyên nghiệp.</p><h3>Thông tin</h3><p>Diện tích phòng tập: 100 m².</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 06:00 – 22:00</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 0, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/Asset_23@4x_1.png', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'Vela Restaurant – Buffet sáng', 'Nhà hàng tầng 3 sức chứa 350 khách, buffet sáng hơn 40 món Á – Âu, phục vụ à la carte, buffet và tiệc Gala.', '<div class=\"service-detail\"><p>Một sáng thức dậy tại Malibu, nghe bản nhạc du dương, nhấp ngụm cà phê và dùng bữa sáng tại nhà hàng Vela tầng 3 với hơn 40 món buffet từ Á sang Âu, trước khi bắt đầu ngày mới đầy hứng khởi cho chuyến công tác hay một ngày rong chơi ở thành phố biển.</p><p>Đội ngũ ẩm thực của khách sạn chăm chút từng món ăn, từ khâu chọn nguyên liệu tươi ngon đến chế biến – cho một bữa sáng tràn năng lượng, một bữa trưa nhẹ nhàng, hay những món đặc biệt cho đêm Gala ấn tượng.</p><p>Nhà hàng được thiết kế rộng rãi, hiện đại, trải thảm cao cấp, sức chứa lên đến 350 khách, phục vụ à la carte, buffet và tiệc Gala.</p><h3>Giờ phục vụ</h3><p>Buffet sáng: 06:30 – 10:00 &nbsp;|&nbsp; Tiệc: 11:00 – 22:00</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 1, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/Anh_1_4_1.jpg', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'Carina Restaurant – Ẩm thực Á Âu', 'Nhà hàng tầng 6 với tầm nhìn đặc biệt, sức chứa 60 khách và phòng VIP 20 khách, ẩm thực giao thoa Âu – Á.', '<div class=\"service-detail\"><p>Toạ lạc tại tầng 6 của khách sạn Malibu với tầm nhìn đặc biệt, Carina Restaurant mang thiết kế hiện đại cùng âm nhạc thư thái, đem đến cho thực khách trải nghiệm ẩm thực đẳng cấp.</p><p>Nhà hàng có sức chứa khoảng 60 khách, cùng một phòng VIP dành riêng cho 20 khách – lý tưởng cho những buổi tiệc riêng tư, thanh lịch và các sự kiện đặc biệt. Đây cũng là lựa chọn đẹp cho những buổi hẹn hò lãng mạn.</p><p>Thực đơn lấy cảm hứng từ sự giao thoa giữa ẩm thực châu Âu và châu Á, tuyển chọn từ nguyên liệu thượng hạng, cùng tâm huyết của những đầu bếp tài hoa, công thức riêng và sự tỉ mỉ trong phục vụ.</p><h3>Giờ phục vụ</h3><p>Hằng ngày: 11:00 – 22:00</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 1, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/CARINA-MALIBU_HOTEL_1.jpg', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'The Lux Café – Cà phê &amp; trà', 'Quán cà phê tại sảnh khách sạn, thiết kế như một góc phố Milan, có cả cây đàn piano cho những phút ngẫu hứng.', '<div class=\"service-detail\"><p>Trước khi trở lại với công việc, hãy ghé The Lux Café ở sảnh khách sạn để thưởng thức một ly kem trong lúc làm thủ tục trả phòng.</p><p>Được thiết kế như một góc phố Milan tráng lệ mà không kém phần thời thượng, The Lux Café khiến bạn như đang đắm mình trong hơi thở của kinh đô thời trang.</p><p>Và nếu có thể, hãy để lại một bản concerto cho Malibu và những vị khách khác bên cây đàn piano nơi sảnh.</p><h3>Giờ phục vụ</h3><p>Hằng ngày: 07:00 – 22:00</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 0, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/800x600_1__1.png', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 'Conference – Hội nghị &amp; hội thảo', '7 phòng hội nghị sức chứa tới 450 khách, phòng Malibu Grand chia được thành 3 phòng nhỏ 120 khách mỗi phòng.', '<div class=\"service-detail\"><p>The Malibu Hotel có 7 phòng hội nghị với sức chứa lên đến 450 khách. Phòng Malibu Grand có thể ngăn thành 3 phòng nhỏ, mỗi phòng 120 khách, bằng hệ thống vách ngăn linh hoạt.</p><p>Hệ thống âm thanh chuẩn quốc tế, màn hình LED và máy chiếu hiện đại, nội thất cao cấp – sẵn sàng đáp ứng mọi nhu cầu của quý khách.</p><p>Chúng tôi cung cấp dịch vụ hỗ trợ kỹ thuật chuyên nghiệp cùng các gói thiết bị và tiệc linh hoạt, bảo đảm mỗi sự kiện diễn ra suôn sẻ và thành công.</p><h3>Liên hệ</h3><p>Điện thoại: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 0, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/Asset_51@4x_1.png', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 'Kid Zone – Khu vui chơi trẻ em', 'Khu vui chơi an toàn, rộng rãi với trò chơi giáo dục và nhân viên trông coi tận tình.', '<div class=\"service-detail\"><p>Kid Zone là nơi lý tưởng để các bé thư giãn và vui chơi an toàn, sáng tạo trong lúc bố mẹ nghỉ ngơi tại khách sạn.</p><p>Khu vui chơi được thiết kế riêng với nhiều trò chơi và hoạt động đa dạng, từ trò chơi vận động đến trò chơi giáo dục, để các bé vừa vui vừa học. Đội ngũ nhân viên chuyên nghiệp, chu đáo luôn có mặt để trông coi và hỗ trợ các bé.</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 09:00 – 17:00</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 0, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/KID-ZONE-MALIBU_-_HOTEL_1.jpg', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 'Entertainment – Khu giải trí', 'Khu giải trí tầng 6 với hệ thống golf 3D mô phỏng nhiều sân tập khác nhau.', '<div class=\"service-detail\"><p>Chơi golf không chỉ thoả niềm đam mê mà còn giúp bạn nâng trình nhanh chóng và mang lại những phút giây thư giãn tuyệt vời sau một ngày làm việc căng thẳng.</p><p>Golf 3D là hệ thống mô phỏng và tái hiện khung cảnh cùng các hoạt động giống như golf thật. Điểm đặc biệt là với golf 3D, người chơi có thể chọn nhiều loại sân tập khác nhau để cải thiện sự linh hoạt của mình.</p><h3>Giờ mở cửa</h3><p>Vui lòng liên hệ lễ tân để biết giờ hoạt động mới nhất.</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 0, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/ENTERTAINMENT.jpg', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 'Billiard &amp; Foosball', 'Bàn billiard và bàn bi lắc tại khu giải trí tầng 6, dành cho những buổi tối thư giãn cùng bạn bè và gia đình.', '<div class=\"service-detail\"><p>Khu Billiard &amp; Foosball nằm trong tổ hợp giải trí tầng 6 của The Malibu Hotel – nơi bạn có thể cùng bạn bè, đồng nghiệp hay gia đình có những giờ phút thư giãn sau một ngày dài.</p><p>Bàn billiard tiêu chuẩn và bàn bi lắc được bảo dưỡng thường xuyên, không gian thoáng đãng ngay cạnh hồ bơi M Pool và phòng tập M Gym.</p><h3>Giờ mở cửa</h3><p>Hằng ngày: 07:00 – 22:00</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 0, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/_THP4305-HDR_1.jpg', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 'Private Laundry – Giặt ủi khép kín', 'Xưởng giặt khép kín của riêng khách sạn, không sử dụng dịch vụ bên thứ ba, hoạt động 24/24.', '<div class=\"service-detail\"><p>Xưởng giặt của The Malibu Hotel vận hành theo chu trình khép kín hoàn toàn, không sử dụng dịch vụ của bất kỳ bên thứ ba nào.</p><p>Nhờ vậy, toàn bộ khăn, ga, gối và đồ vải phục vụ khách đều được phân loại, giặt, tiệt trùng và hấp kỹ lưỡng, giữ hương thơm tự nhiên dễ chịu và tuyệt đối an toàn – bảo đảm tiêu chuẩn vệ sinh và sự thoải mái cho khách.</p><h3>Giờ phục vụ</h3><p>24/24 mỗi ngày</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 0, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/Hotel-Laundry-Services-101-Is-It-Worth-It-04012022-735x491.jpg.webp', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 'Gift Shop – Cửa hàng quà tặng', 'Cửa hàng quà tặng và đồ lưu niệm mở cửa 24/24 ngay trong khách sạn.', '<div class=\"service-detail\"><p>Gift Shop của khách sạn là không gian mua sắm độc đáo và đa dạng, nơi bạn có thể tìm thấy món quà phù hợp cho gia đình, bạn bè – hoặc cho chính mình.</p><p>Từ trang sức tinh xảo đến đồ thủ công mỹ nghệ và quà lưu niệm đặc trưng, chúng tôi mang đến trải nghiệm mua sắm đáng nhớ, trọn vẹn cho hành trình của bạn.</p><p>Đội ngũ nhân viên luôn sẵn sàng tư vấn để bạn chọn được sản phẩm ưng ý nhất.</p><h3>Giờ mở cửa</h3><p>24/24 mỗi ngày</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 0, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/DSC00288_1.jpg', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, 'Gourmet Stay Package – Nghỉ dưỡng kết hợp ẩm thực', 'Từ 2.330.000++ VND/phòng: 01 đêm tại Premier Room, buffet sáng mỗi ngày, 01 bữa trưa hoặc tối theo thực đơn chọn lọc, ưu đãi giặt ủi và M Spa.', '<div class=\"service-detail\"><p>Giữa nhịp sống bận rộn, đôi khi điều chúng ta cần không phải là một chuyến đi dài, mà là một khoảng dừng đủ chất lượng – nơi mọi trải nghiệm đã được chuẩn bị sẵn để bạn chỉ việc tận hưởng.</p><p>The Malibu Hotel giới thiệu <strong>Gourmet Stay Package</strong> – một chương trình nghỉ dưỡng kết hợp ẩm thực, được thiết kế dành cho những ai trân trọng sự tinh tế, tiện nghi và cảm giác trọn vẹn trong từng khoảnh khắc lưu trú.</p><h3>Từ 2.330.000++ VND/phòng, quý khách sẽ trải nghiệm</h3><p>01 đêm nghỉ tại Premier Room sang trọng<br>Buffet sáng mỗi ngày tại nhà hàng<br>01 bữa ăn trưa hoặc tối theo thực đơn chọn lọc<br>Ưu đãi 15% dịch vụ giặt ủi<br>Ưu đãi 20% liệu trình M Spa</p><h3>Gói Fullboard – 2.859.000++ VND/phòng</h3><p>Bao gồm 02 bữa ăn (trưa và tối), mang đến hành trình ẩm thực phong phú hơn.</p><p>Gourmet Stay Package là lựa chọn lý tưởng cho kỳ nghỉ cuối tuần, staycation hay chuyến đi tái tạo năng lượng ngắn ngày.</p><h3>Đặt gói</h3><p>Hotline: 0941 871 644 &nbsp;|&nbsp; Email: res@malibuhotel.com.vn</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 1, 1, 'https://malibuhotel.com.vn/files/blog/46_1815/free_updrage.png', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(14, 'Long Stay – Ưu đãi lưu trú dài ngày', 'Từ 1.050.000 VNĐ++: phòng tiêu chuẩn kèm buffet sáng hơn 40 món, giảm 20% giặt ủi và nhà hàng, voucher F&amp;B 1.000.000 VNĐ.', '<div class=\"service-detail\"><h3>The Malibu Hotel – Điểm đến cho những chuyến công tác đầy phong cách</h3><p>Bắt nhịp cùng xu hướng \"workcation\" với vị trí lý tưởng ngay trung tâm thành phố Vũng Tàu, The Malibu Hotel mang đến cho bạn một chuyến công tác đầy phong cách với nhiều trải nghiệm thú vị trong từng khoảnh khắc.</p><h3>Ưu đãi Long Stay từ 1.050.000 VNĐ++</h3><p>Phòng tiêu chuẩn kèm buffet sáng hơn 40 món<br>Giảm 20% dịch vụ giặt ủi và dịch vụ nhà hàng<br>Voucher F&amp;B trị giá 1.000.000 VNĐ<br>Trà, cà phê và nước suối miễn phí mỗi ngày</p><p>Đừng ngần ngại đặt phòng tại The Malibu Hotel – lựa chọn hoàn hảo cho chuyến công tác của bạn.</p><h3>Đặt phòng</h3><p>Hotline: 0941 871 644 &nbsp;|&nbsp; Tổng đài: (0254) 7305 779<br>263 Lê Hồng Phong, P. Thắng Tam, TP. Vũng Tàu</p></div>', 'published', 1, 'Botble\\ACL\\Models\\User', 1, 0, 'https://malibuhotel.com.vn/files/blog/46_1815/LONG_STAY_HOTEL_2024_vuong-02.png', 0, NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts_translations`
--

DROP TABLE IF EXISTS `posts_translations`;
CREATE TABLE `posts_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posts_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `posts_translations`
--

INSERT INTO `posts_translations` (`lang_code`, `posts_id`, `name`, `description`, `content`, `image`) VALUES
('en_US', 1, 'M Pool – Outdoor Pool', 'A rooftop outdoor pool on the 6th floor with panoramic views over Vung Tau, a full-service lounge bar and a natural-salt electrolysis system.', '<div class=\"service-detail\"><p>A true oasis in the heart of Vung Tau, M Pool offers breath-taking panoramic views of the city, beautiful modern design and a full-service lounge bar. Take a refreshing swim, then enjoy a glass of wine as you overlook the coastal city and bask in the afternoon sun.</p><h3>Pool information</h3><p>Capacity: 30 guests per session. Electrolyte system using natural salt to disinfect the water. Adults\' pool 195 sqm, 1.4 m deep. Children\'s pool 105 sqm, 0.9 m deep.</p><h3>Hours</h3><p>Everyday: 7:00 am – 7:00 pm</p></div>', NULL),
('en_US', 2, 'M Spa – Health Care &amp; Treatment', 'A quiet treatment space with skilled therapists using natural herbs and traditional medicine.', '<div class=\"service-detail\"><p>After discovery activities around the coastal city, M Spa helps you renew your energy for the week ahead. Our team of skilled and dedicated therapists uses traditional medicine and precious herbs from nature to make every moment here worthwhile.</p><p>Simply settle into the quiet, feel the circulation in your blood, relax and regenerate completely over about two hours.</p><h3>Services</h3><p>Sauna, steam bath, hair washing and therapeutic massage.</p><h3>Hours</h3><p>Everyday: 10:00 am – 8:00 pm</p></div>', NULL),
('en_US', 3, 'M Gym – Fitness Centre', 'A 100 sqm gym in the 6th-floor service area with modern equipment matching professional fitness centres.', '<div class=\"service-detail\"><p>For those who keep up an exercise routine, Malibu offers a high-class gym in the entertainment service area on the 6th floor, with modern equipment to meet all your needs just like professional gyms.</p><h3>Information</h3><p>Gym area: 100 sqm.</p><h3>Hours</h3><p>Everyday: 6:00 am – 10:00 pm</p></div>', NULL),
('en_US', 4, 'Vela Restaurant – Breakfast Buffet', 'A 3rd-floor restaurant seating 350 guests, with a breakfast buffet of more than 40 Asian and European dishes, à la carte, buffet and gala service.', '<div class=\"service-detail\"><p>One morning waking up at Malibu, listening to melodious music, sipping a cup of coffee and having breakfast at Vela Restaurant on the 3rd floor with more than 40 buffet dishes from Asia to Europe, before starting a new day of enthusiasm for a business trip or a fun day out in the beautiful coastal city.</p><p>Our culinary team, knowledgeable in the quintessence of cuisine, takes care of every dish from choosing fresh ingredients to cooking – for an energetic breakfast, a light lunch, or even special dishes for an impressive gala night.</p><p>The restaurant is designed in a spacious modern style with high-quality carpet. It accommodates up to 350 guests and serves à la carte, buffet and gala.</p><h3>Hours of operation</h3><p>Breakfast buffet: 6:30 am – 10:00 am &nbsp;|&nbsp; Banquet: 11:00 am – 10:00 pm</p></div>', NULL),
('en_US', 5, 'Carina Restaurant – Fusion Cuisine', 'A 6th-floor restaurant with an extraordinary view, seating 60 guests plus a 20-seat VIP room, serving European-Asian fusion cuisine.', '<div class=\"service-detail\"><p>Located on the 6th floor of the Malibu Hotel with an extraordinary view, the restaurant features modern design and chilling music, providing guests with a classy dining experience.</p><p>The restaurant has a capacity of around 60 guests, with a VIP room reserved for 20 guests. It is ideal for private and elegant celebrations and special events, and a good choice for romantic dates.</p><p>The menu is inspired by fusion cuisine between European and Asian dishes, selected from the best ingredients, along with the enthusiasm of talented chefs, unique recipes and meticulous attention to detail in serving.</p><h3>Hours of operation</h3><p>Everyday: 11:00 am – 10:00 pm</p></div>', NULL),
('en_US', 6, 'The Lux Café – Coffee &amp; Tea', 'A café in the hotel lobby designed like a corner of a Milan street, complete with a piano for spontaneous moments.', '<div class=\"service-detail\"><p>Before we take you back to work, please pass by The Lux Café in the hotel lobby to enjoy a glass of ice cream while checking out.</p><p>Designed like a magnificent corner of a Milan street but no less fashionable, The Lux Café will make you feel like you are immersing yourself in the breath of the fashion world capital.</p><p>And if possible, leave a concerto for Malibu and other guests with the piano in the lobby.</p><h3>Hours of operation</h3><p>Everyday: 7:00 am – 10:00 pm</p></div>', NULL),
('en_US', 7, 'Conference – Meetings &amp; Seminars', 'Seven conference rooms for up to 450 guests; the Malibu Grand room can be divided into three rooms of 120 guests each.', '<div class=\"service-detail\"><p>The Malibu Hotel has 7 conference rooms for up to 450 guests. The Malibu Grand room can be separated into 3 smaller rooms with a capacity of 120 guests each by a flexible partition system.</p><p>With an international-standard sound system, modern LED screens and projectors and high-class interiors, we are ready to meet the needs of all our guests.</p><p>We also offer professional technical support and flexible equipment and catering packages, ensuring each of your events runs smoothly and successfully.</p><h3>Contact</h3><p>Phone: (0254) 7305 779 &nbsp;|&nbsp; Email: dos@malibuhotel.com.vn</p></div>', NULL),
('en_US', 8, 'Kid Zone – Children\'s Playground', 'A safe, spacious play area with educational games and attentive staff.', '<div class=\"service-detail\"><p>Our Kid Zone is the perfect place for children to relax and enjoy safe and creative playtime while you unwind at the hotel.</p><p>It is specially designed with a variety of games and activities, ranging from active games to educational ones, ensuring children have both fun and enriching experiences. Our professional and attentive staff are always available to supervise and assist.</p><h3>Hours</h3><p>Everyday: 9:00 am – 5:00 pm</p></div>', NULL),
('en_US', 9, 'Entertainment', 'A 6th-floor entertainment area with a 3D golf system simulating a range of practice courses.', '<div class=\"service-detail\"><p>Practising golf not only satisfies golfers\' passion for the game, it also helps you improve quickly and brings wonderful moments of relaxation after a stressful day of work.</p><p>3D Golf is a system that simulates and recreates scenes and activities similar to real golf. A special feature is that with 3D golf, golfers can choose different types of practice courses to improve their flexibility.</p><h3>Hours</h3><p>Please contact the front desk for the most current hours of operation.</p></div>', NULL),
('en_US', 10, 'Billiard &amp; Foosball', 'Billiard and foosball tables in the 6th-floor entertainment area, for relaxed evenings with friends and family.', '<div class=\"service-detail\"><p>The Billiard &amp; Foosball area sits within the 6th-floor entertainment complex of The Malibu Hotel – a place to unwind with friends, colleagues or family after a long day.</p><p>Standard billiard tables and foosball tables are regularly maintained, in an airy space right beside the M Pool and M Gym.</p><h3>Hours</h3><p>Everyday: 7:00 am – 10:00 pm</p></div>', NULL),
('en_US', 11, 'Private Laundry', 'A fully in-house, closed-cycle laundry that uses no third-party services, open 24/7.', '<div class=\"service-detail\"><p>The Malibu Hotel laundry runs on a completely closed and unique cycle, without using the services of any third party.</p><p>As a result, all the fabrics used to serve guests are classified, washed, pasteurised and steamed very thoroughly, with a comfortable natural scent that is absolutely safe – ensuring the criteria of health and comfort for our guests.</p><h3>Hours</h3><p>24/7</p></div>', NULL),
('en_US', 12, 'Gift Shop', 'A gift and souvenir shop inside the hotel, open 24/7.', '<div class=\"service-detail\"><p>Our gift shop is a unique and diverse shopping space where you can find the perfect gift for family, friends, or even yourself.</p><p>With a wide range of high-quality products, from elegant jewellery to unique handcrafted items and special souvenirs, we are committed to providing you with a memorable shopping experience that complements your travel journey.</p><p>Our staff are always available to help you choose the most suitable products.</p><h3>Hours</h3><p>Everyday: 24/7</p></div>', NULL),
('en_US', 13, 'Gourmet Stay Package', 'From 2,330,000++ VND/room: one night in a Premier Room, daily breakfast buffet, one set lunch or dinner, plus laundry and M Spa discounts.', '<div class=\"service-detail\"><p>Amid the pace of modern life, true indulgence lies in a well-considered pause – where every element is carefully arranged, allowing guests to relax and enjoy without distraction.</p><p>The Malibu Hotel proudly presents the <strong>Gourmet Stay Package</strong>, a stay-and-dine experience curated for guests who value refinement, comfort and meaningful moments throughout their stay.</p><h3>From 2,330,000++ VND/room, the package includes</h3><p>One night in a refined Premier Room<br>Daily breakfast buffet at the restaurant<br>One set lunch or dinner<br>15% off laundry service<br>20% off M Spa treatments</p><h3>Fullboard package – 2,859,000++ VND/room</h3><p>Includes two meals (lunch and dinner) for a richer culinary journey.</p><p>The Gourmet Stay Package is an ideal choice for a weekend break, a staycation or a short restorative trip.</p><h3>Reservations</h3><p>Hotline: (+84) 941 871 644 &nbsp;|&nbsp; Email: res@malibuhotel.com.vn</p></div>', NULL),
('en_US', 14, 'Long Stay Offers', 'From 1,050,000 VND++: a standard room with a 40-dish breakfast buffet, 20% off laundry and dining, plus a 1,000,000 VND F&amp;B voucher.', '<div class=\"service-detail\"><h3>The Malibu Hotel – the stylish business trip destination</h3><p>In tune with the trend of \"workcation\", and with an ideal location in Vung Tau city, The Malibu Hotel brings you a stylish business trip with many exciting experiences at every moment.</p><h3>Long Stay offer from 1,050,000 VND++</h3><p>Standard room with a breakfast buffet of over 40 dishes<br>20% discount on laundry and restaurant services<br>F&amp;B gift voucher worth 1,000,000 VND<br>Daily complimentary tea, coffee and mineral water</p><p>Do not hesitate to book at The Malibu Hotel, which promises to be the perfect choice for your business trip.</p><h3>Reservations</h3><p>Hotline: (+84) 941 871 644 &nbsp;|&nbsp; Main hotel: (0254) 7305 779<br>263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City</p></div>', NULL);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
CREATE TABLE `post_categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `post_categories`
--

INSERT INTO `post_categories` (`category_id`, `post_id`) VALUES
(2, 1),
(2, 2),
(2, 3),
(3, 4),
(3, 5),
(3, 6),
(4, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(1, 13),
(1, 14);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_tags`
--

DROP TABLE IF EXISTS `post_tags`;
CREATE TABLE `post_tags` (
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `post_tags` (`tag_id`, `post_id`) VALUES
(1, 1),
(2, 1),
(5, 1),
(1, 2),
(5, 2),
(1, 3),
(5, 3),
(1, 4),
(4, 4),
(1, 5),
(4, 5),
(1, 6),
(4, 6),
(1, 7),
(2, 7),
(1, 8),
(5, 8),
(1, 9),
(5, 9),
(1, 10),
(5, 10),
(1, 11),
(1, 12),
(2, 12),
(1, 13),
(3, 13),
(4, 13),
(5, 13),
(1, 14),
(2, 14),
(3, 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `revisions`
--

DROP TABLE IF EXISTS `revisions`;
CREATE TABLE `revisions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `revisionable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisionable_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `key` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `revisions`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `description`, `is_default`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', '{\"users.index\":true,\"users.create\":true,\"users.edit\":true,\"users.destroy\":true,\"roles.index\":true,\"roles.create\":true,\"roles.edit\":true,\"roles.destroy\":true,\"core.system\":true,\"core.cms\":true,\"core.manage.license\":true,\"systems.cronjob\":true,\"core.tools\":true,\"tools.data-synchronize\":true,\"media.index\":true,\"files.index\":true,\"files.create\":true,\"files.edit\":true,\"files.trash\":true,\"files.destroy\":true,\"folders.index\":true,\"folders.create\":true,\"folders.edit\":true,\"folders.trash\":true,\"folders.destroy\":true,\"settings.index\":true,\"settings.common\":true,\"settings.options\":true,\"settings.email\":true,\"settings.media\":true,\"settings.admin-appearance\":true,\"settings.cache\":true,\"settings.datatables\":true,\"settings.email.rules\":true,\"settings.others\":true,\"menus.index\":true,\"menus.create\":true,\"menus.edit\":true,\"menus.destroy\":true,\"optimize.settings\":true,\"pages.index\":true,\"pages.create\":true,\"pages.edit\":true,\"pages.destroy\":true,\"plugins.index\":true,\"plugins.edit\":true,\"plugins.remove\":true,\"plugins.marketplace\":true,\"sitemap.settings\":true,\"core.appearance\":true,\"theme.index\":true,\"theme.activate\":true,\"theme.remove\":true,\"theme.options\":true,\"theme.custom-css\":true,\"theme.custom-js\":true,\"theme.custom-html\":true,\"theme.robots-txt\":true,\"settings.website-tracking\":true,\"widgets.index\":true,\"analytics.general\":true,\"analytics.page\":true,\"analytics.browser\":true,\"analytics.referrer\":true,\"analytics.settings\":true,\"audit-log.index\":true,\"audit-log.destroy\":true,\"backups.index\":true,\"backups.create\":true,\"backups.restore\":true,\"backups.destroy\":true,\"plugins.blog\":true,\"posts.index\":true,\"posts.create\":true,\"posts.edit\":true,\"posts.destroy\":true,\"categories.index\":true,\"categories.create\":true,\"categories.edit\":true,\"categories.destroy\":true,\"tags.index\":true,\"tags.create\":true,\"tags.edit\":true,\"tags.destroy\":true,\"blog.settings\":true,\"posts.export\":true,\"posts.import\":true,\"captcha.settings\":true,\"contacts.index\":true,\"contacts.edit\":true,\"contacts.destroy\":true,\"contact.custom-fields\":true,\"contact.settings\":true,\"plugin.faq\":true,\"faq.index\":true,\"faq.create\":true,\"faq.edit\":true,\"faq.destroy\":true,\"faq_category.index\":true,\"faq_category.create\":true,\"faq_category.edit\":true,\"faq_category.destroy\":true,\"faqs.settings\":true,\"galleries.index\":true,\"galleries.create\":true,\"galleries.edit\":true,\"galleries.destroy\":true,\"room.index\":true,\"room.create\":true,\"room.edit\":true,\"room.destroy\":true,\"amenity.index\":true,\"amenity.create\":true,\"amenity.edit\":true,\"amenity.destroy\":true,\"food.index\":true,\"food.create\":true,\"food.edit\":true,\"food.destroy\":true,\"food-type.index\":true,\"food-type.create\":true,\"food-type.edit\":true,\"food-type.destroy\":true,\"booking.index\":true,\"booking.edit\":true,\"booking.destroy\":true,\"invoices.index\":true,\"invoices.edit\":true,\"invoices.destroy\":true,\"booking.reports.index\":true,\"booking.calendar.index\":true,\"booking-address.index\":true,\"booking-address.create\":true,\"booking-address.edit\":true,\"booking-address.destroy\":true,\"booking-room.index\":true,\"booking-room.create\":true,\"booking-room.edit\":true,\"booking-room.destroy\":true,\"customer.index\":true,\"customer.create\":true,\"customer.edit\":true,\"customer.destroy\":true,\"room-category.index\":true,\"room-category.create\":true,\"room-category.edit\":true,\"room-category.destroy\":true,\"feature.index\":true,\"feature.create\":true,\"feature.edit\":true,\"feature.destroy\":true,\"service.index\":true,\"service.create\":true,\"service.edit\":true,\"service.destroy\":true,\"place.index\":true,\"place.create\":true,\"place.edit\":true,\"place.destroy\":true,\"tax.index\":true,\"tax.create\":true,\"tax.edit\":true,\"tax.destroy\":true,\"invoice.template\":true,\"coupons.index\":true,\"coupons.create\":true,\"coupons.edit\":true,\"coupons.destroy\":true,\"hotel.settings\":true,\"languages.index\":true,\"languages.create\":true,\"languages.edit\":true,\"languages.destroy\":true,\"translations.import\":true,\"translations.export\":true,\"property-translations.import\":true,\"property-translations.export\":true,\"newsletter.index\":true,\"newsletter.destroy\":true,\"newsletter.settings\":true,\"payment.index\":true,\"payments.settings\":true,\"payment.destroy\":true,\"payments.logs\":true,\"payments.logs.show\":true,\"payments.logs.destroy\":true,\"simple-slider.index\":true,\"simple-slider.create\":true,\"simple-slider.edit\":true,\"simple-slider.destroy\":true,\"simple-slider-item.index\":true,\"simple-slider-item.create\":true,\"simple-slider-item.edit\":true,\"simple-slider-item.destroy\":true,\"simple-slider.settings\":true,\"social-login.settings\":true,\"team.index\":true,\"team.create\":true,\"team.edit\":true,\"team.destroy\":true,\"testimonial.index\":true,\"testimonial.create\":true,\"testimonial.edit\":true,\"testimonial.destroy\":true,\"plugins.translation\":true,\"translations.locales\":true,\"translations.theme-translations\":true,\"translations.index\":true,\"theme-translations.export\":true,\"other-translations.export\":true,\"theme-translations.import\":true,\"other-translations.import\":true,\"api.settings\":true,\"api.sanctum-token.index\":true,\"api.sanctum-token.create\":true,\"api.sanctum-token.destroy\":true,\"ai-translator.index\":true,\"ai-translator.settings\":true,\"ai-translator.training\":true}', 'Admin users role', 1, 1, 1, '2025-06-10 10:38:16', '2026-03-28 07:13:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_users`
--

DROP TABLE IF EXISTS `role_users`;
CREATE TABLE `role_users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role_users`
--

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'media_random_hash', '340aedc5d1f1cac4ae4d1f885dea7635', NULL, '2026-09-04 08:00:00'),
(2, 'api_enabled', '0', NULL, '2026-09-04 08:00:00'),
(3, 'analytics_dashboard_widgets', '1', NULL, '2026-09-04 08:00:00'),
(4, 'activated_plugins', '[\"language\",\"language-advanced\",\"analytics\",\"audit-log\",\"backup\",\"blog\",\"captcha\",\"contact\",\"cookie-consent\",\"faq\",\"gallery\",\"hotel\",\"newsletter\",\"razorpay\",\"simple-slider\",\"social-login\",\"testimonial\",\"translation\",\"botble-popup-chat-icon\",\"product\",\"ai-translator\",\"notification-plus\"]', NULL, '2026-09-04 08:00:00'),
(5, 'enable_recaptcha_botble_contact_forms_fronts_contact_form', '1', NULL, '2026-09-04 08:00:00'),
(6, 'enable_recaptcha_botble_newsletter_forms_fronts_newsletter_form', '1', NULL, '2026-09-04 08:00:00'),
(9, 'theme', 'riorelax', NULL, '2026-09-04 08:00:00'),
(10, 'show_admin_bar', '1', NULL, '2026-09-04 08:00:00'),
(11, 'language_hide_default', '1', NULL, '2026-09-04 08:00:00'),
(13, 'language_display', 'all', NULL, '2026-09-04 08:00:00'),
(14, 'language_hide_languages', '[]', NULL, '2026-09-04 08:00:00'),
(15, 'language_switcher_display', 'dropdown', NULL, '2026-09-04 08:00:00'),
(16, 'admin_logo', '', NULL, '2026-09-04 08:00:00'),
(17, 'admin_favicon', '', NULL, '2026-09-04 08:00:00'),
(18, 'permalink-botble-blog-models-post', 'news', NULL, '2026-09-04 08:00:00'),
(19, 'permalink-botble-blog-models-category', 'news', NULL, '2026-09-04 08:00:00'),
(24, 'payment_stripe_payment_type', 'stripe_checkout', NULL, '2026-09-04 08:00:00'),
(25, 'hotel_company_logo_for_invoicing', '', NULL, '2026-09-04 08:00:00'),
(26, 'hotel_company_address_for_invoicing', '263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City, Ba Ria - Vung Tau Province, Vietnam', NULL, '2026-09-04 08:00:00'),
(27, 'hotel_company_email_for_invoicing', 'res@malibuhotel.com.vn', NULL, '2026-09-04 08:00:00'),
(28, 'hotel_company_phone_for_invoicing', '(0254) 7305 779', NULL, '2026-09-04 08:00:00'),
(29, 'hotel_enable_review_room', '1', NULL, '2026-09-04 08:00:00'),
(30, 'hotel_reviews_per_page', '10', NULL, '2026-09-04 08:00:00'),
(31, 'theme-riorelax-site_title', 'The Malibu Hotel Vũng Tàu', NULL, '2026-09-04 08:00:00'),
(32, 'theme-riorelax-copyright', 'Copyright © 2026 The Malibu Hotel. All rights reserved.', NULL, '2026-09-04 08:00:00'),
(33, 'theme-riorelax-primary_color', 'rgb(228, 118, 44)', NULL, '2026-09-04 08:00:00'),
(34, 'theme-riorelax-secondary_color', 'rgb(22, 25, 44)', NULL, '2026-09-04 08:00:00'),
(35, 'theme-riorelax-input_border_color', 'rgb(217, 222, 229)', NULL, '2026-09-04 08:00:00'),
(36, 'theme-riorelax-primary_color_hover', 'rgb(190, 92, 26)', NULL, '2026-09-04 08:00:00'),
(37, 'theme-riorelax-button_text_color_hover', 'rgb(255, 255, 255)', NULL, '2026-09-04 08:00:00'),
(38, 'theme-riorelax-primary_font', 'Be Vietnam Pro', NULL, '2026-09-04 08:00:00'),
(39, 'theme-riorelax-heading_font', 'Be Vietnam Pro', NULL, '2026-09-04 08:00:00'),
(40, 'theme-riorelax-cookie_consent_message', 'Your experience on this site will be improved by allowing cookies', NULL, '2026-09-04 08:00:00'),
(41, 'theme-riorelax-cookie_consent_learn_more_url', '/cookie-policy', NULL, '2026-09-04 08:00:00'),
(42, 'theme-riorelax-cookie_consent_learn_more_text', 'Cookie Policy', NULL, '2026-09-04 08:00:00'),
(43, 'theme-riorelax-homepage_id', '1', NULL, '2026-09-04 08:00:00'),
(44, 'theme-riorelax-blog_page_id', '10', NULL, '2026-09-04 08:00:00'),
(45, 'theme-riorelax-logo', '', NULL, '2026-09-04 08:00:00'),
(46, 'theme-riorelax-favicon', '', NULL, '2026-09-04 08:00:00'),
(47, 'theme-riorelax-email', 'res@malibuhotel.com.vn', NULL, '2026-09-04 08:00:00'),
(48, 'theme-riorelax-address', '263 Lê Hồng Phong, P. Thắng Tam, TP. Vũng Tàu, Bà Rịa - Vũng Tàu', NULL, '2026-09-04 08:00:00'),
(49, 'theme-riorelax-hotline', '0941 871 644', NULL, '2026-09-04 08:00:00'),
(50, 'theme-riorelax-preloader_enabled', 'no', NULL, '2026-09-04 08:00:00'),
(51, 'theme-riorelax-opening_hours', '', NULL, '2026-09-04 08:00:00'),
(52, 'theme-riorelax-header_button_url', '', NULL, '2026-09-04 08:00:00'),
(53, 'theme-riorelax-header_button_label', '', NULL, '2026-09-04 08:00:00'),
(54, 'theme-riorelax-background_footer', '', NULL, '2026-09-04 08:00:00'),
(55, 'theme-riorelax-galleries_limit_images', '3', NULL, '2026-09-04 08:00:00'),
(56, 'theme-riorelax-hotel_rules', '<ul><li><strong>Thời gian nhận/trả phòng:</strong> Nhận phòng từ <strong>14:00</strong>, trả phòng trước <strong>12:00</strong>.</li><li><strong>Giấy tờ tuỳ thân:</strong> Xuất trình Hộ chiếu (khách quốc tế) hoặc CMND/CCCD (khách Việt Nam) còn hiệu lực khi làm thủ tục.</li><li><strong>Chính sách thanh toán:</strong> Cung cấp thông tin thẻ tín dụng hoặc thanh toán đặt cọc để đảm bảo giữ phòng.</li><li><strong>Tiện ích miễn phí:</strong> Nước suối, trà, cà phê mỗi ngày; buffet sáng tại nhà hàng Vela; hồ bơi M Pool và phòng gym M Gym.</li><li><strong>Wi-Fi:</strong> Internet tốc độ cao miễn phí trong toàn bộ khuôn viên.</li><li><strong>Hút thuốc:</strong> Không hút thuốc trong phòng; vui lòng sử dụng ban công hoặc khu vực quy định.</li><li><strong>Vật nuôi:</strong> Không mang theo vật nuôi vào khách sạn.</li><li><strong>An toàn:</strong> Sử dụng két sắt trong phòng để bảo quản tài sản có giá trị; khách sạn có an ninh và lễ tân trực 24/7.</li><li><strong>Số lượng khách:</strong> Lưu trú đúng số người theo hạng phòng đã đặt; phụ thu áp dụng cho khách thêm người hoặc trẻ em.</li><li><strong>Hành lý cấm:</strong> Không mang chất cháy nổ, vũ khí hoặc thực phẩm có mùi nồng vào phòng nghỉ.</li></ul>', NULL, '2026-09-04 08:00:00'),
(57, 'theme-riorelax-cancellation', '', NULL, '2026-09-04 08:00:00'),
(58, 'theme-riorelax-authentication_login_background_image', '', NULL, '2026-09-04 08:00:00'),
(59, 'theme-riorelax-authentication_register_background_image', '', NULL, '2026-09-04 08:00:00'),
(60, 'theme-riorelax-authentication_forgot_password_background_image', '', NULL, '2026-09-04 08:00:00'),
(61, 'theme-riorelax-authentication_reset_password_background_image', '', NULL, '2026-09-04 08:00:00'),
(62, 'theme-riorelax-404_page_image', '', NULL, '2026-09-04 08:00:00'),
(63, 'theme-riorelax-social_links', '[[{\"key\":\"name\",\"value\":\"Facebook\"},{\"key\":\"social-icon\",\"value\":\"fab fa-facebook-f\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.facebook.com\\/themalibuhoteI\"}],[{\"key\":\"name\",\"value\":\"Instagram\"},{\"key\":\"social-icon\",\"value\":\"fab fa-instagram\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.instagram.com\\/malibuhotelvungtau\\/\"}],[{\"key\":\"name\",\"value\":\"TikTok\"},{\"key\":\"social-icon\",\"value\":\"fab fa-tiktok\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.tiktok.com\\/@malibuhotelvt\"}],[{\"key\":\"name\",\"value\":\"YouTube\"},{\"key\":\"social-icon\",\"value\":\"fab fa-youtube\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.youtube.com\\/@malibuhotel8000\"}],[{\"key\":\"name\",\"value\":\"Zalo\"},{\"key\":\"social-icon\",\"value\":\"fas fa-comment-dots\"},{\"key\":\"url\",\"value\":\"https:\\/\\/zalo.me\\/0941871601\"}]]', NULL, '2026-09-04 08:00:00'),
(64, 'simple_slider_using_assets', '0', NULL, '2026-09-04 08:00:00'),
(65, 'membership_authorization_at', '2026-03-13 08:29:34', NULL, '2026-09-04 08:00:00'),
(66, 'theme-riorelax-admin_logo', '', NULL, '2026-09-04 08:00:00'),
(67, 'theme-riorelax-admin_favicon', '', NULL, '2026-09-04 08:00:00'),
(68, 'is_completed_get_started', '1', NULL, '2026-09-04 08:00:00'),
(69, 'license_activated_at', '2026-03-13T08:35:20+00:00', NULL, '2026-09-04 08:00:00'),
(70, 'license_last_verified_at', '2026-03-21T00:55:05+00:00', NULL, '2026-09-04 08:00:00'),
(71, 'license_next_check_at', '2026-03-28T00:55:05+00:00', NULL, '2026-09-04 08:00:00'),
(72, 'license_verification_count', '2', NULL, '2026-09-04 08:00:00'),
(73, 'license_purchase_code_hash', '29a0745d5294a6c99993450452f4709d719c195ee5e9764ddb2ab930582bc839', NULL, '2026-09-04 08:00:00'),
(74, 'license_server_ip', '157.66.81.101', NULL, '2026-09-04 08:00:00'),
(75, 'license_domain', 'vietnamtourist.gomenu.vn', NULL, '2026-09-04 08:00:00'),
(76, 'licensed_to', 'duyphuong', NULL, '2026-09-04 08:00:00'),
(77, 'theme-riorelax-breadcrumb_background_image', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL1.jpg', NULL, '2026-09-04 08:00:00'),
(78, 'theme-riorelax-preloader_version', 'v2', NULL, '2026-09-04 08:00:00'),
(79, 'theme-riorelax-show_site_name', '1', NULL, '2026-09-04 08:00:00'),
(80, 'theme-riorelax-site_title_separator', '-', NULL, '2026-09-04 08:00:00'),
(81, 'theme-riorelax-seo_title', 'The Malibu Hotel Vũng Tàu – Khách sạn 5 sao trung tâm thành phố biển', NULL, '2026-09-04 08:00:00'),
(82, 'theme-riorelax-seo_description', 'The Malibu Hotel Vũng Tàu – 197 phòng nghỉ hướng biển trong toà nhà 23 tầng, kiến trúc châu Âu hiện đại. Hồ bơi M Pool, M Spa, M Gym, nhà hàng Vela & Carina, 7 phòng hội nghị sức chứa 450 khách. Live Beautifully.', NULL, '2026-09-04 08:00:00'),
(83, 'theme-riorelax-seo_index', '1', NULL, '2026-09-04 08:00:00'),
(84, 'theme-riorelax-seo_og_image', '', NULL, '2026-09-04 08:00:00'),
(85, 'theme-riorelax-term_and_privacy_policy_url', '', NULL, '2026-09-04 08:00:00'),
(86, 'theme-riorelax-date_format', 'd/m/Y', NULL, '2026-09-04 08:00:00'),
(87, 'theme-riorelax-favicon_type', 'image/x-icon', NULL, '2026-09-04 08:00:00'),
(88, 'theme-riorelax-header_top_enabled', '1', NULL, '2026-09-04 08:00:00'),
(89, 'theme-riorelax-header_sticky_enabled', 'yes', NULL, '2026-09-04 08:00:00'),
(90, 'theme-riorelax-galleries_page_id', NULL, NULL, '2026-09-04 08:00:00'),
(91, 'theme-riorelax-cookie_consent_enable', 'yes', NULL, '2026-09-04 08:00:00'),
(92, 'theme-riorelax-cookie_consent_style', 'full-width', NULL, '2026-09-04 08:00:00'),
(93, 'theme-riorelax-cookie_consent_button_text', 'Accept cookies', NULL, '2026-09-04 08:00:00'),
(94, 'theme-riorelax-cookie_consent_background_color', 'rgb(22, 25, 44)', NULL, '2026-09-04 08:00:00'),
(95, 'theme-riorelax-cookie_consent_text_color', '#fff', NULL, '2026-09-04 08:00:00'),
(96, 'theme-riorelax-cookie_consent_max_width', '1170', NULL, '2026-09-04 08:00:00'),
(97, 'theme-riorelax-cookie_consent_show_reject_button', 'no', NULL, '2026-09-04 08:00:00'),
(98, 'theme-riorelax-cookie_consent_show_customize_button', 'no', NULL, '2026-09-04 08:00:00'),
(99, 'custom_header_js', '', NULL, '2026-09-04 08:00:00'),
(100, 'custom_body_js', '', NULL, '2026-09-04 08:00:00'),
(101, 'custom_footer_js', '', NULL, '2026-09-04 08:00:00'),
(102, 'admin_logo_max_height', '32', NULL, '2026-09-04 08:00:00'),
(103, 'admin_favicon_type', 'image/x-icon', NULL, '2026-09-04 08:00:00'),
(104, 'login_screen_backgrounds', '[]', NULL, '2026-09-04 08:00:00'),
(105, 'admin_title', 'Malibu Hotel', NULL, '2026-09-04 08:00:00'),
(106, 'admin_appearance_locale', 'en', NULL, '2026-09-04 08:00:00'),
(107, 'rich_editor', 'ckeditor', NULL, '2026-09-04 08:00:00'),
(108, 'enable_page_visual_builder', '1', NULL, '2026-09-04 08:00:00'),
(109, 'admin_appearance_layout', 'vertical', NULL, '2026-09-04 08:00:00'),
(110, 'admin_appearance_show_menu_item_icon', '1', NULL, '2026-09-04 08:00:00'),
(111, 'admin_appearance_container_width', 'container-xl', NULL, '2026-09-04 08:00:00'),
(112, 'admin_primary_font', 'Inter', NULL, '2026-09-04 08:00:00'),
(113, 'admin_primary_color', '#206bc4', NULL, '2026-09-04 08:00:00'),
(114, 'admin_secondary_color', '#6c7a91', NULL, '2026-09-04 08:00:00'),
(115, 'admin_heading_color', 'inherit', NULL, '2026-09-04 08:00:00'),
(116, 'admin_text_color', '#182433', NULL, '2026-09-04 08:00:00'),
(117, 'admin_link_color', '#206bc4', NULL, '2026-09-04 08:00:00'),
(118, 'admin_link_hover_color', '#1a569d', NULL, '2026-09-04 08:00:00'),
(119, 'admin_appearance_custom_css', '', NULL, '2026-09-04 08:00:00'),
(120, 'admin_appearance_custom_header_js', '', NULL, '2026-09-04 08:00:00'),
(121, 'admin_appearance_custom_body_js', '', NULL, '2026-09-04 08:00:00'),
(122, 'admin_appearance_custom_footer_js', '', NULL, '2026-09-04 08:00:00'),
(123, 'show_theme_guideline_link', '0', NULL, '2026-09-04 08:00:00'),
(124, 'admin_appearance_locale_direction', 'ltr', NULL, '2026-09-04 08:00:00'),
(125, 'theme-riorelax-chat_btn_facebook', 'https://www.facebook.com/themalibuhoteI', NULL, '2026-09-04 08:00:00'),
(126, 'theme-riorelax-chat_btn_zalo', 'https://zalo.me/0941871601', NULL, '2026-09-04 08:00:00'),
(127, 'theme-riorelax-chat_btn_tiktok', 'https://www.tiktok.com/@malibuhotelvt', NULL, '2026-09-04 08:00:00'),
(128, 'theme-riorelax-chat_btn_instagram', 'https://www.instagram.com/malibuhotelvungtau/', NULL, '2026-09-04 08:00:00'),
(129, 'theme-riorelax-popup_banner_enabled', '0', NULL, '2026-09-04 08:00:00'),
(130, 'theme-riorelax-popup_banner_image', '', NULL, '2026-09-04 08:00:00'),
(131, 'theme-riorelax-chat_btn_telegram', NULL, NULL, '2026-09-04 08:00:00'),
(406, 'email_driver', 'smtp', NULL, '2026-09-04 08:00:00'),
(407, 'email_from_name', 'The Malibu Hotel', NULL, '2026-09-04 08:00:00'),
(408, 'email_from_address', 'res@malibuhotel.com.vn', NULL, '2026-09-04 08:00:00'),
(409, 'email_port', '587', NULL, '2026-09-04 08:00:00'),
(410, 'email_host', 'smtp.gmail.com', NULL, '2026-09-04 08:00:00'),
(411, 'email_username', '', NULL, '2026-09-04 08:00:00'),
(412, 'email_password', '', NULL, '2026-09-04 08:00:00'),
(413, 'email_local_domain', '', NULL, '2026-09-04 08:00:00'),
(414, 'email_encryption', 'tls', NULL, '2026-09-04 08:00:00'),
(415, 'email_mail_gun_domain', '', NULL, '2026-09-04 08:00:00'),
(416, 'email_mail_gun_secret', '', NULL, '2026-09-04 08:00:00'),
(417, 'email_mail_gun_endpoint', 'api.mailgun.net', NULL, '2026-09-04 08:00:00'),
(418, 'email_ses_key', '', NULL, '2026-09-04 08:00:00'),
(419, 'email_ses_secret', '', NULL, '2026-09-04 08:00:00'),
(420, 'email_ses_region', 'us-east-1', NULL, '2026-09-04 08:00:00'),
(421, 'email_postmark_token', '', NULL, '2026-09-04 08:00:00'),
(422, 'email_resend_key', '', NULL, '2026-09-04 08:00:00'),
(423, 'email_log_channel', 'single', NULL, '2026-09-04 08:00:00'),
(424, 'email_sendmail_path', '/usr/sbin/sendmail -bs -i', NULL, '2026-09-04 08:00:00'),
(425, 'admin_email', '[\"admin@malibuhotel.com.vn\"]', NULL, '2026-09-04 08:00:00'),
(426, 'time_zone', 'Asia/Ho_Chi_Minh', NULL, '2026-09-04 08:00:00'),
(427, 'locale_direction', 'ltr', NULL, '2026-09-04 08:00:00'),
(428, 'enable_send_error_reporting_via_email', '0', NULL, '2026-09-04 08:00:00'),
(429, 'redirect_404_to_homepage', '0', NULL, '2026-09-04 08:00:00'),
(430, 'audit_log_data_retention_period', '30', NULL, '2026-09-04 08:00:00'),
(431, 'locale', 'vi', NULL, '2026-09-04 08:00:00'),
(432, 'theme-riorelax-chat_btn_whatsapp', NULL, NULL, '2026-09-04 08:00:00'),
(487, 'ai_translator_api_key', '', NULL, '2026-09-04 08:00:00'),
(488, 'ai_translator_model', 'gpt-4o-mini', NULL, '2026-09-04 08:00:00'),
(489, 'ai_translator_prompt', 'You are an expert luxury hospitality translator for The Malibu Hotel, a 5-star international hotel in Vung Tau, Vietnam.\r\n\r\nTRANSLATION STYLE:\r\n- Use elegant, sophisticated and refined language befitting a world-class hotel\r\n- Evoke feelings of luxury, relaxation, exclusivity and impeccable service\r\n- Maintain a warm yet prestigious tone that makes guests feel valued\r\n- Keep the brand voice \"Live Beautifully\"\r\n- Keep proper nouns unchanged: Malibu, Vung Tau, M Pool, M Spa, M Gym, Vela Restaurant, Carina Restaurant, The Lux Cafe, Premier, Diamond, Suite, President\r\n- Preserve all HTML tags and attributes exactly as they appear', NULL, '2026-09-04 08:00:00'),
(490, 'ai_translator_admin_permissions_synced', '1', NULL, '2026-09-04 08:00:00'),
(491, 'language_auto_detect_user_language', '1', NULL, '2026-09-04 08:00:00'),
(604, 'google_tag_manager_type', 'custom', NULL, '2026-09-04 08:00:00'),
(605, 'custom_tracking_header_js', '', NULL, '2026-09-04 08:00:00'),
(606, 'custom_tracking_body_html', '', NULL, '2026-09-04 08:00:00'),
(607, 'gtm_debug_mode', '0', NULL, '2026-09-04 08:00:00'),
(608, 'gtm_container_id', '', NULL, '2026-09-04 08:00:00'),
(609, 'google_tag_manager_id', '', NULL, '2026-09-04 08:00:00'),
(646, 'google_tag_manager_code', '', NULL, '2026-09-04 08:00:00'),
(709, 'theme-riorelax-en_US-404_page_image', '', NULL, '2026-09-04 08:00:00'),
(710, 'theme-riorelax-en_US-address', '263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City, Ba Ria - Vung Tau Province, Vietnam', NULL, '2026-09-04 08:00:00'),
(711, 'theme-riorelax-en_US-authentication_forgot_password_background_image', '', NULL, '2026-09-04 08:00:00'),
(712, 'theme-riorelax-en_US-authentication_login_background_image', '', NULL, '2026-09-04 08:00:00'),
(713, 'theme-riorelax-en_US-authentication_register_background_image', '', NULL, '2026-09-04 08:00:00'),
(714, 'theme-riorelax-en_US-authentication_reset_password_background_image', '', NULL, '2026-09-04 08:00:00'),
(715, 'theme-riorelax-en_US-background_footer', '', NULL, '2026-09-04 08:00:00'),
(716, 'theme-riorelax-en_US-breadcrumb_background_image', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/MALIBU-HOTEL1.jpg', NULL, '2026-09-04 08:00:00'),
(717, 'theme-riorelax-en_US-button_text_color_hover', 'rgb(255, 255, 255)', NULL, '2026-09-04 08:00:00'),
(718, 'theme-riorelax-en_US-cancellation', '', NULL, '2026-09-04 08:00:00'),
(719, 'theme-riorelax-en_US-chat_btn_facebook', 'https://www.facebook.com/themalibuhoteI', NULL, '2026-09-04 08:00:00'),
(720, 'theme-riorelax-en_US-chat_btn_instagram', 'https://www.instagram.com/malibuhotelvungtau/', NULL, '2026-09-04 08:00:00'),
(721, 'theme-riorelax-en_US-chat_btn_telegram', NULL, NULL, '2026-09-04 08:00:00'),
(722, 'theme-riorelax-en_US-chat_btn_tiktok', 'https://www.tiktok.com/@malibuhotelvt', NULL, '2026-09-04 08:00:00'),
(723, 'theme-riorelax-en_US-chat_btn_whatsapp', NULL, NULL, '2026-09-04 08:00:00'),
(724, 'theme-riorelax-en_US-chat_btn_zalo', 'https://zalo.me/0941871601', NULL, '2026-09-04 08:00:00'),
(725, 'theme-riorelax-en_US-cookie_consent_background_color', 'rgb(22, 25, 44)', NULL, '2026-09-04 08:00:00'),
(726, 'theme-riorelax-en_US-cookie_consent_button_text', 'Accept cookies', NULL, '2026-09-04 08:00:00'),
(727, 'theme-riorelax-en_US-cookie_consent_enable', 'yes', NULL, '2026-09-04 08:00:00'),
(728, 'theme-riorelax-en_US-cookie_consent_learn_more_text', 'Cookie Policy', NULL, '2026-09-04 08:00:00'),
(729, 'theme-riorelax-en_US-cookie_consent_learn_more_url', '/cookie-policy', NULL, '2026-09-04 08:00:00'),
(730, 'theme-riorelax-en_US-cookie_consent_max_width', '1170', NULL, '2026-09-04 08:00:00'),
(731, 'theme-riorelax-en_US-cookie_consent_message', 'Your experience on this site will be improved by allowing cookies', NULL, '2026-09-04 08:00:00'),
(732, 'theme-riorelax-en_US-cookie_consent_show_customize_button', 'no', NULL, '2026-09-04 08:00:00'),
(733, 'theme-riorelax-en_US-cookie_consent_show_reject_button', 'no', NULL, '2026-09-04 08:00:00'),
(734, 'theme-riorelax-en_US-cookie_consent_style', 'full-width', NULL, '2026-09-04 08:00:00'),
(735, 'theme-riorelax-en_US-cookie_consent_text_color', '#fff', NULL, '2026-09-04 08:00:00'),
(736, 'theme-riorelax-en_US-copyright', 'Copyright © 2026 The Malibu Hotel. All rights reserved.', NULL, '2026-09-04 08:00:00'),
(737, 'theme-riorelax-en_US-date_format', 'd/m/Y', NULL, '2026-09-04 08:00:00'),
(738, 'theme-riorelax-en_US-email', 'res@malibuhotel.com.vn', NULL, '2026-09-04 08:00:00'),
(739, 'theme-riorelax-en_US-favicon', '', NULL, '2026-09-04 08:00:00'),
(740, 'theme-riorelax-en_US-favicon_type', 'image/x-icon', NULL, '2026-09-04 08:00:00'),
(741, 'theme-riorelax-en_US-galleries_limit_images', '3', NULL, '2026-09-04 08:00:00'),
(742, 'theme-riorelax-en_US-galleries_page_id', NULL, NULL, '2026-09-04 08:00:00'),
(743, 'theme-riorelax-en_US-header_button_label', '', NULL, '2026-09-04 08:00:00'),
(744, 'theme-riorelax-en_US-header_button_url', '', NULL, '2026-09-04 08:00:00'),
(745, 'theme-riorelax-en_US-header_sticky_enabled', 'yes', NULL, '2026-09-04 08:00:00'),
(746, 'theme-riorelax-en_US-header_top_enabled', '1', NULL, '2026-09-04 08:00:00'),
(747, 'theme-riorelax-en_US-heading_font', 'Jost', NULL, '2026-09-04 08:00:00'),
(748, 'theme-riorelax-en_US-homepage_id', '1', NULL, '2026-09-04 08:00:00'),
(749, 'theme-riorelax-en_US-hotel_rules', '<ul><li><strong>Check-in / check-out:</strong> Check-in from <strong>14:00</strong>, check-out before <strong>12:00</strong>.</li><li><strong>Identification:</strong> A valid passport (international guests) or ID card (Vietnamese guests) is required at check-in.</li><li><strong>Payment policy:</strong> A credit card or a deposit is required to guarantee the reservation.</li><li><strong>Complimentary:</strong> Daily bottled water, tea and coffee; breakfast buffet at Vela Restaurant; access to M Pool and M Gym.</li><li><strong>Wi-Fi:</strong> Complimentary high-speed internet throughout the hotel.</li><li><strong>Smoking:</strong> Non-smoking rooms; please use the balcony or the designated areas.</li><li><strong>Pets:</strong> Pets are not allowed in the hotel.</li><li><strong>Safety:</strong> Please use the in-room safe for valuables; security and front desk operate 24/7.</li><li><strong>Occupancy:</strong> Please respect the maximum occupancy of your room type; surcharges apply for extra guests or children.</li><li><strong>Prohibited items:</strong> Flammables, weapons and strong-smelling food are not permitted in guest rooms.</li></ul>', NULL, '2026-09-04 08:00:00'),
(750, 'theme-riorelax-en_US-hotline', '(+84) 941 871 644', NULL, '2026-09-04 08:00:00'),
(751, 'theme-riorelax-en_US-input_border_color', 'rgb(217, 222, 229)', NULL, '2026-09-04 08:00:00'),
(752, 'theme-riorelax-en_US-logo', '', NULL, '2026-09-04 08:00:00'),
(753, 'theme-riorelax-en_US-opening_hours', '', NULL, '2026-09-04 08:00:00'),
(754, 'theme-riorelax-en_US-popup_banner_enabled', '0', NULL, '2026-09-04 08:00:00'),
(755, 'theme-riorelax-en_US-popup_banner_image', '', NULL, '2026-09-04 08:00:00'),
(756, 'theme-riorelax-en_US-preloader_enabled', 'no', NULL, '2026-09-04 08:00:00'),
(757, 'theme-riorelax-en_US-preloader_version', 'v2', NULL, '2026-09-04 08:00:00'),
(758, 'theme-riorelax-en_US-primary_color', 'rgb(228, 118, 44)', NULL, '2026-09-04 08:00:00'),
(759, 'theme-riorelax-en_US-primary_color_hover', 'rgb(190, 92, 26)', NULL, '2026-09-04 08:00:00'),
(760, 'theme-riorelax-en_US-primary_font', 'Roboto', NULL, '2026-09-04 08:00:00'),
(761, 'theme-riorelax-en_US-secondary_color', 'rgb(22, 25, 44)', NULL, '2026-09-04 08:00:00'),
(762, 'theme-riorelax-en_US-seo_description', 'The Malibu Hotel Vung Tau offers 197 ocean-view rooms in a 23-storey tower with modern European architecture. M Pool, M Spa, M Gym, Vela & Carina restaurants and 7 conference rooms for up to 450 guests. Live Beautifully.', NULL, '2026-09-04 08:00:00'),
(763, 'theme-riorelax-en_US-seo_index', '1', NULL, '2026-09-04 08:00:00'),
(764, 'theme-riorelax-en_US-seo_og_image', '', NULL, '2026-09-04 08:00:00'),
(765, 'theme-riorelax-en_US-seo_title', 'The Malibu Hotel Vung Tau – 5-Star Hotel in the Heart of the Coastal City', NULL, '2026-09-04 08:00:00'),
(766, 'theme-riorelax-en_US-show_site_name', '1', NULL, '2026-09-04 08:00:00'),
(767, 'theme-riorelax-en_US-site_title', 'The Malibu Hotel Vung Tau', NULL, '2026-09-04 08:00:00'),
(768, 'theme-riorelax-en_US-site_title_separator', '-', NULL, '2026-09-04 08:00:00'),
(769, 'theme-riorelax-en_US-social_links', '[[{\"key\":\"name\",\"value\":\"Facebook\"},{\"key\":\"social-icon\",\"value\":\"fab fa-facebook-f\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.facebook.com\\/themalibuhoteI\"}],[{\"key\":\"name\",\"value\":\"Instagram\"},{\"key\":\"social-icon\",\"value\":\"fab fa-instagram\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.instagram.com\\/malibuhotelvungtau\\/\"}],[{\"key\":\"name\",\"value\":\"TikTok\"},{\"key\":\"social-icon\",\"value\":\"fab fa-tiktok\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.tiktok.com\\/@malibuhotelvt\"}],[{\"key\":\"name\",\"value\":\"YouTube\"},{\"key\":\"social-icon\",\"value\":\"fab fa-youtube\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.youtube.com\\/@malibuhotel8000\"}],[{\"key\":\"name\",\"value\":\"Zalo\"},{\"key\":\"social-icon\",\"value\":\"fas fa-comment-dots\"},{\"key\":\"url\",\"value\":\"https:\\/\\/zalo.me\\/0941871601\"}]]', NULL, '2026-09-04 08:00:00'),
(770, 'theme-riorelax-en_US-term_and_privacy_policy_url', '', NULL, '2026-09-04 08:00:00'),
(771, 'theme-riorelax-breadcrumb_background_image_room', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05931-HDR.jpg', NULL, '2026-09-04 08:00:00'),
(772, 'theme-riorelax-breadcrumb_background_image_product', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg', NULL, '2026-09-04 08:00:00'),
(773, 'theme-riorelax-breadcrumb_background_image_gallery', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-159.jpg', NULL, '2026-09-04 08:00:00'),
(774, 'theme-riorelax-breadcrumb_background_image_blog', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-04.jpg', NULL, '2026-09-04 08:00:00'),
(775, 'analytics_property_id', '', NULL, '2026-09-04 08:00:00'),
(776, 'analytics_service_account_credentials', '', NULL, '2026-09-04 08:00:00'),
(777, 'theme-riorelax-en_US-breadcrumb_background_image_room', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05931-HDR.jpg', NULL, '2026-09-04 08:00:00'),
(778, 'theme-riorelax-en_US-breadcrumb_background_image_product', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc3/M-POOL-MALIBU-HOTEL-70.jpg', NULL, '2026-09-04 08:00:00'),
(779, 'theme-riorelax-en_US-breadcrumb_background_image_gallery', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/M-POOL-MALIBU-HOTEL-159.jpg', NULL, '2026-09-04 08:00:00'),
(780, 'theme-riorelax-en_US-breadcrumb_background_image_blog', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/M-POOL-MALIBU-HOTEL-04.jpg', NULL, '2026-09-04 08:00:00'),
(801, 'indexnow_api_key', '2dbf522a-c943-4224-94dd-8c79f6e4dd58', NULL, '2026-09-04 08:00:00'),
(802, 'sitemap_enabled', '1', NULL, '2026-09-04 08:00:00'),
(803, 'sitemap_items_per_page', '1000', NULL, '2026-09-04 08:00:00'),
(804, 'indexnow_enabled', '1', NULL, '2026-09-04 08:00:00'),
(805, 'media_driver', 'public', NULL, '2026-09-04 08:00:00'),
(806, 'media_aws_access_key_id', '', NULL, '2026-09-04 08:00:00'),
(807, 'media_aws_secret_key', '', NULL, '2026-09-04 08:00:00'),
(808, 'media_aws_default_region', '', NULL, '2026-09-04 08:00:00'),
(809, 'media_aws_bucket', '', NULL, '2026-09-04 08:00:00'),
(810, 'media_aws_url', '', NULL, '2026-09-04 08:00:00'),
(811, 'media_s3_path', '', NULL, '2026-09-04 08:00:00'),
(812, 'media_aws_endpoint', '', NULL, '2026-09-04 08:00:00'),
(813, 'media_aws_use_path_style_endpoint', '0', NULL, '2026-09-04 08:00:00'),
(814, 'media_r2_access_key_id', '', NULL, '2026-09-04 08:00:00'),
(815, 'media_r2_secret_key', '', NULL, '2026-09-04 08:00:00'),
(816, 'media_r2_bucket', '', NULL, '2026-09-04 08:00:00'),
(817, 'media_r2_endpoint', '', NULL, '2026-09-04 08:00:00'),
(818, 'media_r2_url', '', NULL, '2026-09-04 08:00:00'),
(819, 'media_r2_use_path_style_endpoint', '0', NULL, '2026-09-04 08:00:00'),
(820, 'media_wasabi_access_key_id', '', NULL, '2026-09-04 08:00:00'),
(821, 'media_wasabi_secret_key', '', NULL, '2026-09-04 08:00:00'),
(822, 'media_wasabi_default_region', '', NULL, '2026-09-04 08:00:00'),
(823, 'media_wasabi_bucket', '', NULL, '2026-09-04 08:00:00'),
(824, 'media_wasabi_root', '', NULL, '2026-09-04 08:00:00'),
(825, 'media_do_spaces_access_key_id', '', NULL, '2026-09-04 08:00:00'),
(826, 'media_do_spaces_secret_key', '', NULL, '2026-09-04 08:00:00'),
(827, 'media_do_spaces_default_region', '', NULL, '2026-09-04 08:00:00'),
(828, 'media_do_spaces_bucket', '', NULL, '2026-09-04 08:00:00'),
(829, 'media_do_spaces_endpoint', '', NULL, '2026-09-04 08:00:00'),
(830, 'media_do_spaces_cdn_enabled', '0', NULL, '2026-09-04 08:00:00'),
(831, 'media_do_spaces_cdn_custom_domain', '', NULL, '2026-09-04 08:00:00'),
(832, 'media_do_spaces_use_path_style_endpoint', '0', NULL, '2026-09-04 08:00:00'),
(833, 'media_bunnycdn_hostname', '', NULL, '2026-09-04 08:00:00'),
(834, 'media_bunnycdn_zone', '', NULL, '2026-09-04 08:00:00'),
(835, 'media_bunnycdn_key', '', NULL, '2026-09-04 08:00:00'),
(836, 'media_bunnycdn_region', 'de', NULL, '2026-09-04 08:00:00'),
(837, 'media_backblaze_access_key_id', '', NULL, '2026-09-04 08:00:00'),
(838, 'media_backblaze_secret_key', '', NULL, '2026-09-04 08:00:00'),
(839, 'media_backblaze_bucket', '', NULL, '2026-09-04 08:00:00'),
(840, 'media_backblaze_default_region', '', NULL, '2026-09-04 08:00:00'),
(841, 'media_backblaze_endpoint', '', NULL, '2026-09-04 08:00:00'),
(842, 'media_backblaze_use_path_style_endpoint', '0', NULL, '2026-09-04 08:00:00'),
(843, 'media_backblaze_cdn_enabled', '0', NULL, '2026-09-04 08:00:00'),
(844, 'media_backblaze_cdn_custom_domain', '', NULL, '2026-09-04 08:00:00'),
(845, 'media_turn_off_automatic_url_translation_into_latin', '0', NULL, '2026-09-04 08:00:00'),
(846, 'media_use_original_name_for_file_path', '0', NULL, '2026-09-04 08:00:00'),
(847, 'media_keep_original_file_size_and_quality', '0', NULL, '2026-09-04 08:00:00'),
(848, 'media_default_placeholder_image', '', NULL, '2026-09-04 08:00:00'),
(849, 'max_upload_filesize', '10', NULL, '2026-09-04 08:00:00'),
(850, 'media_chunk_enabled', '0', NULL, '2026-09-04 08:00:00'),
(851, 'media_chunk_size', '1048576', NULL, '2026-09-04 08:00:00'),
(852, 'media_max_file_size', '1048576', NULL, '2026-09-04 08:00:00'),
(853, 'media_watermark_enabled', '0', NULL, '2026-09-04 08:00:00'),
(854, 'media_image_processing_library', 'gd', NULL, '2026-09-04 08:00:00'),
(855, 'media_watermark_source', '', NULL, '2026-09-04 08:00:00'),
(856, 'media_watermark_size', '10', NULL, '2026-09-04 08:00:00'),
(857, 'media_watermark_opacity', '70', NULL, '2026-09-04 08:00:00'),
(858, 'media_watermark_position', 'bottom-right', NULL, '2026-09-04 08:00:00'),
(859, 'media_watermark_position_x', '10', NULL, '2026-09-04 08:00:00'),
(860, 'media_watermark_position_y', '10', NULL, '2026-09-04 08:00:00'),
(861, 'media_thumbnail_crop_position', 'center', NULL, '2026-09-04 08:00:00'),
(862, 'user_can_only_view_own_media', '0', NULL, '2026-09-04 08:00:00'),
(863, 'media_convert_image_to_webp', '1', NULL, '2026-09-04 08:00:00'),
(864, 'media_enable_thumbnail_sizes', '1', NULL, '2026-09-04 08:00:00'),
(865, 'media_reduce_large_image_size', '1', NULL, '2026-09-04 08:00:00'),
(866, 'media_image_max_width', '1600', NULL, '2026-09-04 08:00:00'),
(867, 'media_image_max_height', '', NULL, '2026-09-04 08:00:00'),
(868, 'media_customize_upload_path', '0', NULL, '2026-09-04 08:00:00'),
(869, 'media_upload_path', 'storage', NULL, '2026-09-04 08:00:00'),
(870, 'media_convert_file_name_to_uuid', '0', NULL, '2026-09-04 08:00:00'),
(871, 'media_sizes_thumb_width', '150', NULL, '2026-09-04 08:00:00'),
(872, 'media_sizes_thumb_height', '150', NULL, '2026-09-04 08:00:00'),
(873, 'media_sizes_medium_width', '440', NULL, '2026-09-04 08:00:00'),
(874, 'media_sizes_medium_height', '340', NULL, '2026-09-04 08:00:00'),
(875, 'media_sizes_small_width', '300', NULL, '2026-09-04 08:00:00'),
(876, 'media_sizes_small_height', '340', NULL, '2026-09-04 08:00:00'),
(877, 'media_sizes_room-image_width', '850', NULL, '2026-09-04 08:00:00'),
(878, 'media_sizes_room-image_height', '460', NULL, '2026-09-04 08:00:00'),
(879, 'media_folders_can_add_watermark', '[]', NULL, '2026-09-04 08:00:00'),
(880, 'cache_admin_menu_enable', '0', NULL, '2026-09-04 08:00:00'),
(881, 'enable_cache_site_map', '1', NULL, '2026-09-04 08:00:00'),
(882, 'cache_front_menu_enabled', '1', NULL, '2026-09-04 08:00:00'),
(883, 'cache_user_avatar_enabled', '1', NULL, '2026-09-04 08:00:00'),
(884, 'shortcode_cache_enabled', '0', NULL, '2026-09-04 08:00:00'),
(885, 'widget_cache_enabled', '0', NULL, '2026-09-04 08:00:00'),
(886, 'plugin_cache_enabled', '1', NULL, '2026-09-04 08:00:00'),
(887, 'cache_time_site_map', '60', NULL, '2026-09-04 08:00:00'),
(888, 'shortcode_cache_ttl', '1800', NULL, '2026-09-04 08:00:00'),
(889, 'widget_cache_ttl', '1800', NULL, '2026-09-04 08:00:00'),
(890, 'ae_notification_plus_archi-elite-notification-plus-drivers-telegram_enable', '1', NULL, '2026-09-04 08:00:00'),
(891, 'ae_notification_plus_archi-elite-notification-plus-drivers-telegram_bot_token', '8735766624:AAHWnEk2jlTXvq62e0pmO9WfAf3aexn3_20', NULL, '2026-09-04 08:00:00'),
(892, 'ae_notification_plus_archi-elite-notification-plus-drivers-telegram_chat_id', '-1004456903366', NULL, '2026-09-04 08:00:00'),
(893, 'ae_notification_plus_archi-elite-notification-plus-drivers-slack_enable', '0', NULL, '2026-09-04 08:00:00'),
(894, 'ae_notification_plus_archi-elite-notification-plus-drivers-slack_webhook_url', '', NULL, '2026-09-04 08:00:00'),
(895, 'ae_notification_plus_archi-elite-notification-plus-drivers-whats-app_enable', '0', NULL, '2026-09-04 08:00:00'),
(896, 'ae_notification_plus_archi-elite-notification-plus-drivers-whats-app_phone_number_id', '', NULL, '2026-09-04 08:00:00'),
(897, 'ae_notification_plus_archi-elite-notification-plus-drivers-whats-app_access_token', '', NULL, '2026-09-04 08:00:00'),
(898, 'ae_notification_plus_archi-elite-notification-plus-drivers-whats-app_to_phone_number', '', NULL, '2026-09-04 08:00:00'),
(899, 'ae_notification_plus_archi-elite-notification-plus-drivers-vonage_enable', '0', NULL, '2026-09-04 08:00:00'),
(900, 'ae_notification_plus_archi-elite-notification-plus-drivers-vonage_api_key', '', NULL, '2026-09-04 08:00:00'),
(901, 'ae_notification_plus_archi-elite-notification-plus-drivers-vonage_api_secret', '', NULL, '2026-09-04 08:00:00'),
(902, 'ae_notification_plus_archi-elite-notification-plus-drivers-vonage_from', '', NULL, '2026-09-04 08:00:00'),
(903, 'ae_notification_plus_archi-elite-notification-plus-drivers-vonage_to', '', NULL, '2026-09-04 08:00:00'),
(904, 'ae_notification_plus_archi-elite-notification-plus-drivers-twilio_enable', '0', NULL, '2026-09-04 08:00:00'),
(905, 'ae_notification_plus_archi-elite-notification-plus-drivers-twilio_account_sid', '', NULL, '2026-09-04 08:00:00'),
(906, 'ae_notification_plus_archi-elite-notification-plus-drivers-twilio_auth_token', '', NULL, '2026-09-04 08:00:00'),
(907, 'ae_notification_plus_archi-elite-notification-plus-drivers-twilio_from', '', NULL, '2026-09-04 08:00:00'),
(908, 'ae_notification_plus_archi-elite-notification-plus-drivers-twilio_to', '', NULL, '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `simple_sliders`
--

DROP TABLE IF EXISTS `simple_sliders`;
CREATE TABLE `simple_sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `simple_sliders`
--

INSERT INTO `simple_sliders` (`id`, `name`, `key`, `description`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Home slider', 'home-slider-vn', '', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'Trang bìa', 'TRANG BÌA', '', 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `simple_sliders_translations`
--

DROP TABLE IF EXISTS `simple_sliders_translations`;
CREATE TABLE `simple_sliders_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `simple_sliders_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `simple_sliders_translations`
--

INSERT INTO `simple_sliders_translations` (`lang_code`, `simple_sliders_id`, `name`, `description`) VALUES
('en_US', 3, 'Home slider', ''),
('en_US', 4, 'Cover slider', '');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `simple_slider_items`
--

DROP TABLE IF EXISTS `simple_slider_items`;
CREATE TABLE `simple_slider_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `simple_slider_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `simple_slider_items`
--

INSERT INTO `simple_slider_items` (`id`, `simple_slider_id`, `title`, `image`, `link`, `description`, `order`, `created_at`, `updated_at`) VALUES
(1, 3, 'MALIBU HOTEL VŨNG TÀU', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg', '', 'Live Beautifully – 197 phòng nghỉ hướng biển giữa lòng thành phố', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 3, 'PHÒNG NGHỈ &amp; SUITE', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05931-HDR.jpg', '', 'Từ Premier 40 m² đến Presidential Suite 250 m²', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 3, 'M POOL', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-36.jpg', '', 'Hồ bơi ngoài trời tầng 6 với tầm nhìn toàn cảnh Vũng Tàu', 2, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 3, 'HỘI NGHỊ &amp; SỰ KIỆN', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/z7304583041023_6639f72ca0fe6cc33e22cbd47eedd674.jpg', '', '7 phòng hội nghị, sức chứa tới 450 khách', 3, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 4, 'MALIBU HOTEL VŨNG TÀU', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc1/DSC00316.jpg', '', 'Live Beautifully – 197 phòng nghỉ hướng biển giữa lòng thành phố', 0, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 4, 'PHÒNG NGHỈ &amp; SUITE', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc2/DSC05931-HDR.jpg', '', 'Từ Premier 40 m² đến Presidential Suite 250 m²', 1, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 4, 'M POOL', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc5/M-POOL-MALIBU-HOTEL-36.jpg', '', 'Hồ bơi ngoài trời tầng 6 với tầm nhìn toàn cảnh Vũng Tàu', 2, '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 4, 'HỘI NGHỊ &amp; SỰ KIỆN', 'https://malibuhotel.com.vn/files/sites/site_70/site_70_gallery_muc4/z7304583041023_6639f72ca0fe6cc33e22cbd47eedd674.jpg', '', '7 phòng hội nghị, sức chứa tới 450 khách', 3, '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `simple_slider_items_translations`
--

DROP TABLE IF EXISTS `simple_slider_items_translations`;
CREATE TABLE `simple_slider_items_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `simple_slider_items_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `simple_slider_items_translations`
--

INSERT INTO `simple_slider_items_translations` (`lang_code`, `simple_slider_items_id`, `title`, `link`, `description`) VALUES
('en_US', 1, 'MALIBU HOTEL VUNG TAU', '', 'Live Beautifully – 197 ocean-view rooms in the heart of the city'),
('en_US', 2, 'ROOMS &amp; SUITES', '', 'From the 40 sqm Premier to the 250 sqm Presidential Suite'),
('en_US', 3, 'M POOL', '', 'The 6th-floor outdoor pool with panoramic views over Vung Tau'),
('en_US', 4, 'MEETINGS &amp; EVENTS', '', 'Seven conference rooms for up to 450 guests'),
('en_US', 5, 'MALIBU HOTEL VUNG TAU', '', 'Live Beautifully – 197 ocean-view rooms in the heart of the city'),
('en_US', 6, 'ROOMS &amp; SUITES', '', 'From the 40 sqm Premier to the 250 sqm Presidential Suite'),
('en_US', 7, 'M POOL', '', 'The 6th-floor outdoor pool with panoramic views over Vung Tau'),
('en_US', 8, 'MEETINGS &amp; EVENTS', '', 'Seven conference rooms for up to 450 guests');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slugs`
--

DROP TABLE IF EXISTS `slugs`;
CREATE TABLE `slugs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint(20) UNSIGNED NOT NULL,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `slugs`
--

INSERT INTO `slugs` (`id`, `key`, `reference_id`, `reference_type`, `prefix`, `created_at`, `updated_at`) VALUES
(1, 'trang-chu', 1, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 've-chung-toi', 5, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'tien-nghi-dich-vu', 6, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'thu-vien-anh', 7, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'cau-hoi-thuong-gap', 8, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'am-thuc', 9, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 'tin-tuc', 10, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 'lien-he', 11, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 'chinh-sach-bao-mat', 12, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 'dieu-khoan-va-dieu-kien', 13, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 'hoi-nghi-su-kien', 18, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 'malibu-group', 19, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, 'tuyen-dung', 22, 'Botble\\Page\\Models\\Page', '', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(14, 'premier', 5, 'Botble\\Hotel\\Models\\RoomCategory', 'room-categories', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(15, 'diamond', 6, 'Botble\\Hotel\\Models\\RoomCategory', 'room-categories', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(16, 'suite', 7, 'Botble\\Hotel\\Models\\RoomCategory', 'room-categories', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(17, 'president', 8, 'Botble\\Hotel\\Models\\RoomCategory', 'room-categories', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(18, 'phong-premier-twin', 1, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(19, 'phong-premier-king', 2, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(20, 'phong-premier-queen', 3, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(21, 'phong-premier-family', 4, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(22, 'phong-diamond-king', 5, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(23, 'phong-diamond-family', 6, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(24, 'malibu-suite', 7, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(25, 'family-suite', 8, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(26, 'vice-president-suite', 9, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(27, 'presidential-suite', 10, 'Botble\\Hotel\\Models\\Room', 'rooms', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(28, 'm-pool', 1, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(29, 'm-spa', 2, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(30, 'm-gym', 3, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(31, 'vela-restaurant', 4, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(32, 'carina-restaurant', 5, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(33, 'the-lux-cafe', 6, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(34, 'conference', 7, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(35, 'kid-zone', 8, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(36, 'entertainment', 9, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(37, 'billiard-foosball', 10, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(38, 'private-laundry', 11, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(39, 'gift-shop', 12, 'Botble\\Hotel\\Models\\Service', 'services', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(40, 'bai-sau-vung-tau', 1, 'Botble\\Hotel\\Models\\Place', 'places', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(41, 'tuong-chua-kito-vua', 2, 'Botble\\Hotel\\Models\\Place', 'places', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(42, 'ngon-hai-dang-vung-tau', 3, 'Botble\\Hotel\\Models\\Place', 'places', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(43, 'bach-dinh', 4, 'Botble\\Hotel\\Models\\Place', 'places', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(44, 'ho-may-park', 5, 'Botble\\Hotel\\Models\\Place', 'places', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(45, 'cho-xom-luoi', 6, 'Botble\\Hotel\\Models\\Place', 'places', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(46, 'toan-canh-khach-san', 6, 'Botble\\Gallery\\Models\\Gallery', 'galleries', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(47, 'phong-nghi', 7, 'Botble\\Gallery\\Models\\Gallery', 'galleries', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(48, 'nha-hang', 8, 'Botble\\Gallery\\Models\\Gallery', 'galleries', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(49, 'hoi-nghi-amp-su-kien', 9, 'Botble\\Gallery\\Models\\Gallery', 'galleries', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(50, 'ho-boi-m-pool', 10, 'Botble\\Gallery\\Models\\Gallery', 'galleries', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(51, 'phong-tap-m-gym', 11, 'Botble\\Gallery\\Models\\Gallery', 'galleries', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(52, 'm-spa', 12, 'Botble\\Gallery\\Models\\Gallery', 'galleries', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(53, 'giai-tri', 13, 'Botble\\Gallery\\Models\\Gallery', 'galleries', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(54, 'uu-dai', 1, 'Botble\\Blog\\Models\\Category', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(55, 'tien-nghi', 2, 'Botble\\Blog\\Models\\Category', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(56, 'am-thuc', 3, 'Botble\\Blog\\Models\\Category', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(57, 'hoi-nghi-amp-su-kien', 4, 'Botble\\Blog\\Models\\Category', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(58, 'kham-pha-vung-tau', 5, 'Botble\\Blog\\Models\\Category', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(59, 'malibu-hotel', 1, 'Botble\\Blog\\Models\\Tag', 'tag', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(60, 'vung-tau', 2, 'Botble\\Blog\\Models\\Tag', 'tag', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(61, 'uu-dai', 3, 'Botble\\Blog\\Models\\Tag', 'tag', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(62, 'am-thuc', 4, 'Botble\\Blog\\Models\\Tag', 'tag', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(63, 'nghi-duong', 5, 'Botble\\Blog\\Models\\Tag', 'tag', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(64, 'm-pool-ho-boi-ngoai-troi', 1, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(65, 'm-spa-cham-soc-va-tri-lieu', 2, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(66, 'm-gym-phong-tap-the-hinh', 3, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(67, 'vela-restaurant-buffet-sang', 4, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(68, 'carina-restaurant-am-thuc-a-au', 5, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(69, 'the-lux-cafe', 6, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(70, 'conference-hoi-nghi-hoi-thao', 7, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(71, 'kid-zone-khu-vui-choi-tre-em', 8, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(72, 'entertainment-khu-giai-tri', 9, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(73, 'billiard-foosball', 10, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(74, 'private-laundry-giat-ui-khep-kin', 11, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(75, 'gift-shop-cua-hang-qua-tang', 12, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(76, 'gourmet-stay-package', 13, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(77, 'long-stay-uu-dai-luu-tru-dai-ngay', 14, 'Botble\\Blog\\Models\\Post', 'news', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slugs_translations`
--

DROP TABLE IF EXISTS `slugs_translations`;
CREATE TABLE `slugs_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slugs_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `slugs_translations`
--

INSERT INTO `slugs_translations` (`lang_code`, `slugs_id`, `key`, `prefix`) VALUES
('en_US', 1, 'home', ''),
('en_US', 2, 'about-us', ''),
('en_US', 3, 'facilities', ''),
('en_US', 4, 'gallery', ''),
('en_US', 5, 'hotel-faqs', ''),
('en_US', 6, 'dine', ''),
('en_US', 7, 'news', ''),
('en_US', 8, 'contact', ''),
('en_US', 9, 'privacy-policy', ''),
('en_US', 10, 'terms-and-conditions', ''),
('en_US', 11, 'conference-events', ''),
('en_US', 12, 'malibu-group', ''),
('en_US', 13, 'careers', ''),
('en_US', 14, 'premier', 'room-categories'),
('en_US', 15, 'diamond', 'room-categories'),
('en_US', 16, 'suite', 'room-categories'),
('en_US', 17, 'president', 'room-categories'),
('en_US', 18, 'premier-twin-room', 'rooms'),
('en_US', 19, 'premier-king-room', 'rooms'),
('en_US', 20, 'premier-queen-room', 'rooms'),
('en_US', 21, 'premier-family-room', 'rooms'),
('en_US', 22, 'diamond-king-room', 'rooms'),
('en_US', 23, 'diamond-family-room', 'rooms'),
('en_US', 24, 'malibu-suite', 'rooms'),
('en_US', 25, 'family-suite', 'rooms'),
('en_US', 26, 'vice-president-suite', 'rooms'),
('en_US', 27, 'presidential-suite', 'rooms'),
('en_US', 28, 'm-pool', 'services'),
('en_US', 29, 'm-spa', 'services'),
('en_US', 30, 'm-gym', 'services'),
('en_US', 31, 'vela-restaurant', 'services'),
('en_US', 32, 'carina-restaurant', 'services'),
('en_US', 33, 'the-lux-cafe', 'services'),
('en_US', 34, 'conference', 'services'),
('en_US', 35, 'kid-zone', 'services'),
('en_US', 36, 'entertainment', 'services'),
('en_US', 37, 'billiard-foosball', 'services'),
('en_US', 38, 'private-laundry', 'services'),
('en_US', 39, 'gift-shop', 'services'),
('en_US', 40, 'back-beach-vung-tau', 'places'),
('en_US', 41, 'christ-the-king-statue', 'places'),
('en_US', 42, 'vung-tau-lighthouse', 'places'),
('en_US', 43, 'bach-dinh-white-palace', 'places'),
('en_US', 44, 'ho-may-park', 'places'),
('en_US', 45, 'xom-luoi-seafood-market', 'places'),
('en_US', 46, 'hotel-landscape', 'galleries'),
('en_US', 47, 'rooms-amp-suites', 'galleries'),
('en_US', 48, 'restaurants', 'galleries'),
('en_US', 49, 'meetings-amp-events', 'galleries'),
('en_US', 50, 'm-pool', 'galleries'),
('en_US', 51, 'm-gym', 'galleries'),
('en_US', 52, 'm-spa', 'galleries'),
('en_US', 53, 'entertainment', 'galleries'),
('en_US', 54, 'offers', 'news'),
('en_US', 55, 'facilities', 'news'),
('en_US', 56, 'dining', 'news'),
('en_US', 57, 'meetings-amp-events', 'news'),
('en_US', 58, 'explore-vung-tau', 'news'),
('en_US', 59, 'malibu-hotel', 'tag'),
('en_US', 60, 'vung-tau', 'tag'),
('en_US', 61, 'uu-dai', 'tag'),
('en_US', 62, 'am-thuc', 'tag'),
('en_US', 63, 'nghi-duong', 'tag'),
('en_US', 64, 'm-pool-outdoor-pool', 'news'),
('en_US', 65, 'm-spa-health-care-and-treatment', 'news'),
('en_US', 66, 'm-gym-fitness-centre', 'news'),
('en_US', 67, 'vela-restaurant-breakfast-buffet', 'news'),
('en_US', 68, 'carina-restaurant-fusion-cuisine', 'news'),
('en_US', 69, 'the-lux-cafe', 'news'),
('en_US', 70, 'conference-meetings-and-seminars', 'news'),
('en_US', 71, 'kid-zone-childrens-playground', 'news'),
('en_US', 72, 'entertainment-area', 'news'),
('en_US', 73, 'billiard-and-foosball', 'news'),
('en_US', 74, 'private-laundry', 'news'),
('en_US', 75, 'gift-shop', 'news'),
('en_US', 76, 'gourmet-stay-package', 'news'),
('en_US', 77, 'long-stay-offers', 'news');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `social_logins`
--

DROP TABLE IF EXISTS `social_logins`;
CREATE TABLE `social_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `refresh_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expires_at` timestamp NULL DEFAULT NULL,
  `provider_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`provider_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `author_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tags`
--

INSERT INTO `tags` (`id`, `name`, `author_id`, `author_type`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Malibu Hotel', 1, 'Botble\\ACL\\Models\\User', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'Vũng Tàu', 1, 'Botble\\ACL\\Models\\User', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'Ưu đãi', 1, 'Botble\\ACL\\Models\\User', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'Ẩm thực', 1, 'Botble\\ACL\\Models\\User', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'Nghỉ dưỡng', 1, 'Botble\\ACL\\Models\\User', NULL, 'published', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tags_translations`
--

DROP TABLE IF EXISTS `tags_translations`;
CREATE TABLE `tags_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tags_translations` (`lang_code`, `tags_id`, `name`, `description`) VALUES
('en_US', 1, 'Malibu Hotel', NULL),
('en_US', 2, 'Vũng Tàu', NULL),
('en_US', 3, 'Ưu đãi', NULL),
('en_US', 4, 'Ẩm thực', NULL),
('en_US', 5, 'Nghỉ dưỡng', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teams`
--

DROP TABLE IF EXISTS `teams`;
CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `socials` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `teams`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `teams_translations`
--

DROP TABLE IF EXISTS `teams_translations`;
CREATE TABLE `teams_translations` (
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teams_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `testimonials`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `testimonials_translations`
--

DROP TABLE IF EXISTS `testimonials_translations`;
CREATE TABLE `testimonials_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `testimonials_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_id` bigint(20) UNSIGNED DEFAULT NULL,
  `super_user` tinyint(1) NOT NULL DEFAULT 0,
  `manage_supers` tinyint(1) NOT NULL DEFAULT 0,
  `permissions` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `sessions_invalidated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `first_name`, `last_name`, `username`, `avatar_id`, `super_user`, `manage_supers`, `permissions`, `last_login`, `sessions_invalidated_at`) VALUES
(1, 'admin@malibuhotel.com.vn', '0941871644', '2026-09-04 08:00:00', '$2y$12$cuMBS02jVEznQ.k1Ww/YieYBKBOCRuOPzKZNa23NQ3K1gtZFWWVj.', NULL, '2026-09-04 08:00:00', '2026-09-04 08:00:00', 'Malibu', 'Admin', 'admin', NULL, 1, 1, NULL, NULL, NULL);
-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user_meta`
--

DROP TABLE IF EXISTS `user_meta`;
CREATE TABLE `user_meta` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `user_meta`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `widgets`
--

DROP TABLE IF EXISTS `widgets`;
CREATE TABLE `widgets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `widget_id` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sidebar_id` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
  `data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `widgets`
--

INSERT INTO `widgets` (`id`, `widget_id`, `sidebar_id`, `theme`, `position`, `data`, `created_at`, `updated_at`) VALUES
(1, 'ContactInformationMenuWidget', 'footer_sidebar', 'riorelax', 0, '{\"id\": \"ContactInformationMenuWidget\", \"phone_number\": \"0941 871 644\", \"email\": \"res@malibuhotel.com.vn\", \"address\": \"263 L\\u00ea H\\u1ed3ng Phong, P. Th\\u1eafng Tam, TP. V\\u0169ng T\\u00e0u, B\\u00e0 R\\u1ecba - V\\u0169ng T\\u00e0u\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(2, 'CustomMenuWidget', 'footer_sidebar', 'riorelax', 1, '{\"id\": \"CustomMenuWidget\", \"name\": \"Li\\u00ean k\\u1ebft\", \"menu_id\": \"our-links\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(3, 'CustomMenuWidget', 'footer_sidebar', 'riorelax', 2, '{\"id\": \"CustomMenuWidget\", \"name\": \"Ch\\u00ednh s\\u00e1ch\", \"menu_id\": \"our-services\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(4, 'NewsletterWidget', 'footer_sidebar', 'riorelax', 3, '{\"id\": \"NewsletterWidget\", \"title\": \"\\u0110\\u0103ng k\\u00fd nh\\u1eadn b\\u1ea3n tin c\\u1ee7a ch\\u00fang t\\u00f4i\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(5, 'BlogSearchWidget', 'blog_sidebar', 'riorelax', 1, '{\"id\": \"BlogSearchWidget\", \"name\": \"Blog Search\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(6, 'BlogSocialsWidget', 'blog_sidebar', 'riorelax', 2, '{\"id\": \"BlogSocialsWidget\", \"name\": \"Blog Socials\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(7, 'BlogCategoriesWidget', 'blog_sidebar', 'riorelax', 3, '{\"id\": \"BlogCategoriesWidget\", \"name\": \"Blog Categories\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(8, 'BlogPostsWidget', 'blog_sidebar', 'riorelax', 4, '{\"id\": \"BlogPostsWidget\", \"name\": \"Blog Posts\", \"type\": \"recent\", \"limit\": 5}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(9, 'BlogTagsWidget', 'blog_sidebar', 'riorelax', 5, '{\"id\": \"BlogTagsWidget\", \"name\": \"Blog Tags\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(10, 'RoomContactWidget', 'room_sidebar', 'riorelax', 0, '{\"id\": \"RoomContactWidget\", \"title\": \"C\\u1ea7n h\\u1ed7 tr\\u1ee3? Li\\u00ean h\\u1ec7 ch\\u00fang t\\u00f4i\", \"phone\": \"0941871644\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(11, 'RoomContactWidget', 'service_sidebar', 'riorelax', 0, '{\"id\": \"RoomContactWidget\", \"title\": \"C\\u1ea7n h\\u1ed7 tr\\u1ee3? Li\\u00ean h\\u1ec7 ch\\u00fang t\\u00f4i\", \"phone\": \"0941871644\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(12, 'CheckAvailabilityForm', 'rooms_sidebar', 'riorelax', 0, '{\"id\": \"CheckAvailabilityForm\", \"title\": \"Form \\u0111\\u1eb7t ph\\u00f2ng\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(13, 'ContactInformationMenuWidget', 'footer_sidebar', 'riorelax-en_US', 0, '{\"id\": \"ContactInformationMenuWidget\", \"phone_number\": \"(+84) 941 871 644\", \"email\": \"res@malibuhotel.com.vn\", \"address\": \"263 Le Hong Phong Street, Thang Tam Ward, Vung Tau City, Ba Ria - Vung Tau Province, Vietnam\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(14, 'CustomMenuWidget', 'footer_sidebar', 'riorelax-en_US', 1, '{\"id\": \"CustomMenuWidget\", \"name\": \"Our Links\", \"menu_id\": \"link\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(15, 'CustomMenuWidget', 'footer_sidebar', 'riorelax-en_US', 2, '{\"id\": \"CustomMenuWidget\", \"name\": \"Policy\", \"menu_id\": \"policy\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(16, 'NewsletterWidget', 'footer_sidebar', 'riorelax-en_US', 3, '{\"id\": \"NewsletterWidget\", \"title\": \"Subscribe To Our Newsletter\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(17, 'BlogSearchWidget', 'blog_sidebar', 'riorelax-en_US', 1, '{\"id\": \"BlogSearchWidget\", \"name\": \"Blog Search\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(18, 'BlogSocialsWidget', 'blog_sidebar', 'riorelax-en_US', 2, '{\"id\": \"BlogSocialsWidget\", \"name\": \"Blog Socials\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(19, 'BlogCategoriesWidget', 'blog_sidebar', 'riorelax-en_US', 3, '{\"id\": \"BlogCategoriesWidget\", \"name\": \"Blog Categories\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(20, 'BlogPostsWidget', 'blog_sidebar', 'riorelax-en_US', 4, '{\"id\": \"BlogPostsWidget\", \"name\": \"Blog Posts\", \"type\": \"recent\", \"limit\": 5}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(21, 'BlogTagsWidget', 'blog_sidebar', 'riorelax-en_US', 5, '{\"id\": \"BlogTagsWidget\", \"name\": \"Blog Tags\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(22, 'RoomContactWidget', 'room_sidebar', 'riorelax-en_US', 0, '{\"id\": \"RoomContactWidget\", \"title\": \"Need any help? Contact us\", \"phone\": \"0941871644\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(23, 'RoomContactWidget', 'service_sidebar', 'riorelax-en_US', 0, '{\"id\": \"RoomContactWidget\", \"title\": \"Need any help? Contact us\", \"phone\": \"0941871644\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00'),
(24, 'CheckAvailabilityForm', 'rooms_sidebar', 'riorelax-en_US', 0, '{\"id\": \"CheckAvailabilityForm\", \"title\": \"Booking form\"}', '2026-09-04 08:00:00', '2026-09-04 08:00:00');
--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activations_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ai_training_contexts`
--
ALTER TABLE `ai_training_contexts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lang_pair_active` (`source_language`,`target_language`,`is_active`),
  ADD KEY `ai_training_contexts_category_index` (`category`);

--
-- Chỉ mục cho bảng `ai_translation_logs`
--
ALTER TABLE `ai_translation_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ai_translation_logs_created_at_index` (`created_at`),
  ADD KEY `ai_translation_logs_user_id_index` (`user_id`),
  ADD KEY `ai_translation_logs_api_key_hash_index` (`api_key_hash`);

--
-- Chỉ mục cho bảng `audit_histories`
--
ALTER TABLE `audit_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_histories_user_id_index` (`user_id`),
  ADD KEY `audit_histories_module_index` (`module`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_id_index` (`parent_id`),
  ADD KEY `categories_status_index` (`status`),
  ADD KEY `categories_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `categories_translations`
--
ALTER TABLE `categories_translations`
  ADD PRIMARY KEY (`lang_code`,`categories_id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_custom_fields`
--
ALTER TABLE `contact_custom_fields`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_custom_fields_translations`
--
ALTER TABLE `contact_custom_fields_translations`
  ADD PRIMARY KEY (`lang_code`,`contact_custom_fields_id`);

--
-- Chỉ mục cho bảng `contact_custom_field_options`
--
ALTER TABLE `contact_custom_field_options`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contact_custom_field_options_translations`
--
ALTER TABLE `contact_custom_field_options_translations`
  ADD PRIMARY KEY (`lang_code`,`contact_custom_field_options_id`);

--
-- Chỉ mục cho bảng `contact_replies`
--
ALTER TABLE `contact_replies`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dashboard_widgets`
--
ALTER TABLE `dashboard_widgets`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dashboard_widget_settings`
--
ALTER TABLE `dashboard_widget_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dashboard_widget_settings_user_id_index` (`user_id`),
  ADD KEY `dashboard_widget_settings_widget_id_index` (`widget_id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `faqs_translations`
--
ALTER TABLE `faqs_translations`
  ADD PRIMARY KEY (`lang_code`,`faqs_id`);

--
-- Chỉ mục cho bảng `faq_categories`
--
ALTER TABLE `faq_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `faq_categories_translations`
--
ALTER TABLE `faq_categories_translations`
  ADD PRIMARY KEY (`lang_code`,`faq_categories_id`);

--
-- Chỉ mục cho bảng `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `galleries_translations`
--
ALTER TABLE `galleries_translations`
  ADD PRIMARY KEY (`lang_code`,`galleries_id`);

--
-- Chỉ mục cho bảng `gallery_meta`
--
ALTER TABLE `gallery_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_meta_reference_id_index` (`reference_id`);

--
-- Chỉ mục cho bảng `gallery_meta_translations`
--
ALTER TABLE `gallery_meta_translations`
  ADD PRIMARY KEY (`lang_code`,`gallery_meta_id`);

--
-- Chỉ mục cho bảng `ht_amenities`
--
ALTER TABLE `ht_amenities`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_amenities_translations`
--
ALTER TABLE `ht_amenities_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_amenities_id`);

--
-- Chỉ mục cho bảng `ht_bookings`
--
ALTER TABLE `ht_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ht_bookings_booking_number_unique` (`booking_number`);

--
-- Chỉ mục cho bảng `ht_booking_addresses`
--
ALTER TABLE `ht_booking_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_booking_foods`
--
ALTER TABLE `ht_booking_foods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ht_booking_foods_booking_id_food_id_unique` (`booking_id`,`food_id`),
  ADD KEY `ht_booking_foods_booking_id_index` (`booking_id`),
  ADD KEY `ht_booking_foods_food_id_index` (`food_id`);

--
-- Chỉ mục cho bảng `ht_booking_rooms`
--
ALTER TABLE `ht_booking_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_booking_services`
--
ALTER TABLE `ht_booking_services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_coupons`
--
ALTER TABLE `ht_coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ht_coupons_code_unique` (`code`);

--
-- Chỉ mục cho bảng `ht_currencies`
--
ALTER TABLE `ht_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_customers`
--
ALTER TABLE `ht_customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ht_customers_email_unique` (`email`);

--
-- Chỉ mục cho bảng `ht_customer_password_resets`
--
ALTER TABLE `ht_customer_password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `ht_features`
--
ALTER TABLE `ht_features`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_features_translations`
--
ALTER TABLE `ht_features_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_features_id`);

--
-- Chỉ mục cho bảng `ht_foods`
--
ALTER TABLE `ht_foods`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_foods_translations`
--
ALTER TABLE `ht_foods_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_foods_id`);

--
-- Chỉ mục cho bảng `ht_food_types`
--
ALTER TABLE `ht_food_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_food_types_translations`
--
ALTER TABLE `ht_food_types_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_food_types_id`);

--
-- Chỉ mục cho bảng `ht_ical_sync_logs`
--
ALTER TABLE `ht_ical_sync_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ht_ical_sync_logs_room_id_index` (`room_id`),
  ADD KEY `ht_ical_sync_logs_calendar_id_index` (`calendar_id`);

--
-- Chỉ mục cho bảng `ht_invoices`
--
ALTER TABLE `ht_invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ht_invoices_code_unique` (`code`),
  ADD KEY `ht_invoices_reference_type_reference_id_index` (`reference_type`,`reference_id`),
  ADD KEY `ht_invoices_payment_id_index` (`payment_id`),
  ADD KEY `ht_invoices_status_index` (`status`),
  ADD KEY `ht_invoices_customer_id_index` (`customer_id`);

--
-- Chỉ mục cho bảng `ht_invoice_items`
--
ALTER TABLE `ht_invoice_items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_places`
--
ALTER TABLE `ht_places`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_places_translations`
--
ALTER TABLE `ht_places_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_places_id`);

--
-- Chỉ mục cho bảng `ht_products`
--
ALTER TABLE `ht_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `ht_products_translations`
--
ALTER TABLE `ht_products_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_products_id`);

--
-- Chỉ mục cho bảng `ht_product_categories`
--
ALTER TABLE `ht_product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_product_categories_translations`
--
ALTER TABLE `ht_product_categories_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_product_categories_id`);

--
-- Chỉ mục cho bảng `ht_product_orders`
--
ALTER TABLE `ht_product_orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_product_order_items`
--
ALTER TABLE `ht_product_order_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_unique_product_booking` (`product_id`,`service_date`,`service_time`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `ht_rooms`
--
ALTER TABLE `ht_rooms`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_rooms_amenities`
--
ALTER TABLE `ht_rooms_amenities`
  ADD PRIMARY KEY (`amenity_id`,`room_id`),
  ADD KEY `ht_rooms_amenities_amenity_id_index` (`amenity_id`),
  ADD KEY `ht_rooms_amenities_room_id_index` (`room_id`);

--
-- Chỉ mục cho bảng `ht_rooms_translations`
--
ALTER TABLE `ht_rooms_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_rooms_id`);

--
-- Chỉ mục cho bảng `ht_room_calendars`
--
ALTER TABLE `ht_room_calendars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ht_room_calendars_room_id_index` (`room_id`);

--
-- Chỉ mục cho bảng `ht_room_categories`
--
ALTER TABLE `ht_room_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_room_categories_translations`
--
ALTER TABLE `ht_room_categories_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_room_categories_id`);

--
-- Chỉ mục cho bảng `ht_room_dates`
--
ALTER TABLE `ht_room_dates`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_services`
--
ALTER TABLE `ht_services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ht_services_translations`
--
ALTER TABLE `ht_services_translations`
  ADD PRIMARY KEY (`lang_code`,`ht_services_id`);

--
-- Chỉ mục cho bảng `ht_taxes`
--
ALTER TABLE `ht_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`lang_id`),
  ADD KEY `lang_locale_index` (`lang_locale`),
  ADD KEY `lang_code_index` (`lang_code`),
  ADD KEY `lang_is_default_index` (`lang_is_default`);

--
-- Chỉ mục cho bảng `language_meta`
--
ALTER TABLE `language_meta`
  ADD PRIMARY KEY (`lang_meta_id`),
  ADD KEY `language_meta_reference_id_index` (`reference_id`),
  ADD KEY `meta_code_index` (`lang_meta_code`),
  ADD KEY `meta_origin_index` (`lang_meta_origin`),
  ADD KEY `meta_reference_type_index` (`reference_type`);

--
-- Chỉ mục cho bảng `media_files`
--
ALTER TABLE `media_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_files_user_id_index` (`user_id`),
  ADD KEY `media_files_index` (`folder_id`,`user_id`,`created_at`);

--
-- Chỉ mục cho bảng `media_folders`
--
ALTER TABLE `media_folders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_folders_user_id_index` (`user_id`),
  ADD KEY `media_folders_index` (`parent_id`,`user_id`,`created_at`);

--
-- Chỉ mục cho bảng `media_settings`
--
ALTER TABLE `media_settings`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `menu_locations`
--
ALTER TABLE `menu_locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_locations_menu_id_created_at_index` (`menu_id`,`created_at`);

--
-- Chỉ mục cho bảng `menu_nodes`
--
ALTER TABLE `menu_nodes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_nodes_menu_id_index` (`menu_id`),
  ADD KEY `menu_nodes_parent_id_index` (`parent_id`),
  ADD KEY `reference_id` (`reference_id`),
  ADD KEY `reference_type` (`reference_type`);

--
-- Chỉ mục cho bảng `meta_boxes`
--
ALTER TABLE `meta_boxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_boxes_reference_id_index` (`reference_id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `pages_translations`
--
ALTER TABLE `pages_translations`
  ADD PRIMARY KEY (`lang_code`,`pages_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_status_index` (`status`),
  ADD KEY `posts_author_id_index` (`author_id`),
  ADD KEY `posts_author_type_index` (`author_type`),
  ADD KEY `posts_created_at_index` (`created_at`);

--
-- Chỉ mục cho bảng `posts_translations`
--
ALTER TABLE `posts_translations`
  ADD PRIMARY KEY (`lang_code`,`posts_id`);

--
-- Chỉ mục cho bảng `post_categories`
--
ALTER TABLE `post_categories`
  ADD KEY `post_categories_category_id_index` (`category_id`),
  ADD KEY `post_categories_post_id_index` (`post_id`);

--
-- Chỉ mục cho bảng `post_tags`
--
ALTER TABLE `post_tags`
  ADD KEY `post_tags_tag_id_index` (`tag_id`),
  ADD KEY `post_tags_post_id_index` (`post_id`);

--
-- Chỉ mục cho bảng `revisions`
--
ALTER TABLE `revisions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `revisions_revisionable_id_revisionable_type_index` (`revisionable_id`,`revisionable_type`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`),
  ADD KEY `roles_created_by_index` (`created_by`),
  ADD KEY `roles_updated_by_index` (`updated_by`);

--
-- Chỉ mục cho bảng `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_users_user_id_index` (`user_id`),
  ADD KEY `role_users_role_id_index` (`role_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Chỉ mục cho bảng `simple_sliders`
--
ALTER TABLE `simple_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `simple_sliders_translations`
--
ALTER TABLE `simple_sliders_translations`
  ADD PRIMARY KEY (`lang_code`,`simple_sliders_id`),
  ADD KEY `idx_simple_sliders_translations_slider` (`simple_sliders_id`),
  ADD KEY `idx_simple_sliders_translations_slider_lang` (`simple_sliders_id`,`lang_code`);

--
-- Chỉ mục cho bảng `simple_slider_items`
--
ALTER TABLE `simple_slider_items`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `simple_slider_items_translations`
--
ALTER TABLE `simple_slider_items_translations`
  ADD PRIMARY KEY (`lang_code`,`simple_slider_items_id`),
  ADD KEY `idx_simple_slider_items_translations_item` (`simple_slider_items_id`),
  ADD KEY `idx_simple_slider_items_translations_item_lang` (`simple_slider_items_id`,`lang_code`);

--
-- Chỉ mục cho bảng `slugs`
--
ALTER TABLE `slugs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slugs_reference_id_index` (`reference_id`),
  ADD KEY `slugs_key_index` (`key`),
  ADD KEY `slugs_prefix_index` (`prefix`),
  ADD KEY `slugs_reference_index` (`reference_id`,`reference_type`);

--
-- Chỉ mục cho bảng `slugs_translations`
--
ALTER TABLE `slugs_translations`
  ADD PRIMARY KEY (`lang_code`,`slugs_id`);

--
-- Chỉ mục cho bảng `social_logins`
--
ALTER TABLE `social_logins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `social_logins_provider_provider_id_unique` (`provider`,`provider_id`),
  ADD KEY `social_logins_user_type_user_id_index` (`user_type`,`user_id`),
  ADD KEY `social_logins_user_id_user_type_index` (`user_id`,`user_type`);

--
-- Chỉ mục cho bảng `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tags_translations`
--
ALTER TABLE `tags_translations`
  ADD PRIMARY KEY (`lang_code`,`tags_id`);

--
-- Chỉ mục cho bảng `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `teams_translations`
--
ALTER TABLE `teams_translations`
  ADD PRIMARY KEY (`lang_code`,`teams_id`);

--
-- Chỉ mục cho bảng `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `testimonials_translations`
--
ALTER TABLE `testimonials_translations`
  ADD PRIMARY KEY (`lang_code`,`testimonials_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Chỉ mục cho bảng `user_meta`
--
ALTER TABLE `user_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_meta_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `widgets`
--
ALTER TABLE `widgets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `activations`
--
ALTER TABLE `activations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ai_training_contexts`
--
ALTER TABLE `ai_training_contexts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ai_translation_logs`
--
ALTER TABLE `ai_translation_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `audit_histories`
--
ALTER TABLE `audit_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `contact_custom_fields`
--
ALTER TABLE `contact_custom_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contact_custom_field_options`
--
ALTER TABLE `contact_custom_field_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `contact_replies`
--
ALTER TABLE `contact_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `dashboard_widgets`
--
ALTER TABLE `dashboard_widgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `dashboard_widget_settings`
--
ALTER TABLE `dashboard_widget_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `faq_categories`
--
ALTER TABLE `faq_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `gallery_meta`
--
ALTER TABLE `gallery_meta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `ht_amenities`
--
ALTER TABLE `ht_amenities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `ht_bookings`
--
ALTER TABLE `ht_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_booking_addresses`
--
ALTER TABLE `ht_booking_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_booking_foods`
--
ALTER TABLE `ht_booking_foods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ht_booking_rooms`
--
ALTER TABLE `ht_booking_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_booking_services`
--
ALTER TABLE `ht_booking_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_coupons`
--
ALTER TABLE `ht_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_currencies`
--
ALTER TABLE `ht_currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `ht_customers`
--
ALTER TABLE `ht_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_features`
--
ALTER TABLE `ht_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `ht_foods`
--
ALTER TABLE `ht_foods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_food_types`
--
ALTER TABLE `ht_food_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_ical_sync_logs`
--
ALTER TABLE `ht_ical_sync_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ht_invoices`
--
ALTER TABLE `ht_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_invoice_items`
--
ALTER TABLE `ht_invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_places`
--
ALTER TABLE `ht_places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `ht_products`
--
ALTER TABLE `ht_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_product_categories`
--
ALTER TABLE `ht_product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_product_orders`
--
ALTER TABLE `ht_product_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_product_order_items`
--
ALTER TABLE `ht_product_order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `ht_rooms`
--
ALTER TABLE `ht_rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `ht_room_calendars`
--
ALTER TABLE `ht_room_calendars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ht_room_categories`
--
ALTER TABLE `ht_room_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `ht_room_dates`
--
ALTER TABLE `ht_room_dates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ht_services`
--
ALTER TABLE `ht_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `ht_taxes`
--
ALTER TABLE `ht_taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `languages`
--
ALTER TABLE `languages`
  MODIFY `lang_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `language_meta`
--
ALTER TABLE `language_meta`
  MODIFY `lang_meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT cho bảng `media_files`
--
ALTER TABLE `media_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `media_folders`
--
ALTER TABLE `media_folders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `media_settings`
--
ALTER TABLE `media_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `menu_locations`
--
ALTER TABLE `menu_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `menu_nodes`
--
ALTER TABLE `menu_nodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT cho bảng `meta_boxes`
--
ALTER TABLE `meta_boxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT cho bảng `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `revisions`
--
ALTER TABLE `revisions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=909;

--
-- AUTO_INCREMENT cho bảng `simple_sliders`
--
ALTER TABLE `simple_sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `simple_slider_items`
--
ALTER TABLE `simple_slider_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `slugs`
--
ALTER TABLE `slugs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT cho bảng `social_logins`
--
ALTER TABLE `social_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `user_meta`
--
ALTER TABLE `user_meta`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT cho bảng `widgets`
--
ALTER TABLE `widgets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `ai_translation_logs`
--
ALTER TABLE `ai_translation_logs`
  ADD CONSTRAINT `ai_translation_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `ht_products`
--
ALTER TABLE `ht_products`
  ADD CONSTRAINT `ht_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `ht_product_categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `ht_product_order_items`
--
ALTER TABLE `ht_product_order_items`
  ADD CONSTRAINT `ht_product_order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `ht_product_orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ht_product_order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `ht_products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
