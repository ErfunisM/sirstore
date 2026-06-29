<?php


$my_orders_columns = apply_filters('woocommerce_my_account_my_orders_columns', [
	'order-number'  => __('Order', 'woocommerce'),
	'order-date'    => __('Date', 'woocommerce'),
	'order-status'  => __('Status', 'woocommerce'),
	'order-total'   => __('Total', 'woocommerce'),
	'order-actions' => '&nbsp;',
]);

$customer_orders = get_posts(apply_filters('woocommerce_my_account_my_orders_query', [
	'numberposts' => 3,
	'meta_key'    => '_customer_user',
	'meta_value'  => get_current_user_id(),
	'post_type'   => wc_get_order_types('view-orders'),
	'post_status' => array_keys(wc_get_order_statuses()),
]));

if ( $customer_orders ) : ?>

    <div class="latest-orders-status">
        <h4 class="section-title"><i class="far fa-clock"></i> <?= __('آخرین سفارش های شما', 'negarshop') ?></h4>

		<?php
		foreach ( $customer_orders as $customer_order ) :
			$order = wc_get_order($customer_order);
			$deliveryTime = $order->get_meta('ns_delivery_time');
		    $progressWidth = 0;

		    if(is_array($deliveryTime) && isset($deliveryTime['date']) && $order->get_status() !== 'completed'){
		        $orderDate = $order->get_date_created()->getTimestamp();
		        $deliveryDate = $deliveryTime['date'];
			    $progressWidth = (1 - (($deliveryDate - time()) / ($deliveryDate - $orderDate))) * 100;
            }



			if($progressWidth > 100 || $order->get_status() === "completed"){
				$progressWidth = 100;
			}
			?>
            <div class="row order-item">
                <div class="col-lg col-order-id">
                    <ul class="order-details">
                        <li>
                            کد سفارش:
                            <strong><a href="<?php echo esc_url( $order->get_view_order_url() ); ?>">#<?= $order->get_order_number() ?></a></strong>
                        </li>
                        <li>
                            وضعیت:
                            <strong><?= wc_get_order_status_name($order->get_status()) ?></strong>
                        </li>
                        <li>
                            تاریخ:
                            <strong><?= wc_format_datetime($order->get_date_created()) ?></strong>
                        </li>
                    </ul>
                </div>
				<?php
				$deliveryTime = negarshop_format_delivery($order->get_meta('ns_delivery_time'));

					?>
                    <div class="col-lg-auto col-order-date">
                        <ul class="order-details">
                            <li>
                                تاریخ تحویل:
                                <strong>
									<?= $deliveryTime === false ? 'بدون تاریخ' : $deliveryTime ?>
                                </strong>
                            </li>
                        </ul>
                    </div>
				<?php if ( $deliveryTime !== false ) { ?>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-success progress-bar-animated" role="progressbar" aria-valuenow="<?= $progressWidth ?>" aria-valuemin="0"
                             aria-valuemax="100" style="width: <?= $progressWidth ?>%"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
		<?php endforeach; ?>
    </div>
<?php endif;
