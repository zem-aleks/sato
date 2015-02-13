<div class="profile_info shadow">
    <div class="title"><?= $title; ?></div>

    <div class="message-button">Показать исходное письмо заказа</div>
    <div class="clear"></div>
    <div class="order-message">
        <?=$order['detail']['detail'];?>
    </div>
    
    <div class="order-form">
        Имя получателя (ФИО):
        <input type="text" class="order-name" name="name" value="<?=$order['detail']['name']; ?>"/>
        Телефон:
        <input type="text" class="order-phone" name="phone" value="<?=$order['detail']['phone']; ?>"/>
        E-mail
        <input type="text" class="order-email" name="email" value="<?=$order['detail']['email']; ?>"/>
        Адрес:
        <textarea class="order-address" name="address"><?=$order['detail']['address']; ?></textarea>
        <br/><br/>
        <!--<i>Чтобы изменить\добавить товар, введите артикул и нажмите ENTER. Измениния вступят в силу при нажатии кнопки "применить"</i>
        <table class="items" border="0" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <td>Артикул</td>
                    <td style="text-align: left;">Название</td>
                    <td>Цена за ед.</td>
                    <td>Количество</td>
                    <td>Цена</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            <? foreach ($order['items'] as $item):?>
                <tr>
                    <td><input type="text" class="item-id" data-val="<?=$item['ID'];?>" value="<?=$item['ID'];?>"/></td>
                    <td style="text-align: left;" class="item-name">
                        <a href="/dashboard/item/editPage/<?=$item['ID'];?>"><?=$item['name'];?></a>
                    </td>
                    <td class="item-price"><?=(int)$item['price'];?></td>
                    <td><input type="text" class="item-count" value="<?=(int)$item['count'];?>"></td>
                    <td class="item-sum"><?=(int)$item['price'] * (int)$item['count'];?></td>
                    <td class="del-row"><img src="/images/front/del.png" alt="" title=""/></td>
                </tr>
            <? endforeach; ?>
                <tr class="error">
                    <td class="add-row" colspan="6">Добавить</td>
                </tr>
            </tbody>
        </table>-->
        <div class="clear"></div>
    </div>

    Установить статус: 
    <?=form_dropdown('select_status', $status_list, (int) $order['detail']['status']);?>
    <div class="cancel-comment">
        Комментарий администратора к заказу:
        <textarea><?= $order['detail']['admin_comment'];?></textarea>
    </div>
    <center><a class="apply-status" data-id="<?=$order['detail']['ID'];?>" href="javascript: void(0);">Применить</a></center><br/><br/>
    <a class="save del" href="/dashboard/orders/del/<?= $order['detail']['ID']; ?>">Удалить заказ</a>
</div>