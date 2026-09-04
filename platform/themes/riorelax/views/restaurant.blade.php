@php
    use Illuminate\Support\Arr;

    Theme::asset()->container('footer')->usePath()
        ->add('lightgallery-css', 'plugins/lightgallery/css/lightgallery.min.css');
    Theme::asset()->container('footer')->usePath()
        ->add('lightgallery-js', 'plugins/lightgallery/js/lightgallery.min.js');

    Theme::set('pageTitle', $restaurant->name);

    $items = collect($galleryItems ?? []);

    // Ảnh lớn phía trên. Dùng đúng class `room-details-slider` của theme để
    // slick + lightGallery trong public/js/main.js tự khởi tạo, khỏi thêm JS mới.
    // Sau này thay khối này bằng khung nhúng VR360 là xong.
    $sliderImages = $items
        ->filter(fn ($item) => Arr::get($item, 'type', 'image') === 'image' && Arr::get($item, 'img'))
        ->pluck('img')
        ->values();

    if ($sliderImages->isEmpty()) {
        $sliderImages = collect($restaurant->images);
    }

    $videos = $items->filter(fn ($item) => Arr::get($item, 'type') === 'video');
    $vr360s = $items->filter(fn ($item) => Arr::get($item, 'type') === 'vr360');

    $facts = $restaurant->facts;
    $phone = $restaurant->phone ?: theme_option('hotline');
    $email = $restaurant->email ?: theme_option('email');
@endphp

<div class="about-area5 about-p p-relative room-details restaurant-details">
    <div class="container pt-60 pb-40">
        <div class="row">

            <div class="col-sm-12 col-md-12 col-lg-4 order-2">
                <aside class="sidebar services-sidebar">

                    @if ($restaurant->vr360_url)
                        <div class="sidebar-widget categories mb-20">
                            <div class="widget-content text-center">
                                <a href="{{ $restaurant->vr360_url }}" target="_blank"
                                   rel="noopener noreferrer" class="btn ss-btn w-100"
                                   style="display:inline-flex;align-items:center;justify-content:center;gap:8px;text-decoration:none;">
                                    <i class="fal fa-vr-cardboard" style="line-height:1;"></i>
                                    <span style="text-decoration:none;">{{ trans('plugins/restaurant::restaurant.view_vr360') }}</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($facts)
                        <div class="sidebar-widget categories">
                            <div class="widget-content">
                                <h2 class="widget-title">{{ trans('plugins/restaurant::restaurant.information') }}</h2>
                                <ul class="restaurant-facts">
                                    @foreach ($facts as $fact)
                                        <li>
                                            <span class="restaurant-facts__label">{{ $fact['label'] }}</span>
                                            <span class="restaurant-facts__value">{{ $fact['value'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if ($phone || $email)
                        <div class="sidebar-widget categories">
                            <div class="widget-content">
                                <h2 class="widget-title">{{ trans('plugins/restaurant::restaurant.reserve') }}</h2>
                                <ul class="restaurant-contact">
                                    @if ($phone)
                                        <li>
                                            <i class="fal fa-phone"></i>
                                            <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}">{{ $phone }}</a>
                                        </li>
                                    @endif
                                    @if ($email)
                                        <li>
                                            <i class="fal fa-envelope"></i>
                                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif

                    {!! dynamic_sidebar('service_sidebar') !!}
                </aside>
            </div>

            <div class="col-lg-8 col-md-12 col-sm-12 order-1">
                <div class="service-detail">

                    @if ($sliderImages->isNotEmpty())
                        <div class="thumb">
                            <div class="room-details-slider">
                                @foreach ($sliderImages as $image)
                                    <a href="{{ RvMedia::getImageUrl($image) }}">
                                        <img src="{{ RvMedia::getImageUrl($image, 'room-image') }}"
                                             alt="{{ $restaurant->name }}">
                                    </a>
                                @endforeach
                            </div>
                            @if ($sliderImages->count() > 1)
                                <div class="room-details-slider-nav">
                                    @foreach ($sliderImages as $image)
                                        <img src="{{ RvMedia::getImageUrl($image, 'thumb') }}"
                                             alt="{{ $restaurant->name }}">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($videos->isNotEmpty() || $vr360s->isNotEmpty())
                        {!! Theme::partial('media-gallery', [
                            'items' => $videos->merge($vr360s)->values()->toArray(),
                            'id' => 'restaurant-gallery-' . $restaurant->id,
                        ]) !!}
                    @endif

                    <div class="content-box">
                        <div class="row align-items-center mb-30">
                            <div class="col-12">
                                <div class="price">
                                    @if ($restaurant->location)
                                        <p class="restaurant-eyebrow">{{ $restaurant->location }}</p>
                                    @endif
                                    <h2>{{ $restaurant->name }}</h2>
                                </div>
                            </div>
                        </div>

                        @if ($restaurant->description)
                            <p class="restaurant-lead">{{ $restaurant->description }}</p>
                        @endif

                        <div class="ck-content">{!! BaseHelper::clean($restaurant->content) !!}</div>

                        @if ($others->isNotEmpty())
                            <div class="content-box related-room">
                                <h3>{{ trans('plugins/restaurant::restaurant.other_restaurants') }}</h3>
                                <div class="row">
                                    @foreach ($others as $item)
                                        <div class="col-lg-6 mb-20">
                                            {!! Theme::partial('restaurants.item', ['restaurant' => $item]) !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
