<?php
/**
 * Price changes feature hooks and libraries.
 *
 * @package negarshop
 */

define("CB_P_CHANGE", 'cb_price_changes');

function negarshop_price_change_ajax() {
    header("Content-type:application/json");
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    if (isset($_POST['query'])) {
        $query = $_POST['query'];
        $category = (isset($query['cat']) and $query['cat'] !== "false" and is_numeric($query['cat'])) ? $query['cat'] : false;
        $ppp = (isset($query['ppp']) and $query['ppp'] !== "false" and is_numeric($query['ppp'])) ? $query['ppp'] : false;
        $order = (isset($query['order']) and $query['order'] !== "false") ? $query['order'] : false;
        $stock = (isset($query['stock']) and $query['stock'] !== "false") ? ($query['stock'] == true) ? "instock" : "outofsale" : false;
        $columns = (isset($query['columns'])) ? json_decode(negarshop_string_compress_decode($query['columns']), true) : [];
        $dateformat = (isset($query['date'])) ? negarshop_string_compress_decode($query['date']) : false;
        $args = [];

        if ($category !== false) {
            $args['cat'] = $category;
        }
        if ($ppp !== false) {
            $args['ppp'] = $ppp;
        }
        if ($stock !== false) {
            $args['stock'] = $stock;
        }

        $args2 = negarshop_price_change_args($args);
        if (!empty($args2)) {
            ob_start();
            negarshop_print_changes_item($args2, $columns, $dateformat);
            $output = ob_get_contents();
            ob_end_clean();

            $json_array['data'] = $output;
        } else {
            $json_array['data'] = '<tr><td></td><td>' . __("محصولی یافت نشد!", 'negarshop') . '</td></tr>';
        }
        $json_array['status'] = true;
    }
    wp_send_json($json_array);
}

function negarshop_price_changes_add_meta($post_id, $reg, $sale) {
    $key_name = CB_P_CHANGE;
    $value_array = array();
    $value = array(
        'reg' => $reg,
        'sale' => $sale,
    );
    $current_time = time();
    $value_array[$current_time] = $value;

    $meta_value = json_encode($value_array);

    $check_exist = $value_array;
    $check_exist[$current_time]['sale'] = '%';
    $exist_array_js = json_encode($check_exist);
    global $wpdb;
    $wbd_query = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_value like '$exist_array_js' and post_id = $post_id";
    $results = $wpdb->get_results($wbd_query, OBJECT);
    $add_meta = false;
    if (empty($results)) {
        $add_meta = add_post_meta($post_id, $key_name, $meta_value, false);
    } else {
        $exs_meta_id = $results[0];
        $exs_meta_val = $exs_meta_id->meta_value;
        $add_meta = update_post_meta($post_id, $key_name, $meta_value, $exs_meta_val);
    }
    return $add_meta;
}

function negarshop_price_changes_on_product_save($meta_id, $post_id, $meta_key, $meta_value) {
    if ($meta_key == '_regular_price' or $meta_key == '_sale_price') {
        if (get_post_type($post_id) == 'product') {
            $pf = new WC_Product_Factory();
            $prd = $pf->get_product($post_id);
            if ($prd->get_type() == "simple" or $prd->get_type() == "external") {
                negarshop_price_changes_add_meta($post_id, $prd->get_regular_price(), $prd->get_sale_price());
            }
        }
    }
}

function negarshop_price_changes($before, $after) {
    $changes = (int)$after - (int)$before;
    if ($changes === 0) {
        return "<i class='static fas fa-stop' title='" . _e('ثابت', 'negarshop') . "'></i>";
    } else if ($changes > 0) {
        return "<i class='increase fas fa-angle-up' title='" . _e('افزایش', 'negarshop') . "'></i>";
    } else if ($changes < 0) {
        return "<i class='decrease fas fa-angle-down' title='" . _e('کاهش', 'negarshop') . "'></i>";
    }
}

function negarshop_price_change_args($args = array()): array {
    global $wpdb;
    $qy_where = "WHERE meta_key = '" . CB_P_CHANGE . "'";
    $limit_count = 30;
    $orderby = "";
    if (is_numeric($args['cat'])) {
        $args['cat'] = array($args['cat']);
    }

    $wp_args = array(
        'post_type' => array('product', 'product_variation'),
        'posts_per_page' => -1,
    );
    if (isset($args['ppp']) and is_numeric($args['ppp'])) {
        $limit_count = $args['ppp'];
    }
    if (isset($args['cat']) and is_array($args['cat'])) {
        $wp_args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => $args['cat'],
            )
        );
    }
    if (isset($args['order'])) {
        if ($args['order'] == "sales") {
            $wp_args['meta_key'] = 'total_sales';
            $wp_args['orderby'] = 'meta_value_num';
            $wp_args['order'] = 'DESC';
        }
        if ($args['order'] == "views") {
            $wp_args['meta_key'] = 'post_views_count';
            $wp_args['orderby'] = 'meta_value_num';
            $wp_args['order'] = 'DESC';
        }
    }
    if (isset($args['stock'])) {
        if ($args['stock'] == "instock") {
            $wp_args['meta_key'] = '_stock_status';
            $wp_args['meta_value'] = 'instock';
        }
    }


    $the_query = new WP_Query($wp_args);
    $posts_ids = array();

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $posts_ids[] = get_the_ID();
        }
    }
    $qy_where .= ' and post_id IN (' . implode(', ', $posts_ids) . ')';
    $query = "SELECT * FROM {$wpdb->prefix}postmeta $qy_where order by meta_id DESC";
    $results = $wpdb->get_results($query, OBJECT);
    $slef_res = array();
    $filter_res = array();
    foreach ($results as $result) {
        if (!in_array($result->post_id, $filter_res)) {
            $filter_res[] = $result->post_id;
            $slef_res[] = $result;
        }
    }
    if ($limit_count != -1) {
        return array_slice($slef_res, 0, $limit_count);
    } else {
        return $slef_res;
    }
}

function negarshop_print_changes_item($results, $columns_to_dis = array(), $dateformat = false, $item_parent_tag = 'tr', $item_child_tag = 'td') {
    if (!empty($results)):
        $i = 0;
        foreach ($results as $item): if (get_post_status((int)$item->post_id) == 'publish') {
            $i++;
            $parse_meta_val = json_decode($item->meta_value, true);
            $meta_time = array_keys($parse_meta_val);
            $post_all_changes = get_post_meta($item->post_id, CB_P_CHANGE);
            $current_item_index = array_search($item->meta_value, $post_all_changes);
            $past_prices = false;
            $past_prices_time = false;
            if ($current_item_index > 0) {
                $past_prices = $post_all_changes[$current_item_index - 1];
            }
            if ($past_prices !== false) {
                $past_prices = json_decode($past_prices, true);
                $past_prices_time = array_keys($past_prices);
            }

            $pp_show = null;
            $np_show = null;
            ?>
            <<?php echo $item_parent_tag; ?>>

            <?php if (!isset($columns_to_dis['order'])): ?>
                <<?php echo $item_child_tag; ?> class="order">
                <?php echo $i; ?>
                </<?php echo $item_child_tag; ?>>
            <?php endif; ?>

            <?php if (!isset($columns_to_dis['thumbnail'])): ?>
                <<?php echo $item_child_tag; ?> class="thumbnail">
                <a href="<?php echo get_the_permalink((int)$item->post_id); ?>">
                    <?php
                    $prd = false;
                    if (get_post_type((int)$item->post_id) == "product_variation") {
                        $pf = new WC_Product_Factory();
                        $prd = $pf->get_product((int)$item->post_id);
                        echo $prd->get_image();
                    } else {
                        echo get_the_post_thumbnail((int)$item->post_id, 'thumbnail-50');
                    }
                    ?>
                </a>
                </<?php echo $item_child_tag; ?>>
            <?php endif; ?>

            <?php if (!isset($columns_to_dis['title'])): ?>
                <<?php echo $item_child_tag; ?> class="title">
                <a href="<?php echo get_the_permalink((int)$item->post_id); ?>">
                    <?php
                    if (get_post_type((int)$item->post_id) == "product_variation") {
                        echo get_the_title($prd->get_parent_id());
                        echo '<span class="attributes">';
                        foreach ($prd->get_attributes() as $key => $val) {
                            echo '<span>' . urldecode(str_replace("pa_", '', $key)) . ': ' . str_replace('-', ' ', urldecode($val)) . '</span> ';
                        }
                        echo '</span>';
                    } else {
                        echo get_the_title((int)$item->post_id);
                    }
                    ?>
                </a>
                </<?php echo $item_child_tag; ?>>
            <?php endif; ?>

            <?php if (!isset($columns_to_dis['date'])): ?><<?php echo $item_child_tag; ?> class="date"><?php echo date_i18n(($dateformat !== false) ? $dateformat : 'Y/m/d H:i:s', $meta_time[0]); ?></<?php echo $item_child_tag; ?>><?php endif; ?>

            <?php if (!isset($columns_to_dis['past-price'])): ?><<?php echo $item_child_tag; ?> class="past-price">

                <?php
                $pp_regu = $past_prices[$past_prices_time[0]]['reg'];
                $pp_sale = $past_prices[$past_prices_time[0]]['sale'];
                $pp_show = $pp_regu;
                if ($pp_sale != null and $pp_sale != "") {
                    $pp_show = $pp_sale;
                }
                ?>
                <div class="show-price">
                    <span><?php echo ($pp_show !== null) ? wc_price($pp_show) : ''; ?></span>
                </div>
                </<?php echo $item_child_tag; ?>><?php endif; ?>

            <?php if (!isset($columns_to_dis['new-price'])): ?><<?php echo $item_child_tag; ?> class="new-price">


                <?php
                $np_regu = $parse_meta_val[$meta_time[0]]['reg'];
                $np_sale = $parse_meta_val[$meta_time[0]]['sale'];
                $np_show = $np_regu;
                if ($np_sale != null and $np_sale != "") {
                    $np_show = $np_sale;
                }
                ?>
                <div class="show-price">
                    <span><?php echo ($np_show !== null) ? wc_price($np_show) : ''; ?></span>
                </div>

                </<?php echo $item_child_tag; ?>><?php endif; ?>

            <?php if (!isset($columns_to_dis['difference'])): ?><<?php echo $item_child_tag; ?> class="difference">
                <?php if ($past_prices !== false) { ?>

                    <div class="show-price">
                        <span><?php echo ($pp_show !== null) ? wc_price(abs($np_show - $pp_show)) : ''; ?></span>
                    </div>


                <?php } ?>
                </<?php echo $item_child_tag; ?>><?php endif; ?>

            <?php if (!isset($columns_to_dis['changes'])): ?>
                <<?php echo $item_child_tag; ?> class="changes">
                <?php if ($past_prices !== false) { ?>
                    <div class="show-price">
                        <span><?php echo ($pp_show !== null) ? negarshop_price_changes($pp_show, $np_show) : ''; ?></span>
                    </div>
                <?php } ?>
                </<?php echo $item_child_tag; ?>>
            <?php endif; ?>


            </<?php echo $item_parent_tag; ?>>
        <?php } endforeach;
    endif;
}

function negarshop_show_price($pp_regu, $pp_sale) {
    $pp_show = $pp_regu;
    if ($pp_sale != null and $pp_sale != "") {
        $pp_show = $pp_sale;
    }
    return $pp_show;
}

function negarshop_get_chart_data($id) {
    if (is_numeric($id)) {
        $chart_items = array();
        $chart_cats = array();
        $parse_categories = array();
        $parse_stamps = array();
        $parse_series = array();
        $changes_meta = get_post_meta($id, CB_P_CHANGE);
        $changes_meta_array = array();
        foreach ($changes_meta as $key => $item) {
            $item_decode = json_decode($item, true);
            if (isset($item_decode) and !empty($item_decode) and is_array($item_decode)) {
                foreach ($item_decode as $key_in => $item_in) {
                    $changes_meta_array[$key_in] = $item_in;
                }
            }
        }
        foreach ($changes_meta_array as $key => $item) {
            $chart_cats[] = array($key, date_i18n('Y/m/d H:i:s', $key));
            $chart_items[] = (int)negarshop_show_price($item['reg'], $item['sale']);
        }

        foreach ($chart_cats as $item) {
            $parse_categories[] = $item[1];
            $parse_stamps[] = $item[0];
        }
        $parse_series[] = array(
            'name' => get_the_title($id),
            'data' => $chart_items,
        );
        return array(
            'cats' => $parse_categories,
            'cat_stamps' => $parse_stamps,
            'series' => $parse_series,
            'items' => $changes_meta_array,
        );
    }
    return false;
}

function negarshop_print_chart_btn($id, $is_single = false) {
    if (is_numeric($id)) {
        $pf = new WC_Product_Factory();
        $prd = $pf->get_product($id);
        if ($prd === false || $prd === null) {
            return;
        }
        $chart_items = array();
        $chart_cats = array();
        $parse_categories = array();
        $parse_series = array();
        if ($prd->get_type() == "simple") {

            $simple_product_chart = negarshop_get_chart_data($id);
            $parse_categories = $simple_product_chart['cats'];
            $parse_series = $simple_product_chart['series'];

        } else if ($prd->get_type() == "variable") {
            $product_children = $prd->get_children();
            $cats_temp = array();
            $categories_temp = array();
            foreach ($product_children as $product_child) {
                $item_temp = negarshop_get_chart_data($product_child);
                $cats_temp[$product_child] = $item_temp['cat_stamps'];
            }
            foreach ($cats_temp as $item_key => $item_val) {
                if (!empty($item_val)) {
                    foreach ($item_val as $item_time) {
                        $categories_temp[] = $item_time;
                    }
                }
            }
            sort($categories_temp);
            foreach ($categories_temp as $item) {
                $parse_categories[] = date_i18n('Y/m/d H:i:s', $item);
            }
            $loopIndex = 0;
            foreach ($product_children as $product_child) {
                $item_temp = negarshop_get_chart_data($product_child);
                $serie_item = array();
                foreach ($categories_temp as $ct_item) {
                    $pr_int = null;
                    if (isset($item_temp['items'][$ct_item]['reg'])) {
                        $pr_int = negarshop_show_price($item_temp['items'][$ct_item]['reg'], $item_temp['items'][$ct_item]['sale']);
                    }
                    $serie_item[] = ($pr_int === null) ? null : (int)$pr_int;
                }
                $attrs = "";

                $pcf = new WC_Product_Factory();
                $pcrd = $pf->get_product($product_child);
                $pcrd_atts = $pcrd->get_attributes();

                $i = 0;
                foreach ($pcrd_atts as $key => $val) {
                    $i++;
                    $attrs .= urldecode(wc_attribute_label($key, $pcrd)) . ': ' . $pcrd->get_attribute($key);
                    if (count($pcrd_atts) != $i) {
                        $attrs .= ', ';
                    }
                }

                $parse_series[] = array(
                    'name' => $attrs,
                    'data' => $serie_item,
                    'visible' => $loopIndex < 5
                );
                $loopIndex++;
            }

        }

        if (!empty($parse_categories)) {
            if ($is_single) {
                echo "<li>";
            }
            ?>
            <a href="#cb-price-chart" class="product-prices-chart" data-toggle="modal"
               data-target=".chart-modal-<?php echo $id; ?>">
                <?php if ($is_single) {
                    echo __("تغییرات", 'negarshop');
                } else {
                    echo '<i class="fal fa-chart-line "></i>';
                } ?>
            </a>
            <?php if ($is_single) {
                echo "</li>";
            }
            add_action('wp_footer', function () use ($id, $parse_categories, $parse_series) { ?>
                <div class="modal fade chart-modal-<?php echo $id; ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 1100px">
                        <div class="modal-content">
                            <button type="button" class="btn close-modal" data-dismiss="modal">
                                <i class="far fa-times"></i>
                            </button>
                            <div id="orders_statistics_chart_container"></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    jQuery(document).ready(function ($) {

                        Highcharts.chart('orders_statistics_chart_container', {
                            title: {text: '<?php _e('تغییرات قیمت محصول', 'negarshop'); ?>'},
                            subtitle: {text: '<?php the_title(); ?>'},
                            yAxis: {
                                title: {
                                    text: '<?php _e('قیمت ها', 'negarshop'); ?>'
                                },
                                labels: {
                                    formatter: function () {
                                        return this.value;
                                    }
                                }
                            },
                            xAxis: {
                                title: {
                                    text: '<?php _e('تاریخ', 'negarshop'); ?>'
                                },
                                categories: <?php echo json_encode($parse_categories); ?>,
                                scrollbar: {
                                    enabled: true
                                },
                            },
                            legend: {
                                rtl: true,
                                maxHeight: 45,//this was the key property to make my legend paginated
                                //y: 40,//remove position
                                navigation: {
                                    activeColor: '#3E576F',
                                    animation: true,
                                    arrowSize: 12,
                                    inactiveColor: '#CCC',
                                    style: {
                                        fontWeight: 'bold',
                                        color: '#333',
                                        fontSize: '12px'
                                    }
                                }
                            },

                            plotOptions: {
                                series: {
                                    label: {
                                        connectorAllowed: false
                                    }
                                }
                            },
                            tooltip: {
                                useHTML: true,
                                headerFormat: '<p style="text-align: left;   margin-bottom: 0;">{point.key}</p>',
                                pointFormat: '<p style="text-align: right; direction: rtl; margin-bottom: 0;">{series.name}</p><p style="text-align: right; direction: rtl; margin-bottom: 0;"><?php _e('قیمت:', 'negarshop'); ?> {point.y:f} <?php echo get_woocommerce_currency_symbol(); ?></p>'
                            },
                            series: <?php echo json_encode($parse_series); ?>,

                            responsive: {
                                rules: [{
                                    condition: {
                                        maxWidth: 992
                                    },
                                    chartOptions: {
                                        legend: {
                                            layout: 'horizontal',
                                            align: 'center',
                                            verticalAlign: 'bottom'
                                        }
                                    }
                                }]
                            },

                            navigation: {
                                buttonOptions: {
                                    align: 'left'
                                }
                            }

                        });

                    });
                </script>
                <?php
            });
        }
    }
    return false;
}


add_action('wp_ajax_negarshop_price_change_ajax', 'negarshop_price_change_ajax');
add_action('wp_ajax_nopriv_negarshop_price_change_ajax', 'negarshop_price_change_ajax');
add_action('added_post_meta', 'negarshop_price_changes_on_product_save', 10, 4);
add_action('updated_post_meta', 'negarshop_price_changes_on_product_save', 10, 4);