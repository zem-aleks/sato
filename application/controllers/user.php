<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends Controller {


        function User(){
		parent::__construct();
                session_start();
	}
        
        
        
        function login()
        {
            $content = $this->load->module('template')->loadDefaultData();
            $content['title'] = 'Регистрация';
            $content['breadcrumbs'][]=array('url'=>'/user/login','name'=>'Регистрация');
            
            if($this->input->post('rollback') == 1)
                $content['data'] = $this->load->module('form')->postRegistration();
            
            $this->load->view('templates/header',$content);
            $this->load->view('templates/registration',$content);
            $this->load->view('templates/footer',$content);
        }
        
        function logout()
        {
            $this->load->module('users')->logout();
            header('Location: /');
        }
        
        
        function confirm($token)
        {
            $this->db->from('users');
            $this->db->where('token', $token);
            $this->db->where('status', 0);
            $query = $this->db->get();
            if($query->num_rows() <= 0){
                show_404();
                exit();
            }
            $user = $query->row_array();
            
            header('Content-Type: text/html; charset=utf-8');
            $this->load->module('cart')->loadCart();
            
            $data = array(
                'status' => 1,
                'token' => null,
                'cart' => isset($_SESSION['cart'])? $_SESSION['cart'] : null
            );
            $this->db->where('token', $token);
            $this->db->update('users', $data);
            
            $this->load->module('users')->processLogin($user);
            header('Location: /');
        }
        
        
        
        
        
        
        
}