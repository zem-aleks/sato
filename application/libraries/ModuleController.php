<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ModuleController extends Controller{
    
    public static $md;
    public static $config;
    
    public function __construct($config, $md) {
        parent::__construct();
        $this->config = $config;
        $this->md = $md;
        $this->load->model($this->md);
        $this->{$this->md}->config = $this->config;
        $this->{$this->md}->tb = $this->config['tb'];
    }
    
    function index($start = 0)
    {
        $this->load->library('pagination');
        $content = $this->load->module('template')->loadDefaultData();
        $content['entries'] = $this->getEntries($start, $this->config['perPage'], 1);
        $content['settings'] = $this->load->module('settings')->getListSettings();
        $content['page'] = $this->load->module('pages')->getPageCHPU($this->config['name']);
        $content['page_info'] = $content['page'];
        $content['title'] = $content['page']['name'];
        $content['description'] = $content['page']['mdesc'];
        $content['keywords'] = $content['page']['mkeys'];
        $content['breadcrumbs'][] = array('url' => '/' . $this->config['uri'], 'name' => $this->config['title']);
        $content['uri'] = $this->config['uri'];
        $content['upload_folder'] = $this->config['upload_folder'];
        $content['page'] = $this->config['mainPage'];
        $content['paginator'] = $this->getPaginator($this->config['perPage']);
        $content = $this->modifyIndexContent($content);

        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('frontlist', $content);
        $this->load->view('templates/footer', $content);
    }
    
    function view($chpu)
    {
        $this->load->helper('text');
        $content = $this->load->module('template')->loadDefaultData();
        $content['page'] = self::$config['mainPage'];
        $content['view'] = $this->getEntryByChpu($chpu);
        if(empty($content['view']['image']))
            $content['view']['image'] = 'no_image.jpg';
        $content['breadcrumbs'] = array();
        $content['breadcrumbs'][] = array('url' => '/' . $this->config['uri'], 'name' => $this->config['title']);
        $content['breadcrumbs'][] = array('url' => '/' . $this->config['uri'] .'/view/'.$chpu, 'name' => $content['view']['name']);
        $content['settings'] = $this->load->module('settings')->getListSettings();
        $content['uri'] = self::$config['uri'];
        $content['upload_folder'] = self::$config['upload_folder'];
        $content['title'] = $content['view']['title'];
        $content['description'] = $content['view']['mdesc'];
        $content['keywords'] = $content['view']['mkeys'];
        $content['uri'] = $this->config['uri'];
        $content = $this->modifyViewContent($content);
        
        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('view', $content);
        $this->load->view('templates/footer', $content);
    }
    
    function getPaginator($limit, $uriSegment = 2){
        $config['base_url'] = '/' . $this->config['uri'] . '/';
        $config['total_rows'] = $this->{$this->md}->getCount(1);
        $config['per_page'] = $limit;
        $config['uri_segment'] = $uriSegment;
        $config['first_tag_open'] = $config['last_tag_open'] = '<div style="display:none;">';
        $config['first_tag_close'] = $config['last_tag_close'] =  '</div>';
        $config['first_link'] = $config['last_link'] = $config['next_link'] = $config['prev_link'] = '';
        $config['next_link'] = '>';
        $config['prev_link'] = '<';
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
    }
    
    function getEntries($start = 0, $finish = 50, $status = -1) {
        $entries = $this->{$this->md}->getAllEntries($start, $finish, $status);
        foreach ($entries as &$entry)
            $entry = $this->modifyEntry($entry);
        return $entries;
    }
    
    function getFilterEntries($start, $limit, $status, $filter, $order = 'c1.sort') {
        $entries = $this->{$this->md}->getFilterEntries($start, $limit, $status, $filter, $order);
        foreach ($entries as &$entry)
            $entry = $this->modifyEntry($entry);
        return $entries;
    }
    
    function getEntryByChpu($chpu) {
        $entry = $this->{$this->md}->getEntryByChpu($chpu);
        return $this->modifyEntry($entry);
    }
    
    function getEntryById($id) {
        $entry = $this->{$this->md}->getEntryById($id);
        return $this->modifyEntry($entry);
    }
    
    function modifyEntry($entry){
        return $entry;
    }
    
    function modifyIndexContent($content) {
        return $content;
    }
    
    function modifyAdminIndexContent($content) {
        return $content;
    }
    
    function modifyAdminAddContent($content) {
        return $content;
    }
    function modifyAdminEditContent($content) {
        return $this->modifyAdminAddContent($content);
    }
            
    function modifyViewContent($content) {
        return $content;
    }
    
    function makeBreadcrumbsEntry($url, $name) {
        return array('url' => $url, 'name' => $name);
    }
    
    /* -----------------------admin function--------------------- */

    function admin_index($page = 0)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        } else {
            $content = array();
            $content['title'] = $this->config['title'];
            $content['uri'] = $this->config['uri'];
            $content['pages'] = $this->{$this->md}->getAllEntries();
            $content['upload_folder'] = $this->config['upload_folder'];
            $content = $this->modifyAdminIndexContent($content);

            $this->load->view('includes/admin_header', $content);
            $this->load->view('list', $content);
            $this->load->view('includes/admin_footer', $content);
        }
    }
    
    function addPage()
    {
        $content = array();
        $content['title'] = $this->config['title'];
        $content['uri'] = $this->config['uri'];
        $content['upload_folder'] = $this->config['upload_folder'];
        $content['page'] = array();
        $content['form_action'] = 'dashboard/' . $this->config['uri'] . '/add';
        $content['settings'] = Modules::run('settings/getListSettings');
        $content = $this->modifyAdminAddContent($content);

        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }
    
    function editPage($idPage)
    {
        $content['title'] = $this->config['title'];
        $content['uri'] = $this->config['uri'];
        $content['upload_folder'] = $this->config['upload_folder'];
        $content['page'] = $this->{$this->md}->getEntryById($idPage);
        $content['form_action'] = 'dashboard/' . $this->config['uri'] . '/edit/' . $idPage;
        $content['settings'] = Modules::run('settings/getListSettings');
        $content = $this->modifyAdminEditContent($content);

        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }
    
    function add()
    {
        $this->{$this->md}->add();
        redirect('dashboard/' . $this->config['uri']);
    }

    function edit($idPage)
    {
        if ($this->{$this->md}->edit($idPage) > 0)
            redirect('dashboard/' . $this->config['uri']);
        else
            redirect('dashboard/' . $this->config['uri'] . '/editPage/' . $id_page);
    }

    function sort()
    {
        $this->{$this->md}->sort();
    }

    function status($idPage, $status)
    {
        if ($this->{$this->md}->status($idPage, $status) > 0) {
            echo "yes";
        } else {
            echo "no";
        }
    }

    function delPage($id)
    {
        $this->{$this->md}->del($id);
        redirect('dashboard/' . $this->config['uri']);
    }

    /* ----------------end admin functions---------------------- */
    
}