<?php
/**
 * Sidebar
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/sidebar.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (negarshop_option('shop_sidebar') === 'popup') {
    echo '<div class="product-archive-filters--popup">';
    echo '<button class="btn product-filters-toggle" type="button"><i class="far fa-filter btn-icon"></i>' . __('فیلتر محصولات', 'negarshop') . '</button>';
}

get_sidebar('shop');

if (negarshop_option('shop_sidebar') === 'popup') {
    echo '</div>';
}
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
