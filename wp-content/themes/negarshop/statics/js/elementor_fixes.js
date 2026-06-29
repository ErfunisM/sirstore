jQuery( window ).on( 'elementor/frontend/init', () => {
    if ( window.elementorFrontend ) {
        elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $scope ) {
            jQuery('img.lazy').each(function () {
                jQuery(this).attr('src',jQuery(this).attr('data-src'));
            });
            jQuery('.negarshop-countdown').each(function () {
                var date= '0000/00/00';
                if(jQuery(this).attr("data-date") !== undefined){
                    date = jQuery(this).attr("data-date");
                }
                jQuery(this).countdown(date, function(event) {
                    jQuery(this).html(event.strftime('<div class="inner"><span class="countdown-section"><span class="countdown-amount">%D</span><span class="countdown-period">روز</span></span><span class="countdown-section"><span class="countdown-amount">%H</span><span class="countdown-period">ساعت</span></span><span class="countdown-section"><span class="countdown-amount">%M</span><span class="countdown-period">دقیقه</span></span><span class="countdown-section"><span class="countdown-amount">%S</span><span class="countdown-period">ثانیه</span></span></div>'));
                });
            });
        } );
    }
});