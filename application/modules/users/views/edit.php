<div class="profile_info shadow">
    <div class="title"><?= $title; ?></div>

    <?= form_open_multipart('dashboard/users/edit/' . $user['ID'], array('name' => 'editform')); ?> 
    <h3>Пользователь</h3>
    <table class="content2" border="0" cellpadding="5" cellspacing="5" >
        <tbody>
            <tr height="45">

                <td class="theadl">Имя:</td>

                <td><input id="name" name="uname" size="100" value="<?= set_value('name', $user['name']) ?>" maxlength="255" style="width: 100%;" type="text">

                </td>
                <td class="clm" width="31"></td>
            </tr>

            <tr height="45">

                <td class="theadl">Фамилия:</td>

                <td><input id="surname" name="usurname" size="100" value="<?= set_value('surname', $user['surname']) ?>" maxlength="255" style="width: 100%;" type="text">

                </td>
                <td class="clm" width="31"></td>
            </tr>

            <tr height="45">

                <td class="theadl">Email:</td>

                <td><input id="email" name="uemail" size="100" value="<?= set_value('email', $user['email']) ?>" maxlength="255" style="width: 100%;" type="text">

                </td>
                <td class="clm" width="31"></td>
            </tr>

            <tr height="45">

                <td class="theadl">Телефон:</td>

                <td><input id="phone" name="uphone" size="100" value="<?= set_value('phone', $user['phone']) ?>" maxlength="255" style="width: 100%;" type="text">

                </td>
                <td class="clm" width="31"></td>
            </tr>


        </tbody>
    </table>
    <div class="clear"></div>
    <br/>
<!--
    <div class="user-contacts">
        <? foreach ($contacts as $value): ?>
        <? endforeach; ?>
    </div>

    <div class="contacts">
        <? foreach ($contacts as $contact): ?>
            <h3>
                <div>
                    <? if ($contact['type'] == 'house'): ?>Частный дом
                    <? elseif ($contact['type'] == 'flat'): ?>Квартира
                    <? elseif ($contact['type'] == 'office'): ?>Офис
                    <? else: ?>Неизвестно
                    <? endif; ?>
                </div>
            </h3>
            <fieldset>
                <label>Фамилия:</label><input  type="text" name="contacts[<?=$contact['type'];?>][surname]" value="<?= $contact['surname']; ?>"/>
                <label>Имя:</label><input  type="text" name="contacts[<?=$contact['type'];?>][name]" value="<?= $contact['name']; ?>"/>
            </fieldset>
            <fieldset>
                <label>Телефон:</label><input  type="text" name="contacts[<?=$contact['type'];?>][phone]" value="<?= $contact['phone']; ?>"/>
                <label>Email:</label><input class="email" req type="text" name="contacts[<?=$contact['type'];?>][email]" value="<?= $contact['email']; ?>"/>
            </fieldset>

            <fieldset>
                <label>Улица:</label><input  type="text" name="contacts[<?=$contact['type'];?>][street]" value="<?= $contact['street']; ?>"/>
                <label>Дом:</label><input  type="text" name="contacts[<?=$contact['type'];?>][house]" style="width:50px" value="<?= $contact['house']; ?>"/>
                <? if($contact['type'] != 'house'):?>
                <label><?if($contact['type'] == 'flat'):?>Квартира<? else:?>Офис<?endif;?>:</label><input type="text" name="contacts[<?=$contact['type'];?>][room]" style="width:50px" value="<?= $contact['room']; ?>"/>
                <? endif;?>
            </fieldset>

            <fieldset>
                <label>Город:</label><input type="text" name="contacts[<?=$contact['type'];?>][city]" value="<?= $contact['city']; ?>"/>
                <label>Район:</label><input type="text" name="contacts[<?=$contact['type'];?>][district]" value="<?= $contact['district']; ?>"/>
            </fieldset>
        <? endforeach; ?>
    </div>
-->
    <a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= anchor('dashboard/users', 'Отменить', array('class' => "save")) ?>

</div>