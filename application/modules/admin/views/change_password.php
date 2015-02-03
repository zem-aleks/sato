<br>
<h1>Сменить пароль</h1>
<br>

<? if (!empty($error)): ?>
    <div class="alert alert-danger" role="alert">
        <b>При вводе данных произошли ошибки:</b><br/>
        <?= $error; ?>
    </div>
<? endif; ?>
<? if (!empty($success)): ?>
    <div class="alert alert-success" role="alert">
        <b>Ваш запрос успешно обработан!</b>
    </div>
<? endif;?>

<form action="" method="POST">
    <input type="password" name="password1" placeholder="Старый пароль">
    <input type="password" name="password2" placeholder="Новый пароль">
    <input type="password" name="password3" placeholder="Повторите новый пароль">
    <input type="submit" class="button" value="Сохранить">
</form>
