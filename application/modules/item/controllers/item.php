<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Item extends Controller {

    public $name = 'item';
    public $md = 'mdl_item';

    function Item() {
        parent::__construct();
        //error_reporting(E_ALL);
        session_start();
        $this->load->model($this->md);
    }

    /* -----------------------admin function--------------------- */

    function admin_index($filter = 'all', $page = 0) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }

        $content = array();
        if ($filter == 'admin_index')
            $filter = 'all';

        if (isset($_POST['cat_filter']) || isset($_POST['sort_items'])) {
            $_SESSION['item_cat'] = $this->input->post('cat_filter');
            $_SESSION['item_sort'] = $this->input->post('sort_items');
            redirect('/dashboard/item/admin_index/' . $filter . '/');
        }

        $this->load->model('category/mdl_category');
        $categories = $this->mdl_category->getCatsForMenuEdit(1, 1);
        if (isset($_SESSION['item_cat']) && $_SESSION['item_cat'] != 0) {
            $content['selected'] = $_SESSION['item_cat'];
        }
        $content['categories'] = array();
        $content['table_title'] = 'Все товары';
        $top = false;
        foreach ($categories as $value) {
            if($content['selected'] == $value['ID'])
                $content['table_title'] = $value['cat_name'];
            if($content['selected'] == $value['id_parent'])
                $content['table_title'] = 'Все ' . $value['top'];
            if ($value['top'] != $top) {
                $top = $value['top'];
                $content['categories'][$value['top']][] = array(
                    'ID' => $value['id_parent'],
                    'cat_name' => 'Все ' . $value['top']
                );
            }
            $content['categories'][$value['top']][] = $value;
        }


        

        $per_page = 20;
        $content['title'] = 'Товары';
        $content['key'] = 0;
        $content['pages'] = $this->mdl_item->getAllPagesAdmin($page / $per_page, $filter, $content['selected'], $_SESSION['item_sort']);
        $content['filter'] = $filter;

        $this->load->library('pagination');
        $config['base_url'] = '/dashboard/item/admin_index/' . $filter . '/';
        $config['total_rows'] = $this->mdl_item->getAllPagesCount($filter, $content['selected']);
        $config['num_links'] = 5;
        $config['per_page'] = $per_page;
        $config['cur_page'] = $page;
        $config['first_link'] = 'Первая';
        $config['last_link'] = 'Последняя';
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $content['paginator'] = $this->pagination->create_links();

        $content['sort_list'] = array(
            'ID asc' => 'Артикулу (по возр.)',
            'ID desc' => 'Артикулу (по убыв.)',
            'name asc' => 'Названию (по возр.)',
            'name desc' => 'Названию (по убыв.)',
            'price asc' => 'Цене (по возр.)',
            'price desc' => 'Цене (по убыв.)'
        );
        $content['sort'] = $_SESSION['item_sort'];

        $this->load->view('includes/admin_header', $content);
        $this->load->view('list', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function addPage() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content = array();
        $content['title'] = 'Добавить товар';
        $this->load->model('category/mdl_category');
        $this->load->model('dictionary/mdl_dictionary');
        $categories = $this->mdl_category->getCatsForMenuEdit(1, 1);
        $content['categories'] = array();
        foreach ($categories as $value)
            $content['categories'][$value['top']][] = $value;

        $content['colors'] = $this->mdl_dictionary->getDictionary('color');
        $content['materials'] = $this->mdl_dictionary->getDictionary('material');
        $content['brands'] = $this->mdl_dictionary->getDictionary('brand');
        $content['statuses'] = array(
            -1 => 'Ожидается поставка', 
            0 => 'Нет в наличии', 
            1 => 'В наличии', 
            2 => 'Предзаказ'
        );

        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function editPage($id_page) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content = array();
        
        $content['item'] = $this->mdl_item->getPageInfo($id_page);
        $content['item']['related_items'] = $this->mdl_item->getItemsByIds($content['item']['related_items'], 'c1.ID, c1.name');
        $content['title'] = $content['item']['name'] . ' (редактирование)';
        $this->load->model('category/mdl_category');
        $this->load->model('dictionary/mdl_dictionary');

        $categories = $this->mdl_category->getCatsForMenuEdit(1, 1);
        $content['categories'] = array();
        foreach ($categories as $value)
            $content['categories'][$value['top']][] = $value;

        $content['colors'] = $this->mdl_dictionary->getDictionary('color');
        $content['materials'] = $this->mdl_dictionary->getDictionary('material');
        $content['brands'] = $this->mdl_dictionary->getDictionary('brand');
        $content['statuses'] = array(
            -1 => 'Ожидается поставка', 
            0 => 'Нет в наличии', 
            1 => 'В наличии', 
            2 => 'Предзаказ'
        );
        
        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function add() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->mdl_item->add();
        redirect('dashboard/item');
    }

    function edit($id_page) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->mdl_item->edit($id_page))
            redirect('dashboard/item/editPage/' . $id_page);
        else
            redirect('dashboard/item/editPage/' . $id_page);
    }

    function sort() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->mdl_item->sort();
    }

    function status($id_cat, $status) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->mdl_item->status($id_cat, $status)) {
            redirect('dashboard/item');
        } else {
            echo "no";
        }
    }

    function delPage($id) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->mdl_item->del($id);
        redirect('dashboard/item');
    }

    /* ----------------end admin functions---------------------- */

    function getItemsCount($field, $value) {
        return $this->mdl_item->getItemsCount($field, $value);
    }

    function getItemsByCategory($id_category, $limit = -1, $start = 0) {
        //$defArray=array(0,1,2,3,4,5,6,7,8,9,10,20,30,40,50,60,70,80,90,100);
        $result = $this->mdl_item->getItemsByCategory($id_category, $limit, $start);
        /* foreach ($result as &$value) {
          if (empty($value['count_row']))
          $value['count_row'] = $defArray;
          else {
          $value['count_row'] = array_filter(explode(',', $value['count_row']),function($var){
          return (int)$var;
          });
          }

          $value['count_selected']=0;
          if(isset($_SESSION['cart']))
          foreach($_SESSION['cart'] as $product)
          {
          if($product['id']==$value['ID'])
          $value['count_selected']=$product['count'];
          }
          } */
        //unset($value);

        return $result;
    }

    function getItemById($id_item) {
        return $this->mdl_item->getItemById($id_item);
    }

    function getItemsInterval($id_from, $id_to, $limit) {
        return $this->mdl_item->getItemsInterval($id_from, $id_to, $limit);
    }

    function getItemsByIds($ids) {
        return $this->mdl_item->getItemsByIds($ids);
    }

    function findItem($field, $value, $limit) {
        return $this->mdl_item->findItem($field, $value, $limit);
    }

    function findItems($text, $limit = 0, $start = 0) {
        return $this->mdl_item->findItems($text, $limit, $start);
    }

    function findCountItems($text) {
        return $this->mdl_item->findCountItems($text);
    }

    /* function findItemLinks($field,$value)
      {
      return $this->mdl_item->findItemLinks($field,$value);
      } */

    function export() {
        $this->load->module('export')->exportFile('product', array('ID', 'convert(name USING cp1251)', 'price', 'convert(content USING cp1251)', 'id_catalog', '`date`'), $_SERVER['DOCUMENT_ROOT'] . '/load/product.csv');
    }

    function import() {
        $info = $this->load->module('export')->importFile('product', array('ID', 'name', 'price', 'content', 'id_catalog', '`date`'));
        if ($info['status'] === 1) { // import success
            $_SESSION['status'] = 1;
            redirect('/dashboard/item');
        } else { // import unsuccess
            $_SESSION['status'] = 0;
            $_SESSION['error'] = $info['error'];
            redirect('/dashboard/item');
        }
    }

    function getLastNewItems($count, $start = 0) {
        return $this->mdl_item->getLastNewItems($count, $start);
    }

    function getPageCHPU($str) {
        return $this->mdl_item->getPageCHPU($str);
    }

    function getUniversal($select = '*', $where = array(), $count = 0, $start = 0, $order_by = '', $like = array(), $where_in = array()) {
        return $this->mdl_item->getUniversal($select, $where, $count, $start, $order_by, $like, $where_in);
    }

    function getUniversalCount($where = array(), $like = array(), $where_in = array()) {
        return $this->mdl_item->getUniversalCount($where, $like, $where_in);
    }

    function initItemImages(&$items, $limit = 1) {
        $this->mdl_item->initItemImages($items, $limit);
    }

    function getField($field, $type, $where = array()) {
        if ($type == 'max')
            $this->db->select_max($field, 'field');
        elseif ($type == 'min')
            $this->db->select_min($field, 'field');
        $this->db->from('item as c1');
        $this->db->join('cat_item c3', 'c1.ID = c3.id_page', 'LEFT OUTER');
        $this->db->join('categories c2', 'c3.id_cat = c2.ID', 'LEFT OUTER');
        if (!empty($where))
            $this->db->where($where);
        $query = $this->db->get();
        $result = $query->row_array();
        //echo $this->db->last_query();
        return $result['field'];
    }

    function initCategories(&$items, $menu) {
        foreach ($items as &$item) {
            $is_find = false;
            $item['sub'] = array();
            $item['top'] = array();

            foreach ($menu as $top) {
                foreach ($top['children'] as $sub) {
                    //var_dump($sub);
                    //echo $sub['ID'] . ' != ' . $item['id_parent'] . ' <>';
                    if ($item['id_parent'] == $sub['ID']) {

                        $item['sub'] = $sub;
                        $item['top'] = $top;
                        $is_find = true;
                        break;
                    }
                }

                if ($is_find)
                    break;
            }
        }
    }

}

