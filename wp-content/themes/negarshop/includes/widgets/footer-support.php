<?php
/**
 * Footer support widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_footer_support($opts = []) {
    $classes = (isset($opts['class'])) ? $opts['class'] : '';
    $icon = (isset($opts['icon'])) ? $opts['icon'] : '';
    $title = (isset($opts['title'])) ? $opts['title'] : '';
    $sub_title = (isset($opts['sub'])) ? $opts['sub'] : '';
    $link = (isset($opts['link'])) ? $opts['link'] : '';

    echo '<div class="support-times ' . $classes . '">';
    if (!empty($link)) {
        echo '<a href="' . $link . '">';
    }
    if (!empty($icon)) {
        echo '<i class="' . $icon . '"></i>';
    }
    if (!empty($title)) {
        echo '<span class="text">' . $title . '</span>';
    }
    if (!empty($sub_title)) {
        echo '<span class="phone-no">' . $sub_title . '</span>';
    }
    if (!empty($link)) {
        echo '</a>';
    }
    echo '</div>';
}