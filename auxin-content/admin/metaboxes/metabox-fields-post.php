<?php
/**
 * Add metaboxes for posts
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

/*======================================================================*/

function auxin_push_metabox_models_post( $models ){

    // Load general metabox models

    locate_template( AUXIN_CON . 'admin/metaboxes/metabox-fields-post-sidebar-layout.php', true, true );
    locate_template( AUXIN_CON . 'admin/metaboxes/metabox-fields-post-featured-image.php', true, true );
    locate_template( AUXIN_CON . 'admin/metaboxes/metabox-fields-post-content-setting.php', true, true );

    $models[] = array(
        'model'     => auxin_metabox_fields_post_sidebar_layout(),
        'priority'  => 10
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_general_colors(),
        'priority'  => 10
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_post_content_options(),
        'priority'  => 10
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_featured_image(),
        'priority'  => 10
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_general_title(),
        'priority'  => 10
    );

    $models[] = array(
        'model'     => auxin_metabox_fields_general_background(),
        'priority'  => 30
    );

    return $models;
}

add_filter( 'auxin_admin_metabox_models_post', 'auxin_push_metabox_models_post' );
