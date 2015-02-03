<div class="title"><?= $title; ?></div>
<?= form_open_multipart('dashboard/minibanner/addImage', array('name' => 'editform')); ?> 
<table border="0" cellpadding="5" cellspacing="5" >
    <tbody>
        <? if(!empty($error)):?>
        <tr>
            <td>
                <span class="error"><?=$error;?></span>
            </td>
        </tr> 
        <? endif;?>
        <tr>
            <td>Изображение (109х150):<br/>
                <input type="file" name="userfile" />   
            </td>
        </tr>
        <tr>
            <td>Название:<br/>
                <input id="name" name="name" value="<?= set_value('name') ?>" maxlength="255" type="text" />
            </td>
        </tr>
        <tr>
            <td>Короткое описание:<br/>
                <textarea id="content" name="content"><?= set_value('content') ?></textarea>
            </td>
        </tr>
        <tr>
            <td>Ссылка (URL):<br/>
                <input id="link" name="link" size="80" value="<?= set_value('link') ?>" maxlength="255" type="text" />
            </td>
        </tr>

    </tbody></table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= anchor('dashboard/slider', 'Отменить', array('class' => "save")) ?>

