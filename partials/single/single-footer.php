<?php
/**
 * Single Footer
 *
 * This template is used at the bottom of the single template,
 * it contains the page links for paginated posts and the
 * current post category and tags.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

?>
<div class="entry-links"><?php wp_link_pages(); ?></div>
<footer class="entry-footer">
	<span class="cat-links"><?php esc_html_e( 'Categories: ', 'zki-ht' ); ?><?php the_category( ', ' ); ?></span>
	<span class="tag-links"><?php the_tags(); ?></span>
</footer>
