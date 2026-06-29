(function ($) {
    "use strict";

    $(document).on("get_data", ".widget-negarshop-live-price", function () {
        if ($(this).hasClass('loading')) {
            return;
        }
        let targetVal = $(this).attr("data-target");
        let symb = $(this).attr("data-symb");
        if (targetVal.length === 0) {
            return;
        }
        let valPlace = $(this).find('span');
        if (valPlace.text().length === 0) {
            valPlace.text("بارگذاری...");
        }
        $(this).addClass("loading");
        $.get("https://call3.tgju.org/ajax.json", (response) => {
            if (typeof response.current[targetVal] === "undefined") {
                valPlace.text('خطا');
                return;
            }
            let value = response.current[targetVal].p;
            valPlace.text(value + ' ' + symb);
            setTimeout(() => {
                $(this).removeClass("loading");
            }, 1000);
        });
    });

    $(document).on("click", '.widget-negarshop-live-price .reload', function () {
        $(this).parents('.widget-negarshop-live-price').trigger("get_data");
    });

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/negarshop_live_price.default', function ($scope) {
            $scope.find(".widget-negarshop-live-price").trigger("get_data");
            setTimeout(() => {
                $scope.find(".widget-negarshop-live-price").trigger("get_data");
            }, 60000)
        });
    });
})(jQuery);