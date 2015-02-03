<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Prices extends Controller {
    
    public static $settings = array(
        'model'     => 'cmodel', // name of model
        'name'      => 'Entry', // name of module
        'per_page'  => 10,
    );

    function Prices()
    {
        parent::__construct();
        $this->load->model(self::$model);
    }
    
    /* -----------------------admin function--------------------- */

    function admin_index($page = 0)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) 
            redirect('admin');
        
        $content = array();
        $content['title'] = 'Уровни подготовки';
        $content['key'] = 0;
        $content['pages'] = $this->cmodel->getAllPagesAdmin();

        $this->load->view('includes/admin_header', $content);
        $this->load->view('list', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function addPage()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        $content = array();
        $content['title'] = 'Контент';
        //$content['categories'] = $this->mdl_recipe->getCatList();

        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function editPage($id_page)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        $content['title'] = 'Редактирование контента';
        $content['page_info'] = $this->cmodel->getPageInfo($id_page);

        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function add()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        $this->cmodel->add();
        redirect('dashboard/levels');
    }

    function edit($id_page)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        
        if ($this->cmodel->edit($id_page))
            redirect('dashboard/levels');
        else
            redirect('dashboard/levels/editPage/' . $id_page);
    }

    function sort()
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        $this->cmodel->sort();
    }

    function status($id_page, $status)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        if ($this->cmodel->status($id_page, $status)) {
            $article = $this->cmodel->getPageInfo($id_page);
        } else {
            echo "no";
        }
    }

    function delPage($id)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        $this->cmodel->del($id);
        redirect('dashboard/levels');
    }

    /* ----------------end admin functions---------------------- */

}
