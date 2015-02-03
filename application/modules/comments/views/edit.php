<div class="title"><?= $title; ?></div>
<?= form_open_multipart('dashboard/comments/edit/' . $page_info['ID'], array('name' => 'editform')); ?> 

<table border="0" cellpadding="5" cellspacing="5">
    <tbody>

        <tr height="45">	
            <td class="theadl">
                Имя:<br/>
                <input readonly="readonly" style="width: 100%" value="<?= set_value('name', $page_info['name']) ?>" type="text"/>	
            </td>
        </tr>
        <tr height="45">	
            <td class="theadl">
                E-mail:<br/>
                <input readonly="readonly" style="width: 100%" value="<?= set_value('email', $page_info['email']) ?>" type="text"/>		
            </td>
        </tr>
        <tr height="45">	
            <td class="theadl">
                Вопрос:<br/>
                <textarea readonly="readonly" style="width: 100%; height:100px"><?= set_value('question', $page_info['question']) ?></textarea>		
            </td>
        </tr>

    </tbody>
</table>


<? if ($page_info['status'] == '1') {
; ?>
    <a href="<?= base_url() . 'dashboard/comments/status/' . $page_info['ID'] . "/0" ?>" class="save" title="Выкл">Установить не обработанным</a>
<? } else { ?>
    <a href="<?= base_url() . 'dashboard/comments/status/' . $page_info['ID'] . "/1" ?>" class="save"  title="Вкл">Установить обработанным</a>
<? } ?>

<a href="javascript:void(0)" onclick="ConfirmDelete('<?= '/dashboard/comments/delPage/' . $page_info['ID'] ?>')" class="save"  title="Удалить">Удалить</a>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= anchor('dashboard/comments', 'Назад', array('class' => "save")) ?>

