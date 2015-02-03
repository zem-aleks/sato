
<div class="title"><?=$title;?></div>
<br/>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<?php if($pages): foreach($pages as $page): $key++?>
<tr <?if($key%2 == 0) echo "class='gray'"; ?>>
    <!--<td class="drag" align="left"><?=$key?></td>-->
    <td class="names" align="left"><a href="/dashboard/<?=$page['machine_name']?>"><?=$page['name']?></a></td>
    <!--<td class="theadc" align="right">
		<a href="<?=base_url().'dashboard/module/edit/'.$page['ID']?>" class="edit" style="display:none;" title="Редактировать">Edit</a>
		<?if($page['status'] == '1') {;?>
			<a href="<?=base_url().'dashboard/module/status/'.$page['ID']."/0"?>" class="status on"  title="Выкл">Satatus</a>
		<?}else{?>
			<a href="<?=base_url().'dashboard/module/status/'.$page['ID']."/1"?>" class="status"  title="Вкл">Satatus</a>
		<?}?>
		<a href="javascript:void(0)" onclick="ConfirmDelete('<?=base_url().'dashboard/module/del/'.$page['ID']?>')" class="delete"  title="Удалить">Delete</a>
	</td>-->
</tr>
<?php endforeach; else:?>
<tr>
	<td></td>
	<td colspan="4" align="center"><h3>На данный момент страниц нет!</h3></td>	
	<td></td>
</tr>
<?php endif;?>
</tbody>
</table>