'use strict'

$(document).ready(function () {
    $('#preloader-active').fadeOut('slow');

    // skill
    $('.skill-per').each(function () {
        var $this = $(this)
        var id = $this.attr('id')
        $this.css('width', id + '%')
        $({ animatedValue: 0 }).animate(
            { animatedValue: id },
            {
                duration: 1000,
                step: function () {
                    $this.attr('id', Math.floor(this.animatedValue) + '%')
                },
                complete: function () {
                    $this.attr('id', Math.floor(this.animatedValue) + '%')
                },
            }
        )
    })

    // sticky
    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop()
        if (scroll < 200) {
            $('#header-sticky').removeClass('sticky-menu')
        } else {
            $('#header-sticky').addClass('sticky-menu')
        }
    })

    // RESPONSIVE MENU

    $('.info-bar').on('click', function () {
        $('.extra-info').addClass('info-open')
    })

    $('.close-icon').on('click', function () {
        $('.extra-info').removeClass('info-open')
    })

    // offcanvas menu
    $('.menu-tigger').on('click', function () {
        $('.offcanvas-menu,.offcanvas-overly').addClass('active')
        return false
    })
    $('.menu-close,.offcanvas-overly').on('click', function () {
        $('.offcanvas-menu,.offcanvas-overly').removeClass('active')
    })

    // menu toggle
    $('.main-menu li a').on('click', function () {
        if ($(window).width() < 700) {
            $('#mobile-menu').slideUp()
        }
    })

    // smoth scroll
    $(function () {
        $('a.smoth-scroll').on('click', function (event) {
            var $anchor = $(this)
            $('html, body')
                .stop()
                .animate(
                    {
                        scrollTop: $($anchor.attr('href')).offset().top - 100,
                    },
                    1000
                )
            event.preventDefault()
        })
    })

    // mainSlider
    function mainSlider() {
        var BasicSlider = $('.slider-active')

        BasicSlider.on('init', function (e, slick) {
            var $firstAnimatingElements = $('.single-slider:first-child').find('[data-animation]')
            doAnimations($firstAnimatingElements)
        })
        BasicSlider.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
            var $animatingElements = $('.single-slider[data-slick-index="' + nextSlide + '"]').find('[data-animation]')
            doAnimations($animatingElements)
        })
        BasicSlider.slick({
            autoplay: true,
            autoplaySpeed: 10000,
            dots: false,
            fade: true,
            adaptiveHeight: true,
            arrows: true,
            prevArrow: '<button type="button" class="slick-prev"><i class="far fa-angle-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="far fa-angle-right"></i></button>',
            responsive: [{ breakpoint: 1200, settings: { dots: false, arrows: false } }],
            rtl: RiorelaxTheme.isRtl(),
        })

        function doAnimations(elements) {
            var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend'
            elements.each(function () {
                var $this = $(this)
                var $animationDelay = $this.data('delay')
                var $animationType = 'animated ' + $this.data('animation')
                $this.css({
                    'animation-delay': $animationDelay,
                    '-webkit-animation-delay': $animationDelay,
                })
                $this.addClass($animationType).one(animationEndEvents, function () {
                    $this.removeClass($animationType)
                })
            })
        }
    }
    mainSlider()

    // services-active
    $('.services-active').slick({
        dots: true,
        infinite: true,
        arrows: false,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 1,
        rtl: RiorelaxTheme.isRtl(),
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    })

    // team-active
    $('.team-active').slick({
        dots: true,
        infinite: true,
        arrows: false,
        prevArrow: '<button type="button" class="slick-prev"><i class="far fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="far fa-chevron-right"></i></button>',
        speed: 1000,
        slidesToShow: 4,
        slidesToScroll: 1,
        rtl: RiorelaxTheme.isRtl(),
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    })
    // portfolio-active
    $('.class-active').slick({
        dots: false,
        infinite: true,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fal fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fal fa-angle-right"></i></button>',
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 1,
        rtl: RiorelaxTheme.isRtl(),
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    })
    // portfolio-active
    $('.portfolio-active').slick({
        dots: false,
        infinite: true,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fal fa-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fal fa-angle-right"></i></button>',
        speed: 1000,
        slidesToShow: 5,
        slidesToScroll: 1,
        rtl: RiorelaxTheme.isRtl(),
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 5,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    })

    // brand-active
    $('.brand-active').slick({
        dots: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 1500,
        arrows: false,
        speed: 1000,
        slidesToShow: 4,
        slidesToScroll: 2,
        rtl: RiorelaxTheme.isRtl(),
        responsive: [
            {
                breakpoint: 1500,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 3,
                    infinite: true,
                },
            },
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    })

    // testimonial-active
    $('.testimonial-active').slick({
        dots: true,
        infinite: true,
        arrows: false,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 2,
        rtl: RiorelaxTheme.isRtl(),
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    })
    // testimonial-active
    $('.testimonial-active2').slick({
        dots: true,
        autoplay: true,
        autoplaySpeed: 1500,
        infinite: true,
        arrows: false,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
        rtl: RiorelaxTheme.isRtl(),
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    })
    // testimonial-active2

    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav',
        rtl: RiorelaxTheme.isRtl(),
    })
    $('.slider-nav').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        arrows: true,
        centerMode: true,
        focusOnSelect: true,
        variableWidth: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
        rtl: RiorelaxTheme.isRtl(),
    })
    // home-blog-active
    $('.home-blog-active').slick({
        dots: true,
        infinite: true,
        arrows: false,
        speed: 1000,
        slidesToShow: 4,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev"><i class="far fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="far fa-chevron-right"></i></button>',
        rtl: RiorelaxTheme.isRtl(),
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    })

    // home-blog-active
    $('.home-blog-active2').slick({
        dots: false,
        infinite: true,
        arrows: true,
        speed: 1000,
        slidesToShow: 4,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev"><i class="far fa-chevron-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="far fa-chevron-right"></i></button>',
        rtl: RiorelaxTheme.isRtl(),
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true,
                },
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                },
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    })

    // blog
    $('.blog-active').slick({
        dots: false,
        infinite: true,
        arrows: true,
        speed: 1500,
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
        rtl: RiorelaxTheme.isRtl(),
    })

    //room-detail
    function roomDetailsSlider() {
        let roomDetailsSlider = $('.room-details-slider');
        if (roomDetailsSlider.length) {
            let roomDetailsSliderNav = $('.room-details-slider-nav');
            let vr360Frames = roomDetailsSlider.find('.room-vr360-frame');
            let mediaSlides = roomDetailsSlider.find('.room-media-slide');

            roomDetailsSlider.slick({
                rtl: RiorelaxTheme.isRtl(),
                slidesToShow: 1,
                slidesToScroll: 1,
                // An embedded VR360 tour must not be duplicated into slick's wrap-around clones,
                // so infinite mode is dropped only on rooms that actually have VR360 or video slides.
                infinite: !mediaSlides.length,
                autoplay: false,
                arrows: false,
                dots: false,
                asNavFor: '.room-details-slider-nav'
            });

            // Deferred until after slick has built the track, so the tour loads once and only when present.
            vr360Frames.each(function () {
                this.src = $(this).data('src');
            });

            // Video tự chạy khi lướt tới, gỡ hẳn khung phát khi lướt đi để tiếng dừng.
            let videoSlides = roomDetailsSlider.find('.room-video-slide');

            let stopRoomVideos = function () {
                videoSlides.find('.room-video-frame').remove();
            };

            let playRoomVideo = function (index) {
                stopRoomVideos();

                let slide = videoSlides.filter(function () {
                    return $(this).closest('.slick-slide').data('slick-index') === index;
                });

                if (!slide.length) {
                    return;
                }

                let embed = slide.data('video-embed');

                if (!embed) {
                    return;
                }

                if (slide.is('[data-video-file]')) {
                    slide.append(
                        $('<video>', {
                            class: 'room-video-frame',
                            src: embed,
                            controls: true,
                            autoplay: true,
                            playsinline: true,
                        })
                    );

                    return;
                }

                slide.append(
                    $('<iframe>', {
                        class: 'room-video-frame',
                        src: embed + (embed.indexOf('?') === -1 ? '?' : '&') + 'autoplay=1&rel=0&playsinline=1',
                        frameborder: 0,
                        allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
                        allowfullscreen: true,
                    })
                );
            };

            if (videoSlides.length) {
                roomDetailsSlider.on('beforeChange', stopRoomVideos);
                roomDetailsSlider.on('afterChange', function (event, slick, currentSlide) {
                    playRoomVideo(currentSlide);
                });

                playRoomVideo(roomDetailsSlider.slick('slickCurrentSlide'));
            }

            roomDetailsSlider.lightGallery({
                // Ảnh nằm thẳng trong slider nên slick gắn .slick-slide lên CHÍNH thẻ <a>,
                // còn slide VR360/video là <div> bọc <a> bên trong — phải nhận cả hai kiểu,
                // chỉ dùng một vế thì lightGallery bỏ sót và mất nút lướt trái phải.
                // Bỏ qua slide nhân bản, không thì phòng chỉ có ảnh (chế độ vòng lặp còn bật)
                // sẽ liệt kê mỗi ảnh hai lần trong khung xem to.
                selector: '.slick-slide:not(.slick-cloned) a, a.slick-slide:not(.slick-cloned)',
                thumbnail: true,
                share: false,
                fullScreen: false,
                autoplay: false,
                autoplayControls: false,
                actualSize: false,
                // Dánh dấu riêng khung xem của bộ ảnh phòng để CSS giữ nút đóng luôn hiện:
                // slide VR360/video là iframe, chuột nằm trong iframe nên lightGallery
                // không nhận được mousemove để hiện lại thanh công cụ đã tự ẩn.
                addClass: 'lg-room-gallery',
            });

            // Khung xem to dang mo: go src cua tour nhung trong slide va khung phat video
            // de khong co hai tour/video chay cung luc; dong lai thi nap tra ve nhu cu.
            roomDetailsSlider.on('onAfterOpen.lg', function () {
                stopRoomVideos();

                vr360Frames.each(function () {
                    this.removeAttribute('src');
                });
            });

            roomDetailsSlider.on('onCloseAfter.lg', function () {
                vr360Frames.each(function () {
                    this.src = $(this).data('src');
                });

                playRoomVideo(roomDetailsSlider.slick('slickCurrentSlide'));
            });

            roomDetailsSliderNav.slick({
                rtl: RiorelaxTheme.isRtl(),
                slidesToShow: 6,
                slidesToScroll: 1,
                asNavFor: '.room-details-slider',
                dots: false,
                arrows: false,
                centerMode: false,
                focusOnSelect: true,
                responsive: [
                    {
                        breakpoint: 1400,
                        settings: {
                            slidesToShow: 4,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 3,
                        },
                    },
                ],
            });
        }
    }

    roomDetailsSlider()

    // counterUp

    $('.count').counterUp({
        delay: 100,
        time: 1000,
    })

    /* magnificPopup img view */
    $('.popup-image').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true,
        },
    })

    /* magnificPopup video view */
    $('.popup-video').magnificPopup({
        type: 'iframe',
    })

    // paroller
    if ($('.paroller').length) {
        $('.paroller').paroller()
    }

    //* Parallaxmouse js
    function parallaxMouse() {
        if ($('#parallax').length) {
            var scene = document.getElementById('parallax')
            var parallax = new Parallax(scene)
        }
    }
    parallaxMouse()

    // service active
    $('.s-single-services').on('mouseenter', function () {
        $(this).addClass('active').parent().siblings().find('.s-single-services').removeClass('active')
    })

    // scrollToTop
    $.scrollUp({
        scrollName: 'scrollUp',
        topDistance: '300',
        topSpeed: 300,
        animation: 'fade',
        animationInSpeed: 200,
        animationOutSpeed: 200,
        scrollText: '<i class="fas fa-level-up-alt"></i>',
        activeOverlay: false,
    })

    // isotop
    if (jQuery().imagesLoaded) {
        $('.grid').imagesLoaded(function () {
            // init Isotope
            var $grid = $('.grid').isotope({
                itemSelector: '.grid-item',
                percentPosition: true,
                masonry: {
                    // use outer width of grid-sizer for columnWidth
                    columnWidth: 1,
                },
            })

            // filter items on button click
            $('.button-group').on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter')
                $grid.isotope({ filter: filterValue })
            })
        })
    }
    // isotop
    $('.element').each(function () {
        var a = $(this)
        a.typed({
            strings: a.attr('data-elements').split(','),
            typeSpeed: 100,
            backDelay: 3e3,
        })
    }),
        //for menu active class
        $('.button-group > button').on('click', function (event) {
            $(this).siblings('.active').removeClass('active')
            $(this).addClass('active')
            event.preventDefault()
        })

    // WOW active
    new WOW().init()

    //Tabs Box
    if ($('.tabs-box').length) {
        $('.tabs-box .tab-buttons .tab-btn').on('click', function (e) {
            e.preventDefault()
            var target = $($(this).attr('data-tab'))

            if ($(target).is(':visible')) {
                return false
            } else {
                target.parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn')
                $(this).addClass('active-btn')
                target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0)
                target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab animated fadeIn')
                $(target).fadeIn(300)
                $(target).addClass('active-tab animated fadeIn')
            }
        })
    }


    $(document).on('click', '[data-bb-toggle="decrement-room"]', (e) => {
        const currentTarget = $(e.currentTarget)
        const $input = currentTarget.closest('.input-quantity').find('input')
        const inputName = $input.prop('name')
        const min = parseInt($input.prop('min'))

        let value = parseInt($input.val())
        if (value > min) {
            $input.val(value - 1)
            $(`[data-bb-toggle="filter-${inputName}-count"]`).text(value - 1)
        }
    })

    $(document)
        .on('click', '[data-bb-toggle="increment-room"]', (e) => {
            const currentTarget = $(e.currentTarget)
            const $input = currentTarget.closest('.input-quantity').find('input')
            const inputName = $input.prop('name')
            const max = parseInt($input.prop('max'))

            let value = parseInt($input.val())
            if (value < max) {
                $input.val(value + 1)
                $(`[data-bb-toggle="filter-${inputName}-count"]`).text(value + 1)
            }
        })
        .on('click', '[data-bb-toggle="toggle-guests-and-rooms"]', (e) => {
            const currentTarget = $(e.currentTarget)
            const $target = $(currentTarget.data('target'))

            $target.toggle('fast')
        })
})
