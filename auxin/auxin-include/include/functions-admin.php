<?php
/**
 * Admin Functions.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */


/**
 * Adds and collects custom css styles
 *
 * @param  string $content    New content for writing in the file - If you pass nothing, the file will be rewritten again
 * @param  string $ref_name   A reference name for referring a content in future - In fact, this name is a key in $css_array array
 *
 * @return boolean            Returns true if the file is created and updated successfully, false if could be written in file, null if using filesystem is not allowed
 */
function auxin_add_custom_css( $content = '', $ref_name = '' ){

    // retrieve the css array list
    $css_array = auxin_get_theme_mod( 'custom_css_array', array() );

    if( ! empty( $content ) ){
        if( ! empty( $ref_name ) ){
            $css_array[ $ref_name ] = $content;
        } else {
            $css_array[] = $content;
        }
    }


    // You can modify custom css content by using this filter (For instance, you can inject extra content in)
    // While passing custom css content, you are expected to inject array node in main array
    $css_array  = apply_filters( 'auxin_custom_css_file_content', $css_array );
    $css_string = '';

    $sep_comment = apply_filters( 'auxin_custom_css_sep_comment', "/* %s \n=========================*/\n" );

    // remove empty nodes
    $css_array  = array_filter( $css_array );
    $css_string = '';

    // Convert the contents in array to string
    if( is_array( $css_array ) ){
        foreach ( $css_array as $node_ref => $node_content ) {
            if( ! is_numeric( $node_ref) ){
                $css_string .= sprintf( $sep_comment, str_replace( '_', '-', $node_ref ) );
            }
            $css_string .= "$node_content\n";
        }
    }

    // Filter the custom css before saving as an option
    $css_string = apply_filters( 'auxin_custom_css_string', $css_string, $css_array );

    // store css content in database for third party purposes
    set_theme_mod( 'custom_css_string' , $css_string );
    set_theme_mod( 'custom_css_array'  , $css_array  );

    return function_exists( 'auxin_save_custom_css' ) ? auxin_save_custom_css() : null;
}



/**
 * Adds and collects custom JavaScript blocks
 *
 * @param  string $content    New content for writing in the file - If you pass nothing, the file will be rewritten again
 * @param  string $ref_name   A reference name for referring a content in future - In fact, this name is a key in $js_array array
 *
 * @return boolean            Returns true if the file is created and updated successfully, false if could be written in file, null if using filesystem is not allowed
 */
function auxin_add_custom_js( $content = '', $ref_name = '' ){

    // retrieve the js array list
    $js_array = auxin_get_theme_mod( 'custom_js_array', array() );

    if( ! empty( $content ) ){
        if( ! empty( $ref_name ) ){
            $js_array[ $ref_name ] = $content;
        } else {
            $js_array[] = $content;
        }
    }

    // You can modify custom JavaScript content by using this filter (For instance, you can inject extra content in)
    // While passing custom javascript content, you are expected to inject array node in main array
    $js_array  = apply_filters( 'auxin_custom_js_file_content', $js_array );
    $js_string = '';

    $js_array = array_filter( $js_array );

    // Convert the contents in array to string
    if( is_array( $js_array ) ){
        foreach ( $js_array as $node_ref => $node_content ) {
            if( ! is_numeric( $node_ref) ){
                $js_string .= "/* $node_ref \n=========================*/\n";
            }
            $js_string .= "$node_content\n";
        }
    }

    // Filter the custom js before saving as an option
    $js_string = apply_filters( 'auxin_custom_js_string', $js_string, $js_array );

    // store javascript content in database for third party purposes
    set_theme_mod( 'custom_js_string', $js_string );
    set_theme_mod( 'custom_js_array' , $js_array  );

    return function_exists( 'auxin_save_custom_js' ) ? auxin_save_custom_js() : null;
}


/**
 * Collect and return the demo info list
 *
 * @return array    The list of demo data
 */
function auxin_get_demo_info_list(){
    return apply_filters( 'auxin_get_demo_info_list', array() );
}


/**
 * Get install link
 *
 * @param  string  $plugin_slug The plugin slug
 *
 * @return string               Install plugin link
 */
function auxin_get_plugin_install_link( $plugin_slug ){

    // sanitize the plugin slug
    $plugin_slug = esc_attr( $plugin_slug );

    $install_link  = wp_nonce_url(
        add_query_arg(
            array(
                'action' => 'install-plugin',
                'plugin' => $plugin_slug,
            ),
            network_admin_url( 'update.php' )
        ),
        'install-plugin_' . $plugin_slug
    );

    return $install_link;
}

/**
 * Get plugin activate link
 *
 * @return string               Activate plugin link
 */
function auxin_get_plugin_activation_link( $plugin_base_name, $slug, $plugin_filename ) {
    $activate_nonce = wp_create_nonce( 'activate-plugin_' . $slug .'/'. $plugin_filename );
    return self_admin_url( 'plugins.php?_wpnonce=' . $activate_nonce . '&action=activate&plugin='. str_replace( '/', '%2F', $plugin_base_name ) );
}

/**
 * Retrieves the admin welcome page class
 *
 * @return Auxin_Welcome instance
 */
function auxin_welcome_page(){
    return class_exists('Auxin_Welcome') ? Auxin_Welcome::get_instance() : Auxin_Welcome_Base::get_instance();
}
