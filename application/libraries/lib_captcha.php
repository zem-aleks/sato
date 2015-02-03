<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lib_captcha{

	var $use_symbols = "0123456789"; // Здесь Только те буквы, которые Вы хотите выводить
	
	var $amplitude_min=10; // Минимальная амплитуда волны
	var $amplitude_max=20; // Максимальная амплитуда волны
	
	var $font_width=25; // Приблизительная ширина символа в пикселях
	
	var $rand_bsimb_min=3; // Минимальное расстояние между символами (можно отрицательное)
	var $rand_bsimb_max=5; // Максимальное расстояние между символами
	
	var $margin_left=10;// отступ слева
	var $margin_top=50; // отступ сверху
	
	var $font_size=40; // Размер шрифта
	
	var $jpeg_quality = 90; // Качество картинки
	var $length = 6; 
		
		
	 function Lib_captcha(){
       $this->keystring='';
			
		for($i=0;$i<$this->length;$i++)
			$this->keystring.=$this->use_symbols{mt_rand(0,strlen($this->use_symbols)-1)};
    }

	function draw(){
	
				
			$im=imagecreatefromgif('captcha/back.gif');
			
			$width = imagesx($im);
			$height = imagesy($im);
			$rc=mt_rand(120,140);
			$font_color = imagecolorresolve($im, $rc, $rc,$rc);
			$px =$this->margin_left;
			
			
			for($i=0;$i<$this->length;$i++){
				imagettftext($im,$this->font_size,mt_rand(-5,10),$px, $this->margin_top,$font_color,'captcha/CARTOON8.TTF',$this->keystring[$i]);
				$px+=$this->font_width+mt_rand($this->rand_bsimb_min,$this->rand_bsimb_max); 
			}
			
			$h_y=mt_rand(0,$height);
			$h_y1=mt_rand(0,$height);
			imageline($im,mt_rand(0,20),$h_y,mt_rand($width-20,$width),$h_y1,$font_color);
			imageline($im,mt_rand(0,20),$h_y,mt_rand($width-20,$width),$h_y1,$font_color);
			$h_y=mt_rand(0,$height);
			$h_y1=mt_rand(0,$height);
			imageline($im,mt_rand(0,20),$h_y,mt_rand($width-20,$width),$h_y1,$font_color);
			imageline($im,mt_rand(0,20),$h_y,mt_rand($width-20,$width),$h_y1,$font_color);
			
			$this->image_make_pomexi($im,50,80);
			
			$rand=mt_rand(0,1);
			if ($rand)$rand=-1; else $rand=1;
			$this->wave_region($im,0,0,$width,$height,$rand*mt_rand($this->amplitude_min,$this->amplitude_max),mt_rand(30,40));
			header('Expires: Sat, 17 May 2008 05:00:00 GMT'); 
			header('Cache-Control: no-store, no-cache, must-revalidate'); 
			header('Cache-Control: post-check=0, pre-check=0', FALSE); 
			header('Pragma: no-cache');
			if(function_exists("imagejpeg")){
				header("Content-Type: image/jpeg");
				imagejpeg($im, null, $this->jpeg_quality);
			}else if(function_exists("imagegif")){
				header("Content-Type: image/gif");
				imagegif($im);
			}else if(function_exists("imagepng")){
				header("Content-Type: image/x-png");
				imagepng($im);
			}
	 }
	 
	 
	 
 	function getKeyString(){
		return $this->keystring;
	}


	function wave_region($img, $x, $y, $width, $height,$amplitude = 4.5,$period = 30){
		$mult = 2;
		$img2 = imagecreatetruecolor($width * $mult, $height * $mult);
		imagecopyresampled ($img2,$img,0,0,$x,$y,$width * $mult,$height * $mult,$width, $height);
		
		for ($i = 0;$i < ($width * $mult);$i += 2)
		   imagecopy($img2,$img2,$x + $i - 2,$y + sin($i / $period) * $amplitude,$x + $i,$y, 2,($height * $mult));
		
		imagecopyresampled($img,$img2,$x,$y,0,0,$width, $height,$width * $mult,$height * $mult);
		imagedestroy($img2);
	 }

	function image_make_pomexi(&$im,$size,$colch){
	   $max_x=imagesx($im);
	   $max_y=imagesy($im);
	  
	   for ($i=0;$i<=$colch;$i++){
			$size=mt_rand(10,$size);
			$px1=mt_rand(0,$max_x);
			$py1=mt_rand(0,$max_y);
			$col=imagecolorresolve($im, 255, 255, 255); 
			$pk1=mt_rand(-1,1);
			$pk2=mt_rand(-1,1);
			imageline($im,$px1,$py1,$px1+$size*$pk1,$py1+$size*$pk2,$col);
		}	
	}

}
?>