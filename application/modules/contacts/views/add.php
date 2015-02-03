<?=show_editor('content')?>
<div class="title"><?=$title;?></div>
<?=form_open_multipart('dashboard/contacts/add',array('name'=>'editform'));?> 
<table border="0" cellpadding="5" cellspacing="5">
	<tbody>
	<tr height="45">	
		<td class="theadl">
			Название:<br/>
			<input id="name" name="name" size="80" value="" type="text" style="width: 100%;">		
		</td>
	</tr>
        <tr height="45">	
		<td class="theadl">
			Ссылка на карту Google:<br/>
                        <textarea id="map" name="map" size="80" value="" style="width: 100%;height: 80px;"></textarea>		
		</td>
	</tr>
	<tr height="45">
		<td class="theadl">
			Содержание:<br/>
			<textarea id="content" name="content"  value="" ></textarea>		
		</td>
	</tr>		
   
</tbody>
</table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=anchor('dashboard/contacts','Отменить',array('class' => "save"))?>
</tbody></table>
