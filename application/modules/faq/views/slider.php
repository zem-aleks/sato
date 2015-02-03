<div class="faq">
    <div class="pattern big"></div>
    <div class="title">Вопрос-ответ</div>
    <div class="flexslider slider container">
        <ul class="slides">
            <? foreach ($entries as $key => $entry): ?>
            <? if($key % 3 == 0): ?><li><? endif; ?>
            <a href="/faq/view/<?=$entry['chpu'];?>" class="column3">
                <div class="question"><?=$entry['name'];?></div>
                <div class="answer"><?=$entry['answer'];?></div>
            </a>
            <? if(($key+1) % 3 == 0): ?></li><? endif; ?>
            <? endforeach; ?>
        </ul>
    </div>
</div>