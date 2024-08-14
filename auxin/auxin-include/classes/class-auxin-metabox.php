<?php
/**
 * Class for creating single custom metabox
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



class Auxin_Metabox extends Auxin_Metabox_View{

    /**
     * Start to render and display meta fields
     *
     * @return void
     */
    public function render(){
        add_action('admin_menu', array( $this, 'add_meta_box' ) );
    }


    /**
     * Register all meta boxes and add save action hook
     */
    public function add_meta_box(){

        $this->fields = $this->get_filtered_fields();
        $this->type   = $this->get_filtered_types();

        foreach ( $this->type as $posttype ) {

            add_meta_box(   $this->id,
                            $this->title,
                            array( $this, 'display_meta_box' ),
                            $posttype,
                            $this->context,
                            $this->priority
                        );

        }

        add_action( 'save_post', array( $this, 'save_meta_box' ) );
    }

}
