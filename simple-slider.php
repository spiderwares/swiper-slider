<?php
/**
 * Plugin Name:     Simple Slider
 * Plugin URI:      https://wordpress.org/plugins/wpss-simple-slider/
 * Description:     A flexible plugin that allows you to create beautiful and slick sliders in your site or shop in a few seconds.
 * Version:         1.0.0
 * Author:          Kishan Mangukiya
 * Author URI:      mailto:kishanmangukiya.coderkube@gmail.com
 * Text Domain:     wpss-simple-slider
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) :
    exit;
endif;

if ( ! defined( 'WPSS_VERSION' ) ) :
    define( 'WPSS_VERSION', '1.0.0' ); // Plugin version
endif;

if ( ! defined( 'WPSS_PATH' ) ) :
    define( 'WPSS_PATH', plugin_dir_path( __FILE__ ) ); // Absolute path to plugin directory
endif;

if ( ! defined( 'WPSS_URL' ) ) :
    define( 'WPSS_URL', plugin_dir_url( __FILE__ ) ); // URL to plugin directory
endif;

// Load the main loader class which handles plugin dependencies and includes
require_once WPSS_PATH . 'include/class/class-wpss-loader.php';

// Call the 'includes' method from the loader class after all plugins are loaded
add_action( 'plugins_loaded', array( WPSS::class, 'includes' ) );
