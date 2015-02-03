<?php $i = 0;?>
<ul>
	<?php if($modules): foreach($modules as $module): $i++?>
		<li>
			<a href="<?=base_url().'dashboard/'.$module['machine_name']?>" ><?=$module['name']?></a>
		</li>
	<?php endforeach; else:?>
	<?php endif;?>
</ul>