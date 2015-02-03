<div class="title"><?=$title;?></div>

<div class="dictionaries">
    <? foreach ($types as $key => $dictionary):?>
    <div data-type="<?=$key;?>" class="container <?=$key;?>">
        <div class="name"><?=$dictionary['name'];?></div>
        <div class="complete">
            <? foreach ($dictionary['dictionary'] as $value):?>
                <div data-id="<?=$value['ID'];?>" class="dict-item" <? if($key == 'color'): ?>style="background-color: <?=$value['content'];?>"<? endif;?>>
                    <span class="dname"><?=$value['name'];?></span><? if(!empty($value['content'])):?> - <span class="description"><?=$value['content'];?></span> <? endif;?>
                </div>
            <? endforeach;?>
            <div class="clear"></div>
        </div>
        <div data-id="" class="form-add">
            <span>Добавить:</span>
            <input type="text" name="name" placeholder="Название"/>
            <textarea name="content" placeholder="<?=$dictionary['placeholder'];?>"></textarea>
            <div class="save add-dict-item">Добавить</div>
        </div>
    </div>
    <? endforeach; ?>
</div>