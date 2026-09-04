{{-- Reusable N-column editorial grid (dining, facilities, anything with image + blurb + link) --}}
@php
    $columns = (int) ($shortcode->columns ?: 3);
    $columns = in_array($columns, [2, 3, 4], true) ? $columns : 3;

    $items = collect($tabs ?? [])
        ->map(fn ($item) => [
            'image' => Arr::get($item, 'image'),
            'eyebrow' => Arr::get($item, 'eyebrow'),
            'title' => Arr::get($item, 'title'),
            'description' => Arr::get($item, 'description'),
            'link_label' => Arr::get($item, 'link_label'),
            'link_url' => Arr::get($item, 'link_url'),
        ])
        ->filter(fn ($item) => $item['title'])
        ->values();
@endphp

@if ($items->isNotEmpty())
    <section class="mlb-columns" style="--mlb-columns: {{ $columns }}">
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

            <div class="mlb-columns__grid">
                @foreach ($items as $item)
                    <article class="mlb-card">
                        @if ($item['image'])
                            <div class="mlb-card__media">
                                @if ($item['link_url'])
                                    <a href="{{ $item['link_url'] }}">
                                        <img src="{{ RvMedia::getImageUrl($item['image']) }}" alt="{{ $item['title'] }}" loading="lazy">
                                    </a>
                                @else
                                    <img src="{{ RvMedia::getImageUrl($item['image']) }}" alt="{{ $item['title'] }}" loading="lazy">
                                @endif
                            </div>
                        @endif

                        <div class="mlb-card__body">
                            @if ($item['eyebrow'])
                                <p class="mlb-eyebrow mlb-eyebrow--sm">{{ $item['eyebrow'] }}</p>
                            @endif

                            <h3 class="mlb-card__title">
                                @if ($item['link_url'])
                                    <a href="{{ $item['link_url'] }}">{{ $item['title'] }}</a>
                                @else
                                    {{ $item['title'] }}
                                @endif
                            </h3>

                            @if ($item['description'])
                                <p class="mlb-card__text">{!! BaseHelper::clean($item['description']) !!}</p>
                            @endif

                            @if ($item['link_url'] && $item['link_label'])
                                <a class="mlb-link" href="{{ $item['link_url'] }}">{{ $item['link_label'] }}</a>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
