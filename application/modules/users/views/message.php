<div class="profile_info shadow">
    <div class="title"><?= $title; ?></div>

    <form action="" method="POST">
        
        <? if(!empty($info)):?>
        <div class="result">
            <span class="red" style="color: red">
                <b>
                <? if($info['error'] == 0):?>
                Сообщение отправлено!
                <? else:?> 
                Ошибка отправки. Проверьте корректность данных пользователя и заполненных полей!
                <? endif;?>
                </b>
            </span>
        </div><br/>
        <? endif;?>
        
        <span><b>Кому:</b></span><br/>
        <span>
        <?=$user['surname'].' '.$user['name'].' ( почтовый ящик: <b>'.$user['email'].'</b> )';?>
        </span><br/>
        
        <input type="hidden" name="rollback" value="1"/>
        <span><b>Тип сообщения:</b></span><br/>

        <input type="radio" id="email" value="email" checked="checked" name="type"/>
        <label for="email">Сообщение на почту</label><br/>

        <span><b>Сообщение:</b></span><br/>
        <textarea style="width: 700px; height: 80px; margin-bottom: 10px" required="required" name="message"></textarea><br/>
        <input type="submit" value="Отправить"/>
    </form>
</div>