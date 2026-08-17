<?php
/**
 * SEO: Open Graph, JSON-LD, and document extras.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_meta_description() {
    if (is_front_page()) {
        return solehaus_mod('store_tagline');
    }
    if (function_exists('is_shop') && is_shop()) {
        return 'Browse footwear for men, women and children at ' . solehaus_store_name() . ' in Arusha, Tanzania. Contact us on WhatsApp or Instagram for current availability.';
    }
    if (is_singular()) {
        $post = get_queried_object();
        if ($post && !empty($post->post_excerpt)) {
            return wp_strip_all_tags($post->post_excerpt);
        }
        if ($post) {
            return wp_trim_words(wp_strip_all_tags($post->post_content), 28);
        }
    }
    return get_bloginfo('description');
}

function solehaus_og_image() {
    if (is_singular() && has_post_thumbnail()) {
        $url = get_the_post_thumbnail_url(get_queried_object_id(), 'large');
        if ($url) {
            return $url;
        }
    }
    if (function_exists('is_product') && is_product()) {
        $product = wc_get_product(get_the_ID());
        if ($product && $product->get_image_id()) {
            $url = wp_get_attachment_image_url($product->get_image_id(), 'large');
            if ($url) {
                return $url;
            }
        }
    }
    return solehaus_mod('hero_image');
}

function solehaus_seo_head() {
    $description = solehaus_meta_description();
    $image       = solehaus_og_image();
    $title       = wp_get_document_title();
    $url         = is_front_page() ? home_url('/') : ((is_singular()) ? get_permalink() : home_url(add_query_arg(array())));

    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:locale" content="en_TZ">' . "\n";
    echo '<meta property="og:type" content="' . (is_singular() && !is_front_page() ? 'article' : 'website') . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr(solehaus_store_name()) . '">' . "\n";
    if ($image) {
        echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
        echo '<meta name="twitter:image" content="' . esc_url($image) . '">' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<link rel="canonical" href="' . esc_url($url) . '">' . "\n";

    echo '<script type="application/ld+json">' . wp_json_encode(solehaus_local_business_schema(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";

    if (function_exists('is_product') && is_product()) {
        echo '<script type="application/ld+json">' . wp_json_encode(solehaus_product_schema(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
}
add_action('wp_head', 'solehaus_seo_head', 5);

function solehaus_local_business_schema() {
    $same_as = array(
        solehaus_mod('instagram_url'),
        'https://www.instagram.com/tannybeautystore_arusha/',
        'https://www.instagram.com/tanny_arusha/',
    );
    if (solehaus_mod('facebook_url')) {
        $same_as[] = solehaus_mod('facebook_url');
    }

    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'ShoeStore',
        'name'        => solehaus_store_name(),
        'description' => solehaus_mod('store_tagline'),
        'url'         => home_url('/'),
        'image'       => solehaus_mod('hero_image'),
        'telephone'   => solehaus_mod('whatsapp') ? solehaus_mod('whatsapp') : solehaus_mod('phone'),
        'address'     => array(
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Arusha',
            'addressCountry'  => 'TZ',
        ),
        'currenciesAccepted' => 'TZS',
        'sameAs'             => array_values(array_filter($same_as)),
    );

    if (solehaus_mod('email')) {
        $schema['email'] = solehaus_mod('email');
    }
    if (solehaus_mod('address')) {
        $schema['address']['streetAddress'] = solehaus_mod('address');
    }
    if (solehaus_mod('hours')) {
        $schema['openingHours'] = solehaus_mod('hours');
    }

    return $schema;
}

function solehaus_product_schema() {
    $product = wc_get_product(get_the_ID());
    if (!$product) {
        return array();
    }
    $image_id = $product->get_image_id();
    return array(
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => $product->get_name(),
        'description' => wp_strip_all_tags($product->get_short_description() ? $product->get_short_description() : $product->get_description()),
        'image'       => $image_id ? wp_get_attachment_image_url($image_id, 'large') : '',
        'sku'         => $product->get_sku(),
        'brand'       => array(
            '@type' => 'Brand',
            'name'  => solehaus_store_name(),
        ),
        'offers'      => array(
            '@type'         => 'Offer',
            'url'           => get_permalink($product->get_id()),
            'priceCurrency' => 'TZS',
            'price'         => $product->get_price(),
            'availability'  => $product->is_in_stock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'seller'        => array(
                '@type' => 'Organization',
                'name'  => solehaus_store_name(),
            ),
        ),
    );
}

function solehaus_document_title_parts($parts) {
    if (is_front_page()) {
        $parts['title'] = solehaus_store_name() . ' — Arusha, Tanzania';
        $parts['tagline'] = solehaus_mod('store_tagline');
    }
    return $parts;
}
add_filter('document_title_parts', 'solehaus_document_title_parts');
