<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Comments extends Controller {

    public $md = 'mdl_comments';
    public $cmodel = null;

    function Comments() {
        parent::__construct();
        $this->load->model($this->md);
        $this->cmodel = $this->mdl_comments;
    }

    function admin_index($page = 0) {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        } else {
            $per_page = 30;
            $content = array();
            $content['title'] = 'Обратная связь';
            $content['pages'] = $this->cmodel->getComments($per_page, $page);

            $this->load->library('pagination');
            $config['base_url'] = '/dashboard/comments/admin_index/';
            $config['total_rows'] = $this->countAllComments();
            $config['num_links'] = 5;
            $config['per_page'] = $per_page;
            $config['cur_page'] = $page;
            $config['first_link'] = 'Первая';
            $config['last_link'] = 'Последняя';
            $config['use_page_numbers'] = TRUE;
            $this->pagination->initialize($config);
            $content['paginator'] = $this->pagination->create_links();
            
            $this->load->view('includes/admin_header', $content);
            $this->load->view('list', $content);
            $this->load->view('includes/admin_footer', $content);
        }
    }

    function getComments($count, $page = 0) {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        return $this->cmodel->getComments($count, $page);
    }

    function addComment($name, $email, $phone, $question, $comment) {
        return $this->cmodel->addComment($name, $email, $phone, $question, $comment);
    }

    function countAllComments() {
        return $this->cmodel->countAllComments();
    }

    function editPage($id_page) {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
            
        $content['title'] = 'Комментарий (только для чтения)';
        $content['page_info'] = $this->cmodel->getPageInfo($id_page);

        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function delPage($id) {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        $this->cmodel->del($id);
        redirect('/dashboard/comments');
    }

    function status($id, $status) {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in)
            redirect('admin');
        if ($this->cmodel->status($id, $status)) {
            redirect('/dashboard/comments/editPage/' . $id);
        } else {
            echo "no";
        }
    }

}

?>