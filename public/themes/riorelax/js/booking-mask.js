document.addEventListener('DOMContentLoaded', function () {
    var bar = document.getElementById('booking-bar');
    var panel = document.getElementById('booking-panel');
    var toggleBtn = document.getElementById('booking-toggle');
    var closeBtn = document.getElementById('booking-close');

    if (!bar || !panel || !toggleBtn) return;

    var panelInner = panel.querySelector('.booking-bar-panel-inner');

    function updatePanelMaxHeight() {
        if (!panelInner) return;
        var rect = panel.getBoundingClientRect();
        var available = window.innerHeight - rect.top - 10;
        panelInner.style.maxHeight = Math.max(200, available) + 'px';
    }

    // Toggle panel open/close
    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        panel.classList.toggle('open');
        if (panel.classList.contains('open')) {
            updatePanelMaxHeight();
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', function () {
            panel.classList.remove('open');
        });
    }

    // Prevent clicks inside the panel from bubbling to the document listener
    // (fixes datepicker navigation causing the panel to close on re-render)
    panel.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Close when clicking outside
    document.addEventListener('click', function (e) {
        if (bar && !bar.contains(e.target)) {
            panel.classList.remove('open');
        }
    });

    // Always snap bar directly below the header
    var header = document.getElementById('header-sticky') || document.querySelector('.menu-area') || document.querySelector('.header-area');
    var rafId = null;

    function updateBarPosition() {
        if (!header) return;
        var headerBottom;
        if (header.classList.contains('sticky-menu')) {
            // When sticky (position:fixed), calculate final position ignoring
            // the fadeInDown transform animation to prevent a brief clipping glitch.
            var style = window.getComputedStyle(header);
            headerBottom = (parseFloat(style.top) || 0) + (parseFloat(style.marginTop) || 0) + header.offsetHeight;
        } else {
            headerBottom = header.getBoundingClientRect().bottom;
        }
        bar.style.top = Math.max(0, headerBottom) + 'px';
    }

    // Defer scroll updates to the next animation frame so that main.js
    // has already toggled the .sticky-menu class before we read the DOM.
    function scheduleBarUpdate() {
        if (rafId) return;
        rafId = requestAnimationFrame(function () {
            rafId = null;
            updateBarPosition();
        });
    }

    updateBarPosition();
    window.addEventListener('scroll', scheduleBarUpdate, { passive: true });
    window.addEventListener('resize', updateBarPosition);

    initBookingCalendar();

    function initBookingCalendar() {
        if (typeof jQuery === 'undefined' || typeof jQuery.fn.datepicker === 'undefined') {
            setTimeout(initBookingCalendar, 200);
            return;
        }

        var $ = jQuery;
        var $cal = $('#bm-calendar');
        var $startInput = $('#bm-start-date');
        var $endInput = $('#bm-end-date');
        var $checkinField = $('#bm-checkin-field');
        var $checkoutField = $('#bm-checkout-field');

        if (!$cal.length) return;

        var locale = $startInput.data('locale') || 'en';
        var format = $startInput.data('date-format') || 'dd-mm-yyyy';
        var datepickerTranslations = $cal.data('datepicker-translations');
        var activeField = 'checkin'; // 'checkin' or 'checkout'
        var today = new Date();
        today.setHours(0, 0, 0, 0);

        if (datepickerTranslations && $.fn.datepicker && $.fn.datepicker.dates) {
            $.fn.datepicker.dates[locale] = datepickerTranslations;
        }

        // Render inline calendar inside #bm-calendar div
        $cal.datepicker({
            todayHighlight: true,
            format: format,
            language: locale,
            startDate: today
        });

        var checkinDate = null;
        var checkoutDate = null;

        // When a date is selected on the inline calendar
        $cal.on('changeDate', function (e) {
            var selectedDate = e.date;
            if (!selectedDate) return;
            var formatted = $cal.datepicker('getFormattedDate');

            if (activeField === 'checkin') {
                checkinDate = selectedDate;
                $startInput.val(formatted);

                // Auto-switch to checkout
                activeField = 'checkout';
                $checkinField.removeClass('active');
                $checkoutField.addClass('active');

                // Clear checkout if it's before new checkin
                if (checkoutDate && checkoutDate <= selectedDate) {
                    checkoutDate = null;
                    $endInput.val('');
                }
            } else {
                if (checkinDate && selectedDate <= checkinDate) {
                    return; // Don't allow checkout <= checkin
                }
                checkoutDate = selectedDate;
                $endInput.val(formatted);
            }
        });

        // Click on Check In field → switch mode
        $checkinField.on('click', function () {
            activeField = 'checkin';
            $checkinField.addClass('active');
            $checkoutField.removeClass('active');
        });

        // Click on Check Out field → switch mode
        $checkoutField.on('click', function () {
            activeField = 'checkout';
            $checkoutField.addClass('active');
            $checkinField.removeClass('active');
        });
    }
});
