<div class="container page rshadow">
    <div class="preview" style="background-image: url('/uploads/<?=$upload_folder;?>/<?=$view['image'];?>');" title="<?=$view['name'];?>"></div>
    <div id="school" class="school" data-geo="<?=$view['geo'];?>">
        <div class="name">
            <div class="metro-icon" style="background-color: <?=$view['color'];?>"></div>
            <?=$view['name'];?>
            <div class="address"><?=$view['address'];?></div>
        </div>
        <div class="contact one">
            <?=$view['phone'];?>
            <div class="email"><?=$view['email'];?></div>
        </div>
        <a href="/page/register?school=<?=$view['ID'];?>" class="button blue">ЗАПИСАТЬСЯ</a>
        <div class="clear"></div>

        <div class="description"><?=$view['short'];?></div>
        <? if(strlen($view['content']) - strlen($view['short']) > 0): ?>
            <div class="description full"><?=$view['content'];?></div>
            <a href="javascript: void(0);" class="show-all">полностью</a>
        <? endif; ?>
    </div>
    <div class="clear"></div>
</div>

<div id="map" class="container map"></div>

<?=$prices;?>
<?=$wide_user_form;?>