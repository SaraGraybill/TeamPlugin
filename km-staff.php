<?php
/**
 * Plugin Name: Kinder Mission Staff
 * Plugin URI:  https://graybillcreative.com/
 * Description: Creates a staff custom post type.
 * Author:      Graybill Creative
 * Author URI:  https://graybillcreative.com/
 * Text Domain: km-staff
 * Version:     1.0.0
 *
 * The main plugin file.
 *
 * This plugin is released under the GPLv2 license. The images packaged with this plugin are the property of
 * their respective owners, and do not, necessarily, inherit the GPLv2 license.
 */

class KM_Staff {
	/**
	 * @var KM_Staff The one true KM_Staff.
	 * @since 1.0.0
	 */
	private static $instance;

	/**
	 * KM_Staff Instance.
	 *
	 * Insures that only one instance of KM_Staff exists in memory at any one
	 * time. Also prevents needing to define globals all over the place.
	 *
	 * @since 1.0.0
	 * @static
	 * @staticvar array $instance
	 * @uses KM_Staff::setup_constants() Setup the constants needed.
	 * @uses KM_Staff::includes() Include the required files.
	 * @see  KM_Staff()
	 * @return object|KM_Staff The one true KM_Staff
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof KM_Staff ) ) {
			self::$instance = new KM_Staff;
			self::$instance->setup_constants();
			self::$instance->includes();
		}

		return self::$instance;
	}

	/**
	 * Setup plugin constants.
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function setup_constants() {
		// Plugin version.
		define( 'KM_STAFF_VERSION', '1.0.2' );

		// Plugin Folder Path.
		define( 'KM_STAFF_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Folder URL.
		define( 'KM_STAFF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Root File.
		define( 'KM_STAFF_PLUGIN_FILE', __FILE__ );
	}


	/**
	 * Include required files.
	 *
	 * @access private
	 * @since 1.0.0
	 * @return void
	 */
	private function includes() {
		require_once KM_STAFF_PLUGIN_DIR . 'includes/class-ajax-filter.php';
		require_once KM_STAFF_PLUGIN_DIR . 'includes/class-frontend-scripts.php';
		require_once KM_STAFF_PLUGIN_DIR . 'includes/class-post-type.php';
		require_once KM_STAFF_PLUGIN_DIR . 'includes/class-shortcode.php';
	}

}

/**
 * The main function for that returns KM_Staff.
 *
 * The main function responsible for returning the one true KM_Staff
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $kms = KMS(); ?>
 *
 * @since 1.0.0
 * @return object|KM_Staff The one true KM_Staff Instance.
 */
function KMS() {
	return KM_Staff::instance();
}

// Get KMS Running.
KMS();