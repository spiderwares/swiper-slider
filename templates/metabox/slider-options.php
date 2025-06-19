<div class="tnz_ss_slides_wrap">
    <table class="form-table">
        <tbody>

			<?php  foreach( $fields as $field_Key => $field ) : 
				$field_Val = isset( $options[$field_Key] ) ? $options[$field_Key] : $field['default']; ?>

				<tr>
					<th scope="row">
						<?php esc_html_e( $field['name'] ); ?>
						<small><?php esc_html_e( 'Default value: ', 'wpk-simple-slider' ); ?><?php esc_html_e( $field['default'] ); ?></small>
					</th>

					<?php switch( $field['field_type'] ) :
						
						case "radioImg" : 
							wpk_get_temlpate(
								'fields/radioImg-field.php',
								array(
									'field' 		=> $field,
									'field_Val'		=> $field_Val,
									'field_Key'		=> $field_Key
								)
							);
							break;

						case "switch" : 
							wpk_get_temlpate(
								'fields/switch-field.php',
								array(
									'field' 		=> $field,
									'field_Val'		=> $field_Val,
									'field_Key'		=> $field_Key
								)
							);
							break;

					endswitch; ?>
					
				</tr>
			<?php endforeach; ?>

        </tbody>
    </table>
</div>