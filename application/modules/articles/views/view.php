<div class="block2-in1">
    <div class="container">
        <div class="head"><?= $view['name']; ?></div>
    </div>
</div>
<div class="block3-in1">
    <div class="container">
        <div class="text">
            <? if ($view['image'] != 'no_image.jpg'): ?>
                <img src="/uploads/articles/original/<?= $view['image']; ?>" alt="<?= $view['name']; ?>" title="<?= $view['name']; ?>" />
            <? endif; ?>
            <?= $view['content']; ?>
        </div>
    </div>
</div>  