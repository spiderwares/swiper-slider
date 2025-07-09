<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Switch field html
 */
?>
<td class="wpss-switch-field"> 
    <label class="wpss-form-switch">
        <input type="hidden" name="wpss_slider_option[<?php echo esc_attr($field_Key); ?>]" value="0">
        <input 
            type="checkbox"
            class="wpss-toggle-input"
            name="wpss_slider_option[<?php echo esc_attr($field_Key); ?>]"
            value="1"
            data-show="<?php echo isset($field['data_show']) ? esc_attr($field['data_show']) : ''; ?>"
            <?php checked($field_Val, 1); ?> >

        <div class="wpss-toggle-switch">
            <div class="wpss-toggle">
                <svg class="wpss-icon-on" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" role="img">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>

                <svg class="wpss-icon-off" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" role="img">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
        
    </label>
    <?php if ( ! empty( $field['description'] ) ) : ?>
        <p class="description"><?php echo esc_html( $field['description'] ); ?></p>
    <?php endif; ?>
</td>
