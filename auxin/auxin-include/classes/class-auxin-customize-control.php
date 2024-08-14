<?php
/**
 * Auxin Customize Control Class
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/


/**
 * Customize Base Control class.
 */
class Auxin_Customize_Control extends WP_Customize_Control {

    // The control dependencies
    protected $dependency = array();
    public $devices;
    public $device;
    public $css_placeholder;
    public $related_controls;

    public $margin_top = 0;
    public $margin_bottom = 0;
    public $separator  = 0;


    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );

        if( isset( $this->dependency['relation'] ) ){
            $this->dependency[] = array( 'relation' => $this->dependency['relation'] );
            unset( $this->dependency['relation'] );
        } elseif ( is_array( $this->dependency ) ){
            $this->dependency[] = array( 'relation' => 'and' );
        }

        $this->margin_top = ! empty( $args['margin_top'] ) ? $args['margin_top'] : 0;
        $this->margin_bottom = ! empty( $args['margin_bottom'] ) ? $args['margin_bottom'] : 0;

        $this->separator  = in_array( $args['separator'], ['top', 'bottom', 'both', 'none']) ? $args['separator'] : 'bottom';

        add_action( 'customize_preview_init' , array( $this, 'preview_script' ) );
    }


    /**
     * Adds javascript for preview on changes for each control
     */
    public function preview_script(){
        wp_enqueue_script( 'customize-preview' );

        ob_start();
        ?>
        // will trigger on changes for all controls
        ;( function( $ ) {
            wp.customize( '<?php echo esc_js( $this->setting->id ); ?>', function( value ) {
                value.bind( function( to ) {
                    $(window).trigger('resize');
                });
            });
        } )( jQuery );
        <?php
        $js = ob_get_clean();

        wp_add_inline_script( 'customize-preview', $js, 'after' );
    }


    /**
     * Enqueue scripts/styles for the color picker.
     */
    public function enqueue() {
        wp_enqueue_script('wp-util');
        wp_enqueue_script('auxin_plugins');
        wp_enqueue_script('auxin_script');
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();

        $field_dependencies = array();

        if( ! empty( $this->dependency ) ){
            $dependencies = (array) $this->dependency;

            foreach ( $dependencies as $target_id => $target ) {

                if( 'relation' === $target_id ) {
                    continue;
                }

                if( empty( $target['id'] ) || ! ( isset( $target['value'] ) && ! empty( $target['value'] ) ) ){ continue; }

                // make sure there is no duplication in values array
                if( is_array( $target['value'] ) ){
                    $target['value'] = array_unique( $target['value'] );
                }

                // if the operator was not defined or was defined as '=' by mistake
                $target['operator'] = ! empty( $target['operator'] ) && ( '=' !== $target['operator'] )  ? $target['operator'] : '==';

                $target['id'] = $target['id'] . '_control';
                $field_dependencies[ $target_id ] = $target;
            }

            $field_dependencies[ $target_id ] = $target;
        }

        $this->json['dependencies']   = $field_dependencies;
        $this->json['relatedControls'] = $this->related_controls;
    }


    protected function _control_wrapper_open_tag( $attrs = [] ){
        $attrs['class']  = isset( $attrs['class'] ) ? $attrs['class'] : '';
        $attrs['class']  = 'customizer-control-auxin-wrapper ' . $attrs['class'];

        $attrs['style']  = isset( $attrs['style'] ) ? $attrs['style'] : '';
        $attrs['style']  = ! empty( $this->margin_top    ) ? 'margin-top:'. esc_attr( trim( $this->margin_top, 'px' ) ). 'px;' : '';
        $attrs['style'] .= ! empty( $this->margin_bottom ) ? 'margin-bottom:'. esc_attr( trim( $this->margin_bottom, 'px' ) ). 'px;' : '';

        printf( '<div %s>', auxin_make_html_attributes( $attrs ) );
    }

    protected function _control_wrapper_close_tag(){
        echo '</div>';
    }


    protected function control_wrapper_open( $attrs = [] ){
        $this->top_separator();
        $this->_control_wrapper_open_tag( $attrs );
    }

    protected function control_wrapper_close(){
        $this->_control_wrapper_close_tag();
        $this->bottom_separator();
    }


    protected function top_separator(){
        if( in_array( $this->separator, ['top', 'both'] ) ){
            echo '<hr>';
        }
    }

    protected function bottom_separator(){
        if( in_array( $this->separator, ['bottom', 'both'] ) ){
            echo '<hr>';
        }
    }

}


class Auxin_Customize_Code_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_code';

    public $mode = 'javascript';

    public $button_labels = array();



    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );

        $this->button_labels = wp_parse_args( $this->button_labels, array(
            'description'  => __( 'The description', 'phlox-pro' ),
            'label'        => __( 'Submit', 'phlox-pro' )
        ));

        add_action( 'customize_preview_init' , array( $this, 'custom_script' ) );
    }

    public function custom_script(){
        if( 'javascript' !== $this->mode ){
            return;
        }

        wp_enqueue_script( 'customize-preview' );

        ob_start();
        ?>
        /**
         * Note: This the only solution that we found in order to use customizer API to create live custom JS editor
         * This section only executes in customizer preview, not in admin or front end side
         */
        ;( function( $ ) {

            wp.customize( '<?php echo esc_js( $this->setting->id ); ?>', function( value ) {
                value.bind( function( to ) {
                    var $body  = $( 'body' ),
                    dom_id = '<?php echo esc_js( $this->setting->id ); ?>_script';
                    $body.find( '#' + dom_id ).remove();
                    $body.append( '<' + 'script id=\"'+ dom_id +'\" >try{ ' + to + ' } catch(ex) { console.error( "Custom JS:", ex.message ); }</script' + '>' ).find( '#' + dom_id );
                });
            });

        } )( jQuery );
        <?php
        $js = ob_get_clean();

        wp_add_inline_script( 'customize-preview', $js, 'after' );
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
            // editoe mode
            $editor_mode = ! empty( $this->mode ) ? $this->mode : 'javascript';
            $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>

            <textarea id="<?php echo esc_attr( $this->setting->id ); ?>" class="code_editor" rows="5" <?php $this->link(); ?> placeholder="<?php esc_attr( $this->setting->default ); ?>"
            data-code-editor="<?php echo esc_attr( $editor_mode ); ?>" ><?php echo stripslashes( $this->value() ); ?></textarea>

            <?php if( 'javascript' == $this->mode && $this->button_labels['label'] ){ ?>
            <button class="<?php echo esc_attr( $this->setting->id ); ?>-submit button button-primary"><?php echo esc_html( $this->button_labels['label'] ); ?></button>
            <?php } ?>
        </label>
        <hr />
    <?php
    }
}


/**
 * Customize Typography Control class.
 */
class Auxin_Customize_Typography_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_typography';




     public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );

        add_action( 'customize_preview_init' , array( $this, 'live_google_font_loading_script' ) );
    }


    /**
     * Adds javascript for preview on changes for each control
     */
    public function live_google_font_loading_script(){
        wp_enqueue_script( 'customize-preview' );

        ob_start();
        ?>
        /**
         * Note: This section just preloads the google fonts for preview in customizer typography controls
         *       It does not load the fonts in front end or admin area
         */
        ;( function( $ ) {
            wp.customize( '<?php echo esc_js( $this->setting->id ); ?>', function( value ) {
                value.bind( function( to ) {
                    var components = to.match("_gof_(.*):");
                    if( components && components.length > 1 ){
                        var face = components[1];
                        face = face.split(' ').join('+'); // convert spaces to "+" char

                        var google_font_url = '//fonts.googleapis.com/css?family='+ face +
                                              ':400,900italic,900,800italic,800,700italic,700,600italic,600,500italic,500,400italic,300italic,300,200italic,200,100italic,100';

                        var $body  = $( 'body' ),
                        dom_id = '<?php echo esc_js( $this->setting->id ); ?>_font';
                        $body.find( '#' + dom_id ).remove();
                        $body.append( '<link rel=\"stylesheet\" id=\"' + dom_id + '\" href=\"' + google_font_url + '\" type=\"text/css\" />' );
                    }
                });
            });
        } )( jQuery );
        <?php
        $js = ob_get_clean();

        wp_add_inline_script( 'customize-preview', $js, 'after' );
    }


    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
    ?>
        <label>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif;


            $fields_output     = '';

            // Font face and thickness

            // Get default value for font info
            if( ! $typo_info = auxin_get_option( $this->id ) ){ // get stored value if available
                 // otherwise use default value
                $typo_info = isset( $this->default ) ? $this->default : '';
            }

            // temporary fix for compatibility with old stored data. will deprecated in 1.3
            if( isset( $typo_info['font'] ) ){
                $typo_info = $typo_info['font'];
            }

            $fields_output .= '<div class="typo_fields_wrapper typo_font_wrapper" >';
            $fields_output .= '<input type="text" class="axi-font-field" name="'.esc_attr( $this->id ).'" id="'. esc_attr( $this->id ).'" ' . $this->get_link() . ' value="'.esc_attr( $typo_info ).'"  />';
            $fields_output .= '</div>';

            $fields_output .= "</label><hr />";

        echo $fields_output;
    }

}


/**
 * Customize Radio_Image Control class.
 */
class Auxin_Customize_Radio_Image_Control extends Auxin_Customize_Control {

    /**
     * Control type
     *
     * @var string
     */
    public $type = 'auxin_radio_image';

    /**
     * Control Presets
     *
     * @var array
     */
    public $presets = array();

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>

            <select class="visual-select-wrapper" <?php $this->link(); ?>>
                <?php
                $presets = array();

                foreach ( $this->choices as $choice_id => $choice_info ){

                    $data_class  = isset( $choice_info['css_class'] ) && ! empty( $choice_info['css_class'] ) ? 'data-class="'. esc_attr( $choice_info['css_class'] ).'"' : '';
                    $data_symbol = ! empty( $choice_info['image'] ) ? 'data-symbol="'. esc_attr( $choice_info['image'] ).'"' : '';
                    $data_video  = ! empty( $choice_info['video_src'] ) ? 'data-video-src="'. esc_attr( $choice_info['video_src'] ).'"' : '';

                    if( isset( $choice_info['presets'] ) && ! empty( $choice_info['presets'] ) ){
                        $presets[ $choice_id ] = $choice_info['presets'];
                    }

                    echo sprintf( '<option value="%s" %s %s %s %s>%s</option>', esc_attr( $choice_id ),
                        selected( $this->value(), $choice_id, false ) ,
                        $data_symbol, $data_video, $data_class, esc_html( $choice_info['label'] )
                    );
                }

                // Define the presets if was defined
                if( ! empty( $presets ) ){
                    $this->presets = $presets;
                }
                ?>
            </select>
        </label>
        <hr />
    <?php
    }


    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();

        $this->json['presets'] = $this->presets;
    }

}

/**
 * Customize Template Control class.
 */
class Auxin_Customize_Template_Library_Control extends Auxin_Customize_Radio_Image_Control {

    /**
     * Control type
     *
     * @var string
     */
    public $type = 'auxin_template_library';

    /**
     * Template type
     *
     * @var string
     */
    public $template_type = 'section';


    public function render_content() {

        if ( ! class_exists('Auxin_Demo_Importer') || ! class_exists('Auxin_Welcome') ) {
            return;
        }

        $this->choices = array();

        $templates_data = Auxin_Welcome::get_instance()->get_demo_list('templates');

        if ( empty( $templates_data ) ) {
            return ;
        }

        foreach ( $templates_data['templates'] as $template_info ) {
            if ( $template_info['type'] === $this->template_type ) {
                if ( auxin_is_activated() ) {
                    $this->choices[ $template_info['id'] ] = [
                        'label' => $template_info['title'],
                        'image' => $template_info['thumbnail']
                    ];
                } else {
                    if ( ! $template_info['is_pro'] ){
                        $this->choices[ $template_info['id'] ] = [
                            'label' => $template_info['title'],
                            'image' => $template_info['thumbnail']
                        ];
                    }
                }
            }
        }

        echo "<div class='aux-template-container aux-template-type' data-template-type='". esc_attr( $this->template_type )."'>";
        wp_nonce_field( 'customizer-template-library-' .  $this->template_type, '_' . $this->template_type . '_template_library_nonce');
        parent::render_content();
        echo "</div>";
    }
}

/**
 * Customize Icon Control class.
 */
class Auxin_Customize_Icon_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_icon';


    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $font_icons = Auxin()->Font_Icons->get_icons_list( 'fontastic' );
        $font_icons_set2 = Auxin()->Font_Icons->get_icons_list( 'auxicon2' );
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>

            <select <?php $this->link(); ?> class="meta-select aux-fonticonpicker">
                <?php
                echo '<option value="">' . __('Choose ..', 'phlox-pro') . '</option>';

                if( is_array( $font_icons ) ){
                    foreach ( $font_icons as $icon ) {
                        $icon_id = trim( $icon->classname, '.' );
                        echo '<option value="'. esc_attr( $icon_id ) .'" '. selected( $this->value(), $icon_id, false ) .' >'. esc_html( $icon->name ) . '</option>';
                    }
                }
                if( is_array( $font_icons_set2 ) ){
                    foreach ( $font_icons_set2 as $icon ) {
                        $icon_id = trim( $icon->classname, '.' );
                        echo '<option value="'. esc_attr( $icon_id ) .'" '. selected( $this->value(), $icon_id, false ) .' >'. esc_html( $icon->name ) . '</option>';
                    }
                }
                ?>
            </select>
        </label>
        <hr />
    <?php
    }
}


/**
 * Customize Textarea Control class.
 */
class Auxin_Customize_Textarea_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_textarea';

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>
            <textarea rows="5" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
        </label>

        <hr />
    <?php
    }
}

/**
 * Customize Editor Control class.
 */
class Auxin_Customize_Editor_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_editor';

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>

            <?php wp_editor( stripslashes( $this->value() ), $this->id, array( 'media_buttons' => false ) ); ?>
        </label>
        <hr />
    <?php
    }
}


/**
 * Customize Select2 Multiple Control class.
 */
class Auxin_Customize_Select2_Multiple_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_select2_multiple';



    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>

            <select class="aux-orig-select2 aux-admin-select2 aux-select2-multiple" multiple="multiple" <?php $this->link(); ?>>
                <?php
                foreach ( $this->choices as $value => $label ) {
                    $selected = in_array( $value, $this->value() ) ? 'selected' : '';
                    echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' .esc_html( $label ) . '</option>';
                }
                ?>
            </select>
        </label>
        <hr />
    <?php
    }
}

/**
 * Customize import options Control class.
 */
class Auxin_Customize_Import_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_import';



    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>
        </label>
        <form class="auxin-import-export-form" <?php echo $data_device; ?>>
            <input type="file" id="auxin-select-import" accept=".txt">
            <?php wp_nonce_field( 'auxin-import-control', 'auxin-import-nonce' ); ?>
            <button class="button button-primary button-hero" id="auxin-import-data" type="submit"> <span><?php esc_html_e('Submit', 'phlox-pro'); ?></span></button>
        </form>
        <hr />
    <?php
    }
}

/**
 * Customize export options Control class.
 */
class Auxin_Customize_Export_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_export';


    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>
        </label>
        <form class="auxin-import-export-form" <?php echo $data_device; ?>>
            <?php wp_nonce_field( 'auxin-export-control', 'auxin-export-nonce' ); ?>
            <button class="button button-primary button-hero" id="auxin-export-data" type="submit"> <span><?php esc_html_e('Submit', 'phlox-pro'); ?></span></button>
        </form>
        <hr />
    <?php
    }
}


/**
 *
 */
class Auxin_Customize_Select2_Post_Types_Control extends Auxin_Customize_Control {

    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_select2_multiple_post_types';


    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {

        $this->choices = get_post_types( array( 'public' => true, 'exclude_from_search' => false ) );
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>

            <select class="aux-orig-select2 aux-admin-select2 aux-select2-multiple" multiple="multiple" style="width: 100%" <?php $this->link(); ?>>
                <?php
                foreach ( $this->choices as $value )
                    echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' .esc_html( $value ) . '</option>';
                ?>
            </select>
        </label>
        <hr />
    <?php
    }

}

/**
 * Customize Select2 Control class.
 */
class Auxin_Customize_Select2_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_select2';


    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>

            <select class="aux-orig-select2 aux-admin-select2 aux-select2-single" <?php $this->link(); ?>>
                <?php
                foreach ( $this->choices as $value => $label )
                    echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' .esc_html( $label ) . '</option>';
                ?>
            </select>
        </label>
        <hr />
    <?php
    }
}


/**
 * Customize Select Control class.
 */
class Auxin_Customize_Select_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_select';


    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>

            <select <?php $this->link(); ?>>
                <?php
                foreach ( $this->choices as $value => $label )
                    echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' .esc_html( $label ) . '</option>';
                ?>
            </select>
        </label>
        <hr />
    <?php
    }
}



/**
 * Customize Media Control class.
 */
class Auxin_Customize_Media_Control extends Auxin_Customize_Control {

    /**
     * Control type
     */
    public $type = 'auxin_media';

    /**
     * Media control mime type.
     */
    public $mime_type = 'image';

    /**
     * Max number of attachments
     */
    public $limit = 9999;

    /**
     * Allow multiple uploads
     */
    public $multiple = true;

    /**
     * Button labels.
     *
     * @var array
     */
    public $button_labels = array();


    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        parent::__construct( $manager, $id, $args );

        $this->button_labels = wp_parse_args( $this->button_labels, array(
            'add'          => esc_attr__( 'Add File', 'phlox-pro' ),
            'change'       => esc_attr__( 'Change File', 'phlox-pro' ),
            'submit'       => esc_attr__( 'Select File', 'phlox-pro' ),
            'remove'       => esc_attr__( 'Remove', 'phlox-pro' ),
            'frame_title'  => esc_attr__( 'Select File', 'phlox-pro' ),
            'frame_button' => esc_attr__( 'Choose File', 'phlox-pro' )
        ));

    }


    /**
     * Enqueue control related scripts/styles.
     *
     */
    public function enqueue() {
        wp_enqueue_media();
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     *
     * @since 3.4.0
     */
    public function to_json() {
        parent::to_json();

        $this->json['settings'] = array();
        foreach ( $this->settings as $key => $setting ) {
            $this->json['settings'][ $key ] = $setting->id;
        }

        $value = $this->value();

        $this->json['type']           = $this->type;
        $this->json['priority']       = $this->priority;
        $this->json['active']         = $this->active();
        $this->json['section']        = $this->section;
        $this->json['content']        = $this->get_content();
        $this->json['label']          = $this->label;
        $this->json['description']    = $this->description;
        $this->json['instanceNumber'] = $this->instance_number;

        $this->json['mime_type']      = $this->mime_type;
        $this->json['button_labels']  = $this->button_labels;

        $this->json['canUpload']      = current_user_can( 'upload_files' );
        $this->json['value']          = $value;
        $this->json['attachments']    = array('-4' => '' );

        if ( $value ) {
            if( $att_ids = explode( ',', $value ) ){
                $this->json['attachments'] += auxin_get_the_resized_attachment_src( (array) $att_ids, 80, 80, true );
            }
        }

    }


    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
        <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>

            <div class="axi-attachmedia-wrapper" >

                <input type="text" class="white" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?>
                                   data-media-type="<?php echo esc_attr( $this->mime_type ); ?>" data-limit="<?php echo esc_attr( $this->limit ); ?>" data-multiple="<?php echo esc_attr( $this->multiple ); ?>"
                                   data-add-to-list="<?php echo esc_attr( $this->button_labels['add'] ); ?>"
                                   data-uploader-submit="<?php echo esc_attr( $this->button_labels['submit'] ); ?>"
                                   data-uploader-title="<?php echo esc_attr( $this->button_labels['frame_title'] ); ?>"
                                   />
            <?php
                // Store attachment src for avertaAttachMedia field
                if( $att_ids = explode( ',', $this->value() ) ){
                    $this->manager->attach_ids_list += auxin_get_the_resized_attachment_src( $att_ids, 80, 80, true );
                }
            ?>
            </div>

        </label>
        <hr />
    <?php
    }
}


/**
 * Customize Switch Control class.
 */
class Auxin_Customize_Switch_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_switch';


    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
    ?>
        <label <?php echo $data_device; ?>>
        <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>
            <input type="checkbox" class="aux_switch" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?> />

        </label>
        <hr />
    <?php
    }
}


/**
 * Customize Color Control class.
 */
class Auxin_Customize_Color_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_color';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
        ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>
            <div class="mini-color-wrapper">
                <input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
            </div>
        </label>
        <hr />
        <?php
    }
}

/**
 * Customize Color Control class.
 */
class Auxin_Customize_Gradient_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_gradient';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';
        ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>
            <div class="mini-gradient-wrapper">
                <div class="aux-grapick">
                  <div class="aux-grapick-colors"></div>
                  <div class="aux-grapick-inputs">
                    <select class="aux-gradient-type">
                      <option value="">- Select Type -</option>
                      <option value="radial">Radial</option>
                      <option value="linear" selected>Linear</option>
                      <option value="repeating-radial">Repeating Radial</option>
                      <option value="repeating-linear">Repeating Linear</option>
                    </select>
                    <select class="aux-gradient-direction">
                      <option value="">- Select Direction -</option>
                      <option value="top">Top</option>
                      <option value="right" selected>Right</option>
                      <option value="center">Center</option>
                      <option value="bottom">Bottom</option>
                      <option value="left">Left</option>
                    </select>
                  </div>
                </div>
                <input type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
            </div>
        </label>
        <hr />
        <?php
    }
}

/**
 * Customize Sortable_Input Control class.
 */
class Auxin_Customize_Sortable_Input_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'aux_sortable_input';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $list_items = array();

        if( ! empty( $this->choices ) ){
            foreach( $this->choices as $_node_id => $_node_label ){
                $list_items[] = array( 'id' => $_node_id, 'label' => $_node_label );
            }
        }

        $list_items = wp_json_encode( $list_items );
        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';

        ?>
        <label <?php echo $data_device; ?>>
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif;
            if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>
            <div class="aux-sortin-container">
                <input type="text" class="aux-sortable-input" value="<?php echo esc_attr( wp_specialchars_decode( $this->value() ) ); ?>" <?php $this->link(); ?> data-fields="<?php echo esc_attr( wp_specialchars_decode( $list_items ) ); ?>" />
            </div>
        </label>
        <hr />
        <?php
    }
}


/**
 * Customize Base Control class.
 */
class Auxin_Customize_Input_Control extends Auxin_Customize_Control {
    /**
     *
     */
    public $type = 'auxin_base';

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $real_type  = $this->type;

        if( isset( $this->input_attrs['type'] ) ){
            $this->type = $this->input_attrs['type'];
        }

        parent::render_content();

        $this->type = $real_type;
        echo "<hr />";
    }
}




/**
 * Customize Typography Template Part Control class.
 */
class Auxin_Customize_Typography_Template_Part_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_typo_template_part';

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
    ?>
    <div id="aux-typo-controller-template" class="aux-control aux-controller-template"  data-remove-defaults="true" data-selector="inherit">
        <label for=""><?php _e( 'Family', 'phlox-pro' );?></label>
        <div class="aux-control" data-type="font" data-name="font-family" data-default="none| " data-target="#customize-preview iframe">
            <div class="aux-loading">LOADING...</div>
        </div>

        <div class="aux-control" data-type="GlobalColorPicker" data-name="color" data-selector="inherit" data-default="">
            <div class="aux-control" data-type="color" data-name="color" data-default="">
                <input type="text" />
            </div>
            <div class="aux-control" data-type="popover" data-template="aux-global-colors-controller-template" data-name="popover" data-container=".wp-full-overlay-sidebar-content" >
                <button></button>
            </div>
        </div>

        <div class="aux-control" data-type="responsive" data-name="font-size-resp">
            <label class="aux-control-resp-label" for=""><?php _e( 'Size', 'phlox-pro' );?></label>
            <ul class="aux-devices" data-default="desktop">
                <li class="aux-option-item" data-value="desktop" data-device="desktop"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-desktop.svg' ); ?>"></li>
                <li class="aux-option-item" data-value="1024" data-device="tablet"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-tablet.svg' ); ?>"></li>
                <li class="aux-option-item" data-value="768" data-device="mobile"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-mobile.svg' ); ?>"></li>
            </ul>
            <div class="aux-control aux-control-has-unit" data-type="slider" data-default="" data-name="font-size">
                <ul class="aux-units" data-default="px">
                    <li class="aux-option-item" data-value="px">PX</li>
                    <li class="aux-option-item" data-value="em">EM</li>
                    <li class="aux-option-item" data-value="rem">REM</li>
                </ul>
                <input type="number" min="1" max="200" step="1">
            </div>
        </div>

        <label for=""><?php _e( 'Weight', 'phlox-pro' );?></label>
        <div class="aux-control aux-simple-select" data-type="select" data-name="font-weight"
            data-default="">
            <select>
                <option value=""><?php _e( 'Default', 'phlox-pro' );?></option>
                <option value="300">300</option>
                <option value="400">400</option>
                <option value="500">500</option>
                <option value="600">600</option>
                <option value="700">700</option>
                <option value="800">800</option>
                <option value="900">900</option>
                <option value="normal"><?php _e( 'Normal', 'phlox-pro' );?></option>
                <option value="bold"><?php _e( 'Bold', 'phlox-pro' );?></option>
            </select>
        </div>

        <label for=""><?php _e( 'Transform', 'phlox-pro' );?></label>
        <div class="aux-control aux-simple-select" data-type="select" data-name="text-transform"
            data-default="">
            <select>
                <option value=""><?php _e( 'Default', 'phlox-pro' );?></option>
                <option value="uppercase"><?php _e( 'Uppercase', 'phlox-pro' );?></option>
                <option value="lowercase"><?php _e( 'Lowercase', 'phlox-pro' );?></option>
                <option value="capitalize"><?php _e( 'Capitalize', 'phlox-pro' );?></option>
                <option value="none"><?php _e( 'Normal', 'phlox-pro' );?></option>
            </select>
        </div>

        <label for=""><?php _e( 'Style', 'phlox-pro' );?></label>
        <div class="aux-control aux-simple-select" data-type="select" data-name="font-style"
            data-default="">
            <select>
                <option value=""><?php _e( 'Default', 'phlox-pro' );?></option>
                <option value="normal"><?php _e( 'Normal', 'phlox-pro' );?></option>
                <option value="italic"><?php _e( 'Italic', 'phlox-pro' );?></option>
                <option value="oblique"><?php _e( 'Oblique', 'phlox-pro' );?></option>
            </select>
        </div>

        <label for=""><?php _e( 'Decoration', 'phlox-pro' );?></label>
        <div class="aux-control aux-simple-select" data-type="select" data-name="text-decoration"
            data-default="">
            <select>
                <option value=""><?php _e( 'Default', 'phlox-pro' );?></option>
                <option value="underline"><?php _e( 'Underline', 'phlox-pro' );?></option>
                <option value="overline"><?php _e( 'Overline', 'phlox-pro' );?></option>
                <option value="line-through"><?php _e( 'Line Through', 'phlox-pro' );?></option>
                <option value="none"><?php _e( 'None', 'phlox-pro' );?></option>
            </select>
        </div>

        <div class="aux-control" data-type="responsive" data-name="line-height-resp">
            <label class="aux-control-resp-label" for=""><?php _e( 'Line Height', 'phlox-pro' );?></label>
            <ul class="aux-devices" data-default="desktop">
                <li class="aux-option-item" data-value="desktop" data-device="desktop"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-desktop.svg' ); ?>"></li>
                <li class="aux-option-item" data-value="1024" data-device="tablet"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-tablet.svg' ); ?>"></li>
                <li class="aux-option-item" data-value="768" data-device="mobile"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-mobile.svg' ); ?>"></li>
            </ul>
            <div class="aux-control aux-control-has-unit" data-type="slider" data-default="" data-name="line-height">
                <ul class="aux-units" data-default="px">
                    <li class="aux-option-item" data-value="px">PX</li>
                    <li class="aux-option-item" data-value="em">EM</li>
                    <li class="aux-option-item" data-value="rem">REM</li>
                </ul>
                <input type="number" min="1" max="100" step="1">
            </div>
        </div>

        <div class="aux-control" data-type="responsive" data-name="letter-spacing-resp">
            <label class="aux-control-resp-label" for=""><?php _e( 'Letter Spacing', 'phlox-pro' );?></label>
            <ul class="aux-devices" data-default="desktop">
                <li class="aux-option-item" data-value="desktop" data-device="desktop"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-desktop.svg' ); ?>"></li>
                <li class="aux-option-item" data-value="1024" data-device="tablet"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-tablet.svg' ); ?>"></li>
                <li class="aux-option-item" data-value="768" data-device="mobile"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-mobile.svg' ); ?>"></li>
            </ul>
            <div class="aux-control aux-control-has-unit" data-type="slider" data-default="" data-name="letter-spacing">
                <ul class="aux-units" data-default="px">
                    <li class="aux-option-item" data-value="px">PX</li>
                    <li class="aux-option-item" data-value="em">EM</li>
                    <li class="aux-option-item" data-value="rem">REM</li>
                </ul>
                <input type="number" min="-5" max="10" step="0.1">
            </div>
        </div>

    </div>

    <?php
    }
}

/**
 * Customize Global Colors Template Part Control class.
 */
class Auxin_Customize_GlobalColors_Template_Part_Control extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_global_colors_template_part';

    /**
     * @access public
     * @var array
     */
    public $global_colors = [];

    /**
     * @access public
     * @var string
     */
    public $edit_link = '';

    /**
     * @access public
     * @var string
     */
    public $edit_title = '';

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.
     */
    public function render_content() {
        $this->set_global_colors();
    ?>
    <div id="aux-global-colors-controller-template" class="aux-control aux-controller-template"  data-remove-defaults="true" data-selector="inherit">
        <div class="aux-global-colors-header">
            <span><?php _e( 'GLOBAL COLORS', 'phlox-pro' );?></span>
            <a href="<?php echo esc_url( $this->edit_link );?>" target="_blank"><?php echo esc_html( $this->edit_title );?></a>
        </div>
        <div class="aux-global-colors-divider"></div>
        <ul class="aux-colors aux-control" data-type="choose" data-name="variable">
            <?php
                $this->get_global_colors_markup();
            ?>
        </ul>
    </div>

    <?php
    }

    /**
     * Get global colors from elementor plugin
     *
     * @return void
     */
    public function set_global_colors() {
        $active_kit_ID = get_option( 'elementor_active_kit');
        $init_warning = __('Please set global colors in elementor', 'phlox-pro' );

        if ( ! defined( 'ELEMENTOR_VERSION' ) || empty( $active_kit_ID ) ) {
            $this->edit_title = __( 'Install Elementor', 'phlox-pro' );
            $this->edit_link = admin_url( 'plugins.php' );
            $this->global_colors = ['aux' => [ 'color' => '', 'title' => $init_warning ] ];
            return;
        }

        $elementor_page_settings = maybe_unserialize( get_post_meta( $active_kit_ID, '_elementor_page_settings', true ) );

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

        $system_colors = ! empty( $elementor_page_settings['system_colors'] ) ? $elementor_page_settings['system_colors'] : $default_colors;
        // elementor global system colors
        foreach( $system_colors as $color ) {
            $global_colors[ $color['_id'] ]['color'] = $color['color'];
            $global_colors[ $color['_id'] ]['title'] = $color['title'];
        }

        // elementor global custom colors
        if ( ! empty( $elementor_page_settings['custom_colors'] ) ) {
            foreach( $elementor_page_settings['custom_colors'] as $key => $color ) {
                $global_colors[ $color['_id'] ]['color'] = $color['color'];
                $global_colors[ $color['_id'] ]['title'] = $color['title'];
            }
        }

        $this->edit_title = empty( $global_colors ) ? __( 'Setup Global Colors', 'phlox-pro' ) : __( 'Edit', 'phlox-pro' );
        $this->edit_link = admin_url( 'edit.php?post_type=elementor_library&tabs_group=library' );
        $this->global_colors = !empty( $global_colors ) ? $global_colors : ['aux' => [ 'color' => '', 'title' => $init_warning ] ];
    }

    /**
     * Print Global Colors markup
     */
    public function get_global_colors_markup() {

        foreach ( $this->global_colors as $color_ID => $color ) {
            ?>
            <li class="aux-option-item" data-value="var(--e-global-color-<?php echo esc_attr( $color_ID ) . ')'; ?>" data-color="<?php echo esc_attr( $color['color'] ); ?>">
                <div class="aux-color" style="background-color: <?php echo esc_attr( $color['color'] ); ?>"></div>
                <span class="aux-color-label"><?php echo esc_html( $color['title'] );?></span>
                <span class="aux-color-hex"><?php echo esc_html( $color['color'] );?></span>
            </li>
            <?php
        }
    }
}

/**
 * Customize Typography Control class.
 */
class Auxin_Customize_Typography_Controller extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_group_typography';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.f
     */
    public function render_content() {?>
        <div class="aux-typo-controller aux-controller-wrapper">
            <div class="aux-control aux-typo-controller-container aux-controller-btn-wrapper aux-container-has-hover" data-type="container" data-selector="<?php echo esc_attr( $this->setting->selectors ) ;?>">
                <div class="aux-control" data-type="hover" data-name="typography-hover">
                    <ul class="aux-states" data-default="normal">
                        <li class="aux-option-item" data-value="normal">Normal</li>
                        <li class="aux-option-item" data-value="hover">Hover</li>
                    </ul>
                    <span class="aux-controller-label"><?php echo esc_html( $this->label ); ?></span>
                    <div class="aux-control" data-type="popover" data-template="aux-typo-controller-template" data-name="typography" data-container=".wp-full-overlay-sidebar-content">
                        <button class="aux-controller-btn"><span class="dashicons dashicons-edit"></span></button>
                    </div>
                <button class="aux-reset"><i class="auxicon-reload"></i></button>
                </div>
            </div>
            <input type="text" class="aux-controller-input aux-typo-controller-input" data-is-json="true" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />

            <span class="description customize-control-description aux-controller-description"><?php echo auxin_kses( $this->description ); ?></span>
        </div>
        <hr />

    <?php }
}

/**
 * Customize Global Colors Control class.
 */
class Auxin_Customize_GlobalColors_Controller extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_group_global_colors';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
        $this->json['value'] = $this->value();
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.f
     */
    public function render_content() {
        $selector = $this->setting->selectors;
        $placeholder = $this->css_placeholder;

        if ( is_array($selector) ) {

            foreach( $selector as $current_selector => $current_placeholder) {
                $selector = $current_selector;
                $placeholder = $current_placeholder;
            }
        }

        $style_template = !empty($placeholder) ? 'data-style-template="' . esc_attr($placeholder) . '"' : '';
        ?>
        <div class="aux-global-colors-controller aux-controller-wrapper">
            <div class="aux-control aux-global-colors-controller-container aux-controller-btn-wrapper" data-type="container" data-selector="<?php echo esc_attr( $selector ) ;?>">
                <span class="aux-controller-label"><?php echo esc_html( $this->label ); ?></span>
                <div class="aux-control" data-type="GlobalColorPicker" data-name="color" data-selector="inherit" <?php echo $style_template ;?>>
                    <div class="aux-control" data-type="color" data-name="color" data-default="">
                        <input type="text" />
                    </div>
                    <div class="aux-control" data-type="popover" data-template="aux-global-colors-controller-template" data-name="popover" data-container=".wp-full-overlay-sidebar-content" >
                        <button></button>
                    </div>
                </div>
                <input type="text" class="aux-controller-input aux-global-colors-controller-json-input" data-is-json="true" value="<?php echo esc_attr( wp_json_encode( array( 'color' => $this->value() ) ) ); ?>" />
            </div>
            <input type="text" class="aux-controller-input aux-global-colors-controller-input" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
            <span class="description customize-control-description aux-controller-description"><?php echo auxin_kses( $this->description ); ?></span>
        </div>
        <hr />
    <?php }
}


/**
 * Customize Responsive Slider Control class.
 */
class Auxin_Customize_Responsive_Slider_Controller extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_responsive_slider';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.f
     */
    public function render_content() {?>

        <div class="aux-slider-controller aux-controller-wrapper">

            <div class="aux-control aux-controller-container aux-slider-controller-container" data-type="container" data-selector="<?php echo esc_attr( $this->setting->selectors ) ;?>">
                <div class="aux-control" data-type="responsive" data-name="responsive-slider">
                    <label class="aux-control-resp-label" for=""><?php echo esc_html( $this->label ); ?></label>
                    <ul class="aux-devices" data-default="desktop">
                        <li class="aux-option-item" data-value="desktop" data-device="desktop"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-desktop.svg' ); ?>"></li>
                        <li class="aux-option-item" data-value="1024" data-device="tablet"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-tablet.svg' ); ?>"></li>
                        <li class="aux-option-item" data-value="768" data-device="mobile"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-mobile.svg' ); ?>"></li>
                    </ul>
                    <div class="aux-control aux-control-has-unit" data-type="slider" data-default="">
                        <ul class="aux-units" data-default="px">
                            <li class="aux-option-item" data-value="px">PX</li>
                            <li class="aux-option-item" data-value="em">EM</li>
                            <li class="aux-option-item" data-value="rem">REM</li>
                        </ul>
                        <input type="number" min="-5" max="10" step="0.1">
                    </div>
                </div>
            </div>

            <input type="text" class="aux-controller-input aux-slider-controller-input" data-is-json="true" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
            <?php if ( ! empty( $this->description ) ) { ;?> <span class="description customize-control-description aux-controller-description"><?php echo auxin_kses( $this->description ); ?></span> <?php } ;?>
            <hr />
        </div>

    <?php }
}

/**
 * Customize Dimension Control class.
 */
class Auxin_Customize_Responsive_Dimensions_Controller extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_responsive_dimensions';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.f
     */
    public function render_content() {
        $style_template = !empty($this->css_placeholder ) ? 'data-style-template="' . esc_attr($this->css_placeholder) . '"' : '';
        ?>

        <div class="aux-dimension-controller aux-controller-wrapper">

            <div class="aux-control aux-controller-container aux-dimension-controller-container" data-type="container" data-selector="<?php echo esc_attr($this->setting->selectors) ;?>">
                <div class="aux-control" data-type="responsive" data-name="responsive_dimensions">
                    <label class="aux-control-resp-label" for=""><?php echo esc_html( $this->label ); ?></label>
                    <ul class="aux-devices" data-default="desktop">
                        <li class="aux-option-item" data-value="desktop" data-device="desktop"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-desktop.svg' ); ?>"></li>
                        <li class="aux-option-item" data-value="1024" data-device="tablet"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-tablet.svg' ); ?>"></li>
                        <li class="aux-option-item" data-value="768" data-device="mobile"><img src="<?php echo esc_url( AUXIN_URL . 'images/visual-select/aux-oc-mobile.svg' ); ?>"></li>
                    </ul>
                    <div class="aux-control aux-control-has-unit" data-type="dimension" data-default="" <?php echo $style_template ;?>>
                        <ul class="aux-units" data-default="px">
                            <li class="aux-option-item" data-value="px">PX</li>
                            <li class="aux-option-item" data-value="em">EM</li>
                            <li class="aux-option-item" data-value="rem">REM</li>
                        </ul>
                        <ul class="aux-dimension-inputs">
                            <li class="aux-list-number"><input type="number" data-side-name="top"><span class="aux-side-name"><?php _e( 'Top', 'phlox-pro' );?></span></li>
                            <li class="aux-list-number"><input type="number" data-side-name="right"><span class="aux-side-name"><?php _e( 'Right', 'phlox-pro' );?></span></li>
                            <li class="aux-list-number"><input type="number" data-side-name="bottom"><span class="aux-side-name"><?php _e( 'Bottom', 'phlox-pro' );?></span></li>
                            <li class="aux-list-number"><input type="number" data-side-name="left"><span class="aux-side-name"><?php _e( 'Left', 'phlox-pro' );?></span></li>
                            <li class="aux-list-button"><button class="aux-links-value aux-is-active"><i class="auxicon-link-1"></i></button></li>
                        </ul>
                    </div>
                </div>
            </div>

            <input type="text" class="aux-controller-input aux-dimension-controller-input" data-is-json="true" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
            <?php if ( ! empty( $this->description ) ) { ;?> <span class="description customize-control-description aux-controller-description"><?php echo auxin_kses( $this->description ); ?></span> <?php } ;?>
            <hr />
        </div>

    <?php }
}

/**
 * Customize Install Elementor Plugin Control
 */
class Auxin_Customize_Install_Elementor_Plugin extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_install_elementor_plugin';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.f
     */
    public function render_content() {
        $plugin_page_url  = is_multisite() ? network_admin_url( 'plugin-install.php') : admin_url( 'plugin-install.php') ;
        $plugin_page_url  = add_query_arg( [
            's' => 'elementor',
            'tab' => 'search',
            'type'  => 'term'
        ] , $plugin_page_url );
        ?>

        <?php if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif;
        if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
        <?php endif; ?>
        <a class="aux-install-elementor-button button button-primary" href="<?php echo esc_url( $plugin_page_url ) ;?>" target="_blank">
            <svg width="12.812" height="12.875" viewBox="0 0 12.812 12.875" >
                <path d="M0 0h2.687v12.875H0zM5.187 0h7.625v2.562H5.187zM5.187 5.187h7.625v2.562H5.187zM5.187 10.312h7.625v2.562H5.187z" fill="#FFF" />
            </svg>
            <span><?php _e( 'Install Elementor Now', 'phlox-pro' );?></span>
        </a>
        <hr />
    <?php }
}

/**
 * Customize Selective List itemss Control
 */
class Auxin_Customize_Selective_List extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_selective_list';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        $this->has_link = ! empty( $args['has_link'] );
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.f
     */
    public function render_content() { ?>
        <?php if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif;
        if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
        <?php endif; ?>
        <select class="visual-select-wrapper aux-control-selective-list" data-caption="true" <?php $this->link(); ?>>
            <?php
            foreach ( $this->choices as $choice_id => $choice_info ){ ?>
                <?php if ( $choice_id === ' '  || empty( $choice_id ) ) continue;?>
                <?php $data_link = $this->has_link ? 'data-link="' . get_edit_post_link( $choice_id ) . '"' : ''; ?>
                <option data-symbol="aux-custom-symbol-svg" value="<?php echo $choice_id;?>" <?php echo $data_link;?> <?php selected( $this->value(), $choice_id, false );?> ><?php echo esc_html( $choice_info ) ;?></option>
            <?php }
            ?>
        </select>
        <hr />

    <?php }

}

/**
 * Customize Selective List itemss Control
 */
class Auxin_Elementor_Edit_Template extends Auxin_Customize_Control {
    /**
     * @access public
     * @var string
     */
    public $type = 'auxin_edit_template';

    /**
     * @access public
     * @var array
     */
    public $statuses;

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->statuses = '';
        $this->template = $args['template'];
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Refresh the parameters passed to the JavaScript via JSON.
     */
    public function to_json() {
        parent::to_json();
        $this->json['statuses'] = $this->statuses;
        $this->json['defaultValue'] = $this->setting->default;
    }

    /**
     * Don't render the control content from PHP, as it's rendered via JS on load.f
     */
    public function render_content() {
        $title = get_the_title( $this->value() );
        ?>
        <?php if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <?php endif;
        if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
        <?php endif; ?>
        <div class="aux-selective-list">
            <div class="axi-select-item">
                <span class="aux-custom-symbol-svg"></span>
                <span class="axi-select-caption"><?php echo wp_kses_post( $title ) ;?></span>
            </div>
        </div>
        <a class="aux-edit-elementor-button button button-primary" href="<?php echo esc_url( add_query_arg( 'elementor', '', get_permalink( $this->value() ) ) );?>" target="_blank">
            <span><?php printf( __( 'Edit with %s Builder', 'phlox-pro' ), $this->template ); ?></span>
        </a>
        <input class="aux-input-is-hidden" type="text" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> />
        <hr />

    <?php }
}

/**
 * A simple customizer controller for displaying information
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
class Auxin_Customize_Info extends Auxin_Customize_Control {

    /**
     * The type of customize section being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'auxin_info';

    public $title_color = '';

    public $description_color = '';

    public $icon_color = '';

    /**
     * Constructor.
     *
     * @param WP_Customize_Manager $manager Customizer bootstrap instance.
     * @param string               $id      Control ID.
     * @param array                $args    Optional. Arguments to override class property defaults.
     */
    public function __construct( $manager, $id, $args = array() ) {
        $this->description_color = !empty( $args['description_color'] ) ? $args['description_color'] : '';
        $this->description_color = !empty( $args['title_color'] ) ? $args['title_color'] : '';
        $this->icon_color = ! empty( $args['icon_color'] ) ? $args['icon_color'] : '';

        parent::__construct( $manager, $id, $args );
    }

    /**
     * Outputs the Underscore.js template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function render_content() { ?>

        <?php $this->control_wrapper_open(['class' => 'aux-info']); ?>

            <?php if( ! empty( $this->icon_color ) ) { ?>
            <span class="auxicon auxicon-info-1" style="color:<?php echo esc_attr( $this->icon_color ); ?>"></span>
            <?php } ?>
            <div class="txt">
                <span class="customize-control-title" <?php if ( !empty( $this->title_color ) ) echo 'style="color:'.esc_attr( $this->title_color ).';"' ?>><?php echo esc_html( $this->label );?></span>
                <span class="customize-control-description description" <?php if ( !empty( $this->description_color ) ) echo 'style="color:'.esc_attr( $this->description_color ).';"' ?>><?php echo auxin_kses( $this->description );?></span>
            </div>

        <?php $this->control_wrapper_close(); ?>

    <?php }
}


/**
 * A simple customizer controller for displaying information
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
class Auxin_Customize_Color_Repeater extends Auxin_Customize_Control {

    /**
     * The type of customize section being rendered.
     *
     * @since  1.0.0
     * @access public
     * @var    string
     */
    public $type = 'auxin_color_repeater';

    /**
     * Outputs the Underscore.js template.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function render_content() {

        $this->control_wrapper_open();

        $data_device = isset( $this->device ) ? 'data-device="' . esc_attr( $this->device ) . '"' : '';

        if ( ! empty( $this->choices ) ) {
            foreach( $this->choices as $color ) {
                ?>
                 <label <?php echo $data_device; ?>>
                    <span class="customize-control-title"><input type="text" value="<?php echo esc_html( $color['title'] ); ?>"></span>
                    <div class="mini-color-wrapper">
                        <input type="text" value="<?php echo esc_attr( $color['color'] ); ?>" data-id="<?php echo esc_attr( $color['_id'] );?>"/>
                    </div>
                    <span class='aux-remove-color auxicon auxicon-trash'></span>

                </label>
                <hr />
                <?php
            }
        }
        ?>
        <label <?php echo $data_device; ?> style="display:none;">
            <?php if ( ! empty( $this->label ) ) : ?>
                <span class="customize-control-title"><input type="text" value="<?php echo esc_html( $this->label ); ?>"></span>
            <?php endif; ?>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo auxin_kses( $this->description ); ?></span>
            <?php endif; ?>
            <div class="mini-color-wrapper">
                <input type="text" />
            </div>
            <span class='aux-remove-color auxicon auxicon-trash'></span>

        </label>
        <div class='aux-plus'><span>+ <?php esc_html_e( 'Add Global Color', 'phlox-pro' );?><span></div>
        <input class='aux-color-repeater' type="hidden" data-is-json="true" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?>/>
        <?php

        $this->control_wrapper_close();
    }
}
