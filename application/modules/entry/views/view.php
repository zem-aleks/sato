<div class="one-page container">
    <div class="date"><?=$single['date'];?></div>
    <h1><?=$single['name'];?></h1>
    <? if($single['image'] != 'no_image.jpg'): ?>
        <img src="/uploads/articles/<?=$single['image']; ?>" alt="<?=$single['name'];?>" title="<?=$single['name'];?>" />
    <? endif;?>
    <div class="content"><?=$single['content'];?></div>
    
    <div class="read-news container">
        <div class="title">Читайте так же</div>
        <div class="articles">
            <? foreach($last_articles as $article): ?>
                <div class="article">
                    <a class="img" href="/articles/single/<?=$article['chpu']; ?>" style="background-image: url('/uploads/articles/<?=$article['image']; ?>')"></a>
                    <div class="text-data">
                        <a href="/articles/single/<?=$article['chpu']; ?>" class="title"><?=$article['name']; ?></a>
                        <div class="short-text"><?=$article['short']; ?></div>
                    </div>
                    <div class="clear"></div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>