(function ($) {
    "use strict";

    function negarshop_get_compared_products() {
        let compareList = getCookie('negarshop_compared_products');
        if (compareList === '' && typeof compareList !== 'string') {
            return [];
        }

        compareList = decodeURIComponent(compareList);
        if (compareList.length <= 0) {
            return [];
        }
        return compareList.split(',');
    }

    function negarshop_add_compare_product(productID) {
        let compareList = negarshop_get_compared_products();
        if (compareList.includes(productID) !== true) {
            compareList.push(productID);
        }
        document.cookie = "negarshop_compared_products=" + compareList.join(',') + ";path=/";
    }

    function negarshop_remove_compare_product(productID) {
        let compareList = negarshop_get_compared_products();
        compareList = compareList.filter((item) => {
            return item !== productID;
        });

        document.cookie = "negarshop_compared_products=" + compareList.join(',') + ";path=/";
    }


    $(document).on('style', '.negarshop-product-compare', function (e) {
        $(this).find('table').each(function () {
            $(this).parent().css({'width': $(this).outerWidth()});
        });
    });
    $(document).on('click', '.negarshop-show-compare-table', function (e) {
        e.preventDefault();
        $('.negarshop-product-compare').addClass('visible');
        $('.negarshop-product-compare').trigger('style');
        $('body').addClass('negarshop-compare-table-is-showing');
    });
    $(document).on('click', '.negarshop-add-to-compare[data-product-id]', function (e) {
        e.stopPropagation();
        if ($(this).hasClass('added')) {
            $('.negarshop-product-compare').addClass('visible');
            $('body').addClass('negarshop-compare-table-is-showing');
            $('.negarshop-product-compare').trigger('style');
            return;
        }
        let productID = $(this).attr('data-product-id');
        let compareNonce = $(this).attr('data-nonce');
        if (isNaN(productID)) {
            return;
        }

        $(this).addClass('disabled');

        negarshop_add_compare_product(productID);
        $.post(negarshop_compare_obj.ajax_url, {
            'action': 'negarshop_add_to_compare_ajax',
            'product_id': productID,
            'nonce': compareNonce,
        }, (response) => {
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
                z_index: 99999,
                delay: 2000,
                timer: 1000,
            });

            if (response.status) {
                $(this).addClass('added');
                $(this).removeClass('disabled');

                if (response.count >= 1) {
                    $('.negarshop-product-compare .compare-items').html(response.content);
                    $('.negarshop-product-compare').trigger('style');
                }

                if (response.count > 1) {
                    $('.negarshop-product-compare').addClass('visible');
                    $('body').addClass('negarshop-compare-table-is-showing');
                }
            }
        });
    });

    $(document).on('click', '.negarshop-remove-from-compare[data-product-id]', function () {
        let productID = $(this).attr('data-product-id');
        let compareNonce = $(this).attr('data-nonce');
        if (isNaN(productID)) {
            return;
        }

        $(this).addClass('disabled');
        negarshop_remove_compare_product(productID);
        $.post(negarshop_compare_obj.ajax_url, {
            'action': 'negarshop_remove_from_compare_ajax',
            'product_id': productID,
            'nonce': compareNonce,
        }, (response) => {
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
                z_index: 99999,
                delay: 2000,
                timer: 1000,
            });

            if (response.status) {
                $(this).removeClass('disabled');
                $('.negarshop-product-compare .compare-items').html(response.content);
                $('.negarshop-product-compare').trigger('style');
                $('.negarshop-add-to-compare[data-product-id="' + productID + '"]').removeClass('added');

                if (response.count < 1) {
                    $('.negarshop-product-compare').removeClass('visible');
                    $('body').removeClass('negarshop-compare-table-is-showing');
                }
            }
        });
    });

    $(document).on('click', '.negarshop-product-compare .compare-header .header-buttons .buttons-close', function () {
        $(this).parents('.negarshop-product-compare').removeClass('visible');
        $('body').removeClass('negarshop-compare-table-is-showing');
    });
    $(document).on('click', '.negarshop-product-compare .compare-header .header-buttons .button-add-new', function () {
        $('.compare-product-search-popup').toggleClass('visible');
    });
})(jQuery);