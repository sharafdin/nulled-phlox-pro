<?php
/**
 * Generates CSS for a special option
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
class Auxin_CSS_Generator_Option_Manager{

    /**
     * List of instances of generators.
     */
    private $generator_instances = [];

    /**
     * The main CSS selector or placeholder
     *
     * @var string
     */
    private $selector = '';

    /**
     * The main CSS selector or placeholder
     *
     * @var string
     */
    private $placeholder = '';


    function __construct(){
        $this->generator_instances = [
            'responsive-slider'     => new Auxin_CSS_Generator_Option_Slider(),
            'responsive_dimensions' => new Auxin_CSS_Generator_Option_Dimensions(),
            'slider'                => new Auxin_CSS_Generator_Option_Slider(),
            'dimensions'            => new Auxin_CSS_Generator_Option_Dimensions(),
            'typography'            => new Auxin_CSS_Generator_Option_Typography(),
            'typography-hover'      => new Auxin_CSS_Generator_Option_Typography()
        ];
    }

    /**
     * Sets a CSS selector for styles.
     *
     * Sample: '.page-title'
     *
     * @param void
     */
    public function set_selector( $selector ){
        $this->selector = $selector;
    }

    /**
     * Decode the string if it is JSON-encoded
     *
     * @param  string $data  JSON encoded data
     * @return array
     */
    private function maybe_decode_json( $data ){
        if( is_string( $data ) ){
            $parsed = json_decode( $data, true );
            if( is_array( $parsed ) && ( json_last_error() == JSON_ERROR_NONE ) ){
                return $parsed;
            }
        }

       return $data;
    }

    /**
     * Retrieves the generated CSS for the option
     *
     * @param  string|array  $data  Option data
     * @return string               Final CSS for the option
     */
    public function get_css( $data, $selector = null , $placeholder = '' ){
        if( ! empty( $selector ) ){
            $this->selector = $selector;
        }

        if( ! empty( $placeholder ) ){
            $this->placeholder = $placeholder;
        }
        
        // Get parsed json
        $parsed_data = $this->maybe_decode_json( $data, true );

        foreach( $parsed_data as $option_type => $option_info ) {
            if( isset( $this->generator_instances[ $option_type ] ) ){
                $this->generator_instances[ $option_type ]->reset();
                
                if( in_array( $option_type, [ 'typography', 'typography-hover' ] ) ){
                    $this->generator_instances[ $option_type ]->set_selector( $this->selector );
                } else {
                    $this->generator_instances[ $option_type ]->set_selector( $this->selector );
                    $this->generator_instances[ $option_type ]->set_placeholder( $this->placeholder );
                }

                return $this->generator_instances[ $option_type ]->get_css( $parsed_data );
            }
        }

    }

}
