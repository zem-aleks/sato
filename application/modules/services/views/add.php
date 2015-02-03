<?= show_editor('#content') ?>
<div class="title"><?= $title; ?></div>
<?= form_open_multipart($form_action, array('name' => 'editform')); ?> 

<label for="name">Название:</label><br />
<input id="name" name="name" maxlength="255" type="text" value="<?= set_value('name', $page['name']) ?>" />

<label for="type">Категория:
<?=form_dropdown('category', $service_categories,  $page['category']);?>
</label><br /><br />

Содержание:<br />
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
