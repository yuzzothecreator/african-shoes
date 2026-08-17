<?php
/**
 * New arrivals — horizontal scroller.
 *
 * @package Solehaus
 */
$products = solehaus_get_new_arrival_cards(6);
if (!$products) {
    $products = array_slice(solehaus_demo_products(), 0, 4);
}
?>
<section class="sh-section sh-section--mist" id="arrivals" aria-labelledby="sh-arrivals-title">
    <div class="sh-container">
        <div class="sh-section__head sh-section__head--row">
            <div>
                <p class="sh-kicker"><?php esc_html_e('Just in', 'solehaus'); ?></p>
                <h2 id="sh-arrivals-title"><?php esc_html_e('New Arrivals', 'solehaus'); ?></h2>
            </div>
            <a class="sh-text-link" href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>"><?php esc_html_e('View all', 'solehaus'); ?></a>
        </div>
        <div class="sh-rail" tabindex="0" aria-label="<?php esc_attr_e('New arrival products', 'solehaus'); ?>">
            <?php foreach ($products as $product) : ?>
                <?php solehaus_render_product_card($product, 'wide'); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
