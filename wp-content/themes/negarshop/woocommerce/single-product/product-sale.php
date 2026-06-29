<?php
global $product;
$sale_time = $product->get_date_on_sale_to();
$sale_start_time = $product->get_date_on_sale_from();
$reg_price = (int)$product->get_regular_price();
$sale_price = (int)$product->get_sale_price();
$end_time = 0;
if($product->get_type() == "variable"){

    $vr_product_dates = negarshop_get_variable_product_values($product->get_children(), "dates");
    if ($vr_product_dates !== false) {
        $end_time = $vr_product_dates['end_time'];
        $sale_start_time = $vr_product_dates['start_time'];
        $end_time = $end_time->getTimestamp();
    }

    $vr_product_prices = negarshop_get_variable_product_values($product->get_children(), "prices");
    if ($vr_product_dates !== false) {
        $reg_price = (int) $vr_product_prices['regu_price'];
        $sale_price = (int) $vr_product_prices['sale_price'];
    }



}
if((!empty($sale_time) and $sale_time !== null) or $end_time>0){
    $sale_time = new WC_DateTime($sale_time);
    $sale_time = $sale_time->getTimestamp();
    if($product->get_type() == "variable"){
        $sale_time = $end_time;
    }
    ?>
    <div class="<?php echo (negarshop_option('product_single_type') === 'type-3') ? 'inline-sale-timer-box' : 'sale-timer-box mb-5' ?>">
        <div class="title-sec">
            <h5 class="title">
                <?php _e('فروش فوق العاده','negarshop'); ?>
            </h5>
            <?php if (negarshop_option('product_single_type') !== 'type-3') { ?>
            <h6 class="sub-title"><?php _e('زمان باقی مانده :','negarshop'); ?></h6>
            <?php } ?>

        </div>
        <div class="counter-sec">
            <?php 
            if($sale_start_time !== null && $sale_start_time->getTimestamp() > time()){
                _e('هنوز شروع نشده است!','negarshop');
            }else if($sale_time>time()){?>
                <div class="negarshop-countdown <?php echo (negarshop_option('product_single_type') === 'type-3') ? 'no-style' : '' ?>" data-date="<?php echo date('Y/m/d 23:59:59',$sale_time); ?>"></div>
            <?php }else{ _e('اتمام فروش ویژه!','negarshop');} ?>
        </div>
    </div>
<?php } ?>