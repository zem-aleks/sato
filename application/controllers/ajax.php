<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ajax extends Controller 
{

    function Ajax() 
    {
        parent::__construct();
        session_start();
        $result=array('error'=>1,'status'=>'Not allowed');
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) 
                || empty($_SERVER['HTTP_X_REQUESTED_WITH']) 
                || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') 
        {
            echo json_encode($result);
            exit;
        }

    }
    
    function back(){
        $_SESSION['prev']['is_back']=true;
        echo json_encode($_SESSION['prev']);
    }
    
    function purchase()
    {
        $result=array('error'=> 'Корзина пустая','status'=> -10);
        if(isset($_SESSION['cart']))
        {
            $result = $this->load->module('cart')->purchase();
        }
        echo json_encode($result);
    }
    
    function purchaseQuick()
    {
        $result=array('error'=> 'Корзина пустая','status'=> -10);
        if(isset($_SESSION['cart']))
        {
            $result = $this->load->module('cart')->purchaseQuick();
        }
        echo json_encode($result);
    }
    
    // delete cart of shop
    function deleteAllCart() 
    {
        $result = array('error' => 0, 'status' => 0);
        if ($this->load->module('cart')->deleteAllCart())
            $result['status'] = 1;
        else
            $result['error'] = 1;

        echo json_encode($result);
    }

    function deleteFromCart()
    {
        $currency = $_POST['currency'];
        $result=array('error'=>0,'status'=>0);
        if(isset($_POST['id']) && (int)$_POST['id']>0)
        {
            $id=(int)$_POST['id'];
            $cart = $this->load->module('cart')->deleteFromCart($id);
            $settings=$this->load->module('settings')->getListSettings();
            foreach ($cart as &$value) {
                if(empty($value['image']))
                    $value['image'] = 'no_image.jpg';
                if($currency == 'USD') 
                    $value['price'] = round ($value['price'] / $settings['rate'], 2);
            }
            unset($value);
            $result['cart'] = $cart;
            $result['status']=1;
        }
        else
            $result['error']=1;
        
        echo json_encode($result);
    }
    
    function addToCart()
    {
        $result=array('error'=>0,'status'=>0);
        if(isset($_POST['id']) && isset($_POST['count']) 
                && (int)$_POST['id']>0 && (int)$_POST['count']>=0)
        {
            $cart = array();
            $id = (int)  $this->input->post('id', TRUE);
            $count = (int) $this->input->post('count', TRUE);
            $detail = $this->input->post('detail', TRUE);
            $item = $this->load->module('item')->getItemById($id);
            if($item && $item['is_on_stock'] > 0) {
                $cart = $this->load->module('cart')->addToCart($id, $count, $detail);
            } else {
                $result['error'] = 2; // no product in stock
                $result['status'] = $item['is_on_stock'];
            }
            
            $result['cart'] = $cart;
        }
        else{
            $result['error']=1;
            $result['status']='Not valid';
        }
        
        echo json_encode($result);
    }
    
    function updateCart()
    {
        $items = $this->input->post('items', TRUE);
        echo $this->load->module('cart')->updateCart($items);
    }
    
    
    function getProduct()
    {
        $result=array('error'=>0,'status'=>0);
        if(isset($_POST['id']) && (int)$_POST['id']>0)
        {
            $id=(int)$_POST['id'];
            $item=$this->load->module('item')->getItemById($id);
            if($item)
            {
                $result['item']=$item;
            } else {
                $result['error']=2;
                $result['status']='not such product';
            }
        } else {
            $result['error']=1;
            $result['status']='invalid id';
        }
        
        echo json_encode($result);
    }
    

    function findCatalog($id){
        $categories=$this->load->module('category')->getCategoryListByField('ID',$id);
        if(count($categories)>0)
            foreach ($categories as $value) {
                echo $value['cat_name'];
                break;
            }
        else 
            echo 0;
    }
    
    function search()
    {
        $result = array();
        $result['status'] = 0;
        $result['error'] = false;
        $str = $this->input->post('str', TRUE);
        $str = trim($str);
        if(!empty($str) && strlen($str) >= 3) {
            $limit = 5;
            $where = array('c1.status' => 1);
            $like = $this->load->module('filter')->search($str);
            $result['items'] = $this->load->module('item')->getUniversal(
                'c1.ID, c1.name, c1.price, c1.chpu', $where, $limit, 0, 'c1.name', $like
            );
            $result['itemsCount'] = $this->load->module('item')->getUniversalCount($where, $like);
            $this->load->module('item')->initItemImages($result['items'], 1);
            $result['status'] = 1;
        }
        echo json_encode($result);
    }
    
    function searchItems()
    {
        $id_from= $_POST['id_from'];
        $id_to= $_POST['id_to'];
        $result=array('error'=>0,'items'=>array());
        $limit = 20;
        
        if((int)$id_to == -1){
            $result['items']=$this->load->module('item')->findItem('c1.name', $id_from, $limit);
        } elseif($id_to>=$id_from)
            $result['items']=$this->load->module('item')->getItemsInterval((int)$id_from,(int)$id_to, $limit);
        else
            $result['error']=1;
        
        echo json_encode($result);
    }
    
    function searchItem()
    {
        $id = $this->input->post('id', TRUE);
        $result=array('error'=>0);
        $item=$this->load->module('item')->getItemById($id);
        if(!empty($item['ID']))
            $result['item']=$item;
        else
            $result['error']=1;
        echo json_encode($result);
    }
    
    function showMore()
    {
        $result=array('items'=>array(),'error'=>0);
        $start = (int)$this->input->post('start', TRUE);
        $top_id = (int)$this->input->post('top', TRUE);
        $sub_id = (int)$this->input->post('sub', TRUE);
        $id_brand = (int)$this->input->post('brand', TRUE);
        if($top_id >= 0 && $start >= 0) {
            // find items by parametrs
            $like = array();
            $where = array('c1.status' => 1);
            if($top_id == 0) {
                $like = $this->load->module('filter')->search();
                if(empty($like)) {
                    $result['error'] = 2;
                    echo json_encode($result);
                    return;
                }
            } elseif ($sub_id > 0 && $sub_id != $top_id) {
                $where['c3.id_cat'] = $sub_id;
            } elseif($id_brand > 0) {
                $where['c1.id_brand'] = $id_brand;
                $where['c2.id_parent'] = $top_id;
            } else {
                $where['c2.id_parent'] = $top_id;
            }
            

            $content = array();
            $content['firstSort'] = $this->load->module('filter')->firstSorting();
            $content['perPage'] = $this->load->module('filter')->secondSorting();
            $content['filters'] = $this->load->module('filter')->filtering();
            $arr = $this->load->module('filter')->initFilters($content['filters'], $where);
            $filter_where = $arr['where'];
            $filter_where_in = $arr['where_in'];

            $content['items'] = $this->load->module('item')->getUniversal(
                    'c1.ID, c1.name, c1.price, c1.old_price, c1.chpu, c1.is_on_stock', $filter_where, 
                    $content['perPage'], $start, $content['firstSort'], 
                    $like, $filter_where_in
            );
            $this->load->module('item')->initItemImages($content['items'], 1);
            $result['items'] = $content['items'];
        } else {
            $result['error'] = 1;
        }
        
        echo json_encode($result);
    }

    
    function login(){
        $login = $this->input->post('login', TRUE);
        $pass = $this->input->post('pass', TRUE);
        if($this->load->module('users')->login($login, $pass))
            echo 1;
        else
            echo 0;
    }
    
    
    function validStock()
    {
        $result = array();
        $result['status'] = 0;
        $id = $this->input->post('id', TRUE);
        $count = $this->input->post('count', TRUE);
        
        $this->db->select('in_stock');
        $this->db->from('item');
        $this->db->where('ID', $id);
        $query = $this->db->get();
        
        if($query->num_rows() > 0) {
            $item = $query->row_array();
            $result['in_stock'] = $item['in_stock'];
            if($item['in_stock'] >= $count)
                $result['status'] = 1;
            else 
                $result['status'] = -2; // no items in stock
        } else {
            $result['status'] = -1; // item not found 
        }
        
        echo json_encode($result);
    }
    
    function addUser() {
        $result = array('code' => 0, 'msg' => '');
        $this->load->library('form_validation');
        $config = $this->_getMessageConfig();
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['code'] = -1;
            $result['msg'] = "<b>При вводе данных произошли ошибки:</b><br/><br/>" . validation_errors();
        } else {
            $data = array(
                'name' => trim($this->input->post('name', TRUE)),
                'email' => trim($this->input->post('email', TRUE)),
            );
            $result['code'] = $this->load->module('users')->addUserShort($data['name'], $data['email']);
            if(isset($_POST['type']) && $result['code'] > 0) {
                $data = array(
                    'type' => $this->input->post('type', TRUE),
                    'service' => $this->input->post('service', TRUE),
                    'price' => $this->input->post('price', TRUE),
                );
                $this->db->where('ID', $result['code']);
                $this->db->update('users', $data);
            }
            $result['msg'] = 'Ваш запрос успешно обработан!';
        }
        echo json_encode($result);
    }
    
    function checkTest() {
        $result = array('code' => 0, 'detail' => array());
        $name = trim($this->input->post('name', TRUE));
        $email = trim($this->input->post('email', TRUE));
        $answers = $this->input->post('answers', TRUE);
        if(!empty($name) && !empty($email)) {
            $idUser = $this->load->module('users')->addUserShort($name, $email);
            $result['detail'] = $this->load->module('test')->checkTest($answers, $idUser);
            $text = $name . ", поздравляем! Вы успешно прошли тестирование<br><br>";
            $text .= "Ваш результат:<br>";
            $total_percent = 0;
            foreach ($result['detail'] as $key => $done) {
                $percent = round(($done / 10) * 100, 2);
                $total_percent += $percent;
                $text .= "Страница" . ($key + 1) . "  :  ". $percent ."% (" . $done . " / 10 ) <br>";
            }
            $total_percent = $total_percent / 5;
            $text .= "<br>Итого: " . $total_percent . '%'; 
            $result['text'] = $text;
            $result['code'] = 1;
            $this->load->module('mail')->sendMessage($email, 'Результаты Онлайн-Тестирования', $text);
        } else {
            $result['code'] = -1;
        }
        
        echo json_encode($result);
    }
    
    function _getMessageConfig() {
        $config = array(
            array(
                'field' => 'name',
                'label' => 'Имя',
                'rules' => 'trim|alpha|required|min_length[2]|max_length[255]|xss_clean'
            ),
            array(
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'trim|required|valid_email|xss_clean'
            ),
        );

        return $config;
    }
    
    function saveCats(){
        if(isset($_POST['cat'])) {
            $values = $this->input->post('cat');
            foreach ($values as $key => $value) {
                $this->db->where('ID', $key);
                $this->db->update('service_categories', array('name' => $value));
            }
            echo 1;
            return;
        }
        echo 0;
    }
    
}

?>