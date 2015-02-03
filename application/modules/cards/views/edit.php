<div class="title"><?=$title;?></div>
<?=form_open_multipart('dashboard/cards/edit/'.$page_info['ID'],array('name'=>'editform'));?> 

<table border="0" cellpadding="5" cellspacing="5">
	<tbody>
	<tr height="45">	
		<td class="theadl">
			Название банка:<br/>
			<input id="name" name="name" size="80" value="<?=set_value('name',$page_info['name'])?>" style="width: 100%;" type="text">	
		</td>
	</tr>
        <tr height="45">	
		<td class="theadl">
			Номер карты:<br/>
                        <input id="number" name="number" size="80" value="<?=set_value('number',$page_info['number'])?>" style="width: 100%;" type="text"/>
		</td>
	</tr>
</tbody>
</table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=anchor('dashboard/cards','Отменить',array('class' => "save"))?>

