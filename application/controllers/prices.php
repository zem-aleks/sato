<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prices extends Controller {

    public $md = 'mdl_main';

    function Prices()
    {
        parent::__construct();
        session_start();
        $this->load->model($this->md);
    }

    function index()
    {
        $this->load->helper('text');
        $content = $this->load->module('template')->loadDefaultData();
        $content['short_about'] = $this->load->module('pages')->getPageCHPU('prices');
        $content['page'] = 'prices';
        $content['info'] = $this->load->module('pages')->getPageCHPU('prices');
        $content['title'] = $content['info']['title'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];
        $content['breadcrumbs'] = array();
        $content['breadcrumbs'][] = array('url' => '/prices', 'name' => "Цены");
        $content['prices'] = $this->_getPrices(false);
        $content['wide_user_form'] = $this->load->module('users')->getWideUserForm('try-form shadow for-level');

        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('templates/prices', $content);
        $this->load->view('templates/footer', $content);
    }
    
    function _getPrices($escape = true)
    {
        $query = $this->db->get('tbl_prices');
        $prices = $query->result_array();
        $result = array();
        foreach ($prices as $price)
            if($escape)
                $result[$price['ID']] = htmlspecialchars ($price['price']);
            else
                $result[$price['ID']] = $price['price'];
        return $result;
    }
    
    function admin_index()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) 
            redirect('admin');
        
        if(isset($_POST['prices'])) {
            foreach ($_POST['prices'] as $id => $row) {
                $this->db->where('ID', $id);
                $this->db->update('tbl_prices', array('price' => $row));
            }
        }
        
        $content = array();
        $content['title'] = 'Уровни подготовки';
        $content['prices'] = $this->_getPrices();

        $this->load->view('includes/admin_header', $content);
        $this->load->view('includes/prices', $content);
        $this->load->view('includes/admin_footer', $content);
    }

}

?>