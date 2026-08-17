<?php
/**
 * One-click demo catalogue, pages, and menus.
 *
 * @package Solehaus
 */

if (!defined('ABSPATH')) {
    exit;
}

function solehaus_admin_menu() {
    add_theme_page(
        __('Tanny Shoes Setup', 'solehaus'),
        __('Tanny Shoes Setup', 'solehaus'),
        'manage_options',
        'solehaus-setup',
        'solehaus_render_setup_page'
    );
}
add_action('admin_menu', 'solehaus_admin_menu');

function solehaus_admin_notice() {
    if (!current_user_can('manage_options')) {
        return;
    }
    if (get_option('solehaus_demo_imported')) {
        return;
    }
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if ($screen && $screen->id === 'appearance_page_solehaus-setup') {
        return;
    }
    $url = admin_url('themes.php?page=solehaus-setup');
    echo '<div class="notice notice-info"><p>';
    echo esc_html__('Tanny Shoes theme is active. Import the demo catalogue, pages, and menus to finish the storefront.', 'solehaus');
    echo ' <a class="button button-primary" href="' . esc_url($url) . '">' . esc_html__('Open setup', 'solehaus') . '</a>';
    echo '</p></div>';
}
add_action('admin_notices', 'solehaus_admin_notice');

function solehaus_handle_setup_actions() {
    if (!isset($_POST['solehaus_setup_action'])) {
        return;
    }
    if (!current_user_can('manage_options')) {
        return;
    }
    check_admin_referer('solehaus_setup');

    $action = sanitize_key($_POST['solehaus_setup_action']);
    if ($action === 'import') {
        $result = solehaus_import_demo();
        set_transient('solehaus_setup_result', $result, 60);
    }
    wp_safe_redirect(admin_url('themes.php?page=solehaus-setup'));
    exit;
}
add_action('admin_init', 'solehaus_handle_setup_actions');

function solehaus_render_setup_page() {
    if (!current_user_can('manage_options')) {
        return;
    }
    $result   = get_transient('solehaus_setup_result');
    delete_transient('solehaus_setup_result');
    $imported = (bool) get_option('solehaus_demo_imported');
    $woo      = class_exists('WooCommerce');
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Tanny Shoes Setup', 'solehaus'); ?></h1>
        <p><?php esc_html_e('This importer creates product categories, size and colour variations, sample products, the homepage, legal pages, and navigation. You can edit every detail afterwards from Products, Pages, and Appearance → Customise.', 'solehaus'); ?></p>

        <?php if (!$woo) : ?>
            <div class="notice notice-warning"><p>
                <?php esc_html_e('Install and activate WooCommerce first. It is the only required plugin.', 'solehaus'); ?>
                <a href="<?php echo esc_url(admin_url('plugin-install.php?s=woocommerce&tab=search&type=term')); ?>"><?php esc_html_e('Install WooCommerce', 'solehaus'); ?></a>
            </p></div>
        <?php endif; ?>

        <?php if (is_array($result)) : ?>
            <div class="notice notice-<?php echo empty($result['ok']) ? 'error' : 'success'; ?>"><p><?php echo esc_html($result['message']); ?></p></div>
        <?php endif; ?>

        <?php if ($imported) : ?>
            <p><strong><?php esc_html_e('Demo content has already been imported.', 'solehaus'); ?></strong> <?php esc_html_e('Running it again will skip products that already exist and refresh menus and pages if needed.', 'solehaus'); ?></p>
        <?php endif; ?>

        <form method="post">
            <?php wp_nonce_field('solehaus_setup'); ?>
            <input type="hidden" name="solehaus_setup_action" value="import">
            <?php submit_button($imported ? __('Re-run setup', 'solehaus') : __('Import demo store', 'solehaus'), 'primary', 'submit', false); ?>
        </form>

        <h2><?php esc_html_e('After import', 'solehaus'); ?></h2>
        <ol>
            <li><?php esc_html_e('Open Appearance → Customise → Tanny Shoes to review WhatsApp, Instagram, follower count, and homepage copy.', 'solehaus'); ?></li>
            <li><?php esc_html_e('Replace the logo under Site Identity.', 'solehaus'); ?></li>
            <li><?php esc_html_e('Edit products, stock, sale prices, and galleries under Products.', 'solehaus'); ?></li>
            <li><?php esc_html_e('Optional: install Elementor if you prefer drag-and-drop page building. The homepage also works in the block editor.', 'solehaus'); ?></li>
            <li><?php esc_html_e('Keep plugins to WooCommerce plus one SEO plugin if you want extra sitemaps or breadcrumbs. Core already provides /wp-sitemap.xml.', 'solehaus'); ?></li>
        </ol>
    </div>
    <?php
}

function solehaus_import_demo() {
    if (!class_exists('WooCommerce')) {
        return array('ok' => false, 'message' => __('Activate WooCommerce before importing.', 'solehaus'));
    }

    if (!function_exists('media_sideload_image')) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }

    solehaus_woocommerce_setup_defaults();
    $cats = solehaus_import_categories();
    solehaus_import_attributes();
    $count = solehaus_import_products($cats);
    solehaus_import_pages();
    solehaus_import_menus();
    solehaus_seed_shop_widgets();
    if (!get_option('permalink_structure')) {
        update_option('permalink_structure', '/%postname%/');
        flush_rewrite_rules();
    }
    update_option('solehaus_demo_imported', 1);

    return array(
        'ok'      => true,
        'message' => sprintf(__('Setup complete. %d products are ready. Update your real phone number and WhatsApp in Appearance → Customise.', 'solehaus'), $count),
    );
}

function solehaus_import_categories() {
    $map = array();
    $terms = array_merge(
        solehaus_demo_categories(),
        array(
            array('slug' => 'mens-shoes', 'name' => 'Men', 'image' => '', 'alt' => ''),
            array('slug' => 'womens-shoes', 'name' => 'Women', 'image' => '', 'alt' => ''),
            array('slug' => 'kids-shoes', 'name' => 'Kids', 'image' => '', 'alt' => ''),
        )
    );

    foreach ($terms as $cat) {
        $existing = term_exists($cat['slug'], 'product_cat');
        if ($existing) {
            $term_id = (int) (is_array($existing) ? $existing['term_id'] : $existing);
        } else {
            $created = wp_insert_term($cat['name'], 'product_cat', array(
                'slug' => $cat['slug'],
            ));
            if (is_wp_error($created)) {
                continue;
            }
            $term_id = (int) $created['term_id'];
        }
        $map[$cat['slug']] = $term_id;
        if (!empty($cat['image'])) {
            $image_id = solehaus_sideload_image($cat['image'], 0, $cat['name'] . ' category');
            if ($image_id) {
                update_term_meta($term_id, 'thumbnail_id', $image_id);
            }
        }
    }

    $tag = term_exists('new-arrivals', 'product_tag');
    if (!$tag) {
        wp_insert_term('New Arrivals', 'product_tag', array('slug' => 'new-arrivals'));
    }

    return $map;
}

function solehaus_import_attributes() {
    $attributes = array(
        'size'   => array('label' => 'Size', 'terms' => array('36', '37', '38', '39', '40', '41', '42', '43', '44', '45')),
        'colour' => array('label' => 'Colour', 'terms' => array('Black', 'White', 'Brown', 'Navy', 'Grey', 'Beige', 'Nude', 'Khaki', 'Pink')),
    );

    foreach ($attributes as $slug => $data) {
        $id = wc_attribute_taxonomy_id_by_name($slug);
        if (!$id) {
            wc_create_attribute(array(
                'name'         => $data['label'],
                'slug'         => $slug,
                'type'         => 'select',
                'order_by'     => 'menu_order',
                'has_archives' => false,
            ));
        }
    }

    delete_transient('wc_attribute_taxonomies');
    if (class_exists('WC_Cache_Helper')) {
        WC_Cache_Helper::invalidate_cache_group('woocommerce-attributes');
    }

    foreach ($attributes as $slug => $data) {
        $taxonomy = wc_attribute_taxonomy_name($slug);
        if (!taxonomy_exists($taxonomy)) {
            register_taxonomy($taxonomy, array('product'), array(
                'hierarchical' => false,
                'label'        => $data['label'],
                'query_var'    => true,
                'rewrite'      => false,
            ));
        }
        foreach ($data['terms'] as $term_name) {
            if (!term_exists($term_name, $taxonomy)) {
                wp_insert_term($term_name, $taxonomy);
            }
        }
    }
}

function solehaus_import_products($cats) {
    $created = 0;
    foreach (solehaus_demo_products() as $index => $item) {
        $existing = get_page_by_path($item['slug'], OBJECT, 'product');
        if ($existing) {
            continue;
        }

        $product = new WC_Product_Variable();
        $product->set_name($item['name']);
        $product->set_slug($item['slug']);
        $product->set_status('publish');
        $product->set_catalog_visibility('visible');
        $product->set_description($item['description']);
        $product->set_short_description($item['short']);
        $product->set_sku('SH-' . strtoupper(substr(preg_replace('/[^a-z0-9]/i', '', $item['slug']), 0, 8)) . '-' . ($index + 1));
        $product->set_featured(!empty($item['featured']));
        $product->set_manage_stock(false);
        $product->set_stock_status('instock');
        $product->set_sold_individually(false);
        $product->set_menu_order($index + 1);

        $cat_ids = array();
        foreach (array_merge($item['categories'], $item['gender']) as $slug) {
            if (!empty($cats[$slug])) {
                $cat_ids[] = $cats[$slug];
            }
        }
        $product->set_category_ids(array_unique($cat_ids));

        if (!empty($item['new'])) {
            $tag = get_term_by('slug', 'new-arrivals', 'product_tag');
            if ($tag) {
                $product->set_tag_ids(array($tag->term_id));
            }
        }

        $size_attr = solehaus_build_attribute('pa_size', $item['sizes']);
        $colour_attr = solehaus_build_attribute('pa_colour', $item['colours']);
        $product->set_attributes(array($size_attr, $colour_attr));
        $product->save();

        if (!empty($item['badge'])) {
            update_post_meta($product->get_id(), '_solehaus_badge', $item['badge']);
        }

        $image_id = solehaus_sideload_image($item['image'], $product->get_id(), $item['name']);
        if ($image_id) {
            $product->set_image_id($image_id);
        }
        $gallery = array();
        foreach ($item['gallery'] as $gallery_url) {
            $gid = solehaus_sideload_image($gallery_url, $product->get_id(), $item['name'] . ' gallery');
            if ($gid) {
                $gallery[] = $gid;
            }
        }
        if ($gallery) {
            $product->set_gallery_image_ids($gallery);
        }
        $product->save();

        foreach ($item['sizes'] as $size) {
            foreach ($item['colours'] as $colour) {
                $variation = new WC_Product_Variation();
                $variation->set_parent_id($product->get_id());
                $variation->set_attributes(array(
                    'pa_size'   => sanitize_title($size),
                    'pa_colour' => sanitize_title($colour),
                ));
                $variation->set_regular_price((string) ($item['sale_from'] ? $item['sale_from'] : $item['price']));
                if (!empty($item['sale_from']) && $item['sale_from'] > $item['price']) {
                    $variation->set_sale_price((string) $item['price']);
                } else {
                    $variation->set_regular_price((string) $item['price']);
                }
                $variation->set_manage_stock(true);
                $variation->set_stock_quantity((int) $item['stock']);
                $variation->set_stock_status('instock');
                $variation->set_virtual(false);
                $variation->save();
            }
        }

        WC_Product_Variable::sync($product->get_id());
        $created++;
    }
    return $created;
}

function solehaus_build_attribute($taxonomy, $options) {
    $attribute = new WC_Product_Attribute();
    $attribute->set_id(wc_attribute_taxonomy_id_by_name(str_replace('pa_', '', $taxonomy)));
    $attribute->set_name($taxonomy);
    $attribute->set_options($options);
    $attribute->set_visible(true);
    $attribute->set_variation(true);
    return $attribute;
}

function solehaus_sideload_image($url, $parent_id = 0, $alt = '') {
    if (!$url) {
        return 0;
    }
    $tmp = download_url($url, 20);
    if (is_wp_error($tmp)) {
        return 0;
    }
    $file_array = array(
        'name'     => sanitize_file_name(basename(parse_url($url, PHP_URL_PATH))) . '.jpg',
        'tmp_name' => $tmp,
    );
    $id = media_handle_sideload($file_array, $parent_id, $alt);
    if (is_wp_error($id)) {
        @unlink($tmp);
        return 0;
    }
    if ($alt) {
        update_post_meta($id, '_wp_attachment_image_alt', $alt);
    }
    return (int) $id;
}

function solehaus_import_pages() {
    $pages = array(
        'home' => array(
            'title'   => 'Home',
            'content' => '',
            'template'=> '',
        ),
        'contact' => array(
            'title'   => 'Contact',
            'content' => "<!-- wp:paragraph --><p>Contact Tanny Shoes in Arusha, Tanzania on WhatsApp or Instagram. Edit contact details under Appearance → Customise → Tanny Shoes.</p><!-- /wp:paragraph -->",
        ),
        'about' => array(
            'title'   => 'About',
            'content' => '',
        ),
        'privacy-policy' => array(
            'title'   => 'Privacy Policy',
            'content' => solehaus_privacy_content(),
        ),
        'terms' => array(
            'title'   => 'Terms and Conditions',
            'content' => solehaus_terms_content(),
        ),
        'delivery-and-returns' => array(
            'title'   => 'Delivery and Returns',
            'content' => solehaus_delivery_page_content(),
        ),
    );

    $created_ids = array();
    foreach ($pages as $slug => $page) {
        $existing = get_page_by_path($slug);
        if ($existing) {
            $created_ids[$slug] = $existing->ID;
            continue;
        }
        $id = wp_insert_post(array(
            'post_title'   => $page['title'],
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => $page['content'],
        ));
        if (!is_wp_error($id)) {
            $created_ids[$slug] = $id;
        }
    }

    if (!empty($created_ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $created_ids['home']);
    }
    if (!empty($created_ids['privacy-policy'])) {
        update_option('wp_page_for_privacy_policy', $created_ids['privacy-policy']);
    }

    $shop_id = wc_get_page_id('shop');
    if ($shop_id > 0) {
        wp_update_post(array(
            'ID'           => $shop_id,
            'post_title'   => 'Shop',
            'post_content' => '',
        ));
    }
}

function solehaus_import_menus() {
    $shop = wc_get_page_permalink('shop');
    $contact = get_page_by_path('contact');
    $about = get_page_by_path('about');
    $contact_url = $contact ? get_permalink($contact) : home_url('/contact/');
    $about_url = $about ? get_permalink($about) : home_url('/about/');
    $primary_items = array(
        'Home'         => home_url('/'),
        'Shop'         => $shop,
        'Men'          => solehaus_term_link('mens-shoes'),
        'Women'        => solehaus_term_link('womens-shoes'),
        'Kids'         => solehaus_term_link('kids-shoes'),
        'New Arrivals' => home_url('/#arrivals'),
        'Our Stores'   => home_url('/#stores'),
        'Contact'      => $contact_url,
    );
    solehaus_save_menu('Solehaus Primary', 'primary', $primary_items);

    solehaus_save_menu('Solehaus Quick Links', 'footer_quick', array(
        'Home'         => home_url('/'),
        'Shop'         => $shop,
        'About'        => $about_url,
        'New Arrivals' => home_url('/#arrivals'),
        'Contact'      => $contact_url,
    ));

    $cats = array();
    foreach (solehaus_demo_categories() as $cat) {
        $cats[$cat['name']] = solehaus_term_link($cat['slug']);
    }
    solehaus_save_menu('Solehaus Categories', 'footer_categories', $cats);

    $privacy = get_page_by_path('privacy-policy');
    $terms   = get_page_by_path('terms');
    $delivery = get_page_by_path('delivery-and-returns');
    solehaus_save_menu('Solehaus Support', 'footer_support', array(
        'Contact'              => $contact_url,
        'Delivery and Returns' => $delivery ? get_permalink($delivery) : home_url('/delivery-and-returns/'),
        'Privacy Policy'       => $privacy ? get_permalink($privacy) : home_url('/privacy-policy/'),
        'Terms and Conditions' => $terms ? get_permalink($terms) : home_url('/terms/'),
    ));
}

function solehaus_save_menu($name, $location, $items) {
    $menu = wp_get_nav_menu_object($name);
    if (!$menu) {
        $menu_id = wp_create_nav_menu($name);
    } else {
        $menu_id = (int) $menu->term_id;
        $existing_items = wp_get_nav_menu_items($menu_id);
        if ($existing_items) {
            return;
        }
    }

    $order = 1;
    foreach ($items as $label => $url) {
        if (!$url || is_wp_error($url)) {
            continue;
        }
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title'  => $label,
            'menu-item-url'    => esc_url_raw($url),
            'menu-item-status' => 'publish',
            'menu-item-type'   => 'custom',
            'menu-item-position' => $order++,
        ));
    }

    $locations = get_theme_mod('nav_menu_locations', array());
    $locations[$location] = (int) $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

function solehaus_seed_shop_widgets() {
    $sidebars = get_option('sidebars_widgets', array());
    if (!empty($sidebars['shop-sidebar'])) {
        return;
    }

    $search = get_option('widget_woocommerce_product_search', array('_multiwidget' => 1));
    $search[2] = array('title' => 'Search shoes');
    $search['_multiwidget'] = 1;
    update_option('widget_woocommerce_product_search', $search);

    $cats = get_option('widget_woocommerce_product_categories', array('_multiwidget' => 1));
    $cats[2] = array(
        'title'        => 'Categories',
        'orderby'      => 'name',
        'dropdown'     => 0,
        'count'        => 1,
        'hierarchical' => 1,
        'show_children_only' => 0,
        'hide_empty'   => 1,
        'max_depth'    => '',
    );
    $cats['_multiwidget'] = 1;
    update_option('widget_woocommerce_product_categories', $cats);

    $price = get_option('widget_woocommerce_price_filter', array('_multiwidget' => 1));
    $price[2] = array('title' => 'Filter by price');
    $price['_multiwidget'] = 1;
    update_option('widget_woocommerce_price_filter', $price);

    $sidebars['shop-sidebar'] = array(
        'woocommerce_product_search-2',
        'woocommerce_product_categories-2',
        'woocommerce_price_filter-2',
    );
    if (!isset($sidebars['wp_inactive_widgets'])) {
        $sidebars['wp_inactive_widgets'] = array();
    }
    update_option('sidebars_widgets', $sidebars);
}

function solehaus_privacy_content() {
    $name = solehaus_store_name();
    return '<!-- wp:heading --><h2>Privacy Policy</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>' . esc_html($name) . ' collects only the information needed to complete orders, answer WhatsApp messages, and send updates you asked for. This page is a starting point. Replace it with advice from your own legal counsel before trading at scale.</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":3} --><h3>What we collect</h3><!-- /wp:heading -->
<!-- wp:paragraph --><p>When you order or write to us we may keep your name, phone number, WhatsApp number, delivery address, email, size preferences, and order history. Newsletter sign-ups store the email address you submit.</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":3} --><h3>How we use it</h3><!-- /wp:heading -->
<!-- wp:paragraph --><p>We use this information to confirm stock, arrange delivery, process payments, and reply to you. We do not sell customer lists. Payment processors and delivery partners receive only what they need to complete their work.</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":3} --><h3>Your choices</h3><!-- /wp:heading -->
<!-- wp:paragraph --><p>You can ask us to correct or delete your details by email or WhatsApp. You can unsubscribe from the newsletter at any time by writing to the store email in the footer.</p><!-- /wp:paragraph -->';
}

function solehaus_terms_content() {
    $name = solehaus_store_name();
    return '<!-- wp:heading --><h2>Terms and Conditions</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>These terms describe how ' . esc_html($name) . ' sells footwear in Tanzania. Edit this page so it matches how you actually take payment, deliver, and handle size issues.</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":3} --><h3>Orders</h3><!-- /wp:heading -->
<!-- wp:paragraph --><p>An order is confirmed when we accept it on WhatsApp or when checkout payment is completed. Prices are shown in Tanzanian shillings (TZS) and may change until an order is confirmed. Stock is limited; if a size sells out we will tell you and offer a wait, exchange, or refund of any amount already paid.</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":3} --><h3>Payment</h3><!-- /wp:heading -->
<!-- wp:paragraph --><p>We accept the methods shown at checkout and those we confirm on WhatsApp, which may include mobile money, bank transfer, or card. Do not send money to numbers that are not listed on this website.</p><!-- /wp:paragraph -->
<!-- wp:heading {"level":3} --><h3>Delivery and collection</h3><!-- /wp:heading -->
<!-- wp:paragraph --><p>Delivery times are estimates, not guarantees. Risk in the goods passes when you collect them or when they are handed to you by the rider or courier.</p><!-- /wp:paragraph -->';
}

function solehaus_delivery_page_content() {
    return '<!-- wp:heading --><h2>Delivery</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>' . esc_html(solehaus_mod('delivery_info')) . '</p><!-- /wp:paragraph -->
<!-- wp:heading --><h2>Returns</h2><!-- /wp:heading -->
<!-- wp:paragraph --><p>' . esc_html(solehaus_mod('returns_info')) . '</p><!-- /wp:paragraph -->';
}
