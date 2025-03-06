<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class inquiry_schedule_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_groups = TABLE_PREFIX . 'groups';
            $this->tbl_enquiry_schedule = TABLE_PREFIX . 'enquiry_schedule';
       }

       public function getData($id = '') {

            if (!empty($id)) {
                 $this->db->where('isch_id', $id);
                 return $this->db->get($this->tbl_enquiry_schedule)->row_array();
            }
            return $this->db->select($this->tbl_enquiry_schedule . '.*,' . $this->tbl_groups . '.*')
                            ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_enquiry_schedule . '.isch_desig', 'LEFT')
                            ->get($this->tbl_enquiry_schedule)->result_array();
       }

       public function addData($datas) {
            if ($this->db->insert($this->tbl_enquiry_schedule, array_filter($datas))) {
                 $id = $this->db->insert_id();
                 generate_log(array(
                     'log_title' => 'New records',
                     'log_desc' => 'New inquiry schedule created',
                     'log_controller' => 'new-inquiry-schedule',
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
            $this->db->where('isch_id', $datas['isch_id']);
            $id = $datas['isch_id'];
            unset($datas['isch_id']);
            if ($this->db->update($this->tbl_enquiry_schedule, $datas)) {
                 generate_log(array(
                     'log_title' => 'update records',
                     'log_desc' => 'Update inquiry schedule',
                     'log_controller' => 'update-inquiry-schedule',
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 generate_log(array(
                     'log_title' => 'update records failed',
                     'log_desc' => 'Updated inquiry schedule failed',
                     'log_controller' => 'update-inquiry-schedule-error',
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return false;
            }
       }

       public function deleteData($id) {
            $this->db->where('isch_id', $id);
            if ($this->db->delete($this->tbl_enquiry_schedule)) {
                 generate_log(array(
                     'log_title' => 'Delete records',
                     'log_desc' => 'Delete inquiry schedule',
                     'log_controller' => 'delete-inquiry-schedule',
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
  