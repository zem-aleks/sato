<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_item extends Model {

    public $tb = 'item';
    public $perPage = 20;

    function getPageCHPU($str) {
        $this->db->select('c1.*, IFNULL(c3.count, 0) as `count`', FALSE);
        $this->db->from($this->tb . ' as c1');
        $token = '0';
        if (isset($_SESSION['cart']))
            $token = $_SESSION['cart'];
        $this->db->join('cart c3', 'c1.ID = c3.id_item AND token = "' . $token . '"', 'left outer');
        $this->db->where('c1.chpu', $str);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }


    function getAllPagesAdmin($page, $filter = 'all', $category = 0, $sort = 'ID') {
        $this->db->select('c1.*');
        $this->db->distinct();
        $this->db->from($this->tb . ' as c1');
        $this->db->join('cat_item as c3', 'c1.ID = c3.id_page', 'LEFT OUTER');
        $this->db->join('categories as c2', 'c3.id_cat = c2.ID', 'LEFT OUTER');
        if ($filter != 'all') {
            if ($filter == 'enable')
                $f = 1;
            elseif($filter == 'disable')
                $f = 0;
            elseif($filter == 'in_process')
                $f = 2;
            $this->db->where('c1.status', $f);
        }
        if($category > 0) {
            $where = "(c3.id_cat='$category' OR c2.id_parent='$category')";
            $this->db->where($where);
        }
        if(empty($sort))
            $sort = 'ID';
        $this->db->order_by('c1.' . $sort);
        $this->db->limit($this->perPage, $this->perPage * $page);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function getAllPagesCount($filter = 'all', $category = 0) {
        $this->db->distinct();
        $this->db->from($this->tb . ' as c1');
        $this->db->join('cat_item as c3', 'c1.ID = c3.id_page', 'LEFT OUTER');
        $this->db->join('categories as c2', 'c3.id_cat = c2.ID', 'LEFT OUTER');
        if ($filter != 'all') {
            if ($filter == 'enable')
                $f = 1;
            elseif($filter == 'disable')
                $f = 0;
            elseif($filter == 'in_process')
                $f = 2;
            $this->db->where('c1.status', $f);
        }
        if($category > 0) {
            $where = "(c3.id_cat='$category' OR c2.id_parent='$category')";
            $this->db->where($where);
        }
        return $this->db->count_all_results();
    }

    function add() {
        
        $data = array();
        $data['name'] = $this->input->post('name', TRUE);
        $data['price'] = (float)$this->input->post('price', TRUE);
        $data['old_price'] = (float)$this->input->post('old_price', TRUE);
        $data['content'] = $this->input->post('content', TRUE);
        
        $data['id_color'] = $this->input->post('id_color');
        $data['id_material'] = $this->input->post('id_material');
        $data['id_brand'] = $this->input->post('id_brand');
        
        $data['height'] = (float)$this->input->post('height', TRUE);
        $data['width'] = (float)$this->input->post('width', TRUE);
        $data['length'] = (float)$this->input->post('length', TRUE);
        $data['volume'] = (float)$this->input->post('volume', TRUE);
        $data['deepth'] = (float)$this->input->post('deepth', TRUE);
        $data['thickness'] = (float)$this->input->post('thickness', TRUE);
        
        $data['date_create'] = date('Y-m-d H:i:s');
        $data['date_edit'] = $data['date_create'];
        
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        $data['sort'] = $this->db->count_all($this->tb) + 1;
        $data['is_on_stock'] = $this->input->post('is_on_stock', TRUE);
        $data['is_new'] = isset($_POST['is_new']);
        $data['rating'] = $this->input->post('rating');
        $data['status'] = isset($_POST['in_process'])? 2 : 1;
        $data['related_items'] = $this->input->post('related_value');
        
        $acc_array = array();
        $acc = $this->input->post('acc');
        foreach ($acc as $key => $value) {
            $acc_array[] = $key;
        }
        $data['accessories'] = json_encode($acc_array);
        
        if (empty($data['chpu'])) {
            $data['chpu'] = $this->checkCHPU(rus2translit($data['name']));
        }
        $this->db->insert($this->tb, $data);
        $id = $this->db->insert_id();
        
        $categories = $this->input->post('cat');
        foreach ($categories as $cat => $value) {
            $catData = array(
                'id_page' => $id,
                'id_cat' => $cat
            );
            $this->db->insert('cat_item',  $catData);
        }
        
        
        $watermark = $this->input->post('watermark');
        foreach ($_FILES as $key => $file) {
            $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/items/', $key, $watermark);
            if($result['status'] == 1) {
                $this->db->insert('images', array(
                    'id_item' => $id,
                    'image' => $result['img']['file_name']
                ));
            }
        }
        return true;
    }

    function edit($id_page) {
        
        $categories = $this->input->post('cat');
        $this->db->where('id_page', $id_page);
        $this->db->delete('cat_item');
        foreach ($categories as $cat => $value) {
            $catData = array(
                'id_page' => $id_page,
                'id_cat' => $cat
            );
            $this->db->insert('cat_item',  $catData);
        }
        
        $data = array();
        $data['name'] = $this->input->post('name', TRUE);
        $data['price'] = (float)$this->input->post('price', TRUE);
        $data['old_price'] = (float)$this->input->post('old_price', TRUE);
        $data['content'] = $this->input->post('content', TRUE);
        
        $data['id_color'] = $this->input->post('id_color');
        $data['id_material'] = $this->input->post('id_material');
        $data['id_brand'] = $this->input->post('id_brand');
        
        $data['height'] = (float)$this->input->post('height', TRUE);
        $data['width'] = (float)$this->input->post('width', TRUE);
        $data['length'] = (float)$this->input->post('length', TRUE);
        $data['volume'] = (float)$this->input->post('volume', TRUE);
        $data['deepth'] = (float)$this->input->post('deepth', TRUE);
        $data['thickness'] = (float)$this->input->post('thickness', TRUE);
        
        $data['date_edit'] = date('Y-m-d H:i:s');
        
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['chpu'] = $this->input->post('chpu');
        $data['is_on_stock'] = $this->input->post('is_on_stock', TRUE);
        $data['is_new'] = isset($_POST['is_new']);
        $data['rating'] = $this->input->post('rating');
        $data['status'] = isset($_POST['in_process'])? 2 : 1;
        $data['related_items'] = $this->input->post('related_value');
        
        $acc_array = array();
        $acc = $this->input->post('acc');
        foreach ($acc as $key => $value) {
            $acc_array[] = $key;
        }
        $data['accessories'] = json_encode($acc_array);
        
        if (empty($data['chpu'])) {
            $data['chpu'] = $this->checkCHPU(rus2translit($data['name']));
        }
        $this->db->where('ID', $id_page);
        $this->db->update($this->tb, $data);
        
        $watermark = $this->input->post('watermark');
        foreach ($_FILES as $key => $file) {
            $result = uploadImage($_SERVER['DOCUMENT_ROOT'] . '/uploads/items/', $key, $watermark);
            if($result['status'] == 1) {
                $this->db->insert('images', array(
                    'id_item' => $id_page,
                    'image' => $result['img']['file_name']
                ));
            }
        }
    
        $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/items/';
        if(isset($_POST['delImage']))
            foreach ($_POST['delImage'] as $key => $value) 
            {
                $where = array(
                    'id_item' => $id_page,
                    'ID' => $key
                );
                $this->db->where($where);
                $this->db->limit(1);
                $query = $this->db->get('images');
                $image = $query->row_array();
                if(file_exists($path . 'original/' . $image['image']))
                    unlink ($path . 'original/' . $image['image']);
                if(file_exists($path . 'thumb/' . $image['image']))
                    unlink ($path . 'thumb/' . $image['image']);
                $this->db->where($where);
                $this->db->delete('images');
            }
        
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
        $this->db->select('c1.*, c2.name as color_name, c2.content as color_content,'
                          . 'c3.name as material_name, c3.content as material_content,'
                          . 'c4.name as brand_name, c4.content as brand_content,');
        $this->db->from($this->tb . ' as c1');
        $this->db->join('item_options as c2', 'c1.id_color = c2.ID AND c2.type="color"', 'left outer');
        $this->db->join('item_options as c3', 'c1.id_material = c3.ID AND c3.type="material"', 'left outer');
        $this->db->join('item_options as c4', 'c1.id_brand = c4.ID AND c4.type="brand"', 'left outer');
        $this->db->order_by('c1.ID');
        $this->db->where('c1.ID', $id_page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $item = $query->row_array();
            $this->load->model('category/mdl_category');
            $item['categories'] = $this->mdl_category->getItemCategoriesIds($id_page);
            $item['accessories'] = json_decode($item['accessories'], TRUE);
            $item['related_items'] = json_decode($item['related_items'], TRUE);
            $this->db->where('id_item', $id_page);
            $this->db->order_by('ID ASC');
            $query = $this->db->get('images');
            $item['images'] = $query->result_array();
            return $item;
        }
        else
            return false;
    }

    function getPageCat($id_page) {
        $this->db->select('c1.id_cat');
        $this->db->from('cat_item as c1');
        $this->db->where('c1.id_page', $id_page);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }

    function getCatList() {
        $this->db->select('c1.ID, c1.cat_name');
        $this->db->from('categories as c1');
        $this->db->where('c1.id_parent >', '0');
        $query = $this->db->get();
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
        $this->db->where('id_item', $id);
        $query = $this->db->get('images');
        $images = $query->result_array();
        $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/items/';
        foreach ($images as $image){
            unlink($path . 'original/' . $image['image']);
            unlink($path . 'thumb/' . $image['image']);
        }
        $this->db->where('id_page', $id);
        $this->db->delete('cat_item');
        
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

    function getItemsCount($field, $value) {
        $this->db->from($this->tb . ' as c1');
        $this->db->where($field, $value);
        $this->db->where('c1.status', 1);
        return $this->db->count_all_results();
    }

    function getItemsByCategory($id_category, $limit, $start) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->where('c1.id_catalog', $id_category);
        $this->db->where('c1.status', 1);
        $this->db->order_by('c1.date', 'desc');
        $this->db->order_by('c1.ID', 'desc');
        if ($limit > 0)
            $this->db->limit($limit, $start);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function getItemById($id_item) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $this->db->where('c1.ID', $id_item);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }

    function getItemsInterval($id_from, $id_to, $limit) {
        $this->db->select('c1.*');
        $this->db->distinct();
        $this->db->from($this->tb . ' as c1');
        $this->db->where('c1.ID >=', $id_from);
        $this->db->where('c1.ID <=', $id_to);
        $this->db->order_by('c1.ID', 'ASC');
        $this->db->limit($limit);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function getItemsByIds($ids, $select = 'c1.*') {
        if(empty($ids))
            return array();
        $this->db->select($select);
        $this->db->from($this->tb . ' as c1');
        $this->db->where_in('ID', $ids);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return false;
    }

    function findItems($text, $limit = 0, $start = 0) {
        $this->db->select('c1.*');
        $this->db->from($this->tb . ' as c1');
        $where = "( c1.ID='" . $text . "' OR c1.name LIKE '%" . $text . "%' ) and c1.status=1";
        $this->db->where($where);
        if ($limit > 0)
            $this->db->limit($limit, $start);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function findCountItems($text) {
        $this->db->select('c1.ID');
        $this->db->from($this->tb . ' as c1');
        $where = "( c1.ID='" . $text . "' OR c1.name LIKE '%" . $text . "%' ) and c1.status=1";
        $this->db->where($where);
        return $this->db->count_all_results();
    }

    function findItem($field, $value, $limit) {
        $this->db->select('c1.*');
        $this->db->distinct();
        $this->db->from($this->tb . ' as c1');
        $this->db->like($field, $value);
        $this->db->limit($limit);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function findItemLinks($field, $value) {
        $this->db->select('c1.chpu');
        $this->db->where($field, $value);
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }

    function getLastNewItems($count, $start = 0) {
        $this->db->from($this->tb . ' as c1');
        $this->db->where('c1.status', 1);
        $this->db->order_by('c1.date', 'desc');
        $this->db->order_by('c1.ID', 'desc');
        $this->db->limit($count, $start);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }
    
    function initItemImages(&$items, $limit = 1) {
        $ids = array();
        foreach ($items as $value) {
            if((int)$value['ID'] > 0)
                $ids[] = $value['ID'];
        }
        
        $images= array();
        if(!empty($ids)) {
            $this->db->select('*');
            $this->db->from('images');
            $this->db->where_in('id_item', $ids);
            $this->db->order_by('ID');
            $query = $this->db->get();
            $images = $query->result_array();
        } 
        
        foreach ($items as &$value) {
            $value['images'] = array();
            $value['image'] = 'no_image.jpg';
            $count = 0;
            foreach ($images as $image) {
                if($value['ID'] == $image['id_item']) {
                    ++$count;
                    $value['images'][] = $image;
                    if($count == 1)
                        $value['image'] = $image['image'];
                    if ($count == $limit)
                        break;
                }
            }
        }
        
    }

    function getUniversal($select = '*', $where = array(), $count = 0, $start = 0, $order_by = '', $like = array(), $where_in = array()) {
        $this->db->select($select, FALSE);
        $this->db->distinct();
        $this->db->from($this->tb . ' as c1');
        $this->db->join('cat_item c3', 'c1.ID = c3.id_page', 'LEFT OUTER');
        $this->db->join('categories c2', 'c3.id_cat = c2.ID', 'LEFT OUTER');
        /*$token = '0';
        if (isset($_SESSION['cart']))
            $token = $_SESSION['cart'];
        $this->db->join('cart c3', 'c1.ID = c3.id_item AND token = "' . $token . '"', 'left outer');*/
        if (!empty($where))
            $this->db->where($where);
        
        foreach ($where_in as $one) {
            $this->db->where_in($one['field'], $one['array']);
        }
        
        if (!empty($like))
            $this->db->like($like);
        if (!empty($order_by))
            $this->db->order_by($order_by);
        if($count > 0)
            $this->db->limit($count, $start);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $query->result_array();
            }
        else
            return false;
    }

    function getUniversalCount($where = array(), $like = array(), $where_in = array()) {
        $this->db->from($this->tb . ' as c1');
        $this->db->join('cat_item c3', 'c1.ID = c3.id_page', 'LEFT OUTER');
        $this->db->join('categories c2', 'c3.id_cat = c2.ID', 'LEFT OUTER');
        if (!empty($where))
            $this->db->where($where);
        foreach ($where_in as $one) {
            $this->db->where_in($one['field'], $one['array']);
        }
        if (!empty($like))
            $this->db->like($like);
        return $this->db->count_all_results();
    }

    function getRandItems($count, $whithout = 0) {
        $this->db->select('c1.ID', FALSE);
        $this->db->from($this->tb . ' as c1');
        if ($whithout > 0)
            $this->db->where('c1.ID !=', $whithout);
        $this->db->where('c1.status', 1);
        $query = $this->db->get();
        $items = $query->result_array();
        shuffle($items);
        $ids = array();
        $k = 0;
        foreach ($items as $value) {
            $ids[] = $value['ID'];
            ++$k;
            if ($k == $count)
                break;
        }

        $this->db->select('c1.*, IFNULL(c3.count, 0) as `count`', FALSE);
        $this->db->from($this->tb . ' as c1');
        $token = '0';
        if (isset($_SESSION['cart']))
            $token = $_SESSION['cart'];
        $this->db->join('cart c3', 'c1.ID = c3.id_item AND token = "' . $token . '"', 'left outer');
        $this->db->where_in('c1.ID', $ids);
        $query = $this->db->get();
        return $query->result_array();
    }

}