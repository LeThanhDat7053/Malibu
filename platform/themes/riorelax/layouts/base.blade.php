<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, user-scalable=1" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family={{ urlencode(theme_option('primary_font', 'Epilogue')) }}:400,500,600,700" rel="stylesheet" type="text/css">

    {{-- Display serif used by the Malibu homepage headings --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet" type="text/css">

    <style>
        @php
            // Nút "Đặt phòng" nổi ở cạnh màn hình. Các sắc độ đậm hơn của bảng đặt phòng
            // được tính ra từ chính màu nền, khỏi bắt người dùng chọn thêm màu nào nữa.
            // Color picker lưu cả '#rrggbb' lẫn 'rgb(r, g, b)' nên phải đọc được cả hai.
            $parseColor = function (?string $color): array {
                $color = trim((string) $color);

                if (preg_match('/^#?([0-9a-f]{3})$/i', $color, $matches)) {
                    [$r, $g, $b] = str_split($matches[1]);

                    return [hexdec($r . $r), hexdec($g . $g), hexdec($b . $b)];
                }

                if (preg_match('/^#?([0-9a-f]{6})$/i', $color, $matches)) {
                    return array_map('hexdec', str_split($matches[1], 2));
                }

                if (preg_match('/(\d+)\D+(\d+)\D+(\d+)/', $color, $matches)) {
                    return [(int) $matches[1], (int) $matches[2], (int) $matches[3]];
                }

                return [14, 77, 151];
            };

            $shadeColor = fn (array $rgb, float $factor) => sprintf(
                '#%02x%02x%02x',
                ...array_map(fn ($channel) => (int) max(0, min(255, $channel * $factor)), $rgb)
            );

            // Nền bảng lấy sắc đậm của màu chính để chữ trắng còn đọc được
            $bookingPanelBg = theme_option('booking_panel_bg_color') ?: theme_option('primary_color_hover', '#066a4c');
            $bookingPanelRgb = $parseColor($bookingPanelBg);
            $bookingPanelBgDark = $shadeColor($bookingPanelRgb, .78);
            $bookingPanelBgDarker = $shadeColor($bookingPanelRgb, .56);
            $bookingPanelBgDarkest = $shadeColor($bookingPanelRgb, .38);
        @endphp
        :root {
            {{-- chưa đặt riêng thì nút đặt phòng lấy màu chính của theme --}}
            --booking-btn-bg: {{ theme_option('booking_button_bg_color') ?: theme_option('primary_color', '#fec201') }};
            --booking-btn-text: {{ theme_option('booking_button_text_color', '#ffffff') }};
            --booking-btn-bg-hover: {{ theme_option('booking_button_hover_bg_color') ?: theme_option('primary_color_hover', '#066a4c') }};
            --booking-panel-bg: {{ $bookingPanelBg }};
            --booking-panel-bg-dark: {{ $bookingPanelBgDark }};
            --booking-panel-bg-darker: {{ $bookingPanelBgDarker }};
            --booking-panel-bg-darkest: {{ $bookingPanelBgDarkest }};
            --primary-color: {{ theme_option('primary_color', '#fec201') }};
            --secondary-color: {{ theme_option('secondary_color', '#034460') }};
            --input-border-color: {{ theme_option('input_border_color', '#d7cfc8') }};
            --primary-color-hover: {{ theme_option('primary_color_hover', '#066a4c') }};
            --btn-text-color-hover: {{ theme_option('button_text_color_hover', '#101010') }};
            --heading-font: '{{ theme_option('heading_font', 'Jost') }}', sans-serif;
            --primary-font: '{{ theme_option('primary_font', 'Roboto') }}', sans-serif;
        }

        /* Restore list styles inside CKEditor content globally */
        .ck-content ul {
            list-style: disc;
            padding-left: 20px;
            margin-bottom: 15px;
        }
        .ck-content ol {
            list-style: decimal;
            padding-left: 20px;
            margin-bottom: 15px;
        }
        .ck-content ul li,
        .ck-content ol li {
            list-style: inherit;
            margin-bottom: 5px;
            line-height: 1.6;
        }
        .ck-content ul ul { list-style: circle; }
        .ck-content ul ul ul { list-style: square; }
    </style>
    {!! Theme::header() !!}
    {!! Theme::partial('preloader') !!}
</head>
<body @if (BaseHelper::isRtlEnabled()) dir="rtl" @endif>
{!! apply_filters(THEME_FRONT_BODY, null) !!}

@yield('main')

{!! Theme::partial('popup-banner') !!}

{!! Theme::footer() !!}

{{-- Booking Services Chat Bot --}}
{{-- <script id="chat-init" src="https://app.link360.vn/account/js/init.js?id=5740347"></script> --}}
@if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
    <script type="text/javascript">
        $(document).ready(function () {
            @if (session()->has('success_msg'))
                RiorelaxTheme.showSuccess('{{ session('success_msg') }}');
            @endif

            @if (session()->has('error_msg'))
                RiorelaxTheme.showError('{{ session('error_msg') }}');
            @endif

            @if (isset($error_msg))
                RiorelaxTheme.showError('{{ $error_msg }}');
            @endif

            @if (isset($errors))
                @foreach ($errors->all() as $error)
                    RiorelaxTheme.showError('{!! BaseHelper::clean($error) !!}');
                @endforeach
            @endif
        });
    </script>
@endif
</body>
</html>
