<?php
/**
 * Floating WhatsApp and back to top.
 *
 * @package Solehaus
 */
?>
<div class="sh-float">
    <a class="sh-float__wa" href="<?php echo esc_url(solehaus_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer">
        <span class="sh-sr"><?php esc_html_e('Order on WhatsApp', 'solehaus'); ?></span>
        <svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true" fill="currentColor"><path d="M20 11.5A8.5 8.5 0 1 1 11.5 3 8.5 8.5 0 0 1 20 11.5zm-2.3 5.6-1.6-.5a1 1 0 0 0-.9.2l-.9.9a7.1 7.1 0 0 1-3.4-3.4l.9-.9a1 1 0 0 0 .2-.9l-.5-1.6a1 1 0 0 0-1-.7H8.2a1.2 1.2 0 0 0-1.2 1.4 9.2 9.2 0 0 0 10 10 1.2 1.2 0 0 0 1.4-1.2v-1.3a1 1 0 0 0-.7-1z"/></svg>
    </a>
    <button class="sh-float__top" type="button" data-back-top hidden>
        <span class="sh-sr"><?php esc_html_e('Back to top', 'solehaus'); ?></span>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </button>
</div>
