<?php
/**
 * Footer about widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_footer_about($opts = []) {
    $classes = (isset($opts['class'])) ? $opts['class'] : '';
    $logo = (isset($opts['logo'])) ? $opts['logo'] : '';
    $title = (isset($opts['title'])) ? $opts['title'] : '';
    $desc = (isset($opts['desc'])) ? $opts['desc'] : '';

    echo '<div class="about-site ' . $classes . '">';
    if (!empty($logo)) {
        echo '<div class="logo"><img src="' . $logo . '" alt="' . $title . '"></div>';
    }
    echo '<div class="text">';
    if (!empty($title)) {
        if (is_home()) {
            echo '<h1 class="title">' . $title . '</h1>';
        } else {
            echo '<h2 class="title">' . $title . '</h2>';
        }
    }
    if (!empty($desc)) {
        echo '<p class="desc">' . $desc . '</p>';
    }
    echo '</div>';
    echo '</div>';
}