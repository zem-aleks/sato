<div class="profile_info shadow">
<div class="title"><?=$title;?></div>

<?=form_open_multipart('dashboard/users/add',array('name'=>'editform'));?> 
<table border="0" cellpadding="5" cellspacing="5" >
	<tbody>
	<tr height="45">
	
		<td class="theadl">Имя:</td>
		<td><input id="fname" name="fname" size="100" value="<?=set_value('fname')?>" maxlength="255" style="width: 100%;" type="text">
		</td>
        <td class="clm" width="31"></td>
	</tr>
	
	<tr height="45">
	
		<td class="theadl">Фамилия:</td>
		
		<td><input id="lname" name="lname" size="100" value="<?=set_value('lname')?>" maxlength="255" style="width: 100%;" type="text">
		
		</td>
        <td class="clm" width="31"></td>
	</tr>
	
	<tr height="45">
	
		<td class="theadl">Логин:</td>
		
		<td><input id="username" name="username" size="100" value="<?=set_value('login')?>" maxlength="255" style="width: 100%;" type="text">
		
		</td>
        <td class="clm" width="31"></td>
	</tr>
	
	<tr height="45">
	
		<td class="theadl">Email:</td>
		
		<td><input id="email" name="email" size="100" value="<?=set_value('email')?>" maxlength="255" style="width: 100%;" type="text">
		
		</td>
        <td class="clm" width="31"></td>
	</tr>
	<tr height="45">
	
		<td class="theadl">Логин:</td>
		
		<td><input id="username" name="username" size="100" value="<?=set_value('username')?>" maxlength="255" style="width: 100%;" type="text">
		
		</td>
        <td class="clm" width="31"></td>
	</tr>
	<tr height="45">
	
		<td class="theadl">Пароль:</td>
		
		<td><input id="password" name="password" size="100" value="<?=set_value('password')?>" maxlength="255" style="width: 100%;" type="text">
		
		</td>
        <td class="clm" width="31"></td>
	</tr>
	<tr height="45">
	
		<td class="theadl">Телефон:</td>
		
		<td><input id="phone" name="phone" size="100" value="<?=set_value('phone')?>" maxlength="255" style="width: 100%;" type="text">
		
		</td>
        <td class="clm" width="31"></td>
	</tr>	
	<tr height="45">
	
		<td class="theadl">Город:</td>
		
		<td><input id="city" name="city" size="100" value="<?=set_value('city')?>" maxlength="255" style="width: 100%;" type="text">
		
		</td>
        <td class="clm" width="31"></td>
	</tr>
		
</tbody></table>
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?=anchor('dashboard/users','Отменить',array('class' => "save"))?>

</div>
