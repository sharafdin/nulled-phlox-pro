<?php
/**
 * Outputs option panel
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */


/* ---------------------------------------------------------------------------------------------------
    General Section
    Note: $option and $section vars are defined before, don't define or reset them again
--------------------------------------------------------------------------------------------------- */

function auxin_define_options_info( $fields_sections_list ){

    $options  = array();
    $sections = array();

    // General section ==================================================================

    $sections[] = array(
        'id'      => 'general-section',
        'parent'  => '', // section parent's id
        'title'   => __( 'General', 'phlox-pro' ),
        'description' => __( 'General Setting', 'phlox-pro' ),
        'icon'    => 'axicon-cog'
    );

    // Sub section - General layout -------------------------------

    $sections[] = array(
        'id'      => 'general-section-layout',
        'parent'  => 'general-section', // section parent's id
        'title'   => __( 'General Layout', 'phlox-pro' ),
        'description' => __( 'General Layout Setting', 'phlox-pro' )
    );

    $options[] = array(
        'title'          => __( 'Typography Template', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'typography_html_template',
        'section'        => 'general-section-layout',
        'default'        => '',
        'type'           => 'typography_template_part'
    );

    $options[] = array(
        'title'          => __( 'Global Colors Template', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'global_colors_html_template',
        'section'        => 'general-section-layout',
        'default'        => '',
        'type'           => 'global_colors_template_part'
    );

    // --------------------------------------------------------------

    $options[] = array(
        'title'       => __( 'Website Layout', 'phlox-pro' ),
        'description' => __( 'If you choose "Boxed", site content will be wrapped in a box.', 'phlox-pro' ),
        'id'          => 'site_wrapper_size',
        'section'     => 'general-section-layout',
        'post_js'     => '$("body").toggleClass( "aux-boxed", "boxed" == to ).toggleClass( "aux-full-width", "boxed" !== to );',
        'choices'     => array(
            'full'    => array(
                'label'     => __( 'Full', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-full',
            ),
            'boxed'   => array(
                'label'     => __( 'Boxed', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-boxed',
            )
        ),
        'default'   => 'full',
        'type'      => 'radio-image'
    );

    $options[] = array(
        'title'       => __( 'Site Max Width', 'phlox-pro' ),
        'description' => __( 'Specifies the maximum width of website.', 'phlox-pro' ),
        'id'          => 'site_max_width_layout',
        'section'     => 'general-section-layout',
        'type'        => 'select',
        'transport'   => 'postMessage',
        'dependency'  => array(),
        'choices'     => array(
            'nd'      => __( '1000 Pixels', 'phlox-pro' ),
            'hd'      => __( '1200 Pixels', 'phlox-pro' ),
            'xhd'     => __( '1400 Pixels', 'phlox-pro' ),
            's-fhd'   => __( '1600 Pixels', 'phlox-pro' ),
            'fhd'     => __( '1900 Pixels', 'phlox-pro' )
        ),
        'post_js'   => '$( "body" ).removeClass( "aux-nd aux-hd aux-xhd aux-s-fhd aux-fhd" ).addClass( "aux-" + to ); $(window).trigger("resize");',
        'default'   => 's-fhd'
    );

    // Sub section - General Typography -------------------------------

    $sections[] = array(
        'id'      => 'general-section-typography',
        'parent'  => 'general-section', // section parent's id
        'title'   => __( 'General Typography', 'phlox-pro' ),
        'description' => __( 'General Typography Setting', 'phlox-pro' )
    );

    $options[] = array(
        'title'          => __( 'Body', 'phlox-pro' ),
        'id'             => 'body_typography',
        'section'        => 'general-section-typography',
        'type'           => 'group_typography',
        'selectors'      => 'body',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'All Headings', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'general_heading_all',
        'section'        => 'typography-heading-section',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => 'h1, h2, h3, h4, h5, h6, .aux-h1, .aux-h2, .aux-h3, .aux-h4, .aux-h5, .aux-h6',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Heading 1 (H1)', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'general_heading_h1',
        'section'        => 'general-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => 'body h1, body .aux-h1',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Heading 2 (H2)', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'general_heading_h2',
        'section'        => 'general-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => 'body h2, body .aux-h2',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Heading 3 (H3)', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'general_heading_h3',
        'section'        => 'general-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => 'body h3, body .aux-h3',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Heading 4 (H4)', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'general_heading_h4',
        'section'        => 'general-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => 'body h4, body .aux-h4',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Heading 5 (H5)', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'general_heading_h5',
        'section'        => 'general-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => 'body h5, body .aux-h5',
        'transport'      => 'postMessage',
    );

    // Sub section - Logo options ------------------------------------

    $sections[] = array(
        'id'          => 'general-section-logo',
        'parent'      => 'general-section', // section parent's id
        'title'       => __( 'Logo', 'phlox-pro' ),
        'description' => __( 'Logo Setting', 'phlox-pro' )
    );

    $options[] = array(
        'title'          => __( 'Logo Width', 'phlox-pro' ),
        'description'    => __( 'Specifies the max width of logo image in pixels.', 'phlox-pro' ),
        'id'             => 'header_logo_width',
        'section'        => 'title_tagline',
        'dependency'     => array(),
        'transport'      => 'postMessage',
        'default'        => '80',
        'type'           => 'text',
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'header_logo_width' ) );
            }
            $value = trim( $value, 'px');
            return $value ? ".aux-logo-header .aux-logo-anchor{ max-width:{$value}px; }" : '';
        }
    );

    $options[] = array(
        'title'          => __( 'Logo Max Height', 'phlox-pro' ),
        'description'    => __( 'If the original logo is big in dimensions, you can limit the height by this option.', 'phlox-pro' ),
        'id'             => 'header_logo_max_height_type',
        'section'        => 'title_tagline',
        'dependency'     => array(),
        'transport'      => 'postMessage',
        'default'        => 'auto',
        'choices'        => array(
            'auto'      => __( "Same as header height", 'phlox-pro' ),
            'custom'    => __( "Specific size in pixel", 'phlox-pro' ),
            'none'      => __( "No Limit", 'phlox-pro' )
        ),
        'type'           => 'select',
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'header_logo_max_height_type' ) );
            }

            if( "auto" == $value ){
                $max_height = auxin_get_option( 'site_header_container_height', '85');
                $max_height = trim( $max_height, 'px') . 'px';
            } elseif( "custom" == $value ){
                $max_height = auxin_get_option( 'header_logo_max_height', '85');
                $max_height = trim( $max_height, 'px') . 'px';
            } else {
                $max_height = 'none';
            }

            return $max_height ? ".aux-logo-header .aux-logo-anchor > img { max-height:{$max_height}; }" : '';
        }
    );

    $options[] = array(
        'title'          => __( 'Logo Max Height in Pixel', 'phlox-pro' ),
        'description'    => __( 'Specifies the max height of logo image in pixel.', 'phlox-pro' ),
        'id'             => 'header_logo_max_height',
        'section'        => 'title_tagline',
        'dependency'  => array(
            array(
                 'id'      => 'header_logo_max_height_type',
                 'value'   => array('custom'),
                 'operator'=> ''
            )
        ),
        'transport'      => 'postMessage',
        'default'        => '85',
        'type'           => 'text'
    );

    if( $pages_with_custom_logo = auxin_get_pages_with_custom_log() ){
        $options[] = array(
            'title'         => __( 'Pages with custom logo', 'phlox-pro' ),
            'id'            => 'pages_with_custom_logo',
            'section'       => 'title_tagline',
            'type'          => 'selective_list',
            'description'   => __( 'The following pages have custom logo enabled in page options. Select the page to edit the custom logo in page options.', 'phlox-pro' ),
            'has_link'      => true,
            'choices'       => $pages_with_custom_logo
        );
    }


     // Sub section - Paeg animation and preloading layout -------------------------------

    $sections[] = array(
        'id'          => 'page-animation-preloading-section-layout',
        'parent'      => 'general-section', // section parent's id
        'title'       => __( 'Page Animation and Preloading', 'phlox-pro' ),
        'description' => __( 'Page Animation and Preloading Setting', 'phlox-pro' )
    );

    $options[] = array(
        'title'       => __( 'Enable Page Animation', 'phlox-pro' ),
        'description' => __( 'Enable this option to add page animation when user navigates between pages.', 'phlox-pro' ),
        'id'          => 'page_animation_nav_enable',
        'section'     => 'page-animation-preloading-section-layout',
        'default'     => '0',
        'type'        => 'switch',
        'transport'   => 'refresh'
    );

    $options[] = array(
        'title'       => __( 'Animation Type', 'phlox-pro' ),
        'description' => __( 'Hover over images to see the animation.', 'phlox-pro' ),
        'id'          => 'page_animation_nav_type',
        'section'     => 'page-animation-preloading-section-layout',
        'type'        => 'radio-image',
        'dependency'  => array(
            array(
                 'id'      => 'page_animation_nav_enable',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'choices'           => array(
            'fade'      => array(
                'label'     => __('Fade' , 'phlox-pro'),
                'video_src' => AUXIN_URL . 'images/visual-select/videos/LoadFade.webm webm'
            ),
            'cover'      => array(
                'label'     => __('Cover' , 'phlox-pro'),
                'video_src' => AUXIN_URL . 'images/visual-select/videos/LoadFade.webm webm'
            ),
            'circle'    => array(
                'label'     => __('Circle' , 'phlox-pro'),
                'video_src' => AUXIN_URL . 'images/visual-select/videos/LoadCircle.webm webm'
            ),
            'slideup'    => array(
                'label'     => __('Slide-Up' , 'phlox-pro'),
                'video_src' => AUXIN_URL . 'images/visual-select/videos/LoadFade.webm webm'
            ),
        ),
        'transport'   => 'refresh',
        'default'     => 'fade'
    );

    $options[] = array(
        'title'       => __( 'Enable Page Preloading', 'phlox-pro' ),
        'description' => __( 'Enable this option to display a loading animation while site is loading.', 'phlox-pro' ),
        'id'          => 'page_preload_enable',
        'section'     => 'page-animation-preloading-section-layout',
        'default'     => '0',
        'transport'   => 'refresh',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Add Loading Image', 'phlox-pro' ),
        'description' => __( 'Enable this option to add loading image for the site.', 'phlox-pro' ),
        'id'          => 'page_preload_custom_loading',
        'section'     => 'page-animation-preloading-section-layout',
        'default'     => '0',
        'dependency'  => array(
            array(
                 'id'      => 'page_preload_enable',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'transport'   => 'refresh',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Loading Image', 'phlox-pro' ),
        'description' => __( 'Select an animated gif to display while site is loading.', 'phlox-pro' ),
        'id'          => 'page_preload_loading_image',
        'section'     => 'page-animation-preloading-section-layout',
        'dependency'  => array(
             array(
                'id'      => 'page_preload_enable',
                'value'   => array('1'),
                'operator'=> ''
            ),
             array(
                 'id'      => 'page_preload_custom_loading',
                 'value'   => array('1'),
                 'operator'=> '=='
            )
        ),
        'default'     => '',
        'transport'   => 'refresh',
        'type'        => 'image'
    );

    $options[] = array(
        'title'       => __( 'Add Progress Bar', 'phlox-pro' ),
        'description' => __( 'Enable this option to add a top progress bar while site is loading.', 'phlox-pro' ),
        'id'          => 'page_preload_prgoress_bar',
        'section'     => 'page-animation-preloading-section-layout',
        'default'     => '1',
        'transport'   => 'refresh',
        'dependency'  => array(
             array(
                'id'      => 'page_preload_enable',
                'value'   => array('1'),
                'operator'=> ''
            )
        ),
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Progress Bar Position', 'phlox-pro' ),
        'id'          => 'page_preload_prgoress_bar_position',
        'section'     => 'page-animation-preloading-section-layout',
        'type'        => 'select',
        'transport'   => 'refresh',
        'dependency'  => array(
            array(
                'id'      => 'page_preload_enable',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                 'id'      => 'page_preload_prgoress_bar',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'choices'     => array(
            'top'    => __( 'Top', 'phlox-pro' ),
            'bottom' => __( 'Bottom', 'phlox-pro' )
        ),
        'default'   => 'top',
    );

    $options[] = array(
        'title'       => __( 'Progress Bar Color', 'phlox-pro' ),
        'id'          => 'page_preload_prgoress_bar_color',
        'section'     => 'page-animation-preloading-section-layout',
        'type'        => 'color',
        'transport'   => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'page_preload_enable',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                 'id'      => 'page_preload_prgoress_bar',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'selectors' => ' ',
        'default'   => '#FFFFFF',
    );

    $options[] = array(
        'title'       => __( 'Page Preloading Color', 'phlox-pro' ),
        'id'          => 'page_preload_page_overlay_color',
        'section'     => 'page-animation-preloading-section-layout',
        'type'        => 'color',
        'transport'   => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'page_preload_enable',
                'value'   => array('1'),
                'operator'=> ''
            )
        ),
        'default'     => '',
        'selectors'   => [
            ".csstransitions .aux-page-animation-cover .aux-page-animation-overlay" => "background-color:{{VALUE}};"
        ]
    );

    /* ---------------------------------------------------------------------------------------------------
        Colors
    --------------------------------------------------------------------------------------------------- */

    // Color section ==================================================================

    $sections[] = array(
        'id'          => 'appearance-section',
        'parent'      => '', // section parent's id
        'title'       => __( 'Appearance', 'phlox-pro' ),
        'description' => __( 'Appearance Setting', 'phlox-pro' ),
        'icon'        => 'axicon-droplet'
    );

    // Sub section - Global colors -------------------------------
    $global_colors_section = [
        'id'          => 'appearance-section-global-color',
        'parent'      => 'appearance-section', // section parent's id
        'title'       => __( 'Global Colors', 'phlox-pro' ),
        'description' => __( 'Global Colors Setting', 'phlox-pro' )
    ];

    // Sub section - Elementor colors -------------------------------
    if ( class_exists( '\Elementor\Plugin' ) && class_exists( 'AUXELS' ) ) {

        $global_colors_section['description'] = __( 'Elementor Global Colors', 'phlox-pro' ) . '<a href="https://docs.phlox.pro/article/251-global-colors-phlox" target="_blank">'. esc_html__( 'Learn More', 'phlox-pro' ) .'</a>' ;

        $active_kit = get_option( 'elementor_active_kit', '' );
        $current_settings = get_post_meta( $active_kit, '_elementor_page_settings', true );

        $default_colors = [
            [
                '_id' => 'primary',
                'title' => __( 'Primary', 'elementor' ),
                'color' => '#6EC1E4',
            ],
            [
                '_id' => 'secondary',
                'title' => __( 'Secondary', 'elementor' ),
                'color' => '#54595F',
            ],
            [
                '_id' => 'text',
                'title' => __( 'Text', 'elementor' ),
                'color' => '#7A7A7A',
            ],
            [
                '_id' => 'accent',
                'title' => __( 'Accent', 'elementor' ),
                'color' => '#61CE70',
            ],
        ];

        $system_colors = ! empty( $current_settings['system_colors'] ) ? $current_settings['system_colors'] : $default_colors;

        foreach ( $system_colors as $color ) {
            $options[] = [
                'title'       => isset( $color['title'] ) ? $color['title'] : '',
                'id'          => 'elementor_color_' . $color['_id'],
                'section'     => 'appearance-section-global-color',
                'type'        => 'color',
                'transport'   => 'postMessage',
                'default'     => isset( $color['color'] ) ? $color['color'] : '',
                'selectors'   => [
                    ".aux-customize-preview.elementor-kit-{$active_kit}" => "--e-global-color-{$color['_id']}: {{VALUE}};"
                ]
            ];
        }

        $custom_colors = ! empty( $current_settings['custom_colors'] ) ? $current_settings['custom_colors'] : '';

        $options[] = [
            'title'        => __( 'New Custom Color', 'phlox-pro' ),
            'id'           => 'elementor_global_custom_colors_repeater',
            'section'      => 'appearance-section-global-color',
            'type'         => 'color_repeater',
            'transport'    => 'postMessage',
            'choices'      => $custom_colors,
            'margin_bottom'=> '90'
        ];
    }

    $sections[] = $global_colors_section;

    // Sub section - Featured colors -------------------------------

    $options[] = array(
        'id'          => 'use_legacy_featured_colors_info',
        'section'      => 'appearance-section-global-color',
        'type'        => 'info',
        'title'       => __( 'Featured Colors (deprecated)', 'phlox-pro' ),
        'description' => __( 'Legacy featured colors are deprecated and will be removed soon, Please DO NOT use them and use above "Global Colors" instead.', 'phlox-pro' ),
        'description_color' => '#bd0000',
        'title_color' => '#bd0000',
        'icon_color'  => '',
        'separator'   => 'none',
        'margin_top'  => '0',
        'margin_bottom' => '5',
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Featured colors', 'phlox-pro' ),
        'id'             => 'use_legacy_featured_colors',
        'section'        => 'appearance-section-global-color',
        'type'           => 'switch',
        'transport'      => 'refresh',
        'default'        => '0'
    );

    for( $i = 1; $i <= 8 ; ++$i ) {
        $options[] = [
            'title'       => sprintf( __( 'Color %s', 'phlox-pro' ), $i ),
            'id'          => 'site_featured_color_' . $i,
            'section'     => 'appearance-section-global-color',
            'type'        => 'color',
            'transport'   => 'postMessage',
            'default'     => '',
            'selectors'   => [
                ":root" => "--auxin-featured-color-{$i}: {{VALUE}};"
            ],
            'dependency'  => [
                [
                    'id'      => 'use_legacy_featured_colors',
                    'value'   => array('1'),
                    'operator'=> '=='
                ]
            ],
        ];
    }

    // Sub section - Website background -------------------------------

    $sections[] = array(
        'id'          => 'appearance-section-background',
        'parent'      => 'appearance-section', // section parent's id
        'title'       => __( 'Website Background', 'phlox-pro' ),
        'description' => __( 'Website Background Setting', 'phlox-pro' )
    );

    $options[] = array(
        'title'       => __( 'Enable background', 'phlox-pro' ),
        'description'   => sprintf(__( 'Specifies the background options for the body of website on boxed layout.%1$s Only works if %2$s Website Layout %3$s option sets to %2$s Boxed layout %3$s', 'phlox-pro' ), '<br>', '<code>', '</code>'),
        'id'          => 'site_body_background_show',
        'section'     => 'appearance-section-background',
        'default'     => '0',
        'transport'   => 'refresh',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Background Color', 'phlox-pro' ),
        'id'          => 'site_body_background_color',
        'description' => __( 'Specifies the color of website background.', 'phlox-pro' ),
        'section'     => 'appearance-section-background',
        'type'        => 'color',
        'dependency'  => array(
            array(
                'id'      => 'site_body_background_show',
                'value'   => array('1'),
                'operator'=> '=='
            )
        ),
        'selectors'     => 'body',
        'placeholder'   => 'background-color:{{VALUE}}',
        'transport'     => 'postMessage',
        'default'       => ''
    );

    $options[] = array(
        'title'       => __( 'Background Pattern', 'phlox-pro' ),
        'description' => sprintf( __( 'Select one of these patterns as site background image. %s Some of these can be used as a pattern over background image.', 'phlox-pro' ), '<br>' ),
        'id'          => 'site_body_background_pattern',
        'section'     => 'appearance-section-background',
        'choices'     => auxin_get_background_patterns( array( 'none' => array( 'label' =>__( 'None', 'phlox-pro' ), 'image' => AUXIN_URL . 'images/visual-select/none-pattern.svg' ) ), 'before' ),
        'type'        => 'radio-image',
        'dependency'  => array(
            array(
                'id'      => 'site_body_background_show',
                'value'   => array('1'),
                'operator'=> '=='
            )
        ),
        'style_callback' => function( $value = null ){
            // Don't generate custom styles if custom site background is disabled
            if( ! auxin_get_option( 'site_body_background_show' ) ){
                return '';
            }

            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'site_body_background_pattern' ) );
            }
            return 'none' != $value ? "body:before { height:100%; background-image:url($value); }" : '';
        },
        'transport' => 'postMessage',
        'default'   => 'none'
    );

    $options[] = array(
        'title'       =>  __( 'Background Image', 'phlox-pro' ),
        'id'          => 'site_body_background_image',
        'description' =>  __( 'You can upload custom image for site background.', 'phlox-pro' ),
        'section'     => 'appearance-section-background',
        'type'        => 'image',
        'dependency'  => array(
            array(
                'id'      => 'site_body_background_show',
                'value'   => array('1'),
                'operator'=> '=='
            )
        ),
        'style_callback' => function( $value = null ){
            // Don't generate custom styles if custom site background is disabled
            if( ! auxin_get_option( 'site_body_background_show' ) ){
                return '';
            }

            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'site_body_background_image' ) );
            }

            $value = auxin_get_attachment_url( $value, 'full' );
            return empty( $value ) ? '' : "body { background-image:url($value); }";
        },
        'transport' => 'refresh',
        'default'   => ''
    );


    $options[] = array(
        'title'       =>  __( 'Background Size', 'phlox-pro' ),
        'description' =>  __( 'Specifies the background size.', 'phlox-pro' ),
        'id'          => 'site_body_background_size',
        'section'     => 'appearance-section-background',
        'type'        => 'radio-image',
        'choices'     => array(
            'auto' => array(
                'label'     => __( 'Auto', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-bg-size-1',
            ),
            'contain' => array(
                'label'     => __( 'Contain', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-bg-size-2'
            ),
            'cover' => array(
                'label'     => __( 'Cover', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-bg-size-3'
            )
        ),
        'dependency'  => array(
            array(
                'id'      => 'site_body_background_show',
                'value'   => array('1'),
                'operator'=> '=='
            )
        ),
        'style_callback' => function( $value = null ){
            // Don't generate custom styles if custom site background is disabled
            if( ! auxin_get_option( 'site_body_background_show' ) ){
                return '';
            }

            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'site_body_background_size' ) );
            }
            return "body { background-size:$value; }";
        },
        'transport' => 'postMessage',
        'default'   => 'auto'
    );




    $options[] = array(
        'title'       =>  __( 'Background Repeat', 'phlox-pro' ),
        'description' =>  __( 'Specifies how background image repeats.', 'phlox-pro' ),
        'id'          => 'site_body_background_repeat',
        'section'     => 'appearance-section-background',
        'choices'     =>  array(
            'no-repeat' => array(
                'label'     => __( 'No repeat', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-none',
            ),
            'repeat' => array(
                'label'     => __( 'Repeat horizontally and vertically', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-repeat-xy',
            ),
            'repeat-x' => array(
                'label'     => __( 'Repeat horizontally', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-repeat-x',
            ),
            'repeat-y' => array(
                'label'     => __( 'Repeat vertically', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-repeat-y',
            )
        ),
        'type'        => 'radio-image',
        'dependency'  => array(
            array(
                'id'      => 'site_body_background_show',
                'value'   => array('1'),
                'operator'=> '=='
            )
        ),
        'style_callback' => function( $value = null ){
            // Don't generate custom styles if custom site background is disabled
            if( ! auxin_get_option( 'site_body_background_show' ) ){
                return '';
            }

            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'site_body_background_repeat' ) );
            }
            return "body { background-repeat:$value; }";
        },
        'transport' => 'postMessage',
        'default'   => 'no-repeat'
    );



    $options[] = array(
        'title'       =>  __( 'Background Position', 'phlox-pro' ),
        'description' =>  __( 'Specifies background image position.', 'phlox-pro' ),
        'id'          => 'site_body_background_position',
        'section'     => 'appearance-section-background',
        'choices'     => array(
            'left top' => array(
                'label'     => __( 'Left top', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-top-left'
            ),
            'center top' => array(
                'label'     => __( 'Center top', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-top-center'
            ),
            'right top' => array(
                'label'     => __( 'Right top', 'phlox-pro' ) ,
                'css_class' => 'axiAdminIcon-top-right'
            ),

            'left center' => array(
                'label'     => __( 'Left center', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-center-left'
            ),
            'center center' => array(
                'label'     => __( 'Center center', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-center-center'
            ),
            'right center' => array(
                'label'     => __( 'Right center', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-center-right'
            ),

            'left bottom' => array(
                'label'     => __( 'Left bottom', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-bottom-left'
            ),
            'center bottom' => array(
                'label'     => __( 'Center bottom', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-bottom-center'
            ),
            'right bottom' => array(
                'label'     => __( 'Right bottom', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-bottom-right'
            )
        ),
        'type'        => 'radio-image',
        'dependency'  => array(
            array(
                'id'      => 'site_body_background_show',
                'value'   => array('1'),
                'operator'=> '=='
            )
        ),
        'style_callback' => function( $value = null ){
            // Don't generate custom styles if custom site background is disabled
            if( ! auxin_get_option( 'site_body_background_show' ) ){
                return '';
            }

            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'site_body_background_position' ) );
            }
            return "body { background-position:$value; }";
        },
        'transport' => 'postMessage',
        'default'   => 'left top'
    );


    $options[] = array(
        'title'       =>  __( 'Background Attachment', 'phlox-pro' ),
        'description' =>  __( 'Specifies whether the background is fixed or scrollable as user scrolls the page.', 'phlox-pro' ),
        'id'          => 'site_body_background_attach',
        'section'     => 'appearance-section-background',
        'type'        =>  'radio-image',
        'choices'     => array(
            'scroll' => array(
                'label'     => __( 'Scroll', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-bg-attachment-scroll',
            ),
            'fixed' => array(
                'label'     => __( 'Fixed', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-bg-attachment-fixed',
            )
        ),
        'dependency'  => array(
            array(
                'id'      => 'site_body_background_show',
                'value'   => array('1'),
                'operator'=> '=='
            )
        ),
        'style_callback' => function( $value = null ){
            // Don't generate custom styles if custom site background is disabled
            if( ! auxin_get_option( 'site_body_background_show' ) ){
                return '';
            }

            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'site_body_background_attach' ) );
            }
            return "body { background-attachment:$value; }";
        },
        'default'     => 'scroll',
        'transport'   => 'postMessage'
    );

    // Sub section - Website background -------------------------------

    $sections[] = array(
        'id'          => 'appearance-section-content-bg',
        'parent'      => 'appearance-section', // section parent's id
        'title'       => __( 'Content Background', 'phlox-pro' ),
        'description' => __( 'Content Background Setting', 'phlox-pro' )
    );

    $options[] = array(
        'title'       => __( 'Content Background Color', 'phlox-pro' ),
        'id'          => 'site_content_background_color',
        'description' => __( 'Specifies the color of content background.', 'phlox-pro' ),
        'section'     => 'appearance-section-content-bg',
        'type'        => 'color',
        'dependency'  => array(),
        'selectors'   => array(
            ".aux-top-header, .aux-sticky-footer .page-title-section, .aux-sticky-footer #main, #inner-body" => "background-color:{{VALUE}};"
        ),
        'transport'   => 'postMessage',
        'default'     => ''
    );

    // Sub section - Website Frame -------------------------------

    $sections[] = array(
        'id'          => 'appearance-section-frame',
        'parent'      => 'appearance-section', // section parent's id
        'title'       => __( 'Website Frame', 'phlox-pro' ),
        'description' => __( 'Website Frame Setting', 'phlox-pro' )
    );

    $options[] = array(
        'title'       => __( 'Enable Site Frame', 'phlox-pro' ),
        'description' => __( 'Enable this option to add a frame around the site. ', 'phlox-pro' ),
        'id'          => 'site_frame_show',
        'section'     => 'appearance-section-frame',
        'default'     => '0',
        'transport'   => 'refresh',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Site Frame Color', 'phlox-pro' ),
        'id'          => 'site_frame_background_color',
        'description' => __( 'Specifies the color of the frame around the site.', 'phlox-pro' ),
        'section'     => 'appearance-section-frame',
        'type'        => 'color',
        'dependency'  => array(
            array(
                'id'      => 'site_frame_show',
                'value'   => '1'
            )
        ),
        'selectors' => [
            '@media screen and (min-width: 700px) { .aux-framed .aux-side-frames, body.aux-framed:after, .aux-framed .aux-side-frames:before, .aux-framed .aux-side-frames:after' => 'background-color:{{VALUE}};}'
        ],
        'transport' => 'postMessage',
        'default'   => '#111111'
    );


    // Sub section - Skin options --------------------------------------

    $sections[] = array(
        'id'          => 'appearance-section-skin',
        'parent'      => 'appearance-section', // section parent's id
        'title'       => __( 'Skin options', 'phlox-pro' ),
        'description' => __( 'Skin options', 'phlox-pro' )
    );


    $options[] = array(
        'title'       => __( 'Video Player Skin', 'phlox-pro' ),
        'description' => __( 'Specifies the default skin for self hosted video player.', 'phlox-pro' ),
        'id'          => 'global_video_player_skin',
        'section'     => 'appearance-section-skin',
        'type'        => 'radio-image',
        'choices' => array(
            'dark' => array(
                'label' => __( 'Dark', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/audio-player-dark.svg'
            ),
            'light' => array(
                'label' => __( 'Light', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/audio-player-light.svg'
            )
        ),
        'transport' => 'refresh',
        'default'   => 'dark'
    );

    $options[] = array(
        'title'       => __( 'Audio Player Skin', 'phlox-pro' ),
        'description' => __( 'Specifies the default skin for self hosted audio player.', 'phlox-pro' ),
        'id'          => 'global_audio_player_skin',
        'section'     => 'appearance-section-skin',
        'type'        => 'radio-image',
        'choices' => array(
            'dark' => array(
                'label' => __( 'Dark', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/audio-player-dark.svg'
            ),
            'light' => array(
                'label' => __( 'Light', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/audio-player-light.svg'
            )
        ),
        'transport' => 'refresh',
        'default'   => 'dark'
    );

    $options[] = array(
        'title'       => __( 'Pagination Skin', 'phlox-pro' ),
        'description' => __( 'Specifies the default skin for site pagination.', 'phlox-pro' ),
        'id'          => 'archive_pagination_skin',
        'section'     => 'appearance-section-skin',
        'type'        => 'radio-image',
        'choices'     => array(
            'aux-round aux-page-no-border' => array(
                'label' => __( 'Round, No Page Border', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/paginationstyle-5.svg'
            ),
            'aux-round aux-no-border' => array(
                'label' => __( 'Round, No Border', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/paginationstyle-6.svg'
            ),
            'aux-round' => array(
                'label' => __( 'Round, With Border', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/paginationstyle-4.svg'
            ),
            'aux-square aux-page-no-border' => array(
                'label' => __( 'Square, No Page Border', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/paginationstyle-2.svg'
            ),
            'aux-square aux-no-border' => array(
                'label' => __( 'Square, No Border', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/paginationstyle-3.svg'
            ),
            'aux-square' => array(
                'label' => __( 'Square, With Border', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/paginationstyle-1.svg'
            )
        ),
        'post_js'   => '$(".content .aux-pagination").prop("class", "aux-pagination " + to );',
        'transport' => 'postMessage',
        'default'   => 'aux-square'
    );

    $options[] = array(
        'title'          => __( 'Pagination Typography', 'phlox-pro' ),
        'id'             => 'archive_pagination_skin_typography',
        'description'    => '',
        'section'        => 'appearance-section-skin',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-pagination > .pagination, .aux-pagination > .pagination a',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Pagination Active Number Typography', 'phlox-pro' ),
        'id'             => 'archive_pagination_skin_active_typography',
        'description'    => '',
        'section'        => 'appearance-section-skin',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-pagination > .pagination .active, .aux-pagination > .pagination li.active span',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Pagination Next/Prev Typography', 'phlox-pro' ),
        'id'             => 'archive_pagination_skin_next_prev_typography',
        'description'    => '',
        'section'        => 'appearance-section-skin',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-pagination > .pagination .next, .aux-pagination > .pagination .prev, .aux-pagination > .pagination .first , .aux-pagination > .pagination .last, .aux-pagination > .pagination .next a, .aux-pagination > .pagination .prev a, .aux-pagination > .pagination .first a, .aux-pagination > .pagination .last a',
        'transport'      => 'postMessage',
    );

    // Sub section - Skin options --------------------------------------

    $sections[] = array(
        'id'          => 'appearance-section-toolbar-color',
        'parent'      => 'appearance-section', // section parent's id
        'title'       => __( 'Mobile Browsers', 'phlox-pro' ),
        'description' => __( 'Mobile Browsers', 'phlox-pro' )
    );

    $options[] = array(
        'title'          => __( 'Address Bar Color', 'phlox-pro' ),
        'description'    => __( 'Specifies the color of address bar and toolbar on mobile browsers.', 'phlox-pro' ),
        'id'             => 'site_mobile_browser_toolbar_color',
        'section'        => 'appearance-section-toolbar-color',
        'dependency'     => array(),
        'default'        => '#1bb0ce',
        'type'           => 'color',
        'selectors'      => ' '
    );

    // Sub section - Forms -------------------------------

    $sections[] = array(
        'id'          => 'appearance-section-forms',
        'parent'      => 'appearance-section', // section parent's id
        'title'       => __( 'Forms', 'phlox-pro' ),
        'description' => __( 'Forms Appearance', 'phlox-pro' )
    );

    $options[] = array(
        'title'       => __( 'Which Input should be display', 'phlox-pro' ),
        'description' => __( 'Specifies the inputs of comment forms.', 'phlox-pro' ),
        'id'          => 'comment_forms_inputs',
        'section'     => 'appearance-section-forms',
        'choices'     => array(
            'email'   => __( 'Email', 'phlox-pro' ),
            'url'     => __( 'Website', 'phlox-pro' ),
            'author'  => __( 'Name', 'phlox-pro' ),
            'cookies' => __( 'Cookies', 'phlox-pro' )
        ),
        'type'        => 'select2-multiple',
        'dependency'  => array(),
        'transport'   => 'refresh',
        'default'     => array('email','author','url','cookies')
    );


    $options[] = array(
        'title'       => __( 'Comment Forms Skin', 'phlox-pro' ),
        'description' => __( 'Specifies the skin of all comment forms.', 'phlox-pro' ),
        'id'          => 'comment_forms_skin',
        'section'     => 'appearance-section-forms',
        'choices'     => array(
            'classic' => __( 'Classic', 'phlox-pro' ),
            'modern'  => __( 'Modern', 'phlox-pro' )
        ),
        'type'        => 'select',
        'dependency'  => array(),
        'transport'   => 'refresh',
        'default'     => 'classic'
    );

    $options[] = array(
        'title'       => __( 'Label', 'phlox-pro' ),
        'description' => __( 'Enable it to add labels in comment form.', 'phlox-pro' ),
        'id'          => 'comment_forms_label',
        'section'     => 'appearance-section-forms',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'comment_forms_skin',
                 'value'   => 'classic',
            )
        ),
        'transport'   => 'refresh',
        'default'     => '0'
    );

    $options[] = array(
        'title'          => __( 'Label Typography', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'comment_forms_label_typo',
        'section'        => 'appearance-section-forms',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '#commentform label',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'       => __( 'Layout', 'phlox-pro' ),
        'description' => __( 'Specifies the layout of comment forms.', 'phlox-pro' ),
        'id'          => 'comment_forms_layout',
        'section'     => 'appearance-section-forms',
        'choices'     => array(
            'default' => __( 'Default', 'phlox-pro' ),
            'three' => __( '3 Column', 'phlox-pro' ),
            'two'  => __( '2 Column', 'phlox-pro' )
        ),
        'type'        => 'select',
        'dependency'  => array(),
        'transport'   => 'refresh',
        'default'     => 'default'
    );

    $options[] = array(
        'title'       => __( 'Reply Title', 'phlox-pro' ),
        'description' => __( 'Specifies the reply title of comment form.', 'phlox-pro' ),
        'id'          => 'comment_forms_replay_title',
        'section'     => 'appearance-section-forms',
        'type'        => 'text',
        'transport'   => 'refresh',
        'default'     =>  __( 'Add a Comment', 'phlox-pro' ),
    );

    $options[] = array(
        'title'          => __( 'Reply Title Typography', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'comment_forms_replay_title_typo',
        'section'        => 'appearance-section-forms',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '#reply-title > span',
        'transport'      => 'postMessage'
    );

    $options[] = array(
        'title'       => __( 'Comment Form Notes', 'phlox-pro' ),
        'description' => __( 'Specifies notes of comment forms.', 'phlox-pro' ),
        'id'          => 'comment_forms_notes',
        'section'     => 'appearance-section-forms',
        'type'        => 'textarea',
        'transport'   => 'refresh',
        'default'     => __( 'Your email address will not be published. Required fields are marked *', 'phlox-pro' )
    );

    $options[] = array(
        'title'          => __( 'Form Notes Typography', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'comment_forms_notes_typo',
        'section'        => 'appearance-section-forms',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '#commentform .comment-notes',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Response Title Typography', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'comment_forms_response_title_typo',
        'section'        => 'appearance-section-forms',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.comments-title, .comment-reply-title',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Submit Button Typography', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'comment_forms_button_typo',
        'section'        => 'appearance-section-forms',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '#commentform .form-submit input[type="submit"]',
        'transport'      => 'postMessage'
    );


    $options[] = array(
        'title'          => __( 'Form Placeholder Text', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'comment_forms_placeholder_typo',
        'section'        => 'appearance-section-forms',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '#commentform input::placeholder, #commentform textarea::placeholder',
        'transport'      => 'postMessage'
    );

    $options[] = array(
        'title'          => __( 'Comment Author Typography', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'comment_author_typo',
        'section'        => 'appearance-section-forms',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-commentlist .comment-author .fn, .aux-commentlist .comment-author .fn a',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Comment Info Typography', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'comment_info_typo',
        'section'        => 'appearance-section-forms',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-commentlist .comment .comment-author time a',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Comment Content Typography', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'comment_content_typo',
        'section'        => 'appearance-section-forms',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-commentlist .comment .comment-body',
        'transport'      => 'postMessage',
    );



    // Sub section - Sidebars -------------------------------

    $sections[] = array(
        'id'          => 'appearance-section-sidebars',
        'parent'      => 'appearance-section', // section parent's id
        'title'       => __( 'Sidebars', 'phlox-pro' ),
        'description' => __( 'Sidebars Appearance', 'phlox-pro' )
    );

    $options[] = array(
        'title'          => __( 'All Sidebars Widget Title', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'sidebar_common_widget_title_typography',
        'section'        => 'appearance-section-sidebars',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-sidebar .widget-title',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Primary Sidebar Widget Title', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'sidebar_primary_widget_title_typography',
        'section'        => 'appearance-section-sidebars',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-sidebar-primary .widget-title',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Secondary Sidebar Widget Title', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'sidebar_secondary_widget_title_typography',
        'section'        => 'appearance-section-sidebars',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-sidebar-secondary .widget-title',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Sidebar Global Typography', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'sidebar_global_typography',
        'section'        => 'appearance-section-sidebars',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-sidebar',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'         => __( 'Togglable Widgets', 'phlox-pro' ),
        'description'   => __( 'Enable it to togglable the widgets in sidebars.', 'phlox-pro' ),
        'id'            => 'sidebar_widget_togglable',
        'section'       => 'appearance-section-sidebars',
        'transport'     => 'postMessage',
        'type'          => 'switch',
        'default'       => '0',
    );

    $options[] = array(
        'title'         => __( 'Expand widgets on init', 'phlox-pro' ),
        'description'   => __( 'Enable it to expand widgets on init', 'phlox-pro' ),
        'id'            => 'sidebar_widget_expand_on_init',
        'section'       => 'appearance-section-sidebars',
        'transport'     => 'postMessage',
        'type'          => 'switch',
        'default'       => '1',
        'dependency'  => array(
            array(
                'id'      => 'sidebar_widget_togglable',
                'value'   => 1,
                'operator'=> '=='
            ),
        )
    );

    $options[] = array(
        'title'         => __( 'Custom Dropdown Skins', 'phlox-pro' ),
        'description'   => __( 'Enable it to use custom skins for dropdowns in sidebars.', 'phlox-pro' ),
        'id'            => 'sidebar_custom_dropdown',
        'section'       => 'appearance-section-sidebars',
        'transport'     => 'postMessage',
        'type'          => 'select',
        'choices'     => array(
            'none'         => __( 'Default',    'phlox-pro' ),
            'classic'      => __( 'Classic', 'phlox-pro' ),
        ),
        'default'       => 'none',
    );



/* ---------------------------------------------------------------------------------------------------
        Header Section
   --------------------------------------------------------------------------------------------------- */

    // Header section ==================================================================

    $sections[] = array(
        'id'          => 'header-section',
        'parent'      => '',
        'title'       => __( 'Header', 'phlox-pro' ),
        'description' => __( 'Header Setting', 'phlox-pro' ),
        'icon'        => 'axicon-align-justify'
    );



    // Sub section - Header builder -------------------------------
    $sections[] = array(
        'id'          => 'header-section-builder',
        'parent'      => 'header-section',
        'title'       => __( 'Header Templates', 'phlox-pro' ),
        'description' => __( 'Header Templates', 'phlox-pro' )
    );

    if ( class_exists( '\Elementor\Plugin' ) ) {

        $options[] = array(
            'title'       => __( 'Current Header', 'phlox-pro' ),
            'id'          => 'site_elementor_header_edit_template',
            'section'     => 'header-section-builder',
            'type'        => 'edit_template',
            'template'    => 'header',
            'transport'   => 'refresh',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_use_legacy',
                     'value'   => '1',
                     'operator'=> '!='
                ),
            ),
        );

        $options[] = array(
            'title'         => __( 'Your Headers', 'phlox-pro' ),
            'id'            => 'site_elementor_header_template',
            'section'       => 'header-section-builder',
            'type'          => 'selective_list',
            'choices'       => auxin_get_elementor_templates_list('header'),
            'dependency'    => array(
                array(
                     'id'      => 'site_header_use_legacy',
                     'value'   => '1',
                     'operator'=> '!='
                ),
            ),
            'related_controls' => 'site_elementor_header_edit_template'
        );

        $options[] = array(
            'title'         => __( 'Header Templates Library', 'phlox-pro' ),
            'id'            => 'site_elementor_header_templates_library',
            'section'       => 'header-section-builder',
            'type'          => 'template_library',
            'template_type' => 'header',
            'dependency'    => array(
                array(
                     'id'      => 'site_header_use_legacy',
                     'value'   => '1',
                     'operator'=> '!='
                )
            ),
            'related_controls' => [ 'site_elementor_header_template' ]
        );

    } else {
        $options[] = array(
            'title'       => __( 'Header Builder', 'phlox-pro' ),
            'description' => __( 'Get header builder and templates by installing Elementor.', 'phlox-pro' ),
            'id'          => 'site_header_install_elementor',
            'section'     => 'header-section-builder',
            'type'        => 'install_elementor_plugin',
            'transport'   => 'postMessage',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_use_legacy',
                     'value'   => '1',
                     'operator'=> '!='
                )
            ),
        );
    }

    $options[] = array(
        'title'          => __( 'Use Legacy Header', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace header section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_header_use_legacy',
        'section'        => 'header-section-builder',
        'type'           => 'switch',
        'transport'      => 'refresh',
        'default'        => '0',
        'related_controls' => [
            'site_header_section_use_legacy',
            'site_header_navigation_use_legacy',
            'site_mobile_header_section_use_legacy',
            'site_topheader_section_use_legacy',
            'site_full_screen_section_use_legacy',
            'site_header_typography_section_use_legacy',
            'site_header_topbar_typography_section_use_legacy',
            'site_header_btn1_section_use_legacy',
            'site_header_btn2_section_use_legacy'
        ]
    );

    // Sub section - Header builder -------------------------------
    $sections[] = array(
        'id'          => 'header-section-template-setting',
        'parent'      => 'header-section',
        'title'       => __( 'Header Templates Settings', 'phlox-pro' ),
        'description' => __( 'Header Templates Settings', 'phlox-pro' )
    );

    $options[] = array(
        'title'       => __( 'Enable Overlay Header', 'phlox-pro' ),
        'description' => __( 'Enable it to set a overlay header', 'phlox-pro' ),
        'id'          => 'site_overlay_header',
        'section'     => 'header-section-template-setting',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            )
        ),
        'post_js'     => '$("#site-header").toggleClass("aux-transparent-header", 1 == to );',
        'default'     => '0'
    );

    $options[] = array(
        'title'       => __( 'Enable Sticky Header', 'phlox-pro' ),
        'description' => __( 'Enable it to display header menu  on top even by scrolling the page.', 'phlox-pro' ),
        'id'          => 'site_header_top_sticky',
        'section'     => 'header-section-template-setting',
        'type'        => 'switch',
        'dependency'  => array(
             array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            )
        ),
        'post_js'     => '$("body").toggleClass("aux-top-sticky", 1 == to );',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Sticky Header Background', 'phlox-pro' ),
        'description' => __( 'Specifies the sticky header color.', 'phlox-pro' ),
        'id'          => 'sticky_header_color',
        'section'     => 'header-section-template-setting',
        'dependency'  => array(
            array(
                'id'      => 'site_header_top_sticky',
                'value'   => 1,
                'operator'=> '=='
           ),
           array(
                'id'      => 'site_header_top_layout',
                'value'   => 'no-header',
                'operator'=> '!='
           ),
           array(
                'id'      => 'site_header_top_layout',
                'value'   => 'vertical',
                'operator'=> '!='
           ),
           'relation' => 'and'
        ),
        'type'          => 'color',
        'selectors'     => '.aux-elementor-header.aux-sticky .elementor-section-wrap > .elementor-section, .aux-elementor-header.aux-sticky [data-elementor-type="header"] > .elementor-section',
        'placeholder'   => 'background-color:{{VALUE}} !important;',
        'transport'     => 'postMessage',
        'default'       => '#FFFFFF'
    );

    $options[] = array(
        'title'       => __( 'Sticky Header Height', 'phlox-pro' ),
        'description' => __( 'Specifies the Sticky header height.', 'phlox-pro' ),
        'id'          => 'site_header_container_scaled_height',
        'section'     => 'header-section-template-setting',
        'dependency'  => array(
             array(
                 'id'      => 'site_header_top_sticky',
                 'value'   => 1,
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            'relation' => 'and'
        ),
        'transport'      => 'postMessage',
        'style_callback' => function( $value = null ){
            if( ! $value )
                $value = trim( esc_attr( auxin_get_option( 'site_header_container_scaled_height', 85 ) ), 'px' );

                $selector  = ".aux-top-sticky .site-header-section.aux-sticky .aux-fill .aux-menu-depth-0 > .aux-item-content, ".
                             ".aux-top-sticky .site-header-section.aux-sticky .aux-header-elements,".
                             ".aux-elementor-header.aux-sticky [data-elementor-type=\"header\"] > .elementor-section > .elementor-container,".
                             ".aux-elementor-header.aux-sticky .elementor-section-wrap > .elementor-section > .elementor-container { min-height:%spx; }";

            return sprintf( $selector , $value );
        },
        'default'   => '80',
        'type'      => 'text'
    );

    // Sub section - Header legacy notice --------------------------

    $sections[] = array(
        'id'          => 'header-section-deprecation-info',
        'parent'      => 'header-section',
        'type'        => 'Auxin_Customize_Info_Section',
        'title'       => __( 'Legacy Header Options', 'phlox-pro' ),
        'description' => __( 'The following options will be deprecated soon, Please DO NOT use them and use a "Header Template" instead.', 'phlox-pro' ),
        'dependency'  => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Legacy Header options notice', 'phlox-pro' ),
        'id'          => 'site_header_info3',
        'section'     => 'header-section-deprecation-info',
        'type'        => 'switch'
    );

    // Sub section - Header legacy options --------------------------

    $sections[] = array(
        'id'            => 'header-section-layout',
        'parent'        => 'header-section',
        'title'         => __( 'Header Section', 'phlox-pro' ),
        'description'   => __( 'Header Section Setting', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'  => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            ),
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Header', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace header section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_header_section_use_legacy',
        'section'        => 'header-section-layout',
        'type'           => 'switch',
        'default'        => '0',
        'related_controls' => ['site_header_use_legacy']
    );

    $options[] = array(
        'title'       => __( 'Header Layout', 'phlox-pro' ),
        'description' => __( 'Specifies header layout.', 'phlox-pro' ),
        'id'          => 'site_header_top_layout',
        'section'     => 'header-section-layout',
        'type'        => 'radio-image',
        'choices' => array(
            'horizontal-menu-right' => array(
                'label' => __( 'Logo left, Menu right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-layout-1.svg'
            ),
            'burger-right' => array(
                'label' => __( 'Logo left, Burger menu right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-layout-2.svg'
            ),
            'horizontal-menu-left' => array(
                'label'     => __( 'Logo right, Menu left', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-layout-7.svg'
            ),
            'burger-left' => array(
                'label' => __( 'Logo Right, Burger menu left', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-layout-8.svg'
            ),
            'horizontal-menu-center' => array(
                'label' => __( 'Logo middle in top, Menu middle in bottom', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-layout-4.svg'
            ),
            'logo-left-menu-bottom-left' => array(
                'label' => __( 'Logo left in top, Menu left in bottom', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-layout-3.svg'
            ),

            'burger-right-msg'  => array(
                'label' => __( 'Logo left, Burger right, Message right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-layout-2.svg'
            ),
            'logo-left-menu-middle'  => array(
                'label' => __( 'Logo left, Menu Middle', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-layout-2.svg'
            ),
            'vertical'  => array(
                'label' => __( 'Vertical Menu', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-layout-6.svg'
            ),
            'no-header' => array(
                'label' => __( 'No header', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/header-none.svg'
            )
        ),
        'transport' => 'refresh',
        'default'   => 'horizontal-menu-right',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            ),
        ),
    );

    $options[] = array(
        'title'         => __( 'Header Width', 'phlox-pro' ),
        'description'   => sprintf(__( 'Specifies boxed or fullwidth header.%1$s Only works if %2$s Website Layout %3$s option sets to %2$s Full layout %3$s', 'phlox-pro' ), '<br>', '<code>', '</code>'),
        'id'            => 'site_header_width',
        'section'       => 'header-section-layout',
        'type'          => 'radio-image',
        'choices'       => array(
            'boxed'         => array(
                'label'     => __( 'Boxed', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-boxed',
            ),
            'semi-full'     => array(
                'label'     => __( 'Full Width', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-full',
            )
        ),
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".aux-top-header, .site-header-section").removeClass("aux-boxed-container")
                        .removeClass("aux-semi-full-container").addClass("aux-"+ to +"-container");',
        'default'   => 'boxed'
    );

    $options[] = array(
        'title'          => __( 'Header Height', 'phlox-pro' ),
        'description'    => __( 'Specifies the header height in pixel.', 'phlox-pro' ),
        'id'             => 'site_header_container_height',
        'section'        => 'header-section-layout',
        'transport'      => 'postMessage',
        'style_callback' => function( $value = null ){
            if( ! $value )
                $value = esc_attr( auxin_get_option( 'site_header_container_height' ) );

            $value = rtrim( $value, 'px' );
            $selector  = ".site-header-section .aux-header-elements:not(.aux-vertical-menu-elements), ";
            $selector .= ".site-header-section .aux-fill .aux-menu-depth-0 > .aux-item-content { height:%spx; }";

            return sprintf( $selector , $value );
        },
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
             array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
             ),
             array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'default'   => '85',
        'type'      => 'text'
    );

    $options[] = array(
        'title'       => __( 'Add Search Button', 'phlox-pro' ),
        'description' => __( 'Enable it to add search button in the header.', 'phlox-pro' ),
        'id'          => 'site_header_search_button',
        'section'     => 'header-section-layout',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
             array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
             ),
             array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.site-header-section .aux-wrapper .aux-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){ echo auxin_get_header_layout(); }
        ),
        'default'     => '0'
    );

   $options[] = array(
        'title'       => __( 'Add Social Icons', 'phlox-pro' ),
        'description' => __( 'Enable it to add social icons in the header menu.', 'phlox-pro' ),
        'id'          => 'site_header_social_icons',
        'section'     => 'header-section-layout',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.site-header-section .aux-wrapper .aux-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){ echo auxin_get_header_layout(); }
        ),
        'default'     => '0'
    );

    $options[] = array(
        'title'       => __( 'Header Message Text', 'phlox-pro' ),
        'description' => __( 'Enable it to add message in the header menu.', 'phlox-pro' ),
        'id'          => 'site_header_msg_text',
        'section'     => 'header-section-layout',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'burger-right-msg',
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'transport'   => 'postMessage',
        'post_js'   => '$(".aux-header-msg p").html( to );',
        'default'   => '',
        'starter'   => __( 'Welcome to your WordPress Website.', 'phlox-pro' ),
        'type'      => 'textarea'
    );

    $options[] = array(
        'title'       => __( 'Social Icon Size', 'phlox-pro' ),
        'description' => __( 'Specifies the size of social icons in the header menu.', 'phlox-pro' ),
        'id'          => 'site_header_social_icons_size',
        'section'     => 'header-section-layout',
        'default'     => 'small',
        'type'        => 'select',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_social_icons',
                 'value'   => array('1')
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.site-header-section .aux-wrapper .aux-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){ echo auxin_get_header_layout(); }
        ),
        'choices'     => array(
            'small'       => __( 'Small', 'phlox-pro' ),
            'normal'      => __( 'Normal', 'phlox-pro' ),
            'large'       => __( 'Large', 'phlox-pro' ),
            'extra-large' => __( 'Extra Large', 'phlox-pro' ),
        ),
    );

    $options[] = array(
        'title'       => __( 'Display Logo', 'phlox-pro' ),
        'description' => __( 'Enable it to add logo in the header.', 'phlox-pro' ),
        'id'          => 'show_header_logo',
        'section'     => 'header-section-layout',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.site-header-section .aux-wrapper .aux-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){ echo auxin_get_header_layout(); }
        ),
        'default'     => '1'
    );

    if ( class_exists( 'WooCommerce' ) ) {

        $options[] = array(
            'title'       => __( 'Display Header Cart', 'phlox-pro' ),
            'description' => __( 'Enable it to display cart on top header bar.', 'phlox-pro' ),
            'id'          => 'show_header_cart',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'no-header',
                     'operator'=> '!='
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'default'     => '0',
            'starter'     => '1',
            'transport'   => 'postMessage',
            'partial'     => array(
                'selector'              => '.site-header-section .aux-wrapper .aux-container',
                'container_inclusive'   => false,
                'render_callback'       => function(){ echo auxin_get_header_layout(); }
            ),
            'type'        => 'switch',
            'devices'     => array(
                'tablet' => array( 'default' => '', 'title' => __( 'Display Header Cart In Tablet', 'phlox-pro' ) ),
                'mobile' => array( 'default' => '', 'title' => __( 'Display Header Cart In Mobile', 'phlox-pro' ) )
            ),
        );

        $options[] =    array(
            'title'       => __( 'Cart Type', 'phlox-pro' ),
            'description' => '',
            'id'          => 'header_cart_type',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'no-header',
                     'operator'=> '!='
                ),
                array(
                     'id'      => 'show_header_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'transport'   => 'postMessage',
            'post_js'     => '$(".site-header-section .aux-cart-wrapper").alterClass( "aux-cart-type-*", "aux-cart-type-" + to );',
            'choices'     => array(
                'dropdown'     => __( 'Drop Down', 'phlox-pro' ),
                'offcanvas'     => __( 'Off Canvas', 'phlox-pro' )
            ),
            'type'        => 'select',
            'default'     => 'dropdown',
            'devices'     => array(
                'tablet' => array( 'default' => 'offcanvas', 'title' => __( 'Cart Type In Tablet', 'phlox-pro' ) ),
            ),
        );

        $options[] = array(
            'title'       => __( 'Simple Header Cart ', 'phlox-pro' ),
            'description' => __( 'Enable it to use simple mode of header cart.', 'phlox-pro' ),
            'id'          => 'site_header_card_mode',
            'section'     => 'header-section-layout',
            'type'        => 'switch',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'no-header',
                     'operator'=> '!='
                ),
                array(
                     'id'      => 'show_header_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'default'     => '0',
            'transport'   => 'refresh',
        );

        $options[] = array(

            'title'       => __( 'Icon for Cart', 'phlox-pro' ),
            'description' => '',
            'id'          => 'header_cart_icon',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'no-header',
                     'operator'=> '!='
                ),
                array(
                     'id'      => 'show_header_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'default'     => 'auxicon-shopping-cart-1-1',
            'transport'   => 'postMessage',
            'partial'     => array(
                'selector'              => '.site-header-section .aux-wrapper .aux-container',
                'container_inclusive'   => false,
                'render_callback'       => function(){ echo auxin_get_header_layout(); }
            ),
            'type'        => 'icon'
        );

        $options[] = array(
            'title'       => __( 'Text for Cart', 'phlox-pro' ),
            'description' => '',
            'id'          => 'site_header_cart_text',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'no-header',
                     'operator'=> '!='
                ),
                array(
                     'id'      => 'show_header_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'site_header_card_mode',
                     'value'   => array('0'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'default'     => __( 'Shopping Basket', 'phlox-pro' ),
            'transport'   => 'refresh',
            'type'        => 'text'
        );

        $options[] = array(
            'title'       => __( 'Basket Animation', 'phlox-pro' ),
            'description' => '',
            'id'          => 'site_header_cart_animation',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'no-header',
                     'operator'=> '!='
                ),
                array(
                     'id'      => 'show_header_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'site_header_card_mode',
                     'value'   => array('0'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'default'     => 0,
            'transport'   => 'refresh',
            'type'        => 'switch'
        );

        $options[] =    array(
            'title'       => __( 'Cart Dropdown Skin', 'phlox-pro' ),
            'description' => '',
            'id'          => 'header_cart_dropdown_skin',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'no-header',
                     'operator'=> '!='
                ),
                array(
                     'id'      => 'show_header_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'transport'   => 'postMessage',
            'post_js'     => '$(".site-header-section .aux-cart-wrapper .aux-card-dropdown").toggleClass( "aux-card-dropdown-dark", "dark" == to ); if( "dark" == to ){ $(".site-header-section .aux-cart-wrapper").find(".aux-black").toggleClass("aux-black aux-white"); } else { $(".site-header-section .aux-cart-wrapper").find(".aux-white").toggleClass("aux-white aux-black"); }',
            'choices'     => array(
                'light'     => __( 'Light', 'phlox-pro' ),
                'dark'      => __( 'Dark', 'phlox-pro' )
            ),
            'type'        => 'select',
            'default'     => 'light'
        );

        $options[] =    array(
            'title'       => __( 'Dropdown Action On', 'phlox-pro' ),
            'description' => '',
            'id'          => 'header_cart_dropdown_action_on',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'no-header',
                     'operator'=> '!='
                ),
                array(
                     'id'      => 'show_header_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'transport'   => 'postMessage',
            'post_js'     => '$(".site-header-section .aux-cart-wrapper .aux-shopping-basket").alterClass( "aux-action-on-*", "aux-action-on-" + to ); $(".site-header-section").AuxinDropdownEffect();',
            'choices'     => array(
                'hover'     => __( 'Hover', 'phlox-pro' ),
                'click'     => __( 'Click', 'phlox-pro' )
            ),
            'type'        => 'select',
            'default'     => 'hover'
        );

        $options[] = array(
            'title'       => __( 'Total Price Text in Dropdown', 'phlox-pro' ),
            'description' => '',
            'id'          => 'header_cart_dropdown_total_text',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'no-header',
                     'operator'=> '!='
                ),
                array(
                     'id'      => 'show_header_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'default'     => __( 'SUB TOTAL', 'phlox-pro' ),
            'transport'   => 'refresh',
            'type'        => 'text'
        );

        $options[] = array(
            'title'       => __( 'Display My Account', 'phlox-pro' ),
            'description' => __( 'Enable it to display myaccount on header.', 'phlox-pro' ),
            'id'          => 'show_header_myaccount',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'logo-left-menu-middle',
                     'operator'=> '=='
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'default'     => '0',
            'starter'     => '1',
            'transport'   => 'postMessage',
            'partial'     => array(
                'selector'              => '.site-header-section .aux-wrapper .aux-container',
                'container_inclusive'   => false,
                'render_callback'       => function(){ echo auxin_get_header_layout(); }
            ),
            'type'        => 'switch',
        );

        $options[] = array(
            'title'       => __( 'Display Wishlist', 'phlox-pro' ),
            'description' => __( 'Enable it to display wishlist on header.', 'phlox-pro' ),
            'id'          => 'show_header_wishlist',
            'section'     => 'header-section-layout',
            'dependency'  => array(
                array(
                     'id'      => 'site_header_top_layout',
                     'value'   => 'logo-left-menu-middle',
                     'operator'=> '=='
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
               ),
            ),
            'default'     => '0',
            'starter'     => '1',
            'transport'   => 'postMessage',
            'partial'     => array(
                'selector'              => '.site-header-section .aux-wrapper .aux-container',
                'container_inclusive'   => false,
                'render_callback'       => function(){ echo auxin_get_header_layout(); }
            ),
            'type'        => 'switch',
        );

    }

    $options[] = array(
        'title'       => __( 'Add Border', 'phlox-pro' ),
        'description' => __( 'Enable it to add border below the header.', 'phlox-pro' ),
        'id'          => 'site_header_border_bottom',
        'section'     => 'header-section-layout',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'post_js'     => '$("#site-header").toggleClass("aux-add-border", 1 == to );',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Header Animation', 'phlox-pro' ),
        'description' => __( 'Enable it to animation the header after page loads.', 'phlox-pro' ),
        'id'          => 'site_header_animation',
        'section'     => 'header-section-layout',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'default'     => '0'
    );

    $options[] = array(
        'title'       => __( 'Header Animation Delay', 'phlox-pro' ),
        'description' => __( 'The delay amount before starting the header animation in seconds.', 'phlox-pro' ),
        'id'          => 'site_header_animation_delay',
        'section'     => 'header-section-layout',
        'type'        => 'text',
        'dependency'  => array(
            array(
                'id'      => 'site_header_animation',
                'value'   => '1',
           ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'default'     => '0'
    );

    $options[] = array(
        'title'       => __( 'Header Background Color', 'phlox-pro' ),
        'description' => __( 'Specifies the background color of header ', 'phlox-pro' ),
        'id'          => 'site_transparent_header_bgcolor',
        'section'     => 'header-section-layout',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),

        ),
        'type'      => 'color',
        'selectors' => '.site-header-section',
        'placeholder'   => 'background-color:{{VALUE}};',
        'transport' => 'postMessage',
        'default'   => '#FFFFFF'
    );

    $options[] = array(
        'title'       => __( 'Header Menu Color Scheme', 'phlox-pro' ),
        'description' => __( 'Specifies the Color Scheme of Header', 'phlox-pro' ),
        'id'          => 'site_header_color_scheme',
        'section'     => 'header-section-layout',
        'transport'   => 'refresh',
        'choices'     => array(
            'light' => __( 'Light', 'phlox-pro' ),
            'dark'  => __( 'Dark', 'phlox-pro' ),
        ),
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".site-header-section").alterClass( "aux-header-*", "aux-header-" + to );',
        'type'        => 'select',
        'default'     => 'dark'
    );

    $options[] = array(
        'title'       => __( 'Sticky Header Menu Color Scheme', 'phlox-pro' ),
        'description' => __( 'Specifies the color scheme of header menu on sticky header.', 'phlox-pro' ),
        'id'          => 'site_header_sticky_color_scheme',
        'section'     => 'header-section-layout',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_sticky',
                 'value'   => 1,
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
           ),
            'relation' => 'and'
        ),
        'transport'   => 'refresh',
        'choices'     => array(
            'light' => __( 'Light', 'phlox-pro' ),
            'dark'  => __( 'Dark', 'phlox-pro' ),
        ),
        'type'        => 'select',
        'default'     => 'dark'
    );

    $options[] = array(
        'title'       => __( 'Scale Logo on Sticky Header', 'phlox-pro' ),
        'description' => __( 'Enable this option to scale logo on sticky header.', 'phlox-pro' ),
        'id'          => 'site_header_logo_can_scale',
        'section'     => 'header-section-layout',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_sticky',
                 'value'   => 1,
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
            'relation' => 'and'
        ),
        'post_js'   => '$(".aux-logo-header-inner").toggleClass("aux-scale", 1 == to );',
        'default'   => '1'
    );

    $options[] = array(
        'title'       => __( 'Vertical Menu Background Color', 'phlox-pro' ),
        'description' => __( 'Specifies the background color of Vertical menu.', 'phlox-pro' ),
        'id'          => 'site_vertical_menu_background_color',
        'section'     => 'header-section-layout',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'no-header',
                 'operator'=> '!='
            ),
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'     => 'postMessage',
        'default'       => '#FFF',
        'type'          => 'color',
        'selectors'     => '.aux-vertical-menu-side',
        'placeholder'   => 'background-color:{{VALUE}};'
    );


    // Sub section - navigation options -------------------------------

    $sections[] = array(
        'id'            => 'header-section-main-nav',
        'parent'        => 'header-section',                            // section parent's id
        'title'         => __( 'Header Menu', 'phlox-pro' ),
        'description'   => __( 'Header Menu Options', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'  => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            ),
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Header', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace header section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_header_navigation_use_legacy',
        'section'        => 'header-section-main-nav',
        'type'           => 'switch',
        'default'        => '0',
        'related_controls' => ['site_header_use_legacy']
    );

    $options[] = array(
        'title'       => __( 'Header Submenu Skin', 'phlox-pro' ),
        'description' => __( 'Specifies submenu skin.', 'phlox-pro' ),
        'id'          => 'site_header_navigation_sub_skin',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'default'     => 'classic',
        'type'        => 'radio-image',
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-header .aux-master-menu").alterClass( "aux-skin-*", "aux-skin-" + to );',
        'choices'     => array(
            'classic'       => array(
                'label'     => __( 'Paradox', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-1.svg'
            ),
            'classic-center'=> array(
                'label'     => __( 'Classic', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-2.svg'
            ),
            'dash-divided'  => array(
                'label'     => __( 'Dark Transparent', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-5.svg'
            ),
            'divided'       => array(
                'label'     => __( 'Divided', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-3.svg'
            ),
            'minimal-center'=> array(
                'label'     => __( 'Center Paradox', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-4.svg'
            ),
            'modern'        => array(
                'label'     => __( 'Modern Paradox', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-6.svg'
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Vertical Menu Items Align', 'phlox-pro' ),
        'description' => '',
        'id'          => 'site_vertical_header_items_align',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'   => 'refresh',
        'post_js'     => '$(".aux-header .aux-master-menu").alterClass( "aux-*-nav", "aux-" + to + "-nav" );',
        'choices'     => array(
            'center'     => __( 'Center', 'phlox-pro' ),
            'left'       => __( 'Left', 'phlox-pro' ),
        ),
        'type'     => 'select',
        'default'  => 'left'
    );

    $options[] = array(
        'title'       => __( 'Vertical Header Submenu Skin', 'phlox-pro' ),
        'description' => __( 'Specifies submenu skin.', 'phlox-pro' ),
        'id'          => 'site_vertical_header_navigation_sub_skin',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'default'     => 'classic',
        'type'        => 'radio-image',
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-header .aux-master-menu").alterClass( "aux-skin-*", "aux-skin-" + to );',
        'choices'     => array(
            'classic'       => array(
                'label'     => __( 'Paradox', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-1.svg'
            ),
            'dash-divided'  => array(
                'label'     => __( 'Dark Transparent', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-5.svg'
            ),
            'divided'       => array(
                'label'     => __( 'Divided', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-3.svg'
            ),
            'modern'        => array(
                'label'     => __( 'Modern Paradox', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-6.svg'
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Submenu animation effect', 'phlox-pro' ),
        'description' => '',
        'id'          => 'site_header_navigation_sub_effect',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-header .aux-master-menu").alterClass( "aux-*-nav", "aux-" + to + "-nav" );',
        'choices'     => array(
            ''         => array(
                'label'     => __( 'None', 'phlox-pro' ),
                'video_src' => AUXIN_URL . 'images/visual-select/videos/NoFade.webm webm'
            ),
            'fade'     => array(
                'label'     => __( 'Fade', 'phlox-pro' ),
                'video_src' => AUXIN_URL . 'images/visual-select/videos/Fade.webm webm'
            ),
            'slide-up' => array(
                'label'     => __( 'Fade and move', 'phlox-pro' ),
                'video_src' => AUXIN_URL . 'images/visual-select/videos/FadeAndMove.webm webm'
            )
        ),
        'type'     => 'radio-image',
        'default'  => ''
    );

    $options[] = array(
        'title'       => __( 'Display Submenu Indicator', 'phlox-pro' ),
        'description' => __( 'Add submenu indicator icon to header menu items.', 'phlox-pro' ),
        'id'          => 'site_header_navigation_with_indicator',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-header .aux-master-menu").toggleClass( "aux-with-indicator", 1 == to );',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Menu Splitter', 'phlox-pro' ),
        'description' => __( 'Insert splitter symbol between menu items in header.', 'phlox-pro' ),
        'id'          => 'site_header_navigation_with_splitter',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-header .aux-master-menu").toggleClass( "aux-with-splitter", 1 == to );',
        'default'     => '1'
    );


    $options[] = array(
        'title'       => __( 'Display Vertical Menu Footer', 'phlox-pro' ),
        'description' => __( 'Enable it to display footer at the bottom of vertical menu.', 'phlox-pro' ),
        'id'          => 'site_vertical_menu_footer_display',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                'id'       => 'site_header_top_layout',
                'value'    => 'vertical',
                'operator' => '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'  => 'refresh',
        'default'    => '1',
        'type'       => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Display Searchbox Border', 'phlox-pro' ),
        'description' => __( 'Specifies the display of border under the search box', 'phlox-pro' ),
        'id'          => 'site_vertical_header_search_border',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'site_vertical_menu_footer_display',
                 'value'   => array('1')
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'  => 'postMessage',
        'post_js'    => '$(".aux-header .aux-search-box").toggleClass( "aux-search-no-border", 0 == to );',
        'type'       => 'switch',
        'default'    => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Vertical Menu Copyright Text', 'phlox-pro' ),
        'description' => __( 'Enable it to display copyright text at the bottom of vertical menu.', 'phlox-pro' ),
        'id'          => 'site_vertical_menu_copyright',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                 'id'      => 'site_header_top_layout',
                 'value'   => 'vertical',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'site_vertical_menu_footer_display',
                 'value'   => array('1')
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'  => 'refresh',
        'default'    => '1',
        'type'       => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Submenu location ', 'phlox-pro' ),
        'description' => __( 'Set the location of submenu in header area.', 'phlox-pro' ),
        'id'          => 'site_header_navigation_sub_location',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
            array(
                'id'       => 'site_header_top_layout',
                'value'    => 'vertical',
                'operator' => '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'default'     => 'below-header',
        'type'        => 'radio-image',
        'transport'   => 'refresh',
        'choices'     => array(
            'below-header'  => array(
                'label'     => __( 'Below header', 'phlox-pro' ),
                'image'     => AUXIN_URL . 'images/visual-select/sub-menu-padding-1.svg'
            ),
            'below-menu-item' => array(
                'label'     => __( 'Below header menu items', 'phlox-pro' ),
                'image'     => AUXIN_URL . 'images/visual-select/sub-menu-padding-2.svg'
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Menu height', 'phlox-pro' ),
        'description' => __( 'Specifies minimum height of main menu items.', 'phlox-pro' ),
        'id'          => 'site_header_navigation_item_height',
        'section'     => 'header-section-main-nav',
        'dependency'  => array(
             array(
                 'id'      => 'site_header_navigation_sub_location',
                 'value'   => 'below-menu-item',
                 'operator'=> '=='
            ),
            array(
                'id'       => 'site_header_top_layout',
                'value'    => 'vertical',
                'operator' => '!='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'      => 'postMessage',
        'style_callback' => function( $value = null ){
            if( ! $value )
                $value = esc_attr( auxin_get_option( 'site_header_navigation_item_height' ) );

            $selector = ".site-header-section .aux-middle .aux-menu-depth-0 > .aux-item-content { height:%spx; }";

            return sprintf( $selector , $value );
        },
        'default'   => '60',
        'type'      => 'text'
    );


    // Sub section - header mobile options -------------------------------

    $sections[] = array(
        'id'            => 'header-section-mobile-header',
        'parent'        => 'header-section',                            // section parent's id
        'title'         => __( 'Burger Menu', 'phlox-pro' ),
        'description'   => __( 'Burger Menu Options', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );


    $options[] = array(
        'title'          => __( 'Use Legacy Header', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace header section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_mobile_header_section_use_legacy',
        'section'        => 'header-section-mobile-header',
        'type'           => 'switch',
        'default'        => '0',
        'related_controls' => ['site_header_use_legacy']
    );

    $options[] = array(
        'title'          => __( 'Burger Button Color', 'phlox-pro' ),
        'description'    => __( 'Specifies burger button color.', 'phlox-pro' ),
        'id'             => 'site_mobile_header_toggle_button_color',
        'section'        => 'header-section-mobile-header',
        'dependency'  => array(
           array(
               'id'      => 'site_header_use_legacy',
               'value'   => '1',
               'operator'=> '=='
           ),
        ),
        'transport'      => 'postMessage',
        'default'        => '#3d3d3d',
        'type'           => 'color',
        'selectors'      => '.site-header-section .aux-header .aux-burger:before, .site-header-section .aux-header .aux-burger:after, .site-header-section .aux-header .aux-burger .mid-line',
        'placeholder'    => 'border-color:{{VALUE}};'
    );

    $options[] = array(
        'title'          => __( 'Burger Button Style', 'phlox-pro' ),
        'description'    => __( 'Specifies burger button style.', 'phlox-pro' ),
        'id'             => 'site_mobile_header_toggle_button_style',
        'section'        => 'header-section-mobile-header',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'      => 'postMessage',
        'post_js'        => '$(".site-header-section  .aux-burger-box .aux-burger").alterClass( "aux-(l|r|t)*", to );',
        'type'           => 'radio-image',
        'default'        => 'aux-lite-small',
        'choices'                => array(
            'aux-lite-large'     => array(
                'label'          => __( 'Expandable under top header', 'phlox-pro' ),
                'image'          => AUXIN_URL . 'images/visual-select/burger-lite-large.svg'
            ),
            'aux-regular-large'  => array(
                'label'          => __( 'Offcanvas panel', 'phlox-pro' ),
                'image'          => AUXIN_URL . 'images/visual-select/burger-regular-large.svg'
            ),
            'aux-thick-large'    => array(
                'label'          => __( 'Offcanvas panel', 'phlox-pro' ),
                'image'          => AUXIN_URL . 'images/visual-select/burger-thick-large.svg'
            ),
            'aux-lite-medium'    => array(
                'label'          => __( 'FullScreen on entire page', 'phlox-pro' ),
                'image'          => AUXIN_URL . 'images/visual-select/burger-lite-medium.svg'
            ),
            'aux-regular-medium' => array(
                'label'          => __( 'Offcanvas panel', 'phlox-pro' ),
                'image'          => AUXIN_URL . 'images/visual-select/burger-regular-medium.svg'
            ),
            'aux-thick-medium'   => array(
                'label'          => __( 'Offcanvas panel', 'phlox-pro' ),
                'image'          => AUXIN_URL . 'images/visual-select/burger-thick-medium.svg'
            ),
            'aux-lite-small'     => array(
                'label'          => __( 'Offcanvas panel', 'phlox-pro' ),
                'image'          => AUXIN_URL . 'images/visual-select/burger-lite-small.svg'
            ),
            'aux-regular-small'  => array(
                'label'          => __( 'Offcanvas panel', 'phlox-pro' ),
                'image'          => AUXIN_URL . 'images/visual-select/burger-regular-small.svg'
            ),
            'aux-thick-small'    => array(
                'label'          => __( 'Offcanvas panel', 'phlox-pro' ),
                'image'          => AUXIN_URL . 'images/visual-select/burger-thick-small.svg'
            )
        )
    );

    // there are 3 types toggle, fulscreen and sidebar and all the other options are related to this choice (toggle-bar, offcanvas, overlay, none)
    $options[] = array(
        'title'       => __( 'Burger Menu Location', 'phlox-pro' ),
        'description' => __( 'Specifies where menu appears when the burger button is clicked.', 'phlox-pro' ),
        'id'          => 'site_header_mobile_menu_position',
        'section'     => 'header-section-mobile-header',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'   => 'refresh',
        'default'     => 'toggle-bar',
        'type'        => 'radio-image',
        'choices'     => array(
            'toggle-bar' => array(
                'label'     => __( 'Expandable under top header', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/burger-menu-location-1.svg'
            ),
            'overlay'   => array(
                'label'     => __( 'FullScreen on entire page', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/burger-menu-location-3.svg'
            ),
            'offcanvas' => array(
                'label'     => __( 'Offcanvas panel', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/burger-menu-location-2.svg'
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Fullscreen Menu Background Color', 'phlox-pro' ),
        'description' => __( 'Specifies the background color of fullscreen menu and search panel.', 'phlox-pro' ),
        'id'          => 'site_menu_full_screen_background_color',
        'section'     => 'header-section-mobile-header',
        'dependency'  => array(
            array(
                'id'      => 'site_header_mobile_menu_position',
                'value'   => 'overlay',
                'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'      => 'postMessage',
        'default'   => 'rgba(255, 255, 255, 0.95)',
        'type'      => 'color',
        'selectors'      => '#fs-menu-search:before',
        'placeholder'    => 'background-color:{{VALUE}};'
    );

    $options[] = array(
        'title'       => __( 'Fullscreen Menu Skin', 'phlox-pro' ),
        'description' => __( 'Specifies the skin of fullscreen menu panel.', 'phlox-pro' ),
        'id'          => 'site_menu_full_screen_skin',
        'section'     => 'header-section-mobile-header',
        'dependency'  => array(
            array(
                'id'      => 'site_header_mobile_menu_position',
                'value'   => 'overlay',
                'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport' => 'postMessage',
        'post_js'   => '$("#fs-menu-search").alterClass("aux-dark", to );',
        'choices'    => array(
            '' => array(
                'label'     => __( 'Light', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/fullscreen-menu-light.svg'
            ),
            'aux-dark' => array(
                'label'     => __( 'Dark', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/fullscreen-menu-dark.svg'
            )
        ),
        'default'    => '',
        'type'       => 'radio-image'
    );

    $options[] = array(
        'title'       => __( 'FullScreen Menu Templates', 'phlox-pro' ),
        'description' => __( 'Select Specific Template For FullScreen Menu', 'phlox-pro' ),
        'id'          => 'site_header_fullscreen_template',
        'section'     => 'header-section-mobile-header',
        'dependency'  => array(
            array(
                'id'      => 'site_header_mobile_menu_position',
                'value'   => 'overlay',
                'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'default'     => 'center',
        'type'        => 'radio-image',
        'choices'     => array(
            'center'  => array(
                'label'     => __( 'Center Template', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/burger-menu-location-3.svg'
            ),
            'left' => array(
                'label'     => __( 'Left side Template', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/fullscreen-menu-left-light.svg'
            )
        ),
        'transport' => 'refresh',
    );

    $options[] = array(
        'title'       => __( 'Fullscreen Menu Background Image', 'phlox-pro' ),
        'description' => __( 'Specifies the background image of fullscreen menu panel', 'phlox-pro' ),
        'id'          => 'site_menu_full_screen_background_image',
        'section'     => 'header-section-mobile-header',
        'dependency'  => array(
            array(
                'id'      => 'site_header_mobile_menu_position',
                'value'   => 'overlay',
                'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'   => 'postMessage',
        'style_callback' => function( $value = null ){
            if( ! $value )
                $value = esc_attr( auxin_get_option( 'site_menu_full_screen_background_image', 'none' ) );

            $value = auxin_get_attachment_url( $value, 'full' );
            return empty( $value ) ? '' : sprintf( "#fs-menu-search:after { background-image:url( %s ); }" , $value );
        },
        'default'     => '',
        'type'        => 'image'
    );

    $options[] = array(
        'title'       => __( 'Display Submenu Indicator', 'phlox-pro' ),
        'description' => __( 'Add submenu indicator icon to menu items.', 'phlox-pro' ),
        'id'          => 'site_header_fullscreen_indicator',
        'section'     => 'header-section-mobile-header',
        'dependency'  => array(
            array(
                'id'      => 'site_header_mobile_menu_position',
                'value'   => 'overlay',
                'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'default'   => '1',
        'type'      => 'switch',
        'transport' => 'refresh',
    );

    // there are 3 types toggle, fulscreen and sidebar and all the other options are related to this choice (toggle-bar, offcanvas, overlay, none)
    $options[] = array(
        'title'       => __( 'Offcanvas Alignment', 'phlox-pro' ),
        'description' => __( 'Specifies where offcanvas menu appears when the burger button is clicked.', 'phlox-pro' ),
        'id'          => 'site_header_mobile_menu_offcanvas_alignment',
        'section'     => 'header-section-mobile-header',
        'dependency'  => array(
            array(
                'id'      => 'site_header_mobile_menu_position',
                'value'   => 'offcanvas',
                'operator'=> '=='
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'default'     => 'left',
        'type'        => 'radio-image',
        'choices'     => array(
            'left'  => array(
                'label'     => __( 'Left side', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/off-canvas-position-left.svg'
            ),
            'right' => array(
                'label'     => __( 'Right side', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/off-canvas-position-right.svg'
            )
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".aux-offcanvas-menu").alterClass("aux-pin-*", "aux-pin-" + to );'
    );

    // (toggle, accordion, horizontal, vertical, cover)
    $options[] = array(
        'title'       => __( 'Burger Menu Toggle Type', 'phlox-pro' ),
        'description' => __( 'Specifies only one submenu displays at a time or multiple.', 'phlox-pro' )  . '<br>' .
                         __( 'Hover over images to see the animation.', 'phlox-pro' ),
        'id'          => 'site_header_mobile_menu_type',
        'section'     => 'header-section-mobile-header',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'   => 'refresh',
        'default'     => 'toggle',
        'type'        => 'radio-image',
        'choices'     => array(
            'toggle'    => array(
                'label'     => __( 'Toggle', 'phlox-pro' ),
                'video_src' => AUXIN_URL . 'images/visual-select/videos/BurgerMenu-Toggle.webm webm'
            ),
            'accordion' => array(
                'label'     => __( 'Accordion', 'phlox-pro' ),
                'video_src' => AUXIN_URL . 'images/visual-select/videos/BurgerMenu-Accordion.webm webm'
            )
        )
    );




    // Sub section - Top Header -------------------------------

    $sections[] = array(
        'id'            => 'header-section-topbar',
        'parent'        => 'header-section',                               // section parent's id
        'title'         => __( 'Top Header bar', 'phlox-pro' ),
        'description'   => __( 'Top Header bar Setting', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Header', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace header section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_topheader_section_use_legacy',
        'section'        => 'header-section-topbar',
        'type'           => 'switch',
        'default'        => '0',
        'related_controls' => ['site_header_use_legacy']
    );

    $options[] = array(
        'title'       => __( 'Display Top Header bar', 'phlox-pro' ),
        'description' => __( 'Enable it to display top header bar. You can display socials, message and call info there.', 'phlox-pro' ),
        'id'          => 'show_topheader',
        'section'     => 'header-section-topbar',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'default'     => '0',
        'starter'     => '1',
        'post_js'     => '$(".aux-top-header").auxToggle( to );',
        'transport'   => 'postMessage',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Layout', 'phlox-pro' ),
        'description' => __( 'Specifies the layout for top header bar.', 'phlox-pro' ),
        'id'          => 'site_top_header_layout',
        'section'     => 'header-section-topbar',
        'type'        => 'radio-image',
        'dependency'  => array(
            array(
                 'id'      => 'show_topheader',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'choices' => array(
            'topheader1' => array(
                'label'     => __( 'Menu left. Social and search right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/top-header-layout-1.svg'
            ),
            'topheader2' => array(
                'label'     => __( 'Message left. Menu and language right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/top-header-layout-2.svg'
            ),
            'topheader3' => array(
                'label'     => __( 'Social left. Cart and search right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/top-header-layout-3.svg'
            ),
            'topheader4' => array(
                'label'     => __( 'Menu left. Message, social, cart, search and language right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/top-header-layout-4.svg'
            ),
            'topheader5' => array(
                'label'     => __( 'Language left. Social, cart and search right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/top-header-layout-5.svg'
            ),
            'topheader6' => array(
                'label'     => __( 'Message left. Social, cart and search right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/top-header-layout-6.svg'
            ),
            'topheader7' => array(
                'label'     => __( 'Menu left. Social, cart and search right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/top-header-layout-7.svg'
            ),
            'topheader8' => array(
                'label'     => __( 'Language and menu left. Message, social, cart and search right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/top-header-layout-8.svg'
            ),
            'topheader9' => array(
                'label'     => __( 'Message Left, Secondary Message Right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/top-header-layout-8.svg'
            )
        ),
        'partial'     => array(
            'selector'              => '.aux-top-header .aux-wrapper',
            'container_inclusive'   => false,
            'render_callback'       => function(){ echo auxin_get_top_header_markup(); }
        ),
        'transport' => 'postMessage',
        'default'   => 'topheader1'
    );

    if ( class_exists( 'WooCommerce' ) ) {

        $options[] = array(
            'title'       => __( 'Display Top Header Cart', 'phlox-pro' ),
            'description' => __( 'Enable it to display cart on top header bar.', 'phlox-pro' ),
            'id'          => 'show_topheader_cart',
            'section'     => 'header-section-topbar',
            'dependency'  => array(
                array(
                     'id'      => 'site_top_header_layout',
                     'value'   => array('topheader3', 'topheader4', 'topheader5', 'topheader6', 'topheader7', 'topheader8'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'show_topheader',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
                ),
            ),
            'default'     => '0',
            'starter'     => '1',
            'transport'   => 'postMessage',
            'partial'     => array(
                'selector'              => '.aux-top-header .aux-wrapper',
                'container_inclusive'   => false,
                'render_callback'       => function(){ echo auxin_get_top_header_markup(); }
            ),
            'type'        => 'switch'
        );

        $options[] = array(
            'title'       => __( 'Icon for Cart', 'phlox-pro' ),
            'id'          => 'product_cart_icon',
            'section'     => 'header-section-topbar',
            'dependency'  => array(
                array(
                     'id'      => 'site_top_header_layout',
                     'value'   => array('topheader3', 'topheader4', 'topheader5', 'topheader6', 'topheader7', 'topheader8'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'show_topheader',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'show_topheader_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
                ),
            ),
            'default'     => 'auxicon-shopping-cart-1-1',
            'starter'     => '1',
            'transport'   => 'postMessage',
            'partial'     => array(
                'selector'              => '.aux-top-header .aux-wrapper',
                'container_inclusive'   => false,
                'render_callback'       => function(){ echo auxin_get_top_header_markup(); }
            ),
            'type'        => 'icon'
        );

        $options[] =    array(
            'title'       => __( 'Cart Dropdown Skin', 'phlox-pro' ),
            'description' => '',
            'id'          => 'product_cart_dropdown_skin',
            'section'     => 'header-section-topbar',
            'dependency'  => array(
                array(
                     'id'      => 'site_top_header_layout',
                     'value'   => array('topheader3', 'topheader4', 'topheader5', 'topheader6', 'topheader7', 'topheader8'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'show_topheader',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'show_topheader_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
                ),
            ),
            'transport'   => 'postMessage',
            'post_js'     => '$(".aux-top-header .aux-cart-wrapper .aux-card-dropdown").toggleClass( "aux-card-dropdown-dark", "dark" == to ); if( "dark" == to ){ $(".aux-top-header .aux-cart-wrapper").find(".aux-black").toggleClass("aux-black aux-white"); } else { $(".aux-top-header .aux-cart-wrapper").find(".aux-white").toggleClass("aux-white aux-black"); }',
            'choices'     => array(
                'light'     => __( 'Light', 'phlox-pro' ),
                'dark'      => __( 'Dark', 'phlox-pro' )
            ),
            'type'        => 'select',
            'default'     => 'light'
        );

        $options[] =    array(
            'title'       => __( 'Dropdown Action On', 'phlox-pro' ),
            'description' => '',
            'id'          => 'product_cart_dropdown_action_on',
            'section'     => 'header-section-topbar',
            'dependency'  => array(
                array(
                     'id'      => 'site_top_header_layout',
                     'value'   => array('topheader3', 'topheader4', 'topheader5', 'topheader6', 'topheader7', 'topheader8'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'show_topheader',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'show_topheader_cart',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'site_header_use_legacy',
                    'value'   => '1',
                    'operator'=> '=='
                ),
            ),
            'transport'   => 'postMessage',
            'post_js'     => '$(".aux-top-header .aux-cart-wrapper .aux-shopping-basket").alterClass( "aux-action-on-*", "aux-action-on-" + to ); $(".aux-top-header").AuxinDropdownEffect();',
            'choices'     => array(
                'hover'     => __( 'Hover', 'phlox-pro' ),
                'click'     => __( 'Click', 'phlox-pro' )
            ),
            'type'        => 'select',
            'default'     => 'hover'
        );

    }

    $options[] = array(
        'title'       => __( 'Submenu Skin', 'phlox-pro' ),
        'description' => __( 'Specifies submenu skin.', 'phlox-pro' ),
        'id'          => 'top_header_navigation_sub_skin',
        'section'     => 'header-section-topbar',
        'dependency'  => array(
            array(
                'id' => 'show_topheader',
                'value' => array('1')
            ),
            array(
                 'id'      => 'site_top_header_layout',
                 'value'   => array('topheader1', 'topheader2', 'topheader4', 'topheader7', 'topheader8'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'choices'     => array(
            'classic'       => array(
                'label'     => __( 'Paradox', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-1.svg'
            ),
            'classic-center'=> array(
                'label'     => __( 'Classic', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-2.svg'
            ),
            'dash-divided'  => array(
                'label'     => __( 'Dark Transparent', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-5.svg'
            ),
            'divided'       => array(
                'label'     => __( 'Divided', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-3.svg'
            ),
            'minimal-center'=> array(
                'label'     => __( 'Center Paradox', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-4.svg'
            ),
            'modern'        => array(
                'label'     => __( 'Modern Paradox', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sub-menu-skin-6.svg'
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-top-header .aux-master-menu").alterClass( "aux-skin-*", "aux-skin-" + to );',
        'default'     => 'classic',
        'type'        => 'radio-image'
    );

    $options[] = array(
        'title'       => __( 'Background Color', 'phlox-pro' ),
        'description' => __( 'Specifies the background color of top header bar.', 'phlox-pro' ),
        'id'          => 'site_top_header_background_color',
        'section'     => 'header-section-topbar',
        'dependency'  => array(
            array(
                 'id'      => 'show_topheader',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'      => 'postMessage',
        'selectors'   => array(
            "#top-header" => "background-color:{{VALUE}};"
        ),
        'default'   => '#FFFFFF',
        'type'      => 'color'
    );

    $options[] = array(
        'title'       => __( 'Background Gradient', 'phlox-pro' ),
        'description' => __( 'Specifies the background color of top header bar.', 'phlox-pro' ),
        'id'          => 'site_top_header_background_gradient',
        'section'     => 'header-section-topbar',
        'dependency'  => array(
            array(
                 'id'      => 'show_topheader',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'transport'      => 'postMessage',
        'selectors'   => array(
            ".aux-top-header" => "background-image:{{VALUE}};"
        ),
        'default'   => '',
        'type'      => 'gradient'
    );

    $options[] = array(
        'title'       => __( 'Message on Top Header Bar', 'phlox-pro' ),
        'description' => __( 'Add a message to display on top header bar.', 'phlox-pro' ),
        'id'          => 'topheader_message',
        'section'     => 'header-section-topbar',
        'dependency'  => array(
            array(
                 'id'      => 'show_topheader',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'post_js'   => '$(".aux-header-msg p").html( to );',
        'default'   => '',
        'starter'   => __( 'Welcome to your WordPress Website.', 'phlox-pro' ),
        'type'      => 'textarea'
    );

    $options[] = array(
        'title'       => __( 'Secondary Message', 'phlox-pro' ),
        'description' => __( 'Add a Secondary message to display on top header bar.', 'phlox-pro' ),
        'id'          => 'topheader_secondary_message',
        'section'     => 'header-section-topbar',
        'dependency'  => array(
            array(
                 'id'      => 'show_topheader',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                 'id'      => 'site_top_header_layout',
                 'value'   => array('topheader9'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
        'post_js'   => '$(".aux-header-sec-msg p").html( to );',
        'default'   => '',
        'starter'   => __( 'Welcome to your WordPress Website.', 'phlox-pro' ),
        'type'      => 'textarea'
    );

    // Sub section - Full screen search options -------------------------------

    $sections[] = array(
        'id'            => 'header-section-fullscreen-search',
        'parent'        => 'header-section',                          // section parent's id
        'title'         => __( 'Fullscreen Search', 'phlox-pro' ),
        'description'   => __( 'Fullscreen Search', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Header', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace header section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_full_screen_section_use_legacy',
        'section'        => 'header-section-fullscreen-search',
        'type'           => 'switch',
        'default'        => '0',
        'related_controls' => ['site_header_use_legacy']
    );

    $fields_sections_list['fields'][] = array(
        'title'       => __( 'FullScreen Search Skin', 'phlox-pro' ),
        'id'          => 'header_fullscreen_search_skin',
        'section'     => 'header-section-fullscreen-search',
        'default'     => '',
        'type'        => 'radio-image',
        'transport'   => 'postMessage',
        'post_js'     => '$("#fs-search").alterClass("aux-dark", to );',
        'choices'     => array(
            ''        => array(
                'label' => __( 'Light', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/fullscreen-search-light.svg'
            ),
            'aux-dark'  => array(
                'label' => __( 'Dark', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/fullscreen-search-dark.svg'
            )
        ),
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            )
        )
    );

    // Sub section - Header typography options -------------------------------

    $sections[] = array(
        'id'            => 'header-section-typography',
        'parent'        => 'header-section',                          // section parent's id
        'title'         => __( 'Header Typography', 'phlox-pro' ),
        'description'   => __( 'Header Typography', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Header', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace header section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_header_typography_section_use_legacy',
        'section'        => 'header-section-typography',
        'type'           => 'switch',
        'default'        => '0',
        'related_controls' => ['site_header_use_legacy']
    );

    $options[] = array(
        'title'          => __( 'Main Menu', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'header_main_menu_typography',
        'section'        => 'header-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.site-header-section .aux-menu-depth-0 > .aux-item-content .aux-menu-label',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
    );

    $options[] = array(
        'title'          => __( 'Menu Dropdown', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'header_submenu_typography',
        'section'        => 'header-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.site-header-section .aux-submenu > .aux-menu-item > .aux-item-content > .aux-menu-label',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
    );

    $options[] = array(
        'title'          => __( 'Menu Active Item', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'header_menu_active_item_typography',
        'section'        => 'header-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => ".site-header-section .aux-menu-depth-0.current-menu-item > .aux-item-content .aux-menu-label",
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
    );

    $options[] = array(
        'title'          => __( 'Logo Text', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'site_title_typography',
        'section'        => 'header-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-logo-text .site-title',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
    );

    $options[] = array(
        'title'          => __( 'Site Description', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'site_description_typography',
        'section'        => 'header-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-logo-text .site-description',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
    );

    // Sub section - Header typography options -------------------------------

    $sections[] = array(
        'id'            => 'header-section-topbar-typography',
        'parent'        => 'header-section',                              // section parent's id
        'title'         => __( 'Top Header Typography', 'phlox-pro' ),
        'description'   => __( 'Top Header Typography', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Header', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace header section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_header_topbar_typography_section_use_legacy',
        'section'        => 'header-section-topbar-typography',
        'type'           => 'switch',
        'default'        => '0',
        'related_controls' => ['site_header_use_legacy']
    );

    $options[] = array(
        'title'          => __( 'Menu Typography', 'phlox-pro' ),
        'id'             => 'topheader_main_menu_typography',
        'section'        => 'header-section-topbar-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-top-header .aux-master-menu .aux-menu-depth-0 > .aux-item-content',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
    );

    $options[] = array(
        'title'          => __( 'Message Typography', 'phlox-pro' ),
        'id'             => 'topheader_message_typography',
        'section'        => 'header-section-topbar-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-top-header .aux-header-msg p',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '=='
            ),
        ),
    );

    $options[] = array(
        'title'          => __( 'Secondary Message Typography', 'phlox-pro' ),
        'id'             => 'topheader_secondary_message_typography',
        'section'        => 'header-section-topbar-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-top-header .aux-header-sec-msg p',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_header_use_legacy',
                'value'   => '1',
                'operator'=> '='
            ),
        ),
    );

    // Sub section - Website socials ----------------------------------

    $sections[] = array(
        'id'          => 'header-section-main-socials',
        'parent'      => 'header-section', // section parent's id
        'title'       => __( 'Website Socials', 'phlox-pro' ),
        'description' => __( 'Website Socials', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'  => array(
            array(
                 'id'      => 'site_header_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Hide Socials on Tablet', 'phlox-pro' ),
        'description' => __( 'Enable it to hide subfooter on tablet devices.', 'phlox-pro' ),
        'id'          => 'socials_hide_on_tablet',
        'section'     => 'header-section-main-socials',
        'default'     => '1',
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-socials-header").toggleClass( "aux-tablet-off", to );',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Hide Socials on Phone', 'phlox-pro' ),
        'description' => __( 'Enable it to hide subfooter on phone devices.', 'phlox-pro' ),
        'id'          => 'socials_hide_on_phone',
        'section'     => 'header-section-main-socials',
        'default'     => '1',
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-socials-header").toggleClass( "aux-phone-off", to );',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Use Brand Color', 'phlox-pro' ),
        'description' => __( 'Enable this option to apply brand color to each social icons.', 'phlox-pro' ),
        'id'          => 'socials_brand_color',
        'section'     => 'header-section-main-socials',
        'default'     => '0',
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-socials-header").toggleClass( "aux-brand-color", 1 == to );',
    );

    $options[] = array(
        'title'       => __( 'Use Brand Color as Hover', 'phlox-pro' ),
        'description' => __( 'You can sepcify with enable this option to use brand color for each social icons just on hover', 'phlox-pro' ),
        'id'          => 'socials_brand_color_hover',
        'section'     => 'header-section-main-socials',
        'default'     => '0',
        'type'        => 'switch',
        'transport'   => 'refresh',
        'post_js'     => '$(".aux-socials-header").toggleClass( "aux-brand-color", 1 == to );',
    );

    $options[] = array(
        'title'       => __( 'Icon Color', 'phlox-pro' ),
        'id'          => 'socials_brand_color_custom',
        'description' => __( 'Specifies the color of social icons.', 'phlox-pro' ),
        'section'     => 'header-section-main-socials',
        'type'        => 'color',
        'selectors'      => '.aux-top-header .aux-social-list a ',
        'placeholder'    => 'color:{{VALUE}};',
        'dependency'  => array(
            array(
                'id'      => 'socials_brand_color',
                'value'   => array('0'),
                'operator'=> '=='
            )
        ),
        'transport' => 'postMessage',
        'default'   => ''
    );

    $options[] = array(
        'title'       => __( 'Facebook', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'facebook',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'starter'     => '#',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Twitter', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'twitter',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'starter'     => '#',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Dribbble', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'dribbble',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'YouTube', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'youtube',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Vimeo', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'vimeo',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Flickr', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'flickr',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Digg', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'digg',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Stumbleupon', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'stumbleupon',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'LastFM', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'lastfm',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Delicious', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'delicious',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Skype', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'skype',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'starter'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'LinkedIn', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'linkedin',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Tumblr', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'tumblr',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Pinterest', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'pinterest',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Instagram', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'instagram',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'starter'     => '#',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'VK', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'vk',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'Telegram', 'phlox-pro' ),
        'description' => __( 'Should start with <code>http://</code>', 'phlox-pro' ),
        'id'          => 'telegram',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    $options[] = array(
        'title'       => __( 'RSS', 'phlox-pro' ),
        'description' => __( 'Enter your RSS Feed page. For example :', 'phlox-pro' ).' <code>'.esc_url( home_url('?feed=rss2') ).'</code>',
        'id'          => 'rss',
        'section'     => 'header-section-main-socials',
        'transport'   => 'refresh',
        'dependency'  => array(),
        'default'     => '',
        'type'        => 'text'
    );

    /* ---------------------------------------------------------------------------------------------------
        Blog Section
    --------------------------------------------------------------------------------------------------- */

    // Blog section ==================================================================

    $sections[] = array(
        'id'          => 'blog-section',
        'parent'      => '', // section parent's id
        'title'       => __( 'Blog', 'phlox-pro' ),
        'description' => __( 'Blog Setting', 'phlox-pro' ),
        'icon'        => 'axicon-doc'
    );

    // Sub section - Blog Single Page -------------------------------

    $sections[] = array(
        'id'            => 'blog-section-single',
        'parent'        => 'blog-section', // section parent's id
        'title'         => __( 'Single Post', 'phlox-pro' ),
        'description'   => __( 'Preview a blog post', 'phlox-pro' ),
        'preview_link'  => auxin_get_last_post_permalink( array( 'post_type' => 'post' ) )
    );

    // $options[] = array(
    //     'title'       => __( 'Override Single Template', 'phlox-pro' ),
    //     'description' => __( 'Disable it to replace single section with an Elementor template.', 'phlox-pro' ),
    //     'id'          => 'site_single_override_template',
    //     'section'     => 'blog-section-single',
    //     'type'        => 'switch',
    //     'transport'   => 'postMessage',
    //     'default'     => '0'
    // );

    // $options[] = array(
    //     'title'       => __( 'Elementor Single Template', 'phlox-pro' ),
    //     'id'          => 'site_single_template',
    //     'section'     => 'blog-section-single',
    //     'type'        => 'select',
    //     'default'     => ' ',
    //     'dependency'  => array(
    //         array(
    //              'id'      => 'site_single_override_template',
    //              'value'   => array('1')
    //         )
    //     ),
    //     'transport'   => 'postMessage',
    //     'choices'     => auxin_get_elementor_templates_list('single')
    // );


    $options[] = array(
        'title'       => __( 'Single Post Sidebar Position', 'phlox-pro' ),
        'description' => __( 'Specifies position of sidebar on single post.', 'phlox-pro' ),
        'id'          => 'post_single_sidebar_position',
        'section'     => 'blog-section-single',
        'dependency'  => array(),
        'post_js'     => '$(".single-post main.aux-single").alterClass( "*-sidebar", to );',
        'choices'     => array(
            'no-sidebar' => array(
                'label'     => __( 'No Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'     => __( 'Right Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar'  => array(
                'label'     => __( 'Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'     => __( 'Left Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'     => __( 'Right Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'     => __( 'Left Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'     => __( 'Right Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'default'   => 'right-sidebar',
        'type'      => 'radio-image'
    );

    $options[] =    array(
        'title'       => __( 'Single Post Sidebar Style', 'phlox-pro' ),
        'description' => 'Specifies style of sidebar on single post.',
        'id'          => 'post_single_sidebar_decoration',
        'section'     => 'blog-section-single',
        'dependency'  => array(
            array(
                 'id'      => 'post_single_sidebar_position',
                 'value'   => array('no-sidebar'),
                 'operator'=> '!='
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-post main.aux-single").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple'  => array(
                'label'  => __( 'Simple' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    $options[] =    array(
        'title'       => __( 'Single Post Featured Color', 'phlox-pro' ),
        'description' => __( 'Specifies featured color for blog posts.', 'phlox-pro' ),
        'id'          => 'post_single_featured_color',
        'section'     => 'blog-section-single',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'type'        => 'color',
        'selectors'   => ' ',
        'placeholder' => '',
        'default'     => '#1bb0ce'
    );

    $options[] = array(
        'title'       => __( 'Custom Max Width', 'phlox-pro' ),
        'description' => __( 'Specifies the maximum width of website.', 'phlox-pro' ),
        'id'          => 'post_max_width_layout',
        'section'     => 'blog-section-single',
        'type'        => 'select',
        'transport'   => 'postMessage',
        'dependency'  => array(),
        'choices'     => array(
            ''      => __( 'Default Site Max Width', 'phlox-pro' ),
            'nd'    => __( '1000 Pixels', 'phlox-pro' ),
            'hd'    => __( '1200 Pixels', 'phlox-pro' ),
            'xhd'   => __( '1400 Pixels', 'phlox-pro' ),
            's-fhd' => __( '1600 Pixels', 'phlox-pro' ),
            'fhd'   => __( '1900 Pixels', 'phlox-pro' )
        ),
        'post_js'   => 'if(to){ $( "body.single" ).removeClass( "aux-nd aux-hd aux-xhd aux-s-fhd aux-fhd" ).addClass( "aux-" + to ); $(window).trigger("resize"); }',
        'default'   => ''
    );

    $options[] = array(
        'title'       => __( 'Content Style', 'phlox-pro' ),
        'description' => __( 'You can reduce the width of text lines and increase the readability of context in single post of blog (does not affect the width of media).', 'phlox-pro' ),
        'id'          => 'post_single_content_style',
        'section'     => 'blog-section-single',
        'dependency'  => array(),
        'choices'     => array(
            'simple'  => array(
                'label'  => __( 'Default' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/content-normal.svg'
            ),
            'medium' => array(
                'label'  => __( 'Medium Width Content' , 'phlox-pro'),
                'image' => AUXIN_URL . 'images/visual-select/content-less.svg'
            ),
            'narrow' => array(
                'label'  => __( 'Narrow Content' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/content-less.svg'
            )
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".single-post .aux-primary .hentry").toggleClass( "aux-narrow-context", "narrow" == to );',
        'default'   => 'simple',
        'type'      => 'radio-image'
    );

    $options[] = array(
        'title'         => __( 'Display Content Top Margin', 'phlox-pro' ),
        'description'   => __( 'Enable it to display a space between title and content. If you need to start your content from very top of the page, disable it.', 'phlox-pro' ),
        'id'            => 'post_show_content_top_margin',
        'section'       => 'blog-section-single',
        'transport'     => 'refresh',
        'type'          => 'switch',
        'default'       => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Post Media', 'phlox-pro' ),
        'description' => __( 'Enable it to display post media (featured image, video, audio, ..) on single post page.', 'phlox-pro' ),
        'id'          => 'show_post_single_media',
        'section'     => 'blog-section-single',
        'dependency'  => '',
        'transport'   => 'refresh',
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Image Size', 'phlox-pro' ),
        'description' => __( 'Select size of featured image', 'phlox-pro' ),
        'id'          => 'post_single_image_size',
        'section'     => 'blog-section-single',
        'transport'   => 'refresh',
        'type'        => 'select',
        'choices'     => array(
            ''              => __( 'Default', 'phlox-pro' ),
            'medium'        => __( 'Medium', 'phlox-pro' ),
            'medium_large'  => __( 'Medium Large', 'phlox-pro'),
            'large'         => __( 'Large', 'phlox-pro'),
            'full'          => __( 'Original', 'phlox-pro'),
        ),
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_media',
                 'value'   => array('1'),
                 'operator'=> '='
            )
        ),
        'default'     => '',
    );

    $options[] = array(
        'title'       => __( 'Keep aspect ratio', 'phlox-pro' ),
        'description' => __( 'Enable it to keep aspect ratio of featured image.', 'phlox-pro' ),
        'id'          => 'post_single_image_keep_aspect_ratio',
        'section'     => 'blog-section-single',
        'dependency'  => '',
        'default'     => '0',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_media',
                 'value'   => array('1'),
                 'operator'=> '='
            )
        ),
    );


    $options[] = array(
        'title'       => __( 'Display Post Info', 'phlox-pro' ),
        'description' => __( 'Enable it to display post date, categories and author name in post page .', 'phlox-pro' ),
        'id'          => 'show_post_single_meta_info',
        'section'     => 'blog-section-single',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-post .aux-primary .entry-main > .entry-info").auxToggle( to );',
        'default'     => '1',
        'type'        => 'switch'
    );


    $options[] = array(
        'title'         => __( 'Display post date', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the post date.', 'phlox-pro' ),
        'id'            => 'post_meta_date_show',
        'section'       => 'blog-section-single',
        'transport'     => 'postMessage',
        'post_js'       => '$(".single-post .aux-primary .entry-main > .entry-info > .entry-date").auxToggle( to );',
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Display post author', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the post author.', 'phlox-pro' ),
        'id'            => 'post_meta_author_show',
        'section'       => 'blog-section-single',
        'transport'     => 'postMessage',
        'post_js'       => '$(".single-post .aux-primary .entry-main > .entry-info > .entry-author").auxToggle( to );',
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Display comments number', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the post comments number.', 'phlox-pro' ),
        'id'            => 'post_meta_comments_show',
        'section'       => 'blog-section-single',
        'transport'     => 'postMessage',
        'post_js'       => '$(".single-post .aux-primary .entry-main > .entry-info > .entry-comments").auxToggle( to );',
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Display post categories', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the post categories.', 'phlox-pro' ),
        'id'            => 'post_meta_categories_show',
        'section'       => 'blog-section-single',
        'transport'     => 'postMessage',
        'post_js'       => '$(".single-post .aux-primary .entry-main > .entry-info > .entry-tax").auxToggle( to );',
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '1'
    );

    if ( class_exists( 'wp_ulike' ) ) {
        $options[] = array(
            'title'       => __( 'Display Like Button', 'phlox-pro' ),
            'description' => sprintf(__( 'Enable it to display %s like button%s on single post. Please note WP Ulike plugin needs to be activaited in order to use this option.', 'phlox-pro' ), '<strong>', '</strong>'),
            'id'          => 'show_blog_post_like_button',
            'section'     => 'blog-section-single',
            'transport'   => 'postMessage',
            'post_js'     => '$(".single-post .entry-info .wpulike").auxToggle( to );',
            'type'        => 'switch',
            'dependency'  => array(
                array(
                     'id'      => 'show_post_single_meta_info',
                     'value'   => array('1'),
                     'operator'=> ''
                )
            ),
            'default'     => '1'
        );

        $options[] = array(
            'title'       => __( 'Like Button Type', 'phlox-pro' ),
            'description' => __( 'Enable it to display text instead of icon on single post.', 'phlox-pro' ),
            'id'          => 'blog_post_like_button_type',
            'section'     => 'blog-section-single',
            'transport'   => 'postMessage',
            'type'        => 'select',
            'choices'     => array(
                'icon'  => __( 'Icon', 'phlox-pro' ),
                'text'  => __( 'Text', 'phlox-pro')
            ),
            'dependency'  => array(
                array(
                     'id'      => 'show_post_single_meta_info',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'show_blog_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
               )
            ),
            'default'     => 'icon',
        );

        $options[] = array(
            'title'       => __( 'Like Button Position', 'phlox-pro' ),
            'description' => __( 'Show like button befor or after post content.', 'phlox-pro' ),
            'id'          => 'blog_post_like_button_position',
            'section'     => 'blog-section-single',
            'transport'   => 'refresh',
            'type'        => 'select',
            'choices'     => array(
                'top' => __( 'Before post content (Top)', 'phlox-pro' ),
                'bottom' => __( 'After post content (Bottom)', 'phlox-pro' )
            ),
            'dependency'  => array(
                array(
                     'id'      => 'show_post_single_meta_info',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                     'id'      => 'show_blog_post_like_button',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'blog_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            ),
            'default'     => 'top'
        );

        $options[] = array(
            'title'       => __( 'Like Icon', 'phlox-pro' ),
            'id'          => 'blog_post_like_icon',
            'section'     => 'blog-section-single',
            'transport'   => 'refresh',
            'type'        => 'icon',
            'default'     => 'auxicon-heart-2',
            'dependency'  => array(
                array(
                     'id'      => 'show_post_single_meta_info',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'show_blog_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'blog_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            )
        );

        $options[] = array(
            'title'         => __( 'Icon Liked Color', 'phlox-pro' ),
            'description'   => __( 'Like icon color','phlox-pro' ),
            'id'            => 'blog_post_like_icon_color',
            'section'       => 'blog-section-single',
            'transport'     => 'postMessage',
            'type'          => 'color',
            'selectors'     => '.single-post .wp_ulike_btn:before, .single-post .wp_ulike_is_liked .wp_ulike_btn:before ',
            'placeholder'   => 'color:{{VALUE}};',
            'default'       => '',
            'dependency'  => array(
                array(
                     'id'      => 'show_post_single_meta_info',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'show_blog_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'blog_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            )
        );

        $options[] = array(
            'title'         => __( 'Icon Not Liked Color', 'phlox-pro' ),
            'description'   => __( 'Like icon color','phlox-pro' ),
            'id'            => 'blog_post_not_like_icon_color',
            'section'       => 'blog-section-single',
            'transport'     => 'postMessage',
            'type'          => 'color',
            'selectors'     => '.single-post .wp_ulike_is_unliked .wp_ulike_btn:before',
            'placeholder'   => 'color:{{VALUE}};',
            'default'       => '',
            'dependency'  => array(
                array(
                     'id'      => 'show_post_single_meta_info',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'show_blog_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'blog_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            )
        );

        $options[] = array(
            'title'         => __( 'Icon Hover Color', 'phlox-pro' ),
            'description'   => __( 'Like icon hover color','phlox-pro' ),
            'id'            => 'blog_post_like_icon_hover_color',
            'section'       => 'blog-section-single',
            'transport'     => 'postMessage',
            'type'          => 'color',
            'selectors'     => '.single-post .wp_ulike_general_class .wp_ulike_btn:hover:before',
            'placeholder'   => 'color:{{VALUE}};',
            'default'       => '',
            'dependency'  => array(
                array(
                     'id'      => 'show_post_single_meta_info',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'show_blog_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'blog_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            )
        );

        $options[] = array(
            'title'       => __( 'Like Button Icon Size', 'phlox-pro' ),
            'id'          => 'blog_post_like_icon_size',
            'section'     => 'blog-section-single',
            'transport'   => 'postMessage',
            'type'        => 'text',
            'dependency'  => array(
                array(
                     'id'      => 'show_post_single_meta_info',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'show_blog_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'blog_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            ),
            'style_callback' => function( $value = null ){
                if( ! $value ){
                    $value = esc_attr( auxin_get_option( 'blog_post_like_icon_size' ) );
                }
                if( ! is_numeric( $value ) ){
                    $value = 10;
                }
                return $value ? ".single-post .wp_ulike_general_class .wp_ulike_btn:before { font-size:{$value}px; }" : '';
            }
        );

        $options[] = array(
            'title'          => __( 'Like Button Margin', 'phlox-pro' ),
            'id'             => 'blog_post_like_margin',
            'section'        => 'blog-section-single',
            'type'           => 'responsive_dimensions',
            'selectors'      => '.single-post .wp_ulike_general_class button',
            'transport'      => 'postMessage',
            'placeholder'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            'dependency'  => array(
                array(
                     'id'      => 'show_post_single_meta_info',
                     'value'   => array('1'),
                     'operator'=> ''
                ),
                array(
                    'id'      => 'show_blog_post_like_button',
                    'value'   => array('1'),
                    'operator'=> ''
                ),
                array(
                    'id'      => 'blog_post_like_button_type',
                    'value'   => array('icon'),
                    'operator'=> ''
                )
            ),
        );
    }

    $options[] = array(
        'title'       => __( 'Display Tags Section', 'phlox-pro' ),
        'description' => __( 'Enable it to display tags section under the post content.', 'phlox-pro' ),
        'id'          => 'show_post_single_tags_section',
        'section'     => 'blog-section-single',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-post .hentry .entry-meta").auxToggle( to );',
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Display Share Button', 'phlox-pro' ),
        'description' => __( 'Enable it to display %s share button%s on single post.', 'phlox-pro' ),
        'id'          => 'show_blog_post_share_button',
        'section'     => 'blog-section-single',
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-post .entry-info .aux-single-post-share").auxToggle( to );',
        'type'        => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'        => 'show_post_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        ),
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Share Button Type', 'phlox-pro' ),
        'description' => __( 'Enable it to display text instead of icon on single post.', 'phlox-pro' ),
        'id'          => 'blog_post_share_button_type',
        'section'     => 'blog-section-single',
        'transport'   => 'postMessage',
        'type'        => 'select',
        'choices'       => array(
            'icon'  => __( 'Icon', 'phlox-pro' ),
            'text'  => __( 'Text', 'phlox-pro' )
        ),
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'show_blog_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_post_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        ),
        'default'     => 'icon',
    );

    $options[] = array(
        'title'       => __( 'Share Button Icon', 'phlox-pro' ),
        'id'          => 'blog_post_share_button_icon',
        'section'     => 'blog-section-single',
        'transport'   => 'refresh',
        'type'        => 'icon',
        'default'     => 'auxicon-share',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'show_blog_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'blog_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_post_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Icon Color', 'phlox-pro' ),
        'description'   => __( 'Share icon color','phlox-pro' ),
        'id'            => 'blog_post_share_button_icon_color',
        'section'       => 'blog-section-single',
        'transport'     => 'postMessage',
        'type'          => 'color',
        'selectors'     => '.single-post .aux-single-post-share span::before',
        'placeholder'   => 'color:{{VALUE}};',
        'default'       => '',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'show_blog_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'blog_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_post_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Icon Hover Color', 'phlox-pro' ),
        'description'   => __( 'Share icon hover color','phlox-pro' ),
        'id'            => 'blog_post_share_button_icon_hover_color',
        'section'       => 'blog-section-single',
        'transport'     => 'postMessage',
        'type'          => 'color',
        'selectors'     => '.single-post .aux-single-post-share span:hover::before',
        'placeholder'   => 'color:{{VALUE}};',
        'default'       => '',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'show_blog_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'blog_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_post_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Share Button Icon Size', 'phlox-pro' ),
        'id'          => 'blog_post_share_button_icon_size',
        'section'     => 'blog-section-single',
        'transport'   => 'postMessage',
        'type'        => 'text',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'show_blog_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'blog_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_post_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        ),
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'blog_post_share_button_icon_size' ) );
            }
            if( ! is_numeric( $value ) ){
                $value = 10;
            }
            return $value ? ".single-post .aux-single-post-share span::before { font-size:{$value}px; }" : '';
        }
    );

    $options[] = array(
        'title'          => __( 'Share Button Margin', 'phlox-pro' ),
        'id'             => 'blog_post_share_button_margin',
        'section'        => 'blog-section-single',
        'type'           => 'responsive_dimensions',
        'selectors'      => '.single-post .aux-single-post-share',
        'transport'      => 'postMessage',
        'placeholder'    => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_meta_info',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'show_blog_post_share_button',
                'value'   => array('1'),
                'operator'=> ''
            ),
            array(
                'id'      => 'blog_post_share_button_type',
                'value'   => array('icon'),
                'operator'=> ''
            ),
            array(
                'id'        => 'show_post_single_tags_section',
                'value'     => array('1'),
                'operator'  => ''
            )
        ),
    );

    $options[] = array(
        'title'       => __( 'Display Author Section', 'phlox-pro' ),
        'description' => sprintf(__( 'Enable it to display %s author information%s after post content on single post.', 'phlox-pro' ), '<strong>', '</strong>'),
        'id'          => 'show_blog_author_section',
        'section'     => 'blog-section-single',
        'dependency'  => array(),
        'transport'   => 'refresh',
        'default'     => '0',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Display Author Biography Text', 'phlox-pro' ),
        'description' => sprintf(__( 'Enable it to display %s author biography text%s in author section on single post.', 'phlox-pro' ), '<strong>', '</strong>'),
        'id'          => 'show_blog_author_section_text',
        'section'     => 'blog-section-single',
        'dependency'  => array(
            array(
                 'id'      => 'show_blog_author_section',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-post .entry-author-info .author-description dd").auxToggle( to );',
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Display Author Socials', 'phlox-pro' ),
        'description' => sprintf(__( 'Enable it to display %s author socials%s in author section on single post.', 'phlox-pro' ), '<strong>', '</strong>'),
        'id'          => 'show_blog_author_section_social',
        'section'     => 'blog-section-single',
        'dependency'  => array(
            array(
                 'id'      => 'show_blog_author_section',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".single-post .entry-author-info .aux-author-socials").auxToggle( to );',
        'default'   => '1',
        'type'      => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Display Next & Previous Posts', 'phlox-pro' ),
        'description' => __( 'Enable it to display links to next and previous posts on single post page.', 'phlox-pro' ),
        'id'          => 'show_post_single_next_prev_nav',
        'section'     => 'blog-section-single',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'post_js'     => '$(".single .aux-next-prev-posts").auxToggle( to );',
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] =    array(
        'title'       => __( 'Skin for Next & Previous Links', 'phlox-pro' ),
        'description' => __( 'Specifies the skin for next and previous navigation block.', 'phlox-pro' ),
        'id'          => 'post_single_next_prev_nav_skin',
        'section'     => 'blog-section-single',
        'dependency'  => array(
            array(
                 'id'      => 'show_post_single_next_prev_nav',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'transport'   => 'postMessage',
        'choices'     => array(
            'minimal' => array(
                'label'     => __( 'Minimal (default)', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-1.svg'
            ),
            'thumb-arrow' => array(
                'label'     => __( 'Thumbnail with Arrow', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-2.svg'
            ),
            'thumb-no-arrow' => array(
                'label'     => __( 'Thumbnail without Arrow', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-3.svg'
            ),
            'boxed-image' => array(
                'label'     => __( 'Navigation with Light Background', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-4.svg'
            ),
            'boxed-image-dark' => array(
                'label'     => __( 'Navigation with Dark Background', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-5.svg'
            ),
            'thumb-arrow-sticky' => array(
                'label'     => __( 'Sticky Thumbnail with Arrow', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/post-navigation-6.svg'
            )
        ),
        'partial'     => array(
            'selector'              => '.aux-next-prev-posts',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_single_page_navigation(
                    array(
                        'prev_text'      => __( 'Previous Post', 'phlox-pro' ),
                        'next_text'      => __( 'Next Post'    , 'phlox-pro' ),
                        'skin'           => esc_attr( auxin_get_option( 'post_single_next_prev_nav_skin' ) ) // minimal, thumb-no-arrow, thumb-arrow, boxed-image
                    )
                );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'minimal'
    );

    $options[] = array(
        'title'       => __( 'Comment Forms Cookie Consent', 'phlox-pro' ),
        'description' => __( 'Whether to display cookie consent option on comment form for users or not.', 'phlox-pro' ),
        'id'          => 'comment_cookie_consent_enabled',
        'section'     => 'blog-section-single',
        'type'        => 'switch',
        'dependency'  => array(),
        'transport'   => 'refresh',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Comment Avatar Size', 'phlox-pro' ),
        'description' => __( 'Use custom size for avatars in comment section in pixels.', 'phlox-pro' ),
        'id'          => 'comment_avatar_size',
        'section'     => 'blog-section-single',
        'type'        => 'text',
        'transport'   => 'refresh',
        'default'     => '60'
    );

    // Sub section - Blog Single Post Title bar --------------------------------

    $sections[] = array(
        'id'           => 'blog-section-single-titlebar',
        'parent'       => 'blog-section', // section parent's id
        'title'        => __( 'Single Post Title', 'phlox-pro' ),
        'description'  => __( 'Preview Single Post', 'phlox-pro' ),
        'preview_link' => auxin_get_last_post_permalink( array( 'post_type' => 'post' ) )
    );

    $options[] = array(
        'title'         => __( 'Display Title Bar Section', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the page title section.', 'phlox-pro' ),
        'id'            => 'post_title_bar_show',
        'id_deprecated' => 'title_bar_show',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0'
    );

    $options[] = array(
        'title'         => __( 'Layout presets', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_title_bar_preset',
        'id_deprecated' => 'title_bar_preset',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'normal_title_1',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'normal_title_1' => array(
                'label'   => __( 'Default', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-4.svg',
                'presets' => array(
                    'post_title_bar_content_width_type'      => 'boxed',
                    'post_title_bar_content_section_height'  => 'auto',
                    'post_title_bar_heading_bordered'        => 0,
                    'post_title_bar_heading_boxed'           => 0,
                    'post_title_bar_meta_enabled'            => 0,
                    'post_title_bar_bread_enabled'           => 1,
                    'post_title_bar_bread_bordered'          => 0,
                    'post_title_bar_bread_sep_style'         => 'arrow',
                    'post_title_bar_text_align'              => 'left',
                    'post_title_bar_vertical_align'          => 'top',
                    'post_title_bar_scroll_arrow'            => 'none',
                    'post_title_bar_color_style'             => 'dark',
                    'post_title_bar_overlay_color'           => ''
                )
            ),
            'normal_bg_light_1' => array(
                'label'   => __( 'Title bar with light overlay which is aligned center', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-1.svg',
                'presets' => array(
                    'post_title_bar_content_width_type'      => 'boxed',
                    'post_title_bar_content_section_height'  => 'auto',
                    'post_title_bar_heading_bordered'        => 0,
                    'post_title_bar_heading_boxed'           => 0,
                    'post_title_bar_bread_enabled'           => 1,
                    'post_title_bar_bread_bordered'          => 0,
                    'post_title_bar_bread_sep_style'         => 'arrow',
                    'post_title_bar_text_align'              => 'center',
                    'post_title_bar_vertical_align'          => 'top',
                    'post_title_bar_scroll_arrow'            => 'none',
                    'post_title_bar_color_style'             => 'dark',
                    'post_title_bar_overlay_color'           => ''
                )
            ),
            'full_bg_light_1' => array(
                'label'   => __( 'Fullscreen title bar with light overlay on background', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-2.svg',
                'presets' => array(
                    'post_title_bar_content_width_type'      => 'boxed',
                    'post_title_bar_content_section_height'  => 'full',
                    'post_title_bar_heading_bordered'        => 0,
                    'post_title_bar_heading_boxed'           => 0,
                    'post_title_bar_bread_enabled'           => 1,
                    'post_title_bar_bread_bordered'          => 1,
                    'post_title_bar_bread_sep_style'         => 'slash',
                    'post_title_bar_text_align'              => 'center',
                    'post_title_bar_vertical_align'          => 'middle',
                    'post_title_bar_scroll_arrow'            => 'round',
                    'post_title_bar_color_style'             => 'dark',
                    'post_title_bar_overlay_color'           => 'rgba(255,255,255,0.50)'
                )
            ),
            'full_bg_dark_1' => array(
                'label'   => __( 'Fullscreen title bar with dark overlay on background', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-3.svg',
                'presets' => array(
                    'post_title_bar_content_width_type'      => 'boxed',
                    'post_title_bar_content_section_height'  => 'full',
                    'post_title_bar_heading_bordered'        => 0,
                    'post_title_bar_heading_boxed'           => 0,
                    'post_title_bar_bread_enabled'           => 1,
                    'post_title_bar_bread_bordered'          => 0,
                    'post_title_bar_bread_sep_style'         => 'slash',
                    'post_title_bar_text_align'              => 'center',
                    'post_title_bar_vertical_align'          => 'middle',
                    'post_title_bar_scroll_arrow'            => 'round',
                    'post_title_bar_color_style'             => 'light',
                    'post_title_bar_overlay_color'           => 'rgba(0,0,0,0.6)'
                )
            ),
            'full_bg_dark_2' => array(
                'label'   => __( 'Fullscreen title bar with border around the title', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-6.svg',
                'presets' => array(
                    'post_title_bar_content_width_type'      => 'boxed',
                    'post_title_bar_content_section_height'  => 'full',
                    'post_title_bar_heading_bordered'        => 1,
                    'post_title_bar_heading_boxed'           => 0,
                    'post_title_bar_bread_enabled'           => 0,
                    'post_title_bar_bread_bordered'          => 1,
                    'post_title_bar_bread_sep_style'         => 'slash',
                    'post_title_bar_text_align'              => 'center',
                    'post_title_bar_vertical_align'          => 'middle',
                    'post_title_bar_scroll_arrow'            => 'round',
                    'post_title_bar_color_style'             => 'dark',
                    'post_title_bar_overlay_color'           => 'rgba(250,250,250,0.3)'
                )
            ),
            'full_bg_dark_3' => array(
                'label'   => __( 'Fullscreen title bar with dark box around the title', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-7.svg',
                'presets' => array(
                    'post_title_bar_content_width_type'      => 'boxed',
                    'post_title_bar_content_section_height'  => 'full',
                    'post_title_bar_heading_bordered'        => 0,
                    'post_title_bar_heading_boxed'           => 1,
                    'post_title_bar_bread_enabled'           => 0,
                    'post_title_bar_bread_bordered'          => 0,
                    'post_title_bar_bread_sep_style'         => 'slash',
                    'post_title_bar_text_align'              => 'center',
                    'post_title_bar_vertical_align'          => 'middle',
                    'post_title_bar_scroll_arrow'            => 'round',
                    'post_title_bar_color_style'             => 'light',
                    'post_title_bar_overlay_color'           => 'rgba(0,0,0,0.5)'
                )
            ),
            'normal_bg_dark_1' => array(
                'label'   => __( 'Title aligned left with dark overlay on background', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-5.svg',
                'presets' => array(
                    'post_title_bar_content_width_type'      => 'boxed',
                    'post_title_bar_content_section_height'  => 'auto',
                    'post_title_bar_heading_bordered'        => 0,
                    'post_title_bar_heading_boxed'           => 0,
                    'post_title_bar_bread_enabled'           => 1,
                    'post_title_bar_bread_bordered'          => 0,
                    'post_title_bar_bread_sep_style'         => 'gt',
                    'post_title_bar_text_align'              => 'left',
                    'post_title_bar_vertical_align'          => 'bottom',
                    'post_title_bar_scroll_arrow'            => 'none',
                    'post_title_bar_color_style'             => 'light',
                    'post_title_bar_overlay_color'           => 'rgba(0,0,0,0.3)'
                )
            ),
            'full_bg_dark_4' => array(
                'label'   => __( 'Tile overlaps the title area section and is aligned center', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-8.svg',
                'presets' => array(
                    'post_title_bar_content_width_type'      => 'boxed',
                    'post_title_bar_content_section_height'  => 'auto',
                    'post_title_bar_heading_bordered'        => 0,
                    'post_title_bar_heading_boxed'           => 1,
                    'post_title_bar_bread_enabled'           => 1,
                    'post_title_bar_bread_bordered'          => 1,
                    'post_title_bar_bread_sep_style'         => 'gt',
                    'post_title_bar_text_align'              => 'center',
                    'post_title_bar_vertical_align'          => 'bottom-overlap',
                    'post_title_bar_scroll_arrow'            => 'none',
                    'post_title_bar_color_style'             => 'light',
                    'post_title_bar_overlay_color'           => 'rgba(0,0,0,0.5)'
                )
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Enable advanced setting', 'phlox-pro' ),
        'description'   => __( 'Enable it to customize preset layouts.', 'phlox-pro' ),
        'id'            => 'post_title_bar_enable_customize',
        'id_deprecated' => 'title_bar_enable_customize',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Content Width', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_title_bar_content_width_type',
        'id_deprecated' => 'title_bar_content_width_type',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'boxed',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'boxed' => array(
                'label'     => __( 'Boxed', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-boxed',
            ),
            'semi-full' => array(
                'label'     => __( 'Full Width Content with Space on Sides', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-full-with-spaces'
            ),
            'full' => array(
                'label' => __( 'Full Width Content', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-full'
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Title Section Height', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_title_bar_content_section_height',
        'id_deprecated' => 'title_bar_content_section_height',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'select',
        'default'       => 'auto',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'auto'  => __( 'Auto Height', 'phlox-pro' ),
            'full'  => __( 'Full Height', 'phlox-pro' )
        )
    );

    $options[] = array(
        'title'         => __( 'Vertical Position', 'phlox-pro' ),
        'description'   => __( 'Specifies vertical alignment of title and subtitle.', 'phlox-pro' ) . "<br/>".
                           __( 'Note: Parallax feature in not available for "Bottom Overlap" vertical mode.', 'phlox-pro' ),
        'id'            => 'post_title_bar_vertical_align',
        'id_deprecated' => 'title_bar_vertical_align',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'select',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'            => array(
            'top'            => __( 'Top'    , 'phlox-pro' ),
            'middle'         => __( 'Middle' , 'phlox-pro' ),
            'bottom'         => __( 'Bottom' , 'phlox-pro' ),
            'bottom-overlap' => __( 'Bottom Overlap', 'phlox-pro' )
        )
    );

    $options[] = array(
        'title'         => __( 'Scroll Down Arrow', 'phlox-pro' ),
        'description'   => __( 'This option only applies if section height is "Full Height".', 'phlox-pro' ),
        'id'            => 'post_title_bar_scroll_arrow',
        'id_deprecated' => 'title_bar_scroll_arrow',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_content_section_height',
                 'value'   => 'full',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_vertical_align',
                 'value'   => array('top', 'middle', 'bottom'),
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'none' => array(
                'label'     => __( 'None', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-none'
            ),
            'round' => array(
                'label'     => __( 'Round', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-scroll-down-arrow-outline'
            )
        )
    );


    $options[] = array(
        'title'         => __( 'Display Titles', 'phlox-pro' ),
        'description'   => __( 'Enable it to display title/subtitle in title section.', 'phlox-pro' ),
        'id'            => 'post_title_bar_title_show',
        'id_deprecated' => 'title_bar_bread_enabled',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '1',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Border for Heading', 'phlox-pro' ),
        'description'   => __( 'Enable it to display a border around the title and subtitle area.', 'phlox-pro' ),
        'id'            => 'post_title_bar_heading_bordered',
        'id_deprecated' => 'title_bar_heading_bordered',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_title_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Boxed Title', 'phlox-pro' ),
        'description'   => __( 'Enable it to wrap the title and subtitle in a box with background color.', 'phlox-pro' ),
        'id'            => 'post_title_bar_heading_boxed',
        'id_deprecated' => 'title_bar_heading_boxed',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_title_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Title Box Custom Color', 'phlox-pro' ),
        'description'   => __( 'Specifies a custom background color for the box around the title and subtitle.', 'phlox-pro' ),
        'id'            => 'post_title_bar_heading_bg_color',
        'id_deprecated' => 'title_bar_heading_bg_color',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'color',
        'selectors'     => ' ',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_title_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_heading_boxed',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );


    $options[] = array(
        'title'         => __( 'Display Post Meta', 'phlox-pro' ),
        'description'   => __( 'Enable it to display post meta information on title section.', 'phlox-pro' ),
        'id'            => 'post_title_bar_meta_enabled',
        'id_deprecated' => 'title_bar_meta_enabled',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Display Breadcrumb', 'phlox-pro' ),
        'description'   => __( 'Enable it to display breadcrumb on title section.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bread_enabled',
        'id_deprecated' => 'title_bar_bread_enabled',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '1',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Border for Breadcrumb', 'phlox-pro' ),
        'description'   => __( 'Enable it to display border around breadcrumb.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bread_bordered',
        'id_deprecated' => 'title_bar_bread_bordered',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_bread_enabled',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'       => __( 'Breadcrumb Separator Icon', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_title_bar_bread_sep_style',
        'id_deprecated' => 'title_bar_bread_sep_style',
        'section'     => 'blog-section-single-titlebar',
        'dependency'    => array(
            array(
                    'id'      => 'post_title_bar_show',
                    'value'   => '1',
                    'operator'=> '=='
            ),
            array(
                    'id'      => 'post_title_bar_enable_customize',
                    'value'   => '1',
                    'operator'=> '=='
            ),
            array(
                    'id'      => 'post_title_bar_bread_enabled',
                    'value'   => '1',
                    'operator'=> '=='
            )
        ),
        'default'     => 'auxicon-chevron-right-1',
        'transport'   => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'        => 'icon'
    );

    $options[] = array(
        'title'         => __( 'Text Align', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_title_bar_text_align',
        'id_deprecated' => 'title_bar_text_align',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'left',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'left' => array(
                'label'     => __( 'Left', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-text-align-left',
            ),
            'center' => array(
                'label'     => __( 'Center', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-text-align-center'
            ),
            'right' => array(
                'label' => __( 'Right', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-text-align-right'
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Overlay Color', 'phlox-pro' ),
        'description'   => __( 'The color that overlay on the background. Please note that color should have transparency.','phlox-pro' ),
        'id'            => 'post_title_bar_overlay_color',
        'id_deprecated' => 'title_bar_overlay_color',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'color',
        'selectors'     => ' ',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Overlay Pattern', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_title_bar_overlay_pattern',
        'id_deprecated' => 'title_bar_overlay_pattern',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'none',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'none' => array(
                'label'     => __( 'None', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-none'
            ),
            'hash' => array(
                'label'     => __( 'Hash', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-pattern',
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Overlay Pattern Opacity', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_title_bar_overlay_pattern_opacity',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'type'          => 'text',
        'default'       => '0.15',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_overlay_pattern',
                 'value'   => array('hash'),
                 'operator'=> '=='
            )
        ),
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'post_title_bar_overlay_pattern_opacity' ) );
            }
            if( ! is_numeric( $value ) || (float) $value > 1 ){
                $value = 1;
            }
            return $value ? ".single-post .aux-overlay-bg-hash::before { opacity:$value; }" : '';
        }
    );

    $options[] = array(
        'title'         => __( 'Color Mode', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_title_bar_color_style',
        'id_deprecated' => 'title_bar_color_style',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'select',
        'default'       => 'dark',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'dark'  => __( 'Dark', 'phlox-pro' ),
            'light' => __( 'Light', 'phlox-pro' )
        )
    );

        ////////////////////////////////////////////////////////////////////////////////////////

    $options[] = array(
        'title'         => __( 'Enable Title Background', 'phlox-pro' ),
        'description'   => __( 'Enable it to display custom background for title section.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bg_show',
        'id_deprecated' => 'title_bar_bg_show',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Enable Parallax Effect', 'phlox-pro' ),
        'description'   => __( 'Enable it to have parallax background effect on this section.', 'phlox-pro' )."<br />".
                           __( 'Note: Parallax feature in not available for "Bottom Overlap" mode for "Vertical Position" option.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bg_parallax',
        'id_deprecated' => 'title_bar_bg_parallax',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Background Color', 'phlox-pro' ),
        'description'   => __( 'Specifies a background color for title bar.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bg_color',
        'id_deprecated' => 'title_bar_bg_color',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'color',
        'selectors'     => ' ',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Size', 'phlox-pro' ),
        'description'   => __( 'Specifies the background size.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bg_size',
        'id_deprecated' => 'title_bar_bg_size',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'auto',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices' => array(
            'auto' => array(
                'label'       => __( 'Auto', 'phlox-pro' ),
                'css_class'   => 'axiAdminIcon-bg-size-1',
            ),
            'contain' => array(
                'label'       => __( 'Contain', 'phlox-pro' ),
                'css_class'   => 'axiAdminIcon-bg-size-2',
            ),
            'cover' => array(
                'label'       => __( 'Cover', 'phlox-pro' ),
                'css_class'   => 'axiAdminIcon-bg-size-3',
            ),
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Image', 'phlox-pro' ),
        'description'   => __( 'Specifies a background image for title bar.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bg_image',
        'id_deprecated' => 'title_bar_bg_image',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'image',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Video MP4', 'phlox-pro' ),
        'description'   => __( 'You can upload custom video for title background</br>Note: if you set custom image, default image backgrounds will be ignored.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bg_video_mp4',
        'id_deprecated' => 'title_bar_bg_video_mp4',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'video',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Video Ogg', 'phlox-pro' ),
        'description'   => __( 'You can upload custom video for title background</br>Note: if you set custom image, default image backgrounds will be ignored.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bg_video_ogg',
        'id_deprecated' => 'title_bar_bg_video_ogg',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'video',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Video WebM', 'phlox-pro' ),
        'description'   => __( 'You can upload custom video for title background</br>Note: if you set custom image, default image backgrounds will be ignored.', 'phlox-pro' ),
        'id'            => 'post_title_bar_bg_video_webm',
        'id_deprecated' => 'title_bar_bg_video_webm',
        'section'       => 'blog-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.single-post .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'video',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'post_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'post_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );



    $options[] =    array(
        'title'       => __( 'Display post title over content', 'phlox-pro' ),
        'description' => __( 'Enable it to show the main title above post content.', 'phlox-pro' ),
        'id'          => 'post_single_title_show_over_content',
        'section'     => 'blog-section-single-titlebar',
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-post main .entry-main > .entry-header .entry-title").toggleClass( "aux-visually-hide", 0 == to );',
        'type'        => 'switch',
        'default'     => '1'
    );

    $options[] =    array(
        'title'       => __( 'Title Alignment', 'phlox-pro' ),
        'description' => __( 'Specifies alignment for main title in single post content.', 'phlox-pro' ),
        'id'          => 'post_single_title_alignment',
        'section'     => 'blog-section-single-titlebar',
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-post main .entry-main > .entry-header").alterClass( "aux-text-align-*", "aux-text-align-" + to );',
        'choices'     => array(
            'default' => array(
                'label'     => __( 'Left', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-text-align-left',
            ),
            'center' => array(
                'label'     => __( 'Center', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-text-align-center'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'default'
    );

    // Sub section - Blog Archive Page -------------------------------

    $sections[] = array(
        'id'          => 'blog-section-archive',
        'parent'      => 'blog-section', // section parent's id
        'title'       => __( 'Blog Page', 'phlox-pro' ),
        'description' => __( 'Preview Blog Archive', 'phlox-pro' ),
        'preview_link'=> get_post_type_archive_link('post')
    );

    // $options[] = array(
    //     'title'       => __( 'Override Archive Template', 'phlox-pro' ),
    //     'description' => __( 'Disable it to replace archive section with an Elementor template.', 'phlox-pro' ),
    //     'id'          => 'site_archive_override_template',
    //     'section'     => 'blog-section-archive',
    //     'type'        => 'switch',
    //     'transport'   => 'postMessage',
    //     'default'     => '0'
    // );

    // $options[] = array(
    //     'title'       => __( 'Elementor Archive Template', 'phlox-pro' ),
    //     'id'          => 'site_archive_template',
    //     'section'     => 'blog-section-archive',
    //     'type'        => 'select',
    //     'default'     => ' ',
    //     'dependency'  => array(
    //         array(
    //              'id'      => 'site_archive_override_template',
    //              'value'   => array('1')
    //         )
    //     ),
    //     'transport'   => 'postMessage',
    //     'choices'     => auxin_get_elementor_templates_list('archive')
    // );

    $blog_index_template_types = array(
         // default template
        'default' => array(
            'label'  => __( 'Default', 'phlox-pro' ),
            'image' => AUXIN_URL . 'images/visual-select/blog-layout-6.svg'
        ),
        '1' => array(
            'label'  => __( 'Template 1', 'phlox-pro' ),
            'image' => AUXIN_URL . 'images/visual-select/blog-layout-1.svg'
        ),
        '2' => array(
            'label'  => __( 'Template 2' , 'phlox-pro' ),
            'image' => AUXIN_URL . 'images/visual-select/blog-layout-2.svg'
        ),
        '3' => array(
            'label'  => __( 'Template 3' , 'phlox-pro' ),
            'image' => AUXIN_URL . 'images/visual-select/blog-layout-3.svg'
        ),
        '4' => array(
            'label'  => __( 'Template 4' , 'phlox-pro' ),
            'image' => AUXIN_URL . 'images/visual-select/blog-layout-4.svg'
        )
    );

    if( function_exists( 'AUXELS' ) ){

        $advanced_layouts = array(
            '5' => array(
                'label'  => __( 'Grid' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-9.svg'
            ),
            '6' => array(
                'label'  => __( 'Masonry' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-7.svg'
            ),
            '7' => array(
                'label'  => __( 'Timeline' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-8.svg'
            ),
            '8' => array(
                'label'  => __( 'Land' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-10.svg'
            ),
            '9' => array(
                'label'  => __( 'Tiles' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-11.svg'
            )
        );

        $blog_index_template_types = $blog_index_template_types + $advanced_layouts;
    }

    $options[] = array(
        'title'       => __( 'Blog Template', 'phlox-pro' ),
        'description' => __( 'Choose your blog template.', 'phlox-pro' ),
        'id'          => 'post_index_template_type',
        'section'     => 'blog-section-archive',
        'dependency'  => array(),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'post_js'     => '$(".aux-home").alterClass( "aux-template-type-*", "aux-template-type-" + to );',
        'choices'     => $blog_index_template_types,
        'type'        => 'radio-image',
        'default'     => 'default'
    );

    $options[] = array(
        'title'       => __( 'Display Featured Media', 'phlox-pro' ),
        'description' => __( 'Enable it to display featured media on blog archive page.', 'phlox-pro' ),
        'id'          => 'blog_archive_show_featured_image',
        'section'     => 'blog-section-archive',
        'dependency'  => array(),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Custom Max Width', 'phlox-pro' ),
        'description' => __( 'Specifies the maximum width of website.', 'phlox-pro' ),
        'id'          => 'post_archive_max_width_layout',
        'section'     => 'blog-section-archive',
        'type'        => 'select',
        'transport'   => 'postMessage',
        'dependency'  => array(),
        'choices'     => array(
            ''      => __( 'Default Site Max Width', 'phlox-pro' ),
            'nd'    => __( '1000 Pixels', 'phlox-pro' ),
            'hd'    => __( '1200 Pixels', 'phlox-pro' ),
            'xhd'   => __( '1400 Pixels', 'phlox-pro' ),
            's-fhd' => __( '1600 Pixels', 'phlox-pro' ),
            'fhd'   => __( '1900 Pixels', 'phlox-pro' )
        ),
        'post_js'   => 'if(to){ $( "body.archive" ).removeClass( "aux-nd aux-hd aux-xhd aux-s-fhd aux-fhd" ).addClass( "aux-" + to ); $(window).trigger("resize"); }',
        'default'   => ''
    );

    $options[] = array(
        'title'       => __( 'Image aspect ratio', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_image_aspect_ratio',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
            array(
                'id'      => 'post_index_template_type',
                'value'   => array('5', '7', '8'),
                'operator'=> '=='
            ),
            array(
                 'id'      => 'blog_archive_show_featured_image',
                 'value'   => '1',
                 'operator'=> ''
            )
        ),
        'type'        => 'select',
        'choices'     => array(
            '0.75'          => __( 'Horizontal 4:3' , 'phlox-pro' ),
            '0.56'          => __( 'Horizontal 16:9', 'phlox-pro' ),
            '1.00'          => __( 'Square 1:1'     , 'phlox-pro' ),
            '1.33'          => __( 'Vertical 3:4'   , 'phlox-pro' )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => '0.56',
    );

    $options[] = array(
        'title'       => __( 'Auto Mask Featured Image', 'phlox-pro' ),
        'description' => __( 'By enabling this option, the featured images in blog list which are above 800 pixels in height will be automatically masked.(Max height is 800 pixels)', 'phlox-pro' ),
        'id'          => 'blog_archive_mask_featured_image',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
            array(
                 'id'      => 'blog_archive_show_featured_image',
                 'value'   => '1',
                 'operator'=> ''
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-archive .type-post .aux-media-image").toggleClass( "aux-image-mask", 1 == to );',
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Grid Layout', 'phlox-pro' ),
        'description' => __( 'Specifies the style of grid column for each post.', 'phlox-pro' ),
        'id'          => 'post_index_column_content_layout',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'radio-image',
        'choices'     => array(
            'full' => array(
                'label'  => __( 'Full Content' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/grid-normal.svg'
            ),
            'entry-boxed' => array(
                'label'  => __( 'Boxed Content' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/grid-boxed.svg'
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => 'full',
    );

    $options[] = array(
        'title'       => __( 'Display post info', 'phlox-pro' ),
        'description' => '',
        'id'          => 'display_post_info',
        'section'     => 'blog-section-archive',
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Post info position', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_info_position',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                array(
                    'id'      => 'display_post_info',
                    'value'   => array('1'),
                    'operator'=> '=='
                ),
                array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'select',
        'choices'     => array(
            'after-title'  => __( 'After Title' , 'phlox-pro' ),
            'before-title' => __( 'Before Title', 'phlox-pro' )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => 'after-title',
    );

    $options[] = array(
        'title'         => __( 'Display post date', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the post date.', 'phlox-pro' ),
        'id'            => 'display_post_info_date',
        'section'       => 'blog-section-archive',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'display_post_info',
                 'value'   => array('1'),
                 'operator'=> '=='
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Display post author', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the post author.', 'phlox-pro' ),
        'id'            => 'display_post_info_author',
        'section'       => 'blog-section-archive',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'display_post_info',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'post_index_template_type',
                'value'   => array('default', '1', '2', '3', '4'),
                'operator'=> '=='
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Categories', 'phlox-pro' ),
        'description' => '',
        'id'          => 'display_post_info_categories',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                 array(
                    'id'      => 'display_post_info',
                    'value'   => array('1'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Comment', 'phlox-pro' ),
        'description' => '',
        'id'          => 'display_post_info_comments',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                 array(
                    'id'      => 'display_post_info',
                    'value'   => array('1'),
                    'operator'=> '=='
                 ),
                 array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('1', '2', '3', '4'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Comment Number', 'phlox-pro' ),
        'description' => '',
        'id'          => 'display_post_comments_number',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                 array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6', '7', '8'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Display author or read more', 'phlox-pro' ),
        'description' => __('Specifies whether to show author or read more on each post.', 'phlox-pro'),
        'id'          => 'blog_display_author_readmore',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
            array(
               'id'      => 'post_index_template_type',
               'value'   => array('5', '6', '7', '8'),
               'operator'=> '=='
           )
        ),
        'transport'   => 'postMessage',
        'choices'     => array(
            'readmore' => __( 'Read More', 'phlox-pro' ),
            'author'   => __( 'Author'  , 'phlox-pro' ),
            'none'     => __( 'None'  , 'phlox-pro' )
        ),
        'default'     => 'readmore',
        'type'        => 'select'
    );

    $options[] = array(
        'title'       => __( 'Display Author in Header', 'phlox-pro' ),
        'description' => '',
        'id'          => 'blog_display_author_header',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                 array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6', '7', '8'),
                    'operator'=> '=='
                 ),
                 array(
                    'id'      => 'blog_display_author_readmore',
                    'value'   => array('author'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Author in Footer', 'phlox-pro' ),
        'description' => '',
        'id'          => 'blog_display_author_footer',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                 array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6', '7', '8'),
                    'operator'=> '=='
                 ),
                 array(
                    'id'      => 'blog_display_author_readmore',
                    'value'   => array('author'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'default'     => '0'
    );

    $options[] = array(
        'title'       => __( 'Number of columns', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_index_column_number',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'select',
        'choices'     => array(
                    '1'  => '1', '2' => '2', '3' => '3',
                    '4'  => '4', '5' => '5', '6' => '6'
                ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => '4',
    );

    $options[] = array(
        'title'       => __( 'Number of columns in tablet', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_index_column_number_tablet',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'select',
        'choices'     => array(
                    'inherit' => 'Inherited from larger',
                    '1'  => '1', '2' => '2', '3' => '3',
                    '4'  => '4', '5' => '5', '6' => '6'
                ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => 'inherit',
    );

    $options[] = array(
        'title'       => __( 'Number of columns in mobile', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_index_column_number_mobile',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'select',
        'choices'     => array(
                    '1'  => '1', '2' => '2', '3' => '3'
                ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => '1',
    );

    $options[] = array(
        'title'       => __( 'Exclude posts without media', 'phlox-pro' ),
        'description' => '',
        'id'          => 'exclude_without_media',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6', '7', '8', '9'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Exclude quote and link post formats', 'phlox-pro' ),
        'description' => __( 'Do not display the posts with "quote" and "link" post formats', 'phlox-pro' ),
        'id'          => 'post_exclude_quote_link_formats',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6', '7', '8', '9'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Load More Type', 'phlox-pro' ),
        'description' => __( 'Replaces the default pagination in blog archive with a load more', 'phlox-pro' ),
        'id'          => 'post_index_loadmore_type',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                array(
                    'id'      => 'post_index_template_type',
                    'value'   => array('5', '6', '7', '8', '9'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'radio-image',
        'choices'     => array(
            '' => array(
                'label'  => __( 'None' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/load-more-none.svg'
            ),
            'scroll' => array(
                'label'  => __( 'Infinite Scroll' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/load-more-infinite.svg'
            ),
            'next' => array(
                'label'  => __( 'Next Button' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/load-more-button.svg'
            ),
            'next-prev' => array(
                'label'  => __( 'Next Prev' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/load-more-next-prev.svg'
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => ''
    );

    $options[] = array(
        'title'       => __( 'Read More Text', 'phlox-pro' ),
        'description' => __( 'Select the string to read more permalink text in archive pages', 'phlox-pro' ),
        'id'          => 'post_index_read_more_text',
        'section'     => 'blog-section-archive',
        'dependency'  => '',
        'default'     => __( 'Read More', 'phlox-pro' ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'type'        => 'text'
    );

    if ( class_exists( 'wp_ulike' ) ){
        $options[] = array(
            'title'       => __( 'Display Like Button', 'phlox-pro' ),
            'description' => sprintf(__( 'Enable it to display %s like button%s on blog posts. Please note WP Ulike plugin needs to be activaited to use this option.', 'phlox-pro' ), '<strong>', '</strong>'),
            'id'          => 'show_blog_archive_like_button',
            'section'     => 'blog-section-archive',
            'dependency'  => array(
                array(
                     'id'      => 'post_index_template_type',
                     'value'   => array('5', '7', '8', '6'),
                     'operator'=> '=='
                )
            ),
            'transport'   => 'postMessage',
            'partial'     => array(
                'selector'              => '.aux-home .content',
                'container_inclusive'   => false,
                'render_callback'       => function(){
                    auxin_get_template_part( 'theme-parts/loop', 'post' );
                }
            ),
            'default'     => '1',
            'type'        => 'switch'
        );
    }

    $options[] = array(
        'title'       => __( 'Timeline Alignment', 'phlox-pro' ),
        'description' => __( 'Specifies the alignment of timeline on blog page.', 'phlox-pro' ),
        'id'          => 'post_index_timeline_alignment',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
            array(
                 'id'      => 'post_index_template_type',
                 'value'   => '7',
                 'operator'=> '=='
            )
        ),
        'type'        => 'radio-image',
        'choices'     => array(
            'center'  => array(
                'label' => __( 'Center', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-8.svg'
            ),
            'left'    => array(
                'label' => __( 'Left', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-8-left.svg'
            ),
            'right'   => array(
                'label' => __( 'Right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/blog-layout-8-right.svg'
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => 'center',
    );

    $options[] = array(
        'title'       => __( 'Blog Sidebar Position', 'phlox-pro' ),
        'description' => __( 'Specifies the position of sidebar on blog page. Please not that the sidebars in two-sidebar layouts are only visible on screen sizes with 1140px or higher in width.', 'phlox-pro' ),
        'id'          => 'post_index_sidebar_position',
        'section'     => 'blog-section-archive',
        'dependency'  => array(),
        'choices'     => array(
            'no-sidebar' => array(
                'label'  => __( 'No Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'  => __( 'Right Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar' => array(
                'label'  => __( 'Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'  => __( 'Left Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'  => __( 'Right Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'  => __( 'Left Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'  => __( 'Right Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'dependency'    => array(),
        'post_js'       => '$(".blog .aux-archive, main.aux-home").alterClass( "*-sidebar", to );',
        'type'          => 'radio-image',
        'default'       => 'right-sidebar'
    );

    $options[] = array(
        'title'       => __( 'Blog Sidebar Style', 'phlox-pro' ),
        'description' => __( 'Specifies the style of sidebar on blog page.', 'phlox-pro' ),
        'id'          => 'post_index_sidebar_decoration',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
            array(
                 'id'      => 'post_index_sidebar_position',
                 'value'   => array('no-sidebar'),
                 'operator'=> '!='
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".blog .aux-archive, main.aux-home").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple' => array(
                'label'  => __( 'Simple' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    $options[] = array(
        'title'       => __( 'Blog content length', 'phlox-pro' ),
        'description' => sprintf(__( 'Whether to display%1$ssummary%2$sor%1$sfull%2$scontent for each post on blog page', 'phlox-pro' ), '<code>', '</code>'),
        'id'          => 'blog_content_on_listing',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
                array(
                     'id'      => 'post_index_template_type',
                     'value'   => array('9'),
                     'operator'=> '!='
                )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'choices'     => array(
            'full'    => __( 'Full text', 'phlox-pro' ),
            'excerpt' => __( 'Summary'  , 'phlox-pro' ),
            'none'    => __( 'None'  , 'phlox-pro' )
        ),
        'default'     => 'full',
        'type'        => 'select'
    );

    $options[] = array(
        'title'       => __( 'Summery length', 'phlox-pro' ),
        'description' => __( 'Specifies summary character length for each post on blog page.', 'phlox-pro' ),
        'id'          => 'blog_content_on_listing_length',
        'section'     => 'blog-section-archive',
        'dependency'  => array(
            array(
                 'id'      => 'blog_content_on_listing',
                 'value'   => array('excerpt'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'post_index_template_type',
                'value'   => array('9'),
                'operator'=> '!='
           )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-home .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'   => '255',
        'type'      => 'text'
    );


    // Sub section - Blog Archive Page Slider -------------------------------

    $sections[] = array(
        'id'          => 'blog-section-archive-slider',
        'parent'      => 'blog-section', // section parent's id
        'title'       => __( 'Blog Slider', 'phlox-pro' ),
        'description' => __( 'Preview Blog Archive', 'phlox-pro' ),
        'preview_link'=> get_post_type_archive_link('post')
    );

    $options[] = array(
        'title'       => __( 'Display Slider', 'phlox-pro' ),
        'description' => __( 'Specifies to insert post slide above blog posts.', 'phlox-pro' ),
        'id'          => 'post_archive_slider_show',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'     => defined( 'AUXELS_VERSION' ) ? '1' : '0',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'         => __( 'Slider type', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_archive_slider_type',
        'section'       => 'blog-section-archive-slider',
        'dependency'    => array(
            array(
                 'id'    => 'post_archive_slider_show',
                 'value' => array(1)
            )
        ),
        'transport'     => 'refresh',
        'choices'       => array(
            'default'      => __( 'Default Post Slider', 'phlox-pro' ),
            'masterslider' => __( 'Master Slider', 'phlox-pro' ) . ( !defined( 'MSWP_AVERTA_VERSION' ) ? __(' (plugin is not installed)', 'phlox-pro') : '' )
        ),
        'type'          => 'select',
        'default'       => 'default'
    );

    if ( defined( 'MSWP_AVERTA_VERSION' ) ) {

        $ms_sliders = get_masterslider_names( true );
        $slider_ids = array();
        foreach ($ms_sliders as $ms_id => $ms_label ) {
            $slider_ids['ms_'.$ms_id] = '[Master] '. $ms_label;
        }

        $slider_ids = apply_filters( 'auxin_page_header_slider_ids', $slider_ids );
        $slider_ids = array( 'none' => 'Choose an slider' ) + $slider_ids;

        $options[] = array(
            'title'         => __( 'MasterSlider', 'phlox-pro' ),
            'description'   => __('Choose a slider from the list of available Master Sliders.', 'phlox-pro' ),
            'id'            => 'post_archive_slider_id',
            'section'       => 'blog-section-archive-slider',
            'dependency'    => array(
                array(
                    'id'    => 'post_archive_slider_show',
                    'value' => array(1)
                ),
                array(
                    'id'    => 'post_archive_slider_type',
                    'value' => 'masterslider'
                )
            ),
            'transport'     => 'refresh',
            'choices'       => $slider_ids,
            'type'          => 'select',
            'default'       => 'none'
        );
    }

    $options[] = array(
        'title'         => __( 'Slider location', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_archive_slider_location',
        'section'       => 'blog-section-archive-slider',
        'dependency'    => array(
            array(
                 'id'    => 'post_archive_slider_show',
                 'value' => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'     => 'refresh',
        'choices'   => array(
            'content' => array(
                'label' =>__( 'Insert above archive content', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/slider-position-above-content.svg'
            ),
            'block' => array(
                'label' => __( 'Insert below the header', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/slider-position-blow-header.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'block'
    );

    $options[] = array(
        'title'       => __( 'Slides number', 'phlox-pro' ),
        'description' => __( 'Specifies maximum number of slides in slider.', 'phlox-pro' ),
        'id'          => 'post_archive_slider_slides_num',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '10',
        'type'      => 'text'
    );

    $options[] = array(
        'title'       => __( 'Exclude posts', 'phlox-pro' ),
        'description' => __( 'Post IDs separated by comma (eg. 53,34,87,25).', 'phlox-pro' ),
        'id'          => 'post_archive_slider_exclude',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'     => 'post_archive_slider_show',
                'value'  => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '',
        'type'      => 'text'
    );

    $options[] = array(
        'title'       => __( 'Include posts', 'phlox-pro' ),
        'description' => __( 'Post IDs separated by comma (eg. 53,34,87,25).', 'phlox-pro' ),
        'id'          => 'post_archive_slider_include',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '',
        'type'      => 'text'
    );

    $options[] = array(
        'title'       => __( 'Start offset', 'phlox-pro' ),
        'description' => __( 'Specifies number of post to displace or pass over.', 'phlox-pro' ),
        'id'          => 'post_archive_slider_offset',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '',
        'type'      => 'text'
    );

    $options[] = array(
        'title'       => __( 'Order by', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_order_by',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'choices'   => array(
            'date'            => __( 'Date', 'phlox-pro' ),
            'menu_order date' => __( 'Menu Order', 'phlox-pro' ),
            'title'           => __( 'Title', 'phlox-pro' ),
            'ID'              => __( 'ID', 'phlox-pro' ),
            'rand'            => __( 'Random', 'phlox-pro' ),
            'comment_count'   => __( 'Comments', 'phlox-pro' ),
            'modified'        => __( 'Date Modified', 'phlox-pro' ),
            'author'          => __( 'Author', 'phlox-pro' ),
        ),
        'type'     => 'select',
        'default'  => 'date'
    );

    $options[] = array(
        'title'     => __( 'Order direction', 'phlox-pro' ),
        'description'   => '',
        'id'        => 'post_archive_slider_order_dir',
        'section'   => 'blog-section-archive-slider',
        'dependency'=> array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'choices'   => array(
                'DESC'  => __( 'Descending', 'phlox-pro' ),
                'ASC'   => __( 'Ascending', 'phlox-pro' ),
        ),
        'type'          => 'select',
        'default'       => 'DESC'
    );

    $options[] = array(
        'title'       => __( 'Slider skin', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_skin',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'    => 'post_archive_slider_show',
                'value' => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'choices'   => array(
            'aux-light-skin' => array(
                'label' =>__( 'Light and boxed', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/slider-skin-1.svg'
            ),
            'aux-dark-skin' => array(
                'label' => __( 'Dark and boxed', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/slider-skin-2.svg'
            ),
            'aux-full-light-skin' => array(
                'label' => __( 'Light overlay', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/slider-skin-3.svg'
            ),
            'aux-full-dark-skin' => array(
                'label'  => __( 'Dark overlay', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/slider-skin-4.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'aux-light-skin'
    );

    $options[] = array(
        'title'       => __( 'Insert post title', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_add_title',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '1',
        'type'      => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Insert post meta', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_add_meta',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
               'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
               'id'      => 'post_archive_slider_add_title',
                'value'   => array(1)
            ),
            array(
                'id'    => 'post_archive_slider_type',
                'value' => 'default'
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '1',
        'type'      => 'switch'
    );

    $options[] = array(
        'title'      => __( 'Grab the image from', 'phlox-pro' ),
        'description'=> '',
        'id'         => 'post_archive_slider_image_from',
        'section'    => 'blog-section-archive-slider',
        'dependency' => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'choices'   => array(
            'auto'      => __( 'Auto select', 'phlox-pro' ),
            'featured'  => __( 'Featured image', 'phlox-pro' ),
            'first'     => __( 'First image in post', 'phlox-pro' ),
            'custom'    => __( 'Custom image', 'phlox-pro' )
        ),
        'type'          => 'select',
        'default'       => 'auto'
    );

    $options[] = array(
        'title'       => __( 'Background image', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_custom_image',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                'id'      => 'post_archive_slider_image_from',
                'value'   => array('custom')
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'     => '',
        'type'        => 'image'
    );

    $options[] = array(
        'title'       => __( 'Exclude posts without image', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_exclude_without_images',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '1',
        'type'      => 'switch' );

    $options[] = array(
        'title'       => __( 'Slider image width', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_width',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '960',
        'type'      => 'text'
    );

    $options[] = array(
        'title'       => __( 'Slider image height', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_height',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '560',
        'type'      => 'text' );

    $options[] = array(
        'title'       => __( 'Arrow navigation', 'phlox-pro' ),
        'description' => __( 'Specifies to insert arrow buttons over slider.', 'phlox-pro' ),
        'id'          => 'post_archive_slider_arrows',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '0',
        'type'      => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Space between slides', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_space',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '5',
        'type'      => 'text'
    );

    $options[] = array(
        'title'       => __( 'Looped navigation', 'phlox-pro' ),
        'description' => '',
        'id'          => 'post_archive_slider_loop',
        'section'     => 'blog-section-archive-slider',
        'dependency'  => array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '1',
        'type'      => 'switch'
    );


    $options[] = array(
        'title'     => __( 'Slideshow', 'phlox-pro' ),
        'description'   => '',
        'id'        => 'post_archive_slider_slideshow',
        'section'   => 'blog-section-archive-slider',
        'dependency'=> array(
            array(
                'id'      => 'post_archive_slider_show',
                'value'   => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '0',
        'type'      => 'switch'
    );

    $options[] = array(
        'title'         => __( 'Slideshow delay in seconds', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'post_archive_slider_slideshow_delay',
        'section'       => 'blog-section-archive-slider',
        'dependency'    => array(
            array(
                'id'     => 'post_archive_slider_show',
                'value' => array(1)
            ),
            array(
                'id'     => 'post_archive_slider_slideshow',
                'value' => array(1)
            ),
            array(
                 'id'    => 'post_archive_slider_type',
                 'value' => 'default',
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-wrapper-post-slider',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                echo auxin_get_the_archive_slider( 'post', auxin_get_option('post_archive_slider_location') );
            }
        ),
        'default'   => '2',
        'type'      => 'text'
    );



    // Sub section - Blog Taxonomy Page -------------------------------

    $sections[] = array(
        'id'          => 'blog-section-taxonomy',
        'parent'      => 'blog-section', // section parent's id
        'title'       => __( 'Blog Category, tag & author', 'phlox-pro' ),
        'description' => __( 'Blog Category, tag & author page Setting', 'phlox-pro' )
    );

    $options[] = array(
        'title'       => __( 'Taxonomy Page Template', 'phlox-pro' ),
        'description' => 'Choose your category & tag page template.',
        'id'          => 'post_taxonomy_archive_template_type',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.archive .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'post_js'     => '$(".archive .aux-archive").alterClass( "aux-template-type-*", "aux-template-type-" + to );',
        'choices'     => $blog_index_template_types,
        'type'         => 'radio-image',
        'default'      => 'default'
    );

    $options[] = array(
        'title'       => __( 'Taxonomy Page Sidebar Position', 'phlox-pro' ),
        'description' => 'Specifies the position of sidebar on category & tag page.',
        'id'          => 'post_taxonomy_archive_sidebar_position',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(),
        'post_js'     => '$(".archive.tag main, .archive.category main").alterClass( "*-sidebar", to );',
        'choices'     => array(
            'no-sidebar' => array(
                'label'  => __( 'No Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'  => __( 'Right Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar' => array(
                'label'  => __( 'Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'  => __( 'Left Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'  => __( 'Right Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'  => __( 'Left Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'  => __( 'Right Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'right-sidebar'
    );

    $options[] = array(
        'title'       => __( 'Sidebar Style', 'phlox-pro' ),
        'description' => __( 'Specifies the style of sidebar on category & tag page.', 'phlox-pro' ),
        'id'          => 'post_taxonomy_archive_sidebar_decoration',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(
            array(
                 'id'      => 'post_taxonomy_archive_sidebar_position',
                 'value'   => array('no-sidebar'),
                 'operator'=> '!='
            )
        ),
        'post_js'    => '$(".archive.tag main, .archive.category main").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple' => array(
                'label'  => __( 'Simple' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    $options[] = array(
        'title'       => __( 'Taxonomy content length', 'phlox-pro' ),
        'description' => sprintf(__( 'Whether to display%1$ssummary%2$sor%1$sfull%2$scontent for each post on category & tag page.', 'phlox-pro' ), '<code>', '</code>'),
        'id'          => 'post_taxonomy_archive_content_on_listing',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(),
        'transport'   => 'postMessage',
        'dependency'  => array(
            array(
                 'id'      => 'post_taxonomy_archive_template_type',
                 'value'   => array('9'),
                 'operator'=> '!='
            )
         ),
        'partial'     => array(
            'selector'              => '.archive .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'choices'     => array(
            'full'    => __( 'Full text', 'phlox-pro' ),
            'excerpt' => __( 'Summary'  , 'phlox-pro' ),
            'none'    => __( 'None'  , 'phlox-pro' )
        ),
        'default'     => 'full',
        'type'        => 'select'
    );

    $options[] = array(
        'title'       => __( 'Summery length', 'phlox-pro' ),
        'description' => __( 'Specifies summary character length on category & tag page.', 'phlox-pro' ),
        'id'          => 'post_taxonomy_archive_on_listing_length',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(
            array(
                 'id'      => 'post_taxonomy_archive_content_on_listing',
                 'value'   => array('excerpt'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'post_taxonomy_archive_template_type',
                'value'   => array('9'),
                'operator'=> '!='
           )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.archive .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'   => '255',
        'type'      => 'text'
    );


    $options[] = array(
        'title'       => __( 'Display Post Info', 'phlox-pro' ),
        'description' => __( 'Enable it to display post date, categories and author name in post page .', 'phlox-pro' ),
        'id'          => 'display_post_taxonomy_info',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => '',
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.archive .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => '1',
        'type'        => 'switch'
    );


    $options[] = array(
        'title'         => __( 'Display post date', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the post date.', 'phlox-pro' ),
        'id'            => 'display_post_taxonomy_info_date',
        'section'       => 'blog-section-taxonomy',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.archive .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'display_post_taxonomy_info',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Display post author', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the post author.', 'phlox-pro' ),
        'id'            => 'display_post_taxonomy_info_author',
        'section'       => 'blog-section-taxonomy',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.archive .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'display_post_taxonomy_info',
                 'value'   => array('1'),
                 'operator'=> ''
            )
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Display post categories', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the post categories.', 'phlox-pro' ),
        'id'            => 'display_post_taxonomy_info_categories',
        'section'       => 'blog-section-taxonomy',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.archive .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'type'          => 'switch',
        'dependency'  => array(
            array(
                 'id'      => 'display_post_taxonomy_info',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
        ),
        'default'       => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Comment', 'phlox-pro' ),
        'description' => '',
        'id'          => 'display_post_taxonomy_info_comments',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(
                 array(
                    'id'      => 'display_post_taxonomy_info',
                    'value'   => array('1'),
                    'operator'=> '=='
                 ),
                 array(
                    'id'      => 'post_taxonomy_archive_template_type',
                    'value'   => array('1', '2', '3', '4'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Comment', 'phlox-pro' ),
        'description' => '',
        'id'          => 'display_post_taxonomy_widget_comments',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(
                 array(
                    'id'      => 'post_taxonomy_archive_template_type',
                    'value'   => array('5', '6', '7', '8'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Display author or read more', 'phlox-pro' ),
        'description' => __('Specifies whether to show author or read more on each post.', 'phlox-pro'),
        'id'          => 'display_post_taxonomy_author_readmore',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(
            array(
               'id'      => 'post_taxonomy_archive_template_type',
               'value'   => array('5', '6', '7', '8'),
               'operator'=> '=='
           )
        ),
        'transport'   => 'postMessage',
        'choices'     => array(
            'readmore' => __( 'Read More', 'phlox-pro' ),
            'author'   => __( 'Author'  , 'phlox-pro' ),
            'none'     => __( 'None'  , 'phlox-pro' )
        ),
        'default'     => 'readmore',
        'type'        => 'select'
    );

    $options[] = array(
        'title'       => __( 'Display Author in Header', 'phlox-pro' ),
        'description' => '',
        'id'          => 'display_post_taxonomy_author_header',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(
                 array(
                    'id'      => 'post_taxonomy_archive_template_type',
                    'value'   => array('5', '6', '7', '8'),
                    'operator'=> '=='
                 ),
                 array(
                    'id'      => 'display_post_taxonomy_author_readmore',
                    'value'   => array('author'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'default'     => '1'
    );

    $options[] = array(
        'title'       => __( 'Display Author in Footer', 'phlox-pro' ),
        'description' => '',
        'id'          => 'display_post_taxonomy_author_footer',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(
                 array(
                    'id'      => 'post_taxonomy_archive_template_type',
                    'value'   => array('5', '6', '7', '8'),
                    'operator'=> '=='
                 ),
                 array(
                    'id'      => 'display_post_taxonomy_author_readmore',
                    'value'   => array('author'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'switch',
        'transport'   => 'postMessage',
        'default'     => '0'
    );

    $options[] = array(
        'title'       => __( 'Load More Type', 'phlox-pro' ),
        'description' => __( 'Replaces the default pagination in blog archive with a load more', 'phlox-pro' ),
        'id'          => 'post_taxonomy_loadmore_type',
        'section'     => 'blog-section-taxonomy',
        'dependency'  => array(
                array(
                    'id'      => 'post_taxonomy_archive_template_type',
                    'value'   => array('5', '6', '7', '8', '9'),
                    'operator'=> '=='
                )
        ),
        'type'        => 'radio-image',
        'choices'     => array(
            '' => array(
                'label'  => __( 'None' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/load-more-none.svg'
            ),
            'scroll' => array(
                'label'  => __( 'Infinite Scroll' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/load-more-infinite.svg'
            ),
            'next' => array(
                'label'  => __( 'Next Button' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/load-more-button.svg'
            ),
            'next-prev' => array(
                'label'  => __( 'Next Prev' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/load-more-next-prev.svg'
            )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.archive .aux-archive .content',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_get_template_part( 'theme-parts/loop', 'post' );
            }
        ),
        'default'     => ''
    );

    // Sub section - Single Blog Typography -------------------------------

    $sections[] = array(
        'id'          => 'blog-section-single-typography',
        'parent'      => 'blog-section', // section parent's id
        'title'       => __( 'Single Post Typography', 'phlox-pro' ),
        'description' => __( 'Single Post Typography', 'phlox-pro' ),
    );

    $options[] = array(
        'title'          => __( 'Post Title', 'phlox-pro' ),
        'id'             => 'single_post_title_typography',
        'description'    => '',
        'section'        => 'blog-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-post .aux-primary .hentry .entry-title',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post Content', 'phlox-pro' ),
        'id'             => 'single_post_content_typography',
        'description'    => '',
        'section'        => 'blog-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-post .hentry .entry-content',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post info', 'phlox-pro' ),
        'id'             => 'single_post_info_typography',
        'description'    => '',
        'section'        => 'blog-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-post .hentry .entry-info',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post info terms', 'phlox-pro' ),
        'id'             => 'single_post_info_terms_typography',
        'description'    => '',
        'section'        => 'blog-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-post .hentry .entry-info a',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post Meta', 'phlox-pro' ),
        'id'             => 'single_post_meta_typography',
        'description'    => '',
        'section'        => 'blog-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-post .hentry footer.entry-meta .entry-tax',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post Meta Terms', 'phlox-pro' ),
        'id'             => 'single_post_meta_terms_typography',
        'description'    => '',
        'section'        => 'blog-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-post .hentry footer.entry-meta .entry-tax a, .single-post .hentry footer.entry-meta .entry-tax i',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Subtitle', 'phlox-pro' ),
        'id'             => 'single_post_subtitle_typography',
        'description'    => '',
        'section'        => 'blog-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-post .page-title-section .page-subtitle',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Breadcrumb', 'phlox-pro' ),
        'id'             => 'single_post_breadcrumb_typography',
        'description'    => '',
        'section'        => 'blog-section-single-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.single-post .page-title-section .aux-breadcrumbs span , .single-post .page-title-section .aux-breadcrumbs span > a',
        'transport'      => 'postMessage',
    );

    // Sub section - Single Blog Typography -------------------------------

    $sections[] = array(
        'id'          => 'blog-section-blog-appearence',
        'parent'      => 'blog-section', // section parent's id
        'title'       => __( 'Blog Page Appearance', 'phlox-pro' ),
        'description' => __( 'Blog Page Appearance', 'phlox-pro' ),
    );

    $options[] = array(
        'title'          => __( 'Post Title Typography', 'phlox-pro' ),
        'id'             => 'blog_page_title_typography',
        'description'    => '',
        'section'        => 'blog-section-blog-appearence',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.blog .hentry .entry-title',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post info Typography', 'phlox-pro' ),
        'id'             => 'blog_page_info_typography',
        'description'    => '',
        'section'        => 'blog-section-blog-appearence',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.blog .aux-archive .aux-primary .hentry .entry-info',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post info Terms Typography', 'phlox-pro' ),
        'id'             => 'blog_page_info_terms_typography',
        'description'    => '',
        'section'        => 'blog-section-blog-appearence',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.blog .aux-archive .aux-primary .hentry .entry-info a',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Post Content Typography', 'phlox-pro' ),
        'id'             => 'blog_page_content_typography',
        'description'    => '',
        'section'        => 'blog-section-blog-appearence',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.blog .hentry .entry-content',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Button Typography', 'phlox-pro' ),
        'id'             => 'blog_page_button_typography',
        'description'    => '',
        'section'        => 'blog-section-blog-appearence',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.blog .hentry .aux-read-more',
        'transport'      => 'postMessage',
    );

    /* ---------------------------------------------------------------------------------------------------
        Page Section
    --------------------------------------------------------------------------------------------------- */

    // Page section ==================================================================

    $sections[] = array(
        'id'          => 'page-section',
        'parent'      => '', // section parent's id
        'title'       => __( 'Page', 'phlox-pro' ),
        'description' => __( 'Page Setting', 'phlox-pro' ),
        'icon'        => 'axicon-doc'
    );

    // Sub section - Page Single Page -------------------------------

    $sections[] = array(
        'id'          => 'page-section-single-layout',
        'parent'      => 'page-section', // section parent's id
        'title'       => __( 'Page Layout', 'phlox-pro' ),
        'description' => __( 'Page Layout Setting', 'phlox-pro' )
    );

    $sections[] = array(
        'id'            => 'page-section-single-layout',
        'parent'        => 'page-section', // section parent's id
        'title'         => __( 'Page Layout', 'phlox-pro' ),
        'description'   => __( 'Preview a page', 'phlox-pro' ),
        'preview_link'  => auxin_get_last_post_permalink( array( 'post_type' => 'page' ) )
    );


    $options[] = array(
        'title'         => __( 'Page Sidebar Position', 'phlox-pro' ),
        'description'   => __( 'Specifies position of sidebar on page.', 'phlox-pro' ),
        'id'            => 'page_single_sidebar_position',
        'section'       => 'page-section-single-layout',
        'post_js'       => '$(".page .aux-main.aux-single").alterClass( "*-sidebar", to );',
        'choices'       => array(
            'no-sidebar' => array(
                'label'     => __( 'No Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'     => __( 'Right Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar'  => array(
                'label'     => __( 'Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'     => __( 'Left Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'     => __( 'Right Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'     => __( 'Left Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'     => __( 'Right Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'default'   => 'no-sidebar',
        'type'      => 'radio-image'
    );

    $options[] =    array(
        'title'         => __( 'Page Sidebar Style', 'phlox-pro' ),
        'description'   => 'Specifies style of sidebar on page.',
        'id'            => 'page_single_sidebar_decoration',
        'section'       => 'page-section-single-layout',
        'dependency'    => array(
            array(
                 'id'      => 'page_single_sidebar_position',
                 'value'   => array('no-sidebar'),
                 'operator'=> '!='
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".page main.aux-single").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple'  => array(
                'label'  => __( 'Simple' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    $options[] = array(
        'title'         => __( 'Display Content Top Margin', 'phlox-pro' ),
        'description'   => __( 'Enable it to display a space between title and content. If you need to start your content from very top of the page, disable it.', 'phlox-pro' ),
        'id'            => 'page_show_content_top_margin',
        'section'       => 'page-section-single-layout',
        'transport'     => 'refresh',
        'type'          => 'switch',
        'default'       => '1'
    );

    $options[] = array(
        'title'       => __( 'Custom Max Width', 'phlox-pro' ),
        'description' => __( 'Specifies the maximum width of website.', 'phlox-pro' ),
        'id'          => 'page_max_width_layout',
        'section'     => 'page-section-single-layout',
        'type'        => 'select',
        'transport'   => 'postMessage',
        'dependency'  => array(),
        'choices'     => array(
            ''      => __( 'Default Site Max Width', 'phlox-pro' ),
            'nd'    => __( '1000 Pixels', 'phlox-pro' ),
            'hd'    => __( '1200 Pixels', 'phlox-pro' ),
            'xhd'   => __( '1400 Pixels', 'phlox-pro' ),
            's-fhd' => __( '1600 Pixels', 'phlox-pro' ),
            'fhd'   => __( '1900 Pixels', 'phlox-pro' )
        ),
        'post_js'   => 'if(to){ $( "body.page" ).removeClass( "aux-nd aux-hd aux-xhd aux-s-fhd aux-fhd" ).addClass( "aux-" + to ); $(window).trigger("resize"); }',
        'default'   => ''
    );

    $options[] = array(
        'title'         => __( 'Content Layout', 'phlox-pro' ),
        'description'   => __( 'If you select "Full", the content fills the entire width of the page.', 'phlox-pro' ),
        'id'            => 'page_content_layout',
        'type'          => 'radio-image',
        'section'       => 'page-section-single-layout',
        'choices'       => array(
            'boxed' => array(
                'label'     => __( 'Boxed Content', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-boxed'
            ),
            'full' => array(
                'label'     => __( 'Full Content', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-full'
            )
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".page .aux-main.aux-single").toggleClass( "aux-full-container", "full" == to );',
        'default'   => 'boxed',
        'type'      => 'radio-image'
    );

    // Sub section - Page Post Title bar --------------------------------

    $sections[] = array(
        'id'           => 'page-section-single-titlebar',
        'parent'       => 'page-section', // section parent's id
        'title'        => __( 'Page Title', 'phlox-pro' ),
        'description'  => __( 'Preview a page', 'phlox-pro' ),
        'preview_link' => auxin_get_last_post_permalink( array( 'post_type' => 'page' ) )
    );

    $options[] = array(
        'title'         => __( 'Display Title Bar Section', 'phlox-pro' ),
        'description'   => __( 'Enable it to show the page title section.', 'phlox-pro' ),
        'id'            => 'page_title_bar_show',
        'id_deprecated' => 'title_bar_show',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '1'
    );

    $options[] = array(
        'title'         => __( 'Layout presets', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'page_title_bar_preset',
        'id_deprecated' => 'title_bar_preset',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'normal_title_1',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'normal_title_1' => array(
                'label'   => __( 'Default', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-4.svg',
                'presets' => array(
                    'page_title_bar_content_width_type'      => 'boxed',
                    'page_title_bar_content_section_height'  => 'auto',
                    'page_title_bar_heading_bordered'        => 0,
                    'page_title_bar_heading_boxed'           => 0,
                    'page_title_bar_meta_enabled'            => 0,
                    'page_title_bar_bread_enabled'           => 1,
                    'page_title_bar_bread_bordered'          => 0,
                    'page_title_bar_bread_sep_style'         => 'arrow',
                    'page_title_bar_text_align'              => 'left',
                    'page_title_bar_vertical_align'          => 'top',
                    'page_title_bar_scroll_arrow'            => 'none',
                    'page_title_bar_color_style'             => 'dark',
                    'page_title_bar_overlay_color'           => ''
                )
            ),
            'normal_bg_light_1' => array(
                'label'   => __( 'Title bar with light overlay which is aligned center', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-1.svg',
                'presets' => array(
                    'page_title_bar_content_width_type'      => 'boxed',
                    'page_title_bar_content_section_height'  => 'auto',
                    'page_title_bar_heading_bordered'        => 0,
                    'page_title_bar_heading_boxed'           => 0,
                    'page_title_bar_bread_enabled'           => 1,
                    'page_title_bar_bread_bordered'          => 0,
                    'page_title_bar_bread_sep_style'         => 'arrow',
                    'page_title_bar_text_align'              => 'center',
                    'page_title_bar_vertical_align'          => 'top',
                    'page_title_bar_scroll_arrow'            => 'none',
                    'page_title_bar_color_style'             => 'dark',
                    'page_title_bar_overlay_color'           => ''
                )
            ),
            'full_bg_light_1' => array(
                'label'   => __( 'Fullscreen title bar with light overlay on background', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-2.svg',
                'presets' => array(
                    'page_title_bar_content_width_type'      => 'boxed',
                    'page_title_bar_content_section_height'  => 'full',
                    'page_title_bar_heading_bordered'        => 0,
                    'page_title_bar_heading_boxed'           => 0,
                    'page_title_bar_bread_enabled'           => 1,
                    'page_title_bar_bread_bordered'          => 1,
                    'page_title_bar_bread_sep_style'         => 'slash',
                    'page_title_bar_text_align'              => 'center',
                    'page_title_bar_vertical_align'          => 'middle',
                    'page_title_bar_scroll_arrow'            => 'round',
                    'page_title_bar_color_style'             => 'dark',
                    'page_title_bar_overlay_color'           => 'rgba(255,255,255,0.50)'
                )
            ),
            'full_bg_dark_1' => array(
                'label'   => __( 'Fullscreen title bar with dark overlay on background', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-3.svg',
                'presets' => array(
                    'page_title_bar_content_width_type'      => 'boxed',
                    'page_title_bar_content_section_height'  => 'full',
                    'page_title_bar_heading_bordered'        => 0,
                    'page_title_bar_heading_boxed'           => 0,
                    'page_title_bar_bread_enabled'           => 1,
                    'page_title_bar_bread_bordered'          => 0,
                    'page_title_bar_bread_sep_style'         => 'slash',
                    'page_title_bar_text_align'              => 'center',
                    'page_title_bar_vertical_align'          => 'middle',
                    'page_title_bar_scroll_arrow'            => 'round',
                    'page_title_bar_color_style'             => 'light',
                    'page_title_bar_overlay_color'           => 'rgba(0,0,0,0.6)'
                )
            ),
            'full_bg_dark_2' => array(
                'label'   => __( 'Fullscreen title bar with border around the title', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-6.svg',
                'presets' => array(
                    'page_title_bar_content_width_type'      => 'boxed',
                    'page_title_bar_content_section_height'  => 'full',
                    'page_title_bar_heading_bordered'        => 1,
                    'page_title_bar_heading_boxed'           => 0,
                    'page_title_bar_bread_enabled'           => 0,
                    'page_title_bar_bread_bordered'          => 1,
                    'page_title_bar_bread_sep_style'         => 'slash',
                    'page_title_bar_text_align'              => 'center',
                    'page_title_bar_vertical_align'          => 'middle',
                    'page_title_bar_scroll_arrow'            => 'round',
                    'page_title_bar_color_style'             => 'dark',
                    'page_title_bar_overlay_color'           => 'rgba(250,250,250,0.3)'
                )
            ),
            'full_bg_dark_3' => array(
                'label'   => __( 'Fullscreen title bar with dark box around the title', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-7.svg',
                'presets' => array(
                    'page_title_bar_content_width_type'      => 'boxed',
                    'page_title_bar_content_section_height'  => 'full',
                    'page_title_bar_heading_bordered'        => 0,
                    'page_title_bar_heading_boxed'           => 1,
                    'page_title_bar_bread_enabled'           => 0,
                    'page_title_bar_bread_bordered'          => 0,
                    'page_title_bar_bread_sep_style'         => 'slash',
                    'page_title_bar_text_align'              => 'center',
                    'page_title_bar_vertical_align'          => 'middle',
                    'page_title_bar_scroll_arrow'            => 'round',
                    'page_title_bar_color_style'             => 'light',
                    'page_title_bar_overlay_color'           => 'rgba(0,0,0,0.5)'
                )
            ),
            'normal_bg_dark_1' => array(
                'label'   => __( 'Title aligned left with dark overlay on background', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-5.svg',
                'presets' => array(
                    'page_title_bar_content_width_type'      => 'boxed',
                    'page_title_bar_content_section_height'  => 'auto',
                    'page_title_bar_heading_bordered'        => 0,
                    'page_title_bar_heading_boxed'           => 0,
                    'page_title_bar_bread_enabled'           => 1,
                    'page_title_bar_bread_bordered'          => 0,
                    'page_title_bar_bread_sep_style'         => 'gt',
                    'page_title_bar_text_align'              => 'left',
                    'page_title_bar_vertical_align'          => 'bottom',
                    'page_title_bar_scroll_arrow'            => 'none',
                    'page_title_bar_color_style'             => 'light',
                    'page_title_bar_overlay_color'           => 'rgba(0,0,0,0.3)'
                )
            ),
            'full_bg_dark_4' => array(
                'label'   => __( 'Tile overlaps the title area section and is aligned center', 'phlox-pro' ),
                'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-8.svg',
                'presets' => array(
                    'page_title_bar_content_width_type'      => 'boxed',
                    'page_title_bar_content_section_height'  => 'auto',
                    'page_title_bar_heading_bordered'        => 0,
                    'page_title_bar_heading_boxed'           => 1,
                    'page_title_bar_bread_enabled'           => 1,
                    'page_title_bar_bread_bordered'          => 1,
                    'page_title_bar_bread_sep_style'         => 'gt',
                    'page_title_bar_text_align'              => 'center',
                    'page_title_bar_vertical_align'          => 'bottom-overlap',
                    'page_title_bar_scroll_arrow'            => 'none',
                    'page_title_bar_color_style'             => 'light',
                    'page_title_bar_overlay_color'           => 'rgba(0,0,0,0.5)'
                )
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Enable advanced setting', 'phlox-pro' ),
        'description'   => __( 'Enable it to customize preset layouts.', 'phlox-pro' ),
        'id'            => 'page_title_bar_enable_customize',
        'id_deprecated' => 'title_bar_enable_customize',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Content Width', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'page_title_bar_content_width_type',
        'id_deprecated' => 'title_bar_content_width_type',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'boxed',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'boxed' => array(
                'label'     => __( 'Boxed', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-boxed',
            ),
            'semi-full' => array(
                'label'     => __( 'Full Width Content with Space on Sides', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-full-with-spaces'
            ),
            'full' => array(
                'label'     => __( 'Full Width Content', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-content-full'
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Title Section Height', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'page_title_bar_content_section_height',
        'id_deprecated' => 'title_bar_content_section_height',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'select',
        'default'       => 'auto',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'auto'  => __( 'Auto Height', 'phlox-pro' ),
            'full'  => __( 'Full Height', 'phlox-pro' )
        )
    );

    $options[] = array(
        'title'         => __( 'Vertical Position', 'phlox-pro' ),
        'description'   => __( 'Specifies vertical alignment of title and subtitle.', 'phlox-pro' ) . "<br/>".
                           __( 'Note: Parallax feature in not available for "Bottom Overlap" vertical mode.', 'phlox-pro' ),
        'id'            => 'page_title_bar_vertical_align',
        'id_deprecated' => 'title_bar_vertical_align',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'select',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'            => array(
            'top'            => __( 'Top'    , 'phlox-pro' ),
            'middle'         => __( 'Middle' , 'phlox-pro' ),
            'bottom'         => __( 'Bottom' , 'phlox-pro' ),
            'bottom-overlap' => __( 'Bottom Overlap', 'phlox-pro' )
        )
    );

    $options[] = array(
        'title'         => __( 'Scroll Down Arrow', 'phlox-pro' ),
        'description'   => __( 'This option only applies if section height is "Full Height".', 'phlox-pro' ),
        'id'            => 'page_title_bar_scroll_arrow',
        'id_deprecated' => 'title_bar_scroll_arrow',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_content_section_height',
                 'value'   => 'full',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_vertical_align',
                 'value'   => array('top', 'middle', 'bottom'),
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'none' => array(
                'label'     => __( 'None', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-none'
            ),
            'round' => array(
                'label'     => __( 'Round', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-scroll-down-arrow-outline'
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Display Titles', 'phlox-pro' ),
        'description'   => __( 'Enable it to display title/subtitle in title section.', 'phlox-pro' ),
        'id'            => 'page_title_bar_title_show',
        'id_deprecated' => 'title_bar_heading_bordered',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '1',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Border for Heading', 'phlox-pro' ),
        'description'   => __( 'Enable it to display a border around the title and subtitle area.', 'phlox-pro' ),
        'id'            => 'page_title_bar_heading_bordered',
        'id_deprecated' => 'title_bar_heading_bordered',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_title_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Boxed Title', 'phlox-pro' ),
        'description'   => __( 'Enable it to wrap the title and subtitle in a box with background color.', 'phlox-pro' ),
        'id'            => 'page_title_bar_heading_boxed',
        'id_deprecated' => 'title_bar_heading_boxed',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_title_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Title Box Custom Color', 'phlox-pro' ),
        'description'   => __( 'Specifies a custom background color for the box around the title and subtitle.', 'phlox-pro' ),
        'id'            => 'page_title_bar_heading_bg_color',
        'id_deprecated' => 'title_bar_heading_bg_color',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'color',
        'selectors'     => ' ',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_title_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_heading_boxed',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Display Post Meta', 'phlox-pro' ),
        'description'   => __( 'Enable it to display post meta information on title section.', 'phlox-pro' ),
        'id'            => 'page_title_bar_meta_enabled',
        'id_deprecated' => 'title_bar_meta_enabled',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Display Breadcrumb', 'phlox-pro' ),
        'description'   => __( 'Enable it to display breadcrumb on title section.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bread_enabled',
        'id_deprecated' => 'title_bar_bread_enabled',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '1',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'         => __( 'Border for Breadcrumb', 'phlox-pro' ),
        'description'   => __( 'Enable it to display border around breadcrumb.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bread_bordered',
        'id_deprecated' => 'title_bar_bread_bordered',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_bread_enabled',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
    );

    $options[] = array(
        'title'       => __( 'Breadcrumb Separator Icon', 'phlox-pro' ),
        'description' => '',
        'id'          => 'page_title_bar_bread_sep_style',
        'id_deprecated' => 'title_bar_bread_sep_style',
        'section'     => 'page-section-single-titlebar',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_bread_enabled',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'default'     => 'auxicon-chevron-right-1',
        'transport'   => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'        => 'icon'
    );

    $options[] = array(
        'title'         => __( 'Text Align', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'page_title_bar_text_align',
        'id_deprecated' => 'title_bar_text_align',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'left',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'left' => array(
                'label'     => __( 'Left', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-text-align-left',
            ),
            'center' => array(
                'label'     => __( 'Center', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-text-align-center'
            ),
            'right' => array(
                'label'     => __( 'Right', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-text-align-right'
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Overlay Color', 'phlox-pro' ),
        'description'   => __( 'The color that overlay on the background. Please note that color should have transparency.','phlox-pro' ),
        'id'            => 'page_title_bar_overlay_color',
        'id_deprecated' => 'title_bar_overlay_color',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'color',
        'selectors'     => ' ',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Overlay Pattern', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'page_title_bar_overlay_pattern',
        'id_deprecated' => 'title_bar_overlay_pattern',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => 'none',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'none' => array(
                'label'     => __( 'None', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-none'
            ),
            'hash' => array(
                'label'     => __( 'Hash', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-pattern',
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Overlay Pattern Opacity', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'page_title_bar_overlay_pattern_opacity',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'type'          => 'text',
        'default'       => '0.5',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_overlay_pattern',
                 'value'   => array('hash'),
                 'operator'=> '=='
            )
        ),
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'page_title_bar_overlay_pattern_opacity' ) );
            }
            if( ! is_numeric( $value ) || (float) $value > 1 ){
                $value = 1;
            }
            return $value ? ".page .aux-overlay-bg-hash::before { opacity:$value; }" : '';
        }
    );

    $options[] = array(
        'title'         => __( 'Color Mode', 'phlox-pro' ),
        'description'   => '',
        'id'            => 'page_title_bar_color_style',
        'id_deprecated' => 'title_bar_color_style',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'select',
        'default'       => 'dark',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices'       => array(
            'dark'  => __( 'Dark', 'phlox-pro' ),
            'light' => __( 'Light', 'phlox-pro' )
        )
    );

        ////////////////////////////////////////////////////////////////////////////////////////

    $options[] = array(
        'title'         => __( 'Enable Title Background', 'phlox-pro' ),
        'description'   => __( 'Enable it to display custom background for title section.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bg_show',
        'id_deprecated' => 'title_bar_bg_show',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'id_deprecated' => 'axi_show_title_section_background',
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Enable Parallax Effect', 'phlox-pro' ),
        'description'   => __( 'Enable it to have parallax background effect on this section.', 'phlox-pro' )."<br />".
                           __( 'Note: Parallax feature in not available for "Bottom Overlap" mode for "Vertical Position" option.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bg_parallax',
        'id_deprecated' => 'title_bar_bg_parallax',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'switch',
        'default'       => '0',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'         => __( 'Background Color', 'phlox-pro' ),
        'description'   => __( 'Specifies a background color for title bar.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bg_color',
        'id_deprecated' => 'title_bar_bg_color',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'color',
        'selectors'     => ' ',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Size', 'phlox-pro' ),
        'description'   => __( 'Specifies the background size.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bg_size',
        'id_deprecated' => 'title_bar_bg_size',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'radio-image',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),
        'choices' => array(
            'auto' => array(
                'label'       => __( 'Auto', 'phlox-pro' ),
                'css_class'   => 'axiAdminIcon-bg-size-1',
            ),
            'contain' => array(
                'label'       => __( 'Contain', 'phlox-pro' ),
                'css_class'   => 'axiAdminIcon-bg-size-2',
            ),
            'cover' => array(
                'label'       => __( 'Cover', 'phlox-pro' ),
                'css_class'   => 'axiAdminIcon-bg-size-3',
            ),
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Image', 'phlox-pro' ),
        'description'   => __( 'Specifies a background image for title bar.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bg_image',
        'id_deprecated' => 'title_bar_bg_image',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'image',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Video MP4', 'phlox-pro' ),
        'description'   => __( 'You can upload custom video for title background</br>Note: if you set custom image, default image backgrounds will be ignored.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bg_video_mp4',
        'id_deprecated' => 'title_bar_bg_video_mp4',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'video',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Video Ogg', 'phlox-pro' ),
        'description'   => __( 'You can upload custom video for title background</br>Note: if you set custom image, default image backgrounds will be ignored.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bg_video_ogg',
        'id_deprecated' => 'title_bar_bg_video_ogg',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'video',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    $options[] = array(
        'title'         => __( 'Background Video WebM', 'phlox-pro' ),
        'description'   => __( 'You can upload custom video for title background</br>Note: if you set custom image, default image backgrounds will be ignored.', 'phlox-pro' ),
        'id'            => 'page_title_bar_bg_video_webm',
        'id_deprecated' => 'title_bar_bg_video_webm',
        'section'       => 'page-section-single-titlebar',
        'transport'     => 'postMessage',
        'partial'       => array(
            'selector'              => '.page .aux-customizer-page-title-container',
            'container_inclusive'   => false,
            'render_callback'       => function(){
                auxin_the_main_title_section( array( 'has_helper_wrapper' => false ) );
            }
        ),
        'type'          => 'video',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'page_title_bar_enable_customize',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_show',
                 'value'   => '1',
                 'operator'=> '=='
            ),
            array(
                 'id'      => 'page_title_bar_bg_show',
                 'value'   => '1',
                 'operator'=> '=='
            )
        ),

    );

    // Sub section - Page Typography --------------------------------

    $sections[] = array(
        'id'           => 'page-section-typography',
        'parent'       => 'page-section', // section parent's id
        'title'        => __( 'Page Typography', 'phlox-pro' ),
        'description'  => __( 'Page Typography', 'phlox-pro' ),
    );

    $options[] = array(
        'title'          => __( 'Page Title', 'phlox-pro' ),
        'id'             => 'page_title__typography',
        'description'    => '',
        'section'        => 'page-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.page-title',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Page Subtitle', 'phlox-pro' ),
        'id'             => 'page_subtitle__typography',
        'description'    => '',
        'section'        => 'page-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.page-title-section .page-subtitle',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Breadcrumb', 'phlox-pro' ),
        'id'             => 'page_title_breadcrumb_typography',
        'description'    => '',
        'section'        => 'page-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-breadcrumbs',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'          => __( 'Breadcrumb Links', 'phlox-pro' ),
        'id'             => 'page_title_breadcrumb_link_typography',
        'description'    => '',
        'section'        => 'page-section-typography',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.page-title-section .aux-breadcrumbs a',
        'transport'      => 'postMessage',
    );

    $options[] = array(
        'title'         => __( 'Breadcrumb Color', 'phlox-pro' ),
        'id'            => 'page_title_breadcrumb_sep_color',
        'section'       => 'page-section-typography',
        'transport'     => 'postMessage',
        'type'          => 'color',
        'selectors'     => '.page-title-section .aux-breadcrumbs span:after',
        'placeholder'   => 'color:{{VALUE}};',
        'default'       => ''
    );


    if( function_exists('WC') ){

    /* ---------------------------------------------------------------------------------------------------
        Product Section
    --------------------------------------------------------------------------------------------------- */

    // Product section ==================================================================

    $sections[] = array(
        'id'          => 'product-section',
        'parent'      => '', // section parent's id
        'title'       => __( 'Woocommerce', 'phlox-pro' ),
        'description' => __( 'Woocommerce Setting', 'phlox-pro' ),
        'icon'        => 'axicon-basket-alt'
    );

    // Sub section - Single Product Page -------------------------------

    $sections[] = array(
        'id'           => 'product-section-single',
        'parent'       => 'product-section', // section parent's id
        'title'        => __( 'Single Product Page', 'phlox-pro' ),
        'description'  => __( 'Preview a Single Product Page', 'phlox-pro'),
        'preview_link' => auxin_get_last_post_permalink( array( 'post_type' => 'product' ) )
    );


    $options[] = array(
        'title'       => __( 'Single Product Sidebar Position', 'phlox-pro' ),
        'description' => __( 'Specifies the position of sidebar on single product page.', 'phlox-pro' ),
        'id'          => 'product_single_sidebar_position',
        'section'     => 'product-section-single',
        'dependency'  => array(),
        'choices'     => array(
            'no-sidebar' => array(
                'label'  => __( 'No Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'  => __( 'Right Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar' => array(
                'label'  => __( 'Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'  => __( 'Left Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'  => __( 'Right Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'  => __( 'Left Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'  => __( 'Right Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".single-product main.aux-single, main.aux-home").alterClass( "*-sidebar", to );',
        'default'   => 'right-sidebar',
        'type'      => 'radio-image'
    );

     $options[] = array(
        'title'       => __( 'Single Product Sidebar Style', 'phlox-pro' ),
        'description' => 'Specifies the style of sidebar on single product page.',
        'id'          => 'product_single_sidebar_decoration',
        'section'     => 'product-section-single',
        'dependency'  => array(
            array(
                 'id'      => 'product_single_sidebar_position',
                 'value'   => array('no-sidebar'),
                 'operator'=> '!='
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".single-product .aux-single, main.aux-home").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple' => array(
                'label'  => __( 'Simple' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    $options[] = array(
        'title'       => __( 'Custom Max Width', 'phlox-pro' ),
        'description' => __( 'Specifies the maximum width of website.', 'phlox-pro' ),
        'id'          => 'product_max_width_layout',
        'section'     => 'product-section-single',
        'type'        => 'select',
        'transport'   => 'postMessage',
        'dependency'  => array(),
        'choices'     => array(
            ''      => __( 'Default Site Max Width', 'phlox-pro' ),
            'nd'    => __( '1000 Pixels', 'phlox-pro' ),
            'hd'    => __( '1200 Pixels', 'phlox-pro' ),
            'xhd'   => __( '1400 Pixels', 'phlox-pro' ),
            's-fhd' => __( '1600 Pixels', 'phlox-pro' ),
            'fhd'   => __( '1900 Pixels', 'phlox-pro' )
        ),
        'post_js'   => 'if(to){ $( "body.single" ).removeClass( "aux-nd aux-hd aux-xhd aux-s-fhd aux-fhd" ).addClass( "aux-" + to ); $(window).trigger("resize"); }',
        'default'   => ''
    );


    // Sub section - Product Archive Page -------------------------------

    $sections[] = array(
        'id'           => 'product-section-archive',
        'parent'       => 'product-section', // section parent's id
        'title'        => __( 'Shop Page', 'phlox-pro' ),
        'description'  => __( 'Preview Shop Page', 'phlox-pro'),
        'preview_link' => auxin_get_post_type_archive_shortlink('product')
    );


    $options[] = array(
        'title'       => __( 'Shop Page Sidebar Position', 'phlox-pro' ),
        'description' => __( 'Specifies the position of sidebar on shop page.', 'phlox-pro' ),
        'id'          => 'product_index_sidebar_position',
        'section'     => 'product-section-archive',
        'dependency'  => array(),
        'choices'     => array(
            'no-sidebar' => array(
                'label'  => __( 'No Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'  => __( 'Right Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar' => array(
                'label'  => __( 'Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'  => __( 'Left Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'  => __( 'Right Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'  => __( 'Left Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'  => __( 'Right Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".post-type-archive-product main.aux-archive, main.aux-home").alterClass( "*-sidebar", to );',
        'default'   => 'right-sidebar',
        'type'      => 'radio-image'
    );

    $options[] = array(
        'title'       => __( 'Shop Sidebar Style', 'phlox-pro' ),
        'description' => __( 'Specifies the style of sidebar on shop page.', 'phlox-pro' ),
        'id'          => 'product_index_sidebar_decoration',
        'section'     => 'product-section-archive',
        'dependency'  => array(
            array(
                 'id'      => 'product_index_sidebar_position',
                 'value'   => array('no-sidebar'),
                 'operator'=> '!='
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".post-type-archive-product .aux-archive, main.aux-home").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple' => array(
                'label'  => __( 'Simple' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    $options[] = array(
        'title'       => __( 'Custom Max Width', 'phlox-pro' ),
        'description' => __( 'Specifies the maximum width of website.', 'phlox-pro' ),
        'id'          => 'product_archive_max_width_layout',
        'section'     => 'product-section-archive',
        'type'        => 'select',
        'transport'   => 'postMessage',
        'dependency'  => array(),
        'choices'     => array(
            ''      => __( 'Default Site Max Width', 'phlox-pro' ),
            'nd'    => __( '1000 Pixels', 'phlox-pro' ),
            'hd'    => __( '1200 Pixels', 'phlox-pro' ),
            'xhd'   => __( '1400 Pixels', 'phlox-pro' ),
            's-fhd' => __( '1600 Pixels', 'phlox-pro' ),
            'fhd'   => __( '1900 Pixels', 'phlox-pro' )
        ),
        'post_js'   => 'if(to){ $( "body.archive" ).removeClass( "aux-nd aux-hd aux-xhd aux-s-fhd aux-fhd" ).addClass( "aux-" + to ); $(window).trigger("resize"); }',
        'default'   => ''
    );

    $options[] = array(
        'title'       => __('Display View Cart Link', 'phlox-pro'),
        'description' => __('Display view cart link after successfull adding to cart in front of add to cart button.', 'phlox-pro'),
        'id'          => 'product_archive_show_view_cart_link',
        'section'     => 'product-section-archive',
        'transport'   => 'refresh',
        'default'     => '0',
        'type'        => 'switch'
    );

    // -- Sub section - Product Category Page  -----------------------------------------------

    $sections[] = array(
        'id'          => 'product-section-category',
        'parent'      => 'product-section', // section parent's id
        'title'       => __( 'Product Category & Tag', 'phlox-pro' ),
        'description' => __( 'Product Category & Tag Page Setting', 'phlox-pro' )
    );


    $options[] = array(
        'title'       => __( 'Product Taxonomy Sidebar Position', 'phlox-pro' ),
        'description' => __( 'Specifies the position of sidebar on product category & tag page.', 'phlox-pro' ),
        'id'          => 'product_category_sidebar_position',
        'section'     => 'product-section-category',
        'dependency'  => array(),
        'choices'     => array(
            'no-sidebar' => array(
                'label'  => __( 'No Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-none'
            ),
            'right-sidebar' => array(
                'label'  => __( 'Right Sidebar', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right'
            ),
            'left-sidebar' => array(
                'label'  => __( 'Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left'
            ),
            'left2-sidebar' => array(
                'label'  => __( 'Left Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-left'
            ),
            'right2-sidebar' => array(
                'label'  => __( 'Right Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-right-right'
            ),
            'left-right-sidebar' => array(
                'label'  => __( 'Left Right Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            ),
            'right-left-sidebar' => array(
                'label'  => __( 'Right Left Sidebar' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-sidebar-left-right'
            )
        ),
        'transport' => 'refresh',
        'default'   => 'right-sidebar',
        'type'      => 'radio-image'
    );

    $options[] = array(
        'title'       => __( 'Product Taxonomy Sidebar Style', 'phlox-pro' ),
        'description' => __( 'Specifies the style of sidebar on product category & tag page.', 'phlox-pro' ),
        'id'          => 'product_category_sidebar_decoration',
        'section'     => 'product-section-category',
        'dependency'  => array(
            array(
                 'id'      => 'product_category_sidebar_position',
                 'value'   => array('no-sidebar'),
                 'operator'=> '!='
            )
        ),
        'transport'   => 'postMessage',
        'post_js'     => '$(".woocommerce .aux-archive, main.aux-home").alterClass( "aux-sidebar-style-*", "aux-sidebar-style-" + to );',
        'choices'     => array(
            'simple' => array(
                'label'  => __( 'Simple' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-1.svg'
            ),
            'border' => array(
                'label'  => __( 'Bordered Sidebar' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-2.svg'
            ),
            'overlap' => array(
                'label'  => __( 'Overlap Background' , 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/sidebar-style-3.svg'
            )
        ),
        'type'          => 'radio-image',
        'default'       => 'border'
    );

    // -- Sub section - Product Category Page  -----------------------------------------------

    $sections[] = array(
        'id'          => 'product-section-category',
        'parent'      => 'product-section', // section parent's id
        'title'       => __( 'Product Category & Tag', 'phlox-pro' ),
        'description' => __( 'Product Category & Tag Page Setting', 'phlox-pro' )
    );

    }

    /* ---------------------------------------------------------------------------------------------------
        Footer Section
    --------------------------------------------------------------------------------------------------- */

    // Footer section ==================================================================

    $sections[] = array(
        'id'          => 'footer-section',
        'parent'      => '', // section parent's id
        'title'       => __( 'Footer', 'phlox-pro' ),
        'description' => __( 'Footer Setting', 'phlox-pro' ),
        'icon'        => 'axicon-down-circled'
    );

    // Sub section - Footer builder -------------------------------
    $sections[] = array(
        'id'          => 'footer-section-builder',
        'parent'      => 'footer-section',
        'title'       => __( 'Footer Templates', 'phlox-pro' ),
        'description' => __( 'Footer Templates', 'phlox-pro' )
    );

    if ( class_exists( '\Elementor\Plugin' ) ) {

        $options[] = array(
            'title'       => __( 'Current Footer', 'phlox-pro' ),
            'id'          => 'site_elementor_footer_edit_template',
            'section'     => 'footer-section-builder',
            'type'        => 'edit_template',
            'template'    => 'footer',
            'transport'   => 'refresh',
            'dependency'  => array(
                array(
                        'id'      => 'site_footer_use_legacy',
                        'value'   => '1',
                        'operator'=> '!='
                ),
            ),
        );

        $options[] = array(
            'title'         => __( 'Your Footers', 'phlox-pro' ),
            'id'            => 'site_elementor_footer_template',
            'section'       => 'footer-section-builder',
            'type'          => 'selective_list',
            'choices'       => auxin_get_elementor_templates_list('footer'),
            'dependency'    => array(
                array(
                        'id'      => 'site_footer_use_legacy',
                        'value'   => '1',
                        'operator'=> '!='
                ),
            ),
            'related_controls' => 'site_elementor_footer_edit_template'
        );

        $options[] = array(
            'title'         => __( 'Footer Templates Library', 'phlox-pro' ),
            'id'            => 'site_elementor_footer_templates_library',
            'section'       => 'footer-section-builder',
            'type'          => 'template_library',
            'template_type' => 'footer',
            'dependency'    => array(
                array(
                     'id'      => 'site_footer_use_legacy',
                     'value'   => '1',
                     'operator'=> '!='
                )
            ),
            'related_controls' => ['site_elementor_footer_template']
        );

    } else {
        $options[] = array(
            'title'       => __( 'Footer Builder', 'phlox-pro' ),
            'description' => __( 'Get footer builder and templates by installing Elementor.', 'phlox-pro' ),
            'id'          => 'site_footer_install_elementor',
            'section'     => 'footer-section-builder',
            'type'        => 'install_elementor_plugin',
            'transport'   => 'postMessage',
            'dependency'  => array(
                array(
                        'id'      => 'site_footer_use_legacy',
                        'value'   => '1',
                        'operator'=> '!='
                ),
            ),
        );
    }

    $options[] = array(
        'title'            => __( 'Use Legacy Footer', 'phlox-pro' ),
        'description'      => __( 'Disable it to replace footer section with an Elementor template', 'phlox-pro' ),
        'id'               => 'site_footer_use_legacy',
        'section'          => 'footer-section-builder',
        'type'             => 'switch',
        'transport'        => 'refresh',
        'default'          => '0',
        'related_controls' => [
            'site_subfooter_bar_section_use_legacy',
            'site_subfooter_section_use_legacy',
            'site_subfooter_appearance_section_use_legacy',
            'site_footer_section_use_legacy',
            'site_footer_appearence_section_use_legacy'
        ]
    );

    // Sub section - Footer builder -------------------------------

    $sections[] = array(
        'id'          => 'footer-section-template-setting',
        'parent'      => 'footer-section',
        'title'       => __( 'Footer Templates Settings', 'phlox-pro' ),
        'description' => __( 'Footer Templates Settings', 'phlox-pro' )
    );

    $options[] = array(
        'title'       => __( 'Enable Sticky Footer', 'phlox-pro' ),
        'description' => __( 'Enable this option to pin the footer and subfooter to bottom of the website.', 'phlox-pro' ),
        'id'          => 'site_footer_is_sticky',
        'section'     => 'footer-section-template-setting',
        'transport'   => 'refresh',
        'default'     => false,
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Copyright Text', 'phlox-pro' ),
        'description' => __( 'Enter your copyright text to display on footer.', 'phlox-pro' ),
        'id'          => 'copyright',
        'section'     => 'footer-section-template-setting',
        'partial'     => array(
            'selector'              => '.aux-copyright',
            'container_inclusive'   => false,
            'render_callback'       => function(){ auxin_footer_copyright_markup( true ); }
        ),
        'default'     => sprintf( __( '&copy; %s. All rights reserved.', 'phlox-pro' ), '{{Y}} {{sitename}}' ),
        'type'        => 'textarea'
    );

    $options[] = array(
        'title'       => __( 'Show Theme Attribution', 'phlox-pro' ),
        'description' => __( 'Show the "Powered By" text with link to theme homepage in footer.', 'phlox-pro' ),
        'id'          => 'attribution',
        'section'     => 'footer-section-template-setting',
        'partial'     => array(
            'selector'              => '.aux-copyright',
            'container_inclusive'   => false,
            'render_callback'       => function(){ auxin_footer_copyright_markup( true ); }
        ),
        'default'     => false,
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Show Privacy Policy', 'phlox-pro' ),
        'description' => __( 'Show a link to privacy policy page in the footer.', 'phlox-pro' ),
        'id'          => 'footer_privacy_policy_link_display',
        'section'     => 'footer-section-template-setting',
        'partial'     => array(
            'selector'              => '.aux-copyright',
            'container_inclusive'   => false,
            'render_callback'       => function(){ auxin_footer_copyright_markup( true ); }
        ),
        'default'     => false,
        'type'        => 'switch'
    );

    // Sub section - Footer legacy notice --------------------------

    $sections[] = array(
        'id'          => 'footer-section-deprecation-info',
        'parent'      => 'footer-section',
        'type'        => 'Auxin_Customize_Info_Section',
        'title'       => __( 'Legacy Footer Options', 'phlox-pro' ),
        'description' => __( 'The following options will be deprecated soon, Please DO NOT use them and use a "Footer Template" instead.', 'phlox-pro' ),
        'dependency'  => array(
            array(
                 'id'      => 'site_footer_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'       => __( 'Legacy Footer options notice', 'phlox-pro' ),
        'id'          => 'site_footer_info3',
        'section'     => 'footer-section-deprecation-info',
        'type'        => 'switch'
    );

    // Sub section - Sub Footer -------------------------------

    $sections[] = array(
        'id'            => 'footer-section-subfooter-bar',
        'parent'        => 'footer-section', // section parent's id
        'title'         => __( 'Subfooter Bar', 'phlox-pro' ),
        'description'   => __( 'Subfooter Bar Setting', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_footer_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Footer', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace footer section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_subfooter_bar_section_use_legacy',
        'section'        => 'footer-section-subfooter-bar',
        'type'           => 'switch',
        'transport'      => 'postMessage',
        'default'        => '0',
        'related_controls' => ['site_footer_use_legacy']
    );

    $options[] = array(
        'title'       => __( 'Display Subfooter Bar', 'phlox-pro' ),
        'description' => __( 'Enable it to display subfooter bar above of subfooter.', 'phlox-pro' ),
        'id'          => 'show_subfooter_bar',
        'section'     => 'footer-section-subfooter-bar',
        'dependency' => array(
            array(
                 'id'      => 'site_footer_use_legacy',
                 'value'   => array('1'),
                 'operator'=> '=='
            )
        ),
        'post_js'     => '$(".aux-subfooter-bar").auxToggle( to );',
        'default'     => '0',
        'starter'     => '1',
        'transport' => 'postMessage',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'      => __( 'Subfooter Bar Layout', 'phlox-pro' ),
        'description' => __( 'Specifies layout of subtoofer bar.', 'phlox-pro' ),
        'id'         => 'subfooter_bar_layout',
        'section'    => 'footer-section-subfooter-bar',
        'dependency' => array(
            array(
                 'id'      => 'show_subfooter_bar',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'post_js' => 'var bar = $(".aux-subfooter-bar"); bar.find(".container").toggleClass( "aux-fold", "vertical-none-boxed" == to || "vertical-small-boxed" == to ); bar.alterClass("vertical-*", to );',
        'transport' => 'postMessage',
        'choices'   => array(
            'vertical-none-full'   =>  array(
                'label' => __( 'Full', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-padding-none'
            ),
            'vertical-none-boxed'   =>  array(
                'label' => __( 'Boxed', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-padding-x'
            ),
            'vertical-small-full'   =>  array(
                'label' => __( 'Full with small vertical padding', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-padding-y'
            ),
            'vertical-small-boxed'  =>  array(
                'label' => __( 'Boxed with small vertical padding', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-padding-x-y'
            )
        ),
        'default'   => 'vertical-small-boxed',
        'type'      => 'radio-image'
    );

    $options[] = array(
        'title'       => __( 'Background Color', 'phlox-pro' ),
        'id'          => 'subfooter_bar_layout_bg_color',
        'description' => __( 'Specifies background color of subfooter bar.', 'phlox-pro' ),
        'section'     => 'footer-section-subfooter-bar',
        'type'        => 'color',
        'selectors'   => '.aux-subfooter-bar',
        'placeholder' => 'background-color:{{VALUE}};',
        'dependency'  => array(
            array(
                 'id'      => 'show_subfooter_bar',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'transport' => 'postMessage',
        'default'   => '#fafafa'
    );

    $options[] = array(
        'title'       => __( 'Top Border Color', 'phlox-pro' ),
        'id'          => 'subfooter_bar_top_border_color',
        'description' => __( 'Specifies top border color of subfooter bar.', 'phlox-pro' ),
        'section'     => 'footer-section-subfooter-bar',
        'type'        => 'color',
        'selectors'   => '.aux-subfooter-bar',
        'placeholder' => 'border-top:1px solid {{VALUE}};',
        'dependency'  => array(
            array(
                 'id'      => 'show_subfooter_bar',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'transport' => 'postMessage',
        'default'   => '#EAEAEA'
    );


    // Sub section - Sub Footer -------------------------------

    $sections[] = array(
        'id'            => 'footer-section-subfooter',
        'parent'        => 'footer-section', // section parent's id
        'title'         => __( 'Sub Footer', 'phlox-pro' ),
        'description'   => __( 'Sub Footer Setting', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_footer_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Footer', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace footer section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_subfooter_section_use_legacy',
        'section'        => 'footer-section-subfooter',
        'type'           => 'switch',
        'transport'      => 'postMessage',
        'default'        => '0',
        'related_controls' => ['site_footer_use_legacy']
    );

    $options[] = array(
        'title'       => __( 'Display Subfooter', 'phlox-pro' ),
        'description' => __( 'Enable it to display subfooter on all pages.', 'phlox-pro' ),
        'id'          => 'show_subfooter',
        'section'     => 'footer-section-subfooter',
        'dependency' => array(
            array(
                 'id'      => 'site_footer_use_legacy',
                 'value'   => array('1'),
                 'operator'=> '=='
            )
        ),
        'post_js'     => '$(".subfooter").auxToggle( to );',
        'transport'   => 'postMessage',
        'default'     => '0',
        'starter'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Subfooter Layout', 'phlox-pro' ),
        'description' => __( 'Select layout for subfooter widget columns.', 'phlox-pro' ). '<br>' .
                       sprintf( __( 'It generates some widgetareas for subfooter based on the layout, which you need to %s fill them.%s', 'phlox-pro' ),
                               '<a href="'.admin_url('widgets.php').'" target="_blank">', '</a>'  ),
        'id'         => 'subfooter_layout',
        'section'    => 'footer-section-subfooter',
        'dependency' => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'transport' => 'refresh',
        'choices'   => array(
            '1-1'   =>  array(
                'label' => __( '1 Column', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid1'
            ),
            '1-2_1-2'   =>  array(
                'label' => __( '2 Columns- 1/2  1/2' , 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid11'
            ),
            '2-3_1-3'   => array(
                'label' => __( '2 Columns- 2/3  1/3', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid21'
            ),
            '1-3_2-3'   => array(
                'label' => __( '2 Columns- 1/3  2/3', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid12'
            ),
            '3-4_1-4'   => array(
                'label' => __( '2 Columns- 3/4  1/4', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid31'
            ),
            '1-4_3-4'   => array(
                'label' => __( '2 Columns- 1/4  3/4', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid13'
            ),
            '1-3_1-3_1-3'  => array(
                'label' => __( '3 Columns- 1/3  1/3  1/3', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid111'
            ) ,
            '1-2_1-4_1-4'  => array(
                'label' => __( '3 Columns- 1/2  1/4  1/4', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid211'
            ) ,
            '1-4_1-4_1-2'  => array(
                'label' => __( '3 Columns- 1/4  1/4  1/2', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid112'
            ),
            '1-4_1-4_1-4_1-4' => array(
                'label' => __( '4 Columns- 1/4  1/4  1/4  1/4', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid1111'
            ),
            '1-5_1-5_1-5_1-5_1-5' => array(
                'label' => __( '5 Columns- 1/5  1/5  1/5  1/5  1/5', 'phlox-pro' ),
                'css_class' => 'axiAdminIcon-grid11111'
            )
        ),
        'default'   => '1-3_1-3_1-3',
        'type'      => 'radio-image'
    );


    $options[] = array(
        'title'       => __( 'Background Color', 'phlox-pro' ),
        'id'          => 'subfooter_layout_bg_color',
        'description' => __( 'Specifies background color of subfooter.', 'phlox-pro' ),
        'section'     => 'footer-section-subfooter',
        'type'        => 'color',
        'selectors'   => '.aux-subfooter',
        'placeholder' => 'background-color:{{VALUE}};',
        'dependency' => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'transport' => 'postMessage',
        'default'   => ''
    );

    $options[] = array(
        'title'       => __( 'Background Gradient', 'phlox-pro' ),
        'description' => __( 'Specifies the background color for subfooter', 'phlox-pro' ),
        'id'          => 'subfooter_layout_bg_gradient',
        'section'     => 'footer-section-subfooter',
        'dependency'  => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'transport'      => 'postMessage',
        'selectors'   => array(
            ".aux-subfooter" => "background-image:{{VALUE}};"
        ),
        'default'   => '',
        'type'      => 'gradient'
    );

    $options[] = array(
        'title'         => __( 'Sub Footer Background Image', 'phlox-pro' ),
        'description'   => __( 'Specifies a background image for sub footer.', 'phlox-pro' ),
        'id'            => 'subfooter_layout_bg_image',
        'section'       => 'footer-section-subfooter',
        'transport'     => 'postMessage',
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'subfooter_layout_bg_image' ) );
            }
            return empty( $value ) ? '' : sprintf( ".aux-subfooter { background-image: url(%s); }", wp_get_attachment_url( $value ) );
        },
        'type'          => 'image',
        'default'       => '',
        'dependency'    => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        )
    );

    $options[] = array(
        'title'       => __( 'Sub Footer Background Image Position', 'phlox-pro' ),
        'id'          => 'subfooter_layout_bg_image_position',
        'section'     => 'footer-section-subfooter',
        'type'        => 'select',
        'transport'   => 'postMessage',
        'selectors'   => array(
            ".aux-subfooter" => "background-position:{{VALUE}};"
        ),
        'dependency'  => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'choices'     => array(
            'left top'      => __( 'left top', 'phlox-pro' ),
            'left center'   => __( 'left center', 'phlox-pro' ),
            'left bottom'   => __( 'left bottom', 'phlox-pro' ),
            'right top'     => __( 'right top', 'phlox-pro' ),
            'right center'  => __( 'right center', 'phlox-pro' ),
            'right bottom'  => __( 'right bottom', 'phlox-pro' ),
            'center top'    => __( ' center top', 'phlox-pro' ),
            'center center' => __( 'center center', 'phlox-pro' ),
            'center bottom' => __( ' center bottom', 'phlox-pro' )
        ),
        'default'   => 'center center',
    );

    $options[] = array(
        'title'       => __( 'Sub Footer Background Image Size', 'phlox-pro' ),
        'id'          => 'subfooter_layout_bg_image_size',
        'section'     => 'footer-section-subfooter',
        'type'        => 'select',
        'transport'   => 'postMessage',
        'selectors'   => array(
            ".aux-subfooter" => "background-size:{{VALUE}};"
        ),
        'dependency'  => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'choices'     => array(
            'auto'    => __( 'Auto', 'phlox-pro' ),
            'cover'   => __( 'Cover', 'phlox-pro' ),
            'contain' => __( 'Contain', 'phlox-pro' ),
        ),
        'default'   => 'cover',
    );

    $options[] = array(
        'title'       => __( 'Sub Footer Background Image Repeat', 'phlox-pro' ),
        'id'          => 'subfooter_layout_bg_image_repeat',
        'section'     => 'footer-section-subfooter',
        'type'        => 'select',
        'transport'   => 'postMessage',
        'selectors'   => array(
            ".aux-subfooter" => "background-repeat:{{VALUE}};"
        ),
        'dependency'  => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'choices'     => array(
            'no-repeat' => __( 'No-Repeat', 'phlox-pro' ),
            'repeat'    => __( 'Repeat', 'phlox-pro' ),
            'repeat-x'  => __( 'Repeat-X', 'phlox-pro' ),
            'repeat-y'  => __( 'Repeat-Y', 'phlox-pro' )
        ),
        'default'   => 'no-repeat',
    );

    $options[] = array(
        'title'       => __( 'Dark Skin For Widgets', 'phlox-pro' ),
        'description' => __( 'Enable it to change the skin of widgets to dark mode', 'phlox-pro' ),
        'id'          => 'footer_widget_dark_mode',
        'section'     => 'footer-section-subfooter',
        'dependency' => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'default'     => '0',
        'starter'     => '0',
        'transport'   => 'refresh',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Top Border Color', 'phlox-pro' ),
        'id'          => 'subfooter_top_border_color',
        'description' => __( 'Specifies top border color of subfooter.', 'phlox-pro' ),
        'section'     => 'footer-section-subfooter',
        'type'        => 'color',
        'selectors'   => '.aux-subfooter',
        'placeholder' => 'border-top:1px solid {{VALUE}};',
        'dependency'  => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'transport' => 'postMessage',
        'default'   => '#EAEAEA',
        'starter'   => '#EAEAEA'
    );


    $options[] = array(
        'title'       => __( 'Hide Subfooter on Tablet', 'phlox-pro' ),
        'description' => __( 'Enable it to hide subfooter on tablet devices.', 'phlox-pro' ),
        'id'          => 'subfooter_hide_on_tablet',
        'section'     => 'footer-section-subfooter',
        'dependency'  => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'default'     => '0',
        'starter'     => '0',
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-subfooter").toggleClass( "aux-tablet-off", to );',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Hide Subfooter on mobile', 'phlox-pro' ),
        'description' => __( 'Enable it to hide subfooter on mobile devices.', 'phlox-pro' ),
        'id'          => 'subfooter_hide_on_phone',
        'section'     => 'footer-section-subfooter',
        'dependency'  => array(
            array(
                 'id'      => 'show_subfooter',
                 'value'   => array('1'),
                 'operator'=> ''
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'default'     => '0',
        'starter'     => '1',
        'transport'   => 'postMessage',
        'post_js'     => '$(".aux-subfooter").toggleClass( "aux-phone-off", to );',
        'type'        => 'switch'
    );


    // Sub section - Sub Footer Typography ------------------

    $sections[] = array(
        'id'            => 'footer-section-subfooter-appearance',
        'parent'        => 'footer-section', // section parent's id
        'title'         => __( 'Sub Footer Appearance', 'phlox-pro' ),
        'description'   => __( 'Sub Footer Appearance', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_footer_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Footer', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace footer section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_subfooter_appearance_section_use_legacy',
        'section'        => 'footer-section-subfooter-appearance',
        'type'           => 'switch',
        'transport'      => 'postMessage',
        'default'        => '0',
        'related_controls' => ['site_footer_use_legacy']
    );

    $options[] = array(
        'title'          => __( 'Padding', 'phlox-pro' ),
        'id'             => 'subfooter_appearance_padding',
        'section'        => 'footer-section-subfooter-appearance',
        'type'           => 'responsive_dimensions',
        'selectors'      => '.aux-subfooter > .aux-wrapper > .aux-container',
        'transport'      => 'postMessage',
        'placeholder'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        'dependency'  => array(
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
    );


    $options[] = array(
        'title'          => __( 'Widget Title', 'phlox-pro' ),
        'id'             => 'subfooter_widget_title_typography',
        'section'        => 'footer-section-subfooter-appearance',
        'type'           => 'group_typography',
        'selectors'      => '.aux-subfooter .aux-widget-area .widget-title',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
    );

    $options[] = array(
        'title'          => __( 'Widget Text', 'phlox-pro' ),
        'id'             => 'subfooter_widget_text_typography',
        'section'        => 'footer-section-subfooter-appearance',
        'type'           => 'group_typography',
        'selectors'      => '.aux-subfooter .aux-widget-area p',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
    );

    $options[] = array(
        'title'          => __( 'Widget Links', 'phlox-pro' ),
        'id'             => 'subfooter_widget_link_typography',
        'section'        => 'footer-section-subfooter-appearance',
        'type'           => 'group_typography',
        'selectors'      => '.aux-subfooter .aux-widget-area a',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
    );

    // Sub section - Footer -------------------------------

    $sections[] = array(
        'id'            => 'footer-section-footer',
        'parent'        => 'footer-section', // section parent's id
        'title'         => __( 'Footer', 'phlox-pro' ),
        'description'   => __( 'Footer Setting', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_footer_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Footer', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace footer section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_footer_section_use_legacy',
        'section'        => 'footer-section-footer',
        'type'           => 'switch',
        'transport'      => 'postMessage',
        'default'        => '0',
        'related_controls' => ['site_footer_use_legacy']
    );

    $options[] = array(
        'title'       => __( 'Display Footer', 'phlox-pro' ),
        'description' => __( 'Enable it to display footer on all pages.', 'phlox-pro' ),
        'id'          => 'show_site_footer',
        'section'     => 'footer-section-footer',
        'dependency'  => array(
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'post_js'     => '$(".aux-site-footer").auxToggle( to );',
        'transport'   => 'postMessage',
        'default'     => '1',
        'type'        => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Layout', 'phlox-pro' ),
        'description' => __( 'Specifies the footer layout.', 'phlox-pro' ),
        'id'          => 'site_footer_components_layout',
        'section'     => 'footer-section-footer',
        'type'        => 'radio-image',
        'dependency' => array(
            array(
                 'id'      => 'show_site_footer',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'transport'   => 'postMessage',
        'partial'     => array(
            'selector'              => '.aux-site-footer .aux-wrapper',
            'container_inclusive'   => false,
            'render_callback'       => function(){ echo auxin_get_footer_components_markup(); }
        ),
        'choices'     => array(
            'footer_preset1' => array(
                'label' => __( 'Footer Preset 1', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/footer-layout-1.svg'
            ),
            'footer_preset2' => array(
                'label' => __( 'Footer Preset 2', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/footer-layout-2.svg'
            ),
            'footer_preset3' => array(
                'label' => __( 'Footer Preset 3', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/footer-layout-3.svg'
            ),
            'footer_preset4' => array(
                'label' => __( 'Footer Preset 4', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/footer-layout-4.svg'
            ),
            'footer_preset5' => array(
                'label' => __( 'Footer Preset 5', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/footer-layout-4.svg'
            )
        ),
        'default'   => 'footer_preset4'
    );


    $options[] = array(
        'title'       => __( 'Background Color', 'phlox-pro' ),
        'description' => __( 'Specifies the background color for footer', 'phlox-pro' ),
        'id'          => 'site_footer_bg_color',
        'section'     => 'footer-section-footer',
        'dependency'  => array(
            array(
                 'id'      => 'show_site_footer',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'selectors'   => array(
            ".aux-site-footer" => "background-color:{{VALUE}};"
        ),
        'default'     => '#1A1A1A',
        'starter'     => '#1A1A1A',
        'type'        => 'color' ,
        'transport'   => 'postMessage',
    );

    $options[] = array(
        'title'       => __( 'Background Gradient', 'phlox-pro' ),
        'description' => __( 'Specifies the background color for footer', 'phlox-pro' ),
        'id'          => 'site_footer_bg_gradient',
        'section'     => 'footer-section-footer',
        'dependency'  => array(
            array(
                 'id'      => 'show_site_footer',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'transport'      => 'postMessage',
        'selectors'   => array(
            ".aux-site-footer" => "background-image:{{VALUE}};"
        ),
        'default'   => '',
        'type'      => 'gradient'
    );

    $options[] = array(
        'title'       => __( 'Top Separator Color', 'phlox-pro' ),
        'id'          => 'footer_top_border_color',
        'description' => __( 'Specifies the color of separator on top of footer.', 'phlox-pro' ),
        'section'     => 'footer-section-footer',
        'type'        => 'color',
        'dependency'  => array(
            array(
                 'id'      => 'show_site_footer',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'selectors'   => array(
            ".aux-site-footer" => "border-top:1px solid {{VALUE}};"
        ),
        'transport' => 'postMessage',
        'default'   => '#EAEAEA'
    );

    $options[] = array(
        'title'       => __( 'Top Border Thickness', 'phlox-pro' ),
        'id'          => 'footer_top_border_width',
        'description' => __( 'Specifies the thickness of top border on footer in pixels.', 'phlox-pro' ),
        'section'     => 'footer-section-footer',
        'type'        => 'text',
        'dependency'  => array(
            array(
                 'id'      => 'show_site_footer',
                 'value'   => array('1'),
                 'operator'=> '=='
            ),
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = auxin_get_option( 'footer_top_border_width' );
            }
            $value = trim( esc_attr( $value ), 'px' );
            if( '' !== $value ){
                $value = $value ? $value : 0;
                return sprintf( ".aux-site-footer { border-top-width:%spx; }", $value );
            }
            return '';
        },
        'transport' => 'postMessage',
        'default'   => '1'
    );

    // Sub section - Footer Appearance ------------------

    $sections[] = array(
        'id'            => 'footer-section-footer-appearance',
        'parent'        => 'footer-section', // section parent's id
        'title'         => __( 'Footer Appearance', 'phlox-pro' ),
        'description'   => __( 'Footer Appearance', 'phlox-pro' ),
        'is_deprecated' => true,
        'dependency'    => array(
            array(
                 'id'      => 'site_footer_use_legacy',
                 'value'   => '1',
                 'operator'=> '=='
            )
        )
    );

    $options[] = array(
        'title'          => __( 'Use Legacy Footer', 'phlox-pro' ),
        'description'    => __( 'Disable it to replace footer section with an Elementor template', 'phlox-pro' ),
        'id'             => 'site_footer_appearence_section_use_legacy',
        'section'        => 'footer-section-footer-appearance',
        'type'           => 'switch',
        'transport'      => 'postMessage',
        'default'        => '0',
        'related_controls' => ['site_footer_use_legacy']
    );

    $options[] = array(
        'title'          => __( 'Copyright', 'phlox-pro' ),
        'id'             => 'footer_copyright_typography',
        'section'        => 'footer-section-footer-appearance',
        'type'           => 'group_typography',
        'selectors'      => '.aux-copyright',
        'transport'      => 'postMessage',
        'default'        => '',
        'dependency'  => array(
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
    );

    $options[] = array(
        'title'          => __( 'Theme Attribution', 'phlox-pro' ),
        'id'             => 'footer_attribution_link_typography',
        'section'        => 'footer-section-footer-appearance',
        'type'           => 'group_typography',
        'selectors'      => '.aux-site-footer .aux-attribution a',
        'transport'      => 'postMessage',
        'default'        => '',
        'dependency'  => array(
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
    );

    $options[] = array(
        'title'          => __( 'Privacy Policy', 'phlox-pro' ),
        'id'             => 'footer_privacy_policy_link_typography',
        'section'        => 'footer-section-footer-appearance',
        'type'           => 'group_typography',
        'selectors'      => '.aux-site-footer .aux-privacy-policy a',
        'transport'      => 'postMessage',
        'default'        => '',
        'dependency'  => array(
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
    );

    $options[] = array(
        'title'          => __( 'Footer Menu', 'phlox-pro' ),
        'description'    => '',
        'id'             => 'footer_main_menu_typography',
        'section'        => 'footer-section-footer-appearance',
        'default'        => '',
        'type'           => 'group_typography',
        'selectors'      => '.aux-site-footer .footer-menu li > a',
        'transport'      => 'postMessage',
        'dependency'  => array(
            array(
                'id'      => 'site_footer_use_legacy',
                'value'   => array('1'),
                'operator'=> '=='
           )
        ),
    );

    /* ---------------------------------------------------------------------------------------------------
        Tools Section
    --------------------------------------------------------------------------------------------------- */

    $auxin_active_post_types = auxin_get_possible_post_types( true );

    // Tools parent section ==============================================================

    $sections[] = array(
        'id'          => 'tools-section',
        'parent'      => '', // section parent's id
        'title'       => __( 'Extras', 'phlox-pro' ),
        'description' => __( 'Extras', 'phlox-pro' ),
        'icon'        => 'axicon-tools'
    );


    // Sub section - Go to top options -------------------------------

    $sections[] = array(
        'id'          => 'tools-section-goto-top',
        'parent'      => 'tools-section', // section parent's id
        'title'       => __( 'Go to Top Button ', 'phlox-pro' ),
        'description' => __( 'Go to Top Button Options', 'phlox-pro' )
    );

    $options[] = array(
        'title'     => __( 'Display Go to top button', 'phlox-pro' ),
        'description' => __( 'Enable it to display Go to Top button.', 'phlox-pro' ),
        'id'        => 'show_goto_top_btn',
        'section'   => 'tools-section-goto-top',
        'dependency'=> array(),
        'transport' => 'postMessage',
        'post_js'   => '$(".aux-goto-top-btn").auxToggle( to );',
        'default'   => '1',
        'type'      => 'switch'
    );

    $options[] = array(
        'title'       => __( 'Animate scroll', 'phlox-pro' ),
        'description' => __( 'Specifies whether animate or instantly go to top of page, when goto top button clicks.', 'phlox-pro' ),
        'id'          => 'goto_top_animate',
        'section'     => 'tools-section-goto-top',
        'dependency'  => array(
            array(
                'id' => 'show_goto_top_btn',
                'value' => array( '1' )
            )
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".aux-goto-top-btn").data( "animate-scroll", to );',
        'default'   => '1',
        'type'      => 'switch'
    );


    $options[] = array(
        'title'       => __( 'Go to top button position', 'phlox-pro' ),
        'description' => __( 'Specifies the position of Go to Top button.', 'phlox-pro' ),
        'id'          => 'goto_top_alignment',
        'section'     => 'tools-section-goto-top',
        'dependency'  => array(
            array(
                'id' => 'show_goto_top_btn',
                'value' => array( '1' )
            )
        ),
        'choices'   => array(
            'left'   =>  array(
                'label'     => __( 'Left', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/goto-top-left.svg'
            ),
            'center'   =>  array(
                'label'     => __( 'Center', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/goto-top-center.svg'
            ),
            'right'   =>  array(
                'label'     => __( 'Right', 'phlox-pro' ),
                'image' => AUXIN_URL . 'images/visual-select/goto-top-right.svg'
            )
        ),
        'transport' => 'postMessage',
        'post_js'   => '$(".aux-goto-top-btn").alterClass( "aux-align-btn-*", "aux-align-btn-" + to );',
        'default'   => 'right',
        'type'      => 'radio-image'
    );


    // Sub section - Performance -------------------------------

    $sections[] = array(
        'id'          => 'tools-section-performance',
        'parent'      => 'tools-section', // section parent's id
        'title'       => __( 'Performance', 'phlox-pro' ),
        'description' => __( 'Performance Options', 'phlox-pro' )
    );

    $options[] = array(
        'title'       => __( 'Enable image preload preview', 'phlox-pro' ),
        'description' => __( 'Specifies whether to preload images in order to reduce page loading time or load them normally.', 'phlox-pro' ),
        'id'          => 'enable_site_image_preload_preview',
        'section'     => 'tools-section-performance',
        'dependency'  => array(),
        'transport'   => 'postMessage',
        'default'     => '0',
        'type'        => 'switch'
    );


    $options[] = array(
        'title'       => __( 'Image preload transition duration', 'phlox-pro' ),
        'description' => __( 'Specifies the duration of blur fade transition (in milliseconds) when an image completely loaded.', 'phlox-pro' ),
        'id'          => 'site_image_prelaod_transition_duration',
        'section'     => 'tools-section-performance',
        'dependency'  => array(
            array(
                'id'    => 'enable_site_image_preload_preview',
                'value' => '1'
            )
        ),
        'transport'   => 'postMessage',
        'default'     => '',
        'type'        => 'text',
        'style_callback' => function( $value = null ){
            if( ! $value ){
                $value = esc_attr( auxin_get_option( 'site_image_prelaod_transition_duration' ) );
            }
            $value = trim( $value, 'ms' );
            return empty( $value ) ? '' : ".aux-has-preview { transition-duration:{$value}ms; }";
        },
    );

    $sections[] = array(
        'id'          => 'tools-section-breadcrumbs',
        'parent'      => 'tools-section', // section parent's id
        'title'       => __( 'Breadcrumbs', 'phlox-pro' ),
        'description' => __( 'Breadcrumbs general options', 'phlox-pro' )
    );

    $options[] = array(
        'title'     => __( 'Breadcrumbs text max length', 'phlox-pro' ),
        'id'        => 'breadcrumbs_text_max_length',
        'section'   => 'tools-section-breadcrumbs',
        'dependency'=> array(),
        'default'   => '30',
        'type'      => 'number'
    );


    return array( 'fields' => $options, 'sections' => $sections );
}

add_filter( 'auxin_defined_option_fields_sections', 'auxin_define_options_info' );
