<?php
/**
 * Theme Asset Loader
 *
 * Contains all the specific styles and scripts used for this theme.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Load Admin Scripts
 *
 * Loads Scripts that will be used inside the Admin pages
 * (e.g. settings pages, post type edit screen, etc.).
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_admin_assets() : void {
	$admin_script = require_once get_theme_file_path( 'build/js/admin.asset.php' );
	wp_enqueue_script(
		'theme-admin',
		get_theme_file_uri( 'build/js/admin.js' ),
		$admin_script['dependencies'],
		$admin_script['version'],
		true
	);

	$admin_style = require_once get_theme_file_path( 'build/css/admin.asset.php' );
	wp_enqueue_style(
		'theme-admin',
		get_theme_file_uri( 'build/css/admin.css' ),
		[],
		$admin_style['version']
	);
}
add_action( 'admin_enqueue_scripts', 'zki_ht_admin_assets' );

/**
 * Load Front-end Scripts
 *
 * Loads Scripts that will be used on the public
 * facing part of the site.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_frontend_assets() : void {
	$navigation_script = require_once get_theme_file_path( 'build/js/navigation.asset.php' );
	wp_enqueue_script(
		'theme-navigation',
		get_theme_file_uri( 'build/js/navigation.js' ),
		$navigation_script['dependencies'],
		$navigation_script['version'],
		true
	);

	wp_set_script_translations( 'theme-navigation', 'zki-ht' );

	$fe_script = require_once get_theme_file_path( 'build/js/frontend.asset.php' );
	wp_enqueue_script(
		'theme-scripts',
		get_theme_file_uri( 'build/js/frontend.js' ),
		$fe_script['dependencies'],
		$fe_script['version'],
		[
			'strategy' => 'defer',
			'in_footer' => true,
		]
	);

	$fe_style = require_once get_theme_file_path( 'build/css/frontend.asset.php' );
	wp_enqueue_style(
		'theme-styles',
		get_theme_file_uri( 'build/css/frontend.css' ),
		[],
		$fe_style['version'],
	);
}
add_action( 'wp_enqueue_scripts', 'zki_ht_frontend_assets' );
