<?php
/**
 * Legal and content pages with hero banner.
 *
 * @package Solehaus
 */

get_header();
?>
<main id="primary" class="sh-main">
    <div class="sh-page-hero">
        <div class="sh-container sh-page-hero__inner">
            <p class="sh-kicker sh-kicker--light"><?php esc_html_e('Information', 'solehaus'); ?></p>
            <h1><?php the_title(); ?></h1>
        </div>
    </div>
    <div class="sh-container sh-page sh-page--narrow sh-prose">
        <?php while (have_posts()) : the_post(); ?>
            <?php the_content(); ?>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();
