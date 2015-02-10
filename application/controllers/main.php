<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends Controller {

    public $md = 'mdl_main';

    function Main()
    {
        parent::__construct();
        session_start();
        $this->load->model($this->md);
    }

    function index()
    {
        $this->load->helper('text');
        $content = $this->load->module('template')->loadDefaultData();
        $content['about'] = $this->load->module('pages')->getPageCHPU('about');
        $content['models'] = $this->load->module('products')->getFilterEntries(0, 9, 1, array('on_main' => 1), 'c1.sort DESC');
        
        $content['page'] = 'main';
        $content['info'] = $this->load->module('pages')->getPageCHPU('main');
        $content['title'] = $content['info']['title'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];

        $this->load->view('templates/header', $content);
        $this->load->view('templates/main', $content);
        $this->load->view('templates/footer', $content);
    }

}

?>