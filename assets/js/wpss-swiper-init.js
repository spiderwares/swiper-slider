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
                
                // Thumbs enabled options
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
            const isResponsive  = options.control_enable_responsive == '1' || options.control_enable_responsive === 1,
                isAutoSlides    = options.slide_control_view_auto == '1' || options.slide_control_view_auto === true,
                paginationType  = options.pagination_type || 'bullets',
                customStyle     = options.custom_navigation_style || 'style1',
                customTextColor = options.custom_text_color || '#ff0000',
                customBackgroundColor = options.custom_background_color || '#007aff',
                customActiveTextColor = options.custom_active_text_color || '#0a0607',
                customActiveBackgroundColor = options.custom_active_background_color || '#0a0607';

            const baseOptions = {
                effect:         options.animation || 'slide',
                grabCursor:     options.control_grab_cursor == '1',
                slidesPerView: isAutoSlides ? 'auto' : isResponsive ? (parseInt(options.items_in_desktop) || 1) : 1,
                autoplay:       options.control_autoplay == '1' ? {
                    delay:      parseInt(options.autoplay_timing, 10) || 3000,
                    disableOnInteraction: false,
                } : false,
                pagination: paginationType !== 'none' ? {
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
                } : undefined,
                navigation: {
                    nextEl: slider.find('.swiper-button-next')[0],
                    prevEl: slider.find('.swiper-button-prev')[0],
                },
                lazy: options.control_lazyload_images == '1' || options.control_lazyload_images === true,

                on: {
                    init: function () {
                        if ( options.control_autoplay_progress == '1' && options.pagination_type == 'progressbar' && options.progress_bar_color ) {
                            const progressbar = slider.find('.swiper-pagination-progressbar-fill').addClass('wpss-progressbar-fill');
                            progressbar.css({ background: options.progress_bar_color });
                        }

                        if (options.pagination_type === 'fraction') {
                            const fractionEl = slider.find('.swiper-pagination');
                            if (options.fraction_color) {
                                fractionEl.css('color', options.fraction_color);
                            }
                            if (options.fraction_font_size) {
                                fractionEl.css('font-size', `${parseInt(options.fraction_font_size)}px`);
                            }
                        }


                        if (paginationType === 'custom') {
                            slider.find('.swiper-pagination').css({
                                '--wpss-custom-text-color': customTextColor,
                                '--wpss-custom-bg-color': customBackgroundColor,
                                '--wpss-custom-active-text-color': customActiveTextColor,
                                '--wpss-custom-active-bg-color': customActiveBackgroundColor
                            });
                        }
                        
                        if (options.control_autoplay_timeleft == '1' && options.control_autoplay_timeleft_color) {
                            const progress_time = slider.find('.autoplay-progress');
                            progress_time.find('svg').css('stroke', options.control_autoplay_timeleft_color);
                            progress_time.find('span').css('color', options.control_autoplay_timeleft_color);
                        }
                    },
                    autoplayTimeLeft(swiper, time, progress) {
                         if (options.control_autoplay_timeleft == '1') {
                            const progress_time = slider.find('.autoplay-progress');
                            if (progress_time.length) {
                                progress_time.find('svg').css('--progress', 1 - progress);
                                progress_time.find('span').text(`${Math.ceil(time / 1000)}s`);
                            }
                        }
                    }
                },
            };

            if (options.animation === 'cube') {
                baseOptions.cubeEffect = {
                    shadow: options.cube_shadows === '1' || options.cube_shadows === true,
                    slideShadows: options.cube_slide_shadows === '1' || options.cube_slide_shadows === true,
                    shadowOffset: parseInt(options.cube_shadowoffset) || 20,
                    shadowScale: parseInt(options.cube_shadowScale) || 0.94,
                };
            }

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
                300: {
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
