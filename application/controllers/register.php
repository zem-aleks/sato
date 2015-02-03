<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends Controller {

    public $md = 'mdl_main';

    function Register()
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
        $content['short_about']['short'] = word_limiter($content['short_about']['content'], 46);
        $content['articles'] = $this->load->module('articles')->getVerticalLastArticles('column3 second');
        $content['news'] = $this->load->module('news')->getVerticalLastArticles('column3 third');
        $content['levels'] = $this->load->module('levels')->getLastArticles();
        $content['wide_user_form'] = $this->load->module('users')->getWideUserForm();
        $content['page'] = 'main';
        $content['info'] = $this->load->module('pages')->getPageCHPU('main');
        $content['title'] = $content['info']['title'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];
        $content['schools'] = $this->load->module('schools')->getEntries($start, 18);

        $this->load->view('templates/header', $content);
        $this->load->view('templates/main', $content);
        $this->load->view('templates/footer', $content);
    }

}

?>