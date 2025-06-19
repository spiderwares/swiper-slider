<?php
/**
 * Manage slider post type
 */


if( ! class_exists( 'WPK_slider_manage' ) ) :

    class WPK_slider_manage {

        function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_action( 'init', [ __CLASS__, 'register_post_type' ], 10 );
            add_action( 'admin_enqueue_scripts', [ $this, 'include_admin_assets' ], 10 );

            add_action( 'after_setup_theme', [ $this, 'genrate_slider_thumbnail_after_setup_theme' ], 10 );
            add_filter( 'image_size_names_choose', [ $this, 'add_slider_thumbnail_for_js_response' ], 10, 1 );
        }

        public function include_admin_assets() {
            $screen = get_current_screen();
            if( $screen->post_type == 'wpk_slider' ) :
                wp_enqueue_script( 'jquery-ui-core' );
                wp_enqueue_script( 'jquery-ui-widget' );
                wp_enqueue_script( 'jquery-ui-sortable' );

                if ( ! did_action( 'wp_enqueue_media' ) )
                    wp_enqueue_media();

                wp_enqueue_script( 'wpk-admin-core-admin-functions', WPK_SIMPLE_SLIDER_URL . 'assets/js/wpk-core-admin-functions.js', array(), WPK_SIMPLE_SLIDER_VERSION, true );
                wp_enqueue_style( 'wpk-admin-core-style', WPK_SIMPLE_SLIDER_URL . 'assets/css/wpk-admin-core-style.css', array(), WPK_SIMPLE_SLIDER_VERSION );
            endif;            
        }

        public function genrate_slider_thumbnail_after_setup_theme() {
            add_image_size( 'wpk_slider_thumbnail', 250, 130, true );
            add_theme_support( 'editor-styles' );
            add_theme_support( 'align-wide' );
        }

        public function add_slider_thumbnail_for_js_response( $sizes ) {
			$sizes['wpk_slider_thumbnail'] = __( 'WPK slider Thumbnail' );
            return $sizes;
        }
        
        public static function register_post_type() {
            $args = array(
                'label'               => esc_html__( 'WPK Slider', 'wpk-simple-slider' ),
                'labels'              => esc_html__( 'WPK Sliders', 'wpk-simple-slider' ),
                'supports'            => array( 'title', 'thumbnail' ),
                'hierarchical'        => true,
                'public'              => true,
                'show_ui'             => true,
                'show_in_rest'        => true,
                'show_in_menu'        => true,
                'menu_position'       => 10,
                'menu_icon'           => 'dashicons-slides',
                'show_in_admin_bar'   => false,
                'show_in_nav_menus'   => false,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'capability_type'     => 'page',
            );
            register_post_type( 'wpk_slider', $args );
        }

    }
    new WPK_slider_manage();
endif;