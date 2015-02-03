<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slider extends Controller {

    var $tb = 'slider';
    var $md = 'mdl_slider';

    function Slider() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model($this->md);
    }

    function admin_index($cat_id = '', $start_row = 0, $sort_field = '', $fs = '') {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content = array();
        $content['title'] = 'Слайдер';
        $content['slider'] = $this->{$this->md}->getlist();

        $this->load->view('includes/admin_header', $content);
        $this->load->view('list', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function getSImages() {
        return $this->{$this->md}->getSImages();
    }

    function add($something = '', $error = '') {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content['title'] = 'Добавление изображения';
        $content['error'] = $error;
        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function edit($id, $something = '', $error = '') {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content['title'] = 'Редактирование изображения';
        $content['slider'] = $this->{$this->md}->getImage($id);
        $content['error'] = $error;

        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function del($id) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->{$this->md}->del($id);
        redirect('dashboard/slider');
    }

    function addImage() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->add()) {
            redirect('dashboard/slider');
        } else {
            $this->add('', 'Ошибка загрузки изображения. 
                        Изображение должно быть формата jpg,png или gif,
                        разрещением не более 2000х2000 пк. 
                        и размером не более 2 мб.');
        }
    }

    function editImage($id) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->edit($id)) {
            redirect('dashboard/slider');
        } else {
            $this->edit($id, '', 'Ошибка загрузки изображения. 
                        Изображение должно быть формата jpg,png или gif,
                        разрещением не более 2000х2000 пк. 
                        и размером не более 2 мб.');
        }
    }

    function status($id, $status) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->status($id, $status)) {
            redirect('dashboard/slider');
        } else {
            echo "no";
        }
    }

    function sort() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->{$this->md}->sort();
    }

}