<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Schools extends Controller {
    
    public static $config = array(
        'name' => 'schools',
        'title' => 'Школы',
        'uri' => 'schools',
        'upload_folder' => 'schools',
        'tb' => 'schools',
        'perPage' => 20,
        'mainPage' => 'schools'
    );
    public static $md = 'mdl_schools';
    public static $colors = array('#eb2f23', '#f49100', '#959595', '#76b9c1', '#03941b', 
        '#7abd00', '#a61780', '#fad73f', '#325fa0', '#70b8e8', '#92462e');

    function Schools()
    {
        parent::__construct();
        $this->load->model(self::$md);
        $this->cmodel = $this->{self::$md};
        $this->cmodel->config = self::$config;
        $this->cmodel->tb = self::$config['tb'];
    }
    
    function getPricesBlock($customClass = '', $prices = array())
    {
        $content = array();
        if(!empty($prices))
            $content['prices'] = $prices;
        else {
            $query = $this->db->get('tbl_prices');
            $content['prices'] = $query->result_array();
        }
        $content['class'] = $customClass;
        return $this->load->view('prices', $content, true);
    }
    
    function getEntries($start = 0, $finish = 20, $status = 1) {
        $entries = $this->cmodel->getAllEntries($start, $finish, $status);
        foreach ($entries as &$entry) {
            $entry['metro_position'] = explode(',', $entry['metro_position']);
            if(empty($entry['color']))
                $entry['color'] = self::$colors[0];
            if(empty($entry['image']))
                $entry['image'] = 'no_image.jpg';
        }
        return $entries;
    }

    function index($start = 0)
    {
        $this->load->library('pagination');

        $content = $this->load->module('template')->loadDefaultData();
        $content['entries'] = $this->getEntries($start, self::$config['perPage']);
        $content['settings'] = $this->load->module('settings')->getListSettings();
        $content['page'] = $this->load->module('pages')->getPageCHPU(self::$config['name']);
        $content['title'] = $content['page']['name'];
        $content['description'] = $content['page']['mdesc'];
        $content['keywords'] = $content['page']['mkeys'];
        $content['breadcrumbs'][] = array('url' => '/' . self::$config['uri'], 'name' => self::$config['title']);
        $content['uri'] = self::$config['uri'];
        $content['upload_folder'] = self::$config['upload_folder'];
        $content['articles'] = $this->load->module('articles')->getVerticalLastArticles();
        $content['news'] = $this->load->module('news')->getVerticalLastArticles('sidebar-news');
        $content['show_icons'] = true;
        $content['page'] = self::$config['mainPage'];
        $content['user_form'] = $this->load->module('users')->getNarrowUserForm();
        
        $config['base_url'] = '/' . self::$config['uri'] . '/';
        $config['total_rows'] = $this->cmodel->getCount(1);
        $config['per_page'] = self::$config['perPage'];
        $config['first_link'] = $config['last_link'] = $config['next_link'] = $config['prev_link'] = '';
        $this->pagination->initialize($config);
        $content['paginator'] = $this->pagination->create_links();

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
        $content['view'] = $this->cmodel->getEntryByChpu($chpu);
        $content['view']['short'] = character_limiter($content['view']['content'], 500);
        if(empty($content['view']['image']))
            $content['view']['image'] = 'no_image.jpg';
        $content['breadcrumbs'] = array();
        $content['breadcrumbs'][] = array('url' => '/' . self::$config['uri'], 'name' => self::$config['title']);
        $content['breadcrumbs'][] = array('url' => $chpu, 'name' => $content['view']['name']);
        $content['settings'] = $this->load->module('settings')->getListSettings();
        $content['show_map'] = true;
        $content['uri'] = self::$config['uri'];
        $content['upload_folder'] = self::$config['upload_folder'];
        $content['title'] = $content['view']['title'];
        $content['description'] = $content['view']['mdesc'];
        $content['keywords'] = $content['view']['mkeys'];
        $content['wide_user_form'] = $this->load->module('users')->getWideUserForm('try-form on-school');
        $content['prices'] = $this->load->module('schools')->getPricesBlock('', json_decode($content['view']['prices'], TRUE));
        
        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('view', $content);
        $this->load->view('templates/footer', $content);
    }

    /* -----------------------admin function--------------------- */

    function admin_index($page = 0)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        } else {
            $content = array();
            $content['title'] = self::$config['title'];
            $content['uri'] = self::$config['uri'];
            $content['pages'] = $this->cmodel->getAllEntries();
            $content['upload_folder'] = self::$config['upload_folder'];

            $this->load->view('includes/admin_header', $content);
            $this->load->view('list', $content);
            $this->load->view('includes/admin_footer', $content);
        }
    }

    function addPage()
    {
        $content = array();
        $content['title'] = self::$config['title'];
        $content['uri'] = self::$config['uri'];
        $content['show_map'] = true;
        $content['settings']=$this->load->module('settings')->getListSettings();
        $content['form_action'] = 'dashboard/' . self::$config['uri'] . '/add';
        $content['colors'] = self::$colors;
        
        $query = $this->db->get('tbl_prices');
        $content['prices'] = $query->result_array();

        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function editPage($idPage)
    {
        $content = array();
        $content['title'] = self::$config['title'];
        $content['uri'] = self::$config['uri'];
        $content['upload_folder'] = self::$config['upload_folder'];
        $content['page'] = $this->cmodel->getEntryById($idPage);
        $content['show_map'] = true;
        $content['settings']=$this->load->module('settings')->getListSettings();
        $content['form_action'] = 'dashboard/' . self::$config['uri'] . '/edit/' . $idPage;
        $content['colors'] = self::$colors;
        $content['prices'] = json_decode($content['page']['prices'], TRUE);

        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function add()
    {
        $this->cmodel->add();
        redirect('dashboard/' . self::$config['uri']);
    }

    function edit($idPage)
    {
        if ($this->cmodel->edit($idPage) > 0)
            redirect('dashboard/' . self::$config['uri']);
        else
            redirect('dashboard/' . self::$config['uri'] . '/editPage/' . $id_page);
    }

    function sort()
    {
        $this->cmodel->sort();
    }

    function status($idPage, $status)
    {
        if ($this->cmodel->status($idPage, $status) > 0) {
            echo "yes";
        } else {
            echo "no";
        }
    }

    function delPage($id)
    {
        $this->cmodel->del($id);
        redirect('dashboard/' . self::$config['uri']);
    }

    /* ----------------end admin functions---------------------- */

    
}
