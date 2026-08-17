<?php
/**
 * Search results.
 *
 * @package Solehaus
 */

get_header();
?>
<main id="primary" class="sh-main">
    <div class="sh-container sh-page">
        <header class="sh-page__header">
            <h1><?php printf(esc_html__('Search results for “%s”', 'solehaus'), esc_html(get_search_query())); ?></h1>
        </header>
        <?php if (have_posts()) : ?>
            <div class="sh-products sh-products--grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php if (get_post_type() === 'product' && function_exists('wc_get_product')) : ?>
                        <?php
                        $mapped = solehaus_map_wc_product(wc_get_product(get_the_ID()));
                        if ($mapped) {
                            solehaus_render_product_card($mapped);
                        }
                        ?>
                    <?php else : ?>
                        <article class="sh-blog-card">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                        </article>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p><?php esc_html_e('No matching shoes yet. Browse categories or order on WhatsApp with the size you need.', 'solehaus'); ?></p>
            <p><a class="sh-btn sh-btn--dark" href="<?php echo esc_url(function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/')); ?>"><?php esc_html_e('Browse the shop', 'solehaus'); ?></a></p>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
