<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class dar_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();

          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_accounts = TABLE_PREFIX . 'accounts';
          $this->tbl_followup = TABLE_PREFIX . 'followup';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_dar_master = TABLE_PREFIX . 'dar_master';
          $this->tbl_dar_enquiry = TABLE_PREFIX . 'dar_enquiry';
          $this->tbl_contact_mode = TABLE_PREFIX . 'contact_mode';
          $this->tbl_dar_followup = TABLE_PREFIX . 'dar_followup';
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
          $this->tbl_register_history = TABLE_PREFIX . 'register_history';
          $this->tbl_dar_reg_followup = TABLE_PREFIX . 'dar_reg_followup';
          $this->tbl_dar_veh_register = TABLE_PREFIX . 'dar_veh_register';
          $this->tbl_register_followup = TABLE_PREFIX . 'register_followup';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
          $this->view_enquiry_vehicle_master = TABLE_PREFIX . 'view_enquiry_vehicle_master';
     }

     function todaysEnquires()
     {
          $this->db->query("SET time_zone = '+05:30'");
          $today = date('Y-m-d');
          if ($this->usr_grp == 'TL') {
               $mystaffs = array();

               //   $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               //                        ->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $this->uid);
          }
          $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_contact_mode . '.*')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_enquiry . '.enq_mode_enq', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
               ->like($this->tbl_enquiry . '.enq_added_on', $today, 'both')
               ->where($this->tbl_enquiry . '.enq_id NOT IN (SELECT dare_enq FROM ' . $this->tbl_dar_enquiry . ')');
          if ($this->usr_grp == 'DE' || $this->usr_grp == 'MG') {
               $return['inquires'] = $this->db->where($this->tbl_enquiry . '.enq_added_by', $this->uid)->get($this->tbl_enquiry)->result_array();
          } else if ($this->usr_grp == 'TC' || $this->usr_grp == 'SE' || $this->usr_grp == 'TL' || $this->usr_grp == 'MG' || $this->usr_grp == 'EV') {
               if ($this->usr_grp == 'TL') {
                    $return['inquires'] = $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs)->get($this->tbl_enquiry)->result_array();
               } else {
                    $return['inquires'] = $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid)->get($this->tbl_enquiry)->result_array();
               }
               //Mode of contact
               $return['mod_of_contact'] = $this->db->select("enq_mode_enq, COUNT(enq_mode_enq) enq_mode_enq_count, " . $this->tbl_contact_mode . ".cmd_title")
                    ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_enquiry . '.enq_mode_enq')
                    ->where('DATE(' . $this->tbl_enquiry . '.enq_added_on) = ' . "DATE('" . $today . "')")
                    ->where($this->tbl_enquiry . '.enq_id NOT IN (SELECT dare_enq FROM ' . $this->tbl_dar_enquiry . ')')
                    ->where($this->tbl_enquiry . '.enq_se_id', $this->uid)
                    ->group_by('enq_mode_enq')->get($this->tbl_enquiry)->result_array();

               //Mode of contact
               $return['type'] = $this->db->select("enq_cus_status, COUNT(enq_cus_status) enq_cus_status_count")
                    ->where('DATE(' . $this->tbl_enquiry . '.enq_added_on) = ' . "DATE('" . $today . "')")
                    ->where($this->tbl_enquiry . '.enq_id NOT IN (SELECT dare_enq FROM ' . $this->tbl_dar_enquiry . ')')
                    ->where($this->tbl_enquiry . '.enq_se_id', $this->uid)
                    ->group_by('enq_cus_status')->get($this->tbl_enquiry)->result_array();

               //Mode of contact
               $return['hwc'] = $this->db->select("enq_cus_when_buy, COUNT(enq_cus_when_buy) enq_cus_when_buy_count")
                    ->where('DATE(' . $this->tbl_enquiry . '.enq_added_on) = ' . "DATE('" . $today . "')")
                    ->where($this->tbl_enquiry . '.enq_id NOT IN (SELECT dare_enq FROM ' . $this->tbl_dar_enquiry . ')')
                    ->where($this->tbl_enquiry . '.enq_se_id', $this->uid)
                    ->group_by('enq_cus_when_buy')->get($this->tbl_enquiry)->result_array();
          }
          //            debug($return);
          return $return;
     }

     function todaysFollowups()
     {

          if ($this->usr_grp == 'TL') {
               //   $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               //                        ->get($this->tbl_users)->row()->usr_id);
               $mystaffs = array();
               array_push($mystaffs, $this->uid);

               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               //->get($this->tbl_enquiry)->result_array();
          } else {
               //$this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
               $this->db->where('(' . $this->tbl_followup . '.foll_added_by = ' . $this->uid . ' OR ' . $this->tbl_followup . '.foll_updated_by = ' . $this->uid . ')');
          }

          $today = date('Y-m-d');
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'EV' || $this->usr_grp == 'DE') {
               return $this->db->select($this->tbl_followup . '.*,' . $this->tbl_enquiry . '.*,' . $this->tbl_model . '.*,' .
                    $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_enquiry . '.*,' . $this->tbl_vehicle . '.*')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_followup . '.foll_cus_id', 'LEFT')
                    ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'left')
                    ->where('(DATE(' . $this->tbl_followup . ".foll_entry_date) = " . "DATE('" . $today . "')" .
                         ' OR DATE(' . $this->tbl_followup . '.foll_customer_feedback_added_date) = ' . "DATE('" . $today . "')" . ') '
                         . 'AND ' . $this->tbl_followup . '.foll_customer_feedback IS NOT NULL')
                    ->get($this->tbl_followup)->result_array();
          } else if ($this->usr_grp == 'TC' || $this->usr_grp == 'TL' || $this->usr_grp == 'MG') {
               return $this->db->select($this->tbl_followup . '.*,' . $this->tbl_enquiry . '.*,' . $this->tbl_model . '.*,' .
                    $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_enquiry . '.*,' . $this->tbl_vehicle . '.*')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_followup . '.foll_cus_id', 'LEFT')
                    ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'left')
                    ->where('(DATE(' . $this->tbl_followup . ".foll_entry_date) = " . "DATE('" . $today . "')" .
                         ' OR DATE(' . $this->tbl_followup . '.foll_customer_feedback_added_date) = ' . "DATE('" . $today . "')" . ') '
                         . 'AND ' . $this->tbl_followup . '.foll_customer_feedback IS NOT NULL')
                    ->get($this->tbl_followup)->result_array();
          }

          //
          /* if ($this->uid == 609) {
              echo $this->db->last_query();
              debug($return);
              } else {
              return $return;
              } */
     }

     function todaysRegistrations()
     {
          $today = date('Y-m-d');
          if (check_permission('registration', 'reassigntosalesstaff')) { // for tele sales coordinator
               //$this->db->where('regh_added_by', $this->uid);
               $this->db->where('vreg_first_owner', $this->uid);
               $selArr = array(
                    //$this->tbl_register_history . '.regh_remarks',
                    //$this->tbl_register_history . '.regh_system_cmd',
                    $this->tbl_register_master . '.vreg_id',
                    $this->tbl_register_master . '.vreg_cust_name',
                    $this->tbl_register_master . '.vreg_cust_phone',
                    $this->tbl_register_master . '.vreg_inquiry',
                    $this->tbl_register_master . '.vreg_cust_place',
                    $this->tbl_register_master . '.vreg_contact_mode',
                    $this->tbl_register_master . '.vreg_customer_remark',
                    $this->tbl_contact_mode . '.*',
                    $this->tbl_brand . '.*',
                    $this->tbl_variant . '.*',
                    $this->tbl_model . '.*'
               );
               return $this->db->select($selArr, false)
                    //->join($this->tbl_register_master, $this->tbl_register_history . '.regh_register_master = ' . $this->tbl_register_master . '.vreg_id', 'LEFT')
                    ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_register_master . '.vreg_contact_mode', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                    //->like($this->tbl_register_history . '.regh_added_date', $today, 'both')
                    ->like($this->tbl_register_master . '.vreg_added_on', $today, 'both')
                    ->get($this->tbl_register_master)->result_array();
          } else {

               $this->db->where('vreg_first_owner', $this->uid);
               return $this->db->select($this->tbl_register_master . '.*,' . $this->tbl_contact_mode . '.*,' .
                    $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_model . '.*')
                    ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_register_master . '.vreg_contact_mode', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                    ->like($this->tbl_register_master . '.vreg_added_on', $today, 'both')
                    /* ->where('(DATE(' . $this->tbl_register_master . '.vreg_added_on) = ' . "DATE('" . $today . "')" .
                              ' OR DATE(' . $this->tbl_register_master . '.vreg_entry_date) = ' . "DATE('" . $today . "'))") */
                    //->where($this->tbl_register_master . '.vreg_id NOT IN (SELECT dvr_register FROM ' . $this->tbl_dar_veh_register . ')')
                    ->get($this->tbl_register_master)->result_array();
          }
     }

     function processDar($data)
     {

          $timeframe = date('H:i:s', strtotime(get_settings_by_key('DAR_time_frame')));
          $closingDay = get_settings_by_key('DAR_closing_day');

          if (date('H:i:s') <= $timeframe) { // Yesterdy
               $yesterday = date('Y-m-d H:i:s', strtotime('-' . $closingDay . ' Day'));

               $this->db->where('DATE(' . $this->tbl_dar_master . ".darm_added_on) = DATE('" . $yesterday . "')");
               $this->db->where($this->tbl_dar_master . '.darm_added_by = ' . $this->uid);
               $isYesterdaySubmitted = $this->db->from($this->tbl_dar_master)->count_all_results();

               if ($isYesterdaySubmitted < 0) {
                    $data['master']['darm_added_on'] = date('Y-m-d H:i:s', strtotime('-' . $closingDay . ' Day'));
               }
          }

          if (!empty($data)) {
               if (isset($data['master']) && !empty($data['master'])) {
                    $data['master']['darm_added_on'] = date('Y-m-d H:i:s');
                    $this->db->insert($this->tbl_dar_master, array_filter($data['master']));
                    $masterId = $this->db->insert_id();

                    if (isset($data['accounts']) && !empty($data['accounts'])) {
                         $data['accounts']['acc_head'] = 1;
                         $data['accounts']['acc_relation'] = $masterId;
                         $data['accounts']['acc_added_by'] = $this->uid;
                         $data['accounts']['acc_added_on'] = date('Y-m-d H:i:s'); //17-02-2021
                         $this->db->insert($this->tbl_accounts, $data['accounts']);
                         $accId = $this->db->insert_id();
                         generate_log(array(
                              'log_title' => 'Add a records',
                              'log_desc' => 'New account inster against-DAR:' . $masterId,
                              'log_controller' => 'new-account',
                              'log_action' => 'C',
                              'log_ref_id' => $accId,
                              'log_added_by' => $this->uid
                         ));
                    }

                    if (!empty($masterId)) {
                         //Enquiry
                         if (isset($data['enquiry']) && !empty($data['enquiry'])) {
                              foreach ($data['enquiry'] as $key => $value) {
                                   $value['dare_master'] = $masterId;
                                   $this->db->insert($this->tbl_dar_enquiry, array_filter($value));
                              }
                         }

                         //Followup
                         if (isset($data['followup']) && !empty($data['followup'])) {
                              foreach ($data['followup'] as $key => $drFollow) {
                                   $drFollow['darf_master'] = $masterId;
                                   $this->db->insert($this->tbl_dar_followup, array_filter($drFollow));

                                   //Update dar submited on followup table
                                   $this->db->where('foll_id', $drFollow['darf_followup']);
                                   $this->db->update($this->tbl_followup, array('foll_is_dar_submited' => 1));
                              }
                         }

                         //register
                         if (isset($data['register']) && !empty($data['register'])) {
                              foreach ($data['register'] as $key => $regValue) {
                                   $regValue['dvr_master'] = $masterId;
                                   $this->db->insert($this->tbl_dar_veh_register, array_filter($regValue));
                              }
                         }

                         //Register followup
                         if (isset($data['regFollowup']) && !empty($data['regFollowup'])) {
                              foreach ($data['regFollowup'] as $key => $regFValue) {
                                   $regFValue['darrf_dar_master'] = $masterId;
                                   $regFValue['darrf_added_on'] = date('Y-m-d H:i:s');
                                   $this->db->insert($this->tbl_dar_reg_followup, array_filter($regFValue));
                              }
                         }
                    }
                    generate_log(array(
                         'log_title' => 'Add a records',
                         'log_desc' => 'Staff added a dar record',
                         'log_controller' => strtolower(__CLASS__),
                         'log_action' => 'C',
                         'log_ref_id' => $masterId,
                         'log_added_by' => $this->uid
                    ));
               }
               return true;
          } else {
               generate_log(array(
                    'log_title' => 'Add a records',
                    'log_desc' => 'Error occured while add dar record',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'C',
                    'log_ref_id' => 0,
                    'log_added_by' => $this->uid
               ));
               return false;
          }
          exit;
     }

     function getDarInformation($darId = 0, $isToday = false)
     {
          $selArray = array(
               $this->tbl_dar_master . '.darm_is_verified',
               $this->tbl_dar_master . '.darm_id',
               $this->tbl_dar_master . '.darm_added_on',
               $this->tbl_dar_master . '.darm_expec_revenue',
               $this->tbl_dar_master . '.darm_challenges',
               $this->tbl_dar_master . '.darm_pending',
               $this->tbl_dar_master . '.darm_remarks',
               $this->tbl_dar_master . '.darm_verified_team_lead_on',
               $this->tbl_dar_master . '.darm_verified_manager_on',
               'addedby.usr_username AS ab_usr_username',
               'verifiedbytl.usr_username AS vb_usr_username_tl',
               $this->tbl_showroom . '.*',
               'verifiedbymg.usr_username AS vb_usr_username_mg'
          );
          if ($isToday) {
               $this->db->where(array('DATE(' . $this->tbl_dar_master . '.darm_added_on)' => date('Y-m-d')));
          }
          if (!empty($darId)) {
               $this->db->where($this->tbl_dar_master . '.darm_id = ' . $darId);
          } else {
               if ($this->usr_grp == 'MG') { // Manager
                    $this->db->where($this->tbl_dar_master . '.darm_added_by', $this->uid); //darm_showroom
               } else { // Date entry operator or Seles executives if ($this->usr_grp == 'SE')
                    $this->db->where($this->tbl_dar_master . '.darm_added_by = ' . $this->uid);
               }
          }
          $this->db->select($selArray)
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_dar_master . '.darm_added_by', 'LEFT')
               ->join($this->tbl_users . ' verifiedbytl', 'verifiedbytl.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_team_lead', 'LEFT')
               ->join($this->tbl_users . ' verifiedbymg', 'verifiedbymg.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_manager', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_dar_master . '.darm_showroom', 'LEFT');

          $this->db->order_by($this->tbl_dar_master . '.darm_added_on', 'DESC');
          $master = $this->db->get($this->tbl_dar_master)->result_array();
          if (empty($darId)) {
               return $master;
          }
          foreach ((array) $master as $key => $value) {
               $master[$key]['enquiry'] = $this->db->select($this->tbl_dar_enquiry . '.*,' . $this->tbl_contact_mode . '.*,' . $this->tbl_enquiry . '.*')
                    ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_dar_enquiry . '.dare_enq_mode_enquiry', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_dar_enquiry . '.dare_enq', 'LEFT')
                    ->where(array($this->tbl_dar_enquiry . '.dare_master' => $value['darm_id']))
                    ->get($this->tbl_dar_enquiry)->result_array();

               $master[$key]['followup'] = $this->db->select($this->tbl_dar_followup . '.*,' . $this->view_vehicle_vehicle_status . '.*,' . $this->tbl_followup . '.*')
                    ->join($this->view_vehicle_vehicle_status, $this->view_vehicle_vehicle_status . '.veh_id = ' . $this->tbl_dar_followup . '.darf_vehicle', 'LEFT')
                    ->join($this->tbl_followup, $this->tbl_followup . '.foll_id = ' . $this->tbl_dar_followup . '.darf_followup', 'LEFT')
                    ->where(array('darf_master' => $value['darm_id']))
                    ->get($this->tbl_dar_followup)->result_array();

               $master[$key]['account'] = $this->db->get_where($this->tbl_accounts, array('acc_head' => 1, 'acc_relation' => $value['darm_id']))->row_array();

               $selectArray = array(
                    $this->tbl_dar_veh_register . '.*',
                    $this->tbl_contact_mode . '.*',
                    $this->tbl_register_master . '.vreg_inquiry',
                    $this->tbl_register_master . '.vreg_contact_mode',
                    $this->tbl_register_master . '.vreg_call_type',
                    'assign.usr_first_name AS assign_usr_first_name',
                    'assign.usr_last_name AS assign_usr_last_name',
                    'addedby.usr_first_name AS addedby_usr_first_name',
                    'addedby.usr_last_name AS addedby_usr_last_name',
               );
               $master[$key]['register'] = $this->db->select($selectArray)
                    ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_dar_veh_register . '.dvr_contact_mode', 'LEFT')
                    ->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_dar_veh_register . '.dvr_register', 'LEFT')
                    ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                    ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                    ->get_where($this->tbl_dar_veh_register, array('dvr_master' => $value['darm_id']))->result_array();

               $master[$key]['registerFolls'] = $this->db->select($this->tbl_dar_reg_followup . '.*, ' . $this->tbl_register_followup . '.*')
                    ->join($this->tbl_register_followup, $this->tbl_register_followup . '.regf_id = ' . $this->tbl_dar_reg_followup . '.darrf_fol_id', 'LEFT')
                    ->get_where($this->tbl_dar_reg_followup, array('darrf_dar_master' => $value['darm_id']))->result_array();
          }

          if ($this->usr_grp == 'MG' && !empty($darId)) {
               $this->db->where('darm_id = ' . $darId);
               $this->db->update($this->tbl_dar_master, array('darm_last_viewed_on' => date('Y-m-d H:i:s'))); //17-02-2021
          }
          generate_log(array(
               'log_title' => 'View a records',
               'log_desc' => 'Manager or top level staff took the dar record',
               'log_controller' => strtolower(__CLASS__),
               'log_action' => 'R',
               'log_ref_id' => empty($darId) ? 0 : $darId,
               'log_added_by' => $this->uid
          ));
          //debug($master);
          return $master;
     }

     function verifyDAR($darid, $status)
     {
          if ($this->usr_grp == 'TL') {
               $data['darm_is_verified_team_lead'] = 0;
               $data['darm_verified_team_lead_on'] = null;
          } else if ($this->usr_grp == 'MG') {
               $data['darm_is_verified_manager'] = 0;
               $data['darm_verified_manager_on'] = null;
          } else {
               $data['darm_is_verified'] = 0;
               $data['darm_verified_by'] = 0;
               $data['darm_verified_on'] = null;
          }
          if ($status == 1) {
               if ($this->usr_grp == 'TL') {
                    $data['darm_is_verified_team_lead'] = $this->uid;
                    $data['darm_verified_team_lead_on'] = date('Y-m-d H:i:s'); //17-02-2021
               } else if ($this->usr_grp == 'MG') {
                    $data['darm_is_verified_manager'] = $this->uid;
                    $data['darm_verified_manager_on'] = date('Y-m-d H:i:s'); //17-02-2021

                    $data['darm_is_verified'] = 1;
                    $data['darm_verified_by'] = $this->uid;
                    $data['darm_verified_on'] = date('Y-m-d H:i:s'); //17-02-2021
               }

               generate_log(array(
                    'log_title' => 'Verified dar records',
                    'log_desc' => 'Manager or top level staff verified the dar record',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'U',
                    'log_ref_id' => $darid,
                    'log_added_by' => $this->uid
               ));
          } else {
               generate_log(array(
                    'log_title' => 'Unverified dar records',
                    'log_desc' => 'Manager or top level staff unverified the dar record',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'U',
                    'log_ref_id' => $darid,
                    'log_added_by' => $this->uid
               ));
          }
          $this->db->where('darm_id', $darid);
          if ($this->db->update($this->tbl_dar_master, $data)) {
               return true;
          }
          return false;
     }

     function verifyByTeamLead($data)
     {
          if ($this->usr_grp == 'TL') {
               $darmaster['darm_is_verified_team_lead'] = $this->uid;
               $darmaster['darm_verified_team_lead_on'] = date('Y-m-d h:i:s');
               $this->db->where('darm_id', $data['darm_id']);
               $this->db->update($this->tbl_dar_master, $darmaster);
               if (isset($data['enq_comments']) && !empty($data['enq_comments'])) { // team leader inquiry comments
                    foreach ($data['enq_comments'] as $key => $value) {
                         $this->db->where('dare_id', $key);
                         $this->db->update($this->tbl_dar_enquiry, array('dare_TL_comments' => $value));

                         generate_log(array(
                              'log_title' => 'DAR comment added',
                              'log_desc' => 'Dar inquiry team lead comment:' . $data['darm_id'],
                              'log_controller' => 'verify-dar-dare-tl-comments',
                              'log_action' => 'U',
                              'log_ref_id' => $key,
                              'log_added_by' => $this->uid
                         ));
                    }
               }
               if (isset($data['foll_comments']) && !empty($data['foll_comments'])) { // manager inquiry comments
                    foreach ($data['foll_comments'] as $key => $value) {
                         $this->db->where('darf_id', $key);
                         $this->db->update($this->tbl_dar_followup, array('darf_TL_comments' => $value));

                         generate_log(array(
                              'log_title' => 'DAR comment added',
                              'log_desc' => 'Dar followup team lead comment:' . $data['darm_id'],
                              'log_controller' => 'verify-dar-darf-tl-comments',
                              'log_action' => 'U',
                              'log_ref_id' => $key,
                              'log_added_by' => $this->uid
                         ));
                    }
               }
               if (isset($data['accounts']) && !empty($data['accounts'])) { // manager inquiry comments
                    $accid = isset($data['accounts']['acc_id']) ? $data['accounts']['acc_id'] : 0;
                    unset($data['accounts']['acc_id']);
                    $this->db->where('acc_id', $accid);
                    $this->db->update($this->tbl_accounts, array_filter($data['accounts']));

                    generate_log(array(
                         'log_title' => 'DAR comment added',
                         'log_desc' => 'Dar petty cash team lead comment:' . $data['darm_id'],
                         'log_controller' => 'verify-dar-acc-tl-comments',
                         'log_action' => 'U',
                         'log_ref_id' => $accid,
                         'log_added_by' => $this->uid
                    ));
               }
          } else if (is_roo_user() || $this->usr_grp == 'MG') {
               $darmaster['darm_is_verified_manager'] = $this->uid;
               $darmaster['darm_verified_manager_on'] = date('Y-m-d h:i:s');
               $darmaster['darm_is_verified'] = 1;
               $this->db->where('darm_id', $data['darm_id']);
               $this->db->update($this->tbl_dar_master, $darmaster);
               if (isset($data['mgr_enq_comments']) && !empty($data['mgr_enq_comments'])) { // team leader inquiry comments
                    foreach ($data['mgr_enq_comments'] as $key => $value) {
                         $this->db->where('dare_id', $key);
                         $this->db->update($this->tbl_dar_enquiry, array('dare_MG_comments' => $value));

                         generate_log(array(
                              'log_title' => 'DAR comment added',
                              'log_desc' => 'Dar inquiry team lead comment:' . $data['darm_id'],
                              'log_controller' => 'verify-dar-dare-tl-comments',
                              'log_action' => 'U',
                              'log_ref_id' => $key,
                              'log_added_by' => $this->uid
                         ));
                    }
               }
               if (isset($data['mgr_foll_comments']) && !empty($data['mgr_foll_comments'])) { // manager inquiry comments
                    foreach ($data['mgr_foll_comments'] as $key => $value) {
                         $this->db->where('darf_id', $key);
                         $this->db->update($this->tbl_dar_followup, array('darf_MG_comments' => $value));

                         generate_log(array(
                              'log_title' => 'DAR comment added',
                              'log_desc' => 'Dar followup team lead comment:' . $data['darm_id'],
                              'log_controller' => 'verify-dar-darf-tl-comments',
                              'log_action' => 'U',
                              'log_ref_id' => $key,
                              'log_added_by' => $this->uid
                         ));
                    }
               }

               if (isset($data['accounts']) && !empty($data['accounts'])) { // manager inquiry comments
                    $accid = isset($data['accounts']['acc_id']) ? $data['accounts']['acc_id'] : 0;
                    unset($data['accounts']['acc_id']);
                    $this->db->where('acc_id', $accid);
                    $this->db->update($this->tbl_accounts, array_filter($data['accounts']));

                    generate_log(array(
                         'log_title' => 'DAR comment added',
                         'log_desc' => 'Dar petty cash team lead comment:' . $data['darm_id'],
                         'log_controller' => 'verify-dar-acc-tl-comments',
                         'log_action' => 'U',
                         'log_ref_id' => $accid,
                         'log_added_by' => $this->uid
                    ));
               }
          }
     }

     function todaysRegFollowup()
     {
          $today = date('Y-m-d');
          $return = $this->db->select($this->tbl_register_followup . '.*,' . $this->tbl_register_master . '.*,' . $this->tbl_contact_mode . '.*,' .
               $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_model . '.*')
               ->join($this->tbl_register_followup, $this->tbl_register_followup . '.regf_reg_id = ' . $this->tbl_register_master . '.vreg_id', 'LEFT')
               ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_register_master . '.vreg_contact_mode', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->where($this->tbl_register_followup . '.regf_added_by', $this->uid)
               ->where('DATE(' . $this->tbl_register_followup . '.regf_added_on) = ' . "DATE('" . $today . "')")
               ->get($this->tbl_register_master)->result_array();
          //if($this->uid == 561) {
          //     echo $this->db->last_query();
          //     debug($return);
          //}
          return $return;
     }
     function getDarInformationPaginate($postDatas)
     {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value

          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }

          $selArray = array(
               $this->tbl_dar_master . '.darm_is_verified',
               $this->tbl_dar_master . '.darm_id',
               $this->tbl_dar_master . '.darm_added_on',
               $this->tbl_dar_master . '.darm_expec_revenue',
               $this->tbl_dar_master . '.darm_challenges',
               $this->tbl_dar_master . '.darm_pending',
               $this->tbl_dar_master . '.darm_remarks',
               $this->tbl_dar_master . '.darm_verified_team_lead_on',
               $this->tbl_dar_master . '.darm_verified_manager_on',
               'addedby.usr_username AS ab_usr_username',
               'verifiedbytl.usr_username AS vb_usr_username_tl',
               $this->tbl_showroom . '.*',
               'verifiedbymg.usr_username AS vb_usr_username_mg'
          );

          if ($isToday) {
               $this->db->where(array('DATE(' . $this->tbl_dar_master . '.darm_added_on)' => date('Y-m-d')));
          }

          if (!empty($darId)) {
               $this->db->where($this->tbl_dar_master . '.darm_id', $darId);
          } else {
               if ($this->usr_grp == 'MG') { // Manager
                    $this->db->where($this->tbl_dar_master . '.darm_added_by', $this->uid);
               } else { // Date entry operator or Sales executives if ($this->usr_grp == 'SE')
                    $this->db->where($this->tbl_dar_master . '.darm_added_by', $this->uid);
               }
          }

          $this->db->select($selArray)
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_dar_master . '.darm_added_by', 'LEFT')
               ->join($this->tbl_users . ' verifiedbytl', 'verifiedbytl.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_team_lead', 'LEFT')
               ->join($this->tbl_users . ' verifiedbymg', 'verifiedbymg.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_manager', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_dar_master . '.darm_showroom', 'LEFT');

          $this->db->order_by($this->tbl_dar_master . '.darm_added_on', 'DESC');
          $master = $this->db->get($this->tbl_dar_master)->result_array();

          // Count total records query
          $this->db->select('COUNT(*) as total');
          if ($isToday) {
               $this->db->where(array('DATE(' . $this->tbl_dar_master . '.darm_added_on)' => date('Y-m-d')));
          }
          if (!empty($darId)) {
               $this->db->where($this->tbl_dar_master . '.darm_id', $darId);
          } else {
               if ($this->usr_grp == 'MG') { // Manager
                    $this->db->where($this->tbl_dar_master . '.darm_added_by', $this->uid);
               } else { // Date entry operator or Sales executives if ($this->usr_grp == 'SE')
                    $this->db->where($this->tbl_dar_master . '.darm_added_by', $this->uid);
               }
          }
          $totalQuery = $this->db->get($this->tbl_dar_master);
          $totalRecords = $totalQuery->row()->total;

          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $master
          );
          return $response;
     }
}
