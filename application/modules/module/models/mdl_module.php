<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_module extends Model {
	public $tb = 'modules';

	function getAllModulesAdmin(){
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
	function getModulesAdmin(){
		$this->db->select('c1.*');
		$this->db->from($this->tb.' as c1');
		$this->db->where('status',1);
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
		$data['machine_name'] = $this->input->post('machine_name');
	
		$this->db->insert($this->tb,$data);
		return true;
	}
	
	function edit($id_page){
		$data = array();
		$data['name'] = $this->input->post('name');
		$data['machine_name'] = $this->input->post('machine_name');
		
		$this->db->where('ID',$id_page);
		$this->db->update($this->tb,$data);
		return true;
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
	
	function getModuleInfo($id_page){
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
}