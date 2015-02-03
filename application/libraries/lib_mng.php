<?php

/**
 * Описание файла: Библиотека для управления CRUD-объектами
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib_mng {
	
	function Lib_mng () {
		
	}
	
	/**
 	* Функция добавления записи 
 	*/
 	function add ($name,$redirect = false,$id_club = 0) {
 		
 		$CI = & get_instance ();
 		
 		$md = 'mdl_'.$name;
 		
 		$CI->load->model ($md);
		 
		if ($CI->{$md}->item_valid ()) {
			
			//Добавляем
			if(!$id_club){
				$result =  $CI->{$md}->add ();
			}
			else{
				$result =  $CI->{$md}->add ($id_club);
			}
            
            
            if(!$redirect) return $result;
            else {
                
                $redir = $CI->input->post('redirect');   
                
                $url = ($redir == 1)? 'admin/'.$name.'/edit/'.$result: $redirect;
                redirect($url);            
            }
			
		}
		else return false;
		
	}

	
	/**
 	* Удаление записи 
 	*/
 	function del ($name, $id,$redirect = false,$type = '') {
 		
 		$CI = & get_instance ();
 		
 		$md = 'mdl_'.$name;
 		
 		$CI->load->model ($md);
 		
        if($type === '')$CI->{$md}->del ($id);
        else $CI->{$md}->delete ($id,$type);
       
        if(!$redirect) return $result;
        else redirect($redirect);
 		
	}
	
    /**
    * Редактирование  
    */
    function edit ($name,$id=0,$redirect = false,$id_club=0) {

        $CI = & get_instance ();
        
        $md = 'mdl_'.$name;
                        
        $CI->load->model ($md);
        
        if ($CI->{$md}->item_valid (true)) {
                
            if(!$id_club){
				$result =  $CI->{$md}->edit ($id);
			}
			else{
				$result =  $CI->{$md}->edit ($id,$id_club);
			}

            if(!$redirect) return true;
            else redirect($redirect);
			
	}
	else return false;	       		
    }    
    
	function editTeams ($name,$id=0,$redirect = false) {

        $CI = & get_instance ();
        
        $md = 'mdl_'.$name;
                        
        $CI->load->model ($md);
        
        if ($CI->{$md}->item_valid (true)) {
                
            
				$result =  $CI->{$md}->editTeams ($id);
			

            if(!$redirect) return true;
            else redirect($redirect);
			
	}
	else return false;	       		
    }    
	
	
	function submitSostav ($name,$id_club,$id_turnir,$year_turn,$redirect = false) {

        $CI = & get_instance ();
        
        $md = 'mdl_'.$name;
                        
        $CI->load->model ($md);
        
        if ($CI->{$md}->item_valid (true)) {
                
            
				$result =  $CI->{$md}->submitSostav ($id_club,$id_turnir,$year_turn);
			

            if(!$redirect) return true;
            else redirect($redirect);
			
	}
	else return false;	       		
    }    

	/**
 	* Просмотр сведений о записи  
 	*/
	function get ($name,$id) {
		
 		$CI = & get_instance ();
 		
 		$md = 'mdl_'.$name;
 		 		
 		$CI->load->model ($md);		
		
		$data = $CI->{$md}->get ($id);
		
		if (empty ($data)) {
            return false;
		}
        else return $data;
				
	}
    
    
    function getlist ($name,$id_project,$id) {
		
 		$CI = & get_instance ();
 		
 		$md = 'mdl_'.$name;
 		 		
 		$CI->load->model ($md);		
		
		$data = $CI->{$md}->getlist ($id_project,$id);
		
		if (empty ($data)) {
            return false;
		}
        else return $data;
				
	}
	

    function listforms($name,$hdata = array(), $data = array(), $view = 'list'){
        $CI = & get_instance ();
 		
 		$md = 'mdl_project';
 		 		
 		$CI->load->model ($md);	
        
        $data['list'] =  $CI->{$md}->getlist (); 	
        
        $CI->lib_view->cp_view ($name.'/'.$view, $hdata, $data);
        
    }
    
    /**
    * Список записей
    */
    function showlist ($name,$head,$data,$lang = 'all',$cat_id=0,$start_row,$sortby = '', $fs = '',$newsman = 0,$id_club = 0,$year_turn = '0000-00-00'){
            
    
        $CI = & get_instance ();
        
        $md = 'mdl_'.$name;
                        
        $CI->load->model ($md);		
        
        //Сегмент сортировки
        if (!$sortby) {
                $sort_seg = $CI->{$md}->sort_dir.'_'.$CI->{$md}->sort_field;
        }
        else {
                $sort_seg =	$sortby;
                if (strpos ($sortby,'up_')!==false) {
                        $CI->{$md}->sort_field = str_replace ('up_','',$sortby);
                        $CI->{$md}->sort_dir = 'up';	
                } else {				
                        $CI->{$md}->sort_field = str_replace ('down_','',$sortby);
                        $CI->{$md}->sort_dir = 'down';	
                }			
        }

        $per_page = ($CI->{$md}->per_page)? $CI->{$md}->per_page: 10;
        
        //Парсинг строки фильтра
        $CI->{$md}->parse_fs ($fs);
        
        //Если в форме указали поиск
        if (!empty ($_POST) && $CI->input->post ('search_by')!='') {
                $CI->{$md}->search_by = $CI->input->post ('search_by');
                $CI->{$md}->search_value = $CI->input->post ('search_value');
        }
        
        $language = $CI->config->item('lang');
        $lang = (isset($language[$lang]))? $lang: 'all';
        
        
        if(!$id_club){
			$data['items'] = $CI->{$md}->getlist ($lang,$cat_id,$start_row,$newsman); 	
		}
		else{
			$data['items'] = $CI->{$md}->getlist ($lang,$cat_id,$start_row,$newsman,$id_club,$year_turn);
		}
		

        $total = $CI->{$md}->count_all ($lang,$cat_id,$newsman);	
 
        if($newsman && $start_row){
        	$uri_segment = 6;
        }
        else{
        	$uri_segment = 5;
        }
        
		
        $cf = array (
                
             
                'base_url' 		=> base_url ().'admin/'.$name.'/'.$lang.'/'.$cat_id.'/'.(($newsman)?'newsman/'.$newsman:''),
                'per_page' 		=> $per_page,
                'total_rows'	=> $total,
                'uri_segment'	=> $uri_segment,
                'num_links'		=> 6,
                
                'last_link'		=> '&gt;&gt;',
                'last_tag_open'	=> '&nbsp;',
                
                'first_tag_close' => '&nbsp;', 			
                'first_link'	=> '&lt;&lt;',
                
                'next_link'		=> '-&gt;',
                'next_tag_open' => '&nbsp;',
                'cur_tag_open'	=> '<span>&nbsp;<b>&nbsp;',
                'cur_tag_close'	=> '&nbsp;</b></span>',
                
                'prev_link'		=> '&lt;-',
                'cl'			=> '/'.$sort_seg.'/'.$CI->{$md}->fs_str ()
                
         
        );
        
        $CI->load->library('pagination');
        
        $CI->pagination->initialize($cf);
        
        $data['pg_links'] = $CI->pagination->create_links();
        $data['cur_page'] = floor ($start_row/$cf['per_page'])+1;
        //Общее число страничек
        $data['total_pages'] = ceil($total / $cf['per_page']);
        
        $data['pg_row'] = $start_row;
        $data['start_row'] = $start_row;
        
        //Всего элементов
        $data['total_items'] = $total;
        
        if ($data['start_row'] < 1) {
                $data['start_row'] = 1;	
        }
        
        $data['stop_row'] = $start_row+$cf['per_page'];
        
        //Выравниваем номер последней записи
        if ($data['stop_row']>$total) {
                $data['stop_row'] = $total;
        }		
 
        $CI->lib_view->cp_view($name.'/list',$head,$data);		
    }
    
    
    
    function shownewlist ($name,$view,$uri_segment,$head,$data,$lang = 'all',$param=array(),$start_row,$sortby = '', $fs = '') {
                    
        $CI = & get_instance ();
        
        if(!is_array($param)){
            $param = (array) $param;
        }
        extract($param);
        
        $md = 'mdl_'.$name;
                        
        $CI->load->model ($md);		
        
        //Сегмент сортировки
        if (!$sortby) {
            $sort_seg = $CI->{$md}->sort_dir.'_'.$CI->{$md}->sort_field;
        }
        else {
            $sort_seg =	$sortby;
            if (strpos ($sortby,'up_')!==false) {
                $CI->{$md}->sort_field = str_replace ('up_','',$sortby);
                $CI->{$md}->sort_dir = 'up';	
            } else {				
                $CI->{$md}->sort_field = str_replace ('down_','',$sortby);
                $CI->{$md}->sort_dir = 'down';	
            }			
        }  
        $per_page = ($CI->{$md}->per_page)? $CI->{$md}->per_page: 10;
        
        //Парсинг строки фильтра
        $CI->{$md}->parse_fs ($fs);
        
        //Если в форме указали поиск
        if (!empty ($_POST) && $CI->input->post ('search_by')!='') {
            $CI->{$md}->search_by = $CI->input->post ('search_by');
            $CI->{$md}->search_value = $CI->input->post ('search_value');
        }
        
        $language = $CI->config->item('lang');
        $lang = (isset($language[$lang]))? $lang: 'all';
        
        $data['items'] = $CI->{$md}->getlist ($lang,$cat_id,$start_row); 		
        $total = $CI->{$md}->count_all ($lang,$cat_id);

        $url = (empty($url))? 'admin/'.$CI->router->class.'/'.$lang.'/'.$cat_id.'/': $url;
        $data['pg_links'] = pagination($total,$per_page,$uri_segment,$url); 
        $data['cur_page'] = floor ($start_row/$per_page)+1;
        
        //Общее число страничек
        $data['total_pages'] = ceil($total /$per_page);
        
        $data['pg_row'] = $start_row;
        $data['start_row'] = $start_row;
        
        //Всего элементов
        $data['total_items'] = $total;
        
        if ($data['start_row'] < 1) {
                $data['start_row'] = 1;	
        }
        
        $data['stop_row'] = $start_row+$per_page;
        
        //Выравниваем номер последней записи
        if ($data['stop_row']>$total) {
                $data['stop_row'] = $total;
        }		
 
        $CI->lib_view->cp_view($view,$head,$data);		
    }

 	function add_glossary ($name,$redirect = false,$link) {
 		
 		$CI = & get_instance ();
 		
 		$md = 'mdl_'.$name;
 		
 		$CI->load->model ($md);
		 
		if ($CI->{$md}->item_valid ()) {
			
			//Добавляем
            $result =  $CI->{$md}->add ($link);
            
            
            if(!$redirect) return $result;
            else {
                
                $redir = $CI->input->post('redirect');   
                
                $url = ($redir == 1)? 'admin/'.$name.'/'.$link.'/edit/'.$result: $redirect;
                redirect($url);            
            }
			
		}
		else return false;
		
	}
	    /**
    * Редактирование  
    */
    function edit_glossary ($name,$id=0,$redirect = false,$link) {

        $CI = & get_instance ();
        
        $md = 'mdl_'.$name;
                        
        $CI->load->model ($md);
        
        if ($CI->{$md}->item_valid (true)) {
                
            $CI->{$md}->edit ($id,$link);

            if(!$redirect) return true;
            else redirect($redirect);
			
	}
	else return false;	       		
    }    
    
	/**
 	* Удаление записи 
 	*/
 	function del_glossary ($name, $id,$redirect = false,$type = '',$link) {
 		
 		$CI = & get_instance ();
 		
 		$md = 'mdl_'.$name;
 		
 		$CI->load->model ($md);
 		
        if($type === '')$CI->{$md}->del ($id,$link);
        else $CI->{$md}->delete ($id,$type);
       
        if(!$redirect) return $result;
        else redirect($redirect);
 		
	}
}


?>