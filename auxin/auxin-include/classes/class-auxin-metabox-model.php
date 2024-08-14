<?php
/**
 * Class for modeling data for custom metabox
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') ) {
    die();
}



class Auxin_Metabox_Model {

    public function __construct() { }

    // Properties ////////////////////

    public $fields   = array();
    public $id       = "";
    public $title    = "";
    public $type     = array();
    public $context  = 'normal';
    public $priority = 'default';
    public $css_class= '';

    /**
     * deprecation variable
     *
     * @var bool
     */
    public $is_deprecated;

    // Methods /////////////////////

    /**
     * A filter hook which let you manipulate options of custom meta fields in auxin framework
     *
     * @return array   fields list
     */
    public function get_filtered_fields() {

        /**
         *
         * @example
         *
         *   function my_custom_metabox_fields( $fields, $metabox_id, $post_type ) {
         *
         *      if( 'axi_page_option_meta_box' == $metabox_id && in_array( 'page', $post_type ) ){
         *          $new_field = array(
         *              'name'  => __( 'Field name', 'phlox-pro' ),
         *              'desc'  => __( 'Field description', 'phlox-pro' ),
         *              'id'    => 'field_id',
         *              'type'  => 'dropdown',
         *              'options' => array( 'value1' => __('Label 1', 'phlox-pro' ), 'value2' => __( 'Label 2', 'phlox-pro' ) )
         *          );
         *
         *          array_unshift( $fields, $new_field );
         *      }
         *      return $fields;
         *   }
         *
         *   add_filter( 'auxin_metabox_fields', 'my_custom_metabox_fields', 10, 3 );
        */

        return apply_filters( 'auxin_metabox_fields', $this->fields, $this->id, $this->type );
    }


    /**
     * A filter hook which let you add or remove the fields of this class to other post types
     *
     * @return array   type list
     */
    public function get_filtered_types() {

        /**
         *
         * @example
         *
         *   function my_custom_metabox_type( $post_type, $metabox_id ) {
         *
         *       $post_type[] = 'PAGE';
         *       return $post_type;
         *   }
         *
         *   add_filter( 'auxin_metabox_type', 'my_custom_metabox_type', 10, 3 );
        */

        return apply_filters( 'auxin_metabox_type', $this->type, $this->id );
    }

}
