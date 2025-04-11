<?php
/**
 * Security
 *
 * Contains functions, actions, and filters that improve
 * the site's security.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * Remove Generator Meta Tags.
 *
 * @since 0.1.0
 * @return false
 */
add_filter( 'the_generator', '__return_false' );

/**
 * Disable XML RPC.
 *
 * @since 0.1.0
 * @return false
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Remove API discovery link and oEmbed links.
 *
 * @since 0.1.0
 */
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );

/**
 * Remove Oembed Discover
 *
 * @since 0.1.0
 * @return false
 */
add_filter( 'embed_oembed_discover', '__return_false' );


/**
 * CORS Control
 *
 * Changes REST-API header from "null" to "*"
 *
 * @link https://w3c.github.io/webappsec-cors-for-developers/#avoid-returning-access-control-allow-origin-null
 */
function zki_ht_cors_control() : void {
	header( 'Access-Control-Allow-Origin: *' );
}
add_action( 'rest_api_init', 'zki_ht_cors_control' );
