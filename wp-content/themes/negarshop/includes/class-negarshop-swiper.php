<?php

namespace Negarshop;

/**
 * Swiper Carousel class.
 */
class Negarshop_Swiper
{
    /**
     * List of carousel options.
     *
     * @var array
     */
    private array $options = array();

    /**
     * Slide item index.
     *
     * @var int
     */
    private int $slides_count = 0;

    private string $pagination = '';

    /**
     * Check carousel option.
     *
     * @param string $name Option name.
     *
     * @return mixed
     */
    private function get_option(string $name)
    {
        if (!empty($this->options[$name])) {
            return $this->options[$name];
        }

        if (empty($this->options['breakpoints']) || !is_array($this->options['breakpoints'])) {
            return false;
        }

        foreach ($this->options['breakpoints'] as $breakpoint) {
            if (!empty($breakpoint[$name])) {
                return $breakpoint[$name];
            }
        }

        return false;
    }

    /**
     * Class constructor.
     *
     * @param array $options Swiper carousel options.
     */
    public function __construct(array $options = array())
    {
        $this->options = $options;
    }

    /**
     * Start carousel.
     *
     * @param array $arguments Additional classes.
     *
     * @return void
     */
    public function start(array $arguments = array())
    {
        $arguments = wp_parse_args(
            $arguments,
            array(
                'carousel_class' => '',
                'wrapper_class' => '',
            )
        );
        global $negarshop_swiper_carousel;
        $negarshop_swiper_carousel = $this->options;
        echo '<div class="slider-container">';
        $this->start_carousel($arguments['carousel_class']);
        $this->start_wrapper($arguments['wrapper_class']);
    }

    /**
     * End of carousel.
     *
     * @return void
     */
    public function end()
    {
        $this->end_wrapper();
        $this->scrollbar();
        $this->end_carousel();
        $this->navigation();
        $this->pagination();

        echo '</div>';

        unset($GLOBALS['negarshop_swiper_carousel']);
    }

    /**
     * Start carousel wrapper.
     *
     * @param string $additional_class Additional classes.
     *
     * @return void
     */
    public function start_carousel(string $additional_class = '')
    {
        if (!empty($this->options['overflow']) && 'visible' === $this->options['overflow']) {
            $additional_class = 'overflow-visible';
        }
        printf('<div class="swiper%s" dir="rtl" data-settings="%s">', esc_attr(empty($additional_class) ? '' : ' ' . $additional_class), esc_attr(wp_json_encode($this->options)));
    }

    /**
     * End of carousel.
     *
     * @return void
     */
    public function end_carousel()
    {
        echo '</div>';
    }

    /**
     * Start carousel wrapper.
     *
     * @param string $additional_class Additional classes.
     *
     * @return void
     */
    public function start_wrapper(string $additional_class = '')
    {
        printf('<div class="swiper-wrapper%s">', esc_attr(empty($additional_class) ? '' : ' ' . $additional_class));
    }

    /**
     * End of carousel wrapper.
     *
     * @return void
     */
    public function end_wrapper()
    {
        echo '</div>';
    }

    /**
     * Start carousel slide item.
     *
     * @param string $additional_class Additional classes.
     *
     * @return void
     */
    public function start_slide(string $additional_class = '')
    {
        ++$this->slides_count;
        printf('<div class="swiper-slide slide-item-%s %s">', esc_attr($this->slides_count), esc_attr(empty($additional_class) ? '' : ' ' . $additional_class));
    }

    /**
     * Get Slide Index.
     *
     * @return int
     */
    public function index(): int
    {
        return $this->slides_count;
    }

    /**
     * End of carousel slide item.
     *
     * @return void
     */
    public function end_slide()
    {
        echo '</div>';
    }

    /**
     * Set custom pagination for carousel.
     *
     * @param string $pagination_item
     * @return void
     */
    public function set_pagination(string $pagination_item)
    {
        $this->pagination = $pagination_item;
    }

    /**
     * Carousel pagination.
     *
     * @return void
     */
    public function pagination()
    {
        $pagination = $this->get_option('pagination');
        if (false === $pagination || !is_array($pagination)) {
            return;
        }
        if (!empty($this->pagination) && $this->get_option('imaged_bullets') === true) {
            echo '<div class="pagination-custom-templates">';
            echo $this->pagination;
            echo '</div>';
        }
        $pagination = wp_parse_args(
            $pagination,
            array(
                'el' => '.carousel-pagination',
                'position' => 'inside',
                'vertical_align' => 'middle',
                'horizontal_align' => 'center',
            )
        );

        $pagination_classes = ltrim($pagination['el'], '.');

        if ('outside' === $pagination['position']) {
            $pagination_classes .= ' slider-pagination--outside';
        }
        $pagination_classes .= ' slider-pagination--align-' . $pagination['vertical_align'];
        $pagination_classes .= ' slider-pagination--align-' . $pagination['horizontal_align'];

        printf('<div class="swiper-pagination slider-pagination %s"></div>', esc_attr($pagination_classes));
    }

    /**
     * Carousel navigation.
     *
     * @return void
     */
    public function navigation()
    {
        $navigation = $this->get_option('navigation');

        if (false === $navigation || !is_array($navigation)) {
            return;
        }
        $navigation = wp_parse_args(
            $navigation,
            array(
                'nextEl' => '.carousel-prev-button',
                'prevEl' => '.carousel-next-button',
                'position' => 'inside',
                'vertical_align' => 'middle',
                'horizontal_align' => 'center',
                'mode' => 'expanded',
            )
        );

        $navigation_classes = ' slider-buttons--' . $navigation['position'];

        $navigation_classes .= ' slider-buttons--align-' . $navigation['vertical_align'];
        $navigation_classes .= ' slider-buttons--' . $navigation['mode'];

        if ('compact' === $navigation['mode']) {
            $navigation_classes .= ' slider-buttons--align-' . $navigation['horizontal_align'];
        }

        printf('<div class="slider-buttons %s">', esc_attr($navigation_classes));
        printf('<div class="swiper-button-prev slider-button slider-button--prev %s"></div>', esc_attr(ltrim($navigation['prevEl'], '.')));
        printf('<div class="swiper-button-next slider-button slider-button--next %s"></div>', esc_attr(ltrim($navigation['nextEl'], '.')));
        echo '</div>';
    }

    /**
     * Carousel scrollbar.
     *
     * @return void
     */
    public function scrollbar()
    {
        $scrollbar = $this->get_option('scrollbar');
        if (false === $scrollbar || !is_array($scrollbar)) {
            return;
        }
        $scrollbar = wp_parse_args(
            $scrollbar,
            array(
                'el' => '.carousel-scrollbar',
            )
        );

        printf('<div class="swiper-scrollbar %s"></div>', esc_attr(ltrim($scrollbar['el'], '.')));
    }
}