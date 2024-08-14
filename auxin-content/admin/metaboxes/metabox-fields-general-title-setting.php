<?php
/**
 * Add title setting meabox
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

function auxin_metabox_fields_general_title(){

    $model         = new Auxin_Metabox_Model();
    $model->id     = 'general-title';
    $model->title  = __('Title Bar Setting', 'phlox-pro');
    $model->fields = array(

        array(
            'title'         => __( 'Display Title Bar Section', 'phlox-pro' ),
            'description'   => __( 'Choose "Yes" in order to customize the title bar of this page, or choose "No" to turn it off.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_show',
            'id_deprecated' => 'show_title',
            'type'          => 'dropdown',
            'default'       => 'default',
            'choices' => array(
                'default'   => __( 'Theme Default', 'phlox-pro' ) ,
                'yes'       => __( 'Yes', 'phlox-pro' ),
                'no'        => __( 'No', 'phlox-pro' ),
            )
        ),

        array(
            'title'         => __( 'Layout presets', 'phlox-pro' ),
            'description'   => '',
            'id'            => 'aux_title_bar_preset',
            'type'          => 'radio-image',
            'default'       => 'default',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                )
            ),
            'choices'       => array(
                'default'        => array(
                    'label'   => __( 'Theme Default', 'phlox-pro' ),
                    'image'   => AUXIN_URL . 'images/visual-select/default3.svg',
                    'presets' => array()
                ),
                'normal_title_1' => array(
                    'label'   => __( 'Default', 'phlox-pro' ),
                    'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-4.svg',
                    'presets' => array(
                        'aux_title_bar_content_width_type'      => 'boxed',
                        'aux_title_bar_content_section_height'  => 'auto',
                        'aux_title_bar_heading_bordered'        => 0,
                        'aux_title_bar_heading_boxed'           => 0,
                        'aux_title_bar_meta_enabled'            => 0,
                        'aux_title_bar_bread_enabled'           => 1,
                        'aux_title_bar_bread_bordered'          => 0,
                        'aux_title_bar_bread_sep_style'         => 'auxicon-chevron-right-1',
                        'aux_title_bar_text_align'              => 'left',
                        'aux_title_bar_vertical_align'          => 'top',
                        'aux_title_bar_scroll_arrow'            => 'none',
                        'aux_title_bar_color_style'             => 'dark',
                        'aux_title_bar_overlay_color'           => '',
                        'aux_title_bar_overlay_pattern'         => ''
                    )
                ),
                'normal_bg_light_1' => array(
                    'label'   => __( 'Title bar with light overlay which is aligned center', 'phlox-pro' ),
                    'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-1.svg',
                    'presets' => array(
                        'aux_title_bar_content_width_type'      => 'boxed',
                        'aux_title_bar_content_section_height'  => 'auto',
                        'aux_title_bar_heading_bordered'        => 0,
                        'aux_title_bar_heading_boxed'           => 0,
                        'aux_title_bar_bread_enabled'           => 1,
                        'aux_title_bar_bread_bordered'          => 0,
                        'aux_title_bar_bread_sep_style'         => 'auxicon-chevron-right-1',
                        'aux_title_bar_text_align'              => 'center',
                        'aux_title_bar_vertical_align'          => 'top',
                        'aux_title_bar_scroll_arrow'            => 'none',
                        'aux_title_bar_color_style'             => 'dark',
                        'aux_title_bar_overlay_color'           => '',
                        'aux_title_bar_overlay_pattern'         => ''
                    )
                ),
                'full_bg_light_1' => array(
                    'label'   => __( 'Fullscreen title bar with light overlay on background', 'phlox-pro' ),
                    'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-2.svg',
                    'presets' => array(
                        'aux_title_bar_content_width_type'      => 'boxed',
                        'aux_title_bar_content_section_height'  => 'full',
                        'aux_title_bar_heading_bordered'        => 0,
                        'aux_title_bar_heading_boxed'           => 0,
                        'aux_title_bar_bread_enabled'           => 1,
                        'aux_title_bar_bread_bordered'          => 1,
                        'aux_title_bar_bread_sep_style'         => 'auxicon-triangle-right',
                        'aux_title_bar_text_align'              => 'center',
                        'aux_title_bar_vertical_align'          => 'middle',
                        'aux_title_bar_scroll_arrow'            => 'round',
                        'aux_title_bar_color_style'             => 'dark',
                        'aux_title_bar_overlay_color'           => 'rgba(255,255,255,0.50)',
                        'aux_title_bar_overlay_pattern'         => ''
                    )
                ),
                'full_bg_dark_1' => array(
                    'label'   => __( 'Fullscreen title bar with dark overlay on background', 'phlox-pro' ),
                    'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-3.svg',
                    'presets' => array(
                        'aux_title_bar_content_width_type'      => 'boxed',
                        'aux_title_bar_content_section_height'  => 'full',
                        'aux_title_bar_heading_bordered'        => 0,
                        'aux_title_bar_heading_boxed'           => 0,
                        'aux_title_bar_bread_enabled'           => 1,
                        'aux_title_bar_bread_bordered'          => 0,
                        'aux_title_bar_bread_sep_style'         => 'auxicon-triangle-right',
                        'aux_title_bar_text_align'              => 'center',
                        'aux_title_bar_vertical_align'          => 'middle',
                        'aux_title_bar_scroll_arrow'            => 'round',
                        'aux_title_bar_color_style'             => 'light',
                        'aux_title_bar_overlay_color'           => 'rgba(0,0,0,0.6)',
                        'aux_title_bar_overlay_pattern'         => ''
                    )
                ),
                'full_bg_dark_2' => array(
                    'label'   => __( 'Fullscreen title bar with border around the title', 'phlox-pro' ),
                    'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-6.svg',
                    'presets' => array(
                        'aux_title_bar_content_width_type'      => 'boxed',
                        'aux_title_bar_content_section_height'  => 'full',
                        'aux_title_bar_heading_bordered'        => 1,
                        'aux_title_bar_heading_boxed'           => 0,
                        'aux_title_bar_bread_enabled'           => 0,
                        'aux_title_bar_bread_bordered'          => 1,
                        'aux_title_bar_bread_sep_style'         => 'auxicon-triangle-right',
                        'aux_title_bar_text_align'              => 'center',
                        'aux_title_bar_vertical_align'          => 'middle',
                        'aux_title_bar_scroll_arrow'            => 'round',
                        'aux_title_bar_color_style'             => 'dark',
                        'aux_title_bar_overlay_color'           => 'rgba(250,250,250,0.3)',
                        'aux_title_bar_overlay_pattern'         => ''
                    )
                ),
                'full_bg_dark_3' => array(
                    'label'   => __( 'Fullscreen title bar with dark box around the title', 'phlox-pro' ),
                    'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-7.svg',
                    'presets' => array(
                        'aux_title_bar_content_width_type'      => 'boxed',
                        'aux_title_bar_content_section_height'  => 'full',
                        'aux_title_bar_heading_bordered'        => 0,
                        'aux_title_bar_heading_boxed'           => 1,
                        'aux_title_bar_bread_enabled'           => 0,
                        'aux_title_bar_bread_bordered'          => 0,
                        'aux_title_bar_bread_sep_style'         => 'auxicon-triangle-right',
                        'aux_title_bar_text_align'              => 'center',
                        'aux_title_bar_vertical_align'          => 'middle',
                        'aux_title_bar_scroll_arrow'            => 'round',
                        'aux_title_bar_color_style'             => 'light',
                        'aux_title_bar_overlay_color'           => 'rgba(0,0,0,0.5)',
                        'aux_title_bar_overlay_pattern'         => ''
                    )
                ),
                'normal_bg_dark_1' => array(
                    'label'   => __( 'Title aligned left with dark overlay on background', 'phlox-pro' ),
                    'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-5.svg',
                    'presets' => array(
                        'aux_title_bar_content_width_type'      => 'boxed',
                        'aux_title_bar_content_section_height'  => 'auto',
                        'aux_title_bar_heading_bordered'        => 0,
                        'aux_title_bar_heading_boxed'           => 0,
                        'aux_title_bar_bread_enabled'           => 1,
                        'aux_title_bar_bread_bordered'          => 0,
                        'aux_title_bar_bread_sep_style'         => 'auxicon-chevron-right-1',
                        'aux_title_bar_text_align'              => 'left',
                        'aux_title_bar_vertical_align'          => 'bottom',
                        'aux_title_bar_scroll_arrow'            => 'none',
                        'aux_title_bar_color_style'             => 'light',
                        'aux_title_bar_overlay_color'           => 'rgba(0,0,0,0.3)',
                        'aux_title_bar_overlay_pattern'         => ''
                    )
                ),
                'full_bg_dark_4' => array(
                    'label'   => __( 'Tile overlaps the title area section and is aligned center', 'phlox-pro' ),
                    'image'   => AUXIN_URL . 'images/visual-select/titlebar-style-8.svg',
                    'presets' => array(
                        'aux_title_bar_content_width_type'      => 'boxed',
                        'aux_title_bar_content_section_height'  => 'auto',
                        'aux_title_bar_heading_bordered'        => 0,
                        'aux_title_bar_heading_boxed'           => 1,
                        'aux_title_bar_bread_enabled'           => 1,
                        'aux_title_bar_bread_bordered'          => 1,
                        'aux_title_bar_bread_sep_style'         => 'auxicon-chevron-right-1',
                        'aux_title_bar_text_align'              => 'center',
                        'aux_title_bar_vertical_align'          => 'bottom-overlap',
                        'aux_title_bar_scroll_arrow'            => 'none',
                        'aux_title_bar_color_style'             => 'light',
                        'aux_title_bar_overlay_color'           => 'rgba(0,0,0,0.5)',
                        'aux_title_bar_overlay_pattern'         => ''
                    )
                )
            )
        ),

        array(
            'title'         => __( 'Enable Advanced Setting', 'phlox-pro' ),
            'description'   => __( 'Enable it to customize preset layouts.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_enable_customize',
            'type'          => 'switch',
            'default'       => '0',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            ),
        ),

        array(
            'title'         => __( 'Content Width', 'phlox-pro' ),
            'description'   => '',
            'id'            => 'aux_title_bar_content_width_type',
            'type'          => 'radio-image',
            'default'       => 'boxed',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
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
        ),

        array(
            'title'         => __( 'Title Section Height', 'phlox-pro' ),
            'description'   => '',
            'id'            => 'aux_title_bar_content_section_height',
            'type'          => 'select',
            'default'       => '',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   =>'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            ),
            'choices'       => array(
                'auto'      => __( 'Auto Height', 'phlox-pro' ),
                'full'      => __( 'Full Height', 'phlox-pro' )
            )
        ),


        array(
            'title'         => __( 'Vertical Position', 'phlox-pro' ),
            'description'   => __( 'Specifies vertical alignment of title and subtitle.', 'phlox-pro' ) . "<br/>".
                               __( 'Note: Parallax feature in not available for "Bottom Overlap" vertical mode.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_vertical_align',
            'type'          => 'select',
            'default'       => '',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            ),
            'choices'            => array(
                ''               => __( 'Default', 'phlox-pro' ),
                'top'            => __( 'Top'    , 'phlox-pro' ),
                'middle'         => __( 'Middle' , 'phlox-pro' ),
                'bottom'         => __( 'Bottom' , 'phlox-pro' ),
                'bottom-overlap' => __( 'Bottom Overlap', 'phlox-pro' )
            )
        ),

        array(
            'title'         => __( 'Scroll Down Arrow', 'phlox-pro' ),
            'description'   => __( 'This option only applies if section height is "Full Height".', 'phlox-pro' ),
            'id'            => 'aux_title_bar_scroll_arrow',
            'type'          => 'radio-image',
            'default'       => '',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_content_section_height',
                     'value'   => 'full',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_vertical_align',
                     'value'   => array('top', 'middle', 'bottom'),
                     'operator'=> '=='
                )
            ),
            'choices'       => array(
                '' => array(
                    'label'     => __( 'None', 'phlox-pro' ),
                    'css_class' => 'axiAdminIcon-none'
                ),
                'round' => array(
                    'label'     => __( 'Round', 'phlox-pro' ),
                    'css_class' => 'axiAdminIcon-scroll-down-arrow-outline'
                )
            )
        ),

        array(
            'title'         => __( 'Display Titles', 'phlox-pro' ),
            'description'   => __( 'Enable it to display title/subtitle in title section.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_title_show',
            'type'          => 'switch',
            'default'       => '1',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            )
        ),

        array(
            'title'         => __( 'Border for Heading', 'phlox-pro' ),
            'description'   => __( 'Enable it to display a border around the title and subtitle area.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_heading_bordered',
            'type'          => 'switch',
            'default'       => '0',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_title_show',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            )
        ),

        array(
            'title'         => __( 'Boxed Title', 'phlox-pro' ),
            'description'   => __( 'Enable it to wrap the title and subtitle in a box with background color.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_heading_boxed',
            'type'          => 'switch',
            'default'       => '0',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_title_show',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            )
        ),

        array(
            'title'         => __( 'Title Box Color', 'phlox-pro' ),
            'description'   => __( 'Specifies a custom background color for the box around the title and subtitle.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_heading_bg_color',
            'type'          => 'color',
            'default'       => '',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_title_show',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_heading_boxed',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            )
        ),

        array(
            'title'         => __( 'Display Post Meta', 'phlox-pro' ),
            'description'   => __( 'Enable it to display post meta information on title section.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_meta_enabled',
            'type'          => 'switch',
            'default'       => '0',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            ),
        ),

        array(
            'title'         => __( 'Display Breadcrumb', 'phlox-pro' ),
            'description'   => __( 'Enable it to display breadcrumb on title section.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_bread_enabled',
            'type'          => 'switch',
            'default'       => '1',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            ),
        ),

        array(
            'title'         => __( 'Border for Breadcrumb', 'phlox-pro' ),
            'description'   => __( 'Enable it to display border around breadcrumb.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_bread_bordered',
            'type'          => 'switch',
            'default'       => '0',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_bread_enabled',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            ),
        ),

        array(
            'title'         => __( 'Breadcrumb Separator', 'phlox-pro' ),
            'description'   => 'enable it to display separator between breadcrumb parts.',
            'id'            => 'aux_title_bar_bread_sep_style',
            'type'          => 'icon',
            'default'       => 'auxicon-chevron-right-1',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_bread_enabled',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            ),
        ),

        array(
            'title'         => __( 'Text Align', 'phlox-pro' ),
            'description'   => '',
            'id'            => 'aux_title_bar_text_align',
            'type'          => 'radio-image',
            'default'       => 'left',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
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
        ),


        array(
            'title'         => __( 'Overlay Color', 'phlox-pro' ),
            'description'   => __( 'The color that overlay on the background. Please note that color should have transparency.','phlox-pro' ),
            'id'            => 'aux_title_bar_overlay_color',
            'type'          => 'color',
            'default'       => '',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            )
        ),

        array(
            'title'         => __( 'Overlay Pattern', 'phlox-pro' ),
            'description'   => '',
            'id'            => 'aux_title_bar_overlay_pattern',
            'type'          => 'radio-image',
            'default'       => 'none',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
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
        ),


        array(
            'title'         => __( 'Overlay Pattern Opacity', 'phlox-pro' ),
            'description'   => '',
            'id'            => 'aux_title_bar_overlay_pattern_opacity',
            'type'          => 'text',
            'default'       => '0.15',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            )
        ),

        array(
            'title'         => __( 'Color Mode', 'phlox-pro' ),
            'description'   => '',
            'id'            => 'aux_title_bar_color_style',
            'type'          => 'select2',
            'default'       => '',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            ),
            'choices'       => array(
                'dark'  => __( 'Dark', 'phlox-pro' ),
                'light' => __( 'Light', 'phlox-pro' )
            )
        ),

        ////////////////////////////////////////////////////////////////////////////////////////

        array(
            'title'         => __( 'Enable Title Background', 'phlox-pro' ),
            'description'   => __( 'Enable it to display custom background for title section.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_bg_show',
            'id_deprecated' => 'axi_show_title_section_background',
            'type'          => 'switch',
            'default'       => '0',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            )
        ),

        array(
            'title'         => __( 'Background for title section', 'phlox-pro' ),
            'description'   => '',
            'type'          => 'sep',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_bg_show',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            )
        ),

        array(
            'title'         => __( 'Title Background', 'phlox-pro' ),
            'description'   => __( 'Specifies a background for title bar.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_bg',
            'id_deprecated' => 'axi_title_section_background',
            'type'          => 'background',
            'default'       => '',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_bg_show',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            ),
            'default' => array(
                'image'         => '',
                'size'          => 'cover',
                'color'         => '',
                'video_mp4'     => '',
                'video_ogg'     => '',
                'video_webm'    => ''
            )
        ),

        array(
            'title'         => __( 'Enable Parallax Effect', 'phlox-pro' ),
            'description'   => __( 'Enable it to have parallax background effect on this section.', 'phlox-pro' )."<br />".
                               __( 'Note: Parallax feature in not available for "Bottom Overlap" mode for "Vertical Position" option.', 'phlox-pro' ),
            'id'            => 'aux_title_bar_bg_parallax',
            'type'          => 'switch',
            'default'       => '0',
            'dependency'    => array(
                array(
                     'id'      => 'aux_title_bar_show',
                     'value'   => 'yes',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_enable_customize',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_bg_show',
                     'value'   => '1',
                     'operator'=> '=='
                ),
                array(
                     'id'      => 'aux_title_bar_preset',
                     'value'   => array('normal_title_1', 'normal_bg_light_1', 'full_bg_light_1', 'full_bg_dark_1', 'full_bg_dark_2','full_bg_dark_3', 'normal_bg_dark_1', 'full_bg_dark_4'),
                     'operator'=> '=='
                )
            )
        )

    );

    return $model;
}
