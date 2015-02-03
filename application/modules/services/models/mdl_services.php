<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_services extends ModuleModel {

    public $tb = '';
    public $config = array();
    public $uploadConfig = array(
        'allowed_types' => 'gif|jpg|png|bmp',
        'max_size' => '1024',
        'max_width' => '2000',
        'max_height' => '2000',
        'encrypt_name' => TRUE,
    );
    
    public function __construct() {
        parent::__construct($this->tb, $this->config, $this->uploadConfig);
    }
    
    function getFilterEntries($start, $limit, $status, $filter) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        if ($status >= 0)
            $this->db->where('c1.status', $status);
        if(!empty($filter))
            $this->db->where($filter);
        if ($limit > 0)
            $this->db->limit($limit, $start);
        $this->db->order_by('c1.sort');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return false;
    }
    
    function add()
    {
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['category'] = $this->input->post('category');
        $data['content'] = $this->input->post('content');
        $data['date'] = date('Y-m-d H:i:s');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        $data['sort'] = $this->getSort();
        $id = $this->db->insert($this->tb, $data);
        return $id;
    }
    
    function edit($idPage)
    {
        $entry = $this->getEntryById($id);
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['category'] = $this->input->post('category');
        $data['content'] = $this->input->post('content');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        $this->db->where('ID', $idPage);
        $this->db->update($this->tb, $data);
        return $idPage;
    }
    
    function getServiceCategories($status = 1)
    {
        $categories = array();
        if($status > 0)
            $this->db->where('status', $status);
        $this->db->from('service_categories');
        $this->db->order_by('sort');
        $query = $this->db->get();
        return $query->result_array();
    }
    
}
