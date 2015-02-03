<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Module extends Controller {

	public $name = 'module';
	public $md = 'mdl_module';

	function Module(){
		parent::__construct();
		$this->load->model($this->md);
	}

	
	/*-----------------------admin function---------------------*/
	function admin_index($page = 0){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!$is_logged_in){
			redirect('admin');	
		}
		else{
			$content = array();
			$content['title'] = 'Модули';
			$content['key'] = 0;		
			$content['pages'] = $this->mdl_module->getModulesAdmin();
			$this->load->view('includes/admin_header',$content);	
			$this->load->view('list',$content);	
			$this->load->view('includes/admin_footer',$content);	
		}
		
	}	
	function addModule(){
		$content = array();
		$content['title'] = 'Модули';
		
		$this->load->view('includes/admin_header',$content);	
		$this->load->view('add',$content);	
		$this->load->view('includes/admin_footer',$content);	
	}
	
	function editModule($id_page){
		$content['title'] = 'Редактирование модуля';
		$content['page_info'] = $this->mdl_pages->getModuleInfo($id_page);
		
		$this->load->view('includes/admin_header',$content);	
		$this->load->view('edit',$content);	
		$this->load->view('includes/admin_footer',$content);	
	}
	
	function add(){
		$this->mdl_pages->add();
		redirect('dashboard/module');
	}
	
	function edit($id_page){
		if($this->mdl_pages->edit($id_page))
		{
			redirect('dashboard/module/'.$id_page);
		}

	}
	function del($id){	 
		$this->{$this->md}->del($id);
		redirect('dashboard/module/');
	}
	
	function status($id_cat, $status){
		if($this->{$this->md}->status($id_cat, $status)){
			redirect('dashboard/module');
		}
		else {
			echo "no";
		}
	}
 
	
	function left_menu(){
		$content = array();	
		$content['modules'] = $this->mdl_module->getModulesAdmin();
			
		$this->load->view('left_menu',$content);	
	}
	/*----------------end admin functions----------------------*/
	

}

