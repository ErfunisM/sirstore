<div class="product-section single-style-2-gallery">
	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action('woocommerce_before_single_product_summary');
	wc_get_template_part('single-product/product', 'sale');
	?>
</div>
<div class="product-section single-style-2">
    <div class="row">
		<?php if ( negarshop_option('product_tools_ac') == "true" ) { ?>
            <div class="col-12">
				<?php
				wc_get_template_part('single-product/product', 'actions');
				?>
            </div>
		<?php } ?>
        <div class="col-lg">
			<?php wc_get_template_part('single-product/custom', 'title');
			wc_get_template_part('single-product/product', 'sale');
			?>
            <div class="row">
                <div class="col-lg">
                    <div class="row">
                        <div class="col-lg mb-3">
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
                        </div>
                        <div class="col-lg<?php global $product;
						echo $product->get_type() == "grouped" ? "-12" : "-4"; ?>">
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
							<?php do_action('woocommerce_after_single_product_summary_left'); ?>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        <div class="col-12">
			<?php wc_get_template_part('single-product/product', 'features'); ?>
        </div>
    </div>
</div>


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