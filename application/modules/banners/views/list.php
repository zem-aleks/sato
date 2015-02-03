<div class="title"><?=$title;?></div>
<div align="center"><?=anchor('dashboard/banners/add/','Добавить баннер',array('class'=>'save'))?></div>
<br/>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<?php if($banners): foreach($banners as $page): $key++?>
<tr <?if($key%2 == 0) echo "class='gray'"; ?> id="<?=$page['ID']?>" >
    <td align="left">
				<?php 
				if($page['image']){
					print "<div class='perview'><img src='/uploads/banners/".$page['image']."'/></div>";
				}
				else{
					print '<img width="80" src="/uploads/banners/no_image.jpg" alt="нет изображения" title="нет изображения"/>';
				}?>		
	</td>
    <td class="name" align="left" style="width:37%"><?=$page['name']?></td>
	<td class="name" align="left" style="width:37%"><?=$page['link']?></td>
    <td class="theadc" align="right">
		<a href="<?=base_url().'dashboard/banners/edit/'.$page['ID']?>" class="edit" title="Редактировать">Edit</a>
		<?if($page['status'] == '1') {;?>
			<a href="<?=base_url().'dashboard/banners/status/'.$page['ID']."/0"?>" class="status on" title="Выкл">Satatus</a>
		<?}else{?>
			<a href="<?=base_url().'dashboard/banners/status/'.$page['ID']."/1"?>" class="status"  title="Вкл">Satatus</a>
		<?}?>
		
		<a href="javascript:void(0)" onclick="ConfirmDelete('<?=base_url().'dashboard/banners/delBanner/'.$page['ID']?>')" class="delete"  title="Удалить">Delete</a>
	</td>
</tr>
<?php endforeach; else:?>
<tr>
	<td></td>
	<td colspan="4" align="center"><h3>На данный момент баннеров нет!</h3></td>	
	<td></td>
</tr>
<?php endif;?>
</tbody>
</table>

<div align="center"><?=anchor('dashboard/banners/add/','Добавить баннер',array('class'=>'save'))?></div>          
