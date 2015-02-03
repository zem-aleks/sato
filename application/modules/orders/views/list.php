<div class="title"><?= $title; ?></div>

<center>
    <div class="pagination"><?= $paginator; ?></div>
</center>
<div align="center">Показывать заказы: 
    <a <? if ($filter == 'all'): ?>class="active"<? endif; ?> href="/dashboard/orders/">Все</a> 
    <a <? if ($filter == 'disable'): ?>class="active"<? endif; ?> href="/dashboard/orders/admin_index/disable">Не обработанные</a> 
    <a <? if ($filter == 'enable'): ?>class="active"<? endif; ?> href="/dashboard/orders/admin_index/enable">Обработанные</a>
</div>


<table  border="0" cellpadding="5" cellspacing="5" >
    <thead>
        <tr class="gray"  style="font-weight:bold; border-bottom:1px solid gray;">
            <td  align="center" width="25">№</td>
            <td  align="center" width="25">№ заказа</td>
            <td  align="center" width="130">Имя</td>
            <td  align="center" width="80">Email</td>
            <td  align="center" width="80">Телефон</td>
            <td  align="center" width="100">Дата и время</td>
            <td  align="center" width="50">Статус</td>
            <td  align="left" width="*">Функции</td>
        </tr>
    </thead>
    <tbody>
        <? $i = 0; ?>
        <? foreach ($orders as $value):++$i ?>
            <tr class="<? if($i%2 == 0):?>gray<?endif;?>">
                <td  align="center" width="25"><?=$i;?></td>
                <td  align="center" width="25"><?=$value['ID'];?></td>
                <td  align="center" width="130"><?=$value['name'];?></td>
                <td  align="center" width="80"><?=  strtolower($value['email']);?></td>
                <td  align="center" width="80"><?=$value['phone'];?></td>
                <td  align="center" width="100"><?=$value['date'];?></td>
                <td  align="center" width="50" class="status1">
                    <?=$status_list[$value['status']];?>
                </td>
                <td align="left">
                    <a href="/dashboard/orders/edit/<?= $value['ID']; ?>" class="edit">Редактировать</a>
                    <a href="javascript:void(0)" onclick="ConfirmDelete('/dashboard/orders/del/<?= $value['ID']; ?>')" class="delete">Удалить</a><br/>
                    <a href="javascript:void(0);" class="accept-order" data-id="<?= $value['ID']; ?>">Принять</a>
                </td>
            </tr>
        <? endforeach; ?>
        <? if ($i <= 0): ?>
            <tr>
                <td></td>
                <td colspan="4" align="center"><h3>Заказов нет</h3></td>	
                <td></td>
            </tr>
        <? endif; ?>

    </tbody>
</table>
<div class="clear"></div>
<br/>
<center>
    <div class="pagination"><?= $paginator; ?></div>
</center>

