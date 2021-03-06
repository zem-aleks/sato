<section class="catalog container"  data-id="<?=$current['category'];?>" data-sort="<?=$current['order'];?>">
    <h1>КАТАЛОГ</h1>
    <a href="/catalog/<?=$current['category'];?>/<?=$current['order'] == 'asc'? 'desc' : 'asc' ;?>" class="sort <?=$current['order'];?>">Сортировка: <span>По ценам</span></a>
    <aside>
        <ul>
            <li><a href="/catalog" style="border-bottom: none;"><h2>Продукция</h2></a></li>
            <? foreach ($categories as $category): ?>
            <li><a href="/catalog/<?=$category['ID'];?>/<?=$current['order'];?>" <? if($current['category'] == $category['ID']): ?>class="active"<? endif;?>><?=$category['name'];?></a></li>
            <? endforeach; ?>
        </ul>
    </aside>
    <div class="products">
        <? foreach ($products as $product): ?>
            <? $this->load->view('templates/item', array('product' => $product)) ?>
            
        <? endforeach;?>
    </div>
    <div class="clear"></div>
    <? if(count($products) == 6): ?>
    <div class="contain"><a href="" class="view-more">Еще ассортимент</a></div>
    <div class="clear"></div>
    <? endif; ?>
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
            <div class="details">Вся продукция производится в Корее, что обеспечивает высочайшее качество</div>
        </div>
        <div class="point three">
            <div class="number">3</div>
            <div class="adv">Гарантийное обслуживание</div>
            <div class="details">На продукцию предоставляется расширенная гарантия 5 лет</div>
        </div>
    </div>
</section>
<section class="about">
    <div class="container">
        <div class="heading"><?=$about['name'];?></div>
        <div class="text">
            <?=$about['short'];?>
            <a href="/page/about" class="more"><span>еще о бренде</span> &darr;</a>
        </div>
        <a href="#" class="up">Наверх</a>
    </div>
</section>
