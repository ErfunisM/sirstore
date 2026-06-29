function setCookie(cname, cvalue, exdays, htime) {
    let d = new Date();
    if (!htime) {
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    } else {
        d.setTime(d.getTime() + (exdays * 60 * 60 * 1000));
    }
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function get(name) {
    if (name = (new RegExp('[?&]' + encodeURIComponent(name) + '=([^&]*)')).exec(location.search))
        return decodeURIComponent(name[1]);
}

function insertParam(key, value) {
    key = encodeURI(key);
    value = encodeURI(value);

    let kvp = document.location.search.substr(1).split('&');

    let i = kvp.length;
    let x;
    while (i--) {
        x = kvp[i].split('=');

        if (x[0] == key) {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }

    if (i < 0) {
        kvp[kvp.length] = [key, value].join('=');
    }

    //this will reload the page, it's likely better to store this until finished
    document.location.search = kvp.join('&');
}

function removeParam(key) {
    let sourceURL = window.location.href;
    let rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    document.location = rtn;
    return rtn;
}

function magnify(imgID, zoom) {
    let img, glass, w, h, bw;
    img = document.getElementById(imgID);
    /*create magnifier glass:*/
    glass = document.createElement("DIV");
    glass.setAttribute("class", "img-magnifier-glass");
    /*insert magnifier glass:*/
    img.parentElement.insertBefore(glass, img);
    /*set background properties for the magnifier glass:*/
    glass.style.backgroundImage = "url('" + img.src + "')";
    glass.style.backgroundRepeat = "no-repeat";
    glass.style.backgroundSize = (img.width * zoom) + "px " + (img.height * zoom) + "px";
    bw = 3;
    w = glass.offsetWidth / 2;
    h = glass.offsetHeight / 2;
    /*execute a function when someone moves the magnifier glass over the image:*/
    glass.addEventListener("mousemove", moveMagnifier);
    img.addEventListener("mousemove", moveMagnifier);
    /*and also for touch screens:*/
    glass.addEventListener("touchmove", moveMagnifier);
    img.addEventListener("touchmove", moveMagnifier);

    function moveMagnifier(e) {
        let pos, x, y;
        /*prevent any other actions that may occur when moving over the image*/
        e.preventDefault();
        /*get the cursor's x and y positions:*/
        pos = getCursorPos(e);
        x = pos.x;
        y = pos.y;
        /*prevent the magnifier glass from being positioned outside the image:*/
        if (x > img.width - (w / zoom)) {
            x = img.width - (w / zoom);
        }
        if (x < w / zoom) {
            x = w / zoom;
        }
        if (y > img.height - (h / zoom)) {
            y = img.height - (h / zoom);
        }
        if (y < h / zoom) {
            y = h / zoom;
        }
        /*set the position of the magnifier glass:*/
        glass.style.left = (x - w) + "px";
        glass.style.top = (y - h) + "px";
        /*display what the magnifier glass "sees":*/
        glass.style.backgroundPosition = "-" + ((x * zoom) - w + bw) + "px -" + ((y * zoom) - h + bw) + "px";
    }

    function getCursorPos(e) {
        let a, x = 0, y = 0;
        e = e || window.event;
        /*get the x and y positions of the image:*/
        a = img.getBoundingClientRect();
        /*calculate the cursor's x and y coordinates, relative to the image:*/
        x = e.pageX - a.left;
        y = e.pageY - a.top;
        /*consider any page scrolling:*/
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;
        return {x: x, y: y};
    }
}

(function ($) {
    "use strict";
    let cookie_array = getCookie('img_banners');
    if (cookie_array == "") {
        cookie_array = [];
    } else {
        cookie_array = JSON.parse(cookie_array);
    }
    $('.image-banner-parent.removeable').each(function () {
        if (cookie_array.indexOf($(this).attr('id')) != "-1") {
            $(this).hide()
        }
        $(this).append('<button class="close-btn"><i class="fal fa-times"></i></button>');
    });
    $('.image-banner-parent.removeable button.close-btn').click(function () {
        let thisParent = $(this).parents('.image-banner-parent.removeable');
        cookie_array[cookie_array.length] = thisParent.attr("id");
        setCookie("img_banners", JSON.stringify(cookie_array), 10, false);
        thisParent.slideUp();
    });
    $('.flip-clock-a').each(function () {
        let endTime = parseInt($(this).attr('data-end'));
        let thisID = $(this).attr('id');
        let clock;
        clock = $('#' + thisID).FlipClock(endTime, {
            clockFace: 'DailyCounter',
            autoStart: false,
            language: 'fa',
            showSeconds: true,
            callbacks: {
                stop: function () {
                    window.location.assign('/');
                }
            }
        });
        clock.setCountdown(true);
        clock.start();
    });

    $(document).on('owl-init', '.owl-carousel', function () {
        let carousel_settings = {
            rtl: true,
            items: 3,
            nav: true,
            loop: false,
            navText: ["<i class='fal fa-angle-left'></i>", "<i class='fal fa-angle-right'></i>"],
            responsive: {
                0: {
                    dots: true,
                    nav: false,
                },
                768: {
                    dots: false,
                    nav: true
                },
            },
        };

        if (typeof $(this).attr('data-slider') !== 'undefined') {
            try {
                carousel_settings = JSON.parse($(this).attr('data-slider'));
            } catch (e) {
            }
        }

        $(this).owlCarousel(carousel_settings);
    });


    $.fn.wc_product_def_gallery = jQuery('.product .woocommerce-product-gallery').html();

    function CBinitProductGallery() {
        let bigcar = $('.owl-carousel.wc-product-carousel');
        let thumbcar = $('.single-style-2-gallery .owl-carousel.wc-product-carousel-thumbs');
        let styleThreeThumbcar = $('.product-single-style-3 .owl-carousel.wc-product-carousel-thumbs');
        $(document).ready(function () {
            bigcar.owlCarousel({
                items: 1,
                nav: true,
                loop: false,
                navText: ["<i class='fal fa-angle-left'></i>", "<i class='fal fa-angle-right'></i>"],
                responsive: {
                    0: {
                        dots: true,
                        nav: false,
                    },
                    768: {
                        dots: false,
                        nav: true
                    },
                },
            });
            let isCenter = true;
            let items_thumbs = 6;
            if (thumbcar.length > 0) {
                items_thumbs = 12;
            } else if (styleThreeThumbcar.length > 0) {
                isCenter = false
                items_thumbs = 4;
                thumbcar = styleThreeThumbcar;
            } else {
                thumbcar = $('.owl-carousel.wc-product-carousel-thumbs');
            }
            thumbcar.owlCarousel({
                items: items_thumbs,
                center: isCenter,
                margin: 10,
                nav: false,
                dots: false,
                checkVisible: true
            });
            bigcar.find('.owl-stage').lightGallery({
                selector: '.car-dtag'
            });
            let setterTimer = null;
            bigcar.on('changed.owl.carousel', function (event) {
                thumbcar.trigger('to.owl.carousel', event.item.index);
                clearTimeout(setterTimer);
                setterTimer = setTimeout(() => {
                    let activeItemAttachmentID = bigcar.find('.owl-item.active [data-attach-id]').attr('data-attach-id');
                    thumbcar.find('.custom-active-item').removeClass('custom-active-item');
                    thumbcar.find('[data-attach-id="' + activeItemAttachmentID + '"]').parents('.owl-item').addClass('custom-active-item');
                }, 100);
            });
            thumbcar.on('changed.owl.carousel', function (event) {
                bigcar.trigger('to.owl.carousel', event.item.index);
                clearTimeout(setterTimer);
                setterTimer = setTimeout(() => {
                    let activeItemAttachmentID = bigcar.find('.owl-item.active [data-attach-id]').attr('data-attach-id');
                    thumbcar.find('.custom-active-item').removeClass('custom-active-item');
                    thumbcar.find('[data-attach-id="' + activeItemAttachmentID + '"]').parents('.owl-item').addClass('custom-active-item');
                }, 500);
            });
            $('.owl-carousel.wc-product-carousel-thumbs .owl-item').click(function () {
                bigcar.trigger('to.owl.carousel', $(this).index());
            });
        });
        bigcar.on('initialized.owl.carousel', function (event) {
            setTimeout(function () {
                bigcar.trigger('to.owl.carousel', event.item.count - 1);
            }, 10);
        });
        if ($(window).innerWidth() > 992) {
            $(document).ready(function () {
                $('.owl-carousel.wc-product-carousel img.product-gallery-img').each(function () {
                    $('#' + $(this).attr('id')).one("load", function () {
                        $('#' + $(this).attr('id')).magnify({
                            speed: 200,
                            src: $(this).attr('src')
                        });
                    }).each(function () {
                        if (this.complete) {
                            $(this).trigger('load');
                        }
                    });
                });
            });
        }
    }

    CBinitProductGallery();
    let wcshortdesc = $('.woocommerce-product-details__short-description').height();
    if (wcshortdesc > 194) {
        $('.woocommerce-product-details__short-description.has-trigger').append('<button id="product-short-desc-toggle"><span class="outer"><span>دیدن ادامه...</span> <i class="fal fa-angle-down"></i></span></button>');
    }
    $('#product-short-desc-toggle').click(function () {
        $(this).parents('.woocommerce-product-details__short-description').toggleClass('show');
        if ($(this).parents('.woocommerce-product-details__short-description').hasClass('show')) {
            $(this).find('.outer span').text('کوتاه کردن');
        } else {
            $(this).find('.outer span').text('دیدن ادامه...');
        }
    });
    $(document).ready(function () {
        $('.enamad-carousel').owlCarousel({rtl: true, items: 1, loop: true, autoplay: true});
    });

    $('img.lazy').one("load", function () {
        $(this).parents('figure.thumb').css({'background-image': 'none'});
    }).each(function () {
        if (this.complete) {
            $(this).trigger('load');
        }
    });


    $(document).ready(function () {
        $('body:not(.elementor-page) .offer-moments .owl-carousel').each(function () {
            let carouselSEL = $(this);
            let carinit = carouselSEL.owlCarousel({
                items: 1,
                rtl: true,
                dots: false,
                touchDrag: false,
                mouseDrag: false,
                pullDrag: false,
                loop: true,
                nav: false,
                autoplay: true,
                autoplayTimeout: 7000,
                autoplayHoverPause: false,
                onInitialized: function () {
                    carouselSEL.parents('.offer-moments').addClass('animate-bar');
                }
            });
        });
    });


    let afterval = 0;
    wpbtt_start();
    $(window).scroll(function () {
        wpbtt_start();
        if ($(window).scrollTop() > 0) {
            $('.fixed-bottom-bar').fadeIn('fast');
        } else {
            $('.fixed-bottom-bar').fadeOut('fast');
        }
    });
    $("#main-menu-btn").click(function () {
        $("#side-menu").addClass('show');
    });
    $("#res-search-btn").click(function () {
        $(this).addClass('show');
    });
    $("#res-search-close").click(function () {
        $("#res-search-btn").removeClass('show');
        return false;
    });
    $(".ui-mask").click(function () {
        $("#side-menu").removeClass('show');
    });
    $("#side-menu nav li.menu-item-has-children,footer#footer .footer-copyright nav.footer-menu li.menu-item-has-children").each(function () {
        $(this).children('a').after('<span class="toggle"><i class="fal fa-angle-down"></i></span>');
    });
    $("#side-menu nav li.menu-item-has-children span.toggle").click(function () {
        $(this).toggleClass('active');
        $(this).next('ul').slideToggle('fast');
    });
    $("footer#footer .footer-copyright nav.footer-menu li.menu-item-has-children span.toggle").click(function () {
        $(this).toggleClass('active');
        $(this).next('ul').toggleClass('show');
    });
    $("button#footer-menu-toggle").click(function () {
        $(this).next('ul').toggleClass('show');
    });
    $(".content-widget header.section-header button.wg-tabs-toggle").click(function () {
        $(this).next('ul').toggleClass('show');
    });
    $(".content-widget header.section-header button.wg-tabs-close").click(function () {
        $(this).parents('ul').removeClass('show');
    });
    $(".content-widget header.section-header ul.tabs a").click(function () {
        $(this).parents('ul').removeClass('show');
    });
    $(document).ready(function () {
        let qiit = $('.quantity input.input-text');
        qiit.each(function () {
            $(this).before('<span class="m-btn"><i class="far fa-minus"></i></span>');
            $(this).after('<span class="p-btn"><i class="far fa-plus"></i></span>');
            $(this).parents('.quantity').addClass('custom-num');
            $(this).show();
        });
    });
    $(document).on('click', '.quantity .m-btn', function () {
        let inputT = $(this).parent().find('input.input-text');
        if (parseInt(inputT.val()) > parseInt(inputT.attr('min'))) {
            inputT.val(parseInt(inputT.val()) - 1);
            inputT.change();
        }
    });
    $(document).on('click', '.quantity .p-btn', function () {
        let inputT = $(this).parent().find('input.qty');
        if (parseInt(inputT.val()) < parseInt(inputT.attr('max')) || inputT.attr('max') == "") {
            inputT.val(parseInt(inputT.val()) + 1);
            inputT.change();
        }
    });

    $(document).ajaxSuccess(function (event, xhr, settings) {
        let req_url = settings.url;
        if (req_url.search("wc-ajax=get_refreshed_fragments") > -1) {
            $('.quantity input.input-text').parents('.quantity').addClass('custom-num');
            $('.quantity.custom-num input.input-text').before('<span class="m-btn"><i class="far fa-minus"></i></span>');
            $('.quantity.custom-num input.input-text').after('<span class="p-btn"><i class="far fa-plus"></i></span>');
            $('.quantity input.input-text').show();
        }
    });
    if ($('.orderby.custom-select').length > 0) {
        $('.products-archive-header ul.products-archive-tabs button:not(.active)').click(function () {
            $('.orderby.custom-select').val($(this).attr('data-value'));
            $('.orderby.custom-select').change();
        });
    } else {
        $('.woocommerce-products-header .products-archive-header').remove();
    }
    if (get('stock') == "instock") {
        $('#archive-in-stock-switch').prop('checked', true);
    }
    $('#archive-in-stock-switch').change(function () {
        if ($(this).prop("checked")) {
            insertParam('stock', 'instock');
        } else {
            removeParam('stock');
        }
    });
    if (getCookie('negarshop_popup') != "hidden") {
        $('#negarshop-popup').modal('show');
    }
    $('#negarshop-popup .negarshop-popup-link').click(function () {
        let cook_time = $('#negarshop-popup').attr('data-time');
        setCookie('negarshop_popup', 'hidden', cook_time, true);
        $('#negarshop-popup').modal('hide');
    });
    $('#negarshop-popup').on('hidden.bs.modal', function (e) {
        let cook_time = $('#negarshop-popup').attr('data-time');
        setCookie('negarshop_popup', 'hidden', cook_time, true);
    });
    $('#header-action-menu-btn').click(function () {
        $(this).toggleClass('active');
        $('header#header.style-negarshop-light .bottom').toggleClass('show');
    });


    function wpbtt_btn(i) {
        let prec = i * 3.6;
        if (prec <= 180) {
            jQuery('#negarshop-to-top>span').css('background-image', 'linear-gradient(' + (prec + 90) + 'deg, transparent 50%, #fff 50%),linear-gradient(90deg, #fff 50%, transparent 50%)');
        } else {
            jQuery('#negarshop-to-top>span').css('background-image', 'linear-gradient(' + (prec - 90) + 'deg, transparent 50%, ' + jsVars.borderActiveColor + ' 50%),linear-gradient(90deg, #fff 50%, transparent 50%)');
        }
    }

    function wpbtt_start() {
        let scrollTop = jQuery(window).scrollTop();
        let docHeight = jQuery(document).height();
        let winHeight = jQuery(window).height();
        let scrollPercent = (scrollTop) / (docHeight - winHeight);
        let scrollPercentRounded = Math.round(scrollPercent * 100);
        wpbtt_btn(scrollPercentRounded);
    }

    $('#negarshop-to-top').click(function () {
        $("html, body").stop().animate({scrollTop: 0}, "fast");
        return false;
    });
    $('.products-grid .grid-products-loader button.btn').click(function () {
        let thisItem = $(this);
        let ti_offset = parseInt($(this).attr('data-offset'));
        thisItem.addClass('disabled');
        jQuery.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_grid_post_ajax',
            'query': thisItem.attr('data-query'),
            'offset': ti_offset,
        }, function (response) {
            if (response.status) {
                ti_offset++;
                thisItem.attr('data-offset', ti_offset);
                thisItem.removeClass('disabled');
                thisItem.parents('.grid-items').children('.row').append(response.data);
                if (!response.next) {
                    thisItem.remove();
                }
            }
        });
        return false;
    });
    let caloadmg = false;
    $('#magical-btn').click(function () {
        let thisItem = $(this);
        $('.magic-items').slideUp('fast');
        thisItem.addClass('loading');
        jQuery.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_magic_post_ajax',
            'query': thisItem.attr('data-query'),
        }, function (response) {
            if (response.status) {
                $('.magic-items').slideDown('fast');
                $("html, body").animate({scrollTop: $('.magic-items').offset().top}, "slow");
                $('.magic-items .row').html(response.data);
            }
            thisItem.removeClass('loading');
        });
        return false;
    });
    $(document).on("click", ".add-product-favo, .dislike_product", function () {
        let thisItem = $(this);
        if (!thisItem.hasClass('login_req')) {
            thisItem.addClass('disabled');
            jQuery.post(negarshop_obj.ajax_url, {
                'action': 'negarshop_like_ajax',
                'id': thisItem.attr('data-id'),
            }, function (response) {
                if (response.status) {
                    if (response.status_code == 1) {
                        thisItem.addClass("liked");
                    } else if (response.status_code == 2) {
                        thisItem.removeClass("liked");
                    }
                    thisItem.removeClass('disabled');
                    if (thisItem.hasClass('dislike_product')) {
                        location.reload();
                    }
                }
            });
        } else {
            $('#login-popup-modal').modal('show');
        }
        return false;
    });
    $(document).on("click", ".cb-quick-view:not(.disabled)", function () {
        let thisItem = $(this);
        let cbQVModal = $('.cb-quick-view-modal-lg');
        thisItem.addClass('disabled');
        cbQVModal.find('.modal-content').children('.loading').show();
        cbQVModal.find('.modal-content').children('.content').html('');
        cbQVModal.modal('show');
        jQuery.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_quick_view_ajax',
            'id': thisItem.attr('data-id'),
        }, function (response) {
            if (response.status) {
                cbQVModal.find('.modal-content').children('.loading').hide();
                cbQVModal.find('.modal-content').children('.content').html(response.data);
                thisItem.removeClass('disabled');
            }
        });
        return false;
    });
    $(document).on("submit", '.card-add-to-cart form', function (e) {
        let item_id = $(this).parents('.product-card').parent().attr('id');
        let formData = {};
        $(this).find("[name]").each(function (index, node) {
            formData[node.name] = node.value;
        });
        formData['action'] = 'negarshop_add_to_cart_ajax';
        formData['id'] = formData['add-to-cart'];
        formData['add-to-cart'] = false;
        let thisitem = $(this);
        thisitem.addClass('disabled');
        $.ajax({
            url: negarshop_obj.ajax_url,
            method: 'post',
            data: formData
        }).done(function (response) {
            if (response.status !== undefined) {
                $.notify({
                    message: response.message,
                }, {
                    // settings
                    element: 'body',
                    position: null,
                    type: response.style,
                    allow_dismiss: false,
                    newest_on_top: false,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    z_index: parseInt(thisitem.attr('data-offset')),
                    delay: 2000,
                    timer: 1000,
                });
                $('.widget_shopping_cart_content').html(response.basket);
                $('.cart-basket-box span.count, #responsive-header .rh-item .badge').text(response.count);
                $('.cart-basket-box span.subtitle').html(response.total_amount);
                $('.header-cart-basket.cart-mode-popup.cart-auto-show .cart-basket-box').trigger('click');
            }
            atc_can[item_id] = true;
            thisitem.parents('.product-card').removeClass('show-add-cart');
            thisitem.removeClass('disabled');
        });
        return false;
    });


    let atc_time = {};
    let atc_can = {};
    $(document).on("click", '.cb-add-to-cart.advanced_cart', function () {
        let item_id = $(this).parents('.product-card').parent().attr('id');
        atc_can[item_id] = true;
        $(this).parents('.product-card').addClass('show-add-cart');
        return false;
    });
    $(document).on("mouseleave", '.product-card', function () {
        let thisItem = $(this);
        let item_id = $(this).parent().attr('id');
        atc_time[item_id] = setTimeout(function () {
            if (atc_can[item_id]) {
                thisItem.removeClass('show-add-cart');
            }
        }, 2000);
    });
    $(document).on("mouseenter", '.product-card', function () {
        let item_id = $(this).parent().attr('id');
        if (atc_time[item_id] !== undefined) {
            clearTimeout(atc_time[item_id]);
        }
        atc_can[item_id] = true;
    });
    $(document).on("focus", '.card-add-to-cart select,.card-add-to-cart input', function () {
        let item_id = $(this).parents('.product-card').parent().attr('id');
        if (atc_time[item_id] !== undefined) {
            clearTimeout(atc_time[item_id]);
        }
        atc_can[item_id] = false;
    });
    $(document).on("focusout", '.card-add-to-cart select,.card-add-to-cart input', function () {
        let item_id = $(this).parents('.product-card').parent().attr('id');
        atc_can[item_id] = true;
    });
    $(document).on("click", '.card-add-to-cart .close', function () {
        $(this).parents('.product-card').removeClass('show-add-cart')
    });


    $(document).on("click", '.cb-add-to-cart:not(.advanced_cart)', function () {
        let thisitem = $(this);
        thisitem.addClass('disabled');
        $.ajax({
            url: negarshop_obj.ajax_url,
            method: 'post',
            data: {
                'action': 'negarshop_add_to_cart_ajax',
                'id': thisitem.attr('data-id'),
            }
        }).done(function (response) {
            if (response.status !== undefined) {
                $.notify({
                    message: response.message,
                }, {
                    // settings
                    element: 'body',
                    position: null,
                    type: response.style,
                    allow_dismiss: false,
                    newest_on_top: false,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    z_index: parseInt(thisitem.attr('data-offset')),
                    delay: 2000,
                    timer: 1000,
                });
                $('.widget_shopping_cart_content').html(response.basket);
                $('.cart-basket-box span.count, #responsive-header .rh-item .badge').text(response.count);
                $('.cart-basket-box span.subtitle').html(response.total_amount);
                $('.header-cart-basket.cart-mode-popup.cart-auto-show .cart-basket-box').trigger('click');
            }
            thisitem.removeClass('disabled');
        });
    });


    $("html").click(function () {
        $(".header-search .search-box.ajax-form .search-result").fadeOut('fast');
        $("body").removeClass("search-overlay-is-showing");
    });

    $(".header-search .search-box.ajax-form .search-result:not(.compare-mode)").click(function (a) {
        a.stopPropagation();
    });

    $('.header-search .search-box.ajax-form input.search-field').focus(function (a) {
        a.stopPropagation();
        $(this).parents('.search-box').find('.search-result').fadeIn('fast');
        $("body").addClass("search-overlay-is-showing");
    }).click(function (a) {
        a.stopPropagation();
        $(this).parents('.search-box').find('.search-result').fadeIn('fast');
        $("body").addClass("search-overlay-is-showing");
    });
    let pretext = $('.header-search .search-box.ajax-form input.search-field').val();
    let forceSearch = false;

    let current_category, current_instuck;
    $('.header-search .search-box.ajax-form .close-popup, .header-search .search-box.ajax-form .search-submit').click(function () {
        forceSearch = true;
        current_category = $(this).parents('.search-box').find('#header-search-cat').val();
        current_instuck = $(this).parents('.search-box').find('#header-search-stock').val();
        $('.header-search .search-box input.search-field').keyup();
        return false;
    });

    let cansend = true;
    let myTimeVar;
    $('.header-search .search-box.ajax-form input.search-field').keyup(function () {
        clearTimeout(myTimeVar);
        let thisItem = $(this);
        let current_text = $(this).val();
        thisItem.parents('.search-box').addClass('loading');
        myTimeVar = setTimeout(function () {
            let content_selector = thisItem.parents('.search-box').find('.search-result');
            if (current_text.length <= 1) {
                content_selector.html('');
            }

            let current_type = thisItem.parents('.search-box').attr('data-type');
            let search_mode = thisItem.parents('.search-box').attr('data-mode');
            if (search_mode !== '') {
                content_selector.addClass(search_mode + '-mode');
            }
            current_category = thisItem.parents('.search-box').find('#header-search-cat').val();
            current_instuck = thisItem.parents('.search-box').find('#header-search-stock') !== undefined ? thisItem.parents('.search-box').find('#header-search-stock').val() : '';
            if (cansend && (current_text != pretext || forceSearch) && current_text != "" && current_text.length > 1) {
                cansend = false;
                forceSearch = false;


                content_selector.html('');
                jQuery.post(negarshop_obj.ajax_url, {
                    'action': 'negarshop_ajax_search',
                    's': thisItem.val(),
                    'cat': current_category,
                    'stuck': current_instuck,
                    'search_mode': search_mode,
                    'type': current_type,
                }, function (response) {
                    if (response.status) {
                        let html_output = '';
                        let i;
                        let res_data = response.data;
                        if (res_data.length > 0) {
                            for (i = 0; i < res_data.length; i++) {
                                let compareBtn = res_data[i].compare !== false ? res_data[i].compare : '';
                                html_output = html_output + '<li><a href="' + res_data[i].url + '"><img src="' + res_data[i].thumb + '" alt="' + res_data[i].title + '"/><h3>' + res_data[i].title + '</h3><h6>' + res_data[i].price + '</h6></a>' +
                                    compareBtn +
                                    '</li>';
                            }
                            html_output += '<li class="archive">' + defaultText.searchArchive + '<a href="javascript:void(0)" onclick="archive_btn(this)" class="archive-btn btn btn-primary btn-large">' + defaultText.searchAllBtn + '</a> </li>';
                        } else {
                            html_output = '<li class="nothing"><i class="fal fa-times-circle"></i>' + defaultText.searchNotFound + '</li>';
                        }
                        content_selector.fadeIn('fast');
                        content_selector.html(html_output);
                        thisItem.parents('.search-box').removeClass('loading');

                        $("body").addClass("search-overlay-is-showing");
                    }
                    cansend = true;
                });

            } else {
                thisItem.parents('.search-box').removeClass('loading');
            }
            pretext = current_text;
        }, 1000);
    });
    $('.negar-select').each(function () {
        $(this).select2();
    });
    $('.header-search .search-box button.search-filters').click(function (e) {
        e.stopPropagation();
        $(this).parents('.search-box').toggleClass('show-filters');
    });
    $('.header-search .search-box button.close-popup').click(function (e) {
        e.stopPropagation();
        $(this).parents('.search-box').removeClass('show-filters');
    });

    function initOWLCAR(selector) {
        selector.each(function () {
            let owlSelector = $(this);
            let owlOptions = {};
            if (owlSelector.attr('data-owl-options') !== undefined) {
                owlOptions = JSON.parse(owlSelector.attr('data-owl-options'));
            }
            owlSelector.owlCarousel(owlOptions);
        });
    }

    $(document).ready(function () {
        initOWLCAR($('.inline-owl-carousel'));
        $('.amazing-product-widget .owl-carousel').trigger('owl-init');
    });

    $(document).on('mouseenter', '.is-mega-menu-con.is-product-mega-menu .tabs a[data-query],.is-mega-menu-con.is-two-level-mega-menu .tabs a[data-query]', function () {
        let thisitem = $(this);
        thisitem.parents('.tabs').find('a').removeClass('item-hover');
        thisitem.addClass('item-hover');
        let menu_tab = thisitem.attr('data-tab');
        let content = thisitem.parents('.is-mega-menu-con').find('.contents');
        content.addClass('loading');
        if (!$(this).hasClass('loaded')) {
            let menu_query = thisitem.attr('data-query');
            if (!thisitem.hasClass('loading')) {
                thisitem.addClass('loading');
                content.find('.owl-carousel').removeClass('show');
                jQuery.post(negarshop_obj.ajax_url, {
                    'action': 'negarshop_ajax_megamenu_producs',
                    'query': menu_query,
                    'tab': menu_tab
                }, function (response) {
                    if (response.status) {
                        content.append(response.data.htmlContent);
                        content.find('.tab-' + menu_tab).addClass('show');
                        initOWLCAR(content.find('.tab-' + response.data.classAttr));
                        thisitem.addClass('loaded');
                    }
                    thisitem.removeClass('loading');
                    content.removeClass('loading');
                    thisitem.trigger('mouseenter');
                });
            }
        } else {
            content.removeClass('loading');
            content.find('.owl-carousel').removeClass('show');
            content.find('.tl-tabs').removeClass('show');
            content.find('.tab-' + menu_tab).removeClass('owl-hidden');
            content.find('.tab-' + menu_tab).addClass('show');
        }
    });
    $('ul.main-menu li[data-id]').hover(function () {
        if (!$(this).hasClass('loaded')) {
            let thisitem = $(this);
            let menu_id = thisitem.attr('data-id');
            if (!thisitem.hasClass('loading')) {
                thisitem.addClass('loading');
                jQuery.post(negarshop_obj.ajax_url, {
                    'action': 'negarshop_ajax_megamenu',
                    'menu_id': menu_id
                }, function (response) {
                    if (response.status) {
                        thisitem.append(response.data);
                        thisitem.addClass('loaded');
                        if (response.type === "product") {
                            thisitem.find('.tabs li:first-of-type>a').trigger('mouseenter');
                        }
                        let containerSize = $('.elementor-container').length > 0 ? $('.elementor-container').width() : $('.container').width();
                        $('.header-main-nav .header-main-menu:not(.vertical-menu) li[data-id]>ul.is-mega-menu-con').width(containerSize - 30);
                        $('.header-main-nav .header-main-menu.vertical-menu li[data-id]>ul.is-mega-menu-con').width(containerSize - 275);
                    }
                    thisitem.removeClass('loading');
                });
            }
        }
    });

    $('.header-main-nav .header-main-menu ul.main-menu>li.loaded>a').each(function () {
        if ($(this).prev('ul').length === 1) {
            let html_OUT = $(this)[0].outerHTML;
            $(this).prev('ul').before(html_OUT);
            $(this).prev('ul').find('.tabs ul>li:first-of-type>a').trigger('mouseenter');
            $(this).remove();
            let contSize = $('.elementor-container').length > 0 ? $('.elementor-container').width() : $('.container').width();
            $('.header-main-nav .header-main-menu:not(.vertical-menu) li[data-id]>ul.is-mega-menu-con').width(contSize - 30);
        }
    });
    $('.header-main-nav .header-main-menu.vertical-menu  li[data-id]>ul.is-mega-menu-con').each(function () {

        if ($(this).offset().left < 0) {
            $(this).width($(this).width() + $(this).offset().left - 15);
        }
    });

    $('video[custom-control]').each(function () {
        $(this).after('<button class="btn-play"><i class="fal fa-play"></i></button>');
    });
    $('video[custom-control]+.btn-play').on("click", function () {
        if ($(this).find('i').hasClass('fa-pause')) {
            $(this).prev("video").get(0).pause();
        } else {
            $(this).prev("video").get(0).play();
        }
        $(this).find('i').toggleClass("fa-pause");
    });


    $("#res-search-show").click(function () {
        $('.res-searchform').addClass('active');
    });
    $("#res-search-close").click(function () {
        $('.res-searchform').removeClass('active');
    });
    $("#header-menu-toggle").click(function () {
        $(".side-nav").addClass('show');
    });
    $(".ui-mask").click(function () {
        $(".side-nav").removeClass('show');
    });
    $(".side-nav nav li.menu-item-has-children, #footer .footer-menu nav.footer-menu li.menu-item-has-children").each(function () {
        $(this).children('a').after('<span class="toggle"><i class="fal fa-angle-down"></i></span>');
    });
    $(".side-nav nav li.menu-item-has-children span.toggle, #footer .footer-menu nav.footer-menu li.menu-item-has-children span.toggle").click(function () {
        $(this).toggleClass('active');
        $(this).next('ul').slideToggle('fast');
    });
    $(window).scroll(function () {
        if ($(this).width() < 1200) {
            if ($(this).scrollTop() > 15) {
                $('#responsive-header').addClass('fixed');
            } else {
                $('#responsive-header').removeClass('fixed');
            }
        }
    });


    $('#send-product-email').on("click", function () {
        let thisitem = $(this);
        let post_id = thisitem.attr('data-id');
        let user_email = $('#share-email-address').val();
        if (!thisitem.hasClass('disabled')) {
            thisitem.addClass('disabled');
            jQuery.post(negarshop_obj.ajax_url, {
                'action': 'negarshop_email_sharing',
                'id': post_id,
                'email': user_email,
            }, function (response) {
                let res = defaultText.errorSend;
                let style = "error";
                if (response.status) {
                    res = response.data;
                    style = "success";
                }
                $.notify({
                    message: res,
                }, {
                    // settings
                    element: 'body',
                    position: null,
                    type: style,
                    allow_dismiss: false,
                    newest_on_top: false,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    z_index: 9999,
                    delay: 2000,
                    timer: 1000,
                });
                thisitem.removeClass('disabled');
            });
        }
    });
    $(document).ready(function () {
        $('.product-additional-items .owl-carousel').owlCarousel({
            rtl: true,
            nav: true,
            dots: false,
            navText: ["<i class='fal fa-angle-right'></i>", "<i class='fal fa-angle-left'></i>"],
            responsive: {
                0: {
                    items: 2,
                },
                480: {
                    items: 2,
                },
                700: {
                    items: 2,
                },
                991: {
                    items: 2,
                },
            },
            margin: 20
        });
    });
    if ($('.af-add-to-cart .btn').length > 0) {
        let AF_cansend = true;
        let af_add = $('.af-add-to-cart .btn');
        let af_sel = $(".product-additional-items .additional-factor");
        let af_items_sel = $(".product-additional-items input[name*='quantity[']");
        let af_total_sel = $(".product-additional-items .af-total-price .total-count b");
        let af_items_sel_count = af_items_sel.length;
        af_items_sel.on("change", function () {
            let af_total_price = 0;
            let item_ID = parseInt($(this).attr("data-id"));
            if ($(this)[0].checked) {
                $(this).attr("value", "1");
                af_items_sel_count++;
            } else {
                $(this).attr("value", "0");
                af_items_sel_count--;
            }
            if (af_items_sel_count == 1) {
                $(".product-additional-items input[name*='quantity[']:checked").addClass('disabled');
            } else {
                $(".product-additional-items input[name*='quantity['].disabled").removeClass('disabled');
            }
            if (AF_cansend) {
                af_items_sel.each(function () {
                    if ($(this)[0].checked) {
                        af_total_price += parseInt($(this).attr("data-price"));
                    }
                });
                AF_cansend = false;
                af_sel.addClass('loading');
                jQuery.post(negarshop_obj.ajax_url, {
                    'action': 'negarshop_price_html',
                    'int': af_total_price,
                }, function (response) {
                    if (response) {
                        af_total_sel.text(af_items_sel_count);
                        $('.product-section.product-additional-items .additional-factor .af-total-price .price').html(response.data);
                    }
                    af_sel.removeClass('loading');
                    AF_cansend = true;
                });
            }
        });
    }

    function arrayEdit(array, item, add) {
        if (add) {
            let exist = false;
            for (var KEY in array) {
                if (array[KEY] === item) {
                    exist = true;
                }
            }
            if (!exist) {
                array[array.length] = item;
            }
        } else {
            for (var KEY in array) {
                if (array[KEY] === item) {
                    array.splice(KEY, 1);
                }
            }
        }
        return array;
    }


    $('.cb-nouislider').each(function () {
        let bigValueSlider = $(this).get(0);
        let slider = noUiSlider.create(bigValueSlider, {
            start: 3,
            step: 1,
            connect: [true, false],
            direction: 'rtl',
            range: {
                min: 1,
                max: 5
            }
        });
        $(this).append('<input type="hidden" name="' + $(this).attr("data-name") + '" value="3" />');
        $(this).append('<span class="level">' + defaultText.medium + '</span>');
        let input_value = $(this).find('input');
        let level_text = $(this).find('.level');
        bigValueSlider.noUiSlider.on('slide.one', function (a) {
            input_value.val(parseInt(a[0]));
            switch (parseInt(a[0])) {
                case 2:
                    level_text.text(defaultText.bad);
                    break;
                case 3:
                    level_text.text(defaultText.medium);
                    break;
                case 4:
                    level_text.text(defaultText.good);
                    break;
                case 5:
                    level_text.text(defaultText.excelent);
                    break;
                default:
                    level_text.text(defaultText.verybad);
                    break;
            }
        });
    });

    $('.cb-chips').each(function () {
        $(this).append('<div class="cb-chips">');
        $(this).append('<div class="add-box"><input type="text" name="' + $(this).attr('data-name') + '[]" placeholder="' + $(this).attr('data-phold') + '" class="text-field"><button class="btn add-item" type="button"><i class="fas fa-plus"></i></button></div>');
        $(this).append('<ul class="chip-items">');
        $(this).append('</ul>');
        $(this).append('</div>');
    });
    $(document).on("keypress", ".cb-chips input.text-field", function (e) {
        if (e.which == 13) {
            $(this).parents('.add-box').find('.add-item').click();
            return false;
        }
    });
    $(document).on("click", ".cb-chips .add-box .add-item", function () {
        let parent = $(this).parents('.cb-chips');
        let txt_inp = parent.find('.text-field').val();
        if (txt_inp !== "") {
            let div = document.createElement("div");
            div.innerHTML = txt_inp;
            parent.find('.chip-items').prepend('<li><span>' + div.innerText + '</span><button class="remove-item" type="button"><i class="far fa-times"></i></button><input type="hidden" name="' + parent.attr('data-name') + '[]" value="' + txt_inp + '"></li>');
            parent.find('.text-field').val("");
        }
    });
    $(document).on("click", ".cb-chips .chip-items .remove-item", function () {
        $(this).parents('li').remove();
    });
    $('.comment-form-cookies-consent').addClass('ns-checkbox');

    function exLikes() {
        $('.comment-like-btn').each(function () {
            let id = $(this).attr('data-id');
            let cookie_name = "comment_like_btn";
            let cookie = getCookie(cookie_name);
            if (cookie === "") {
                cookie = [];
            } else {
                cookie = JSON.parse(cookie);
            }
            let rate_exists = jQuery.inArray(id, cookie);
            if (rate_exists >= 0) {
                $(this).addClass('disabled');
            }
        });
    }

    $(document).on("click", ".comment-like-btn", function () {
        let thisitem = $(this);
        let cookie_name = "comment_like_btn";
        let cookie = getCookie(cookie_name);
        if (cookie === "") {
            cookie = [];
        } else {
            cookie = JSON.parse(cookie);
        }
        let rate_exists = jQuery.inArray(thisitem.attr('data-id'), cookie);
        if (rate_exists === -1) {
            if (cookie.length === 0) {
                cookie[0] = thisitem.attr('data-id');
                cookie = JSON.stringify(cookie);
                setCookie(cookie_name, cookie, 30, false);
            } else {
                cookie[cookie.length] = thisitem.attr('data-id');
                cookie = JSON.stringify(cookie);
                setCookie(cookie_name, cookie, 30, false);
            }
            if (!thisitem.hasClass('disabled')) {
                thisitem.addClass('disabled');
                $.post(negarshop_obj.ajax_url, {
                    'action': 'negarshop_comment_rates',
                    'id': thisitem.attr('data-id'),
                    'act': thisitem.attr('data-action'),
                }, function (response) {
                    if (response.status) {
                        thisitem.find('.count').text(response.data);
                        exLikes();
                    }
                    $('.comment-like-btn[data-id="' + thisitem.attr('data-id') + '"]').addClass('disabled');
                });
            }
        } else {
            thisitem.addClass('disabled');
        }
    });

    $('.cb-comment-tabs .cb-tabs a').click(function () {
        let thisitem = $(this);
        if (!thisitem.hasClass('disabled') && !thisitem.hasClass('active')) {
            thisitem.addClass('disabled');
            $('.cb_comment_list').addClass('loading');
            $.post(negarshop_obj.ajax_url, {
                'action': 'negarshop_comment_tabs',
                'id': thisitem.attr('data-id'),
                'order': thisitem.attr('data-order'),
            }, function (response) {
                if (response.status) {
                    $('.cb_comment_list .commentlist').html(response.data);
                    $('.cb-comment-tabs .cb-tabs a').removeClass('active');
                    thisitem.addClass('active');
                    exLikes();
                }
                $('.cb_comment_list').removeClass('loading');
                thisitem.removeClass('disabled');
            });
        }
        return false;
    });
    $('.cb-comment-tabs .cb-tabs li:first-of-type a').click();

    $('.related.products-carousel .owl-carousel').each(function () {
        let count = $(this).data('car-count') ?? 4;
        $(this).owlCarousel({
            rtl: true,
            nav: true,
            dots: false,
            loop: true,
            navText: ["<i class='fal fa-angle-right'></i>", "<i class='fal fa-angle-left'></i>"],
            responsive: {
                0: {
                    items: 2.5,
                },
                480: {
                    items: 3.5,
                },
                700: {
                    items: 3,
                },
                991: {
                    items: count,
                },
            },
            margin: 15
        });
    });

    $(document).on('user_login', '.negarshop-login-box', function (e, data) {
        data.form_data.action = 'negarshop_ajax_login';
        let result = $(this).find('.login-result');
        let loader = $(this).find('.login-loading');
        let button = $(this).find('.woocommerce-button');
        loader.slideDown('fast');
        button.addClass('loading');
        $.ajax({
            method: "POST",
            url: negarshop_obj.ajax_url,
            data: data.form_data
        }).done((response, textStatus, xhr) => {
            loader.slideUp('fast');
            if (302 === xhr.status || typeof response.data === 'undefined') {
                result.removeClass('login-result--error');
                result.addClass('login-result--success');
                result.html('وارد شدید! در حال انتقال...');
                setTimeout(() => {
                    window.location.replace(
                        data.form_data.redirect
                    );
                }, 1000);
                return;
            }

            button.removeClass('loading');
            result.html(response.data);

            if (!response.success) {
                result.addClass('login-result--error');
                result.removeClass('login-result--success');
            }
        });
    });

    $(document).on('submit', '.negarshop-login-box form.woocommerce-form-login', function (e) {
        e.preventDefault();
        let data = {};
        let form_data = $(this).serializeArray();

        if (form_data.length < 1) {
            return;
        }

        form_data.forEach(function (item) {
            data[item.name] = item.value;
        });

        $(this).parents('.negarshop-login-box').trigger('user_login', {
            form_data: data
        });
    });

    $(".variations_form.cart select").each(function () {
        $(this).addClass('form-control');
    });
    $(".sms-notif-submit").each(function () {
        $(this).removeClass('dokan-btn');
        $(this).addClass('btn');
    });
    $(".sms-notif-submit").each(function () {
        $(this).removeClass('dokan-btn-theme');
        $(this).addClass('btn-primary');
    });
    $('#yith-wcwtl-output .button').addClass('btn');
    $('.summary.entry-summary #yith-wcwtl-output').remove();
    $('ul.product-categories li.cat-parent>a').on("click", function () {
        $(this).next("ul").slideToggle("fast");
        $(this).parents('li').toggleClass('open');
        return false;
    });
    $('[data-toggle="tooltip"]').tooltip();
    $(document).on('click', '.ns-popup-btn', function () {
        let mdl_selector = $(this).attr('data-toggle');
        $(mdl_selector).addClass('active');
    });
    $(document).on('click', '.ns-popup-close', function () {
        $(this).parents('.ns-popup').removeClass('active');
    });
    $(document).on('click', '.ns-closer', function () {
        $(this).prev('.ns-popup').removeClass('active');
    });
    $('.sec-sticky').each(function () {
        let thisIitem = $(this);
        $(this).after('<div class="sticky-space" style="height: ' + $(this).height() + 'px"></div>');
        if ($(window).width() > 991) {
            let firstOff = thisIitem.offset().top;
            $(window).scroll(function () {
                let item = thisIitem;
                if ($(window).scrollTop() >= firstOff) {
                    if (!item.hasClass('fixed')) {
                        item.addClass('fixed');
                    }
                } else {
                    if (item.hasClass('fixed')) {
                        item.removeClass('fixed');
                    }
                }
            });
        }
    });

    $(document).ready(function ($) {
        if ($.isFunction(window.background)) {
            $('.background-video').background();
        }
    });

    $(document).on('hide_variation', 'form.variations_form', function (e, variation) {
        if ($.fn.wc_variations_current !== $.fn.wc_product_def_gallery) {
            jQuery('.product .woocommerce-product-gallery').html($.fn.wc_product_def_gallery);
            CBinitProductGallery();
        }
        $.fn.wc_variations_current = $.fn.wc_product_def_gallery;
    });
    $(document).on('found_variation.wc-variation-form', 'form.variations_form', function (e, variation) {
        let $form = $(this);

        if (variation && variation.cb_var_gallery && variation.cb_var_gallery.length > 0) {
            $.fn.wc_gallery_items_count = variation.cb_var_gallery.length;
            let html_output = '<div class="owl-carousel wc-product-carousel images">';
            jQuery.each(variation.cb_var_gallery, function (loopi, imgitem) {
                imgitem = imgitem['large'];
                html_output += '<div class="car-dtag" data-src="' + imgitem + '">';
                html_output += '<a href="' + imgitem + '" class="img-magnifier-container"><img class="product-gallery-img" data-magnify-src="' + imgitem + '" src="' + imgitem + '" alt="' + (loopi + 1) + '" id="wc-carousel-image-' + loopi + '" /></a>';
                html_output += '</div>';
            });
            html_output += '</div>';
            html_output += '<div class="owl-carousel wc-product-carousel-thumbs">';
            jQuery.each(variation.cb_var_gallery, function (loopi, imgitem) {
                imgitem = imgitem['thumb'];
                html_output += '<img src="' + imgitem + '" alt="' + loopi + '" />';
            });
            html_output += '</div>';
            if ($.fn.wc_variations_current !== html_output) {
                jQuery('.product .woocommerce-product-gallery').html(html_output);
                CBinitProductGallery();
            }
            $.fn.wc_variations_current = html_output;
        } else {
            if ($.fn.wc_variations_current !== $.fn.wc_product_def_gallery) {
                jQuery('.product .woocommerce-product-gallery').html($.fn.wc_product_def_gallery);
                CBinitProductGallery();
            }
            $.fn.wc_variations_current = $.fn.wc_product_def_gallery;
        }

        window.setTimeout(function () {
            $(window).trigger('resize');
            $form.wc_maybe_trigger_slide_position_reset(variation);
            $('.owl-carousel.wc-product-carousel').trigger('to.owl.carousel', 100);
        }, 20);
    });

    $.fn.wc_variations_current = false;


    $('.horz-res-scroll').each(function () {
        $(this).wrap('<div class="hrs-outer"></div>');
        let outer = $(this).parent();
        outer.append('<button class="btn hts-btn hrs-next-btn"><i class="far fa-angle-left"></i></button>');
        outer.prepend('<button class="btn hts-btn hrs-prev-btn" style="display: none"><i class="far fa-angle-right"></i></button>');
    });
    $('.hrs-outer .hts-btn').click(function () {
        let tag = $(this).parent().find('.horz-res-scroll');
        let ts = $(this);
        if ($(this).hasClass('hrs-next-btn')) {
            tag.stop().animate({scrollLeft: tag.scrollLeft() - 100}, 400, function () {
                if (tag.scrollLeft() >= 0) {
                    ts.parent().find('.hrs-prev-btn').fadeOut('fast');
                } else {
                    ts.parent().find('.hrs-prev-btn').fadeIn('fast');
                }
            });
        } else {
            tag.stop().animate({scrollLeft: tag.scrollLeft() + 100}, 400, function () {
                if (tag.scrollLeft() >= 0) {
                    ts.parent().find('.hrs-prev-btn').fadeOut('fast');
                } else {
                    ts.parent().find('.hrs-prev-btn').fadeIn('fast');
                }
            });
        }

    });
    $(document).on('click', '.sidebar.shop-archive-sidebar.acc-widgets section.widget:not(.show)', function () {
        $('.sidebar.shop-archive-sidebar.acc-widgets section.widget.show').not(this).children('*:not(.wg-header)').slideUp('fast');
        $('.sidebar.shop-archive-sidebar.acc-widgets section.widget.show').not(this).removeClass('show');
        $(this).children('*').slideDown('fast');
        $(this).addClass('show');
    });

    $(document).ready(function () {
        setTimeout(function () {
            $('.carousel .carousel-item img:not(.loaded)').each(function () {
                $(this).attr("src", $(this).attr("data-src"));
                $(this).addClass('loaded');
            });
        }, 1000);
        $('#shipping_city, #billing_city').addClass('form-control');
        $('.negarshop-countdown').each(function () {
            let date = '0000/00/00';
            if ($(this).attr("data-date") !== undefined) {
                date = $(this).attr("data-date");
            }
            $(this).countdown(date, function (event) {
                $(this).html(event.strftime('<div class="inner"><span class="countdown-section"><span class="countdown-amount countdown-amount--days">%D</span><span class="countdown-period">روز</span></span><span class="countdown-section"><span class="countdown-amount">%H</span><span class="countdown-period">ساعت</span></span><span class="countdown-section"><span class="countdown-amount">%M</span><span class="countdown-period">دقیقه</span></span><span class="countdown-section"><span class="countdown-amount">%S</span><span class="countdown-period">ثانیه</span></span></div>'));

                if ($(this).find('.countdown-amount--days').text() === '00') {
                    $(this).find('.countdown-amount--days').parent().hide();
                }
            });
        });
    });
    $('.crunchify-clipboard').click(function () {
        let copyText = document.getElementById("product-url-inpt");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
    });

    $(document).on('click', '.shop-archive-sidebar .section-close', function () {
        $(this).parents('.shop-archive-sidebar').removeClass('show');
        return false;
    });
    $(document).on('click', '.shop-filters-show', function () {
        $('.shop-archive-sidebar').addClass('show');
        return false;
    });

    $(document).on('submit', '#product-survey-form', function () {
        if ($("body").hasClass('logged-in')) {
            let formData = {};
            formData['action'] = 'negarshop_product_survey_ajax';
            formData['answ'] = 'no';
            $(this).find("input[name]").each(function (index, node) {
                formData[node.name] = node.value;
            });
            if ((formData['desc1'] !== undefined && formData['desc1'] !== "") || (formData['desc2'] !== undefined && formData['desc2'] !== "")) {
                let self = $(this);
                self.addClass('loading');
                jQuery.post(negarshop_obj.ajax_url, formData, function (response) {
                    self.removeClass('loading');
                    if (response.status) {
                        $('#product-survey').modal('hide');
                        self.remove();
                        $('.entry-summary .product-survey').addClass('sent');
                    } else {
                        $.notify({
                            message: response.data,
                        }, {
                            // settings
                            element: 'body',
                            position: null,
                            type: 'error',
                            allow_dismiss: false,
                            newest_on_top: false,
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            z_index: 9999,
                            delay: 2000,
                            timer: 1000,
                        });
                    }
                });
            }
        } else {
            $('#login-popup-modal').modal('show');
        }
        return false;
    });
    $(document).on('click', '.product-survey .btn.yes', function () {
        if ($("body").hasClass('logged-in')) {
            let formData = {};
            formData['action'] = 'negarshop_product_survey_ajax';
            formData['answ'] = 'yes';
            formData['product'] = $(this).attr('data-product');
            let self = $(this).parents('.product-survey');
            self.addClass('loading');
            jQuery.post(negarshop_obj.ajax_url, formData, function (response) {
                self.removeClass('loading');
                if (response.status) {
                    self.addClass('sent');
                } else {
                    $.notify({
                        message: response.data,
                    }, {
                        // settings
                        element: 'body',
                        position: null,
                        type: 'error',
                        allow_dismiss: false,
                        newest_on_top: false,
                        placement: {
                            from: "top",
                            align: "right"
                        },
                        z_index: 9999,
                        delay: 2000,
                        timer: 1000,
                    });
                }
            });
        } else {
            $('#login-popup-modal').modal('show');
        }
        return false;
    });
    $('.woocommerce nav.woocommerce-MyAccount-navigation ul li.res-toggle-menu').click(function () {
        $(this).toggleClass('show');
        return false;
    });
    $('#login-popup-modal').on('show.bs.modal', function (e) {
        if (!$("body").hasClass('pop-up-login')) {
            window.location.href = negarshop_obj.my_account;
            return false;
        }
    });
    $('.product-video-carousel').owlCarousel({
        items: 1,
        nav: true,
        dots: false,
        rtl: true,
        loop: false,
        touchDrag: false,
        mouseDrag: false,
        pullDrag: false,
        lazyLoad: true,
    });
    $('.modal').on('hide.bs.modal', function () {
        if ($(this).find('video').length > 0) {
            $(this).find('video').get(0).pause();
        }
    });

    $(document).on("click", ".responsive-menu .toggle-menu", function () {
        $(this).next(".menu-popup").addClass('show');
    });
    $(document).on("click", ".responsive-menu .overlay", function () {
        $(this).prev(".menu-popup").removeClass('show');
    });
    $(".responsive-menu nav li.menu-item-has-children,footer#footer .footer-copyright nav.footer-menu li.menu-item-has-children").each(function () {
        let childLink = $(this).children('a');
        childLink.after('<span class="toggle" style="height: ' + childLink.outerHeight() + 'px; width: ' + childLink.outerHeight() + 'px"><i class="fal fa-angle-down"></i></span>');
    });
    $(document).on("click", ".responsive-menu nav li.menu-item-has-children span.toggle", function () {
        $(this).toggleClass('active');
        let __self = $(this);
        $(this).next('ul').slideToggle('fast', function () {
            let targetHeight = __self.prev('a').outerHeight();
            $(this).find('span.toggle').each(function () {
                $(this).css({'height': targetHeight, 'width': targetHeight});
            });
        });
    });

    $(document).on('change', ".woocommerce-ordering select.orderby", function () {
        $('.products-archive-tabs button').removeClass('active');
        $('#btn-sort-' + $(this).val()).addClass('active');
    });

    $('.product-section .product-featured-attrs ul li:nth-of-type(3) ~ li').hide();
    if ($('.product-section .product-featured-attrs ul li').length > 3) {
        $('.product-section .product-featured-attrs ul').after('<a href="javascript:void(0)" class="view-more">... <span class="show">دیدن همه</span><span class="hide">کوتاه کردن</span></a>')
    }
    $(document).on('click', '.product-section .product-featured-attrs .view-more', function () {
        $(this).toggleClass('close-more');
        $('.product-section .product-featured-attrs ul li:nth-of-type(3) ~ li').slideToggle('fast');
    });

    $('.cart-header-steps .owl-carousel').owlCarousel({
        rtl: true,

        center: true,
        items: 2,
        loop: true,
        margin: 10,
        responsive: {
            600: {
                items: 4
            }
        }
    });


    $('#questionModal form').on('submit', function () {
        $('#submit-question-form').attr('disabled', true);
    });
    $('.send-question').on('click', function () {
        if ($('body').hasClass('logged-in')) {
            let questionParent = parseInt($(this).data('parent')) ?? 0;
            $('#question_parent').val(questionParent);
            if (questionParent > 0) {
                $('#questionModal .new-question').hide();
                $('#questionModal .replay-question').show();
            } else {
                $('#questionModal .new-question').show();
                $('#questionModal .replay-question').hide();
            }


            $('#questionModal').modal('show');
        } else {
            $('#login-popup-modal').modal('show');
        }
        return false;
    });


    if (window.location.href.indexOf("#question-") > -1 || window.location.href.indexOf("#questions") > -1 || window.location.href.indexOf("#tab-ns_questions") > -1) {
        setTimeout(() => {
            $('a[href="#tab-ns_questions"]').trigger('click');
        }, 1000);
    }

    $(document).on('change', '.woocommerce-cart-form', function () {
        setTimeout(() => {
            $(this).find('[name="update_cart"]').trigger('click');
        }, 1000);
    });
    $('.input-has-map').each(function () {
        let mapContent = '<div class="negarshop-map" id="' + $(this).data('map') + '"></div>';
        if ($(this).parents('.woocommerce-billing-fields').length > 0) {
            $('.woocommerce-billing-fields__field-wrapper').append(mapContent);

            $(document).on('change', '#billing_city', function () {
                if ($(this).val() !== null) {
                    let searchUrl = 'https://nominatim.openstreetmap.org/search?format=json&state=' + encodeURI($('#billing_state option:selected').text()) + '&city=' + encodeURI($('#billing_city option:selected').text());
                    $.get(searchUrl, (response) => {
                        if (response.length > 0) {
                            marker.setLatLng(new L.LatLng(response[0].lat, response[0].lon), {draggable: 'true'});
                            map.setView(marker.getLatLng(), map.getZoom());
                        }
                    });
                }
            });
        }

        if ($(this).parents('.woocommerce-shipping-fields').length > 0) {
            $('.woocommerce-shipping-fields__field-wrapper').append(mapContent);

            $(document).on('change', '#shipping_city', function () {
                if ($(this).val() !== null) {
                    let searchUrl = 'https://nominatim.openstreetmap.org/search?format=json&state=' + encodeURI($('#shipping_state option:selected').text()) + '&city=' + encodeURI($('#shipping_city option:selected').text());
                    $.get(searchUrl, (response) => {
                        if (response.length > 0) {
                            marker.setLatLng(new L.LatLng(response[0].lat, response[0].lon), {draggable: 'true'});
                            map.setView(marker.getLatLng(), map.getZoom());
                        }
                    });
                }

            });
        }

        let mapValue = $(this).val();

        if (mapValue.replaceAll(' ', '') !== '') {
            mapValue = mapValue.split(',');
        }

        if (mapValue.length !== 2) {
            mapValue = negarshop_obj.checkout_location;
        }

        if (mapValue.length !== 2) {
            mapValue = [38.0717, 46.3115];
            $('#billing_city').trigger('change');
            $('#shipping_city').trigger('change');
        }

        let map = L.map($(this).data('map'), {
            center: mapValue,
            dragging: true,
            zoom: 14
        });
        L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        let marker = new L.marker(mapValue, {
            draggable: true,
            autoPan: true
        }).addTo(map);

        map.on('click', (e) => {
            marker.setLatLng(e.latlng, {draggable: 'true'});
        });
        marker.on('move', () => {
            $(this).val(marker.getLatLng().lat + ',' + marker.getLatLng().lng);
        });


    });
    if (typeof Dropzone !== 'undefined' && $('#comment-attachments').length > 0) {
        Dropzone.autoDiscover = false;
        let commentAttachments = [];
        let myDropzone = new Dropzone("#comment-attachments", {
            url: negarshop_obj.ajax_url,
            maxFilesize: 2,
            maxFiles: 5,
            acceptedFiles: 'image/png,image/jpg,image/jpeg',
            dictDefaultMessage: 'برای پیوست تصویر فایل خود را بکشید و اینجا رها کنید!',
            dictFileTooBig: 'فایل نباید بیشتر از 2 مگابایت باشد!',
            dictInvalidFileType: 'فقط فایل های با فرمت jpg و png قابل قبول هستند!'
        });

        myDropzone.on('sending', function (file, xhr, formData) {
            formData.append('action', 'negarshop_comment_attachments');
            formData.append('nonce', NSDP.nonce);
        });
        myDropzone.on("processing", function () {
            $('#commentform #submit').addClass('disabled');
        });
        myDropzone.on("queuecomplete", function () {
            $('#commentform #submit').removeClass('disabled');
        });
        myDropzone.on("success", function (file) {
            let response = JSON.parse(file.xhr.response);
            if (typeof response.success !== 'undefined') {
                if (response.success) {
                    commentAttachments.push(response.attach);
                    $('#comment-attach-ids').val(commentAttachments.join(','));
                } else {
                    alert(response.data?.message ?? 'خطایی رخ داده است!');
                }
            }
        });
    }

    $('.comment-attachments').lightGallery({
        selector: 'a'
    });

    $(document).ready(function () {
        setTimeout(() => {
            $('.ns-page-loader').fadeOut('slow');
        }, 1000);
    });

    $(document).ready(function () {
        let productSidebarSticky = $('.product-side-col .product-sidebar').stickySidebar({
            topSpacing: 20,
            bottomSpacing: 20,
        });
        let productTabsSticky = $('.product-single-style-3 .product-tabs-outer.sticky').stickySidebar({
            topSpacing: 0,
            containerSelector: '.wc-tabs-wrapper'
        });
    });

    $(document).on('click', '#responsive-categories-page .terms-list .item-parent[data-parent]', function () {
        let targetItem = $(this).attr('data-parent');
        $(this).parents('.terms-list').hide();
        $('#responsive-categories-page .term-item-' + targetItem).parent('.terms-list').slideDown('fast');

    });
    $(document).on('click', '#responsive-categories-page .terms-list a .arrow[data-target]', function () {
        let targetItem = $(this).attr('data-target');
        $('#responsive-categories-page .terms-list').hide();
        $('#responsive-categories-page .child-term-' + targetItem).slideDown('fast');

        return false;
    });

    $(document).on('click', '#responsive-footer-bar a', function () {
        let targetElement = $(this).attr('href');
        let barContents = $('#responsive-contents');
        let parentLI = $(this).parents('li');
        let parentUL = $(this).parents('ul');

        if (parentLI.hasClass('back-item')) {
            parentLI.removeClass('show-item');
            parentUL.find('.active-item').removeClass('active-item');
            parentLI.addClass('active-item');

            barContents.removeClass('show-menu');
            $('#responsive-footer-bar').removeClass('page-is-showing');
            $('body').removeClass('mobile-panel-showing');
            return false;
        }

        if ((parentLI.hasClass('current-page') && parentLI.hasClass('not-ajax')) || parentLI.hasClass('close-page')) {
            $("html, body").stop().animate({scrollTop: 0}, "fast");

            parentUL.find('.active-item').removeClass('active-item');
            parentLI.addClass('active-item');

            barContents.removeClass('show-menu');
            $('#responsive-footer-bar').removeClass('page-is-showing');
            $('body').removeClass('mobile-panel-showing');

            return false;
        }


        if (!parentLI.hasClass('not-ajax')) {
            parentUL.find('.active-item').removeClass('active-item');
            parentLI.addClass('active-item');

            if ($(targetElement).length > 0) {
                barContents.children('div').not(targetElement).hide();
                barContents.addClass('show-menu');
                $('#responsive-footer-bar').addClass('page-is-showing');
                $('body').addClass('mobile-panel-showing');
                barContents.find(targetElement).fadeIn('fast');
                barContents.stop().animate({scrollTop: 0}, "fast");
            }


            if (parentUL.find('.current-page').length === 0) {
                parentUL.find('.back-item').addClass('show-item');
            }

            return false;
        }


        if (parentLI.hasClass('not-ajax') && !parentLI.hasClass('current-page')) {
            parentLI.addClass('pending-show');
            $('body').addClass('mobile-loading');
            parentUL.find('.active-item').removeClass('active-item');
            barContents.removeClass('show-menu');
            $('#responsive-footer-bar').removeClass('page-is-showing');
            $('body').removeClass('mobile-panel-showing');
        }
    });

    $(document).on('click', '.panel-mobile-title .panel-close', function () {
        $(this).parents('.woocommerce-Tabs-panel').removeClass('show-panel');
        $(this).parents('.product-summary-left').removeClass('show-panel');
        $('body').removeClass('mobile-panel-showing');
        return false;
    });

    $(document).on('mouseup', 'ul.wc-tabs li a', function () {
        let targetElement = $(this).attr('href');

        $('body').addClass('mobile-panel-showing');
        $(targetElement).addClass('show-panel');
        $(targetElement).stop().animate({scrollTop: 0}, "fast");
        return false;
    });

    $(document).on('click', '.product-single-responsive-bar .show-addtocart', function () {
        $('.product-summary-left').addClass('show-panel').stop().animate({scrollTop: 0}, "fast");
        $('body').addClass('mobile-panel-showing');
        return false;
    });

    $(document).on('click', '.product-single-responsive-bar .show-actions', function () {
        $('.product-single-actions').addClass('show-panel');
        $('body').addClass('mobile-panel-showing');
        return false;
    });
    $(document).on('click mouseup', '.ns-mobile-dimmer, .product-single-actions', function () {
        $('.product-single-actions').removeClass('show-panel');
        $('body').removeClass('mobile-panel-showing');
        return false;
    });

    $(document).on('click', '.header-cart-basket.cart-mode-popup .cart-basket-box', function (e) {
        e.preventDefault();
        $(this).parents('.cart-mode-popup').addClass('show-cart');
        $(this).parents('.cart-mode-popup').find('.ns-closer').fadeIn('fast');
    });
    $(document).on('click', '.header-cart-basket.cart-mode-popup .ns-closer, .header-cart-basket.cart-mode-popup .cart-items-header .header-close', function (e) {
        e.preventDefault();
        $(this).parents('.cart-mode-popup').removeClass('show-cart');
        $(this).parents('.cart-mode-popup').find('.ns-closer').fadeOut('fast');
    });
    $(document).on('click', '.product-filters-toggle', function (e) {
        e.preventDefault();
        $('.product-archive-filters--popup .shop-archive-sidebar').toggleClass('show');
    });

    $(document).ready(function () {
        let archive_categories_carousel = $('.archive-product-categories .owl-carousel');

        archive_categories_carousel.owlCarousel({
            rtl: true,
            nav: true,
            loop: false,
            autoplay: true,
            autoplayTimeout: 7000,
            autoplayHoverPause: false,
            dots: false,
            responsive: {
                0: {items: 2,},
                480: {items: 2,},
                700: {items: 3,},
                991: {items: 6,},
            },
            margin: 15
        });
    });

})(jQuery);

function NegarshopCreateCustomAlert(txt) {
    d = document;

    if (d.getElementById("negarshopAlertContainer")) return;

    mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
    mObj.id = "negarshopAlertContainer";
    mObj.style.height = d.documentElement.scrollHeight + "px";

    alertObj = mObj.appendChild(d.createElement("div"));
    alertObj.id = "negarshopAlertBox";
    if (d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
    alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth) / 2 + "px";
    alertObj.style.visiblity = "visible";

    h1 = alertObj.appendChild(d.createElement("h1"));
    h1.appendChild(d.createTextNode('پیغام'));

    msg = alertObj.appendChild(d.createElement("p"));
    //msg.appendChild(d.createTextNode(txt));
    msg.innerHTML = txt;

    btn = alertObj.appendChild(d.createElement("a"));
    btn.id = "closeBtn";
    btn.appendChild(d.createTextNode('تایید'));
    btn.href = "javascript:void(0)";
    btn.focus();
    btn.onclick = function () {
        NegarshopRemoveCustomAlert();
        return false;
    }

    alertObj.style.display = "block";

}

function NegarshopRemoveCustomAlert() {
    document.getElementsByTagName("body")[0].removeChild(document.getElementById("negarshopAlertContainer"));
}

function archive_btn(e) {
    let searchField = jQuery(e).parents('.header-search').find('.search-input.search-field');
    searchField.val(decodeURI(encodeURI(searchField.val())));
    jQuery(e).parents('.header-search').find('form').submit();
}

jQuery(document).ready(function (a) {
    "use strict";
    a(".show-ywsl-box").on("click", function (b) {
        b.preventDefault(), a(".ywsl-box").slideToggle()
    }), "#_=_" == window.location.hash && (history.replaceState ? history.replaceState(null, null, window.location.href.split("#")[0]) : window.location.hash = "")
});
jQuery(document).ready(function (a) {
    "use strict";
    let b = function () {
        let b = a(document).find("#yith-wcwtl-email"), c = b.parents("#yith-wcwtl-output").find("a.button"),
            d = c.attr("href");
        b.length && b.on("input", function (a) {
            let e = b.val(), f = b.attr("name");
            c.prop("href", d + "&" + f + "=" + e)
        })
    };
    b(), a("form.variations_form").on("show_variation", b), a(document).on("qv_loader_stop", b)
});

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register(negarshop_obj.service_worker);
}

const isInStandaloneMode = () =>
    (window.matchMedia('(display-mode: standalone)').matches) || (window.navigator.standalone) || document.referrer.includes('android-app://');


if (isInStandaloneMode()) {
    jQuery('body').prepend('<div class="pwa-page-loader"><span class="spinner"></span></div>');
    setTimeout(function () {
        jQuery('.pwa-page-loader').remove();
    }, 10000);

    jQuery(document).ready(function ($) {
        let beforeunloadcount = 0;
        jQuery('.pwa-page-loader').remove();

    });
    window.addEventListener('beforeunload', () => {
        jQuery('body').prepend('<div class="pwa-page-loader"><span class="spinner"></span></div>');
        setTimeout(function () {
            jQuery('.pwa-page-loader').remove();
        }, 10000);
    });
}

/** Keyboard shortcodes **/

(function ($) {
    $(document).on("keydown", function (e) {
        // Adding the search keyboard shortcode.
        if (
            (e.ctrlKey && e.which === 75) // ctrl + k
            || (e.ctrlKey && e.which === 70) // ctrl + f
        ) {
            let searchBox = $(".header-search .search-input");
            if (searchBox.length <= 0) {
                return false;
            }
            $("html, body").stop().animate({scrollTop: searchBox.first().offset().top - 60}, 500, 'swing', function () {
                searchBox.first().focus();
            });
        }
    });
})(jQuery);

/**
 * Smart login
 */

(function ($) {
    $(document).ready(function () {
        let login = $(".smart-login");
        if (login.length <= 0) {
            return;
        }

        if (login.find("#ns-mobile").val().length > 0) {
            login.find(".step-one-submit").removeClass("disabled");
        }
    });
    $(document).on("keyup change", ".smart-login #ns-mobile", function () {
        if ($(this).val().length > 0) {
            $(this).parents(".smart-login").find(".step-one-submit").removeClass("disabled");
        } else {
            $(this).parents(".smart-login").find(".step-one-submit").addClass("disabled");
        }
    });
    $(document).on("keyup change", ".smart-login #ns-password", function () {
        if ($(this).val().length > 0) {
            $(this).parents(".smart-login").find(".password-login-submit").removeClass("disabled");
        } else {
            $(this).parents(".smart-login").find(".password-login-submit").addClass("disabled");
        }
    });
    $(document).on("keyup change", ".smart-login #auth-code", function (e) {
        if (e.key === undefined) {
            return;
        }
        if ($(this).val().length === 5) {
            $(this).parents(".smart-login").find(".auth-login-submit").removeClass("disabled");
            $(this).parents(".smart-login").trigger("smart_login_step2");
        } else {
            $(this).parents(".smart-login").find(".auth-login-submit").addClass("disabled");
        }
    });
    $(document).on("smart_login_step1", ".smart-login", function (e) {
        if ($(this).hasClass("loading")) {
            return;
        }
        $(this).addClass('loading');
        $(this).find('.login-result').text('');
        let mobile = $(this).find("input#ns-mobile");
        mobile.attr("readonly", true);
        $.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_smart_login',
            'mobile': mobile.val(),
            '_nonce': $(this).find("[name='_wpnonce']").val(),
        }, (response) => {
            $(this).removeClass('loading');

            if (!response.success) {
                $(this).find('.login-result').text(response.data.message);
                setTimeout(() => {
                    $(this).find('.login-result').text('');
                }, 5000);
                mobile.attr("readonly", false);
            } else {
                if (response.data.login.type === "mobile") {
                    $(this).trigger("smart_login_change_step", {
                        step: 2, frag: {
                            '.user-mobile': response.data.login.user
                        }
                    });
                    $(this).trigger("smart_login_step2_load", {timer: response.data.login.timer});
                }
                if (response.data.login.type === "email") {
                    $(this).trigger("smart_login_change_step", {
                        step: 3
                    });
                    $(this).trigger("smart_login_step3_load");
                }
            }
        });
    });
    $(document).on("smart_login_step2_load", ".smart-login", function (e, data) {
        let smsTimer = $(this).find('.sms-timer');
        const d = new Date();
        d.setSeconds(d.getSeconds() + data.timer);
        smsTimer.countdown(d, function (event) {
            $(this).html(event.strftime('%M:%S'));

            if (event.elapsed) {
                $(this).parents('.smart-login').find(".resend-code").show();
            } else {
                $(this).parents('.smart-login').find(".resend-code").hide();
            }
        });

        $(this).find("#auth-code").val("");
        $(this).find("#auth-code").focus();
    });
    $(document).on("smart_login_step3_load", ".smart-login", function (e, data) {
        $(this).find("#ns-password").focus();
    });
    $(document).on("smart_login_step2", ".smart-login", function (e, data) {
        if ($(this).hasClass("loading")) {
            return;
        }
        let code = $(this).find("input#auth-code");
        if (code.val().length !== 5) {
            code.focus();
            return;
        }

        $(this).addClass('loading');
        $(this).find('.login-result').text('');
        let mobile = $(this).find("input#ns-mobile");
        let redirect = $(this).find("input[name='ns-redirect']").val();
        code.attr("readonly", true);
        $.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_smart_login_auth',
            'mobile': mobile.val(),
            'code': code.val(),
            'redirect': redirect,
            '_nonce': $(this).find("[name='_wpnonce']").val(),
        }, (response) => {
            $(this).find('.login-result').text(response.data.message);
            setTimeout(() => {
                $(this).find('.login-result').text('');
            }, 5000);
            if (!response.success) {
                $(this).removeClass('loading');
                code.attr("readonly", false);
            } else if (response.success && response.data.code === 200) {
                window.location.replace(response.data.redirect);

                setTimeout(() => {
                    window.location.href = response.data.redirect;
                }, 10000);
            }
        });
    });
    $(document).on("smart_login_step3", ".smart-login", function (e, data) {
        if ($(this).hasClass("loading")) {
            return;
        }
        let pass = $(this).find("input#ns-password");
        if (pass.val().length <= 0) {
            pass.focus();
            return;
        }

        $(this).addClass('loading');
        $(this).find('.login-result').text('');
        let email = $(this).find("input#ns-mobile");
        let redirect = $(this).find("input[name='ns-redirect']").val();
        pass.attr("readonly", true);
        $.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_smart_login_email_pass',
            'email': email.val(),
            'password': pass.val(),
            'redirect': redirect,
            '_nonce': $(this).find("[name='_wpnonce']").val(),
        }, (response) => {
            $(this).find('.login-result').html(response.data.message);
            setTimeout(() => {
                $(this).find('.login-result').text('');
            }, 5000);
            if (!response.success) {
                $(this).removeClass('loading');
                pass.attr("readonly", false);
            } else if (response.success && response.data.code === 200) {
                window.location.replace(response.data.redirect);

                setTimeout(() => {
                    window.location.href = response.data.redirect;
                }, 10000);
            }
        });
    });
    $(document).on("click", ".smart-login .resend-code", function (e, data) {
        $(this).parents(".smart-login").trigger("smart_login_step1");
    });
    $(document).on("click", ".smart-login .back-btn", function (e, data) {
        $(this).parents(".smart-login").trigger("smart_login_change_step", {
            step: 1
        });
        let inputs = $(this).parents('.smart-login').find('#ns-mobile, #ns-password, #auth-code');
        inputs.val("");
        inputs.attr("readonly", false);
    });
    $(document).on("smart_login_change_step", ".smart-login", function (e, data) {
        $(this).find("[name='step']").val(data.step);
        $(this).find('.login-steps').hide();
        $(this).find('.step-' + data.step).slideDown("fast");

        if (parseInt(data.step) > 1) {
            $(this).find(".back-btn").slideDown("fast");
        } else {
            $(this).find(".back-btn").slideUp("fast");
        }

        if (typeof data.frag === "object") {
            Object.keys(data.frag).forEach((item) => {
                $(this).find('.step-' + data.step).find(item).html(data.frag[item]);
            });
        }
    });

    $(document).on("submit", ".smart-login .login-form", function (e) {
        e.preventDefault();

        let step = $(this).find("[name='step']").val();
        if ('1' === step) {
            $(this).parents(".smart-login").trigger("smart_login_step1");
        }
        if ('2' === step) {
            $(this).parents(".smart-login").trigger("smart_login_step2");
        }
        if ('3' === step) {
            $(this).parents(".smart-login").trigger("smart_login_step3");
        }
    });
})(jQuery);

/**
 * My account mobile verification.
 */
(function ($) {
    $(document).on("click", ".negarshop-mobile-verify-form .send-code", function (e) {
        e.preventDefault();
        $(this).parents(".negarshop-mobile-verify-form").trigger("send_code");
    });
    $(document).on("click", ".negarshop-mobile-verify-form.step-2 .verify-code", function (e) {
        e.preventDefault();
        $(this).parents(".negarshop-mobile-verify-form").trigger("verify_code");
    });
    $(document).on("send_code", ".negarshop-mobile-verify-form", function () {
        if ($(this).hasClass("loading")) {
            return;
        }
        $(this).addClass('loading');
        $(this).find('.login-result').text('');
        let mobile = $(this).find("input#ns-mobile");
        mobile.attr("readonly", true);
        $.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_smart_login_myaccount_verify_mobile',
            'mobile': mobile.val(),
            '_nonce': $(this).find("[name='ns-nonce']").val(),
        }, (response) => {
            $(this).removeClass('loading');

            if (!response.success) {
                $(this).find('.login-result').text(response.data.message);
                setTimeout(() => {
                    $(this).find('.login-result').text('');
                }, 5000);
                mobile.attr("readonly", false);
            } else {
                $(".negarshop-mobile-verify-form").hide();
                $(".negarshop-mobile-verify-form.step-2").slideDown("fast");
                $(".negarshop-mobile-verify-form.step-2 .user-mobile").text(response.data.data.mobile);
                $(".negarshop-mobile-verify-form.step-2 input#ns-mobile-number").val(response.data.data.mobile);
            }
        });
    });
    $(document).on("verify_code", ".negarshop-mobile-verify-form", function () {
        if ($(this).hasClass("loading")) {
            return;
        }
        let code = $(this).find("input#ns-mobile-verify");
        if (code.val().length === 0) {
            return;
        }

        $(this).addClass('loading');
        $(this).find('.login-result').text('');
        let mobile = $(this).find("input#ns-mobile-number");
        code.attr("readonly", true);
        $.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_smart_login_myaccount_verify_mobile',
            'mobile': mobile.val(),
            'code': code.val(),
            '_nonce': $(this).find("[name='ns-nonce']").val(),
        }, (response) => {
            $(this).removeClass('loading');

            if (!response.success) {
                $(this).find('.login-result').text(response.data.message);
                setTimeout(() => {
                    $(this).find('.login-result').text('');
                }, 5000);
                code.attr("readonly", false);
            } else {
                $(".negarshop-mobile-verify-form").remove();
                $(".negarshop-mobile-verify-form.step-2").addClass("loading");
                window.location.reload();
            }
        });
    });
})(jQuery);