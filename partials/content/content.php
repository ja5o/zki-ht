<?php
/**
 * Entry Content Template
 *
 * This is the default template for showing content on the site.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php tha_entry_top(); ?>
	<div class="entry-content is-layout-constrained has-global-padding">
		<?php
		tha_entry_content_before();
		the_content();
		tha_entry_content_after();
		?>
	</div>
	<?php tha_entry_bottom(); ?>
</article>
