<div class="block2-in1">
    <div class="container">
        <div class="head"><?=$view['name'];?></div>
    </div>
</div>
<div class="block3-in1">
    <div class="container">
        <?=$view['content'];?>
        
        <div class="element left-element">
            <? for($k = 0; $k < 2; ++$k): ?>
                <a href="/services/view/<?=$services[$k]['chpu'];?>"><?=$services[$k]['name'];?></a>
            <? endfor; ?>
        </div>
        <div class="element center-element">
            <? for(; $k < 4; ++$k): ?>
                <a href="/services/view/<?=$services[$k]['chpu'];?>"><?=$services[$k]['name'];?></a>
            <? endfor; ?>
        </div>
        <div class="element right-element">
            <? for(; $k < 6; ++$k): ?>
                <a href="/services/view/<?=$services[$k]['chpu'];?>"><?=$services[$k]['name'];?></a>
            <? endfor; ?>
        </div>
        <div class="cln"></div>
    </div>
</div>  