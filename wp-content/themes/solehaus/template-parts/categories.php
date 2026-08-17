<?php
/**
 * Shop by category.
 *
 * @package Solehaus
 */
?>
<section class="sh-section" id="categories" aria-labelledby="sh-cats-title">
    <div class="sh-container">
        <div class="sh-section__head">
            <p class="sh-kicker"><?php esc_html_e('Browse', 'solehaus'); ?></p>
            <h2 id="sh-cats-title"><?php esc_html_e('Shop by Category', 'solehaus'); ?></h2>
            <p><?php esc_html_e('Footwear for men, women and children — sneakers, formal, casual, sandals and anatomic styles.', 'solehaus'); ?></p>
        </div>
        <div class="sh-cats">
            <?php foreach (solehaus_demo_categories() as $cat) : ?>
                <a class="sh-cat" href="<?php echo esc_url(solehaus_category_url($cat['slug'])); ?>">
                    <img src="<?php echo esc_url($cat['image']); ?>" alt="<?php echo esc_attr($cat['alt']); ?>" width="640" height="800" loading="lazy" decoding="async">
                    <span class="sh-cat__label">
                        <strong><?php echo esc_html($cat['name']); ?></strong>
                        <em><?php esc_html_e('Explore Collection', 'solehaus'); ?></em>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
