<?php
/**
 * Instagram community section.
 *
 * @package Solehaus
 */
$handle = solehaus_instagram_handle();
$url    = solehaus_mod('instagram_url');
?>
<section class="sh-section sh-section--mist" id="community" aria-labelledby="sh-community-title">
    <div class="sh-container">
        <div class="sh-section__head sh-section__head--center">
            <p class="sh-kicker"><?php esc_html_e('Social', 'solehaus'); ?></p>
            <h2 id="sh-community-title"><?php echo esc_html(solehaus_mod('community_headline')); ?></h2>
            <p><?php echo esc_html(solehaus_mod('community_text')); ?></p>
            <?php if (solehaus_mod('instagram_followers')) : ?>
                <p class="sh-community__stat"><?php echo esc_html(solehaus_mod('instagram_followers')); ?></p>
            <?php endif; ?>
        </div>
        <div class="sh-ig">
            <?php foreach (solehaus_instagram_images() as $img) : ?>
                <a class="sh-ig__item" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer">
                    <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" width="480" height="480" loading="lazy" decoding="async">
                </a>
            <?php endforeach; ?>
        </div>
        <p class="sh-center">
            <a class="sh-btn sh-btn--accent" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html(solehaus_mod('community_button')); ?></a>
        </p>
    </div>
</section>
