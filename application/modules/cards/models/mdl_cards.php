<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_cards extends Model {

    //Название таблицы
    var $tb = 'cards';

    function Mdl_cards() {
        parent::__construct();
    }
    
    function getAllPagesAdmin(){
		$this->db->select('c1.*');
		$this->db->from($this->tb.' as c1');
		$this->db->order_by('c1.ID');
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
                $data['number'] = $this->input->post('number');
                $data['sort'] = $this->db->count_all($this->tb)+1;
                $this->db->insert($this->tb,$data);
                $id = $this->db->insert_id();
		return true;
	}
	function edit($id_page){
		$data = array();
		$data['name'] = $this->input->post('name');
                $data['number'] = $this->input->post('number');
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
        
        function del($id){
            $this->db->where('ID',$id);
            $this->db->delete($this->tb);
        }
        
        
        
        function getCards()
        {
            $this->db->select('c1.*');
            $this->db->from($this->tb.' as c1');
            $this->db->where('status',1);
            $this->db->order_by('sort');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->result_array();
            }
            else
                return false;
        }

}
