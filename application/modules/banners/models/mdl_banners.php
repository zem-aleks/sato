<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_banners extends Model {
    //Название таблицы
	var $table = 'banners';
    
    
    //Количество элементов на странице
    var $per_page = 35;

	
    function Mdl_banners () {
		parent::__construct();  
	}   
    
	function getBanners(){
    	$this->db->select('c1.*');
		$this->db->from($this->table.' as c1');
		$this->db->where('c1.status',1);
		$query = $this->db->get();
    	if ($query->num_rows() > 0)
    		return $query->result_array();
    	else return false;
    	
    }
    /*--------------------------------------------------------------------*/
	function getlist(){
    	$query = $this->db->get($this->table);		
    	if ($query->num_rows() > 0)
		      return $query->result_array();        
		else return false;
    	
    }
	
	function add () {
    	$data = array();
    	
    	$data['name'] = $this->input->post('name');
    	$data['link'] = $this->input->post('link');
        $data['categoryID'] = $this->input->post('categoryID');
		
		$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/banners/';  // задаем путь к директории upload
                $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg'; // указываем допустимые расширения
		$config['max_size']    = '2048';  // max размер файла в Kb
		$config['max_width']  = '2048';  // max размер  по вертикали
		$config['max_height']  = '2048'; // max размер  по горизонтали

		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload()){   // сообщение об ошибке загрузки
			$error = array('error' =>$this->upload->display_errors());
			$data['image'] = '';
		}
		else{  // вывод параметров  переданного файла
			$img = $this->upload->data();
			$data['image'] = $img['file_name'];
		}
    	
    	$this->db->insert($this->table,$data);
    	$id_cat = $this->db->insert_id();

    	if($id_cat){
    	return true;
    	}
    	else return false;
    }
    
    function edit($id) {
    	$data = array();
    
    	$data['name'] = $this->input->post('name');
    	$data['link'] = $this->input->post('link');
        $data['categoryID'] = $this->input->post('categoryID');
		$del = $this->input->post('del');
		
		$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/banners/';  // задаем путь к директории upload
                $config['allowed_types'] = 'gif|jpg|png|bmp|jpeg'; // указываем допустимые расширения
		$config['max_size']    = '2048';  // max размер файла в Kb
		$config['max_width']  = '2048';  // max размер  по вертикали
		$config['max_height']  = '2048'; // max размер  по горизонтали

		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload()){   // сообщение об ошибке загрузки
			$error = array('error' =>$this->upload->display_errors());
		}
		else{  // вывод параметров  переданного файла
			$img = $this->upload->data();
			$data['image'] = $img['file_name'];
		}
		
		if($del){
			 if (file_exists($this->input->post('image'))) {
				unlink($this->input->post('image')) or die('failed deleting: ' . $path);
			  }
    		$data['image'] = "";
    	}
		
    	$this->db->where('ID',$id);
    	$this->db->update($this->table,$data);
    
    	if($id){
    		return true;
    	}
    	else return false;
    }
	
	function status ($id, $status) {
    	$data = array();
    
    	$data['status'] = $status;
    	$this->db->where('ID',$id);
    	$this->db->update($this->table,$data);
    
    	if($id){
    		return true;
    	}
    	else return false;
    }
    
    function del($id){
    	$this->db->where('ID',$id);
    	$this->db->delete($this->table);
    }
	
	function getBannersList(){
    	$query = $this->db->get($this->table);
    	if ($query->num_rows() > 0){
    		$list =  $query->result_array();
			$result = array();
			foreach($list as $item){
				$result[$item['link']] = $item['image'];
			}			
			return $result;
		}
    	else return false;
    	
    }
   
   function getBanner($id){
		$this->db->select('c1.*');
		$this->db->from($this->table.' as c1');
		$this->db->where('c1.ID',$id);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}
		else return false;
   }
   
   
   function getBannerOfPage($id_page)
   {
       $this->db->select('c1.*');
		$this->db->from($this->table.' as c1');
		$this->db->where('c1.categoryID',$id_page);
                $this->db->where('c1.status',1);
		$query = $this->db->get();
		if ($query->num_rows() > 0){
			return $query->row_array();
		}
		else return false;
   }
}
