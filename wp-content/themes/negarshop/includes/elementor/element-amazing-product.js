jQuery( window ).on( 'elementor/frontend/init', () => {
    elementorFrontend.hooks.addAction( 'frontend/element_ready/negarshop_amazing_product.default', function($scope, $){
        $scope.find('.owl-carousel').trigger('owl-init');
    });
} );
