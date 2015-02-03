<?php

/**
 * Описание файла: Библиотека для отпрвки писем
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib_send {
    
    var  $CI;
    
    var $from = 'no-replay@hotsport.com.ua';
    
    var $fromname = '';
    
    var $temp = 'letter.html';
    
    var $charset = 'UTF-8';
    
    var $template = '';

	
	function Lib_send () {
	   
        $this->CI = &get_instance ();
        
        $this->CI->load->library('lib_mail');
		
	}
    
    
    function m_send($email,$subject,$message,$from='',$fromname = '',$template = ''){
        
        $this->set_template($template);
        
        $this->CI->lib_mail->ClearAllRecipients();
       	$this->CI->lib_mail->ClearAttachments();
       
        //От кого отправка
        $this->CI->lib_mail->From = (!empty($from))? $from: $this->from;
        $this->CI->lib_mail->FromName = (!empty($fromname))? $fromname: $this->fromname;
        
        //Кому отправляется письмо
        $this->CI->lib_mail->AddAddress($email);
        //$lib_mail->AddAddress('ishamshur@yandex.ru');
        
        //Тема письма
        $this->CI->lib_mail->Subject = $subject;
        
        //Тип письма
        $this->CI->lib_mail->IsHTML(true);
        
        $this->CI->lib_mail->CharSet = $this->charset;
                    
        $body = $this->set_message($message);
                       
        $this->CI->lib_mail->Body = $body;
                       
        if($this->CI->lib_mail->Send ()){ 
            return true;
        }
        else {
            return false;
        }
        
        
    }
    
    
    function send_admins($subject,$message){
        
        $this->CI->load->model('mdl_users');
        
        if($admins =  $this->CI->mdl_users->get_sys_admins()){
            if(is_array($admins) && sizeof($admins) > 0)
                foreach($admins as $admin){
                                                       
                    $this->m_send($admin['email'],$subject,$message);
                }
                return true;
        }
        else return false;
        
        
    }
    
    
      
    function set_template($template = ''){
        
        if(!empty($template))
            $template = APPPATH.'views/'.$template;     
        else
            $template = APPPATH.'views/'.$this->temp;   
            
        $this->template = @file_get_contents($template);  
      
    }
    
    function set_message($body){  
    
        $this->set_image();
        
        if($this->CI->lib_mail->ContentType == 'text/html'){        
             return str_replace('%%BODY%%',$body,$this->template);
        }
        else return $body;
        
    }
    
    function set_image(){
        $this->CI->lib_mail->AddEmbeddedImage(FCPATH.'/images/letters/letter_680_01.jpg','img1','letter_680_01.jpg');
        $this->CI->lib_mail->AddEmbeddedImage(FCPATH.'/images/letters/rassilka.jpg','img3','rassilka.jpg');
    }
    
    
	
	
}


?>