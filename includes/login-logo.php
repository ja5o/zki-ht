<?php
/**
 * Login Logo
 *
 * Login screen related functions.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Change Logo URL
 *
 * Changes the destination url for the login header logo
 * to the site home url.
 *
 * @since 0.1.0
 * @return string
 */
function zki_ht_login_header_url(): string {
	return esc_url( home_url() );
}
add_filter( 'login_headerurl', 'zki_ht_login_header_url' );

/**
 * Login Header Text
 *
 * Replaces the accessible logo text in the login page.
 *
 * @since 0.1.0
 * @return string
 */
function zki_ht_login_headertext() : string {
	return sprintf(
		_x( 'Go back to %s', 'Accessible text for login header text', 'zki-ht' ),
		get_bloginfo( 'name' )
	);
}
add_filter( 'login_headertext', 'zki_ht_login_headertext' );

/**
 * Print the Site Logo in Login Page
 *
 * Outputs the custom site logo on the login screen, if one is available.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_login_logo() : void {
	$custom_logo = (int) get_theme_mod( 'custom_logo' );

	if ( ! $custom_logo ) {
		return;
	}

	$logo = wp_get_attachment_image_src( $custom_logo, 'large' );
	$logo = $logo[0];

	$styles = sprintf(
		'<style>
		.login h1 a {
			background-image: url(%s);
			background-size: contain;
			background-repeat: no-repeat;
			background-position: center;
			display: block;
			overflow: hidden;
			text-indent: -9999em;
			width: auto;
			height: 84px;
		}
		</style>',
		esc_url( $logo )
	);
	echo $styles;
}
add_action( 'login_head', 'zki_ht_login_logo' );
