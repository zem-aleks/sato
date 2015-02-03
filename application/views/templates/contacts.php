<div class="block2-in1">
    <div class="container">
        <div class="head"><?= $view['name']; ?></div>
    </div>
</div>
<div class="block3-in1">
    <div class="container">
        <?= $view['content']; ?>

        <div class="map">
            <?= $settings['map']; ?>
        </div>
        
        <div class="contact-form">
            <form method="POST" action="">
                <h2>Форма обратной связи</h2>
                <? if (isset($_SESSION['success'])): ?>
                    <div class="success">Ваша заявка успешно отправлена!</div>
                    <? unset($_SESSION['success']); ?>
                <? endif; ?>
                <div class="contact-description">
                    <? if (!empty($errors)): ?>
                        <div class="errors">
                            <b>При вводе данных произошли ошибки:</b><br/>
                            <?= $errors; ?>
                        </div>
                    <? endif; ?>
                </div>
                <input name="name" type="text" placeholder="Ваше имя" value="<?= set_value('name'); ?>"/>
                <input name="email" type="text" placeholder="E-mail" value="<?= set_value('email'); ?>"/>
                <input name="phone" type="text" placeholder="Ваш телефон" value="<?= set_value('phone'); ?>"/>
                <input name="question" type="text" placeholder="Ваш вопрос" value="<?= set_value('question'); ?>"/>
                <textarea name="comment" placeholder="Комментарий к вопросу"><?= set_value('comment'); ?></textarea>
                <input type="submit" value="Отправить" class="contact-submit blue button"/>
                <div class="clear"></div>
            </form>
        </div>
    </div>


</div>  
<!--
<div class="contacts">
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <div>
                    <h1>Контакты</h1>
                    <div class="content">
<?= $view['content']; ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-5 col-xs-offset-1">
                <div>
                    <h2>Обратная связь</h2>
                    <form method="POST" action="">
<? if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success" role="alert">Ваша заявка успешно отправлена!</div>
    <? unset($_SESSION['success']); ?>
<? endif; ?>
                        <div class="contact-description">
<? if (!empty($errors)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <b>При вводе данных произошли ошибки:</b><br/>
    <?= $errors; ?>
                                </div>
<? endif; ?>
                        </div>
                        <div class="form-group">
                            <input class="form-control input-lg" name="name" type="text" placeholder="Ваше имя" value="<?= set_value('name'); ?>"/>
                            <input class="form-control input-lg" name="email" type="text" placeholder="E-mail" value="<?= set_value('email'); ?>"/>
                            <textarea class="form-control input-lg" name="question" placeholder="Ваш вопрос"><?= set_value('question'); ?></textarea>
                            <input class="contact-submit button" type="submit" value="Отправить"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="map shadow">
<?= $settings['map']; ?>
    </div>
</div>
-->