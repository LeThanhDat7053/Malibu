{{-- trang /rooms đã có nhịp đệm riêng nên phần này không cần padding --}}
<section class="mlb-rooms-list">
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
</section>
