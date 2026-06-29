<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.5.1
 */

defined('ABSPATH') || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if (!function_exists('wc_get_gallery_image_html')) {
    return;
}

global $product;
$attachment_ids = negarshop_get_product_images($product);

$thumbnail_height = negarshop_woocommerce_image_height_builder(negarshop_option('product_thumbnail_size'));
$thumbnail_height = sprintf('padding-top: %s;', esc_attr($thumbnail_height));

if ($attachment_ids !== false) {
    echo '<div class="owl-carousel wc-product-carousel custom-background--' . negarshop_option('product_thumbnail_background') . ' images">';
    $three_opt = negarshop_option('model_ac', 'posts', get_the_ID());

    if (isset($three_opt['selector']) && $three_opt['selector'] === "true") {
        echo '<div class="view-3d-slide"><a href="javascript:void(0);" data-toggle="modal" data-target=".view-3d-modal-' . get_the_id() . '" class="action-btn-3d-view" data-id="' . get_the_id() . '">
<i class="fal fa-cubes"></i><b>' . __('دیدن ماکت محصول', 'negarshop') . '</b></a> </div>';
    }
    $iintforeach = 0;
    foreach ($attachment_ids as $attachment_id) {
        $gitem = wp_get_attachment_image_src($attachment_id, 'medium_large');
        if (!is_array($gitem)) {
            continue;
        }
        echo '<div class="car-dtag" style="' . $thumbnail_height . '" data-attach-id="' . $attachment_id . '" data-src="' . $gitem[0] . '">';
        echo '<a href="' . $gitem[0] . '" class="img-magnifier-container"><img class="product-gallery-img" data-magnify-src="' . $gitem[0] . '" src="' . $gitem[0] . '" alt="' . get_the_title() . '" id="wc-carousel-image-' . $iintforeach . '" /></a>';
        echo '</div>';
        $iintforeach++;
    }
    echo '</div>';
    echo '<div class="owl-carousel wc-product-carousel-thumbs">';
    if (isset($three_opt['selector']) && $three_opt['selector'] === "true") {
        echo '<div class="view-3d-thumb"><i class="fal fa-cubes"></i></div>';
    }

    foreach ($attachment_ids as $attachment_id) {
        echo '<div data-attach-id="' . $attachment_id . '">' . wp_get_attachment_image($attachment_id) . '</div>';
    }
    echo '</div>';
}
