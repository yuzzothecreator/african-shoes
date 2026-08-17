<?php
/**
 * Page template.
 *
 * @package Solehaus
 */

get_header();
?>
<main id="primary" class="sh-main">
    <div class="sh-container sh-page sh-page--narrow">
        <?php while (have_posts()) : the_post(); ?>
            <header class="sh-page__header">
                <h1><?php the_title(); ?></h1>
            </header>
            <div class="sh-prose">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
    </div>
</main>
<?php
get_footer();
