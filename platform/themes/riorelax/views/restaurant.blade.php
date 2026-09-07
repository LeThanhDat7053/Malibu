@php
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;

    // Layout full-width + headerClass 'mlb-header': navbar mờ đè lên banner giống trang chủ mới.
    Theme::layout('full-width');
    Theme::set('headerClass', 'mlb-header');
    Theme::set('pageTitle', $restaurant->name);
    // Banner riêng của trang nhà hàng thay cho breadcrumb dùng chung
    Theme::set('breadcrumb', false);

    $metaItems = collect($galleryItems ?? [])->filter(fn ($item) => filled(Arr::get($item, 'img')));

    // Cột videos của nhà hàng chứa cả video lẫn vr360 (xem RestaurantController::save),
    // gộp chung với lưới media rồi bỏ trùng theo URL — làm y như trang phòng.
    $mediaItems = $metaItems
        ->reject(fn ($item) => Arr::get($item, 'type', 'image') === 'image')
        ->merge(collect($restaurant->videos)->filter(fn ($item) => filled(Arr::get($item, 'img'))))
        ->unique(fn ($item) => Arr::get($item, 'img'));

    // Link nhập ở ô "VR360 tour URL" trong dashboard cũng là một ô của lưới và đứng đầu,
    // giống cách trang phòng đưa vr360_url thành slide đầu tiên.
    $vr360Items = collect([['img' => $restaurant->vr360_url, 'type' => 'vr360']])
        ->merge($mediaItems->filter(fn ($item) => Arr::get($item, 'type') === 'vr360'))
        ->filter(fn ($item) => filled(Arr::get($item, 'img')))
        ->unique(fn ($item) => Arr::get($item, 'img'));

    // Thiếu 'type' thì coi là video: dữ liệu cũ ở cột videos không ghi khoá này.
    $videoItems = $mediaItems->filter(fn ($item) => Arr::get($item, 'type', 'video') === 'video');

    $imageItems = $metaItems->filter(fn ($item) => Arr::get($item, 'type', 'image') === 'image');

    // Chưa có gì trong lưới media thì lấy tạm cột images cũ.
    if ($imageItems->isEmpty()) {
        $imageItems = collect($restaurant->images)
            ->filter()
            ->map(fn ($image) => ['img' => $image, 'type' => 'image']);
    }

    // Thứ tự ô: VR360 → video → ảnh, khớp thứ tự slide của trang phòng.
    $items = $vr360Items->concat($videoItems)->concat($imageItems);

    // Đưa URL bất kỳ về link xem được: link ngoài giữ nguyên, còn lại đi qua RvMedia.
    $rstUrl = fn ($url) => $url
        ? (Str::startsWith($url, ['http://', 'https://', '//']) ? $url : RvMedia::getImageUrl($url))
        : null;

    // Ô VR360 / video không có ảnh riêng thì mượn ảnh đầu tiên của nhà hàng làm nền,
    // giống poster dự phòng của slide VR360 bên trang phòng.
    $fallbackPoster = ($firstImage = Arr::first($imageItems->pluck('img')->all()))
        ? RvMedia::getImageUrl($firstImage)
        : null;

    // Mỗi ô của lưới gallery: ảnh, video (YouTube / Vimeo / file mp4) hoặc VR360.
    $galleryTiles = $items->map(function ($item) use ($rstUrl, $fallbackPoster) {
        $type = Arr::get($item, 'type', 'image');
        $url = Arr::get($item, 'img');
        $thumb = Arr::get($item, 'thumb');
        $description = Arr::get($item, 'description');

        if ($type === 'video') {
            $embed = null;

            if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $match)) {
                $embed = 'https://www.youtube.com/embed/' . $match[1] . '?autoplay=1&rel=0';
                $thumb = $thumb ?: 'https://img.youtube.com/vi/' . $match[1] . '/hqdefault.jpg';
            } elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $url, $match)) {
                $embed = 'https://player.vimeo.com/video/' . $match[1] . '?autoplay=1';
            }

            return [
                'type' => 'video',
                'preview' => $rstUrl($thumb) ?: $fallbackPoster,
                // không phải YouTube / Vimeo thì coi là file video phát thẳng
                'embed' => $embed,
                'file' => $embed ? null : $rstUrl($url),
                'description' => $description,
            ];
        }

        if ($type === 'vr360') {
            // Link tour 360 không phải ảnh nên không dùng làm nền được, trừ khi
            // chính nó là file ảnh panorama.
            $isPanoramaFile = Str::endsWith(Str::lower(Str::before($url, '?')), ['.jpg', '.jpeg', '.png', '.webp']);

            return [
                'type' => 'vr360',
                'preview' => $rstUrl($thumb) ?: ($isPanoramaFile ? $rstUrl($url) : $fallbackPoster),
                'link' => $url,
                'description' => $description,
            ];
        }

        return [
            'type' => 'image',
            'preview' => RvMedia::getImageUrl($url),
            'description' => $description,
        ];
    })->values();

    $banner = $restaurant->banner;

    // Ảnh nền banner: ảnh bìa của nhà hàng, không có thì lấy ảnh breadcrumb chung
    $heroImage = $banner
        ? RvMedia::getImageUrl($banner)
        : (($fallback = theme_option('breadcrumb_background_image'))
            ? RvMedia::getImageUrl($fallback)
            : Theme::asset()->url('images/breadcrumb-bg.jpg'));

    $menuImages = collect($restaurant->menu_images);

    // không lấy tên khách sạn làm phụ đề: trống thì bỏ hẳn dòng trên tiêu đề
    $subtitle = $restaurant->subtitle;
    $phone = $restaurant->phone ?: theme_option('hotline');

    $crumbs = collect(Theme::breadcrumb()->getCrumbs());

    // Khung giờ phục vụ hiển thị thành các ô dàn ngang trên nội dung
    $hourSlots = collect($restaurant->opening_hours_slots);

    // Dải thông tin căn giữa dưới nội dung
    $metaItems = collect([
        ['label' => trans('plugins/restaurant::restaurant.location'), 'value' => $restaurant->location],
        ['label' => trans('plugins/restaurant::restaurant.cuisine'), 'value' => $restaurant->cuisine],
        ['label' => trans('plugins/restaurant::restaurant.phone'), 'value' => $phone, 'tel' => true],
    ])->filter(fn ($item) => filled($item['value']))->values();
@endphp

<div class="mlb-page mlb-rst-page">

    {{-- 1. Banner ảnh trơn, navbar mờ đè lên --}}
    <div class="rst-hero" style="background-image: url('{{ $heroImage }}');"></div>

    {{-- 2. Tiêu đề --}}
    <div class="rst-title">
        @if ($subtitle)
            <div class="rst-title__label">{{ $subtitle }}</div>
        @endif
        <h1 class="rst-title__name">{{ $restaurant->name }}</h1>
        <div class="rst-divider"><span class="rst-diamond"></span></div>

        @if ($crumbs->count() > 1)
            <nav aria-label="breadcrumb">
                <ol class="rst-crumbs">
                    @foreach ($crumbs as $crumb)
                        @if (! $loop->last)
                            <li><a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a></li>
                        @else
                            <li aria-current="page">{{ $crumb['label'] }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        @endif
    </div>

    {{-- 3. Nút VR360 --}}
    @if ($restaurant->vr360_url)
        <div class="rst-vr">
            <a href="{{ $restaurant->vr360_url }}" target="_blank" rel="noopener noreferrer">
                <i class="fal fa-vr-cardboard"></i>
                {{ trans('plugins/restaurant::restaurant.view_vr360') }}
            </a>
        </div>
    @endif

    {{-- 4. Khung giờ phục vụ: mỗi khung một ô, dàn ngang căn giữa --}}
    @if ($hourSlots->isNotEmpty())
        <div class="rst-hours">
            @foreach ($hourSlots as $slot)
                <div class="rst-hours__item">
                    @if ($slot['label'])
                        <span class="rst-hours__name">{{ $slot['label'] }}</span>
                    @endif
                    <span class="rst-hours__time">{{ $slot['time'] }}</span>
                    @if ($slot['days'])
                        <span class="rst-hours__days">{{ $slot['days'] }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- 5. Nội dung --}}
    <div class="rst-content">
        @if ($restaurant->description)
            <p class="rst-content__lead">{{ $restaurant->description }}</p>
        @endif

        @if ($restaurant->content)
            <div class="ck-content">{!! BaseHelper::clean($restaurant->content) !!}</div>
        @endif

        {{-- Vị trí / ẩm thực / điện thoại, căn giữa dưới nội dung --}}
        @if ($metaItems->isNotEmpty())
            <ul class="rst-facts">
                @foreach ($metaItems as $item)
                    <li>
                        <span class="rst-facts__label">{{ $item['label'] }}</span>
                        <span class="rst-facts__value">
                            @if (Arr::get($item, 'tel'))
                                <a href="tel:{{ preg_replace('/\D+/', '', $item['value']) }}">{{ $item['value'] }}</a>
                            @else
                                {{-- dữ liệu cũ lưu sẵn '&amp;', không giải mã thì hiện ra nguyên chuỗi --}}
                                {{ html_entity_decode($item['value'], ENT_QUOTES | ENT_HTML5) }}
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- 6. Khung VR360 nhúng thẳng vào trang --}}
    @if ($restaurant->vr360_embed)
        <section class="rst-embed">
            <div class="rst-heading">
                <div class="rst-heading__line"><span class="rst-diamond"></span></div>
                <div class="rst-heading__sub">{{ $restaurant->name }}</div>
                <h2 class="rst-heading__main">VR360</h2>
            </div>
            <div class="rst-embed__frame">
                <iframe src="{{ $restaurant->vr360_embed }}" title="{{ $restaurant->name }} VR360"
                        loading="lazy" allowfullscreen></iframe>
            </div>
        </section>
    @endif

    {{-- 7. Gallery: ảnh + video + VR360 trong một lưới.
         Mỗi ô mang data-rst-item để lightbox gom thành một bộ, mở ra lướt qua lại được. --}}
    @if ($galleryTiles->isNotEmpty())
        <section class="rst-gallery">
            <div class="rst-heading">
                <div class="rst-heading__line"><span class="rst-diamond"></span></div>
                <div class="rst-heading__sub">{{ $restaurant->name }}</div>
                <h2 class="rst-heading__main">{{ trans('plugins/restaurant::restaurant.gallery_heading') }}</h2>
            </div>
            <div class="rst-gallery__grid" data-rst-gallery>
                @foreach ($galleryTiles as $tile)
                    @if ($tile['type'] === 'vr360')
                        {{-- VR360: nhúng thẳng tour vào lưới, kéo xoay được ngay không cần bấm.
                             iframe nuốt hết click nên nút phóng to phải tách riêng ở góc. --}}
                        <div class="rst-photo rst-photo--vr"
                             data-rst-item data-rst-kind="vr360"
                             data-rst-src="{{ $tile['link'] }}"
                             data-rst-caption="{{ $tile['description'] }}">
                            <iframe class="rst-photo__frame"
                                    src="{{ $tile['link'] }}"
                                    title="{{ $tile['description'] ?: trans('plugins/restaurant::restaurant.view_vr360') }}"
                                    loading="lazy"
                                    frameborder="0"
                                    allow="accelerometer; gyroscope; magnetometer; xr-spatial-tracking; fullscreen"
                                    allowfullscreen></iframe>
                            <span class="rst-photo__tag">VR360</span>
                            <div class="rst-photo__tools">
                                <button type="button" class="rst-photo__tool" data-rst-open
                                        aria-label="{{ __('View fullscreen') }}">
                                    <i class="fal fa-expand-arrows"></i>
                                </button>
                                {{-- lối thoát khi trang tour chặn nhúng iframe --}}
                                <a class="rst-photo__tool" href="{{ $tile['link'] }}" target="_blank"
                                   rel="noopener noreferrer" aria-label="{{ __('Open in new tab') }}">
                                    <i class="fal fa-external-link"></i>
                                </a>
                            </div>
                            @if ($tile['description'])
                                <span class="rst-photo__caption">{{ $tile['description'] }}</span>
                            @endif
                        </div>
                    @elseif ($tile['type'] === 'video')
                        <button type="button" class="rst-photo rst-photo--media"
                                data-rst-item data-rst-kind="video"
                                data-rst-src="{{ $tile['embed'] ?: $tile['file'] }}"
                                @if (! $tile['embed']) data-rst-file @endif
                                data-rst-caption="{{ $tile['description'] }}"
                                aria-label="{{ $tile['description'] ?: __('Video') }}">
                            @if ($tile['preview'])
                                <img src="{{ $tile['preview'] }}" alt="{{ $tile['description'] }}" loading="lazy">
                            @endif
                            <span class="rst-photo__play"><i class="fas fa-play"></i></span>
                            <span class="rst-photo__tag">Video</span>
                            @if ($tile['description'])
                                <span class="rst-photo__caption">{{ $tile['description'] }}</span>
                            @endif
                        </button>
                    @else
                        {{-- ảnh gốc: cỡ 'medium' (440x340) bị kéo giãn ở khổ này --}}
                        <div class="rst-photo"
                             data-rst-item data-rst-kind="image"
                             data-rst-src="{{ $tile['preview'] }}"
                             data-rst-caption="{{ $tile['description'] }}">
                            <img src="{{ $tile['preview'] }}"
                                 alt="{{ $tile['description'] ?: $restaurant->name }}" loading="lazy">
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    @endif

    {{-- 8. Our Menu: chỉ là ảnh thực đơn --}}
    @if ($menuImages->isNotEmpty())
        <section class="rst-menu">
            <div class="rst-heading rst-heading--light">
                <div class="rst-heading__line"><span class="rst-diamond"></span></div>
                <div class="rst-heading__sub">{{ $restaurant->name }}</div>
                <h2 class="rst-heading__main">{{ trans('plugins/restaurant::restaurant.our_menu') }}</h2>
                @if ($restaurant->menu_heading)
                    <div class="rst-heading__bottom"><span>{{ $restaurant->menu_heading }}</span></div>
                @endif
            </div>

            <div class="rst-carousel" data-rst-carousel>
                <div class="rst-carousel__stage">
                    @foreach ($menuImages as $image)
                        <div class="rst-carousel__item" data-rst-lightbox="{{ RvMedia::getImageUrl($image) }}">
                            <img src="{{ RvMedia::getImageUrl($image) }}"
                                 alt="{{ $restaurant->name }} — menu {{ $loop->iteration }}" loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($menuImages->count() > 1)
                <div class="rst-carousel__nav">
                    <button type="button" data-rst-prev aria-label="Previous">&#10094;</button>
                    <button type="button" data-rst-next aria-label="Next">&#10095;</button>
                </div>
            @endif
        </section>
    @endif

    {{-- 9. Các không gian khác --}}
    @if ($others->isNotEmpty())
        <section class="rst-others">
            <div class="mlb-shell">
                <div class="rst-heading">
                    <div class="rst-heading__line"><span class="rst-diamond"></span></div>
                    <div class="rst-heading__sub">{{ trans('plugins/restaurant::restaurant.explore') }}</div>
                    <h2 class="rst-heading__main">{{ trans('plugins/restaurant::restaurant.other_restaurants') }}</h2>
                </div>
                <div class="mlb-rst-grid">
                    @foreach ($others as $item)
                        {!! Theme::partial('restaurants.item', ['restaurant' => $item]) !!}
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- 10. CTA chốt trang: đặt bàn + thông tin liên hệ của chính nhà hàng này --}}
    @if ($phone || $restaurant->email)
        <section class="rst-cta" @if ($banner) style="background-image: url('{{ RvMedia::getImageUrl($banner) }}');" @endif>
            <div class="rst-cta__inner">
                <div class="rst-cta__eyebrow">{{ trans('plugins/restaurant::restaurant.reserve') }}</div>
                <h2 class="rst-cta__title">{{ $restaurant->name }}</h2>
                <div class="rst-divider"><span class="rst-diamond"></span></div>

                @if ($restaurant->description)
                    <p class="rst-cta__lede">{{ $restaurant->description }}</p>
                @endif

                @if ($hourSlots->isNotEmpty() || $restaurant->location)
                    <ul class="rst-cta__meta">
                        @foreach ($hourSlots as $slot)
                            <li>
                                <i class="fal fa-clock"></i>
                                {{ $slot['label'] ? $slot['label'] . ': ' : '' }}{{ $slot['time'] }}
                            </li>
                        @endforeach
                        @if ($restaurant->location)
                            <li><i class="fal fa-map-marker-alt"></i> {{ $restaurant->location }}</li>
                        @endif
                    </ul>
                @endif

                <div class="rst-cta__actions">
                    @if ($phone)
                        <a class="rst-cta__btn" href="tel:{{ preg_replace('/\D+/', '', $phone) }}">
                            <i class="fal fa-phone"></i>
                            <span>{{ $phone }}</span>
                        </a>
                    @endif

                    @if ($restaurant->email)
                        <a class="rst-cta__btn rst-cta__btn--ghost" href="mailto:{{ $restaurant->email }}">
                            <i class="fal fa-envelope"></i>
                            <span>{{ $restaurant->email }}</span>
                        </a>
                    @endif
                </div>
            </div>
        </section>
    @endif
</div>

{{-- Lightbox dùng chung cho gallery và ảnh menu --}}
<div class="rst-lightbox" data-rst-lightbox-root hidden>
    <button type="button" class="rst-lightbox__close" data-rst-lightbox-close aria-label="Close">&times;</button>

    {{-- lướt qua lại ngay trong lightbox, khỏi phải thoát ra bấm ô khác --}}
    <button type="button" class="rst-lightbox__nav rst-lightbox__nav--prev" data-rst-lightbox-prev
            aria-label="{{ __('Previous') }}" hidden><i class="fal fa-angle-left"></i></button>
    <button type="button" class="rst-lightbox__nav rst-lightbox__nav--next" data-rst-lightbox-next
            aria-label="{{ __('Next') }}" hidden><i class="fal fa-angle-right"></i></button>

    <img src="" alt="">
    {{-- khung video / tour: js đổ iframe hoặc thẻ video vào đây rồi dọn sạch khi đóng --}}
    <div class="rst-lightbox__media" data-rst-lightbox-media hidden></div>

    <div class="rst-lightbox__bar" data-rst-lightbox-bar hidden>
        <span class="rst-lightbox__caption" data-rst-lightbox-caption></span>
        <span class="rst-lightbox__counter" data-rst-lightbox-counter></span>
    </div>
</div>
