<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends Controller {

    public $name = 'pages';
    public $md = 'mdl_pages';

    function Pages() {
        parent::__construct();
        $this->load->model($this->md);
    }

    /* -----------------------admin function--------------------- */

    function admin_index($page = 0) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content = array();
        $content['title'] = 'Страницы';
        $content['key'] = 0;
        $content['pages'] = $this->mdl_pages->getAllPagesAdmin();

        $this->load->view('includes/admin_header', $content);
        $this->load->view('list', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    /* function addPage(){
      $content = array();
      $content['title'] = 'Страницы';
      $content['categories'] = $this->mdl_pages->getCatList();

      $this->load->view('includes/admin_header',$content);
      $this->load->view('add',$content);
      $this->load->view('includes/admin_footer',$content);
      } */

    function editPage($id_page) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content['title'] = 'Редактирование страницы';
        $content['page_info'] = $this->mdl_pages->getPageInfo($id_page);
        $content['categories'] = $this->mdl_pages->getCatList();
        $content['select_cat'] = $this->mdl_pages->getPageCat($id_page);

        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function edit($id_page) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->mdl_pages->edit($id_page)) {
            redirect('dashboard/pages');
        }
    }

    /* function add(){
      $this->mdl_pages->add();
      redirect('dashboard/pages');
      }

      function sort(){
      $this->mdl_pages->sort();
      }
      function status($id_cat, $status){
      if($this->{$this->md}->status($id_cat, $status)){
      redirect('dashboard/pages');
      }
      else {
      echo "no";
      }
      }
      function delPage($id){

      $this->{$this->md}->del($id);
      redirect('dashboard/pages');
      } */
    /* ----------------end admin functions---------------------- */

    function getPagesChpu() {
        return $this->{$this->md}->getPagesChpu();
    }

    function getPageCHPU($chpu) {
        return $this->{$this->md}->getPageCHPU($chpu);
    }
    
    function getPages()
    {
        return $this->{$this->md}->getPages();
    }

}

