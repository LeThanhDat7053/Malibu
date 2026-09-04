@php
    $image = $restaurant->image;
@endphp

<a class="rst-card" href="{{ $restaurant->url }}">
    <div class="rst-card__media">
        @if ($image)
            <img src="{{ RvMedia::getImageUrl($image, 'medium') }}"
                 alt="{{ $restaurant->name }}" loading="lazy">
        @endif
        @if ($restaurant->vr360_url)
            <span class="rst-card__badge">
                <i class="fal fa-vr-cardboard"></i> VR360
            </span>
        @endif
    </div>
    <div class="rst-card__body">
        @if ($restaurant->location)
            <p class="rst-card__eyebrow">{{ $restaurant->location }}</p>
        @endif
        <h3 class="rst-card__title">{{ $restaurant->name }}</h3>
        @if ($restaurant->description)
            <p class="rst-card__desc">{{ $restaurant->description }}</p>
        @endif
        @if ($restaurant->opening_hours)
            <p class="rst-card__meta">
                <i class="fal fa-clock"></i> {{ $restaurant->opening_hours }}
            </p>
        @endif
        <span class="rst-card__more">
            {{ trans('plugins/restaurant::restaurant.view_details') }}
            <i class="fal fa-arrow-right"></i>
        </span>
    </div>
</a>
