<?php
/**
 * Файл положить в директорию ./application/helpers
 * Подключить в нужном месте $this->load->helper('sms')
 * 
 * @param string $login - логин для авторизации на сайте
 * @param string $password - пароль
 * @param string $from - параметр от "кого"
 * @param int $phone - телефон в межд.формате без "+" либо массив номеров
 * @param string $message - текст сообщения
 * Пустым может быть только сообщение
 */
function getAccount()
{
    return array(
        'login' => '',
        'password' => '',
        'from' => ''
    );
}

function sms_send($login, $password, $from, $phone, $message = '')
{
	if(empty($login) || empty($password) || empty($from) || empty($phone))
	{
		return false;
	}
	else 
	{
	$sUrl  = 'http://letsads.com/api';
	$sXML  = '<?xml version="1.0" encoding="UTF-8"?>

		<request>
   		 <auth>
      		  <login>'.$login.'</login>
       		 <password>'.$password.'</password>
   		 </auth>
    		<message>
      		  <from>'.$from.'</from>
       		 <text>'.$message.'</text>';
	if(is_array($phone))
	{
		foreach($phone as $key => $value)
		{
       		$sXML  .= '<recipient>'.$val.'</recipient>';
		}
	}
	else 
	{
		$sXML  .= '<recipient>'.$phone.'</recipient>';
	}
	$sXML  .='</message></request>';
        
	$rCurl = curl_init($sUrl);
	curl_setopt($rCurl, CURLOPT_HEADER, 0);
	curl_setopt($rCurl, CURLOPT_POSTFIELDS, $sXML);
	curl_setopt($rCurl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($rCurl, CURLOPT_POST, 1);
	$sAnswer = curl_exec($rCurl);
	curl_close($rCurl);
	}
}
