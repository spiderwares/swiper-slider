<?php
/**
 * Select field html
 */
?>
<td>
    <select name="wpss_slider_option[<?php echo esc_attr( $field_Key ); ?>]" class="wpss-select">
        <?php if ( ! empty( $field['options'] ) && is_array( $field['options'] ) ) : ?>
            <?php foreach ( $field['options'] as $option_value => $option_label ) : ?>
                <option value="<?php echo esc_attr( $option_value ); ?>" <?php selected( $field_Val, $option_value ); ?>>
                    <?php echo esc_html( $option_label ); ?>
                </option>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</td>


