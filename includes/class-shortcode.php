<?php
/**
 * Register Shortcode
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shortcode class.
 */
class KM_Staff_Shortcode {
	/**
	 * Init shortcode.
	 */
	public static function init() {
		add_shortcode( 'staff_grid', [ __CLASS__, 'staff_grid' ] );
	}

 	/**
	 * Add shortcode.
	 */
	public static function staff_grid() {
		// Load scripts.
		wp_enqueue_script( 'kms-script' );

		// Load styles.
		wp_enqueue_style( 'kms-style' );

		$args = [
			'post_type'              => KM_Staff_Post_Type::$post_type_name,
			'posts_per_page'         => '100', // Reasonable upper limit.
			'ignore_sticky_posts'    => true,
			'no_found_rows'          => true,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		];

		$staff = new WP_Query( $args );

		// Start output buffering
		ob_start();

		if ( $staff->have_posts() ) :

			$locations = get_terms( KM_Staff_Post_Type::$taxonomy_name );

			if ( $locations ) :
				echo '<div class="staff-grid__filter">';
				echo '<span>Filter by location:</span>';

				/**
				 * Link for all staff.
				 *
				 * We pass an empty string in the "title" value as it's used to filter staff
				 * and since it's empty, all staff will be returned.
				 *
				 * @see KM_Staff_Ajax_Filter line 51.
				 */
				printf( '<a class="staff-grid__filter__link selected" title="" href="#">%s</a>',
					esc_html( 'All' )
				);

				foreach ( $locations as $location ) :

					printf( '<a class="staff-grid__filter__link" title="%s" href="%s">%s</a>',
						esc_attr( $location->slug ),
						get_term_link( $location ),
						esc_html( $location->name )
					);


				endforeach;

				echo '</div>';

			endif;

			echo '<div class="staff-grid">';

				while ( $staff->have_posts() ) :

					$staff->the_post();

					require KM_STAFF_PLUGIN_DIR . 'templates/shortcode-staff-grid.php';

				endwhile;

				wp_reset_postdata();

			echo '</div>';

			echo '<div class="staff-grid__loading">';
				echo '<img src="' . KM_STAFF_PLUGIN_URL . 'assets/images/loading.gif">';
			echo '</div>';

		endif;

		// Return buffered output
		return ob_get_clean();

	}
}

KM_Staff_Shortcode::init();