<?php
/**
 * Body Classes
 *
 * Contains filters that modifies the classes
 * printed on the body tags in various templates.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Custom Body Classes
 *
 * Adds custom classes to the array of body classes.
 *
 * @since 0.1.0
 * @param array $classes
 * @return array
 */
function zki_ht_body_classes( array $classes ) : array {
	// Are we on mobile?.
	if ( wp_is_mobile() ) {
		$classes[] = 'mobile';
	}

	// Set layout.
	$layout = 'l-fullwidth-content';

	// Add class to body.
	$classes[] = $layout;

	$classes[] = 'no-js';

	return apply_filters( 'zki_ht_body_classes', $classes );
}
add_filter( 'body_class', 'zki_ht_body_classes' );

