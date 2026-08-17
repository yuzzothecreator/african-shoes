<?php
/**
 * Front page landing layout.
 *
 * @package Solehaus
 */

get_header();
?>
<main id="primary" class="sh-main">
    <?php
    if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('single')) {
        // Elementor takes over the page.
    } else {
        get_template_part('template-parts/landing');
    }
    ?>
</main>
<?php
get_footer();
