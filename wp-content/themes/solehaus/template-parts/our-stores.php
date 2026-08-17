<?php
/**
 * Our Stores — related Instagram pages.
 *
 * @package Solehaus
 */
?>
<section class="sh-section" id="stores" aria-labelledby="sh-stores-title">
    <div class="sh-container">
        <div class="sh-section__head">
            <p class="sh-kicker"><?php esc_html_e('Find us online', 'solehaus'); ?></p>
            <h2 id="sh-stores-title"><?php esc_html_e('Our Stores', 'solehaus'); ?></h2>
            <p><?php esc_html_e('Follow Tanny Shoes and related Instagram pages for footwear, beauty and product updates in Arusha.', 'solehaus'); ?></p>
        </div>
        <div class="sh-stores">
            <?php foreach (solehaus_related_stores() as $store) : ?>
                <article class="sh-store-card">
                    <h3><?php echo esc_html($store['name']); ?></h3>
                    <p class="sh-store-card__handle">@<?php echo esc_html($store['handle']); ?></p>
                    <p><?php echo esc_html($store['description']); ?></p>
                    <a class="sh-text-link" href="<?php echo esc_url($store['url']); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Visit on Instagram', 'solehaus'); ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
