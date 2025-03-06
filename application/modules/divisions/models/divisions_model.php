<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class divisions_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_divisions = TABLE_PREFIX . 'divisions';
       }

       public function getData($id = '') {

            if (!empty($id)) {
                 $this->db->where('div_id', $id);
                 return $this->db->get($this->tbl_divisions)->row_array();
            }
            return $this->db->get($this->tbl_divisions)->result_array();
       }
       
       public function getActiveData() {
            return $this->db->where('div_status', 1)->get($this->tbl_divisions)->result_array();
       }

       public function addData($datas) {
            if ($this->db->insert($this->tbl_divisions, $datas)) {
                 $id = $this->db->insert_id();
                 generate_log(array(
                     'log_title' => 'New records',
                     'log_desc' => 'New division created',
                     'log_controller' => 'new-division',
                     'log_action' => 'C',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

       public function updateData($datas) {
            $this->db->where('div_id', $datas['div_id']);
            $id = $datas['div_id'];
            unset($datas['div_id']);
            if ($this->db->update($this->tbl_divisions, $datas)) {
                 generate_log(array(
                     'log_title' => 'update records',
                     'log_desc' => 'Update division',
                     'log_controller' => 'update-division',
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 generate_log(array(
                     'log_title' => 'update records failed',
                     'log_desc' => 'Updated division failed',
                     'log_controller' => 'update-division-error',
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return false;
            }
       }

       public function deleteData($id) {
            $this->db->where('div_id', $id);
            if ($this->db->delete($this->tbl_divisions)) {
                 generate_log(array(
                     'log_title' => 'Delete records',
                     'log_desc' => 'Delete division',
                     'log_controller' => 'delete-division',
                     'log_action' => 'D',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }
       public function getDivNameById($id = '') {

          if (!empty($id)) {
               $this->db->select('div_name')->where('div_id', $id);
               return $this->db->get($this->tbl_divisions)->row_array();
          }
          return false;
       
     }
  } 