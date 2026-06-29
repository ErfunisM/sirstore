<?php
/**
 * Product suggest widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_page_widget_moment ($atts, $pb = "unyson") {

    if ( !function_exists('WC') ) {
        return;
    }
    $color = "";
    if ( $pb === "unyson" ) {
        if ( $atts['color_t'] == "default" ) {
            $color = negarshop_option('main_color');
        } else {
            $color = $atts['color_t_picker'];
            $color = $color['custom'];
            $color = $color['color'];
        }
    }
    ?>
    <section class="content-widget exc-header offer-moments <?php if ( empty($atts['title']) ) {
        echo 'no-title';
    } ?>" id="content-widget-<?php echo $atts['id']; ?>">
        <?php if ( !empty($atts['title']) ) { ?>
            <header class="section-header" id="content-widget-header-<?php echo $atts['id']; ?>">
                <?php if ( !empty($atts['title']) ) { ?>
                    <h4><?php echo $atts['title']; ?></h4>
                <?php } ?>
            </header>
        <?php } ?>
        <div class="owl-carousel">

            <?php
            $slides         = [];
            $posts_pp       = $atts['items_type_picker'];
            $slide_products = $posts_pp['products'];
            $posts_pp       = (int) $slide_products['products_count'];
            $product_picker = $slide_products['products_type_picker'];
            $args           = [
                'post_type'      => 'product',
                'posts_per_page' => $posts_pp,
                'orderby'        => 'rand'
            ];
            if ( $product_picker['products_type'] == "ids" ) {
                $ids_list         = $product_picker['ids'];
                $ids_list         = $ids_list['product_ids'];
                $ids_list         = explode(',', $ids_list);
                $args['orderby']  = 'post__in';
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
            $tab_titles = [];
            if ( $product_picker['products_type'] == "idsTitled" ) {
                $ids_list   = $product_picker['idsTitled'];
                $items_list = $ids_list['items'];
                $ids_list   = [];
                foreach ( $items_list as $item ) {
                    $ids_list[]              = $item['id'];
                    $tab_titles[$item['id']] = $item['title'];
                }
                $args['orderby']  = 'post__in';
                $args['post__in'] = $ids_list;
            }
            $the_query = new WP_Query($args);
            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();

                    $pf  = new WC_Product_Factory();
                    $prd = $pf->get_product(get_the_id());


                    $slide_values = [
                        'id'           => get_the_id(),
                        'title'        => get_the_title(),
                        'tab_title'    => ($product_picker['products_type'] == "idsTitled") ? $tab_titles[get_the_id()] : get_the_title(),
                        'link'         => get_the_permalink(),
                        'photo'        => [
                            'url' => get_the_post_thumbnail_url(get_the_id(), 'medium')
                        ],
                        'reg_price'    => $prd->get_regular_price(),
                        'sale_price'   => $prd->get_sale_price(),
                        'price'        => $prd->get_price_html(),
                        'product_type' => $prd->get_type(),
                        'attributes'   => $prd->get_attributes(),
                        'children'     => $prd->get_children(),
                        'manage'       => $prd->get_manage_stock(),
                        'quantity'     => $prd->get_stock_quantity(),
                        'total_sale'   => $prd->get_total_sales(),
                        'av_rate'      => $prd->get_average_rating(),

                    ];
                    $slides[]     = $slide_values;
                }
                wp_reset_postdata();
            }

            ?>
            <?php foreach ( $slides as $item ): ?>
                <div class="om-item <?php echo $item['product_type']; ?>">
                    <figure>
                        <a href="<?php echo $item['link']; ?>" title="<?php echo $item['title']; ?>">
                            <img class="lazy" data-src="<?php echo $item['photo']['url']; ?>"
                                 alt="<?php echo $item['title']; ?>">
                        </a>
                    </figure>
                    <div class="item-footer">
                        <h3 class="title"><a
                                href="<?php echo $item['link']; ?>"><?php echo negarshop_excerpt_crop($item['tab_title'], 55); ?></a>
                        </h3>
                        <div class="price"><?php echo $item['price']; ?></div>
                    </div>
                    <div class="loader-bar"></div>


                </div>
            <?php endforeach; ?>
        </div>


        <?php if ( $pb === "unyson" ) { ?>
            <style>

                .style-2 #content-widget-header-<?php echo $atts['id']; ?>, #content-widget-header-<?php echo $atts['id']; ?> a.archive, #content-widget-<?php echo $atts['id']; ?> .more .btn-primary {
                    background-color: <?php echo $color; ?>;
                }

                #content-widget-<?php echo $atts['id']; ?> a:hover, #content-widget-<?php echo $atts['id']; ?> .owl-item .price ins, #content-widget-<?php echo $atts['id']; ?> .owl-item .price, #content-widget-<?php echo $atts['id']; ?> .owl-item .price span.amount {
                    color: <?php echo $color; ?>;
                }

            </style>
        <?php } ?>
    </section>
    <?php
}