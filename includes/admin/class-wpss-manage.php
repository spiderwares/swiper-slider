<?php
/**
 * Manage slider post type
 */

if ( ! defined( 'ABSPATH' ) ) exit;

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
                'side', 
                'high'
            );
        }

        public function shortcode_metabox_callback( $post ) {
            printf( 
                '<p>%s</p><hr><code>[wpss_slider id="%d"]</code>', 
                esc_html__( 'Use the following shortcode to display the slider', 'swiper-slider' ), 
                esc_attr( $post->ID ) 
            );
        }

        public function include_admin_assets() {
            $screen = get_current_screen();
            if( $screen->post_type == 'wpss_slider' ) :
                wp_enqueue_script( 'jquery-ui-core' );
                wp_enqueue_script( 'jquery-ui-widget' );
                wp_enqueue_script( 'jquery-ui-sortable' );
                wp_enqueue_style( 'wp-color-picker' );
                wp_enqueue_script( 'wp-color-picker' );

                wp_enqueue_script( 
                    'wp-color-picker-alpha', 
                    WPSS_URL . 'assets/js/wp-color-picker-alpha.js', 
                    array('jquery', 'wp-color-picker'), 
                    WPSS_VERSION,
                    true
                );

                if ( ! did_action( 'wp_enqueue_media' ) )
                    wp_enqueue_media();

                wp_enqueue_script( 
                    'wpss-admin-core', 
                    WPSS_URL . 'assets/js/wpss-admin-core.js', 
                    array('jquery', 'media-editor', 'media-views', 'wp-color-picker-alpha'), 
                    WPSS_VERSION,
                    true
                );

                wp_enqueue_style( '
                    wpss-admin-core-style', 
                    WPSS_URL . 'assets/css/wpss-admin-core-style.css', 
                    array(), 
                    WPSS_VERSION
                );
            endif;            
        }

        public function add_shortcode_column( $columns ) {
            $new_columns = [];

            foreach ( $columns as $key => $value ) :
                $new_columns[ $key ] = $value;

                if ( $key === 'title' ) :
                    $new_columns['wpss_shortcode'] = esc_html__( 'Shortcode', 'swiper-slider' );
                endif;
            endforeach;

            return $new_columns;
        }

        public function render_shortcode_column( $column, $post_id ) {
            if ( $column === 'wpss_shortcode' ) :
                printf( '<code>[wpss_slider id="%d"]</code>', 
                esc_attr( $post_id ) 
            );
            endif;
        }

        public function genrate_slider_thumbnail_after_setup_theme() {
            add_image_size( 'wpss_slider_thumbnail', 250, 130, true );
            add_theme_support( 'editor-styles' );
            add_theme_support( 'align-wide' );
        }

        public function add_slider_thumbnail_for_js_response( $sizes ) {
			$sizes['wpss_slider_thumbnail'] = esc_html__( 'WPSS slider Thumbnail', 'swiper-slider' );
            return $sizes;
        }

        public static function register_post_type() {
            $labels = array(
                'name'               => esc_html__( 'Sliders', 'swiper-slider' ),
                'singular_name'      => esc_html__( 'Slider', 'swiper-slider' ),
                'menu_name'          => esc_html__( 'Swiper Slider', 'swiper-slider' ),
                'name_admin_bar'     => esc_html__( 'Slider', 'swiper-slider' ),
                'add_new_item'       => esc_html__( 'Add Slider', 'swiper-slider' ),
                'new_item'           => esc_html__( 'New Slider', 'swiper-slider' ),
                'edit_item'          => esc_html__( 'Edit Slider', 'swiper-slider' ),
                'view_item'          => esc_html__( 'View Slider', 'swiper-slider' ),
                'all_items'          => esc_html__( 'Swiper Slider', 'swiper-slider' ),
                'search_items'       => esc_html__( 'Search Sliders', 'swiper-slider' ),
                'parent_item_colon'  => esc_html__( 'Parent Sliders:', 'swiper-slider' ),
                'not_found'          => esc_html__( 'No sliders found.', 'swiper-slider' ),
                'not_found_in_trash' => esc_html__( 'No sliders found in Trash.', 'swiper-slider' ),
            );

            $args = array(
                'label'               => esc_html__( 'Swiper Slider', 'swiper-slider' ),
                'labels'              => $labels,
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