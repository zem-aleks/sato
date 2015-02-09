<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Articles extends ModuleController {

    public static $config = array(
        'name' => 'articles',
        'title' => 'Статьи',
        'uri' => 'articles',
        'upload_folder' => 'articles',
        'tb' => 'articles',
        'perPage' => 10,
        'mainPage' => 'articles',
        'media_fields' => array('image', 'thumb'),
    );
    public static $md = 'mdl_articles';
    
    public function __construct() {
        parent::__construct(self::$config, self::$md);
    }
    
    public function modifyEntry($entry)
    {
        $entry['date'] = modifyDate($entry['date']);
        return $entry;
    }
    
    public function modifyViewContent($content)
    {
        $content['last'] = $this->getEntries(0, 4, 1);
        foreach ($content['last'] as $key => $entry)
            if($entry['ID'] == $content['view']['ID'])
                unset($content['last'][$key]);
            
        if(count($content['last']) > 3)
            unset($content['last'][rand(0, 3)]);
           
        return $content;
    }
}
