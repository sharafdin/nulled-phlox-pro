<?php
/**
 * Auxin configurations
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;



class AuxinConfig {

    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;


    public $config = array();


    function __construct(){
        $this->init_config();
    }

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

        if( isset( $this->config[ $name ] ) ){
            return $this->config[ $name ];
        }

        return null;
    }


    private function init_config(){

        /**
         * Image Sizes
         */
        $this->config['image_sizes'] = array(
            'i2'    => array(479, null, null),
            'i2_1'  => array(479,  290, true),
            'i2_2'  => array(479,  582, true),

            'full'  => array(1200, 800, true),
            'side'  => array(1050, 700, true)
        );

        $this->config['image_sizes'] = apply_filters( 'auxin_image_sizes', $this->config['image_sizes'] );

        /**
         * Theme support features
         */
        $this->config['theme_support'] = apply_filters( 'auxin_theme_support',
            array(
                'post-thumbnails',
                'post-formats',
                'woocommerce',
                'html5',
                'gallery',
                'customize-selective-refresh-widgets',
                'custom-logo',
                'auxin-portfolio',
                'auxin-shop'
            )
        );

        /**
         * Theme custom post types
         */
        $this->config['active_post_types'] = apply_filters( 'auxin_active_post_types',
            array(
                'portfolio'   => false,
                'product'     => false,
                'news'        => false,
                'service'     => false,
                'faq'         => false,
                'staff'       => false,
                'testimonial' => false,
                'events'      => false,
                'feedback'    => false,
                'client'      => false
            )
        );

        $this->config['theme_width_list'] = apply_filters( 'auxin_theme_width_list',
            array(
                'nd'    => 1000,
                'hd'    => 1200,
                'xhd'   => 1400,
                's-fhd' => 1600,
                'fhd'   => 1900
            )
        );

        $this->config['theme_gutter'] = 70;
    }

}


/*---------------------------------------------*/
/*  Functions
/*---------------------------------------------*/

/**
 * Quick access to get image sizes
 *
 * @param  string $key Image size ID
 * @return array       Returns an array containing image sizes
 */
function auxin_get_image_size( $key ){
    $image_sizes = AuxinConfig::get_instance()->image_sizes;
    return isset( $image_sizes[ $key ] ) ? $image_sizes[ $key ]: array();
}

function auxin_get_image_sizes( $key ){
    return AuxinConfig::get_instance()->image_sizes;
}


/**
 * Returns all possible/allowed post types in theme framework
 *
 * @param  $only_allowed  whether to return only allowed post types or not
 * @return array  An array containing list of all post types
 */
function auxin_get_possible_post_types( $only_allowed = false ){
    // list of all custom post types
    $all_custom_post_types = AuxinConfig::get_instance()->active_post_types;

    return $only_allowed ? array_filter( $all_custom_post_types ) : $all_custom_post_types;
}

/**
 *  Is post type allowed or not
 *
 * @param  string $post_type  Post type name
 * @return boolean
 */
function auxin_is_post_type_allowed( $post_type ){
    $auxin_active_post_types = auxin_get_possible_post_types();
    return isset( $auxin_active_post_types[ $post_type ] ) && $auxin_active_post_types[ $post_type ];
}


/**
 * Returns all active post types in theme framework (the registered ones)
 * You are expected to call this function when all post types are registered
 *
 * @param  $only_actives  whether to return only active post types or not
 * @return array  An array containing list of all post types
 */
function auxin_registered_post_types( $only_actives = false ){
    // list of all custom poat types
    $all_custom_post_types = auxin_get_possible_post_types( $only_actives );

    return array_filter( array_keys( $all_custom_post_types), 'post_type_exists' );
}

