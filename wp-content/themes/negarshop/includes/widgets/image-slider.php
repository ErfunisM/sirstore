<?php

use Negarshop\Negarshop_Swiper;

/**
 * Image slider widget hooks and libraries.
 *
 * @package negarshop
 */

function negarshop_page_widget_slider($settings)
{

    $settings = wp_parse_args(
        $settings ?? array(),
        array(
            'swiper_options' => array(),
            'slides' => array(),
        )
    );

    $slider = new Negarshop_Swiper($settings['swiper_options']);
    ?>
    <div class="element-image-slider">
        <?php
        echo '<div class="main-slider">';
        $slider->start();
        $customPagination = "";
        if (!empty($settings['slides'])) :
            foreach ($settings['slides'] as $slide) :
                $slider->start_slide();

                $slide_image_classes = array(
                    'item-image--align-' . $slide['background_custom_align'],
                    'item-image--align-' . $slide['background_custom_vertical_align'],
                );

                $slide_content_classes = array(
                    'padding-large',
                    'item-inner--align-' . $slide['content_align'],
                    'item-inner--align-' . $slide['content_vertical_align'],
                );
                $customPagination .= sprintf('<span class="custom-pagination-item elementor-repeater-item-%s"><span></span></span>', esc_attr($slide['_id']));
                ?>
                <div class="slider-item elementor-repeater-item-<?php echo esc_attr($slide['_id']); ?>">
                    <?php
                    if ('slide' === $slide['link_mode'] && !empty($slide['link_attribute'])) {
                        // PHPCS - the variable $slide['link_attribute'] holds safe data.
                        printf('<a %s>', $slide['link_attribute']);//phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                    ?>
                    <div class="item-image <?php echo esc_attr(implode(' ', $slide_image_classes)); ?>"></div>
                    <div class="item-inner <?php echo esc_attr(implode(' ', $slide_content_classes)); ?>">
                        <?php
                        if ('container' === $slide['content_size']) {
                            echo '<div class="container">';
                        }
                        ?>
                        <?php if (!empty($slide['badge'])) : ?>
                            <div class="item-badge">
                                <span class="badge"><?php echo esc_html($slide['badge']); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($slide['title'])) : ?>
                            <h3 class="item-title"><?php echo esc_html($slide['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($slide['content'])) : ?>
                            <div class="item-description">
                                <?php
                                // PHPCS - the variable $slide['content'] holds safe data.
                                echo $slide['content']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                ?>
                            </div>
                        <?php endif; ?>
                        <?php if ('button' === $slide['link_mode'] && !empty($slide['link_label']) && !empty($slide['link_attribute'])) : ?>
                            <div class="item-buttons  margin-top-medium">
                                <a
                                    <?php
                                    // PHPCS - the variable $slide['link_attribute'] holds safe data.
                                    echo $slide['link_attribute']; //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                    ?>
                                        class="button button--white padding-x-large">
                                    <?php echo esc_html($slide['link_label']); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php
                        if ('container' === $slide['content_size']) {
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <?php
                    if ('slide' === $slide['link_mode']) {
                        echo '</a>';
                    }
                    ?>
                </div>
                <?php
                $slider->end_slide();
            endforeach;
        endif;
        $slider->set_pagination($customPagination);
        $slider->end();
        echo '</div>';

        if (!empty($settings['swiper_options']['pagination']['type']) && 'slider' === $settings['swiper_options']['pagination']['type']) {
            $thumbnailSlider = new Negarshop_Swiper([
                'slidesPerView' => 'auto',
                'spaceBetween' => 30,
            ]);
            echo '<div class="thumbnail-slider">';
            $thumbnailSlider->start();
            if (!empty($settings['slides'])) :
                foreach ($settings['slides'] as $slide) :
                    $thumbnailSlider->start_slide();
                    echo '<div class="thumb-item">';
                    if (!empty($slide['background_image']['id'])) {
                        echo '<div class="thumb-image">';
                        echo wp_get_attachment_image($slide['background_image']['id']);
                        echo '</div>';
                    }
                    printf('<div class="thumb-title">%s</div>', $slide['title']);
                    echo '</div>';
                    $thumbnailSlider->end_slide();
                endforeach;
            endif;
            $thumbnailSlider->end();
            echo '</div>';
        }
        ?>
    </div>
    <?php
}