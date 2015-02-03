<div class="profile_info shadow">
<?php if(!empty($errors)){
print_r($errors);
 }?>
<?=form_open_multipart('admin/settings/changePass',array('name'=>'editform'));?> 
<div>
<div class="row_span">
Введите новый пароль:



<input type="password" name="password"></br>
</div>
<div class="row_span">
Подтвердите новый пароль:
<input type="password" name="confirm_password">
</div>
</div>

<div style="padding:20px; text-align:center;">
<a href="javascript:void(0)" style="background: #f58f30;padding:10px 22px;text-transform:uppercase;color:#ffffff;margin-left:30px;" class="orange_link" onclick="document.editform.submit()">Сохранить</a>
</div> 
</form>

<pre>
<?php //print_r($errors)?>
</pre>
</div>