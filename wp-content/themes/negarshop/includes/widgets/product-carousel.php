<?php
/**
 * Product carousel widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_page_widget_carousel($atts) {
    $tabs = $atts['tabs'];
    $image_size = negarshop_image_size_builder($atts['card_image'], $atts['card_custom_image_width'], $atts['card_custom_image_height']);
    $items_opts = negarshop_product_card_elementor_data($atts);
    ?>
    <section
            class="content-widget products-carousel tabs-count-<?php echo count($tabs); ?> tabs"
            id="content-widget-<?php echo $atts['id']; ?>">
        <?php if ($atts['tab_mode'] === 'side'): ?>
        <div class="row">
            <div class="col-lg-2">
                <?php endif; ?>
                <?php if (!empty($tabs) and !(count($tabs) == 1 and empty($tabs[0]['tab_name']))) { ?>
                    <header class="section-header" id="content-widget-header-<?php echo $atts['id']; ?>">
                        <ul class="tabs tabs--<?php echo esc_attr($atts['tab_mode']); ?>">
                            <?php $forint = 0;
                            $tab_link = "/";
                            if (isset($tabs[0]['link']) && !empty($tabs[0]['link'])) {
                                $tab_link = $tabs[0]['link'];
                            }
                            foreach ($tabs as $item):
                                $item['id'] = $atts['id'];
                                $item['image_size'] = $image_size;
                                $item['products_stock'] = isset($item['products_stock']) ? $item['products_stock'] : 'all';
                                $encoded_query = json_encode($item);
                                $encoded_query = negarshop_string_compress_encode($encoded_query);
                                ?>
                                <li class="<?php echo ($forint == 0) ? 'active' : ''; ?>">
                                    <a href="#<?php echo $atts['id'] . '_' . $forint; ?>"
                                       data-query="<?php echo $encoded_query; ?>"
                                       data-opts="<?php echo negarshop_string_compress_encode(json_encode($items_opts)); ?>"><?php echo $item['tab_name']; ?></a>
                                </li>
                                <?php $forint++; endforeach; ?>
                        </ul>
                        <?php if ($atts['tab_mode'] !== 'side'): ?>
                            <a href="<?php echo esc_attr($tab_link); ?>"
                               class="btn archive-link"><?php _e('دیدن همه', 'negarshop'); ?></a>
                        <?php endif; ?>
                    </header>
                <?php } ?>
                <?php if ($atts['tab_mode'] === 'side'): ?>
            </div>
            <div class="col-lg-10">
                <?php endif; ?>
                <?php
                $responsive_items = [
                    'sm' => $atts['carousel_items_xs'],
                    'md' => $atts['carousel_items_md'],
                    'lg' => $atts['carousel_items_lg'],
                    'xl' => $atts['carousel_items_xl']
                ];
                ?>
                <div class="carousel-content">
                    <div class="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="owl-carousel" data-carousel="<?php echo esc_attr(json_encode([
                        'nav' => $atts['carousel_nav'] == "true",
                        'loop' => $atts['carousel_loop'] == "true",
                        'autoplay' => $atts['carousel_autoplay'] == "true"
                    ])); ?>" data-items="<?php echo esc_attr(json_encode($responsive_items)); ?>"
                         id="product-carousel-<?php echo $atts['id']; ?>">
                        <?php
                        $tab_1 = $tabs[0];
                        $slides = [];
                        if ($tab_1['items_type'] == 'custom') {
                            $slideAtts = $tab_1['items_type_picker'];
                            $slideAtts = $slideAtts['custom'];
                            $slideAtts = $slideAtts['slides'];
                            $slides = $slideAtts;
                        } else {
                            $posts_pp = $tab_1['items_type_picker'];
                            $slide_products = $posts_pp['products'];
                            $posts_pp = (int)$slide_products['products_count'];
                            $product_picker = $slide_products['products_type_picker'];
                            $tab_1['products_stock'] = isset($tab_1['products_stock']) ? $tab_1['products_stock'] : 'all';
                            $args = [
                                'post_type' => 'product',
                                'posts_per_page' => $posts_pp
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
                            if ($product_picker['products_type'] == "tag") {
                                $tags = $product_picker['tag'];
                                $args['tax_query'] = [
                                    [
                                        'taxonomy' => 'product_tag',
                                        'field' => 'id',
                                        'terms' => $tags['woo_tags'],
                                    ]
                                ];
                            }
                            if ($product_picker['products_type'] == "views") {
                                $posts_date = $product_picker['views']['views_time'];
                                $cbgdw = negarshop_get_date_views($posts_date);
                                $post_ids = (empty($cbgdw)) ? [0] : negarshop_get_date_views($posts_date);
                                $args['post__in'] = $post_ids;
                                $args['orderby'] = 'post__in';

                            }
                            if ($product_picker['products_type'] == "sell") {
                                global $woocommerce;
                                include_once $woocommerce->plugin_path() . '/includes/admin/reports/class-wc-admin-report.php';
                                $wc_report = new WC_Admin_Report();
                                $current_range = 'last_month';

                                $posts_date = $product_picker['sell']['sell_time'];
                                $wc_report->check_current_range_nonce($posts_date);
                                $wc_report->calculate_current_range($posts_date);


                                $top_sellers = $wc_report->get_order_report_data([
                                    'data' => [
                                        '_product_id' => [
                                            'type' => 'order_item_meta',
                                            'order_item_type' => 'line_item',
                                            'function' => '',
                                            'name' => 'product_id',
                                        ],
                                        '_qty' => [
                                            'type' => 'order_item_meta',
                                            'order_item_type' => 'line_item',
                                            'function' => 'SUM',
                                            'name' => 'order_item_qty',
                                        ],
                                    ],
                                    'order_by' => 'order_item_qty DESC',
                                    'group_by' => 'product_id',
                                    'limit' => $posts_pp,
                                    'query_type' => 'get_results',
                                    'filter_range' => true,
                                ]);
                                $top_sels = [0];
                                unset($args['posts_per_page']);
                                if ($top_sellers) {
                                    foreach ($top_sellers as $item) {
                                        $top_sels[] = $item->product_id;
                                    }
                                    $args['posts_per_page'] = -1;
                                }
                                $args['post__in'] = $top_sels;
                                $args['orderby'] = 'post__in';
                            }


                            if ($product_picker['products_type'] === "archive" && is_archive()) {
                                $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

                                if ($term !== false) {
                                    $args['tax_query'] = [
                                        [
                                            'taxonomy' => $term->taxonomy,
                                            'field' => 'id',
                                            'terms' => $term->term_id,
                                        ]
                                    ];
                                }
                            }


                            if ($tab_1['products_stock'] === "instock") {
                                $args['meta_query'][] = [
                                    'key' => '_stock_status',
                                    'value' => 'instock'
                                ];
                            }

                            if ($tab_1['products_stock'] === "outofstock") {
                                $args['meta_query'][] = [
                                    'key' => '_stock_status',
                                    'compare' => '!=',
                                    'value' => 'instock'
                                ];
                            }
                            if ($tab_1['products_stock'] === "sale") {
                                $args['meta_query'][] = [
                                    'key' => 'product_sale_slider',
                                    'value' => 'true'
                                ];
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
                        $fint = 0;
                        foreach ($slides as $item): ?>
                            <div id="car-item-<?php echo $atts['id'] . '-' . $fint; ?>">
                                <?php negarshop_carousel_item($item, false, false, $items_opts); ?>
                            </div>
                            <?php $fint++; endforeach; ?>
                    </div>
                </div>
                <?php if ($atts['tab_mode'] === 'side'): ?>
            </div>
        </div>
    <?php endif; ?>


        <script>
            jQuery(document).ready(function ($) {
                $('#product-carousel-<?php echo $atts['id']; ?>').owlCarousel({
                    rtl: true,
                    <?php if ($atts['carousel_autoplay'] == "true") {
                        echo 'autoplay:true,
                autoplayTimeout:7000,
                autoplayHoverPause:false,';
                    } ?>
                    nav: <?php echo $atts['carousel_nav']; ?>,
                    dots: false,
                    loop: <?php echo $atts['carousel_loop']; ?>,
                    navText: ["<i class='fal fa-angle-right'></i>", "<i class='fal fa-angle-left'></i>"],
                    navElement: 'button type="button" role="presentation" aria-label="slider navigation"',
                    responsive: {
                        0: {
                            items: <?php echo $atts['carousel_items_xs']; ?>,
                        },
                        480: {
                            items: <?php echo $atts['carousel_items_md']; ?>,
                        },
                        700: {
                            items: <?php echo $atts['carousel_items_lg']; ?>,
                        },
                        991: {
                            items: <?php echo $atts['carousel_items_xl']; ?>,
                        },
                    },
                    autoplayHoverPause: true,
                    margin: 15
                });

            });
        </script>
    </section>
    <?php
}