<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class grade_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_grade = TABLE_PREFIX . 'grade';
            $this->tbl_groups = TABLE_PREFIX . 'groups';
       }

       public function getData($id = '') {

            if (!empty($id)) {
                 $this->db->where('grd_id', $id);
                 return $this->db->get($this->tbl_grade)->row_array();
            }
            return $this->db->select(array($this->tbl_groups . '.*', $this->tbl_grade . '.*'))
                            ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_grade . '.grd_designation', 'LEFT')
                            ->where('grd_status', 1)->get($this->tbl_grade)->result_array();
       }

       public function addData($datas) {
            if ($this->db->insert($this->tbl_grade, $datas)) {
                 $id = $this->db->insert_id();
                 generate_log(array(
                     'log_title' => 'New records',
                     'log_desc' => 'New grade created',
                     'log_controller' => 'new-grade',
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
            $this->db->where('grd_id', $datas['grd_id']);
            $id = $datas['grd_id'];
            unset($datas['grd_id']);
            if ($this->db->update($this->tbl_grade, $datas)) {
                 generate_log(array(
                     'log_title' => 'update records',
                     'log_desc' => 'Update grade',
                     'log_controller' => 'update-grade',
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 generate_log(array(
                     'log_title' => 'update records failed',
                     'log_desc' => 'Updated grade failed',
                     'log_controller' => 'update-grade-error',
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return false;
            }
       }

       public function deleteData($id) {
            $this->db->where('grd_id', $id);
            if ($this->db->delete($this->tbl_grade)) {
                 generate_log(array(
                     'log_title' => 'Delete records',
                     'log_desc' => 'Delete grade',
                     'log_controller' => 'delete-grade',
                     'log_action' => 'D',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

  }
  