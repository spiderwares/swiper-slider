<div class="wpss_slides_wrap">
    <table class="form-table">
        <tbody>

			<?php  foreach( $fields as $field_Key => $field ) : 
				$field_Val = isset( $options[$field_Key] ) ? $options[$field_Key] : $field['default'];
				$row_class = ( strpos( $field_Key, 'items_in_' ) === 0 ) ? 'wpss-responsive-field' : ''; 
				?>

				<tr class="<?php echo esc_attr( $row_class ); ?>">
					<th scope="row">
						<?php echo esc_html( $field['name'] ); ?>
					</th>

					<?php switch( $field['field_type'] ) :
						
						case "radio" : 
							wpss_get_template(
								'fields/radio-field.php',
								array(
									'field' 		=> $field,
									'field_Val'		=> $field_Val,
									'field_Key'		=> $field_Key
								)
							);
							break;

						case "switch" : 
							wpss_get_template( 
								'fields/switch-field.php',
								array(
									'field'         => $field,
									'field_Val'     => $field_Val,
									'field_Key'     => $field_Key 
									) 
								);
							break;

						case "number":
							wpss_get_template( 
								'fields/number-field.php', 
								array(
									'field'          => $field,
									'field_Val'      => $field_Val,
									'field_Key'      => $field_Key 
								) 
							);
							break;
							
						case "color":
							wpss_get_template( 
								'fields/color-field.php', 
								array(
									'field'          => $field,
									'field_Val'      => $field_Val,
									'field_Key'      => $field_Key 
								) 
							);
							break;

						case "select":
							wpss_get_template( 
								'fields/select-field.php', 
								array(
									'field'          => $field,
									'field_Val'      => $field_Val,
									'field_Key'      => $field_Key 
								) 
							);
							break;

					endswitch; ?>
					
				</tr>
			<?php endforeach; ?>

        </tbody>
    </table>
</div>
