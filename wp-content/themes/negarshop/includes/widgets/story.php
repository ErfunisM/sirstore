<?php
/**
 * Elementor story widget template.
 *
 * @param array $settings
 * @return void
 */
function negarshop_page_widget_story(array $settings = array())
{
    if (empty($settings['items'])) {
        return;
    }
    echo '<div class="widget-story">';
    echo '<div class="story-items owl-carousel">';
    foreach ($settings['items'] as $item) {
        $itemID = $settings['id'] . sha1(json_encode($item));
        printf('<div class="item story-item active elementor-repeater-item-%s" data-id="%s">', esc_attr($item['_id']), esc_attr($itemID));
        echo '<div class="item-content"></div>';
        echo '</div>';
    }
    echo '</div>';
    echo '<div class="story-viewport">';
    echo '<div class="viewport-dismisser"></div>';
    echo '<div class="viewport-wrapper">';
    echo '<div class="owl-carousel view-carousel">';
    foreach ($settings['items'] as $item) {
        $itemID = $settings['id'] . sha1(json_encode($item));
        printf('<div class="item elementor-repeater-item-%s" data-id="%s">', esc_attr($item['_id']), esc_attr($itemID));
        if (!empty($item['link']['url'])) {
            printf('<a href="%s" target="_blank">', esc_url($item['link']['url']));
        }
        echo '<div class="item-content"></div>';
        if (!empty($item['link']['url'])) {
            echo '</a>';
        }
        echo '</div>';
    }
    echo '</div>';
    echo '<button type="button" class="close-stories"><i class="far fa-times"></i></button>';
    echo '</div>';
    echo '</div>';

    echo '</div>';
}