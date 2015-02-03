<div class="title"><?=$title;?></div>
<?=form_open_multipart('dashboard/item/add',array('name'=>'editform'));?> 
<table border="0" cellpadding="5" cellspacing="5">
	<tbody>
        <tr>
		<td>Фото:<br/>
			<input type="file" name="userfile" size="20" />   
		</td>
	</tr>
	<tr height="45">	
		<td class="theadl">
			Название:<br/>
			<input id="name" name="name" size="80" value="" maxlength="255" type="text">		
		</td>
	</tr>
        <tr height="45">	
		<td class="theadl">
			Цена (разделение через точку):<br/>
			<input id="price" name="price" size="80" value="" maxlength="12" type="text">		
		</td>
	</tr>
	<tr height="45">
            <td>Прикрепить к каталогу (укажите ID каталога):<br/>
                <input id="id_parent" class="ajax" name="id_parent" size="80" value="0" maxlength="8" type="text">
                Название каталога: "<span class="analyze" style="color: red">Корень</span>"
            </td>
        </tr>
	<tr height="45">
		<td class="theadl">
			Содержание:<br/>
                        <textarea style="width: 100%" id="content" name="content"  value="" ></textarea>		
		</td>
	</tr>	
</tbody>
</table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=anchor('dashboard/item','Отменить',array('class' => "save"))?>
</tbody></table>
