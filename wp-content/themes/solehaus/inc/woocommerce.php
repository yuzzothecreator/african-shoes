<?php
/**
 * WooCommerce integration.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_is_woocommerce() {
    return class_exists('WooCommerce');
}

function solehaus_woocommerce_setup_defaults() {
    if (!solehaus_is_woocommerce()) {
        return;
    }
    if (get_option('solehaus_wc_configured')) {
        return;
    }

    update_option('woocommerce_currency', 'TZS');
    update_option('woocommerce_currency_pos', 'left_space');
    update_option('woocommerce_price_thousand_sep', ',');
    update_option('woocommerce_price_decimal_sep', '.');
    update_option('woocommerce_price_num_decimals', 0);
    update_option('woocommerce_default_country', 'TZ:TZ-02');
    update_option('woocommerce_specific_allowed_countries', array('TZ'));
    update_option('woocommerce_allowed_countries', 'specific');
    update_option('woocommerce_enable_guest_checkout', 'yes');
    update_option('woocommerce_enable_reviews', 'yes');
    update_option('woocommerce_review_rating_required', 'yes');
    update_option('woocommerce_weight_unit', 'kg');
    update_option('woocommerce_dimension_unit', 'cm');
    update_option('solehaus_wc_configured', 1);
}
add_action('after_setup_theme', 'solehaus_woocommerce_setup_defaults', 40);

function solehaus_loop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'solehaus_loop_columns');

function solehaus_products_per_page() {
    return 12;
}
add_filter('loop_shop_per_page', 'solehaus_products_per_page');

function solehaus_related_products_args($args) {
    $args['posts_per_page'] = 4;
    $args['columns']        = 4;
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'solehaus_related_products_args');

function solehaus_remove_wc_styles($styles) {
    unset($styles['woocommerce-general']);
    return $styles;
}
add_filter('woocommerce_enqueue_styles', 'solehaus_remove_wc_styles');

function solehaus_remove_default_wrappers() {
    remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
}
add_action('wp', 'solehaus_remove_default_wrappers');

function solehaus_ajax_add_to_cart() {
    check_ajax_referer('solehaus_front', 'nonce');

    if (!solehaus_is_woocommerce()) {
        wp_send_json_error(array('message' => __('WooCommerce is not active.', 'solehaus')), 400);
    }

    $product_id = absint($_POST['product_id'] ?? 0);
    $size       = sanitize_text_field(wp_unslash($_POST['size'] ?? ''));
    $qty        = 1;

    if (!$product_id) {
        wp_send_json_error(array('message' => __('Missing product.', 'solehaus')), 400);
    }

    $product = wc_get_product($product_id);
    if (!$product) {
        wp_send_json_error(array('message' => __('Product not found.', 'solehaus')), 404);
    }

    $variation_id = 0;
    $variation    = array();

    if ($product->is_type('variable') && $size) {
        foreach ($product->get_children() as $child_id) {
            $child = wc_get_product($child_id);
            if (!$child) {
                continue;
            }
            $attrs = $child->get_attributes();
            foreach ($attrs as $value) {
                if (strcasecmp((string) $value, $size) === 0) {
                    $variation_id = $child_id;
                    $variation    = $child->get_variation_attributes();
                    break 2;
                }
            }
        }
        if (!$variation_id) {
            wp_send_json_error(array('message' => __('That size is not available.', 'solehaus')), 400);
        }
        $added = WC()->cart->add_to_cart($product_id, $qty, $variation_id, $variation);
    } else {
        $added = WC()->cart->add_to_cart($product_id, $qty);
    }

    if (!$added) {
        wp_send_json_error(array('message' => __('Could not add this item to the cart.', 'solehaus')), 400);
    }

    wp_send_json_success(array(
        'count'   => WC()->cart->get_cart_contents_count(),
        'message' => __('Added to cart.', 'solehaus'),
        'cartUrl' => wc_get_cart_url(),
    ));
}
add_action('wp_ajax_solehaus_add_to_cart', 'solehaus_ajax_add_to_cart');
add_action('wp_ajax_nopriv_solehaus_add_to_cart', 'solehaus_ajax_add_to_cart');

function solehaus_cart_fragments($fragments) {
    ob_start();
    ?>
    <span class="sh-cart-count" data-count="<?php echo esc_attr((string) solehaus_cart_count()); ?>"><?php echo esc_html((string) solehaus_cart_count()); ?></span>
    <?php
    $fragments['span.sh-cart-count'] = ob_get_clean();
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'solehaus_cart_fragments');

function solehaus_shop_toolbar_copy() {
    if (is_shop()) {
        echo '<p class="sh-shop-intro">' . esc_html__('Browse sneakers, formal shoes, casual pairs, sports shoes, and sandals. Filter by category or search by name. Prices are in Tanzanian shillings.', 'solehaus') . '</p>';
    }
}
add_action('woocommerce_archive_description', 'solehaus_shop_toolbar_copy', 15);

function solehaus_show_product_search($form) {
    return $form;
}

function solehaus_register_product_filter_shortcode() {
    add_shortcode('solehaus_product_search', function () {
        if (!solehaus_is_woocommerce()) {
            return '';
        }
        ob_start();
        get_product_search_form();
        return ob_get_clean();
    });
}
add_action('init', 'solehaus_register_product_filter_shortcode');
