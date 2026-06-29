<?php
/**
 * Footer steps widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_footer_steps($opts = []) {
    $items = $opts['steps'];
    if (!empty($items)) {
        echo '<div class="shopping-features ' . $opts['style'] . ' ' . $opts['color_mode'] . '-color-mode"><div class="row">';
        foreach ($items as $item) {
            echo '<div class="col-lg">';
            echo '<div class="item">';
            if (!empty($item['url'])) {
                echo '<a href="' . $item['url'] . '">';
            }
            if (!empty($item['icon'])) {
                echo '<span class="icon"><i class="' . $item['icon'] . '"></i></span>';
            }
            if (!empty($item['title'])) {
                echo '<span class="title">' . $item['title'] . '</span>';
            }
            if (!empty($item['desc'])) {
                echo '<span class="desc">' . $item['desc'] . '</span>';
            }
            if (!empty($item['url'])) {
                echo '</a>';
            }
            echo '</div>';
            echo '</div>';
        }
        echo '</div></div>';
    }
}