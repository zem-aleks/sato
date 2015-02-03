<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services extends ModuleController {
    
    public static $config = array(
        'name' => 'services',
        'title' => 'Услуги',
        'uri' => 'services',
        'upload_folder' => 'services',
        'tb' => 'services',
        'perPage' => 9,
        'mainPage' => 'services',
        'media_fields' => array(),
    );
    public static $md = 'mdl_services';
    
    
    public function __construct() {
        parent::__construct(self::$config, self::$md);
    }
    
    public function getCategories()
    {
        $categories = array();
        $settings = Modules::run('settings/getListSettings');
        $lists = explode("\n\n", $settings['sericeCategories']);
        foreach ($lists as $list) {
            $elements = explode("\n", $list);
            $isFirst = true;
            foreach ($elements as $element) {
                $items = explode("- ", $element);
                if(count($items) > 0 && !empty($items[1])) {
                    $category = trim($items[1]);
                    if($isFirst) {
                        $categories[] = array('name' => $category, 'children' => array());
                        $isFirst = false;
                    } else {
                        $categories[count($categories) - 1]['children'][] = $category;
                    }
                }
            }
        }
        
        return $categories;
    }
    
    public function getCategoriesList()
    {
        $list = array();
        $categories = $this->getCategories();
        foreach ($categories as $key1 => $top) {
            foreach ($top['children'] as $key2 => $category) {
                $list[$key1 . '-' . $key2] = $top['name'] . ' - ' . $category;
            }
        }
        return $list;
    }
    
    function modifyIndexContent($content) {
        $content['services'] = $this->load->module('services')->getEntries(0, 50, 1);
        $content['service_categories'] = $this->{$this->md}->getServiceCategories();
        return $content;
    }
    
    function modifyViewContent($content) {
        $content['page'] = 'services';
        $content['services'] = $this->getEntries(0, 50, 1);
        shuffle($content['services']);
        return $content;
    }
    
    function getScategories()
    {
        return $this->{$this->md}->getServiceCategories();
    }
    
    function modifyAdminIndexContent($content) {
        $content['service_categories'] = $this->{$this->md}->getServiceCategories();
        return $content;
    }
    
    function modifyAdminAddContent($content) {
        $content['service_categories'] = array();
        $cats = $this->{$this->md}->getServiceCategories();
        foreach ($cats as $value) {
            $content['service_categories'][$value['ID']] = $value['name'];
        }
        return $content;
    }
    
}
