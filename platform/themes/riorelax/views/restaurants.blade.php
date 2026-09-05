@php
    Theme::set('pageTitle', theme_option('restaurants_banner_title') ?: trans('plugins/restaurant::restaurant.name'));

    if ($bannerImage = theme_option('restaurants_banner_image')) {
        Theme::set('breadcrumbBackgroundImage', $bannerImage);
    }
@endphp

<div class="rst-listing">
    @if ($restaurants->isEmpty())
        <p class="text-center py-5 text-muted">
            {{ trans('plugins/restaurant::restaurant.no_restaurants') }}
        </p>
    @else
        @foreach ($restaurants as $restaurant)
            @php
                $image = $restaurant->banner;
            @endphp
            <section class="rst-row {{ $loop->even ? 'rst-row--reverse' : '' }}">
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-6 col-md-12">
                            <a class="rst-row__media" href="{{ $restaurant->url }}">
                                @if ($image)
                                    <img src="{{ RvMedia::getImageUrl($image, 'medium') }}"
                                         alt="{{ $restaurant->name }}" loading="lazy">
                                @endif
                                @if ($restaurant->vr360_url)
                                    <span class="rst-row__badge">
                                        <i class="fal fa-vr-cardboard"></i> VR360
                                    </span>
                                @endif
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="rst-row__body">
                                @if ($restaurant->opening_hours)
                                    <h5 class="rst-row__hours">{{ $restaurant->opening_hours }}</h5>
                                @endif
                                <h2 class="rst-row__title">
                                    <a href="{{ $restaurant->url }}">{{ $restaurant->name }}</a>
                                </h2>
                                @if ($restaurant->description)
                                    <p class="rst-row__desc">{{ $restaurant->description }}</p>
                                @endif
                                <a href="{{ $restaurant->url }}" class="btn ss-btn">
                                    {{ trans('plugins/restaurant::restaurant.view_details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif
</div>
