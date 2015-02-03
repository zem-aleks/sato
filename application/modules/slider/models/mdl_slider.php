<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_slider extends Model {

    //Название таблицы
    var $table = 'slider';
    //Количество элементов на странице
    var $per_page = 35;

    function Mdl_slider() {
        parent::__construct();
    }

    function getSImages() {
        $this->db->select('c1.*');
        $this->db->from($this->table . ' as c1');
        $this->db->where('c1.status', 1);
        $this->db->order_by('c1.sort');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    /* -------------------------------------------------------------------- */

    function getlist() {
        $this->db->select('c1.*');
        $this->db->from($this->table . ' as c1');
        $this->db->order_by('c1.sort');
        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    function add() {
        $data = array();

        $data['name'] = $this->input->post('name');
        $data['link'] = $this->input->post('link');
        $data['sort'] = $this->db->count_all($this->table) + 1;

        $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/uploads/slider/';  // задаем путь к директории upload
        $config['allowed_types'] = 'gif|jpg|png|bmp'; // указываем допустимые расширения
        $config['max_size'] = '2048';  // max размер файла в Kb
        $config['max_width'] = '2000';  // max размер  по вертикали
        $config['max_height'] = '2000'; // max размер  по горизонтали

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {   // сообщение об ошибке загрузки
            $error = array('error' => $this->upload->display_errors());
            $data['image'] = '';
            return false;
        } else {  // вывод параметров  переданного файла
            $img = $this->upload->data();
            $data['image'] = $img['file_name'];
        }

        $this->db->insert($this->table, $data);
        $id_cat = $this->db->insert_id();

        if ($id_cat) {
            return true;
        }
        else
            return false;
    }

    function edit($id) {
        $data = array();

        $data['name'] = $this->input->post('name');
        $data['link'] = $this->input->post('link');
        $del = $this->input->post('del');
        if ($del) {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/slider/' . $this->input->post('image'));
            $data['image'] = "";
        } else {

            $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/uploads/slider/';  // задаем путь к директории upload
            $config['allowed_types'] = 'gif|jpg|png|bmp'; // указываем допустимые расширения
            $config['max_size'] = '2048';  // max размер файла в Kb
            $config['max_width'] = '2000';  // max размер  по вертикали
            $config['max_height'] = '2000'; // max размер  по горизонтали

            $this->load->library('upload', $config);
            $error=array();
            if (!$this->upload->do_upload()) {   // сообщение об ошибке загрузки
                $error = array('error' => $this->upload->display_errors());
            } else {  // вывод параметров  переданного файла
                $img = $this->upload->data();
                $data['image'] = $img['file_name'];
            }

        }

        $this->db->where('ID', $id);
        $this->db->update($this->table, $data);

        if ($id) {
            return true;
        }
        else
            return false;
    }

    function status($id, $status) {
        $data = array();

        $data['status'] = $status;
        $this->db->where('ID', $id);
        $this->db->update($this->table, $data);

        if ($id) {
            return true;
        }
        else
            return false;
    }

    function del($id) {
        $row = $this->getImage($id);
        if (!empty($row['image']) && $row['image'] != 'no_image.jpg')
            unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/slider/' . $row['image']);
        $this->db->where('ID', $id);
        $this->db->delete($this->table);
    }

    function getImage($id) {
        $this->db->select('c1.*');
        $this->db->from($this->table . ' as c1');
        $this->db->where('c1.ID', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }

    function sort() {
        if (isset($_POST) && isset($_POST['st'])) {
            $arr = $_POST['st'];
            $items = explode(';', $arr);
            for ($i = 0; $i < count($items) - 1; $i++) {
                $tmp = explode("_", $items[$i]);
                $data['sort'] = $tmp[0];
                $this->db->where('ID', $tmp[1]);
                $this->db->update($this->table, $data);
            }
        }
    }

}


