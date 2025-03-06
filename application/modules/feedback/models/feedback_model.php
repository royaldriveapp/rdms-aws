<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class feedback_model extends CI_Model {

     public function __construct() {
          parent::__construct();
          $this->load->database();
          $this->tbl_feedback = 'app_feedback';
          $this->tbl_users = TABLE_PREFIX . 'users';
     }

     function getAllAppFeedback($id = '') {
          if ($id) {
               return $this->db->where('app_feedback_id', $id)->get($this->tbl_feedback)->row_array();
          }
          return $this->db->select($this->tbl_feedback . '.*, ' . $this->tbl_users . '.usr_username')
                          ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_feedback . '.app_feedback_action_pln_added_by', 'LEFT')
                          ->get($this->tbl_feedback)->result_array();
     }

     function getLiveAppFeedback() {
          return $this->db->select($this->tbl_feedback . '.*, ' . $this->tbl_users . '.usr_username')
                          ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_feedback . '.app_feedback_action_pln_added_by', 'LEFT')
                          ->where('app_feedback_action_pln IS NULL')->get($this->tbl_feedback)->result_array();
     }

     function updateFeedback($datas) {
          if ($datas) {
               $feedbackId = $datas['app_feedback_id'];
               unset($datas['app_feedback_id']);
               $datas['app_feedback_action_date'] = date('Y-m-d H:i:s');
               $datas['app_feedback_action_pln_added_by'] = $this->uid;
               $this->db->where('app_feedback_id', $feedbackId);
               $this->db->update($this->tbl_feedback, $datas);
               return true;
          }
          return false;
     }

}
