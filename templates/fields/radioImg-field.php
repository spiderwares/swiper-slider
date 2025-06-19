<?php 
/**
* Radio image field html
*/
?>
<td>
    <?php if( isset( $field['options'] ) ) : ?>
        <?php foreach( $field['options'] as $optionKey => $optionImg ) : ?>
            <p class="image-control">
                <input 
                    type="radio" 
                    name="slideroption[<?php esc_attr_e( $field_Key ); ?>]" 
                    value="slide" 
                    id="<?php esc_attr_e( $field_Key . "_" . $optionKey ) ?>" 
                    <?php checked( $optionKey, $field_Val ); ?>>

                <label for="<?php esc_attr_e( $field_Key . "_" . $optionKey ) ?>">
                    <img width="150" src="<?php echo esc_url( WPK_SIMPLE_SLIDER_URL . "assets/images/options/" . $optionImg  ); ?>">
                    <?php esc_html_e( $optionKey ); ?>
                </label>
            </p>
        <?php endforeach; ?>
    <?php endif; ?>
</td>