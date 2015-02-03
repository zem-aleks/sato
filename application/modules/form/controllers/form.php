<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Form extends Controller {

	private static $md = 'mdl_form';

	function Form(){
            parent::__construct();
            session_start();
            $this->load->model(self::$md);
	}
        
        
        function postSortingItems()
        {
            $order = 'DESC';
            if(isset($_POST['order']) && ($_POST['order'] == 'ASC' || $_POST['order']== 'DESC')) {
                $order = $_POST['order'];
                $this->load->helper('cookie');
                $cookie = array(
                    'name'   => 'order',
                    'value'  => $order,
                    'expire' => '86500',
                    'domain' => '.helen-style.com.ua',
                    'path'   => '/'
                );

                set_cookie($cookie);
            }
            elseif(isset($_COOKIE['order']))
                $order = $_COOKIE['order'];
            return $order;
        }
        
        
        function postChangeCurrency()
        {
            $order = 'UAH';
            if(isset($_POST['currency']) && ($_POST['currency'] == 'UAH' || $_POST['currency']== 'USD')) {
                $order = $_POST['currency'];
                $this->load->helper('cookie');
                $cookie = array(
                    'name'   => 'currency',
                    'value'  => $order,
                    'expire' => '86500',
                    'domain' => '.helen-style.com.ua',
                    'path'   => '/'
                );

                set_cookie($cookie);
            }
            elseif(isset($_COOKIE['currency']))
                $order = $_COOKIE['currency'];
            return $order;
        }
        
        
        function postRegistration()
        {
            $reg = array();
            $errors = array();
            
            $reg['login'] = $this->input->post('login', TRUE);
            $reg['name'] = $this->input->post('name', TRUE);
            $reg['password'] = $this->input->post('password', TRUE);
            $reg['email'] = $this->input->post('email', TRUE);
            $reg['phone'] = $this->input->post('phone', TRUE);
            
            $this->db->select('ID');
            $this->db->from('users');
            $this->db->where('login', $reg['login']);
            $query = $this->db->get();
            if($query->num_rows() > 0)
                $errors[] = 'Пользователь с таким логином уже существует!';
            
            $this->db->select('ID');
            $this->db->from('users');
            $this->db->where('email', $reg['email']);
            $query = $this->db->get();
            if($query->num_rows() > 0)
                $errors[] = 'Пользователь с таким почтовым ящиком уже существует!';
            
            foreach($reg as $value)
            {
                if(empty($value)){
                    $errors[] = 'Не все поля заполнены!';
                    break;
                }
            }
            
            if (count($errors) <= 0) {
                $reg['token'] = md5('helen'.$reg['login'].date('Y-m-d H:i:s').'style'.rand(-100,100));
                $reg['password'] = crypt($reg['password'], 'Соль');
                
                $this->db->insert('users', $reg);
                header('Content-Type: text/html; charset=utf-8');
                $msg = 
                        'Здравствуйте, '.$reg['name'].'. Вами была заполнена 
                        регистрационная форма. Чтобы завершить регистрацию
                        пройдите по следующей ссылке: 
                        <a href="http://'.$_SERVER['HTTP_HOST'].'/user/confirm/'.$reg['token'].'">
                        '.$_SERVER['HTTP_HOST'].'/user/confirm/'.$reg['token'].'
                        </a>';
                
                mail($reg['email'], 'Регистрация на helen-style.com.ua', $msg);
                
                $this->db->where('email', $reg['email']);
                $this->db->from('delivery');
                $query = $this->db->get();
                if($query->num_rows() == 0)
                    $this->db->insert('delivery', array('email' => $reg['email']));
                return array('status' => 'ok');  
            } else 
                return array('reg' => $reg, 'errors' => $errors);  
        }
	

}

