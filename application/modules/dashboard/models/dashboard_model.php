<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class dashboard_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->tbl_city = TABLE_PREFIX . 'city';
          $this->tbl_state = TABLE_PREFIX . 'state';
          $this->tbl_place = TABLE_PREFIX . 'place';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_country = TABLE_PREFIX . 'country';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_followup = TABLE_PREFIX . 'followup';
          $this->tbl_district = TABLE_PREFIX . 'district';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_occupation = TABLE_PREFIX . 'occupation';
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
     }

     function countTotalEnquires()
     {

          $analysis = array();
          $showroom = get_logged_user('usr_showroom');
          $analysis['stock_vehicle'] = $this->db->where('(val_status = ' . add_stock . ' OR val_status = 28 OR val_status = 13)')
               ->where(array('val_booking_status' => 0))->count_all_results($this->tbl_valuation);
          if (is_roo_user()) {
               $where = ' WHERE enq_current_status != 9';
               $analysis['active_enquires'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 3';
               $analysis['dropped_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 7';
               $analysis['soled_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_se_id != enq_added_by';
               $analysis['total_assigned'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;
          } else if ($this->usr_grp == 'MG') { // Manager
               $where = ' WHERE enq_current_status = 1 AND enq_showroom_id = ' . $showroom;
               $analysis['active_enquires'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 3 AND enq_showroom_id = ' . $showroom;
               $analysis['dropped_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 7 AND enq_showroom_id = ' . $showroom;
               $analysis['soled_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE (enq_se_id != enq_added_by) AND enq_showroom_id = ' . $showroom;
               $analysis['total_assigned'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;
          } else if (check_permission('enquiry', 'showluxusyenq')) {

               $where = ' WHERE enq_current_status = 1 AND (enq_showroom_id = 2 OR enq_showroom_id = 4 OR enq_showroom_id = 6)';
               $analysis['active_enquires'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 3 AND enq_added_by = ' . $this->uid;
               $analysis['dropped_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 7 AND enq_added_by = ' . $this->uid;
               $analysis['soled_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE (enq_se_id != enq_added_by) AND enq_se_id = ' . $this->uid;
               $analysis['total_assigned'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $where = ' WHERE enq_current_status = 1 AND enq_added_by = ' . $this->uid;
               $analysis['active_enquires'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 3 AND enq_added_by = ' . $this->uid;
               $analysis['dropped_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 7 AND enq_added_by = ' . $this->uid;
               $analysis['soled_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE (enq_se_id != enq_added_by) AND enq_added_by = ' . $this->uid;
               $analysis['total_assigned'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;
          } else if ($this->usr_grp == 'SE') {
               $where = ' WHERE enq_current_status = 1 AND enq_se_id = ' . $this->uid;
               $analysis['active_enquires'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 3 AND enq_added_by = ' . $this->uid;
               $analysis['dropped_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE enq_current_status = 7 AND enq_added_by = ' . $this->uid;
               $analysis['soled_vehicles'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;

               $where = ' WHERE (enq_se_id != enq_added_by) AND enq_se_id = ' . $this->uid;
               $analysis['total_assigned'] = $this->db->query("SELECT COUNT(*) AS enq_total FROM " . $this->tbl_enquiry . $where)->row()->enq_total;
          } else if ($this->usr_grp == 'TL') {

               $mystaffs = array();
               if (check_permission('reports', 'show_res_inact_staff_also')) {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                    array_push($mystaffs, $this->uid);
               } else {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                         ->where(array('usr_tl' => $this->uid, 'usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->row()->usr_id);
                    array_push($mystaffs, $this->uid);
               }

               $analysis['active_enquires'] = $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs)
                    ->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)->count_all_results($this->tbl_enquiry, false);

               $analysis['dropped_vehicles'] = $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs)
                    ->where($this->tbl_enquiry . '.enq_current_status', 3)->count_all_results($this->tbl_enquiry, false);

               $analysis['soled_vehicles'] = $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs)
                    ->where($this->tbl_enquiry . '.enq_current_status', 7)->count_all_results($this->tbl_enquiry, false);

               $where = ' WHERE (enq_se_id != enq_added_by) AND enq_se_id IN (' . $mystaffs . ')';
               $analysis['total_assigned'] = $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs)
                    ->where('enq_se_id != enq_added_by')->count_all_results($this->tbl_enquiry, false);
          }
          return $analysis;
     }

     function dashboardMeterials()
     {
          $analysis = array();
          $showroom = get_logged_user('usr_showroom');

          $today = date('Y-m-d') . '<br>';
          $onemonthBefore = date('Y-m-d', (strtotime('-7 day', strtotime(date('Y-m-d')))));

          if (is_roo_user()) { // root users
               $tmpTblEnquiry = "(SELECT enq_id,enq_mode_enq,enq_entry_date,enq_cus_when_buy,enq_showroom_id FROM " . $this->tbl_enquiry . " WHERE DATE(enq_entry_date) BETWEEN '" . $onemonthBefore . "' AND '" . $today . "') tmp";

               $analysis['mode_of_enq_total_count'] = $this->db->select("COUNT(*) AS total_no")->get($tmpTblEnquiry)->row()->total_no;

               $analysis['mode_of_enq_count'] = $this->db->select("COUNT(*) AS total_no, enq_mode_enq, enq_entry_date", false)
                    ->group_by('enq_mode_enq')->having('total_no > 0')->get($tmpTblEnquiry)->result_array();

               //Hot+
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 1);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 1, 'total_no' => $cnt);

               //Hot
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 2);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 2, 'total_no' => $cnt);
               //echo $this->db->last_query();
               //debug($analysis);
               //Warm
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 3);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 3, 'total_no' => $cnt);

               //Cold
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 4);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 4, 'total_no' => $cnt);
          } else if ($this->usr_grp == 'MG') { // Manager
               $tmpTblEnquiry = "(SELECT enq_id,enq_mode_enq,enq_entry_date,enq_cus_when_buy,enq_showroom_id FROM " . $this->tbl_enquiry . " WHERE enq_showroom_id = $showroom AND DATE(enq_entry_date) BETWEEN '" . $onemonthBefore . "' AND '" . $today . "') tmp";

               $analysis['mode_of_enq_total_count'] = $this->db->select("COUNT(*) AS total_no, enq_showroom_id")
                    ->get($tmpTblEnquiry)->row()->total_no;

               $analysis['mode_of_enq_count'] = $this->db->select("COUNT(*) AS total_no, enq_mode_enq")
                    ->from($tmpTblEnquiry)->group_by('enq_mode_enq')->get()->result_array();

               //Hot+
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 1);
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 1, 'total_no' => $cnt);

               //Hot
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 2);
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 2, 'total_no' => $cnt);

               //Warm
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 3);
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 3, 'total_no' => $cnt);

               //Cold
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 4);
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 4, 'total_no' => $cnt);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $tmpTblEnquiry = "(SELECT enq_added_by,enq_id,enq_mode_enq,enq_entry_date,enq_cus_when_buy,enq_showroom_id FROM " . $this->tbl_enquiry . " WHERE enq_added_by = $this->uid AND DATE(enq_entry_date) BETWEEN '" . $onemonthBefore . "' AND '" . $today . "') tmp";

               $analysis['mode_of_enq_total_count'] = $this->db->select("COUNT(*) AS total_no, enq_added_by")->get($tmpTblEnquiry)->row()->total_no;

               $analysis['mode_of_enq_count'] = $this->db->select("COUNT(*) AS total_no, enq_mode_enq")
                    ->from($tmpTblEnquiry)->group_by('enq_mode_enq')->get()->result_array();

               $analysis['hwc_grp_total_count'] = $this->db->select("COUNT(*) AS total_no, enq_cus_when_buy")
                    ->from($tmpTblEnquiry)->group_by('enq_cus_when_buy')->get()->result_array();
          } else if ($this->usr_grp == 'SE') { // Sales executive
               $tmpTblEnquiry = "(SELECT enq_id,enq_mode_enq,enq_entry_date,enq_cus_when_buy,enq_showroom_id, enq_se_id FROM " . $this->tbl_enquiry . " WHERE enq_se_id = $this->uid AND DATE(enq_entry_date) BETWEEN '" . $onemonthBefore . "' AND '" . $today . "') tmp";

               $analysis['mode_of_enq_total_count'] = $this->db->select("COUNT(*) AS total_no, enq_se_id")
                    ->where(array('enq_se_id' => $this->uid))->get($tmpTblEnquiry)->row()->total_no;

               $analysis['mode_of_enq_count'] = $this->db->select("COUNT(*) AS total_no, enq_mode_enq")
                    ->from($tmpTblEnquiry)->group_by('enq_mode_enq')->get()->result_array();

               /*$analysis['hwc_grp_total_count'] = $this->db->select("COUNT(*) AS total_no, enq_cus_when_buy")
                                 ->from($tmpTblEnquiry)->group_by('enq_cus_when_buy')->get()->result_array();*/

               //Hot+
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 1);
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 1, 'total_no' => $cnt);

               //Hot
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 2);
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 2, 'total_no' => $cnt);

               //Warm
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 3);
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 3, 'total_no' => $cnt);

               //Cold
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 4);
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 4, 'total_no' => $cnt);
          } else if ($this->usr_grp == 'TL') { // Sales executive
               $mystaffs = $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id;
               if (empty($mystaffs)) {
                    $mystaffs  = $this->uid;
               }
               $tmpTblEnquiry = "(SELECT enq_se_id,enq_id,enq_mode_enq,enq_entry_date,enq_cus_when_buy,enq_showroom_id FROM " . $this->tbl_enquiry . " WHERE enq_se_id IN ($mystaffs) AND DATE(enq_entry_date) BETWEEN '" .
                    $onemonthBefore . "' AND '" . $today . "') tmp";

               $analysis['mode_of_enq_total_count'] = $this->db->query("SELECT COUNT(*) AS total_no, enq_se_id FROM $tmpTblEnquiry ")
                    ->row()->total_no;

               $analysis['mode_of_enq_count'] = $this->db->query("SELECT COUNT(*) AS total_no, enq_mode_enq FROM " .
                    $tmpTblEnquiry . " GROUP BY enq_mode_enq")->result_array();


               //Hot+
               $mystaffs = explode(',', $mystaffs);
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 1);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 1, 'total_no' => $cnt);

               //Hot
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 2);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 2, 'total_no' => $cnt);

               //Warm
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 3);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 3, 'total_no' => $cnt);

               //Cold
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', 4);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               $cnt = $this->db->count_all_results($this->tbl_enquiry);
               $analysis['hwc_grp_total_count'][] = array('enq_cus_when_buy' => 4, 'total_no' => $cnt);
          }

          /* Main graph */

          // Start date
          $date = date('Y-m-d', (strtotime('-7 day', strtotime(date('Y-m-d')))));
          // End date
          $end_date = date('Y-m-d');
          $mlp = array();
          $clt = array();
          $cok = array();
          $tvm = array();
          $dates = array();
          while (strtotime($date) <= strtotime($end_date)) {
               $datesFullFormat[] = date('d-m-Y', strtotime($date));

               $dates[] = "'" . date('d-m', strtotime($date)) . "'";

               $mlp[] = $this->db->query("SELECT COUNT(*) AS mlp_count FROM " . $this->tbl_enquiry . " WHERE DATE(enq_entry_date) = '$date' AND enq_showroom_id = 1")
                    ->row()->mlp_count;

               $clt[] = $this->db->query("SELECT COUNT(*) AS mlp_count FROM " . $this->tbl_enquiry . " WHERE DATE(enq_entry_date) = '$date' AND enq_showroom_id = 2")
                    ->row()->mlp_count;

               $cok[] = $this->db->query("SELECT COUNT(*) AS cok_count FROM " . $this->tbl_enquiry . " WHERE DATE(enq_entry_date) = '$date' AND enq_showroom_id = 4")
                    ->row()->cok_count;

               $tvm[] = $this->db->query("SELECT COUNT(*) AS cok_count FROM " . $this->tbl_enquiry . " WHERE DATE(enq_entry_date) = '$date' AND (enq_showroom_id = 6 OR enq_showroom_id = 7)")
                    ->row()->cok_count;

               $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
          }
          $analysis['mainGraphContent']['datesFullFormat'] = $datesFullFormat;
          $analysis['mainGraphContent']['dates'] = implode(',', $dates);
          $analysis['mainGraphContent']['MLP'] = implode(',', $mlp);
          $analysis['mainGraphContent']['CLT'] = implode(',', $clt);
          $analysis['mainGraphContent']['COK'] = implode(',', $cok);
          $analysis['mainGraphContent']['TVM'] = implode(',', $tvm);

          //if($this->uid == 100) {
          //debug($analysis);
          //}

          /* Main graph */

          //            $analysis['myreg_count'] = $this->db->query("SELECT COUNT(*) AS mlp_count FROM " . $this->tbl_register_master . " WHERE "
          //                            . "vreg_assigned_to = " . $this->uid . ' AND vreg_inquiry = 0')->row()->mlp_count;

          return $analysis;
     }

     function vehicleDemantGraph()
     {

          $vdr = $this->db->query("CALL sp_vehicle_demant_graph_new()")->result_array();
          $this->db->reconnect();
          $return = array();
          $return['vehicleBrandModel'] = implode(',', array_column($vdr, 'veh_brand_model'));
          $return['count'] = implode(',', array_column($vdr, 'veh_count'));
          return $return;
     }
}
