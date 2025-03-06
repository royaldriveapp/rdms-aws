<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class events_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_events = TABLE_PREFIX . 'events';
       }

       public function read($id = '') {
            if (!empty($id)) {
                 return $this->db->get_where($this->tbl_events, array('evnt_id' => $id))->row_array();
            }
            return $this->db->order_by('evnt_date', 'DESC')->get($this->tbl_events)->result_array();
       }

       public function create($datas) {
            $datas['evnt_added_by'] = $this->uid;
            $datas['evnt_date'] = date('Y-m-d', strtotime($datas['evnt_date']));
            if ($this->db->insert($this->tbl_events, $datas)) {
                 $id = $this->db->insert_id();
                 generate_log(array(
                     'log_title' => 'New event',
                     'log_desc' => 'New event created',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'C',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

       public function update($datas) {
            $id = $datas['evnt_id'];
            unset($datas['evnt_id']);
            $this->db->where('evnt_id', $id);
            $datas['evnt_date'] = date('Y-m-d', strtotime($datas['evnt_date']));
            if ($this->db->update($this->tbl_events, $datas)) {
                 generate_log(array(
                     'log_title' => 'Event updated',
                     'log_desc' => 'Event updated',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

       public function delete($id) {
            $this->db->where('evnt_id', $id);
            if ($this->db->delete($this->tbl_events)) {
                 generate_log(array(
                     'log_title' => 'Event delete',
                     'log_desc' => 'Event deleted',
                     'log_controller' => strtolower(__CLASS__),
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
  