<div class="title container"><?=$title;?></div>
<div class="container front-list">
    <? foreach ($entries as $entry): ?>
    <div class="media">
        <a class="pull-left" href="/articles/view/<?= $entry['chpu']; ?>" style="background-image: url(/uploads/articles/thumb/<?= $entry['image']; ?>);"></a>
        <div class="media-body">
            <div class="date"><?= $entry['date']; ?></div>
            <a href="/<?= $uri; ?>/view/<?= $entry['chpu']; ?>" class="media-heading"><?= $entry['name']; ?></a>
            <?= $entry['short']; ?>
        </div>
    </div>
    <? endforeach; ?>
    
    <div class="pagination"><?=$paginator; ?></div>
</div>