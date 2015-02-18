<section class="catalog-info product-view container">
    <div class="gallery">
        <h1><span><?= $product['brand']['name']; ?></span> <?= $product['name']; ?></h1>
        <div class="gallery-slider">
            <ul class="slides">
                <? foreach ($product['images'] as $image): ?>
                    <li class="pic">
                        <a class="gallery-item" href="/uploads/products/original/<?= $image['image']; ?>" rel="group1" >
                            <img src="/uploads/products/original/<?= $image['image']; ?>" alt="" />
                        </a>
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
        <div class="price"><?= $product['price']; ?> <span class="rub-1">Р</span></div>
        <? if(!empty($product['sizes']) && !empty($product['sizes'][0])): ?>
        <div class="select-size">
            <label for="product-size">Выберите размер:</label>
            <select id="product-size">
                <? foreach($product['sizes'] as $size): ?>
                <option><?=$size; ?></option>
                <? endforeach ;?>
            </select>
        </div>
        <? endif;?>
        <div class="button product-buy" data-id="<?= $product['ID']; ?>">КУПИТЬ</div>
    </div>
    <div class="clear"></div>
</section>
<section class="tech-info container">
    <h2 class="arrow_box">Тех. характеристики</h2>
    <?= $product['content']; ?>
    <!--<div class="addition">
        <div class="files">
            Файлы для скачивания
            <a href="">Инструкция DB300</a>
        </div>
        <div class="sertificates">
            Товар получил сертификаты<br>
            <img src="/images/front/serts.jpg" alt="Товар получил сертификаты" />
        </div>
        <div class="clear"></div>
    </div>-->
</section>
