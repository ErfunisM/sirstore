<?php
function negarshop_factor_shop_orders_table_columns($defaults)
{
    $defaults['ns-factor'] = 'فاکتور ساز';
    return $defaults;
}

function negarshop_factor_shop_order_column_value($column)
{
    if ($column !== 'ns-factor') {
        return;
    }
    global $post, $the_order;

    if (!is_a($the_order, 'WC_Order')) {
        $the_order = wc_get_order($post->ID);
    }

    printf('<a class="button wc-action-button" href="%s" aria-label="">ساخت فاکتور</a>', add_query_arg([
        'action' => 'factor',
        'post' => $post->ID
    ], admin_url('post.php')));
}

function negarshop_factor_generator_page_content($post_id)
{
    if ('shop_order' !== get_post_type($post_id)) {
        return;
    }
    global $order;
    $order = wc_get_order($post_id);

    include_once get_template_directory() . '/template-parts/admin/order-factor.php';
    die();
}

/**
 * Get the previous post ID based on the current post ID.
 *
 * @param int $current_post_id The ID of the current post.
 * @return int|false The previous post ID, or false if no previous post is found.
 */
function get_previous_post_id($current_post_id)
{
    $post = get_post($current_post_id);
    if (empty($post)) {
        return false;
    }

    global $wpdb;
    $results = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_type = '{$post->post_type}' AND ID < {$post->ID} ORDER BY ID DESC LIMIT 0,1", ARRAY_A);

    if (!empty($results) && !empty($results[0]['ID'])) {
        return $results[0]['ID'];
    }

    return false;
}

/**
 * Get the next post ID based on the current post ID.
 *
 * @param int $current_post_id The ID of the current post.
 * @return int|false The ID of the next post, or false if not found.
 */
function get_next_post_id($current_post_id)
{
    $post = get_post($current_post_id);
    if (empty($post)) {
        return false;
    }

    global $wpdb;
    $results = $wpdb->get_results("SELECT ID FROM {$wpdb->posts} WHERE post_type = '{$post->post_type}' AND ID > {$post->ID} ORDER BY ID ASC LIMIT 0,1", ARRAY_A);

    if (!empty($results) && !empty($results[0]['ID'])) {
        return $results[0]['ID'];
    }

    return false;
}

function negarshop_factor_metabox_html()
{

    $the_order = wc_get_order(sanitize_text_field($_GET['id'] ?? 0));
    if (!($the_order instanceof WC_Order)) {
        return;
    }

    printf('<a class="button wc-action-button" href="%s" aria-label="">ساخت فاکتور</a>', add_query_arg([
        'action' => 'factor',
        'post' => $the_order->get_id()
    ], admin_url('post.php')));
}

function negarshop_add_factor_metabox()
{
    add_meta_box('negarshop-order-item-factor', 'فاکتورساز - نگارشاپ', 'negarshop_factor_metabox_html', 'woocommerce_page_wc-orders', 'side', 'high');
}


add_filter('manage_edit-shop_order_columns', 'negarshop_factor_shop_orders_table_columns');
add_action('manage_shop_order_posts_custom_column', 'negarshop_factor_shop_order_column_value');
add_action('post_action_factor', 'negarshop_factor_generator_page_content');
add_action('add_meta_boxes', 'negarshop_add_factor_metabox');
