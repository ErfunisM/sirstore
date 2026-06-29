<?php
/**
 * Footer copyright widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_footer_copyright($opts = []) {
    $classes = (isset($opts['class'])) ? $opts['class'] : '';
    $text = (isset($opts['text'])) ? $opts['text'] : '';
    $designer = (isset($opts['designer']) and $opts['designer'] == false) ? '' : '<a href="https://www.coderboy.ir" target="_blank" title="پسرک کدنویس">طراح: پسرک کدنویس</a>';
    echo '<div class="footer-copyright ' . $classes . '">';
    if (!empty($text)) {
        echo '<p>' . $text . '</p> ';
    }
    if (!empty($designer)) {
        echo $designer;
    }
    echo '</div>';
}

