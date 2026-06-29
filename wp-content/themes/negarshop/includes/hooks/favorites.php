<?php
/**
 * Favorites hooks and libraries.
 *
 * @package negarshop
 */

$negarshop_post_like_meta = "rm_post_favorite";

function negarshop_get_likes () {
    if ( is_user_logged_in() ) {
        global $negarshop_post_like_meta;
        $get_meta = get_user_meta(get_current_user_id(), $negarshop_post_like_meta, true);

        return ($get_meta == "") ? [] : $get_meta;
    }

    return false;
}

function negarshop_like_exists ($id = null): bool {
    if ( $id != null and is_user_logged_in() ) {
        $get_likes = negarshop_get_likes();
        if ( in_array($id, $get_likes) ) {
            return true;
        }
    }

    return false;
}

function negarshop_like_action ($post_id = null, $add = true): array {
    $status = [
        'status'     => false,
        'data'       => '',
        'is_numeric' => is_numeric($post_id)
    ];
    if ( $post_id !== null and is_numeric($post_id) and is_user_logged_in() ) {
        global $negarshop_post_like_meta;
        $likes   = negarshop_get_likes();
        $user_id = (get_current_user_id() !== 0) ? get_current_user_id() : false;
        if ( $user_id !== false ) {
            if ( $add ) {
                if ( !in_array($post_id, $likes) ) {
                    $likes[]  = $post_id;
                    $add_like = add_user_meta($user_id, $negarshop_post_like_meta, $likes, true);
                    if ( $add_like === false ) {
                        $add_like = update_user_meta($user_id, $negarshop_post_like_meta, $likes);
                    }
                    if ( $add_like !== false ) {
                        $status['status'] = true;
                        $status['data']   = negarshop_get_likes();
                    }
                } else {
                    $status['data'] = "exists";
                }
            } else {
                if ( in_array($post_id, $likes) ) {
                    $likes    = array_diff($likes, [$post_id]);
                    $add_like = update_user_meta($user_id, $negarshop_post_like_meta, $likes);
                    if ( $add_like !== false ) {
                        $status['status'] = true;
                        $status['data']   = negarshop_get_likes();
                    }
                } else {
                    $status['data'] = "not exists";
                }
            }
        }
    }

    return $status;
}

function negarshop_like_ajax () {
    header("Content-type:application/json");
    $json_array = [
        'status'      => false,
        'status_code' => 0,
        'data'        => ''
    ];
    if ( isset($_POST['id']) and is_numeric($_POST['id']) ) {
        $check_action = negarshop_like_exists($_POST['id']);
        if ( !$check_action ) {
            $like_res = negarshop_like_action($_POST['id']);
            if ( $like_res['status'] ) {
                $json_array['status']      = true;
                $json_array['status_code'] = 1;
                $json_array['data']        = __("محصول مورد نظر شما به علاقه مندی ها اضافه شد!", 'negarshop');
            }
        } else {
            $like_res = negarshop_like_action($_POST['id'], false);
            if ( $like_res['status'] ) {
                $json_array['status']      = true;
                $json_array['status_code'] = 2;
                $json_array['data']        = __("محصول مورد نظر شما از علاقه مندی ها حذف شد!", 'negarshop');
            }
        }
    }
    echo json_encode($json_array);
    wp_die();
}

function negarshop_fav_btn ($id, $is_single = false, $echo = true) {
    $check_liked = (negarshop_like_exists($id)) ? "liked" : "";
    $html        = "";
    $log_class   = is_user_logged_in() ? '' : 'login_req';
    if ( $is_single ) {
        $html .= "<li>";
    }
    $html .= '<button type="button" aria-label="'. __('افزودن به علاقه مندی ها','negarshop').'" data-toggle="tooltip" data-placement="bottom" data-original-title="' . __('افزودن به علاقه مندی ها', 'negarshop') . '"  class="add-product-favo ' . $check_liked . ' ' . $log_class . '" data-id="' . $id . '">';
    if ( $is_single ) {
        $html .= __('محبوب', 'negarshop');
    } else {
        $html .= '<i class="far fa-heart"></i>';
    }
    $html .= '</button>';
    if ( $is_single ) {
        $html .= "</li>";
    }
    if ( $echo ) {
        echo $html;
    } else {
        return $html;
    }
}

function negarshop_get_favorite_products () {
    $user_favorites = negarshop_get_likes();
    $output_ht      = '<table class="table ns-table">';
    $output_ht      .= ' <thead><tr><th scope="col" width="50"> </th><th scope="col">' . __('نام محصول', 'negarshop') . '</th><th class="actions-th"></th></tr></thead><tbody>';
    if ( !empty($user_favorites) ) {
        $foreachI = 1;
        foreach ( $user_favorites as $item ) {
            $output_ht .= '<tr>';
            $output_ht .= '<th scope="row">' . $foreachI . '</th>';
            $output_ht .= '<td><a href="' . get_the_permalink($item) . '">' . get_the_title($item) . '</a></td>';
            $output_ht .= '<td class="text-left actions">' . negarshop_add_to_cart_btn($item) . ' <a href="#delete_' . $item . '" class="dislike_product" data-id="' . $item . '"> ' . __('پاک کردن', 'negarshop') . '</a></td>';
            $output_ht .= '</tr><tr class="spacer"></tr>';
            $foreachI++;
        }
    } else if ( !is_user_logged_in() ) {
        if ( function_exists('wc_get_page_permalink') and wp_redirect(wc_get_page_permalink('myaccount')) ) {
            exit;
        }
    } else {
        $output_ht .= '<tr>';
        $output_ht .= '<th scope="row"></th>';
        $output_ht .= '<th scope="row">' . __('محصولی یافت نشد!', 'negarshop') . '</th>';
        $output_ht .= '</tr>';
    }
    $output_ht .= '</tbody></table>';

    return $output_ht;
}

function negarshop_favs_add_premium_support_endpoint()
{
    add_rewrite_endpoint('favorites', EP_ROOT | EP_PAGES);
}

function negarshop_favs_premium_support_query_vars($vars)
{
    $vars[] = 'favorites';

    return $vars;
}


function negarshop_favs_premium_support_content()
{
    echo negarshop_get_favorite_products();
}

add_action('woocommerce_account_favorites_endpoint', 'negarshop_favs_premium_support_content');

add_action('wp_ajax_negarshop_like_ajax', 'negarshop_like_ajax');
add_action('wp_ajax_nopriv_negarshop_like_ajax', 'negarshop_like_ajax');
add_shortcode('negarshop_favs', 'negarshop_get_favorite_products');
add_action('init', 'negarshop_favs_add_premium_support_endpoint');
add_filter('query_vars', 'negarshop_favs_premium_support_query_vars', 0);
