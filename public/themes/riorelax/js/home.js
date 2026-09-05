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

    // ----------------------------------------------------------- booking strip

    function pickerDate($input) {
        try {
            return $input.datepicker('getDate')
        } catch (e) {
            return null
        }
    }

    function setPickerValue($input, text) {
        $input.val(text)

        try {
            $input.datepicker('update', text)
        } catch (e) {
            /* datepicker not initialised — the plain value is still submitted */
        }
    }

    function initBookingStrip() {
        var form = document.querySelector('[data-mlb-booking-form]')

        if (!form) {
            return
        }

        var $start = $(form).find('#mlb-start-date')
        var $end = $(form).find('#mlb-end-date')
        var $adults = $(form).find('#mlb-adults')
        var $children = $(form).find('#mlb-children')
        var $promo = $(form).find('#mlb-promo')

        // check-out always stays after check-in
        $start.on('changeDate', function () {
            var start = pickerDate($start)
            var end = pickerDate($end)

            if (!start) {
                return
            }

            if (!end || end <= start) {
                var next = new Date(start.getTime())
                next.setDate(next.getDate() + 1)

                try {
                    $end.datepicker('setDate', next)
                } catch (e) {}
            }

            try {
                $end.datepicker('setStartDate', start)
            } catch (e) {}
        })

        restoreStay($start, $end, $adults, $children)
        deferFloatingBar()

        form.addEventListener('submit', function () {
            var start = pickerDate($start)

            writeJson(STAY_KEY, {
                startText: $start.val(),
                endText: $end.val(),
                startTime: start ? start.getTime() : null,
                adults: $adults.val(),
                children: $children.val(),
            })

            var coupon = $promo.length ? $.trim($promo.val()) : ''

            if (coupon) {
                writeJson(COUPON_KEY, coupon)
            }
        })
    }

    function restoreStay($start, $end, $adults, $children) {
        var stay = readJson(STAY_KEY, null)

        if (!stay || !stay.startText || !stay.endText) {
            greet(null)
            return
        }

        // a saved stay whose check-in has passed is worse than no suggestion at all
        if (!stay.startTime || stay.startTime < startOfToday().getTime()) {
            removeKey(STAY_KEY)
            greet(null)
            return
        }

        setPickerValue($start, stay.startText)
        setPickerValue($end, stay.endText)

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

    // ---------------------------------------------------------------- reveal

    // Each entry: selector, motion, per-item stagger in ms (0 = no stagger).
    // Stagger is counted within the item's own parent, so each grid restarts at 0.
    var REVEAL_GROUPS = [
        ['.mlb-section-head', 'up', 0],
        ['.mlb-rooms__grid .mlb-room', 'up', 90],
        ['.mlb-columns__grid .mlb-card', 'up', 90],
        ['.mlb-offers__grid .mlb-offer', 'up', 90],
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
        var inner = document.querySelector('.mlb-home .mlb-booking__inner')

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
        initReveal()
        measureBookingStrip()
    })
})(jQuery)
