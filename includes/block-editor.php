<?php
/**
 * Theme specific block editor compatibility functions
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Theme Supports
 *
 * Adds theme supports for block editor related features.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_block_editor_supports() : void {
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'block-template-parts' );
}
add_action( 'after_setup_theme', 'zki_ht_block_editor_supports' );

/**
 * Editor Scripts
 *
 * Loads scripts that modify the block editor experience.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_editor_scripts() : void {
	$editor_script = require_once get_theme_file_path( 'build/js/editor.asset.php' );
	wp_enqueue_script(
		'theme-editor',
		get_theme_file_uri( 'build/js/editor.js' ),
		array_merge( $editor_script['dependencies'], [ 'wp-blocks', 'wp-dom-ready' ]),
		$editor_script['version'],
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'zki_ht_editor_scripts' );

/**
 * Block Variations
 *
 * Enqueues script file that contains the theme block variations.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_block_variations() : void {
	$variations_assets = require_once get_theme_file_path( '/build/js/variations.asset.php' );

	wp_enqueue_script(
		'zki-ht-block-variations',
		get_theme_file_uri( '/build/js/variations.js' ),
		array_merge( $variations_assets['dependencies'], [ 'wp-blocks', 'wp-dom-ready', 'wp-element', 'wp-primitives' ] ),
		$variations_assets['version'],
		false
	);
}
add_action( 'enqueue_block_editor_assets', 'zki_ht_block_variations' );

/**
 * Block Filters
 *
 * Enqueues script file that contains the theme block filters.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_block_filters(): void {
	$filters_assets = require_once get_theme_file_path( '/build/js/filters.asset.php' );

	wp_enqueue_script(
		'zki-ht-block-filters',
		get_theme_file_uri( '/build/js/filters.js' ),
		array_merge( $filters_assets['dependencies'], [ 'wp-blocks', 'wp-dom-ready' ] ),
		$filters_assets['version'],
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'zki_ht_block_filters' );

/**
 * Editor Styles
 *
 * Load stylesheets into the block editor.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_editor_styles() : void {
	// Load styles only meant to be displayed on the block editor content.
	if ( is_admin() ) {
		wp_enqueue_style(
			'theme-editor',
			get_theme_file_uri( 'build/css/editor.css' ),
			[],
			wp_get_theme()->get( 'Version' )
		);
	}
}
add_action( 'enqueue_block_assets', 'zki_ht_editor_styles' );

/**
 * Filters whether block styles should be loaded separately
 *
 * Returning false loads all core block assets, regardless of whether they are rendered in a page or not
 * Returning true loads core block assets only when they are rendered.
 *
 * @link https://developer.wordpress.org/reference/hooks/should_load_separate_core_block_assets/
 *
 * @since 0.1.0
 * @return bool Always returns true.
 */
add_filter( 'should_load_separate_core_block_assets', '__return_true' );

/**
 * Filters whether block styles should be loaded on demand.
 *
 * Returning false loads all block assets, regardless of whether they are rendered in a page or not.
 * Returning true loads block assets only when they are rendered.
 *
 * This filter differs from should_load_separate_core_block_assets in that it does not take into account
 * the enqueueing of the wp-block-library stylesheet.
 *
 * @link https://developer.wordpress.org/reference/hooks/should_load_block_assets_on_demand/
 *
 * @since 0.1.1
 * @return bool Always returns true.
 */
add_filter( 'should_load_block_assets_on_demand', '__return_true' );

/**
 * Disable the remote patterns coming from the Dotorg pattern directory.
 *
 * @link https://developer.wordpress.org/themes/features/block-patterns/#disabling-remote-patterns
 *
 * @since 0.1.0
 * @return bool Always returns false.
*/
add_filter( 'should_load_remote_block_patterns', '__return_false' );

/**
 * Theme Block Category
 *
 * Registers a custom block category and places it
 * between the media and design core categories.
 *
 * @since 0.1.0
 * @param array $block_categories
 * @return array
 */
function zki_ht_register_block_category( array $block_categories ) : array {
	$new_categories = [
		[
			'slug' => 'zki-blocks',
			'title' => __( 'Theme Blocks', 'zki' ),
		]
	];
	array_splice( $block_categories, 2, 0, $new_categories );

	return $block_categories;
}
add_filter( 'block_categories_all', 'zki_ht_register_block_category' );

/**
 * Register Theme Blocks
 *
 * Registers all block folders found in 'build/blocks' directory.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_register_blocks() : void {
	$blocks = glob( get_theme_file_path() . '/build/blocks/*', GLOB_ONLYDIR );
	foreach ( $blocks as $block_folder ) {
		register_block_type( $block_folder );
	}
}
add_action( 'init', 'zki_ht_register_blocks' );

/**
 * Disable Core Blocks
 *
 * Disable core blocks on requested post types.
 *
 * @since 0.1.0
 * @param boolean|array $allowed_block_types Array of block type slugs, or boolean to enable/disable all
 * @param WP_Block_Editor_Context $block_editor_context The current block editor context.
 * @return boolean|array
 */
function zki_ht_disable_core_blocks( bool|array $allowed_block_types, WP_Block_Editor_Context $block_editor_context ): bool|array {
	// Disable for all.
	$disable_for_all = apply_filters( 'zki_disable_blocks_for_all', false );

	if ( $disable_for_all ) {
		return false;
	}

	/**
	 * List of disabled post types.
	 *
	 * Build the array in a format that encourage
	 * lookup for better performance.
	 *
	 * For example: [ 'page' => true ]
	*/
	$disable_for_post_types = [];

	// Allow addition of post types from 3rd party sources.
	$disable_for_post_types = apply_filters( 'zki_disable_blocks_for_post_types', $disable_for_post_types );

	// Get current post type.
	$current_post_type = $block_editor_context->post->post_type;
	// If post type is in the disable list, return no allowed blocks
	if ( isset( $disable_for_post_types[ $current_post_type ] ) ) {
		return false;
	}

	return $allowed_block_types;
}
add_filter( 'allowed_block_types_all', 'zki_ht_disable_core_blocks', 10, 2 );
