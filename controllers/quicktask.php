<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
  class quicktask extends App_Controller {
       public function __construct() {
            parent::__construct();
            $this->load->model('enquiry/enquiry_model', 'enquiry');
       }

       function index() {
           $this->render_page(strtolower(__CLASS__) . '/registerReassign');
       }


       function registerReassign() {
          $assignTo = 709;
          $frName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' => $assignTo))->row()->usr_username;

          $qry = "SELECT cpnl_register_master.*, assign.usr_first_name AS assign_usr_first_name, assign.usr_last_name AS assign_usr_last_name, addedby.usr_first_name 
            AS addedby_usr_first_name, addedby.usr_last_name AS addedby_usr_last_name, exstse.usr_username 
            AS exstse_usr_username, cpnl_events.evnt_title, rana_brand.brd_id, rana_brand.brd_title, rana_model.mod_id, 
            rana_model.mod_title, rana_variant.var_id, rana_variant.var_variant_name, cpnl_enquiry.enq_current_status, cpnl_callcenterbridging.ccb_recording_URL, 
            cpnl_callcenterbridging.ccb_callStatus_id, cpnl_departments.dep_name, cpnl_district_statewise.* FROM (`cpnl_register_master`) 
            LEFT JOIN `cpnl_users` assign ON `assign`.`usr_id` = `cpnl_register_master`.`vreg_assigned_to` 
            LEFT JOIN `cpnl_users` addedby ON `addedby`.`usr_id` = `cpnl_register_master`.`vreg_added_by` 
            LEFT JOIN `cpnl_events` ON `cpnl_events`.`evnt_id` = `cpnl_register_master`.`vreg_event` 
            LEFT JOIN `rana_brand` ON `rana_brand`.`brd_id` = `cpnl_register_master`.`vreg_brand` 
            LEFT JOIN `rana_model` ON `rana_model`.`mod_id` = `cpnl_register_master`.`vreg_model` 
            LEFT JOIN `cpnl_enquiry` ON `cpnl_enquiry`.`enq_id` = `cpnl_register_master`.`vreg_inquiry` 
            LEFT JOIN `cpnl_users` exstse ON `cpnl_enquiry`.`enq_se_id` = `exstse`.`usr_id` 
            LEFT JOIN `cpnl_callcenterbridging` ON `cpnl_callcenterbridging`.`ccb_id` = `cpnl_register_master`.`vreg_voxbay_ref` 
            LEFT JOIN `rana_variant` ON `rana_variant`.`var_id` = `cpnl_register_master`.`vreg_varient` 
            LEFT JOIN `cpnl_departments` ON `cpnl_departments`.`dep_id` = `cpnl_register_master`.`vreg_department` 
            LEFT JOIN `cpnl_district_statewise` ON `cpnl_district_statewise`.`std_id` = `cpnl_register_master`.`vreg_district` 
            WHERE `vreg_assigned_to` = '336' AND `vreg_is_punched` = 0 AND (cpnl_enquiry.enq_current_status NOT IN (4,6,2) OR cpnl_enquiry.enq_current_status IS NULL) 
            AND `cpnl_register_master`.`vreg_status` IN (0, 1) AND `vreg_added_on` <= DATE('2021-12-31')  AND flg = 0 LIMIT 76";
          $rehmanEnquires =  $this->db->query($qry)->result_array();

          if(!empty($rehmanEnquires) && $assignTo > 0) {
            foreach ((array) $rehmanEnquires as $inqKey => $value) {
                $this->db->insert('cpnl_register_history', array(
                        'regh_phone_num' => $value['vreg_cust_phone'],
                        'regh_register_master' => $value['vreg_id'],
                        'regh_assigned_by' => $this->uid,
                        'regh_assigned_to' => $assignTo,
                        'regh_added_date' => date('Y-m-d H:i:s'),
                        'regh_added_by' => $this->uid,
                        'regh_remarks' => "Reassigned some of Rahman's register to " . $frName . " for calling",
                        'regh_system_cmd' => "Reassigned some of Rahman's register to " . $frName . " for calling"
                ));
                $regHistory = $this->db->insert_id();
                $this->db->where('vreg_id', $value['vreg_id'])->update('cpnl_register_master', 
                array('vreg_assigned_to' => $assignTo, 'vreg_history_id' => $regHistory, 'flg' => 1));
                
                generate_log(array(
                        'log_title' => "Reassigned some of Rahman's register to " . $frName . " for calling",
                        'log_desc' => serialize($value),
                        'log_controller' => 'quick-assign-register-master',
                        'log_action' => 'C',
                        'log_ref_id' => $value['vreg_id'],
                        'log_added_by' => $this->uid
                ));
             }
          }
          $this->session->set_flashdata('app_success', 'Register successfully reassigned to ' . $frName);
          redirect('quicktask');
      }
}