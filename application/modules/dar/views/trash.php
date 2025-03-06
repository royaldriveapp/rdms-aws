<?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class trash extends App_Controller {

       public function __construct() {
            parent::__construct();

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
            $this->tbl_dar_reg_followup = TABLE_PREFIX . 'dar_reg_followup';
            $this->tbl_dar_veh_register = TABLE_PREFIX . 'dar_veh_register';
            $this->tbl_register_followup = TABLE_PREFIX . 'register_followup';
            $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
            $this->view_enquiry_vehicle_master = TABLE_PREFIX . 'view_enquiry_vehicle_master';
       }

       function index() {
            $f = $this->db->query("SELECT enq_id FROM `cpnl_enquiry` WHERE (DATE(enq_entry_date) >= DATE('2021-01-01') AND DATE(enq_entry_date) <= DATE('2021-02-03')) AND enq_cus_status = 2")->result_array();
            $done = array();
            $pend = array();
            foreach ($f as $key => $value) {
                 //echo $value['enq_id'];
                 $new = $this->db->get_where('cpnl_valuation', array('val_enquiry_id' => $value['enq_id']))->row_array();
                 //$old = $this->db->get_where('cpnl_valuation_old', array('val_enquiry_id' => $value['enq_id']))->row_array();

                 debug($new, 0);
                 //debug($old, 0);
                 //echo '<br>--------------------<br>';
            }
//            echo $this->db->last_query();
//            debug($f);
       }

       function calltime() {
            $dataFrom = '2021-01-01';
            $dataTo = '2021-02-03';

            $data = array();
            echo '<br>Total calls</br>';
            while (strtotime($dataFrom) <= strtotime($dataTo)) {

                 $d = $this->db->query("SELECT ccb_authorized_person_id, COUNT(*) AS cnt FROM `cpnl_callcenterbridging` WHERE (ccb_callDate >= '" .
                                 $dataFrom . " 9:00:00' AND ccb_callDate <= '" . $dataFrom . " 18:00:00') AND ccb_callStatus_id = 18 AND ccb_punch_time <= 15"
                                 . " GROUP BY ccb_authorized_person_id")->result_array();
                 //echo $this->db->last_query() . '<br>';
                 foreach ($d as $key => $value) {
                      $data[$value['ccb_authorized_person_id']] = $data[$value['ccb_authorized_person_id']] + $value['cnt'];
                 }

                 $dataFrom = date("Y-m-d", strtotime("+1 day", strtotime($dataFrom)));
            }
            debug($data, 0);
       }

       function daradj() {
            //$q = "SELECT * FROM `cpnl_register_followup` WHERE `regf_added_on` LIKE '%2021-01-29%' AND `regf_added_by` = 561";
            //$d = $this->db->query($q)->result_array();

            $today = date('2021-01-29');
            $d = $this->db->select($this->tbl_register_followup . '.*,' . $this->tbl_register_master . '.*,' . $this->tbl_contact_mode . '.*,' .
                                    $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_model . '.*')
                            ->join($this->tbl_register_followup, $this->tbl_register_followup . '.regf_reg_id = ' . $this->tbl_register_master . '.vreg_id', 'LEFT')
                            ->join($this->tbl_contact_mode, $this->tbl_contact_mode . '.cmd_mod_id = ' . $this->tbl_register_master . '.vreg_contact_mode', 'LEFT')
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                            ->where(array('regf_added_by' => 561))->like($this->tbl_register_followup . '.regf_added_on', $today, 'both')
                            ->get($this->tbl_register_master)->result_array();

            //debug($d);
            foreach ($d as $key => $value) {
                 $this->db->insert('cpnl_dar_reg_followup', array(
                     'darrf_dar_master' => 5856,
                     'darrf_vehicle_full_name' => $value['brd_title'] . ', ' . $value['mod_title'] . ',' . $value['var_variant_name'],
                     'darrf_fol_id' => $value['regf_id'],
                     'darrf_reg_id' => $value['vreg_id'],
                     'darrf_customer' => $value['vreg_cust_name'],
                     'darrf_mobile' => $value['vreg_cust_phone'],
                     'darrf_next_foll_date' => $value['regf_next_folowup'],
                     'darrf_foll_comment' => $value['regf_desc'],
                     'darrf_added_on' => date('Y-m-d H:i:s')
                 ));
            }

            debug($d);
       }

  }
  