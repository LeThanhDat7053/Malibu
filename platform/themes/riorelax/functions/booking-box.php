<?php

use Botble\Theme\Facades\Theme;

// Hộp đặt phòng nhanh: mỗi trang chỉ hiện một hộp, khối nằm trên cùng giữ chỗ trước
if (! function_exists('malibu_is_home_layout')) {
    function malibu_is_home_layout(): bool
    {
        return Theme::getLayoutName() === 'home';
    }
}

if (! function_exists('malibu_booking_slot_take')) {
    // Trả về true đúng một lần mỗi request, các khối gọi sau tự tắt hộp
    function malibu_booking_slot_take(): bool
    {
        static $taken = false;

        if ($taken) {
            return false;
        }

        return $taken = true;
    }
}

if (! function_exists('malibu_booking_box_enabled')) {
    // Ô tick trong simple-slider và video-section chỉ có tác dụng ở trang chủ
    function malibu_booking_box_enabled(mixed $flag): bool
    {
        return (string) $flag === '1' && malibu_is_home_layout() && malibu_booking_slot_take();
    }
}

if (! function_exists('malibu_booking_box_note')) {
    function malibu_booking_box_note(): string
    {
        return __('Only one quick booking box is rendered per page and only on the homepage - the block placed highest wins, the others switch themselves off.');
    }
}
