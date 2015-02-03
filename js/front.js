$(document).ready(function() {
    $('a[href*=#]').bind("click", function (e) {
        var anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top
        }, 1000);
        e.preventDefault();
    });
    
    $('.flexslider').flexslider({
        slideshow : false,
        animation : 'slide'
    });
    
    $('input[name="phone"]').mask("(999) 999-99-99");
});
    