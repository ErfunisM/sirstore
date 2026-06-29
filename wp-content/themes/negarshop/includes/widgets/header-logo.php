<?php
/**
 * Header logo widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_header_logo($data = array(), $classes = array('text-center'))
{
    $color_mode = (isset($data['cm'])) ? $data['cm'] : 'darken';
    if ($color_mode == "light") {
        $classes[] = "light-color-mode";
    }
    $class_attr = implode(' ', $classes);
    $url = (isset($data['url'])) ? '<a href="' . $data['url'] . '">' : '';
    echo '<div class="header-logo ' . $class_attr . '">' . $url;
    if (isset($data['image']) && !empty($data['image'])) {
        $alt = (isset($data['title'])) ? $data['title'] : get_bloginfo('name');
        echo '<img src="' . $data['image'] . '" alt="' . $alt . '">';
    } else if (isset($data['title'])) {
        echo '<h1>' . $data['title'] .'</h1>';
    }
    if ($url !== '') {
        echo "</a>";
    }
    echo '</div>';
}