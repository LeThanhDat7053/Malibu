@php
    Theme::asset()->container('footer')->usePath()->add('lightgallery-css', 'plugins/lightgallery/css/lightgallery.min.css');
    Theme::asset()->container('footer')->usePath()->add('lightgallery-js', 'plugins/lightgallery/js/lightgallery.min.js');

    Theme::set('pageTitle', $room->name);
    Theme::set('breadcrumbPageKey', 'room');
    $nights = (int) $startDate->diffInDays($endDate);

    $roomGalleryItems = function_exists('gallery_meta_data') ? gallery_meta_data($room) : [];
    $roomVideos = collect($room->videos ?? []);
    $roomGalleryVr360s = collect($roomGalleryItems)->filter(fn($item) => Arr::get($item, 'type') === 'vr360');

    // VR360 tours shown as the first slide(s) of the room gallery.
    // Sources: the dedicated vr360_url field + any gallery item of type vr360.
    $roomVr360Items = collect([['img' => $room->vr360_url ?? null, 'thumb' => null, 'description' => null]])
        ->merge($roomGalleryVr360s)
        ->filter(fn($item) => ! empty(Arr::get($item, 'img')))
        ->unique(fn($item) => Arr::get($item, 'img'))
        ->values();

    // Poster for a VR360 slide: its own thumb, else the room's first image.
    $roomVr360Poster = function (array $item) use ($room) {
        $thumb = Arr::get($item, 'thumb');

        if ($thumb) {
            return str_starts_with($thumb, 'http') ? $thumb : RvMedia::getImageUrl($thumb);
        }

        return ($first = Arr::first($room->images ?? [])) ? RvMedia::getImageUrl($first, 'room-image') : RvMedia::getDefaultImage();
    };
@endphp
{{-- data-mlb-room feeds the "recently viewed" strip on the homepage --}}
<div class="about-area5 about-p p-relative room-details" data-mlb-room="{{ $room->getKey() }}">
    <div class="container pt-60 pb-40">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-4 order-2">
                <aside class="sidebar services-sidebar">
                    @if (HotelHelper::isBookingEnabled())
                        <div class="sidebar-widget categories">
                            <div class="widget-content">
                                <h2 class="widget-title"> {{ __('Booking form') }} </h2>
                                <div class="booking">
                                    <div class="contact-bg">
                                        {!! Theme::partial('hotel.forms.form', ['availableForBooking' => true, 'style' => 1, 'room' => $room]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    {!! dynamic_sidebar('room_sidebar') !!}
                </aside>
            </div>

            <div class="col-lg-8 col-md-12 col-sm-12 order-1">
                <div class="service-detail">
                    <div class="thumb">
                        <div class="room-details-slider">
                            {{-- VR360 embedded inline as the first slide(s). src is deferred to data-src and
                                 filled by roomDetailsSlider() so slick's clones don't load the tour twice.
                                 Not an <a>, so lightGallery (selector: 'a') skips it and only indexes photos. --}}
                            @foreach ($roomVr360Items as $vr360)
                                <div class="room-vr360-slide">
                                    <iframe class="room-vr360-frame"
                                            data-src="{{ Arr::get($vr360, 'img') }}"
                                            title="{{ Arr::get($vr360, 'description') ?: __('View VR360') }}"
                                            frameborder="0"
                                            allow="accelerometer; gyroscope; magnetometer; xr-spatial-tracking; fullscreen"
                                            allowfullscreen></iframe>
                                </div>
                            @endforeach
                            @foreach ($room->images as $img)
                                <a href="{{ RvMedia::getImageUrl($img) }}">
                                    <img src="{{ RvMedia::getImageUrl($img, 'room-image') }}" alt="{{ $room->name }}">
                                </a>
                            @endforeach
                        </div>
                        <div class="room-details-slider-nav">
                            @foreach ($roomVr360Items as $vr360)
                                <div class="room-vr360-nav-thumb">
                                    <img src="{{ $roomVr360Poster($vr360) }}" alt="{{ Arr::get($vr360, 'description') ?: $room->name }}">
                                    <span class="room-vr360-badge">
                                        <i class="fal fa-vr-cardboard"></i>
                                    </span>
                                </div>
                            @endforeach
                            @foreach ($room->images as $img)
                                <img src="{{ RvMedia::getImageUrl($img, 'thumb') }}" alt="{{ $room->name }}">
                            @endforeach
                        </div>
                    </div>

                    {{-- VR360 now lives in the slider above, so this block only carries videos --}}
                    @if ($roomVideos->isNotEmpty())
                        {!! Theme::partial('media-gallery', ['items' => $roomVideos->values()->toArray(), 'id' => 'room-gallery']) !!}
                    @endif
                    <div class="content-box">
                        <div class="row align-items-center mb-50">
                            <div class="col-12">
                                <div class="price">
                                    <h2>{{ $room->name }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="ck-content">{!! BaseHelper::clean($room->content) !!}</div>

                        @if ($room->amenities->isNotEmpty())
                            <div class="room-block-content shadow-block mt-50 amenities-list">
                                <h3>{{ __('Amenities') }}</h3>
                                <div class="row">
                                    @foreach ($room->amenities as $amenity)
                                        @php
                                            $image = $amenity->getMetaData('icon_image', true)
                                        @endphp

                                        <div class="col-xl-4 col-lg-6 col-12 d-flex align-items-center mb-3">
                                            @if ($image)
                                                <img width="20px" class="d-block" src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $amenity->name }}">
                                            @elseif($amenity->icon)
                                                <x-core::icon :name="$amenity->icon"/>
                                            @endif
                                            <span class="ms-2">{{ $amenity->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($rules = theme_option('hotel_rules'))
                            <div class="room-block-content shadow-block">
                                <div class="hotel-rules-box">
                                    <h3>{{ __('Hotel Rules') }}</h3>
                                    {!! BaseHelper::clean($rules) !!}
                                </div>
                            </div>
                        @endif

                        @if ($cancellation = theme_option('cancellation'))
                            <div class="room-block-content shadow-block">
                                <h3>{{ __('Cancellation') }}</h3>
                                {!! BaseHelper::clean($cancellation) !!}
                            </div>
                        @endif


                        <div class="content-box related-room">
                            <h3>{{ __('Related Rooms') }}</h3>
                            <div class="row">
                                @foreach($relatedRooms as $room)
                                    <div class="col-lg-6 mb-20">
                                        {!! Theme::partial('rooms.item', compact('room', 'startDate', 'endDate', 'nights', 'adults')) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
