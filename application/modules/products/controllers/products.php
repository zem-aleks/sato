<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends ModuleController {

    public static $config = array(
        'name' => 'products',
        'title' => 'Продукция',
        'uri' => 'products',
        'upload_folder' => 'products',
        'tb' => 'products',
        'perPage' => 10,
        'mainPage' => 'products',
        'media_fields' => array('image', 'thumb'),
    );
    public static $md = 'mdl_products';

    public function __construct()
    {
        parent::__construct(self::$config, self::$md);
    }

    public function modifyEntry($entry)
    {
        $this->db->where('id_item', $entry['ID']);
        $this->db->order_by('ID ASC');
        $query = $this->db->get('images');
        
        $entry['image'] = 'no_image.jpg';
        $entry['images'] = $query->result_array();
        if(!empty($entry['images']))
            $entry['image'] = $entry['images'][0]['image'];
        $entry['brand'] = $this->load->module('dictionary')->getValue($entry['id_brand']);
        $entry['category'] = $this->load->module('dictionary')->getValue($entry['id_category']);
        $entry['date'] = modifyDate($entry['date']);
        $entry['price'] = number_format((int)$entry['price'], 0, ',', ' ');
        //($number, 2, ',', ' ');
        return $entry;
    }
    
    public function modifyAdminAddContent($content)
    {
        $this->load->model('dictionary/mdl_dictionary');
        $content['brands'] = $this->mdl_dictionary->getDictionary('brands');
        $content['categories'] = $this->mdl_dictionary->getDictionary('categories');
        return $content;
    }
    
    public function modifyAdminEditContent($content)
    {
        $this->load->model('dictionary/mdl_dictionary');
        $content['brands'] = $this->mdl_dictionary->getDictionary('brands');
        $content['categories'] = $this->mdl_dictionary->getDictionary('categories');
        $this->db->where('id_item', $content['page']['ID']);
        $this->db->order_by('ID ASC');
        $query = $this->db->get('images');
        $content['page']['images'] = $query->result_array();
        return $content;
    }
    
    public function modifyViewContent($content)
    {
        $content['product'] = $content['view'];
        return parent::modifyViewContent($content);
    }


}
