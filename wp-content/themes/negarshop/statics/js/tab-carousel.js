jQuery(document).ready(function ($) {
    "use strict";
    $('.content-widget.products-carousel.tabs header.section-header ul li a').click(function () {
        if (!$(this).parent().hasClass('active')) {
            var thisitem = $(this);
            var item_query = thisitem.attr('data-query');
            var item_opts = thisitem.attr('data-opts');
            var carousel_tag = thisitem.parents('.content-widget.products-carousel.tabs').find('.owl-carousel');
            thisitem.parents('.content-widget.products-carousel.tabs').find('.loading').addClass('visible');
            if (!thisitem.hasClass('loading')) {
                jQuery.post(negarshop_obj.ajax_url, {
                    'action': 'negarshop_ajax_tabcarousel',
                    'query': item_query,
                    'opts': item_opts,
                }, function (response) {
                    if (response.status) {
                        carousel_tag.trigger('destroy.owl.carousel');
                        carousel_tag.find('.owl-stage-outer').children().unwrap();
                        carousel_tag.removeClass("owl-center owl-loaded owl-text-select-on");
                        carousel_tag.html(response.data.content);
                        thisitem.parents('.content-widget.products-carousel').find('.section-header a.archive-link').attr('href',response.data.archive);
                        var items = carousel_tag.attr('data-items');
                        var carOPTS = JSON.parse(carousel_tag.attr('data-carousel'));
                        items = JSON.parse(items);
                        carousel_tag.owlCarousel({
                            rtl: true,
                            nav: carOPTS.nav,
                            loop: carOPTS.loop,
                            autoplay: carOPTS.autoplay,
                            autoplayTimeout: 7000,
                            autoplayHoverPause: false,
                            dots: false,
                            navText: ["<i class='fal fa-angle-right'></i>","<i class='fal fa-angle-left'></i>"],
                            responsive: {
                                0: {items: items.sm,},
                                480: {items: items.md,},
                                700: {items: items.lg,},
                                991: {items: items.xl,},
                            },
                            margin: 15
                        });
                        thisitem.parents('ul').find('li').removeClass('active');
                        thisitem.parent().addClass('active');
                        thisitem.parents('.content-widget.products-carousel.tabs').find('.loading').removeClass('visible');
                    }
                    thisitem.removeClass('loading');
                });
            }
        }
        return false;
    });
});
