<?php
/**
 * Simple Slideshow Core Functions
 *
 * General core functions available on both the front-end and admin.
 */

if( !function_exists( 'wpk_get_temlpate' ) ) : 
   
    function wpk_get_temlpate( $template_name, $args = array(), $template_path = '' ) {
        if( empty( $template_path ) ) :
            $template_path = WPK_SIMPLE_SLIDER_PATH . '/templates/';
        endif;        
        
        $template = $template_path . $template_name;
        if ( ! file_exists( $template ) ) :
            return new WP_Error( 
                'error', 
                sprintf( 
                    __( '%s does not exist.', 'wpk-simple-slider' ), 
                    '<code>' . $template . '</code>' 
                ) 
            );
        endif;

        do_action( 'wpk_before_template_part', $template, $args, $template_path );

        if ( ! empty( $args ) && is_array( $args ) ) :
            extract( $args );
        endif;
        include $template;

        do_action( 'wpk_after_template_part', $template, $args, $template_path );
    }

endif;