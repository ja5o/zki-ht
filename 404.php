<?php
/**
 * 404 Page Template
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

get_header();
?>
<article id="post-0" class="post not-found">
	<header class="header">
		<div class="is-layout-contrained has-global-padding">
			<h1 class="not-found-title"><?php esc_html_e( 'Not Found', 'zki-ht' ); ?></h1>
		</div>
	</header>
	<div class="no-found-content">
		<div class="is-layout-constrained has-global-padding">
			<p><?php esc_html_e( 'Nothing found for the requested page. Try a search instead?', 'zki-ht' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	</div>
</article>
<?php
get_footer();

