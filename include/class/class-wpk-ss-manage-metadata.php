<?php 
/**
 * Metabox handling class
 */

if( ! class_exists( 'WPK_slider_init' ) ) :

    class WPK_slider_init {
        private $screens;
        private $metaKey;
        private $metaBoxs;
        private $fields;

        public $defaultOptions;

        function __construct() {
            $this->default_Options();
            $this->event_handler();
        }

        public function event_handler(){
            add_action( 'add_meta_boxes', [ $this, 'intialize_slideshow_metabox' ], 10 );
            add_action( 'save_post', [ $this, 'save_slideshow_metadata' ] );
        }

        public function default_Options(){
            $this->metaKey = 'wpk_slider_image_ids';
            $this->screens = array( 'wpk_slider'  );
            $this->metaBoxs = array(
                'wpk-slideshow-metabox'     => array(
                    'name'      =>  'Slides',
                    'callback'  =>  'genrate_slideshow_metabox',
                ),
                'wpk-slideshow-options-metabox'     => array(
                    'name'      =>  'Slider Options',
                    'callback'  =>  'genrate_slideshow_option_metabox',
                )
            );

            $this->fields = array(
                'wpk_slider_animation'  => array(
                    'name'          => __( 'Transition type', 'wpk-simple-slider' ),
                    'field_type'    => 'radioImg',
                    'options'       => array(
                        'slide' =>  'animation-type-slide.gif',
                        'fade'  =>  'animation-type-fade.gif'
                    ),
                    'default'       => 'slide'
                ),
                'wpk_slider_navigation_arrow_style' => array(
                    'name'          => __( 'Navigation arrows style', 'wpk-simple-slider' ),
                    'field_type'    => 'radioImg',
                    'options'       => array(
                        'none'   =>  'arrow-style-none.jpg',
                        'style1' =>  'arrow-style-1.jpg',
                        'style2' =>  'arrow-style-2.jpg',
                        'style3' =>  'arrow-style-3.jpg',
                        'prev_next_slides'  => 'arrow-style-preve-next-slide-visible.jpg'
                    ),
                    'default'       => 'style1'
                ),
                'wpk_slider_dots_navigation_style'  => array(
                    'name'          => __( 'Bullet arrows style', 'wpk-simple-slider' ),
                    'field_type'    => 'radioImg',
                    'options'       => array(
                        'none'   =>  'arrow-style-none.jpg',
                        'style1' =>  'bullets-style-1.jpg',
                        'style2' =>  'bullets-style-2.jpg',
                        'style3' =>  'bullets-style-3.jpg',
                        'style4' =>  'bullets-style-4.jpg',
                    ),
                    'default'       => 'style1'
                ),
                'wpk_slider_control_autoplay'   => array(
                    'name'          => __( 'Autoplay', 'wpk-simple-slider' ),
                    'field_type'    => 'switch',
                    'default'       => true
                ),
                'wpk_slider_autoplay_timing'   => array(
                    'name'          => __( 'Autoplay timing', 'wpk-simple-slider' ),
                    'field_type'    => 'range',
                    'default'       => 3000
                ),
                'wpk_slider_control_autoplay_progress'   => array(
                    'name'          => __( 'Autoplay progress', 'wpk-simple-slider' ),
                    'field_type'    => 'switch',
                    'default'       => true
                ),
                'wpk_slider_control_lazyload_images'   => array(
                    'name'          => __( 'Lazy load images', 'wpk-simple-slider' ),
                    'field_type'    => 'switch',
                    'default'       => true
                ),
                'wpk_slider_control_grab_cursor'   => array(
                    'name'          => __( 'Grab cursor', 'wpk-simple-slider' ),
                    'field_type'    => 'switch',
                    'default'       => false
                ),
            );
        }

        public function intialize_slideshow_metabox() {
            foreach( $this->screens as $screen_id ) :

                foreach( $this->metaBoxs as $metaBoxID => $metaBox ) :

                    add_meta_box(
                        $metaBoxID,
                        esc_html__( $metaBox['name'], 'wpk-simple-slider' ),
                        array( $this, $metaBox['callback'] ),
                        $screen_id,
                        'normal',
                        'high'
                    );
                
                endforeach;

            endforeach;
        }

        

        public function genrate_slideshow_metabox( $slideshow ){
            $imageIDs = get_post_meta( $slideshow->ID, 'wpk_slider_image_ids', true );
            $imageIDs = json_decode( $imageIDs, true );

            $images = get_posts( 
                array(
                    'post_type'      => 'attachment',
                    'orderby'        => 'post__in',
                    'order'          => 'ASC',
                    'post__in'       => $imageIDs,
                    'numberposts'    => -1,
                    'post_mime_type' => 'image'
                ) 
            );

            wpk_get_temlpate(
                'metabox/slides.php',
                array(
                    'metaKey' => 'wpk_slider_image_ids',
                    'imageIDs' => $imageIDs,
                    'images'   => $images
                )
            );
        }

        public function genrate_slideshow_option_metabox( $slideshow ){
            $options = get_post_meta( $slideshow->ID, 'wpk_slider_image_ids', true );

            wpk_get_temlpate(
                'metabox/slider-options.php',
                array(
                    'metaKey'       => 'wpk_slider_image_ids',
                    'fields'        => $this->fields,
                    'options'       => $options,
                )
            );
        }

        public function save_slideshow_metadata( $slideshow_ID ){
            if ( ! isset( $_POST['wpk_slider_metabox_nonce'] ) || empty( $slideshow_ID ) ) :
                return;
            endif;

            update_post_meta( $slideshow_ID, 'wpk_slider_image_ids', json_encode( $_POST['wpk_slider_image_ids'] ) );
            return $slideshow_ID;
        }


    }
    new WPK_slider_init();
endif;