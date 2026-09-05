{{-- Editorial room card used by [featured-rooms style="editorial"] --}}
@php
    $bookingQuery = http_build_query(array_filter([
        'start_date' => request()->query('start_date', $startDate ?? null),
        'end_date' => request()->query('end_date', $endDate ?? null),
        'adults' => request()->query('adults', $adults ?? null),
        'children' => request()->query('children'),
    ]));

    $roomUrl = $room->url . ($bookingQuery ? '?' . $bookingQuery : '');
@endphp

<article class="mlb-room">
    <a class="mlb-room__media" href="{{ $roomUrl }}">
        @if ($images = $room->images)
            <img src="{{ RvMedia::getImageUrl(Arr::first($images), 'room-image') }}" alt="{{ $room->name }}" loading="lazy">
        @endif

        @if (! empty($room->vr360_url))
            <span class="mlb-room__badge">360°</span>
        @endif
    </a>

    <div class="mlb-room__body">
        @if ($room->category)
            <p class="mlb-eyebrow mlb-eyebrow--sm">{{ $room->category->name }}</p>
        @endif

        <h3 class="mlb-room__title"><a href="{{ $roomUrl }}">{{ $room->name }}</a></h3>

        <ul class="mlb-room__meta">
            @if ($room->size)
                <li>{{ $room->size }} m²</li>
            @endif
            @if ($room->max_adults)
                <li>{{ $room->max_adults }} {{ __('guests') }}</li>
            @endif
            @if ($room->number_of_beds)
                <li>{{ $room->number_of_beds }} {{ __('beds') }}</li>
            @endif
        </ul>

        @if ($description = $room->description)
            <p class="mlb-room__text">{{ Str::limit(strip_tags($description), 110) }}</p>
        @endif

        @php
            $roomAmenities = $room->amenities
                ->filter(fn ($amenity) => $amenity->getMetaData('icon_image', true) || $amenity->icon)
                ->take(6);
        @endphp

        @if ($roomAmenities->isNotEmpty())
            <ul class="mlb-room__amenities">
                @foreach ($roomAmenities as $amenity)
                    @php($amenityIcon = $amenity->getMetaData('icon_image', true))
                    <li data-tip="{{ $amenity->name }}">
                        @if ($amenityIcon)
                            <img src="{{ RvMedia::getImageUrl($amenityIcon) }}" alt="{{ $amenity->name }}" width="18" height="18" loading="lazy">
                        @else
                            <x-core::icon :name="$amenity->icon"/>
                        @endif
                        <span class="visually-hidden">{{ $amenity->name }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mlb-room__actions">
            <a class="mlb-btn mlb-btn--sm" href="{{ $roomUrl }}">{{ __('View room & book') }}</a>

            @if (! empty($room->vr360_url))
                <a class="mlb-link" href="{{ $room->vr360_url }}" target="_blank" rel="noopener noreferrer">{{ __('View in 360°') }}</a>
            @endif
        </div>
    </div>
</article>
