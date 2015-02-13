<div class="item">
    <a href="/products/view/<?= $product['chpu']; ?>">
        <div class="pic">
            <img src="/uploads/products/thumb/<?= $product['image']; ?>" alt="<?= $product['name']; ?>" />
        </div>
        <div class="model"><span><?= $product['brand']['name']; ?></span> <?= $product['name']; ?></div>
        <div class="price"><?= $product['price']; ?> <span class="rub rub-2">P</span></div>
    </a>
    <a href="/products/view/<?= $product['chpu']; ?>" class="details">Подробнее о модели</a>
</div>
