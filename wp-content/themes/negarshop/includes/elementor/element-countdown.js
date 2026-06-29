(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/negarshop_countdown.default', function ($scope) {
            $scope.find('.widget-negarshop-countdown').each(function () {
                let date = $(this).attr('data-timer') ?? '';
                if (typeof $(this).data('template') === 'undefined') {
                    $(this).data('template', $(this).html());
                }
                $(this).addClass('initialized');
                $(this).countdown(date, (event) => {
                    let content = $(this).data('template');
                    content = content.replaceAll('{days}', event.strftime('%D'));
                    content = content.replaceAll('{hours}', event.strftime('%H'));
                    content = content.replaceAll('{minutes}', event.strftime('%M'));
                    content = content.replaceAll('{seconds}', event.strftime('%S'));
                    $(this).html(content);
                });
            });
        });
    });
})(jQuery);