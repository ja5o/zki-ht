<?php
/**
 * Helper Functions
 *
 * Contains utility functions that can be used throughout the entire codebase.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Limit the excerpt length
 *
 * Returns a trimmed version of the post excerpt with a custom length.
 *
 * @since 0.1.0
 * @param array $args {
 *     Optional. Array of arguments to customize the excerpt.
 *
 *     @type int    $length Number of words for the excerpt. Default is 20.
 *     @type string $more   Text to append after the excerpt. Default '...'.
 *     @type int    $post   Post ID to retrieve the excerpt from. Default is the current post.
 * }
 * @return string The trimmed excerpt.
 */
function zki_ht_get_trimmed_excerpt( array $args = [] ) : string {
	$defaults = [
		'length' => 20,
		'more'   => '...',
		'post'   => '',
	];

	$args = wp_parse_args( $args, $defaults );

	return wp_trim_words( get_the_excerpt( $args['post'] ), absint( $args['length'] ), esc_html( $args['more'] ) );
}
