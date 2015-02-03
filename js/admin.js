$(document).ready(function() {
    
    $('.save-cats').click(function(){
        var data = $('#serv-cat-form').serialize();
        $.post('/ajax/saveCats', data, function(res){
            if(parseInt(res) == 1) {
                alert('Категории успешно сохранены!');
            } else {
                alert('Ошибка запроса. Попробуйте обновить страницу');
            }
        });
    });


    $('.items').on('click', '.del-row', function() {
        $(this).closest('tr').hide(300, function() {
            $(this).remove();
        });
    });

    $('.items').on('change keyup', '.item-count', function() {
        var val = parseInt($(this).val());
        if (isNaN(val))
            val = 0;
        var $row = $(this).closest('tr');
        var price = parseInt($row.find('.item-price').text());
        $row.find('.item-sum').text(price * val);
    });

    $('.items').on('change', '.item-id', function() {
        var id = parseInt($(this).val());
        initRow(id, $(this));
    });

    $('.items').on('keypress', '.item-id', function(e) {
        if (e.which == 13) {
            var id = parseInt($(this).val());
            initRow(id, $(this));
        }
    });

    function initRow(id, $input)
    {
        if (isNaN(id))
            id = 0;
        $input.val(id);
        if (parseInt($input.data('val')) != id) {
            $input.data('val', id);
            var $row = $input.closest('tr');
            $row.find('.item-name').html($('<div>').addClass('preloader').show());
            $row.find('.item-price').text('');
            $row.find('.item-sum').text('');
            $.ajax({
                url: '/ajax/getProduct',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    id: id
                },
                success: function(obj) {
                    if (obj.error == 0) {
                        $row.find('.item-name').html(
                                '<a href="/dashboard/item/editPage/' + obj.item.ID + '">' + obj.item.name + '</a>'
                                );
                        $row.find('.item-price').text(parseInt(obj.item.price));
                        $row.find('.item-count').trigger('change');
                        $row.removeClass('error');
                    } else {
                        $row.find('.item-name').text('Товар не найден');
                        $row.addClass('error');
                    }
                },
                error: function() {
                    $row.find('.item-name').text('Ошибка поиска. Обновите страницу');
                    $row.addClass('error');
                }
            });
        }
    }


    $('.items .add-row').click(function() {
        $(this).closest('tr').before(
                $('<tr>').html(
                '<td><input class="item-id" type="text"/></td>'
                + '<td class="item-name" style="text-align: left;"></td>'
                + '<td class="item-price"></td>'
                + '<td><input class="item-count" type="text" value="1"></td>'
                + '<td class="item-sum"></td>'
                + '<td class="del-row"><img src="/images/front/del.png" alt="" title=""/></td>')
                );
    });

    $('.message-button').click(function() {
        if ($('.order-message').is(':visible')) {
            $(this).text('Показать исходное письмо заказа');
        } else {
            $(this).text('Спрятать исходное письмо заказа');
        }
        $('.order-message').slideToggle(300);
    });

    $('.js-form').submit(function() {
        var values = [];
        $('.related-items .r-item').each(function() {
            values.push($(this).data('id'));
        });
        $('input[name="related_value"]').val(JSON.stringify(values));
    });

    $('.related-items').on('click', '.r-item .remove', function() {
        var $item = $(this).closest('.r-item');
        jConfirm('Удалить?', 'Подтверждение', function(is_yes) {
            if (is_yes)
                $item.remove();
        });
    });

    $('.related-items .remove-all').click(function() {
        var $items = $(this).closest('.related-items').find('.r-item');
        if ($items.length > 0)
            jConfirm('Удалить все элементы?', 'Подтверждение', function(is_yes) {
                if (is_yes)
                    $items.remove();
            });
    });

    $("#related-input").autocomplete({
        delay: 0,
        minLength: 2,
        source: function(request, response) {
            $.ajax({
                url: "/ajax/searchItems",
                dataType: "json",
                type: "POST",
                data: {
                    id_from: request.term,
                    id_to: -1
                },
                success: function(data) {
                    response($.map(data.items, function(item) {
                        return {
                            label: item.name,
                            value: item.ID
                        }
                    }));
                }
            });
        },
        select: function(event, ui) {
            $("#related-input").val('');
            var $item = $('<div>').addClass('r-item').data('id', ui.item.value).append(
                    $('<a href="/dashboard/item/editPage/' + ui.item.value + '">').addClass('label').text(ui.item.label),
                    $('<div>').addClass('remove')
                    );
            $('.related-items').append($item);
            return false;
        }
    });

    $('.apply-status').click(function() {
        var status = $('select[name="select_status"]').val();
        var comment = $('.cancel-comment textarea').val();
        var id = $(this).data('id');
        var data = {};
        data.order = {};
        data.order.admin_comment = comment;
        data.order.name = $('.order-name').val();
        data.order.email = $('.order-email').val();
        data.order.phone = $('.order-phone').val();
        data.order.address = $('.order-address').val();
        data.order.status = status;
        data.items = [];

        $('.items tbody tr').not('.error').each(function() {
            var item_id = parseInt($(this).find('.item-id').val());
            if (item_id > 0) {
                var item = {};
                item.id = item_id;
                item.count = parseInt($(this).find('.item-count').val());
                data.items.push(item);
            }
        });

        $.ajax({
            url: '/dashboard/orders/updateOrder/' + id,
            type: 'POST',
            data: data,
            success: function(obj) {
                if (obj == '1')
                    alert('Сохранено')
            },
            error: function() {
                alert('Server error')
            }
        });
    });

    $('.category-form select').change(function() {
        $(this).closest('.category-form').submit();
    });

    $('.by-name .search-item').bind('keyup', function() {
        var id = $(this).val();
        var $block = $(this).closest('.block');
        var val = $(this).val();
        var oldVal = $(this).data('val');
        if (!isEmpty(val) && val != oldVal) {
            $(this).data('val', val);
            searchItems(id, -1, $block);
        }

    });

    $('input[placeholder],textarea[placeholder]').placeholder();

    $('.select').click(function() {
        var id_from = $('.search-item.from').val();
        var id_to = $('.search-item.to').val();
        var $block = $(this).closest('.block');
        searchItems(id_from, id_to, $block);
    });

    function searchItems(id_from, id_to, $block)
    {
        var $dom = $block.find('.search-result.original');
        $block.find('.preloader').show();
        $block.find('.search-result.copy').remove();

        $block.find('.search-error').text('');
        $dom.hide();

        $.ajax({
            url: '/ajax/searchItems/',
            async: false,
            data: {
                id_from: id_from,
                id_to: id_to
            },
            type: 'POST',
            dataType: 'json',
            success: function(obj) {
                if (obj.error == 1)
                {
                    $block.find('.search-error').text('Не верно указан интервал').show();
                    $dom.hide();
                }
                else
                {
                    var item = null;
                    for (var k = 0; k < obj.items.length; ++k)
                    {
                        item = obj.items[k];
                        var $row = $dom.clone().removeClass('original').addClass('copy');
                        $dom.before($row);
                        initSearchItem(item, $row);
                    }
                }
                $block.find('.preloader').slideUp();
            },
            error: function() {
                alert('Ошибка сервера');
                $dom.hide();
                $block.find('.preloader').hide();
            }
        });
    }


    function initSearchItem(item, $dom)
    {
        $dom.find('.id').text(item.ID);
        $dom.find('.image').html('<img width="80" onerror = "this.style.display = \'none\'" alt="' + item.ID + '" title="' + item.ID + '" src="/uploads/items/' + item.ID + '.jpg" />');
        $dom.find('.name').text(item.name);
        $dom.find('.edit').attr('href', '/dashboard/item/editPage/' + item.ID);
        $dom.find('.status').attr('href', '/dashboard/item/status/' + item.ID + '/' + (item.status == 1 ? 0 : 1));
        if (item.status == 1)
            $dom.find('.status').addClass('on').attr('title', 'Выкл');
        else
            $dom.find('.status').removeClass('on').attr('title', 'Вкл');

        $dom.find('.delete').attr('onclick', 'ConfirmDelete("/dashboard/item/delPage/' + item.ID + '")');
        $dom.slideDown(500);
    }

    function searchItem(id, $dom)
    {
        $('.by-name .search-error').text('');
        $dom.hide();
        $.ajax({
            url: '/ajax/searchItem/',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(obj) {
                if (obj.error == 1)
                {
                    $('.by-name .search-error').text('Товар не найден').show();
                    $dom.hide();
                }
                else
                {
                    $dom.find('.id').text(obj.item.ID);
                    $dom.find('.image').html('<img width="80" onerror = "this.style.display = \'none\'" alt="' + obj.item.ID + '" title="' + obj.item.ID + '" src="/uploads/items/' + obj.item.ID + '.jpg" />');
                    $dom.find('.name').text(obj.item.name);
                    $dom.find('.edit').attr('href', '/dashboard/item/editPage/' + obj.item.ID);
                    $dom.find('.status').attr('href', '/dashboard/item/status/' + obj.item.ID + '/' + (obj.item.status == 1 ? 0 : 1));
                    if (obj.item.status == 1)
                        $dom.find('.status').addClass('on').attr('title', 'Выкл');
                    else
                        $dom.find('.status').removeClass('on').attr('title', 'Вкл');

                    $dom.find('.delete').attr('onclick', 'ConfirmDelete("/dashboard/item/delPage/' + obj.item.ID + '")');
                    $dom.slideDown(500);
                }
            },
            error: function() {
                alert('Ошибка сервера');
                $dom.hide();
            }
        });

    }

    function findCatalog(id_parent, $span) {
        if (id_parent != 0)
            $.ajax({
                url: '/ajax/findCatalog/' + id_parent,
                success: function(res) {
                    if (res === 0)
                    {
                        $span.text('Каталог не найден');
                    }
                    else
                        $span.text(res);
                },
                error: function() {
                    alert('Ошибка сервера');
                }
            });
        else
            $span.text('Корень каталога');
    }


    $("#drag").tableDnD({
        onDrop: function(table, row) {
            var rows = table.tBodies[0].rows;
            var $arr = "";

            for (var i = 0; i < rows.length; i++) {
                $arr += i + "_" + rows[i].id + ";";
            }

            var html = $.ajax({
                type: "POST",
                url: window.location.href + "/sort",
                data: "st=" + $arr,
                dataType: "html",
                async: false,
                success: function(data) {
                    /*alert(data);*/
                }
            }).responseText;

        }
    });
    $('html').on('click', '.status', function() {
        var link = $(this).attr('href');
        var cl = "";
        var elem = $(this);
        if ($(this).hasClass('on'))
            cl = 'off';
        else
            cl = 'on';
        var html = $.ajax({
            type: "POST",
            url: link,
            dataType: "html",
            async: false,
            success: function(data) {
                //$(document).replaceAll(data);alert(link);
                link2 = link.substring(0, link.length - 1)
                if (cl == 'off') {
                    elem.removeClass('on');
                    link2 += '1';
                }
                if (cl == 'on') {
                    elem.addClass('on');
                    link2 += '0';
                }
                elem.attr("href", link2);
            }
        }).responseText;
        return false;
    });
    $('#categ li').prepend('<div class="dropzone"></div>');
    $('#categ li').draggable({
        handle: ' > dl',
        opacity: .8,
        addClasses: false,
        helper: 'clone',
        zIndex: 100
    });
    $('#categ dl, #categ .dropzone').droppable({
        accept: '#categ li',
        tolerance: 'pointer',
        drop: function(e, ui) {
            var li = $(this).parent();
            var child = !$(this).hasClass('dropzone');
            //If this is our first child, we'll need a ul to drop into.
            if (child && li.children('ul').length == 0) {
                li.append('<ul/>');
            }
            //ui.draggable is our reference to the item that's been dragged.
            if (child) {
                li.children('ul').append(ui.draggable);
            }
            else {
                li.before(ui.draggable);
            }
            var $id = ui.draggable.attr('id');
            var $parent = $('#' + $id).parent('ul').parent('li').attr('id');
            if (!$parent)
                $parent = 0;
            var html = $.ajax({
                type: "POST",
                url: window.location.href + "/drag",
                data: "item=" + $id + "&parent=" + $parent,
                dataType: "html",
                async: false,
                success: function(data) {
                    /*alert(data);*/
                }
            }).responseText;
            //reset our background colours.
            li.find('dl,.dropzone').css({backgroundColor: '', borderColor: ''});
        },
        over: function() {
            $(this).filter('dl').css({backgroundColor: '#ccc'});
            $(this).filter('.dropzone').css({borderColor: '#aaa'});
        },
        out: function() {
            $(this).filter('dl').css({backgroundColor: ''});
            $(this).filter('.dropzone').css({borderColor: ''});
        }
    });
    $("#categ li").has('li').toggleClass('plus');
    $("#categ li").children('ul').css({'display': 'none'});

    $(".collapse").click(function() {

        if ($(this).closest('li').attr('class') == "plus") {

            $(this).closest('li.plus').removeClass('plus').addClass('minus');
            $(this).closest('li.minus').children('ul').css({'display': 'block'});
        }
        else {
            if ($(this).closest('li').attr('class') == "minus") {
                $(this).closest('li.minus').removeClass('minus').addClass('plus');
                $(this).closest('li.plus').children('ul').css({'display': 'none'});
            }
        }
        return false;
    });
    $(".name").click(function() {
        return false;
    });

    $('.accept-order').click(function() {
        var id = $(this).data('id');
        var $status = $(this).closest('tr').find('.status1');
        $.ajax({
            url: 'dashboard/orders/status/' + id + '/1/0',
            success: function() {
                $status.text('Принят');
            },
            error: function() {
                alert('Ошибка сервера');
            }
        });
    });

    $('.save.cancel').click(function() {
        if (confirm('Вы действительно хотите удалить этот заказ и вернуть товары на склад?'))
            return true;
        else
            return false;
    });

    $('.save.del').click(function() {
        if (confirm('Удалить заказ?'))
            return true;
        else
            return false;
    });


    $('body').on('click', 'a.sort', function() {
        var $first = $(this).closest('li');
        var $second = null;
        var is_up = false;
        if ($(this).hasClass('up')) {
            $second = $first.prev('li');
            is_up = true;
        }
        else
            $second = $first.next('li');

        if ($second && $second.length > 0) {
            var id1 = parseInt($first.attr('id'));
            var id2 = parseInt($second.attr('id'));
            $.ajax({
                type: "POST",
                url: window.location.href + "/sort",
                data: {
                    id1: id1,
                    id2: id2
                },
                dataType: "html",
                success: function(data) {
                    if (data == '1') {
                        if (is_up) {
                            $second.before($first);
                        } else {
                            $first.before($second);
                        }
                    } else {
                        alert('Server error. Refresh page.');
                    }
                }
            })
        }
    });

    $('.add-dict-item').click(function() {
        var $form = $(this).closest('.form-add');
        var name = $form.find('input[name="name"]').val();
        var content = $form.find('textarea[name="content"]').val();
        var type = $(this).closest('.container').data('type');
        if (!isEmpty(name)) {
            $.ajax({
                url: '/dashboard/dictionary/add',
                type: 'POST',
                data: {
                    name: name,
                    content: content,
                    type: type
                },
                success: function(id) {
                    if (id) {
                        var text = '<span class="dname">' + name + '</span>';
                        if (content && content.length > 0)
                            text += ' - <span class="description">' + content + '</span>';
                        var $item = $('<div>').attr('data-id', id).addClass('dict-item').html(text);
                        if (type == 'color')
                            $item.css('background-color', content);
                        $form.closest('.container').find('.complete .clear').before($item);
                        $form.find('input[name="name"]').val('');
                        $form.find('textarea[name="content"]').val('');
                    }
                },
                error: function(data) {
                    alert('Server error. Refresh page.')
                }
            });
        } else {
            alert('Заполните поля!');
        }
    });

    $('html').on('click', '.delete-dict', function() {
        if (confirm('Удалить?'))
            var id = $(this).data('id');
        $.ajax({
            url: '/dashboard/dictionary/del/' + id,
            success: function(obj) {
                if (obj) {
                    $('.initiator').dialog("close");
                    $('.complete .dict-item[data-id="' + id + '"]').remove();
                }
            },
            error: function(data) {
                alert('Server error. Refresh page.')
            }
        });
    });

    $('html').on('click', '.apply-dict', function() {
        var name = $(this).closest('div').find('.dname').val();
        var desc = $(this).closest('div').find('.description').val();
        var id = $(this).closest('div').find('.delete-dict').data('id');
        $.ajax({
            url: '/dashboard/dictionary/edit/' + id,
            type: 'POST',
            data: {
                name: name,
                desc: desc
            },
            success: function(obj) {
                $('.complete .dict-item[data-id="' + id + '"] .dname').text(name);
                $('.complete .dict-item[data-id="' + id + '"] .description').text(desc);
                $('.initiator').dialog("close");
            },
            error: function() {
                alert('Server error');
            }
        });
    });

    $('.complete').on('click', '.dict-item', function() {
        var $item = $(this);
        var name = $item.find('.dname').text();
        var desc = $item.find('.description').text();
        var id = $item.data('id');
        var html = '<input type="text" placeholder="Название" class="dname" value="' + name + '"/>' +
                '<textarea style="width : 100%" placeholder="Описание" class="description">' + desc + '</textarea>' +
                '<center><a href="javascript: void(0);" class="apply-dict">Применить</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' +
                '<a data-id="' + id + '" href="javascript: void(0);" class="delete-dict">Удалить термин</a></center>';
        $('<div>').addClass('initiator').html(html).appendTo('body').dialog({
            dialogClass: "dictionary-form",
            title: "Редактировать словарь",
            modal: true,
            closeOnEscape: true
        });
        /*if(confirm('Удалить?'))
         $.ajax({
         url: '/dashboard/dictionary/del/' + $item.data('id'),
         success: function(id) {
         if (id) {
         $item.remove();
         }
         },
         error: function(data) {
         alert('Server error. Refresh page.')
         }
         });*/
    });

    $('.add-photo').click(function() {
        var $input = $('.item-photo').find('.for-copy');
        var $newInput = $input.clone().removeClass('for-copy').val('')
                .attr('name', $input.attr('name') + '_' + $('.item-photo input').length);
        $input.after($newInput);
    });

});
function ConfirmDelete(url) {
    jConfirm("Удалить?", 'Подтверждение',
            function(r) {
                if (r)
                    document.location.href = url;
            });
}