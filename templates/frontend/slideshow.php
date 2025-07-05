<?php if ( ! empty($imageIDs)) : ?>
    <div class="swiper swiper-slider-wrapper <?php echo esc_attr($slideshow_main_class); ?>" 
    data-options='<?php echo esc_attr( $options );?>'
    <?php echo wp_kses_post( $wrapper_style ); ?>>
        <div class="swiper-wrapper">
            <?php foreach( $imageIDs as $imageID ) :
                $image_style = sprintf(
                    'width: %dpx; height: %dpx; object-fit: cover;',
                    (int) $width_image,
                    (int) $height_image
                );
            ?>
                <div class="swiper-slide">
                    <div class="swiper-zoom-container">
                        <img 
                            src="<?php echo esc_url( wp_get_attachment_image_url( $imageID, 'full' ) ); ?>" 
                            alt="" 
                            loading="lazy"
                            style="<?php echo esc_attr($image_style); ?>"
                        />

                        <?php if( $lazy_load ): ?>
                            <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination Type -->
        <?php if ( $dot_style !== 'none' || in_array($pagination_type, ['progressbar', 'fraction', 'custom'], true) ) : ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>

        <!-- Scrollbar --->
        <?php
             $scrollbar = apply_filters( 'wpss_pro_slider_scrollbar', '', array(
                'image_ids' => $imageIDs,
                'options'   => $options,
                'class'     => $slideshow_main_class,
            ) );

            // Proper escaping for filter output
            echo wp_kses_post( $scrollbar );
        ?>

        <!-- Next & Prev Button -->
        <?php if( $arrow_style != 'none' ): ?>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        <?php endif; ?>
        
    </div>

    <!-- Swiper Thumbs Gallery -->
    <?php if (!empty($show_thumb_gallery)): ?>
    <div class="swiper wpss-swiper-thumbs-gallery wpss-thumbs-<?php echo esc_attr($thumb_gallery_orientation ?? 'horizontal'); ?>"
        data-thumb-width="<?php echo esc_attr($thumb_gallery_img_width ?? 68); ?>"
        data-thumb-height="<?php echo esc_attr($thumb_gallery_img_height ?? 68); ?>">
        <div class="swiper-wrapper">
            <?php foreach( $imageIDs as $imageID ) : ?>
                <div class="swiper-slide">
                    <img 
                        src="<?php echo esc_url( wp_get_attachment_image_url( $imageID, 'thumbnail' ) ); ?>" 
                        alt="" 
                        style="width:<?php echo esc_attr($thumb_gallery_img_width ?? 68); ?>px;height:<?php echo esc_attr($thumb_gallery_img_height ?? 68); ?>px;object-fit:cover;"
                    />
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
<?php endif; ?>