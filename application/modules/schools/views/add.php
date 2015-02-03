<?= show_editor('#content') ?>
<div class="title"><?= $title; ?></div>
<?= form_open_multipart($form_action, array('name' => 'editform')); ?> 
<label for="photo">Фото (140x140):</label><br />
<? if (!empty($page['image']) && $page['image'] != 'no_image.jpg'): ?>
    <img src="/uploads/<?= $upload_folder; ?>/<?= $page['image']; ?>" style='max-height:150px;'/><br/>
    <input id="photo" type="checkbox" name="del" />Удалить
    <input type="hidden" name="image" value="<?= $page['image']; ?>" />
<? else: ?>
    <input id="photo" type="file" name="userfile" size="20" /> 
<? endif; ?>	
<br />

<label for="name">Название:</label><br />
<input id="name" name="name" maxlength="255" type="text" value="<?= set_value('name', $page['name']) ?>" />

<input id="is_new" name="is_new" maxlength="255" type="checkbox" <? if($page['is_new']): ?>checked="checked"<?endif;?> />
<label for="is_new">Новая школа</label><br /><br />

<label for="color">Цвет:</label><br />
<div class="colors">
    <? foreach($colors as $color): ?>
        <div class="one-color" data-color="<?=$color;?>" style="background-color: <?=$color;?>"></div>
    <? endforeach; ?>
</div>
<input id="color" type="text" name="color" value="<?= set_value('color', $page['color']) ?>" />
<input id="metro_position" type="hidden" name="metro_position" value="<?= set_value('metro_position', $page['metro_position']) ?>" />
Поставте точку на карте где находится школа:
<div class="metro">
    <i class="pin fa fa-map-marker"></i>
</div>

<label for="email">Email школы:</label><br />
<input id="email" name="email" maxlength="50" type="text" value="<?= set_value('email', $page['email']) ?>" />

<label for="phone">Телефон школы:</label><br />
<input id="phone" name="phone" maxlength="50" type="text" value="<?= set_value('phone', $page['phone']) ?>" />

<label for="address">Адрес в Москве:</label><br />
<input id="address" name="address" maxlength="255" type="text" value="<?= set_value('address', $page['address']) ?>" />
<input type="text" readonly="readonly" placeholder="координаты школы" id="geo" name="geo" value="<?= set_value('geo', $page['geo']) ?>" />
<input type="hidden" readonly="readonly" placeholder="координаты метро" id="metro" name="metro" value="<?= set_value('metro', $page['metro']) ?>" />
<div id="map" style="width: 100%; height: 300px;"></div>

<br />
<label for="discount">Общая скидка школы в процентах (указывается на главной странице):</label><br />
<input id="discount" name="discount" maxlength="255" type="text" value="<?= set_value('discount', $page['discount']) ?>" />

<div class="prices container for-level general">
    <h1>СТОИМОСТЬ ОБУЧЕНИЯ</h1>
    <div class="desc">Стоимость месяца занятий <b>(18 ак. часов)</b> при оплате за:</div>
        <? foreach($prices as $key => $price): ?>
            <div class="row <? if($key % 2 == 1):?>highlight<? endif; ?>">
                <input type="hidden" value="<?=($key + 1);?>" name="prices[<?=($key + 1);?>][ID]" />
                <input type="hidden" value="<?=$price['period'];?>" name="prices[<?=($key + 1);?>][period]" />
                <div class="period"><?=$price['period'];?></div>
                <div class="cost">
                    <span class="red">
                        <input type="text" name="prices[<?=($key + 1);?>][price]" value="<?=$price['price'];?>" placeholder="Цена"/> 
                        <span class="ru">Р</span>
                    </span> 
                    -<input type="text" name="prices[<?=($key + 1);?>][discount]" value="<?=$price['discount'];?>" placeholder="Скидка">%
                </div>
            </div>
        <? endforeach; ?>
</div><br />

Содержание:<br />
<textarea id="content" name="content"><?= set_value('content', $page['content']) ?></textarea>		

<br /><br />ЧПУ (Если оставить пустым,то по названию построится автоматически.)<br />
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

<style>
    .prices .title {
    text-align: left;
    margin-bottom: 6px;
}
.prices {
    padding-top: 40px;
}
.prices .desc {
    font-size: 14px;
    margin-bottom: 28px;
}
.prices .row {
    font-size: 24px;
    height: 24px;
    padding: 10px 0 10px;
    margin-bottom: 4px;
}
.prices .row > div {
    display: inline-block;
    vertical-align: top;
}
.prices .row .period {
    padding-left: 26px;
    width: 60%;
}
.prices .row.highlight {
    background-color: #eef5f7;
}
.prices .cost .ru:after {
    height: 2px;
    top: 18px;
    width: 14px;
}
.prices input[type="text"] {
width: 60px;
display: inline-block;
margin: 0px 10px;
padding: 0px 4px;
}
</style>