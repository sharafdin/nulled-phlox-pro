<?php
/**
 * The root class of theme options
 *
 * Auxin_Option::get_option();
 * Auxin_Option::update_option();
 * Auxin_Option::delete_option();
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
class Auxin_Option {

    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * Instance of Auxin_Options_Data which
     * stores panel data and config
     * (model)
     *
     * @var object
     */
    public $data = null;

    /**
     * Instance of Auxin_Options_Controller which
     * stores panel data and config
     * (controller)
     *
     * @var object
     */
    public $controller = null;



    function __construct(){
        $this->data       = new Auxin_Options_Data();
        $this->controller = new Auxin_Options_Controller( $this->data );
    }

    /**
     * Get option value from auxin options, if option_name does not exist then returns default value
     *
     * @param   string $option_name     A unique name for option
     * @param   string $default         The default value for option
     *
     * @return boolean                  The option value
     */
    public static function get_option( $option_name, $default = '' ){
        return auxin_get_option( $option_name, $default );
    }

    /**
     * Update option value in auxin options, if option_name does not exist then insert new option
     *
     * @param   string $option_name     A unique name for option
     * @param   string $option_value    The option value
     *
     * @return boolean                  True if option value has changed, false if not or if update failed.
     */
    public static function update_option( $option_name, $option_value ){
        return auxin_update_option( $option_name, $option_value = '' );
    }

    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     */
    public static function api() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }

}
