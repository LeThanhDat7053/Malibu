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
        var media = root.querySelector('[data-rst-lightbox-media]');
        var prev = root.querySelector('[data-rst-lightbox-prev]');
        var next = root.querySelector('[data-rst-lightbox-next]');
        var bar = root.querySelector('[data-rst-lightbox-bar]');
        var caption = root.querySelector('[data-rst-lightbox-caption]');
        var counter = root.querySelector('[data-rst-lightbox-counter]');

        // Bộ đang xem và vị trí trong bộ. group rỗng nghĩa là mở lẻ một ảnh
        // (ảnh thực đơn), lúc đó không hiện nút lướt.
        var group = [];
        var current = -1;

        function clearMedia() {
            if (!media) {
                return;
            }

            // xoá hẳn iframe / video để tiếng không chạy tiếp
            media.innerHTML = '';
            media.hidden = true;
            media.classList.remove('rst-lightbox__media--wide');
        }

        function showImage(src) {
            clearMedia();
            image.src = src;
            image.hidden = false;
        }

        // Video / VR360: nhồi iframe (YouTube, Vimeo, tour 360) hoặc thẻ <video> cho file mp4.
        function showMedia(html, wide) {
            if (!media) {
                return;
            }

            image.hidden = true;
            image.src = '';
            media.innerHTML = html;
            // tour 360 xem sướng hơn ở khung cao, video giữ tỉ lệ 16/9
            media.classList.toggle('rst-lightbox__media--wide', !!wide);
            media.hidden = false;
        }

        function render(el) {
            var kind = el.getAttribute('data-rst-kind') || 'image';
            var src = el.getAttribute('data-rst-src');

            if (kind === 'video') {
                if (el.hasAttribute('data-rst-file')) {
                    showMedia('<video controls autoplay playsinline src="' + src + '"></video>', false);
                } else {
                    showMedia(
                        '<iframe src="' + src + '" frameborder="0" ' +
                        'allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ' +
                        'allowfullscreen></iframe>',
                        false
                    );
                }
            } else if (kind === 'vr360') {
                showMedia(
                    '<iframe src="' + src + '" frameborder="0" ' +
                    'allow="accelerometer; gyroscope; magnetometer; xr-spatial-tracking; fullscreen" ' +
                    'allowfullscreen></iframe>',
                    true
                );
            } else {
                showImage(src);
            }

            if (caption) {
                caption.textContent = el.getAttribute('data-rst-caption') || '';
            }
        }

        function updateChrome() {
            var many = group.length > 1;

            if (prev) {
                prev.hidden = !many;
            }

            if (next) {
                next.hidden = !many;
            }

            if (counter) {
                counter.textContent = many ? (current + 1) + ' / ' + group.length : '';
            }

            if (bar) {
                bar.hidden = !many && !(caption && caption.textContent);
            }
        }

        function show() {
            root.hidden = false;
            document.body.style.overflow = 'hidden';
        }

        // Mở một ô trong bộ: từ đây bấm mũi tên là lướt tiếp, khỏi thoát ra
        function openGroup(el) {
            var container = el.closest('[data-rst-gallery]');

            group = container
                ? Array.prototype.slice.call(container.querySelectorAll('[data-rst-item]'))
                : [el];
            current = group.indexOf(el);

            render(el);
            updateChrome();
            show();
        }

        // Ảnh lẻ (ảnh thực đơn) — vẫn giữ đường cũ data-rst-lightbox
        function openSingle(src) {
            group = [];
            current = -1;

            showImage(src);

            if (caption) {
                caption.textContent = '';
            }

            updateChrome();
            show();
        }

        function go(delta) {
            if (group.length < 2) {
                return;
            }

            current = (current + delta + group.length) % group.length;
            render(group[current]);
            updateChrome();
        }

        function close() {
            root.hidden = true;
            image.src = '';
            image.hidden = false;
            clearMedia();
            group = [];
            current = -1;
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function (event) {
            if (event.target.closest('[data-rst-lightbox-prev]')) {
                go(-1);

                return;
            }

            if (event.target.closest('[data-rst-lightbox-next]')) {
                go(1);

                return;
            }

            if (event.target.closest('[data-rst-lightbox-close]') || event.target === root) {
                close();

                return;
            }

            // Đang ở trong lightbox thì không mở thêm gì nữa
            if (root.contains(event.target)) {
                return;
            }

            // Ô VR360 là iframe nuốt click nên có nút mở rộng riêng; nút thoát ra
            // tab mới thì để trình duyệt tự xử.
            if (event.target.closest('.rst-photo__tool:not([data-rst-open])')) {
                return;
            }

            var item = event.target.closest('[data-rst-item]');

            if (item) {
                openGroup(item);

                return;
            }

            var single = event.target.closest('[data-rst-lightbox]');

            if (single) {
                openSingle(single.getAttribute('data-rst-lightbox'));
            }
        });

        // Vuốt ngang trên điện thoại. Vuốt trên iframe tour thì tour ăn mất,
        // lúc đó vẫn còn hai nút mũi tên.
        var touchX = null;

        root.addEventListener('touchstart', function (event) {
            touchX = event.touches[0].clientX;
        }, { passive: true });

        root.addEventListener('touchend', function (event) {
            if (touchX === null) {
                return;
            }

            var diff = event.changedTouches[0].clientX - touchX;
            touchX = null;

            if (Math.abs(diff) > 50) {
                go(diff < 0 ? 1 : -1);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (root.hidden) {
                return;
            }

            if (event.key === 'Escape') {
                close();
            } else if (event.key === 'ArrowLeft') {
                go(-1);
            } else if (event.key === 'ArrowRight') {
                go(1);
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
