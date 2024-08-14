<?php
/**
 * Class for parsing and managing icon fonts
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

class Auxin_Font_Icons {

    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     *
     *
     * @var array
     */
    protected $fonts_list;




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

    /**
     * Magic method to get the value of accessible properties
     *
     * @param   string   The property name
     * @return  string  The value of property
     */
    public function __get( $name ){

        if( property_exists( $this, $name ) ){
            return $this->$name;
        }

        return null;
    }

    /**
     * Magic method to set value for properties
     *
     * @param   string    The property name
     * @param   string   The property value
     * @return  bool    True, if the value was set to property successfully, False on failure.
     */
    public function __set( $name, $value ){
        if( isset( $this->$name ) ){
            $this->$name = $value;
            return true;
        }
        return false;
    }


    public function get_icons_list( $font_name ){

        if( ( false === $icons_list = get_site_transient( 'auxin_font_icons_list_' . $font_name ) ) || empty( $icons_list ) ){
            $this->update();
            $icons_list = $this->fonts_list[ $font_name ];
        }
        return $icons_list;
    }


    public function update(){
        // cache the data for fontastic font
        $font_path = THEME_DIR . 'css/fonts/fontastic/';

        $this->fetch_and_store_font_icons_list( 'fontastic', $font_path . 'auxicon/auxin-front.json' );
        $this->fetch_and_store_font_icons_list( 'auxicon2' , $font_path . 'auxicon2/auxin-front-2.json' );
    }

    /**
     * Parse and store the fonts data from the fonts json file
     *
     * @param  string  $font_path Path for fonts json file
     * @return void
     */
    private function fetch_and_store_font_icons_list( $font_name, $font_path ){
        $this->fonts_list[ $font_name ] = $this->get_font_json_contents( $font_path );
        set_site_transient( 'auxin_font_icons_list_' . $font_name, $this->fonts_list[ $font_name ], 30 * DAY_IN_SECONDS );
    }

    /**
     * Parse and retrieves the fonts from the fonts json file
     *
     * @param  string  $font_path Path for fonts json file
     * @return string             Parsed json
     */
    private function get_font_json_contents( $font_path = '' ){
        global $wp_filesystem;

        if ( empty($wp_filesystem) ) {
            require_once( ABSPATH . '/wp-admin/includes/file.php' );
            WP_Filesystem();
        }

        $json_content = $wp_filesystem->get_contents( $font_path );

        if( ! is_wp_error( $json_content ) && false !== $json_content ){
            return json_decode( $json_content );
        }

        return false;
    }


    /**
     * Retrieves the icons list for an specific font name
     *
     * @param  string $font_name  The font name that we are willing to get its icons list
     * @return Array              A list containing the info of all icons
     */
    public function get_font_icons_list( $font_name = '' ){
        if( isset( $this->fonts_list[ $font_name ] ) ){
            return $this->fonts_list[ $font_name ];
        }
        return false;
    }

}
