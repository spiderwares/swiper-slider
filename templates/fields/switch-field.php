<?php
/**
 * Switch field html
 */
?>
<?php
$is_responsive_field = ( $field_Key === 'control_enable_responsive' );
?>
<td>
    <label class="wpss-form-switch">
        <input type="hidden" name="wpss_slider_option[<?php echo esc_attr( $field_Key ); ?>]" value="0">
        <input 
            type="checkbox"
            name="wpss_slider_option[<?php echo esc_attr( $field_Key ); ?>]"
            value="1"
            id="<?php echo $is_responsive_field ? 'wpss_enable_responsive' : ''; ?>"
            <?php checked( $field_Val, 1 ); ?>>
        <span></span>
    </label>

    <?php if ( ! empty( $field['description'] ) ) : ?>
        <p class="description" style="margin-top: 5px;">
            <?php echo esc_html( $field['description'] ); ?>
        </p>
    <?php endif; ?>
</td>


