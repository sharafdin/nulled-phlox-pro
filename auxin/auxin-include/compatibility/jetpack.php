<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function auxin_jetpack_setup() {
    add_theme_support( 'infinite-scroll', array(
        'container' => 'main',
        'footer'    => 'page',
    ) );
}

add_action( 'after_setup_theme', 'auxin_jetpack_setup' );
