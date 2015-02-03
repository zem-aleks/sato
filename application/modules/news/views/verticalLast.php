<div class="<?=$class;?>">
    <div class="title">Новости</div>
    <div class="news">
        <? foreach ($last_articles as $article): ?>
            <div class="article">
                <a href="/news/view/<?=$article['chpu'];?>" class="short-text"><?=$article['name'];?></a>
                <div class="date"><?=$article['date'];?></div>
            </div>
        <? endforeach; ?>
    </div>
    <a class="more" href="/news">архив новостей</a>
</div>