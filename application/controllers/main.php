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
        $content['short_about'] = $this->load->module('pages')->getPageCHPU('about');
        $content['short_about']['short'] = word_limiter($content['short_about']['content'], 100);
        //$content['articles'] = $this->load->module('articles')->getVerticalLastArticles('column3 second');
        //$content['news'] = $this->load->module('news')->getVerticalLastArticles('column3 third');
        //$content['works'] = $this->load->module('portfolio')->getSlider(3, "Наши работы");
        //$content['services'] = $this->load->module('services')->getEntries(0, 50, 1);
        //$content['service_categories'] = $this->load->module('services')->getScategories();
        //$content['works'] = $this->load->module('portfolio')->getEntries(0, 8, 1);
        //$content['faq'] = $this->load->module('faq')->getSlider(6);
        
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