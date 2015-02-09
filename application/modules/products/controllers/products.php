<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Products extends ModuleController {

    public static $config = array(
        'name' => 'products',
        'title' => 'Товары',
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
        $entry['date'] = modifyDate($entry['date']);
        return $entry;
    }


}
