<div class="title"><?=$title;?></div>
<br/>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<?php if($pages): foreach($pages as $page): $key++?>
<tr <?if($key%2 == 0) echo "class='gray'"; ?> id="<?=$page['ID']?>" >
    
    <td class="name" style="width:96%" align="left"><?=$page['name']?></td>
    <td class="theadc" align="right">
		<a href="<?=base_url().'dashboard/pages/editPage/'.$page['ID']?>" class="edit" title="Редактировать">Edit</a>		
    </td>
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
<br/>