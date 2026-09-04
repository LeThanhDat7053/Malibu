{{-- Location: contact block + nearby places on the left, lazily-loaded map on the right --}}
@php
    $address = $shortcode->address ?: theme_option('address');
    $phone = $shortcode->phone ?: theme_option('hotline');
    $email = $shortcode->email ?: theme_option('email');
    $mapUrl = $shortcode->map_embed_url;
    $directionsUrl = $shortcode->directions_url;
@endphp

<section class="mlb-location">
    <div class="mlb-shell">
        <div class="mlb-location__grid">
            <div class="mlb-location__info">
                @if ($subtitle = $shortcode->subtitle)
                    <p class="mlb-eyebrow">{{ $subtitle }}</p>
                @endif

                @if ($title = $shortcode->title)
                    <h2 class="mlb-display">{!! BaseHelper::clean($title) !!}</h2>
                @endif

                <dl class="mlb-location__contact">
                    @if ($address)
                        <div>
                            <dt>{{ __('Hotel address') }}</dt>
                            <dd>{{ $address }}</dd>
                        </div>
                    @endif

                    @if ($phone)
                        <div>
                            <dt>{{ __('Telephone') }}</dt>
                            <dd><a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}">{{ $phone }}</a></dd>
                        </div>
                    @endif

                    @if ($email)
                        <div>
                            <dt>{{ __('Email address') }}</dt>
                            <dd><a href="mailto:{{ $email }}">{{ $email }}</a></dd>
                        </div>
                    @endif
                </dl>

                @if ($directionsUrl)
                    <a class="mlb-btn" href="{{ $directionsUrl }}" target="_blank" rel="noopener noreferrer">
                        {{ $shortcode->button_label ?: __('Get directions') }}
                    </a>
                @endif

                @if (! empty($places) && $places->isNotEmpty())
                    <div class="mlb-location__places">
                        <p class="mlb-eyebrow mlb-eyebrow--sm">{{ $shortcode->places_title ?: __('Nearby') }}</p>
                        <ul>
                            @foreach ($places as $place)
                                <li>
                                    <a href="{{ $place->url }}">{{ $place->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            @if ($mapUrl)
                <div class="mlb-location__map" data-mlb-map data-src="{{ $mapUrl }}">
                    <noscript>
                        <iframe src="{{ $mapUrl }}" title="{{ __('Map') }}" loading="lazy"></iframe>
                    </noscript>
                </div>
            @endif
        </div>
    </div>
</section>
