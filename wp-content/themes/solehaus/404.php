<?php
/**
 * 404 template.
 *
 * @package Solehaus
 */

get_header();
?>
<main id="primary" class="sh-main">
    <div class="sh-container sh-page sh-page--narrow sh-404">
        <p class="sh-kicker"><?php esc_html_e('Page not found', 'solehaus'); ?></p>
        <h1><?php esc_html_e('This pair has walked off the map.', 'solehaus'); ?></h1>
        <p><?php esc_html_e('The page may have moved. Search for a style, or go back to the shop.', 'solehaus'); ?></p>
        <?php get_search_form(); ?>
        <p><a class="sh-btn sh-btn--dark" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Back to home', 'solehaus'); ?></a></p>
    </div>
</main>
<?php
get_footer();
