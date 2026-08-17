<?php
/**
 * Hero.
 *
 * @package Solehaus
 */

$shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$image = solehaus_mod('hero_image');
?>
<section class="sh-hero" aria-label="<?php esc_attr_e('Featured collection', 'solehaus'); ?>">
    <div class="sh-hero__media">
        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(sprintf('Stylish footwear lifestyle image for %s in Arusha, Tanzania', solehaus_store_name())); ?>" width="1920" height="1080" fetchpriority="high" decoding="async">
    </div>
    <div class="sh-hero__overlay"></div>
    <div class="sh-container sh-hero__content">
        <p class="sh-kicker sh-kicker--light"><?php echo esc_html(solehaus_mod('hero_eyebrow')); ?></p>
        <h1><?php echo esc_html(solehaus_mod('hero_headline')); ?></h1>
        <p class="sh-hero__lead"><?php echo esc_html(solehaus_mod('hero_text')); ?></p>
        <div class="sh-hero__actions">
            <a class="sh-btn sh-btn--light" href="<?php echo esc_url($shop); ?>"><?php echo esc_html(solehaus_mod('hero_primary_label')); ?></a>
            <a class="sh-btn sh-btn--whatsapp" href="<?php echo esc_url(solehaus_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html(solehaus_mod('hero_secondary_label')); ?></a>
        </div>
        <?php if (solehaus_mod('hero_trust')) : ?>
            <p class="sh-hero__trust"><?php echo esc_html(solehaus_mod('hero_trust')); ?></p>
        <?php endif; ?>
    </div>
</section>
