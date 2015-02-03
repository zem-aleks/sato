<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends Controller {

    var $tb = 'categories';
    var $md = 'mdl_category';

    function Category() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model($this->md);
    }

    function admin_index($cat_id = '', $start_row = 0, $sort_field = '', $fs = '') {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        } else {
            $content = array();
            $content['title'] = 'Меню';
            $content['categories'] = $this->mdl_category->getlist();

            $this->load->view('includes/admin_header', $content);
            $this->load->view('list', $content);
            $this->load->view('includes/admin_footer', $content);
        }
    }

    function sort() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $id1 = $this->input->post('id1', TRUE);
        $id2 = $this->input->post('id2', TRUE);
        $cat1 = $this->getCategory($id1);
        $cat2 = $this->getCategory($id2);
        if(!empty($cat1['sort']) && !empty($cat2['sort']) && $cat1['sort'] != $cat2['sort']) {
            $this->db->where('ID', $cat1['ID']);
            $this->db->update($this->tb, array('sort' => $cat2['sort']));
            
            $this->db->where('ID', $cat2['ID']);
            $this->db->update($this->tb, array('sort' => $cat1['sort']));
            echo 1;
        } else 
            echo -1;
    }

    function getTopMenu() {
        return $this->mdl_category->getTopMenu();
    }

    function getCategoryListByField($name_field, $name_value, $settings = null) {
        return $this->mdl_category->getCategoryListByField($name_field, $name_value, $settings);
    }

    function getCategoriesOfParent($id_parent) {
        return $this->mdl_category->getCategoriesOfParent($id_parent);
    }

    function getCategoryList() {
        return $this->mdl_category->getCategoriesList();
    }

    function getDisplayCategory() {
        return $this->mdl_category->getDisplayCategory();
    }

    function add() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content['title'] = 'Добавление элемента меню';
        //$content['pages'] = $this->load->module('pages')->getPages();
        //$content['categories'] = $this->{$this->md}->getCatsForMenuEdit(0, 0);
        //$content['items'] = $this->load->module('item')->getUniversal('c1.ID, c1.name, c2.cat_name', array(), 0, 0, 'c1.name');
        /*foreach ($content['items'] as &$value) {
            $value['name'] = $value['name'] . ' (' . $value['cat_name'] . ')';
        }*/

        $this->load->view('includes/admin_header', $content);
        $this->load->view('add', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function edit($id_cat) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content['title'] = 'Редактирование элемента меню';
        $content['category'] = $this->{$this->md}->getCategory($id_cat);
        /*$content['pages'] = $this->load->module('pages')->getPages();
        $content['categories'] = $this->{$this->md}->getCatsForMenuEdit(0, 0);
        $content['items'] = $this->load->module('item')->getUniversal('c1.ID, c1.name, c2.cat_name', array(), 0, 0, 'c1.name');
        foreach ($content['items'] as &$value) {
            $value['name'] = $value['name'] . ' (' . $value['cat_name'] . ')';
        }*/
        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function del($id) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $this->{$this->md}->del($id);
        redirect('dashboard/category');
    }

    function addCategory() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->add()) {
            redirect('dashboard/category');
        } else {
            redirect('dashboard/category/add');
        }
    }

    function editCategory($id_cat) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->edit($id_cat)) {
            redirect('dashboard/category');
        } else {
            redirect('dashboard/category/edit/' . $id_cat);
        }
    }

    function status($id_cat, $status) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->status($id_cat, $status)) {
            redirect('dashboard/category');
        } else {
            echo "no";
        }
    }

    function drag() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->{$this->md}->drag()) {
            redirect('dashboard/category');
        } else {
            echo "no";
        }
    }

    function listGoods($id) {
        $content['title'] = 'Товары производителя';
        $content['goods'] = $this->{$this->md}->getGoodsForCat($id);

        $this->load->view('includes/admin_header', $content);
        $this->load->view('editCatGoods', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function loadShop($shop_chpu) {
        $shops = $this->{$this->md}->getCategoryListByField('chpu', $shop_chpu, array('type' => 'massiv'));
        if (count($shops) > 0) {
            return $shops[0];
        } else {
            show_404();
            exit();
        }
    }

    function loadCategory($category_chpu) {
        $categories = $this->load->module('category')->getCategoryListByField('chpu', $category_chpu, array('type' => 'massiv'));
        if (count($categories) > 0) {
            return $categories[0];
        } else {
            show_404();
            exit();
        }
    }

    /**
     * Создает список категорий по указанным начальному и конечному уровню глубины
     * 
     * @param int $levelBegin с этого уровня категории добавляются в список (начинается с 0)
     * @param int $levelEnd до этого уровня ищутся категории
     * @param int $id_parent корень от которого начинают искаться категории
     * @param int $level текущий уровень поиска
     * 
     * @return array|false  возвращает массив категорий или ложь, если ничего не найденно
     */
    function getCatsForMenuEdit($levelBegin = 0, $levelEnd = 1, $id_parent = 0, $level = 0) {
        return $this->{$this->md}->getCatsForMenuEdit($levelBegin, $levelEnd, $id_parent, $level);
    }

    function getMenu($id_parent = 0) {
        return $this->{$this->md}->getMenu($id_parent);
    }

    function getCategory($id_cat) {
        return $this->{$this->md}->getCategory($id_cat);
    }
    
    function getCategoryCHPU($chpu, $where = array()) {
        return $this->{$this->md}->getCategoryCHPU($chpu, $where);
    }
    
    function getCategoryBrands($id_category){
        $this->db->select('c1.ID as id_brand, c1.name');
        $this->db->distinct();
        $this->db->from('item_options c1');
        $this->db->join('item c2', 'c2.id_brand = c1.ID');
        $this->db->join('cat_item c3', 'c3.id_page = c2.ID');
        $this->db->where('c1.type', 'brand');
        $this->db->where('c3.id_cat', $id_category);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function getCategoryColors($id_category)
    {
        $this->db->select('c1.ID, c1.name, c1.content');
        $this->db->distinct();
        $this->db->from('item_options c1');
        $this->db->join('item c2', 'c2.id_color = c1.ID');
        $this->db->join('cat_item c3', 'c3.id_page = c2.ID');
        $this->db->where('c1.type', 'color');
        $this->db->where('c3.id_cat', $id_category);
        $query = $this->db->get();
        return $query->result_array();
    }

}