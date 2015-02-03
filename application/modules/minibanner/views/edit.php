<div class="title"><?= $title; ?></div>
<?= form_open_multipart('dashboard/minibanner/editImage/' . $slider['ID'], array('name' => 'editform')); ?> 
<table border="0" cellpadding="5" cellspacing="5" >
    <tbody>
        <? if (!empty($error)): ?>
            <tr>
                <td>
                    <span class="error"><?= $error; ?></span>
                </td>
            </tr> 
        <? endif; ?>
        <tr>
            <td>Изображение (109х150):<br/>
                <?php
                if ($slider['image']) {
                    print "<img src='/uploads/slider/" . $slider['image'] . "' style='max-width: 300px;max-height:300px;'/><br/>";
                    print '<input type="checkbox" name="del" />Удалить';
                    print '<input type="hidden" name="image" value="' . $slider['image'] . '" />';
                } else {
                    ?>
                    <input type="file" name="userfile" size="20" /> 
                <? } ?>			
            </td>
        </tr>
        <tr height="45">
            <td>Название:<br/>
                <input id="name" name="name" size="80" value="<?= set_value('name', $slider['name']) ?>" maxlength="255" type="text">
            <td>
        </tr>
        <tr>
            <td>Короткое описание:<br/>
                <textarea id="content" name="content"><?= set_value('content', $slider['content']) ?></textarea>
            </td>
        </tr>
        <tr height="45">
            <td>Ссылка (URL):<br/>
                <input id="link" name="link" size="80" value="<?= set_value('link', $slider['link']) ?>" maxlength="255" type="text">
            <td>
        </tr>
    </tbody></table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= anchor('dashboard/slider', 'Отменить', array('class' => "save")) ?>
