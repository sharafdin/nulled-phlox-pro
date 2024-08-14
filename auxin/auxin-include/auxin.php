<?php
/**
 * Auxin is a powerful and exclusive framework which powers averta themes
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


if( ! class_exists( 'Auxin' ) ){

    class Auxin {

        /**
         * Instance of this class.
         *
         * @var      object
         */
        public static $instance = null;

        /**
         * Auxin version
         *
         * @var      string
         */
        public $version = '2.2.3';


        public $config = null;


        /**
         * Return an instance of this class.
         *
         * @return    object    A single instance of this class.
         */
        public static function get_instance() {

            if ( null == self::$instance ) {
                self::$instance = new self();
            }

            return self::$instance;
        }


        public function __construct(){

            // Skip initializing the auxin if authorize failed
            if( ! $this->authorized() ){
                return;
            }
            $this->define_constants();
            $this->include_files();
        }


        private function define_constants(){

            // core version
            $this->define( 'AUXIN_VERSION', esc_attr( $this->version ) );

            // this id is used as prefix in database option field names - specific for each theme
            $this->define( 'AUXIN' , 'auxin_' );



            // Server path for current theme directory
            $this->define( 'THEME_DIR' , get_template_directory() . '/' );

            // Http url of current theme directory
            $this->define( 'THEME_URL' , esc_url( get_template_directory_uri() . '/' ) );



            // path to auxin folder from theme root dir
            $this->define( 'AUXIN_DIR' , 'auxin/' );

            // Http url of admin folder
            $this->define( 'AUXIN_URL' , THEME_URL. AUXIN_DIR );



            // slug for auxin includes folder
            $this->define( 'AUXIN_INC_SLUG' , 'auxin-include/' );

            // slug for auxin contents folder
            $this->define( 'AUXIN_CON_SLUG' , 'auxin-content/' );



            // Server path for admin > include folder
            $this->define( 'AUXIN_INC' , AUXIN_DIR . AUXIN_INC_SLUG );

            // Http url of admin > include folder
            $this->define( 'AUXIN_INC_URL' , AUXIN_URL. AUXIN_INC_SLUG );



            // Server path for admin > include folder
            $this->define( 'AUXIN_CON' ,  AUXIN_CON_SLUG );

            // Http url of admin > include folder
            $this->define( 'AUXIN_CON_URL' , THEME_URL. AUXIN_CON_SLUG );



            // Server path for admin > css folder
            $this->define( 'ADMIN_CSS' , AUXIN_DIR. 'css/' );

            // Http url of admin > css folder
            $this->define( 'ADMIN_CSS_URL' , AUXIN_URL. 'css/' );



            // Server path for admin > js folder
            $this->define( 'ADMIN_JS' , AUXIN_DIR. 'js/' );

            // Http url of admin > js folder
            $this->define( 'ADMIN_JS_URL' , AUXIN_URL. 'js/' );


            locate_template( AUXIN_CON . 'init/constant.php', true, true );
            locate_template( AUXIN_CON . 'init/constant-i18n.php', true, true );

            // theme name
            $theme_data = wp_get_theme();

            $this->define( 'THEME_NAME'      , esc_attr( $theme_data->Name ) );
            $this->define( 'THEME_NAME_I18N' , esc_attr( rtrim( $theme_data->Name, 'Child' ) ) );

            // theme version
            if( $theme_parent_data = $theme_data->parent() ){
                $this->define( 'THEME_VERSION'   , esc_attr( $theme_parent_data->Version ) );
            } else {
                $this->define( 'THEME_VERSION'   , esc_attr( $theme_data->Version ) );
            }

            if( ! defined('THEME_ID') ) {
                // theme ID
                if( ! $_theme_id = get_option( "stylesheet" ) ){
                    if( ! $_theme_id = get_option( "current_theme" ) ){
                        $_theme_id = $theme_data->Name;
                    }
                }
                $_theme_id =  str_replace( ' ', '-', strtolower( trim( $_theme_id ) ) );
                define( 'THEME_ID' , esc_attr( $_theme_id ) );
            }

            $this->define( 'THEME_PRO' , false );

            // domain name for tranlation file
            $this->define( 'THEME'.'_DOMAIN' , THEME_ID );

            // To display or hide support information in help panel
            $this->define( 'AUXIN_SUPPORT'  , true  );
            $this->define( 'AUXIN_NO_BRAND' , false );

            // set this to false to disable update notifier
            $this->define( 'AUXIN_UPDATE_NOTIFIER' , true );

            // a custom directory in uploads directory for storing custom files. Default uploads/{THEME_ID}
            $uploads = wp_get_upload_dir();
            $this->define( 'THEME_CUSTOM_DIR' , $uploads['basedir'] . '/' . THEME_ID );
        }


        private function define( $name, $value ) {
            if ( ! defined( $name ) ) {
                define( $name, $value );
            }
        }


        public function include_files(){

            /*----------------------------------------------*/
            /*  Include essential functions
            /*----------------------------------------------*/
            locate_template( AUXIN_INC . 'init/global.php' , true, true );

            /*----------------------------------------------*/
            /*  Setup general configs
            /*----------------------------------------------*/
            locate_template( AUXIN_INC. 'init/config.php', true, true );

            /*----------------------------------------------*/
            /*  Include general functions
            /*----------------------------------------------*/
            locate_template( AUXIN_INC . 'include/functions.php', true, true );

            if( is_admin() )
                locate_template( AUXIN_INC . 'include/functions-admin.php', true, true );

            do_action( 'auxin_functions_ready' );

            /*----------------------------------------------*/
            /*  Theme specific functions and configs
            /*----------------------------------------------*/
            locate_template( AUXIN_CON . 'functions.php', true, true );

            /*----------------------------------------------*/
            /*  Include all template functions
            /*----------------------------------------------*/
            locate_template( AUXIN_INC.'include/templates/index.php', true, true );

            /*----------------------------------------------*/
            /*  Include general settings
            /*----------------------------------------------*/
            locate_template( AUXIN_INC . 'include/hooks-general.php', true, true );

            if( is_admin() )
                locate_template( AUXIN_INC . 'include/hooks-admin.php', true, true );

            /*----------------------------------------------*/
            /*  Include classes
            /*----------------------------------------------*/
            locate_template( AUXIN_INC. 'classes/index.php', true, true );

            do_action( 'auxin_classes_loaded' );

            /*----------------------------------------------*/
            /*  Add Modules
            /*----------------------------------------------*/
            locate_template( AUXIN_INC . 'modules/index.php', true, true );

            do_action( 'auxin_ready' );

            /*----------------------------------------------*/
            /*  Compatibility for third party plugins
            /*----------------------------------------------*/
            locate_template( AUXIN_INC . 'compatibility/index.php', true, true );

            /*----------------------------------------------*/
            /*  Init Theme Options
            /*----------------------------------------------*/
            if( is_admin() )
                Auxin_Option::api();

            /*----------------------------------------------*/
            do_action( 'auxin_loaded' );


            if( is_admin() )
                do_action( 'auxin_admin_loaded' );

        }


        /**
         * Whether to terminate loading auxin or not
         *
         * @return boolean
         */
        private function authorized(){
            locate_template( 'auxin-content/init/dependency.php', true, true );

            if( defined('AUXELS_VERSION') && defined('AUXELS_REQUIRED_VERSION') && version_compare( AUXELS_VERSION, AUXELS_REQUIRED_VERSION, '<' ) ){
                add_action( 'admin_notices', array( $this, 'plugin_dependency_notice' ) );
                return false;
            }
            if( defined('AUXPFO_VERSION') && defined('AUXPFO_REQUIRED_VERSION') && version_compare( AUXPFO_VERSION, AUXPFO_REQUIRED_VERSION, '<' ) ){
                add_action( 'admin_notices', array( $this, 'plugin_dependency_notice' ) );
                return false;
            }
            return true;
        }

        /**
         * Display a notice for plugin version requirement
         *
         * @return void
         */
        public function plugin_dependency_notice(){
            if( defined('AUXELS_VERSION') && defined('AUXELS_REQUIRED_VERSION') ){
                echo '<div class="aux-front-error aux-front-notice error" style="padding:2em;font-size:16px;">';
                printf( __( 'Phlox theme cannot function properly due to following reason: "Phlox Core Elements" version %s is required. Current version is %s. Please update it. ', 'phlox-pro'), AUXELS_REQUIRED_VERSION, AUXELS_VERSION );
                echo '</div>';
            }
        }

        /**
         * Magic method to get the value of accessible properties
         *
         * @param   string   The property name
         * @return  string  The value of property
         */
        public function __get( $name ){

            if( property_exists( $this, $name ) ){
                return $this->$name;
            }

            if( 'Font_Icons' == $name ){
                return Auxin_Font_Icons::get_instance();
            }

            if( 'Master_Menu' == $name ){
                return Auxin_Master_Nav_Menu::get_instance();
            }

            if( 'Config' == $name ){
                return AuxinConfig::get_instance();
            }

            return null;
        }

    }



    /**
     * Returns the instance of Auxin
     *
     * @return Auxin
     */
    function Auxin() {
        return Auxin::get_instance();
    }
    Auxin();

}
