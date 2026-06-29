/**
 * @author CoderBoy team
 */
(function ($) {
    "use strict";
    $.fn.size = function () {
        return this.length;
    };
    $('#page_template').change(function () {
        $('#fw-options-box-magical_box_options').hide();
        $('#fw-options-box-default_page_options').hide();
        $('#fw-options-box-aof_page_options').hide();

        if ($(this).val() === "magical-box.php") {
            $('#fw-options-box-magical_box_options').slideDown();
        } else if ($(this).val() === "amazing-offer.php") {
            $('#fw-options-box-aof_page_options').slideDown();
        } else if ($(this).val() === "default") {
            $('#fw-options-box-default_page_options').slideDown();
        }
    });
    $('#page_template').change();
    $(document).on('click', '.cb_addable_image .add-btn', function () {
        var thisitem = $(this);
        var image_frame;
        if (image_frame) {
            image_frame.open();
        }
        // Define image_frame as wp.media object
        image_frame = wp.media({
            title: 'Select Media',
            multiple: false,
            library: {
                type: 'image',
            }
        });

        image_frame.on('close', function () {
            let selection = image_frame.state().get('selection');
            selection.each(function (attachment) {
                var inp_name = thisitem.attr("data-name");
                thisitem.parent().find('.image-items').append('<div class="img-item"><img src="' + attachment.changed.url + '" alt=""><i>X</i><input name="' + inp_name + '[]" value="' + attachment['id'] + '" type="hidden"></div>');

            });
        });

        image_frame.on('open', function () {
            let selection = image_frame.state().get('selection');
        });

        image_frame.open();

        $(this).parents('.woocommerce_variation').find('.wc_input_price').trigger('change');


    });
    $(document).on('click', '.cb_addable_image .img-item i', function () {
        $(this).parent().remove();
        $(this).parents('.woocommerce_variation').find('.wc_input_price').trigger('change');
    });

    $(document).on('click', '.comment-attachments .remove-item', function () {
        $(this).addClass('disabled');
        let commentID = $(this).data('comment-id') ?? '0';
        let attachID = $(this).data('attach-id') ?? '0';

        $.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_comment_attach_remove',
            'attach': attachID,
            'comment': commentID
        }, (response) => {
            if (typeof response.success !== 'undefined') {
                if (response.success) {
                    $(this).parents('li').remove();
                } else {
                    alert(response.message);
                }
            }
        });
    });
})(jQuery);
