<div class="container one-page">
    <h1>Публикации</h1>
    <div class="content articles">
        <table>
            <? foreach ($articles as $article): ?>
                <tr class="article wide">
                    <td class="thumb">
                        <a href="/articles/single/<?= $article['chpu']; ?>" class="img" style="background-image: url('/images/front/<?= $article['image']; ?>')" title="<?= $article['name']; ?>"></a>
                    </td>
                    <td class="desc">
                        <div class="text-data">
                            <a href="/articles/single/<?= $article['chpu']; ?>" class="title"><?= $article['name']; ?></a>
                            <div class="short-text"><?= $article['short']; ?></div>
                        </div>
                    </td>
                <? endforeach; ?>
        </table>
    </div>
    
    <div class="pagination"><?=$paginator; ?></div>
</div>