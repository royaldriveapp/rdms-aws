<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class followup_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
//            $this->db->query("SET time_zone = '+05:30'");

            $this->tbl_city = TABLE_PREFIX . 'city';
            $this->tbl_state = TABLE_PREFIX . 'state';
            $this->tbl_place = TABLE_PREFIX . 'place';
            $this->tbl_model = TABLE_PREFIX_RANA . 'model';
            $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
            $this->tbl_users = TABLE_PREFIX . 'users';
            $this->tbl_states = TABLE_PREFIX . 'states';
            $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
            $this->tbl_valuation = TABLE_PREFIX . 'valuation';
            $this->tbl_showroom = TABLE_PREFIX . 'showroom';
            $this->tbl_country = TABLE_PREFIX . 'country';
            $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
            $this->tbl_statuses = TABLE_PREFIX . 'statuses';
            $this->tbl_followup = TABLE_PREFIX . 'followup';
            // $this->tbl_district = TABLE_PREFIX . 'district';
            $this->tbl_district = TABLE_PREFIX . 'district_statewise';
            $this->tbl_showroom = TABLE_PREFIX . 'showroom';
            $this->tbl_questions = TABLE_PREFIX . 'questions';
            $this->tbl_occupation = TABLE_PREFIX . 'occupation';
            $this->tbl_address_proof = TABLE_PREFIX . 'address_proof';
            $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
            $this->tbl_enq_prefrences = TABLE_PREFIX . 'enq_prefrences';
            $this->tbl_vehicle_status = TABLE_PREFIX . 'vehicle_status';
            $this->tbl_quick_tc_report = TABLE_PREFIX . 'quick_tc_report';
            $this->tbl_register_master = TABLE_PREFIX . 'register_master';
            $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
            $this->tbl_valuation_status = TABLE_PREFIX . 'valuation_status';
            $this->tbl_enquiry_questions = TABLE_PREFIX . 'enquiry_questions';
            $this->tbl_followup_view_log = TABLE_PREFIX . 'followup_view_log';
            $this->tbl_vehicle_booking_master = TABLE_PREFIX . 'vehicle_booking_master';
            $this->tbl_vehicle_booking_documents = TABLE_PREFIX . 'vehicle_booking_documents';
            $this->tbl_vehicle_booking_accessories = TABLE_PREFIX . 'vehicle_booking_accessories';
            $this->tbl_vehicle_booking_refurbishment = TABLE_PREFIX . 'vehicle_booking_refurbishment';
            $this->tbl_vehicle_booking_confirmations = TABLE_PREFIX . 'vehicle_booking_confirmations';
            $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
            $this->view_enquiry_vehicle_master = TABLE_PREFIX . 'view_enquiry_vehicle_master';
            $this->tbl_procurement_rqsts = TABLE_PREFIX . 'procurement_rqsts';
            $this->tbl_procurement_rqst_details = TABLE_PREFIX . 'procurement_rqst_details';
            $this->tbl_procurement_rqst_status = TABLE_PREFIX . 'procurement_rqst_status';
            $this->tbl_countries = TABLE_PREFIX . 'countries';
            $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
            $this->tbl_groups = TABLE_PREFIX . 'groups';
            $this->tbl_home_visits = TABLE_PREFIX . 'home_visits';
            $this->tbl_test_drives = TABLE_PREFIX . 'test_drives';
            $this->tbl_home_visits_approvals = TABLE_PREFIX . 'home_visit_approvals';
            $this->tbl_test_drive_approvals = TABLE_PREFIX . 'test_drive_approvals';
            $this->tbl_travel_modes = TABLE_PREFIX . 'travel_modes';
            $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
            $this->tbl_rto_office = TABLE_PREFIX . 'rto_office';
       }

       function getFollowupEnquires($id = '') {
            $this->load->model('evaluation/evaluation_model', 'evaluation');
            $showroom = get_logged_user('usr_showroom');
            if (!empty($id)) {
                 $enq = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_occupation . '.*,' . $this->tbl_city . '.*,'
                                         . $this->tbl_district . '.*,' . $this->tbl_state . '.*,' . $this->tbl_country . '.*,'
                                         . $this->tbl_users . '.*, enqaddedby.usr_first_name AS enq_added_by_name')
                                 ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
                                 ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
                                 // ->join($this->tbl_district, $this->tbl_district . '.dit_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
                                 ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
                                 ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
                                 ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                                 ->join($this->tbl_users, 'enqaddedby enqaddedby.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'LEFT')
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
                 generate_log(array(
                     'log_title' => 'List all records',
                     'log_desc' => 'List all records',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'L',
                     'log_added_by' => $this->uid
                 ));
                 $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                                 ->get($this->tbl_users)->row()->usr_id);
                 $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

                 if ($this->usr_grp == 'AD') {
                      
                 } else if ($this->usr_grp == 'SE') {
                      $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
                 } else if ($this->usr_grp == 'TL') {
                      $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
                 } else if ($this->usr_grp == 'MG') {
                      $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
                 } else if ($this->usr_grp == 'TC') {
                      $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
                 } else {
                      $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
                 }

                 return $this->db->select($this->tbl_enquiry . '.*,' .
                                         $this->tbl_users . '.*, enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                                 ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'LEFT')
                                 ->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') >= -2)')
                                 ->order_by($this->tbl_enquiry . '.enq_next_foll_date DESC')
                                 ->get($this->tbl_enquiry)->result_array();
            }
       }

       function get($id, $date = '') {

            if (!empty($id)) {
                 return $this->db->select($this->tbl_enquiry . '.enq_id, ' . $this->tbl_enquiry . '.enq_se_id, ' .
                                         $this->tbl_users . '.usr_id, ' . $this->tbl_users . '.usr_active, ' .
                                         $this->tbl_followup . '.*, ' . $this->tbl_vehicle . '.veh_status, ' .
                                         $this->tbl_vehicle . '.veh_brand, ' . $this->tbl_vehicle . '.veh_brand, ' . $this->tbl_vehicle . '.veh_varient,' .
                                         $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
                                 ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                                 ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_followup . '.foll_cus_id', 'LEFT')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                                 ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                 ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                 ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                 ->order_by($this->tbl_vehicle . '.veh_status', 'ASC')
                                 ->get_where($this->tbl_followup, array($this->tbl_followup . '.foll_cus_id' => $id,
                                     'DATE(' . $this->tbl_followup . '.foll_next_foll_date)' => $date))->result_array();
            }
       }

       function getFollowupByEnquiry($enqId) {//
            if (!empty($enqId)) {
                 $enq = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_occupation . '.*,' . $this->tbl_city . '.*,'
                                         . $this->tbl_district . '.*,' . $this->tbl_state . '.*,' . $this->tbl_country . '.*,' . $this->tbl_users . '.*,' .
                                         $this->tbl_statuses . '.*')
                                 ->join($this->tbl_occupation, $this->tbl_occupation . '.occ_id = ' . $this->tbl_enquiry . '.enq_cus_occu', 'left')
                                 ->join($this->tbl_city, $this->tbl_city . '.cit_id = ' . $this->tbl_enquiry . '.enq_cus_city', 'left')
                                 ->join($this->tbl_district, $this->tbl_district . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
                                 ->join($this->tbl_state, $this->tbl_state . '.stt_id = ' . $this->tbl_enquiry . '.enq_cus_state', 'left')
                                 ->join($this->tbl_country, $this->tbl_country . '.cnt_id = ' . $this->tbl_enquiry . '.enq_cus_country', 'left')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                                 ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_value', 'left')
                                 ->where($this->tbl_enquiry . '.enq_id', $enqId)->get($this->tbl_enquiry)->row_array();

                 if (!empty($enq)) {
                      //$whr = array('veh_enq_id' => $id, 'veh_status' => 2, 'veh_type' => 0,'veh_enq_type_old'=>NULL);//buy
                      $enq['vehicle_sale'] = $this->db->select($this->tbl_vehicle . '.*, ' . $this->tbl_brand . '.brd_title,' .
                                              $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
                                      ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                      ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                      ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                      ->get_where($this->tbl_vehicle, array($this->tbl_vehicle . '.veh_status' => 1, $this->tbl_vehicle . '.veh_enq_id' => $enqId, $this->tbl_vehicle . '.veh_changed_to' => 0, 'veh_enq_type_old' => NULL))->result_array();
                      $enq['vehicle_sale_req'] = $this->db->select($this->tbl_vehicle . '.*, ' . $this->tbl_brand . '.brd_title,' .
                                              $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
                                      ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                      ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                      ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                      ->get_where($this->tbl_vehicle, array($this->tbl_vehicle . '.veh_status' => 1, $this->tbl_vehicle . '.veh_enq_id' => $enqId, $this->tbl_vehicle . '.veh_type' => 1, $this->tbl_vehicle . '.veh_changed_to' => 0, 'veh_enq_type_old' => NULL))->result_array();
                      $enq['vehicle_sale_pitched'] = $this->db->select($this->tbl_vehicle . '.*, ' . $this->tbl_brand . '.brd_title,' .
                                              $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
                                      ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                      ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                      ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                      ->get_where($this->tbl_vehicle, array($this->tbl_vehicle . '.veh_status' => 1, $this->tbl_vehicle . '.veh_enq_id' => $enqId, $this->tbl_vehicle . '.veh_type' => 3, $this->tbl_vehicle . '.veh_changed_to' => 0, 'veh_enq_type_old' => NULL))->result_array();

                      $enq['vehicle_buy'] = $this->db->select($this->tbl_vehicle . '.*, ' . $this->tbl_brand . '.brd_title,' .
                                              $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
                                      ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                      ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                      ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                      ->get_where($this->tbl_vehicle, array($this->tbl_vehicle . '.veh_status' => 2, $this->tbl_vehicle . '.veh_enq_id' => $enqId, $this->tbl_vehicle . '.veh_changed_to' => 0, 'veh_enq_type_old' => NULL))->result_array();

                      if ($this->uid != ADMIN_ID && check_permission('followup', 'disableotherfollowup')) {
                           $this->db->where(array($this->tbl_followup . '.foll_added_by' => $this->uid));
                      }

                      $enq['followups'] = $this->db->select($this->tbl_followup . '.*, ' .
                                              $this->tbl_vehicle . '.veh_brand, ' . $this->tbl_vehicle . '.veh_model, ' .
                                              $this->tbl_vehicle . '.veh_type, ' . $this->tbl_vehicle . '.veh_stock_id, ' .
                                              $this->tbl_brand . '.brd_title,' . $this->tbl_vehicle . '.veh_varient,' .
                                              $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
                                              $this->tbl_users . '.usr_username AS folloup_added_by, ' . $this->tbl_users . '.usr_id AS folloup_added_by_id,' .
                                              $this->tbl_users . '.usr_avatar, ' . $this->tbl_showroom . '.shr_location, ' .
                                              'updatedby.usr_username AS folloup_upd_by, updatedby.usr_id AS folloup_upd_by_id')
                                      ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                                      ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                      ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                      ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_followup . '.foll_added_by', 'LEFT')
                                      ->join($this->tbl_users . ' updatedby', 'updatedby.usr_id = ' . $this->tbl_followup . '.foll_updated_by', 'LEFT')
                                      ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                                      ->order_by($this->tbl_followup . '.foll_id', 'DESC')->get_where($this->tbl_followup, array($this->tbl_followup . '.foll_cus_id' => $enqId, 'foll_parent' => 0))->result_array();
                      //Question answers
                      $enq['questionAnswers'] = array();
                      if ($enq['enq_cus_status'] == 1) { // Sale
                           $enq['questionAnswers'] = $this->db->select($this->tbl_questions . '.*,' . $this->tbl_enquiry_questions . '.*')
                                   ->join($this->tbl_enquiry_questions, $this->tbl_enquiry_questions . '.enqq_question_id = ' . $this->tbl_questions . '.qus_id', 'LEFT ')
                                   ->order_by($this->tbl_questions . '.qus_order')
                                   ->get_where($this->tbl_questions, '(' . $this->tbl_questions . '.qus_type = 1 OR ' . $this->tbl_questions . '.qus_type = 2) AND (' .
                                           $this->tbl_enquiry_questions . '.enqq_enq_id = ' . $enqId . ' OR cpnl_enquiry_questions.enqq_enq_id IS NULL)')
                                   ->result_array();
                      } else if ($enq['enq_cus_status'] == 2) { // Buy
                           $enq['questionAnswers'] = $this->db->select($this->tbl_questions . '.*,' . $this->tbl_enquiry_questions . '.*')
                                   ->join($this->tbl_enquiry_questions, $this->tbl_enquiry_questions . '.enqq_question_id = ' . $this->tbl_questions . '.qus_id', 'LEFT')
                                   ->order_by($this->tbl_questions . '.qus_order')
                                   ->get_where($this->tbl_questions, '(' . $this->tbl_questions . '.qus_type = 1 OR ' . $this->tbl_questions . '.qus_type = 3) AND (' .
                                           $this->tbl_enquiry_questions . '.enqq_enq_id = ' . $enqId . ' OR cpnl_enquiry_questions.enqq_enq_id IS NULL)')
                                   ->result_array();
                      } else if ($enq['enq_cus_status'] == 3) { // Exch
                           $enq['questionAnswers'] = $this->db->select($this->tbl_questions . '.*,' . $this->tbl_enquiry_questions . '.*')
                                   ->join($this->tbl_enquiry_questions, $this->tbl_enquiry_questions . '.enqq_question_id = ' . $this->tbl_questions . '.qus_id', 'LEFT')
                                   ->order_by($this->tbl_questions . '.qus_order')
                                   ->get_where($this->tbl_questions, '(' . $this->tbl_questions . '.qus_type = 1 OR ' . $this->tbl_questions . '.qus_type = 4) AND (' .
                                           $this->tbl_enquiry_questions . '.enqq_enq_id = ' . $enqId . ' OR cpnl_enquiry_questions.enqq_enq_id IS NULL)')
                                   ->result_array();
                      }
                 }

                 return $enq;
            }
       }

       function addFollowUp($datas) {
            if (!empty($datas)) {

                 $datas['foll_next_foll_date'] = (isset($datas['foll_next_foll_date']) && !empty($datas['foll_next_foll_date'])) ?
                         date('Y-m-d h:i:s', strtotime($datas['foll_next_foll_date'])) : '';

                 $datas['foll_added_by'] = get_logged_user('usr_id');
                 $datas['foll_entry_date'] = date('Y-m-d H:i:s');
                 $datas = array_filter($datas);
                 if ($this->db->insert($this->tbl_followup, $datas)) {
                      $id = $this->db->insert_id();
                      generate_log(array(
                          'log_title' => 'New followup',
                          'log_desc' => serialize($datas),
                          'log_controller' => strtolower(__CLASS__),
                          'log_action' => 'C',
                          'log_ref_id' => $id,
                          'log_added_by' => get_logged_user('usr_id')
                      ));

                      if ((isset($datas['foll_cus_id']) && !empty($datas['foll_cus_id'])) &&
                              !empty($datas['foll_next_foll_date'])) {
                           $follStatus = isset($datas['foll_status']) ? $datas['foll_status'] : 0;
                           $this->db->where('enq_id', $datas['foll_cus_id']);
                           $this->db->update($this->tbl_enquiry, array(
                               'enq_next_foll_date' => $datas['foll_next_foll_date'],
                               'enq_cus_when_buy' => $follStatus)
                           );

                           generate_log(array(
                               'log_title' => 'Followup updated',
                               'log_desc' => 'Followup date updated on inquiry follup id-' . $id,
                               'log_controller' => 'update-foll-date-enq',
                               'log_action' => 'U',
                               'log_ref_id' => $datas['foll_cus_id'],
                               'log_added_by' => get_logged_user('usr_id')
                           ));
                      }
                      /* Update as punched */
                      $this->db->where('vreg_inquiry', $datas['foll_cus_id']);
                      $this->db->update($this->tbl_register_master, array('vreg_is_punched' => 1));

                      return true;
                 }
            } else {
                 return false;
            }
       }

       function missedCount() {
            $selectArray = array(
                $this->tbl_enquiry . '.enq_se_id',
                $this->tbl_enquiry . '.enq_mode_enq',
                $this->tbl_users . '.usr_first_name',
                $this->tbl_users . '.usr_active',
                'count(*) AS msdfolcnt'
            );

            return $this->db->select($selectArray)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                            ->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
                            ->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)')
                            ->order_by($this->tbl_users . '.usr_active', 'DESC')
                            ->order_by('msdfolcnt', 'DESC')->group_by($this->tbl_enquiry . '.enq_se_id')->get($this->tbl_enquiry)->result_array();
       }

       function missed($userId, $search = '', $limit = 0, $page = 0) {
            $showroom = get_logged_user('usr_showroom');
            $mystaffs = array($userId);
            if ($this->usr_grp == 'TL') {
                 $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                                 ->get($this->tbl_users)->row()->usr_id);
            }
            $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status IS NULL OR ' . $this->tbl_enquiry . '.enq_current_status = 1)');
            if ($this->usr_grp == 'SE') {
                 $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
            } else if ($this->usr_grp == 'MG') {
                 $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
            } else if ($this->usr_grp == 'TL' || !empty($mystaffs)) {
                 $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
            } else if (!is_roo_user()) {
                 $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
            }
            if (!empty($search)) {
                 $whereSearch = '(' . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_users . ".usr_first_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $search . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_whatsapp LIKE '%" . $search . "%' )";
                 $this->db->where($whereSearch);
            }
            $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' .
                                    $this->tbl_users . '.*, enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                            ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'LEFT')
                            ->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses)
                            ->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)')
                            ->order_by($this->tbl_enquiry . '.enq_next_foll_date DESC')->count_all_results($this->tbl_enquiry);

            $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status IS NULL OR ' . $this->tbl_enquiry . '.enq_current_status = 1)');
            if ($this->usr_grp == 'SE') {
                 $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
            } else if ($this->usr_grp == 'MG') {
                 $this->db->where($this->tbl_enquiry . '.enq_showroom_id = ' . $showroom);
            } else if ($this->usr_grp == 'TL' || !empty($mystaffs)) {
                 $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
            } else if (!is_roo_user()) {
                 $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
            }

            if ($limit) {
                 $this->db->limit($limit, $page);
            }
            if (!empty($search)) {
                 $whereSearch = '(' . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_users . ".usr_first_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $search . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_whatsapp LIKE '%" . $search . "%' )";
                 $this->db->where($whereSearch);
            }
            $selectArray = array(
                $this->tbl_enquiry . '.enq_id',
                $this->tbl_enquiry . '.enq_added_by',
                $this->tbl_enquiry . '.enq_cus_name',
                $this->tbl_enquiry . '.enq_cus_mobile',
                $this->tbl_enquiry . '.enq_cus_whatsapp',
                $this->tbl_enquiry . '.enq_entry_date',
                $this->tbl_enquiry . '.enq_added_by',
                $this->tbl_enquiry . '.enq_se_id',
                $this->tbl_enquiry . '.enq_mode_enq',
                $this->tbl_users . '.usr_id',
                $this->tbl_users . '.usr_first_name',
                'enqaddedby.usr_first_name AS enq_added_by_name',
                'enqaddedby.usr_id AS enq_added_by_id'
            );
            $return['data'] = $this->db->select($selectArray)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                            ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'LEFT')
                            ->where($this->tbl_enquiry . '.enq_current_status', 1)
                            ->where('(DATEDIFF(DATE(' . $this->tbl_enquiry . '.enq_next_foll_date), ' . "DATE('" . date('Y-m-d') . "')" . ') <= -3)')
                            ->order_by($this->tbl_enquiry . '.enq_next_foll_date DESC')
                            ->get($this->tbl_enquiry)->result_array();
            // echo $this->db->last_query();
            // exit;
            return $return;
       }

       function missedtemp() {
            $showroom = get_logged_user('usr_showroom');

            $where = ' WHERE (' . $this->tbl_enquiry . '.enq_current_status IS NULL OR ' . $this->tbl_enquiry . '.enq_current_status = 1) ';
            if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
                 $where .= ' AND ' . $this->tbl_enquiry . '.enq_se_id = ' . $this->uid;
            }

            if ($this->usr_grp == 'MG') {
                 $where .= ' AND ' . $this->tbl_enquiry . '.enq_showroom_id = ' . $showroom;
            }
            $today = date('Y-m-d');
            return $this->db->query("SELECT t1.*, cpnl_enquiry.*, cpnl_users.*
                    FROM cpnl_followup AS t1
                    JOIN (SELECT MAX(foll_id) AS max_id, `foll_id` FROM cpnl_followup WHERE DATEDIFF(DATE(foll_next_foll_date), '$today') <= -3 GROUP BY `foll_cus_id`) AS t2 ON t1.foll_id = t2.foll_id 
                    LEFT join cpnl_enquiry on cpnl_enquiry.enq_id = t1.foll_cus_id 
                    LEFT join cpnl_users on cpnl_users.usr_id = cpnl_enquiry.enq_se_id
                    " . $where . ' ORDER BY t1.foll_id')->result_array();
       }

       function editFollowUp($datas) {
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            generate_log(array(
                'log_title' => 'New followup',
                'log_desc' => serialize($datas),
                'log_controller' => 'edit-follow-up',
                'log_action' => 'U',
                'log_ref_id' => 1,
                'log_added_by' => $this->uid
            ));
            if (isset($datas['followup']['foll_next_foll_date']) && !empty($datas['followup']['foll_next_foll_date'])) {
                 $nextFollDate = date('Y-m-d', strtotime($datas['followup']['foll_next_foll_date']));
                 $follupAlreadyEntered = $this->db->get_where($this->tbl_followup, array('foll_cus_id' => $datas['foll_cus_id'],
                             'DATE(' . $this->tbl_followup . '.foll_next_foll_date)' => $nextFollDate))->row_array();

                 if (isset($datas['foll_customer_feedback']) && !empty($datas['foll_customer_feedback'])) {
                      foreach ($datas['foll_customer_feedback'] as $key => $value) {
                           if (!empty($value)) {
                                $updateData = array();
                                $updateData['foll_customer_feedback'] = $value;
                                $updateData['foll_customer_feedback_added_date'] = date('Y-m-d');
                                $updateData['foll_updated_by'] = $this->uid;
                                $updateData['foll_is_dar_submited'] = 0;
                                $this->db->where('foll_id', $key);
                                if ($this->db->update($this->tbl_followup, $updateData)) {
                                     generate_log(array(
                                         'log_title' => 'Update followup',
                                         'log_desc' => 'Followup updated',
                                         'log_controller' => strtolower(__CLASS__),
                                         'log_action' => 'U',
                                         'log_ref_id' => $key,
                                         'log_added_by' => get_logged_user('usr_id')
                                     ));
                                }
                           }
                           if (empty($follupAlreadyEntered)) { // Create new followup
                                $follup = $this->db->get_where($this->tbl_followup, array('foll_id' => $key))->row_array();
                                if (!empty($follup)) {
                                     $datas['followup']['foll_cus_id'] = $follup['foll_cus_id'];
                                     $datas['followup']['foll_cus_vehicle_id'] = $follup['foll_cus_vehicle_id'];
                                }
                                if ((isset($datas['followup']['foll_status']) && !empty(isset($datas['followup']['foll_status']))) &&
                                        (isset($datas['followup']['foll_contact']) && !empty(isset($datas['followup']['foll_contact']))) &&
                                        (isset($datas['followup']['foll_action_plan']) && !empty(isset($datas['followup']['foll_action_plan']))) &&
                                        (isset($datas['followup']['foll_next_foll_date']) && !empty(isset($datas['followup']['foll_next_foll_date']))) &&
                                        (isset($datas['followup']['foll_remarks']) && !empty(isset($datas['followup']['foll_remarks'])))) {
                                     $this->addFollowUp($datas['followup']);
                                }
                           } else { // update existing followup
                                $datas['followup']['foll_next_foll_date'] = $nextFollDate;
                                $this->db->where('foll_id', $key);
                                $this->db->update($this->tbl_followup, $datas['followup']);
                           }
                      }
                 }
                 return true;
            }
            return false;
       }

       function quickUpdateFollowup($datas) {
            if (isset($datas['foll_customer_feedback']) && !empty($datas['foll_customer_feedback'])) {
                 foreach ($datas['foll_customer_feedback'] as $key => $value) {

                      if (!empty($value)) {
                           $updateData = array();
                           $updateData['foll_customer_feedback'] = $value;
                           $updateData['foll_updated_by'] = get_logged_user('usr_id');
                           $updateData['foll_is_dar_submited'] = 0;
                           $this->db->where('foll_id', $key);
                           if ($this->db->update($this->tbl_followup, $updateData)) {
                                generate_log(array(
                                    'log_title' => 'Update followup',
                                    'log_desc' => serialize($updateData),
                                    'log_controller' => 'followup-update-by-admin',
                                    'log_action' => 'U',
                                    'log_ref_id' => $key,
                                    'log_added_by' => get_logged_user('usr_id')
                                ));
                           }
                      }
                 }
                 return true;
            }
            return false;
       }

       function getFollowup($id) {
            return $this->db->order_by('foll_entry_date', 'DESC')->get_where($this->tbl_followup, array('foll_cus_vehicle_id' => $id))->result_array();
       }

       function getVehicle($id) {
            if (!empty($id)) {
                 $vehicles['statuses'] = '';
                 $vehicles = $this->db->get_where($this->view_enquiry_vehicle_master, array($this->view_enquiry_vehicle_master . '.veh_id' => $id))->row_array();
                 if (isset($vehicles['veh_id'])) {
                      $vehicles['statuses'] = $this->db->select($this->tbl_vehicle_status . '.*, ' . $this->tbl_statuses . '.*')
                                      ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_id = ' . $this->tbl_vehicle_status . '.vst_status')
                                      ->order_by($this->tbl_vehicle_status . '.vst_id', 'DESC')->where($this->tbl_vehicle_status . '.vst_vehicle_id', $vehicles['veh_id'])
                                      ->get($this->tbl_vehicle_status)->result_array();
                      $vehicles['current_status'] = $this->db->get_where($this->tbl_statuses, array('sts_value' => $vehicles['vst_current_status']))->row_array();
                 }
                 return $vehicles;
            } else {
                 return false;
            }
       }

       function changeStatus($data) {
            if (!empty($data)) {
                 $data['enh_added_by'] = $this->uid;
                 if ($this->db->insert($this->tbl_enquiry_history, $data)) {
                      $enqHistoryId = $this->db->insert_id();

                      /* Folowup comment */
                      $curStatus = $this->db->get_where($this->tbl_statuses, array('sts_value' => $data['enh_status']))->row_array();
                      $selectArray = array(
                          $this->tbl_enquiry . '.enq_se_id',
                          $this->tbl_enquiry . '.enq_cus_name',
                          $this->tbl_enquiry . '.enq_cus_mobile',
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

                      if ($data['enh_status'] == loss_of_sale_or_buy || $data['enh_status'] == enq_lost ||
                              $data['enh_status'] == enq_req_drop || $data['enh_status'] == enq_droped) {
                           // To cold
                           $enUpdate = array(
                               'enq_current_status' => $data['enh_status'],
                               'enq_cus_when_buy' => 4,
                               'enq_current_status_history' => $enqHistoryId
                           );
                      }
                      $this->db->where('enq_id', $data['enh_enq_id']);
                      $this->db->update($this->tbl_enquiry, $enUpdate);
                      generate_log(array(
                          'log_title' => 'Change enquiry status',
                          'log_desc' => 'Status has been changed',
                          'log_controller' => strtolower(__CLASS__),
                          'log_action' => 'C',
                          'log_ref_id' => $enqHistoryId,
                          'log_added_by' => get_logged_user('usr_id')
                      ));
                      return true;
                 }
            }
            return false;
            /* $data['vst_added_by'] = get_logged_user('usr_id');
              if ((isset($data['vst_evaluation_id']) && !empty($data['vst_evaluation_id'])) && isset($data['est_status'])) {
              $this->db->insert($this->tbl_valuation_status, array(
              'est_enq_veh_id' => $data['vst_vehicle_id'],
              'est_enq_id' => $data['vst_enq_id'],
              'est_valuation_id' => $data['vst_evaluation_id'],
              'est_status' => $data['est_status'],
              'est_added_by' => get_logged_user('usr_id')));
              }
              unset($data['vst_evaluation_id']);
              unset($data['est_status']);
              if ($this->db->insert($this->tbl_vehicle_status, $data)) {
              generate_log(array(
              'log_title' => 'Change status',
              'log_desc' => 'Status has been changed',
              'log_controller' => strtolower(__CLASS__),
              'log_action' => 'C',
              'log_ref_id' => 0,
              'log_added_by' => get_logged_user('usr_id')
              ));
              return true;
              } else {
              generate_log(array(
              'log_title' => 'Change status',
              'log_desc' => 'Status has been changed',
              'log_controller' => strtolower(__CLASS__),
              'log_action' => 'C',
              'log_ref_id' => 0,
              'log_added_by' => get_logged_user('usr_id')
              ));
              return false;
              } */
       }

       function resetMisdFollup($nextFollowupDetails, $misdFolEnqId) {
            if (!empty($misdFolEnqId)) {
                 foreach ($misdFolEnqId as $key => $enqId) {
                      $nextFollowupDetails['foll_next_foll_date'] = date('Y-m-d', strtotime($nextFollowupDetails['foll_next_foll_date']));
                      $enqDetails = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $enqId))->row_array();
                      if (!empty($enqDetails)) {
                           $modOfContact = 0;
                           $missedFollwups = $this->db->select($this->tbl_followup . '.*')
                                           ->where('DATEDIFF(DATE(' . $this->tbl_followup . '.foll_next_foll_date), ' . TODAY . ') <= -3 AND '
                                                   . " (foll_customer_feedback IS NULL OR foll_customer_feedback = '')")
                                           ->where($this->tbl_followup . '.foll_cus_id', $enqId)->get($this->tbl_followup)->result_array();

                           foreach ((array) $missedFollwups as $key => $foll) {
                                $modOfContact = $foll['foll_contact'];
                                generate_log(array(
                                    'log_title' => 'Reset followup date to -' . $nextFollowupDetails['foll_next_foll_date'],
                                    'log_desc' => serialize($foll),
                                    'log_controller' => 'reset-followup-date',
                                    'log_action' => 'U',
                                    'log_ref_id' => $foll['foll_id'],
                                    'log_added_by' => get_logged_user('usr_id')
                                ));
                                $updateFollUp = array(
                                    'foll_customer_feedback' => get_settings_by_key('comn_foll_customer_feedback'),
                                    'foll_customer_feedback_added_date' => date('Y-m-d h:i:s'),
                                    'foll_updated_by' => $this->uid,
                                    'foll_is_dar_submited' => 0
                                );
                                $this->db->where('foll_id', $foll['foll_id']);
                                $this->db->update($this->tbl_followup, $updateFollUp);
                           }

                           $vehicles = $this->db->get_where($this->tbl_vehicle, array('veh_enq_id' => $enqId))->result_array();

                           foreach ((array) $vehicles as $key => $veh) {
                                $nextFollowupDetails['foll_cus_id'] = $enqId;
                                $nextFollowupDetails['foll_cus_vehicle_id'] = $veh['veh_id'];
                                $nextFollowupDetails['foll_entry_date'] = date('Y-m-d H:i:s');
                                $nextFollowupDetails['foll_contact'] = $modOfContact;
                                $nextFollowupDetails = array_filter($nextFollowupDetails);
                                $this->db->insert($this->tbl_followup, $nextFollowupDetails);
                                $newFollId = $this->db->insert_id();

                                $this->db->where('enq_id', $enqId);
                                $this->db->update($this->tbl_enquiry, array('enq_next_foll_date' => $nextFollowupDetails['foll_next_foll_date']));

                                generate_log(array(
                                    'log_title' => 'New followup',
                                    'log_desc' => 'New followup added',
                                    'log_controller' => 'new-foll-after-rest',
                                    'log_action' => 'C',
                                    'log_ref_id' => $newFollId,
                                    'log_added_by' => get_logged_user('usr_id')
                                ));
                           }
                      }
                 }
            }
            return true;
       }

       function getfollowupByDate($enqId, $datas) {
            if (!empty($enqId) && !empty($datas)) {
                 if (isset($datas['newDate'])) {
                      $date = date('Y-m-d', strtotime($datas['newDate']));
                      $return = array();
                      //Get previos date data if any
                      $return['data'] = $this->db->select($this->tbl_followup . '.*, ' . $this->tbl_vehicle . '.veh_status, ' .
                                              $this->tbl_vehicle . '.veh_brand, ' . $this->tbl_vehicle . '.veh_brand, ' . $this->tbl_vehicle . '.veh_varient,' .
                                              $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
                                      ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                                      ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                      ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                      ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                      ->order_by($this->tbl_vehicle . '.veh_status', 'ASC')
                                      ->get_where($this->tbl_followup, array($this->tbl_followup . '.foll_cus_id' => $enqId,
                                          'DATE(' . $this->tbl_followup . '.foll_next_foll_date)' => $date))->result_array();
                      $return['message'] = !empty($return['data']) ? 'You have already entered the followup on ' . $date . ', you can update the followup now.' : '';
                      //Get current date followup details if previos date is empty
                      if (empty($return['data']) && (isset($datas['currentDate']) && !empty($datas['currentDate']))) {
                           $return['data'] = $this->db->select($this->tbl_followup . '.*, ' . $this->tbl_vehicle . '.veh_status, ' .
                                                   $this->tbl_vehicle . '.veh_brand, ' . $this->tbl_vehicle . '.veh_brand, ' . $this->tbl_vehicle . '.veh_varient,' .
                                                   $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
                                           ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                                           ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                                           ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                                           ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                                           ->order_by($this->tbl_vehicle . '.veh_status', 'ASC')
                                           ->get_where($this->tbl_followup, array($this->tbl_followup . '.foll_cus_id' => $enqId,
                                               'DATE(' . $this->tbl_followup . '.foll_next_foll_date)' => $datas['currentDate']))->result_array();
                           $return['message'] = !empty($return['data']) ? "Can't found followup on $date, please add or modify followup details on " . $datas['currentDate'] : '';
                      }
                      return $return;
                 }
            }
       }

       function getNextFollowupDate($enqId) {
            if (!empty($enqId)) {
                 $next = $this->db->order_by('foll_id', 'DESC')->get_where($this->tbl_followup, array('foll_cus_id' => $enqId,
                             'foll_customer_feedback' => NULL))->row_array();
                 if (!empty($next)) {
                      return $next;
                 } else {
                      return $this->db->order_by('foll_id', 'DESC')->get_where($this->tbl_followup, array('foll_cus_id' => $enqId))->row_array();
                 }
            }
            return false;
       }

       function getLatestFollowupDate($enqId, $format = 'Y-m-d') {
            if (!empty($enqId)) {
                 $date = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $enqId))->row()->enq_next_foll_date;
                 if (!empty($date)) {
                      return date($format, strtotime($date));
                 }
            }
            return false;
       }

       function changeTestDriveHomeVisit($enqId, $type, $status) {
            if (!empty($enqId) && !empty($type)) {
                 $status = isset($status['status']) ? $status['status'] : '';
                 $this->db->where('enq_id', $enqId);
                 $this->db->update($this->tbl_enquiry, array($type => $status));
                 return true;
            }
            return false;
       }

       function updateEnquiryQuestions($data) {
            if (!empty($data)) {
                 $enq_cus_status = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $data['enq_id']))->row()->enq_cus_status;

                 $questions = array();
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

                 $this->db->where('enqq_enq_id', $data['enq_id']);
                 $this->db->delete($this->tbl_enquiry_questions);

                 foreach ($data['questions'] as $key => $value) {
                      $quesEnqid = key($value);
                      $answer = array_values($value)[0];
                      if (in_array($key, $questions) && !empty($answer)) {
                           $qstArray = array(
                               'enqq_enq_id' => $data['enq_id'],
                               'enqq_question_id' => $key,
                               'enqq_answer' => $answer
                           );
                           $this->db->insert($this->tbl_enquiry_questions, $qstArray);
                      }
                 }
                 return true;
            }
            return false;
       }

       function getStockVehicles() {
            $this->db->where(array($this->tbl_valuation . '.val_status' => 1, $this->tbl_valuation . '.val_is_booked' => 0));

            return$this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*,' .
                                    $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_enquiry . '.*')
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                            ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
                            ->get($this->tbl_valuation)->result_array();
       }

       function getEnquiryHistory($enqId) {
            $select = array(
                $this->tbl_enquiry_history . '.*',
                $this->tbl_enquiry . '.*',
                $this->tbl_users . '.*',
                $this->tbl_statuses . '.*'
            );
            return $this->db->select($select)->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_enquiry_history . '.enh_enq_id')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry_history . '.enh_current_sales_executive')
                            ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_enquiry_history . '.enh_status')
                            ->order_by('enh_added_on', 'DESC')->get_where($this->tbl_enquiry_history, array($this->tbl_enquiry_history . '.enh_enq_id' => $enqId))->result_array();
       }

       function removeRow($id, $msg) {
            $this->db->where('qtr_id', $id)->update($this->tbl_quick_tc_report, array('qtr_replay' => $msg, 'qtr_reply_on' => date('Y-m-d H:i:s'), 'qtr_reply_by' => $this->uid));
       }

       function assignTo($assignToId, $enqId) {

            $assignTo = $this->db->select('usr_first_name, usr_last_name')->get_where($this->tbl_users, array('usr_id' => $assignToId))->row_array();
            $assignBy = $this->db->select('usr_first_name, usr_last_name')->get_where($this->tbl_users, array('usr_id' => $this->uid))->row_array();

            $assignTo = isset($assignTo['usr_first_name']) ? $assignTo['usr_first_name'] : '';
            $assignBy = isset($assignBy['usr_first_name']) ? $assignBy['usr_first_name'] : '';

            $historyId = $this->enquiry->addEnquiryHistory(
                    array(
                        'enh_enq_id' => $enqId,
                        'enh_current_sales_executive' => $assignToId,
                        'enh_status' => assign_to_other_staff,
                        'enh_remarks' => 'Enquiry assigned by ' . $assignBy . ' to ' . $assignTo,
                        'enh_added_by' => $this->uid,
                        'enh_added_on' => date('Y-m-d h:i:s')
                    )
            );

            $this->db->where('enq_id', $enqId)->update($this->tbl_enquiry, array('enq_se_id' => $assignToId,
                'enq_current_status_history' => $historyId, 'enq_current_status' => assign_to_other_staff, 'enq_added_by' => $this->uid));

            $vehicles = $this->db->get_where($this->tbl_vehicle, array('veh_enq_id' => $enqId))->result_array();

            if (!empty($vehicles)) {
                 foreach ($vehicles as $key => $value) {
                      $updateData['foll_cus_id'] = $enqId;
                      $updateData['foll_cus_vehicle_id'] = $value['veh_id'];
                      $updateData['foll_entry_date'] = date('Y-m-d H:i:s');
                      $updateData['foll_status'] = 1;
                      $updateData['foll_remarks'] = 'Enquiry assigned by ' . $assignBy . ' to ' . $assignTo;

                      $updateData['foll_added_by'] = $this->uid;
                      $updateData['foll_updated_by'] = $this->uid;

                      if ($this->db->insert($this->tbl_followup, $updateData)) {
                           generate_log(array(
                               'log_title' => 'Enquiry assigned to ' . $assignTo . ' by ' . $assignBy,
                               'log_desc' => serialize(array('assigneto' => $assignTo, 'enq_id' => $enqId)),
                               'log_controller' => 'enquiry-assigned-by-tele-caller',
                               'log_action' => 'U',
                               'log_ref_id' => 0,
                               'log_added_by' => get_logged_user('usr_id')
                           ));
                      }
                 }
            }
       }

       function getLastRegisterRelatedToEnquiry($enqId) {
            return $this->db->order_by('vreg_id', 'DESC')->limit(1)->get_where($this->tbl_register_master, array('vreg_inquiry' => $enqId))->row_array();
       }

       function todayfollowup() {
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
                $this->tbl_enquiry . '.enq_cus_whatsapp',
                $this->tbl_enquiry . '.enq_cus_when_buy',
                $this->tbl_enquiry . '.enq_mode_enq',
                $this->tbl_users . '.usr_first_name',
                $this->tbl_users . '.usr_last_name',
                'tbl_added_by.usr_id AS enq_added_by_id',
                'tbl_added_by.usr_username AS enq_added_by_name'
            );
            $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
            return $this->db->select($ArrSelect)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                            ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                            ->where($this->tbl_users . '.usr_active', 1)->order_by($this->tbl_enquiry . '.enq_next_foll_date', 'DESC')->get($this->tbl_enquiry)->result_array();
       }

       function updateComments($data) {
            $data['foll_cus_vehicle_id'] = 0;
            $data['foll_entry_date'] = date('Y-m-d H:i:s');
            $data['foll_customer_feedback'] = '';
            $data['foll_can_show_all'] = 1;
            $data['foll_contact'] = 0;
            $data['foll_action_plan'] = '';
            $data['foll_added_by'] = $this->uid;
            $data['foll_updated_by'] = $this->uid;
            $data['foll_is_dar_submited'] = 0;
            $data['foll_is_cmnt'] = 1;

            if (isset($data['folmsgshow'])) {
                 $data['folmsgshow'][] = $this->grp_id;
                 $data['folmsgshow'] = array_unique($data['folmsgshow']);
            } else {
                 $data['folmsgshow'][] = $this->grp_id;
            }
            if (!empty($data['folmsgshow'])) {
                 $data['foll_access_grp_id'] = serialize($data['folmsgshow']);
                 unset($data['folmsgshow']);
            }

            //Enquiry details
            $enqDetails = $this->db->select('enq_se_id, enq_cus_when_buy')->where('enq_id', $data['foll_cus_id'])->get($this->tbl_enquiry)->row_array();
            //Get enquiry vehicle
            $vehicle = $this->db->select('veh_id')->get_where($this->tbl_vehicle, array('veh_enq_id' => $data['foll_cus_id']))->row()->veh_id;

            $data['foll_cus_vehicle_id'] = $vehicle;
            $data['foll_status'] = isset($enqDetails['enq_cus_when_buy']) ? $enqDetails['enq_cus_when_buy'] : 0;

            $this->db->insert($this->tbl_followup, $data);
            $follCmdId = $this->db->insert_id();

            generate_log(array(
                'log_title' => 'Followup comment',
                'log_desc' => serialize($data),
                'log_controller' => 'followup-comment',
                'log_action' => 'C',
                'log_ref_id' => $follCmdId,
                'log_added_by' => get_logged_user('usr_id')
            ));
            $salesStaff = isset($enqDetails['enq_se_id']) ? $enqDetails['enq_se_id'] : 0;
            $this->db->insert($this->tbl_followup_view_log, array('fvl_enq_id' => $data['foll_cus_id'], 'fvl_foll_id' => $follCmdId, 'fvl_sales_staff' => $salesStaff));
            return true;
       }

       function getComments($follId) {

            return $this->db->select($this->tbl_followup . '.*, ' . $this->tbl_users . '.usr_username AS folloup_added_by, ' .
                                    $this->tbl_users . '.usr_id AS folloup_added_by_id,' . $this->tbl_users . '.usr_avatar, ' . $this->tbl_showroom . '.shr_location')
                            ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_followup . '.foll_cus_vehicle_id', 'LEFT')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_vehicle . '.veh_brand', 'LEFT')
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_vehicle . '.veh_model', 'LEFT')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_vehicle . '.veh_varient', 'LEFT')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_followup . '.foll_added_by', 'LEFT')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
                            ->order_by($this->tbl_followup . '.foll_id', 'DESC')->get_where($this->tbl_followup, array($this->tbl_followup . '.foll_parent' => $follId))->result_array();
       }

       function getInquiryByDate() {
            $mystaffs = array();
            if ($this->usr_grp == 'TL') {
                 $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                                 ->get($this->tbl_users)->row()->usr_id);
            }
            $showroom = get_logged_user('usr_showroom');

            $date = date("Y-m-d", strtotime("-1 day"));
            $this->db->where('(DATE(' . $this->tbl_enquiry . ".enq_entry_date) >= '" . $date . "' AND DATE(" . $this->tbl_enquiry . ".enq_entry_date) <= '" . $date . "')");

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
            $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
            return $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,', false)
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_enquiry . '.enq_showroom_id', 'LEFT')
                            ->where($this->tbl_users . '.usr_active', 1)->order_by($this->tbl_enquiry . '.enq_entry_date', 'DESC')
                            ->get($this->tbl_enquiry)->result_array();
       }

       function updateHotWarmCold($postData) {
            $enqDetails = $this->db->select('enq_se_id, enq_cus_when_buy')->where('enq_id', $postData['foll_new_sts_enq_id'])
                            ->get($this->tbl_enquiry)->row_array();
            if (!empty($enqDetails)) {
                 $salesStaff = isset($enqDetails['enq_se_id']) ? $enqDetails['enq_se_id'] : 0;

                 $data['foll_status'] = $postData['foll_new_status'];
                 $data['foll_cus_id'] = $postData['foll_new_sts_enq_id'];
                 $data['foll_cus_vehicle_id'] = 0;
                 $data['foll_entry_date'] = date('Y-m-d H:i:s');
                 $data['foll_customer_feedback'] = '';
                 $data['foll_can_show_all'] = 1;
                 $data['foll_contact'] = 0;
                 $data['foll_action_plan'] = '';
                 $data['foll_added_by'] = $this->uid;
                 $data['foll_updated_by'] = $this->uid;
                 $data['foll_is_dar_submited'] = 0;
                 $data['foll_is_cmnt'] = 1;

                 if (isset($postData['folmsgshow'])) {
                      $postData['folmsgshow'][] = $this->grp_id;
                      $postData['folmsgshow'] = array_unique($postData['folmsgshow']);
                 } else {
                      $postData['folmsgshow'][] = $this->grp_id;
                 }
                 if (!empty($postData['folmsgshow'])) {
                      $data['foll_access_grp_id'] = serialize($postData['folmsgshow']);
                 }
                 $folStatus = unserialize(FOLLOW_UP_STATUS);

                 $oldFolStatus = isset($folStatus[$enqDetails['enq_cus_when_buy']]) ? $folStatus[$enqDetails['enq_cus_when_buy']] : '';
                 $newFolStatus = isset($folStatus[$postData['foll_new_status']]) ? $folStatus[$postData['foll_new_status']] : '';
                 $sytemCmd = $this->session->userdata('usr_username') . ' changed followup status ' . $oldFolStatus . ' >> ' . $newFolStatus;
                 $data['foll_remarks'] = $postData['foll_new_status_remarks'] . ' ' . $sytemCmd;

                 $this->db->insert($this->tbl_followup, $data);
                 $follCmdId = $this->db->insert_id();

                 $this->db->where('enq_id', $postData['foll_new_sts_enq_id'])
                         ->update($this->tbl_enquiry, array('enq_cus_when_buy' => $postData['foll_new_status']));

                 $this->db->insert($this->tbl_followup_view_log, array('fvl_enq_id' => $data['foll_cus_id'],
                     'fvl_foll_id' => $follCmdId, 'fvl_sales_staff' => $salesStaff));
                 return true;
            }
            return false;
       }

       function getAllHotAndHotPlusInquires() {
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
            }
            $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', array(1, 2));
            $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);

            $ArrSelect = array(
                $this->tbl_enquiry . '.enq_cus_name',
                $this->tbl_enquiry . '.enq_id',
                $this->tbl_enquiry . '.enq_cus_mobile',
                $this->tbl_enquiry . '.enq_next_foll_date',
                $this->tbl_enquiry . '.enq_cus_whatsapp',
                $this->tbl_enquiry . '.enq_cus_when_buy',
                $this->tbl_enquiry . '.enq_mode_enq',
                $this->tbl_enquiry . '.enq_entry_date',
                $this->tbl_users . '.usr_first_name',
                $this->tbl_users . '.usr_last_name',
                'tbl_added_by.usr_id AS enq_added_by_id',
                'tbl_added_by.usr_username AS enq_added_by_name'
            );

            return $this->db->select($ArrSelect)->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                            ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                            ->where($this->tbl_users . '.usr_active', 1)->order_by($this->tbl_enquiry . '.enq_next_foll_date', 'DESC')->get($this->tbl_enquiry)->result_array();
       }

       function changevehicle($data) {
            if (isset($data['newvehicle']['enq_id'])) {
                 $enq = $this->db->select('enq_showroom_id,enq_cus_status,enq_next_foll_date')
                                 ->get_where($this->tbl_enquiry, array('enq_id' => $data['newvehicle']['enq_id']))->row_array();
                 $shrmId = isset($enq['enq_showroom_id']) ? $enq['enq_showroom_id'] : 0;
                 $custSts = isset($enq['enq_cus_status']) ? $enq['enq_cus_status'] : 1;

                 $brand = isset($data['newvehicle']['brand']) ? $data['newvehicle']['brand'] : 0;
                 $model = isset($data['newvehicle']['model']) ? $data['newvehicle']['model'] : 0;
                 $varient = isset($data['newvehicle']['varient']) ? $data['newvehicle']['varient'] : 0;
                 $remarks = isset($data['newvehicle']['remarks']) ? $data['newvehicle']['remarks'] : '';

                 if (!empty($enq)) {
                      $vdata = array(
                          'veh_showroom_id' => $shrmId,
                          'veh_enq_id' => $data['newvehicle']['enq_id'],
                          'veh_brand' => $brand,
                          'veh_model' => $model,
                          'veh_varient' => $varient,
                          'veh_status' => $custSts,
                          'veh_added_by' => $this->uid
                      );
                      $this->db->insert($this->tbl_vehicle, $vdata);
                      $vehId = $this->db->insert_id();

                      $fdata['foll_cus_vehicle_id'] = $vehId;
                      $fdata['foll_status'] = 0;
                      $fdata['foll_cus_id'] = $data['newvehicle']['enq_id'];
                      $fdata['foll_entry_date'] = date('Y-m-d H:i:s');
                      $fdata['foll_customer_feedback'] = '';
                      $fdata['foll_can_show_all'] = 1;
                      $fdata['foll_contact'] = 0;
                      $fdata['foll_action_plan'] = '';
                      $fdata['foll_added_by'] = $this->uid;
                      $fdata['foll_updated_by'] = $this->uid;
                      $fdata['foll_is_dar_submited'] = 0;
                      $fdata['foll_is_cmnt'] = 1;
                      $fdata['foll_remarks'] = $remarks;
                      $fdata['foll_next_foll_date'] = $enq['enq_next_foll_date'];

                      $this->db->insert($this->tbl_followup, $fdata);
                      $folId = $this->db->insert_id();

                      generate_log(array(
                          'log_title' => 'Vehicle changed from followup',
                          'log_desc' => serialize($data),
                          'log_controller' => 'vehicle-changed-by-followup',
                          'log_action' => 'C',
                          'log_ref_id' => $folId,
                          'log_added_by' => get_logged_user('usr_id')
                      ));
                 }
            }
       }

       //Jafaer
       function getPreferences($id = '') {

            if ($id) {
                 return $this->db->select($this->tbl_enq_prefrences . '.*,' .
                                         ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile')
                                 ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_enq_prefrences . '.prf_addded_by', 'LEFT')
                                 ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_enq_prefrences . '.prf_enq_id', 'left')
                                 ->where('prf_enq_id', $id)->get($this->tbl_enq_prefrences)->result_array();
            }

            $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                            ->get($this->tbl_users)->row()->usr_id);

            if (check_permission('followup', 'enquirypreferencemyself')) {
                 $this->db->where($this->tbl_enq_prefrences . '.prf_addded_by', $this->uid);
            } else if (check_permission('followup', 'enquirypreferencemyteam')) {
                 array_push($mystaffs, $this->uid);
                 $this->db->where_in($this->tbl_enq_prefrences . '.prf_addded_by', $mystaffs);
            } else if (check_permission('followup', 'enquirypreferencemyshowroom')) {
                 $this->db->where_in($this->tbl_enq_prefrences . '.prf_showoom', $this->shrm);
            }

            return $this->db->select($this->tbl_enq_prefrences . '.*,' .
                                    ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' . $this->tbl_enquiry . '.enq_se_id ')
                            ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_enq_prefrences . '.prf_addded_by', 'LEFT')
                            ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_enq_prefrences . '.prf_enq_id', 'left')
                            ->get($this->tbl_enq_prefrences)->result_array();
       }

       public function getStates($id = '') {
            if ($id) {
                 return $this->db->where('sts_id', $id)->get($this->tbl_states)->row()->sts_name;
            } else {
                 return $this->db->select($this->tbl_states . '.*,')
                                 ->get($this->tbl_states)->result_array();
            }
       }

       public function getCountries($id = '') {
            if ($id) {
                 return $this->db->where('id', $id)->get($this->tbl_countries)->row()->sts_name;
            } else {
                 return $this->db->select($this->tbl_countries . '.*,')
                                 ->get($this->tbl_countries)->result_array();
            }
       }

       public function getColors($id = '') {
            if ($id) {
                 return $this->db->select($this->tbl_vehicle_colors . '.vc_color,')
                                 ->where('vc_id ', $id)->get($this->tbl_vehicle_colors)->row()->vc_color;
            } else {
                 return $this->db->select($this->tbl_vehicle_colors . '.*,')
                                 ->order_by($this->tbl_vehicle_colors . '.vc_sort_order', 'asc')
                                 ->get($this->tbl_vehicle_colors)->result_array();
            }
       }

       public function getSalesStaff($id = '') {
            return $this->db->select($this->tbl_users . '.usr_first_name,')
                            ->where('usr_id ', $id)->get($this->tbl_users)->row()->usr_first_name;
       }

       public function addProcReq($data) {

            $data['brand'] = !empty($data['brand']) ? $data['brand'] : 0;
            $data['model'] = !empty($data['model']) ? $data['model'] : 0;
            $data['variant'] = !empty($data['variant']) ? $data['variant'] : 0;

            $vehicleDetails = $this->common_model->getVehicleName($data['brand'], $data['model'], $data['variant']);

            $purPeriod = unserialize(PURCHASE_PERIOD);
            $purPeriod = isset($purPeriod[$data['purchase_prd']]) ? $purPeriod[$data['purchase_prd']] : '';

            if (isset($data) && !empty($data)) {
                 $PrfData = array(
                     'proc_brand' => $data['brand'],
                     'proc_model' => $data['model'],
                     'proc_variant' => $data['variant'],
                     'proc_purchase_period' => $data['purchase_prd'],
                     'proc_sales_staff' => $data['enq_se_id'],
                     'proc_enq_id' => $data['enq_id'],
                     'proc_addded_by' => $this->uid,
                     'proc_status' => '1',
                     'proc_added_on' => date("Y-m-d H:i:s"),
                     'proc_shoroom' => $this->shrm
                 );
                 $this->db->insert('cpnl_procurement_rqsts', $PrfData);
                 //Log
                 $PrfData['proc_id'] = $this->db->insert_id();
                 generate_log(array(
                     'log_title' => 'New procurement req',
                     'log_desc' => serialize($PrfData),
                     'log_controller' => 'new-procurement-req',
                     'log_action' => 'C',
                     'log_ref_id' => $PrfData['proc_id'],
                     'log_added_by' => $this->uid
                 ));
                 //Followup comment
                 $fdata['foll_cus_vehicle_id'] = 0;
                 $fdata['foll_status'] = 0;
                 $fdata['foll_cus_id'] = $data['enq_id'];
                 $fdata['foll_entry_date'] = date('Y-m-d H:i:s');
                 $fdata['foll_customer_feedback'] = '';
                 $fdata['foll_can_show_all'] = 1;
                 $fdata['foll_contact'] = 0;
                 $fdata['foll_action_plan'] = '';
                 $fdata['foll_added_by'] = $this->uid;
                 $fdata['foll_updated_by'] = $this->uid;
                 $fdata['foll_is_dar_submited'] = 0;
                 $fdata['foll_is_cmnt'] = 1;
                 $fdata['foll_remarks'] = 'Procurement request for ' . $vehicleDetails . '<br> Purchase period : ' . $purPeriod . '<br>' . $data['descriptin'];

                 $this->db->insert($this->tbl_followup, $fdata);
                 return true;
            }
       }

       public function addPreference($data) {
            if (isset($data) && !empty($data)) {
                 if (isset($data['colors']) && !empty($data['colors'])) {
                      foreach ($data['colors'] as $key => $value) {
                           $PrfData = array(
                               'prf_key' => '1',
                               'prf_value' => $value,
                               'prf_description' => $data['colors_description'][$key],
                               'prf_enq_id' => $data['enq_id'],
                               'prf_addded_by' => $this->uid,
                               'prf_added_on' => date("Y-m-d H:i:s"),
                               'prf_showoom' => $this->shrm
                           );
                           $this->db->insert('cpnl_enq_prefrences', $PrfData);
                           $PrfData['proc_id'] = $this->db->insert_id();
                           generate_log(array(
                               'log_title' => 'New preference',
                               'log_desc' => serialize($PrfData),
                               'log_controller' => 'new-preference',
                               'log_action' => 'C',
                               'log_ref_id' => $PrfData['proc_id'],
                               'log_added_by' => $this->uid
                           ));
                      }
                 }
                 if (isset($data['registration']) && !empty($data['registration'])) {
                      foreach ($data['registration'] as $key => $value) {
                           $PrfData = array(
                               'prf_key' => '2',
                               'prf_value' => $value,
                               'prf_description' => $data['Reg_description'][$key],
                               'prf_enq_id' => $data['enq_id'],
                               'prf_addded_by' => $this->uid,
                               'prf_added_on' => date("Y-m-d H:i:s"),
                               'prf_showoom' => $this->shrm
                           );
                           $this->db->insert('cpnl_enq_prefrences', $PrfData);
                           $PrfData['proc_id'] = $this->db->insert_id();
                           generate_log(array(
                               'log_title' => 'New preference',
                               'log_desc' => serialize($PrfData),
                               'log_controller' => 'new-preference',
                               'log_action' => 'C',
                               'log_ref_id' => $PrfData['proc_id'],
                               'log_added_by' => $this->uid
                           ));
                      }
                 }
                 if (isset($data['other_state']) && !empty($data['other_state'])) {
                      foreach ($data['other_state'] as $key => $value) {
                           $PrfData = array(
                               'prf_key' => '3',
                               'prf_value' => $value,
                               'prf_description' => $data['other_description'][$key],
                               'prf_enq_id' => $data['enq_id'],
                               'prf_addded_by' => $this->uid,
                               'prf_added_on' => date("Y-m-d H:i:s"),
                               'prf_showoom' => $this->shrm
                           );
                           $this->db->insert('cpnl_enq_prefrences', $PrfData);
                           $PrfData['proc_id'] = $this->db->insert_id();
                           generate_log(array(
                               'log_title' => 'New preference',
                               'log_desc' => serialize($PrfData),
                               'log_controller' => 'new-preference',
                               'log_action' => 'C',
                               'log_ref_id' => $PrfData['proc_id'],
                               'log_added_by' => $this->uid
                           ));
                      }
                 }
                 if (isset($data['vehicle_type']) && !empty($data['vehicle_type'])) {
                      foreach ($data['vehicle_type'] as $key => $value) {
                           $PrfData = array(
                               'prf_key' => '4',
                               'prf_value' => $value,
                               'prf_description' => $data['vehicle_description'][$key],
                               'prf_enq_id' => $data['enq_id'],
                               'prf_addded_by' => $this->uid,
                               'prf_added_on' => date("Y-m-d H:i:s"),
                               'prf_showoom' => $this->shrm
                           );
                           $this->db->insert('cpnl_enq_prefrences', $PrfData);
                           $PrfData['proc_id'] = $this->db->insert_id();
                           generate_log(array(
                               'log_title' => 'New preference',
                               'log_desc' => serialize($PrfData),
                               'log_controller' => 'new-preference',
                               'log_action' => 'C',
                               'log_ref_id' => $PrfData['proc_id'],
                               'log_added_by' => $this->uid
                           ));
                      }
                 }
                 if (isset($data['rto']) && !empty($data['rto'])) {
                      foreach ($data['rto'] as $key => $value) {
                           $PrfData = array(
                               'prf_key' => '5',
                               'prf_value' => $value,
                               'prf_description' => $data['rto_description'][$key],
                               'prf_enq_id' => $data['enq_id'],
                               'prf_addded_by' => $this->uid,
                               'prf_added_on' => date("Y-m-d H:i:s"),
                               'prf_showoom' => $this->shrm
                           );
                           $this->db->insert('cpnl_enq_prefrences', $PrfData);
                           $PrfData['proc_id'] = $this->db->insert_id();
                           generate_log(array(
                               'log_title' => 'New preference',
                               'log_desc' => serialize($PrfData),
                               'log_controller' => 'new-preference',
                               'log_action' => 'C',
                               'log_ref_id' => $PrfData['proc_id'],
                               'log_added_by' => $this->uid
                           ));
                      }
                 }
                 return true;
            }
       }

       function getPrequrementRqst($id = '') {
            if ($id) {
                 $data = $this->db->select($this->tbl_procurement_rqsts . '.*,' .
                                         ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' . $this->tbl_enquiry . '.enq_se_id ')
                                 ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_procurement_rqsts . '.proc_addded_by', 'LEFT')
                                 ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_procurement_rqsts . '.proc_enq_id', 'left')
                                 ->where('proc_id ', $id)->get($this->tbl_procurement_rqsts)->row_array();

                 return $data;
            }

            if (check_permission('followup', 'precurementrqstlist_myshowroom')) {
                 $this->db->where_in($this->tbl_procurement_rqsts . '.proc_shoroom', $this->shrm);
            } else if (check_permission('followup', 'precurementrqstlist_myself')) {
                 $this->db->where_in($this->tbl_procurement_rqsts . '.proc_addded_by', $this->uid);
            }

            return $this->db->select($this->tbl_procurement_rqsts . '.*,' .
                                    ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_cus_mobile,' . $this->tbl_enquiry . '.enq_se_id ')
                            ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_procurement_rqsts . '.proc_addded_by', 'LEFT')
                            ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_procurement_rqsts . '.proc_enq_id', 'left')
                            ->get($this->tbl_procurement_rqsts)->result_array();
       }

       function UpdatePrequrementRqst($data) {
            $this->db->where('proc_dt_viewed_id', $this->uid);
            $this->db->where('proc_dt_master_id', $data['proc_id']);
            $this->db->from($this->tbl_procurement_rqst_details);
            $count = $this->db->count_all_results();
            if ($count == 0) {
                 $PrcData = array(
                     'proc_dt_master_id' => $data['proc_id'],
                     'proc_dt_viewed_id' => $this->uid,
                     'proc_added_on' => date("Y-m-d H:i:s")
                 );
                 $this->db->insert($this->tbl_procurement_rqst_details, $PrcData);
            }
       }

       public function addProcStatus($param) {
            $PrcData = array(
                'proc_sts_master_id' => $param['proc_id'],
                'proc_sts_status' => $param['proc_status'],
                'proc_sts_description' => $param['proc_remarks'],
                'proc_sts_added_by' => $this->uid,
                'proc_sts_added_on' => date("Y-m-d H:i:s")
            );
            $this->db->insert($this->tbl_procurement_rqst_status, $PrcData);
            $insId = $this->db->insert_id();
            generate_log(array(
                'log_title' => 'New procurement req',
                'log_desc' => serialize($param),
                'log_controller' => 'procurement-req-sts-update',
                'log_action' => 'U',
                'log_ref_id' => $insId,
                'log_added_by' => $this->uid
            ));
            //Followup comment
            $fdata['foll_cus_vehicle_id'] = 0;
            $fdata['foll_status'] = 0;
            $fdata['foll_cus_id'] = $param['proc_enq_id'];
            $fdata['foll_entry_date'] = date('Y-m-d H:i:s');
            $fdata['foll_customer_feedback'] = '';
            $fdata['foll_can_show_all'] = 1;
            $fdata['foll_contact'] = 0;
            $fdata['foll_action_plan'] = '';
            $fdata['foll_added_by'] = $this->uid;
            $fdata['foll_updated_by'] = $this->uid;
            $fdata['foll_is_dar_submited'] = 0;
            $fdata['foll_is_cmnt'] = 1;
            $fdata['foll_remarks'] = $param['proc_remarks'];
            $this->db->insert($this->tbl_followup, $fdata);

            return true;
       }

       public function getProcStatus($id) {
            return $this->db->select($this->tbl_procurement_rqst_status . '.*,' .
                                    ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_statuses . '.sts_title')
                            ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_procurement_rqst_status . '.proc_sts_added_by', 'LEFT')
                            ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_procurement_rqst_status . '.proc_sts_status', 'left')
                            ->where('proc_sts_master_id', $id)->order_by($this->tbl_procurement_rqst_status . '.proc_sts_added_on', 'DESC')
                            ->get($this->tbl_procurement_rqst_status)->result_array();
       }

       function changeEnqStatus($data) {
            if (!empty($data)) {
                 $data['enh_added_by'] = $this->uid;
                 if ($this->db->insert($this->tbl_enquiry_history, $data)) {
                      $enqHistoryId = $this->db->insert_id();

                      /* Folowup comment */
                      $curStatus = $this->db->get_where($this->tbl_statuses, array('sts_value' => $data['enh_status']))->row_array();
                      $selectArray = array(
                          $this->tbl_enquiry . '.enq_se_id',
                          $this->tbl_enquiry . '.enq_cus_name',
                          $this->tbl_enquiry . '.enq_cus_mobile',
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

                      if ($data['enh_status'] == loss_of_sale_or_buy || $data['enh_status'] == enq_lost ||
                              $data['enh_status'] == enq_req_drop || $data['enh_status'] == enq_droped) {
                           // To cold
                           $enUpdate = array(
                               'enq_current_status' => $data['enh_status'],
                               'enq_cus_when_buy' => 4,
                               'enq_current_status_history' => $enqHistoryId
                           );
                      }
                      $this->db->where('enq_id', $data['enh_enq_id']);
                      $this->db->update($this->tbl_enquiry, $enUpdate);
                      generate_log(array(
                          'log_title' => 'Change enquiry status',
                          'log_desc' => 'Status has been changed',
                          'log_controller' => strtolower(__CLASS__),
                          'log_action' => 'C',
                          'log_ref_id' => $enqHistoryId,
                          'log_added_by' => get_logged_user('usr_id')
                      ));
                      return true;
                 }
            }
            return false;
       }

       function getStaffs() {
            $salesStaff = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
                                    $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active')
                            ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                            ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                            ->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
                            //->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1, $this->tbl_users . '.usr_showroom' => $id))
                            ->where(array($this->tbl_users . '.usr_active' => 1))
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                            ->get($this->tbl_users)->result_array();
            return $salesStaff;
       }

       function addTestDrive($data) {
            if (!empty($data)) {
                 $data['tdrv_added_by'] = $this->uid;
                 $data['tdrv_created_at'] = date('Y-m-d H:i:s');
                 if ($data['tdrv_test_drive_date'] == '') {
                      $follCmd['tdrv_test_drive_date'] = date('Y-m-d H:i:s');
                 } else {
                      $tdrv_date = date_create($data['tdrv_test_drive_date']);
                      $data['tdrv_test_drive_date'] = date_format($tdrv_date, "Y-m-d H:i:s");
                 }
                 if ($this->db->insert($this->tbl_test_drives, $data)) {
                      $id = $this->db->insert_id();
                      generate_log(array(
                          'log_title' => 'Test drive',
                          'log_desc' => 'Test drive from follow up form',
                          'log_controller' => strtolower(__CLASS__),
                          'log_action' => 'C',
                          'log_ref_id' => $id,
                          'log_added_by' => get_logged_user('usr_id')
                      ));
                      return true;
                 }
            }
            return false;
       }

       function addHomeVisit($data) {
            if (!empty($data)) {
                 $distState = $this->getDistrictId($data['hmv_district']);
                 $data['hmv_district'] = $distState['std_id'];
                 $data['hmv_state'] = $distState['std_state'];
                 $data['hmv_veh_no'] = '';
                 if ($data['hmv_travel_mod'] == 8 && $data['hmv_fleet_veh'] == 3) {
                      $data['hmv_reg1'] = strtoupper($data['hmv_reg1']);
                      $data['hmv_reg3'] = strtoupper($data['hmv_reg3']);
                      $data['hmv_veh_no'] = $data['hmv_reg1'] . '-' . $data['hmv_reg2'] . '-' . $data['hmv_reg3'] . '-' . $data['hmv_reg4'];
                 }
                 if ($data['hmv_fleet_veh'] == 1) {
                      $data['hmv_veh_stock_id'] = $data['hmv_veh_comp'];
                 }
                 if ($data['hmv_fleet_veh'] == 2) {
                      $data['hmv_veh_stock_id'] = $data['hmv_veh_stock'];
                 }
                 unset($data['hmv_reg1'], $data['hmv_reg2'], $data['hmv_reg3'], $data['hmv_reg4'], $data['hmv_veh_comp'], $data['hmv_veh_stock']);
                 $data['hmv_added_by'] = $this->uid;
                 $data['hmv_created_at'] = date('Y-m-d H:i:s');
                 if ($data['hmv_date'] == '') {
                      $data['hmv_date'] = date('Y-m-d H:i:s');
                 } else {
                      $hmv_date = date_create($data['hmv_date']);
                      $data['hmv_date'] = date_format($hmv_date, "Y-m-d H:i:s");
                 }
                 // debug($data);
                 if ($this->db->insert($this->tbl_home_visits, $data)) {
                      $id = $this->db->insert_id();
                      generate_log(array(
                          'log_title' => 'Home visit Req',
                          'log_desc' => 'Home visit Req from follow up form',
                          'log_controller' => strtolower(__CLASS__),
                          'log_action' => 'C',
                          'log_ref_id' => $id,
                          'log_added_by' => get_logged_user('usr_id')
                      ));
                      return true;
                 }
            }
            return false;
       }

//       function getHomeVisit($hmv_id = '') {
//            $qry = $this->db->select($this->tbl_home_visits . '.*,' .
//                            ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,'
//                            . $this->tbl_variant . '.var_variant_name,' . $this->tbl_users . '.usr_first_name AS travel_with,approvedBy.usr_first_name AS approved_by,')
//                    ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_home_visits . '.hmv_added_by', 'LEFT')
//                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id  = ' . $this->tbl_home_visits . '.hmv_veh_stock_id', 'left')
//                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
//                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
//                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
//                    ->join($this->tbl_users, $this->tbl_users . '.usr_id  = ' . $this->tbl_home_visits . '.hmv_travel_with', 'left')
//                    ->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_home_visits . '.hmv_approved_by', 'LEFT')
//                    ->where('hmv_added_by', $this->uid);
//            if ($hmv_id) {
//                 return $qry->where('hmv_id', $hmv_id)
//                                 ->get($this->tbl_home_visits)->row_array();
//            }
//            return $qry->order_by($this->tbl_home_visits . '.hmv_date', 'DESC')
//                            ->get($this->tbl_home_visits)->result_array();
//       }

       function getHomeVisit($hmv_id = '') {

            $qry = $this->db->select($this->tbl_home_visits . '.*,' .
                            ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,'
                            . $this->tbl_variant . '.var_variant_name,' . $this->tbl_users .
                            '.usr_first_name AS travel_with,' . $this->tbl_enquiry .
                            '.enq_cus_name,' . $this->tbl_enquiry .
                            '.enq_cus_address,' . $this->tbl_enquiry .
                            '.enq_cus_mobile,' . $this->tbl_enquiry .
                            '.enq_cus_city,' . $this->tbl_enquiry .
                            '.enq_cus_dist,' . $this->tbl_enquiry .
                            '.enq_cus_age,')//enq_cus_age
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
            if ($hmv_id) {
                 return $qry->where('hmv_id', $hmv_id)
                                 ->get($this->tbl_home_visits)->row_array();
            }
            return $qry->where('hmv_added_by', $this->uid)->order_by($this->tbl_home_visits . '.hmv_date', 'DESC')
                            ->get($this->tbl_home_visits)->result_array();
       }

       function checkHomeVisitApprovals($hmva_master_id = '') {
            if ($hmva_master_id) {
                 $qry = $this->db->select($this->tbl_home_visits_approvals . '.*,' .
                                         'approvedBy.usr_first_name AS approved_by,')
                                 ->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_home_visits_approvals . '.hmva_approved_by', 'LEFT')->where('hmva_master_id ', $hmva_master_id);
                 return $qry->order_by($this->tbl_home_visits_approvals . '.hmva_id', 'ASC')
                                 ->get($this->tbl_home_visits_approvals)->result_array();
            }
       }

       function updateHomeVisit($data) {
            $hmv_enq_id = $data['hmv_enq_id'];
            $hmv_id = $data['hmv_id'];
            $hmv_in_date = date_create($data['hmv_in_date']);
            $data['hmv_in_date'] = date_format($hmv_in_date, "Y-m-d H:i:s");
            $this->db->where('hmv_id', $data['hmv_id']);
            unset($data['hmv_id']);
            unset($data['hmv_enq_id']);
            $this->db->update($this->tbl_home_visits, $data);
            $this->db->where('enq_id', $hmv_enq_id);
            $enqData['enq_cus_home_visit'] = 1;
            $this->db->update($this->tbl_enquiry, $enqData);
            generate_log(array(
                'log_title' => 'Update Home visit Req ',
                'log_desc' => 'Update Home visit Req from follow up form',
                'log_controller' => strtolower(__CLASS__),
                'log_action' => 'U',
                'log_ref_id' => $hmv_id,
                'log_added_by' => get_logged_user('usr_id')
            ));
            return true;
       }

//       function getHomeVisitApprovelReq($hmv_id = '') {
//            $qry = $this->db->select($this->tbl_home_visits . '.*,' .
//                            ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,'
//                            . $this->tbl_variant . '.var_variant_name,' . $this->tbl_users . '.usr_first_name AS travel_with,')
//                    ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_home_visits . '.hmv_added_by', 'LEFT')
//                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id  = ' . $this->tbl_home_visits . '.hmv_veh_stock_id', 'left')
//                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
//                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
//                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
//                    ->join($this->tbl_users, $this->tbl_users . '.usr_id  = ' . $this->tbl_home_visits . '.hmv_travel_with', 'left')
//                    //->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_home_visits . '.hmv_approved_by', 'LEFT')
//                    ->join($this->tbl_home_visits_approvals, $this->tbl_home_visits_approvals . '.hmva_master_id = ' .
//                                       $this->tbl_home_visits . '.hmv_id AND ' .
//                                       $this->tbl_home_visits_approvals . '.hmva_approved_by = ' . $this->uid, 'LEFT')//"your_id !=",$your_id
//                               ->where($this->tbl_home_visits_approvals . '.hmva_approved_by IS NULL')->where($this->tbl_home_visits.'.hmv_added_by !=', $this->uid);
//                                          if ($hmv_id) {
//                 return $qry->where('hmv_id', $hmv_id)
//                                 ->get($this->tbl_home_visits)->row_array();
//            }
//            return $qry->order_by($this->tbl_home_visits . '.hmv_date', 'DESC')
//                            ->get($this->tbl_home_visits)->result_array();
//       }
       function getHomeVisitApprovelReq($hmv_id = '') {//$this->db->where('(a = 1 or a = 2)');
            $qry = $this->db->select($this->tbl_home_visits . '.*,' .
                                    ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,'
                                    . $this->tbl_variant . '.var_variant_name,' . $this->tbl_users . '.usr_first_name AS travel_with,' . $this->tbl_home_visits_approvals . '.hmva_approved_by,' . $this->tbl_home_visits_approvals . '.hmva_approval_status,' . $this->tbl_enquiry .
                                    '.enq_cus_name,' . $this->tbl_enquiry .
                                    '.enq_cus_address,' . $this->tbl_enquiry .
                                    '.enq_cus_mobile,' . $this->tbl_enquiry .
                                    '.enq_cus_city,' . $this->tbl_enquiry .
                                    '.enq_cus_dist,' . $this->tbl_enquiry .
                                    '.enq_cus_age,')//
                            ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_home_visits . '.hmv_added_by', 'LEFT')
                            ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id  = ' . $this->tbl_home_visits . '.hmv_veh_stock_id', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id  = ' . $this->tbl_home_visits . '.hmv_travel_with', 'left')
                            ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id  = ' . $this->tbl_home_visits . '.hmv_enq_id', 'left')
                            //->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_home_visits . '.hmv_approved_by', 'LEFT')
                            ->join($this->tbl_home_visits_approvals, $this->tbl_home_visits_approvals . '.hmva_master_id = ' .
                                    $this->tbl_home_visits . '.hmv_id AND ' .
                                    $this->tbl_home_visits_approvals . '.hmva_approved_by = ' . $this->uid, 'LEFT')//"your_id !=",$your_id
                            ->where("(" . $this->tbl_home_visits_approvals . '.hmva_approved_by IS NULL' . " or cpnl_home_visit_approvals.hmva_approval_status=2)")->where($this->tbl_home_visits . '.hmv_added_by !=', $this->uid);
            if ($hmv_id) {
                 return $qry->where('hmv_id', $hmv_id)
                                 ->get($this->tbl_home_visits)->row_array();
            }
            return $qry->order_by($this->tbl_home_visits . '.hmv_date', 'DESC')
                            ->get($this->tbl_home_visits)->result_array();
       }

       function updateHomeVisitApproval($data) {
            $data['hmva_approved_date'] = date('Y-m-d H:i:s');
            $data['hmva_approved_by'] = 0;
            $data['hmva_approval_status'] = 2; //rejected
            if ($data['is_approved']) {
                 $data['hmva_approval_status'] = 1; //approved
            }
            $data['hmva_approved_by'] = $this->uid;
            unset($data['is_approved']);
            $this->db->insert($this->tbl_home_visits_approvals, $data);
            $id = $this->db->insert_id();
            generate_log(array(
                'log_title' => 'Update Home visit Req Approval ',
                'log_desc' => 'Update Home visit Req Approval',
                'log_controller' => strtolower(__CLASS__),
                'log_action' => 'C',
                'log_ref_id' => $id,
                'log_added_by' => get_logged_user('usr_id')
            ));
            return true;
       }

       function getHomeVisitApprovedReq($hmv_id = '') {
            $qry = $this->db->select($this->tbl_home_visits . '.*,' .
                                    ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,'
                                    . $this->tbl_variant . '.var_variant_name,' . $this->tbl_users . '.usr_first_name AS travel_with,' . $this->tbl_home_visits_approvals . '.hmva_approved_by,')
                            ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_home_visits . '.hmv_added_by', 'LEFT')
                            ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id  = ' . $this->tbl_home_visits . '.hmv_veh_stock_id', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id  = ' . $this->tbl_home_visits . '.hmv_travel_with', 'left')
                            //->join($this->tbl_users . 'enqapprovedby', 'enqApprovedby.usr_id = ' . $this->tbl_home_visits_approvals . '.hmva_approved_by', 'LEFT')
                            //->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_home_visits . '.hmv_approved_by', 'LEFT')
                            ->join($this->tbl_home_visits_approvals, $this->tbl_home_visits_approvals . '.hmva_master_id = ' .
                                    $this->tbl_home_visits . '.hmv_id AND ' .
                                    $this->tbl_home_visits_approvals . '.hmva_approved_by = ' . $this->uid, 'LEFT')//"your_id !=",$your_id
                            ->where($this->tbl_home_visits_approvals . '.hmva_approved_by IS NOT NULL')->where($this->tbl_home_visits . '.hmv_added_by !=', $this->uid);
            if ($hmv_id) {
                 return $qry->where('hmv_id', $hmv_id)
                                 ->get($this->tbl_home_visits)->row_array();
            }
            return $qry->order_by($this->tbl_home_visits . '.hmv_date', 'DESC')
                            ->get($this->tbl_home_visits)->result_array();
       }

       function addChangedVehicle($data) {

            if (!empty($data)) {
                 //  debug($data);
                 // debug($data['vehicle']['sale']['veh_brand']);
                 $veh['veh_previous_model'] = $data['old_veh_model'];
                 $showroom = get_logged_user('usr_showroom');
                 if (!empty($showroom)) {
                      $veh['veh_showroom_id'] = $showroom;
                 }
//                  unset($data['old_veh_id']);
//                     unset($data['old_veh_brand']);
//                        unset($data['old_veh_model']);
//                           unset($data['old_veh_varient']);
                 //
                 if ($data['veh_type'] == 1) {
                      $veh['veh_enq_id'] = $data['veh_enq_id'];
                      $veh['veh_status'] = 1;
                      $veh['veh_brand'] = isset($data['vehicle']['sale']['veh_brand']) ? $data['vehicle']['sale']['veh_brand'] : 0;
                      $veh['veh_model'] = isset($data['vehicle']['sale']['veh_model']) ? $data['vehicle']['sale']['veh_model'] : 0;
                      $veh['veh_varient'] = isset($data['vehicle']['sale']['veh_varient']) ? $data['vehicle']['sale']['veh_varient'] : 0;
                      $veh['veh_fuel'] = $data['vehicle']['sale']['veh_fuel'];
                      $veh['veh_color'] = $data['vehicle']['sale']['veh_color'];
                      $veh['veh_exptd_date_purchase'] = $data['vehicle']['sale']['veh_exptd_date_purchase'];
                      $veh['veh_price_id'] = empty($data['vehicle']['sale']['veh_price_id']) ? 0 : $data['vehicle']['sale']['veh_price_id'];
                      $veh['veh_prefer_no'] = $data['vehicle']['sale']['veh_prefer_number'];
                      $veh['veh_year'] = empty($data['vehicle']['sale']['veh_year']) ? 0 : $data['vehicle']['sale']['veh_year'];
                      $veh['veh_km_id'] = empty($data['vehicle']['sale']['veh_km_id']) ? 0 : $data['vehicle']['sale']['veh_km_id'];
                      $veh['veh_remarks'] = empty($data['vehicle']['sale']['veh_remarks']) ? 0 : $data['vehicle']['sale']['veh_remarks'];
                      $veh['veh_manf_year_from'] = isset($data['vehicle']['sale']['veh_manf_year_from']) ? $data['vehicle']['sale']['veh_manf_year_from'] : '';
                      $veh['veh_manf_year_to'] = isset($data['vehicle']['sale']['veh_manf_year_to']) ? $data['vehicle']['sale']['veh_manf_year_to'] : '';
                      $veh['veh_type'] = 1; //required
                      $veh['veh_added_by'] = $this->uid;
                      $followup_comment = 'Changed' . ' ' . $data['old_veh_details'] . ' to' . ' ' . @$data['brd_name_new'] . ' ' . @$data['model_name_new'] . ' ' . @$data['variant_name_new'];
                      // debug($data['vehicle']['sale']['veh_brand']);
                 } if ($data['veh_type'] == 3) {
                      $veh['veh_enq_id'] = $data['veh_enq_id'];
                      $veh['veh_status'] = 1;
                      $veh['veh_stock_id'] = @$data['veh_stock_id'];
                      $veh['veh_exch_cus_expect'] = @$data['vehicle']['pitched']['veh_customer_offer'];
                      $veh['veh_remarks'] = @$data['vehicle']['pitched']['veh_remarks'];
                      $veh['veh_tl_remarks'] = @$data['vehicle']['pitched']['veh_tl_remarks'];
                      $veh['veh_sm_remarks'] = @$data['vehicle']['pitched']['veh_sm_remarks'];
                      $veh['veh_gm_remarks'] = @$data['vehicle']['pitched']['veh_gm_remarks'];
                      $veh['veh_type'] = 3;
                      $veh['veh_added_by'] = $this->uid;
                      $followup_comment = 'Changed' . ' ' . $data['old_veh_reg'] . ' ' . $data['old_veh_details'] . ' to' . ' ' . @$data['pitched_veh_new'];
                      // debug($data['vehicle']['sale']['veh_brand']);
                 }
                 $this->db->insert($this->tbl_vehicle, $veh);
                 $id = $this->db->insert_id();
                 //
                 if ($id) {

                      $this->db->where('veh_id', $data['old_veh_id']);
                      $this->db->update($this->tbl_vehicle, ['veh_changed_to' => $id, 'veh_changed_date' => date('Y-m-d H:i:s')]);
                      $comment = 'Changed' . ' ' . $data['old_veh_details'] . ' to' . ' ' . @$data['vehicle']['sale']['veh_brand'];
                      $foll_data = ['foll_remarks' => $followup_comment, 'foll_cus_id' => $data['veh_enq_id'], 'foll_parent' => 0];
                      $this->updateComments($foll_data);
                      generate_log(array(
                          'log_title' => 'Change vehicle',
                          'log_desc' => 'Change vehicle from follow up form',
                          'log_controller' => strtolower(__CLASS__),
                          'log_action' => 'C',
                          'log_ref_id' => $id,
                          'log_added_by' => get_logged_user('usr_id')
                      ));
                      return true;
                 }
            }
            return false;
       }

       function getTestDriveApprovelReq($tdrv_id = '') {//$this->db->where('(a = 1 or a = 2)');
            $qry = $this->db->select($this->tbl_test_drives . '.*,' .
                                    ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,'
                                    . $this->tbl_variant . '.var_variant_name,' . $this->tbl_test_drive_approvals . '.tdrva_approved_by,' . $this->tbl_test_drive_approvals . '.tdrva_approval_status,' . $this->tbl_enquiry .
                                    '.enq_cus_name,' . $this->tbl_enquiry .
                                    '.enq_cus_address,' . $this->tbl_enquiry .
                                    '.enq_cus_mobile,' . $this->tbl_enquiry .
                                    '.enq_cus_city,' . $this->tbl_enquiry .
                                    '.enq_cus_dist,' . $this->tbl_enquiry .
                                    '.enq_cus_age,')//
                            ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_test_drives . '.tdrv_added_by', 'LEFT')
                            ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id  = ' . $this->tbl_test_drives . '.tdrv_veh_stock_id', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                            ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id  = ' . $this->tbl_test_drives . '.tdrv_enq_id', 'left')
//     ->join($this->tbl_users, $this->tbl_users . '.usr_id  = ' . $this->tbl_test_drives . '.hmv_travel_with', 'left')
                            //->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_home_visits . '.hmv_approved_by', 'LEFT')
                            ->join($this->tbl_test_drive_approvals, $this->tbl_test_drive_approvals . '.tdrva_master_id = ' .
                                    $this->tbl_test_drives . '.tdrv_id AND ' .
                                    $this->tbl_test_drive_approvals . '.tdrva_approved_by = ' . $this->uid, 'LEFT')//"your_id !=",$your_id
                            ->where("(" . $this->tbl_test_drive_approvals . '.tdrva_approved_by IS NULL' . " or cpnl_test_drive_approvals.tdrva_approval_status=2)")->where($this->tbl_test_drives . '.tdrv_added_by !=', $this->uid);
            if ($tdrv_id) {
                 return $qry->where('tdrv_id', $tdrv_id)
                                 ->get($this->tbl_test_drives)->row_array();
            }
            return $qry->order_by($this->tbl_test_drives . '.tdrv_test_drive_date', 'DESC')
                            ->get($this->tbl_test_drives)->result_array();
       }

       function checkTestDriveApprovals($tdrva_master_id = '') {
            if ($tdrva_master_id) {
                 $qry = $this->db->select($this->tbl_test_drive_approvals . '.*,' .
                                         'approvedBy.usr_first_name AS approved_by,')
                                 ->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_test_drive_approvals . '.tdrva_approved_by', 'LEFT')->where('tdrva_master_id ', $tdrva_master_id);
                 return $qry->order_by($this->tbl_test_drive_approvals . '.tdrva_id', 'ASC')
                                 ->get($this->tbl_test_drive_approvals)->result_array();
            }
       }

       function updateTestDriveApproval($data) {
            $data['tdrva_approved_date'] = date('Y-m-d H:i:s');
            $data['tdrva_approved_by'] = 0;
            if ($data['is_approved']) {
                 $data['tdrva_approved_by'] = $this->uid;
            }
            unset($data['is_approved']);
            $this->db->insert($this->tbl_test_drive_approvals, $data);
            $id = $this->db->insert_id();
            generate_log(array(
                'log_title' => 'Update Test drive Req Approval ',
                'log_desc' => 'Updateed Test drive Req Approval',
                'log_controller' => strtolower(__CLASS__),
                'log_action' => 'C',
                'log_ref_id' => $id,
                'log_added_by' => get_logged_user('usr_id')
            ));
            return true;
       }

       function getTestDrive($hmv_id = '') {

            $qry = $this->db->select($this->tbl_test_drives . '.*,' .
                            ', enqaddedby.usr_first_name AS enq_added_by_name, enqaddedby.usr_id AS enq_added_by_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' . $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,'
                            . $this->tbl_variant . '.var_variant_name,' . $this->tbl_enquiry .
                            '.enq_cus_name,' . $this->tbl_enquiry .
                            '.enq_cus_address,' . $this->tbl_enquiry .
                            '.enq_cus_mobile,' . $this->tbl_enquiry .
                            '.enq_cus_city,' . $this->tbl_enquiry .
                            '.enq_cus_dist,' . $this->tbl_enquiry .
                            '.enq_cus_age,')//enq_cus_age
                    ->join($this->tbl_users . ' enqaddedby', 'enqaddedby.usr_id = ' . $this->tbl_test_drives . '.tdrv_added_by', 'LEFT')
                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id  = ' . $this->tbl_test_drives . '.tdrv_veh_stock_id', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id  = ' . $this->tbl_test_drives . '.tdrv_enq_id', 'left');
            // ->join($this->tbl_home_visits_approvals, $this->tbl_home_visits_approvals . '.hmva_master_id  = ' . $this->tbl_home_visits . '.hmv_id ', 'left')
            //->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_home_visits_approvals . '.hmva_approved_by', 'LEFT')
            //->where('hmv_added_by', $this->uid); 
            if ($hmv_id) {
                 return $qry->where('tdrv_id', $hmv_id)
                                 ->get($this->tbl_test_drives)->row_array();
            }
            return $qry->where('tdrv_added_by', $this->uid)->order_by($this->tbl_test_drives . '.tdrv_test_drive_date', 'DESC')
                            ->get($this->tbl_test_drives)->result_array();
       }

       function getTravelModes() {
            return $this->db->get($this->tbl_travel_modes)->result_array();
       }

       public function getDistrictId($term) {
            if ($term) {
                 $query = $this->db->like('std_district_name', $term)->get($this->tbl_district_statewise);
                 return $query->row_array();
            }
       }

       function enquiryfollowup_ajax($postDatas) {
            $draw = $postDatas['draw'];
            $row = $postDatas['start'];
            $rowperpage = $postDatas['length']; // Rows display per page
            $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
            $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'foll_id'; // Column name 
            $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
            $searchValue = $postDatas['search']['value']; // Search value

            if ($this->usr_grp == 'SE' || $this->usr_grp == 'EV' || $this->usr_grp == 'TL') {
                 $this->db->where($this->tbl_enquiry . '.enq_se_id = ' . $this->uid);
            } else if ($this->usr_grp == 'TC') {
                 $this->db->where($this->tbl_followup . '.foll_added_by = ' . $this->uid);
            }
            $selectArray = array(
                $this->tbl_followup . '.foll_id', $this->tbl_followup . '.foll_next_foll_date',
                $this->tbl_followup . '.foll_next_foll_date', $this->tbl_followup . '.foll_customer_feedback',
                $this->tbl_vehicle . '.veh_id', $this->tbl_vehicle . '.veh_brand', $this->tbl_vehicle . '.veh_model',
                $this->tbl_vehicle . '.veh_varient', $this->tbl_vehicle . '.veh_status', $this->tbl_enquiry . '.enq_cus_name',
                $this->tbl_enquiry . '.enq_id', $this->tbl_brand . '.brd_title', $this->tbl_model . '.mod_title', $this->tbl_enquiry . '.enq_current_status',
                $this->tbl_variant . '.var_variant_name'
            );
            return $this->db->select($selectArray)
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
       }

       public function getRto($id = '') {
            if ($id) {
                 return $this->db->where('rto_id', $id)->select('rto_reg_num,rto_place')
                                 ->get($this->tbl_rto_office)->row_array();
            }
            return $this->db->select('rto_id,rto_reg_num,rto_place')
                            ->get($this->tbl_rto_office)->result_array();
       }

  }
  