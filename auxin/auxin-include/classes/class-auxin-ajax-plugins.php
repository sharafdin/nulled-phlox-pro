<?php

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;

/**
 * Auxin_Ajax_Plugins class
 */
class Auxin_Ajax_Plugins {

	/**
	 * TGMPA instance storage
	 *
	 * @var object
	 */
	protected $tgmpa_instance;

	/**
	 * TGMPA Menu slug
	 *
	 * @var string
	 */
	protected $tgmpa_menu_slug 	= 'tgmpa-install-plugins';

	/**
	 * TGMPA Menu url
	 *
	 * @var string
	 */
	protected $tgmpa_url 		= 'themes.php?page=tgmpa-install-plugins';

    /**
     * Plugin filters
     *
     * @var array
     */
    protected $plugin_filters   = array();

    /**
     * Current theme slug
     *
     * @var string
     */
    protected $theme_id = '';


	/**
	 * Holds the current instance of the theme manager
	 *
	 */
	protected static $instance 	= null;

	/**
	 * Retrieves class instance
	 *
	 * @return Auxin_Ajax_Plugins
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance 	= new self;
		}

		return self::$instance;
	}


	/**
	 * Constructor
	 */
	public function __construct() {
        
        $this->theme_id  = THEME_ID;
		$this->init_actions();
	}

	/**
	 * Setup the hooks, actions and filters.
	 *
	 */
	public function init_actions() {

		if ( current_user_can( 'manage_options' ) ) {


			if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
				add_action( 'init'					, array( $this, 'get_tgmpa_instanse' ), 30 );
				add_action( 'init'					, array( $this, 'set_tgmpa_url' ), 40 );
			}

            // add_action( 'admin_enqueue_scripts'		, array( $this, 'enqueue_scripts' ) );
            add_filter( 'tgmpa_load'				, array( $this, 'tgmpa_load' ), 10, 1 );
            add_action( 'wp_ajax_aux_setup_plugins'	, array( $this, 'ajax_plugins' ) );

			if( isset( $_POST['action'] ) && $_POST['action'] === "aux_setup_plugins" && wp_doing_ajax() ) {
				add_filter( 'wp_redirect', '__return_false', 999 );
			}
		}
	}
	/**
	 * Enqueue admin scripts
	 *
	 */
	public function enqueue_scripts() {}

    /**
     * Check for TGMPA load
     *
     */
	public function tgmpa_load( $status ) {
		return is_admin() || current_user_can( 'install_themes' );
	}

	/**
	 * Get configured TGMPA instance
	 *
	 */
	public function get_tgmpa_instanse() {
		$this->tgmpa_instance 	= call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
	}

	/**
	 * Update $tgmpa_menu_slug and $tgmpa_parent_slug from TGMPA instance
	 *
	 */
	public function set_tgmpa_url() {
		$this->tgmpa_menu_slug 	= ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
		$this->tgmpa_menu_slug 	= apply_filters( $this->theme_id . '_theme_setup_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug );

		$tgmpa_parent_slug 		= ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && $this->tgmpa_instance->parent_slug !== 'themes.php' ) ? 'admin.php' : 'themes.php';

		$this->tgmpa_url 		= apply_filters( $this->theme_id . '_theme_setup_wizard_tgmpa_url', $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug );
	}

	/**
	 * Output the tgmpa plugins list
	 */
	private function get_plugins( $custom_list = array() ) {

		$plugins  = array(
			'all'      => array(), // Meaning: all plugins which still have open actions.
			'install'  => array(),
			'update'   => array(),
			'activate' => array(),
        );

		foreach ( $this->tgmpa_instance->plugins as $slug => $plugin ) {

			if( ! empty( $custom_list ) && ! in_array( $slug, $custom_list ) ){
				// This condition is for custom requests lists
				continue;
			} elseif( $this->tgmpa_instance->is_plugin_active( $slug ) && false === $this->tgmpa_instance->does_plugin_have_update( $slug ) ) {
				// No need to display plugins if they are installed, up-to-date and active.
				continue;
			} else {
				$plugins['all'][ $slug ] = $plugin;

				if ( ! $this->tgmpa_instance->is_plugin_installed( $slug ) ) {
					$plugins['install'][ $slug ] = $plugin;
				} else {

					if ( false !== $this->tgmpa_instance->does_plugin_have_update( $slug ) ) {
						$plugins['update'][ $slug ] = $plugin;
					}
					if ( $this->tgmpa_instance->can_plugin_activate( $slug ) ) {
						$plugins['activate'][ $slug ] = $plugin;
					}

				}
			}
		}

		return $plugins;
	}

	/**
	 * Plugins AJAX Process
	 */
	public function ajax_plugins() {
        // Inputs validations
		if ( ! check_ajax_referer( 'aux_setup_nonce', 'wpnonce' ) || ! isset( $_POST['slug'] ) || empty( $_POST['slug'] ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'No Slug Found', 'phlox-pro' ) ) );
		}
        $request = array();
        // send back some json we use to hit up TGM
        $plugins = $this->get_plugins();
		// what are we doing with this plugin?
		foreach ( $plugins['activate'] as $slug => $plugin ) {
			if ( $slug === 'related-posts-for-wp' ) {
				update_option( 'rp4wp_do_install', false );
			}
			if ( $_POST['slug'] == $slug ) {
				$request = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-activate',
					'action2'       => - 1,
					'message'       => esc_html__( 'Activating', 'phlox-pro' ),
				);
				break;
			}
		}
		foreach ( $plugins['update'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$request = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-update',
					'action2'       => - 1,
					'message'       => esc_html__( 'Updating', 'phlox-pro' ),
				);
				break;
			}
		}
		foreach ( $plugins['install'] as $slug => $plugin ) {
			if ( $_POST['slug'] == $slug ) {
				$request = array(
					'url'           => admin_url( $this->tgmpa_url ),
					'plugin'        => array( $slug ),
					'tgmpa-page'    => $this->tgmpa_menu_slug,
					'plugin_status' => 'all',
					'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
					'action'        => 'tgmpa-bulk-install',
					'action2'       => - 1,
					'message'       => esc_html__( 'Installing', 'phlox-pro' ),
				);
				break;
			}
		}

		if ( ! empty( $request ) ) {
			$request['hash'] = md5( serialize( $request ) ); // used for checking if duplicates happen, move to next plugin
			wp_send_json_success( $request );
		}

        wp_send_json_success( array( 'message' => esc_html__( 'Activated', 'phlox-pro' ) ) );

	}

}
