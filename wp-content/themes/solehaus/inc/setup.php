<?php
/**
 * Theme setup.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_setup() {
    load_theme_textdomain('solehaus', SOLEHAUS_DIR . '/languages');

    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    add_theme_support('custom-logo', array(
        'height'      => 64,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor.css');

    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    add_theme_support('elementor');

    register_nav_menus(array(
        'primary'           => __('Primary Menu', 'solehaus'),
        'footer_quick'      => __('Footer Quick Links', 'solehaus'),
        'footer_categories' => __('Footer Categories', 'solehaus'),
        'footer_support'    => __('Footer Customer Support', 'solehaus'),
    ));

    add_image_size('solehaus-card', 800, 800, true);
    add_image_size('solehaus-hero', 1920, 1080, true);
    add_image_size('solehaus-portrait', 800, 1000, true);
}
add_action('after_setup_theme', 'solehaus_setup');

function solehaus_content_width() {
    $GLOBALS['content_width'] = 760;
}
add_action('after_setup_theme', 'solehaus_content_width', 0);

function solehaus_widgets_init() {
    register_sidebar(array(
        'name'          => __('Shop Sidebar', 'solehaus'),
        'id'            => 'shop-sidebar',
        'description'   => __('Filters and widgets beside the product catalogue.', 'solehaus'),
        'before_widget' => '<section id="%1$s" class="sh-widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="sh-widget__title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'solehaus_widgets_init');

function solehaus_excerpt_length() {
    return 24;
}
add_filter('excerpt_length', 'solehaus_excerpt_length');

function solehaus_body_classes($classes) {
    if (is_front_page()) {
        $classes[] = 'sh-home';
    }
    if (!is_active_sidebar('shop-sidebar')) {
        $classes[] = 'no-shop-sidebar';
    }
    return $classes;
}
add_filter('body_class', 'solehaus_body_classes');

function solehaus_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'solehaus_pingback_header');

function solehaus_elementor_support() {
    if (!did_action('elementor/loaded')) {
        return;
    }
    add_theme_support('elementor-header-footer');
}
add_action('after_setup_theme', 'solehaus_elementor_support', 20);
