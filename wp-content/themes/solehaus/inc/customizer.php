<?php
/**
 * Theme Customiser — Tanny Shoes business settings.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_customize_register($wp_customize) {
    $wp_customize->get_setting('blogname')->transport = 'postMessage';

    $wp_customize->add_panel('solehaus_panel', array(
        'title'       => __('Tanny Shoes', 'solehaus'),
        'description' => __('Edit store identity, contact details, homepage copy, and social links. All business information is managed here.', 'solehaus'),
        'priority'    => 30,
    ));

    solehaus_customize_section($wp_customize, 'identity', __('Store identity', 'solehaus'), 10, array(
        'store_name'      => array('label' => __('Business name', 'solehaus'), 'type' => 'text'),
        'store_tagline'   => array('label' => __('SEO description / tagline', 'solehaus'), 'type' => 'textarea'),
        'city'            => array('label' => __('City and country', 'solehaus'), 'type' => 'text'),
        'accent_color'    => array('label' => __('Primary brand colour (pink)', 'solehaus'), 'type' => 'color'),
        'secondary_color' => array('label' => __('Secondary accent (light blue)', 'solehaus'), 'type' => 'color'),
    ));

    solehaus_customize_section($wp_customize, 'contact', __('Contact', 'solehaus'), 20, array(
        'whatsapp'       => array('label' => __('WhatsApp number', 'solehaus'), 'type' => 'text'),
        'whatsapp_url'   => array('label' => __('WhatsApp URL', 'solehaus'), 'type' => 'url'),
        'phone'          => array('label' => __('Phone number (optional)', 'solehaus'), 'type' => 'text'),
        'email'          => array('label' => __('Email address (optional)', 'solehaus'), 'type' => 'email'),
        'address'        => array('label' => __('Street address (optional)', 'solehaus'), 'type' => 'textarea'),
        'hours'          => array('label' => __('Opening hours (optional)', 'solehaus'), 'type' => 'textarea'),
        'maps_embed'     => array('label' => __('Google Maps embed URL (optional)', 'solehaus'), 'type' => 'url'),
        'directions_url' => array('label' => __('Get Directions URL (optional)', 'solehaus'), 'type' => 'url'),
        'whatsapp_greeting' => array('label' => __('Default WhatsApp greeting', 'solehaus'), 'type' => 'textarea'),
    ));

    solehaus_customize_section($wp_customize, 'social', __('Social media', 'solehaus'), 30, array(
        'instagram'           => array('label' => __('Main Instagram handle (without @)', 'solehaus'), 'type' => 'text'),
        'instagram_url'       => array('label' => __('Main Instagram URL', 'solehaus'), 'type' => 'url'),
        'instagram_followers' => array('label' => __('Instagram follower label', 'solehaus'), 'type' => 'text'),
        'facebook_url'        => array('label' => __('Facebook URL (optional)', 'solehaus'), 'type' => 'url'),
        'tiktok_url'          => array('label' => __('TikTok URL (optional)', 'solehaus'), 'type' => 'url'),
    ));

    solehaus_customize_section($wp_customize, 'home', __('Homepage copy', 'solehaus'), 40, array(
        'announcement'        => array('label' => __('Announcement bar', 'solehaus'), 'type' => 'text'),
        'hero_eyebrow'      => array('label' => __('Hero eyebrow', 'solehaus'), 'type' => 'text'),
        'hero_headline'       => array('label' => __('Hero headline', 'solehaus'), 'type' => 'text'),
        'hero_text'           => array('label' => __('Hero description', 'solehaus'), 'type' => 'textarea'),
        'hero_primary_label'  => array('label' => __('Hero primary button', 'solehaus'), 'type' => 'text'),
        'hero_secondary_label'=> array('label' => __('Hero WhatsApp button', 'solehaus'), 'type' => 'text'),
        'promo_headline'      => array('label' => __('Promotional headline', 'solehaus'), 'type' => 'text'),
        'promo_text'          => array('label' => __('Promotional text', 'solehaus'), 'type' => 'textarea'),
        'story_headline'      => array('label' => __('About heading', 'solehaus'), 'type' => 'text'),
        'story_text'          => array('label' => __('About text', 'solehaus'), 'type' => 'textarea'),
        'community_headline'  => array('label' => __('Community section heading', 'solehaus'), 'type' => 'text'),
        'community_text'      => array('label' => __('Community section text', 'solehaus'), 'type' => 'textarea'),
        'community_button'    => array('label' => __('Community button label', 'solehaus'), 'type' => 'text'),
        'newsletter_headline' => array('label' => __('Newsletter heading', 'solehaus'), 'type' => 'text'),
        'newsletter_text'     => array('label' => __('Newsletter text', 'solehaus'), 'type' => 'textarea'),
        'footer_about'        => array('label' => __('Footer description', 'solehaus'), 'type' => 'textarea'),
    ));

    solehaus_customize_section($wp_customize, 'policies', __('Policies (optional)', 'solehaus'), 50, array(
        'delivery_info' => array('label' => __('Delivery information', 'solehaus'), 'type' => 'textarea'),
        'returns_info'  => array('label' => __('Returns information', 'solehaus'), 'type' => 'textarea'),
    ));

    $image_keys = array(
        'hero_image'  => __('Hero image', 'solehaus'),
        'promo_image' => __('Promotional banner image', 'solehaus'),
        'story_image' => __('About section image', 'solehaus'),
    );
    foreach ($image_keys as $key => $label) {
        $wp_customize->add_setting('solehaus_' . $key, array(
            'default'           => solehaus_default($key),
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'solehaus_' . $key, array(
            'label'       => $label,
            'section'     => 'solehaus_home',
            'settings'    => 'solehaus_' . $key,
            'description' => __('Upload a WebP image where possible.', 'solehaus'),
        )));
    }
}
add_action('customize_register', 'solehaus_customize_register');

function solehaus_customize_section($wp_customize, $id, $title, $priority, $fields) {
    $section = 'solehaus_' . $id;
    $wp_customize->add_section($section, array(
        'title'    => $title,
        'panel'    => 'solehaus_panel',
        'priority' => $priority,
    ));

    foreach ($fields as $key => $field) {
        $setting = 'solehaus_' . $key;
        $type    = $field['type'];
        $sanitize = 'sanitize_text_field';
        if ($type === 'textarea') {
            $sanitize = 'sanitize_textarea_field';
        } elseif ($type === 'url') {
            $sanitize = 'esc_url_raw';
        } elseif ($type === 'email') {
            $sanitize = 'sanitize_email';
        } elseif ($type === 'color') {
            $sanitize = 'sanitize_hex_color';
        }

        $wp_customize->add_setting($setting, array(
            'default'           => solehaus_default($key),
            'sanitize_callback' => $sanitize,
            'transport'         => 'refresh',
        ));

        $wp_customize->add_control($setting, array(
            'label'   => $field['label'],
            'section' => $section,
            'type'    => $type === 'color' ? 'color' : $type,
        ));
    }
}
