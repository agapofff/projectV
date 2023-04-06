var isTouchCapable = 'ontouchstart' in window ||
    window.DocumentTouch && document instanceof window.DocumentTouch ||
    navigator.maxTouchPoints > 0 ||
    window.navigator.msMaxTouchPoints > 0;

$(document).on('click', '.video__muted', function() {
    $(this).addClass('active');
    $(this).parents('.video').find('video').get(0).muted = false;
});

$(document).on('click', '.video__muted.active', function() {
    $(this).removeClass('active');
    $(this).parents('.video').find('video').get(0).muted = true;
});
