    <?php if(is_plugin_active('hotel')): ?>
    <?php
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
    ?>

    <div class="booking-bar" id="booking-bar">
        <div class="booking-bar-inner">
            <button type="button" class="booking-bar-btn" id="booking-toggle">
                <i class="far fa-calendar-alt"></i>
                <span><?php echo e(__('Booking')); ?></span>
            </button>
        </div>
        <div class="booking-bar-panel" id="booking-panel">
            <div class="booking-bar-panel-inner">
                <h4 class="bm-title"><?php echo e(__('MAKE RESERVATION')); ?></h4>

                <form id="booking-form" class="form-booking" method="GET" action="<?php echo e(route('public.rooms')); ?>">
                    <div class="bm-dates-row">
                        <div class="bm-date-field active" id="bm-checkin-field">
                            <label><?php echo e(__('Check In')); ?></label>
                            <input type="text" id="bm-start-date" name="start_date" placeholder="..." readonly
                                data-date-format="<?php echo e(HotelHelper::getBookingFormDateFormat()); ?>"
                                data-locale="<?php echo e(App::getLocale()); ?>">
                        </div>
                        <div class="bm-date-field" id="bm-checkout-field">
                            <label><?php echo e(__('Check Out')); ?></label>
                            <input type="text" id="bm-end-date" name="end_date" placeholder="..." readonly>
                        </div>
                    </div>

                    <div id="bm-calendar" data-datepicker-translations='<?php echo json_encode($bookingCalendarTranslations, 15, 512) ?>'></div>

                    <div class="bm-guests-row">
                        <div class="bm-guest-field">
                            <label><?php echo e(__('ADULTS')); ?></label>
                            <select name="adults">
                                <option value="1">1</option>
                                <option value="2" selected>2</option>
                                <?php for($i = 3; $i <= 10; $i++): ?>
                                    <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="bm-guest-field">
                            <label><?php echo e(__('CHILDREN')); ?></label>
                            <select name="children">
                                <?php for($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?php echo e($i); ?>" <?php if($i === 0): ?> selected <?php endif; ?>><?php echo e($i); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="booking-submit"><?php echo e(__('Check Rates')); ?></button>
                </form>

                <button type="button" class="booking-close" id="booking-close">&times;</button>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php /**PATH C:\laragon\www\main\platform\themes/riorelax/partials/booking-mask.blade.php ENDPATH**/ ?>