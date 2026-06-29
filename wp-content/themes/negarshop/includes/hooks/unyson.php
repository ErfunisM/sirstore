<?php
/**
 * Unyson hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_framework_customizations_dir_rel_path($rel_path): string {
    return '/includes/unyson';
}

function negarshop_fw_ext_backups_db_export_exclude_option($exclude, $option_name, $is_full_backup) {
    if (!$is_full_backup) {
        if ($option_name === 'wp_inc_cloud') {
            return true;
        }
    }

    return $exclude;
}

function negarshop_fw_ext_backups_db_restore_exclude_option($exclude, $option_name, $is_full) {
    if (!$is_full) {
        if ($option_name === 'wp_inc_cloud') {
            return true;
        }
    }

    return $exclude;
}

function negarshop_fw_ext_backups_db_restore_keep_options($options, $is_full) {
    if (!$is_full) {
        $options['template'] = true;
        $options['stylesheet'] = true;
        $options['wp_inc_cloud'] = true;
    }

    return $options;
}

function negarshop_fw_mega_menu_icon_customizations($option) {
    $option['type'] = 'upload';
    $option['label'] = 'بارگذاری آیکن';
    $option['images_only'] = true;
    $option['value'] = ['url' => ''];

    return $option;
}

$GLOBALS['ns_theme_options'] = [];

function negarshop_is_demo(): bool {
    return strpos(site_url(), 'coderboy.ir') !== false || strpos(site_url(), 'localhost/negarshop') !== false;
}

function negarshop_is_localhost(): bool {
    return $_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1';
}

function negarshop_option($opt_name = "", $opt_type = "settings", $id = 0, $common = false) {
    if (negarshop_is_demo()) {
        if (isset($_GET['single_type']) && $_GET['single_type'] === "3") {
            if ($opt_name === "product_single_type") {
                return "type-3";
            }

            if ($opt_name === "site_radius") {
                return "10";
            }

            if ($opt_name === "product_tab_styles") {
                return "style-5";
            }
        }
    }

    if (!defined('FW')) {
        return false;
    }

    if ($opt_type == "settings") {

        if (($common or $opt_name == "main_color") and is_page() and (fw_get_db_post_option(get_the_ID(), "page_styles") == "true") and get_the_id() != get_option('page_on_front')) {

            if (!isset($GLOBALS['ns_theme_options']['post_' . get_the_ID() . '_' . $opt_name])) {
                $GLOBALS['ns_theme_options']['post_' . get_the_ID() . '_' . $opt_name] = function_exists('fw_get_db_post_option') ? fw_get_db_post_option(get_the_ID(), $opt_name) : '';
            }

            return $GLOBALS['ns_theme_options']['post_' . get_the_ID() . '_' . $opt_name];
        }

        if (!isset($GLOBALS['ns_theme_options'][$opt_name])) {
            $GLOBALS['ns_theme_options'][$opt_name] = function_exists('fw_get_db_settings_option') ? fw_get_db_settings_option($opt_name) : '';
        }

        return $GLOBALS['ns_theme_options'][$opt_name];
    } else if ($opt_type == "posts") {
        if (!isset($GLOBALS['ns_theme_options']['post_' . $id . '_' . $opt_name])) {
            $GLOBALS['ns_theme_options']['post_' . $id . '_' . $opt_name] = function_exists('fw_get_db_post_option') ? fw_get_db_post_option($id, $opt_name) : '';
        }

        return $GLOBALS['ns_theme_options']['post_' . $id . '_' . $opt_name];
    }

    return false;
}

function negarshop_unyson_loaded() {
    fw()->extensions->manager->activate_extensions(['megamenu' => 1]);
}

function negarshop_admin_bar_menu_theme_settings($wp_admin_bar) {
    $args = array(
        'id' => 'negarshop-theme-options',
        'title' => 'تنظیمات قالب',
        'href' => admin_url('themes.php?page=fw-settings')
    );
    $wp_admin_bar->add_node($args);
}


add_filter('fw_framework_customizations_dir_rel_path', 'negarshop_framework_customizations_dir_rel_path');
add_filter('fw_ext_backups_db_export_exclude_option', 'negarshop_fw_ext_backups_db_export_exclude_option', 10, 3);
add_filter('fw_ext_backups_db_restore_exclude_option', 'negarshop_fw_ext_backups_db_restore_exclude_option', 10, 3);
add_filter('fw_ext_backups_db_restore_keep_options', 'negarshop_fw_ext_backups_db_restore_keep_options', 10, 2);
add_filter('fw:ext:megamenu:icon-option', 'negarshop_fw_mega_menu_icon_customizations');
remove_filter('wp_get_update_data', ['FW_Extension_Update', '_filter_update_data'], 10);
add_action('fw_init', 'negarshop_unyson_loaded');
add_action('admin_bar_menu', 'negarshop_admin_bar_menu_theme_settings', 50);