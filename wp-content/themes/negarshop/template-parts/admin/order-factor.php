<?php
/**
 * Admin order factor page
 *
 * @var WC_Order $order current order item.
 */

$previous_id = get_previous_post_id($order->get_id());
$next_id = get_next_post_id($order->get_id());
$factor_type = esc_attr($_GET['type'] ?? '');

$factor_types = [
    'customer' => 'فاکتور فروش',
    'post' => 'برچسب پستی',
];

if (empty($factor_type)) {
    $factor_type = array_key_first($factor_types);
}
$orderUser = $order->get_user();

$factor_firstname = $order->get_shipping_first_name();
$factor_lastname = $order->get_shipping_last_name();
$factor_address1 = $order->get_shipping_address_1();
$factor_postcode = $order->get_shipping_postcode();
$factor_phone = $order->get_shipping_phone();
$factor_state = $order->get_shipping_state();
$factor_city = $order->get_shipping_city();

if (empty($factor_firstname)) {
    $factor_firstname = $order->get_billing_first_name();
}
if (empty($factor_lastname)) {
    $factor_lastname = $order->get_billing_last_name();
}
if (empty($factor_address1)) {
    $factor_address1 = $order->get_billing_address_1();
}
if (empty($factor_postcode)) {
    $factor_postcode = $order->get_billing_postcode();
}
if (empty($factor_phone)) {
    $factor_phone = $order->get_billing_phone();
}
if (empty($factor_state)) {
    $factor_state = $order->get_billing_state();
}
if (empty($factor_city)) {
    $factor_city = $order->get_billing_city();
}
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>فاکتور سفارش <?php echo $order->get_id(); ?> سایت <?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/statics/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/statics/fonts/vazir/vazir.css'; ?>">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/statics/css/admin-factor.css'; ?>">
</head>
<body>
<div class="wrapper py-5">
    <div class="container">
        <div class="factor-page">
            <div class="page-header hide-in-print">
                <div class="row align-items-center mb-5 border-bottom pb-3">
                    <div class="col-auto">
                        <?php if (false !== $previous_id): ?>
                            <a class="btn btn-secondary update-link" href="<?php echo add_query_arg([
                                'action' => 'factor',
                                'post' => $previous_id,
                                'type' => $factor_type
                            ], admin_url('post.php')); ?>">
                                <b>سفارش قبلی</b><br>
                                <span>سفارش <?php echo $previous_id; ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="col text-center">
                        <h1 class="mb-0">سفارش <?php echo $order->get_id(); ?></h1>
                    </div>
                    <div class="col-auto">
                        <?php if (false !== $next_id): ?>
                            <a class="btn btn-secondary update-link" href="<?php echo add_query_arg([
                                'action' => 'factor',
                                'post' => $next_id,
                                'type' => $factor_type
                            ], admin_url('post.php')); ?>">
                                <b>سفارش بعدی</b><br>
                                <span>سفارش <?php echo $next_id; ?></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <form class="mb-0">
                    <div class="row align-items-end mb-5 border-bottom pb-3">
                        <div class="col my-1">
                            <input type="hidden" name="action" value="factor">
                            <input type="hidden" name="post" value="<?php echo $order->get_id(); ?>">
                            <label class="mr-sm-2" for="factor-type">نوع فاکتور</label>
                            <select class="custom-select mr-sm-2" id="factor-type" name="type">
                                <?php
                                foreach ($factor_types as $type => $label) {
                                    printf('<option value="%s" %s>%s</option>', $type, selected($type, $factor_type, false), $label);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-auto my-1">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="checkbox" class="custom-control-input" name="grayscale"
                                       id="grayscale" <?php checked(isset($_GET['grayscale'])); ?>>
                                <label class="custom-control-label" for="grayscale">سیاه و سفید</label>
                            </div>
                        </div>
                        <div class="col-auto my-1">
                            <button type="button" class="btn btn-primary" id="print-selected">پرینت</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="print-area">
                <?php if ("post" === $factor_type): ?>
                    <div class="print-object factor-post" data-type="post">
                        <div class="factor-header mb-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    شماره فاکتور: <b><?php echo $order->get_id(); ?></b>
                                </div>
                                <div class="col text-left">
                                    <?php if ('true' === negarshop_option('factor_barcode')) : ?>
                                        <p>
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo esc_attr($order->get_id()); ?>"
                                                 alt="" class="qr-code"></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <table class="information-table table table-bordered mb-0">
                            <thead class="thead-light">
                            <tr class="text-center">
                                <th style="width: 50%">گیرنده</th>
                                <th style="width: 50%">فرستنده</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td>
                                    <b>فرستنده:</b>
                                    <span><?php echo negarshop_option('factor_post_sender'); ?></span><br>
                                    <b>نشانی:</b>
                                    <span><?php echo negarshop_option('factor_post_address'); ?></span><br>
                                    <b>کد پستی:</b>
                                    <span><?php echo negarshop_option('factor_post_pcode'); ?></span><br>
                                    <b>تلفن:</b> <span><?php echo negarshop_option('factor_post_mobile'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>گیرنده:</b>
                                    <span><?php echo $factor_firstname . ' ' . $factor_lastname; ?></span><br>
                                    <b>نشانی:</b>
                                    <span><?php echo $factor_address1; ?></span><br>
                                    <b>کد پستی:</b>
                                    <span><?php echo $factor_postcode; ?></span><br>
                                    <b>شماره تماس:</b>
                                    <span><?php echo $factor_phone; ?></span>
                                </td>
                                <th></th>
                            </tr>
                            </tbody>
                        </table>
                        <div class="divider"></div>
                    </div>
                <?php endif; ?>
                <?php if ("customer" === $factor_type): ?>
                    <div class="print-object factor-customer" data-type="customer">
                        <div class="factor-header mb-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <?php
                                    $logo = negarshop_option('factor_logo');
                                    ?>
                                    <img
                                         src="<?php echo esc_url($logo['url']); ?>"
                                         class="header-logo mb-4">
                                    <p class="mb-0 header-title"><?php echo negarshop_option('factor_header_label') ?></p>
                                </div>
                                <div class="col-auto text-left">
                                    <?php if ('true' === negarshop_option('factor_barcode')) : ?>
                                        <p>
                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?php echo esc_attr($order->get_id()); ?>"
                                                 alt="" class="qr-code"></p>
                                    <?php endif; ?>
                                    <p class="mb-0">
                                        شماره فاکتور: <b><?php echo $order->get_id(); ?></b>
                                        &nbsp;
                                        /
                                        &nbsp;
                                        تاریخ:
                                        <b><?php echo ns_jdate('Y/m/d', $order->get_date_created()->getTimestamp()); ?></b>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <table class="information-table table table-bordered">
                            <thead class="thead-light">
                            <tr>
                                <th style="width: 50%">فروشنده</th>
                                <th style="width: 50%">خریدار</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <b>فروشنده: </b> <?php bloginfo('name'); ?> &nbsp;&nbsp;&nbsp;
                                    <b>استان: </b> <span><?php echo negarshop_state_to_label(WC()->countries->get_base_state()); ?></span>&nbsp;&nbsp;
                                    <b>شهر: </b> <span><?php echo WC()->countries->get_base_city(); ?></span>&nbsp;&nbsp;
                                    <b>کد پستی: </b>
                                    <span><?php echo WC()->countries->get_base_postcode(); ?></span>&nbsp;&nbsp;
                                    <b>شماره تماس: </b>
                                    <span><?php echo negarshop_option('factor_mobile_number'); ?></span><br>
                                    <b>آدرس: </b> <span><?php echo WC()->countries->get_base_address(); ?></span>
                                </td>
                                <td>
                                    <b>خریدار: </b> <?php echo $factor_firstname . ' ' . $factor_lastname; ?>
                                    &nbsp;&nbsp;&nbsp;
                                    <b>استان: </b> <span><?php echo negarshop_state_to_label($factor_state); ?></span>&nbsp;&nbsp;
                                    <b>شهر: </b> <span><?php echo $factor_city; ?></span>&nbsp;&nbsp;
                                    <b>کد پستی: </b> <span><?php echo $factor_postcode; ?></span>&nbsp;&nbsp;
                                    <b>شماره تماس: </b> <span><?php echo $factor_phone; ?></span><br>
                                    <b>آدرس: </b> <span><?php echo $factor_address1; ?></span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <table class="information-table table table-bordered">
                            <thead class="thead-light">
                            <tr class="text-center">
                                <th>ردیف</th>
                                <th style="width: 100px">کد کالا</th>
                                <th class="text-right">شرح کالا یا خدمات</th>
                                <th>تعداد</th>
                                <th>مبلغ واحد</th>
                                <th>مبلغ کل</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $index = 0;
                            foreach ($order->get_items() as $order_item):
                                $order_item_data = $order_item->get_data();
                                ?>
                                <tr class="text-center">
                                    <td><?php echo ++$index; ?></td>
                                    <td><?php echo $order_item->get_id(); ?></td>
                                    <td class="text-right"><?php echo $order_item->get_name(); ?></td>
                                    <td><?php echo $order_item->get_quantity(); ?></td>
                                    <td><?php echo wc_price($order->get_item_subtotal($order_item, false, true)); ?></td>
                                    <td><?php echo wc_price($order_item_data['total'] ?? 0); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot class="thead-light">
                            <tr class="text-center">
                                <th colspan="3" class="bg-white">هزینه حمل و نقل:</th>
                                <th colspan="3"
                                    class="bg-white"><?php echo wc_price($order->get_shipping_total()); ?></th>
                            </tr>
                            <tr class="text-center">
                                <th colspan="3">جمع کل:</th>
                                <th colspan="3"><?php echo wc_price($order->get_total()); ?></th>
                            </tr>
                            <tr class="text-center">
                                <th colspan="3" class="bg-white">روش پرداخت:</th>
                                <th colspan="3"
                                    class="bg-white"><?php echo $order->get_payment_method_title(); ?></th>
                            </tr>
                            </tfoot>
                        </table>
                        <p class="mb-0 mt-3 text-center"><?php echo negarshop_option('factor_footer_label'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo get_template_directory_uri() . '/statics/js/jquery-3.2.1.min.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/statics/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo get_template_directory_uri() . '/statics/js/admin-factor.js'; ?>"></script>
</body>
</html>
