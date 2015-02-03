<div class="container all-courses">
    <h1>УРОВНИ ПОДГОТОВКИ</h1>
    <div class="metro-list levels-list">
        <? foreach($levels as $key => $level): ?>
        <div class="level num-<?=$key;?>">
            <div class="level-name"><?=$level['name']; ?></div>
            <div class="level-desc">Срок обучения: <b><?=$level['term']; ?> академ. часа</b> / Словарный запас: <b><?=$level['words']; ?> слов</b></div>
            <span class="blue">&rarr;</span> <a class="more" href="/levels/view/<?=$level['chpu']; ?>">подробнее об уровне</a>
        </div>
        <? endforeach; ?>
    </div>
    <div class="sidebar">
        <?=$user_form; ?>
        <?=$articles;?>
    </div>
    <div class="clear"></div>
</div>