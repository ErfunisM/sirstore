<?php
/**
 * Negarshop product compare functions.
 *
 * @package negarshop
 */

/**
 * Render compare container html.
 *
 * @return void
 */
function negarshop_product_compare_container() {
    if (negarshop_option('negarshop_compare') !== 'true') {
        return;
    }
    ?>
    <div class="negarshop-product-compare">
        <div class="compare-header">
            <h6 class="header-title"><?php _e('مقایسه محصولات', 'negarshop'); ?></h6>
            <div class="header-buttons">
                <button class="button button-add-new" type="button">
                    <?php _e('افزودن محصول', 'negarshop'); ?>
                    <i class="fas fa-plus"></i>
                </button>

                <div class="compare-product-search-popup">
                    <?php
                    negarshop_header_search([
                        'search_mode' => 'compare',
                        'search_post_type' => 'product',
                        'search_ajax' => 'true',
                        'search_placeholder' => 'جستجو محصول برای مقایسه...'
                    ]);
                    ?>
                </div>
                <button type="button" class="button buttons-close"
                        title="<?php _e('بستن مقایسه محصولات', 'negarshop'); ?>">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="compare-content">
            <div class="compare-items">
                <?php echo negarshop_product_compare_table_builder(); ?>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Get list of compared products.
 *
 * @return array
 */
function negarshop_get_compared_products(): array {
    if (is_user_logged_in()) {
        $compareProductsList = get_user_meta(get_current_user_id(), 'negarshop_compared_products', true);
    } else {
        $compareProductsList = empty($_COOKIE['negarshop_compared_products']) ? [] : explode(',', $_COOKIE['negarshop_compared_products']);
    }
    if (!is_array($compareProductsList)) {
        return [];
    }
    return $compareProductsList;
}

/**
 * Add new product to compare list.
 *
 * @param $productID
 * @return bool
 */
function negarshop_add_compare_product($productID): bool {
    if (get_post_status($productID) !== 'publish') {
        return false;
    }
    $compareProductsList = negarshop_get_compared_products();
    $compareProductsList[] = $productID;
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), 'negarshop_compared_products', $compareProductsList);
    }
    return true;
}

/**
 * Remove a product from compare list.
 *
 * @param $productID
 * @return bool
 */
function negarshop_remove_compare_product($productID): bool {
    if (get_post_status($productID) !== 'publish') {
        return false;
    }
    $compareProductsList = negarshop_get_compared_products();
    if (($key = array_search($productID, $compareProductsList)) !== false) {
        unset($compareProductsList[$key]);
    }
    if (is_user_logged_in()) {
        update_user_meta(get_current_user_id(), 'negarshop_compared_products', $compareProductsList);
    }
    return true;
}

/**
 * Check product is in compare list.
 *
 * @param $productID
 * @return bool
 */
function negarshop_in_compare_list($productID): bool {
    $compareProductsList = negarshop_get_compared_products();
    return in_array($productID, $compareProductsList);
}

/**
 * Render compared products table.
 *
 * @return string
 */
function negarshop_product_compare_table_builder(): string {
    $compareProductsList = negarshop_get_compared_products();
    ob_start();
    $products_query = new WP_Query([
        'post_status' => 'publish',
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post__in' => array_slice($compareProductsList, 0, negarshop_option('compare_count_limit'))
    ]);
    $comparedProducts = [];
    $attributesList = [];
    if (!empty($compareProductsList) && $products_query->have_posts()) {
        $exclude_attributes = negarshop_option('exclude_compare_attributes');
        if (!is_array($exclude_attributes)) {
            $exclude_attributes = [];
        }
        while ($products_query->have_posts()) {
            $products_query->the_post();
            $product = wc_get_product(get_the_ID());
            $comparedProducts[] = [
                'id' => $product->get_id(),
                'link' => $product->get_permalink(),
                'title' => $product->get_title(),
                'thumbnail' => $product->get_image(),
                'attributes' => array_filter($product->get_attributes(), 'wc_attributes_array_filter_visible'),
                'price' => $product->get_price_html()
            ];
            if (!empty(array_filter($product->get_attributes(), 'wc_attributes_array_filter_visible'))) {
                foreach (array_filter($product->get_attributes(), 'wc_attributes_array_filter_visible') as $key => $item) {
                    /**
                     * @var WC_Product_Attribute $item
                     */

                    if (isset($attributesList[$key]) || in_array($item->get_name(), $exclude_attributes)) {
                        continue;
                    }

                    $attributesList[$key] = $item->get_name();
                }
            }
        }
    }

    if (empty($compareProductsList)) {
        ?>

        <div class="empty-compare-list">
            <?php _e('لیست مقایسه محصولات شما خالی می باشد!', 'negarshop'); ?>
        </div>


        <?php
        return ob_get_clean();
    }

    ?>
    <div class="table-header">
        <table>
            <tbody>
            <tr>
                <th><?php _e('محصولات', 'negarshop'); ?></th>
                <?php
                if (!empty($comparedProducts)):
                    foreach ($comparedProducts as $product):
                        ?>
                        <td>
                            <h2 class="item-title"><a
                                        href="<?php echo esc_attr($product['link']); ?>"><?php echo $product['title']; ?></a>
                            </h2>
                        </td>
                    <?php
                    endforeach;
                endif;
                ?>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="table-footer">
        <table>
            <tbody>
            <tr>
                <th></th>
                <?php
                if (!empty($comparedProducts)):
                    foreach ($comparedProducts as $product):
                        ?>
                        <td class="item-remove">
                            <button class="btn btn-transparent negarshop-remove-from-compare"
                                    data-nonce="<?php echo wp_create_nonce('negarshop_compare_nonce'); ?>"
                                    data-product-id="<?php echo esc_attr($product['id']); ?>" type="button">
                                <i class="far fa-remove"></i>
                                حذف محصول
                            </button>
                        </td>
                    <?php
                    endforeach;
                endif;
                ?>
            </tr>

            <tr>
                <th></th>

                <?php
                if (!empty($comparedProducts)):
                    foreach ($comparedProducts as $product):
                        ?>
                        <td>
                            <figure class="item-thumbnail">
                                <?php echo $product['thumbnail']; ?>
                            </figure>
                        </td>
                    <?php
                    endforeach;
                endif;
                ?>
            </tr>

            <?php
            if (!empty($attributesList)):
                foreach (array_keys($attributesList) as $item):
                    ?>
                    <tr class="item-attributes">
                        <th><?php echo wc_attribute_label($attributesList[$item]); ?></th>

                        <?php
                        if (!empty($comparedProducts)):
                            foreach ($comparedProducts as $product):
                                ?>
                                <td>
                                <span class="attribute-item"><?php
                                    if (isset($product['attributes'][$item])) {
                                        if ($product['attributes'][$item]->is_taxonomy()) {
                                            $parsed_attributes = [];
                                            $attribute_values = wc_get_product_terms($product['id'], $product['attributes'][$item]->get_name(), array('fields' => 'all'));
                                            if (!empty($attribute_values)) {
                                                foreach ($attribute_values as $attribute_value) {
                                                    $parsed_attributes[] = $attribute_value->name;
                                                }
                                            }


                                        } else {
                                            $parsed_attributes = $product['attributes'][$item]->get_options();
                                        }
                                        echo wc_implode_text_attributes($parsed_attributes);
                                    }
                                    ?></span>
                                </td>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </tr>
                <?php
                endforeach;
            endif;
            ?>
            <tr>
                <th>قیمت</th>

                <?php
                if (!empty($comparedProducts)):
                    foreach ($comparedProducts as $product):
                        ?>
                        <td class="item-price price">
                            <?php echo $product['price']; ?>
                        </td>
                    <?php
                    endforeach;
                endif;
                ?>

            </tr>
            <tr>
                <th></th>

                <?php
                if (!empty($comparedProducts)):
                    foreach ($comparedProducts as $product):
                        ?>
                        <td class="item-add-to-cart">
                            <?php echo negarshop_add_to_cart_btn($product['id'], '<i class="far fa-shopping-cart"></i> ' . __('افزودن به سبد خرید', 'negarshop'), 'btn btn-primary',
                                '99999999'); ?>
                        </td>
                    <?php
                    endforeach;
                endif;
                ?>
            </tr>
            </tbody>
        </table>
    </div>
    <?php

    return ob_get_clean();
}

function negarshop_add_to_compare_ajax() {
    $response = [
        'status' => false,
        'message' => __('خطایی هنگام افزودن محصول به جدول مقایسه رخ داد!', 'negarshop'),
        'content' => '',
        'count' => '',
        'style' => 'danger'
    ];
    if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
    } else {
        wp_send_json($response);
        return;
    }

    if (negarshop_add_compare_product($product_id)) {
        $productsCount = negarshop_get_compared_products();
        $response['status'] = true;
        $response['message'] = __('محصول با موفقیت به جدول مقایسه اضافه شد!', 'negarshop');
        $response['content'] = negarshop_product_compare_table_builder();
        $response['count'] = count($productsCount);
        $response['style'] = 'success';
    } else {
        $response['message'] = __('محصول مورد نظر یافت نشد!', 'negarshop');
    }

    wp_send_json($response);
}

function negarshop_remove_from_compare_ajax() {
    $response = [
        'status' => false,
        'message' => __('خطایی هنگام حذف محصول از جدول مقایسه رخ داد!', 'negarshop'),
        'content' => '',
        'style' => 'danger'
    ];
    if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
    } else {
        wp_send_json($response);
        return;
    }

    if (negarshop_remove_compare_product($product_id)) {
        $productsCount = negarshop_get_compared_products();
        $response['status'] = true;
        $response['message'] = __('محصول با موفقیت از جدول مقایسه حذف شد!', 'negarshop');
        $response['content'] = negarshop_product_compare_table_builder();
        $response['count'] = count($productsCount);
        $response['style'] = 'success';
    } else {
        $response['message'] = __('محصول مورد نظر یافت نشد!', 'negarshop');
    }

    wp_send_json($response);
}


add_action('wp_footer', 'negarshop_product_compare_container');
add_action("wp_ajax_negarshop_add_to_compare_ajax", "negarshop_add_to_compare_ajax");
add_action("wp_ajax_nopriv_negarshop_add_to_compare_ajax", "negarshop_add_to_compare_ajax");
add_action("wp_ajax_negarshop_remove_from_compare_ajax", "negarshop_remove_from_compare_ajax");
add_action("wp_ajax_nopriv_negarshop_remove_from_compare_ajax", "negarshop_remove_from_compare_ajax");