<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class departments_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_departments = TABLE_PREFIX . 'departments';
            $this->tbl_divisions = TABLE_PREFIX . 'divisions';
       }

       public function getData($id = '') {

            if (!empty($id)) {
                 $this->db->where('dep_id', $id);
                 return $this->db->get($this->tbl_departments)->row_array();
            }
            return $this->db->select($this->tbl_departments . '.*,' . $this->tbl_divisions . '.* , parentDep.dep_name AS dep_parent_name', false)
                            ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_departments . '.dep_division', 'LEFT')
                            ->join($this->tbl_departments . ' parentDep', 'parentDep.dep_id = ' . $this->tbl_departments . '.dep_parent', 'LEFT')
                            ->where($this->tbl_departments . '.dep_status', 1)->get($this->tbl_departments)->result_array();
       }

       public function addData($datas) {
            if ($this->db->insert($this->tbl_departments, $datas)) {
                 $id = $this->db->insert_id();
                 generate_log(array(
                     'log_title' => 'New records',
                     'log_desc' => 'New department created',
                     'log_controller' => 'new-department',
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
            $this->db->where('dep_id', $datas['dep_id']);
            $id = $datas['dep_id'];
            unset($datas['dep_id']);
            if ($this->db->update($this->tbl_departments, $datas)) {
                 generate_log(array(
                     'log_title' => 'update records',
                     'log_desc' => 'Update department',
                     'log_controller' => 'update-department',
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 generate_log(array(
                     'log_title' => 'update records failed',
                     'log_desc' => 'Updated department failed',
                     'log_controller' => 'update-department-error',
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return false;
            }
       }

       public function deleteData($id) {
            $this->db->where('dep_id', $id);
            if ($this->db->delete($this->tbl_departments)) {
                 generate_log(array(
                     'log_title' => 'Delete records',
                     'log_desc' => 'Delete department',
                     'log_controller' => 'delete-department',
                     'log_action' => 'D',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

       function getParentDepartment() {
            return $this->db->get_where($this->tbl_departments, array('dep_parent' => 0))->result_array();
       }
  }