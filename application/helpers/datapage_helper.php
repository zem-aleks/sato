<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function translit($link, $dot_true = false) {

$replace_array = array(

'А' => 'a', 'Б' => 'b', 'В' => 'v', 'Г' => 'g', 'Д' => 'd', 'Е' => 'e', 'Є' => 'ye',
'Ё' => 'yo', 'Ж' => 'zh', 'З' => 'z', 'И' => 'i', 'І' => 'i', 'Й' => 'i', 'Ї' => 'yi',
'К' => 'k', 'Л' => 'l', 'М' => 'm', 'Н' => 'n', 'О' => 'o', 'П' => 'p', 'Р' => 'r',
'С' => 's', 'Т' => 't', 'У' => 'u', 'Ф' => 'f', 'Х' => 'kh', 'Ц' => 'ts', 'Ч' => 'ch',
'Ш' => 'sh', 'Щ' => 'sch', 'Ь' => '', 'Ъ' => '', 'Ы' => 'y', 'Э' => 'e', 'Ю' => 'yu',
'Я' => 'ya', 

'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'є' => 'ye',
'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'і' => 'i', 'й' => 'i', 'ї' => 'yi',
'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' =>'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
'с' => 's', 'т' => 't', 'у' =>'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts',
'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch', 'ь' => '', 'ы' => 'y', 'ъ' => '',
'э' => 'e', 'ю' => 'yu', 'я' => 'ya'

);

$link = strtr($link, $replace_array);

if (function_exists('htmlspecialchars_decode')) {
    
    $link = htmlspecialchars_decode($link);
    
}
else $link = preg_replace('/\&[A-Za-a0-9]+\;/', $link);



$regexp = ($dot_true) ? "/[^a-z0-9\_\-\.]+/mi" : "/[^a-z0-9\_\-]+/mi";

$link = preg_replace($regexp, " ", $link);
$link = preg_replace( "/\s+/ms", '-', $link );
$link = preg_replace('#[\-]+#i', '-', $link);
$link = strtolower($link);
if (!empty($link)) {

if ($link[0] == '-' || $link[0] == '_' ) {
	$link = substr($link,1);
}
if ($link[strlen($link)-1] == '-' ) $link = substr($link,0,-1);

if (strlen($link) > 255) {
$words =  explode('-', $link);
$link = $words[0];

if (count($words) > 1) {
	for ($i = 1, $c = count($words); $i <= $c; $i++) {
	if ((strlen($link) + strlen($words[$i])) < 255) $link .= '-'.$words[$i];
	else break;
	}				
}
}

if (strlen($link) > 255) $link = substr($link,0,255);
}
else return false;
return $link;
}


/*=======================================================
# Создание Мета-Описания
=======================================================*/
function make_mdesc($str) {

if (empty($str)) return false;

$mdesc = '';

$replace_mdesc = array( "\x27", "\x22", "\x60", "\t","\n","\r",'"',"'", '\r', '\n', "/", "\\","{","}","[","]");

$trans = get_html_translation_table(HTML_ENTITIES);
	
if (!empty($str)) {
$mdesc = str_replace($trans, ' ', $str);
	if (function_exists('htmlspecialchars_decode')) $mdesc = htmlspecialchars_decode($mdesc);
	else $mdesc = preg_replace("/&[A-Za-z0-9]+;/i", ' ', $mdesc);
$mdesc = str_ireplace(array('<br />','<p>','</p>', '<hr />', '<br>', '<hr>'), ' ', $mdesc );
$mdesc = strip_tags($mdesc);
$mdesc = str_replace($replace_mdesc, ' ', $mdesc);
$mdesc = preg_replace( "/\s+/ms", ' ', $mdesc);
$mdesc = trim($mdesc);
$mdesc =substr($mdesc, 0, 255);
}

return $mdesc;	
}



/*=======================================================
# Создание Мета-Ключевых слов
=======================================================*/
function make_mkeys($str) {

if (empty($str)) return false;

$mkeys = '';
	
$replace_mkeys = array( "\x27", "\x22", "\x60", "\t",'\n','\r', "\n","\r", '\\', "'",",",".","/","¬","#",";",":","@","~","[","]","{","}","=","-","+",")","(","*","&","^","%","$","<",">","?","!", '"' );	

$trans = get_html_translation_table(HTML_ENTITIES);

if (!empty($str)) {
	
$words = array ();
$mkeys = str_replace($trans, ' ', $str);
	if (function_exists('htmlspecialchars_decode')) $mkeys = htmlspecialchars_decode($mkeys);
	else $mkeys = preg_replace("/&[A-Za-z0-9]+;/i", ' ', $mkeys);
$mkeys = str_ireplace(array('<br />','<p>','</p>', '<hr />', '<br>', '<hr>'), ' ', $mkeys);
$mkeys = strip_tags($mkeys);
$mkeys = str_replace($replace_mkeys, ' ', $mkeys);
$mkeys = preg_replace( "/\s+/ms", ' ', $mkeys);
$mkeys = trim($mkeys);
$temp   = explode(" ", $mkeys);

foreach ($temp as $word) {
	if (strlen($word) > 4) $words[] = $word;
}

$words   = array_count_values($words);
arsort ($words);
$words = array_keys($words);
$words = array_slice ($words, 0, 20);


$mkeys = implode (', ', $words);

}

return $mkeys;
}

function make_mkeys2() {
	$CI = & get_instance();
	if($CI->input->post('mkeys')){
		$mkeys = rtrim($CI->input->post('mkeys'),',');
	}
	elseif($tags = $CI->input->post('tags')){
		$mkeys = rtrim(implode(', ',$tags),',');
	}
	elseif($tags = $CI->input->post('content')){
		$mkeys = make_mkeys($CI->input->post('content'));
	}
	else{
		$mkeys = $CI->input->post('name');	
	}
	
	return $mkeys;         
}

