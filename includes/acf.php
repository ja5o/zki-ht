<?php
/**
 * ACF Customizations
 *
 * Contains all functions, actions and filters related to the ACF PRO plugin.
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

// Removes the empty fields message on ACF blocks.
add_filter( 'acf/blocks/no_fields_assigned_message', '__return_empty_string' );
// Prevents ACF from removing native custom fields metabox.
add_filter( 'acf/settings/remove_wp_meta_box', '__return_false' );
