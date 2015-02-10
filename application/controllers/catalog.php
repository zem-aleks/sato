<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Catalog extends Controller {


    function Main()
    {
        parent::__construct();
        session_start();
    }

    function index($idCategory = 0, $order = 'asc')
    {
        $perPage = 6;
        $this->load->helper('text');
        $this->load->model('dictionary/mdl_dictionary');
        $content = $this->load->module('template')->loadDefaultData();
        $content['about'] = $this->load->module('pages')->getPageCHPU('about');
        $content['page'] = 'catalog';
        $content['info'] = $this->load->module('pages')->getPageCHPU('catalog');
        $content['title'] = $content['info']['title'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];
        $content['categories'] = $this->mdl_dictionary->getDictionary('categories');
        $content['products'] = $this->products(0, $perPage, $idCategory, 'c1.price ' . $order);
        $content['current'] = array(
            'category' => $idCategory,
            'order' => $order,
        );

        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('templates/catalog', $content);
        $this->load->view('templates/footer', $content);
    }
    
    function products($start = 0, $limit = 6, $idCategory = 0, $order = 'c1.price ASC')
    {
        $condition = array();
        if($idCategory > 0)
            $condition = array('id_category' => $idCategory);
        $products = $this->load->module('products')->getFilterEntries($start, $limit, 1, $condition, $order);
        return $products;
    }
    
    function productsJson($start = 0, $limit = 6, $idCategory = 0, $order = 'ASC')
    {
        $result = array('status' => 0);
        $products = $this->products($start, $limit, $idCategory, 'c1.price ' . $order);
        if(count($products) > 0) {
            $result['status'] = 1;
            $result['html'] = '';
            foreach ($products as $product)
                $result['html'] .= $this->load->view('templates/item', array('product' => $product), TRUE);
        }
        
        echo json_encode($result);
    }

}

?>