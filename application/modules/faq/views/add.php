<?= show_editor('#content') ?>
<div class="title"><?= $title; ?></div>
<?= form_open_multipart($form_action, array('name' => 'editform')); ?> 
<label for="name">Введите вопрос:</label><br />
<textarea id="name" name="name" rows="4" cols="80"><?= set_value('name', $page['name']) ?></textarea><br /><br />

<label for="answer">Введите ответ:</label><br />
<textarea id="answer" name="answer" rows="4" cols="80"><?= set_value('answer', $page['answer']) ?></textarea><br /><br />

<a href="javascript:void(0)"  class="save" onclick="document.editform.submit()">Сохранить</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= anchor('dashboard/' . $uri, 'Отменить', array('class' => "save")); ?>

