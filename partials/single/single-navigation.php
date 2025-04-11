<?php
/**
 * Single Post Navigation
 *
 * This template shows the current post navigation at
 * the bottom of the post entry.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

$args = [
	// translators: post navigation prev.
	'prev_text' => '<i class="icon-arrow-left" aria-hidden="true"></i><div class="nav-links-wrap"><span class="nav-links-label">' . __( 'Previous', 'zki-ht' ) . '</span><span class="nav-links-name">%title</span></div>',
	// translators: post navigation next.
	'next_text' => '<div class="nav-links-wrap"><span class="nav-links-label">' . __( 'Next', 'zki-ht' ) . '</span><span class="nav-links-name">%title</span></div><i class="icon-arrow-right" aria-hidden="true"></i>',
];
?>
<div class="entry-navigation is-layout-constrained has-global-padding">
	<?php the_post_navigation( $args ); ?>
</div>
