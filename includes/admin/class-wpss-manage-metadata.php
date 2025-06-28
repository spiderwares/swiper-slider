<?php 
/**
 * Metabox handling class
 */

if( ! class_exists( 'WPSS_slider_init' ) ) :

    class WPSS_slider_init {
        private $screens;
        private $metaKey;
        private $metaBoxs;
        private $fields;

        public $defaultOptions;

        public function __construct() {
            $this->default_Options();
            $this->event_handler();
        }

        public function event_handler() {
            add_action( 'add_meta_boxes', [ $this, 'intialize_slideshow_metabox' ], 10 );
            add_action( 'save_post', [ $this, 'save_slideshow_metadata' ] );
        }

        public function default_Options() {
            $this->metaKey = 'wpss_slider_image_ids';
            $this->screens = array( 'wpss_slider'  );
            $this->metaBoxs = array(
                'wpss-slideshow-metabox'     => array(
                    'name'      =>  'Slides',
                    'callback'  =>  'genrate_slideshow_metabox',
                ),
                'wpss-slideshow-options-metabox'    => array(
                    'name'      =>  'Slider Options',
                    'callback'  =>  'genrate_slideshow_option_metabox',
                )
            );

            $this->fields = apply_filters( 'wpss_slider_fields', array(
                'animation'  => array(
                    'name'          => esc_html__( 'Transition type', 'swiper-slider' ),
                    'field_type'    => 'radio',
                    'options'       => array(
                        'slide' =>  'animation-type-slide.gif',
                        'fade'  =>  'animation-type-fade.gif',
                        'flip'  =>  'animation-type-flip.gif',
                        'cube'  =>  'animation-type-cube.gif',
                    ),
                    'default'       => 'slide'
                ),
                'navigation_arrow_style' => array(
                    'name'          => esc_html__( 'Navigation arrows style', 'swiper-slider' ),
                    'field_type'    => 'radio',
                    'options'       => array(
                        'none'   =>  'arrow-style-none.jpg',
                        'style1' =>  'arrow-style-1.jpg',
                        'style2' =>  'arrow-style-2.jpg',
                        'style3' =>  'arrow-style-3.jpg',
                        'style4'  => 'arrow-style-preve-next-slide-visible.jpg'
                    ),
                    'default'       => 'style1'
                ),
                'dots_navigation_style'  => array(
                    'name'          => esc_html__( 'Bullet arrows style', 'swiper-slider' ),
                    'field_type'    => 'radio',
                    'options'       => array(
                        'none'   =>  'arrow-style-none.jpg',
                        'style1' =>  'bullets-style-1.jpg',
                        'style2' =>  'bullets-style-2.jpg',
                        'style3' =>  'bullets-style-3.jpg',
                        'style4' =>  'bullets-style-4.jpg',
                    ),
                    'default'       => 'style1'
                ),
                'control_autoplay'  => array(
                    'name'          => esc_html__( 'Autoplay', 'swiper-slider' ),
                    'field_type'    => 'switch',
                    'default'       => true,
                    'description'   => esc_html__( 'Enable or disable autoplay functionality.', 'swiper-slider' ),
                ),
                'autoplay_timing'   => array(
                    'name'          => esc_html__( 'Autoplay timing', 'swiper-slider' ),
                    'field_type'    => 'number',
                    'default'       => 3000,
                    'description'   => esc_html__( 'Enter autoplay speed in milliseconds (e.g., 3000 for 3 seconds).', 'swiper-slider' ),
                ),
                'control_autoplay_progress'   => array(
                    'name'          => esc_html__( 'Autoplay progress', 'swiper-slider' ),
                    'field_type'    => 'switch',
                    'default'       => false,
                    'description'   => esc_html__( 'Show a progress bar while autoplay is running.', 'swiper-slider' )
                ),
                'progress_bar_color' => array(
                    'name'        => esc_html__( 'Progress bar color', 'swiper-slider' ),
                    'field_type'  => 'color',
                    'default'     => '#ff0000'
                ),
                'control_lazyload_images'   => array(
                    'name'          => esc_html__( 'Lazy load images', 'swiper-slider' ),  
                    'field_type'    => 'switch',
                    'default'       => true,
                    'description'   => esc_html('Load images only when they are needed.', 'swiper-slider')
                ),
                'control_grab_cursor'   => array(
                    'name'          => esc_html__( 'Grab cursor', 'swiper-slider' ),
                    'field_type'    => 'switch',
                    'default'       => false,
                    'description'   => esc_html__( 'Change the mouse cursor to a hand icon when hovering over the slider.', 'swiper-slider' )
                ),
                'control_enable_responsive'   => array(
                    'name'          => esc_html__( 'Enable Responsive', 'swiper-slider' ),
                    'field_type'    => 'switch',
                    'default'       => true,
                    'description'   => esc_html__( 'Enable responsive layout for different screen sizes (mobile, tablet, desktop).', 'swiper-slider' )
                ),
                'items_in_desktop'  => array(
                    'name'          => esc_html__( 'Items in Standard Desktop', 'swiper-slider' ),
                    'field_type'    => 'number',
                    'default'       => 4,
                    'depends_on'    => 'control_enable_responsive'
                ),
                'items_in_tablet'   => array(
                    'name'          => esc_html__( 'Items in Tablet', 'swiper-slider' ),
                    'field_type'    => 'number',
                    'default'       => 2,
                    'depends_on'    => 'control_enable_responsive'
                ),
                'items_in_mobile'   => array(
                    'name'          => esc_html__( 'Items in Mobile', 'swiper-slider' ),
                    'field_type'    => 'number',
                    'default'       => 1,
                    'depends_on'    => 'control_enable_responsive'
                ),
            ) );
        }

        public function intialize_slideshow_metabox() {
            foreach( $this->screens as $screen_id ) :

                foreach( $this->metaBoxs as $metaBoxID => $metaBox ) :

                    add_meta_box(
                        $metaBoxID,
                        esc_html( $metaBox['name'], 'swiper-slider' ),
                        array( $this, $metaBox['callback'] ),
                        $screen_id,
                        'normal',
                        'high'
                    );
                
                endforeach;

            endforeach;
        } 

        public function genrate_slideshow_metabox( $slideshow ){
            $imageIDs = get_post_meta( $slideshow->ID, 'wpss_slider_image_ids', true );
            $imageIDs = json_decode( $imageIDs, true );

            wpss_get_template(
                'metabox/slides.php',
                array(
                    'metaKey' => 'wpss_slider_image_ids',
                    'imageIDs' => $imageIDs
                )
            );
        }

        public function genrate_slideshow_option_metabox( $slideshow ) {
            $image_ids       = get_post_meta( $slideshow->ID, 'wpss_slider_image_ids', true );
            $slider_options  = get_post_meta( $slideshow->ID, 'wpss_slider_option', true );
            $image_ids       = is_array($image_ids) ? $image_ids : [];
            $slider_options  = is_array($slider_options) ? $slider_options : [];
            $options         = array_merge( $image_ids, $slider_options );

            wpss_get_template(
                'metabox/slider-options.php',
                array(
                    'metaKey' => 'wpss_slider_image_ids',
                    'fields'  => $this->fields,
                    'options' => $options,
                )
            );
        }

        public function save_slideshow_metadata( $slideshow_ID ) {
            if ( ! isset( $_POST['wpss_slideshow_metabox_nonce'] ) | ! 
                wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wpss_slideshow_metabox_nonce'] ) ),
                'wpss_slideshow_metabox_data' 
                )
            ) :
                return;
            endif;

            if ( isset( $_POST['wpss_slider_image_ids'] ) && is_array( $_POST['wpss_slider_image_ids'] ) ) :
                $image_ids = array_map( 'absint', wp_unslash( $_POST['wpss_slider_image_ids'] ) ); 
                update_post_meta( $slideshow_ID, 'wpss_slider_image_ids', wp_json_encode( $image_ids ) );
            endif;

            if ( isset( $_POST['wpss_slider_option'] ) && is_array( $_POST['wpss_slider_option'] ) ) :
                $slider_options = array_map( 'sanitize_text_field', wp_unslash( $_POST['wpss_slider_option'] ) );
                update_post_meta( $slideshow_ID, 'wpss_slider_option', $slider_options );
            endif;

            return $slideshow_ID;
        }



    }
    new WPSS_slider_init();
endif;