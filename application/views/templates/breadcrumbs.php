<div class="breadcrumbs">
    <a href="/">На главную</a>
    <? foreach($breadcrumbs as $value):?>
    / <a href="<?=$value['url'];?>"><?=$value['name'];?></a>
    <? endforeach;?>
</div>