<?php
/**
 * Generates CSS for a slider option
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 *
 * Sample data model:
 * [
 *    'responsive-slider' => [
 *        '1024' => [
 *            'value' => 10,
 *            'unit'  => 'px'
 *        ],
 *        'desktop' => [
 *            'value' => 12,
 *            'unit'  => 'px'
 *        ]
 *    ]
 * ];
 */
class Auxin_CSS_Generator_Option_Slider extends Auxin_CSS_Generator_Option_Base{


    /**
     * Crawls all breakpoints, generates and collects CSS roles
     *
     * @param  array $breakpoints  Lits of breakpoints
     *
     * @return void
     */
    protected function walk_breakpoints( $breakpoints ){
        foreach( $breakpoints as $breakpoint => $breakpoint_values ){
            $placeholder = $this->placeholder;

            if( ! empty( $breakpoint_values['value'] ) ){
                $placeholder = str_replace( '{{VALUE}}', $breakpoint_values['value'], $placeholder );
                $placeholder = str_replace( '{{UNIT}}' , $breakpoint_values['unit'] , $placeholder );
                $this->stack_css( $placeholder, $breakpoint );
            }
        }
    }

}
