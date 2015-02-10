<section class="cart container">
    <h1>Корзина</h1>
    <? $sum = 0; ?>
    <? foreach ($cart as $product): ?>
    <? $sum += $product['count'] * $product['original_price']; ?>
    <div class="product" data-id="<?=$product['ID'];?>" data-price="<?=$product['original_price']; ?>">
        <div class="item">
            <a href="/products/view/<?=$product['chpu'];?>">
                <div class="pic">
                    <img src="/uploads/products/thumb/<?=$product['image'];?>" alt="<?=$product['name'];?>" />
                </div>
                <div class="model">
                    <span><?=$product['brand']['name'];?></span>
                    <span><?=$product['name'];?></span>
                </div>
            </a>
        </div>
        <div class="quantity">
            <div>Количество:</div>
            <input type="number" class="number" value="<?=$product['count'];?>"/>
            <div class="price"><?=$product['price'];?> Р</div>
        </div>
        <a href="javascript:void(0);" class="close product-remove">х</a>
    </div>
    <? endforeach; ?>
    
    <div class="total">Общая сумма: <span class="price"><span class="cart-sum"><?=number_format((int)$sum, 0, ',', ' ');?></span> Р</span></div>
</section>
<section class="form-order container">
    <h1>Форма заказа</h1>
    <div class="enter-data">
        <input type="text" name="" placeholder="Имя" class="text"/>
        <input type="text" name="" placeholder="E-mail" class="text"/>
        <input type="text" name="" placeholder="Адрес*" class="text"/>
        <input type="text" name="" placeholder="Телефон*" class="text"/>
        <input type="text" name="" placeholder="Курьерская доставка г.Моска" class="text address"/>
        <input type="text" name="" placeholder="Наличными курьеру" class="text address"/>
        <textarea name="" placeholder="Комментарий к заказу" class="text"></textarea>
        <input type="submit" value="Оформить заказ" class="button"/>
    </div>
    <div class="details">
        <?=$about['content']; ?>
        <!--<p><b>Мы готовы отправить Ваш заказ, любым удобным для Вас способом.</b></p>
        <p>При заказе до 500 грн доставка по Киеву (до  парадного) составляет 50 грн (малогабаритное и весом до 2кг - 30грн), от 501 до 1000 грн - 30грн</p>
        <p><b>При заказе свыше 1000 грн доставка осуществляется БЕСПЛАТНО.</b></p>
        <p>Доставка товара за пределы Киева (область) : 5грн/км (считается в одну сторону), но не менее 100грн.</p>
        <p><b>Доставка сантехники осуществляется в удобное для Вас время и в согласованные сроки.</b></p>
        <p>Доставка по Украине осуществляется удобным для Вас перевозчиком, который может привезти как на склад в Вашем городе, так и по Вашему адресу (например, Вам домой или в офис) или предложите Ваш вариант.</p>-->
    </div>
    <div class="clear"></div>
</section>