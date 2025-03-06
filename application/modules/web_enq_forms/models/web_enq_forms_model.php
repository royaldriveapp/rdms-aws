<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class web_enq_forms_model extends CI_Model
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
               //->where('(' . $this->tbl_groups . ".grp_slug = 'SE' OR " . $this->tbl_groups . ".grp_slug = 'DE' OR " . $this->tbl_groups . ".grp_slug = 'TL' OR " . $this->tbl_groups . ".grp_slug = 'EV')")
               ->where('(usr_designation_new = 100 OR usr_designation_new = 37 OR usr_designation_new = 20 OR usr_designation_new = 36 OR usr_designation_new = 59
               OR usr_designation_new = 11)')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_can_auto_assign' => 1))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->get($this->tbl_users)->result_array();
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
               ->where('(usr_designation_new = 100 OR usr_designation_new = 37 OR usr_designation_new = 20 OR usr_designation_new = 36 OR usr_designation_new = 59)')
               ->order_by($this->tbl_users . '.usr_first_name')->get($this->tbl_users)->result_array();
     }
     function staffFellowship()
     {
          return $this->db->select(
               array(
                    // $this->tbl_users . '.*'
                    $this->tbl_users . '.usr_id',
                    $this->tbl_users . '.usr_first_name',
                    $this->tbl_users . '.usr_username',
                    $this->tbl_users . '.usr_last_name',
                    $this->tbl_users . '.usr_mobile_personal',
                    $this->tbl_users . '.usr_tl',
                    // $this->tbl_users_groups . '.group_id as group_id',
                    // $this->tbl_groups . '.name as group_name',
                    // $this->tbl_groups . '.description as group_desc',
                    // $this->tbl_showroom . '.*'
               )
          )
               // ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               // ->join($this->tbl_groups, $this->tbl_users_groups . '.group_id = ' . $this->tbl_groups . '.id')
               // ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               // ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->where('(usr_designation_new = 117)')
               //->where('usr_designation_new',117)
               ->order_by($this->tbl_users . '.usr_first_name')->get($this->tbl_users)->result_array();
     }
     function getValData()
     {
          return $this->db->select("`{$this->tbl_valuation}`.`val_id`, `{$this->tbl_valuation}`.`val_veh_no`") //
               ->get($this->tbl_valuation)
               ->result_array();
     }
     function getMou()
     {
          $data = $this->db->select("`{$this->tbl_mou_master}`.`moum_number`, `{$this->tbl_mou_master}`.`moum_reg_num`, `{$this->tbl_mou_master}`.`moum_adv_token`") //
               ->get($this->tbl_mou_master)
               ->result_array();
          return $data;
     }

     function getData($id)
     {
          //  $fields = $this->db->list_fields('web_enq_users');
          //debug( $fields);
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
               "DATE_FORMAT(" . $this->tbl_web_enquiry . ".web_created_at, '%d-%m-%Y') AS web_created_at",
               $this->tbl_web_enquiry . '.web_rdms_enq_id',
               $this->tbl_web_enquiry . '.web_enq_type',
               $this->tbl_web_enquiry . '.web_address',
               'addeddBy.web_usr_name AS added_usr_username',
               'addeddBy.web_usr_phone AS web_usr_phone',
               'addeddBy.web_usr_email AS web_usr_email',
               'occuCat.occ_cat_name AS occ_cat_name',
               'occupation.occ_name AS occ_name',
               'district.std_district_name AS std_district_name',
               //'man.webman_type',
          );


          $this->db->where('web_id', $id);
          $data['master'] = $this->db->select($selArray) //
               ->join($this->tbl_web_enq_users . ' addeddBy', 'addeddBy.web_usr_master_id = ' . $this->tbl_web_enquiry . '.web_id', 'left')
               ->join($this->tbl_occupation_category . ' occuCat', 'occuCat.occ_cat_id = ' . $this->tbl_web_enquiry . '.web_occupation_cat', 'left')
               ->join($this->tbl_occupation . ' occupation', 'occupation.occ_id = ' . $this->tbl_web_enquiry . '.web_occupation', 'left')
               ->join($this->tbl_district_statewise . ' district', 'district.std_id = ' . $this->tbl_web_enquiry . '.web_district', 'left')
               ->get($this->tbl_web_enquiry)
               ->row_array();
          // echo $this->db->last_query(); exit;
          //return $data;
          $data['money'] = $this->getMan($id, 'money');
          $data['need'] = $this->getMan($id, 'need');
          $data['authority'] = $this->getMan($id, 'authority');
          $data['phone_numbers'] = $this->getPhone($id);
          $data['family'] = $this->getFamily($id);
          $eng_type = $data['master']['web_enq_type'];
          if ($eng_type == 1) {
               //sales
               $data['pitchedVeh'] = $this->getpitchedVeh($id);
               $data['assoVeh'] = $this->getAssoVeh($id);
          } elseif ($eng_type == 2) {
               //purchase
               $data['assoVeh'] = $this->getAssoVeh($id);
               $data['purchaseVeh'] = $this->getPurchaseVeh($id);
          } elseif ($eng_type == 3) {
               //exchange
               $data['pitchedVeh'] = $this->getpitchedVeh($id);
               $data['assoVeh'] = $this->getAssoVeh($id);
               $data['purchaseVeh'] = $this->getPurchaseVeh($id);
          } else {
               //rd care
               $data['assoVeh'] = $this->getAssoVeh($id);
               $data['rfDetails'] = $this->getRf($id);
          }
          return $data;
     }

     function getMan($id, $type)
     {
          $selArray = array(
               $this->tbl_web_enquiry_man . '.webman_id',
               $this->tbl_web_enquiry_man . '.webman_master_id',
               $this->tbl_web_enquiry_man . '.webman_name',
               $this->tbl_web_enquiry_man . '.webman_phone',
               $this->tbl_web_enquiry_man . '.webman_relation',
               $this->tbl_web_enquiry_man . '.webman_remarks',
          );

          $this->db->where('webman_master_id', $id);
          $this->db->where('webman_type', $type);
          return $this->db->select($selArray) //
               ->get($this->tbl_web_enquiry_man)
               ->row_array();
     }
     function getPhone($id)
     {
          $selArray = array(
               $this->tbl_web_enquiry_phone . '.webph_id ',
               $this->tbl_web_enquiry_phone . '.webph_master_id',
               $this->tbl_web_enquiry_phone . '.webph_phone',
          );

          $this->db->where('webph_master_id', $id);
          return $this->db->select($selArray) //
               ->get($this->tbl_web_enquiry_phone)
               ->result_array();
     }
     function getFamily($id)
     {
          $selArray = array(
               $this->tbl_web_enq_family_details . '.web_fml_id',
               $this->tbl_web_enq_family_details . '.web_fml_name',
               $this->tbl_web_enq_family_details . '.web_fml_relation',
               $this->tbl_web_enq_family_details . '.web_fml_occu',
               $this->tbl_web_enq_family_details . '.web_fml_age',
          );

          $this->db->where('web_fml_master_id', $id);
          return $this->db->select($selArray) //
               ->get($this->tbl_web_enq_family_details)
               ->result_array();
     }

     function getpitchedVeh($id)
     {
          $selArray = array(
               $this->tbl_web_enq_pitched_veh . '.web_pi_id',
               $this->tbl_web_enq_pitched_veh . '.web_pi_brand',
               $this->tbl_web_enq_pitched_veh . '.web_pi_model',
               $this->tbl_web_enq_pitched_veh . '.web_pi_variant',
               $this->tbl_web_enq_pitched_veh . '.web_pi_budget',
               $this->tbl_web_enq_pitched_veh . '.web_pi_ownership',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_price_range . '.pr_range',
          );

          $this->db->where('web_pi_master_id', $id);
          $this->db->select($selArray);
          $this->db->join($this->tbl_brand, "{$this->tbl_brand}.brd_id = {$this->tbl_web_enq_pitched_veh}.web_pi_brand", 'left');
          $this->db->join($this->tbl_model, "{$this->tbl_model}.mod_id = {$this->tbl_web_enq_pitched_veh}.web_pi_model", 'left');
          $this->db->join($this->tbl_variant, "{$this->tbl_variant}.var_id = {$this->tbl_web_enq_pitched_veh}.web_pi_variant", 'left');
          $this->db->join($this->tbl_price_range, "{$this->tbl_price_range}.pr_id = {$this->tbl_web_enq_pitched_veh}.web_pi_budget", 'left');
          $data = $this->db->get($this->tbl_web_enq_pitched_veh)->result_array();
          return $data;
     }

     function getAssoVeh($id)
     {
          $selArray = array(
               $this->tbl_web_enq_veh_associated_with_customer . '.web_asso_id',
               $this->tbl_web_enq_veh_associated_with_customer . '.web_asso_brand',
               $this->tbl_web_enq_veh_associated_with_customer . '.web_asso_model',
               $this->tbl_web_enq_veh_associated_with_customer . '.web_asso_variant',
               $this->tbl_web_enq_veh_associated_with_customer . '.web_asso_reg_no',
               "DATE_FORMAT(" . $this->tbl_web_enq_veh_associated_with_customer . ".web_asso_insurance_validity, '%d-%m-%Y') AS web_asso_insurance_validity",
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
          );

          $this->db->where('web_asso_master_id', $id);
          $this->db->select($selArray);
          $this->db->join($this->tbl_brand, "{$this->tbl_brand}.brd_id = {$this->tbl_web_enq_veh_associated_with_customer}.web_asso_brand", 'left');
          $this->db->join($this->tbl_model, "{$this->tbl_model}.mod_id = {$this->tbl_web_enq_veh_associated_with_customer}.web_asso_model", 'left');
          $this->db->join($this->tbl_variant, "{$this->tbl_variant}.var_id = {$this->tbl_web_enq_veh_associated_with_customer}.web_asso_variant", 'left');
          $data = $this->db->get($this->tbl_web_enq_veh_associated_with_customer)->result_array();
          return $data;
     }

     function getPurchaseVeh($id)
     {
          $selArray = array(
               $this->tbl_web_enq_purchase_veh . '.web_purch_id',
               $this->tbl_web_enq_purchase_veh . '.web_purch_brand',
               $this->tbl_web_enq_purchase_veh . '.web_purch_model',
               $this->tbl_web_enq_purchase_veh . '.web_purch_variant',
               $this->tbl_web_enq_purchase_veh . '.web_purch_ownersip',
               $this->tbl_web_enq_purchase_veh . '.web_purch_insurance_comp',
               "DATE_FORMAT(" . $this->tbl_web_enq_purchase_veh . ".web_purch_insurance_validity, '%d-%m-%Y') AS web_purch_insurance_validity",
               $this->tbl_web_enq_purchase_veh . '.web_purch_license_plate',
               $this->tbl_web_enq_purchase_veh . '.web_purch_km',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
          );

          $this->db->where('web_purch_master_id', $id);
          $this->db->select($selArray);
          $this->db->join($this->tbl_brand, "{$this->tbl_brand}.brd_id = {$this->tbl_web_enq_purchase_veh}.web_purch_brand", 'left');
          $this->db->join($this->tbl_model, "{$this->tbl_model}.mod_id = {$this->tbl_web_enq_purchase_veh}.web_purch_model", 'left');
          $this->db->join($this->tbl_variant, "{$this->tbl_variant}.var_id = {$this->tbl_web_enq_purchase_veh}.web_purch_variant", 'left');
          $data = $this->db->get($this->tbl_web_enq_purchase_veh)->result_array();
          return $data;
     }
     function getRf($id)
     {
          $selArray = array(
               $this->tbl_web_enq_refurb_jobs . '.web_rf_id',
               $this->tbl_web_enq_refurb_jobs . '.web_rf_details',
          );

          $this->db->where('web_rf_master_id', $id);
          return $this->db->select($selArray) //
               ->get($this->tbl_web_enq_refurb_jobs)
               ->result_array();
     }






     function getDataPaginate($postDatas, $filterDatas)
     {
          $mystaffs = array();
          if (check_permission('web_enq_forms', 'my_staff')) {
               // $mystaffs = my_staff($this->uid);
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
          //$totalRecords = $this->getTotal($searchValue,$filterDatas);

          if (check_permission('web_enq_forms', 'show_all')) {
          } else if (check_permission('web_enq_forms', 'my_staff')) {
               // $this->db->where_in($this->tbl_web_enquiry . '.web_assign_to', $mystaffs);
               $this->db->where_in('addeddBy.web_usr_phone', $mystaffs);
          } elseif (check_permission('web_enq_forms', 'my_leads')) {
               $this->db->where($this->tbl_web_enquiry . '.web_assign_to', $this->uid);
          }
          $this->db->where($this->tbl_web_enquiry . '.web_rdms_enq_id', 0);
          // Applying the filter condition if 'staff' is set in filterDatas
          if (isset($filterDatas['staff']) && !empty($filterDatas['staff'])) {
               $staffPhones = implode(',', $filterDatas['staff']);
               $this->db->where('addeddBy.web_usr_phone IN (' . $staffPhones . ')');
          }

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
               "DATE_FORMAT(" . $this->tbl_web_enquiry . ".web_created_at, '%d-%m-%Y') AS web_created_at",
               $this->tbl_web_enquiry . '.web_rdms_enq_id',
               $this->tbl_web_enquiry . '.web_enq_type',
               $this->tbl_web_enquiry . '.web_address',
               'addeddBy.web_usr_name AS added_usr_username',
               'web_enquiry_phone.webph_phone'
          );

          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          if (isset($filterDatas['category']) && !empty($filterDatas['category'])) {
               if ($filterDatas['category'] == 1) { //Assigned
                    $this->db->where('web_assign_to > 0');
               } else if ($filterDatas['category'] == 2) { //Pending to Assign
                    $this->db->where('web_assign_to = 0');
               }
          }
          $data = $this->db->select($selArray)
               ->join($this->tbl_web_enq_users . ' as addeddBy', 'addeddBy.web_usr_master_id = ' . $this->tbl_web_enquiry . '.web_id', 'left')
               ->join('web_enquiry_phone', 'web_enquiry_phone.webph_master_id = ' . $this->tbl_web_enquiry . '.web_id', 'left')
               ->group_by($this->tbl_web_enquiry . '.web_id') // Fetch only one record per enquiry
               ->order_by($this->tbl_web_enquiry . '.web_id', 'DESC')
               ->get($this->tbl_web_enquiry)->result_array();

          /*ids and count  */

          if (check_permission('web_enq_forms', 'show_all')) {
               // Show all
          } else if (check_permission('web_enq_forms', 'my_staff')) {
               // $this->db->where_in($this->tbl_web_enquiry . '.web_assign_to', $mystaffs);
               $this->db->where_in('addeddBy.web_usr_phone', $mystaffs);
          } elseif (check_permission('web_enq_forms', 'my_leads')) {
               $this->db->where($this->tbl_web_enquiry . '.web_assign_to', $this->uid);
          }
          //$id = $this->db->select($this->tbl_web_enquiry . '.web_id')->where($this->tbl_web_enquiry . '.web_rdms_enq_id', 0)->get($this->tbl_web_enquiry)->result_array();
          if (isset($filterDatas['staff']) && !empty($filterDatas['staff'])) {
               $staffPhones = implode(',', $filterDatas['staff']);
               $this->db->where('addeddBy.web_usr_phone IN (' . $staffPhones . ')');
          }
          if (!empty($searchValue)) {
               $this->db->where('(' . implode(" OR ", $search) . ')');
          }
          $this->db->where($this->tbl_web_enquiry . '.web_rdms_enq_id', 0);
          if (isset($filterDatas['category']) && !empty($filterDatas['category'])) {
               if ($filterDatas['category'] == 1) { //Assigned
                    $this->db->where('web_assign_to > 0');
               } else if ($filterDatas['category'] == 2) { //Pending to Assign
                    $this->db->where('web_assign_to = 0');
               }
          }
          $id = $this->db->select($this->tbl_web_enquiry . '.web_id')
               ->join($this->tbl_web_enq_users . ' as addeddBy', 'addeddBy.web_usr_master_id = ' . $this->tbl_web_enquiry . '.web_id', 'left')
               ->join('web_enquiry_phone', 'web_enquiry_phone.webph_master_id = ' . $this->tbl_web_enquiry . '.web_id', 'left')
               ->group_by($this->tbl_web_enquiry . '.web_id') // Fetch only one record per enquiry
               ->order_by($this->tbl_web_enquiry . '.web_id', 'DESC')
               ->get($this->tbl_web_enquiry)->result_array();
          $totalRecords = count($id);
          /*End ids and count  */
          //debug($totalRecords);
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data,
               'id' => implode(',', array_column($id, 'web_id'))
          );
          return $response;
     }

     function getTotal($searchValue)
     {


          if (check_permission('web_enq_forms', 'show_all')) {
          } else if (check_permission('web_enq_forms', 'my_staff')) {
               $mystaffs = my_staff($this->uid);
               $this->db->where_in($this->tbl_web_enquiry . '.web_assign_to', $mystaffs);
          } elseif (check_permission('web_enq_forms', 'my_leads')) {
               $this->db->where($this->tbl_web_enquiry . '.web_assign_to', $this->uid);
          }
          if (isset($filterDatas['staff']) && !empty($filterDatas['staff'])) {
               $staffPhones = implode(',', $filterDatas['staff']);
               $this->db->where('addeddBy.web_usr_phone IN (' . $staffPhones . ')');
          }
          $this->db->where($this->tbl_web_enquiry . '.web_rdms_enq_id', 0);
          $this->db->from($this->tbl_web_enquiry);
          return $this->db->count_all_results();
     }


     public function addToReg($get)
     {
          // Retrieve data and initialize variables
          $allData = $this->getData($get['web_id']);
          $data = $allData['master'];
          $regMaster = array();

          // Populate $regMaster array with data from $allData and other sources
          $regMaster['vreg_brand'] = 0;
          $regMaster['vreg_model'] = 0;
          $regMaster['vreg_varient'] = 0;
          if ($data['web_enq_type'] == 1 && !empty($allData['pitchedVeh'])) {

               $regMaster['vreg_brand'] =  $allData['pitchedVeh'][0]['web_pi_brand'];
               $regMaster['vreg_model'] = $allData['pitchedVeh'][0]['web_pi_model'];
               $regMaster['vreg_varient'] = $allData['pitchedVeh'][0]['web_pi_variant'];
          } elseif ($data['web_enq_type'] == 2 && !empty($allData['purchaseVeh'])) {

               $regMaster['vreg_brand'] =  $allData['purchaseVeh'][0]['web_purch_brand'];
               $regMaster['vreg_model'] = $allData['purchaseVeh'][0]['web_purch_model'];
               $regMaster['vreg_varient'] = $allData['purchaseVeh'][0]['web_purch_variant'];
               $regMaster['vreg_km'] = $allData['purchaseVeh'][0]['web_purch_km'];
          } elseif ($data['web_enq_type'] == 3 && !empty($allData['pitchedVeh'])) {

               $regMaster['vreg_brand'] =  $allData['pitchedVeh'][0]['web_pi_brand'];
               $regMaster['vreg_model'] = $allData['pitchedVeh'][0]['web_pi_model'];
               $regMaster['vreg_varient'] = $allData['pitchedVeh'][0]['web_pi_variant'];
          }
          $regMaster['vreg_is_verified'] = 1;
          $regMaster['vreg_verified_by'] = $this->uid;

          $assignedTo = (isset($get['vreg_assigned_to']) && !empty($get['vreg_assigned_to'])) ? $get['vreg_assigned_to'] : $this->uid;
          $regMaster['vreg_inquiry'] =  0;
          $regMaster['vreg_status'] = 1;
          $regMaster['vreg_is_punched'] = 0;

          $regMaster['vreg_showroom'] = (isset($get['vreg_showroom']) && !empty($get['vreg_showroom'])) ? $get['vreg_showroom'] : $this->shrm;
          $regMaster['vreg_department'] = (isset($get['vreg_department']) && !empty($get['vreg_department'])) ? $get['vreg_department'] : 0;
          $regMaster['vreg_division'] = (isset($get['vreg_division']) && !empty($get['vreg_division'])) ? $get['vreg_division'] : 0;
          $regMaster['vreg_customer_status'] = (isset($get['vreg_customer_status']) && !empty($get['vreg_customer_status'])) ? $get['vreg_customer_status'] : 0;
          $regMaster['vreg_added_by'] = $this->uid;
          $regMaster['vreg_added_on'] = date('Y-m-d H:i:s'); //h-> H added on 03-12-2020 06:00 AM
          // $regMaster['vreg_entry_date'] = date('Y-m-d', strtotime($data['web_created_at']));
          $regMaster['vreg_entry_date'] = date('Y-m-d H:i:s');
          $regMaster['vreg_cust_name'] = isset($data['web_name']) ? $data['web_name'] : '';
          //$regMaster['vreg_assigned_to'] = (empty($oldEnqSEId)) ? $assignedTo : $oldEnqSEId;
          $regMaster['vreg_source_branch'] = $this->shrm;
          $regMaster['vreg_web_enq_id '] = isset($data['web_id']) ? $data['web_id'] : '';
          $regMaster['vreg_contact_mode '] = isset($data['web_source_of_enq']) ? $data['web_source_of_enq'] : '';
          $regMaster['vreg_address'] = isset($data['web_address']) ? $data['web_address'] : '';
          //$regMaster['vreg_address'] = isset($data['web_address']) ? $data['web_address'] : '';
          $regMaster['vreg_email'] = isset($data['web_email']) ? $data['web_email'] : '';
          if (!empty($allData['phone_numbers'])) {
               $regMaster['vreg_cust_phone'] =  $allData['phone_numbers'][0]['webph_phone'];
          }
          $regMaster['vreg_whatsapp '] = isset($data['web_whatsapp']) ? $data['web_whatsapp'] : 0;
          $regMaster['vreg_district'] = isset($data['web_district']) ? $data['web_district'] : '';
          $regMaster['vreg_customer_remark'] = isset($data['web_remarks']) ? $data['web_remarks'] : '';
          $regMaster['vreg_occupation'] = $data['occ_cat_name'] . '/' . $data['occ_name'];

          // Insert record into cpnl_register_master table
          $insertData = array_filter($regMaster);
          //  debug($insertData);
          $insertSuccess = $this->db->insert($this->tbl_register_master, $insertData);

          if ($insertSuccess) {
               $id = $this->db->insert_id();

               // Update web_enquiry table with web_rdms_reg_id
               $this->db->where('web_id', $get['web_id']);
               $updateSuccess = $this->db->update('web_enquiry', array('web_rdms_reg_id' => $id));

               if ($updateSuccess) {
                    // Add entry to register history and generate log
                    $this->addRegisterHistory(array(
                         'regh_register_master' => $id,
                         'regh_assigned_by' => $this->uid,
                         'regh_assigned_to' =>  $assignedTo,
                         'regh_remarks' =>  $regMaster['vreg_customer_remark'],
                         'regh_system_cmd' => 'Register punched sales department',
                         'regh_contact_mode' => isset($regMaster['vreg_contact_mode ']) ?  $regMaster['vreg_contact_mode ']  : 0
                    ));
                    generate_log(array(
                         'log_title' => 'Web enq form - vehicle registration ',
                         'log_desc' => serialize($allData),
                         'log_controller' => 'new-quick-register',
                         'log_action' => 'C',
                         'log_ref_id' => $id,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    // Log successful registration
                    log_message('info', 'New record inserted into cpnl_register_master. ID: ' . $id);

                    // Return true upon successful registration
                    return true;
               } else {
                    // Log error if update fails
                    log_message('error', 'Failed to update web_enquiry table with web_rdms_reg_id: ' . $id);

                    // Rollback insertion if update fails
                    $this->db->where('vreg_id', $id);
                    $this->db->delete($this->tbl_register_master);

                    // Return false
                    return false;
               }
          } else {
               // Log error if insertion fails
               log_message('error', 'Failed to insert record into cpnl_register_master table.');

               // Return false
               return false;
          }
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
     function deleteRecord($web_id)
     {
          log_message('debug', 'Deleting record with Web ID: ' . $web_id); // Debug log
          $result = $this->db->delete($this->tbl_web_enquiry, ['web_id' => $web_id]);
          log_message('debug', 'Delete result: ' . $this->db->affected_rows()); // Debug log
          return $result;
     }

     function assignToStaff($webIDs, $staff, $desc)
     { // debug($staff);
          //  debug($webIDs);
          $date = date('Y-m-d H:i:s');
          $this->db->where($webIDs)->update($this->tbl_web_enquiry, array('web_assign_to' => $staff, 'web_assign_by' => $this->uid, 'web_assign_on' => $date, 'web_assign_cmd' => $desc));
     }

     public function list_by_staff()
     {
          $web_usr_phone = $this->input->get('satffs_phone');

          if (empty($web_usr_phone)) {
               show_404();
          }

          // Pagination settings
          $limit = 3; // Number of records per page
          $page = $this->input->get('page') ? $this->input->get('page') : 1; // Get the current page number
          $offset = ($page - 1) * $limit; // Calculate offset

          // Select data with limit, offset, and order by web_id descending
          $this->db->select('web_enquiry.*, web_enq_users.web_usr_phone, web_enquiry_phone.webph_phone');
          $this->db->from('web_enquiry');
          $this->db->join('web_enquiry_phone', 'web_enquiry_phone.webph_master_id = web_enquiry.web_id', 'left');
          $this->db->join('web_enq_users', 'web_enq_users.web_usr_master_id = web_enquiry.web_id', 'left');
          $this->db->where('web_enq_users.web_usr_phone', $web_usr_phone);
          $this->db->group_by('web_enquiry.web_id'); // Fetch only one record per enquiry
          $this->db->order_by('web_enquiry.web_id', 'DESC'); // Order by web_id descending
          $this->db->limit($limit, $offset); // Apply pagination

          $query = $this->db->get();
          $result = $query->result_array();

          // Count total number of records
          $this->db->select('COUNT(DISTINCT web_enquiry.web_id) as count', FALSE);
          $this->db->from('web_enquiry');
          $this->db->join('web_enquiry_phone', 'web_enquiry_phone.webph_master_id = web_enquiry.web_id', 'left');
          $this->db->join('web_enq_users', 'web_enq_users.web_usr_master_id = web_enquiry.web_id', 'left');
          $this->db->where('web_enq_users.web_usr_phone', $web_usr_phone);

          $total_rows = $this->db->get()->row()->count;

          // Prepare response data including pagination information
          $response = array(
               'total_rows' => $total_rows,
               'total_pages' => ceil($total_rows / $limit),
               'current_page' => $page,
               'data' => $result
          );

          echo json_encode($response);
     }

     function validate($req)
     {
          if (!empty($req)) {
               // debug($data);
               $data['web_status'] = $req['validate'];
               $data['web_status_cmd'] = $req['remarks'];
               $data['web_validated_by'] = $this->uid;
               $data['web_validated_on'] = date('Y-m-d H:i:s');
               $id = $req['web_id'];
               //debug($data);
               $this->db->where('web_id', $id);

               if ($this->db->update($this->tbl_web_enquiry, $data)) {
                    generate_log(array(
                         'log_title' => 'Update fellowship Validation ' . date('Y-m-d H:i:s'),
                         'log_desc' => serialize($data),
                         'log_controller' => 'fellowship validation',
                         'log_action' => 'U',
                         'log_ref_id' => $id,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    return true;
               } else {
                    generate_log(array(
                         'log_title' => 'Update fellowship Validation ' . date('Y-m-d H:i:s'),
                         'log_desc' => 'Error on update',
                         'log_controller' => 'fellowship validation',
                         'log_action' => 'U',
                         'log_ref_id' => $id,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    return false;
               }
          } else {
               return false;
          }
     }

     function getDistricts($state = '')
     {
          if ($state) {
               //return $this->db->get($this->tbl_district_statewise)->result_array();
               //  return $this->db->where_in($this->tbl_district_statewise . '.std_state', $state)->get($this->tbl_district_statewise)->result_array();
               return $this->db->where('std_state', $state)->get($this->tbl_district_statewise)->result_array();
          }
     }
     public function updateFellowship($postData)
     {
          // Extract and unset data if set
          //     $pitchedData = !empty($postData['pitched']) ? $postData['pitched'] : null;
          //     $assocData = !empty($postData['assoc']) ? $postData['assoc'] : null;
          //     $familyData = !empty($postData['family']) ? $postData['family'] : null;

          //unset($postData['pitched'], $postData['assoc'], $postData['family']);
          //debug($postData);
          // Insert common data and get the masterId
          $resp = $this->UpdateCommonData($postData);

          //     if ($masterId) {
          //         if ($pitchedData) {
          //             $this->insertPitchedData($pitchedData, $masterId);
          //         }
          //         if ($assocData) {
          //             $this->insertAssocData($assocData, $masterId);
          //         }
          //         if ($familyData) {
          //             $this->insertfamilyData($familyData, $masterId);
          //         }

          //         return true;
          //     }
          // Error
          return $resp;
     }



     public function UpdateCommonData($postData)
     {
          // Update 'web_enquiry' master table
          $enquiryData = array(
               'web_category' => $postData['category'],
               // 'web_source_of_enq' => !empty($postData['enq-source']) ? $postData['enq-source'] : 0,
               'web_name' => $postData['name'],
               'web_gender' => $postData['gender'],
               'web_email' => $postData['email'],
               'web_insta' => $postData['instagram'],
               'web_youtube' => $postData['youtube_channel'],
               'web_fb' => $postData['fb'],
               'web_twitter' => $postData['twitter'],
               'web_linkedin' => $postData['linkedin'],
               'web_whatsapp' => $postData['whats_app'],
               'web_pin' => !empty($postData['pin']) ? $postData['pin'] : null,
               'web_district' => $postData['district'],
               'web_address' => $postData['address'],
               //    'web_occupation_cat' => !empty($postData['occupation_cat']) ? $postData['occupation_cat'] : null,
               //    'web_occupation' => $postData['occupation'],
               //    'web_company_website' => $postData['company_website'],
               //    'web_remarks' => $postData['remarks'],
               //    'web_enq_type' => $postData['web_enq_type']
          );

          // Update the record in 'web_enquiry' table
          $this->db->where('web_id', $postData['web_id']);
          if (!$this->db->update('web_enquiry', $enquiryData)) {
               return false; // Return false if update fails
          }

          // Update phone numbers in 'web_enquiry_phone' table
          if (!empty($postData['phone_no'])) {
               $phoneNumbers = $postData['phone_no'];
               $phoneIds = $postData['phone_id']; // IDs of phone numbers

               // Get existing phone numbers from the database
               $this->db->where('webph_master_id', $postData['web_id']);
               $existingPhones = $this->db->get('web_enquiry_phone')->result_array();
               $existingPhoneIds = array_column($existingPhones, 'webph_id');

               // Delete phone numbers that are not in the submitted data

               // Insert or update phone numbers
               foreach ($phoneNumbers as $index => $phoneNumber) {
                    $phoneData = array(
                         'webph_master_id' => $postData['web_id'],
                         'webph_phone' => $phoneNumber,
                         'webph_created_at' => date('Y-m-d H:i:s')
                    );

                    // Check if phone ID exists, if so, update, otherwise insert
                    if (!empty($phoneIds[$index])) {
                         $this->db->where('webph_id', $phoneIds[$index]);
                         if (!$this->db->update('web_enquiry_phone', $phoneData)) {
                              return false; // Return false if update fails
                         }
                    } else {
                         if (!$this->db->insert('web_enquiry_phone', $phoneData)) {
                              return false; // Return false if insert fails
                         }
                    }
               }
          } else {
               // If no phone numbers are provided, delete all associated phone numbers
               $this->db->where('webph_master_id', $postData['web_id']);
               $this->db->delete('web_enquiry_phone');
          }

          return true; // Return true if everything was successful
     }


     public function reinstatePhoneNumber($webph_master_id, $webph_phone, $webph_created_at)
     {
          // Prepare the data for insertion
          $phoneData = array(
               'webph_master_id' => $webph_master_id,
               'webph_phone' => $webph_phone,
               'webph_created_at' => $webph_created_at
          );

          // Insert the data into the 'web_enquiry_phone' table
          if ($this->db->insert('web_enquiry_phone', $phoneData)) {
               return true; // Return true if insertion is successful
          } else {
               return false; // Return false if insertion fails
          }
     }

     function analysis()
     {
          return $this->db->query("SELECT `web_assign_to`, " . $this->tbl_users . ".usr_username, count(*) AS total,
                    sum(case when `web_validated_by` = 0 then 1 else 0 end) AS pending,
                    sum(case when `web_validated_by` > 0 then 1 else 0 end) AS done
                    FROM " . $this->tbl_web_enquiry . "
                    LEFT JOIN cpnl_users ON " . $this->tbl_users . ".usr_id = " . $this->tbl_web_enquiry . ".web_assign_to
                    GROUP BY `web_assign_to`")->result_array();
     }
}
