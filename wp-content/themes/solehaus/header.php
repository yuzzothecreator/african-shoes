<?php
/**
 * Theme header.
 *
 * @package Solehaus
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0B0B0B">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="sh-skip" href="#primary"><?php esc_html_e('Skip to content', 'solehaus'); ?></a>
<?php get_template_part('template-parts/announcement-bar'); ?>
<header class="sh-header" id="site-header">
    <div class="sh-container sh-header__inner">
        <button class="sh-icon-btn sh-nav-toggle" type="button" aria-expanded="false" aria-controls="primary-navigation" aria-label="<?php esc_attr_e('Open menu', 'solehaus'); ?>">
            <span></span><span></span><span></span>
        </button>

        <div class="sh-logo">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="sh-logo__word sh-logo__mark" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr(solehaus_store_name()); ?>">
                    <span class="sh-logo__icon" aria-hidden="true">TS</span>
                    <span><?php echo esc_html(solehaus_store_name()); ?></span>
                </a>
            <?php endif; ?>
        </div>

        <nav class="sh-nav-wrap" id="primary-navigation" aria-label="<?php esc_attr_e('Primary', 'solehaus'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'sh-nav',
                'container'      => false,
                'fallback_cb'    => 'solehaus_nav_fallback',
            ));
            ?>
        </nav>

        <div class="sh-header__actions">
            <button class="sh-icon-btn" type="button" data-open-search aria-haspopup="dialog" aria-controls="sh-search" aria-label="<?php esc_attr_e('Search products', 'solehaus'); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            </button>
            <a class="sh-icon-btn sh-cart-link" href="<?php echo esc_url(solehaus_cart_url()); ?>" aria-label="<?php esc_attr_e('Shopping bag', 'solehaus'); ?>">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 7h15l-1.5 9h-12L5 4H2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="20" r="1.4" fill="currentColor"/><circle cx="18" cy="20" r="1.4" fill="currentColor"/></svg>
                <span class="sh-cart-count" data-count="<?php echo esc_attr((string) solehaus_cart_count()); ?>"><?php echo esc_html((string) solehaus_cart_count()); ?></span>
            </a>
            <a class="sh-btn sh-btn--whatsapp sh-btn--header" href="<?php echo esc_url(solehaus_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer">
                <?php esc_html_e('Order on WhatsApp', 'solehaus'); ?>
            </a>
        </div>
    </div>
</header>

<div class="sh-search" id="sh-search" hidden>
    <div class="sh-search__panel" role="dialog" aria-modal="true" aria-labelledby="sh-search-title">
        <div class="sh-search__top">
            <h2 id="sh-search-title"><?php esc_html_e('Search shoes', 'solehaus'); ?></h2>
            <button type="button" class="sh-icon-btn" data-close-search aria-label="<?php esc_attr_e('Close search', 'solehaus'); ?>">×</button>
        </div>
        <form class="sh-search__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <label class="sh-sr" for="sh-search-field"><?php esc_html_e('Search products', 'solehaus'); ?></label>
            <input id="sh-search-field" type="search" name="s" placeholder="<?php esc_attr_e('Try “oxford”, “runner”, or a size', 'solehaus'); ?>" value="<?php echo esc_attr(get_search_query()); ?>">
            <?php if (class_exists('WooCommerce')) : ?>
                <input type="hidden" name="post_type" value="product">
            <?php endif; ?>
            <button class="sh-btn sh-btn--dark" type="submit"><?php esc_html_e('Search', 'solehaus'); ?></button>
        </form>
    </div>
</div>
