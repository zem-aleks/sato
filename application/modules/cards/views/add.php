<div class="title"><?= $title; ?></div>
<?= form_open_multipart('dashboard/cards/add', array('name' => 'editform')); ?> 
<table border="0" cellpadding="5" cellspacing="5" >
    <tbody>
        <tr>
            <td>Название банка:<br/>
                <input id="name" name="name" size="80" value="" maxlength="255" type="text">
            </td>
        </tr>
        <tr>
            <td>Номер карты:<br/>
                <input id="number" name="number" size="80" value="" maxlength="20" type="text">
            </td>
        </tr>
</tr>

</tbody></table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a> 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= anchor('dashboard/cards', 'Отменить', array('class' => "save")) ?>

