<?php
/**
 * Site Header
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

?>

<!DOCTYPE html>
<?php tha_html_before(); ?>
<html <?php language_attributes(); ?>>
<head>
	<?php tha_head_top(); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
	<?php wp_head(); ?>
	<?php tha_head_bottom(); ?>
</head>
<body <?php body_class(); ?>>
	<?php tha_body_top(); ?>
	<div id="wrapper" class="hfeed">
		<?php tha_header_before(); ?>
		<header id="header" class="site-header" role="banner">
			<div class="is-layout-constrained has-global-padding">
				<?php tha_header_top(); ?>
				<div class="site-header-wrapper alignwide">
					<div class="site-header-start">
						<?php zki_ht_site_branding(); ?>
					</div><!-- /.site-start -->

					<div class="site-header-end">
						<nav class="site-navigation" aria-label="<?php esc_attr_e( 'Main Navigation', 'zki-ht' ); ?>">
							<button class="site-navigation-mobile-trigger">
								<span class="screen-reader-text"><?php esc_attr_e( 'Open menu', 'zki-ht' ); ?></span>
								<span aria-hidden="true" class="icon-menu"></span>
							</button>
							<div class="site-navigation-container">
								<button class="site-navigation-close">
									<span class="screen-reader-text"><?php esc_attr_e( 'Close menu', 'zki-ht' ); ?></span>
									<span aria-hidden="true"  class="icon-close"></span>
								</button>
								<?php
								wp_nav_menu(
									[
										'theme_location' => 'main-menu',
										'menu_class'     => 'primary-menu',
										'menu_id'        => 'primary-nav',
										'container'      => false,
									]
								);
								?>
							</div>
						</nav><!-- /.site-navigation -->
					</div><!-- /.site-end -->
				</div><!-- /.site-header-wrapper -->
				<?php tha_header_bottom(); ?>
			</div>
		</header>
		<?php tha_header_after(); ?>
		<div id="container" class="site-container">
			<?php tha_content_before(); ?>
			<main id="site-content" role="main">
				<?php tha_content_top(); ?>
