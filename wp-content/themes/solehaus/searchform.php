<?php
/**
 * Product search form.
 *
 * @package Solehaus
 */
?>
<form class="sh-search__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <label class="sh-sr" for="woocommerce-product-search-field"><?php esc_html_e('Search products', 'solehaus'); ?></label>
    <input id="woocommerce-product-search-field" type="search" name="s" placeholder="<?php esc_attr_e('Search shoes', 'solehaus'); ?>" value="<?php echo esc_attr(get_search_query()); ?>">
    <input type="hidden" name="post_type" value="product">
    <button class="sh-btn sh-btn--dark" type="submit"><?php esc_html_e('Search', 'solehaus'); ?></button>
</form>
