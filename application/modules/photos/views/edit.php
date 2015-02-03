<div class="title"><?=$title;?></div>
<?=form_open_multipart('dashboard/item/edit/'.$page_info['ID'],array('name'=>'editform'));?> 

<table border="0" cellpadding="5" cellspacing="5">
	<tbody>
        <tr>
		<td>Фото:<br/>
			<?php 
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/items/'.$page_info['ID'].'.jpg')){
					print "<img src='/uploads/items/".$page_info['ID'].".jpg' style='max-height:150px;'/><br/>";
					print '<input type="checkbox" name="del" />Удалить';
					print '<input type="hidden" name="image" value="/uploads/items/'.$page_info['ID'].'.jpg" />';
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
			Цена (разделение через точку):<br/>
			<input id="price" name="price" size="80" value="<?=set_value('price',$page_info['price'])?>" maxlength="12" type="text">		
		</td>
	</tr>
	<tr height="45">
            <td>Прикрепить к каталогу (укажите ID каталога):<br/>
                <input id="id_parent" class="ajax" name="id_parent" size="80" value="<?= $page_info['id_catalog'];?>" maxlength="8" type="text">
                Название каталога: "<span class="analyze" style="color: red"></span>"
            </td>
        </tr>
	<tr height="45">
		<td class="theadl">
			Содержание:<br/>
			<textarea id="content" style="width: 100%;height:80px" name="content" ><?=set_value('content',$page_info['content'])?></textarea>		
		</td>
	</tr>	
</tbody>
</table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=anchor('dashboard/item','Отменить',array('class' => "save"))?>

