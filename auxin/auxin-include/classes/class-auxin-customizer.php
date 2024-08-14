<?php
/**
 * Customizer manager for auxin framework
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

class Auxin_Customizer{

    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Sections and panels
     *
     * @var array
     */
    public $sections = array();

    /**
     * List of fields
     *
     * @var array
     */
    public $fields = array();

    /**
     * Nonce for customizer ajax calls
     *
     * @var string
     */
    private $nonce;


    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }


    function __construct(){
        add_action( 'customize_register'                , array( $this, 'customize_register') );
        add_action( 'customize_preview_init'            , array( $this, 'preview_init'      ) );
        add_action( 'customize_controls_print_styles'   , array( $this, 'controls_style'    ) );
        add_action( 'customize_controls_enqueue_scripts', array( $this, 'controls_script'   ) );

        // ajax call by controls
        add_action( 'wp_ajax_auxin_customizer'          , array( $this, 'ajax_get'          ) );
        // intergrating the import/export plugin
        add_filter( 'cei_export_option_keys'            , array( $this, 'customizer_export_option_keys' ) );

        $this->nonce = wp_create_nonce( 'aux-customizer-nonce' );
    }


    /**
     * Define what extra options are expected to be exported with customizer export plugin
     *
     * @param  array $option_keys  The list of options we need to export too
     */
    public function customizer_export_option_keys( $option_keys ) {
        // Will be @deprecated at version 2.0
        remove_theme_mod( 'font_icons_list_fontastic' );

        $option_keys[] = THEME_ID.'_theme_options';

        return $option_keys;
    }

    /**
     * Ajax call for customizer controllers
     *
     * @return void
     */
    public function ajax_get(){

        if( isset( $_REQUEST['setting_id'] ) ){

            if( isset( $_REQUEST['nonce'] ) ){
                if( ! wp_verify_nonce( $_REQUEST['nonce'], 'aux-customizer-nonce' ) ){
                    wp_send_json_error( 'Access denied [aux103].' );
                }
            } else {
                wp_send_json_error( 'Access denied [aux107].' );
            }

            $setting_id    = $_REQUEST['setting_id'];
            $setting_value = $_REQUEST['setting_value'];

            // If the setting_variable is equal to null, then use the default_value
            if( empty( $setting_value ) ){
                $setting_value = $_REQUEST['default_value'];
            }

            $field = Auxin_Option::api()->controller->get_field( $setting_id );
            $style = '';

            if( ! empty( $field['style_callback'] ) ){
                $style = call_user_func( $field['style_callback'], $setting_value );
            }
            wp_send_json_success( $style );
        }

        wp_send_json_error( 'Setting ID not found' );
    }

    /**
     * Gets the setting and sections and generates the customizer controllers and other parts
     */
    public function render( $sections = null, $fields = null ){

        if( is_array( $sections ) ){
            $this->sections = $sections;
        }
        if( is_array( $fields ) ){
            $this->fields = $fields;
        }

    }

    /**
     * Render the options
     *
     * @return void
     */
    public function maybe_render(){
        $sorted_sections = Auxin_Option::api()->controller->sort_sections();
        $sorted_fields   = Auxin_Option::api()->controller->sort_fields();

        if( empty( $sorted_sections ) || empty( $sorted_fields ) ){
            return;
        }

        $this->render( $sorted_sections, $sorted_fields );
    }

    /**
     * Exclude the following options from options list
     *
     * @return array   The list of exclude options
     */
    public function exclude_types(){
        return apply_filters( 'auxin_customizer_excludes_types', array() );
    }

    /**
     * List of all special controls
     *
     * @return array   The list of all special controls
     */
    public function special_types(){
        return array('group_typography', 'color',  'responsive_slider', 'responsive_dimensions', 'typography_template_part',  'global_colors_template_part' );
    }

    /**
     * Special styles for customizer controls
     *
     * @return void
     */
    public function controls_style() {
        if ( is_rtl() ) {
            wp_enqueue_style( 'auxin-customizer-rtl',  ADMIN_CSS_URL . 'other/customizer-rtl.css', NULL, THEME_VERSION, 'all' );
        } else {
            wp_enqueue_style( 'auxin-customizer',  ADMIN_CSS_URL . 'other/customizer.css', NULL, THEME_VERSION, 'all' );
        }

        wp_localize_script( 'jquery', 'auxinCustomizerNonce', [ 'nonce' => $this->nonce ] );
    }

    /**
     * Special scripts for customizer controls
     *
     * @return void
     */
    public function controls_script() {
        wp_enqueue_script( 'auxin-customizer', ADMIN_JS_URL . 'solo/customizer-controls.js' , array( 'jquery' ), THEME_VERSION, true );
    }

    /**
     * Special styles and scripts for customizer preview frame
     *
     * @return void
     */
    public function preview_init(){
        wp_enqueue_script( 'customize-preview' );
        wp_enqueue_script( 'auxin-customizer', ADMIN_JS_URL . 'solo/customizer.js' , array( 'jquery', 'customize-preview' ), THEME_VERSION, true );

        wp_localize_script( 'customize-preview', 'auxinCustomizerNonce', [ 'nonce' => $this->nonce ] );

        // load the file in customizer preview frame
        wp_enqueue_style( 'auxin-customizer-preview',  ADMIN_CSS_URL . 'other/customizer-preview.css', NULL, THEME_VERSION, 'all' );
    }

    /**
     * Adding extra controllers and sections on customizer initialization
     *
     * @return void
     */
    public function customize_register( WP_Customize_Manager $wp_customize ){

        $wp_customize->register_section_type( 'Auxin_Customize_Section' );
        $wp_customize->register_section_type( 'Auxin_Customize_Link_Section' );
        $wp_customize->register_section_type( 'Auxin_Customize_Info_Section' );

        $wp_customize->attach_ids_list = array( '-1' => ''); // Collect attachment id and srcs for attachMedia script

        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';


        if ( isset( $wp_customize->selective_refresh ) ) {
            $wp_customize->selective_refresh->add_partial( 'blogname', array(
                'selector'            => '.site-title a',
                'container_inclusive' => false,
                'render_callback'     => function(){ bloginfo( 'name' ); }
            ) );
            $wp_customize->selective_refresh->add_partial( 'blogdescription', array(
                'selector'            => '.site-description',
                'container_inclusive' => false,
                'render_callback'     => function(){ bloginfo( 'description' ); }
            ) );
            $wp_customize->selective_refresh->add_partial( 'custom_logo', array(
                'selector'            => '.aux-logo-header',
                'container_inclusive' => false,
                'render_callback'     => function(){ echo auxin_get_custom_logo_image(); }
            ) );
        }


        // load controls
        locate_template( AUXIN_INC. 'classes/class-auxin-customize-control.php', true, true );

        do_action( 'auxin_customize_before_add_sections', $wp_customize, $this );

        // Add Sections
        // =====================================================================

        foreach ( $this->sections as $panel_id => $sections ) {
            foreach ( $sections as $section ) {

                // Skip if the section is not allowed to be added to customizer
                if( 'option_panel' == $section['add_to'] ){
                    continue;
                }

                if( isset( $section['parent'] ) ){


                    if( (  empty( $section['parent'] ) && empty( $section['type']  )   ) ||
                        ( !empty( $section['type']   ) && 'panel' === $section['type'] )
                        ){

                        // Add Panel
                        // -----------------------------------------------------
                        $wp_customize->add_panel( $section['id'], array(
                            'title'           => $section['title'],
                            'description'     => $section['description'],
                            'priority'        => $section['priority'],
                            'active_callback' => '', // @TODO $section['active_callback']
                            'icon'            => $section['icon'] // Meanwhile this param is not available in customizer
                        ));

                    } else {
                        // Get corresponding section class
                        $section_class = ! empty( $section['type'] ) && ( $section['type'] !== 'section' ) ? $section['type'] : 'Auxin_Customize_Section';

                        $section_options = array(
                            'title'           => $section['title'],
                            'description'     => $section['description'],
                            'preview_link'    => $section['preview_link'],
                            'priority'        => $section['priority'],
                            'active_callback' => '', // @TODO $section['active_callback'],
                            'icon'            => $section['icon'], // Meanwhile this param is not available in customizer
                            'capability'      => 'edit_theme_options',
                            'dependency'      => $section['dependency'],
                            'is_deprecated'   => $section['is_deprecated']
                        );

                        if( ! empty( $section['parent'] ) ){
                            $section_options['panel'] = $section['parent'];
                        }

                        // Special options for "Auxin_Customize_Link_Section" section type
                        if( 'Auxin_Customize_Link_Section' === $section_class ){
                            $section_options['button_label'] = $section['button_label'];
                            $section_options['button_url'  ] = $section['button_url'];
                        }

                        // Add Section
                        // -----------------------------------------------------
                        $wp_customize->add_section( new $section_class( $wp_customize, $section['id'], $section_options ) );

                    }
                }
            }
        }

        do_action( 'auxin_customize_before_add_controls', $wp_customize, $this );

        // Add Fields
        // =====================================================================

        foreach ( $this->fields as $section_id => $fields ) {
            foreach ( $fields as $field_id => $field ) {

                // Skip if the section is not allowed to be added to customizer
                if( isset( $field['add_to'] ) && 'option_panel' == $field['add_to'] ){
                    continue;
                }

                // Skip excluded types
                if( in_array( $field['type'], $this->exclude_types() ) ){
                    continue;
                }


                if( in_array( $field['type'], $this->special_types() )) {
                    $field['category'] = 'special';
                } else {
                    $field['category'] = 'general';
                }

                // Add setting
                // -------------------------------------------------------------

                $this->add_setting( $wp_customize, $field );

                // Controls
                // -------------------------------------------------------------
                $this->add_control( $wp_customize, $field );

                // Partials and placement
                // -------------------------------------------------------------

                $this->add_partial( $wp_customize, $field );

            }
        }

        do_action( 'auxin_customize_after_add_controls', $wp_customize, $this );
    }

    /**
     * Adds a new option/setting to customizer
     *
     * @param object $wp_customize Customizer Manager class
     * @param array  $field        Field options
     */
    protected function add_setting( $wp_customize, $field ){

        // The array of args should be defined and passed directly to "add_setting" method due to "Theme Check" criteria.
        $wp_customize->add_setting( new Auxin_Customize_Setting( $wp_customize, $field['id'], array(
            'capability'           => $field['capability'],
            'category'             => $field['category'],
            'theme_supports'       => $field['theme_supports'], // Rarely needed.
            'default'              => is_array( $field['default'] ) ? '': $field['default'],
            'transport'            => $field['transport'], // refresh or postMessage
            'post_js'              => $field['post_js'],
            'style_callback'       => $field['style_callback'],
            'selectors'            => $field['selectors'],
            'sanitize_callback'    => $field['sanitize_callback'],
            'sanitize_js_callback' => $field['sanitize_js_callback'] // Basically to_json.
            ) ) );

        if ( ! empty( $field['devices'] ) && is_array( $field['devices'] ) ) {
            foreach ( $field['devices'] as $device => $device_args ) {
                $wp_customize->add_setting( new Auxin_Customize_Setting( $wp_customize, $device . '_' . $field['id'], array(
                    'capability'           => $field['capability'],
                    'theme_supports'       => $field['theme_supports'], // Rarely needed.
                    'default'              => $device_args['default'],
                    'transport'            => $field['transport'], // refresh or postMessage
                    'post_js'              => $field['post_js'],
                    'style_callback'       => $field['style_callback'],
                    'selectors'            => $field['selectors'],
                    'sanitize_callback'    => $field['sanitize_callback'],
                    'sanitize_js_callback' => $field['sanitize_js_callback'] // Basically to_json.
                ) ) );
            }
        }

    }

    /**
     * Adds a new partial to customizer
     *
     * @param object $wp_customize Customizer Manager class
     * @param array  $field        Field options
     */
    protected function add_partial( $wp_customize, $field ){

        if( $field['partial']['selector'] && $field['partial']['render_callback'] ){

            $partial_args = array(
                'settings'        => $field['id'],
                'selector'        => $field['partial']['selector'],
                'render_callback' => $field['partial']['render_callback']
            );

            $wp_customize->selective_refresh->add_partial( $field['id'] . '_partial', $partial_args );
        }

    }

    /**
     * Adds a new control to customizer
     *
     * @param object $wp_customize Customizer Manager class
     * @param array  $field        Field options
     */
    protected function add_control( $wp_customize, $field ){

        $control_type_class = 'WP_Customize_Control';

        $control_args = array(
            'settings'         => $field['id'],
            'label'            => $field['title'],
            'type'             => $field['type'],               // type of control (checkbox, textarea, radio, select, dropdown-pages, number, url, tel, email, time, date, )
            'section'          => $field['section'],            // Required, core or custom.
            'priority'         => $field['priority'],           // Within the section.
            'choices'          => $field['choices'],
            'mode'             => $field['mode'],
            'description'      => $field['description'],
            'dependency'       => $field['dependency'],
            'default'          => $field['default'],
            'selectors'        => $field['selectors'],
            'css_placeholder'  => $field['placeholder'],
            'related_controls' => $field['related_controls'],
            'active_callback'  => '',
            'devices'          => $field['devices'],
            'device'           => 'desktop',
            'description_color' => $field['description_color'],
            'title_color'      => $field['title_color'],
            'icon_color'       => $field['icon_color'],
            'margin_top'       => $field['margin_top'],
            'margin_bottom'    => $field['margin_bottom'],
            'separator'        => $field['separator']
        );

        switch ( $field['type'] ) {

            case 'color':
                $control_args['type'] = 'auxin_group_global_colors';
                $control_type_class = 'Auxin_Customize_GlobalColors_Controller';
                break;

            case 'gradient':
                $control_args['type'] = 'auxin_gradient';
                $control_type_class = 'Auxin_Customize_Gradient_Control';
                break;

            case 'slider':
                $control_args['type'] = 'auxin_slider';
                $control_type_class = 'Auxin_Customize_Slider_Control';
                break;

            case 'images':
                $control_args['type']          = 'auxin_media';
                $control_args['mime_type']     = 'image';
                $control_args['limit']         = 9999;
                $control_args['multiple']      = '1';
                $control_args['button_labels'] = array(
                    'add'          => esc_attr__( 'Add Image', 'phlox-pro' ),
                    'change'       => esc_attr__( 'Change Image', 'phlox-pro' ),
                    'submit'       => esc_attr__( 'Submit Image', 'phlox-pro' ),
                    'frame_title'  => esc_attr__( 'Select Image', 'phlox-pro' ),
                    'frame_button' => esc_attr__( 'Choose Image', 'phlox-pro' )
                );
                $control_type_class = 'Auxin_Customize_Media_Control';
                break;

            case 'image':
                $control_args['type']          = 'auxin_media';
                $control_args['mime_type']     = 'image';
                $control_args['limit']         = 1;
                $control_args['multiple']      = '0';
                $control_args['button_labels'] = array(
                    'add'          => esc_attr__( 'Add Image', 'phlox-pro' ),
                    'change'       => esc_attr__( 'Change Image', 'phlox-pro' ),
                    'submit'       => esc_attr__( 'Submit Image', 'phlox-pro' ),
                    'frame_title'  => esc_attr__( 'Select Image', 'phlox-pro' ),
                    'frame_button' => esc_attr__( 'Choose Image', 'phlox-pro' )
                );
                $control_type_class = 'Auxin_Customize_Media_Control';
                break;

            case 'cropped_image':
                $control_args['button_labels'] = array(
                    'select'       => __( 'Select image', 'phlox-pro' ),
                    'change'       => __( 'Change image', 'phlox-pro' ),
                    'remove'       => __( 'Remove', 'phlox-pro' ),
                    'default'      => __( 'Default', 'phlox-pro' ),
                    'placeholder'  => __( 'No image selected', 'phlox-pro' ),
                    'frame_title'  => __( 'Select image', 'phlox-pro' ),
                    'frame_button' => __( 'Choose image', 'phlox-pro' )
                );
                $control_type_class = 'WP_Customize_Cropped_Image_Control';
                break;

            case 'audio':
                $control_args['type']          = 'auxin_media';
                $control_args['mime_type']     = 'audio';
                $control_args['limit']         = 1;
                $control_args['multiple']      = '0';
                $control_args['button_labels'] = array(
                    'add'          => esc_attr__( 'Add Audio', 'phlox-pro' ),
                    'change'       => esc_attr__( 'Change Audio', 'phlox-pro' ),
                    'submit'       => esc_attr__( 'Submit Audio', 'phlox-pro' ),
                    'frame_title'  => esc_attr__( 'Select Audio', 'phlox-pro' ),
                    'frame_button' => esc_attr__( 'Choose Audio', 'phlox-pro' )
                );
                $control_type_class = 'Auxin_Customize_Media_Control';
                break;

            case 'video':
                $control_args['type']          = 'auxin_media';
                $control_args['mime_type']     = 'video';
                $control_args['limit']         = 1;
                $control_args['multiple']      = '0';
                $control_args['button_labels'] = array(
                    'add'          => esc_attr__( 'Add Video', 'phlox-pro' ),
                    'change'       => esc_attr__( 'Change Video', 'phlox-pro' ),
                    'submit'       => esc_attr__( 'Submit Video', 'phlox-pro' ),
                    'frame_title'  => esc_attr__( 'Select Video', 'phlox-pro' ),
                    'frame_button' => esc_attr__( 'Choose Video', 'phlox-pro' )
                );
                $control_type_class = 'Auxin_Customize_Media_Control';
                break;

            case 'switch':
                $control_args['type'] = 'auxin_switch';
                $control_type_class = 'Auxin_Customize_Switch_Control';
                break;

            case 'select':
                $control_args['type'] = 'auxin_select';
                $control_type_class = 'Auxin_Customize_Select_Control';
                break;

            case 'select2':
                $control_args['type'] = 'auxin_select2';
                $control_type_class = 'Auxin_Customize_Select2_Control';
                break;

            case 'select2-multiple':
                $control_args['type'] = 'auxin_select2_multiple';
                $control_type_class = 'Auxin_Customize_Select2_Multiple_Control';
                break;

            case 'select2-post-types':
                $control_args['type'] = 'auxin_select2_multiple';
                $control_type_class = 'Auxin_Customize_Select2_Post_Types_Control';
                break;

            case 'sortable-input':
                $control_args['type'] = 'auxin_sortable_input';
                $control_type_class = 'Auxin_Customize_Sortable_Input_Control';
                break;

            case 'editor':
                $control_args['type'] = 'auxin_editor';
                $control_type_class = 'Auxin_Customize_Editor_Control';
                break;

            case 'textarea':
                $control_args['type'] = 'auxin_textarea';
                $control_type_class = 'Auxin_Customize_Textarea_Control';
                break;


            case 'typography_template_part':
                $control_args['type'] = 'auxin_typo_template_part';
                $control_type_class = 'Auxin_Customize_Typography_Template_Part_Control';
                break;

            case 'global_colors_template_part':
                $control_args['type'] = 'auxin_global_colors_template_part';
                $control_type_class = 'Auxin_Customize_GlobalColors_Template_Part_Control';
                break;

            case 'group_typography':
                $control_args['type'] = 'auxin_group_typography';
                $control_type_class = 'Auxin_Customize_Typography_Controller';
                break;

            case 'group_global_colors':
                $control_args['type'] = 'auxin_group_global_colors';
                $control_type_class = 'Auxin_Customize_GlobalColors_Controller';
                break;

            case 'responsive_slider':
                $control_args['type'] = 'auxin_responsive_slider';
                $control_type_class = 'Auxin_Customize_Responsive_Slider_Controller';
                break;

            case 'responsive_dimensions':
                $control_args['type'] = 'auxin_responsive_dimensions';
                $control_type_class = 'Auxin_Customize_Responsive_Dimensions_Controller';
                break;

            case 'icon':
                $control_args['type'] = 'auxin_icon';
                $control_type_class = 'Auxin_Customize_Icon_Control';
                break;

            case 'text':
                $control_args['type'] = 'auxin_base';
                $control_type_class = 'Auxin_Customize_Input_Control';
                break;

            case 'typography':
                $control_args['type'] = 'auxin_typography';
                $control_type_class = 'Auxin_Customize_Typography_Control';
                break;

            case 'radio-image':
                $control_args['type'] = 'auxin_radio_image';
                $control_type_class = 'Auxin_Customize_Radio_Image_Control';
                break;

            case 'link':
                $control_args['type'] = 'auxin_link';
                $control_type_class = 'Auxin_Customize_Link_Control';
                break;

            case 'import':
                $control_args['type'] = 'auxin_import';
                $control_type_class = 'Auxin_Customize_Import_Control';
                break;

            case 'export':
                $control_args['type'] = 'auxin_export';
                $control_type_class = 'Auxin_Customize_Export_Control';
                break;

            case 'code':
                $control_args['type'] = 'auxin_code';
                $control_args['button_labels'] = $field['button_labels'];
                $control_type_class = 'Auxin_Customize_Code_Control';
                break;

            case 'install_elementor_plugin':
                $control_args['type'] = 'auxin_install_elementor_plugin';
                $control_type_class = 'Auxin_Customize_Install_Elementor_Plugin';
                break;

            case 'selective_list':
                $control_args['type'] = 'auxin_selective_list';
                $control_args['has_link'] = isset( $field['has_link'] ) ? $field['has_link'] : false ;
                $control_type_class = 'Auxin_Customize_Selective_List';
                break;

            case 'edit_template':
                $control_args['type']     = 'auxin_edit_template';
                $control_args['template'] = isset( $field['template'] ) ? $field['template'] : 'header' ;
                $control_type_class = 'Auxin_Elementor_Edit_Template';
                break;
            case 'template_library':
                $control_args['type'] = 'auxin_template_library';
                $control_args['template_type'] = isset( $field['template_type'] ) ? $field['template_type'] : 'header' ;
                $control_type_class = 'Auxin_Customize_Template_Library_Control';
                break;

            case 'info':
                $control_args['type'] = 'auxin_info';
                $control_type_class = 'Auxin_Customize_Info';
                break;
            case 'color_repeater':
                $control_args['type'] = 'auxin_color_repeater';
                $control_type_class = 'Auxin_Customize_Color_Repeater';
                break;

            default:
                $control_args['type'] = 'auxin_base';
                $control_args['input_attrs'] = array('type' => $field['type'] );
                $control_type_class = 'Auxin_Customize_Input_Control';
                break;
        }

        $wp_customize->add_control(
            new $control_type_class( $wp_customize, $field['id'] . '_control', $control_args )
        );

        if ( $control_args['devices'] ) {
            foreach ( $control_args['devices'] as $device => $device_args ) {
                $control_args['devices']  = false;
                $control_args['device']   = $device;
                $control_args['label']    = $device_args['title'];
                $control_args['settings'] = $device . '_' . $field['id'];
                $control_args['default']  = $device_args['default'];
                $wp_customize->add_control(
                    new $control_type_class( $wp_customize, $device . '_' . $field['id'] . '_control', $control_args )
                );
            }
        }

    }

}
