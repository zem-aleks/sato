<div class="title"><?= $title; ?></div>
<?= form_open_multipart('dashboard/slider/addImage', array('name' => 'editform')); ?> 
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
            <td>Изображение (1920х652):<br/>
                <input type="file" name="userfile" size="20" />   
            </td>
        </tr>
        <tr>
            <td>Название:<br/>
                <input id="name" name="name" size="80" value="<?= set_value('name') ?>" maxlength="255" type="text" />
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

