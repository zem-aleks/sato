<h1 class="title container"><?=$title;?></h1>
<div class="container front-list">
    <? foreach ($entries as $entry): ?>
    <div class="media">
        <a class="pull-left" href="/<?=$uri;?>/view/<?= $entry['chpu']; ?>" style="background-image: url(/uploads/<?=$uri;?>/thumb/<?= $entry['image']; ?>);"></a>
        <div class="media-body">
            <div class="date"><?= $entry['date']; ?></div>
            <a href="/<?= $uri; ?>/view/<?= $entry['chpu']; ?>" class="media-heading"><?= $entry['name']; ?></a>
            <?= $entry['short']; ?>
        </div>
    </div>
    <? endforeach; ?>
    
    <div class="pagination"><?=$paginator; ?></div>
</div>
