<div class="title"><?=$title;?></div>
<br/>
<?=form_open_multipart('dashboard/settings/save',array('name'=>'editform'));?> 
<table width="100%" border="0" cellpadding="5" cellspacing="5">
<?php if($settings): foreach($settings as $page): $key++?>
	<tr height="35">	
		<td class="theadl">
			<?=$page['title']?>:<br/>
			<textarea id="name<?=$key?>" name="set[]" size="100" ><?=set_value('value',$page['value'])?></textarea>	
			<input name="id[]" value="<?=$page['ID']?>" type="hidden">	
                        <br/><br/>
		</td>
	</tr>	
<?php endforeach; 
else:?>
<tr>
	<td></td>
	<td colspan="4" align="center"><h3>На данный момент настроек нет!</h3></td>	
	<td></td>
</tr>
<?php endif;?>
</tbody>
</table>
<input type='submit' value='Сохранить' class="save"/>
</form>
<br/>