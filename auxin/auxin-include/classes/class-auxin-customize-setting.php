<?php
/**
 * Auxin Customize Setting Class
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

/**
 * Customizer Auxin Option Setting class.
 *
 * @see WP_Customize_Setting
 */
class Auxin_Customize_Setting extends WP_Customize_Setting {

    public $type = 'auxin_option';

    // Default value
    public $default = '';

    // The inline JS
    public $post_js = '';

    // A callback function that generates the custom CSS for this setting
    public $style_callback;

    // Instant custom CSS for this setting
    public $selectors;

    // Option controll custom type
    public $category;


    public function __construct( $manager, $id, $args = array() ) {

        add_action( 'customize_preview_init', array( $this, 'preview_init' ) );

        parent::__construct( $manager, $id, $args );

        if ( empty( $this->style_callback ) ) {
            $this->style_callback = array( $this, 'style_callback' );
        }

        // triggers on customizer preview
        add_action( "customize_preview_{$this->id_data['base']}" , array( $this, 'on_customizer_preview'  ) );

    }


    public function on_customizer_preview(){
        // Pass the value of setting to preview frame instead of the stored option value
        add_filter( "pre_auxin_option_{$this->id_data['base']}", array( $this, '_preview_filter' ) );
    }


    public function preview_init(){

        $custom_style = $this->custom_style();

        if( ( ! empty( $this->post_js ) || ! empty( $this->selectors ) || null !== $custom_style ) &&  'postMessage' == $this->transport ){

            wp_enqueue_script('customize-preview');
            $style_dom_id  = esc_attr( 'auxin-customizer-css-'. $this->id_data['base'] );

            ob_start();
            ?>
            ;( function( $ ) {

                var style = { html: function(){} },
                    selectors = '<?php echo $this->get_selectors(); ?>';

        <?php // Genetate the js code for creating style tag
                if( ( $this->style_callback !== array( $this, 'style_callback' ) || ! empty( $this->selectors ) ) ){ ?>
                    style = $( '#<?php echo $style_dom_id; ?>' );

                    if ( ! style.length ) {
                        style = $( 'head' ).append( '<style type=\"text/css\" id=\"<?php echo $style_dom_id; ?>\" />' ).find( '#<?php echo $style_dom_id; ?>' );
                    }
        <?php   } 

                if ( $this->category !== 'special' ) { ?>

                wp.customize( '<?php echo esc_js( $this->id_data['base'] ); ?>', function( value ) {

                    // Run the initial post js value
                    $(function() {
                        // get setting value
                        var to = wp.customize( '<?php echo esc_js( $this->id_data['base'] ); ?>' )();
                        <?php // run the post_js script on start
                        echo $this->post_js; ?>
                    });

                    var initialStyles = '<?php echo $custom_style ? str_replace( array( "\n", "\r" ) , array(" \ ", " \ "), $custom_style ) : '';  ?>';
                    if( ! initialStyles && selectors ){
                        var initialValue = wp.customize( '<?php echo esc_js( $this->id_data['base'] ); ?>' )();
                        initialStyles += auxinGetSelectorStyles( initialValue, selectors );
                    }
                    if( initialStyles ){
                        // apply initial setting value
                        style.html( initialStyles );
                    }

                    value.bind( function( to ) {

<?php if( $this->style_callback !== array( $this, 'style_callback' ) ){ ?>
                        if( undefined !== style ){
                            wp.ajax.send( "auxin_customizer", {
                                success: function( data ){
                                    style.html( data );
                                },
                                error: function( data ){
                                    console.log( data );
                                },
                                data: {
                                  nonce: auxinCustomizerNonce.nonce,
                                  setting_value: to,
                                  default_value: '<?php echo esc_js( $this->default ); ?>',
                                  setting_id: '<?php echo esc_js( $this->id_data['base'] ); ?>'
                                }
                            });
                        }
<?php } elseif( ! empty( $this->selectors ) ){ ?>
                        if( undefined !== style ){
                            var css = auxinGetSelectorStyles( to, selectors );
                            style.html( css );
                        }
<?php } ?>
                        <?php
                        // add the post_js script
                        echo $this->post_js; ?>
                    });
                }); <?php };?>
            } )( jQuery );
            <?php
            $js = ob_get_clean();

            wp_add_inline_script( 'customize-preview', $js, 'after' );
        }

    }

    private function get_selectors(){
        $ditect_styles = '';

        if( ! empty( $this->selectors ) ){
            if( is_array( $this->selectors ) ){
                foreach ( $this->selectors as $property => $property_value ) {
                    if( is_numeric( $property ) ){
                        $ditect_styles .= $property_value . ',';
                    } else {
                        $ditect_styles .= $property . '{'. $property_value .'}';
                    }
                }
            } else {
                $ditect_styles = $this->selectors;
            }
        }

        return rtrim( $ditect_styles, ',' );
    }


    public function style_callback( $css = array() ){
        return null;
    }

    /**
     * Call the user defined callback for retrieving the custom styles
     *
     * @return string|array   The custom css style with placeholder (|to|)
     */
    public function custom_style(){
        return call_user_func( $this->style_callback, null );
    }


    /**
     * Get the root value for a setting, especially for multidimensional ones.
     *
     * @param mixed $default Value to return if root does not exist.
     * @return mixed
     */
    protected function get_root_value( $default = null ) {
        $id_base = $this->id_data['base'];
        if ( 'option' === $this->type ) {
            return get_option( $id_base, $default );
        } elseif ( 'theme_mod' === $this->type ) {
            return auxin_get_theme_mod( $id_base, $default );

        // @auxin-start
        } elseif ( 'auxin_option' === $this->type ) {
            return auxin_get_option( $id_base, $default );
        // @auxin-end
        } else {
            /*
             * Any WP_Customize_Setting subclass implementing aggregate multidimensional
             * will need to override this method to obtain the data from the appropriate
             * location.
             */
            return $default;
        }
    }


    /**
     * Set the root value for a setting, especially for multidimensional ones.
     *
     * @param mixed $value Value to set as root of multidimensional setting.
     * @return bool Whether the multidimensional root was updated successfully.
     */
    protected function set_root_value( $value ) {
        $id_base = $this->id_data['base'];

        if ( 'option' === $this->type ) {
            $autoload = true;
            if ( isset( self::$aggregated_multidimensionals[ $this->type ][ $this->id_data['base'] ]['autoload'] ) ) {
                $autoload = self::$aggregated_multidimensionals[ $this->type ][ $this->id_data['base'] ]['autoload'];
            }
            return update_option( $id_base, $value, $autoload );

        } elseif ( 'theme_mod' === $this->type ) {
            set_theme_mod( $id_base, $value );
            return true;

        // @auxin-start
        } elseif( 'auxin_option' === $this->type ){

            // update front-end options
            $is_updated = auxin_update_option( $id_base, $value );

            // generate custom css and js codes
            Auxin_Fonts::get_instance()->parse_typography();

            // if auxin-elements was enabled
            auxin_add_custom_css();
            auxin_add_custom_js();

            return $is_updated;

        // @auxin-end
        } else {
            /*
             * Any WP_Customize_Setting subclass implementing aggregate multidimensional
             * will need to override this method to obtain the data from the appropriate
             * location.
             */
            return false;
        }
    }


    /**
     * Save the value of the setting, using the related API.
     *
     * @param mixed $value The value to update.
     * @return bool The result of saving the value.
     */
    protected function update( $value ) {
        parent::update( $value );

        return $this->set_root_value( $value );
    }

}

