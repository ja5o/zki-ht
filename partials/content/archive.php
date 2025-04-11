<?php
/**
 * Archive Entry Template
 *
 * This template is used at the archive posts loop.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

?>
<article <?php post_class( 'archive-grid-item post-summary' ); ?>>
	<?php if ( ( has_post_thumbnail() ) ) : ?>
		<div class="post-summary-image">
			<?php the_post_thumbnail( 'medium' ); ?>
		</div>
	<?php endif; ?>
	<h2 class="post-summary-title">
		<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="post-summary-link">
			<?php the_title(); ?>
		</a>
	</h2>
	<div class="post-summary-content">
		<?php the_excerpt(); ?>
	</div>
</article>
