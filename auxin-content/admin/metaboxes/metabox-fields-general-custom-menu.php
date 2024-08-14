<?php
/**
 * Add custom menu meta box Model
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

function auxin_metabox_fields_custom_menu(){

    $model          = new Auxin_Metabox_Model();
    $model->id      = 'custom-menu';
    $model->title   = __('Custom Menu', 'phlox-pro');
    $model->context = 'side';
    $model->type    = array('page', 'service', 'faq');


    // get list of nav menus
    $nav_menus = wp_get_nav_menus();
    $nav_menu_list   = array( '' => __('- no custom menu -', 'phlox-pro') );

    if( isset( $nav_menus ) && !empty( $nav_menus ) ) {

         foreach( (array) $nav_menus as $_nav_menu ) {
            $nav_menu_list[ esc_attr($_nav_menu->term_id) ] = $_nav_menu->name;
        }
    }

    $model->fields= array(
        "menu" => array(
            'title'         => __('Menu', 'phlox-pro'),
            'description'   => __('Select one of the custom sidebars. You can create new ones in "Option panel > Tools > Sidebar Generator".', 'phlox-pro'),
            'id'            => 'sidebar-id',
            'type'          => 'select',
            'choices'       => $nav_menu_list
        )
    );

    return $model;
}
