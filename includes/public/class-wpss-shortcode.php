<?php
/**
 * Manage slider post type
 */

if( ! class_exists( 'WPSS_Slider_Shortcode' ) ) :

class WPSS_Slider_Shortcode {

    public function __construct() {
        $this->event_handler();
    }

    public function event_handler() {
        add_shortcode( 'wpss_simple_slider', [ $this, 'genrate_slider_Shortcode' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'slideshow_enqueue_frontend_assets' ], 10 );
    }

    public function slideshow_enqueue_frontend_assets() {
        wp_enqueue_script( 
            'swiper-bundle.min--js', 
            WPSS_URL . 'assets/js/swiper-bundle.min.js', 
            array(), 
            WPSS_VERSION, 
            true 
        );

        wp_enqueue_style( 
            'swiper-bundle.min--css', 
            WPSS_URL . 'assets/css/swiper-bundle.min.css', 
            array(), 
            WPSS_VERSION 
        );

        wp_enqueue_script(
            'wpss-swiper-init',
            WPSS_URL . 'assets/js/wpss-swiper-init.js',
            array('jquery'),
            WPSS_VERSION,
            true
        );

        wp_enqueue_style(
            'wpss-frontend-style',
            WPSS_URL . 'assets/css/wpss-frontend-style.css',
            array(),
            WPSS_VERSION
        );
    }

    public function genrate_slider_Shortcode( $args ) {
        $slideshow_ID = !empty( $args['id'] ) ? $args['id'] : '';

        if ( empty( $slideshow_ID ) ) :
            return '<p>' . esc_html__( "Error: Slideshow ID not found!", 'swiper-slider' ) . '</p>';
        endif;

        $imageIDs         = json_decode( get_post_meta( $slideshow_ID, 'wpss_slider_image_ids', true ), true);

        $sliderOptions    = get_post_meta( $slideshow_ID, 'wpss_slider_option', true );

        if ( empty( $imageIDs ) || ! is_array( $imageIDs ) ) :
            return '<p>' . esc_html__( "No slides found. Please add at least one image.", 'swiper-slider' ) . '</p>';
        endif;

        $arrow_style        = isset($sliderOptions['navigation_arrow_style']) ? $sliderOptions['navigation_arrow_style'] : 'style1';
        $dot_style          = isset($sliderOptions['dots_navigation_style']) ? $sliderOptions['dots_navigation_style'] : 'style1';
        $custom_style       = isset($sliderOptions['custom_navigation_style']) ? $sliderOptions['custom_navigation_style'] : 'style1';
        $lazy_load          = isset($sliderOptions['control_lazyload_images']) ? $sliderOptions['control_lazyload_images'] : '';
        $pagination_type    = isset($sliderOptions['pagination_type']) ? $sliderOptions['pagination_type'] : 'bullets';
        $progress_position  = isset($sliderOptions['progress_bar_position']) ? $sliderOptions['progress_bar_position'] : 'bottom';
        $width_image        = !empty($sliderOptions['width_image']) ? $sliderOptions['width_image'] : 500;
        $height_image       = !empty($sliderOptions['height_image']) ? $sliderOptions['height_image'] : 500;

        $is_vertical        = isset($sliderOptions['control_slider_vertical']) && ($sliderOptions['control_slider_vertical'] == '1' || $sliderOptions['control_slider_vertical'] === true);
        $wrapper_style      = $is_vertical ? '' : 'style="max-width:' . (int) $width_image . 'px;"';

        $slideshow_main_class = trim(
            'wpss_slider--' . $slideshow_ID .
            ' wpss-swiper-arrow-' . esc_attr($arrow_style) .
            ($pagination_type === 'custom' ? '' : ' wpss-swiper-dot-' . esc_attr($dot_style)) .
            ' wpss-swiper-custom-' . esc_attr($custom_style) .
            ' wpss-pagination-' . esc_attr($pagination_type) .
            ' wpss-progress-' . esc_attr($progress_position) .
            ( $is_vertical ? ' vertical' : '' )
        );

        // Prepare thumb gallery options for template
        $show_thumb_gallery = isset($sliderOptions['show_thumb_gallery']) && ($sliderOptions['show_thumb_gallery'] == '1' || $sliderOptions['show_thumb_gallery'] === true);

        ob_start();
        wpss_get_template(
            'frontend/slideshow.php',
            array(
                'imageIDs'              => $imageIDs, 
                'slideshow_ID'          => $slideshow_ID,
                'slideshow_main_class'  => $slideshow_main_class,
                'dot_style'             => $dot_style,
                'custom_style'          => $custom_style,
                'arrow_style'           => $arrow_style,
                'lazy_load'             => $lazy_load,
                'pagination_type'       => $pagination_type,
                'width_image'           => $width_image,
                'height_image'          => $height_image,
                'wrapper_style'         => $wrapper_style,
                'options'               => json_encode($sliderOptions),
                'show_thumb_gallery'    => $show_thumb_gallery,
            )
        );
        return ob_get_clean();
    }

}
new WPSS_Slider_Shortcode();

endif;