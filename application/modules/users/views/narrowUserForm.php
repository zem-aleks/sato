<div class="try-form narrow rshadow <?= $class; ?>">
    <div class="title">ЗАПИШИСЬ НА БЕСПЛАТНЫЙ УРОК!</div>
    <form class="lesson-form" action="" method="POST">
        <div class="try-fields">
            <input type="text" name="name" placeholder="Ваше имя" required="required"/>
            <input type="text" name="phone" placeholder="Номер телефона" required="required"/>
            <input type="text" name="email" placeholder="Email" required="required"/>
            <select name="id_level" required="required">
                <option value="0">Ваш уровень</option>
                <? foreach ($levels as $level): ?>
                    <option value="<?= $level['ID']; ?>"><?= $level['name']; ?></option>
                <? endforeach; ?>
            </select>
            <select name="id_school" required="required">
                <option value="0">Расположение</option>
                <? foreach ($schools as $school): ?>
                    <option value="<?= $school['ID']; ?>"><?= $school['name']; ?></option>
                <? endforeach; ?>
            </select>
            <input type="submit" class="button blue" value="ЗАПИСАТЬСЯ" />
            <div class="clear"></div>
        </div>
    </form>
</div>