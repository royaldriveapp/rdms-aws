<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class emp_details_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->db->query("SET time_zone = '+05:30'");

          $this->tbl_city = TABLE_PREFIX . 'city';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_state = TABLE_PREFIX . 'state';
          $this->tbl_grade = TABLE_PREFIX . 'grade';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_country = TABLE_PREFIX . 'country';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_district = TABLE_PREFIX . 'district';
          $this->tbl_extensions = TABLE_PREFIX . 'extensions';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_app_download_ref = TABLE_PREFIX . 'app_download_ref';
     }
     function staffRegisterRequest($data)
     {
          if ($data) {
               generate_log(array(
                    'log_title' => 'Create new user',
                    'log_desc' => serialize($data),
                    'log_controller' => 'staff-create-request',
                    'log_action' => 'C',
                    'log_ref_id' => 90,
                    'log_added_by' => $this->uid
               ));

               $data['usr_added_by'] = $this->uid;
               $data['usr_active'] = 0;
               $data['usr_new_join'] = 1;
               $data['usr_username'] = $data['usr_first_name'] . ' ' . $data['usr_last_name'];

               $data['usr_doj'] = !empty($data['usr_doj']) ? date('Y-m-d', strtotime($data['usr_doj'])) : '';
               $data['usr_dob'] = !empty($data['usr_dob']) ? date('Y-m-d', strtotime($data['usr_dob'])) : '';
               $data['usr_marriage_date'] = !empty($data['usr_marriage_date']) ? date('Y-m-d', strtotime($data['usr_marriage_date'])) : '';

               $data = array_filter($data);
               $this->db->insert($this->tbl_users, $data);
               $lastInsertId = $this->db->insert_id();

               /* Bitly */
               $appDownload = url_shortner('https://www.royaldrive.in/appdwn/dwn/' . $lastInsertId);
               $this->db->where('usr_id', $lastInsertId)->update($this->tbl_users, array('usr_appdownloadlink' => $appDownload));
               /* Bitly */

               generate_log(array(
                    'log_title' => 'Create new user',
                    'log_desc' => 'New user added',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'C',
                    'log_ref_id' => $lastInsertId,
                    'log_added_by' => $this->uid
               ));
               return true;
          } else {
               generate_log(array(
                    'log_title' => 'Create new user',
                    'log_desc' => 'Failed to create new user',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'C',
                    'log_ref_id' => 0,
                    'log_added_by' => $this->uid
               ));

               return false;
          }
     }

     function getStaffMaster()
     {
          //COUNT(cpnl_app_download_ref.adr_id) AS add_dwn_count
          if ($this->uid != 100) {
               $this->db->where($this->tbl_users . '.usr_resigned', 0);
          }
          $this->db->where($this->tbl_users . '.usr_id !=', 1);

          if (!check_permission('emp_details', 'showinnactivestaffs')) {
               //$this->db->where('(' . $this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0)');
               $this->db->where($this->tbl_users . '.usr_active = 1');
          }

          $this->db->where($this->tbl_users . ".usr_username != ''");
          return $this->db->select($this->tbl_users . '.*, ' .
               $this->tbl_users_groups . '.group_id as group_id, ' .
               $this->tbl_groups . '.name as group_name, ' .
               $this->tbl_groups . '.description as group_desc, ' . $this->tbl_showroom . '.*, tl.usr_username AS teamLead, ' .
               $this->tbl_designation . '.desig_title')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_users . ' tl', 'tl.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               //  ->join($this->tbl_app_download_ref, $this->tbl_users . '.usr_id = ' . $this->tbl_app_download_ref . '.adr_user_id', 'LEFT')
               //  ->group_by('cpnl_app_download_ref.adr_user_id')
               ->get($this->tbl_users)->result_array();
     }
     function getStaffMasterPaginate($postDatas, $filterDatas)
     {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value

          if ($this->uid != 100) {
               $this->db->where($this->tbl_users . '.usr_resigned', 0);
          }
          $this->db->where($this->tbl_users . '.usr_id !=', 1);

          if (!check_permission('emp_details', 'showinnactivestaffs')) {
               $this->db->where($this->tbl_users . '.usr_active = 1');
          }

          $this->db->where($this->tbl_users . ".usr_username != ''");

          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_users . ".usr_username LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_email LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_users . ".usr_first_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_last_name LIKE '%"
                    . $searchValue . "%' OR " . $this->tbl_users . ".usr_phone LIKE '%" . $searchValue . "%') ");
          }

          if (isset($filterDatas['desig']) && ($filterDatas['desig'] > 0)) {
               $this->db->where_in($this->tbl_users . '.usr_designation_new', $filterDatas['desig']);
          }

          if (isset($filterDatas['division']) && ($filterDatas['division'] > 0)) {
               $this->db->where(array($this->tbl_users . '.usr_division' => $filterDatas['division']));
          }

          if (isset($filterDatas['showroom']) && ($filterDatas['showroom'] > 0)) {
               $this->db->where(array($this->tbl_users . '.usr_showroom' => $filterDatas['showroom']));
          }

          if (isset($filterDatas['resigned']) && ($filterDatas['resigned'] != '')) {
               $this->db->where(array($this->tbl_users . '.usr_resigned' => $filterDatas['resigned']));
          }

          // Clone the query to calculate total records without limits
          $countQuery = clone $this->db;
          $totalRecords = $countQuery->count_all_results($this->tbl_users);

          // Apply limit and get the data for the current page

          $this->db->select(
               $this->tbl_users . '.usr_id, ' .
                    $this->tbl_users . '.usr_appdownloadlink, ' .
                    $this->tbl_users . '.usr_emp_code, ' .
                    $this->tbl_users . '.usr_username, ' .
                    $this->tbl_users . '.usr_caller_id, ' .
                    $this->tbl_users . '.usr_company_email, ' .
                    $this->tbl_users . '.usr_phone, ' .
                    $this->tbl_users . '.usr_persnl_email, ' .
                    $this->tbl_users . '.usr_mobile_personal, ' .
                    $this->tbl_users . '.usr_doj, ' .
                    $this->tbl_users . '.usr_dob, ' .
                    $this->tbl_users . '.usr_address, ' .
                    $this->tbl_users . '.usr_address1, ' .
                    $this->tbl_users . '.usr_emergency_no, ' .
                    $this->tbl_users . '.usr_marital_status, ' .
                    $this->tbl_users . '.usr_spouse_name, ' .
                    $this->tbl_users . '.usr_marriage_date, ' .
                    $this->tbl_users . '.usr_father_name, ' .
                    $this->tbl_users . '.usr_edu_quali, ' .
                    $this->tbl_users . '.usr_tech_quali, ' .
                    $this->tbl_users . '.usr_previous_exp, ' .
                    $this->tbl_users . '.usr_industry_exp, ' .
                    $this->tbl_users . '.usr_bank, ' .
                    $this->tbl_users . '.usr_bank_acc_no, ' .
                    $this->tbl_users . '.usr_bank_ifsc,' .
                    $this->tbl_users_groups . '.group_id as group_id, ' .
                    $this->tbl_groups . '.name as group_name, ' .
                    $this->tbl_groups . '.description as group_desc, ' . $this->tbl_showroom . '.*, tl.usr_username AS teamLead, ' .
                    $this->tbl_designation . '.desig_title'
          );
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          $data = $this->db->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_users . ' tl', 'tl.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->get($this->tbl_users)->result_array();

          $response = array(
               "draw" => intval($postDatas['draw']),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }

     function getNewStaffRequest($postDatas)
     {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value

          $this->db->where($this->tbl_users . '.usr_new_join', 1);

          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_users . ".usr_username LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_email LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_users . ".usr_first_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_last_name LIKE '%"
                    . $searchValue . "%') ");
          }

          // Clone the query to calculate total records without limits
          $totalRecords = $this->db->count_all_results($this->tbl_users);
          // Apply limit and get the data for the current page

          $this->db->where($this->tbl_users . '.usr_new_join', 1);

          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_users . ".usr_username LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_email LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_users . ".usr_first_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_last_name LIKE '%"
                    . $searchValue . "%') ");
          }

          $this->db->select(
               $this->tbl_users . '.usr_id, ' .
                    $this->tbl_users . '.usr_appdownloadlink, ' .
                    $this->tbl_users . '.usr_emp_code, ' .
                    $this->tbl_users . '.usr_username, ' .
                    $this->tbl_users . '.usr_caller_id, ' .
                    $this->tbl_users . '.usr_company_email, ' .
                    $this->tbl_users . '.usr_phone, ' .
                    $this->tbl_users . '.usr_persnl_email, ' .
                    $this->tbl_users . '.usr_mobile_personal, ' .
                    $this->tbl_users . '.usr_doj, ' .
                    $this->tbl_users . '.usr_dob, ' .
                    $this->tbl_users . '.usr_address, ' .
                    $this->tbl_users . '.usr_address1, ' .
                    $this->tbl_users . '.usr_emergency_no, ' .
                    $this->tbl_users . '.usr_marital_status, ' .
                    $this->tbl_users . '.usr_spouse_name, ' .
                    $this->tbl_users . '.usr_marriage_date, ' .
                    $this->tbl_users . '.usr_father_name, ' .
                    $this->tbl_users . '.usr_edu_quali, ' .
                    $this->tbl_users . '.usr_tech_quali, ' .
                    $this->tbl_users . '.usr_previous_exp, ' .
                    $this->tbl_users . '.usr_industry_exp, ' .
                    $this->tbl_users . '.usr_bank, ' .
                    $this->tbl_users . '.usr_bank_acc_no, ' .
                    $this->tbl_users . '.usr_bank_ifsc,' .
                    $this->tbl_users_groups . '.group_id as group_id, ' .
                    $this->tbl_groups . '.name as group_name, ' .
                    $this->tbl_groups . '.description as group_desc, ' . $this->tbl_showroom . '.*, tl.usr_username AS teamLead, ' .
                    $this->tbl_designation . '.desig_title'
          );
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          $data = $this->db->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_users . ' tl', 'tl.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->get($this->tbl_users)->result_array();

          $response = array(
               "draw" => intval($postDatas['draw']),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }

     function upcomingCelebrations()
     {
          //$data['birthday'] = $this->db->select('usr_emp_code, usr_username, usr_dob')->where('(DAY(usr_dob) = DAY(DATE_ADD(CURDATE(), INTERVAL 1 DAY)) OR 
          //DAY(usr_dob) = DAY(CURDATE())) and (MONTH(usr_dob) = MONTH(CURDATE())) AND (YEAR(CURDATE()) > YEAR(usr_dob))')->get($this->tbl_users)->result_array();
          $data['birthday'] = $this->db->select('usr_emp_code, usr_username, usr_dob,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               //->where('(MONTH(CURDATE()) = MONTH(usr_dob))')->where('DAY(usr_dob) >= ' . date('d'))
               ->where('(MONTH(CURDATE()) = MONTH(usr_dob))')
               ->where('usr_resigned', 0)->where('usr_active', 1)->order_by('DAY(usr_dob)')->get($this->tbl_users)->result_array();

          $data['joinanniver'] = $this->db->select('usr_emp_code, usr_username, usr_doj, DAY(usr_doj), DAY(DATE_ADD(CURDATE(), INTERVAL 1 DAY)), DAY(usr_doj), DAY(CURDATE()),
                    MONTH(usr_doj), MONTH(CURDATE()),' . $this->tbl_showroom . '.shr_location', false)
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               //->where('(DAY(usr_doj) = DAY(DATE_ADD(CURDATE(), INTERVAL 1 DAY))  OR DAY(usr_doj) = DAY(CURDATE())) and (MONTH(usr_doj) = MONTH(CURDATE())) AND (YEAR(CURDATE()) > YEAR(usr_doj))')
               ->where('(MONTH(usr_doj) = MONTH(CURDATE()))')->where('usr_active', 1)->where('usr_resigned', 0)
               ->where('DAY(usr_doj) >= ' . date('d'))
               ->order_by('DAY(usr_doj)')->get($this->tbl_users)->result_array();

          $data['marranniver'] = $this->db->select('usr_emp_code, usr_username, usr_marriage_date, ' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->where('(MONTH(CURDATE()) = MONTH(usr_marriage_date))')->where('DAY(usr_marriage_date) >= ' . date('d'))
               ->where('usr_resigned', 0)->where('usr_active', 1)->order_by('DAY(usr_marriage_date)')->get($this->tbl_users)->result_array();
          return $data;
     }

     function getUsers()
     {
          $showroom = get_logged_user('usr_showroom');
          if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_users . '.usr_showroom', $showroom);
               $this->db->where_in($this->tbl_groups . '.grp_slug', array('AC', 'TL', 'DE', 'SE', 'OS'));
          }
          if ($this->usr_grp == 'DE') { // Data entry
               $this->db->where($this->tbl_users . '.usr_active', 1);
               $this->db->where($this->tbl_users . '.usr_showroom', $showroom);
               $this->db->where_in($this->tbl_groups . '.grp_slug', array('DE', 'SE', 'OS'));
          }
          $this->db->where($this->tbl_users . '.usr_id !=', 1);
          $this->db->where($this->tbl_users . ".usr_username != ''");
          //$this->db->where($this->tbl_users . ".usr_active", 1);
          return $this->db->select(
               $this->tbl_users . '.*, ' .
                    $this->tbl_users_groups . '.group_id as group_id, ' .
                    $this->tbl_groups . '.name as group_name, ' .
                    $this->tbl_groups . '.description as group_desc, ' . $this->tbl_showroom . '.*, tl.usr_username AS teamLead, ' .
                    $this->tbl_designation . '.desig_title'
          )
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_users . ' tl', 'tl.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->order_by($this->tbl_users . '.usr_active', 'DESC')->get($this->tbl_users)->result_array();
     }

     function register($data)
     {
          if ($data) {
               $desi = isset($data['usr_group']) ? $data['usr_group'] : 0;
               $username = isset($data['usr_first_name']) ? $data['usr_first_name'] : '';
               $password = isset($data['usr_password']) ? $data['usr_password'] : '';
               $email = isset($data['usr_email']) ? $data['usr_email'] : '';
               $group = array($data['usr_group']); // Sets user to admin.

               unset($data['usr_group']);
               unset($data['usr_password']);
               unset($data['usr_password_conf']);

               /* City */
               $city = $this->db->like('cit_name', $data['usr_city'], 'both')->get($this->tbl_city)->row_array();
               if (empty($city)) {
                    $this->db->insert($this->tbl_city, array('cit_name' => $data['usr_city']));
                    $data['usr_city'] = $this->db->insert_id();
               } else {
                    $data['usr_city'] = $city['cit_id'];
               }
               /* District */
               $dist = $this->db->like('dit_name', $data['usr_district'], 'both')->get($this->tbl_district)->row_array();
               if (empty($dist)) {
                    $this->db->insert($this->tbl_district, array('dit_name' => $data['usr_district']));
                    $data['usr_district'] = $this->db->insert_id();
               } else {
                    $data['usr_district'] = $dist['dit_id'];
               }
               /* State */
               $state = $this->db->like('stt_name', $data['usr_state'], 'both')->get($this->tbl_state)->row_array();
               if (empty($state)) {
                    $this->db->insert($this->tbl_state, array('stt_name' => $data['usr_state']));
                    $data['usr_state'] = $this->db->insert_id();
               } else {
                    $data['usr_state'] = $state['stt_id'];
               }
               /* Country */
               $country = $this->db->like('cnt_name', $data['usr_country'], 'both')->get($this->tbl_country)->row_array();
               if (empty($country)) {
                    $this->db->insert($this->tbl_country, array('cnt_name' => $data['usr_country']));
                    $data['usr_country'] = $this->db->insert_id();
               } else {
                    $data['usr_country'] = $country['cnt_id'];
               }
               $data['usr_added_by'] = $this->uid;
               $data['usr_designation'] = $desi;
               $data = array_filter($data);
               $lastInsertId = $this->ion_auth->register($username, $password, $email, $data, $group);

               /* Bitly */
               $appDownload = url_shortner('https://www.royaldrive.in/appdwn/dwn/' . $lastInsertId);
               $this->db->where('usr_id', $lastInsertId)->update($this->tbl_users, array('usr_appdownloadlink' => $appDownload));
               /* Bitly */

               generate_log(array(
                    'log_title' => 'Create new user',
                    'log_desc' => 'New user added',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'C',
                    'log_ref_id' => $lastInsertId,
                    'log_added_by' => $this->uid
               ));

               return true;
          } else {
               generate_log(array(
                    'log_title' => 'Create new user',
                    'log_desc' => 'Failed to create new user',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'C',
                    'log_ref_id' => 0,
                    'log_added_by' => $this->uid
               ));

               return false;
          }
     }

     function update($data)
     {
          if ((isset($data['usr_id']) && !empty($data['usr_id'])) && (isset($data['usr_showroom']) && !empty($data['usr_showroom']))) {
               $userDetails = $this->ion_auth->user($data['usr_id'])->row_array();
               $newShowroom = isset($data['usr_showroom']) ? $data['usr_showroom'] : 0;
               $curShowroom = isset($userDetails['usr_showroom']) ? $userDetails['usr_showroom'] : 0;
               if ($newShowroom != $curShowroom) {
                    generate_log(array(
                         'log_title' => 'Changed executive showroom',
                         'log_desc' => $curShowroom . '-' . $newShowroom,
                         'log_controller' => 'change_exe_showroom',
                         'log_action' => 'U',
                         'log_ref_id' => $data['usr_id'],
                         'log_added_by' => $this->uid
                    ));
               }
          }
          $userGroup = $data['usr_group'];
          $id = isset($data['usr_id']) ? $data['usr_id'] : '';
          unset($data['usr_id']);
          $this->ion_auth->remove_from_group('', $id);
          $this->ion_auth->add_to_group($data['usr_group'], $id);
          unset($data['usr_group']);

          if (isset($data['usr_password']) && empty($data['usr_password'])) {
               unset($data['usr_password']);
          }
          unset($data['usr_password_conf']);

          /* City */
          /*$city = $this->db->like('cit_name', $data['usr_city'], 'both')->get($this->tbl_city)->row_array();
            if (empty($city)) {
                 $this->db->insert($this->tbl_city, array('cit_name' => $data['usr_city']));
                 $data['usr_city'] = $this->db->insert_id();
            } else {
                 $data['usr_city'] = $city['cit_id'];
            }
            /* District */
          /*$dist = $this->db->like('dit_name', $data['usr_district'], 'both')->get($this->tbl_district)->row_array();
            if (empty($dist)) {
                 $this->db->insert($this->tbl_district, array('dit_name' => $data['usr_district']));
                 $data['usr_district'] = $this->db->insert_id();
            } else {
                 $data['usr_district'] = $dist['dit_id'];
            }
            /* State */
          /*$state = $this->db->like('stt_name', $data['usr_state'], 'both')->get($this->tbl_state)->row_array();
            if (empty($state)) {
                 $this->db->insert($this->tbl_state, array('stt_name' => $data['usr_state']));
                 $data['usr_state'] = $this->db->insert_id();
            } else {
                 $data['usr_state'] = $state['stt_id'];
            }
            /* Country */
          /*$country = $this->db->like('cnt_name', $data['usr_country'], 'both')->get($this->tbl_country)->row_array();
            if (empty($country)) {
                 $this->db->insert($this->tbl_country, array('cnt_name' => $data['usr_country']));
                 $data['usr_country'] = $this->db->insert_id();
            } else {
                 $data['usr_country'] = $country['cnt_id'];
            }*/
          $data['usr_active'] = 1;
          $data['usr_username'] = $data['usr_first_name'];
          $data['usr_updated_by'] = $this->uid;
          //$data['usr_tl'] = $userGroup == 8 ? $data['usr_tl'] : 0;
          $data['usr_active'] = isset($data['usr_active']) ? $data['usr_active'] : 0;
          $data['usr_designation'] = $userGroup;
          $data = array_filter($data);
          $data['usr_new_join'] = 0;
          $this->ion_auth->update($id, $data);

          generate_log(array(
               'log_title' => 'Update user',
               'log_desc' => 'Updated user details',
               'log_controller' => strtolower(__CLASS__),
               'log_action' => 'U',
               'log_ref_id' => $id,
               'log_added_by' => $this->uid
          ));

          return true;
     }

     function salesExecutives()
     {
          //            $this->db->where('usr_id != ', $this->uid);
          //if ($this->usr_grp == 'MG') {
          //$this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
          //}
          if (check_permission('emp_details', 'showinnactivestaffs')) {
               $this->db->where($this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0');
          } else {
               $this->db->where($this->tbl_users . '.usr_active = 1');
          }
          if ($this->usr_grp == 'TL') {
               //$this->db->where($this->tbl_users . '.usr_tl', $this->uid);
               //                 $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
               return  $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
                    ->where(array($this->tbl_users . '.usr_can_auto_assign' => 1))
                    ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();

               //echo $this->db->last_query();
               //debug($return);

          } else {
               return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                    //->where(array($this->tbl_users . '.usr_can_auto_assign' => 1))
                    ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
          }
     }

     function salesOfficerandcre()
     {
          if ($this->usr_grp == 'MG') {
               $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
          }
          if (check_permission('emp_details', 'showinnactivestaffs')) {
               $this->db->where($this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0');
          } else {
               $this->db->where($this->tbl_users . '.usr_active = 1');
          }
          if ($this->usr_grp == 'TL') {
               //$this->db->where($this->tbl_users . '.usr_tl', $this->uid);
               //                 $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
               return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
                    //->where(array($this->tbl_users . '.usr_can_auto_assign' => 1))
                    ->where_in($this->tbl_groups . '.grp_slug', array('SE', 'TC'))
                    ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
          } else {
               return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')

                    ->where_in($this->tbl_groups . '.grp_slug', array('SE', 'TC'))
                    ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
          }
     }

     function getAllEmployees()
     {
          return $this->db->select(
               $this->tbl_users . '.*, ' .
                    $this->tbl_users_groups . '.group_id as group_id, ' .
                    $this->tbl_groups . '.name as group_name, ' .
                    $this->tbl_groups . '.description as group_desc, ' . $this->tbl_showroom . '.*'
          )
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'left')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->order_by($this->tbl_users . '.usr_first_name')
               ->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->result_array();
     }

     function salesExecutivesByShowroom($showroomId)
     {
          /* $this->db->where('usr_id != ', $this->uid);
              if (!empty($showroomId)) {
              $this->db->where($this->tbl_users . '.usr_showroom', $showroomId);
              }
              return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
              ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
              ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
              ->where(array($this->tbl_groups . '.grp_slug' => 'SE'))->get($this->tbl_users)->result_array(); */

          $this->db->where('usr_id != ', $this->uid);
          if (!empty($showroomId)) {
               $this->db->where($this->tbl_users . '.usr_showroom', $showroomId);
          }
          if (check_permission('emp_details', 'showinnactivestaffs')) {
               $this->db->where($this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0');
          } else {
               $this->db->where($this->tbl_users . '.usr_active = 1');
          }
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               //                            ->where(array($this->tbl_groups . '.grp_slug' => 'SE'))
               ->where(array($this->tbl_users . '.usr_can_auto_assign' => 1))
               ->get($this->tbl_users)->result_array();
     }

     function getTeamLeads($showroomId)
     {
          if (!empty($showroomId)) {
               //$this->db->where($this->tbl_users . '.usr_showroom', $showroomId);
          }
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_username AS col_title, ' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
               ->order_by('usr_first_name')->where(array('usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->result_array();
     }

     function bindDesignationGrades($id)
     {
          return $this->db->select('grd_id AS col_id, grd_code AS col_title')->where('grd_designation', $id)->get($this->tbl_grade)->result_array();
     }

     function downloadCount($usrId)
     {
          if (!empty($usrId)) {
               return $this->db->where('adr_user_id', $usrId)->count_all_results($this->tbl_app_download_ref);
          }
     }

     function teleCallers()
     {
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
               ->where(array($this->tbl_groups . '.grp_slug' => 'TC'))->where(array($this->tbl_users . '.usr_active' => 1))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->get($this->tbl_users)->result_array();
     }

     function myReportingStaff()
     {
          return $this->db->select($this->tbl_users . '.usr_id, ' . $this->tbl_users . '.usr_username')
               ->get_where($this->tbl_users, array('usr_tl' => $this->uid, 'usr_active' => 1))->result_array();
     }

     function salesExecutivesOnly()
     {
          if ($this->usr_grp == 'TL') {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)
                    ->get($this->tbl_users)->row()->usr_id);
          }
          $this->db->where('usr_id != ', $this->uid);
          if ($this->usr_grp == 'MG') {
               $this->db->where($this->tbl_users . '.usr_showroom', $this->shrm);
          }

          if (check_permission('emp_details', 'showinnactivestaffs')) {
               $this->db->where($this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0');
          } else {
               $this->db->where($this->tbl_users . '.usr_active = 1');
          }
          if ($this->usr_grp == 'TL') {
               return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
                    ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_groups . '.id' => GRP_SALES_OFFICER))
                    ->where_in($this->tbl_users . '.usr_id', $mystaffs)->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
          } else {
               return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                    ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_groups . '.id' => GRP_SALES_OFFICER))
                    ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
          }
     }

     function getAutoAssignedMenbers()
     {
          return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
               ->where($this->tbl_users . '.usr_active = 1 AND (' . $this->tbl_users . '.usr_can_auto_assign = 1 OR ' .
                    $this->tbl_users . '.usr_designation_new = 43 OR . ' . $this->tbl_users . '.usr_designation_new = 14)')
               ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
     }

     function teleCallersSalesStaffs()
     {
          if (check_permission('registration', 'myregisterassigntodropdownmyteam')) {
               $mystaffs = my_staff($this->uid);
               array_push($mystaffs, $this->uid);
               $this->db->where_in($this->tbl_users . '.usr_id', $mystaffs);
          }
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'left')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where('(' . $this->tbl_groups . ".grp_slug = 'TC' OR " . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
               ->order_by($this->tbl_users . '.usr_first_name', 'ASC')
               ->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0))->get($this->tbl_users)->result_array();
     }

     function getExtensions()
     {
          return $this->db->select($this->tbl_extensions . '.*,' . $this->tbl_showroom  . '.*')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_extensions . '.ext_branch', 'left')
               ->where('ext_status', 1)->order_by($this->tbl_extensions . '.ext_branch', 'DESC')->get($this->tbl_extensions)->result_array();
     }

     function staffQuickupdate($data)
     {

          $id = $data['usr_id'];
          unset($data['usr_id']);

          $data['usr_added_by'] = $this->uid;
          $data['usr_active'] = 0;
          $data['usr_new_join'] = 1;
          $data['usr_username'] = $data['usr_first_name'] . ' ' . $data['usr_last_name'];

          $data['usr_doj'] = !empty($data['usr_doj']) ? date('Y-m-d', strtotime($data['usr_doj'])) : NULL;
          $data['usr_dob'] = !empty($data['usr_dob']) ? date('Y-m-d', strtotime($data['usr_dob'])) : NULL;
          $data['usr_marriage_date'] = !empty($data['usr_marriage_date']) ? date('Y-m-d', strtotime($data['usr_marriage_date'])) : NULL;

          $this->db->where('usr_id', $id)->update($this->tbl_users, $data);

          generate_log(array(
               'log_title' => 'Quick update staff',
               'log_desc' => serialize($data),
               'log_controller' => 'quick-update-staff',
               'log_action' => 'U',
               'log_ref_id' => $id,
               'log_added_by' => $this->uid
          ));
          return true;
     }
     //target 
     function getSaleStaffs($shrm = 2)
     {
          $salesStaff = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_showroom . '.shr_location,' . $this->tbl_users . '.usr_active,' . $this->tbl_designation . '.desig_title')
               //->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               //->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               // ->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
               ->where('(' . $this->tbl_users . ".usr_designation_new = 5 OR " . $this->tbl_users . ".usr_designation_new = 6 OR " . $this->tbl_users . ".usr_designation_new = 11 OR " . $this->tbl_users . ".usr_designation_new = 12 OR " . $this->tbl_users . ".usr_designation_new = 14 OR " . $this->tbl_users . ".usr_designation_new = 18 OR " . $this->tbl_users . ".usr_designation_new = 24 OR " . $this->tbl_users . ".usr_designation_new = 25 OR " . $this->tbl_users . ".usr_designation_new = 22)")
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_showroom' => $shrm))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->get($this->tbl_users)->result_array();
          return $salesStaff;
     }
     function getTargetByUserId($id, $month, $category = '')
     {
          //debug($id);
          $currentYear = date('Y');
          if ($category == 1) {
               $this->db->select('st_1st_week_target,st_2nd_week_target,st_3rd_week_target,st_4th_week_target');
               $res = $this->db->where(array('st_user_id' => $id, 'st_target_month' => $month, 'st_target_year' => $currentYear))
                    ->get('cpnl_staff_targets')->row_array();
          } else if ($category == 2) {
               $this->db->select('st_1st_week_valuation_target,st_2nd_week_valuation_target,st_3rd_week_valuation_target,st_4th_week_valuation_target');
               $res = $this->db->where(array('st_user_id' => $id, 'st_target_month' => $month, 'st_target_year' => $currentYear))
                    ->get('cpnl_staff_targets')->row_array();
          }

          //debug($res);
          return !empty($res) ? $res : '';
     }
     function storeTargets($data)
     {
          if (!empty($data)) {
               $currentYear = date('Y');

               $res = $this->db->select('st_target')
                    ->where(array('st_user_id' => $data['stff_id'], 'st_target_month' => $data['month_id'], 'st_target_year' => $currentYear))
                    ->get('cpnl_staff_targets')->num_rows();
               if ($data['tagetCategory'] == 1) { //sales target
                    if ($data['wk'] == 1) {
                         $taget_field = 'st_1st_week_target';
                    } elseif ($data['wk'] == 2) {
                         $taget_field = 'st_2nd_week_target';
                    } elseif ($data['wk'] == 3) {
                         $taget_field = 'st_3rd_week_target';
                    } elseif ($data['wk'] == 4) {
                         $taget_field = 'st_4th_week_target';
                    }
               } elseif ($data['tagetCategory'] == 2) { //valuation target
                    if ($data['wk'] == 1) {
                         $taget_field = 'st_1st_week_valuation_target';
                    } elseif ($data['wk'] == 2) {
                         $taget_field = 'st_2nd_week_valuation_target';
                    } elseif ($data['wk'] == 3) {
                         $taget_field = 'st_3rd_week_valuation_target';
                    } elseif ($data['wk'] == 4) {
                         $taget_field = 'st_4th_week_valuation_target';
                    }
               }
               if ($res) {
                    $res = $this->db->where(array('st_user_id' => $data['stff_id'], 'st_target_month' => $data['month_id'], 'st_target_year' => $currentYear))->update('cpnl_staff_targets', array($taget_field => $data['target']));
                    debug($res);
               } else {
                    $this->db->insert('cpnl_staff_targets', array($taget_field => $data['target'], 'st_user_id' => $data['stff_id'], 'st_target_month' => $data['month_id'], 'st_target_year' => $currentYear, 'st_created_by' => $this->uid, 'st_created_at' => date('Y-m-d H:i:s')));
                    $res = $this->db->insert_id();
                    debug($res);
               }
          }
     }

     function resignation($data)
     {
          $userId = $data['usr_id'];
          unset($data['usr_id']);
          generate_log(array(
               'log_title' => 'Staff resignation',
               'log_desc' => serialize($data),
               'log_controller' => 'staff-resignation',
               'log_action' => 'U',
               'log_ref_id' => $userId,
               'log_added_by' => $this->uid
          ));
          $data['usr_active'] = 0;
          $data['usr_resigned_date'] = (!empty($data['usr_resigned_date'])) ? date('Y-m-d', strtotime($data['usr_resigned_date'])) : date('Y-m-d H:i:s');
          $this->db->where('usr_id', $userId)->update($this->tbl_users, $data);
          return true;
     }
     function getUsersPaginate($postDatas, $filterDatas)
     {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          $showroom = get_logged_user('usr_showroom');

          if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_users . '.usr_showroom', $showroom);
               $this->db->where_in($this->tbl_groups . '.grp_slug', array('AC', 'TL', 'DE', 'SE', 'OS'));
          }

          if ($this->usr_grp == 'DE') { // Data entry
               $this->db->where($this->tbl_users . '.usr_active', 1);
               $this->db->where($this->tbl_users . '.usr_showroom', $showroom);
               $this->db->where_in($this->tbl_groups . '.grp_slug', array('DE', 'SE', 'OS'));
          }

          $this->db->where($this->tbl_users . '.usr_id !=', 1);
          $this->db->where($this->tbl_users . ".usr_username != ''");
          // Calculate the total records without pagination limit
          ///$this->db->select('COUNT(' . $this->tbl_users . '.usr_id) as totalRecords');
          ///$totalRecordsQuery = $this->db->get($this->tbl_users);
          ///$totalRecordsData = $totalRecordsQuery->row_array();
          ///$totalRecords = isset($totalRecordsData['totalRecords']) ? (int)$totalRecordsData['totalRecords'] : 0;
          $totalRecords = $this->totalRecords($postDatas, $filterDatas);
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          if (!empty($searchValue)) {

               //    $this->db->where("(usr_username LIKE '%" . $searchValue . "%' OR desig_title LIKE '%" . $searchValue . "%' OR "
               //        . "%' OR shr_location LIKE '%" . $searchValue . "%' OR usr_email LIKE '%" . $searchValue . "%' OR tl.usr_username LIKE '%" . $searchValue . "%') ");
               $this->db->where("(" . $this->tbl_users . ".usr_username LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_email LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_users . ".usr_first_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_last_name LIKE '%" .
                    $searchValue . "%' OR tl.usr_username LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_emp_code LIKE '%" . $searchValue . "%') ");
          }

          if (isset($filterDatas['desig']) && ($filterDatas['desig'] > 0)) {
               $this->db->where(array($this->tbl_users . '.usr_designation_new' => $filterDatas['desig']));
          }
          if (isset($filterDatas['division']) && ($filterDatas['division'] > 0)) {
               $this->db->where(array($this->tbl_users . '.usr_showroom' => $filterDatas['division']));
          }
          if (isset($filterDatas['showroom']) && ($filterDatas['showroom'] > 0)) {
               $this->db->where(array($this->tbl_users . '.usr_showroom' => $filterDatas['showroom']));
          }

          if (isset($filterDatas['resigned']) && ($filterDatas['resigned'] != '')) {
               $this->db->where(array($this->tbl_users . '.usr_resigned' => $filterDatas['resigned']));
          }
          $data = $this->db->select(
               $this->tbl_users . '.usr_id, ' .
                    $this->tbl_users . '.usr_emp_code, ' .
                    $this->tbl_users . '.usr_avatar, ' .
                    $this->tbl_users . '.usr_username, ' .
                    $this->tbl_users . '.usr_appdownloadlink, ' .
                    $this->tbl_users . '.usr_email, ' .
                    $this->tbl_users . '.usr_first_name, ' .
                    $this->tbl_users . '.usr_last_name, ' .
                    $this->tbl_users . '.usr_active, ' .
                    $this->tbl_users . '.usr_can_auto_assign, ' .
                    $this->tbl_users . '.usr_resigned, ' .
                    $this->tbl_users . '.usr_resigned_date, ' .
                    $this->tbl_users . '.usr_rejoined_on, ' .
                    $this->tbl_users . '.usr_resigned_reason, ' .
                    $this->tbl_users . '.usr_resigned_remarks, ' .
                    $this->tbl_users_groups . '.group_id as group_id, ' .
                    $this->tbl_groups . '.name as group_name, ' .
                    $this->tbl_groups . '.description as group_desc, ' .
                    $this->tbl_showroom . '.*, tl.usr_username AS teamLead, ' .
                    $this->tbl_designation . '.desig_title, ' .
                    '(SELECT COUNT(' . $this->tbl_app_download_ref . '.adr_user_id) FROM ' . $this->tbl_app_download_ref . ' WHERE ' . $this->tbl_app_download_ref . '.adr_user_id = ' . $this->tbl_users . '.usr_id) as download_count'
          )
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'LEFT')
               ->join($this->tbl_users . ' tl', 'tl.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->order_by($this->tbl_users . '.usr_active', 'DESC')->get($this->tbl_users)->result_array();

          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }

     function totalRecords($postDatas, $filterDatas)
     {
          $searchValue = $postDatas['search']['value']; // Search value
          $showroom = get_logged_user('usr_showroom');

          if ($this->usr_grp == 'MG') { // Manager
               $this->db->where($this->tbl_users . '.usr_showroom', $showroom);
               $this->db->where_in($this->tbl_groups . '.grp_slug', array('AC', 'TL', 'DE', 'SE', 'OS'));
          }

          if ($this->usr_grp == 'DE') { // Data entry
               $this->db->where($this->tbl_users . '.usr_active', 1);
               $this->db->where($this->tbl_users . '.usr_showroom', $showroom);
               $this->db->where_in($this->tbl_groups . '.grp_slug', array('DE', 'SE', 'OS'));
          }

          $this->db->where($this->tbl_users . '.usr_id !=', 1);
          $this->db->where($this->tbl_users . ".usr_username != ''");


          if (!empty($searchValue)) {

               $this->db->where("(" . $this->tbl_users . ".usr_username LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_email LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_users . ".usr_first_name LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_last_name LIKE '%" .
                    $searchValue . "%' OR tl.usr_username LIKE '%" . $searchValue . "%' OR " . $this->tbl_users . ".usr_emp_code LIKE '%" . $searchValue . "%') ");
          }

          if (isset($filterDatas['desig']) && ($filterDatas['desig'] > 0)) {
               $this->db->where(array($this->tbl_users . '.usr_designation_new' => $filterDatas['desig']));
          }
          if (isset($filterDatas['division']) && ($filterDatas['division'] > 0)) {
               $this->db->where(array($this->tbl_users . '.usr_showroom' => $filterDatas['division']));
          }
          if (isset($filterDatas['showroom']) && ($filterDatas['showroom'] > 0)) {
               $this->db->where(array($this->tbl_users . '.usr_showroom' => $filterDatas['showroom']));
          }

          if (isset($filterDatas['resigned']) && ($filterDatas['resigned'] != '')) {
               $this->db->where(array($this->tbl_users . '.usr_resigned' => $filterDatas['resigned']));
          }
          $this->db->select('COUNT(*) as count')
               ->from($this->tbl_users)
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
               ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id', 'LEFT')
               ->join($this->tbl_users . ' tl', 'tl.usr_id = ' . $this->tbl_users . '.usr_tl', 'LEFT');

          $result = $this->db->get()->row_array();
          return $result['count'];
     }
}
