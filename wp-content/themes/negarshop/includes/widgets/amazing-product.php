<?php
/**
 * Amazing product widget template.
 *
 * @package negarshop
 */

function negarshop_widget_amazing_product($options) {
    $options = wp_parse_args($options, array(
            'widget_style'  =>  ''
    ));
    $slider_options = array(
        'rtl' => true,
        'items' => 1,
        'nav' => false,
        'loop' => false,
        'dots' => true,
    );
    ?>
    <section class="content-widget amazing-product-widget amazing-product-widget--<?php echo esc_attr($options['widget_style']); ?>" id="content-widget-<?php echo $options['id']; ?>">
        <div class="owl-carousel" data-slider="<?php echo esc_attr(wp_json_encode($slider_options)); ?>">
            <?php
            $posts_pp = $options['items_type_picker'];
            $slide_products = $posts_pp['products'];
            $posts_pp = (int)$slide_products['products_count'];
            $product_picker = $slide_products['products_type_picker'];
            $args = [
                'post_type' => 'product',
                'posts_per_page' => $posts_pp,
                'orderby' => 'rand'
            ];
            if ($product_picker['products_type'] == "ids") {
                $ids_list = $product_picker['ids'];
                $ids_list = $ids_list['product_ids'];
                $ids_list = explode(',', $ids_list);
                $args['orderby'] = 'post__in';
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
            $tab_titles = [];
            if ($product_picker['products_type'] == "idsTitled") {
                $ids_list = $product_picker['idsTitled'];
                $items_list = $ids_list['items'];
                $ids_list = [];
                foreach ($items_list as $item) {
                    $ids_list[] = $item['id'];
                    $tab_titles[$item['id']] = $item['title'];
                }
                $args['orderby'] = 'post__in';
                $args['post__in'] = $ids_list;
            }
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) {
                while ($the_query->have_posts()) {
                    $the_query->the_post();

                    $pf = new WC_Product_Factory();
                    $prd = $pf->get_product(get_the_id());
                    $st_time = false;
                    $ed_time = false;

                    if ($prd->get_type() == "simple" or $prd->get_type() == "external") {
                        $st_time = new WC_DateTime($prd->get_date_on_sale_from());
                        $ed_time = new WC_DateTime($prd->get_date_on_sale_to());
                        $st_time = $st_time->getTimestamp();
                        $ed_time = $ed_time->getTimestamp();
                    } else if ($prd->get_type() == "variable" and $prd->has_child()) {
                        $vr_product_dates = negarshop_get_variable_product_values($prd->get_children(), "dates");
                        if ($vr_product_dates !== false) {
                            $st_time = $vr_product_dates['start_time'];
                            $ed_time = $vr_product_dates['end_time'];
                            $st_time = $st_time->getTimestamp();
                            $ed_time = $ed_time->getTimestamp();
                        }
                    }
                    if (negarshop_is_demo()) {
                        $st_time = time() - 3600;
                        $ed_time = time() + 3600;
                    }
                    ?>
                    <div class="owl-slide amazing-product-item <?php echo $item['product_type']; ?>">
                        <header class="item-header">
                            <figure class="item-figure">
                                <a href="<?php echo $prd->get_permalink(); ?>" title="<?php echo $prd->get_title(); ?>">
                                    <?php echo $prd->get_image(); ?>
                                </a>
                            </figure>
                            <div class="item-title">
                                <h3 class="title"><a
                                            href="<?php echo $prd->get_permalink(); ?>"><?php echo negarshop_excerpt_crop($prd->get_title(), 55); ?></a>
                                </h3>
                                <div class="star"><?php echo wc_get_rating_html(empty($prd->get_average_rating()) ? 5 : $prd->get_average_rating(), $prd->get_rating_count()); ?></div>
                            </div>
                        </header>
                        <footer class="item-footer">
                            <div class="countdown-outer">
                                <div class="countdown-title">
                                    <?php esc_html_e('تخفیف','negarshop'); ?>
                                    <b><?php esc_html_e('ویـــــــژه','negarshop'); ?></b>
                                </div>
                                <div class="countdown-inner">
                                    <?php
                                    if (!empty($st_time) && is_numeric($st_time) && $st_time > time()) {
                                        echo '<div class="not-started"><i class="fal fa-clock"></i><span>' . __('هنوز شروع نشده!', 'negarshop') . '</span></div>';
                                    } else if (!empty($ed_time) && is_numeric($ed_time) && (($ed_time - time()) > 0)) { ?>
                                        <div class="negarshop-countdown"
                                             data-date="<?php echo date('Y/m/d 23:59:59', $ed_time); ?>"></div>
                                    <?php } ?>
                                    <?php
                                    if (!negarshop_product_in_stock($prd->get_id())) {
                                        echo '<div class="finished"><i class="fal fa-surprise "></i><span>' . __('تمام شد!', 'negarshop') . '</span></div>';
                                    } ?>
                                </div>
                            </div>
                            <div class="item-pricing">
                                <div class="stock-bar">
                                    <span class="stock-bar-title"><?php echo $prd->get_manage_stock() ? sprintf(__('فقط %s تا باقی مانده', 'negarshop'), '<b>' . $prd->get_stock_quantity() . '</b>') : __('فروش محدود', 'negarshop'); ?></span>
                                    <?php
                                    $quantity = $prd->get_manage_stock() ? (int)$prd->get_stock_quantity() : 0;
                                    $total_sale = empty($prd->get_total_sales()) ? 0 : $prd->get_total_sales();
                                    $percent = 95;
                                    if ($quantity !== 0 and $total_sale !== 0) {
                                        $percent = (100 * $total_sale) / ($quantity + $total_sale);
                                    }
                                    ?>
                                    <div class="progress mb-2" style="height: 5px;">
                                        <div class="progress-bar"
                                             aria-label="<?php _e('میزان فروش', 'negarshop') ?>"
                                             role="progressbar"
                                             style="width: <?php echo $percent; ?>%;"></div>
                                    </div>
                                </div>
                                <div class="item-price">
                                    <?php echo negarshop_price($prd); ?>
                                </div>
                                <div class="item-buttons">
                                    <a href="<?php echo $prd->get_permalink(); ?>" class="btn btn-primary btn-large"><?php esc_html_e('خرید محصول','negarshop'); ?></a>
                                </div>
                            </div>
                        </footer>
                    </div>
                    <?php
                }
                wp_reset_postdata();
            }

            ?>
        </div>
    </section>
    <?php
}