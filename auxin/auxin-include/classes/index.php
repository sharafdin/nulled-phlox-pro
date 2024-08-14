<?php
/**
 * Include classes
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

if( is_admin() ){

    // Assigning capabilities and option on theme install
    new Auxin_Theme_Screen_Help();

    // Register required assets (scripts & styles)
    new Auxin_Admin_Assets();

    // Parse and load fonts
    Auxin_Fonts::get_instance();
}

// Init Master Menu navigation
Auxin_Master_Nav_Menu::get_instance();

