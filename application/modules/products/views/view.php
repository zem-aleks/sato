<section class="catalog-info product-view container">
    <div class="gallery">
        <h1><span><?= $product['brand']['name']; ?></span> <?= $product['name']; ?></h1>
        <div class="gallery-slider">
            <ul class="slides">
                <? foreach ($product['images'] as $image): ?>
                    <li class="pic">
                        <img src="/uploads/products/original/<?= $image['image']; ?>" alt="" />
                    </li>
                <? endforeach; ?>
            </ul>

            <? if (count($product['images']) > 1): ?>
                <ul class="flex-control-nav">
                    <? foreach ($product['images'] as $image): ?>
                        <li style="background-image: url(/uploads/products/thumb/<?= $image['image']; ?>)"></li>
                    <? endforeach; ?>
                </ul>
            <? endif; ?>
        </div>
    </div>
    <div class="description">
        <?= $product['short']; ?>
        <div class="price"><?= $product['price']; ?> <span class="rub">Р</span></div>
        <div class="button">КУПИТЬ</div>
    </div>
    <div class="clear"></div>
</section>
<section class="tech-info container">
    <table>
        <thead>
            <tr>
                <td>Тех. характеристики</td>
                <td>Сравнить</td>
                <td>Отзывы</td>
                <td>Галерея</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Управление</td>
                <td>Боковая панель управления</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Направление сети</td>
                <td>AC 220 ~ 240 V - 50 Hz</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Потребляемая мощность</td>
                <td>max 1270 Вт</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Рабочее давление воды</td>
                <td>0.70 - 7.50 кгС/см2</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Подогрев сиденья</td>
                <td>Выкл./34°C/38°C/42°C</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Регулировка температуры</td>
                <td>Выкл./34°C/38°C/42°C</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Обогрев сиденья</td>
                <td>55 Вт</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Защита</td>
                <td>температурный предохранитель</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Омывание, Обмыв, Биде, Клизма</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Потребление воды Обмыв/Биде/Клизма</td>
                <td>0.6/0.7/0.5 л/мин.</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>Контроль давления воды </td>
                <td>5-ступенчатое регулирование</td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="container">
        <div></div>
        <div></div>
    </div>
</section>