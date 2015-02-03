<?= show_editor('#content') ?>
<div class="title">Редактирование <?= $title; ?></div>
<?= form_open_multipart('dashboard/' . $uri . '/edit/' . $page['ID'], array('name' => 'editform')); ?> 

<table border="0" cellpadding="5" cellspacing="5">
    <tbody>
        <tr>
            <td>Фото:<br/>
                <? if (!empty($page['image']) && $page['image'] != 'no_image.jpg'): ?>
                    <img src="/uploads/<?=$upload_folder;?>/<?=$page['image'];?>" style='max-height:150px;'/><br/>
                    <input type="checkbox" name="del" />Удалить
                    <input type="hidden" name="image" value="<?=$page['image'];?>" />
                <? else: ?>
                    <input type="file" name="userfile" size="20" /> 
                <? endif; ?>	
            </td>
        </tr>
        <tr height="45">	
            <td class="theadl">
                Название:<br/>
                <input id="name" name="name" size="80" value="<?= set_value('name', $page['name']) ?>" maxlength="255" type="text">	
            </td>
        </tr>
        <tr height="45">
            <td class="theadl">
                Содержание:<br/>
                <textarea id="content" name="content" ><?= set_value('content', $page['content']) ?></textarea>		
            </td>
        </tr>	
        <tr>
            <td class="theadl">
                ЧПУ:&nbsp;&nbsp;&nbsp;</br></br>
                (Если оставить пустым,то по названию построится автоматически.)</br></br>
                <input type="text" size="80" name="chpu" value="<?= set_value('chpu', $page['chpu']) ?>" />
            </td>
        </tr>	
        <tr>
            <td class="theadl">
                Title:&nbsp;&nbsp;&nbsp;</br>
                <input type="text"	size="80" name="title"	value="<?= set_value('title', $page['title']) ?>" />
            </td>
        </tr>
        <tr>
            <td class="theadl">
                Description:&nbsp;&nbsp;&nbsp;</br>
                <textarea name="mdesc" rows="4" cols="80"><?= set_value('mdesc', $page['mdesc']) ?></textarea>
            </td>
        </tr>
        <tr>
            <td class="theadl" >
                Key-words:&nbsp;&nbsp;&nbsp;&nbsp;</br>
                <textarea	name="mkeys" rows="4" cols="80"><?= set_value('mkeys', $page['mkeys']) ?></textarea>
            </td>
        </tr>   
    </tbody>
</table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= anchor('dashboard/' . $uri, 'Отменить', array('class' => "save")) ?>

