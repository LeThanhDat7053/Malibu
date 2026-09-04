{{-- Brand signature: numbered editorial rows stating what only Malibu offers --}}
@php
    $items = collect($tabs ?? [])
        ->map(fn ($item) => [
            'icon' => Arr::get($item, 'icon'),
            'image' => Arr::get($item, 'image'),
            'title' => Arr::get($item, 'title'),
            'description' => Arr::get($item, 'description'),
        ])
        ->filter(fn ($item) => $item['title'])
        ->values();
@endphp

@if ($items->isNotEmpty())
    <section class="mlb-signature">
        @if ($bgImage = $shortcode->background_image)
            <img class="mlb-signature__bg" src="{{ RvMedia::getImageUrl($bgImage) }}" alt="" aria-hidden="true" loading="lazy">
        @endif

        <div class="mlb-shell">
            <div class="mlb-section-head">
                @if ($subtitle = $shortcode->subtitle)
                    <p class="mlb-eyebrow">{{ $subtitle }}</p>
                @endif

                @if ($title = $shortcode->title)
                    <h2 class="mlb-display">{!! BaseHelper::clean($title) !!}</h2>
                @endif

                @if ($description = $shortcode->description)
                    <p class="mlb-lede">{!! BaseHelper::clean($description) !!}</p>
                @endif
            </div>

            <ol class="mlb-signature__list">
                @foreach ($items as $index => $item)
                    <li class="mlb-signature__item">
                        <span class="mlb-signature__index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>

                        <div class="mlb-signature__body">
                            <h3 class="mlb-signature__title">
                                @if ($item['icon'])
                                    <i class="{{ $item['icon'] }}" aria-hidden="true"></i>
                                @endif
                                {{ $item['title'] }}
                            </h3>

                            @if ($item['description'])
                                <p>{!! BaseHelper::clean($item['description']) !!}</p>
                            @endif
                        </div>

                        @if ($item['image'])
                            <div class="mlb-signature__media">
                                <img src="{{ RvMedia::getImageUrl($item['image'], 'medium') }}" alt="{{ $item['title'] }}" loading="lazy">
                            </div>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </section>
@endif
