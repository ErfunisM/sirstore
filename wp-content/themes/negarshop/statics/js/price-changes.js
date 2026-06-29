jQuery(function($){
    "use strict";
    $('.price-changes button.cb-change-filter-btn').click(function(){
        var this_item = $(this);
        this_item.addClass('disabled');
        this_item.parents('.price-changes').find('table').addClass('loading');
        jQuery.post(negarshop_obj.ajax_url, {
            'action': 'negarshop_price_change_ajax',
            'query': {
                'cat':  this_item.parents('.cb-filters').find('select.cb-change-wc-cats').val(),
                /*'order': this_item.parents('.cb-filters').find('select.cb-change-wc-order').val(),*/
                'ppp':  this_item.parents('.cb-filters').find('select.cb-change-wc-ppp').val(),
                'columns':  this_item.attr('data-columns'),
                'date':  this_item.attr('data-date'),
                'stock':  this_item.parents('.cb-filters').find('.cb-change-wc-stock').is(":checked")

            },
        }, function(response) {
            if(response.status){
                this_item.parents('.price-changes').find('table').find('tbody').html(response.data);
                this_item.parents('.price-changes').find('.scrollbar-price').mCustomScrollbar();
            }
            this_item.parents('.price-changes').find('table').removeClass('loading');
            this_item.removeClass('disabled');
        });
        return false;
    });
    $('.price-changes button.cb-change-filter-btn').click();

});