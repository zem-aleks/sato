<div class="title"><?= $title; ?></div>

<div class="block by-interval">
    Введите интервал ID и нажмите кнопку "Выбрать" (максимальный интервал 20 товаров): 
    <input class="search-item from" type="text" placeholder="ID товара" required="required" maxlength="8">
    <input class="search-item to" type="text" placeholder="ID товара" required="required" maxlength="8">
    <div class=" select save">Выбрать</div>
    <div class="clear"></div>
    <table class="search-table"  width="100%" border="0" cellpadding="5" cellspacing="5">
        <tr height="45" class="search-result original gray">
            <td class="id" align="center"></td> 
            <td class="name" style="width:65%" align="left"></td>
            <td class="theadc" align="right" width="90">
                <a href="" class="edit" title="Редактировать">Edit</a>
                <a href="" class="status"  title="Вкл">Status</a>
                <a href="javascript:void(0)" onclick="" class="delete"  title="Удалить">Delete</a>
            </td>
        </tr>
        <tr>
            <td>
                <div class="preloader"></div>
            </td>
        </tr>
    </table>
</div>

<div class="block by-name">
    Введите название товара:<br/>
    <input class="search-item" type="text" placeholder="назвние товара" required="required"/>
    <span class="search-error"></span>
    <div class="clear"></div>
    <table class="search-table"  width="100%" border="0" cellpadding="5" cellspacing="5">
        <tr height="45" class="search-result original gray">
            <td class="id" align="center"></td>
            <td class="name" style="width:65%" align="left"></td>
            <td class="theadc" align="right" width="90">
                <a href="" class="edit" title="Редактировать">Edit</a>
                <a href="" class="status"  title="Вкл">Status</a>
                <a href="javascript:void(0)" onclick="" class="delete"  title="Удалить">Delete</a>
            </td>
        </tr>
        <tr>
            <td>
                <div class="preloader"></div>
            </td>
        </tr>
    </table>
</div>

<div align="center"><?= anchor('dashboard/item/addPage/', 'Добавить товар', array('class' => 'save')) ?></div>
<br/>
<div align="center">
    <form class="category-form" action="" method="POST">
        Показать категорию:
        <?= form_select('cat_filter', 'ID', 'cat_name', $categories, array($selected), $categories); ?>
        <br/>Сортировать по: 
        <?= form_dropdown('sort_items', $sort_list, $sort); ?>
    </form>
</div>
<div align="center">
    Показывать товары: 
    <a <? if ($filter == 'all'): ?>class="active"<? endif; ?> href="/dashboard/item/">Все</a> 
    <a <? if ($filter == 'disable'): ?>class="active"<? endif; ?> href="/dashboard/item/admin_index/disable">Выключенные</a> 
    <a <? if ($filter == 'enable'): ?>class="active"<? endif; ?> href="/dashboard/item/admin_index/enable">Включенные</a>
    <a <? if ($filter == 'in_process'): ?>class="active"<? endif; ?> href="/dashboard/item/admin_index/in_process">В процессе</a>

</div><br/>

<div align="center"><?= $paginator; ?></div><br/>

<? $category = false; ?>
<? $is_first_empty = true; ?>
<table width="100%" border="0" cellpadding="5" cellspacing="5" >
    <tr class="category">
        <td colspan="4" align="center"><?= $table_title; ?></td>
    </tr>
    <?php if ($pages): foreach ($pages as $page): $key++ ?>
            <tr <? if ($key % 2 == 0) echo "class='gray'"; ?> id="<?= $page['ID'] ?>" >
                <td style="width:10%;text-align: center;" align="left"><?= $page['ID'] ?></td>
                <td class="name" style="width:55%" align="left"><?= $page['name'] ?></td>
                <td class="name" style="width:20%;text-align: center;" align="left"><?= (int) $page['price'] ?> грн.</td>
                <td class="theadc" align="right" width="90">
                    <a href="<?= base_url() . 'dashboard/item/editPage/' . $page['ID'] ?>" class="edit" title="Редактировать">Edit</a>
                    <?
                    if ($page['status'] >= '1') {
                        ;
                        ?>
                        <a href="<?= base_url() . 'dashboard/item/status/' . $page['ID'] . "/0" ?>" class="status on" title="Выкл">Satatus</a>
                    <? } else { ?>
                        <a href="<?= base_url() . 'dashboard/item/status/' . $page['ID'] . "/1" ?>" class="status"  title="Вкл">Satatus</a>
        <? } ?>

                    <a href="javascript:void(0)" onclick="ConfirmDelete('<?= base_url() . 'dashboard/item/delPage/' . $page['ID'] ?>')" class="delete"  title="Удалить">Delete</a>
                </td>
            </tr>
        <?php
        endforeach;
    else:
        ?>
        <tr>
            <td></td>
            <td colspan="4" align="center"><h3>На данный момент товаров нет!</h3></td>	
            <td></td>
        </tr>
<?php endif; ?>
</tbody>
</table>
<br/>
<div align="center"><?= $paginator; ?></div>
<br/>
<div align="center"><?= anchor('dashboard/item/addPage/', 'Добавить товар', array('class' => 'save')) ?></div>
