<div class="title"><?= $title; ?></div>
<div align="center"><?= anchor('dashboard/cards/addPage/', 'Добавить карточку', array('class' => 'save')) ?></div>
<br/>

<table width="100%" border="0" cellpadding="5" cellspacing="5" id="drag">
    <?php if ($cards):?>
        <? foreach ($cards as $page): $key++ ?>
            <tr <? if ($key % 2 == 0) echo "class='gray'"; ?> id="<?= $page['ID'] ?>" >
                <td class="id" style="width:7%" align="center"><?= $page['ID'] ?></td> 
                <td class="name" style="width:40%" align="left"><?= $page['name'] ?></td>
                <td class="number" style="width:40%" align="left"><?= $page['number'] ?></td>
                <td class="theadc" align="right" width="90">
                    <a href="<?= base_url() . 'dashboard/cards/editPage/' . $page['ID'] ?>" class="edit" title="Редактировать">Edit</a>
                    <? if ($page['status'] == '1') {
; ?>
                        <a href="<?= base_url() . 'dashboard/cards/status/' . $page['ID'] . "/0" ?>" class="status on" title="Выкл">Satatus</a>
                    <? } else { ?>
                        <a href="<?= base_url() . 'dashboard/cards/status/' . $page['ID'] . "/1" ?>" class="status"  title="Вкл">Satatus</a>
        <? } ?>

                    <a href="javascript:void(0)" onclick="ConfirmDelete('<?= base_url() . 'dashboard/cards/delPage/' . $page['ID'] ?>')" class="delete"  title="Удалить">Delete</a>
                </td>
            </tr>
        <? endforeach; ?>
<? else: ?>
        <tr>
            <td></td>
            <td colspan="4" align="center"><h3>На данный момент карточек нет!</h3></td>	
            <td></td>
        </tr>
<? endif; ?>
</tbody>
</table>

<div align="center"><?= anchor('dashboard/cards/addPage/', 'Добавить карточку', array('class' => 'save')) ?></div>
