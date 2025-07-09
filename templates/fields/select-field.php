<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Select field html
 */
?>
<td>
    <select name="wpss_slider_option[<?php echo esc_attr($field_Key); ?>]"
            class="wpss-select wpss-select-field"
            <?php if (!empty($field['data_hide'])) : ?>
                data-hide="<?php echo esc_attr($field['data_hide']); ?>"
            <?php endif; ?>>

        <?php foreach ($field['options'] as $option_value => $option_label) : 
            $data_show_attr = isset($field['data_show_map'][$option_value]) ? $field['data_show_map'][$option_value] : ''; ?>
            <option
                value="<?php echo esc_attr($option_value); ?>"
                <?php if ($data_show_attr) : ?>
                    data-show="<?php echo esc_attr($data_show_attr); ?>"
                <?php endif; ?>
                <?php selected($field_Val, $option_value); ?>
               <?php echo in_array($option_value, isset($field['disabled_options']) ? $field['disabled_options'] : [], true) ? 'disabled' : ''; ?>>
                <?php echo esc_html($option_label); ?>
            </option>
        <?php endforeach; ?>
    </select>


    <?php if (!empty($field['description'])) : ?>
        <p class="description"><?php echo esc_html($field['description']); ?></p>
    <?php endif; ?>
</td>

