<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/old__content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

/**
 * @var WC_Product $productItem
 * @var array $options
 * @var bool $grid
 */

if (!isset($productItem)) {
    global $product;
    $productItem = $product;
}
if (!isset($grid)) {
    $grid = false;
}
if (!isset($options)) {
    $options = [];
}
if (empty($productItem) || !$productItem->is_visible()) {
    return;
}
$cardOptions = [
    'wrap_title' => negarshop_option('items_title'),
    'price' => negarshop_option('items_price'),
    'one_price' => negarshop_option('one_price'),
    'ribbon' => negarshop_option('item_ribbs'),
    'brand' => negarshop_option('item_brand'),
    'item_colors' => negarshop_option('item_colors'),
    'card_type' => 'vertical',
    'items_vars' => 'false',
    'image_size' => 'woocommerce_thumbnail',
    'image_dimensions' => negarshop_option('items_thumbnail_size'),
    'items_timer' => 'false',
    'rate' => negarshop_option('item_rate'),
    'items_add_to_cart' => 'simple',
    'bottom_actions_style' => negarshop_option('card_bottom_actions_style'),
    'bottom_actions' => [
        'cart' => true,
        'view' => true,
        'compare' => true,
        'like' => true,
    ],
    'top_actions_style' => negarshop_option('card_top_actions_style'),
    'top_actions' => [
        'cart' => false,
        'view' => false,
        'compare' => false,
        'like' => false,
    ],
];
$cardOptions = array_merge($cardOptions, $options);

if ($cardOptions['image_dimensions'] !== '1x1') {
    $cardOptions['image_size'] = 'medium_large';
}

$cardData = [
    'id' => $productItem->get_id(),
    'title' => $productItem->get_title(),
    'link' => $productItem->get_permalink(),
    'photo' => $productItem->get_image($cardOptions['image_size']),
    'price' => $productItem->get_price_html(),
    'product_type' => $productItem->get_type(),
    'image_background' => negarshop_option('image_background', 'posts', $productItem->get_id())
];

$topActionArgs = [
    'cart' => false,
    'view' => false,
    'compare' => false,
    'like' => false,
    'cart_type' => $cardOptions['items_add_to_cart']
];
$topActionArgs = array_merge($topActionArgs, $cardOptions['top_actions']);
if ($cardOptions['top_actions_style'] === 'false' || (!$topActionArgs['cart'] && !$topActionArgs['view'] && !$topActionArgs['compare'] && !$topActionArgs['like'])) {
    $topActionArgs = false;
}

$bottomActionArgs = [
    'like' => negarshop_option('product_action_like'),
    'compare' => negarshop_option('product_action_compare'),
    'view' => negarshop_option('product_action_more'),
    'cart' => negarshop_option('product_action_addtocart'),
    'cart_type' => $cardOptions['items_add_to_cart'],
    'cart_text' => '<i class="far fa-shopping-cart"></i>'
];

$bottomActionArgs = array_merge($bottomActionArgs, $cardOptions['bottom_actions']);
if ($cardOptions['bottom_actions_style'] === 'false' || (!$bottomActionArgs['cart'] && !$bottomActionArgs['view'] && !$bottomActionArgs['compare'] && !$bottomActionArgs['like'])) {
    $bottomActionArgs = false;
}
if ($cardOptions['bottom_actions_style'] === 'bold-actions') {
    $bottomActionArgs['cart_text'] .= ' ' . __('خرید محصول', 'negarshop');
}

echo ($grid !== false) ? '<div class="col-lg-' . $grid . ' col-md-6 grid-item">' : '';

$productClass = 'product-card';
if ($cardOptions['bottom_actions_style'] !== 'false') {
    $productClass .= ' product-card--' . $cardOptions['bottom_actions_style'];
}
$productClass .= ' product-type-' . $productItem->get_type();
$productClass .= ' product-mode--' . $cardOptions['card_type'];

if ('true' === negarshop_option('sale_price_responsive')) {
    $productClass .= ' product-responsive-full-price';
}

$cardStyles = [];

if (!empty($cardData['image_background'])) {
    $cardStyles[] = sprintf('background-color:%s;', esc_attr($cardData['image_background']));
    $cardStyles[] = 'background-image: none;';
}

$cardOptions['image_dimensions'] = negarshop_woocommerce_image_height_builder($cardOptions['image_dimensions']);
$cardStyles[] = sprintf('padding-top: %s;', esc_attr($cardOptions['image_dimensions']));
?>
    <article <?php wc_product_class($productClass); ?>>
        <div class="product-card-thumbnail">
            <figure class="thumbnail" style="<?php echo esc_attr(implode(' ', $cardStyles)); ?>">
                <a href="<?php echo $cardData['link']; ?>">
                    <?php
                    echo $cardData['photo'];
                    negarshop_woocommerce_template_loop_product_second_thumbnail($cardData['id'], $cardOptions['image_size']);
                    if ($cardOptions['ribbon'] !== "false") {
                        negarshop_print_ribbons($cardData['id']);
                    } ?>

                </a>
                <?php
                $topAction = negarshop_product_actions($cardData['id'], $topActionArgs);
                if ($topAction):
                    ?>
                    <div class="header-actions">
                        <?php
                        echo $topAction;
                        ?>
                    </div>
                <?php endif; ?>
            </figure>

            <?php if ($cardOptions['item_colors'] === "true") { ?>
                <div class="product-variable-color">
                    <?php echo negarshop_print_colored_dots($productItem); ?>
                </div>
            <?php } ?>
        </div>
        <div class="product-card-content">
            <?php if ($cardOptions['items_add_to_cart'] === "advanced" && $productItem->get_stock_status() !== 'outofstock' && in_array($productItem->get_type(),
                    ['variable', 'simple'])) {
                ?>
                <div class="card-add-to-cart">
                    <?php
                    if ($productItem->get_type() === "variable") {
                        // Enqueue variation scripts.
                        wp_enqueue_script('wc-add-to-cart-variation');

                        // Get Available variations?
                        $get_variations = count($productItem->get_children()) <= apply_filters('woocommerce_ajax_variation_threshold',
                                30, $productItem);

                        // Load the template.
                        wc_get_template('single-product/add-to-cart/variable.php', [
                            'product' => $productItem,
                            'available_variations' => $get_variations ? $productItem->get_available_variations() : false,
                            'attributes' => $productItem->get_variation_attributes(),
                            'selected_attributes' => $productItem->get_default_attributes(),
                        ]);
                    } else {
                        wc_get_template('single-product/add-to-cart/simple.php', [
                            'product' => $productItem
                        ]);
                    }
                    ?>
                    <button class="close"><i class="far fa-times"></i> بستن</button>
                </div>
            <?php } ?>
            <div class="card-footer">
                <?php if ($cardOptions['brand'] === 'true') {
                    $brand = get_the_terms($productItem->get_id(), 'product_brand');

                    if (!empty($brand) && !is_wp_error($brand)) {
                        printf('<div class="card-title card-brand"><a href="%s">%s</a></div>', esc_attr(get_term_link($brand[0])), esc_html($brand[0]->name));
                    }
                }
                ?>
                <a href="<?php echo $cardData['link']; ?>">
                    <h3 class="card-title <?php echo $cardOptions['wrap_title'] === "true" ? 'wrap' : ''; ?>">
                        <?php echo $cardData['title']; ?>
                    </h3>
                </a>

                <?php if ($cardOptions['rate'] !== "false") { ?>
                    <div class="card-rate">
                        <div class="rate"><?php echo negarshop_get_rating_html($productItem->get_average_rating()); ?></div>
                    </div>
                <?php } ?>

                <?php if ($cardOptions['items_timer'] === "true"): ?>
                    <?php

                    $sale_time = $productItem->get_date_on_sale_to();
                    $reg_price = (int)$productItem->get_regular_price();
                    $sale_price = (int)$productItem->get_sale_price();
                    $end_time = 0;
                    if ($productItem->get_type() == "variable") {

                        $vr_product_dates = negarshop_get_variable_product_values($productItem->get_children(), "dates");
                        if ($vr_product_dates !== false) {
                            $end_time = $vr_product_dates['end_time'];
                            $end_time = $end_time->getTimestamp();
                        }

                        $vr_product_prices = negarshop_get_variable_product_values($productItem->get_children(), "prices");
                        if ($vr_product_dates !== false) {
                            $reg_price = (int)$vr_product_prices['regu_price'];
                            $sale_price = (int)$vr_product_prices['sale_price'];
                        }


                    }
                    if ((!empty($sale_time) and $sale_time !== null) or $end_time > 0) {
                        $sale_time = new WC_DateTime($sale_time);
                        $sale_time = $sale_time->getTimestamp();
                        if ($productItem->get_type() == "variable") {
                            $sale_time = $end_time;
                        }
                        ?>
                        <?php if ($sale_time > time()) { ?>
                            <div class="card-timer">
                                <div class="negarshop-countdown"
                                     data-date="<?php echo date('Y/m/d 23:59:59', $sale_time); ?>"></div>
                            </div>
                        <?php }
                    }
                endif; ?>

                <?php if ($cardOptions['items_vars'] !== "false") { ?>
                    <div class="product-variables">
                        <ul class="product-bold-attributes ln-<?php echo $cardOptions['items_vars']; ?>"
                            style="height: <?php echo $cardOptions['items_vars'] * 26; ?>px">
                            <?php
                            $attributes = negarshop_option('product_vip_attrs', 'posts', $cardData['id']);
                            if (!empty($attributes)) {
                                ?>
                                <?php
                                foreach ($attributes as $attribute) :
                                    ?>
                                    <li class="product-attr">
                                        <span class="product-attr-title"><?php echo $attribute['title']; ?>: </span>
                                        <span class="product-attr-text"><span><?php echo $attribute['values']; ?></span></span>
                                    </li>
                                    <?php $cardOptions['items_vars'] -= 1;
                                    if ($cardOptions['items_vars'] == 0) {
                                        break;
                                    } endforeach; ?>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <div class="card-footer-buttons position-relative">
                    <?php if ($cardOptions['price'] !== "false") { ?>
                        <div class="card-price <?php echo $cardOptions['one_price'] === "true" ? 'one-price' : ''; ?>">
                            <?php echo negarshop_price($productItem) ?>
                        </div>
                    <?php } ?>

                    <?php
                    $bottomAction = negarshop_product_actions($cardData['id'], $bottomActionArgs);
                    if ($bottomAction):
                        ?>
                        <div class="actions">
                            <?php
                            echo $bottomAction;
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>


        </div>
    </article>
<?php
echo ($grid !== false) ? '</div>' : '';