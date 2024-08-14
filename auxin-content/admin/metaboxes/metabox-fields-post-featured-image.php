<?php
/**
 * Add featured image setting meta box Model
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

function auxin_metabox_fields_featured_image(){

    $model         = new Auxin_Metabox_Model();
    $model->id     = 'media-setting';
    $model->title  = __('Media Setting', 'phlox-pro' );
    $model->fields = array(

        array(
            'title'         => __('Display media on single post?', 'phlox-pro'),
            'description'   => __('Specifies whether to display the featured image, video or audio of this post on single page or not.', 'phlox-pro'),
            'id'            => 'blog_single_show_media',
            'type'          => 'dropdown',
            'default'       => 'default',
            'choices'     => array(
                'default' => __( 'Theme Default', 'phlox-pro' ),
                'yes'     => __( 'Yes, always' , 'phlox-pro' ),
                'no'      => __( 'No' , 'phlox-pro'  )
            )
        ),

        array(
            'title'         => __('Display featured image on archive blog?', 'phlox-pro'),
            'description'   => __('Specifies whether to display the featured image of this post on blog archive page or not. "Auto" means the featured image will be disabled automatically if there is an image in content too. Note: This option only applies to "image" and "standard" post format.', 'phlox-pro'),
            'id'            => 'blog_archive_show_featured_image',
            'type'          => 'dropdown',
            'default'       => 'auto',
            'choices'     => array(
                'default' => __( 'default', 'phlox-pro' ),
                'yes'     => __( 'Yes, always' , 'phlox-pro' ),
                'no'      => __( 'No' , 'phlox-pro'  )
            )
        )

    );

    return $model;
}
