{{-- Khối video: căn trái/phải kèm nội dung, hoặc phủ kín màn hình làm hero --}}
@php
    $layout = in_array($shortcode->layout, ['left', 'right', 'full'], true) ? $shortcode->layout : 'left';
    $isFull = $layout === 'full';

    $videoFile = $shortcode->video_file ? RvMedia::url($shortcode->video_file) : null;
    $youtubeId = $shortcode->youtube_video_id;
    $poster = $shortcode->poster_image ? RvMedia::getImageUrl($shortcode->poster_image) : null;

    // Mark giữa video chỉ dùng cho bố cục full, chưa chọn ảnh thì lấy logo demo trong theme
    $watermark = $isFull && $shortcode->watermark_enabled !== '0'
        ? ($shortcode->watermark_image
            ? RvMedia::getImageUrl($shortcode->watermark_image)
            : Theme::asset()->url('images/mlb-demo/logo-main-video.png'))
        : null;

    $heights = ['full' => '100svh', 'tall' => '80vh', 'medium' => '62vh'];
    $stageHeight = Arr::get($heights, $shortcode->height ?: 'full', '100svh');

    $overlay = $shortcode->overlay_opacity;
    $scrim = $overlay === null || $overlay === '' ? ($isFull ? 35 : 0) : (int) $overlay;
    $scrim = max(0, min(90, $scrim)) / 100;

    $hasText = $shortcode->subtitle || $shortcode->title || $shortcode->description;
    $hasMedia = $videoFile || $youtubeId || $poster;

    // chỉ giữ chỗ hộp đặt phòng khi khối này thật sự hiện ra
    $showBooking = $hasMedia && malibu_booking_box_enabled($shortcode->show_booking);
@endphp

@if ($hasMedia)
    <section class="mlb-video mlb-video--{{ $isFull ? 'full' : 'split' }} mlb-video--media-{{ $layout }}"
             style="--mlb-video-h: {{ $stageHeight }}; --mlb-video-scrim: {{ $scrim }}">

        @if ($isFull)
            <div class="mlb-video__stage">
                @include(Theme::getThemeNamespace('partials.shortcodes.video-section.player'), [
                    'background' => true,
                    'videoFile' => $videoFile,
                    'youtubeId' => $youtubeId,
                    'poster' => $poster,
                ])

                <span class="mlb-video__scrim" aria-hidden="true"></span>

                @if ($watermark)
                    <img class="mlb-video__mark" src="{{ $watermark }}" alt="{{ $shortcode->title ?: '' }}" loading="lazy">
                @endif

                @if ($hasText)
                    <div class="mlb-video__overlay">
                        <div class="mlb-shell">
                            @if ($subtitle = $shortcode->subtitle)
                                <p class="mlb-eyebrow">{{ $subtitle }}</p>
                            @endif

                            @if ($title = $shortcode->title)
                                <h2 class="mlb-display">{!! BaseHelper::clean($title) !!}</h2>
                            @endif

                            @if ($description = $shortcode->description)
                                <p class="mlb-lede">{!! BaseHelper::clean($description) !!}</p>
                            @endif

                            @if (($buttonLabel = $shortcode->button_label) && ($buttonUrl = $shortcode->button_url))
                                <a class="mlb-btn" href="{{ $buttonUrl }}">{{ $buttonLabel }}</a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @else
            <div class="mlb-shell">
                <div class="mlb-video__grid">
                    <div class="mlb-video__media">
                        @include(Theme::getThemeNamespace('partials.shortcodes.video-section.player'), [
                            'background' => false,
                            'videoFile' => $videoFile,
                            'youtubeId' => $youtubeId,
                            'poster' => $poster,
                        ])
                    </div>

                    <div class="mlb-video__content">
                        @if ($subtitle = $shortcode->subtitle)
                            <p class="mlb-eyebrow">{{ $subtitle }}</p>
                        @endif

                        @if ($title = $shortcode->title)
                            <h2 class="mlb-display mlb-display--sm">{!! BaseHelper::clean($title) !!}</h2>
                        @endif

                        @if ($description = $shortcode->description)
                            <div class="mlb-video__text">{!! BaseHelper::clean($description) !!}</div>
                        @endif

                        @if (($buttonLabel = $shortcode->button_label) && ($buttonUrl = $shortcode->button_url))
                            <a class="mlb-btn" href="{{ $buttonUrl }}">{{ $buttonLabel }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </section>

    {{-- hộp đặt phòng luôn nằm ngoài khung video, không bao giờ đè lên hình --}}
    @if ($showBooking)
        @include(Theme::getThemeNamespace('partials.shortcodes.includes.booking-box'), [
            'variant' => 'video',
            'buttonLabel' => $shortcode->booking_button_label,
            'promoEnabled' => $shortcode->booking_promo_enabled === '1',
            'trustItems' => array_values(array_filter(array_map('trim', explode(';', (string) $shortcode->booking_trust_items)))),
            'boxTitle' => $shortcode->booking_title ?: null,
        ])
    @endif
@endif
