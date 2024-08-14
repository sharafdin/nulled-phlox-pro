<?php
/**
 * Style and script manager for front end
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

class Auxin_Frontend_Assets {

    // Name prefixe for assets
    public $prefix = 'auxin-';

    // default assets version
    public $version = '2.0.0';

    // version number for custom asset files
    public $custom_version = '1.0';


    /**
     * Construct
     */
    public function __construct() {

        // get parent theme data, even if the child theme is active
        $theme_data = auxin_get_main_theme();
        // set theme version
        $this->version = $theme_data->version;
        // version number for custom asset files
        $this->custom_version = auxin_get_theme_mod( 'custom_css_ver', '1.0' );

        add_filter( 'auxin_header_inline_styles', array( $this, 'inline_header_styles'  ), 11, 2 );
        add_filter( 'auxin_footer_inline_script', array( $this, 'inline_footer_scripts' ), 11, 2 );


        add_action( 'wp_enqueue_scripts'   , array( $this, 'load_main_assets'  ) );
        add_action( 'wp_enqueue_scripts'   , array( $this, 'load_assets'  ), 15 );
        add_action( 'login_enqueue_scripts', array( $this, 'login_assets' ), 11 );

        add_action( 'get_footer', [ $this, 'enqueue_style_in_footer' ], 100 );
    }

    /**
     * Register and load frontend scripts
     *
     * @return void
     */
    public function load_assets(){
        global $post;

        /*-----------------------------------------------------------------------------------*/
        /*  JS
        /*-----------------------------------------------------------------------------------*/
        // Enables HTML5 elements & feature detects
        wp_enqueue_script( 'auxin-modernizr' , THEME_URL . 'js/solo/modernizr-custom.min.js' , null, $this->version, false );


        if ( apply_filters( 'auxin_load_minified_assets', true ) ) {
            wp_enqueue_script( 'auxin-plugins' , THEME_URL . 'js/plugins.min.js' , array( 'jquery', 'masonry', 'imagesloaded' ), $this->version, TRUE );
            wp_enqueue_script( 'auxin-scripts' , THEME_URL . 'js/scripts.min.js' , array( 'auxin-plugins' ), $this->version, TRUE );
        } else {
            wp_enqueue_script( 'auxin-plugins' , THEME_URL . 'js/plugins.js' , array( 'jquery', 'masonry', 'imagesloaded' ), $this->version, TRUE );
            wp_enqueue_script( 'auxin-scripts' , THEME_URL . 'js/scripts.js' , array( 'auxin-plugins' ), $this->version, TRUE );
        }


        // responsive table
        wp_register_script( 'stacktable' , THEME_URL . 'js/solo/stacktable.js' , array( 'jquery' ), $this->version, TRUE );

        // Print JS Object /////////////////////////////////////////////////////


        $aux_upload_dir = wp_get_upload_dir();

        // Localize the main auxin variables
        wp_localize_script( 'auxin-modernizr', 'auxin', apply_filters( 'auxin_frontend_js_params', array(
            'ajax_url'      => self_admin_url( 'admin-ajax.php' ),
            'is_rtl'        => is_rtl(),
            'is_reponsive'  => auxin_get_option( 'enable_site_reponsiveness', true ),
            'is_framed'     => auxin_get_option( 'site_frame_show', false ),
            'frame_width'   => 20,
            'wpml_lang'     => defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en',
            'uploadbaseurl' => $aux_upload_dir['baseurl'],
            'nonce'         => wp_create_nonce( 'auxin-security-nonce' )
        )));

        // Add essential inline scripts to header
        $auxin_header_inline_scripts = 'function auxinNS(n){for(var e=n.split("."),a=window,i="",r=e.length,t=0;r>t;t++)"window"!=e[t]&&(i=e[t],a[i]=a[i]||{},a=a[i]);return a;}';
        if( $auxin_header_inline_scripts = apply_filters( 'auxin_header_inline_scripts', $auxin_header_inline_scripts ) ){
            wp_add_inline_script( 'auxin-modernizr', "/* < ![CDATA[ */\n". $auxin_header_inline_scripts ."\n/* ]]> */",
            'before' );
        }

        //  Prints user defined custom JavaScript code in footer ///////////////
        if( $custom_js = apply_filters( 'auxin_footer_inline_script', '', $post ) ){
            wp_add_inline_script( 'auxin-scripts', $custom_js, 'after' );
        }

        /*-----------------------------------------------------------------------------------*/
        /*  CSS
        /*-----------------------------------------------------------------------------------*/

        // register front-end custom styles ////////////////////////////////////

        /*
        // wp_enqueue_style('auxin-base', THEME_URL . 'css/theme-styles.css' , NULL, $this->version );
        */



        // Load the special css file
        if( auxin_get_option( 'special_css_file_enabled', 0 ) ){
            $uploads   = wp_get_upload_dir();
            $css_file  = $uploads['baseurl'] . '/' . THEME_ID . '/'. auxin_get_option('special_css_file_name', 'special') .'.css';
            wp_enqueue_style('auxin-special' , set_url_scheme( $css_file ) , array('auxin-main'), $this->version );
        }

        // Load style.css file if child theme is active, in this case the clients are able to add and apply their custom css styles in style.css file too
        if( is_child_theme() || defined('AUXIN_LOAD_DEFAULT_STYLESHEET') ){
            wp_enqueue_style('auxin-child' , get_stylesheet_uri() , array('auxin-main'), $this->version );
        }
        
        /*
        if((defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE == "fa") || is_rtl()) {
            wp_enqueue_style('auxin-rtl2'     , $tmp_dir . 'css/rtl.css'                 , array("auxin-base2", "auxin-main2", "superfish2"), $this->version);
        }
        */


        // Enqueue front-end custom styles /////////////////////////////////////

        $this->load_fonts();
        $this->load_custom_css_file();
        $this->load_custom_js_file();
        $this->go_pricing_styles();

        wp_register_style( 'auxin-inline-styles', false, [], $this->version );

        do_action( 'auxin_enqueue_script', $post );
    }

    public function load_main_assets() {
        wp_enqueue_style('auxin-base' , THEME_URL . 'css/base.css' , NULL, $this->version );


        // Register and enqueue the font icons in front-end
        wp_register_style('auxin-front-icon' , THEME_URL . 'css/auxin-icon.css' , array('auxin-base'), $this->version );
        wp_enqueue_style('auxin-front-icon');


        wp_enqueue_style('auxin-main' , THEME_URL . 'css/main.css' , array('auxin-base'), $this->version );
    }

    /**
     * Load selected fonts in front-end
     *
     * @return void
     */
    function load_fonts(){

        $font_urls = auxin_get_theme_mod( 'font_urls' );

        if( !is_array( $font_urls ) ){
            return false;
        }

        foreach ( $font_urls as $style_id => $font_enqueue_url ) {
            wp_enqueue_style ( $style_id, $font_enqueue_url, NULL, $this->custom_version );
        }
    }


    /**
     * Load custom css code in front-end
     *
     * @return void
     */
    function load_custom_css_file(){

        if ( ! is_customize_preview() ) {

            // load custom.css if the directory is writable. else use inline css fallback - Make sure the auxin-elements is installed
            if( function_exists('AUXELS') && ! auxin_get_theme_mod( 'inline_custom_css', '' ) ){

                $uploads   = wp_get_upload_dir();
                $css_file  = $uploads['baseurl'] . '/' . THEME_ID . '/custom.css';

                wp_enqueue_style( 'auxin-custom', set_url_scheme( $css_file ), array('auxin-base'), $this->custom_version );

            }
        }
    }


    /**
     * Load custom js code in front-end
     *
     * @return void
     */
    function load_custom_js_file(){

        // Dont enqueue custom js file if it is cutomizer preview (use inline instead to try/catch)
        if( is_customize_preview() ){
            return;
        }

        // load custom.js if the directory is writable. else use inline js fallback - Make sure the auxin-elements is installed

        if( function_exists('AUXELS') && ! auxin_get_theme_mod( 'use_inline_custom_js', '' ) ){

            $uploads   = wp_get_upload_dir();
            $js_file  = $uploads['baseurl'] . '/' . THEME_ID . '/custom.js';

            wp_enqueue_script( 'auxin-custom-js', set_url_scheme( $js_file ), array('auxin-plugins'), auxin_get_theme_mod( 'custom_js_ver' , 1.0 ), true );


        }
    }


    // -------------------------------------------------------------------------


    /**
     * Adds custom styles in page header if inline custom css is set.
     *
     * @return void
     */
    function inline_header_styles( $css, $post ){

        if( function_exists( 'AUXELS' ) ){

            // if custom.css is not writable, print css styles in page header
            if( auxin_get_theme_mod( 'inline_custom_css' ) ) {
                if( current_user_can( 'manage_options' ) ){
                    $css .= "\n". sprintf( "<!-- Note for admin: The custom.css file in [%s] is not writeable, so the theme uses inline css callback instead. -->\n",
                                           "wp-content/uploads/". THEME_ID. "/custom.css" ) . "\n";
                }
                $css .= auxin_get_theme_mod( 'custom_css_string' ) . "\n";
            }

        // if both "auxin elements" and inline css were not available fallback and fetch inline css
        } else {
            $css .= auxin_get_theme_mod( 'custom_css_string' ) . "\n";
        }

        $css .= auxin_get_option( 'extra_custom_css' );

        // Add custom CSS code of the page to header
        if( ! is_404() && ! empty( $post->ID ) ) {

            $post_ID = $post->ID;

            if ( class_exists( 'WooCommerce' ) ) {
                $post_ID = is_shop() ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
            }

            $css .= get_post_meta( $post_ID, 'aux_metafields_custom_styles', true );
            $css .= get_post_meta( $post_ID, 'aux_page_custom_css', true );
        }

        return $css;
    }



    /**
     * Adds custom scripts in page footer if inline custom js is set.
     *
     * @return void
     */
    function inline_footer_scripts( $js, $post ){

        // Force to add custom js inline if it was customizer preview
        if( is_customize_preview() ){
            $custom_js = auxin_get_theme_mod( 'custom_js_string' );
            $js .= $custom_js ? 'try{ '. $custom_js .' } catch(ex) { console.error( "Custom JS:", ex.message ); }' : '';

        } elseif( ! function_exists('AUXELS') || auxin_get_theme_mod( 'use_inline_custom_js', '' ) ){
            // if custom.js is not writable, print js scripts in page footer
            if( current_user_can( 'manage_options' ) ){
                $js .= "\n". sprintf( "// Note for admin: The custom.js file in [%s] is not writeable, so the theme uses inline js callback instead. \n",
                                      "wp-content/uploads/". THEME_ID. "/custom.js" );
            }
            $js .= auxin_get_theme_mod( 'custom_js_string', '' ) . "\n";
        }

        return $js;
    }


    /**
     * Load custom styles for skins on login page
     *
     * @return void
     */
    public function login_assets() {
        wp_register_style( 'login-auxin', ADMIN_CSS_URL. 'login.css', array('login'), $this->version );
        wp_print_styles( 'login-auxin' );
    }


    public function go_pricing_styles() {

        if ( class_exists( 'GW_GoPricing' ) || class_exists('AUXPRO') ) {
            wp_enqueue_style( 'auxin-go-pricing', THEME_URL . 'css/go-pricing.css', array(), $this->version );
        }

    }

    /**
     * Load inline styles in footer
     *
     * @return void
     */
    public function enqueue_style_in_footer() {
        wp_enqueue_style( 'auxin-inline-styles' );
    }

}

return new Auxin_Frontend_Assets();
