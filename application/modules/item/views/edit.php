<div class="title"><?= $title; ?></div>

<div class="break"></div>

<div class="product">
    <?= form_open_multipart('dashboard/item/edit/' . $item['ID'], array('name' => 'editform', 'class' => 'js-form')); ?> 

    Фотографии (900х900):<br/>
    
    <i>Выберите тип водянного знака для заружаемых фотографий (если нужен и светлый и темный фон,
    то сначала загрузите фотографии с одним фоном, а потом при редактировании 
    товара загрузите фотографии с другим фоном)</i><br/>
    <input type="radio" id="w_white" value="white" name="watermark" checked="checked"/>
    <label for="w_white">Светлый фон картинки</label><br/>
    <input type="radio" id="w_black" value="black" name="watermark"/>
    <label for="w_black">Темный фон картинки</label>
    <div class="admin-images">
        <? foreach ($item['images'] as $image): ?>
        <div class="for-image">
            <img src="/uploads/items/thumb/<?=$image['image'];?>" alt="" title=""/><br/>
            <input type="checkbox" name="delImage[<?=$image['ID'];?>]"/> удалить?
        </div>
        <? endforeach; ?>
        <div class="clear"></div>
    </div>
    <div class="item-photo">
        <input class="for-copy" type="file" name="images" value=""/>
    </div>
    <div class="add-photo">Добавить</div>
    
    <div class="break"></div>
    
    Название:<br/>
    <input id="name" name="name" value="<?=$item['name'];?>" maxlength="255" type="text"/>	


    <fieldset class="two">
        Цена (разделение через точку):<br/>
        <input id="price" name="price" value="<?=$item['price'];?>" maxlength="12" type="text"/>
    </fieldset>
    <fieldset class="two">
        Старая цена\цена со скидкой:<br/>
        <input id="old_price" name="old_price" value="<?=$item['old_price'];?>" maxlength="12" type="text"/>
    </fieldset>
    <div class="clear"></div>

    Прикрепить к каталогу:<br/>
    <? foreach($categories as $top => $values): ?>
    <div class="acc-cat">
        <i><?=$top; ?>:</i> <br/>
        <? foreach($values as $cat):?>
        <input name="cat[<?=$cat['ID'];?>]" type="checkbox" id="cat-<?=$cat['ID'];?>" <? if(in_array($cat['ID'], $item['categories'])):?>checked="checked"<? endif;?>/>
            <label for="cat-<?=$cat['ID'];?>"><?=$cat['cat_name'];?></label><br/>
        <? endforeach; ?>
    </div>
    <? endforeach; ?>

    <br/><br/>Содержание:<br/>
    <textarea style="height: 100px;" id="content" name="content"  value=""><?=$item['content'];?></textarea>	
    
    <div class="break"></div>

    Размеры<br/><br/>
    <fieldset>
        <label for="height">Высота:</label>
        <input id="height" name="height" value="<?=$item['height'];?>" maxlength="11" type="text"/>
    </fieldset>
    <fieldset>
        <label for="length">Длина:</label>
        <input id="length" name="length" value="<?=$item['length'];?>" maxlength="11" type="text"/>
    </fieldset>
    <fieldset>
        <label for="width">Ширина:</label>
        <input id="width" name="width" value="<?=$item['width'];?>" maxlength="11" type="text"/>
    </fieldset>
    <fieldset>
        <label for="deepth">Глубина:</label>
        <input id="deepth" name="deepth" value="<?=$item['deepth'];?>" maxlength="11" type="text"/>
    </fieldset>
    <fieldset>
        <label for="thickness">Толщина:</label>
        <input id="thickness" name="thickness" value="<?=$item['thickness'];?>" maxlength="11" type="text"/>
    </fieldset>
    <fieldset>
        <label for="volume">Объем:</label>
        <input id="volume" name="volume" value="<?=$item['volume'];?>" maxlength="11" type="text"/>
    </fieldset>
    <div class="clear"></div>
    
    <div class="break"></div>

    <fieldset>
        Цвет:<br/>
        <?= form_select('id_color', 'ID', 'name', $colors, $item['id_color']); ?>
    </fieldset>
    <fieldset>
        Материал:<br/>
        <?= form_select('id_material', 'ID', 'name', $materials, $item['id_material']); ?>
    </fieldset>
    <fieldset>
        Бренд:<br/>
        <?= form_select('id_brand', 'ID', 'name', $brands, $item['id_brand']); ?>
    </fieldset>
    <div class="clear"></div>
    
    <div class="break"></div>
    
    Добавить категорию аксессуаров:<br/><br/>
    <? foreach($categories as $top => $values): ?>
    <div class="acc-cat">
        <i><?=$top; ?>:</i> <br/>
        <? foreach($values as $cat):?>
        <input name="acc[<?=$cat['ID'];?>]" type="checkbox" id="acc-<?=$cat['ID'];?>" <? if(in_array($cat['ID'], $item['accessories'])):?>checked="checked"<? endif;?>/>
            <label for="acc-<?=$cat['ID'];?>"><?=$cat['cat_name'];?></label><br/>
        <? endforeach; ?>
    </div>
    <? endforeach; ?>
    
    <div class="break"></div>
    
    Добавить сопутствующие товары:<br/><br/>
    
    Начните вводить название товара: <input type="text" value="" id="related-input"/>
    <div class="related-items">
        <input class="remove-all" type="button" value="Очистить"/>
        <? foreach($item['related_items'] as $rel):?>
        <div class="r-item" data-id="<?=(int)$rel['ID'];?>">
            <a href="/dashboard/item/editPage/<?=$rel['ID'];?>" class="label"><?=$rel['name'];?></a>
            <div class="remove"></div>
        </div>
        <? endforeach;?>
    </div>
    <input type="hidden" value="" name="related_value"/>
    
    <div class="break"></div>
    
    ЧПУ (Если оставить пустым,то по названию построится автоматически.):</br>
    <input type="text" name="chpu" value="<?=$item['chpu'];?>" />
    
    Title:</br>
    <input type="text" name="title" value="<?=$item['title'];?>" />
    
    Description:</br>
    <textarea name="mdesc" rows="4" cols="80"><?=$item['mdesc'];?></textarea>
    
    Key-words:</br>
    <textarea name="mkeys" rows="4" cols="80"><?=$item['mkeys'];?></textarea>
    
    <div class="break"></div>
    
    Рейтинг популярности: <br/>
    <input type="text" name="rating" value="<?=$item['rating'];?>"/>
    
    Статус:<br/>
    <?= form_dropdown('is_on_stock', $statuses, $item['is_on_stock']); ?>
    <br/><br/>
    
    <input id="in_process" name="in_process" type="checkbox" <? if($item['status'] == 2):?>checked="checked"<? endif;?>/>
    <label for="in_process">В процессе</label><br/><br/>
    
    <!--
    <input id="is_new" name="is_new" type="checkbox" <? if($item['is_new']):?>checked="checked"<? endif;?>/>
    <label for="is_new">Новинка</label><br/>
    -->
    <input type="submit" value="Сохранить"/>
</form>
</div>

