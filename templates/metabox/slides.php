<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
?>
<div class="wpss_slides_wrap">
    <ul class="wpss_slides">
        <?php if (isset($imageIDs) && !empty($imageIDs)) : 
            foreach ( $imageIDs as $imageID ) : ?>
                <li>
                    <img width="250" src="<?php echo esc_url( wp_get_attachment_image_src( $imageID, 'wpss_slideshow_thumbnail' )[0] ); ?>" />
                    <div class="wpss_slide_actions">
                        <a href="#" class="wpss_slide_move">
                            <span class="tooltip">
                                <?php echo esc_html__( 'Drag & Sort' , 'swiper-slider' ); ?>
                            </span>
                            <i class="dashicons dashicons-move"></i>
                        </a>
                        <a href="#" class="wpss_slide_remove">
                            <span class="tooltip">
                                <?php echo esc_html__( 'Delete' , 'swiper-slider' ) ?>
                        </span>
                            <i class="dashicons dashicons-trash"></i>
                        </a>
                    </div>
                    <input type="hidden" name="<?php echo esc_attr( $metaKey ); ?>[]" value="<?php echo esc_attr( $imageID ); ?>" />
                </li>
            <?php endforeach;
        endif; ?>
    </ul>

    <div style="clear:both"></div>
    <?php wp_nonce_field( 'wpss_slideshow_metabox_data', 'wpss_slideshow_metabox_nonce' ); ?>
    <a href="#" class="button wpss_upload_slide">
        <?php echo esc_html__( 'Add Slide', 'swiper-slider' ); ?>
    </a>
</div>
