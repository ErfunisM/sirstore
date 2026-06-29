(function ($) {
    "use strict";

    $(document).on("change check", "#grayscale", function () {
        if ($(this).is(":checked")) {
            $(".print-area").addClass('grayscale');
        } else {
            $(".print-area").removeClass('grayscale');
        }
    });

    $("#grayscale").trigger("check");

    $(document).on("change", "#factor-type", function () {
        $(this).parents('form').trigger("submit");
    });

    $(document).on("click", "#print-selected", function () {
        $("body").addClass('print-mode');
        window.print();
        setTimeout(() => {
            $("body").removeClass('print-mode');
        }, 2000);
    });
    
})(jQuery);