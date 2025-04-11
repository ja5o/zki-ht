<?php
/**
 * Archive Header
 *
 * This template is used at the top of the archive pages.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

$archive_title = '';
$description   = '';
$blog_page_id  = get_option( 'page_for_posts' );

if ( is_home() && $blog_page_id ) {
	$archive_title = get_the_title( $blog_page_id );
} elseif ( is_search() ) {
	// translators: Search results title.
	$archive_title = sprintf( __( 'Search results for: %s', 'zki-ht' ), get_search_query() );
} elseif ( is_archive() ) {
	$archive_title = get_the_archive_title();
	$description   = get_the_archive_description();
}
?>

<header class="archive-header">
	<div class="is-layout-constrained has-global-padding">
		<h1 class="archive-title"><?php echo esc_html( wp_strip_all_tags( $archive_title ) ); ?></h1>
		<?php if ( ! empty( $description ) ) : ?>
			<div class="archive-meta">
				<?php echo wp_kses_post( $description ); ?>
			</div>
		<?php endif; ?>
	</div>
</header>
