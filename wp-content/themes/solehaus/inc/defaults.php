<?php
/**
 * Central business configuration — edit values here or in Appearance → Customise.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Default Customiser values for Tanny Shoes.
 */
function solehaus_defaults() {
    return array(
        'store_name'            => 'Tanny Shoes',
        'store_tagline'         => 'Discover stylish and comfortable footwear for men, women and children from Tanny Shoes in Arusha, Tanzania.',
        'city'                  => 'Arusha, Tanzania',
        'announcement'          => 'Footwear for men, women and children | Order on WhatsApp',
        'phone'                 => '',
        'whatsapp'              => '+255 624 041 062',
        'whatsapp_url'          => 'https://wa.me/255624041062',
        'email'                 => '',
        'address'               => '',
        'hours'                 => '',
        'maps_embed'            => '',
        'directions_url'        => '',
        'instagram'             => 'tannyshoes_aimmall',
        'instagram_url'         => 'https://www.instagram.com/tannyshoes_aimmall/',
        'instagram_followers'   => '31K+ Instagram followers',
        'facebook_url'          => '',
        'tiktok_url'            => '',
        'hero_eyebrow'          => 'Tanny Shoes • Arusha, Tanzania',
        'hero_headline'         => 'Shoes for Every Step',
        'hero_text'             => 'Discover stylish and comfortable footwear for men, women and children from Tanny Shoes in Arusha, Tanzania.',
        'hero_trust'            => '',
        'hero_primary_label'    => 'Shop Collection',
        'hero_secondary_label'  => 'Order on WhatsApp',
        'hero_image'            => 'https://images.unsplash.com/photo-1556906787-89487169e8f0?auto=format&fit=crop&w=1920&h=1080&q=80&fm=webp',
        'promo_headline'        => 'New styles on Instagram',
        'promo_text'            => 'Follow @tannyshoes_aimmall for footwear updates, new arrivals and product posts.',
        'promo_image'           => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=1600&q=80&fm=webp',
        'story_headline'        => 'Footwear for the Whole Family',
        'story_text'            => 'Tanny Shoes is a footwear retailer based in Arusha, Tanzania, offering shoes for men, women and children. Customers can explore available products and contact the store directly through WhatsApp or Instagram.',
        'story_image'           => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&w=1400&q=80&fm=webp',
        'community_headline'    => 'Join the Tanny Shoes Community',
        'community_text'        => 'Follow @tannyshoes_aimmall on Instagram to discover new footwear, product updates and the latest arrivals.',
        'community_button'      => 'Follow on Instagram',
        'newsletter_headline'   => 'Stay Updated',
        'newsletter_text'       => 'Leave your email if you would like updates when this website adds new catalogue information.',
        'footer_about'          => 'Tanny Shoes is a footwear retailer in Arusha, Tanzania. Browse demonstration products here and contact us on WhatsApp or Instagram for current availability.',
        'delivery_info'         => '',
        'returns_info'          => '',
        'accent_color'          => '#E91E8C',
        'secondary_color'       => '#7DD3FC',
        'whatsapp_greeting'     => 'Hello Tanny Shoes, I would like to enquire about your footwear.',
    );
}

function solehaus_default($key) {
    $defaults = solehaus_defaults();
    return isset($defaults[$key]) ? $defaults[$key] : '';
}

function solehaus_mod($key) {
    return get_theme_mod('solehaus_' . $key, solehaus_default($key));
}

/**
 * Related Instagram stores — editable in defaults; extend via Customiser later if needed.
 */
function solehaus_related_stores() {
    return array(
        array(
            'name'        => 'Tanny Shoes',
            'handle'      => 'tannyshoes_aimmall',
            'url'         => 'https://www.instagram.com/tannyshoes_aimmall/',
            'description' => 'Footwear for men, women and children.',
        ),
        array(
            'name'        => 'Tanny Beauty Store Arusha',
            'handle'      => 'tannybeautystore_arusha',
            'url'         => 'https://www.instagram.com/tannybeautystore_arusha/',
            'description' => 'Visit our related beauty-store page on Instagram.',
        ),
        array(
            'name'        => 'Tanny Arusha',
            'handle'      => 'tanny_arusha',
            'url'         => 'https://www.instagram.com/tanny_arusha/',
            'description' => 'Explore more products and updates from Tanny in Arusha.',
        ),
    );
}

/**
 * Demonstration catalogue — not real Tanny Shoes inventory.
 */
function solehaus_demo_products() {
    return array(
        array(
            'slug'        => 'demo-mens-casual-sneaker',
            'name'        => 'Demo — Men\'s Casual Sneaker',
            'category'    => 'Men\'s Shoes',
            'price'       => 85000,
            'sale_from'   => 0,
            'badge'       => 'Demo',
            'featured'    => true,
            'new'         => false,
            'gender'      => array('mens-shoes'),
            'categories'  => array('mens-shoes', 'sneakers', 'casual-shoes'),
            'sizes'       => array('40', '41', '42', '43', '44', '45'),
            'colours'     => array('Black', 'White'),
            'stock'       => 0,
            'short'       => 'Demonstration product for layout preview only.',
            'description' => 'This is a demonstration product. Contact Tanny Shoes on WhatsApp or Instagram for current styles, sizes and prices.',
            'image'       => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=900&h=900&q=80&fm=webp',
            'gallery'     => array(),
        ),
        array(
            'slug'        => 'demo-womens-platform-sneaker',
            'name'        => 'Demo — Women\'s Platform Sneaker',
            'category'    => 'Women\'s Shoes',
            'price'       => 90000,
            'sale_from'   => 0,
            'badge'       => 'Demo',
            'featured'    => true,
            'new'         => true,
            'gender'      => array('womens-shoes'),
            'categories'  => array('womens-shoes', 'sneakers'),
            'sizes'       => array('36', '37', '38', '39', '40', '41'),
            'colours'     => array('White', 'Black'),
            'stock'       => 0,
            'short'       => 'Demonstration product for layout preview only.',
            'description' => 'This is a demonstration product. Contact Tanny Shoes on WhatsApp or Instagram for current styles, sizes and prices.',
            'image'       => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=900&h=900&q=80&fm=webp',
            'gallery'     => array(),
        ),
        array(
            'slug'        => 'demo-kids-school-shoe',
            'name'        => 'Demo — Kids\' School Shoe',
            'category'    => 'Kids\' Shoes',
            'price'       => 55000,
            'sale_from'   => 0,
            'badge'       => 'Demo',
            'featured'    => true,
            'new'         => false,
            'gender'      => array('kids-shoes'),
            'categories'  => array('kids-shoes', 'formal-shoes'),
            'sizes'       => array('28', '29', '30', '31', '32', '33', '34', '35'),
            'colours'     => array('Black'),
            'stock'       => 0,
            'short'       => 'Demonstration product for layout preview only.',
            'description' => 'This is a demonstration product. Contact Tanny Shoes on WhatsApp or Instagram for current styles, sizes and prices.',
            'image'       => 'https://images.unsplash.com/photo-1515347659542-ec95166e6f24?auto=format&fit=crop&w=900&h=900&q=80&fm=webp',
            'gallery'     => array(),
        ),
        array(
            'slug'        => 'demo-formal-oxford',
            'name'        => 'Demo — Formal Oxford',
            'category'    => 'Formal Shoes',
            'price'       => 120000,
            'sale_from'   => 0,
            'badge'       => 'Demo',
            'featured'    => true,
            'new'         => false,
            'gender'      => array('mens-shoes'),
            'categories'  => array('formal-shoes', 'mens-shoes'),
            'sizes'       => array('40', '41', '42', '43', '44', '45'),
            'colours'     => array('Black', 'Brown'),
            'stock'       => 0,
            'short'       => 'Demonstration product for layout preview only.',
            'description' => 'This is a demonstration product. Contact Tanny Shoes on WhatsApp or Instagram for current styles, sizes and prices.',
            'image'       => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?auto=format&fit=crop&w=900&h=900&q=80&fm=webp',
            'gallery'     => array(),
        ),
        array(
            'slug'        => 'demo-everyday-runner',
            'name'        => 'Demo — Everyday Runner',
            'category'    => 'Sneakers',
            'price'       => 75000,
            'sale_from'   => 0,
            'badge'       => 'Demo',
            'featured'    => true,
            'new'         => false,
            'gender'      => array('mens-shoes', 'womens-shoes'),
            'categories'  => array('sneakers', 'casual-shoes'),
            'sizes'       => array('36', '37', '38', '39', '40', '41', '42', '43', '44'),
            'colours'     => array('Grey', 'Navy'),
            'stock'       => 0,
            'short'       => 'Demonstration product for layout preview only.',
            'description' => 'This is a demonstration product. Contact Tanny Shoes on WhatsApp or Instagram for current styles, sizes and prices.',
            'image'       => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=900&h=900&q=80&fm=webp',
            'gallery'     => array(),
        ),
        array(
            'slug'        => 'demo-casual-slip-on',
            'name'        => 'Demo — Casual Slip-On',
            'category'    => 'Casual Shoes',
            'price'       => 65000,
            'sale_from'   => 0,
            'badge'       => 'Demo',
            'featured'    => true,
            'new'         => false,
            'gender'      => array('mens-shoes', 'womens-shoes'),
            'categories'  => array('casual-shoes'),
            'sizes'       => array('36', '37', '38', '39', '40', '41', '42', '43', '44'),
            'colours'     => array('Navy', 'Beige'),
            'stock'       => 0,
            'short'       => 'Demonstration product for layout preview only.',
            'description' => 'This is a demonstration product. Contact Tanny Shoes on WhatsApp or Instagram for current styles, sizes and prices.',
            'image'       => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=900&h=900&q=80&fm=webp',
            'gallery'     => array(),
        ),
        array(
            'slug'        => 'demo-summer-sandal',
            'name'        => 'Demo — Summer Sandal',
            'category'    => 'Sandals',
            'price'       => 48000,
            'sale_from'   => 0,
            'badge'       => 'Demo',
            'featured'    => true,
            'new'         => false,
            'gender'      => array('womens-shoes'),
            'categories'  => array('sandals', 'womens-shoes'),
            'sizes'       => array('36', '37', '38', '39', '40', '41'),
            'colours'     => array('Black', 'Nude'),
            'stock'       => 0,
            'short'       => 'Demonstration product for layout preview only.',
            'description' => 'This is a demonstration product. Contact Tanny Shoes on WhatsApp or Instagram for current styles, sizes and prices.',
            'image'       => 'https://images.unsplash.com/photo-1603487742131-4160ec999306?auto=format&fit=crop&w=900&h=900&q=80&fm=webp',
            'gallery'     => array(),
        ),
        array(
            'slug'        => 'demo-anatomic-comfort',
            'name'        => 'Demo — Anatomic Comfort Shoe',
            'category'    => 'Anatomic Shoes',
            'price'       => 95000,
            'sale_from'   => 0,
            'badge'       => 'Demo',
            'featured'    => true,
            'new'         => true,
            'gender'      => array('mens-shoes', 'womens-shoes'),
            'categories'  => array('anatomic-shoes', 'casual-shoes'),
            'sizes'       => array('37', '38', '39', '40', '41', '42', '43', '44'),
            'colours'     => array('Black', 'Brown'),
            'stock'       => 0,
            'short'       => 'Demonstration product for layout preview only.',
            'description' => 'This is a demonstration product. Contact Tanny Shoes on WhatsApp or Instagram for current styles, sizes and prices.',
            'image'       => 'https://images.unsplash.com/photo-1533867617858-e7b97e060509?auto=format&fit=crop&w=900&h=900&q=80&fm=webp',
            'gallery'     => array(),
        ),
    );
}

function solehaus_demo_categories() {
    return array(
        array(
            'slug'  => 'mens-shoes',
            'name'  => 'Men\'s Shoes',
            'image' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?auto=format&fit=crop&w=800&h=1000&q=80&fm=webp',
            'alt'   => 'Men\'s leather shoes from Tanny Shoes collection preview',
        ),
        array(
            'slug'  => 'womens-shoes',
            'name'  => 'Women\'s Shoes',
            'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=800&h=1000&q=80&fm=webp',
            'alt'   => 'Women\'s fashion shoes from Tanny Shoes collection preview',
        ),
        array(
            'slug'  => 'kids-shoes',
            'name'  => 'Kids\' Shoes',
            'image' => 'https://images.unsplash.com/photo-1515347659542-ec95166e6f24?auto=format&fit=crop&w=800&h=1000&q=80&fm=webp',
            'alt'   => 'Children\'s shoes from Tanny Shoes collection preview',
        ),
        array(
            'slug'  => 'sneakers',
            'name'  => 'Sneakers',
            'image' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=800&h=1000&q=80&fm=webp',
            'alt'   => 'Sneakers from Tanny Shoes collection preview',
        ),
        array(
            'slug'  => 'formal-shoes',
            'name'  => 'Formal Shoes',
            'image' => 'https://images.unsplash.com/photo-1533867617858-e7b97e060509?auto=format&fit=crop&w=800&h=1000&q=80&fm=webp',
            'alt'   => 'Formal shoes from Tanny Shoes collection preview',
        ),
        array(
            'slug'  => 'casual-shoes',
            'name'  => 'Casual Shoes',
            'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=800&h=1000&q=80&fm=webp',
            'alt'   => 'Casual shoes from Tanny Shoes collection preview',
        ),
        array(
            'slug'  => 'sandals',
            'name'  => 'Sandals',
            'image' => 'https://images.unsplash.com/photo-1603487742131-4160ec999306?auto=format&fit=crop&w=800&h=1000&q=80&fm=webp',
            'alt'   => 'Sandals from Tanny Shoes collection preview',
        ),
        array(
            'slug'  => 'anatomic-shoes',
            'name'  => 'Anatomic Shoes',
            'image' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?auto=format&fit=crop&w=800&h=1000&q=80&fm=webp',
            'alt'   => 'Anatomic comfort shoes from Tanny Shoes collection preview',
        ),
    );
}

function solehaus_instagram_images() {
    return array(
        array('url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=700&h=700&q=80&fm=webp', 'alt' => 'Footwear style preview for Tanny Shoes Instagram'),
        array('url' => 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?auto=format&fit=crop&w=700&h=700&q=80&fm=webp', 'alt' => 'Sneaker style preview for Tanny Shoes Instagram'),
        array('url' => 'https://images.unsplash.com/photo-1515886657613-9f3515c0c79f?auto=format&fit=crop&w=700&h=700&q=80&fm=webp', 'alt' => 'Lifestyle footwear preview for Tanny Shoes Instagram'),
        array('url' => 'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?auto=format&fit=crop&w=700&h=700&q=80&fm=webp', 'alt' => 'Sports shoe preview for Tanny Shoes Instagram'),
        array('url' => 'https://images.unsplash.com/photo-1614252235316-8c857d38b5f4?auto=format&fit=crop&w=700&h=700&q=80&fm=webp', 'alt' => 'Formal shoe preview for Tanny Shoes Instagram'),
        array('url' => 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?auto=format&fit=crop&w=700&h=700&q=80&fm=webp', 'alt' => 'Casual shoe preview for Tanny Shoes Instagram'),
    );
}
