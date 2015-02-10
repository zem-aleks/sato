<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cart extends Controller {

    private static $md = 'mdl_cart';

    function Cart() {
        parent::__construct();
        $this->load->model(self::$md);
    }
    
    function index()
    {
        $this->load->helper('text');
        $content = $this->load->module('template')->loadDefaultData();
        $content['about'] = $this->load->module('pages')->getPageCHPU('cart');
        $content['models'] = $this->load->module('products')->getFilterEntries(0, 9, 1, array('on_main' => 1), 'c1.sort');
        
        $content['page'] = 'main';
        $content['info'] = $this->load->module('pages')->getPageCHPU('main');
        $content['title'] = $content['info']['title'];
        $content['description'] = $content['info']['mdesc'];
        $content['keywords'] = $content['info']['mkeys'];
        
        $content['breadcrumbs'][] = array('url' => '/cart' , 'name' => 'Корзина');

        $this->load->view('templates/header', $content);
        $this->load->view('templates/breadcrumbs', $content);
        $this->load->view('templates/cart', $content);
        $this->load->view('templates/footer', $content);
    }

    function admin_index($cat_id = '', $start_row = 0, $sort_field = '', $fs = '') {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        } else {
            $content = array();

            $this->load->view('includes/admin_header', $content);
            $this->load->view('list', $content);
            $this->load->view('includes/admin_footer', $content);
        }
    }

    // load cart from cookies
    function loadCart() {
        if (!isset($_SESSION['cart']) && isset($_COOKIE['cart'])) {
            $_SESSION['cart'] = $_COOKIE['cart'];
        }
    }

    // save cart to cookies
    function saveCart() {
        if (isset($_SESSION['cart'])) {
            $this->load->helper('cookie');
            set_cookie('cart', $_SESSION['cart'], 60 * 60 * 24 * 365, '.' . $_SERVER["HTTP_HOST"], '/', '', FALSE);
        }
    }

    // delete all items from cart 
    function deleteAllCart() {
        $this->loadCart();
        if (isset($_SESSION['cart'])) {
            $this->db->where('token', $_SESSION['cart']);
            $this->db->delete('cart');
            $this->load->helper('cookie');
            unset($_SESSION['cart']);
            set_cookie('cart', null, 60 * 60 * 24 * 365, '.' . $_SERVER["HTTP_HOST"], '/', '', FALSE);
            return true;
        }

        return false;
    }

    // delete item from cart of shop
    function deleteFromCart($id) {
        $this->loadCart();
        if (isset($_SESSION['cart'])) {
            $this->db->where('id_item', $id);
            $this->db->where('token', $_SESSION['cart']);
            $this->db->delete('cart');
            return $this->getCart();
        }
        return false;
    }

    // add item to cart of shop
    function addToCart($id, $count, $detail = '') {
        $this->loadCart();
        if (isset($_SESSION['cart'])) {
            $is_find = false;
            $cartItems = $this->{self::$md}->getCartIds($_SESSION['cart']);
            foreach ($cartItems as $product) {
                if ((int)$product['id_item'] === (int)$id) {
                    if ($count > 0) {
                        $data = array(
                            'count' => $product['count'] + $count,
                            'detail' => $detail,
                            'date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('ID', $product['ID']);
                        $this->db->update('cart', $data);
                    } else {
                        $this->db->where('ID', $product['ID']);
                        $this->db->delete('cart');
                    }

                    $is_find = true;
                    break;
                }
            }

            if (!$is_find && $count > 0) {
                $data = array(
                    'id_item' => $id,
                    'count' => $count,
                    'detail' => $detail,
                    'token' => $_SESSION['cart'],
                    'date' => date('Y-m-d H:i:s')
                );
                $this->db->insert('cart', $data);
            }
        } else if ($count > 0) {
            $token = sha1($_SERVER['REMOTE_ADDR'] . date('Y-m-d H:i:s') . 'helen' . rand(-100, 100));
            $data = array(
                'id_item' => $id,
                'count' => $count,
                'detail' => $detail,
                'token' => $token,
                'date' => date('Y-m-d H:i:s')
            );

            $this->db->insert('cart', $data);
            $_SESSION['cart'] = $token;
        }
        $this->saveCart();
        return $this->getCart();
        // need to return last item
    }

    // get cart items 
    function getCart() {
        $this->loadCart();
        if(isset($_SESSION['cart']))
            return $this->{self::$md}->getCart($_SESSION['cart']);
        else 
            return array();
    }
    
    
    function updateCart($items)
    {
        $cart = $this->getCart();
        if(empty($cart))
            return false;
        
        foreach ($items as $item)
        {
            $item['count'] = (int)$item['count'];
            $item['id'] = (int)$item['id'];
            
            foreach ($cart as $cart_item) {
                
                if($item['id'] == (int)$cart_item['ID'])
                {
                    if($item['count'] == 0) {
                        //echo 'delete ' . $cart_item['ID'] . '!';
                        $this->db->where('id_item', $cart_item['ID']);
                        $this->db->where('token', $_SESSION['cart']);
                        $this->db->delete('cart');
                    } else {
                        //echo 'update ' . $cart_item['ID'] . ' to '. $item['count'] .'!';
                        $this->db->where('id_item', $cart_item['ID']);
                        $this->db->where('token', $_SESSION['cart']);
                        $this->db->update('cart', array('count' => $item['count']));
                    }
                }
            }
        }
        
        return true;
    }
    
    function purchase() {
        $result = array();
        $this->load->library('form_validation');
        $config = $this->_purchaseConfig();
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = validation_errors();
            $result['status'] = -1;
            $user_data = $this->input->post(NULL, TRUE);
            $_SESSION['user'] = $user_data;
        } else {
            
            $cart = $this->getCart();
            foreach ($cart as $cart_item) {
                if(!$cart_item['is_on_stock']) {
                    $result['error'] = 'Извините, товара ' . $cart_item['name'] . ' уже нет на складе';
                    $result['status'] = -2;
                     return $result;
                }
            } 
            
            $user_data = $this->input->post(NULL, TRUE);
            $_SESSION['user'] = $user_data;
            $is_mail = $this->load->module('mail')->sendPurchase($user_data, $cart);
            if($is_mail) {
                $result['id'] = $is_mail;
                $result['status'] = 1;
                $result['error'] = false;
                $this->deleteAllCart();
            } else {
                $result['error'] = 'Произошла ошибка во время отправки заказа на почтовый ящик. Обновите страницу и повторите операцию!';
                $result['status'] = -3;
            }
        }
        return $result;
    }
    
    function purchaseQuick() {
        $result = array();
        $this->load->library('form_validation');
        $config = $this->_purchaseQuickConfig();
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = validation_errors();
            $result['status'] = -1;
            $user_data = $this->input->post(NULL, TRUE);
            $_SESSION['user'] = $user_data;
        } else {
            $cart = $this->getCart();
            foreach ($cart as $cart_item) {
                if(!$cart_item['is_on_stock']) {
                    $result['error'] = 'Извините, товара ' . $cart_item['name'] . ' уже нет на складе';
                    $result['status'] = -2;
                     return $result;
                }
            } 
            $user_data = $this->input->post(NULL, TRUE);
            foreach ($user_data as $key => $value) {
                $_SESSION['user'][$key] = $value;
            }
            $is_mail = $this->load->module('mail')->sendPurchaseQuick($user_data, $cart);
            if($is_mail) {
                $result['id'] = $is_mail;
                $result['status'] = 1;
                $result['error'] = false;
                $this->deleteAllCart();
            } else {
                $result['error'] = 'Произошла ошибка во время отправки заказа на почтовый ящик. Обновите страницу и повторите операцию!';
                $result['status'] = -3;
            }
            
        }
        return $result;
    }
    
    function _purchaseConfig() {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Имя получателя (ФИО)',
                'rules' => 'trim|required|min_length[4]|max_length[255]|xss_clean'
            ),
            array(
                'field' => 'phone',
                'label' => 'Телефон',
                'rules' => 'trim|required|min_length[6]|max_length[255]|xss_clean'
            ),
            array(
                'field' => 'city',
                'label' => 'Город',
                'rules' => 'trim|required|xss_clean|min_length[2]|max_length[255]'
            ),
            array(
                'field' => 'delivery',
                'label' => 'Способ доставки',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'street',
                'label' => 'Улица',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'house',
                'label' => 'Дом',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'room',
                'label' => 'Квартира',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'pay',
                'label' => 'Оплата',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'Электронный адрес',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
            array(
                'field' => 'comment',
                'label' => 'Комментарий к заказу',
                'rules' => 'trim|xss_clean'
            )
        );

        return $config;
    }
    
    function _purchaseQuickConfig() {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Имя получателя (ФИО)',
                'rules' => 'trim|required|min_length[4]|max_length[255]|xss_clean'
            ),
            array(
                'field' => 'phone',
                'label' => 'Телефон',
                'rules' => 'trim|required|min_length[6]|max_length[255]|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'Электронный адрес',
                'rules' => 'trim|required|valid_email|xss_clean'
            )
        );

        return $config;
    }
}

?>