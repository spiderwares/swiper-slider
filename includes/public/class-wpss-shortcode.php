<?php
/**
 * Manage slider post type
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'WPSS_Slider_Shortcode' ) ) :

class WPSS_Slider_Shortcode {

    protected $settings = [];

    protected $slider_ID = '';

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

        $arrow_css = $this->arrow_css( $this->settings, $this->slider_ID );

        if ( ! empty( $arrow_css ) ) :
            wp_add_inline_style( 'wpss-frontend-style', $arrow_css );
        endif;
    }

    public function arrow_css( $settings, $slider_ID ) {
        ob_start();

        wpss_get_template(
            'fields/dynamic-style.php',
            array(
                'settings'      => $settings,
                'slider_id'     => $slider_ID
            )
        );

        return ob_get_clean();
    }

    public function genrate_slider_Shortcode( $args ) {
        $slideshow_ID       = !empty( $args['id'] ) ? $args['id'] : '';
        $this->slider_ID    = $slideshow_ID;

        if ( empty( $slideshow_ID ) ) :
            return '<p>' . esc_html__( "Error: Slideshow ID not found!", 'swiper-slider' ) . '</p>';
        endif;

        $imageIDs         = json_decode( get_post_meta( $slideshow_ID, 'wpss_slider_image_ids', true ), true );
        $sliderOptions    = get_post_meta( $slideshow_ID, 'wpss_slider_option', true );

        // echo "<pre>";
        // print_r($sliderOptions); die; 

        if ( empty( $imageIDs ) || ! is_array( $imageIDs ) ) :
            return '<p>' . esc_html__( "No slides found. Please add at least one image.", 'swiper-slider' ) . '</p>';
        endif;

        $arrow_style                    = isset($sliderOptions['navigation_arrow_style']) ? $sliderOptions['navigation_arrow_style'] : 'style1';
        $bullets_style                  = isset($sliderOptions['bullets_navigation_style']) ? $sliderOptions['bullets_navigation_style'] : 'style1';
        $custom_style                   = isset($sliderOptions['custom_navigation_style']) ? $sliderOptions['custom_navigation_style'] : 'style1';
        $lazy_load                      = isset($sliderOptions['control_lazyload_images']) ? $sliderOptions['control_lazyload_images'] : '';
        $pagination_type                = isset($sliderOptions['pagination_type']) ? $sliderOptions['pagination_type'] : 'bullets';
        $progress_position              = isset($sliderOptions['progress_bar_position']) ? $sliderOptions['progress_bar_position'] : 'bottom';
        $is_vertical                    = isset($sliderOptions['control_slider_vertical']) && ($sliderOptions['control_slider_vertical'] == '1' || $sliderOptions['control_slider_vertical'] === true);
        $thumb_gallery                  = isset($sliderOptions['thumb_gallery']) && ($sliderOptions['thumb_gallery'] == '1' || $sliderOptions['thumb_gallery'] === true);
        $thumb_width                    = !empty($sliderOptions['thumb_gallery_width']) ? (int)$sliderOptions['thumb_gallery_width'] : 70;
        $thumb_height                   = !empty($sliderOptions['thumb_gallery_height']) ? (int)$sliderOptions['thumb_gallery_height'] : 70;
        $width_image_value              = !empty($sliderOptions['width_image']) ? $sliderOptions['width_image'] : 500;
        $height_image_value             = !empty($sliderOptions['height_image']) ? $sliderOptions['height_image'] : 500;
        $image_unit                     = !empty($sliderOptions['image_unit']) ? $sliderOptions['image_unit'] : 'px';
        $width_image                    = $width_image_value . $image_unit;
        $height_image                   = $height_image_value . $image_unit;
        $wrapper_style                  = $is_vertical ? '' : 'style="max-width:' . esc_attr($width_image) . ';"';
        $control_autoplay               = !empty($sliderOptions['control_autoplay']) && $sliderOptions['control_autoplay'] == '1';
        $control_autoplay_timeleft      = !empty($sliderOptions['control_autoplay_timeleft']) && $sliderOptions['control_autoplay_timeleft'] == '1';
        $timeleft_position              = isset($sliderOptions['control_autoplay_timeleft_position']) ? $sliderOptions['control_autoplay_timeleft_position'] : 'bottom-right';
        $autoplay_timeleft_font_size    = isset($sliderOptions['control_autoplay_timeleft_font_size']) ? (int)$sliderOptions['control_autoplay_timeleft_font_size'] : 5;

        $timeleft_class = 'wpss-timeleft-' . esc_attr($timeleft_position);

        $slideshow_main_class = trim(
            'wpss_slider--' . $slideshow_ID .
            ' wpss-swiper-arrow-' . esc_attr($arrow_style) .
            ($pagination_type === 'custom' ? '' : ' wpss-swiper-dot-' . esc_attr($bullets_style)) .
            ' wpss-swiper-custom-' . esc_attr($custom_style) .
            ' wpss-pagination-' . esc_attr($pagination_type) .
            ' wpss-progress-' . esc_attr($progress_position) .
            ' wpss-timeleft-' . esc_attr($timeleft_position) 
        );

        // Get per-instance inline arrow style
        $arrow_css = $this->arrow_css( $sliderOptions, $slideshow_ID );

        ob_start();
        wpss_get_template(
            'frontend/slideshow.php',
            array(
                'imageIDs'                      => $imageIDs, 
                'slideshow_ID'                  => $slideshow_ID,
                'slideshow_main_class'          => $slideshow_main_class,
                'bullets_style'                 => $bullets_style,
                'custom_style'                  => $custom_style,
                'arrow_style'                   => $arrow_style,
                'lazy_load'                     => $lazy_load,
                'pagination_type'               => $pagination_type,
                'width_image'                   => $width_image,
                'height_image'                  => $height_image,
                'wrapper_style'                 => $wrapper_style,
                'thumb_gallery'                 => $thumb_gallery,
                'thumb_width'                   => $thumb_width,
                'thumb_height'                  => $thumb_height,
                'timeleft_position'             => $timeleft_position,
                'progress_position'             => $progress_position,
                 'timeleft_class'               => $timeleft_class,
                'control_autoplay'              => $control_autoplay,
                'autoplay_timeleft_font_size'   => $autoplay_timeleft_font_size,
                'control_autoplay_timeleft'     => $control_autoplay_timeleft,
                'arrow_css'                     => $arrow_css,
                'options'                       => json_encode($sliderOptions),

            )
        );
        return ob_get_clean();
    }

}

new WPSS_Slider_Shortcode();

endif;
