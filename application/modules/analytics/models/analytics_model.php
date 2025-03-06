<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class analytics_model extends CI_Model {

     public function __construct() {
          parent::__construct();
          $this->load->database();

          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
     }

     function enquirydroppedpulse($filter = array()) {
          $users = $this->db->select('usr_id, usr_first_name')->get_where($this->tbl_users, array('usr_active' => 1, 'usr_can_auto_assign' => 1))->result_array();
          $dateFrom = (isset($filter['enq_date_from']) && !empty($filter['enq_date_from'])) ? date('Y-m-d', strtotime($filter['enq_date_from'])) : '';
          $dateTo = (isset($filter['enq_date_to']) && !empty($filter['enq_date_to'])) ? date('Y-m-d', strtotime($filter['enq_date_to'])) : '';

          foreach ($users as $key => $value) {
               $return[$value['usr_id']]['salesStaff'] = $value['usr_first_name'];

               if (!empty($dateFrom) && !empty($dateTo)) {
                    $this->db->where("(DATE($this->tbl_enquiry_history.enh_added_on) BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "')");
               } else if (!empty($dateFrom)) {
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $dateFrom);
               } else if (!empty($dateTo)) {
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $dateTo);
               }

               if (!isset($filter['isDrop']) && !isset($filter['isRequestToDrop'])) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               } else if (isset($filter['isDrop']) && isset($filter['isRequestToDrop'])) {
                    $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status = ' . $filter['isRequestToDrop'] . ' OR ' .
                            $this->tbl_enquiry . '.enq_current_status = ' . $filter['isDrop'] . ')');
               } else if (isset($filter['isRequestToDrop'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_current_status', $filter['isRequestToDrop']);
               } else if (isset($filter['isDrop'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_current_status', $filter['isDrop']);
               }

               $return[$value['usr_id']]['hotp'] = $this->db->select($this->tbl_enquiry . '.enq_current_status, ' .
                               $this->tbl_enquiry . '.enq_cus_when_buy,' . $this->tbl_users . '.usr_first_name, ' .
                               $this->tbl_enquiry . '.enq_added_on', true)
                       ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                       ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
                       ->where('enq_cus_when_buy', 1)->where('enq_se_id', $value['usr_id'])
                       ->count_all_results($this->tbl_enquiry);
               
               //---------------------------------------------------------------------------------------------------------

               if (!empty($dateFrom) && !empty($dateTo)) {
                    $this->db->where("(DATE($this->tbl_enquiry_history.enh_added_on) BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "')");
               } else if (!empty($dateFrom)) {
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $dateFrom);
               } else if (!empty($dateTo)) {
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $dateTo);
               }

               if (!isset($filter['isDrop']) && !isset($filter['isRequestToDrop'])) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               } else if (isset($filter['isDrop']) && isset($filter['isRequestToDrop'])) {
                    $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status = ' . $filter['isRequestToDrop'] . ' OR ' .
                            $this->tbl_enquiry . '.enq_current_status = ' . $filter['isDrop'] . ')');
               } else if (isset($filter['isRequestToDrop'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_current_status', $filter['isRequestToDrop']);
               } else if (isset($filter['isDrop'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_current_status', $filter['isDrop']);
               }
               $return[$value['usr_id']]['hot'] = $this->db->select($this->tbl_enquiry . '.enq_current_status, ' .
                               $this->tbl_enquiry . '.enq_cus_when_buy, ' . $this->tbl_users . '.usr_first_name, ' .
                               $this->tbl_enquiry . '.enq_added_on', true)
                       ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                       ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
                       ->where('enq_cus_when_buy', 2)->where('enq_se_id', $value['usr_id'])
                       ->count_all_results($this->tbl_enquiry);
               //---------------------------------------------------------------------------------------------------------

               if (!empty($dateFrom) && !empty($dateTo)) {
                    $this->db->where("(DATE($this->tbl_enquiry_history.enh_added_on) BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "')");
               } else if (!empty($dateFrom)) {
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $dateFrom);
               } else if (!empty($dateTo)) {
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $dateTo);
               }

               if (!isset($filter['isDrop']) && !isset($filter['isRequestToDrop'])) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               } else if (isset($filter['isDrop']) && isset($filter['isRequestToDrop'])) {
                    $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status = ' . $filter['isRequestToDrop'] . ' OR ' .
                            $this->tbl_enquiry . '.enq_current_status = ' . $filter['isDrop'] . ')');
               } else if (isset($filter['isRequestToDrop'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_current_status', $filter['isRequestToDrop']);
               } else if (isset($filter['isDrop'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_current_status', $filter['isDrop']);
               }
               $return[$value['usr_id']]['warm'] = $this->db->select($this->tbl_enquiry . '.enq_current_status, ' .
                               $this->tbl_enquiry . '.enq_cus_when_buy, ' . $this->tbl_users . '.usr_first_name, ' .
                               $this->tbl_enquiry . '.enq_added_on', true)
                       ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                       ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
                       ->where('enq_cus_when_buy', 3)->where('enq_se_id', $value['usr_id'])
                       ->count_all_results($this->tbl_enquiry);
               //---------------------------------------------------------------------------------------------------------

               if (!empty($dateFrom) && !empty($dateTo)) {
                    $this->db->where("(DATE($this->tbl_enquiry_history.enh_added_on) BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "')");
               } else if (!empty($dateFrom)) {
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) >=', $dateFrom);
               } else if (!empty($dateTo)) {
                    $this->db->where('DATE(' . $this->tbl_enquiry_history . '.enh_added_on) <=', $dateTo);
               }

               if (!isset($filter['isDrop']) && !isset($filter['isRequestToDrop'])) {
                    $this->db->where_in($this->tbl_enquiry . '.enq_current_status', $this->myEnqStatuses);
               } else if (isset($filter['isDrop']) && isset($filter['isRequestToDrop'])) {
                    $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status = ' . $filter['isRequestToDrop'] . ' OR ' .
                            $this->tbl_enquiry . '.enq_current_status = ' . $filter['isDrop'] . ')');
               } else if (isset($filter['isRequestToDrop'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_current_status', $filter['isRequestToDrop']);
               } else if (isset($filter['isDrop'])) {
                    $this->db->where($this->tbl_enquiry . '.enq_current_status', $filter['isDrop']);
               }
               $return[$value['usr_id']]['cold'] = $this->db->select($this->tbl_enquiry . '.enq_current_status, ' .
                               $this->tbl_enquiry . '.enq_cus_when_buy, ' . $this->tbl_users . '.usr_first_name, ' .
                               $this->tbl_enquiry . '.enq_added_on', true)
                       ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                       ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
                       ->where('enq_cus_when_buy', 4)->where('enq_se_id', $value['usr_id'])
                       ->count_all_results($this->tbl_enquiry);
          }
          return $return;
     }

}
