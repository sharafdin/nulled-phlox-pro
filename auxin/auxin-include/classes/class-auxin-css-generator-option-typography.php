<?php
/**
 * Generates CSS for a typography option
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 *
 * Sample data model:
[
    "typography-hover": [
        "normal": [
            "font-family": [
                "value": "ABeeZee:regular,italic",
                "type": "gFont"
            ],
            "color": "rgb(186, 216, 92)",
            "font-size-resp": [
                "desktop": [
                    "value": 23,
                    "unit": "px"
                ]
            ],
            "font-weight": "400",
            "text-transform": "uppercase",
            "font-style": "italic",
            "text-decoration": "underline",
            "line-height-resp": [
                "desktop": [
                    "value": 21,
                    "unit": "px"
                ]
            ],
            "letter-spacing-resp": [
                "desktop": [
                    "value": 1,
                    "unit": "px"
                ]
            ]
        ],
        "hover": [
            "font-family": [
                "value": "Abril Fatface:regular",
                "type": "gFont"
            ],
            "color": "rgb(92, 216, 119)",
            "font-size-resp": [
                "1024": [
                    "value": 23,
                    "unit": "px"
                ],
                "desktop": [
                    "value": 27,
                    "unit": "px"
                ]
            ],
            "font-weight": "400",
            "text-transform": "capitalize",
            "font-style": "normal",
            "text-decoration": "overline",
            "line-height-resp": [
                "1024": [
                    "value": 2,
                    "unit": "px"
                ],
                "desktop": [
                    "value": 21,
                    "unit": "px"
                ]
            ],
            "letter-spacing-resp": [
                "desktop": [
                    "value": 2,
                    "unit": "px"
                ]
            ]
        ]
    ]
]
 * 
 * 
 */
class Auxin_CSS_Generator_Option_Typography extends Auxin_CSS_Generator_Option_Base{

    /**
     * Crawls all controls if it is a group of controls
     *
     * @param  array $info  Controls data
     * @return void
     */
    protected function walk_control_groups( $groups ){
        foreach( $groups as $group_name => $group_info ) {
            // Backward compatibility for previous data 
            if( isset( $group_info['normal'] ) ){
                $this->walk_states( $group_info );
            } else {
                $this->set_current_stat( 'normal' );
                $this->walk_properties( $group_info );
            }
        }
    }

    /**
     * Crawls all CSS stats (normal, hover, active)
     *
     * @param  array $states  Control stats list
     * @return void
     */
    protected function walk_states( $states ){
        foreach( $states as $stat_name => $properties ) {
            $this->set_current_stat( $stat_name );
            $this->walk_properties( $properties );
        }
    }

    /**
     * Crawls all css properties
     *
     * @param  array $properties  List of various CSS properties
     * @return void
     */
    protected function walk_properties( $properties ){
        foreach ( $properties as $prop => $propValue ) {
            $prop = str_replace( '-resp', '', $prop );

            if( is_array( $propValue ) && $prop !== 'font-family' ){
                $this->walk_breakpoints( $propValue, $prop );
            } elseif( ! empty( $propValue ) && $css = $this->get_sanitized_rule_string( $prop, $propValue ) ) {
                $this->stack_css( $css, $this->defaults['breakpoint'], $prop );
            }
        }
    }

    /**
     * Crawls all breakpoints, generates and collects CSS roles
     *
     * @param  array $breakpoints  Lits of breakpoints
     *
     * @return void
     */
    protected function walk_breakpoints( $breakpoints, $prop ){

        foreach( $breakpoints as $breakpoint => $units ) {
            if( !empty( $units['value'] ) && !empty( $units['unit'] ) ){
                $css = $prop . ":" . $units['value'] . $units['unit'] . ";";
                $this->stack_css( $css, $breakpoint );
            }
        }

    }

    /**
     * Sanitizes a CSS rule
     */
    private function get_sanitized_rule_string( $prop, $value ){

        if( $prop == "font-family" ){
            $value = isset( $value['value'] ) ? $value['value'] : $value;
            $face  = strtok( $value, ':');
            if( 'none' === $face ){
                return '';
            }
            Auxin_Fonts::get_instance()->load_font( $face, $value );
            return $prop . ":'" . $face . "';";
        }

        return  $prop . ":" . $value . ";";
    }

}
