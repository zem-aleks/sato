<div class="view container">
    <div class="contain">
        <h1><?= $view['name']; ?></h1>
        <div class="text">
            <div class="date"><?= $view['date']; ?></div>
            <? if ($view['image'] != 'no_image.jpg'): ?>
                <img src="/uploads/<?= $uri; ?>/original/<?= $view['image']; ?>" alt="<?= $view['name']; ?>" title="<?= $view['name']; ?>" />
            <? endif; ?>
            <?= $view['content']; ?>
        </div>
    </div>
</div>