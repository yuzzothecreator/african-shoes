<?php
/**
 * About page template.
 *
 * @package Solehaus
 */

get_header();
?>
<main id="primary" class="sh-main">
    <div class="sh-page-hero">
        <div class="sh-container sh-page-hero__inner">
            <p class="sh-kicker sh-kicker--light"><?php esc_html_e('About us', 'solehaus'); ?></p>
            <h1><?php echo esc_html(solehaus_mod('story_headline')); ?></h1>
            <p class="sh-page-hero__lead"><?php echo esc_html(solehaus_mod('story_text')); ?></p>
        </div>
    </div>
    <div class="sh-container sh-page">
        <div class="sh-story__grid sh-story__grid--page">
            <div class="sh-story__media">
                <img src="<?php echo esc_url(solehaus_mod('story_image')); ?>" alt="<?php echo esc_attr(sprintf('Footwear collection preview for %s in Arusha', solehaus_store_name())); ?>" width="900" height="1100" loading="lazy" decoding="async">
            </div>
            <div class="sh-story__copy">
                <p class="sh-kicker"><?php esc_html_e('Our story', 'solehaus'); ?></p>
                <h2><?php esc_html_e('Based in Arusha, Tanzania', 'solehaus'); ?></h2>
                <?php echo solehaus_nl2p(solehaus_mod('story_text')); ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php if (get_the_content()) : ?>
                        <div class="sh-prose"><?php the_content(); ?></div>
                    <?php endif; ?>
                <?php endwhile; ?>
                <p>
                    <?php
                    printf(
                        /* translators: %s: Instagram handle link */
                        wp_kses_post(__('Follow <a href="%1$s" target="_blank" rel="noopener noreferrer">@%2$s</a> for footwear updates, or message us on WhatsApp to ask about sizes and availability.', 'solehaus')),
                        esc_url(solehaus_mod('instagram_url')),
                        esc_html(solehaus_instagram_handle())
                    );
                    ?>
                </p>
                <div class="sh-page__actions">
                    <?php $shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/'); ?>
                    <a class="sh-btn sh-btn--dark" href="<?php echo esc_url($shop); ?>"><?php esc_html_e('Browse shop', 'solehaus'); ?></a>
                    <a class="sh-btn sh-btn--whatsapp" href="<?php echo esc_url(solehaus_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('WhatsApp', 'solehaus'); ?></a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
