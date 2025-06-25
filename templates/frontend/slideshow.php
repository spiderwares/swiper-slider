<?php if ( ! empty($imageIDs)) : ?>
    <div class="swiper <?php echo esc_attr($slideshow_main_class); ?>" data-attr='<?php echo esc_attr($slideshowAttr); ?>'>
        <div class="swiper-wrapper">
            <?php foreach( $imageIDs as $imageID ) : ?>
                <div class="swiper-slide">
                    <img class="swiper-lazy" data-src="<?php echo wp_get_attachment_image_url( $imageID, 'full' ); ?>" />
                    <div class="wpss-swiper-lazy-preloader"></div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- <div class="swiper-pagination"></div> -->

        <?php if( $arrow_style != 'none' ): ?>
            <div class="swiper-button-next swiper-<?php echo esc_attr( $slideshow_ID ); ?>-next"></div>
            <div class="swiper-button-prev swiper-<?php echo esc_attr( $slideshow_ID ); ?>-prev"></div>
        <?php endif; ?>
    </div>
<?php endif; ?>
