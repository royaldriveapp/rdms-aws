<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class webenquires_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();

            $this->tbl_users = TABLE_PREFIX . 'users';
            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
            $this->tbl_model = TABLE_PREFIX_RANA . 'model';
            $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
            $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
            $this->tbl_statuses = TABLE_PREFIX . 'statuses';
            $this->tbl_products = TABLE_PREFIX_RANA . 'products';
            $this->tbl_departments = TABLE_PREFIX . 'departments';
            $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
            $this->tbl_register_master = TABLE_PREFIX . 'register_master';
            $this->tbl_register_history = TABLE_PREFIX . 'register_history';
            $this->tbl_connect_with_seller = TABLE_PREFIX_RANA . 'connect_with_seller';
            $this->tbl_rana_users = TABLE_PREFIX_RANA . 'users';
            $this->tbl_prod_features = TABLE_PREFIX_RANA . 'prod_features';
            $this->tbl_prod_images = TABLE_PREFIX_RANA . 'prod_images';
            $this->tbl_prod_specifications = TABLE_PREFIX_RANA . 'prod_specifications';
       }

       function getAllWebSiteInquires($id = 0) {

            $this->db->select($this->tbl_connect_with_seller . '.*, ' . $this->tbl_products . '.*,' .
                            $this->tbl_model . '.mod_id,' . $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.*,' . $this->tbl_variant . '.*')
                    ->join($this->tbl_products, $this->tbl_products . '.prd_id = ' . $this->tbl_connect_with_seller . '.cws_prod_id', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'LEFT')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'LEFT')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'LEFT')
                    ->order_by($this->tbl_connect_with_seller . '.cws_added_date', 'DESC');

            if (!empty($id)) {
                 $this->db->where($this->tbl_connect_with_seller . '.cws_id', $id);
                 return $this->db->get($this->tbl_connect_with_seller)->row_array();
            } else {
                 $this->db->where($this->tbl_connect_with_seller . '.cws_punched_by', 0);
                 return $this->db->get($this->tbl_connect_with_seller)->result_array();
            }
       }

       function readCustomeTaleData($data) {
            $table = isset($data['t']) ? trim($data['t']) : '';
            $pk = isset($data['pk']) ? trim($data['pk']) : '';
            $pkid = isset($data['i']) ? trim($data['i']) : '';
            $fields = isset($data['f']) ? explode(',', $data['f']) : '*';

            if (!empty($table) && !empty($pk) && !empty($pkid) && !empty($fields)) {
                 if ($fields != '*') {
                      return $this->db->select($fields)->get_where($table, array($pk => $pkid))->row_array();
                 } else {
                      return $this->db->select($fields)->get_where($table, array($pk => $pkid))->result_array();
                 }
            }
       }

       public function create($regMaster) {
          
            date_default_timezone_set("Asia/Calcutta");
            $regMaster['vreg_first_owner'] = $this->uid;
            $regMaster['vreg_first_added_on'] = date('Y-m-d h:i:s');
            $allCalls = array();
            $prdId = 0;
            if (isset($regMaster['hash']) && !empty($regMaster['hash'])) {
                 $hash = unserialize($regMaster['hash']);
                 unset($regMaster['hash']);
                 $table = isset($hash['t']) ? trim($hash['t']) : '';
                 $pk = isset($hash['pk']) ? trim($hash['pk']) : '';
                 $pkid = isset($hash['i']) ? trim($hash['i']) : '';
                 $fields = isset($hash['f']) ? explode(',', $hash['f']) : '*';
                 $prdId =  isset($hash['prd_id']) ? $hash['prd_id'] : 0;

                 $callerNumber = $this->db->select($fields)->get_where($table, array($pk => $pkid))->row_array();
                 $callerNumber = isset($callerNumber['phone']) ? $callerNumber['phone'] : 0;
                 if (!empty($callerNumber)) {
                      $callerNumber = substr($callerNumber, -10);
                      $allCalls = $this->db->select($pk)->like('cws_phone', $callerNumber, 'both')
                                      ->where('cws_punched_by', 0)->get($table)->result_array();
                      $allCalls = array_column($allCalls, $pk);
                 }
                 $punchOn = date('Y-m-d h:i:s');
                 if (!empty($allCalls)) {
                      $this->db->where_in($pk, $allCalls)->update($table, array('cws_punched_by' => $this->uid,
                          'cws_punched_on' => $punchOn));
                 }
            }

            if (!isset($regMaster['vreg_assigned_to'])) {
                 //Get department details
                 $dept = array();
                 if (!empty($regMaster['vreg_department'])) {
                      $dept = $this->db->get_where($this->tbl_departments, array('dep_id' => $regMaster['vreg_department']))->row_array();
                 }

                 $regMaster['vreg_assigned_to'] = 0;
                 $regMaster['vreg_showroom'] = $this->shrm;
                 $regMaster['vreg_added_by'] = $this->uid;
                 $regMaster['vreg_added_on'] = date('Y-m-d h:i:s');
                 $regMaster['vreg_entry_date'] = date('Y-m-d', strtotime($regMaster['vreg_entry_date']));
                 if ($this->db->insert($this->tbl_register_master, array_filter($regMaster))) {
                      $id = $this->db->insert_id();
                      
                      /* Set ass punched */
                      if($prdId > 0) {
                         $this->db->where('prd_id', $prdId)->update($this->tbl_products, array('prd_reg_id' => $id));
                      }

                      $this->addRegisterHistory(
                              array(
                                  'regh_register_master' => $id,
                                  'regh_assigned_by' => $this->uid,
                                  'regh_assigned_to' => $regMaster['vreg_assigned_to'],
                                  'regh_remarks' => $regMaster['vreg_customer_remark'],
                                  'regh_phone_num' => $regMaster['vreg_cust_phone'],
                                  'regh_system_cmd' => 'Register punched none sales department'
                              )
                      );
                      generate_log(array(
                          'log_title' => 'Enquiry registration',
                          'log_desc' => 'New registration punched related to HR, CRM etc...',
                          'log_controller' => strtolower(__CLASS__),
                          'log_action' => 'C',
                          'log_ref_id' => $id,
                          'log_added_by' => get_logged_user('usr_id')
                      ));

                      if (!empty($dept)) {
                           $this->load->library('email', Array(
                               'protocol' => 'smtp',
                               'smtp_host' => SMTP_HOST,
                               'smtp_port' => SMTP_PORT,
                               'smtp_user' => SMTP_USER,
                               'smtp_pass' => SMTP_PASS,
                               'mailtype' => 'html',
                               'charset' => 'utf-8'
                           ));

                           $message = "<table>"
                                   . "<tr>"
                                   . "<td>Date</td>"
                                   . "<td>" . $regMaster['vreg_entry_date'] . "</td>"
                                   . "</tr>"
                                   . "<tr>"
                                   . "<td>Name</td>"
                                   . "<td>" . $regMaster['vreg_cust_name'] . "</td>"
                                   . "</tr>"
                                   . "<tr>"
                                   . "<td>Phone</td>"
                                   . "<td>" . $regMaster['vreg_cust_phone'] . "</td>"
                                   . "</tr>"
                                   . "<tr>"
                                   . "<td>Place</td>"
                                   . "<td>" . $regMaster['vreg_cust_place'] . "</td>"
                                   . "</tr>"
                                   . "<td>Message</td>"
                                   . "<td>" . $regMaster['vreg_customer_remark'] . "</td>"
                                   . "</tr>"
                                   . "</table>";

                           $this->email->set_newline("\r\n");
                           $this->email->to($dept['dep_mail']);
                           $this->email->subject('CRM - Mail from admin portal');
                           $this->email->message($message);
                           $this->email->reply_to('noreply@royaldrive.in', 'Royaldrive');
                           $this->email->from('admin@royaldrive.in', 'CRM - Mail from admin portal');
                           $this->email->send();
                      }
                      //Register id to call bridge
                      if (!empty($allCalls)) {
                           $this->db->where_in($pk, $pkid)->update($table, array('cws_register_ref' => $id));
                           $query = $this->db->last_query();
                           generate_log(array(
                               'log_title' => 'cws_register_ref-query',
                               'log_desc' => $query,
                               'log_controller' => strtolower(__CLASS__),
                               'log_action' => 'C',
                               'log_ref_id' => $id,
                               'log_added_by' => get_logged_user('usr_id')
                           ));
                      }
                      return true;
                 } else {
                      return false;
                 }
            } else {

                 $inqHistory = array();
                 $inquiry = array();

                 $previousEnq = $this->getEnquiryByMobile($regMaster['vreg_cust_phone']);
                 $newSE = $this->common_model->getUser($regMaster['vreg_assigned_to']);

                 $newSEName = isset($newSE['usr_username']) ? $newSE['usr_username'] : '';
                 $oldSEName = isset($previousEnq['usr_username']) ? $previousEnq['usr_username'] : '';

                 if (!empty($previousEnq)) {
                      if ($previousEnq['enq_current_status'] != 1) { // Not active mod
                           $currentStsDetails = $this->db->get_where($this->tbl_statuses, array('sts_value' => $previousEnq['enq_current_status']))->row_array();
                           $regMaster['vreg_is_verified'] = 0;
                           $regMaster['vreg_verified_by'] = 0;
                           $inqHistory['enh_status'] = inquiry_reopened;
                           $inquiry['enq_current_status'] = inquiry_reopened;
                           $inqHistory['enh_remarks'] = 'Current inquiry status is ' . $currentStsDetails['sts_des'] . ', so this inquiry is assigned from ' . $oldSEName . ' to ' . $newSEName;
                      } else if ($previousEnq['enq_se_id'] == $regMaster['vreg_assigned_to']) { // If previous inq SE id same to new SE id
                           $regMaster['vreg_is_verified'] = 1;
                           $regMaster['vreg_verified_by'] = $this->uid;
                           $inqHistory['enh_status'] = 1;
                           $inquiry['enq_current_status'] = 1;
                           $inqHistory['enh_remarks'] = 'Registerd as new entry but already exists in inquiry and is assigned to ' . $newSEName;
                      } else { // If previous inq is open and assign to new SE
                           $regMaster['vreg_is_verified'] = 0;
                           $regMaster['vreg_verified_by'] = 0;
                           $inqHistory['enh_status'] = inquiry_reopened;
                           $inquiry['enq_current_status'] = inquiry_reopened;
                           $inqHistory['enh_remarks'] = 'Registerd as new entry but already exists in inquiry in other executive and is assigned from ' . $oldSEName . ' to ' . $newSEName;
                      }

                      // Create inquiry history
                      $inqHistory['enh_added_by'] = $this->uid;
                      $inqHistory['enh_added_on'] = date('Y-m-d');
                      $inqHistory['enh_enq_id'] = $previousEnq['enq_id'];
                      $inqHistory['enh_current_sales_executive'] = $regMaster['vreg_assigned_to'];
                      $this->db->insert($this->tbl_enquiry_history, $inqHistory);
                      $historyId = $this->db->insert_id();

                      $inquiry['enq_is_already_exists'] = 1;
                      $inquiry['enq_current_status_history'] = $historyId;
                      $this->db->where('enq_id', $previousEnq['enq_id'])->update($this->tbl_enquiry, $inquiry);
                 } else {
                      $regMaster['vreg_is_verified'] = 1;
                      $regMaster['vreg_verified_by'] = $this->uid;
                 }
                 $oldEnqSEId = (isset($previousEnq['enq_se_id']) && !empty($previousEnq['enq_se_id'])) ? $previousEnq['enq_se_id'] : 0;
                 $assignedTo = (isset($regMaster['vreg_assigned_to']) && !empty($regMaster['vreg_assigned_to'])) ? $regMaster['vreg_assigned_to'] : $this->uid;
                 $regMaster['vreg_inquiry'] = (isset($previousEnq['enq_id']) && !empty($previousEnq['enq_id'])) ? $previousEnq['enq_id'] : 0;
                 $regMaster['vreg_status'] = (isset($previousEnq['enq_id']) && !empty($previousEnq['enq_id'])) ? 1 : 0;
                 $regMaster['vreg_showroom'] = $this->shrm;
                 $regMaster['vreg_added_by'] = $this->uid;
                 $regMaster['vreg_added_on'] = date('Y-m-d h:i:s');
                 $regMaster['vreg_entry_date'] = date('Y-m-d', strtotime($regMaster['vreg_entry_date']));
                 //$regMaster['vreg_assigned_to'] = (empty($oldEnqSEId)) ? $assignedTo : $oldEnqSEId;

                 if ($this->db->insert($this->tbl_register_master, array_filter($regMaster))) {
                      $id = $this->db->insert_id();
                      $this->addRegisterHistory(
                              array(
                                  'regh_register_master' => $id,
                                  'regh_assigned_by' => $this->uid,
                                  'regh_assigned_to' => $regMaster['vreg_assigned_to'],
                                  'regh_remarks' => $regMaster['vreg_customer_remark'],
                                  'regh_phone_num' => $regMaster['vreg_cust_phone'],
                                  'regh_system_cmd' => 'Web inquiry punched to sales department'
                              )
                      );
                      generate_log(array(
                          'log_title' => 'New vehicle registration',
                          'log_desc' => 'New vehicle registration',
                          'log_controller' => strtolower(__CLASS__),
                          'log_action' => 'C',
                          'log_ref_id' => $id,
                          'log_added_by' => get_logged_user('usr_id')
                      ));
                      //Register id to call bridge
                      if (!empty($allCalls)) {
                           $this->db->where_in($pk, $pkid)->update($table, array('cws_register_ref' => $id));
                      }
                      //SMS To SE
                      /* $assignedTo = $this->common_model->getUser($regMaster['vreg_assigned_to']);
                        if (!empty($assignedTo) && isset($assignedTo['usr_phone'])) {

                        $brandName = isset($regMaster['vreg_brand']) ? $regMaster['vreg_brand'] : 0;
                        $modelName = isset($regMaster['vreg_model']) ? $regMaster['vreg_model'] : 0;
                        $varient = isset($regMaster['vreg_varient']) ? $regMaster['vreg_varient'] : 0;

                        $vehicle = $this->getBrandModelVarientName($brandName, $modelName, $varient);

                        $brandName = isset($vehicle['brandName']['brd_title']) ? $vehicle['brandName']['brd_title'] : '';
                        $modelName = isset($vehicle['modelName']['mod_title']) ? $vehicle['modelName']['mod_title'] : '';
                        $varient = isset($vehicle['varientName']['var_variant_name']) ? $vehicle['varientName']['var_variant_name'] : '';

                        $assignedBy = $this->common_model->getUser($this->uid);
                        $mob = $regMaster['vreg_cust_phone'];
                        $name = $regMaster['vreg_cust_name'];
                        $assignedBy = isset($assignedBy['usr_username']) ? $assignedBy['usr_username'] : '';
                        $msg = $assignedBy . ' assigned inquiry of ' . $name . ', ' . $mob . ', ' . $brandName . ', ' . $modelName . ',' . $varient;
                        send_sms($msg, $assignedTo['usr_phone'], 'sms-register');
                        } */
                      return true;
                 } else {
                      return false;
                 }
            }
       }

       function getEnquiryByMobile($phoneNo) {
            if (!empty($phoneNo)) {
                 $cusMobile = substr(trim($phoneNo), -10);
                 return $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                                 ->like('enq_cus_mobile', $cusMobile, 'before')->get($this->tbl_enquiry)->row_array();
            }
            return false;
       }

       function addRegisterHistory($datas, $updateRegMstr = true) {
            $datas['regh_added_by'] = $this->uid;
            $datas['regh_added_date'] = date('Y-m-d h:i:s');
            $this->db->insert($this->tbl_register_history, $datas);
            if ($updateRegMstr) {
                 $this->db->where('vreg_id', $datas['regh_register_master'])
                         ->update($this->tbl_register_master, array('vreg_assigned_to' => $datas['regh_assigned_to']));
            }
       }

       function getAllPurchgaseInquires($id = 0) {

          $this->db->select($this->tbl_products . '.*, ' . $this->tbl_rana_users . '.username,' . $this->tbl_rana_users . '.phone,' . $this->tbl_rana_users . '.email,' .
                          $this->tbl_rana_users . '.usr_phone_code,' . $this->tbl_model . '.mod_id,' . $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.*,' . 
                          $this->tbl_variant . '.*, assignedby.usr_username AS assignedby_usr_username', false)
                  ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'LEFT')
                  ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'LEFT')
                  ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'LEFT')
                  ->join($this->tbl_users .' assignedby',  'assignedby.usr_id = ' . $this->tbl_products . '.prd_assign_to', 'LEFT')
                  ->join($this->tbl_rana_users, $this->tbl_rana_users . '.id = ' . $this->tbl_products . '.prd_user_id', 'LEFT');
          $this->db->where($this->tbl_products . '.prd_added_by_user', 1)->where($this->tbl_products . '.prd_reg_id', 0);
          $this->db->where('('.$this->tbl_products . '.prd_usr_ph_num IS NOT NULL OR ' . $this->tbl_rana_users . '.phone IS NOT NULL)');
          if(!is_roo_user()) {
               if (check_permission('webenquires', 'showmypurchaseenquires')) {
                    $this->db->where($this->tbl_products . '.prd_assign_to', $this->uid);
               }
          }
          if (!empty($id)) {
               $this->db->where($this->tbl_products . '.prd_id', $id);
               $return = $this->db->get($this->tbl_products)->row_array();
          } else {
               $return = $this->db->get($this->tbl_products)->result_array();
          }
          return $return;
     }

     public function createPurchaseEnq($regMaster) {
          date_default_timezone_set("Asia/Calcutta");
          $regMaster['vreg_first_owner'] = $this->uid;
          $regMaster['vreg_first_added_on'] = date('Y-m-d h:i:s');
          $allCalls = array();
          if (isset($regMaster['hash']) && !empty($regMaster['hash'])) {
               $hash = unserialize($regMaster['hash']);
               unset($regMaster['hash']);
               $table = isset($hash['t']) ? trim($hash['t']) : '';
               $pk = isset($hash['pk']) ? trim($hash['pk']) : '';
               $pkid = isset($hash['i']) ? trim($hash['i']) : '';
               $fields = isset($hash['f']) ? explode(',', $hash['f']) : '*';
          }

          if (!isset($regMaster['vreg_assigned_to'])) {
               //Get department details
               $dept = array();
               if (!empty($regMaster['vreg_department'])) {
                    $dept = $this->db->get_where($this->tbl_departments, array('dep_id' => $regMaster['vreg_department']))->row_array();
               }

               $regMaster['vreg_assigned_to'] = 0;
               $regMaster['vreg_showroom'] = $this->shrm;
               $regMaster['vreg_added_by'] = $this->uid;
               $regMaster['vreg_added_on'] = date('Y-m-d h:i:s');
               $regMaster['vreg_entry_date'] = date('Y-m-d', strtotime($regMaster['vreg_entry_date']));
               if ($this->db->insert($this->tbl_register_master, array_filter($regMaster))) {
                    $id = $this->db->insert_id();
                    $this->addRegisterHistory(
                            array(
                                'regh_register_master' => $id,
                                'regh_assigned_by' => $this->uid,
                                'regh_assigned_to' => $regMaster['vreg_assigned_to'],
                                'regh_remarks' => $regMaster['vreg_customer_remark'],
                                'regh_phone_num' => $regMaster['vreg_cust_phone'],
                                'regh_system_cmd' => 'Register punched none sales department'
                            )
                    );
                    generate_log(array(
                        'log_title' => 'Enquiry registration',
                        'log_desc' => 'New registration punched related to HR, CRM etc...',
                        'log_controller' => strtolower(__CLASS__),
                        'log_action' => 'C',
                        'log_ref_id' => $id,
                        'log_added_by' => get_logged_user('usr_id')
                    ));

                    if (!empty($dept)) {
                         $this->load->library('email', Array(
                             'protocol' => 'smtp',
                             'smtp_host' => SMTP_HOST,
                             'smtp_port' => SMTP_PORT,
                             'smtp_user' => SMTP_USER,
                             'smtp_pass' => SMTP_PASS,
                             'mailtype' => 'html',
                             'charset' => 'utf-8'
                         ));

                         $message = "<table>"
                                 . "<tr>"
                                 . "<td>Date</td>"
                                 . "<td>" . $regMaster['vreg_entry_date'] . "</td>"
                                 . "</tr>"
                                 . "<tr>"
                                 . "<td>Name</td>"
                                 . "<td>" . $regMaster['vreg_cust_name'] . "</td>"
                                 . "</tr>"
                                 . "<tr>"
                                 . "<td>Phone</td>"
                                 . "<td>" . $regMaster['vreg_cust_phone'] . "</td>"
                                 . "</tr>"
                                 . "<tr>"
                                 . "<td>Place</td>"
                                 . "<td>" . $regMaster['vreg_cust_place'] . "</td>"
                                 . "</tr>"
                                 . "<td>Message</td>"
                                 . "<td>" . $regMaster['vreg_customer_remark'] . "</td>"
                                 . "</tr>"
                                 . "</table>";

                         $this->email->set_newline("\r\n");
                         $this->email->to($dept['dep_mail']);
                         $this->email->subject('CRM - Mail from admin portal');
                         $this->email->message($message);
                         $this->email->reply_to('noreply@royaldrive.in', 'Royaldrive');
                         $this->email->from('admin@royaldrive.in', 'CRM - Mail from admin portal');
                         $this->email->send();
                    }
                    //Register id to call bridge
                    if ($id) {
                         //  debug($pkid);
                         $punchOn = date('Y-m-d h:i:s');
                         $this->db->where('prd_id', $pkid)->update($this->tbl_products, array('prd_reg_id' => $id, 'prd_punched_by' => $this->uid, 'prd_punched_on' => $punchOn));
                         $query = $this->db->last_query();
                         generate_log(array(
                             'log_title' => 'cws_register_ref-query',
                             'log_desc' => $query,
                             'log_controller' => strtolower(__CLASS__),
                             'log_action' => 'C',
                             'log_ref_id' => $id,
                             'log_added_by' => get_logged_user('usr_id')
                         ));
                    }
                    return true;
               } else {
                    return false;
               }
          } else {

               $inqHistory = array();
               $inquiry = array();

               $previousEnq = $this->getEnquiryByMobile($regMaster['vreg_cust_phone']);
               $newSE = $this->common_model->getUser($regMaster['vreg_assigned_to']);

               $newSEName = isset($newSE['usr_username']) ? $newSE['usr_username'] : '';
               $oldSEName = isset($previousEnq['usr_username']) ? $previousEnq['usr_username'] : '';

               if (!empty($previousEnq)) {
                    if ($previousEnq['enq_current_status'] != 1) { // Not active mod
                         $currentStsDetails = $this->db->get_where($this->tbl_statuses, array('sts_value' => $previousEnq['enq_current_status']))->row_array();
                         $regMaster['vreg_is_verified'] = 0;
                         $regMaster['vreg_verified_by'] = 0;
                         $inqHistory['enh_status'] = inquiry_reopened;
                         $inquiry['enq_current_status'] = inquiry_reopened;
                         $inqHistory['enh_remarks'] = 'Current inquiry status is ' . $currentStsDetails['sts_des'] . ', so this inquiry is assigned from ' . $oldSEName . ' to ' . $newSEName;
                    } else if ($previousEnq['enq_se_id'] == $regMaster['vreg_assigned_to']) { // If previous inq SE id same to new SE id
                         $regMaster['vreg_is_verified'] = 1;
                         $regMaster['vreg_verified_by'] = $this->uid;
                         $inqHistory['enh_status'] = 1;
                         $inquiry['enq_current_status'] = 1;
                         $inqHistory['enh_remarks'] = 'Registerd as new entry but already exists in inquiry and is assigned to ' . $newSEName;
                    } else { // If previous inq is open and assign to new SE
                         $regMaster['vreg_is_verified'] = 0;
                         $regMaster['vreg_verified_by'] = 0;
                         $inqHistory['enh_status'] = inquiry_reopened;
                         $inquiry['enq_current_status'] = inquiry_reopened;
                         $inqHistory['enh_remarks'] = 'Registerd as new entry but already exists in inquiry in other executive and is assigned from ' . $oldSEName . ' to ' . $newSEName;
                    }

                    // Create inquiry history
                    $inqHistory['enh_added_by'] = $this->uid;
                    $inqHistory['enh_added_on'] = date('Y-m-d');
                    $inqHistory['enh_enq_id'] = $previousEnq['enq_id'];
                    $inqHistory['enh_current_sales_executive'] = $regMaster['vreg_assigned_to'];
                    $this->db->insert($this->tbl_enquiry_history, $inqHistory);
                    $historyId = $this->db->insert_id();

                    $inquiry['enq_is_already_exists'] = 1;
                    $inquiry['enq_current_status_history'] = $historyId;
                    $this->db->where('enq_id', $previousEnq['enq_id'])->update($this->tbl_enquiry, $inquiry);
               } else {
                    $regMaster['vreg_is_verified'] = 1;
                    $regMaster['vreg_verified_by'] = $this->uid;
               }
               $oldEnqSEId = (isset($previousEnq['enq_se_id']) && !empty($previousEnq['enq_se_id'])) ? $previousEnq['enq_se_id'] : 0;
               $assignedTo = (isset($regMaster['vreg_assigned_to']) && !empty($regMaster['vreg_assigned_to'])) ? $regMaster['vreg_assigned_to'] : $this->uid;
               $regMaster['vreg_inquiry'] = (isset($previousEnq['enq_id']) && !empty($previousEnq['enq_id'])) ? $previousEnq['enq_id'] : 0;
               $regMaster['vreg_status'] = (isset($previousEnq['enq_id']) && !empty($previousEnq['enq_id'])) ? 1 : 0;
               $regMaster['vreg_showroom'] = $this->shrm;
               $regMaster['vreg_added_by'] = $this->uid;
               $regMaster['vreg_added_on'] = date('Y-m-d h:i:s');
               $regMaster['vreg_entry_date'] = date('Y-m-d', strtotime($regMaster['vreg_entry_date']));
               //$regMaster['vreg_assigned_to'] = (empty($oldEnqSEId)) ? $assignedTo : $oldEnqSEId;

               if ($this->db->insert($this->tbl_register_master, array_filter($regMaster))) {
                    $id = $this->db->insert_id();
                    $this->addRegisterHistory(
                            array(
                                'regh_register_master' => $id,
                                'regh_assigned_by' => $this->uid,
                                'regh_assigned_to' => $regMaster['vreg_assigned_to'],
                                'regh_remarks' => $regMaster['vreg_customer_remark'],
                                'regh_phone_num' => $regMaster['vreg_cust_phone'],
                                'regh_system_cmd' => 'Web inquiry punched to sales department'
                            )
                    );
                    generate_log(array(
                        'log_title' => 'New vehicle registration',
                        'log_desc' => 'New vehicle registration',
                        'log_controller' => strtolower(__CLASS__),
                        'log_action' => 'C',
                        'log_ref_id' => $id,
                        'log_added_by' => get_logged_user('usr_id')
                    ));
                    //Register id to call bridge
                    if ($id) {
                         // debug($pkid);
                         $punchOn = date('Y-m-d h:i:s');
                         $this->db->where('prd_id', $pkid)->update($this->tbl_products, array('prd_reg_id' => $id, 'prd_punched_by' => $this->uid, 'prd_punched_on' => $punchOn));
                    }
                    //SMS To SE
                    /* $assignedTo = $this->common_model->getUser($regMaster['vreg_assigned_to']);
                      if (!empty($assignedTo) && isset($assignedTo['usr_phone'])) {

                      $brandName = isset($regMaster['vreg_brand']) ? $regMaster['vreg_brand'] : 0;
                      $modelName = isset($regMaster['vreg_model']) ? $regMaster['vreg_model'] : 0;
                      $varient = isset($regMaster['vreg_varient']) ? $regMaster['vreg_varient'] : 0;

                      $vehicle = $this->getBrandModelVarientName($brandName, $modelName, $varient);

                      $brandName = isset($vehicle['brandName']['brd_title']) ? $vehicle['brandName']['brd_title'] : '';
                      $modelName = isset($vehicle['modelName']['mod_title']) ? $vehicle['modelName']['mod_title'] : '';
                      $varient = isset($vehicle['varientName']['var_variant_name']) ? $vehicle['varientName']['var_variant_name'] : '';

                      $assignedBy = $this->common_model->getUser($this->uid);
                      $mob = $regMaster['vreg_cust_phone'];
                      $name = $regMaster['vreg_cust_name'];
                      $assignedBy = isset($assignedBy['usr_username']) ? $assignedBy['usr_username'] : '';
                      $msg = $assignedBy . ' assigned inquiry of ' . $name . ', ' . $mob . ', ' . $brandName . ', ' . $modelName . ',' . $varient;
                      send_sms($msg, $assignedTo['usr_phone'], 'sms-register');
                      } */
                    return true;
               } else {
                    return false;
               }
          }
      }

      function exportPurchaseEnq() {
          $selectArray = array(
              $this->tbl_products . '.prd_number',
              $this->tbl_products . '.prd_color',
              $this->tbl_products . '.prd_model',
              $this->tbl_products . '.prd_price',
              $this->tbl_products . '.prd_variant',
              $this->tbl_products . '.prd_brand',
              $this->tbl_products . '.prd_date',
              $this->tbl_rana_users . '.username',
              $this->tbl_rana_users . '.phone',
              $this->tbl_rana_users . '.email',
              $this->tbl_brand . '.brd_title',
              $this->tbl_model . '.mod_title',
              $this->tbl_variant . '.var_variant_name'
          );
          $this->db->select($selectArray, false)
                  ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'LEFT')
                  ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'LEFT')
                  ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'LEFT')
                  ->join($this->tbl_rana_users, $this->tbl_rana_users . '.id = ' . $this->tbl_products . '.prd_user_id', 'LEFT');
          $this->db->where($this->tbl_products . '.prd_added_by_user', 1);
          $this->db->where($this->tbl_products . '.prd_reg_id', 0);
          $this->db->where($this->tbl_rana_users . '.phone IS NOT NULL');
          if(!is_roo_user()) {
               if (check_permission('webenquires', 'showmypurchaseenquires')) {
                    $this->db->where($this->tbl_products . '.prd_assign_to', $this->uid);
               }
          }
          $this->db->where('(' . $this->tbl_products . '.prd_usr_ph_num IS NOT NULL OR ' . $this->tbl_rana_users . '.phone IS NOT NULL)');

          $return = $this->db->get($this->tbl_products)->result_array();
          return $return;
     }

     function deletepurchaseenq($enqId) {
          if(!empty($enqId)) {
               $this->db->where('prd_id', $enqId)->delete($this->tbl_products);
               $this->db->where('pft_prod_id', $enqId)->delete($this->tbl_prod_features);
               $this->db->where('pdi_prod_id', $enqId)->delete($this->tbl_prod_images);
               $this->db->where('spe_prod_id', $enqId)->delete($this->tbl_prod_specifications); 
               return true;
          }
          return false;
     }
  }
  