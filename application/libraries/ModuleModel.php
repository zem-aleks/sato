<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModuleModel extends Model {

    public $tb = '';
    public $config = array();
    public $uploadConfig = array(
        'allowed_types' => 'gif|jpg|png|bmp',
        'max_size' => '1024',
        'max_width' => '2000',
        'max_height' => '2000',
    );
    
    public function __construct($tb, $config, $uploadConfig) {
        parent::__construct();
        $this->tb = $tb;
        $this->config = $config;
        $this->uploadConfig = $uploadConfig;
    }

    function getEntryByField($field, $value, $status = -1) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->where('c1.' . $field, $value);
        if ($status >= 0)
            $this->db->where('c1.status', $status);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else
            return false;
    }

    function getEntryByChpu($chpu, $status = -1) {
        return $this->getEntryByField('chpu', $chpu, $status);
    }

    function getEntryById($id, $status = -1) {
        return $this->getEntryByField('ID', $id, $status);
    }

    function getAllEntries($start = 0, $limit = 0, $status = -1) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        if ($status >= 0)
            $this->db->where('c1.status', $status);
        if ($limit > 0)
            $this->db->limit($limit, $start);
        $this->db->order_by('c1.sort');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return false;
    }

    function getCount($status = -1) {
        $this->db->from($this->tb . ' as c1');
        if ($status >= 0)
            $this->db->where('c1.status', $status);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    
    
    function add()
    {
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['sort'] = $this->getSort();
        $id = $this->db->insert($this->tb, $data);
        return $id;
    }
    
    function edit($idPage)
    {
        $data = array();
        $data['name'] = $this->input->post('name');
        $this->db->where('ID', $idPage);
        $this->db->update($this->tb, $data);
        return $idPage;
    }
    
    function uploadImage($name = 'userfile', $isDetail = false)
    {
        $result = array('image' => '', 'error' => '', 'data' => array());
        $this->uploadConfig['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $this->config['upload_folder'] . '/';
        if(!is_dir($this->uploadConfig['upload_path'])) 
            mkdir($this->uploadConfig['upload_path'], 755);
        $this->load->library('upload', $this->uploadConfig);
        if (!$this->upload->do_upload($name)) {  
            $result['error'] = array('error' => $this->upload->display_errors());
            $result['image'] = '';
        } else {  // вывод параметров  переданного файла
            $result['data'] = $this->upload->data();
            $result['image'] = $result['data']['file_name'];
        }
        return $isDetail? $result : $result['image'];
    }
    
    function getSort()
    {
        $max = 1;
        $this->db->select_max('sort');
        $query = $this->db->get($this->tb);
        $row = $query->row_array();
        if(is_array($row)) {
            $max = $row['sort'] + 1;
        }
        return $max;
    }
    
    function sort()
    {
        if (isset($_POST) && isset($_POST['st'])) {
            $arr = $_POST['st'];
            $items = explode(';', $arr);
            for ($i = 0; $i < count($items) - 1; $i++) {
                $tmp = explode("_", $items[$i]);
                $data['sort'] = $tmp[0];
                $this->db->where('ID', $tmp[1]);
                $this->db->update($this->tb, $data);
            }
        }
    }

    function status($id, $status)
    {
        $this->db->where('ID', $id);
        $this->db->update($this->tb, array('status' => $status));
        return $id;
    }

    function del($id)
    {
        if(!empty($this->config['media_fields'])) {
            $entry = $this->getEntryById($id);
            foreach ($this->config['media_fields'] as $field_name) {
                $this->removeImage($entry[$field_name]);
            }
        }
        $this->db->where('ID', $id);
        $this->db->delete($this->tb);
    }
    
    function removeImage($name)
    {
        $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $this->config['upload_folder'] . '/';
        if(!empty($name) && is_file($path . $name)) {
            unlink($path . $name);
        }
    }

    function checkChpu($str)
    {
        $translit = "empty";
        $i = 0;
        while ($translit != "") {
            $this->db->select('c1.chpu');
            $this->db->from($this->tb . ' as c1');
            $this->db->where('c1.chpu', $str);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $translit = "empty";
            } else
                $translit = "";
            if ($translit != "") {
                $str .= $i;
                $i++;
            }
        }
        return $str;
    }

}
