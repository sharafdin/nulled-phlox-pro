<?php
/**
 * Add custom sidebar meta box Model
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

function auxin_metabox_fields_custom_sidebar(){

    $model          = new Auxin_Metabox_Model();
    $model->id      = 'custom-sidebar';
    $model->title   = __('Custom Sidebar', 'phlox-pro');
    $model->context = 'side';
    $model->type    = array('page', 'service', 'faq');

    // get list of generated sidebars
    $custom_sidebars = auxin_get_theme_mod( 'auxin_sidebars');
    $sidebars_list   = array( '' => __('--- no sidebar ---', 'phlox-pro') );

    if( isset( $custom_sidebars ) && !empty( $custom_sidebars ) ) {

        foreach( $custom_sidebars as $key => $val ){
            $sidebar_id = THEME_ID .'-'. strtolower( str_replace( ' ', '-', $val ) );
            $sidebars_list[ $sidebar_id ] = $val;
        }
    }

    $model->fields= array(
        "sidebar" => array(
            'title'         => __('Sidebars', 'phlox-pro'),
            'description'   => __('Select one of the custom sidebars. You can create new ones in "Option panel > Tools > Sidebar Generator"', 'phlox-pro'),
            'id'            => 'sidebar-id',
            'type'          => 'select',
            'choices'       => $sidebars_list
        ),

        array(
            'title'         => __('Hide Global Sidebar?', 'phlox-pro'),
            'description'   => __('It shows custom sidebar instead of global sidebar. Otherwise it shows custom Sidebar below global sidebar', 'phlox-pro'),
            'id'            => 'axi_not_show_global_sidebar',
            'type'          => 'checkbox',
            'default'       => '1'
        )
    );

    return $model;
}
