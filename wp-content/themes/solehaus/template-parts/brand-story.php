<?php
/**
 * About section.
 *
 * @package Solehaus
 */
?>
<section class="sh-story" id="about" aria-labelledby="sh-story-title">
    <div class="sh-container sh-story__grid">
        <div class="sh-story__media">
            <img src="<?php echo esc_url(solehaus_mod('story_image')); ?>" alt="<?php echo esc_attr(sprintf('Footwear collection preview for %s in Arusha', solehaus_store_name())); ?>" width="900" height="1100" loading="lazy" decoding="async">
        </div>
        <div class="sh-story__copy">
            <p class="sh-kicker"><?php esc_html_e('About us', 'solehaus'); ?></p>
            <h2 id="sh-story-title"><?php echo esc_html(solehaus_mod('story_headline')); ?></h2>
            <?php echo solehaus_nl2p(solehaus_mod('story_text')); ?>
            <a class="sh-btn sh-btn--dark" href="<?php echo esc_url(home_url('/#contact')); ?>"><?php esc_html_e('Contact Tanny Shoes', 'solehaus'); ?></a>
        </div>
    </div>
</section>
