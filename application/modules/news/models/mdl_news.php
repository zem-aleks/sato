<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_news extends Model {
	public $tb = 'news';
	public $perPage = 10;

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

	
	function getAllPagesAdmin(){
		$this->db->select('c1.*');
		$this->db->from($this->tb.' as c1');
		$this->db->order_by('c1.sort');
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else return false;
	}
	function add(){
		$data = array();
		$data['name'] = $this->input->post('name');
                $data['date']= date('Y-m-d');
                $data['views']= 0;
		$data['content'] = $this->input->post('content');
		$data['title'] = $this->input->post('title');
		$data['mkeys'] = $this->input->post('mkeys');
		$data['mdesc'] = $this->input->post('mdesc');
		$data['chpu'] = $this->input->post('chpu');
		$data['sort'] = $this->db->count_all($this->tb)+1;
		if(empty($data['chpu'])){
			$data['chpu'] = $this->checkCHPU(rus2translit($data['name']));
		}	
                
                $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/articles/', 'userfile');
                $img = $result['img'];
                if($result['status'] == 1)
                    $data['image'] = $img['file_name'];
                
                
		$id = $this->db->insert($this->tb,$data);
		
		return true;
	}
	function edit($id_page){
		$data = array();
		$data['name'] = $this->input->post('name');
		$data['content'] = $this->input->post('content');
		$data['title'] = $this->input->post('title');
		$data['mkeys'] = $this->input->post('mkeys');
		$data['mdesc'] = $this->input->post('mdesc');
		$data['chpu'] = $this->input->post('chpu');
                $data['date']= date('Y-m-d');
		if(empty($data['chpu'])){
			$data['chpu'] = $this->checkCHPU(rus2translit($data['name']));
		}
                
                $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/articles/', 'userfile');
                $img = $result['img'];
                if($result['status'] == 1)
                    $data['image'] = $img['file_name'];
		
		if($this->input->post('del')=='on'){
                    if (file_exists($this->input->post('image'))) {
                        unlink($this->input->post('image')) or die('failed deleting: ' . $path);
                    }
                    $data['image'] = "no_image.jpg";
                }
                
		$this->db->where('ID',$id_page);
		$this->db->update($this->tb,$data);
		
		
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
    
    
    function viewsUp($id)
    {
        $data = array();
        $this->db->set('views', 'views + 1',FALSE);
    	$this->db->where('ID',$id);
    	$this->db->update($this->tb);
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
        
        function getAllArticles($start, $limit)
        {
            $this->db->select('c1.*');
            $this->db->from($this->tb . ' as c1');
            $this->db->where('c1.status',1);
            $this->db->order_by('c1.sort');
            $this->db->limit($limit, $start);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
                return false;
        }
        
        function getCount()
        {
            $this->db->from($this->tb . ' as c1');
            $this->db->where('c1.status',1);
            $query = $this->db->get();
            return $query->num_rows();
        }

        function findItem($field,$value)
        {
            $this->db->select('c1.*');
            $this->db->from($this->tb . ' as c1');
            $this->db->like($field, $value); 
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
                return false;
        }
        
        function getLastNews($count)
        {
            $this->db->select('c1.*');
            $this->db->from($this->tb . ' as c1');
            $this->db->where('c1.status',1);
            $this->db->order_by('c1.sort');
            $this->db->limit($count);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
                return false;
        }
        
        

}