<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_users extends Model {

    public $tb = 'users';

    function getAllPagesAdmin($page, $perPage) {
        $this->db->select('c1.*');
        $this->db->distinct();
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

    function getAllPagesCount() {
        return $this->db->count_all($this->tb);
    }
    
    function getUser($field, $value)
    {
        $this->db->from('users');
        $this->db->where($field,$value);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else 
            return false;
    }
    
    function findUser($str)
    {
        
        $this->db->from('users');
        $this->db->where('name',$str);
        $this->db->or_where('email',$str);
        $this->db->or_where('phone',$str);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->row_array();
        else 
            return false;
    }
    
    
    function getUserContacts($id_user)
    {
        $this->db->from('users_address');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        return $query->result_array();
    }

}