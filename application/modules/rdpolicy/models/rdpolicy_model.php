<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class rdpolicy_model extends CI_Model {

     public function __construct() {
          parent::__construct();
          $this->load->database();

          $this->tbl_city = TABLE_PREFIX . 'city';
          $this->tbl_state = TABLE_PREFIX . 'state';
          $this->tbl_place = TABLE_PREFIX . 'place';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_country = TABLE_PREFIX . 'country';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_policies = TABLE_PREFIX . 'policies';
          $this->tbl_followup = TABLE_PREFIX . 'followup';
          $this->tbl_district = TABLE_PREFIX . 'district';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_occupation = TABLE_PREFIX . 'occupation';
          $this->tbl_hr_holidays = TABLE_PREFIX . 'hr_holidays';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
          $this->tbl_travel_modes = TABLE_PREFIX . 'travel_modes';
          $this->tbl_travel_area = TABLE_PREFIX . 'travel_area';
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
          $this->tbl_designation_trvl_eligibl = TABLE_PREFIX . 'designation_trvl_eligibl';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
     }

     function travelPolicy() {
          $data = $this->db->select($this->tbl_users . '.usr_designation_new,' . $this->tbl_designation . '.*')
                          ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
                          ->get_where($this->tbl_users, array('usr_id' => $this->uid))->row_array();
        
          $data['eligibles'] = $this->db->select('dte_travel_area,dte_travel_mod, dte_designation, cpnl_travel_area.tra_title')
                          ->join('cpnl_travel_area', 'cpnl_travel_area.tra_id = ' . $this->tbl_designation_trvl_eligibl . '.dte_travel_area', 'LEFT')
                          ->group_by('dte_travel_area, dte_designation')->having(array('dte_designation' => $data['usr_designation_new']))
                          ->get($this->tbl_designation_trvl_eligibl)->result_array();

          foreach ($data['eligibles'] as $key => $value) {
               $data['eligibles'][$key]['modes'] = @$this->db->select('GROUP_CONCAT(' . $this->tbl_travel_modes . ".dtm_title SEPARATOR ', ') AS te", false)
                               ->join($this->tbl_travel_modes, $this->tbl_travel_modes . '.dtm_id = ' . $this->tbl_designation_trvl_eligibl . '.dte_travel_mod', 'LEFT')
                               ->get_where($this->tbl_designation_trvl_eligibl, array('dte_travel_area' => $value['dte_travel_area'], 
                               'dte_designation' => $data['usr_designation_new']))->row()->te;
          }
          return $data;
     }

     function getHolidays() {
          return $this->db->order_by('hrh_date_from')->get($this->tbl_hr_holidays)->result_array();
     }

     function getPolicies($all = 1) {
          if($all != 1) {
               $this->db->where('pol_status', 1);
          }
          return $this->db->get($this->tbl_policies)->result_array();
     }
     
     function getPoliciesById($id) {
          return $this->db->where('pol_id', $id)->get($this->tbl_policies)->row_array();
     }
     
     function createPolicy($data) {
          $data['pol_added_by'] = $this->uid;
          $data['pol_added_on'] = date('Y-m-d H:i:s');
          $this->db->insert($this->tbl_policies, $data);
     }
     
     function updatePolicy($data) {
          $id = $data['pol_id'];
          unset($data['pol_id']);
          $this->db->where('pol_id', $id)->update($this->tbl_policies, $data);
          return;
     }
     
     function deleteData($id) {
          $this->db->where('pol_id', $id)->delete($this->tbl_policies);
          return true;
     }
}