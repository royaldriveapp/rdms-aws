<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class dbcall_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();

          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_events = TABLE_PREFIX . 'events';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_statuses = TABLE_PREFIX . 'statuses';
          $this->tbl_division = TABLE_PREFIX . 'division';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_departments = TABLE_PREFIX . 'departments';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
          $this->tbl_register_history = TABLE_PREFIX . 'register_history';
          $this->tbl_enquiry_db_master = TABLE_PREFIX . 'enquiry_db_master';
          $this->tbl_callcenterbridging = TABLE_PREFIX . 'callcenterbridging';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->tbl_enquiry_db_details = TABLE_PREFIX . 'enquiry_db_details';
     }

     function teleCallers()
     {
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
               ->where('(' . $this->tbl_groups . ".grp_slug = 'TC' OR " . $this->tbl_groups . ".grp_slug = 'SE')")
               ->where(array($this->tbl_users . '.usr_active' => 1))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->get($this->tbl_users)->result_array();
          //->where('(' . $this->tbl_groups . ".grp_slug = 'TC' OR " . $this->tbl_groups . ".grp_slug = 'SE')")
     }

     function dbMaster($data)
     {
          $data['edm_added_on'] = date('Y-m-d H:i:s');
          $data['edm_added_by'] = $this->uid;
          $this->db->insert($this->tbl_enquiry_db_master, $data);
          return $this->db->insert_id();
     }

     function add($excelData, $masterId)
     {

          //if ((isset($excelData['C']) && isset($excelData['D'])) && (!empty($excelData['C']) && !empty($excelData['C']))) {
          $ingId = 0;
          $regId = 0;
          $excelData['C'] = str_replace(' ', '', $excelData['C']);
          $cusMobile = substr($excelData['C'], -10);
          if (!empty($cusMobile)) {
               //Inquiry already punched.
               $enquiry = $this->db->select('enq_id')->like('enq_cus_mobile', $cusMobile, 'both')->get($this->tbl_enquiry)->row_array();
               $ingId = isset($enquiry['enq_id']) ? $enquiry['enq_id'] : 0;

               //Register already punched.
               $register = $this->db->select('vreg_id')->like('vreg_cust_phone', $cusMobile, 'both')->get($this->tbl_register_master)->row_array();
               $regId = isset($register['vreg_id']) ? $register['vreg_id'] : 0;
          }

          $insArray['edd_veh_reg_num'] = $excelData['A']; //Vehicle registeration number
          $insArray['edd_cust_name'] = $excelData['B']; // Name
          $insArray['edd_cust_number'] = $excelData['C']; // numner
          $insArray['edd_email'] = $excelData['D']; // email
          $insArray['edd_location'] = $excelData['E']; // location
          $insArray['edd_address'] = $excelData['F']; // address

          $sbe = 0;
          if (strpos($excelData['G'], 'S') !== false) { // Sales
               $sbe = 1;
          } else if (strpos($excelData['G'], 'P') !== false) { // Purchase
               $sbe = 2;
          } else if (strpos($excelData['G'], 'E') !== false) { // Exchange
               $sbe = 3;
          }

          $insArray['edd_vehicle'] = $excelData['H']; // Vehicle
          $insArray['edd_desc'] = $excelData['I']; // Description
          $insArray['edd_cust_whatsap'] = $excelData['J']; // Whatsapp
          $insArray['edd_year'] = $excelData['K']; // Whatsapp

          $insArray['edd_spe'] = $sbe; // 1-Sell, 2-Buy, 3-Exchange
          $insArray['edd_vehicle'] = $excelData['H']; // 
          $insArray['edd_desc'] = $excelData['I']; // 

          $insArray['edd_added_on'] = date('Y-m-d H:i:s');
          $insArray['edd_added_by'] = $this->uid;
          $insArray['edd_register_id'] = $regId;
          $insArray['edd_enq_id'] = $ingId;
          $insArray['edd_db_master_id'] = $masterId;
          $this->db->insert($this->tbl_enquiry_db_details, array_filter($insArray));
          return $this->db->insert_id();
          //}
     }

     function assignTo($salesStaff, $ids)
     {
          $this->db->where_in('edd_id', $ids)->update($this->tbl_enquiry_db_details, array('edd_assign_to' => $salesStaff));
     }

     function fetchDBMaster($postDatas)
     {

          $select = array(
               $this->tbl_enquiry_db_master . '.*',
               "DATE_FORMAT(" . $this->tbl_enquiry_db_master . '.edm_added_on, "%M %d %Y %h %i") AS edm_added_on',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
          );

          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'edm_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          ## Search 

          if (!is_roo_user() && check_permission('dbcall', 'showactiveonly')) {
               $this->db->where($this->tbl_enquiry_db_master . '.edm_status', 1);
          }
          if (!is_roo_user() && check_permission('dbcall', 'showmasteronlyassigntome')) {
               $this->db->like($this->tbl_enquiry_db_master . '.edm_assignto', $this->uid, 'both');
          }

          $totalRecords = $this->db->count_all_results($this->tbl_enquiry_db_master);

          if ($searchValue != '') {
               $this->db->where("(edm_db_title LIKE '%" . $searchValue . "%' OR addedby_usr_first_name LIKE '%" .
                    $searchValue . "%' OR addedby_usr_last_name LIKE '%" . $searchValue . "%') ");
          }
          if (!is_roo_user() && check_permission('dbcall', 'showactiveonly')) {
               $this->db->where($this->tbl_enquiry_db_master . '.edm_status', 1);
          }
          if (!is_roo_user() && check_permission('dbcall', 'showmasteronlyassigntome')) {
               $this->db->like($this->tbl_enquiry_db_master . '.edm_assignto', $this->uid, 'both');
          }
          $totalRecordwithFilter = $this->db->select($select)->from($this->tbl_enquiry_db_master)
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_enquiry_db_master . '.edm_added_by', 'LEFT')
               ->count_all_results();

          if ($searchValue != '') {
               $this->db->where("(edm_db_title LIKE '%" . $searchValue . "%' OR addedby_usr_first_name LIKE '%" .
                    $searchValue . "%' OR addedby_usr_last_name LIKE '%" . $searchValue . "%') ");
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          if (!is_roo_user() && check_permission('dbcall', 'showactiveonly')) {
               $this->db->where($this->tbl_enquiry_db_master . '.edm_status', 1);
          }
          if (!is_roo_user() && check_permission('dbcall', 'showmasteronlyassigntome')) {
               $this->db->like($this->tbl_enquiry_db_master . '.edm_assignto', $this->uid, 'both');
          }
          $this->db->limit($rowperpage, $row);
          $data = $this->db->select($select, false)
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_enquiry_db_master . '.edm_added_by', 'LEFT')
               ->get($this->tbl_enquiry_db_master)->result_array();

          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          // echo $this->db->last_query();
          // debug($response);
          return $response;
     }

     function fetchDBDetails($postDatas, $id)
     {

          $select = array(
               $this->tbl_enquiry_db_details . '.*',
               "DATE_FORMAT(" . $this->tbl_enquiry_db_details . '.edd_added_on, "%M %d %Y %h %i") AS crt_added_on, edd_desc',
               'assignto.usr_first_name AS assignto_usr_first_name',
               'assignto.usr_last_name AS assignto_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
          );

          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'edd_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          ## Search 
          $this->db->where($this->tbl_enquiry_db_details . ".edd_cust_number != ''");
          $this->db->where($this->tbl_enquiry_db_details . ".edd_reg_ref", 0);

          if (!is_roo_user() && check_permission('dbcall', 'showonlymy')) {
               $this->db->where($this->tbl_enquiry_db_details . '.edd_assign_to', $this->uid);
          }

          $totalRecords = $this->db->count_all_results($this->tbl_enquiry_db_details);

          $select = array(
               $this->tbl_enquiry_db_details . '.*',
               "DATE_FORMAT(" . $this->tbl_enquiry_db_details . '.edd_added_on, "%M %d %Y %h %i") AS crt_added_on, edd_desc',
               'assignto.usr_first_name AS assignto_usr_first_name',
               'assignto.usr_last_name AS assignto_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_register_master . '.vreg_is_effective',
               $this->tbl_register_master . '.vreg_is_effective',
               $this->tbl_register_master . '.vreg_entry_date',
               $this->tbl_register_master . '.vreg_customer_remark'
          );
          if ($searchValue != '') {
               $this->db->where("(edd_cust_name LIKE '%" . $searchValue . "%' OR assignto.usr_last_name LIKE '%" . $searchValue . "%' OR assignto.usr_first_name LIKE '%" . $searchValue . "%' OR "
                    . "addedby.usr_first_name LIKE '%" . $searchValue . "%' OR addedby.usr_last_name LIKE '%" . $searchValue . "%') ");
          }
          if (!is_roo_user() && check_permission('dbcall', 'showonlymy')) {
               $this->db->where($this->tbl_enquiry_db_details . '.edd_assign_to', $this->uid);
          }
          $this->db->where($this->tbl_enquiry_db_details . ".edd_cust_number != ''");
          $this->db->where($this->tbl_enquiry_db_details . ".edd_reg_ref", 0);
          $totalRecordwithFilter = $this->db->select($select)->from($this->tbl_enquiry_db_details)
               ->join($this->tbl_users . ' assignto', 'assignto.usr_id = ' . $this->tbl_enquiry_db_details . '.edd_assign_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_enquiry_db_details . '.edd_added_by', 'LEFT')
               ->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_enquiry_db_details . '.edd_register_id', 'LEFT')
               ->where($this->tbl_enquiry_db_details . '.edd_db_master_id', $id)->count_all_results();

          if ($searchValue != '') {
               $this->db->where("(edd_cust_name LIKE '%" . $searchValue . "%' OR assignto.usr_last_name LIKE '%" . $searchValue . "%' OR assignto.usr_first_name LIKE '%" . $searchValue . "%' OR "
                    . "addedby.usr_first_name LIKE '%" . $searchValue . "%' OR addedby.usr_last_name LIKE '%" . $searchValue . "%') ");
          }

          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $this->db->where($this->tbl_enquiry_db_details . ".edd_cust_number != ''");
          $this->db->where($this->tbl_enquiry_db_details . ".edd_reg_ref", 0);
          if (!is_roo_user() && check_permission('dbcall', 'showonlymy')) {
               $this->db->where($this->tbl_enquiry_db_details . '.edd_assign_to', $this->uid);
          }
          $this->db->limit($rowperpage, $row);
          $select = array(
               $this->tbl_enquiry_db_details . '.*',
               "DATE_FORMAT(" . $this->tbl_enquiry_db_details . '.edd_added_on, "%M %d %Y %h %i") AS crt_added_on, edd_desc',
               'assignto.usr_first_name AS assignto_usr_first_name',
               'assignto.usr_last_name AS assignto_usr_last_name',
               'addedby.usr_first_name AS addedby_usr_first_name',
               'addedby.usr_last_name AS addedby_usr_last_name',
               $this->tbl_register_master . '.vreg_is_effective',
               $this->tbl_register_master . '.vreg_entry_date',
               $this->tbl_register_master . '.vreg_customer_remark'
          );
          $data = $this->db->select($select, false)
               ->join($this->tbl_users . ' assignto', 'assignto.usr_id = ' . $this->tbl_enquiry_db_details . '.edd_assign_to', 'LEFT')
               ->join($this->tbl_users . ' addedby', 'addedby.usr_id = ' . $this->tbl_enquiry_db_details . '.edd_added_by', 'LEFT')
               ->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_id = ' . $this->tbl_enquiry_db_details . '.edd_register_id', 'LEFT')
               ->where($this->tbl_enquiry_db_details . '.edd_db_master_id', $id)->get($this->tbl_enquiry_db_details)->result_array();

          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;
     }

     public function create($regMaster)
     {

          $regMaster['vreg_first_owner'] = $this->uid;
          $regMaster['vreg_is_effective'] = (isset($regMaster['vreg_is_effective']) && !empty($regMaster['vreg_is_effective'])) ?
               $regMaster['vreg_is_effective'] : 0;
          $regMaster['vreg_first_added_on'] = date('Y-m-d H:i:s');
          $callListRef = isset($regMaster['vreg_voxbay_ref']) ? $regMaster['vreg_voxbay_ref'] : 0;
          unset($regMaster['vreg_voxbay_ref']);

          if (!isset($regMaster['vreg_assigned_to'])) {
               //Get department details
               $dept = $this->db->get_where($this->tbl_departments, array('dep_id' => $regMaster['vreg_department']))->row_array();

               $regMaster['vreg_assigned_to'] = 0;
               $regMaster['vreg_cust_name'] = isset($regMaster['vreg_cust_name']) ? trim($regMaster['vreg_cust_name']) : '';
               $regMaster['vreg_showroom'] = $this->shrm;
               $regMaster['vreg_added_by'] = $this->uid;
               $regMaster['vreg_added_on'] = date('Y-m-d H:i:s');
               $regMaster['vreg_entry_date'] = date('Y-m-d', strtotime($regMaster['vreg_entry_date']));
               $regMaster['vreg_is_verified'] = 1;
               $regMaster['vreg_verified_by'] = $this->uid;
               if ($this->db->insert($this->tbl_register_master, array_filter($regMaster))) {
                    $id = $this->db->insert_id();
                    $this->addRegisterHistory(
                         array(
                              'regh_register_master' => $id,
                              'regh_assigned_by' => $this->uid,
                              'regh_assigned_to' => $regMaster['vreg_assigned_to'],
                              'regh_remarks' => $regMaster['vreg_customer_remark'],
                              'regh_system_cmd' => 'Register punched none sales department'
                         )
                    );
                    generate_log(array(
                         'log_title' => 'Enquiry registration',
                         'log_desc' => 'New registration punched related to HR, CRM etc...',
                         'log_controller' => strtolower(__CLASS__) . '_dblist',
                         'log_action' => 'C',
                         'log_ref_id' => $id,
                         'log_added_by' => get_logged_user('usr_id')
                    ));

                    if (!empty($dept)) {
                         /* $this->load->library('email', Array(
                             'protocol' => 'smtp',
                             'smtp_host' => SMTP_HOST,
                             'smtp_port' => SMTP_PORT,
                             'smtp_user' => SMTP_USER,
                             'smtp_pass' => SMTP_PASS,
                             'mailtype' => 'html',
                             'charset' => 'utf-8'
                             )); */
                         $this->load->library('email', array('mailtype' => 'html', 'charset' => 'utf-8'));

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
                    if ($callListRef > 0) {
                         $punchOn = date('Y-m-d H:i:s');
                         $this->db->where_in('edd_id', $callListRef)->update(
                              $this->tbl_enquiry_db_details,
                              array('edd_punched_by' => $this->uid, 'edd_punched_on' => $punchOn, 'edd_reg_ref' => $id)
                         );
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
               $regMaster['vreg_added_on'] = date('Y-m-d H:i:s'); //h-> H added on 03-12-2020 06:00 AM
               $regMaster['vreg_entry_date'] = date('Y-m-d', strtotime($regMaster['vreg_entry_date']));
               $regMaster['vreg_cust_name'] = isset($regMaster['vreg_cust_name']) ? trim($regMaster['vreg_cust_name']) : '';
               //$regMaster['vreg_assigned_to'] = (empty($oldEnqSEId)) ? $assignedTo : $oldEnqSEId;

               if ($this->db->insert($this->tbl_register_master, array_filter($regMaster))) {
                    $id = $this->db->insert_id();
                    $this->addRegisterHistory(
                         array(
                              'regh_register_master' => $id,
                              'regh_assigned_by' => $this->uid,
                              'regh_assigned_to' => $regMaster['vreg_assigned_to'],
                              'regh_remarks' => $regMaster['vreg_customer_remark'],
                              'regh_system_cmd' => 'Register punched sales department'
                         )
                    );
                    generate_log(array(
                         'log_title' => 'New vehicle registration from db list',
                         'log_desc' => 'New vehicle registration from db list',
                         'log_controller' => strtolower(__CLASS__) . '_dblist',
                         'log_action' => 'C',
                         'log_ref_id' => $id,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    //Register id to call bridge
                    if ($callListRef > 0) {
                         $punchOn = date('Y-m-d H:i:s');
                         $this->db->where_in('edd_id', $callListRef)->update(
                              $this->tbl_enquiry_db_details,
                              array('edd_punched_by' => $this->uid, 'edd_punched_on' => $punchOn, 'edd_reg_ref' => $id)
                         );
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

     function readCallList($id)
     {
          return $this->db->get_where($this->tbl_enquiry_db_details, array('edd_id' => $id))->row_array();
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

     function addRegisterHistory($datas, $updateRegMstr = true)
     {
          $datas['regh_added_by'] = $this->uid;
          $datas['regh_added_date'] = date('Y-m-d H:i:s');
          $this->db->insert($this->tbl_register_history, $datas);
          if ($updateRegMstr) {
               $this->db->where('vreg_id', $datas['regh_register_master'])
                    ->update($this->tbl_register_master, array('vreg_assigned_to' => $datas['regh_assigned_to']));
          }
     }

     function changeStatus($id)
     {
          $details = $this->db->get_where($this->tbl_enquiry_db_master, array('edm_id' => $id))->row_array();
          $newSts = ($details['edm_status'] == 1) ? 0 : 1;
          $this->db->where('edm_id', $id)->update($this->tbl_enquiry_db_master, array('edm_status' => $newSts));
          return true;
     }

     function delete($masterId)
     {
          $this->db->where('edm_id', $masterId)->delete($this->tbl_enquiry_db_master);
          $this->db->where('edd_db_master_id', $masterId)->delete($this->tbl_enquiry_db_details);
          return true;
     }
}
