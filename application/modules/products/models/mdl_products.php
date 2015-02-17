<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_products extends ModuleModel {

    public $tb = 'products';
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
    
    function getFilterEntries($start, $limit, $status, $filter, $order = 'c1.sort') {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        if ($status >= 0)
            $this->db->where('c1.status', $status);
        if(!empty($filter))
            $this->db->where($filter);
        if ($limit > 0)
            $this->db->limit($limit, $start);
        $this->db->order_by($order);
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
        $data['price'] = $this->input->post('price');
        $data['id_category'] = $this->input->post('id_category');
        $data['id_brand'] = $this->input->post('id_brand');
        $data['on_main'] = $this->input->post('on_main');
        $data['on_slider'] = $this->input->post('on_slider');
        $data['slider_desc'] = $this->input->post('slider_desc');
        $data['short'] = $this->input->post('short');
        $data['content'] = $this->input->post('content');
        $data['date'] = date('Y-m-d H:i:s');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        $data['sort'] = $this->getSort();
        $data['sizes'] = $this->input->post('sizes');
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        
        $this->db->insert($this->tb, $data);
        $id = $this->db->insert_id();
        
        foreach ($_FILES as $key => $file) {
            $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/products/', $key);
            if($result['status'] == 1) {
                $this->db->insert('images', array(
                    'id_item' => $id,
                    'image' => $result['img']['file_name']
                ));
            }
        }
        
        return $id;
    }

    function edit($id)
    {
        $entry = $this->getEntryById($id);
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['price'] = $this->input->post('price');
        $data['id_category'] = $this->input->post('id_category');
        $data['id_brand'] = $this->input->post('id_brand');
        $data['short'] = $this->input->post('short');
        $data['content'] = $this->input->post('content');
        $data['sizes'] = $this->input->post('sizes');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        $data['on_main'] = $this->input->post('on_main')? 1 : 0;
        $data['on_slider'] = $this->input->post('on_slider')? 1 : 0;
        $data['slider_desc'] = $this->input->post('slider_desc');
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        
        if($this->input->post('del') == 'on') {
            $this->removeImage($entry['image']);
            $data['image'] = "";
        } elseif(empty($_POST['image'])) {
            $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/products/', 'userfile');
            $img = $result['img'];
            if ($result['status'] == 1)
                $data['image'] = $img['file_name'];
        }
        
        $this->db->where('ID', $id);
        $this->db->update($this->tb, $data);
        
        foreach ($_FILES as $key => $file) {
            $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/products/', $key);
            if($result['status'] == 1) {
                $this->db->insert('images', array(
                    'id_item' => $id,
                    'image' => $result['img']['file_name']
                ));
            }
        }
    
        $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/products/';
        if(isset($_POST['delImage']))
            foreach ($_POST['delImage'] as $key => $value) 
            {
                $where = array(
                    'id_item' => $id,
                    'ID' => $key
                );
                $this->db->where($where);
                $this->db->limit(1);
                $query = $this->db->get('images');
                $image = $query->row_array();
                if(file_exists($path . 'original/' . $image['image']))
                    unlink ($path . 'original/' . $image['image']);
                if(file_exists($path . 'thumb/' . $image['image']))
                    unlink ($path . 'thumb/' . $image['image']);
                $this->db->where($where);
                $this->db->delete('images');
            }
        
        return $id;
    }

}
