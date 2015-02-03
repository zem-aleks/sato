<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Template extends Controller {

	private static $md = 'mdl_template';

	function Template(){
            parent::__construct();
            session_start();
            $this->load->model(self::$md);
	}
        
        function loadDefaultData()
        {
            //$this->load->module('cart')->loadCart();
            $content = array();
            $content['breadcrumbs']=array();
            $content['menu'] = $this->load->module('category')->getMenu();
            $content['settings']=$this->load->module('settings')->getListSettings();
            $content['cart'] = $this->load->module('cart')->getCart();
            $content['cart_sum'] = 0;
            foreach ($content['cart'] as $item)
                if((bool)$item['is_on_stock'])
                    $content['cart_sum'] += $item['price'] * $item['count'];
            
            return $content;
        }
	

}

