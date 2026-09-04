{{-- Inline booking strip: overlaps the hero, sticks to the top once scrolled past --}}
@php
    $minGuests = HotelHelper::getMinimumNumberOfGuests();
    $maxGuests = max(HotelHelper::getMaximumNumberOfGuests(), $minGuests + 1);
    $startDate = Carbon\Carbon::now()->format(HotelHelper::getDateFormat());
    $endDate = Carbon\Carbon::now()->addDay()->format(HotelHelper::getDateFormat());
    $trustItems = array_values(array_filter(array_map('trim', explode(';', (string) $shortcode->trust_items))));
    $promoEnabled = $shortcode->promo_enabled !== '0';
@endphp

<section class="mlb-booking" id="mlb-booking">
    <div class="mlb-booking__shell">
        <div class="mlb-booking__inner">
            <p class="mlb-booking__eyebrow" data-mlb-greeting data-default="{{ $shortcode->title ?: __('Book direct') }}">
                {{ $shortcode->title ?: __('Book direct') }}
            </p>

            <form class="mlb-booking__form form-booking" method="GET" action="{{ route('public.rooms') }}" data-mlb-booking-form>
                <div class="mlb-booking__field mlb-booking__field--date">
                    <label for="mlb-start-date">{{ __('Arrival date') }}</label>
                    <input
                        type="text"
                        id="mlb-start-date"
                        name="start_date"
                        class="date-picker"
                        autocomplete="off"
                        data-date-format="{{ HotelHelper::getBookingFormDateFormat() }}"
                        data-locale="{{ App::getLocale() }}"
                        placeholder="{{ $startDate }}"
                        value="{{ $startDate }}"
                    >
                </div>

                <div class="mlb-booking__field mlb-booking__field--date">
                    <label for="mlb-end-date">{{ __('Departure date') }}</label>
                    <input
                        type="text"
                        id="mlb-end-date"
                        name="end_date"
                        class="date-picker"
                        autocomplete="off"
                        data-date-format="{{ HotelHelper::getBookingFormDateFormat() }}"
                        data-locale="{{ App::getLocale() }}"
                        placeholder="{{ $endDate }}"
                        value="{{ $endDate }}"
                    >
                </div>

                <div class="mlb-booking__field">
                    <label for="mlb-adults">{{ __('Adult guests') }}</label>
                    <select id="mlb-adults" name="adults">
                        @for ($i = $minGuests; $i <= $maxGuests; $i++)
                            <option value="{{ $i }}" @selected($i === 2)>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mlb-booking__field">
                    <label for="mlb-children">{{ __('Child guests') }}</label>
                    <select id="mlb-children" name="children">
                        @for ($i = 0; $i <= 6; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                @if ($promoEnabled)
                    <div class="mlb-booking__field mlb-booking__field--promo">
                        <label for="mlb-promo">{{ __('Promo code') }}</label>
                        <input type="text" id="mlb-promo" name="coupon_code" autocomplete="off" placeholder="{{ __('Optional') }}">
                    </div>
                @endif

                <button type="submit" class="mlb-booking__submit">
                    {{ $shortcode->button_label ?: __('Check rates') }}
                </button>
            </form>

            @if ($trustItems)
                <ul class="mlb-booking__trust">
                    @foreach ($trustItems as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- strings home.js needs for the personalised greeting --}}
    @php
        $mlbI18n = [
            'morning' => __('Good morning'),
            'afternoon' => __('Good afternoon'),
            'evening' => __('Good evening'),
            'welcomeBack' => __('Welcome back'),
            'continueStay' => __('Continue your stay'),
            'guests' => __('guests'),
        ];
    @endphp
    <script type="application/json" data-mlb-i18n>@json($mlbI18n)</script>
</section>
