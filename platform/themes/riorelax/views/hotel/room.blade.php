@php
    Theme::layout('full-width');
    // Navbar lấy theo trang chủ mới: mờ đen đè lên hero, sticky đổi nền trắng
    Theme::set('headerClass', 'mlb-header');
    Theme::asset()->container('footer')->usePath()->add('lightgallery-css', 'plugins/lightgallery/css/lightgallery.min.css');
    Theme::asset()->container('footer')->usePath()->add('lightgallery-js', 'plugins/lightgallery/js/lightgallery.min.js');

    Theme::set('pageTitle', $room->name);
    Theme::set('breadcrumbPageKey', 'room');
    // Dải tiêu đề riêng của trang phòng thay cho breadcrumb dùng chung
    Theme::set('breadcrumb', false);

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

    // Ảnh nền dải tiêu đề: ưu tiên ảnh cấu hình ở Theme Options, không có thì lấy ảnh đầu của phòng
    $heroImageOption = theme_option('breadcrumb_background_image_room') ?: theme_option('breadcrumb_background_image');
    $heroImage = $heroImageOption
        ? RvMedia::getImageUrl($heroImageOption)
        : (($firstImage = Arr::first($room->images ?? [])) ? RvMedia::getImageUrl($firstImage, 'room-image') : Theme::asset()->url('images/breadcrumb-bg.jpg'));

    $showPrice = HotelHelper::isBookingEnabled() && $room->price > 0;

    // Thông số phòng, hiển thị thành dải fact ngay dưới bộ ảnh
    $roomFacts = collect([
        ['label' => __('Room type'), 'value' => $room->category?->name],
        ['label' => __('Room size'), 'value' => $room->size ? $room->size . ' m²' : null],
        ['label' => __('Beds'), 'value' => $room->number_of_beds ?: null],
        ['label' => __('Adults'), 'value' => $room->max_adults ?: null],
        ['label' => __('Children'), 'value' => $room->max_children ?: null],
    ])->filter(fn ($fact) => filled($fact['value']))->values();

    // Breadcrumb mặc định chỉ có Trang chủ > tên phòng, chèn thêm trang danh sách phòng vào giữa
    $roomCrumbs = collect(Theme::breadcrumb()->getCrumbs());

    if ($roomCrumbs->count() > 1 && Route::has('public.rooms')) {
        $roomsUrl = route('public.rooms');

        if (! $roomCrumbs->contains(fn ($crumb) => rtrim((string) Arr::get($crumb, 'url'), '/') === rtrim($roomsUrl, '/'))) {
            $roomCrumbs->splice($roomCrumbs->count() - 1, 0, [['label' => __('Rooms'), 'url' => $roomsUrl]]);
        }
    }

    $roomCrumbs = $roomCrumbs->values();

    $hotelRules = theme_option('hotel_rules');
    $cancellation = theme_option('cancellation');
    $hotline = theme_option('hotline');
    $contactEmail = theme_option('contact_email');
@endphp

{{-- data-mlb-room feeds the "recently viewed" strip on the homepage --}}
<div class="mlb-page mlb-room-detail" data-mlb-room="{{ $room->getKey() }}">

    {{-- Dải tiêu đề: tên phòng + giá + breadcrumb đè lên ảnh --}}
    <section class="mlb-rd-hero" style="background-image: url('{{ $heroImage }}');">
        <div class="mlb-shell mlb-rd-hero__inner">
            <div class="mlb-rd-hero__head">
                <div class="mlb-rd-hero__id">
                    @if ($categoryName = $room->category?->name)
                        <p class="mlb-eyebrow mlb-rd-hero__eyebrow">{{ $categoryName }}</p>
                    @endif
                    <h1 class="mlb-rd-hero__title">{{ $room->name }}</h1>
                </div>

                @if ($showPrice)
                    <p class="mlb-rd-hero__price">
                        <span>{{ __('From') }}</span>
                        <strong>{{ format_price($room->price) }}</strong>
                        <span>/ {{ __('night') }}</span>
                    </p>
                @endif
            </div>

            @if ($roomCrumbs->count() > 1)
                <nav aria-label="breadcrumb">
                    <ol class="mlb-rd-crumbs">
                        @foreach ($roomCrumbs as $crumb)
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

    <div class="mlb-shell mlb-rd-body">
        <div class="mlb-rd-main">
            <div class="mlb-rd-content">
                {{-- Bộ ảnh: ảnh lớn + dải thumbnail đè lên đáy ảnh --}}
                <div class="mlb-rd-gallery">
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

                @if ($roomFacts->isNotEmpty())
                    <ul class="mlb-rd-facts">
                        @foreach ($roomFacts as $fact)
                            <li>
                                <span class="mlb-rd-facts__k">{{ $fact['label'] }}</span>
                                <span class="mlb-rd-facts__v">{{ $fact['value'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                {{-- $room->content đã được controller bọc sẵn trong .ck-content --}}
                <div class="mlb-rd-prose mlb-rd-prose--lead">{!! BaseHelper::clean($room->content) !!}</div>

                @if ($roomVideos->isNotEmpty())
                    <section class="mlb-rd-section">
                        <div class="mlb-rd-head">
                            <h2 class="mlb-rd-head__title">{{ __('Video') }}</h2>
                            <p class="mlb-rd-head__sub">{{ __('A closer look at the room') }}</p>
                        </div>
                        {!! Theme::partial('media-gallery', ['items' => $roomVideos->values()->toArray(), 'id' => 'room-gallery']) !!}
                    </section>
                @endif

                @if ($room->amenities->isNotEmpty())
                    <section class="mlb-rd-section">
                        <div class="mlb-rd-head">
                            <h2 class="mlb-rd-head__title">{{ __('Amenities') }}</h2>
                            <p class="mlb-rd-head__sub">{{ __('Included in this room') }}</p>
                        </div>
                        <ul class="mlb-rd-amenities">
                            @foreach ($room->amenities as $amenity)
                                @php($amenityIcon = $amenity->getMetaData('icon_image', true))
                                <li>
                                    @if ($amenityIcon)
                                        <img src="{{ RvMedia::getImageUrl($amenityIcon) }}" alt="{{ $amenity->name }}" width="20" height="20">
                                    @elseif ($amenity->icon)
                                        <x-core::icon :name="$amenity->icon"/>
                                    @else
                                        <i class="fal fa-check"></i>
                                    @endif
                                    <span>{{ $amenity->name }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if ($hotelRules || $cancellation)
                    <section class="mlb-rd-section">
                        <div class="mlb-rd-head">
                            <h2 class="mlb-rd-head__title">{{ __('Good to know') }}</h2>
                            <p class="mlb-rd-head__sub">{{ __('House rules & cancellation') }}</p>
                        </div>
                        <div class="mlb-rd-notes">
                            @if ($hotelRules)
                                <article class="mlb-rd-note">
                                    <h3>{{ __('Hotel Rules') }}</h3>
                                    <div class="mlb-rd-prose">{!! BaseHelper::clean($hotelRules) !!}</div>
                                </article>
                            @endif
                            @if ($cancellation)
                                <article class="mlb-rd-note">
                                    <h3>{{ __('Cancellation') }}</h3>
                                    <div class="mlb-rd-prose">{!! BaseHelper::clean($cancellation) !!}</div>
                                </article>
                            @endif
                        </div>
                    </section>
                @endif

                @if (count($relatedRooms))
                    <section class="mlb-rd-section mlb-rd-related">
                        <div class="mlb-rd-head">
                            <h2 class="mlb-rd-head__title">{{ __('Related Rooms') }}</h2>
                            <p class="mlb-rd-head__sub">{{ __('Other rooms you may like') }}</p>
                        </div>
                        <div class="mlb-rd-related__grid">
                            @foreach ($relatedRooms as $relatedRoom)
                                {!! Theme::partial('rooms.item-editorial', ['room' => $relatedRoom, 'startDate' => $startDate, 'endDate' => $endDate, 'nights' => $nights, 'adults' => $adults]) !!}
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <aside class="mlb-rd-aside">
                <div class="mlb-rd-aside__inner">
                    @if (HotelHelper::isBookingEnabled())
                        <div class="mlb-rd-widget mlb-rd-widget--booking">
                            <h2 class="mlb-rd-widget__title">{{ __('Book your room') }}</h2>
                            @if ($showPrice)
                                <p class="mlb-rd-widget__price">
                                    <strong>{{ format_price($room->price) }}</strong>
                                    <span>/ {{ __('night') }}</span>
                                </p>
                            @endif
                            {!! Theme::partial('hotel.forms.form', ['availableForBooking' => true, 'style' => 1, 'room' => $room]) !!}
                        </div>
                    @endif

                    @if ($hotline || $contactEmail)
                        <div class="mlb-rd-widget mlb-rd-widget--help">
                            <h2 class="mlb-rd-widget__title">{{ __('Need help?') }}</h2>
                            <ul class="mlb-rd-help">
                                @if ($hotline)
                                    <li>
                                        <i class="fal fa-phone-alt"></i>
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $hotline) }}">{{ $hotline }}</a>
                                    </li>
                                @endif
                                @if ($contactEmail)
                                    <li>
                                        <i class="fal fa-envelope"></i>
                                        <a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    {!! dynamic_sidebar('room_sidebar') !!}
                </div>
            </aside>
        </div>
    </div>
</div>
