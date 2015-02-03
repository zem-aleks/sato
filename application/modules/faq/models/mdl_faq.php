<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_faq extends ModuleModel {

    public $tb = 'test';
    public $config = array();
    public $uploadConfig = array(
        'allowed_types' => 'gif|jpg|png|bmp',
        'max_size' => '1024',
        'max_width' => '2000',
        'max_height' => '2000',
    );
    
    public function __construct() {
        parent::__construct($this->tb, $this->config, $this->uploadConfig);
    }
    
    function add()
    {
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['answer'] = $this->input->post('answer');
        $data['sort'] = $this->getSort();
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        
        $id = $this->db->insert($this->tb, $data);
        return $id;
    }

    function edit($idPage)
    {
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['answer'] = $this->input->post('answer');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        $this->db->where('ID', $idPage);
        $this->db->update($this->tb, $data);
        return $idPage;
    }
}
