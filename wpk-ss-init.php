<?php
/**
 * Plugin Name: WPK Simple Slider
 * Plugin URI: https://wordpress.org/plugins/wpk-simple-slider/
 * Description: A flexible plugin that allows you to create beautiful and slick sliders in your site or shop in a few seconds.
 * Author: Kishan Mangukiya
 * Version: 1.0.0
 * Author URI: mailto:kishanmangukiya.coderkube@gmail.com
 */

if ( ! defined( 'WPK_SIMPLE_SLIDER' ) ) :
	define( 'WPK_SIMPLE_SLIDER', 'WPK_SIMPLE_SLIDER' );
endif;

if ( ! defined( 'WPK_SIMPLE_SLIDER_VERSION' ) ) :
	define( 'WPK_SIMPLE_SLIDER_VERSION', '1.0.0' );
endif;

if ( ! defined( 'WPK_SIMPLE_SLIDER_PATH' ) ) :
	define( 'WPK_SIMPLE_SLIDER_PATH', plugin_dir_path( __FILE__ ) );
endif;

if ( ! defined( 'WPK_SIMPLE_SLIDER_URL' ) ) {
	define( 'WPK_SIMPLE_SLIDER_URL', plugin_dir_url( __FILE__ ) );
}


if ( ! function_exists( 'wpk_ss_constructor' ) ) :

	function wpk_ss_constructor(){
		require_once "include/wpk-ss-core-functions.php";
		if( is_admin() ) :
			require_once "include/class/class-wpk-ss-manage.php";
			require_once "include/class/class-wpk-ss-manage-metadata.php";
		else :
			require_once "include/class/class-wpk-ss-shortcode.php";
		endif;
	}
	add_action( 'plugins_loaded', 'wpk_ss_constructor' );

endif;