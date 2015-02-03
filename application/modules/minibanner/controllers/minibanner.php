<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Minibanner extends Controller {
    
	var $tb = 'minibanner';
	
	var $md = 'mdl_minibanner'; 
	
    function Minibanner() {
		parent::__construct();
		$this->load->helper('form');
		$this->load->model($this->md);		
    }
	
    function admin_index($cat_id='',$start_row = 0, $sort_field = '', $fs = ''){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!$is_logged_in){
			redirect('admin');	
		}
		else{
			$content = array();
			$content['title'] = 'Минибаннеры';    	
			$content['slider'] = $this->{$this->md}->getlist();
			
			$this->load->view('includes/admin_header',$content);	
			$this->load->view('list',$content);	
			$this->load->view('includes/admin_footer',$content);
		}
    }
    
	function getSImages(){
		return $this->{$this->md}->getSImages();
	}
	
	function add($something='',$error=''){  
		$content['title'] = 'Добавление изображения';
                $content['error'] = $error;
		$this->load->view('includes/admin_header',$content);	
		$this->load->view('add',$content);	
		$this->load->view('includes/admin_footer',$content);
	}
 
 
	function edit($id,$something='',$error=''){
		$content['title'] = 'Редактирование изображения';	 
		$content['slider'] = $this->{$this->md}->getImage($id);
                $content['error'] = $error;
	
		$this->load->view('includes/admin_header',$content);	
		$this->load->view('edit',$content);	
		$this->load->view('includes/admin_footer',$content);
	}
 
	function del($id){
	 
		$this->{$this->md}->del($id);
		redirect('dashboard/minibanner');
	}
 
	function addImage(){
		if($this->{$this->md}->add()){
			redirect('dashboard/minibanner');
		}
		else {
                    $this->add('','Ошибка загрузки изображения. 
                        Изображение должно быть формата jpg,png или gif,
                        разрещением не более 2000х2000 пк. 
                        и размером не более 2 мб.');
		}
	}
 
	function editImage($id){
		if($this->{$this->md}->edit($id)){
			redirect('dashboard/minibanner');
		}
		else {
			$this->edit($id,'','Ошибка загрузки изображения. 
                        Изображение должно быть формата jpg,png или gif,
                        разрещением не более 2000х2000 пк. 
                        и размером не более 2 мб.');
		}
	}
	
	function status($id, $status){
		if($this->{$this->md}->status($id, $status)){
			redirect('dashboard/minibanner');
		}
		else {
			echo "no";
		}
	}
        
        function sort(){
		$this->{$this->md}->sort();
	}
    
}