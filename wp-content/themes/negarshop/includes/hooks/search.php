<?php
/**
 * Search hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_ajax_search() {
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    $query_s = (isset($_POST['s']) and !empty($_POST['s'])) ? $_POST['s'] : false;
    $query_cat = (isset($_POST['cat']) and !empty($_POST['cat'])) ? $_POST['cat'] : false;
    $query_stuck = (isset($_POST['stuck']) and !empty($_POST['stuck'])) ? $_POST['stuck'] : false;
    $post_type = (isset($_POST['type']) and !empty($_POST['type'])) ? $_POST['type'] : false;
    $search_mode = isset($_POST['search_mode']) ? $_POST['search_mode'] : '';
    if ($post_type) {
        $post_type = $post_type === "product" ? "product" : "post";
    }
    if ($query_s !== false) {
        $args = [
            's' => $query_s,
            'posts_per_page' => 10,
            'post_type' => $post_type,
            'post_status' => 'publish'
        ];
        if ($query_cat !== false) {
            if ($post_type === "product") {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => [$query_cat],
                    ],
                ];
            } else {
                $args['cat'] = $query_cat;
            }
        }
        if ($query_stuck !== false && $post_type === "product") {
            if ($query_stuck === "true") {
                $args['meta_query']['relation'] = 'AND';
                $args['meta_query'][] = [
                    'key' => '_stock_status',
                    'value' => 'instock',
                    'compare' => '=',
                ];
            }
        }


        $the_query = new WP_Query($args);
        if ($post_type === "product") {
            if (!$the_query->have_posts()) {
                if (is_numeric($query_s)) {
                    unset($args['s']);
                    $args['p'] = $query_s;

                    $the_query = new WP_Query($args);
                }
                if (!$the_query->have_posts()) {
                    unset($args['s'], $args['p']);
                    $args['meta_query'][] = [
                        'key' => '_sku',
                        'value' => $query_s,
                        'compare' => '=',
                    ];
                    $the_query = new WP_Query($args);
                }
            }
        }
        $posts = [];
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();

                if ($post_type === "product") {
                    $pf = new WC_Product_Factory();
                    $prd = $pf->get_product(get_the_id());
                    if ($prd) {
                        $posts[] = [
                            'id' => get_the_id(),
                            'title' => get_the_title(),
                            'price' => !empty($prd->get_price_html()) ? $prd->get_price_html() : 'جزئیات بیشتر در صفحه محصول',
                            'url' => get_the_permalink(),
                            'compare' => $search_mode === 'compare' ? negarshop_print_compare_btn(get_the_id(), null, false, 'btn btn-primary') : false,
                            'thumb' => get_the_post_thumbnail_url(get_the_id(), 'thumbnail') ? get_the_post_thumbnail_url(get_the_id(), 'thumbnail') : ''
                        ];
                    }
                } else {
                    $posts[] = [
                        'id' => get_the_id(),
                        'title' => get_the_title(),
                        'price' => '',
                        'url' => get_the_permalink(),
                        'compare' => false,
                        'thumb' => get_the_post_thumbnail_url(get_the_id(), 'thumbnail') ? get_the_post_thumbnail_url(get_the_id(), 'thumbnail') : ''
                    ];
                }
            }
            wp_reset_postdata();
        }
        $json_array['status'] = true;
        $json_array['data'] = $posts;

    }

    wp_send_json($json_array);
    wp_die();
}

add_action('wp_ajax_negarshop_ajax_search', 'negarshop_ajax_search');
add_action('wp_ajax_nopriv_negarshop_ajax_search', 'negarshop_ajax_search');