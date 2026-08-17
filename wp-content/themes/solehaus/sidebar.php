<?php
/**
 * Shop sidebar.
 *
 * @package Solehaus
 */

if (!is_active_sidebar('shop-sidebar')) {
    return;
}
dynamic_sidebar('shop-sidebar');
