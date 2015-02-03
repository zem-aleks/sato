<div class="title"><?=$title;?></div>
<?=form_open_multipart('dashboard/banners/editBanner/'.$banner['ID'],array('name'=>'editform'));?> 
<table border="0" cellpadding="5" cellspacing="5" >
	<tbody>
	<tr>
		<td>Фото:<br/>
			<?php 
				if($banner['image']){
					print "<img src='/uploads/banners/".$banner['image']."' style='max-height:300px; max-width: 400px;'/><br/>";
					print '<input type="checkbox" name="del" />Удалить';
					print '<input type="hidden" name="image" value="'.$banner['image'].'" />';
				}
				else{?>
					<input type="file" name="userfile" size="20" /> 
			<? 	}?>			
		</td>
	</tr>
	<tr height="45">
		<td>Название:<br/>
			<input id="name" name="name" size="80" value="<?=set_value('name',$banner['name'])?>" maxlength="255" type="text">
		<td>
	</tr>
        <tr height="45">
            <td>Прикрепить к каталогу (укажите ID каталога):<br/>
                <input id="id_parent" class="ajax" name="categoryID" size="80" value="<?=set_value('categoryID',$banner['categoryID'])?>" maxlength="8" type="text">
                Название каталога: "<span class="analyze" style="color: red">Корень</span>"
            </td>
        </tr>
        <tr>
        <!--<td>Прикрепить к странице:<br/>
            <select id="categoryID" name="categoryID" value="<?=set_value('categoryID',$banner['categoryID'])?>">
                <option value="">Выберите страницу</option>
                <? foreach($categories as $key=>$cat):?>
                <option <?if($key==$banner['categoryID']):?>selected="selected"<?endif;?> value="<?=$key;?>"><?=$cat;?></option>
                <? endforeach;?>
            </select>
		</td>
	</tr>-->
	<tr>
		<td>Ссылка:</br>
			<input type="text"	size="80" name="link" value="<?=set_value('link',$banner['link'])?>" />
		</td>
	</tr>
</tbody></table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=anchor('dashboard/banners','Отменить',array('class' => "save"))?>
