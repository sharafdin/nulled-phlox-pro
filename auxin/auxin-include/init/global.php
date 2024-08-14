<?php
/**
 * Essential core functions here
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


/// Auto-load auxin classes on demand //////////////////////////////////////////


// Auto-load classes on demand
if ( function_exists( "__autoload" ) ) {
    spl_autoload_register( "__autoload" );
}
spl_autoload_register( 'auxin_classes_autoload' );



/**
 * Auto-load auxin classes on demand to reduce memory consumption
 *
 * @param mixed $class
 * @return void
 */
function auxin_classes_autoload( $class ) {
    $path  = null;
    $class = strtolower( $class );
    $file = 'class-' . str_replace( '_', '-', $class ) . '.php';

    // the possible pathes containing classes
    $possible_pathes = array(
        AUXIN_INC . 'classes/'
    );

    foreach ( $possible_pathes as $path ) {
        if( is_readable( THEME_DIR . $path . $file ) ){
            locate_template( $path . $file, true, true );
            return;
        }
    }
}


/// auxin Options //////////////////////////////////////////////////////////////


/**
 * Retrieves auxin options including saved and defined options
 *
 * @return  array    An array containing all auxin options
 */
function auxin_options(){
    return Auxin_option::api()->data->auxin_options;
}

/**
 * Retrieves only saved auxin options
 *
 * @return  array    An array containing all auxin options
 */
function auxin_get_options(){
    return get_option( THEME_ID.'_theme_options' , array() );
}


/**
 * Get all defined options (fields) that are hooked in auxin
 *
 * @return  array    An array containing all defined options
 */
function auxin_get_defined_options(){
    return Auxin_option::api()->data->defined_options;
}


/**
 * Get a list containing the default value of options
 *
 * @return  array    An array containing the default value of options
 */
function auxin_default_option_values(){
    return Auxin_option::api()->data->default_option_values;
}


/**
 * Get auxin option value
 *
 * @param   string  $option_name    A unique name for option
 * @param   string  $default_value  A value to return by function if option_value not found
 * @return  string|array            Option_value or default_value
 */
function auxin_get_option( $option_name, $default_value = '' ){
    if( ! $option_name ) return;

    /**
     * Filter the value of an existing option before it is retrieved.
     *
     * The dynamic portion of the hook name, `$option_name`, refers to the option name.
     *
     *
     * @param bool|mixed $pre_option   Value to return instead of the option value.
     *                                 Default false to skip it.
     * @param string     $option_name  Option name.
     */
    $pre = apply_filters( 'pre_auxin_option_' . $option_name, 'unpredictableZvidSidXisudpdido899e8', $option_name );
    if ( 'unpredictableZvidSidXisudpdido899e8' !== $pre )
        return $pre;


    $auxin_options = auxin_options();
    $option_value  = isset( $auxin_options[ $option_name ] ) ? $auxin_options[ $option_name ]: $default_value;

    return apply_filters( 'auxin_get_option', $option_value, $option_name, $default_value );
}


/**
 * Checks if needle exists in option value
 *
 * @param  string  $option_name   The option name to search in
 * @param  boolean $needle        The searched needle
 * @return boolean                Returns True if needle found in option, False otherwise
 */
function auxin_in_option( $option_name, $needle = true ){
    $option_val = (array) auxin_get_option( $option_name );

    if( is_bool( $needle ) ){
        $needle = $needle ? "true" : "false";
    }

    return in_array( $needle, $option_val ) ;
}


/**
 * Sanitize auxin options
 *
 * @param  array $raw_options Theme options in array
 * @return array              An array containing valid theme options
 */
function auxin_sanitize_options( $raw_options ){
    if( ! empty( $raw_options ) && is_array( $raw_options ) ){
        return $raw_options;
    }
    return array();
}


/**
 * Update option value in auxin options, if option_name does not exist then insert new option
 *
 * @param   string $option_name     A unique name for option
 * @param   string $option_value    The option value
 *
 * @return boolean                  True if option value has changed, false if not or if update failed.
 */
function auxin_update_option( $option_name, $option_value = '' ){
    if( ! $option_name ) return false;

    $auxin_options = auxin_options();
    $old_value     = ! empty( $auxin_options[ $option_name ] ) ? $auxin_options[ $option_name ] : null;

    /**
     * Filters an option before its value is (maybe) updated.
     *
     * @param mixed  $option_value     The new, unserialized option value.
     * @param string $option_name    Name of the option.
     * @param mixed  $old_value The old option value.
     */
    $option_value = apply_filters( 'pre_auxin_update_option', $option_value, $option_name, $old_value );

    // If the new and old values are the same, no need to update.
    if ( $option_value === $old_value )
        return false;

    $auxin_options = auxin_options();
    $auxin_options[ $option_name ] = $option_value;
    // update the auxin options cache
    Auxin_option::api()->data->auxin_options = $auxin_options;

    return update_option( THEME_ID.'_theme_options', $auxin_options );
}


/**
 * Update/overwrite all auxin options
 *
 * @param   string $option          All formatted options in an array
 *
 * @return boolean                  True if option value has changed, false if not or if update failed.
 */
function auxin_update_options( $options ){
    if( ! $options ) return false;

    // update current in use theme options
    $auxin_options = auxin_options();

    if( empty( $options ) || ! is_array( $options ) ){
        $options = array();
    }

    // pass the options through a filter and store them in formatted options
    $auxin_options = apply_filters( 'auxin_before_update_options', $options );
    // update the auxin options cache
    Auxin_option::api()->data->auxin_options = $auxin_options;

    // save formatted/usable options
    return update_option( THEME_ID.'_theme_options', $auxin_options );
}


/**
 * Define global variable auxin_content_layout
 *
 * @return string  th layout of current page
 */
function auxin_wp_global_variables(){
    global $auxin_content_layout, $post;

    if( empty( $post->ID ) ) return;
    if( 'default' === $content_layout = get_post_meta( $post->ID, 'content_layout', true ) ){
        $content_layout = auxin_get_option( 'page_content_layout' );
    }
    $auxin_content_layout = apply_filters( 'auxin_post_content_layout', $content_layout, $post );
}
add_action( 'wp', 'auxin_wp_global_variables' );
