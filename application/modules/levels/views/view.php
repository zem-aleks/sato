<div class="details-content container rshadow level-view">
    <div class="stats">
        <div class="name">УРОВЕНЬ <?= $level['name']; ?></div>
        Срок обучения: <b><?= $level['term']; ?> академ. часа</b>
        Словарный запас: <b><?= $level['words']; ?> слов</b><br />
        <a href="/page/register?level=<?=$level['ID'];?>" class="button blue">ЗАПИСАТЬСЯ</a>
    </div>
    <div class="desc"><?= $level['content']; ?></div>
    <div class="clear"></div>
</div>

<?=$prices;?>
<?=$wide_user_form;?>
