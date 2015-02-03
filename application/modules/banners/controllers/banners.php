<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Banners extends Controller {

    var $tb = 'banners';
    var $md = 'mdl_banners';

    function Banners() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model($this->md);
    }

    function admin_index($cat_id = '', $start_row = 0, $sort_field = '', $fs = '') {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        } else {
            $content = array();
            $content['title'] = 'Баннеры';
            $content['banners'] = $this->{$this->md}->getlist();
            $content['categories'] = $this->load->module('category')->getCategoryList();
            $this->load->view('includes/admin_header', $content);
            $this->load->view('list', $content);
            $this->load->view('includes/admin_footer', $content);
        }
    }

    function getBanners() {
        return $this->mdl_banners->getBanners();
    }

    function getBanner($id) {
        return $this->mdl_banners->getBanner($id);
    }

    function getBannerOfPage($id_page) {
        return $this->mdl_banners->getBannerOfPage($id_page);
    }

    function add() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content['title'] = 'Добавление баннера';
        $content['categories'] = $this->load->module('category')->getCategoryList();
        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function edit($id) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content['title'] = 'Редактирование баннера';
        $content['banner'] = $this->{$this->md}->getBanner($id);
        $content['categories'] = $this->load->module('category')->getCategoryList();
        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function delBanner($id) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->{$this->md}->del($id);
        redirect('dashboard/banners');
    }

    function addBanner() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->add()) {
            redirect('dashboard/banners');
        } else {
            echo "no";
        }
    }

    function editBanner($id) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->edit($id)) {
            redirect('dashboard/banners');
        } else {
            echo "no";
        }
    }

    function status($id, $status) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->status($id, $status)) {
            redirect('dashboard/banners');
        } else {
            echo "no";
        }
    }

}