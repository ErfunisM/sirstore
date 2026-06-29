<?php
    global $product;
?>
<div class="product-single-style-3">
    <div class="row">
        <div class="col-lg-4 mb-5 mb-xl-0 mb-lg-0 product-side-col">
            <div class="product-sidebar">
                <?php
                /**
                 * Hook: woocommerce_before_single_product_summary.
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action('woocommerce_before_single_product_summary');
                ?>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="product-section">
                <?php wc_get_template_part('single-product/custom', 'title');
                ?>
                <div class="summary entry-summary">
                    <?php
                    /**
                     * Hook: woocommerce_single_product_summary.
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_rating - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     * @hooked WC_Structured_Data::generate_product_data() - 60
                     */
                    do_action('woocommerce_single_product_summary');
                    ?>
                </div>
                <div class="product-summary-left not-sticky <?php echo negarshop_option('product_responsive_add_to_cart') === 'true' ? '' : 'inline-mode'; ?>">
                    <div class="panel-mobile-title">
                                    <span class="panel-close">
                                        <i class="far fa-angle-right"></i>
                                    </span>
                        <span class="panel-title">
                                        <?= __('خرید محصول', 'negarshop') . ' ' . $product->get_title() ?>
                                    </span>
                    </div>
                    <?php
                    /**
                     * Hook: woocommerce_single_product_summary_left.
                     *
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     */
                    do_action('woocommerce_single_product_summary_left');
                    ?>
                </div>
                <?php do_action('woocommerce_after_single_product_summary_left');
                echo '<div class="product-listed-metas">';
                negarshop_product_vendor_details();
                echo wc_get_stock_html($product);
                echo '</div>';
                ?>

                <?php wc_get_template_part('single-product/product', 'features'); ?>

                <?php
                wc_get_template_part('single-product/additional', 'products');
                wc_get_template_part('single-product/custom', 'short-description');
                ?>
                <?php
                /**
                 * Hook: woocommerce_after_single_product_summary.
                 *
                 * @hooked woocommerce_output_product_data_tabs - 10
                 * @hooked woocommerce_upsell_display - 15
                 * @hooked woocommerce_output_related_products - 20
                 */
                do_action('woocommerce_after_single_product_summary');
                ?>
            </div>
        </div>
    </div>


</div>