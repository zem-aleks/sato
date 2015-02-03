<div class="<?=$class;?>">
    <div class="title">Публикации</div>
    <div class="articles">
        <? foreach ($last_articles as $article): ?>
            <div class="article">
                <a href="/articles/view/<?= $article['chpu']; ?>" class="img" style="background-image: url('/uploads/articles/thumb/<?= $article['image']; ?>')" title="<?= $article['name']; ?>"></a>
                <div class="text-data">
                    <a href="/articles/view/<?= $article['chpu']; ?>" class="title"><?= $article['name']; ?></a>
                    <div class="short-text"><?= $article['short']; ?></div>
                </div>
                <div class="clear"></div>
            </div>
        <? endforeach; ?>
    </div>
    <a class="more" href="/articles">все публикации</a>
</div>