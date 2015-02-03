<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_pages extends Model {

    public $tb = 'pages';
    public $perPage = 10;

    function getPageCHPU($chpu) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->where('c1.chpu', $chpu);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }

    function getLeftMenu() {
        $this->db->select('c1.title, c1.chpu, c1.ID');
        $this->db->from($this->tb . ' as c1');
        $this->db->join('cat_pages', 'cat_pages.id_page = c1.ID', 'left outer');
        $this->db->where('cat_pages.id', null);
        $this->db->where('c1.status', 1);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }
    
    function getPages() {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->where('c1.status', 1);
        $this->db->order_by('c1.sort');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function getAllPagesAdmin() {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->order_by('c1.sort');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function add() {
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['content'] = $this->input->post('content');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        $data['sort'] = $this->db->count_all($this->tb) + 1;
        if (empty($data['chpu'])) {
            $data['chpu'] = $this->checkCHPU(rus2translit($data['name']));
        }
        $id = $this->db->insert($this->tb, $data);

        $data2['id_page'] = $id;
        $data2['id_cat'] = $this->input->post('cat');
        $this->db->insert("cat_pages", $data2);

        return true;
    }

    function edit($id_page) {
        $data = array();
        $data['name'] = $this->input->post('name');
        if(empty($data['name']))
            unset($data['name']);
        $data['content'] = $this->input->post('content');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        /*$data['chpu'] = $this->input->post('chpu');
        if (empty($data['chpu'])) {
            $data['chpu'] = $this->checkCHPU(rus2translit($data['name']));
        }*/
        $this->db->where('ID', $id_page);
        $this->db->update($this->tb, $data);

        /*
        $this->db->select('c1.id');
        $this->db->from('cat_pages as c1');
        $this->db->where('id_page', $id_page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->row_array();
        }
        if ($this->input->post('cat') != 0) {
            if ($result[0]['id'] > 0) {
                $data2['id_page'] = $id_page;
                $data2['id_cat'] = $this->input->post('cat');
                $this->db->where('id', $result['id']);
                $this->db->update("cat_pages", $data2);
            } else {
                $data2['id_page'] = $id_page;
                $data2['id_cat'] = $this->input->post('cat');
                $this->db->insert("cat_pages", $data2);
            }
        } else {
            $this->db->where('id', $result['id']);
            $this->db->delete('cat_pages');
        }*/
        return true;
    }

    function sort() {
        if (isset($_POST) && isset($_POST['st'])) {
            $arr = $_POST['st'];
            $items = explode(';', $arr);
            for ($i = 0; $i < count($items) - 1; $i++) {
                $tmp = explode("_", $items[$i]);
                $data['sort'] = $tmp[0];
                $this->db->where('ID', $tmp[1]);
                $this->db->update($this->tb, $data);
            }
        }
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

    function getPageCat($id_page) {
        $this->db->select('c1.id_cat');
        $this->db->from('cat_pages as c1');
        $this->db->where('c1.id_page', $id_page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }

    function getCatList() {
        $query = $this->db->get('categories');
        if ($query->num_rows() > 0) {
            $list = $query->result_array();
            $result = array();
            $result[0] = "Нет";
            foreach ($list as $item) {
                $result[$item['ID']] = $item['cat_name'];
            }
            return $result;
        }
        else
            return false;
    }

    function del($id) {
        $this->db->where('ID', $id);
        $this->db->delete($this->tb);
    }

    function checkCHPU($str) {
        $translit = "empty";
        $i = 0;
        while ($translit != "") {
            $this->db->select('c1.chpu');
            $this->db->from($this->tb . ' as c1');
            $this->db->where('c1.chpu', $str);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $translit = "empty";
            }
            else
                $translit = "";
            if ($translit != "") {
                $str .= $i;
                $i++;
            }
        }
        return $str;
    }

    function getPagesChpu() {
        $this->db->select('c1.chpu');
        $this->db->from($this->tb . ' as c1');
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            $result = array();
            $arr=$query->result_array();
            foreach ($arr as $value)
                $result[]=$value['chpu'];
            return $result;
        }
        else
            return false;
    }

}