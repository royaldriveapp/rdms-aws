<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class welcomekit_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_welcomekit = TABLE_PREFIX . 'welcome_kit';
       }

       public function read($id = '') {
            if (!empty($id)) {
                 return $this->db->get_where($this->tbl_welcomekit, array('wkt_id' => $id))->row_array();
            }
            return $this->db->order_by('wkt_id', 'DESC')->get($this->tbl_welcomekit)->result_array();
       }

       public function create($datas) {
            $datas['wkt_added_by'] = $this->uid;
            $datas['wkt_added_on'] = date('Y-m-d h:i:s');
            if ($this->db->insert($this->tbl_welcomekit, $datas)) {
                 $id = $this->db->insert_id();
                 generate_log(array(
                     'log_title' => 'New welcome kit added',
                     'log_desc' => 'New welcome kit added',
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
            $id = $datas['wkt_id'];
            unset($datas['wkt_id']);
            $this->db->where('wkt_id', $id);
            if ($this->db->update($this->tbl_welcomekit, $datas)) {
                 generate_log(array(
                     'log_title' => 'welcome kit updated',
                     'log_desc' => 'welcome kit updated',
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
            $this->db->where('wkt_id', $id);
            if ($this->db->delete($this->tbl_welcomekit)) {
                 generate_log(array(
                     'log_title' => 'welcome kit delete',
                     'log_desc' => 'welcome kit deleted',
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
  