/* Đo footer rồi công bố hai biến CSS cho phần lộ footer:
   --mlb-footer-h    chiều cao footer, dùng cho chỗ trống giữ chân trang
   --mlb-footer-reveal  số px footer đã lộ ra, nút cuộn lên bám theo mép này

   Mỗi khung hình chỉ đọc pageYOffset rồi tính, các số đo layout chỉ lấy lại khi
   đổi kích thước hoặc khi chính footer đổi chiều cao. */
;(function () {
    'use strict'

    var MIN_GAP = 80 // footer phải thấp hơn khung nhìn ít nhất bấy nhiêu px mới cho lộ kiểu này

    function isOpaque(color) {
        return color && color !== 'transparent' && !/rgba\(\s*0,\s*0,\s*0,\s*0\s*\)/.test(color)
    }

    // Màu thật đang được vẽ ở một điểm, bỏ qua cây con của phần tử skip.
    // Dò bằng hit test thay vì lần theo DOM, vì nền cuối trang có thể do bất kỳ khối nào vẽ ra.
    function paintedColorAt(x, y, skip) {
        if (!document.elementsFromPoint) {
            return null
        }

        var stack = document.elementsFromPoint(x, y)
        var checked = 0

        for (var i = 0; i < stack.length; i++) {
            if (skip === stack[i] || skip.contains(stack[i])) {
                continue
            }

            var color = window.getComputedStyle(stack[i]).backgroundColor

            if (isOpaque(color)) {
                return color
            }

            if (++checked > 6) {
                break
            }
        }

        return null
    }

    function inkFor(color) {
        var match = String(color).match(/([\d.]+)[\s,]+([\d.]+)[\s,]+([\d.]+)/)

        if (!match) {
            return '#fff'
        }

        var light = (0.299 * +match[1] + 0.587 * +match[2] + 0.114 * +match[3]) / 255

        return light > 0.55 ? '#16192c' : '#fff'
    }

    function init(footer) {
        var root = document.documentElement
        var page = document.querySelector('.mlb-page')
        var spacer = document.querySelector('.mlb-footer-spacer')

        if (!page || !spacer) {
            return
        }

        // nẹm chữ V thò xuống dưới mép trang, mũi tên cuộn lên nằm trong đó
        var wedge = document.createElement('a')
        wedge.className = 'mlb-page__wedge'
        wedge.href = '#top'
        wedge.setAttribute('aria-label', 'Scroll to top')
        wedge.innerHTML = '<i class="fas fa-level-up-alt" aria-hidden="true"></i>'
        wedge.addEventListener('click', function (event) {
            event.preventDefault()
            window.scrollTo({ top: 0, behavior: 'smooth' })
        })
        page.appendChild(wedge)

        var wedgeHeight = parseFloat(window.getComputedStyle(root).getPropertyValue('--mlb-wedge-h')) || 42
        var lastTint = 0
        var lastColor = null

        var height = 0
        var enabled = false
        var ticking = false
        var lastReveal = null
        var lastOpen = null

        function measure() {
            height = footer.offsetHeight
            enabled = height > 0 && height <= window.innerHeight - MIN_GAP

            root.classList.toggle('mlb-reveal-off', !enabled)
            root.style.setProperty('--mlb-footer-h', (enabled ? height : 0) + 'px')


        }

        function render(scrollY) {
            var reveal = 0

            if (enabled) {
                // footer đang position:fixed nên không góp chiều cao: đáy .mlb-page = chiều cao
                // tài liệu trừ chỗ trống. Tính lại mỗi khung hình nên trang cao lên vẫn khít.
                var startDoc = document.documentElement.scrollHeight - height

                reveal = Math.max(0, Math.min(height, scrollY + window.innerHeight - startDoc))
            }

            var rounded = Math.round(reveal)

            if (rounded !== lastReveal) {
                lastReveal = rounded
                root.style.setProperty('--mlb-footer-reveal', rounded + 'px')
            }

            // nẹm ló ra được nửa là nút tròn lui, tránh cảnh hai mũi tên cùng hiện
            var open = enabled && rounded >= wedgeHeight / 2

            // mép dưới trang đã vào khung nhìn thì đo màu ngay tại đó cho nẹm khớp màu tuyệt đối
            if (rounded > 0 && Date.now() - lastTint > 150) {
                lastTint = Date.now()

                var box = wedge.getBoundingClientRect()
                var color = paintedColorAt(box.left + box.width / 2, box.top - 2, wedge)

                if (color && color !== lastColor) {
                    lastColor = color
                    root.style.setProperty('--mlb-wedge-bg', color)
                    root.style.setProperty('--mlb-wedge-ink', inkFor(color))
                }
            }

            if (open !== lastOpen) {
                lastOpen = open
                document.body.classList.toggle('mlb-footer-open', open)
            }
        }

        function frame() {
            ticking = false
            render(window.pageYOffset)
        }

        function onScroll() {
            if (ticking) {
                return
            }

            ticking = true
            window.requestAnimationFrame(frame)
        }

        function remeasure() {
            measure()
            render(window.pageYOffset)
        }

        remeasure()
        window.addEventListener('scroll', onScroll, { passive: true })
        window.addEventListener('resize', remeasure)
        window.addEventListener('load', remeasure)

        // footer đổi chiều cao, hoặc trang cao lên vì ảnh lazy tải xong, đều phải tính lại;
        // hoãn sang khung hình sau để không đo lại ngay trong lúc trình duyệt đang đo
        if (window.ResizeObserver) {
            var busy = false
            var observer = new window.ResizeObserver(function () {
                if (busy) {
                    return
                }

                busy = true
                remeasure()
                busy = false
            })

            observer.observe(footer)
            observer.observe(page)
        }
    }

    function start() {
        var footer = document.querySelector('[data-mlb-footer]')

        if (footer) {
            init(footer)
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start)
    } else {
        start()
    }
})()
