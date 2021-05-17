<?php
/**
 * Register Post Type
 *
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post Type class.
 */
class KM_Staff_Post_Type {
	/**
	 * Post type name.
	 *
	 * @var string
	 */
	public static $post_type_name = 'staff';

	/**
	 * Taxonomy name.
	 *
	 * @var string
	 */
	public static $taxonomy_name = 'staff_location';

	/**
	 * Init post type.
	 */
	public static function init() {
		add_action( 'init', [ __CLASS__, 'register_post_type' ], 0 );
		add_action( 'init', [ __CLASS__, 'register_taxonomy' ],  0 );
		add_filter( 'enter_title_here', [ __CLASS__, 'title_placeholder_text' ] );
		add_action( 'acf/init', [ __CLASS__, 'add_acf_fields' ] );

	}

	/**
	 * Register post type.
	 */
	public static function register_post_type() {

		$labels = [
			'name'                  => _x( 'Staff', 'Post Type General Name', 'km-staff' ),
			'singular_name'         => _x( 'Staff', 'Post Type Singular Name', 'km-staff' ),
			'menu_name'             => __( 'Staff', 'km-staff' ),
			'parent_item_colon'     => __( 'Parent Staff:', 'km-staff' ),
			'all_items'             => __( 'All Staff', 'km-staff' ),
			'view_item'             => __( 'View Staff', 'km-staff' ),
			'add_new_item'          => __( 'Add New Staff', 'km-staff' ),
			'add_new'               => __( 'Add New', 'km-staff' ),
			'edit_item'             => __( 'Edit Staff', 'km-staff' ),
			'update_item'           => __( 'Update Staff', 'km-staff' ),
			'search_items'          => __( 'Search Staff', 'km-staff' ),
			'not_found'             => __( 'Not found', 'km-staff' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'km-staff' ),
			'featured_image'        => __( 'Staff photo', 'km-staff' ),
			'set_featured_image'    => __( 'Set staff photo', 'km-staff' ),
			'remove_featured_image' => __( 'Remove staff photo', 'km-staff' ),
			'use_featured_image'    => __( 'Use as staff photo', 'km-staff' ),
		];

		$args = [
			'label'                 => __( 'staff', 'km-staff' ),
			'description'           => __( 'Staff CPT', 'km-staff' ),
			'labels'                => $labels,
			'supports'              => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_nav_menus'     => false,
			'show_in_admin_bar'     => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-admin-users',
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => false,
			'capability_type'       => 'page',
		];
		register_post_type( self::$post_type_name, $args );
	}

	/**
	 * Register taxonomy.
	 */
	public static function register_taxonomy() {

		$labels = [
			'name'                  => _x( 'Staff Locations', 'Taxonomy General Name', 'km-staff' ),
			'singular_name'         => _x( 'Staff Location', 'Taxonomy Singular Name', 'km-staff' ),
			'menu_name'             => __( 'Locations', 'km-staff' ),
			'all_items'             => __( 'All Locations', 'km-staff' ),
			'parent_item'           => __( 'Parent Location', 'km-staff' ),
			'parent_item_colon'     => __( 'Parent Location:', 'km-staff' ),
			'new_item_name'         => __( 'New Location', 'km-staff' ),
			'add_new_item'          => __( 'Add New Location', 'km-staff' ),
			'edit_item'             => __( 'Edit Location', 'km-staff' ),
			'update_item'           => __( 'Update Location', 'km-staff' ),
			'view_item'             => __( 'View Location', 'km-staff' ),
			'add_or_remove_items'   => __( 'Add or remove locations', 'km-staff' ),
		];

		$args = [
			'labels'                => $labels,
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'show_in_nav_menus'     => false,
			'show_tagcloud'         => false,
			'rewrite'               => false,
		];
		register_taxonomy( self::$taxonomy_name, self::$post_type_name, $args );
	}

	/**
	 * Change Title field placeholder text.
	 */
	function title_placeholder_text ( $title ) {
		if ( get_post_type() == 'staff' ) {
			$title = __( 'Enter staff name' );
		}
		return $title;
	}

	/**
	 * Register ACF fields.
	 */
	function add_acf_fields() {
		acf_add_local_field_group(
			[
				'key'             => 'group_1',
				'label_placement' => 'left',
				'title'           => 'Staff Information',
				'position'        => 'acf_after_title',
				'fields'          => [
					[
						'key'          => 'field_1',
						'label'        => 'Job Title',
						'name'         => 'kms_job_title',
						'type'         => 'text',
					]
				],
				'location' => [
					[
						[
							'param' => 'post_type',
							'operator' => '==',
							'value' => self::$post_type_name,
						],
					],
				],
			]
		);
	}
}

KM_Staff_Post_Type::init();