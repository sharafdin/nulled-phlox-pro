<?php
/**
 * Compatibility for following plugind is included:
 * - WPML
 * - SEO by Yoast
 * - All in on SEO Pack
 * - Jetpack
 * - Visual Composer
 * - WooCommerce
 * - Breadcrumb NavXT
 * - Related Posts
 * - Wordpress Popular Posts
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


// disable the automatic appending of related posts to the post content
add_filter( 'rp4wp_append_content', '__return_false' );


/*-----------------------------------------------------------------------------------*/
/*  WPML Custom Functions
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/wpml.php', true, true );

/*-----------------------------------------------------------------------------------*/
/*  Jetpack
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/jetpack.php', true, true );

/*-----------------------------------------------------------------------------------*/
/*  Jetpack
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/vc.php', true, true );

/*-----------------------------------------------------------------------------------*/
/*  WooCommerce
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/woocommerce.php', true, true );

/*-----------------------------------------------------------------------------------*/
/*  Wordpress Popular Posts
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/wordpress-popular-posts.php', true, true );

/*-----------------------------------------------------------------------------------*/
/*  Wordpress Popular Posts
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/go-pricing.php', true, true );

/*-----------------------------------------------------------------------------------*/
/*  Elementor and corresponding expensions
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/elementor.php', true, true );

/*-----------------------------------------------------------------------------------*/
/*  Contact form 7
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/cf7.php', true, true );

/*-----------------------------------------------------------------------------------*/
/*  WP Ulike
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/wp-ulike.php', true, true );

/*-----------------------------------------------------------------------------------*/
/*  Elements Pack
/*-----------------------------------------------------------------------------------*/
locate_template( AUXIN_INC. 'compatibility/elements-pack.php', true, true );