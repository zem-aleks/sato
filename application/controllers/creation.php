<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Creation extends Controller {

    public $md = 'mdl_main';

    function Creation()
    {
        parent::__construct();
        session_start();
        $this->load->model($this->md);
    }

    function index()
    {
        $this->load->helper('text');
        $content = $this->load->module('template')->loadDefaultData();
        $content['works'] = $this->load->module('portfolio')->getEntries(0, 9, 1);
        $content['page'] = 'creation';
        $content['info'] = $this->load->module('pages')->getPageCHPU('creation');
        $content['services'] = $this->load->module('services')->getEntries(0, 4, 1, 'creation');
        
        $content['title'] = $content['info']['title'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];

        $this->load->view('templates/header', $content);
        //$this->load->view('templates/breadcrumbs', $content);
        $this->load->view('templates/creation', $content);
        $this->load->view('templates/footer', $content);
    }

}

?>