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
@endonce
