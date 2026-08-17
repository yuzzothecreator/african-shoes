<?php
/**
 * Product loop card — uses Tanny Shoes card component.
 *
 * @package Solehaus
 */

defined('ABSPATH') || exit;

global $product;

if (!$product instanceof WC_Product) {
    return;
}

$mapped = solehaus_map_wc_product($product);
if (!$mapped) {
    return;
}
?>
<li <?php wc_product_class('', $product); ?>>
    <?php solehaus_render_product_card($mapped); ?>
</li>
