jQuery(function($) {
    "use strict";
    var variables = {};
    var request_sendable = true;
    var product_id = $('.woocommerce.single-product form.variations_form.cart').attr('data-product_id');
    $('.woocommerce .variations_form.cart select.custom-select').each(function() {
        var variable_name = $(this).attr("data-attribute_name");
        var variable_value = $(this).val();
        variables[variable_name] = variable_value;
    });
    $('.woocommerce .variations_form.cart select.custom-select').change(function() {
		var clock_selector = $('.woocommerce.single-product .sale-timer .flip-clock-a');
        if ($(this).val() !== "") {
            $('.woocommerce.single-product .sale-timer .negarshop-loading').show();
            var variable_name = $(this).attr("data-attribute_name");
            var variable_value = $(this).val();
            variables[variable_name] = variable_value;
            var data_to_send = {};
            data_to_send = variables;
            data_to_send['product_id'] = product_id;
            data_to_send['action'] = 'negarshop_ajax_variable_product';
            if (request_sendable) {
                request_sendable = false;
                jQuery.post(negarshop_obj.ajax_url, data_to_send, function(response) {
                    if (response.status) {
                        $('.woocommerce.single-product .sale-timer').slideDown('fast');
                        var discount = 0;
                        discount = parseInt(response.data.prices.reg) - parseInt(response.data.prices.sale);
                        $('.woocommerce.single-product .sale-timer .left .discount span').text(accounting.formatMoney(discount, "", 0) + " " + response.data.prices.currency_symbol);
                        var endTime = parseInt(response.data.dates.end) - parseInt(response.data.dates.now);
                        clock_selector.html("");
                        clock_selector.removeAttr("class");
                        clock_selector.addClass("flip-clock-a");
                        var clock;
                        clock = $('.woocommerce.single-product .sale-timer .flip-clock-a').FlipClock(endTime, {
                            clockFace: 'DailyCounter',
                            autoStart: false,
                            language: 'fa',
                            showSeconds: true,
                            callbacks: {
                                stop: function() {
                                    window.location.assign('/');
                                }
                            }
                        });
                        clock.setCountdown(true);
                        clock.start();
                    } else {
                        $('.woocommerce.single-product .sale-timer').slideUp('fast');
                        $('.woocommerce.single-product .sale-timer .left .discount span').text('-');
                        clock_selector.html("");
                        clock_selector.removeAttr("class");
                        clock_selector.addClass("flip-clock-a");
                    }
                    $('.woocommerce.single-product .sale-timer .negarshop-loading').hide();
                    request_sendable = true;
                });
            }
        } else {
			$('.woocommerce.single-product .sale-timer').slideUp('fast');
			$('.woocommerce.single-product .sale-timer .left .discount span').text('-');
			clock_selector.html("");
			clock_selector.removeAttr("class");
			clock_selector.addClass("flip-clock-a");
		}
    });
    $('.woocommerce .variations_form.cart select.custom-select').change();
});