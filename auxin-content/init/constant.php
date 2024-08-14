<?php
/**
 * Defining Constants.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

/*-----------------------------------------------------------------------------------*/
/*  Define Global Vars
/*-----------------------------------------------------------------------------------*/

// theme name
$theme_data = wp_get_theme();


// this id is used as prefix in database option field names - specific for each theme
if( ! defined('THEME_ID' )       ) define( 'THEME_ID'        ,  'phlox-pro' );
if( ! defined('THEME'.'_DOMAIN') ) define( 'THEME'.'_DOMAIN' ,  'phlox-pro' );

if( ! defined('THEME_NAME')      ) define( 'THEME_NAME'      , esc_attr( $theme_data->Name ) );

/*-----------------------------------------------------------------------------------*/
