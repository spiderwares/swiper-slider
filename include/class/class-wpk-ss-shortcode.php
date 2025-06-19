<?php
/**
 * Manage slider post type
 */


if( ! class_exists( 'WPK_slider_shortcode' ) ) :

    class WPK_slider_shortcode {

        function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_shortcode( 'wpk_slider', [ $this, 'genrate_slider_Shortcode' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'slideshow_enqueue_frontend_assets' ], 10 );

        }

        public function slideshow_enqueue_frontend_assets() {
            wp_enqueue_script( 'swiper-bundle.min--js', WPK_SIMPLE_SLIDER_URL . 'assets/js/swiper-bundle.min.js', array(), WPK_SIMPLE_SLIDER_VERSION, true );
            wp_enqueue_style( 'swiper-bundle.min--css', WPK_SIMPLE_SLIDER_URL . 'assets/css/swiper-bundle.min.css', array(), WPK_SIMPLE_SLIDER_VERSION );
        }

        public function genrate_slider_Shortcode( $args ) {
            $slideshow_ID = !empty( $args['slideshow_ID'] ) && isset( $args['slideshow_ID'] ) ? $args['slideshow_ID'] : '';
            if( empty( $slideshow_ID ) ) 
                return new WP_Error( 
                    'error',
                     __( "Error, 404 not found!", 'wpk-simple-slider' ) 
                );

            $imageIDs = get_post_meta( $slideshow_ID, 'wpk_slider_image_ids', true );
            if( empty( $imageIDs ) ) 
                return new WP_Error( 
                    'error',
                    __( "Error, Please insert atleast one slide!", 'wpk-simple-slider' ) 
                );

            $slides = get_posts( 
                array(
                    'post_type' => 'attachment',
                    'orderby' => 'post__in',
                    'order' => 'ASC',
                    'post__in' => $imageIDs,
                    'numberposts' => -1,
                    'post_mime_type' => 'image'
                ) 
            );
            
            $slideshowAttr = array(
                "navigation" => array(
                    'nextEl'  => ".swiper-" . $slideshow_ID . "-next",
                    'prevEl'  => ".swiper-" . $slideshow_ID . "-prev",
                )
            );
            wp_localize_script( 'swiper-bundle.min', $slideshow_ID, $slideshowAttr );

            wpk_get_temlpate(
                'frontend/slideshow.php',
                array(
                    'slides'        => $slides,
                    'slideshow_ID'  => $slideshow_ID,
                    'slideshow_main_class' => 'wpk_slider--' . $slideshow_ID,
                    'slideshowAttr'    => json_encode( $slideshowAttr )
                )
            );
        }
    }
    new WPK_slider_shortcode();
endif;