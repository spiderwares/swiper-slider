<?php
/**
 * Manage slider post type
 */


if( ! class_exists( 'WPSS_Slider_Manage' ) ) :

    class WPSS_Slider_Manage {

        public function __construct() {
            $this->event_handler();
        }

        public function event_handler() {
            add_action( 'init', [ __CLASS__, 'register_post_type' ], 10 );
            add_action( 'admin_enqueue_scripts', [ $this, 'include_admin_assets' ], 10 );

            add_action( 'after_setup_theme', [ $this, 'genrate_slider_thumbnail_after_setup_theme' ], 10 );
            add_filter( 'image_size_names_choose', [ $this, 'add_slider_thumbnail_for_js_response' ], 10, 1 );

            add_filter( 'manage_wpss_slider_posts_columns', [ $this, 'add_shortcode_column' ] );
            add_action( 'manage_wpss_slider_posts_custom_column', [ $this, 'render_shortcode_column' ], 10, 2 );
            add_action( 'admin_menu', [ $this, 'shortcode_add_metabox' ] );
        }

        public function shortcode_add_metabox() {
            add_meta_box(
                'wpss_slider_shortcode_metabox',
                'Slider Shortcode',
                [$this, 'shortcode_metabox_callback'],
                'wpss_slider',
                'side', // position (normal, side, advanced)
                'high' // priority (default, low, high, core)
            );
        }

        public function shortcode_metabox_callback( $post ) {
            printf( 
                '<p>Use the following shortcode to display the slider</p><hr><code>[wpss_simple_slider id="%d"]</code>', 
                $post->ID 
            );
        }


        public function include_admin_assets() {
            $screen = get_current_screen();
            if( $screen->post_type == 'wpss_slider' ) :
                wp_enqueue_script( 'jquery-ui-core' );
                wp_enqueue_script( 'jquery-ui-widget' );
                wp_enqueue_script( 'jquery-ui-sortable' );

                if ( ! did_action( 'wp_enqueue_media' ) )
                    wp_enqueue_media();

                wp_enqueue_script( 
                    'wpss-admin-core-admin-functions', 
                    WPSS_URL . 'assets/js/wpss-core-admin-functions.js', 
                    array(), 
                    WPSS_VERSION, 
                    true 
                );
                wp_enqueue_style( '
                    wpss-admin-core-style', 
                    WPSS_URL . 'assets/css/wpss-admin-core-style.css', 
                    array(), 
                    WPSS_VERSION
                );

                 wp_enqueue_script(
                    'wpss-slider-admin',
                    WPSS_URL . 'assets/js/wpss-slider-admin.js',
                    ['jquery'],
                    WPSS_VERSION,
                    true
                );
            endif;            
        }

        public function add_shortcode_column( $columns ) {
            $new_columns = [];

            foreach ( $columns as $key => $value ) :
                $new_columns[ $key ] = $value;

                if ( $key === 'title' ) :
                    $new_columns['wpss_shortcode'] = esc_html__( 'Shortcode', 'wpss-simple-slider' );
                endif;
            endforeach;

            return $new_columns;
        }

        public function render_shortcode_column( $column, $post_id ) {
            if ( $column === 'wpss_shortcode' ) :
                printf( '<code>[wpss_simple_slider id="%d"]</code>', $post_id );
            endif;
        }

        public function genrate_slider_thumbnail_after_setup_theme() {
            add_image_size( 'wpss_slider_thumbnail', 250, 130, true );
            add_theme_support( 'editor-styles' );
            add_theme_support( 'align-wide' );
        }

        public function add_slider_thumbnail_for_js_response( $sizes ) {
			$sizes['wpss_slider_thumbnail'] = esc_html__( 'WPSS slider Thumbnail' );
            return $sizes;
        }
        
        public static function register_post_type() {
            $args = array(
                'label'               => esc_html__( 'Simple Slider', 'wpss-simple-slider' ),
                'labels'              => esc_html__( 'Sliders', 'wpss-simple-slider' ),
                'supports'            => array( 'title' ),
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
            register_post_type( 'wpss_slider', $args );
        }

    }
    new WPSS_Slider_Manage();
endif;