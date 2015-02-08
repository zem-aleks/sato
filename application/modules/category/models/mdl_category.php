<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_category extends Model {

    //Название таблицы
    var $table = 'categories';
    //Количество элементов на странице
    var $per_page = 35;

    function Mdl_category() {
        parent::__construct();
        $this->load->helper('datapage');
    }

    function count_all($lang = 'all', $cat_id = '') {

        $this->db->from($this->table . ' AS c1');

        if ($cat_id != '' && $cat_id != -1)
            $this->db->where('c1.cat_id', $cat_id);

        return $this->db->count_all_results();
    }

    function getlist($lang = 'all', $cat_id = 0, $start_row = 0) {
        $this->db->select('c1.*');
        $this->db->from($this->table . ' as c1');
        $this->db->order_by('sort');

        $query = $this->db->get();
        if ($query->num_rows() > 0)
            return $this->get_tree($query->result_array(), 0);
        else
            return false;
    }

    function getTopMenu() {
        $this->db->select('c1.*');
        $this->db->from($this->table . ' as c1');
        $this->db->where('c1.status', 1);
        $this->db->order_by('c1.ID');
        $query = $this->db->get();

        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    /* -------------генерация дерева------------ */

    function get_tree($tree, $pid, $key = 0) {
        $html = '';
        $fl = 0;
        foreach ($tree as $row) {
            if ($row['id_parent'] == $pid) {
                $html .= '<li id="' . $row['ID'] . '" ><dl';
                if ($key % 2 == 0)
                    $html .= ' class="gray"';
                $key++;
                $html .= '> 
								<dt>
									<a href="#" class="collapse">&nbsp;</a>
									<a href="#" class="name">' . $row['cat_name'] . '</a>
								</dt>';
                
                $html .= '
								<dd>
                                                                
									<a href="javascript:void(0)" onclick="ConfirmDelete(\'' . base_url() . 'dashboard/category/del/' . $row['ID'] . '\')" class="delete"  title="Удалить">Delete</a>
								</dd>
								<dd>';

                if ($row['status'] == '1') {
                    $html .= '<a href="' . base_url() . 'dashboard/category/status/' . $row['ID'] . '/0" class="status on"  title="Выкл">Satatus</a>';
                } else {
                    $html .= '<a href="' . base_url() . 'dashboard/category/status/' . $row['ID'] . '/1" class="status"  title="Вкл">Satatus</a>';
                }

                $html .= '</dd>
                            <dd><a href="/dashboard/category/edit/' . $row['ID'] . '" class="edit"  title="Редактировать">Edit</a></dd>
							';
						
                $html .= '<dd><a class="sort up" href="javascript: void(0);"></a>';
                $html .= '<a class="sort down" href="javascript: void(0);"></a></dd>';
                $html .= '</dl>' . $this->get_tree($tree, $row['ID'], $key). '</li>';
                if ($row['id_parent'] == 0)
                    $fl = 1;
                else
                    $fl = 0;
            }
        }

        if ($fl == 1)
            return $html ? '<ul id="categ1">' . $html . '</ul><div class="clear"></div>' . "\n" : '';
        else
            return $html ? '<ul>' . $html . '</ul><div class="clear"></div>' . "\n" : '';
    }

    function user_tree($tree, $pid, $key = 1) {
        $html = '';
        $fl = 0;
        foreach ($tree as $row) {
            if ($row['id_parent'] == $pid) {
                $sql = "SELECT c1.chpu FROM tbl_pages as c1, tbl_cat_pages as c2 WHERE c1.status = 1 AND c1.ID = c2.id_page AND c2.id_cat = '" . $row['ID'] . "'";
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                    $link = $query->row_array();
                    $html .= '<li id="' . $row['ID'] . '" >
							<a href="/pages/' . $link['chpu'] . '" class="name">' . $row['cat_name'] . '</a>
							' . $this->user_tree($tree, $row['ID'], $key) . '
						</li>';
                } else {
                    $html .= '<li id="' . $row['ID'] . '" >' . $row['cat_name'] . $this->user_tree($tree, $row['ID'], $key++) . '</li>';
                }
                if ($row['id_parent'] == 0)
                    $fl = 1;
                else
                    $fl = 0;
                $query->free_result();
            }
        }

        if ($fl == 1)
            return $html ? '<ul id="top">' . $html . '</ul>' . "\n" : '';
        else
            return $html ? '<ul>' . $html . '</ul>' . "\n" : '';
    }

    /* -------------------------------------------------------------------- */

    function add() {
        $data = array();
        $data['cat_name'] = $this->input->post('name');
        $data['url'] = $this->input->post('url');
        $data['id_parent'] = 0;
        if(empty($data['cat_name']))
            return false;
        
        /*$data['chpu'] = $this->input->post('chpu');
        $data['title'] = $this->input->post('title');
        $data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['content'] = $this->input->post('content');
        $data['id_parent'] = $this->input->post('id_parent');
        $data['top_item_id'] = $this->input->post('top_item_id');
        $data['top_item_name'] = $this->input->post('top_item_name');
        $data['top_item_desc'] = $this->input->post('top_item_desc');
        $data['new_item_id'] = $this->input->post('new_item_id');
        $data['page_text'] = $this->input->post('page_text');

        if (empty($data['chpu'])) {
            $data['chpu'] = rus2translit($data['cat_name']);
        }

        if (empty($data['cat_name']) || empty($data['chpu']))
            return false;
        */
        
        $this->db->select_max('sort');
        $query = $this->db->get($this->table);
        $sort = $query->row_array();
        $data['sort'] = ++$sort['sort'];

        $this->db->insert($this->table, $data);
        $id_cat = $this->db->insert_id();

        return true;
    }

    function edit($id) {
        $data = array();
        $data['cat_name'] = $this->input->post('name');
        $data['url'] = $this->input->post('url');
        /*$data['mkeys'] = $this->input->post('mkeys');
        $data['mdesc'] = $this->input->post('mdesc');
        $data['id_parent'] = $this->input->post('id_parent');
        if ($data['id_parent'] == '') {
            $data['id_parent'] = 0;
        }
        $data['top_item_id'] = $this->input->post('top_item_id');
        $data['top_item_name'] = $this->input->post('top_item_name');
        $data['top_item_desc'] = $this->input->post('top_item_desc');
        $data['new_item_id'] = $this->input->post('new_item_id');
        $data['page_text'] = $this->input->post('page_text');
        
        $data['cat_name'] = $this->input->post('name');
        $data['content'] = $this->input->post('content');*/
        
        /*$del = $this->input->post('del');
        if (empty($data['cat_name']) && empty($data['chpu']))
            return false;
        if (empty($data['chpu'])) {
            $data['chpu'] = rus2translit($data['cat_name']);
        }*/
        $this->db->where('ID', $id);
        $this->db->update($this->table, $data);
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

    function drag() {
        if (isset($_POST) && isset($_POST['item']) && isset($_POST['parent'])) {
            $data['id_parent'] = $_POST['parent'];
            $this->db->where('ID', $_POST['item']);
            $this->db->update($this->table, $data);
        }
    }

    function del($id) {
        $this->db->select('ID');
        $this->db->where('id_parent', $id);
        $query = $this->db->get($this->table);
        if($query->num_rows() > 0) {
            $cats = $query->result_array();
            foreach ($cats as $value) {
                $this->del($value['ID']);
            }
        }
        
        $this->db->where('ID', $id);
        $this->db->delete($this->table);
    }

    function getCategories() {
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }

    /**
     * Создает список категорий по указанным начальному и конечному уровню глубины
     * 
     * @param int $levelBegin с этого уровня категории добавляются в список (начинается с 0)
     * @param int $levelEnd до этого уровня ищутся категории
     * @param int $id_parent корень от которого начинают искаться категории
     * @param int $level текущий уровень поиска
     * 
     * @return array|false  возвращает массив категорий или ложь, если ничего не найденно
     */
    function getCatsForMenuEdit($levelBegin = 0, $levelEnd = 1, $id_parent = 0, $level = 0) {
        $this->db->select('c1.*, c2.cat_name as top');
        $this->db->distinct();
        $this->db->from($this->table . ' as c1');
        $this->db->join($this->table . ' as c2', 'c1.id_parent = c2.ID', 'LEFT OUTER');
        $this->db->where('c1.id_parent', $id_parent);
        $this->db->order_by('c1.sort');

        $query = $this->db->get($this->table);

        if ($query->num_rows() > 0) {
            $list = $query->result_array();
            ++$level;
            foreach ($list as $item) {

                if ($level - 1 >= $levelBegin) {
                    $result[] = $item;
                }

                if ($level <= $levelEnd) {
                    $new_list = $this->getCatsForMenuEdit($levelBegin, $levelEnd, $item['ID'], $level);
                    if ($new_list)
                        foreach ($new_list as $key => $value) {
                            $result[] = $value;
                        }
                }
            }

            return $result;
        }
        else
            return false;
    }

    
    /* this is function need to cache mexanizm */
    function getMenu($id_parent = 0) {
        $this->db->select('c1.*');
        $this->db->distinct();
        $this->db->from($this->table . ' as c1');
        $this->db->where('c1.id_parent', $id_parent);
        $this->db->where('c1.status', 1);
        $this->db->order_by('c1.sort');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $menu = $query->result_array();
            foreach ($menu as &$value) {
                if($id_parent == 0) {
                    $value['children'] = $this->getMenu($value['ID']);
                    $value['brands'] = $this->getCategoryBrands($value);
                    if($value['top_item_id']) {
                        $this->load->model('item/mdl_item');
                        $value['topItem'] = $this->mdl_item->getPageInfo($value['top_item_id']);
                    }
                } else {
                    $value['count'] = 0;
                    $this->db->from('cat_item');
                    $this->db->join('item', 'item.ID = cat_item.id_page');
                    $this->db->where('id_cat', $value['ID']);
                    $this->db->where('item.status', 1);
                    $value['count'] = $this->db->count_all_results();
                }
            }
            return $menu;
        }
        else
            return false;
    }
    
    /*
     * @param array $category - category with children
     */
    function getCategoryBrands($category)
    {
        $brands = array();
        $ids = array();
        if($category['children'])
            foreach ($category['children'] as $value) {
                $ids[] = $value['ID'];
            }
        if(!empty($ids)) {
            $this->db->select('c1.id_brand, c2.name');
            $this->db->distinct();
            $this->db->from('item as c1');
            $this->db->join('item_options as c2', 'c1.id_brand = c2.ID');
            $this->db->join('cat_item c3', 'c1.ID = c3.id_page');
            $this->db->where('c1.status', 1);
            $this->db->where_in('c3.id_cat', $ids);
            $query = $this->db->get();
            $brands = $query->result_array();
        }
        
        return $brands;
    }
    
    function getCategoriesList() {
        $this->db->select('c1.*');
        $this->db->from($this->table . ' as c1');
        $this->db->where('c1.status', 1);
        $this->db->order_by('c1.sort');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $list = $query->result_array();
            $result = array();
            foreach ($list as $item) {
                $result[$item['ID']] = $item['cat_name'];
            }
            return $result;
        }
        else
            return false;
    }

    function getShopList() {
        $this->db->select('c1.*');
        $this->db->from($this->table . ' as c1');
        $this->db->where('c1.id_parent', 0);
        $this->db->order_by('c1.sort');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $list = $query->result_array();
            $result = array();
            foreach ($list as $item) {
                $result[$item['ID']] = $item['cat_name'];
            }
            return $result;
        }
        else
            return false;
    }

    function getIzmer() {
        $query = $this->db->get('tbl_izmer');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return false;
    }

    function getCategory($id_cat) {
        $this->db->select('c1.*');
        $this->db->from($this->table . ' as c1');
        $this->db->where('c1.ID', $id_cat);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }
    
    function getCategoryCHPU($chpu, $where = array()) {
        $this->db->select('c1.*');
        $this->db->from($this->table . ' as c1');
        $this->db->where('c1.chpu', $chpu);
        if(!empty($where))
            $this->db->where($where);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        else
            return false;
    }

    function getCategoryListByField($field_name, $field_value, $settings = null) {
        $this->db->where($field_name, $field_value);
        $this->db->where('status', 1);
        $this->db->order_by('sort');
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            $list = $query->result_array();
            $result = array();
            if (isset($settings['type']) && $settings['type'] == 'massiv')
                return $list;

            foreach ($list as $item) {
                $result[$item['ID']] = $item;
            }

            return $result;
        }
        else
            return false;
    }

    function getCategoriesOfParent($id_parent) {
        $this->db->where('id_parent', $id_parent);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0)
            return $query->result_array();
        else
            return false;
    }
    
    function getItemCategories($idItem, $select = 'c2.*', $status = -1)
    {
        $this->db->select($select);
        $this->db->from('cat_item as c1');
        $this->db->join('categories c2', 'c1.id_cat = c2.ID');
        $this->db->where('c1.id_page', $idItem);
        if($status != -1)
            $this->db->where('c2.status', $status);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    function getItemCategoriesIds($idItem)
    {
        $result = array();
        $this->db->select('id_cat');
        $this->db->where('id_page', $idItem);
        $query = $this->db->get('cat_item');
        $rows = $query->result_array();
        foreach ($rows as $row)
            $result[] = $row['id_cat'];
        return $result;
    }


}
