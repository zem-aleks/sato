<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
	function __construct(){
		parent::__construct();
	}

    /**
 	* Валидация цвета
 	*/ 
   	function valid_color($str){
	
		if (!preg_match("/^([a-f0-9]{6,6})+$/i", $str)){
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
    
    /**
 	* Латиница
 	*/ 
   	function latin($str){
	
		if (!preg_match("/^([a-zA-Z0-9_\-])+$/i", $str)){
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
    
   	/**
 	* Валидация url
 	*/ 
    function valid_url ($str) {
        
        //return (!preg_match('/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:;.?+=&%@!\-\/]))?/',$str)) ? FALSE :           TRUE;
        
        $pattern = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
        if (!eregi($pattern, $str)){
			return FALSE;
		}
		else {
			return TRUE;
		}
    }
    
    /**
 	* Валидация капчи
 	*/ 
    function valid_captcha($str){
        $CI = & get_instance ();
		return ($CI->session->userdata('secret_word') != $str)? FALSE: TRUE;
	}
	
	
	
	
	
    

    
    /**
 	* Проверка бота
 	*/ 
    function valid_bot($str){
        
		return (empty($str))? TRUE: FALSE; 
	}
    
    
    /**
     * Проверка на уникальность
     */
	function uniq_cat_url ($str,$cat) {
		//Объект CI
		$CI = & get_instance ();
        
        if ( ! isset($_POST[$cat]))
		{
			return FALSE;				
		}
		
        $cat = $_POST[$cat];
        $cat_id = ($CI->input->post('cat_id'))? intval($CI->input->post('cat_id')): false;
        
 	    $CI->db->where ('cat_link',$str); 
 	    if(isset($_POST['lang'])) $CI->db->where ('lang',$_POST['lang']); 

 	    if($cat_id){
 	    	$CI->db->where ('cat_id <>',$cat_id); 
 	    }
        //$CI->db->where ('parent_id',$cat);                   
        return ($CI->db->count_all_results('categories')==0)? TRUE : FALSE;
	} 

	
	function uniq_page_url ($str) {
		//Объект CI
		$CI = & get_instance ();
		
        $cat_id = ($CI->input->post('cat_id'))? intval($CI->input->post('cat_id')): false;
        $page_id = ($CI->input->post('page_id'))? intval($CI->input->post('page_id')): false;
        
 	    $CI->db->where ('link',$str); 

 	    if($page_id){
 	    	$CI->db->where ('page_id <>',$page_id); 
 	    }
 	    
        $CI->db->where ('cat_id',$cat_id);       
                    
        return ($CI->db->count_all_results('pages')==0)? TRUE : FALSE;
	} 
    
    
    function uniq_login($str){
	
		$CI = & get_instance ();		
 	    $CI->db->where('login',$str);                     
        return ($CI->db->count_all_results('users')==0)? TRUE : FALSE;
	}
	
	function uniq_email($str){
	
		$CI = & get_instance ();		
 	    $CI->db->where('email',$str);                     
        return ($CI->db->count_all_results('users')==0)? TRUE : FALSE;
	}
    
    
    function uniqsortcats($str,$field){
	
		$CI = & get_instance ();
        
        if ( ! isset($_POST[$field]))
		{
			return FALSE;				
		}
		
		$field = $_POST[$field];
        				
 	    $CI->db->where('parent_id',$field);  
        $CI->db->where('sort',$str);                   
        return ($CI->db->count_all_results('categories')==0)? TRUE : FALSE;
	}
    
    function uniqsortpages($str,$field){
	
		$CI = & get_instance ();
        
        if ( ! isset($_POST[$field]))
		{
			return FALSE;				
		}
		
		$field = $_POST[$field];
        		
 	    $CI->db->where('cat_id',$field);  
        $CI->db->where('hits',$str);                   
        return ($CI->db->count_all_results('pages')==0)? TRUE : FALSE;
	}
    
    
    function typography($str){
        $CI = & get_instance ();	
		$CI->load->library('typography');
	
		
		return $CI->typography->auto_typography($str);
        
        
        //$str = auto_typography($str);


        //$str = str_replace('ё','е',$str); 
        //$str = mb_ereg_replace('/ё/i','е',$str);
        //return $str;
    }
    
    
	function parse_image($str) {
	    if (!$str) return $str;
	    
	    $temp = preg_match_all("/<[\s+]?img.*\/?>/i",$str, $matches);
	    
	    foreach($matches[0] AS $link) {
	        if (strpos($link,'align="left"') && strpos($link,'class="img_left"') === FALSE) {
	            $link_new = preg_replace("/<[\s+]?img/i",'<img class="img_left" ', $link);	            
	            $str = str_replace($link,$link_new, $str);                    
	        }
	        elseif (strpos($link, 'align="right"') && strpos($link,'class="img_right"') === FALSE) {
	            $link_new = preg_replace("/<[\s+]?img/i",'<img class="img_right" ', $link);	            
	            $str = str_replace($link,$link_new, $str);                    
	        }	        
	    }
	    return $str;    
	}
	 
	
	function parse_glossary($str){
		if (!$str) return $str;
		$CI = & get_instance ();	
		
		$parent_id = false;
		
		if($cat_id = $CI->input->post('cat_id')){
			$parent_id = $CI->lib_cache->model('mdl_pages','getParentId',array($cat_id),true,86400);
		}
		
		switch ($parent_id){
			case 8: $glossary_id = 1;
				break;
			case 2: $glossary_id = 3;
				break;
			case 3: $glossary_id = 2;
				break;
			case 5: $glossary_id = 5;
				break;
			case 108: $glossary_id = 4;
				break;
			default: $glossary_id = false;				
		}		

		$terms = $CI->lib_cache->model('mdl_glossary','getAllList',array($glossary_id),true,86400);
		
		if(empty($terms)) return $str;

		foreach ($terms as $term ) {
			
			$result = '';
			$start_pos = 0;
		    $term['term'] = str_replace('/','\/',$term['term']);
			preg_match_all( '/<a\s.*?>.*?<\/a>|<h\d.*?\/h\d>|<.*?>/isu', $str,$matches, PREG_OFFSET_CAPTURE );
			$replace_re = '/([\s\r\n\:\;\!\?\.\,\)\(<>]{1}|^)('.$term['term'].')([\s\r\n\:\;\!\?\.\,\)\(<>]{1}|$)/isu';
			
			foreach ( $matches[0] as $match ) {
				$length = $match[1] - $start_pos;
				
				if ( $length > 0 ) {
					$text = substr( $str, $start_pos, $length );			
					$result .= preg_replace( $replace_re, '$1<a href="ru/'.$term['glossary_link'].'_glossary/'.$term['term_id'].'" class="gterm">$2</a>$3', $text );										
				}

				$result .= $match[0];
				$start_pos = $match[1] + strlen( $match[0] );
			}
			
			if ( $start_pos < strlen( $str )) {
				$text = substr( $str, $start_pos );
				$result .= preg_replace( $replace_re, '$1<a href="ru/'.$term['glossary_link'].'_glossary/'.$term['term_id'].'" class="gterm">$2</a>$3', $text );				
			}
			
			$str = $result;			
		}
		
		return $str;
	}
    
	
	function unique($str,$fields){
	
		$CI = & get_instance ();
		
		//list($table,$field,$id) = explode('.',$fields);
		
		$data = explode('.',$fields);
		$table = (!empty($data[0]))? $data[0]: false;
		$field = (!empty($data[1]))? $data[1]: false;
		$id = (!empty($data[2]))? $data[2]: false;
						
		if($id){
			$v_id = ($CI->input->post($id))? $CI->input->post($id): false;
 	    	$CI->db->where ($id.' <>',$v_id); 
 	    }
		
 	    $CI->db->where($field,$str); 
 	                        
        return ($CI->db->count_all_results($table)>0)?  FALSE: TRUE;

	}
    
}
