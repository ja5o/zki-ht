<?php
/**
 * Single Header
 *
 * This template is used at the top of the post entry,
 * it shows the post featured image and title.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

?>
<header class="entry-header is-layout-constrained has-global-padding">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-featured-image">
			<?php the_post_thumbnail( 'fullhd' ); ?>
		</div>
	<?php endif; ?>
	<h1 class="entry-title"><?php the_title(); ?></h1>
	<?php get_template_part( 'partials/single/single', 'meta' ); ?>
</header>
