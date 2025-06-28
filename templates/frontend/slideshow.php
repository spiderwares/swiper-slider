<?php if ( ! empty($imageIDs)) : ?>
    <div class="swiper swiper-slider-wrapper <?php echo esc_attr($slideshow_main_class); ?>" 
    data-options='<?php echo esc_attr( $options ); ?>'>
        <div class="swiper-wrapper">
            <?php foreach( $imageIDs as $imageID ) : ?>
                <div class="swiper-slide">
                    <img 
                        src="<?php echo esc_url( wp_get_attachment_image_url( $imageID, 'full' ) ); ?>" 
                        alt="" 
                        loading="lazy"  />

                    <?php if( $lazy_load ): ?>
                        <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Bullets Pagination -->
        <?php if ( $dot_style != 'none' ) : ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>
          
        <!-- Prev & Next Button -->
        <?php if( $arrow_style != 'none' ): ?>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        <?php endif; ?>
    </div>
<?php endif; ?>