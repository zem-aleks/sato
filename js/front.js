$(document).ready(function() {
    $('a[href*=#]').bind("click", function (e) {
        $('html, body').stop().animate({
            scrollTop: 0
        }, 1000);
        e.preventDefault();
    });
    
    $('.flexslider').flexslider({
        slideshow : false,
        animation : 'slide'
    });
    
    $('input[name="phone"]').mask("(999) 999-99-99");
});
    