(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            if(!$element.hasClass('smoot-carousel-yes')) {
                elementorFrontend.elementsHandler.addHandler(priotechSwiperBase, {
                    $element,
                })
            }
            else {
                let $tickerWrapper = $(".smoot-carousel-yes .elementor-image-carousel-item-wrapper");
                let $list = $tickerWrapper.find(".priotech-con");
                let $clonedList = $list.clone();
                let listWidth = 0;

                $list.find(".priotech-con-inner").each(function (i) {
                    listWidth += $(this, i).outerWidth(true);
                });

                let endPos = $tickerWrapper.width() - listWidth;

                $list.add($clonedList).css({
                    "width" : listWidth + "px"
                });

                $clonedList.addClass("cloned").appendTo($tickerWrapper);

                //TimelineMax
                let infinite = new TimelineMax({repeat: -1, paused: true});
                let time = 40;

                infinite
                    .fromTo($list, time, {rotation:0.01,x:0}, {force3D:false, x: -listWidth, ease: Linear.easeNone}, 0)
                    .fromTo($clonedList, time, {rotation:0.01, x:listWidth}, {force3D:false, x:0, ease: Linear.easeNone}, 0)
                    .set($list, {force3D:false, rotation:0.01, x: listWidth})
                    .to($clonedList, time, {force3D:false, rotation:0.01, x: -listWidth, ease: Linear.easeNone}, time)
                    .to($list, time, {force3D:false, rotation:0.01, x: 0, ease: Linear.easeNone}, time)
                    .progress(1).progress(0)
                    .play();

                // Pause/Play
                $tickerWrapper.on("mouseenter", function(){
                    infinite.pause();
                }).on("mouseleave", function(){
                    infinite.play();
                });
            }
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/priotech-image-carousel.default', addHandler);
    })
})(jQuery);
