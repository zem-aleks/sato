<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_comments extends Model {

    public $tb = 'comments';

    function getComments($count, $page, $status = -1) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        if($status != -1)
            $this->db->where('c1.status', $status);
        $this->db->order_by('c1.ID DESC');
        if ($count > 0)
            $this->db->limit($count, $page);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getPageInfo($id_page) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->order_by('c1.ID');
        $this->db->where('c1.ID', $id_page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }

    function getAllComments($status) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        if ($status >= 0)
            $this->db->where('c1.status', $status);
        $this->db->order_by('c1.date');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function getBranch($id, $level, $result, $status) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->where('c1.parentID', $id);
        $this->db->where('c1.status', $status);
        $this->db->order_by('c1.date');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $comments = $query->result_array();
            foreach ($comments as $com) {
                $com['level'] = $level;
                $result[] = $com;
                //$this->getBranch($com['ID'],$level+1,&$result,$status);
            }
        }
    }

    function del($id) {
        $this->db->where('ID', $id);
        $this->db->delete($this->tb);
    }

    function status($id, $status) {
        $data = array();
        $data['status'] = $status;
        $this->db->where('ID', $id);
        $this->db->update($this->tb, $data);

        if ($id) {
            return true;
        }
        else
            return false;
    }

    function addComment($name, $email, $phone, $question, $comment) {
        $data = array();
        $data['name'] = $name;
        $data['email'] = $email;
        $data['comment'] = $comment;
        $data['question'] = $question;
        $data['phone'] = $phone;
        $data['date'] = date('Y-m-d H:i:s');
        $this->db->insert($this->tb, $data);
        return $this->db->insert_id();
    }

    function countAllComments() {
        $this->db->select('c1.ID');
        $this->db->from($this->tb . ' as c1');
        return $this->db->count_all_results();
    }

}
