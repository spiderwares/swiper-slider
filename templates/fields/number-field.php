<?php 
/**
* Number field html
*/
?>
<td class="wpss-number-field  wpss-vishrut">
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
        <p class="description" style="margin-top: 5px;">
            <?php echo esc_html( $field['description'] ); ?>
        </p>
    <?php endif; ?>
</td>

