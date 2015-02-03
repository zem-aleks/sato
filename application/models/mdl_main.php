<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_main extends Model {

	function getTitle($module, $values){
		return $this->load->module('settings')->getSettingByName('title');
	}
	function getDescription($module, $values){
		return $this->load->module('settings')->getSettingByName('mkeys');
	}
	function getKeywords($module, $values){
		return $this->load->module('settings')->getSettingByName('mdesc');
	}
	function getCss(){
		$this->db->select('c1.machine_name');
		$this->db->from('modules as c1');
		$this->db->where('c1.status',1);
		$query = $this->db->get();
    	if ($query->num_rows() > 0){
    		$list =  $query->result_array();
			$result = "";
			foreach($list as $item){
				$result .= '<link href="'.base_url().'css/'.$item['machine_name'].'.css" rel="stylesheet" type="text/css"/>\r\n';
			}			
			return $result;
		}
    	else return false;
		
	}
	function getJs(){
		$this->db->select('c1.machine_name');
		$this->db->from('modules as c1');
		$this->db->where('c1.status',1);
		$query = $this->db->get();
    	if ($query->num_rows() > 0){
    		$list =  $query->result_array();
			$result = array();
			foreach($list as $item){
				$result += $this->load->module($item['machine_name'])->headerJS();
			}			
			$js = array_unique($result);
			$result = implode(",", $js );
			return $result;
		}
    	else return false;
	}
}
?>