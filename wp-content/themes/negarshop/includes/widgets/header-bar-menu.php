<?php
/**
 * Bar menu widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_header_bar_menu($location_name = array('loc' => 'top'), $classes = array('text-right'))
{
    $class_attr = implode(' ', $classes);
    echo '<div class="' . $class_attr . '">';
    if (isset($location_name['id']) or has_nav_menu($location_name['loc'])) :
        echo '<nav class="top-bar">';
        $menu_args = array(
            'menu_class' => 'top-menu',
            'items_wrap' => '<ul id="%1$s" class="%2$s" tabindex="0">%3$s</ul>',
            'container' => false
        );
        if (isset($location_name['id'])) {
            $menu_args['menu'] = $location_name['id'];
        } else if (isset($location_name['loc'])) {
            $menu_args['theme_location'] = $location_name['loc'];
        }
        wp_nav_menu($menu_args);
        echo '</nav>';
    endif;
    echo '</div>';
}