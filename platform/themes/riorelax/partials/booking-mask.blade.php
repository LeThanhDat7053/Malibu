    @if (is_plugin_active('hotel') && theme_option('booking_button_enabled', 'yes') !== 'no')
    @php
        $bookingCalendarTranslations = [
            'days' => [
                __('Sunday'),
                __('Monday'),
                __('Tuesday'),
                __('Wednesday'),
                __('Thursday'),
                __('Friday'),
                __('Saturday'),
                __('Sunday'),
            ],
            'daysShort' => [
                __('Sun'),
                __('Mon'),
                __('Tue'),
                __('Wed'),
                __('Thu'),
                __('Fri'),
                __('Sat'),
                __('Sun'),
            ],
            'daysMin' => [
                __('Su'),
                __('Mo'),
                __('Tu'),
                __('We'),
                __('Th'),
                __('Fr'),
                __('Sa'),
                __('Su'),
            ],
            'months' => [
                __('January'),
                __('February'),
                __('March'),
                __('April'),
                __('May'),
                __('June'),
                __('July'),
                __('August'),
                __('September'),
                __('October'),
                __('November'),
                __('December'),
            ],
            'monthsShort' => [
                __('Jan'),
                __('Feb'),
                __('Mar'),
                __('Apr'),
                __('May'),
                __('Jun'),
                __('Jul'),
                __('Aug'),
                __('Sep'),
                __('Oct'),
                __('Nov'),
                __('Dec'),
            ],
            'today' => __('Today'),
            'clear' => __('Clear'),
        ];
    @endphp

    @php
        // Nhan, duong dan va mau lay tu Theme Options > Nut dat phong.
        $bookingLabel = theme_option('booking_button_label') ?: __('Booking');
        $bookingUrl = trim((string) theme_option('booking_button_url'));
        $bookingNewTab = theme_option('booking_button_new_tab', 'yes') !== 'no';
    @endphp

    <div class="booking-bar" id="booking-bar">
        <div class="booking-bar-inner">
            @if ($bookingUrl)
                {{-- Da dat URL: nut tro thang sang he thong dat phong ben ngoai --}}
                <a href="{{ $bookingUrl }}" class="booking-bar-btn"
                   @if ($bookingNewTab) target="_blank" rel="noopener noreferrer" @endif>
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ $bookingLabel }}</span>
                </a>
            @else
                <button type="button" class="booking-bar-btn" id="booking-toggle">
                    <i class="far fa-calendar-alt"></i>
                    <span>{{ $bookingLabel }}</span>
                </button>
            @endif
        </div>
        <div class="booking-bar-panel" id="booking-panel">
            <div class="booking-bar-panel-inner">
                <h4 class="bm-title">{{ __('MAKE RESERVATION') }}</h4>

                <form id="booking-form" class="form-booking" method="GET" action="{{ route('public.rooms') }}">
                    <div class="bm-dates-row">
                        <div class="bm-date-field active" id="bm-checkin-field">
                            <label>{{ __('Check In') }}</label>
                            <input type="text" id="bm-start-date" name="start_date" placeholder="..." readonly
                                data-date-format="{{ HotelHelper::getBookingFormDateFormat() }}"
                                data-locale="{{ App::getLocale() }}">
                        </div>
                        <div class="bm-date-field" id="bm-checkout-field">
                            <label>{{ __('Check Out') }}</label>
                            <input type="text" id="bm-end-date" name="end_date" placeholder="..." readonly>
                        </div>
                    </div>

                    <div id="bm-calendar" data-datepicker-translations='@json($bookingCalendarTranslations)'></div>

                    <div class="bm-guests-row">
                        <div class="bm-guest-field">
                            <label>{{ __('ADULTS') }}</label>
                            <select name="adults">
                                <option value="1">1</option>
                                <option value="2" selected>2</option>
                                @for ($i = 3; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="bm-guest-field">
                            <label>{{ __('CHILDREN') }}</label>
                            <select name="children">
                                @for ($i = 0; $i <= 10; $i++)
                                    <option value="{{ $i }}" @if($i === 0) selected @endif>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="booking-submit">{{ __('Check Rates') }}</button>
                </form>

                <button type="button" class="booking-close" id="booking-close">&times;</button>
            </div>
        </div>
    </div>
    @endif
