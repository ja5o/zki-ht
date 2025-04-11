<?php
/**
 * Site Branding
 *
 * This template shows the formatted site branding,
 * when a custom logo is set it shows it, if not
 * then the blog name is shown.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

?>
<div class="site-branding">
	<?php if ( has_custom_logo() ) : ?>
		<?php the_custom_logo(); ?>
	<?php else : ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" rel="home">
			<span><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
		</a>
	<?php endif; ?>
</div><!-- /.site-branding -->
