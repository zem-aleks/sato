<?= show_editor('#content') ?>
<?= show_editor('#short') ?>
<?= show_editor('#slider_desc') ?>

<div class="title"><?= $title; ?></div>
<?= form_open_multipart($form_action, array('name' => 'editform')); ?>

Фотографии (оптимальный размер 750x750):<br/>
<div class="admin-images">
    <? foreach ($page['images'] as $image): ?>
        <div class="for-image">
            <img src="/uploads/<?=$uri;?>/thumb/<?= $image['image']; ?>" alt="" title=""/><br/>
            <input type="checkbox" name="delImage[<?= $image['ID']; ?>]"/> удалить?
        </div>
    <? endforeach; ?>
    <div class="clear"></div>
</div>
<div class="item-photo">
    <input class="for-copy" type="file" name="images" value=""/>
</div>
<div class="add-photo">Добавить</div>


<label for="name">Модель:</label><br />
<input id="name" name="name" maxlength="255" type="text" value="<?= set_value('name', $page['name']) ?>" />

<label for="price">Цена (разделение через точку):</label><br />
<input id="price" name="price" value="<?= $page['price']; ?>" maxlength="12" type="text"/>

Категория товара:<br />
<?= form_select('id_category', 'ID', 'name', $categories, $page['id_category']); ?>

<br /><br />Бренд:<br />
<?= form_select('id_brand', 'ID', 'name', $brands, $page['id_brand']); ?>

<br /><br />Размеры (каждый размер с новой строчки):
<textarea rows="5" name="sizes"><?= set_value('sizes', $page['sizes']) ?></textarea>

<br /><br />
<label>
    <input name="on_main" type="checkbox" <? if($page['on_main']):?>checked="checked"<? endif;?>/>
    Показывать модель главной странице в моделях?
</label>
<br /><br />
<label>
    <input name="on_slider" type="checkbox" <? if($page['on_slider']):?>checked="checked"<? endif;?>/>
    Добавить модель в слайдер на главной странице?
</label>
<br /><br />

Краткое описание товара на слайдере:<br />
<textarea id="slider_desc" rows="5" name="slider_desc"><?= set_value('slider_desc', $page['slider_desc']) ?></textarea><br /><br />

Краткое описание товара (описание с правой стороны):<br />
<textarea id="short" rows="5" name="short"><?= set_value('short', $page['short']) ?></textarea><br /><br />

Детальное описание товара (таблица с техническими характеристиками и т.д.):<br />
<textarea id="content" name="content"><?= set_value('content', $page['content']) ?></textarea><br /><br />

ЧПУ (Если оставить пустым,то по названию построится автоматически.)<br />
<input type="text" size="80" name="chpu" value="<?= set_value('chpu', $page['chpu']) ?>" />

Title:&nbsp;&nbsp;&nbsp;<br />
<input type="text" name="title" value="<?= set_value('title', $page['title']) ?>"/>

Description:&nbsp;&nbsp;&nbsp;<br />
<textarea name="mdesc" rows="4" cols="80"><?= set_value('mdesc', $page['mdesc']) ?></textarea>

Key-words:&nbsp;&nbsp;&nbsp;&nbsp;<br />
<textarea name="mkeys" rows="4" cols="80"><?= set_value('mkeys', $page['mkeys']) ?></textarea>
<br /><br />
<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= anchor('dashboard/' . $uri, 'Отменить', array('class' => "save")); ?>
