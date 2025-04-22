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
add_action( 'wp_head', 'zki_ht_preload_fonts' );

/**
 * Preload First Images
 *
 * Preloads up to two images from top-level blocks and their inner blocks.
 *
 * @since 0.1.1
 * @return void
 */
function zki_ht_preload_images() : void {
	global $post;

	// Return early if we don't have post data.
	if ( ! $post ) {
		return;
	}

	// Allow for plugin or child themes to remove this feature.
	$maybe_preload_hero_image = apply_filters( 'zki_ht_preload_images', true );

	if ( $maybe_preload_hero_image && has_blocks( $post->post_content ) ) {
		$blocks = parse_blocks( $post->post_content );
		$preload_count = 0;
		foreach ( $blocks as $block ) {
			$preload_count = zki_ht_preload_image_inside_block( $block, $preload_count );

			if ( $preload_count >= 2 ) {
				break;
			}
		}
	}
}
add_action( 'wp_head', 'zki_ht_preload_images' );

/**
 * Custom Fetch Priority
 *
 * Adds `fetchpriority` to the images of the blocks that contains
 * the class names specified on the `zki_fetchpriority_classes`.
 *
 * @since 0.1.1
 * @param string    $block_content The block content.
 * @param array     $block         The full block, including name and attributes.
 * @return string The block content.
 */
function zki_ht_set_fetchpriority_on_elements( string $block_content, array $block ) {
	$fetch_classes = [
		'zki-fetch-high' => 'high',
	];

	$fetch_classes = apply_filters( 'zki_fetchpriority_classes', $fetch_classes );

	if ( isset( $block['attrs']['className'] ) && ! empty( $block['attrs']['className'] ) ) {
		$block_classes = explode( ' ', $block['attrs']['className'] );

		foreach( $block_classes as $block_class ) {
			if ( isset( $fetch_classes[ $block_class ] ) ) {
				$processor = new WP_HTML_Tag_Processor( $block_content );

				if ( $processor->next_tag( 'img' ) ) {
					$processor->set_attribute( 'fetchpriority', $fetch_classes[ $block_class ] );
				}

				$block_content = $processor->get_updated_html();
			}
		}
	}

	return $block_content;
}
add_filter( 'render_block', 'zki_ht_set_fetchpriority_on_elements', 10, 2 );

/**
 * Preload Image in Head
 *
 * Recursively preload images found in a block and its inner blocks.
 *
 * @since 0.1.1
 *
 * @param array $block           A single parsed block.
 * @param int   $preload_count   Current number of images preloaded.
 * @return int                   Updated preload count.
 */
function zki_ht_preload_image_inside_block( array $block, int $preload_count = 0 ) {
	if ( $preload_count >= 2 ) {
		return $preload_count;
	}

	if ( isset( $block['attrs']['id'] ) && wp_attachment_is( 'image', $block['attrs']['id'] ) ) {
		$image_src = wp_get_attachment_image_url( $block['attrs']['id'], 'fullhd' );
		$image_srcset = wp_get_attachment_image_srcset( $block['attrs']['id'] );
		$image_sizes = wp_get_attachment_image_sizes( $block['attrs']['id'], 'fullhd' );
		echo sprintf(
			'<link rel="preload" as="image" href="%s" imagesrcset="%s" imagesizes="%s">',
			$image_src,
			$image_srcset,
			$image_sizes
		);
		$preload_count++;
	}

	if ( ! empty( $block['innerBlocks'] ) ) {
		foreach ( $block['innerBlocks'] as $inner_block ) {
			$preload_count = zki_ht_preload_image_inside_block( $inner_block, $preload_count );
			if ( $preload_count >= 3 ) {
				break;
			}
		}
	}

	return $preload_count;
}

/**
 * Disable Emojis
 *
 * Disable anything related to wp-emoji
 *
 * @since 0.1.1
 * @return void
 */
function zki_ht_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'zki_ht_disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'zki_ht_disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'zki_ht_disable_emojis' );

/**
 * Disable Emojis from TinyMCE
 *
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @since 0.1.1
 * @param array $plugins
 * @return array Difference betwen the two arrays
 */
function zki_ht_disable_emojis_tinymce( array $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, [ 'wpemoji' ] );
	} else {
		return [];
	}
}

/**
 * Remove Emojis DNS prefetch
 *
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @since 0.1.1
 * @param array $urls URLs to print for resource hints.
 * @param string $relation_type The relation type the URLs are printed for.
 * @return array Difference betwen the two arrays.
 */
function zki_ht_disable_emojis_remove_dns_prefetch( array $urls, string $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
		$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
		$urls = array_diff( $urls, array( $emoji_svg_url ) );
	}

	return $urls;
}
