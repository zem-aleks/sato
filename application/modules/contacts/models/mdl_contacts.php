<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_contacts extends Model {
	public $tb = 'contacts';
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
	
	/*function getLeftMenu(){
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
	}*/
	
	function getAllPagesAdmin($status=-1){
		$this->db->select('c1.*');
		$this->db->from($this->tb.' as c1');
                if($status>=0)
                    $this->db->where('status',$status);
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
                $data['map'] = $this->input->post('map');
		$data['content'] = $this->input->post('content');
		$data['sort'] = $this->db->count_all($this->tb)+1;
                
		$id = $this->db->insert($this->tb,$data);
		return true;
	}
	function edit($id_page){
		$data = array();
		$data['name'] = $this->input->post('name');
                $data['map'] = $this->input->post('map');
		$data['content'] = $this->input->post('content');
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
        
	
	function del($id){
            $this->db->where('ID',$id);
            $this->db->delete($this->tb);
        }
                
        
        function getItemsByIds($ids)
        {
            $this->db->select('c1.*');
            $this->db->from('item as c1');
            $this->db->where_in('ID',$ids);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
                return false;
        }
}