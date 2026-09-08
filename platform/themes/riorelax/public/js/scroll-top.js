/* Vòng tiến trình quanh nút cuộn lên đầu trang.
   Plugin jquery.scrollUp dựng sẵn thẻ #scrollUp và lo phần ẩn/hiện, ở đây chỉ bọc thêm vòng.
   Vòng có hai bản chồng nhau đảo màu của nhau: phần nằm trên nền cùng tông cam lộ bản trắng.

   Mỗi khung hình chỉ làm phép tính rồi ghi style, không đọc layout. Việc dò nền tốn kém
   (elementsFromPoint) chạy tách ra một tác vụ riêng, cách quãng, và nhớ mép theo toạ độ
   TÀI LIỆU nên giữa hai lần dò vẫn tính ra đúng chỗ đổi màu. */
;(function () {
    'use strict'

    var SVG =
        '<svg class="mlb-top__ring-svg" viewBox="0 0 50 50" aria-hidden="true" focusable="false">' +
        '<circle class="mlb-top__ring-track" cx="25" cy="25" r="23"></circle>' +
        '<circle class="mlb-top__ring-bar" cx="25" cy="25" r="23"></circle>' +
        '</svg>'

    // mask đặt ở span bọc ngoài, svg bên trong mới là thứ bị xoay
    var RING =
        '<span class="mlb-top__ring mlb-top__ring--brand">' + SVG + '</span>' +
        '<span class="mlb-top__ring mlb-top__ring--light">' + SVG + '</span>'

    var MARGIN = 160 // dò rộng hơn nút bấy nhiêu px, để mép sắp trôi vào đã nằm sẵn trong bộ nhớ
    var STEP = 24 // khoảng cách giữa hai điểm dò thô
    var REFINE = 6 // số lần chia đôi để tìm mép, sai số còn dưới 0.2px
    var MATCH = 0.25 // khoảng cách RGB chuẩn hoá, dưới ngưỡng này coi là cùng tông với màu chính
    var PROBE_GAP = 250 // ms tối thiểu giữa hai lần dò định kỳ, dò theo vùng lo phần bám sát cuộn

    function parseColor(value) {
        if (!value) {
            return null
        }

        var text = value.trim()
        var match = text.match(/^#([0-9a-f]{3}|[0-9a-f]{6})$/i)

        if (match) {
            var hex = match[1]

            if (hex.length === 3) {
                hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2]
            }

            return {
                r: parseInt(hex.slice(0, 2), 16),
                g: parseInt(hex.slice(2, 4), 16),
                b: parseInt(hex.slice(4, 6), 16),
                a: 1,
            }
        }

        match = text.match(/rgba?\(\s*([\d.]+)[\s,]+([\d.]+)[\s,]+([\d.]+)(?:[\s,/]+([\d.]+))?/i)

        if (!match) {
            return null
        }

        return {
            r: parseFloat(match[1]),
            g: parseFloat(match[2]),
            b: parseFloat(match[3]),
            a: match[4] === undefined ? 1 : parseFloat(match[4]),
        }
    }

    function distance(a, b) {
        var dr = a.r - b.r
        var dg = a.g - b.g
        var db = a.b - b.b

        return Math.sqrt((dr * dr + dg * dg + db * db) / 3) / 255
    }

    function defer(fn) {
        if (window.requestIdleCallback) {
            window.requestIdleCallback(fn, { timeout: 40 })
        } else {
            window.setTimeout(fn, 0)
        }
    }

    function mount(button) {
        if (button.querySelector('.mlb-top__ring')) {
            return
        }

        // giữ nguyên icon mà main.js đã đặt, chỉ bọc lại rồi chèn hai vòng ra ngoài
        var icon = document.createElement('span')
        icon.className = 'mlb-top__icon'

        while (button.firstChild) {
            icon.appendChild(button.firstChild)
        }

        button.insertAdjacentHTML('afterbegin', RING)
        button.appendChild(icon)
        button.setAttribute('aria-label', button.getAttribute('title') || 'Scroll to top')

        var brandRing = button.querySelector('.mlb-top__ring--brand')
        var lightRing = button.querySelector('.mlb-top__ring--light')
        var radius = parseFloat(button.querySelector('.mlb-top__ring-bar').getAttribute('r')) || 23

        button.style.setProperty('--mlb-top-len', (2 * Math.PI * radius).toFixed(2))

        var brand = parseColor(
            getComputedStyle(document.documentElement).getPropertyValue('--primary-color')
        ) || { r: 228, g: 118, b: 44, a: 1 }

        // ---- số đo nguội, chỉ làm mới trong tác vụ dò hoặc khi đổi kích thước ----
        var box = null // hộp nút trong khung nhìn, nút position:fixed nên đứng yên
        var maxScroll = 0
        var edges = [] // mép giữa hai vùng nền, theo toạ độ tài liệu, tăng dần
        var headIsBrand = false // trạng thái phía trên mép đầu tiên
        var probedFrom = 0
        var probedTo = 0

        var ticking = false
        var probeQueued = false
        var lastProbe = 0
        var lastMask = null
        var lastProgress = null

        function refresh() {
            var rect = button.getBoundingClientRect()

            box = rect.width && rect.height ? rect : null

            var doc = document.documentElement
            var height = Math.max(doc.scrollHeight, document.body ? document.body.scrollHeight : 0)

            maxScroll = Math.max(0, height - window.innerHeight)
        }

        // bỏ qua cả cây con của nút rồi lấy phần tử đầu tiên thật sự có nền
        function isBrandAt(x, y) {
            var stack = document.elementsFromPoint(x, y)
            var checked = 0

            for (var i = 0; i < stack.length; i++) {
                if (button === stack[i] || button.contains(stack[i])) {
                    continue
                }

                var color = parseColor(getComputedStyle(stack[i]).backgroundColor)

                if (color && color.a > 0.35) {
                    return distance(color, brand) < MATCH
                }

                if (++checked > 6) {
                    break
                }
            }

            return false
        }

        // chia đôi khoảng giữa hai điểm khác trạng thái cho tới khi ra đúng toạ độ mép
        function edgeBetween(x, low, high, lowIsBrand) {
            for (var i = 0; i < REFINE; i++) {
                var mid = (low + high) / 2

                if (isBrandAt(x, mid) === lowIsBrand) {
                    low = mid
                } else {
                    high = mid
                }
            }

            return (low + high) / 2
        }

        // dò một dải quanh nút rồi nhớ các mép theo toạ độ tài liệu
        function probe() {
            refresh()

            if (!box || !document.elementsFromPoint) {
                return
            }

            var scrollY = window.pageYOffset
            var x = box.left + box.width / 2
            var top = Math.max(1, box.top - MARGIN)
            var bottom = Math.min(window.innerHeight - 1, box.bottom + MARGIN)
            var count = Math.max(4, Math.round((bottom - top) / STEP) + 1)
            var points = []
            var flags = []
            var found = []
            var i

            for (i = 0; i < count; i++) {
                var y = top + ((bottom - top) * i) / (count - 1)
                points.push(y)
                flags.push(isBrandAt(x, y))
            }

            for (i = 1; i < count; i++) {
                if (flags[i] !== flags[i - 1]) {
                    found.push(edgeBetween(x, points[i - 1], points[i], flags[i - 1]) + scrollY)
                }
            }

            edges = found
            headIsBrand = flags[0]
            probedFrom = top + scrollY
            probedTo = bottom + scrollY
        }

        function queueProbe() {
            if (probeQueued) {
                return
            }

            probeQueued = true

            defer(function () {
                probeQueued = false
                lastProbe = Date.now()
                probe()
                render(window.pageYOffset)
            })
        }

        // các dải nền cùng tông cam nằm trong nút, tính bằng số học từ mép đã nhớ
        function brandBands(scrollY) {
            if (!box) {
                return []
            }

            var top = box.top + scrollY
            var bottom = box.bottom + scrollY
            var state = headIsBrand
            var bands = []
            var open = null
            var i

            for (i = 0; i < edges.length; i++) {
                if (edges[i] > top) {
                    break
                }

                state = !state
            }

            if (state) {
                open = top
            }

            for (; i < edges.length && edges[i] < bottom; i++) {
                if (open === null) {
                    open = edges[i]
                } else {
                    bands.push([open, edges[i]])
                    open = null
                }
            }

            if (open !== null) {
                bands.push([open, bottom])
            }

            return bands.map(function (band) {
                return [
                    Math.max(0, ((band[0] - top) / box.height) * 100),
                    Math.min(100, ((band[1] - top) / box.height) * 100),
                ]
            })
        }

        function gradient(bands, inverted) {
            var shown = inverted ? 'transparent' : '#000'
            var hidden = inverted ? '#000' : 'transparent'
            var parts = []
            var cursor = 0

            bands.forEach(function (band) {
                var from = band[0].toFixed(2)
                var to = band[1].toFixed(2)

                if (band[0] > cursor) {
                    parts.push(hidden + ' ' + cursor.toFixed(2) + '% ' + from + '%')
                }

                parts.push(shown + ' ' + from + '% ' + to + '%')
                cursor = band[1]
            })

            if (cursor < 100) {
                parts.push(hidden + ' ' + cursor.toFixed(2) + '% 100%')
            }

            return 'linear-gradient(to bottom, ' + parts.join(', ') + ')'
        }

        function applyMask(element, value) {
            element.style.webkitMaskImage = value
            element.style.maskImage = value
        }

        // chỉ ghi style, không đọc gì của layout
        function render(scrollY) {
            var progress = maxScroll > 0 ? Math.max(0, Math.min(1, scrollY / maxScroll)) : 0
            var rounded = progress.toFixed(4)

            if (rounded !== lastProgress) {
                lastProgress = rounded
                button.style.setProperty('--mlb-top-progress', rounded)
            }

            var bands = brandBands(scrollY)
            var key = JSON.stringify(bands)

            if (key === lastMask) {
                return
            }

            lastMask = key
            applyMask(lightRing, gradient(bands, false))
            applyMask(brandRing, gradient(bands, true))
        }

        function frame() {
            ticking = false

            var scrollY = window.pageYOffset

            render(scrollY)

            if (!box) {
                queueProbe()

                return
            }

            // trôi khỏi vùng đã dò, hoặc đã quá lâu kể từ lần dò trước thì hẹn dò lại
            if (
                scrollY + box.top < probedFrom ||
                scrollY + box.bottom > probedTo ||
                Date.now() - lastProbe > PROBE_GAP
            ) {
                queueProbe()
            }
        }

        function onScroll() {
            if (ticking) {
                return
            }

            ticking = true
            window.requestAnimationFrame(frame)
        }

        function onResize() {
            lastMask = null
            lastProgress = null
            queueProbe()
        }

        probe()
        render(window.pageYOffset)
        window.addEventListener('scroll', onScroll, { passive: true })
        window.addEventListener('resize', onResize)
        window.addEventListener('load', onResize)
    }

    // main.js dựng nút trong document ready, chờ vài nhịp cho tới khi thẻ có mặt
    function wait(tries) {
        var button = document.getElementById('scrollUp')

        if (button) {
            mount(button)
            return
        }

        if (tries < 60) {
            window.setTimeout(function () {
                wait(tries + 1)
            }, 100)
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            wait(0)
        })
    } else {
        wait(0)
    }
})()
