$.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};

$(window).on('load resize scroll', function() {
    const classLists = ["news-item", "gb-callout", "item-archive", "featured-item"];
    classLists.forEach(function(classList) {
        $('.' + classList).each(function() {
            if ($(this).isInViewport()) {
                $(this).addClass('appear');
            }
        });
    });
});