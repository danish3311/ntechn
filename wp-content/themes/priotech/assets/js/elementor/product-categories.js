(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            elementorFrontend.elementsHandler.addHandler(priotechSwiperBase, {
                $element,
            })
        }
        elementorFrontend.hooks.addAction('frontend/element_ready/priotech-product-categories.default', addHandler);
    })
})(jQuery);
