@php
    use Illuminate\Support\Arr;

    // Layout full-width + headerClass 'mlb-header': navbar mờ đè lên banner giống trang chủ mới.
    Theme::layout('full-width');
    Theme::set('headerClass', 'mlb-header');
    Theme::set('pageTitle', $restaurant->name);
    // Banner riêng của trang nhà hàng thay cho breadcrumb dùng chung
    Theme::set('breadcrumb', false);

    $items = collect($galleryItems ?? []);

    $galleryImages = $items
        ->filter(fn ($item) => Arr::get($item, 'type', 'image') === 'image' && Arr::get($item, 'img'))
        ->pluck('img')
        ->values();

    if ($galleryImages->isEmpty()) {
        $galleryImages = collect($restaurant->images);
    }

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

    {{-- 7. Gallery ảnh --}}
    @if ($galleryImages->isNotEmpty())
        <section class="rst-gallery">
            <div class="rst-heading">
                <div class="rst-heading__line"><span class="rst-diamond"></span></div>
                <div class="rst-heading__sub">{{ $restaurant->name }}</div>
                <h2 class="rst-heading__main">{{ trans('plugins/restaurant::restaurant.gallery_heading') }}</h2>
            </div>
            <div class="rst-gallery__grid">
                @foreach ($galleryImages as $image)
                    {{-- ảnh gốc: cỡ 'medium' (440x340) bị kéo giãn ở khổ này --}}
                    <div class="rst-photo" data-rst-lightbox="{{ RvMedia::getImageUrl($image) }}">
                        <img src="{{ RvMedia::getImageUrl($image) }}"
                             alt="{{ $restaurant->name }}" loading="lazy">
                    </div>
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
    <img src="" alt="">
</div>
