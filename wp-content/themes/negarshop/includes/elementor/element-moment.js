jQuery( window ).on( 'elementor/frontend/init', () => {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/negarshop_moment.default', function($scope, $){
        $scope.find('.owl-carousel').each(function () {
            var carouselSEL = $(this);
            var carinit = carouselSEL.owlCarousel({
                items: 1,
                rtl: true,
                dots: false,
                touchDrag: false,
                mouseDrag: false,
                pullDrag: false,
                loop: true,
                nav: false,
                autoplay:true,
                autoplayTimeout:7000,
                autoplayHoverPause:false,
                onInitialized: function () {
                    carouselSEL.parents('.offer-moments').addClass('animate-bar');
                }
            });
        });
    });
} );
