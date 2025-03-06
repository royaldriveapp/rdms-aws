<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class seo_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->tbl_seo_pages = TABLE_PREFIX . 'seo_pages';
          $this->tbl_seo_cms = TABLE_PREFIX . 'seo_cms';

          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_products = TABLE_PREFIX_RANA . 'products';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbt_prod_features = TABLE_PREFIX_RANA . 'prod_features';
          $this->tbt_prod_images = TABLE_PREFIX_RANA . 'prod_images';
          $this->tbl_users = TABLE_PREFIX_RANA . 'users';
          $this->tbl_prod_images = TABLE_PREFIX_RANA . 'prod_images';
     }

     function getPageTitles($id = 0)
     {
          if (!empty($id)) {
               return $this->db->get_where($this->tbl_seo_pages, array('seop_id' => $id))->row_array();
          }
          return $this->db->get($this->tbl_seo_pages)->result_array();
     }

     public function updateData($datas)
     {
          $this->db->where('seop_id', $datas['seop_id']);
          $id = $datas['seop_id'];
          unset($datas['seop_id']);
          $datas['prd_sync'] = 0;
          if ($this->db->update($this->tbl_seo_pages, $datas)) {
               generate_log(array(
                    'log_title' => 'update page title',
                    'log_desc' => serialize($datas),
                    'log_controller' => 'update-page-title',
                    'log_action' => 'U',
                    'log_ref_id' => $id,
                    'log_added_by' => $this->uid
               ));
               return true;
          } else {
               generate_log(array(
                    'log_title' => 'update page title error',
                    'log_desc' => serialize($datas),
                    'log_controller' => 'update-page-title-error',
                    'log_action' => 'U',
                    'log_ref_id' => $id,
                    'log_added_by' => $this->uid
               ));
               return false;
          }
     }

     function getPagecms($id = 0)
     {
          if (!empty($id)) {
               return $this->db->select($this->tbl_seo_cms . '.*, ' . $this->tbl_seo_pages . '.*')
                    ->join($this->tbl_seo_pages, $this->tbl_seo_pages . '.seop_id = ' . $this->tbl_seo_cms . '.seocms_page', 'LEFT')
                    ->get_where($this->tbl_seo_cms, array('seocms_id' => $id))->row_array();
          }
          return $this->db->select($this->tbl_seo_cms . '.*, ' . $this->tbl_seo_pages . '.*')
               ->join($this->tbl_seo_pages, $this->tbl_seo_pages . '.seop_id = ' . $this->tbl_seo_cms . '.seocms_page', 'LEFT')
               ->get($this->tbl_seo_cms)->result_array();
     }

     function setPagecms($data)
     {
          $this->db->where('seocms_id', $data['seocms_id']);
          $id = $data['seocms_id'];
          unset($data['seocms_id']);
          $data['seocms_updatd_on'] = date('Y-m-d H:i:s');
          $data['seocms_updatd_by'] = $this->uid;
          if ($this->db->update($this->tbl_seo_cms, $data)) {
               generate_log(array(
                    'log_title' => 'update page content cms',
                    'log_desc' => serialize($data),
                    'log_controller' => 'update-page-cms',
                    'log_action' => 'U',
                    'log_ref_id' => $id,
                    'log_added_by' => $this->uid
               ));
               return true;
          } else {
               generate_log(array(
                    'log_title' => 'update page content error',
                    'log_desc' => serialize($data),
                    'log_controller' => 'update-page-cms-error',
                    'log_action' => 'U',
                    'log_ref_id' => $id,
                    'log_added_by' => $this->uid
               ));
               return false;
          }
     }

     function products($id = 0)
     {
          $selectArray = array(
               $this->tbl_products . '.prd_id',
               $this->tbl_products . '.prd_rd_mini',
               $this->tbl_products . '.prd_number',
               $this->tbl_products . '.prd_page_title',
               $this->tbl_products . '.prd_meta_desc',
               $this->tbl_products . '.prd_rd_mini',
               $this->tbl_brand . '.brd_title',
               $this->tbl_brand . '.brd_slug',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
          );

          $this->db->select($selectArray)
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.id = ' . $this->tbl_products . '.prd_user_id', 'left');

          if ($id) {
               $this->db->where($this->tbl_products . '.prd_id', $id);
               $return = $this->db->where($this->tbl_products . '.prd_added_by_user', 0)->get($this->tbl_products)->row_array();
               $return['images'] = $this->db->get_where($this->tbl_prod_images, array('pdi_prod_id' => $id))->result_array();
               return $return;
          }

          return $this->db->where(array($this->tbl_products . '.prd_added_by_user' => 0, $this->tbl_products . '.prd_status' => 1))
               ->get($this->tbl_products)->result_array();
     }

     function setProductTitle($data)
     {
          $this->db->where('prd_id', $data['prd_id'])->update(
               $this->tbl_products,
               array('prd_page_title' => $data['prd_page_title'], 'prd_meta_desc' => $data['prd_meta_desc'], 'prd_sync' => 0)
          );

          foreach ($data['pdi_image_alt'] as $key => $value) {
               $this->db->where('pdi_id', $key)->update($this->tbl_prod_images, array('pdi_image_alt' => $value));
          }
          return true;
     }
}
