<?php
/**
 * Admin Asset Manager
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;



class Auxin_Admin_Assets {

    // default assets version
    private $version = '2.0.0';


    function __construct(){
        // set theme version
        $this->version = THEME_VERSION;

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue'  ) );

        add_action( 'admin_init', array( $this, 'add_editor_styles' ) );
    }


    public function enqueue( $hook_suffix ){
        // Enqueue styles and scripts
        $this->enqueue_admin_styles(  $hook_suffix );
        $this->enqueue_admin_scripts( $hook_suffix );

        // Print auxin javascript object
        $this->print_auxin_js_object( $hook_suffix );
    }


    /**
     * Add Admin styles
     *
     * @return void
     */
    public function enqueue_admin_styles( $hook_suffix ) {

        // register admin custom styles /////////////////////////////////////////////////
        wp_register_style('auxin-jquery-ui'        , ADMIN_CSS_URL. 'other/auxin-jquery-ui.css');
        if( auxin_is_currentpage_id('aux-news') ){
            wp_enqueue_style('auxin-jquery-ui');
        }

        // Enqueue admin custom styles /////////////////////////////////////////////////

        // Register and enqueue the font icons in admin pages
        wp_register_style( 'auxin-front-icon' , THEME_URL . 'css/auxin-icon.css', null, $this->version);
        wp_enqueue_style( 'auxin-front-icon' );

        wp_enqueue_style('auxin-admin-style', ADMIN_CSS_URL. 'admin.css', array(), $this->version );

        if( is_rtl() ){
            wp_enqueue_style( 'auxin-rtl-main', ADMIN_CSS_URL. 'rtl.css' );
        }

    }

    /**
     * Change the default font of TinyMCE to Open Sans
     */
    public function add_editor_styles(){
        $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Open+Sans:100,300,400,600,700' );
        add_editor_style( array( $font_url, ADMIN_CSS_URL. 'other/editor-style.css' ) );
    }


    /**
     * Add Admin Scripts
     *
     * @return void
     */
    public function enqueue_admin_scripts( $hook_suffix ) {
        global $pagenow;

        $screen = get_current_screen();

        // register admin custom scripts /////////////////////////////////////////////////

        // Base64 1.0
        wp_register_script('base64'       , ADMIN_JS_URL . 'solo/base64.js', null, "1.0" );

        // Ace editor
        wp_register_script('ace-editor'   , ADMIN_JS_URL . 'solo/ace/ace.js', null, "1.1.7");

        wp_enqueue_script('auxin_global'  , ADMIN_JS_URL . 'global.js'  , array( 'jquery', 'jquery-ui-core', 'json2' ), $this->version );

        // Contains all essential plugins
        wp_register_script( 'auxin_plugins' , ADMIN_JS_URL . 'plugins.js',
            array( 'auxin_global', 'jquery-ui-slider', 'jquery-ui-sortable', 'base64', 'ace-editor' ), $this->version
        );

        // Contains all general scripts
        wp_register_script( 'auxin_script'  , ADMIN_JS_URL . 'scripts.js' , array( 'auxin_plugins', 'media-upload' ), $this->version );


        // Enqueue admin custom scripts /////////////////////////////////////////////////


        if( auxin_is_theme_admin_page() ){
            // load media uploader
            wp_enqueue_media();
            wp_enqueue_script('auxin_script');
        }


        // on widgets page
        if( auxin_is_currentpage_id('phlox_page_auxin-system') ){
            wp_enqueue_script('auxin_plugins');
        }
    }


    /**
     * Create essential js global vars
     *
     * @return void
     */
    public function print_auxin_js_object( $hook_suffix ){
        global $post;

        $upload_dir = wp_get_upload_dir();

        wp_localize_script( 'auxin_global', 'auxin', apply_filters( 'auxin_admin_js_object', array(

            'themeurl'      => THEME_URL ,
            'themeid'       => THEME_ID ,
            'adminurl'      => self_admin_url(),
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),
            'uploadbaseurl' => $upload_dir['baseurl'],
            'earlyms'       => false,
            'admin'         => array(
                'ace' => array(
                    'showGutter'                => true,
                    'theme'                     => 'tomorrow',
                    'tabSize'                   => 4,
                    'useSoftTabs'               => true,
                    'maxLines'                  => 55,
                    'minLines'                  => 25,
                    'enableBasicAutocompletion' => true,
                    'execute'                   => esc_attr__('Execute', 'phlox-pro' )
                ),
                'visualIconSelector' => array(
                    'toggleBtnLabel' => esc_attr__('Visual Icon Selector', 'phlox-pro' )
                ),
                'fontSelector'  => array(
                    'previewTextLabel' => esc_attr__('Preview text:', 'phlox-pro' ),
                    'fontLabel'        => esc_attr__('Font:'        , 'phlox-pro' ),
                    'fontSizeLabel'    => esc_attr__('Size:'        , 'phlox-pro' ),
                    'fontStyleLabel'   => esc_attr__('Style:'       , 'phlox-pro' ),
                    'googleFonts'      => esc_attr__('Google Fonts' , 'phlox-pro' ),
                    'systemFonts'      => esc_attr__('System Fonts' , 'phlox-pro' ),
                    'geaFonts'         => esc_attr__('Google Early Access', 'phlox-pro' ),
                    'customFonts'      => esc_attr__('Custom Fonts' , 'phlox-pro' )
                ),
                'fonts'         => Auxin_Fonts::get_instance()->get_fonts_list(),
                'colorpicker'   => array(
                    'cancelText'    => esc_attr__('Cancel', 'phlox-pro' ),
                    'chooseText'    => esc_attr__('Apply' , 'phlox-pro' )
                )
            ),
            'post' => array(
                'id'    => ( isset( $post->ID ) ? $post->ID : '' )
            ),
            'l10n' => array(
                'installedMsg'          => __( 'Installation completed successfully.', 'phlox-pro' ),
                'unknownError'          => __( 'Something went wrong.', 'phlox-pro' ),
                'pluginInstalled'       => __( 'Installed!', 'phlox-pro' ),
                'installFailedShort'    => __( 'Installation Failed!', 'phlox-pro' ),
            )

        )));
    }

}
