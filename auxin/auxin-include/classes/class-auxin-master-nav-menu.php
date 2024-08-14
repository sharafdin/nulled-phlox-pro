<?php
/**
 * Main class for adding configurations and hooks for extending WordPress navigation menu
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
class Auxin_Master_Nav_Menu {

    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance  = null;

    /**
     * List of temporary meta fields for menu items
     *
     * @var array
     */
    private $__menu_item_fields = array();

    /**
     * List of custom meta fields for menu items
     *
     * @var array
     */
    public $__filtered_menu_item_fields = array();


    function __construct(){

        // Defining the custom fields for menu items
        $this->__menu_item_fields = array(

            'megamenu' => array(
                'label'     => __( 'Submenu as Mega menu', 'phlox-pro' ),
                'type'      => 'switch',
                'id'        => 'megamenu',
                'default'   => '0',
                'max_depth' => 0
            ),
            'nolink' => array(
                'label'     => __( 'Disable Link', 'phlox-pro' ),
                'type'      => 'switch',
                'id'        => 'nolink',
                'default'   => '0'
            ),
            'hide_label' => array(
                'label'     => __( 'Hide Label', 'phlox-pro' ),
                'type'      => 'switch',
                'id'        => 'hide_label',
                'default'   => '0'
            ),
            'icon' => array(
                'label'     => __( 'Icon', 'phlox-pro' ),
                'type'      => 'icon',
                'id'        => 'icon',
                'default'   => ''
            ),
            'icon_align' => array(
                'label'     => __( 'Icon Alignment', 'phlox-pro' ),
                'type'      => 'select',
                'id'        => 'icon_align',
                'choices'   => array(
                    ''       => esc_attr__( 'Auto', 'phlox-pro' ),
                    'left'   => esc_attr__( 'Left'    , 'phlox-pro' ),
                    'right'  => esc_attr__( 'Right'   , 'phlox-pro' ),
                    'top'    => esc_attr__( 'Top'     , 'phlox-pro' ),
                    'bottom' => esc_attr__( 'Bottom'  , 'phlox-pro' )
                ),
                'default'   => ''
            ),
            'row_start' => array(
                'label'     => __( 'Start Row From Here', 'phlox-pro' ),
                'type'      => 'switch',
                'id'        => 'row_start',
                'default'   => '0',
                'min_depth' => 1,
                'max_depth' => 1
            ),
            'hide_title' => array(
                'label'     => __( 'Hide Title', 'phlox-pro' ),
                'type'      => 'switch',
                'id'        => 'hide_title',
                'default'   => '0',
                'min_depth' => 1,
                'max_depth' => 1
            ),
            'col_num' => array(
                'label'     => __( 'Number of Columns', 'phlox-pro' ),
                'type'      => 'select',
                'id'        => 'col_num',
                'choices'   => array(
                    //'auto'  => __( 'Auto', 'phlox-pro' ),
                    1       => 1,
                    2       => 2,
                    3       => 3,
                    4       => 4,
                    5       => 5,
                    6       => 6
                ),
                'default'   => 2,
                'max_depth' => 0
            ),
            'hide_desktop' => array(
                'label'     => __( 'Hide on Desktop', 'phlox-pro' ),
                'type'      => 'switch',
                'id'        => 'hide_desktop',
                'default'   => '0'
            ),
            'hide_tablet' => array(
                'label'     => __( 'Hide on Tablet', 'phlox-pro' ),
                'type'      => 'switch',
                'id'        => 'hide_tablet',
                'default'   => '0'
            ),
            'hide_mobile' => array(
                'label'     => __( 'Hide on Mobile', 'phlox-pro' ),
                'type'      => 'switch',
                'id'        => 'hide_mobile',
                'default'   => '0'
            ),
            'sec_text' => array(
                'label'     => __( 'Secondary Text', 'phlox-pro' ),
                'type'      => 'textarea',
                'id'        => 'sec_text',
                'default'   => ''
            ),
            'sec_bg_color' => array(
                'label'     => __( 'Secondary Text Background Color', 'phlox-pro' ),
                'type'      => 'textarea',
                'id'        => 'sec_bg_color',
                'default'   => '#FFF'
            ),
            'custom_style' => array(
                'label'     => __( 'Custom Style', 'phlox-pro' ),
                'type'      => 'textarea',
                'id'        => 'custom_style',
                'default'   => ''
            ),
            'aux_background_image' => array(
                'label'     => __( 'Image ID', 'phlox-pro' ),
                'type'      => 'textarea',
                'id'        => 'aux_background_image',
                'default'   => '',
                'min_depth' => 1,
                'max_depth' => 1
            ),
            'link_path' => array(
                'label'     => __( 'Link/anchor ID', 'phlox-pro' ),
                'type'      => 'text',
                'id'        => 'link_path',
                'default'   => '',
                'visible'   => array( 'page' ),
            )
        );


        // Change the walker class and default args for front end navigation menu
        add_filter( 'wp_nav_menu_args'      , array( $this, 'change_nav_menu_frontend_walker' ), 9, 1 );
        // Add HTML comment before and after of menu section
        add_filter( 'wp_nav_menu'           , array( $this, 'add_html_comment_nav_menu_front' ), 9, 1 );
    }

    /* Back End
    ==========================================================================*/


    /* Front End
    ==========================================================================*/

    /**
     * Modifies the walker class and default args for front end menu
     */
    public function change_nav_menu_frontend_walker( $args ){

        // This line will block our custom args from nav menu (This will fix nav issues on Elementor header builder)
        if( $args['fallback_cb'] !== 'wp_page_menu' ) {
            return $args;
        }


        $args['container']  = 'nav';
        $args['before']     = "\n";
        $args['after']      = "\n";

        // only init master menu in following theme locations
        $master_menu_theme_locations = array( 'header-primary', 'header-secondary', 'element');

        $menu_direction  = isset( $args['direction'] ) ? $args['direction'] : 'horizontal';           // the menu type on desktop size (toggle, accordion, horizontal, vertical, cover)


        if( in_array( $args['theme_location'], $master_menu_theme_locations ) ){
            $args['menu_class']  = 'aux-master-menu aux-no-js';

            if ( 'header-secondary' == $args['theme_location'] ){
                $args['menu_class'] .= ' aux-skin-' . esc_attr( auxin_get_option( 'top_header_navigation_sub_skin', 'default' ) );

            }else if ( 'header-primary' == $args['theme_location'] && 'vertical' === $menu_direction ) {

                $args['menu_class'] .= ' aux-skin-' . esc_attr( auxin_get_option( 'site_vertical_header_navigation_sub_skin', 'default' ) );

            } else if ( 'element' != $args['theme_location'] ) {

                $args['menu_class'] .= ' aux-skin-' . esc_attr( auxin_get_option( 'site_header_navigation_sub_skin', 'default' ) );

            }

            $args['menu_class'] .= isset( $args['extra_class'] ) && ! empty( $args['menu_class'] )  ? $args['extra_class'] : '';
            $args['walker']      = new Auxin_Walker_Nav_Menu_Front();
        }



        if( 'header-secondary' == $args['theme_location'] ){
            // insert menu direction classname
            $args['menu_class'] .= ' aux-' . $menu_direction;
        }

        // the mobile menu options for header-primary menu
        // ---------------------------------------------------------------------
        $data_switch_attr = '';

        if ( 'element' == $args['theme_location'] ){
            $mobile_menu_type    = isset( $args['mobile_menu_type'] ) && ! empty( $args['mobile_menu_type'] ) ? $args['mobile_menu_type'] : 'toggle';
            $mobile_under        = isset( $args['mobile_under'] ) && ! empty( $args['mobile_under'] ) ? $args['mobile_under'] : 765 ;
            $mobile_menu_target  = isset( $args['mobile_menu_target'] ) && ! empty( $args['mobile_menu_target'] ) ? $args['mobile_menu_target'] : '.aux-elementor-header .aux-toggle-menu-bar';
            $data_switch_attr    = ' data-switch-type="'. esc_attr( $mobile_menu_type ) .'" data-switch-parent="'. esc_attr( $mobile_menu_target ) .'" data-switch-width="'. esc_attr( $mobile_under ) .'" ';
            $args['menu_class'] .= ' aux-' . $menu_direction;
        }

        if( 'header-primary' == $args['theme_location'] ){


            // Specifies the submenu opening effect
            $submenu_effect = auxin_get_option( 'site_header_navigation_sub_effect', '' );
            if ( !empty( $submenu_effect ) ) {
                $args['menu_class'] .= ' aux-' . esc_attr( $submenu_effect ) . '-nav';
            }

            // insert menu direction classname
            $args['menu_class'] .= ' aux-' . $menu_direction;


            // Add splitter and indicator if they are enabled
            if( auxin_get_option( 'site_header_navigation_with_indicator' ) ){
                $args['menu_class'] .= ' aux-with-indicator';
            }
            if( auxin_get_option( 'site_header_navigation_with_splitter' ) &&  'horizontal' === $menu_direction ){
                $args['menu_class'] .= ' aux-with-splitter';
            }

            // under what width we have to move the menu to switch parent
            if( ! isset( $args['mobile_under'] ) ){
                $args['mobile_under'] = 767;
            }

            // the menu position on mobile and tablet size (toggle-bar, offcanvas, overlay, none)
            $mobile_menu_position = isset( $args['mobile_menu_position'] ) ? $args['mobile_menu_position'] : auxin_get_option( 'site_header_mobile_menu_position' );
            $mobile_menu_position = esc_attr( $mobile_menu_position );

            // the menu type on mobile and tablet size (toggle, accordion, horizontal, vertical, cover)
            $mobile_menu_type     = isset( $args['mobile_menu_type'] ) ? $args['mobile_menu_type'] : auxin_get_option( 'site_header_mobile_menu_type' );

            $mobile_menu_parent_selectors = array(
                'toggle-bar' => '.aux-header .aux-toggle-menu-bar',
                'offcanvas'  => '.aux-offcanvas-menu .offcanvas-content',
                'overlay'    => '.aux-fs-popup .aux-fs-menu',
                'none'       => ''
            );

            // where to move menu on mobile and tablet size
            $mobile_menu_target   = isset( $mobile_menu_parent_selectors[ $mobile_menu_position ] ) ? $mobile_menu_parent_selectors[ $mobile_menu_position ] : '';

            $data_switch_attr = ' data-switch-type="'. esc_attr( $mobile_menu_type ) .'" data-switch-parent="'. esc_attr( $mobile_menu_target ) .'" data-switch-width="'. esc_attr( $args['mobile_under'] ) .'" ';
        }
        // ---------------------------------------------------------------------

        $args['items_wrap'] = "\n\n\t" . '<ul id="%1$s" class="%2$s" data-type="' . esc_attr( $menu_direction ) . '" '. $data_switch_attr ." >\n" .'%3$s'. "\t</ul>\n\n";

        return $args;
    }

    /**
     * Adds HTML comment before and after of menu section
     * @param string $output
     */
    public function add_html_comment_nav_menu_front( $output ){
        return "<!-- start master menu -->\n" . $output. "\n<!-- end master menu -->\n";
    }

    /* Get methods
    ==========================================================================*/

    /**
     * Retrieves the list of menu items
     *
     * @param array  $args   An array of arguments. @see wp_nav_menu()
     * @return               Returns the list of menu items
     */
    public function get_menu_items( $args ){

        $menu_items = array();

        // Get the nav menu based on the requested menu
        $menu = wp_get_nav_menu_object( $args->menu );

        // Get the nav menu based on the theme_location
        if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) )
            $menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );

        // get the first menu that has items if we still can't find a menu
        if ( ! $menu && !$args->theme_location ) {
            $menus = wp_get_nav_menus();
            foreach ( $menus as $menu_maybe ) {
                if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
                    $menu = $menu_maybe;
                    break;
                }
            }
        }

        if ( empty( $args->menu ) ) {
            $args->menu = $menu;
        }

        // If the menu exists, get its items.
        if ( $menu && ! is_wp_error($menu) && !isset($menu_items) )
            $menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

        return $menu_items;
    }


    /**
     * Magic method to get the value of accessible properties
     *
     * @param   string   The property name
     * @return  string  The value of property
     */
    public function __get( $name ){

        // Make the other part of application to change the custom fields via a custom filter hook
        if( 'menu_item_fields' ==  $name ){
            if( empty( $this->__filtered_menu_item_fields ) ){
                $this->__filtered_menu_item_fields = apply_filters( 'auxin_master_nav_menu_item_fields', $this->__menu_item_fields );
            }

            return $this->__filtered_menu_item_fields;
        }

        if( property_exists( $this, $name ) ){
            return $this->$name;
        }

        return null;
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

}
