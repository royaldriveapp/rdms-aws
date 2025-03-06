<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class Category_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->table = TABLE_PREFIX . 'category';
       }

       public function addNewCategory($datas) {
            $datas['cat_slug'] = get_url_string($datas['cat_title']);
            if ($this->db->insert($this->table, $datas)) {
                 return true;
            } else {
                 return false;
            }
       }

       public function getCategoryChaild($parent, $idNotin = '') {

            $this->db->select("cat_id, cat_title");
            $this->db->where('cat_parent', $parent);
            if (!empty($idNotin)) {
                 $this->db->where('cat_id !=', $idNotin);
            }
            $result = $this->db->get($this->table)->result_array();
            return $result;
       }

       public function getCategories($id = '') {

            $this->db->select("gcat.*, gcat.cat_show_on_footer, gcat.cat_show_on_home_page, gcat.cat_image AS cat_image, gcat.cat_parent AS cat_parent, gcat.cat_desc AS category_desc, gcat.cat_title AS category_name, gcat.cat_id AS cat_id, gcat2.cat_title AS parent_category");
            $this->db->from($this->table . ' gcat');
            $this->db->join($this->table . ' gcat2', 'gcat.cat_parent = gcat2.cat_id', 'left');
            if (!empty($id)) {
                 $this->db->where('gcat.cat_id', $id);
                 return $this->db->get()->row_array();
            } else {
                 return $this->db->get()->result_array();
            }
       }

       public function updateCategory($datas) {
            
            $dataWithOldPriority = $this->db->get_where($this->table, array('cat_order' => $datas['cat_order']))->row_array();
            $dataWithNewPriority = $this->db->get_where($this->table, array('cat_id' => $datas['cat_id']))->row_array();
            $datas['cat_slug'] = get_url_string($datas['cat_title']);
            $this->db->where('cat_id', $datas['cat_id']);
            $datas['cat_show_on_home_page'] = isset($datas['cat_show_on_home_page']) ? $datas['cat_show_on_home_page'] : 0;
            $datas['cat_show_on_footer'] = isset($datas['cat_show_on_footer']) ? $datas['cat_show_on_footer'] : 0;

            unset($datas['cat_id']);
            if ($this->db->update($this->table, $datas)) {

                 if (!empty($dataWithOldPriority) && !empty($dataWithNewPriority)) {
                      $this->db->where('cat_id', $dataWithOldPriority['cat_id']);
                      $this->db->update($this->table, array('cat_order' => $dataWithNewPriority['cat_order']));
                 }

                 return true;
            } else {
                 return false;
            }
       }

       public function deleteCategory($id) {

            $this->removeCategoryImage($id);
            $this->db->where('cat_id', $id);
            if ($this->db->delete($this->table)) {
                 $this->db->where('cat_parent', $id);
                 $this->db->delete($this->table);
                 return true;
            } else {
                 return false;
            }
       }

       public function categoryTree() {

            $this->db->select("cat.cat_id AS category_id, cat.cat_title AS category_name, cat2.cat_title AS parent_category_name, cat2.cat_id AS parent_category_id")
                    ->from($this->table . ' cat')
                    ->join($this->table . ' cat2', 'cat.cat_parent = cat2.cat_id', 'LEFT')
                    ->order_by('parent_category_name');
            $tree = $this->db->get()->result_array();
            return $tree;
       }

       public function removeCategoryImage($id) {
            if ($id) {
                 $this->db->where('cat_id', $id);
                 $image = $this->db->get($this->table)->result_array();
                 $image = isset($image['0']) ? $image['0'] : array();
                 if (isset($image['cat_image']) && !empty($image['cat_image'])) {
                      if (file_exists(FILE_UPLOAD_PATH . 'category/' . $image['cat_image'])) {
                           unlink(FILE_UPLOAD_PATH . 'category/' . $image['cat_image']);
                      }
                      if (file_exists(FILE_UPLOAD_PATH . 'category/thumb_' . $image['cat_image'])) {
                           unlink(FILE_UPLOAD_PATH . 'category/thumb_' . $image['cat_image']);
                      }
                      $this->db->where('cat_id', $id);
                      $this->db->update($this->table, array('cat_image' => ''));
                      return true;
                 }
            }
            return false;
       }

       function getNextOrder($max = false) {
            if ($max) {
                 return $this->db->count_all_results($this->table);
            } else {
                 return $this->db->select_max('cat_order')->get($this->table)->row()->cat_order + 1;
            }
       }

  }
  