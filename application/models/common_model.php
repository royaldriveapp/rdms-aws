<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class Common_model extends CI_Model
{
     public $childrens = array();

     public function __construct()
     {
          parent::__construct();
          $this->load->database();

          $this->tbl_feedback = 'app_feedback';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_statuses = TABLE_PREFIX . 'statuses';
          $this->tbl_followup = TABLE_PREFIX . 'followup';
          $this->tbl_km_ranges = TABLE_PREFIX . 'km_ranges';
          $this->tbl_divisions = TABLE_PREFIX . 'divisions';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_dar_master = TABLE_PREFIX . 'dar_master';
          $this->tbl_general_log = TABLE_PREFIX . 'general_log';
          $this->tbl_user_access = TABLE_PREFIX . 'user_access';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_contact_mode = TABLE_PREFIX . 'contact_mode';
          $this->tbl_vehicle_status = TABLE_PREFIX . 'vehicle_status';
          $this->tbl_customer_grade = TABLE_PREFIX . 'customer_grade';
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->tbl_vehicle_booking_master = TABLE_PREFIX . 'vehicle_booking_master';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
          $this->view_enquiry_vehicle_master = TABLE_PREFIX . 'view_enquiry_vehicle_master';
          $this->tbl_vehicle_booking_confirmations = TABLE_PREFIX . 'vehicle_booking_confirmations';
          $this->tbl_price_range = TABLE_PREFIX . 'price_range';
          $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
          $this->tbl_procurement_rqsts = TABLE_PREFIX . 'procurement_rqsts';
          $this->tbl_procurement_rqst_details = TABLE_PREFIX . 'procurement_rqst_details';
          $this->tbl_procurement_rqst_status = TABLE_PREFIX . 'procurement_rqst_status';
          $this->tbl_products = TABLE_PREFIX_RANA . 'products';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_role = TABLE_PREFIX . 'role';
     }
 
     function getIhitsFinYearCode()
     {
          $finYearCode = get_settings_by_key('iHits_fin_year_lx_sm_code');
          $finYearCode = explode('/', $finYearCode);
          $finYearCode = isset($finYearCode[1]) ? $finYearCode[1] : array();
          if (isset($finYearCode[1])) {
               $finYearCode = explode('-', $finYearCode);
               if (isset($finYearCode[0]) && isset($finYearCode[1])) {
                    return array('s' => $finYearCode[1], 'l' => $finYearCode[0]);
               }
          }
          return false;
     }

     function myChildStaffs($id)
     {
          $this->myStaff($id);
          return $this->childrens;
     }

     function myStaff($id)
     {
          $this->db->select('usr_id');
          $this->db->where(array('usr_tl' => $id, 'usr_resigned' => 0, 'usr_active' => 1));

          $child = $this->db->get($this->tbl_users);
          $categories = $child->result_array();
          $i = 0;
          array_push($this->childrens, $id);
          foreach ($categories as $p_cat) {
               $categories[$i]['sub'] = $this->myStaff($p_cat['usr_id']);
               array_push($this->childrens, $p_cat['usr_id']);
               $i++;
          }
          return $categories;
     }

     public function getUser($id = null, $excludeAdminUser = false)
     {

          $this->db->select($this->tbl_users . '.*');
          if ($excludeAdminUser) {
               $this->db->where("usr_id !=", 1);
          }

          if ($id) {
               $this->db->where('usr_id', $id);
               $user = $this->db->get($this->tbl_users)->row_array();
          } else {
               $user = $this->db->get($this->tbl_users)->result_array();
          }
          $permission = $this->db->select(array($this->tbl_users_groups . '.*', $this->tbl_user_access . '.*'))
               ->join($this->tbl_user_access, $this->tbl_user_access . '.cua_user_id = ' . $this->tbl_users_groups . '.user_id', 'left')
               ->where($this->tbl_users_groups . '.user_id', $id)->get($this->tbl_users_groups)->row_array();
          return array_merge($user, $permission);
     }
     /* new */
     public function getUser_new($id = null, $excludeAdminUser = false)
     {
          if ($excludeAdminUser) {
               $this->db->where("usr_id !=", 1);
          }
          if ($id) {
               $user = $this->db->select(array($this->tbl_users_groups . '.*', $this->tbl_users . '.*'))
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'left')
                    ->where($this->tbl_users . '.usr_id', $id)->get($this->tbl_users)->row_array();
          } else {
               $user = $this->db->select(array($this->tbl_users_groups . '.*', $this->tbl_users . '.*'))
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'left')
                    ->get($this->tbl_users)->result_array();
          }
          $this->db->where('rol_id', $user['usr_rol']);
          $permission = $this->db->get($this->tbl_role)->row_array();
          return array_merge($user, $permission);
     }
     /*@new*/

     public function generateLog($data, $table)
     {
          $this->load->library('user_agent');
          if (!empty($data)) {
               $data['log_user_agent'] = $this->agent->agent;
               $data['log_added_on_in'] = date('Y-m-d H:i:s');
               $this->db->insert(TABLE_PREFIX . $table, $data);
               return true;
          } else {
               return false;
          }
     }

     //   function todaysFollowups() {
     //        $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
     //        /* if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
     //          $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
     //          }

     //          return $this->db->select($this->tbl_followup . '.*,' . $this->view_vehicle_vehicle_status . '.*,' . $this->tbl_enquiry . '.*')
     //          ->join($this->view_vehicle_vehicle_status, $this->view_vehicle_vehicle_status . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
     //          ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_followup . '.foll_cus_id', 'LEFT')
     //          ->where($this->view_vehicle_vehicle_status . '.vst_all_statuses IS NULL AND ' . 'DATE(' . $this->tbl_followup . ".foll_next_foll_date) = DATE_ADD(CURDATE(), INTERVAL +1 DAY) AND " . $this->tbl_followup . ".foll_customer_feedback IS NULL")
     //          ->get($this->tbl_followup)->result_array(); */
     //        if ($this->uid > 0) {
     //             if ($this->usr_grp == 'SE' || $this->usr_grp == 'EV' || $this->usr_grp == 'TL') {
     //                  $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
     //             } else if($this->usr_grp == 'TC') {
     //                  $this->db->where($this->tbl_followup . '.foll_added_by = ' . $this->uid);
     //             }
     //             $selectArray = array(
     //                 $this->tbl_followup . '.foll_id',
     //                 $this->tbl_followup . '.foll_next_foll_date',
     //                 $this->tbl_followup . '.foll_next_foll_date',
     //                 $this->tbl_followup . '.foll_customer_feedback',
     //                 $this->view_vehicle_vehicle_status . '.veh_id',
     //                 $this->view_vehicle_vehicle_status . '.veh_status',
     //                 $this->view_vehicle_vehicle_status . '.brd_title',
     //                 $this->view_vehicle_vehicle_status . '.mod_title',
     //                 $this->view_vehicle_vehicle_status . '.var_variant_name',
     //                 $this->view_vehicle_vehicle_status . '.vst_all_statuses',
     //                 $this->tbl_enquiry . '.enq_cus_name',
     //                 $this->tbl_enquiry . '.enq_id',
     //                 $this->tbl_enquiry . '.enq_current_status',
     //                 $this->tbl_enquiry . '.enq_cus_status',
     //                 $this->tbl_enquiry . '.enq_cus_mobile',
     //             );
     //             return $this->db->select($selectArray)->join($this->view_vehicle_vehicle_status, $this->view_vehicle_vehicle_status . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
     //                             ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_followup . '.foll_cus_id', 'LEFT')
     //                             ->where($this->view_vehicle_vehicle_status . '.vst_all_statuses IS NULL AND ' .
     //                                     '(DATE(' . $this->tbl_followup . '.foll_next_foll_date) = CURDATE() OR DATE(' . $this->tbl_followup . ".foll_next_foll_date) = DATE_ADD(CURDATE(), INTERVAL +1 DAY)) AND " . $this->tbl_followup . ".foll_customer_feedback IS NULL")
     //                             ->get($this->tbl_followup)->result_array();
     //        }
     //   }

     function todaysFollowups()
     {
          if ($this->uid > 0) {
               if ($this->usr_grp == 'SE' || $this->usr_grp == 'EV' || $this->usr_grp == 'TL') {
                    $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
               } else if ($this->usr_grp == 'TC') {
                    $this->db->where($this->tbl_followup . '.foll_added_by = ' . $this->uid);
               }
               if(check_permission('upcommingfollowup', 'exclude_cold')) {
                    $this->db->where('(enq_cus_when_buy = 1 OR enq_cus_when_buy = 2 OR enq_cus_when_buy = 3)');
               }
               $selectArray = array(
                    $this->tbl_followup . '.foll_id', $this->tbl_followup . '.foll_next_foll_date',
                    $this->tbl_followup . '.foll_next_foll_date', $this->tbl_followup . '.foll_customer_feedback',
                    $this->tbl_vehicle . '.veh_id', $this->tbl_vehicle . '.veh_brand', $this->tbl_vehicle . '.veh_model',
                    $this->tbl_vehicle . '.veh_varient', $this->tbl_vehicle . '.veh_status', $this->tbl_enquiry . '.enq_cus_name',
                    $this->tbl_enquiry . '.enq_id', $this->tbl_brand . '.brd_title', $this->tbl_model . '.mod_title', $this->tbl_enquiry . '.enq_current_status',
                    $this->tbl_variant . '.var_variant_name', $this->tbl_enquiry . '.enq_cus_status'
               );
               $return = $this->db->select($selectArray)
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_followup . '.foll_cus_id', 'LEFT')
                    ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    ->where('(DATE(' . $this->tbl_followup . '.foll_next_foll_date) = CURDATE() OR DATE(' .
                         $this->tbl_followup . ".foll_next_foll_date) = DATE_ADD(CURDATE(), INTERVAL +1 DAY)) AND " .
                         $this->tbl_followup . ".foll_customer_feedback IS NULL")
                    ->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
                    ->get($this->tbl_followup)->result_array();


               // if($this->uid == 814) {
               //      echo $this->db->last_query();
               //      debug($return);
               // }
               return $return;
          }
     }

     function analytics()
     {
          //Sale requist
          $userId = $this->session->userdata('usr_user_id');
          $user = $this->getUser($userId);
          $showroom = isset($user['usr_showroom']) ? $user['usr_showroom'] : 0;

          if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $userId);
          }
          if ($this->usr_grp == 'MG') {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
          }

          $this->db->where($this->tbl_enquiry . '.enq_current_status', 6);
          $data['count_sale_req'] = $this->db->select("COUNT(*) AS enq_total")->get($this->tbl_enquiry)->row()->enq_total;

          //Drop requist
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $userId);
          }
          if ($this->usr_grp == 'MG') {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
          }

          $this->db->where($this->tbl_enquiry . '.enq_current_status', 2);
          $data['count_drop_req'] = $this->db->select("COUNT(*) AS enq_total")->get($this->tbl_enquiry)->row()->enq_total;

          //Delete requist
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $userId);
          }
          if ($this->usr_grp == 'MG') {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
          }

          $this->db->where($this->tbl_enquiry . '.enq_current_status', 8);
          $data['count_delete_req'] = $this->db->select("COUNT(*) AS enq_total")->get($this->tbl_enquiry)->row()->enq_total;

          //Loss requist
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $userId);
          }
          if ($this->usr_grp == 'MG') {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
          }

          $this->db->where($this->tbl_enquiry . '.enq_current_status', 4);
          $data['count_loss_req'] = $this->db->select("COUNT(*) AS enq_total")->get($this->tbl_enquiry)->row()->enq_total;

          //Running followup count
          /* $this->db->where($this->tbl_enquiry . '.enq_delete != 99 AND ' . $this->tbl_enquiry . '.enq_current_status != 9 ');
              if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
              $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
              }

              if ($this->usr_grp == 'MG') {
              $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
              }

              $data['count_running_followup'] = $this->db->select($this->tbl_followup . '.*,' . $this->view_vehicle_vehicle_status . '.*,' . $this->tbl_enquiry . '.*,' .
              $this->tbl_users . '.*')
              ->join($this->view_vehicle_vehicle_status, $this->view_vehicle_vehicle_status .
              '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
              ->join($this->tbl_enquiry, $this->tbl_enquiry .
              '.enq_id = ' . $this->tbl_followup . '.foll_cus_id', 'LEFT')
              ->join($this->tbl_users, $this->tbl_users .
              '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
              ->where($this->view_vehicle_vehicle_status . '.vst_all_statuses IS NULL AND ' .
              '((DATEDIFF(DATE(' . $this->tbl_followup . '.foll_next_foll_date), CURDATE()) >= 0 AND
              DATEDIFF(DATE(' . $this->tbl_followup . '.foll_next_foll_date), CURDATE()) <= 10) OR
              (DATEDIFF(DATE(' . $this->tbl_followup . '.foll_next_foll_date), CURDATE()) = -2)) ' .
              " AND (" . $this->tbl_followup . ".foll_customer_feedback IS NULL OR " . $this->tbl_followup . ".foll_customer_feedback = '')")
              ->order_by($this->tbl_followup . '.foll_next_foll_date ASC')
              ->get($this->tbl_followup)->num_rows(); */

          //Missed followup count
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status IS NULL OR ' . $this->tbl_enquiry . '.enq_current_status = 1)');
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
               $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
          }

          if ($this->usr_grp == 'MG') {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
          }
          $this->db->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)');
          $data['count_missed_followup'] = $this->db->select("COUNT(*) AS enq_total")->get($this->tbl_enquiry)->row()->enq_total;

          //Freezed enquires
          $this->db->where('enq_current_status', 9);
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
               $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
          }

          if ($this->usr_grp == 'MG') {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
          }
          $data['count_freezed_enquiry'] = $this->db->select('COUNT(*) AS freeze_count')->get($this->tbl_enquiry)->row()->freeze_count;

          //Pending evaluation
          $this->db->where('val_status', 0);
          $data['count_pending_evaluation'] = $this->db->select('COUNT(*) AS pending_evaluation')->get($this->tbl_valuation)->row()->pending_evaluation;

          //evaluated vehicles
          $this->db->where('val_status', vehicle_evaluated);
          $data['count_evaluated_vehicle'] = $this->db->select('COUNT(*) AS pending_evaluation')->get($this->tbl_valuation)->row()->pending_evaluation;

          return $data;
     }

     function clearEnquiry()
     {
          $this->db->truncate(TABLE_PREFIX . 'enquiry');
          $this->db->truncate(TABLE_PREFIX . 'followup');
          $this->db->truncate(TABLE_PREFIX . 'general_log');
          $this->db->truncate(TABLE_PREFIX . 'vehicle');
          $this->db->truncate(TABLE_PREFIX . 'vehicle_status');
          return true;
     }

     function cleanEvaluation()
     {
          $this->db->truncate(TABLE_PREFIX . 'valuation');
          $this->db->truncate(TABLE_PREFIX . 'valuation_complaint');
     }

     function getStatuses($category)
     {
          if (is_array($category)) {
               return $this->db->where_in('sts_category', $category)->where(array('sts_status' => 1))
                    ->order_by('sts_order')->like('sts_access', $this->usr_grp, 'BOTH')
                    ->get($this->tbl_statuses)->result_array();
          } else {
               return $this->db->where(array('sts_category' => $category, 'sts_status' => 1))
                    ->order_by('sts_order')->like('sts_access', $this->usr_grp, 'BOTH')
                    ->get($this->tbl_statuses)->result_array();
          }
     }

     function recentEnquiry()
     {
          $this->db->query('SET SESSION group_concat_max_len = 1000000');
          $newlyAdded = $this->db->select('GROUP_CONCAT(log_ref_id) AS log_ref_id')
               ->where(array('log_action =' => 'R', 'log_controller' => 'enquiry_model', 'log_added_by' => $this->uid))
               ->get($this->tbl_general_log)->row()->log_ref_id;

          $selArray = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_users . '.usr_id',
               'tbl_added_by.usr_username AS enq_added_by_name'
          );
          $this->db->select($selArray)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left');
          return $this->db->order_by($this->tbl_enquiry . '.enq_id', 'DESC')
               ->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $newlyAdded))
               ->where($this->tbl_enquiry . '.enq_se_id', $this->uid)
               ->get($this->tbl_enquiry)->result_array();
     }

     function getContactModes($id = '')
     {
          if (!empty($id)) {
               return $this->db->get_where($this->tbl_contact_mode, array('cmd_id' => $id))->row_array();
          }
          return $this->db->get($this->tbl_contact_mode)->result_array();
     }

     function TLDARforApproval()
     {
          return array();
          if (check_permission('dar', 'denaydarallbrnch')) {
               $this->db->where($this->tbl_showroom . '.shr_id', get_logged_user('usr_showroom'));
          }

          if ($this->usr_grp == 'TL') {
               $this->db->where('addedby.usr_tl', $this->uid);
               $this->db->where($this->tbl_dar_master . '.darm_is_verified_team_lead = 0');
               $this->db->select($this->tbl_dar_master . '.*, addedby.usr_username AS ab_usr_username, verifiedbytl.usr_username AS vb_usr_username,' .
                    $this->tbl_showroom . '.*, verifiedbymg.usr_username AS vb_usr_username_mg')
                    ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_dar_master . '.darm_added_by', 'LEFT')
                    ->join($this->tbl_users . ' verifiedbytl', 'verifiedbytl.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_team_lead', 'LEFT')
                    ->join($this->tbl_users . ' verifiedbymg', 'verifiedbymg.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_manager', 'LEFT')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_dar_master . '.darm_showroom', 'LEFT');
               $this->db->order_by($this->tbl_dar_master . '.darm_added_on', 'DESC');
               return $this->db->get($this->tbl_dar_master)->result_array();
          }
          if (is_roo_user() || $this->usr_grp == 'MG') {
               $this->db->where($this->tbl_dar_master . '.darm_is_verified_team_lead > 1 AND ' . $this->tbl_dar_master . '.darm_is_verified_manager = 0');
               $this->db->select($this->tbl_dar_master . '.*, addedby.usr_username AS ab_usr_username, verifiedbytl.usr_username AS vb_usr_username,' .
                    $this->tbl_showroom . '.*, verifiedbymg.usr_username AS vb_usr_username_mg')
                    ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_dar_master . '.darm_added_by', 'LEFT')
                    ->join($this->tbl_users . ' verifiedbytl', 'verifiedbytl.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_team_lead', 'LEFT')
                    ->join($this->tbl_users . ' verifiedbymg', 'verifiedbymg.usr_id = ' . $this->tbl_dar_master . '.darm_is_verified_manager', 'LEFT')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_dar_master . '.darm_showroom', 'LEFT');
               $this->db->order_by($this->tbl_dar_master . '.darm_added_on', 'DESC');
               return $this->db->get($this->tbl_dar_master)->result_array();
          }
     }

     /**
      * This is a general function to change status field of any table 
      * @param int $pkId <primary key id>
      * @param int $ischecked <current status 0/1>
      * @param string $table <table name which we want to edit>
      * @param int $statusFieldName <status field name in specified table>
      * @param string $whrFieldName <primary key field name>
      * @return boolean
      * Author : JK
      */
     function changeStatus($pkId, $ischecked, $table, $statusFieldName, $whrFieldName)
     {
          $this->db->where($whrFieldName, $pkId);
          if ($this->db->update(TABLE_PREFIX . $table, array($statusFieldName => $ischecked))) {
               return true;
          }
          return false;
     }

     /**
      * This is a general function to change status field of any table 
      * @param int $pkId <primary key id>
      * @param int $ischecked <current status 0/1>
      * @param string $table <table name which we want to edit>
      * @param int $statusFieldName <status field name in specified table>
      * @param string $whrFieldName <primary key field name>
      * @return boolean
      * Author : JK
      */
     function changeStatusRana($pkId, $ischecked, $table, $statusFieldName, $whrFieldName)
     {
          $this->db->where($whrFieldName, $pkId);
          if ($this->db->update(TABLE_PREFIX_RANA . $table, array($statusFieldName => $ischecked))) {
               return true;
          }
          return false;
     }

     function getEnquiresByStatus($status)
     {
          if (!empty($status)) {
               return $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                    ->where('enq_current_status', $status)->get($this->tbl_enquiry)->result_array();
          }
          return false;
     }

     function pendingRegisterApproval()
     {
          $salesPurchaseEnq = array(4, 6, 7, 8);
          return $this->db->where('vreg_is_verified', 0)->where_in('vreg_department', $salesPurchaseEnq)
               ->get($this->tbl_register_master)->result_array();
     }

     function pendingCustGradeNotification()
     {

          $grades = $this->db->select('sgrd_id')->get_where($this->tbl_customer_grade, array('sgrd_need_verification' => 1))->result_array();
          $grades = array_column($grades, 'sgrd_id');
          $select = array(
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_customer_grade . '.sgrd_id',
               $this->tbl_customer_grade . '.sgrd_grade'
          );
          return $this->db->select($select, false)->join($this->tbl_customer_grade, $this->tbl_enquiry . '.enq_customer_grade = ' . $this->tbl_customer_grade . '.sgrd_id', 'LEFT')
               ->where($this->tbl_enquiry . '.enq_customer_grade > 0 AND ' . $this->tbl_enquiry . '.enq_customer_grade_verify_by = 0')
               ->get($this->tbl_enquiry)->result_array();
     }

     function assignedEnquires()
     {
          if ($this->uid > 0) {
               $ArrSelect = array(
                    $this->tbl_enquiry . '.enq_cus_name',
                    $this->tbl_enquiry . '.enq_id',
                    $this->tbl_enquiry . '.enq_cus_mobile',
                    $this->tbl_users . '.usr_first_name',
                    $this->tbl_users . '.usr_last_name',
                    'tbl_added_by.usr_username AS enq_added_by_name'
               );

               return $this->db->select($ArrSelect)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($this->tbl_enquiry . '.enq_se_id', $this->uid)
                    ->where($this->tbl_enquiry . '.enq_last_viewd != ' . $this->uid)->where($this->tbl_enquiry . '.enq_added_by != ', $this->uid)
                    ->get($this->tbl_enquiry)->result_array();
          }
     }

     function pendingRegisters()
     {

          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop . ',' . enq_lost . ',' . enq_droped . ',' . enq_verfd_close;
          $selectArray = array(
               $this->tbl_register_master . '.vreg_cust_name',
               $this->tbl_register_master . '.vreg_cust_place',
               $this->tbl_register_master . '.vreg_cust_phone',
               $this->tbl_register_master . '.vreg_customer_remark',
               $this->tbl_register_master . '.vreg_last_action',
               $this->tbl_register_master . '.vreg_added_by',
               $this->tbl_register_master . '.vreg_assigned_to',
               $this->tbl_register_master . '.vreg_inquiry',
               $this->tbl_register_master . '.vreg_id',
               $this->tbl_register_master . '.vreg_added_on',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_enquiry . '.enq_current_status'
          );
          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');

          if (check_permission('registration', 'not_show_visitors_in_myregister')) {
               $this->db->where_not_in('vreg_contact_mode', array(40));
          }

          $return['pendingRegisters'] = $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT')
               ->where('vreg_assigned_to', $this->uid)->where('(vreg_is_punched = 0)')
               //                            ->where('MONTH(' . $this->tbl_register_master . '.vreg_added_on) = MONTH(CURRENT_DATE())')
               //->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
               ->get($this->tbl_register_master)->result_array();
          //if($this->uid == 927) {
          //  echo $this->db->last_query();
          //}
          //debug($return);
          return $return;
     }

     function getCustomeUserDetails($uid, $fields)
     {
          return $this->db->select($fields)->where('usr_id', $uid)->get($this->tbl_users)->row_array();
     }

     function todaysFollowup()
     {
          if ($this->uid != ADMIN_ID) {
               if (check_permission('notify_todayfollowup', 'showmyselffollowup')) {
                    $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
               }
               if (check_permission('notify_todayfollowup', 'showmystaff')) {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                         ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               }
               if (check_permission('notify_todayfollowup', 'showmyshowroom')) {
                    $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
               }
               if (check_permission('notify_todayfollowup', 'hothotpls')) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', array(1, 2));
               }

               if (check_permission('notify_todayfollowup', 'hothotplswrm')) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', array(1, 2, 3));
               }
          }
          $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_next_foll_date)', date('Y-m-d'));
          if (strtoupper(date("D")) == 'MON') {
               $yesterday = date('Y-m-d', strtotime("-1 days"));
               $this->db->or_where('DATE(' . $this->tbl_enquiry . '.enq_next_foll_date)', $yesterday);
          }
          $ArrSelect = array(
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_next_foll_date',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_last_name',
               'tbl_added_by.usr_username AS enq_added_by_name'
          );

          return $this->db->select($ArrSelect)->from($this->tbl_enquiry)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')->count_all_results();
     }

     function outDatingInsurance()
     {
          //SELECT NOW(), val_insurance_comp_date, DATEDIFF(val_insurance_comp_date, NOW()) FROM `cpnl_valuation`
          $selectAray = array(
               'NOW()',
               'val_insurance_comp_date', 'DATEDIFF(val_insurance_comp_date, NOW()) AS diff_val_insurance_comp_date',
               'val_insurance_ll_date', 'DATEDIFF(val_insurance_ll_date, NOW()) AS diff_val_insurance_ll_date'
          );
          $return = $this->db->select($selectAray)->get($this->tbl_valuation)->result_array();
          debug($return);
     }

     function regiFollNotification()
     {

          if (check_permission('notification', 'myregallfollwup')) {
               $this->db->where_in($this->tbl_register_master . '.vreg_status', array(0, 1));
               return $this->db->select($this->tbl_register_master . '.vreg_cust_phone, ' . $this->tbl_register_master . '.vreg_cust_name,' .
                    $this->tbl_register_master . '.vreg_next_followup, ' . 'TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' .
                    $this->tbl_register_master . '.vreg_next_followup ' . ') AS dateDiff, ' . $this->tbl_register_master . '.vreg_id, ' .
                    $this->tbl_users . '.usr_first_name', false)
                    ->join($this->tbl_users, $this->tbl_register_master . '.vreg_added_by = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                    ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                    ->get($this->tbl_register_master)->result_array();
          } else if (check_permission('notification', 'myregfollwup')) {
               $this->db->where_in($this->tbl_register_master . '.vreg_status', array(0, 1));
               return $this->db->select($this->tbl_register_master . '.vreg_cust_phone, ' . $this->tbl_register_master . '.vreg_cust_name,' .
                    $this->tbl_register_master . '.vreg_next_followup, ' . 'TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' .
                    $this->tbl_register_master . '.vreg_next_followup ' . ') AS dateDiff, ' . $this->tbl_register_master . '.vreg_id, ' .
                    $this->tbl_users . '.usr_first_name', false)
                    ->join($this->tbl_users, $this->tbl_register_master . '.vreg_added_by = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                    //    ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                    ->where($this->tbl_register_master . '.vreg_assigned_to', $this->uid)->get($this->tbl_register_master)->result_array();
               //<= 35
          } else if (check_permission('notification', 'mystaffregfollwup')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $this->uid);
               $this->db->where_in($this->tbl_register_master . '.vreg_status', array(0, 1));
               return $this->db->select($this->tbl_register_master . '.vreg_cust_phone, ' . $this->tbl_register_master . '.vreg_cust_name,' .
                    $this->tbl_register_master . '.vreg_next_followup, ' . 'TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' .
                    $this->tbl_register_master . '.vreg_next_followup ' . ') AS dateDiff, ' . $this->tbl_register_master . '.vreg_id,' .
                    $this->tbl_users . '.usr_first_name', false)
                    ->join($this->tbl_users, $this->tbl_register_master . '.vreg_added_by = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                    ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                    ->where_in($this->tbl_register_master . '.vreg_assigned_to', $mystaffs)->get($this->tbl_register_master)->result_array();
          } else if (check_permission('notification', 'myshowroomregfollwup')) {
               $this->db->where_in($this->tbl_register_master . '.vreg_status', array(0, 1));
               return $this->db->select($this->tbl_register_master . '.vreg_cust_phone, ' . $this->tbl_register_master . '.vreg_cust_name,' .
                    $this->tbl_register_master . '.vreg_next_followup, ' . 'TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' .
                    $this->tbl_register_master . '.vreg_next_followup ' . ') AS dateDiff, ' . $this->tbl_register_master . '.vreg_id,' .
                    $this->tbl_users . '.usr_first_name', false)
                    ->join($this->tbl_users, $this->tbl_register_master . '.vreg_added_by = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                    ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                    ->where($this->tbl_register_master . '.vreg_showroom', $this->shrm)->get($this->tbl_register_master)->result_array();
          }
     }

     function getStatusById($stsid)
     {
          return $this->db->where(array('sts_id' => $stsid))->get($this->tbl_statuses)->row_array();
     }

     function getKMRanges()
     {
          return $this->db->get($this->tbl_km_ranges)->result_array();
     }

     function sideBarNotifications()
     {
          if ($this->uid > 0) {
               if (check_permission('booking', 'showbooking')) {
                    $return = array();
                    $mystaffs = array();
                    if (check_permission('booking', 'mystaffbking')) {
                         $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                              ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                         array_push($mystaffs, $this->uid);
                    }

                    /* Get rejected booking */
                    $this->db->where('enq_current_status', reject_book);
                    if (check_permission('booking', 'showall')) {
                    } else if (check_permission('booking', 'mybking')) {
                         $this->db->where('enq_se_id', $this->uid);
                    } else if (check_permission('booking', 'mystaffbking')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
                    } else if (check_permission('booking', 'myshowroombking')) {
                         $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
                    }
                    $return['reject_book'] = $this->db->count_all_results($this->tbl_enquiry);

                    /* Booked or rebooked */
                    if (check_permission('booking', 'showonlyconfmbooking')) {
                         $this->db->where($this->tbl_vehicle_booking_confirmations . '.vbc_verify_by != NULL');
                    }
                    if (check_permission('booking', 'showall')) {
                    } else if (check_permission('booking', 'mybking')) {
                         $this->db->where($this->tbl_vehicle_booking_master . '.vbk_sales_staff', $this->uid);
                    } else if (check_permission('booking', 'mystaffbking')) {
                         $this->db->where_in($this->tbl_vehicle_booking_master . '.vbk_sales_staff', $mystaffs);
                    } else if (check_permission('booking', 'myshowroombking')) {
                         $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $this->shrm);
                    }
                    $return['booked'] = $this->db->join($this->tbl_vehicle_booking_confirmations, $this->tbl_vehicle_booking_confirmations .
                         '.vbc_book_master = ' . $this->tbl_vehicle_booking_master . '.vbk_id AND ' . $this->tbl_vehicle_booking_confirmations .
                         '.vbc_verify_by = ' . $this->uid, 'LEFT')->where($this->tbl_vehicle_booking_confirmations . '.vbc_id IS NULL')
                         ->where_in(
                              $this->tbl_vehicle_booking_master . '.vbk_status',
                              array(vehicle_booked)
                         )->count_all_results($this->tbl_vehicle_booking_master);
                    //, confm_book, rfi_loan_approved, dc_ready_to_del

                    /* Booking confirmed */
                    if (check_permission('booking', 'showall')) {
                    } else if (check_permission('booking', 'mybking')) {
                         $this->db->where($this->tbl_vehicle_booking_master . '.vbk_sales_staff', $this->uid);
                    } else if (check_permission('booking', 'mystaffbking')) {
                         $this->db->where_in($this->tbl_vehicle_booking_master . '.vbk_sales_staff', $mystaffs);
                    } else if (check_permission('booking', 'myshowroombking')) {
                         $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $this->shrm);
                    }
                    $return['bookConfirmed'] = $this->db->where_in(
                         $this->tbl_vehicle_booking_master . '.vbk_status',
                         array(confm_book, rfi_loan_approved, dc_ready_to_del)
                    )->count_all_results($this->tbl_vehicle_booking_master);
               }

               //Pending image upload for products
               if (check_permission('product', 'canuploadprdimage_notify')) {
                    $selArray = array(
                         $this->tbl_products . '.prd_id',
                         $this->tbl_products . '.prd_number',
                         $this->tbl_products . '.prd_regno_prt_1',
                         $this->tbl_products . '.prd_regno_prt_2',
                         $this->tbl_products . '.prd_regno_prt_3',
                         $this->tbl_products . '.prd_regno_prt_4'
                    );
                    $this->db->select($selArray);
                    $this->db->where($this->tbl_products . '.prd_photo_upld_by', 0);
                    $this->db->where($this->tbl_products . '.prd_location', $this->shrm);
                    $return['pendingImageUpload'] = $this->db->count_all_results($this->tbl_products);
               }

               //Pending approve product
               if (check_permission('product', 'readytopublish_notify')) {
                    $selArray = array(
                         $this->tbl_products . '.prd_id',
                         /* $this->tbl_products . '.prd_number',
                          $this->tbl_products . '.prd_regno_prt_1',
                          $this->tbl_products . '.prd_regno_prt_2',
                          $this->tbl_products . '.prd_regno_prt_3',
                          $this->tbl_products . '.prd_regno_prt_4',
                          $this->tbl_brand . '.*',
                          $this->tbl_model . '.*',
                          $this->tbl_variant . '.*', */
                         "CONCAT(prd_regno_prt_1,'-',prd_regno_prt_2,'-',prd_regno_prt_3,'-',prd_regno_prt_4) AS regno",
                         "CONCAT(brd_title,' ', mod_title, ' ', var_variant_name) AS vehicle"
                    );
                    $this->db->select($selArray);

                    $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
                    $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
                    $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');

                    $this->db->where($this->tbl_products . '.prd_photo_upld_by >', 0);
                    $this->db->where($this->tbl_products . '.prd_data_updated >', 0);
                    $this->db->where($this->tbl_products . '.prd_verified_by', 0);
                    $this->db->where($this->tbl_products . '.prd_status', 0);
                    $return['readytopublish'] = $this->db->get($this->tbl_products)->result_array();
               }
               if (check_permission('registration', 'secondayregcourtseycall_notify')) {
                    $yesterday = date('Y-m-d', strtotime('-1 day'));

                    $MyGivenDateIn = strtotime($yesterday);
                    $ConverDate = date("l", $MyGivenDateIn);
                    $ConverDateTomatch = strtolower($ConverDate);

                    if ($ConverDateTomatch == "sunday") {
                         $yesterday = date('Y-m-d', strtotime('-2 day'));
                    }
                    //->where('DATE(' . $this->tbl_register_master . '.vreg_entry_date) = ', $yesterday)
                    $return['secondayregcourtseycall'] = $this->db->where('vreg_assigned_to', $this->uid)->where('vreg_contact_mode', 9)->where('vreg_second_d_hpy_cal IS NULL')
                         ->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses)->count_all_results($this->tbl_register_master);

                    // if($this->uid == 968) {
                    //      echo $this->db->last_query();
                    //      debug($return['secondayregcourtseycall']);
                    // }
               }

               if (check_permission('insurance', 'index')) {
                    $selArray = array(
                         $this->tbl_valuation . '.val_id',
                         'UPPER(' . $this->tbl_valuation . '.val_veh_no) AS val_veh_no',
                         $this->tbl_valuation . '.val_status',
                         $this->tbl_valuation . '.val_type',
                         $this->tbl_valuation . '.val_prt_1',
                         $this->tbl_valuation . '.val_prt_2',
                         $this->tbl_valuation . '.val_prt_3',
                         $this->tbl_valuation . '.val_prt_4',
                         $this->tbl_valuation . '.val_valuation_date',
                         $this->tbl_valuation . '.val_insurance_idv',
                         $this->tbl_valuation . '.val_insurance_company',
                         $this->tbl_valuation . '.val_insurance_validity',
                         "DATEDIFF(DATE(" . $this->tbl_valuation . ".val_insurance_validity), '" . date('Y-m-d') . "') AS validity",
                         $this->tbl_model . '.mod_title',
                         $this->tbl_brand . '.brd_title',
                         $this->tbl_variant . '.var_variant_name',
                    );
                    $return['insurance_expiry'] = $this->db->select($selArray, false)
                         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                         ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                         ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                         ->where("DATEDIFF(DATE(" . $this->tbl_valuation . ".val_insurance_validity), '" . date('Y-m-d') . "') <= 4")
                         ->order_by('val_insurance_validity')->where('val_comp_stock', 1)->get($this->tbl_valuation)->result_array();
               }
          }
          return array_filter($return);
     }

     function getShowroomDetails($id)
     {
          return $this->db->get_where($this->tbl_showroom, array('shr_id' => $id))->row_array();
     }

     function getDivisionDetails($id)
     {
          return $this->db->get_where($this->tbl_divisions, array('div_id' => $id))->row_array();
     }

     /* function getBookedVehicle() {
       $this->tbl_vehicle_booking_master = TABLE_PREFIX . 'vehicle_booking_master';
       $this->tbl_vehicle_booking_confirmations = TABLE_PREFIX . 'vehicle_booking_confirmations';

       $fields = array(
       $this->tbl_vehicle_booking_master . '.*', $this->tbl_vehicle_booking_confirmations . '.*'
       );

       $bookedVehicle = $this->db->select($fields)
       ->join($this->tbl_vehicle_booking_confirmations, $this->tbl_vehicle_booking_confirmations . '.vbc_book_master = ' .
       $this->tbl_vehicle_booking_master . '.vbk_id', 'LEFT')
       ->where('(cpnl_vehicle_booking_confirmations.vbc_verify_by = ' . $this->uid . ' OR cpnl_vehicle_booking_confirmations.vbc_verify_by IS NULL)')
       ->get($this->tbl_vehicle_booking_master)->result_array();
       return $bookedVehicle;
       } */

     function getRegectedVehicle()
     {
          $this->load->model('followup/followup_model', 'followup');
          $this->followup->getRejectBooking();
     }

     function getStatus($stsValue, $field = array())
     {
          if (!empty($field)) {
               $this->db->select($field);
          }
          return $this->db->where(array('sts_value' => $stsValue))->get($this->tbl_statuses)->row();
     }

     function getPriceRanges()
     {
          return $this->db->order_by('pr_sort_order', 'asc')->get($this->tbl_price_range)->result_array();
     }

     // function getVehicleColors_old() {
     //      return $this->db->order_by('vc_sort_order', 'asc')->get($this->tbl_vehicle_colors)->result_array();
     // }
     function getVehicleColors($id = '')
     { //
          if ($id) {
               return $this->db->order_by('vc_color ', 'asc')->where('vc_id', $id)->get($this->tbl_vehicle_colors)->row_array();
          } else {
               return $this->db->order_by('vc_color ', 'asc')->get($this->tbl_vehicle_colors)->result_array();
          }
     }

     function pendingPrecurementNotification()
     {
          if ($this->uid > 0) {
               return $this->db->select($this->tbl_procurement_rqsts . ".*, " . $this->tbl_procurement_rqst_details . ".proc_dt_viewed_id", false)
                    ->join($this->tbl_procurement_rqst_details, $this->tbl_procurement_rqst_details . '.proc_dt_master_id = ' .
                         $this->tbl_procurement_rqsts . '.proc_id AND ' .
                         $this->tbl_procurement_rqst_details . '.proc_dt_viewed_id = ' . $this->uid, 'LEFT')
                    ->where($this->tbl_procurement_rqst_details . '.proc_dt_viewed_id IS NULL')
                    ->limit(5)->get($this->tbl_procurement_rqsts)->result_array();
          }
          return array();
     }

     function getVehicleName($brdId = '', $modId = '', $varId = '')
     {
          if ($brdId) {
               $bmv[0] = $this->db->select('brd_title AS bmv')->where('brd_id', $brdId)->get($this->tbl_brand)->row()->bmv;
          }
          if ($modId) {
               $bmv[1] = $this->db->select('mod_title AS bmv')->where('mod_id', $modId)->get($this->tbl_model)->row()->bmv;
          }
          if ($varId) {
               $bmv[2] = $this->db->select('var_variant_name AS bmv')->where('var_id', $varId)->get($this->tbl_variant)->row()->bmv;
          }

          return implode(', ', $bmv);
     }

     function getDistricts($id = '')
     {
          if ($id) {
               return $this->db->where_in($this->tbl_district_statewise . '.std_state', $id)
                    ->get($this->tbl_district_statewise)->result_array();
          }
          return $this->db->get($this->tbl_district_statewise)->result_array();
     }
     function feedback()
     {
          return $this->db->where('app_feedback_action_pln IS NULL')->count_all_results($this->tbl_feedback);
     }

     function pendingInsuranceApproval()
     {
          $this->tbl_valuation = 'cpnl_valuation';
          return $this->db->where_in('val_status', array(add_stock, book_delvry))
               ->where("(DATEDIFF(DATE(val_insurance_comp_date), '" . date('Y-m-d') . "') <= 4) OR (DATEDIFF(DATE(val_insurance_ll_date), '" . date('Y-m-d') . "') <= 4)")
               ->count_all_results($this->tbl_valuation);
     }
}