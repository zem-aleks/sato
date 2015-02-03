<?=show_editor('#content')?>
<div class="title"><?=$title;?></div>
<?=form_open_multipart('dashboard/articles/edit/'.$page_info['ID'],array('name'=>'editform'));?> 

<table border="0" cellpadding="5" cellspacing="5">
	<tbody>
        <tr>
		<td>Фото:<br/>
			<?php 
				if(!empty($page_info['image']) && $page_info['image']!='no_image.jpg'){
					print "<img src='".base_url().'uploads/articles/thumb/'.$page_info['image']."' style='max-height:150px;'/><br/>";
					print '<input type="checkbox" name="del" />Удалить';
					print '<input type="hidden" name="image" value="'.base_url().'uploads/items/'.$page_info['image'].'" />';
				}
				else{?>
					<input type="file" name="userfile" size="20" /> 
			<? 	}?>			
		</td>
	</tr>
	<tr height="45">	
		<td class="theadl">
			Название:<br/>
			<input id="name" name="name" size="80" value="<?=set_value('name',$page_info['name'])?>" maxlength="255" type="text">	
		</td>
	</tr>
	<tr height="45">
		<td class="theadl">
			Содержание:<br/>
			<textarea id="content" name="content" ><?=set_value('content',$page_info['content'])?></textarea>		
		</td>
	</tr>	
	<tr>
		<td class="theadl">
			ЧПУ:&nbsp;&nbsp;&nbsp;</br></br>
			(Если оставить пустым,то по названию построится автоматически.)</br></br>
			<input type="text" size="80" name="chpu" value="<?=set_value('chpu',$page_info['chpu'])?>" />
		</td>
	</tr>	
    <tr>
		<td class="theadl">
			Title:&nbsp;&nbsp;&nbsp;</br>
			<input type="text"	size="80" name="title"	value="<?=set_value('title',$page_info['title'])?>" />
		</td>
	</tr>
	<tr>
		<td class="theadl">
			Description:&nbsp;&nbsp;&nbsp;</br>
			<textarea name="mdesc" rows="4" cols="80"><?=set_value('mdesc',$page_info['mdesc'])?></textarea>
		</td>
	</tr>
	<tr>
		<td class="theadl" >
			Key-words:&nbsp;&nbsp;&nbsp;&nbsp;</br>
			<textarea	name="mkeys" rows="4" cols="80"><?=set_value('mkeys',$page_info['mkeys'])?></textarea>
		</td>
	</tr>   
</tbody>
</table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=anchor('dashboard/articles','Отменить',array('class' => "save"))?>

