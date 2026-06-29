<?php
/**
 * Footer socials widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_footer_socials($opts = []) {
    $classes = (isset($opts['class'])) ? $opts['class'] : '';
    $title = (isset($opts['title'])) ? $opts['title'] : '';
    $socials = (isset($opts['socials'])) ? $opts['socials'] : [];
    echo '<div class="footer-socials ' . $classes . '">';
    if (!empty($title)) {
        echo '<h6 class="title">' . $title . '</h6>';
    }
    if (!empty($socials)) {
        echo '<ul>';
        foreach ($socials as $social) {
            $link = (isset($social['link'])) ? $social['link'] : '';
            $icon = (isset($social['icon'])) ? $social['icon'] : '';
            echo '<li><a target="_blank" href="' . $link . '"><i class="' . $icon . '"></i></a></li>';
        }
        echo '</ul>';
    }
    echo '</div>';
}