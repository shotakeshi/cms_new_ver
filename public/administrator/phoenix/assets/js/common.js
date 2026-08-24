(function ($) {
    'use strict';
    const elementOverlay = $('#ajax-overlay')
    $.ajaxSetup({
        beforeSend: function () {
            elementOverlay.fadeIn();
            elementOverlay.css('display', 'grid')
        },
        complete: function () {
            elementOverlay.fadeOut();
        },
        error: function (xhr, status, error) {
            elementOverlay.fadeOut();
        }
    });

})(jQuery)