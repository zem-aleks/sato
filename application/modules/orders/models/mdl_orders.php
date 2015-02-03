<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_orders extends Model {

    public $tb = 'orders';

    function Mdl_orders() {
        parent::__construct();
    }

    function add($name, $phone, $email, $address, $text, $items, $is_quick = 0) {
        $data = array();
        $data['name'] = $name;
        $data['phone'] = $phone;
        $data['email'] = $email;
        $data['detail'] = $text;
        $data['address'] = $address;
        $data['date'] = date('Y-m-d H:i:s');
        $data['is_quick'] = $is_quick;
        $this->db->insert($this->tb, $data);
        $id = $this->db->insert_id();
        $this->addItemsToOrder($id, $items);
        
        return $id;
    }
    
    function getAllPagesAdmin($page, $perPage) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->order_by('c1.ID');
        $this->db->limit($perPage, $perPage * $page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }
    
    function getAllPagesCount($filter = 'all', $isQuick = 0) {
        if($filter == 'enable')
            $this->db->where('status', 2);
        elseif($filter == 'disable')
            $this->db->where('status', 0);
        $this->db->where('is_quick', $isQuick);
        return $this->db->count_all_results($this->tb);
    }
    
    
    function getOrders($page, $perPage, $filter = 'all', $isQuick = 0)
    {
        $this->db->select('O.*');
        $this->db->from('orders O');
        if($filter == 'enable')
            $this->db->where('O.status', 2);
        elseif($filter == 'disable')
            $this->db->where('O.status', 0);
        $this->db->where('is_quick', $isQuick);
        $this->db->order_by('O.ID', 'DESC');
        $this->db->limit($perPage, $perPage * $page);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows() > 0) {
            return $query->result_array();
        } else 
            return false;
    }
    
    
    function getOrder($id_order)
    {
        $this->db->from('orders');
        $this->db->where('ID', $id_order);
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            $order['detail'] = $query->row_array();
            $order['items'] = $this->getOrderItems($id_order);
            return $order;
        }
        else 
            return false;
    }
    
    function getOrderItems($id_order)
    {
        $this->db->from('order_items');
        $this->db->join('item','item.ID = order_items.id_item','left outer');
        $this->db->where('id_order', $id_order);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    function addItemsToOrder($id_order, $items)
    {
        $data = array();
        $data['id_order'] = $id_order;
        foreach ($items as $item) 
        {
            $data['id_item'] = $item['ID'];
            $data['count'] = (int)$item['count'];
            if($data['count'] > 0)
                $this->db->insert('order_items', $data);
        }
    }

}