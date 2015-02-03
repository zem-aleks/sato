<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends Controller {

    var $md = 'mdl_orders';

    function Orders() 
    {
        parent::__construct();
        $this->load->model($this->md);
    }

    function add($name, $phone, $email, $address, $text, $items, $is_quick = 0)
    {
        return $this->{$this->md}->add($name, $phone, $email, $address, $text, $items, $is_quick);
    }
    
    
    function admin_index($filter='all', $page = 0) {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        } else {
            $content = array();
            $content['title'] = 'Заказы';
            $per_page = 20;
            
            $this->load->model('admin/mdl_admin');
            $content['orders'] = $this->{$this->md}->getOrders($page / $per_page, $per_page, $filter, 0);
            $content['filter'] = $filter;
            //$content['pages'] = $this->mdl_item->getAllPagesAdmin($page/$per_page,$filter);
            
            $this->load->library('pagination');
            $config['base_url'] = '/dashboard/orders/admin_index/' . $filter . '/';
            $config['total_rows'] = $this->{$this->md}->getAllPagesCount($filter, 0);
            $config['num_links'] = 5;
            $config['per_page'] = $per_page;
            $config['cur_page'] = $page;
            $config['first_link'] = 'Первая';
            $config['last_link'] = 'Последняя';
            $config['use_page_numbers'] = TRUE;
            $this->pagination->initialize($config);
            $content['paginator'] = $this->pagination->create_links();
            $content['status_list'] = array(
                'Не обработан', 'Принят в обработку', 'Готово',
                'На согласовании', 'Доставляется', 'Завершен',
                'Отменен'
            );

            $this->load->view('includes/admin_header', $content);
            $this->load->view('list', $content);
            $this->load->view('includes/admin_footer', $content);
        }
    }
    
    function quick($filter='all', $page = 0)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        } else {
            $content = array();
            $content['title'] = 'Быстрые Заказы';
            $per_page = 20;
            
            $this->load->model('admin/mdl_admin');
            $content['orders'] = $this->{$this->md}->getOrders($page / $per_page, $per_page, $filter, 1);
            $content['filter'] = $filter;
            //$content['pages'] = $this->mdl_item->getAllPagesAdmin($page/$per_page,$filter);
            
            $this->load->library('pagination');
            $config['base_url'] = '/dashboard/orders/quick/' . $filter . '/';
            $config['total_rows'] = $this->{$this->md}->getAllPagesCount($filter, 1);
            $config['num_links'] = 5;
            $config['per_page'] = $per_page;
            $config['cur_page'] = $page;
            $config['first_link'] = 'Первая';
            $config['last_link'] = 'Последняя';
            $config['use_page_numbers'] = TRUE;
            $this->pagination->initialize($config);
            $content['paginator'] = $this->pagination->create_links();
            $content['status_list'] = array(
                'Не обработан', 'Принят в обработку', 'Готово',
                'На согласовании', 'Доставляется', 'Завершен',
                'Отменен'
            );

            $this->load->view('includes/admin_header', $content);
            $this->load->view('list_quick', $content);
            $this->load->view('includes/admin_footer', $content);
        }
    }
    
    
    function _edit($id_user)
    {
        $data = array(
            'name' => $this->input->post('name'),
            'surname' => $this->input->post('surname'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
        );
        $this->db->where('ID',$id_user);
        $this->db->update('users',$data);
        header('Location: /dashboard/users');
    }
    
    
    function edit($id) {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        }
        if(isset($_POST['name']))
            $this->_edit ($id);
        
        $content = array();
        $content['order'] = $this->{$this->md}->getOrder($id);
        $content['title'] = 'Заказ №'.$id;
        
        $content['status_list'] = array(
            'Не обработан', 'Принят в обработку', 'Готово',
            'На согласовании', 'Доставляется', 'Завершен',
            'Отменен'
        );
        
        $this->load->view('includes/admin_header', $content);
        $this->load->view('edit', $content);
        $this->load->view('includes/admin_footer', $content);
    }
    
    
    function del($id)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        }
        if((int) $id > 0){
            $this->db->where('ID',$id);
            $this->db->delete('orders');
            
            $this->db->where('id_order',$id);;
            $this->db->delete('order_items');
        }
        header('Location: /dashboard/orders');
    }
    
    
    function status($id, $status, $renew = true)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        }
        if((int)$status>=0)
        {
            $comment = $_POST['comment'];
            $this->db->where('ID',$id);
            $this->db->update('orders', array( 'status' => $status, 'admin_comment' => $comment));
            echo 1;
        }
        if($renew)
            header('Location: /dashboard/orders/edit/'.$id);
    }
    
    function updateOrder($id)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        }
        
        $data = $_POST['order'];
        $this->db->where('ID', $id);
        $this->db->update('orders', $data);
        
        $items = $_POST['items'];
        $this->db->where('id_order', $id);
        $this->db->delete('order_items');
        foreach ($items as $item) {
            $data = array(
                'id_order' => $id,
                'id_item' => $item['id'],
                'count' => $item['count']
            );
            $this->db->insert('order_items', $data);
        }
        echo 1;
    }
    
    
    function cancel($id)
    {
        $is_logged_in = $this->session->userdata('is_logged_in');
        if (!$is_logged_in) {
            redirect('admin');
        }
        
        $order = $this->{$this->md}->getOrder($id);
        
        foreach ($order['items'] as $item) {
            $this->db->where('ID', $item['id_item']);
            $this->db->set('in_stock', 'in_stock+'.$item['count'], FALSE);
            $this->db->update('item');
        }
        
        $this->del($id);
    }
    
    
}
?>