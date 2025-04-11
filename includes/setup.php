<?php
/**
 * Theme Setup
 *
 * Contains functions, actions, and filters related to
 * theme setup functionalities and supports.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Theme setup
 *
 * Declares theme support for various WordPress features.
 * @since 0.1.0
 * @return void
 */
function zki_ht_theme_setup() : void {
	load_theme_textdomain( 'zki-ht', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'meta',
		'style',
		'script',
		'navigation-widgets'
	) );

	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 860;
	}

	$custom_logo_defs = [
		'height'               => 100,
		'width'                => 400,
		'flex-height'          => true,
		'flex-width'           => true,
	];
	add_theme_support( 'custom-logo', $custom_logo_defs );
}
add_action( 'after_setup_theme', 'zki_ht_theme_setup' );

/**
 * Navigation Menus
 *
 * Registers theme navigation locations.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_navigation_menus() : void {
	register_nav_menus(
		[
			'main-menu' => esc_html__( 'Main Menu', 'zki-ht' ),
		]
	);
}
add_action( 'after_setup_theme', 'zki_ht_navigation_menus' );

/**
 * Image Sizes
 *
 * Registers custom theme image sizes.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_image_sizes() : void {
	add_image_size( 'fullhd', 1920 );
}
add_action( 'after_setup_theme', 'zki_ht_image_sizes' );

/**
 * Disable scaling of big images.
 *
 * @since 0.1.0
 * @return false
 */
add_filter( 'big_image_size_threshold', '__return_false' );

/**
 * Unset Image Sizes
 *
 * Remove some of the larger default WordPress image sizes.
 *
 * @since 0.1.0
 * @param array $sizes Associative array of image sizes to be created.
 * @return array
 */
function zki_ht_image_insert_override( array $sizes ) : array {
	unset( $sizes['medium_large'] );
	unset( $sizes['1536x1536'] );
	unset( $sizes['2048x2048'] );
	return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'zki_ht_image_insert_override' );

/**
 * Pingback link
 *
 * Adds pingback link to header if is a singular template and
 * the pings feature is active.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_pingback_header() : void {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'zki_ht_pingback_header' );

/**
 * Remove Excerpt More Link
 *
 * Removes the link since we are making the
 * whole container a link to the post.
 *
 * @since 0.1.0
 * @param string $more The string shown within the more link.
 * @return string
 */
function zki_ht_excerpt_more( string $more ) : string {
	return '';
}
add_filter('excerpt_more', 'zki_ht_excerpt_more');

/**
 * Disable Block Editor
 *
 * Disables the block editor (gutenberg) for specific post types.
 *
 * @since 0.1.0
 * @param bool   $current_status Whether the post type can be edited or not.
 * @param string $post_type      The post type being checked.
 * @return bool
 */
function zki_ht_disable_block_editor_for_posttypes( bool $current_status, string $post_type ) : bool {
	$disabled_post_types = [];

	if ( in_array( $post_type, $disabled_post_types ) ) {
		return false;
	}

	return $current_status;
}
add_filter( 'use_block_editor_for_post_type', 'zki_ht_disable_block_editor_for_posttypes', 10, 2 );
