<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'WPSS' ) ) :

/**
 * Main WPSS Class
 */
final class WPSS {

    /**
     * The single instance of the class.
     *
     * @var WPSS
     */
    protected static $instance = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->event_handler();
        $this->includes();
    }

    /**
     * Hook initialization
     */
    private function event_handler() {
        add_action( 'plugins_loaded', array( $this, 'includes' ), 11 );
    }

    /**
     * Get the single instance of WPSS
     *
     * @return WPSS
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) :
            self::$instance = new self();
            do_action( 'wpss_plugin_loaded' );
        endif;
        return self::$instance;
    }

    /**
     * Include required files.
     */
    public function includes() {
        if ( is_admin() ) :
            $this->includes_admin();
        else:
            $this->includes_public();
        endif;
        require_once WPSS_PATH . 'includes/wpss-core-functions.php';
    }

    /**
     * Include admin files.
     */
    public function includes_admin() {
        require_once WPSS_PATH . 'includes/class-wpss-install.php';
        require_once WPSS_PATH . 'includes/admin/class-wpss-manage.php';
        require_once WPSS_PATH . 'includes/admin/class-wpss-manage-metadata.php';
    }
    
    /**
     * Include public files.
     */
    public function includes_public() {
        require_once WPSS_PATH . 'includes/public/class-wpss-shortcode.php';
    }
}

endif;
