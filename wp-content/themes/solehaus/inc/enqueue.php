<?php
/**
 * Scripts and styles.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_enqueue_assets() {
    wp_enqueue_style(
        'solehaus-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Manrope:wght@500;600;700;800&display=swap',
        array(),
        null
    );

    wp_enqueue_style(
        'solehaus-main',
        SOLEHAUS_URI . '/assets/css/main.css',
        array('solehaus-fonts'),
        SOLEHAUS_VERSION
    );

    if (class_exists('WooCommerce')) {
        wp_enqueue_style(
            'solehaus-woocommerce',
            SOLEHAUS_URI . '/assets/css/woocommerce.css',
            array('solehaus-main'),
            SOLEHAUS_VERSION
        );
    }

    wp_add_inline_style('solehaus-main', solehaus_accent_css());

    wp_enqueue_script(
        'solehaus-main',
        SOLEHAUS_URI . '/assets/js/main.js',
        array(),
        SOLEHAUS_VERSION,
        true
    );

    wp_localize_script('solehaus-main', 'solehausData', array(
        'ajaxUrl'      => admin_url('admin-ajax.php'),
        'nonce'        => wp_create_nonce('solehaus_front'),
        'waBase'       => 'https://wa.me/255624041062',
        'storeName'    => solehaus_store_name(),
        'selectSize'   => __('Please select a size first.', 'solehaus'),
        'addedToCart'  => __('Added to cart.', 'solehaus'),
        'cartError'    => __('Could not add this item. Please try again or order on WhatsApp.', 'solehaus'),
        'subscribeOk'  => __('Thank you. We will write when new styles or sizes arrive.', 'solehaus'),
        'subscribeErr' => __('Please enter a valid email address.', 'solehaus'),
    ));
}
add_action('wp_enqueue_scripts', 'solehaus_enqueue_assets');

function solehaus_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
        );
        $urls[] = array(
            'href'        => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://images.unsplash.com',
        );
    }
    return $urls;
}
add_filter('wp_resource_hints', 'solehaus_resource_hints', 10, 2);

function solehaus_script_loader_tag($tag, $handle) {
    if ('solehaus-main' === $handle) {
        return str_replace(' src', ' defer src', $tag);
    }
    return $tag;
}
add_filter('script_loader_tag', 'solehaus_script_loader_tag', 10, 2);
