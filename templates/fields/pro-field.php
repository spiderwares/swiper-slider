<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Pro version lock-only field
 */
?>
<td>
    <div class="wpss-pro-message">
        <?php 
            if ( ! empty( $field['pro_version_message'] ) ) :
                echo esc_html( $field['pro_version_message'] );
            else:
                echo esc_html__( 'This feature is available in the Pro version only.', 'swiper-slider' );
            endif;
        ?>

        <?php echo esc_html__( 'Click', 'swiper-slider' ); ?>
        <a href="<?php echo esc_url( WPSS_PRO_VERSION_URL ); ?>" target="_blank">
            <?php echo esc_html__( 'here', 'swiper-slider' ); ?>
        </a>
        <?php echo esc_html__( ' to buy', 'swiper-slider' ); ?>.
    </div>
</td>
