<?php
/**
 * Single Template Hooks
 *
 * Action and filter hooks that modify the
 * way the single template is rendered.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Single Post Header
 *
 * Includes the single header template part.
 *
 * @since 0.1.0
 */
function zki_ht_single_entry_header() : void {
	if ( is_single() ) {
		get_template_part( 'partials/single/single', 'header' );
	}
}
add_action( 'tha_entry_top', 'zki_ht_single_entry_header' );

/**
 * Single Post Footer
 *
 * Includes the single footer template part.
 *
 * @since 0.1.0
 */
function zki_ht_single_entry_footer() : void {
	if ( is_single() ) {
		get_template_part( 'partials/single/single', 'footer' );
	}
}
add_action( 'tha_entry_content_after', 'zki_ht_single_entry_footer' );

/**
 * Single Entry Navigation
 *
 * Includes the single post navigation template part.
 *
 * @since 0.1.0
 */
function zki_ht_single_entry_nav() : void {
	if ( is_single() ) {
		get_template_part( 'partials/single/single', 'navigation' );
	}
}
add_action( 'tha_entry_bottom', 'zki_ht_single_entry_nav' );
