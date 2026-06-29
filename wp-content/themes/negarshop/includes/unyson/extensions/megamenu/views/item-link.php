<?php if (!defined('FW')) die('Forbidden');

// file: {theme}/framework-customizations/extensions/megamenu/views/item-link.php

/**
 * @var WP_Post $item
 * @var string $title
 * @var array $attributes
 * @var object $args
 * @var int $depth
 */

{
    $icon_html = '';

    if (
        fw()->extensions->get('megamenu')->show_icon()
        &&
        ($icon = fw_ext_mega_menu_get_meta($item, 'icon'))
    ) {
        $url = wp_get_attachment_image_src($icon);
        if(isset($url[0]) and !empty($url[0])) {
            $icon_html = '<i class="item-icon" style="background-image: url(\'' . $url[0] . '\');"></i> ';
        }
    }
}

// Make a menu WordPress way
echo $args->before;
echo fw_html_tag('a', $attributes, $args->link_before . $icon_html . $title . $args->link_after);
echo $args->after;