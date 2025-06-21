<?php
/**
 * Manage slider post type
 */


if( ! class_exists( 'WPSS_Slider_Shortcode' ) ) :

    class WPSS_Slider_Shortcode {

        function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_shortcode( 'wpss_slider', [ $this, 'genrate_slider_Shortcode' ] );
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
        }

        public function genrate_slider_Shortcode( $args ) {
            $slideshow_ID = !empty( $args['slideshow_ID'] ) && isset( $args['slideshow_ID'] ) ? $args['slideshow_ID'] : '';
            if( empty( $slideshow_ID ) ) 
                return new WP_Error( 
                    'error',
                     __( "Error, 404 not found!", 'wpss-simple-slider' ) 
                );

            $imageIDs = get_post_meta( $slideshow_ID, 'wpss_slider_image_ids', true );
            if( empty( $imageIDs ) ) 
                return new WP_Error( 
                    'error',
                    __( "Error, Please insert atleast one slide!", 'wpss-simple-slider' ) 
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

            wpss_get_template(
                'frontend/slideshow.php',
                array(
                    'slides'        => $slides,
                    'slideshow_ID'  => $slideshow_ID,
                    'slideshow_main_class' => 'wpss_slider--' . $slideshow_ID,
                    'slideshowAttr'    => json_encode( $slideshowAttr )
                )
            );
        }
    }
    new WPSS_Slider_Shortcode();
endif;