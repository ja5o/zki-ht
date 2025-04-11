<?php
/**
 * Theme Block Areas
 *
 * Block Areas are sections of the site that will hold
 * sections content that will be later displayed on
 * specific parts of the site relying on hooks.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Register Block Area Post Type
 *
 * Register the Block Area post type, this post type
 * will use the block editor to create its content
 * and will be shown on specific hooks.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_register_block_area_pt() : void {
	$labels = [
		'name'               => __( 'Block Areas', 'zki-ht' ),
		'singular_name'      => __( 'Block Area', 'zki-ht' ),
		'add_new'            => __( 'Add New', 'zki-ht' ),
		'add_new_item'       => __( 'Add New Block Area', 'zki-ht' ),
		'edit_item'          => __( 'Edit Block Area', 'zki-ht' ),
		'new_item'           => __( 'New Block Area', 'zki-ht' ),
		'view_item'          => __( 'View Block Area', 'zki-ht' ),
		'search_item'        => __( 'Search Block Areas', 'zki-ht' ),
		'not_found'          => __( 'No Block Areas found', 'zki-ht' ),
		'not_found_in_trash' => __( 'No Block Areas found in trash', 'zki-ht' ),
		'parent_item_colon'  => __( 'Parent Block Area:', 'zki-ht' ),
		'menu_name'          => __( 'Block Areas', 'zki-ht' ),
	];

	$args = [
		'labels'              => $labels,
		'hierarchical'        => false,
		'supports'             => [ 'title', 'editor', 'revision', 'custom-fields' ],
		'public'              => false,
		'publicly_queryable'  => false,
		'show_ui'             => true,
		'show_in_rest'        => true,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => false,
		'menu-icon'           => 'dashicons-layout',
		'show_in_menu'        => 'themes.php',
	];

	register_post_type( 'block_area', $args );
}
add_action( 'init', 'zki_ht_register_block_area_pt' );

/**
 * Register Block Areas Post Meta
 *
 * Register Hook Name and Priority Post Meta for
 * Block Area Post Type.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_register_block_area_post_meta() : void {
	register_post_meta(
		'block_area',
		'block_area_hook',
		[
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string'
		]
	);

	register_post_meta(
		'block_area',
		'block_area_priority',
		[
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string'
		]
	);
}
add_action( 'init', 'zki_ht_register_block_area_post_meta', 20 );

/**
 * Get Registered Block Areas
 *
 * Get available Block Area Elements created on the site,
 * and cache them for better performance.
 *
 * @param boolean $force_refresh
 */
function zki_ht_get_block_area_elements(bool $force_refresh = false ) {
	// Check for the block_area_elements key in the 'block_areas' group.
	$block_area_elements = wp_cache_get( 'zki_ht_block_area_elements', 'block_areas' );

	// If nothing is found, build the object.
	if ( true === $force_refresh || false === $block_area_elements ) {
		// Get the Block Area Elements.
		$block_area_elements = new WP_Query(
			[
				'post_type'              => 'block_area',
				'posts_per_page'         => 500,
				'post_status'            => 'publish',
				'no_found_rows'          => true,
				'update_post_term_cache' => false,
			]
		);

		if ( ! is_wp_error( $block_area_elements ) && $block_area_elements->have_posts() ) {
			// Since we are refreshing on each Block Area save, we don't need a timed cache expiration.
			wp_cache_set( 'zki_ht_block_area_elements', $block_area_elements->posts, 'block_areas' );
		}
	}

	return $block_area_elements;
}

/**
 * Refresh Block Areas Cache
 *
 * Refresh the Block Areas cache when a new Block Area
 * is created or updated.
 *
 * @since 0.1.0
 * @param integer $post_id
 * @param WP_Post $post
 * @param boolean $update
 * @return void
 */
function zki_ht_refresh_block_areas( int $post_id, WP_Post $post, bool $update ) {
	// Return early if this is an autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Return early if this a draft.
	if ( 'auto-draft' === $post->post_status || 'draft' === $post->post_status ) {
		return;
	}

	zki_ht_get_block_area_elements( true );
}
add_action( 'save_post_block_area', 'zki_ht_refresh_block_areas', 10, 3 );

/**
 * Set Block Area Action Hooks
 *
 * Loops through all the registered block areas
 * and set them on their respective hooks
 * based on their post meta.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_add_block_area_actions() : void {
	$block_area_elements = zki_ht_get_block_area_elements();

	if ( $block_area_elements->have_posts() ) {
		while ( $block_area_elements->have_posts() ) {
			$block_area_elements->the_post();
			global $post;
			$element_meta = get_post_meta( $post->ID );

			if ( isset( $element_meta['block_area_hook'] ) && ! empty( $element_meta['block_area_hook'][0] ) ) {
				add_action( $element_meta['block_area_hook'][0], function() use ( $post ) {
					echo apply_filters( 'the_content', $post->post_content );
				}, $element_meta['block_area_priority'][0] );
			}
		}
		wp_reset_postdata();
	}
}
add_action( 'init', 'zki_ht_add_block_area_actions' );

/**
 * Register Block Area Editor Screen Sidebars
 *
 * Enqueues the Block Area editor sidebar that will hold
 * the fields for hook name and priority post meta.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_sidebar_editor_scripts() : void {
	$sidebar_script = require_once get_theme_file_path( 'build/js/block-areas.asset.php' );
	wp_enqueue_script(
		'block-areas-editor',
		get_theme_file_uri( 'build/js/block-areas.js' ),
		$sidebar_script['dependencies'],
		$sidebar_script['version'],
		true
	);

	wp_set_script_translations( 'block-areas-editor', 'zki-ht' );
}
add_action( 'enqueue_block_editor_assets', 'zki_ht_sidebar_editor_scripts' );
