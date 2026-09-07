{{-- Hộp đặt phòng nhanh dùng chung cho booking-strip, simple-slider và video-section --}}
@php
    $variant = $variant ?? 'hero';
    $buttonLabel = $buttonLabel ?: __('Check rates');
    $promoEnabled = $promoEnabled ?? true;
    $trustItems = $trustItems ?? [];
    $boxTitle = $boxTitle ?? null;

    $minGuests = HotelHelper::getMinimumNumberOfGuests();
    $maxGuests = max(HotelHelper::getMaximumNumberOfGuests(), $minGuests + 1);
    $dateFormat = HotelHelper::getDateFormat();
    $startDate = Carbon\Carbon::now();
    $endDate = Carbon\Carbon::now()->addDay();

    $calendarI18n = [
        'daysMin' => [__('Su'), __('Mo'), __('Tu'), __('We'), __('Th'), __('Fr'), __('Sa')],
        'months' => [
            __('January'), __('February'), __('March'), __('April'), __('May'), __('June'),
            __('July'), __('August'), __('September'), __('October'), __('November'), __('December'),
        ],
        'monthsShort' => [
            __('Jan'), __('Feb'), __('Mar'), __('Apr'), __('May'), __('Jun'),
            __('Jul'), __('Aug'), __('Sep'), __('Oct'), __('Nov'), __('Dec'),
        ],
        'clear' => __('Clear'),
        'apply' => __('Apply'),
        'night' => __('night'),
        'nights' => __('nights'),
        'placeholder' => __('Select your dates'),
        'format' => HotelHelper::getBookingFormDateFormat(),
    ];
@endphp

<section class="mlb-booking mlb-booking--{{ $variant }}" id="mlb-booking">
    <div class="mlb-booking__shell">
        <div class="mlb-booking__inner">
            @if ($boxTitle)
                <p class="mlb-booking__eyebrow">{{ $boxTitle }}</p>
            @endif

            <form class="mlb-booking__form form-booking" method="GET" action="{{ route('public.rooms') }}" data-mlb-booking-form>
                {{-- một ô duy nhất cho cả kỳ nghỉ, lịch hai tháng bung ra khi bấm --}}
                <div class="mlb-booking__field mlb-booking__field--range" data-mlb-range data-i18n='@json($calendarI18n)'>
                    <label for="mlb-range-trigger">{{ __('Date') }}</label>

                    <button type="button" class="mlb-range__value" id="mlb-range-trigger" data-mlb-range-trigger aria-haspopup="dialog" aria-expanded="false">
                        <span class="mlb-range__text" data-mlb-range-text>{{ $startDate->format($dateFormat) }} — {{ $endDate->format($dateFormat) }}</span>
                        <span class="mlb-range__nights" data-mlb-range-nights></span>
                    </button>

                    <input type="hidden" id="mlb-start-date" name="start_date" value="{{ $startDate->format($dateFormat) }}">
                    <input type="hidden" id="mlb-end-date" name="end_date" value="{{ $endDate->format($dateFormat) }}">

                    <div class="mlb-range__pop" data-mlb-range-pop role="dialog" aria-label="{{ __('Date') }}" hidden>
                        <div class="mlb-range__body" data-mlb-range-body></div>
                        <div class="mlb-range__foot">
                            <span class="mlb-range__summary" data-mlb-range-summary></span>
                            <button type="button" class="mlb-range__btn mlb-range__btn--clear" data-mlb-range-clear>{{ __('Clear') }}</button>
                            <button type="button" class="mlb-range__btn mlb-range__btn--apply" data-mlb-range-apply>{{ __('Apply') }}</button>
                        </div>
                    </div>
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

                <button type="submit" class="mlb-booking__submit">{{ $buttonLabel }}</button>
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

    {{-- chuỗi dịch cho lời chào cá nhân hoá trong home.js --}}
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
