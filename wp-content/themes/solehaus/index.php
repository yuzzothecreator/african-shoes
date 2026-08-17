<?php
/**
 * Default index.
 *
 * @package Solehaus
 */

get_header();
?>
<main id="primary" class="sh-main">
    <div class="sh-container sh-page">
        <?php if (have_posts()) : ?>
            <header class="sh-page__header">
                <h1><?php echo wp_kses_post(get_the_archive_title()); ?></h1>
            </header>
            <div class="sh-blog-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <article <?php post_class('sh-blog-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('solehaus-card'); ?></a>
                        <?php endif; ?>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?></p>
                    </article>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <h1><?php esc_html_e('Nothing found', 'solehaus'); ?></h1>
            <p><?php esc_html_e('Try a different search or browse the shop.', 'solehaus'); ?></p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
