<?php

class Dashboard extends Controller 
{
	function __construct()
	{
		parent::Controller();
	}
	function index($page = 0){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!$is_logged_in){
			redirect('admin');	
		}
		else{
                    redirect('dashboard/pages');
		}
		
	}
	function members_area()
	{
		modules::run('admin/is_logged_in');
		$this->load->view('logged_in_area');
	}
	
	function messages()
	{
		modules::run('admin/is_logged_in');
		$this->load->model('admin/mdl_admin');
		$user = $this->mdl_admin->get_member_details($this->uri->segment(3));
		if( !$user )
		{
			// No user found
			return false;
		}
		else
		{
			// display our widget
			$this->load->view('member_messages', $user);
		}				
	}
	
	function profile()
	{
		$this->load->model('login/mdl_admin');
		$user = $this->mdl_admin->get_member_details($this->uri->segment(3));
		if( !$user )
		{
			// No user found
			$data['main_content'] = 'member_profile';
			$data['notice'] = 'you need to view a profile id';
			$this->load->view('includes/template', $data);
		}
		else
		{
			// display our widget
			$user['main_content'] = 'member_profile';
			$this->load->view('includes/template', $user);
		}			
		
	}
}
