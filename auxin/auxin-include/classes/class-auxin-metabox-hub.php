<?php
/**
 * Class for creating custom metaboxes in tab view
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



class Auxin_Metabox_Hub extends Auxin_Metabox{

    public $models = array( '10' => array() );

    /**
     * Adds auxin_Metabox_Model to $models property
     *
     * @param $model    object  A metabox model containing fields for a single tab on Metabox Hub
     * @param $priority int     The priority of displaying metabox models (tabs) on Metabox Hub. Lower number than 10, mean higher priority
     *
     * @return  void
     */
    public function add_model( $model , $priority = 10 ){
        if( ! empty( $model ) ){
            if( ! isset( $this->models[ $priority ] ) ){
                $this->models[ $priority ] = array();
            }
            $this->models[ $priority ][] = $model;
        }

    }


    /**
     * Adds a list of auxin_Metabox_Model instance to $models property
     *
     * @param $model    object  A list of instances of Auxin_Metabox_Model class
     *                          sample: $model = array(
     *                              array( 'model' => $the_model_instance1, 'priority' => '10' ),
     *                              array( 'model' => $the_model_instance2, 'priority' => '10' )
     *                          )
     * @param $priority int     The priority of displaying metabox models (tabs) on Metabox Hub. Lower number than 10, mean higher priority
     *
     * @return  void
     */
    public function add_models( $models ){
        if( empty( $models ) ){
            return;
        }

        foreach ( $models as $model ) {
            if( isset( $model['model'] ) ){
                $priority = isset( $model['priority'] ) ? $model['priority'] : '10';

                if( $model['model'] instanceof Auxin_Metabox_Model ){
                    $this->add_model( $model['model'], $priority );
                } else {
                    auxin_error( 'The metabox model is not a valid instance of "Auxin_Metabox_Model" class' );
                    continue;
                }

            } elseif( $model instanceof Auxin_Metabox_Model ){
                $this->add_model( $model, '10' );
            } else {
                auxin_error( 'The metabox model is not a valid instance of "Auxin_Metabox_Model" class' );
                continue;
            }
        }

    }

    /**
     * Checked whether any model has been added to class or not
     *
     * @return  boolean      True if at least one model has been added to this class, otherwise, false
     */
    public function has_model(){
        if( count( $this->models ) > 1 || count( $this->models['10'] ) > 0 ){
            return true;
        }
        return false;
    }


    /**
     * Start to render and display meta fields if at least one model has been added
     *
     * @return void
     */
    public function maybe_render(){
        if( $this->has_model() ){
            $this->render();
        }
    }


    /**
     * Show Metabox Fields in Edit Page
     *
     * @return void
     */
    public function display_meta_box() {

        wp_nonce_field( $this->id , $this->id.'-nonce' );

        $layout_mode = $this->context == 'side' ? 'min_mode': "";

        // sort models base on prioriyies
        ksort( $this->models );

        echo '<div class="av3_container" >';
            printf('<div class="form-table meta-box axi-metabox-hub axi-metabox-container %s clearfix">', $layout_mode);

            $tabs_markup  = '';
            $tabs_contant = '';

            foreach ( $this->models as $model_group_id => $model_group ) {
                foreach( $model_group as $model ) {

                    $model->fields = $model->get_filtered_fields();
                    $model->fields = $this->sanitize_fields( $model->fields );

                    $tab_id             = ! empty( $model->id ) ? $model->id : sanitize_title( $model->title );
                    $tab_css_class      = 'aux-tab-' . $tab_id . ( empty( $model->css_class ) ? '' : ' '. $model->css_class );
                    $content_css_class  = ! empty( $model->css_class ) ? $model->css_class : 'aux-content-' . $tab_id;
                    $is_deprecated      =  isset( $model->is_deprecated ) && ! empty( $model->is_deprecated ) ? $model->is_deprecated : false;
                    $deprecated_markup  = $is_deprecated ? '<span class="aux-deprecated">' . __( 'Deprecated', 'phlox-pro' ) . '</span>' : '';

                    $tabs_markup  .= '<li class="'. esc_attr( $tab_css_class ) .'"><a href="#'.esc_attr( $tab_id ).'">'. esc_html( $model->title ) . ' ' . $deprecated_markup . '</a></li>';
                    $tabs_contant .= '<li id="'.esc_attr( $tab_id ).'" class="'.esc_attr( $content_css_class ).'">'. $this->get_fields_output( $model->fields ) .'</li>';
                }
            }

            echo    '<div class="hub-tabs-bg"></div>',
                    '<ul class="tabs">',
                        $tabs_markup,
                    '</ul>',

                    '<ul class="tabs-content">',
                        $tabs_contant,
                    '</ul>';

            echo   '</div>',
            '<div class="axi-metabox-loading"><span class="spinner is-active"></span><span class="axi-metabox-loading-label">'.__('Loading options..', 'phlox-pro' ).'</span></div>',
        '</div>';

        $this->print_dependencies();
    }


    /**
     * Save all meta fields in this metaboxes
     * @param  int $post_id The post id which the fields belong to that post.
     *
     * @return boolean      Returns true on sucess and false or int on failure
     */
    public function save_meta_box( $post_id ) {
        // get post object
        $post = get_post( $post_id );

        // Verify the nonce before proceeding.
        if ( ! isset( $_POST[$this->id.'-nonce'] ) || ! wp_verify_nonce( $_POST[$this->id.'-nonce'], $this->id ) ){
            return $post_id;
        }

        // Get the post type object.
        $post_type = get_post_type_object( $post->post_type );

        // Check if the current user has permission to edit the post.
        if ( ! current_user_can( $post_type->cap->edit_post, $post->ID ) ){
            return $post->ID;
        }

        // check autosave
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post->ID;
        }

        // reset custom styles
        $this->page_custom_css = '';

        // Loop through all fields in metabox models and save the values
        foreach ( $this->models as $model_group_id => $model_group ) {

            foreach( $model_group as $model ) {

                $model->fields = $model->get_filtered_fields();
                // sanitize the fields
                $model->fields = $this->sanitize_fields( $model->fields );

                foreach ( $model->fields as $field ) {
                    if( in_array( $field['type'], $this->exclude_to_save_field_types ) ) {
                        continue;
                    }
                    // store the field value
                    $field_value = $this->update_field( $field, $post );

                    // collect custom styles based on fields value
                    $this->collect_custom_styles( $field, $field_value );
                }

            }

        }

        $this->store_custom_styles( $post );

        return true;
    }


}
