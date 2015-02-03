<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cards extends Controller {

    var $tb = 'cards';
    var $md = 'mdl_cards';

    function Cards() {
        parent::__construct();
        $this->load->model($this->md);
    }

    function admin_index($cat_id = '', $start_row = 0, $sort_field = '', $fs = '') {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        } else {
            $content = array();
            $content ['cards'] = $this->{$this->md}->getAllPagesAdmin();
            $this->load->view('includes/admin_header', $content);
            $this->load->view('list', $content);
            $this->load->view('includes/admin_footer', $content);
        }
    }

    function addPage() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content = array();
        $content['title'] = 'Банковские карточки';

        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function editPage($id_page) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content['title'] = 'Банковские карточки';
        $content['page_info'] = $this->{$this->md}->getPageInfo($id_page);
        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function add() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->{$this->md}->add();
        redirect('dashboard/cards');
    }

    function edit($id_page) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->edit($id_page))
            redirect('dashboard/cards');
        else
            redirect('dashboard/cards/editPage/' . $id_page);
    }

    function sort() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->{$this->md}->sort();
    }

    function status($id_cat, $status) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->status($id_cat, $status)) {
            redirect('dashboard/cards');
        } else {
            echo "no";
        }
    }

    function delPage($id) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->{$this->md}->del($id);
        redirect('dashboard/cards');
    }

    function getCards() {
        return $this->{$this->md}->getCards();
    }

}

?>