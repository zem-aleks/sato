<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_portfolio extends ModuleModel {

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
    
    function add()
    {
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['content'] = $this->input->post('content');
        $data['date'] = date('Y-m-d H:i:s');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        //$data['image'] = $this->uploadImage('userfile');
        $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/portfolio/', 'userfile');
        $img = $result['img'];
        if ($result['status'] == 1)
            $data['image'] = $img['file_name'];
        $data['sort'] = $this->getSort();
        
        $id = $this->db->insert($this->tb, $data);
        return $id;
    }
    
    function edit($idPage)
    {
        $entry = $this->getEntryById($id);
        $data = array();
        $data['name'] = $this->input->post('name');
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
            $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/portfolio/', 'userfile');
            $img = $result['img'];
            if ($result['status'] == 1)
                $data['image'] = $img['file_name'];
        }
        
        $this->db->where('ID', $idPage);
        $this->db->update($this->tb, $data);
        return $idPage;
    }
}
