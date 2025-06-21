<?php
/**
 * Range field html
 */
?>
<td>
    <input 
        type="range"
        name="wpss_slider_option[<?php echo esc_attr( $field_Key ); ?>]"
        min="0"
        max="10000"
        step="100"
        value="<?php echo esc_attr( $field_Val ); ?>"
        oninput="document.getElementById('<?php echo esc_attr( $field_Key ); ?>_output').value = this.value"
    >
    <output 
        id="<?php echo esc_attr( $field_Key ); ?>_output" 
        class="wpss-range-output">
        <?php echo esc_html( $field_Val ); ?>
    </output>
</td>

