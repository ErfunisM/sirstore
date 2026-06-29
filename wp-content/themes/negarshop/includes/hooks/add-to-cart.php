<?php
/**
 * Add to cart hooks and libraries
 *
 * @package negarshop
 */

function negarshop_add_to_cart_btn(
    $product_id = null, $text = '<i class="far fa-shopping-cart"></i>', $class = '', $offset = '1031',
    $add_type = "simple"
) {
    if ($product_id === null) {
        $product_id = get_the_ID();
    }
    $pf = new WC_Product_Factory();
    $prd = $pf->get_product($product_id);
    if (($add_type == "simple" or $add_type == "advanced") and $prd !== false and $prd->get_stock_status() === 'instock') {
        if ($add_type === "advanced") {
            $class .= ' advanced_cart';
            return '<button type="button" aria-label="' . __('افزودن به سبد خرید',
                    'negarshop') . '" class="cb-add-to-cart ' . $class . '" data-toggle="tooltip" data-placement="bottom" data-original-title="' . __('افزودن به سبد خرید',
                    'negarshop') . '" data-offset="' . $offset . '" data-id="' . $product_id . '">' . $text . '</button>';

        } else {
            if ($prd->get_type() === "simple") {
                return '<button type="button" aria-label="' . __('افزودن به سبد خرید',
                        'negarshop') . '"  class="cb-add-to-cart ' . $class . '" data-toggle="tooltip" data-placement="bottom" data-original-title="' . __('افزودن به سبد خرید',
                        'negarshop') . '" data-offset="' . $offset . '" data-id="' . $product_id . '">' . $text . '</button>';
            } else {
                return '<a class="' . $class . '" href="' . get_the_permalink($product_id) . '" data-toggle="tooltip" data-placement="bottom" data-original-title="' . __('افزودن به سبد خرید',
                        'negarshop') . '" data-offset="' . $offset . '" data-id="' . $product_id . '">' . $text . '</a>';
            }
        }

    } else {
        return '<a class="' . $class . '" href="' . get_the_permalink($product_id) . '" data-toggle="tooltip" data-placement="bottom" data-original-title="' . __('دیدن محصول',
                'negarshop') . '">' . $text . '</a>';
    }
}

function negarshop_add_to_cart_ajax() {
    $res = [
        'status' => false,
        'message' => __('خطا! محصول به سبد خرید اضافه نشد!', 'negarshop'),
        'basket' => '',
        'count' => '0',
        'total_amount' => wc_price(0),
        'style' => 'danger'
    ];
    if (isset($_POST['id']) and function_exists('WC')) {
        $product_id = $_POST['id'];
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
        $variation_id = isset($_POST['variation_id']) ? $_POST['variation_id'] : 0;
        $pf = new WC_Product_Factory();
        $prd = $pf->get_product($product_id);
        if ($prd) {
            if (WC()->cart->add_to_cart($product_id, $quantity, $variation_id)) {
                $res['status'] = true;
                $res['message'] = '"' . get_the_title($variation_id !== 0 ? $variation_id : $product_id) . '"' . __(' به سبد خرید اضافه شد!',
                        'negarshop');
                $res['style'] = 'success';

                ob_start();
                woocommerce_mini_cart();
                $htmloutput = ob_get_contents();
                ob_end_clean();
                $res['basket'] = $htmloutput;
                $res['count'] = WC()->cart->get_cart_contents_count();
                $res['total_amount'] = WC()->cart->get_cart_total();
            }
        }
    }
    wp_send_json($res);
}

add_action("wp_ajax_negarshop_add_to_cart_ajax", "negarshop_add_to_cart_ajax");
add_action("wp_ajax_nopriv_negarshop_add_to_cart_ajax", "negarshop_add_to_cart_ajax");