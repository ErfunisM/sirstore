<?php
if (negarshop_option('pa_ac', 'posts', get_the_ID()) !== "true") {
    return;
}
$pa_picker = negarshop_option('pa_ac_picker', 'posts', get_the_ID());
$pa_picker = $pa_picker['true'];
$post_id = $pa_picker['pa_product'][0] ?? false;
$product_items = [];
if (get_post_type($post_id) === 'product') {
    $pf = new WC_Product_Factory();
    $prd = $pf->get_product($post_id);
    if ($prd->get_type() === "grouped") {
        $product_items = $prd->get_children();
    }
}
if (empty($product_items)) {
    return;
}
?>
    <div class="product-section product-additional-items">
        <?php if (!empty($pa_picker['pa_title'])) { ?>
            <h5 class="pa-title mb-4"><?php echo esc_html($pa_picker['pa_title']); ?></h5>
        <?php } ?>
        <div class="row">
            <?php
            $slides = [];
            $args = [
                'post_type' => 'product',
                'posts_per_page' => -1,
                'post__in' => $product_items,
                'orderby' => 'post__in',
            ];
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
            if (negarshop_option('product_single_type') === 'type-3') {
                echo '<div class="col-12">';
            }else{
            ?>
            <div class="col-lg-6 mb-4">
                <section class="content-widget products-carousel style-2">
                    <div class="carousel-content">
                        <div class="owl-carousel" data-car-count="2">
                            <?php
                            foreach ($slides as $slide) {
                                negarshop_carousel_item($slide);
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-6 mb-4">
                <?php } ?>
                <div class="additional-factor">
                    <div class="loading">
                        <div class="spinner"></div>
                    </div>
                    <div class="af-inner">
                        <form action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data">

                            <input type="hidden" name="add-to-cart" value="<?php echo $post_id; ?>">
                            <div class="af-items">
                                <h6 class="af-title">محصولات</h6>
                                <?php
                                $int_i = 1;
                                /**
                                 * @var WC_Product[] $slides
                                 */
                                foreach ($slides as $slide) {
                                    ?>
                                    <div class="af-item ns-checkbox">
                                        <input id="pa-item-<?php echo $int_i; ?>"
                                               data-price="<?php echo $slide->get_price(); ?>"
                                               data-id="<?php echo $slide->get_id(); ?>" value="1"
                                               name="quantity[<?php echo $slide->get_id(); ?>]" type="checkbox" checked>
                                        <label for="pa-item-<?php echo $int_i; ?>"><?php echo $slide->get_title(); ?></label>
                                        <div class="price"><?php echo $slide->get_price(); ?></div>
                                    </div>
                                    <?php
                                    $int_i++;
                                }
                                ?>
                            </div>
                            <div class="af-total row">
                                <?php
                                $total_price = 0;
                                $def_json = [];
                                foreach ($slides as $slide) {
                                    $total_price += (int) $slide->get_price();
                                    $def_json[] = $slide->get_id();
                                }
                                $def_json = json_encode($def_json);
                                ?>
                                <div class="af-total-price col">
                                    <h6 class="total-price-title"><?php _e("تعداد کل:", 'negarshop'); ?></h6>
                                    <span class="total-count"><b><?php echo count($slides); ?></b> محصول</span>
                                </div>
                                <div class="af-total-price col">
                                    <h6 class="total-price-title"><?php _e("جمع کل:", 'negarshop'); ?></h6>
                                    <div class="price"><?php echo wc_price($total_price); ?></div>
                                </div>
                            </div>
                            <div class="af-add-to-cart">
                                <button class="btn btn-primary"
                                        type="submit"><?php _e("افزودن به سبد خرید", 'negarshop'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php wp_reset_postdata();