<?php
// Exit if accessed directly.

if ( ! defined( 'ABSPATH' ) ) exit;

if( ! isset($slider_id) || empty($slider_id) ) :
    return;
endif;

if ( empty( $settings ) || ! is_array( $settings ) ) :
    return;
endif;


$arrow_color           = isset( $settings['arrow_color'] ) ? $settings['arrow_color'] : '#ffffff';
$arrow_bg_color        = isset( $settings['arrow_bg_color'] ) ? $settings['arrow_bg_color'] : '#000000';
$arrow_hover_color     = isset( $settings['arrow_hover_color'] ) ? $settings['arrow_hover_color'] : '#ffffff';
$arrow_hover_bg_color  = isset( $settings['arrow_hover_bg_color'] ) ? $settings['arrow_hover_bg_color'] : '#333333';
$arrow_border_color    = isset( $settings['arrow_border_color'] ) ? $settings['arrow_border_color'] : '#ffffff';
$arrow_style           = isset( $settings['navigation_arrow_style'] ) ? $settings['navigation_arrow_style'] : 'style1';

$bullets_bg_color       = isset( $settings['bullets_bg_color'] ) ? $settings['bullets_bg_color'] : '#ffffff';
$bullets_hover_bg_color = isset( $settings['bullets_hover_bg_color'] ) ? $settings['bullets_hover_bg_color'] : '#ffffff';
$bullets_border_color   = isset( $settings['bullets_border_color'] ) ? $settings['bullets_border_color'] : '#ffffff';
$bullets_style          = isset( $settings['bullets_navigation_style'] ) ? $settings['bullets_navigation_style'] : 'style1';

$unit         = isset( $settings['arrow_position_unit'] ) ? $settings['arrow_position_unit'] : 'px';
$arrow_top    = isset( $settings['arrow_position_top'] ) ? intval( $settings['arrow_position_top'] ) . $unit : 'auto';
$arrow_bottom = isset( $settings['arrow_position_bottom'] ) ? intval( $settings['arrow_position_bottom'] ) . $unit : 'auto';
$arrow_left   = isset( $settings['arrow_position_left'] ) ? intval( $settings['arrow_position_left'] ) . $unit : 'auto';
$arrow_right  = isset( $settings['arrow_position_right'] ) ? intval( $settings['arrow_position_right'] ) . $unit : 'auto';

?>

/* ================= Dynamic Arrow Style ============== */
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-<?php echo esc_attr( $arrow_style ); ?> .swiper-button-next,
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-<?php echo esc_attr( $arrow_style ); ?> .swiper-button-prev {
    color: <?php echo esc_html( $arrow_color ); ?>;
    <?php if ( $arrow_style !== 'style1' && $arrow_style !== 'custom' && $arrow_style !== 'style5' ) : ?>
    background-color: <?php echo esc_html( $arrow_bg_color ); ?>;
    <?php endif; ?>
    <?php if ( $arrow_style !== 'style1' && $arrow_style !== 'none' && $arrow_style !== 'style5' ) : ?>
    border-color: <?php echo esc_html( $arrow_border_color ); ?>;
    <?php endif; ?>
}

.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-<?php echo esc_attr( $arrow_style ); ?> .swiper-button-next:hover,
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-<?php echo esc_attr( $arrow_style ); ?> .swiper-button-prev:hover {
    color: <?php echo esc_html( $arrow_hover_color ); ?>;
    <?php if ( $arrow_style !== 'style1' && $arrow_style !== 'custom' && $arrow_style !== 'style5'  ) : ?>
    background-color: <?php echo esc_html( $arrow_hover_bg_color ); ?>;
    <?php endif; ?>
    <?php if ( $arrow_style !== 'style1' && $arrow_style !== 'none' && $arrow_style !== 'style5' ) : ?>
    border-color: <?php echo esc_html( $arrow_border_color ); ?>;
    <?php endif; ?>
}

/* === Dynamic Custom Arrow Position === */
<?php if ( $arrow_style === 'custom' ) : ?>
.wpss_slider--<?php echo esc_attr( $slider_id ); ?>.wpss-swiper-arrow-custom .swiper-button-prev {
    <?php if ( $settings['arrow_position_top'] !== '' ) : ?>
        top: <?php echo esc_html( $arrow_top ); ?>;
        bottom: auto;
    <?php elseif ( $settings['arrow_position_bottom'] !== '' ) : ?>
        top: auto;
        bottom: <?php echo esc_html( $arrow_bottom ); ?>;
    <?php endif; ?>

    left: <?php echo esc_html( $arrow_left ); ?>;
    right: auto;
}

.wpss_slider--<?php echo esc_attr( $slider_id ); ?>.wpss-swiper-arrow-custom .swiper-button-next {
    <?php if ( $settings['arrow_position_top'] !== '' ) : ?>
        top: <?php echo esc_html( $arrow_top ); ?>;
        bottom: auto;
    <?php elseif ( $settings['arrow_position_bottom'] !== '' ) : ?>
        top: auto;
        bottom: <?php echo esc_html( $arrow_bottom ); ?>;
    <?php endif; ?>

    left: auto;
    right: <?php echo esc_html( $arrow_right ); ?>;
}
<?php endif; ?>


<?php if ( $arrow_style === 'style4' ) : ?>
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style4 .swiper-button-prev::before {
    border-color: transparent <?php echo esc_html( $arrow_color ); ?> transparent transparent;
}
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style4 .swiper-button-next::before {
    border-color: transparent transparent transparent <?php echo esc_html( $arrow_color ); ?>;
}
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style4 .swiper-button-prev:hover::before {
    border-color: transparent <?php echo esc_html( $arrow_hover_color ); ?> transparent transparent;
}
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style4 .swiper-button-next:hover::before {
    border-color: transparent transparent transparent <?php echo esc_html( $arrow_hover_color ); ?>;
}
<?php endif; ?>

<?php if ( $arrow_style === 'style5' ) : ?>
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style5 .swiper-button-next::before,
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style5 .swiper-button-prev::before {
    background-color: <?php echo esc_html( $arrow_color ); ?>;
}
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style5 .swiper-button-next::after,
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style5 .swiper-button-prev::after {
    border-top-color: <?php echo esc_html( $arrow_color ); ?>;
    border-right-color: <?php echo esc_html( $arrow_color ); ?>;
}

.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style5 .swiper-button-next:hover::before,
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style5 .swiper-button-prev:hover::before {
    background-color: <?php echo esc_html( $arrow_hover_color ); ?>;
}
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style5 .swiper-button-next:hover::after,
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-arrow-style5 .swiper-button-prev:hover::after {
    border-top-color: <?php echo esc_html( $arrow_hover_color ); ?>;
    border-right-color: <?php echo esc_html( $arrow_hover_color ); ?>;
}
<?php endif; ?>
/* ==================== End Dynamic Arrow Style ================ */


/* ================ Dynamic Dot Style ================ */
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-dot-<?php echo esc_attr( $bullets_style ); ?> .swiper-pagination-bullet {
    background-color: <?php echo esc_html( $bullets_bg_color ); ?>;
    background-color: <?php echo esc_html( $bullets_bg_color ); ?>;
    border: 2px solid <?php echo esc_html( $bullets_border_color ); ?>;

}

.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-dot-<?php echo esc_attr( $bullets_style ); ?> .swiper-pagination-bullet-active,
.wpss_slider--<?php echo esc_attr($slider_id); ?>.wpss-swiper-dot-<?php echo esc_attr( $bullets_style ); ?> .swiper-pagination-bullet:hover {
    background-color: <?php echo esc_html( $bullets_hover_bg_color ); ?>;
    border: 2px solid <?php echo esc_html( $bullets_border_color ); ?>;
}