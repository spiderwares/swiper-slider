jQuery(function ($) {

    class WPSS_Frontend {

        constructor() {
            this.init();
        }

        init() {
            this.initializeSliders();
        }

        initializeSliders() {
            $('.wpss-swiper').each((index, element) => {
                const slider = $(element),
                    rawOptions = slider.attr('data-options');

                if (!rawOptions) return;

                let options = this.parseOptions(rawOptions);
                if (!options) return;

                if (options.slide_control_view_auto == '1' || options.slide_control_view_auto === true) {
                    slider.addClass('wpss-auto-slides');
                }
                
                // Only initialize thumbs if enabled in options
                let thumbsSwiper = null;
                if (options.thumb_gallery == '1' || options.thumb_gallery === true) {
                     const thumbsGallery = slider.parent().find('.wpss-swiper-thumbs-gallery');
                    if (thumbsGallery.length) {
                        thumbsSwiper = new Swiper(thumbsGallery[0], {
                            loop: options.thumb_gallery_loop === '1',
                            spaceBetween: parseInt(options.thumb_gallery_space, 10) || 10,
                            slidesPerView: 3,
                            watchSlidesProgress: true,
                        });
                    }
                }

                const finalOptions = this.swiperOptions(slider, options);
                if (thumbsSwiper) {
                    finalOptions.thumbs = { swiper: thumbsSwiper };
                }
                this.createSwiperInstance(slider, finalOptions);
            });
        }

        parseOptions(rawOptions) {
            try {
                return JSON.parse(rawOptions);
            } catch (error) {
                console.error("Invalid JSON in data-options:", error);
                return null;
            }
        }

        swiperOptions(slider, options) {
            const isResponsive  = options.control_enable_responsive === '1' || options.control_enable_responsive === 1,
                isAutoSlides    = options.slide_control_view_auto == '1' || options.slide_control_view_auto === true,
                paginationType  = options.pagination_type || 'bullets',
                customStyle     = options.custom_navigation_style || 'style1',
                customTextColor = options.custom_text_color || '#ff0000',
                customBackgroundColor = options.custom_background_color || '#007aff',
                customActiveTextColor = options.custom_active_text_color || '#0a0607',
                customActiveBackgroundColor = options.custom_active_background_color || '#0a0607';

            const baseOptions = {
                effect: options.animation || 'slide',
                grabCursor: options.control_grab_cursor == '1',
                slidesPerView: isAutoSlides ? 'auto' : isResponsive ? (parseInt(options.items_in_desktop) || 1) : 1,
                autoplay: options.control_autoplay == '1' ? {
                    delay: parseInt(options.autoplay_timing, 10) || 3000,
                    disableOnInteraction: false,
                } : false,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    renderBullet: function (index, className) {
                        if (paginationType === 'custom') {
                            return `<span class="${className} wpss-swiper-custom-${customStyle}">${index + 1}</span>`;
                        }
                        return `<span class="${className}"></span>`;
                    },
                    type: paginationType === 'progressbar' ? 'progressbar' :
                        paginationType === 'fraction' ? 'fraction' :
                        'bullets',
                },
                navigation: {
                    nextEl: slider.find('.swiper-button-next')[0],
                    prevEl: slider.find('.swiper-button-prev')[0],
                },
                lazy: options.control_lazyload_images == '1' || options.control_lazyload_images === true,
                on: {
                    init: function () {
                        const isAutoplayProgress = options.control_autoplay_progress == '1' || options.control_autoplay_progress === true;

                        if (isAutoplayProgress && options.progress_bar_color && options.pagination_type == 'progressbar') {
                            const $progressbar = slider.find('.swiper-pagination-progressbar-fill').addClass('wpss-progressbar-fill');
                            $progressbar.css({ background: options.progress_bar_color });
                        }

                        if (options.pagination_type === 'fraction' && options.fraction_color) {
                            const $fraction = slider.find('.swiper-pagination');
                            $fraction.css('color', options.fraction_color);
                        }

                        if (paginationType === 'custom') {
                            const $pagination = slider.find('.swiper-pagination');
                            $pagination.css({
                                '--wpss-custom-text-color': customTextColor,
                                '--wpss-custom-bg-color': customBackgroundColor,
                                '--wpss-custom-active-text-color': customActiveTextColor,
                                '--wpss-custom-active-bg-color': customActiveBackgroundColor
                            });
                        }
                    }
                },
            };

            if (!isAutoSlides && isResponsive) {
                baseOptions.breakpoints = this.getResponsiveBreakpoints(options);
            }

            return $.extend({}, baseOptions, options);
        }

        getResponsiveBreakpoints(options) {
            return {
                1024: {
                    slidesPerView: parseInt(options.items_in_desktop) || 4,
                },
                768: {
                    slidesPerView: parseInt(options.items_in_tablet) || 2,
                },
                400: {
                    slidesPerView: parseInt(options.items_in_mobile) || 1,
                }
            };
        }

        createSwiperInstance(slider, finalOptions) {
            new Swiper(slider[0], finalOptions);
        }

    }

    new WPSS_Frontend();

});
