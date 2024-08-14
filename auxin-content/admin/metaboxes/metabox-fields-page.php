<?php
/**
 * Add page option meta box
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

/*======================================================================*/

function auxin_push_metabox_models_page( $models ){

    // Attach general common metabox models to hub
    $models[] = array(
        'model'     => auxin_metabox_fields_general_layout(),
        'priority'  => 1
    );
    $models[] = array(
        'model'     => auxin_metabox_fields_general_title(),
        'priority'  => 5
    );
    $models[] = array(
        'model'     => auxin_metabox_fields_general_background(),
        'priority'  => 6
    );
    $models[] = array(
        'model'     => auxin_metabox_fields_general_slider(),
        'priority'  => 7
    );
    return $models;
}

add_filter( 'auxin_admin_metabox_models_page', 'auxin_push_metabox_models_page' );
