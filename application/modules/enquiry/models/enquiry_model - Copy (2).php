<?php

use function Psy\debug;

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class enquiry_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          //debug(TABLE_PREFIX);
          $this->db->query("SET time_zone = '+05:30'");
          $this->tbl_city = TABLE_PREFIX . 'city';
          $this->tbl_state = TABLE_PREFIX . 'state';
          $this->tbl_place = TABLE_PREFIX . 'place';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_events = TABLE_PREFIX . 'events';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_country = TABLE_PREFIX . 'country';
          // $this->tbl_vehicle = TABLE_PREFIX . 'vehicle_1';
          // $this->tbl_enquiry = TABLE_PREFIX . 'enquiry_1';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_statuses = TABLE_PREFIX . 'statuses';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          //$this->tbl_followup = TABLE_PREFIX . 'followup_1';
          $this->tbl_followup = TABLE_PREFIX . 'followup';
          $this->tbl_district = TABLE_PREFIX . 'district_statewise';
          $this->tbl_divisions = TABLE_PREFIX . 'divisions';
          $this->tbl_questions = TABLE_PREFIX . 'questions';
          //$this->tbl_valuation = TABLE_PREFIX . 'valuation_1';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_occupation = TABLE_PREFIX . 'occupation';
          $this->tbl_departments = TABLE_PREFIX . 'departments';
          $this->tbl_enquiry_pool = TABLE_PREFIX . 'enquiry_pool';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_customer_grade = TABLE_PREFIX . 'customer_grade';
          $this->tbl_vehicle_status = TABLE_PREFIX . 'vehicle_status';
          // $this->tbl_register_master = TABLE_PREFIX . 'register_master_1';
          // $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history_1';
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
          $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
          $this->tbl_quick_tc_report = TABLE_PREFIX . 'quick_tc_report';
          // $this->tbl_valuation_status = TABLE_PREFIX . 'valuation_status_1';
          // $this->tbl_register_history = TABLE_PREFIX . 'register_history_1';
          $this->tbl_valuation_status = TABLE_PREFIX . 'valuation_status';
          $this->tbl_register_history = TABLE_PREFIX . 'register_history';
          // $this->tbl_enquiry_questions = TABLE_PREFIX . 'enquiry_questions_1';
          // $this->tbl_register_followup = TABLE_PREFIX . 'register_followup_1';
          $this->tbl_enquiry_questions = TABLE_PREFIX . 'enquiry_questions';
          $this->tbl_register_followup = TABLE_PREFIX . 'register_followup';
          $this->tbl_callcenterbridging = TABLE_PREFIX . 'callcenterbridging';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->tbl_offer_prices = TABLE_PREFIX . 'offer_prices';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
          $this->view_enquiry_vehicle_master = TABLE_PREFIX . 'view_enquiry_vehicle_master';
          $this->tbl_quick_tc_report_master = TABLE_PREFIX . 'quick_tc_report_master';
          $this->tbl_occupation_category = TABLE_PREFIX . 'occupation_categories';
          $this->tbl_purpose_of_purchase = TABLE_PREFIX . 'purpose_of_purchase';
          $this->tbl_home_visits = TABLE_PREFIX . 'home_visits';
          $this->tbl_home_visit_approvals = TABLE_PREFIX . 'home_visit_approvals';
          $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
          $this->tbl_procurement_rqsts = TABLE_PREFIX . 'procurement_rqsts';
          $this->tbl_enq_prefrences = TABLE_PREFIX . 'enq_prefrences';
          $this->tbl_enquiry_meta = TABLE_PREFIX . 'enquiry_meta';
          $this->tbl_customer_details = TABLE_PREFIX . 'customer_details';
          $this->tbl_customer_phones = TABLE_PREFIX . 'customer_phones';
     }

     function enquires($id = '', $status = array(), $limit = 0, $page = 0, $exParams = array())
     { //enquires_rl
          error_reporting(E_ALL);
          //$this->myEnqStatuses = array(1);
          $this->load->model('evaluation/evaluation_model', 'evaluation');
          //$this->load->model('evaluation_new/evaluation_model', 'evaluation');
          $showroom = get_logged_user('usr_showroom');
          if (!empty($id)) {
               $this->updateEnquiryLastView($id);
               $enq = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_occupation . '.*,' . $this->tbl_city . '.*,'
                    . $this->tbl_district . '.*,' . $this->tbl_state . '.*,' . $this->tbl_country . '.*')
                    ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
                    ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
                    ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
                    ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
                    ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
                    //->join($this->tbl_valuation, $this->tbl_valuation . '.val_enquiry_id = ' . $this->tbl_enquiry . '.enq_id', 'left')
                    ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($this->tbl_enquiry . '.enq_id', $id)->get($this->tbl_enquiry)->row_array();
               // debug($enq);
               ////////   $enq = $this->db->select($this->tbl_enquiry . '.*,')
               // ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
               // ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
               // ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
               // ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
               //->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
               ////////// ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($this->tbl_enquiry . '.enq_id', $id)->get($this->tbl_enquiry)->row_array();
               //////////// debug($enq);

               if (!empty($enq)) {
                    $enq['followup'] = $this->db->order_by('foll_entry_date', 'DESC')
                         ->get_where($this->tbl_followup, array('foll_cus_id' => $id))->result_array();

                    //                    $enq['vehicle_sall'] = $this->db->select($this->view_vehicle_vehicle_status . '.*')
                    //                                    ->where('veh_enq_id = ' . $id . ' AND veh_status = 1 AND (vst_current_status != 99 OR vst_current_status IS NULL)')
                    //                                    ->get($this->view_vehicle_vehicle_status)->result_array();
                    //                    $enq['vehicle_buy'] = $this->db->select($this->view_vehicle_vehicle_status . '.*')
                    //                                    ->where('veh_enq_id = ' . $id . ' AND veh_status = 2 AND (vst_current_status != 99 OR vst_current_status IS NULL)')
                    //                                    ->get($this->view_vehicle_vehicle_status)->result_array();
                    //                    //
                    // debug($id);
                    //debug($enq['followup']);

                    // $whr = array('veh_enq_id' => $id, 'veh_status' => 2, 'veh_type' => 0, 'veh_enq_type_old' => NULL);
                    $whr = array('veh_enq_id' => $id, 'veh_status' => 2, 'veh_type' => 0, 'veh_enq_type_old' => 0);

                    $enq['vehicle_buy'] = $this->db->select(
                         $this->tbl_vehicle . '.*, ' .
                              $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
                              $this->tbl_valuation . '.val_id , ' . $this->tbl_valuation . '.val_insurance_company, ' . $this->tbl_valuation . '.val_insurance_comp_date AS ins_valid_up_to,' . $this->tbl_valuation . '.val_insurance_comp_date,' . $this->tbl_valuation . '.val_insurance_ll_idv,' . $this->tbl_valuation . '.val_insurance,' .
                              $this->tbl_valuation . '.val_insurance_ll_date, ' . $this->tbl_valuation . '.val_insurance_comp_idv,' . $this->tbl_valuation . '.val_insurance_ll_idv AS ncb_percntg,' . $this->tbl_valuation . '.val_insurance_need_ncb AS ncb_req,'
                              . $this->tbl_valuation . '.val_insurance AS insurance_type,' . $this->tbl_valuation . '.val_hypo_bank AS bank,' . $this->tbl_valuation . '.val_hypo_bank_branch AS bank_branch,' . $this->tbl_valuation . '.val_hypo_close_by_cust,' . $this->tbl_valuation . '.val_hypo_loan_date AS loan_starting_date,'
                              . $this->tbl_valuation . '.val_hypo_loan_end_date AS loan_ending_date,' . $this->tbl_valuation . '.val_hypo_daily_int AS daily_interest,' . $this->tbl_valuation . '.val_hypo_frclos_val AS forclousure_value,' . $this->tbl_valuation . '.val_hypo_frclos_date AS forclousure_date,' . $this->tbl_valuation . '.val_top_up_loan AS any_top_up_loan,'
                              . $this->tbl_valuation . '.val_hypo_loan_amt AS loan_amount,'
                    )->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                         ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                         ->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                         ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                         ->where($whr)->get($this->tbl_vehicle)->result_array();
                    //debug($enq['vehicle_buy']);

                    // $whr = array('veh_enq_id' => $id, 'veh_status' => 1, 'veh_type' => 1, 'veh_enq_type_old' => NULL); //rq veh
                    $whr = array('veh_enq_id' => $id, 'veh_status' => 1, 'veh_type' => 1, 'veh_enq_type_old' => 0);
                    $enq['vehicle_sall'] = $this->db->select(
                         $this->tbl_vehicle . '.*, ' .
                              $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
                    )->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                         ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                         //->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                         ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                         ->where($whr)->get($this->tbl_vehicle)->result_array();
                    // debug($enq['vehicle_sall']);
                    //@
                    //edit enq
                    //$whr = array('veh_enq_id' => $id, 'veh_status' => 0, 'veh_type' => 2, 'veh_enq_type_old' => NULL); //Existing veh
                    $whr = array('veh_enq_id' => $id, 'veh_status' => 0, 'veh_type' => 2, 'veh_enq_type_old' => 0);
                    $enq['vehicle_existing'] = $this->db->select(
                         $this->tbl_vehicle . '.*, ' .
                              $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
                    )->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                         ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                         //->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                         ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                         ->where($whr)->get($this->tbl_vehicle)->result_array();
                    //  $whr = array('veh_enq_id' => $id, 'veh_status' => 1, 'veh_type' => 3, 'veh_enq_type_old' => NULL); //Pitched veh
                    $whr = array('veh_enq_id' => $id, 'veh_status' => 1, 'veh_type' => 3, 'veh_enq_type_old' => 0); //Pitched veh
                    $enq['vehicle_pitched'] = $this->db->select(
                         $this->tbl_vehicle . '.*, ' .
                              $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
                              $this->tbl_valuation . '.*,'
                    )->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle . '.veh_stock_id', 'LEFT')
                         ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'LEFT')
                         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'LEFT')
                         ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'LEFT')
                         //->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                         ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                         ->where($whr)->get($this->tbl_vehicle)->result_array();
                    //@edit enq

                    $questions = $this->db->select($this->tbl_enquiry_questions . '.*,' . $this->tbl_questions . '.*')
                         ->join($this->tbl_questions, $this->tbl_questions . '.qus_id = ' . $this->tbl_enquiry_questions . '.enqq_question_id', 'LEFT')
                         ->where($this->tbl_enquiry_questions . '.enqq_enq_id', $id)->get($this->tbl_enquiry_questions)->result_array();

                    foreach ((array) $questions as $catID => $qst) {
                         $enq['questions'][$qst["qus_id"]] = $qst;
                    }
               }
               generate_log(array(
                    'log_title' => 'View a records',
                    'log_desc' => 'Records id : ' . $id,
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'R',
                    'log_ref_id' => $id,
                    'log_added_by' => get_logged_user('usr_id')
               ));
               return $enq;
          } else {
               //  debug('list');
               $whereSearch = '';
               if (isset($exParams['search']) && !empty($exParams['search'])) {
                    $exParams['search'] = trim($exParams['search']);
                    $whereSearch = '(' . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_users . ".usr_first_name LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_enquiry . ".enq_number LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_whatsapp LIKE '%" . $exParams['search'] . "%' )";
               }
               if (is_roo_user()) {
                    //$this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.usr_id, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->count_all_results($this->tbl_enquiry);
                    //Data

                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des'
                    );
                    //$this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();
                    //echo $this->db->last_query();
                    //exit;
                    return $return;
               } else if (check_permission('enquiry', 'showluxysmartenquiries')) {
                    //debug(2121);
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.usr_id, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->count_all_results($this->tbl_enquiry);
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }

                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des'
                    );
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();
                    return $return;
               } else if (check_permission('enquiry', 'showmyshowroom')) { // Manager // Sreejitha

                    $where[$this->tbl_users . '.usr_showroom'] = $showroom;
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }
                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des'
                    );
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                    return $return;
               } else if (check_permission('enquiry', 'showonlysmartenquires')) {

                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id' . $this->tbl_users . '.usr_id')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where(array('usr_division' => 1))->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }
                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_added_by',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des'
                    );

                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, array($this->tbl_users . '.usr_division' => 1))->result_array();
                    //echo $this->db->last_query();
                    return $return;
               } else if ($this->usr_grp == 'MG' || check_permission('enquiry', 'showonlymystaff')) { // Manager
                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_added_by',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des'
                    );

                    $mystaff = my_staff($this->uid);
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                         $where[$this->tbl_users . '.usr_resigned'] = 0;
                    }
                    if (check_permission('enquiry', 'enq_showsalesonly')) {
                         $this->db->where($this->tbl_enquiry . '.enq_cus_status != 2');
                    }
                    //Count
                    if (!empty($exclude)) {
                         $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                    }
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaff);

                    $return['count'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($exclude)) {
                         $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                    }
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }
                    if (check_permission('enquiry', 'enq_showsalesonly')) {
                         $this->db->where($this->tbl_enquiry . '.enq_cus_status != 2');
                    }
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaff);
                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des'
                    );
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();

                    return $return;
               } else if ($this->usr_grp == 'DE') { // Date entry operator

                    $where[$this->tbl_enquiry . '.enq_added_by'] = $this->uid;
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }

                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.usr_id, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);
                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }

                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des'
                    );
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                    //debug(777);
                    return $return;
               } else if ($this->usr_grp == 'SE') { // Seles executives

                    $where[$this->tbl_enquiry . '.enq_se_id'] = $this->uid;
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }

                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }

                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }
                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des'
                    );
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'inquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                    return $return;
               } else if ($this->usr_grp == 'TL') { // Team lead
                    //Get sales executves under team lead
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                         ->get($this->tbl_users)->row()->usr_id);


                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if (!empty($mystaffs)) {
                         array_push($mystaffs, $this->uid);
                         $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
                    }
                    if (!empty($where)) {
                         $this->where($where);
                    }

                    $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->count_all_results($this->tbl_enquiry);
                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    if (!empty($mystaffs)) {
                         array_push($mystaffs, $this->uid);
                         $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
                    }

                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des',
                    );
                    if (!empty($where)) {
                         $this->db->where($where);
                    }
                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();
                    return $return;
               } else {
                    // Seles executives // Tele callers

                    $where[$this->tbl_enquiry . '.enq_se_id'] = $this->uid;

                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }

                    $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }

                    if (check_permission('enquiry', 'onlylivecases')) {
                         $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    }
                    $select = array(
                         $this->tbl_enquiry . '.enq_id',
                         $this->tbl_enquiry . '.enq_number',
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
                         'tbl_added_by.usr_username AS enq_added_by_name',
                         $this->tbl_statuses . '.sts_title',
                         $this->tbl_statuses . '.sts_des',
                    );
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                    return $return;
               }
          }
     }

     function enquires_old_live($id = '', $status = array(), $limit = 0, $page = 0, $exParams = array())
     {
          $this->load->model('evaluation/evaluation_model', 'evaluation');
          $showroom = get_logged_user('usr_showroom');
          if (!empty($id)) {
               $this->updateEnquiryLastView($id);
               $enq = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_occupation . '.*,' . $this->tbl_city . '.*,'
                    . $this->tbl_district . '.*,' . $this->tbl_state . '.*,' . $this->tbl_country . '.*')
                    ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
                    ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
                    ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
                    ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
                    ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
                    ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($this->tbl_enquiry . '.enq_id', $id)->get($this->tbl_enquiry)->row_array();
               if (!empty($enq)) {
                    $enq['followup'] = $this->db->order_by('foll_entry_date', 'DESC')->get_where($this->tbl_followup, array('foll_cus_id' => $id))->result_array();

                    /* old qry $enq['vehicle_sall'] = $this->db->select($this->viewj_vehicle_vehicle_status . '.*')
                         ->where('veh_enq_id = ' . $id . ' AND veh_status = 1 AND (vst_current_status != 99 OR vst_current_status IS NULL)')
                         ->get($this->viewj_vehicle_vehicle_status)->result_array();*/
                    //     debug($enq['vehicle_sall']);
                    ///////////////$ jsk new
                    //$whr = array('veh_enq_id' => $id, 'veh_status' => 1, 'veh_type' => 1,'veh_enq_type_old' => 0); //rq veh
                    $whr = array('veh_enq_id' => $id, 'veh_status' => 1);
                    $enq['vehicle_sall'] = $this->db->select(
                         $this->tbl_vehicle . '.*, ' .
                              $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
                    )->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                         ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                         //->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                         ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                         ->where($whr)->get($this->tbl_vehicle)->result_array();
                    //  debug($enq['vehicle_sall']);

                    /////////@

                    /////old buy
                    // $enq['vehicle_buy'] = $this->db->select($this->viewj_vehicle_vehicle_status . '.*')
                    //      ->where('veh_enq_id = ' . $id . ' AND veh_status = 2 AND (vst_current_status != 99 OR vst_current_status IS NULL)')
                    //      ->get($this->viewj_vehicle_vehicle_status)->result_array();
                    //      debug($enq['vehicle_buy']);
                    ///@old buy

                    ////$ byu new/////
                    //$whr = array('veh_enq_id' => $id, 'veh_status' => 2, 'veh_type' => 0, 'veh_enq_type_old' => 0);
                    $whr = array('veh_enq_id' => $id, 'veh_status' => 2);

                    $enq['vehicle_buy'] = $this->db->select(
                         $this->tbl_vehicle . '.*, ' .
                              $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
                              $this->tbl_valuation . '.val_id , ' . $this->tbl_valuation . '.val_insurance_company, ' . $this->tbl_valuation . '.val_insurance_comp_date AS ins_valid_up_to,' . $this->tbl_valuation . '.val_insurance_comp_date,' . $this->tbl_valuation . '.val_insurance_ll_idv,' . $this->tbl_valuation . '.val_insurance,' .
                              $this->tbl_valuation . '.val_insurance_ll_date, ' . $this->tbl_valuation . '.val_insurance_comp_idv,' . $this->tbl_valuation . '.val_insurance_ll_idv AS ncb_percntg,' . $this->tbl_valuation . '.val_insurance_need_ncb AS ncb_req,'
                              . $this->tbl_valuation . '.val_insurance AS insurance_type,' . $this->tbl_valuation . '.val_hypo_bank AS bank,' . $this->tbl_valuation . '.val_hypo_bank_branch AS bank_branch,' . $this->tbl_valuation . '.val_hypo_close_by_cust,' . $this->tbl_valuation . '.val_hypo_loan_date AS loan_starting_date,'
                              . $this->tbl_valuation . '.val_hypo_loan_end_date AS loan_ending_date,' . $this->tbl_valuation . '.val_hypo_daily_int AS daily_interest,' . $this->tbl_valuation . '.val_hypo_frclos_val AS forclousure_value,' . $this->tbl_valuation . '.val_hypo_frclos_date AS forclousure_date,' . $this->tbl_valuation . '.val_top_up_loan AS any_top_up_loan,'
                              . $this->tbl_valuation . '.val_hypo_loan_amt AS loan_amount,'
                    )->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                         ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                         ->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                         ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                         ->where($whr)->get($this->tbl_vehicle)->result_array();
                    //debug($enq['vehicle_buy']);

                    ///@buy new////////////
                    $questions = $this->db->select($this->tbl_enquiry_questions . '.*,' . $this->tbl_questions . '.*')
                         ->join($this->tbl_questions, $this->tbl_questions . '.qus_id = ' . $this->tbl_enquiry_questions . '.enqq_question_id', 'LEFT')
                         ->where($this->tbl_enquiry_questions . '.enqq_enq_id', $id)->get($this->tbl_enquiry_questions)->result_array();
                    ///debug(1111);
                    foreach ((array) $questions as $catID => $qst) {
                         $enq['questions'][$qst["qus_id"]] = $qst;
                    }

                    $cusMobile = substr($enq['enq_cus_mobile'], -10);
                    $enq['regAssigned'] = $this->db->select($this->tbl_register_master . '.vreg_id, vreg_first_added_on, vreg_contact_mode, ' . $this->tbl_users . '.usr_username')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_register_master . '.vreg_first_owner', 'LEFT')
                         ->like($this->tbl_register_master . '.vreg_cust_phone', $cusMobile, 'both')->order_by('vreg_id', 'DESC')
                         ->get($this->tbl_register_master)->result_array();
               }
               generate_log(array(
                    'log_title' => 'View a records',
                    'log_desc' => 'Records id : ' . $id,
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'R',
                    'log_ref_id' => $id,
                    'log_added_by' => get_logged_user('usr_id')
               ));
               return $enq;
          } else {
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
                    $this->tbl_users . '.usr_id',
                    $this->tbl_users . '.usr_first_name',
                    'tbl_added_by.usr_username AS enq_added_by_name',
                    $this->tbl_statuses . '.sts_title',
                    $this->tbl_statuses . '.sts_des',
               );

               $whereSearch = '';
               if (isset($exParams['search']) && !empty($exParams['search'])) {
                    $exParams['search'] = trim($exParams['search']);
                    $whereSearch = '(' . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_users . ".usr_first_name LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_enquiry . ".enq_number LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_whatsapp LIKE '%" . $exParams['search'] . "%' )";
               }
               if (is_roo_user() || $this->uid == 100) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.usr_id, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    $return['data'] = $this->db->select($select)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                         //->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();

                    return $return;
               } else if (check_permission('enquiry', 'showluxysmartenquiries')) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.usr_id, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->count_all_results($this->tbl_enquiry);
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();

                    return $return;
               } else if ($this->usr_grp == 'MG') { // Manager
                    $where[$this->tbl_enquiry . '.enq_showroom_id'] = $showroom;
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk

                    //Count
                    if (!empty($exclude)) {
                         $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                    }
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.usr_id, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($exclude)) {
                         $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                    }
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses); //new jsk
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                    //   debug($return);
                    return $return;
               } else if (check_permission('enquiry', 'showmyshowroom')) { // Manager // Sreejitha
                    // debug(12123);
                    $where[$this->tbl_enquiry . '.enq_showroom_id'] = $showroom;
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                    return $return;
               } else if ($this->usr_grp == 'DE') { // Date entry operator
                    $where[$this->tbl_enquiry . '.enq_added_by'] = $this->uid;
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.usr_id, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);
                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                    return $return;
               } else if ($this->usr_grp == 'SE') { // Seles executives
                    $where[$this->tbl_enquiry . '.enq_se_id'] = $this->uid;
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }

                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'inquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                    return $return;
               } else if ($this->usr_grp == 'TL') { // Team lead
                    //Get sales executves under team lead
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                         ->get($this->tbl_users)->row()->usr_id);
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if (!empty($mystaffs)) {
                         array_push($mystaffs, $this->uid);
                         $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
                    }
                    if (!empty($where)) {
                         $this->where($where);
                    }

                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.usr_id, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->count_all_results($this->tbl_enquiry);
                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }
                    if (!empty($mystaffs)) {
                         array_push($mystaffs, $this->uid);
                         $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
                    }

                    if (!empty($where)) {
                         $this->db->where($where);
                    }
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();
                    return $return;
               } else {
                    $where[$this->tbl_enquiry . '.enq_se_id'] = $this->uid;
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                    //Count
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }

                    $return['count'] = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.usr_id, tbl_added_by.usr_username AS enq_added_by_name')
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                    //Data
                    if (!empty($whereSearch)) {
                         $this->db->where($whereSearch);
                    }
                    if ($limit) {
                         $this->db->limit($limit, $page);
                    }

                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                    $return['data'] = $this->db->select($select)
                         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                         ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                         ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                         // ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                         ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                    return $return;
               }
          }
     }

     function newEnquiry($data, $valId = 0)
     { //jjj
         
        //  print_r($data);
          //  debug($data,1);
          // debug($data['vehicle']['buy'],1);
          // debug('mdl_0',1);
          $er = '';
          generate_log(array(
               'log_title' => 'New inquiry',
               'log_desc' => json_encode($data),
               'log_controller' => 'new-enquiry',
               'log_action' => 'C',
               'log_ref_id' => 1425,
               'log_added_by' => $this->uid
          ));
          $regId = 0;
          if (isset($data['vreg_id']) && !empty($data['vreg_id'])) {
               $regId = $data['vreg_id'];
               unset($data['vreg_id']);
          }

          $this->load->model('followup_new/followup_model', 'followup');
          if (isset($data['enquiry']['enq_cus_mobile']) && !empty($data['enquiry']['enq_cus_mobile'])) {
               $cusMobile = substr($data['enquiry']['enq_cus_mobile'], -10);
               $duplicateEntry = $this->db->like('enq_cus_mobile', $cusMobile, 'before')->get($this->tbl_enquiry)->row_array();
               if (!empty($duplicateEntry)) {
                    $data['enquiry']['enq_current_status'] = 9;
               }
          }
          $showroom = get_logged_user('usr_showroom');
          if (!empty($data)) {
               $enquiryId = '';

               /* Set default values */

               $data['enquiry']['enq_punched_by'] = $this->uid;
               $data['enquiry']['enq_added_by'] = $this->uid;
               $data['enquiry']['enq_showroom_id'] = $showroom;
               $data['enquiry']['enq_cus_id'] = $data['vreg_cust_id'];
               $data['enquiry']['enq_cus_age_group'] = isset($data['enquiry']['enq_cus_age_group']) ? $data['enquiry']['enq_cus_age_group'] : 0;
               $data['enquiry']['enq_cus_pin'] = empty($data['enquiry']['enq_cus_pin']) ? 0 : $data['enquiry']['enq_cus_pin'];
               $data['enquiry']['enq_cus_when_buy'] = isset($data['followup']['foll_status']) ? $data['followup']['foll_status'] : 0;
               $data['enquiry']['enq_cus_loan_emi'] = empty($data['enquiry']['enq_cus_loan_emi']) ? 0 : $data['enquiry']['enq_cus_loan_emi'];
               $data['enquiry']['enq_cus_status'] = empty($data['enquiry']['enq_cus_status']) ? 0 : $data['enquiry']['enq_cus_status'];
               $data['enquiry']['enq_cus_test_drive'] = 0; //isset($data['enquiry']['enq_cus_test_drive']) ? 0 : $data['enquiry']['enq_cus_test_drive'];
               $data['enquiry']['enq_current_status'] = empty($data['enquiry']['enq_current_status']) ? 1 : $data['enquiry']['enq_current_status'];
               $data['enquiry']['enq_cus_loan_period'] = empty($data['enquiry']['enq_cus_loan_period']) ? 0 : $data['enquiry']['enq_cus_loan_period'];
               $data['enquiry']['enq_cus_loan_amount'] = empty($data['enquiry']['enq_cus_loan_amount']) ? 0 : $data['enquiry']['enq_cus_loan_amount'];
               //$data['enquiry']['enq_cus_loan_amount'] = empty($data['enquiry']['enq_cus_loan_amount']) ? 0 : $data['enquiry']['enq_cus_loan_amount'];
               $data['enquiry']['enq_cus_family_members'] = empty($data['enquiry']['enq_cus_family_members']) ? 0 : $data['enquiry']['enq_cus_family_members'];
               $data['enquiry']['enq_cus_gender'] = isset($data['enquiry']['enq_cus_gender']) ? $data['enquiry']['enq_cus_gender'] : 0;
               $data['enquiry']['enq_cus_age'] = isset($data['enquiry']['enq_cus_age']) ? $data['enquiry']['enq_cus_age'] : 0;
               $data['enquiry']['enq_cus_address'] = isset($data['enquiry']['enq_cus_address']) ? $data['enquiry']['enq_cus_address'] : '';
               $data['enquiry']['enq_cus_ofc_address'] = isset($data['enquiry']['enq_cus_ofc_address']) ? $data['enquiry']['enq_cus_ofc_address'] : '';
               $data['enquiry']['enq_cus_office_no'] = isset($data['enquiry']['enq_cus_office_no']) ? $data['enquiry']['enq_cus_office_no'] : '';
               $data['enquiry']['enq_cus_occu'] = isset($data['enquiry']['enq_cus_occu']) ? $data['enquiry']['enq_cus_occu'] : '';
               $data['enquiry']['enq_cus_occu_category'] = isset($data['enquiry']['enq_cus_occu_category']) ? $data['enquiry']['enq_cus_occu_category'] : '';
               $data['enquiry']['enq_cus_purpose'] = isset($data['enquiry']['enq_cus_purpose']) ? $data['enquiry']['enq_cus_purpose'] : '';
               $data['enquiry']['enq_money_name'] = isset($data['money']['name']) ? $data['money']['name'] : '';
               $data['enquiry']['enq_money_phone'] = isset($data['money']['phone']) ? $data['money']['phone'] : '';
               $data['enquiry']['enq_money_relation'] = isset($data['money']['relation']) ? $data['money']['relation'] : '';
               $data['enquiry']['enq_money_remarks'] = isset($data['money']['remarks']) ? $data['money']['remarks'] : '';
               $data['enquiry']['enq_need_name'] = isset($data['need']['name']) ? $data['need']['name'] : '';
               $data['enquiry']['enq_need_phone'] = isset($data['need']['phone']) ? $data['need']['phone'] : '';
               $data['enquiry']['enq_need_relation'] = isset($data['need']['relation']) ? $data['need']['relation'] : '';
               $data['enquiry']['enq_need_remarks'] = isset($data['need']['remarks']) ? $data['need']['remarks'] : '';
               $data['enquiry']['enq_authority_name'] = isset($data['authority']['name']) ? $data['authority']['name'] : '';
               $data['enquiry']['enq_authority_phone'] = isset($data['authority']['phone']) ? $data['authority']['phone'] : '';
               $data['enquiry']['enq_authority_relation'] = isset($data['authority']['relation']) ? $data['authority']['relation'] : '';
               $data['enquiry']['enq_authority_remarks'] = isset($data['authority']['remarks']) ? $data['authority']['remarks'] : '';
               $data['enquiry']['enq_mode_enq'] = empty($data['enquiry']['enq_mode_enq']) ? 0 : $data['enquiry']['enq_mode_enq'];
               /* Set default values */

               if (isset($data['enquiry']) && !empty($data['enquiry'])) {
                    if (isset($data['enquiry']['other_purpose']) && !empty($data['enquiry']['other_purpose'])) {
                         $this->db->insert($this->tbl_purpose_of_purchase, array('purp_name' => $data['enquiry']['other_purpose'], 'purp_status' => 0, 'purp_addded_by' => $this->uid, 'purp_added_on' => date('Y-m-d H:i:s')));
                         $data['enquiry']['enq_cus_purpose'] = $this->db->insert_id();
                         unset($data['enquiry']['other_purpose']);
                    }

                    /* Occupation */
                    //                    if (isset($data['enquiry']['enq_cus_occu']) && !empty($data['enquiry']['enq_cus_occu'])) {
                    //                         $occu = $this->db->like('occ_name', $data['enquiry']['enq_cus_occu'], 'both')->get($this->tbl_occupation)->row_array();
                    //                         if (empty($occu)) {
                    //                              $this->db->insert($this->tbl_occupation, array('occ_name' => $data['enquiry']['enq_cus_occu']));
                    //                              $data['enquiry']['enq_cus_occu'] = $this->db->insert_id();
                    //                         } else {
                    //                              $data['enquiry']['enq_cus_occu'] = $occu['occ_id'];
                    //                         }
                    //                    } else {
                    //                         $data['enquiry']['enq_cus_occu'] = 0;
                    //                    }
                    /* City */
                    if (isset($data['enquiry']['enq_cus_city']) && !empty($data['enquiry']['enq_cus_city'])) {
                         $city = $this->db->like('cit_name', $data['enquiry']['enq_cus_city'], 'both')->get($this->tbl_city)->row_array();
                         if (empty($city)) {
                              $this->db->insert($this->tbl_city, array('cit_name' => $data['enquiry']['enq_cus_city']));
                              $data['enquiry']['enq_cus_city'] = $this->db->insert_id();
                         } else {
                              $data['enquiry']['enq_cus_city'] = $city['cit_id'];
                         }
                    } else {
                         $data['enquiry']['enq_cus_city'] = 0;
                    }
                    /* District */
                    /* if (isset($data['enquiry']['enq_cus_dist']) && !empty($data['enquiry']['enq_cus_dist'])) {
                        $dist = $this->db->like('dit_name', $data['enquiry']['enq_cus_dist'], 'both')->get($this->tbl_district)->row_array();
                        if (empty($dist)) {
                        $this->db->insert($this->tbl_district, array('dit_name' => $data['enquiry']['enq_cus_dist']));
                        $data['enquiry']['enq_cus_dist'] = $this->db->insert_id();
                        } else {
                        $data['enquiry']['enq_cus_dist'] = $dist['dit_id'];
                        }
                        } else {
                        $data['enquiry']['enq_cus_dist'] = 0;
                        } */
                    /* State */
                    //                    if (isset($data['enquiry']['enq_cus_state']) && !empty($data['enquiry']['enq_cus_state'])) {
                    //                         $state = $this->db->like('stt_name', $data['enquiry']['enq_cus_state'], 'both')->get($this->tbl_state)->row_array();
                    //                         if (empty($state)) {
                    //                              $this->db->insert($this->tbl_state, array('stt_name' => $data['enquiry']['enq_cus_state']));
                    //                              $data['enquiry']['enq_cus_state'] = $this->db->insert_id();
                    //                         } else {
                    //                              $data['enquiry']['enq_cus_state'] = $state['stt_id'];
                    //                         }
                    //                    } else {
                    //                         $data['enquiry']['enq_cus_state'] = 0;
                    //                    }
                    /* Country */
                    //                    if (isset($data['enquiry']['enq_cus_country']) && !empty($data['enquiry']['enq_cus_country'])) {
                    //                         $country = $this->db->like('cnt_name', $data['enquiry']['enq_cus_country'], 'both')->get($this->tbl_country)->row_array();
                    //                         if (empty($country)) {
                    //                              $this->db->insert($this->tbl_country, array('cnt_name' => $data['enquiry']['enq_cus_country']));
                    //                              $data['enquiry']['enq_cus_country'] = $this->db->insert_id();
                    //                         } else {
                    //                              $data['enquiry']['enq_cus_country'] = $country['cnt_id'];
                    //                         }
                    //                    } else {
                    //                         $data['enquiry']['enq_cus_country'] = 0;
                    //                    }
                    /* Sale and purchase */
                    $data['enquiry']['enq_se_id'] = isset($data['enquiry']['enq_se_id']) ? $data['enquiry']['enq_se_id'] : $this->uid;
                    $data['enquiry']['enq_entry_date'] = (isset($data['enquiry']['enq_entry_date']) && !empty($data['enquiry']['enq_entry_date'])) ?
                         date('Y-m-d', strtotime($data['enquiry']['enq_entry_date'])) : '';

                    $data['enquiry']['enq_next_foll_date'] = (isset($data['followup']['foll_next_foll_date']) &&
                         !empty($data['followup']['foll_next_foll_date'])) ?
                         date('Y-m-d', strtotime($data['followup']['foll_next_foll_date'])) : null;

                    $data['enquiry']['enq_added_on'] = date('Y-m-d H:i:s'); //03-12-2020 changed to h -> H
                    if ($this->db->insert($this->tbl_enquiry, array_filter($data['enquiry']), true)) {
                         $enquiryId = $this->db->insert_id();
                         /*Update custmer data*/
                         if (isset($data['vreg_cust_id']) && !empty($data['vreg_cust_id'])) {

                              $cusData = [
                                   'cusd_name' =>  $data['enquiry']['enq_cus_name'],
                                   'cusd_phone_resi'=> $data['enquiry']['enq_cus_phone_res'],
                                   'cusd_phone_office'=> $data['enquiry']['enq_cus_office_no'],
                                   'cusd_whatsapp'=> $data['enquiry']['enq_cus_whatsapp'],
                                   'cusd_email'=> $data['enquiry']['enq_cus_email'],
                                   'cusd_fb'=> $data['enquiry']['enq_cus_fbid'],
                                   'cusd_place'=> $data['enquiry']['enq_cus_city'], 
                                   'cusd_address'=> $data['enquiry']['enq_cus_address'],
                                   'cusd_address_office'=> $data['enquiry']['enq_cus_ofc_address'],   
                                   'cusd_district'=> $data['enquiry']['enq_cus_dist'],
                                   'cusd_profession'=>$data['enquiry']['enq_cus_occu'],//profession
                                   'cusd_company'=> $data['enquiry']['enq_cus_company'],
                                   'cusd_age'=> $data['enquiry']['enq_cus_age_group'],
                                   'cusd_gender'=> $data['enquiry']['enq_cus_gender'],
                                   'cusd_pin'=> $data['enquiry']['enq_cus_pin'],
                               ];
                               $cus_id = $this->updateCustomer($cusData, $data['vreg_cust_id']);
                              
                                  if ($cus_id) {
                                      //echo "Customer updated successfully.";
                                  } else {
                                     // echo "Failed to update customer.";
                                  }
                                                       }
                                                       /*End Update custmer data*/

                         /* Enquiry history */
                         $enqH['enh_remarks'] = 'New enquiry created ';
                         $enqH['enh_added_by'] = $this->uid;
                         $enqH['enh_added_on'] = date('Y-m-d H:i:s');
                         $enqH['enh_enq_id'] = $enquiryId;
                         $enqH['enh_status'] = 1;
                         $enqH['enh_current_sales_executive'] = $data['enquiry']['enq_se_id'];
                         $enqH['enh_contact_mod'] = $data['enquiry']['enq_mode_enq'];
                         $this->db->insert($this->tbl_enquiry_history, $enqH);
                         $historyId = $this->db->insert_id();
                         /* Enquiry history*/

                         $this->db->where('enq_id', $enquiryId)->update(
                              $this->tbl_enquiry,
                              array('enq_number' => generate_vehicle_virtual_id($enquiryId), 'enq_current_status_history' => $historyId)
                         );

                         //Questions  
                         /* $questions = array();
                             if ($data['enquiry']['enq_cus_status'] == 1) { // Sale
                             $questions = explode(',', $this->db->select('GROUP_CONCAT(qus_id) AS qus_id')
                             ->get_where($this->tbl_questions, 'qus_type = 1 OR qus_type = 2')->row()->qus_id);
                             } else if ($data['enquiry']['enq_cus_status'] == 2) { // Buy
                             $questions = explode(',', $this->db->select('GROUP_CONCAT(qus_id) AS qus_id')
                             ->get_where($this->tbl_questions, 'qus_type = 1 OR qus_type = 3')->row()->qus_id);
                             } else if ($data['enquiry']['enq_cus_status'] == 3) { // Exch
                             $questions = explode(',', $this->db->select('GROUP_CONCAT(qus_id) AS qus_id')
                             ->get_where($this->tbl_questions, 'qus_type = 1 OR qus_type = 4')->row()->qus_id);
                             }
                             if (!empty($questions) && !empty($data['questions'])) {
                             foreach ($data['questions'] as $key => $value) {
                             $quesId = substr($key, 4);
                             if (in_array($quesId, $questions) && !empty($value)) {
                             $qstArray = array(
                             'enqq_enq_id' => $enquiryId,
                             'enqq_question_id' => $quesId,
                             'enqq_answer' => $value
                             );
                             $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                             }
                             }
                             } */
                         if ($data['enquiry']['enq_cus_status'] == 1) {
                              if (!empty($data['saquestions'])) {
                                   foreach ($data['saquestions'] as $key => $value) {
                                        /*                                   $quesId = substr($key, 4);
                                            if (in_array($quesId, $questions) && !empty($value)) { */
                                        if (!empty($value)) {
                                             $qstArray = array(
                                                  'enqq_enq_id' => $enquiryId,
                                                  'enqq_question_id' => $key,
                                                  'enqq_answer' => $value
                                             );
                                             $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                                        }
                                   }
                              }
                         } elseif ($data['enquiry']['enq_cus_status'] == 2) {


                              if (!empty($data['byquestions'])) {
                                   foreach ($data['byquestions'] as $key => $value) {
                                        //                                     $quesId = substr($key, 4);
                                        if (!empty($value)) {
                                             $qstArray = array(
                                                  'enqq_enq_id' => $enquiryId,
                                                  'enqq_question_id' => $key,
                                                  'enqq_answer' => $value
                                             );
                                             $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                                        }
                                   }
                              }
                         } else {

                              if (!empty($data['exquestions'])) {
                                   foreach ($data['exquestions'] as $key => $value) {
                                        //                                     $quesId = substr($key, 4);
                                        if (!empty($value)) {
                                             $qstArray = array(
                                                  'enqq_enq_id' => $enquiryId,
                                                  'enqq_question_id' => $key,
                                                  'enqq_answer' => $value
                                             );
                                             $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                                        }
                                   }
                              }
                         }
                         //Questions

                         if ($regId > 0) {
                              /* Update register master */
                              $this->db->where('vreg_id', $regId);
                              $this->db->update($this->tbl_register_master, array('vreg_status' => 1, 'vreg_inquiry' => $enquiryId, 'vreg_is_punched' => 1));
                         }
                         if ($data['enquiry']['enq_cus_status'] == 1 || $data['enquiry']['enq_cus_status'] == 3) { //sale or Exchange
                              $noOfSale = isset($data['vehicle']['sale']['veh_brand']) ? count($data['vehicle']['sale']['veh_brand']) : 0; //required
                              if ($noOfSale > 0) {
                                   $this->storeReqVeh($data['vehicle']['sale'], $noOfSale, $enquiryId, $data['enquiry']['enq_se_id']); //req
                              }

                              $noOfPitched = isset($data['vehicle']['pitched']['veh_val_id']) ? count($data['vehicle']['pitched']['veh_val_id']) : 0;
                              if ($noOfPitched > 0) {
                                   $this->storePitchedVeh($data['vehicle']['pitched'], $noOfPitched, $enquiryId);
                              }
                         }
                         /* Existing veh */
                         $noOfExisting = isset($data['vehicle']['existing']['veh_brand']) ? count($data['vehicle']['existing']['veh_brand']) : 0;
                         if ($noOfExisting > 0) {
                              $this->storeExistingVeh($data['vehicle']['existing'], $noOfExisting, $enquiryId);
                         }
                         /* @Existing veh */
                         if ($data['enquiry']['enq_cus_status'] == 2 || $data['enquiry']['enq_cus_status'] == 3) { //purchase //jsk create function
                              $noOfBuy = isset($data['vehicle']['buy']['veh_brand']) ? count($data['vehicle']['buy']['veh_brand']) : 0;
                              $this->storePurchaseVeh($data['vehicle']['buy'], $noOfBuy, $enquiryId, $data['enquiry']);
                         }

                         if (isset($data['followup']) && !empty($data['followup'])) {/* Followup */
                              // debug($data['followup']);
                              if (!empty($noOfPitched)) {
                                   $veh_id = $this->db->select('veh_id')->order_by('veh_id', 'ASC')->get_where($this->tbl_vehicle, array('veh_enq_id' => $enquiryId, 'veh_type' => 3))->row_array();
                              } else {
                                   $veh_id = $this->db->select('veh_id')->order_by('veh_id', 'ASC')->get_where($this->tbl_vehicle, array('veh_enq_id' => $enquiryId, 'veh_type' => 1))->row_array();
                              }
                              $data['followup']['foll_cus_id'] = $enquiryId;
                              // $data['followup']['foll_cus_vehicle_id'] = $veh_id;
                              $this->followup->addFollowUp($data['followup']);
                         }
                         $er = $this->db->_error_message();
                         if ($er) {
                              debug($er);
                         }
                         generate_log(array(
                              'log_title' => 'Added new row',
                              'log_desc' => serialize($data),
                              'log_controller' => strtolower(__CLASS__),
                              'log_action' => 'C',
                              'log_ref_id' => $enquiryId,
                              'log_added_by' => get_logged_user('usr_id')
                         ));
                    } else {
                         generate_log(array(
                              'log_title' => 'Error while add new enquiry',
                              'log_desc' => 'Error while add new enquiry',
                              'log_controller' => strtolower(__CLASS__),
                              'log_action' => 'C',
                              'log_added_by' => get_logged_user('usr_id')
                         ));
                    }
               }
               return $enquiryId;
          } else {
               return false;
          }
     }

     function updateEnquiry($data, $valId = 0)
     { //veh_varient
          // debug($data['vehicle']['existing']);
          // debug($data['vehicle']['existing']['veh_varient']);
          //   debug($data['vehicle']['existing']);
          // $noOfSale = isset($data['vehicle']['sale']['veh_brand']) ? count($data['vehicle']['sale']['veh_brand']) : 0;//Required
          // $noOfExisting = isset($data['vehicle']['existing']['veh_brand']) ? count($data['vehicle']['existing']['veh_brand']) : 0;
          // $noOfPitched = isset($data['vehicle']['pitched']['veh_val_id']) ? count($data['vehicle']['pitched']['veh_val_id']) : 0;
          // $noOfBuy = isset($data['vehicle']['buy']['veh_brand']) ? count($data['vehicle']['buy']['veh_brand']) : 0;
          //$data['vehicle']['sale']['veh_id']
          // debug($data['money']['phone']);
          //  debug($data['enquiry']['enq_cus_state']);//enq_cus_dist
          //debug($data['enquiry']['enq_cus_dist']);
          //debug($data['enquiry']['enq_customer_grade']);
          //debug($data['vehicle']['sale']['veh_owner'][0]);
          /* if($this->uid == 42) { debug($data); }; */
          generate_log(array(
               'log_title' => 'Updated enquiry',
               'log_desc' => serialize($data),
               'log_controller' => 'updateEnquiry',
               'log_action' => 'U',
               'log_ref_id' => 11,
               'log_added_by' => $this->uid
          ));
          //Update questions
          /* if (isset($data['questions']) && !empty($data['questions'])) { */

          $enq_cus_status = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $data['enq_id']))->row()->enq_cus_status;

          /* $questions = array();
              if ($enq_cus_status == 1) { // Sale
              $questions = explode(',', $this->db->select('GROUP_CONCAT(qus_id) AS qus_id')
              ->get_where($this->tbl_questions, 'qus_type = 1 OR qus_type = 2')->row()->qus_id);
              } else if ($enq_cus_status == 2) { // Buy
              $questions = explode(',', $this->db->select('GROUP_CONCAT(qus_id) AS qus_id')
              ->get_where($this->tbl_questions, 'qus_type = 1 OR qus_type = 3')->row()->qus_id);
              } else if ($enq_cus_status == 3) { // Exch
              $questions = explode(',', $this->db->select('GROUP_CONCAT(qus_id) AS qus_id')
              ->get_where($this->tbl_questions, 'qus_type = 1 OR qus_type = 4')->row()->qus_id);
              }
              foreach ($data['questions'] as $key => $value) {
              $answer = array_values($value)[0];
              if (in_array($key, $questions) && !empty($answer)) {
              $qstArray = array(
              'enqq_enq_id' => $data['enq_id'],
              'enqq_question_id' => $key,
              'enqq_answer' => $answer
              );
              $this->db->insert($this->tbl_enquiry_questions, $qstArray);
              }
              } */
          $this->db->where('enqq_enq_id', $data['enq_id']);
          $this->db->delete($this->tbl_enquiry_questions);

          if ($enq_cus_status == 1) {
               if (isset($data['saquestions']) && !empty($data['saquestions'])) {
                    foreach ($data['saquestions'] as $key => $value) {
                         /*                          $answer = array_values($value)[0];
                             if (in_array($key, $questions) && !empty($answer)) { */
                         if (!empty($value)) {
                              $qstArray = array(
                                   'enqq_enq_id' => $data['enq_id'],
                                   'enqq_question_id' => $key,
                                   'enqq_answer' => $value
                              );
                              $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                         }
                    }
               }
          } else if ($enq_cus_status == 2) {
               if (isset($data['byquestions']) && !empty($data['byquestions'])) {
                    foreach ($data['byquestions'] as $key => $value) {
                         /*                          $answer = array_values($value)[0]; */
                         /* if (in_array($key, $questions) && !empty($answer)) { */
                         if (!empty($value)) {
                              $qstArray = array(
                                   'enqq_enq_id' => $data['enq_id'],
                                   'enqq_question_id' => $key,
                                   'enqq_answer' => $value
                              );
                              $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                         }
                    }
               }
          }
          if ($enq_cus_status == 3) {
               if (isset($data['exquestions']) && !empty($data['exquestions'])) {
                    foreach ($data['exquestions'] as $key => $value) {
                         /*                           $answer = array_values($value)[0];
                             if (in_array($key, $questions) && !empty($answer)) { */
                         if (!empty($value)) {
                              $qstArray = array(
                                   'enqq_enq_id' => $data['enq_id'],
                                   'enqq_question_id' => $key,
                                   'enqq_answer' => $value
                              );
                              $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                         }
                    }
               }
          }
          /* } */
          //Update questions

          $showroom = get_logged_user('usr_showroom');
          if (!empty($data)) {

               if (isset($data['enquiry']) && !empty($data['enquiry'])) {

                    if (isset($data['enquiry']['other_purpose']) && !empty($data['enquiry']['other_purpose'])) {
                         $this->db->insert($this->tbl_purpose_of_purchase, array('purp_name' => $data['enquiry']['other_purpose'], 'purp_status' => 0, 'purp_addded_by' => $this->uid, 'purp_added_on' => date('Y-m-d H:i:s')));
                         $data['enquiry']['enq_cus_purpose'] = $this->db->insert_id();
                         unset($data['enquiry']['other_purpose']);
                    }
                    /* Occupation */

                    /* City */
                    if (isset($data['enquiry']['enq_cus_city']) && !empty($data['enquiry']['enq_cus_city'])) {
                         $city = $this->db->like('cit_name', $data['enquiry']['enq_cus_city'], 'both')->get($this->tbl_city)->row_array();
                         if (empty($city)) {
                              $this->db->insert($this->tbl_city, array('cit_name' => $data['enquiry']['enq_cus_city']));
                              $data['enquiry']['enq_cus_city'] = $this->db->insert_id();
                         } else {
                              $data['enquiry']['enq_cus_city'] = $city['cit_id'];
                         }
                    } else {
                         $data['enquiry']['enq_cus_city'] = 0;
                    }
                    /* District */
                    /* if (isset($data['enquiry']['enq_cus_dist']) && !empty($data['enquiry']['enq_cus_dist'])) {
                        $dist = $this->db->like('dit_name', $data['enquiry']['enq_cus_dist'], 'both')->get($this->tbl_district)->row_array();
                        if (empty($dist)) {
                        $this->db->insert($this->tbl_district, array('dit_name' => $data['enquiry']['enq_cus_dist']));
                        $data['enquiry']['enq_cus_dist'] = $this->db->insert_id();
                        } else {
                        $data['enquiry']['enq_cus_dist'] = $dist['dit_id'];
                        }
                        } else {
                        $data['enquiry']['enq_cus_dist'] = 0;
                        } */
                    /* State */
                    /* Country */
                    //                      if (isset($data['enquiry']['enq_cus_country']) && !empty($data['enquiry']['enq_cus_country'])) {
                    //                           $country = $this->db->like('cnt_name', $data['enquiry']['enq_cus_country'], 'both')->get($this->tbl_country)->row_array();
                    //                           if (empty($country)) {
                    //                                $this->db->insert($this->tbl_country, array('cnt_name' => $data['enquiry']['enq_cus_country']));
                    //                                $data['enquiry']['enq_cus_country'] = $this->db->insert_id();
                    //                           } else {
                    //                                $data['enquiry']['enq_cus_country'] = $country['cnt_id'];
                    //                           }
                    //                      } else {
                    //                           $data['enquiry']['enq_cus_country'] = 0;
                    //                      }

                    $data['enquiry']['enq_cus_test_drive'] = isset($data['enquiry']['enq_cus_test_drive']) ? $data['enquiry']['enq_cus_test_drive'] : 0;

                    if (isset($data['enquiry']['enq_entry_date']) && !empty($data['enquiry']['enq_entry_date'])) {
                         $data['enquiry']['enq_entry_date'] = date('Y-m-d', strtotime($data['enquiry']['enq_entry_date']));
                    }
                    if (isset($data['enquiry']['enq_se_id']) && !empty($data['enquiry']['enq_se_id'])) {
                         $presentEnq = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $data['enq_id']))->row_array();
                         if ((isset($presentEnq['enq_se_id']) && !empty($presentEnq['enq_se_id'])) &&
                              ($presentEnq['enq_se_id'] != $data['enquiry']['enq_se_id'])
                         ) {
                              generate_log(array(
                                   'log_title' => 'Changed sales executive for enquiry',
                                   'log_desc' => $presentEnq['enq_se_id'] . '-' . $data['enquiry']['enq_se_id'],
                                   'log_controller' => 'change_exe_enquiry',
                                   'log_action' => 'U',
                                   'log_ref_id' => $data['enq_id'],
                                   'log_added_by' => $this->uid
                              ));
                         }
                    }
                    ///

                    $data['enquiry']['enq_money_name'] = isset($data['money']['name']) ? $data['money']['name'] : '';
                    $data['enquiry']['enq_money_phone'] = isset($data['money']['phone']) ? $data['money']['phone'] : '';
                    $data['enquiry']['enq_money_relation'] = isset($data['money']['relation']) ? $data['money']['relation'] : '';
                    $data['enquiry']['enq_money_remarks'] = isset($data['money']['remarks']) ? $data['money']['remarks'] : '';
                    $data['enquiry']['enq_need_name'] = isset($data['need']['name']) ? $data['need']['name'] : '';
                    $data['enquiry']['enq_need_phone'] = isset($data['need']['phone']) ? $data['need']['phone'] : '';
                    $data['enquiry']['enq_need_relation'] = isset($data['need']['relation']) ? $data['need']['relation'] : '';
                    $data['enquiry']['enq_need_remarks'] = isset($data['need']['remarks']) ? $data['need']['remarks'] : '';
                    $data['enquiry']['enq_authority_name'] = isset($data['authority']['name']) ? $data['authority']['name'] : '';
                    $data['enquiry']['enq_authority_phone'] = isset($data['authority']['phone']) ? $data['authority']['phone'] : '';
                    $data['enquiry']['enq_authority_relation'] = isset($data['authority']['relation']) ? $data['authority']['relation'] : '';
                    $data['enquiry']['enq_authority_remarks'] = isset($data['authority']['remarks']) ? $data['authority']['remarks'] : '';


                    //  debug($data['enquiry']);
                    //@
                    $this->updateEnquiryLastView($data['enq_id']);

                    /* Enquiry history */
                    $seId = isset($data['enquiry']['enq_se_id']) ? $data['enquiry']['enq_se_id'] : $this->uid;
                    $mod = isset($data['enquiry']['enq_mode_enq']) ? $data['enquiry']['enq_mode_enq'] : 0;
                    $enqH['enh_remarks'] = 'Enquiry updated';
                    $enqH['enh_added_by'] = $this->uid;
                    $enqH['enh_added_on'] = date('Y-m-d H:i:s');
                    $enqH['enh_enq_id'] = $data['enq_id'];
                    $enqH['enh_status'] = 1;
                    $enqH['enh_current_sales_executive'] = $seId;
                    $enqH['enh_contact_mod'] = $mod;
                    $this->db->insert($this->tbl_enquiry_history, $enqH);
                    $data['enquiry']['enq_current_status_history'] = $this->db->insert_id();
                    /* Enquiry history*/


                    $this->db->where('enq_id', $data['enq_id']);
                    if ($this->db->update($this->tbl_enquiry, $data['enquiry'])) {

                         $noOfSale = isset($data['vehicle']['sale']['veh_brand']) ? count($data['vehicle']['sale']['veh_brand']) : 0; //Required
                         $noOfExisting = isset($data['vehicle']['existing']['veh_brand']) ? count($data['vehicle']['existing']['veh_brand']) : 0;
                         $noOfPitched = isset($data['vehicle']['pitched']['veh_val_id']) ? count($data['vehicle']['pitched']['veh_val_id']) : 0;
                         $noOfBuy = isset($data['vehicle']['buy']['veh_brand']) ? count($data['vehicle']['buy']['veh_brand']) : 0;
                         //$data['vehicle']['sale']['veh_id']
                         //debug($noOfPitched);
                         // exit;

                         for ($i = 0; $i < $noOfSale; $i++) {
                              $req['veh_enq_id'] = $data['enq_id'];
                              $req['veh_status'] = 1;
                              $req['veh_brand'] = isset($data['vehicle']['sale']['veh_brand'][$i]) ? $data['vehicle']['sale']['veh_brand'][$i] : 0;
                              $req['veh_model'] = isset($data['vehicle']['sale']['veh_model'][$i]) ? $data['vehicle']['sale']['veh_model'][$i] : 0;
                              $req['veh_varient'] = isset($data['vehicle']['sale']['veh_varient'][$i]) ? $data['vehicle']['sale']['veh_varient'][$i] : 0;
                              $req['veh_fuel'] = $data['vehicle']['sale']['veh_fuel'][$i];
                              $req['veh_color'] = $data['vehicle']['sale']['veh_color'][$i];
                              $req['veh_exptd_date_purchase'] = $data['vehicle']['sale']['veh_exptd_date_purchase'][$i];
                              $req['veh_price_id'] = empty($data['vehicle']['sale']['veh_price_id'][$i]) ? 0 : $data['vehicle']['sale']['veh_price_id'][$i];
                              $req['veh_prefer_no'] = $data['vehicle']['sale']['veh_prefer_number'][$i];
                              $req['veh_year'] = empty($data['vehicle']['sale']['veh_year'][$i]) ? 0 : $data['vehicle']['sale']['veh_year'][$i];
                              $req['veh_km_id'] = empty($data['vehicle']['sale']['veh_km_id'][$i]) ? 0 : $data['vehicle']['sale']['veh_km_id'][$i];
                              $req['veh_remarks'] = empty($data['vehicle']['sale']['veh_remarks'][$i]) ? 0 : $data['vehicle']['sale']['veh_remarks'][$i];
                              $req['veh_manf_year_from'] = empty($data['vehicle']['sale']['veh_manf_year_from'][$i]) ? 0 : $data['vehicle']['sale']['veh_manf_year_from'][$i];
                              $req['veh_manf_year_to'] = empty($data['vehicle']['sale']['veh_manf_year_to'][$i]) ? 0 : $data['vehicle']['sale']['veh_manf_year_to'][$i];
                              $req['veh_type'] = 1; //required
                              $req['veh_added_by'] = $this->uid;
                              if (!empty($showroom)) {
                                   $sale['veh_showroom_id'] = $showroom;
                              }
                              if (isset($data['vehicle']['sale']['veh_id'][$i]) && !empty($data['vehicle']['sale']['veh_id'][$i])) {
                                   $this->db->where('veh_id', $data['vehicle']['sale']['veh_id'][$i]);
                                   $this->db->update($this->tbl_vehicle, $req);
                              } else {
                                   $this->db->insert($this->tbl_vehicle, $req);
                              }
                         } //@sale
                         for ($i = 0; $i < $noOfExisting; $i++) {
                              $existing['veh_enq_id'] = $data['enq_id'];
                              $existing['veh_status'] = 1;
                              $existing['veh_brand'] = isset($data['vehicle']['existing']['veh_brand'][$i]) ? $data['vehicle']['existing']['veh_brand'][$i] : 0;
                              $existing['veh_model'] = isset($data['vehicle']['existing']['veh_model'][$i]) ? $data['vehicle']['existing']['veh_model'][$i] : 0;
                              $existing['veh_varient'] = isset($data['vehicle']['existing']['veh_varient'][$i]) ? $data['vehicle']['existing']['veh_varient'][$i] : 0;
                              $existing['veh_fuel'] = $data['vehicle']['existing']['veh_fuel'][$i];
                              $existing['veh_color'] = $data['vehicle']['existing']['veh_color'][$i];
                              $existing['veh_km_from'] = empty($data['vehicle']['existing']['veh_km_from'][$i]) ? 0 : $data['vehicle']['existing']['veh_km_from'][$i];
                              $existing['veh_exchange_intrested'] = empty($data['vehicle']['existing']['exchange_intrested'][$i]) ? 0 : $data['vehicle']['existing']['exchange_intrested'][$i];
                              $existing['veh_exch_dealer_value'] = empty($data['vehicle']['existing']['market_value'][$i]) ? 0 : $data['vehicle']['existing']['market_value'][$i];
                              $existing['veh_exch_estimate'] = empty($data['vehicle']['existing']['our_offer'][$i]) ? 0 : $data['vehicle']['existing']['our_offer'][$i];
                              $existing['veh_exch_cus_expect'] = empty($data['vehicle']['existing']['veh_exch_cus_expect'][$i]) ? 0 : $data['vehicle']['existing']['veh_exch_cus_expect'][$i]; //db Customer expectation
                              $existing['veh_insurance_validity'] = $data['vehicle']['existing']['insurance_validity'][$i];
                              $existing['veh_tyre_condition'] = $data['vehicle']['existing']['tyre_condition'][$i];
                              $existing['veh_remarks'] = $data['vehicle']['existing']['veh_remarks'][$i];
                              $existing['veh_manf_year'] = empty($data['vehicle']['existing']['veh_manf_year'][$i]) ? 0 : $data['vehicle']['existing']['veh_manf_year'][$i];
                              $existing['veh_reg'] = $data['vehicle']['existing']['veh_reg1'][$i] . '-' . $data['vehicle']['existing']['veh_reg2'][$i] . '-' . $data['vehicle']['existing']['veh_reg3'][$i] . '-' . $data['vehicle']['existing']['veh_reg4'][$i];
                              $existing['veh_owner'] = empty($data['vehicle']['existing']['veh_owner'][$i]) ? 0 : $data['vehicle']['existing']['veh_owner'][$i];
                              $existing['veh_type'] = 2; //Existing
                              $existing['veh_added_by'] = $this->uid;
                              if (!empty($showroom)) {
                                   $sale['veh_showroom_id'] = $showroom;
                              }
                              if (isset($data['vehicle']['existing']['veh_id'][$i]) && !empty($data['vehicle']['existing']['veh_id'][$i])) {
                                   $this->db->where('veh_id', $data['vehicle']['existing']['veh_id'][$i]);
                                   $this->db->update($this->tbl_vehicle, $existing);
                              } else {
                                   $this->db->insert($this->tbl_vehicle, $existing);
                              }
                         } //@existing

                         for ($i = 0; $i < $noOfPitched; $i++) {
                              $pitched['veh_enq_id'] = $data['enq_id'];
                              $pitched['veh_status'] = 1;
                              $pitched['veh_stock_id'] = @$data['vehicle']['pitched']['veh_val_id'][$i];
                              $pitched['veh_exch_cus_expect'] = empty($data['vehicle']['pitched']['veh_customer_offer'][$i]) ? 0 : $data['vehicle']['pitched']['veh_customer_offer'][$i];
                              $pitched['veh_remarks'] = @$data['vehicle']['pitched']['veh_remarks'][$i];
                              $pitched['veh_tl_remarks'] = @$data['vehicle']['pitched']['veh_tl_remarks'][$i];
                              $pitched['veh_sm_remarks'] = @$data['vehicle']['pitched']['veh_sm_remarks'][$i];
                              $pitched['veh_gm_remarks'] = @$data['vehicle']['pitched']['veh_gm_remarks'][$i];
                              $pitched['veh_type'] = 3;
                              $pitched['veh_added_by'] = $this->uid;
                              if (!empty($showroom)) {
                                   $sale['veh_showroom_id'] = $showroom;
                              }
                              if (isset($data['vehicle']['pitched']['veh_id'][$i]) && !empty($data['vehicle']['pitched']['veh_id'][$i])) {
                                   $this->db->where('veh_id', $data['vehicle']['pitched']['veh_id'][$i]);
                                   $this->db->update($this->tbl_vehicle, $pitched);
                              } else {
                                   $this->db->insert($this->tbl_vehicle, $pitched);
                              }
                         } //@pitched

                         for ($i = 0; $i < $noOfBuy; $i++) {
                              $buy['veh_enq_id'] = $data['enq_id'];
                              $buy['veh_status'] = 2;
                              $buy['veh_brand'] = isset($data['vehicle']['buy']['veh_brand'][$i]) ? $data['vehicle']['buy']['veh_brand'][$i] : 0;
                              $buy['veh_model'] = isset($data['vehicle']['buy']['veh_model'][$i]) ? $data['vehicle']['buy']['veh_model'][$i] : 0;
                              $buy['veh_varient'] = isset($data['vehicle']['buy']['veh_varient'][$i]) ? $data['vehicle']['buy']['veh_varient'][$i] : 0;
                              $buy['veh_fuel'] = $data['vehicle']['buy']['veh_fuel'][$i];
                              $buy['veh_year'] = empty($data['vehicle']['buy']['veh_year'][$i]) ? 0 : $data['vehicle']['buy']['veh_year'][$i];
                              $buy['veh_color'] = $data['vehicle']['buy']['veh_color'][$i];
                              // $buy['veh_price_from'] = empty($data['vehicle']['buy']['veh_price_from'][$i]) ? 0 : $data['vehicle']['buy']['veh_price_from'][$i];
                              // $buy['veh_price_to'] = empty($data['vehicle']['buy']['veh_price_to'][$i]) ? 0 : $data['vehicle']['buy']['veh_price_to'][$i];
                              $buy['veh_price_id'] = empty($data['vehicle']['buy']['veh_price_id'][$i]) ? 0 : $data['vehicle']['buy']['veh_price_id'][$i];
                              $buy['veh_km_from'] = empty($data['vehicle']['buy']['veh_km_from'][$i]) ? 0 : $data['vehicle']['buy']['veh_km_from'][$i];
                              //  $buy['veh_km_from'] = empty($data['vehicle']['buy']['veh_km_from'][$i]) ? 0 : $data['vehicle']['buy']['veh_km_from'][$i];
                              // $buy['veh_km_to'] = empty($data['vehicle']['buy']['veh_km_to'][$i]) ? 0 : $data['vehicle']['buy']['veh_km_to'][$i];
                              $buy['veh_reg'] = $data['vehicle']['buy']['veh_reg1'][$i] . '-' . $data['vehicle']['buy']['veh_reg2'][$i] . '-' . $data['vehicle']['buy']['veh_reg3'][$i] . '-' . $data['vehicle']['buy']['veh_reg4'][$i];
                              $buy['veh_owner'] = empty($data['vehicle']['buy']['veh_owner'][$i]) ? 0 : $data['vehicle']['buy']['veh_owner'][$i];
                              $buy['veh_remarks'] = $data['vehicle']['buy']['veh_remarks'][$i];
                              $buy['veh_exch_cus_expect'] = empty($data['vehicle']['buy']['veh_exch_cus_expect'][$i]) ? 0 : $data['vehicle']['buy']['veh_exch_cus_expect'][$i];
                              $buy['veh_exch_estimate'] = empty($data['vehicle']['buy']['veh_exch_estimate'][$i]) ? 0 : $data['vehicle']['buy']['veh_exch_estimate'][$i];
                              $buy['veh_exch_dealer_value'] = empty($data['vehicle']['buy']['veh_exch_dealer_value'][$i]) ? 0 : $data['vehicle']['buy']['veh_exch_dealer_value'][$i];
                              $buy['veh_exch_dealer_value'] = empty($data['vehicle']['buy']['veh_exch_dealer_value'][$i]) ? 0 : $data['vehicle']['buy']['veh_exch_dealer_value'][$i];
                              $buy['veh_chassis_number'] = isset($data['vehicle']['buy']['veh_chassis_number'][$i]) ? $data['vehicle']['buy']['veh_chassis_number'][$i] : 0;
                              $buy['veh_added_by'] = $this->uid;
                              $buy['veh_first_reg'] = !empty($data['vehicle']['buy']['veh_first_reg'][$i]) ? date('Y-m-d', strtotime($data['vehicle']['buy']['veh_first_reg'][$i])) : 0;
                              $buy['veh_delivery_date'] = !empty($data['vehicle']['buy']['veh_delivery_date'][$i]) ? date('Y-m-d', strtotime($data['vehicle']['buy']['veh_delivery_date'][$i])) : 0;
                              $buy['veh_manf_year'] = !empty($data['vehicle']['buy']['veh_manf_year'][$i]) ? $data['vehicle']['buy']['veh_manf_year'][$i] : 0;
                              $buy['veh_ac'] = !empty($data['vehicle']['buy']['veh_ac'][$i]) ? $data['vehicle']['buy']['veh_ac'][$i] : 0;
                              $buy['veh_ac_zone'] = !empty($data['vehicle']['buy']['veh_ac_zone'][$i]) ? $data['vehicle']['buy']['veh_ac_zone'][$i] : 0;
                              $buy['veh_cc'] = !empty($data['vehicle']['buy']['veh_cc'][$i]) ? $data['vehicle']['buy']['veh_cc'][$i] : 0;
                              $buy['veh_vehicle_type'] = !empty($data['vehicle']['buy']['veh_vehicle_type'][$i]) ? $data['vehicle']['buy']['veh_vehicle_type'][$i] : 0;
                              $buy['veh_engine_num'] = !empty($data['vehicle']['buy']['veh_engine_num'][$i]) ? $data['vehicle']['buy']['veh_engine_num'][$i] : 0;
                              $buy['veh_transmission'] = !empty($data['vehicle']['buy']['veh_transmission'][$i]) ? $data['vehicle']['buy']['veh_transmission'][$i] : 0;
                              $buy['veh_seat_no'] = !empty($data['vehicle']['buy']['veh_seat_no'][$i]) ? $data['vehicle']['buy']['veh_seat_no'][$i] : 0;
                              if (!empty($showroom)) {
                                   $buy['veh_showroom_id'] = $showroom;
                              }
                              if (isset($data['vehicle']['buy']['veh_id'][$i]) && !empty($data['vehicle']['buy']['veh_id'][$i])) {
                                   $this->db->where('veh_id', $data['vehicle']['buy']['veh_id'][$i]);
                                   $this->db->update($this->tbl_vehicle, $buy);
                              } else {
                                   $this->db->insert($this->tbl_vehicle, $buy);
                              }
                         }
                         generate_log(array(
                              'log_title' => 'Updated enquiry',
                              'log_desc' => 'Updated enquiry',
                              'log_controller' => strtolower(__CLASS__),
                              'log_action' => 'U',
                              'log_ref_id' => $data['enq_id'],
                              'log_added_by' => get_logged_user('usr_id')
                         ));
                    } else {
                         generate_log(array(
                              'log_title' => 'Error while updated enquiry',
                              'log_desc' => 'Error while updated enquiry',
                              'log_controller' => strtolower(__CLASS__),
                              'log_action' => 'U',
                              'log_ref_id' => $data['enq_id'],
                              'log_added_by' => get_logged_user('usr_id')
                         ));
                    }
               }

               return true;
          } else {
               return false;
          }
     }

     function updateEnqAndChangeVeh($data)
     {
          //debug($data['enq_cus_status_old']);
          //exit;
          //           $this->storeReqVeh($data);
          //           exit;
          // $ju = isset($data['enquiry']['enq_cus_loan_amount']) ? count($data['enquiry']['enq_cus_loan_amount']) : 0; //Required
          // debug($ju,1);

          /* if($this->uid == 42) { debug($data); }; */
          generate_log(array(
               'log_title' => 'Updated enquiry',
               'log_desc' => serialize($data),
               'log_controller' => 'updateEnquiry',
               'log_action' => 'U',
               'log_ref_id' => 11,
               'log_added_by' => $this->uid
          ));
          //Update questions
          /* if (isset($data['questions']) && !empty($data['questions'])) { */

          $enq_cus_status = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $data['enq_id']))->row()->enq_cus_status;

          /* $questions = array();
              if ($enq_cus_status == 1) { // Sale
              $questions = explode(',', $this->db->select('GROUP_CONCAT(qus_id) AS qus_id')
              ->get_where($this->tbl_questions, 'qus_type = 1 OR qus_type = 2')->row()->qus_id);
              } else if ($enq_cus_status == 2) { // Buy
              $questions = explode(',', $this->db->select('GROUP_CONCAT(qus_id) AS qus_id')
              ->get_where($this->tbl_questions, 'qus_type = 1 OR qus_type = 3')->row()->qus_id);
              } else if ($enq_cus_status == 3) { // Exch
              $questions = explode(',', $this->db->select('GROUP_CONCAT(qus_id) AS qus_id')
              ->get_where($this->tbl_questions, 'qus_type = 1 OR qus_type = 4')->row()->qus_id);
              }
              foreach ($data['questions'] as $key => $value) {
              $answer = array_values($value)[0];
              if (in_array($key, $questions) && !empty($answer)) {
              $qstArray = array(
              'enqq_enq_id' => $data['enq_id'],
              'enqq_question_id' => $key,
              'enqq_answer' => $answer
              );
              $this->db->insert($this->tbl_enquiry_questions, $qstArray);
              }
              } */
          $this->db->where('enqq_enq_id', $data['enq_id']);
          $this->db->delete($this->tbl_enquiry_questions);

          if ($enq_cus_status == 1) {
               if (isset($data['saquestions']) && !empty($data['saquestions'])) {
                    foreach ($data['saquestions'] as $key => $value) {
                         /*                          $answer = array_values($value)[0];
                             if (in_array($key, $questions) && !empty($answer)) { */
                         if (!empty($value)) {
                              $qstArray = array(
                                   'enqq_enq_id' => $data['enq_id'],
                                   'enqq_question_id' => $key,
                                   'enqq_answer' => $value
                              );
                              $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                         }
                    }
               }
          } else if ($enq_cus_status == 2) {
               if (isset($data['byquestions']) && !empty($data['byquestions'])) {
                    foreach ($data['byquestions'] as $key => $value) {
                         /*                          $answer = array_values($value)[0]; */
                         /* if (in_array($key, $questions) && !empty($answer)) { */
                         if (!empty($value)) {
                              $qstArray = array(
                                   'enqq_enq_id' => $data['enq_id'],
                                   'enqq_question_id' => $key,
                                   'enqq_answer' => $value
                              );
                              $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                         }
                    }
               }
          }
          if ($enq_cus_status == 3) {
               if (isset($data['exquestions']) && !empty($data['exquestions'])) {
                    foreach ($data['exquestions'] as $key => $value) {
                         /*                           $answer = array_values($value)[0];
                             if (in_array($key, $questions) && !empty($answer)) { */
                         if (!empty($value)) {
                              $qstArray = array(
                                   'enqq_enq_id' => $data['enq_id'],
                                   'enqq_question_id' => $key,
                                   'enqq_answer' => $value
                              );
                              $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                         }
                    }
               }
          }
          /* } */
          //Update questions

          $showroom = get_logged_user('usr_showroom');
          if (!empty($data)) {
               if (isset($data['enquiry']) && !empty($data['enquiry'])) {

                    if (isset($data['enquiry']['other_purpose']) && !empty($data['enquiry']['other_purpose'])) {
                         $this->db->insert($this->tbl_purpose_of_purchase, array('purp_name' => $data['enquiry']['other_purpose'], 'purp_status' => 0, 'purp_addded_by' => $this->uid, 'purp_added_on' => date('Y-m-d H:i:s')));
                         $data['enquiry']['enq_cus_purpose'] = $this->db->insert_id();
                    }
                    unset($data['enquiry']['other_purpose']);
                    /* Occupation */

                    /* City */
                    if (isset($data['enquiry']['enq_cus_city']) && !empty($data['enquiry']['enq_cus_city'])) {
                         $city = $this->db->like('cit_name', $data['enquiry']['enq_cus_city'], 'both')->get($this->tbl_city)->row_array();
                         if (empty($city)) {
                              $this->db->insert($this->tbl_city, array('cit_name' => $data['enquiry']['enq_cus_city']));
                              $data['enquiry']['enq_cus_city'] = $this->db->insert_id();
                         } else {
                              $data['enquiry']['enq_cus_city'] = $city['cit_id'];
                         }
                    } else {
                         $data['enquiry']['enq_cus_city'] = 0;
                    }
                    /* District */
                    /* if (isset($data['enquiry']['enq_cus_dist']) && !empty($data['enquiry']['enq_cus_dist'])) {
                        $dist = $this->db->like('dit_name', $data['enquiry']['enq_cus_dist'], 'both')->get($this->tbl_district)->row_array();
                        if (empty($dist)) {
                        $this->db->insert($this->tbl_district, array('dit_name' => $data['enquiry']['enq_cus_dist']));
                        $data['enquiry']['enq_cus_dist'] = $this->db->insert_id();
                        } else {
                        $data['enquiry']['enq_cus_dist'] = $dist['dit_id'];
                        }
                        } else {
                        $data['enquiry']['enq_cus_dist'] = 0;
                        } */
                    /* State */
                    /* Country */
                    //                      if (isset($data['enquiry']['enq_cus_country']) && !empty($data['enquiry']['enq_cus_country'])) {
                    //                           $country = $this->db->like('cnt_name', $data['enquiry']['enq_cus_country'], 'both')->get($this->tbl_country)->row_array();
                    //                           if (empty($country)) {
                    //                                $this->db->insert($this->tbl_country, array('cnt_name' => $data['enquiry']['enq_cus_country']));
                    //                                $data['enquiry']['enq_cus_country'] = $this->db->insert_id();
                    //                           } else {
                    //                                $data['enquiry']['enq_cus_country'] = $country['cnt_id'];
                    //                           }
                    //                      } else {
                    //                           $data['enquiry']['enq_cus_country'] = 0;
                    //                      }

                    $data['enquiry']['enq_cus_test_drive'] = isset($data['enquiry']['enq_cus_test_drive']) ? $data['enquiry']['enq_cus_test_drive'] : 0;

                    if (isset($data['enquiry']['enq_entry_date']) && !empty($data['enquiry']['enq_entry_date'])) {
                         $data['enquiry']['enq_entry_date'] = date('Y-m-d', strtotime($data['enquiry']['enq_entry_date']));
                    }
                    if (isset($data['enquiry']['enq_se_id']) && !empty($data['enquiry']['enq_se_id'])) {
                         $presentEnq = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $data['enq_id']))->row_array();
                         if ((isset($presentEnq['enq_se_id']) && !empty($presentEnq['enq_se_id'])) &&
                              ($presentEnq['enq_se_id'] != $data['enquiry']['enq_se_id'])
                         ) {
                              generate_log(array(
                                   'log_title' => 'Changed sales executive for enquiry',
                                   'log_desc' => $presentEnq['enq_se_id'] . '-' . $data['enquiry']['enq_se_id'],
                                   'log_controller' => 'change_exe_enquiry',
                                   'log_action' => 'U',
                                   'log_ref_id' => $data['enq_id'],
                                   'log_added_by' => $this->uid
                              ));
                         }
                    }
                    ///


                    $data['enquiry']['enq_cus_status'] = $data['enquiry']['enq_cus_status'];
                    $data['enquiry']['enq_money_name'] = isset($data['money']['name']) ? $data['money']['name'] : '';
                    $data['enquiry']['enq_money_phone'] = isset($data['money']['phone']) ? $data['money']['phone'] : '';
                    $data['enquiry']['enq_money_relation'] = isset($data['money']['relation']) ? $data['money']['relation'] : '';
                    $data['enquiry']['enq_money_remarks'] = isset($data['money']['remarks']) ? $data['money']['remarks'] : '';
                    $data['enquiry']['enq_need_name'] = isset($data['need']['name']) ? $data['need']['name'] : '';
                    $data['enquiry']['enq_need_phone'] = isset($data['need']['phone']) ? $data['need']['phone'] : '';
                    $data['enquiry']['enq_need_relation'] = isset($data['need']['relation']) ? $data['need']['relation'] : '';
                    $data['enquiry']['enq_need_remarks'] = isset($data['need']['remarks']) ? $data['need']['remarks'] : '';
                    $data['enquiry']['enq_authority_name'] = isset($data['authority']['name']) ? $data['authority']['name'] : '';
                    $data['enquiry']['enq_authority_phone'] = isset($data['authority']['phone']) ? $data['authority']['phone'] : '';
                    $data['enquiry']['enq_authority_relation'] = isset($data['authority']['relation']) ? $data['authority']['relation'] : '';
                    $data['enquiry']['enq_authority_remarks'] = isset($data['authority']['remarks']) ? $data['authority']['remarks'] : '';
                    //debug($data['enq_id']);
                    $enquiryId = $data['enq_id'];
                    if ($data['enquiry']['enq_cus_status'] != $data['enq_cus_status_old'] and $data['enquiry']['enq_cus_status'] != 3) {
                         //follo
                         //debug('changed');
                         $this->db->where('veh_enq_id', $data['enq_id']);
                         $this->db->where('veh_type', $data['enq_id']);
                         $this->db->where($this->tbl_vehicle . '.veh_type != 2');
                         $this->db->update($this->tbl_vehicle, ['veh_enq_type_old' => $data['enq_cus_status_old']]); //
                         $new_type = $data['enquiry']['enq_cus_status'] == 1 ? 'Sales Enq' : 'Purchase Enq';
                         $old_type = $data['enq_cus_status_old'] == 1 ? 'Sales Enq' : 'Purchase Enq';
                         $followup_comment = 'Changed ' . $old_type . ' to' . ' ' . $new_type;
                         $foll_data = ['foll_remarks' => $followup_comment, 'foll_cus_id' => $data['enq_id'], 'foll_parent' => 0];

                         $this->followup->updateComments($foll_data);
                    }


                    //  debug($data['enquiry']);
                    //@
                    $this->updateEnquiryLastView($data['enq_id']);

                    /* Enquiry history */
                    $seId = isset($data['enquiry']['enq_se_id']) ? $data['enquiry']['enq_se_id'] : $this->uid;
                    $mod = isset($data['enquiry']['enq_mode_enq']) ? $data['enquiry']['enq_mode_enq'] : 0;
                    $enqH['enh_remarks'] = 'Enquiry updated';
                    $enqH['enh_added_by'] = $this->uid;
                    $enqH['enh_added_on'] = date('Y-m-d H:i:s');
                    $enqH['enh_enq_id'] = $data['enq_id'];
                    $enqH['enh_status'] = 1;
                    $enqH['enh_current_sales_executive'] = $seId;
                    $enqH['enh_contact_mod'] = $mod;
                    $this->db->insert($this->tbl_enquiry_history, $enqH);
                    $data['enquiry']['enq_current_status_history'] = $this->db->insert_id();
                    /* Enquiry history*/

                    $this->db->where('enq_id', $data['enq_id']);
                    if ($this->db->update($this->tbl_enquiry, $data['enquiry'])) {

                         $noOfSale = isset($data['vehicle']['sale']['veh_brand']) ? count($data['vehicle']['sale']['veh_brand']) : 0; //Required
                         $noOfExisting = isset($data['vehicle']['existing']['veh_brand']) ? count($data['vehicle']['existing']['veh_brand']) : 0;
                         $noOfPitched = isset($data['vehicle']['pitched']['veh_val_id']) ? count($data['vehicle']['pitched']['veh_val_id']) : 0;
                         $noOfBuy = isset($data['vehicle']['buy']['veh_brand']) ? count($data['vehicle']['buy']['veh_brand']) : 0;
                         //$data['vehicle']['sale']['veh_id']
                         //debug($noOfPitched);
                         // exit;
                         if ($data['enquiry']['enq_cus_status'] == 1 || $data['enquiry']['enq_cus_status'] == 3) { //sales or exchange
                              $noOfSale = isset($data['vehicle']['sale']['veh_brand']) ? count($data['vehicle']['sale']['veh_brand']) : 0; //required
                              if ($noOfSale > 0) {

                                   $this->storeReqVeh($data['vehicle']['sale'], $noOfSale, $enquiryId); //req

                              }

                              $noOfPitched = isset($data['vehicle']['pitched']['veh_val_id']) ? count($data['vehicle']['pitched']['veh_val_id']) : 0;

                              if ($noOfPitched > 0) {
                                   $this->storePitchedVeh($data['vehicle']['pitched'], $noOfPitched, $enquiryId);
                                   $this->updatePitchedvehMeta($data['vehicle']['pitched'], $noOfPitched, $enquiryId);
                              } elseif ($noOfSale > 0) {

                                   $this->updateSalesVehicleMeta($data['vehicle']['sale'], $noOfSale, $enquiryId);
                              }
                         }

                         /* Existing veh */
                         $noOfExisting = isset($data['vehicle']['existing']['veh_brand']) ? count($data['vehicle']['existing']['veh_brand']) : 0;
                         if ($noOfExisting > 0) {
                              $this->storeExistingVeh($data['vehicle']['existing'], $noOfExisting, $enquiryId);
                         }
                         /* @Existing veh */
                         if ($noOfBuy > 0) {
                              $this->storePurchaseVeh($data['vehicle']['buy'], $noOfBuy, $enquiryId, $data['enquiry']);
                              $this->updatePurchaseVehicleMeta($data['vehicle']['buy'], $noOfBuy, $enquiryId, $data['enquiry']);
                         }

                         // debug($buy['veh_delivery_state']);
                         generate_log(array(
                              'log_title' => 'Updated enquiry',
                              'log_desc' => 'Updated enquiry',
                              'log_controller' => strtolower(__CLASS__),
                              'log_action' => 'U',
                              'log_ref_id' => $data['enq_id'],
                              'log_added_by' => get_logged_user('usr_id')
                         ));
                    } else {
                         generate_log(array(
                              'log_title' => 'Error while updated enquiry',
                              'log_desc' => 'Error while updated enquiry',
                              'log_controller' => strtolower(__CLASS__),
                              'log_action' => 'U',
                              'log_ref_id' => $data['enq_id'],
                              'log_added_by' => get_logged_user('usr_id')
                         ));
                    }
               }

               return true;
          } else {
               return false;
          }
     }

     public function getBrands($id = '')
     {

          $this->db->select("branda.*, brandb.brd_title AS parent")
               ->from($this->tbl_brand . ' branda')
               ->join($this->tbl_brand . ' brandb', 'branda.brd_parent = brandb.brd_id', 'left');

          if (!empty($id)) {
               $this->db->where('branda.brd_id', $id);
          }
          $this->db->order_by('branda.brd_title', 'asc');
          $brands = $this->db->get()->result_array();
          // debug($brands,1);
          return $brands;
     }

     function getModel($id = '')
     {
          if (!empty($id)) {
               $this->db->where($this->tbl_model . '.mod_id', $id);
               return $this->db->select($this->tbl_model . '.*,' . $this->tbl_brand . '.*')->from($this->tbl_model, false)
                    ->join($this->tbl_brand, $this->tbl_model . '.mod_brand = ' . $this->tbl_brand . '.brd_id', 'left')
                    ->get()->row_array();
          } else {
               return $this->db->select($this->tbl_model . '.*,' . $this->tbl_brand . '.*')->from($this->tbl_model, false)
                    ->join($this->tbl_brand, $this->tbl_model . '.mod_brand = ' . $this->tbl_brand . '.brd_id', 'left')
                    ->get()->result_array();
          }
     }

     function getVariant($id = '')
     {
          if (!empty($id)) {
               $this->db->where($this->tbl_variant . '.var_id', $id);
               return $this->db->select($this->tbl_variant . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*')->from($this->tbl_variant)
                    ->join($this->tbl_model, $this->tbl_variant . '.var_model_id = ' . $this->tbl_model . '.mod_id', 'left')
                    ->join($this->tbl_brand, $this->tbl_variant . '.var_brand_id = ' . $this->tbl_brand . '.brd_id', 'left')
                    ->get()->row_array();
          } else {
               return $this->db->select($this->tbl_variant . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*')->from($this->tbl_variant)
                    ->join($this->tbl_model, $this->tbl_variant . '.var_model_id = ' . $this->tbl_model . '.mod_id', 'left')
                    ->join($this->tbl_brand, $this->tbl_variant . '.var_brand_id = ' . $this->tbl_brand . '.brd_id', 'left')
                    ->get()->result_array();
          }
     }

     function autoComPlace($qry)
     {
          if (!empty($qry)) {
               $this->db->select('plc_id AS data, plc_name AS value');
               $this->db->like('plc_name', $qry, 'after');
               return $this->db->get($this->tbl_place)->result_array();
          }
     }

     function autoComOccupation($qry)
     {
          if (!empty($qry)) {
               $this->db->select('occ_id AS data, occ_name AS value');
               $this->db->like('occ_name', $qry, 'after');
               return $this->db->get($this->tbl_occupation)->result_array();
          }
     }

     function autoComCountry($qry)
     {
          if (!empty($qry)) {
               $this->db->select('cnt_id AS data, cnt_name AS value');
               $this->db->like('cnt_name', $qry, 'after');
               return $this->db->get($this->tbl_country)->result_array();
          }
     }

     function autoComCity($qry)
     {
          if (!empty($qry)) {
               $this->db->select('cit_id AS data, cit_name AS value');
               $this->db->like('cit_name', $qry, 'after');
               return $this->db->get($this->tbl_city)->result_array();
          }
     }

     function autoComDistrict($qry)
     {
          if (!empty($qry)) {
               $this->db->select('std_id AS data, std_district_name AS value');
               $this->db->like('std_district_name', $qry, 'after');
               return $this->db->get($this->tbl_district)->result_array();
          }
     }

     function autoComState($qry)
     {
          if (!empty($qry)) {
               $this->db->select('stt_id AS data, stt_name AS value');
               $this->db->like('stt_name', $qry, 'after');
               return $this->db->get($this->tbl_state)->result_array();
          }
     }

     function permenentDelete($enqId)
     {
          if (!empty($enqId)) {
               $duplicateEntry = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $enqId))->row_array();
               $duplicateEntry['vehicles'] = $this->db->get_where($this->tbl_vehicle, array('veh_enq_id' => $enqId))->result_array();
               $duplicateEntry['followup'] = $this->db->get_where($this->tbl_followup, array('foll_cus_id' => $enqId))->result_array();

               $this->db->delete($this->tbl_vehicle, array('veh_enq_id' => $enqId));
               $this->db->delete($this->tbl_enquiry, array('enq_id' => $enqId));
               $this->db->delete($this->tbl_followup, array('foll_cus_id' => $enqId));
               $this->db->delete($this->tbl_valuation, array('val_enquiry_id' => $enqId));
               $this->db->delete($this->tbl_enquiry_questions, array('enqq_enq_id' => $enqId));
               $this->db->delete($this->tbl_enquiry_history, array('enh_enq_id' => $enqId));
               $this->db->delete($this->tbl_procurement_rqsts, array('proc_enq_id' => $enqId));
               $this->db->delete($this->tbl_enq_prefrences, array('prf_enq_id' => $enqId));
               $this->db->delete($this->tbl_home_visits, array('hmv_enq_id' => $enqId));

               generate_log(array(
                    'log_title' => 'Delete enquiry',
                    'log_desc' => serialize($duplicateEntry),
                    'log_controller' => 'per-delete-enquiry',
                    'log_action' => 'D',
                    'log_ref_id' => $enqId,
                    'log_added_by' => $this->uid
               ));
               return true;
          } else {
               return false;
          }
     }

     function getModelByBrand($id)
     {
          return $this->db->select($this->tbl_model . '.*, mod_id AS col_id, mod_title AS col_title')
               ->where_in('mod_brand', $id)->order_by('mod_title', 'asc')->get($this->tbl_model)->result_array();
     }

     function getVariantByModel($id)
     {
          return $this->db->select($this->tbl_variant . '.*, var_id AS col_id, var_variant_name AS col_title')
               ->where_in('var_model_id', $id)->order_by('var_variant_name', 'asc')->get($this->tbl_variant)->result_array();
     }

     function removeSaleOrPurchase($id)
     {
          if (!empty($id)) {
               //$this->db->where('veh_id', $id);
               //$this->db->update($this->tbl_vehicle, array('veh_delete' => 1));
               $this->db->where('veh_id', $id);
               $this->db->delete($this->tbl_vehicle);
               generate_log(array(
                    'log_title' => 'Delete one vehicle details',
                    'log_desc' => 'Delete one vehicle details',
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

     function changeStatus($enqId, $status)
     {

          $this->db->where('enq_id', $enqId);
          $this->db->update($this->tbl_enquiry, array('enq_current_status' => $status));

          generate_log(array(
               'log_title' => 'Change status of enquiry',
               'log_desc' => 'Change status of enquiry of ' . $enqId . ' to ' . $status,
               'log_controller' => strtolower(__CLASS__),
               'log_action' => 'U',
               'log_ref_id' => $enqId,
               'log_added_by' => get_logged_user('usr_id')
          ));

          /* Update as punched */
          $this->db->where('vreg_inquiry', $enqId);
          $this->db->update($this->tbl_register_master, array('vreg_is_punched' => 1));
     }
     function getRequestedEnquires($enqId = '', $status = '', $filters = array(), $limit = 0, $page = 0)
     { //cpd frm live
          if (!empty($enqId)) {
               $result = $this->db->select($this->tbl_enquiry . '.enq_number,' . $this->tbl_enquiry . '.enq_id,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' . $this->tbl_enquiry . '.enq_entry_date,' .
                    $this->tbl_enquiry . '.enq_cus_status,' . $this->tbl_enquiry . '.enq_cus_whatsapp,' . $this->tbl_enquiry . '.enq_added_by,' .
                    $this->tbl_enquiry . '.enq_current_status,' . $this->tbl_enquiry . '.enq_mode_enq,' . $this->tbl_statuses . '.*,' . $this->tbl_enquiry . '.enq_se_id,' . $this->tbl_showroom . '.*, ' .
                    $this->tbl_users . '.usr_first_name,' . $this->tbl_users . '.usr_last_name,' . $this->tbl_users . '.usr_id,addedby.usr_first_name AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->join($this->tbl_users . ' addedby', $this->tbl_enquiry . '.enq_added_by = ' . 'addedby.usr_id', 'LEFT')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                    ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_enquiry . '.enq_current_status', 'LEFT')
                    ->where(array($this->tbl_enquiry . '.enq_id' => $enqId))->get($this->tbl_enquiry)->row_array();

               $result['vehicles'] = $this->db->select($this->tbl_vehicle . '.*,' . $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.*,' . $this->tbl_variant . '.*')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    ->where(array('veh_enq_id' => $enqId))->get($this->tbl_vehicle)->result_array();

               $result['history'] = $this->db->select($this->tbl_enquiry_history . '.*,' . $this->tbl_statuses . '.*,addedby.usr_first_name AS enq_added_by_name')
                    ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_enquiry_history . '.enh_status', 'LEFT')
                    ->join($this->tbl_users . ' addedby', $this->tbl_enquiry_history . '.enh_added_by = ' . 'addedby.usr_id', 'LEFT')
                    ->order_by('enh_added_on', 'DESC')->where('enh_enq_id', $enqId)->get($this->tbl_enquiry_history)->result_array();
               return $result;
          }

          $return['count'] = $this->reqQry('count', $status, $filters, $limit, $page);
          $enqIds = $this->reqQry('getIds', $status, $filters, $limit, $page);
          $return['enq_ids'] = serialize($enqIds);
          //echo $data['enq_ids']; exit;
          $return['data'] = $this->reqQry('data', $status, $filters, $limit, $page);
          //   debug($return);

          return $return;
     }
     function reqQry($type = '', $status, $filters = array(), $limit = 0, $page = 0)
     {
          //  getRequestedEnquires
          //Filters
          if (isset($filters['showroom']) && !empty($filters['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $filters['showroom']);
          }
          if (isset($filters['mode']) && !empty($filters['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $filters['mode']);
          }
          if (isset($filters['executive']) && !empty($filters['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $filters['executive']);
          }
          if (isset($filters['enq_date_from']) && !empty($filters['enq_date_from'])) {
               //debug($filters['enq_date_from']);
               $date = date('Y-m-d', strtotime($filters['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $date);
               $this->db->order_by($this->tbl_enquiry_history . '.enh_added_on');
          }
          if (isset($filters['enq_date_to']) && !empty($filters['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($filters['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $date);
          }
          if (isset($filters['status']) && !empty($filters['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $filters['status']);
          }
          //Filters
          if (is_roo_user() || check_permission('enquiry', 'showdroplstluxsmart')) {
          } else if (check_permission('enquiry', 'showdroppedenquiriesmyshowroom')) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          } else if ($this->usr_grp == 'SE' || check_permission('enquiry', 'showdroppedenquiriesonlymy')) {
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
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
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          $whereSearch = '';
          if (!empty($filters['keysearch'])) {
               $whereSearch = '(' . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $filters['keysearch'] . "%' OR " .
                    $this->tbl_enquiry . ".enq_number LIKE '%" . $filters['keysearch'] . "%' OR " .
                    $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $filters['keysearch'] . "%' OR " .
                    $this->tbl_enquiry . ".enq_cus_whatsapp LIKE '%" . $filters['keysearch'] . "%' )";
          }

          if ($type == 'count') {
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               $return = $this->db->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
                    ->where('enq_current_status', $status)->count_all_results($this->tbl_enquiry);
          }
          if ($type == 'getIds') { //
               $return = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_enquiry . '.enq_se_id,')->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
                    ->where('enq_current_status', $status)->get($this->tbl_enquiry)->result_array();
          }
          if ($type == 'data') {
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if ($limit) {
                    $this->db->limit($limit, $page);
               }
               $return = $this->db->select($this->tbl_enquiry . '.enq_number,' . $this->tbl_enquiry . '.enq_current_status,' . $this->tbl_enquiry . '.enq_id,' .
                    $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' .
                    $this->tbl_enquiry . '.enq_mode_enq,' . $this->tbl_enquiry . '.enq_entry_date,' . $this->tbl_enquiry . '.enq_cus_when_buy,' .
                    $this->tbl_enquiry . '.enq_cus_whatsapp,' . $this->tbl_enquiry . '.enq_added_by,' .
                    $this->tbl_enquiry . '.enq_se_id,' . $this->tbl_showroom . '.*, ' . $this->tbl_users . '.usr_first_name,' .
                    $this->tbl_users . '.usr_last_name,' . $this->tbl_users . '.usr_id,addedby.usr_first_name AS enq_added_by_name,' . $this->tbl_enquiry_history . '.*,' .
                    $this->tbl_divisions . '.div_name,' . $this->tbl_district_statewise . '.std_district_name,' . $this->tbl_enquiry . '.enq_home_visit_date,' .
                    $this->tbl_enquiry . '.enq_last_foll_cust_rmk,' . $this->tbl_enquiry . '.enq_sm_rmk,' . $this->tbl_enquiry . '.enq_asm_rmk,' . $this->tbl_enquiry . '.enq_mis_rmk,' .
                    $this->tbl_enquiry . '.enq_added_on, tl.usr_first_name AS tl_usr_first_name, ' . $this->tbl_enquiry . '.enq_cus_status')

                    ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->join($this->tbl_users . ' addedby', $this->tbl_enquiry . '.enq_added_by = ' . 'addedby.usr_id', 'LEFT')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                    ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'LEFT')
                    ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
                    ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'LEFT')
                    ->join($this->tbl_users . ' tl', $this->tbl_users . '.usr_tl = tl.usr_id', 'LEFT')
                    ->where('enq_current_status', $status)->get($this->tbl_enquiry)->result_array();

               //echo $this->db->last_query();
               //exit;
               // debug($return);
          }
          return $return;
     }
     function getRequestedEnquires_old($enqId = '', $status = '', $filters = array())
     {
          if (!empty($enqId)) {
               $result = $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' .
                    $this->tbl_enquiry . '.enq_cus_status,' . $this->tbl_enquiry . '.enq_cus_whatsapp,' . $this->tbl_enquiry . '.enq_added_by,' .
                    $this->tbl_enquiry . '.enq_current_status,' . $this->tbl_statuses . '.*,' . $this->tbl_enquiry . '.enq_se_id,' . $this->tbl_showroom . '.*, ' .
                    $this->tbl_users . '.usr_first_name,' . $this->tbl_users . '.usr_last_name,' . $this->tbl_users . '.usr_id,addedby.usr_first_name AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->join($this->tbl_users . ' addedby', $this->tbl_enquiry . '.enq_added_by = ' . 'addedby.usr_id', 'LEFT')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                    ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_enquiry . '.enq_current_status', 'LEFT')
                    ->where(array($this->tbl_enquiry . '.enq_id' => $enqId))->get($this->tbl_enquiry)->row_array();

               $result['vehicles'] = $this->db->select($this->tbl_vehicle . '.*,' . $this->tbl_vehicle . '.*,' .
                    $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.*,' . $this->tbl_variant . '.*')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    ->where(array('veh_enq_id' => $enqId))->get($this->tbl_vehicle)->result_array();

               $result['history'] = $this->db->select($this->tbl_enquiry_history . '.*,' . $this->tbl_statuses . '.*,addedby.usr_first_name AS enq_added_by_name')
                    ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_enquiry_history . '.enh_status', 'LEFT')
                    ->join($this->tbl_users . ' addedby', $this->tbl_enquiry_history . '.enh_added_by = ' . 'addedby.usr_id', 'LEFT')
                    ->order_by('enh_added_on', 'DESC')->where('enh_enq_id', $enqId)->get($this->tbl_enquiry_history)->result_array();
               return $result;
          }
          //Filters
          if (isset($filters['showroom']) && !empty($filters['showroom'])) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $filters['showroom']);
          }
          if (isset($filters['mode']) && !empty($filters['mode'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_mode_enq', $filters['mode']);
          }
          if (isset($filters['executive']) && !empty($filters['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $filters['executive']);
          }
          if (isset($filters['enq_date_from']) && !empty($filters['enq_date_from'])) {
               $date = date('Y-m-d', strtotime($filters['enq_date_from']));
               $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $date);
               $this->db->order_by($this->tbl_enquiry_history . '.enh_added_on');
          }
          if (isset($filters['enq_date_to']) && !empty($filters['enq_date_to'])) {
               $date = date('Y-m-d', strtotime($filters['enq_date_to']));
               $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $date);
          }
          if (isset($filters['status']) && !empty($filters['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $filters['status']);
          }
          //Filters
          if (is_roo_user()) {
          } else if ($this->usr_grp == 'MG') {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          } else if ($this->usr_grp == 'SE') {
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          $return = $this->db->select($this->tbl_enquiry . '.enq_current_status,' . $this->tbl_enquiry . '.enq_id,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' .
               $this->tbl_enquiry . '.enq_cus_whatsapp,' . $this->tbl_enquiry . '.enq_added_by,' .
               $this->tbl_enquiry . '.enq_se_id,' . $this->tbl_showroom . '.*, ' . $this->tbl_users . '.usr_first_name,' .
               $this->tbl_users . '.usr_last_name,' . $this->tbl_users . '.usr_id,addedby.usr_first_name AS enq_added_by_name,' .
               $this->tbl_enquiry_history . '.*')
               ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_users . ' addedby', $this->tbl_enquiry . '.enq_added_by = ' . 'addedby.usr_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
               ->where('enq_current_status', $status)->get($this->tbl_enquiry)->result_array();
          return $return;
     }

     function getTrackCardDetails($enqId)
     {

          $enq = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_occupation . '.*,' . $this->tbl_city . '.*,'
               . $this->tbl_district . '.*,' . $this->tbl_state . '.*,' . $this->tbl_country . '.*,'
               . $this->tbl_showroom . '.*,' . $this->tbl_users . '.*,'
               . $this->tbl_divisions . '.div_name,' . $this->tbl_valuation . '.val_id,' . $this->tbl_valuation . '.val_status,'
               . $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des,' . $this->tbl_customer_grade . '.sgrd_grade,' . $this->tbl_customer_grade . '.sgrd_need_verification')
               ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
               ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
               ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
               ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
               ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id  = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
               ->join($this->tbl_customer_grade, $this->tbl_customer_grade . '.sgrd_id = ' . $this->tbl_enquiry . '.enq_customer_grade', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_enquiry_id = ' . $this->tbl_enquiry . '.enq_id', 'left')
               ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($this->tbl_enquiry . '.enq_id', $enqId)->get($this->tbl_enquiry)->row_array();

          if (!empty($enq)) {
               $enq['followup'] = $this->db->select($this->tbl_followup . '.*, ' .
                    $this->tbl_vehicle . '.veh_brand, ' . $this->tbl_vehicle . '.veh_model, ' . $this->tbl_vehicle . '.veh_varient,' .
                    $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
                    $this->tbl_users . '.usr_username AS folloup_added_by, ' . $this->tbl_users . '.usr_id AS folloup_added_by_id,' .
                    $this->tbl_users . '.usr_avatar, ' . $this->tbl_showroom . '.shr_location')
                    ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_followup . '.foll_added_by', 'LEFT')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                    ->order_by($this->tbl_followup . '.foll_id', 'DESC')
                    ->get_where($this->tbl_followup, array($this->tbl_followup . '.foll_cus_id' => $enqId, 'foll_parent' => 0))->result_array();

               $enq['vehicle_sall'] = $this->db->select($this->view_enquiry_vehicle_master . '.*,' . $this->tbl_statuses . '.*')
                    ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->view_enquiry_vehicle_master . '.vst_current_status', 'LEFt')
                    ->where($this->view_enquiry_vehicle_master . '.veh_enq_id = ' . $enqId .
                         ' AND ' . $this->view_enquiry_vehicle_master . '.veh_status = 1 AND (' .
                         $this->view_enquiry_vehicle_master . '.vst_current_status != 99 OR ' . $this->view_enquiry_vehicle_master . '.vst_current_status IS NULL)')
                    ->get($this->view_enquiry_vehicle_master)->result_array();

               /* $enq['vehicle_buy'] = $this->db->select($this->view_enquiry_vehicle_master . '.*,' . $this->tbl_statuses . '.*')
                   ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->view_enquiry_vehicle_master . '.vst_current_status', 'LEFt')
                   ->where($this->view_enquiry_vehicle_master . '.veh_enq_id = ' . $enqId .
                   ' AND ' . $this->view_enquiry_vehicle_master . '.veh_status = 2 AND (' .
                   $this->view_enquiry_vehicle_master . '.vst_current_status != 99 OR ' . $this->view_enquiry_vehicle_master . '.vst_current_status IS NULL)')
                   ->get($this->view_enquiry_vehicle_master)->result_array(); */
               $enq['vehicle_buy'] = $this->db->select($this->view_enquiry_vehicle_master . '.*,' . $this->tbl_statuses . '.*')
                    ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->view_enquiry_vehicle_master . '.vst_current_status', 'LEFt')
                    ->where($this->view_enquiry_vehicle_master . '.veh_enq_id = ' . $enqId .
                         ' AND ' . $this->view_enquiry_vehicle_master . '.veh_status = 2 AND (' .
                         $this->view_enquiry_vehicle_master . '.vst_current_status != 99 OR ' . $this->view_enquiry_vehicle_master . '.vst_current_status IS NULL)')
                    ->get($this->view_enquiry_vehicle_master)->result_array();

               $enq['questions'] = $this->db->select($this->tbl_enquiry_questions . '.*,' . $this->tbl_questions . '.*')
                    ->join($this->tbl_questions, $this->tbl_questions . '.qus_id = ' . $this->tbl_enquiry_questions . '.enqq_question_id', 'LEFT')
                    ->where($this->tbl_enquiry_questions . '.enqq_enq_id', $enqId)->get($this->tbl_enquiry_questions)->result_array();

               $cusMobile = substr($enq['enq_cus_mobile'], -10);
               $enq['regAssigned'] = $this->db->select($this->tbl_register_master . '.vreg_id, vreg_first_added_on, vreg_contact_mode, ' . $this->tbl_users . '.usr_username')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_register_master . '.vreg_first_owner', 'LEFT')
                    ->like($this->tbl_register_master . '.vreg_cust_phone', $cusMobile, 'both')->order_by('vreg_id', 'DESC')
                    ->get($this->tbl_register_master)->result_array();
          }
          return $enq;
     }

     function getTrackCardDetails_test($enqId)
     {
          //debug($enqId);
          $enq = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_occupation . '.*,' . $this->tbl_city . '.*,'
               . $this->tbl_district . '.*,' . $this->tbl_state . '.*,' . $this->tbl_country . '.*,'
               . $this->tbl_showroom . '.*,' . $this->tbl_users . '.*,'
               . $this->tbl_divisions . '.div_name,' . $this->tbl_occupation_category . '.occ_cat_name,'
               . $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des,' . $this->tbl_customer_grade . '.sgrd_grade,' . $this->tbl_customer_grade . '.sgrd_need_verification')
               ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
               ->join($this->tbl_occupation_category, $this->tbl_occupation_category . '.occ_occupation_id = ' . $this->tbl_occupation . '.occ_id', 'left')
               //tbl_occupation_category
               ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
               ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
               ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
               ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id  = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
               ->join($this->tbl_customer_grade, $this->tbl_customer_grade . '.sgrd_id = ' . $this->tbl_enquiry . '.enq_customer_grade', 'left')
               ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($this->tbl_enquiry . '.enq_id', $enqId)->get($this->tbl_enquiry)->row_array();

          if (!empty($enq)) {
               $enq['followup'] = $this->db->select($this->tbl_followup . '.*, ' .
                    $this->tbl_vehicle . '.veh_brand, ' . $this->tbl_vehicle . '.veh_model, ' . $this->tbl_vehicle . '.veh_varient,' .
                    $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
                    $this->tbl_users . '.usr_username AS folloup_added_by, ' . $this->tbl_users . '.usr_id AS folloup_added_by_id,' .
                    $this->tbl_users . '.usr_avatar, ' . $this->tbl_showroom . '.shr_location')
                    ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_followup . '.foll_added_by', 'LEFT')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                    ->order_by($this->tbl_followup . '.foll_id', 'DESC')
                    ->get_where($this->tbl_followup, array($this->tbl_followup . '.foll_cus_id' => $enqId, 'foll_parent' => 0))->result_array();

               //                 $enq['vehicle_sall'] = $this->db->select($this->view_enquiry_vehicle_master . '.*,' . $this->tbl_statuses . '.*')
               //                                 ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->view_enquiry_vehicle_master . '.vst_current_status', 'LEFt')
               //                                 ->where($this->view_enquiry_vehicle_master . '.veh_enq_id = ' . $enqId .
               //                                         ' AND ' . $this->view_enquiry_vehicle_master . '.veh_status = 1 AND (' .
               //                                         $this->view_enquiry_vehicle_master . '.vst_current_status != 99 OR ' . $this->view_enquiry_vehicle_master . '.vst_current_status IS NULL)')
               //                                 ->get($this->view_enquiry_vehicle_master)->result_array();

               /* $enq['vehicle_buy'] = $this->db->select($this->view_enquiry_vehicle_master . '.*,' . $this->tbl_statuses . '.*')
                   ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->view_enquiry_vehicle_master . '.vst_current_status', 'LEFt')
                   ->where($this->view_enquiry_vehicle_master . '.veh_enq_id = ' . $enqId .
                   ' AND ' . $this->view_enquiry_vehicle_master . '.veh_status = 2 AND (' .
                   $this->view_enquiry_vehicle_master . '.vst_current_status != 99 OR ' . $this->view_enquiry_vehicle_master . '.vst_current_status IS NULL)')
                   ->get($this->view_enquiry_vehicle_master)->result_array(); */
               //                 $enq['vehicle_sall'] = $this->db->select($this->view_vehicle_vehicle_status . '.*')
               //                                    ->where('veh_enq_id = ' . $id . ' AND veh_status = 1 AND (vst_current_status != 99 OR vst_current_status IS NULL)')
               //                                    ->get($this->view_vehicle_vehicle_status)->result_array();
               $whr = array('veh_enq_id' => $enqId, 'veh_status' => 2, 'veh_type' => 0);

               $enq['vehicle_buy'] = $this->db->select(
                    $this->tbl_vehicle . '.*, ' .
                         $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
                         $this->tbl_valuation . '.val_insurance_company, ' . $this->tbl_valuation . '.val_insurance_comp_date AS ins_valid_up_to,' . $this->tbl_valuation . '.val_insurance_comp_date,' . $this->tbl_valuation . '.val_insurance_ll_idv,' . $this->tbl_valuation . '.val_insurance,' .
                         $this->tbl_valuation . '.val_insurance_ll_date, ' . $this->tbl_valuation . '.val_insurance_comp_idv,' . $this->tbl_valuation . '.val_insurance_ll_idv AS ncb_percntg,' . $this->tbl_valuation . '.val_insurance_need_ncb AS ncb_req,'
                         . $this->tbl_valuation . '.val_insurance AS insurance_type,' . $this->tbl_valuation . '.val_hypo_bank AS bank,' . $this->tbl_valuation . '.val_hypo_bank_branch AS bank_branch,' . $this->tbl_valuation . '.val_hypo_close_by_cust,' . $this->tbl_valuation . '.val_hypo_loan_date AS loan_starting_date,'
                         . $this->tbl_valuation . '.val_hypo_loan_end_date AS loan_ending_date,' . $this->tbl_valuation . '.val_hypo_daily_int AS daily_interest,' . $this->tbl_valuation . '.val_hypo_frclos_val AS forclousure_value,' . $this->tbl_valuation . '.val_hypo_frclos_date AS forclousure_date,' . $this->tbl_valuation . '.val_top_up_loan AS any_top_up_loan,'
                         . $this->tbl_valuation . '.val_hypo_loan_amt AS loan_amount,'
               )->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                    ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                    ->where($whr)->get($this->tbl_vehicle)->result_array();
               $whr = array('veh_enq_id' => $enqId, 'veh_status' => 1, 'veh_type' => 1); //rq veh
               $enq['vehicle_sall'] = $this->db->select(
                    $this->tbl_vehicle . '.*, ' .
                         $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
               )->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    //->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                    ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                    ->where($whr)->get($this->tbl_vehicle)->result_array();
               $whr = array('veh_enq_id' => $enqId, 'veh_status' => 0, 'veh_type' => 2); //Existing veh
               $enq['vehicle_existing'] = $this->db->select(
                    $this->tbl_vehicle . '.*, ' .
                         $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
               )->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                    //->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                    ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                    ->where($whr)->get($this->tbl_vehicle)->result_array();

               $whr = array('veh_enq_id' => $enqId, 'veh_status' => 1, 'veh_type' => 3); //Pitched veh
               //                 $enq['vehicle_pitched'] = $this->db->select($this->tbl_vehicle . '.*, ' .
               //                                         $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
               //                                 )->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               //                                 ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               //                                 ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
               //                                 //->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
               //                                 ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
               //                                 ->where($whr)->get($this->tbl_vehicle)->result_array();
               $enq['vehicle_pitched'] = $this->db->select(
                    $this->tbl_vehicle . '.*, ' .
                         $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
                         $this->tbl_valuation . '.*,'
               )->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle . '.veh_stock_id', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'LEFT')
                    //->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                    ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')
                    ->where($whr)->get($this->tbl_vehicle)->result_array();


               $enq['questions'] = $this->db->select($this->tbl_enquiry_questions . '.*,' . $this->tbl_questions . '.*')
                    ->join($this->tbl_questions, $this->tbl_questions . '.qus_id = ' . $this->tbl_enquiry_questions . '.enqq_question_id', 'LEFT')
                    ->where($this->tbl_enquiry_questions . '.enqq_enq_id', $enqId)->get($this->tbl_enquiry_questions)->result_array();

               //                 $enq['home_visits']= $this->db->select($this->tbl_home_visits . '.*,' . $this->tbl_home_visit_approvals . '.*')
               //                                 ->join($this->tbl_home_visits, $this->tbl_home_visits . '.hmv_id  = ' . $this->tbl_home_visit_approvals . '.hmva_master_id', 'LEFT')
               //                                 ->where($this->tbl_home_visits . '.hmv_id ', $enqId)->get($this->tbl_home_visits)->result_array();
               //
               $enq['home_visits'] = $this->db->select($this->tbl_home_visits . '.*,' .
                    ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,'
                    . $this->tbl_variant . '.var_variant_name,' . $this->tbl_users .
                    '.usr_first_name AS travel_with,' . $this->tbl_enquiry .
                    '.enq_cus_name,' . $this->tbl_enquiry .
                    '.enq_cus_address,' . $this->tbl_enquiry .
                    '.enq_cus_mobile,' . $this->tbl_enquiry .
                    '.enq_cus_city,' . $this->tbl_enquiry .
                    '.enq_cus_dist,' . $this->tbl_enquiry .
                    '.enq_cus_age,') //enq_cus_age
                    ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_home_visits . '.hmv_added_by', 'LEFT')
                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id  = ' . $this->tbl_home_visits . '.hmv_veh_stock_id', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id  = ' . $this->tbl_home_visits . '.hmv_travel_with', 'left')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id  = ' . $this->tbl_home_visits . '.hmv_enq_id', 'left')
                    ->where('hmv_enq_id', $enqId)->order_by($this->tbl_home_visits . '.hmv_date', 'DESC')
                    ->get($this->tbl_home_visits)->result_array();
          }
          return $enq;
     }

     function getFreezedEnquires()
     {
          $where[$this->tbl_enquiry . '.enq_current_status'] = 9;
          if (is_roo_user()) { // Admin users
               $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left');
               return $this->db->order_by($this->tbl_enquiry . '.enq_id', 'DESC')
                    ->get_where($this->tbl_enquiry, $where)->result_array();
          } else if ($this->usr_grp == 'MG') { // Manager
               $showroom = get_logged_user('usr_showroom');
               $where[$this->tbl_enquiry . '.enq_showroom_id'] = $showroom;
               $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left');
               return $this->db->order_by($this->tbl_enquiry . '.enq_id', 'DESC')
                    ->get_where($this->tbl_enquiry, $where)->result_array();
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $where[$this->tbl_enquiry . '.enq_added_by'] = $this->uid;
               $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left');
               return $this->db->order_by($this->tbl_enquiry . '.enq_id', 'DESC')
                    ->get_where($this->tbl_enquiry, $where)->result_array();
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $where[$this->tbl_enquiry . '.enq_se_id'] = $this->uid;
               $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left');
               return $this->db->order_by($this->tbl_enquiry . '.enq_id', 'DESC')
                    ->get_where($this->tbl_enquiry, $where)->result_array();
          } else if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id);
               if (!empty($mystaffs)) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               }

               $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left');
               return $this->db->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
          }
     }

     function getVehicleStatusDetails($vehId, $statusId)
     {

          return $this->db->order_by('vst_id', 'DESC')
               ->get_where($this->tbl_vehicle_status, array('vst_vehicle_id' => $vehId, 'vst_status' => $statusId))->row_array();
     }

     function getOriginalFreezedEnquiry($mobileNo)
     {
          $mobileNo = substr($mobileNo, -10);
          $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left');
          return $this->db->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($this->tbl_enquiry . '.enq_current_status != 9')
               ->like($this->tbl_enquiry . '.enq_cus_mobile', $mobileNo, 'both')->get($this->tbl_enquiry)->row_array();
     }

     function listEnqForAssign($id = '', $status = array(), $limit = 0, $page = 0, $exParams = array())
     {
          $this->load->model('evaluation/evaluation_model', 'evaluation');
          $showroom = get_logged_user('usr_showroom');

          $whereSearch = '';

          if (is_roo_user()) {
               $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')->where(array('vst_current_status' => '99'))
                    ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
               $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));

               $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;

               if (isset($exParams['showroom']) && !empty($exParams['showroom'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $exParams['showroom']);
               }

               if (isset($exParams['executive']) && !empty($exParams['executive'])) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $exParams['executive']);
               }

               //Count
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);
               $count = $this->db->last_query();
               //Data
               if (isset($exParams['showroom']) && !empty($exParams['showroom'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $exParams['showroom']);
               }

               if (isset($exParams['executive']) && !empty($exParams['executive'])) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $exParams['executive']);
               }
               $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if ($limit) {
                    $this->db->limit($limit, $page);
               }
               $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')
                    ->where($where)->get($this->tbl_enquiry)->result_array();
               return $return;
          } else if ($this->usr_grp == 'MG') { // Manager
               $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')
                    ->where(array('vst_current_status' => '99', 'enq_showroom_id' => $showroom))
                    ->get($this->view_enquiry_vehicle_master)->row()->enq_id;

               $where[$this->tbl_enquiry . '.enq_showroom_id'] = $showroom;
               $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;
               if (isset($exParams['showroom']) && !empty($exParams['showroom'])) {
                    $this->db->where($this->view_enquiry_vehicle_master . '.enq_showroom_id', $exParams['showroom']);
               }

               if (isset($exParams['executive']) && !empty($exParams['executive'])) {
                    $this->db->where_in($this->view_enquiry_vehicle_master . '.enq_se_id', $exParams['executive']);
               }
               //Count
               $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

               //Data
               if (isset($exParams['showroom']) && !empty($exParams['showroom'])) {
                    $this->db->where($this->view_enquiry_vehicle_master . '.enq_showroom_id', $exParams['showroom']);
               }

               if (isset($exParams['executive']) && !empty($exParams['executive'])) {
                    $this->db->where_in($this->view_enquiry_vehicle_master . '.enq_se_id', $exParams['executive']);
               }
               $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if ($limit) {
                    $this->db->limit($limit, $page);
               }
               $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
               return $return;
          }
     }

     function assignEnquires($datas)
     {
          if (!empty($datas)) {
               if ((isset($datas['assignEnqIds']) && !empty($datas['assignEnqIds'])) && isset($datas['salesExeId'])) {
                    $seId = $datas['salesExeId'];
                    foreach ((array) $datas['assignEnqIds'] as $key => $endId) {
                         //Move enquiry
                         $enquiry = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $endId))->row_array();
                         if (!empty($enquiry)) {
                              generate_log(array(
                                   'log_title' => 'Enquiry moved',
                                   'log_desc' => $enquiry['enq_se_id'] . '-' . $seId,
                                   'log_controller' => 'move-enquiry',
                                   'log_action' => 'U',
                                   'log_ref_id' => $endId,
                                   'log_added_by' => get_logged_user('usr_id')
                              ));
                              $this->db->where(array('enq_id' => $endId));
                              $this->db->update($this->tbl_enquiry, array('enq_se_id' => $seId));
                         }

                         //Move enquiry
                         $followup = $this->db->get_where($this->tbl_followup, array('foll_cus_id' => $endId))->result_array();
                         if (!empty($followup) && is_array($followup)) {
                              foreach ($followup as $key => $fol) {
                                   if (!empty($fol)) {
                                        generate_log(array(
                                             'log_title' => 'Followup moved',
                                             'log_desc' => $fol['foll_added_by'] . '-' . $seId,
                                             'log_controller' => 'move-followup',
                                             'log_action' => 'U',
                                             'log_ref_id' => $fol['foll_id'],
                                             'log_added_by' => get_logged_user('usr_id')
                                        ));
                                        $this->db->where(array('foll_id' => $fol['foll_id']));
                                        //$endId
                                        $this->db->update($this->tbl_followup, array('foll_added_by' => $fol['foll_added_by']));
                                   }
                              }
                         }
                    }
               }
               return true;
          }
          return false;
     }

   /**-------------------------------2025Test --------------------------*/

     public function readVehicleRegTest($id = '', $limit = 0, $page = 0, $filter = array(), $assign = false)
     {
          $allStatus = isset($filter['chkAllStatus']) ? $filter['chkAllStatus'] : '0';
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);

          $vregDivision = isset($filter['vreg_division']) ? $filter['vreg_division'] : 0;
          $vregShowroom = isset($filter['vreg_showroom']) ? $filter['vreg_showroom'] : 0;
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop . ',' . enq_lost . ',' . enq_droped . ',' . enq_verfd_close;
          $vreg_first_owner = isset($filter['vreg_first_owner']) ? $filter['vreg_first_owner'] : 0;
          $vreg_added_by = isset($filter['vreg_added_by']) ? $filter['vreg_added_by'] : 0;
          $dept = isset($filter['vreg_department']) ? $filter['vreg_department'] : '';
          $type = isset($filter['vreg_call_type']) ? $filter['vreg_call_type'] : '';
          $mode = isset($filter['vreg_contact_mode']) ? $filter['vreg_contact_mode'] : '';
          $event = isset($filter['vreg_event']) ? $filter['vreg_event'] : '';
          $effective = isset($filter['vreg_is_effective']) ? $filter['vreg_is_effective'] : '';
          $addedEntry = (isset($filter['added_entry']) && !empty($filter['added_entry'])) ? $filter['added_entry'] : 'vreg_added_on';
          $isPunched = (isset($filter['vreg_is_punched'])) ? $filter['vreg_is_punched'] : '';

          $enq_date_from = (isset($filter['vreg_added_on_fr']) && !empty($filter['vreg_added_on_fr'])) ?
          date('Y-m-d', strtotime($filter['vreg_added_on_fr'])) : '';

          $enq_date_to = (isset($filter['vreg_added_on_to']) && !empty($filter['vreg_added_on_to'])) ?
          date('Y-m-d', strtotime($filter['vreg_added_on_to'])) : '';
          $search = isset($filter['search']) ? $filter['search'] : '';

          if (($this->uid != ADMIN_ID) && empty($search)) {

               if (check_permission('registration', 'showmyshowroomregisters')) {

                    $this->db->where('vreg_showroom', $this->shrm);
               } else {

                    if (!check_permission('registration', 'showallregisters')) {
                         $this->db->where(array('vreg_assigned_to' => $this->uid));
                    }
                    if (check_permission('registration', 'registrationcreatedbyme')) {
                         $this->db->where(array('vreg_added_by' => $this->uid));
                    }
                    if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                         array_push($mystaffs, $this->uid);
                         $mystaffs = array_filter($mystaffs);

                         $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
                    }
                    if (check_permission('registration', 'myregmyown')) {
                         $this->db->where(array('vreg_first_owner' => $this->uid));
                    }
                    if (check_permission('registration', 'not_show_visitors_in_myregister')) {
                         $this->db->where_not_in('vreg_contact_mode', array(40));
                    }
                    if (check_permission('registration', 'serviceregisters')) {
                         $this->db->where('vreg_division', 3); // RD Care
                    }
               }
          } //dn
          if (!$assign) {
               if (!empty($filter)) {

                    if ($isPunched == '0' || $isPunched == '1') {
                         $this->db->where('vreg_is_punched', $isPunched);
                    }
                    if ($vreg_first_owner > 0) {
                         $this->db->where('vreg_first_owner', $vreg_first_owner);
                    }
                    if ($vreg_added_by > 0) {
                         $this->db->where('vreg_added_by', $vreg_added_by);
                    }

                    $type = isset($filter['type']) ? $filter['type'] : '';
                    $brd = isset($filter['vreg_brand']) ? $filter['vreg_brand'] : '';
                    $mod = isset($filter['vreg_model']) ? $filter['vreg_model'] : '';
                    $var = isset($filter['vreg_varient']) ? $filter['vreg_varient'] : '';

                    if ($type == 'ex') {
                         $this->db->where('vreg_inquiry != 0');
                    } else if ($type == 'nw') {
                         $this->db->where('vreg_inquiry = 0');
                    }

                    if ($dept > 0) {
                         $this->db->where('vreg_department', $dept);
                    }
                    if ($type > 0) {
                         $this->db->where('vreg_call_type', $type);
                    }
                    if ($mode > 0) {
                         $this->db->where('vreg_contact_mode', $mode);
                         if ($mode == 5) {
                              if ($event) {
                                   $this->db->where('vreg_event', $event);
                              }
                         }
                    }

                    // if (!empty($search)) {//old code  to reomve
                    //      $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                    //      $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                    //      $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    //      $this->db->where($whereSearch);
                    // }
                    // Apply search filter
                    if (!empty($search)) { // new code
                         $whereSearch = '(' . $this->tbl_customer_details . ".cusd_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_customer_details . ".cusd_place LIKE '%" . $search . "%' OR " .
                         $this->tbl_customer_phones . ".cup_phone LIKE '%" . $search . "%' )";
                         $this->db->where($whereSearch);
                    }
                    if ($brd > 0) {
                         $this->db->where($this->tbl_register_master . ".vreg_brand", $brd);
                    }
                    if ($mod > 0) {
                         $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
                    }
                    if ($var > 0) {
                         $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
                    }
                    if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                         $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
                    }
                    if ($vregDivision > 0) {
                         $this->db->where('vreg_division', $vregDivision);
                    }
                    if ($vregShowroom > 0) {
                         $this->db->where('vreg_showroom', $vregShowroom);
                    }
               }
               if (!check_permission('enquiry', 'myregshowpunchedalso')) {
                    $this->db->where('vreg_is_punched = 0');
               }
               if (!empty($enq_date_from) && !empty($enq_date_to)) {
                    $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . ') )');
               }
               if ($effective == '0' || $effective == '1') {
                    $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
               }
               if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
                    $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
               }

               // $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left');
               $this->db->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT');
               $this->db->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT');
               $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT');
               $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'LEFT');
               $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT');
               $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'LEFT');
               $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT');
               $this->db->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = exstse.usr_id', 'LEFT');
               $this->db->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'LEFT');
               $this->db->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'LEFT');
               $this->db->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'LEFT');
               $this->db->join($this->tbl_customer_details, $this->tbl_customer_details . '.cusd_id = ' . $this->tbl_register_master . '.vreg_cust_id', 'LEFT');
               $this->db->join($this->tbl_customer_phones, $this->tbl_customer_phones . '.cup_customer_id = ' . $this->tbl_customer_details . '.cusd_id', 'LEFT');

               if ($allStatus != 1) {

                    $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
                    $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
               }
              // $this->db->group_by($this->tbl_register_master . '.vreg_id'); // is it correct? don't repaet same in records $this->tbl_register_master .phone tables ($this->tbl_customer_phones) may coantains mutple record against one records of $this->tbl_register_master  table
    $this->db->select('COUNT(DISTINCT ' . $this->tbl_register_master . '.vreg_id) as count');
    $query = $this->db->get($this->tbl_register_master);
    $return['count'] = $query->row()->count;
             // $return['count'] = $this->db->count_all_results($this->tbl_register_master); // total reord fetching for pagination pupose 
             //  debug($return);
             return $return;
          }
     }
   /**-------------------------------End2025Test --------------------------*/
   /**-------------------------------2025 --------------------------*/
   public function readVehicleReg_2025($id = '', $limit = 0, $page = 0, $filter = array(), $assign = false)
{
     $search = isset($filter['search']) ? $filter['search'] : '';     
    $selectArray = array(
        $this->tbl_register_master . '.vreg_id',
        $this->tbl_register_master . '.vreg_assigned_to',
        $this->tbl_register_master . '.vreg_added_by',
        $this->tbl_register_master . '.vreg_contact_mode',
        $this->tbl_register_master . '.vreg_district',
        $this->tbl_register_master . '.vreg_tsc_comments',
        $this->tbl_register_master . '.vreg_added_on',
        $this->tbl_register_master . '.vreg_cust_id',
        $this->tbl_register_master . '.vreg_existing_vehicle',
        $this->tbl_register_master . '.vreg_brand',
        $this->tbl_register_master . '.vreg_model',
        $this->tbl_register_master . '.vreg_varient',
        $this->tbl_register_master . '.vreg_year',
        $this->tbl_register_master . '.vreg_investment',
        $this->tbl_register_master . '.vreg_km',
        $this->tbl_register_master . '.vreg_customer_status',
        $this->tbl_register_master . '.vreg_type_of_visit',
        $this->tbl_register_master . '.vreg_appointment',
        $this->tbl_register_master . '.vreg_second_d_hpy_cal',
        $this->tbl_register_master . '.vreg_division',
        $this->tbl_register_master . '.vreg_showroom',
        $this->tbl_register_master . '.vreg_call_type',
        $this->tbl_register_master . '.vreg_event',
        $this->tbl_register_master . '.vreg_is_effective',
        $this->tbl_register_master . '.vreg_entry_date',
        $this->tbl_register_master . '.vreg_is_punched',
        $this->tbl_register_master . '.vreg_customer_remark',
        $this->tbl_register_master . '.vreg_inquiry',
        $this->tbl_register_master . '.vreg_is_verified',
        $this->tbl_register_master . '.vreg_next_followup',
        $this->tbl_register_master . '.vreg_cust_place',
        $this->tbl_register_master . '.vreg_referal_type',
        $this->tbl_register_master . '.vreg_referal_name',
        $this->tbl_register_master . '.vreg_referal_phone',
        $this->tbl_register_master . '.vreg_last_action',
        'assign.usr_first_name AS assign_usr_first_name',
        'assign.usr_last_name AS assign_usr_last_name',
        'assign.usr_division AS div_id',
        'addedby.usr_first_name AS addedby_usr_first_name',
        'addedby.usr_last_name AS addedby_usr_last_name',
        'exstse.usr_username AS exstse_usr_username',
        $this->tbl_events . '.evnt_title',
        $this->tbl_brand . '.brd_id',
        $this->tbl_brand . '.brd_title',
        $this->tbl_model . '.mod_id',
        $this->tbl_model . '.mod_title',
        $this->tbl_variant . '.var_id',
        $this->tbl_variant . '.var_variant_name',
        $this->tbl_enquiry . '.enq_current_status',
        $this->tbl_callcenterbridging . '.ccb_recording_URL',
        $this->tbl_callcenterbridging . '.ccb_callStatus_id',
        $this->tbl_departments . '.dep_name',
        $this->tbl_district_statewise . '.*',
        $this->tbl_customer_details . '.cusd_id',
        $this->tbl_customer_details . '.cusd_name',
        $this->tbl_customer_details . '.cusd_phone_office',
        $this->tbl_customer_details . '.cusd_phone_resi',
        $this->tbl_customer_details . '.cusd_whatsapp',
        $this->tbl_customer_details . '.cusd_email',
        $this->tbl_customer_details . '.cusd_fb',
        $this->tbl_customer_details . '.cusd_age',
        $this->tbl_customer_details . '.cusd_gender',
        $this->tbl_customer_details . '.cusd_place',
        $this->tbl_customer_details . '.cusd_address',
        $this->tbl_customer_details . '.cusd_address_office',
        $this->tbl_customer_details . '.cusd_profession',
        $this->tbl_customer_details . '.cusd_company',
        $this->tbl_customer_details . '.cusd_district',
        $this->tbl_customer_details . '.cusd_pin'
    );

    $this->db->select(array_merge($selectArray, [
        "GROUP_CONCAT(DISTINCT " . $this->tbl_customer_phones . ".cup_phone SEPARATOR ', ') AS phone_numbers"
    ]));

    $this->db->from($this->tbl_register_master);
    $this->db->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT');
    $this->db->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT');
    $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT');
    $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'LEFT');
    $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT');
    $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'LEFT');
    $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT');
    $this->db->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = exstse.usr_id', 'LEFT');
    $this->db->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'LEFT');
    $this->db->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'LEFT');
    $this->db->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'LEFT');
    $this->db->join($this->tbl_customer_details, $this->tbl_customer_details . '.cusd_id = ' . $this->tbl_register_master . '.vreg_cust_id', 'LEFT');
    $this->db->join($this->tbl_customer_phones, $this->tbl_customer_phones . '.cup_customer_id = ' . $this->tbl_customer_details . '.cusd_id', 'LEFT');

    // Apply search filter
    if (!empty($search)) { 
     $whereSearch = '(' . $this->tbl_customer_details . ".cusd_name LIKE '%" . $search . "%' OR " .
                    $this->tbl_customer_details . ".cusd_place LIKE '%" . $search . "%' OR " .
                    $this->tbl_customer_phones . ".cup_phone LIKE '%" . $search . "%' )";
     $this->db->where($whereSearch);
 }
    $this->db->group_by($this->tbl_register_master . '.vreg_id');

    $query = $this->db->get();
    return $query->result_array();
}
 
   /**-------------------------------End2025 --------------------------*/

     /**-------------------------------2025-90% --------------------------*/
     public function readVehicleRegNew($id = '', $limit = 0, $page = 0, $filter = array(), $assign = false)
     { //new
          $id=3;
          $allStatus = isset($filter['chkAllStatus']) ? $filter['chkAllStatus'] : '0';
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);

          $vregDivision = isset($filter['vreg_division']) ? $filter['vreg_division'] : 0;
          $vregShowroom = isset($filter['vreg_showroom']) ? $filter['vreg_showroom'] : 0;
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop . ',' . enq_lost . ',' . enq_droped . ',' . enq_verfd_close;
          $vreg_first_owner = isset($filter['vreg_first_owner']) ? $filter['vreg_first_owner'] : 0;
          $vreg_added_by = isset($filter['vreg_added_by']) ? $filter['vreg_added_by'] : 0;
          $dept = isset($filter['vreg_department']) ? $filter['vreg_department'] : '';
          $type = isset($filter['vreg_call_type']) ? $filter['vreg_call_type'] : '';
          $mode = isset($filter['vreg_contact_mode']) ? $filter['vreg_contact_mode'] : '';
          $event = isset($filter['vreg_event']) ? $filter['vreg_event'] : '';
          $effective = isset($filter['vreg_is_effective']) ? $filter['vreg_is_effective'] : '';
          $addedEntry = (isset($filter['added_entry']) && !empty($filter['added_entry'])) ? $filter['added_entry'] : 'vreg_added_on';
          $isPunched = (isset($filter['vreg_is_punched'])) ? $filter['vreg_is_punched'] : '';

          $enq_date_from = (isset($filter['vreg_added_on_fr']) && !empty($filter['vreg_added_on_fr'])) ?
          date('Y-m-d', strtotime($filter['vreg_added_on_fr'])) : '';

          $enq_date_to = (isset($filter['vreg_added_on_to']) && !empty($filter['vreg_added_on_to'])) ?
          date('Y-m-d', strtotime($filter['vreg_added_on_to'])) : '';
          $search = isset($filter['search']) ? $filter['search'] : '';

          if (($this->uid != ADMIN_ID) && empty($search)) {

               if (check_permission('registration', 'showmyshowroomregisters')) {

                    $this->db->where('vreg_showroom', $this->shrm);
               } else {

                    if (!check_permission('registration', 'showallregisters')) {
                         $this->db->where(array('vreg_assigned_to' => $this->uid));
                    }
                    if (check_permission('registration', 'registrationcreatedbyme')) {
                         $this->db->where(array('vreg_added_by' => $this->uid));
                    }
                    if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                         array_push($mystaffs, $this->uid);
                         $mystaffs = array_filter($mystaffs);

                         $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
                    }
                    if (check_permission('registration', 'myregmyown')) {
                         $this->db->where(array('vreg_first_owner' => $this->uid));
                    }
                    if (check_permission('registration', 'not_show_visitors_in_myregister')) {
                         $this->db->where_not_in('vreg_contact_mode', array(40));
                    }
                    if (check_permission('registration', 'serviceregisters')) {
                         $this->db->where('vreg_division', 3); // RD Care
                    }
               }
          } //dn
          if (!$assign) {
               if (!empty($filter)) {

                    if ($isPunched == '0' || $isPunched == '1') {
                         $this->db->where('vreg_is_punched', $isPunched);
                    }
                    if ($vreg_first_owner > 0) {
                         $this->db->where('vreg_first_owner', $vreg_first_owner);
                    }
                    if ($vreg_added_by > 0) {
                         $this->db->where('vreg_added_by', $vreg_added_by);
                    }

                    $type = isset($filter['type']) ? $filter['type'] : '';
                    $brd = isset($filter['vreg_brand']) ? $filter['vreg_brand'] : '';
                    $mod = isset($filter['vreg_model']) ? $filter['vreg_model'] : '';
                    $var = isset($filter['vreg_varient']) ? $filter['vreg_varient'] : '';

                    if ($type == 'ex') {
                         $this->db->where('vreg_inquiry != 0');
                    } else if ($type == 'nw') {
                         $this->db->where('vreg_inquiry = 0');
                    }

                    if ($dept > 0) {
                         $this->db->where('vreg_department', $dept);
                    }
                    if ($type > 0) {
                         $this->db->where('vreg_call_type', $type);
                    }
                    if ($mode > 0) {
                         $this->db->where('vreg_contact_mode', $mode);
                         if ($mode == 5) {
                              if ($event) {
                                   $this->db->where('vreg_event', $event);
                              }
                         }
                    }

                    // if (!empty($search)) {//old
                    //      $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                    //      $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                    //      $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    //      $this->db->where($whereSearch);
                    // }
                    // Apply search filter
                    if (!empty($search)) { // new code
                         $whereSearch = '(' . $this->tbl_customer_details . ".cusd_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_customer_details . ".cusd_place LIKE '%" . $search . "%' OR " .
                         $this->tbl_customer_phones . ".cup_phone LIKE '%" . $search . "%' )";
                         $this->db->where($whereSearch);
                    }
                    if ($brd > 0) {
                         $this->db->where($this->tbl_register_master . ".vreg_brand", $brd);
                    }
                    if ($mod > 0) {
                         $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
                    }
                    if ($var > 0) {
                         $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
                    }
                    if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                         $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
                    }
                    if ($vregDivision > 0) {
                         $this->db->where('vreg_division', $vregDivision);
                    }
                    if ($vregShowroom > 0) {
                         $this->db->where('vreg_showroom', $vregShowroom);
                    }
               }
               if (!check_permission('enquiry', 'myregshowpunchedalso')) {
                    $this->db->where('vreg_is_punched = 0');
               }
               if (!empty($enq_date_from) && !empty($enq_date_to)) {
                    $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . ') )');
               }
               if ($effective == '0' || $effective == '1') {
                    $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
               }
               if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
                    $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
               }


               $this->db->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT');
               $this->db->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT');
               $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT');
               $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'LEFT');
               $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT');
               $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'LEFT');
               $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT');
               $this->db->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = exstse.usr_id', 'LEFT');
               $this->db->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'LEFT');
               $this->db->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'LEFT');
               $this->db->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'LEFT');
               $this->db->join($this->tbl_customer_details, $this->tbl_customer_details . '.cusd_id = ' . $this->tbl_register_master . '.vreg_cust_id', 'LEFT');
               $this->db->join($this->tbl_customer_phones, $this->tbl_customer_phones . '.cup_customer_id = ' . $this->tbl_customer_details . '.cusd_id', 'LEFT');

               if ($allStatus != 1) {

                    $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
                    $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
               }
               $this->db->select('COUNT(DISTINCT ' . $this->tbl_register_master . '.vreg_id) as count');
               $query = $this->db->get($this->tbl_register_master);
               $return['count'] = $query->row()->count;
               //select//
               $selectArray = array(
                    $this->tbl_register_master . '.vreg_id',
                    $this->tbl_register_master . '.vreg_assigned_to',
                    $this->tbl_register_master . '.vreg_added_by',
                    $this->tbl_register_master . '.vreg_contact_mode',
                    $this->tbl_register_master . '.vreg_district',
                    $this->tbl_register_master . '.vreg_tsc_comments',
                    $this->tbl_register_master . '.vreg_added_on',
                    $this->tbl_register_master . '.vreg_cust_id',
                    $this->tbl_register_master . '.vreg_existing_vehicle',
                    $this->tbl_register_master . '.vreg_brand',
                    $this->tbl_register_master . '.vreg_model',
                    $this->tbl_register_master . '.vreg_varient',
                    $this->tbl_register_master . '.vreg_year',
                    $this->tbl_register_master . '.vreg_investment',
                    $this->tbl_register_master . '.vreg_km',
                    $this->tbl_register_master . '.vreg_customer_status',
                    $this->tbl_register_master . '.vreg_type_of_visit',
                    $this->tbl_register_master . '.vreg_appointment',
                    $this->tbl_register_master . '.vreg_second_d_hpy_cal',
                    $this->tbl_register_master . '.vreg_division',
                    $this->tbl_register_master . '.vreg_showroom',
                    $this->tbl_register_master . '.vreg_call_type',
                    $this->tbl_register_master . '.vreg_event',
                    $this->tbl_register_master . '.vreg_is_effective',
                    $this->tbl_register_master . '.vreg_entry_date',
                    $this->tbl_register_master . '.vreg_is_punched',
                    $this->tbl_register_master . '.vreg_customer_remark',
                    $this->tbl_register_master . '.vreg_inquiry',
                    $this->tbl_register_master . '.vreg_is_verified',
                    $this->tbl_register_master . '.vreg_next_followup',
                    $this->tbl_register_master . '.vreg_cust_place',
                    $this->tbl_register_master . '.vreg_referal_type',
                    $this->tbl_register_master . '.vreg_referal_name',
                    $this->tbl_register_master . '.vreg_referal_phone',
                    $this->tbl_register_master . '.vreg_last_action',
                    'assign.usr_first_name AS assign_usr_first_name',
                    'assign.usr_last_name AS assign_usr_last_name',
                    'assign.usr_division AS div_id',
                    'addedby.usr_first_name AS addedby_usr_first_name',
                    'addedby.usr_last_name AS addedby_usr_last_name',
                    'exstse.usr_username AS exstse_usr_username',
                    $this->tbl_events . '.evnt_title',
                    $this->tbl_brand . '.brd_id',
                    $this->tbl_brand . '.brd_title',
                    $this->tbl_model . '.mod_id',
                    $this->tbl_model . '.mod_title',
                    $this->tbl_variant . '.var_id',
                    $this->tbl_variant . '.var_variant_name',
                    $this->tbl_enquiry . '.enq_current_status',
                    $this->tbl_callcenterbridging . '.ccb_recording_URL',
                    $this->tbl_callcenterbridging . '.ccb_callStatus_id',
                    $this->tbl_departments . '.dep_name',
                    $this->tbl_district_statewise . '.*',
                    $this->tbl_customer_details . '.cusd_id',
                    $this->tbl_customer_details . '.cusd_name',
                    $this->tbl_customer_details . '.cusd_phone_office',
                    $this->tbl_customer_details . '.cusd_phone_resi',
                    $this->tbl_customer_details . '.cusd_whatsapp',
                    $this->tbl_customer_details . '.cusd_email',
                    $this->tbl_customer_details . '.cusd_fb',
                    $this->tbl_customer_details . '.cusd_age',
                    $this->tbl_customer_details . '.cusd_gender',
                    $this->tbl_customer_details . '.cusd_place',
                    $this->tbl_customer_details . '.cusd_address',
                    $this->tbl_customer_details . '.cusd_address_office',
                    $this->tbl_customer_details . '.cusd_profession',
                    $this->tbl_customer_details . '.cusd_company',
                    $this->tbl_customer_details . '.cusd_district',
                    $this->tbl_customer_details . '.cusd_pin'
               );

               $this->db->select(array_merge($selectArray, [
                    "GROUP_CONCAT(DISTINCT " . $this->tbl_customer_phones . ".cup_phone SEPARATOR ', ') AS phone_numbers"
               ]));
               //End Select//

               /*Join data*/
               $this->db->from($this->tbl_register_master);
               $this->db->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT');
               $this->db->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT');
               $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT');
               $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'LEFT');
               $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT');
               $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'LEFT');
               $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT');
               $this->db->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = exstse.usr_id', 'LEFT');
               $this->db->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'LEFT');
               $this->db->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'LEFT');
               $this->db->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'LEFT');
               $this->db->join($this->tbl_customer_details, $this->tbl_customer_details . '.cusd_id = ' . $this->tbl_register_master . '.vreg_cust_id', 'LEFT');
               $this->db->join($this->tbl_customer_phones, $this->tbl_customer_phones . '.cup_customer_id = ' . $this->tbl_customer_details . '.cusd_id', 'LEFT');

               /*End join data*/
               if (!empty($id)) { //need to modify
                    //debug($id);
                    return $this->db->order_by($this->tbl_register_master . '.vreg_entry_date', 'DESC')
                         ->get_where($this->tbl_register_master, array($this->tbl_register_master . '.vreg_id' => $id))->row_array();
               }

               //$this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
               if ($limit) {
                    $this->db->limit($limit, $page);
               }
          }
          if (($this->uid != ADMIN_ID) && empty($search)) {
               if (check_permission('registration', 'showmyshowroomregisters')) {
                    $this->db->where('vreg_showroom', $this->shrm);
               } else {
                    if (!check_permission('registration', 'showallregisters')) {
                         $this->db->where(array('vreg_assigned_to' => $this->uid));
                    }
                    if (check_permission('registration', 'registrationcreatedbyme')) {
                         $this->db->where(array('vreg_added_by' => $this->uid));
                    }
                    if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                         array_push($mystaffs, $this->uid);
                         $mystaffs = array_filter($mystaffs);
                         $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
                    }
                    if (check_permission('registration', 'myregmyown')) {
                         $this->db->where(array('vreg_first_owner' => $this->uid));
                    }
                    if (check_permission('registration', 'serviceregisters')) {
                         $this->db->where('vreg_division', 3);
                    }
               }
               if (check_permission('registration', 'not_show_visitors_in_myregister')) {
                    $this->db->where_not_in('vreg_contact_mode', array(40));
               }
          }
          if (!empty($filter)) {
               if ($isPunched == '0' || $isPunched == '1') {
                    $this->db->where('vreg_is_punched', $isPunched);
               }
               if ($vreg_first_owner > 0) {
                    $this->db->where('vreg_first_owner', $vreg_first_owner);
               }
               if ($vreg_added_by > 0) {
                    $this->db->where('vreg_added_by', $vreg_added_by);
               }
               $type = isset($filter['type']) ? $filter['type'] : '';
               if ($type == 'ex') {
                    $this->db->where('vreg_inquiry != 0');
               } else if ($type == 'nw') {
                    $this->db->where('vreg_inquiry = 0');
               }
               if ($dept > 0) {
                    $this->db->where('vreg_department', $dept);
               }
               if ($type > 0) {
                    $this->db->where('vreg_call_type', $type);
               }
               if ($mode > 0) {
                    $this->db->where('vreg_contact_mode', $mode);
                    if ($mode == 5) {
                         if ($event) {
                              $this->db->where('vreg_event', $event);
                         }
                    }
               }
               //    if (!empty($search)) {//old removed
               //         $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
               //         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
               //         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
               //         $this->db->where($whereSearch);
               //    }
               // Apply search filter
               if (!empty($search)) { //new
                    $whereSearch = '(' . $this->tbl_customer_details . ".cusd_name LIKE '%" . $search . "%' OR " .
                    $this->tbl_customer_details . ".cusd_place LIKE '%" . $search . "%' OR " .
                    $this->tbl_customer_phones . ".cup_phone LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }
               if ($brd > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_brand", $brd);
               }
               if ($mod > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
               }
               if ($var > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
               }
               if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
               }
               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               }
               if ($vregShowroom > 0) {
                    $this->db->where('vreg_showroom', $vregShowroom);
               }
          }
          if (!check_permission('enquiry', 'myregshowpunchedalso')) {
               $this->db->where('vreg_is_punched = 0');
          }

          if (!empty($enq_date_from) && !empty($enq_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
               'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . '))');
          }
          if ($effective == '0' || $effective == '1') {
               $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          }
          $this->db->order_by('vreg_entry_date', 'DESC');
          if ($allStatus != 1) {
               $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
               $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          }

          if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
               $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
          }
          if ($assign) { //need to modify
               $select = "CONCAT(" . $this->tbl_register_master . '.vreg_id' . "," . "'-'," . $this->tbl_register_master . '.vreg_cust_phone,' . "'-'," . ",addedby.usr_username) as asign";
               $this->db->select($select, false)
                    ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                    ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left');
               $return['data'] = $this->db->get($this->tbl_register_master)->result_array();
          } else {
               // $return['data'] = $this->db->get($this->tbl_register_master)->result_array();//old
               /* new */
               $this->db->group_by($this->tbl_register_master . '.vreg_id');
               $query = $this->db->get();
               $return['data'] = $query->result_array();
               /* End new */
          }
          // if ($this->uid == 100) {
          //      echo $this->db->last_query();
          //      debug($return['data']);
          // }

          return $return;
     }
   /**-------------------------------End2025-90% --------------------------*/

     public function readVehicleReg($id = '', $limit = 0, $page = 0, $filter = array(), $assign = false)
     { //cpd to api 17171

          $allStatus = isset($filter['chkAllStatus']) ? $filter['chkAllStatus'] : '0';
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);

          $vregDivision = isset($filter['vreg_division']) ? $filter['vreg_division'] : 0;
          $vregShowroom = isset($filter['vreg_showroom']) ? $filter['vreg_showroom'] : 0;
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop . ',' . enq_lost . ',' . enq_droped . ',' . enq_verfd_close;
          $vreg_first_owner = isset($filter['vreg_first_owner']) ? $filter['vreg_first_owner'] : 0;
          $vreg_added_by = isset($filter['vreg_added_by']) ? $filter['vreg_added_by'] : 0;
          $dept = isset($filter['vreg_department']) ? $filter['vreg_department'] : '';
          $type = isset($filter['vreg_call_type']) ? $filter['vreg_call_type'] : '';
          $mode = isset($filter['vreg_contact_mode']) ? $filter['vreg_contact_mode'] : '';
          $event = isset($filter['vreg_event']) ? $filter['vreg_event'] : '';
          $effective = isset($filter['vreg_is_effective']) ? $filter['vreg_is_effective'] : '';
          $addedEntry = (isset($filter['added_entry']) && !empty($filter['added_entry'])) ? $filter['added_entry'] : 'vreg_added_on';
          $isPunched = (isset($filter['vreg_is_punched'])) ? $filter['vreg_is_punched'] : '';

          $enq_date_from = (isset($filter['vreg_added_on_fr']) && !empty($filter['vreg_added_on_fr'])) ?
          date('Y-m-d', strtotime($filter['vreg_added_on_fr'])) : '';

          $enq_date_to = (isset($filter['vreg_added_on_to']) && !empty($filter['vreg_added_on_to'])) ?
          date('Y-m-d', strtotime($filter['vreg_added_on_to'])) : '';
          $search = isset($filter['search']) ? $filter['search'] : '';

          if (($this->uid != ADMIN_ID) && empty($search)) {

               if (check_permission('registration', 'showmyshowroomregisters')) {

                    $this->db->where('vreg_showroom', $this->shrm);
               } else {

                    if (!check_permission('registration', 'showallregisters')) {
                         $this->db->where(array('vreg_assigned_to' => $this->uid));
                    }
                    if (check_permission('registration', 'registrationcreatedbyme')) {
                         $this->db->where(array('vreg_added_by' => $this->uid));
                    }
                    if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                         array_push($mystaffs, $this->uid);
                         $mystaffs = array_filter($mystaffs);

                         $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
                    }
                    if (check_permission('registration', 'myregmyown')) {
                         $this->db->where(array('vreg_first_owner' => $this->uid));
                    }
                    if (check_permission('registration', 'not_show_visitors_in_myregister')) {
                         $this->db->where_not_in('vreg_contact_mode', array(40));
                    }
                    if (check_permission('registration', 'serviceregisters')) {
                         $this->db->where('vreg_division', 3); // RD Care
                    }
               }
          } //dn
          if (!$assign) {
               if (!empty($filter)) {

                    if ($isPunched == '0' || $isPunched == '1') {
                         $this->db->where('vreg_is_punched', $isPunched);
                    }
                    if ($vreg_first_owner > 0) {
                         $this->db->where('vreg_first_owner', $vreg_first_owner);
                    }
                    if ($vreg_added_by > 0) {
                         $this->db->where('vreg_added_by', $vreg_added_by);
                    }

                    $type = isset($filter['type']) ? $filter['type'] : '';
                    $brd = isset($filter['vreg_brand']) ? $filter['vreg_brand'] : '';
                    $mod = isset($filter['vreg_model']) ? $filter['vreg_model'] : '';
                    $var = isset($filter['vreg_varient']) ? $filter['vreg_varient'] : '';

                    if ($type == 'ex') {
                         $this->db->where('vreg_inquiry != 0');
                    } else if ($type == 'nw') {
                         $this->db->where('vreg_inquiry = 0');
                    }

                    if ($dept > 0) {
                         $this->db->where('vreg_department', $dept);
                    }
                    if ($type > 0) {
                         $this->db->where('vreg_call_type', $type);
                    }
                    if ($mode > 0) {
                         $this->db->where('vreg_contact_mode', $mode);
                         if ($mode == 5) {
                              if ($event) {
                                   $this->db->where('vreg_event', $event);
                              }
                         }
                    }

                    if (!empty($search)) {
                         $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                         $this->db->where($whereSearch);
                    }
                    if ($brd > 0) {
                         $this->db->where($this->tbl_register_master . ".vreg_brand", $brd);
                    }
                    if ($mod > 0) {
                         $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
                    }
                    if ($var > 0) {
                         $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
                    }
                    if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                         $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
                    }
                    if ($vregDivision > 0) {
                         $this->db->where('vreg_division', $vregDivision);
                    }
                    if ($vregShowroom > 0) {
                         $this->db->where('vreg_showroom', $vregShowroom);
                    }
               }
               if (!check_permission('enquiry', 'myregshowpunchedalso')) {
                    $this->db->where('vreg_is_punched = 0');
               }
               if (!empty($enq_date_from) && !empty($enq_date_to)) {
                    $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . ') )');
               }
               if ($effective == '0' || $effective == '1') {
                    $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
               }
               if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
                    $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
               }

               $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left');
               if ($allStatus != 1) {

                    $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
                    $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
               }
               $return['count'] = $this->db->count_all_results($this->tbl_register_master);
              // return $return;//
               $selectArray = array(
                    $this->tbl_register_master . '.vreg_id',
                    $this->tbl_register_master . '.vreg_assigned_to',
                    $this->tbl_register_master . '.vreg_added_by',
                    $this->tbl_register_master . '.vreg_contact_mode',
                    $this->tbl_register_master . '.vreg_district',
                    $this->tbl_register_master . '.vreg_tsc_comments',
                    $this->tbl_register_master . '.vreg_added_on',
                    $this->tbl_register_master . '.vreg_cust_id',
                    $this->tbl_register_master . '.vreg_cust_name',
                    $this->tbl_register_master . '.vreg_cust_phone',
                    $this->tbl_register_master . '.vreg_email',
                    $this->tbl_register_master . '.vreg_cust_place',
                    $this->tbl_register_master . '.vreg_existing_vehicle',
                    $this->tbl_register_master . '.vreg_occupation',
                    $this->tbl_register_master . '.vreg_brand',
                    $this->tbl_register_master . '.vreg_model',
                    $this->tbl_register_master . '.vreg_varient',
                    $this->tbl_register_master . '.vreg_year',
                    $this->tbl_register_master . '.vreg_investment',
                    $this->tbl_register_master . '.vreg_km',
                    $this->tbl_register_master . '.vreg_customer_status',
                    $this->tbl_register_master . '.vreg_type_of_visit',
                    $this->tbl_register_master . '.vreg_tsc_comments',
                    $this->tbl_register_master . '.vreg_appointment',
                    $this->tbl_register_master . '.vreg_second_d_hpy_cal',
                    $this->tbl_register_master . '.vreg_second_d_hpy_cal',
                    $this->tbl_register_master . '.vreg_division',
                    $this->tbl_register_master . '.vreg_showroom',
                    $this->tbl_register_master . '.vreg_call_type',
                    $this->tbl_register_master . '.vreg_event',
                    $this->tbl_register_master . '.vreg_is_effective',
                    $this->tbl_register_master . '.vreg_entry_date',
                    $this->tbl_register_master . '.vreg_is_punched',
                    $this->tbl_register_master . '.vreg_customer_remark',
                    $this->tbl_register_master . '.vreg_inquiry',
                    $this->tbl_register_master . '.vreg_is_verified',
                    $this->tbl_register_master . '.vreg_next_followup',
                    $this->tbl_register_master . '.vreg_cust_place',
                    $this->tbl_register_master . '.vreg_referal_type',
                    $this->tbl_register_master . '.vreg_referal_name',
                    $this->tbl_register_master . '.vreg_referal_phone',
                    $this->tbl_register_master . '.vreg_last_action',
                    'assign.usr_first_name AS assign_usr_first_name',
                    'assign.usr_last_name AS assign_usr_last_name',
                    'assign.usr_division AS div_id', //
                    'addedby.usr_first_name AS addedby_usr_first_name',
                    'addedby.usr_last_name AS addedby_usr_last_name',
                    //'addedby.usr_division AS div_nm',//
                    'exstse.usr_username AS exstse_usr_username',
                    $this->tbl_events . '.evnt_title',
                    $this->tbl_brand . '.brd_id',
                    $this->tbl_brand . '.brd_title',
                    $this->tbl_model . '.mod_id',
                    $this->tbl_model . '.mod_title',
                    $this->tbl_variant . '.var_id',
                    $this->tbl_variant . '.var_variant_name',
                    $this->tbl_enquiry . '.enq_current_status',
                    $this->tbl_callcenterbridging . '.ccb_recording_URL',
                    $this->tbl_callcenterbridging . '.ccb_callStatus_id',
                    $this->tbl_departments . '.dep_name',
                    $this->tbl_district_statewise . '.*',
                    // $this->tbl_divisions . '.div_name'//
                    /*Customer data*/
                    $this->tbl_customer_details . '.cusd_id',
                    $this->tbl_customer_details . '.cusd_name',
                    $this->tbl_customer_details . '.cusd_phone_office',
                    $this->tbl_customer_details . '.cusd_phone_resi',
                    $this->tbl_customer_details . '.cusd_whatsapp',
                    $this->tbl_customer_details . '.cusd_email',
                    $this->tbl_customer_details . '.cusd_fb',
                    $this->tbl_customer_details . '.cusd_age',
                    $this->tbl_customer_details . '.cusd_gender',
                    $this->tbl_customer_details . '.cusd_place',
                    $this->tbl_customer_details . '.cusd_address',
                    $this->tbl_customer_details . '.cusd_address_office',
                    $this->tbl_customer_details . '.cusd_profession',
                    $this->tbl_customer_details . '.cusd_company',
                    $this->tbl_customer_details . '.cusd_district',
                    $this->tbl_customer_details . '.cusd_pin',
                    //   $this->tbl_city . '.cit_name'
                    /*End Customer data*/
               );
               $this->db->select($selectArray, false)
                    ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                    ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                    ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
                    ->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = ' . 'exstse.usr_id', 'left')
                    //->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . 'assign.usr_division', 'left')//
                    ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                    ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
                    ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left')
                    // ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_register_master . '.vreg_division', 'left');
                    /*Join Customer data*/
                    ->join($this->tbl_customer_details, $this->tbl_customer_details . '.cusd_id = ' . $this->tbl_register_master . '.vreg_cust_id', 'left');
               //->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_customer_details . '.cusd_place', 'left');
               /*End Join Customer data*/
               if (!empty($id)) {
                    //debug($id);
                    return $this->db->order_by($this->tbl_register_master . '.vreg_entry_date', 'DESC')
                         ->get_where($this->tbl_register_master, array($this->tbl_register_master . '.vreg_id' => $id))->row_array();
               }

               //$this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
               if ($limit) {
                    $this->db->limit($limit, $page);
               }
          }
          if (($this->uid != ADMIN_ID) && empty($search)) {
               if (check_permission('registration', 'showmyshowroomregisters')) {
                    $this->db->where('vreg_showroom', $this->shrm);
               } else {
                    if (!check_permission('registration', 'showallregisters')) {
                         $this->db->where(array('vreg_assigned_to' => $this->uid));
                    }
                    if (check_permission('registration', 'registrationcreatedbyme')) {
                         $this->db->where(array('vreg_added_by' => $this->uid));
                    }
                    if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                         array_push($mystaffs, $this->uid);
                         $mystaffs = array_filter($mystaffs);
                         $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
                    }
                    if (check_permission('registration', 'myregmyown')) {
                         $this->db->where(array('vreg_first_owner' => $this->uid));
                    }
                    if (check_permission('registration', 'serviceregisters')) {
                         $this->db->where('vreg_division', 3);
                    }
               }
               if (check_permission('registration', 'not_show_visitors_in_myregister')) {
                    $this->db->where_not_in('vreg_contact_mode', array(40));
               }
          }
          if (!empty($filter)) {
               if ($isPunched == '0' || $isPunched == '1') {
                    $this->db->where('vreg_is_punched', $isPunched);
               }
               if ($vreg_first_owner > 0) {
                    $this->db->where('vreg_first_owner', $vreg_first_owner);
               }
               if ($vreg_added_by > 0) {
                    $this->db->where('vreg_added_by', $vreg_added_by);
               }
               $type = isset($filter['type']) ? $filter['type'] : '';
               if ($type == 'ex') {
                    $this->db->where('vreg_inquiry != 0');
               } else if ($type == 'nw') {
                    $this->db->where('vreg_inquiry = 0');
               }
               if ($dept > 0) {
                    $this->db->where('vreg_department', $dept);
               }
               if ($type > 0) {
                    $this->db->where('vreg_call_type', $type);
               }
               if ($mode > 0) {
                    $this->db->where('vreg_contact_mode', $mode);
                    if ($mode == 5) {
                         if ($event) {
                              $this->db->where('vreg_event', $event);
                         }
                    }
               }
               if (!empty($search)) {
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                    $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                    $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }
               if ($brd > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_brand", $brd);
               }
               if ($mod > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
               }
               if ($var > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
               }
               if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
               }
               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               }
               if ($vregShowroom > 0) {
                    $this->db->where('vreg_showroom', $vregShowroom);
               }
          }
          if (!check_permission('enquiry', 'myregshowpunchedalso')) {
               $this->db->where('vreg_is_punched = 0');
          }

          if (!empty($enq_date_from) && !empty($enq_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
               'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . '))');
          }
          if ($effective == '0' || $effective == '1') {
               $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          }
          $this->db->order_by('vreg_entry_date', 'DESC');
          if ($allStatus != 1) {
               $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
               $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          }

          if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
               $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
          }
          if ($assign) {//..?
               $select = "CONCAT(" . $this->tbl_register_master . '.vreg_id' . "," . "'-'," . $this->tbl_register_master . '.vreg_cust_phone,' . "'-'," . ",addedby.usr_username) as asign";
               $this->db->select($select, false)
                    ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                    ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left');
               $return['data'] = $this->db->get($this->tbl_register_master)->result_array();
               //debug($return['data']);
          } else {
               $return['data'] = $this->db->get($this->tbl_register_master)->result_array();
          }
          // if ($this->uid == 100) {
          //      echo $this->db->last_query();
          //      debug($return['data']);
          // }

          return $return;
     }
     public function readVehicleRegEnq($id = '', $limit = 0, $page = 0, $filter = array())
     { //cpd to api 17171

          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);

          $vregDivision = isset($filter['vreg_division']) ? $filter['vreg_division'] : 0;
          $vregShowroom = isset($filter['vreg_showroom']) ? $filter['vreg_showroom'] : 0;
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
          $vreg_first_owner = isset($filter['vreg_first_owner']) ? $filter['vreg_first_owner'] : 0;
          $vreg_added_by = isset($filter['vreg_added_by']) ? $filter['vreg_added_by'] : 0;
          $dept = isset($filter['vreg_department']) ? $filter['vreg_department'] : '';
          $type = isset($filter['vreg_call_type']) ? $filter['vreg_call_type'] : '';
          $mode = isset($filter['vreg_contact_mode']) ? $filter['vreg_contact_mode'] : '';
          $event = isset($filter['vreg_event']) ? $filter['vreg_event'] : '';
          $effective = isset($filter['vreg_is_effective']) ? $filter['vreg_is_effective'] : '';
          $addedEntry = (isset($filter['added_entry']) && !empty($filter['added_entry'])) ? $filter['added_entry'] : 'vreg_added_on';
          $isPunched = (isset($filter['vreg_is_punched'])) ? $filter['vreg_is_punched'] : '';

          $enq_date_from = (isset($filter['vreg_added_on_fr']) && !empty($filter['vreg_added_on_fr'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_fr'])) : '';

          $enq_date_to = (isset($filter['vreg_added_on_to']) && !empty($filter['vreg_added_on_to'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_to'])) : '';
          $search = isset($filter['search']) ? $filter['search'] : '';

          if (($this->uid != ADMIN_ID) && empty($search)) {

               if (check_permission('registration', 'showmyshowroomregisters')) {
                    $this->db->where('vreg_showroom', $this->shrm);
               } else {
                    if (!check_permission('registration', 'showallregisters')) {
                         $this->db->where(array('vreg_assigned_to' => $this->uid));
                    }
                    if (check_permission('registration', 'registrationcreatedbyme')) {
                         $this->db->where(array('vreg_added_by' => $this->uid));
                    }
                    if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                         array_push($mystaffs, $this->uid);
                         $mystaffs = array_filter($mystaffs);
                         $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                              $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
                    }
                    if (check_permission('registration', 'myregmyown')) {
                         $this->db->where(array('vreg_first_owner' => $this->uid));
                    }
                    if (check_permission('registration', 'not_show_visitors_in_myregister')) {
                         $this->db->where_not_in('vreg_contact_mode', array(40));
                    }
               }
          }

          if (!empty($filter)) {
               if ($isPunched == 0 || $isPunched == 1) {
                    $this->db->where('vreg_is_punched', $isPunched);
               }
               if ($vreg_first_owner > 0) {
                    $this->db->where('vreg_first_owner', $vreg_first_owner);
               }
               if ($vreg_added_by > 0) {
                    $this->db->where('vreg_added_by', $vreg_added_by);
               }

               $type = isset($filter['type']) ? $filter['type'] : '';
               $brd = isset($filter['vreg_brand']) ? $filter['vreg_brand'] : '';
               $mod = isset($filter['vreg_model']) ? $filter['vreg_model'] : '';
               $var = isset($filter['vreg_varient']) ? $filter['vreg_varient'] : '';

               if ($type == 'ex') {
                    $this->db->where('vreg_inquiry != 0');
               } else if ($type == 'nw') {
                    $this->db->where('vreg_inquiry = 0');
               }

               if ($dept > 0) {
                    $this->db->where('vreg_department', $dept);
               }
               if ($type > 0) {
                    $this->db->where('vreg_call_type', $type);
               }
               if ($mode > 0) {
                    $this->db->where('vreg_contact_mode', $mode);
                    if ($mode == 5) {
                         if ($event) {
                              $this->db->where('vreg_event', $event);
                         }
                    }
               }

               if (!empty($search)) {
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }
               if ($brd > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_brand", $brd);
               }
               if ($mod > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
               }
               if ($var > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
               }
               if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
               }
               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               }
               if ($vregShowroom > 0) {
                    $this->db->where('vreg_showroom', $vregShowroom);
               }
          }
          if (!check_permission('enquiry', 'myregshowpunchedalso')) {
               $this->db->where('vreg_is_punched = 0');
          }
          if (!empty($enq_date_from) && !empty($enq_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . ') )');
          }
          if ($effective == '0' || $effective == '1') {
               $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          }
          if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
               $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
          }

          $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left');
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $return['count'] = $this->db->count_all_results($this->tbl_register_master);

          $selectArray = array(
               $this->tbl_register_master . '.*',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               'exstse.usr_username AS exstse_usr_username',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_enquiry . '.enq_current_status',
               $this->tbl_callcenterbridging . '.ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus_id',
               $this->tbl_departments . '.dep_name',
               $this->tbl_district_statewise . '.*'
          );
          $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
               ->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = ' . 'exstse.usr_id', 'left')
               ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left');

          if (!empty($id)) {
               //debug($id);
               return $this->db->order_by($this->tbl_register_master . '.vreg_entry_date', 'DESC')
                    ->get_where($this->tbl_register_master, array($this->tbl_register_master . '.vreg_inquiry' => $id))->row_array();
               //->get_where($this->tbl_register_master, array($this->tbl_register_master . '.vreg_id' => $id))->row_array();


          }
          //$this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          if (($this->uid != ADMIN_ID) && empty($search)) {
               if (check_permission('registration', 'showmyshowroomregisters')) {
                    $this->db->where('vreg_showroom', $this->shrm);
               } else {
                    if (!check_permission('registration', 'showallregisters')) {
                         $this->db->where(array('vreg_assigned_to' => $this->uid));
                    }
                    if (check_permission('registration', 'registrationcreatedbyme')) {
                         $this->db->where(array('vreg_added_by' => $this->uid));
                    }
                    if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                         array_push($mystaffs, $this->uid);
                         $mystaffs = array_filter($mystaffs);
                         $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                              $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
                    }
                    if (check_permission('registration', 'myregmyown')) {
                         $this->db->where(array('vreg_first_owner' => $this->uid));
                    }
               }
               if (check_permission('registration', 'not_show_visitors_in_myregister')) {
                    $this->db->where_not_in('vreg_contact_mode', array(40));
               }
          }
          if (!empty($filter)) {
               if ($isPunched == 0 || $isPunched == 1) {
                    $this->db->where('vreg_is_punched', $isPunched);
               }
               if ($vreg_first_owner > 0) {
                    $this->db->where('vreg_first_owner', $vreg_first_owner);
               }
               if ($vreg_added_by > 0) {
                    $this->db->where('vreg_added_by', $vreg_added_by);
               }
               $type = isset($filter['type']) ? $filter['type'] : '';
               if ($type == 'ex') {
                    $this->db->where('vreg_inquiry != 0');
               } else if ($type == 'nw') {
                    $this->db->where('vreg_inquiry = 0');
               }
               if ($dept > 0) {
                    $this->db->where('vreg_department', $dept);
               }
               if ($type > 0) {
                    $this->db->where('vreg_call_type', $type);
               }
               if ($mode > 0) {
                    $this->db->where('vreg_contact_mode', $mode);
                    if ($mode == 5) {
                         if ($event) {
                              $this->db->where('vreg_event', $event);
                         }
                    }
               }
               if (!empty($search)) {
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }
               if ($brd > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_brand", $brd);
               }
               if ($mod > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
               }
               if ($var > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
               }
               if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
               }
               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               }
               if ($vregShowroom > 0) {
                    $this->db->where('vreg_showroom', $vregShowroom);
               }
          }
          if (!check_permission('enquiry', 'myregshowpunchedalso')) {
               $this->db->where('vreg_is_punched = 0');
          }

          if (!empty($enq_date_from) && !empty($enq_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . '))');
          }
          if ($effective == '0' || $effective == '1') {
               $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          }
          $this->db->order_by('vreg_entry_date', 'DESC');
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
               $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
          }
          $return['data'] = $this->db->get($this->tbl_register_master)->result_array();

          return $return;
     }

     public function readVehicleRegReport($id = '', $limit = 0, $page = 0, $filter = array())
     {
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);

          $vreg_first_owner = isset($filter['vreg_first_owner']) ? $filter['vreg_first_owner'] : 0;
          $vreg_assigned_to = isset($filter['vreg_assigned_to']) ? $filter['vreg_assigned_to'] : 0;
          $vreg_added_by = isset($filter['vreg_added_by']) ? $filter['vreg_added_by'] : 0;

          $showallsts = isset($filter['showallsts']) ? $filter['showallsts'] : 0;
          $showenqpunch = isset($filter['vreg_is_punched']) ? $filter['vreg_is_punched'] : 0;
          $vregDivision = isset($filter['vreg_division']) ? $filter['vreg_division'] : 0;
          $vregShowroom = isset($filter['vreg_showroom']) ? $filter['vreg_showroom'] : 0;
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
          $vreg_first_owner = isset($filter['vreg_first_owner']) ? $filter['vreg_first_owner'] : 0;
          $dept = isset($filter['vreg_department']) ? $filter['vreg_department'] : '';
          $type = isset($filter['vreg_call_type']) ? $filter['vreg_call_type'] : '';
          $mode = isset($filter['vreg_contact_mode']) ? $filter['vreg_contact_mode'] : '';
          $effective = isset($filter['vreg_is_effective']) ? $filter['vreg_is_effective'] : '';
          $addedEntry = (isset($filter['added_entry']) && !empty($filter['added_entry'])) ? $filter['added_entry'] : 'vreg_added_on';

          $enq_date_from = (isset($filter['vreg_added_on_fr']) && !empty($filter['vreg_added_on_fr'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_fr'])) : '';

          $enq_date_to = (isset($filter['vreg_added_on_to']) && !empty($filter['vreg_added_on_to'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_to'])) : '';
          $search = isset($filter['search']) ? $filter['search'] : '';


          if (!empty($filter)) {

               if ($vreg_assigned_to > 0) {
                    $this->db->where('vreg_assigned_to', $vreg_assigned_to);
               }
               if ($vreg_added_by > 0) {
                    $this->db->where('vreg_added_by', $vreg_added_by);
               }
               if ($vreg_first_owner > 0) {
                    $this->db->where('vreg_first_owner', $vreg_first_owner);
               }
               $type = isset($filter['type']) ? $filter['type'] : '';
               $brd = isset($filter['vreg_brand']) ? $filter['vreg_brand'] : '';
               $mod = isset($filter['vreg_model']) ? $filter['vreg_model'] : '';
               $var = isset($filter['vreg_varient']) ? $filter['vreg_varient'] : '';

               if ($type == 'ex') {
                    $this->db->where('vreg_inquiry != 0');
               } else if ($type == 'nw') {
                    $this->db->where('vreg_inquiry = 0');
               }

               if ($dept > 0) {
                    $this->db->where('vreg_department', $dept);
               }
               if ($type > 0) {
                    $this->db->where('vreg_call_type', $type);
               }
               if ($mode > 0) {
                    $this->db->where('vreg_contact_mode', $mode);
               }

               if (!empty($search)) {
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }
               if ($brd > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_brand", $brd);
               }
               if ($mod > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
               }
               if ($var > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
               }
               if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
               }
               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               }
               if ($vregShowroom > 0) {
                    $this->db->where('vreg_showroom', $vregShowroom);
               }
          }
          if (!empty($enq_date_from) && !empty($enq_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . ') )');
          }
          if ($effective == '0' || $effective == '1') {
               $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          }
          if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
               $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
          }

          $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left');
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');

          if ($showallsts != 1) {
               $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          }
          if ($showenqpunch != 1) {
               $this->db->where('vreg_is_punched', 0);
          }

          $return['count'] = $this->db->count_all_results($this->tbl_register_master);

          $selectArray = array(
               $this->tbl_register_master . '.*',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_enquiry . '.enq_current_status',
               $this->tbl_callcenterbridging . '.ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus_id',
               $this->tbl_departments . '.dep_name',
               $this->tbl_district_statewise . '.*'
          );
          $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
               ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left');

          if (!empty($id)) {
               return $this->db->order_by($this->tbl_register_master . '.vreg_entry_date', 'DESC')
                    ->get_where($this->tbl_register_master, array($this->tbl_register_master . '.vreg_id' => $id))->row_array();
          }
          if ($limit) {
               $this->db->limit($limit, $page);
          }

          if (!empty($filter)) {
               if ($vreg_assigned_to > 0) {
                    $this->db->where('vreg_assigned_to', $vreg_assigned_to);
               }
               if ($vreg_added_by > 0) {
                    $this->db->where('vreg_added_by', $vreg_added_by);
               }
               if ($vreg_first_owner > 0) {
                    $this->db->where('vreg_first_owner', $vreg_first_owner);
               }
               $type = isset($filter['type']) ? $filter['type'] : '';
               if ($type == 'ex') {
                    $this->db->where('vreg_inquiry != 0');
               } else if ($type == 'nw') {
                    $this->db->where('vreg_inquiry = 0');
               }
               if ($dept > 0) {
                    $this->db->where('vreg_department', $dept);
               }
               if ($type > 0) {
                    $this->db->where('vreg_call_type', $type);
               }
               if ($mode > 0) {
                    $this->db->where('vreg_contact_mode', $mode);
               }
               if (!empty($search)) {
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }
               if ($brd > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_brand", $brd);
               }
               if ($mod > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
               }
               if ($var > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
               }
               if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
               }
               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               }
               if ($vregShowroom > 0) {
                    $this->db->where('vreg_showroom', $vregShowroom);
               }
          }
          if (!empty($enq_date_from) && !empty($enq_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . '))');
          }
          if ($effective == '0' || $effective == '1') {
               $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          }
          $this->db->order_by('vreg_entry_date', 'DESC');
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
          if ($showallsts != 1) {
               $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          }
          if ($showenqpunch != 1) {
               $this->db->where('vreg_is_punched', 0);
          }
          if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
               $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
          }
          $return['data'] = $this->db->get($this->tbl_register_master)->result_array();

          return $return;
     }

     function getTotalActiveStaff()
     {
          return $this->db->select('usr_username, usr_id')
               ->where("usr_username IS NOT NULL AND usr_username != ''")
               ->get_where($this->tbl_users, array('usr_active' => 1))->result_array();
     }

     function isFollowupPunched($enqId)
     {
          if (!empty($enqId)) {
               return $this->db->get_where($this->tbl_followup, array('foll_cus_id' => $enqId))->row_array();
          }
          return null;
     }

     function registerExists($phoneNo)
     {
          if (!empty($phoneNo)) {
               return $this->db->like('vreg_cust_phone', substr($phoneNo, -10), 'before')->get($this->tbl_register_master)->row_array();
          }
          return false;
     }

     function getInquiryQuestions()
     {
          /*             if ($this->uid != ADMIN_ID) {
              $this->db->where('qus_designation', $this->grp_id);
              } */
          $questions['sell'] = $this->db->order_by('qus_order')
               ->get_where($this->tbl_questions, '(qus_category = 1 AND qus_status = 1) AND (qus_type = 2 OR qus_type = 1)')
               ->result_array();
          /* echo $this->db->last_query();exit;
              if ($this->uid != ADMIN_ID) {
              $this->db->where('qus_designation', $this->grp_id);
              } */
          $questions['buy'] = $this->db->order_by('qus_order')
               ->get_where($this->tbl_questions, '(qus_category = 1 AND qus_status = 1) AND (qus_type = 3 OR qus_type = 1)')
               ->result_array();

          /*            if ($this->uid != ADMIN_ID) {
              $this->db->where('qus_designation', $this->grp_id);
              } */
          $questions['exch'] = $this->db->order_by('qus_order')
               ->get_where($this->tbl_questions, '(qus_category = 1 AND qus_status = 1) AND (qus_type = 4 OR qus_type = 1)')
               ->result_array();
          return $questions;
     }

     function addEnquiryHistory($datas)
     {
          if (!empty($datas)) {
               $this->db->insert($this->tbl_enquiry_history, $datas);
               return $this->db->insert_id();
          }
          return false;
     }

     function getBrandByDivision($divId)
     {
          return $this->db->select($this->tbl_brand . '.*, brd_id AS col_id, brd_title AS col_title')
               ->where('brd_section', $divId)->get($this->tbl_brand)->result_array();
     }

     function bindShowroomByDivision($div)
     {
          $return['associatedShowroom'] = $this->db->select($this->tbl_showroom . '.shr_id AS col_id, ' . $this->tbl_showroom . '.shr_location AS col_title')
               ->where(array('shr_division' => $div))->get($this->tbl_showroom)->result_array();

          $return['notAssociatedShowroom'] = $this->db->select($this->tbl_showroom . '.shr_id AS col_id, ' . $this->tbl_showroom . '.shr_location AS col_title')
               ->where(array('shr_division != ' => $div))->get($this->tbl_showroom)->result_array();

          $return['notAssociatedDivision'] = $this->db->select($this->tbl_divisions . '.div_id AS col_id, ' . $this->tbl_divisions . '.div_name AS col_title')
               ->where(array('div_id != ' => $div, 'div_status' => 1))->get($this->tbl_divisions)->result_array();

          $selectArray = array(
               $this->tbl_departments . '.dep_id',
               $this->tbl_departments . '.dep_name',
               $this->tbl_departments . '.dep_is_sale_rel',
               'parentDep.dep_name AS dep_parent_name'
          );

          $return['departments'] = $this->db->select($selectArray, false)->join($this->tbl_departments . ' parentDep', 'parentDep.dep_id = ' . $this->tbl_departments . '.dep_parent', 'LEFT')
               ->where(array($this->tbl_departments . '.dep_status' => 1, $this->tbl_departments . '.dep_division' => $div))
               ->get($this->tbl_departments)->result_array();

          return $return;
     }

     function updateEnquiryLastView($enqId, $who = 0)
     {
          $who = $who > 0 ? $who : $this->uid;
          $this->db->where('enq_id', $enqId)->update($this->tbl_enquiry, array('enq_last_viewd' => $who));
          return true;
     }

     function sendBackRegister()
     {
          $this->load->model('registration/registration_model', 'registration');
          if (
               isset($_POST['assignedTo']) && isset($_POST['assignedFrom']) &&
               isset($_POST['regMaster']) && isset($_POST['reason']) && isset($_POST['call_type'])
          ) {

               $assignedBy = $this->db->select('usr_username')->get_where($this->tbl_users, array('usr_id' => $_POST['assignedFrom']))->row_array();
               $assignedBy = isset($assignedBy['usr_username']) ? $assignedBy['usr_username'] : '';
               $assignedTo = $this->db->select('usr_username')->get_where($this->tbl_users, array('usr_id' => $_POST['assignedTo']))->row_array();
               $assignedTo = isset($assignedTo['usr_username']) ? $assignedTo['usr_username'] : '';
               $this->registration->addRegisterHistory(
                    array(
                         'regh_register_master' => $_POST['regMaster'],
                         'regh_assigned_by' => $_POST['assignedFrom'],
                         'regh_assigned_to' => $_POST['assignedTo'],
                         'regh_remarks' => $_POST['reason'],
                         'regh_call_type' => $_POST['call_type'],
                         'regh_system_cmd' => 'Register reassigned by ' . $assignedBy . ' to ' . $assignedTo
                    )
               );
               $this->db->where(array('vreg_id' => $_POST['regMaster']))->update($this->tbl_register_master, array(
                    'vreg_last_action' => $_POST['reason'],
                    'vreg_call_type' => $_POST['call_type'],
                    'vreg_se_commented_on' => date('Y-m-d h:i:s'),
                    'vreg_assigned_to' => $_POST['assignedTo'],
                    'vreg_added_by' => $_POST['assignedFrom']
               ));
          }
          return true;
     }

     function getQuickFollowupMaster()
     {
          if (!check_permission('enquiry', 'showallqukassgnfollwupmstr')) {
               $this->db->like($this->tbl_quick_tc_report_master . '.qtrm_assign_to', $this->uid, 'both');
          }
          if ($this->uid != ADMIN_ID) {
               $this->db->where($this->tbl_quick_tc_report_master . '.qtrm_status', 1);
          }
          return $this->db->select($this->tbl_quick_tc_report_master . '.*, ' . $this->tbl_users . '.usr_username')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report_master . '.qtrm_added_by', 'LEFT')
               ->get($this->tbl_quick_tc_report_master)->result_array();
     }

     function quickFollowupAnalysis($masterId)
     {
          $data['done'] = $this->db->where(array('qtr_reply_by > ' => 0, 'qtr_master_id' => $masterId))->count_all_results($this->tbl_quick_tc_report);
          $data['pend'] = $this->db->where(array('qtr_reply_by' => 0, 'qtr_master_id' => $masterId))->count_all_results($this->tbl_quick_tc_report);
          return $data;
     }

     function getQuickFollowupLeads($id)
     {
          $selectArray = array(
               $this->tbl_quick_tc_report . '.*',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_whatsapp',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_users . '.usr_username',
               $this->tbl_showroom . '.*'
          );
          if ($this->uid != ADMIN_ID && check_permission('enquiry', 'showonlyassigntome')) {
               $this->db->where($this->tbl_quick_tc_report . '.qtr_assigned_to', $this->uid);
          }
          $this->db->where($this->tbl_quick_tc_report . '.qtr_replay IS NULL');
          $this->db->where($this->tbl_quick_tc_report . '.qtr_master_id', $id);
          $return = $this->db->select($selectArray)
               ->join($this->tbl_enquiry, $this->tbl_quick_tc_report . '.qtr_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_quick_tc_report)->result_array();
          return $return;
     }

     function quickupdate($data)
     {
          generate_log(array(
               'log_title' => 'quickupdate',
               'log_desc' => serialize($data),
               'log_controller' => 'quick-followup',
               'log_action' => 'C',
               'log_ref_id' => 1010,
               'log_added_by' => $this->uid
          ));
          date_default_timezone_set("Asia/Calcutta");
          if ((isset($data['id']) && !empty($data['id'])) &&
               (isset($data['cmt']) && !empty(trim($data['cmt']))) &&
               (isset($data['effective']) && !empty($data['effective'])) &&
               (isset($data['enqType']) && !empty($data['enqType']))
          ) {

               $alreadyCalled = $this->db->select('qtr_reply_on')->get_where($this->tbl_quick_tc_report, array('qtr_id' => $data['id']))->row_array();
               $alreadyReplyOn = (isset($alreadyCalled['qtr_reply_on']) && !empty($alreadyCalled['qtr_reply_on'])) ?
                    $alreadyCalled['qtr_reply_on'] : date('Y-m-d h:i:s');

               $this->db->where('qtr_id', $data['id'])->update($this->tbl_quick_tc_report, array(
                    'qtr_replay' => trim($data['cmt']),
                    'qtr_reply_on' => $alreadyReplyOn,
                    'qtr_reply_by' => $this->uid,
                    'qtr_effective' => $data['effective'],
                    'qtr_type' => $data['enqType']
               ));
               return true;
          }
          return false;
     }

     function getBrandModel($enqId)
     {
          error_reporting(E_ALL);
          $vehicles = $this->db->select($this->tbl_vehicle . '.veh_id,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
               ->where($this->tbl_vehicle . '.veh_enq_id', $enqId)->get($this->tbl_vehicle)->row_array();
          $brd = isset($vehicles['brd_title']) ? $vehicles['brd_title'] : '';
          $mod = isset($vehicles['mod_title']) ? $vehicles['mod_title'] : '';
          $var = isset($vehicles['var_variant_name']) ? $vehicles['var_variant_name'] : '';
          return $brd . ', ' . $mod . ', ' . $var;
     }

     function registerTodaysanalysis()
     {
          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $tc = $this->emp_details->teleCallers();
          if (!empty($tc)) {
               foreach ($tc as $key => $value) {
                    $tc[$key]['analysis'] = $this->db->select('COUNT(*) AS cnt, vreg_contact_mode')->group_by('vreg_contact_mode')
                         ->where('DATE(' . $this->tbl_register_master . '.vreg_added_on) = ' . "DATE('" . date('Y-m-d') . "')")
                         ->where('vreg_first_owner', $value['user_id'])->get($this->tbl_register_master)->result_array();
               }
          }
          return $tc;
     }

     function searchEnquiryByDateShowroomSe($limit = 0, $page = 0, $data)
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
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          $return['count'] = $this->db->count_all_results($this->tbl_enquiry);
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
          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          if ($limit) {
               $this->db->limit($limit, $page);
          }

          $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' .
               $this->tbl_occupation . '.*, teamLead.usr_username AS teamLead')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'LEFT')
               ->join($this->tbl_users . ' teamLead', 'teamLead.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_enquiry)->result_array();
          /* echo $this->db->last_query(); */
          return $return;
     }

     function myinquiresByStatusExpExcel($data)
     {
          if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id);
          }

          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) { // Team leed
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          if (isset($data['status']) && !empty($data['status'])) {
               $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
          }
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          return $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' .
               $this->tbl_occupation . '.*, teamLead.usr_username AS teamLead')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
               ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'LEFT')
               ->join($this->tbl_users . ' teamLead', 'teamLead.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_enquiry)->result_array();
     }

     function selfregister()
     {
          $selectArray = array(
               $this->tbl_register_master . '.*',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_enquiry . '.enq_current_status',
               $this->tbl_callcenterbridging . '.ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus_id'
          );
          return $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
               ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->where('vreg_assigned_to', $this->uid)->where('(vreg_is_punched = 0 OR vreg_inquiry = 0)')
               ->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses)
               ->get($this->tbl_register_master)->result_array();
     }

     function setRegisterFollowup($data)
     {
          $follData = $data['regfoll'];
          if (!empty($follData['regf_next_folowup'])) {
               $datetime = explode(' ', $follData['regf_next_folowup']);
               $originalDateTime = $follData['regf_next_folowup'];
               $times = explode(':', $datetime[1]);
               $times = $times[0] . ':' . $times[1] . ' ' . $times[2];
               $date = isset($datetime[0]) ? date('Y-m-d', strtotime($datetime[0])) : '';
               $time = isset($datetime[1]) ? date('H:i', strtotime($times)) : '';
               $follData['regf_next_folowup'] = $date . ' ' . $time;
               $this->db->insert($this->tbl_register_followup, $follData);
               //not reach, line buzy, 

               $follCount = $this->db->select('vreg_next_followup_cont')->get_where($this->tbl_register_master, array('vreg_id' => $follData['regf_reg_id']))->row()->vreg_next_followup_cont + 1;

               $this->db->where(array('vreg_id' => $follData['regf_reg_id']))
                    ->update($this->tbl_register_master, array(
                         'vreg_next_followup' => $follData['regf_next_folowup'],
                         'vreg_next_followup_cont' => $follCount
                    ));

               $this->registration->addRegisterHistory(
                    array(
                         'regh_register_master' => $follData['regf_reg_id'],
                         'regh_assigned_by' => $data['vreg_added_by'],
                         'regh_assigned_to' => $data['vreg_assigned_to'],
                         'regh_remarks' => $follData['regf_desc'],
                         'regh_call_type' => $follData['regf_reson'],
                         'regh_system_cmd' => 'Followup register as on ' . $originalDateTime
                    )
               );

               return true;
          }
     }

     function regFollowups($regId)
     {
          return $this->db->select($this->tbl_register_followup . '.*,' . $this->tbl_users . '.usr_username')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_register_followup . '.regf_added_by', 'LEFT')
               ->order_by($this->tbl_register_followup . '.regf_next_folowup', 'DESC')
               ->get_where($this->tbl_register_followup, array($this->tbl_register_followup . '.regf_reg_id' => $regId))->result_array();
     }

     function getConnectedCallByRegister($regId)
     {
          return $this->db->select('ccb_recording_URL')->where(array('ccb_callStatus_id' => VB_CONNECTED, 'ccb_register_ref' => $regId))
               ->get($this->tbl_callcenterbridging)->row_array();
     }

     function regPendingCount($uid = 0)
     {
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
          $return = $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT')
               ->where('vreg_assigned_to', $uid)->where('(vreg_is_punched = 0 OR vreg_inquiry = 0)')
               /*                           ->where('MONTH(' . $this->tbl_register_master . '.vreg_added_on) = MONTH(CURRENT_DATE())')
                              ->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses) */
               ->get($this->tbl_register_master)->result_array();
          return $return;
     }

     function enqForpool($veh_brand = '', $veh_model = '')
     {

          if ($veh_brand && $veh_model) {
               $select = array(
                    $this->tbl_enquiry . '.enq_id',
                    $this->tbl_enquiry . '.enq_added_by',
                    $this->tbl_enquiry . '.enq_cus_name',
                    $this->tbl_enquiry . '.enq_cus_mobile',
                    $this->tbl_enquiry . '.enq_cus_whatsapp',
                    $this->tbl_enquiry . '.enq_entry_date',
                    $this->tbl_enquiry . '.enq_added_by',
                    $this->tbl_enquiry . '.enq_se_id',
                    // $this->tbl_enquiry . '.enq_mode_enq',
                    $this->tbl_enquiry . '.enq_cus_when_buy',
                    $this->tbl_users . '.usr_id as usr_id_SelExictv',
                    $this->tbl_users . '.usr_first_name AS salesExicutive',
                    $this->tbl_vehicle . '.veh_model',
                    $this->tbl_vehicle . '.veh_varient',
               );
               $return['purchase'] = $this->db->select($select)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->join($this->tbl_vehicle, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle . '.veh_enq_id', 'left')
                    ->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
                    ->where($this->tbl_enquiry . '.enq_cus_status', 2)
                    ->where($this->tbl_vehicle . '.veh_brand', $veh_brand)
                    ->where($this->tbl_vehicle . '.veh_model', $veh_model)
                    ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();

               $return['sale'] = $this->db->select($select)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->join($this->tbl_vehicle, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle . '.veh_enq_id', 'left')
                    ->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
                    ->where($this->tbl_enquiry . '.enq_cus_status', 1)
                    ->where($this->tbl_vehicle . '.veh_brand', $veh_brand)
                    ->where($this->tbl_vehicle . '.veh_model', $veh_model)
                    ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();
               echo $this->db->last_query();
               debug($return);
               return $return;
          } else {
               die('Error');
          }
     }

     function getLiveEnq()
     {

          $select = array(
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
          );
          if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id);
          }

          if (is_roo_user()) { // Admin users
          } else if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          } else if ($this->usr_grp == 'DE') { // Date entry operator
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          } else if ($this->usr_grp == 'SE') { // Seles executives
               $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
          } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) { // Team leed
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          }
          $return = $this->db->select($select)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
               ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
               ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
               ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
               ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();
          return $return;
          // debug($return);
     }

     function addOfferPrice($data)
     {
          $id = $this->db->insert($this->tbl_offer_prices, $data);
          return $id;
     }

     function staffCanAssignEnquires()
     {
          return $this->db->select(
               array(
                    $this->tbl_users . '.usr_id',
                    $this->tbl_users . '.usr_first_name',
                    $this->tbl_users . '.usr_username',
                    $this->tbl_users . '.usr_last_name',
                    $this->tbl_users_groups . '.group_id as group_id',
                    $this->tbl_groups . '.name as group_name',
                    $this->tbl_groups . '.description as group_desc',
                    $this->tbl_showroom . '.*'
               )
          )
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1))
               //->where('usr_designation_new', 12)
               ->order_by($this->tbl_users . '.usr_first_name')->get($this->tbl_users)->result_array();
     }

     function reassignenquiry($data)
     {

          $oldSE = $this->db->get_where($this->tbl_users, array('usr_id' => $data['old_se_id']))->row()->usr_first_name;
          $newSE = $this->db->get_where($this->tbl_users, array('usr_id' => $data['new_se_id']))->row()->usr_first_name;

          $newShowroom = $this->db->get_where($this->tbl_users, array('usr_id' => $data['new_se_id']))->row()->usr_showroom;
          $newDivision = $this->db->get_where($this->tbl_users, array('usr_id' => $data['new_se_id']))->row()->usr_division;

          //Sysytem comment
          $alias = 'One enquiry of ' . $oldSE . ' is re-assigned to ' . $newSE . ', re-assigned by ' . $this->session->userdata('usr_username');

          //Update enquiry
          $this->db->where('enq_id', $data['enq_id'])->update($this->tbl_enquiry, array(
               'enq_se_id' => $data['new_se_id'],
               'enq_division' => $newDivision,
               'enq_showroom_id' => $newShowroom
          ));

          //Enquiry history
          $this->addEnquiryHistory(array(
               'enh_enq_id' => $data['enq_id'],
               'enh_current_sales_executive' => $data['new_se_id'],
               'enh_source' => 1,
               'enh_remarks' => $data['remark'],
               'enh_added_by' => $this->uid,
               'enh_added_on' => date('Y-m-d H:i:s'),
               'enh_alias' => $alias
          ));

          //Foll rmark
          $this->load->model('followup/followup_model', 'followup');
          $this->followup->updateComments(array(
               'foll_remarks' => $alias,
               'foll_cus_id' => $data['enq_id'],
               'foll_parent' => 0
          ));

          //Log
          $data['comment'] = $alias;
          generate_log(array(
               'log_title' => $alias,
               'log_desc' => serialize($data),
               'log_controller' => 'reassign-enquiry',
               'log_action' => 'C',
               'log_ref_id' => $data['enq_id'],
               'log_added_by' => $this->uid
          ));
          return true;
     }

     function getQuickAssignFollAssignTo($assignto)
     {
          if (!empty($assignto)) {
               return $this->db->select('GROUP_CONCAT(usr_username) AS usr_username')
                    ->where_in('usr_id', $assignto)->get($this->tbl_users)->row()->usr_username;
          }
     }

     function getPurchaseVehicleNumber($enqId)
     {
          return $this->db->select('GROUP_CONCAT(veh_reg) AS veh_reg')->where('veh_enq_id', $enqId)
               ->get($this->tbl_vehicle)->row()->veh_reg;
     }

     function getVehicleByEnquiryId($enqId)
     {
          // $vehicle = $this->db->query("SELECT GROUP_CONCAT(IF(cpnl_vehicle_1.veh_brand=0, '', rana_brand.brd_title) , ' ',"
          //      . "IF(cpnl_vehicle_1.veh_model=0, '', rana_model.mod_title), ' ' , IF(cpnl_vehicle_1.veh_varient=0, '', rana_variant.var_variant_name)) AS vehicle "
          //      . "FROM cpnl_vehicle_1 LEFT JOIN rana_brand ON rana_brand.brd_id = cpnl_vehicle_1.veh_brand "
          //      . "LEFT JOIN rana_model ON rana_model.mod_id = cpnl_vehicle_1.veh_model "
          //      . "LEFT JOIN rana_variant ON rana_variant.var_id = cpnl_vehicle_1.veh_varient "
          //      . "WHERE cpnl_vehicle_1.veh_enq_id = " . $enqId)->row_array();
          // return isset($vehicle['vehicle']) ? $vehicle['vehicle'] : '';
          $vehicle = $this->db->query("SELECT GROUP_CONCAT(IF(cpnl_vehicle.veh_brand=0, '', rana_brand.brd_title) , ' ',"
               . "IF(cpnl_vehicle.veh_model=0, '', rana_model.mod_title), ' ' , IF(cpnl_vehicle.veh_varient=0, '', rana_variant.var_variant_name)) AS vehicle "
               . "FROM cpnl_vehicle LEFT JOIN rana_brand ON rana_brand.brd_id = cpnl_vehicle.veh_brand "
               . "LEFT JOIN rana_model ON rana_model.mod_id = cpnl_vehicle.veh_model "
               . "LEFT JOIN rana_variant ON rana_variant.var_id = cpnl_vehicle.veh_varient "
               . "WHERE cpnl_vehicle.veh_enq_id = " . $enqId)->row_array();
          return isset($vehicle['vehicle']) ? $vehicle['vehicle'] : '';
     }

     function getProfession()
     {
          return $this->db->select('*')
               ->get($this->tbl_occupation)->result_array();
     }

     function getProfessionCategory()
     {
          return $this->db->select('*')
               ->get($this->tbl_occupation_category)->result_array();
     }

     function getpurposeOfPurchase()
     {
          return $this->db->select('*')
               ->get($this->tbl_purpose_of_purchase)->result_array();
     }

     function storeReqVeh($data, $noOfSale, $enquiryId, $enq_se_id = '')
     {
          $showroom = get_logged_user('usr_showroom');
          for ($i = 0; $i < $noOfSale; $i++) {
               $req['veh_enq_id'] = $enquiryId;
               $req['veh_status'] = 1; //sell-1,buy=2
               $req['veh_brand'] = isset($data['veh_brand'][$i]) ? $data['veh_brand'][$i] : 0;
               $req['veh_model'] = isset($data['veh_model'][$i]) ? $data['veh_model'][$i] : 0;
               $req['veh_varient'] = isset($data['veh_varient'][$i]) ? $data['veh_varient'][$i] : 0;
               $req['veh_fuel'] = $data['veh_fuel'][$i];
               $req['veh_color'] = $data['veh_color'][$i];
               $req['veh_exptd_date_purchase'] = $data['veh_exptd_date_purchase'][$i];
               $req['veh_price_id'] = empty($data['veh_price_id'][$i]) ? 0 : $data['veh_price_id'][$i];
               $req['veh_prefer_no'] = $data['veh_prefer_number'][$i];
               $req['veh_year'] = empty($data['veh_year'][$i]) ? 0 : $data['veh_year'][$i];
               $req['veh_km_id'] = empty($data['veh_km_id'][$i]) ? 0 : $data['veh_km_id'][$i];
               $req['veh_remarks'] = empty($data['veh_remarks'][$i]) ? 0 : $data['veh_remarks'][$i];
               $req['veh_manf_year_from'] = empty($data['veh_manf_year_from'][$i]) ? 0 : $data['veh_manf_year_from'][$i];
               $req['veh_manf_year_to'] = empty($data['veh_manf_year_to'][$i]) ? 0 : $data['veh_manf_year_to'][$i];
               $req['veh_type'] = 1; //required
               $req['veh_added_by'] = $this->uid;
               if (!empty($showroom)) {
                    $req['veh_showroom_id'] = $showroom;
               }
               if (isset($data['veh_id'][$i]) && !empty($data['veh_id'][$i])) {
                    $this->db->where('veh_id', $data['veh_id'][$i]);
                    $this->db->update($this->tbl_vehicle, $req);
               } else {
                    $this->db->insert($this->tbl_vehicle, $req);
               }
               /*  $vehId = $this->db->insert_id();
                   if (isset($data['followup']) && !empty($data['followup'])) {
                   $data['followup']['foll_cus_id'] = $enquiryId;
                   $data['followup']['foll_cus_vehicle_id'] = $vehId;
                   $this->followup->addFollowUp($data['followup']);
                   } */

               if (isset($data['veh_color'][$i]) && !empty($data['veh_color'][$i])) {
                    $PrfColorData = array(
                         'prf_key' => '1',
                         'prf_value' => $data['vehicle']['veh_color'][$i],
                         'prf_description' => 'Submited from Enquiry form',
                         'prf_enq_id' => $enquiryId,
                         'prf_addded_by' => $this->uid,
                         'prf_added_on' => date("Y-m-d H:i:s"),
                         'prf_showoom' => $this->shrm
                    );
                    $this->db->insert('cpnl_enq_prefrences', $PrfColorData);
                    $PrfColorData['proc_id'] = $this->db->insert_id();
                    generate_log(array(
                         'log_title' => 'New preference',
                         'log_desc' => serialize($PrfColorData),
                         'log_controller' => 'new-preference',
                         'log_action' => 'C',
                         'log_ref_id' => $PrfColorData['proc_id'],
                         'log_added_by' => $this->uid
                    ));
               }
               if (isset($data['veh_prefer_number'][$i]) && !empty($data['veh_prefer_number'][$i])) {
                    $PrfNumberData = array(
                         'prf_key' => '1',
                         'prf_value' => $data['veh_prefer_number'][$i],
                         'prf_description' => 'Submited from Enquiry form',
                         'prf_enq_id' => $enquiryId,
                         'prf_addded_by' => $this->uid,
                         'prf_added_on' => date("Y-m-d H:i:s"),
                         'prf_showoom' => $this->shrm
                    );
                    $this->db->insert('cpnl_enq_prefrences', $PrfNumberData);
                    $PrfNumberData['proc_id'] = $this->db->insert_id();
                    generate_log(array(
                         'log_title' => 'New preference',
                         'log_desc' => serialize($PrfNumberData),
                         'log_controller' => 'new-preference',
                         'log_action' => 'C',
                         'log_ref_id' => $PrfNumberData['proc_id'],
                         'log_added_by' => $this->uid
                    ));
               }
               /*Procurement request*/

               if ((isset($data['proc_purchase_prd'][$i]) && !empty($data['proc_purchase_prd'][$i])) &&
                    isset($data['proc_desc'][$i]) && !empty($data['proc_desc'][$i])
               ) {
                    $procreq['enq_se_id'] = $enq_se_id;
                    $procreq['enq_id'] = $enquiryId;
                    $procreq['brand'] = isset($req['veh_brand']) ? $req['veh_brand'] : 0;
                    $procreq['model'] = isset($req['veh_model']) ? $req['veh_model'] : 0;
                    $procreq['variant'] = isset($req['veh_varient']) ? $req['veh_varient'] : 0;
                    $procreq['purchase_prd'] = $data['proc_purchase_prd'][$i];
                    $procreq['descriptin'] = $data['proc_desc'][$i];

                    $procreq['proc_id'] = $procId = $this->followup->addProcReq($procreq);
                    generate_log(array(
                         'log_title' => 'New purchase procurement request',
                         'log_desc' => serialize($procreq),
                         'log_controller' => 'new-proc-req-frm-enq',
                         'log_action' => 'C',
                         'log_ref_id' => $procId,
                         'log_added_by' => $this->uid
                    ));
               }
          }

          return true;
     }

     function storePitchedVeh($data, $noOfPitched, $enquiryId)
     {
          $showroom = get_logged_user('usr_showroom');
          for ($i = 0; $i < $noOfPitched; $i++) {
               $pitched['veh_enq_id'] = $enquiryId;
               $pitched['veh_status'] = 1;
               $pitched['veh_stock_id'] = $data['veh_val_id'][$i];
               //$pitched['veh_exch_cus_expect'] = $data['veh_customer_offer'][$i];
               //$pitched['veh_exch_cus_expect'] = empty($data['vehicle']['pitched']['veh_customer_offer'][$i]) ? 0 : $data['vehicle']['pitched']['veh_customer_offer'][$i];
               $pitched['veh_exch_cus_expect'] = empty($data['veh_customer_offer'][$i]) ? 0 : $data['veh_customer_offer'][$i];
               $pitched['veh_remarks'] = $data['veh_remarks'][$i];
               $pitched['veh_tl_remarks'] = $data['veh_tl_remarks'][$i];
               $pitched['veh_sm_remarks'] = $data['veh_sm_remarks'][$i];
               $pitched['veh_gm_remarks'] = $data['veh_gm_remarks'][$i];
               $pitched['veh_type'] = 3;
               $pitched['veh_added_by'] = $this->uid;
               if (!empty($showroom)) {
                    $sale['veh_showroom_id'] = $showroom;
               }
               // $this->db->insert($this->tbl_vehicle, $pitched);
               if (isset($data['veh_id'][$i]) && !empty($data['veh_id'][$i])) {
                    $this->db->where('veh_id', $data['veh_id'][$i]);
                    $this->db->update($this->tbl_vehicle, $pitched);
               } else {
                    $this->db->insert($this->tbl_vehicle, $pitched);
               }
          }
          return true;
     }

     function storeExistingVeh($data, $noOfExisting, $enquiryId)
     {
          $showroom = get_logged_user('usr_showroom');
          for ($i = 0; $i < $noOfExisting; $i++) {
               $existing['veh_enq_id'] = $enquiryId;
               $existing['veh_status'] = 0;
               $existing['veh_brand'] = isset($data['veh_brand'][$i]) ? $data['veh_brand'][$i] : 0;
               $existing['veh_model'] = isset($data['veh_model'][$i]) ? $data['veh_model'][$i] : 0;
               $existing['veh_varient'] = isset($data['veh_varient'][$i]) ? $data['veh_varient'][$i] : 0;
               $existing['veh_fuel'] = $data['veh_fuel'][$i];
               $existing['veh_color'] = $data['veh_color'][$i];
               $existing['veh_km_from'] = empty($data['veh_km_from'][$i]) ? 0 : $data['veh_km_from'][$i];
               $existing['veh_exchange_intrested'] = empty($data['exchange_intrested'][$i]) ? 0 : $data['exchange_intrested'][$i];
               $existing['veh_exch_dealer_value'] = empty($data['market_value'][$i]) ? 0 : $data['market_value'][$i];
               $existing['veh_exch_estimate'] = empty($data['our_offer'][$i]) ? 0 : $data['our_offer'][$i];
               $existing['veh_exch_cus_expect'] = empty($data['veh_exch_cus_expect'][$i]) ? 0 : $data['veh_exch_cus_expect'][$i]; //db Customer expectation
               $existing['veh_insurance_validity'] = $data['insurance_validity'][$i];
               $existing['veh_tyre_condition'] = $data['tyre_condition'][$i];
               $existing['veh_remarks'] = $data['veh_remarks'][$i];
               $existing['veh_manf_year'] = empty($data['veh_manf_year'][$i]) ? 0 : $data['veh_manf_year'][$i];
               $existing['veh_reg'] = $data['veh_reg1'][$i] . '-' . $data['veh_reg2'][$i] . '-' . $data['veh_reg3'][$i] . '-' . $data['veh_reg4'][$i];
               $existing['veh_owner'] = empty($data['veh_owner'][$i]) ? 0 : $data['veh_owner'][$i];
               $existing['veh_type'] = 2; //Existing
               $existing['veh_added_by'] = $this->uid;
               if (!empty($showroom)) {
                    $sale['veh_showroom_id'] = $showroom;
               }
               if (isset($data['veh_id'][$i]) && !empty($data['veh_id'][$i])) {
                    $this->db->where('veh_id', $data['veh_id'][$i]);
                    $this->db->update($this->tbl_vehicle, $existing);
               } else {
                    $this->db->insert($this->tbl_vehicle, $existing);
               }
          }
     }

     function storePurchaseVeh($data, $noOfBuy, $enquiryId, $enquiry)
     {
          // if($this->uid==100){
          //      debug($data);
          //     if (isset($data['val_id'])) {
          //      debug('upd');

          // } else { //Newly added vehicle
          //     debug('new111');

          // }

          // }

          // $valuationDetails['val_hypo_bank'] = !empty($data['bank'][0]) ? $data['bank'][0] :0;
          //debug($valuationDetails['val_hypo_bank']);//$data['val_hypo_close_by_cust'][$i]
          //  debug($data['veh_id']);
          //debug($valId);
          //$data['enquiry']['enq_cus_name']
          // debug($enquiry['enq_cus_name']);
          // exit;
          $showroom = get_logged_user('usr_showroom');
          for ($i = 0; $i < $noOfBuy; $i++) {
               $buy['veh_enq_id'] = $enquiryId;
               $buy['veh_status'] = 2;
               $buy['veh_type'] = 0;
               $buy['veh_brand'] = isset($data['veh_brand'][$i]) ? $data['veh_brand'][$i] : 0;
               $buy['veh_model'] = isset($data['veh_model'][$i]) ? $data['veh_model'][$i] : 0;
               $buy['veh_varient'] = isset($data['veh_varient'][$i]) ? $data['veh_varient'][$i] : 0;
               $buy['veh_fuel'] = $data['veh_fuel'][$i];
               $buy['veh_year'] = empty($data['veh_year'][$i]) ? 0 : $data['veh_year'][$i];
               $buy['veh_color'] = $data['veh_color'][$i];
               //$buy['veh_price_from'] = empty($data['vehicle']['buy']['veh_price_from'][$i]) ? 0 : $data['vehicle']['buy']['veh_price_from'][$i];
               //$buy['veh_price_to'] = empty($data['vehicle']['buy']['veh_price_to'][$i]) ? 0 : $data['vehicle']['buy']['veh_price_to'][$i];
               $buy['veh_price_id'] = empty($data['veh_price_id'][$i]) ? 0 : $data['veh_price_id'][$i];
               $buy['veh_km_from'] = empty($data['veh_km_from'][$i]) ? 0 : $data['veh_km_from'][$i];
               //$buy['veh_km_to'] = empty($data['vehicle']['buy']['veh_km_to'][$i]) ? 0 : $data['vehicle']['buy']['veh_km_to'][$i];
               //$buy['veh_km_id'] = empty($data['vehicle']['buy']['veh_km_id'][$i]) ? 0 : $data['vehicle']['buy']['veh_km_id'][$i];
               $buy['veh_chassis_number'] = isset($data['veh_chassis_number'][$i]) ? $data['veh_chassis_number'][$i] : 0;
               $buy['veh_reg'] = $data['veh_reg1'][$i] . '-' . $data['veh_reg2'][$i] . '-' . $data['veh_reg3'][$i] . '-' . $data['veh_reg4'][$i];
               $buy['veh_owner'] = $data['veh_owner'][$i];
               $buy['veh_remarks'] = $data['veh_remarks'][$i];
               //
               $buy['veh_color_in_rc'] = $data['veh_color_in_rc'][$i] ? $data['veh_color_in_rc'][$i] : 0;
               $buy['veh_delivery_location'] = $data['veh_delivery_location'][$i];
               $buy['veh_delivery_state'] = $data['veh_delivery_state'][$i];
               $buy['veh_comprossr'] = $data['veh_comprossr'][$i];
               $buy['veh_dealership'] = $data['veh_dealership'][$i];
               $buy['veh_re_reg'] = $data['veh_re_reg'][$i];
               //
               //$buy['veh_exch_cus_expect'] = !empty($data['vehicle']['buy']['veh_exch_cus_expect'][$i]) ? $data['vehicle']['buy']['veh_exch_cus_expect'][$i] : 0;
               // $buy['veh_exch_estimate'] = !empty($data['vehicle']['buy']['veh_exch_estimate'][$i]) ? $data['vehicle']['buy']['veh_exch_estimate'][$i] : 0;
               //$buy['veh_exch_dealer_value'] = !empty($data['vehicle']['buy']['veh_exch_dealer_value'][$i]) ? $data['vehicle']['buy']['veh_exch_dealer_value'][$i] : 0;

               $buy['veh_first_reg'] = !empty($data['veh_first_reg'][$i]) ? date('Y-m-d', strtotime($data['veh_first_reg'][$i])) : 0;
               $buy['veh_delivery_date'] = !empty($data['veh_delivery_date'][$i]) ? date('Y-m-d', strtotime($data['veh_delivery_date'][$i])) : 0;
               $buy['veh_manf_year'] = !empty($data['veh_manf_year'][$i]) ? $data['veh_manf_year'][$i] : 0;
               $buy['veh_ac'] = !empty($data['veh_ac'][$i]) ? $data['veh_ac'][$i] : 0;
               $buy['veh_ac_zone'] = !empty($data['veh_ac_zone'][$i]) ? $data['veh_ac_zone'][$i] : 0;
               $buy['veh_cc'] = !empty($data['veh_cc'][$i]) ? $data['veh_cc'][$i] : 0;
               $buy['veh_vehicle_type'] = !empty($data['veh_vehicle_type'][$i]) ? $data['veh_vehicle_type'][$i] : 0;
               $buy['veh_engine_num'] = !empty($data['veh_engine_num'][$i]) ? $data['veh_engine_num'][$i] : 0;
               $buy['veh_transmission'] = !empty($data['veh_transmission'][$i]) ? $data['veh_transmission'][$i] : 0;
               $buy['veh_seat_no'] = !empty($data['veh_seat_no'][$i]) ? $data['veh_seat_no'][$i] : 0;

               $buy['veh_added_by'] = $this->uid;
               $buy['veh_showroom_id'] = $showroom;
               $buy['veh_stock_id'] = isset($data['is_stock_veh'][$i]) ? $data['val_id'][$i] : 0;
               // unset($data['is_stock_veh'][$i]);
               $buy['veh_type'] = 0;
               //  $this->db->insert($this->tbl_vehicle, $buy);
               // $vehId = $this->db->insert_id();
               if (isset($data['veh_id'][$i]) && !empty($data['veh_id'][$i])) {
                    $vehId = $data['veh_id'][$i];
                    // $buy['check'] = 'Old';
                    $this->db->where('veh_id', $data['veh_id'][$i]);
                    $this->db->update($this->tbl_vehicle, $buy);
               } else {
                    // $buy['check'] = 'New';
                    $this->db->insert($this->tbl_vehicle, $buy);
                    $vehId = $this->db->insert_id();
               }

               //                                   if (isset($data['followup']) && !empty($data['followup'])) {
               //                                        $data['followup']['foll_cus_id'] = $enquiryId;
               //                                        $data['followup']['foll_cus_vehicle_id'] = $vehId;
               //                                        $this->followup->addFollowUp($data['followup']);
               //                                   }
               $valuationDetails['val_vehicle_id'] = $vehId;
               $valuationDetails['val_enquiry_id'] = $enquiryId;
               $valuationDetails['val_veh_no'] = isset($buy['veh_reg']) ? str_replace('-', '', $buy['veh_reg']) : '';
               $valuationDetails['val_showroom'] = $showroom;
               $valuationDetails['val_division'] = $this->div;
               $valuationDetails['val_brand'] = $buy['veh_brand'];
               $valuationDetails['val_model'] = $buy['veh_model'];
               $valuationDetails['val_variant'] = $buy['veh_varient'];
               $valuationDetails['val_fuel'] = $buy['veh_fuel'];
               $valuationDetails['val_color'] = $buy['veh_color'];
               $valuationDetails['val_chasis_no'] = $buy['veh_chassis_number'];
               $valuationDetails['val_added_by'] = $this->uid;

               $valuationDetails['val_type'] = 3;
               $valuationDetails['val_km'] = !empty($buy['veh_km_from']) ? $buy['veh_km_from'] : $buy['veh_km_to'];

               $valuationDetails['val_model_year'] = $buy['veh_year'];
               $valuationDetails['val_delv_date'] = !empty($buy['veh_delivery_date']) ? date('Y-m-d', strtotime($buy['veh_delivery_date'])) : NULL;
               $valuationDetails['val_reg_date'] = !empty($buy['veh_first_reg']) ? date('Y-m-d', strtotime($buy['veh_first_reg'])) : NULL;
               $valuationDetails['val_minif_year'] = $buy['veh_manf_year'];
               $valuationDetails['val_ac'] = $buy['veh_ac'];
               $valuationDetails['val_ac_zone'] = $buy['veh_ac_zone'];
               $valuationDetails['val_eng_cc'] = $buy['veh_cc'];
               $valuationDetails['val_veh_type'] = $buy['veh_vehicle_type'];
               $valuationDetails['val_model_year'] = $buy['veh_year'];
               $valuationDetails['val_engine_no'] = $buy['veh_engine_num'];
               $valuationDetails['val_transmission'] = $buy['veh_transmission'];
               $valuationDetails['val_no_of_seats'] = $buy['veh_seat_no'];
               //$valuationDetails['val_delv_date'] = !empty($buy['veh_delivery_date']) ? date('Y-m-d', strtotime($buy['veh_delivery_date'])) :'';
               //$valuationDetails['val_reg_date'] = !empty($buy['veh_first_reg']) ? date('Y-m-d', strtotime($buy['veh_first_reg'])) : '';
               $valuationDetails['val_cust_name'] = isset($enquiry['enq_cus_name']) ? $enquiry['enq_cus_name'] : '';
               $valuationDetails['val_cust_phone'] = isset($enquiry['enq_cus_mobile']) ? $enquiry['enq_cus_mobile'] : '';
               $valuationDetails['val_cust_email'] = isset($enquiry['enq_cus_email']) ? $enquiry['enq_cus_email'] : '';
               $valuationDetails['val_cust_source'] = isset($enquiry['enq_mode_enq']) ? $enquiry['enq_mode_enq'] : '';
               $valuationDetails['val_veh_color_in_rc'] = $data['veh_color_in_rc'][$i];
               //   $valuationDetails['val_veh_delivery_location'] = $data['veh_delivery_location'][$i];
               //   $valuationDetails['val_veh_delivery_state'] = $data['veh_delivery_state'][$i];
               //   $valuationDetails['val_veh_comprossr'] = $data['veh_comprossr'][$i];
               //   $valuationDetails['val_veh_dealership'] = $data['veh_dealership'][$i];
               $valuationDetails['val_first_dlvry_location'] = $data['veh_delivery_location'][$i];
               $valuationDetails['val_first_dlvry_state'] = $data['veh_delivery_state'][$i];
               $valuationDetails['val_ac_compressor'] = !empty($data['veh_comprossr'][$i]) ? $data['veh_comprossr'][$i] : 0;
               $valuationDetails['val_first_dlvry_dlrship'] = !empty($data['veh_dealership'][$i]) ? $data['veh_dealership'][$i] : 0;
               $valuationDetails['val_veh_re_reg'] = !empty($data['veh_re_reg'][$i]) ? $data['veh_re_reg'][$i] : 0;

               $vhNum = (isset($buy['veh_reg']) && !empty($buy['veh_reg'])) ? explode('-', str_replace(' ', '-', $buy['veh_reg'])) : '';
               $valuationDetails['val_prt_1'] = isset($vhNum['0']) ? strtoupper(trim($vhNum['0'])) : '';
               $valuationDetails['val_prt_2'] = isset($vhNum['1']) ? strtoupper(trim($vhNum['1'])) : '';
               $valuationDetails['val_prt_3'] = isset($vhNum['2']) ? strtoupper(trim($vhNum['2'])) : '';
               $valuationDetails['val_prt_4'] = isset($vhNum['3']) ? strtoupper(trim($vhNum['3'])) : '';
               $valuationDetails['val_insurance_company'] = isset($data['insurance_company'][$i]) ? $data['insurance_company'][$i] : '';
               $valuationDetails['val_insurance_comp_date'] = !empty($data['valid_up_to'][$i]) ? date('Y-m-d', strtotime($data['valid_up_to'][$i])) : NULL; //isset($data['vehicle']['buy']['valid_up_to'][$i]) ? $data['vehicle']['buy']['valid_up_to'][$i] : '';
               $valuationDetails['val_insurance_ll_date'] = !empty($data['val_insurance_ll_date'][$i]) ? date('Y-m-d', strtotime($data['val_insurance_ll_date'][$i])) : NULL; //isset($data['vehicle']['buy']['val_insurance_ll_date'][$i]) ? $data['vehicle']['buy']['val_insurance_ll_date'][$i] : '';
               $valuationDetails['val_insurance_comp_idv'] = !empty($data['idv'][$i]) ? $data['idv'][$i] : 0;
               //debug($valuationDetails['val_insurance_comp_idv']);
               $valuationDetails['val_insurance_ll_idv'] = !empty($data['ncb_percentage'][$i]) ? $data['ncb_percentage'][$i] : 0;
               //$valuationDetails['val_insurance_need_ncb'] = isset($data['vehicle']['buy']['ncb_req'][$i]) ? $data['vehicle']['buy']['ncb_req'][$i] : '';
               $valuationDetails['val_insurance_need_ncb'] = $data['ncb_req'][0] ? 1 : 0;
               $valuationDetails['val_insurance'] = !empty($data['insurance_type'][$i]) ? $data['insurance_type'][$i] : 0;
               //hypothication
               $valuationDetails['val_hypo_bank'] = !empty($data['bank'][$i]) ? $data['bank'][$i] : 0;
               $valuationDetails['val_hypo_bank_branch'] = !empty($data['bank_branch'][$i]) ? $data['bank_branch'][$i] : NULL;
               //$valuationDetails['val_hypo_close_by_cust'] = isset($data['vehicle']['buy']['val_hypo_close_by_cust'][$i]) ? $data['vehicle']['buy']['val_hypo_close_by_cust'][$i] : '';
               $valuationDetails['val_hypo_loan_date'] = !empty($data['loan_starting_date'][$i]) ? date('Y-m-d', strtotime($data['loan_starting_date'][$i])) : NULL; //isset($data['vehicle']['buy']['loan_starting_date'][$i]) ? $data['vehicle']['buy']['loan_starting_date'][$i] : '';
               $valuationDetails['val_hypo_loan_end_date'] = !empty($data['loan_ending_date'][$i]) ? date('Y-m-d', strtotime($data['loan_ending_date'][$i])) : NULL; //isset($data['vehicle']['buy']['loan_ending_date'][$i]) ? $data['vehicle']['buy']['loan_ending_date'][$i] : '';
               $valuationDetails['val_hypo_daily_int'] = !empty($data['daily_interest'][$i]) ? $data['daily_interest'][$i] : NULL;
               $valuationDetails['val_hypo_frclos_val'] = !empty($data['forclousure_value'][$i]) ? $data['forclousure_value'][$i] : NULL;
               $valuationDetails['val_hypo_frclos_val'] = !empty($data['forclousure_value'][$i]) ? $data['forclousure_value'][$i] : NULL;
               $valuationDetails['val_hypo_frclos_date'] = !empty($data['forclousure_date'][$i]) ? date('Y-m-d', strtotime($data['forclousure_date'][$i])) : NULL; //isset($data['vehicle']['buy']['forclousure_date'][$i]) ? $data['vehicle']['buy']['forclousure_date'][$i] : '';
               $valuationDetails['val_top_up_loan'] = isset($data['any_top_up_loan'][$i]) ? 1 : 0;
               $valuationDetails['val_hypo_close_by_cust'] = isset($data['val_hypo_close_by_cust'][$i]) ? 1 : 0;
               $valuationDetails['val_hypo_loan_amt'] = !empty($data['loan_amount'][$i]) ? $data['loan_amount'][$i] : 0;
               // if($this->uid==100){
               //      debug('oookkk');
               // }
               if (isset($data['val_id'][$i]) && $data['val_id'][$i] != '') { //Check if Selected already added vehicle from the select box
                    // if($this->uid==100 || $this->uid==358 ){
                    //      debug('upd0101');

                    // }

                    //debug($data['val_id'][$i]);
                    $this->db->where('val_id', $data['val_id'][$i]);
                    //$this->db->update($this->tbl_valuation, ['val_enquiry_id' => $enquiryId]);
                    $this->db->update($this->tbl_valuation, $valuationDetails);
               } else { //Newly added vehicle

                    // if($this->uid==100 || $this->uid==358){
                    //      debug('new0101');
                    //      debug($valuationDetails);
                    // }

                    $valuationDetails['val_status'] = 0;
                    $this->db->insert($this->tbl_valuation, $valuationDetails);
               }
          }
     }

     function matchingInquiry($phoneNo)
     {
          if (!empty($phoneNo)) {
               $cusMobile = substr($phoneNo, -10);
               $this->db->select($this->tbl_enquiry . '.enq_id,');
               //->where_in('enq_current_status', $this->myEnqStatuses)
               $data = $this->db->like('enq_cus_mobile', $cusMobile, 'before')->get($this->tbl_enquiry)->row_array();
               if (isset($data['enq_id'])) {
                    return $data['enq_id'];
               }
               return false;
          }
          return false;
     }

     function purchase_enq_ajaxOld($postDatas, $filterDatas)
     {

          /* $draw = $postDatas['draw'];
              $row = $postDatas['start'];
              $rowperpage = $postDatas['length']; // Rows display per page
              $columnIndex = $postDatas['order'][0]['column']; // Column index
              $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
              $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
              $searchValue = $postDatas['search']['value']; // Search value */

          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value
          //echo 'rowpag'.$rowperpage;
          //echo '<br> row'.$row;
          //exit;
          $totalRecords = $this->db->count_all_results($this->tbl_valuation);

          //-----------------------------------------------------------------------------------------
          $whr = array($this->tbl_vehicle . '.veh_status' => 2, $this->tbl_vehicle . '.veh_type' => 0, $this->tbl_vehicle . '.veh_enq_type_old' => NULL);
          $enq = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_occupation . '.*,' . $this->tbl_city . '.*,'
               . $this->tbl_district . '.*,' . $this->tbl_state . '.*,' . $this->tbl_country . '.*,' . $this->tbl_register_master . '.vreg_contact_mode,' . $this->tbl_register_master . '.vreg_is_punched,' . $this->tbl_register_master . '.vreg_call_type,' . $this->tbl_register_master . '.vreg_cust_place,' . $this->tbl_register_master . '.vreg_cust_phone,'
               . ',tb_reg_brand.brd_title as reg_brd_title,' . 'tb_reg_model.mod_title as reg_mod_title,' . 'tb_reg_variant.var_variant_name as reg_variant_name,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
               . $this->tbl_vehicle . '.veh_brand,' . $this->tbl_vehicle . '.veh_model,' . $this->tbl_vehicle . '.veh_varient,' . $this->tbl_vehicle . '.veh_first_reg,' . $this->tbl_vehicle . '.veh_km_from,' . $this->tbl_vehicle . '.veh_id,' . $this->tbl_vehicle . '.veh_reg,' . $this->tbl_vehicle . '.veh_owner,' . $this->tbl_vehicle . '.veh_color,'
               . $this->tbl_vehicle . '.veh_transmission,' . $this->tbl_vehicle . '.veh_fuel,' . $this->tbl_vehicle_colors . '.vc_color,') //. $this->tbl_valuation . '.val_id,'
               ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
               ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
               ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
               ->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_inquiry = ' . $this->tbl_enquiry . '.enq_id', 'left')
               ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
               ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
               ->join($this->tbl_brand . ' tb_reg_brand', 'tb_reg_brand.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'LEFT')
               ->join($this->tbl_model . ' tb_reg_model', 'tb_reg_model.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT')
               ->join($this->tbl_variant . ' tb_reg_variant', 'tb_reg_variant.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'LEFT')
               //$this->tbl_valuation = TABLE_PREFIX . 'valuation';val_vehicle_id
               //->join($this->tbl_model . ' tb_reg_model', 'tb_reg_model.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT')
               //             ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
               //($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
               // ->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
               ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               //->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_valuation . '.val_vehicle_id', 'LEFT')
               //->join($this->tbl_model . ' tb_reg_model', 'tb_reg_model.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT')
               // ->join($this->tbl_vehicle . ' tb_vehc', 'tb_vehc.veh_id = ' . $this->tbl_valuation . '.val_vehicle_id', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
               ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_vehicle . '.veh_color', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($whr)->where($this->tbl_enquiry . '.enq_cus_status', 2);

          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
               //$this->db->limit(limit,offset);
          }
          $data = $this->db->get($this->tbl_enquiry)->result_array();
          $str = $this->db->last_query();
          // debug($str);
          $totalRecordwithFilter = 100;
          #Response
          // debug($data);
          $totalRecordwithFilter = 100;
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;
     }

     function purchase_enq_ajax($postDatas, $filterDatas)
     {

          /* $draw = $postDatas['draw'];
              $row = $postDatas['start'];
              $rowperpage = $postDatas['length']; // Rows display per page
              $columnIndex = $postDatas['order'][0]['column']; // Column index
              $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
              $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
              $searchValue = $postDatas['search']['value']; // Search value */

          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value
          //echo 'rowpag'.$rowperpage;
          //echo '<br> row'.$row;
          //exit;
          $totalRecords = $this->db->count_all_results($this->tbl_valuation);

          //-----------------------------------------------------------------------------------------
          $whr = array($this->tbl_vehicle . '.veh_status' => 2, $this->tbl_vehicle . '.veh_type' => 0, $this->tbl_vehicle . '.veh_enq_type_old' => NULL);
          $enq = $this->db->select($this->tbl_enquiry . '.enq_id ,' . $this->tbl_enquiry . '.enq_cus_name ,' . $this->tbl_enquiry . '.enq_cus_when_buy ,' . $this->tbl_city . '.cit_name,'
               . $this->tbl_district . '.std_district_name,' . $this->tbl_register_master . '.vreg_contact_mode,' . $this->tbl_register_master . '.vreg_cust_phone,' . $this->tbl_register_master . '.vreg_cust_place,' . $this->tbl_register_master . '.vreg_is_punched,' . $this->tbl_register_master . '.vreg_call_type,'
               . ',tb_reg_brand.brd_title as reg_brd_title,' . 'tb_reg_model.mod_title as reg_mod_title,' . 'tb_reg_variant.var_variant_name as reg_variant_name,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
               . $this->tbl_vehicle . '.veh_brand,' . $this->tbl_vehicle . '.veh_model,' . $this->tbl_vehicle . '.veh_varient,' . $this->tbl_vehicle . '.veh_id,' . $this->tbl_vehicle . '.veh_color,' . $this->tbl_vehicle . '.veh_owner,' . $this->tbl_vehicle . '.veh_fuel,' . $this->tbl_vehicle . '.veh_reg,' . $this->tbl_vehicle . '.veh_km_from,'
               . $this->tbl_vehicle . '.veh_first_reg,' . $this->tbl_vehicle . '.veh_transmission,' . $this->tbl_vehicle_colors . '.vc_color,') //. $this->tbl_valuation . '.val_id,'
               ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
               ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
               ->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_inquiry = ' . $this->tbl_enquiry . '.enq_id', 'left')
               ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
               ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
               ->join($this->tbl_brand . ' tb_reg_brand', 'tb_reg_brand.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'LEFT')
               ->join($this->tbl_model . ' tb_reg_model', 'tb_reg_model.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT')
               ->join($this->tbl_variant . ' tb_reg_variant', 'tb_reg_variant.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'LEFT')
               //$this->tbl_valuation = TABLE_PREFIX . 'valuation';val_vehicle_id
               //->join($this->tbl_model . ' tb_reg_model', 'tb_reg_model.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT')
               //             ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
               //($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
               // ->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
               ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               //->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_valuation . '.val_vehicle_id', 'LEFT')
               //->join($this->tbl_model . ' tb_reg_model', 'tb_reg_model.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT')
               // ->join($this->tbl_vehicle . ' tb_vehc', 'tb_vehc.veh_id = ' . $this->tbl_valuation . '.val_vehicle_id', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
               ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_vehicle . '.veh_color', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($whr)->where($this->tbl_enquiry . '.enq_cus_status != ', 1); //changed by jk enq_cus_status = 2

          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
               //$this->db->limit(limit,offset);
          }
          $data = $this->db->get($this->tbl_enquiry)->result_array();
          $str = $this->db->last_query();
          // debug($str);
          $totalRecordwithFilter = 100;
          #Response
          // echo $this->db->last_query();
          // debug($data);
          $totalRecordwithFilter = 100;
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;
     }

     function pr_purchase_enq($postDatas, $filterDatas)
     {
          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value
          //$totalRecords = $this->db->count_all_results($this->tbl_valuation);
          // $rowperpage=3;
          //conut
          $whr = array($this->tbl_vehicle . '.veh_status' => 2, $this->tbl_vehicle . '.veh_type' => 0, $this->tbl_vehicle . '.veh_enq_type_old' => NULL);
          $enq = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_occupation . '.*,' . $this->tbl_city . '.*,'
               . $this->tbl_district . '.*,' . $this->tbl_state . '.*,' . $this->tbl_country . '.*,' . $this->tbl_register_master . '.vreg_contact_mode,' . $this->tbl_register_master . '.vreg_is_punched,' . $this->tbl_register_master . '.vreg_call_type,' . $this->tbl_register_master . '.vreg_cust_place,' . $this->tbl_register_master . '.vreg_cust_phone,'
               . ',tb_reg_brand.brd_title as reg_brd_title,' . 'tb_reg_model.mod_title as reg_mod_title,' . 'tb_reg_variant.var_variant_name as reg_variant_name,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
               . $this->tbl_vehicle . '.veh_brand,' . $this->tbl_vehicle . '.veh_model,' . $this->tbl_vehicle . '.veh_varient,' . $this->tbl_vehicle . '.veh_first_reg,' . $this->tbl_vehicle . '.veh_km_from,' . $this->tbl_vehicle . '.veh_id,' . $this->tbl_vehicle . '.veh_reg,' . $this->tbl_vehicle . '.veh_owner,' . $this->tbl_vehicle . '.veh_color,' . $this->tbl_vehicle . '.veh_transmission,' . $this->tbl_vehicle . '.veh_fuel,') //veh_reg
               ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
               ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
               ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
               ->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_inquiry = ' . $this->tbl_enquiry . '.enq_id', 'left')
               ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
               ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
               ->join($this->tbl_brand . ' tb_reg_brand', 'tb_reg_brand.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'LEFT')
               ->join($this->tbl_model . ' tb_reg_model', 'tb_reg_model.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'LEFT')
               ->join($this->tbl_variant . ' tb_reg_variant', 'tb_reg_variant.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'LEFT')
               //             ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
               //($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
               ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
               ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($whr)->where($this->tbl_enquiry . '.enq_cus_status', 2);

          $totalRecords = $this->db->count_all_results($this->tbl_enquiry);
          // $data = $this->db->get($this->tbl_enquiry)->result_array();
          ///@count
          error_reporting(0);
          // $this->db->limit($rowperpage, $row);
          $data = $this->db->query("CALL sp_purchase_enq_list($rowperpage, $row)")->result_array();
          $this->db->reconnect();
          //  debug($data);
          #Response
          // debug($data);
          $totalRecordwithFilter = 100;
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }

     function reassigntosalesstaff($data)
     {
          $regId = isset($data['vreg_id']) ? $data['vreg_id'] : 0;
          if ($regId > 0) {
               unset($data['vreg_id']);
               $data['vreg_added_by'] = $this->uid;
               $data['vreg_brand'] = (isset($data['vreg_brand']) && !empty($data['vreg_brand'])) ? $data['vreg_brand'] : 0;
               $data['vreg_year'] = (isset($data['vreg_year']) && !empty($data['vreg_year'])) ? $data['vreg_year'] : 0;
               $data['vreg_km'] = (isset($data['vreg_km']) && !empty($data['vreg_km'])) ? $data['vreg_km'] : 0;
               $data['vreg_ownership'] = (isset($data['vreg_ownership']) && !empty($data['vreg_ownership'])) ? $data['vreg_ownership'] : 0;
               $data['vreg_is_punched'] = 0;
               $this->db->where('vreg_id', $regId)->update($this->tbl_register_master, $data);
               //Register history
               $userDetails = $this->db->select('usr_username')->get_where(
                    $this->tbl_users,
                    array('usr_id' => $data['vreg_assigned_to'])
               )->row_array();
               $myname = $this->session->userdata('usr_username');
               $assgdto = isset($userDetails['usr_username']) ? $userDetails['usr_username'] : '';

               $histry = array(
                    'regh_register_master' => $regId,
                    'regh_assigned_by' => $this->uid,
                    'regh_assigned_to' => $data['vreg_assigned_to'],
                    'regh_added_date' => date('Y-m-d H:i:s'),
                    'regh_added_by' => $this->uid,
                    'regh_remarks' => $data['vreg_tsc_comments'],
                    'regh_system_cmd' => 'Quick register re-assigned to ' . $assgdto . ', re-assigned by ' . $myname
               );
               $this->db->insert($this->tbl_register_history, $histry);
               //Re-assign Report
               $reData = array(
                    're_staff' => $data['vreg_assigned_to'],
                    're_reg_id' => $regId,
                    're_added_by' => $this->uid,
                    're_added_on' => date('Y-m-d H:i:s')
               );

               $this->db->insert('cpnl_re_assign_reports', $reData);

               generate_log(array(
                    'log_title' => 'Re-assign register',
                    'log_desc' => 'Re-assign register',
                    'log_controller' => 'reassigntosalesstaff',
                    'log_action' => 'U',
                    'log_ref_id' => $regId,
                    'log_added_by' => $this->uid
               ));
          }
          return false;
     }

     function getStaffNameById($user_id)
     {
          $staff = $this->db->select('usr_first_name')->get_where($this->tbl_users, array('usr_id' => $user_id))->row_array();
          return $staff;
     }

     function getEnquiries()
     { //enq_cus_status
          error_reporting(0);
          $res = $this->db->query("CALL sp_get_enquiries_for_dar($this->uid)")->result_array();
          $this->db->reconnect();
          //debug($res);
          return $res;
     }

     function bindEnqVeh($id)
     { //cpnl_vehicle_1//enq_entry_date
          // debug($id); ->where($whr)
          //            $whr = array($this->tbl_vehicle . '.veh_status' => 1,$this->tbl_vehicle . '.veh_enq_type_old' => NULL,$this->tbl_vehicle . '.veh_enq_id' => $id);
          //            $res= $this->db->select($this->tbl_enquiry . '.enq_id,' . $this->tbl_enquiry . '.enq_showroom_id,' . $this->tbl_enquiry . '.enq_entry_date,' . $this->tbl_enquiry . '.enq_se_id,' . $this->tbl_enquiry . '.enq_mode_enq,'
          //                                    . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' . $this->tbl_enquiry . '.enq_cus_mobile,'.$this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,'
          //                                    . $this->tbl_vehicle . '.veh_brand,' . $this->tbl_vehicle . '.veh_model,' . $this->tbl_vehicle . '.veh_varient,' . $this->tbl_vehicle . '.veh_first_reg,' . $this->tbl_vehicle . '.veh_km_from,' . $this->tbl_vehicle . '.veh_id,' . $this->tbl_vehicle . '.veh_reg,')//veh_reg
          //                                                                                //             ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
          //                            //($this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
          //                           // ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
          //                     ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT')
          //                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
          //                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
          //                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
          //                            ->order_by($this->tbl_vehicle . '.veh_id', 'DESC')->where($whr)->get($this->tbl_vehicle)->result_array();
          //            $count = $this->db->last_query();
          //            debug($count);
          //            return $count;
          //debug($res);
          //

          //
          //                      SELECT `cpnl_enquiry`.`enq_id`, `cpnl_enquiry`.`enq_showroom_id`, `cpnl_enquiry`.`enq_entry_date`, `cpnl_enquiry`.`enq_se_id`, `cpnl_enquiry`.`enq_mode_enq`, `cpnl_enquiry`.`enq_cus_name`, `cpnl_enquiry`.`enq_cus_name`, `cpnl_enquiry`.`enq_cus_mobile`, `cpnl_enquiry`.`enq_cus_mobile`, `rana_brand`.`brd_title`, `rana_model`.`mod_title`, `rana_variant`.`var_variant_name`, `cpnl_vehicle_1`.`veh_brand`, `cpnl_vehicle_1`.`veh_model`, `cpnl_vehicle_1`.`veh_varient`, `cpnl_vehicle_1`.`veh_first_reg`, `cpnl_vehicle_1`.`veh_km_from`, `cpnl_vehicle_1`.`veh_id`, `cpnl_vehicle_1`.`veh_reg`
          //FROM (`cpnl_vehicle_1`)
          //LEFT JOIN `cpnl_enquiry` ON `cpnl_enquiry`.`enq_id` = `cpnl_vehicle_1`.`veh_enq_id`
          //LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_vehicle_1`.`veh_brand`
          //LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_vehicle_1`.`veh_model`
          //LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_vehicle_1`.`veh_varient`
          //WHERE `cpnl_vehicle_1`.`veh_status` =  1
          //AND `cpnl_vehicle_1`.`veh_enq_type_old` IS NULL
          //AND `cpnl_vehicle_1`.`veh_enq_id` =  7
          //ORDER BY `cpnl_vehicle_1`.`veh_id` DESC
          //debug($id);
          error_reporting(0);
          $res['enqData'] = $this->db->query("CALL sp_enquiry_by_id($id)")->row_array();

          $this->db->reconnect();
          error_reporting(0);

          $res['vehData'] = $this->db->query("CALL sp_get_enq_vehicles($id)")->result_array();
          $this->db->reconnect();
          return $res;
          // debug($res);
     }
     function getEnqVehById($id)
     {
          error_reporting(0);
          $res = $this->db->query("CALL sp_vehicle_by_id($id)")->row_array();
          $this->db->reconnect();
          //debug($res);
          return $res;
     }
     function pendingRegByStaff01($limit = 0, $page = 0, $filter = array())
     {
          //debug($this->usr_grp);
          //debug($filter);
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
          $selectArray = array(
               $this->tbl_register_master . '.vreg_assigned_to',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'count(*) AS pendregcount'
          );
          $return['count'] = 11;
          //  $return['count'] = $this->pendingRegTotal($filter); 
          // debug( $return['count']);
          $vregDivision = isset($filter['vreg_division']) ? $filter['vreg_division'] : 0;
          $vregShowroom = isset($filter['vreg_showroom']) ? $filter['vreg_showroom'] : 0;
          $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
               ->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = ' . 'exstse.usr_id', 'left')
               ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left');

          if ($limit) {
               $this->db->limit($limit, $page);
          }
          //            if (($this->uid != ADMIN_ID) && empty($search)) {
          //                 if (!check_permission('registration', 'showallregisters')) {
          //                      $this->db->where(array('vreg_assigned_to' => $this->uid));
          //                 }
          //                 if (check_permission('registration', 'registrationcreatedbyme')) {
          //                      $this->db->where(array('vreg_added_by' => $this->uid));
          //                 }
          //                 if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
          //                      array_push($mystaffs, $this->uid);
          //                      $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
          //                              $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
          //                 }
          //                 if (check_permission('enquiry', 'myregistersmartpurchaseonly')) {
          //                      $this->db->where_in('vreg_department', array(7));
          //                 }
          //            }   

          if ($this->usr_grp == 'SE' || $this->usr_grp == 'EV' || $this->usr_grp == 'TL') {
               $this->db->where('vreg_is_punched = 0');
          }
          if ($vregDivision > 0) {
               $this->db->where('vreg_division', $vregDivision);
          }
          if ($vregShowroom > 0) {
               $this->db->where('vreg_showroom', $vregShowroom);
          }
          //            if ($effective == '0' || $effective == '1') {
          //                 $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          //            }
          // $this->db->order_by('vreg_entry_date', 'DESC');
          //            $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' .
          //                    $this->tbl_enquiry . '.enq_current_status IS NULL)');

          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);

          $return['data'] = $this->db->order_by('pendregcount', 'DESC')->group_by($this->tbl_register_master . '.vreg_assigned_to')->get($this->tbl_register_master)->result_array();
          return $return;
     }
     public function pendingRegByStaff($limit = 0, $page = 0, $filter = array())
     {
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);

          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;

          $vregDivision = isset($filter['vreg_division']) ? $filter['vreg_division'] : 0;
          $vregShowroom = isset($filter['vreg_showroom']) ? $filter['vreg_showroom'] : 0;
          $showallsts = isset($filter['showallsts']) ? $filter['showallsts'] : 0;

          $vreg_assigned_to = isset($filter['vreg_assigned_to']) ? $filter['vreg_assigned_to'] : 0;
          $vreg_first_owner = isset($filter['vreg_first_owner']) ? $filter['vreg_first_owner'] : 0;
          $dept = isset($filter['vreg_department']) ? $filter['vreg_department'] : '';
          $type = isset($filter['vreg_call_type']) ? $filter['vreg_call_type'] : '';
          $mode = isset($filter['vreg_contact_mode']) ? $filter['vreg_contact_mode'] : '';
          $effective = isset($filter['vreg_is_effective']) ? $filter['vreg_is_effective'] : '';
          $addedEntry = (isset($filter['added_entry']) && !empty($filter['added_entry'])) ? $filter['added_entry'] : 'vreg_added_on';

          $enq_date_from = (isset($filter['vreg_added_on_fr']) && !empty($filter['vreg_added_on_fr'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_fr'])) : '';

          $enq_date_to = (isset($filter['vreg_added_on_to']) && !empty($filter['vreg_added_on_to'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_to'])) : '';
          $search = isset($filter['search']) ? $filter['search'] : '';

          $selectArray = array(

               $this->tbl_register_master . '.vreg_cust_name',
               $this->tbl_register_master . '.vreg_assigned_to',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'count(*) AS pendregcount'
          );
          // $return['count'] =11;
          $return['count'] = $this->pendingRegTotal($filter);
          // debug($return['count']);
          $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
               ->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = ' . 'exstse.usr_id', 'left')
               ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left');


          /* $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses); */
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          if (($this->uid != ADMIN_ID) && empty($search)) {
               //                 if (!check_permission('registration', 'showallregisters')) {
               //                      $this->db->where(array('vreg_assigned_to' => $this->uid));
               //                 }
               //                 if (check_permission('registration', 'registrationcreatedbyme')) {
               //                      $this->db->where(array('vreg_added_by' => $this->uid));
               //                 }
               if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                    array_push($mystaffs, $this->uid);
                    $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
               }
               if (check_permission('enquiry', 'myregistersmartpurchaseonly')) {
                    $this->db->where_in('vreg_department', array(7));
               }
          }
          if (!empty($filter)) {

               $type = isset($filter['type']) ? $filter['type'] : '';
               if ($type == 'ex') {
                    $this->db->where('vreg_inquiry != 0');
               } else if ($type == 'nw') {
                    $this->db->where('vreg_inquiry = 0');
               }
               if ($dept > 0) {
                    $this->db->where('vreg_department', $dept);
               }
               if ($type > 0) {
                    $this->db->where('vreg_call_type', $type);
               }
               if ($mode > 0) {
                    $this->db->where('vreg_contact_mode', $mode);
               }
               if (!empty($search)) {
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }

               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               }
               if ($vregShowroom > 0) {
                    $this->db->where('vreg_showroom', $vregShowroom);
               }
          }
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'EV' || $this->usr_grp == 'TL') {
               $this->db->where('vreg_is_punched = 0');
          }

          if (!empty($enq_date_from) && !empty($enq_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . '))');
          }
          if ($effective == '0' || $effective == '1') {
               $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          }
          //$this->db->order_by('vreg_entry_date', 'DESC');
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' .
               $this->tbl_enquiry . '.enq_current_status IS NULL)');

          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $return['data'] = $this->db->order_by('pendregcount', 'DESC')->group_by($this->tbl_register_master . '.vreg_assigned_to')->get($this->tbl_register_master)->result_array();
          //$str = $this->db->last_query();
          //debug($str);       
          return $return;
     }
     public function pendingRegTotal($filter = array())
     {
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);

          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;

          $vregDivision = isset($filter['vreg_division']) ? $filter['vreg_division'] : 0;
          $vregShowroom = isset($filter['vreg_showroom']) ? $filter['vreg_showroom'] : 0;
          $showallsts = isset($filter['showallsts']) ? $filter['showallsts'] : 0;

          $vreg_assigned_to = isset($filter['vreg_assigned_to']) ? $filter['vreg_assigned_to'] : 0;
          $vreg_first_owner = isset($filter['vreg_first_owner']) ? $filter['vreg_first_owner'] : 0;
          $dept = isset($filter['vreg_department']) ? $filter['vreg_department'] : '';
          $type = isset($filter['vreg_call_type']) ? $filter['vreg_call_type'] : '';
          $mode = isset($filter['vreg_contact_mode']) ? $filter['vreg_contact_mode'] : '';
          $effective = isset($filter['vreg_is_effective']) ? $filter['vreg_is_effective'] : '';
          $addedEntry = (isset($filter['added_entry']) && !empty($filter['added_entry'])) ? $filter['added_entry'] : 'vreg_added_on';

          $enq_date_from = (isset($filter['vreg_added_on_fr']) && !empty($filter['vreg_added_on_fr'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_fr'])) : '';

          $enq_date_to = (isset($filter['vreg_added_on_to']) && !empty($filter['vreg_added_on_to'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_to'])) : '';
          $search = isset($filter['search']) ? $filter['search'] : '';

          $selectArray = array(

               $this->tbl_register_master . '.vreg_cust_name',
               $this->tbl_register_master . '.vreg_assigned_to',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
          );
          // $return['count'] =11;

          //debug($return['count']);
          $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
               ->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = ' . 'exstse.usr_id', 'left')
               ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left');


          /* $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses); */

          if (($this->uid != ADMIN_ID) && empty($search)) {
               //                 if (!check_permission('registration', 'showallregisters')) {
               //                      $this->db->where(array('vreg_assigned_to' => $this->uid));
               //                 }
               //                 if (check_permission('registration', 'registrationcreatedbyme')) {
               //                      $this->db->where(array('vreg_added_by' => $this->uid));
               //                 }
               if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                    array_push($mystaffs, $this->uid);
                    $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
               }
               if (check_permission('enquiry', 'myregistersmartpurchaseonly')) {
                    $this->db->where_in('vreg_department', array(7));
               }
          }
          if (!empty($filter)) {

               $type = isset($filter['type']) ? $filter['type'] : '';
               if ($type == 'ex') {
                    $this->db->where('vreg_inquiry != 0');
               } else if ($type == 'nw') {
                    $this->db->where('vreg_inquiry = 0');
               }
               if ($dept > 0) {
                    $this->db->where('vreg_department', $dept);
               }
               if ($type > 0) {
                    $this->db->where('vreg_call_type', $type);
               }
               if ($mode > 0) {
                    $this->db->where('vreg_contact_mode', $mode);
               }
               if (!empty($search)) {
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }

               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               }
               if ($vregShowroom > 0) {
                    $this->db->where('vreg_showroom', $vregShowroom);
               }
          }
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'EV' || $this->usr_grp == 'TL') {
               $this->db->where('vreg_is_punched = 0');
          }

          if (!empty($enq_date_from) && !empty($enq_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . '))');
          }
          if ($effective == '0' || $effective == '1') {
               $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          }
          //$this->db->order_by('vreg_entry_date', 'DESC');
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' .
               $this->tbl_enquiry . '.enq_current_status IS NULL)');

          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $count = $this->db->group_by($this->tbl_register_master . '.vreg_assigned_to')->get($this->tbl_register_master)->num_rows();
          //debug($return['data']);
          //debug(sizeof($return['data']));       

          //  $return['data'] = $this->db->get($this->tbl_register_master)->result_array();
          // debug($return['data']);
          return $count;
     }
     public function pendingRegByStaffX($limit = 0, $page = 0, $filter = array())
     {
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);

          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;

          //            $vregDivision = isset($filter['vreg_division']) ? $filter['vreg_division'] : 0;
          //            $vregShowroom = isset($filter['vreg_showroom']) ? $filter['vreg_showroom'] : 0;
          //            $showallsts = isset($filter['showallsts']) ? $filter['showallsts'] : 0;

          $vreg_assigned_to = isset($filter['vreg_assigned_to']) ? $filter['vreg_assigned_to'] : 0;
          $vreg_first_owner = isset($filter['vreg_first_owner']) ? $filter['vreg_first_owner'] : 0;
          $dept = isset($filter['vreg_department']) ? $filter['vreg_department'] : '';
          $type = isset($filter['vreg_call_type']) ? $filter['vreg_call_type'] : '';
          $mode = isset($filter['vreg_contact_mode']) ? $filter['vreg_contact_mode'] : '';
          $effective = isset($filter['vreg_is_effective']) ? $filter['vreg_is_effective'] : '';
          $addedEntry = (isset($filter['added_entry']) && !empty($filter['added_entry'])) ? $filter['added_entry'] : 'vreg_added_on';

          $enq_date_from = (isset($filter['vreg_added_on_fr']) && !empty($filter['vreg_added_on_fr'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_fr'])) : '';

          $enq_date_to = (isset($filter['vreg_added_on_to']) && !empty($filter['vreg_added_on_to'])) ?
               date('Y-m-d', strtotime($filter['vreg_added_on_to'])) : '';
          $search = isset($filter['search']) ? $filter['search'] : '';

          $selectArray = array(

               $this->tbl_register_master . '.vreg_cust_name',
               $this->tbl_register_master . '.vreg_assigned_to',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'count(*) AS pendregcount'
          );
          // $return['count'] =11;
          $return['count'] = $this->pendingRegTotal($filter);
          // debug($return['count']);
          $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
               ->join($this->tbl_users . ' exstse', $this->tbl_enquiry . '.enq_se_id = ' . 'exstse.usr_id', 'left')
               ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left');


          /* $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses); */
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          if (($this->uid != ADMIN_ID) && empty($search)) {
               //                 if (!check_permission('registration', 'showallregisters')) {
               //                      $this->db->where(array('vreg_assigned_to' => $this->uid));
               //                 }
               //                 if (check_permission('registration', 'registrationcreatedbyme')) {
               //                      $this->db->where(array('vreg_added_by' => $this->uid));
               //                 }
               if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                    array_push($mystaffs, $this->uid);
                    $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
               }
               if (check_permission('enquiry', 'myregistersmartpurchaseonly')) {
                    $this->db->where_in('vreg_department', array(7));
               }
          }
          if (!empty($filter)) {

               $type = isset($filter['type']) ? $filter['type'] : '';
               if ($type == 'ex') {
                    $this->db->where('vreg_inquiry != 0');
               } else if ($type == 'nw') {
                    $this->db->where('vreg_inquiry = 0');
               }
               if ($dept > 0) {
                    $this->db->where('vreg_department', $dept);
               }
               if ($type > 0) {
                    $this->db->where('vreg_call_type', $type);
               }
               if ($mode > 0) {
                    $this->db->where('vreg_contact_mode', $mode);
               }
               if (!empty($search)) {
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }

               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               }
               if ($vregShowroom > 0) {
                    $this->db->where('vreg_showroom', $vregShowroom);
               }
          }
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'EV' || $this->usr_grp == 'TL') {
               $this->db->where('vreg_is_punched = 0');
          }

          if (!empty($enq_date_from) && !empty($enq_date_to)) {
               $this->db->where('(DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') >= DATE(' . "'" . $enq_date_from . "'" . ') AND ' .
                    'DATE(' . $this->tbl_register_master . '.' . $addedEntry . ') <= DATE(' . "'" . $enq_date_to . "'" . '))');
          }
          if ($effective == '0' || $effective == '1') {
               $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
          }
          //$this->db->order_by('vreg_entry_date', 'DESC');
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' .
               $this->tbl_enquiry . '.enq_current_status IS NULL)');

          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $return['data'] = $this->db->order_by('pendregcount', 'DESC')->group_by($this->tbl_register_master . '.vreg_assigned_to')->get($this->tbl_register_master)->result_array();
          return $return;
     }

     function poolEnquires($limit = 0, $page = 0, $exParams = array())
     {
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
               $this->tbl_enquiry . '.enq_pool_entry_date',
               $this->tbl_enquiry . '.enq_pool_id',
               $this->tbl_enquiry . '.enq_current_status',
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_first_name',
               'tbl_added_by.usr_username AS enq_added_by_name',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des'
          );

          $whereSearch = '';
          if (isset($exParams['search']) && !empty($exParams['search'])) {
               $exParams['search'] = trim($exParams['search']);
               $whereSearch = '(' . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $exParams['search'] . "%' OR " .
                    $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $exParams['search'] . "%' OR " .
                    $this->tbl_enquiry . ".enq_number LIKE '%" . $exParams['search'] . "%' OR " .
                    $this->tbl_enquiry . ".enq_cus_whatsapp LIKE '%" . $exParams['search'] . "%' )";
          }
          $dateF = !empty($exParams['enq_pool_entry_date_from']) ?  date('Y-m-d', strtotime($exParams['enq_pool_entry_date_from'])) : '';
          $dateT = !empty($exParams['enq_pool_entry_date_to']) ?  date('Y-m-d', strtotime($exParams['enq_pool_entry_date_to'])) : '';

          if (is_roo_user() || check_permission('enquiry', 'showall')) {

               //Count
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if (!empty($dateF) && !empty($dateT)) {
                    $this->db->where('(DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) >= DATE(' . "'" . $dateF . "'" . ') AND DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) <= DATE(' . "'" . $dateT . "'" . '))');
               }
               if (isset($exParams['enq_status']) && !empty($exParams['enq_status'])) {
                    $this->db->where('( ' . $this->tbl_enquiry . '.enq_current_status = ' . str_replace(',', ' OR ' . $this->tbl_enquiry . '.enq_current_status = ', $exParams['enq_status']) . ' )');
               } else {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               }
               $return['count'] = $this->db->where(array('enq_is_pool' => 1, 'enq_pool_flag' => 1))

                    ->count_all_results($this->tbl_enquiry);

               //Data
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if ($limit) {
                    $this->db->limit($limit, $page);
               }

               if (!empty($dateF) && !empty($dateT)) {
                    $this->db->where('(DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) >= DATE(' . "'" . $dateF . "'" . ') AND DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) <= DATE(' . "'" . $dateT . "'" . '))');
               }
               if (isset($exParams['enq_status']) && !empty($exParams['enq_status'])) {
                    $this->db->where('( ' . $this->tbl_enquiry . '.enq_current_status = ' . str_replace(',', ' OR ' . $this->tbl_enquiry . '.enq_current_status = ', $exParams['enq_status']) . ' )');
               } else {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               }
               $return['data'] = $this->db->select($select)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                    ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                    ->where(array('enq_is_pool' => 1, 'enq_pool_flag' => 1))->order_by($this->tbl_enquiry . '.enq_pool_entry_date', 'DESC')
                    ->get($this->tbl_enquiry)->result_array();

               return $return;
          } else if (check_permission('enquiry', 'showmyshowroom')) { // SM

               $where[$this->tbl_enquiry . '.enq_showroom_id'] = $this->shrm;
               //Count
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if (isset($exParams['enq_status']) && !empty($exParams['enq_status'])) {
                    $this->db->where('( ' . $this->tbl_enquiry . '.enq_current_status = ' . str_replace(',', ' OR ' . $this->tbl_enquiry . '.enq_current_status = ', $exParams['enq_status']) . ' )');
               } else {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               }
               $return['count'] = $this->db->where(array('enq_is_pool' => 1, 'enq_pool_flag' => 1))->where($where)->count_all_results($this->tbl_enquiry);
               //Data

               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if ($limit) {
                    $this->db->limit($limit, $page);
               }
               if (!empty($dateF) && !empty($dateT)) {
                    $this->db->where('(DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) >= DATE(' . "'" . $dateF . "'" . ') AND DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) <= DATE(' . "'" . $dateT . "'" . '))');
               }
               if (isset($exParams['enq_status']) && !empty($exParams['enq_status'])) {
                    $this->db->where('( ' . $this->tbl_enquiry . '.enq_current_status = ' . str_replace(',', ' OR ' . $this->tbl_enquiry . '.enq_current_status = ', $exParams['enq_status']) . ' )');
               } else {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               }
               $return['data'] = $this->db->select($select)
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                    ->where(array('enq_is_pool' => 1, 'enq_pool_flag' => 1))->order_by($this->tbl_enquiry . '.enq_pool_entry_date', 'DESC')
                    ->get_where($this->tbl_enquiry, $where)->result_array();

               return $return;
          } else if (check_permission('enquiry', 'showonlymystaff')) { // ASM

               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);

               if (!empty($mystaffs)) {
                    array_push($mystaffs, $this->uid);
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               }

               //Count 
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if (!empty($dateF) && !empty($dateT)) {
                    $this->db->where('(DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) >= DATE(' . "'" . $dateF . "'" . ') AND DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) <= DATE(' . "'" . $dateT . "'" . '))');
               }
               if (isset($exParams['enq_status']) && !empty($exParams['enq_status'])) {
                    $this->db->where('( ' . $this->tbl_enquiry . '.enq_current_status = ' . str_replace(',', ' OR ' . $this->tbl_enquiry . '.enq_current_status = ', $exParams['enq_status']) . ' )');
               } else {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               }
               $return['count'] = $this->db->where(array('enq_is_pool' => 1, 'enq_pool_flag' => 1))->count_all_results($this->tbl_enquiry);

               if (!empty($mystaffs)) {
                    array_push($mystaffs, $this->uid);
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               }
               //Data
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if ($limit) {
                    $this->db->limit($limit, $page);
               }
               if (!empty($dateF) && !empty($dateT)) {
                    $this->db->where('(DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) >= DATE(' . "'" . $dateF . "'" . ') AND DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) <= DATE(' . "'" . $dateT . "'" . '))');
               }
               if (isset($exParams['enq_status']) && !empty($exParams['enq_status'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_current_status = ' . str_replace(',', ' OR ' . $this->tbl_enquiry . '.enq_current_status = ', $exParams['enq_status']));
               } else {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               }
               $return['data'] = $this->db->select($select)
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'left')
                    ->where(array('enq_is_pool' => 1, 'enq_pool_flag' => 1))->order_by($this->tbl_enquiry . '.enq_pool_entry_date', 'DESC')
                    ->get($this->tbl_enquiry)->result_array();

               return $return;
          } else if (check_permission('enquiry', 'showonlymyself')) { // Seles executives

               $where[$this->tbl_enquiry . '.enq_se_id'] = $this->uid;
               $where[$this->tbl_enquiry . '.enq_is_pool'] = 1;
               $where[$this->tbl_enquiry . '.enq_pool_flag'] = 1;

               //Count
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if (!empty($dateF) && !empty($dateT)) {
                    $this->db->where('(DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) >= DATE(' . "'" . $dateF . "'" . ') AND DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) <= DATE(' . "'" . $dateT . "'" . '))');
               }
               if (isset($exParams['enq_status']) && !empty($exParams['enq_status'])) {
                    $this->db->where('( ' . $this->tbl_enquiry . '.enq_current_status = ' . str_replace(',', ' OR ' . $this->tbl_enquiry . '.enq_current_status = ', $exParams['enq_status']) . ' )');
               } else {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               }
               $return['count'] = $this->db->where($where)->count_all_results($this->tbl_enquiry);

               //Data
               if (!empty($whereSearch)) {
                    $this->db->where($whereSearch);
               }
               if ($limit) {
                    $this->db->limit($limit, $page);
               }
               if (!empty($dateF) && !empty($dateT)) {
                    $this->db->where('(DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) >= DATE(' . "'" . $dateF . "'" . ') AND DATE(' . $this->tbl_enquiry . '.enq_pool_entry_date) <= DATE(' . "'" . $dateT . "'" . '))');
               }
               if (isset($exParams['enq_status']) && !empty($exParams['enq_status'])) {
                    $this->db->where('( ' . $this->tbl_enquiry . '.enq_current_status = ' . str_replace(',', ' OR ' . $this->tbl_enquiry . '.enq_current_status = ', $exParams['enq_status']) . ' )');
               } else {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               }
               $return['data'] = $this->db->select($select)
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                    ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value_new', 'LEFT')
                    ->order_by($this->tbl_enquiry . '.enq_pool_entry_date', 'DESC')
                    ->get_where($this->tbl_enquiry, $where)->result_array();
               //echo $this->db->last_query();
               return $return;
          }
     }

     function getUserNameById($user)
     {
          return $this->db->select('usr_username')->get_where($this->tbl_users, array('usr_id' => $user))->row()->usr_username;
     }

     function updateRegisterMaster($vregIds, $user)
     {
          $this->db->where($vregIds)->update($this->tbl_register_master, array('vreg_assigned_to' => $user, 'flg' => 1));
     }

     function registerHistoryBatch($regHistory)
     {
          $this->db->insert_batch($this->tbl_register_history, $regHistory);
     }

     function poolBatch($batchId = 0)
     {
          $this->db->where('enp_added_by', $this->uid);
          if (!empty($batchId)) {
               $select = array(
                    'enq_pool_batch',
                    'enp_cmd_assign',
                    'enp_added_on',
                    'enp_added_by',
                    $this->tbl_users . '.usr_username',
                    'enp_updated_on',
                    'enp_cmd_updates',
                    'updby.usr_username AS usr_upd_username, sefrm.usr_username AS usr_from_username, enq_cus_name, enq_cus_mobile,'
                         . ' asgnto.usr_username AS usr_to_username'
               );
               return $this->db->select($select)
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry_pool . '.enp_added_by', 'LEFT')
                    ->join($this->tbl_users . ' updby', ' updby.usr_id = ' . $this->tbl_enquiry_pool . '.enp_updated_by', 'LEFT')
                    ->join($this->tbl_users . ' sefrm', ' sefrm.usr_id = ' . $this->tbl_enquiry_pool . '.enp_se_from_id', 'LEFT')
                    ->join($this->tbl_users . ' asgnto', ' asgnto.usr_id = ' . $this->tbl_enquiry_pool . '.enp_se_to_id', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_enquiry_pool . '.enp_enq_id', 'LEFT')
                    ->where('enq_pool_batch', $batchId)->get($this->tbl_enquiry_pool)->result_array();
          } else {
               $select = array('enq_pool_batch', 'enp_cmd_assign', 'enp_added_on', 'enp_added_by', 'usr_username');
               return $this->db->select($select)
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry_pool . '.enp_added_by', 'LEFT')
                    ->group_by('enq_pool_batch')->order_by('enp_added_on', 'DESC')->get($this->tbl_enquiry_pool)->result_array();
          }
     }

     function changeStatusDropLost($data, $get = '')
     {
          if (!empty($data)) {
               $data['enh_added_by'] = $this->uid;
               $data['enh_added_on'] = date('Y-m-d H:i:s');
               $poolId = 0;
               if (isset($data['pool_id'])) {
                    $poolId = $data['pool_id'];
                    unset($data['pool_id']);
               } else if (isset($data['p'])) {
                    $poolId = $data['p'];
                    unset($data['p']);
               } else if (isset($get['p'])) {
                    $poolId = $get['p'];
               }
               if ($this->db->insert($this->tbl_enquiry_history, $data)) {
                    $enqHistoryId = $this->db->insert_id();

                    /* Folowup comment */
                    $curStatus = $this->db->get_where($this->tbl_statuses, array('sts_value' => $data['enh_status']))->row_array();
                    $selectArray = array(
                         $this->tbl_enquiry . '.enq_se_id',
                         $this->tbl_enquiry . '.enq_cus_name',
                         $this->tbl_enquiry . '.enq_cus_mobile',
                         $this->tbl_enquiry . '.enq_cus_when_buy',
                         $this->tbl_users . '.usr_first_name'
                    );

                    $enqdetails = $this->db->select($selectArray)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                         ->get_where($this->tbl_enquiry, array('enq_id' => $data['enh_enq_id']))->row_array();

                    $salesStaffName = isset($enqdetails['usr_first_name']) ? $enqdetails['usr_first_name'] : '';
                    $custName = isset($enqdetails['enq_cus_name']) ? $enqdetails['enq_cus_name'] : '';
                    $curStatusName = isset($curStatus['sts_des']) ? $curStatus['sts_des'] : '';

                    $comment = $salesStaffName . "'s " . ' customer ' . $custName . ' enquiry status has been changed to ' . $curStatusName .
                         ', satus changed by ' . $this->session->userdata('usr_username');

                    $follCmd['foll_remarks'] = $comment;
                    $follCmd['foll_cus_id'] = $data['enh_enq_id'];
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

                    $enUpdate = array(
                         'enq_current_status' => $data['enh_status'],
                         'enq_current_status_history' => $enqHistoryId
                    );

                    if (
                         $data['enh_status'] == loss_of_sale_or_buy || $data['enh_status'] == enq_lost ||
                         $data['enh_status'] == enq_req_drop || $data['enh_status'] == enq_droped
                    ) {
                         // To cold 'enq_cus_when_buy' => 4,
                         $enUpdate = array(
                              'enq_current_status' => $data['enh_status'],
                              'enq_current_status_history' => $enqHistoryId
                         );
                    }
                    $this->db->where('enq_id', $data['enh_enq_id']);
                    $this->db->update($this->tbl_enquiry, $enUpdate);
                    generate_log(array(
                         'log_title' => 'Change enquiry status',
                         'log_desc' => serialize($data),
                         'log_controller' => strtolower(__CLASS__),
                         'log_action' => 'C',
                         'log_ref_id' => $enqHistoryId,
                         'log_added_by' => get_logged_user('usr_id')
                    ));

                    /*Update pool*/
                    if (!empty($poolId)) {
                         $enqUpdPool['enq_pool_updt_date'] = date('Y-m-d H:i:s');
                         $enqUpdPool['enq_pool_lst_cmd'] = $data['enh_remarks'];
                         $enqUpdPool['enq_pool_flag'] = 0; //Show in enq pool old 1
                         $enqUpdPool['enq_cus_when_buy'] = $enqdetails['enq_cus_when_buy'];
                         $this->db->where('enq_id', $datas['foll_cus_id'])->update($this->tbl_enquiry, $enqUpdPool);
                         $this->db->where('enp_id', $poolId)->update($this->tbl_enquiry_pool, array(
                              'enp_updated_on' => date('Y-m-d H:i:s'),
                              'enp_updated_by' => $this->uid,
                              'enp_cmd_updates' => $data['enh_remarks'],
                         ));
                    }

                    return true;
               }
          }
          return false;
     }

     /*jsk*/
     function updateSalesVehicleMeta($data, $noOfSale, $enquiryId, $enq_se_id = '')
     {


          $lastReq = null; // Initialize a variable to store the last data

          for ($i = 0; $i < $noOfSale; $i++) {

               $req['veh_brand'] = isset($data['veh_brand'][$i]) ? $data['veh_brand'][$i] : 0;
               $req['veh_model'] = isset($data['veh_model'][$i]) ? $data['veh_model'][$i] : 0;
               $req['veh_varient'] = isset($data['veh_varient'][$i]) ? $data['veh_varient'][$i] : 0;


               // Update the lastReq variable with the current data
               $lastReq = $req;
          }

          ///   debug($lastReq);
          // echo'<pre>';
          //print_r($lastReq);

          $brand = $this->db->select('brd_title')->where($this->tbl_brand . '.brd_id', $lastReq['veh_brand'])->get($this->tbl_brand)->row_array();
          $brand = isset($brand['brd_title']) ? $brand['brd_title'] : '';

          $model = $this->db->select('mod_title')->where($this->tbl_model . '.mod_id', $lastReq['veh_model'])->get($this->tbl_model)->row_array();
          $model = isset($model['mod_title']) ? $model['mod_title'] : '';

          $variant = $this->db->select('var_variant_name')->where($this->tbl_variant . '.var_id ', $lastReq['veh_varient'])->get($this->tbl_variant)->row_array();
          $variant = isset($variant['var_variant_name']) ? $variant['var_variant_name'] : '';

          $vehicle = $brand . '. ' . $model . '. ' . $variant;


          $this->db->where('enqm_enq_id', $enquiryId)->update(
               $this->tbl_enquiry_meta,
               array('enqm_sls_veh' => $vehicle)
          );
          return true;
     }
     function updatePurchaseVehicleMeta($data, $noOfBuy, $enquiryId, $enquiry)
     {
          $lastBuy = null;
          for ($i = 0; $i < $noOfBuy; $i++) {

               $buy['veh_brand'] = isset($data['veh_brand'][$i]) ? $data['veh_brand'][$i] : 0;
               $buy['veh_model'] = isset($data['veh_model'][$i]) ? $data['veh_model'][$i] : 0;
               $buy['veh_varient'] = isset($data['veh_varient'][$i]) ? $data['veh_varient'][$i] : 0;
               $lastBuy = $buy;
          }

          $brand = $this->db->select('brd_title')->where($this->tbl_brand . '.brd_id', $lastBuy['veh_brand'])->get($this->tbl_brand)->row_array();
          $brand = isset($brand['brd_title']) ? $brand['brd_title'] : '';

          $model = $this->db->select('mod_title')->where($this->tbl_model . '.mod_id', $lastBuy['veh_model'])->get($this->tbl_model)->row_array();
          $model = isset($model['mod_title']) ? $model['mod_title'] : '';

          $variant = $this->db->select('var_variant_name')->where($this->tbl_variant . '.var_id ', $lastBuy['veh_varient'])->get($this->tbl_variant)->row_array();
          $variant = isset($variant['var_variant_name']) ? $variant['var_variant_name'] : '';

          $vehicle = $brand . '- ' . $model . '- ' . $variant;

          $this->db->where('enqm_enq_id', $enquiryId)->update(
               $this->tbl_enquiry_meta,
               array('enqm_pur_veh' => $vehicle)
          );
          return true;
     }


     function updatePitchedvehMeta($data, $noOfPitched, $enquiryId)
     {
          $last = null;
          // echo'<pre>';
          //print_r($data);

          for ($i = 0; $i < $noOfPitched; $i++) {
               $pitched['brand'] =  $data['brand_name'][$i];
               $pitched['model'] =  $data['model_name'][$i];
               $pitched['variant'] = $data['variant_name'][$i];
               $last = $pitched;
          }


          $vehicle =  $last['brand'] . ', ' . $last['model'] . ', ' . $last['variant'];
          //echo $vehicle;
          //exit;

          $this->db->where('enqm_enq_id', $enquiryId)->update(
               $this->tbl_enquiry_meta,
               array('enqm_sls_veh' => $vehicle)
          );
          return true;
     }

     public function updateCustomer($updateData, $cusd_id) {
          //return True; exit;
          $existingData = $this->db->select('cusd_name, cusd_phone_office, cusd_phone_resi,cusd_whatsapp,cusd_email,cusd_fb,cusd_age,cusd_gender,cusd_place,cusd_address,cusd_address_office,cusd_profession,cusd_company,cusd_district,cusd_pin')
                                   ->from($this->tbl_customer_details)
                                   ->where('cusd_id', $cusd_id)
                                   ->get()
                                   ->row_array();
      
          // Compare and filter fields that have changed
          $fieldsToUpdate = array_diff_assoc($updateData, $existingData);
      
          if (!empty($fieldsToUpdate)) {
              $this->db->where('cusd_id', $cusd_id);
              $this->db->update($this->tbl_customer_details, $fieldsToUpdate);
      
              // Clr cache if applicable
          //     $cacheKey = "customer_details_{$cusd_id}";
          //     $this->cache->delete($cacheKey);
      
              return true;
          }
      
          return false; // No updates required
      }
     /*@jsk*/
}