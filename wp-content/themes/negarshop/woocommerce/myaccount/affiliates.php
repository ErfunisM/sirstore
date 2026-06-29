<?php
if (!function_exists('yith_wcaf_get_dashboard_navigation_menu')) return;
$tabs = yith_wcaf_get_dashboard_navigation_menu();
echo '<div class="ns-store-header">';
echo '<ul class="nav nav-pills">';
$current_tab = isset($_GET['tab'])?$_GET['tab']:'';
foreach ($tabs as $slug => $tab){
	echo '<li class="nav-item">';
	$icon = "";
	switch ($slug){
		case "commissions":
			$icon = '<i class="far fa-shopping-cart"></i>';
			break;
		case "clicks":
			$icon = '<i class="far fa-mouse-pointer"></i>';
			break;
		case "payments":
			$icon = '<i class="far fa-credit-card-blank"></i>';
			break;
		case "generate-link":
			$icon = '<i class="far fa-link"></i>';
			break;
		case "settings":
			$icon = '<i class="far fa-cog"></i>';
			break;
		default:
			$icon = "";
			break;
    }
	echo '<a class="nav-link'.($current_tab===$slug?' active':'').'" href="'.add_query_arg( 'tab', $slug, wc_get_account_endpoint_url('affiliates') ).'">'.$icon.' '.$tab['label'].'</a>';
	echo '</li>';

}
global $wp;
$wp->query_vars[$current_tab] = true;
echo '</ul>';
echo '<div class="tab-content mt-5 ns-affiliate">';
echo str_replace(['shop_table','name="per_page"'],['shop_table ns-table','name="per_page" class="form-control"'],do_shortcode('[yith_wcaf_affiliate_dashboard]'));
echo '</div>';
echo '</div>';