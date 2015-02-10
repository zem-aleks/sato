<div class="item">
    <a href="/products/view/<?= $product['chpu']; ?>">
        <div class="pic">
            <img src="/uploads/products/thumb/<?= $product['image']; ?>" alt="<?= $product['name']; ?>" />
        </div>
        <div class="model"><span style="text-transform: uppercase;font-family: 'Roboto Bold';"><?= $product['brand']['name']; ?></span> <span><?= $product['name']; ?></span></div>
        <div class="price"><?= (int) $product['price']; ?></div>
    </a>
    <a href="/products/view/<?= $product['chpu']; ?>" class="details">Подробнее о модели</a>
</div>