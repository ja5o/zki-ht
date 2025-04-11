<?php
/**
 * Template Tags
 *
 * @package    ZKI HT
 * @since      0.1.0
 **/

/**
 * Print Comments
 *
 * Displays the comments template if required.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_print_comments() : void {
	if ( comments_open() && ! post_password_required() ) {
		comments_template();
	}
}

/**
 * Site Branding
 *
 * Includes the site branding template part.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_site_branding() : void {
	get_template_part( 'partials/site', 'branding' );
}
