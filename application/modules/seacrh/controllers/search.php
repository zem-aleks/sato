<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Controller {

	public $md = 'mdl_search';
        public $cmodel = null;

	function Search(){
		parent::__construct();
		$this->load->model($this->md);
                $this->cmodel=  $this->mdl_search;
	}

	
	/*-----------------------admin function---------------------*/
	function admin_index($page = 0){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!$is_logged_in){
			redirect('admin');	
		}
		else{
			$content = array();
			$content['title'] = 'Рецепты';
			$content['key'] = 0;		
			$content['pages'] = $this->mdl_recipe->getAllPagesAdmin();
			
			$this->load->view('includes/admin_header',$content);	
			$this->load->view('list',$content);	
			$this->load->view('includes/admin_footer',$content);	
		}
	}
        
        
        function find($tables,$fields,$text)
        {
            
        }
        
}