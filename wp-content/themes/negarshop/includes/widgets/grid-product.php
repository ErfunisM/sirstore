<?php
/**
 * Grid product widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_grid_post_ajax() {
    header("Content-type:application/json");
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    $atts = negarshop_string_compress_decode($_POST['query']);
    $offset = (isset($_POST['offset']) and is_numeric($_POST['offset'])) ? $_POST['offset'] : 0;
    $atts = json_decode($atts, true);
    $slides = [];
    $posts_pp = 0;
    if ($atts['items_type'] == 'custom') {
        $slideAtts = $atts['items_type_picker'];
        $slideAtts = $slideAtts['custom'];
        $slideAtts = $slideAtts['slides'];
        $slides = $slideAtts;
    } else {
        $posts_pp = $atts['items_type_picker'];
        $slide_products = $posts_pp['products'];
        $posts_pp = (int)$slide_products['products_count'];
        $product_picker = $slide_products['products_type_picker'];

        $args = [
            'post_type' => 'product',
            'posts_per_page' => $posts_pp,
            'offset' => $offset * $posts_pp
        ];
        if ($product_picker['products_type'] == "ids") {
            $ids_list = $product_picker['ids'];
            $ids_list = $ids_list['product_ids'];
            $ids_list = explode(',', $ids_list);
            $args['post__in'] = $ids_list;
        }
        if ($product_picker['products_type'] == "category") {
            $categories = $product_picker['category'];
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $categories['woo_categories'],
                ]
            ];
        }
        if ($product_picker['products_type'] == "views") {
            $args['meta_key'] = 'post_views_count';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            $posts_date = $product_picker['views'];
            $posts_date = $posts_date['views_time'];
            if ($posts_date == "day") {
                $args['date_query'] = [
                    [
                        'after' => '1 day ago'
                    ]
                ];
            } else if ($posts_date == "week") {
                $args['date_query'] = [
                    [
                        'after' => '1 week ago'
                    ]
                ];
            } else if ($posts_date == "month") {
                $args['date_query'] = [
                    [
                        'after' => '1 month ago'
                    ]
                ];
            } else if ($posts_date == "year") {
                $args['date_query'] = [
                    [
                        'after' => '1 year ago'
                    ]
                ];
            }
        }
        if ($product_picker['products_type'] == "sell") {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
            $posts_date = $product_picker['sell'];
            $posts_date = $posts_date['sell_time'];
            if ($posts_date == "day") {
                $args['date_query'] = [
                    [
                        'after' => '1 day ago'
                    ]
                ];
            } else if ($posts_date == "week") {
                $args['date_query'] = [
                    [
                        'after' => '1 week ago'
                    ]
                ];
            } else if ($posts_date == "month") {
                $args['date_query'] = [
                    [
                        'after' => '1 month ago'
                    ]
                ];
            } else if ($posts_date == "year") {
                $args['date_query'] = [
                    [
                        'after' => '1 year ago'
                    ]
                ];
            }
        }
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $pf = new WC_Product_Factory();
                $prd = $pf->get_product(get_the_id());
                $slides[] = $prd;
            }
            wp_reset_postdata();
        }
    }

    if (!empty($slides)) {
        $fint = 0;
        ob_start();
        foreach ($slides as $item):
            negarshop_carousel_item($item, false, $atts['grid']);
            $fint++;
        endforeach;
        $output = ob_get_contents();
        ob_end_clean();
        $json_array['status'] = true;
        $json_array['data'] = $output;
        $next_arg = $args;
        $next_arg['offset'] = ($offset + 1) * $posts_pp;
        $the_query = new WP_Query($next_arg);
        if ($the_query->have_posts()) {
            $json_array['next'] = true;
        } else {
            $json_array['next'] = false;
        }
    }


    echo json_encode($json_array);
    wp_die();
}

add_action('wp_ajax_negarshop_grid_post_ajax', 'negarshop_grid_post_ajax');
add_action('wp_ajax_nopriv_negarshop_grid_post_ajax', 'negarshop_grid_post_ajax');