$(document).ready(function () {
    $('a[href*=#]').bind("click", function (e) {
        $('html, body').stop().animate({
            scrollTop: 0
        }, 1000);
        e.preventDefault();
    });

    $('.flexslider').flexslider({
        slideshow: true,
        animation: 'slide',
        prevText: "",
        nextText: "",
    });

    $('.gallery-slider').each(function () {
        var $this = $(this);
        var isDirectionNav = $this.closest('.product-view').length <= 0;
        $this.flexslider({
            slideshow: false,
            animation: 'slide',
            prevText: "",
            nextText: "",
            manualControls: $this.find('.flex-control-nav li'),
            directionNav: isDirectionNav,
        });
    });

    var mainSlider = $('.main-slider').flexslider({
        slideshow: false,
        animation: 'slide',
        prevText: "",
        nextText: "",
        manualControls: '.main-control-nav li',
        selector: '.main-slides > li',
        directionNav: false,
    }).data('flexslider');

    function nextSlide()
    {
        var total = $('.main-slider .main-control-nav li').length;
        var index = $('.main-slider .main-control-nav .flex-active').index();
        mainSlider.flexAnimate((index + 1) % total);
    }

    function prevSlide()
    {
        var total = $('.main-slider .main-control-nav li').length;
        var index = $('.main-slider .main-control-nav .flex-active').index();
        mainSlider.flexAnimate((index - 1) % total);
    }

    $('.view-more').click(function () {
        var $this = $(this);
        if ($this.hasClass('processing'))
            return false;
        $this.addClass('processing');
        var start = $('.item').length;
        var limit = 6;
        var category = $('.catalog').data('id');
        var order = $('.catalog[data-sort]').data('sort');
        $.ajax({
            url: '/catalog/products/' + start + '/' + limit + '/'
                    + category + '/' + order,
            type: 'POST',
            dataType: 'JSON',
            success: function (res) {
                if (res.status == 1 && !isEmpty(res.html)) {
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

    $('.product-buy').click(function () {
        var id = $(this).data('id');
        var count = 1;
        addProduct(id, count, null);
    });

    $('.product-remove').click(function () {
        var $row = $(this).closest('.product');
        var id = $row.data('id');
        deleteFromCart(id, $row);
    });


    $('.cart .number').change(function () {
        if (isNaN($(this).val()) || $(this).val() <= 0)
            $(this).val(1);
        var sum = 0.;
        $('.cart .product').each(function () {
            sum += parseInt($(this).data('price') * $(this).find('.number').
                    val());
        });
        updateCart();
        $('.cart-sum').text(sum);
    });


    $('.form-order form').submit(function (e) {
        var data = {};
        data.name = $('.form-order [name="name"]').val();
        data.phone = $('.form-order [name="phone"]').val();
        data.address = $('.form-order [name="address"]').val();
        data.delivery = $('.form-order [name="delivery"]').val();
        data.payment = $('.form-order [name="payment"]').val();
        data.email = $('.form-order [name="email"]').val();
        data.comment = $('.form-order [name="comment"]').val();

        $.ajax({
            url: '/ajax/purchase',
            type: 'POST',
            dataType: 'JSON',
            data: data,
            success: function (obj) {
                if (obj.status <= 0) {
                    $('.alert').html(obj.error).show('500');
                    alert('Ошибка ввода данных');
                } else {
                     $('.alert').html(
                             'Ваш заказ успешно отправил и будет обработан в ближайшее время. Вам на почту будет выслано уведомление.')
                             .show(500).addClass('alert-success').removeClass('alert-danger');
                     setTimeout(function(){
                         window.location = '/';
                     }, 5000);
                }
            },
            error: function (e) {
                alert(
                        'Ошибка сервера. Попробуйте обновить страницу или повторить оперцаию позже.')
            }
        });
        return false;
    });
});

// ---- functions to work with cart ----//

function updateCart()
{
    var items = [];
    $('.cart .product').each(function () {
        items.push({
            id: $(this).data('id'),
            count: $(this).find('.number').val()
        });
    });
    console.log(items);
    $.post('/ajax/updateCart', {items: items}, function () {
    });
}

function deleteAllCart()
{
    $.ajax({
        url: '/ajax/deleteAllCart',
        type: 'POST',
        dataType: 'json',
        success: function (obj) {
            if (obj.error == 0 && obj.status == 1)
            {
                $('.cart-table tbody tr').fadeOut(400, function () {
                    $(this).remove();
                });
                $('.cart-last-empty').removeClass('hidden');
                $('.cart-last-block').addClass('hidden');
                $('.cart-all').text(0);
                $('.cart-count').text(0);
                $('.but').hide();
            }
            else if (obj.error == 1)
                alert('Не корректный запрос');
            else
                alert('Не правильный ID');
        },
        error: function () {
            alert('Server error');
        }
    });
}

// $row - row of element (if need delete element form DOM)
function deleteFromCart(id, $row)
{
    $.ajax({
        url: '/ajax/deleteFromCart',
        type: 'POST',
        dataType: 'json',
        data: {
            id: id
        },
        success: function (obj) {

            if (obj.error == 0 && obj.status == 1)
            {
                if (typeof $row != 'undefined')
                {
                    $row.fadeOut(500, function () {
                        $row.remove();
                    });

                    var sum = 0.;
                    for (var k = 0; k < obj.cart.length; ++k)
                        sum += parseInt(obj.cart[k].original_price
                                * obj.cart[k].count);
                    $('.cart-count').text(obj.cart.length + ' шт.');
                    $('.cart-sum').text(sum);
                }

                if (obj.cart.length == 0) {
                    $('.cart-count').text('пусто');
                }

            }
            else if (obj.error == 1)
                alert('Не корректный запрос');
            else
                alert('Не правильный ID');
        },
        error: function () {
            alert('Server error');
        }
    });
}


// add product to cart
function addProduct(id, count, detail)
{
    if (id > 0 && count > 0) {
        $.ajax({
            url: '/ajax/addToCart',
            type: 'POST',
            data: {
                id: id,
                count: count,
                detail: detail
            },
            dataType: 'json',
            success: function (obj) {
                if (obj.error == 0)
                {
                    var sum = 0;
                    for (var k = 0; k < obj.cart.length; ++k)
                    {
                        sum += parseFloat(obj.cart[k].price) * parseInt(
                                obj.cart[k].count);
                    }
                    $('.cart-count').text(obj.cart.length + ' шт.');
                    //$('.cart-block .cart-sum').text(sum);

                    alert('Товар добавлен в корзину');

                } else if (obj.error == 2) {
                    if (obj.status == 0)
                        showAlert('Ошибка',
                                'Извините, в данный момент товара нет на складе.');
                    else
                        showAlert('Ошибка',
                                'Извините, в данный момент товара нет на складе. Ожидается поставка в ближайшее время.');
                } else {
                    showAlert('Ошибка запроса',
                            'Попробуйте обновить страницу и повторить операцию.');
                }



            },
            error: function (e, code) {
                alert('Server error');
            }
        });
    }
}

function showAlert(title, message)
{
    alert(title + '! ' + message);/*
    if ($alertDialog && $alertDialog.length > 0) {
        $alertDialog.find('.dialog-title').html(title);
        $alertDialog.find('.dialog-content').html(message);
        $alertDialog.dialog('open');
    } else {
        
    }*/
}
 