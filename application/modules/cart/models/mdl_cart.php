<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_cart extends Model {
        //Название таблицы
	private static $table = 'cart';
        
        function getCartIds($token)
        {
            $this->db->select('c1.ID, c1.id_item, c1.count');
            $this->db->from(self::$table . ' as c1');
            $this->db->where('c1.token', $token);
            $query = $this->db->get();
            return $query->result_array();
        }
        
        function getCart($token)
        {
            $this->db->select('c1.count, c1.detail, c1.date, c2.*');
            $this->db->from(self::$table . ' as c1');
            $this->db->join('item as c2', 'c2.ID = c1.id_item');
            $this->db->where('c1.token', $token);
            $this->db->order_by('c1.date', 'DESC');
            $query = $this->db->get();
            return $query->result_array();
        }
        
        function getLastItem($token)
        {
            $this->db->select('c1.count, c1.detail, c1.date, c2.*');
            $this->db->from(self::$table . ' as c1');
            $this->db->join('item as c2', 'c2.ID = c1.id_item');
            $this->db->where('c1.token', $token);
            $this->db->order_by('c1.date', 'DESC');
            $this->db->limit(1);
            $query = $this->db->get();
            if ($query->num_rows() > 0)
                return $query->row_array();
            return false;
        }
        
}