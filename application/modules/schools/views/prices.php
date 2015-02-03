<div class="container prices <?=$class;?>">
    <h1>СТОИМОСТЬ ОБУЧЕНИЯ</h1>
    <div class="desc">Стоимость месяца занятий <b>(18 ак. часов)</b> при оплате за:</div>
    <? foreach($prices as $key => $price): ?>
        <div class="row <? if($key % 2 == 1):?>highlight<? endif;?>">
            <div class="period"><?=$price['period'];?></div>
            <div class="cost"><span class="red"><?=$price['price'];?> <span class="ru">Р</span></span> <span class="percent"><? if($price['discount'] > 0): ?>-<?=$price['discount'];?>%<? endif; ?></span></div>
        </div>
    <? endforeach; ?>
</div>