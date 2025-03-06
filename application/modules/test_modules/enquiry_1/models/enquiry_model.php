<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class enquiry_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->db->query("SET time_zone = '+05:30'");

            $this->tbl_city = TABLE_PREFIX . 'city';
            $this->tbl_state = TABLE_PREFIX . 'state';
            $this->tbl_place = TABLE_PREFIX . 'place';
            $this->tbl_users = TABLE_PREFIX . 'users';
            $this->tbl_events = TABLE_PREFIX . 'events';
            $this->tbl_groups = TABLE_PREFIX . 'groups';
            $this->tbl_country = TABLE_PREFIX . 'country';
            $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
            $this->tbl_model = TABLE_PREFIX_RANA . 'model';
            $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
            $this->tbl_statuses = TABLE_PREFIX . 'statuses';
            $this->tbl_showroom = TABLE_PREFIX . 'showroom';
            $this->tbl_followup = TABLE_PREFIX . 'followup';
            $this->tbl_divisions = TABLE_PREFIX . 'divisions';
            $this->tbl_questions = TABLE_PREFIX . 'questions';
            $this->tbl_valuation = TABLE_PREFIX . 'valuation';
            $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
            $this->tbl_occupation = TABLE_PREFIX . 'occupation';
            $this->tbl_departments = TABLE_PREFIX . 'departments';
            $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
            $this->tbl_district = TABLE_PREFIX . 'district_statewise';
            $this->tbl_customer_grade = TABLE_PREFIX . 'customer_grade';
            $this->tbl_vehicle_status = TABLE_PREFIX . 'vehicle_status';
            $this->tbl_register_master = TABLE_PREFIX . 'register_master';
            $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
            $this->tbl_quick_tc_report = TABLE_PREFIX . 'quick_tc_report';
            $this->tbl_valuation_status = TABLE_PREFIX . 'valuation_status';
            $this->tbl_register_history = TABLE_PREFIX . 'register_history';
            $this->tbl_enquiry_questions = TABLE_PREFIX . 'enquiry_questions';
            $this->tbl_register_followup = TABLE_PREFIX . 'register_followup';
            $this->tbl_callcenterbridging = TABLE_PREFIX . 'callcenterbridging';
            $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
            $this->tbl_quick_tc_report_master = TABLE_PREFIX . 'quick_tc_report_master';
            $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
            $this->view_enquiry_vehicle_master = TABLE_PREFIX . 'view_enquiry_vehicle_master';
       }

       function enquires($id = '', $status = array(), $limit = 0, $page = 0, $exParams = array()) {
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
                      $enq['followup'] = $this->db->order_by('foll_entry_date', 'DESC')
                                      ->get_where($this->tbl_followup, array('foll_cus_id' => $id))->result_array();

                      $enq['vehicle_sall'] = $this->db->select($this->view_vehicle_vehicle_status . '.*')
                                      ->where('veh_enq_id = ' . $id . ' AND veh_status = 1 AND (vst_current_status != 99 OR vst_current_status IS NULL)')
                                      ->get($this->view_vehicle_vehicle_status)->result_array();
                      $enq['vehicle_buy'] = $this->db->select($this->view_vehicle_vehicle_status . '.*')
                                      ->where('veh_enq_id = ' . $id . ' AND veh_status = 2 AND (vst_current_status != 99 OR vst_current_status IS NULL)')
                                      ->get($this->view_vehicle_vehicle_status)->result_array();
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
////                      $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')->where(array('vst_current_status' => '99'))
////                                      ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
//
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
//                      $where[$this->tbl_enquiry . '.enq_current_status'] = 1;
                      //Count
                      if (!empty($whereSearch)) {
                           $this->db->where($whereSearch);
                      }
                      $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->count_all_results($this->tbl_enquiry);

                      //Data
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
                      if (!empty($whereSearch)) {
                           $this->db->where($whereSearch);
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
                          $this->tbl_users . '.usr_id',
                          $this->tbl_users . '.usr_first_name',
                          'tbl_added_by.usr_username AS enq_added_by_name',
                          $this->tbl_statuses . '.sts_title',
                          $this->tbl_statuses . '.sts_des',
                      );
                      $return['data'] = $this->db->select($select)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                                      ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();
                      return $return;
                 } else if(check_permission('enquiry', 'showluxysmartenquiries')) {
                      //$this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                      if (!empty($whereSearch)) {
                           $this->db->where($whereSearch);
                      }
                      $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->count_all_results($this->tbl_enquiry);
                      if (!empty($whereSearch)) {
                           $this->db->where($whereSearch);
                      }
                      if ($limit) {
                           $this->db->limit($limit, $page);
                      }
                      //$this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                      $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' .
                                              $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des')
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                                      ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();
                      return $return;
                 } else if ($this->usr_grp == 'MG') { // Manager
                    
//                      $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')
//                                      ->where(array('vst_current_status' => '99', 'enq_showroom_id' => $showroom))
//                                      ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
//                      $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;
                      $where[$this->tbl_enquiry . '.enq_showroom_id'] = $showroom;
                      $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                      //Count
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
                      if (!empty($whereSearch)) {
                           $this->db->where($whereSearch);
                      }
                      $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                      //Data
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
                      if (!empty($whereSearch)) {
                           $this->db->where($whereSearch);
                      }
                      if ($limit) {
                           $this->db->limit($limit, $page);
                      }
                      $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' .
                                              $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des')
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                                      ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                      return $return;
                 } else if ($this->usr_grp == 'DE') { // Date entry operator
//                      $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')
//                                      ->where(array('vst_current_status' => '99', 'enq_added_by' => $this->uid))
//                                      ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
//                      $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;
                      $where[$this->tbl_enquiry . '.enq_added_by'] = $this->uid;
                      $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                      //Count
                      if (!empty($whereSearch)) {
                           $this->db->where($whereSearch);
                      }
//                      $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
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
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
                      $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' .
                                              $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des')
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                                      ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                      return $return;
                 } else if ($this->usr_grp == 'SE') { // Seles executives
//                      $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')
//                                      ->where(array('vst_current_status' => '99', 'enq_se_id' => $this->uid))
//                                      ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
//                      $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;
                      $where[$this->tbl_enquiry . '.enq_se_id'] = $this->uid;
                      $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                      //Count
                      if (!empty($whereSearch)) {
                           $this->db->where($whereSearch);
                      }
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
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
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
                      $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
                      $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' .
                                              $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des')
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                                      ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'inquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                      return $return;
                 } else if ($this->usr_grp == 'TL') { // Team lead
                      //Get sales executves under team lead
                      $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                                      ->get($this->tbl_users)->row()->usr_id);

//                      $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')
//                                      ->where(array('vst_current_status' => '99', 'enq_added_by' => $this->uid))
//                                      ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
//                      $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;
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
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
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
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
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
                      if (!empty($where)) {
                           $this->where($where);
                      }
                      $return['data'] = $this->db->select($select)
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                                      ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get($this->tbl_enquiry)->result_array();
                      return $return;
                 } else {
                      // Seles executives
//                      $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')
//                                      ->where(array('vst_current_status' => '99', 'enq_se_id' => $this->uid))
//                                      ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
//                      $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;
                      $where[$this->tbl_enquiry . '.enq_se_id'] = $this->uid;

                      $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                      //Count
                      if (!empty($whereSearch)) {
                           $this->db->where($whereSearch);
                      }
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
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
//                      if (!empty($exclude)) {
//                           $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
//                      }
                      $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' .
                                              $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des')
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                      ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                      ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                                      ->where('(' . $this->tbl_statuses . ".sts_category LIKE 'enquiry' OR " . $this->tbl_statuses . ".sts_category LIKE 'vehicle')")
                                      ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                      return $return;
                 }
            }
       }

       function newEnquiry($data) {
            generate_log(array(
                'log_title' => 'New inquiry',
                'log_desc' => serialize($data),
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

            $this->load->model('followup/followup_model', 'followup');
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
                 $data['enquiry']['enq_division'] = $this->div;
                 $data['enquiry']['enq_cus_pin'] = empty($data['enquiry']['enq_cus_pin']) ? 0 : $data['enquiry']['enq_cus_pin'];
                 $data['enquiry']['enq_cus_when_buy'] = isset($data['followup']['foll_status']) ? $data['followup']['foll_status'] : 0;
                 $data['enquiry']['enq_cus_loan_emi'] = empty($data['enquiry']['enq_cus_loan_emi']) ? 0 : $data['enquiry']['enq_cus_loan_emi'];
                 $data['enquiry']['enq_cus_status'] = empty($data['enquiry']['enq_cus_status']) ? 0 : $data['enquiry']['enq_cus_status'];
                 $data['enquiry']['enq_cus_test_drive'] = 0; //isset($data['enquiry']['enq_cus_test_drive']) ? 0 : $data['enquiry']['enq_cus_test_drive'];
                 $data['enquiry']['enq_current_status'] = empty($data['enquiry']['enq_current_status']) ? 1 : $data['enquiry']['enq_current_status'];
                 $data['enquiry']['enq_cus_loan_period'] = empty($data['enquiry']['enq_cus_loan_period']) ? 0 : $data['enquiry']['enq_cus_loan_period'];
                 $data['enquiry']['enq_cus_loan_amount'] = empty($data['enquiry']['enq_cus_loan_amount']) ? 0 : $data['enquiry']['enq_cus_loan_amount'];
                 $data['enquiry']['enq_cus_loan_amount'] = empty($data['enquiry']['enq_cus_loan_amount']) ? 0 : $data['enquiry']['enq_cus_loan_amount'];
                 $data['enquiry']['enq_cus_family_members'] = empty($data['enquiry']['enq_cus_family_members']) ? 0 : $data['enquiry']['enq_cus_family_members'];
                 /* Set default values */

                 if (isset($data['enquiry']) && !empty($data['enquiry'])) {

                      /* Occupation */
                      if (isset($data['enquiry']['enq_cus_occu']) && !empty($data['enquiry']['enq_cus_occu'])) {
                           $occu = $this->db->like('occ_name', $data['enquiry']['enq_cus_occu'], 'both')->get($this->tbl_occupation)->row_array();
                           if (empty($occu)) {
                                $this->db->insert($this->tbl_occupation, array('occ_name' => $data['enquiry']['enq_cus_occu']));
                                $data['enquiry']['enq_cus_occu'] = $this->db->insert_id();
                           } else {
                                $data['enquiry']['enq_cus_occu'] = $occu['occ_id'];
                           }
                      } else {
                           $data['enquiry']['enq_cus_occu'] = 0;
                      }
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
                      /*if (isset($data['enquiry']['enq_cus_dist']) && !empty($data['enquiry']['enq_cus_dist'])) {
                           $dist = $this->db->like('dit_name', $data['enquiry']['enq_cus_dist'], 'both')->get($this->tbl_district)->row_array();
                           if (empty($dist)) {
                                $this->db->insert($this->tbl_district, array('dit_name' => $data['enquiry']['enq_cus_dist']));
                                $data['enquiry']['enq_cus_dist'] = $this->db->insert_id();
                           } else {
                                $data['enquiry']['enq_cus_dist'] = $dist['dit_id'];
                           }
                      } else {
                           $data['enquiry']['enq_cus_dist'] = 0;
                      }*/
                      /* State */
                      if (isset($data['enquiry']['enq_cus_state']) && !empty($data['enquiry']['enq_cus_state'])) {
                           $state = $this->db->like('stt_name', $data['enquiry']['enq_cus_state'], 'both')->get($this->tbl_state)->row_array();
                           if (empty($state)) {
                                $this->db->insert($this->tbl_state, array('stt_name' => $data['enquiry']['enq_cus_state']));
                                $data['enquiry']['enq_cus_state'] = $this->db->insert_id();
                           } else {
                                $data['enquiry']['enq_cus_state'] = $state['stt_id'];
                           }
                      } else {
                           $data['enquiry']['enq_cus_state'] = 0;
                      }
                      /* Country */
                      if (isset($data['enquiry']['enq_cus_country']) && !empty($data['enquiry']['enq_cus_country'])) {
                           $country = $this->db->like('cnt_name', $data['enquiry']['enq_cus_country'], 'both')->get($this->tbl_country)->row_array();
                           if (empty($country)) {
                                $this->db->insert($this->tbl_country, array('cnt_name' => $data['enquiry']['enq_cus_country']));
                                $data['enquiry']['enq_cus_country'] = $this->db->insert_id();
                           } else {
                                $data['enquiry']['enq_cus_country'] = $country['cnt_id'];
                           }
                      } else {
                           $data['enquiry']['enq_cus_country'] = 0;
                      }
                      /* Sale and purchase */
                      $data['enquiry']['enq_se_id'] = isset($data['enquiry']['enq_se_id']) ? $data['enquiry']['enq_se_id'] : $this->uid;
                      $data['enquiry']['enq_entry_date'] = (isset($data['enquiry']['enq_entry_date']) && !empty($data['enquiry']['enq_entry_date'])) ?
                              date('Y-m-d', strtotime($data['enquiry']['enq_entry_date'])) : '';

                      $data['enquiry']['enq_next_foll_date'] = (isset($data['followup']['foll_next_foll_date']) &&
                              !empty($data['followup']['foll_next_foll_date'])) ?
                              date('Y-m-d', strtotime($data['followup']['foll_next_foll_date'])) : null;

                      $data['enquiry']['enq_added_on'] = date('Y-m-d H:i:s'); //03-12-2020 changed to h -> H
                      if ($this->db->insert($this->tbl_enquiry, $data['enquiry'], true)) {
                           $enquiryId = $this->db->insert_id();

                           $er = $this->db->_error_message();
                              if(!empty($er)) {
                                   generate_log(array(
                                        'log_title' => 'New enquiry error',
                                        'log_desc' => serialize($er),
                                        'log_controller' => 'new-enq-error',
                                        'log_action' => 'U',
                                        'log_ref_id' => $enquiryId,
                                        'log_added_by' => $this->uid
                                   ));
                              }

                           $this->db->where('enq_id', $enquiryId)->update($this->tbl_enquiry, array('enq_number' => generate_vehicle_virtual_id($enquiryId)));
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
                           if (!empty($data['saquestions'])) {
                                foreach ($data['saquestions'] as $key => $value) {
//                                     $quesId = substr($key, 4);
                                     //if (in_array($quesId, $questions) && !empty($value)) {
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
                           //Questions

                           if ($regId > 0) {
                                /* Update register master */
                                $this->db->where('vreg_id', $regId);
                                $this->db->update($this->tbl_register_master, array('vreg_status' => 1, 'vreg_inquiry' => $enquiryId));
                           }
                           if ($data['enquiry']['enq_cus_status'] == 1 || $data['enquiry']['enq_cus_status'] == 3) {
                                $noOfSale = isset($data['vehicle']['sale']['veh_brand']) ? count($data['vehicle']['sale']['veh_brand']) : 0;

                                for ($i = 0; $i < $noOfSale; $i++) {
                                     $sale['veh_enq_id'] = $enquiryId;
                                     $sale['veh_status'] = 1;
                                     $sale['veh_brand'] = isset($data['vehicle']['sale']['veh_brand'][$i]) ? $data['vehicle']['sale']['veh_brand'][$i] : 0;
                                     $sale['veh_model'] = isset($data['vehicle']['sale']['veh_model'][$i]) ? $data['vehicle']['sale']['veh_model'][$i] : 0;
                                     $sale['veh_varient'] = isset($data['vehicle']['sale']['veh_varient'][$i]) ? $data['vehicle']['sale']['veh_varient'][$i] : 0;
                                     $sale['veh_fuel'] = $data['vehicle']['sale']['veh_fuel'][$i];
                                     $sale['veh_color'] = $data['vehicle']['sale']['veh_color'][$i];

                                     $sale['veh_year'] = empty($data['vehicle']['sale']['veh_year'][$i]) ? 0 : $data['vehicle']['sale']['veh_year'][$i];
                                     $sale['veh_price_from'] = empty($data['vehicle']['sale']['veh_price_from'][$i]) ? 0 : $data['vehicle']['sale']['veh_price_from'][$i];
                                     $sale['veh_price_to'] = empty($data['vehicle']['sale']['veh_price_to'][$i]) ? 0 : $data['vehicle']['sale']['veh_price_to'][$i];
                                     $sale['veh_km_from'] = empty($data['vehicle']['sale']['veh_km_from'][$i]) ? 0 : $data['vehicle']['sale']['veh_km_from'][$i];
                                     $sale['veh_km_to'] = empty($data['vehicle']['sale']['veh_km_to'][$i]) ? 0 : $data['vehicle']['sale']['veh_km_to'][$i];
                                     $sale['veh_reg'] = $data['vehicle']['sale']['veh_reg'][$i];
                                     $sale['veh_owner'] = $data['vehicle']['sale']['veh_owner'][$i];
                                     $sale['veh_remarks'] = $data['vehicle']['sale']['veh_remarks'][$i];
                                     $sale['veh_stock_id'] = isset($data['vehicle']['sale']['veh_stock_id'][$i]) ? $data['vehicle']['sale']['veh_stock_id'][$i] : 0;
                                     $sale['veh_added_by'] = $this->uid;
                                     $sale['veh_showroom_id'] = $showroom;
                                     $this->db->insert($this->tbl_vehicle, array_filter($sale));
                                     $vehId = $this->db->insert_id();
                                     
                                     /*Procurement request*/
                                     
                                     if ((isset($data['vehicle']['sale']['proc_purchase_prd'][$i]) && !empty($data['vehicle']['sale']['proc_purchase_prd'][$i])) && 
                                             isset($data['vehicle']['sale']['proc_desc'][$i]) && !empty($data['vehicle']['sale']['proc_desc'][$i])) {
                                        $procreq['enq_se_id'] = $data['enquiry']['enq_se_id'];
                                        $procreq['enq_id'] = $enquiryId;
                                        $procreq['brand'] = isset($sale['veh_brand']) ? $sale['veh_brand'] : 0;
                                        $procreq['model'] = isset($sale['veh_model']) ? $sale['veh_model'] : 0;
                                        $procreq['variant'] = isset($sale['veh_varient']) ? $sale['veh_varient'] : 0;
                                        $procreq['purchase_prd'] = $data['vehicle']['sale']['proc_purchase_prd'][$i];
                                        $procreq['descriptin'] = $data['vehicle']['sale']['proc_desc'][$i];

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

                                     /*Procurement request*/

                                     if (isset($data['followup']) && !empty($data['followup'])) {
                                          $data['followup']['foll_cus_id'] = $enquiryId;
                                          $data['followup']['foll_cus_vehicle_id'] = $vehId;
                                          $this->followup->addFollowUp($data['followup']);
                                     }
                                }
                           }
                           if ($data['enquiry']['enq_cus_status'] == 2 || $data['enquiry']['enq_cus_status'] == 3) {
                                $noOfBuy = isset($data['vehicle']['buy']['veh_brand']) ? count($data['vehicle']['buy']['veh_brand']) : 0;
                                for ($i = 0; $i < $noOfBuy; $i++) {
                                     $buy['veh_enq_id'] = $enquiryId;
                                     $buy['veh_status'] = 2;
                                     $buy['veh_brand'] = isset($data['vehicle']['buy']['veh_brand'][$i]) ? $data['vehicle']['buy']['veh_brand'][$i] : 0;
                                     $buy['veh_model'] = isset($data['vehicle']['buy']['veh_model'][$i]) ? $data['vehicle']['buy']['veh_model'][$i] : 0;
                                     $buy['veh_varient'] = isset($data['vehicle']['buy']['veh_varient'][$i]) ? $data['vehicle']['buy']['veh_varient'][$i] : 0;
                                     $buy['veh_fuel'] = $data['vehicle']['buy']['veh_fuel'][$i];
                                     $buy['veh_year'] = empty($data['vehicle']['buy']['veh_year'][$i]) ? 0 : $data['vehicle']['buy']['veh_year'][$i];
                                     $buy['veh_color'] = $data['vehicle']['buy']['veh_color'][$i];
                                     $buy['veh_price_from'] = empty($data['vehicle']['buy']['veh_price_from'][$i]) ? 0 : $data['vehicle']['buy']['veh_price_from'][$i];
                                     $buy['veh_price_to'] = empty($data['vehicle']['buy']['veh_price_to'][$i]) ? 0 : $data['vehicle']['buy']['veh_price_to'][$i];
                                     $buy['veh_km_from'] = empty($data['vehicle']['buy']['veh_km_from'][$i]) ? 0 : $data['vehicle']['buy']['veh_km_from'][$i];
                                     $buy['veh_km_to'] = empty($data['vehicle']['buy']['veh_km_to'][$i]) ? 0 : $data['vehicle']['buy']['veh_km_to'][$i];
                                     $buy['veh_chassis_number'] = isset($data['vehicle']['buy']['veh_chassis_number'][$i]) ? $data['vehicle']['buy']['veh_chassis_number'][$i] : 0;
                                     $buy['veh_reg'] = $data['vehicle']['buy']['veh_reg'][$i];
                                     $buy['veh_owner'] = $data['vehicle']['buy']['veh_owner'][$i];
                                     $buy['veh_remarks'] = $data['vehicle']['buy']['veh_remarks'][$i];
                                     $buy['veh_exch_cus_expect'] = !empty($data['vehicle']['buy']['veh_exch_cus_expect'][$i]) ? $data['vehicle']['buy']['veh_exch_cus_expect'][$i] : 0;
                                     $buy['veh_exch_estimate'] = !empty($data['vehicle']['buy']['veh_exch_estimate'][$i]) ? $data['vehicle']['buy']['veh_exch_estimate'][$i] : 0;
                                     $buy['veh_exch_dealer_value'] = !empty($data['vehicle']['buy']['veh_exch_dealer_value'][$i]) ? $data['vehicle']['buy']['veh_exch_dealer_value'][$i] : 0;

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

                                     $buy['veh_added_by'] = $this->uid;
                                     $buy['veh_showroom_id'] = $showroom;
                                     $this->db->insert($this->tbl_vehicle, array_filter($buy));
                                     $vehId = $this->db->insert_id();

                                     if (isset($data['followup']) && !empty($data['followup'])) {
                                          $data['followup']['foll_cus_id'] = $enquiryId;
                                          $data['followup']['foll_cus_vehicle_id'] = $vehId;
                                          $this->followup->addFollowUp($data['followup']);
                                     }

                                     $valuationDetails['val_enquiry_id'] = $enquiryId;
                                     $valuationDetails['val_veh_no'] = isset($buy['veh_reg']) ? $buy['veh_reg'] : '';
                                     $valuationDetails['val_showroom'] = $showroom;
                                     $valuationDetails['val_division'] = $this->div;
                                     $valuationDetails['val_brand'] = $buy['veh_brand'];
                                     $valuationDetails['val_model'] = $buy['veh_model'];
                                     $valuationDetails['val_variant'] = !empty($buy['veh_varient']) ? $buy['veh_varient'] : 0;
                                     $valuationDetails['val_fuel'] = !empty($buy['veh_fuel']) ? $buy['veh_fuel'] : 0;
                                     $valuationDetails['val_color'] = $buy['veh_color'];
                                     $valuationDetails['val_chasis_no'] = $buy['veh_chassis_number'];
                                     $valuationDetails['val_added_by'] = $this->uid;
                                     $valuationDetails['val_status'] = 0;
                                     $valuationDetails['val_type'] = 3;
                                     $valuationDetails['val_km'] = !empty($buy['veh_km_from']) ? $buy['veh_km_from'] : $buy['veh_km_to'];

                                     $valuationDetails['val_model_year'] = $buy['veh_year'];
                                     $valuationDetails['val_delv_date'] = !empty($buy['veh_delivery_date']) ? date('Y-m-d', strtotime($buy['veh_delivery_date'])) : '';
                                     $valuationDetails['val_reg_date'] = !empty($buy['veh_first_reg']) ? date('Y-m-d', strtotime($buy['veh_first_reg'])) : '';
                                     $valuationDetails['val_minif_year'] = $buy['veh_manf_year'];
                                     $valuationDetails['val_ac'] = $buy['veh_ac'];
                                     $valuationDetails['val_ac_zone'] = $buy['veh_ac_zone'];
                                     $valuationDetails['val_eng_cc'] = $buy['veh_cc'];
                                     $valuationDetails['val_veh_type'] = $buy['veh_vehicle_type'];
                                     $valuationDetails['val_model_year'] = $buy['veh_year'];
                                     $valuationDetails['val_engine_no'] = $buy['veh_engine_num'];
                                     $valuationDetails['val_transmission'] = $buy['veh_transmission'];
                                     $valuationDetails['val_no_of_seats'] = $buy['veh_seat_no'];
                                   //   $valuationDetails['val_delv_date'] = $buy['veh_delivery_date'];
                                   //   $valuationDetails['val_reg_date'] = $buy['veh_first_reg'];
                                     $valuationDetails['val_cust_name'] = isset($data['enquiry']['enq_cus_name']) ? $data['enquiry']['enq_cus_name'] : '';
                                     $valuationDetails['val_cust_phone'] = isset($data['enquiry']['enq_cus_mobile']) ? $data['enquiry']['enq_cus_mobile'] : '';
                                     $valuationDetails['val_cust_email'] = isset($data['enquiry']['enq_cus_email']) ? $data['enquiry']['enq_cus_email'] : '';
                                     $valuationDetails['val_cust_source'] = isset($data['enquiry']['enq_mode_enq']) ? $data['enquiry']['enq_mode_enq'] : '';

                                     $vhNum = (isset($buy['veh_reg']) && !empty($buy['veh_reg'])) ? explode('-', str_replace(' ', '-', $buy['veh_reg'])) : '';
                                     $valuationDetails['val_prt_1'] = isset($vhNum['0']) ? $vhNum['0'] : '';
                                     $valuationDetails['val_prt_2'] = isset($vhNum['1']) ? $vhNum['1'] : '';
                                     $valuationDetails['val_prt_3'] = isset($vhNum['2']) ? $vhNum['2'] : '';
                                     $valuationDetails['val_prt_4'] = isset($vhNum['3']) ? $vhNum['3'] : '';

                                     $this->db->insert($this->tbl_valuation, array_filter($valuationDetails));
                                }
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

       function updateEnquiry($data) {
            //if($this->uid == 42) { debug($data); };
            generate_log(array(
                'log_title' => 'Updated enquiry',
                'log_desc' => serialize($data),
                'log_controller' => 'updateEnquiry',
                'log_action' => 'U',
                'log_ref_id' => 11,
                'log_added_by' => $this->uid
            ));
            //Update questions
            //if (isset($data['questions']) && !empty($data['questions'])) {

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
//                           $answer = array_values($value)[0];
                           //if (in_array($key, $questions) && !empty($answer)) {
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
//                           $answer = array_values($value)[0];
                           //if (in_array($key, $questions) && !empty($answer)) {
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
            } if ($enq_cus_status == 3) {
                 if (isset($data['exquestions']) && !empty($data['exquestions'])) {
                      foreach ($data['exquestions'] as $key => $value) {
//                           $answer = array_values($value)[0];
                           //if (in_array($key, $questions) && !empty($answer)) {
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
            //}
            //Update questions

            $showroom = get_logged_user('usr_showroom');
            if (!empty($data)) {
                 if (isset($data['enquiry']) && !empty($data['enquiry'])) {
                      /* Occupation */
                      if (isset($data['enquiry']['enq_cus_occu']) && !empty($data['enquiry']['enq_cus_occu'])) {
                           $occu = $this->db->like('occ_name', $data['enquiry']['enq_cus_occu'], 'both')->get($this->tbl_occupation)->row_array();
                           if (empty($occu)) {
                                $this->db->insert($this->tbl_occupation, array('occ_name' => $data['enquiry']['enq_cus_occu']));
                                $data['enquiry']['enq_cus_occu'] = $this->db->insert_id();
                           } else {
                                $data['enquiry']['enq_cus_occu'] = $occu['occ_id'];
                           }
                      } else {
                           $data['enquiry']['enq_cus_occu'] = 0;
                      }
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
                      /*if (isset($data['enquiry']['enq_cus_dist']) && !empty($data['enquiry']['enq_cus_dist'])) {
                           $dist = $this->db->like('dit_name', $data['enquiry']['enq_cus_dist'], 'both')->get($this->tbl_district)->row_array();
                           if (empty($dist)) {
                                $this->db->insert($this->tbl_district, array('dit_name' => $data['enquiry']['enq_cus_dist']));
                                $data['enquiry']['enq_cus_dist'] = $this->db->insert_id();
                           } else {
                                $data['enquiry']['enq_cus_dist'] = $dist['dit_id'];
                           }
                      } else {
                           $data['enquiry']['enq_cus_dist'] = 0;
                      }*/
                      /* State */
                      if (isset($data['enquiry']['enq_cus_state']) && !empty($data['enquiry']['enq_cus_state'])) {
                           $state = $this->db->like('stt_name', $data['enquiry']['enq_cus_state'], 'both')->get($this->tbl_state)->row_array();
                           if (empty($state)) {
                                $this->db->insert($this->tbl_state, array('stt_name' => $data['enquiry']['enq_cus_state']));
                                $data['enquiry']['enq_cus_state'] = $this->db->insert_id();
                           } else {
                                $data['enquiry']['enq_cus_state'] = $state['stt_id'];
                           }
                      } else {
                           $data['enquiry']['enq_cus_state'] = 0;
                      }
                      /* Country */
                      if (isset($data['enquiry']['enq_cus_country']) && !empty($data['enquiry']['enq_cus_country'])) {
                           $country = $this->db->like('cnt_name', $data['enquiry']['enq_cus_country'], 'both')->get($this->tbl_country)->row_array();
                           if (empty($country)) {
                                $this->db->insert($this->tbl_country, array('cnt_name' => $data['enquiry']['enq_cus_country']));
                                $data['enquiry']['enq_cus_country'] = $this->db->insert_id();
                           } else {
                                $data['enquiry']['enq_cus_country'] = $country['cnt_id'];
                           }
                      } else {
                           $data['enquiry']['enq_cus_country'] = 0;
                      }

                      $data['enquiry']['enq_cus_test_drive'] = isset($data['enquiry']['enq_cus_test_drive']) ? $data['enquiry']['enq_cus_test_drive'] : 0;

                      if (isset($data['enquiry']['enq_entry_date']) && !empty($data['enquiry']['enq_entry_date'])) {
                           $data['enquiry']['enq_entry_date'] = date('Y-m-d', strtotime($data['enquiry']['enq_entry_date']));
                      }
                      if (isset($data['enquiry']['enq_se_id']) && !empty($data['enquiry']['enq_se_id'])) {
                           $presentEnq = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $data['enq_id']))->row_array();
                           if ((isset($presentEnq['enq_se_id']) && !empty($presentEnq['enq_se_id'])) &&
                                   ($presentEnq['enq_se_id'] != $data['enquiry']['enq_se_id'])) {
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

                      $this->updateEnquiryLastView($data['enq_id']);
                      $this->db->where('enq_id', $data['enq_id']);
                      if ($this->db->update($this->tbl_enquiry, $data['enquiry'])) {

                           $noOfSale = isset($data['vehicle']['sale']['veh_brand']) ? count($data['vehicle']['sale']['veh_brand']) : 0;
                           $noOfBuy = isset($data['vehicle']['buy']['veh_brand']) ? count($data['vehicle']['buy']['veh_brand']) : 0;

                           for ($i = 0; $i < $noOfSale; $i++) {
                                $sale['veh_enq_id'] = $data['enq_id'];
                                $sale['veh_status'] = 1;
                                $sale['veh_brand'] = isset($data['vehicle']['sale']['veh_brand'][$i]) ? $data['vehicle']['sale']['veh_brand'][$i] : 0;
                                $sale['veh_model'] = isset($data['vehicle']['sale']['veh_model'][$i]) ? $data['vehicle']['sale']['veh_model'][$i] : 0;
                                $sale['veh_varient'] = isset($data['vehicle']['sale']['veh_varient'][$i]) ? $data['vehicle']['sale']['veh_varient'][$i] : 0;
                                $sale['veh_fuel'] = $data['vehicle']['sale']['veh_fuel'][$i];
                                $sale['veh_year'] = empty($data['vehicle']['sale']['veh_year'][$i]) ? 0 : $data['vehicle']['sale']['veh_year'][$i];
                                $sale['veh_color'] = $data['vehicle']['sale']['veh_color'][$i];
                                $sale['veh_price_from'] = empty($data['vehicle']['sale']['veh_price_from'][$i]) ? 0 : $data['vehicle']['sale']['veh_price_from'][$i];
                                $sale['veh_price_to'] = empty($data['vehicle']['sale']['veh_price_to'][$i]) ? 0 : $data['vehicle']['sale']['veh_price_to'][$i];
                                $sale['veh_km_from'] = empty($data['vehicle']['sale']['veh_km_from'][$i]) ? 0 : $data['vehicle']['sale']['veh_km_from'][$i];
                                $sale['veh_km_to'] = empty($data['vehicle']['sale']['veh_km_to'][$i]) ? 0 : $data['vehicle']['sale']['veh_km_to'][$i];
                                $sale['veh_reg'] = $data['vehicle']['sale']['veh_reg'][$i];
                                $sale['veh_owner'] = empty($data['vehicle']['sale']['veh_owner'][$i]) ? $data['vehicle']['sale']['veh_owner'][$i] : 0;
                                $sale['veh_remarks'] = $data['vehicle']['sale']['veh_remarks'][$i];
                                $sale['veh_stock_id'] = isset($data['vehicle']['sale']['veh_stock_id'][$i]) ? $data['vehicle']['sale']['veh_stock_id'][$i] : 0;
                                $sale['veh_added_by'] = $this->uid;
                                if (!empty($showroom)) {
                                     $sale['veh_showroom_id'] = $showroom;
                                }

                                if (isset($data['vehicle']['sale']['veh_id'][$i]) && !empty($data['vehicle']['sale']['veh_id'][$i])) {
                                     $this->db->where('veh_id', $data['vehicle']['sale']['veh_id'][$i]);
                                     $this->db->update($this->tbl_vehicle, $sale);
                                } else {
                                     $this->db->insert($this->tbl_vehicle, $sale);
                                }
                           }

                           for ($i = 0; $i < $noOfBuy; $i++) {
                                $buy['veh_enq_id'] = $data['enq_id'];
                                $buy['veh_status'] = 2;
                                $buy['veh_brand'] = isset($data['vehicle']['buy']['veh_brand'][$i]) ? $data['vehicle']['buy']['veh_brand'][$i] : 0;
                                $buy['veh_model'] = isset($data['vehicle']['buy']['veh_model'][$i]) ? $data['vehicle']['buy']['veh_model'][$i] : 0;
                                $buy['veh_varient'] = isset($data['vehicle']['buy']['veh_varient'][$i]) ? $data['vehicle']['buy']['veh_varient'][$i] : 0;
                                $buy['veh_fuel'] = $data['vehicle']['buy']['veh_fuel'][$i];
                                $buy['veh_year'] = empty($data['vehicle']['buy']['veh_year'][$i]) ? 0 : $data['vehicle']['buy']['veh_year'][$i];
                                $buy['veh_color'] = $data['vehicle']['buy']['veh_color'][$i];
                                $buy['veh_price_from'] = empty($data['vehicle']['buy']['veh_price_from'][$i]) ? 0 : $data['vehicle']['buy']['veh_price_from'][$i];
                                $buy['veh_price_to'] = empty($data['vehicle']['buy']['veh_price_to'][$i]) ? 0 : $data['vehicle']['buy']['veh_price_to'][$i];
                                $buy['veh_km_from'] = empty($data['vehicle']['buy']['veh_km_from'][$i]) ? 0 : $data['vehicle']['buy']['veh_km_from'][$i];
                                $buy['veh_km_to'] = empty($data['vehicle']['buy']['veh_km_to'][$i]) ? 0 : $data['vehicle']['buy']['veh_km_to'][$i];
                                $buy['veh_reg'] = $data['vehicle']['buy']['veh_reg'][$i];
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

       public function getBrands($id = '') {
            $this->db->select("branda.*, brandb.brd_title AS parent")
                    ->from($this->tbl_brand . ' branda')
                    ->join($this->tbl_brand . ' brandb', 'branda.brd_parent = brandb.brd_id', 'left');

            if (!empty($id)) {
                 $this->db->where('branda.brd_id', $id);
            }
            $this->db->order_by('branda.brd_title', 'asc');
            $brands = $this->db->get()->result_array();
            return $brands;
       }

       function getModel($id = '') {
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

       function getVariant($id = '') {
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

       function autoComPlace($qry) {
            if (!empty($qry)) {
                 $this->db->select('plc_id AS data, plc_name AS value');
                 $this->db->like('plc_name', $qry, 'after');
                 return $this->db->get($this->tbl_place)->result_array();
            }
       }

       function autoComOccupation($qry) {
            if (!empty($qry)) {
                 $this->db->select('occ_id AS data, occ_name AS value');
                 $this->db->like('occ_name', $qry, 'after');
                 return $this->db->get($this->tbl_occupation)->result_array();
            }
       }

       function autoComCountry($qry) {
            if (!empty($qry)) {
                 $this->db->select('cnt_id AS data, cnt_name AS value');
                 $this->db->like('cnt_name', $qry, 'after');
                 return $this->db->get($this->tbl_country)->result_array();
            }
       }

       function autoComCity($qry) {
            if (!empty($qry)) {
                 $this->db->select('cit_id AS data, cit_name AS value');
                 $this->db->like('cit_name', $qry, 'after');
                 return $this->db->get($this->tbl_city)->result_array();
            }
       }

       function autoComDistrict($qry) {
            if (!empty($qry)) {
                 $this->db->select('dit_id AS data, dit_name AS value');
                 $this->db->like('dit_name', $qry, 'after');
                 return $this->db->get($this->tbl_district)->result_array();
            }
       }

       function autoComState($qry) {
            if (!empty($qry)) {
                 $this->db->select('stt_id AS data, stt_name AS value');
                 $this->db->like('stt_name', $qry, 'after');
                 return $this->db->get($this->tbl_state)->result_array();
            }
       }

       function permenentDelete($enqId) {
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

       function getModelByBrand($id) {
            return $this->db->select($this->tbl_model . '.*, mod_id AS col_id, mod_title AS col_title')
                            ->where_in('mod_brand', $id)->get($this->tbl_model)->result_array();
       }

       function getVariantByModel($id) {
            return $this->db->select($this->tbl_variant . '.*, var_id AS col_id, var_variant_name AS col_title')
                            ->where_in('var_model_id', $id)->get($this->tbl_variant)->result_array();
       }

       function removeSaleOrPurchase($id) {
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

       function changeStatus($enqId, $status) {
            $this->db->get_where($this->tbl_statuses, array('sts_value' => $status))->sts_des;
            
            $this->db->where('enq_id', $enqId);
            $this->db->update($this->tbl_enquiry, array('enq_current_status' => $status));

            /*$follCmd['foll_remarks'] = $salesStaffName . ' take booking for ' . $data['add_info'];
            $follCmd['foll_cus_id'] = $enqId;
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
            $this->db->insert($this->tbl_followup, $follCmd);*/

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

       function getRequestedEnquires($enqId = '', $status = '', $filters = array()) {
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
                 
            } else if ($this->usr_grp == 'MG' || check_permission('enquiry', 'showdroppedenquiriesmyshowroom')) {
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
                                    $this->tbl_users . '.usr_last_name,' . $this->tbl_users . '.usr_id,addedby.usr_first_name AS enq_added_by_name,' . $this->tbl_enquiry_history . '.*')
                            ->join($this->tbl_users, $this->tbl_enquiry . '.enq_se_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                            ->join($this->tbl_users . ' addedby', $this->tbl_enquiry . '.enq_added_by = ' . 'addedby.usr_id', 'LEFT')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                            ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
                            ->where('enq_current_status', $status)->get($this->tbl_enquiry)->result_array();
            return $return;
       }

       function getTrackCardDetails($enqId) {

            $enq = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_occupation . '.*,' . $this->tbl_city . '.*,'
                                    . $this->tbl_district . '.*,' . $this->tbl_state . '.*,' . $this->tbl_country . '.*,'
                                    . $this->tbl_showroom . '.*,' . $this->tbl_users . '.*,'
                                    . $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des,' . $this->tbl_customer_grade . '.*')
                            ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
                            ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
                            ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
                            ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
                            ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'left')
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

                 $enq['vehicle_sall'] = $this->db->select($this->view_enquiry_vehicle_master . '.*,' . $this->tbl_statuses . '.*')
                                 ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->view_enquiry_vehicle_master . '.vst_current_status', 'LEFt')
                                 ->where($this->view_enquiry_vehicle_master . '.veh_enq_id = ' . $enqId .
                                         ' AND ' . $this->view_enquiry_vehicle_master . '.veh_status = 1 AND (' .
                                         $this->view_enquiry_vehicle_master . '.vst_current_status != 99 OR ' . $this->view_enquiry_vehicle_master . '.vst_current_status IS NULL)')
                                 ->get($this->view_enquiry_vehicle_master)->result_array();

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

       function getFreezedEnquires() {
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

       function getVehicleStatusDetails($vehId, $statusId) {

            return $this->db->order_by('vst_id', 'DESC')
                            ->get_where($this->tbl_vehicle_status, array('vst_vehicle_id' => $vehId, 'vst_status' => $statusId))->row_array();
       }

       function getOriginalFreezedEnquiry($mobileNo) {
            $mobileNo = substr($mobileNo, -10);
            $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                    ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left');
            return $this->db->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($this->tbl_enquiry . '.enq_current_status != 9')
                            ->like($this->tbl_enquiry . '.enq_cus_mobile', $mobileNo, 'both')->get($this->tbl_enquiry)->row_array();
       }

       function listEnqForAssign($id = '', $status = array(), $limit = 0, $page = 0, $exParams = array()) {
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

       function assignEnquires($datas) {
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

       public function readVehicleReg($id = '', $limit = 0, $page = 0, $filter = array()) {
            $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                            ->get($this->tbl_users)->row()->usr_id);

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
            }

            if (!empty($filter)) {
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
                 } if ($mod > 0) {
                      $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
                 } if ($var > 0) {
                      $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
                 }
                 if(isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])){
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
                 }
                 if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
                 } if ($vregShowroom > 0) {
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
                $this->tbl_brand . '.brd_id', $this->tbl_brand . '.brd_title',
                $this->tbl_model . '.mod_id', $this->tbl_model . '.mod_title',
                $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',
                $this->tbl_enquiry . '.enq_current_status',
                $this->tbl_callcenterbridging . '.ccb_recording_URL',
                $this->tbl_callcenterbridging . '.ccb_callStatus_id',
                $this->tbl_departments . '.dep_name', $this->tbl_district_statewise . '.*'
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
                 return $this->db->order_by($this->tbl_register_master . '.vreg_entry_date', 'DESC')
                                 ->get_where($this->tbl_register_master, array($this->tbl_register_master . '.vreg_id' => $id))->row_array();
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
            }
            if (!empty($filter)) {
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
                 } if ($mod > 0) {
                      $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
                 } if ($var > 0) {
                      $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
                 }
                 if(isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])){
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
                 }
                 if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
                 } if ($vregShowroom > 0) {
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
            //if($this->uid == 635) {
               //echo $this->db->last_query();
               //debug($return['data']);
            //}
            return $return;
       }

       function isFollowupPunched($enqId) {
            if (!empty($enqId)) {
                 return $this->db->get_where($this->tbl_followup, array('foll_cus_id' => $enqId))->row_array();
            }
            return null;
       }

       function registerExists($phoneNo) {
            if (!empty($phoneNo)) {
                 return $this->db->like('vreg_cust_phone', substr($phoneNo, -10), 'before')->get($this->tbl_register_master)->row_array();
            }
            return false;
       }

       function getInquiryQuestions() {
//            if ($this->uid != ADMIN_ID) {
//                 $this->db->where('qus_designation', $this->grp_id);
//            }
            $questions['sell'] = $this->db->order_by('qus_order')
                    ->get_where($this->tbl_questions, '(qus_category = 1 AND qus_status = 1) AND (qus_type = 2 OR qus_type = 1)')
                    ->result_array();
            //echo $this->db->last_query();exit;
//            if ($this->uid != ADMIN_ID) {
//                 $this->db->where('qus_designation', $this->grp_id);
//            }
            $questions['buy'] = $this->db->order_by('qus_order')
                    ->get_where($this->tbl_questions, '(qus_category = 1 AND qus_status = 1) AND (qus_type = 3 OR qus_type = 1)')
                    ->result_array();

//            if ($this->uid != ADMIN_ID) {
//                 $this->db->where('qus_designation', $this->grp_id);
//            }
            $questions['exch'] = $this->db->order_by('qus_order')
                    ->get_where($this->tbl_questions, '(qus_category = 1 AND qus_status = 1) AND (qus_type = 4 OR qus_type = 1)')
                    ->result_array();
            return $questions;
       }

       function addEnquiryHistory($datas) {
            if (!empty($datas)) {
                 $this->db->insert($this->tbl_enquiry_history, $datas);
                 return $this->db->insert_id();
            }
            return false;
       }

       function getBrandByDivision($divId) {
            return $this->db->select($this->tbl_brand . '.*, brd_id AS col_id, brd_title AS col_title')
                            ->where('brd_section', $divId)->get($this->tbl_brand)->result_array();
       }

       function bindShowroomByDivision($div) {
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

       function updateEnquiryLastView($enqId, $who = 0) {
            $who = $who > 0 ? $who : $this->uid;
            $this->db->where('enq_id', $enqId)->update($this->tbl_enquiry, array('enq_last_viewd' => $who));
            return true;
       }

       function sendBackRegister() {
            $this->load->model('registration/registration_model', 'registration');
            if (isset($_POST['assignedTo']) && isset($_POST['assignedFrom']) &&
                    isset($_POST['regMaster']) && isset($_POST['reason']) && isset($_POST['call_type'])) {

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
                     'vreg_last_action' => $_POST['reason'], 'vreg_call_type' => $_POST['call_type'],
                     'vreg_se_commented_on' => date('Y-m-d h:i:s'),
                     'vreg_assigned_to' => $_POST['assignedTo'], 'vreg_added_by' => $_POST['assignedFrom']));
            }
            return true;
       }

       /*function getQuickFollowupLeads() {
            $selectArray = array(
                $this->tbl_quick_tc_report . '.*',
                $this->tbl_enquiry . '.enq_entry_date',
                $this->tbl_enquiry . '.enq_id',
                $this->tbl_enquiry . '.enq_cus_name',
                $this->tbl_enquiry . '.enq_cus_whatsapp',
                $this->tbl_enquiry . '.enq_cus_mobile',
                $this->tbl_users . '.usr_username',
                $this->tbl_showroom . '.*'
            );
            if ($this->uid != ADMIN_ID && check_permission('enquiry', 'showonlyassigntome')) {
                 $this->db->where($this->tbl_quick_tc_report . '.qtr_assigned_to', $this->uid);
            }
            $this->db->where($this->tbl_quick_tc_report . '.qtr_replay IS NULL');
            $this->db->where($this->tbl_quick_tc_report . '.qtr_status', 1);
            $return = $this->db->select($selectArray)
                            ->join($this->tbl_enquiry, $this->tbl_quick_tc_report . '.qtr_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
                            ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
                            ->get($this->tbl_quick_tc_report)->result_array();
            return $return;
       }*/

       function getQuickFollowupMaster() {
          if (!check_permission('enquiry', 'showallqukassgnfollwupmstr')) {
               $this->db->like($this->tbl_quick_tc_report_master . '.qtrm_assign_to', $this->uid, 'both');
          }
          if($this->uid != ADMIN_ID) {
               $this->db->where($this->tbl_quick_tc_report_master . '.qtrm_status', 1);
          }
          return $this->db->select($this->tbl_quick_tc_report_master . '.*, ' . $this->tbl_users . '.usr_username')
                          ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_quick_tc_report_master . '.qtrm_added_by', 'LEFT')
                          ->get($this->tbl_quick_tc_report_master)->result_array();
     }

     function quickFollowupAnalysis($masterId) {
          $data['done'] = $this->db->where(array('qtr_reply_by > ' => 0, 'qtr_master_id' => $masterId))->count_all_results($this->tbl_quick_tc_report);
          $data['pend'] = $this->db->where(array('qtr_reply_by' => 0, 'qtr_master_id' => $masterId))->count_all_results($this->tbl_quick_tc_report);
          return $data;
     }
     
     function getQuickFollowupLeads($id) {
          $selectArray = array(
              $this->tbl_quick_tc_report . '.*',
              $this->tbl_enquiry . '.enq_entry_date',
              $this->tbl_enquiry . '.enq_id',
              $this->tbl_enquiry . '.enq_cus_name',
              $this->tbl_enquiry . '.enq_cus_whatsapp',
              $this->tbl_enquiry . '.enq_cus_mobile',
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

       function quickupdate($data) {
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
                    (isset($data['enqType']) && !empty($data['enqType']))) {

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

       function getBrandModel($enqId) {
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

       function registerTodaysanalysis() {
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

       function searchEnquiryByDateShowroomSe($limit = 0, $page = 0, $data) {
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
                 $this->db->where($this->tbl_enquiry . '.enq_cus_when_buy', $data['status']);
            }

            if (is_roo_user()) { // Admin users
            } else if ($this->usr_grp == 'MG') { // Manager
                 $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
            } else if ($this->usr_grp == 'DE') { // Date entry operator
                 $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $showroom);
            } else if ($this->usr_grp == 'SE') { // Seles executives
                 $this->db->where($this->tbl_enquiry . '.enq_se_id', $this->uid);
            } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) {// Team leed
                 $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
            }
            $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
            $return['count'] = $this->db->count_all_results($this->tbl_enquiry);
            //echo $this->db->last_query() . '<br>';

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
            } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) {// Team leed
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
            //echo $this->db->last_query();
            //debug($return);
            return $return;
       }

       function myinquiresByStatusExpExcel($data) {
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
            } else if ($this->usr_grp == 'TL' && !empty($mystaffs)) {// Team leed
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

       function selfregister() {
            $selectArray = array(
                $this->tbl_register_master . '.*',
                'assign.usr_first_name AS assign_usr_first_name',
                'assign.usr_last_name AS assign_usr_last_name',
                'addedby.usr_first_name AS addedby_usr_first_name',
                'addedby.usr_last_name AS addedby_usr_last_name',
                $this->tbl_events . '.evnt_title',
                $this->tbl_brand . '.brd_id', $this->tbl_brand . '.brd_title',
                $this->tbl_model . '.mod_id', $this->tbl_model . '.mod_title',
                $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',
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

       function setRegisterFollowup($data) {
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

       function regFollowups($regId) {
            return $this->db->select($this->tbl_register_followup . '.*,' . $this->tbl_users . '.usr_username')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_register_followup . '.regf_added_by', 'LEFT')
                            ->order_by($this->tbl_register_followup . '.regf_next_folowup', 'DESC')
                            ->get_where($this->tbl_register_followup, array($this->tbl_register_followup . '.regf_reg_id' => $regId))->result_array();
       }

       function getConnectedCallByRegister($regId) {
            return $this->db->select('ccb_recording_URL')->where(array('ccb_callStatus_id' => VB_CONNECTED, 'ccb_register_ref' => $regId))
                            ->get($this->tbl_callcenterbridging)->row_array();
       }

       function regPendingCount($uid = 0) {
            $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
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
            $return = $this->db->select($selectArray, false)
                            ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                            ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                            ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT')
                            ->where('vreg_assigned_to', $uid)->where('(vreg_is_punched = 0)')
//                            ->where('MONTH(' . $this->tbl_register_master . '.vreg_added_on) = MONTH(CURRENT_DATE())')
//                            ->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
                            ->get($this->tbl_register_master)->result_array();
            //echo $this->db->last_query();
            //debug($return);
            return $return;
       }

       function staffCanAssignEnquires() {
          return $this->db->select(array(
                              $this->tbl_users . '.usr_id',
                              $this->tbl_users . '.usr_first_name',
                              $this->tbl_users . '.usr_last_name',
                              $this->tbl_users_groups . '.group_id as group_id',
                              $this->tbl_groups . '.name as group_name',
                              $this->tbl_groups . '.description as group_desc',
                              $this->tbl_showroom . '.*'
                                  )
                          )
                          ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'left')
                          ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'left')
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                          ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1, 'usr_resigned' => 0))
                          ->order_by($this->tbl_users . '.usr_first_name')->get($this->tbl_users)->result_array();
     }

     function test() {
          echo 'Here';exit;
     }

     function reassignenquiry($data) {

          $loggeduserName = $this->session->userdata('usr_username');
          $loggeduserName = isset($data['reassigndby']) ? $data['reassigndby'] : $loggeduserName;

          $oldSE = $this->db->get_where($this->tbl_users, array('usr_id' => $data['old_se_id']))->row()->usr_first_name;
          $newSE = $this->db->get_where($this->tbl_users, array('usr_id' => $data['new_se_id']))->row()->usr_first_name;

          $newShowroom = $this->db->get_where($this->tbl_users, array('usr_id' => $data['new_se_id']))->row()->usr_showroom;
          $newDivision = $this->db->get_where($this->tbl_users, array('usr_id' => $data['new_se_id']))->row()->usr_division;

          //Sysytem comment
          $alias = 'One enquiry of ' . $oldSE . ' is re-assigned to ' . $newSE . ', re-assigned by ' . $loggeduserName;

          //Enquiry history
          $historyId = $this->addEnquiryHistory(array(
              'enh_enq_id' => $data['enq_id'],
              'enh_current_sales_executive' => $data['new_se_id'],
              'enh_source' => 1,
              'enh_remarks' => $data['remark'],
              'enh_added_by' => $this->uid,
              'enh_added_on' => date('Y-m-d H:i:s'),
              'enh_alias' => $alias,
              'enh_status' => 1
          ));

          //Update enquiry
          //enq_current_status_history added on 02-JUN-2021 11:08 PM
          $this->db->where('enq_id', $data['enq_id'])->update($this->tbl_enquiry, array(
               'enq_se_id' => $data['new_se_id'], 'enq_division' => $newDivision, 'enq_showroom_id' => $newShowroom , 
               'enq_current_status_history' => $historyId, 'enq_current_status' => 1
          ));

          //Foll rmark
          $foladdedby = isset($data['foll_added_by']) ? $data['foll_added_by'] : $this->uid;
          $folupdatby = isset($data['foll_updated_by']) ? $data['foll_updated_by'] : $this->uid;
          $this->load->model('followup/followup_model', 'followup');
          $this->followup->updateComments(array(
              'foll_remarks' => $alias,
              'foll_cus_id' => $data['enq_id'],
              'foll_parent' => 0,
              'foll_added_by' => $foladdedby,
              'foll_updated_by' => $folupdatby
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

     function getQuickAssignFollAssignTo($assignto) {
          if(!empty($assignto)){
               return $this->db->select('GROUP_CONCAT(usr_username) AS usr_username')
                       ->where_in('usr_id', $assignto)->get($this->tbl_users)->row()->usr_username;
          }
     }

     function getQuickFollowupLeadsAnalysis($id) {
          $selectArray = array(
              $this->tbl_quick_tc_report . '.*',
              $this->tbl_enquiry . '.enq_entry_date',
              $this->tbl_enquiry . '.enq_id',
              $this->tbl_enquiry . '.enq_cus_name',
              $this->tbl_enquiry . '.enq_cus_whatsapp',
              $this->tbl_enquiry . '.enq_cus_mobile',
              'newsalestaff.usr_username AS newse_username',
              'oldsalestaff.usr_username AS oldse_username',
              $this->tbl_showroom . '.*',
              'updatedby.usr_username AS updby_username',
              'assignedto.usr_username AS assignedto_username',
          );
          if ($this->uid != ADMIN_ID && check_permission('enquiry', 'showonlyassigntome')) {
               $this->db->where($this->tbl_quick_tc_report . '.qtr_assigned_to', $this->uid);
          }
          $this->db->where($this->tbl_quick_tc_report . '.qtr_master_id', $id);
          $return = $this->db->select($selectArray)
                          ->join($this->tbl_enquiry, $this->tbl_quick_tc_report . '.qtr_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
                          ->join($this->tbl_users . ' newsalestaff', 'newsalestaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                          ->join($this->tbl_users . ' oldsalestaff', 'oldsalestaff.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_se_id', 'LEFT')
                          ->join($this->tbl_users . ' updatedby', 'updatedby.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_reply_by', 'LEFT')
                          ->join($this->tbl_users . ' assignedto', 'assignedto.usr_id = ' . $this->tbl_quick_tc_report . '.qtr_assigned_to', 'LEFT')
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
                          ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_quick_tc_report)->result_array();
          return $return;
     }

     function getPurchaseVehicleNumber($enqId) {
          return $this->db->select('GROUP_CONCAT(veh_reg) AS veh_reg')->where('veh_enq_id', $enqId)->get($this->tbl_vehicle)->row()->veh_reg;
     }

     function getVehicleByEnquiryId($enqId) {
          $vehicle = $this->db->query("SELECT GROUP_CONCAT(IF(cpnl_vehicle.veh_brand=0, '', rana_brand.brd_title) , ' ',"
                          . "IF(cpnl_vehicle.veh_model=0, '', rana_model.mod_title), ' ' , IF(cpnl_vehicle.veh_varient=0, '', rana_variant.var_variant_name)) AS vehicle "
                          . "FROM cpnl_vehicle LEFT JOIN rana_brand ON rana_brand.brd_id = cpnl_vehicle.veh_brand "
                          . "LEFT JOIN rana_model ON rana_model.mod_id = cpnl_vehicle.veh_model "
                          . "LEFT JOIN rana_variant ON rana_variant.var_id = cpnl_vehicle.veh_varient "
                          . "WHERE cpnl_vehicle.veh_enq_id = " . $enqId)->row_array();
          return isset($vehicle['vehicle']) ? $vehicle['vehicle'] : '';
     }

     function reassigntosalesstaff($data) {
          $regId = isset($data['vreg_id']) ? $data['vreg_id'] : 0;
          if ($regId > 0) {
               unset($data['vreg_id']);
               $data['vreg_added_by'] = $this->uid;
               $this->db->where('vreg_id', $regId)->update($this->tbl_register_master, array_filter($data));

               //Register history
               $userDetails = $this->db->select('usr_username')->get_where($this->tbl_users,
                               array('usr_id' => $data['vreg_assigned_to']))->row_array();
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

     public function readVehicleRegReport($id = '', $limit = 0, $page = 0, $filter = array()) {
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
               } if ($mod > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
               } if ($var > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
               }
               if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
               }
               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               } if ($vregShowroom > 0) {
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
              $this->tbl_brand . '.brd_id', $this->tbl_brand . '.brd_title',
              $this->tbl_model . '.mod_id', $this->tbl_model . '.mod_title',
              $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',
              $this->tbl_enquiry . '.enq_current_status',
              $this->tbl_callcenterbridging . '.ccb_recording_URL',
              $this->tbl_callcenterbridging . '.ccb_callStatus_id',
              $this->tbl_departments . '.dep_name', $this->tbl_district_statewise . '.*'
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
               } if ($mod > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_model", $mod);
               } if ($var > 0) {
                    $this->db->where($this->tbl_register_master . ".vreg_varient", $var);
               }
               if (isset($filter['vreg_assigned_to']) && !empty($filter['vreg_assigned_to'])) {
                    $this->db->where($this->tbl_register_master . ".vreg_assigned_to", $filter['vreg_assigned_to']);
               }
               if ($vregDivision > 0) {
                    $this->db->where('vreg_division', $vregDivision);
               } if ($vregShowroom > 0) {
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

     function getTotalActiveStaff() {
          return $this->db->select('usr_username, usr_id')
                          ->where("usr_username IS NOT NULL AND usr_username != ''")
                          ->get_where($this->tbl_users, array('usr_active' => 1))->result_array();
     }

     function courtesyCallList() {
          $date1 = date('Y-m-d', strtotime(date("Y-m-d", strtotime("-3 day"))));
          $date2 = date('Y-m-d', strtotime(date("Y-m-d", strtotime("-5 day"))));
          $date3 = date('Y-m-d', strtotime(date("Y-m-d", strtotime("-20 day"))));
          
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
              $this->tbl_users . '.usr_first_name',
              $this->tbl_showroom . '.*',
              $this->tbl_occupation . '.*',
              $this->tbl_city . '.*',
              'teamLead.usr_username AS teamLead'
          );
          
          //Data before 3 days
          $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) =', $date1);
          if(!is_roo_user()) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          }
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          $return['dataThree'] = $this->db->select($selectArray)
                          ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
                          ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'LEFT')
                          ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city   ', 'LEFT')
                          ->join($this->tbl_users . ' teamLead', 'teamLead.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
                          ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_enquiry)->result_array();
          
          //Data before 5 days
          $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) =', $date2);
          if(!is_roo_user()) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          }
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          $return['dataFive'] = $this->db->select($selectArray)
                          ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
                          ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'LEFT')
                          ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city   ', 'LEFT')
                          ->join($this->tbl_users . ' teamLead', 'teamLead.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
                          ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_enquiry)->result_array();
          
          //Data before 20 days
          $this->db->where('DATE(' . $this->tbl_enquiry . '.enq_entry_date) =', $date3);
          if(!is_roo_user()) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          }
          $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
          $this->db->order_by($this->tbl_enquiry . '.enq_entry_date');
          $return['dataTwnty'] = $this->db->select($selectArray)
                          ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
                          ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'LEFT')
                          ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city   ', 'LEFT')
                          ->join($this->tbl_users . ' teamLead', 'teamLead.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
                          ->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')->get($this->tbl_enquiry)->result_array();
          return $return;
       }
 } 