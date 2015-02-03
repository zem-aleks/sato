
	<?php echo $this->lang->line('welcome').", ".$first_name.' '.$last_name." ".$this->lang->line('in_admin_panel'); ?> &middot; 
	<?php /*echo anchor('dashboard/pages', 'Dashboard');*/?> 
	<?php /*echo anchor('dashboard/profile/'.$id, 'Profile'); */?> 
	<?php echo anchor('admin/logout', $this->lang->line('logout') ); ?>
