<?php
/**
 * Newsletter.
 *
 * @package Solehaus
 */
?>
<section class="sh-news" id="newsletter" aria-labelledby="sh-news-title">
    <div class="sh-container sh-news__inner">
        <div>
            <h2 id="sh-news-title"><?php echo esc_html(solehaus_mod('newsletter_headline')); ?></h2>
            <p><?php echo esc_html(solehaus_mod('newsletter_text')); ?></p>
        </div>
        <form class="sh-news__form" id="sh-newsletter-form">
            <label class="sh-sr" for="sh-news-email"><?php esc_html_e('Email address', 'solehaus'); ?></label>
            <input id="sh-news-email" name="email" type="email" autocomplete="email" required placeholder="<?php esc_attr_e('you@email.com', 'solehaus'); ?>">
            <input class="sh-hp" type="text" name="company" tabindex="-1" autocomplete="off" aria-hidden="true">
            <button class="sh-btn sh-btn--accent" type="submit"><?php esc_html_e('Subscribe', 'solehaus'); ?></button>
            <p class="sh-news__status" role="status" aria-live="polite"></p>
        </form>
    </div>
</section>
