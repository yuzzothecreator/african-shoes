<?php
/**
 * Why choose us.
 *
 * @package Solehaus
 */
$items = array(
    array('Quality Products', 'Leather, canvas, and sports uppers chosen for everyday Tanzanian wear — office, commute, and weekend.'),
    array('Affordable Prices', 'Clear TZS prices on every card. Sale pairs show the previous price so you can compare.'),
    array('Fast Delivery', 'Dar es Salaam orders are usually prepared the same day. Other regions typically take a few working days.'),
    array('Friendly Customer Support', 'Write on WhatsApp with the size you need. We confirm stock before you pay.'),
);
?>
<section class="sh-section" id="why" aria-labelledby="sh-why-title">
    <div class="sh-container">
        <div class="sh-section__head">
            <p class="sh-kicker"><?php esc_html_e('The shop', 'solehaus'); ?></p>
            <h2 id="sh-why-title"><?php esc_html_e('Why Choose Us', 'solehaus'); ?></h2>
        </div>
        <div class="sh-benefits">
            <?php foreach ($items as $i => $item) : ?>
                <article class="sh-benefit">
                    <span class="sh-benefit__icon" aria-hidden="true"><?php echo esc_html(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                    <h3><?php echo esc_html($item[0]); ?></h3>
                    <p><?php echo esc_html($item[1]); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
