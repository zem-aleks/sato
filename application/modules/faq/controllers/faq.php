<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faq extends ModuleController {
    
    public static $config = array(
        'name' => 'faq',
        'title' => 'Вопрос-ответ',
        'uri' => 'faq',
        'upload_folder' => 'faq',
        'tb' => 'faq',
        'perPage' => 9,
        'mainPage' => 'faq'
    );
    public static $md = 'mdl_faq';
    
    
    public function __construct() {
        parent::__construct(self::$config, self::$md);
    }
    
    public function getSlider($count)
    {
        $content = array();
        $content['entries'] = $this->getEntries(0, $count, 1);
        foreach($content['entries'] as &$entry) {
            $entry['answer'] = word_limiter($entry['answer'], 24);
        }
        return $this->load->view('slider', $content, TRUE);
    }
    
    public function modifyIndexContent($content) {
        $this->load->helper('text');
        foreach($content['entries'] as &$entry) {
            $entry['answer'] = word_limiter($entry['answer'], 24);
        }
        return $content;
    }
    
    
    
}
