<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class fest_enquires_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_events = TABLE_PREFIX . 'events';
            $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
            $this->tbl_model = TABLE_PREFIX_RANA . 'model';
            $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
            $this->tbl_event_enquires = TABLE_PREFIX . 'event_enquires';
            $this->tbl_products = TABLE_PREFIX_RANA . 'products';
            $this->tbl_users = TABLE_PREFIX . 'users';
            $this->tbl_register_master = TABLE_PREFIX . 'register_master';
            $this->tbl_departments = TABLE_PREFIX . 'departments';
            $this->tbl_state = TABLE_PREFIX . 'states';
            $this->tbl_district = TABLE_PREFIX . 'district_statewise';
       }

       function getData($id = '') {
            $selectArray = array(
                $this->tbl_event_enquires . '.*',
                $this->tbl_events . '.evnt_title',
                $this->tbl_brand . '.brd_title',
                $this->tbl_model . '.mod_title',
                $this->tbl_variant . '.var_variant_name',
                $this->tbl_products . '.prd_id',
                'CONCAT(' . $this->tbl_products . '.prd_regno_prt_1,' . $this->tbl_products . '.prd_regno_prt_2,' .
                $this->tbl_products . '.prd_regno_prt_3,' . $this->tbl_products . '.prd_regno_prt_4) AS eve_vehicle_selected',
                $this->tbl_users . '.usr_first_name AS assigedby',
                $this->tbl_register_master . '.vreg_id',
                $this->tbl_register_master . '.vreg_customer_remark',
                $this->tbl_district . '.std_district_name',
                $this->tbl_state . '.sts_name',
                $this->tbl_departments . '.dep_name'
            );


            if (!empty($id)) {
                 $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_event_enquires . '.eve_event', 'LEFT');
                 $this->db->join($this->tbl_products, $this->tbl_products . '.prd_id = ' . $this->tbl_event_enquires . '.eve_vehicle', 'LEFT');
                 $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
                 $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
                 $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');
                 $this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_event_enquires . '.eve_punched_by', 'left');
                 $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_event_enquires . '.eve_register_id', 'left');
                 $this->db->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_event_enquires . '.eve_department', 'left');
                 return $this->db->select($selectArray)->order_by('eve_added_on', 'DESC')->get_where($this->tbl_event_enquires, array('eve_id' => $id))->row_array();
            }

            $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_event_enquires . '.eve_event', 'LEFT');
            $this->db->join($this->tbl_products, $this->tbl_products . '.prd_id = ' . $this->tbl_event_enquires . '.eve_vehicle', 'LEFT');
            $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
            $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
            $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');
            $this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_event_enquires . '.eve_punched_by', 'left');
            $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_event_enquires . '.eve_register_id', 'left');
            $this->db->join($this->tbl_district, "{$this->tbl_district}.std_id = {$this->tbl_event_enquires}.eve_district", 'left');
            $this->db->join($this->tbl_state, "{$this->tbl_state}.sts_id = {$this->tbl_event_enquires}.eve_state", 'left');
            $this->db->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_event_enquires . '.eve_department', 'left');

            if ($this->uid != 100) {
                 if (check_permission('registration', 'shw_pndgtopunch_enquires')) {
                      $this->db->where('eve_register_id', 0);
                 }
            }
            $this->db->where(array('eve_event' => 14));
            return $this->db->select($selectArray)->order_by('eve_added_on', 'DESC')->get($this->tbl_event_enquires)->result_array();
       }

       function getNextOrder($max = false) {
            if ($max) {
                 return $this->db->count_all_results($this->tbl_blogs);
            } else {
                 return $this->db->select_max('blog_order')->get($this->tbl_blogs)->row()->blog_order + 1;
            }
       }

       function newBlog($datas) {
            if (isset($datas['blog']) && !empty($datas['blog'])) {
                 $datas['blog']['blog_slug'] = slugify($datas['blog']['blog_title']);
                 if ($this->db->insert($this->tbl_blogs, $datas['blog'])) {
                      $lastId = $this->db->insert_id();
                      if (isset($datas['tags']) && !empty($datas['tags'])) {

                           foreach ($datas['tags'] as $key => $value) {
                                $this->db->insert($this->tbl_blog_tags_assoc, array('bgtg_blog' => $lastId, 'bgtg_tag' => $value));
                           }
                      }
                      return $lastId;
                 } else {
                      return false;
                 }
            } else {
                 return false;
            }
       }

       function updateBlog($datas, $id) {
            if (!empty($datas['blog']) && !empty($id)) {
                 $this->db->where('blog_id', $id);
                 $datas['blog']['blog_slug'] = slugify($datas['blog']['blog_title']);
                 if ($this->db->update($this->tbl_blogs, $datas['blog'])) {
                      if (isset($datas['tags']) && !empty($datas['tags'])) {
                           $this->db->where('bgtg_blog', $id);
                           $this->db->delete($this->tbl_blog_tags_assoc);
                           foreach ($datas['tags'] as $key => $value) {
                                $this->db->insert($this->tbl_blog_tags_assoc, array('bgtg_blog' => $id, 'bgtg_tag' => $value));
                           }
                      }
                      return true;
                 } else {
                      return false;
                 }
            } else {
                 return false;
            }
       }

       public function addImages($image) {
            if ($this->db->insert($this->tbl_blog_images, $image)) {
                 return true;
            } else {
                 return false;
            }
       }

       function removeNewsImage($id) {
            if ($id) {
                 $this->db->where('bimg_id', $id);
                 $image = $this->db->get($this->tbl_blog_images)->row_array();

                 if (isset($image['bimg_image']) && !empty($image['bimg_image'])) {
                      if (file_exists(UPLOAD_PATH . 'blog/' . $image['bimg_image'])) {
                           unlink(UPLOAD_PATH . 'blog/' . $image['bimg_image']);
                      }
                      if (file_exists(UPLOAD_PATH . 'blog/thumb_' . $image['bimg_image'])) {
                           unlink(UPLOAD_PATH . 'blog/thumb_' . $image['bimg_image']);
                      }
                      $this->db->where('bimg_id', $id);
                      $this->db->delete($this->tbl_blog_images);
                      return true;
                 }
            }
            return false;
       }

       function deleteBlog($id) {
            if (!empty($id)) {
                 $this->db->where('blog_id', $id);
                 if ($this->db->delete($this->tbl_blogs)) {
                      return true;
                 } else {
                      return false;
                 }
            } else {
                 return false;
            }
       }

       function blogCategories($id = '') {
            if (!empty($id)) {
                 return $this->db->get_where($this->tbl_blogs_category, array('bcat_id' => $id))->row_array();
            }
            return $this->db->get($this->tbl_blogs_category)->result_array();
       }

       function deleteCategory($id) {
            if ($id) {
                 $this->db->where('bcat_id', $id);
                 $this->db->delete($this->tbl_blogs_category);
                 return true;
            }
            return false;
       }

       function updateCategory($data) {
            if (!empty($data)) {
                 $id = isset($data['bcat_id']) ? $data['bcat_id'] : 0;
                 unset($data['bcat_id']);
                 $data['bcat_slug'] = slugify($data['bcat_title']);
                 $this->db->where('bcat_id', $id);
                 $this->db->update($this->tbl_blogs_category, $data);
                 return true;
            }
            return false;
       }

       function newCategory($data) {
            if (!empty($data)) {
                 $data['bcat_slug'] = slugify($data['bcat_title']);
                 $this->db->insert($this->tbl_blogs_category, $data);
                 return true;
            }
            return false;
       }

       /* Tag */

       function blogTags($id = '') {
            if (!empty($id)) {
                 return $this->db->get_where($this->tbl_blogs_tags, array('btag_id' => $id))->row_array();
            }
            return $this->db->get($this->tbl_blogs_tags)->result_array();
       }

       function deleteTag($id) {
            if ($id) {
                 $this->db->where('btag_id', $id);
                 $this->db->delete($this->tbl_blogs_tags);
                 return true;
            }
            return false;
       }

       function updateTag($data) {
            if (!empty($data)) {
                 $id = isset($data['btag_id']) ? $data['btag_id'] : 0;
                 unset($data['btag_id']);
                 $data['btag_slug'] = slugify($data['btag_title']);
                 $this->db->where('btag_id', $id);
                 $this->db->update($this->tbl_blogs_tags, $data);
                 return true;
            }
            return false;
       }

       function newTag($data) {
            if (!empty($data)) {
                 $data['btag_slug'] = slugify($data['btag_title']);
                 $this->db->insert($this->tbl_blogs_tags, $data);
                 return true;
            }
            return false;
       }

  }
  