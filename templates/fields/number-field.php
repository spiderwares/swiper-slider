<?php 
/**
* Number field html
*/
?>
<td class="wpss-number-field">
    <?php if ( ! empty( $field['pro_version'] ) && ! defined( 'WPSS_PRO_VERSION' ) ) : ?>
        <p class="wpss-pro-lock-message">
            <?php 
                echo ! empty( $field['pro_version_message'] ) 
                    ? esc_html( $field['pro_version_message'] ) 
                    : esc_html__( 'This number option is available in Pro only.', 'swiper-slider' );
            ?>
            <a href="https://x.ai/swiper-slider-pro" target="_blank">
                <?php echo esc_html__( 'Get Pro Version', 'swiper-slider' ); ?>
            </a>
        </p>
    <?php else : ?>
        <div class="wpss-number-wrap">
            <input 
                type="number" 
                name="wpss_slider_option[<?php echo esc_attr( $field_Key ); ?>]" 
                value="<?php echo esc_attr( $field_Val ); ?>" 
                min="1"
                class="wpss-input"
            >
        </div>
        <?php if ( ! empty( $field['description'] ) ) : ?>
            <p class="description"><?php echo esc_html( $field['description'] ); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</td>


