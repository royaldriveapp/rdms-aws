<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class manage_banner_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_banner = TABLE_PREFIX . 'banner';
       }

       function getBanner($id = '') {
            if ($id) {
                 return $this->db->where('bnr_id', $id)->get($this->tbl_banner)->row_array();
            } else {
                 return $this->db->order_by('bnr_order', 'asc')->get($this->tbl_banner)->result_array();
            }
       }
       
       function getSiteBanner($id = '') {
            if ($id) {
                 return $this->db->where('bnr_id', $id)->get($this->tbl_banner)->row_array();
            } else {
                 return $this->db->order_by('bnr_order', 'asc')->get_where($this->tbl_banner, array('bnr_category' => 1))->result_array();
            }
       }

       function getNextOrder($max = false) {
            if ($max) {
                 return $this->db->count_all_results($this->tbl_banner);
            } else {
                 return $this->db->select_max('bnr_order')->get($this->tbl_banner)->row()->bnr_order + 1;
            }
       }

       function addNewBenner($data) {
            if (!empty($data)) {
                 $this->db->insert($this->tbl_banner, $data);
                 return true;
            } else {
                 return false;
            }
       }

       function updateBenner($data) {
            if (!empty($data)) {

                 $dataWithOldPriority = $this->db->get_where($this->tbl_banner, array('bnr_order' => $data['banner']['bnr_order']))->row_array();
                 $dataWithNewPriority = $this->db->get_where($this->tbl_banner, array('bnr_id' => $data['bnr_id']))->row_array();

                 $id = $data['bnr_id'];
                 $this->db->where('bnr_id', $id);
                 $this->db->update($this->tbl_banner, $data['banner']);

                 if (!empty($dataWithOldPriority) && !empty($dataWithNewPriority)) {
                      $this->db->where('bnr_id', $dataWithOldPriority['bnr_id']);
                      $this->db->update($this->tbl_banner, array('bnr_order' => $dataWithNewPriority['bnr_order']));
                 }
                 return true;
            } else {
                 return false;
            }
       }

       function removeImage($id, $image) {
            $this->db->where('bnr_id', $id);
            $this->db->update($this->tbl_banner, array('bnr_image' => ''));

            if (file_exists(FILE_UPLOAD_PATH . 'banner/' . $image)) {
                 unlink(UPLOAD_PATH . 'banner/' . $image);
                 unlink(UPLOAD_PATH . 'banner/thumb_' . $image);
            }
       }

       function deleteBanner($id, $image) {
            $this->db->where('bnr_id', $id);
            $res = $this->db->delete($this->tbl_banner);
            if (file_exists(UPLOAD_PATH . 'banner/' . $image)) {
                 unlink(UPLOAD_PATH . 'banner/' . $image);
                 unlink(UPLOAD_PATH . 'banner/thumb_' . $image);
            }
            return $res;
       }

  }
  