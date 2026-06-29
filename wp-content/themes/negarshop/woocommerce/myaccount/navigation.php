<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
$current_user = wp_get_current_user();
?>

<nav class="woocommerce-MyAccount-navigation">

    <section class="widget ns-store-avatar wc-dashboard">
        <header class="store-avatar-header">
            <div class="profile-img">
                <?php echo get_avatar($current_user->user_email,150); ?>
            </div>
        </header>
        <footer class="store-avatar-footer">
            <?php if ( ! empty( $current_user->display_name) ) { ?>
                <h1 class="store-name"><?php echo esc_html( $current_user->display_name ); ?></h1>
            <?php } ?>
            <div class="reg-date"><?php
                $founds = '[get-account-funds]';
                if($founds == do_shortcode($founds)) {
                    echo __('عضویت از ', 'negarshop') . human_time_diff(strtotime($current_user->user_registered)) . __(" پیش", 'negarshop');
                }else{
                    echo do_shortcode($founds);
                }
                ?></div>
           <div class="user-actions">
               <a href="<?php echo wp_logout_url(wc_get_page_permalink('myaccount')); ?>" class="logout"><i class="far fa-sign-out"></i><?php _e(' خروج از حساب','negarshop'); ?></a>
           </div>
        </footer>
    </section>
	<ul class="woocommerce-account-navs">
        <li class="res-toggle-menu">
            <a href="#toggle-menu">
                <span class="show"><i class="far fa-bars"></i>
                دیدن منو</span>
                <span class="hide"><i class="far fa-times"></i>
                بستن منو</span>
            </a>
        </li>
		<?php
        $menu_items = [];
        $tmp_menu_items = wc_get_account_menu_items();
        foreach ($tmp_menu_items as $key => $val){
            $active = negarshop_option("account_tab_".$key);
            $name   = negarshop_option("account_tab_".$key."_name");

            if(!$active){
                unset($tmp_menu_items[$key]);
            }else if($name !== null and !empty($name)){
                $tmp_menu_items[$key] = $name;
            }

        }
        $menu_items = $tmp_menu_items;
        foreach ($menu_items  as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
                <?php
                    $url = esc_url( wc_get_account_endpoint_url( $endpoint ));
                ?>
				<a href="<?php echo $url; ?>">
                    <?php
                    switch ($endpoint){
                        case "dashboard":
                            echo '<i class="fal fa-user"></i>';
                            break;
                        case "orders":
                            echo '<i class="fal fa-shopping-cart"></i>';
                            break;
                        case "downloads":
                            echo '<i class="fal fa-download"></i>';
                            break;
                        case "edit-address":
                            echo '<i class="fal fa-location"></i>';
                            break;
                        case "cb_favs":
                            echo '<i class="fal fa-heart"></i>';
                            break;
                        case "edit-account":
                            echo '<i class="fal fa-id-card"></i>';
                            break;
                        case "customer-logout":
                            echo '<i class="fal fa-power-off"></i>';
                            break;
                        case "rma-requests":
                            echo '<i class="fal fa-undo"></i>';
                            break;
                        case "following":
                            echo '<i class="fal fa-users"></i>';
                            break;
                        case "support-tickets":
                            echo '<i class="fal fa-envelope-open"></i>';
                            break;
                        case "wc-smart-coupons":
                            echo '<i class="fal fa-ticket-alt"></i>';
                            break;
                        case "favorites":
                            echo '<i class="fal fa-heart"></i>';
                            break;
                        case "affiliates":
                            echo '<i class="fal fa-money-check"></i>';
                            break;
                        case "account-funds":
                            echo '<i class="fal fa-credit-card"></i>';
                            $label = __('کیف پول','negarshop');
                            break;
                        default:
                            break;
                    }
                    echo esc_html( $label ); ?></a>
			</li>
		<?php endforeach;

        $store_user = null;
		if (function_exists('dokan')) {
            $store_user = dokan()->vendor->get($current_user->ID);
            $seller_pages = get_option('dokan_pages');
            $is_vendor = (!empty($store_user) and ($store_user->data->roles[0] == "administrator" or $store_user->data->roles[0] == "seller")) ? true : false;
            if ($is_vendor and !empty($seller_pages)) {
		?>

        <li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--vendors">
            <a href="<?php echo get_the_permalink($seller_pages['dashboard']); ?>">
                <i class="fal fa-store"></i><?php _e('پنل فروشندگان', 'negarshop'); ?></a>
        </li>
        <?php
            }
		}
		?>
	</ul>
</nav>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>
