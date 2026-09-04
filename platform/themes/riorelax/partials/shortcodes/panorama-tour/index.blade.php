{{-- Full-bleed 360° tour: poster first, iframe injected on click so it never costs LCP --}}
@php
    $scenes = collect($tabs ?? [])
        ->map(fn ($scene) => [
            'label' => Arr::get($scene, 'label'),
            'url' => Arr::get($scene, 'url'),
            'thumbnail' => Arr::get($scene, 'thumbnail'),
        ])
        ->filter(fn ($scene) => $scene['label'] && $scene['url'])
        ->values();

    $defaultUrl = $shortcode->tour_url ?: $scenes->first()['url'] ?? null;
    $poster = $shortcode->poster_image;
@endphp

@if ($defaultUrl)
    <section class="mlb-panorama" data-mlb-panorama>
        <div class="mlb-panorama__head">
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

        <div class="mlb-panorama__stage" data-mlb-panorama-stage data-url="{{ $defaultUrl }}">
            @if ($poster)
                <img
                    class="mlb-panorama__poster"
                    src="{{ RvMedia::getImageUrl($poster) }}"
                    alt="{{ BaseHelper::clean($shortcode->title ?: __('360° tour')) }}"
                    loading="lazy"
                >
            @endif

            <button type="button" class="mlb-panorama__launch" data-mlb-panorama-launch>
                <span class="mlb-panorama__ring" aria-hidden="true">360°</span>
                <span class="mlb-panorama__cta">{{ $shortcode->button_label ?: __('Explore in 360°') }}</span>
            </button>

            <a
                class="mlb-panorama__external"
                href="{{ $defaultUrl }}"
                target="_blank"
                rel="noopener noreferrer"
                data-mlb-panorama-external
            >{{ __('Open tour in a new tab') }}</a>
        </div>

        @if ($scenes->count() > 1)
            <div class="mlb-panorama__scenes" role="tablist">
                @foreach ($scenes as $index => $scene)
                    <button
                        type="button"
                        role="tab"
                        class="mlb-panorama__scene @if (! $index) is-active @endif"
                        data-mlb-panorama-scene
                        data-url="{{ $scene['url'] }}"
                        aria-selected="{{ $index ? 'false' : 'true' }}"
                    >
                        @if ($scene['thumbnail'])
                            <img src="{{ RvMedia::getImageUrl($scene['thumbnail'], 'thumb') }}" alt="{{ $scene['label'] }}" loading="lazy">
                        @endif
                        <span>{{ $scene['label'] }}</span>
                    </button>
                @endforeach
            </div>
        @endif
    </section>
@endif
