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
          $this->tbl_investors_followup = TABLE_PREFIX . 'investors_followup';
          $this->tbl_event_enquires = TABLE_PREFIX . 'event_enquires';
     }

     function getWebInvestors($id) {
          $selectArray = array(
               $this->tbl_event_enquires . '.*',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_products . '.prd_id',
               'CONCAT(' . $this->tbl_products . '.prd_regno_prt_1,' . $this->tbl_products . '.prd_regno_prt_2,' .
                    $this->tbl_products . '.prd_regno_prt_3,' . $this->tbl_products . '.prd_regno_prt_4) AS eve_vehicle_selected',
               $this->tbl_users . '.usr_first_name AS assigedby',
               $this->tbl_register_master . '.vreg_id',
               $this->tbl_register_master . '.vreg_customer_remark'
          );

          if (!empty($id)) {
               $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_event_enquires . '.eve_event', 'LEFT');
               $this->db->join($this->tbl_products, $this->tbl_products . '.prd_id = ' . $this->tbl_event_enquires . '.eve_vehicle', 'LEFT');
               $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
               $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
               $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');
               $this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_event_enquires . '.eve_punched_by', 'left');
               $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_event_enquires . '.eve_register_id', 'left');
               return $this->db->select($selectArray)->order_by('eve_added_on', 'DESC')->get_where($this->tbl_event_enquires, array('eve_id' => $id))->row_array();
          }

          $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_event_enquires . '.eve_event', 'LEFT');
          $this->db->join($this->tbl_products, $this->tbl_products . '.prd_id = ' . $this->tbl_event_enquires . '.eve_vehicle', 'LEFT');
          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');
          $this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_event_enquires . '.eve_punched_by', 'left');
          $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_event_enquires . '.eve_register_id', 'left');

          if ($this->uid != 100) {
               if (check_permission('registration', 'shw_pndgtopunch_enquires')) {
                    $this->db->where('eve_register_id', 0);
               }
          }
          $this->db->where(array('eve_category' => 3));
          return $this->db->select($selectArray)->order_by('eve_added_on', 'DESC')->get($this->tbl_event_enquires)->result_array();
     }

     function getVoxBayDetails($voxBayId) {

          return $this->db->select($this->tbl_callcenterbridging . '.ccb_recording_URL,' . $this->tbl_callcenterbridging . '.ccb_callerNumber')
                          ->get_where($this->tbl_callcenterbridging, array('ccb_id' => $voxBayId))->row_array();
     }

     function getInvester($id = 0) {

          if (!empty($id)) {
               $data['master'] = $this->db->select($this->tbl_investors_master . '.*,' . $this->tbl_district_statewise . '.*')
                               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_investors_master . '.inv_dist', 'LEFT')
                               ->get_where($this->tbl_investors_master, array('inv_id' => $id))->row_array();
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
          generate_log(array(
              'log_title' => 'Create invester',
              'log_desc' => serialize($data),
              'log_controller' => 'inv-pre-insert',
              'log_action' => 'C',
              'log_ref_id' => 0,
              'log_added_by' => $this->uid
          ));

          if (isset($data['mstr']['inv_name']) && !empty($data['mstr']['inv_name'])) {
               $data['mstr']['inv_added_by'] = $this->uid;
               $data['mstr']['inv_added_on'] = date('Y-m-d H:i:s');
               $this->db->insert($this->tbl_investors_master, $data['mstr']);
               $mstrId = $this->db->insert_id();
               $this->newAddressPhoneVehicle($data, $mstrId);

               if (isset($data['voxBayId']) && !empty($data['voxBayId'])) {
                    $this->updateVoxBayAsRead($data['voxBayId'], $mstrId);
               }
               return $mstrId;
          }
          return false;
     }

     function updateVoxBayDetails($voxBayId, $investrId) {

          $voxbayDetails = $this->getVoxBayDetails($voxBayId);
          if (!empty($voxbayDetails)) {
               $custNum = isset($voxbayDetails['ccb_callerNumber']) ? $voxbayDetails['ccb_callerNumber'] :
                       substr(trim($voxbayDetails['ccb_callerNumber']), -10);

               $custNum = $this->db->select('ccb_id')->like('ccb_callerNumber', $custNum, 'both')
                               ->where('ccb_punched_by', 0)->get($this->tbl_callcenterbridging)->result_array();
               $allCalls = array_column($allCalls, 'ccb_id');

               $this->db->where_in('ccb_id', $allCalls)->update($this->tbl_callcenterbridging, array('ccb_register_ref' => $investrId,
                   'ccb_punched_by' => $this->uid));
          }
     }

     function update($data) {
          $mstrId = isset($data['inv_id']) ? $data['inv_id'] : 0;
          generate_log(array(
              'log_title' => 'Create invester',
              'log_desc' => serialize($data),
              'log_controller' => 'inv-pre-update',
              'log_action' => 'U',
              'log_ref_id' => $mstrId,
              'log_added_by' => $this->uid
          ));
          if (isset($data['inv_id']) && !empty($data['inv_id'])) {
               $masterId = $data['inv_id'];

               //Reset referral
               $this->db->where(array('inv_id' => $masterId))->update($this->tbl_investors_master, array(
                   'inv_ref_type' => 0, 'inv_ref_name' => '', 'inv_ref_cotact_no' => '',
                   'inv_ref_staff' => 0, 'inv_ref_cust_id' => 0
               ));

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
          generate_log(array(
              'log_title' => 'Create investment',
              'log_desc' => serialize($datas),
              'log_controller' => 'inv-cont-pre-insert',
              'log_action' => 'U',
              'log_ref_id' => 0,
              'log_added_by' => $this->uid
          ));

          $datas['details']['invd_entry_date'] = date('Y-m-d', strtotime($datas['details']['invd_entry_date']));
          $this->db->insert($this->tbl_investors_details, $datas['details']);

          if (isset($datas['voxbayId']) && !empty($datas['voxbayId'])) {
               $this->updateVoxBayAsRead($datas['voxbayId'], $datas['details']['invd_investor']);
          }
          return true;
     }

     function updateVoxBayAsRead($voxbayId, $investorId) {
          if (!empty($voxbayId) && !empty($investorId)) {
               //Update ccb_register_ref as investor id on voxbay call bridging
               $this->db->where('ccb_id', $voxbayId)->update($this->tbl_callcenterbridging, array('ccb_register_ref' => $investorId));
          }
     }

     function getInvestments($investerId) {
          return $this->db->select($this->tbl_investors_details . '.*,' . $this->tbl_investors_master . '.*')
                          ->join($this->tbl_investors_master, $this->tbl_investors_master . '.inv_id = ' . $this->tbl_investors_details . '.invd_investor', 'LEFT')
                          ->where($this->tbl_investors_details . '.invd_investor', $investerId)->get($this->tbl_investors_details)->result_array();
     }

     function getInvestmentFollowup($investerId) {
          return $this->db->select($this->tbl_investors_followup . '.*,' . $this->tbl_investors_master . '.*,' .
                                  $this->tbl_users . '.usr_first_name,' . $this->tbl_users . '.usr_last_name,' . $this->tbl_users . '.usr_avatar')
                          ->join($this->tbl_investors_master, $this->tbl_investors_master . '.inv_id = ' . $this->tbl_investors_followup . '.invf_investor', 'LEFT')
                          ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_investors_followup . '.invf_added_by')
                          ->where($this->tbl_investors_followup . '.invf_investor', $investerId)->get($this->tbl_investors_followup)->result_array();
     }

     function getDistricts($id = '') {
          if ($id) {
               return $this->db->where_in($this->tbl_district_statewise . '.std_state', $id)->get($this->tbl_district_statewise)->result_array();
          }
          return $this->db->get($this->tbl_district_statewise)->result_array();
     }

     public function delete($id) {
          $mstr = $this->db->get_where($this->tbl_investors_master, array('inv_id' => $id))->row_array();
          generate_log(array(
              'log_title' => 'Delete all',
              'log_desc' => serialize($mstr),
              'log_controller' => 'inv-delete-all',
              'log_action' => 'U',
              'log_ref_id' => $id,
              'log_added_by' => $this->uid
          ));
          $this->db->delete($this->tbl_investors_master, array('inv_id' => $id));
          $this->db->delete($this->tbl_investors_phone, array('invp_master' => $id));
          $this->db->delete($this->tbl_investors_proof, array('invpf_master' => $id));
          $this->db->delete($this->tbl_investors_vehicle, array('invv_master' => $id));
          $this->db->delete($this->tbl_investors_invested_company, array('invic_master' => $id));
          $this->db->delete($this->tbl_investors_details, array('invd_investor' => $id));
          return true;
     }

     function updateFollowup($data, $investId) {
          generate_log(array(
              'log_title' => 'Update follup',
              'log_desc' => serialize($data),
              'log_controller' => 'inv-update-follup',
              'log_action' => 'U',
              'log_ref_id' => $investId,
              'log_added_by' => $this->uid
          ));
          if (!empty($data) && !empty($investId)) {
               $this->db->insert($this->tbl_investors_followup,
                       array('invf_investor' => $investId, 'invf_comment' => $data['vdh_cmd'],
                           'invf_added_by' => $this->uid, 'invf_added_on' => date('Y-m-d H:i:s')));
               $folId = $this->db->insert_id();
               return $this->db->select($this->tbl_investors_followup . '.*,' . $this->tbl_investors_master . '.*,' .
                                       $this->tbl_users . '.usr_first_name,' . $this->tbl_users . '.usr_last_name,' . $this->tbl_users . '.usr_avatar')
                               ->join($this->tbl_investors_master, $this->tbl_investors_master . '.inv_id = ' . $this->tbl_investors_followup . '.invf_investor', 'LEFT')
                               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_investors_followup . '.invf_added_by')
                               ->where($this->tbl_investors_followup . '.invf_id', $folId)->get($this->tbl_investors_followup)->row_array();
          }
     }

     function bindAllRdStaffs() {
          //fetch All RD staffs For Referance 
          if (check_permission('registration', 'canselfassignregister')) {//usr_phone
               $this->db->where('usr_id != ', $this->uid);
          }
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' . $this->tbl_users . '.usr_phone AS satff_phone, '
                                  . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active')
                          ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                          ->where(array($this->tbl_users . '.usr_active' => 1))->get($this->tbl_users)->result_array();
     }

     public function getAllCalls($postDatas) {

          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          ## Search 

          $this->db->where('ccb_can_show', 1)->where('ccb_category', 2);
          //$this->db->where('ccb_callStatus_id > 0');
          $totalRecords = $this->db->count_all_results($this->tbl_callcenterbridging);

          if ($searchValue != '') {
               $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                       . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }
          $this->db->where('ccb_can_show', 1)->where('ccb_category', 2);
          //$this->db->where('ccb_callStatus_id > 0');
          
          $totalRecordwithFilter = $this->db->count_all_results($this->tbl_callcenterbridging);

          if (!empty($searchValue)) {
               $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                       . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $this->db->limit($rowperpage, $row);
          $this->db->select(array(
              $this->tbl_callcenterbridging . '.ccb_id',
              "CONCAT('http://45.249.170.209:8080/content/incomingrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
              $this->tbl_callcenterbridging . '.ccb_callStatus',
              $this->tbl_callcenterbridging . '.ccb_calledNumber',
              $this->tbl_callcenterbridging . '.ccb_callerNumber',
              $this->tbl_callcenterbridging . '.ccb_AgentNumber',
              $this->tbl_callcenterbridging . '.ccb_authorized_person',
              "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_added_on, "%M %d %Y %h %i") AS ccb_added_on',
          ));
          $this->db->where('ccb_can_show', 1)->where('ccb_category', 2);
          $data = $this->db->get($this->tbl_callcenterbridging)->result_array();
          ## Response
          $response = array(
              "draw" => intval($draw),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecordwithFilter,
              "aaData" => $data
          );
          return $response;
     }

     function getEnquiryByMobile($phoneNo) {
          if (!empty($phoneNo)) {
               $cusMobile = substr(trim($phoneNo), -10);
               return $this->db->select($this->tbl_enquiry . '.enq_cus_name,' . $this->tbl_enquiry . '.enq_id,' . $this->tbl_users . '.*')
                               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                               ->like('enq_cus_mobile', $cusMobile, 'both')->get($this->tbl_enquiry)->row_array();
          }
          return false;
     }

}
