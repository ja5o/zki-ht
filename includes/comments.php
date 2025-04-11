<?php
/**
 * Comments
 *
 * Contains all functions, actions and filters
 * related to the core comments section.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

if ( ! function_exists( 'zki_ht_remove_fields_from_comment_form' ) ) {
	/**
	 * Remove URL field from comment form
	 *
	 * Removes URL field from comment form
	 *
	 * @since 0.1.0
	 * @param array $fields Comment form fields.
	 */
	function zki_ht_remove_fields_from_comment_form( $fields ) : array {
		/**
		 * Comment Form Fields to be Unset
		 *
		 * @since 0.1.0
		 * @param array $fields_to_remove Fields that will be unset.
		 */
		$fields_to_remove = apply_filters( 'zki_ht_unset_form_fields', [ 'url' ] );
		foreach ( $fields_to_remove as $field ) {
			unset( $fields[ $field ] );
		}
		return $fields;
	}
}
add_filter( 'comment_form_default_fields', 'zki_ht_remove_fields_from_comment_form' );

/**
 * Enqueue Comment Script
 *
 * Loads the comments script if required.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_enqueue_comment_reply_script() : void {
	if ( get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'comment_form_before', 'zki_ht_enqueue_comment_reply_script' );

if ( ! function_exists( 'zki_ht_custom_pings' ) ) {
	/**
	 * Custom Pingback item markup
	 *
	 * Customizes the pingback comment markup.
	 *
	 * @since 0.1.0
	 * @param WP_Comment $comment WP_Comment object.
	 * @return void
	 */
	function zki_ht_custom_pings( $comment ) : void {
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
		<?php
	}
}

/**
 * Comments count
 *
 * Gets the comments count for each comments section.
 *
 * @since 0.1.0
 * @param string|int $count  A string representing the number of comments a post has, otherwise 0.
 * @param int $post_id Post ID.
 * @return string|int $count The post comments number.
 */
function zki_ht_comment_count( string|int $count, int $post_id ) : string|int {
	if ( ! is_admin() ) {
		$get_comments     = get_comments( 'status=approve&post_id=' . $post_id );
		$comments_by_type = separate_comments( $get_comments );
		return count( (array) $comments_by_type['comment'] );
	} else {
		return $count;
	}
}
add_filter( 'get_comments_number', 'zki_ht_comment_count', 0, 2 );
