<?php
/**
 * Shared helpers.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_store_name() {
    $name = solehaus_mod('store_name');
    return $name ? $name : get_bloginfo('name');
}

function solehaus_format_tzs($amount) {
    $amount = (int) $amount;
    return 'TZS ' . number_format($amount, 0, '.', ',');
}

function solehaus_whatsapp_digits($raw = '') {
    $raw = $raw ? $raw : solehaus_mod('whatsapp');
    $digits = preg_replace('/\D+/', '', (string) $raw);
    if (strpos($digits, '0') === 0 && strlen($digits) === 10) {
        $digits = '255' . substr($digits, 1);
    }
    return $digits;
}

function solehaus_whatsapp_url($message = '') {
    $configured = solehaus_mod('whatsapp_url');
    if (!$message) {
        return $configured ? $configured : 'https://wa.me/' . solehaus_whatsapp_digits();
    }
    $digits = solehaus_whatsapp_digits();
    return 'https://wa.me/' . $digits . '?text=' . rawurlencode($message);
}

function solehaus_instagram_handle() {
    $handle = ltrim((string) solehaus_mod('instagram'), '@');
    return $handle;
}

function solehaus_nav_fallback($args = array()) {
    $shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
    $contact = get_page_by_path('contact');
    $contact_url = $contact ? get_permalink($contact) : home_url('/contact/');
    $items = array(
        array('Home', home_url('/')),
        array('Shop', $shop),
        array('Men', solehaus_term_link('mens-shoes')),
        array('Women', solehaus_term_link('womens-shoes')),
        array('Kids', solehaus_term_link('kids-shoes')),
        array('New Arrivals', home_url('/#arrivals')),
        array('Our Stores', home_url('/#stores')),
        array('Contact', $contact_url),
    );

    echo '<ul class="' . esc_attr($args['menu_class'] ?? 'sh-nav') . '">';
    foreach ($items as $item) {
        echo '<li><a href="' . esc_url($item[1]) . '">' . esc_html($item[0]) . '</a></li>';
    }
    echo '</ul>';
}

function solehaus_term_link($slug) {
    if (taxonomy_exists('product_cat')) {
        $term = get_term_by('slug', $slug, 'product_cat');
        if ($term && !is_wp_error($term)) {
            return get_term_link($term);
        }
    }
    return function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
}

function solehaus_category_url($slug) {
    return solehaus_term_link($slug);
}

function solehaus_product_url($slug) {
    if (function_exists('wc_get_product_id_by_sku') || post_type_exists('product')) {
        $post = get_page_by_path($slug, OBJECT, 'product');
        if ($post) {
            return get_permalink($post);
        }
    }
    return home_url('/#featured');
}

function solehaus_cart_url() {
    if (function_exists('wc_get_cart_url')) {
        return wc_get_cart_url();
    }
    return home_url('/cart/');
}

function solehaus_cart_count() {
    if (function_exists('WC') && WC()->cart) {
        return (int) WC()->cart->get_cart_contents_count();
    }
    return 0;
}

function solehaus_accent_css() {
    $accent = sanitize_hex_color(solehaus_mod('accent_color'));
    $secondary = sanitize_hex_color(solehaus_mod('secondary_color'));
    if (!$accent) {
        $accent = '#E91E8C';
    }
    if (!$secondary) {
        $secondary = '#7DD3FC';
    }
    return ':root{--sh-accent:' . $accent . ';--sh-accent-secondary:' . $secondary . ';}';
}

function solehaus_stars($rating) {
    $rating = max(1, min(5, (int) $rating));
    $html = '<span class="sh-stars" aria-label="' . esc_attr($rating . ' out of 5 stars') . '">';
    for ($i = 1; $i <= 5; $i++) {
        $html .= $i <= $rating
            ? '<span aria-hidden="true">★</span>'
            : '<span class="is-empty" aria-hidden="true">★</span>';
    }
    $html .= '</span>';
    return $html;
}

function solehaus_nl2p($text) {
    $parts = preg_split('/\n+/', trim((string) $text));
    $out = '';
    foreach ($parts as $part) {
        if ($part !== '') {
            $out .= '<p>' . esc_html($part) . '</p>';
        }
    }
    return $out;
}

/**
 * @param array $product Demo product array or Woo product mapped array.
 */
function solehaus_render_product_card($product, $variant = 'grid') {
    $name       = $product['name'];
    $price      = (int) $product['price'];
    $sale_from  = (int) ($product['sale_from'] ?? 0);
    $badge      = $product['badge'] ?? '';
    $category   = $product['category'] ?? '';
    $image      = $product['image'];
    $alt        = $product['image_alt'] ?? ($name . ' — Tanny Shoes product preview');
    $sizes      = $product['sizes'] ?? array();
    $permalink  = $product['permalink'] ?? solehaus_product_url($product['slug'] ?? '');
    $product_id = $product['id'] ?? 0;
    $wa_message = solehaus_product_whatsapp_message($name, $price, $permalink, '');

    if (!$category && !empty($product['categories']) && is_array($product['categories'])) {
        $first = reset($product['categories']);
        $category = is_string($first) ? ucwords(str_replace('-', ' ', $first)) : '';
    }

    $class = 'sh-card' . ($variant === 'wide' ? ' sh-card--wide' : '');
    ?>
    <article class="<?php echo esc_attr($class); ?>" data-product-name="<?php echo esc_attr($name); ?>" data-product-price="<?php echo esc_attr((string) $price); ?>" data-product-url="<?php echo esc_url($permalink); ?>" data-product-id="<?php echo esc_attr((string) $product_id); ?>">
        <a class="sh-card__media" href="<?php echo esc_url($permalink); ?>">
            <?php if ($badge) : ?>
                <span class="sh-badge sh-badge--<?php echo esc_attr(strtolower($badge)); ?>"><?php echo esc_html($badge); ?></span>
            <?php endif; ?>
            <span class="sh-card__media-inner">
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($alt); ?>" width="640" height="640" loading="lazy" decoding="async">
            </span>
        </a>
        <div class="sh-card__body">
            <div class="sh-card__top">
                <?php if ($category) : ?>
                    <p class="sh-card__category"><?php echo esc_html($category); ?></p>
                <?php endif; ?>
            </div>
            <h3 class="sh-card__title">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($name); ?></a>
            </h3>
            <div class="sh-card__price-row">
                <p class="sh-card__price">
                    <span class="sh-price"><?php echo esc_html(solehaus_format_tzs($price)); ?></span>
                    <?php if ($sale_from > $price) : ?>
                        <s class="sh-price sh-price--was"><?php echo esc_html(solehaus_format_tzs($sale_from)); ?></s>
                    <?php endif; ?>
                </p>
            </div>
            <?php if ($sizes) : ?>
                <label class="sh-card__sizes">
                    <span class="sh-card__sizes-label"><?php esc_html_e('Select size', 'solehaus'); ?></span>
                    <select class="sh-size" aria-label="<?php echo esc_attr(sprintf('Select size for %s', $name)); ?>">
                        <option value=""><?php esc_html_e('Choose size', 'solehaus'); ?></option>
                        <?php foreach ($sizes as $size) : ?>
                            <option value="<?php echo esc_attr($size); ?>"><?php echo esc_html($size); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            <?php endif; ?>
            <div class="sh-card__actions">
                <a class="sh-btn sh-btn--outline sh-btn--view" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr(sprintf(__('View product: %s', 'solehaus'), $name)); ?>">
                    <?php esc_html_e('View', 'solehaus'); ?>
                </a>
                <a class="sh-btn sh-btn--whatsapp sh-wa-order" href="<?php echo esc_url(solehaus_whatsapp_url($wa_message)); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr(sprintf(__('Order %s on WhatsApp', 'solehaus'), $name)); ?>">
                    <?php esc_html_e('WhatsApp', 'solehaus'); ?>
                </a>
            </div>
        </div>
    </article>
    <?php
}

function solehaus_map_wc_product($product) {
    if (!$product instanceof WC_Product) {
        return null;
    }

    $regular = (float) $product->get_regular_price();
    $sale    = (float) $product->get_sale_price();
    $price   = (float) $product->get_price();
    if ($product->is_type('variable')) {
        $price   = (float) $product->get_variation_price('min', true);
        $regular = (float) $product->get_variation_regular_price('max', true);
        $sale    = $product->is_on_sale() ? $price : 0;
    }

    $sizes = array();
    $attrs = $product->get_attributes();
    foreach ($attrs as $attr) {
        if (!$attr instanceof WC_Product_Attribute) {
            continue;
        }
        $name = strtolower($attr->get_name());
        if (strpos($name, 'size') === false && $name !== 'pa_size') {
            continue;
        }
        if ($attr->is_taxonomy()) {
            $terms = wc_get_product_terms($product->get_id(), $attr->get_name(), array('fields' => 'names'));
            $sizes = $terms;
        } else {
            $sizes = $attr->get_options();
        }
    }

    $badge = '';
    if ($product->is_on_sale()) {
        $badge = 'Sale';
    } elseif ($product->get_meta('_solehaus_badge') === 'New' || has_term('new-arrivals', 'product_tag', $product->get_id())) {
        $badge = 'New';
    }

    $image_id = $product->get_image_id();
    $image    = $image_id ? wp_get_attachment_image_url($image_id, 'solehaus-card') : wc_placeholder_img_src('woocommerce_single');
    $alt      = $image_id ? get_post_meta($image_id, '_wp_attachment_image_alt', true) : $product->get_name();

    $cats = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'names'));
    $category = (!is_wp_error($cats) && $cats) ? $cats[0] : '';

    return array(
        'id'         => $product->get_id(),
        'slug'       => $product->get_slug(),
        'name'       => $product->get_name(),
        'category'   => $category,
        'price'      => $sale && $sale < $regular ? $sale : $price,
        'sale_from'  => ($sale && $sale < $regular) ? $regular : (($product->is_on_sale() && $regular > $price) ? $regular : 0),
        'badge'      => $badge,
        'sizes'      => $sizes,
        'image'      => $image,
        'image_alt'  => $alt ? $alt : $product->get_name(),
        'permalink'  => $product->get_permalink(),
    );
}

function solehaus_get_featured_cards($limit = 8) {
    if (function_exists('wc_get_products')) {
        $products = wc_get_products(array(
            'status'   => 'publish',
            'limit'    => $limit,
            'featured' => true,
            'orderby'  => 'menu_order',
            'order'    => 'ASC',
        ));
        if (count($products) < $limit) {
            $extra = wc_get_products(array(
                'status'  => 'publish',
                'limit'   => $limit,
                'exclude' => wp_list_pluck($products, 'id'),
                'orderby' => 'date',
            ));
            $products = array_merge($products, $extra);
        }
        $cards = array();
        foreach (array_slice($products, 0, $limit) as $product) {
            $mapped = solehaus_map_wc_product($product);
            if ($mapped) {
                $cards[] = $mapped;
            }
        }
        if ($cards) {
            return $cards;
        }
    }
    return array_slice(solehaus_demo_products(), 0, $limit);
}

function solehaus_get_new_arrival_cards($limit = 6) {
    if (function_exists('wc_get_products')) {
        $products = wc_get_products(array(
            'status' => 'publish',
            'limit'  => $limit,
            'tag'    => array('new-arrivals'),
        ));
        if (!$products) {
            $products = wc_get_products(array(
                'status'  => 'publish',
                'limit'   => $limit,
                'orderby' => 'date',
                'order'   => 'DESC',
            ));
        }
        $cards = array();
        foreach ($products as $product) {
            $mapped = solehaus_map_wc_product($product);
            if ($mapped) {
                $cards[] = $mapped;
            }
        }
        if ($cards) {
            return $cards;
        }
    }
    $all = solehaus_demo_products();
    return array_values(array_filter($all, function ($item) {
        return !empty($item['new']);
    }));
}
