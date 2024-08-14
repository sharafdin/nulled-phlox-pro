<?php
/**
 * Generates CSS for a responsive dimentions option
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 *
 * Sample data model:
 * [
 *     'responsive-dimensions' => [
 *         '1024' => [
 *             'value' => [
 *                 'top'     => '',
 *                 'right'   => '',
 *                 'bottom'  => '',
 *                 'left'    => '',
 *                 'isLinked'=> ''
 *             ],
 *             'unit'  => 'px'
 *         ],
 *         'desktop' => [
 *             'value' => [
 *                 'top'     => '',
 *                 'right'   => '',
 *                 'bottom'  => '',
 *                 'left'    => '',
 *                 'isLinked'=> ''
 *             ],
 *             'unit'  => 'px'
 *         ]
 *     ]
 * ];
 */
class Auxin_CSS_Generator_Option_Dimensions extends Auxin_CSS_Generator_Option_Base{

    /**
     * Crawls all breakpoints, generates and collects CSS roles
     *
     * @param  array $breakpoints  Lits of breakpoints
     *
     * @return void
     */
    protected function walk_breakpoints( $breakpoints ){
        foreach( $breakpoints as $breakpoint => $breakpoint_values ){
            if( ! empty( $breakpoint_values['value'] ) ){
                $placeholder = $this->placeholder;

                $top = ! empty( $breakpoint_values['value']['top'] ) ? $breakpoint_values['value']['top'] : 0;
                $placeholder = str_replace( '{{TOP}}', $top, $placeholder );

                $right = ! empty( $breakpoint_values['value']['right'] ) ? $breakpoint_values['value']['right'] : 0;
                $placeholder = str_replace( '{{RIGHT}}', $right, $placeholder );

                $bottom = ! empty( $breakpoint_values['value']['bottom'] ) ? $breakpoint_values['value']['bottom'] : 0;
                $placeholder = str_replace( '{{BOTTOM}}', $bottom, $placeholder );

                $left = ! empty( $breakpoint_values['value']['left'] ) ? $breakpoint_values['value']['left'] : 0;
                $placeholder = str_replace( '{{LEFT}}', $left, $placeholder );

                $unit = ! empty( $breakpoint_values['unit'] ) ? $breakpoint_values['unit'] : 'px';
                $placeholder = str_replace( '{{UNIT}}', $unit, $placeholder );

                $this->stack_css( $placeholder, $breakpoint );
            }
        }
    }

}
