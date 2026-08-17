<?php
/**
 * Template Name: Full Width (Elementor)
 *
 * @package Solehaus
 */

get_header();
?>
<main id="primary" class="sh-main">
    <?php
    while (have_posts()) {
        the_post();
        the_content();
    }
    ?>
</main>
<?php
get_footer();
