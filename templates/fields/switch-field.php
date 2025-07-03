<?php
/**
 * Switch field html
 */
?>
<td class="wpss-switch-field"> 
    <?php if ( ! empty( $field['pro_version'] ) && ! defined( 'WPSS_PRO_VERSION' ) ) : ?>
          <p class="wpss-pro-lock-message">
            <?php 
                echo ! empty( $field['pro_version_message'] ) 
                    ? esc_html( $field['pro_version_message'] ) 
                    : esc_html__( 'This option is available in the Pro version.', 'swiper-slider' );
            ?>
            <a href="https://x.ai/swiper-slider-pro" target="_blank">
                <?php echo esc_html__( 'Get Pro Version', 'swiper-slider' ); ?>
            </a>
        </p>
    <?php else : ?>
        <label class="wpss-form-switch">
            <input type="hidden" name="wpss_slider_option[<?php echo esc_attr($field_Key); ?>]" value="0">
            <input 
                type="checkbox"
                name="wpss_slider_option[<?php echo esc_attr($field_Key); ?>]"
                value="1"
                data-show="<?php echo esc_attr($field['data_show'] ?? ''); ?>"
                <?php checked($field_Val, 1); ?>
            >
            <span></span>
        </label>
        <?php if (!empty($field['description'])) : ?>
            <p class="description"><?php echo esc_html($field['description']); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</td>
