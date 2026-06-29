<?php
{
    remove_filter('wp_nav_menu_args', '_filter_fw_ext_mega_menu_wp_nav_menu_args');

    /** @internal */
    function _filter_theme_ext_mega_menu_wp_nav_menu_args($args) {
        if(isset($args['mega_menu']) and $args['mega_menu'] == true){
        $args['walker'] = new FW_Ext_Mega_Menu_Custom_Walker();
        }
        return $args;
    }
    add_filter('wp_nav_menu_args', '_filter_theme_ext_mega_menu_wp_nav_menu_args');
}