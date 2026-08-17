<?php
/**
 * Announcement bar.
 *
 * @package Solehaus
 */
$text = solehaus_mod('announcement');
if (!$text) {
    return;
}
?>
<div class="sh-announce" role="region" aria-label="<?php esc_attr_e('Store announcement', 'solehaus'); ?>">
    <p><?php echo esc_html($text); ?></p>
</div>
