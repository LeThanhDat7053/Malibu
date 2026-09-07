/* Malibu homepage behaviour: lightweight personalisation, lazy embeds, reveal-on-scroll.
   Everything degrades to a working static page if localStorage or JS features are missing. */
;(function ($) {
    'use strict'

    var STAY_KEY = 'mlb.stay'
    var ROOMS_KEY = 'mlb.rooms'
    var COUPON_KEY = 'mlb.coupon'
    var ROOMS_LIMIT = 6

    var I18N = {
        morning: 'Good morning',
        afternoon: 'Good afternoon',
        evening: 'Good evening',
        welcomeBack: 'Welcome back',
        continueStay: 'Continue your stay',
        guests: 'guests',
    }

    function loadI18n() {
        var node = document.querySelector('[data-mlb-i18n]')

        if (!node) {
            return
        }

        try {
            var parsed = JSON.parse(node.textContent)

            Object.keys(parsed).forEach(function (key) {
                if (parsed[key]) {
                    I18N[key] = parsed[key]
                }
            })
        } catch (e) {
            /* keep the English fallbacks */
        }
    }

    // ---------------------------------------------------------------- storage

    function readJson(key, fallback) {
        try {
            var raw = window.localStorage.getItem(key)
            return raw ? JSON.parse(raw) : fallback
        } catch (e) {
            return fallback
        }
    }

    function writeJson(key, value) {
        try {
            window.localStorage.setItem(key, JSON.stringify(value))
        } catch (e) {
            /* private mode or storage disabled — personalisation is simply skipped */
        }
    }

    function removeKey(key) {
        try {
            window.localStorage.removeItem(key)
        } catch (e) {}
    }

    function startOfToday() {
        var now = new Date()
        return new Date(now.getFullYear(), now.getMonth(), now.getDate())
    }

    // ------------------------------------------------------------ room history

    function trackRoomView() {
        var node = document.querySelector('[data-mlb-room]')

        if (!node) {
            return
        }

        var id = parseInt(node.getAttribute('data-mlb-room'), 10)

        if (!id) {
            return
        }

        var history = readJson(ROOMS_KEY, [])

        if (!Array.isArray(history)) {
            history = []
        }

        history = history.filter(function (item) {
            return item !== id
        })
        history.unshift(id)

        writeJson(ROOMS_KEY, history.slice(0, ROOMS_LIMIT))
    }

    function renderRecentlyViewed() {
        var section = document.querySelector('[data-mlb-recent]')

        if (!section) {
            return
        }

        var dataNode = section.querySelector('[data-mlb-recent-data]')
        var track = section.querySelector('[data-mlb-recent-track]')

        if (!dataNode || !track) {
            return
        }

        var history = readJson(ROOMS_KEY, [])

        if (!Array.isArray(history) || !history.length) {
            return
        }

        var rooms

        try {
            rooms = JSON.parse(dataNode.textContent)
        } catch (e) {
            return
        }

        var byId = {}
        rooms.forEach(function (room) {
            byId[room.id] = room
        })

        var picked = history
            .map(function (id) {
                return byId[id]
            })
            .filter(Boolean)

        if (!picked.length) {
            return
        }

        track.innerHTML = ''

        picked.forEach(function (room) {
            var card = document.createElement('a')
            card.className = 'mlb-recent__card'
            card.href = room.url

            if (room.image) {
                var img = document.createElement('img')
                img.src = room.image
                img.alt = room.name
                img.loading = 'lazy'
                card.appendChild(img)
            }

            var body = document.createElement('span')

            var name = document.createElement('span')
            name.className = 'mlb-recent__name'
            name.textContent = room.name
            body.appendChild(name)

            var bits = []
            if (room.size) {
                bits.push(room.size + ' m²')
            }
            if (room.adults) {
                bits.push(room.adults + ' ' + I18N.guests)
            }

            if (bits.length) {
                var meta = document.createElement('span')
                meta.className = 'mlb-recent__meta'
                meta.textContent = bits.join(' · ')
                body.appendChild(meta)
            }

            card.appendChild(body)
            track.appendChild(card)
        })

        section.hidden = false

        var clear = section.querySelector('[data-mlb-recent-clear]')

        if (clear) {
            clear.addEventListener('click', function () {
                removeKey(ROOMS_KEY)
                section.hidden = true
            })
        }
    }

    // ------------------------------------------------------------ date range

    var RANGE_I18N = {
        daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        months: [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December',
        ],
        monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        clear: 'Clear',
        apply: 'Apply',
        night: 'night',
        nights: 'nights',
        placeholder: 'Select your dates',
        format: 'dd-mm-yyyy',
    }

    function pad(value) {
        return value < 10 ? '0' + value : '' + value
    }

    function midnight(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate())
    }

    function addDays(date, count) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate() + count)
    }

    function sameDay(a, b) {
        return !!a && !!b && a.getTime() === b.getTime()
    }

    // Mọi định dạng plugin Hotel hỗ trợ đều là dd/mm/yyyy có độ dài cố định
    function formatDate(date, format) {
        return format
            .replace('yyyy', date.getFullYear())
            .replace('mm', pad(date.getMonth() + 1))
            .replace('dd', pad(date.getDate()))
    }

    function parseDate(text, format) {
        if (!text) {
            return null
        }

        var year = parseInt(text.substr(format.indexOf('yyyy'), 4), 10)
        var month = parseInt(text.substr(format.indexOf('mm'), 2), 10)
        var day = parseInt(text.substr(format.indexOf('dd'), 2), 10)

        if (!year || !month || !day) {
            return null
        }

        return new Date(year, month - 1, day)
    }

    function createDateRange(root) {
        var trigger = root.querySelector('[data-mlb-range-trigger]')
        var pop = root.querySelector('[data-mlb-range-pop]')
        var body = root.querySelector('[data-mlb-range-body]')
        var textEl = root.querySelector('[data-mlb-range-text]')
        var nightsEl = root.querySelector('[data-mlb-range-nights]')
        var summaryEl = root.querySelector('[data-mlb-range-summary]')
        var clearBtn = root.querySelector('[data-mlb-range-clear]')
        var applyBtn = root.querySelector('[data-mlb-range-apply]')
        var startInput = root.querySelector('input[name="start_date"]')
        var endInput = root.querySelector('input[name="end_date"]')

        if (!trigger || !pop || !body || !startInput || !endInput) {
            return null
        }

        var i18n = $.extend({}, RANGE_I18N)

        try {
            $.extend(i18n, JSON.parse(root.getAttribute('data-i18n')))
        } catch (e) {
            /* thiếu chuỗi dịch thì dùng bản tiếng Anh mặc định */
        }

        var locale = document.documentElement.lang || 'en'
        var today = midnight(new Date())
        var format = i18n.format
        var backdrop = null

        var start = parseDate(startInput.value, format) || today
        var end = parseDate(endInput.value, format) || addDays(today, 1)
        var draftStart = start
        var draftEnd = end
        var hover = null
        var view = new Date(start.getFullYear(), start.getMonth(), 1)

        function longDate(date) {
            try {
                return date.toLocaleDateString(locale, { day: 'numeric', month: 'long', year: 'numeric' })
            } catch (e) {
                return i18n.months[date.getMonth()] + ' ' + date.getDate() + ', ' + date.getFullYear()
            }
        }

        function monthTitle(date) {
            try {
                return date.toLocaleDateString(locale, { month: 'short', year: 'numeric' })
            } catch (e) {
                return i18n.monthsShort[date.getMonth()] + ' ' + date.getFullYear()
            }
        }

        function nightsBetween(from, to) {
            return Math.round((to.getTime() - from.getTime()) / 86400000)
        }

        function paintField() {
            textEl.textContent = longDate(start) + ' — ' + longDate(end)
            var nights = nightsBetween(start, end)
            nightsEl.textContent = nights + ' ' + (nights === 1 ? i18n.night : i18n.nights)
            startInput.value = formatDate(start, format)
            endInput.value = formatDate(end, format)
        }

        function paintSummary() {
            if (!draftStart) {
                summaryEl.textContent = i18n.placeholder
                return
            }

            summaryEl.textContent = draftEnd
                ? formatDate(draftStart, format) + ' - ' + formatDate(draftEnd, format)
                : formatDate(draftStart, format) + ' - …'
        }

        function edge() {
            return draftEnd || (draftStart && hover && hover > draftStart ? hover : null)
        }

        function dayClass(date, inMonth) {
            var classes = ['mlb-range__day']
            var last = edge()

            if (!inMonth) {
                classes.push('is-muted')
            }

            if (sameDay(date, draftStart)) {
                classes.push('is-start')
            } else if (sameDay(date, last)) {
                classes.push('is-end')
            } else if (draftStart && last && date > draftStart && date < last) {
                classes.push('is-between')
            }

            return classes.join(' ')
        }

        function buildMonth(offset) {
            var first = new Date(view.getFullYear(), view.getMonth() + offset, 1)
            var cal = document.createElement('div')
            cal.className = 'mlb-range__cal'

            var head = document.createElement('div')
            head.className = 'mlb-range__cal-head'

            var prev = document.createElement('button')
            prev.type = 'button'
            prev.className = 'mlb-range__step'
            prev.innerHTML = '&lsaquo;'
            prev.setAttribute('aria-label', 'Previous month')
            prev.hidden = offset !== 0 || view <= new Date(today.getFullYear(), today.getMonth(), 1)
            prev.addEventListener('click', function () {
                view = new Date(view.getFullYear(), view.getMonth() - 1, 1)
                render()
            })

            var title = document.createElement('span')
            title.className = 'mlb-range__title'
            title.textContent = monthTitle(first)

            var next = document.createElement('button')
            next.type = 'button'
            next.className = 'mlb-range__step'
            next.innerHTML = '&rsaquo;'
            next.setAttribute('aria-label', 'Next month')
            next.hidden = offset !== 1
            next.addEventListener('click', function () {
                view = new Date(view.getFullYear(), view.getMonth() + 1, 1)
                render()
            })

            head.appendChild(prev)
            head.appendChild(title)
            head.appendChild(next)
            cal.appendChild(head)

            var grid = document.createElement('div')
            grid.className = 'mlb-range__grid'

            i18n.daysMin.forEach(function (name) {
                var cell = document.createElement('span')
                cell.className = 'mlb-range__dow'
                cell.textContent = name
                grid.appendChild(cell)
            })

            var lead = first.getDay()

            for (var i = 0; i < 42; i++) {
                var date = new Date(first.getFullYear(), first.getMonth(), 1 - lead + i)
                var inMonth = date.getMonth() === first.getMonth()
                var cell = document.createElement('button')

                cell.type = 'button'
                cell.className = dayClass(date, inMonth)
                cell.textContent = date.getDate()
                cell.disabled = date < today

                if (!cell.disabled) {
                    ;(function (picked) {
                        cell.addEventListener('click', function () {
                            pick(picked)
                        })
                        cell.addEventListener('mouseenter', function () {
                            if (draftStart && !draftEnd) {
                                hover = picked
                                render()
                            }
                        })
                    })(date)
                }

                grid.appendChild(cell)
            }

            cal.appendChild(grid)

            return cal
        }

        function pick(date) {
            if (!draftStart || draftEnd || date <= draftStart) {
                draftStart = date
                draftEnd = null
            } else {
                draftEnd = date
            }

            hover = null
            render()
        }

        function render() {
            body.innerHTML = ''
            body.appendChild(buildMonth(0))
            body.appendChild(buildMonth(1))
            paintSummary()
        }

        function open() {
            draftStart = start
            draftEnd = end
            hover = null
            view = new Date(start.getFullYear(), start.getMonth(), 1)

            if (view < new Date(today.getFullYear(), today.getMonth(), 1)) {
                view = new Date(today.getFullYear(), today.getMonth(), 1)
            }

            render()
            pop.hidden = false
            trigger.setAttribute('aria-expanded', 'true')

            backdrop = document.createElement('div')
            backdrop.className = 'mlb-range__backdrop'
            backdrop.addEventListener('click', close)
            document.body.appendChild(backdrop)
        }

        function close() {
            pop.hidden = true
            trigger.setAttribute('aria-expanded', 'false')

            if (backdrop) {
                backdrop.remove()
                backdrop = null
            }
        }

        function commit() {
            if (draftStart) {
                start = draftStart
                end = draftEnd && draftEnd > draftStart ? draftEnd : addDays(draftStart, 1)
            }

            paintField()
            close()
        }

        trigger.addEventListener('click', function (event) {
            event.preventDefault()
            pop.hidden ? open() : close()
        })

        pop.addEventListener('click', function (event) {
            event.stopPropagation()
        })

        document.addEventListener('click', function (event) {
            if (!pop.hidden && !root.contains(event.target)) {
                close()
            }
        })

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !pop.hidden) {
                close()
            }
        })

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                draftStart = null
                draftEnd = null
                hover = null
                render()
            })
        }

        if (applyBtn) {
            applyBtn.addEventListener('click', commit)
        }

        paintField()

        return {
            set: function (from, to) {
                start = midnight(from)
                end = to && midnight(to) > start ? midnight(to) : addDays(start, 1)
                paintField()
            },
            value: function () {
                return {
                    start: start,
                    end: end,
                    startText: startInput.value,
                    endText: endInput.value,
                }
            },
        }
    }

    // ----------------------------------------------------------- booking strip

    function initBookingStrip() {
        var form = document.querySelector('[data-mlb-booking-form]')

        if (!form) {
            return
        }

        var rangeRoot = form.querySelector('[data-mlb-range]')
        var range = rangeRoot ? createDateRange(rangeRoot) : null
        var $adults = $(form).find('#mlb-adults')
        var $children = $(form).find('#mlb-children')
        var $promo = $(form).find('#mlb-promo')

        restoreStay(range, $adults, $children)
        deferFloatingBar()

        form.addEventListener('submit', function () {
            var stay = range ? range.value() : null

            writeJson(STAY_KEY, {
                startText: stay ? stay.startText : '',
                endText: stay ? stay.endText : '',
                startTime: stay ? stay.start.getTime() : null,
                endTime: stay ? stay.end.getTime() : null,
                adults: $adults.val(),
                children: $children.val(),
            })

            var coupon = $promo.length ? $.trim($promo.val()) : ''

            if (coupon) {
                writeJson(COUPON_KEY, coupon)
            }
        })
    }

    function restoreStay(range, $adults, $children) {
        var stay = readJson(STAY_KEY, null)

        if (!stay || !stay.startTime) {
            greet(null)
            return
        }

        // a saved stay whose check-in has passed is worse than no suggestion at all
        if (stay.startTime < startOfToday().getTime()) {
            removeKey(STAY_KEY)
            greet(null)
            return
        }

        if (range) {
            range.set(new Date(stay.startTime), stay.endTime ? new Date(stay.endTime) : null)
            stay.startText = range.value().startText
            stay.endText = range.value().endText
        }

        if (stay.adults) {
            $adults.val(stay.adults)
        }

        if (stay.children) {
            $children.val(stay.children)
        }

        greet(stay)
    }

    function greet(stay) {
        var node = document.querySelector('[data-mlb-greeting]')

        if (!node) {
            return
        }

        if (stay) {
            var guests = parseInt(stay.adults, 10) || 0
            guests += parseInt(stay.children, 10) || 0

            node.textContent =
                I18N.continueStay +
                ' ' +
                stay.startText +
                ' → ' +
                stay.endText +
                (guests ? ' · ' + guests + ' ' + I18N.guests : '')

            return
        }

        var hour = new Date().getHours()
        var part = hour < 11 ? I18N.morning : hour < 18 ? I18N.afternoon : I18N.evening
        var history = readJson(ROOMS_KEY, [])

        if (Array.isArray(history) && history.length) {
            part = I18N.welcomeBack
        }

        node.textContent = part + ' — ' + (node.getAttribute('data-default') || '')
    }

    // The theme's floating booking bar is fixed near the top-right, exactly where the
    // in-page strip sits. Hide it until the page has scrolled past that strip.
    // Deliberately not an IntersectionObserver: during a fast scroll it can deliver a
    // stale "still intersecting" entry after a newer one and flick the bar back off.
    function deferFloatingBar() {
        var strip = document.querySelector('.mlb-booking')
        var bar = document.querySelector('.booking-bar')

        if (!strip || !bar) {
            return
        }

        var showFrom = 0
        var ticking = false

        function measure() {
            showFrom = strip.getBoundingClientRect().bottom + window.pageYOffset
            sync()
        }

        function sync() {
            document.body.classList.toggle('mlb-bar-hidden', window.pageYOffset < showFrom)
        }

        function onScroll() {
            if (ticking) {
                return
            }

            ticking = true
            window.requestAnimationFrame(function () {
                ticking = false
                sync()
            })
        }

        measure()
        window.addEventListener('scroll', onScroll, { passive: true })
        window.addEventListener('resize', measure)
        window.addEventListener('load', measure)
    }

    // prefill the coupon field on the booking page with what was typed on the homepage
    function applyStoredCoupon() {
        var input = document.getElementById('coupon_code')

        if (!input || input.value) {
            return
        }

        var coupon = readJson(COUPON_KEY, null)

        if (!coupon) {
            return
        }

        input.value = coupon

        var panel = input.closest('.coupon-form')

        if (panel) {
            panel.style.display = 'block'
        }
    }

    // -------------------------------------------------------------- panorama

    function initPanorama() {
        document.querySelectorAll('[data-mlb-panorama]').forEach(function (section) {
            var stage = section.querySelector('[data-mlb-panorama-stage]')
            var launch = section.querySelector('[data-mlb-panorama-launch]')
            var external = section.querySelector('[data-mlb-panorama-external]')

            if (!stage) {
                return
            }

            function mount(url) {
                var frame = stage.querySelector('iframe')

                if (!frame) {
                    frame = document.createElement('iframe')
                    frame.setAttribute('allowfullscreen', 'true')
                    frame.setAttribute('allow', 'accelerometer; gyroscope; fullscreen; xr-spatial-tracking')
                    frame.setAttribute('loading', 'lazy')
                    frame.setAttribute('title', '360°')
                    stage.appendChild(frame)

                    var poster = stage.querySelector('.mlb-panorama__poster')

                    if (poster) {
                        poster.style.display = 'none'
                    }

                    if (launch) {
                        launch.style.display = 'none'
                    }
                }

                frame.src = url
            }

            if (launch) {
                launch.addEventListener('click', function () {
                    mount(stage.getAttribute('data-url'))
                })
            }

            section.querySelectorAll('[data-mlb-panorama-scene]').forEach(function (button) {
                button.addEventListener('click', function () {
                    var url = button.getAttribute('data-url')

                    section.querySelectorAll('[data-mlb-panorama-scene]').forEach(function (other) {
                        other.classList.toggle('is-active', other === button)
                        other.setAttribute('aria-selected', other === button ? 'true' : 'false')
                    })

                    stage.setAttribute('data-url', url)

                    if (external) {
                        external.href = url
                    }

                    if (stage.querySelector('iframe')) {
                        mount(url)
                    }
                })
            })
        })
    }

    // ------------------------------------------------------------------- map

    function initMap() {
        var holders = document.querySelectorAll('[data-mlb-map]')

        if (!holders.length) {
            return
        }

        function mount(holder) {
            if (holder.querySelector('iframe')) {
                return
            }

            var frame = document.createElement('iframe')
            frame.src = holder.getAttribute('data-src')
            frame.title = 'Map'
            frame.loading = 'lazy'
            frame.setAttribute('referrerpolicy', 'no-referrer-when-downgrade')
            frame.setAttribute('allowfullscreen', 'true')
            holder.appendChild(frame)
        }

        if (!('IntersectionObserver' in window)) {
            holders.forEach(mount)
            return
        }

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        mount(entry.target)
                        observer.unobserve(entry.target)
                    }
                })
            },
            { rootMargin: '200px' }
        )

        holders.forEach(function (holder) {
            observer.observe(holder)
        })
    }

    // --------------------------------------------------------------- sliders

    // Mọi khối một hàng (cột nổi bật, ưu đãi, giải thưởng) dùng chung một bộ tuỳ chọn slick
    function initSliders() {
        if (!$.fn.slick) {
            return
        }

        var rtl = document.body.getAttribute('dir') === 'rtl'

        $('[data-mlb-slider]').each(function () {
            var $el = $(this)

            if ($el.hasClass('slick-initialized')) {
                return
            }

            var read = function (name, fallback) {
                return parseInt($el.attr('data-per-view' + name), 10) || fallback
            }

            var per = read('', 3)
            var lg = read('-lg', per)
            var md = read('-md', lg)
            var sm = read('-sm', md)
            var xs = read('-xs', 1)
            var total = $el.children().length

            $el.slick({
                slidesToShow: per,
                slidesToScroll: 1,
                infinite: total > per,
                autoplay: $el.attr('data-autoplay') === '1',
                autoplaySpeed: 4000,
                pauseOnHover: true,
                speed: 650,
                cssEase: 'cubic-bezier(0.22, 0.61, 0.36, 1)',
                arrows: true,
                dots: $el.attr('data-dots') !== '0',
                rtl: rtl,
                prevArrow: '<button type="button" class="mlb-slider__nav mlb-slider__nav--prev" aria-label="Previous"></button>',
                nextArrow: '<button type="button" class="mlb-slider__nav mlb-slider__nav--next" aria-label="Next"></button>',
                responsive: [
                    { breakpoint: 1400, settings: { slidesToShow: lg, infinite: total > lg } },
                    { breakpoint: 1200, settings: { slidesToShow: md, infinite: total > md } },
                    { breakpoint: 992, settings: { slidesToShow: sm, infinite: total > sm } },
                    { breakpoint: 576, settings: { slidesToShow: xs, infinite: total > xs } },
                ],
            })
        })
    }

    // ----------------------------------------------------------------- video

    // Bố cục chia đôi chỉ nạp iframe YouTube khi khách bấm play
    function initVideoEmbed() {
        document.querySelectorAll('[data-mlb-video-embed]').forEach(function (button) {
            button.addEventListener('click', function () {
                var frame = document.createElement('div')
                frame.className = 'mlb-video__frame'

                var iframe = document.createElement('iframe')
                iframe.src = button.getAttribute('data-mlb-video-embed')
                iframe.title = button.getAttribute('aria-label') || ''
                iframe.setAttribute('frameborder', '0')
                iframe.setAttribute('allow', 'autoplay; encrypted-media; picture-in-picture; fullscreen')
                iframe.setAttribute('allowfullscreen', '')

                frame.appendChild(iframe)
                button.parentNode.replaceChild(frame, button)
            })
        })
    }

    // ---------------------------------------------------------------- reveal

    // Each entry: selector, motion, per-item stagger in ms (0 = no stagger).
    // Stagger is counted within the item's own parent, so each grid restarts at 0.
    var REVEAL_GROUPS = [
        ['.mlb-section-head', 'up', 0],
        ['.mlb-rooms__grid .mlb-room', 'up', 90],
        ['.mlb-columns__grid:not([data-mlb-slider]) .mlb-card', 'up', 90],
        ['.mlb-offers__grid:not([data-mlb-slider]) .mlb-offer', 'up', 90],
        ['.mlb-columns__grid[data-mlb-slider]', 'up', 0],
        ['.mlb-offers__grid[data-mlb-slider]', 'up', 0],
        ['.mlb-awards__track', 'up', 0],
        ['.mlb-video__grid', 'up', 0],
        ['.mlb-signature__item', 'left', 110],
        ['.mlb-recent__card', 'up', 60],
        ['.mlb-location__grid', 'up', 0],
        ['.mlb-rooms__foot', 'up', 0],
    ]

    var STAGGER_CAP = 4 // beyond this the delay stops growing, so long lists stay snappy

    function initReveal() {
        var home = document.querySelector('.mlb-home')

        if (!home || !('IntersectionObserver' in window)) {
            return
        }

        var targets = []
        var counters = []

        REVEAL_GROUPS.forEach(function (group) {
            var selector = group[0]
            var motion = group[1]
            var stagger = group[2]

            home.querySelectorAll(selector).forEach(function (el) {
                if (el.hasAttribute('data-mlb-reveal')) {
                    return
                }

                el.setAttribute('data-mlb-reveal', motion)

                if (stagger) {
                    var parent = el.parentElement
                    var slot = counters.filter(function (c) {
                        return c.parent === parent
                    })[0]

                    if (!slot) {
                        slot = { parent: parent, n: 0 }
                        counters.push(slot)
                    }

                    el.style.setProperty('--mlb-delay', Math.min(slot.n, STAGGER_CAP) * stagger + 'ms')
                    slot.n++
                }

                targets.push(el)
            })
        })

        if (!targets.length) {
            return
        }

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible')
                        observer.unobserve(entry.target)
                    }
                })
            },
            { rootMargin: '0px 0px -8% 0px', threshold: 0.05 }
        )

        targets.forEach(function (target) {
            observer.observe(target)
        })

        // Safety net: if the observer somehow never fires, anything already on screen
        // is revealed anyway. Items below the fold still wait for the scroll, so the
        // effect survives — an unconditional timeout would cancel it outright.
        window.setTimeout(function () {
            targets.forEach(function (target) {
                if (target.classList.contains('is-visible')) {
                    return
                }

                var box = target.getBoundingClientRect()

                if (box.top < window.innerHeight && box.bottom > 0) {
                    target.classList.add('is-visible')
                    observer.unobserve(target)
                }
            })
        }, 1200)
    }

    // Hộp booking đè lên hero: đo chiều cao thật để CSS chừa đúng khoảng ảnh dưới đáy hộp
    function measureBookingStrip() {
        var inner = document.querySelector('.mlb-home .mlb-booking--hero .mlb-booking__inner')

        if (!inner) {
            return
        }

        var apply = function () {
            document.documentElement.style.setProperty(
                '--mlb-booking-h',
                Math.round(inner.getBoundingClientRect().height) + 'px'
            )
        }

        apply()

        if (window.ResizeObserver) {
            new ResizeObserver(apply).observe(inner)
        } else {
            window.addEventListener('resize', apply)
        }
    }

    $(function () {
        loadI18n()
        trackRoomView()
        renderRecentlyViewed()
        initBookingStrip()
        applyStoredCoupon()
        initPanorama()
        initMap()
        initSliders()
        initVideoEmbed()
        initReveal()
        measureBookingStrip()
    })
})(jQuery)
