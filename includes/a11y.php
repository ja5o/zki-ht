<?php
/**
 * Accessibility
 *
 * Contains all functions related to accessibility features
 * that make the site more accessible for users.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

if ( ! function_exists( 'zki_skip_link' ) ) {
	/**
	 * Skip Link
	 *
	 * Adds skip link to beging of the page.
	 *
	 * @since 0.1.0
	 * @return void
	 */
	function zki_skip_link() : void {
		echo '<a href="#site-content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'zki' ) . '</a>';
	}
}
add_action( 'wp_body_open', 'zki_skip_link', 5 );
