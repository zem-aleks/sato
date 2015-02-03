<div class="<?=$class;?>">
    <div class="container">
        <div class="title">ЗАПИШИСЬ НА БЕСПЛАТНЫЙ УРОК!</div>
        <form class="lesson-form" action="" method="POST">
            <div class="try-fields">
                    <div class="left">
                        <input type="text" name="name" placeholder="Ваше имя" required="required"/>
                        <input type="text" name="phone" placeholder="Номер телефона" required="required"/>
                        <input type="text" name="email" placeholder="Email" required="required"/>
                    </div>
                    <div class="right">
                        <select name="id_level" required="required" value="<?=$id_level;?>">
                            <option value="0">Ваш уровень</option>
                            <? foreach($levels as $level): ?>
                                <option <? if($level['ID'] == $id_level):?>selected="selected"<?endif;?> value="<?=$level['ID'];?>"><?=$level['name'];?></option>
                            <? endforeach; ?>
                        </select>
                        <select name="id_school" required="required" value="<?=$id_school;?>">
                            <option value="0">Расположение</option>
                            <? foreach($schools as $school): ?>
                                <option <? if($school['ID'] == $id_school):?>selected="selected"<?endif;?> value="<?=$school['ID'];?>"><?=$school['name'];?></option>
                            <? endforeach ;?>
                        </select>
                        <input type="submit" class="button blue" value="ЗАПИСАТЬСЯ" />
                    </div>
                    <div class="clear"></div>
            </div>
        </form>
    </div>
</div>