<?php
/**
 * Contact page template.
 *
 * @package Solehaus
 */

get_header();

$directions = solehaus_mod('directions_url');
?>
<main id="primary" class="sh-main">
    <div class="sh-page-hero">
        <div class="sh-container sh-page-hero__inner">
            <p class="sh-kicker sh-kicker--light"><?php esc_html_e('Get in touch', 'solehaus'); ?></p>
            <h1><?php the_title(); ?></h1>
            <p class="sh-page-hero__lead"><?php esc_html_e('Reach Tanny Shoes on WhatsApp or Instagram for orders, sizes, and availability.', 'solehaus'); ?></p>
        </div>
    </div>
    <div class="sh-container sh-page">
        <?php while (have_posts()) : the_post(); ?>
            <?php if (get_the_content()) : ?>
                <div class="sh-prose sh-page--narrow" style="margin-bottom:2rem;">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
        <div class="sh-contact sh-contact--simple">
            <div class="sh-contact__card">
                <ul class="sh-contact__list">
                    <li>
                        <span><?php esc_html_e('Business', 'solehaus'); ?></span>
                        <strong><?php echo esc_html(solehaus_store_name()); ?></strong>
                    </li>
                    <li>
                        <span><?php esc_html_e('Location', 'solehaus'); ?></span>
                        <div><?php echo esc_html(solehaus_mod('city')); ?></div>
                    </li>
                    <li>
                        <span><?php esc_html_e('WhatsApp', 'solehaus'); ?></span>
                        <a href="<?php echo esc_url(solehaus_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html(solehaus_mod('whatsapp')); ?></a>
                    </li>
                    <li>
                        <span><?php esc_html_e('Instagram', 'solehaus'); ?></span>
                        <a href="<?php echo esc_url(solehaus_mod('instagram_url')); ?>" target="_blank" rel="noopener noreferrer">@<?php echo esc_html(solehaus_instagram_handle()); ?></a>
                    </li>
                </ul>
                <div class="sh-contact__actions">
                    <a class="sh-btn sh-btn--whatsapp" href="<?php echo esc_url(solehaus_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Chat on WhatsApp', 'solehaus'); ?></a>
                    <a class="sh-btn sh-btn--secondary" href="<?php echo esc_url(solehaus_mod('instagram_url')); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Visit Instagram', 'solehaus'); ?></a>
                    <?php if ($directions) : ?>
                        <a class="sh-btn sh-btn--dark" href="<?php echo esc_url($directions); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Get Directions', 'solehaus'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
get_footer();
