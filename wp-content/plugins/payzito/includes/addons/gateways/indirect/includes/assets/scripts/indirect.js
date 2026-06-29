(function($){
    $(function(){

        if($('.pa-indirect-gateway').length > 0)
        {
            $("#pa-dpr-field-2").padatepicker({
                isRTL: true,
                dateFormat: "yy/mm/dd",
            });
            $("#pa-dpr-field-btn-2").click(function(event) {
                event.preventDefault();
                $("#pa-dpr-field-2").focus();
            });

            /* Amount Input Keyup */
            $('body').on('keyup','#pa-dpr-field-3',function(){
                $(this).val(modifyNumberBySeparator($(this).val()));
            });

            $("#pa-dpc-field-2").padatepicker({
                isRTL: true,
                dateFormat: "yy/mm/dd",
            });
            $("#pa-dpc-field-btn-2").click(function(event) {
                event.preventDefault();
                $("#pa-dpc-field-2").focus();
            });

            /* Amount Input Keyup */
            $('body').on('keyup','#pa-dpc-field-3',function(){
                $(this).val(modifyNumberBySeparator($(this).val()));
            });

            /* Change Paid Method */
            $('.pa-dp-send-data').on('click','',function(){
                var type = $(this).attr('method');
                PAChangeIndirectForm(type);
            });

            /* Start Time Picker 1 */
            $('#pa-dpr-field-2-a').wickedpicker({
                showSeconds: true,
                twentyFour: true, //Display 24 hour format, defaults to false
                title: indirectGatewayStatics['timePickerTime'],
            });

            /* Start Time Picker 2 */
            $('#pa-dpc-field-2-a').wickedpicker({
                showSeconds: true,
                twentyFour: true, //Display 24 hour format, defaults to false
                title: indirectGatewayStatics['timePickerTime'],
            });

            /* Set Calendar Default Value */
            $('input[name="paid_date"]').val(indirectGatewayStatics['currentTime']);
        }

    });
})(jQuery);

function PASendIndirectGatewayData(method)
{
    var data = {};
    var selector;
    var value = '';
    var warningIcon = 'pa-icon-triangle-exclamation';
    var successIcon = 'pa-icon-square-check';
    var msgClass = method == 1 ? '.pa-dp-receipt-msg' : '.pa-dp-card-msg';

    if(method == 1)
    {
        selector = jQuery('.pa-indirect-gateway .pa-dp-receipt-form');
    }
    else if(method == 2)
    {
        selector = jQuery('.pa-indirect-gateway .pa-dp-card-form');
    }
    else
    {
        return false;
    }

    data['method'] = method;

    if(selector.find('input[name="name_family"]').length > 0)
    {
        value = selector.find('input[name="name_family"]').val();
        if(selector.find('input[name="name_family"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value.length < 3 || value.length > 255)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidNameMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['name_family'] = value;
    }

    if(selector.find('input[name="paid_date"]').length > 0)
    {
        value = selector.find('input[name="paid_date"]').val();
        if(selector.find('input[name="paid_date"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value.length != 10)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidPaidDateMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['paid_date'] = value;
    }

    if(selector.find('input[name="paid_time"]').length > 0)
    {
        value = selector.find('input[name="paid_time"]').val();
        if(selector.find('input[name="paid_time"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value.length != 12)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidPaidTimeMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['paid_time'] = value;
    }

    if(selector.find('input[name="amount"]').length > 0)
    {
        value = selector.find('input[name="amount"]').val();
        value = removeSeparator(value);
        if(selector.find('input[name="amount"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value < 100)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidAmountMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['amount'] = value;
    }

    if(selector.find('textarea[name="description"]').length > 0)
    {
        if(selector.find('textarea[name="description"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value))
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidDescriptionMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        value = selector.find('textarea[name="description"]').val();
        data['description'] = value;
    }

    /* for 1 */
    if(method == 1 && selector.find('input[name="account_number"]').length > 0)
    {
        value = selector.find('input[name="account_number"]').val();
        if(selector.find('input[name="account_number"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value.length < 2 || value.length > 100)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidAccountNumberMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['account_number'] = value;
    }

    /* for 1 */
    if(method == 1 && selector.find('input[name="bank"]').length > 0)
    {
        value = selector.find('input[name="bank"]').val();
        if(selector.find('input[name="bank"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value.length < 2 || value.length > 100)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidBankMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['bank'] = value;
    }

    /* for 1 */
    if(method == 1 && selector.find('input[name="receipt_number"]').length > 0)
    {
        value = selector.find('input[name="receipt_number"]').val();
        if(selector.find('input[name="receipt_number"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value.length < 2 || value.length > 100)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidReceiptNumberMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['receipt_number'] = value;
    }

    /* for 2 */
    if(method == 2 && selector.find('input[name="to_card"]').length > 0)
    {
        value = selector.find('input[name="to_card"]').val();
        if(selector.find('input[name="to_card"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value.length < 2 || value.length > 100)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidToCardMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['to_card'] = value;
    }

    /* for 2 */
    if(method == 2 && selector.find('input[name="your_card"]').length > 0)
    {
        value = selector.find('input[name="your_card"]').val();
        if(selector.find('input[name="your_card"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value.length != 4)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidYourCardMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['your_card'] = value;
    }

    /* for 2 */
    if(method == 2 && selector.find('input[name="tracking_number"]').length > 0)
    {
        value = selector.find('input[name="tracking_number"]').val();
        if(selector.find('input[name="tracking_number"]').closest('.pa-dp-field').attr('status') == 1)
        {
            if(empty(value) || value.length < 2 || value.length > 100)
            {
                selector.find(msgClass).html(getMsgHtml(0,indirectGatewayStatics['invalidTrackingCodeMsg'],warningIcon));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
                return;
            }
        }
        data['tracking_number'] = value;
    }

    selector.find(msgClass).html(getMsgHtml(2,indirectGatewayStatics['loadingMsg'],'pa-icon-spinner'));
    selector.find(msgClass+' .pa-bt-msg').fadeIn(500);

    jQuery.ajax({
        type: "POST",
        url: indirectGatewayStatics['saveUrl'],
        data: data,
        success:function(result)
        {
            result = jsonDecode(result,[0,indirectGatewayStatics['unknownError']]);

            if(result[0] == 1)
            {
                jQuery('.pa-indirect-payment-form').hide();
                jQuery('.pa-indirect-gateway-options').hide();
                jQuery('.pa-indirect-payment-final').show();

                var el = jQuery('.pa-indirect-payment-final');
                var elOffset = el.offset().top;
                var elHeight = el.height();
                var windowHeight = jQuery(window).height();
                var offset;

                if (elHeight < windowHeight)
                {
                    offset = elOffset - ((windowHeight / 2) - (elHeight / 2));
                }
                else
                {
                    offset = elOffset;
                }

                jQuery("html,body").animate({scrollTop:offset},"slow");
            }
            else
            {
                selector.find(msgClass).html(getMsgHtml(result[0],result[1],(result[0] == 0 ? warningIcon : successIcon)));
                selector.find(msgClass+' .pa-bt-msg').fadeIn(500);
            }
        },
        error:function(xhr)
        {
            loadAjaxError(xhr);
        },
        timeout: 20000,
    });
}

function PAChangeIndirectForm(method)
{
    var selector = jQuery('.pa-main.pa-indirect-gateway');

    if(!selector || selector.find('.pa-indirect-gateway-options').attr('count') != 2)
    {
        return false;
    }

    jQuery('.pa-indirect-gateway-options .pa-dp-option[method="'+method+'"]').css({
        background: '#ddfae8'
    });
    jQuery('.pa-indirect-gateway-options .pa-dp-option[method="'+(method == 1 ? 2 : 1)+'"]').css({
        background: '#f5f5f5'
    });

    if(method == 1)
    {
        jQuery('.pa-indirect-payment-form .pa-dp-receipt-form').show();
        jQuery('.pa-indirect-payment-form .pa-dp-card-form').hide();
    }
    else if(method == 2)
    {
        jQuery('.pa-indirect-payment-form .pa-dp-receipt-form').hide();
        jQuery('.pa-indirect-payment-form .pa-dp-card-form').show();
    }
}