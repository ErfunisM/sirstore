<?php
/**
 * Amazing slider widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_page_widget_amazing($atts)
{

    if (!function_exists('WC')) {
        return;
    }

    $slides = [];
    if ($atts['items_type'] === 'custom') {
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
            'post_type' => ['product', 'product_variation'],
            'meta_query' => [
                [ // Simple products type
                    'key' => 'product_sale_slider',
                    'value' => 'true',
                ]
            ],
            'posts_per_page' => $posts_pp,
        ];
        if ($product_picker['products_type'] == "ids") {
            unset($args['meta_query']);
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
            unset($args['meta_query']);
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
                if ($prd->get_type() == "variation") {
                    $prd = $pf->get_product($prd->get_parent_id());
                }

                $slide_values = [
                    'id' => $prd->get_id(),
                    'title' => $prd->get_title(),
                    'tab_title' => ($product_picker['products_type'] == "idsTitled") ? $tab_titles[$prd->get_id()] : $prd->get_title(),
                    'link' => $prd->get_permalink(),
                    'photo' => [
                        'url' => get_the_post_thumbnail_url($prd->get_id(), 'sz_1_1')
                    ],
                    'reg_price' => $prd->get_regular_price(),
                    'sale_price' => $prd->get_sale_price(),
                    'price' => $prd->get_price_html(),
                    'product_type' => $prd->get_type(),
                    'attributes' => $prd->get_attributes(),
                    'children' => $prd->get_children(),
                    'manage' => $prd->get_manage_stock(),
                    'quantity' => $prd->get_stock_quantity(),
                    'total_sale' => $prd->get_total_sales(),
                    'av_rate' => $prd->get_average_rating(),

                ];

                if ($prd->get_type() == "simple" or $prd->get_type() == "external") {
                    $st_time = new WC_DateTime($prd->get_date_on_sale_from());
                    $ed_time = new WC_DateTime($prd->get_date_on_sale_to());
                    $slide_values['sale_date_start'] = $st_time->getTimestamp();
                    $slide_values['sale_date_end'] = $ed_time->getTimestamp();
                } else if ($prd->get_type() == "variable" and $prd->has_child()) {
                    $vr_product_dates = negarshop_get_variable_product_values($prd->get_children(), "dates");
                    if ($vr_product_dates !== false) {
                        $std_time = $vr_product_dates['start_time'];
                        $end_time = $vr_product_dates['end_time'];
                        $slide_values['sale_date_start'] = $std_time->getTimestamp();
                        $slide_values['sale_date_end'] = $end_time->getTimestamp();
                    }
                }
                if (negarshop_is_demo()) {
                    $slide_values['sale_date_start'] = time() - 3600;
                    $slide_values['sale_date_end'] = time() + 3600;
                }
                $slides[] = $slide_values;
            }
            wp_reset_postdata();
        }
    }
    ?>
    <section
            class="content-widget slider-2 style-2 <?php echo $atts['style'] ?? ''; ?> <?php echo $atts['tabs_style'] ?? ''; ?>"
            id="content-widget-<?php echo $atts['id']; ?>">
        <h6 class="responsive-title"><?php _e('پیشنهاد های شگفت انگیز', 'negarshop') ?></h6>
        <div id="carouselIndicators-<?php echo $atts['id']; ?>" class="carousel ns-fade" data-ride="carousel">
            <div class="row align-items-center">
                <div class="col-lg-auto">
                    <div class="cind-inner">
                        <ol class="carousel-indicators">
                            <?php $fint = 0;
                            foreach ($slides as $item): ?>
                                <li data-target="#carouselIndicators-<?php echo $atts['id']; ?>"
                                    data-slide-to="<?php echo $fint; ?>"
                                    class="<?php if ($fint == 0) {
                                        echo "active";
                                    } ?>"><span><?php echo $item['tab_title']; ?></span></li>
                                <?php $fint++; endforeach; ?>
                        </ol>
                    </div>
                </div>

                <div class="col-lg">
                    <div class="carousel-inner">
                        <?php $fint = 0;
                        foreach ($slides as $item):
                            $product_thumb = $item['photo'];
                            $ribs = negarshop_get_ribbons($item['id']);
                            ?>
                            <div class="carousel-item <?php if ($fint == 0) {
                                echo "active";
                            } ?>">
                                <div class="row">
                                    <div class="col-auto product-thumb">
                                        <div class="pt-content">
                                            <div class="inner">
                                                <div class="thumbnail-fig">
                                                    <a href="<?php echo $item['link']; ?>"
                                                       title="<?php echo $item['title']; ?>"
                                                       style="background-image: url(<?php echo $product_thumb['url']; ?>);"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col product-info">
                                        <div class="footer-sec">
                                            <div class="ribbon-discount-outer">
                                                <?php if (isset($ribs['fal fa-percent']['title']) && $ribs['fal fa-percent']['title'] > 0) { ?>
                                                    <span class="ribbon-discount">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     viewBox="0 0 175.92 174"><g class="cls-1"><g
                                                                id="Layer_2" data-name="Layer 2"><g id="OBJECTS">
                                                                <path
                                                                        class="cls-3"
                                                                        d="M148.38,109.14a53,53,0,0,1-1-7.61,31,31,0,0,1,.26-4.62c.24-2,1-2.49-1-3,1.15.19,1.36.62,1.63-.66a29.28,29.28,0,0,1,4.65-10.79c3.67-5.74,5.86-11.34,4.41-18.28-1.66-7.92-6.74-12.43-13.6-16.13a32.52,32.52,0,0,1-14.38-15.4c-2.57-6-3.7-12.09-9.33-16.16S107.12,10.76,100.39,13c-5.47,1.82-10.11,4.21-16,4.52a30.72,30.72,0,0,1-11.16-1.26c-2.64-.87-5.21-1.93-7.91-2.59a21.82,21.82,0,0,0-22.07,8.82C40.62,26.27,40,30.8,38.47,35a27.38,27.38,0,0,1-2.82,5.62c-.23.35-1.78,2.32-1.58,2.48l1,.8c-.24-.17-.91-.88-1.19-.87a31.29,31.29,0,0,1-3.67,4.21c-2.45,2.34-5.37,4-8.19,5.79a21.62,21.62,0,0,0-6.13,30.78,59.05,59.05,0,0,1,5,7.67,30.42,30.42,0,0,1,1.88,5.14c.36,1.33.51.89,1.68.61-1.18.31-1.5,0-1.17,1.35a31,31,0,0,1,.83,5.43c.22,4.06-.81,8-.81,12.08C23.2,123.65,28,131,34.47,134.61c5.64,3.18,11.83,2.1,17.9,3.35a32.69,32.69,0,0,1,15.86,8.49c4.52,4.35,8.57,8.4,15.12,9.21,7.84,1,14.48-1.72,19.77-7.44,4.6-5.06,9.13-9.1,15.71-11.46,7-2.49,14.64-1.11,20.89-5.69A22,22,0,0,0,148.38,109.14Z"/><circle
                                                                        class="cls-4" cx="84.87" cy="80.93" r="56.59"
                                                                        transform="translate(-32.37 83.72) rotate(-45)"/></g></g></g></svg>
                                                    <span class="count"><i
                                                                class="fal fa-percent"></i><?php echo $ribs['fal fa-percent']['title']; ?></span>
                                                </span>
                                                <?php } ?>
                                            </div>
                                            <div class="title-rate-sec">
                                                <h2 class="item-title"><a
                                                            href="<?php echo $item['link']; ?>"><?php echo $item['title']; ?></a>

                                                </h2>
                                            </div>

                                            <div class="feature-daels-price">
                                                <?php
                                                if ($item['product_type'] == "simple") { ?>
                                                    <span class="
                                <?php if (empty($item['sale_price']) or $item['reg_price'] == $item['sale_price']) {
                                                        echo 'sale-price w-100';
                                                    } else {
                                                        echo "remove-price";
                                                    } ?>"><?php echo wc_price($item['reg_price']); ?></span>
                                                    <?php if (!empty($item['sale_price']) and $item['reg_price'] != $item['sale_price']) { ?>
                                                        <span class="sale-price">
                                            <?php echo wc_price($item['sale_price']); ?></span>                        <?php } ?>
                                                <?php } else { ?>
                                                    <span class="sale-price variable w-100"><?php echo $item['price']; ?></span>
                                                <?php } ?>
                                            </div>


                                            <ul class="feature-attr-p">
                                                <?php
                                                $attributes = negarshop_option('product_vip_attrs', 'posts', $item['id']);
                                                if (!empty($attributes)) {
                                                    ?>
                                                    <?php

                                                    foreach ($attributes as $attribute) :
                                                        ?>
                                                        <li class="product-attr">
                                                            <i class="far fa-check"></i>
                                                            <span class="product-attr-title"><?php echo $attribute['title']; ?>: </span>
                                                            <span class="product-attr-text"><span><?php echo $attribute['values']; ?></span></span>
                                                        </li>
                                                    <?php endforeach; ?>
                                                <?php } ?>
                                            </ul>

                                            <div class="countdown-outer">
                                                <?php
                                                if (isset($item['sale_date_start']) && is_numeric($item['sale_date_start']) && $item['sale_date_start'] > time()) {
                                                    echo '<div class="not-started"><i class="fal fa-clock"></i><span>' . __('هنوز شروع نشده!', 'negarshop') . '</span></div>';
                                                } else if (isset($item['sale_date_end']) and isset($item['sale_date_start']) and (($item['sale_date_end'] - time()) > 0)) { ?>
                                                    <div class="negarshop-countdown"
                                                         data-date="<?php echo date('Y/m/d 23:59:59', $item['sale_date_end']); ?>"></div>
                                                <?php } ?>
                                                <?php
                                                if (!negarshop_product_in_stock($item['id'])) {
                                                    echo '<div class="finished"><i class="fal fa-surprise "></i><span>' . __('تمام شد!', 'negarshop') . '</span></div>';
                                                } ?>
                                            </div>

                                            <div class="product-quantity">
                                                <?php if ($atts['instuck_progress'] == 'true'): ?>
                                                    <div>
                                                        <span class="sale"><?php _e('فروش: ', 'negarshop') ?><?php echo ($item['total_sale'] == "") ? 0 : $item['total_sale']; ?></span>
                                                        <span class="in-stuck float-left"><?php _e('موجودی: ', 'negarshop'); ?><?php echo ($item['manage'] === true) ? $item['quantity'] : __('نامحدود', 'negarshop'); ?></span>
                                                    </div>
                                                    <?php
                                                    $quantity = ($item['manage'] === true) ? (int)$item['quantity'] : 0;
                                                    $total_sale = ($item['total_sale'] == "") ? 0 : (int)$item['total_sale'];
                                                    $percent = 0;
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
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $fint++; endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}