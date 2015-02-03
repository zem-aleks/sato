<div class="block2-in1">
    <div class="container">
        <div class="head">НОВОСТИ И АКЦИИ</div>
    </div>
</div>
<div class="publish">
    <div class="container">
        <? foreach ($articles as $article): ?>
        <div class="element">
            <div class="name-p"><a href="/news/view/<?= $article['chpu']; ?>"><?= $article['name']; ?></a></div>
            <div class="img"><img src="/uploads/articles/thumb/<?= $article['image']; ?>" alt="" ></div>
            <div class="text-p"><?= $article['short']; ?></div>
        </div>
        <? endforeach; ?>
        <div class="cln"></div>
        <div class="block-list">
            <div class="element-list left-element">
                <? $count = count($all); $one = (int)($count / 3); $first = $one + ($count % 3 > 0)? 1 : 0; ?>
                <? for($k = 0; $k <  $first; ++$k): ?>
                    <a href="/news/view/<?=$all[$k+2]['chpu'];?>"><?=$all[$k+2]['name'];?></a>
                <? endfor; ?>
            </div>
            <div class="element-list center-element">
                <? for(; $k < $one + $first + ($count % 3 > 0)? 1 : 0  ; ++$k): ?>
                    <a href="/news/view/<?=$all[$k+2]['chpu'];?>"><?=$all[$k+2]['name'];?></a>
                <? endfor; ?>
            </div>
            <div class="element-list right-element">
                <? for(; $k < $count ; ++$k): ?>
                    <a href="/news/view/<?=$all[$k+2]['chpu'];?>"><?=$all[$k+2]['name'];?></a>
                <? endfor; ?>
            </div>
        </div>
        <div class="cln"></div>
    </div>
</div>