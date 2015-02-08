<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Page extends Controller {

    function Page() {
        parent::__construct();
        session_start();
    }

    function _remap($method) {
        $pagesNames = array();
        $pagesNames = $this->load->module('pages')->getPagesChpu();
        if ($method == 'index')
            show_404();
        elseif (in_array($method, $pagesNames))
            $this->index($method);
        else
            show_404();
    }

    function index($chpu, $params) {
        $this->load->library('form_validation');
        $config = $this->_getMessageConfig();
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $content = $this->load->module('template')->loadDefaultData();
            $content['errors'] = validation_errors();
            $content['page'] = $chpu;
            $content['view'] = $this->load->module('pages')->getPageCHPU($chpu);
            $content['title'] = $content['view']['title'];
            if (empty($content['title']))
                $content['title'] = $content['view']['name'];
            $content['description'] = $content['view']['mdesc'];
            $content['keywords'] = $content['view']['mkeys'];
            $content['breadcrumbs'] = array();
            $content['breadcrumbs'][] = array('url' => '/page/' . $chpu, 'name' => $content['view']['name']);
            $content['settings'] = $this->load->module('settings')->getListSettings();
            $this->load->view('templates/header', $content);
            $this->load->view('templates/breadcrumbs', $content);
            if ($content['view']['chpu'] == 'contacts') {
                $this->load->view('templates/contacts', $content);
            } elseif($content['view']['chpu'] == 'register') {
                parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
                $idSchool = (int)$_GET['school'];
                $idLevel = (int)$_GET['level'];
                $this->load->view('templates/page', $content);
                $this->load->module('users')->getWideUserForm('try-form on-school', false, $idSchool, $idLevel);
            }else {
                $this->load->view('templates/page', $content);
            }
            $this->load->view('templates/footer', $content);
            
        } else {
            $settings = $this->load->module('settings')->getListSettings();
            $name = $this->input->post('name', TRUE);
            $email = $this->input->post('email', TRUE);
            $phone = $this->input->post('phone', TRUE);
            $question = $this->input->post('question', TRUE);
            $comment = $this->input->post('comment', TRUE);
            $id = $this->load->module('comments')->addComment($name, $email, $phone, $question, $comment);
            
            //$this->load->module('users')->addUser($name, $phone, $email, '', 1);
            $text = 'Уважаемый администратор, к вам пришло новое сообщение №'.$id.' через 
                форму обратной связи. Чтобы его просмотреть зайдите в 
                <a href="'.base_url().'dashboard/comments">модуль обратной связи</a> 
                или перейдите по следующей ссылке:<br/>
                <a href="'.base_url().'dashboard/comments/editPage/'.$id.'">ссылка на сообщение</a>';
            
            $this->load->module('mail')->sendMessage($settings['emailContact'], 'Новое сообщение на Interactis.ru', $text);
            $_SESSION['success'] = 1;
            redirect('/page/' . $chpu);
        }
    }

    function _getMessageConfig() {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Имя',
                'rules' => 'trim|alpha|required|min_length[2]|max_length[255]|xss_clean'
            ),
            array(
                'field' => 'phone',
                'label' => 'Телефон',
                'rules' => 'trim|min_length[6]|max_length[255]|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'question',
                'label' => 'Вопрос',
                'rules' => 'trim|required|min_length[4]|xss_clean'
            ),
            array(
                'field' => 'comment',
                'label' => 'Комментарий',
                'rules' => 'trim|xss_clean'
            )
        );

        return $config;
    }

}