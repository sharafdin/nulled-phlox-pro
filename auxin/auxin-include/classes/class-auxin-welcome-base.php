<?php
/**
 * Generates a welcome page
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

class Auxin_Welcome_Base {

    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;

    /**
     * The sections (tabs) info
     *
     * @var array()
     */
    protected $sections = array();

    /**
     * The slug name to refer to this menu
     *
     * @since 1.0
     *
     * @var string
     */
    protected $page_slug;

    /**
     * The slug name to refer to this menu
     *
     * @since 1.0
     *
     * @var string
     */
    protected $parent_slug;

    /**
     * The class version number.
     *
     * @var string
     */
    protected $version  = '1.1';

    /**
     * Current theme slug
     *
     * @var string
     */
    protected $theme_id = '';


    /**
     * Constructor
     *
     */
    function __construct(){
        $this->theme_id  = THEME_ID;
        $this->page_slug = 'auxin-welcome';

        $this->init_actions();
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
     * Init the actions
     *
     * @return void
     */
    protected function init_actions(){
        add_action( 'admin_menu'                   , array( $this, 'register_admin_menu'  ) );
        add_action( 'auxin_admin_welcome_menu_args', array( $this, 'menu_badge_count'     ) );
        add_action( 'admin_enqueue_scripts'        , array( $this, 'maybe_add_body_class' ) );

        if( $this->is_welcome_page() ){
            // Hide all admin notices on dashboard page
            remove_all_actions( 'admin_notices' );
        }
    }

    /**
     * Checks and adds a constant class names to body on welcome page
     *
     */
    public function maybe_add_body_class(){
        if( $this->is_welcome_page() ){
            add_action( 'admin_body_class', array( $this, 'add_body_class' ) );
        }
    }

    /**
     * Checks whether the current page is welcome page or not
     */
    protected function is_welcome_page(){
        if( function_exists('get_current_screen') ){
            $screen = get_current_screen();
            return is_object( $screen ) && false !== strpos( $screen->id, '_' . $this->page_slug );
        }
        return ! empty( $_GET['page'] ) && $this->page_slug === $_GET['page'];
    }

    /**
     * Adds a constant class names to body on welcome page
     */
    public function add_body_class( $classes ){
        $classes .= ' aux-welcome-body';

        return $classes;
    }

    /**
     * Retrieves the admin menu args
     *
     * @return array  Admin menu args
     */
    public function get_admin_menu_args(){
        $menu_name = AUXIN_NO_BRAND ? __( 'Theme Panel', 'phlox-pro') : THEME_NAME_I18N;

        return apply_filters( 'auxin_admin_welcome_menu_args', array(
            'name'          => $menu_name,
            'title'         => __('Welcome', 'phlox-pro'),
            'compatibility' => 'manage_options'
        ) );
    }

    /**
     * Register the admin menu
     *
     * @return void
     */
    public function register_admin_menu() {

        $menu_args = $this->get_admin_menu_args();

        /*  Register welcome submenu
        /*---------------------------*/
        add_theme_page(
            $menu_args['title'],         // [Title]    The title to be displayed on the corresponding page for this menu
            $menu_args['name'],          // [Text]     The text to be displayed for this actual menu item
            $menu_args['compatibility'],
            $this->page_slug,            // [ID/slug]  The unique ID - that is, the slug - for this menu item
            array( $this, 'render')      // [Callback] The name of the function to call when rendering the menu for this page
        );
    }

    /**
     * Collect the sections
     *
     * @return array    panel sections
     */
    public function get_sections(){
        if( empty( $this->sections ) ){
            $this->sections = apply_filters( 'auxin_admin_welcome_sections', array() );
        }

        return $this->sections;
    }


    /**
     * Header section
     *
     * @param  string $type The current tab
     * @return void
     */
    protected function the_header( $type ){

        $sections = $this->get_sections();
        if( empty( $sections ) ){
            return;
        }

        $welcome_description = ! empty( $sections[ $type ]['description'] ) ? $sections[ $type ]['description'] : '';

        $welcome_page_title  = AUXIN_NO_BRAND ? __('Welcome','phlox-pro') : sprintf( __( 'Welcome to %s Theme', 'phlox-pro' ) . '</strong>',  '<strong>'. THEME_NAME_I18N );
        /**
        * Filter the "Welcome to theme name" text displayed in the welcome page.
        *
        * @param string $welcome_page_title The title that will be printed .
        */
        $welcome_page_title = apply_filters( 'auxin_welcome_page_title', $welcome_page_title, $type );

        ?>
        <div class="aux-welcome-header">
            <h1 class="aux-welcome-title"><?php echo wp_kses( $welcome_page_title, array(
                'br' => array(),
                'em' => array(),
                'strong' => array(),
            ) ); ?></h1>
            <div class="aux-welcome-subtitle">
                <?php
                    echo '<span class="aux-welcome-desc-meta">' . sprintf( esc_html__('Version %s', 'phlox-pro'), THEME_VERSION ) . '</span>';
                    if( function_exists('auxin_is_activated') &&  auxin_is_activated() ){
                        printf( '<span class="aux-is-activated aux-welcome-desc-meta"> %s </span>', esc_html__('Activated', 'phlox-pro') );
                        printf( '<a class="aux-welcome-desc-meta-link aux-welcome-desc-meta" href="https://docs.phlox.pro/article/174-transfer-license" target="_blank">%s</a>', esc_html__('How to deactivate?', 'phlox-pro') );
                    }
                    echo esc_html( $welcome_description );
                ?>
            </div>
            <?php
                $theme_badge = sprintf( '<a class="aux-welcome-theme-badge" href="%s"></a>', $this->get_tab_link() );
                echo apply_filters( 'auxin_display_theme_badge', $theme_badge );
            ?>
        </div>
        <?php
    }

    /**
     * Navigation section
     *
     * @param  string $type The current tab
     * @return void
     */
    protected function the_nav( $type ){

        $nav_tabs = $this->get_sections();
        if( empty( $nav_tabs ) ){
            return;
        }

        echo '<nav class="aux-welcome-nav-bar aux-' . $type . '-tab-is-active" >';
        echo '<ul>';

        foreach( $nav_tabs as $tab_id => $tab_info ) {
            $feature_tab_class  = $type === $tab_id ? 'aux-welcome-nav-tab aux-tab-active' : 'aux-welcome-nav-tab';
            $feature_tab_class .= ' aux-tab-' . $tab_id;

            if( empty( $tab_info['url'] ) ){
                $tab_info['url'] = $this->get_page_link() . '&tab='.  $tab_id;
            }

            $target = ! empty( $tab_info['target'] ) ? $tab_info['target'] : '_self';

            echo '<li class="' . esc_attr( $feature_tab_class ) . '">';
            echo '<a href="' . esc_url( $tab_info['url'] ) . '" target="'. esc_attr( $target ) .'">';
            echo $tab_info['label'];
            echo '</a>';
            if( ! empty( $tab_info['image'] ) ){
                echo '<img src="' . esc_url( $tab_info['image'] ) . '" />';
            }
            echo '</li>';
        }

        echo '</ul>';
        echo '</nav>';
    }

    /**
     * Start rendering the about page
     *
     * @return void
     */
    public function render(){

        $tab = $this->current_tab();
        ?>
        <div class="wrap aux-welcome aux-welcome-page-<?php echo esc_attr( $tab ); ?>">
            <div class="aux-welcome-inner">
                <?php do_action( 'auxin_admin_welcome_before_header' ); ?>
                <?php $this->the_header( $tab ); ?>
                <?php do_action( 'auxin_admin_welcome_after_header' ); ?>
                <?php $this->the_nav( $tab ); ?>
                <?php $this->the_content( $tab ); ?>
            </div>
        </div>
        <?php
    }

    /**
     * Retrieves or validate the current tab
     *
     * @param  string $tab_id    The tab id
     * @return string|array      Returns the current tab if $tab_id is empty.
     */
    protected function current_tab( $tab_id = '' ){
        $tab  = ! empty( $_GET['tab'] ) ? sanitize_key( $_GET['tab'] ) : '';
        $sec  = $this->get_sections();
        // Return on empty
        if( empty( $sec ) ){
            return;
        }
        $tab  = in_array( $tab, array_keys( $sec ) ) ? $tab : array_keys( $sec )[0];

        if( empty( $tab_id ) ){
            return $tab;
        } else {
            return $tab === $tab;
        }
    }

    /**
     * Retrieves the welcome page relative tab path
     *
     * @return string     Page and tab relative path
     */
    public function get_page_rel_tab( $tab ){
        return $this->get_page_rel_path() . '&tab=' . $tab;
    }

    /**
     * Retrieves the welcome page relative path
     *
     * @return string     Page relative path
     */
    public function get_page_rel_path(){
        return 'themes.php?page=' . $this->page_slug;
    }

    /**
     * Retrieves the welcome page url
     *
     * @return string     Page url
     */
    public function get_page_link(){
        return self_admin_url( $this->get_page_rel_path() );
    }

    /**
     * Retrieves the welcome tab url
     *
     * @return string     Page url
     */
    public function get_tab_link( $tab = '' ){
        return esc_url( $this->get_page_link() . ( $tab ? '&tab=' . $tab : '') );
    }

    /**
     * Add update bubble to theme admin menu
     *
     * @param  string $theme_menu_label The theme menu label
     * @return string                   The theme menu label
     */
    public function menu_badge_count( $theme_menu_args ){
        if( $update_count = apply_filters( 'auxin_theme_menu_update_count', 0 ) ){
            $theme_menu_args['name'] .= sprintf(' <span class="update-plugins count-%1$s"><span class="update-count">%1$s</span></span>', $update_count );
        }
        return $theme_menu_args;
    }

    /**
     * Render tab content
     *
     * @return void
     */
    protected function the_content( $type ){

        $sections = $this->get_sections();
        if( empty( $sections ) ){
            return;
        }

        do_action( 'auxin_admin_before_welcome_section_content', $type, $sections );

        if( ! empty( $sections[ $type ]['callback'] ) ){
            if( is_string( $sections[ $type ]['callback'] ) ){

                if( method_exists( $this, $sections[ $type ]['callback'] ) ){
                    call_user_func( array( $this, $sections[ $type ]['callback'] ) );
                }
                if( function_exists( $sections[ $type ]['callback'] ) ){
                    call_user_func( $sections[ $type ]['callback'] );
                }
            } elseif( is_array( $sections[ $type ]['callback'] ) ){
                if( is_callable( $sections[ $type ]['callback'] ) ){
                    call_user_func( $sections[ $type ]['callback'] );
                }
            }
        }

        $auto_method_name = 'content_'.$type;
        if( method_exists( $this, $auto_method_name ) ){
            $this->$auto_method_name();
        }

        do_action( 'auxin_admin_after_welcome_section_content', $type, $sections );
    }

}
