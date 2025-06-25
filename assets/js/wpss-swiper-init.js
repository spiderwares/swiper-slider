class WPSS_Swiper_Slider {
    constructor() {
        this.init();
    }


    // Wait for DOM ready and then initialize sliders
    init() {
        document.addEventListener("DOMContentLoaded", () => {
            this.initAllSliders();
        });
    }

    // Initialize all sliders with `.swiper` class
    initAllSliders() {
        const sliders = document.querySelectorAll(".swiper");
        sliders.forEach((slider) => this.initSingleSlider(slider));
    }

    // Initialize a single slider
    initSingleSlider(slider) {
        const config = this.getSliderConfig(slider);
        new Swiper(slider, config);
    }

    getSliderConfig(slider) {
        const config = {
            loop: true,
            navigation: {}
        };

        this.applyDataNavigation(slider, config);
        this.applyGrabCursor(slider, config);
        this.applyAutoplay(slider, config);
        this.applyAutoplayProgress(slider, config);
        this.applyLazyLoad(slider, config);

        return config;
    }


    // Parse navigation data attribute and apply
    applyDataNavigation(slider, config) {
        const configData = slider.getAttribute("data-attr");
        if (configData) {
            try {
                const parsed = JSON.parse(configData);
                if (parsed.navigation) {
                    config.navigation = parsed.navigation;
                }
            } catch (error) {
                console.warn("Invalid swiper data config:", error);
            }
        }
    }

    // Enable grab cursor if class present
    applyGrabCursor(slider, config) {
        if (slider.classList.contains("wpss-swiper-grab-cursor")) {
            config.grabCursor = true;
        }
    }

    // Enable autoplay with optional delay
    applyAutoplay(slider, config) {
        if (slider.classList.contains("wpss-swiper-autoplay")) {
            const match = slider.className.match(/wpss-swiper-autoplay-(\d+)/);
            const delay = match ? parseInt(match[1], 10) : 3000;
            config.autoplay = {
                delay: delay,
                disableOnInteraction: false,
            };
        }
    }

    // Add progress bar if required
    applyAutoplayProgress(slider, config) {
        if (slider.classList.contains("wpss-wpss-swiper-autoplay-progress")) {
            const paginationEl = document.createElement("div");
            paginationEl.classList.add("swiper-pagination");
            slider.appendChild(paginationEl);

            config.pagination = {
                el: paginationEl,
                type: "progressbar",
            };
        }
    }

    // Enable lazy loading of images
    applyLazyLoad(slider, config) {
        if (slider.classList.contains("wpss-swiper-lazy-load")) {
            config.lazy = {
                loadPrevNext: true,
                loadOnTransitionStart: true,
            };
            config.watchSlidesProgress = true;
        }
    }
}

// Initialize the class
new WPSS_Swiper_Slider();