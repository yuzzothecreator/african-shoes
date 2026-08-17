<?php
/**
 * Featured products grid.
 *
 * @package Solehaus
 */
$products = solehaus_get_featured_cards(8);
?>
<section class="sh-section sh-section--mist" id="featured" aria-labelledby="sh-featured-title">
    <div class="sh-container">
        <div class="sh-section__head">
            <p class="sh-kicker"><?php esc_html_e('Collection preview', 'solehaus'); ?></p>
            <h2 id="sh-featured-title"><?php esc_html_e('Featured Products', 'solehaus'); ?></h2>
            <p><?php esc_html_e('The products below are demonstration items for website layout. Contact Tanny Shoes on WhatsApp or Instagram for current styles, sizes and prices in TZS.', 'solehaus'); ?></p>
        </div>
        <div class="sh-products sh-products--grid">
            <?php foreach ($products as $product) : ?>
                <?php solehaus_render_product_card($product); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
