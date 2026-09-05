@php
    // Layout full-width + headerClass 'mlb-header': navbar mờ đè lên hero giống trang chủ mới.
    Theme::layout('full-width');
    Theme::set('headerClass', 'mlb-header');
    Theme::set('pageTitle', trans('plugins/restaurant::restaurant.name'));
    Theme::set('breadcrumb', false);

    // Ảnh nền dải tiêu đề: ảnh cấu hình ở Theme Options, không có thì lấy bìa nhà hàng đầu tiên
    $heroOption = theme_option('restaurants_banner_image') ?: theme_option('breadcrumb_background_image');
    $heroBanner = $restaurants->first()?->banner;

    $heroImage = $heroOption
        ? RvMedia::getImageUrl($heroOption)
        : ($heroBanner ? RvMedia::getImageUrl($heroBanner) : Theme::asset()->url('images/breadcrumb-bg.jpg'));

    $crumbs = collect(Theme::breadcrumb()->getCrumbs());
@endphp

<div class="mlb-page mlb-rst-page">

    <section class="mlb-rd-hero" style="background-image: url('{{ $heroImage }}');">
        <div class="mlb-shell mlb-rd-hero__inner">
            <div class="mlb-rd-hero__head">
                <div class="mlb-rd-hero__id">
                    <h1 class="mlb-rd-hero__title">{{ trans('plugins/restaurant::restaurant.name') }}</h1>
                </div>
            </div>

            @if ($crumbs->count() > 1)
                <nav aria-label="breadcrumb">
                    <ol class="mlb-rd-crumbs">
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
    </section>

    @if ($restaurants->isEmpty())
        <p class="mlb-rst-empty">{{ trans('plugins/restaurant::restaurant.no_restaurants') }}</p>
    @else
        <div class="mlb-shell mlb-rst-rows">
            @foreach ($restaurants as $restaurant)
                @php($image = $restaurant->banner)
                <article class="mlb-rst-row {{ $loop->even ? 'mlb-rst-row--reverse' : '' }}">
                    <a class="mlb-rst-row__media" href="{{ $restaurant->url }}">
                        @if ($image)
                            {{-- ảnh gốc: cỡ 'medium' (440x340) bị vỡ ở khổ nửa trang --}}
                            <img src="{{ RvMedia::getImageUrl($image) }}"
                                 alt="{{ $restaurant->name }}" loading="lazy">
                        @endif
                        @if ($restaurant->vr360_url)
                            <span class="mlb-rst-badge">
                                <i class="fal fa-vr-cardboard"></i> VR360
                            </span>
                        @endif
                    </a>

                    <div class="mlb-rst-row__body">
                        @if ($restaurant->subtitle)
                            <p class="mlb-eyebrow">{{ $restaurant->subtitle }}</p>
                        @endif

                        <h2 class="mlb-rst-row__title">
                            <a href="{{ $restaurant->url }}">{{ $restaurant->name }}</a>
                        </h2>

                        @if ($restaurant->description)
                            <p class="mlb-rst-row__desc">{{ $restaurant->description }}</p>
                        @endif

                        @if ($restaurant->location || $restaurant->opening_hours || $restaurant->cuisine)
                            <ul class="mlb-rst-row__meta">
                                @if ($restaurant->location)
                                    <li><i class="fal fa-map-marker-alt"></i> {{ $restaurant->location }}</li>
                                @endif
                                @if ($restaurant->opening_hours)
                                    <li><i class="fal fa-clock"></i> {{ $restaurant->opening_hours }}</li>
                                @endif
                                @if ($restaurant->cuisine)
                                    <li><i class="fal fa-utensils"></i> {{ $restaurant->cuisine }}</li>
                                @endif
                            </ul>
                        @endif

                        <a href="{{ $restaurant->url }}" class="mlb-btn">
                            {{ trans('plugins/restaurant::restaurant.view_details') }}
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
