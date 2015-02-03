<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dictionary extends Controller {

    
    private $md = 'mdl_dictionary';
    //private static $types = array('color', 'brand', 'material');

    function Dictionary() {
        parent::__construct();
        $this->load->model($this->md);
    }

    /* -----------------------admin function--------------------- */

    function admin_index($page = 0) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        
        $content = array();
        $content['title'] = 'Допольнительные материалы по товарам';
        $content['types'] = array(
            'color' => array(
                'name' => 'Цвета товаров',
                'placeholder' => '#FFFFFF',
                'dictionary' => $this->{$this->md}->getDictionary('color')
            ),
            'brand' => array(
                'name' => 'Бренды/Фирмы',
                'placeholder' => 'Описание бренда',
                'dictionary' => $this->{$this->md}->getDictionary('brand')
            ),
            'material' => array(
                'name' => 'Материалы из которых делают товары',
                'placeholder' => 'Описание  материала',
                'dictionary' => $this->{$this->md}->getDictionary('material')
            )
        );

        $this->load->view('includes/admin_header', $content);
        $this->load->view('list', $content);
        $this->load->view('includes/admin_footer', $content);
    }
    
    function add()
    {
        if (!$this->session->userdata('is_logged_in')) 
            redirect('admin');
        $name = $this->input->post('name', TRUE);
        $content = $this->input->post('content', TRUE);
        $type = $this->input->post('type', TRUE);
        $this->db->insert('item_options', array(
            'name' => $name,
            'content' => $content,
            'type' => $type
        ));
        echo $this->db->insert_id();
    }
    
    function edit($id)
    {
        if (!$this->session->userdata('is_logged_in') && $id <= 0) 
            echo 0;
        else {
            $data = array();
            $data['name'] = $this->input->post('name', TRUE);
            $data['content'] = $this->input->post('desc', TRUE);
            $this->db->where('ID', $id);
            $this->db->update('item_options', $data);
            echo 1;
        }
        
    }
    
    function del($id)
    {
        if (!$this->session->userdata('is_logged_in')) 
            redirect('admin');
        $this->db->where('ID', $id);
        $this->db->delete('item_options');
        echo 1;
    }
    
    function getValue($id)
    {
        $this->db->where('ID', $id);
        $query = $this->db->get('item_options');
        return $query->row_array();
    }
    
    function getDictionary($type = false)
    {
        return $this->{$this->md}->getDictionary($type);
    }

}

