{{-- Hộp đặt phòng nhanh đứng riêng: đè lên hero ở trang chủ, dùng được cho trang khác --}}
@php
    $trustItems = array_values(array_filter(array_map('trim', explode(';', (string) $shortcode->trust_items))));
@endphp

@include(Theme::getThemeNamespace('partials.shortcodes.includes.booking-box'), [
    'variant' => 'hero',
    'buttonLabel' => $shortcode->button_label,
    'promoEnabled' => $shortcode->promo_enabled !== '0',
    'trustItems' => $trustItems,
    'boxTitle' => null,
])
