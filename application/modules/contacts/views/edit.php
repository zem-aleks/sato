<?=show_editor('content')?>
<div class="title"><?=$title;?></div>
<?=form_open_multipart('dashboard/contacts/edit/'.$page_info['ID'],array('name'=>'editform'));?> 

<table border="0" cellpadding="5" cellspacing="5">
	<tbody>
	<tr height="45">	
		<td class="theadl">
			Название:<br/>
			<input id="name" name="name" size="80" value="<?=set_value('name',$page_info['name'])?>" style="width: 100%;" type="text">	
		</td>
	</tr>
        <tr height="45">	
		<td class="theadl">
			Ссылка на карту Google:<br/>
                        <textarea id="map" name="map" size="80" value="" style="width: 100%;height: 80px;"><?=set_value('map',$page_info['map'])?></textarea>		
		</td>
	</tr>
	<tr height="45">
		<td class="theadl">
			Содержание:<br/>
			<textarea id="content" name="content" ><?=set_value('content',$page_info['content'])?>"</textarea>		
		</td>
	</tr>  
</tbody>
</table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=anchor('dashboard/contacts','Отменить',array('class' => "save"))?>

