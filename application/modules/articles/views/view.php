<div class="view container">
    <div class="contain">
        <h1><?= $view['name']; ?></h1>
        <div class="text">
            <div class="date">21 МАРТА</div>
            <? if ($view['image'] != 'no_image.jpg'): ?>
                <img src="/uploads/articles/original/<?= $view['image']; ?>" alt="<?= $view['name']; ?>" title="<?= $view['name']; ?>" />
            <? endif; ?>
                <h3>Универсальный теплообменник высокой производительности</h3>
            <?= $view['content']; ?>
        </div>
    </div>
</div>