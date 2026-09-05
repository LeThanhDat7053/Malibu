@php
    Theme::layout('full-width');
    // Navbar và dải tiêu đề dùng chung với trang danh sách phòng
    Theme::set('headerClass', 'mlb-header');
    Theme::set('pageTitle', $category->name);
    Theme::set('breadcrumbPageKey', 'room');
    Theme::set('breadcrumb', false);

    [$startDate, $endDate, $adults, $nights, $children, $room] = HotelHelper::getRoomBookingParams();

    // controller không eager load category, nạp sẵn ở đây cho khỏi query từng phòng.
    // getCollection() có thể trả về Collection thường nên gói lại bằng Eloquent Collection.
    \Illuminate\Database\Eloquent\Collection::make($rooms->items())->loadMissing('category');

    $heroImageOption = theme_option('breadcrumb_background_image_room') ?: theme_option('breadcrumb_background_image');
    $heroImage = $heroImageOption
        ? RvMedia::getImageUrl($heroImageOption)
        : Theme::asset()->url('images/breadcrumb-bg.jpg');

    $roomCrumbs = collect(Theme::breadcrumb()->getCrumbs());
@endphp

<div class="mlb-page mlb-rooms-page">
    <section class="mlb-rd-hero" style="background-image: url('{{ $heroImage }}');">
        <div class="mlb-shell mlb-rd-hero__inner">
            <div class="mlb-rd-hero__head">
                <div class="mlb-rd-hero__id">
                    <p class="mlb-eyebrow mlb-rd-hero__eyebrow">{{ __('Rooms') }}</p>
                    <h1 class="mlb-rd-hero__title">{{ $category->name }}</h1>
                </div>
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
        <div class="mlb-section-head mlb-section-head--tight">
            <h2 class="mlb-display mlb-display--sm">{{ __(':count rooms available', ['count' => $rooms->total()]) }}</h2>
        </div>

        @if ($rooms->isNotEmpty())
            <div class="mlb-rooms__grid">
                @foreach ($rooms as $room)
                    {!! Theme::partial('rooms.item-editorial', compact('room', 'startDate', 'endDate', 'nights', 'adults')) !!}
                @endforeach
            </div>

            @if ($rooms instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <div class="text-center mt-30">
                    {!! $rooms->withQueryString()->links(Theme::getThemeNamespace('partials.pagination')) !!}
                </div>
            @endif
        @endif
    </div>
</div>
