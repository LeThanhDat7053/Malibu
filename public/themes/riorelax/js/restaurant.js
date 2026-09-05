/**
 * Nhà hàng — carousel ảnh thực đơn (coverflow 3D) và lightbox xem ảnh.
 *
 * Viết bằng JS thuần, không phụ thuộc slick hay magnific-popup để trang chi
 * tiết nhà hàng không kéo theo cấu hình của trang Phòng.
 */
(function () {
    'use strict';

    /* ---------------------------------------------------------- Lightbox */

    function initLightbox() {
        var root = document.querySelector('[data-rst-lightbox-root]');

        if (!root) {
            return;
        }

        var image = root.querySelector('img');

        function open(src) {
            image.src = src;
            root.hidden = false;
            document.body.style.overflow = 'hidden';
        }

        function close() {
            root.hidden = true;
            image.src = '';
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function (event) {
            var trigger = event.target.closest('[data-rst-lightbox]');

            if (trigger) {
                open(trigger.getAttribute('data-rst-lightbox'));

                return;
            }

            if (event.target.closest('[data-rst-lightbox-close]') || event.target === root) {
                close();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !root.hidden) {
                close();
            }
        });
    }

    /* --------------------------------------------------------- Carousel */

    function initCarousel(wrapper) {
        var items = Array.prototype.slice.call(wrapper.querySelectorAll('.rst-carousel__item'));

        if (!items.length) {
            return;
        }

        var section = wrapper.closest('.rst-menu') || document;
        var current = 0;

        function layout() {
            var total = items.length;

            items.forEach(function (item, index) {
                // Khoảng cách vòng tròn từ ảnh đang xem, chạy trong [-total/2, total/2].
                var offset = index - current;

                if (offset > total / 2) {
                    offset -= total;
                } else if (offset < -total / 2) {
                    offset += total;
                }

                var distance = Math.abs(offset);
                var isNarrow = window.innerWidth <= 1024;
                var step = isNarrow ? 170 : 260;

                item.style.transform =
                    'translateX(' + offset * step + 'px)' +
                    ' translateZ(' + -distance * 220 + 'px)' +
                    ' rotateY(' + offset * -28 + 'deg)';
                item.style.opacity = distance > 2 ? '0' : String(1 - distance * 0.25);
                item.style.zIndex = String(100 - distance);
                item.classList.toggle('is-active', distance === 0);
                item.style.pointerEvents = distance > 2 ? 'none' : '';
            });
        }

        function go(delta) {
            current = (current + delta + items.length) % items.length;
            layout();
        }

        var prev = section.querySelector('[data-rst-prev]');
        var next = section.querySelector('[data-rst-next]');

        if (prev) {
            prev.addEventListener('click', function () {
                go(-1);
            });
        }

        if (next) {
            next.addEventListener('click', function () {
                go(1);
            });
        }

        // Ảnh không ở giữa thì click để đưa vào giữa, ở giữa mới mở lightbox.
        items.forEach(function (item, index) {
            item.addEventListener('click', function (event) {
                if (index !== current) {
                    event.stopPropagation();
                    current = index;
                    layout();
                }
            }, true);
        });

        // Kéo bằng chuột hoặc chạm.
        var startX = null;

        function onStart(x) {
            startX = x;
        }

        function onEnd(x) {
            if (startX === null) {
                return;
            }

            var diff = x - startX;
            startX = null;

            if (Math.abs(diff) > 50) {
                go(diff < 0 ? 1 : -1);
            }
        }

        wrapper.addEventListener('mousedown', function (event) {
            onStart(event.clientX);
        });
        wrapper.addEventListener('mouseup', function (event) {
            onEnd(event.clientX);
        });
        wrapper.addEventListener('touchstart', function (event) {
            onStart(event.touches[0].clientX);
        }, { passive: true });
        wrapper.addEventListener('touchend', function (event) {
            onEnd(event.changedTouches[0].clientX);
        });

        window.addEventListener('resize', layout);

        layout();
    }

    document.addEventListener('DOMContentLoaded', function () {
        initLightbox();

        document.querySelectorAll('[data-rst-carousel]').forEach(initCarousel);
    });
})();
