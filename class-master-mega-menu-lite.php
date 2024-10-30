<?php
namespace JLTELMM;

use JLTELMM\Libs\Assets;
use JLTELMM\Libs\Helper;
use JLTELMM\Libs\Featured;
use JLTELMM\Inc\Classes\Recommended_Plugins;
use JLTELMM\Inc\Classes\Notifications\Notifications;
use JLTELMM\Inc\Classes\Pro_Upgrade;
use JLTELMM\Inc\Classes\Row_Links;
use JLTELMM\Inc\Classes\Upgrade_Plugin;
use JLTELMM\Inc\Classes\Feedback;
use JLTELMM\Inc\Addon\Mega_Menu_Nav;
use JLTELMM\Inc\Megamenu\JLTMA_Megamenu_Options;
use JLTELMM\Inc\Megamenu\JLTMA_Megamenu_Api;
use JLTELMM\Inc\Megamenu\JLTMA_Megamenu_Cpt;
use JLTELMM\Inc\Megamenu\JLTMA_Megamenu_Cpt_Api;

/**
 * Main Class
 *
 * @master-mega-menu-lite
 * Jewel Theme <support@jeweltheme.com>
 * @version     1.0.3
 */

// No, Direct access Sir !!!
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * JLE_Elementor_Mega_Menu Class
 */
if ( ! class_exists( '\JLTELMM\JLE_Elementor_Mega_Menu' ) ) {

	/**
	 * Class: JLE_Elementor_Mega_Menu
	 */
	final class JLE_Elementor_Mega_Menu {

		const VERSION            = JLTELMM_VER;

	    const MINIMUM_PHP_VERSION = '5.4';
	    
	    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

		private static $instance = null;

		/**
		 * what we collect construct method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function __construct() {
			$this->includes();
			add_action( 'plugins_loaded', array( $this, 'jltelmm_plugins_loaded' ), 999 );
			// Body Class.
			add_filter( 'admin_body_class', array( $this, 'jltelmm_body_class' ) );
			// This should run earlier .
			// add_action( 'plugins_loaded', [ $this, 'jltelmm_maybe_run_upgrades' ], -100 ); .


			
			new JLTMA_Megamenu_Api();
			new JLTMA_Megamenu_Cpt();
			new JLTMA_Megamenu_Cpt_Api();
			new JLTMA_Megamenu_Options();
			

			// Widget Register
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'jltelmm_megamenu_init_widgets' ] );

			//Register Controls
			add_action( 'elementor/controls/controls_registered'   , array( $this, 'jltelmm_register_controls' ) );
		}


		/**
		 * Master Mega Menu Navigation Addon
		 * 
		 */
		public function jltelmm_megamenu_init_widgets() {
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Mega_Menu_Nav() );	
		}


	    public function is_elementor_activated( $plugin_path = 'elementor/elementor.php' ){
	        $installed_plugins_list = get_plugins();
	        return isset( $installed_plugins_list[ $plugin_path ] );
	    }


		public function jltelmm_register_controls($controls_manager){

			$controls_manager = \Elementor\Plugin::$instance->controls_manager;

			$controls = array(
				'jltma-visual-select' => array(
					'file'  => JLTELMM_PATH . 'Inc/Megamenu/controls/visual-select.php',
					'class' => 'JLTELMM\Inc\Megamenu\Controls\JLTMA_Control_Visual_Select',
					'type'  => 'single'
				)
			);

			foreach ( $controls as $control_type => $control_info ) {
				if( ! empty( $control_info['file'] ) && ! empty( $control_info['class'] ) ){

					include_once( $control_info['file'] );

					if( class_exists( $control_info['class'] ) ){
						$class_name = $control_info['class'];
					} elseif( class_exists( __NAMESPACE__ . '\\' . $control_info['class'] ) ){
						$class_name = __NAMESPACE__ . '\\' . $control_info['class'];
					}

					if( $control_info['type'] === 'group' ){
						$controls_manager->add_group_control( $control_type, new $class_name() );
					} else {
						$controls_manager->register_control( $control_type, new $class_name() );
					}

				}
			}

		}

		/**
		 * plugins_loaded method
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltelmm_plugins_loaded() {


			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'jltelmm_megamenu_notice_missing_main_plugin' ) );
				return;
			}

			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'jltelmm_megamenu_notice_minimum_elementor_version' ) );
				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', array( $this, 'jltelmm_megamenu_notice_minimum_php_version' ) );
				return;
			}


			$this->jltelmm_activate();
		}


		/**
		 * Version Key
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function plugin_version_key() {
			return Helper::jltelmm_slug_cleanup() . '_version';
		}


		/**
		 * Activation Hook
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public static function jltelmm_activate() {
			$current_jltelmm_version = get_option( self::plugin_version_key(), null );

			if ( get_option( 'jltelmm_activation_time' ) === false ) {
				update_option( 'jltelmm_activation_time', strtotime( 'now' ) );
			}

			if ( is_null( $current_jltelmm_version ) ) {
				update_option( self::plugin_version_key(), self::VERSION );
			}

			$allowed = get_option( Helper::jltelmm_slug_cleanup() . '_allow_tracking', 'no' );

			// if it wasn't allowed before, do nothing .
			if ( 'yes' !== $allowed ) {
				return;
			}
			// re-schedule and delete the last sent time so we could force send again .
			$hook_name = Helper::jltelmm_slug_cleanup() . '_tracker_send_event';
			if ( ! wp_next_scheduled( $hook_name ) ) {
				wp_schedule_event( time(), 'weekly', $hook_name );
			}
		}


		public function jltelmm_megamenu_notice_missing_main_plugin() {
			$plugin = 'elementor/elementor.php';

			if ( $this->is_elementor_activated() ) {
				if ( ! current_user_can( 'activate_plugins' ) ) {
					return;
				}
				$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
				// $message = esc_html__( 'Master Mega Menu requires <b>', 'jltma' );
				$message = sprintf( esc_html__( 'Master Mega Menu requires %1$s"Elementor"%2$s plugin to be active. Please activate Elementor to continue.', 'jltma' ), '<strong>', '</strong>' );
				$button_text = esc_html__( 'Activate Elementor', 'jltma' );

			} else {
				if ( ! current_user_can( 'install_plugins' ) ) {
					return;
				}

				$activation_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
				$message = sprintf( esc_html__( 'Master Mega Menu requires %1$s"Elementor"%2$s plugin to be installed and activated. Please install Elementor to continue.', 'jltma' ), '<strong>', '</strong>' );
				$button_text = esc_html__( 'Install Elementor', 'jltma' );
			}

			$button = '<p><a href="' . esc_url_raw( $activation_url ) . '" class="button-primary">' . esc_html( $button_text ) . '</a></p>';

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p>%2$s</div>', $message , $button );

		}


		public function jltelmm_megamenu_notice_minimum_elementor_version() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'jltma' ),
				'<strong>' . esc_html__( 'Master Mega Menu', 'jltma' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'jltma' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

		public function jltelmm_megamenu_notice_minimum_php_version() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'jltma' ),
				'<strong>' . esc_html__( 'Master Mega Menu', 'jltma' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'jltma' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}


		/**
		 * Add Body Class
		 *
		 * @param [type] $classes .
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltelmm_body_class( $classes ) {
			$classes .= ' master-mega-menu-lite ';
			return $classes;
		}

		/**
		 * Run Upgrader Class
		 *
		 * @return void
		 */
		public function jltelmm_maybe_run_upgrades() {
			if ( ! is_admin() && ! current_user_can( 'manage_options' ) ) {
				return;
			}

			// Run Upgrader .
			$upgrade = new Upgrade_Plugin();

			// Need to work on Upgrade Class .
			if ( $upgrade->if_updates_available() ) {
				$upgrade->run_updates();
			}
		}

		/**
		 * Include methods
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function includes() {

	        // include JLTELMM_PATH . '/inc/cpt.php';
			// include JLTELMM_PATH . '/inc/rest-api.php';
	        // include JLTELMM_PATH . '/inc/api.php';		
			// include JLTELMM_PATH . '/inc/options.php';
			// include JLTELMM_PATH . '/inc/walker-nav-menu.php';
			// include JLTELMM_PATH . '/inc/cpt-api.php';


			new Assets();
			new Recommended_Plugins();
			new Row_Links();
			new Pro_Upgrade();
			new Notifications();
			new Featured();
			new Feedback();
		}


		/**
		 * Initialization
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltelmm_init() {
			$this->jltelmm_load_textdomain();
		}


		/**
		 * Text Domain
		 *
		 * @author Jewel Theme <support@jeweltheme.com>
		 */
		public function jltelmm_load_textdomain() {
			$domain = 'master-mega-menu-lite';
			$locale = apply_filters( 'jltelmm_plugin_locale', get_locale(), $domain );

			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, false, dirname( JLTELMM_BASE ) . '/languages/' );
		}
		
		
		

		/**
		 * Returns the singleton instance of the class.
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof JLE_Elementor_Mega_Menu ) ) {
				self::$instance = new JLE_Elementor_Mega_Menu();
				self::$instance->jltelmm_init();
			}

			return self::$instance;
		}
	}

	// Get Instant of JLE_Elementor_Mega_Menu Class .
	JLE_Elementor_Mega_Menu::get_instance();
}