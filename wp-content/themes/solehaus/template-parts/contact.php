<?php
/**
 * Contact section.
 *
 * @package Solehaus
 */
$directions = solehaus_mod('directions_url');
?>
<section class="sh-section sh-section--mist" id="contact" aria-labelledby="sh-contact-title">
    <div class="sh-container">
        <div class="sh-section__head">
            <p class="sh-kicker"><?php esc_html_e('Get in touch', 'solehaus'); ?></p>
            <h2 id="sh-contact-title"><?php esc_html_e('Contact', 'solehaus'); ?></h2>
        </div>
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
</section>
