<?php
/**
 * WPML compatibility
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


function auxin_the_single_post_languages(){
    if( ! function_exists( 'icl_get_languages' ) )
        return;

    $languages = icl_get_languages('skip_missing=1');

    if( 1 < count( $languages ) ){
        echo __( 'This is also available in: ', 'phlox-pro' );

        foreach( $languages as $l ){
            if( ! $l['active'] )
                $langs[] = '<a href="'.$l['url'].'">'.$l['translated_name'].'</a>';
        }
        echo join(', ', $langs );
    }
}


function auxin_language_selector_flags( $args = array() ){
    if( ! function_exists( 'icl_get_languages' ) )
        return;

    $defaults = array(
        'css_class' => ''
    );

    $args = wp_parse_args( $args, $defaults );

    $languages = icl_get_languages('skip_missing=0&orderby=code');

    if( ! empty( $languages ) ){
        echo '<div class="header_flags_lan_selector '. esc_attr( $args['css_class'] ) .'">';

        foreach( $languages as $l ){
            if( ! $l['active'] )
                echo '<a href="'.$l['url'].'" title="'.$l['translated_name'].'" >';

            echo '<img class="iclflag" src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';

            if( ! $l['active'] )
                echo '</a>';
        }

        echo '</div>';
    }
}


function auxin_languages_list_footer(){
    if( ! function_exists( "icl_get_languages" ) )
        return;

    $languages = icl_get_languages('skip_missing=0&orderby=code');

    if( ! empty( $languages ) ){
        echo '<div id="footer_language_list"><ul>';

        foreach($languages as $l){
            echo '<li>';
            if( $l['country_flag_url'] ){
                if( ! $l['active'] ) echo '<a href="'.$l['url'].'">';
                echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
                if( ! $l['active'] ) echo '</a>';
            }

            if( ! $l['active'] ) echo '<a href="'.$l['url'].'">';
            echo icl_disp_language($l['native_name'], $l['translated_name']);
            if( ! $l['active'] ) echo '</a>';
            echo '</li>';
        }

        echo '</ul></div>';
    }
}

/**
 * Returns markup for the language selector if wpml is activated
 *
 * @return string   The language selector markup based on the wpml setting
 */
 function auxin_get_language_selector( $args = array( 'css_class' => '' ) ){
    if( function_exists( 'icl_object_id' ) ){
        echo '<div class="aux-wpml-switcher '. esc_attr( $args['css_class'] ) .'">';
        do_action('wpml_add_language_selector');
        echo '</div>';
    }
}
