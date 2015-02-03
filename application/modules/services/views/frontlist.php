<div class="block2-in1">
    <div class="container">
        <div class="head">УСЛУГИ</div>
    </div>
</div>
<div class="block3-u">
    <div class="container">
        <?=$page_info['content'];?>
        <div class="element">
            <div class="img"><?=$service_categories[0]['name']; ?></div>
        </div>
        <div class="element">
            <div class="img"><?=$service_categories[1]['name']; ?></div>
        </div>
        <div class="element">
            <div class="img"><?=$service_categories[2]['name']; ?></div>
        </div>            
        <div class="element center-element">
            <? foreach ($services as $service): ?>
                <? if($service['category'] == 0) : ?>
                    <a href="/services/view/<?=$service['chpu']; ?>"><?=$service['name']; ?></a>
                <? endif; ?>
            <? endforeach; ?>
        </div>
        <div class="element center-element">
            <? foreach ($services as $service): ?>
                <? if($service['category'] == 1) : ?>
                    <a href="/services/view/<?=$service['chpu']; ?>"><?=$service['name']; ?></a>
                <? endif; ?>
            <? endforeach; ?>
        </div>
        <div class="element center-element">
            <? foreach ($services as $service): ?>
                <? if($service['category'] == 2) : ?>
                    <a href="/services/view/<?=$service['chpu']; ?>"><?=$service['name']; ?></a>
                <? endif; ?>
            <? endforeach; ?>
        </div>
        <div class="cln"></div>
    </div>
</div>  