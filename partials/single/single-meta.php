<?php
/**
 * Single Meta
 *
 * This template is used inside the 'single-header' template and
 * shows the current post meta, usually author name and date.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

?>
<div class="entry-meta">
	<span class="author vcard">
		<?php esc_html_e( 'Written by', 'zki-ht' ); ?>
		<?php the_author_posts_link(); ?>
	</span>
	<span class="meta-sep"> | </span>
	<time
		class="entry-date"
		datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"
		title="<?php echo esc_attr( get_the_date() ); ?>"
	>
		<?php the_time( get_option( 'date_format' ) ); ?>
	</time>
</div>
