(function ($) {
    "use strict";

    $(window).on('elementor/frontend/init', () => {
        elementorFrontend.hooks.addAction('frontend/element_ready/negarshop_story.default', function ($scope) {
            $scope.find('.view-carousel').each(function () {
                var carinit = $(this).owlCarousel({
                    items: 1,
                    rtl: true,
                    dots: true,
                    loop: false,
                    nav: true,
                    autoplay: true,
                    autoplayTimeout: 1000,
                    autoplayHoverPause: false,
                });
                carinit.trigger('stop.owl.autoplay');
            });
            $scope.find('.story-items').each(function () {
                var carinit = $(this).owlCarousel({
                    rtl: true,
                    margin: 10,
                    loop: false,
                    autoWidth: true,
                    dots: false
                });
            });
        });
    });
    $(window).on("resize showstories", function () {
        let windowsHeight = $(this).outerHeight();
        $(".widget-story .story-viewport .viewport-wrapper").each(function () {
            let itemWidth = $(this).outerWidth();
            let itemHeight = $(this).outerHeight();

            if (windowsHeight < itemHeight) {
                $(this).css({"width": (windowsHeight / 1.77) + 'px'});
                $(this).find('.view-carousel').trigger("resized.owl.carousel");
            } else {
                $(this).css({"width": '400px'});
            }
        });
    });
    $(document).on("click", ".widget-story .story-items .owl-item", function () {
        $(this).parents(".widget-story").find(".story-viewport").addClass("show-viewport");
        $(this).parents(".widget-story").find(".view-carousel").trigger("to.owl.carousel", [$(this).index(), 0, true]).trigger('play.owl.autoplay', [5000]);
        $("body").addClass("story-showing");
        setTimeout(() => {
            $(window).trigger("showstories");
        }, 500);

    });
    $(document).on("click", ".widget-story .close-stories, .widget-story .viewport-dismisser", function () {
        $(".widget-story").trigger("close");
    });

    $(document).on("close", ".widget-story", function () {
        $(this).find(".story-viewport").removeClass("show-viewport");
        let carousel = $(this).find(".view-carousel");
        carousel.trigger('stop.owl.autoplay');
        $("body").removeClass("story-showing");
    });

    $(document).on("keydown", function (e) {
        if (e.which === 27 || e.key == "Escape") {
            $(".widget-story").trigger("close");
        }
    });

})(jQuery);