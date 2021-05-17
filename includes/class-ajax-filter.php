<?php
/**
 * Handle Ajax Filter
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ajax Filter class.
 */
class KM_Staff_Ajax_Filter  {
	/**
	 * Init ajax filter.
	 */
	public static function init() {
		add_action( 'wp_ajax_filter_staff', [ __CLASS__, 'filter_staff' ] );
		add_action( 'wp_ajax_nopriv_filter_staff', [ __CLASS__, 'filter_staff' ] );
	}

	/**
	 * Filter staff member based on the location selection.
	 */
	public static function filter_staff() {

		// Verify nonce
		if ( ! isset( $_POST['filter_nonce'] ) || ! wp_verify_nonce( $_POST['filter_nonce'], 'filter_nonce' ) ) {
			die( 'Permission denied' );
		}

		$taxonomy = sanitize_text_field( $_POST['location'] );

		$args = [
			'post_type'              => KM_Staff_Post_Type::$post_type_name,
			'posts_per_page'         => '100', // Reasonable upper limit.
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'tax_query'              => [
				[
					'taxonomy' => KM_Staff_Post_Type::$taxonomy_name,
					'field'    => 'slug',
					'terms'    => $taxonomy,
				]
			],
		];

		// If taxonomy is not set, remove key from array and get all staff
		if ( ! $taxonomy ) {
			unset( $args['tax_query'] );
		}

		$query = new \WP_Query( $args );

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();

			$result['response'][] = self::staff_get_template_part();
			$result['status'] = 'success';

			endwhile;
		else:

			$result['response'] = '<h2>No staff found</h2>';
			$result['status']   = '404';

		endif;

		$result = json_encode( $result );
		echo $result;

		die();
	}

	/**
	 * Helper function to retrieve staff template part.
	 */
	public static function staff_get_template_part() {

		ob_start();
		require KM_STAFF_PLUGIN_DIR . 'templates/shortcode-staff-grid.php';
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}

KM_Staff_Ajax_Filter::init();