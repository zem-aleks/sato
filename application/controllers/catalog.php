<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Catalog extends Controller {


    function Main()
    {
        parent::__construct();
        session_start();
    }

    function index()
    {
        $this->load->helper('text');
        $content = $this->load->module('template')->loadDefaultData();
        $content['about'] = $this->load->module('pages')->getPageCHPU('about');
        $content['page'] = 'catalog';
        $content['info'] = $this->load->module('pages')->getPageCHPU('catalog');
        $content['title'] = $content['info']['title'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];

        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('templates/catalog', $content);
        $this->load->view('templates/footer', $content);
    }

}

?>