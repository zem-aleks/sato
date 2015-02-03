<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class lib_auth {
	
	var $CI;
    
    var $md = 'mdl_users';
	
	function lib_auth () {
		
		$this->CI = & get_instance ();
	}
	
	
	/**
 	* Авторизация админа
 	*/
	function authAdmin ($login, $pass) {	   

        $admin = $this->CI->{$this->md}->checkAdmin($login);
        
		if ($admin['login'] == $login && $admin['pass'] == $this->CI->{$this->md}->getPass($pass)) {
		  
				//Запись данных в сессию
				$mdstr = $this->CI->{$this->md}->getHash($admin['pass']);			
				unset($admin['pass']);
                
                $this->CI->{$this->md}->setonline($admin['user_id']);
                
                

				$this->CI->session->set_userdata(
					array (
                    
                    'logged_in' => TRUE,
					
					'user' => $admin,
					//Хеш для жёсткой проверки
					'user_hash' => $mdstr
					
					)                    
				);
                
			return TRUE;
		}
		elseif($journalist = $this->CI->{$this->md}->checkJournalist($login)){
			if ($journalist['login'] == $login && $journalist['pass'] == $this->CI->{$this->md}->getPass($pass)) {
			  
					//Запись данных в сессию
					$mdstr = $this->CI->{$this->md}->getHash($journalist['pass']);			
					unset($journalist['pass']);
	                
	                $this->CI->{$this->md}->setonline($journalist['user_id']);
	                
	                
	
					$this->CI->session->set_userdata(
						array (
	                    
	                    'logged_in' => TRUE,
						
						'user' => $journalist,
						//Хеш для жёсткой проверки
						'user_hash' => $mdstr
						
						)                    
					);
	                
				return TRUE;
			}           
			else{
				return FALSE;
			}
			
		}
        //журналист для английской версии
        elseif($journalist_en = $this->CI->{$this->md}->checkJournalistEn($login)){
			if ($journalist_en['login'] == $login && $journalist_en['pass'] == $this->CI->{$this->md}->getPass($pass)) {
			  
					//Запись данных в сессию
					$mdstr = $this->CI->{$this->md}->getHash($journalist_en['pass']);			
					unset($journalist_en['pass']);
	                
	                $this->CI->{$this->md}->setonline($journalist_en['user_id']);
	                
	                
	
					$this->CI->session->set_userdata(
						array (
	                    
	                    'logged_in' => TRUE,
						
						'user' => $journalist_en,
						//Хеш для жёсткой проверки
						'user_hash' => $mdstr
						
						)                    
					);
	                
				return TRUE;
			} 
  	         else{
				return FALSE;
			}
			
		}
		else {
			
			return FALSE;
			
		}
		
	}
    
    
    /**
 	* Авторизация админа
 	*/
	function authUser ($login, $pass) {
        
        $user = $this->CI->{$this->md}->checkUser($login);
        
		if ($user['login'] == $login && $user['pass'] == $this->CI->{$this->md}->getPass($pass)) {
		  
				//Запись данных в сессию
				$mdstr = $this->CI->{$this->md}->getHash($user['pass']);			
				unset($user['pass']);
                
                
                $this->CI->{$this->md}->setonline($user['user_id']);
                
                $this->CI->lib_cache->delete_all('live');
                $this->CI->lib_cache->delete_all('blog');
                
				$this->CI->session->set_userdata(
					array (
                    
                    'logged_in' => TRUE,
					
					'user' => $user,
					//Хеш для жёсткой проверки
					'user_hash' => $mdstr
					
					)                    
				);
                
			return TRUE;
		}
		
		else {
			
			return FALSE;
			
		}
		
	}
    
    
	
	/**
	 * Проверка вошёл ли как администратор
	 */
	function checkAdmin () {
		if($this->CI->dx_auth->is_logged_in() && $this->CI->dx_auth->is_admin()){
			return true;
		}
		else {
			redirect ('auth/login');
		}
	}
    
    
    function checkUser () {
    	if($this->CI->dx_auth->is_logged_in()){
			return $this->CI->session->all_userdata();
		}
		else {
			return false;
		}
	}
    
    function check() {
        
        $user = $this->CI->session->userdata('user');
		
		if ($this->CI->session->userdata('logged_in') && $user['login'] != '') {
		  
            $this->CI->load->model($this->md);       
            $user = $this->CI->{$this->md}->checkUser($user['login']);
			
			$mdstr = $this->CI->{$this->md}->getHash($user['pass']);		
			
			if ($this->CI->session->userdata('user_hash') == $mdstr) {
               
                return true;	
			}
			else {
				return FALSE;
			}
			
		}
		else {
		  
			return FALSE;
			
		}
		
	}
    
    
    
    
    /**
 	* Проверка пользователя, который забыл пароль
 	*/
	function forgotUser ($login, $email) {
       
		if ($user = $this->CI->{$this->md}->issetUser($login,$email)) {
		  
                
			return $user['email'];
		}
		
		else {
			
			return FALSE;
			
		}
		
	}
    
	
	function logged_in(){
		if($this->CI->dx_auth->is_logged_in()){
			return $this->CI->session->all_userdata();
		}
		else return false;
	}
	
	
	function isAdmin(){
	if($this->CI->dx_auth->is_logged_in() && $this->CI->dx_auth->is_admin()){
			return true;
		}
		else {
			return false;
		}
	}
	
	
	/**
 	* Выполняет выход админа 
 	*/
 	function logout ($redirect=false) {
 		$this->CI->dx_auth->logout();
 		redirect('admin');
	}
    
    
    function UpdateSocial($social = 1){
        $user = $this->CI->session->userdata('user');
		
		if ($this->CI->session->userdata('logged_in') && $user['login'] != '') {
		  $user['social'] = $social;
		   $this->CI->session->set_userdata(
					array (
					'user' => $user	
					)                    
				);   
		}
    }
    
    function UpdateName($name){
    $user = $this->CI->session->userdata('user');
		
		if ($this->CI->session->userdata('logged_in') && $user['login'] != '') {
		  $user['name'] = $name;
		   $this->CI->session->set_userdata(
					array (
					'user' => $user	
					)                    
				);   
		}
    }
    
    
	
	
 	
 	
}
?>