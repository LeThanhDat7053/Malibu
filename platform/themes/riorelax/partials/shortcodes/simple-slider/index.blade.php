@once
    <style>
        .slider-area .slider-active .single-slider.slider-bg .slider-content.s-slider-content {
            width: 100% !important;
            max-width: none !important;
            margin-inline: auto;
            padding-inline: 0 !important;
        }

        .slider-area .slider-active .single-slider.slider-bg .slider-text-banner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: clamp(8px, 1.2vw, 16px);
            width: 100%;
            max-width: 100%;
            position: absolute;
            left: 0;
            right: 0;
            top: 22%;
            transform: translateY(-50%);
            z-index: 2;
            padding: clamp(14px, 1.8vw, 26px) 0;
            background: rgba(32, 24, 20, 0.52);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }

        .slider-area .slider-active .single-slider.slider-bg .slider-text-banner-inner {
            width: min(100%, 1280px);
            margin: 0 auto;
            padding-inline: clamp(18px, 3vw, 48px);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: inherit;
        }

        .slider-area .slider-active .single-slider.slider-bg .slider-title {
            margin: 0;
            color: #f4b41a;
            font-size: clamp(22px, 3vw, 56px);
            line-height: 1.08;
            font-style: italic;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .slider-area .slider-active .single-slider.slider-bg .slider-description {
            margin: 0;
            color: #fff;
            font-size: clamp(24px, 3.5vw, 72px);
            line-height: 1.12;
            font-style: italic;
            font-weight: 700;
            text-wrap: balance;
        }

        .slider-area .slider-active .single-slider.slider-bg .slider-description * {
            color: inherit;
        }

        .slider-area .slider-active .single-slider.slider-bg .slider-btn {
            margin-top: clamp(16px, 2vw, 28px) !important;
            margin-bottom: 0 !important;
        }

        @media (min-width: 1025px) {
            .slider-area .slider-active .single-slider.slider-bg .slider-mobile-image {
                display: none !important;
            }

            .slider-area .slider-active .single-slider.slider-bg .container {
                position: absolute;
                inset: 0;
                z-index: 3;
                max-width: 100% !important;
                padding-inline: 0;
                display: flex;
                align-items: flex-start;
                justify-content: center;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-content.s-slider-content {
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                padding-top: clamp(80px, 15vh, 180px) !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                position: static;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-text-banner {
                position: static;
                inset: auto;
                transform: none;
            }

            .slider-area .slider-active .single-slider.slider-bg .row,
            .slider-area .slider-active .single-slider.slider-bg [class*="col-"] {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .slider-area {
                padding-top: 110px;
                background: #000 !important;
            }

            .slider-area .slider-active .single-slider.slider-bg .container,
            .slider-area .slider-active .single-slider.slider-bg .row,
            .slider-area .slider-active .single-slider.slider-bg [class*="col-"] {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
            }

            .slider-area .slider-active,
            .slider-area .slider-active .single-slider.slider-bg {
                background-color: #000 !important;
            }

            .slider-area .slider-active:not(.slick-initialized) .single-slider.slider-bg {
                display: none !important;
            }

            .slider-area .slider-active:not(.slick-initialized) .single-slider.slider-bg:first-child {
                display: flex !important;
            }

            .slider-area .slider-active .single-slider.slider-bg {
                min-height: 320px !important;
                height: 36vh !important;
                max-height: 420px !important;
                display: block !important;
                position: relative;
                background-color: #000 !important;
                overflow: hidden;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-mobile-image {
                display: block;
                width: 100%;
                height: 100%;
                min-height: 320px;
                max-height: 420px;
                object-fit: cover;
                object-position: center center;
            }

            .slider-area .slider-active .single-slider.slider-bg .container {
                position: absolute;
                inset: 0;
                z-index: 3;
                display: flex;
                align-items: flex-start;
                justify-content: center;
                padding-bottom: 0;
            }

            .slider-area .slider-active .single-slider.slider-bg .row {
                width: 100%;
            }

            .slider-area .slider-content.s-slider-content {
                width: 100%;
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                padding: 0 !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                position: static;
                padding-top: clamp(44px, 11vh, 92px) !important;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-text-banner {
                width: 100%;
                max-width: 100%;
                position: static;
                inset: auto;
                transform: none;
                padding: 16px 0;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-text-banner-inner {
                width: min(100%, 1000px);
                padding-inline: 20px;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-title {
                font-size: clamp(18px, 3vw, 34px) !important;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-description {
                font-size: clamp(22px, 4.2vw, 48px) !important;
                line-height: 1.15 !important;
            }

            .slider-area .slider-content.s-slider-content .slider-btn {
                margin-top: 18px !important;
                margin-bottom: 0 !important;
            }

            .slider-area .slider-active .slick-list,
            .slider-area .slider-active .slick-track,
            .slider-area .slider-active .slick-slide,
            .slider-area .slider-active .slick-slide > div {
                height: 36vh !important;
                min-height: 320px !important;
                max-height: 420px !important;
            }
        }

        @media (max-width: 767px) {
            .slider-area {
                padding-top: 110px;
                background: #000 !important;
            }

            .slider-area .slider-active .single-slider.slider-bg .container,
            .slider-area .slider-active .single-slider.slider-bg .row,
            .slider-area .slider-active .single-slider.slider-bg [class*="col-"] {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 0;
            }

            .slider-area .slider-active,
            .slider-area .slider-active .single-slider.slider-bg {
                background-color: #000 !important;
            }

            .slider-area .slider-active:not(.slick-initialized) .single-slider.slider-bg {
                display: none !important;
            }

            .slider-area .slider-active:not(.slick-initialized) .single-slider.slider-bg:first-child {
                display: flex !important;
            }

            .slider-area .slider-active .single-slider.slider-bg {
                min-height: 190px !important;
                height: 22vh !important;
                max-height: 240px !important;
                display: block !important;
                position: relative;
                background-color: #000 !important;
                overflow: hidden;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-mobile-image {
                display: block;
                width: 100%;
                height: 100%;
                min-height: 190px;
                max-height: 240px;
                object-fit: cover;
                object-position: center center;
            }

            .slider-area .slider-active .single-slider.slider-bg .container {
                position: absolute;
                inset: 0;
                z-index: 3;
                display: flex;
                align-items: flex-start;
                justify-content: center;
                padding-bottom: 0;
            }

            .slider-area .slider-active .single-slider.slider-bg .row {
                width: 100%;
            }

            .slider-area .slider-content.s-slider-content {
                width: 100%;
                margin-top: 0 !important;
                margin-bottom: 0 !important;
                padding: 0 !important;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                position: static;
                padding-top: clamp(16px, 6vh, 40px) !important;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-text-banner {
                width: 100%;
                max-width: 100%;
                position: static;
                inset: auto;
                transform: none;
                gap: 6px;
                padding: 10px 0;
                background: rgba(32, 24, 20, 0.58);
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-text-banner-inner {
                width: 100%;
                padding-inline: 10px;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-title {
                font-size: clamp(12px, 3.1vw, 18px) !important;
                line-height: 1.15 !important;
            }

            .slider-area .slider-active .single-slider.slider-bg .slider-description {
                font-size: clamp(16px, 4.1vw, 24px) !important;
                line-height: 1.18 !important;
            }

            .slider-area .slider-content.s-slider-content .slider-btn {
                margin-top: 16px !important;
                margin-bottom: 0 !important;
            }

            .slider-area .slider-active .slick-list,
            .slider-area .slider-active .slick-track,
            .slider-area .slider-active .slick-slide,
            .slider-area .slider-active .slick-slide > div {
                height: 22vh !important;
                min-height: 190px !important;
                max-height: 240px !important;
            }
        }

        /* ===== Fix ảnh dọc (portrait) bị cắt mất phần trên ===== */

        /* Lớp nền mờ lấy chính ảnh của slide, lấp khoảng trống khi ảnh dọc dùng contain */
        .slider-area .slider-active .single-slider.slider-bg::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: inherit;
            background-size: cover;
            background-position: center center;
            filter: blur(28px) brightness(0.55);
            transform: scale(1.12);
            z-index: 0;
        }

        /* Ảnh thật hiển thị ở MỌI breakpoint (trước đây desktop bị display:none) */
        .slider-area .slider-active .single-slider.slider-bg .slider-mobile-image {
            display: block !important;
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            max-height: none;
            min-height: 0;
            object-fit: cover;
            object-position: center center;
            z-index: 1;
        }

        /* Ảnh dọc: hiện trọn ảnh, không cắt */
        .slider-area .slider-active .single-slider.slider-bg.is-portrait .slider-mobile-image {
            object-fit: contain;
            object-position: center center;
        }

        /* Chiều cao khung hợp lý thay cho min-height 1000px cứng của theme */
        .slider-area .slider-active .single-slider.slider-bg {
            min-height: 0 !important;
            height: clamp(460px, 76vh, 860px);
            background-position: center center !important;
            overflow: hidden;
        }

        .slider-area .slider-active .slick-list,
        .slider-area .slider-active .slick-track,
        .slider-area .slider-active .slick-slide,
        .slider-area .slider-active .slick-slide > div {
            height: clamp(460px, 76vh, 860px);
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .slider-area .slider-active .single-slider.slider-bg {
                height: 36vh !important;
                min-height: 320px !important;
                max-height: 420px !important;
            }
        }

        @media (max-width: 767px) {
            .slider-area .slider-active .single-slider.slider-bg {
                height: 22vh !important;
                min-height: 190px !important;
                max-height: 240px !important;
            }
        }

        /* ===== Chỉ trang chủ Malibu: banner chiếm trọn màn hình ===== */
        .mlb-home .slider-area .slider-active .single-slider.slider-bg,
        .mlb-home .slider-area .slider-active .slick-list,
        .mlb-home .slider-area .slider-active .slick-track,
        .mlb-home .slider-area .slider-active .slick-slide,
        .mlb-home .slider-area .slider-active .slick-slide > div {
            height: 100vh !important;
            height: 100svh !important;
            min-height: 0 !important;
            max-height: none !important;
        }

        .mlb-home .slider-area .slider-active .single-slider.slider-bg .slider-mobile-image {
            min-height: 0 !important;
            max-height: none !important;
        }

        @media (max-width: 1024px) {
            .mlb-home .slider-area {
                padding-top: 0 !important;
            }
        }

        /* Số thứ tự slide ở cạnh phải */
        .mlb-home .slider-area .mlb-hero-count {
            position: absolute;
            z-index: 5;
            inset-inline-end: clamp(20px, 2.6vw, 52px);
            /* ngồi ngay trên mép hộp booking đang đè vào hero */
            bottom: calc(var(--mlb-hero-strip, 200px) + clamp(20px, 2.4vw, 36px));
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 14px;
        }

        .mlb-home .slider-area .mlb-hero-count button {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0;
            border: 0;
            background: none;
            cursor: pointer;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.55);
            transition: color 0.25s ease;
        }

        .mlb-home .slider-area .mlb-hero-count button::before {
            content: '';
            width: 22px;
            height: 1px;
            background: currentColor;
            transition: width 0.25s ease, background 0.25s ease;
        }

        .mlb-home .slider-area .mlb-hero-count button:hover,
        .mlb-home .slider-area .mlb-hero-count button.is-active {
            color: #fff;
        }

        .mlb-home .slider-area .mlb-hero-count button.is-active::before {
            width: 46px;
            background: var(--mlb-accent, #e2711d);
        }

        @media (max-width: 767px) {
            .mlb-home .slider-area .mlb-hero-count {
                display: none;
            }
        }
    </style>
@endonce

<section id="home" class="slider-area fix p-relative">
    <div class="slider-active" style="background: #101010;">
        @foreach($sliders as $slider)
            <div
                class="single-slider slider-bg d-flex align-items-center"
                style="background-image:url({{ RvMedia::getImageUrl($slider->image) }});"
            >
                <img
                    class="slider-mobile-image"
                    src="{{ RvMedia::getImageUrl($slider->image) }}"
                    alt="{{ $slider->title ?: 'Slider image' }}"
                >
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12">
                            <div class="slider-content s-slider-content mt-80 text-center">
                                @if ($slider->title || $slider->description)
                                    <div class="slider-text-banner" data-animation="fadeIn" data-delay=".4s">
                                        <div class="slider-text-banner-inner">
                                            @if ($title = $slider->title)
                                                <h2 class="slider-title">{!! BaseHelper::clean($title) !!}</h2>
                                            @endif

                                            @if ($description = $slider->description)
                                                <p class="slider-description">{!! BaseHelper::clean($description) !!}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="slider-btn mt-30 mb-105">
                                    @php
                                        $buttonPrimaryLabel = $slider->getMetaData('button_primary_label', true);
                                        $buttonPrimaryUrl = $slider->getMetaData('button_primary_url', true);
                                        $buttonPlayLabel = $slider->getMetaData('button_play_label', true);
                                        $linkYoutubeUrl = $slider->getMetaData('youtube_url', true);

                                        if ($linkYoutubeUrl) {
                                            $linkYoutubeUrl = Botble\Theme\Supports\Youtube::getYoutubeVideoID($linkYoutubeUrl);
                                        }

                                    @endphp

                                    @if ($buttonPrimaryUrl && $buttonPrimaryLabel)
                                        <a href="{{ $buttonPrimaryUrl }}" class="btn ss-btn active mr-15" data-animation="fadeInLeft" data-delay=".4s">
                                            {!! BaseHelper::clean($buttonPrimaryLabel) !!}
                                        </a>
                                    @endif

                                    @if ($buttonPlayLabel && $linkYoutubeUrl)
                                        <a href="https://www.youtube.com/watch?v={{ $linkYoutubeUrl }}" class="video-i popup-video" data-animation="fadeInUp" data-delay=".8s" style="animation-delay: 0.8s;" tabindex="0">
                                            <i class="fas fa-play"></i>
                                            {!! BaseHelper::clean($buttonPlayLabel) !!}
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- số thứ tự slide, dựng bằng JS sau khi slick khởi tạo --}}
    <div class="mlb-hero-count" data-mlb-hero-count></div>
</section>

@once
    <script>
        (function () {
            function markOrientation(img) {
                if (!img.naturalWidth || !img.naturalHeight) return;
                var slide = img.closest('.single-slider.slider-bg');
                if (!slide) return;
                // Ảnh cao hơn rộng (hoặc gần vuông) => hiển thị trọn ảnh, không cắt
                slide.classList.toggle('is-portrait', img.naturalHeight / img.naturalWidth > 0.9);
            }

            function run() {
                document
                    .querySelectorAll('.slider-area .single-slider.slider-bg .slider-mobile-image')
                    .forEach(function (img) {
                        if (img.complete) {
                            markOrientation(img);
                        } else {
                            img.addEventListener('load', function () { markOrientation(img); }, { once: true });
                        }
                    });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', run);
            } else {
                run();
            }
        })();
    </script>

    {{-- rail số thứ tự slide ở cạnh phải, đồng bộ với slick --}}
    <script>
        (function () {
            function pad(n) { return (n < 10 ? '0' : '') + n; }

            function build() {
                var $slider = window.jQuery('.mlb-home .slider-area .slider-active');
                var nav = document.querySelector('.mlb-home [data-mlb-hero-count]');
                if (!nav || !$slider.length) return;

                var total = $slider.find('.single-slider').not('.slick-cloned').length;
                if (total < 2) return;

                nav.innerHTML = '';
                for (var i = 0; i < total; i++) {
                    var btn = document.createElement('button');
                    btn.type = 'button';
                    btn.textContent = pad(i + 1);
                    btn.setAttribute('aria-label', 'Slide ' + (i + 1));
                    btn.dataset.index = i;
                    nav.appendChild(btn);
                }

                function setActive(index) {
                    nav.querySelectorAll('button').forEach(function (b) {
                        b.classList.toggle('is-active', Number(b.dataset.index) === index);
                    });
                }

                nav.addEventListener('click', function (e) {
                    var btn = e.target.closest('button');
                    if (btn) $slider.slick('slickGoTo', Number(btn.dataset.index));
                });

                $slider.on('afterChange', function (e, slick, current) { setActive(current); });
                setActive($slider.slick('slickCurrentSlide') || 0);
            }

            function wait(tries) {
                var el = document.querySelector('.mlb-home .slider-area .slider-active');
                if (window.jQuery && el && el.classList.contains('slick-initialized')) return build();
                if (tries < 80) setTimeout(function () { wait(tries + 1); }, 100);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function () { wait(0); });
            } else {
                wait(0);
            }
        })();
    </script>
@endonce
