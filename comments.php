<?php
/**
 * Comments Template
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

?>
<?php tha_comments_before(); ?>
<div id="comments" class="comments-section is-layout-constrained has-global-padding">
	<?php
	if ( have_comments() ) :
		global $comments_by_type;
		$comments_by_type = separate_comments( $comments );
		if ( ! empty( $comments_by_type['comment'] ) ) :
			?>
			<section id="comments-list" class="comments">
				<h2 class="comments-title"><?php comments_number(); ?></h2>
				<?php if ( get_comment_pages_count() > 1 ) : ?>
					<nav id="comments-nav-above" class="comments-navigation" role="navigation">
						<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
					</nav>
				<?php endif; ?>
				<ul>
					<?php wp_list_comments( [ 'type' => 'comment', 'max_depth' => 4 ] ); ?>
				</ul>
				<?php if ( get_comment_pages_count() > 1 ) : ?>
					<nav id="comments-nav-below" class="comments-navigation" role="navigation">
						<div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
					</nav>
				<?php endif; ?>
			</section>
			<?php
		endif;
		if ( ! empty( $comments_by_type['pings'] ) ) :
			// phpcs:disable
			$ping_count = count( (array) $comments_by_type['pings'] );
			?>
			<section id="trackbacks-list" class="comments">
				<h2 class="comments-title"><?php echo '<span class="ping-count">' . esc_html( $ping_count ) . '</span> ' . esc_html( _nx( 'Trackback or Pingback', 'Trackbacks and Pingbacks', $ping_count, 'comments count', 'zki-ht' ) ); ?></h2>
				<ul>
					<?php wp_list_comments(
						[
							'type' => 'pings',
							'callback' => 'zki_ht_custom_pings',
						]
					); ?>
				</ul>
			</section>
			<?php
		endif;
	endif;
	if ( comments_open() ) {
		comment_form();
	}
	?>
</div>
<?php tha_comments_after(); ?>
