<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if ( !defined('ABSPATH') ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters('woocommerce_product_tabs', []);

if ( !empty($tabs) ) : ?>
    <div class="woocommerce-tabs wc-tabs-wrapper">
        <div class="product-tabs-outer sticky">
            <ul class="wc-tabs wc-tabs-<?= negarshop_option('product_tab_styles') ?>" role="tablist">
				<?php foreach ( $tabs as $key => $tab ) : ?>
                <li class="<?php echo esc_attr($key); ?>_tab" id="tab-title-<?php echo esc_attr($key); ?>"
                    role="tab"
                    aria-controls="tab-<?php echo esc_attr($key); ?>">
                    <a href="#tab-<?php echo esc_attr($key); ?>">
						<?php switch ( $key ) {
							case "description":
								echo '<i class="fas fa-pen-square"></i>';
								break;
							case "cb_rates":
								echo '<i class="fas fa-list-alt"></i>';
								break;
							case "additional_information":
								echo '<i class="fas fa-clipboard"></i>';
								break;
							case "reviews":
								echo '<i class="fas fa-comment-alt-lines"></i>';
								break;
							case "ns_questions":
								echo '<i class="fas fa-comments"></i>';
								break;
							case "seller":
								echo '<i class="fas fa-shopping-bag"></i>';
								break;
							case "more_seller_product":
								echo '<i class="fas fa-ellipsis-v"></i>';
								break;
							case "shipping":
								echo '<i class="fas fa-car"></i>';
								break;
							default:
								break;
						} ?>
						<?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key); ?></a>
                    </li><?php endforeach; ?>
            </ul>
        </div>
		<?php foreach ( $tabs as $key => $tab ) : ?>
            <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab"
                 id="tab-<?php echo esc_attr($key); ?>" role="tabpanel"
                 aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                <div class="panel-mobile-title">
                    <span class="panel-close">
                        <i class="far fa-angle-right"></i>
                    </span>
                    <span class="panel-title">
                        <?= $tab['title'] ?>
                    </span>
                </div>

				<?php if ( isset($tab['callback']) ) {
					call_user_func($tab['callback'], $key, $tab);
				} ?>
            </div>
		<?php endforeach; ?>

		<?php do_action('woocommerce_product_after_tabs'); ?>
    </div>

<?php endif; ?>
