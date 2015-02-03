<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Levels extends Controller {

    public $name = 'levels';
    public $md = 'mdl_levels';
    public $cmodel = null;

    function Levels()
    {
        parent::__construct();
        $this->load->model($this->md);
        $this->cmodel = $this->mdl_levels;
    }

    function index($start = 0)
    {
        $content = $this->load->module('template')->loadDefaultData();
        $content['levels'] = $this->load->module('levels')->getLastArticles();
        $content['page'] = 'levels';
        $content['settings'] = $this->load->module('settings')->getListSettings();
        $content['articles'] = $this->load->module('articles')->getVerticalLastArticles();
        $content['info'] = $this->load->module('pages')->getPageCHPU('levels');
        $content['title'] = $content['info']['name'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];
        $content['breadcrumbs'][] = array('url' => '/courses', 'name' => 'Уровни подготовки');
        $content['user_form'] = $this->load->module('users')->getNarrowUserForm();

        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('frontlist', $content);
        $this->load->view('templates/footer', $content);
    }
    
    function view($chpu) 
    {
        $content = $this->load->module('template')->loadDefaultData();
        $content['page'] = 'levels';
        $content['level'] = $this->getArticle($chpu);
        $query = $this->db->get('tbl_prices');
        $content['prices'] = $query->result_array();
        $content['breadcrumbs'] = array();
        $content['breadcrumbs'][] = array('url' => '/levels', 'name' => 'Уровни подготовки');
        $content['breadcrumbs'][] = array('url' => $chpu, 'name' => 'Уровень ' . $content['level']['name']);
        $content['settings'] = $this->load->module('settings')->getListSettings();
        $content['title'] = $content['level']['title'];
        $content['description'] = $content['level']['mdesc'];
        $content['keywords'] = $content['level']['mkeys'];
        $content['wide_user_form'] = $this->load->module('users')->getWideUserForm('try-form shadow for-level');
        $content['prices'] = $this->load->module('schools')->getPricesBlock('for-level');
        
        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('view', $content);
        $this->load->view('templates/footer',$content);
    }
    
    function getArticle($chpu)
    {
        return $this->cmodel->getPageCHPU($chpu);
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
    
    function getLastArticles()
    {
        return $this->cmodel->getLastNews(20);
    }

    /* ----------------end admin functions---------------------- */

}
