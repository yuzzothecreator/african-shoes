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
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_support',
                    'menu_class'     => 'sh-footer__list',
                    'container'      => false,
                    'fallback_cb'    => static function () {
                        $contact = get_page_by_path('contact');
                        $delivery = get_page_by_path('delivery-and-returns');
                        $privacy = get_privacy_policy_url() ? get_privacy_policy_url() : home_url('/privacy-policy/');
                        echo '<ul class="sh-footer__list">';
                        echo '<li><a href="' . esc_url($contact ? get_permalink($contact) : home_url('/contact/')) . '">' . esc_html__('Contact', 'solehaus') . '</a></li>';
                        echo '<li><a href="' . esc_url($delivery ? get_permalink($delivery) : home_url('/delivery-and-returns/')) . '">' . esc_html__('Delivery and Returns', 'solehaus') . '</a></li>';
                        echo '<li><a href="' . esc_url($privacy) . '">' . esc_html__('Privacy Policy', 'solehaus') . '</a></li>';
                        echo '<li><a href="' . esc_url(home_url('/terms/')) . '">' . esc_html__('Terms and Conditions', 'solehaus') . '</a></li>';
                        echo '</ul>';
                    },
                ));
                ?>
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
