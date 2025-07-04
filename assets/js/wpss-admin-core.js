jQuery(function($) {
    class WPSS_Admin_Core {

        constructor() {
            this.init();
        }

        init() {
            this.cacheSelectors();
            this.bindEvents();
            this.initSortable();
            this.initColorPickers();

            $('.wpss-switch-field input[type="checkbox"], .wpss-select-field').each((i, el) => {
                this.toggleVisibility({ currentTarget: el });
            });

        }

        cacheSelectors() {
            this.$slideContainer = $('.wpss_slides');
        }

        bindEvents() {
            $(document.body).on('click', '.wpss_upload_slide', this.handleUploadSlide.bind(this));
            $(document.body).on('click', '.wpss_slide_remove', this.handleRemoveSlide.bind(this));
            $(document.body).on('change', '.wpss-switch-field input[type="checkbox"], .wpss-select-field',this.toggleVisibility.bind(this));
        }

        // toggleVisibility(e) {
        //     var __this = $(e.currentTarget);

        //     if (__this.is('select')) {
        //         var target     = __this.find(':selected').data('show'),
        //             hideElement = __this.data('hide');
        //         $(document.body).find(hideElement).hide();
        //         $(document.body).find(target).show();
        //     } else {
        //         var target = __this.data('show');
        //         $(document.body).find(target).toggle(__this.is(':checked'));
        //     }
        // }
        

        toggleVisibility(e) {
            const __this = $(e.currentTarget);

            if (__this.is('select')) {
                const target    = __this.find(':selected').data('show'),
                    hideElement = __this.data('hide');
                $(document.body).find(hideElement).hide();
                $(document.body).find(target).show();

                if (__this.is('[name="wpss_slider_option[pagination_type]"]')) {
                    const isProgressbar = __this.val() === 'progressbar',
                        isAutoplayProgressChecked = $('[name="wpss_slider_option[control_autoplay_progress]"]').is(':checked');
                    $(document.body).find('.wpss-progress-bar').toggle(isProgressbar && isAutoplayProgressChecked);
                }
            } else if (__this.is('input[type="checkbox"]')) {
                const target        = __this.data('show'),
                    isProgressbar   = $('[name="wpss_slider_option[pagination_type]"]').val() === 'progressbar';
                if (target === '.wpss-progress-bar') {
                    $(document.body).find(target).toggle(__this.is(':checked') && isProgressbar);
                } else {
                    $(document.body).find(target).toggle(__this.is(':checked'));
                }
            }
        }


        handleUploadSlide(e) {
            e.preventDefault();
            const mediaUploader = wp.media({
                title: 'Insert images',
                library: { type: 'image' },
                button: { text: 'Use these images' },
                multiple: true
            });

            mediaUploader.on('select', () => {
                const attachments = mediaUploader.state().get('selection').map(att => att.toJSON());

                attachments.forEach(attachment => {
                    const imageUrl = attachment.sizes?.wpss_slideshow_thumbnail?.url || attachment.url;

                    const slideHtml = `
                        <li>
                            <img width="250" src="${imageUrl}" />
                            <div class="wpss_slide_actions">
                                <a href="#" class="wpss_slide_move">
                                    <span class="tooltip">Drag & Sort</span>
                                    <i class="dashicons dashicons-move"></i>
                                </a>
                                <a href="#" class="wpss_slide_remove">
                                    <span class="tooltip">Delete</span>
                                    <i class="dashicons dashicons-trash"></i>
                                </a>
                            </div>
                            <input type="hidden" name="wpss_slider_image_ids[]" value="${attachment.id}" />
                        </li>`;
                    this.$slideContainer.append(slideHtml);
                });
            });

            mediaUploader.open();
        }

        handleRemoveSlide(e) {
            e.preventDefault();
            $(e.currentTarget).closest('li').remove();
        }

        initSortable() {
            this.$slideContainer.sortable({
                items: 'li',
                handle: '.wpss_slide_move',
                cursor: '-webkit-grabbing',
                stop: (event, ui) => {
                    ui.item.removeAttr('style');
                }
            });
        }

        initColorPickers() {
            if ($.fn.wpColorPicker) {
                $('.wpss-color-picker').wpColorPicker();
            }
        }
    }

    new WPSS_Admin_Core();
});
