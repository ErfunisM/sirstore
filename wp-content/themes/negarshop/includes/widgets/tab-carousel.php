<?php
/**
 * Tab carousel hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_ajax_tabcarousel () {
    header("Content-type:application/json");
    $json_array   = [
        'status' => false,
        'data'   => ''
    ];
    $query_decode = ($_POST['query']) ? $_POST['query'] : false;
    $item_opts    = (isset($_POST['opts'])) ? $_POST['opts'] : false;
    if ( $query_decode !== false ) {
        $query_decode = negarshop_string_compress_decode($_POST['query']);
        $query_decode = json_decode($query_decode, true);
        $tab_1        = $query_decode;
        $item_opts    = ($item_opts !== false) ? json_decode(negarshop_string_compress_decode($item_opts), true) : [];
        $slides       = [];
        if ( $tab_1['items_type'] == 'custom' ) {
            $slideAtts = $tab_1['items_type_picker'];
            $slideAtts = $slideAtts['custom'];
            $slideAtts = $slideAtts['slides'];
            $slides    = $slideAtts;
        } else {
            $posts_pp       = $tab_1['items_type_picker'];
            $slide_products = $posts_pp['products'];
            $posts_pp       = (int) $slide_products['products_count'];
            $product_picker = $slide_products['products_type_picker'];

            $args = [
                'post_type'      => 'product',
                'posts_per_page' => $posts_pp,
                'post_status'   =>  'publish'
            ];
            if ( $product_picker['products_type'] == "ids" ) {
                $ids_list         = $product_picker['ids'];
                $ids_list         = $ids_list['product_ids'];
                $ids_list         = explode(',', $ids_list);
                $args['post__in'] = $ids_list;
            }
            if ( $product_picker['products_type'] == "category" ) {
                $categories        = $product_picker['category'];
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'product_cat',
                        'field'    => 'id',
                        'terms'    => $categories['woo_categories'],
                    ]
                ];
            }
            if ( $product_picker['products_type'] == "tag" ) {
                $tags              = $product_picker['tag'];
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'product_tag',
                        'field'    => 'id',
                        'terms'    => $tags['woo_tags'],
                    ]
                ];
            }
            if ( $product_picker['products_type'] == "views" ) {
                $posts_date       = $product_picker['views']['views_time'];
                $cbgtw            = negarshop_get_date_views($posts_date);
                $post_ids         = (empty($cbgtw)) ? [0] : negarshop_get_date_views($posts_date);
                $args['post__in'] = $post_ids;
                $args['orderby']  = 'post__in';

            }
            if ( $product_picker['products_type'] == "sell" ) {
                global $woocommerce;
                include_once $woocommerce->plugin_path() . '/includes/admin/reports/class-wc-admin-report.php';
                $wc_report     = new WC_Admin_Report();
                $current_range = 'last_month';

                $posts_date = $product_picker['sell']['sell_time'];
                $wc_report->check_current_range_nonce($posts_date);
                $wc_report->calculate_current_range($posts_date);


                $top_sellers = $wc_report->get_order_report_data([
                    'data'         => [
                        '_product_id' => [
                            'type'            => 'order_item_meta',
                            'order_item_type' => 'line_item',
                            'function'        => '',
                            'name'            => 'product_id',
                        ],
                        '_qty'        => [
                            'type'            => 'order_item_meta',
                            'order_item_type' => 'line_item',
                            'function'        => 'SUM',
                            'name'            => 'order_item_qty',
                        ],
                    ],
                    'order_by'     => 'order_item_qty DESC',
                    'group_by'     => 'product_id',
                    'limit'        => $posts_pp,
                    'query_type'   => 'get_results',
                    'filter_range' => true,
                ]);
                $top_sels    = [0];
                unset($args['posts_per_page']);
                if ( $top_sellers ) {
                    foreach ( $top_sellers as $item ) {
                        $top_sels[] = $item->product_id;
                    }
                    $args['posts_per_page'] = -1;
                }
                $args['post__in'] = $top_sels;
                $args['orderby']  = 'post__in';
            }


            if ( $tab_1['products_stock'] === "instock" ) {
                $args['meta_query'][] = [
                    'key'   => '_stock_status',
                    'value' => 'instock'
                ];
            }
            if ( $tab_1['products_stock'] === "outofstock" ) {
                $args['meta_query'][] = [
                    'key'     => '_stock_status',
                    'compare' => '!=',
                    'value'   => 'instock'
                ];
            }
            if ( $tab_1['products_stock'] === "sale" ) {
                $args['meta_query'][] = [
                    'key'   => 'product_sale_slider',
                    'value' => 'true'
                ];
            }

            $the_query = new WP_Query($args);
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $pf       = new WC_Product_Factory();
                    $prd      = $pf->get_product(get_the_id());
                    $slides[] = $prd;
                }
                wp_reset_postdata();
            }
        }
        ob_start();
        $fint = 0;
        foreach ( $slides as $item ): ?>
            <div id="car-item-<?php echo $tab_1['id'] . '-' . $fint; ?>">
                <?php negarshop_carousel_item($item, false, false, $item_opts); ?>
            </div>
            <?php $fint++; endforeach; ?>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        $json_array['status'] = true;
        $json_array['data']   = [
            'content' => $output,
            'archive' => !empty($tab_1['link']) ? $tab_1['link'] : ''
        ];
    }

    echo json_encode($json_array);
    wp_die();
}

add_action('wp_ajax_negarshop_ajax_tabcarousel', 'negarshop_ajax_tabcarousel');
add_action('wp_ajax_nopriv_negarshop_ajax_tabcarousel', 'negarshop_ajax_tabcarousel');