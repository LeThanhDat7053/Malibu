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

    // Hiện 5 ảnh: ảnh giữa và 2 ảnh mỗi bên.
    var HALF_VISIBLE = 2;

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
                var visible = distance <= HALF_VISIBLE;

                // Ảnh ngoài dải hiển thị đỗ ngay sát mép quạt ảnh và mờ hẳn, thay vì
                // văng ra xa rồi bay ngang qua màn hình mỗi lần bấm mũi tên.
                var slot = visible
                    ? offset
                    : (offset > 0 ? HALF_VISIBLE + 1 : -(HALF_VISIBLE + 1));
                var slotDistance = Math.abs(slot);

                // bước trượt theo từng breakpoint, khớp khổ thẻ khai báo trong restaurant.css
                var width = window.innerWidth;
                var step = width <= 480 ? 160 : (width <= 768 ? 190 : (width <= 1024 ? 220 : 280));
                // ảnh hai bên nghiêng cố định 40°, càng xa càng nhỏ dần
                var rotateY = slot === 0 ? 0 : (slot < 0 ? 40 : -40);
                var scale = slot === 0 ? 1 : 0.72 - slotDistance * 0.06;

                item.style.transform =
                    'translateX(' + slot * step + 'px)' +
                    ' rotateY(' + rotateY + 'deg)' +
                    ' scale(' + scale + ')';
                item.style.opacity = visible ? '1' : '0';
                // ảnh đang xem luôn nằm trên cùng, càng ra rìa càng xuống dưới
                item.style.zIndex = visible ? String(100 - distance * 20) : '0';
                item.style.pointerEvents = visible ? '' : 'none';
                item.classList.toggle('is-active', distance === 0);
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
