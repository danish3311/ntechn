(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            elementorFrontend.elementsHandler.addHandler(priotechSwiperBase, {
                $element,
            })
        }

        if ($('.elementor-widget-priotech-banner-carousel .priotech-swiper').length > 0) {
            $('.elementor-widget-priotech-banner-carousel .priotech-swiper').on('swiperInit', function(e, slider) {
                slider.on('slideChangeTransitionStart', function (e) {
                    $('.elementor-banner-wrap-box-text .elementor-banner-box-text').hide(); 
                }); 
                
                slider.on('slideChangeTransitionEnd', function (e) {
                    $('.elementor-banner-wrap-box-text .elementor-banner-box-text').eq(e.realIndex).fadeIn();    
                }); 
            });    
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/priotech-banner-carousel.default', addHandler);
    })
    
})(jQuery);

