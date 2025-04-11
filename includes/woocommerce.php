<?php
/**
 * WooCommerce
 *
 * Contains all functions, actions and filters
 * related to the WooCommerce plugin.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

/**
 * WooCommerce Support
 *
 * Declares theme support for WooCommerce functionalities.
 */
function zki_ht_wc_setup() : void {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
}
add_action( 'after_setup_theme', 'zki_ht_wc_setup' );
