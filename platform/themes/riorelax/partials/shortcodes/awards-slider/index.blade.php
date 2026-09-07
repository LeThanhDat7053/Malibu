{{-- Dải giải thưởng / chứng nhận, mọi ảnh cùng một khung cao nên hàng không nhấp nhô --}}
@php
    $perView = (int) ($shortcode->columns ?: 6);
    $perView = min(max($perView, 3), 8);

    $items = collect($tabs ?? [])
        ->map(fn ($item) => [
            'src' => Arr::get($item, 'image') ? RvMedia::getImageUrl(Arr::get($item, 'image')) : null,
            'name' => Arr::get($item, 'name'),
            'link' => Arr::get($item, 'link'),
        ])
        ->filter(fn ($item) => $item['src'])
        ->values();

    // Ảnh demo tạm nằm trong theme, gỡ khối này khi admin đã tự tải ảnh giải thưởng lên
    if ($items->isEmpty()) {
        $items = collect([
            'award-4' => 'Expedia Guest Rated Award 2024',
            'award-7' => 'Trip.com Verified Reviews 2025',
            'award-3' => 'Booking.com Traveller Review Awards 2025',
            'award-1' => 'Tiket.com 2024',
            'award8' => 'Agoda Gold Circle 2025',
            'award-2' => 'Trip.com Traveller Review Awards 2024',
            'booking-award' => 'Booking.com',
            'agoda-gold-circle' => 'Agoda Gold Circle',
        ])
            ->map(fn (string $name, string $file) => [
                'src' => Theme::asset()->url('images/mlb-demo/awards/' . $file . '.jpg'),
                'name' => $name,
                'link' => null,
            ])
            ->values();
    }

    $isSlider = $items->count() > $perView;
    $autoplay = $shortcode->autoplay !== '0';
@endphp

@if ($items->isNotEmpty())
    <section class="mlb-awards" @if ($bg = $shortcode->background_color) style="background: {{ $bg }}" @endif>
        <div class="mlb-shell">
            @if ($shortcode->subtitle || $shortcode->title || $shortcode->description)
                <div class="mlb-section-head mlb-section-head--tight mlb-section-head--center">
                    @if ($subtitle = $shortcode->subtitle)
                        <p class="mlb-eyebrow">{{ $subtitle }}</p>
                    @endif

                    @if ($title = $shortcode->title)
                        <h2 class="mlb-display mlb-display--sm">{!! BaseHelper::clean($title) !!}</h2>
                    @endif

                    @if ($description = $shortcode->description)
                        <p class="mlb-lede">{!! BaseHelper::clean($description) !!}</p>
                    @endif
                </div>
            @endif

            <div
                class="mlb-awards__track {{ $isSlider ? 'mlb-slider' : 'mlb-awards__track--static' }}"
                style="--mlb-awards-per-view: {{ $perView }}"
                @if ($isSlider)
                    data-mlb-slider
                    data-per-view="{{ $perView }}"
                    data-per-view-lg="{{ min($perView, 5) }}"
                    data-per-view-md="{{ min($perView, 4) }}"
                    data-per-view-sm="3"
                    data-per-view-xs="2"
                    data-autoplay="{{ $autoplay ? 1 : 0 }}"
                    data-dots="0"
                @endif
            >
                @foreach ($items as $item)
                    <figure class="mlb-award">
                        @if ($item['link'])
                            <a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer" class="mlb-award__frame">
                                <img src="{{ $item['src'] }}" alt="{{ $item['name'] }}" loading="lazy">
                            </a>
                        @else
                            <span class="mlb-award__frame">
                                <img src="{{ $item['src'] }}" alt="{{ $item['name'] }}" loading="lazy">
                            </span>
                        @endif

                        @if ($item['name'] && $shortcode->show_names === '1')
                            <figcaption class="mlb-award__name">{{ $item['name'] }}</figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
@endif
