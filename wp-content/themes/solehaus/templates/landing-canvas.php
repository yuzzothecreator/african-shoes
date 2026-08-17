<?php
/**
 * Template Name: Landing Canvas
 * Description: Blank canvas for Gutenberg or Elementor. Header and footer still show.
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
