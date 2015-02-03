<div class="container">
    <div class="all-schools">ВСЕ ШКОЛЫ НА КАРТЕ</div>
    <div style="display: none;" class="for-map rshadow">
        <div class="metro">
            <div class="trans"></div>
            <? foreach($entries as $entry): ?>
                <? if($entry['metro_position'] && count($entry['metro_position']) >= 2): ?>
                    <i class="pin fa fa-map-marker" style="
                       top: <?=$entry['metro_position'][0];?>;
                       left: <?=$entry['metro_position'][1];?>;
                       color: <?=$entry['color'];?>;">
                        <div class="tooltip">
                                <div class="metro-icon" style="background-color: <?=$entry['color'];?>"></div>
                                <a href="/<?=$uri;?>/view/<?=$entry['chpu'];?>"><?=$entry['name'];?></a>
                                <div class="address"><?=$entry['address'];?></div>
                                <div class="phone"><?=$entry['phone'];?></div>
                                <div class="email"><?=$entry['email'];?></div>
                        </div>
                    </i>
                <? endif; ?>
            <? endforeach; ?>
        </div>
    </div>
    <div class="metro-list">
        <? foreach($entries as $entry): ?>
        <div class="school">
            <a class="preview" href="/<?=$uri;?>/view/<?=$entry['chpu'];?>" style="background-image: url('/uploads/<?=$upload_folder;?>/<?=$entry['image'];?>');" title="<?=$entry['name'];?>"></a>
            <div class="name">
                <div class="metro-icon" style="background-color: <?=$entry['color'];?>"></div>
                <a href="/<?=$uri;?>/view/<?=$entry['chpu'];?>"><?=$entry['name'];?></a>
                <div class="address"><?=$entry['address'];?></div>
            </div>
            <div class="contact">
                <?=$entry['phone'];?>
                <div class="email"><?=$entry['email'];?></div>
            </div>
            <div class="clear"></div>
        </div>
        <? endforeach; ?>
        <div class="pagination"><?=$paginator; ?></div>
    </div>
    <div class="sidebar">
        <?=$user_form;?>
        <?=$articles;?>
        <?=$news;?>
    </div>
    <div class="clear"></div>
</div>