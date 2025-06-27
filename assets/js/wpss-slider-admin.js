jQuery(function ($) {

    class WPSS_Responsive_Field {
        constructor() {
            this.init();
        }

        init() {
            this.cacheSelectors();
            this.bindEvents();
            this.ResponsiveFields();
            this.ProgressBarFields();
        }

        cacheSelectors() {
            this.$responsiveToggle      = $('#wpss_enable_responsive');
            this.$responsiveFields      = $('.wpss-responsive-field');
            this.$progressBar           = $('[name="wpss_slider_option[control_autoplay_progress]"]');
            this.$progressBarColorField = $('.wpss-progress-bar')
        }

        bindEvents() {
            this.$responsiveToggle.on('change', this.ResponsiveFields.bind(this));
            this.$progressBar.on('change', this.ProgressBarFields.bind(this));
        }

        ResponsiveFields() {
            const isEnabled = this.$responsiveToggle.is(':checked');
            this.$responsiveFields.toggle(isEnabled);
        }

        ProgressBarFields() {
            const isChecked = this.$progressBar.is(':checked');
            this.$progressBarColorField.closest('tr').toggle(isChecked);
        }
    }

    new WPSS_Responsive_Field();
});
