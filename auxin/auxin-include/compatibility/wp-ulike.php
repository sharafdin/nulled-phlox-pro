<?php
/**
 * WP Ulike compatibility
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;

/**
 *
 * hooked to wp_ulike_add_templates_args in single-post template
 *
 */
function auxin_change_like_icon ( $args ) {
    $like_class = (  'icon' === $like_type = auxin_get_option( 'blog_post_like_button_type', 'icon' ) ) ? ' aux-icon ' . auxin_get_option( 'blog_post_like_icon', 'auxicon-heart-2' ) : 'aux-has-text';

    $args['button_class'] .= ' ' . $like_class;
    if ( $like_type === 'text' ) {
        $args['button_type'] = 'text';
        $args['button_text'] = __( 'Like', 'phlox-pro' );
    }

    return $args;
}

?>