<?php
/**
 * Default Template
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

get_header();

if ( have_posts() ) :
	tha_content_while_before();
	while ( have_posts() ) :
		the_post();
		tha_entry_before();
		$partial = is_singular() ? 'content' : 'archive';
		get_template_part( 'partials/content/' . $partial );
		tha_entry_after();
		comments_template();
	endwhile;
	tha_content_while_after();
else :
	tha_entry_before();
	get_template_part( 'partials/content/no-content' );
	tha_entry_after();
endif;

get_footer();
