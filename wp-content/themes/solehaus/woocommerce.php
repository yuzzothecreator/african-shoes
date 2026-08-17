<?php
/**
 * WooCommerce wrapper.
 *
 * @package Solehaus
 */

get_header();

$is_archive = function_exists('is_shop') && (is_shop() || is_product_taxonomy());
?>
<main id="primary" class="sh-main sh-main--shop">
    <div class="sh-container<?php echo $is_archive ? ' sh-shop-layout' : ''; ?>">
        <?php if ($is_archive && is_active_sidebar('shop-sidebar')) : ?>
            <aside class="sh-shop-sidebar" aria-label="<?php esc_attr_e('Product filters', 'solehaus'); ?>">
                <?php dynamic_sidebar('shop-sidebar'); ?>
            </aside>
        <?php endif; ?>
        <div class="sh-shop-content">
            <?php woocommerce_content(); ?>
        </div>
    </div>
</main>
<?php
get_footer();
