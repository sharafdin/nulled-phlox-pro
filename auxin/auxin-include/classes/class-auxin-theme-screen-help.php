<?php
/**
 * Class to add content to screen help
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;



class Auxin_Theme_Screen_Help {


  function __construct() {

        // Adds support tab under help screen
        add_action( 'admin_head', array( $this, 'display_support_info' ) , 10 );

        add_action( 'admin_head', array( $this, 'display_technical_info' ) , 10 );

        // if debaug mode is enabled display screen information in help tabs
        if( ! ( defined( 'WP_DEBUG' ) && ! WP_DEBUG ) || ( AUXIN_SUPPORT  && ! AUXIN_NO_BRAND ) ){
            add_action( 'admin_head', array( $this, 'display_screen_info' ) , 10 );
        }
  }


    /**
     * Display support info
     *
     */
    public function display_support_info() {

        $screen = get_current_screen();

        if ( is_null( $screen ) ) {
            return;
        }

        // List screen properties
        $help_content  = '<p><strong>'. sprintf( __( 'Below resources are available to help you in using %s theme.', 'phlox-pro' ), THEME_NAME_I18N ) .'</strong></p>';
        $help_content .= '<ul>';
        $help_content .= '<li>'. sprintf( __( 'A complete %s documentation %s, which updates regularly.', 'phlox-pro' ), '<a target="_blank" href="'. esc_url( 'http://avt.li/doc-wizard-'. THEME_ID ) .'">', '</a>' ) . '</li>';
        $help_content .= '<li>'. sprintf( 'A dedicated %s support forum %s, with expert staff waiting for you.', '<a target="_blank" href="'. esc_url( 'http://avt.li/ticket-' . THEME_ID ) .'">', '</a>' ) .'</li>';
        $help_content .= '<li>'. sprintf( 'Series of %s video tutorials %s, will be available soon.', '<a target="_blank" href="'. esc_url( 'http://avt.li/videos-' . THEME_ID ) .'">', '</a>' ) .'</li>';
        $help_content .= '<li>'. sprintf( 'You want more? %s sing up our newsletter %s to be the first one to get new features of %s theme.', '<a target="_blank" href="'. esc_url( 'http://avt.li/home-' . THEME_ID ) .'">', '</a>', THEME_NAME_I18N ) .'</li>';
        $help_content .= '<li>'. sprintf( 'Leave us a %s feedback %s, we always love hearing from our clients.', '<a target="_blank" href="'. self_admin_url( 'admin.php?page=auxin-welcome&tab=feedback') .'">', '</a>' ) .'</li>';
        $help_content .= '</ul>';

        // Add help panel
        $screen->add_help_tab(
            array(
                'id'        => 'auxin-support-info',
                'title'     => __( 'Phlox Support', 'phlox-pro' ),
                'content'   => $help_content
            )
        );

    }


    /**
     * Display Current admin screen information
     *
     */
    public function display_screen_info() {

        global $hook_suffix;
        $screen = get_current_screen();

        if ( is_null( $screen ) ) {
            return;
        }

        $screen_id = $screen->id;

        // List screen properties
        $variables = '<ul style="width:50%;float:left;"> <strong>Screen variables </strong>'
            . sprintf( '<li> Screen id : %s</li>' , $screen_id )
            . sprintf( '<li> Screen base : %s</li>', $screen->base )
            . sprintf( '<li> Parent base : %s</li>', $screen->parent_base )
            . sprintf( '<li> Parent file : %s</li>', $screen->parent_file )
            . sprintf( '<li> Hook suffix : %s</li>', $hook_suffix )
            . '</ul>';

        // Append global $hook_suffix to the hook stems
        $hooks = array(
            "load-$hook_suffix",
            "admin_print_styles-$hook_suffix",
            "admin_print_scripts-$hook_suffix",
            "admin_head-$hook_suffix",
            "admin_footer-$hook_suffix"
        );

        // If add_meta_boxes or add_meta_boxes_{screen_id} is used, list these too
        if ( did_action( 'add_meta_boxes_' . $screen_id ) )
            $hooks[] = 'add_meta_boxes_' . $screen_id;

        if ( did_action( 'add_meta_boxes' ) ) $hooks[] = 'add_meta_boxes';

        $hooks = '<ul style="width:50%;float:left;"> <strong>Hooks </strong> <li>' . implode( '</li><li>', $hooks ) . '</li></ul>';

        // Combine $variables list with $hooks list.
        $help_content = $variables . $hooks;

        // Add help panel
        $screen->add_help_tab(
            array('id' => 'auxin-screen-help',
                'title'=> 'Screen Information',
                'content' => $help_content,
            )
        );

    }


    /**
     * Display technical info about web server configs
     *
     */
    public function display_technical_info() {

        $screen = get_current_screen();

        if ( is_null( $screen ) ) {
            return;
        }

        // List screen properties
        $help_content  = '<ul style="width:50%;float:left;"> <strong>Web server</strong>';
        $help_content .= '<li>php version : ' . phpversion(). '</li>';
        $help_content .= $this->get_ini_val('max_execution_time'     , 'max_execution_time');
        $help_content .= $this->get_ini_val('max_file_uploads'       , 'max_file_uploads');
        $help_content .= $this->get_ini_val('max_input_nesting_level', 'max_input_nesting_level');
        $help_content .= $this->get_ini_val('max_input_time'         , 'max_input_time');
        $help_content .= $this->get_ini_val('max_input_vars'         , 'max_input_vars');
        $help_content .= $this->get_ini_val('memory_limit'           , 'memory_limit');
        $help_content .= $this->get_ini_val('post_max_size'          , 'post_max_size');
        $help_content .= $this->get_ini_val('upload_max_filesize'    , 'upload_max_filesize');
        $help_content .= $this->get_ini_val('output_buffering'       , 'output_buffering');
        $help_content .= $this->get_ini_val('short_open_tag'         , 'short_open_tag');

        if( function_exists('get_filesystem_method') )
            $help_content .= sprintf( '<li> FileSystem : %s</li>', get_filesystem_method(array(), THEME_DIR) );

        $help_content .= '</ul>';


        $help_content .= '<ul style="width:50%;float:left;"> <strong>Web server</strong>';

        if(function_exists("get_loaded_extensions"))
        $help_content .= sprintf( '<li> Extentions : %s</li>', implode(' ,', get_loaded_extensions()));

        if(extension_loaded('suhosin'))
        $help_content .= '<li> Suhosin : Available</li>';

        if(!function_exists('mb_strwidth'))
        $help_content .= '<li> mb_* package : Unavailable. You need to enable it.</li>';

        $help_content .= '</ul>';


        // Add help panel
        $screen->add_help_tab(
            array('id' => 'auxin-technical-info',
                'title'=> 'Technical Information',
                'content' => $help_content,
            )
        );
    }


    private function get_ini_val( $label , $var ){
        $value = ini_get($var);
        return $value === false?"":sprintf( '<li> %s : %s</li>', $label, $value );
    }

}
