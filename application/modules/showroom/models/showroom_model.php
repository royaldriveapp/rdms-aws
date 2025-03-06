<?php
if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class showroom_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_divisions = TABLE_PREFIX . 'divisions';
     }

     function get($id = '', $div = array())
     {
          if (!empty($id)) {
               return $this->db->get_where($this->tbl_showroom, array('shr_id' => $id))->row_array();
          }
          if (!empty($div)) {
               $this->db->where('(shr_division = ' . implode($div, ' OR shr_division = ') . ')');
          }
          return $this->db->where('shr_status', 1)->get($this->tbl_showroom)->result_array();
     }

     public function getData($id = '', $div = array())
     {
          if (!empty($div)) {
               $this->db->where('(shr_division = ' . implode($div, ' OR shr_division = ') . ')');
          }
          if (!empty($id)) {
               $this->db->where('shr_id', $id);
               return $this->db->get($this->tbl_showroom)->row_array();
          }
          return $this->db->select($this->tbl_showroom . '.*,' . $this->tbl_divisions . '.*')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'LEFT')
               ->where('shr_status', 1)->get($this->tbl_showroom)->result_array();
     }

     public function addData($datas)
     {
          if ($this->db->insert($this->tbl_showroom, $datas)) {
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

     public function updateData($datas)
     {
          $this->db->where('shr_id', $datas['shr_id']);
          $id = $datas['shr_id'];
          unset($datas['shr_id']);
          if ($this->db->update($this->tbl_showroom, $datas)) {
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

     public function deleteData($id)
     {
          $this->db->where('shr_id', $id);
          if ($this->db->delete($this->tbl_showroom)) {
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
}
