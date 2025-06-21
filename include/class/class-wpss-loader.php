<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'WPSS' ) ) :
    
    class WPSS {

        public function __construct() {
            $this->includes();
        }

        public static function includes() {
            require_once WPSS_PATH . 'include/wpss-core-functions.php';

            if ( is_admin() ) :
                require_once WPSS_PATH . 'include/class/class-wpss-manage.php';
                require_once WPSS_PATH . 'include/class/class-wpss-manage-metadata.php';
            else :
                require_once WPSS_PATH . 'include/class/class-wpss-shortcode.php';
            endif;
        }

        // public function includes(){
        //     if( is_admin() ) :
        //         $this->includes_admin();
        //    else :
        //         $this->includes_public();
        //     endif;
        // }

        // public function includes_admin(){
        //     require_once WPSS_PATH . 'include/wpss-core-functions.php';
        //     require_once WPSS_PATH . 'include/class/class-wpss-manage.php';
        //     require_once WPSS_PATH . 'include/class/class-wpss-manage-metadata.php';
        //     require_once WPSS_PATH . 'include/class/class-wpss-shortcode.php';
        // }

        // public function includes_public(){
        // }
        
    }
endif;
