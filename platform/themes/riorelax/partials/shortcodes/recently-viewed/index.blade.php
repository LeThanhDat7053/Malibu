{{-- Rooms the visitor already opened; hidden until home.js finds ids in localStorage --}}
@php
    $payload = $rooms
        ->map(fn ($room) => [
            'id' => $room->getKey(),
            'name' => $room->name,
            'url' => $room->url,
            'image' => ($image = Arr::first($room->images ?: [])) ? RvMedia::getImageUrl($image, 'medium') : null,
            'size' => $room->size,
            'adults' => $room->max_adults,
        ])
        ->values();
@endphp

@if ($payload->isNotEmpty())
    <section class="mlb-recent" data-mlb-recent hidden>
        <div class="mlb-shell">
            <div class="mlb-section-head mlb-section-head--tight">
                <p class="mlb-eyebrow">{{ $shortcode->subtitle ?: __('Pick up where you left off') }}</p>
                <h2 class="mlb-display mlb-display--sm">{{ $shortcode->title ?: __('Rooms you viewed') }}</h2>
            </div>

            <div class="mlb-recent__track" data-mlb-recent-track></div>

            <button type="button" class="mlb-recent__clear" data-mlb-recent-clear>{{ __('Clear viewing history') }}</button>
        </div>

        <script type="application/json" data-mlb-recent-data>@json($payload)</script>
    </section>
@endif
