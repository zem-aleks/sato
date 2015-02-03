<div class="block2-in1">
    <div class="container">
        <div class="head">ФОТОГАЛЕРЕЯ</div>
    </div>
</div>
<div class="block3-portf works">
    <div class="container">
        <? foreach ($entries as $entry): ?>
        <div class="element">
            <div class="img"><a href="/portfolio/view/<?= $entry['chpu']; ?>"><span class="plus-img"><span></span></span><div class="bg" style="background-image: url(/uploads/<?= $upload_folder; ?>/thumb/<?= $entry['image']; ?>);"></div></a></div>
            <a href="/portfolio/view/<?= $entry['chpu']; ?>" class="text"><?= $entry['name']; ?></a>
        </div>
        <? endforeach; ?>
        <div class="cln"></div>
    </div>
</div>  