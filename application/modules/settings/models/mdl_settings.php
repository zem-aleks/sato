<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_settings extends Model {

    public $tb = 'settings';
    public $perPage = 10;

    function getAllSettingsAdmin() {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->order_by('c1.ID');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function save() {
        $id = $this->input->post('id');
        $values = $this->input->post('set');
        for ($i = 0; $i < count($id); $i++) {
            $data = array();
            $data['value'] = $values[$i];
            $this->db->where('ID', $id[$i]);
            $this->db->update($this->tb, $data);
        }
        return true;
    }

}