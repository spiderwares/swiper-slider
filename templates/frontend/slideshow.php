<?php if ( ! empty($imageIDs)) : ?>
    <div class="swiper swiper-slider-wrapper <?php echo esc_attr($slideshow_main_class); ?>" 
    data-options='<?php echo esc_attr( $options ); 
    ?>'>
        <div class="swiper-wrapper">
            <?php foreach( $imageIDs as $imageID ) : ?>
                <div class="swiper-slide">
                    <div class="swiper-zoom-container">
                        <img 
                            src="<?php echo esc_url( wp_get_attachment_image_url( $imageID, 'full' ) ); ?>" 
                            alt="" 
                            loading="lazy"  
                            style="<?php 
                            $is_vertical = isset($sliderOptions['control_slider_vertical']) && ($sliderOptions['control_slider_vertical'] == '1' || $sliderOptions['control_slider_vertical'] === true);
                            echo $is_vertical 
                                ? 'max-width: 100%; height: auto; object-fit: cover;'
                                : 'width: ' . esc_attr($width_image) . 'px; height: ' . esc_attr($height_image) . 'px; object-fit: cover;';
                            ?>"
                        />

                        <?php if( $lazy_load ): ?>
                            <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination Type -->
        <?php if ( $dot_style !== 'none' || in_array($pagination_type, ['progressbar', 'fraction'], true) ) : ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>

        <!-- Scrollbar --->
        <?php
            echo apply_filters( 'wpss_pro_slider_scrollbar', '', [
                'image_ids' => $imageIDs,
                'options'   => $options,
                'class'     => $slideshow_main_class,
            ] );
        ?>

        <!-- Next & Prev Button -->
        <?php if( $arrow_style != 'none' ): ?>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        <?php endif; ?>
        
    </div>
<?php endif; ?>