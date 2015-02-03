<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib_forms{
    
    var $form = 0;
    var $CI;
    
    var $t_frame = 'frame';
    
    var $t_form = 'form';
     
    var $t_module = 'module';
    
    var $t_elemts = 'elementonframe';
	
	function Lib_forms() {
	   
		$this->CI = &get_instance ();
        
        //$this->form = (!empty($page))? $page : 'main';
	}
    
    
    function GetFrames() //Получаем наши фреймы по форме
 	{
 	  
      $this->CI->db->from($this->t_elemts);
      $this->CI->db->join($this->t_module, $this->t_elemts.'.ModuleId = '.$this->t_module.'.ModuleId');
      $this->CI->db->where('FormID',1);	
      $query = $this->CI->db->get();
      
      /*
      $sql = "SELECT c1.*,c2.* FROM ".$this->CI->db->dbprefix.$this->t_elemts." AS c1 INNER JOIN ".$this->CI->db->dbprefix.$this->t_module." AS c2 ON c1.ModuleId = c2.ModuleId WHERE c1.FormID = 1";
      $query = $this->CI->db->query($sql);
*/
        $frames = array();  
        $blocks = array();
        if ($query->num_rows() > 0){  
            foreach($query->result_array() as $element){
                if ($element['WidthCell'] == null) $element['WidthCell']  = "100%";
        		if ($element['HeightCell'] == 50) $element['HeightCell']  = "100%";
        		if ($element['HeightCell'] == null) $element['HeightCell']  = "100%";
        		if ($element['style'] != "") $element['style'] = "style=\"".$element['style']."\"";
        		if ($element['align'] == null) $element['align'] = "left";
        		if ($element['valign'] == null) $element['valign'] = "top";
                        
                $frames[$element['FrameID']][$element['RowPos']][$element['ColPos']] = $element;
            }       	  
        }
        
        ksort($frames);
        foreach($frames as $f => $frame){   
            ksort($frame);
            $blocks[$f] = "<table border=\"0\"  cellpadding=\"0\"  cellspacing=\"0\" height=\"10\" width=\"100%\">";  
             foreach($frame as $r => $rows){
                 ksort($rows);
                 $blocks[$f] .= "<tr>";
                    foreach($rows as $c => $cols){

                        $info = $this->load_module($cols['module_name']);
                        $blocks[$f] .= "<td valign='".$cols['valign']."' align='".$cols['align']."'  ".$cols['style'].">".$info;
                        $blocks[$f] .= "</td>";
                    }           
                 $blocks[$f] .= "</tr>"; 
             }
             $blocks[$f] .= "</table>";   
        }  
                
        return $blocks;
 	}
    
    
    function load_module($name,$method = '',$data=array()){
        
        if($method != ''){
            $this->CI->load->model('modules/'.$name);       
            $data['content'] = $this->CI->{$name}->{$method}($data);
        }

        if ($this->isFile($name)){
            return $this->CI->load->view('template/modules/'.$name,$data,true);
        }
        
        
        
    }
    
    
    function isFile($name){
        return (file_exists(APPPATH.'views/template/modules/'.$name.EXT))? true: false;
    }
    
	
}


?>