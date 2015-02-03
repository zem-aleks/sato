<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib_module {
    
    var $CI;
    var $curTheme = 'default';
    private $cache_path;
	
	function Lib_module () {
		$this->CI = &get_instance ();
		//$this->CI->load->library('lib_cache');
		$this->cache_path = APPPATH.'cache/'; 
		$this->curTheme = $this->CI->config->item('current_theme');
	}
    
	
	
	/*
	 * Функция загружает модуль
	 */
function load_modules($modules){
        
    	$modules = (!is_array($modules))? array($modules): $modules;
    	
        if(is_array($modules) && sizeof($modules) > 0){
        	
            foreach($modules as $module){
                $data = array();
                
                //Использовать кэширование
                $cached =  (isset($module['cached']))? $module['cached']: ((config_item('enable_cached') == 1)? true: false); 

                //Время жизни кэша
                $expires = (!empty($module['cache_expires']))? $module['cache_expires'] : config_item('cache_expires');
                
                //Проверка, нужно ли загружать модуль
                $is_load_module = (!empty($module['name']) && !empty($module['method']) && $this->isModules($module['name']))? true: false;

                //Шаблон модуля
                $view = (!empty($module['view']) && $this->isView($module['view']))? $module['view']: false;
                
                //Пользовательские данные, переданные в модуль
                $datamod = (isset($module['data']) && sizeof($module['data']) > 0)? $module['data']: array();
                
                //Параметры модуля
                $arguments = array($this->CI->uri->rsegment_array(), $datamod);
                               
                $cache_file = ''; // Имя кэша

                if($is_load_module){
                	
                	//$cache_file = $module['name'].DIRECTORY_SEPARATOR.md5($module['method'].serialize($arguments).$view);
                	if(!empty($module['common'])){
                		$cache_file = $module['name'].DIRECTORY_SEPARATOR.md5($module['method'].$view);
                	}
                	else{
                		$cache_file = $module['name'].DIRECTORY_SEPARATOR.md5($module['method'].serialize(end($this->CI->uri->rsegment_array())).$view);
                	}
               	                	
                	if($content = $this->getCacheFile($cache_file,$cached)){
                		$this->show_content($content,$view);
                		continue;
                	} 
                	
                   //$data['content'] = $this->CI->lib_cache->module($module['name'],$module['method'],$arguments, $cached,$expires); 
                
			        if(!in_array($module['name'], $this->CI->load->_ci_models) && $module['method']){
			           $this->CI->load->model('modules/'.$module['name']);
			        }
					if($module['method']){
                    	$data['content'] = call_user_func_array(array($this->CI->$module['name'], $module['method']), $arguments);
					}                                                                              
                	
                }

                
                //Если есть шаблон модуля, то выводим его
                if($view){
                                       
                    $content = $this->CI->load->view('template/modules/'.$view,$data,true);
                                       
                    if($cached) $this->write_cache($content,$cache_file,$expires);
                   
                    $this->show_content($content,$view);

                }               
            }            
        }             
    }
    
    
    function isView($name){
        
        return (!empty($name) && file_exists(APPPATH.'views/template/modules/'.$name.EXT))? true: false;
    }
    
    function isModules($name){
        return (!empty($name) && file_exists(APPPATH.'models/modules/'.$name.EXT))? true: false;
    }
    
    
    function show_content($content,$view){
    	if(empty($content)) return;
    	
    	if(IS_ADMIN) echo '<!-- Шаблон:'.$view.'-->';
        echo $content;
        if(IS_ADMIN) echo '<!--Конец. Шаблон:'.$view.'-->';
    }
    
    
    
    //Возвращает закэшированный файл
    function getCacheFile($filename,$use_expires = true){
    	
    	// Check if cache was requested with the function or uses this object
        if (empty($filename) || $use_expires !== TRUE) return FALSE;
        
        // Check directory permissions
        if ( ! is_dir($this->cache_path) OR ! is_really_writable($this->cache_path))
        {
            return FALSE;
        }
        
        // Build the file path.
        $filepath = $this->cache_path.$filename.'.cache.html';
        
        // Check if the cache exists, if not return FALSE
        if ( ! @file_exists($filepath))
        {
            return FALSE;
        }
        
        // Check if the cache can be opened, if not return FALSE
        if ( ! $fp = @fopen($filepath, FOPEN_READ))
        {
            return FALSE;
        }
        
        // Lock the cache
        flock($fp, LOCK_SH);
        
        // If the file contains data return it, otherwise return NULL
        if (filesize($filepath) > 0)
        {
            $content = fread($fp, filesize($filepath));
        }
        else
        {
            $content = NULL;
        }
        
        // Unlock the cache and close the file
        flock($fp, LOCK_UN);
        fclose($fp);
        
        if($use_expires){
        	
	        if ( ! preg_match("/(\d+TS--->)/", $content, $match))
			{
				return FALSE;
			}
			
			// Has the file expired? If so we'll delete it.
			if (time() >= trim(str_replace('TS--->', '', $match['1'])))
			{ 		
				@unlink($filepath);
				log_message('debug', "Cache file has expired. File deleted");
				return FALSE;
			}
        }
    	
        return preg_replace("/(\d+TS--->)/", '', $content);
    }
    
	
    
	function write_cache($content = NULL, $filename = NULL, $expires = NULL)
	{
		if ( empty($filename) && ! is_dir($this->cache_path) OR ! is_really_writable($this->cache_path))
        {
        	return;
        }
		
        
		// check if filename contains dirs
        $subdirs = explode(DIRECTORY_SEPARATOR, $filename);
        if (count($subdirs) > 1)
        {
        array_pop($subdirs);
        $test_path = $this->cache_path.implode(DIRECTORY_SEPARATOR, $subdirs);
        
        // check if specified subdir exists
        if ( ! @file_exists($test_path))
        {
        // create non existing dirs, asumes PHP5
        if ( ! @mkdir($test_path, DIR_WRITE_MODE, TRUE)) return FALSE;
        }
        }
        
        // Set the path to the cachefile which is to be created
        $cache_path = $this->cache_path.$filename.'.cache.html';
        
        // Open the file and log if an error occures
        if ( ! $fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE))
        {
        log_message('error', "Unable to write Cache file: ".$cache_path);
        return;
        }
                
      
		$expire = time() + $expires;
		
		if (flock($fp, LOCK_EX))
		{
			fwrite($fp, $expire.'TS--->'.$content);
			flock($fp, LOCK_UN);
		}
		else
		{
			log_message('error', "Unable to secure a file lock for file at: ".$cache_path);
			return;
		}
		fclose($fp);
		@chmod($cache_path, DIR_WRITE_MODE);

		log_message('debug', "Cache file written: ".$cache_path);
	}

	
}


?>