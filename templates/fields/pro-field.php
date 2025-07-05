<?php
/**
 * Pro version lock-only field
 */
?>
<td>
    <div class="wpss-pro-message">
        <?php 
            echo ! empty( $field['pro_version_message'] )
                ? esc_html( $field['pro_version_message'] )
                : esc_html__( 'This feature is available in the Pro version only.', 'swiper-slider' );
        ?>
        <?php echo esc_html__( 'Click', 'swiper-slider' ); ?>
            <a href="<?php echo esc_html__(' WPSS_PRO_VERSION_URL '); ?>" target="_blank">
                <?php echo esc_html__( 'here', 'swiper-slider' ); ?>
            </a>
        <?php echo esc_html__( ' to buy', 'swiper-slider' ); ?>.
    </div>
</td>
