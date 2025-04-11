<?php
/**
 * Widgets
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Widget Areas
 *
 * Registers widget sidebar locations for the theme.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_widget_areas() : void {
	register_sidebar(
		[
			'name'          => esc_html__( 'Right Sidebar', 'zki-ht' ),
			'id'            => 'right-sidebar',
			'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		]
	);
}
add_action( 'widgets_init', 'zki_ht_widget_areas' );

/**
 * Displays the right sidebar.
 *
 * Displays the right sidebar (default one) after the content section
 * using the 'tha_content_after' hook.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_display_right_sidebar() : void {
	get_sidebar();
}
add_action( 'tha_content_after', 'zki_ht_display_right_sidebar' );
