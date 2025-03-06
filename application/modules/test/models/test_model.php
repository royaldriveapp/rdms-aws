<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class test_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();
            $this->tbl_welcomekit = TABLE_PREFIX . 'welcome_kit';

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
          $this->tbl_district = TABLE_PREFIX . 'district_statewise';
          $this->tbl_divisions = TABLE_PREFIX . 'divisions';
          $this->tbl_questions = TABLE_PREFIX . 'questions';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_occupation = TABLE_PREFIX . 'occupation';
          $this->tbl_departments = TABLE_PREFIX . 'departments';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
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
          $this->tbl_offer_prices = TABLE_PREFIX . 'offer_prices';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
          $this->view_enquiry_vehicle_master = TABLE_PREFIX . 'view_enquiry_vehicle_master';
          $this->tbl_quick_tc_report_master = TABLE_PREFIX . 'quick_tc_report_master';
          $this->tbl_occupation_category = TABLE_PREFIX . 'occupation_categories';
          $this->tbl_purpose_of_purchase = TABLE_PREFIX . 'purpose_of_purchase';
          $this->tbl_home_visits = TABLE_PREFIX . 'home_visits';
          $this->tbl_home_visit_approvals = TABLE_PREFIX . 'home_visit_approvals';
          $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
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

       public function tmp() {
            $this->db->db_debug = true;
            try {
               if($this->db->insert('test', array(
                    'remarks' => 'test',
                    //'date_two' => date('Y-m-d')
               ))) {
               } else {
                    throw new Exception($this->db->_error_message());
               }
            } catch (\Exception $e) {
               echo 'ERROR:' . $e->getMessage();
            }
       }

       public function read($id = '') {
            if (!empty($id)) {
                 return $this->db->get_where($this->tbl_welcomekit, array('wkt_id' => $id))->row_array();
            }
            return $this->db->order_by('wkt_id', 'DESC')->get($this->tbl_welcomekit)->result_array();
       }

       public function create($datas) {
            $datas['wkt_added_by'] = $this->uid;
            $datas['wkt_added_on'] = date('Y-m-d h:i:s');
            if ($this->db->insert($this->tbl_welcomekit, $datas)) {
                 $id = $this->db->insert_id();
                 generate_log(array(
                     'log_title' => 'New welcome kit added',
                     'log_desc' => 'New welcome kit added',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'C',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

       public function update($datas) {
            $id = $datas['wkt_id'];
            unset($datas['wkt_id']);
            $this->db->where('wkt_id', $id);
            if ($this->db->update($this->tbl_welcomekit, $datas)) {
                 generate_log(array(
                     'log_title' => 'welcome kit updated',
                     'log_desc' => 'welcome kit updated',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'U',
                     'log_ref_id' => $id,
                     'log_added_by' => get_logged_user('usr_id')
                 ));
                 return true;
            } else {
                 return false;
            }
       }

       public function delete($id) {
            $this->db->where('wkt_id', $id);
            if ($this->db->delete($this->tbl_welcomekit)) {
                 generate_log(array(
                     'log_title' => 'welcome kit delete',
                     'log_desc' => 'welcome kit deleted',
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
       public function getPhoneNo($prm) {
     if($prm==='enq'){
          return $this->db->select('enq_cus_name as name,enq_cus_mobile as phone')->order_by('enq_id', 'DESC')->get('cpnl_enquiry')->result_array();
          //return $this->db->select('enq_id,enq_cus_name,enq_cus_mobile')->order_by('enq_id', 'DESC')->get('cpnl_enquiry')->result_array();
     }elseif($prm==='reg'){
          //return $this->db->select('vreg_id,vreg_cust_name,vreg_cust_phone')->order_by('vreg_id', 'DESC')->get('cpnl_register_master')->result_array();
          return $this->db->select('vreg_cust_name as name,vreg_cust_phone as phone')->order_by('vreg_id', 'DESC')->get('cpnl_register_master')->result_array();
     }
     elseif($prm==='booked'){
        
          $res= $this->db->select('vbk_per_ph_no')->get('cpnl_vehicle_booking_master')->result_array();
     }
         
     }


  }
  