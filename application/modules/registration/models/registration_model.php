<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class registration_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          date_default_timezone_set("Asia/Calcutta");
          //$this->db->query("SET time_zone = '+05:30'");

          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_products = TABLE_PREFIX_RANA . 'products';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_event_enquires = TABLE_PREFIX . 'event_enquires';
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
          $this->tbl_event_enquires_referals = TABLE_PREFIX . 'event_enquires_referals';
          $this->tbl_state = TABLE_PREFIX . 'states';
          $this->tbl_district = TABLE_PREFIX . 'district_statewise';
          $this->tbl_contact_mode = TABLE_PREFIX . 'contact_mode';
          $this->tbl_customer_details = TABLE_PREFIX . 'customer_details';
          $this->tbl_customer_phones = TABLE_PREFIX . 'customer_phones';
     }

     function getDistricts()
     {
          return $this->db->get($this->tbl_district_statewise)->result_array();
     }

     function alreadyEnteredToday($mob)
     {
          if (!empty($mob)) {
               $cusMobile = substr($mob, -10);
               return $this->db->select($this->tbl_register_master . '.vreg_first_owner, ' . $this->tbl_register_master . '.vreg_assigned_to, ' .
                    $this->tbl_register_master . '.vreg_last_action, ' . $this->tbl_users . '.usr_username AS assignBy,' . $this->tbl_users . '.usr_id AS assignById ,'
                    . 'assignedTo.usr_username assignTo, assignedTo.usr_id AS assignToId')
                    //                                 ->where(array('DATE(vreg_added_on)' => date('Y-m-d')))
                    ->join($this->tbl_users, $this->tbl_register_master . '.vreg_added_by = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->join($this->tbl_users . ' assignedTo', 'assignedTo.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                    ->like('vreg_cust_phone', $cusMobile, 'before')->get($this->tbl_register_master)->row_array();
          }
     }

     public function readVehicleReg($id = '', $filter = array())
     {
          $search = isset($filter['search']) ? $filter['search'] : '';
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
               ->get($this->tbl_users)->row()->usr_id);

          $selectArray = array(
               $this->tbl_register_master . '.*',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               'ownedby.usr_first_name AS ownedby_usr_first_name',
               'ownedby.usr_last_name AS ownedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_departments . '.*',
               $this->tbl_customer_details . '.cusd_id',
               $this->tbl_customer_details . '.cusd_name',
               $this->tbl_customer_details . '.cusd_whatsapp',
               $this->tbl_customer_details . '.cusd_place',
          );
          $this->db->select(array_merge($selectArray, [
               "GROUP_CONCAT(DISTINCT " . $this->tbl_customer_phones . ".cup_phone SEPARATOR ', ') AS phone_numbers"
          ]));
         $this->db->from($this->tbl_register_master)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_users . ' ownedby', 'ownedby.usr_id = ' . $this->tbl_register_master . '.vreg_first_owner', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left');
               $this->db->join($this->tbl_customer_details, $this->tbl_customer_details . '.cusd_id = ' . $this->tbl_register_master . '.vreg_cust_id', 'LEFT');
              $this->db->join($this->tbl_customer_phones, $this->tbl_customer_phones . '.cup_customer_id = ' . $this->tbl_customer_details . '.cusd_id', 'LEFT');

          if (!empty($id)) {
               //return $this->db->get_where($this->tbl_register_master, array($this->tbl_register_master . '.vreg_id' => $id))->row_array();
               $this->db->where($this->tbl_register_master . '.vreg_id', $id);
               $this->db->order_by($this->tbl_register_master . '.vreg_entry_date', 'DESC');
               return $this->db->get()->row_array();
          }
          if ($this->uid != ADMIN_ID) {
               if (check_permission('registration', 'registrationcreatedbyme')) {
                    $this->db->where(array('vreg_first_owner' => $this->uid));
               }
          }
          if (check_permission('enquiry', 'reassigntosalesstaff')) { //TSC athira
               $this->db->where('(vreg_added_by = ' . $this->uid . ' OR vreg_first_owner = ' . $this->uid . ')');
          } else {
               //if ($this->usr_grp == 'SE' || $this->usr_grp == 'TL') {
               $this->db->where(array('vreg_first_owner' => $this->uid));
          }

          if (empty($search)) {
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
               if (empty($enq_date_from) && empty($enq_date_to)) {
                    $this->db->where('DATE(' . $this->tbl_register_master . '.vreg_added_on) = ' . "DATE('" . date('Y-m-d') . "')");
               }
               if (isset($filter['showroom']) && !empty($filter['showroom'])) {
                    $this->db->where($this->tbl_register_master . '.vreg_showroom', $filter['showroom']);
               }

               if (isset($filter['vreg_department']) && !empty($filter['vreg_department'])) {
                    $this->db->where($this->tbl_register_master . '.vreg_department', $filter['vreg_department']);
               }
               if (isset($filter['vreg_call_type']) && !empty($filter['vreg_call_type'])) {
                    $this->db->where($this->tbl_register_master . '.vreg_call_type', $filter['vreg_call_type']);
               }

               $effective = isset($filter['vreg_is_effective']) ? $filter['vreg_is_effective'] : '';
               if ($effective == '0' || $effective == '1') {
                    $this->db->where($this->tbl_register_master . '.vreg_is_effective', $effective);
               }
               $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          } else {
               // $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
               //      $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
               //      $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
               // $this->db->where($whereSearch);//old
                     if (!empty($search)) { //new
                    $whereSearch = '(' . $this->tbl_customer_details . ".cusd_name LIKE '%" . $search . "%' OR " .
                    $this->tbl_customer_details . ".cusd_place LIKE '%" . $search . "%' OR " .
                    $this->tbl_customer_phones . ".cup_phone LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }
          }
          if (isset($filter['executive']) && !empty($filter['executive'])) {
               //Register created by myself and assigned to SE
               //                 $this->db->where_in('('.$this->tbl_register_master . '.vreg_first_owner', $filter['executive']);
               $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $filter['executive']) . ') OR ' .
                    $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $filter['executive']) . '))');
          } else {
               if (!is_roo_user() && check_permission('enquiry', 'myregshowonlymyshowroom')) {
                    array_push($mystaffs, $this->uid);
                    $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
               }
          }

          //   if ($this->uid == 870) {
          //        $return = $this->db->get($this->tbl_register_master)->result_array();
          //        echo $this->db->last_query();
          //        debug($return);
          //   }
          if (isset($filter['vreg_brand']) && !empty($filter['vreg_brand'])) {
               $this->db->where($this->tbl_register_master . '.vreg_brand', $filter['vreg_brand']);
          }
          if (isset($filter['vreg_model']) && !empty($filter['vreg_model'])) {
               $this->db->where($this->tbl_register_master . '.vreg_model', $filter['vreg_model']);
          }
          if (isset($filter['vreg_varient']) && !empty($filter['vreg_varient'])) {
               $this->db->where($this->tbl_register_master . '.vreg_varient', $filter['vreg_varient']);
          }
         // return $this->db->get($this->tbl_register_master)->result_array();//old
         $this->db->group_by($this->tbl_register_master . '.vreg_id');
               $query = $this->db->get();
               return $query->result_array();
     }

     function todayAnalysis()
     {

          $analysis['leadType'] = $this->db->select('vreg_call_type, COUNT(*) as total')->group_by('vreg_call_type')
               ->where('DATE(' . $this->tbl_register_master . '.vreg_first_added_on) = ' . "DATE('" . date('Y-m-d') . "')")
               ->where($this->tbl_register_master . '.vreg_first_owner', $this->uid)
               ->order_by('total', 'desc')->get($this->tbl_register_master)->result_array();

          $analysis['assignTo'] = $this->db->select($this->tbl_register_master . '.vreg_assigned_to, COUNT(*) as total,' . $this->tbl_users . '.usr_username')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->group_by('vreg_assigned_to')
               ->where('DATE(' . $this->tbl_register_master . '.vreg_first_added_on) = ' . "DATE('" . date('Y-m-d') . "')")
               ->where($this->tbl_register_master . '.vreg_first_owner', $this->uid)
               ->order_by('total', 'desc')->get($this->tbl_register_master)->result_array();

          $analysis['contactMod'] = $this->db->select('vreg_contact_mode, COUNT(*) as total')->group_by('vreg_contact_mode')
               ->where('DATE(' . $this->tbl_register_master . '.vreg_first_added_on) = ' . "DATE('" . date('Y-m-d') . "')")
               ->where($this->tbl_register_master . '.vreg_first_owner', $this->uid)
               ->order_by('total', 'desc')->get($this->tbl_register_master)->result_array();

          return $analysis;
     }

  public function create($regMaster)
     {
          error_reporting(E_ALL);
          date_default_timezone_set("Asia/Calcutta");
          $bikeArray = array(37, 40, 41, 48, 50, 54, 55, 56, 57);
          $regMaster['vreg_brand'] = isset($regMaster['vreg_brand']) ? $regMaster['vreg_brand'] : 0;
          if (isset($regMaster['vreg_cust_phone'])) {
               $regMaster['vreg_cust_phone'] = trim($regMaster['vreg_cust_phone']);
               $regMaster['vreg_cust_phone'] = preg_replace('/[^A-Za-z0-9]/', '', $regMaster['vreg_cust_phone']);
          }

          if (in_array($regMaster['vreg_brand'], $bikeArray)) {
               $regMaster['vreg_veh_base'] = 2;
          } else if ($regMaster['vreg_brand'] == 0) {
               $regMaster['vreg_veh_base'] = 0;
          } else {
               $regMaster['vreg_veh_base'] = 1;
          }

          $regMaster['vreg_first_owner'] = $this->uid;
          $regMaster['vreg_is_effective'] = (isset($regMaster['vreg_is_effective']) && !empty($regMaster['vreg_is_effective'])) ? $regMaster['vreg_is_effective'] : 0;
          $regMaster['vreg_exchange'] = (isset($regMaster['vreg_exchange']) && !empty($regMaster['vreg_exchange'])) ? $regMaster['vreg_is_effective'] : 0;

          $regMaster['vreg_first_added_on'] = date('Y-m-d H:i:s');
          $allCalls = array();
          $evId = 0;
          if (isset($regMaster['vreg_voxbay_ref']) && !empty($regMaster['vreg_voxbay_ref'])) {

               $callerNumber = $this->db->select('ccb_callerNumber')->get_where($this->tbl_callcenterbridging, array('ccb_id' => $regMaster['vreg_voxbay_ref']))->row_array();
               $callerNumber = isset($callerNumber['ccb_callerNumber']) ? $callerNumber['ccb_callerNumber'] : 0;
               if (!empty($callerNumber)) {
                    $callerNumber = substr($callerNumber, -10);
                    $allCalls = $this->db->select('ccb_id')->like('ccb_callerNumber', $callerNumber, 'both')
                         ->where('ccb_punched_by', 0)->get($this->tbl_callcenterbridging)->result_array();
                    $allCalls = array_column($allCalls, 'ccb_id');
               }
               $punchOn = date('Y-m-d H:i:s'); //h -> H 03-12-2020 06:00 AM
               if (!empty($allCalls)) {
                    $this->db->where_in('ccb_id', $allCalls)->update($this->tbl_callcenterbridging, array(
                         'ccb_punched_by' => $this->uid,
                         'ccb_punched_on' => $punchOn,
                         'ccb_can_show' => 0
                    ));
               }
          } else if (isset($regMaster['eve_register_id']) && !empty($regMaster['eve_register_id'])) {
               $evId = $regMaster['eve_register_id'];
               unset($regMaster['eve_register_id']);
          }

          if (!isset($regMaster['vreg_assigned_to'])) {
               //Get department details
               $dept = $this->db->get_where($this->tbl_departments, array('dep_id' => $regMaster['vreg_department']))->row_array();

               $regMaster['vreg_assigned_to'] = 0;
               $regMaster['vreg_cust_name'] = isset($regMaster['vreg_cust_name']) ? trim($regMaster['vreg_cust_name']) : '';
               $regMaster['vreg_showroom'] = (isset($regMaster['vreg_showroom']) && !empty($regMaster['vreg_showroom'])) ? trim($regMaster['vreg_showroom']) : $this->shrm;
               $regMaster['vreg_added_by'] = $this->uid;
               $regMaster['vreg_added_on'] = date('Y-m-d H:i:s');
               $regMaster['vreg_entry_date'] = date('Y-m-d', strtotime($regMaster['vreg_entry_date']));
               $regMaster['vreg_is_verified'] = 1;
               $regMaster['vreg_verified_by'] = $this->uid;
               $regMaster['vreg_source_branch'] = $this->shrm;
               $cntMod = isset($regMaster['vreg_contact_mode']) ? trim($regMaster['vreg_contact_mode']) : 0;
               //
               if ($this->db->insert($this->tbl_register_master, array_filter($regMaster))) {
                    $id = $this->db->insert_id();
                    $this->addRegisterHistory(
                         array(
                              'regh_register_master' => $id,
                              'regh_assigned_by' => $this->uid,
                              'regh_assigned_to' => $regMaster['vreg_assigned_to'],
                              'regh_remarks' => $regMaster['vreg_customer_remark'],
                              'regh_system_cmd' => 'Register punched none sales department',
                              'regh_contact_mode' => $cntMod
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
                     //wrt mail fn
                    }
                    //Register id to call bridge
                    if (!empty($allCalls)) {
                         $this->db->where_in('ccb_id', $allCalls)->update($this->tbl_callcenterbridging, array('ccb_register_ref' => $id));
                    }
                    if (isset($evId) && !empty($evId)) {
                         $this->db->where_in('eve_id', $evId)->update($this->tbl_event_enquires, array('eve_register_id' => $id, 'eve_punched_by' => $this->uid, 'eve_show_all' => 1));
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
                    $inqHistory['enh_added_on'] = date('Y-m-d H:i:s'); //H:i:s added on 03-12-2020 06:00 AM
                    $inqHistory['enh_enq_id'] = $previousEnq['enq_id'];
                    $inqHistory['enh_current_sales_executive'] = $regMaster['vreg_assigned_to'];
                    $this->db->insert($this->tbl_enquiry_history, $inqHistory);
                    $historyId = $this->db->insert_id();

                    $inquiry['enq_is_already_exists'] = 1;
                    $inquiry['enq_current_status_history'] = $historyId;
                    $inquiry['enq_current_status'] = 1;
                    $this->db->where('enq_id', $previousEnq['enq_id'])->update($this->tbl_enquiry, $inquiry);
               } else {
                    $regMaster['vreg_is_verified'] = 1;
                    $regMaster['vreg_verified_by'] = $this->uid;
               }
               $oldEnqSEId = (isset($previousEnq['enq_se_id']) && !empty($previousEnq['enq_se_id'])) ? $previousEnq['enq_se_id'] : 0;
               $assignedTo = (isset($regMaster['vreg_assigned_to']) && !empty($regMaster['vreg_assigned_to'])) ? $regMaster['vreg_assigned_to'] : $this->uid;
               $regMaster['vreg_inquiry'] = (isset($previousEnq['enq_id']) && !empty($previousEnq['enq_id'])) ? $previousEnq['enq_id'] : 0;
               $regMaster['vreg_status'] = (isset($previousEnq['enq_id']) && !empty($previousEnq['enq_id'])) ? 1 : 0;
               $regMaster['vreg_showroom'] = (isset($regMaster['vreg_showroom']) && !empty($regMaster['vreg_showroom'])) ? trim($regMaster['vreg_showroom']) : $this->shrm;;
               $regMaster['vreg_added_by'] = $this->uid;
               $regMaster['vreg_added_on'] = date('Y-m-d H:i:s'); //h-> H added on 03-12-2020 06:00 AM
               $regMaster['vreg_entry_date'] = date('Y-m-d', strtotime($regMaster['vreg_entry_date']));
               $regMaster['vreg_cust_name'] = isset($regMaster['vreg_cust_name']) ? trim($regMaster['vreg_cust_name']) : '';
               //$regMaster['vreg_assigned_to'] = (empty($oldEnqSEId)) ? $assignedTo : $oldEnqSEId;
               $regMaster['vreg_source_branch'] = $this->shrm;
               $regMaster['vreg_referal_phone'] = isset($regMaster['vreg_referal_phone']) ? preg_replace("/[^0-9]/", "", $regMaster['vreg_referal_phone']) : 0;
               if ($this->db->insert($this->tbl_register_master, array_filter($regMaster))) {
                    $id = $this->db->insert_id();
                    $this->addRegisterHistory(
                         array(
                              'regh_register_master' => $id,
                              'regh_assigned_by' => $this->uid,
                              'regh_assigned_to' => $regMaster['vreg_assigned_to'],
                              'regh_remarks' => $regMaster['vreg_customer_remark'],
                              'regh_system_cmd' => 'Register punched sales department',
                              'regh_contact_mode' => isset($regMaster['vreg_contact_mode']) ? $regMaster['vreg_contact_mode'] : 0
                         )
                    );
                    generate_log(array(
                         'log_title' => 'New vehicle registration',
                         'log_desc' => serialize($regMaster),
                         'log_controller' => 'new-quick-register',
                         'log_action' => 'C',
                         'log_ref_id' => $id,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    //Register id to call bridge
                    if (!empty($allCalls)) {
                         $this->db->where_in('ccb_id', $allCalls)->update($this->tbl_callcenterbridging, array('ccb_register_ref' => $id));
                    }
                    if (isset($evId) && !empty($evId)) {
                         $this->db->where_in('eve_id', $evId)->update($this->tbl_event_enquires, array('eve_register_id' => $id, 'eve_punched_by' => $this->uid, 'eve_show_all' => 1));
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

     function reassign($datas)
     {
          date_default_timezone_set("Asia/Calcutta");
          $id = $datas['vreg_id'];
          unset($datas['vreg_id']);
          $datas['vreg_is_effective'] = (isset($datas['vreg_is_effective']) && !empty($datas['vreg_is_effective'])) ? $datas['vreg_is_effective'] : 0;
          $oldAssign = isset($datas['vreg_assigned_to_old']) ? $datas['vreg_assigned_to_old'] : 0;
          unset($datas['vreg_assigned_to_old']);
          if (!empty($oldAssign) && isset($datas['vreg_assigned_to'])) {
               if ($oldAssign != $datas['vreg_assigned_to']) { //Assigned to changed
                    $assignedBy = $this->session->userdata('usr_username');
                    $assignedTo = $this->db->select('usr_username')->get_where($this->tbl_users, array('usr_id' => $datas['vreg_assigned_to']))->row_array();
                    $assignedTo = isset($assignedTo['usr_username']) ? $assignedTo['usr_username'] : '';

                    $this->addRegisterHistory(
                         array(
                              'regh_register_master' => $id,
                              'regh_assigned_by' => $this->uid,
                              'regh_assigned_to' => $datas['vreg_assigned_to'],
                              'regh_remarks' => $datas['vreg_last_action'],
                              'regh_call_type' => $datas['vreg_call_type'],
                              'regh_system_cmd' => 'Register reassigned by ' . $assignedBy . ' to ' . $assignedTo,
                              'regh_status' => 1,
                              'regh_contact_mode' => isset($datas['vreg_contact_mode']) ? $datas['vreg_contact_mode'] : 0
                         )
                    );
                    $this->db->where(array('vreg_id' => $_POST['regMaster']))->update($this->tbl_register_master, array(
                         'vreg_last_action' => $_POST['reason'],
                         'vreg_call_type' => $_POST['call_type'],
                         'vreg_assigned_to' => $_POST['assignedTo'],
                         'vreg_added_by' => $this->uid,
                         'vreg_status' => 1
                    ));
               }
          }

          $datas['vreg_event'] = ($datas['vreg_contact_mode'] == 5) ? $datas['vreg_event'] : 0;
          $datas['vreg_entry_date'] = (isset($datas['vreg_entry_date']) && !empty($datas['vreg_entry_date'])) ?
               date('Y-m-d H:i:s', strtotime($datas['vreg_entry_date'])) : null;

          /* change 13-10-2020 */
          $datas['vreg_brand'] = isset($datas['vreg_brand']) ? $datas['vreg_brand'] : 0;
          $datas['vreg_model'] = isset($datas['vreg_model']) ? $datas['vreg_model'] : 0;
          $datas['vreg_varient'] = isset($datas['vreg_varient']) ? $datas['vreg_varient'] : 0;
          $datas['vreg_assigned_to'] = isset($datas['vreg_assigned_to']) ? $datas['vreg_assigned_to'] : 0;
          $datas['vreg_department'] = (isset($datas['vreg_department']) && !empty($datas['vreg_department'])) ? $datas['vreg_department'] : 0;
          $datas['vreg_added_by'] = $this->uid;
          /* change 13-10-2020 */

          $this->db->where('vreg_id', $id);
          if ($this->db->update($this->tbl_register_master, $datas)) {
               generate_log(array(
                    'log_title' => 'Reassigned registration',
                    'log_desc' => 'Reassigned vehicle register',
                    'log_controller' => 'reasign-reg-aftr-update',
                    'log_action' => 'U',
                    'log_ref_id' => $id,
                    'log_added_by' => get_logged_user('usr_id')
               ));
               return true;
          } else {
               return false;
          }
     }

     public function update($datas)
     {
          date_default_timezone_set("Asia/Calcutta");
          $id = $datas['vreg_id'];
          unset($datas['vreg_id']);
          $datas['vreg_is_effective'] = (isset($datas['vreg_is_effective']) && !empty($datas['vreg_is_effective'])) ? $datas['vreg_is_effective'] : 0;
          $_POST['call_type'] = (isset($_POST['call_type']) && !empty($_POST['call_type'])) ? $_POST['call_type'] : 0;
          $_POST['assignedTo'] = (isset($_POST['assignedTo']) && !empty($_POST['assignedTo'])) ? $_POST['assignedTo'] : 0;
          $oldAssign = isset($datas['vreg_assigned_to_old']) ? $datas['vreg_assigned_to_old'] : 0;
          unset($datas['vreg_assigned_to_old']);
          if (!empty($oldAssign) && isset($datas['vreg_assigned_to'])) {
               if ($oldAssign != $datas['vreg_assigned_to']) { //Assigned to changed
                    $assignedBy = $this->session->userdata('usr_username');
                    $assignedTo = $this->db->select('usr_username')->get_where($this->tbl_users, array('usr_id' => $datas['vreg_assigned_to']))->row_array();
                    $assignedTo = isset($assignedTo['usr_username']) ? $assignedTo['usr_username'] : '';

                    $this->addRegisterHistory(
                         array(
                              'regh_register_master' => $id,
                              'regh_assigned_by' => $this->uid,
                              'regh_assigned_to' => $datas['vreg_assigned_to'],
                              'regh_remarks' => $datas['vreg_customer_remark'],
                              'regh_call_type' => !empty($datas['vreg_call_type']) ? $datas['vreg_call_type'] : 0,
                              'regh_system_cmd' => 'Register reassigned by ' . $assignedBy . ' to ' . $assignedTo,
                              'regh_status' => 1,
                              'regh_contact_mode' => isset($datas['vreg_contact_mode']) ? $datas['vreg_contact_mode'] : 0
                         )
                    );
                    $this->db->where(array('vreg_id' => $_POST['regMaster']))->update($this->tbl_register_master, array_filter(array(
                         'vreg_last_action' => $_POST['reason'],
                         'vreg_call_type' => $_POST['call_type'],
                         'vreg_assigned_to' => $_POST['assignedTo'],
                         'vreg_added_by' => $this->uid,
                         'vreg_status' => 1
                    )));
               }
          }

          $datas['vreg_event'] = ($datas['vreg_contact_mode'] == 5) ? $datas['vreg_event'] : 0;
          $datas['vreg_entry_date'] = (isset($datas['vreg_entry_date']) && !empty($datas['vreg_entry_date'])) ?
               date('Y-m-d', strtotime($datas['vreg_entry_date'])) : null;

          /* change 13-10-2020 */
          $datas['vreg_brand'] = isset($datas['vreg_brand']) ? $datas['vreg_brand'] : 0;
          $datas['vreg_model'] = isset($datas['vreg_model']) ? $datas['vreg_model'] : 0;
          $datas['vreg_varient'] = isset($datas['vreg_varient']) ? $datas['vreg_varient'] : 0;
          $datas['vreg_assigned_to'] = isset($datas['vreg_assigned_to']) ? $datas['vreg_assigned_to'] : 0;
          $datas['vreg_department'] = (isset($datas['vreg_department']) && !empty($datas['vreg_department'])) ? $datas['vreg_department'] : 0;
          $datas['vreg_added_by'] = $this->uid;
          $datas['vreg_call_type'] = (isset($datas['vreg_call_type']) && !empty($datas['vreg_call_type'])) ? $datas['vreg_call_type'] : 0;
          /* change 13-10-2020 */

          $this->db->where('vreg_id', $id);
          if ($this->db->update($this->tbl_register_master, array_filter($datas))) {
               generate_log(array(
                    'log_title' => 'Updated vehicle register',
                    'log_desc' => 'Updated vehicle register',
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

     public function delete($id)
     {
          $this->db->where('vreg_id', $id);
          if ($this->db->delete($this->tbl_register_master)) {
               $this->db->where('regh_register_master', $id)->delete($this->tbl_register_history);
               generate_log(array(
                    'log_title' => 'Delete vehicle register',
                    'log_desc' => 'Deleted vehicle register',
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

     function ifAlreadyEntered($mobile)
     {
          if (!empty($mobile)) {
               $msg = '';
               $cusMobile = substr(trim($mobile), -10);

               $duplicateRegister = $this->db->select($this->tbl_register_master . '.*,' . $this->tbl_users . '.*')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                    ->like($this->tbl_register_master . '.vreg_cust_phone', $cusMobile, 'before')
                    ->get($this->tbl_register_master)->row_array();

               if (!empty($duplicateRegister)) {
                    $asignTo = $duplicateRegister['usr_first_name'] . ' ' . $duplicateRegister['usr_last_name'];
                    $msg = 'Customer already exists on register, assigned to ' . $asignTo;
               }

               $duplicateInquiry = $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                    ->like($this->tbl_enquiry . '.enq_cus_mobile', $cusMobile, 'before')->get($this->tbl_enquiry)->row_array();

               if (!empty($duplicateInquiry)) {
                    $asignTo = $duplicateInquiry['usr_first_name'] . ' ' . $duplicateInquiry['usr_last_name'];
                    $msg = $msg . ' Customer already exists on inquiry, assigned to ' . $asignTo;
               }
               if (!empty($duplicateInquiry) || !empty($duplicateRegister)) {
                    return array('status' => true, 'msg' => $msg);
               } else {
                    return array('status' => false, 'msg' => 'Does not exists');
               }
          }
          return array('status' => false, 'msg' => 'Mobile number is empty');
     }




     function getEnquiryByMobile($phoneNo)
     {
          if (!empty($phoneNo)) {
               $cusMobile = substr(trim($phoneNo), -10);
               return $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                    ->like('enq_cus_mobile', $cusMobile, 'before')->get($this->tbl_enquiry)->row_array();
          }
          return false;
     }

     function getPendingReopendInquires($id)
     {

          $select = array(
               $this->tbl_register_master . '.*',
               $this->tbl_enquiry . '.*',
               $this->tbl_users . '.*',
               $this->tbl_enquiry_history . '.*',
               'reg_by.usr_first_name AS reg_usr_first_name'
          );
          return $this->db->select($select)
               ->join($this->tbl_enquiry, $this->tbl_register_master . '.vreg_inquiry = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
               ->join($this->tbl_users . ' reg_by', 'reg_by.usr_id = ' . $this->tbl_register_master . '.vreg_first_owner', 'LEFT')
               ->join($this->tbl_enquiry_history, $this->tbl_enquiry_history . '.enh_id = ' . $this->tbl_enquiry . '.enq_current_status_history', 'LEFT')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_id = ' . $this->tbl_enquiry . '.enq_current_status', 'LEFT')
               ->where($this->tbl_register_master . '.vreg_id', $id)->get($this->tbl_register_master)->row_array();
     }

     function approvalForReschedule($data)
     {
          $alreadyverified = $this->db->get_where(
               $this->tbl_register_master,
               array('vreg_id' => $data['vreg_id'], 'vreg_is_verified' => 0)
          )->row_array();
          if (!empty($alreadyverified)) {
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
               $enqH['enh_contact_mod'] = $data['vreg_contact_mode'];

               $this->db->insert($this->tbl_enquiry_history, $enqH);
               $historyId = $this->db->insert_id();
               $modCnt = isset($alreadyverified['vreg_contact_mode']) ? $alreadyverified['vreg_contact_mode'] : 0;
               /* Push to register history */
               $this->addRegisterHistory(
                    array(
                         'regh_register_master' => $data['vreg_id'],
                         'regh_assigned_by' => $this->uid,
                         'regh_assigned_to' => $data['vreg_assigned_to'],
                         'regh_remarks' => $remarks,
                         'regh_system_cmd' => 'Register re assigned to ' . $newSEName,
                         'regh_contact_mode' => $modCnt
                    ),
                    false
               );
               /* Push to register history */

               $enquiryDetails = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $data['vreg_inquiry']))->row_array();
               $seId = isset($enquiryDetails['enq_se_id']) ? $enquiryDetails['enq_se_id'] : 0;

               $enqInsert = array(
                    'enq_se_id' => $data['vreg_assigned_to'],
                    'enq_current_status' => 1,
                    'enq_current_status_history' => $historyId,
                    'enq_showroom_id' => $showroom,
                    'enq_division' => $division,
                    'enq_mode_enq' => $data['vreg_contact_mode']
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
          } else {
               generate_log(array(
                    'log_title' => 'Old enquiry verified and rescheduled to new staff already assign',
                    'log_desc' => serialize($data),
                    'log_controller' => 'approval-for-reschedule-already-assign',
                    'log_action' => 'U',
                    'log_ref_id' => $data['vreg_inquiry'],
                    'log_added_by' => $this->uid
               ));
               return false;
          }
     }

     function getAutoAssignExecutive($showroom = 0, $division = 0)
     {
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

     function getAllStaffInSales()
     {
          if (check_permission('registration', 'assigntotsc')) {
               return $this->db->select("usr_id AS col_id, usr_username AS col_title, " . $this->tbl_showroom . ".shr_location AS shr_location", false)
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                    ->where('(usr_designation_new = 59 OR usr_designation_new = 43)')->where(array('usr_active' => 1, 'usr_resigned' => 0))
                    ->get($this->tbl_users)->result_array();
          }
          $this->db->where('usr_id != ', $this->uid);
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               ->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " .
                    $this->tbl_groups . ".grp_slug = 'TL' OR " . $this->tbl_groups . ".grp_slug = 'EV')")
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->get($this->tbl_users)->result_array();
     }

     function salesPurchaseExecutivesMyShowroom()
     {
          $this->db->where_in($this->tbl_users . '.usr_departments', array(4, 6, 7, 8));
          $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);

          if (check_permission('emp_details', 'showinnactivestaffs')) {
               $this->db->where($this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0 OR ' . $this->tbl_users . '.usr_resigned = 0');
          } else {
               $this->db->where($this->tbl_users . '.usr_active = 1 AND ' . $this->tbl_users . '.usr_resigned = 0');
          }
          $selectArray = array(
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_last_name',
               $this->tbl_users . '.usr_username',
          );
          return $this->db->select($selectArray)->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
     }

     function salesPurchaseExecutivesAllShowroom()
     {
          $this->db->where_in($this->tbl_users . '.usr_departments', array(4, 6, 7, 8));

          if (check_permission('emp_details', 'showinnactivestaffs')) {
               $this->db->where($this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0 OR ' . $this->tbl_users . '.usr_resigned = 0');
          } else {
               $this->db->where($this->tbl_users . '.usr_active = 1 AND ' . $this->tbl_users . '.usr_resigned = 0');
          }
          $selectArray = array(
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_last_name',
               $this->tbl_users . '.usr_username',
          );
          return $this->db->select($selectArray)->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
     }

     function addRegisterHistory($datas, $updateRegMstr = true)
     {
          $datas['regh_added_by'] = $this->uid;
          $datas['regh_added_date'] = date('Y-m-d H:i:s'); // changes on 16-02-2021
          $this->db->insert($this->tbl_register_history, $datas);
          if ($updateRegMstr) {
               $this->db->where('vreg_id', $datas['regh_register_master'])
                    ->update($this->tbl_register_master, array('vreg_assigned_to' => $datas['regh_assigned_to']));
          }
     }

     function getShowRoomByDivision($division)
     {
          return $this->db->get_where($this->tbl_showroom, array('shr_division' => $division, 'shr_status' => 1))->result_array();
     }

     function getDepartmentByDivision($division)
     {

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

     function getBrandModelVarientName($brd = 0, $mod = 0, $var = 0)
     {
          $return = array();
          if ($brd) {
               $return['brandName'] = $this->db->select('brd_title')->get_where($this->tbl_brand, array('brd_id' => $brd))->row_array();
          }
          if ($mod) {
               $return['modelName'] = $this->db->select('mod_title')->get_where($this->tbl_model, array('mod_id' => $mod))->row_array();
          }
          if ($var) {
               $return['varientName'] = $this->db->select('var_variant_name')->get_where($this->tbl_variant, array('var_id' => $mod))->row_array();
          }
          return $return;
     }

     function reqToDropRegister($data)
     {
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

     public function registerbystatus($id = '', $filter = array(), $limit, $page)
     {
          $mystaffs = array();
          if (check_permission('registration', 'showmystaffreqfordrop')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id);
          }
          $selectArray = array(
               $this->tbl_register_master . '.*',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
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

          if (!empty($id)) {
               return $this->db->get_where($this->tbl_register_master, array($this->tbl_register_master . '.vreg_id' => $id))->row_array();
          }

          /*Count*/
          if (!empty($filter)) {
               if (isset($filter['search']) && !empty($filter['search'])) {
                    $search = trim($filter['search']);
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }
          }

          if (check_permission('registration', 'showallreqfordrop') || is_roo_user()) {
          } else if (check_permission('registration', 'showmyreqfordrop')) {
               $this->db->where('(vreg_first_owner = ' . $this->uid . ' OR vreg_assigned_to = ' . $this->uid . ')');
          } else if (check_permission('registration', 'showmystaffreqfordrop')) {
               $this->db->where_in(array('vreg_first_owner' => $mystaffs));
          } else if (check_permission('registration', 'showmyshowroomreqfordrop')) {
               $this->db->where(array('vreg_showroom' => $this->shrm));
          } else if (check_permission('registration', 'showdroppedbyme')) {
               $this->db->where('(vreg_first_owner = ' . $this->uid . ' OR vreg_assigned_to = ' . $this->uid . ')');
          } else if (check_permission('registration', 'showlxdivisionreqfordrop')) { //Luxury
               $this->db->where('assign.usr_division = 2');
          } else if (check_permission('registration', 'showsmdivisionreqfordrop')) { //Smart
               $this->db->where('assign.usr_division = 1');
          } else if (check_permission('registration', 'showlxdivisionreqfordrop') && check_permission('registration', 'showsmdivisionreqfordrop')) {
               $this->db->where('(assign.usr_division = 1 OR assign.usr_division = 2)');
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

          $return['count'] = $this->db->count_all_results($this->tbl_register_master);

          /*Data*/
          if (!empty($filter)) {
               if (isset($filter['search']) && !empty($filter['search'])) {
                    $search = trim($filter['search']);
                    $whereSearch = '(' . $this->tbl_register_master . ".vreg_cust_name LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_phone LIKE '%" . $search . "%' OR " .
                         $this->tbl_register_master . ".vreg_cust_place LIKE '%" . $search . "%' )";
                    $this->db->where($whereSearch);
               }
          }
          if (check_permission('registration', 'showallreqfordrop') || is_roo_user()) {
          } else if (check_permission('registration', 'showmyreqfordrop')) {
               $this->db->where('(vreg_first_owner = ' . $this->uid . ' OR vreg_assigned_to = ' . $this->uid . ')');
          } else if (check_permission('registration', 'showmystaffreqfordrop')) {
               $this->db->where_in(array('vreg_first_owner' => $mystaffs));
          } else if (check_permission('registration', 'showmyshowroomreqfordrop')) {
               $this->db->where(array('vreg_showroom' => $this->shrm));
          } else if (check_permission('registration', 'showdroppedbyme')) {
               $this->db->where('(vreg_first_owner = ' . $this->uid . ' OR vreg_assigned_to = ' . $this->uid . ')');
          } else if (check_permission('registration', 'showlxdivisionreqfordrop')) { //Luxury
               $this->db->where('assign.usr_division = 2');
          } else if (check_permission('registration', 'showsmdivisionreqfordrop')) { //Smart
               $this->db->where('assign.usr_division = 1');
          } else if (check_permission('registration', 'showlxdivisionreqfordrop') && check_permission('registration', 'showsmdivisionreqfordrop')) {
               $this->db->where('(assign.usr_division = 1 OR assign.usr_division = 2)');
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
          if ($limit) {
               $this->db->limit($limit, $page);
          }
          $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' assign', 'assign.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
               ->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_register_master . '.vreg_event', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_register_master . '.vreg_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_register_master . '.vreg_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_register_master . '.vreg_varient', 'left')
               ->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_register_master . '.vreg_department', 'left');
          $return['datas'] = $this->db->get($this->tbl_register_master)->result_array();
          //echo $this->db->last_query();exit;
          return $return;
     }

     public function waitingForReply()
     {
          $selectArray = array(
               $this->tbl_register_master . '.*',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
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

     function getRelatedVehicle($brd, $mod, $vr)
     {
          $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
          $selectArray = array(
               $this->tbl_register_master . '.vreg_id',
               $this->tbl_register_master . '.vreg_is_verified',
               $this->tbl_register_master . '.vreg_status',
               'vreg_entry_date',
               'vreg_cust_name',
               'vreg_cust_phone',
               'vreg_cust_place',
               'vreg_contact_mode',
               'vreg_year',
               'vreg_investment',
               'vreg_added_on',
               'vreg_call_type',
               'vreg_customer_remark',
               'vreg_last_action',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
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


          if (!is_roo_user()) {
               if (check_permission('registration', 'stockmach_mycases')) {
                    $this->db->where(array('vreg_added_by' => $this->uid));
                    //vreg_first_owner
               } else if (check_permission('registration', 'registrationcreatedbyme')) {
                    $this->db->where(array('vreg_added_by' => $this->uid));
                    $this->db->where(array('vreg_assigned_to' => $this->uid));
               } else if (check_permission('enquiry', 'myregshowonlymyshowroom')) {
                    array_push($mystaffs, $this->uid);
                    $this->db->where('(' . $this->tbl_register_master . '.vreg_first_owner IN (' . implode(',', $mystaffs) . ') OR ' .
                         $this->tbl_register_master . '.vreg_assigned_to IN (' . implode(',', $mystaffs) . '))');
               }
          }
          $this->db->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses);
          $this->db->where($this->tbl_register_master . '.vreg_inquiry', 0);
          $this->db->where($this->tbl_register_master . '.vreg_brand', $brd);
          $this->db->order_by($this->tbl_register_master . '.vreg_added_on', 'DESC');
          $this->db->limit(15);
          return $this->db->get($this->tbl_register_master)->result_array();
     }

     function informStockToCustomer()
     {
          //Luxury
          $this->tbl_products = TABLE_PREFIX_RANA . 'products';
          $select = array(
               $this->tbl_products . '.prd_brand',
               $this->tbl_products . '.prd_model',
               $this->tbl_products . '.prd_variant',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name'
          );
          $this->db->select($select)->from($this->tbl_products);
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
          $this->db->select($select)->from($this->tbl_products);
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

     function reghistory($id)
     {
          $selectArray = array(
               $this->tbl_register_history . '.*',
               $this->tbl_register_master . '.vreg_id',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_departments . '.*'
          );

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

     function bindStaffsByShowroom($id, $dpt = 0)
     {
          $assigns = array();
          //D - 4 - Sls smart
          //D - 7 - Pur smart
          //D - 6 - Sls Lux
          //D - 8 - Pur Lux
          //$assigns[] = 'usr_id = ' . 641; //Reshma
          //$assigns[] = 'usr_id = ' . 670; //Deepa
          if ($this->uid != 100) {
               if (check_permission('registration', 'assigntotsc')) { // Can assign to telesales coordinator
                    if ($dpt == 4 || $dpt == 7) { // Smart sls & pur
                         $assigns[] = 'usr_designation_new = ' . 59; //Purchase coordinator
                         $assigns[] = 'usr_designation_new = ' . 43; //Sales coordinator
                         $assigns[] = 'usr_designation_new = ' . 9; //MIS
                         $assigns[] = 'usr_designation_new = ' . 89; //Sales & Purchase Admin Smart
                    } else if ($dpt == 6 || $dpt == 8) { // Luxury sls & pur
                         $assigns[] = 'usr_designation_new = ' . 59; //Purchase coordinator
                         $assigns[] = 'usr_designation_new = ' . 43; //Sales coordinator
                         $assigns[] = 'usr_designation_new = ' . 100; //Area sales manager
                    }
               } else { // Can assign to sales staff
                    if ($dpt == 4 || $dpt == 6) {
                         if ($dpt == 4) {
                              $assigns[] = 'usr_designation_new = ' . 89; //Sales & Purchase Admin Smart
                         }
                         $assigns[] = 'usr_designation_new = ' . 12; //Sr. Sales Consultant
                         $assigns[] = 'usr_designation_new = ' . 18; //Sales Consultant
                         $assigns[] = 'usr_designation_new = ' . 43; //Sales coordinator
                         $assigns[] = 'usr_designation_new = ' . 11; //Area Manager - Sales
                         $assigns[] = 'usr_designation_new = ' . 79; //Territory Sales Manager
                         $assigns[] = 'usr_designation_new = ' . 82; //Deputy Sales Manager
                         $assigns[] = 'usr_designation_new = ' . 83; //Regional Sales Manager
                         $assigns[] = 'usr_designation_new = ' . 6; //ASM (amendment for vasil)
                         $assigns[] = 'usr_designation_new = ' . 100; //Area Sales Manager
                    } else {
                         $assigns[] = 'usr_designation_new = ' . 22; //Purchase Manager
                         $assigns[] = 'usr_designation_new = ' . 23; //Senior Evaluator
                         $assigns[] = 'usr_designation_new = ' . 24; //Assistant Manager Purchase
                         $assigns[] = 'usr_designation_new = ' . 35; //Purchase Executive
                         $assigns[] = 'usr_designation_new = ' . 40; //Area Manager - Purchase
                         $assigns[] = 'usr_designation_new = ' . 60; //Manager - Sales & Purchase Luxury Bikes
                         $assigns[] = 'usr_designation_new = ' . 64; //Evaluator Sourcer
                         $assigns[] = 'usr_designation_new = ' . 59; //Purchase coordinator
                         $assigns[] = 'usr_designation_new = ' . 69; //Sr. Purchase Executive
                    }
               }
               if (check_permission('registration', 'canpunchtoasm')) { // Can assign to ASM too
                    $assigns[] = 'usr_designation_new = ' . 6;
               }
               if (check_permission('registration', 'canpunchtosm')) { // Can assign to SM too
                    $assigns[] = 'usr_designation_new = ' . 25;
               }

               if (check_permission('registration', 'deptwiseregister')) {
                    $this->db->where('usr_departments', $dpt);
               }
          }

          if (!empty($assigns)) {
               $return = $this->db->select("usr_id AS col_id, usr_username AS col_title, " . $this->tbl_showroom . ".shr_location AS shr_location", false)
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                    ->where('(' . implode($assigns, ' OR ') . ')')->where(array('usr_active' => 1, 'usr_resigned' => 0, 'usr_showroom' => $id))
                    ->order_by('usr_username', 'ASC')->get($this->tbl_users)->result_array();
               //echo $this->db->last_query();
               $myself = array();
               if (check_permission('registration', 'canselfassignregister')) {
                    $assigns[] = 'usr_id = ' . $this->uid;
                    $myself = $this->db->select("usr_id AS col_id, usr_username AS col_title, " . $this->tbl_showroom . ".shr_location AS shr_location", false)
                         ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                         ->where('usr_id = ', $this->uid)->order_by('usr_username', 'ASC')->get($this->tbl_users)->result_array();
               }
               array_splice($return, 0, 0, $myself);
               return $return;
          }

          if ($this->uid != 100) {
               //fetch staffs by showroom
               if (check_permission('registration', 'canselfassignregister')) {
                    $this->db->where('usr_id != ', $this->uid);
               }
               if ($dpt != 8) {
                    $this->db->where($this->tbl_showroom . '.shr_id', $id);
               }
          }
          $salesStaff = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               //->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1))
               //->or_where($this->tbl_users . '.usr_id', 968) // , $this->tbl_users . '.usr_showroom' => $id)
               ///->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0, $this->tbl_users . '.usr_can_auto_assign' => 1))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->order_by('usr_username', 'ASC')->get($this->tbl_users)->result_array();

          if (check_permission('registration', 'canselfassignregister') && ($this->uid != 100)) {
               $myself = $this->db->select($this->tbl_users . ".usr_id AS col_id, 'Self' AS col_title, " .
                    $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active', false)
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                    ->where(array($this->tbl_users . '.usr_active' => 1)) //newly added
                    ->order_by('usr_username', 'ASC')->where(array($this->tbl_users . '.usr_id' => $this->uid))->get($this->tbl_users)->result_array();
               array_splice($salesStaff, 0, 0, $myself);
          }
          //echo $this->db->last_query();
          //debug($salesStaff);
          return $salesStaff;
     }
     function bindStaffsByShowroom_test($id)
     { //for testing purpose 

          if (check_permission('registration', 'assigntotsc') && ($this->uid != 100)) {
               debug(111);
               return $this->db->select("usr_id AS col_id, usr_username AS col_title, " . $this->tbl_showroom . ".shr_location AS shr_location", false)
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                    ->where('(usr_designation_new = 59 OR usr_designation_new = 43 OR usr_id = 641)')->where(array('usr_active' => 1, 'usr_resigned' => 0, 'usr_showroom' => $id))
                    ->order_by('usr_username', 'ASC')->get($this->tbl_users)->result_array();
          }

          //fetch staffs by showroom
          if (check_permission('registration', 'canselfassignregister') && ($this->uid != 100)) {
               //debug(222);
               $this->db->where('usr_id != ', $this->uid);
          }
          $salesStaff = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               //->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1, $this->tbl_users . '.usr_showroom' => $id))
               ///->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0, $this->tbl_users . '.usr_can_auto_assign' => 1))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->order_by('usr_username', 'ASC')->get($this->tbl_users)->result_array();

          if (check_permission('registration', 'canselfassignregister') && ($this->uid != 100)) {
               // debug(33);
               $myself = $this->db->select($this->tbl_users . ".usr_id AS col_id, 'Self' AS col_title, " .
                    $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active', false)
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                    ->where(array($this->tbl_users . '.usr_active' => 1)) //newly added
                    ->order_by('usr_username', 'ASC')->where(array($this->tbl_users . '.usr_id' => $this->uid))->get($this->tbl_users)->result_array();
               array_splice($salesStaff, 0, 0, $myself);
          }
          return $salesStaff;
     }
     function bindStaffsByShowroomBK($id)
     {

          if (check_permission('registration', 'assigntotsc')) {
               return $this->db->select("usr_id AS col_id, usr_username AS col_title, " . $this->tbl_showroom . ".shr_location AS shr_location", false)
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                    ->where('(usr_designation_new = 59 OR usr_designation_new = 43 OR usr_id = 641)')->where(array('usr_active' => 1, 'usr_resigned' => 0))
                    ->order_by('usr_username', 'ASC')->get($this->tbl_users)->result_array();
          }

          //fetch staffs by showroom
          if (check_permission('registration', 'canselfassignregister')) {
               $this->db->where('usr_id != ', $this->uid);
          }
          $salesStaff = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               //->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
               //->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1, $this->tbl_users . '.usr_showroom' => $id))
               ->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0, $this->tbl_users . '.usr_can_auto_assign' => 1))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->order_by('usr_username', 'ASC')->get($this->tbl_users)->result_array();

          if (check_permission('registration', 'canselfassignregister')) {
               $myself = $this->db->select($this->tbl_users . ".usr_id AS col_id, 'Self' AS col_title, " .
                    $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active', false)
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                    ->order_by('usr_username', 'ASC')->where(array($this->tbl_users . '.usr_id' => $this->uid))->get($this->tbl_users)->result_array();
               array_splice($salesStaff, 0, 0, $myself);
          }
          return $salesStaff;
     }

     function reassignedregisters($id = 0)
     {
          $enqExclude = loss_of_sale_or_buy . ',' . sale_closed . ',' . enq_req_drop;
          if (!empty($id)) {
               $selectArray = array(
                    $this->tbl_register_master . '.*',
                    'assign.usr_first_name AS assign_usr_first_name',
                    'assign.usr_last_name AS assign_usr_last_name',
                    'addedby.usr_first_name AS addedby_usr_first_name',
                    'addedby.usr_last_name AS addedby_usr_last_name',
                    $this->tbl_events . '.evnt_title',
                    $this->tbl_brand . '.brd_id',
                    $this->tbl_brand . '.brd_title',
                    $this->tbl_model . '.mod_id',
                    $this->tbl_model . '.mod_title',
                    $this->tbl_variant . '.var_id',
                    $this->tbl_variant . '.var_variant_name',
                    $this->tbl_enquiry . '.enq_current_status',
                    $this->tbl_callcenterbridging . '.ccb_recording_URL',
                    $this->tbl_callcenterbridging . '.ccb_callStatus_id',
                    $this->tbl_departments . '.dep_name',
                    $this->tbl_district_statewise . '.*'
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

     function telesalesCoordinator()
     {
          return $this->db->select('usr_id, usr_username')->get_where($this->tbl_users, array('usr_designation_new' => 43))->result_array();
     }

     function readVehicleRegDetails($id)
     {
          $selectArray = array(
               $this->tbl_register_master . '.*',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               'owner.usr_first_name AS ownedby_usr_first_name',
               'owner.usr_last_name AS ownedby_usr_last_name',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_enquiry . '.enq_current_status',
               $this->tbl_callcenterbridging . '.ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus_id',
               $this->tbl_departments . '.dep_name',
               $this->tbl_district_statewise . '.*'
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

     function getLastDroppedHistory($regId)
     {
          return $this->db->order_by('regh_id', 'DESC')->limit(1)->get_where(
               $this->tbl_register_history,
               array('regh_register_master' => $regId, 'regh_status' => reg_droped)
          )->row_array();
     }

     function reopen($datas)
     {
          if (!empty($datas)) {
               $datas['regh_added_date'] = date('Y-m-d H:i:s');
               $datas['regh_added_by'] = $this->uid;
               $datas['regh_system_cmd'] = "Quick register re-open by " . $this->session->userdata('usr_username');
               //Update register master
               $this->db->where('vreg_id', $datas['regh_register_master'])->update($this->tbl_register_master, array('vreg_status' => 0, 'vreg_assigned_to' => $datas['regh_assigned_to']));
               //Update register history
               $this->db->insert($this->tbl_register_history, $datas);
          }
     }
     function registerCourtesyCall($day)
     {

          $yesterday = date('Y-m-d', strtotime('-1 day'));
          $MyGivenDateIn = strtotime($yesterday);
          $ConverDate = date("l", $MyGivenDateIn);
          $ConverDateTomatch = strtolower($ConverDate);

          if ($ConverDateTomatch == "sunday") {
               $yesterday = date('Y-m-d', strtotime('-2 day'));
          } else {
               $yesterday = date('Y-m-d', strtotime('-1 day'));
          }

          $selectArray = array(
               $this->tbl_register_master . '.*',
               'assign.usr_first_name AS assign_usr_first_name',
               'assign.usr_last_name AS assign_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               'exstse.usr_username AS exstse_usr_username',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_enquiry . '.enq_current_status',
               $this->tbl_callcenterbridging . '.ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus_id',
               $this->tbl_departments . '.dep_name',
               $this->tbl_district_statewise . '.*'
          );
          return $this->db->select($selectArray, false)
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
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'left')
               //->where('DATE(' . $this->tbl_register_master . '.vreg_entry_date) = ', $yesterday)
               ->where('vreg_assigned_to', $this->uid)->where('vreg_contact_mode', 9)
               ->where_in($this->tbl_register_master . '.vreg_status', $this->myRegStatuses)
               ->where('vreg_second_d_hpy_cal IS NULL')->get($this->tbl_register_master)->result_array();
     }

     function updateRegisterCourtesyCall($data)
     {

          $this->db->where('vreg_id', $data['vreg_id'])->update($this->tbl_register_master, array('vreg_second_d_hpy_cal' => $data['vreg_second_d_hpy_cal']));
          $username = $this->session->userdata('usr_username');
          $this->db->insert($this->tbl_register_history, array(
               'regh_phone_num' => $data['vreg_cust_phone'],
               'regh_register_master' => $data['vreg_id'],
               'regh_assigned_by' => $data['vreg_added_by'],
               'regh_assigned_to' => $data['vreg_assigned_to'],
               'regh_added_date' => date('Y-m-d H:i:s'),
               'regh_added_by' => $this->uid,
               'regh_remarks' => $data['vreg_second_d_hpy_cal'],
               'regh_system_cmd' => 'Second day courtesy call by ' . $username . ' on ' . date('j M Y H:i A'),
               'regh_status' => $data['vreg_status']
          ));
     }

     function eventlistener($id = 0)
     {
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
          $this->db->where(array('eve_category' => 1, 'eve_show_all' => 1));
          $return['events'] = $this->db->select($selectArray)->order_by('eve_added_on', 'DESC')->get($this->tbl_event_enquires)->result_array();
          /*Sales Event */


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
               $this->tbl_register_master . '.vreg_customer_remark',
               $this->tbl_district . '.std_district_name',
               $this->tbl_state . '.sts_name',
               $this->tbl_departments . '.dep_name'
          );


          if (!empty($id)) {
               $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_event_enquires . '.eve_event', 'LEFT');
               $this->db->join($this->tbl_products, $this->tbl_products . '.prd_id = ' . $this->tbl_event_enquires . '.eve_vehicle', 'LEFT');
               $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
               $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
               $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');
               $this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_event_enquires . '.eve_punched_by', 'left');
               $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_event_enquires . '.eve_register_id', 'left');
               $this->db->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_event_enquires . '.eve_department', 'left');
               return $this->db->select($selectArray)->order_by('eve_added_on', 'DESC')->get_where($this->tbl_event_enquires, array('eve_id' => $id))->row_array();
          }

          $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_event_enquires . '.eve_event', 'LEFT');
          $this->db->join($this->tbl_products, $this->tbl_products . '.prd_id = ' . $this->tbl_event_enquires . '.eve_vehicle', 'LEFT');
          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');
          $this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_event_enquires . '.eve_punched_by', 'left');
          $this->db->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_event_enquires . '.eve_register_id', 'left');
          $this->db->join($this->tbl_district, "{$this->tbl_district}.std_id = {$this->tbl_event_enquires}.eve_district", 'left');
          $this->db->join($this->tbl_state, "{$this->tbl_state}.sts_id = {$this->tbl_event_enquires}.eve_state", 'left');
          $this->db->join($this->tbl_departments, $this->tbl_departments . '.dep_id = ' . $this->tbl_event_enquires . '.eve_department', 'left');

          if ($this->uid != 100) {
               if (check_permission('registration', 'shw_pndgtopunch_enquires')) {
                    $this->db->where('eve_register_id', 0);
               }
          }
          $this->db->where(array('eve_category' => 4, 'eve_show_all' => 1)); //4 for sales event
          $return['sales_events'] = $this->db->select($selectArray)->order_by('eve_added_on', 'DESC')->get($this->tbl_event_enquires)->result_array();

          /* E Sales Event*/
          /* Lucky */

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
               $this->tbl_register_master . '.vreg_customer_remark',
               $this->tbl_event_enquires_referals . '.*'
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
          $this->db->join($this->tbl_event_enquires_referals, $this->tbl_event_enquires_referals . '.eer_enq_id = ' . $this->tbl_event_enquires . '.eve_id', 'left');
          if ($this->uid != 100) {
               if (check_permission('registration', 'shw_pndgtopunch_enquires')) {
                    $this->db->where('eve_register_id', 0);
               }
          }

          $this->db->where(array('eve_category' => 2, 'eve_show_all' => 1));
          $return['lucky'] = $this->db->select($selectArray)->order_by('eve_added_on', 'DESC')->get($this->tbl_event_enquires)->result_array();
          $return['web_enq']= $this->getWebEnquiries();
          $return['veh_enq']= $this->getVehEnquiries();
          return $return;
     }

     function readEventRegister($id)
     {
          return $this->db->get_where($this->tbl_event_enquires, array('eve_id' => $id))->row_array();
     }

     function exportExcelEvent()
     {
          $selectArray = array(
               $this->tbl_event_enquires . '.*',
               $this->tbl_events . '.evnt_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_products . '.prd_id',
               'CONCAT(' . $this->tbl_products . '.prd_regno_prt_1,' . $this->tbl_products . '.prd_regno_prt_2,' .
                    $this->tbl_products . '.prd_regno_prt_3,' . $this->tbl_products . '.prd_regno_prt_4) AS eve_vehicle_selected',
               $this->tbl_users . '.usr_first_name AS assigedby'
          );

          $this->db->join($this->tbl_events, $this->tbl_events . '.evnt_id = ' . $this->tbl_event_enquires . '.eve_event', 'LEFT');
          $this->db->join($this->tbl_products, $this->tbl_products . '.prd_id = ' . $this->tbl_event_enquires . '.eve_vehicle', 'LEFT');
          $this->db->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_products . '.prd_brand', 'left');
          $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_products . '.prd_model', 'left');
          $this->db->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_products . '.prd_variant', 'left');
          $this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_event_enquires . '.eve_punched_by', 'left');

          if ($this->uid != 100) {
               if (check_permission('registration', 'shw_pndgtopunch_enquires')) {
                    $this->db->where('eve_register_id', 0);
               }
          }
          $this->db->where(array('eve_show_all' => 1));
          return $this->db->select($selectArray)->order_by('eve_added_on', 'DESC')->get($this->tbl_event_enquires)->result_array();
     }

     function changesStatus($field, $prdId, $status)
     {
          if (!empty($prdId)) {
               $update[$field] = $status;
               $this->db->where('eve_id', $prdId);
               $this->db->update($this->tbl_event_enquires, $update);
               //return $status . '-' .  $this->db->last_query();
               return true;
          } else {
               return false;
          }
     }
     function bindAllRdStaffs()
     {
          //jsk
          //fetch All RD staffs For Referance 
          if (check_permission('registration', 'canselfassignregister')) { //usr_phone
               $this->db->where('usr_id != ', $this->uid);
          }
          $salesStaff = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_username AS col_title, ' . $this->tbl_users . '.usr_phone AS satff_phone, '
               . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
               //->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
               ->where(array($this->tbl_users . '.usr_active' => 1))->order_by($this->tbl_users . '.usr_username', 'ASC')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->get($this->tbl_users)->result_array();

          // if (check_permission('registration', 'canselfassignregister')) {
          $myself = $this->db->select($this->tbl_users . ".usr_id AS col_id, 'Self' AS col_title, " . $this->tbl_users . '.usr_phone AS satff_phone, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active', false)
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_id' => $this->uid))->order_by($this->tbl_users . '.usr_username', 'ASC')->get($this->tbl_users)->result_array();

          array_splice($salesStaff, 0, 0, $myself); //Insert new item in array on any position;
          //  }
          //   debug($salesStaff);
          return $salesStaff;
     }
     function getStaffById($uid)
     {
          $RdStaff = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' . $this->tbl_users . '.usr_phone AS satff_phone')
               ->where('usr_id', $uid)
               ->get($this->tbl_users)->row_array();
          return $RdStaff;
     }

     function modeOfContact()
     {

          $this->db->select('cmd_mod_id,cmd_title');

          $res = $this->db->get($this->tbl_contact_mode)->result_array();
          return $res;
     }
     public function getWebEnquiries() {

          $this->db->select("
              {$this->tbl_event_enquires}.eve_id,
              {$this->tbl_event_enquires}.eve_name,
              {$this->tbl_event_enquires}.eve_register_id,
              {$this->tbl_event_enquires}.eve_mobile,
              {$this->tbl_event_enquires}.eve_vehicle,
              {$this->tbl_event_enquires}.eve_email,
              {$this->tbl_event_enquires}.eve_vehicle_string,
              {$this->tbl_event_enquires}.eve_added_on,
              {$this->tbl_event_enquires}.eve_assigned_to,
              {$this->tbl_users}.usr_first_name
          "); 
      
    
          $this->db->from($this->tbl_event_enquires); 
          $this->db->join($this->tbl_users, "{$this->tbl_event_enquires}.eve_assigned_to = {$this->tbl_users}.usr_id", 'left'); 
if ($this->uid != ADMIN_ID) {
     if (check_permission('productenquires', 'showwebhenquiriesassignedtome')) {//Show web enquiries assigned to me
          $this->db->where(array('eve_assigned_to' => $this->uid));
     }
}
          $this->db->where("{$this->tbl_event_enquires}.eve_event", 56); 
          $this->db->order_by("{$this->tbl_event_enquires}.eve_added_on", 'DESC'); 
                    $query = $this->db->get();

          return $query->result_array(); 
      }
      public function getVehEnquiries() {

          $this->db->select("
              {$this->tbl_event_enquires}.eve_id,
              {$this->tbl_event_enquires}.eve_name,
              {$this->tbl_event_enquires}.eve_register_id,
              {$this->tbl_event_enquires}.eve_mobile,
              {$this->tbl_event_enquires}.eve_vehicle,
              {$this->tbl_event_enquires}.eve_email,
              {$this->tbl_event_enquires}.eve_vehicle_string,
              {$this->tbl_event_enquires}.eve_added_on,
              {$this->tbl_event_enquires}.eve_assigned_to,
              {$this->tbl_users}.usr_first_name
          "); 
      
    
          $this->db->from($this->tbl_event_enquires); 
          $this->db->join($this->tbl_users, "{$this->tbl_event_enquires}.eve_assigned_to = {$this->tbl_users}.usr_id", 'left'); 
          if ($this->uid != ADMIN_ID) {
               if (check_permission('productenquires', 'showvehenquiriesassignedtome')) {//Show veh enquiries assigned to me
                    $this->db->where(array('eve_assigned_to' => $this->uid));
               }
          }
          $this->db->where("{$this->tbl_event_enquires}.eve_event", 57); 
          $this->db->order_by("{$this->tbl_event_enquires}.eve_added_on", 'DESC'); 
                    $query = $this->db->get();

          return $query->result_array(); 
      }

    //CUSTOMER
    public function check_existing_customer($phone, $email) {
        $this->db->or_where('cusd_phone', $phone);
        $this->db->or_where('cusd_email', $email);
        $query = $this->db->get('cpnl_customer_details');

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false; // No match found
        }
    }
    public function addCustomer($data) {
        $this->db->insert('cpnl_customer_details', $data);
        return $this->db->insert_id(); 
    }
    //New
    function matchingRegister($customerId)
{
  if (!empty($customerId)) {
      return $this->db->select($this->tbl_register_master . '.vreg_last_action, ' .
                                $this->tbl_register_master . '.vreg_cust_name, ' .
                                $this->tbl_register_master . '.vreg_added_on, ' .
                                $this->tbl_register_master . '.vreg_customer_remark, ' .
                                $this->tbl_register_master . '.vreg_contact_mode, ' .
                                'asto.usr_id AS assto_usr_id, asto.usr_first_name AS assto_usr_name, ' .
                                'adby.usr_id AS adby_usr_id, adby.usr_first_name AS adby_usr_name, ' .
                                'fwon.usr_id AS fwon_usr_id, fwon.usr_first_name AS fwon_usr_name, ' .
                                $this->tbl_district_statewise . '.*')
                  ->join($this->tbl_users . ' asto', 'asto.usr_id = ' . $this->tbl_register_master . '.vreg_assigned_to', 'LEFT')
                  ->join($this->tbl_users . ' adby', 'adby.usr_id = ' . $this->tbl_register_master . '.vreg_added_by', 'LEFT')
                  ->join($this->tbl_users . ' fwon', 'fwon.usr_id = ' . $this->tbl_register_master . '.vreg_first_owner', 'LEFT')
                  ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_register_master . '.vreg_district', 'LEFT')
                  ->where('vreg_cust_id', $customerId)
                  ->order_by($this->tbl_register_master . '.vreg_added_on', 'DESC')
                  ->get($this->tbl_register_master)
                  ->result_array();
  }
  return false;
}

function getEnquiryByCustomerId($customerId)
{
  if (!empty($customerId)) {
      return $this->db->select($this->tbl_enquiry . '.*, ' . $this->tbl_users . '.*')
                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                      ->where('enq_cus_id', $customerId)
                      ->get($this->tbl_enquiry)
                      ->row_array();
  }
  return false;
}

function matchingInquiry($customerId)
{
  if (!empty($customerId)) {
      return $this->db->select($this->tbl_enquiry . '.enq_id, ' .
                                $this->tbl_users . '.usr_id, ' .
                                $this->tbl_users . '.usr_first_name, ' .
                                $this->tbl_statuses . '.sts_title')
                      ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')
                      ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value_new = ' . $this->tbl_enquiry . '.enq_current_status', 'LEFT')
                      ->where('enq_cus_id', $customerId)
                      ->get($this->tbl_enquiry)
                      ->row_array();
  }
  return false;
}
    // @CUSTOMER
}
