$(document).ready(function() {
    $('a[href*=#]').bind("click", function (e) {
        $('html, body').stop().animate({
            scrollTop: 0
        }, 1000);
        e.preventDefault();
    });
    
    $('.flexslider').flexslider({
        slideshow : true,
        animation : 'slide',
        prevText: "",
        nextText: "",
    });
    
    $('.gallery-slider').each(function(){
        var $this = $(this);
        var isDirectionNav = $this.closest('.product-view').length <= 0;
        $this.flexslider({
            slideshow : false,
            animation : 'slide',
            prevText: "",
            nextText: "",
            manualControls : $this.find('.flex-control-nav li'),
            directionNav: isDirectionNav,  
        });
    });
    
    var mainSlider = $('.main-slider').flexslider({
        slideshow : false,
        animation : 'slide',
        prevText: "",
        nextText: "",
        manualControls : '.main-control-nav li',
        selector : '.main-slides > li',
        directionNav: false,  
    }).data('flexslider');
    
    function nextSlide()
    {
        var total = $('.main-slider .main-control-nav li').length;
        var index = $('.main-slider .main-control-nav .flex-active').index();
        mainSlider.flexAnimate((index+1) % total);
    }
    
    function prevSlide()
    {
        var total = $('.main-slider .main-control-nav li').length;
        var index = $('.main-slider .main-control-nav .flex-active').index();
        mainSlider.flexAnimate((index-1) % total);
    }
    
    $('.view-more').click(function(){
        var $this = $(this);
        if($this.hasClass('processing'))
            return false;
        $this.addClass('processing');
        var start = $('.item').length;
        var limit = 6;
        var category = $('.catalog').data('id');
        var order = $('.catalog').data('sort');
        $.ajax({
            url: '/catalog/products/' + start + '/' + limit + '/'
                    + category + '/' + order,
            type: 'POST',
            dataType: 'JSON',
            success: function (res) {
                if (res.status == 1 && !isEmpty(res.html) ) {
                    $('.products').append(res.html);
                } else {
                    $this.remove();
                }
                $this.removeClass('processing');
            },
            error: function () {
                alert('Server error');
                $this.removeClass('processing');
            }
        });
        return false;
    });
    
    $('input[name="phone"]').mask("(999) 999-99-99");
});
    