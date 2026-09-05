@php
    use Illuminate\Support\Arr;

    // Hero + carousel thực đơn tự chạy bằng css/restaurant.css và js/restaurant.js,
    // không cần slick nên bỏ hẳn slider cũ của trang Phòng.
    Theme::set('pageTitle', $restaurant->name);
    Theme::set('breadcrumb', false);

    $items = collect($galleryItems ?? []);

    $galleryImages = $items
        ->filter(fn ($item) => Arr::get($item, 'type', 'image') === 'image' && Arr::get($item, 'img'))
        ->pluck('img')
        ->values();

    if ($galleryImages->isEmpty()) {
        $galleryImages = collect($restaurant->images);
    }

    // Ảnh hero không lặp lại trong lưới gallery.
    $banner = $restaurant->banner;

    $menuImages = collect($restaurant->menu_images);

    $subtitle = $restaurant->subtitle ?: theme_option('site_title');
    $phone = $restaurant->phone ?: theme_option('hotline');
@endphp

<div class="rst-detail">

    {{-- 1. Hero: ảnh khổ lớn, sau này thay bằng khung VR360 --}}
    @if ($restaurant->vr360_embed)
        <div class="rst-hero rst-hero--embed">
            <iframe src="{{ $restaurant->vr360_embed }}" title="{{ $restaurant->name }} VR360"
                    loading="lazy" allowfullscreen></iframe>
        </div>
    @elseif ($banner)
        <div class="rst-hero" style="background-image:url('{{ RvMedia::getImageUrl($banner) }}');"></div>
    @endif

    {{-- 2. Tiêu đề --}}
    <div class="rst-title">
        @if ($subtitle)
            <div class="rst-title__label">{{ $subtitle }}</div>
        @endif
        <h1 class="rst-title__name">{{ $restaurant->name }}</h1>
        <div class="rst-divider"><span class="rst-diamond"></span></div>
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

    {{-- 4. Nội dung --}}
    <div class="rst-intro">
        @if ($restaurant->description)
            <p class="rst-intro__lead">{{ $restaurant->description }}</p>
        @endif

        @if ($restaurant->content)
            <div class="ck-content">{!! BaseHelper::clean($restaurant->content) !!}</div>
        @endif

        @if ($restaurant->opening_hours)
            <div class="rst-hours">{{ $restaurant->opening_hours }}</div>
        @endif

        {{-- Vị trí / sức chứa / phong cách ẩm thực — trước đây nằm ở cột bên. --}}
        @if ($restaurant->facts)
            <ul class="rst-facts">
                @foreach ($restaurant->facts as $fact)
                    @continue($fact['label'] === trans('plugins/restaurant::restaurant.opening_hours'))
                    <li>
                        <span class="rst-facts__label">{{ $fact['label'] }}</span>
                        <span class="rst-facts__value">{{ $fact['value'] }}</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- 5. Gallery ảnh --}}
    @if ($galleryImages->isNotEmpty())
        <section class="rst-gallery">
            <div class="rst-heading">
                <div class="rst-heading__line"><span class="rst-diamond"></span></div>
                <div class="rst-heading__sub">{{ $restaurant->name }}</div>
                <div class="rst-heading__main">{{ trans('plugins/restaurant::restaurant.gallery_heading') }}</div>
            </div>
            <div class="rst-gallery__grid">
                @foreach ($galleryImages as $image)
                    <div class="rst-photo" data-rst-lightbox="{{ RvMedia::getImageUrl($image) }}">
                        <img src="{{ RvMedia::getImageUrl($image, 'medium') }}"
                             alt="{{ $restaurant->name }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- 6. Our Menu: chỉ là ảnh thực đơn --}}
    @if ($menuImages->isNotEmpty())
        <section class="rst-menu">
            <div class="rst-heading rst-heading--light">
                <div class="rst-heading__line"><span class="rst-diamond"></span></div>
                <div class="rst-heading__sub">{{ $restaurant->name }}</div>
                <div class="rst-heading__main">{{ trans('plugins/restaurant::restaurant.our_menu') }}</div>
                @if ($restaurant->menu_heading)
                    <div class="rst-heading__bottom"><span>{{ $restaurant->menu_heading }}</span></div>
                @endif
            </div>

            <div class="rst-carousel" data-rst-carousel>
                <div class="rst-carousel__stage">
                    @foreach ($menuImages as $image)
                        <div class="rst-carousel__item" data-rst-lightbox="{{ RvMedia::getImageUrl($image) }}">
                            <img src="{{ RvMedia::getImageUrl($image, 'medium') }}"
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

    {{-- 7. Thanh đặt chỗ --}}
    @if ($phone)
        <a class="rst-reserve" href="tel:{{ preg_replace('/\D+/', '', $phone) }}">
            {{ trans('plugins/restaurant::restaurant.reserve') }}
        </a>
    @endif

    {{-- 8. Các không gian khác --}}
    @if ($others->isNotEmpty())
        <section class="rst-others">
            <div class="container">
                <div class="rst-heading">
                    <div class="rst-heading__line"><span class="rst-diamond"></span></div>
                    <div class="rst-heading__main">{{ trans('plugins/restaurant::restaurant.other_restaurants') }}</div>
                </div>
                <div class="rst-others__grid">
                    @foreach ($others as $item)
                        {!! Theme::partial('restaurants.item', ['restaurant' => $item]) !!}
                    @endforeach
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
