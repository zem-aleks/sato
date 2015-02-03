<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_dictionary extends Model {

    function getDictionary($type = false)
    {
        if($type)
            $this->db->where('type', $type);
        $this->db->order_by('name');
        $query = $this->db->get('item_options');
        return $query->result_array();
    }
    
}