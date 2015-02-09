<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_news extends ModuleModel {

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
        $data['short'] = $this->input->post('short');
        $data['content'] = $this->input->post('content');
        $data['date'] = date('Y-m-d H:i:s');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        
        $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/news/', 'userfile');
        $img = $result['img'];
        if ($result['status'] == 1)
            $data['image'] = $img['file_name'];
        $data['sort'] = $this->getSort();
        
        $id = $this->db->insert($this->tb, $data);
        return $id;
    }

    function edit($id)
    {
        $entry = $this->getEntryById($id);
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['short'] = $this->input->post('short');
        $data['content'] = $this->input->post('content');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        
        if($this->input->post('del') == 'on') {
            $this->removeImage($entry['image']);
            $data['image'] = "";
        } elseif(empty($_POST['image'])) {
            $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/news/', 'userfile');
            $img = $result['img'];
            if ($result['status'] == 1)
                $data['image'] = $img['file_name'];
        }
        
        $this->db->where('ID', $id);
        $this->db->update($this->tb, $data);
        return $id;
    }

}
