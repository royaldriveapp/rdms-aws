<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class designation_model extends CI_Model {

     public function __construct() {
          parent::__construct();
          $this->load->database();
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
          $this->tbl_travel_modes = TABLE_PREFIX . 'travel_modes';
          $this->tbl_designation_trvl_eligibl = TABLE_PREFIX . 'designation_trvl_eligibl';
     }

     function getTravelModes() {
          return $this->db->get($this->tbl_travel_modes)->result_array();
     }

     public function getDataOld($desig_id = '') {

          if (!empty($desig_id)) {
               $this->db->where('id', $desig_id);
               return $this->db->get($this->tbl_groups)->row_array();
          }
          return $this->db->get($this->tbl_groups)->result_array();
     }
     
     public function getData($desig_id = '') {

          if (!empty($desig_id)) {
               $this->db->where('desig_id', $desig_id);
               $return =  $this->db->get($this->tbl_designation)->row_array();
               $return['travelEligibi'] = $this->db->select('dte_travel_area, GROUP_CONCAT(cpnl_designation_trvl_eligibl.dte_travel_mod) AS dte_designation')
                    ->where(array('dte_designation' => $desig_id))
                    ->group_by('dte_travel_area')->get($this->tbl_designation_trvl_eligibl)->result_array();
               return $return;
          }
          return $this->db->select($this->tbl_designation . '.*')->order_by('desig_title')->get($this->tbl_designation)->result_array();
     }

     function getDesignationTravelDetails($degig) {
          $data = $this->db->select('dte_travel_area,dte_travel_mod, dte_designation, cpnl_travel_area.tra_title')
                          ->join('cpnl_travel_area', 'cpnl_travel_area.tra_id = ' . $this->tbl_designation_trvl_eligibl . '.dte_travel_area', 'LEFT')
                          ->group_by('dte_travel_area, dte_designation')->having(array('dte_designation' => $degig))
                          ->get($this->tbl_designation_trvl_eligibl)->result_array();
          
          foreach ($data as $key => $value) {
               $data[$key]['modes'] = @$this->db->select('GROUP_CONCAT(' . $this->tbl_travel_modes . ".dtm_title SEPARATOR ', ') AS te", false)
                               ->join($this->tbl_travel_modes, $this->tbl_travel_modes . '.dtm_id = ' . $this->tbl_designation_trvl_eligibl . '.dte_travel_mod', 'LEFT')
                               ->get_where($this->tbl_designation_trvl_eligibl, array('dte_travel_area' => $value['dte_travel_area'], 
                               'dte_designation' => $degig))->row()->te;
          }
          return $data;
     }

     public function addData($datas) {
          $travel = array();
          if (isset($datas['trvelig']) && !empty($datas['trvelig'])) {
               $travel = $datas['trvelig'];
               unset($datas['trvelig']);
          }

          if ($this->db->insert($this->tbl_designation, array_filter($datas))) {
               $desig_id = $this->db->insert_id();
               if (!empty($travel)) {
                    foreach ($travel as $akey => $avalue) {
                         foreach ($avalue as $key => $value) {
                              if (!empty($value)) {
                                   $insArray['dte_designation'] = $desig_id;
                                   $insArray['dte_travel_area'] = $akey;
                                   $insArray['dte_travel_mod'] = $value;
                                   $this->db->insert($this->tbl_designation_trvl_eligibl, $insArray);
                              }
                         }
                    }
               }

               generate_log(array(
                   'log_title' => 'New records',
                   'log_desc' => serialize($datas),
                   'log_controller' => 'new-designation',
                   'log_action' => 'C',
                   'log_ref_id' => $desig_id,
                   'log_added_by' => $this->uid
               ));
               return true;
          } else {
               return false;
          }
     }

     public function updateData($datas) {
          
          $travel = array();
          if (isset($datas['trvelig']) && !empty($datas['trvelig'])) {
               $travel = $datas['trvelig'];
               unset($datas['trvelig']);
          }

          $this->db->where('desig_id', $datas['desig_id']);
          $desig_id = $datas['desig_id'];
          unset($datas['desig_id']);
          
          if ($this->db->update($this->tbl_designation, array_filter($datas))) {
               $this->db->delete($this->tbl_designation_trvl_eligibl, array('dte_designation' => $desig_id));
               if (!empty($travel)) {
                    foreach ($travel as $akey => $avalue) {
                         foreach ($avalue as $key => $value) {
                              if (!empty($value)) {
                                   $insArray['dte_designation'] = $desig_id;
                                   $insArray['dte_travel_area'] = $akey;
                                   $insArray['dte_travel_mod'] = $value;
                                   $this->db->insert($this->tbl_designation_trvl_eligibl, $insArray);
                              }
                         }
                    }
               }
               generate_log(array(
                   'log_title' => 'update records',
                   'log_desc' => serialize($datas),
                   'log_controller' => 'update-designation',
                   'log_action' => 'U',
                   'log_ref_id' => $desig_id,
                   'log_added_by' => $this->uid
               ));
               return true;
          } else {
               generate_log(array(
                   'log_title' => 'update records failed',
                   'log_desc' => 'Updated designation failed',
                   'log_controller' => 'update-designation-error',
                   'log_action' => 'U',
                   'log_ref_id' => $desig_id,
                   'log_added_by' => $this->uid
               ));
               return false;
          }
     }

     public function deleteData($desig_id) {
          $this->db->where('desig_id', $desig_id);
          if ($this->db->delete($this->tbl_designation)) {
               generate_log(array(
                   'log_title' => 'Delete records',
                   'log_desc' => 'Delete designation',
                   'log_controller' => 'delete-designation',
                   'log_action' => 'D',
                   'log_ref_desig_id' => $desig_id,
                   'log_added_by' => $this->uid
               ));
               return true;
          } else {
               return false;
          }
     }

}
