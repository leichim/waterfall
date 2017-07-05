/**
 * Custom JS for the WaterFall theme
 */
var Waterfall = {
    init: function () {
        this.lightbox();
    },
    lightbox: function () {
        jQuery('.waterfall-lightbox').find('a[href$=".png"], a[href$=".gif"], a[href$=".jpg"], a[href$=".svg"], a[href$=".webp"]').swipebox();
    }
};

jQuery(document).ready(
    Waterfall.init()
);