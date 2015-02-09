<div class="view container">
    <div class="contain">
        <h1><?= $view['name']; ?></h1>
        <div class="text">
            <div class="date"><?= $view['date']; ?></div>
            <? if ($view['image'] != 'no_image.jpg'): ?>
                <img src="/uploads/<?=$uri;?>/original/<?= $view['image']; ?>" alt="<?= $view['name']; ?>" title="<?= $view['name']; ?>" />
            <? endif; ?>
            <?= $view['content']; ?>
        </div>
        <div class="read-news">
            <h1>Читайте так же</h1>
            <div class="articles">
                <? foreach($last as $entry): ?>
                <div class="article">
                    <a href="" class="img" style="background-image: url(/uploads/<?=$uri;?>/original/<?= $entry['image']; ?>)"></a>
                    <div class="text-data">
                        <a href="/<?=$uri;?>/view/<?= $entry['chpu']; ?>" class="title"><?=$entry['name']; ?></a>
                        <div><?=$entry['short']; ?></div>
                    </div>
                    <div class="clear"></div>
                </div>
                <? endforeach; ?>
            </div>
        </div>
    </div>
</div>
