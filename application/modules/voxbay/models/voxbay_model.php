<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class voxbay_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();

          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
          $this->tbl_callcenterbridging = TABLE_PREFIX . 'callcenterbridging';
          $this->tbl_callcenterbridging_outgoing = TABLE_PREFIX . 'callcenterbridging_outgoing';
          $this->hideCategory = array(2);
     }

     /*public function getAllCalls($postDatas) {

            $draw = $postDatas['draw'];
            $row = $postDatas['start'];
            $rowperpage = $postDatas['length']; // Rows display per page
            $columnIndex = $postDatas['order'][0]['column']; // Column index
            $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
            $searchValue = $postDatas['search']['value']; // Search value
            ## Search 

            $searchQuery = "";
            if ($searchValue != '') {
                 $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                         . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
            }
            $this->db->where('ccb_recording_URL IS NOT NULL');
            $this->db->where('ccb_punched_by', 0);
            
            ## Total number of records without filtering
            $totalRecords = $this->db->count_all_results($this->tbl_callcenterbridging);

            ## Total number of record with filtering
            if (!empty($searchQuery)) {
                 $this->db->where($searchQuery);
            }
            $totalRecordwithFilter = $this->db->count_all_results($this->tbl_callcenterbridging);

            ## Fetch records
            if (!empty($searchValue)) {
                 $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                         . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
            }
            if (!empty($columnName) && !empty($columnSortOrder)) {
                 $this->db->order_by($columnName, $columnSortOrder);
            }
            $this->db->order_by('ccb_id', 'desc');
            $this->db->limit($rowperpage, $row);
            $this->db->select(array(
                $this->tbl_callcenterbridging . '.ccb_id',
                "CONCAT('http://pbx.voxbaysolutions.com/callrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
                $this->tbl_callcenterbridging . '.ccb_callStatus',
                $this->tbl_callcenterbridging . '.ccb_calledNumber',
                $this->tbl_callcenterbridging . '.ccb_callerNumber',
                $this->tbl_callcenterbridging . '.ccb_AgentNumber',
                $this->tbl_callcenterbridging . '.ccb_authorized_person',
                "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_callDate, "%M %d %Y %h %i") AS ccb_callDate',
            ));
            $this->db->where('ccb_recording_URL IS NOT NULL');
            $this->db->where('ccb_punched_by', 0);
            
            $data = $this->db->get($this->tbl_callcenterbridging)->result_array();
            
            ## Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            return $response;
       }*/

     public function getAllCalls($postDatas)
     {
          $vbBaseUrl = get_settings_by_key('voxbay_call_baseurl');

          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          ## Search 

          $this->db->where('ccb_can_show', 1)->where_not_in('ccb_category', $this->hideCategory);
          $this->db->where('ccb_calledNumber != 914843109140');
          
          //$this->db->where('ccb_callStatus_id > 0');
          $totalRecords = $this->db->count_all_results($this->tbl_callcenterbridging);

          if ($searchValue != '') {
               $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                    . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }
          $this->db->where('ccb_can_show', 1)->where_not_in('ccb_category', $this->hideCategory);
          //$this->db->where('ccb_callStatus_id > 0');
          if (check_permission('voxbay', 'myconnectedincall') && $this->uid != 100) {
               $this->db->where('ccb_authorized_person_id', $this->uid);
          }
          $this->db->where('ccb_calledNumber != 914843109140');
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
               "CONCAT('" . $vbBaseUrl . "content/incomingrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus',
               $this->tbl_callcenterbridging . '.ccb_calledNumber',
               $this->tbl_callcenterbridging . '.ccb_callerNumber',
               $this->tbl_callcenterbridging . '.ccb_AgentNumber',
               $this->tbl_callcenterbridging . '.ccb_authorized_person',
               $this->tbl_callcenterbridging . '.ccb_category',
               "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_added_on, "%M %d %Y %h %i") AS ccb_added_on',
          ));
          $this->db->where('ccb_can_show', 1)->where_not_in('ccb_category', $this->hideCategory);
          //$this->db->where('ccb_callStatus_id > 0');
          if (check_permission('voxbay', 'myconnectedincall') && $this->uid != 100) {
               $this->db->where('ccb_authorized_person_id', $this->uid);
          }
          $this->db->where('ccb_calledNumber != 914843109140');
          $data = $this->db->get($this->tbl_callcenterbridging)->result_array();
          //echo $this->db->last_query();exit;
          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;
     }

     function readVoxBayCall($id)
     {
          return $this->db->get_where($this->tbl_callcenterbridging, array('ccb_id' => $id))->row_array();
     }

     function readVoxBayCallForRegister($id)
     {
          return $this->db->select('ccb_callerNumber, ccb_id')->get_where($this->tbl_callcenterbridging, array('ccb_id' => $id))->row_array();
     }

     public function pendingCalls($postDatas)
     {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          ## Search 

          $this->db->where('ccb_misd_old', 1)->where('ccb_can_show', 1)->where_not_in('ccb_category', $this->hideCategory);
          if ($this->usr_grp == 'TC' || $this->usr_grp == 'SE') {
               $this->db->where('ccb_force_assign', $this->uid);
          }
          $this->db->group_by("ccb_opt_ph");
          $totalRecords = count($this->db->select('ccb_id, RIGHT(ccb_callerNumber, 10) AS ccb_opt_ph, ccb_callerNumber, COUNT(*) AS count, ccb_force_assign', false)
               ->get($this->tbl_callcenterbridging)->result_array());

          if ($searchValue != '') {
               $this->db->like("ccb_callerNumber", $searchValue, "both");
          }
          $this->db->where('ccb_misd_old', 1)->where('ccb_can_show', 1)->where_not_in('ccb_category', $this->hideCategory);
          if ($this->usr_grp == 'TC' || $this->usr_grp == 'SE') {
               $this->db->where('ccb_force_assign', $this->uid);
          }
          $this->db->group_by('ccb_opt_ph');
          $totalRecordwithFilter = count($this->db->select('ccb_id, RIGHT(ccb_callerNumber, 10) AS ccb_opt_ph, ccb_callerNumber, COUNT(*) AS count, ccb_force_assign', false)
               ->get($this->tbl_callcenterbridging)->result_array());

          $this->db->limit($rowperpage, $row);
          if ($searchValue != '') {
               $this->db->like("ccb_callerNumber", $searchValue, "both");
          }
          $this->db->where('ccb_misd_old', 1)->where('ccb_can_show', 1)->where_not_in('ccb_category', $this->hideCategory);
          if ($this->usr_grp == 'TC' || $this->usr_grp == 'SE') {
               $this->db->where('ccb_force_assign', $this->uid);
          }
          $this->db->group_by('ccb_opt_ph');
          $data = $this->db->select('ccb_id, RIGHT(ccb_callerNumber, 10) AS ccb_opt_ph, ccb_callerNumber, COUNT(*) AS count, ccb_force_assign', false)
               ->get($this->tbl_callcenterbridging)->result_array();
          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;
     }

     function calllog($phnumber)
     {
          $phnumber = substr($phnumber, -10);
          return $this->db->order_by('ccb_id', 'desc')->like('ccb_callerNumber', $phnumber, 'both')->get($this->tbl_callcenterbridging)->result_array();
     }

     public function getAllConnectedCall($postDatas)
     {
          $vbBaseUrl = get_settings_by_key('voxbay_call_baseurl');
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          ## Search 
            $this->db->where('ccb_calledNumber != 914843109140');
          $this->db->where('ccb_callStatus_id', VB_CONNECTED)->where_not_in('ccb_category', $this->hideCategory);
          $totalRecords = $this->db->count_all_results($this->tbl_callcenterbridging);

          if ($searchValue != '') {
               $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                    . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }
          $this->db->where('ccb_callStatus_id', VB_CONNECTED)->where_not_in('ccb_category', $this->hideCategory);
            $this->db->where('ccb_calledNumber != 914843109140');
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
               "CONCAT('" . $vbBaseUrl . "content/incomingrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus',
               $this->tbl_callcenterbridging . '.ccb_calledNumber',
               $this->tbl_callcenterbridging . '.ccb_callerNumber',
               $this->tbl_callcenterbridging . '.ccb_AgentNumber',
               $this->tbl_callcenterbridging . '.ccb_authorized_person',
               $this->tbl_callcenterbridging . '.ccb_category',
               "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_added_on, "%M %d %Y %h %i") AS ccb_added_on',
          ));
          $this->db->where('ccb_calledNumber != 914843109140');
          $this->db->where('ccb_callStatus_id', VB_CONNECTED)->where_not_in('ccb_category', $this->hideCategory);
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

     function getOutboundByNumber($number)
     {
          $vbBaseUrl = get_settings_by_key('voxbay_call_baseurl');
          if (!empty($number)) {
               $this->db->where("ccbo_destination LIKE '%" . $number . "%'");
          }
          $this->db->order_by('ccbo_id', 'DESC');
          $this->db->select(array(
               $this->tbl_callcenterbridging_outgoing . '.*',
               "CONCAT('" . $vbBaseUrl . "content/callrecordings/'," . $this->tbl_callcenterbridging_outgoing . '.ccbo_recording_URL,' . "'.wav') AS ccbo_recording_URL",
               "DATE_FORMAT(" . $this->tbl_callcenterbridging_outgoing . '.ccbo_date, "%M %d %Y %h %i") AS ccbo_date'
          ));
          //->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_callcenterbridging_outgoing . '.ccbo_destination_user_id', 'LEFT');
          //,$this->tbl_users . '.usr_username'
          return $this->db->get($this->tbl_callcenterbridging_outgoing)->result_array();
     }

     public function getAllConnectedInCall($postDatas)
     {
          $vbBaseUrl = get_settings_by_key('voxbay_call_baseurl');
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          $dataF = isset($postDatas['dateFrom']) ? $postDatas['dateFrom'] : '';
          $dataT = isset($postDatas['dateTo']) ? $postDatas['dateTo'] : '';

          ## Search 
          $this->db->where('ccb_callStatus_id', VB_CONNECTED)->where_not_in('ccb_category', $this->hideCategory);
          $this->db->where('ccb_calledNumber != 914843109140');
          $totalRecords = $this->db->count_all_results($this->tbl_callcenterbridging);

          if ($searchValue != '') {
               $this->db->where("(ccb_calledNumber LIKE '%" . $searchValue . "%' OR ccb_callerNumber LIKE '%" . $searchValue . "%' OR "
                    . "ccb_AgentNumber LIKE '%" . $searchValue . "%' OR ccb_authorized_person LIKE '%" . $searchValue . "%') ");
          }

          if (!empty($dataF)) {
               $date = date('Y-m-d', strtotime($dataF));
               $this->db->where('DATE(ccb_callDate) >=', $date);
               $this->db->order_by('ccb_callDate');
          }
          if (!empty($dataT)) {
               $date = date('Y-m-d', strtotime($dataT));
               $this->db->where('DATE(ccb_callDate) <=', $date);
          }
          if (isset($postDatas['staff']) && !empty($postDatas['staff'])) {
               $this->db->where('ccb_authorized_person_id', $postDatas['staff']);
          }

          $this->db->where('ccb_callStatus_id', VB_CONNECTED)->where_not_in('ccb_category', $this->hideCategory);
            $this->db->where('ccb_calledNumber != 914843109140');
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
               "CONCAT('" . $vbBaseUrl . "content/incomingrecordings/'," . $this->tbl_callcenterbridging . '.ccb_recording_URL) AS ccb_recording_URL',
               $this->tbl_callcenterbridging . '.ccb_callStatus',
               $this->tbl_callcenterbridging . '.ccb_calledNumber',
               $this->tbl_callcenterbridging . '.ccb_callerNumber',
               $this->tbl_callcenterbridging . '.ccb_AgentNumber',
               $this->tbl_callcenterbridging . '.ccb_authorized_person',
               $this->tbl_callcenterbridging . '.ccb_category',
               "DATE_FORMAT(" . $this->tbl_callcenterbridging . '.ccb_added_on, "%M %d %Y %h %i") AS ccb_added_on',
          ));
          $this->db->where('ccb_callStatus_id', VB_CONNECTED)->where_not_in('ccb_category', $this->hideCategory);
          if (!empty($dataF)) {
               $date = date('Y-m-d', strtotime($dataF));
               $this->db->where('DATE(ccb_callDate) >=', $date);
               $this->db->order_by('ccb_callDate');
          }
          if (!empty($dataT)) {
               $date = date('Y-m-d', strtotime($dataT));
               $this->db->where('DATE(ccb_callDate) <=', $date);
          }
          if (isset($postDatas['staff']) && !empty($postDatas['staff'])) {
               $this->db->where('ccb_authorized_person_id', $postDatas['staff']);
          }
          $this->db->where('ccb_calledNumber != 914843109140');
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

     public function getAllConnectedOutCall($postDatas)
     {
          $vbBaseUrl = get_settings_by_key('voxbay_call_baseurl');
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccbo_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          $dataF = isset($postDatas['dateFrom']) ? $postDatas['dateFrom'] : '';
          $dataT = isset($postDatas['dateTo']) ? $postDatas['dateTo'] : '';

          ## Search 
          //$this->db->where('ccb_callStatus_id', VB_CONNECTED)->where_not_in('ccb_category', $this->hideCategory);
          $this->db->where('ccbo_callerid != 914843109140');
          $totalRecords = $this->db->count_all_results($this->tbl_callcenterbridging_outgoing);

          if ($searchValue != '') {
               $this->db->where("(ccbo_destination LIKE '%" . $searchValue . "%' OR ccbo_callerid LIKE '%" . $searchValue . "%' OR "
                    . "ccbo_extension LIKE '%" . $searchValue . "%' OR ccbo_destination_user LIKE '%" . $searchValue . "%') ");
          }

          if (!empty($dataF)) {
               $date = date('Y-m-d', strtotime($dataF));
               $this->db->where('DATE(ccbo_date) >=', $date);
               $this->db->order_by('ccbo_date');
          }
          if (!empty($dataT)) {
               $date = date('Y-m-d', strtotime($dataT));
               $this->db->where('DATE(ccbo_date) <=', $date);
          }
          if (isset($postDatas['staff']) && !empty($postDatas['staff'])) {
               $this->db->where('ccbo_destination_user_id', $postDatas['staff']);
          }
          //$this->db->where('ccb_callStatus_id', VB_CONNECTED)->where_not_in('ccb_category', $this->hideCategory);
          if (check_permission('voxbay', 'myconnectedoutcall') && $this->uid != 100) {
               $this->db->where('ccbo_destination_user_id', $this->uid);
          }
          $this->db->where('ccbo_callerid != 914843109140');
          $totalRecordwithFilter = $this->db->count_all_results($this->tbl_callcenterbridging_outgoing);
          if ($searchValue != '') {
               $this->db->where("(ccbo_destination LIKE '%" . $searchValue . "%' OR ccbo_callerid LIKE '%" . $searchValue . "%' OR "
                    . "ccbo_extension LIKE '%" . $searchValue . "%' OR ccbo_destination_user LIKE '%" . $searchValue . "%') ");
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $this->db->limit($rowperpage, $row);
          $this->db->select(array(
               'ccbo_id',
               'ccbo_destination_user',
               'ccbo_callerid',
               'ccbo_status',
               'ccbo_destination',
               "DATE_FORMAT(ccbo_date, '%M %d %Y %h %i') AS ccbo_date",
               "CONCAT('" . $vbBaseUrl . "content/callrecordings/'," . $this->tbl_callcenterbridging_outgoing . '.ccbo_recording_URL,' . "'.wav') AS ccbo_recording_URL"
          ));
          //$this->db->where('ccb_callStatus_id', VB_CONNECTED)->where_not_in('ccb_category', $this->hideCategory);
          if (!empty($dataF)) {
               $date = date('Y-m-d', strtotime($dataF));
               $this->db->where('DATE(ccbo_date) >=', $date);
               $this->db->order_by('ccbo_date');
          }
          if (!empty($dataT)) {
               $date = date('Y-m-d', strtotime($dataT));
               $this->db->where('DATE(ccbo_date) <=', $date);
          }
          if (isset($postDatas['staff']) && !empty($postDatas['staff'])) {
               $this->db->where('ccbo_destination_user_id', $postDatas['staff']);
          }
          if (check_permission('voxbay', 'myconnectedoutcall') && $this->uid != 100) {
               $this->db->where('ccbo_destination_user_id', $this->uid);
          }
          $this->db->where('ccbo_callerid != 914843109140');
          $data = $this->db->get($this->tbl_callcenterbridging_outgoing)->result_array();
          // echo $this->db->last_query();
          // exit;
          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;
     }

     function getStaffs()
     {
          return $this->db->select($this->tbl_users . '.usr_id, ' . $this->tbl_users . '.usr_first_name, ' .
               $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active,' . $this->tbl_designation . '.desig_title')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->where('(' . $this->tbl_users . ".usr_designation_new = 14 OR " .
                    $this->tbl_users . ".usr_designation_new = 43 OR " .
                    $this->tbl_users . ".usr_designation_new = 59 OR " .
                    $this->tbl_users . ".usr_designation_new = 38)")->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->get($this->tbl_users)->result_array();
     }
}
