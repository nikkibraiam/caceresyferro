<?php
/**
 * Plugin Name: RealHomes Demo Import
 * Plugin URI: http://themeforest.net/item/real-homes-wordpress-real-estate-theme/5373914
 * Description: Import RealHomes demo contents with one click.
 * Version: 1.1.0
 * Author: InspiryThemes
 * Author URI: https://themeforest.net/user/inspirythemes/portfolio?order_by=sales
 * Text Domain: realhomes-demo-import
 * Domain Path: /languages
 *
 * @package realhomes-demo-import
 */

// Block direct access to the main plugin file.
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Main plugin class with initialization tasks.
 */
class RHDI_Plugin {
	/**
	 * Constructor for this class.
	 */
	public function __construct() {

		/**
		 * Deactivate the OneClickDemoImport plugin if it's activated.
		 */
		add_action( 'admin_init', array( $this, 'deactivate_ocdi_plugin' ) );

		/**
		 * Display admin error message if PHP version is older than 5.3.2.
		 * Otherwise execute the main plugin class.
		 */
		if ( version_compare( phpversion(), '5.3.2', '<' ) ) {
			add_action( 'admin_notices', array( $this, 'old_php_admin_error_notice' ) );
		}
		else {
			// Set plugin constants.
			$this->set_plugin_constants();

			// Import demos configuration.
			require_once RHDI_PATH . 'demos/demos-config.php';

			// Composer autoloader.
			require_once RHDI_PATH . 'vendor/autoload.php';

			// Instantiate the main plugin class *Singleton*.
			$pt_one_click_demo_import = OCDI\RealHomesDemoImport::get_instance();

			// Register WP CLI commands
			if ( defined( 'WP_CLI' ) && WP_CLI ) {
				WP_CLI::add_command( 'rhdi list', array( 'OCDI\WPCLICommands', 'list_predefined' ) );
				WP_CLI::add_command( 'rhdi import', array( 'OCDI\WPCLICommands', 'import' ) );
			}
		}
	}

	/**
	 * Deactivate the OneClickDemoImport plugin if it's activated.
	 */
	public function deactivate_ocdi_plugin() {
		if ( is_plugin_active( 'one-click-demo-import/one-click-demo-import.php' ) ) {
			deactivate_plugins( 'one-click-demo-import/one-click-demo-import.php' );
			add_action( 'admin_notices', array( $this, 'admin_notice_ocdi_deactivated' ) );
		}
	}

	/**
	 * Display the OCDI plugin deactivation notice.
	 */
	public function admin_notice_ocdi_deactivated() {
		$class   = 'notice notice-error';
		$message = sprintf( esc_html__( '%1$sOne Click Demo Import%2$s plugin has been deactivated to avoid any conflict with %1$sRealHomes Demo Import%2$s plugin.', 'rhdi' ), '<strong>', '</strong>' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
	}

	/**
	 * Display an admin error notice when PHP is older the version 5.3.2.
	 * Hook it to the 'admin_notices' action.
	 */
	public function old_php_admin_error_notice() {
		$message = sprintf( esc_html__( 'The %2$sRealHomes Demo Import%3$s plugin requires %2$sPHP 5.3.2+%3$s to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.%4$s Your current version of PHP: %2$s%1$s%3$s', 'rhdi' ), phpversion(), '<strong>', '</strong>', '<br>' );

		printf( '<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post( $message ) );
	}


	/**
	 * Set plugin constants.
	 *
	 * Path/URL to root of this plugin, with trailing slash and plugin version.
	 */
	private function set_plugin_constants() {
		// Path/URL to root of this plugin, with trailing slash.
		if ( ! defined( 'RHDI_PATH' ) ) {
			define( 'RHDI_PATH', plugin_dir_path( __FILE__ ) );
		}
		if ( ! defined( 'RHDI_URL' ) ) {
			define( 'RHDI_URL', plugin_dir_url( __FILE__ ) );
		}

		// Action hook to set the plugin version constant.
		add_action( 'admin_init', array( $this, 'set_plugin_version_constant' ) );
	}


	/**
	 * Set plugin version constant -> RHDI_VERSIONS.
	 */
	public function set_plugin_version_constant() {
		if ( ! defined( 'RHDI_VERSIONS' ) ) {
			$plugin_data = get_plugin_data( __FILE__ );
			define( 'RHDI_VERSIONS', $plugin_data['Version'] );
		}
	}
}

// Instantiate the plugin class.
$RHDI_Plugin = new RHDI_Plugin();
