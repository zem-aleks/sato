<div class="title"><?= $title; ?></div>
<?= form_open_multipart('dashboard/category/editCategory/' . $category['ID'], array('name' => 'editform')); ?> 
<table border="0" cellpadding="5" cellspacing="5" >
    <tbody>
        <tr height="45">
            <td>Название:<br/>
                <input id="name" name="name" size="80" value="<?= set_value('name', $category['cat_name']) ?>" maxlength="255" type="text">
            <td>
        </tr>
        <tr>
            <td>URL (ссылка на страницу):<br/>
                <input id="url" name="url" size="80" value="<?= set_value('url', $category['url']) ?>" maxlength="255" type="text" />
            </td>
        </tr>
        <!--<tr>
            <td>Краткое описание (используется в навигационном меню):<br/>
                <input id="content" name="content" size="80" value="<?= set_value('content', $category['content']) ?>" maxlength="255" type="text" />
            </td>
        </tr>
        <tr height="45">
            <td >Является Подкатегорией:<br/>
                <?= form_select('id_parent', 'ID', 'cat_name', $categories, $category['id_parent']) ?>
            </td>
        </tr>
        <tr>
            <td>ЧПУ:</br>
                (Если оставить пустым,то по названию построится автоматически.)</br></br>
                <input type="text"	size="80" name="chpu"	value="<?= set_value('chpu', $category['chpu']) ?>" />
            </td>
        </tr>
        <tr>
            <td>Title:</br>
                <input type="text"	size="80" name="title" value="<?= set_value('title', $category['title']) ?>" />
            </td>
        </tr>
        <tr>
            <td >Description:</br>
                <textarea name="mdesc" rows="4" cols="80"><?= set_value('mdesc', $category['mdesc']) ?></textarea>
            </td>
        </tr>
        <tr>
            <td>Key-words:</br>
                <textarea name="mkeys" rows="4" cols="80"><?= set_value('mkeys', $category['mkeys']) ?></textarea>
            </td>
        </tr>
        <tr height="45">
            <td>ID товара новинки категории (отображаеться в каталоге категории):<br/>
                <input type="text" size="80" name="new_item_id" value="<?=$category['new_item_id'];?>" />
            </td>
        </tr>
        <tr height="45">
            <td>ID топового товара категории (отображаеться в меню навигации):<br/>
                <input type="text" size="80" name="top_item_id" value="<?=$category['top_item_id'];?>" />
            </td>
        </tr>
        <tr height="45">
            <td>Название топового товара (если оставить пустым, берется название товара):<br/>
                <input type="text" name="top_item_name" maxlength="255" value="<?= set_value('top_item_name', $category['top_item_name']) ?>"/>
            </td>
        </tr>
        <tr height="45">
            <td>Короткое описание топового товара:<br/>
                <textarea name="top_item_desc" maxlength="255"><?= set_value('top_item_desc', $category['top_item_desc']) ?></textarea>
            </td>
        </tr>
        <tr height="45">
            <td>Контент страницы:<br/>
                <?=show_editor('#page-text')?>
                <textarea id="page-text" name="page_text"><?= set_value('top_item_desc', $category['page_text']) ?></textarea>
            </td>
        </tr>-->
    </tbody></table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= anchor('dashboard/category', 'Отменить', array('class' => "save")) ?>
