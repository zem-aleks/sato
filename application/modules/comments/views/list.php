<div class="title"><?= $title; ?></div>
<br/>
<?= $paginator; ?>
<table width="100%" border="0" cellpadding="5" cellspacing="5" class="comments-table">
    <? $key = 0; ?>
    <? if ($pages): ?> 
        <? foreach ($pages as $page): ?>
            <? $key++; ?>
            <tr <? if ($key % 2 == 0) echo "class='gray'"; ?> id="<?= $page['ID'] ?>" >
                <td align="center"><?= $page['ID'] ?></td>
                <td class="cname" align="left"><?= $page['name'] ?></td>
                <td class="email" align="left"><?= $page['email'] ?></td>
                <td class="email" align="left"><?= $page['date'] ?></td>
                <td class="theadc" align="right" width="90px">
                    <a href="<?= base_url() . 'dashboard/comments/editPage/' . $page['ID'] ?>" class="edit" title="Редактировать">Edit</a>
                    <? if ($page['status'] == '1') : ?>
                        <a href="<?= base_url() . 'dashboard/comments/status/' . $page['ID'] . "/0" ?>" class="status on" title="Выкл">Satatus</a>
                    <? else: ?>
                        <a href="<?= base_url() . 'dashboard/comments/status/' . $page['ID'] . "/1" ?>" class="status"  title="Вкл">Satatus</a>
                    <? endif; ?>
                    <a href="javascript:void(0)" onclick="ConfirmDelete('<?= base_url() . 'dashboard/comments/delPage/' . $page['ID'] ?>')" class="delete"  title="Удалить">Delete</a>
                </td>
            </tr>
        <? endforeach; ?>
    <? else: ?>
        <tr>
            <td></td>
            <td colspan="4" align="center"><h3>На данный момент товаров нет!</h3></td>	
            <td></td>
        </tr>
    <? endif; ?>
</tbody>
</table>
<?= $paginator; ?>