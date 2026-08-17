<?php
/**
 * Newsletter subscriptions stored as a custom post type (no extra plugin).
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_register_subscribers() {
    register_post_type('sh_subscriber', array(
        'labels' => array(
            'name'          => __('Newsletter subscribers', 'solehaus'),
            'singular_name' => __('Subscriber', 'solehaus'),
        ),
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'supports'     => array('title'),
        'menu_icon'    => 'dashicons-email-alt',
        'capability_type' => 'post',
    ));
}
add_action('init', 'solehaus_register_subscribers');

function solehaus_subscribe_ajax() {
    check_ajax_referer('solehaus_front', 'nonce');

    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $hp    = sanitize_text_field(wp_unslash($_POST['company'] ?? ''));

    if ($hp !== '') {
        wp_send_json_success(array('message' => __('Thank you. We will write when new styles or sizes arrive.', 'solehaus')));
    }

    if (!is_email($email)) {
        wp_send_json_error(array('message' => __('Please enter a valid email address.', 'solehaus')), 400);
    }

    $existing = get_posts(array(
        'post_type'      => 'sh_subscriber',
        'title'          => $email,
        'posts_per_page' => 1,
        'post_status'    => 'private',
        'fields'         => 'ids',
    ));
    if ($existing) {
        wp_send_json_success(array('message' => __('This email is already on the list.', 'solehaus')));
    }

    $id = wp_insert_post(array(
        'post_type'   => 'sh_subscriber',
        'post_title'  => $email,
        'post_status' => 'private',
    ), true);

    if (is_wp_error($id)) {
        wp_send_json_error(array('message' => __('Could not save your email. Please try again.', 'solehaus')), 500);
    }

    $store_email = sanitize_email(solehaus_mod('email'));
    if ($store_email) {
        wp_mail(
            $store_email,
            sprintf('[%s] New newsletter subscriber', solehaus_store_name()),
            'A customer asked to receive updates: ' . $email
        );
    }

    wp_send_json_success(array('message' => __('Thank you. We will write when new styles or sizes arrive.', 'solehaus')));
}
add_action('wp_ajax_solehaus_subscribe', 'solehaus_subscribe_ajax');
add_action('wp_ajax_nopriv_solehaus_subscribe', 'solehaus_subscribe_ajax');
