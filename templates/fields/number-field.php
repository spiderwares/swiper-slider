<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
/**
* Number field html
*/
?>
<td class="wpss-number-field">
    <div class="wpss-number-wrap">
        <input 
            type="number" 
            name="wpss_slider_option[<?php echo esc_attr( $field_Key ); ?>]" 
            value="<?php echo esc_attr( $field_Val ); ?>"
            class="wpss-input"
        >
    </div>
    <?php if ( ! empty( $field['description'] ) ) : ?>
        <p class="description"><?php echo esc_html( $field['description'] ); ?></p>
    <?php endif; ?>
</td>


