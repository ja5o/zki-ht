<?php
/**
 * No Content
 *
 * This template is shown when no content is available,
 * usually for search results.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

?>

<section class="no-results not-found">
	<div class="is-layout-constrained has-global-padding">
		<h1 class="no-results-title"><?php esc_html_e( 'Nothing Found', 'zki-ht' ); ?></h1>
		<?php
		echo '<p>' . esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'zki-ht' ) . '</p>';
		?>
		<?php get_search_form(); ?>
	</div>
</section>
