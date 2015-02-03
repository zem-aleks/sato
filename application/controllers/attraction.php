<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attraction extends Controller {

    public $md = 'mdl_main';

    function Attraction()
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
        $content['page'] = 'attraction';
        $content['info'] = $this->load->module('pages')->getPageCHPU('attraction');
        $content['title'] = $content['info']['title'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];
        $content['services'] = $this->load->module('services')->getEntries(0, 5, 1, 'attraction');

        $this->load->view('templates/header', $content);
        //$this->load->view('templates/breadcrumbs', $content);
        $this->load->view('templates/attraction', $content);
        $this->load->view('templates/footer', $content);
    }

}

?>