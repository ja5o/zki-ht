<?php
/**
 * Theme functions file
 *
 * @package    ZKI HT
 * @since      0.1.0
 */

// Theme.
require_once get_template_directory() . '/includes/helpers.php';
require_once get_template_directory() . '/includes/tha-theme-hooks.php';
require_once get_template_directory() . '/includes/setup.php';
require_once get_template_directory() . '/includes/login-logo.php';
require_once get_template_directory() . '/includes/block-editor.php';
require_once get_template_directory() . '/includes/block-areas.php';
require_once get_template_directory() . '/includes/hooks/single.php';
require_once get_template_directory() . '/includes/hooks/archive.php';
require_once get_template_directory() . '/includes/woocommerce.php';
require_once get_template_directory() . '/includes/asset-loader.php';
require_once get_template_directory() . '/includes/security.php';
require_once get_template_directory() . '/includes/body-classes.php';
require_once get_template_directory() . '/includes/a11y.php';
require_once get_template_directory() . '/includes/seo.php';
require_once get_template_directory() . '/includes/widgets.php';
require_once get_template_directory() . '/includes/comments.php';
require_once get_template_directory() . '/includes/template-tags.php';

// Plugin Support.
require_once get_template_directory() . '/includes/acf.php';
