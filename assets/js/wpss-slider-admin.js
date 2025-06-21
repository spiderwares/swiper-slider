jQuery(function ($) {

    class WPSS_Responsive_Toggle {

        constructor() {
            this.init();
        }

        init() {
            this.cacheSelectors();
            this.bindEvents();
            this.handleToggleResponsiveFields();
        }

        cacheSelectors() {
            this.$responsiveToggle = $('#wpss_enable_responsive');
            this.$responsiveFields = $('.wpss-responsive-field');
        }

        bindEvents() {
            this.$responsiveToggle.on('change', this.handleToggleResponsiveFields.bind(this));
        }

        handleToggleResponsiveFields() {
            const isEnabled = this.$responsiveToggle.is(':checked');
            this.$responsiveFields.toggle(isEnabled);
        }
    }

    new WPSS_Responsive_Toggle();
    
});
