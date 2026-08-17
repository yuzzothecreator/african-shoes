<?php
/**
 * Customer testimonials.
 *
 * @package Solehaus
 */
?>
<section class="sh-section" id="reviews" aria-labelledby="sh-reviews-title">
    <div class="sh-container">
        <div class="sh-section__head">
            <p class="sh-kicker"><?php esc_html_e('From customers', 'solehaus'); ?></p>
            <h2 id="sh-reviews-title"><?php esc_html_e('What Shoppers Say', 'solehaus'); ?></h2>
            <p><?php esc_html_e('Recent comments from people who bought pairs through the shop or WhatsApp. Individual results vary with size and wear.', 'solehaus'); ?></p>
        </div>
        <div class="sh-reviews">
            <?php foreach (solehaus_demo_testimonials() as $review) : ?>
                <figure class="sh-review">
                    <div class="sh-review__top">
                        <img src="<?php echo esc_url($review['image']); ?>" alt="<?php echo esc_attr($review['alt']); ?>" width="64" height="64" loading="lazy" decoding="async">
                        <figcaption>
                            <strong><?php echo esc_html($review['name']); ?></strong>
                            <span><?php echo esc_html($review['city']); ?></span>
                        </figcaption>
                    </div>
                    <?php echo solehaus_stars($review['rating']); ?>
                    <blockquote>
                        <p><?php echo esc_html($review['quote']); ?></p>
                    </blockquote>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
