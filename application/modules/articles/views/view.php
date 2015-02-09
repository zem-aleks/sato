<div class="view container">
    <div class="contain">
        <h1><?= $view['name']; ?></h1>
        <div class="text">
            <div class="date">21 МАРТА</div>
            <? if ($view['image'] != 'no_image.jpg'): ?>
                <img src="/uploads/articles/original/<?= $view['image']; ?>" alt="<?= $view['name']; ?>" title="<?= $view['name']; ?>" />
            <? endif; ?>
                <h3>Универсальный теплообменник</h3>
            <?= $view['content']; ?>
        </div>
        <div class="read-news">
            <h1>Читайте так же</h1>
            <div class="articles">
                <div class="article">
                    <a href="" class="img"></a>
                    <div class="text-data">
                        <a href="" class="title">Универсальный теплообменник высокой производительности</a>
                        <div>Новый высокомощный теплообменник B633 </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="article">
                    <a href="" class="img"></a>
                    <div class="text-data">
                        <a href="" class="title">Универсальный теплообменник высокой производительности</a>
                        <div>Новый высокомощный теплообменник B633 </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="article">
                    <a href="" class="img"></a>
                    <div class="text-data">
                        <a href="" class="title">Универсальный теплообменник высокой производительности</a>
                        <div>Новый высокомощный теплообменник B633 </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</div>