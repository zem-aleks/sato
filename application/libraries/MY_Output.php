<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Output extends CI_Output {
	
/**
	 * Write a Cache File
	 *
	 * @access	public
	 * @return	void
	 */	
	function _write_cache($output)
	{
		$CI =& get_instance();	
		$path = $CI->config->item('cache_path');
	
		$cache_path = ($path == '') ? BASEPATH.'cache/' : $path;
		
		if ( ! is_dir($cache_path) OR ! is_really_writable($cache_path))
		{
			return;
		}

		$uri = $CI->uri->uri_string();
		
		if(!strpos($uri, 'html')){
			
			$uri .= '/category';
		}

		// check if filename contains dirs
        $subdirs = explode(DIRECTORY_SEPARATOR, $uri);
        
        if (count($subdirs) > 1){
        	
        	array_pop($subdirs);
        	
        	$test_path = $cache_path.implode(DIRECTORY_SEPARATOR, $subdirs);
        
        	// check if specified subdir exists
        	if ( ! @file_exists($test_path)){
        		
	        	// create non existing dirs, asumes PHP5
	        	if ( ! @mkdir($test_path, DIR_WRITE_MODE, TRUE)) return FALSE;
        	}
        }
   
        $cache_path .= $uri.'.cache';

		if ( ! $fp = @fopen($cache_path, FOPEN_WRITE_CREATE_DESTRUCTIVE))
		{
			log_message('error', "Unable to write cache file: ".$cache_path);
			return;
		}
		
		$expire = time() + ($this->cache_expiration * 60);
		
		if (flock($fp, LOCK_EX))
		{
			fwrite($fp, $expire.'TS--->'.$output);
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
	
/**
	 * Update/serve a cached file
	 *
	 * @access	public
	 * @return	void
	 */	
	function _display_cache(&$CFG, &$URI)
	{
		$cache_path = ($CFG->item('cache_path') == '') ? BASEPATH.'cache/' : $CFG->item('cache_path');
			
		if ( ! is_dir($cache_path) OR ! is_really_writable($cache_path))
		{
			return FALSE;
		}
		
		
		$uri = $URI->uri_string();
		
		if(!strpos($uri, 'html')){
			
			$uri .= '/category';
		}
		
		$filepath = $cache_path.$uri.'.cache';

		
		if ( ! @file_exists($filepath))
		{
			return FALSE;
		}
	
		if ( ! $fp = @fopen($filepath, FOPEN_READ))
		{
			return FALSE;
		}
			
		flock($fp, LOCK_SH);
		
		$cache = '';
		if (filesize($filepath) > 0)
		{
			$cache = fread($fp, filesize($filepath));
		}
	
		flock($fp, LOCK_UN);
		fclose($fp);
					
		// Strip out the embedded timestamp		
		if ( ! preg_match("/(\d+TS--->)/", $cache, $match))
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

		// Display the cache
		$this->_display(str_replace($match['0'], '', $cache));
		log_message('debug', "Cache file is current. Sending it to browser.");		
		return TRUE;
	}
	
}

?>