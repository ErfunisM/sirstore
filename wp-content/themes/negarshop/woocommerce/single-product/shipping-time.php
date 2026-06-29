<?php
if ( negarshop_option('product_shipping_time') !== 'true' ) {
	return;
}
global $product_id;

$productShipping = negarshop_option('product_shipping_time', 'posts', $product_id);

if ( $productShipping === null ) {
	$productShipping = 0;
}
?>
<div class="product-shipping-time">
    <i class="far fa-clock"></i>
    <div class="shiping-title">
        <b>
			<?= (int) $productShipping > 0 ? 'ارسال از ' . $productShipping . ' روز کاری' : __('آماده ارسال', 'negarshop') ?>
        </b>
		<?php if ( (int) $productShipping > 0 && !is_cart() ) { ?>
            <p><?php _e('زمان آماده سازی و ارسال محصول', 'negarshop'); ?></p>
		<?php } ?>
    </div>
</div>