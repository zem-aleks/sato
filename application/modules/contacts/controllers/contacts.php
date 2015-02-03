<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends Controller {

	public $name = 'contacts';
	public $md = 'mdl_contacts';

	function Contacts(){
		parent::__construct();
                session_start();
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
			$content['title'] = 'Контакты';
			$content['key'] = 0;		
			$content['pages'] = $this->mdl_contacts->getAllPagesAdmin();
			
			$this->load->view('includes/admin_header',$content);	
			$this->load->view('list',$content);	
			$this->load->view('includes/admin_footer',$content);	
		}
	}	
        
	function addPage(){
		$content = array();
		$content['title'] = 'Добавить контакт';
		$this->load->view('includes/admin_header',$content);	
		$this->load->view('add',$content);	
		$this->load->view('includes/admin_footer',$content);	
	}
	function editPage($id_page){
		$content['title'] = 'Редактирование контакта';
		$content['page_info'] = $this->mdl_contacts->getPageInfo($id_page);
		
		$this->load->view('includes/admin_header',$content);	
		$this->load->view('edit',$content);	
		$this->load->view('includes/admin_footer',$content);	
	}
	function add(){
		$this->mdl_contacts->add();
		redirect('dashboard/contacts');
	}
	function edit($id_page){
		if($this->mdl_contacts->edit($id_page))
                    redirect('dashboard/contacts');
                else 
                    redirect('dashboard/contacts/editPage/'.$id_page);
	}
        
	function sort(){
		$this->mdl_contacts->sort();
	}
        
	function status($id_cat, $status){
		if($this->mdl_contacts->status($id_cat, $status)){
			redirect('dashboard/contacts');
		}
		else {
			echo "no";
		}
	}
	function delPage($id){
	 
		$this->mdl_contacts->del($id);
		redirect('dashboard/contacts');
	}
	/*----------------end admin functions----------------------*/
	
        
        function getItemById($id_item)
        {
            return $this->mdl_contacts->getItemById($id_item);
        }
        
        function getItemsByIds($ids)
        {
            return $this->mdl_contacts->getItemsByIds($ids);
        }
        
        function getContacts($status=-1)
        {
            return $this->mdl_contacts->getAllPagesAdmin($status);
        }

}

