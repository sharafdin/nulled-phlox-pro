<?php
/**
 * Contact form 7 compatibility
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;

add_filter( 'option_element_pack_license_key', function( $value ) {
    return 'pro_license';
});