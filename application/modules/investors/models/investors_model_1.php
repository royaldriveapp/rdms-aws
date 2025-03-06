<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class investors_model extends CI_Model {

     public function __construct() {
          parent::__construct();
          $this->load->database();

          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_events = TABLE_PREFIX . 'events';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_statuses = TABLE_PREFIX . 'statuses';
          $this->tbl_division = TABLE_PREFIX . 'division';
          $this->tbl_departments = TABLE_PREFIX . 'departments';
          $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
          $this->tbl_register_history = TABLE_PREFIX . 'register_history';
          $this->tbl_callcenterbridging = TABLE_PREFIX . 'callcenterbridging';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->tbl_products = TABLE_PREFIX_RANA . 'products';
          $this->tbl_investors_master = TABLE_PREFIX . 'investors_master';
          $this->tbl_investors_phone = TABLE_PREFIX . 'investors_phone';
          $this->tbl_investors_proof = TABLE_PREFIX . 'investors_proof';
          $this->tbl_investors_vehicle = TABLE_PREFIX . 'investors_vehicle';
          $this->tbl_investors_details = TABLE_PREFIX . 'investors_details';
          $this->tbl_investors_invested_company = TABLE_PREFIX . 'investors_invested_company';
     }

     function getVoxBayDetails($voxBayId) {

          return $this->db->select($this->tbl_callcenterbridging . '.ccb_recording_URL,' . $this->tbl_callcenterbridging . '.ccb_callerNumber')
                          ->get_where($this->tbl_callcenterbridging, array('ccb_id' => $voxBayId))->row_array();
     }

     function getInvester($id = 0) {

          if (!empty($id)) {
               $data['master'] = $this->db->select($this->tbl_investors_master . '.*,' . $this->tbl_district_statewise . '.*')
                               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_investors_master . '.inv_dist')->get_where($this->tbl_investors_master, array('inv_id' => $id))->row_array();
               $data['phone'] = $this->db->get_where($this->tbl_investors_phone, array('invp_master' => $id))->result_array();
               $data['proof'] = $this->db->get_where($this->tbl_investors_proof, array('invpf_master' => $id))->result_array();

               $data['otherInvest'] = $this->db->get_where($this->tbl_investors_invested_company, array('invic_master' => $id))->result_array();

               $data['vehle'] = $this->db->select($this->tbl_investors_vehicle . '.*,' . $this->tbl_brand . '.brd_title,' .
                                       $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name')
                               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_investors_vehicle . '.invv_brand', 'left')
                               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_investors_vehicle . '.invv_model', 'left')
                               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_investors_vehicle . '.invv_varient', 'left')
                               ->get_where($this->tbl_investors_vehicle, array('invv_master' => $id))->result_array();
               return $data;
          }

          $selectArray = array(
              $this->tbl_investors_master . '.*',
              '(SELECT GROUP_CONCAT(invp_phone) AS numbrs FROM cpnl_investors_phone WHERE ' .
              $this->tbl_investors_master . '.inv_id = ' . $this->tbl_investors_phone . '.invp_master) AS cntct_numbrs',
              $this->tbl_district_statewise . '.std_district_name'
          );

          return $this->db->select($selectArray, false)
                          ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_investors_master . '.inv_dist', 'LEFT')
                          ->get($this->tbl_investors_master)->result_array();
     }

     function createLead($data) {

          //Master
          $data['mstr']['inv_added_by'] = $this->uid;
          $data['mstr']['inv_added_on'] = date('Y-m-d H:i:s');
          $this->db->insert($this->tbl_investors_master, $data['mstr']);
          $mstrId = $this->db->insert_id();

          $this->newAddressPhoneVehicle($data, $mstrId);
          return $mstrId;
     }

     function updateVoxBayDetails($voxBayId, $investrId) {
          $this->db->where('ccb_id', $voxBayId)->update($this->tbl_callcenterbridging, array('ccb_register_ref' => $investrId));
     }

     function update($data) {

          if (isset($data['inv_id']) && !empty($data['inv_id'])) {
               $masterId = $data['inv_id'];

               //Master
               $data['mstr']['inv_last_uptd_by'] = $this->uid;
               $data['mstr']['inv_last_uptd_on'] = date('Y-m-d H:i:s');
               $this->db->where(array('inv_id' => $masterId))->update($this->tbl_investors_master, $data['mstr']);

               //Contact numbers edit
               if (isset($data['cnct']['invp_phone_u']) && !empty($data['cnct']['invp_phone_u'])) {
                    $index = 0;
                    $this->db->delete($this->tbl_investors_phone, array('invp_master' => $masterId));
                    foreach ($data['cnct']['invp_phone_u'] as $key => $number) {
                         $primary = ($index == 0) ? 1 : 0;
                         $this->db->insert($this->tbl_investors_phone, array(
                             'invp_id' => $key,
                             'invp_phone' => $number,
                             'invp_primary' => $primary,
                             'invp_master' => $masterId
                         ));
                         $index++;
                    }
               }

               //Proof
               if (isset($data['ap']['invpf_proof_id_u']) && !empty($data['ap']['invpf_proof_id_u'])) {
                    $this->db->delete($this->tbl_investors_proof, array('invpf_master' => $masterId));
                    foreach ($data['ap']['invpf_proof_id_u'] as $pftKey => $prfVal) {
                         $this->db->insert($this->tbl_investors_proof, array(
                             'invpf_id' => $pftKey,
                             'invpf_proof_id' => !empty($prfVal) ? $prfVal : 0,
                             'invpf_proof_number' => isset($data['ap']['invpf_proof_number_u'][$pftKey]) ? $data['ap']['invpf_proof_number_u'][$pftKey] : 0,
                             'invpf_master' => $masterId
                         ));
                    }
               }
               //Vehicle
               if (isset($data['veh']['invv_brand_u']) && !empty($data['veh']['invv_brand_u'])) {
                    $this->db->delete($this->tbl_investors_vehicle, array('invv_master' => $masterId));
                    foreach ($data['veh']['invv_brand_u'] as $vehKey => $vehVal) {
                         $this->db->insert($this->tbl_investors_vehicle, array(
                             'invv_brand' => isset($vehVal) ? $vehVal : 0,
                             'invv_model' => isset($data['veh']['invv_model_u'][$vehKey]) ? $data['veh']['invv_model_u'][$vehKey] : 0,
                             'invv_varient' => isset($data['veh']['invv_varient_u'][$vehKey]) ? $data['veh']['invv_varient_u'][$vehKey] : 0,
                             'invv_master' => $masterId
                         ));
                    }
               }

               //Other invested comanies
               if (isset($data['veh']['invv_brand_u']) && !empty($data['veh']['invv_brand_u'])) {
                    $this->db->delete($this->tbl_investors_vehicle, array('invv_master' => $masterId));
                    foreach ($data['veh']['invv_brand_u'] as $vehKey => $vehVal) {
                         $this->db->insert($this->tbl_investors_vehicle, array(
                             'invv_brand' => isset($vehVal) ? $vehVal : 0,
                             'invv_model' => isset($data['veh']['invv_model_u'][$vehKey]) ? $data['veh']['invv_model_u'][$vehKey] : 0,
                             'invv_varient' => isset($data['veh']['invv_varient_u'][$vehKey]) ? $data['veh']['invv_varient_u'][$vehKey] : 0,
                             'invv_master' => $masterId
                         ));
                    }
               }

               $this->newAddressPhoneVehicle($data, $masterId);
               return true;
          }
     }

     function newAddressPhoneVehicle($data, $masterId) {
          //Contact numbers
          if (isset($data['cnct']['invp_phone']) && !empty($data['cnct']['invp_phone'])) {
               foreach ($data['cnct']['invp_phone'] as $key => $numbers) {
                    if (!empty($numbers)) {
                         $primary = ($key == 0) ? 1 : 0;
                         $this->db->insert($this->tbl_investors_phone, array(
                             'invp_phone' => $numbers,
                             'invp_primary' => $primary,
                             'invp_master' => $masterId
                         ));
                    }
               }
          }
          //Proof
          if (isset($data['ap']['invpf_proof_id']) && !empty($data['ap']['invpf_proof_id'])) {
               $proofCount = count($data['ap']['invpf_proof_id']);
               for ($i = 0; $i < $proofCount; $i++) {
                    if ((isset($data['ap']['invpf_proof_id'][$i]) && !empty($data['ap']['invpf_proof_id'][$i])) &&
                            (isset($data['ap']['invpf_proof_number'][$i]) && !empty($data['ap']['invpf_proof_number'][$i]))) {
                         $this->db->insert($this->tbl_investors_proof, array(
                             'invpf_proof_id' => isset($data['ap']['invpf_proof_id'][$i]) ? $data['ap']['invpf_proof_id'][$i] : 0,
                             'invpf_proof_number' => isset($data['ap']['invpf_proof_number'][$i]) ? $data['ap']['invpf_proof_number'][$i] : 0,
                             'invpf_master' => $masterId
                         ));
                    }
               }
          }
          //Vehicle
          if (isset($data['veh']['invv_brand']) && !empty($data['veh']['invv_brand'])) {
               $vehCount = count($data['veh']['invv_brand']);
               for ($i = 0; $i < $vehCount; $i++) {
                    if (((isset($data['veh']['invv_brand'][$i])) && (!empty($data['veh']['invv_brand'][$i]))) &&
                            ((isset($data['veh']['invv_model'][$i])) && (!empty($data['veh']['invv_model'][$i])))) {
                         $this->db->insert($this->tbl_investors_vehicle, array(
                             'invv_brand' => (int) $data['veh']['invv_brand'][$i],
                             'invv_model' => (int) $data['veh']['invv_model'][$i],
                             'invv_varient' => (int) $data['veh']['invv_varient'][$i],
                             'invv_master' => $masterId
                         ));
                    }
               }
          }

          //company
          if (isset($data['company']['invic_company']) && !empty($data['company']['invic_company'])) {
               foreach ($data['company']['invic_company'] as $key => $invCompany) {
                    if (!empty($invCompany)) {
                         $this->db->insert($this->tbl_investors_invested_company, array(
                             'invic_company' => $invCompany,
                             'invic_master' => $masterId
                         ));
                    }
               }
          }
     }

     function makeInvest($datas) {
          $datas['details']['invd_entry_date'] = date('Y-m-d', strtotime($datas['details']['invd_entry_date']));
          $this->db->insert($this->tbl_investors_details, $datas['details']);
          return true;
     }

     function getInvestments($investerId) {
          return $this->db->select($this->tbl_investors_details . '.*,' . $this->tbl_investors_master . '.*')
                          ->join($this->tbl_investors_master, $this->tbl_investors_master . '.inv_id = ' . $this->tbl_investors_details . '.invd_investor', 'LEFT')
                          ->where($this->tbl_investors_details . '.invd_investor', $investerId)->get($this->tbl_investors_details)->result_array();
     }

     function getDistricts($id = '') {
          if ($id) {
               return $this->db->where_in($this->tbl_district_statewise . '.std_state', $id)->get($this->tbl_district_statewise)->result_array();
          }
          return $this->db->get($this->tbl_district_statewise)->result_array();
     }

     public function delete($id) {

          $this->db->delete($this->tbl_investors_master, array('inv_id' => $id));
          $this->db->delete($this->tbl_investors_phone, array('invp_master' => $id));
          $this->db->delete($this->tbl_investors_proof, array('invpf_master' => $id));
          $this->db->delete($this->tbl_investors_vehicle, array('invv_master' => $id));
          $this->db->delete($this->tbl_investors_invested_company, array('invic_master' => $id));
          $this->db->delete($this->tbl_investors_details, array('invd_investor' => $id));
          return true;
     }

     

     

     function approvalForReschedule($data) {
          $remarks = isset($data['remarks']) ? $data['remarks'] : '';
          unset($data['remarks']);
          $newSE = $this->common_model->getUser($data['vreg_assigned_to']);
          $newSEName = isset($newSE['usr_username']) ? $newSE['usr_username'] : '';
          $showroom = isset($newSE['usr_showroom']) ? $newSE['usr_showroom'] : 0;
          $division = isset($newSE['usr_division']) ? $newSE['usr_division'] : 0;

          $enqH['enh_remarks'] = 'Verified registration and assigned to ' . $newSEName;
          $enqH['enh_added_by'] = $this->uid;
          $enqH['enh_added_on'] = date('Y-m-d');
          $enqH['enh_enq_id'] = $data['vreg_inquiry'];
          $enqH['enh_status'] = 1;
          $enqH['enh_current_sales_executive'] = $data['vreg_assigned_to'];
          $this->db->insert($this->tbl_enquiry_history, $enqH);
          $historyId = $this->db->insert_id();

          $this->addRegisterHistory(
                  array(
                      'regh_register_master' => $data['vreg_id'],
                      'regh_assigned_by' => $this->uid,
                      'regh_assigned_to' => $data['vreg_assigned_to'],
                      'regh_remarks' => $remarks,
                      'regh_system_cmd' => 'Register re assigned to ' . $newSEName
                  ), false
          );

          $enquiryDetails = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $data['vreg_inquiry']))->row_array();
          $seId = isset($enquiryDetails['enq_se_id']) ? $enquiryDetails['enq_se_id'] : 0;

          $enqInsert = array(
              'enq_se_id' => $data['vreg_assigned_to'],
              'enq_current_status' => 1,
              'enq_current_status_history' => $historyId,
              'enq_showroom_id' => $showroom,
              'enq_division' => $division
          );
          if ($seId != $data['vreg_assigned_to']) {
               $enqInsert['enq_entry_date'] = date('Y-m-d', strtotime($data['vreg_entry_date']));
          }

          $this->db->where('enq_id', $data['vreg_inquiry'])->update($this->tbl_enquiry, $enqInsert);

          $log = $data;
          $log['history'] = $enqH;
          generate_log(array(
              'log_title' => 'Old enquiry verified and rescheduled to ' . $newSEName,
              'log_desc' => serialize($log),
              'log_controller' => strtolower(__CLASS__),
              'log_action' => 'U',
              'log_ref_id' => $data['vreg_inquiry'],
              'log_added_by' => get_logged_user('usr_id')
          ));
          $regId = $data['vreg_id'];
          unset($data['vreg_id']);

          $data['vreg_entry_date'] = date('Y-m-d', strtotime($data['vreg_entry_date']));
          $data['vreg_is_verified'] = 1;
          $data['vreg_verified_by'] = $this->uid;
          $this->db->where('vreg_id', $regId)->update($this->tbl_register_master, $data);
          return true;
     }

     function getAutoAssignExecutive($showroom = 0, $division = 0) {
          $autoAssignMembers = $this->db->select('usr_id')->get_where($this->tbl_users, array('usr_showroom' => $showroom, 'usr_can_auto_assign' => 1, 'usr_active' => 1, 'usr_id !=' => $this->uid))->result_array();
          $autoAssignMembers = array_column($autoAssignMembers, 'usr_id');
          $startingDateOfThisMonth = date("Y-m-1");
          $today = date("Y-m-d");

          $members = $this->db->select('vreg_assigned_to, count(vreg_assigned_to) AS curr_reg_count')
                          ->where_in('vreg_assigned_to', $autoAssignMembers)->where('(DATE(vreg_entry_date) >= ' . "DATE('" . $startingDateOfThisMonth . "') " . ' AND DATE(vreg_entry_date) <= ' . "DATE('" . $today . "'))")
                          ->group_by('vreg_assigned_to')->order_by('curr_reg_count', 'ASC')->get($this->tbl_register_master)->result_array();

          if (isset($members['0']['vreg_assigned_to'])) {
               return $members['0']['vreg_assigned_to'];
          } else if (!empty($autoAssignMembers)) {
               return $autoAssignMembers['0'];
          } else {
               return $this->uid;
          }
     }

     function getAllStaffInSales() {
          $this->db->where('usr_id != ', $this->uid);
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
                                  $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
                          ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                          ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                          ->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " .
                                  $this->tbl_groups . ".grp_slug = 'TL')")
                          ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1))
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                          ->get($this->tbl_users)->result_array();
     }

     function addRegisterHistory($datas, $updateRegMstr = true) {
          $datas['regh_added_by'] = $this->uid;
          $datas['regh_added_date'] = date('Y-m-d H:i:s');
          $this->db->insert($this->tbl_register_history, $datas);
          if ($updateRegMstr) {
               $this->db->where('vreg_id', $datas['regh_register_master'])
                       ->update($this->tbl_register_master, array('vreg_assigned_to' => $datas['regh_assigned_to']));
          }
     }

     function getShowRoomByDivision($division) {
          return $this->db->get_where($this->tbl_showroom, array('shr_division' => $division, 'shr_status' => 1))->result_array();
     }

     function getDepartmentByDivision($division) {

          $selectArray = array(
              $this->tbl_departments . '.dep_id',
              $this->tbl_departments . '.dep_name',
              $this->tbl_departments . '.dep_is_sale_rel',
              'parentDep.dep_name AS dep_parent_name'
          );

          return $this->db->select($selectArray, false)->join($this->tbl_departments . ' parentDep', 'parentDep.dep_id = ' . $this->tbl_departments . '.dep_parent', 'LEFT')
                          ->where(array($this->tbl_departments . '.dep_status' => 1, $this->tbl_departments . '.dep_division' => $division))
                          ->get($this->tbl_departments)->result_array();
     }

     function getBrandModelVarientName($brd = 0, $mod = 0, $var = 0) {
          $return = array();
          if ($brd) {
               $return['brandName'] = $this->db->select('brd_title')->get_where($this->tbl_brand, array('brd_id' => $brd))->row_array();
          } if ($mod) {
               $return['modelName'] = $this->db->select('mod_title')->get_where($this->tbl_model, array('mod_id' => $mod))->row_array();
          } if ($var) {
               $return['varientName'] = $this->db->select('var_variant_name')->get_where($this->tbl_variant, array('var_id' => $mod))->row_array();
          }
          return $return;
     }

     function reqToDropRegister($data) {
          $regDetails = $this->db->get_where($this->tbl_register_master, array('vreg_id' => $data['regMaster']))->row_array();
          if (!empty($regDetails)) {
               $comment = isset($data['reason']) ? $data['reason'] : '';
               $status = isset($data['status']) ? $data['status'] : '';
               $this->db->where('vreg_id', $data['regMaster'])->update($this->tbl_register_master, array(
                   'vreg_status' => $status
               ));
               $username = $this->session->userdata('usr_username');
               //h -> H added on 03-12-2020 06:00 AM
               $this->db->insert($this->tbl_register_history, array(
                   'regh_phone_num' => $regDetails['vreg_cust_phone'],
                   'regh_register_master' => $data['regMaster'],
                   'regh_assigned_by' => $regDetails['vreg_added_by'],
                   'regh_assigned_to' => $regDetails['vreg_assigned_to'],
                   'regh_added_date' => date('Y-m-d H:i:s'),
                   'regh_added_by' => $this->uid,
                   'regh_remarks' => $comment,
                   'regh_system_cmd' => 'Requested to drop this register by ' . $username . ' on ' . date('j M Y h:i A'),
                   'regh_status' => $status
               ));
          }
          $alldetails['reqDrop'] = $data;
          $alldetails['register'] = $regDetails;
          generate_log(array(
              'log_title' => 'Request for drop register',
              'log_desc' => serialize($alldetails),
              'log_controller' => 'reg-req-drop',
              'log_action' => 'U',
              'log_ref_id' => $data['regMaster'],
              'log_added_by' => get_logged_user('usr_id')
          ));
          return true;
     }

     public function registerbystatus($id = '', $filter = array()) {
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
              $this->tbl_register_history . '.regh_remarks',
              $this->tbl_register_history . '.regh_system_cmd',
              $this->tbl_departments . '.*'
          );
          $this->db->select($selectArray, false)
                  ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                  ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                  ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
                  ->join($this->tbl_register_history, $this->tbl_register_history . '.regh_register_master = ' . $this->tbl_register_master .
                          '.vreg_id AND ' . $this->tbl_register_history . '.regh_status = ' . reg_droped, 'LEFT')
                  ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                  ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                  ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                  ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left');

          if (!empty($id)) {
               return $this->db->get_where($this->tbl_register_master, array($this->tbl_register_master . '.vreg_id' => $id))->row_array();
          }
          if (check_permission('registration', 'showallreqfordrop') || is_roo_user()) {
               
          } else if (check_permission('registration', 'showmyreqfordrop')) {
               $this->db->where(array('vreg_first_owner' => $this->uid));
          } else if (check_permission('registration', 'showmystaffreqfordrop')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                               ->get($this->tbl_users)->row()->usr_id);
               $this->db->where_in(array('vreg_first_owner' => $mystaffs));
          } else if (check_permission('registration', 'showmyshowroomreqfordrop')) {
               $this->db->where(array('vreg_showroom' => $this->shrm));
          }

          $enq_date_from = (isset($filter['enq_date_from']) && !empty($filter['enq_date_from'])) ?
                  date('Y-m-d', strtotime($filter['enq_date_from'])) : '';

          $enq_date_to = (isset($filter['enq_date_to']) && !empty($filter['enq_date_to'])) ?
                  date('Y-m-d', strtotime($filter['enq_date_to'])) : '';

          if (!empty($enq_date_from)) {
               $this->db->where('DATE(' . $this->tbl_register_master . '.vreg_added_on) >=', $enq_date_from);
          }
          if (!empty($enq_date_to)) {
               $this->db->where('DATE(' . $this->tbl_register_master . '.vreg_added_on) <=', $enq_date_to);
          }
          if (isset($filter['mode']) && !empty($filter['mode'])) {
               $this->db->where_in($this->tbl_register_master . '.vreg_contact_mode', $filter['mode']);
          }
          if (isset($filter['showroom']) && !empty($filter['showroom'])) {
               $this->db->where($this->tbl_register_master . '.vreg_showroom', $filter['showroom']);
          }
          if (isset($filter['executive']) && !empty($filter['executive'])) {
               $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $filter['executive']) . ') OR ' .
                       $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $filter['executive']) . '))');
          }
          if (isset($filter['ststus']) && !empty($filter['ststus'])) {
               $this->db->where($this->tbl_register_master . '.vreg_status', $filter['ststus']);
          }
          return $this->db->get($this->tbl_register_master)->result_array();
     }

     public function waitingForReply() {
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
              $this->tbl_departments . '.*'
          );
          $this->db->select($selectArray, false)
                  ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                  ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                  ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
                  ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                  ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                  ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                  ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left');

          //if (check_permission('registration', 'registrationcreatedbyme')) {
          $this->db->where(array('vreg_first_owner' => $this->uid));
          //}
          $this->db->where(array('vreg_call_type' => 11));

          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          return $this->db->get($this->tbl_register_master)->result_array();
     }

     function getRelatedVehicle($brd, $mod, $vr) {
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
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
              $this->tbl_departments . '.*'
          );
          $this->db->select($selectArray, false)
                  ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                  ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                  ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
                  ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                  ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                  ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                  ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left');

          if (check_permission('registration', 'registrationcreatedbyme') && !is_roo_user()) {
               $this->db->where(array('vreg_first_owner' => $this->uid));
               $this->db->where(array('vreg_assigned_to' => $this->uid));
          }

          if (check_permission('enquiry', 'myregshowonlymyshowroom') && !is_roo_user()) {
               array_push($mystaffs, $this->uid);
               $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                       $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
          }
          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $this->db->where($this->tbl_register_master . '.vreg_inquiry', 0);
          $this->db->where($this->tbl_register_master . '.vreg_brand', $brd);
          return $this->db->get($this->tbl_register_master)->result_array();
     }

     function informStockToCustomer() {
          //Luxury
          $this->tbl_products = TABLE_PREFIX_RANA . 'products';
          $this->db->select($this->tbl_products . '.*,' . $this->tbl_brand . '.*,' . $this->tbl_model . '.*,' . $this->tbl_variant . '.*')->from($this->tbl_products);
          $this->db->join(TABLE_PREFIX_RANA . 'brand', TABLE_PREFIX_RANA . 'brand.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
          $this->db->join(TABLE_PREFIX_RANA . 'category', TABLE_PREFIX_RANA . 'category.cat_id = ' . $this->tbl_products . '.prd_category ', 'left');
          $this->db->join(TABLE_PREFIX_RANA . 'category cat1', 'cat1.cat_id = ' . TABLE_PREFIX_RANA . 'category.cat_parent ', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');
          $this->db->where($this->tbl_products . '.prd_status', 1);
          $this->db->where($this->tbl_products . '.prd_booked', 0);
          $this->db->where($this->tbl_products . '.prd_soled', 0);
          $this->db->where($this->tbl_products . '.prd_rd_mini', 0);
          $data['luxury'] = $this->db->get()->result_array();
          //Smart
          $this->tbl_products = TABLE_PREFIX_RANA . 'products';
          $this->db->select($this->tbl_products . '.*,' . $this->tbl_brand . '.*,' . $this->tbl_model . '.*,' . $this->tbl_variant . '.*')->from($this->tbl_products);
          $this->db->join(TABLE_PREFIX_RANA . 'brand', TABLE_PREFIX_RANA . 'brand.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
          $this->db->join(TABLE_PREFIX_RANA . 'category', TABLE_PREFIX_RANA . 'category.cat_id = ' . $this->tbl_products . '.prd_category ', 'left');
          $this->db->join(TABLE_PREFIX_RANA . 'category cat1', 'cat1.cat_id = ' . TABLE_PREFIX_RANA . 'category.cat_parent ', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');
          $this->db->where($this->tbl_products . '.prd_status', 1);
          $this->db->where($this->tbl_products . '.prd_booked', 0);
          $this->db->where($this->tbl_products . '.prd_soled', 0);
          $this->db->where($this->tbl_products . '.prd_rd_mini', 1);
          $data['smart'] = $this->db->get()->result_array();
          return $data;
     }

     function reghistory($id) {
          $selectArray = array($this->tbl_register_history . '.*',
              $this->tbl_register_master . '.*', 'assign.usr_first_name AS assign_usr_first_name',
              'assign.usr_last_name AS assign_usr_last_name', 'addedby.usr_first_name AS addedby_usr_first_name',
              'addedby.usr_last_name AS addedby_usr_last_name', $this->tbl_events . '.evnt_title',
              $this->tbl_brand . '.brd_id', $this->tbl_brand . '.brd_title', $this->tbl_model . '.mod_id', $this->tbl_model . '.mod_title',
              $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name', $this->tbl_departments . '.*');

          return $this->db->select($selectArray)
                          ->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_register_history . '.regh_register_master', 'LEFT')
                          ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_history . '.regh_assigned_to', 'LEFT')
                          ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_history . '.regh_assigned_by', 'LEFT')
                          ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
                          ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                          ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                          ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                          ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
                          ->where($this->tbl_register_history . '.regh_register_master', $id)->order_by($this->tbl_register_history . '.regh_id', 'DESC')
                          ->get($this->tbl_register_history)->result_array();
     }

     function bindStaffsByShowroom($id) {
          //fetch staffs by showroom
          if (check_permission('registration', 'canselfassignregister')) {
               $this->db->where('usr_id != ', $this->uid);
          }
          $salesStaff = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
                                  $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active')
                          ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                          ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                          ->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
                          ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1, $this->tbl_users . '.usr_showroom' => $id))
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                          ->get($this->tbl_users)->result_array();

          if (check_permission('registration', 'canselfassignregister')) {
               $myself = $this->db->select($this->tbl_users . ".usr_id AS col_id, 'Self' AS col_title, " .
                                       $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active', false)
                               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                               ->where(array($this->tbl_users . '.usr_id' => $this->uid))->get($this->tbl_users)->result_array();
               array_splice($salesStaff, 0, 0, $myself); //Insert new item in array on any position;
          }
          return $salesStaff;
     }

     function reassignedregisters($id = 0) {
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
          if (!empty($id)) {
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

               return $this->db->select($selectArray, false)
                               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
                               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
                               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
                               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'left')
                               ->join($this->tbl_callcenterbridging, $this->tbl_callcenterbridging . '.ccb_id = ' . $this->tbl_register_master . '.vreg_voxbay_ref', 'left')
                               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
                               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left')
                               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left')
                               ->where('vreg_assigned_to', $id)->where('vreg_is_punched', 0)->where_in('vreg_department', array(4, 6, 7, 8))
                               ->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)')
                               ->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses)->get($this->tbl_register_master)->result_array();
          }

          $this->load->model('emp_details/emp_details_model', 'emp_details');
          $setc = $this->emp_details->teleCallers();
          foreach ($setc as $key => $value) {
               $setc[$key]['counts'] = $this->db->select('vreg_cust_name, vreg_first_owner, vreg_added_by, vreg_assigned_to, vreg_last_action, vreg_inquiry')
                               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_register_master . '.vreg_inquiry', 'LEFT')
                               ->where('vreg_assigned_to', $value['col_id'])->where_in('vreg_department', array(4, 6, 7, 8))
                               ->where('vreg_is_punched', 0)->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses)
                               ->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)')
                               ->get($this->tbl_register_master)->result_array();
          }
          return $setc;
     }

     public function readVehicleRegq($id = '', $limit = 0, $page = 0, $filter = array()) {
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                          ->get($this->tbl_users)->row()->usr_id);

          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
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
               if (!check_permission('registration', 'showallregisters')) {
                    $this->db->where(array('vreg_assigned_to' => $this->uid));
               }
               if (check_permission('registration', 'registrationcreatedbyme')) {
                    $this->db->where(array('vreg_added_by' => $this->uid));
               }
               if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                    array_push($mystaffs, $this->uid);
                    $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                            $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
               }
          }

          if (!empty($filter)) {
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
          }
          if ($this->usr_grp == 'SE' || $this->usr_grp == 'EV' || $this->usr_grp == 'TL') {
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
          //$this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          if (($this->uid != ADMIN_ID) && empty($search)) {
               if (!check_permission('registration', 'showallregisters')) {
                    $this->db->where(array('vreg_assigned_to' => $this->uid));
               }
               if (check_permission('registration', 'registrationcreatedbyme')) {
                    $this->db->where(array('vreg_added_by' => $this->uid));
               }
               if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                    array_push($mystaffs, $this->uid);
                    $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                            $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
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
          $this->db->order_by('vreg_entry_date', 'DESC');
          $this->db->where('(' . $this->tbl_enquiry . '.enq_current_status NOT IN (' . $enqExclude . ') OR ' . $this->tbl_enquiry . '.enq_current_status IS NULL)');
          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          if (isset($filter['hhpwc']) && !empty($filter['hhpwc'])) {
               $this->db->where($this->tbl_register_master . '.vreg_customer_status', $filter['hhpwc']);
          }
          $return['data'] = $this->db->get($this->tbl_register_master)->result_array();
          if ($this->uid == '32') {
               //echo $this->db->last_query();
               //debug($return['data']);
          }
          return $return;
     }

     function registerfollowup_ajax($postDatas) {

          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'vreg_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          //Count

          if (check_permission('notification', 'myregallfollwup')) {
               $this->db->where('(' . $this->tbl_register_master . '.vreg_status = 0 OR ' . $this->tbl_register_master . '.vreg_status = 1)');
               $totalRecords = $this->db->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                       ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                       ->count_all_results($this->tbl_register_master);

               if ($searchValue != '') {
                    $this->db->where("(vreg_cust_name LIKE '%" . $searchValue . "%' OR vreg_cust_phone LIKE '%" . $searchValue . "%')");
               }
               $this->db->where('(' . $this->tbl_register_master . '.vreg_status = 0 OR ' . $this->tbl_register_master . '.vreg_status = 1)');
               $totalRecordwithFilter = $this->db->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                       ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                       ->count_all_results($this->tbl_register_master);
          } else if (check_permission('notification', 'myregfollwup')) {
               $this->db->where('(' . $this->tbl_register_master . '.vreg_status = 0 OR ' . $this->tbl_register_master . '.vreg_status = 1)');
               $totalRecords = $this->db->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->where($this->tbl_register_master . '.vreg_assigned_to', $this->uid)->count_all_results($this->tbl_register_master);

               $this->db->where('(' . $this->tbl_register_master . '.vreg_status = 0 OR ' . $this->tbl_register_master . '.vreg_status = 1)');
               if ($searchValue != '') {
                    $this->db->where("(vreg_cust_name LIKE '%" . $searchValue . "%' OR vreg_cust_phone LIKE '%" . $searchValue . "%')");
               }
               $totalRecordwithFilter = $this->db->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->where($this->tbl_register_master . '.vreg_assigned_to', $this->uid)->count_all_results($this->tbl_register_master);
          } else if (check_permission('notification', 'mystaffregfollwup')) {
               $this->db->where('(' . $this->tbl_register_master . '.vreg_status = 0 OR ' . $this->tbl_register_master . '.vreg_status = 1)');
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $this->uid);
               $totalRecords = $this->db->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->where_in($this->tbl_register_master . '.vreg_assigned_to', $mystaffs)->count_all_results($this->tbl_register_master);

               $this->db->where('(' . $this->tbl_register_master . '.vreg_status = 0 OR ' . $this->tbl_register_master . '.vreg_status = 1)');
               if ($searchValue != '') {
                    $this->db->where("(vreg_cust_name LIKE '%" . $searchValue . "%' OR vreg_cust_phone LIKE '%" . $searchValue . "%')");
               }
               $totalRecordwithFilter = $this->db->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->where_in($this->tbl_register_master . '.vreg_assigned_to', $mystaffs)->count_all_results($this->tbl_register_master);
          } else if (check_permission('notification', 'myshowroomregfollwup')) {
               $totalRecords = $this->db->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->where($this->tbl_register_master . '.vreg_showroom', $this->shrm)->count_all_results($this->tbl_register_master);

               $this->db->where('(' . $this->tbl_register_master . '.vreg_status = 0 OR ' . $this->tbl_register_master . '.vreg_status = 1)');
               if ($searchValue != '') {
                    $this->db->where("(vreg_cust_name LIKE '%" . $searchValue . "%' OR vreg_cust_phone LIKE '%" . $searchValue . "%')");
               }
               $totalRecordwithFilter = $this->db->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->where($this->tbl_register_master . '.vreg_showroom', $this->shrm)->count_all_results($this->tbl_register_master);
          }
          //Data

          $this->db->where('(' . $this->tbl_register_master . '.vreg_status = 0 OR ' . $this->tbl_register_master . '.vreg_status = 1)');
          if ($searchValue != '') {
               $this->db->where("(vreg_cust_name LIKE '%" . $searchValue . "%' OR vreg_cust_phone LIKE '%" . $searchValue . "%')");
          }

          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $this->db->limit($rowperpage, $row);
          if (check_permission('notification', 'myregallfollwup')) {
               $data = $this->db->select($this->tbl_register_master . '.vreg_cust_phone, ' . $this->tbl_register_master . '.vreg_cust_name,' .
                                       $this->tbl_register_master . '.vreg_next_followup, ' . 'TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' .
                                       $this->tbl_register_master . '.vreg_next_followup ' . ') AS dateDiff, ' . $this->tbl_register_master . '.vreg_id, ' .
                                       $this->tbl_users . '.usr_first_name', false)
                               ->join($this->tbl_users, $this->tbl_register_master . '.vreg_added_by = ' . $this->tbl_users . '.usr_id', 'LEFT')
                               ->where($this->tbl_register_master . '.vreg_is_punched', 0)
                               ->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->get($this->tbl_register_master)->result_array();
          } else if (check_permission('notification', 'myregfollwup')) {

               $data = $this->db->select($this->tbl_register_master . '.vreg_cust_phone, ' . $this->tbl_register_master . '.vreg_cust_name,' .
                                       $this->tbl_register_master . '.vreg_next_followup, ' . 'TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' .
                                       $this->tbl_register_master . '.vreg_next_followup ' . ') AS dateDiff, ' . $this->tbl_register_master . '.vreg_id, ' .
                                       $this->tbl_users . '.usr_first_name', false)
                               ->join($this->tbl_users, $this->tbl_register_master . '.vreg_added_by = ' . $this->tbl_users . '.usr_id', 'LEFT')
                               ->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->where($this->tbl_register_master . '.vreg_assigned_to', $this->uid)->get($this->tbl_register_master)->result_array();
          } else if (check_permission('notification', 'mystaffregfollwup')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               array_push($mystaffs, $this->uid);

               $data = $this->db->select($this->tbl_register_master . '.vreg_cust_phone, ' . $this->tbl_register_master . '.vreg_cust_name,' .
                                       $this->tbl_register_master . '.vreg_next_followup, ' . 'TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' .
                                       $this->tbl_register_master . '.vreg_next_followup ' . ') AS dateDiff, ' . $this->tbl_register_master . '.vreg_id,' .
                                       $this->tbl_users . '.usr_first_name', false)
                               ->join($this->tbl_users, $this->tbl_register_master . '.vreg_added_by = ' . $this->tbl_users . '.usr_id', 'LEFT')
                               ->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->where_in($this->tbl_register_master . '.vreg_assigned_to', $mystaffs)->get($this->tbl_register_master)->result_array();
          } else if (check_permission('notification', 'myshowroomregfollwup')) {

               $data = $this->db->select($this->tbl_register_master . '.vreg_cust_phone, ' . $this->tbl_register_master . '.vreg_cust_name,' .
                                       $this->tbl_register_master . '.vreg_next_followup, ' . 'TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' .
                                       $this->tbl_register_master . '.vreg_next_followup ' . ') AS dateDiff, ' . $this->tbl_register_master . '.vreg_id,' .
                                       $this->tbl_users . '.usr_first_name', false)
                               ->join($this->tbl_users, $this->tbl_register_master . '.vreg_added_by = ' . $this->tbl_users . '.usr_id', 'LEFT')
                               ->where($this->tbl_register_master . '.vreg_is_punched', 0)->where($this->tbl_register_master . '.vreg_next_followup IS NOT NULL')
                               ->where('(TIMESTAMPDIFF(MINUTE, ' . '"' . date('Y-m-d H:i') . '", ' . $this->tbl_register_master . '.vreg_next_followup ' . ')) <= 0')
                               ->where($this->tbl_register_master . '.vreg_showroom', $this->shrm)->get($this->tbl_register_master)->result_array();
          }

          ## Response
          $response = array(
              "draw" => intval($draw),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecordwithFilter,
              "aaData" => $data
          );
          return $response;
     }

     function telesalesCoordinator() {
          return $this->db->select('usr_id, usr_username')->get_where($this->tbl_users, array('usr_designation_new' => 43))->result_array();
     }

     function readVehicleRegDetails($id) {
          $selectArray = array(
              $this->tbl_register_master . '.*',
              'assign.usr_first_name AS assign_usr_first_name',
              'assign.usr_last_name AS assign_usr_last_name',
              'addedby.usr_first_name AS addedby_usr_first_name',
              'addedby.usr_last_name AS addedby_usr_last_name',
              'owner.usr_first_name AS ownedby_usr_first_name',
              'owner.usr_last_name AS ownedby_usr_last_name',
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
                  ->join($this->tbl_users . ' owner', 'owner.usr_id = ' . $this->tbl_register_master . '.vreg_first_owner', 'LEFT')
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
     }

     function getLastDroppedHistory($regId) {
          return $this->db->order_by('regh_id', 'DESC')->limit(1)->get_where($this->tbl_register_history,
                          array('regh_register_master' => $regId, 'regh_status' => reg_droped))->row_array();
     }

     function reopen($datas) {
          if (!empty($datas)) {
               $datas['regh_added_date'] = date('Y-m-d H:i:s');
               $datas['regh_added_by'] = $this->uid;
               $datas['regh_system_cmd'] = "Quick register re-open by " . $this->session->userdata('usr_username');
               //Update register master
               $this->db->where('vreg_id', $datas['regh_register_master'])->update($this->tbl_register_master, array('vreg_status' => 0));
               //Update register history
               $this->db->insert($this->tbl_register_history, $datas);
          }
     }

     function bindAllRdStaffs() {
          //fetch All RD staffs For Referance 
          if (check_permission('registration', 'canselfassignregister')) {//usr_phone
               $this->db->where('usr_id != ', $this->uid);
          }
          $salesStaff = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' . $this->tbl_users . '.usr_phone AS satff_phone, '
                                  . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active')
                          ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                          ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                          //->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
                          ->where(array($this->tbl_users . '.usr_active' => 1))
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                          ->get($this->tbl_users)->result_array();

          // if (check_permission('registration', 'canselfassignregister')) {
          $myself = $this->db->select($this->tbl_users . ".usr_id AS col_id, 'Self' AS col_title, " . $this->tbl_users . '.usr_phone AS satff_phone, ' .
                                  $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active', false)
                          ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                          ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                          ->where(array($this->tbl_users . '.usr_id' => $this->uid))->get($this->tbl_users)->result_array();

          array_splice($salesStaff, 0, 0, $myself); //Insert new item in array on any position;
          //  }
          //   debug($salesStaff);
          return $salesStaff;
     }

     public function getRegisterByStaff($currenStaff) {
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
          $data = $this->db->join('cpnl_enquiry', 'cpnl_enquiry.enq_id = cpnl_register_master.vreg_inquiry', 'left')
                          ->where(array('vreg_assigned_to' => $currenStaff, 'vreg_is_punched' => 0, 'vreg_inquiry' => 0))
                          ->where_in('vreg_status', $this->myRegStatuses)
                          ->where('(cpnl_enquiry.enq_current_status NOT IN (' . $enqExclude . ') OR cpnl_enquiry.enq_current_status IS NULL)')
                          ->get('cpnl_register_master')->result_array();
          return $data;
     }

     public function updateReAssign($vreg_id, $toStaff) {
          $this->db->where('vreg_id', $vreg_id)->update('cpnl_register_master', array('vreg_assigned_to' => $toStaff, 'vreg_added_by' => $this->uid));
     }

     public function updateReAssignHistory($fr, $to, $vreg_id, $regDta, $comment) {
          $toName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' => $to))->row()->usr_username;
          $frName = $this->db->select('usr_username')->get_where('cpnl_users', array('usr_id' => $fr))->row()->usr_username;
          $narration = "All Register of sales officer " . $frName . "quickly re-assigned to " . $toName . ", due to resignation of " . $frName . ", assigned by " . $this->session->userdata('usr_username');
          $f['regData'] = $regDta;
          $f['frm_staff'] = $fr;
          $f['to_staff'] = $to;
          $f['remark'] = $comment;
          $f['created_at'] = date('Y-m-d H:i:s');
          $this->db->insert('cpnl_register_history', array(
              'regh_phone_num' => $regDta['vreg_cust_phone'],
              'regh_register_master' => $vreg_id,
              'regh_assigned_by' => $this->uid,
              'regh_assigned_to' => $to,
              'regh_added_date' => date('Y-m-d H:i:s'),
              'regh_added_by' => $this->uid,
              'regh_remarks' => $comment,
              'regh_system_cmd' => $narration
          ));
          generate_log(array(
              'log_title' => $narration,
              'log_desc' => serialize($f),
              'log_controller' => 'quick-re-assign-register-master',
              'log_action' => 'C',
              'log_ref_id' => $vreg_id,
              'log_added_by' => $this->uid
          ));
     }

     function registrationeventlistener() {
          $f = $this->db->order_by('eve_added_on', 'DESC')->get($this->tbl_event_enquires)->result_array();
          debug($f);
     }
}