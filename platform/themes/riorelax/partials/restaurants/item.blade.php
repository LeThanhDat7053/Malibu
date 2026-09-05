@php
    $image = $restaurant->banner;
@endphp

<a class="mlb-rst-card" href="{{ $restaurant->url }}">
    <div class="mlb-rst-card__media">
        @if ($image)
            <img src="{{ RvMedia::getImageUrl($image, 'room-image') }}"
                 alt="{{ $restaurant->name }}" loading="lazy">
        @endif
        @if ($restaurant->vr360_url)
            <span class="mlb-rst-badge">
                <i class="fal fa-vr-cardboard"></i> VR360
            </span>
        @endif
    </div>
    <div class="mlb-rst-card__body">
        @if ($restaurant->location)
            <p class="mlb-eyebrow mlb-eyebrow--sm">{{ $restaurant->location }}</p>
        @endif
        <h3 class="mlb-rst-card__title">{{ $restaurant->name }}</h3>
        @if ($restaurant->description)
            <p class="mlb-rst-card__desc">{{ $restaurant->description }}</p>
        @endif
        @if ($restaurant->opening_hours)
            <p class="mlb-rst-card__meta">
                <i class="fal fa-clock"></i> {{ $restaurant->opening_hours }}
            </p>
        @endif
        <span class="mlb-rst-card__foot">
            <span class="mlb-link">{{ trans('plugins/restaurant::restaurant.view_details') }}</span>
        </span>
    </div>
</a>
