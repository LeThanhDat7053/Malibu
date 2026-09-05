<section class="services-area pt-90 pb-90">
    <div class="container">
        <div class="mlb-rooms__grid">
            @foreach ($rooms as $room)
                {!! Theme::partial('rooms.item-editorial', compact('room', 'startDate', 'endDate', 'nights', 'adults')) !!}
            @endforeach
        </div>
    </div>
</section>
