<?php
/**
 * WhatsApp ordering helpers.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_product_whatsapp_message($name, $price, $url, $size = '') {
    $size_text = $size ? $size : 'Not selected';
    return sprintf(
        'Hello Tanny Shoes, I am interested in %s. Preferred size: %s. Product price: %s. Product link: %s. Is it available?',
        $name,
        $size_text,
        solehaus_format_tzs($price),
        $url
    );
}

function solehaus_single_product_whatsapp_url() {
    if (!function_exists('wc_get_product')) {
        return solehaus_whatsapp_url();
    }
    $product = wc_get_product(get_the_ID());
    if (!$product) {
        return solehaus_whatsapp_url();
    }
    $message = solehaus_product_whatsapp_message(
        $product->get_name(),
        (float) $product->get_price(),
        get_permalink($product->get_id()),
        ''
    );
    return solehaus_whatsapp_url($message);
}

function solehaus_single_whatsapp_button() {
    if (!is_product()) {
        return;
    }
    echo '<a class="sh-btn sh-btn--whatsapp sh-btn--block" href="' . esc_url(solehaus_single_product_whatsapp_url()) . '" target="_blank" rel="noopener noreferrer">' . esc_html__('Order on WhatsApp', 'solehaus') . '</a>';
}
add_action('woocommerce_after_add_to_cart_button', 'solehaus_single_whatsapp_button', 20);
