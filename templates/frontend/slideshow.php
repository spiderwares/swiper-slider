<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! empty($imageIDs)) : 
?>
    <?php if ( ! empty( $arrow_css ) ) : ?>
        <style><?php echo esc_html( $arrow_css ); ?></style>
    <?php endif; ?>

    <div class="wpss-swiper swiper swiper-slider-wrapper <?php echo esc_attr($slideshow_main_class); ?>" 
    data-options='<?php echo esc_attr( $options );?>'
    <?php echo wp_kses_post( $wrapper_style ); ?>>
        <div class="swiper-wrapper">
            <?php foreach( $imageIDs as $imageID ) :
                $image_style = sprintf(
                    'width: %s; height: %s; object-fit: cover;',
                    esc_attr($width_image),
                    esc_attr($height_image)
                ); ?>
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
        <?php if ( $pagination_type !== 'none' ) : ?>
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

        <div class="autoplay-progress <?php echo esc_attr($timeleft_class); ?>">
            <svg viewBox="0 0 48 48">
                <circle cx="24" cy="24" r="20"></circle>
            </svg>
            <span style="font-size: <?php echo esc_attr($autoplay_timeleft_font_size); ?>px;"></span>
        </div>
    </div>

   <!-- Swiper Thumbs Gallery -->
    <?php
    if ( ! empty( $thumb_gallery ) ) :
        $thumb_gallery = apply_filters( 'wpss_pro_slider_thumb_gallery', '', array(
            'image_ids'      => $imageIDs,
            'thumb_width'    => $thumb_width,
            'thumb_height'   => $thumb_height,
            'main_class'     => $slideshow_main_class,
        ) );
        echo wp_kses_post( $thumb_gallery );
    endif;
    ?>

<?php endif; ?> 