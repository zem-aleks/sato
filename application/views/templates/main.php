<section class="top-slider">
    <div class="container main-slider">
        <ul class="main-slides">
            <? foreach ($sliderProducts as $product): ?>
            <li>
                <div class="item-decription">
                    <div class="item-category"><?=$product['category']['name'];?></div>
                    <a href="/products/view/<?=$product['chpu'];?>" class="item-name"><span class="brand"><?=$product['brand']['name'];?></span> <?=$product['name'];?></a>
                    <div class="item-details">
                        <?=$product['slider_desc'];?>
                    </div>
                    <div class="price"><?=$product['price'];?><span class="rub">Р</span></div>
                    <div class="button">КУПИТЬ</div>
                </div>

                <div class="item-gallery">
                    <div class="gallery-slider">
                        <ul class="slides">
                            <? foreach ($product['images'] as $image): ?>
                            <li class="pic">
                                <img src="/uploads/products/original/<?=$image['image'];?>" alt="" />
                                <!--<div class="tizers">
                                    <div class="tizer" style="left: 20px; top: 20px;">
                                        <div class="tizer-msg">
                                            <div class="tizer-title">Информационное табло</div>
                                            Показывает какой режим включен, а так же помогает 
                                            лучше ориентироваться в полезных функциях устройства
                                        </div>
                                    </div>
                                </div>-->
                            </li>
                            <? endforeach; ?>
                        </ul>
                        
                        <? if(count($product['images']) > 1): ?>
                        <ul class="flex-control-nav">
                            <? foreach ($product['images'] as $image): ?>
                            <li style="background-image: url(/uploads/products/thumb/<?=$image['image'];?>)"></li>
                            <? endforeach; ?>
                        </ul>
                        <? endif; ?>
                    </div>
                </div>

                <div class="clear"></div>
            </li>
            <? endforeach; ?>
        </ul>
        <!--<ul class="main-control-direction">
            <? foreach ($sliderProducts as $product): ?>
            <li><?=$product['name'];?></li>
            <? endforeach; ?>
        </ul>-->
        <ul class="main-control-nav">
            <? foreach ($sliderProducts as $product): ?>
            <li><?=$product['name'];?></li>
            <? endforeach; ?>
        </ul>
        
    </div>
</section>
<section class="desk">
    <div class="container">
        <div class="heading">SATO ЭТО</div>
        <div class="items">
            <div class="item flag">Сделано в традициях <b>японского качества</b></div>
            <div class="item star">Расширенная гарантия <b>на 5 лет</b></div>
            <div class="item pencil"><b>Современный дизайн и функционал</b></div>
        </div>
    </div>
</section>
<section class="models">
    <div class="container">
        <div class="heading">МОДЕЛИ</div>
        <div class="products flexslider">
            <ul class="slides">
                <li>
                    <? foreach ($models as $key => $model): ?>
                    
                        <? if($key > 0 && $key % 3 == 0):?>
                            </li><li>
                        <? endif;?>
                    
                        <a href="/products/view/<?=$model['chpu'];?>" class="item">
                            <div class="pic">
                                <img src="/uploads/products/thumb/<?=$model['image'];?>" alt="<?=$model['name'];?>" />
                            </div>
                            <div class="model"><?=$model['brand']['name'];?> <span><?=$model['name'];?></span></div>
                            <div class="price"><?=(int)$model['price'];?></div>
                        </a>
                    
                    <? endforeach; ?>
                </li>
            </ul>
        </div>
    </div>
</section>
<section class="compare">
    <div class="container">
        <div class="heading">СРАВНЕНИЕ МОДЕЛЕЙ</div>
        <table class="comparison">
            <thead>
                <tr>
                    <td>РЕЖИМ И ФУНКЦИИ</td>
                    <td>
                        <div class="icon"><img src="/images/front/cover-sm.png" alt="" /></div> <span>DB300</span></td>
                    <td>
                        <div class="icon"><img src="/images/front/cover-sm.png" alt="" /></div> <span>DB400</span></td>
                    <td>
                        <div class="icon"><img src="/images/front/cover2.png" alt="" /></div> <span>DB500</span></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Обмыв</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Биде</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Клизма</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Сушка</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Режим "Дети"</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Воздушные пузыри в струе воды</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Водяной насос с повышенной производительностью</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Подогрев сиденья</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Плавное опускание крышки и сиденья</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Пульсация, массаж</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Интеллектуальный и автоматический энергосберегающий режим</td>
                    <td class="check"></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Дезодорация</td>
                    <td></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Мгновенный нагрев воды</td>
                    <td></td>
                    <td class="check"></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Пульт дистанционного управления</td>
                    <td></td>
                    <td></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Сохранение настроек на несколько пользователей</td>
                    <td></td>
                    <td></td>
                    <td class="check"></td>
                </tr>
                <tr>
                    <td>Отключение датчика присутствия *</td>
                    <td class="check"></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
<section class="advantages">
    <div class="container">
        <div class="heading">3 ПРИЧИНЫ <span>ВЫБРАТЬ</span> SATO</div>
        <div class="point one">
            <div class="number">1</div>
            <div class="adv">Низкие цены</div>
            <div class="details">Стоимость нашей продукции ниже, чем у аналогов на рынке</div>
        </div>
        <div class="point two">
            <div class="number">2</div>
            <div class="adv">Высокое качество</div>
            <div class="details">Вся продукция производится в Японии, что обеспечивает высочайшее качество</div>
        </div>
        <div class="point three">
            <div class="number">3</div>
            <div class="adv">Гарантийное обслуживание</div>
            <div class="details">На продукцию предоставляется год гарантии. Мы без проблем заменим бракованный товар</div>
        </div>
    </div>
</section>
<section class="about">
    <div class="container">
        <div class="heading"><?= $about['name']; ?></div>
        <div class="text">
            <?= $about['short']; ?>
            <a href="/page/about" class="more"><span>еще о бренде</span> &darr;</a>
        </div>
        <a href="#" class="up">Наверх</a>
    </div>
</section>