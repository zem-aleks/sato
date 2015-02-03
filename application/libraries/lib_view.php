<?php

/**
 * Описание файла: Функции отображения
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib_view {
    
    var $background = array('football','basketball','hockey','box_mma','tennis','euro_2012','equestrian','shakhtar_75','mediacenter');  
    
    var $lang = array(					
    				'ru' => 'russian',
					'en' => 'english');
    
	function Lib_view () {
		
	}
    
    
    
	function cp_view ($page, $hdata=array(), $data = array ()) {
	   
        $CI = &get_instance ();
        
        $data['page'] = $page;
        $data['hdata'] = $hdata;
		        
        $CI->load->view('admin/index',$data);

	}
    
    function page_view ($hdata=array(), $data = array ()) {
	   
        $CI = &get_instance ();
        $curTheme = $CI->config->item('current_theme');
        
        
        
        
        
		//если ИЕ6
      $CI->load->library('user_agent');
      if($CI->agent->browser() == 'Internet Explorer' AND in_array($CI->agent->version(), array('6.0')))
      {
      	redirect('ie6');
      }
      
      
        
        
        $url = $CI->uri->rsegment_array();
        $data['controller'] = (!empty($url[1]))? $url[1]: false;
        $data['method'] = (!empty($url[2]))? $url[2]: false;  
        $data['lang'] = (!empty($url[3]))? $url[3]: 'ru';  
        $data['cat'] = (isset($data['cat']))? $data['cat']: ((!empty($url[4]))?$url[4]:'0');  
        $data['page'] = (isset($data['page']))? $data['page']: ((!empty($url[5]))? $url[5]: '');  
  
        //var_dump($data);
        
        if(!in_array($data['lang'],array('ru','en','ua'))){
            $data['lang'] = 'ru';
        }
        
        if($data['lang'] == 'en'){
        	$curTheme = 'default_en';
        }
        
        if($data['controller'] == 'pda'){
            $curTheme = 'pda';
        }
        
        if(!empty($data['lang'])){
        	if($data['lang'] == 'ru' || $data['lang'] == 'en'){
        		$CI->config->set_item('language',$this->lang[$data['lang']]);
        	}
        }
       
        
        $CI->lang->load('text_const');
        
        //Обновляем количество пользователей онлайн
        //$CI->load->model('mdl_analitics');
	//	$CI->mdl_analitics->updateUserOnline();
        
        
        $data['theme'] = $curTheme;
        $data['hdata'] = $hdata;
        $data['background'] = $this->background;
        $data['user'] = $CI->lib_auth->checkUser();
        
        
          if($data['method'] != 'search' && $data['method'] != 'search_mediacenter'){
            $CI->session->unset_userdata( array ('search' => ''));
            $CI->session->unset_userdata( array ('cat_id'=> ''));
        }
                
        $data['search']=($CI->input->post('search'))?$CI->input->post('search',true):$CI->session->userdata('search');
        
        //Устанавливаем background
        $parentcat = $CI->lib_cache->library('lib_view','getParentsCats',array($data['cat']),true,86400*365);        	
        $data['parentcat'] = ($parentcat == 'video' || $data['method'] == 'mediacenter')? 'mediacenter': $parentcat;
                

    	$data['user_name'] = (!empty($url[4]))?$url[4]:'0';
            
            if($data['method'] == 'user'){
            	$data['user_name'] = $url[5];
            }
        
        
        if($data['user']){
            $count = $CI->lib_cache->module('blog','checkBlog',array($data['user']['login'],$data['user']['user_id']),false);
            $data['myblog'] = ( $count > 0)? true: false;
            
           

           if($data['user']['social'])
            	$data['unread_messages'] = ( $count > 0)? $CI->lib_cache->module('message','count_unread_message',array($data['user']['user_id'],$data['page']),false): false;
           else 
           		$data['unread_messages'] = false;

           	/*
            $data['messages'] = $CI->lib_cache->module('message','count_unread_message',array($data['user']['user_id'],$data['page']),false);
            $data['albums'] = $CI->lib_cache->module('useralbum','countAlbums',array($data['user']['user_id']),false);
            $data['blogs'] = $CI->lib_cache->module('blog','count_all_blogs_for_user',array($data['user']['user_id']),false);
            $data['count_predictions'] = $CI->lib_cache->module('matches','countAllUserPredictions',array($data['user']['user_id']),false);
            $data['audios'] = $CI->lib_cache->module('audio','countAudio',array($data['user']['user_id']),false);
            $data['videos'] = $CI->lib_cache->module('video','countVideo',array($data['user']['user_id']),false);
            $data['count_comments'] = $CI->lib_cache->module('soc_user','countComments',array($data['user']['user_id']),false);
            $data['count_friends'] = $CI->lib_cache->module('soc_user','count_all_friends',array($data['user']['user_id']),false);
            */
            //var_dump($url);
        }
        else{
            $data['myblog'] = false;
        }
        
        $CI->load->view('template/'.$curTheme.'/index',$data);

	}
    
	
	
	function page_view_test ($hdata=array(), $data = array ()) {
	   
        $CI = &get_instance ();
        $curTheme = $CI->config->item('current_theme');
        
        
       // $this->config->set_item('enable_cached', '0');
        
        
		//если ИЕ6
      $CI->load->library('user_agent');
      if($CI->agent->browser() == 'Internet Explorer' AND in_array($CI->agent->version(), array('6.0')))
      {
      	redirect('ie6');
      }
      
      
        
        
        $url = $CI->uri->rsegment_array();
        $data['controller'] = (!empty($url[1]))? $url[1]: false;
        $data['method'] = (!empty($url[2]))? $url[2]: false;  
        $data['lang'] = (!empty($url[3]))? $url[3]: 'ru';  
        $data['cat'] = (isset($data['cat']))? $data['cat']: ((!empty($url[4]))?$url[4]:'0');  
        $data['page'] = (isset($data['page']))? $data['page']: ((!empty($url[5]))? $url[5]: '');  
        
        if(!in_array($data['lang'],array('ru','en','ua'))){
            $data['lang'] = 'ru';
        }
        
        if($data['lang'] == 'en'){
        	$curTheme = 'default_en';
        }
        
        if($data['controller'] == 'pda'){
            $curTheme = 'pda';
        }
        
        if(!empty($data['lang'])){
        	if($data['lang'] == 'ru' || $data['lang'] == 'en'){
        		$CI->config->set_item('language',$this->lang[$data['lang']]);
        	}
        }
       
        
        $CI->lang->load('text_const');
        
        
        $data['theme'] = $curTheme;
        $data['hdata'] = $hdata;
        $data['background'] = $this->background;
        $data['user'] = $CI->lib_auth->checkUser();
        
        
          if($data['method'] != 'search'){
            $CI->session->unset_userdata( array ('search' => ''));
            $CI->session->unset_userdata( array ('cat_id'=> ''));
        }
                
        $data['search']=($CI->input->post('search'))?$CI->input->post('search',true):$CI->session->userdata('search');
        
        //Устанавливаем background
        $data['parentcat'] = $CI->lib_cache->library('lib_view','getParentsCats',array($data['cat']),true,86400*365);        
      
        if($data['user']){
            $count = $CI->lib_cache->module('blog','checkBlog',array($data['user']['login'],$data['user']['user_id']),false);
            $data['myblog'] = ( $count > 0)? true: false;
            
           

           if($data['user']['social'])
            	$data['unread_messages'] = ( $count > 0)? $CI->lib_cache->module('message','count_unread_message',array($data['user']['user_id'],$data['page']),false): false;
           else 
           		$data['unread_messages'] = false;
            
            
            $data['user_name'] = (!empty($url[4]))?$url[4]:'0';
            
            if($data['method'] == 'user'){
            	$data['user_name'] = $url[5];
            }
            
            $data['messages'] = $CI->lib_cache->module('message','count_unread_message',array($data['user']['user_id'],$data['page']),false);
            $data['albums'] = $CI->lib_cache->module('useralbum','countAlbums',array($data['user']['user_id']),false);
            $data['blogs'] = $CI->lib_cache->module('blog','count_all_blogs_for_user',array($data['user']['user_id']),false);
            $data['count_predictions'] = $CI->lib_cache->module('matches','countAllUserPredictions',array($data['user']['user_id']),false);
            $data['count_predictions'] = $CI->lib_cache->module('matches','countAllUserPredictions',array($data['user']['user_id']),false);
            $data['audios'] = $CI->lib_cache->module('audio','countAudio',array($data['user']['user_id']),false);
            $data['videos'] = $CI->lib_cache->module('video','countVideo',array($data['user']['user_id']),false);
            $data['count_comments'] = $CI->lib_cache->module('soc_user','countComments',array($data['user']['user_id']),false);
            $data['count_friends'] = $CI->lib_cache->module('soc_user','count_all_friends',array($data['user']['user_id']),false);
            
            //var_dump($url);
        }
        else{
            $data['myblog'] = false;
        }
        
        $CI->load->view('test2/'.$curTheme.'/index',$data);

	}
    
    function getParentsCats($cat){
    	//для конного спорта
    	if($cat == 'equestrian'){
    		return 'equestrian';
    	}
    	
    	if($cat == 'shakhtar_75'){
    		return 'shakhtar_75';
    	}
    	
    	
        $CI = &get_instance ();
        $CI->db->select('parent_id,cat_link');
        $CI->db->where('cat_link',$cat);
        $CI->db->limit(1);
        $query = $CI->db->get('categories');
        
        if($query->num_rows() > 0){
            $res = $query->row_array();
            
            if($res['parent_id'] != 0 && $res['parent_id'] != 1){
                $CI->db->select('parent_id,cat_link');
                $CI->db->where('cat_id',$res['parent_id']);
                $CI->db->limit(1);
                $query = $CI->db->get('categories');
                
                if($query->num_rows() > 0){                    
                    $res2 = $query->row_array();
                    return $this->getParentsCats($res2['cat_link']);
                }
                else{
                    return $res['cat_link'];
                }
                
                
            }
            else{
                return $res['cat_link'];
            }
        }
        else return false;
        
    }

    
    
	
}


?>