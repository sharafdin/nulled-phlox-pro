<?php
/**
 * Theme general functions
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

if( ! function_exists('auxin_get_famous_colors_list') ) {

    function auxin_get_famous_colors_list(){
        return apply_filters( 'auxin_famous_colors_list', array(
            'black'    => array(
                'label'     => __('black', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-black',
            ),
            'white'    => array(
                'label'     => __('White', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-white',
            ),
            'masala'    => array(
                'label'     => __('Masala', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-masala',
            ),
            'dark-gray'    => array(
                'label'     => __('Dark Gray', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-dark-gray',
            ),
            'ball-blue'    => array(
                'label'     => __('Ball Blue', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-ball-blue',
            ),
            'fountain-blue'    => array(
                'label'     => __('Fountain Blue', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-fountain-blue',
            ),
            'shamrock'    => array(
                'label'     => __('Shamrock', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-shamrock',
            ),
            'curios-blue'    => array(
                'label'     => __('Curios Blue', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-curios-blue',
            ),
            'light-sea-green'    => array(
                'label'     => __('Light Sea Green', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-light-sea-green',
            ),
            'emerald'    => array(
                'label'     => __('Emerald', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-emerald',
            ),
            'energy-yellow'    => array(
                'label'     => __('Energy Yellow', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-energy-yellow',
            ),
            'mikado-yellow'    => array(
                'label'     => __('Mikado Yellow', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-mikado-yellow',
            ),
            'pink-salmon'    => array(
                'label'     => __('Pink Salmon', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-pink-salmon',
            ),
            'wisteria'    => array(
                'label'     => __('Wisteria', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-wisteria',
            ),
            'lilac'    => array(
                'label'     => __('Lilac', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-lilac',
            ),
            'pale-sky'    => array(
                'label'     => __('Pale Sky', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-pale-sky',
            ),
            'tower-gray'    => array(
                'label'     => __('Tower Gray', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-tower-gray',
            ),

            'william'    => array(
                'label'     => __('William', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-william',
            ),
            'carmine-pink'    => array(
                'label'     => __('Carmine Pink', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-carmine-pink',
            ),
            'persimmon'    => array(
                'label'     => __('Persimmon', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-persimmon',
            ),
            'tan-hide'    => array(
                'label'     => __('Tan Hide', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-tan-hide',
            ),
            'wild-watermelon'    => array(
                'label'     => __('Wild Watermelon', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-wild-watermelon',
            ),
            'iceberg'    => array(
                'label'     => __('Iceberg', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-iceberg',
            ),

            'dark-lavender'    => array(
                'label'     => __('Dark Lavender', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-dark-lavender',
            ),
            'viking'    => array(
                'label'     => __('Viking', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-viking',
            ),
            'tiffany-blue'    => array(
                'label'     => __('Tiffany Blue', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-tiffany-blue',
            ),
            'pastel-orange'    => array(
                'label'     => __('Pastel Orange', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-pastel-orange',
            ),
            'east-bay'    => array(
                'label'     => __('East Bay', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-east-bay',
            ),
            'steel-blue'    => array(
                'label'     => __('Steel Blue', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-steel-blue',
            ),
            'half-backed'    => array(
                'label'     => __('Half Backed', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-half-backed',
            ),
            'tapestry'    => array(
                'label'     => __('Tapestry', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-tapestry',
            ),
            'fire-engine-red'    => array(
                'label'     => __('Fire Engine Red', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-fire-engine-red',
            ),
            'dark-orange'    => array(
                'label'     => __('Dark Orange', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-dark-orange',
            ),
            'brick-red'    => array(
                'label'     => __('Brick Red', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-brick-red',
            ),
            'khaki'   => array(
                'label'     => __('Khaki', 'phlox-pro'),
                'css_class' => 'aux-color-selector aux-button aux-visual-selector-khaki',
            )
        ) );

    }

}


if( ! function_exists('auxin_get_elementor_templates_list') ) {
    function auxin_get_elementor_templates_list( $document_type = 'all' ){
        $args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'elementor_library',
            'post_status'      => 'publish'
        );

        if( $document_type !== 'all' ){
            $args['meta_key']   = '_elementor_template_type';
            $args['meta_value'] = $document_type;
        }

        $posts_array  = get_posts( $args );
        $output_array = array( '' => __( 'Select a template', 'phlox-pro' ) );


        foreach ( $posts_array as $key => $value ) {
            $output_array[ $value->ID ] =  $value->post_title;
        }

        return $output_array;
    }
}

if ( ! function_exists( 'auxin_get_pages_with_custom_log' ) ) {
    function auxin_get_pages_with_custom_log() {
        global $wpdb;

        $query = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key='aux_custom_logo' AND meta_value!=''";

        $results = $wpdb->get_results( $query );

        $pages_with_custom_logo = [];
        foreach( $results as $page ) {
            $pages_with_custom_logo[ $page->post_id ] = get_the_title( $page->post_id );
        }

        return $pages_with_custom_logo;
    }
}