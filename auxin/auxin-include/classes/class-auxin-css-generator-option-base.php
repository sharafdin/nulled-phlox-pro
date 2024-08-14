<?php
/**
 * Base class for generating CSS for an option
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
class Auxin_CSS_Generator_Option_Base {

    /**
     * Keeps styles for various breakpoints
     *
     * @var array
     */
    protected $styles_list = [];

    /**
     * The main CSS selector
     *
     * Sample: '.page-title'
     *
     * @var string
     */
    protected $selector = '';

    /**
     * A CSS placeholder for replacing the special tags
     *
     * Sample: '.page-title{ max-width:{{SIZE}}{{UNIT}}; }'
     *
     * @var string
     */
    protected $placeholder = '';

    /**
     * Stores the current stat of CSS while parsing the styles
     *
     * values: 'normal', 'hover', 'active'
     *
     * @var string
     */
    protected $current_stat = 'normal';

    /**
     * Default configs
     *
     * @var array
     */
    protected $defaults = [
        'breakpoint' => 'desktop'
    ];


    function __construct(){
        $this->reset();
    }

    /**
     * Collects and stacks css rules in a list
     *
     * @param  string $css        a CSS string.
     * @param  string $breakpoint The breakpoint that the $css belongs to.
     * @param  string $css_id     An optional identification for this CSS string.
     *
     * @return void
     */
    protected function stack_css( $css, $breakpoint = '', $css_id = '', $stat = '' ){
        if( empty( $breakpoint ) ){
            $breakpoint = $this->defaults['breakpoint'];
        }

        if( empty( $stat ) ){
            $stat = $this->current_stat;
        }

        if( ! isset( $this->styles_list[ $stat ] ) ){
            $this->styles_list[ $stat ] = [
                $this->defaults['breakpoint'] => []
            ];
        }

        if( ! isset( $this->styles_list[ $stat ][ $breakpoint ] ) ){
            $this->styles_list[ $stat ][ $breakpoint ] = [];
        }

        if( ! empty( $css_id ) ){
            $this->styles_list[ $stat ][ $breakpoint ][ $css_id ] = $css;
        } else {
            $this->styles_list[ $stat ][ $breakpoint ][] = $css;
        }
    }

    /**
     * Sets a CSS selector for styles
     *
     * Sample: '.page-title'
     *
     * @param void
     */
    public function set_selector( $selector ){
        $this->selector = $selector;
    }

    /**
     * Sets a pleceholder that is consist of special tags
     *
     * Sample: '.page-title{ max-width:{{SIZE}}{{UNIT}}; }'
     *
     * @param void
     */
    public function set_placeholder( $placeholder ){
        $this->placeholder = $placeholder;
    }

    /**
     * Sets the current stat of CSS while stacking styles
     *
     * values: 'normal', 'hover', 'active'
     *
     * @param void
     */
    public function set_current_stat( $stat ){
        if( in_array( $stat, ['normal', 'hover', 'active'] ) ){
            $this->current_stat = $stat;
        }
    }

    /**
     * Walk through all groups (popovers) and collect styles
     *
     * @param  array $info  Controls data
     *
     * @return void
     */
    protected function walk_control_groups( $groups ){
        foreach( $groups as $group_name => $group_info ) {
            $this->walk_breakpoints( $group_info );
        }
    }

    /**
     * Generates final CSS based on parsed breakpoint list.
     *
     * @return string  Final CSS for the controller
     */
    protected function generate_css(){
        $result = array();

        foreach( $this->styles_list as $stat => $breakpoints ) {

            foreach( $breakpoints as $breakpoint => $styles ) {
                if( empty( $styles ) ){
                    continue;
                }
                // Join the list of styles for current breakpoint
                $styles = implode(" ", $styles);

                // If the selector is set, wrap the styles with selector
                if( ! empty( $this->selector ) ){
                    if( $stat === 'normal' ){
                        $styles = $this->selector . '{ ' . $styles . ' } ';
                    } else {
                        $styles = $this->selector . ':' . $stat . '{ ' . $styles . ' } ';
                    }
                }

                $result[] = $breakpoint === $this->defaults['breakpoint'] ? $styles : "@media(max-width: {$breakpoint}px){ {$styles} } ";
            }

        }

        return implode("\n", $result);
    }

    /**
     * Resets properties to default values
     *
     * @return void
     */
    public function reset(){
        $this->selector    = '';
        $this->placeholder = '';
        $this->styles_list = [
            'normal' => [
                'desktop' => [],
                '1024'    => [],
                '768'     => []
            ]
        ];
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
    public function get_css( $data ){

        $parsed_data = $this->maybe_decode_json( $data, true );
        $this->walk_control_groups( $parsed_data );

        return $this->generate_css();
    }

}
