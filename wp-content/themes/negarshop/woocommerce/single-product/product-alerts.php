<?php
global $product;
$alerts = negarshop_option('product_alerts');
if(!empty($alerts)) {
    echo '<div class="product-alerts">';
            foreach ($alerts as $alert) {
            	$role = isset($alert['roles'])?$alert['roles']:'all';
	            if(($role === "instock" and $product->get_stock_status() === "instock") or ($role === "outofstock" and $product->get_stock_status() === "outofstock") or ($role === 'all')) {

		            if ( negarshop_option(md5($alert['title']), 'posts') === null or negarshop_option(md5($alert['title']), 'posts') === true ) {
			            echo '<div class="alert-item" style="background-color: ' . $alert['bg'] . '; color: ' . $alert['color'] . ';">';
			            if ( isset($alert['link']) and !empty($alert['link']) ) {
				            echo '<a href="' . $alert['link'] . '" style="color: ' . $alert['color'] . ';">';
			            }
			            if ( isset($alert['icon']) and !empty($alert['icon']) ) {
				            echo '<span class="icon"><i class="' . $alert['icon'] . '"></i></span>';
			            }
			            if ( isset($alert['title']) and !empty($alert['title']) ) {
				            echo '<span class="title">' . $alert['title'] . '</span>';
			            }
			            if ( isset($alert['desc']) and !empty($alert['desc']) ) {
				            echo '<span class="desc">' . $alert['desc'] . '</span>';
			            }
			            if ( isset($alert['link']) and !empty($alert['link']) ) {
				            echo '</a>';
			            }
			            echo '</div>';
		            }
	            }
            }
    echo '</div>';
}