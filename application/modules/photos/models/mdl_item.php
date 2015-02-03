<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_item extends Model {
	public $tb = 'product';
	public $perPage = 200;

	function getPageCHPU($str){
		$this->db->select('c1.*');
		$this->db->from($this->tb.' as c1');
		$this->db->where('c1.chpu',$str);
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
                    return $query->row_array();
		}	
		else return false;
	}
	
	function getLeftMenu(){
		$this->db->select('c1.title, c1.chpu, c1.ID');
		$this->db->from($this->tb.' as c1');
		$this->db->join('cat_item', 'cat_item.id_page = c1.ID','left outer');
		$this->db->where('cat_item.id',null);
		$this->db->where('c1.status',1);
		
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}	
		else return false;
	}
	
	function getAllPagesAdmin($page){
		$this->db->select('c1.*');
		$this->db->from($this->tb.' as c1');
		$this->db->order_by('c1.ID');
                $this->db->limit($this->perPage,$this->perPage*$page);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
                    return $query->result_array();
		}
		else return false;
	}
        
        function getAllPagesCount(){
            return $this->db->count_all($this->tb);
        }
        
        
	function add(){
		$data = array();
		$data['name'] = $this->input->post('name');
                $data['price'] = $this->input->post('price');
		$data['content'] = $this->input->post('content');
                $data['id_catalog'] = $this->input->post('id_parent');
                $this->db->insert($this->tb,$data);
                $id = $this->db->insert_id();
                
                $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/items';  // задаем путь к директории upload
                $config['allowed_types'] = 'jpg|jpeg'; // указываем допустимые расширения
		$config['max_size']    = '1024';  // max размер файла в Kb
		$config['max_width']  = '2000';  // max размер  по вертикали
		$config['max_height']  = '2000'; // max размер  по горизонтали
                
                $config['file_name']  = $id; 
                $config['overwrite']  = TRUE; 
                
		$this->load->library('upload', $config);

		if ( !$this->upload->do_upload()){   // сообщение об ошибке загрузки
			$error = array('error' =>$this->upload->display_errors());
		}
		else{  // вывод параметров  переданного файла
			$img = $this->upload->data();
		}
                
		return true;
	}
	function edit($id_page){
		$data = array();
		$data['name'] = $this->input->post('name');
                $data['price'] = $this->input->post('price');
		$data['content'] = $this->input->post('content');
                $data['id_catalog'] = $this->input->post('id_parent');
                $this->db->where('ID',$id_page);
		$this->db->update($this->tb,$data);
                
                //echo $this->input->post('del');
                //echo $_SERVER['DOCUMENT_ROOT'].'/uploads/items/'.$id_page.'.jpg';
                if($this->input->post('del')=='on'){
                    if (file_exists($_SERVER['DOCUMENT_ROOT'].'/uploads/items/'.$id_page.'.jpg')) {
                        unlink($_SERVER['DOCUMENT_ROOT'].'/uploads/items/'.$id_page.'.jpg') 
                                or die('failed deleting: ' . $path);
                    }
                }
                
                    $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/items/';  // задаем путь к директории upload
                    $config['allowed_types'] = 'jpg|jpeg'; // указываем допустимые расширения
                    $config['max_size']    = '1024';  // max размер файла в Kb
                    $config['max_width']  = '2000';  // max размер  по вертикали
                    $config['max_height']  = '2000'; // max размер  по горизонтали

                    $config['file_name']  = $id_page; 
                    $config['overwrite']  = TRUE; 

                    $this->load->library('upload', $config);

                    if ( !$this->upload->do_upload()){   // сообщение об ошибке загрузки
                            $error = array('error' =>$this->upload->display_errors());
                    }
                    else{  // вывод параметров  переданного файла
                            $img = $this->upload->data();
                    }
                
                
		return true;
	}
	function sort(){
		 if (isset($_POST) && isset($_POST['st'])) {
			$arr = $_POST['st'];
			$items = explode(';', $arr);
			for($i=0;$i<count($items)-1;$i++){
				$tmp = explode("_", $items[$i]);				
				$data['sort'] = $tmp[0];
				$this->db->where('ID',$tmp[1]);
				$this->db->update($this->tb,$data);				
			}
		}
	}
        
	function status ($id, $status) {
            $data = array();
            $data['status'] = $status;
            $this->db->where('ID',$id);
            $this->db->update($this->tb,$data);

            if($id){
                    return true;
            }
            else return false;
        }
        
	function getPageInfo($id_page){
		$this->db->select('c1.*');
		$this->db->from($this->tb.' as c1');
		$this->db->order_by('c1.ID');
		$this->db->where('c1.ID',$id_page);
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	
	
		else return false;
	}
	function getPageCat($id_page){
		$this->db->select('c1.id_cat');
		$this->db->from('cat_item as c1');
		$this->db->where('c1.id_page',$id_page);
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
	
	
		else return false;
	}
	function getCatList(){
            $this->db->select('c1.ID, c1.cat_name');
		$this->db->from('categories as c1');
		$this->db->where('c1.id_parent >','0');
		$query = $this->db->get();
            if ($query->num_rows() > 0){
                    $list =  $query->result_array();
                            $result = array();
                            $result[0] = "Нет";
                            foreach($list as $item){
                                    $result[$item['ID']] = $item['cat_name'];
                            }			
                            return $result;
                    }
            else return false;

        }
        
	function del($id){
            $this->db->where('ID',$id);
            $this->db->delete($this->tb);
        }
	function checkCHPU($str){
		$translit = "empty";
		$i=0;
		while($translit != ""){
			$this->db->select('c1.chpu');
			$this->db->from($this->tb.' as c1');
			$this->db->where('c1.chpu',$str);
			$query = $this->db->get();
	
			if ($query->num_rows() > 0){
				$translit = "empty";
			}else $translit = "";
			if($translit != "") {$str .= $i;$i++;}
		}
		return $str;
	}
        
        function getItemsCount($field,$value){
            $this->db->from($this->tb.' as c1');
            $this->db->where($field, $value);
            $this->db->where('c1.status', 1);
            return $this->db->count_all_results();;
        }
        
        function getItemsByCategory($id_category,$limit,$start)
        {
            $this->db->select('c1.*');
            $this->db->from($this->tb.' as c1');
            $this->db->where('c1.id_catalog', $id_category);
            $this->db->where('c1.status', 1);
            $this->db->order_by('c1.date','desc');
            $this->db->order_by('c1.ID','desc');
            if($limit>0)
                $this->db->limit($limit,$start);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
                return false;
        }
        
        function getItemById($id_item)
        {
            $this->db->select('c1.*');
            $this->db->from($this->tb . ' as c1');
            $this->db->order_by('c1.ID');
            $this->db->where('c1.ID', $id_item);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            else
                return false;
        }
        
        function getItemsByIds($ids)
        {
            $this->db->select('c1.*');
            $this->db->from($this->tb . ' as c1');
            $this->db->where_in('ID',$ids);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
                return false;
        }
        
        function findItem($field,$value)
        {
            $this->db->select('c1.*, 
                cat1.chpu as cat_chpu,cat1.cat_name as cat_name,
                cat2.chpu as shop_chpu, cat2.cat_name as shop_name');
            $this->db->from($this->tb . ' as c1');
            
            $this->db->join('cat_item', 'cat_item.id_page = c1.ID');
            $this->db->join('categories as cat1', 'cat_item.id_cat = cat1.ID');
            $this->db->join('categories as cat2', 'cat1.id_parent = cat2.ID');
            
            $this->db->like($field, $value); 
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
                return false;
        }
        
        function findItemLinks($field,$value)
        {
            $this->db->select('c1.chpu');
            $this->db->where($field,$value);
            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
            else
                return false;
        }      
        
        function getLastNewItems($count,$start=0)
        {
            $this->db->from($this->tb . ' as c1');
            $this->db->where('c1.status', 1);
            $this->db->order_by('c1.date','desc');
            $this->db->order_by('c1.ID','desc');
            $this->db->limit($count,$start);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
                return false;
        }
           
}