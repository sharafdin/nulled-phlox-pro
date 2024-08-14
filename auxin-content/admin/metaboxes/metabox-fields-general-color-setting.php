<?php
/**
 * Add color setting meta box Model
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

function auxin_metabox_fields_general_colors(){

    $model         = new Auxin_Metabox_Model();
    $model->id     = 'general-color';
    $model->title  = __('General Setting', 'phlox-pro' );
    $model->fields = array(

        array(
            'title'         => __('Custom Featured Color?', 'phlox-pro'),
            'description'   => __('By default custom feature color of all posts are the same as the color defined in theme options. You have to enable this option if you want to define custom feature color for this post.', 'phlox-pro'),
            'id'            => 'auxin_featured_color_enabled',
            'type'          => 'switch',
            'default'       => 0
        ),

        array(
            'title'         => __('Featured Color', 'phlox-pro'),
            'description'   => __('Custom featured color for this post.', 'phlox-pro'),
            'id'            => 'auxin_featured_color',
            'dependency'    => array(
                array(
                    'id'       => 'auxin_featured_color_enabled',
                    'value'    => '1',
                    'operator' => '=='
                )
            ),
            'type'          => 'color',
            'default'       => esc_attr( auxin_get_option('post_single_featured_color', '#1bb0ce') )
        )

    );

    return $model;
}
