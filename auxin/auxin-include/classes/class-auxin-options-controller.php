<?php
/**
 * Option panel controller
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


class Auxin_Options_Controller {
    /**
     * The option controller
     *
     * @var Auxin_Options_Data instance
     */
    public $model = null;



    function __construct( $model ){
        $this->model = $model;
    }

    //=== Add option section ===================================================

    public function add_sections( $sections ){
        if( is_array( $sections ) ){
            $this->model->sections = array_merge( $this->model->sections, $sections );
        }
        $this->sort_sections();
    }

    public function add_section( $section ){
        if( is_array( $section ) ){
            $this->model->sections[] = $section;
        }
    }

    //=== Add option field =====================================================

    public function add_fields( $fields ){
        if( is_array( $fields ) ){
            $this->model->fields = array_merge( $this->model->fields, $fields );
        }
        $this->sort_fields();
    }

    public function add_field( $field ){
        if( is_array( $field ) ){
            $this->model->fields[] = $field;
        }
    }

    //=== Get option field =====================================================

    public function get_fields(){
        return $this->model->fields;
    }

    public function get_field( $field_id ){

        $fields = $this->get_fields();
        foreach ( $fields as $field ) {
            if(  $field_id == $field['id'] ){
                return $field;
            }
        }
        return false;
    }

    //=== Get option sections ==================================================

    public function get_sections(){
        return $this->model->sections;
    }

    public function get_section( $section_id ){

        $sections = $this->get_sections();
        foreach ( $sections as $section ) {
            if(  $section_id == $section['id'] ){
                return $section;
            }
        }
        return false;
    }

    //=== Sort sections ========================================================

    /**
     * Sort and input (unsorted) fields by section id
     *
     * @return void
     */
    public function sort_fields(){

        $option_fields  = $this->get_fields();

        if( ! is_array( $option_fields ) ){
            return new WP_Error( 'auxin-options', 'No options is defined.' );
        }

        // classify options by sections
        $sorted_fields = array();

        foreach( $option_fields as $field ){

            // Sanitize the field
            $field = $this->_sanitize_field( $field );

            if( isset( $field['section'] ) ){
                $sorted_fields[ $field['section'] ][ $field['id'] ] = $field;
            }
        }

        $this->model->sorted_fields = apply_filters( 'auxin_option_panel_fields', $sorted_fields );

        return $this->model->sorted_fields;
    }

    /**
     * Sort and input (unsorted) sections by section id
     *
     * @return void
     */
    public function sort_sections(){

        $sections = $this->get_sections();

        if( ! is_array( $sections ) ){
            return new WP_Error( 'auxin-options', 'No section is defined.' );
        }

        // classify sections hierarchy
        $sorted_sections   = array();
        $unsorted_sections = array();

        foreach( $sections as $section ){
            $section = $this->_sanitize_section( $section );

            if( isset( $section['id'] ) ){
                if( ! empty( $section['parent'] ) ){
                    // If it is section
                    $sorted_sections[ $section['parent'] ][ $section['id'] ] = $section;
                } else {
                    // If it is Panel
                    $sorted_sections[ $section['id'] ][ $section['id'] ] = $section;
                }

                $unsorted_sections[ $section['id'] ] = $section;
            }
        }

        $this->model->sorted_sections = apply_filters( 'auxin_option_panel_sections', $sorted_sections );
        $this->model->sections        = $unsorted_sections;

        return $this->model->sorted_sections;
    }

    //=== Sanitize sections ====================================================

    private function _sanitize_section( $section ){

        if( ! isset( $section['parent'] ) ){
            $section['parent'] = '';
        }

        $section['title']           = isset( $section['title']      ) ? $section['title']       : '';
        $section['description']     = isset( $section['description']) ? $section['description'] : '';
        $section['priority']        = isset( $section['priority']   ) ? esc_attr( $section['priority']   ) : 10;
        $section['capability']      = isset( $section['capability'] ) ? esc_attr( $section['capability'] ) : $this->model->default_capability;
        $section['icon']            = isset( $section['icon']       ) ? esc_attr( $section['icon']       ) : '';
        $section['add_to']          = isset( $section['add_to']     ) ? esc_attr( $section['add_to']     ) : 'all';
        $section['active_callback'] = isset( $section['active_callback'] ) ? esc_attr( $section['active_callback'] ) : '';
        $section['preview_link']    = isset( $section['preview_link'] ) ? $section['preview_link']       : '';
        $section['dependency']      = isset( $section['dependency'] ) ? $section['dependency']       : '';
        $section['is_deprecated']   = isset( $section['is_deprecated'] ) ? $section['is_deprecated']       : false;

        return $section;
    }


    private function _sanitize_field( $field ){

        $field = wp_parse_args( $field, array(
            'type'                 => '',
            'capability'           => '',
            'theme_supports'       => '',
            'default'              => '',
            'choices'              => array(),
            'mode'                 => '',
            'description'          => '',
            'priority'             => 10,
            'transport'            => 'postMessage',
            'active_callback'      => '',
            'dependency'           => array(),
            'partial'              => array(),
            'post_js'              => '',
            'button_labels'        => array(),
            'style_callback'       => '',
            'selectors'            => '',
            'sanitize_callback'    => '',
            'placeholder'          => '',
            'sanitize_js_callback' => '',
            'devices'              => array(),
            'device'               => 'desktop',
            'related_controls'     => [],
            'description_color'    => '',
            'title_color'          => '',
            'icon_color'           => '',
            'margin_top'           => '',
            'margin_bottom'        => '',
            'separator'            => ''
        ));

        // sanitize the partial setting
        if( ! is_array( $field['partial'] ) ){
            $field['partial'] = (array) $field['partial'];
        }
        if( ! isset( $field['partial']['selector'] ) ){
            $field['partial']['selector'] = '';
        }
        if( ! isset( $field['partial']['render_callback'] ) ){
            $field['partial']['render_callback'] = '';
        }
        if( ! isset( $field['partial']['container_inclusive'] ) ){
            $field['partial']['container_inclusive'] = false;
        }

        // make sure a default capability is set
        if( empty( $field['capability'] ) ){
            $field['capability'] = 'edit_theme_options';
        }

        if( ! empty( $field['sanitize_callback'] ) ){
            $field['sanitize_callback'] = esc_url_raw( $field['sanitize_callback'] );
        }

        return $field;
    }

    /**
     * Gets current style options and stores them in a CSS file
     * This function will be called by option panel's save handler
     *
     * @return void
     */
    public function save_custom_styles(){
        // creates css query for loading google fonts, and registers css to enqueue by wp
        Auxin_Fonts::get_instance()->parse_typography();
        auxin_add_custom_css();
    }


    /**
     *  Gets current custom Javascript codes and stores them in a JS file
     *  This function will be called by option panel's save handler
     *
     *  @return void
     */
    public function save_custom_scripts(){
        auxin_add_custom_js();
    }


    /**
     * Generates and stores the custom asset files
     *
     * @return void
     */
    public function save_custom_assets(){
        $this->save_custom_styles();
        $this->save_custom_scripts();
    }

}
