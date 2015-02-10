<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends Controller {

    var $name = 'users';
    var $md = 'mdl_users';
    var $per_page = 20;

    function Users() {
        parent::__construct();
        $this->load->model($this->md);
    }
    
    function getWideUserForm($customClass = 'try-form shadow', $return = true, $idSchool = 0, $idLevel = 0)
    {
        $content = array(
            'class'  => $customClass,
            'levels'  => $this->load->module('levels')->getLastArticles(),
            'schools' => $this->load->module('schools')->getEntries(),
            'id_level' => $idLevel,
            'id_school' => $idSchool,
        );
        return $this->load->view('wideUserForm', $content, $return);
    }
    
    function getNarrowUserForm($customClass = '')
    {
        $content = array(
            'class'  => $customClass,
            'levels'  => $this->load->module('levels')->getLastArticles(),
            'schools' => $this->load->module('schools')->getEntries()
        );
        return $this->load->view('narrowUserForm', $content, true);
    }

    function admin_index($page = 0) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }

        $content = array();
        $content['title'] = 'Пользователи';
        $per_page = 20;

        $content['search'] = false;
        $content['str'] = $this->input->post('str');
        if (!empty($content['str']))
            $content['search'] = $this->{$this->md}->findUser($content['str']);

        $this->load->model('admin/mdl_admin');
        $content['member'] = $this->mdl_admin->get_member_details();

        $content['users'] = $this->{$this->md}->getAllPagesAdmin($page / $per_page, $per_page);
        foreach ($content['users'] as $key => &$value) {
            switch ($value['type']) {
                case 'attraction':
                    $value['type'] = 'Привлечение клиентов';
                    break;
                case 'creation':
                    $value['type'] = "Создание сайта";
                    break;
                case 'other':
                    $value['type'] = 'Другие услуги';
                    break;
                default:
                    break;
            }
        }
        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/users/admin_index/';
        $config['total_rows'] = $this->{$this->md}->getAllPagesCount();
        $config['num_links'] = 5;
        $config['per_page'] = $per_page;
        $config['cur_page'] = $page;
        $config['first_link'] = 'Первая';
        $config['last_link'] = 'Последняя';
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $content['paginator'] = $this->pagination->create_links();

        $this->load->view('includes/admin_header', $content);
        $this->load->view('info', $content);
        $this->load->view('includes/admin_footer', $content);
    }
    
    function addUserShort($name, $email, $status = 1)
    {
        $idUser = 0;
        $userData = array(
            'name' => $name,
            'email' => $email,
            'status' => $status,
        );
        $this->db->select('ID');
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if (false) {
            $user = $query->row_array();
            $this->db->where('ID', $user['ID']);
            $this->db->update('users', $userData);
            $idUser = $user['ID'];
        } else {
            $this->db->insert('users', $userData);
            $idUser = $this->db->insert_id();
        }

        return $idUser;
        
    }

    function addUser($name, $phone, $email, $address = '', $status = 1) {
        $idUser = 0;
        $userData = array(
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'status' => $status,
            'address' => $address
        );
        $this->db->select('ID');
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $user = $query->row_array();
            $this->db->where('ID', $user['ID']);
            $this->db->update('users', $userData);
            $idUser = $user['ID'];
        } else {
            $this->db->insert('users', $userData);
            $idUser = $this->db->insert_id();
        }

        return $idUser;
    }

    function export() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->load->module('export')->exportFile('users', array('ID', 'name', 'email', 'phone', 'address'));
    }

    function _edit($id_user, $contacts = array()) {
        $data = array(
            'name' => $this->input->post('uname'),
            'surname' => $this->input->post('usurname'),
            'email' => $this->input->post('uemail'),
            'phone' => $this->input->post('uphone'),
        );
        $this->db->where('ID', $id_user);
        $this->db->update('users', $data);

        /* $cdata = $this->input->post('contacts');
          foreach ($contacts as $value) {
          $data = array(
          'name' => $cdata[$value['type']]['name'],
          'surname' => $cdata[$value['type']]['surname'],
          'email' => $cdata[$value['type']]['email'],
          'phone' => $cdata[$value['type']]['phone'],
          'street' => $cdata[$value['type']]['street'],
          'house' => $cdata[$value['type']]['house'],
          'room' => $cdata[$value['type']]['room'],
          'city' => $cdata[$value['type']]['city'],
          'district' => $cdata[$value['type']]['district']
          );

          $this->db->where('id_user', $id_user);
          $this->db->where('type', $value['type']);
          $this->db->update('users_address', $data);
          } */

        header('Location: /dashboard/users/edit/' . $id_user);
    }

    function edit($id_user) {

        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content = array();
        $content['user'] = $this->{$this->md}->getUser('ID', $id_user);
        //$content['contacts'] = $this->{$this->md}->getUserContacts($id_user);

        if (isset($_POST['uname']))
            $this->_edit($id_user, $content['contacts']);

        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function del($id_user) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->db->where('ID', $id_user);
        ;
        $this->db->delete('users');
        header('Location: /dashboard/users');
    }

    function _writeToUser($type, $message, $user) {
        $result = array();
        $result['status'] = 0;
        $result['detail'] = 'not send';
        $types = array('sms', 'email');
        if (in_array(trim($type), $types) && !empty($message)) {
            if ($type == 'email' && !empty($user['email'])) {
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                //$headers .= 'From: Интерактис <no_reply@interactis.ru>' . "\r\n";
                mail($user['email'], 'Интерактис', $message, $headers);
            } elseif ($type == 'sms' && !empty($user['phone'])) {
                // отправка сообщения
                $this->load->helper('sms');
                $account = getAccount();
                sms_send($account['login'], $account['password'], $account['from'], $user['phone'], $message);
            } else {

                $result['status'] = -2;
                $result['detail'] = 'not valid user data';
            }
        } else {
            $result['status'] = -1;
            $result['detail'] = 'not valid input data';
        }

        return $result;
    }

    function writeAll() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
    }

    function write($id_user) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content = array();
        $content['user'] = $this->{$this->md}->getUser('ID', (int) $id_user);

        if ($this->input->post('rollback') == 1)
            $content['info'] = $this->_writeToUser($this->input->post('type'), $this->input->post('message'), $content['user']);

        $this->load->view('includes/admin_header', $content);
        $this->load->view('message', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function auth() {
        if (isset($_SESSION['user']['ID']) && $_SESSION['user']['ID'] > 0)
            return true;
        elseif (isset($_COOKIE['hash'])) {
            $this->db->from('users');
            $this->db->where('hash', $_COOKIE['hash']);
            $query = $this->db->get();
            if ($query->num_rows > 0) {
                $user = $query->row_array();
                $this->processLogin($user);
            }
            else
                return false;
        }
        else
            return false;
    }

    function login($login, $password) {
        $this->db->from('users');
        $this->db->where('login', $login);
        $this->db->where('password', crypt($password, 'Соль'));
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $user = $query->row_array();
            $this->processLogin($user);
            return true;
        }
        else
            return false;
    }

    function logout() {
        unset($_SESSION['user']);
        $this->load->helper('cookie');
        set_cookie('hash', null, 0, $_SERVER['SERVER_NAME'], '/');
    }

    function processLogin($user) {
        $hash = sha1($user['email'] . 'mega' . date('Y-m-d H:i:s'));
        $this->db->where('ID', $user['ID']);
        $this->db->update('users', array('hash' => $hash));
        unset($user['password']);
        $_SESSION['user'] = $user;
        $this->load->helper('cookie');
        set_cookie('hash', $hash, 60 * 60 * 24 * 14, $_SERVER['SERVER_NAME'], '/');
    }

}