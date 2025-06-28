<?php 
/**
* Radio image field html
*/
?>
<td>
    <?php if( isset( $field['options'] ) ) : ?>
        <?php foreach( $field['options'] as $optionKey => $optionImg ) : ?>
            <p class="wpss-image-control">
                <input 
                    type="radio" 
                    name="wpss_slider_option[<?php echo esc_attr( $field_Key ); ?>]"
                    value="<?php echo esc_attr( $optionKey ); ?>"
                    id="<?php echo esc_attr( $field_Key . "_" . $optionKey ) ?>" 
                    <?php checked( $optionKey, $field_Val ); ?>>

                <label for="<?php echo esc_attr( $field_Key . "_" . $optionKey ) ?>">
                    <img width="150" src="<?php echo esc_url( WPSS_URL . "assets/images/options/" . $optionImg  ); ?>">
                    <?php echo esc_html( $optionKey ); ?>
                </label>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
</td>
