<?php
/**
 * Gutenberg patterns so the owner can rebuild or duplicate sections.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_register_pattern_category() {
    register_block_pattern_category('solehaus', array(
        'label' => __('Solehaus', 'solehaus'),
    ));
}
add_action('init', 'solehaus_register_pattern_category');

function solehaus_register_shortcodes() {
    add_shortcode('solehaus_featured_products', function () {
        ob_start();
        get_template_part('template-parts/featured-products');
        return ob_get_clean();
    });
    add_shortcode('solehaus_categories', function () {
        ob_start();
        get_template_part('template-parts/categories');
        return ob_get_clean();
    });
    add_shortcode('solehaus_new_arrivals', function () {
        ob_start();
        get_template_part('template-parts/new-arrivals');
        return ob_get_clean();
    });
    add_shortcode('solehaus_whatsapp_button', function ($atts) {
        $atts = shortcode_atts(array('label' => __('Order on WhatsApp', 'solehaus')), $atts);
        return '<a class="sh-btn sh-btn--whatsapp" href="' . esc_url(solehaus_whatsapp_url()) . '" target="_blank" rel="noopener noreferrer">' . esc_html($atts['label']) . '</a>';
    });
}
add_action('init', 'solehaus_register_shortcodes');
