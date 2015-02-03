<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mail extends Controller 
{
    var $headers=null;
    var $images=null;
    
    function Mail() 
    {
        parent::__construct();
        session_start();
        $this->headers='MIME-Version: 1.0' . "\r\n";
        $this->headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $this->headers .= 'From: Johnny English <no_reply@johnny-english.ru>' . "\r\n";
    }
    
    function sendMessage($email, $title, $text)
    {
        mail($email, $title, $text,  $this->headers);
    }
    
    function sendFeedback($name,$email,$feedback)
    {
        $text="<table border='1' align='center' cellpadding='5' cellspacing='0' width='600'><tbody><tr>";
        $text.="<td width='300' align='center'>Имя: ".$name."</td>";
        $text.="<td width='300' align='center'>Email: ".$email."</td>";
        $text.="</tr>";
        $text.="<tr><td colspan='2' align='left'>".$feedback."</td></tr>";
        $text.="</tbody></table>";
        $settings=$this->load->module('settings')->getListSettings();
        $email= $settings['emailFeedback'];
            
        if(!empty($email))
            mail($email, 'Сообщение отправленное через обратную связь', $text,  $this->headers);
    }
    
}
?>
