<?php
/**
 * Views hooks and libraries.
 *
 * @package negarshop
 */

global $wpdb;

define('negarshop_views_table_name', $wpdb->prefix . 'cb_views');

if ($wpdb->get_var("SHOW TABLES LIKE '" . negarshop_views_table_name . "'") != negarshop_views_table_name) {
    //table not in database. Create new table
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE " . negarshop_views_table_name . " (
  id int(11) NOT NULL AUTO_INCREMENT,
  time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
  post int(11) NOT NULL,
  count int(11) NOT NULL,
  PRIMARY KEY  (id)
) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
} else {
    define('negarshop_views_ready', true);
}

function negarshop_check_view($id = null) {
    if ($id !== null and is_numeric($id)) {
        global $wpdb;
        $check = $wpdb->get_results("SELECT * FROM " . negarshop_views_table_name . " WHERE post = $id and time LIKE '" . date('Y-m-d ') . "%'");

        return (empty($check)) ? true : $check[0]->id;
    }
}

function negarshop_add_view($id = null) {
    if ($id == null) {
        global $post;
        $id = $post->ID;
    }
    global $wpdb;
    $ex_view_id = negarshop_check_view($id);
    $inset = false;
    if ($ex_view_id === true) {
        $inset = $wpdb->insert(negarshop_views_table_name, [
            'post' => $id,
            'count' => 1,
            'time' => date('Y-m-d H:i:s'),
        ]);
    } else {
        $user_count = $wpdb->get_var("SELECT count FROM " . negarshop_views_table_name . " WHERE id=" . $ex_view_id);
        $inset = $wpdb->update(negarshop_views_table_name, [
            'count' => intval($user_count) + 1,
        ], [
            'id' => $ex_view_id
        ]);
    }

    return $inset;
}

function negarshop_view_action() {
    if (is_single()) {
        negarshop_add_view();
    }
}

function negarshop_get_post_views($id = null, $range = 'all'): int {
    if ($id == null) {
        global $post;
        $id = $post->ID;
    }
    $count = 0;
    $date_wh = '';
    switch ($range) {
        case 'today':
            $date_wh = " and time LIKE '" . date('Y-m-d ') . "%'";
            break;
        case 'month':
            $date_wh = " and time LIKE '" . date('Y-m-') . "%'";
            break;
        case 'year':
            $date_wh = " and time LIKE '" . date('Y-') . "%'";
            break;
        default:
            $date_wh = '';
            break;
    }
    global $wpdb;
    $cnt_array = $wpdb->get_results("SELECT * FROM " . negarshop_views_table_name . " WHERE post = $id" . $date_wh);
    foreach ($cnt_array as $item) {
        $count += (int)$item->count;
    }

    return $count;
}

function negarshop_get_date_views($range = '7day'): array {
    $posts = [];
    $first_date = '0000-00-00 00:00:00';
    $second_date = '0000-00-00 00:00:00';


    switch ($range) {
        case 'today':
            $first_date = date('Y-m-d') . ' 00:00:00';
            $second_date = date('Y-m-d') . ' 23:59:59';
            break;
        case '7day':
            $first_date = date('Y-m-d H:i:s', strtotime('-1 week'));
            $second_date = date('Y-m-d H:i:s');
            break;
        case 'last_month':
            $first_date = date('Y-m-01 00:00:00', strtotime('-1 month'));
            $second_date = date('Y-m-01 00:00:00');
            break;
        case 'month':
            $first_date = date('Y-m-01 00:00:00');
            $second_date = date('Y-m-d H:i:s');
            break;
        case 'year':
            $first_date = date('Y-01-01 00:00:00');
            $second_date = date('Y-m-d H:i:s');
            break;
        default:
            break;
    }


    $query = "SELECT * FROM " . negarshop_views_table_name . " WHERE time BETWEEN '$first_date' AND '$second_date' order by count DESC";
    global $wpdb;
    $results = $wpdb->get_results($query);
    foreach ($results as $result) {
        if (!in_array($result->post, $posts)) {
            $posts[] = $result->post;
        }
    }

    return $posts;
}

function negarshop_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function negarshop_post_view_count() {
    if (is_single()) {
        global $post;
        negarshop_set_post_views($post->ID);
    }
}


add_action('wp_head', 'negarshop_view_action');
add_action('wp_head', 'negarshop_post_view_count');