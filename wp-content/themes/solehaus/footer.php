    <?php get_template_part('template-parts/floating-buttons'); ?>
    <footer class="sh-footer">
        <div class="sh-container sh-footer__grid">
            <div class="sh-footer__brand">
                <a class="sh-logo__word sh-logo__word--light" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(solehaus_store_name()); ?></a>
                <p><?php echo esc_html(solehaus_mod('footer_about')); ?></p>
                <p class="sh-footer__location"><?php echo esc_html(solehaus_mod('city')); ?></p>
                <p class="sh-footer__wa">
                    <a href="<?php echo esc_url(solehaus_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html(solehaus_mod('whatsapp')); ?></a>
                </p>
            </div>

            <div>
                <h2><?php esc_html_e('Shop', 'solehaus'); ?></h2>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_quick',
                    'menu_class'     => 'sh-footer__list',
                    'container'      => false,
                    'fallback_cb'    => static function () {
                        $shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
                        echo '<ul class="sh-footer__list">';
                        echo '<li><a href="' . esc_url(home_url('/')) . '">Home</a></li>';
                        echo '<li><a href="' . esc_url($shop) . '">Shop</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/#arrivals')) . '">New Arrivals</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/#stores')) . '">Our Stores</a></li>';
                        echo '</ul>';
                    },
                ));
                ?>
            </div>

            <div>
                <h2><?php esc_html_e('Categories', 'solehaus'); ?></h2>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_categories',
                    'menu_class'     => 'sh-footer__list',
                    'container'      => false,
                    'fallback_cb'    => static function () {
                        echo '<ul class="sh-footer__list">';
                        foreach (solehaus_demo_categories() as $cat) {
                            echo '<li><a href="' . esc_url(solehaus_category_url($cat['slug'])) . '">' . esc_html($cat['name']) . '</a></li>';
                        }
                        echo '</ul>';
                    },
                ));
                ?>
            </div>

            <div>
                <h2><?php esc_html_e('Customer support', 'solehaus'); ?></h2>
                <ul class="sh-footer__list">
                    <li><a href="<?php echo esc_url(home_url('/#contact')); ?>"><?php esc_html_e('Contact', 'solehaus'); ?></a></li>
                    <li><a href="<?php echo esc_url(get_privacy_policy_url() ? get_privacy_policy_url() : home_url('/privacy-policy/')); ?>"><?php esc_html_e('Privacy Policy', 'solehaus'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/terms/')); ?>"><?php esc_html_e('Terms and Conditions', 'solehaus'); ?></a></li>
                </ul>
                <h3><?php esc_html_e('Related Instagram stores', 'solehaus'); ?></h3>
                <ul class="sh-footer__list">
                    <?php foreach (solehaus_related_stores() as $store) : ?>
                        <li>
                            <a href="<?php echo esc_url($store['url']); ?>" target="_blank" rel="noopener noreferrer">
                                @<?php echo esc_html($store['handle']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="sh-footer__bar">
            <div class="sh-container sh-footer__bar-inner">
                <p>&copy; <?php echo esc_html(gmdate('Y')); ?> <?php echo esc_html(solehaus_store_name()); ?>. <?php esc_html_e('All rights reserved.', 'solehaus'); ?></p>
                <p>
                    <a href="<?php echo esc_url(get_privacy_policy_url() ? get_privacy_policy_url() : home_url('/privacy-policy/')); ?>"><?php esc_html_e('Privacy Policy', 'solehaus'); ?></a>
                    <a href="<?php echo esc_url(home_url('/terms/')); ?>"><?php esc_html_e('Terms and Conditions', 'solehaus'); ?></a>
                </p>
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>
