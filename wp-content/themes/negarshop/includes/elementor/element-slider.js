(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/negarshop_image_slider.default', function ($scope) {

            let thumbnailSlider = $scope.find('.thumbnail-slider .swiper');

            if (thumbnailSlider.length > 0) {
                thumbnailSlider = new Swiper(thumbnailSlider[0], JSON.parse(thumbnailSlider.attr('data-settings')))
            } else {
                thumbnailSlider = false;
            }

            $scope.find('.swiper').each(function () {
                if ($(this).hasClass('swiper-initialized')) {
                    return;
                }
                let swiper_settings = $(this).attr('data-settings');
                try {
                    swiper_settings = JSON.parse(swiper_settings);
                } catch (e) {
                    swiper_settings = {};
                }
                swiper_settings.on = {
                    afterInit: (swiper) => {
                        let container = $(this).parents(".slider-container");
                        let paginationTemplate = container.find('.pagination-custom-templates .custom-pagination-item');
                        if (paginationTemplate.length > 0) {
                            container.find('.swiper-pagination .swiper-pagination-bullet').each(function (i) {
                                let customPage = paginationTemplate.get(i);
                                $(this).append(customPage);
                            })
                        }
                    }
                };
                if (false !== thumbnailSlider) {
                    swiper_settings.thumbs = {
                        swiper: thumbnailSlider
                    }
                }
                let swiper = new Swiper($(this)[0], swiper_settings);

                $(this).data('swiper', swiper);
            });
        });
    });
})(jQuery);