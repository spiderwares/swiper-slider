jQuery(function ($) {

    class WPSS_Slider_Frontend {

        constructor() {
            this.init();
        }

        init() {
            this.initializeSliders();
        }

        initializeSliders() {
            $('.swiper.swiper-slider-wrapper').each((index, element) => {
                const slider = $(element),
                    rawOptions = slider.attr('data-options');

                if (!rawOptions) return;

                let options = this.parseOptions(rawOptions);
                if (!options) return;

                const finalOptions = this.buildSwiperOptions(slider, options);
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

        buildSwiperOptions(slider, options) {
            const isResponsive  = options.control_enable_responsive === '1' || options.control_enable_responsive === 1,
                isAutoSlides    = options.slide_control_view_auto == '1' || options.slide_control_view_auto === true,
                progresscolor   = options.progress_bar_color,
                fractionColor   = options.fraction_color;

            const baseOptions = {
                effect: options.animation || 'slide',
                grabCursor: options.control_grab_cursor == '1',
                slidesPerView: isAutoSlides ? 'auto' : isResponsive ? (parseInt(options.items_in_desktop) || 1) : 1,
                autoplay: options.control_autoplay == '1' ? {
                    delay: parseInt(options.autoplay_timing, 10) || 3000,
                    disableOnInteraction: false,
                } : false,
                pagination: {
                    el: slider.find('.swiper-pagination')[0],
                    clickable: true,
                    type: options.pagination_type === 'progressbar' ? 'progressbar' : 
                        options.pagination_type === 'fraction' ? 'fraction' : 'bullets',
                },
                navigation: {
                    nextEl: slider.find('.swiper-button-next')[0],
                    prevEl: slider.find('.swiper-button-prev')[0],
                },
                lazy: options.control_lazyload_images == '1' || options.control_lazyload_images === true,
                on: {
                    init: function () {
                        const isAutoplayProgress = options.control_autoplay_progress == '1' || options.control_autoplay_progress === true;
                        if (isAutoplayProgress && progresscolor && options.pagination_type == 'progressbar') {
                            const $progressbar = slider.find('.swiper-pagination-progressbar-fill');
                            $progressbar.css({ background: progresscolor });
                        }

                        if (options.pagination_type === 'fraction' && fractionColor) {
                            const $fraction = slider.find('.swiper-pagination');
                            $fraction.css('color', fractionColor);
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

    new WPSS_Slider_Frontend();

});