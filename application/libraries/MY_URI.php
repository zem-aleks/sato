<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_URI extends CI_URI
{
    function _filter_uri($str)
    {
        if ($str != '' AND $this->config->item('permitted_uri_chars') != '')
        {
	    if ( ! preg_match("|^[".str_replace(array('\\-', '\-'), '-', preg_quote($this->config->item('permitted_uri_chars'), '-'))."]+$|ui", $str))
            //if ( ! preg_match("|^[".preg_quote($this->config->item('permitted_uri_chars'))."]+$|ui", $str))
           {
               exit('The URI you submitted has disallowed characters.');
           }
       }
           
       return $str;
    }
}
