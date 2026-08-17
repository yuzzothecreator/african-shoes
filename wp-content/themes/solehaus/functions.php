<?php
/**
 * Solehaus theme bootstrap.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

define('SOLEHAUS_VERSION', '1.0.0');
define('SOLEHAUS_DIR', get_template_directory());
define('SOLEHAUS_URI', get_template_directory_uri());

require_once SOLEHAUS_DIR . '/inc/defaults.php';
require_once SOLEHAUS_DIR . '/inc/helpers.php';
require_once SOLEHAUS_DIR . '/inc/setup.php';
require_once SOLEHAUS_DIR . '/inc/enqueue.php';
require_once SOLEHAUS_DIR . '/inc/customizer.php';
require_once SOLEHAUS_DIR . '/inc/whatsapp.php';
require_once SOLEHAUS_DIR . '/inc/woocommerce.php';
require_once SOLEHAUS_DIR . '/inc/seo.php';
require_once SOLEHAUS_DIR . '/inc/newsletter.php';
require_once SOLEHAUS_DIR . '/inc/block-patterns.php';
require_once SOLEHAUS_DIR . '/inc/demo-content.php';
