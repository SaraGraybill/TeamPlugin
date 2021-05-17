<?php
/**
 * Handle frontend scripts
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Frontend Scripts class.
 */
class KM_Staff_Frontend_Scripts  {
	/**
	 * Init scripts.
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'register_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'register_styles' ] );
	}

 	/**
	 * Register scripts.
	 */
	public static function register_scripts() {
		$scripts_uri = KM_STAFF_PLUGIN_URL . 'assets/scripts/';

		wp_register_script(
			'kms-script',
			"{$scripts_uri}kms-script.js",
			['jquery'],
			KM_STAFF_VERSION
		);

		wp_localize_script( 'kms-script', 'filter_vars',
			[
				'filter_nonce'    => wp_create_nonce( 'filter_nonce' ),
				'filter_ajax_url' => admin_url( 'admin-ajax.php' ),
			]
		);
	}

 	/**
	 * Register styles.
	 */
	public static function register_styles() {
		$styles_uri = KM_STAFF_PLUGIN_URL . 'assets/styles/';

		wp_register_style(
			'kms-style',
			"{$styles_uri}kms-styles.css",
			[],
			KM_STAFF_VERSION
		);
	}
}

KM_Staff_Frontend_Scripts::init();