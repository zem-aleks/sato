<div class="title"><?= $title; ?></div>
<table style="width:100%;">
    <tbody>
        <tr>
            <td>
                <span>Экспортировать таблицу пользователей:</span>
            </td>
            <td align="right">
                <a style="margin-right: 1em;" class="save" href="/dashboard/users/export">Экспорт</a>
            </td>
        </tr>
    </tbody>
    <div class="clear"></div>
</table><br/>

<!--
<table>
    <tr>
        <td>
            <div class="search">
                <form action="" method="POST">
                    <b>Введите фамилию или e-mail или номер телефона для поиска:</b> <br/>
                    <input type="text" name="str" placeholder="Поиск" value="<?=$str;?>" style="float:left; margin: 2px;"/>
                    <input type="submit" class="save" value="Найти" />
                </form>
            </div>
        </td> 
    </tr>
</table>
<div class="clear"></div>
<br/>


<? if($search):?>
<table  border="0" cellpadding="5" cellspacing="5" >
    <thead>
        <tr  style="font-weight:bold; border-bottom:1px solid gray;">
            <td  align="left" width="200">Фамилия Имя</td> 
            <td  align="left"width="180">Email</td>
            <td  align="left"width="140">Телефон</td>
            <td  align="left" width="*">Функции</td>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td  align="left" width="200"><?= $search['name'] ?></td>
                <td align="left" width="180"><?= $search['email'] ?></td>
                <td align="left" width="140"><?= $search['phone'] ?></td>
                <td align="left" width="*">
                    <a href="/dashboard/users/edit/<?= $search['ID']; ?>" class="edit">Редактировать</a>
                    <a href="javascript:void(0)" onclick="ConfirmDelete('/dashboard/users/del/<?= $search['ID']; ?>')" class="delete">Удалить</a><br/>
                    <a href="/dashboard/users/write/<?= $search['ID']; ?>" class="write">Написать</a>
                </td>
            </tr>
    </tbody>
</table>
<div class="clear"></div>
<br/>
<? endif;?>
-->

<center>
    <div class="pagination"><?= $paginator; ?></div>
</center>

<? if($member['role'] == 'superadmin'):?>

<table  border="0" cellpadding="5" cellspacing="5" >
    <thead>
        <tr class="gray" style="font-weight:bold; border-bottom:1px solid gray;">
            <td  align="left" width="10">ID</td>
            <td  align="left" width="100">Имя</td>
            <td  align="left"width="120">Email</td>
            <td  align="left"width="120">Тип услуги</td>
            <td  align="left"width="100">Бюджет</td>
            <td  align="left"width="100">Примечание</td>
            <td  align="left" width="*">Функции</td>
        </tr>
    </thead>
    <tbody>
        <? $i = 0; ?>
        <? foreach ($users as $user):++$i ?>
            <tr class="<? if($i%2 == 0):?>gray<?endif;?>">
                <td width="10"><?= $user['ID'] ?></td>
                <td  align="left" width="100"><?= $user['name'] ?></td>
                <td align="left" width="120"><?= $user['email'] ?></td>
                <td align="left" width="120"><?= $user['type'] ?></td>
                <td  align="left"width="100"><?= $user['price'] ?></td>
                <td  align="left"width="100"><?= $user['service'] ?></a></td>
                <td align="left" width="*">
                    <!--<a href="/dashboard/users/edit/<?= $user['ID']; ?>" class="edit">Редактировать</a>
                    <a href="javascript:void(0)" onclick="ConfirmDelete('/dashboard/users/del/<?= $user['ID']; ?>')" class="delete">Удалить</a><br/>
                    -->
                    <a href="/dashboard/users/write/<?= $user['ID']; ?>" class="write">Написать</a><br>
                    <a href="javascript:void(0)" onclick="ConfirmDelete('/dashboard/users/del/<?= $user['ID']; ?>')" class="delete">Удалить</a>
                </td>
            </tr>
        <? endforeach; ?>
        <? if ($i <= 0): ?>
            <tr>
                <td></td>
                <td colspan="4" align="center"><h3>Пользователей нет</h3></td>	
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

<? endif;?>