<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Portfolio extends ModuleController {
    
    public static $config = array(
        'name' => 'gallery',
        'title' => 'Работы',
        'uri' => 'portfolio',
        'upload_folder' => 'portfolio',
        'tb' => 'portfolio',
        'perPage' => 1000,
        'mainPage' => 'portfolio',
        'media_fields' => array('image', 'thumb'),
    );
    public static $md = 'mdl_portfolio';
    
    
    public function __construct() {
        parent::__construct(self::$config, self::$md);
    }
    
    public function getSlider($count, $title = '')
    {
        $content = array();
        $content['works'] = $this->getEntries(0, $count, 1);
        $content['upload_folder'] = self::$config['upload_folder'];
        $content['title'] = $title;
        return $this->load->view('slider', $content, TRUE);
    }
    
}
