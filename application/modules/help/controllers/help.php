<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class help extends App_Controller {

       public function __construct() {

            parent::__construct();
            $this->page_title = 'Help';
       }

       public function index() {
            $this->page_title = 'Help';
            $this->render_page(strtolower(__CLASS__) . '/index');
       }

       function missingContactModes($enqId = '') {
            if (empty($enqId)) {
                 if ($this->uid == 1) {
                      $this->db->where("(enq_mode_enq IS NULL or enq_mode_enq = 0 or enq_mode_enq = '')");
                 } else {
                      $this->db->where("enq_se_id = " . $this->uid . " AND  (enq_mode_enq IS NULL or enq_mode_enq = 0 or enq_mode_enq = '')");
                 }
                 $data['enquires'] = $this->db->get('cpnl_enquiry')->result_array();
                 $this->render_page('missingContactModes', $data);
            } else if (!empty($enqId) && !empty($_POST)) {
                 $enqId = encryptor($enqId, 'D');
                 $mod = isset($_POST['value']) ? $_POST['value'] : 0;

                 $this->db->where('enq_id', $enqId);
                 $this->db->update('cpnl_enquiry', array('enq_mode_enq' => $mod));

                 generate_log(array(
                     'log_title' => 'Reset mode of contact ',
                     'log_desc' => $enqId . '-' . $mod,
                     'log_controller' => 'reset-mode-of-contact',
                     'log_action' => 'U',
                     'log_ref_id' => $enqId,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 echo json_encode(array('status' => 'success', 'msg' => 'Mode of contact successfully changed!'));
            }
       }

       function bulkdropdel() {
            $enqId = $this->db->query("SELECT * FROM `cpnl_enquiry` where `enq_current_status` IN (2,4,8)")->result_array();
            foreach ($enqId as $key => $value) {
                 $enq = $this->db->get_where('cpnl_enquiry', array('enq_id' => $value['enq_id']))->row_array();

                 if (isset($enq['enq_current_status'])) {

                      if ($enq['enq_current_status'] == 2) { // Drop
                           $exists = $this->db->get_where('cpnl_enquiry_history', array('enh_enq_id' => $value['enq_id'], 'enh_status' => 3))->row_array();
                           if (empty($exists)) {
                                $this->db->insert('cpnl_enquiry_history', array(
                                    'enh_enq_id' => $value['enq_id'],
                                    'enh_status' => 3,
                                    'enh_remarks' => 'Inquery dropped, Verified by team leader',
                                    'enh_added_by' => 1,
                                    'enh_added_on' => date('Y-m-d h:i:s')
                                ));
                                $insertId = $this->db->insert_id();
                                $this->db->where('enq_id', $value['enq_id']);
                                $this->db->update('cpnl_enquiry', array('enq_current_status' => 3, 'enq_current_status_history' => $insertId));
                           }
                      } else if ($enq['enq_current_status'] == 4) { // Delete
                           $exists = $this->db->get_where('cpnl_enquiry_history', array('enh_enq_id' => $value['enq_id'], 'enh_status' => 5))->row_array();
                           if (empty($exists)) {
                                $this->db->insert('cpnl_enquiry_history', array(
                                    'enh_enq_id' => $value['enq_id'],
                                    'enh_status' => 5,
                                    'enh_remarks' => 'Loss of sale or purchase inquery, Verified by team leader',
                                    'enh_added_by' => 1,
                                    'enh_added_on' => date('Y-m-d h:i:s')
                                ));
                                $insertId = $this->db->insert_id();
                                $this->db->where('enq_id', $value['enq_id']);
                                $this->db->update('cpnl_enquiry', array('enq_current_status' => 5, 'enq_current_status_history' => $insertId));
                           }
                      } else if ($enq['enq_current_status'] == 8) { // Drop
                           $exists = $this->db->get_where('cpnl_enquiry_history', array('enh_enq_id' => $value['enq_id'], 'enh_status' => 99))->row_array();
                           if (empty($exists)) {
                                $this->db->insert('cpnl_enquiry_history', array(
                                    'enh_enq_id' => $value['enq_id'],
                                    'enh_status' => 99,
                                    'enh_remarks' => 'Inquery deleted, Verified by team leader',
                                    'enh_added_by' => 1,
                                    'enh_added_on' => date('Y-m-d h:i:s')
                                ));
                                $insertId = $this->db->insert_id();
                                $this->db->where('enq_id', $value['enq_id']);
                                $this->db->update('cpnl_enquiry', array('enq_current_status' => 99, 'enq_current_status_history' => $insertId));
                           }
                      }
                 }
            }
       }

       function alltableclmncount() {
            $this->load->model('help_model', 'help');
            $data['tables'] = $this->help->tables();
            $this->render_page('alltableclmncount', $data);
       }
  }