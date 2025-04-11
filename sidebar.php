<?php
/**
 * The sidebar containing the primary widget area
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

if ( is_active_sidebar( 'right-sidebar' ) ) :
	tha_sidebars_before();
	?>
	<aside id="rigth-sidebar" class="sidebar" role="complementary">
		<?php tha_sidebar_top(); ?>
		<div class="widget-area">
			<ul class="widget-list">
				<?php dynamic_sidebar( 'right-sidebar' ); ?>
			</ul>
		</div>
		<?php tha_sidebar_bottom(); ?>
	</aside>
	<?php
	tha_sidebars_after();
endif;
