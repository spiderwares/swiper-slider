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
        }

        cacheSelectors() {
            this.$slideContainer = $('.wpss_slides');
        }

        bindEvents() {
            $(document.body).on('click', '.wpss_upload_slide', this.handleUploadSlide.bind(this));
            $(document.body).on('click', '.wpss_slide_remove', this.handleRemoveSlide.bind(this));
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