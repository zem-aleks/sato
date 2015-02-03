<div class="title"><?=$title;?></div>
<div align="center"><?=anchor('dashboard/minibanner/add/','Добавить',array('class'=>'save'))?></div>
<br/>
<table width="100%" border="0" cellpadding="5" cellspacing="5" id="drag">
<?php if($slider): foreach($slider as $page): $key++?>
<tr <?if($key%2 == 0) echo "class='gray'"; ?> id="<?=$page['ID']?>" >
    <td align="left">
				<?php 
				if($page['image']){
					print "<div class='perview'><img src='/uploads/slider/".$page['image']."'/></div>";
				}
				else{
					print "нет изображения";
				}?>		
	</td>
    <td class="name" align="left" style="width:35%"><?=$page['name']?></td>
    <td class="name" align="left" style="width:35%"><?=$page['link']?></td>
    <td class="theadc" style="width:20%" align="right">
		<a href="<?=base_url().'dashboard/minibanner/edit/'.$page['ID']?>" class="edit" title="Редактировать">Edit</a>
		<?if($page['status'] == '1') {;?>
			<a href="<?=base_url().'dashboard/minibanner/status/'.$page['ID']."/0"?>" class="status on" title="Выкл">Satatus</a>
		<?}else{?>
			<a href="<?=base_url().'dashboard/minibanner/status/'.$page['ID']."/1"?>" class="status"  title="Вкл">Satatus</a>
		<?}?>
		
		<a href="javascript:void(0)" onclick="ConfirmDelete('<?=base_url().'dashboard/minibanner/del/'.$page['ID']?>')" class="delete"  title="Удалить">Delete</a>
	</td>
</tr>
<?php endforeach; else:?>
<tr>
	<td></td>
	<td colspan="4" align="center"><h3>На данный момент ничего нет!</h3></td>	
	<td></td>
</tr>
<?php endif;?>
</tbody>
</table>

<div align="center"><?=anchor('dashboard/minibanner/add/','Добавить',array('class'=>'save'))?></div>          
