<?php
/**
 * Admin hooks
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

function auxin_update_font_icons_list(){
    // parse and cache the list of fonts
    $fonts = Auxin()->Font_Icons;
    $fonts->update();
}
add_action( 'after_switch_theme', 'auxin_update_font_icons_list' );


// make the customizer avaialble while requesting via ajax
if ( defined('DOING_AJAX') && DOING_AJAX && version_compare( PHP_VERSION, '5.3.0', '>=') ){
    Auxin_Customizer::get_instance();
}


global $pagenow;
// redirect to welcome page after theme activation
if ( ! empty( $_GET['activated'] ) && 'true' == $_GET['activated'] && $pagenow == "themes.php" && defined('AUXELS_VERSION') ){
    wp_redirect( self_admin_url('admin.php?page=auxin-welcome') );
}

/**
 * Include the Welcome page admin menu
 *
 * @return void
 */
function auxin_setup_admin_welcome_page() {
    if( class_exists('Auxin_Welcome') ){
        Auxin_Welcome::get_instance();
    } else {
        Auxin_Welcome_Base::get_instance();
    }
}
add_action( 'auxin_admin_loaded', 'auxin_setup_admin_welcome_page' );


/*------------------------------------------------------------------------*/

/**
 * Update the deprecated option ids
 */
function auxin_update_last_checked_version(){

    $last_checked_version = auxin_get_theme_mod( 'last_checked_version', '1.0.0' );

    if( version_compare( $last_checked_version, THEME_VERSION, '>=') ){
        return;
    }

    do_action( 'auxin_theme_updated', $last_checked_version );
    do_action( 'auxin_updated'      , 'theme', THEME_ID, THEME_VERSION, THEME_ID );

    set_theme_mod( 'last_checked_version', THEME_VERSION );
}
add_action( 'auxin_loaded', 'auxin_update_last_checked_version' );


function auxin_maybe_inherit_lite_theme_mods(){

    if( ! auxin_get_theme_mod( 'are_pro_options_inherited', 0 ) ){
        $current_theme = get_stylesheet();

        // try to inherit the auxin options
        if( ! $source_options = get_option( 'phlox' ."-child_theme_options" ) ){
            $source_options = get_option( 'phlox' ."_theme_options" );
        }
        if ( ! empty( $source_options ) ) {
            update_option( "{$current_theme}_theme_options", $source_options );
        }
        
        $id = get_theme_mod('custom_logo');

        // inherit the logo from lite version
        if( ! get_theme_mod('custom_logo') ){
            // try to inherit from child lite version
            if( ( $lite_child_mods = get_option( "theme_mods_" . 'phlox' . "-child" ) ) && ! empty( $lite_child_mods['custom_logo'] ) ){
                set_theme_mod('custom_logo', $lite_child_mods['custom_logo'] );
            // try to inherit from main lite version
            } elseif( ( $lite_parent_mods = get_option( "theme_mods_" . 'phlox' ) ) && ! empty( $lite_parent_mods['custom_logo'] ) ){

                set_theme_mod('custom_logo', $lite_parent_mods['custom_logo'] );
            }
        }

        // inherit custom css from lite version
        if ( ! wp_get_custom_css() ) {
            if ( $lite_custom_css = wp_get_custom_css( 'phlox' . "-child" ) ) {
               wp_update_custom_css_post( $lite_custom_css ) ;
            } elseif ( $lite_custom_css = wp_get_custom_css( 'phlox' ) ) {
               wp_update_custom_css_post( $lite_custom_css ) ;
            }
        }
        set_theme_mod( 'are_pro_options_inherited', 1 );
    }

}

add_action( 'auxin_admin_loaded', 'auxin_maybe_inherit_lite_theme_mods' );


/**
 * Skip the notice for core plugin if skip btn clicked
 *
 * @return void
 */
function auxin_hide_required_plugin_notice() {

    if ( isset( $_GET['aux-hide-core-plugin-notice'] ) && isset( $_GET['_notice_nonce'] ) ) {
        if ( ! wp_verify_nonce( $_GET['_notice_nonce'], 'auxin_hide_notices_nonce' ) ) {
            wp_die( __( 'Authorization failed. Please refresh the page and try again.', 'phlox-pro' ) );
        }
        auxin_set_transient( 'auxin_hide_the_core_plugin_notice_' . THEME_ID, 1, 4 * YEAR_IN_SECONDS );
    }

    if ( isset( $_GET['aux-hide-phlox-pro-tools-plugin-notice'] ) && isset( $_GET['_notice_nonce'] ) ) {
        if ( ! wp_verify_nonce( $_GET['_notice_nonce'], 'auxin_hide_notices_nonce' ) ) {
            wp_die( __( 'Authorization failed. Please refresh the page and try again.', 'phlox-pro' ) );
        }
        auxin_set_transient( 'auxin_hide_phlox_pro_tools_plugin_notice_' . THEME_ID, 1, 4 * YEAR_IN_SECONDS );
    }

    if ( isset( $_GET['aux-show-install-core-plugin-notice'] ) && isset( $_GET['_notice_nonce'] ) ) {
        if ( ! wp_verify_nonce( $_GET['_notice_nonce'], 'auxin_hide_notices_nonce' ) ) {
            wp_die( __( 'Authorization failed. Please refresh the page and try again.', 'phlox-pro' ) );
        }
        auxin_delete_transient( 'auxin_hide_phlox_pro_tools_plugin_notice_' . THEME_ID );
        auxin_delete_transient( 'auxin_hide_the_core_plugin_notice_' . THEME_ID );
    }
}
add_action( 'wp_loaded', 'auxin_hide_required_plugin_notice' );


/**
 * Display a notice for installing theme core plugin
 *
 * @return void
 */
function auxin_core_plugin_notice(){
    if ( auxin_get_transient( 'auxin_hide_the_core_plugin_notice_' . THEME_ID ) ) {
        return;
    }
    $is_pro_tools_plugin_active = false;
    if( defined( 'AUXELS_VERSION' ) ) {
        if ( $is_pro_tools_plugin_active = auxin_is_plugin_active( 'auxin-pro-tools/auxin-pro-tools.php' ) ) {
        if( class_exists( '\Elementor\Plugin' ) ){
            return;
        }
        }
    }

    $plugins_base_name = array(
        'auxin-elements/auxin-elements.php',
        'elementor/elementor.php'
    );
    $plugins_slug      = array(
        'auxin-elements',
        'elementor'
    );
    $plugins_filename  = array(
        'auxin-elements.php',
        'elementor.php'
    );
    $plugins_title     = array(
        __('Phlox Core Plugin', 'phlox-pro'),
        __('Elementor', 'phlox-pro')
    );
    // Classess to check if plugins are active or not
    $class_check = array(
        'AUXELS',
        '\Elementor\Plugin'
    );

    if( ! $is_pro_tools_plugin_active ){
        $plugins_base_name[] = 'auxin-pro-tools/auxin-pro-tools.php';
        $plugins_slug[]      = 'auxin-pro-tools';
        $plugins_filename[]  = 'auxin-pro-tools.php';
        $plugins_title[]     = __('Phlox Pro Tools Plugin', 'phlox-pro');
        $class_check[] = 'AUXPRO';
    }

    $installed_plugins  = get_plugins();

    // find required plugins which is not installed or active
    $not_installed_or_activated_plugins_id = array();
    foreach ( $plugins_base_name as $key => $plugin_base_name ) {
        if( ! isset( $installed_plugins[ $plugin_base_name ] ) || ! class_exists( $class_check[$key] ) ){
            $not_installed_or_activated_plugins_id[] = $key;
        }
    }

    // get information of required plugins which is not installed or not activated
    foreach ( $not_installed_or_activated_plugins_id as $key => $value ) {

        $not_installed_plugins_number = count( $not_installed_or_activated_plugins_id );
        $progress_text = $not_installed_plugins_number > 1 ? ( $key + 1 ). " / {$not_installed_plugins_number}" : "";
        $progress_text_and_title = $progress_text . ' - ' .$plugins_title[ $value ];

        $links_attrs[$key] = array(
            'data-plugin-slug'      => $plugins_slug[$value],

            'data-activating-label' => sprintf( __( 'Activating %s', 'phlox-pro' ), $progress_text_and_title ),
            'data-installing-label' => sprintf( __( 'Installing %s', 'phlox-pro' ), $progress_text_and_title ),
            'data-activate-label'   => sprintf( __( 'Activate %s'  , 'phlox-pro' ), $progress_text_and_title ),
            'data-install-label'    => sprintf( __( 'Install %s'   , 'phlox-pro' ), $progress_text_and_title ),

            'data-activate-url'     => auxin_get_plugin_activation_link( $plugins_base_name[$value], $plugins_slug[$value], $plugins_filename[$value] ),
            'data-install-url'      => auxin_get_plugin_install_link( $plugins_slug[$value] ),

            'data-redirect-url'     => self_admin_url( 'admin.php?page=auxin-welcome' ),
            'data-num-of-required-plugins' => $not_installed_plugins_number,
            'data-plugin-order'     => $key + 1,
            'data-wpnonce'          => wp_create_nonce( 'aux_setup_nonce' )
        );

        if( ! isset( $installed_plugins[ $plugins_base_name[$value] ] ) ){
            $links_attrs[$key]['data-action'] = 'install';
            $links_attrs[$key]['href'] = $links_attrs[ $key ]['data-install-url'];
            $links_attrs[$key]['button_label'] = sprintf( esc_html__( 'Install %s', 'phlox-pro' ), $progress_text_and_title );
        } elseif( ! class_exists( $class_check[ $value ] ) ) {
            $links_attrs[$key]['data-action'] = 'activate';
            $links_attrs[$key]['href'] = $links_attrs[ $key ]['data-activate-url'];
            $links_attrs[$key]['button_label'] = sprintf( esc_html__( 'Activate %s', 'phlox-pro' ), $progress_text_and_title );
        }
    }
?>
    <div class="updated auxin-message aux-notice-wrapper aux-notice-install-now">
        <h3 class="aux-notice-title"><?php printf( __( 'Thanks for choosing %s', 'phlox-pro' ), THEME_NAME_I18N ); ?></h3>
        <p class="aux-notice-description"><?php echo __( 'To take full advantages of Phlox theme and enabling demo importer, please install core plugins.', 'phlox-pro' ); ?></p>
        <p class="submit">
            <a class="button button-primary auxin-install-now aux-not-installed" data-info='<?php echo wp_json_encode( $links_attrs);?>' ><?php echo $links_attrs[0]['button_label']; ?></a>
            <a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'aux-hide-core-plugin-notice', 'install' ), 'auxin_hide_notices_nonce', '_notice_nonce' ) ); ?>" class="notice-dismiss aux-close-notice"><span class="screen-reader-text"><?php _e( 'Skip', 'phlox-pro' ); ?></span></a>
        </p>
    </div>
<?php
}
add_action( 'admin_notices', 'auxin_core_plugin_notice' );




function auxin_customizer_device_options( $obj ) {
    if ( isset( $obj->devices ) && is_array( $obj->devices ) && ! empty( $obj->devices ) ): ?>
        <div class="axi-devices-option-wrapper" data-option-id="<?php echo esc_attr( $obj->id ); ?>">
            <span class="axi-devices-option axi-devices-option-desktop axi-selected" data-select-device="desktop">
                <img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/desktop.svg' ); ?>">
            </span>
            <?php foreach ( $obj->devices as $device => $title ): ?>
            <span class="axi-devices-option axi-devices-option-<?php echo esc_attr( $device ); ?>" data-select-device="<?php echo esc_attr( $device ); ?>">
                <img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/' . $device . '.svg' ); ?>" >
            </span>
            <?php endforeach ?>
        </div>
    <?php endif;
}

add_action( 'customize_render_control', 'auxin_customizer_device_options' );

