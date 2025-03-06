<?php
if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class fellowship_model extends CI_Model
{
     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->db->query("SET time_zone = '+05:30'");

          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          //  $this->tbl_web_enq_users = TABLE_PREFIX . 'users';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
          $this->tbl_mou_master = TABLE_PREFIX . 'mou_master';
          $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
          $this->tbl_state = TABLE_PREFIX . 'states';
          $this->tbl_district = TABLE_PREFIX . 'district_statewise';
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
          $this->tbl_register_history = TABLE_PREFIX . 'register_history';
          $this->tbl_web_enquiry = 'web_enquiry';
          $this->tbl_web_enq_users = 'web_enq_users';
          $this->tbl_web_enquiry_man = 'web_enquiry_man';
          $this->tbl_web_enquiry_phone = 'web_enquiry_phone';
          $this->tbl_web_enq_family_details = 'web_enq_family_details';
          $this->tbl_web_enq_pitched_veh = 'web_enq_pitched_veh';
          $this->tbl_web_enq_veh_associated_with_customer = 'web_enq_veh_associated_with_customer';
          $this->tbl_web_enq_purchase_veh = 'web_enq_purchase_veh';
          $this->tbl_web_enq_refurb_jobs = 'web_enq_refurb_jobs';
          $this->tbl_occupation_category = TABLE_PREFIX . 'occupation_categories';
          $this->tbl_occupation = TABLE_PREFIX . 'occupation';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->tbl_price_range = TABLE_PREFIX . 'price_range';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
     }
     function staffCanAssignEnquires()
     {
          return $this->db->select(
               array(
                    $this->tbl_users . '.usr_id',
                    $this->tbl_users . '.usr_first_name',
                    $this->tbl_users . '.usr_username',
                    $this->tbl_users . '.usr_last_name',
                    $this->tbl_users_groups . '.group_id as group_id',
                    $this->tbl_groups . '.name as group_name',
                    $this->tbl_groups . '.description as group_desc',
                    $this->tbl_showroom . '.*'
               )
          )
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->where('(usr_designation_new = 100 OR usr_designation_new = 37 OR usr_designation_new = 20)')
               ->order_by($this->tbl_users . '.usr_first_name')->get($this->tbl_users)->result_array();
     }
     /*report*/
     function FellowshipStaffsForReport()
     {
          if (check_permission('fellowship', 'show_all_reports')) {
          } else if (check_permission('fellowship', 'my_staff_reports')) {
               $this->db->where($this->tbl_users . '.usr_tl', $this->uid);
          }
          return $this->db->select(
               array(
                    $this->tbl_users . '.usr_id',
                    $this->tbl_users . '.usr_first_name',
                    $this->tbl_users . '.usr_username',
                    $this->tbl_users . '.usr_last_name',
                    $this->tbl_users . '.usr_mobile_personal',
                    $this->tbl_users . '.usr_tl'
               )
          )

               ->where('(usr_designation_new = 117)')
               ->order_by($this->tbl_users . '.usr_first_name')->get($this->tbl_users)->result_array();
     }
     function getTeamLead()
     {

          return $this->db->select(
               array(
                    $this->tbl_users . '.usr_id',
                    $this->tbl_users . '.usr_username'
               )
          )->where($this->tbl_users . '.usr_is_fellowship_tl', 1)->get($this->tbl_users)->result_array();
     }

     function getReport($postDatas, $filterDatas)
     {
          $mystaffs = array();
          if (check_permission('fellowship', 'my_staff_reports')) {
               //$mystaffs = my_staff($this->uid);
               $mystaffs = $this->db->select('usr_mobile_personal')->get_where($this->tbl_users, array('usr_tl' => $this->uid, 'usr_designation_new' => 117))->result_array();
               $mystaffs = array_column($mystaffs, 'usr_mobile_personal');
          }
          error_reporting(E_ALL);
          ini_set('display_errors', 1);
          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value

          $totalRecords = $this->getReportTotal($searchValue, $filterDatas, $mystaffs);
          $search = array();
          if (!empty($searchValue)) {
               $search[] = "web_name LIKE '%" . $searchValue . "%'";
               $search[] = "web_email LIKE '%" . $searchValue . "%'";
               $search[] = "web_insta LIKE '%" . $searchValue . "%'";
               $search[] = "web_youtube LIKE '%" . $searchValue . "%'";
               $search[] = "web_fb LIKE '%" . $searchValue . "%'";
               $search[] = "web_twitter LIKE '%" . $searchValue . "%'";
               $search[] = "web_linkedin LIKE '%" . $searchValue . "%'";
               $search[] = "web_whatsapp LIKE '%" . $searchValue . "%'";
               $search[] = "web_pin LIKE '%" . $searchValue . "%'";
               $search[] = "web_district LIKE '%" . $searchValue . "%'";
               $search[] = "web_address LIKE '%" . $searchValue . "%'";
               $this->db->where('(' . implode(" OR ", $search) . ')');
          }
          $this->db->where($this->tbl_web_enquiry . '.web_rdms_enq_id', 0);
          if (check_permission('fellowship', 'show_all_reports')) {
          } else if (check_permission('fellowship', 'my_staff_reports')) {
               $this->db->where_in('addeddBy.web_usr_phone', $mystaffs);
          } elseif (check_permission('fellowship', 'my_report')) {
               $this->db->where($this->tbl_web_enquiry . '.web_assign_to', $this->uid);
          }
          /*filters */
          if (isset($filterDatas['staff']) && !empty($filterDatas['staff'])) {
               $staffPhones = implode(',', $filterDatas['staff']);
               $this->db->where('addeddBy.web_usr_phone IN (' . $staffPhones . ')');
          }
          if (isset($filterDatas['tl']) && !empty($filterDatas['tl'])) {
               $TL = implode(',', $filterDatas['tl']);
               $this->db->where('leadDetails.usr_id IN (' . $TL . ')');
          }
          if (isset($filterDatas['status']) && !empty($filterDatas['status'])) {
               $status = implode(',', $filterDatas['status']);
               $this->db->where($this->tbl_web_enquiry . '.web_status IN (' . $status . ')');
          }
          if (isset($filterDatas['validated_at']) && !empty($filterDatas['validated_at'])) {
               $validated_at = date('Y-m-d', strtotime($filterDatas['validated_at']));
               $this->db->where($this->tbl_web_enquiry . '.web_validated_on', $validated_at);
          }
          if (isset($filterDatas['web_created_at_fr']) && !empty($filterDatas['web_created_at_fr'])) {
               $date = date('Y-m-d', strtotime($filterDatas['web_created_at_fr']));
               $this->db->where('DATE(' . $this->tbl_web_enquiry . '.web_created_at) >=', $date);
               $this->db->order_by($this->tbl_web_enquiry . '.web_created_at');
          }
          if (isset($filterDatas['web_created_at_to']) && !empty($filterDatas['web_created_at_to'])) {
               $date = date('Y-m-d', strtotime($filterDatas['web_created_at_to']));
               $this->db->where('DATE(' . $this->tbl_web_enquiry . '.web_created_at) <=', $date);
          }

          /*End filters*/
          $selArray = array(
               $this->tbl_web_enquiry . '.web_id',
               $this->tbl_web_enquiry . '.web_category',
               $this->tbl_web_enquiry . '.web_source_of_enq',
               $this->tbl_web_enquiry . '.web_name',
               $this->tbl_web_enquiry . '.web_gender',
               $this->tbl_web_enquiry . '.web_email',
               $this->tbl_web_enquiry . '.web_insta',
               $this->tbl_web_enquiry . '.web_youtube',
               $this->tbl_web_enquiry . '.web_fb',
               $this->tbl_web_enquiry . '.web_twitter',
               $this->tbl_web_enquiry . '.web_linkedin',
               $this->tbl_web_enquiry . '.web_whatsapp',
               $this->tbl_web_enquiry . '.web_pin',
               $this->tbl_web_enquiry . '.web_district',
               $this->tbl_web_enquiry . '.web_occupation_cat',
               $this->tbl_web_enquiry . '.web_occupation',
               $this->tbl_web_enquiry . '.web_company_website',
               $this->tbl_web_enquiry . '.web_remarks',
               $this->tbl_web_enquiry . '.web_status',
               $this->tbl_web_enquiry . '.web_assign_to',
               "DATE_FORMAT(" . $this->tbl_web_enquiry . ".web_validated_on, '%d-%m-%Y') AS web_validated_on",
               $this->tbl_web_enquiry . '.web_validated_cmd',
               $this->tbl_web_enquiry . '.web_status_cmd',
               "DATE_FORMAT(" . $this->tbl_web_enquiry . ".web_created_at, '%d-%m-%Y') AS web_created_at",
               $this->tbl_web_enquiry . '.web_rdms_enq_id',
               $this->tbl_web_enquiry . '.web_enq_type',
               $this->tbl_web_enquiry . '.web_address',
               'addeddBy.web_usr_name AS added_usr_username',
               'addeddBy.web_usr_phone AS web_usr_phone',
               'web_enquiry_phone.webph_phone',
               'teamLead.usr_tl',
               //'teamLead.usr_id As usrtb_id',
               //'teamLead.usr_username As usrtb_username',
               'leadDetails.usr_first_name AS team_lead_first_name',
               'assignedStaff.usr_username As sales_staff'
          );

          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          if (isset($filterDatas['executive']) && !empty($filterDatas['executive'])) {
               $this->db->where($this->tbl_web_enquiry . '.web_assign_to', $filterDatas['executive']);
          }
          $data = $this->db->select($selArray)
               ->join($this->tbl_web_enq_users . ' addeddBy', 'addeddBy.web_usr_master_id = ' . $this->tbl_web_enquiry . '.web_id', 'left')
               ->join('web_enquiry_phone', 'web_enquiry_phone.webph_master_id = web_enquiry.web_id', 'left')
               ->join($this->tbl_users . ' teamLead', 'teamLead.usr_mobile_personal = addeddBy.web_usr_phone', 'left')
               ->join($this->tbl_users . ' leadDetails', 'leadDetails.usr_id = teamLead.usr_tl', 'left')
               ->join($this->tbl_users . ' assignedStaff', 'assignedStaff.usr_id = ' . $this->tbl_web_enquiry . '.web_assign_to', 'left')
               ->group_by($this->tbl_web_enquiry . '.web_id') // Fetch only one record per enquiry
               ->order_by($this->tbl_web_enquiry . '.web_id', 'DESC')
               ->get($this->tbl_web_enquiry)->result_array();
          //debug($data);
          // $uniqueTL = [];
          //     foreach ($data as $row) {
          //         $uniqueTL[$row['usr_tl']] = $row['team_lead_first_name'];
          //     }
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data,
          );
          //echo $this->db->last_query();
          //debug($response);
          return $response;
     }

     function getReportTotal($searchValue, $filterDatas, $mystaffs)
     {
          $search = array();
          if (!empty($searchValue)) {
               $search[] = "web_name LIKE '%" . $searchValue . "%'";
               $search[] = "web_email LIKE '%" . $searchValue . "%'";
               $search[] = "web_insta LIKE '%" . $searchValue . "%'";
               $search[] = "web_youtube LIKE '%" . $searchValue . "%'";
               $search[] = "web_fb LIKE '%" . $searchValue . "%'";
               $search[] = "web_twitter LIKE '%" . $searchValue . "%'";
               $search[] = "web_linkedin LIKE '%" . $searchValue . "%'";
               $search[] = "web_whatsapp LIKE '%" . $searchValue . "%'";
               $search[] = "web_pin LIKE '%" . $searchValue . "%'";
               $search[] = "web_district LIKE '%" . $searchValue . "%'";
               $search[] = "web_address LIKE '%" . $searchValue . "%'";
               $this->db->where('(' . implode(" OR ", $search) . ')');
          }

          $this->db->where($this->tbl_web_enquiry . '.web_rdms_enq_id', 0);

          if (check_permission('fellowship', 'show_all_reports')) {
          } else if (check_permission('fellowship', 'my_staff_reports')) {
               $this->db->where_in('addeddBy.web_usr_phone', $mystaffs);
          } elseif (check_permission('fellowship', 'my_report')) {
               $this->db->where($this->tbl_web_enquiry . '.web_assign_to', $this->uid);
          }

          $this->db->join($this->tbl_web_enq_users . ' addeddBy', 'addeddBy.web_usr_master_id = ' . $this->tbl_web_enquiry . '.web_id', 'left');

          // Apply filters
          if (isset($filterDatas['staff']) && !empty($filterDatas['staff'])) {
               $this->db->where_in('addeddBy.web_usr_phone', $filterDatas['staff']);
          }

          if (isset($filterDatas['tl']) && !empty($filterDatas['tl'])) {
               $this->db->join($this->tbl_users . ' teamLead', 'teamLead.usr_mobile_personal = addeddBy.web_usr_phone', 'left');
               $this->db->where_in('teamLead.usr_tl', $filterDatas['tl']);
          }

          if (isset($filterDatas['status']) && !empty($filterDatas['status'])) {
               $this->db->where_in($this->tbl_web_enquiry . '.web_status', $filterDatas['status']);
          }

          if (isset($filterDatas['validated_at']) && !empty($filterDatas['validated_at'])) {
               $validated_at = date('Y-m-d', strtotime($filterDatas['validated_at']));
               $this->db->where($this->tbl_web_enquiry . '.web_validated_on', $validated_at);
          }
          if (isset($filterDatas['executive']) && !empty($filterDatas['executive'])) {
               $this->db->where($this->tbl_web_enquiry . '.web_assign_to', $filterDatas['executive']);
          }
          if (isset($filterDatas['web_created_at_fr']) && !empty($filterDatas['web_created_at_fr'])) {
               $date = date('Y-m-d', strtotime($filterDatas['web_created_at_fr']));
               $this->db->where('DATE(' . $this->tbl_web_enquiry . '.web_created_at) >=', $date);
               $this->db->order_by($this->tbl_web_enquiry . '.web_created_at');
          }
          if (isset($filterDatas['web_created_at_to']) && !empty($filterDatas['web_created_at_to'])) {
               $date = date('Y-m-d', strtotime($filterDatas['web_created_at_to']));
               $this->db->where('DATE(' . $this->tbl_web_enquiry . '.web_created_at) <=', $date);
          }
          $this->db->from($this->tbl_web_enquiry);
          return $this->db->count_all_results();
     }
     /*End report*/

     public function getCountBasedReportBk()
     {
          // Fetch users based on the given condition
          $users = $this->db->select(
               array(
                    $this->tbl_users . '.usr_id',
                    $this->tbl_users . '.usr_first_name',
                    $this->tbl_users . '.usr_username',
                    $this->tbl_users . '.usr_last_name',
                    $this->tbl_users . '.usr_mobile_personal',
                    $this->tbl_users . '.usr_tl'
               )
          )
               ->where('usr_designation_new', 117)
               ->order_by($this->tbl_users . '.usr_first_name')
               ->get($this->tbl_users)
               ->result_array();

          $reportData = [];

          foreach ($users as $user) {
               // Count total enquiries
               $this->db->where('web_added_by', $user['usr_mobile_personal']);
               $totalEnquiries = $this->db->count_all_results($this->tbl_web_enquiry);

               // Count validated enquiries
               $this->db->where('web_added_by', $user['usr_mobile_personal']);
               $this->db->where('web_status', 1);
               $validatedEnquiries = $this->db->count_all_results($this->tbl_web_enquiry);

               // Add data to report array
               $reportData[] = [

                    'usr_name' => $user['usr_username'],
                    'usr_mobile_personal' => $user['usr_mobile_personal'],
                    'total_enquiries' => $totalEnquiries,
                    'validated_enquiries' => $validatedEnquiries
               ];
          }

          return $reportData;
     }
     public function getCountBasedReportj($postDatas, $filterDatas)
     {
          error_reporting(E_ALL);
          ini_set('display_errors', 1);
          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          $users = $this->db->select(
               array(
                    $this->tbl_users . '.usr_id',
                    $this->tbl_users . '.usr_first_name',
                    $this->tbl_users . '.usr_username',
                    $this->tbl_users . '.usr_last_name',
                    $this->tbl_users . '.usr_mobile_personal',
                    $this->tbl_users . '.usr_tl'
               )
          )
               ->where('usr_designation_new', 117)
               ->order_by($this->tbl_users . '.usr_first_name')
               ->get($this->tbl_users)
               ->result_array();

          $reportData = [];

          foreach ($users as $user) {
               // Count total enquiries
               $this->db->where('web_added_by', $user['usr_mobile_personal']);
               $totalEnquiries = $this->db->count_all_results($this->tbl_web_enquiry);

               // Count validated enquiries
               $this->db->where('web_added_by', $user['usr_mobile_personal']);
               $this->db->where('web_status', 1);
               $validatedEnquiries = $this->db->count_all_results($this->tbl_web_enquiry);

               // Add data to report array
               $reportData[] = [

                    'usr_name' => $user['usr_username'],
                    'usr_mobile_personal' => $user['usr_mobile_personal'],
                    'total_enquiries' => $totalEnquiries,
                    'validated_enquiries' => $validatedEnquiries
               ];
          }
          $totalRecords = count($users);
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $reportData,
          );
          //echo $this->db->last_query();
          //debug($response);
          return $response;
          //return $reportData;
     }

     public function getCountBasedReport($postDatas, $filterDatas)
     {
          error_reporting(E_ALL);
          ini_set('display_errors', 1);

          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 10; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'asc'; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value

          // Build the base query
          $this->db->select('
        u.usr_id, 
        u.usr_username as usr_name,
        u.usr_mobile_personal,
        COUNT(DISTINCT w.web_id) as total_enquiries,
        SUM(CASE WHEN w.web_status = 1 THEN 1 ELSE 0 END) as validated_enquiries
    ')
               ->from($this->tbl_users . ' u')
               ->join($this->tbl_web_enquiry . ' w', 'u.usr_mobile_personal = w.web_added_by', 'left')
               ->where('u.usr_designation_new', 117)
               ->group_by('u.usr_id');

          // Filtering
          if (!empty($searchValue)) {
               $this->db->like('usr_username', $searchValue);
               $this->db->or_like('usr_mobile_personal', $searchValue);
          }


          // Get the total number of records
          $totalRecordsQuery = clone $this->db;  // Clone the DB object to keep the original query intact
          $totalRecordsQuery->select('COUNT(*) as count');
          $totalRecords = $totalRecordsQuery->get()->row()->count;

          // Apply sorting
          $this->db->order_by($columnName, $columnSortOrder);

          // Apply pagination
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }

          // Get the results
          $reportData = $this->db->get()->result_array();

          // Prepare response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $reportData,
          );

          return $response;
     }


     public function getTableFields()
     {

          //      $query = $this->db->order_by('web_usr_id', 'asc')
          //      ->where('web_usr_phone', 2)
          //      ->get('web_enq_users');
          // return $query->result_array();

          //      $sql = "
          //      UPDATE web_enquiry
          //      JOIN web_enq_users ON web_enquiry.web_id = web_enq_users.web_usr_master_id
          //      SET web_enquiry.web_added_by = web_enq_users.web_usr_phone
          //      WHERE web_enq_users.web_usr_phone IS NOT NULL
          //  ";
          //  $this->db->query($sql);
          // return 1;
          $query = $this->db->order_by('web_id', 'asc') //
               ->limit(100)
               ->get($this->tbl_web_enquiry);
          return $query->result_array();
          //     $query = $this->db->query("SHOW COLUMNS FROM " .$this->tbl_web_enquiry);
          //     return $query->result_array();
     }
}
