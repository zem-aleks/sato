<?php

class Admin extends Controller {
	
	function index(){
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!$is_logged_in){
			$data['main_content'] = 'login_form';
			$this->load->view('login_form', $data);		
		}
		else{
			redirect('/dashboard/pages');
		}
	}
        
        function password(){
            $is_logged_in = $this->session->userdata('is_logged_in');
            if(!$is_logged_in){
                redirect('/dashboard/pages');
                return;
            }
            
            session_start();
            $content = array();
            $content['title'] = 'Сменить пароль';
            $content['error'] = '';
            $content['success'] = '';
            $this->load->library('form_validation');
            $config = array(
                array(
                    'field' => 'password1',
                    'label' => 'Старый пароль',
                    'rules' => 'required|min_length[4]|max_length[25]|xss_clean'
                ),
                array(
                    'field' => 'password2',
                    'label' => 'Новый пароль',
                    'rules' => 'required|min_length[4]|max_length[25]|matches[password3]|md5'
                ),
                array(
                    'field' => 'password3',
                    'label' => 'Потверждение пароля',
                    'rules' => 'required|min_length[4]|max_length[25]|xss_clean'
                ),
            );
            $this->form_validation->set_rules($config);
            if($this->form_validation->run()) {
                $content['success'] = "Пароль успешно изменен";
                $password = $this->input->post('password2');
                $this->db->where('username', $this->session->userdata('username'));
                $this->db->update('membership', array('password' => $password));
            } else {
                $content['error'] = validation_errors();
            }
            $this->load->view('includes/admin_header', $content);
            $this->load->view('change_password', $content);
            $this->load->view('includes/admin_footer', $content);
        }
	
	function validate_credentials(){		
		$this->load->model('mdl_admin');
		$query = $this->mdl_admin->validate();
		
		if($query) // if the user's credentials validated...
		{
			$data = array(
				'username' => $this->input->post('username'),
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
			redirect('dashboard/pages');
		}
		else // incorrect username or password
		{
			$this->index();
		}
	}	
	
	function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('is_logged_in');
		$this->session->sess_destroy();
		$this->index();
	}	
	
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';	
			die();		
		}		
	}
	function cp(){
		if( $this->session->userdata('username') )
		{
			// load the model for this controller
			$this->load->model('mdl_admin');
			// Get User Details from Database
			$user = $this->mdl_admin->get_member_details();
			if( !$user )
			{
				// No user found
				return false;
				
			}
			else
			{
				// display our widget
				$this->load->view('user_widget', $user);
			}			
		}
		else
		{
			// There is no session so we return nothing
			return false;
		}
	}
	
	/*function signup()
	{
		$data['main_content'] = 'signup_form';
		$this->load->view('includes/template', $data);
	}
	
	function create_member()
	{
		$this->load->library('form_validation');
		
		// field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('password2', 'Password Confirmation', 'trim|required|matches[password]');
		
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view('signup_form');
		}
		
		else
		{			
			$this->load->model('mdl_admin');
			
			if($query = $this->mdl_admin->create_member())
			{
				$data['main_content'] = 'signup_successful';
				$this->load->view('includes/template', $data);
			}
			else
			{
				$this->load->view('signup_form');			
			}
		}
		
	}*/
	
	
	
	/**/
}