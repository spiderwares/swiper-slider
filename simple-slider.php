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

if ( ! defined( 'WPSS_FILE' ) ) :
    define( 'WPSS_FILE', __FILE__ ); // Define the plugin file path.
endif;

if ( ! defined( 'WPSS_BASENAME' ) ) :
    define( 'WPSS_BASENAME', plugin_basename( WPSS_FILE ) ); // Define the plugin basename.
endif;

if ( ! defined( 'WPSS_VERSION' ) ) :
    define( 'WPSS_VERSION', time() ); // Plugin version
endif;

if ( ! defined( 'WPSS_PATH' ) ) :
    define( 'WPSS_PATH', plugin_dir_path( __FILE__ ) ); // Absolute path to plugin directory
endif;

if ( ! defined( 'WPSS_URL' ) ) :
    define( 'WPSS_URL', plugin_dir_url( __FILE__ ) ); // URL to plugin directory
endif;

if ( ! class_exists( 'WPSS', false ) ) :
    require_once WPSS_PATH . 'includes/class-wpss.php';
endif;

register_activation_hook( __FILE__, array( 'WPSS_install', 'install' ) ); // set activation hook

WPSS::instance();
