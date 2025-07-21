<?php 
/**
 * Metabox handling class
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'WPSS_Manage_Metadata' ) ) :

    class WPSS_Manage_Metadata {
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
            $this->metaKey  = 'wpss_slider_image_ids';
            $this->screens  = array( 'wpss_slider'  );
            $this->metaBoxs = array(
                'wpss-slideshow-metabox'     => array(
                    'name'      =>  'Slides',
                    'callback'  =>  'genrate_slideshow_metabox',
                ),
                'wpss-slideshow-options-metabox'    => array(
                    'name'      =>  'Slider Options',
                    'callback'  =>  'genrate_slideshow_option_metabox',
                ),
            );

            $this->fields = array(
                'animation'  => array(
                    'name'          => esc_html__( 'Transition type', 'swiper-slider' ),
                    'field_type'    => 'radio',
                    'options'       => array(
                        'slide'             =>  'animation-slide.gif',
                        'fade'              =>  'animation-fade.gif',
                        'flip'              =>  'animation-flip.gif',
                        'cube'              =>  'animation-cube.gif',
                        'cards (pro)'       =>  'animation-cards.gif',
                        'coverflow (pro)'   =>  'animation-coverflow.gif',
                        'shadow push (pro)' =>  'animation-creative1.gif',
                        'zoom split (pro)'  =>  'animation-creative2.gif',
                        'slide flow(pro)' =>  'animation-creative3.gif',
                        'flip deck (pro)'   =>  'animation-creative4.gif',
                        'twist flow (pro)'  =>  'animation-creative5.gif',
                        'mirror (pro)'     =>  'animation-creative6.gif',
                    ),
                    'disabled_options' => array( 
                        'cards (pro)', 
                        'coverflow (pro)', 
                        'shadow push (pro)', 
                        'zoom split (pro)', 
                        'slide flow(pro)', 
                        'flip deck (pro)', 
                        'twist flow (pro)', 
                        'mirror (pro)'
                    ),
                    'default'       => 'slide',
                    'data_hide'     => '.wpss-coverflow-options, .wpss-cube-options, .wpss-cards-options',
                    'data_show_map' => array(
                        'cards'      => '.wpss-cards-options',
                        'cube'      => '.wpss-cube-options',
                        'coverflow' => '.wpss-coverflow-options',
                    ),
                ),
                'cards_border' => array(
                    'name'        => esc_html__('Border Radius', 'swiper-slider'),
                    'field_type'  => 'number',
                    'default'     => 20,
                    'class'       => 'wpss-cards-options',
                    'description' => esc_html__('Border radius cards in px.', 'swiper-slider'),
                ),
                'cube_shadows' => array(
                    'name'        => esc_html__('Shadows', 'swiper-slider'),
                    'field_type'  => 'switch',
                    'default'     => true,
                    'class'       => 'wpss-cube-options',
                    'description' => esc_html__('Enable shadows.', 'swiper-slider'),
                ),
                'cube_slide_shadows' => array(
                    'name'        => esc_html__('Slide Shadows', 'swiper-slider'),
                    'field_type'  => 'switch',
                    'default'     => true,
                    'class'       => 'wpss-cube-options',
                    'description' => esc_html__('Enable slide shadows.', 'swiper-slider'),
                ),
                'cube_shadowoffset' => array(
                    'name'        => esc_html__('Shadow Offset', 'swiper-slider'),
                    'field_type'  => 'number',
                    'default'     => 20,
                    'class'       => 'wpss-cube-options',
                    'description' => esc_html__('Shadow Offset in slides.', 'swiper-slider'),
                ),
                'cube_shadowScale' => array(
                    'name'        => esc_html__('Shadow Scale', 'swiper-slider'),
                    'field_type'  => 'number',
                    'default'     => 0.94,
                    'class'       => 'wpss-cube-options',
                    'description' => esc_html__('Shadow Scale in slides.', 'swiper-slider'),
                ),

                'coverflow_rotate' => array(
                    'name'        => esc_html__('Rotate', 'swiper-slider'),
                    'field_type'  => 'number',
                    'default'     => 50,
                    'class'       => 'wpss-coverflow-options',
                    'description' => esc_html__('Rotation angle for coverflow.', 'swiper-slider'),
                ),
                'coverflow_stretch' => array(
                    'name'        => esc_html__('Stretch', 'swiper-slider'),
                    'field_type'  => 'number',
                    'default'     => 0,
                    'class'       => 'wpss-coverflow-options',
                    'description' => esc_html__('Space between slides.', 'swiper-slider'),
                ),
                'coverflow_depth' => array(
                    'name'        => esc_html__('Depth', 'swiper-slider'),
                    'field_type'  => 'number',
                    'default'     => 100,
                    'class'       => 'wpss-coverflow-options',
                    'description' => esc_html__('Depth offset.', 'swiper-slider'),
                ),
                'coverflow_modifier' => array(
                    'name'        => esc_html__('Modifier', 'swiper-slider'),
                    'field_type'  => 'number',
                    'default'     => 1,
                    'class'       => 'wpss-coverflow-options',
                    'description' => esc_html__('Effect multiplier.', 'swiper-slider'),
                ),
                'coverflow_shadows' => array(
                    'name'        => esc_html__('Slide Shadows', 'swiper-slider'),
                    'field_type'  => 'switch',
                    'default'     => true,
                    'class'       => 'wpss-coverflow-options',
                    'description' => esc_html__('Enable slide shadows.', 'swiper-slider'),
                ),
                'navigation_arrow_style' => array(
                    'name'          => esc_html__( 'Navigation arrows style', 'swiper-slider' ),
                    'field_type'    => 'radio',
                    'options'       => array(
                        'none'   => 'arrow-style-none.jpg',
                        'style1' => 'arrow-style-1.jpg',
                        'style2' => 'arrow-style-2.jpg',
                        'style3' => 'arrow-style-preve-next-slide-visible.jpg',
                        'style4' => 'arrow-style-4.png',
                        'style5 (pro)' => 'arrow-style-5.jpg',
                        'custom (pro)' => 'arrow-custom.jpg',
                    ),
                    'disabled_options' => array( 
                        'style5 (pro)',
                        'custom (pro)', 
                    ),
                    'default'       => 'style1',
                    'data_hide'     => '.wpss-arrow-color, .wpss-arrow-hover-color, .wpss-arrow-colors, .wpss-arrow-border-color, .wpss-arrow-position, .wpss-arrow-font-size, .wpss-arrow-border-radius',
                    'data_show_map' => array(
                        'style1' => '.wpss-arrow-color, .wpss-arrow-hover-color, .wpss-arrow-font-size',
                        'style2' => '.wpss-arrow-colors, .wpss-arrow-color, .wpss-arrow-hover-color, .wpss-arrow-border-color, .wpss-arrow-font-size, .wpss-arrow-border-radius',
                        'style3' => '.wpss-arrow-colors, .wpss-arrow-color, .wpss-arrow-hover-color, .wpss-arrow-border-color, .wpss-arrow-font-size',
                        'style4' => '.wpss-arrow-colors, .wpss-arrow-color, .wpss-arrow-hover-color, .wpss-arrow-border-color, .wpss-arrow-font-size, .wpss-arrow-border-radius',
                        'style5' => '.wpss-arrow-color, .wpss-arrow-hover-color, .wpss-arrow-font-size',
                        'custom' => '.wpss-arrow-color, .wpss-arrow-hover-color, .wpss-arrow-border-color, .wpss-arrow-position, .wpss-arrow-font-size, .wpss-arrow-border-radius',
                    ),
                ),
                'arrow_font_size' => array(
                    'name'        => esc_html__( 'Arrow Font Size', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 16,
                    'class'       => 'wpss-arrow-font-size',
                    'description' => esc_html__( 'Set font size for arrow icon in px.', 'swiper-slider' ),
                ),
                'arrow_border_radius' => array(
                    'name'        => esc_html__( 'Arrow Border Radius', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 50,
                    'class'       => 'wpss-arrow-border-radius',
                    'description' => esc_html__( 'Set border radius for arrow border in %.', 'swiper-slider' ),
                ),
                'arrow_position_unit' => array(
                    'name'        => esc_html__( 'Arrow Position Unit', 'swiper-slider' ),
                    'field_type'  => 'select',
                    'options'     => array(
                        'px'  => 'px',
                        '%'   => '%',
                        'em'  => 'em',
                        'rem' => 'rem',
                    ),
                    'default'     => 'px',
                    'class'       => 'wpss-arrow-position',
                ),
                'arrow_position_top' => array(
                    'name'        => esc_html__( 'Arrow Top Position', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 220,
                    'description' => esc_html__( 'Distance from the top. Leave bottom blank if this is set.', 'swiper-slider' ),
                    'class'       => 'wpss-arrow-position',
                ),
                'arrow_position_bottom' => array(
                    'name'        => esc_html__( 'Arrow Bottom Position', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => '',
                    'description' => esc_html__( 'Distance from the bottom. Leave top blank if this is set.', 'swiper-slider' ),
                    'class'       => 'wpss-arrow-position',
                ),
                'arrow_position_left' => array(
                    'name'        => esc_html__( 'Arrow Left Position', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 10,
                    'description' => esc_html__( 'Distance from the left.', 'swiper-slider' ),
                    'class'       => 'wpss-arrow-position',
                ),
                'arrow_position_right' => array(
                    'name'        => esc_html__( 'Arrow Right Position', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 10,
                    'description' => esc_html__( 'Distance from the right.', 'swiper-slider' ),
                    'class'       => 'wpss-arrow-position',
                ),
                'arrow_color' => array(
                    'name'        => esc_html__( 'Arrow Color', 'swiper-slider' ),
                    'field_type'  => 'color', 
                    'default'     => '#ffffff',
                    'class'       => 'wpss-arrow-color',
                ),
                'arrow_bg_color' => array(
                    'name'        => esc_html__( 'Arrow Background Color', 'swiper-slider' ),
                    'field_type'  => 'color',
                    'default'     => '#000000',
                    'class'       => 'wpss-arrow-colors',
                ),
                'arrow_hover_color' => array(
                    'name'        => esc_html__( 'Arrow Hover Color', 'swiper-slider' ),
                    'field_type'  => 'color',
                    'default'     => '#ffffff',
                    'class'       => 'wpss-arrow-hover-color',
                ),
                'arrow_hover_bg_color' => array(
                    'name'        => esc_html__( 'Arrow Hover Background Color', 'swiper-slider' ),
                    'field_type'  => 'color',
                    'default'     => '#333333',
                    'class'       => 'wpss-arrow-colors',
                ),
                'arrow_border_color' => array(
                    'name'        => esc_html__( 'Arrow Border Color', 'swiper-slider' ),
                    'field_type'  => 'color',
                    'default'     => '#ffffff',
                    'class'       => 'wpss-arrow-border-color',
                ),
                'image_unit' => array(
                    'name'        => esc_html__( 'Set Width & Height', 'swiper-slider' ),
                    'field_type'  => 'select',
                    'options'     => array(
                        'px'  => 'px',
                        '%'   => '%',
                        'em'  => 'em',
                        'rem' => 'rem',
                        'vh'  => 'vh',
                    ),
                    'default'     => 'px',
                    'description' => esc_html__( 'Unit to use for image width and height (e.g., px, %, em). Applied to each slide image.', 'swiper-slider' ),
                ),
                'width_image'   => array(
                    'name'        => esc_html__( 'Width of Image', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 700,
                    'description' =>  esc_html__( 'Specify the width of each slide image.', 'swiper-slider' ),
                ),
                'height_image'   => array(
                    'name'        => esc_html__( 'Height of Image', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 400,
                    'description' =>  esc_html__( 'Specify the height of each slide image.', 'swiper-slider' ),
                ),
                'pagination_type' => array(
                    'name'        => esc_html__( 'Pagination Type', 'swiper-slider' ),
                    'field_type'  => 'select',
                    'options'     => array(
                        'none'        => esc_html__( 'None', 'swiper-slider' ),
                        'bullets'     => esc_html__( 'Bullets', 'swiper-slider' ),
                        'progressbar' => esc_html__( 'Progress Bar', 'swiper-slider' ),
                        'fraction'    => esc_html__( 'Fraction', 'swiper-slider' ),
                        'custom'      => esc_html__( 'Custom', 'swiper-slider' ),
                    ),
                    'disabled_options' => array( 'fraction' , 'custom' ),
                    'default'       => 'bullets',
                    'description'   => esc_html__( 'Choose the type of pagination for the slider.', 'swiper-slider' ),
                    'data_hide'     => '.wpss-bullet-style, .wpss-autoplay-progress, .wpss-progress-bar, .wpss-fraction-style, .wpss-custom-style, .wpss-bullets-bg-color, .wpss-bullets-hover-bg-color, .wpss-bullets-border-color',
                    'data_show_map' => array(
                        'bullets'     => '.wpss-bullet-style, .wpss-bullets-bg-color, .wpss-bullets-hover-bg-color, .wpss-bullets-border-color',
                        'progressbar' => '.wpss-autoplay-progress, .wpss-progress-bar',
                        'fraction'    => '.wpss-fraction-style',
                        'custom'      => '.wpss-custom-style',
                    ),
                ),
                'bullets_navigation_style'  => array(
                    'name'          => esc_html__( 'Bullet style', 'swiper-slider' ),
                    'field_type'    => 'radio',
                    'options'       => array(
                        'style1' =>  'bullets-style-1.jpg',
                        'style2' =>  'bullets-style-2.jpg',
                        'style3' =>  'bullets-style-3.jpg',
                        'style4' =>  'bullets-style-4.jpg',
                    ),
                    'default'       => 'style1',
                    'class'         => 'wpss-bullet-style',
                ),
                'bullets_bg_color' => array(
                    'name'        => esc_html__( 'Bullet Background Color', 'swiper-slider' ),
                    'field_type'  => 'color',
                    'default'     => '',
                    'class'       => 'wpss-bullets-bg-color',
                ),
                'bullets_hover_bg_color' => array(
                    'name'        => esc_html__( 'Bullet Hover Background Color', 'swiper-slider' ),
                    'field_type'  => 'color',
                    'default'     => '#ffffff',
                    'class'       => 'wpss-bullets-hover-bg-color',
                ),
                'bullets_border_color' => array(
                    'name'        => esc_html__( 'Bullet Border Color', 'swiper-slider' ),
                    'field_type'  => 'color',
                    'default'     => '#ffffff',
                    'class'       => 'wpss-bullets-border-color',
                ),
                'control_autoplay_progress'   => array(
                    'name'          => esc_html__( 'Autoplay progress', 'swiper-slider' ),
                    'field_type'    => 'switch',
                    'default'       => false,
                    'description'   => esc_html__( 'Show a progress bar while autoplay is running.', 'swiper-slider' ),
                    'data_show'     => '.wpss-progress-bar',
                    'class'         => 'wpss-autoplay-progress',
                ),
                'progress_bar_position' => array(
                    'name'          => esc_html__( 'Progress Bar Position', 'swiper-slider' ),
                    'field_type'    => 'select',
                    'options'       => array(
                        'bottom'    => esc_html__( 'Bottom (Use in Horizontal)', 'swiper-slider' ),
                        'top'       => esc_html__( 'Top (Use in Horizontal)', 'swiper-slider' ),
                        'left'      => esc_html__( 'Left (Use in Vertical)', 'swiper-slider' ),
                        'right'     => esc_html__( 'Right (Use in Vertical)', 'swiper-slider' ),
                    ),
                    'default'       => 'bottom',
                    'description'   => esc_html__( 'Choose where to position the autoplay progress bar.', 'swiper-slider' ),
                    'class'         => 'wpss-progress-bar',
                    'disabled_options' => array('right','left'),
                ),
                'progress_bar_color' => array(
                    'name'          => esc_html__( 'Progress bar color', 'swiper-slider' ),
                    'field_type'    => 'color',
                    'default'       => '#ff0000',
                    'class'         => 'wpss-progress-bar',
                ),
                'fraction_navigation_style'  => array(
                    'name'        => esc_html__( 'Fraction style', 'swiper-slider' ),
                    'field_type'  => 'radio',
                    'options'     => array(
                        'style1'  => 'bullets-fraction.png',
                    ),
                    'default'     => 'style1',
                    'class'       => 'wpss-fraction-style',
                ),
                'fraction_color' => array(
                    'name'          => esc_html__( 'Fraction color', 'swiper-slider' ),
                    'field_type'    => 'color',
                    'default'       => '#ff0000',
                    'class'         => 'wpss-fraction-style',
                ),
                'fraction_font_size' => array(
                    'name'        => esc_html__( 'Fraction Font Size (px)', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 16,
                    'class'       => 'wpss-fraction-style',
                    'description' => esc_html__( 'Set the font size for the fraction pagination.', 'swiper-slider' ),
                ),
                'fraction_position' => array(
                    'name'        => esc_html__( 'Fraction Position', 'swiper-slider' ),
                    'field_type'  => 'select',
                    'default'     => 'center',
                    'options'     => array(
                        'top-left'     => esc_html__( 'Top Left', 'swiper-slider' ),
                        'top-right'    => esc_html__( 'Top Right', 'swiper-slider' ),
                        'bottom-left'  => esc_html__( 'Bottom Left', 'swiper-slider' ),
                        'bottom-right' => esc_html__( 'Bottom Right', 'swiper-slider' ),
                        'center'   => esc_html__( 'Center', 'swiper-slider' ),
                    ),
                    'description' => esc_html__( 'Choose position for fraction in pagination.', 'swiper-slider' ),
                    'class'       => 'wpss-fraction-style',
                ),
                'custom_navigation_style'  => array(
                    'name'        => esc_html__( 'Custom style', 'swiper-slider' ),
                    'field_type'  => 'radio',
                    'options'     => array(
                        'style1'  => 'custom-style1.jpg',
                    ),
                    'default'     => 'style1',
                    'class'       => 'wpss-custom-style',
                ),
               'custom_text_color' => array(
                    'name'          => esc_html__( 'Custom Color', 'swiper-slider' ),
                    'field_type'    => 'color',
                    'default'       => '#ffffff',
                    'class'         => 'wpss-custom-style',
                    'description'   => esc_html__( 'Set the text color for numbered pagination bullets.', 'swiper-slider' ),
                ),
                'custom_background_color' => array(
                    'name'          => esc_html__( 'Custom Background Color', 'swiper-slider' ),
                    'field_type'    => 'color',
                    'default'       => '#007aff',
                    'class'         => 'wpss-custom-style',
                    'description'   => esc_html__( 'Set the background color for active pagination bullets.', 'swiper-slider' ),
                ),
               'custom_active_text_color' => array(
                    'name'          => esc_html__( 'Custom active Text Color', 'swiper-slider' ),
                    'field_type'    => 'color',
                    'default'       => '#ffffff',
                    'class'         => 'wpss-custom-style',
                    'description'   => esc_html__( 'Set the text color for inactive numbered pagination bullets.', 'swiper-slider' ),
                ),
                'custom_active_background_color' => array(
                    'name'          => esc_html__( 'Custom active Background Color', 'swiper-slider' ),
                    'field_type'    => 'color',
                    'default'       => '#0a0607',
                    'class'         => 'wpss-custom-style',
                    'description'   => esc_html__( 'Set the background color for inactive pagination bullets.', 'swiper-slider' ),
                ),
                'control_autoplay_progress'   => array(
                    'name'          => esc_html__( 'Autoplay progress', 'swiper-slider' ),
                    'field_type'    => 'switch',
                    'default'       => false,
                    'description'   => esc_html__( 'Show a progress bar while autoplay is running.', 'swiper-slider' ),
                    'data_show'     => '.wpss-progress-bar',
                    'class'         => 'wpss-autoplay-progress',
                ),
                'progress_bar_position' => array(
                    'name'          => esc_html__( 'Progress Bar Position', 'swiper-slider' ),
                    'field_type'    => 'select',
                    'options'       => array(
                        'bottom'    => esc_html__( 'Bottom (Use in Horizontal)', 'swiper-slider' ),
                        'top'       => esc_html__( 'Top (Use in Horizontal)', 'swiper-slider' ),
                        'left'      => esc_html__( 'Left (Use in Vertical)', 'swiper-slider' ),
                        'right'     => esc_html__( 'Right (Use in Vertical)', 'swiper-slider' ),
                    ),
                    'default'       => 'bottom',
                    'description'   => esc_html__( 'Choose where to position the autoplay progress bar.', 'swiper-slider' ),
                    'class'         => 'wpss-progress-bar',
                    'disabled_options' => array('right','left'),
                ),
                'progress_bar_color' => array(
                    'name'          => esc_html__( 'Progress bar color', 'swiper-slider' ),
                    'field_type'    => 'color',
                    'default'       => '#ff0000',
                    'class'         => 'wpss-progress-bar',
                ),
                'control_slider_vertical' => array(
                    'name'        =>  esc_html__( 'Vertical Slider Control', 'swiper-slider' ),
                    'field_type'  =>  'switch',
                    'default'     =>  false,
                    'pro_version' =>  true,
                    'description' =>  esc_html__( 'Enable vertical direction for the slider.', 'swiper-slider' ),
                ),
                'control_autoplay'  => array(
                    'name'          => esc_html__( 'Autoplay', 'swiper-slider' ),
                    'field_type'    => 'switch',
                    'default'       => true,
                    'description'   => esc_html__( 'Enable or disable autoplay functionality.', 'swiper-slider' ),
                    'data_show'     => '.wpss-autoplay-timing',
                ),
                'autoplay_timing'   => array(
                    'name'          => esc_html__( 'Autoplay timing', 'swiper-slider' ),
                    'field_type'    => 'number',
                    'default'       => 3000,
                    'class'         => 'wpss-autoplay-timing',
                    'description'   => esc_html__( 'Enter autoplay speed in milliseconds (e.g., 3000 for 3 seconds).', 'swiper-slider' ),
                ),
                'control_autoplay_timeleft' => array(
                    'name'        => esc_html__( 'Circular Autoplay Progress', 'swiper-slider' ),
                    'field_type'  => 'switch',
                    'default'     => false,
                    'description' => esc_html__( 'Show circular progress countdown during autoplay (available for all pagination types).', 'swiper-slider' ),
                    'data_show'   => '.wpss-autoplay-timeleft', 
                ),
                'control_autoplay_timeleft_color' => array(
                    'name'        => esc_html__( 'TimeLeft Color', 'swiper-slider' ),
                    'field_type'  => 'color',
                    'default'     => '#007aff',
                    'description' => esc_html__( 'Set color for circular autoplay progress.', 'swiper-slider' ),
                    'class'       => 'wpss-autoplay-timeleft',
                ),
                'control_autoplay_timeleft_position' => array(
                    'name'        => esc_html__( 'Autoplay TimeLeft Position', 'swiper-slider' ),
                    'field_type'  => 'select',
                    'default'     => 'bottom-right',
                    'options'     => array(
                        'top-left'     => esc_html__( 'Top Left', 'swiper-slider' ),
                        'top-right'    => esc_html__( 'Top Right', 'swiper-slider' ),
                        'bottom-left'  => esc_html__( 'Bottom Left', 'swiper-slider' ),
                        'bottom-right' => esc_html__( 'Bottom Right', 'swiper-slider' ),
                    ),
                    'description' => esc_html__( 'Choose position for autoplay time left circle.', 'swiper-slider' ),
                    'class'       => 'wpss-autoplay-timeleft',
                ),
                'control_autoplay_timeleft_font_size' => array(
                    'name'        => esc_html__( 'Time Left Font Size', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 20,
                    'description' => esc_html__( 'Font size for the autoplay time left number (in px).', 'swiper-slider' ),
                    'unit'        => 'px',
                    'class'       => 'wpss-autoplay-timeleft',
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
                    'default'       => false,
                    'description'   => esc_html__( 'Enable responsive layout for different screen sizes (mobile, tablet, desktop).', 'swiper-slider' ),
                    'data_show'     => '.wpss-responsive-field',
                ),
                'items_in_desktop'  => array(
                    'name'          => esc_html__( 'Items in Standard Desktop', 'swiper-slider' ),
                    'field_type'    => 'number',
                    'default'       => 4,
                    'class'         => 'wpss-responsive-field',
                ),
                'items_in_tablet'   => array(
                    'name'          => esc_html__( 'Items in Tablet', 'swiper-slider' ),
                    'field_type'    => 'number',
                    'default'       => 2,
                    'class'         => 'wpss-responsive-field',
                ),
                'items_in_mobile'   => array(
                    'name'          => esc_html__( 'Items in Mobile', 'swiper-slider' ),
                    'field_type'    => 'number',
                    'default'       => 1,
                    'class'         => 'wpss-responsive-field',
                ),
                'slide_control_view_auto' => array(
                    'name'        =>  esc_html__( 'Slides Per View Auto', 'swiper-slider' ),
                    'field_type'  =>  'switch',
                    'default'     =>  false,
                    'pro_version' => true,
                    'description' =>  esc_html__( 'Enable slide show per view auto for the slider.', 'swiper-slider' ),
                    'class'       => 'wpss-responsive-field',
                ),
                'slide_control_center' => array(
                    'name'        =>  esc_html__( 'Slides Centered', 'swiper-slider' ),
                    'field_type'  =>  'switch',
                    'default'     =>  false,
                    'pro_version' => true,
                    'description' =>  esc_html__( 'Enable slide centered for the slider.', 'swiper-slider' ),
                ),
                'control_loop_slider' => array(
                    'name'        => esc_html__( 'Loop Slides', 'swiper-slider' ),
                    'field_type'  => 'switch',
                    'default'     => false,
                    'pro_version' => true,
                    'description' => esc_html__( 'Enable continuous loop mode for the slider.', 'swiper-slider' ),
                ),
                'control_slide_speed' => array(
                    'name'        => esc_html__( 'Slide Speed', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 400,
                    'pro_version' => true,
                    'description' => esc_html__( 'Set the speed of slide transition in milliseconds (e.g., 400 = 0.4 seconds).', 'swiper-slider' ),
                ),
                'control_slide_space' => array(
                    'name'        => esc_html__( 'Slides Space', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 10,
                    'pro_version' => true,
                    'description' => esc_html__( 'Space between each slide (in px).', 'swiper-slider' ),
                ),
                'zoom_images' => array(
                    'name'        => esc_html__( 'Zoom Images', 'swiper-slider' ),
                    'field_type'  => 'switch',
                    'default'     => false,
                    'pro_version' => true,
                    'description' => esc_html__( 'Enable a zoom images for slider.', 'swiper-slider' ),
                ),
                'control_keyboard' => array(
                    'name'        =>  esc_html__( 'Keyboard Control', 'swiper-slider' ),
                    'field_type'  =>  'switch',
                    'default'     =>  false,
                    'pro_version' =>  true,
                    'description' =>  esc_html__( 'Enable keyboard navigation for the slider using arrow keys.', 'swiper-slider' ),
                ),
                'control_mousewheel' => array(
                    'name'        =>  esc_html__( 'Mousewheel Control', 'swiper-slider' ),
                    'field_type'  =>  'switch',
                    'default'     =>  false,
                    'pro_version' =>  true,
                    'description' =>  esc_html__( 'Enable mouse wheel navigation for the slider.', 'swiper-slider' ),
                ),
                'control_scrollbar' => array(
                    'name'        =>  esc_html__( 'Scrollbar Control', 'swiper-slider' ),
                    'field_type'  =>  'switch',
                    'default'     =>  false,
                    'pro_version' =>  true,
                    'description' =>  esc_html__( 'Enable scrollbar navigation for the slider.', 'swiper-slider' ),
                    'data_show'   => '.wpss-scrollbar-wrapper',
                ),
                'scrollbar_position' => array(
                    'name'        => esc_html__('Scrollbar Position', 'swiper-slider'),
                    'field_type'  => 'select',
                    'default'     => 'bottom',
                    'description' => esc_html__('Choose scrollbar position.', 'swiper-slider'),
                    'options'     => array(
                        'bottom' => esc_html__('Bottom (Use in Horizontal)', 'swiper-slider'),
                        'top'    => esc_html__('Top (Use in Horizontal)', 'swiper-slider'),
                        'left'   => esc_html__('Left ( Use in Vertical)', 'swiper-slider'),
                        'right'  => esc_html__('Right ( Use in Vertical)', 'swiper-slider'),
                    ),
                    'pro_version' =>  true,
                    'class'       => 'wpss-scrollbar-wrapper',
                ),
                'scrollbar_color' => array(
                    'name'        =>  esc_html__( 'Scrollbar Color', 'swiper-slider' ),
                    'field_type'  =>  'color',
                    'default'     =>  '#999999',
                    'class'       =>  'wpss-scrollbar-wrapper',
                    'pro_version' =>  true,
                ),  
                'control_rtl_slider' => array(
                    'name'        => esc_html__( 'Enable RTL', 'swiper-slider' ),
                    'field_type'  => 'switch',
                    'default'     => false,
                    'pro_version' => true,
                    'description' => esc_html__( 'Enable Right-to-Left sliding for RTL languages.', 'swiper-slider' ),
                ),
                'enable_grid_layout' => array(
                    'name'        => esc_html__('Enable Grid Layout', 'swiper-slider'),
                    'field_type'  => 'switch',
                    'default'     => false,
                    'pro_version' => true,
                    'description' => esc_html__('Enable Swiper grid layout.', 'swiper-slider'),
                    'data_show'   => 'grid_layout_axis',
                    'data_show'   => '.wpss-grid-layout',
                ),
                'grid_layout_axis' => array(
                    'name'        => esc_html__('Grid Layout Type', 'swiper-slider'),
                    'field_type'  => 'select',
                    'default'     => 'row',
                    'pro_version' => true,
                    'options'     => array(
                        'row'    => esc_html__('Row', 'swiper-slider'),
                        'column' => esc_html__('Column', 'swiper-slider'),
                    ),
                    'description'     => esc_html__('Choose grid layout: Row or Column.', 'swiper-slider'),
                    'data_show_map'   => array(
                        'row'    => 'grid_count',
                        'column' => 'grid_count',
                    ),
                    'class'   => 'wpss-grid-layout',
                ),
                'grid_count' => array(
                    'name'        => esc_html__('Grid Count', 'swiper-slider'),
                    'field_type'  => 'number',
                    'default'     => 2,
                    'pro_version' => true,
                    'description' => esc_html__('Set the number of rows or columns based on your layout.', 'swiper-slider'),
                    'class'   => 'wpss-grid-layout',
                ),
                'thumb_gallery' => array(
                    'name'        => esc_html__( 'Show Thumbnail Gallery', 'swiper-slider' ),
                    'field_type'  => 'switch',
                    'default'     => false,
                    'pro_version' => true,
                    'description' => esc_html__( 'Enable to display a thumbnail gallery below the main slider.', 'swiper-slider' ),
                    'data_show'       => '.wpss-thumb-gallery',
                ),
                'thumb_gallery_loop' => array(
                    'name'        => esc_html__( 'Thumbnail Gallery Loop', 'swiper-slider' ),
                    'field_type'  => 'switch',
                    'default'     => true,
                    'description' => esc_html__( 'Enable continuous loop mode for the thumbs gallery.', 'swiper-slider' ),
                    'pro_version' => true,
                    'class'       => 'wpss-thumb-gallery',
                ),
                'thumb_gallery_space' => array(
                    'name'        => esc_html__( 'Thumbnail Gallery Space', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 10,
                    'pro_version' => true,
                    'description' => esc_html__( 'Space between each thumbs gallery (in px).', 'swiper-slider' ),
                ),
                'thumb_gallery_width' => array(
                    'name'        => esc_html__( 'Thumbnail Width', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 80,
                    'pro_version' => true,
                    'description' => esc_html__( 'Set width of thumbnail images in px.', 'swiper-slider' ),
                    'class'       => 'wpss-thumb-gallery',
                ),
                'thumb_gallery_height' => array(
                    'name'        => esc_html__( 'Thumbnail Height', 'swiper-slider' ),
                    'field_type'  => 'number',
                    'default'     => 80,
                    'pro_version' => true,
                    'description' => esc_html__( 'Set height of thumbnail images in px.', 'swiper-slider' ),
                    'class'       => 'wpss-thumb-gallery',
                ),
            );

            $this->fields = apply_filters( 'wpss_slider_fields', $this->fields );
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
            if ( ! isset( $_POST['wpss_slideshow_metabox_nonce'] ) || ! 
                wp_verify_nonce( 
                    sanitize_text_field( wp_unslash( $_POST['wpss_slideshow_metabox_nonce'] ) ),
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
    new WPSS_Manage_Metadata();
endif;