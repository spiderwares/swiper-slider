<?php 
if ( ! defined( 'ABSPATH' ) ) exit; 
?>
<div class="wpss_slides_wrap">
    <table class="form-table">
        <tbody>
            <?php foreach( $fields as $field_Key => $field ) : 
                $field_Val  = isset( $options[$field_Key] ) ? $options[$field_Key] : ( isset( $field['default'] ) ? $field['default'] : '' );
                $row_class  = isset( $field['class'] ) ? $field['class'] : '' ;
                $visible = !$row_class || strpos(json_encode($options), $row_class) !== false;
            ?>
                 <tr class="<?php echo esc_attr($row_class); ?>" style="<?php echo $visible ? '' : 'display: none;'; ?>">
                    <th scope="row">
                        <?php echo esc_html( $field['name'] ); ?>
                    </th>
                    <?php 
                    // Check for pro version restriction first
                    if ( ! empty( $field['pro_version'] ) && ! defined( 'WPSS_PRO_VERSION' ) ) :
                        wpss_get_template(
                            'fields/pro-field.php',
                            array(
                                'field' => $field
                            )
                        );
                    else :
                        switch( $field['field_type'] ) :
                            case "radio" : 
                                wpss_get_template(
                                    'fields/radio-field.php',
                                    array(
                                        'field'     => $field,
                                        'field_Val' => $field_Val,
                                        'field_Key' => $field_Key
                                    )
                                );
                                break;

                            case "switch" : 
                                wpss_get_template( 
                                    'fields/switch-field.php',
                                    array(
                                        'field'     => $field,
                                        'field_Val' => $field_Val,
                                        'field_Key' => $field_Key 
                                    ) 
                                );
                                break;

                            case "number":
                                wpss_get_template( 
                                    'fields/number-field.php', 
                                    array(
                                        'field'     => $field,
                                        'field_Val' => $field_Val,
                                        'field_Key' => $field_Key 
                                    ) 
                                );
                                break;
                                
                            case "color":
                                wpss_get_template( 
                                    'fields/color-field.php', 
                                    array(
                                        'field'     => $field,
                                        'field_Val' => $field_Val,
                                        'field_Key' => $field_Key 
                                    ) 
                                );
                                break;

                            case "select":
                                wpss_get_template( 
                                    'fields/select-field.php', 
                                    array(
                                        'field'     => $field,
                                        'field_Val' => $field_Val,
                                        'field_Key' => $field_Key 
                                    ) 
                                );
                                break;

							case "pro":
								wpss_get_template(
									'fields/pro-field.php',
									array(
										'field'      => $field,
										'field_Val'  => $field_Val,
										'field_Key'  => $field_Key
									)
								);
								break;


                        endswitch; 
                    endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>