<?php
/**
 * Archive Template Hooks
 *
 * Contains Action and filter hooks that modify the
 * way archive pages are rendered for this theme.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Archive Header
 *
 * Includes the archive header template part.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_archive_header() : void {
	if ( is_home() || is_archive() || is_search() ) :
		get_template_part( 'partials/archive/archive', 'header' );
	endif;
}
add_action( 'tha_content_while_before', 'zki_ht_archive_header' );

/**
 * Archive Wrapper Opening Tags
 *
 * Prints the opening tags for the archive wrapper container.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_archive_wrapper_open() :void {
	if ( is_archive() || is_search() || is_home() ) {
		echo '<div class="is-layout-constrained has-global-padding">';
		echo '<div class="archive-grid">';
	}
}
add_action( 'tha_content_while_before', 'zki_ht_archive_wrapper_open' );

/**
 * Archive Wrapper Closing Tags
 *
 * Prints the closing tags for the archive wrapper container.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_archive_wrapper_close() :void {
	if ( is_archive() || is_search() || is_home() ) {
		echo '</div>';
		echo '</div>';
	}
}
add_action( 'tha_content_while_after', 'zki_ht_archive_wrapper_close' );

/**
 * Archive Paginated Navigation
 *
 * Displays a paginated navigation for archive pages
 * like blog, taxonomy and search results.
 *
 * @author: Bill Erickson
 * @link: https://github.com/billerickson/BE-Starter/
 *
 * @return void
 */
function zki_ht_archive_pagination() : void {

	if ( is_singular() ) {
		return;
	}

	global $wp_query;

	// Stop execution if there's only one page.
	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = (int) $wp_query->max_num_pages;
	$links = [];

	// Add current page to the array.
	if ( $paged >= 1 ) {
		$links[] = $paged;
	}

	// Add the pages around the current page to the array.
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<nav class="archive-pagination pagination">';
	echo '<div class="is-layout-constrained has-global-padding">';

	$before_number = '<span class="screen-reader-text">' . __( 'Go to page', 'zki-ht' ) . '</span>';

	printf( '<ul role="navigation" aria-label="%s">', esc_attr__( 'Pagination', 'zki-ht' ) );

	// Previous Post Link.
	if ( get_previous_posts_link() ) {
		$label = '<span class="screen-reader-text">' . __( 'Go to Previous Page', 'zki-ht' ) . '</span>';
		$label .= '<i class="icon-arrow-left"></i>';
		$link  = get_previous_posts_link( $label );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Value is hardcoded and safe, not set via input.
		printf( '<li class="pagination-previous">%s</li>' . "\n", $link );
	}

	// Link to first page, plus ellipses if necessary.
	if ( ! in_array( 1, $links, true ) ) {
		$class = 1 === $paged ? ' class="active"' : '';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Value is known to be safe, not set via input.
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link( 1 ), trim( $before_number . ' 1' ) );

		if ( ! in_array( 2, $links, true ) ) {
			$label = sprintf( '<span class="screen-reader-text">%s</span> &#x02026;', __( 'Interim pages omitted', 'zki-ht' ) );
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Value is known to be safe, not set via input.
			printf( '<li class="pagination-omission">%s</li> ' . "\n", $label );
		}
	}

	// Link to current page, plus 2 pages in either direction if necessary.
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = '';
		$aria  = '';
		if ( $paged === $link ) {
			$class = ' class="active" ';
			$aria  = ' aria-label="' . esc_attr__( 'Current page', 'zki-ht' ) . '" aria-current="page"';
		}

		printf(
			'<li%s><span %s>%s</span></li>' . "\n",
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Value is safe, not set via input.
			$class,
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Value is safe, not set via input.
			$aria,
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Value is safe, not set via input.
			wp_kses_post( '<span class="screen-reader-text">' . __( 'Page', 'zki-ht' ) . '</span> ' . $link )
		);
	}

	// Link to last page, plus ellipses if necessary.
	if ( ! in_array( $max, $links, true ) ) {

		if ( ! in_array( $max - 1, $links, true ) ) {
			$label = sprintf( '<span class="screen-reader-text">%s</span> &#x02026;', __( 'Interim pages omitted', 'zki-ht' ) );
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Value is known to be safe, not set via input.
			printf( '<li class="pagination-omission">%s</li> ' . "\n", $label );
		}

		$class = $paged === $max ? ' class="active"' : '';
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Value is safe, not set via input.
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, get_pagenum_link( $max ), trim( $before_number . ' ' . $max ) );

	}

	// Next Post Link.
	if ( get_next_posts_link() ) {
		$label = '<span class="screen-reader-text">' . __( 'Go to Next Page', 'zki-ht' ) . '</span>';
		$label .= '<i class="icon-arrow-right"></i>';
		$link  = get_next_posts_link( $label );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Value is hardcoded and safe, not set via input.
		printf( '<li class="pagination-next">%s</li>' . "\n", $link );
	}

	echo '</ul>';
	echo '</div>';
	echo '</nav>';
}
add_action( 'tha_content_while_after', 'zki_ht_archive_pagination', 20 );
