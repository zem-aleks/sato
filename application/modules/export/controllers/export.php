<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Export extends Controller {

    var $cmodel=null;

    function Export() 
    {
        parent::__construct();
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->load->model('mdl_export');
        $this->cmodel=  $this->mdl_export;
    }

    
    
    function exportFile($table_name, $fields)
    {
        mysql_query("SET NAMES 'cp1251'");
        mysql_query("SET CHARACTER SET 'cp1251'");
        $this->load->dbutil();
        if(!empty($fields))
            $this->db->select(implode(',',$fields));
        $this->db->from($table_name);
        $query = $this->db->get();
        //$query = $this->db->query("SELECT * FROM tbl_item");
        $delimiter = ";";
        $newline = "\r\n";
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        $this->load->helper('download');
        $name = $table_name.' ('.date('Y-m-d H:i:s').').csv';
        force_download($name, $data);
        /*
        // update file
        $this->cmodel->export_csv($table_name,$fields,$path);
        // download file
        $this->load->helper('download');
        if(file_exists($path))
        {
            $data = file_get_contents($path); // Read the file's contents
            $name = $table_name.' ('.date('Y-m-d H:i:s').').csv';
            force_download($name, $data);
        }
        else echo 'error of export file. File not created.';*/
    }
    
    function importFile($table_name,$fields)
    {
        $result=array('status'=>1, 'error'=>'');
        
        $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/uploads/csv/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '300048';
        $config['file_name'] = $table_name;
        $config['overwrite'] = TRUE;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $result['error']=$this->upload->display_errors();
            $result['status']=0;
        } else {
            $result['upload_data'] = $this->upload->data();
            $path=$_SERVER['DOCUMENT_ROOT'].'/uploads/csv/'.$result['upload_data']['orig_name'];
            $result['path']=$path;
            if(file_exists($path))
            {
                if($this->cmodel->import_csv($table_name,$fields,$path))
                {
                    // all ok
                } else {
                    $result['error']='Not imported!!!';
                    $result['status']=0;
                }
            }
            else
            {
                $result['error']='File not exists! Error!!!<br>';
                $result['status']=0;
            }
        }
        
        return $result;
    }
    
}
?>