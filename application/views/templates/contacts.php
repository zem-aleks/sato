<div class="contact-page">
    <div class="container">
        <div class="contacts">
            <h1>Контакты</h1>
            <?=$view['content']; ?>
            <!--<div class="phone">
                <div class="number">+7(495)760-27-80</div>
                <span class="small">единый телефон для всех отделов</span>
            </div>
            <p>
                Официальное представительство
                <br><a href="">officicalsato@mail.com </a>
            </p>
            <p>
                Дирекция по развитию и сотрудничеству
                <br><a href="">directorsato@mail.com</a>
            </p>
            <p>
                <span>Техническая поддержка</span>
                <br><a href="">texsato@mail.com</a>
            </p>
            <p class="address">
                <span>Главный сервисный центр</span>
                <br>ТЦ «Метр квадратный» 2 этаж, павильон 59
            </p>
            <p>
                <span class="small">г. Москва, Волгоградский проспект </span>
                <br><span class="small">д. 32, корпус 25, 2 этаж, павильон 59</span>
            </p>-->
        </div>
        <div class="write">
            <h1>Обратная связь</h1>
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
                    <input class="text" name="name" type="text" placeholder="Ваше имя" value="<?= set_value('name'); ?>"/>
                    <input  class="text" name="email" type="text" placeholder="E-mail" value="<?= set_value('email'); ?>"/>
                    <textarea class="text" name="question" placeholder="Сообщение"><?= set_value('question'); ?></textarea>
                    <input class="contact-submit button" type="submit" value="Отправить"/>
                </div>
            </form>
        </div>
        <h1>Как добраться ?</h1>
        <div class="map">
            <?= $settings['map']; ?>
        </div>
    </div>
</div>