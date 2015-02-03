<div class="title"><?= $title; ?></div>
<div align="center"><?= anchor('dashboard/' . $uri . '/addPage/', 'Добавить', array('class' => 'save')) ?></div>
<br/>
<table width="100%" border="0" cellpadding="5" cellspacing="5" id="drag">
    <? if ($pages): ?>
        <? foreach ($pages as $page): $key++ ?>
            <tr <? if ($key % 2 == 0) echo "class='gray'"; ?> id="<?= $page['ID'] ?>" >
                <td class="drag" align="left"><?= $key ?></td>
                <td class="image" align="center" widht="80"></td>
                <td class="name" style="width:65%" align="left"><?= $page['name'] ?></td>
                <td class="theadc" align="right">
                    <a href="<?= base_url() . 'dashboard/' . $uri . '/editPage/' . $page['ID'] ?>" class="edit" title="Редактировать">Edit</a>
                    <? if ($page['status'] == '1'): ?>
                        <a href="<?= base_url() . 'dashboard/' . $uri . '/status/' . $page['ID'] . "/0" ?>" class="status on" title="Выкл">Status</a>
                    <? else: ?>
                        <a href="<?= base_url() . 'dashboard/' . $uri . '/status/' . $page['ID'] . "/1" ?>" class="status"  title="Вкл">Status</a>
                    <? endif; ?>
                    <a href="javascript:void(0)" onclick="ConfirmDelete('<?= base_url() . 'dashboard/' . $uri . '/delPage/' . $page['ID'] ?>')" class="delete"  title="Удалить">Delete</a>
                </td>
            </tr>
        <? endforeach; ?>
    <? else: ?>
        <tr>
            <td></td>
            <td colspan="4" align="center"><h3>На данный момент страниц нет!</h3></td>	
            <td></td>
        </tr>
    <? endif; ?>
</table>
<br/>
<div align="center"><?= anchor('dashboard/' . $uri . '/addPage/', 'Добавить', array('class' => 'save')) ?></div>