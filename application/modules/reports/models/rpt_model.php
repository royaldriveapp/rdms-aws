<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class reports_model extends CI_Model
{
     public function __construct()
     {

          parent::__construct();
          $this->load->database();

          $this->tbl_city = TABLE_PREFIX . 'city';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_events = TABLE_PREFIX . 'events';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_statuses = TABLE_PREFIX . 'statuses';
          $this->tbl_followup = TABLE_PREFIX . 'followup';
          $this->tbl_divisions = TABLE_PREFIX . 'divisions';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_occupation = TABLE_PREFIX . 'occupation';
          $this->tbl_dar_master = TABLE_PREFIX . 'dar_master';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
          $this->tbl_general_log = TABLE_PREFIX . 'general_log';
          $this->tbl_dar_enquiry = TABLE_PREFIX . 'dar_enquiry';
          $this->tbl_departments = TABLE_PREFIX . 'departments';
          $this->tbl_home_visits = TABLE_PREFIX . 'home_visits';
          $this->tbl_enquiry_pool = TABLE_PREFIX . 'enquiry_pool';
          $this->tbl_enquiry_meta = TABLE_PREFIX . 'enquiry_meta';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_dar_followup = TABLE_PREFIX . 'dar_followup';
          $this->tbl_travel_modes = TABLE_PREFIX . 'travel_modes';
          $this->tbl_contact_mode = TABLE_PREFIX . 'contact_mode';
          $this->tbl_vehicle_status = TABLE_PREFIX . 'vehicle_status';
          $this->tbl_quick_tc_report = TABLE_PREFIX . 'quick_tc_report';
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
          $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
          $this->tbl_valuation_status = TABLE_PREFIX . 'valuation_status';
          $this->tbl_callcenterbridging = TABLE_PREFIX . 'callcenterbridging';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->view_valuation_master = TABLE_PREFIX . 'view_valuation_master';
          $this->view_all_vehicle_status = TABLE_PREFIX . 'view_all_vehicle_status';
          $this->tbl_quick_tc_report_master = TABLE_PREFIX . 'quick_tc_report_master';
          $this->tbl_vehicle_booking_master = TABLE_PREFIX . 'vehicle_booking_master';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
          $this->view_enquiry_vehicle_master = TABLE_PREFIX . 'view_enquiry_vehicle_master';
          $this->view_followup_current_status = TABLE_PREFIX . 'view_followup_current_status';
     }

     function getDistricts()
     {
          return $this->db->get($this->tbl_district_statewise)->result_array();
     }
     function quickVehicleSearch($data, $limit = 0, $page = 0)
     {
          $mystaffs = array();
          if ($this->usr_grp == 'TL') {
               if (check_permission('reports', 'show_res_inact_staff_also')) {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                    array_push($mystaffs, $this->uid);
               } else {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                         ->where(array('usr_tl' => $this->uid, 'usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->row()->usr_id);
                    array_push($mystaffs, $this->uid);
               }
          }
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          if (isset($data['veh_category']) && !empty($data['veh_category'])) {
               // $this->db->where_in($this->view_vehicle_vehicle_status . '.brd_category', $data['veh_category']); //w
               $this->db->where_in($this->tbl_brand . '.brd_category', $data['veh_category']); //w
          }
          if (isset($data['enq_sts']) && !empty($data['enq_sts'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', $data['enq_sts']);
          }
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }
          if (isset($data['vehicle']['sale']['veh_brand'])) {
               $br = array_filter($data['vehicle']['sale']['veh_brand']);
               if (!empty($br)) {
                    // $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_brand', $br);//w
                    $this->db->where_in($this->tbl_vehicle . '.veh_brand', $br); //w
               }
          }
          if (isset($data['vehicle']['sale']['veh_model'])) {
               $md = array_filter($data['vehicle']['sale']['veh_model']);
               if (!empty($md)) {
                    //$this->db->where_in($this->view_vehicle_vehicle_status . '.veh_model', $md); //w
                    $this->db->where_in($this->tbl_vehicle . '.veh_model', $md);
               }
          }
          if (isset($data['vehicle']['sale']['veh_varient'])) {
               $vr = array_filter($data['vehicle']['sale']['veh_varient']);
               if (!empty($vr)) {
                    // $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_varient', $vr);//w
                    $this->db->where_in($this->tbl_vehicle . '.veh_varient', $vr);
               }
          }
          if (!check_permission('reports', 'showallbranches')) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }
          //   $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT');
          //   $this->db->where('(' . $this->view_vehicle_vehicle_status . ".vst_all_statuses LIKE '%{1}' OR " . $this->view_vehicle_vehicle_status . ".vst_all_statuses IS NULL)");
          //            $this->db->where($this->tbl_enquiry . '.enq_id > 0');
          if (!check_permission('reports', 'showallbranches')) {
               if ($this->usr_grp == 'SE') { // Seles executives
                    $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
               } else if ($this->usr_grp == 'TL') {
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               }
          }
          if (isset($data['type']) && !empty($data['type'])) { // Sales or purchase
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }
          //  $return['count'] = $this->db->count_all_results($this->tbl_vehicle);//count jsk
          $return['count'] = $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_vehicle . '.veh_brand = ' . $this->tbl_brand . '.brd_id', 'LEFT')
               ->join($this->tbl_model, $this->tbl_vehicle . '.veh_model = ' . $this->tbl_model . '.mod_id', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_vehicle . '.veh_varient = ' . $this->tbl_variant . '.var_id', 'LEFT')
               ->count_all_results($this->tbl_vehicle);
          // debug($return['count']);

          /* Data */
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          if (isset($data['veh_category']) && !empty($data['veh_category'])) {
               // $this->db->where_in($this->view_vehicle_vehicle_status . '.brd_category', $data['veh_category']);
               $this->db->where_in($this->tbl_brand . '.brd_category', $data['veh_category']); //w
          }
          if (isset($data['enq_sts']) && !empty($data['enq_sts'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', $data['enq_sts']);
          }
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }
          if (isset($data['vehicle']['sale']['veh_brand'])) {
               $br = array_filter($data['vehicle']['sale']['veh_brand']);
               if (!empty($br)) {
                    // $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_brand', $br);//w
                    $this->db->where_in($this->tbl_vehicle . '.veh_brand', $br);
               }
          }

          if (isset($data['vehicle']['sale']['veh_model'])) {
               $md = array_filter($data['vehicle']['sale']['veh_model']);
               if (!empty($md)) {
                    // $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_model', $md);//w
                    $this->db->where_in($this->tbl_vehicle . '.veh_model', $md);
               }
          }

          if (isset($data['vehicle']['sale']['veh_varient'])) {
               $vr = array_filter($data['vehicle']['sale']['veh_varient']);
               if (!empty($vr)) {
                    // $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_varient', $vr);//w
                    $this->db->where_in($this->tbl_vehicle . '.veh_varient', $vr);
               }
          }

          //$this->db->where('(' . $this->view_vehicle_vehicle_status . ".vst_all_statuses LIKE '%{1}' OR " . $this->view_vehicle_vehicle_status . ".vst_all_statuses IS NULL)");
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          if (!check_permission('reports', 'showallbranches')) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          }
          $selectArray = array(
               $this->tbl_vehicle . '.veh_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_vehicle . '.veh_status',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_phone',
          );
          if (!check_permission('reports', 'showallbranches')) {
               if ($this->usr_grp == 'SE') { // Seles executives
                    $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
               } else if ($this->usr_grp == 'TL') {
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               }
          }

          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }
          //            $this->db->where($this->tbl_enquiry . '.enq_id > 0');
          if (isset($data['type']) && !empty($data['type'])) { // Sales or purchase
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          } //LEFT JOIN `rana_brand` ON((`rana_brand`.`brd_id` = `cpnl_vehicle`.`veh_brand`))) 
          $return['data'] = $this->db->select($selectArray)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_vehicle . '.veh_brand = ' . $this->tbl_brand . '.brd_id', 'LEFT')
               ->join($this->tbl_model, $this->tbl_vehicle . '.veh_model = ' . $this->tbl_model . '.mod_id', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_vehicle . '.veh_varient = ' . $this->tbl_variant . '.var_id', 'LEFT')
               ->get($this->tbl_vehicle)->result_array();
          //echo $this->db->last_query();
          //exit;
          //debug($return['data']);
          return $return;
     }

     function quickVehicleSearch_temp($data, $limit = 0, $page = 0)
     {
          $mystaffs = my_staff($this->uid);
          /* Data */
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          if (isset($data['veh_category']) && !empty($data['veh_category'])) {
               // $this->db->where_in($this->view_vehicle_vehicle_status . '.brd_category', $data['veh_category']);
               $this->db->where_in($this->tbl_brand . '.brd_category', $data['veh_category']); //w
          }
          if (isset($data['enq_sts']) && !empty($data['enq_sts'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', $data['enq_sts']);
          }
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }
          if (isset($data['vehicle']['sale']['veh_brand'])) {
               $br = array_filter($data['vehicle']['sale']['veh_brand']);
               if (!empty($br)) {
                    // $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_brand', $br);//w
                    $this->db->where_in($this->tbl_vehicle . '.veh_brand', $br);
               }
          }

          if (isset($data['vehicle']['sale']['veh_model'])) {
               $md = array_filter($data['vehicle']['sale']['veh_model']);
               if (!empty($md)) {
                    // $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_model', $md);//w
                    $this->db->where_in($this->tbl_vehicle . '.veh_model', $md);
               }
          }

          if (isset($data['vehicle']['sale']['veh_varient'])) {
               $vr = array_filter($data['vehicle']['sale']['veh_varient']);
               if (!empty($vr)) {
                    // $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_varient', $vr);//w
                    $this->db->where_in($this->tbl_vehicle . '.veh_varient', $vr);
               }
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          if (!check_permission('reports', 'showallbranches')) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          }
          $selectArray = array(
               $this->tbl_vehicle . '.veh_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_vehicle . '.veh_status',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_phone',
          );
          if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL') {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }
          if (isset($data['type']) && !empty($data['type'])) { // Sales or purchase
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }
          $return['data'] = $this->db->select($selectArray)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_vehicle . '.veh_brand = ' . $this->tbl_brand . '.brd_id', 'LEFT')
               ->join($this->tbl_model, $this->tbl_vehicle . '.veh_model = ' . $this->tbl_model . '.mod_id', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_vehicle . '.veh_varient = ' . $this->tbl_variant . '.var_id', 'LEFT')
               ->get($this->tbl_vehicle)->result_array();
          //echo $this->db->last_query();
          //debug($return['data']); 
          return $return;
     }

     function quickVehicleSearchNolimit($limit = 0, $page = 0, $data)
     {
          /* Data */
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }
          if (isset($data['vehicle']['sale']['veh_brand'])) {
               $br = array_filter($data['vehicle']['sale']['veh_brand']);
               if (!empty($br)) {
                    // $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_brand', $br);
                    $this->db->where_in($this->tbl_vehicle . '.veh_brand', $br);
               }
          }

          if (isset($data['vehicle']['sale']['veh_model'])) {
               $md = array_filter($data['vehicle']['sale']['veh_model']);
               if (!empty($md)) {
                    //$this->db->where_in($this->view_vehicle_vehicle_status . '.veh_model', $md);
                    $this->db->where_in($this->tbl_vehicle . '.veh_model', $md);
               }
          }

          if (isset($data['vehicle']['sale']['veh_varient'])) {
               $vr = array_filter($data['vehicle']['sale']['veh_varient']);
               if (!empty($vr)) {
                    //  $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_varient', $vr);
                    $this->db->where_in($this->tbl_vehicle . '.veh_varient', $vr);
               }
          }

          //$this->db->where('(' . $this->view_vehicle_vehicle_status . ".vst_all_statuses LIKE '%{1}' OR " . $this->view_vehicle_vehicle_status . ".vst_all_statuses IS NULL)");
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          if (!can_access_module('reports', 'showallbranches')) {
               $this->db->where($this->tbl_showroom . '.shr_id', $this->shrm);
          }
          $selectArray = array(
               $this->tbl_vehicle . '.veh_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_vehicle . '.veh_status',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_phone',
          );
          if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }
          //            $this->db->where($this->tbl_enquiry . '.enq_id > 0');
          if (isset($data['type']) && !empty($data['type'])) { // Sales or purchase
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }
          return $this->db->select($selectArray)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_vehicle . '.veh_brand = ' . $this->tbl_brand . '.brd_id', 'LEFT')
               ->join($this->tbl_model, $this->tbl_vehicle . '.veh_model = ' . $this->tbl_model . '.mod_id', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_vehicle . '.veh_varient = ' . $this->tbl_variant . '.var_id', 'LEFT')
               ->get($this->tbl_vehicle)->result_array();
     }

     function quickVehicleSearchNolimit1($limit = 0, $page = 0, $data)
     {

          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['vehicle']['sale']['veh_brand'])) {
               $br = array_filter($data['vehicle']['sale']['veh_brand']);
               if (!empty($br)) {
                    $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_brand', $br);
               }
          }

          if (isset($data['vehicle']['sale']['veh_model'])) {
               $md = array_filter($data['vehicle']['sale']['veh_model']);
               if (!empty($md)) {
                    $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_model', $md);
               }
          }

          if (isset($data['vehicle']['sale']['veh_varient'])) {
               $vr = array_filter($data['vehicle']['sale']['veh_varient']);
               if (!empty($vr)) {
                    $this->db->where_in($this->view_vehicle_vehicle_status . '.veh_varient', $vr);
               }
          }

          //$this->db->where('(' . $this->view_vehicle_vehicle_status . ".vst_all_statuses LIKE '%{1}' OR " . $this->view_vehicle_vehicle_status . ".vst_all_statuses IS NULL)");
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

          /*if ($limit || $page) {
                 $this->db->limit($limit, $page);
            }*/
          if (!can_access_module('reports', 'showallbranches')) {
               $this->db->where($this->tbl_showroom . '.shr_id', $this->shrm);
          }
          $selectArray = array(
               $this->view_vehicle_vehicle_status . '.veh_id',
               $this->view_vehicle_vehicle_status . '.brd_title',
               $this->view_vehicle_vehicle_status . '.mod_title',
               $this->view_vehicle_vehicle_status . '.var_variant_name',
               $this->view_vehicle_vehicle_status . '.veh_status',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_phone',
          );
          if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }
          $this->db->where($this->tbl_enquiry . '.enq_id > 0');
          if (isset($data['isMissedFollowup']) && $data['isMissedFollowup'] == 1) {
               $this->db->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)');
          }
          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          return $this->db->select($selectArray)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->view_vehicle_vehicle_status . '.veh_enq_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->get($this->view_vehicle_vehicle_status)->result_array();
     }

     function duplicateEntry()
     {

          $return = $this->db->select($this->view_enquiry_vehicle_master . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*')
               ->join('(SELECT * FROM ' . $this->view_enquiry_vehicle_master . ' GROUP BY enq_cus_valid_mobile HAVING COUNT(enq_cus_valid_mobile) >1) tmp_mob ', ' tmp_mob.enq_cus_valid_mobile = ' . $this->view_enquiry_vehicle_master . '.enq_cus_valid_mobile', 'INNER')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->view_enquiry_vehicle_master . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->view_enquiry_vehicle_master . '.enq_showroom_id', 'LEFT')
               ->order_by($this->view_enquiry_vehicle_master . '.enq_cus_valid_mobile', 'DESC')
               ->get($this->view_enquiry_vehicle_master)->result_array();
          return $return;
          //   debug($return);
     }

     function searchEnquiryByDateShowroomSeBack($limit = 0, $page = 0, $data)
     {
          $mystaffs = array();
          if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id);
          }

          $showroom = get_logged_user('usr_showroom');
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }

          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) { // Team leed
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }

          $return['count'] = $this->db->count_all_results($this->tbl_enquiry);

          /* Data */
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }

          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }

          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) { // Team leed
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }

          $this->db->join('(SELECT foll_id, foll_status, foll_cus_id, foll_cus_vehicle_id 
                              FROM ' . $this->tbl_followup . ' WHERE foll_is_cmnt = 0 AND foll_id IN (select MAX(foll_id) AS foll_id FROM ' .
               $this->tbl_followup . ' GROUP BY foll_cus_id)
                         ) followup_current_status', 'followup_current_status.foll_cus_id = ' . $this->tbl_enquiry . '.enq_id', 'INNER');

          $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' .
               'followup_current_status.*,' . $this->tbl_vehicle . '.*,' .
               $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.*,' . $this->tbl_variant . '.*')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               //->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . 'followup_current_status.foll_cus_vehicle_id', 'LEFT')
               //->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               //->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               //->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')

               ->join($this->tbl_enquiry_meta, $this->tbl_enquiry_meta . '.enqm_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')

               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
               ->get($this->tbl_enquiry)->result_array();
          // if($this->uid == 48) {
          //      echo $this->db->last_query();
          //      debug($return);
          // }
          return $return;
     }

     function getInnactiveVehicles($status, $limit = 0, $page = 0, $filter = array(), $noLimit = true)
     {
          $mystaffs = array();
          if (check_permission('reports', 'show_res_inact_staff_also')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $this->uid);
          } else {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where(array('usr_tl' => $this->uid, 'usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $this->uid);
          }
          $searchValue = isset($filter['searchValue']) ? $filter['searchValue'] : '';
          array_push($mystaffs, $this->uid);

          if ($this->uid != 100) {
               if (check_permission('enquiry', 'showdroppedenquiriesmyteam')) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               } else if (check_permission('enquiry', 'showdroppedenquiriesmyshowroom')) {
                    $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
               } else if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL' || $this->usr_grp == 'DE') {
                    $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
               }
          }
          if (isset($filter['mode']) && !empty($filter['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $filter['mode']);
          }

          if (isset($filter['enq_cus_dist']) && !empty($filter['enq_cus_dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $filter['enq_cus_dist']);
          }

          if (isset($filter['executive']) && !empty($filter['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $filter['executive']);
          }
          if (isset($filter['enh_added_on_from']) && !empty($filter['enh_added_on_from'])) {
               $date = date('Y-m-d', strtotime($filter['enh_added_on_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $date);
               $this->db->order_by($this->tbl_enquiry_history . '.enh_added_on');
          }
          if (isset($filter['enh_added_on_to']) && !empty($filter['enh_added_on_to'])) {
               $date = date('Y-m-d', strtotime($filter['enh_added_on_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $date);
               $this->db->order_by($this->tbl_enquiry_history . '.enh_added_on');
          }
          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $searchValue . "%') ");
          }

          $return['count'] = $this->db->where($this->tbl_enquiry . '.enq_current_status', $status)
               ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' .
                    $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
               ->count_all_results($this->tbl_enquiry);

          //Data
          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $searchValue . "%') ");
          }
          if (isset($filter['mode']) && !empty($filter['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $filter['mode']);
          }
          if (isset($filter['enh_added_on_from']) && !empty($filter['enh_added_on_from'])) {
               $date = date('Y-m-d', strtotime($filter['enh_added_on_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $date);
               $this->db->order_by($this->tbl_enquiry_history . '.enh_added_on');
          }
          if (isset($filter['enh_added_on_to']) && !empty($filter['enh_added_on_to'])) {
               $date = date('Y-m-d', strtotime($filter['enh_added_on_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $date);
               $this->db->order_by($this->tbl_enquiry_history . '.enh_added_on');
          }

          if (empty($filter['enh_added_on_from']) && empty($filter['enh_added_on_to'])) {
               $this->db->order_by($this->tbl_enquiry_history . '.enh_added_on', 'DESC');
          }
          if (isset($filter['enq_cus_dist']) && !empty($filter['enq_cus_dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $filter['enq_cus_dist']);
          }

          if ($this->uid != 100) {
               if (check_permission('enquiry', 'showdroppedenquiriesmyteam')) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               } else if (check_permission('enquiry', 'showdroppedenquiriesmyshowroom')) {
                    $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
               } else if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL' || $this->usr_grp == 'DE') {
                    $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
               }
          }
          if (isset($filter['executive']) && !empty($filter['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $filter['executive']);
          }
          if ($limit && $noLimit) {
               $this->db->limit($limit, $page);
          }
          $selectArray = array(
               $this->tbl_enquiry . '.enq_number',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_last_foll_cust_rmk',
               $this->tbl_users . '.usr_first_name',
               'tbl_added_by.usr_username AS enq_added_by_name',
               $this->tbl_showroom . '.*',
               $this->tbl_enquiry_history . '.*',
               $this->tbl_district_statewise . '.std_district_name'
          );
          $return['data'] = $this->db->select($selectArray)
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'LEFT')
               ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'LEFT')
               ->where($this->tbl_enquiry . '.enq_current_status', $status)->get($this->tbl_enquiry)->result_array();
          // echo $this->db->last_query();
          // debug($return['data']);
          return $return;
     }

     function teleCallersSalesStaffs()
     {
          $assign[] = $this->tbl_groups . ".grp_slug = 'TC'";
          $assign[] = $this->tbl_groups . ".grp_slug = 'SE'";
          $assign[] = $this->tbl_designation . ".desig_slug = 'TPC'";
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'left')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->where('(' . implode(' OR ', $assign) . ')')
               ->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->result_array();
     }

     function getVehicleStatusHistory($vehId = '')
     {

          if (!empty($vehId)) {
               $return = $this->db->select($this->view_enquiry_vehicle_master . '.*,' .
                    $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' . $this->tbl_showroom . '.*')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->view_enquiry_vehicle_master . '.veh_showroom_id', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->view_enquiry_vehicle_master . '.veh_enq_id', 'LEFT')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->view_enquiry_vehicle_master . '.enq_se_id', 'LEFT')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->view_enquiry_vehicle_master . '.enq_added_by', 'LEFT')
                    ->where($this->view_enquiry_vehicle_master . '.veh_id', $vehId)
                    ->get($this->view_enquiry_vehicle_master)->row_array();

               if (!empty($return)) {
                    $return['statuses'] = $this->db->select($this->tbl_vehicle_status . '.*,' . $this->tbl_statuses . '.*')
                         ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_status . '.vst_status', 'LEFT')
                         ->order_by('vst_id', 'DESC')->where('vst_vehicle_id', $return['veh_id'])->get($this->tbl_vehicle_status)->result_array();

                    $return['currentStatus'] = $this->db->select($this->tbl_vehicle_status . '.*,' . $this->tbl_statuses . '.*')
                         ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_status . '.vst_status', 'LEFT')
                         ->order_by('vst_id', 'DESC')->where('vst_vehicle_id', $return['veh_id'])->get($this->tbl_vehicle_status)->row_array();

                    $return['soledVehicle'] = $result['soldVehicle'] = $this->db->select($this->tbl_valuation_status . '.*,' . $this->tbl_statuses . '.*,' .
                         $this->view_valuation_master . '.*')
                         ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_valuation_status . '.est_status', 'LEFT')
                         ->join($this->view_valuation_master, $this->view_valuation_master . '.val_id = ' . $this->tbl_valuation_status . '.est_valuation_id', 'LEFT')
                         ->get_where($this->tbl_valuation_status, array('est_enq_veh_id' => $return['veh_id'], 'est_status' => 11))->row_array();
               }

               return $return;
          }
     }

     function darEnquires($datas)
     {

          if (isset($datas['enq_date_from']) && !empty($datas['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($datas['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_dar_master . '.darm_added_on) >=', $date);
               $this->db->order_by($this->tbl_dar_master . '.darm_added_on');
          }
          if (isset($datas['enq_date_to']) && !empty($datas['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($datas['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_dar_master . '.darm_added_on) <=', $date);
          }
          if (!empty($datas['executive'])) {
               $this->db->where_in($this->tbl_dar_master . '.darm_added_by', $datas['executive']);
          }

          $selArr = array(
               $this->tbl_dar_enquiry . '.*,' . $this->tbl_dar_master . '.*, addedby.usr_username AS ab_usr_username, verifiedbytl.usr_username AS vb_usr_username,' .
                    $this->tbl_showroom . '.*, verifiedbymg.usr_username AS vb_usr_username_mg,' . $this->tbl_designation . '.desig_title',
               $this->tbl_enquiry . '.enq_id', $this->tbl_enquiry . '.enq_se_id', $this->tbl_enquiry . '.enq_cus_name', $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_mode_enq', $this->tbl_enquiry . '.enq_cus_status', $this->tbl_enquiry . '.enq_entry_date', $this->tbl_enquiry . '.enq_next_foll_date',
               $this->tbl_statuses . '.sts_title'
          );

          $this->db->select($selArr, false)
               ->join($this->tbl_dar_master, $this->tbl_dar_enquiry . '.dare_master = ' . $this->tbl_dar_master . '.darm_id', 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_dar_enquiry . '.dare_enq', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_dar_master . '.darm_added_by', 'LEFT')
               ->join($this->tbl_users . ' verifiedbytl', 'verifiedbytl.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_team_lead', 'LEFT')
               ->join($this->tbl_users . ' verifiedbymg', 'verifiedbymg.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_manager', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_dar_master . '.darm_showroom', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = addedby.usr_designation_new', 'LEFT')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_enquiry . '.enq_current_status', 'LEFT');
          $this->db->order_by($this->tbl_dar_master . '.darm_added_on', 'DESC');
          return $this->db->get($this->tbl_dar_enquiry)->result_array();
     }

     function dar($datas)
     {

          $dataFrom = (isset($datas['darm_added_on_fr']) && !empty($datas['darm_added_on_fr'])) ?
               date('Y-m-d', strtotime($datas['darm_added_on_fr'])) : date('Y-m-d');
          $dataTo = (isset($datas['darm_added_on_to']) && !empty($datas['darm_added_on_to'])) ?
               date('Y-m-d', strtotime($datas['darm_added_on_to'])) : date('Y-m-d');

          if (!empty($dataFrom) || !empty($dataTo)) {

               $return = array();
               while (strtotime($dataFrom) <= strtotime($dataTo)) {

                    if (check_permission('reports', 'dar_mystaff')) {
                         if (isset($datas['executive']) && !empty($datas['executive'])) {
                              $this->db->where_in($this->tbl_users . '.usr_id', $datas['executive']);
                         } else {
                              $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                                   ->get($this->tbl_users)->row()->usr_id);
                              $this->db->where_in($this->tbl_users . '.usr_id', $mystaffs);
                         }
                         if (isset($datas['showroom']) && !empty($datas['showroom'])) {
                              $this->db->where($this->tbl_showroom . '.shr_id', $datas['showroom']);
                         }
                         $staffs = $this->db->select($this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_designation . '.desig_title')
                              ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                              ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                              ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
                              ->where($this->tbl_users . '.usr_resigned', 0)
                              ->where(array($this->tbl_users . '.usr_tl' => $this->uid, 'usr_active' => 1))->get($this->tbl_users)->result_array();
                         //->where_in($this->tbl_users_groups . '.group_id', array(4, 7, 8, 9))
                         foreach ((array) $staffs as $key => $value) {

                              //                                $this->db->where('DATE(' . $this->tbl_dar_master . '.darm_added_on) = ' . $dataFrom);
                              $this->db->where('DATE(' . $this->tbl_dar_master . ".darm_added_on) = DATE('" . $dataFrom . "')");
                              $this->db->where('addedby.usr_resigned', 0);
                              $this->db->where($this->tbl_dar_master . '.darm_added_by = ' . $value['usr_id']);
                              $this->db->select($this->tbl_dar_master . '.*, addedby.usr_username AS ab_usr_username, verifiedbytl.usr_username AS vb_usr_username,' .
                                   $this->tbl_showroom . '.*, verifiedbymg.usr_username AS vb_usr_username_mg,' . $this->tbl_designation . '.desig_title')
                                   ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_dar_master . '.darm_added_by', 'LEFT')
                                   ->join($this->tbl_users . ' verifiedbytl', 'verifiedbytl.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_team_lead', 'LEFT')
                                   ->join($this->tbl_users . ' verifiedbymg', 'verifiedbymg.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_manager', 'LEFT')
                                   ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_dar_master . '.darm_showroom', 'LEFT')
                                   ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = addedby.usr_designation_new', 'LEFT');
                              $this->db->order_by($this->tbl_dar_master . '.darm_added_on', 'DESC');
                              $value['darMaster'] = $this->db->get($this->tbl_dar_master)->result_array();

                              $return[$dataFrom][$key] = $value;
                         }
                    } else {

                         if (check_permission('reports', 'dar_myshowroom')) {
                              $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
                         }
                         if (isset($datas['executive']) && !empty($datas['executive'])) {
                              $this->db->where_in($this->tbl_users . '.usr_id', $datas['executive']);
                         }
                         if (isset($datas['showroom']) && !empty($datas['showroom'])) {
                              $this->db->where($this->tbl_showroom . '.shr_id', $datas['showroom']);
                         }
                         if (check_permission('reports', 'dar_salesdept') && check_permission('reports', 'dar_purdept')) {
                              $staffs = $this->db->select($this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_designation . '.desig_title')
                                   ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                                   ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
                                   ->where($this->tbl_users . '.usr_resigned', 0)->where('usr_active', 1)
                                   ->where_in($this->tbl_users . '.usr_departments', array(4, 6, 7, 8))->get($this->tbl_users)->result_array();
                         } else if (check_permission('reports', 'dar_salesdept')) {
                              $staffs = $this->db->select($this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_designation . '.desig_title')
                                   ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                                   ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
                                   ->where($this->tbl_users . '.usr_resigned', 0)
                                   ->where('usr_active', 1)->where_in($this->tbl_users . '.usr_departments', array(4, 6))->get($this->tbl_users)->result_array();
                         } else if (check_permission('reports', 'dar_purdept')) {
                              $staffs = $this->db->select($this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_designation . '.desig_title')
                                   ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                                   ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
                                   ->where($this->tbl_users . '.usr_resigned', 0)
                                   ->where('usr_active', 1)->where_in($this->tbl_users . '.usr_departments', array(7, 8))->get($this->tbl_users)->result_array();
                         } else {
                              $staffs = $this->db->select($this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_designation . '.desig_title')
                                   ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                                   ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                                   ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
                                   ->where($this->tbl_users . '.usr_resigned', 0)
                                   ->where('usr_active', 1)->where_in($this->tbl_users_groups . '.group_id', array(4, 7, 8, 9, 11))->get($this->tbl_users)->result_array();
                         }
                         //   if($this->uid == 853) {
                         //      echo $this->db->last_query();
                         //      debug($staffs);
                         //      exit;
                         //   }
                         foreach ((array) $staffs as $key => $value) {
                              $this->db->where($this->tbl_dar_master . '.darm_added_by = ' . $value['usr_id']);
                              $this->db->where('DATE(' . $this->tbl_dar_master . ".darm_added_on) = DATE('" . $dataFrom . "')");
                              $this->db->where('addedby.usr_resigned', 0);
                              $this->db->select($this->tbl_dar_master . '.*, addedby.usr_username AS ab_usr_username, verifiedbytl.usr_username AS vb_usr_username_tl,' .
                                   $this->tbl_showroom . '.*, verifiedbymg.usr_username AS vb_usr_username_mg,' . $this->tbl_designation . '.desig_title')
                                   ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_dar_master . '.darm_added_by', 'LEFT')
                                   ->join($this->tbl_users . ' verifiedbytl', 'verifiedbytl.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_team_lead', 'LEFT')
                                   ->join($this->tbl_users . ' verifiedbymg', 'verifiedbymg.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_manager', 'LEFT')
                                   ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_dar_master . '.darm_showroom', 'LEFT')
                                   ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = addedby.usr_designation_new', 'LEFT');
                              $this->db->order_by($this->tbl_dar_master . '.darm_added_on', 'DESC');
                              $value['darMaster'] = $this->db->get($this->tbl_dar_master)->result_array();
                              $return[$dataFrom][$key] = $value;
                         }
                    }
                    $dataFrom = date("Y-m-d", strtotime("+1 day", strtotime($dataFrom)));
               }
               //   if($this->uid == 641) {
               //        echo $this->db->last_query();
               //        debug($return);
               //   }
               return $return;
          }
     }

     function darStaffFilter()
     {

          if (check_permission('reports', 'dar_mystaff')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);

               return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                    ->where_in($this->tbl_users . '.usr_id', $mystaffs)
                    ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
          } else {
               if (check_permission('report', 'dar_showmyshowroomstaffonly')) {
                    $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
               }
               if (check_permission('emp_details', 'showinnactivestaffs')) {
                    $this->db->where($this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0');
               } else {
                    $this->db->where($this->tbl_users . '.usr_active = 1');
               }
               if ($this->usr_grp == 'TL') {
                    //$this->db->where($this->tbl_users . '.usr_tl', $this->uid);
                    //                 $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
                    return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                         ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                         ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
                         //->where(array($this->tbl_users . '.usr_can_auto_assign' => 1))
                         ->where_in($this->tbl_groups . '.grp_slug', array('SE', 'TC'))
                         ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
               } else {
                    return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                         ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                         ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')

                         ->where_in($this->tbl_groups . '.grp_slug', array('SE', 'TC'))
                         ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
               }
          }
     }

     function searchInquiryByDefault($limit = 0, $page = 0, $data)
     {
          $this->db->query('SET SQL_BIG_SELECTS=1');
          $mystaffs = array();
          if (check_permission('enquiry', 'showonlymystaff')) {
               $mystaffs = my_staff($this->uid);
          } else if ($this->usr_grp == 'TL') {
               if (check_permission('reports', 'show_res_inact_staff_also')) {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                    array_push($mystaffs, $this->uid);
               } else {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where(array('usr_tl' => $this->uid, 'usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->row()->usr_id);
                    array_push($mystaffs, $this->uid);
               }
          }
          $showroom = get_logged_user('usr_showroom');
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }
          if (isset($data['dist']) && !empty($data['dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $data['dist']);
          }
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }

          if (is_roo_user() || check_permission('enquiry', 'showall')) { // Admin users
          } else if (check_permission('enquiry', 'showonlymystaff')) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          } else if ($this->usr_grp == 'MG' && $this->uid != 48 && $this->uid != 870 && $this->uid != 927 && $this->uid != 691) { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE' || (check_permission('enquiry', 'showmyshowroom'))) { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE' && empty($data['executive'])) { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if (!empty($mystaffs)) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if (isset($data['isMissedFollowup']) && $data['isMissedFollowup'] == 1) {
               $this->db->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)');
          }
          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }

          if (!isset($data['isDrpNdLost'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          }
          $bgetfr = (isset($data['bgetfr']) && !empty($data['bgetfr'])) ? $data['bgetfr'] : 0;
          $bgetto = (isset($data['bgetto']) && !empty($data['bgetto'])) ? $data['bgetto'] : 0;
          if ($bgetfr > 0 && $bgetto > 0) {
               $this->db->where('(' . $this->tbl_enquiry . '.enq_budget >= ' . $bgetfr . ' && ' . $this->tbl_enquiry . '.enq_budget <= ' . $bgetto . ')');
          } else if ($bgetfr > 0 && empty($bgetto)) {
               $this->db->where($this->tbl_enquiry . '.enq_budget >= ' . $bgetfr);
          }
          $return['count'] = $this->db->count_all_results($this->tbl_enquiry);

          /* Data */
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }
          if (isset($data['dist']) && !empty($data['dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $data['dist']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }
          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }
          if (is_roo_user() || check_permission('enquiry', 'showall')) { // Admin users 
          } else if (check_permission('enquiry', 'showonlymystaff')) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          } else if ($this->usr_grp == 'MG' && $this->uid != 48 && $this->uid != 870 && $this->uid != 927 && $this->uid != 691) { // Manager Ponnu, Shiny, Remya, Ancy
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE' || (check_permission('enquiry', 'showmyshowroom'))) { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE' && empty($data['executive'])) { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if (!empty($mystaffs)) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }

          if ($bgetfr > 0 && $bgetto > 0) {
               $this->db->where('(' . $this->tbl_enquiry . '.enq_budget >= ' . $bgetfr . ' && ' . $this->tbl_enquiry . '.enq_budget <= ' . $bgetto . ')');
          } else if ($bgetfr > 0 && empty($bgetto)) {
               $this->db->where($this->tbl_enquiry . '.enq_budget >= ' . $bgetfr);
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }

          $select = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_whatsapp',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_cus_status',
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_showroom . '.*',
               $this->tbl_enquiry . '.enq_next_foll_date',
               $this->tbl_enquiry . '.enq_home_visit_date',
               $this->tbl_enquiry . '.enq_sm_rmk',
               $this->tbl_enquiry . '.enq_asm_rmk',
               $this->tbl_enquiry . '.enq_mis_rmk',
               'addedBy.usr_first_name AS addedBy_usr_first_name',
               $this->tbl_district_statewise . '.std_district_name',
               $this->tbl_enquiry . '.enq_last_foll_cust_rmk',
               $this->tbl_enquiry . '.enq_last_foll_date',
               //$this->tbl_enquiry_meta . '.enqm_pur_veh',
               //$this->tbl_enquiry_meta . '.enqm_sls_veh'
          );
          if (isset($data['isMissedFollowup']) && $data['isMissedFollowup'] == 1) {
               $this->db->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)');
          }
          if (!isset($data['isDrpNdLost'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          }
          $return['data'] = $this->db->select($select)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_users . ' AS addedBy', 'addedBy.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'LEFT')
               //->join($this->tbl_enquiry_meta, $this->tbl_enquiry_meta . '.enqm_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
               ->get($this->tbl_enquiry)->result_array();
          // if ($this->uid == 100) {
          //      echo $this->db->last_query();
          //      debug($return);
          // }
          return $return;
     }

     function poolEnq($limit = 0, $page = 0, $data)
     {

          $mystaffs = array();
          if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $this->uid);
          }
          $showroom = get_logged_user('usr_showroom');
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }
          if (isset($data['dist']) && !empty($data['dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $data['dist']);
          }
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_pool_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }

          if (is_roo_user() || check_permission('enquiry', 'showall')) { // Admin users
          } else if (check_permission('enquiry', 'showmyshowroom')) { // SM
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if (check_permission('enquiry', 'showonlymyself')) { // SE
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if (check_permission('enquiry', 'showonlymystaff')) { // ASM
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if (isset($data['isMissedFollowup']) && $data['isMissedFollowup'] == 1) {
               $this->db->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)');
          }

          if (isset($data['isFollowPending']) && $data['isFollowPending'] == 1) {
               $this->db->where('enq_pool_updt_date', NULL);
          }

          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }

          if (!isset($data['isDrpNdLost'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          }
          $bgetfr = (isset($data['bgetfr']) && !empty($data['bgetfr'])) ? $data['bgetfr'] : 0;
          $bgetto = (isset($data['bgetto']) && !empty($data['bgetto'])) ? $data['bgetto'] : 0;
          if ($bgetfr > 0 && $bgetto > 0) {
               $this->db->where('(' . $this->tbl_enquiry . '.enq_budget >= ' . $bgetfr . ' && ' . $this->tbl_enquiry . '.enq_budget <= ' . $bgetto . ')');
          } else if ($bgetfr > 0 && empty($bgetto)) {
               $this->db->where($this->tbl_enquiry . '.enq_budget >= ' . $bgetfr);
          }
          $this->db->where('enq_is_pool', 1);
          $return['count'] = $this->db->count_all_results($this->tbl_enquiry);

          /* Data */
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }
          if (isset($data['dist']) && !empty($data['dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $data['dist']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_pool_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }
          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }

          if (is_roo_user() || check_permission('enquiry', 'showall')) { // Admin users
          } else if (check_permission('enquiry', 'showmyshowroom')) { // SM
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if (check_permission('enquiry', 'showonlymyself')) { // SE
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if (check_permission('enquiry', 'showonlymystaff')) { // ASM
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }

          if ($bgetfr > 0 && $bgetto > 0) {
               $this->db->where('(' . $this->tbl_enquiry . '.enq_budget >= ' . $bgetfr . ' && ' . $this->tbl_enquiry . '.enq_budget <= ' . $bgetto . ')');
          } else if ($bgetfr > 0 && empty($bgetto)) {
               $this->db->where($this->tbl_enquiry . '.enq_budget >= ' . $bgetfr);
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }

          $select = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_whatsapp',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_cus_status',
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_showroom . '.*',
               $this->tbl_enquiry . '.enq_next_foll_date',
               $this->tbl_enquiry . '.enq_pool_lst_cmd',
               $this->tbl_enquiry . '.enq_pool_updt_date',
               $this->tbl_enquiry . '.enq_pool_entry_date'
          );
          if (isset($data['isMissedFollowup']) && $data['isMissedFollowup'] == 1) {
               $this->db->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)');
          }
          if (!isset($data['isDrpNdLost'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          }
          if (isset($data['isFollowPending']) && $data['isFollowPending'] == 1) {
               $this->db->where('enq_pool_updt_date', NULL);
          }
          $this->db->where('enq_is_pool', 1);
          $return['data'] = $this->db->select($select)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
               ->get($this->tbl_enquiry)->result_array();
          // if ($this->uid == 927) {
          //echo $this->db->last_query();
          //debug($return);
          // }
          return $return;
     }

     function searchInquiryByDefaultNoLimit($limit = 0, $page = 0, $data)
     {
          $mystaffs = array();
          if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $this->uid);
          }
          $showroom = get_logged_user('usr_showroom');
          /* Data */
          if (isset($data['mode']) && !empty($data['mode'])) {
               if (is_array($data['mode'])) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
               } else {
                    $this->db->where($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
               }
          }
          if (isset($data['dist']) && !empty($data['dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $data['dist']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }
          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }
          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG' && $this->uid != 48 && $this->uid != 870 && $this->uid != 927) { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE' || (check_permission('enquiry', 'showmyshowroom'))) { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }

          $select = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_whatsapp',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_cus_status',
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_showroom . '.*',
               $this->tbl_enquiry . '.enq_next_foll_date'
          );
          if (isset($data['isMissedFollowup']) && $data['isMissedFollowup'] == 1) {
               $this->db->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)');
          }
          if (!isset($data['isDrpNdLost'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          }
          return $this->db->select($select)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
               ->get($this->tbl_enquiry)->result_array();
     }

     function homevisitneeded($limit = 0, $page = 0, $filter)
     {
          //if (!is_roo_user()) {
          //     $this->db->where('foll_added_by', $this->uid);
          //}
          if (isset($filter['executive']) && !empty($filter['executive'])) {
               $this->db->where_in('foll_added_by', $filter['executive']);
          }
          if (isset($filter['enq_date_from']) && !empty($filter['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($filter['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_followup . '.foll_entry_date) >=', $date);
          }
          if (isset($filter['enq_date_to']) && !empty($filter['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($filter['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_followup . '.foll_entry_date) <=', $date);
          }
          //$homeVisitNeeded = $this->db->select('foll_cus_id')->distinct()->get_where($this->tbl_followup, array('foll_contact' => 2))->result_array();
          //if (!empty($homeVisitNeeded)) {

          //$homeVisitNeeded = array_column($homeVisitNeeded, 'foll_cus_id');

          //$return['count'] = $this->db->where_in($this->tbl_enquiry . '.enq_id', $homeVisitNeeded)->count_all_results($this->tbl_enquiry);
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          $return['count'] = $this->db->where($this->tbl_enquiry . '.enq_cus_home_visit', 1)->count_all_results($this->tbl_enquiry);

          if ($limit) {
               $this->db->limit($limit, $page);
          }
          $selectArray = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_status',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_contact_mode . '.cmd_title'
          );
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          $return['data'] = $this->db->select($selectArray)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_enquiry . '.enq_mode_enq', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->where($this->tbl_enquiry . '.enq_cus_home_visit', 1)
               ->get($this->tbl_enquiry)->result_array();
          //if($this->uid == 100) {
          //echo $this->db->last_query();
          //debug($return);
          //}
          return $return;
          //}
     }

     function getBookedEnquires($limit = 0, $page = 0)
     {
          $showroom = get_logged_user('usr_showroom');
          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG' || $this->usr_grp == 'TL') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          }
          $this->db->where($this->tbl_enquiry . '.enq_current_status', 13);
          $return['count'] = $this->db->count_all_results($this->tbl_enquiry);

          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG' || $this->usr_grp == 'TL') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_contact_mode . '.*,' .
               $this->tbl_enquiry_history . '.*,' . $this->tbl_valuation . '.val_id,' .
               $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' .
               $this->tbl_valuation . '.val_veh_no,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' .
               $this->tbl_vehicle_booking_master . '.vbk_added_on')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_enquiry . '.enq_mode_enq', 'LEFT')
               ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_enquiry_history . '.enh_booked_vehicle', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_vehicle_booking_master, $this->tbl_vehicle_booking_master . '.vbk_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->order_by($this->tbl_vehicle_booking_master . '.vbk_added_on', 'DESC')->where($this->tbl_enquiry . '.enq_current_status', 13);

          $return['data'] = $this->db->get($this->tbl_enquiry)->result_array();
          return $return;
     }

     function voxbayCallHistory($filter = array())
     {

          $dataFrom = '';
          $dataTo = '';
          if (isset($filter['date_from']) && !empty($filter['date_from'])) {
               $dataFrom = date('Y-m-d', strtotime($filter['date_from']));
               $this->db->where('DATE(ccb_added_on) >=', $dataFrom);
          }
          if (isset($filter['date_to']) && !empty($filter['date_to'])) {
               $dataTo = date('Y-m-d', strtotime($filter['date_to']));
               $this->db->where('DATE(ccb_added_on) <=', $dataTo);
          }
          if (empty($dataFrom) && empty($dataTo)) {
               $this->db->where('DATE(ccb_added_on)', date('Y-m-d'));
          }
          return $this->db->where('ccb_recording_URL IS NOT NULL')->get($this->tbl_callcenterbridging)->result_array();
     }

     /* public function getAllCalls($postDatas) {
         $se = isset($postDatas['se']) ? $postDatas['se'] : '';
         $dataFrom = '';
         $dataTo = '';

         $draw = $postDatas['draw'];
         $row = $postDatas['start'];
         $rowperpage = $postDatas['length']; // Rows display per page
         $columnIndex = $postDatas['order'][0]['column']; // Column index
         $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
         $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
         $searchValue = $postDatas['search']['value']; // Search value
         ## Search

         $searchQuery = "";
         if ($searchValue != '') {
         $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
         . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
         }
         $this->db->where('ccb_recording_URL IS NOT NULL');
         $this->db->group_by('ccb_register_ref');

         ## Total number of records without filtering
         $totalRecords = $this->db->count_all_results($this->tbl_callcenterbridging);

         ## Total number of record with filtering
         if (!empty($searchQuery)) {
         $this->db->where($searchQuery);
         }
         ## filter by date
         if (isset($postDatas['fData']) && !empty($postDatas['fData'])) {
         $dataFrom = date('Y-m-d', strtotime($postDatas['fData']));
         $this->db->where('DATE(ccb_added_on) >=', $dataFrom);
         }
         if (isset($postDatas['tData']) && !empty($postDatas['tData'])) {
         $dataTo = date('Y-m-d', strtotime($postDatas['tData']));
         $this->db->where('DATE(ccb_added_on) <=', $dataTo);
         }
         if (empty($dataFrom) && empty($dataTo)) {
         $this->db->where('DATE(ccb_added_on)', date('Y-m-d'));
         }
         if (check_permission('reports', 'showmyvxbyreg')) {
         $this->db->where('ccb_punched_by', $this->uid);
         }
         if (!empty($se)) {
         if (check_permission('reports', 'canchoosese')) {
         $this->db->where_in('ccb_punched_by', $se);
         }
         }
         $totalRecordwithFilter = $this->db->count_all_results($this->tbl_callcenterbridging);

         ## Fetch records
         if (!empty($searchValue)) {
         $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
         . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
         }
         if (!empty($columnName) && !empty($columnSortOrder)) {
         $this->db->order_by($columnName, $columnSortOrder);
         }
         $this->db->order_by('ccb_id', 'desc');
         $this->db->group_by('ccb_register_ref');

         $this->db->limit($rowperpage, $row);
         $this->db->select(array(
         $this->tbl_callcenterbridging . '.ccb_id',
         "CONCAT('http://pbx.voxbaysolutions.com/callrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
         $this->tbl_callcenterbridging . '.ccb_callStatus',
         $this->tbl_callcenterbridging . '.ccb_calledNumber',
         $this->tbl_callcenterbridging . '.ccb_callerNumber',
         $this->tbl_callcenterbridging . '.ccb_AgentNumber',
         $this->tbl_callcenterbridging . '.ccb_authorized_person',
         "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_callDate, "%M %d %Y %h %i") AS ccb_callDate',
         "DATE_FORMAT(" . $this->tbl_register_master . '.vreg_entry_date, "%M %d %Y %h %i") AS vreg_entry_date',
         $this->tbl_callcenterbridging . '.ccb_register_ref',
         $this->tbl_register_master . '.*',
         'assign.usr_first_name AS assign_usr_first_name',
         'assign.usr_last_name AS assign_usr_last_name',
         'addedby.usr_first_name AS addedby_usr_first_name',
         'addedby.usr_last_name AS addedby_usr_last_name',
         $this->tbl_events . '.evnt_title',
         $this->tbl_brand . '.brd_id', $this->tbl_brand . '.brd_title',
         $this->tbl_model . '.mod_id', $this->tbl_model . '.mod_title',
         $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',
         $this->tbl_departments . '.*'
         ));
         $this->db->where('ccb_recording_URL IS NOT NULL');

         ## filter by date
         if (isset($postDatas['fData']) && !empty($postDatas['fData'])) {
         $dataFrom = date('Y-m-d', strtotime($postDatas['fData']));
         $this->db->where('DATE(vreg_entry_date) >=', $dataFrom);
         }
         if (isset($postDatas['tData']) && !empty($postDatas['tData'])) {
         $dataTo = date('Y-m-d', strtotime($postDatas['tData']));
         $this->db->where('DATE(vreg_entry_date) <=', $dataTo);
         }
         if (empty($dataFrom) && empty($dataTo)) {
         $this->db->where('DATE(vreg_entry_date)', date('Y-m-d'));
         }
         if (check_permission('reports', 'showmyvxbyreg')) {
         $this->db->where($this->tbl_register_master . '.vreg_first_owner', $this->uid);
         }
         if (!empty($se)) {
         if (check_permission('reports', 'canchoosese')) {
         $this->db->where_in($this->tbl_callcenterbridging . '.ccb_punched_by', $se);
         }
         }
         $data = $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_callcenterbridging . '.ccb_register_ref', 'LEFT')
         ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
         ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
         ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
         ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
         ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
         ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
         ->get($this->tbl_callcenterbridging)->result_array();

         //            echo $this->db->last_query();
         //            debug($data);
         ## Response
         $response = array(
         "draw" => intval($draw),
         "iTotalRecords" => $totalRecords,
         "iTotalDisplayRecords" => $totalRecordwithFilter,
         "aaData" => $data
         );
         return $response;
         }

         function eportVoxbayDailyCallReport($postDatas) {
         $se = isset($postDatas['se']) ? $postDatas['se'] : '';
         $searchValue = (isset($postDatas['search']) && !empty($postDatas['search'])) ? $postDatas['search'] : '';
         if (!empty($searchValue)) {
         $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
         . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
         }

         $this->db->order_by('ccb_id', 'desc');
         $this->db->group_by('ccb_register_ref');

         $this->db->select(array(
         $this->tbl_callcenterbridging . '.ccb_id',
         "CONCAT('http://pbx.voxbaysolutions.com/callrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
         $this->tbl_callcenterbridging . '.ccb_callStatus',
         $this->tbl_callcenterbridging . '.ccb_calledNumber',
         $this->tbl_callcenterbridging . '.ccb_callerNumber',
         $this->tbl_callcenterbridging . '.ccb_AgentNumber',
         $this->tbl_callcenterbridging . '.ccb_authorized_person',
         "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_callDate, "%M %d %Y %h %i") AS ccb_callDate',
         "DATE_FORMAT(" . $this->tbl_register_master . '.vreg_entry_date, "%M %d %Y %h %i") AS vreg_entry_date',
         $this->tbl_callcenterbridging . '.ccb_register_ref',
         $this->tbl_register_master . '.*',
         'assign.usr_first_name AS assign_usr_first_name',
         'assign.usr_last_name AS assign_usr_last_name',
         'addedby.usr_first_name AS addedby_usr_first_name',
         'addedby.usr_last_name AS addedby_usr_last_name',
         $this->tbl_events . '.evnt_title',
         $this->tbl_brand . '.brd_id', $this->tbl_brand . '.brd_title',
         $this->tbl_model . '.mod_id', $this->tbl_model . '.mod_title',
         $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',
         $this->tbl_departments . '.*'
         ));
         $this->db->where('ccb_recording_URL IS NOT NULL');

         ## filter by date
         if (isset($postDatas['fData']) && !empty($postDatas['fData'])) {
         $dataFrom = date('Y-m-d', strtotime($postDatas['fData']));
         $this->db->where('DATE(vreg_entry_date) >=', $dataFrom);
         }
         if (isset($postDatas['tData']) && !empty($postDatas['tData'])) {
         $dataTo = date('Y-m-d', strtotime($postDatas['tData']));
         $this->db->where('DATE(vreg_entry_date) <=', $dataTo);
         }
         if (empty($dataFrom) && empty($dataTo)) {
         $this->db->where('DATE(vreg_entry_date)', date('Y-m-d'));
         }

         if (check_permission('reports', 'showmyvxbyreg')) {
         $this->db->where($this->tbl_register_master . '.vreg_first_owner', $this->uid);
         }
         if (!empty($se)) {
         if (check_permission('reports', 'canchoosese')) {
         $this->db->where_in($this->tbl_callcenterbridging . '.ccb_punched_by', $se);
         }
         }

         $return = $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_callcenterbridging . '.ccb_register_ref', 'LEFT')
         ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
         ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
         ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
         ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
         ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
         ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
         ->get($this->tbl_callcenterbridging)->result_array();

         echo $this->db->last_query();
         debug($return);
         } */

     public function getAllCalls($postDatas)
     {
          $se = isset($postDatas['se']) ? $postDatas['se'] : '';
          $dataFrom = '';
          $dataTo = '';

          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = $postDatas['order'][0]['column']; // Column index
          $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
          $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          ## Search 

          $this->db->where('ccb_recording_URL IS NOT NULL');
          $this->db->group_by('ccb_register_ref');

          if (check_permission('reports', 'showmyvxbyreg')) {
               $this->db->where($this->tbl_register_master . '.vreg_first_owner', $this->uid);
          }
          if (!empty($se)) {
               if (check_permission('reports', 'canchoosese') || check_permission('reports', 'myreportingstaff')) {
                    $this->db->where_in($this->tbl_register_master . '.vreg_first_owner', $se);
               }
          }

          $totalRecords = $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_callcenterbridging . '.ccb_register_ref', 'LEFT')
               ->count_all_results($this->tbl_callcenterbridging);

          //----------------------------------------------------------------------------------------------------------

          if (!empty($searchValue)) {
               $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                    . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $this->db->order_by('ccb_id', 'desc');
          $this->db->group_by('ccb_register_ref');

          $this->db->select(array(
               $this->tbl_callcenterbridging . '.ccb_id'
          ));
          $this->db->where('ccb_recording_URL IS NOT NULL');

          if (isset($postDatas['fData']) && !empty($postDatas['fData'])) {
               $dataFrom = date('Y-m-d', strtotime($postDatas['fData']));
               $this->db->where('DATE(vreg_entry_date) >=', $dataFrom);
          }
          if (isset($postDatas['tData']) && !empty($postDatas['tData'])) {
               $dataTo = date('Y-m-d', strtotime($postDatas['tData']));
               $this->db->where('DATE(vreg_entry_date) <=', $dataTo);
          }
          if (empty($dataFrom) && empty($dataTo)) {
               $this->db->where('DATE(vreg_entry_date)', date('Y-m-d'));
          }
          if (check_permission('reports', 'showmyvxbyreg')) {
               $this->db->where($this->tbl_register_master . '.vreg_first_owner', $this->uid);
          }
          if (!empty($se)) {
               if (check_permission('reports', 'canchoosese') || check_permission('reports', 'myreportingstaff')) {
                    $this->db->where_in($this->tbl_callcenterbridging . '.ccb_punched_by', $se);
               }
          }
          $totalRecordwithFilter = $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_callcenterbridging . '.ccb_register_ref', 'LEFT')
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->get($this->tbl_callcenterbridging)->result_array();

          $totalRecordwithFilter = count($totalRecordwithFilter);

          //--------------------------------------------------------------------------------------------------------------------------

          if (!empty($searchValue)) {
               $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                    . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $this->db->order_by('ccb_id', 'desc');
          $this->db->group_by('ccb_register_ref');

          $this->db->limit($rowperpage, $row);
          $this->db->select(array(
               $this->tbl_callcenterbridging . '.ccb_id',
               "CONCAT('http://pbx.voxbaysolutions.com/callrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus',
               $this->tbl_callcenterbridging . '.ccb_calledNumber',
               $this->tbl_callcenterbridging . '.ccb_callerNumber',
               $this->tbl_callcenterbridging . '.ccb_AgentNumber',
               $this->tbl_callcenterbridging . '.ccb_authorized_person',
               "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_callDate, "%M %d %Y") AS ccb_callDate',
               $this->tbl_callcenterbridging . '.ccb_register_ref',
               $this->tbl_register_master . '.*',
               "DATE_FORMAT(" . $this->tbl_register_master . '.vreg_entry_date, "%M %d %Y") AS vreg_entry_date',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id', $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id', $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',
               $this->tbl_departments . '.*'
          ));
          $this->db->where('ccb_recording_URL IS NOT NULL');

          if (isset($postDatas['fData']) && !empty($postDatas['fData'])) {
               $dataFrom = date('Y-m-d', strtotime($postDatas['fData']));
               $this->db->where('DATE(vreg_entry_date) >=', $dataFrom);
          }
          if (isset($postDatas['tData']) && !empty($postDatas['tData'])) {
               $dataTo = date('Y-m-d', strtotime($postDatas['tData']));
               $this->db->where('DATE(vreg_entry_date) <=', $dataTo);
          }
          if (empty($dataFrom) && empty($dataTo)) {
               $this->db->where('DATE(vreg_entry_date)', date('Y-m-d'));
          }
          if (check_permission('reports', 'showmyvxbyreg')) {
               $this->db->where($this->tbl_register_master . '.vreg_first_owner', $this->uid);
          }
          if (!empty($se)) {
               if (check_permission('reports', 'canchoosese') || check_permission('reports', 'myreportingstaff')) {
                    $this->db->where_in($this->tbl_register_master . '.vreg_first_owner', $se);
               }
          }
          $data = $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_callcenterbridging . '.ccb_register_ref', 'LEFT')
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->get($this->tbl_callcenterbridging)->result_array();

          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;
     }

     function eportVoxbayDailyCallReport($postDatas)
     {
          $se = (isset($postDatas['se']) && !empty($postDatas['se'])) ? explode(',', $postDatas['se']) : '';
          $searchValue = (isset($postDatas['search']) && !empty($postDatas['search'])) ? $postDatas['search'] : '';
          if (!empty($searchValue)) {
               $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                    . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }

          $this->db->order_by('ccb_id', 'desc');
          $this->db->group_by('ccb_register_ref');

          $this->db->select(array(
               $this->tbl_callcenterbridging . '.ccb_id',
               "CONCAT('http://pbx.voxbaysolutions.com/callrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus',
               $this->tbl_callcenterbridging . '.ccb_calledNumber',
               $this->tbl_callcenterbridging . '.ccb_callerNumber',
               $this->tbl_callcenterbridging . '.ccb_AgentNumber',
               $this->tbl_callcenterbridging . '.ccb_authorized_person',
               "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_callDate, "%M %d %Y") AS ccb_callDate',
               $this->tbl_callcenterbridging . '.ccb_register_ref',
               $this->tbl_register_master . '.*',
               "DATE_FORMAT(" . $this->tbl_register_master . '.vreg_entry_date, "%M %d %Y") AS vreg_entry_date',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id', $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id', $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',
               $this->tbl_departments . '.*'
          ));
          $this->db->where('ccb_recording_URL IS NOT NULL');

          ## filter by date
          if (isset($postDatas['fData']) && !empty($postDatas['fData'])) {
               $dataFrom = date('Y-m-d', strtotime($postDatas['fData']));
               $this->db->where('DATE(vreg_entry_date) >=', $dataFrom);
          }
          if (isset($postDatas['tData']) && !empty($postDatas['tData'])) {
               $dataTo = date('Y-m-d', strtotime($postDatas['tData']));
               $this->db->where('DATE(vreg_entry_date) <=', $dataTo);
          }
          if (empty($dataFrom) && empty($dataTo)) {
               $this->db->where('DATE(vreg_entry_date)', date('Y-m-d'));
          }

          if (check_permission('reports', 'showmyvxbyreg')) {
               $this->db->where($this->tbl_register_master . '.vreg_first_owner', $this->uid);
          }
          if (!empty($se)) {
               if (check_permission('reports', 'canchoosese') || check_permission('reports', 'myreportingstaff')) {
                    $this->db->where_in($this->tbl_register_master . '.vreg_first_owner', $se);
               }
          }

          return $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_callcenterbridging . '.ccb_register_ref', 'LEFT')
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->get($this->tbl_callcenterbridging)->result_array();
     }

     function getQuickAssignInquires($limit = 0, $page = 0, $data)
     {
          $mystaffs = array();
          if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id);
          }
          $showroom = get_logged_user('usr_showroom');

          /* Data */
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }

          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where('followup_current_status.foll_status', $data['status']);
          }

          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL') {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }

          $this->db->join('(SELECT foll_id, foll_status, foll_cus_id, foll_cus_vehicle_id 
                              FROM ' . $this->tbl_followup . ' WHERE foll_is_cmnt = 0 AND foll_id IN (select MAX(foll_id) AS foll_id FROM ' .
               $this->tbl_followup . ' GROUP BY foll_cus_id)
                         ) followup_current_status', 'followup_current_status.foll_cus_id = ' . $this->tbl_enquiry . '.enq_id', 'INNER');

          $selectArray = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_se_id'
          );
          if ($limit || $page) {
               $this->db->limit($limit, $page);
          }
          return $this->db->select($selectArray)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . 'followup_current_status.foll_cus_vehicle_id', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
               ->get($this->tbl_enquiry)->result_array();
     }

     function quickEnquiryFedBack($postDatas)
     {
          $filter = isset($postDatas['filter']) ? unserialize($postDatas['filter']) : array();
          $filetrWhere = array();
          if (!empty($filter)) {
               foreach ($filter as $key => $value) {
                    $filetrWhere[] = $key . ' = ' . $value;
               }
          }
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = $postDatas['order'][0]['column']; // Column index
          $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
          $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          ## Search 
          $totalRecords = $this->db->count_all_results($this->tbl_quick_tc_report);

          if (!empty($filetrWhere)) {
               $this->db->where("(" . implode(' AND ', $filetrWhere) . " )");
          }
          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_username LIKE '%" . $searchValue . "%' OR "
                    . "replyBy.usr_username LIKE '%" . $searchValue . "%' OR " . $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $searchValue . "%') ");
          }

          $selectArray = array(
               $this->tbl_quick_tc_report . '.*',
               "DATE_FORMAT(" . $this->tbl_enquiry . '.enq_entry_date, "%M %d %Y") AS enq_entry_date',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_whatsapp',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_users . '.usr_username',
               'replyBy.usr_username AS replyByTc',
               "DATE_FORMAT(" . $this->tbl_quick_tc_report . '.qtr_reply_on, "%M %d %Y") AS qtr_reply_on',
          );
          if ($this->uid != ADMIN_ID && check_permission('enquiry', 'showonlyassigntome')) {
               $this->db->where($this->tbl_quick_tc_report . '.qtr_assigned_to', $this->uid);
          }

          $totalRecordwithFilter = $this->db->select($selectArray)
               ->join($this->tbl_enquiry, $this->tbl_quick_tc_report . '.qtr_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_users . ' replyBy', 'replyBy.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_reply_by', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
               ->get($this->tbl_quick_tc_report)->result_array();
          $totalRecordwithFilter = count($totalRecordwithFilter);

          if (!empty($filetrWhere)) {
               $this->db->where("(" . implode(' AND ', $filetrWhere) . " )");
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $this->db->limit($rowperpage, $row);
          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_username LIKE '%" . $searchValue . "%' OR "
                    . "replyBy.usr_username LIKE '%" . $searchValue . "%' OR " . $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $searchValue . "%') ");
          }

          if ($this->uid != ADMIN_ID && check_permission('enquiry', 'showonlyassigntome')) {
               $this->db->where($this->tbl_quick_tc_report . '.qtr_assigned_to', $this->uid);
          }
          $selectArray = array(
               $this->tbl_quick_tc_report . '.*',
               "DATE_FORMAT(" . $this->tbl_enquiry . '.enq_entry_date, "%M %d %Y") AS enq_entry_date',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_whatsapp',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_users . '.usr_username',
               'replyBy.usr_username AS replyByTc',
               "DATE_FORMAT(" . $this->tbl_quick_tc_report . '.qtr_reply_on, "%M %d %Y") AS qtr_reply_on',
          );
          $data = $this->db->select($selectArray)
               ->join($this->tbl_enquiry, $this->tbl_quick_tc_report . '.qtr_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_users . ' replyBy', 'replyBy.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
               ->order_by($this->tbl_quick_tc_report . '.qtr_reply_on', 'DESC')
               ->get($this->tbl_quick_tc_report)->result_array();

          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;

          /* foreach ($data as $key1 => $value1) {
              $vehicles = $this->db->select($this->tbl_vehicle . '.veh_id,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
              ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
              ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
              ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
              ->where($this->tbl_vehicle . '.veh_enq_id', $value1['qtr_enq_id'])->get($this->tbl_vehicle)->result_array();
              $vehicleName = array();
              if (!empty($vehicles)) {
              foreach ($vehicles as $key2 => $value2) {
              $vehicleName[] = $value2['brd_title'] . ',' . $value2['mod_title'] . ',' . $value2['var_variant_name'];
              }
              }
              $veh = implode('/', $vehicleName);
              $this->db->where('qtr_id', $value1['qtr_id'])->update($this->tbl_quick_tc_report, array('qtr_vehile' => $veh));
              } */
     }

     function getAnalysisOfCall()
     {
          $data = array();
          $staffs = $this->db->select('qtr_assigned_to')->group_by('qtr_assigned_to')->get($this->tbl_quick_tc_report)->result_array();
          $staffs = array_column($staffs, 'qtr_assigned_to');

          foreach ($staffs as $key => $value) {
               @$data[$value]['name'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                    ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->get($this->tbl_quick_tc_report)->row()->usr_username;

               @$data[$value]['total'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                    ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->get($this->tbl_quick_tc_report)->row()->count;

               @$data[$value]['called'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                    ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_reply_by > 0')->get($this->tbl_quick_tc_report)->row()->count;

               @$data[$value]['balance'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                    ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_reply_by', 0)->get($this->tbl_quick_tc_report)->row()->count;

               @$data[$value]['hot'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                    ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_type', 1)->get($this->tbl_quick_tc_report)->row()->count;

               @$data[$value]['warm'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                    ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_type', 2)->get($this->tbl_quick_tc_report)->row()->count;

               @$data[$value]['cold'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                    ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_type', 3)->get($this->tbl_quick_tc_report)->row()->count;

               @$data[$value]['efect'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                    ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_effective', 1)->get($this->tbl_quick_tc_report)->row()->count;

               @$data[$value]['infect'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                    ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_effective', 0)->get($this->tbl_quick_tc_report)->row()->count;
          }
          return $data;
     }

     function voxbayPunchReprt_ajax($postDatas)
     {

          $filter = isset($postDatas['filter']) ? unserialize($postDatas['filter']) : array();
          $filetrWhere = array();
          if (!empty($filter)) {
               foreach ($filter as $key => $value) {
                    $filetrWhere[] = $key . ' = ' . $value;
               }
          }
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = $postDatas['order'][0]['column']; // Column index
          $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
          $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          ## Search 

          $totalRecords = $this->db->count_all_results($this->tbl_callcenterbridging);

          if (!empty($filetrWhere)) {
               $this->db->where("(" . implode(' AND ', $filetrWhere) . " )");
          }
          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_callcenterbridging . ".ccb_callerNumber LIKE '%" . $searchValue . "%' OR " . $this->tbl_callcenterbridging . ".ccb_calledNumber LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_callcenterbridging . ".ccb_AgentNumber LIKE '%" . $searchValue . "%' OR " . $this->tbl_callcenterbridging . ".ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }
          //            $this->db->where($this->tbl_callcenterbridging . '.ccb_callStatus', 'Connected');

          $selectArray = array(
               $this->tbl_callcenterbridging . '.*'
          );
          $totalRecordwithFilter = $this->db->select($selectArray)->get($this->tbl_callcenterbridging)->result_array();

          $totalRecordwithFilter = count($totalRecordwithFilter);

          if (!empty($filetrWhere)) {
               $this->db->where("(" . implode(' AND ', $filetrWhere) . " )");
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $this->db->limit($rowperpage, $row);
          //            $this->db->where($this->tbl_callcenterbridging . '.ccb_callStatus', 'Connected');
          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_callcenterbridging . ".ccb_callerNumber LIKE '%" . $searchValue . "%' OR " . $this->tbl_callcenterbridging . ".ccb_calledNumber LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_callcenterbridging . ".ccb_AgentNumber LIKE '%" . $searchValue . "%' OR " . $this->tbl_callcenterbridging . ".ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }

          $selectArray = array(
               $this->tbl_callcenterbridging . '.*',
               "CONCAT('http://pbx.voxbaysolutions.com/callrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
               "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_callDate, "%M %d %Y") AS ccb_callDate',
               "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_callDate, "%h %i") AS ccb_callTime',
               $this->tbl_register_master . '.*', "DATE_FORMAT(" . $this->tbl_register_master . '.vreg_added_on, "%M %d %Y") AS vreg_added_on',
               "DATE_FORMAT(" . $this->tbl_register_master . '.vreg_added_on, "%h %i") AS vreg_added_time',
               'assign.usr_first_name AS assign_usr_first_name', 'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name', 'addedby.usr_last_name AS addedby_usr_last_name',
               "DATE_FORMAT(" . $this->tbl_register_master . '.vreg_se_commented_on, "%M %d %Y %h %i") AS vreg_se_commented_on',
          );
          $data = $this->db->select($selectArray)
               ->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_callcenterbridging . '.ccb_register_ref', 'LEFT')
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->get($this->tbl_callcenterbridging)->result_array();
          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data,
               'hiden' => ''
          );

          return $response;
     }

     function searchEnquiryByDateShowroomSe($limit = 0, $page = 0, $data)
     {
          $this->db->query('SET SQL_BIG_SELECTS=1');
          $mystaffs = array();
          if ($this->usr_grp == 'TL') {
               if (check_permission('reports', 'show_res_inact_staff_also')) {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                    array_push($mystaffs, $this->uid);
               } else {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                         ->where(array('usr_tl' => $this->uid, 'usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->row()->usr_id);
                    array_push($mystaffs, $this->uid);
               }
          }
          $data['executive'] = isset($data['executive']) ? $data['executive'] : '';
          $showroom = get_logged_user('usr_showroom');

          /* Data */
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }

          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               //$this->db->where('followup_current_status.foll_status', $data['status']);
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }

          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG' && $this->uid != 48 && $this->uid != 870 && $this->uid != 927  && $this->uid != 691) { // Manager // Sreejitha
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE' || (check_permission('enquiry', 'showmyshowroom'))) { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE' && (empty($data['executive']))) { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) { // Team leed
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }

          if (!isset($data['isDrpNdLost'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          }

          $return['count'] = $this->db->count_all_results($this->tbl_enquiry);

          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }

          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
               $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          }
          if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($data['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
          }

          if (isset($data['status']) && !empty($data['status'])) {
               //$this->db->where('followup_current_status.foll_status', $data['status']);
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }

          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG' && $this->uid != 48 && $this->uid != 870 && $this->uid != 927 && $this->uid != 691) { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE' || (check_permission('enquiry', 'showmyshowroom'))) { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE' && (empty($data['executive']))) { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) { // Team leed
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }

          if (!isset($data['isDrpNdLost'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          }
          $selectArray = array(
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_budget',
               $this->tbl_enquiry . '.enq_cus_status',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_address',
               $this->tbl_enquiry . '.enq_cus_loan_perc',
               $this->tbl_enquiry . '.enq_cus_loan_amount',
               $this->tbl_enquiry . '.enq_cus_loan_emi',
               $this->tbl_enquiry . '.enq_cus_loan_period',
               $this->tbl_enquiry . '.enq_cus_remarks',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_next_foll_date',
               $this->tbl_enquiry . '.enq_added_on',
               $this->tbl_enquiry . '.enq_last_foll_cust_rmk',
               $this->tbl_enquiry . '.enq_last_foll_date',
               $this->tbl_enquiry . '.enq_home_visit_date',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_enquiry . '.enq_sm_rmk',
               $this->tbl_enquiry . '.enq_asm_rmk',
               $this->tbl_enquiry . '.enq_mis_rmk',
               $this->tbl_enquiry . '.enq_number',
               $this->tbl_enquiry . '.enq_cus_status',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_showroom . '.*',
               $this->tbl_occupation . '.*',
               $this->tbl_city . '.*',
               'teamLead.usr_username AS teamLead',
               $this->tbl_district_statewise . '.std_district_name',
               'createdby.usr_first_name AS createdby_first_name',
               $this->tbl_divisions . '.div_name',
               $this->tbl_enquiry_meta . '.enqm_pur_veh',
               $this->tbl_enquiry_meta . '.enqm_sls_veh'
          );
          $return['data'] = $this->db->select($selectArray)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_users . ' createdby', 'createdby.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'LEFT')
               ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'LEFT')
               ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city   ', 'LEFT')
               ->join($this->tbl_users . ' teamLead', 'teamLead.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'LEFT')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value_new = ' . $this->tbl_enquiry . '.enq_current_status', 'LEFT')
               ->join($this->tbl_enquiry_meta, $this->tbl_enquiry_meta . '.enqm_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_enquiry)->result_array();
          return $return;
     }

     function getVehicleByEnquiry($enqId)
     {
          $selectArray = array(
               $this->tbl_vehicle . '.veh_price_from',
               $this->tbl_vehicle . '.veh_price_to',
               $this->tbl_vehicle . '.veh_km_from',
               $this->tbl_vehicle . '.veh_km_to',
               $this->tbl_vehicle . '.veh_color',
               $this->tbl_vehicle . '.veh_year',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name'
          );
          if (!empty($enqId)) {
               $data['sales'] = $this->db->select($selectArray)
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')->limit(1)->get_where($this->tbl_vehicle, array(
                         $this->tbl_vehicle . '.veh_enq_id' => $enqId,
                         $this->tbl_vehicle . '.veh_status' => 1
                    ))->result_array();

               $data['buy'] = $this->db->select($selectArray)
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')->limit(1)->get_where($this->tbl_vehicle, array(
                         $this->tbl_vehicle . '.veh_enq_id' => $enqId,
                         $this->tbl_vehicle . '.veh_status' => 2
                    ))->result_array();
               return $data;
          }
          return array();
     }

     function telcalrPerformanceReport()
     {

          $dataTo = date('Y-m-d');
          $dataFrom = date('Y-m-d', strtotime('-10 days'));
          $data = array();
          $this->load->model('emp_details/emp_details_model', 'emp_details');

          while (strtotime($dataFrom) <= strtotime($dataTo)) {
               //Tele out
               $efectedCall = $this->db->select('count(*) AS count')->where('DATE(qtr_reply_on)', $dataFrom)->where('qtr_effective', 1)
                    ->group_by('qtr_assigned_to')->get($this->tbl_quick_tc_report)->row_array();

               $data[$dataFrom]['efectedCall'] = isset($efectedCall['count']) ? $efectedCall['count'] : 0;

               $inefectedCall = $this->db->select('count(*) AS count')->where('DATE(qtr_reply_on)', $dataFrom)->where('qtr_effective', 2)->group_by('qtr_assigned_to')
                    ->get($this->tbl_quick_tc_report)->row_array();
               $data[$dataFrom]['ineffectiveCall'] = isset($inefectedCall['count']) ? $inefectedCall['count'] : 0;

               $hot = $this->db->select('count(*) AS count')->where('DATE(qtr_reply_on)', $dataFrom)->where('qtr_type', 1)->group_by('qtr_assigned_to')
                    ->get($this->tbl_quick_tc_report)->row_array();
               $data[$dataFrom]['hot'] = isset($hot['count']) ? $hot['count'] : 0;

               $warm = $this->db->select('count(*) AS count')->where('DATE(qtr_reply_on)', $dataFrom)->where('qtr_type', 2)->group_by('qtr_assigned_to')
                    ->get($this->tbl_quick_tc_report)->row_array();
               $data[$dataFrom]['warm'] = isset($warm['count']) ? $warm['count'] : 0;

               $cold = $this->db->select('count(*) AS count')->where('DATE(qtr_reply_on)', $dataFrom)->where('qtr_type', 3)->group_by('qtr_assigned_to')
                    ->get($this->tbl_quick_tc_report)->row_array();
               $data[$dataFrom]['cold'] = isset($cold['count']) ? $cold['count'] : 0;

               $ttlAssigned = $this->db->select('count(*) AS count')->where('DATE(qtr_assigned_on)', $dataFrom)->get($this->tbl_quick_tc_report)->row_array();
               $data[$dataFrom]['ttlAssigned'] = isset($ttlAssigned['count']) ? $ttlAssigned['count'] : 0;

               $pending = $this->db->select('count(*) AS count')->where('DATE(qtr_assigned_on)', $dataFrom)
                    ->where("qtr_reply_on IS NULL OR qtr_reply_on = ''")->get($this->tbl_quick_tc_report)->row_array();
               $data[$dataFrom]['pending'] = isset($pending['count']) ? $pending['count'] : 0;

               //Tele in
               $teleIn = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $dataFrom)
                    ->where('ccb_callerNumber IS NOT NULL')->get($this->tbl_callcenterbridging)->result_array();

               //echo $this->db->last_query();exit;
               $data[$dataFrom]['teleIn'] = !empty($teleIn) ? count($teleIn) : 0;
               /* $this->db->query("SELECT count(*) AS count FROM ( SELECT ccb_callDate, ccb_callerNumber "
                   . "FROM (" . $this->tbl_callcenterbridging . ") WHERE DATE(ccb_added_on) = '" . $dataFrom .
                   "') AS x GROUP BY x.ccb_callerNumber")->result_array(); */

               $missed = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $dataFrom)
                    ->where('ccb_callStatus_id != 0')->where('ccb_callStatus_id != ' . VB_CONNECTED)
                    ->where('ccb_punched_by > 0')->get($this->tbl_callcenterbridging)->result_array();
               $data[$dataFrom]['missed'] = !empty($missed) ? count($missed) : 0;
               /* $missed = $this->db->query("SELECT count(*) AS count FROM ( SELECT ccb_callDate, ccb_callerNumber "
                   . "FROM (" . $this->tbl_callcenterbridging . ") WHERE DATE(ccb_added_on) = '" . $dataFrom .
                   "' AND ccb_callStatus_id != " . VB_CONNECTED . ") AS x GROUP BY x.ccb_callerNumber")->result_array(); */

               $salesPurchaseEnq = array(4, 6, 7, 8);
               $enquiry = $this->db->select('count(*) AS count')->where('DATE(vreg_added_on)', $dataFrom)
                    ->where_in('vreg_department', $salesPurchaseEnq)->get($this->tbl_register_master)->row_array();
               $data[$dataFrom]['salesPurchase'] = isset($enquiry['count']) ? $enquiry['count'] : 0;

               //Effective calls
               $qualified = $this->db->select('count(*) AS count')->where(array('DATE(vreg_added_on)' => $dataFrom, 'vreg_call_type' => 1))
                    ->get($this->tbl_register_master)->row_array();
               $data[$dataFrom]['effective'] = isset($qualified['count']) ? $qualified['count'] : 0;

               //teleCallers followup enquires
               $telecllers = $this->emp_details->teleCallers();
               $telecllers = array_column($telecllers, 'col_id');
               $folowup = $this->db->select('count(*) AS count')->where(array('DATE(foll_customer_feedback_added_date)' => $dataFrom))
                    ->get($this->tbl_followup)->row_array();
               $data[$dataFrom]['followup'] = isset($folowup['count']) ? $folowup['count'] : 0;

               //pending
               $pendingToCall = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $dataFrom)
                    ->where('ccb_callStatus_id != 0')->where('ccb_callStatus_id != ' . VB_CONNECTED)
                    ->where('ccb_punched_by', 0)->get($this->tbl_callcenterbridging)->result_array();
               $data[$dataFrom]['pendingToCall'] = !empty($pendingToCall) ? count($pendingToCall) : 0;

               $smryTotal = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $dataFrom)
                    ->where('ccb_callStatus_id', VB_CONNECTED)->get($this->tbl_callcenterbridging)->result_array();
               $data[$dataFrom]['smryTotal'] = !empty($smryTotal) ? count($smryTotal) : 0;

               $dataFrom = date("Y-m-d", strtotime("+1 day", strtotime($dataFrom)));
          }
          return $data;

          /* $assignedTo = $this->db->distinct()->select('qtr_assigned_to')->get($this->tbl_quick_tc_report)->result_array();
              $staffs = array_column($assignedTo, 'qtr_assigned_to');
              if (!empty($staffs)) {
              foreach ($staffs as $key => $value) {
              @$data[$value]['name'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
              ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
              ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->get($this->tbl_quick_tc_report)->row()->usr_username;

              @$data[$value]['total'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
              ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
              ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->get($this->tbl_quick_tc_report)->row()->count;

              @$data[$value]['called'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
              ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
              ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_reply_by > 0')->get($this->tbl_quick_tc_report)->row()->count;

              @$data[$value]['balance'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
              ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
              ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_reply_by', 0)->get($this->tbl_quick_tc_report)->row()->count;

              @$data[$value]['hot'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
              ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
              ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_type', 1)->get($this->tbl_quick_tc_report)->row()->count;

              @$data[$value]['warm'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
              ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
              ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_type', 2)->get($this->tbl_quick_tc_report)->row()->count;

              @$data[$value]['cold'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
              ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
              ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_type', 3)->get($this->tbl_quick_tc_report)->row()->count;

              @$data[$value]['efect'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
              ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
              ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_effective', 1)->get($this->tbl_quick_tc_report)->row()->count;

              @$data[$value]['infect'] = $this->db->select('qtr_assigned_to, count(*) AS count, ' . $this->tbl_users . '.usr_username')
              ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
              ->where('qtr_assigned_to', $value)->group_by('qtr_assigned_to')->where('qtr_effective', 0)->get($this->tbl_quick_tc_report)->row()->count;
              }
              }
              return $data; */
     }

     function telcalrPerformanceDeailReport($postDatas, $type, $date)
     {
          $type = strtolower(trim($type));
          if ($type == 'telein') {
               $draw = $postDatas['draw'];
               $row = $postDatas['start'];
               $rowperpage = $postDatas['length']; // Rows display per page
               $columnIndex = $postDatas['order'][0]['column']; // Column index
               $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
               $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
               $searchValue = $postDatas['search']['value']; // Search value

               $data = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $date)
                    ->where('ccb_callerNumber IS NOT NULL')->get($this->tbl_callcenterbridging)->result_array();
               $totalRecords = count($data);

               $this->db->like($this->tbl_callcenterbridging . '.ccb_callStatus', $searchValue, 'both');
               $totalRecordwithFilter = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $date)
                    ->where('ccb_callerNumber IS NOT NULL')->get($this->tbl_callcenterbridging)->result_array();
               $totalRecordwithFilter = count($totalRecordwithFilter);

               if (!empty($columnName) && !empty($columnSortOrder)) {
                    $this->db->order_by($columnName, $columnSortOrder);
               }
               $this->db->limit($rowperpage, $row);
               $this->db->like($this->tbl_callcenterbridging . '.ccb_callStatus', $searchValue, 'both');
               $data = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $date)
                    ->where('ccb_callerNumber IS NOT NULL')->get($this->tbl_callcenterbridging)->result_array();

               $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordwithFilter,
                    "aaData" => $data,
                    'hiden' => ''
               );
               return $response;
          }

          if ($type == 'teleinpending') {
               $draw = $postDatas['draw'];
               $row = $postDatas['start'];
               $rowperpage = $postDatas['length']; // Rows display per page
               $columnIndex = $postDatas['order'][0]['column']; // Column index
               $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
               $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
               $searchValue = $postDatas['search']['value']; // Search value

               $data = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $date)
                    ->where('ccb_callStatus_id != 0')->where('ccb_callStatus_id != ' . VB_CONNECTED)
                    ->where('ccb_punched_by', 0)->get($this->tbl_callcenterbridging)->result_array();
               $totalRecords = count($data);

               $this->db->like($this->tbl_callcenterbridging . '.ccb_callStatus', $searchValue, 'both');
               $totalRecordwithFilter = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $date)
                    ->where('ccb_callStatus_id != 0')->where('ccb_callStatus_id != ' . VB_CONNECTED)
                    ->where('ccb_punched_by', 0)->get($this->tbl_callcenterbridging)->result_array();
               $totalRecordwithFilter = count($totalRecordwithFilter);

               if (!empty($columnName) && !empty($columnSortOrder)) {
                    $this->db->order_by($columnName, $columnSortOrder);
               }
               $this->db->limit($rowperpage, $row);
               $this->db->like($this->tbl_callcenterbridging . '.ccb_callStatus', $searchValue, 'both');
               $data = $this->db->distinct()->select('ccb_callerNumber')->where('DATE(ccb_added_on)', $date)
                    ->where('ccb_callStatus_id != 0')->where('ccb_callStatus_id != ' . VB_CONNECTED)
                    ->where('ccb_punched_by', 0)->get($this->tbl_callcenterbridging)->result_array();

               $response = array(
                    "draw" => intval($draw),
                    "iTotalRecords" => $totalRecords,
                    "iTotalDisplayRecords" => $totalRecordwithFilter,
                    "aaData" => $data,
                    'hiden' => ''
               );
               return $response;
          }
     }

     function getAllShowrooms()
     {
          return $this->db->get('cpnl_blogs')->result_array();
     }

     function getLastFollowup($enqId)
     {
          return $this->db->select('foll_remarks, foll_entry_date')->order_by('foll_id', 'DESC')
               ->limit(1)->get_where($this->tbl_followup, array('foll_cus_id' => $enqId, 'foll_is_cmnt' => 0))->row_array();
     }

     function getLastFollowupDate($enqId)
     {
          return $this->db->select('foll_entry_date, foll_budget_from, foll_budget_to')->where(array('foll_cus_id' => $enqId, 'foll_is_cmnt' => 0))
               ->order_by('foll_id', 'DESC')->limit(1)->get($this->tbl_followup)->row_array();
     }

     function getFollowupBudget($enqId)
     {
          return $this->db->select('foll_entry_date, foll_budget_from, foll_budget_to')
               ->where(array('foll_cus_id' => $enqId, 'foll_is_cmnt' => 0))->or_where(array('foll_budget_from > ' => '0', 'foll_budget_to > ' => '0'))
               ->order_by('foll_id', 'DESC')->limit(1)->get($this->tbl_followup)->row_array();
     }

     function getLastFollowupCustomerRemark($enqId)
     {
          return $this->db->select('foll_customer_feedback')
               ->where(array('foll_cus_id' => $enqId, 'foll_is_cmnt' => 0, 'foll_customer_feedback !=' => 'NULL'))
               ->order_by('foll_id', 'DESC')->limit(1)->get($this->tbl_followup)->row_array();
     }

     function getVehicleDetails($enqId)
     {

          $vehicleDetails = $this->db->query("SELECT GROUP_CONCAT( IF(" . $this->tbl_vehicle . ".veh_brand=0, '', " . $this->tbl_brand . ".brd_title) , "
               . "IF(" . $this->tbl_vehicle . ".veh_model=0, '', " . $this->tbl_model . ".mod_title) , IF(" .
               $this->tbl_vehicle . ".veh_varient=0, '', " . $this->tbl_variant . ".var_variant_name)) AS vehicle "
               . "FROM " . $this->tbl_vehicle . " LEFT JOIN " . $this->tbl_brand . " ON " . $this->tbl_brand . ".brd_id = " . $this->tbl_vehicle . ".veh_brand "
               . "LEFT JOIN " . $this->tbl_model . " ON " . $this->tbl_model . ".mod_id = " . $this->tbl_vehicle . ".veh_model "
               . "LEFT JOIN " . $this->tbl_variant . " ON " . $this->tbl_variant . ".var_id = " . $this->tbl_vehicle . ".veh_varient "
               . "WHERE " . $this->tbl_vehicle . ".veh_enq_id = " . $enqId)->row_array();

          return isset($vehicleDetails['vehicle']) ? $vehicleDetails['vehicle'] : '';
     }

     function getVehicleInformation($enqId)
     {
          $selectArray = array(
               $this->tbl_vehicle . '.veh_exch_cus_expect',
               $this->tbl_vehicle . '.veh_color'
          );
          return $this->db->select($selectArray)->where(array($this->tbl_vehicle . ".veh_enq_id" => $enqId))->get($this->tbl_vehicle)->result_array();
     }

     function registerPendingByUser()
     {
          $mystaff = array();
          if ($this->desi == 'SH') {
               $mystaff = my_staff($this->uid);
          }
          //$this->tbl_groups . '.grp_slug' => 'TC', 
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop . ',' . enq_lost . ',' . enq_droped . ',' . enq_verfd_close;
          $selectArray = array(
               $this->tbl_register_master . '.vreg_assigned_to',
               $this->tbl_register_master . '.vreg_added_by',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'assign.usr_id AS assign_usr_id',
               'assign.usr_active AS assign_usr_active',
               $this->tbl_enquiry . '.enq_current_status',
               'COUNT(*) AS cnt', $this->tbl_users_groups . '.*',
               $this->tbl_groups . '.*',
               $this->tbl_designation . '.desig_title'
          );
          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
          $date = date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 days'));
          $this->db->where_not_in('vreg_contact_mode', array(40));
          /*
          5	Sales Head
          6    ASM
          9	Team Cooridnator
          11	Area Manager - Sales
          12	Sr. Sales Consultant
          14   Tele callers
          18	Sales Consultant
          22	Purchase Manager
          24	Assistant Manager Purchase
          35	Purchase Executive
          38	MIS Coordinator
          40	Area Manager - Purchase
          43   Tele sales Cooridnator
          56	Divisional Manager
          59	Tele Purchase Coordinator
          60	Manager - Sales & Purchase Luxury Bikes
          69	Sr. Purchase Executive
          */
          if ($this->desi == 'SH') {
               $this->db->where_in('assign.usr_id', $mystaff);
          } else {
               $designation = array(5, 6, 9, 11, 12, 18, 22, 24, 35, 38, 40, 56, 58, 59, 60, 64, 69, 43, 14, 79);
               $this->db->where_in($this->tbl_designation . ".desig_id", $designation);
          }

          $return['yesterday'] = $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = assign.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . 'assign.usr_designation_new', 'LEFT')
               ->where(array('assign.usr_active' => 1, 'assign.usr_resigned' => 0))
               ->where('DATE(' . $this->tbl_register_master . '.vreg_entry_date) <=', $date)
               ->group_by('vreg_assigned_to')->where('(vreg_is_punched = 0)')->get($this->tbl_register_master)->result_array();

          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
          $this->db->where_not_in('vreg_contact_mode', array(40));

          if ($this->desi == 'SH') {
               $this->db->where_in('assign.usr_id', $mystaff);
          } else {
               $designation = array(5, 6, 9, 11, 12, 18, 22, 24, 35, 38, 40, 56, 58, 59, 60, 64, 69, 43, 14);
               $this->db->where_in($this->tbl_designation . ".desig_id", $designation);
          }
          $return['today'] = $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = assign.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . 'assign.usr_designation_new', 'LEFT')
               ->where(array('assign.usr_active' => 1, 'assign.usr_resigned' => 0))
               ->group_by('vreg_assigned_to')->where('(vreg_is_punched = 0)')->get($this->tbl_register_master)->result_array();
          return $return;
     }

     function registerPendingByUserDetails($user, $yesterday = 1)
     {
          //$this->tbl_groups . '.grp_slug' => 'TC', 
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
          $selectArray = array(
               $this->tbl_register_master . '.vreg_assigned_to',
               $this->tbl_register_master . '.vreg_added_by',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               'owner.usr_first_name AS ownedby_usr_first_name',
               'owner.usr_last_name AS ownedby_usr_last_name',
               $this->tbl_enquiry . '.enq_current_status',
               $this->tbl_users_groups . '.*',
               $this->tbl_groups . '.*',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id', $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id', $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',
               'vreg_status,vreg_is_effective,vreg_entry_date,vreg_cust_name,vreg_id,vreg_cust_phone,vreg_cust_place,vreg_contact_mode,vreg_added_on,vreg_customer_remark'
          );
          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
          //if (check_permission('registration', 'not_show_visitors_in_myregister')) {
          $this->db->where_not_in('vreg_contact_mode', array(40));
          //}
          if ($yesterday) {
               $date = date('Y-m-d', strtotime(date('Y-m-d') . ' - 1 days'));
               return $this->db->select($selectArray, false)
                    ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                    ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                    ->join($this->tbl_users . ' owner', 'owner.usr_id = ' . $this->tbl_register_master . '.vreg_first_owner', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = assign.usr_id', 'LEFT')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
                    ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                    ->where('DATE(' . $this->tbl_register_master . '.vreg_entry_date) <=', $date)
                    ->where('vreg_assigned_to', $user)->where('(vreg_is_punched = 0)')->get($this->tbl_register_master)->result_array();
          }
          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
          return $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_users . ' owner', 'owner.usr_id = ' . $this->tbl_register_master . '.vreg_first_owner', 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = assign.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->where('vreg_assigned_to', $user)->where('(vreg_is_punched = 0)')->get($this->tbl_register_master)->result_array();
     }

     function exceldownload()
     {
          return $this->db->select($this->tbl_general_log . '.*,' . $this->tbl_users . '.usr_username')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_general_log . '.log_added_by', 'LEFT')
               ->like('log_controller', 'exp-excel', 'after')->get($this->tbl_general_log)->result_array();
     }

     function filterinquires($limit = 0, $page = 0, $data)
     {

          if (isset($data['currentstatus']) && !empty($data['currentstatus'])) {
               $data['currentstatus'] = explode(',', $data['currentstatus']);
          }

          $mystaffs = array();
          if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $this->uid);
          }
          $showroom = get_logged_user('usr_showroom');

          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }
          if (isset($data['dist']) && !empty($data['dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $data['dist']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (!empty($data['currentstatus']) && !in_array(1, $data['currentstatus'])) {
               if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
                    $date = date('Y-m-d', strtotime($data['enq_date_from']));
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $date);
                    $this->db->order_by($this->tbl_enquiry_history . '.enh_added_on');
               }
               if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
                    $date = date('Y-m-d', strtotime($data['enq_date_to']));
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $date);
               }
          } else {
               if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
                    $date = date('Y-m-d', strtotime($data['enq_date_from']));
                    $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
                    $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
               }
               if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
                    $date = date('Y-m-d', strtotime($data['enq_date_to']));
                    $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
               }
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }
          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }
          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL' && empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }

          $select = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_whatsapp',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_cus_status',
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_showroom . '.*',
               $this->tbl_enquiry . '.enq_next_foll_date',
               $this->tbl_enquiry_history . '.*',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des'
               //$this->tbl_register_master . '.vreg_inquiry',
               //$this->tbl_register_master . '.vreg_cust_name',
               //$this->tbl_register_master . '.vreg_cust_phone',
               //$this->tbl_register_master . '.vreg_contact_mode'
          );
          if (isset($data['isMissedFollowup']) && $data['isMissedFollowup'] == 1) {
               $this->db->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)');
          }
          if (!empty($data['currentstatus'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $data['currentstatus']);
          } else {
               //$this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          }
          $return['count'] = count($this->db->select($select)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')

               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' .
                    $this->tbl_enquiry . ".enq_current_status AND (sts_category = 'vehicle' OR sts_category = 'enquiry')", 'LEFT')

               //->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_inquiry = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_enquiry)->result_array());

          //echo $this->db->last_query() . '<br><br><br>';
          /* Data */
          if (isset($data['mode']) && !empty($data['mode'])) {
               $this->db->where($this->tbl_enquiry . '.enq_mode_enq', $data['mode']);
          }
          if (isset($data['dist']) && !empty($data['dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $data['dist']);
          }
          if (isset($data['showroom']) && !empty($data['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $data['showroom']);
          }

          if (isset($data['executive']) && !empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $data['executive']);
          }
          if (!empty($data['currentstatus']) && !in_array(1, $data['currentstatus'])) {
               if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
                    $date = date('Y-m-d', strtotime($data['enq_date_from']));
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $date);
                    $this->db->order_by($this->tbl_enquiry_history . '.enh_added_on');
               }
               if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
                    $date = date('Y-m-d', strtotime($data['enq_date_to']));
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $date);
               }
          } else {
               if (isset($data['enq_date_from']) && !empty($data['enq_date_from'])) {
                    $date = date('Y-m-d', strtotime($data['enq_date_from']));
                    $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) >=', $date);
                    $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
               }
               if (isset($data['enq_date_to']) && !empty($data['enq_date_to'])) {
                    $date = date('Y-m-d', strtotime($data['enq_date_to']));
                    $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) <=', $date);
               }
          }

          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }
          if (isset($data['type']) && !empty($data['type'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_status', $data['type']);
          }
          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL' && empty($data['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }

          $select = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_whatsapp',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_by',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_cus_status',
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_showroom . '.*',
               $this->tbl_enquiry . '.enq_next_foll_date',
               $this->tbl_enquiry_history . '.*',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des'
               //$this->tbl_register_master . '.vreg_inquiry',
               //$this->tbl_register_master . '.vreg_cust_name',
               //$this->tbl_register_master . '.vreg_cust_phone',
               //$this->tbl_register_master . '.vreg_contact_mode'
          );
          if (isset($data['isMissedFollowup']) && $data['isMissedFollowup'] == 1) {
               $this->db->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)');
          }
          if (!empty($data['currentstatus'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $data['currentstatus']);
          } else {
               //$this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          }
          $return['data'] = $this->db->select($select)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')

               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' .
                    $this->tbl_enquiry . ".enq_current_status AND (sts_category = 'vehicle' OR sts_category = 'enquiry')", 'LEFT')

               //->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_inquiry = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_enquiry)->result_array();
          //echo $this->db->last_query();
          //exit;
          return $return;
     }

     function getDeliveredvehicles($limit = 0, $page = 0)
     {
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);
          array_push($mystaffs, $this->uid);


          $showroom = get_logged_user('usr_showroom');
          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') { // Seles executives
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          $this->db->where($this->tbl_enquiry . '.enq_current_status', book_delvry);
          $return['count'] = $this->db->count_all_results($this->tbl_enquiry);

          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
          } else if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') { // Seles executives
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_contact_mode . '.*,' .
               $this->tbl_enquiry_history . '.*,' . $this->tbl_valuation . '.val_id,' .
               $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' .
               $this->tbl_valuation . '.val_veh_no,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*,' . $this->tbl_variant . '.*')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_enquiry . '.enq_mode_enq', 'LEFT')
               ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_enquiry_history . '.enh_booked_vehicle', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->where($this->tbl_enquiry . '.enq_current_status', book_delvry);

          $return['data'] = $this->db->get($this->tbl_enquiry)->result_array();
          return $return;
     }

     function getEnquiries($filterData = '')
     {
          $this->db->select('veh_enq_id,veh_id,veh_year,veh_varient,veh_model,veh_brand,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.var_variant_name, ' . $this->tbl_model . '.mod_title')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
          $this->db->from($this->tbl_vehicle);
          $this->db->group_by(array($this->tbl_vehicle . '.veh_year', $this->tbl_vehicle . '.veh_varient'));
          $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
          if (isset($filterData['km']) && !empty($filterData['km'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_km_id', $filterData['km']);
          }
          if (isset($filterData['year']) && !empty($filterData['year'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_year', $filterData['year']);
          }
          if (isset($filterData['val_brand']) && !empty($filterData['val_brand'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_brand', $filterData['val_brand']);
          }
          if (isset($filterData['val_model']) && !empty($filterData['val_model'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_model', $filterData['val_model']);
          }
          if (isset($filterData['val_variant']) && !empty($filterData['val_variant'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_varient', $filterData['val_variant']);
          }
          $query = $this->db->get();
          $res = $query->result_array();
          return $res;
     }

     function getEnquiries_BK_LST($filterData = '')
     {

          $this->db->select('veh_enq_id,veh_id,veh_year,veh_varient,veh_model,veh_brand,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.var_variant_name, ' . $this->tbl_model . '.mod_title')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
          $this->db->from($this->tbl_vehicle);
          $this->db->group_by(array($this->tbl_vehicle . '.veh_year', $this->tbl_vehicle . '.veh_varient'));
          // $this->db->order_by($this->tbl_vehicle . '.veh_year desc');
          $this->db->where($this->tbl_vehicle . '.veh_status =', 1); //veh_year
          if (!empty($filterData && $filterData['km'])) {
               $this->db->where($this->tbl_vehicle . '.veh_km_id =', $filterData['km']);
          }
          $query = $this->db->get();
          $res = $query->result_array();
          return $res;
     }

     function getEnquiries_BK($filterData = '')
     {

          $this->db->select('veh_enq_id,veh_id,veh_year,veh_varient,veh_model,veh_brand,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.var_variant_name, ' . $this->tbl_model . '.mod_title')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
          $this->db->from($this->tbl_vehicle);
          $this->db->group_by(array($this->tbl_vehicle . '.veh_year', $this->tbl_vehicle . '.veh_varient'));
          $this->db->where($this->tbl_vehicle . '.veh_status =', 1); //veh_year
          if (!empty($filterData && $filterData['km'])) {
               //return $filterData['km'];
               $this->db->where($this->tbl_vehicle . '.veh_km_id =', $filterData['km']);
          }
          $query = $this->db->get();
          $res = $query->result_array();
          return $res;
     }

     function getMod_Yr_range($Variant_id)
     {
          if ($Variant_id) {
               $this->db->select('MIN(veh_year) as min_year,MAX(veh_year) as max_year');
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $Variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
               $query = $this->db->get($this->tbl_vehicle);
               $years = $query->result_array();
               return ($years[0]['min_year'] == $years[0]['max_year']) ? $years[0]['min_year'] : $years[0]['min_year'] . ' - ' . $years[0]['max_year'];
          }
          return false;
     }

     function getDataCount($Variant_id, $modl_year)
     { //dd($Variant_id);
          if ($Variant_id && $modl_year) {
               $this->db->select('veh_enq_id');
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $Variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               // print_r (explode(" ",$str));
               // $aaj = array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               //->where($this->tbl_vehicle . '.veh_status =', 1) add this cndn
               $data['hot_plus'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 1)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['hot'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 2)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['warm'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 3)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['cold'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 4)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['dropCount'] = $this->db->where("(enq_current_status = 3 or enq_current_status = 2) ")
                    ->where_in('enq_id', $enqIDs)->count_all_results($this->tbl_enquiry);
               //$data['enqIDs'] = json_encode($enqIDs);
               $this->db->select('veh_enq_id'); //get purchase record
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $Variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 2);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               $data['purchase_count'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_current_status', 1)->where('enq_cus_status =', 2)->count_all_results($this->tbl_enquiry);
               return $data;
          }
          return false;
     }

     function getDataCountForGrpByModel($model_id, $modl_year)
     {
          if ($model_id && $modl_year) {
               $this->db->select('veh_enq_id');
               $this->db->where($this->tbl_vehicle . '.veh_model =', $model_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               // print_r (explode(" ",$str));
               // $aaj = array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               //->where($this->tbl_vehicle . '.veh_status =', 1) add this cndn
               $data['hot_plus'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 1)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['hot'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 2)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['warm'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 3)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['cold'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 4)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['dropCount'] = $this->db->where("(enq_current_status = 3 or enq_current_status = 2) ")
                    ->where_in('enq_id', $enqIDs)->count_all_results($this->tbl_enquiry);
               //$data['enqIDs'] = json_encode($enqIDs);
               $this->db->select('veh_enq_id'); //get purchase record
               $this->db->where($this->tbl_vehicle . '.veh_model =', $model_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 2);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               $data['purchase_count'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_current_status', 1)->where('enq_cus_status =', 2)->count_all_results($this->tbl_enquiry);
               return $data;
          }
          return false;
     }

     function getDataCountForGrpByvariant($Variant_id, $modl_year)
     {
          // dd($Variant_id);
          //exit;
          if ($Variant_id && $modl_year) {
               $this->db->select('veh_enq_id');
               $this->db->where_in($this->tbl_vehicle . '.veh_varient', $Variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year=', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               // print_r (explode(" ",$str));
               // $aaj = array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               //->where($this->tbl_vehicle . '.veh_status =', 1) add this cndn
               $data['hot_plus'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 1)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['hot'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 2)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['warm'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 3)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['cold'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 4)->where('enq_current_status', 1)->count_all_results($this->tbl_enquiry);
               $data['dropCount'] = $this->db->where("(enq_current_status = 3 or enq_current_status = 2) ")
                    ->where_in('enq_id', $enqIDs)->count_all_results($this->tbl_enquiry);
               //$data['enqIDs'] = json_encode($enqIDs);
               $this->db->select('veh_enq_id'); //get purchase record
               $this->db->where_in($this->tbl_vehicle . '.veh_varient ', $Variant_id);
               $this->db->where_in($this->tbl_vehicle . '.veh_year ', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status ', 2);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               $data['purchase_count'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_current_status', 1)->where('enq_cus_status =', 2)->count_all_results($this->tbl_enquiry);
               return $data;
          }
          return false;
     }

     function getDataCount_BK($Variant_id, $modl_year)
     {
          if ($Variant_id && $modl_year) {
               $this->db->select('veh_enq_id');
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $Variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               // print_r (explode(" ",$str));
               // $aaj = array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               //->where($this->tbl_vehicle . '.veh_status =', 1) add this cndn
               $data['hot_plus'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 1)->count_all_results($this->tbl_enquiry);
               $data['hot'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 2)->count_all_results($this->tbl_enquiry);
               $data['warm'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 3)->count_all_results($this->tbl_enquiry);
               $data['cold'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 4)->count_all_results($this->tbl_enquiry);
               $data['dropCount'] = $this->db->where("(enq_current_status = 3 or enq_current_status = 2) ")
                    ->where_in('enq_id', $enqIDs)->count_all_results($this->tbl_enquiry);
               //$data['enqIDs'] = json_encode($enqIDs);
               $this->db->select('veh_enq_id'); //get purchase record
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $Variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 2);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               $data['purchase_count'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_current_status', 1)->where('enq_cus_status =', 2)->count_all_results($this->tbl_enquiry);
               return $data;
          }
          return false;
     }

     function getDetailsByVariant($variant_id = '', $modl_yr = '')
     {
          if ($variant_id && $modl_yr) {
               $this->db->select('veh_enq_id,veh_id,veh_year,veh_varient,veh_model,veh_brand,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant .
                    '.var_variant_name, ' . $this->tbl_model . '.mod_title')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
               $this->db->from($this->tbl_vehicle);
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_yr);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
               $query = $this->db->get();
               $res['vehicle_details'] = $query->row_array(); //fetch vehicle details  
               $this->db->select('veh_km_id,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant .
                    '.var_variant_name, ' . $this->tbl_model . '.mod_title,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' .
                    $this->tbl_enquiry . '.enq_se_id AS salesExictvID,' . $this->tbl_enquiry . '.enq_cus_when_buy')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id  = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
               $this->db->from($this->tbl_vehicle);
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_yr);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
               // $this->db->where("(".$this->tbl_enquiry.".enq_current_status != 3 or ".$this->tbl_enquiry.".enq_current_status != 2) ");
               $this->db->where($this->tbl_enquiry . '.enq_current_status =', 1);
               $query = $this->db->get();
               $res['sale'] = $query->result_array(); //fetch sale enquiry
               $this->db->select('veh_km_id,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant .
                    '.var_variant_name, ' . $this->tbl_model . '.mod_title,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' .
                    $this->tbl_enquiry . '.enq_se_id AS salesExictvID,' . $this->tbl_enquiry . '.enq_cus_when_buy')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id  = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
               $this->db->from($this->tbl_vehicle);
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_yr);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 2);
               $this->db->where($this->tbl_enquiry . '.enq_current_status =', 1);
               //  $this->db->where("(".$this->tbl_enquiry.".enq_current_status != 3 or ".$this->tbl_enquiry.".enq_current_status != 2) ");
               $query = $this->db->get();
               $res['purchase'] = $query->result_array(); //fetch purchase enquiry
               return $res;
          }
          return false;
     }

     function getSalesEctvName($user_id = '')
     {
          $this->db->select('usr_username');
          return $this->db->where(array('usr_id' => $user_id))->get($this->tbl_users)->row();
     }

     function getEnquiriesGrpByModel($filterData = '')
     {
          $this->db->select('veh_enq_id,veh_id,veh_year,veh_model,veh_brand,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT');
          $this->db->from($this->tbl_vehicle);
          $this->db->group_by(array($this->tbl_vehicle . '.veh_year', $this->tbl_vehicle . '.veh_model'));
          $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
          if (isset($filterData['km']) && !empty($filterData['km'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_km_id', $filterData['km']);
          }
          if (isset($filterData['year']) && !empty($filterData['year'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_year', $filterData['year']);
          }
          if (isset($filterData['val_brand']) && !empty($filterData['val_brand'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_brand', $filterData['val_brand']);
          }
          if (isset($filterData['val_model']) && !empty($filterData['val_model'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_model', $filterData['val_model']);
          }
          if (isset($filterData['val_variant']) && !empty($filterData['val_variant'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_varient', $filterData['val_variant']);
          }
          return $this->db->get()->result_array();
     }

     function getEnquiriesPagination($filterData = '')
     {
          $this->db->select('veh_enq_id,veh_id,veh_year,veh_varient,veh_model,veh_brand,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.var_variant_name, ' . $this->tbl_model . '.mod_title')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
          $this->db->from($this->tbl_vehicle);
          $this->db->group_by(array($this->tbl_vehicle . '.veh_year', $this->tbl_vehicle . '.veh_varient'));
          $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
          if (isset($filterData['km']) && !empty($filterData['km'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_km_id', $filterData['km']);
          }
          if (isset($filterData['year']) && !empty($filterData['year'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_year', $filterData['year']);
          }
          if (isset($filterData['val_brand']) && !empty($filterData['val_brand'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_brand', $filterData['val_brand']);
          }
          if (isset($filterData['val_model']) && !empty($filterData['val_model'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_model', $filterData['val_model']);
          }
          if (isset($filterData['val_variant']) && !empty($filterData['val_variant'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_varient', $filterData['val_variant']);
          }
          $query = $this->db->get();
          $res = $query->result_array();
          return $res;
     }

     function make_query()
     {
          $this->db->select('veh_enq_id,veh_id,veh_year,veh_varient,veh_model,veh_brand,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.var_variant_name, ' . $this->tbl_model . '.mod_title')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
          $this->db->from($this->tbl_vehicle);
          $this->db->group_by(array($this->tbl_vehicle . '.veh_year', $this->tbl_vehicle . '.veh_varient'));
          $this->db->where($this->tbl_vehicle . '.veh_status =', 1);

          if (isset($_POST["search"]["value"])) {
               $this->db->like("first_name", $_POST["search"]["value"]);
               $this->db->or_like("last_name", $_POST["search"]["value"]);
          }
          if (isset($_POST["order"])) {
               $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
          } else {
               $this->db->order_by('id', 'DESC');
          }
     }

     function make_datatables()
     {
          $this->make_query();
          if ($_POST["length"] != -1) {
               $this->db->limit($_POST['length'], $_POST['start']);
          }
          $query = $this->db->get();
          return $query->result();
     }

     function get_filtered_data()
     {
          $this->make_query();
          $query = $this->db->get();
          return $query->num_rows();
     }

     function get_all_data()
     {
          $this->db->select("*");
          $this->db->from($this->tbl_vehicle);
          return $this->db->count_all_results();
     }

     function getDataCount_detail_pg($Variant_id, $modl_year)
     {
          if ($Variant_id && $modl_year) {
               $this->db->select('veh_enq_id');
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $Variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               //->where($this->tbl_vehicle . '.veh_status =', 1) add this cndn
               $data['hot_plus'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 1)->count_all_results($this->tbl_enquiry);
               $data['hot'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 2)->count_all_results($this->tbl_enquiry);
               $data['warm'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 3)->count_all_results($this->tbl_enquiry);
               $data['cold'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_cus_when_buy', 4)->count_all_results($this->tbl_enquiry);
               $data['dropCount'] = $this->db->where("(enq_current_status = 3 or enq_current_status = 2) ")
                    ->where_in('enq_id', $enqIDs)->count_all_results($this->tbl_enquiry);
               $this->db->select('veh_enq_id'); //get purchase record
               $this->db->where($this->tbl_vehicle . '.veh_varient =', $Variant_id);
               $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_year);
               $this->db->where($this->tbl_vehicle . '.veh_status =', 2);
               $query = $this->db->get($this->tbl_vehicle);
               $results = $query->result_array();
               foreach ($results as $key => $result) {
                    $enqIDs[] = $result['veh_enq_id'];
               }
               $data['purchase_count'] = $this->db->where_in('enq_id', $enqIDs)->where('enq_current_status', 1)->where('enq_cus_status =', 2)->count_all_results($this->tbl_enquiry);
               return $data;
          }
          return false;
     }

     function getEnquiriesForPooll($filterData = '', $limit = 4, $start = 0, $date_filter = '')
     {
          $sale_date_from = '';
          $sale_date_to = date('y-m-d');
          if (@$date_filter['sales_date_from']) {

               $sale_date_from = date("Y-m-d", strtotime($date_filter['sales_date_from']));
          }
          if (@$date_filter['sales_date_to']) {
               $sale_date_to = date("Y-m-d", strtotime($date_filter['sales_date_to']));
          }
          $this->db->select('veh_enq_id,veh_brand,veh_model,veh_varient,veh_year,cpnl_enquiry.enq_entry_date,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.var_variant_name, ' . $this->tbl_model . '.mod_title,'
               . $this->tbl_enquiry . '.enq_id ,' . 'COUNT(CASE WHEN cpnl_enquiry.enq_cus_when_buy = 1 AND cpnl_enquiry.enq_current_status = 1 THEN cpnl_enquiry.enq_cus_when_buy
    END) as hot_plus,
COUNT(CASE WHEN cpnl_enquiry.enq_cus_when_buy = 2 AND cpnl_enquiry.enq_current_status = 1 THEN cpnl_enquiry.enq_cus_when_buy
    END) as hot, 
    COUNT(CASE WHEN cpnl_enquiry.enq_cus_when_buy = 3 AND cpnl_enquiry.enq_current_status = 1 THEN cpnl_enquiry.enq_cus_when_buy
    END) as warm,
    COUNT(CASE WHEN cpnl_enquiry.enq_cus_when_buy = 4 AND cpnl_enquiry.enq_current_status = 1 THEN cpnl_enquiry.enq_cus_when_buy
    END) as cold,
    COUNT(
    CASE WHEN cpnl_enquiry.enq_current_status = 3 OR cpnl_enquiry.enq_current_status = 2 THEN cpnl_enquiry.enq_cus_when_buy
END
) AS dropCount,

')->join('cpnl_enquiry', 'cpnl_enquiry.enq_id = cpnl_vehicle.veh_enq_id', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
          $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
          $this->db->where($this->tbl_vehicle . '.veh_varient !=', '');
          $this->db->where($this->tbl_enquiry . '.enq_entry_date >=', $sale_date_from)->where($this->tbl_enquiry . '.enq_entry_date <=', $sale_date_to);
          //  $this->db->where($this->tbl_enquiry . '.enq_entry_date >=', $sale_date_from)->where($this->tbl_enquiry . '.enq_entry_date <=', $sale_date_to);
          $this->db->group_by(array($this->tbl_vehicle . '.veh_year', $this->tbl_vehicle . '.veh_varient'));
          if (isset($filterData['km']) && !empty($filterData['km'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_km_id', $filterData['km']);
          }
          if (isset($filterData['year']) && !empty($filterData['year'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_year', $filterData['year']);
          }
          if (isset($filterData['val_brand']) && !empty($filterData['val_brand'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_brand', $filterData['val_brand']);
          }
          if (isset($filterData['val_model']) && !empty($filterData['val_model'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_model', $filterData['val_model']);
          }
          if (isset($filterData['val_variant']) && !empty($filterData['val_variant'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_varient', $filterData['val_variant']);
          }
          $this->db->from('cpnl_vehicle');
          $this->db->order_by('hot_plus', "desc");
          $this->db->limit($limit, $start);
          $query = $this->db->get();
          $res = $query->result_array();
          return $res;
     }

     function getPurchaseCount($Variant_id, $modl_year, $date_filter = '', $filterData = '')
     {
          $purchase_date_from = '';
          $purchase_date_to = date('y-m-d');
          if (@$date_filter['purchase_date_from']) {

               $purchase_date_from = date("Y-m-d", strtotime($date_filter['purchase_date_from']));
          }
          if (@$date_filter['purchase_date_to']) {
               $purchase_date_to = date("Y-m-d", strtotime($date_filter['purchase_date_to']));
          }
          $this->db->where($this->tbl_vehicle . '.veh_varient =', $Variant_id);
          $this->db->where($this->tbl_vehicle . '.veh_year =', $modl_year)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id  = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT');
          $this->db->where($this->tbl_enquiry . '.enq_entry_date >=', $purchase_date_from)->where($this->tbl_enquiry . '.enq_entry_date <=', $purchase_date_to);
          $data['purchase_count'] = $this->db->where($this->tbl_vehicle . '.veh_status =', 2)->count_all_results($this->tbl_vehicle);
          return $data;
     }

     function getEnquiriesCount($filterData = '', $date_filter = '')
     {
          $sale_date_from = date('Y-m-d', strtotime('-1000000000000 days'));
          $sale_date_to = date('y-m-d');
          if (@$date_filter['sales_date_from']) {

               $sale_date_from = date("Y-m-d", strtotime($date_filter['sales_date_from']));
          }
          if (@$date_filter['sales_date_to']) {
               $sale_date_to = date("Y-m-d", strtotime($date_filter['sales_date_to']));
          }
          $this->db->select('veh_enq_id,veh_id,veh_year,veh_varient,veh_model,veh_brand,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.var_variant_name, ' . $this->tbl_model . '.mod_title')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id  = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT');
          $this->db->from($this->tbl_vehicle);
          $this->db->group_by(array($this->tbl_vehicle . '.veh_year', $this->tbl_vehicle . '.veh_varient'));
          $this->db->where($this->tbl_vehicle . '.veh_status =', 1);
          if (isset($filterData['km']) && !empty($filterData['km'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_km_id', $filterData['km']);
          }
          if (isset($filterData['year']) && !empty($filterData['year'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_year', $filterData['year']);
          }
          if (isset($filterData['val_brand']) && !empty($filterData['val_brand'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_brand', $filterData['val_brand']);
          }
          if (isset($filterData['val_model']) && !empty($filterData['val_model'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_model', $filterData['val_model']);
          }
          if (isset($filterData['val_variant']) && !empty($filterData['val_variant'])) {
               $this->db->where_in($this->tbl_vehicle . '.veh_varient', $filterData['val_variant']);
          }
          $this->db->where($this->tbl_enquiry . '.enq_entry_date >=', $sale_date_from)->where($this->tbl_enquiry . '.enq_entry_date <=', $sale_date_to);
          $query = $this->db->get();
          $res = $query->num_rows();
          return $res;
     }

     function getMyStaffs()
     {
          return $this->db->where('usr_tl', $this->uid)->or_where('usr_id', $this->uid)->get($this->tbl_users)->result_array();
     }

     function quickAssignMaster($data)
     {
          $data['executive'] = isset($data['executive']) ? serialize($data['executive']) : '';
          $this->db->insert($this->tbl_quick_tc_report_master, array(
               'qtrm_title' => $data['desc'],
               'qtrm_added_by' => $this->uid,
               'qtrm_added_on' => date('Y-m-d H:i:s'),
               'qtrm_assign_to' => $data['executive']
          ));
          $id = $this->db->insert_id();
          generate_log(array(
               'log_title' => 'Quick enquiry assigned master',
               'log_desc' => serialize($data),
               'log_controller' => 'quick-assign-master',
               'log_action' => 'C',
               'log_ref_id' => $id,
               'log_added_by' => $this->uid
          ));
          return $id;
     }

     function getQuickFollowupMaster()
     {
          return $this->db->select($this->tbl_quick_tc_report_master . '.*, ' . $this->tbl_users . '.usr_username')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report_master . '.qtrm_added_by', 'LEFT')
               ->where($this->tbl_quick_tc_report_master . '.qtrm_status', 1)->get($this->tbl_quick_tc_report_master)->result_array();
     }

     function getStatusDetails($status)
     {
          return $this->db->get_where($this->tbl_statuses, array('sts_value' => $status))->row_array();
     }



     function pbxDailyCalls()
     {
          $today = date('Y-m-d');
          $todayCalls['total'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id > ' => 0
          ))->result_array(); //18

          $todayCalls['connected'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id' => VB_CONNECTED
          ))->result_array(); //18

          $todayCalls['noanswer'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id' => VB_NOANSWER
          ))->result_array(); //23

          $todayCalls['cancel'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id' => VB_CANCEL
          ))->result_array(); //19

          $todayCalls['notconnected'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id' => VB_NOT_CONNECTED
          ))->result_array(); //24

          $todayCalls['chanlunavl'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id' => VB_CHANUNAVAIL
          ))->result_array(); //21

          $todayCalls['congestion'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id' => VB_CONGESTION
          ))->result_array(); //23

          $todayCalls['busy'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id' => VB_BUSY
          ))->result_array(); //23

          //DID based
          //914847136855
          $todayCalls['did1'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id > ' => 0, 'ccb_calledNumber' => '914847136855'
          ))->result_array(); //18

          //914847136856
          $todayCalls['did2'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id > ' => 0, 'ccb_calledNumber' => '914847136856'
          ))->result_array(); //18

          //914847136682
          $todayCalls['did3'] = $this->db->get_where($this->tbl_callcenterbridging, array(
               'DATE(ccb_callDate)' => $today,
               'ccb_callStatus_id > ' => 0, 'ccb_calledNumber' => '914847136682'
          ))->result_array(); //18

          return $todayCalls;
     }

     function getStockVehicle()
     {
          $selectArray = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_vehicle . '.veh_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_valuation . '.val_prt_1',
               $this->tbl_valuation . '.val_prt_2',
               $this->tbl_valuation . '.val_prt_3',
               $this->tbl_valuation . '.val_prt_4',
               $this->tbl_vehicle . '.veh_stock_id',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_last_name'
          );

          return $this->db->select($selectArray)
               ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle . '.veh_stock_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->where($this->tbl_vehicle . '.veh_stock_id > 0')
               ->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm)
               ->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
               ->get($this->tbl_enquiry)->result_array();
     }

     public function getStaffsByShrm($shrm)
     {
          error_reporting(1);
          $staffs = $this->db->query("CALL sp_get_sl_staffs_by_shrm($shrm)")->result_array();
          $this->db->reconnect();
          return $staffs;
     }

     public function getBrandAndModel($shrm, $frm_date, $to_date)
     {
          $res['frm_date'] = date("Y-m-d", strtotime($frm_date));
          $res['to_date'] = date("Y-m-d", strtotime($to_date));
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          error_reporting(1);
          $res['vehData'] = $this->db->query("CALL sp_get_sl_brand_and_model($shrm,$assign,$enqReOpnd,'$res[frm_date]','$res[to_date]')")->result_array();
          $this->db->reconnect();
          return $res;
     }
     public function getEnqCountByStaffAndMdl($staff, $mod_id, $frm_date, $to_date)
     {
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          error_reporting(1);
          $res = $this->db->query("CALL sp_get_sl_enq_count_by_staff_mdl($staff,$mod_id,'$frm_date','$to_date',$assign,$enqReOpnd)")->row_array();
          $this->db->reconnect();
          return $res;
     }
     function salesExecutives()
     {
          if (check_permission('reports', 'fltr_staff_my_shwrm_sls')) { //
               $this->db->where(array($this->tbl_users . '.usr_showroom' => $this->shrm));
               $this->db->where_in($this->tbl_users . '.usr_departments', array(4, 6));
          } else if (check_permission('reports', 'fltr_staff_my_shwrm_pur')) { //
               $this->db->where_in($this->tbl_users . '.usr_departments', array(7, 8));
               $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
          } else if (check_permission('reports', 'fltr_purch_sales_staf_my_shrm')) {
               $this->db->where_in($this->tbl_users . '.usr_departments', array(4, 6, 7, 8));
               $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
          } else if (check_permission('reports', 'fltr_purch_sales_staf_my_team') || check_permission('reports', 'fltr_staff_my_staff_pur') || check_permission('reports', 'fltr_staff_my_staff_sls')) {
               $mystaff = my_staff($this->uid);
               $this->db->where_in($this->tbl_users . '.usr_id', $mystaff);
          }

          if (check_permission('emp_details', 'showinnactivestaffs')) {
               $this->db->where($this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0 OR ' . $this->tbl_users . '.usr_resigned = 0');
          } else {
               $this->db->where($this->tbl_users . '.usr_active = 1');
          }
          $this->db->where($this->tbl_users . '.usr_resigned = 0');
          $selectArray = array(
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_last_name',
               $this->tbl_users . '.usr_username',
          );
          return $this->db->select($selectArray)->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
     }

     public function updateReAssignHistoryFollowup($fr, $to, $enq_id, $enquiry, $comment, $divBySE, $poolBatch)
     {
          $toName = $this->db->select('usr_username')->get_where($this->tbl_users, array('usr_id' => $to))->row()->usr_username;
          $frName = $this->db->select('usr_username')->get_where($this->tbl_users, array('usr_id' => $fr))->row()->usr_username;
          if ($divBySE < 30) {
               $addDays = rand(1, $divBySE);
          } else {
               $addDays = rand(1, 30);
          }
          $addDays = (int)$addDays;
          $nextFolDate = date('Y-m-d H:i:s');
          $nextFolDate = date('Y-m-d H:i:s', strtotime($nextFolDate . ' + ' . $addDays . ' days'));
          $f['enquiry'] = $enquiry;
          $f['frm_staff'] = $fr;
          $f['to_staff'] = $to;
          generate_log(array(
               'log_title' => 'Quick assign enquiry ' . $frName . ' to ' . $toName,
               'log_desc' => serialize($f),
               'log_controller' => 'quk-assign-inquiry-' . $frName . '-' . $toName,
               'log_action' => 'C',
               'log_ref_id' => $enq_id,
               'log_added_by' => $this->uid
          ));
          $fol = $this->db->order_by('foll_id', 'DESC')->limit(1)->get_where($this->tbl_followup, array('foll_cus_id' => $enq_id, 'foll_is_cmnt' => 0))->row_array();
          if (!empty($fol)) {
               //Comment
               $follCmd['foll_remarks'] = $comment;
               $follCmd['foll_cus_id'] = $enq_id;
               $follCmd['foll_parent'] = 0;
               $follCmd['foll_cus_vehicle_id'] = 0;
               $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
               $follCmd['foll_customer_feedback'] = '';
               $follCmd['foll_can_show_all'] = 1;
               $follCmd['foll_contact'] = 0;
               $follCmd['foll_action_plan'] = '';
               $follCmd['foll_added_by'] = $this->uid;
               $follCmd['foll_updated_by'] = $this->uid;
               $follCmd['foll_is_dar_submited'] = 0;
               $follCmd['foll_is_cmnt'] = 1;
               $this->db->insert($this->tbl_followup, $follCmd);

               //Insert new followup
               $foll = array(
                    'foll_cus_id' => $enq_id,
                    'foll_showroom' => 0,
                    'foll_sales_staff' => $to,
                    'foll_cus_vehicle_id' => $fol['foll_cus_vehicle_id'],
                    'foll_entry_date' => date('Y-m-d H:i:s'),
                    'foll_status' => $fol['foll_status'],
                    'foll_remarks' => $frName . "'s enquires reassigned to " . $toName,
                    'foll_can_show_all' => 0,
                    'foll_customer_feedback_added_date' => date('Y-m-d H:i:s'),
                    'foll_contact' => $fol['foll_contact'],
                    'foll_action_plan' => $fol['foll_action_plan'],
                    'foll_next_foll_date' => $nextFolDate,
                    'foll_added_by' => $this->uid,
                    'foll_updated_by' => 0,
                    'foll_is_dar_submited' => 0,
                    'foll_is_cmnt' => 0
               );
               $this->db->insert($this->tbl_followup, $foll);

               //Enquiry history
               $enqHtry = array(
                    'enh_enq_id' => $enq_id,
                    'enh_current_sales_executive' => $to,
                    'enh_status' => 1,
                    'enh_alias' => 'All enquiries of sales officer quickly assigned to another sales officer ' . $toName . ' of ' . $frName,
                    'enh_remarks' => $comment
               );
               $this->db->insert($this->tbl_enquiry_history, $enqHtry);
               $hisId = $this->db->insert_id();

               //Move to pool
               $this->db->insert(
                    $this->tbl_enquiry_pool,
                    array(
                         'enp_enq_id' => $enq_id,
                         'enq_pool_batch' => $poolBatch,
                         'enp_se_from_id' => $fr,
                         'enp_se_to_id' => $to,
                         'enp_cmd_assign' => $comment,
                         'enp_added_on' => date('Y-m-d H:i:s'),
                         'enp_added_by' => $this->uid
                    )
               );
               $poolId = $this->db->insert_id();

               //Update enquiry
               $this->db->where('enq_id', $enq_id)->update($this->tbl_enquiry, array(
                    'enq_last_viewd' => $to, 'enq_se_id' => $to, 'is_exe' => 1, 'enq_next_foll_date' => $nextFolDate,
                    'enq_current_status_history' => $hisId, 'enq_last_viewd' => 0, 'enq_is_pool' => 1, 'enq_pool_flag' => 1,
                    'enq_pool_entry_date' => date('Y-m-d H:i:s'), 'enq_pool_lst_cmd' => $comment,
                    'enq_pool_id' => $poolId
               ));

               return true;
          } else {
               return false;
          }
     }
     public function price_list($div = '', $shrm = '')
     {
          $this->db->query('SET SQL_BIG_SELECTS=1');
          if ($div) {
               if ($div == 2 && $shrm == '') {

                    $res = $this->db->query("CALL sp_price_list_luxury()")->result_array();
               } elseif ($shrm) {

                    $res = $this->db->query("CALL sp_price_list_by_shrm($shrm)")->result_array();
               } elseif ($div == 1) {
                    $res = $this->db->query("CALL sp_price_list_smart()")->result_array();
               }
          } else {
               $res = $this->db->query("CALL sp_price_list_all()")->result_array();
          }
          error_reporting(0);
          $this->db->reconnect();
          //debug($this->db->last_query());
          //  debug($res);
          return $res;
     }
     public function price_list_test($div = '', $shrm = '')
     {
          $this->db->query('SET SQL_BIG_SELECTS=1');
          //     $sql= "SELECT
          //      `cpnl_valuation`.`val_id`,
          //      `cpnl_valuation`.`val_brand`,
          //      `cpnl_valuation`.`val_model`,
          //      `cpnl_valuation`.`val_variant`,
          //     `cpnl_valuation`.`val_fuel`,
          //      `cpnl_valuation`.`val_color`,
          //      `cpnl_valuation`.`val_minif_year`,
          //      `cpnl_valuation`.`val_km`,
          //       `cpnl_valuation`.`val_manf_date`,
          //     `cpnl_valuation`.`val_veh_no`,
          //     `cpnl_valuation`.`val_insurance_validity`,
          //     `cpnl_valuation`.`val_insurance_idv`,
          //     `cpnl_valuation`.`val_no_of_owner`,
          //     `cpnl_valuation`.`val_type`,
          //     `cpnl_valuation`.`val_showroom`,
          //     `cpnl_valuation`.`val_booking_status`,
          //     `cpnl_valuation`.`val_status`,
          //     `rana_products`.`prd_id`,
          //     `rana_products`.`prd_price`,
          //     `rana_brand`.`brd_title`, `rana_model`.`mod_title`,`rana_variant`.`var_variant_name`,
          //     `cpnl_vehicle_booking_master`.`vbk_added_on`,
          //     `cpnl_vehicle_booking_master`.`vbk_added_by`,
          //     `cpnl_vehicle_booking_master`.`vbk_id`,
          //     `cpnl_vehicle_booking_master`.`vbk_showroom`,
          //     `cpnl_vehicle_booking_master`.`vbk_status`,
          //     `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id`, 
          //      `cpnl_users`.`usr_first_name` AS booked_staff
          //    FROM
          //     (`cpnl_valuation`)
          //     LEFT JOIN `rana_products` ON `rana_products`.`prd_valuation_id` = `cpnl_valuation`.`val_id`

          //     LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_valuation`.`val_brand`
          // LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_valuation`.`val_model`
          // LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_valuation`.`val_variant`

          //     LEFT JOIN `cpnl_vehicle_booking_master` ON `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id` = `cpnl_valuation`.`val_id`
          //      LEFT JOIN `cpnl_users` ON `cpnl_users`.`usr_id` = `cpnl_vehicle_booking_master`.`vbk_sales_staff`
          // WHERE (`cpnl_valuation`.`val_status` = 39 OR `cpnl_valuation`.`val_status`=13 ) AND `cpnl_valuation`.`val_showroom` = 1 AND `cpnl_valuation`.`val_id` != 2982 AND `cpnl_valuation`.`val_id`!=950 AND `cpnl_valuation`.`val_id` != 3652 AND `cpnl_valuation`.`val_id` != 4361 AND `cpnl_valuation`.`val_id` != 4441 AND `cpnl_valuation`.`val_id` != 4511 AND `cpnl_valuation`.`val_id` != 4541 AND `cpnl_valuation`.`val_id` != 4583 AND `cpnl_valuation`.`val_id` != 4528 AND `cpnl_valuation`.`val_id` != 4618 AND `cpnl_valuation`.`val_id` != 4557 AND `cpnl_valuation`.`val_id` != 4543 AND `cpnl_valuation`.`val_id` != 4725 AND `cpnl_valuation`.`val_id` != 3754 AND `cpnl_valuation`.`val_id` != 4307 AND `cpnl_valuation`.`val_id` != 4806 AND `cpnl_valuation`.`val_id` != 4805 AND `cpnl_valuation`.`val_id` != 4825 AND `cpnl_valuation`.`val_id` != 4940 AND `cpnl_valuation`.`val_id` != 4941 AND `cpnl_valuation`.`val_id` != 4997 AND `cpnl_valuation`.`val_id` != 4960 AND `cpnl_valuation`.`val_id` != 4953 AND `cpnl_valuation`.`val_id` != 4954 AND `cpnl_valuation`.`val_id` != 4970 AND `cpnl_valuation`.`val_id` != 4816 AND `cpnl_vehicle_booking_master`.`vbk_status` != 40 AND `cpnl_valuation`.`val_re_evaluated` = 0 AND `cpnl_valuation`.`val_is_sold`=0 
          // ORDER BY `cpnl_vehicle_booking_master`.`vbk_added_on` DESC";



          //      $sql= "SELECT
          //      `cpnl_valuation`.`val_id`,
          //      `cpnl_valuation`.`val_brand`,
          //      `cpnl_valuation`.`val_model`,
          //      `cpnl_valuation`.`val_variant`,
          //     `cpnl_valuation`.`val_fuel`,
          //      `cpnl_valuation`.`val_color`,
          //      `cpnl_valuation`.`val_minif_year`,
          //      `cpnl_valuation`.`val_km`,
          //       `cpnl_valuation`.`val_manf_date`,
          //     `cpnl_valuation`.`val_veh_no`,
          //     `cpnl_valuation`.`val_insurance_validity`,
          //     `cpnl_valuation`.`val_insurance_idv`,
          //     `cpnl_valuation`.`val_no_of_owner`,
          //     `cpnl_valuation`.`val_type`,
          //     `cpnl_valuation`.`val_showroom`,
          //     `cpnl_valuation`.`val_booking_status`,
          //     `cpnl_valuation`.`val_status`,
          //     `cpnl_valuation`.`val_re_evaluated`,
          //     `rana_products`.`prd_id`,
          //     `rana_products`.`prd_price`,
          //     `rana_brand`.`brd_title`, `rana_model`.`mod_title`,`rana_variant`.`var_variant_name`,
          //     `cpnl_vehicle_booking_master`.`vbk_added_on`,
          //     `cpnl_vehicle_booking_master`.`vbk_added_by`,
          //     `cpnl_vehicle_booking_master`.`vbk_id`,
          //     `cpnl_vehicle_booking_master`.`vbk_showroom`,
          //     `cpnl_vehicle_booking_master`.`vbk_status`,
          //     `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id`, 
          //      `cpnl_users`.`usr_first_name` AS booked_staff
          //    FROM
          //     (`cpnl_valuation`)
          //     LEFT JOIN `rana_products` ON `rana_products`.`prd_valuation_id` = `cpnl_valuation`.`val_id`

          //     LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_valuation`.`val_brand`
          // LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_valuation`.`val_model`
          // LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_valuation`.`val_variant`

          //     LEFT JOIN `cpnl_vehicle_booking_master` ON `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id` = `cpnl_valuation`.`val_id`
          //      LEFT JOIN `cpnl_users` ON `cpnl_users`.`usr_id` = `cpnl_vehicle_booking_master`.`vbk_sales_staff`
          // WHERE `cpnl_valuation`.`val_id` = 2982 OR `cpnl_valuation`.`val_id`=950 OR `cpnl_valuation`.`val_id` = 3652 OR `cpnl_valuation`.`val_id` = 4361 OR `cpnl_valuation`.`val_id` = 4441 OR `cpnl_valuation`.`val_id` = 4511 OR `cpnl_valuation`.`val_id` = 4541 OR `cpnl_valuation`.`val_id` = 4583 OR `cpnl_valuation`.`val_id` = 4528 OR `cpnl_valuation`.`val_id`= 4618 OR `cpnl_valuation`.`val_id` = 4557 OR `cpnl_valuation`.`val_id` = 4543 OR `cpnl_valuation`.`val_id` = 4725 OR `cpnl_valuation`.`val_id` = 3754 OR `cpnl_valuation`.`val_id` = 4307 OR `cpnl_valuation`.`val_id` = 4806 OR `cpnl_valuation`.`val_id` = 4805 OR `cpnl_valuation`.`val_id` = 4825 OR `cpnl_valuation`.`val_id` = 4940 OR `cpnl_valuation`.`val_id` = 4941 OR `cpnl_valuation`.`val_id` = 4997 OR `cpnl_valuation`.`val_id` = 4960 OR `cpnl_valuation`.`val_id` = 4953 OR `cpnl_valuation`.`val_id` = 4954 OR `cpnl_valuation`.`val_id` = 4970 OR `cpnl_valuation`.`val_id` = 4816 
          // ORDER BY `cpnl_vehicle_booking_master`.`vbk_added_on` DESC";
          // $sql="SELECT
          // `cpnl_valuation`.`val_id`,
          // `cpnl_valuation`.`val_brand`,
          // `cpnl_valuation`.`val_model`,
          // `cpnl_valuation`.`val_variant`,
          // `cpnl_valuation`.`val_fuel`,
          // `cpnl_valuation`.`val_color`,
          // `cpnl_valuation`.`val_minif_year`,
          // `cpnl_valuation`.`val_km`,
          //  `cpnl_valuation`.`val_manf_date`,
          // `cpnl_valuation`.`val_veh_no`,
          // `cpnl_valuation`.`val_insurance_validity`,
          // `cpnl_valuation`.`val_insurance_idv`,
          // `cpnl_valuation`.`val_no_of_owner`,
          // `cpnl_valuation`.`val_type`,
          // `cpnl_valuation`.`val_showroom`,
          // `cpnl_valuation`.`val_booking_status`,
          // `cpnl_valuation`.`val_status`,
          // `cpnl_valuation`.`val_re_evaluated`,
          // `cpnl_valuation`.`val_is_sold`,

          // `rana_products`.`prd_id`,
          // `rana_products`.`prd_price`,
          // `rana_brand`.`brd_title`, `rana_model`.`mod_title`,`rana_variant`.`var_variant_name`,
          // `cpnl_vehicle_booking_master`.`vbk_added_on`,
          // `cpnl_vehicle_booking_master`.`vbk_added_by`,
          // `cpnl_vehicle_booking_master`.`vbk_id`,
          // `cpnl_vehicle_booking_master`.`vbk_showroom`,
          // `cpnl_vehicle_booking_master`.`vbk_status`,
          // `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id`, 
          // `cpnl_users`.`usr_first_name` AS booked_staff
          // FROM
          // (`cpnl_valuation`)
          // LEFT JOIN `rana_products` ON `rana_products`.`prd_valuation_id` = `cpnl_valuation`.`val_id`

          // LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_valuation`.`val_brand`
          // LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_valuation`.`val_model`
          // LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_valuation`.`val_variant`

          // LEFT JOIN `cpnl_vehicle_booking_master` ON `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id` = `cpnl_valuation`.`val_id`
          // LEFT JOIN `cpnl_users` ON `cpnl_users`.`usr_id` = `cpnl_vehicle_booking_master`.`vbk_sales_staff`
          // WHERE (`cpnl_valuation`.`val_status` = 39 OR `cpnl_valuation`.`val_status`=13) AND `cpnl_valuation`.`val_re_evaluated` = 0  And `cpnl_valuation`.`val_showroom` = 1 And `cpnl_valuation`.`val_is_sold`=0 AND (cpnl_vehicle_booking_master.vbk_status != 40 OR cpnl_vehicle_booking_master.vbk_status is null) AND (`cpnl_valuation`.`val_id` != 2982 AND `cpnl_valuation`.`val_id`!=950 AND `cpnl_valuation`.`val_id` != 3652 AND `cpnl_valuation`.`val_id` != 4361 AND `cpnl_valuation`.`val_id` != 4441 AND `cpnl_valuation`.`val_id` != 4511 AND `cpnl_valuation`.`val_id` != 4541 AND `cpnl_valuation`.`val_id` != 4583 AND `cpnl_valuation`.`val_id` != 4528 AND `cpnl_valuation`.`val_id` != 4618 AND `cpnl_valuation`.`val_id` != 4557 AND `cpnl_valuation`.`val_id` != 4543 AND `cpnl_valuation`.`val_id` != 4725 AND `cpnl_valuation`.`val_id` != 3754 AND `cpnl_valuation`.`val_id` != 4307 AND `cpnl_valuation`.`val_id` != 4806 AND `cpnl_valuation`.`val_id` != 4805 AND `cpnl_valuation`.`val_id` != 4825 AND `cpnl_valuation`.`val_id` != 4940 AND `cpnl_valuation`.`val_id` != 4941 AND `cpnl_valuation`.`val_id` != 4997 AND `cpnl_valuation`.`val_id` != 4960 AND `cpnl_valuation`.`val_id` != 4953 AND `cpnl_valuation`.`val_id` != 4954 AND `cpnl_valuation`.`val_id` != 4970 AND `cpnl_valuation`.`val_id` != 4816) 
          // ORDER BY `cpnl_vehicle_booking_master`.`vbk_added_on` DESC";

          // $sql="SELECT
          // `cpnl_valuation`.`val_id`,
          // `cpnl_valuation`.`val_brand`,
          // `cpnl_valuation`.`val_model`,
          // `cpnl_valuation`.`val_variant`,
          // `cpnl_valuation`.`val_fuel`,
          // `cpnl_valuation`.`val_color`,
          // `cpnl_valuation`.`val_minif_year`,
          // `cpnl_valuation`.`val_km`,
          //  `cpnl_valuation`.`val_manf_date`,
          // `cpnl_valuation`.`val_veh_no`,
          // `cpnl_valuation`.`val_insurance_validity`,
          // `cpnl_valuation`.`val_insurance_idv`,
          // `cpnl_valuation`.`val_no_of_owner`,
          // `cpnl_valuation`.`val_type`,
          // `cpnl_valuation`.`val_showroom`,
          // `cpnl_valuation`.`val_booking_status`,
          // `cpnl_valuation`.`val_status`,
          // `cpnl_valuation`.`val_re_evaluated`,
          // `cpnl_valuation`.`val_is_sold`,

          // `rana_products`.`prd_id`,
          // `rana_products`.`prd_price`,
          // `rana_brand`.`brd_title`, `rana_model`.`mod_title`,`rana_variant`.`var_variant_name`,
          // `cpnl_vehicle_booking_master`.`vbk_added_on`,
          // `cpnl_vehicle_booking_master`.`vbk_added_by`,
          // `cpnl_vehicle_booking_master`.`vbk_id`,
          // `cpnl_vehicle_booking_master`.`vbk_showroom`,
          // `cpnl_vehicle_booking_master`.`vbk_status`,
          // `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id`, 
          // `cpnl_users`.`usr_first_name` AS booked_staff
          // FROM
          // (`cpnl_valuation`)
          // LEFT JOIN `rana_products` ON `rana_products`.`prd_valuation_id` = `cpnl_valuation`.`val_id`

          // LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_valuation`.`val_brand`
          // LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_valuation`.`val_model`
          // LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_valuation`.`val_variant`

          // LEFT JOIN `cpnl_vehicle_booking_master` ON `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id` = `cpnl_valuation`.`val_id`
          // LEFT JOIN `cpnl_users` ON `cpnl_users`.`usr_id` = `cpnl_vehicle_booking_master`.`vbk_sales_staff`
          // WHERE `cpnl_valuation`.`val_id` = 2982 OR `cpnl_valuation`.`val_id`=950 OR `cpnl_valuation`.`val_id` = 3652 OR `cpnl_valuation`.`val_id` = 4361 OR `cpnl_valuation`.`val_id` = 4441 OR `cpnl_valuation`.`val_id` = 4511 OR `cpnl_valuation`.`val_id` = 4541 OR `cpnl_valuation`.`val_id` = 4583 OR `cpnl_valuation`.`val_id` = 4528 OR `cpnl_valuation`.`val_id` = 4618 OR `cpnl_valuation`.`val_id` = 4557 OR `cpnl_valuation`.`val_id` = 4543 OR `cpnl_valuation`.`val_id` = 4725 OR `cpnl_valuation`.`val_id` = 3754 OR `cpnl_valuation`.`val_id` = 4307 OR `cpnl_valuation`.`val_id` = 4806 OR `cpnl_valuation`.`val_id` = 4805 OR `cpnl_valuation`.`val_id` = 4825 OR `cpnl_valuation`.`val_id` = 4940 OR `cpnl_valuation`.`val_id` = 4941 OR `cpnl_valuation`.`val_id` = 4997 OR `cpnl_valuation`.`val_id` = 4960 OR `cpnl_valuation`.`val_id` = 4953 OR `cpnl_valuation`.`val_id` = 4954 OR `cpnl_valuation`.`val_id` = 4970 OR `cpnl_valuation`.`val_id` = 4816 
          // ORDER BY `cpnl_vehicle_booking_master`.`vbk_added_on` DESC";//`cpnl_valuation`.`val_veh_no`,
          $sql = "SELECT
`cpnl_valuation`.`val_id`,
`cpnl_valuation`.`val_brand`,
`cpnl_valuation`.`val_model`,
`cpnl_valuation`.`val_variant`,
`cpnl_valuation`.`val_fuel`,
`cpnl_valuation`.`val_color`,
`cpnl_valuation`.`val_minif_year`,
`cpnl_valuation`.`val_km`,
 `cpnl_valuation`.`val_manf_date`,
`cpnl_valuation`.`val_prt_1`,
`cpnl_valuation`.`val_prt_2`,
`cpnl_valuation`.`val_prt_3`,
`cpnl_valuation`.`val_prt_4`,
`cpnl_valuation`.`val_veh_no`,
CONCAT(cpnl_valuation.val_prt_1, '-', cpnl_valuation.val_prt_2, '-', cpnl_valuation.val_prt_3, '-', cpnl_valuation.val_prt_4) AS regno,
`cpnl_valuation`.`val_insurance_validity`,
`cpnl_valuation`.`val_insurance_idv`,
`cpnl_valuation`.`val_no_of_owner`,
`cpnl_valuation`.`val_type`,
`cpnl_valuation`.`val_showroom`,
`cpnl_valuation`.`val_booking_status`,
`cpnl_valuation`.`val_status`,
`rana_products`.`prd_id`,
`rana_products`.`prd_price`,
`rana_brand`.`brd_title`, `rana_model`.`mod_title`,`rana_variant`.`var_variant_name`,
`cpnl_vehicle_booking_master`.`vbk_added_on`,
`cpnl_vehicle_booking_master`.`vbk_added_by`,
`cpnl_vehicle_booking_master`.`vbk_id`,
`cpnl_vehicle_booking_master`.`vbk_showroom`,
`cpnl_vehicle_booking_master`.`vbk_status`,
`cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id`, 
`cpnl_users`.`usr_first_name` AS booked_staff
FROM
(`cpnl_valuation`)
LEFT JOIN `rana_products` ON `rana_products`.`prd_valuation_id` = `cpnl_valuation`.`val_id`

LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_valuation`.`val_brand`
LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_valuation`.`val_model`
LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_valuation`.`val_variant`

LEFT JOIN `cpnl_vehicle_booking_master` ON `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id` = `cpnl_valuation`.`val_id`
LEFT JOIN `cpnl_users` ON `cpnl_users`.`usr_id` = `cpnl_vehicle_booking_master`.`vbk_sales_staff`
WHERE (`cpnl_valuation`.`val_status` = 39 OR `cpnl_valuation`.`val_status`=13) AND `cpnl_valuation`.`val_re_evaluated` = 0 AND (`cpnl_valuation`.`val_showroom` = 2 OR `cpnl_valuation`.`val_showroom` = 4) And `cpnl_valuation`.`val_is_sold`=0 AND (cpnl_vehicle_booking_master.vbk_status != 40 OR cpnl_vehicle_booking_master.vbk_status is null)
ORDER BY `cpnl_vehicle_booking_master`.`vbk_added_on` DESC";
          $query = $this->db->query($sql);
          $res = $query->result_array();
          debug($res);
          //return $res;
          //        foreach($res as $val){
          //           //debug($val['val_id']);
          //           $dataUpd = array(
          //                          'val_status'=>77
          //                               );
          //           $id=$this->db->where('val_id', $val['val_id']);
          //    $this->db->update('cpnl_valuation', $dataUpd);
          //         //  $val[]
          //        }
          //       debug($id);
          // (`cpnl_valuation`.`val_id` != 2982 OR `cpnl_valuation`.`val_id`!=950 OR `cpnl_valuation`.`val_id` != 3652 OR `cpnl_valuation`.`val_id` != 4361 OR `cpnl_valuation`.`val_id` != 4441 OR `cpnl_valuation`.`val_id` != 4511 OR `cpnl_valuation`.`val_id` != 4541 OR `cpnl_valuation`.`val_id` != 4583 OR `cpnl_valuation`.`val_id` != 4528 OR `cpnl_valuation`.`val_id` != 4618 OR `cpnl_valuation`.`val_id` != 4557 OR `cpnl_valuation`.`val_id` != 4543 OR `cpnl_valuation`.`val_id` != 4725 OR `cpnl_valuation`.`val_id` != 3754 OR `cpnl_valuation`.`val_id` != 4307 OR `cpnl_valuation`.`val_id` != 4806 OR `cpnl_valuation`.`val_id` != 4805 OR `cpnl_valuation`.`val_id` != 4825 OR `cpnl_valuation`.`val_id` != 4940 OR `cpnl_valuation`.`val_id` != 4941 OR `cpnl_valuation`.`val_id` != 4997 OR `cpnl_valuation`.`val_id` != 4960 OR `cpnl_valuation`.`val_id` != 4953 OR `cpnl_valuation`.`val_id` != 4954 OR `cpnl_valuation`.`val_id` != 4970 OR `cpnl_valuation`.`val_id` != 4816) 
          //   $veh_in_excel=[]
     }

     public function price_list_test_add77($div = '', $shrm = '')
     {


          $ids = array(4557, 4805, 4998, 4997, 4816, 4736, 4995, 5020, 4734, 5036, 5027, 5170);
          //$dbStations->where_in('id', $ids);
          $dataUpd = array(
               'val_status' => 39
          );
          $id = $this->db->select('val_id,val_veh_no,val_status')->where_in('val_id', $ids)->get('cpnl_valuation')->result_array();
          debug($id);
          //$this->db->where_in('val_id', $ids)->update('cpnl_valuation', $dataUpd);
          exit;

          $this->db->query('SET SQL_BIG_SELECTS=1');
          $sql = "SELECT
`cpnl_valuation`.`val_id`,
`cpnl_valuation`.`val_brand`,
`cpnl_valuation`.`val_model`,
`cpnl_valuation`.`val_variant`,
`cpnl_valuation`.`val_fuel`,
`cpnl_valuation`.`val_color`,
`cpnl_valuation`.`val_minif_year`,
`cpnl_valuation`.`val_km`,
 `cpnl_valuation`.`val_manf_date`,
`cpnl_valuation`.`val_veh_no`,
`cpnl_valuation`.`val_insurance_validity`,
`cpnl_valuation`.`val_insurance_idv`,
`cpnl_valuation`.`val_no_of_owner`,
`cpnl_valuation`.`val_type`,
`cpnl_valuation`.`val_showroom`,
`cpnl_valuation`.`val_booking_status`,
`cpnl_valuation`.`val_status`,
`cpnl_valuation`.`val_re_evaluated`,
`cpnl_valuation`.`val_is_sold`,

`rana_products`.`prd_id`,
`rana_products`.`prd_price`,
`rana_brand`.`brd_title`, `rana_model`.`mod_title`,`rana_variant`.`var_variant_name`,
`cpnl_vehicle_booking_master`.`vbk_added_on`,
`cpnl_vehicle_booking_master`.`vbk_added_by`,
`cpnl_vehicle_booking_master`.`vbk_id`,
`cpnl_vehicle_booking_master`.`vbk_showroom`,
`cpnl_vehicle_booking_master`.`vbk_status`,
`cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id`, 
`cpnl_users`.`usr_first_name` AS booked_staff
FROM
(`cpnl_valuation`)
LEFT JOIN `rana_products` ON `rana_products`.`prd_valuation_id` = `cpnl_valuation`.`val_id`

LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_valuation`.`val_brand`
LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_valuation`.`val_model`
LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_valuation`.`val_variant`

LEFT JOIN `cpnl_vehicle_booking_master` ON `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id` = `cpnl_valuation`.`val_id`
LEFT JOIN `cpnl_users` ON `cpnl_users`.`usr_id` = `cpnl_vehicle_booking_master`.`vbk_sales_staff`
WHERE (`cpnl_valuation`.`val_showroom` = 2 OR `cpnl_valuation`.`val_showroom` = 4) And `cpnl_valuation`.`val_is_sold`=0 AND (cpnl_vehicle_booking_master.vbk_status != 40 OR cpnl_vehicle_booking_master.vbk_status is null) AND (`cpnl_valuation`.`val_id` != 2889 AND `cpnl_valuation`.`val_id`!=2587 AND `cpnl_valuation`.`val_id` != 2821 AND `cpnl_valuation`.`val_id` != 2899 AND `cpnl_valuation`.`val_id` != 2935 AND `cpnl_valuation`.`val_id` != 3501 AND `cpnl_valuation`.`val_id` != 3359 AND `cpnl_valuation`.`val_id` != 3790 AND `cpnl_valuation`.`val_id` != 908 AND `cpnl_valuation`.`val_id` != 3800 AND `cpnl_valuation`.`val_id` != 3523 AND `cpnl_valuation`.`val_id` != 4049 AND `cpnl_valuation`.`val_id` != 3444 AND `cpnl_valuation`.`val_id` != 4116 AND `cpnl_valuation`.`val_id` != 4223 AND `cpnl_valuation`.`val_id` != 4104 AND `cpnl_valuation`.`val_id` != 2775 AND `cpnl_valuation`.`val_id` != 4235 AND `cpnl_valuation`.`val_id` != 4451 AND `cpnl_valuation`.`val_id` != 4461 AND `cpnl_valuation`.`val_id` != 1740 AND `cpnl_valuation`.`val_id` != 4466 AND `cpnl_valuation`.`val_id` != 4471 AND `cpnl_valuation`.`val_id` != 4470 AND `cpnl_valuation`.`val_id` != 1864 AND `cpnl_valuation`.`val_id` != 4499 AND `cpnl_valuation`.`val_id` !=4500 AND `cpnl_valuation`.`val_id` !=4592 AND `cpnl_valuation`.`val_id` !=4642 AND `cpnl_valuation`.`val_id` !=1932 AND  `cpnl_valuation`.`val_id` !=4487 AND `cpnl_valuation`.`val_id` != 4604 AND `cpnl_valuation`.`val_id` != 2655 AND `cpnl_valuation`.`val_id` != 4651 AND `cpnl_valuation`.`val_id` != 4674 AND `cpnl_valuation`.`val_id` != 4804 AND `cpnl_valuation`.`val_id` != 3872 AND `cpnl_valuation`.`val_id` != 4720 AND `cpnl_valuation`.`val_id` != 4675 AND `cpnl_valuation`.`val_id` != 4506 AND `cpnl_valuation`.`val_id` != 4507 AND `cpnl_valuation`.`val_id` != 4676 AND `cpnl_valuation`.`val_id` != 4827 AND `cpnl_valuation`.`val_id` != 4942 AND `cpnl_valuation`.`val_id` != 1495 AND `cpnl_valuation`.`val_id` != 4679 AND `cpnl_valuation`.`val_id` != 4881 AND `cpnl_valuation`.`val_id` != 2607 AND `cpnl_valuation`.`val_id` != 4951 AND `cpnl_valuation`.`val_id` != 4956 AND `cpnl_valuation`.`val_id` != 4957 AND `cpnl_valuation`.`val_id` != 5007 AND `cpnl_valuation`.`val_id` != 2917 AND `cpnl_valuation`.`val_id` != 5014 AND `cpnl_valuation`.`val_id` != 4891 AND `cpnl_valuation`.`val_id` != 5022 AND `cpnl_valuation`.`val_id` != 2811 AND `cpnl_valuation`.`val_id` != 5028 AND `cpnl_valuation`.`val_id` != 2036 AND `cpnl_valuation`.`val_id` != 5038 AND `cpnl_valuation`.`val_id` != 2059 AND `cpnl_valuation`.`val_id` != 2060 AND `cpnl_valuation`.`val_id` != 5041 AND `cpnl_valuation`.`val_id` != 5051)
ORDER BY `cpnl_vehicle_booking_master`.`vbk_added_on` DESC";
          $query = $this->db->query($sql);
          $res = $query->result_array();
          debug($res, 1);
          //return $res;
          foreach ($res as $val) {
               //debug($val['val_id']);
               $dataUpd = array(
                    'val_status' => 77
               );
               $id = $this->db->where('val_id', $val['val_id']);
               $this->db->update('cpnl_valuation', $dataUpd);
               //  $val[]
          }
     }

     public function price_list_test_new($data)
     {

          //           $dataUpd2 = array(
          //                'val_status'=>77,
          //                                         );
          // $id=$this->db->where('val_id',5036);
          // $this->db->update('cpnl_valuation', $dataUpd2);  exit;

          $part_1 = str_replace(' ', '', $data['part_1']);
          $part_2 = str_replace(' ', '', $data['part_2']);
          $part_3 = str_replace(' ', '', $data['part_3']);
          $part_4 = str_replace(' ', '', $data['part_4']);

          // $part_1=$data['part_1'];
          // $part_2=$data['part_2'];
          // $part_3=$data['part_3'];
          // $part_4=$data['part_4'];

          $this->db->query('SET SQL_BIG_SELECTS=1');
          $searchValue = 5;
          $sql = "SELECT
`cpnl_valuation`.`val_id`,
`cpnl_valuation`.`val_brand`,
`cpnl_valuation`.`val_model`,
`cpnl_valuation`.`val_variant`,
`cpnl_valuation`.`val_fuel`,
`cpnl_valuation`.`val_color`,
`cpnl_valuation`.`val_minif_year`,
`cpnl_valuation`.`val_km`,
 `cpnl_valuation`.`val_manf_date`,
`cpnl_valuation`.`val_prt_1`,
`cpnl_valuation`.`val_prt_2`,
`cpnl_valuation`.`val_prt_3`,
`cpnl_valuation`.`val_prt_4`,
`cpnl_valuation`.`val_veh_no`,
CONCAT(cpnl_valuation.val_prt_1, '-', cpnl_valuation.val_prt_2, '-', cpnl_valuation.val_prt_3, '-', cpnl_valuation.val_prt_4) AS regno,
`cpnl_valuation`.`val_insurance_validity`,
`cpnl_valuation`.`val_insurance_idv`,
`cpnl_valuation`.`val_no_of_owner`,
`cpnl_valuation`.`val_type`,
`cpnl_valuation`.`val_showroom`,
`cpnl_valuation`.`val_booking_status`,
`cpnl_valuation`.`val_status`,
`cpnl_valuation`.`val_is_sold`,
`cpnl_valuation`.`val_re_evaluated`,
val_parent_id,
`rana_products`.`prd_id`,
`rana_products`.`prd_price`,
`rana_brand`.`brd_title`, `rana_model`.`mod_title`,`rana_variant`.`var_variant_name`,
`cpnl_vehicle_booking_master`.`vbk_added_on`,
`cpnl_vehicle_booking_master`.`vbk_added_by`,
`cpnl_vehicle_booking_master`.`vbk_id`,
`cpnl_vehicle_booking_master`.`vbk_showroom`,
`cpnl_vehicle_booking_master`.`vbk_status`,
`cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id`, 
`cpnl_users`.`usr_first_name` AS booked_staff
FROM
(`cpnl_valuation`)
LEFT JOIN `rana_products` ON `rana_products`.`prd_valuation_id` = `cpnl_valuation`.`val_id`

LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_valuation`.`val_brand`
LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_valuation`.`val_model`
LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_valuation`.`val_variant`

LEFT JOIN `cpnl_vehicle_booking_master` ON `cpnl_vehicle_booking_master`.`vbk_evaluation_veh_id` = `cpnl_valuation`.`val_id`
LEFT JOIN `cpnl_users` ON `cpnl_users`.`usr_id` = `cpnl_vehicle_booking_master`.`vbk_sales_staff`
WHERE `cpnl_valuation`.`val_prt_1` = '$part_1' AND `cpnl_valuation`.`val_prt_2` = '$part_2' AND `cpnl_valuation`.`val_prt_3` = '$part_3' AND `cpnl_valuation`.`val_prt_4` = '$part_4'
GROUP BY `cpnl_valuation`.`val_id`
ORDER BY `cpnl_valuation`.`val_id` ASC";
          $query = $this->db->query($sql);
          $array = $res = $query->result_array();
          //debug($res);
          //if(!empty($res)){
          if (count($array) < 1)
               debug('no data');
          //return null;
          echo $array_size = count($array);
          $keys = array_keys($array);
          //debug($array[$keys[sizeof($keys) - 1]]);exit;
          $latest_val_id = $array[$keys[sizeof($keys) - 1]]['val_id'];
          //  if($array_size==1){
          //      echo 'ONly one';
          //      $dataUpd = array(
          //                                    'val_status'=>39,
          //                                    'val_re_evaluated'=>0,
          //                                    'val_parent_id'=>0,
          //                                    'val_is_sold'=>0

          //                                         );
          //                     $id=$this->db->where('val_id', $latest_val_id);
          //              $this->db->update('cpnl_valuation', $dataUpd);
          //              debug('upd only one',1);
          //              exit;
          //  }
          //$keys = array_keys($array);
          //echo $latest_val_id=$array[$keys[sizeof($keys) - 1]]['val_id'];
          foreach ($array as $k => $value) {
               if ($latest_val_id == $value['val_id']) {
                    $dataUpd = array(
                         'val_status' => 39,
                         'val_re_evaluated' => 0,
                         'val_is_sold' => 0

                    );
                    $id = $this->db->where('val_id', $latest_val_id);
                    $this->db->update('cpnl_valuation', $dataUpd);
               } else {
                    $dataUpd2 = array(
                         'val_status' => 77,
                    );
                    $id = $this->db->where('val_id', $value['val_id']);
                    $this->db->update('cpnl_valuation', $dataUpd2);
               }
               //  echo $k.'<br>';

          }

          debug($array, 1);
          //debug($array[$keys[sizeof($keys) - 1]]);
          //}else{
          // debug('no data');
          //}
          // echo end($res);
          exit;
          //debug($res);
          //return $res;
          //        foreach($res as $val){
          //           //debug($val['val_id']);
          //           $dataUpd = array(
          //                          'val_status'=>77
          //                               );
          //           $id=$this->db->where('val_id', $val['val_id']);
          //    $this->db->update('cpnl_valuation', $dataUpd);
          //         //  $val[]
          //        }
          //       debug($id);
          // (`cpnl_valuation`.`val_id` != 2982 OR `cpnl_valuation`.`val_id`!=950 OR `cpnl_valuation`.`val_id` != 3652 OR `cpnl_valuation`.`val_id` != 4361 OR `cpnl_valuation`.`val_id` != 4441 OR `cpnl_valuation`.`val_id` != 4511 OR `cpnl_valuation`.`val_id` != 4541 OR `cpnl_valuation`.`val_id` != 4583 OR `cpnl_valuation`.`val_id` != 4528 OR `cpnl_valuation`.`val_id` != 4618 OR `cpnl_valuation`.`val_id` != 4557 OR `cpnl_valuation`.`val_id` != 4543 OR `cpnl_valuation`.`val_id` != 4725 OR `cpnl_valuation`.`val_id` != 3754 OR `cpnl_valuation`.`val_id` != 4307 OR `cpnl_valuation`.`val_id` != 4806 OR `cpnl_valuation`.`val_id` != 4805 OR `cpnl_valuation`.`val_id` != 4825 OR `cpnl_valuation`.`val_id` != 4940 OR `cpnl_valuation`.`val_id` != 4941 OR `cpnl_valuation`.`val_id` != 4997 OR `cpnl_valuation`.`val_id` != 4960 OR `cpnl_valuation`.`val_id` != 4953 OR `cpnl_valuation`.`val_id` != 4954 OR `cpnl_valuation`.`val_id` != 4970 OR `cpnl_valuation`.`val_id` != 4816) 
          //   $veh_in_excel=[]
     }
     function get_stock_status_count()
     { //val_type= own,park and sale
          $res = $this->db->query("CALL sp_count_purchase_refurb_stocks()")->row_array();
          $this->db->reconnect();
          $data['purch_refurb_stock'] = $res['numrows'];


          $res = $this->db->query("CALL sp_count_purchase_booked_stock()")->row_array();
          $this->db->reconnect();
          $data['purch_booked_stock'] = $res['numrows'];
          //val_status =43 Refurbishment completed & ready to delivery

          $res = $this->db->query("CALL sp_count_purchase_ready_to_sell()")->row_array();
          $this->db->reconnect();
          $data['purch_ready_to_sell'] = $res['numrows'];
          $data['purch_total'] = $data['purch_refurb_stock'] + $data['purch_ready_to_sell'] + $data['purch_booked_stock'];

          $res = $this->db->query("CALL sp_purchase_stock_delivered_this_month()")->row_array();
          $this->db->reconnect();
          $data['purch_stock_delivered_this_month'] = $res['numrows'];


          /*             * *****Park & Sell******* val_type 3 or 4 ****** */
          $res = $this->db->query("CALL sp_count_park_refurb_stock()")->row_array();
          $this->db->reconnect();
          $data['park_refurb_stock'] = $res['numrows'];


          $res = $this->db->query("CALL sp_count_park_booked_stock()")->row_array();
          $this->db->reconnect();
          $data['park_booked_stock'] = $res['numrows']; //refurbil undenkil bookedil kaanikkanda

          $res = $this->db->query("CALL sp_count_park_ready_to_sell()")->row_array();
          $this->db->reconnect();
          $data['park_ready_to_sell'] = $res['numrows']; //43 Refurbishment completed & ready to delivery

          $data['park_total'] = $data['park_refurb_stock'] + $data['park_ready_to_sell'] + $data['park_booked_stock'];

          $res = $this->db->query("CALL sp_park_stock_delivered_this_month()")->row_array();
          $this->db->reconnect();
          $data['park_stock_delivered_this_month'] = $res['numrows'];


          /* Total */
          $data['total_refurb_stock'] = $data['purch_refurb_stock'] + $data['park_refurb_stock'];
          $data['total_booked_stock'] = $data['purch_booked_stock'] + $data['park_booked_stock'];
          $data['total_ready_to_sell'] = $data['purch_ready_to_sell'] + $data['park_ready_to_sell'];
          $data['total'] = $data['purch_total'] + $data['park_total'];
          $data['total_delivered_this_mont'] = $data['purch_stock_delivered_this_month'] + $data['park_stock_delivered_this_month'];
          /* -------Ageing---------- */

          $data['purch_age_above_60'] = $this->AgeingCountGreaterOrLess('>', 60, 1);
          $data['purch_age_lessthan_30'] = $this->AgeingCountGreaterOrLess('<', 30, 1);


          $res = $this->db->query("CALL sp_count_ageing_in_bw_days(45, 60, 1)")->row_array();
          $this->db->reconnect();
          $data['purch_ag45_60'] = $res['numrows'];
          $res = $this->db->query("CALL sp_count_ageing_in_bw_days(30, 45, 1)")->row_array();
          $this->db->reconnect();
          $data['purch_ag30_45'] = $res['numrows'];
          $data['total_purch_ageing'] = $data['purch_age_above_60'] + $data['purch_age_lessthan_30'] + $data['purch_ag45_60'] + $data['purch_ag30_45'];
          $data['park_age_above_60'] = $this->AgeingCountGreaterOrLess('>', 60, 4) + $this->AgeingCountGreaterOrLess('>', 60, 3); // or jasja
          $data['park_age_lessthan_30'] = $this->AgeingCountGreaterOrLess('<', 30, 4) + $this->AgeingCountGreaterOrLess('<', 30, 3); // or jasja
          $res1 = $this->db->query("CALL sp_count_ageing_in_bw_days(45, 60, 4)")->row_array();
          $this->db->reconnect();
          $res2 = $this->db->query("CALL sp_count_ageing_in_bw_days(45, 60, 3)")->row_array();
          $this->db->reconnect();
          $data['park_ag45_60'] = $res1['numrows'] + $res2['numrows'];
          $res1 = $this->db->query("CALL sp_count_ageing_in_bw_days(30, 45, 4)")->row_array();
          $this->db->reconnect();
          $res2 = $this->db->query("CALL sp_count_ageing_in_bw_days(30, 45, 3)")->row_array();
          $this->db->reconnect();
          $data['park_ag30_45'] = $res1['numrows'] + $res2['numrows'];
          $data['total_park_ageing'] = $data['park_age_above_60'] + $data['park_age_lessthan_30'] + $data['park_ag45_60'] + $data['park_ag30_45'];
          $data['total_age_above_60'] = $data['purch_age_above_60'] + $data['park_age_above_60'];
          $data['total_ag45_60'] = $data['purch_ag45_60'] + $data['park_ag45_60'];
          $data['total_ag30_45'] = $data['purch_ag30_45'] + $data['park_ag30_45'];
          $data['total_age_lessthan_30'] = $data['purch_age_lessthan_30'] + $data['park_age_lessthan_30'];
          $data['grand_total'] = $data['total_age_above_60'] + $data['total_ag45_60'] + $data['total_ag30_45'] + $data['total_age_lessthan_30'];

          return $data;
     }
     public function AgeingCountGreaterOrLess($gl, $no, $type)
     { //val_is_sold =0 dbt
          $sql = "SELECT  val_id
FROM    cpnl_valuation_1
WHERE   datediff(current_date,date(val_purchased_date)) $gl $no AND val_type=$type AND val_re_evaluated=0";
          $query = $this->db->query($sql);
          return $query->num_rows();
          //            SELECT  COUNT(val_id) AS `numrows`
          //FROM    cpnl_valuation
          //WHERE   datediff(current_date,date(val_purchased_date)) > 60 AND val_type=1 AND val_re_evaluated=0
     }
     function stock_status_count()
     {
          $this->db->select('val_id ,val_veh_no,val_showroom,val_brand,val_model,val_variant,val_type,val_model_year,val_km,val_status,val_refurb_status,val_refurb_remark,val_model,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' . $this->tbl_showroom . '.shr_location,')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id  = ' . $this->tbl_valuation . '.val_showroom', 'LEFT');
          $this->db->where($this->tbl_valuation . '.val_re_evaluated =', 0);
          $this->db->from($this->tbl_valuation);
          $query = $this->db->get();
          $res = $query->num_rows();
          return $res;
     }
     function getBookedStockReport($limit = 4, $start = 0, $month)
     {
          //  $month=10 ;
          $res = $this->db->query("CALL sp_booked_stock_report($limit, $start,$month)")->result_array(); //sp_month_wise_booked_report
          $this->db->reconnect();
          //debug($res);
          return $res;
     }

     function BookedStockReportCount($month)
     {
          //debug($month);
          //  $month=10 ;
          $res = $this->db->query("CALL sp_booked_stock_report_count($month)")->row_array();
          $this->db->reconnect();
          //debug($res);
          return $res;
     }
     function purchase_report($limit = 4, $start = 0, $month)
     {
          /*  $this->db->select('val_id,val_cust_source,val_veh_no, val_showroom, val_brand, val_model, val_variant, val_type, val_km, val_status, val_model_year, val_next_serv_date, val_next_serv_km, val_refurb_status, val_refurb_remark, val_purchased_date,' . $this->tbl_brand . '.brd_title,'. $this->tbl_model . '.mod_title,'. $this->tbl_variant . '.var_variant_name,'. $this->tbl_showroom . '.shr_location,'.$this->tbl_statuses.'.sts_title as status,')
       ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'LEFT')
       ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'LEFT')
       ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'LEFT')
       ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id  = ' . $this->tbl_valuation . '.val_showroom', 'LEFT')
       ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value  = ' . $this->tbl_valuation . '.val_status', 'LEFT');
       $this->db->where($this->tbl_valuation . '.val_re_evaluated =', 0);
       $this->db->from($this->tbl_valuation);
       $this->db->order_by('val_purchased_date', "desc");
       $this->db->limit($limit, $start);
       $query = $this->db->get();
       $res = $query->result_array();
       // echo $this->db->last_query();
       //exit; */
          error_reporting(0);
          $res = $this->db->query("CALL sp_purchase_report($limit, $start,$month)")->result_array();
          $this->db->reconnect();
          return $res;
     }
     function purchase_report_count($month)
     {
          /*  $this->db->select('val_id,val_cust_source,val_veh_no, val_showroom, val_brand, val_model, val_variant, val_type, val_km, val_status, val_model_year, val_next_serv_date, val_next_serv_km, val_refurb_status, val_refurb_remark, val_purchased_date,' . $this->tbl_brand . '.brd_title,'. $this->tbl_model . '.mod_title,'. $this->tbl_variant . '.var_variant_name,'. $this->tbl_showroom . '.shr_location,'.$this->tbl_statuses.'.sts_title as status,')
       ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'LEFT')
       ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'LEFT')
       ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'LEFT')
       ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id  = ' . $this->tbl_valuation . '.val_showroom', 'LEFT')
       ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value  = ' . $this->tbl_valuation . '.val_status', 'LEFT');
       $this->db->where($this->tbl_valuation . '.val_re_evaluated =', 0);
       $this->db->from($this->tbl_valuation);
       $this->db->order_by('val_purchased_date', "desc");
       $this->db->limit($limit, $start);
       $query = $this->db->get();
       $res = $query->result_array();
       // echo $this->db->last_query();
       //exit; */
          error_reporting(0);
          $res = $this->db->query("CALL sp_purchase_report_count($month)")->row_array();
          $this->db->reconnect();
          return $res;
     }
     public function statusWithHomeVisit($shrm = 1)
     { //rcd jsk shrm
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          error_reporting(0);
          $res['enqData'] = $this->db->query("CALL sp_status_with_home_visit($shrm,$assign,$enqReOpnd)")->row_array();
          $this->db->reconnect();
          $res['shrm'] = $shrm;
          return $res;
     }
     function targetVsAchievement($shrm, $sub = 0)
     {
          /*
       SELECT cpnl_staff_targets.*,`cpnl_users`.`usr_showroom`,`cpnl_users`.`usr_first_name` FROM `cpnl_staff_targets` LEFT JOIN cpnl_users
       ON cpnl_staff_targets.`st_user_id` = cpnl_users.`usr_id` WHERE 1
      */
          $year = date("Y");
          error_reporting(0);
          $satffInfo = $this->db->query("CALL sp_satff_targets($sub,$shrm,$year)")->result_array();
          $this->db->reconnect();
          //  $satffInfo['sub']=$sub;
          // debug($satffInfo);
          foreach ($satffInfo as $key => $value) {
               error_reporting(0);
               $res = $this->db->query("CALL sp_sales_target_vs_achievement($sub,$value[st_user_id],$shrm)")->row_array();
               $this->db->reconnect();
               $res['staff'] = $value['satff_name'];
               $res['staff_id'] = $value['st_user_id'];
               $res['target'] = $value['st_1st_week_target'] + $value['st_2nd_week_target'] + $value['st_3rd_week_target'] + $value['st_4th_week_target'];
               $return[] = $res;
          }
          //debug($return);
          return $return;
     }
     function weeklyTargetVsAchivement($shrm = 1, $status)
     { //rcd jsk shrm
          $sub = 1;
          // debug($status);
          /*
       SELECT cpnl_staff_targets.*,`cpnl_users`.`usr_showroom`,`cpnl_users`.`usr_first_name` FROM `cpnl_staff_targets` LEFT JOIN cpnl_users
       ON cpnl_staff_targets.`st_user_id` = cpnl_users.`usr_id` WHERE 1
      */
          $frstWkStringDay = date("Y-m-01", strtotime("-1 months"));
          $frstWkEndngday = date("Y-m-08", strtotime("-1 months")); //2021-09-08
          $secWkEndngday = date("Y-m-15", strtotime("-1 months"));
          $thirdWkEndngday = date("Y-m-22", strtotime("-1 months"));
          $thisMonthFirstDay = date("Y-m-01");
          $year = date('Y');
          error_reporting(0);
          $satffInfo = $this->db->query("CALL sp_satff_targets($sub,$shrm,$year)")->result_array();
          $this->db->reconnect();
          // return $satffInfo;
          foreach ($satffInfo as $key => $value) {
               error_reporting(0);
               if ($status == 'booked') {
                    $status_1 = 28; //booking confirmed
                    $status_2 = 13; //booked
                    $res = $this->db->query("CALL sp_weekly_sl_target_vs_achivement($value[st_user_id],$shrm,$status_1,$status_2,'$frstWkStringDay','$frstWkEndngday','$frstWkEndngday','$secWkEndngday','$secWkEndngday','$thirdWkEndngday','$thirdWkEndngday','$thisMonthFirstDay')")->row_array();
               } elseif ($status == 'delivered') {
                    $status = 40; //delivered
                    $res = $this->db->query("CALL sp_weekly_sales_target_vs_achivement($value[st_user_id],$shrm,$status,'$frstWkStringDay','$frstWkEndngday','$frstWkEndngday','$secWkEndngday','$secWkEndngday','$thirdWkEndngday','$thirdWkEndngday','$thisMonthFirstDay')")->row_array();
               }
               //latest $res = $this->db->query("CALL sp_weekly_sales_target_vs_achivement($value[st_user_id],$shrm,$status,'$frstWkStringDay','$frstWkEndngday','$frstWkEndngday','$secWkEndngday','$secWkEndngday','$thirdWkEndngday','$thirdWkEndngday','$thisMonthFirstDay')")->row_array();
               // $res = $this->db->query("CALL sp_weekly_sales_target_vs_achivement($value[st_user_id],$shrm,$status,'2021-09-01','2021-09-08','2021-09-08','2021-09-15','2021-09-15','2021-09-22','2021-09-22','2021-10-01')")->row_array(); 
               $this->db->reconnect();

               $res['st_1st_week_target'] = $value['st_1st_week_target'];
               $res['st_2nd_week_target'] = $value['st_2nd_week_target'];
               $res['st_3rd_week_target'] = $value['st_3rd_week_target'];
               $res['st_4th_week_target'] = $value['st_4th_week_target'];
               $res['staff'] = $value['satff_name'];
               $res['staff_id'] = $value['st_user_id'];
               $res['shrm'] = $shrm;
               $res['status'] = $status;
               // $res['target'] = $value['st_1st_week_target']+$value['st_2nd_week_target']+$value['st_3rd_week_target']+$value['st_4th_week_target'];
               $return[] = $res;
          }
          // echo $this->db->last_query();
          // exit;
          return $return;
     }
     public function stockReport($shrm = 1)
     { //rcd jsk shrm
          error_reporting(0);
          $res = $this->db->query("CALL sp_md_stock_report($shrm)")->row_array();
          $this->db->reconnect();
          //debug($res);
          return $res;
     }
     public function expectBooking($shrm = 1)
     { //rcd jsk shrm
          error_reporting(0);
          $res = $this->db->query("CALL sp_expect_booking($shrm)")->result_array();
          $this->db->reconnect();
          //debug($res);
          return $res;
     }

     public function isRptExpectBooking($eb_veh_id, $eb_id, $sale_staff)
     {
          //($eb_veh_id);
          error_reporting(0);
          $res = $this->db->query("CALL sp_repeated_expect_booking($eb_veh_id,$eb_id,$sale_staff)")->result_array();
          $this->db->reconnect();
          //  debug($res);
          return $res;
     }

     public function isBookedOrDelivered($valId, $status)
     {
          // return $valId;
          // debug($valId);
          // vbk_evaluation_veh_id 
          error_reporting(0);
          $res = $this->db->query("CALL sp_is_booked($valId,$status)")->row_array();
          $this->db->reconnect();
          //debug($res['numrows']);
          return $res['numrows'];
     }

     public function expecDelivery($shrm = 1)
     { //rcd jsk shrm
          error_reporting(0);
          $res = $this->db->query("CALL sp_expect_delivery($shrm)")->result_array();
          $this->db->reconnect();
          //debug($res);
          return $res;
     }

     public function isRptExpectDelivery($eb_veh_id, $eb_id, $sale_staff)
     {
          //($eb_veh_id);
          error_reporting(0);
          $res = $this->db->query("CALL sp_repeated_expect_delivery($eb_veh_id,$eb_id,$sale_staff)")->result_array();
          $this->db->reconnect();
          //  debug($res);
          return $res;
     }
     public function summaryEnq($month = 0, $shrm = 0)
     { //sales= enq_cus_status=1 or 3
          $this_month = date('m');
          $shoroom = $this->shrm;
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          if ($month == 0) {
               $month = date('m');
          }
          if ($shrm == 0) {
               $shrm = $this->shrm;
          }
          // debug($shrm);
          error_reporting(0);
          $res = $this->db->query("CALL sp_summary_enq($shrm,$month,$assign,$enqReOpnd)")->result_array();
          $this->db->reconnect();
          // debug($res);
          return $res;
     }
     public function sales_data_bank($limit = 4, $start = 0, $shrm = 1, $month)
     {
          /*  $this->db->select('val_id,val_cust_source,val_veh_no, val_showroom, val_brand, val_model, val_variant, val_type, val_km, val_status, val_model_year, val_next_serv_date, val_next_serv_km, val_refurb_status, val_refurb_remark, val_purchased_date,' . $this->tbl_brand . '.brd_title,'. $this->tbl_model . '.mod_title,'. $this->tbl_variant . '.var_variant_name,'. $this->tbl_showroom . '.shr_location,'.$this->tbl_statuses.'.sts_title as status,')
       ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'LEFT')
       ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'LEFT')
       ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'LEFT')
       ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id  = ' . $this->tbl_valuation . '.val_showroom', 'LEFT')
       ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value  = ' . $this->tbl_valuation . '.val_status', 'LEFT');
       $this->db->where($this->tbl_valuation . '.val_re_evaluated =', 0);
       $this->db->from($this->tbl_valuation);
       $this->db->order_by('val_purchased_date', "desc");
       $this->db->limit($limit, $start);
       $query = $this->db->get();
       $res = $query->result_array();
       // echo $this->db->last_query();
       //exit; */
          // debug($start);
          // $this_month=date('m');
          error_reporting(0);

          $res = $this->db->query("CALL sp_sales_data_bank($limit,$start,$shrm,$month)")->result_array(); //sp_stock_status_report
          $this->db->reconnect();
          //debug($res);
          // debug($this->db->last_query());
          return $res;
     }

     public function sales_data_bankCount($shrm = 1, $month)
     {
          error_reporting(0);

          $res = $this->db->query("CALL sp_sales_data_bank_count($shrm,$month)")->row_array(); //sp_stock_status_report
          $this->db->reconnect();
          return $res['numrows'];
     }

     public function enqData($enq_id)
     {
          error_reporting(0);
          $res = $this->db->query("CALL sp_enq_data($enq_id)")->result_array(); //
          $this->db->reconnect();
          // return $enq_id;
          //debug($res);
          // debug($this->db->last_query());
          return $res;
     }
     public function oldStockReport($limit = 4, $start = 0, $shrm = 1)
     { //val_is_sold =0 dbt
          /* SELECT IF(val_is_sold =1, DATEDIFF(date(val_sold_date),date(val_purchased_date)), DATEDIFF(current_date,date(val_purchased_date))) AS day_in_stock,val_id,val_purchased_date,val_veh_no,val_model_year,val_km,val_is_sold,val_sold_date,val_showroom, rana_model.mod_title, rana_brand.brd_title, rana_variant.var_variant_name
       FROM    cpnl_valuation
       LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_valuation`.`val_model`
       LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_valuation`.`val_brand`
       LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_valuation`.`val_variant`
       WHERE ( ( datediff(current_date,date(val_purchased_date)) > no AND val_is_sold=0 AND val_re_evaluated=0) Or ( datediff(current_date,date(val_purchased_date)) > no AND val_is_sold=1 AND MONTH(cpnl_valuation.val_sold_date) =mnth  AND val_re_evaluated=0 )) AND cpnl_valuation.val_showroom=shrm
       LIMIT `lmt` OFFSET `ofst` */
          $days = 60; //criteria for old stock
          $this_month = date('m');
          error_reporting(0);
          // $res = $this->db->query("CALL sp_old_stock_report($days,$this_month,$shrm,$limit,$start)")->result_array();
          $res = $this->db->query("CALL sp_old_stock_report($days,$this_month,$shrm)")->result_array();
          return $res;
          $this->db->reconnect();
     }

     public function FcPaymentPendingDeals($shrm = 1)
     {

          error_reporting(0);
          // $res = $this->db->query("CALL sp_old_stock_report($days,$this_month,$shrm,$limit,$start)")->result_array();
          $res['pendingPymnts'] = $this->db->query("CALL sp_fc_payment_pending_deals($shrm)")->result_array();
          $res['shrm'] = $shrm;
          return $res;
     }

     public function RcTrnsfrPendings($shrm = 1, $isAbv)
     {
          $this_month = date('m');
          error_reporting(0);
          // $res = $this->db->query("CALL sp_old_stock_report($days,$this_month,$shrm,$limit,$start)")->result_array();
          if ($isAbv == 1) {
               $res['RcPendings'] = $this->db->query("CALL sp_rc_ransfer_pending_list_abv($shrm,30)")->result_array();
               $this->db->reconnect();
               $res['RcTrnfrdThisMnth'] = $this->db->query("CALL sp_rc_ransfered_this_month_abv($shrm,30,$this_month)")->result_array();
               $this->db->reconnect();
          } else {
               $res['RcPendings'] = $this->db->query("CALL sp_rc_ransfer_pending_list_blw($shrm,30)")->result_array();
               $this->db->reconnect();
               $res['RcTrnfrdThisMnth'] = $this->db->query("CALL sp_rc_ransfered_this_month_blw($shrm,30,$this_month)")->result_array();
               $this->db->reconnect();
          }
          $res['shrm'] = $shrm;
          return $res;
     }

     public function InsuranceTrnsfrPendings($shrm = 1)
     {
          error_reporting(0);
          $res['InsrncPendings'] = $this->db->query("CALL sp_insurance_transfer_pending_list($shrm,14)")->result_array();
          $this->db->reconnect();
          $res['shrm'] = $shrm;
          //  debug($res);
          return $res;
     }
     public function purchaseNewLiveEnqs($shrm)
     {
          error_reporting(0);
          //$res = $this->db->query("CALL sp_sales_report_new_and_live_enq_count($shrm)")->row_array();
          $res = $this->db->query("CALL sp_purch_new_and_live_enq_count($shrm)")->row_array();
          $this->db->reconnect();
          //debug( $shrm);
          return $res;
     }

     public function enqStsWithEvl($param)
     {
          error_reporting(0);
          $res = $this->db->query("CALL sp_purch_enq_sts_with_val($shrm)")->row_array();
          $this->db->reconnect();
          return $res;
     }
     public function dailySalesReport($shrm = 1, $status = 28)
     {
          $sub = 0; //or 0
          /*
       SELECT cpnl_staff_targets.*,`cpnl_users`.`usr_showroom`,`cpnl_users`.`usr_first_name` FROM `cpnl_staff_targets` LEFT JOIN cpnl_users
       ON cpnl_staff_targets.`st_user_id` = cpnl_users.`usr_id` WHERE 1
      */
          $frstWkStringDay = date("Y-m-01");
          $frstWkEndngday = date("Y-m-08"); //2021-09-08
          $secWkEndngday = date("Y-m-15");
          $thirdWkEndngday = date("Y-m-22");
          $nextMonthFirstDay = date("Y-m-01", strtotime("+1 months"));
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          $year = date('Y');
          error_reporting(0);
          $satffInfo = $this->db->query("CALL sp_satff_targets($sub,$shrm,$year)")->result_array();
          $this->db->reconnect();
          foreach ($satffInfo as $key => $value) {
               error_reporting(0);
               $res = $this->db->query("CALL sp_daily_sl_target_vs_achivement($value[st_user_id],$shrm,$status,'$frstWkStringDay','$frstWkEndngday','$frstWkEndngday','$secWkEndngday','$secWkEndngday','$thirdWkEndngday','$thirdWkEndngday','$nextMonthFirstDay')")->row_array();
               $this->db->reconnect();
               $res['totalTarget'] = $value['st_1st_week_target'] + $value['st_2nd_week_target'] + $value['st_3rd_week_target'] + $value['st_4th_week_target'];
               $res['totalAchivement'] = $res['1st_week_achivement'] + $res['2nd_week_achivement'] + $res['3rd_week_achivement'] + $res['4th_week_achivement'];
               $res['target1'] = $value['st_1st_week_target'];
               $res['trgt_carryFwd'] = $value['st_1st_week_target'] - $res['1st_week_achivement'];

               $res['target2'] = $value['st_2nd_week_target'] + $res['trgt_carryFwd'];
               $res['trgt_carryFwd'] = $res['target2'] - $res['2nd_week_achivement'];

               $res['target3'] = $value['st_3rd_week_target'] + $res['trgt_carryFwd'];
               $res['trgt_carryFwd'] = $res['target3'] - $res['3rd_week_achivement'];

               $res['target4'] = $value['st_4th_week_target'] + $res['trgt_carryFwd'];
               if (date('d') >= 1 and date('d') <= 7) {
                    $res['this_wk_target'] = $res['target1'];
                    $res['this_wk_achivement'] = $res['1st_week_achivement'];
               } elseif (date('d') >= 8 and date('d') < 15) {
                    $res['this_wk_target'] = $res['target2'];
                    $res['this_wk_achivement'] = $res['2nd_week_achivement'];
               } elseif (date('d') >= 15 and date('d') < 23) {
                    $res['this_wk_target'] = $res['target3'];
                    $res['this_wk_achivement'] = $res['3rd_week_achivement'];
               } elseif (date('d') > 22) {
                    $res['this_wk_target'] = $res['target4'];
                    $res['this_wk_achivement'] = $res['4th_week_achivement'];
               }

               $res['st_1st_week_target'] = $value['st_1st_week_target'];
               $res['st_2nd_week_target'] = $value['st_2nd_week_target'];
               $res['st_3rd_week_target'] = $value['st_3rd_week_target'];
               $res['st_4th_week_target'] = $value['st_4th_week_target'];
               $res['staff'] = $value['satff_name'];
               $res['staff_id'] = $value['st_user_id'];
               $res['shrm'] = $shrm;
               $res['status'] = $status;
               $res['UnslvdBtlneck'] = $this->db->query("CALL sp_unsolved_bottleneck_by_staff_id($value[st_user_id])")->result_array();
               $this->db->reconnect();
               $res['homeVsts'] = $this->db->query("CALL sp_monday_sl_home_vst_trgt_achvmnt($value[st_user_id],$assign,$enqReOpnd)")->row_array();
               $this->db->reconnect();
               $res['parkAndSl'] = $this->db->query("CALL sp_monday_sl_park_and_sl_achvmnt($value[st_user_id])")->row_array();
               $this->db->reconnect();
               $res['agedVehAchvmnt'] = $this->db->query("CALL sp_daily_sl_aged_veh_achvmnt($value[st_user_id])")->row_array();
               $this->db->reconnect();
               $return[] = $res;
          }
          // debug($return);
          return $return;
     }
     public function getEnqCountByStaffAndMdlWithModeOfContact($staff, $mod_id, $frm_date, $to_date)
     {
          //$frm_date = '2021-12-01 00:00:00';
          //$to_date = '2021-12-31 00:00:00';
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          error_reporting(0);
          $res = $this->db->query("CALL sp_get_sl_enq_count_by_staff_mdl($staff,$mod_id,'$frm_date','$to_date',$assign,$enqReOpnd)")->row_array();
          $this->db->reconnect();
          //debug($res);
          return $res;
     }

     public function getStaffs_enq_ByShrm($shrm)
     {
          // $shrm=2;
          if (date('d') >= 1 and date('d') <= 7) {
               $re['strt_date'] = date("Y-m-01");
               $re['end_date'] = date("Y-m-d");
          } elseif (date('d') >= 8 and date('d') < 15) {
               $re['strt_date'] = date("Y-m-08");
               $re['end_date'] = date("Y-m-d");
          } elseif (date('d') >= 15 and date('d') < 23) {
               $re['strt_date'] = date("Y-m-15");
               $re['end_date'] = date("Y-m-d");
          } elseif (date('d') > 22) {
               $re['strt_date'] = date("Y-m-22");
               $re['end_date'] = date("Y-m-d");
          }

          $res['strt_date'] = date("Y-m-d", strtotime($re['strt_date']));
          $res['end_date'] = date("Y-m-d", strtotime($re['end_date']));
          // debug($re);
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;

          error_reporting(0);
          $re['staffs'] = $this->db->query("CALL sp_get_sl_staffs_and_tl_by_shrm($shrm)")->result_array();

          //   debug($staffs);
          $this->db->reconnect();
          foreach ($re['staffs'] as $key => $value) {
               $res['satff_data'] = $value;
               error_reporting(0);
               $res['enqCounts'] = $this->db->query("CALL sp_get_sl_enq_status_monday($value[usr_id],'$res[strt_date]','$res[end_date]',$assign,$enqReOpnd)")->row_array();
               $this->db->reconnect();
               //debug($value);

               $return[] = $res;
          }
          //  debug($return);
          return $return;
     }

     public function dayWiseReport($shrm)
     {
          error_reporting(0);
          $staffs = $this->db->query("CALL sp_get_sl_staffs_by_shrm($shrm)")->result_array();
          $this->db->reconnect();
          foreach ($staffs as $key => $value) {
               $res['staffInfo'] = $value;
               $res['yDayAchvmnt'] = $this->db->query("CALL sp_get_sl_yesterday_achvmnt_by_staff($value[usr_id])")->row_array();
               $this->db->reconnect();
               $res['UnslvdBtlneck'] = $this->db->query("CALL sp_unsolved_bottleneck_by_staff_id($value[usr_id])")->result_array();
               $this->db->reconnect();
               //  debug($res['UnslvdBtlneck']);
               $target = $this->db->query("CALL sp_target_by_staff_id($value[usr_id])")->row_array();
               $res['monthlyTarget'] = $target['st_1st_week_target'] + $target['st_2nd_week_target'] + $target['st_3rd_week_target'] + $target['st_4th_week_target'];
               $this->db->reconnect();

               $achvmnt = $this->db->query("CALL sp_this_month_achivement_by_staff_id($value[usr_id])")->row_array();
               $this->db->reconnect();
               $res['thisMonthAchvmnt'] = $achvmnt['thisMonthAchvmnt'];
               //sp_target_by_staff_id
               $return[] = $res;
          }
          // debug($return);
          return $return;
     }

     public function dailyPurchseReport($shrm = 1, $status = 28)
     {
          $sub = 0; //or 0
          /*
       SELECT cpnl_staff_targets.*,`cpnl_users`.`usr_showroom`,`cpnl_users`.`usr_first_name` FROM `cpnl_staff_targets` LEFT JOIN cpnl_users
       ON cpnl_staff_targets.`st_user_id` = cpnl_users.`usr_id` WHERE 1
      */
          $frstWkStringDay = date("Y-m-01");
          $frstWkEndngday = date("Y-m-08"); //2021-09-08
          $secWkEndngday = date("Y-m-15");
          $thirdWkEndngday = date("Y-m-22");
          $nextMonthFirstDay = date("Y-m-01", strtotime("+1 months"));
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          $year = date('Y');
          //debug($frstWkEndngday);
          error_reporting(0);
          $satffInfo = $this->db->query("CALL sp_purchase_satff_targets($sub,$shrm,$year)")->result_array();
          //debug($satffInfo);
          $this->db->reconnect();
          foreach ($satffInfo as $key => $value) {
               error_reporting(0);
               //sp_daily_purch_target_vs_achivement
               //sp_daily_purch_target_vs_achivement_with_loan	
               $res = $this->db->query("CALL sp_daily_purch_target_vs_achivement($value[st_user_id],$shrm,'$frstWkStringDay','$frstWkEndngday','$frstWkEndngday','$secWkEndngday','$secWkEndngday','$thirdWkEndngday','$thirdWkEndngday','$nextMonthFirstDay')")->row_array();
               $this->db->reconnect();

               $res['totalTarget_purch'] = $value['st_1st_week_target'] + $value['st_2nd_week_target'] + $value['st_3rd_week_target'] + $value['st_4th_week_target'];
               $res['totalAchivement_purch'] = $res['1st_week_achivement_purch'] + $res['2nd_week_achivement_purch'] + $res['3rd_week_achivement_purch'] + $res['4th_week_achivement_purch'];
               $res['totalAchivement_purch_with_loan'] = $res['1st_week_achivement_purch_with_loan'] + $res['2nd_week_achivement_purch_with_loan'] + $res['3rd_week_achivement_purch_with_loan'] + $res['4th_week_achivement_purch_with_loan'];
               $res['totalAchivement_park'] = $res['1st_week_achivement_park'] + $res['2nd_week_achivement_park'] + $res['3rd_week_achivement_park'] + $res['4th_week_achivement_park'];
               $res['target1'] = $value['st_1st_week_target'];
               $res['trgt_carryFwd'] = $value['st_1st_week_target'] - $res['1st_week_achivement_purch'];

               $res['target2'] = $value['st_2nd_week_target'] + $res['trgt_carryFwd'];
               $res['trgt_carryFwd'] = $res['target2'] - $res['2nd_week_achivement_purch'];

               $res['target3'] = $value['st_3rd_week_target'] + $res['trgt_carryFwd'];
               $res['trgt_carryFwd'] = $res['target3'] - $res['3rd_week_achivement_purch'];

               $res['target4'] = $value['st_4th_week_target'] + $res['trgt_carryFwd'];
               if (date('d') >= 1 and date('d') <= 7) {
                    $res['this_wk_target'] = $res['target1'];
                    $res['this_wk_achivement_purch'] = $res['1st_week_achivement_purch'];
                    $res['this_wk_achivement_purch_with_loan'] = $res['1st_week_achivement_purch_with_loan'];
                    $res['this_wk_achivement_park'] = $res['1st_week_achivement_park'];
               } elseif (date('d') >= 8 and date('d') < 15) {
                    $res['this_wk_target'] = $res['target2'];
                    $res['this_wk_achivement_purch'] = $res['2nd_week_achivement_purch'];
                    $res['this_wk_achivement_purch_with_loan'] = $res['2nd_week_achivement_purch_with_loan'];
                    $res['this_wk_achivement_park'] = $res['2nd_week_achivement_park'];
               } elseif (date('d') >= 15 and date('d') < 23) {
                    $res['this_wk_target'] = $res['target3'];
                    $res['this_wk_achivement_purch'] = $res['3rd_week_achivement_purch'];
                    $res['this_wk_achivement_purch_with_loan'] = $res['3rd_week_achivement_purch_with_loan'];
                    $res['this_wk_achivement_park'] = $res['3rd_week_achivement_park'];
               } elseif (date('d') > 22) {
                    $res['this_wk_target'] = $res['target4'];
                    $res['this_wk_achivement_purch'] = $res['4th_week_achivement_purch'];
                    $res['this_wk_achivement_purch_with_loan'] = $res['4th_week_achivement_purch_with_loan'];
                    $res['this_wk_achivement_park'] = $res['4th_week_achivement_park'];
               }

               $res['st_1st_week_target'] = $value['st_1st_week_target'];
               $res['st_2nd_week_target'] = $value['st_2nd_week_target'];
               $res['st_3rd_week_target'] = $value['st_3rd_week_target'];
               $res['st_4th_week_target'] = $value['st_4th_week_target'];
               $res['staff'] = $value['satff_name'];
               $res['staff_id'] = $value['st_user_id'];
               $res['shrm'] = $shrm;
               $res['status'] = $status;
               $res['UnslvdBtlneck'] = $this->db->query("CALL sp_unsolved_bottleneck_by_staff_id($value[st_user_id])")->result_array();
               $this->db->reconnect();
               // $res['homeVsts'] = $this->db->query("CALL sp_monday_sl_home_vst_trgt_achvmnt($value[st_user_id],$assign,$enqReOpnd)")->row_array();
               $this->db->reconnect();
               //  $res['parkAndSl'] = $this->db->query("CALL sp_monday_sl_park_and_sl_achvmnt($value[st_user_id])")->row_array();
               $this->db->reconnect();
               // $res['agedVehAchvmnt'] = $this->db->query("CALL sp_daily_sl_aged_veh_achvmnt($value[st_user_id])")->row_array();
               $this->db->reconnect();
               $return[] = $res;
          }
          // debug($return);
          return $return;
     }

     public function getPurchaseStaffs_enq_ByShrm($shrm)
     {
          // $shrm=2;
          if (date('d') >= 1 and date('d') <= 7) {
               $re['strt_date'] = date("Y-m-01");
               $re['end_date'] = date("Y-m-d");
          } elseif (date('d') >= 8 and date('d') < 15) {
               $re['strt_date'] = date("Y-m-08");
               $re['end_date'] = date("Y-m-d");
          } elseif (date('d') >= 15 and date('d') < 23) {
               $re['strt_date'] = date("Y-m-15");
               $re['end_date'] = date("Y-m-d");
          } elseif (date('d') > 22) {
               $re['strt_date'] = date("Y-m-22");
               $re['end_date'] = date("Y-m-d");
          }

          $res['strt_date'] = date("Y-m-d", strtotime($re['strt_date']));
          $res['end_date'] = date("Y-m-d", strtotime($re['end_date']));
          // debug($re);
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;

          error_reporting(0);
          $re['staffs'] = $this->db->query("CALL sp_get_purchase_staffs_and_tl_by_shrm($shrm)")->result_array();

          //   debug($staffs);
          $this->db->reconnect();
          foreach ($re['staffs'] as $key => $value) {
               $res['satff_data'] = $value;
               error_reporting(0);
               $res['enqCounts'] = $this->db->query("CALL sp_get_purchase_enq_status_monday($value[usr_id],'$res[strt_date]','$res[end_date]',$assign,$enqReOpnd)")->row_array();
               $this->db->reconnect();
               //debug($value);

               $return[] = $res;
          }
          //  debug($return);
          return $return;
     }

     public function dayWiseReportPurchase($shrm)
     {
          error_reporting(0);
          $staffs = $this->db->query("CALL sp_get_purchase_staffs_by_shrm($shrm)")->result_array();
          $this->db->reconnect();
          foreach ($staffs as $key => $value) {
               $res['staffInfo'] = $value;
               $res['yDayAchvmnt'] = $this->db->query("CALL sp_get_sl_yesterday_achvmnt_by_staff($value[usr_id])")->row_array(); //sl or purch
               $this->db->reconnect();
               $res['UnslvdBtlneck'] = $this->db->query("CALL sp_unsolved_bottleneck_by_staff_id($value[usr_id])")->result_array();
               $this->db->reconnect();
               //  debug($res['UnslvdBtlneck']);
               $target = $this->db->query("CALL sp_target_by_staff_id($value[usr_id])")->row_array();
               $res['monthlyTarget'] = $target['st_1st_week_target'] + $target['st_2nd_week_target'] + $target['st_3rd_week_target'] + $target['st_4th_week_target'];
               $this->db->reconnect();

               $achvmnt = $this->db->query("CALL sp_this_month_purchase_achivement_by_staff_id($value[usr_id])")->row_array();
               $this->db->reconnect();
               $res['purchAchvmnt'] = $achvmnt['purchAchvmnt'];
               $res['achvmntPurchWithLoan'] = $achvmnt['achvmntPurchWithLoan'];
               $res['parkAchvmnt'] = $achvmnt['parkAchvmnt'];
               $res['totalAchvmnt'] = $achvmnt['totalAchvmnt'];
               //sp_target_by_staff_id
               //debug($achvmnt);
               $return[] = $res;
          }
          // debug($return);
          return $return;
     }

     public function getStaffsEnqHotListByShrm($shrm)
     {
          if (date('d') >= 1 and date('d') <= 7) {
               $re['strt_date'] = date("Y-m-01");
               $re['end_date'] = date("Y-m-d");
          } elseif (date('d') >= 8 and date('d') < 15) {
               $re['strt_date'] = date("Y-m-08");
               $re['end_date'] = date("Y-m-d");
          } elseif (date('d') >= 15 and date('d') < 23) {
               $re['strt_date'] = date("Y-m-15");
               $re['end_date'] = date("Y-m-d");
          } elseif (date('d') > 22) {
               $re['strt_date'] = date("Y-m-22");
               $re['end_date'] = date("Y-m-d");
          }
          $res['strt_date'] = date("Y-m-d", strtotime($re['strt_date']));
          $res['end_date'] = date("Y-m-d", strtotime($re['end_date']));
          if ($re['strt_date'] == $re['end_date']) {
               $res['end_date'] = date("Y-m-d", strtotime($re['end_date'] . ' + 1 days'));
          }

          // debug($re);
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          error_reporting(0);
          $staffs = $this->db->query("CALL sp_get_sl_staffs_by_shrm($shrm)")->result_array();
          $this->db->reconnect();
          foreach ($staffs as $key => $value) {
               $res['staffInfo'] = $value;
               $res['hotList'] = $this->db->query("CALL sp_get_sl_hot_list_by_staff($value[usr_id],'$res[strt_date]','$res[end_date]',$assign,$enqReOpnd)")->row_array(); //sl or purch
               $this->db->reconnect();
               $return[] = $res;
          }
          return $return;
     }

     public function summaryEnqPurchase($month = 0, $shrm = 0)
     { //sales= enq_cus_status=1 or 3
          $this_month = date('m');
          $shoroom = $this->shrm;
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          if ($month == 0) {
               $month = date('m');
          }
          if ($shrm == 0) {
               $shrm = $this->shrm;
          }
          // debug($shrm);
          error_reporting(0);
          $res = $this->db->query("CALL sp_summary_enq_purchase($shrm,$month,$assign,$enqReOpnd)")->result_array();
          $this->db->reconnect();
          // debug($res);
          return $res;
     }

     public function purchEnqStatusWithEvl($shrm)
     {
          //debug($shrm);
          // $this_month = date('m');
          //$shoroom = $this->shrm;
          $assign = (int) assign_to_other_staff;
          $enqReOpnd = (int) inquiry_reopened;
          //            if ($month == 0) {
          //                 $month = date('m');
          //            }
          if ($shrm == 0) {
               $shrm = $this->shrm;
          }
          // debug($shrm);
          error_reporting(0);
          $res = $this->db->query("CALL sp_purch_enq_status_with_eval($shrm,$assign,$enqReOpnd)")->row_array();
          $this->db->reconnect();
          // debug($res);
          return $res;
     }

     function purchEnqWeeklyTargetAchv($shrm = 1, $status)
     {
          // debug(13123); jsk
          $sub = 1;
          // debug($status);
          /*
          SELECT cpnl_staff_targets.*,`cpnl_users`.`usr_showroom`,`cpnl_users`.`usr_first_name` FROM `cpnl_staff_targets` LEFT JOIN cpnl_users
          ON cpnl_staff_targets.`st_user_id` = cpnl_users.`usr_id` WHERE 1
          */
          $frstWkStringDay = date("Y-m-01", strtotime("-1 months"));
          $frstWkEndngday = date("Y-m-08", strtotime("-1 months")); //2021-09-08
          $secWkEndngday = date("Y-m-15", strtotime("-1 months"));
          $thirdWkEndngday = date("Y-m-22", strtotime("-1 months"));
          $thisMonthFirstDay = date("Y-m-01");
          $year = date('Y');
          error_reporting(0);
          $satffInfo = $this->db->query("CALL sp_purchase_satff_targets($sub,$shrm,$year)")->result_array();
          $this->db->reconnect();
          // return $satffInfo;
          foreach ($satffInfo as $key => $value) {
               error_reporting(0);
               $res = $this->db->query("CALL sp_weekly_sales_target_vs_achivement($value[st_user_id],$shrm,$status,'$frstWkStringDay','$frstWkEndngday','$frstWkEndngday','$secWkEndngday','$secWkEndngday','$thirdWkEndngday','$thirdWkEndngday','$thisMonthFirstDay')")->row_array();
               // $res = $this->db->query("CALL sp_weekly_sales_target_vs_achivement($value[st_user_id],$shrm,$status,'2021-09-01','2021-09-08','2021-09-08','2021-09-15','2021-09-15','2021-09-22','2021-09-22','2021-10-01')")->row_array(); 
               $this->db->reconnect();

               $res['st_1st_week_target'] = $value['st_1st_week_target'];
               $res['st_2nd_week_target'] = $value['st_2nd_week_target'];
               $res['st_3rd_week_target'] = $value['st_3rd_week_target'];
               $res['st_4th_week_target'] = $value['st_4th_week_target'];
               $res['staff'] = $value['satff_name'];
               $res['staff_id'] = $value['st_user_id'];
               $res['shrm'] = $shrm;
               $res['status'] = $status;
               // $res['target'] = $value['st_1st_week_target']+$value['st_2nd_week_target']+$value['st_3rd_week_target']+$value['st_4th_week_target'];
               $return[] = $res;
          }
          // echo $this->db->last_query();
          // exit;
          return $return;
     }

     public function detailedWalikInReport($shrm)
     { //sp_detailed_walikin_report
          error_reporting(0);
          $staffs = $this->db->query("CALL sp_get_sl_staffs_by_shrm($shrm)")->result_array();
          // debug($staffs);
          $this->db->reconnect();
          foreach ($staffs as $key => $value) {
               $res['staffInfo'] = $value;
               $res['yDayWalkin'] = $this->db->query("CALL sp_detailed_walikin_report($value[usr_id])")->row_array();
               $this->db->reconnect();
               $return[] = $res;
          }
          // debug($return);
          //  debug($return);
          return $return;
     }
     public function refurbStocks($div = '', $shrm = '')
     {
          if ($div) {
               if ($div == 2 && $shrm == '') {

                    $res = $this->db->query("CALL sp_refurb_stocks_luxury()")->result_array();
               } elseif ($shrm) {

                    $res = $this->db->query("CALL sp_refurb_stocks_by_shrm($shrm)")->result_array();
               } elseif ($div == 1) {
                    $res = $this->db->query("CALL sp_refurb_stocks_smart()")->result_array();
               }
          } else {
               $res = $this->db->query("CALL sp_refurb_stocks_all()")->result_array();
          }
          error_reporting(0);
          $this->db->reconnect();
          return $res;
     }

     function getHomeVisitReport($filter = '')
     {
          if (check_permission('home_visit_report', 'hw_smart_only') and !check_permission('home_visit_report', 'hw_all')) { //1=smart,2=luxury
               $shrms = explode(',', $this->db->select('GROUP_CONCAT(shr_id ) AS shr_id')->where('shr_division', 1)
                    ->get($this->tbl_showroom)->row()->shr_id);
          } elseif (check_permission('home_visit_report', 'hw_luxury_only') and !check_permission('home_visit_report', 'hw_all')) {
               $shrms = explode(',', $this->db->select('GROUP_CONCAT(shr_id ) AS shr_id')->where('shr_division', 2)
                    ->get($this->tbl_showroom)->row()->shr_id);
          }

          $qry = $this->db->select($this->tbl_home_visits . '.*,' .
               ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,enqaddedby.usr_departments,' .
               $this->tbl_travel_modes . '.dtm_title,' . $this->tbl_valuation . '.val_veh_no,' .
               $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' .
               $this->tbl_valuation . '.val_variant,' . $this->tbl_brand . '.brd_title,' .
               $this->tbl_model . '.mod_title,' . $this->tbl_variant .
               '.var_variant_name,' . $this->tbl_users .
               '.usr_first_name AS travel_with,' . $this->tbl_enquiry .
               '.enq_cus_name,' . $this->tbl_enquiry .
               '.enq_cus_address,' . $this->tbl_enquiry .
               '.enq_cus_mobile,' . $this->tbl_enquiry .
               '.enq_cus_city,' . $this->tbl_enquiry .
               '.enq_cus_dist,' . $this->tbl_enquiry .
               '.enq_cus_age,' . $this->tbl_enquiry .
               '.enq_number,' . $this->tbl_enquiry .
               '.enq_cus_when_buy', false) //enq_cus_when_buy
               ->join($this->tbl_travel_modes, $this->tbl_travel_modes . '.dtm_id = ' . $this->tbl_home_visits . '.hmv_travel_mod', 'left')
               ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_home_visits . '.hmv_added_by', 'LEFT')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id  = ' . $this->tbl_home_visits . '.hmv_veh_stock_id', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id  = ' . $this->tbl_home_visits . '.hmv_travel_with', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id  = ' . $this->tbl_home_visits . '.hmv_enq_id', 'left');
          // ->join($this->tbl_home_visits_approvals, $this->tbl_home_visits_approvals . '.hmva_master_id  = ' . $this->tbl_home_visits . '.hmv_id ', 'left')
          //->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_home_visits_approvals . '.hmva_approved_by', 'LEFT')
          //->where('hmv_added_by', $this->uid); 
          //$qaryfltr
          if (@$filter['hot_status']) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $filter['hot_status']);
          }
          if (@$filter['is_visited']) {
               $this->db->where($this->tbl_home_visits . '.hmv_in_date is NOT NULL', NULL, FALSE);
          }

          ////////$        
          $hmv_date_from = (isset($filter['hmv_date_frm']) && !empty($filter['hmv_date_frm'])) ?
               date('Y-m-d', strtotime($filter['hmv_date_frm'])) : '';

          $hmv_date_to = (isset($filter['hmv_date_to']) && !empty($filter['hmv_date_to'])) ?
               date('Y-m-d', strtotime($filter['hmv_date_to'])) : '';

          if (!empty($hmv_date_from) && !empty($hmv_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_home_visits . '.' . 'hmv_date' . ') >= DATE(' . "'" . $hmv_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_home_visits . '.' . 'hmv_date' . ') <= DATE(' . "'" . $hmv_date_to . "'" . ') )');
          }
          if (@$filter['staff']) {
               $this->db->where($this->tbl_home_visits . '.hmv_added_by', $filter['staff']);
          }
          //////@

          if (check_permission('home_visit_report', 'hw_my_team') and !check_permission('home_visit_report', 'hw_all')) {
               $this->db->where('enqaddedby.usr_tl', $this->uid);
          }
          if ((check_permission('home_visit_report', 'hw_smart_only') or check_permission('home_visit_report', 'hw_luxury_only')) and (!check_permission('home_visit_report', 'hw_all'))) {

               $this->db->where_in($this->tbl_enquiry . '.enq_showroom_id', $shrms);
          }
          if (check_permission('home_visit_report', 'hw_luxury_sales_only') and !check_permission('home_visit_report', 'hw_all')) {
               $this->db->where('enqaddedby.usr_departments', 6);
          }
          if (check_permission('home_visit_report', 'hw_smart_sales_only') and !check_permission('home_visit_report', 'hw_all')) {
               $this->db->where('enqaddedby.usr_departments', 4);
          }
          if (check_permission('home_visit_report', 'hw_luxury_purchase_only') and !check_permission('home_visit_report', 'hw_all')) {
               $this->db->where('enqaddedby.usr_departments', 8);
          }
          if (check_permission('home_visit_report', 'hw_smart_purchase_only') and !check_permission('home_visit_report', 'hw_all')) {
               $this->db->where('enqaddedby.usr_departments', 7);
          }
          if (check_permission('home_visit_report', 'hw_my_shwroom') and !check_permission('home_visit_report', 'hw_all')) {
               $this->db->where('enqaddedby.usr_showroom', $this->shrm);
          }
          //@qaryfltr
          if (check_permission('home_visit_report', 'hw_all') or check_permission('home_visit_report', 'hw_smart_only') or check_permission('home_visit_report', 'hw_my_own') or check_permission('home_visit_report', 'hw_my_team') or check_permission('home_visit_report', 'hw_smart_purchase_only') or check_permission('home_visit_report', 'hw_smart_sales_only') or check_permission('home_visit_report', 'hw_my_shwroom') or check_permission('home_visit_report', 'hw_luxury_only') or check_permission('home_visit_report', 'hw_luxury_purchase_only') or check_permission('home_visit_report', 'hw_luxury_sales_only')) {
               return $qry->order_by($this->tbl_home_visits . '.hmv_date', 'DESC')
                    ->get($this->tbl_home_visits)->result_array();
          }
     }
     //@home visit//
     function getTravelModes()
     {
          return $this->db->get($this->tbl_travel_modes)->result_array();
     }
     public function checklistDetails()
     {
          $res = $this->db->query("CALL sp_get_checklist_details()")->result_array();
          error_reporting(0);
          $this->db->reconnect();
          return $res;
     }
     public function checklistDetailsAjx($postDatas)
     {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          $query = "CALL sp_get_checklist_details_by_page($rowperpage, $row, '$searchValue')";
          $data = $this->db->query($query)->result_array();
          error_reporting(0);
          $this->db->reconnect();
          $totalRecords = $this->getChkCount($searchValue);
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }
     public function getChkCount($searchValue = '')
     {
          $query = $this->db->query("SELECT COUNT(*) as count FROM (
             SELECT pcl_val_id, pcl_vehicle_reg_no, cpnl_valuation.val_enquiry_id, pcl_created_at, cpnl_users.usr_username
             FROM cpnl_purchase_check_list_details
             JOIN cpnl_chklist_cat_item ON cpnl_purchase_check_list_details.Pcld_check_list_item_id = cpnl_chklist_cat_item.chitem_id
             JOIN cpnl_purchase_check_list ON pcld_check_list_master_id = pcl_check_list_id
             JOIN cpnl_valuation ON cpnl_valuation.val_id = cpnl_purchase_check_list.pcl_val_id
             JOIN cpnl_users ON cpnl_valuation.val_evaluator = cpnl_users.usr_id
             JOIN rana_brand ON cpnl_valuation.val_brand = rana_brand.brd_id
             JOIN rana_model ON cpnl_valuation.val_model = rana_model.mod_id
             JOIN rana_variant ON cpnl_valuation.val_variant = rana_variant.var_id
             WHERE cpnl_valuation.val_status = 39
             AND (
                 pcl_vehicle_reg_no LIKE CONCAT('%', ?, '%')
                 OR val_enquiry_id LIKE CONCAT('%', ?, '%')
                 OR val_stock_num LIKE CONCAT('%', ?, '%')
                 OR pcl_created_at LIKE CONCAT('%', ?, '%')
                 OR usr_username LIKE CONCAT('%', ?, '%')
             )
             GROUP BY pcl_val_id, pcl_vehicle_reg_no, cpnl_valuation.val_enquiry_id, pcl_created_at, cpnl_users.usr_username
         ) AS subquery", array($searchValue, $searchValue, $searchValue, $searchValue, $searchValue));

          $result = $query->row()->count;

          $query->free_result(); // Clear the result set

          // Close the current result set
          $this->db->close();

          return $result;
     }

     function registerPendingForReassign($user)
     {
          //$this->tbl_groups . '.grp_slug' => 'TC', 
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
          $select = "CONCAT(" . $this->tbl_register_master . '.vreg_id' . "," . "'-'," . $this->tbl_register_master . '.vreg_cust_phone,' . "'-'," . ",addedby.usr_username) as asign";
          $this->db->select($select, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left');

          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses)->where('vreg_assigned_to', $user)->where('(vreg_is_punched = 0)');
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
          //if (check_permission('registration', 'not_show_visitors_in_myregister')) {
          $this->db->where_not_in('vreg_contact_mode', array(40));
          //} 
          return $this->db->select($select, false)->get($this->tbl_register_master)->result_array();
     }

     function customercomplaints()
     {
          $selectArray = array(
               $this->tbl_register_master . '.vreg_id', $this->tbl_register_master . '.vreg_assigned_to',
               $this->tbl_register_master . '.vreg_added_by', $this->tbl_register_master . '.vreg_contact_mode',
               $this->tbl_register_master . '.vreg_district', $this->tbl_register_master . '.vreg_tsc_comments',
               $this->tbl_register_master . '.vreg_added_on', $this->tbl_register_master . '.vreg_cust_name',
               $this->tbl_register_master . '.vreg_cust_phone', $this->tbl_register_master . '.vreg_email',
               $this->tbl_register_master . '.vreg_cust_place', $this->tbl_register_master . '.vreg_existing_vehicle',
               $this->tbl_register_master . '.vreg_occupation', $this->tbl_register_master . '.vreg_customer_status',
               $this->tbl_register_master . '.vreg_type_of_visit', $this->tbl_register_master . '.vreg_tsc_comments',
               $this->tbl_register_master . '.vreg_division', $this->tbl_register_master . '.vreg_showroom',
               $this->tbl_register_master . '.vreg_event', $this->tbl_register_master . '.vreg_is_effective',
               $this->tbl_register_master . '.vreg_entry_date', $this->tbl_register_master . '.vreg_is_punched',
               $this->tbl_register_master . '.vreg_customer_remark', $this->tbl_register_master . '.vreg_inquiry',
               $this->tbl_register_master . '.vreg_cust_place', $this->tbl_register_master . '.vreg_last_action',
               $this->tbl_register_master . '.vreg_call_type',
               'assign.usr_first_name AS assign_usr_first_name', 'assign.usr_last_name AS assign_usr_last_name',
               'assign.usr_division AS div_id', 'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name', 'exstse.usr_username AS exstse_usr_username',
               $this->tbl_enquiry . '.enq_current_status', $this->tbl_callcenterbridging . '.ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus_id', $this->tbl_departments . '.dep_name',
               $this->tbl_district_statewise . '.*',
          );
          return $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
               ->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = ' . 'exstse.usr_id', 'left')
               ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left')
               ->where('(vreg_department = 5 OR vreg_department = 9)')->where("DATE(vreg_added_on) >= '2023-10-17'")->order_by('vreg_added_on', 'DESC')
               ->get($this->tbl_register_master)->result_array();
     }
}
