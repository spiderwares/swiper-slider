<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Radio image field html
 */
?>
<td>
    <?php if ( isset( $field['options'] ) ) : ?>
        <div class="wpss-radio-field" <?php echo isset( $field['data_hide'] ) ? 'data-hide="' . esc_attr( $field['data_hide'] ) . '"' : ''; ?>>
            <?php foreach ( $field['options'] as $optionKey => $optionImg ) : ?>
                <p class="wpss-image-control <?php echo in_array( $optionKey, $field['disabled_options'] ?? array() ) ? 'wpss-disabled-option' : ''; ?>">
                    <input 
                        type="radio" 
                        name="wpss_slider_option[<?php echo esc_attr( $field_Key ); ?>]"
                        value="<?php echo esc_attr( $optionKey ); ?>"
                        id="<?php echo esc_attr( $field_Key . '_' . $optionKey ); ?>"
                        <?php checked( $optionKey, $field_Val ); ?>
                        <?php echo in_array( $optionKey, $field['disabled_options'] ?? array() ) ? 'disabled' : ''; ?>
                        data-show="<?php echo esc_attr( $field['data_show_map'][ $optionKey ] ?? '' ); ?>"
                    >

                    <label for="<?php echo esc_attr( $field_Key . '_' . $optionKey ); ?>">
                        <img 
                            width="150" 
                            src="<?php echo esc_url( WPSS_URL . 'assets/images/options/' . $optionImg ); ?>" 
                            alt="<?php echo esc_attr( $optionKey ); ?>"
                            style="<?php echo in_array( $optionKey, $field['disabled_options'] ?? array() ) ? 'opacity: 0.5; cursor: not-allowed;' : ''; ?>"
                        >
                        <?php echo esc_html( $optionKey ); ?>
                    </label>
                </p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</td>

