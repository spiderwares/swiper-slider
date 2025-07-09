<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Radio image field html
 */
?>
<td>
    <?php if( isset( $field['options'] ) ) : ?>
        <?php 
        $disabled_options = isset( $field['disabled_options'] ) ? $field['disabled_options'] : array();
        foreach( $field['options'] as $optionKey => $optionImg ) :
            $is_disabled = in_array( $optionKey, $disabled_options ); ?>
            <p class="wpss-image-control <?php echo $is_disabled ? 'wpss-disabled-option' : ''; ?>">
                <input 
                    type="radio" 
                    name="wpss_slider_option[<?php echo esc_attr( $field_Key ); ?>]"
                    value="<?php echo esc_attr( $optionKey ); ?>"
                    id="<?php echo esc_attr( $field_Key . "_" . $optionKey ) ?>" 
                    <?php checked( $optionKey, $field_Val ); ?>
                    <?php echo $is_disabled ? 'disabled' : ''; ?>>

                <label for="<?php echo esc_attr( $field_Key . "_" . $optionKey ) ?>">
                    <img 
                        width="150" 
                        src="<?php echo esc_url( WPSS_URL . "assets/images/options/" . $optionImg ); ?>" 
                        alt="<?php echo esc_attr( $optionKey ); ?>" 
                        style="<?php echo $is_disabled ? 'opacity: 0.5; cursor: not-allowed;' : ''; ?>"
                    >
                    <?php echo esc_html( $optionKey ); ?>
                </label>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
</td>
