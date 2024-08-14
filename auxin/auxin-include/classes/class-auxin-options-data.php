<?php
/**
 * Option panel model
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;



/**
*   Manages default options for option panel
*/
class Auxin_Options_Data {

    /**
     * List of sections and options
     *
     * @var array
     */
    public $data = array();




    /**
     * Magic method to set value for properties
     *
     * @param   string    The property name
     * @param   string    The property value
     * @return  bool      True, if the value was set to property successfully, False on failure.
     */
    public function __set( $name, $value ){

        // set default options for option panel
        if( 'default' === $name ){
            $this->data['unserialized_defaults'] = maybe_unserialize( $value );
            $this->data['serialized_defaults'  ] = maybe_serialize  ( $value );
            return true;
        }

        $this->data[ $name ] = $value;

        return true;
    }


    /**
     * Magic method to get the value of accessible properties
     *
     * @param   string   The property name
     * @return  string  The value of property
     */
    public function __get( $name ){

        // get default options for option panel
        if( 'default' == $name && isset( $this->data['unserialized_defaults'] ) ){
            return $this->data['unserialized_defaults'];
        }

        // filter the default capability for sections and fields
        if( 'default_capability' == $name ){
            if( empty( $this->data['default_capability'] ) ){
                $this->data['default_capability'] = apply_filters( 'auxin_option_default_capability', 'edit_theme_options' );
            }
            return $this->data['default_capability'];
        }

        // get parsed auxin option ( the main options list in auxin )
        if( 'auxin_options' == $name ){
            if( empty( $this->data['auxin_options'] ) ){
                $this->data['auxin_options'] = wp_parse_args(
                    get_option( THEME_ID.'_theme_options' , array() ),
                    $this->default_option_values
                );
            }
            return $this->data['auxin_options'];
        }

        // get the list of default values for options
        if( 'default_option_values' == $name ){
            if( empty( $this->data['default_option_values'] ) ){
                $this->data['default_option_values'] = array();
                /*
                 * Import theme starter content for fresh installs when landing in the customizer.
                 */
                $use_starter_content = get_option( 'fresh_site' ) && is_customize_preview() ? 1 : 0;

                foreach ( $this->fields as $field_info ) {
                    if( ! empty( $field_info['id'] ) ){
                        $this->data['default_option_values'][ $field_info['id'] ] = $use_starter_content && ! empty( $field_info['starter'] ) ?
                            $field_info['starter'] :
                            ( empty( $field_info['default'] ) ? '' : $field_info['default'] );

                    }
                }
            }
            return $this->data['default_option_values'];
        }

        // hook in and get defined options
        if( 'defined_options' == $name ){
            if( empty( $this->data['defined_options'] ) ){
                $this->data['defined_options'] = apply_filters( 'auxin_defined_option_fields_sections', array( 'fields' => array(), 'sections' => array() ) );
            }
            return $this->data['defined_options'];
        }

        // get the list of fields
        if( 'fields' == $name ){
            if( empty( $this->data['fields'] ) ){
                $this->data['fields'] = $this->defined_options['fields'];
            }
            return $this->data['fields'];
        }

        // get the list of sections
        if( 'sections' == $name ){
            if( empty( $this->data['sections'] ) ){
                $this->data['sections'] = $this->defined_options['sections'];
            }
            return $this->data['sections'];
        }

        // get the list of sidebars
        if( 'sidebars' == $name ){
            if( empty( $this->data['sidebars'] ) ){
                $this->data['sidebars'] = auxin_get_theme_mod( 'auxin_sidebars' );
            }
            return $this->data['sidebars'];
        }

        if( isset( $this->data[ $name ] ) ){
            return $this->data[ $name ];
        }

        return array();
    }

}
