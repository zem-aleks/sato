function isEmpty(str) {
    if (str == null)
        return true;
    for (var i = 0; i < str.toString().length; i++)
        if (" " != str.charAt(i))
            return false;
    return true;
}

function isLink(str)
{
    return /((http|https):\/\/(\w+:{0,1}\w*@)?(\S+)|)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(str);
}
function isNumbers(str)
{
    return /^\d+$/.test(str);
}
function isHash(hash)
{
    var re = /^[a-zA-Z0-9]+$/;
    return re.test(hash);
}
function isEmail(email)
{
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function isPhone(str)
{
    return /^((8|\+7|\+3)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/.test(str);
}

$(document).ready(function() {
    // полезные функции для всех страниц
    $('input[placeholder],textarea[placeholder]').placeholder();
    /*$(window).scroll(function(e) {
        if ($('#header').offset().top + $('#header').height() - $(window).scrollTop() < 0)
            $('#scroll-top').fadeIn(400);
        else
            $('#scroll-top').fadeOut(400);
    });

    $('#scroll-top').click(function() {
        $('body,html').animate({
            scrollTop: 0
        }, 600);
    });*/


    //---------my-select---------------------//
/*
    $('.items').on('click', '.my-select', function(e) {
        var is_open = $(this).hasClass('open');
        var $list = $(this).find('.options');
        var pageHeight = $('#wrapper').height();


        $('.my-select').removeClass('open');
        if (!is_open) {
            $(this).addClass('open');
            if (pageHeight - ($list.offset().top + $list.height()) < 0)
            {
                $list.css('bottom', '0px');
            }
            var scroll = $list.offset().top;
            if ($(window).height() - $list.height() > 0)
                scroll = $list.offset().top - ($(window).height() - $list.height()) + 5;
            $('body,html').animate({
                scrollTop: scroll
            }, 600);
        }



    });

    $('.items').on('click', '.option', function() {
        $(this).closest('.my-select').find('.value').text($(this).text());
    });

    $('html').bind('click.my_select', function(event) {
        if ($(event.target).closest('.my-select').length == 0)
            $('.my-select').removeClass('open');
    });
*/
    //-----------end my-select--------------//


});