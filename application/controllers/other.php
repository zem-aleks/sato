<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Other extends Controller {

    public $md = 'mdl_main';

    function Other()
    {
        parent::__construct();
        session_start();
        $this->load->model($this->md);
    }

    function index()
    {
        $this->load->helper('text');
        $content = $this->load->module('template')->loadDefaultData();
        $content['works'] = $this->load->module('portfolio')->getSlider(3, "Примеры работ");
        $content['page'] = 'other';
        $content['info'] = $this->load->module('pages')->getPageCHPU('other');
        $content['title'] = $content['info']['title'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];
        $content['breadcrumbs'][] = array('url' => '/other', 'name' => "Другие услуги");

        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('templates/other', $content);
        $this->load->view('templates/footer', $content);
    }

}

?>