<?php
/**
 * Swiper Slideshow Core Functions
 *
 * General core functions available on both the front-end and admin.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if( !function_exists( 'wpss_get_template' ) ) :
    /**
     * Loads a template from the version template directory.
     *
     * @param string $template_name Name of the template file.
     * @param array  $args Optional. Variables to pass to the template file.
     * @param string $template_path Optional. Custom path to templates.
     *
     * @return void|WP_Error
     */ 
   
    function wpss_get_template( $template_name, $args = array(), $template_path = '' ) {
        if( empty( $template_path ) ) :
            $template_path = WPSS_PATH . '/templates/';
        endif;        
        
        $template = $template_path . $template_name;
        if ( ! file_exists( $template ) ) :
            return new WP_Error( 
                'error', 
                sprintf( 
                    // translators: %s: The full path to the missing template file.
                    esc_html__( '%s does not exist.', 'swiper-slider' ), 
                    '<code>' . esc_html( $template ). '</code>' 
                ) 
            );
        endif;

        do_action( 'wpss_before_template_part', $template, $args, $template_path );

        if ( ! empty( $args ) && is_array( $args ) ) :
            extract( $args );
        endif;
        include $template;

        do_action( 'wpss_after_template_part', $template, $args, $template_path );
    }

endif;