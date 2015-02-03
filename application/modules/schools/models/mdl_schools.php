<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_schools extends Model {

    public $tb = 'schools';
    public $config = array();
    public $uploadConfig = array(
        'allowed_types' => 'gif|jpg|png|bmp',
        'max_size' => '1024',
        'max_width' => '2000',
        'max_height' => '2000',
    );
    
    function getEntryByField($field, $value, $status = -1)
    {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->where('c1.' . $field, $value);
        if($status >= 0)
            $this->db->where('c1.status', $status);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else
            return false;
    }
    
    function getEntryByChpu($chpu, $status = -1)
    {
        return $this->getEntryByField('chpu', $chpu, $status);
    }
    
    function getEntryById($id, $status = -1) 
    {
        return $this->getEntryByField('ID', $id, $status);
    }

    function getAllEntries($start = 0, $limit = 0, $status = -1)
    {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        if($status >= 0)
            $this->db->where('c1.status', $status);
        if($limit > 0)
            $this->db->limit($limit, $start);
        $this->db->order_by('c1.sort');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return false;
    }
    
    
    function getCount($status = -1)
    {
        $this->db->from($this->tb . ' as c1');
        if($status >= 0)
            $this->db->where('c1.status', $status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function add()
    {
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['date'] = date('Y-m-d H:i:s');
        $data['views'] = 0;
        $data['content'] = $this->input->post('content');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['address'] = $this->input->post('address');
        $data['geo'] = $this->input->post('geo');
        $data['metro'] = $this->input->post('metro');
        $data['color'] = $this->input->post('color');
        $data['is_new'] = isset($_POST['is_new']);
        $data['prices'] = json_encode($this->input->post('prices'));
        $data['discount'] = $this->input->post('discount');
        $data['metro_position'] = $this->input->post('metro_position');
        $data['sort'] = $this->db->count_all($this->tb) + 1;
        if (empty($data['chpu']))
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));

        $this->uploadConfig['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $this->config['upload_folder'] . '/';  // задаем путь к директории upload
        $this->load->library('upload', $this->uploadConfig);

        if (!$this->upload->do_upload()) {   // сообщение об ошибке загрузки
            $error = array('error' => $this->upload->display_errors());
            $data['image'] = '';
        } else {  // вывод параметров  переданного файла
            $img = $this->upload->data();
            $data['image'] = $img['file_name'];
        }

        $id = $this->db->insert($this->tb, $data);
        return $id;
    }

    function edit($idPage)
    {
        $data = array();
        $data['name'] = $this->input->post('name');
        $data['content'] = $this->input->post('content');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['discount'] = $this->input->post('discount');
        $data['address'] = $this->input->post('address');
        $data['geo'] = $this->input->post('geo');
        $data['metro'] = $this->input->post('metro');
        $data['color'] = $this->input->post('color');
        $data['metro_position'] = $this->input->post('metro_position');
        $data['is_new'] = isset($_POST['is_new']);
        $data['prices'] = json_encode($this->input->post('prices'));
        $data['date'] = date('Y-m-d');
        if (empty($data['chpu'])) {
            $data['chpu'] = $this->checkChpu(rus2translit($data['name']));
        }

        $this->uploadConfig['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $this->config['upload_folder'] . '/';  // задаем путь к директории upload
        $this->load->library('upload', $this->uploadConfig);

        if (!$this->upload->do_upload()) {   // сообщение об ошибке загрузки
            $error = array('error' => $this->upload->display_errors());
        } else {  // вывод параметров  переданного файла
            $img = $this->upload->data();
            $data['image'] = $img['file_name'];
        }

        if ($this->input->post('del') == 'on') {
            if (file_exists($this->input->post('image'))) {
                unlink($this->input->post('image')) or die('failed deleting: ' . $path);
            }
            $data['image'] = "no_image.jpg";
        }

        $this->db->where('ID', $idPage);
        $this->db->update($this->tb, $data);
        return $idPage;
    }

    function sort()
    {
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

    function status($id, $status)
    {
        $this->db->where('ID', $id);
        $this->db->update($this->tb, array('status' => $status));
        return $id;
    }

    function del($id)
    {
        $this->db->where('ID', $id);
        $this->db->delete($this->tb);
    }

    function checkChpu($str)
    {
        $translit = "empty";
        $i = 0;
        while ($translit != "") {
            $this->db->select('c1.chpu');
            $this->db->from($this->tb . ' as c1');
            $this->db->where('c1.chpu', $str);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $translit = "empty";
            } else
                $translit = "";
            if ($translit != "") {
                $str .= $i;
                $i++;
            }
        }
        return $str;
    }


}
