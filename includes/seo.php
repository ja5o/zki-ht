<?php
/**
 * SEO
 *
 * Contains functions, actions, and filters that improve
 * the site's SEO features.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

if ( ! function_exists( 'zki_ht_document_title_separator' ) ) {
	/**
	 * Title Separator
	 *
	 * Adds default title tag separator to '<title>' tag.
	 *
	 * @param  string $sep Document title separator.
	 * @return string $sep
	 */
	function zki_ht_document_title_separator( string $sep ) : string {
		$sep = esc_html( '|' );
		return $sep;
	}
}
add_filter( 'document_title_separator', 'zki_ht_document_title_separator' );

/**
 * Preload Fonts
 *
 * Preloads relevant font files to improve performance.
 *
 * This function operates under the following assumptions:
 * - It loads font faces only for the first font family declared in theme.json.
 * - It includes only fonts with a weight of 400 or 700, as these are the most commonly used above the fold.
 * - It loads only the first font file specified in the `src` attribute of theme.json,
 *   which is expected to be in WOFF2 or WOFF format.
 *
 * Additional fonts can be preloaded using the `zki_ht_preloaded_fonts` filter.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_preload_fonts() {
	$fonts_to_preload = [];
	$theme_json_fonts = WP_Font_Face_Resolver::get_fonts_from_theme_json();

	if ( ! empty( $theme_json_fonts ) ) {
		foreach( $theme_json_fonts[0] as $font_face ) {
			if ( 'normal' === $font_face['font-style'] && preg_match( '/\b(400|700)\b/', $font_face['font-weight'] ) ) {
				$fonts_to_preload[] = [
					'url' => $font_face['src'][0],
					'format' => pathinfo( parse_url( $font_face['src'][0], PHP_URL_PATH ), PATHINFO_EXTENSION ),
				];
			}
		}
	}

	array_push(
		$fonts_to_preload,
		[
			'url' => get_theme_file_uri( 'build/fonts/icomoon/icomoon.woff' ),
			'format' => 'woff'
		]
	);

	$fonts_to_preload = apply_filters( 'zki_ht_preloaded_fonts', $fonts_to_preload );

	foreach ( $fonts_to_preload as $font ) {
		echo sprintf(
			'<link rel="preload" as="font" type="font/%1$s" href="%2$s" crossorigin>',
			$font['format'],
			$font['url']
		);
	}
}
add_action( 'wp_head', 'zki_ht_preload_icon_fonts' );

/**
 * Preload Hero Image
 *
 * Preloads the background image of the first block if it
 * is a 'core/cover' block.
 *
 * @since 0.1.0
 * @return void
 */
function zki_ht_preload_hero_image() : void {
	global $post;

	// Return early if we don't have post data.
	if ( ! $post ) {
		return;
	}

	// Allow for plugin or child themes to remove this feature.
	$maybe_preload_hero_image = apply_filters( 'zki_ht_preload_hero_image', true );

	if ( $maybe_preload_hero_image && has_blocks( $post->post_content ) ) {
		$blocks = parse_blocks( $post->post_content );

		// Preload only if cover media is set and is an image.
		if ( $blocks[0]['blockName'] === 'core/cover' && isset( $blocks[0]['attrs']['id'] ) && wp_attachment_is( 'image', $blocks[0]['attrs']['id'] ) ) {
			$image_src = wp_get_attachment_image_url( $blocks[0]['attrs']['id'], 'fullhd' );
			$image_srcset = wp_get_attachment_image_srcset( $blocks[0]['attrs']['id'] );
			$image_sizes = wp_get_attachment_image_sizes( $blocks[0]['attrs']['id'], 'fullhd' );
			echo sprintf(
				'<link rel="preload" as="image" href="%s" imagesrcset="%s" imagesizes="%s">',
				$image_src,
				$image_srcset,
				$image_sizes
			);
		}
	}
}
add_action( 'wp_head', 'zki_ht_preload_hero_image' );
