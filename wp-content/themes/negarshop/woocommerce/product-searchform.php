<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if (!defined('ABSPATH')) {
    exit;
}
if (negarshop_option('header_search_ac') !== 'true') {
    return;
}
$header_search = negarshop_option('header_search_ac_picker');
$header_search = $header_search['true'];
?>
<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="input-group">
        <input type="text" id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>"
               class="search-field form-control" placeholder="<?php echo $header_search['search_placeholder']; ?>"
               value="<?php echo get_search_query(); ?>" name="s">
        <button class="search-btn" type="submit"><i class="fal fa-search"></i></button>
        <input type="hidden" name="post_type" value="product"/>
        <?php
        $search_picker = negarshop_option('header_search_ac_picker');
        $search_picker = $search_picker['true'];
        if (isset($search_picker['header_search_ajax']) and $search_picker['header_search_ajax'] == 'true' and negarshop_option('header_style') == 'negarshop') { ?>
            <div class="instuck">
                <input class="instuck" type="checkbox" id="header-search-instuck"/>
                <label for="header-search-instuck"
                       title="<?php _e("فقط موجود ها", 'negarshop') ?>"><span><?php _e("موجود", 'negarshop') ?></span></label>
            </div>
            <div class="select-category">
                <?php $wc_categories = get_categories(array('taxonomy' => 'product_cat')); ?>
                <select id="header-search-category">
                    <option value=""><?php _e("انتخاب دسته بندی", 'negarshop') ?></option>
                    <?php foreach ($wc_categories as $item): $item = get_term($item->term_id); ?>
                        <option value="<?php echo $item->term_id; ?>"><?php echo $item->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <i class="fal fa-angle-down"></i>
            </div>
        <?php } ?>
    </div>
</form>