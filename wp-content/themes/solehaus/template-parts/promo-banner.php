<?php
/**
 * Promotional banner.
 *
 * @package Solehaus
 */
$url = solehaus_mod('instagram_url');
?>
<section class="sh-promo" aria-labelledby="sh-promo-title">
    <img class="sh-promo__bg" src="<?php echo esc_url(solehaus_mod('promo_image')); ?>" alt="<?php esc_attr_e('Footwear lifestyle image for Tanny Shoes', 'solehaus'); ?>" width="1600" height="900" loading="lazy" decoding="async">
    <div class="sh-promo__overlay"></div>
    <div class="sh-container sh-promo__content">
        <h2 id="sh-promo-title"><?php echo esc_html(solehaus_mod('promo_headline')); ?></h2>
        <p><?php echo esc_html(solehaus_mod('promo_text')); ?></p>
        <a class="sh-btn sh-btn--light" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Follow on Instagram', 'solehaus'); ?></a>
    </div>
</section>
