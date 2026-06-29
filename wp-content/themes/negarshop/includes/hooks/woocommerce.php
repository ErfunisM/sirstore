<?php
/**
 * Woocommerce hooks and functions.
 *
 * @package negarshop
 */

function negarshop_woocommerce_header_add_to_cart_fragment($fragments)
{
    $fragments['.rh-item .badge'] = '<span class="badge">' . WC()->cart->get_cart_contents_count() . '</span>';
    $fragments['.header-cart-basket .cart-basket-box .subtitle'] = '<span class="subtitle">' . WC()->cart->get_cart_total() . '</span>';
    $fragments['.header-cart-basket .cart-basket-box .count'] = '<span class="count">' . WC()->cart->get_cart_contents_count() . '</span>';

    return $fragments;
}

function negarshop_get_attribute_prent($id)
{
    global $post;
    $id = sanitize_title($id);
    $id = strtolower($id);
    $val = get_post_meta($_POST['post_id'] ?? $post->ID, "attribute_" . $id . "_parent", true);

    return !empty($val) ? $val : false;
}

function negarshop_action_woocommerce_after_product_attribute_settings($attribute, $i)
{
    $value = negarshop_get_attribute_prent($i);
    ?>
    <tr>
        <td>
            <div class="attribute-parent">
                <label><?php esc_html_e('گروه', 'negarshop'); ?></label><input type="text" class="attribute_parent"
                                                                               name="attribute_parent[<?php echo esc_attr($i); ?>]"
                                                                               value="<?php echo $value; ?>"/>
            </div>
        </td>
    </tr>
    <?php
}

function negarshop_product_vendor_details()
{
    global $product;
    if (function_exists('dokan_get_store_info')) {
        $author = get_user_by('email', get_the_author_meta('email'));
        $store_info = false;
        if ($author and !empty($author) and $author !== null) {
            $store_info = dokan_get_store_info($author->ID);
        }

        if ($store_info and isset($store_info['store_name']) and !empty($store_info['store_name'])) { ?>
            <div class="details vendor">
                <span class="title"><?php _e(' فروشنده:', 'negarshop'); ?></span>
                <?php printf('<a href="%s">%s</a>', dokan_get_store_url($author->ID), $store_info['store_name']); ?>
            </div>
        <?php }
    }
    if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>

        <div class="details sku_wrapper product_meta"><span
                    class="title"><?php esc_html_e('SKU:', 'woocommerce'); ?></span>
            <span
                    class="sku"><?php echo ($sku = $product->get_sku()) ? $sku : esc_html__('N/A', 'woocommerce'); ?></span>
        </div>

    <?php endif;
}

function negarshop_questions_show()
{
    if (is_user_logged_in()) {
        add_action('wp_footer', function () {
            ?>
            <div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
                 data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <span class="new-question"><?php _e('ثبت پرسش جدید', 'negarshop'); ?></span>
                                <span class="replay-question"><?php _e('ثبت پاسخ', 'negarshop'); ?></span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="<?= site_url() ?>/wp-comments-post.php" method="post">
                            <input type="hidden" name="comment_type" value="ns_question">
                            <input type="hidden" name="comment_post_ID" value="<?= get_the_ID() ?>">
                            <input type="hidden" id="question_parent" name="comment_parent" value="0">

                            <div class="modal-body">
                                <p>
                                    <label for="question-text">
                                        <span class="new-question"><?php _e('متن پرسش', 'negarshop'); ?></span>
                                        <span class="replay-question"><?php _e('متن پاسخ', 'negarshop'); ?></span>
                                    </label>
                                    <textarea id="question-text" name="comment" class="form-control" cols="30"
                                              rows="5"></textarea>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal"><?php _e('بستن', 'negarshop'); ?></button>
                                <button type="submit" id="submit-question-form" class="btn btn-primary mr-2">
                                    <span class="new-question"><?php _e('ارسال پرسش', 'negarshop'); ?></span>
                                    <span class="replay-question"><?php _e('ارسال پاسخ', 'negarshop'); ?></span>
                                    <span class="sending-comment"><?php _e('درحال ارسال ...', 'negarshop'); ?></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php });
    } ?>
    <div class="row">
        <div class="col-lg-3">
            <div class="question-submit">
                <i class="icon fal fa-question-square"></i>
                <p><?php _e('شما نیز میتوانید سوالات خود را ثبت کنید!', 'negarshop'); ?></p>
                <button class="send-question btn btn-primary" data-parent="0"><i class="far fa-question"></i>
                    <?php _e('ثبت پرسش', 'negarshop'); ?>
                </button>
            </div>
        </div>

        <div class="col-lg">
            <?php
            $questionsArg = [
                'status' => 'approve',
                'type' => 'ns_question',
                'post_id' => get_the_ID(),
                'parent' => 0,
                'number' => 5,
                'paged' => is_numeric($_GET['qpage'] ?? 'false') ? (int)$_GET['qpage'] : 1,
            ];
            $comments = get_comments($questionsArg);
            if (empty($comments)) {
                echo '<div class="question-empty">';
                echo '<span class="icon"><i class="far fa-times-circle"></i></span>';
                echo '<p>';
                _e('اگر سوالی در مورد محصول دارید از این قسمت بپرسید!', 'negarshop');
                echo '</p>';
                echo '</div>';
            } else {
                echo '<ul class="product-questions">';
                foreach ($comments as $comment) :
                    ?>
                <li class="question-item" id="question-<?= $comment->comment_ID ?>">
                    <div class="question-content">
                        <i class="far fa-question-square"></i>
                        <?= esc_html($comment->comment_content) ?>
                    </div>
                    <?php
                    $childReplyArg = $questionsArg;
                    $childReplyArg['parent'] = $comment->comment_ID;
                    unset($childReplyArg['type'], $childReplyArg['paged']);
                    $children = get_comments($childReplyArg);

                    if (!empty($children)) {
                        echo '<ul class="children">';
                        foreach ($children as $child) {
                            ?>


                            <li class="question-item" id="question-<?= $child->comment_ID ?>">
                                <div class="question-header"><?php _e('پاسخ:', 'negarshop'); ?></div>
                                <div class="question-content">
                                    <?= esc_html($child->comment_content) ?>
                                </div>
                                <div class="question-actions comment-actions">
                                    <div class="title"><?php _e('آیا این پاسخ برایتان مفید بود؟', 'negarshop'); ?></div>
                                    <div class="comment-like">
                                        <button class="comment-like-btn" data-action="like"
                                                data-id="<?= $child->comment_ID; ?>"><?php _e('بله', 'negarshop'); ?>
                                            <span
                                                    class="count"><?php echo negarshop_get_comment_likes($child->comment_ID); ?></span>
                                        </button>
                                    </div>
                                    <div class="comment-like">
                                        <button class="comment-like-btn" data-action="dislike"
                                                data-id="<?= $child->comment_ID; ?>"><?php _e('خیر', 'negarshop'); ?>
                                            <span
                                                    class="count"><?php echo negarshop_get_comment_dislikes($child->comment_ID); ?></span>
                                        </button>
                                    </div>
                                </div>
                            </li>
                        <?php }
                        echo '</ul>';
                    } else { ?>

                        <div class="question-actions">
                            <button class="btn send-question"
                                    data-parent="<?= $comment->comment_ID ?>"><?php _e('ارسال پاسخ', 'negarshop'); ?></button>
                        </div>
                    <?php } ?>
                    </li>
                <?php
                endforeach;
                echo '</ul>';
                unset($questionsArg['number']);
                $questionsArg['count'] = true;
                $questionsCounts = get_comments($questionsArg);
                echo '<div class="question-pagination">';
                paginate_comments_links([
                    'base' => add_query_arg('qpage', '%#%'),
                    'format' => '',
                    'total' => ceil($questionsCounts / 5),
                    'current' => is_numeric($_GET['qpage'] ?? 'false') ? (int)$_GET['qpage'] : 1,
                    'echo' => true,
                    'add_fragment' => '#questions'
                ]);
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php
}

function negarshop_product_tabs_customize($tabs)
{
    if (!isset($tabs['description']) and (!empty(negarshop_option('product_acc_desc', 'posts', get_the_id())) or !empty(negarshop_option('product_reviews_p', 'posts', get_the_id())) or !empty(negarshop_option('product_reviews_m', 'posts', get_the_id())) or !empty(negarshop_option('product_reviews_rate', 'posts', get_the_id())))) {
        $tabs['cb_rates'] = [
            'title' => __('بررسی ها', 'negarshop'),
            'callback' => 'woocommerce_product_description_tab'
        ];
    }

    $tabs['ns_questions'] = [
        'title' => __('پرسش و پاسخ', 'negarshop'),
        'priority' => 35,
        'callback' => 'negarshop_questions_show'
    ];

    $tab_manager = negarshop_option('product_tabs');
    if (!empty($tab_manager)) {
        foreach ($tab_manager as $item) {
            if (isset($tabs[$item['slug']])) {
                if ($item['active']) {
                    $tabs[$item['slug']]['title'] = $item['title'];
                    $tabs[$item['slug']]['priority'] = $item['priority'];
                } else {
                    unset($tabs[$item['slug']]);
                }
            }
        }
    }

    return $tabs;
}

function negarshop_woocommerce_account_menu_items($items)
{
    if (function_exists('yith_wcaf_get_dashboard_links')) {
        $items['affiliates'] = "بازاریابی";
    }
    unset($items['customer-logout']);

    return $items;
}

function negarshop_woocommerce_template_loop_product_second_thumbnail($id = null, $size = null)
{
    if ($id == null) {
        global $product;
        if (!$product) {
            return;
        }
        $id = $product->get_id();
    }
    $image_size = apply_filters('single_product_archive_thumbnail_size', 'woocommerce_thumbnail');
    if ($size !== null) {
        $image_size = $size;
    }
    $attach_id = negarshop_option('hover_image', 'posts', $id);
    if (!empty($attach_id) and isset($attach_id['attachment_id'])) {
        echo wp_get_attachment_image($attach_id['attachment_id'], $image_size);
    }
}

function negarshop_product_shipping_time()
{
    global $product, $product_id;
    $product_id = $product->get_ID();
    wc_get_template_part('single-product/shipping', 'time');
}

function negarshop_checkout_thankyou()
{
    if (negarshop_option('thankyou_page_customize') === 'custom') {
        $text = negarshop_option('thankyou_page-multi-picker');

        return $text['custom']['text'];
    }
    ?>
    <span class="woocommerce-thankyou-order-received-thankyou-buttons">
        <a href="<?= site_url() ?>" class="btn btn-primary"><?= __('بازگشت به فروشگاه', 'negarshop') ?></a>
        <a href="<?= wc_get_account_endpoint_url('orders') ?>" class="btn"><?= __('سفارشات من', 'negarshop') ?></a>
    </span>
    <?php
}

function negarshop_cart_header_steps()
{
    wc_get_template_part('cart', 'steps');
}

function negarshop_save_custom_field_variations($variation_id, $i)
{
    if (isset($_POST['variable_post_id'])) {
        $reg_price = $_POST['variable_regular_price'];
        $sale_price = $_POST['variable_sale_price'];
        negarshop_price_changes_add_meta($variation_id, $reg_price[$i], $sale_price[$i]);
    }
}

function negarshop_related_products_fix($args): array
{
    $args['meta_query'][] = [
        'key' => '_stock_status',
        'value' => 'instock'
    ];

    return $args;
}

function negarshop_delivery_checkout_field_process()
{
    if (negarshop_option('delivery_active') === 'true') {
        if (!isset($_POST['delivery_time']) || !is_numeric($_POST['delivery_time'])) {
            wc_add_notice('انتخاب زمان ارسال ضروری می باشد!', 'error');
        }
    }
}

function negarshop_delivery_checkout_field_update_order_meta($order_id)
{
    $deliveryDates = negarshop_get_cart_delivery_times(WC()->cart->get_cart());
    if (isset($_POST['delivery_time'])) {
        $metaValue = $deliveryDates[$_POST['delivery_time']] ?? 'نا معلوم';
        update_post_meta($order_id, 'ns_delivery_time', $metaValue);
    }

    if (isset($_POST['billing_map_address'])) {
        update_post_meta($order_id, 'billing_map_address', esc_sql($_POST['billing_map_address']));
    }

    if (isset($_POST['shipping_map_address'])) {
        update_post_meta($order_id, 'shipping_map_address', esc_sql($_POST['shipping_map_address']));
    }
}

function negarshop_delivery_order_column($columns)
{
    if (negarshop_option('delivery_active') === 'true') {
        $columns['ns_delivery'] = 'تاریخ تحویل';
    }

    return $columns;
}

function negarshop_delivery_order_column_content($column)
{
    global $post;
    if ('ns_delivery' === $column) {
        $order = wc_get_order($post->ID);
        $delivery = $order->get_meta('ns_delivery_time');
        if (is_array($delivery) && isset($delivery['date'])) {
            echo '<b>' . ns_jdate('Y/m/d', $delivery['date']) . '</b>';
        } else {
            echo 'انتخاب نشده';
        }
    }
}

function negarshop_delivery_checkout_field_display_admin_order_meta($order)
{
    if (negarshop_option('delivery_active') === 'true') {
        $delivery = $order->get_meta('ns_delivery_time');
        if (is_array($delivery) && isset($delivery['date'])) {
            $delivery = ns_jdate('Y/m/d', $delivery['date']);
        } else {
            $delivery = 'انتخاب نشده';
        }
        echo '<p><strong>تاریخ تحویل:</strong> ' . $delivery . '</p>';
    }


    if (negarshop_option('checkout_location') === 'true') {
        $map = $order->get_meta('billing_map_address');
        if (!empty($map)) {
            echo '<p><strong>آدرس روی نقشه:</strong> <a href="' . 'https://www.google.com/maps/dir//' . $map . '" target="_blank">مشاهده در نقشه</a></p>';
        }
    }
}

function negarshop_add_custom_field_to_variations($loop, $variation_data, $variation)
{
    $gallery_imgs = get_post_meta($variation->ID, 'cb_var_gallery', true);
    ?>
    <p class="form-row form-row-full">
        <label><?php _e('گالری متغیر', 'negarshop'); ?></label>
    <div class="cb_addable_image">
        <div class="image-items">
            <?php
            if (is_array($gallery_imgs) and !empty($gallery_imgs)) {
                foreach ($gallery_imgs as $gallery_img) {
                    $img_src = wp_get_attachment_image_src($gallery_img);
                    if ($img_src !== false and isset($img_src[0])) {
                        echo '<div class="img-item"><img src="' . $img_src[0] . '" alt=""><i>X</i><input name="cb_var_gallery[' . $loop . '][]" value="' . $gallery_img . '" type="hidden"></div>';
                    }
                }
            }
            ?>
        </div>
        <input type="button" data-name="cb_var_gallery[<?php echo $loop; ?>]"
               value="<?php _e('اضافه کردن', 'negarshop'); ?>" class="button button-primary button-large add-btn"/>
    </div>
    </p>
    <?php
}

function negarshop_save_gallery_custom_field_variations($variation_id, $i)
{
    if (isset($_POST['cb_var_gallery'][$i])) {
        update_post_meta($variation_id, 'cb_var_gallery', $_POST['cb_var_gallery'][$i]);
    } else {
        update_post_meta($variation_id, 'cb_var_gallery', []);
    }
}

function negarshop_add_images_to_variable($variations)
{
    if (!is_singular('product')) {
        return $variations;
    }
    $gallery_items = get_post_meta($variations['variation_id'], 'cb_var_gallery', true);
    $gallery_items = is_array($gallery_items) ? $gallery_items : [];

    $feature_image = get_post_meta($variations['variation_id'], '_thumbnail_id', true);

    if (!empty($feature_image)) {
        $gallery_items[] = $feature_image;
    }
    if (!empty($gallery_items)) {
        foreach ($gallery_items as $gallery_item) {
            $img = wp_get_attachment_image_src($gallery_item, 'large');
            $img_thumb = wp_get_attachment_image_src($gallery_item);
            if ($img !== false and isset($img[0])) {
                $variations['cb_var_gallery'][] = [
                    'large' => $img[0],
                    'thumb' => $img_thumb[0]
                ];
            }
        }
    }
    $product = new WC_Product(get_the_id());
    $variations['cb_product_images'] = negarshop_get_product_images($product, true);

    return $variations;
}

function negarshop_custom_override_default_locale_fields($fields): array
{
    $fields['state']['priority'] = 41;
    $fields['city']['priority'] = 42;

    return $fields;
}

function negarshop_wc_login_redirect($redirect_to)
{
    if (isset($_REQUEST['redirect'])) {
        $redirect_to = $_REQUEST['redirect'];
    } else if (isset($_GET['ref'])) {
        $redirect_to = $_GET['ref'];
    } else {
        $redirect_to = site_url();
    }

    return $redirect_to;
}

function negarshop_favs_add_premium_support_link_my_account($items)
{
    $items['favorites'] = 'علاقه مندی ها';

    return $items;
}

function negarshop_wc_category_description()
{

    if (is_product_category()) {
        global $wp_query;
        if ($wp_query->is_paged()) {
            $cat_id = $wp_query->get_queried_object_id();
            $cat_desc = term_description($cat_id, 'product_cat');
            echo $cat_desc;
        }
    }
}

function negarshop_woocommerce_before_main_content()
{
    echo '<div class="container">';
}

function negarshop_woocommerce_after_main_content()
{
    echo '</div>';
}

function negarshop_woocommerce_before_add_to_cart_product_actions()
{
    if (negarshop_option('product_single_type') === 'type-3' && negarshop_option('product_tools_ac') == "true") {
        wc_get_template_part('single-product/product', 'actions');
    }
}

function negarshop_woocommerce_single_product_summary_left()
{
    if (negarshop_option('product_single_type') !== 'type-3') {
        negarshop_product_vendor_details();
    }
}

function negarshop_woocommerce_single_product_summary()
{
    get_template_part('/woocommerce/single-product/attrs');
}

function negarshop_woocommerce_review_meta($com)
{
    $date = human_time_diff(strtotime($com->comment_date)) . __(' پیش', 'negarshop');
    echo '<p class="meta">
		<strong class="woocommerce-review__author">' . $com->comment_author . '</strong>
		<span class="woocommerce-review__dash">–</span>
		<time class="woocommerce-review__published-date" datetime="' . $com->comment_date . '">' . $date . '</time>
	</p>';
}

function negarshop_woocommerce_single_product_summary_tags()
{
    if (negarshop_option('product_tags_tools') !== 'true') {
        return;
    }
    global $product;
    echo wc_get_product_tag_list($product->get_id(), ', ', '<div class="tagged_as"><i class="fal fa-tags"></i>' . _n('Tag:', 'Tags:', count($product->get_tag_ids()), 'woocommerce') . ' ', '</div>');
}

function negarshop_woocommerce_after_cart_item_name($cart_item, $cart_item_key)
{
    global $product_id;
    $product_id = $cart_item['product_id'];
    wc_get_template_part('single-product/shipping', 'time');
}

function negarshop_woocommerce_empty_price_html($product): string
{
    return '<span class="price-coming-soon">' . negarshop_option('noprice_text') . '</span>';
}

function negarshop_woocommerce_checkout_fields($fields)
{
    if (negarshop_option('checkout_location') !== 'true') {
        return $fields;
    }
    $fields['billing']['billing_map_address'] = [
        'label' => __('آدرس روی نقشه', 'negarshop'),
        'required' => false,
        'class' => ['hidden'],
        'input_class' => ['input-has-map'],
        'autocomplete' => 'billing_map_address',
        'priority' => 200,
        'custom_attributes' => [
            'data-listen' => '#billing_city, #billing_state',
            'data-map' => 'billing-map'
        ]
    ];

    $fields['shipping']['shipping_map_address'] = [
        'label' => __('آدرس روی نقشه', 'negarshop'),
        'required' => false,
        'class' => ['hidden'],
        'input_class' => ['input-has-map'],
        'autocomplete' => 'shipping_map_address',
        'priority' => 200,
        'custom_attributes' => [
            'data-listen' => '#shipping_city, #shipping_state',
            'data-map' => 'shipping-map'
        ]
    ];

    return $fields;
}

function negarshop_woocommerce_admin_order_data_after_shipping_address($order)
{
    if (negarshop_option('checkout_location') === 'true') {
        $map = $order->get_meta('shipping_map_address');
        if (!empty($map)) {
            echo '<p><strong>آدرس روی نقشه:</strong> <a href="' . 'https://www.google.com/maps/dir//' . $map . '" target="_blank">مشاهده در نقشه</a></p>';
        }
    }
}

function negarshop_woocommerce_dropdown_variation_attribute_options_html($html, $args)
{
    if (is_singular('product')) {
        return $html;
    }

    return str_replace('id="' . $args['id'] . '"', '', $html);
}

function negarshop_woocommerce_review_meta_badges($comment)
{
    global $post;
    if ($comment->user_id !== "0") {
        $customer_email = get_user_meta($comment->user_id, 'billing_email', true);
        $is_bought = wc_customer_bought_product($customer_email, $comment->user_id, $comment->comment_post_ID);
        if ($is_bought) {
            echo '<span class="big-meta-item is-bought">' . __('خریدار این محصول', 'negarshop') . '</span>';
        }
    }
    if ($comment->user_id === "1") {
        echo '<span class="big-meta-item is-admin">' . __('مدیریت سایت', 'negarshop') . '</span>';
    }
}

function negarshop_woocommerce_before_single_product_summary_shipping_time()
{
    if (negarshop_option('product_single_type') !== 'type-3') {
        return;
    }
    negarshop_product_shipping_time();
}

function negarshop_woocommerce_before_single_product_summary_alerts()
{
    if (negarshop_option('product_single_type') !== 'type-3') {
        return;
    }
    wc_get_template_part('single-product/product', 'alerts');
}

function negarshop_woocommerce_single_product_summary_shipping_time()
{
    if (negarshop_option('product_single_type') === 'type-3') {
        return;
    }
    negarshop_product_shipping_time();
}

function negarshop_woocommerce_single_product_summary_product_alerts()
{
    if (negarshop_option('product_single_type') === 'type-3') {
        return;
    }
    wc_get_template_part('single-product/product', 'alerts');
}

function negarshop_sort_by_stock($posts_clauses)
{
    if (negarshop_option("sort_by_stock") !== "true") {
        return $posts_clauses;
    }

    global $wpdb;

    if (is_woocommerce() && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy())) {
        $posts_clauses['join'] .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
        $posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
        $posts_clauses['where'] = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
    }

    return $posts_clauses;
}

function negarshop_pre_get_posts_shop($query)
{
    if (function_exists('WC')) {
        if (is_archive() and (is_shop() || is_product_category() || is_product_tag()) && $query->is_main_query()) {

            $orderby_value = isset($_GET['stock']) ? wc_clean($_GET['stock']) : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby'));
            if ($orderby_value == 'instock') {
                $query->set('meta_key', '_stock_status');
                $query->set('meta_value', 'instock');
            }

            $cat_value = isset($_GET['pcat']) ? $_GET['pcat'] : false;
            if (is_numeric($cat_value)) {
                $query->set('tax_query', [
                    [
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => [(int)$cat_value],
                    ]
                ]);
            }

        }
    }
}

function negarshop_ajax_woocommerce_save_attributes()
{
    check_ajax_referer('save-attributes', 'security');
    parse_str($_POST['data'], $data);
    $post_id = absint($_POST['post_id']);
    if (array_key_exists("attribute_parent", $data) && is_array($data["attribute_parent"])) {
        foreach ($data["attribute_parent"] as $i => $val) {
            $attr_name = sanitize_title($data["attribute_names"][$i]);
            $attr_name = strtolower($attr_name);
            update_post_meta($post_id, "attribute_" . $attr_name . "_parent", $val);
        }
    }
}

function negarshop_remove_product_metabox()
{
    remove_meta_box('postcustom', 'product', 'normal');
}

function negarshop_get_variable_product_values($children, $value = "dates", $passed = null)
{
    if (!empty($children)) {
        foreach ($children as $item) {

            $pf = new WC_Product_Factory();
            $prd = $pf->get_product($item);
            if ($passed !== null) {
                $prd = $pf->get_product($passed);
            }
            if ($value == "dates") {
                $st_time = new WC_DateTime($prd->get_date_on_sale_from());
                $ed_time = new WC_DateTime($prd->get_date_on_sale_to());
                if ($prd->get_date_on_sale_from() !== null or $prd->get_date_on_sale_to() !== null) {
                    return ['start_time' => $st_time, 'end_time' => $ed_time];
                }
            }
            if ($value == "sale") {
                if ($prd->is_on_sale() or $item == $children[count($children) - 1]) {
                    return $prd->is_on_sale();
                }
            }
            if ($value == "prices") {
                if (!empty($prd->get_regular_price()) and !empty($prd->get_sale_price())) {
                    return [
                        'regu_price' => $prd->get_regular_price(),
                        'sale_price' => $prd->get_sale_price(),
                        'price' => $prd->get_price_html(),
                    ];
                }
            }
            if ($value == "total_sale") {
                echo $prd->get_total_sales();
            }
            if ($value == "stock") {
                if ($prd->get_stock_status() == "instock" or $item == $children[count($children) - 1]) {
                    return [
                        'manage' => $prd->get_manage_stock(),
                        'quantity' => $prd->get_stock_quantity(),
                        'status' => $prd->get_stock_status(),
                    ];
                }
            }
            if ($passed !== null) {
                break;
            }
        }
    }

    return false;
}

function negarshop_get_ribbons($id = null)
{
    if ($id !== null && is_numeric($id)) {
        $pf = new WC_Product_Factory();
        $prd = $pf->get_product($id);
        $ribbons = [];

        $sp = "";
        $rp = "";
        $pgms = false;
        $pgsq = 1;
        $sf_date = null;
        $st_date = null;
        $on_sale = false;

        if ($prd->get_type() === "simple" || $prd->get_type() === "external") {
            $sp = $prd->get_sale_price();
            $rp = $prd->get_regular_price();
            $pgms = $prd->get_stock_status();
            $on_sale = $prd->is_on_sale();
        }

        if ($prd->get_type() === "variable") {
            $price_vals = negarshop_get_variable_product_values($prd->get_children(), "prices");
            if ($price_vals !== false) {
                $sp = $price_vals['sale_price'];
                $rp = $price_vals['regu_price'];
                $price_stock = negarshop_get_variable_product_values($prd->get_children(), "stock");
                $pgms = $price_stock['status'];
                $on_sale = negarshop_get_variable_product_values($prd->get_children(), "sale");
            }
        }
        /*
                if (!empty($sp) and !empty($rp)) {
                    $ribbons['percent'] = (1- round(($sp / $rp),3))*100;
                }*/
        if ($on_sale) {
            $roundDiscount = negarshop_option('product_price_percent');
            $ribbons['fal fa-percent'] = [
                'title' => (1 - round($sp / $rp, $roundDiscount === 'true' ? 2 : 3)) * 100,
                'color' => negarshop_option('ribb_sale_color')
            ];
        }
        if ($pgms === "outofstock") {
            $ribbons = [];
            $ribbons['fal fa-times'] = [
                'title' => __("ناموجود", 'negarshop'),
                'color' => negarshop_option('ribb_stock_color')
            ];
        }
        if ($prd->get_backorders() !== "no") {
            unset($ribbons['fal fa-times']);
        }

        return $ribbons;
    }

    return false;
}

function negarshop_print_ribbons($id = null, $is_single = false): bool
{
    if ($id !== null && is_numeric($id)) {
        $ribbons = negarshop_get_ribbons($id);
        $custom_ribbons = negarshop_option('product_ribbons');
        if (!empty($custom_ribbons)) {
            foreach ($custom_ribbons as $custom_ribbon) {
                $product_ribbon = negarshop_option(md5($custom_ribbon['title']), 'posts', $id);
                if ($product_ribbon) {
                    $ribbons[$custom_ribbon['icon']] = [
                        'title' => $custom_ribbon['title'],
                        'color' => isset($custom_ribbon['color']) ? $custom_ribbon['color'] : ''
                    ];
                }
            }
        }
        if (!empty($ribbons)) {
            echo $is_single ? '<div class="product-single-ribbons">' : '';
            echo '<div class="ribbons">';

            foreach ($ribbons as $name => $val) {
                $color = isset($val['color']) ? $val['color'] : '#999';
                $title = "";
                if ($name == "fal fa-percent") {
                    $title = $val['title'];
                }
                if ($name == "fal fa-star") {
                    $title = __("حراج", 'negarshop');
                }
                if ($name == "fal fa-cubes") {
                    $title = __("سه بعدی", 'negarshop');
                    $color = negarshop_option('ribb_3d_color');
                }
                echo '<div><span style="background-color: ' . $color . '" title="' . $title . '" class="item"><i class="' . $name . '"></i> <span> ' . $val['title'] . ' </span></span></div>';
            }
            echo '</div>';
            echo $is_single ? '</div>' : '';
        }
    }

    return false;
}

function negarshop_get_print_ribbons($id = null, $is_single = false)
{

    ob_start();
    negarshop_print_ribbons($id, $is_single);
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

function negarshop_product_in_stock($id = null): bool
{
    if ($id != null) {
        $ribbons = negarshop_get_ribbons($id);
        if (isset($ribbons['times'])) {
            return false;
        }

        return true;
    }

    return false;
}

function negarshop_get_product_timer($id = null, $variable_index = null)
{
    if (isset($id) and is_numeric($id)) {
        $timer = [];
        $pf = new WC_Product_Factory();
        $prd = $pf->get_product($id);
        if ($prd->get_type() == "simple") {
            $st_time = new WC_DateTime($prd->get_date_on_sale_from());
            $ed_time = new WC_DateTime($prd->get_date_on_sale_to());
            $timer['sale_date_start'] = $st_time->getTimestamp();
            $timer['sale_date_end'] = $ed_time->getTimestamp();

            return $timer;
        } else if ($prd->get_type() == "variable" and $prd->has_child()) {
            $vr_product_dates = negarshop_get_variable_product_values($prd->get_children(), "dates", $variable_index);
            if ($vr_product_dates !== false) {
                $std_time = $vr_product_dates['start_time'];
                $end_time = $vr_product_dates['end_time'];
                $timer['sale_date_start'] = $std_time->getTimestamp();
                $timer['sale_date_end'] = $end_time->getTimestamp();

                return $timer;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    return false;
}

function negarshop_get_rating_html($rating, $count = 0)
{
    if ($count === 0) {
        $tmp = negarshop_option('product_def_rate', 'posts', get_the_ID());
        if (is_numeric($tmp)) {
            $rating = $tmp;
        }
    }
    $html = '<div class="star-rating">';
    $html .= wc_get_star_rating_html($rating, $count);
    $html .= '</div>';

    return apply_filters('woocommerce_get_star_rating_html', $html, $rating, $count);
}

function negarshop_shop_header_filters()
{
    ?>
    <header class="woocommerce-products-header woocommerce-products-header--<?php echo esc_attr(negarshop_option('products_archive_orders_header_style')); ?>">
        <?php if (apply_filters('woocommerce_show_page_title', true) && negarshop_option('breadcrumb_title') !== 'yes') : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
        <?php endif; ?>


        <div class="products-archive-header">
            <div class="products-archive-tabs-wrapper">
                <h6><?php _e('مرتب سازی بر اساس :', 'negarshop'); ?></h6>
                <?php if (negarshop_option('products_archive_orderby_style') === 'tab') : ?>
                <div class="d-none">
                    <?php endif; ?>
                    <?php woocommerce_catalog_ordering(); ?>
                    <?php if (negarshop_option('products_archive_orderby_style') === 'tab') : ?>
                </div>
            <?php
            $default_orderby = wc_get_loop_prop('is_search') ? 'relevance' : apply_filters('woocommerce_default_catalog_orderby', get_option('woocommerce_default_catalog_orderby', ''));
            $orderby = isset($_GET['orderby']) ? wc_clean(wp_unslash($_GET['orderby'])) : $default_orderby;
            $orderOptions = apply_filters('woocommerce_catalog_orderby', [
                'date' => __('جدیدترین', 'negarshop'),
                'popularity' => __('محبوب‌ترین', 'negarshop'),
                'rating' => __('رتبه بندی', 'negarshop'),
                'price' => __('ارزان‌ترین', 'negarshop'),
                'price-desc' => __('گران‌ترین', 'negarshop'),
            ]);

            $tabsStyle = negarshop_option('products_archive_orderby_tab-picker');
            ?>
                <ul class="products-archive-tabs products-archive-tabs--<?php echo esc_attr($tabsStyle['tab']['style']); ?>">
                    <?php foreach ($orderOptions as $key => $label): ?>
                        <li>
                            <button class="<?php echo $orderby === $key ? ' active' : ''; ?>"
                                    id="btn-sort-<?php echo esc_attr($key); ?>"
                                    data-value="<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            </div>
            <?php
            if (negarshop_option('products_archive_stock_filter') === 'true') :
                $instock = isset($_GET['stock']) && $_GET['stock'] === 'instock';
                ?>
                <div class="order-by-stock">
                    <span class="title"><?php _e('فقط موجود ها: ', 'negarshop'); ?></span>
                    <label class="switch">
                        <input type="checkbox" id="archive-in-stock-switch" <?php echo checked($instock); ?>>
                        <span class="slider round"></span>
                    </label>
                </div>
            <?php
            endif;
            if (negarshop_option('shop_sidebar') === 'popup') {
                do_action('woocommerce_sidebar');
            }
            ?>
        </div>
        <?php
        if (negarshop_option('products_archive_active_filter') === 'true' && class_exists('WC_Widget_Layered_Nav_Filters')) {
            $activeFilters = new WC_Widget_Layered_Nav_Filters();
            $activeFilters->widget([
                'before_widget' => '<div class="products-archive-active-filters">',
                'before_title' => '<span class="filters-title">',
                'after_title' => '</span>',
                'after_widget' => '</div>',
            ], []);
        }
        ?>
    </header>
    <?php
}

function negarshop_get_products_delivery_total_time(array $items): int
{
    $productsDelivery = 0;
    if (!empty($items)) {
        foreach ($items as $cart_item) {
            $itemTime = 0;
            if ($cart_item['data']->get_type() === 'variation') {

                $itemTime = negarshop_option('product_shipping_time', 'posts', $cart_item['data']->get_parent_id());

                if (!is_numeric($itemTime)) {
                    continue;
                }

                $productsDelivery = ((int)$itemTime) > $productsDelivery ? (int)$itemTime : $productsDelivery;
                continue;
            }
            $itemTime = negarshop_option('product_shipping_time', 'posts', $cart_item['product_id']);

            $productsDelivery = ((int)$itemTime) > $productsDelivery ? (int)$itemTime : $productsDelivery;
        }

        return $productsDelivery;
    }

    return 0;
}

function negarshop_get_cart_delivery_times(array $items): array
{
    $productsDelivery = negarshop_get_products_delivery_total_time($items);

    $allowedDays = negarshop_option('delivery_allowed_dates');
    $deliveryMin = negarshop_option('delivery_min');
    $deliveryMin = is_numeric($deliveryMin) ? (int)$deliveryMin : 0;

    $datesCount = negarshop_option('delivery_times');
    $datesCount = is_numeric($datesCount) ? (int)$datesCount : 3;
    $datesCount += 7 - count($allowedDays);
    $results = [];

    for ($i = 0; $i < $datesCount; $i++) {
        $datetime = new DateTime();
        $datetime->modify('+' . ($productsDelivery + $i + $deliveryMin) . ' ' . ($productsDelivery + $i + $deliveryMin > 1 ? 'day' : 'days'));
        if (!in_array(strtolower($datetime->format('l')), $allowedDays, false)) {
            continue;
        }


        $results[] = [
            'dayName' => $datetime->format('l'),
            'date' => $datetime->format('U')
        ];
    }


    return $results;
}

function negarshop_format_delivery($order_delivery)
{
    if (is_array($order_delivery) && isset($order_delivery['date'])) {
        return ns_jdate('Y/m/d', $order_delivery['date']);
    }

    return false;
}

function negarshop_cart_regular_orders_total()
{
    $total = 0;
    if (WC()->cart->is_empty()) {
        return $total;
    }
    foreach (WC()->cart->get_cart_contents() as $cart_content) {
        if (!isset($cart_content['data']) || empty($cart_content['data'])) {
            continue;
        }
        if (empty($cart_content['data']->get_regular_price()) && !is_numeric($cart_content['data']->get_regular_price()) && empty($cart_content['data']->get_price()) && !is_numeric($cart_content['data']->get_price())) {
            continue;
        }
        if (empty($cart_content['data']->get_regular_price())) {
            $total += $cart_content['data']->get_price() * $cart_content['quantity'];
        } else {
            $total += $cart_content['data']->get_regular_price() * $cart_content['quantity'];
        }
    }
    return $total;
}

function negarshop_cart_sale_orders_total()
{
    if (negarshop_cart_regular_orders_total() - WC()->cart->get_cart_contents_total() < 0) {
        return false;
    }
    $price = negarshop_cart_regular_orders_total() - WC()->cart->get_cart_contents_total();
    return $price <= 0 ? false : wc_price($price);
}

function negarshop_ajax_variable_product()
{
    header("Content-type:application/json");
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    $data_store = WC_Data_Store::load('product');
    unset($_POST['action']);
    $variable_product = wc_get_product(absint($_POST['product_id']));
    $variation_id = $data_store->find_matching_product_variation($variable_product, wp_unslash($_POST));
    $pf = new WC_Product_Factory();
    $prd = $pf->get_product($variation_id);
    if ($prd !== false) {
        $st_time = new WC_DateTime($prd->get_date_on_sale_from());
        $ed_time = new WC_DateTime($prd->get_date_on_sale_to());
        $res_data = [
            'prices' => [
                'reg' => $prd->get_regular_price(),
                'sale' => $prd->get_sale_price(),
                'currency_symbol' => get_woocommerce_currency_symbol(),
            ]
        ];
        if ($prd->get_date_on_sale_from() !== null or $prd->get_date_on_sale_to() !== null) {
            $res_data['dates'] = [
                'start' => $st_time->getTimestamp(),
                'end' => $ed_time->getTimestamp(),
                'now' => time()
            ];
            $json_array['status'] = true;
        } else {
            $res_data = [];
        }
        $json_array['data'] = $res_data;
    }
    echo json_encode($json_array);
    wp_die();
}

/**
 * @param WC_Product $product
 * @return string
 */
function negarshop_price($product): string
{
    $return = '';
    if (empty($product->get_price_html())) {
        $return .= '<span class="unavailable">' . __('بزودی', 'negarshop') . '</span>';
    } else if ($product->get_stock_status() !== 'outofstock') {
        $return .= $product->get_price_html();
    } else {
        $return .= '<span class="unavailable">' . negarshop_option('noprice_text') . '</span>';
    }

    return str_replace(' &ndash; ', '<span class="dash"> &ndash; </span>', $return);
}

function negarshop_carousel_item($item, $is_ajax = false, $grid = false, $opts = [])
{
    if (!function_exists('WC')) {
        return;
    }
    global $product;
    $oldGlobalProduct = $product;
    $product = $item;
    wc_get_template('content-product.php', [
        'productItem' => $item,
        'grid' => $grid,
        'options' => $opts,
    ]);
    $product = $oldGlobalProduct;
}

function negarshop_product_actions(int $productID, $options = [])
{
    if ($options === false) {
        return false;
    }
    $optionsDefaults = [
        'like' => true,
        'compare' => true,
        'view' => true,
        'cart' => true,
        'cart_type' => 'simple',
        'cart_text' => '<i class="far fa-shopping-cart"></i>'
    ];
    $options = array_merge($optionsDefaults, $options);
    if (!in_array(true, $options)) {
        return false;
    }
    ob_start();
    ?>
    <ul>
        <?php if ($options['like']): ?>
            <li class="like"><?php negarshop_fav_btn($productID); ?></li>
        <?php endif; ?>
        <?php if ($options['compare']): ?>
            <li class="woocommerce product compare-button"><?php negarshop_print_compare_btn($productID, '<i class="far fa-random"></i>'); ?></li>
        <?php endif; ?>
        <?php if ($options['view']): ?>
            <li class="quick-view">
                <?php negarshop_quick_view_btn($productID); ?>
            </li>
        <?php endif; ?>
        <?php if ($options['cart']): ?>
            <li class="add-to-cart">
                <?php echo negarshop_add_to_cart_btn($productID, $options['cart_text'], '',
                    '1031', $options['cart_type']); ?>
            </li>
        <?php endif; ?>
    </ul>
    <?php
    return ob_get_clean();
}

function negarshop_get_all_image_sizes()
{
    global $_wp_additional_image_sizes;

    $default_image_sizes = ['thumbnail', 'medium', 'medium_large', 'large'];

    $image_sizes = [];

    foreach ($default_image_sizes as $size) {
        $image_sizes[$size] = [
            'width' => (int)get_option($size . '_size_w'),
            'height' => (int)get_option($size . '_size_h'),
            'crop' => (bool)get_option($size . '_crop'),
        ];
    }

    if ($_wp_additional_image_sizes) {
        $image_sizes = array_merge($image_sizes, $_wp_additional_image_sizes);
    }

    return apply_filters('image_size_names_choose', $image_sizes);
}

function negarshop_image_size_builder($select, $custom_width = '200', $custom_height = '200')
{
    if ($select !== "custom") {
        $size = $select;
    } else {
        $size = [
            $custom_width,
            $custom_height
        ];
    }

    return $size;
}

function negarshop_product_color_vars($product)
{
    if ($product->get_type() === "variable") {
        $prd_atts = $product->get_attributes();
        if (!empty($prd_atts)) {
            $tmp_vars = [];
            $colors = [];
            foreach ($prd_atts as $key => $val) {
                $attr = wc_get_attribute($val->get_id());
                if ($attr !== null && $attr->type === "colorpicker") {
                    $tmp_vars[$key] = $val->get_options();
                    if (!empty($tmp_vars[$key])) {
                        foreach ($tmp_vars[$key] as $itm) {
                            $colorMeta = get_term_meta($itm, $attr->slug . '_yith_wccl_value', true);
                            if (empty($colorMeta)) {
                                $colorMeta = get_term_meta($itm, '_yith_wccl_value', true);
                            }
                            $colors[$itm] = $colorMeta;
                        }
                    }
                }
            }

            return $colors;
        }
    }

    return false;
}

function negarshop_print_colored_dots($product)
{
    $colors = negarshop_product_color_vars($product);
    if ($colors && !empty($colors)) {
        $output = '<div class="colored-dots" data-toggle="tooltip" data-placement="bottom" data-original-title="' . __('رنگبندی ها',
                'negarshop') . '">';
        foreach ($colors as $key => $val) {
            if (!empty($val)) {
                $output .= '<span class="dot-item" style="background-color: ' . $val . '"></span>';
            }
        }
        $output .= '</div>';

        return $output;
    }

    return false;
}

function negarshop_print_threeview_btn($id)
{
    $opt = negarshop_option('model_ac', 'posts', $id);
    if (!isset($opt['selector']) || $opt['selector'] !== "true") {
        return;
    }
    echo '<li>';
    echo '<a href="javascript:void(0);" data-toggle="modal" data-target=".view-3d-modal-' . $id . '" class="action-btn-3d-view" data-id="' . $id . '">' . __('سه بعدی', 'negarshop') . '</a>';
    echo '</li>';
}

function negarshop_print_threeview_popup()
{
    if (!is_singular('product')) {
        return;
    }
    $id = get_the_ID();
    $opt = negarshop_option('model_ac', 'posts', $id);
    if (!isset($opt['selector']) || $opt['selector'] !== "true") {
        return;
    }

    ?>
    <div class="modal fade view-3d-modal-<?php echo $id; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn close-modal" data-dismiss="modal">
                    <i class="far fa-times"></i>
                </button>
                <div id="modal-3d-view-inner">
                    <div class="spinner"></div>
                    <div class="obj_content"></div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function negarshop_print_product_video_btn($id)
{
    $videos = negarshop_option('product_videos', 'posts', $id);

    if (!empty($videos) and is_array($videos)) {
        echo '<li>';
        echo '<a href="javascript:void(0);" data-toggle="modal" data-target=".view-video-modal-' . $id . '" class="action-btn-video-view" data-id="' . $id . '">' . __('ویدئو', 'negarshop') . '</a>';
        echo '</li>';
    }
}

function negarshop_print_product_video_modal()
{
    if (!is_singular('product')) {
        return;
    }
    $id = get_the_ID();
    $videos = negarshop_option('product_videos', 'posts', $id);

    if (empty($videos) || !is_array($videos)) {
        return;
    }
    ?>
    <div class="modal fade view-video-modal-<?php echo $id; ?>" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn close-modal" data-dismiss="modal">
                    <i class="far fa-times"></i>
                </button>
                <div class="modal-header">
                    <h5 class="modal-title"><?php _e('ویدیوی محصول', 'negarshop'); ?></h5>
                </div>
                <div class="modal-body">
                    <div class="owl-carousel product-video-carousel">
                        <?php
                        foreach ($videos as $video) {
                            if (!isset($video['value']['url']) && empty($video['url'])) {
                                continue;
                            }

                            $videoLink = empty($video['url']) ? $video['value']['url'] : $video['url'];

                            echo '<div class="product-item-video">';
                            echo do_shortcode('[video src="' . $videoLink . '"]');
                            echo isset($video['title']) ? '<h4 class="video-title">' . $video['title'] . '</h4>' : '';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

function negarshop_3dview_ajax()
{
    header("Content-type:application/json");
    $json_array = [
        'status' => false,
        'data' => ['m' => '', 't' => '', 'c' => '']
    ];
    $id = $_POST['id'];
    $three_ac = negarshop_option('model_ac', 'posts', $id);
    if (isset($three_ac['selector']) && $three_ac['selector'] === "true") {
        $json_array['status'] = true;
        if (!empty($three_ac['true']['model_m'])) {
            $json_array['data']['m'] = $three_ac['true']['model_m'];
        }
        if (!empty($three_ac['true']['model_t'])) {
            $json_array['data']['t'] = $three_ac['true']['model_t'];
        }
        if (!empty($three_ac['true']['model_c'])) {
            $json_array['data']['c'] = $three_ac['true']['model_c'];
        }
    }
    die(json_encode($json_array));
}

function negarshop_price_html()
{
    header("Content-type:application/json");
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    $id = $_POST['int'];
    if (is_numeric($id)) {
        $json_array = [
            'status' => true,
            'data' => wc_price($id)
        ];
    }
    die(json_encode($json_array));
}

function negarshop_email_sharing()
{
    header("Content-type:application/json");
    $json_array = [
        'status' => false,
        'data' => ''
    ];
    $id = $_POST['id'];
    $email = $_POST['email'];
    if (is_numeric($id) && is_email($email)) {
        $subject = get_bloginfo('name') . ' - ' . get_the_title($id);
        $body = '<div style="direction: rtl; text-align: right;"><h1>' . get_the_title($id) . '</h1><br>';
        $body .= '<p>' . get_the_excerpt($id) . '</p><br>';
        $body .= '<a style="background: #00bfd6;color: #fff;display: block;padding: 10px;text-align: center;text-decoration: navajowhite;" href="' . get_the_permalink(
                $id
            ) . '">' . __(
                'صفحه محصول', 'negarshop'
            ) . '</a>';
        $body .= '</div>';

        $headers = ['Content-Type: text/html; charset=UTF-8'];
        $send = wp_mail($email, $subject, $body, $headers);
        if ($send) {
            $json_array = [
                'status' => true,
                'data' => __('ایمیل با موفقیت ارسال شد!', 'negarshop')
            ];
        }
    }
    die(json_encode($json_array));
}

function negarshop_percent_to_text($int): ?string
{
    $txt = "";
    if (is_numeric($int)) {
        if ($int > 0) {
            $txt = __("خیلی بد", 'negarshop');
        }
        if ($int > 20) {
            $txt = __("بد", 'negarshop');
        }
        if ($int > 40) {
            $txt = __("متوسط", 'negarshop');
        }
        if ($int > 60) {
            $txt = __("خوب", 'negarshop');
        }
        if ($int > 80) {
            $txt = __("خیلی خوب", 'negarshop');
        }
        if ($int == 100) {
            $txt = __("عالی", 'negarshop');
        }
    }

    return $txt;
}

function negarshop_woocommerce_output_related_products_args($args): array
{
    $args = wp_parse_args(['posts_per_page' => 6], $args);
    if (negarshop_option('wide_style') == 'true') {
        $args = wp_parse_args(['posts_per_page' => 7], $args);
    }

    return $args;
}

function negarshop_get_product_images($product, $url = false, $krsort = true)
{
    if ($product !== null) {
        $attachment_ids = $product->get_gallery_image_ids();
        $attachment_ids_tmp = [];
        if (!empty($product->get_image_id())) {
            $attachment_ids_tmp[] = $product->get_image_id();
        }
        $attachment_ids = array_merge($attachment_ids_tmp, $attachment_ids);
        if ($krsort) {
            krsort($attachment_ids);
        }
        $res = $attachment_ids;
        if ($url) {
            $res = [];
            foreach ($attachment_ids as $attachment_id) {
                $gitem = wp_get_attachment_image_src($attachment_id, 'large');
                if (!isset($gitem[0])) {
                    continue;
                }
                $res[] = $gitem[0];
            }
        }

        return empty($res) ? false : $res;
    }
}

function negarshop_get_thumbnail($id = null, $size = "post-thumbnail")
{
    if ($id === null) {
        $id = get_the_ID();
    }
    $url = get_the_post_thumbnail_url($id, $size);
    $output = '<img class="lazy" data-src="' . $url . '" alt="' . get_the_title($id) . '">';

    return $output;
}

function negarshop_price_update_time()
{
    if (negarshop_option('product_price_update') !== 'true') {
        return;
    }
    global $product;
    if ($product) {
        $prdMD = $product->get_date_modified();
        echo '<span class="price-update">' . __('بروزرسانی قیمت', 'negarshop') . ': ' . ns_jdate(
                'Y/m/d', $prdMD->getTimestamp()
            ) . '</span>';
    }
}

function negarshop_sale_product_timer()
{
    if (negarshop_option('product_single_type') === 'type-3') {
        wc_get_template_part('single-product/product', 'sale');
    }
}

function negarshop_persian_chars_checkout()
{
    if (isset($_POST['billing_first_name']) and !negarshop_check_persian($_POST['billing_first_name'])) {
        wc_add_notice(__('لطفا <b>نام خود را بصورت فارسی</b> وارد نمایید!', 'negarshop'), 'error');
    }
    if (isset($_POST['billing_last_name']) and !negarshop_check_persian($_POST['billing_last_name'])) {
        wc_add_notice(__('لطفا <b>نام خانوادگی خود را بصورت فارسی</b> وارد نمایید!', 'negarshop'), 'error');
    }
    if (isset($_POST['billing_address_1']) and !negarshop_check_persian($_POST['billing_address_1'])) {
        wc_add_notice(__('لطفا <b>خیابان خود را بصورت فارسی</b> وارد نمایید!', 'negarshop'), 'error');
    }
    if (isset($_POST['billing_address_2']) and !negarshop_check_persian($_POST['billing_address_2'])) {
        wc_add_notice(__('لطفا <b>آدرس خود را بصورت فارسی</b> وارد نمایید!', 'negarshop'), 'error');
    }

    if (isset($_POST['shipping_first_name']) and !negarshop_check_persian($_POST['shipping_first_name'])) {
        wc_add_notice(__('لطفا <b>نام خود را بصورت فارسی</b> وارد نمایید!', 'negarshop'), 'error');
    }
    if (isset($_POST['shipping_last_name']) and !negarshop_check_persian($_POST['shipping_last_name'])) {
        wc_add_notice(__('لطفا <b>نام خانوادگی خود را بصورت فارسی</b> وارد نمایید!', 'negarshop'), 'error');
    }
    if (isset($_POST['shipping_address_1']) and !negarshop_check_persian($_POST['shipping_address_1'])) {
        wc_add_notice(__('لطفا <b>خیابان خود را بصورت فارسی</b> وارد نمایید!', 'negarshop'), 'error');
    }
    if (isset($_POST['shipping_address_2']) and !negarshop_check_persian($_POST['shipping_address_2'])) {
        wc_add_notice(__('لطفا <b>آدرس خود را بصورت فارسی</b> وارد نمایید!', 'negarshop'), 'error');
    }
}

function negarshop_check_persian($string): bool
{
    return preg_replace("/[a-zA-Z]/", "", $string) === $string;
}

function negarshop_get_account_menu_items()
{
    $endpoints = [
        'orders' => get_option('woocommerce_myaccount_orders_endpoint', 'orders'),
        'downloads' => get_option('woocommerce_myaccount_downloads_endpoint', 'downloads'),
        'edit-address' => get_option('woocommerce_myaccount_edit_address_endpoint', 'edit-address'),
        'payment-methods' => get_option('woocommerce_myaccount_payment_methods_endpoint', 'payment-methods'),
        'edit-account' => get_option('woocommerce_myaccount_edit_account_endpoint', 'edit-account'),
        'customer-logout' => get_option('woocommerce_logout_endpoint', 'customer-logout'),
    ];

    $items = [
        'dashboard' => __('Dashboard', 'woocommerce'),
        'orders' => __('Orders', 'woocommerce'),
        'downloads' => __('Downloads', 'woocommerce'),
        'edit-address' => __('Addresses', 'woocommerce'),
        'payment-methods' => __('Payment methods', 'woocommerce'),
        'edit-account' => __('Account details', 'woocommerce'),
        'customer-logout' => __('Logout', 'woocommerce'),
    ];

    // Remove missing endpoints.
    foreach ($endpoints as $endpoint_id => $endpoint) {
        if (empty($endpoint)) {
            unset($items[$endpoint_id]);
        }
    }

    return apply_filters('woocommerce_account_menu_items', $items);
}

function negarshop_woocommerce_breadcrumb($defaults): array
{
    $breadcrumb_align = negarshop_option('breadcrumb_align');
    $breadcrumb_background = negarshop_option('breadcrumb_background');
    $breadcrumb_text_color = negarshop_option('breadcrumb_text_color');
    $breadcrumb_picker = negarshop_option('breadcrumb_background-picker');
    $breadcrumb_style_attributes = '';
    $full_width = false;
    $padding = false;
    $breadcrumb_class = 'site-breadcrumb--align-' . $breadcrumb_align;
    $breadcrumb_class .= ' site-breadcrumb--' . $breadcrumb_background;

    switch ($breadcrumb_background) {
        case 'color':
            $breadcrumb_style_attributes = sprintf('background-color: %s;', $breadcrumb_picker['color']['color']);
            $full_width = $breadcrumb_picker['color']['full'] === 'yes';
            $padding = $breadcrumb_picker['color']['padding'] ?? false;
            break;
        case 'image':
            $image_url = '';

            if (is_tax('product_cat') && $breadcrumb_picker['image']['smart'] === 'yes') {
                $category = get_queried_object();
                $thumb = get_term_meta($category->term_id, 'thumbnail_id', true);
                $image_url = empty($thumb) ? '' : wp_get_attachment_image_url((int)$thumb, 'full');
            }

            if (empty($image_url)) {
                $image_url = $breadcrumb_picker['image']['custom']['url'];
            }

            $breadcrumb_style_attributes = sprintf('background-image: url(%s);', $image_url);
            $full_width = $breadcrumb_picker['image']['full'] === 'yes';
            $padding = $breadcrumb_picker['color']['padding'] ?? false;
            break;

        default:
            break;
    }

    if (is_numeric($padding)) {
        $breadcrumb_style_attributes .= sprintf(' padding-top: %spx; padding-bottom: %spx;', $padding, $padding);
    }
    if (!empty($breadcrumb_text_color)) {
        $breadcrumb_style_attributes .= sprintf(' color: %s;', $breadcrumb_text_color);
    }
    if ($full_width) {
        $breadcrumb_class .= ' site-breadcrumb--full-width';
    }

    $wrap_before = sprintf('<div class="site-breadcrumb %s" style="%s">', $breadcrumb_class, $breadcrumb_style_attributes);
    $wrap_after = '</div>';

    if ($full_width) {
        $wrap_before = '</div>' . $wrap_before . '<div class="container">';
        $wrap_after .= '</div><div class="container">';
    }

    $defaults['wrap_before'] = $wrap_before . $defaults['wrap_before'];

    if (negarshop_option('breadcrumb_title') === 'yes' && is_archive()) {
        add_filter('get_the_archive_title_prefix', '__return_empty_string');
        $defaults['wrap_after'] .= '<h1 class="page-title">' . get_the_archive_title() . '</h1>';
        remove_filter('get_the_archive_title_prefix', '__return_empty_string');
    }

    $defaults['wrap_after'] = $defaults['wrap_after'] . $wrap_after;
    return $defaults;
}

/**
 * Generate product image height.
 *
 * @param $size
 * @return string
 */
function negarshop_woocommerce_image_height_builder($size)
{
    $size = explode('x', $size);
    if (empty($size)) {
        return '100%';
    }

    $width = $size[0] ?? '1';
    $height = $size[1] ?? '1';

    if (!is_numeric($width) || !is_numeric($height)) {
        return '100%';
    }

    if ($width > 1) {
        $height -= $width - 1;
    }

    return ($height * 100) . '%';
}

function negarshop_product_related_posts_query($query, $product_id, $args)
{
    global $wpdb;

    $query['join'] .= " INNER JOIN {$wpdb->postmeta} as pm ON p.ID = pm.post_id ";
    $query['where'] .= " AND pm.meta_key = '_stock_status' AND meta_value = 'instock' ";

    return $query;
}

function negarshop_state_to_label($state)
{
    $states = [
        'ABZ' => 'البرز',
        'ADL' => 'اردبیل',
        'EAZ' => 'آذربایجان شرقی',
        'WAZ' => 'آذربایجان غربی',
        'BHR' => 'بوشهر',
        'CHB' => 'چهارمحال و بختیاری',
        'FRS' => 'فارس',
        'GIL' => 'گیلان',
        'GLS' => 'گلستان',
        'HDN' => 'همدان',
        'HRZ' => 'هرمزگان',
        'ILM' => 'ایلام',
        'ESF' => 'اصفهان',
        'KRN' => 'کرمان',
        'KRH' => 'کرمانشاه',
        'NKH' => 'خراسان شمالی',
        'RKH' => 'خراسان رضوی',
        'SKH' => 'خراسان جنوبی',
        'KHZ' => 'خوزستان',
        'KBD' => 'کهگیلویه و بویراحمد',
        'KRD' => 'کردستان',
        'LRS' => 'لرستان',
        'MKZ' => 'مرکزی',
        'MZN' => 'مازندران',
        'GZN' => 'قزوین',
        'QHM' => 'قم',
        'SMN' => 'سمنان',
        'SBN' => 'سیستان و بلوچستان',
        'THR' => 'تهران',
        'YZD' => 'یزد',
        'ZJN' => 'زنجان',
    ];

    return $states[$state] ?? $state;
}

add_filter('woocommerce_add_to_cart_fragments', 'negarshop_woocommerce_header_add_to_cart_fragment');
add_action('woocommerce_before_main_content', 'negarshop_woocommerce_before_main_content');
add_action('woocommerce_after_main_content', 'negarshop_woocommerce_after_main_content');
add_filter('woocommerce_enqueue_styles', '__return_empty_array');
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action('woocommerce_single_product_custom_title', 'woocommerce_template_single_meta');
add_action('woocommerce_after_product_attribute_settings', 'negarshop_action_woocommerce_after_product_attribute_settings', 10, 2);
add_action('woocommerce_single_product_summary_left', 'woocommerce_template_single_price');
add_action('woocommerce_single_product_summary_left', 'woocommerce_template_single_add_to_cart', 20);
add_action('woocommerce_before_add_to_cart_product_actions', 'negarshop_woocommerce_before_add_to_cart_product_actions');
add_action('woocommerce_single_product_summary_left', 'negarshop_woocommerce_single_product_summary_left', 1);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');
add_action('woocommerce_single_product_summary', 'negarshop_woocommerce_single_product_summary', 5);
remove_action('woocommerce_review_meta', 'woocommerce_review_display_meta', 10);
add_action('woocommerce_review_meta', 'negarshop_woocommerce_review_meta', 10);
add_filter('woocommerce_product_tabs', 'negarshop_product_tabs_customize', 20);
add_filter('woocommerce_account_menu_items', 'negarshop_woocommerce_account_menu_items', 10, 1);
add_action('woocommerce_before_shop_loop_item_title', 'negarshop_woocommerce_template_loop_product_second_thumbnail', 11, 1);
add_action('woocommerce_single_product_summary', 'negarshop_woocommerce_single_product_summary_tags', 41);
add_action('woocommerce_after_cart_item_name', 'negarshop_woocommerce_after_cart_item_name', 10, 2);
add_action('woocommerce_before_checkout_form', 'negarshop_cart_header_steps', 1);
add_action('woocommerce_before_cart', 'negarshop_cart_header_steps', 1);
add_action('woocommerce_before_thankyou', 'negarshop_cart_header_steps', 1);
remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form');
add_filter('woocommerce_empty_price_html', 'negarshop_woocommerce_empty_price_html', 99);
add_action('woocommerce_save_product_variation', 'negarshop_save_custom_field_variations', 10, 2);
add_filter('woocommerce_output_related_products_args', 'negarshop_related_products_fix', 20);
add_action('woocommerce_checkout_process', 'negarshop_delivery_checkout_field_process');
add_filter('woocommerce_checkout_fields', 'negarshop_woocommerce_checkout_fields');
add_action('woocommerce_checkout_update_order_meta', 'negarshop_delivery_checkout_field_update_order_meta');
add_filter('manage_edit-shop_order_columns', 'negarshop_delivery_order_column');
add_action('manage_shop_order_posts_custom_column', 'negarshop_delivery_order_column_content');
add_action('woocommerce_admin_order_data_after_billing_address', 'negarshop_delivery_checkout_field_display_admin_order_meta', 10, 1);
add_action('woocommerce_admin_order_data_after_shipping_address', 'negarshop_woocommerce_admin_order_data_after_shipping_address', 10, 1);
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'negarshop_woocommerce_dropdown_variation_attribute_options_html', 10, 2);
add_action('woocommerce_variation_options_pricing', 'negarshop_add_custom_field_to_variations', 10, 3);
add_action('woocommerce_save_product_variation', 'negarshop_save_gallery_custom_field_variations', 10, 2);
add_filter('woocommerce_available_variation', 'negarshop_add_images_to_variable');
add_filter('woocommerce_default_address_fields', 'negarshop_custom_override_default_locale_fields');
add_action('woocommerce_review_meta', 'negarshop_woocommerce_review_meta_badges', 9);
add_filter('woocommerce_show_variation_price', '__return_true');
add_filter('woocommerce_login_redirect', 'negarshop_wc_login_redirect');
add_filter('woocommerce_account_menu_items', 'negarshop_favs_add_premium_support_link_my_account');
add_action('woocommerce_archive_description', 'negarshop_wc_category_description');
add_action('woocommerce_before_single_product_summary', 'negarshop_woocommerce_before_single_product_summary_shipping_time', 30);
add_action('woocommerce_before_single_product_summary', 'negarshop_woocommerce_before_single_product_summary_alerts', 31);
add_action('woocommerce_single_product_summary', 'negarshop_woocommerce_single_product_summary_shipping_time', 4);
add_action('woocommerce_single_product_summary', 'negarshop_woocommerce_single_product_summary_product_alerts', 40);
add_filter('posts_clauses', 'negarshop_sort_by_stock');
add_filter('pre_get_posts', 'negarshop_pre_get_posts_shop');
add_action('wp_ajax_woocommerce_save_attributes', 'negarshop_ajax_woocommerce_save_attributes', 0);
add_action('admin_menu', 'negarshop_remove_product_metabox');
add_action('wp_ajax_negarshop_ajax_variable_product', 'negarshop_ajax_variable_product');
add_action('wp_ajax_nopriv_negarshop_ajax_variable_product', 'negarshop_ajax_variable_product');
add_action('wp_ajax_negarshop_3dview_ajax', 'negarshop_3dview_ajax');
add_action('wp_ajax_nopriv_negarshop_3dview_ajax', 'negarshop_3dview_ajax');
add_action('wp_ajax_negarshop_price_html', 'negarshop_price_html');
add_action('wp_ajax_nopriv_negarshop_price_html', 'negarshop_price_html');
add_action('wp_ajax_negarshop_email_sharing', 'negarshop_email_sharing');
add_action('wp_ajax_nopriv_negarshop_email_sharing', 'negarshop_email_sharing');
add_filter('woocommerce_output_related_products_args', 'negarshop_woocommerce_output_related_products_args');
add_action('ns_custom_add_to_cart_btn', 'negarshop_sale_product_timer');
add_action('ns_custom_add_to_cart_btn', 'negarshop_price_update_time');
add_filter('woocommerce_breadcrumb_defaults', 'negarshop_woocommerce_breadcrumb');
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
add_action('wp_footer', 'negarshop_print_threeview_popup');
add_action('wp_footer', 'negarshop_print_product_video_modal');
add_filter('woocommerce_product_related_posts_query', 'negarshop_product_related_posts_query', 10, 3);
remove_action('woocommerce_shop_loop_header', 'woocommerce_product_taxonomy_archive_header', 10);
