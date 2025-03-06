<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class tools_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
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
            $this->tbl_district = TABLE_PREFIX . 'district';
            $this->tbl_questions = TABLE_PREFIX . 'questions';
            $this->tbl_valuation = TABLE_PREFIX . 'valuation';
            $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
            $this->tbl_occupation = TABLE_PREFIX . 'occupation';
            $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
            $this->tbl_vehicle_status = TABLE_PREFIX . 'vehicle_status';
            $this->tbl_register_master = TABLE_PREFIX . 'register_master';
            $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
            $this->tbl_valuation_status = TABLE_PREFIX . 'valuation_status';
            $this->tbl_enquiry_questions = TABLE_PREFIX . 'enquiry_questions';
            $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
            $this->view_enquiry_vehicle_master = TABLE_PREFIX . 'view_enquiry_vehicle_master';
       }

       function enquires($id = '', $status = array(), $limit = 0, $page = 0, $exParams = array()) {
            $showroom = get_logged_user('usr_showroom');
            $whereSearch = '';
            if (isset($exParams['search']) && !empty($exParams['search'])) {
                 $whereSearch = '(' . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_users . ".usr_first_name LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_mobile LIKE '%" . $exParams['search'] . "%' OR " .
                         $this->tbl_enquiry . ".enq_cus_whatsapp LIKE '%" . $exParams['search'] . "%' )";
            }
            if (is_roo_user()) {
                 $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')->where(array('vst_current_status' => '99'))
                                 ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
                 $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                 $this->db->where("enq_cus_whatsapp != ''");
                 $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;

                 //Count
                 if (!empty($whereSearch)) {
                      $this->db->where($whereSearch);
                 }
                 $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                                 ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                 ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                 //Data
                 $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                 if (!empty($whereSearch)) {
                      $this->db->where($whereSearch);
                 }
                 $this->db->where("enq_cus_whatsapp != ''");
                 if ($limit) {
                      $this->db->limit($limit, $page);
                 }
                 $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' .
                                         $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                                 ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                 ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_id', 'left')
                                 ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')
                                 ->where($where)->get($this->tbl_enquiry)->result_array();
                 return $return;
            } else if ($this->usr_grp == 'MG') { // Manager
                 $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')
                                 ->where(array('vst_current_status' => '99', 'enq_showroom_id' => $showroom))
                                 ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
                 $this->db->where("enq_cus_whatsapp != ''");
                 $where[$this->tbl_enquiry . '.enq_showroom_id'] = $showroom;
                 $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;

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
                 $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                 if (!empty($whereSearch)) {
                      $this->db->where($whereSearch);
                 }
                 $this->db->where("enq_cus_whatsapp != ''");
                 if ($limit) {
                      $this->db->limit($limit, $page);
                 }
                 $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' .
                                         $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                 ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                 ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_id', 'left')
                                 ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                 return $return;
            } else if ($this->usr_grp == 'DE') { // Date entry operator
                 $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')
                                 ->where(array('vst_current_status' => '99', 'enq_added_by' => $this->uid))
                                 ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
                 $this->db->where("enq_cus_whatsapp != ''");
                 $where[$this->tbl_enquiry . '.enq_added_by'] = $this->uid;
                 $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;

                 //Count
                 if (!empty($whereSearch)) {
                      $this->db->where($whereSearch);
                 }
                 $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                 $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                 ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                 ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);
                 //Data
                 $this->db->where("enq_cus_whatsapp != ''");
                 if (!empty($whereSearch)) {
                      $this->db->where($whereSearch);
                 }
                 if ($limit) {
                      $this->db->limit($limit, $page);
                 }
                 $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                 $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' .
                                         $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                 ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                 ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_id', 'left')
                         ->db->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                 return $return;
            } else if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') { // Seles executives
                 $exclude = $this->db->select('GROUP_CONCAT(enq_id) AS enq_id')
                                 ->where(array('vst_current_status' => '99', 'enq_se_id' => $this->uid))
                                 ->get($this->view_enquiry_vehicle_master)->row()->enq_id;
                 $this->db->where("enq_cus_whatsapp != ''");
                 $where[$this->tbl_enquiry . '.enq_se_id'] = $this->uid;
                 $where[$this->tbl_enquiry . '.enq_current_status !='] = 9;

                 //Count
                 if (!empty($whereSearch)) {
                      $this->db->where($whereSearch);
                 }
                 $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                 $return['count'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                 ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                 ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->where($where)->count_all_results($this->tbl_enquiry);

                 //Data
                 if (!empty($whereSearch)) {
                      $this->db->where($whereSearch);
                 }
                 $this->db->where("enq_cus_whatsapp != ''");
                 if ($limit) {
                      $this->db->limit($limit, $page);
                 }
                 $this->db->where_not_in($this->tbl_enquiry . '.enq_id', explode(',', $exclude));
                 $return['data'] = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*, tbl_added_by.usr_username AS enq_added_by_name,' .
                                         $this->tbl_statuses . '.sts_title,' . $this->tbl_statuses . '.sts_des')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id')
                                 ->join($this->tbl_users . ' tbl_added_by', 'tbl_added_by.usr_id = ' . $this->tbl_enquiry . '.enq_added_by', 'left')
                                 ->join($this->tbl_statuses, $this->tbl_enquiry . '.enq_current_status = ' . $this->tbl_statuses . '.sts_id', 'left')
                                 ->order_by($this->tbl_enquiry . '.enq_id', 'DESC')->get_where($this->tbl_enquiry, $where)->result_array();
                 return $return;
            }
       }

       function customerWhatsappNumber($custId) {
            if (!empty($custId)) {
                 return $this->db->get_where($this->tbl_enquiry, array('enq_id' => $custId))->row()->enq_cus_whatsapp;
            }
            return false;
       }

       function getAllCustomerContactsBySE() {

            return $this->db->select($this->tbl_enquiry . '.enq_sms_sent, ' . $this->tbl_enquiry . '.enq_id, ' . $this->tbl_enquiry . '.enq_cus_name, ' . $this->tbl_enquiry . '.enq_cus_mobile,' .
                                    $this->tbl_users . '.usr_username,' . $this->tbl_users . '.usr_phone')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                            ->where($this->tbl_enquiry . '.enq_sms_sent', 0)->get($this->tbl_enquiry)->result_array();
       }

  }
  