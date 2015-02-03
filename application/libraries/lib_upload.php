<?php

/**
 * Описание файла: Библиотека для загрузки изображений на сервер
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib_upload {
    
    //Имя загружаемого файла
    var $filename = '';
    
    //Директорию в которую будет загружен файл
    var $dir = '/img';
                    
    var $error = '';
    
    var  $CI;
    
     var $iRules = array(
                        array('resize'=>'113x81','crop'=> true),
                        
                        array('resize'=>'161x107','crop'=> true),
                        
                        array('resize'=>'214x161','crop'=> true),
                        
                        array('resize'=>'242x167','crop'=> true),
                        
                        array('resize'=>'277x191','crop'=> true),
                        
                        array('resize'=>'350x250','crop'=> true),
                        
                        array('resize'=>'360x250','crop'=> true),
                        
                        array('resize'=>'397x302','crop'=> true),
                        
                        array('resize'=>'500x285','crop'=> true),
                        
                        array('resize'=>'')
                    );
    
	
	function Lib_upload () {
	   
        $this->CI = &get_instance ();
	   
       $this->dir = $_SERVER['DOCUMENT_ROOT'].$this->dir.'/'.date('dmY',time());
       
       $class = APPPATH.'libraries/lib_img_upload'.EXT;
       include_once($class);
		
	}
    
    
    function create_img($filename){
    	//var_dump($filename);
        
        if(empty($filename['tmp_name'])) return false;
  
        $this->CI->lib_img_upload = new lib_img_upload($filename);
        
        //$this->CI->load->library('lib_img_upload',$filename);
        
        if($this->CI->lib_img_upload->uploaded)
        {
            $size = GetImageSize($filename['tmp_name']);
            
            //Генерируем случайное название
            $imgname = uniqid();
            
            $this->CI->lib_img_upload->allowed = array('image/*');
            
            //Если правила на заданы, записываем оригинальный файл
            if(!is_array($this->iRules) || sizeof($this->iRules) == 0){   
                
                //Устанавливаем новое имя для картинки
                $this->CI->lib_img_upload->file_new_name_body  = $imgname;
                $this->CI->lib_img_upload->image_convert = 'jpg';
                $this->CI->lib_img_upload->Process($this->dir);
                
                if (!$this->CI->lib_img_upload->processed) return false;
                                                          
            }
            else{
                
                $error = 0;
                //Нарезаем изображения нужного размера
                foreach($this->iRules as $rule){               
    
                    
                    //Устанавливаем новое имя для картинки
                    $this->CI->lib_img_upload->file_new_name_body  = $imgname;
                    $this->CI->lib_img_upload->image_convert = 'jpg';
                    
                    //$crop = (!empty($rule['crop']))? true: false;
                    
                    $crop = false;

                    if(!empty($rule['checksize']) && !empty($rule['crop']) && $size[0] > $size[1]){
                    	$crop = false;
                    }
                    elseif(!empty($rule['crop']) && empty($rule['checksize'])){
                    	$crop = true;
                    }
                    
                    $auto_width = false;
                    
                	if(!empty($rule['check_height']) && $size[0] <= $size[1]){
                    	$crop = false;
                    	$auto_width = true;
                    }

                    
                    if (!empty($rule['resize'])) {
                        
                         //Устанавливаем новое имя для картинки, в зависимости от размеров
                        $this->CI->lib_img_upload->file_new_name_body  = $rule['resize'].'_'.$imgname;
                
                        $resWH = explode('x', $rule['resize']);                    
                        $this->set_img_resize($size[0],$size[1],$resWH[0],$resWH[1],$crop,$auto_width);  
                                                                          
                    }
                    
                    $add_watermark = (isset($rule['watermark']) && $rule['watermark'] == true )? true: false;
                    
                    if($add_watermark)
                    {
                        $this->CI->lib_img_upload->image_watermark = 'img/watermark.png';
                    
                        $this->CI->lib_img_upload->image_watermark_position = 'BR';
                    }
                    
                    
                    
                    $this->CI->lib_img_upload->Process($this->dir);
                    
                    if (!$this->CI->lib_img_upload->processed) $error++;
               
                }  
                
                
                if($error > 0) return false;
                                              
            }
            
            $this->CI->lib_img_upload->clean();
            echo $this->CI->lib_img_upload->error;
        
            return $imgname.'.jpg';
            
            
        }
        else return false;

        
    }
    
function create_local_img($filename){
  
        $this->CI->lib_img_upload = new lib_img_upload($filename);
        
        //$this->CI->load->library('lib_img_upload',$filename);
        
        if($this->CI->lib_img_upload->uploaded)
        {
	        /*$handle->file_new_name_body   = 'image_resized';
	   		$handle->image_resize         = true;
	    	$handle->image_x              = 100;
	     	$handle->image_ratio_y        = true;
	      	$handle->process('/home/user/files/');
	   		if ($handle->processed) {
	          echo 'image resized';
	          $handle->clean();
	       	} else {
	          echo 'error : ' . $handle->error;
	      	}*/
        	
        	
        	
            $size = GetImageSize($filename);
            
            //Генерируем случайное название
            $imgname = uniqid();
            
            $this->CI->lib_img_upload->allowed = array('image/*');
            
            //Если правила на заданы, записываем оригинальный файл
            if(!is_array($this->iRules) || sizeof($this->iRules) == 0){   
                
                //Устанавливаем новое имя для картинки
                $this->CI->lib_img_upload->file_new_name_body  = $imgname;
                $this->CI->lib_img_upload->image_convert = 'jpg';
                $this->CI->lib_img_upload->Process($this->dir);
                
                if (!$this->CI->lib_img_upload->processed) return false;
                                                          
            }
            else{
                
                $error = 0;
                //Нарезаем изображения нужного размера
                foreach($this->iRules as $rule){               
    
                    
                    //Устанавливаем новое имя для картинки
                    $this->CI->lib_img_upload->file_new_name_body  = $imgname;
                    $this->CI->lib_img_upload->image_convert = 'jpg';
                    
                    $crop = (!empty($rule['crop']))? true: false;
                    if (!empty($rule['resize'])) {
                        
                         //Устанавливаем новое имя для картинки, в зависимости от размеров
                        $this->CI->lib_img_upload->file_new_name_body  = $rule['resize'].'_'.$imgname;
                
                        $resWH = explode('x', $rule['resize']);                    
                        $this->set_img_resize($size[0],$size[1],$resWH[0],$resWH[1],$crop);  
                                                                          
                    }
                    
                    $add_watermark = (isset($rule['watermark']) && $rule['watermark'] == true )? true: false;
                    
                    if($add_watermark)
                    {
                        $this->CI->lib_img_upload->image_watermark = 'img/watermark.png';
                    
                        $this->CI->lib_img_upload->image_watermark_position = 'BR';
                    }
                    
                    
                    
                    $this->CI->lib_img_upload->Process($this->dir);
                    
                    if (!$this->CI->lib_img_upload->processed) $error++;
               
                }  
                
                
                if($error > 0) return false;
                                              
            }
            
            $this->CI->lib_img_upload->clean();
            //echo $this->CI->lib_img_upload->log;
        
            return $imgname.'.jpg';
            
            
        }
        else return false;

        
    }
    
    
    function create_zip_img($filename){
        
        if(empty($filename['tmp_name'])) return false;
        
        $this->CI->load->library('lib_img_upload',$filename);
        
        $this->CI->load->config('mimes',TRUE);
        
        if(!in_array($filename['type'],$this->CI->config->item('zip','mimes')))return false;
        
         $this->CI->load->plugin('pl_zip_read');
        
        if($this->CI->lib_img_upload->uploaded)
        {
            $size = GetImageSize($filename['tmp_name']);
            
            //Генерируем случайное название
            $imgname = uniqid();           
            
            $this->CI->lib_img_upload->image_convert = 'jpg';
            $this->CI->lib_img_upload->allowed = array('image/*');
            
            //Если правила на заданы, записываем оригинальный файл
            if(!is_array($this->iRules) || sizeof($this->iRules) == 0){   
                
                //Устанавливаем новое имя для картинки
                $this->CI->lib_img_upload->file_new_name_body  = $imgname;
               
                if($this->CI->lib_img_upload->Process($this->dir))
                    $this->CI->lib_img_upload->clean();                
            }
            else{
                
                //Нарезаем изображения нужного размера
                foreach($this->iRules as $rule){               
    
                    
                    //Устанавливаем новое имя для картинки
                    $this->CI->lib_img_upload->file_new_name_body  = $imgname;
                    
                    
                    $crop = (!empty($rule['crop']))? true: false;
                    if (!empty($rule['resize'])) {
                        
                         //Устанавливаем новое имя для картинки, в зависимости от размеров
                        $this->CI->lib_img_upload->file_new_name_body  = $imgname.'_'.$rule['resize'];
                
                        $resWH = explode('x', $rule['resize']);                    
                        $this->set_img_resize($size[0],$size[1],$resWH[0],$resWH[1],$crop);  
                                                                          
                    }
                    
                    if($this->CI->lib_img_upload->Process($this->dir)){
                        $this->CI->lib_img_upload->clean();
                    }
               
                }
            }
            
            return $imgname.$this->CI->lib_img_upload->image_convert;
            
        }

        
    }
    
    
    function set_img_resize($img_w,$img_h,$resize_x = 100,$resize_y = 100, $crop = false,$auto_width = false){
       
        $this->CI->lib_img_upload->image_resize = true; 
        
        if($crop){
            $this->CI->lib_img_upload->image_x = $resize_x;
            $this->CI->lib_img_upload->image_y = $resize_y;
            $this->CI->lib_img_upload->image_ratio_crop = true;
        }
        elseif(!$this->check_size($img_w,$img_h,$resize_x,$resize_y) && !$auto_width){
            
            $this->CI->lib_img_upload->image_x = $resize_x;
            $this->CI->lib_img_upload->image_ratio_y = true;
        }
        else{
            $this->CI->lib_img_upload->image_y = $resize_y;
            $this->CI->lib_img_upload->image_ratio_x = true;
        }

        
        
    }
    
    function check_size($img_w,$img_h,$resize_x,$resize_y){
        
        $test1 = $img_w/$img_h;
        
        $test2 = $resize_x/$resize_y;
        
        return ($test1 >= $test2)? true: false;
    
    }
    
    
   
    
    
    function show_error(){
        
        return $this->CI->lib_img_upload->error;
        
    }
	
	
	
}


?>