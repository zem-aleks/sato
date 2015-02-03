<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Actions extends Controller {

	public $name = 'articles';
	public $md = 'mdl_actions';
        public $cmodel=null;

	function Actions(){
		parent::__construct();
		$this->load->model($this->md);
                $this->cmodel=$this->mdl_actions;
	}

	
	/*-----------------------admin function---------------------*/
	function admin_index($page = 0){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!$is_logged_in){
			redirect('admin');	
		}
		else{
			$content = array();
			$content['title'] = 'Акции';
			$content['key'] = 0;		
			$content['pages'] = $this->cmodel->getAllPagesAdmin();
			
			$this->load->view('includes/admin_header',$content);	
			$this->load->view('list',$content);	
			$this->load->view('includes/admin_footer',$content);	
		}
	}	
        
	function addPage(){
		$content = array();
		$content['title'] = 'Контент';
		//$content['categories'] = $this->mdl_recipe->getCatList();
		
		$this->load->view('includes/admin_header',$content);	
		$this->load->view('add',$content);	
		$this->load->view('includes/admin_footer',$content);	
	}
	function editPage($id_page){
		$content['title'] = 'Редактирование контента';
		$content['page_info'] = $this->cmodel->getPageInfo($id_page);
		
		$this->load->view('includes/admin_header',$content);	
		$this->load->view('edit',$content);	
		$this->load->view('includes/admin_footer',$content);	
	}
	function add(){
		$this->cmodel->add();
		redirect('dashboard/actions');
	}
	function edit($id_page){
		if($this->cmodel->edit($id_page))
                    redirect('dashboard/actions');
                else 
                    redirect('dashboard/actions/editPage/'.$id_page);

	}
	function sort(){
		$this->cmodel->sort();
	}
	function status($id_cat, $status){
		if($this->cmodel->status($id_cat, $status)){
			redirect('dashboard/actions');
		}
		else {
			echo "no";
		}
	}
	function delPage($id)
        { 
		$this->cmodel->del($id);
		redirect('dashboard/actions');
	}
	/*----------------end admin functions----------------------*/


        function getAllArticles()
        {
            return $this->cmodel->getAllArticles();
        }
        
        function getArticle($chpu)
        {
            return $this->cmodel->getPageCHPU($chpu);
        }
        
        function getLinkRecipe($recipe_chpu)
        {
            $recipe=  $this->getRecipe($recipe_chpu);
            $ingridients= explode("\n",$recipe['ingridients']);
            foreach ($ingridients as &$val)
            {
                $val=trim($val);
                $links=$this->load->module('item')->findItem('name',$val);
                if($links)
                {
                    $link=$links[0];
                    $val='<a href="/'.$link['shop_chpu'].'/'.$link['cat_chpu'].'">'.$val.'</a>';
                }
            }
            $recipe['ingridients']=$ingridients;
            return $recipe;
        }
        
        function viewsUp($id)
        {
            $this->cmodel->viewsUp($id);
        }
        
        function findItem($field,$value)
        {
            return $this->cmodel->findItem($field,$value);
        }
}

