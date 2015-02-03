<?=show_editor('content')?>
<div class="title"><?=$title;?></div>
<?=form_open_multipart('admin/pages/add',array('name'=>'editform'));?> 
<table border="0" cellpadding="5" cellspacing="5">
	<tbody>
	<tr height="45">	
		<td class="theadl">
			Название:<br/>
			<input id="name" name="name" size="80" value="" maxlength="255" type="text">		
		</td>
	</tr>	
	<tr height="45">
		<td class="theadl">
			Содержание:<br/>
			<textarea id="content" name="content"  value="" ></textarea>		
		</td>
	</tr>	
	<tr>
		<td class="theadl">
			ЧПУ:&nbsp;&nbsp;&nbsp;</br></br>
			(Если оставить пустым,то по названию построится автоматически.)</br></br>
			<input type="text" size="80" name="chpu" value="" />
		</td>
	</tr>	
    <tr>
		<td class="theadl">
			Title:&nbsp;&nbsp;&nbsp;</br>
			<input type="text"	size="80" name="title"	value="" />
		</td>
	</tr>
	<tr>
		<td class="theadl">
			Description:&nbsp;&nbsp;&nbsp;</br>
			<textarea name="mdesc" rows="4" cols="80"></textarea>
		</td>
	</tr>
	<tr>
		<td class="theadl" >
			Key-words:&nbsp;&nbsp;&nbsp;&nbsp;</br>
			<textarea	name="mkeys" rows="4" cols="80"></textarea>
		</td>
	</tr>   
</tbody>
</table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=anchor('admin/pages','Отменить',array('class' => "save"))?>
</tbody></table>
