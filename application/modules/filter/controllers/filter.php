<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Filter extends Controller {

    private static $md = 'mdl_form';

    function Filter() {
        parent::__construct();
        session_start();
        //$this->load->model(self::$md);
    }

    function initFilters($filters, $where) {
        $result = array();
        if (!empty($filters['price'])) {
            if (!empty($filters['price']['from'])) {
                $where['c1.price >='] = $filters['price']['from'];
            }
            if (!empty($filters['price']['to'])) {
                $where['c1.price <='] = $filters['price']['to'];
            }
        }

        $where_in = array();
        $k = 0;
        if (!empty($filters['brands'])) {
            $where_in[$k]['field'] = 'c1.id_brand';
            $where_in[$k]['array'] = array();
            foreach ($filters['brands'] as $value) {
                $where_in[$k]['array'][] = $value;
            }
        }
        ++$k;
        
        $k = 0;
        if (!empty($filters['colors'])) {
            $where_in[$k]['field'] = 'c1.id_color';
            $where_in[$k]['array'] = array();
            foreach ($filters['colors'] as $value) {
                $where_in[$k]['array'][] = $value;
            }
        }
        ++$k;

        $result['where'] = $where;
        $result['where_in'] = $where_in;
        return $result;
    }

    function filtering() {
        $filters = array();
        $filters['price'] = array();
        $filters['brands'] = array();
        $filters['colors'] = array();
        $filters['display'] = false;
        $need_save = false;
        if (isset($_POST['rollback']) && $_POST['rollback'] == 'filter') {
            $need_save = true;
            $from = $this->input->post('interval-from', TRUE);
            $to = $this->input->post('interval-to', TRUE);
            $brands = $this->input->post('brands', TRUE);
            $colors = $this->input->post('colors', TRUE);

            if (!empty($from)) {
                $filters['price']['from'] = (int) $from;
                $filters['display'] = true;
                $need_save = true;
            }
            if (!empty($to)) {
                $filters['price']['to'] = (int) $to;
                $filters['display'] = true;
                $need_save = true;
            }
            if (!empty($brands)) {
                foreach ($brands as $key => $value) {
                    $filters['brands'][] = (int) $key;
                }
                $filters['display'] = true;
                $need_save = true;
            }
            if (!empty($colors)) {
                foreach ($colors as $key => $value) {
                    $filters['colors'][] = (int) $key;
                }
                $filters['display'] = true;
                $need_save = true;
            }

            if ($need_save) {
                $_SESSION['filters'] = $filters;
                redirect($_SERVER['REQUEST_URI']);
            }
        } elseif (isset($_SESSION['filters'])) {
            $filters = $_SESSION['filters'];
        }
        return $filters;
    }

    function firstSorting() {
        $values = array('c1.rating desc', 'c1.price asc', 'c1.price desc', 'c1.name', 'c1.date_create');
        $order_by = $values[0];
        if (isset($_POST['sort'])) {
            $sort = $this->input->post('sort', TRUE);
            if (in_array($sort, $values)) {
                $order_by = $sort;
                $_SESSION['firstSort'] = $sort;
                redirect($_SERVER[REQUEST_URI]);
            }
        } elseif ($_SESSION['firstSort'] && in_array($_SESSION['firstSort'], $values)) {
            $order_by = $_SESSION['firstSort'];
        }
        return $order_by;
    }

    function secondSorting() {
        $max = 60;
        $limit = 20;
        if (isset($_POST['sort2'])) {
            $sort = (int) $this->input->post('sort2', TRUE);
            if ($sort <= $max) {
                $limit = $sort;
                $_SESSION['secondSort'] = $sort;
                redirect($_SERVER['REQUEST_URI']);
            }
        } elseif ($_SESSION['secondSort'] && $_SESSION['secondSort'] <= $max) {
            $limit = $_SESSION['secondSort'];
        }
        return $limit;
    }
    
    function search($str = false)
    {
        $like = array();
        if (isset($_POST['search']) && !$str) {
            $str = $this->input->post('search', TRUE);
            $str = trim($str);
            if(strlen($str) >= 3)
            {
                $like = array('c1.name' => $str);
                $_SESSION['search'] = $like;
                redirect($_SERVER['REQUEST_URI']);
            }
        } elseif($str){
            if(strlen($str) >= 3)
            {
                $like = array('c1.name' => $str);
                $_SESSION['search'] = $like;
            }
        } elseif(isset($_SESSION['search'])) {
            $like = $_SESSION['search'];
        }
        
        return $like;
    }

}

