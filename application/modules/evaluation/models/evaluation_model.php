<?php
if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class evaluation_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();

          $this->tbl_banks = TABLE_PREFIX . 'banks';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_company = TABLE_PREFIX . 'company';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_vendors = TABLE_PREFIX . 'vendors';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_insurers = TABLE_PREFIX . 'insurers';
          $this->tbl_statuses = TABLE_PREFIX . 'statuses';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_divisions = TABLE_PREFIX . 'divisions';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_valuation_status = TABLE_PREFIX . 'valuation_status';
          $this->tbl_vehicle_features = TABLE_PREFIX . 'vehicle_features';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->tbl_valuation_features = TABLE_PREFIX . 'valuation_features';
          $this->tbl_valuation_complaint = TABLE_PREFIX . 'valuation_complaint';
          $this->tbl_valuation_documents = TABLE_PREFIX . 'valuation_documents';
          $this->tbl_valuation_veh_images = TABLE_PREFIX . 'valuation_veh_images';
          $this->tbl_valuation_ful_bd_chkup = TABLE_PREFIX . 'valuation_ful_bd_chkup';
          $this->tbl_valuation_upgrade_details = TABLE_PREFIX . 'valuation_upgrade_details';
          $this->tbl_valuation_ful_bd_chkup_master = TABLE_PREFIX . 'valuation_ful_bd_chkup_master';
          $this->tbl_valuation_ful_bd_chkup_details = TABLE_PREFIX . 'valuation_ful_bd_chkup_details';
          $this->tbl_chklist_cat_item = TABLE_PREFIX . 'chklist_cat_item';
          $this->tbl_chklist_category = TABLE_PREFIX . 'chklist_category';
          $this->tbl_purchase_check_list = TABLE_PREFIX . 'purchase_check_list';
          $this->tbl_purchase_check_list_details = TABLE_PREFIX . 'purchase_check_list_details';
          $this->tbl_products = TABLE_PREFIX_RANA . 'products';
          $this->tbl_valuation_doc_history = TABLE_PREFIX . 'valuation_doc_history';
          $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
          $this->tbl_rto_office = TABLE_PREFIX . 'rto_office';
          $this->tbl_tyres_comp = TABLE_PREFIX . 'tyres_comp';
          $this->tbl_expence_type = TABLE_PREFIX . 'expence_type';
          $this->tbl_valuation_upgrade_master = TABLE_PREFIX . 'valuation_upgrade_master';
          $this->load->model('ihits_api/ihits_api_model', 'ihits');
     }

     function getExpenceType()
     {
          return $this->db->where(array('ven_status' => 1, 'ven_type' => 1))->order_by('ven_name')->get($this->tbl_vendors)->result_array();
     }

     function getAllBanks()
     {
          return $this->db->order_by('bnk_name')->get($this->tbl_banks)->result_array();
     }

     function getInsurers()
     {
          return $this->db->order_by('ins_insurer')->get($this->tbl_insurers)->result_array();
     }

     function evaluation_ajax($postDatas, $filterDatas)
     {
          $this->db->query('SET SQL_BIG_SELECTS=1');
          /*$draw = $postDatas['draw'];
            $row = $postDatas['start'];
            $rowperpage = $postDatas['length']; // Rows display per page
            $columnIndex = $postDatas['order'][0]['column']; // Column index
            $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
            $searchValue = $postDatas['search']['value']; // Search value*/

          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value

          $totalRecords = $this->db->count_all_results($this->tbl_valuation);

          //-----------------------------------------------------------------------------------------
          if (!empty($searchValue)) {
               $this->db->where("(val_veh_no LIKE '%" . $searchValue . "%' OR shr_location LIKE '%" . $searchValue . "%' OR "
                    . "brd_title LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%' OR enq_cus_name LIKE '%" . $searchValue . "%' OR enq_cus_mobile LIKE '%" . $searchValue . "%') 
                    OR (REPLACE(val_veh_no, '-', '') LIKE '%" . $searchValue . "%') OR val_stock_num LIKE '%" . $searchValue . "%'");
          }

          if (isset($filterDatas['status']) && ($filterDatas['status'] >= 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_status' => $filterDatas['status']));
          }
          if (isset($filterDatas['vreg_division']) && ($filterDatas['vreg_division'] > 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_division' => $filterDatas['vreg_division']));
          }
          if (isset($filterDatas['showroom']) && ($filterDatas['showroom'] > 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_showroom' => $filterDatas['showroom']));
          }
          if (isset($filterDatas['type']) && !empty($filterDatas['type'])) {
               $this->db->where_in($this->tbl_valuation . '.val_type', explode(',', $filterDatas['type']));
          }
          if (isset($filterDatas['enqStatus']) && !empty($filterDatas['enqStatus'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', $filterDatas['enqStatus']);
          }
          if (isset($filterDatas['val_brand']) && !empty($filterDatas['val_brand'])) {
               $this->db->where_in($this->tbl_valuation . '.val_brand', $filterDatas['val_brand']);
          }
          if (isset($filterDatas['val_model']) && !empty($filterDatas['val_model'])) {
               $this->db->where_in($this->tbl_valuation . '.val_model', $filterDatas['val_model']);
          }
          if (isset($filterDatas['val_variant']) && !empty($filterDatas['val_variant'])) {
               $this->db->where_in($this->tbl_valuation . '.val_variant', $filterDatas['val_variant']);
          }
          if (isset($filterDatas['val_evaluator']) && !empty($filterDatas['val_evaluator'])) {
               $this->db->where('(' . $this->tbl_valuation . '.val_evaluator IN (' . implode($filterDatas['val_evaluator'], ',') . ') OR ' .
                    $this->tbl_users . '.usr_id IN (' . implode($filterDatas['val_evaluator'], ',') . '))');
          }
          if (isset($filterDatas['val_sales_officer']) && !empty($filterDatas['val_sales_officer'])) {
               $this->db->where('(' . $this->tbl_valuation . '.val_sales_officer IN (' . implode($filterDatas['val_sales_officer'], ',') . ') OR ' .
                    $this->tbl_users . '.usr_id IN (' . implode($filterDatas['val_sales_officer'], ',') . '))');
          }
          $val_valuation_date_from = (isset($filterDatas['val_valuation_date_from']) && !empty($filterDatas['val_valuation_date_from'])) ?
               date('Y-m-d', strtotime($filterDatas['val_valuation_date_from'])) : '';

          $val_valuation_date_to = (isset($filterDatas['val_valuation_date_to']) && !empty($filterDatas['val_valuation_date_to'])) ?
               date('Y-m-d', strtotime($filterDatas['val_valuation_date_to'])) : '';

          if (!empty($val_valuation_date_from)) {
               //$this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) >=', $val_valuation_date_to);
               $this->db->where("(DATE(" . $this->tbl_valuation . ".val_valuation_date) >= '" . $val_valuation_date_from .  "' OR DATE(" . $this->tbl_valuation . ".val_added_date) >= '" . $val_valuation_date_from . "')");
          }
          if (!empty($val_valuation_date_to)) {
               //$this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) <=', $val_valuation_date_to);
               $this->db->where("(DATE(" . $this->tbl_valuation . ".val_valuation_date) <= '" . $val_valuation_date_to .  "' OR DATE(" . $this->tbl_valuation . ".val_added_date) <= '" . $val_valuation_date_to . "')");
          }
          $this->db->where('val_veh_no IS NOT NULL');
          $selArray = array(
               $this->tbl_valuation . '.val_id',
               $this->tbl_valuation . '.val_stock_num',
               'UPPER(' . $this->tbl_valuation . '.val_prt_1) AS val_prt_1',
               'UPPER(' . $this->tbl_valuation . '.val_prt_2) AS val_prt_2',
               'UPPER(' . $this->tbl_valuation . '.val_prt_3) AS val_prt_3',
               'UPPER(' . $this->tbl_valuation . '.val_prt_4) AS val_prt_4',
               "UPPER(val_veh_no) AS val_veh_no",
               $this->tbl_valuation . '.val_status',
               $this->tbl_valuation . '.val_type',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_valuation . '.val_fuel',
               $this->tbl_valuation . '.val_eng_cc',
               "(CASE WHEN " . $this->tbl_valuation . ".val_fuel = 1 THEN 'Petrol'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 2 THEN 'Diesel'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 3 THEN 'Gas'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 4 THEN 'Hybrid'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 5 THEN 'Electric'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 6 THEN 'CNG' END) AS fuel",
               "UPPER(DATE_FORMAT(" . $this->tbl_valuation . ".val_added_date, " . DATE_FORMAT_QRY_D . ")) AS val_added_date",
               "UPPER(DATE_FORMAT(" . $this->tbl_valuation . ".val_valuation_date, " . DATE_FORMAT_QRY_D . ")) AS val_valuation_date",
               $this->tbl_valuation . '.val_booking_status',
               $this->tbl_valuation . '.val_refurb_cost',
               $this->tbl_valuation . '.val_refurb_act_cost',
               $this->tbl_valuation . '.val_type',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_username',
               $this->tbl_showroom . '.shr_id',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_enquiry . '.enq_id',
               "UPPER(DATE_FORMAT(" . $this->tbl_enquiry . ".enq_entry_date, " . DATE_FORMAT_QRY_D . ")) AS enq_entry_date",
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_number',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_district_statewise . '.std_district_name',
               'evaluatedBy.usr_username AS evtr_usr_username',
               'val_book_sts.sts_title AS val_book_sts_title',
               'slsOfficer.usr_username AS so_usr_username, slsOfficer.usr_first_name AS so_usr_first_name',
               "UPPER(DATE_FORMAT(" . $this->tbl_purchase_check_list . ".pcl_created_at, " . DATE_FORMAT_QRY_D . ")) AS pcl_created_at",
               $this->tbl_vehicle_colors . '.vc_color',
               'val_sts.sts_title AS val_sts_title'
          );
          $totalRecordwithFilter = $this->db->select($selArray, false)
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
               ->join($this->tbl_users . ' evaluatedBy', 'evaluatedBy.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
               ->join($this->tbl_statuses . ' val_book_sts', 'val_book_sts.sts_value = ' . $this->tbl_valuation . '.val_booking_status', 'LEFT')
               ->join($this->tbl_users . ' slsOfficer', 'slsOfficer.usr_id = ' . $this->tbl_valuation . '.val_sales_officer', 'left')
               ->join($this->tbl_purchase_check_list, $this->tbl_purchase_check_list . '.pcl_val_id = ' . $this->tbl_valuation . '.val_id', 'left')
               ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_valuation . '.val_color', 'left')
               ->join($this->tbl_statuses . ' val_sts', 'val_sts.sts_value = ' . $this->tbl_valuation . '.val_status', 'LEFT')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'LEFT')
               ->count_all_results($this->tbl_valuation);

          //----------------------------------------------------------------------------------------
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }

          if (!empty($searchValue)) {
               $this->db->where("(val_veh_no LIKE '%" . $searchValue . "%' OR shr_location LIKE '%" . $searchValue . "%' OR "
                    . "brd_title LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%' OR enq_cus_name LIKE '%" . $searchValue . "%' OR enq_cus_mobile LIKE '%" . $searchValue . "%') 
                    OR (REPLACE(val_veh_no, '-', '') LIKE '%" . $searchValue . "%') OR val_stock_num LIKE '%" . $searchValue . "%'");
          }

          if (isset($filterDatas['status']) && ($filterDatas['status'] >= 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_status' => $filterDatas['status']));
          }
          if (isset($filterDatas['vreg_division']) && ($filterDatas['vreg_division'] > 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_division' => $filterDatas['vreg_division']));
          }
          if (isset($filterDatas['showroom']) && ($filterDatas['showroom'] > 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_showroom' => $filterDatas['showroom']));
          }
          if (isset($filterDatas['type']) && !empty($filterDatas['type'])) {
               $this->db->where_in($this->tbl_valuation . '.val_type', explode(',', $filterDatas['type']));
          }
          if (isset($filterDatas['enqStatus']) && !empty($filterDatas['enqStatus'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', $filterDatas['enqStatus']);
          }
          if (isset($filterDatas['val_brand']) && !empty($filterDatas['val_brand'])) {
               $this->db->where_in($this->tbl_valuation . '.val_brand', $filterDatas['val_brand']);
          }
          if (isset($filterDatas['val_model']) && !empty($filterDatas['val_model'])) {
               $this->db->where_in($this->tbl_valuation . '.val_model', $filterDatas['val_model']);
          }
          if (isset($filterDatas['val_variant']) && !empty($filterDatas['val_variant'])) {
               $this->db->where_in($this->tbl_valuation . '.val_variant', $filterDatas['val_variant']);
          }
          if (isset($filterDatas['val_evaluator']) && !empty($filterDatas['val_evaluator'])) {
               //$this->db->where_in($this->tbl_valuation . '.val_evaluator', $filterDatas['val_evaluator']);
               $this->db->where('(' . $this->tbl_valuation . '.val_evaluator IN (' . implode($filterDatas['val_evaluator'], ',') . ') OR ' .
                    $this->tbl_users . '.usr_id IN (' . implode($filterDatas['val_evaluator'], ',') . '))');
          }
          if (isset($filterDatas['val_sales_officer']) && !empty($filterDatas['val_sales_officer'])) {
               $this->db->where('(' . $this->tbl_valuation . '.val_sales_officer IN (' . implode($filterDatas['val_sales_officer'], ',') . ') OR ' .
                    $this->tbl_users . '.usr_id IN (' . implode($filterDatas['val_sales_officer'], ',') . '))');
          }
          if (!empty($val_valuation_date_from)) {
               //$this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) >=', $val_valuation_date_from);
               $this->db->where("(DATE(" . $this->tbl_valuation . ".val_valuation_date) >= '" . $val_valuation_date_from .  "' OR DATE(" . $this->tbl_valuation . ".val_added_date) >= '" . $val_valuation_date_from . "')");
          }
          if (!empty($val_valuation_date_to)) {
               //$this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) <=', $val_valuation_date_to);
               $this->db->where("(DATE(" . $this->tbl_valuation . ".val_valuation_date) <= '" . $val_valuation_date_to .  "' OR DATE(" . $this->tbl_valuation . ".val_added_date) <= '" . $val_valuation_date_to . "')");
          }
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          $this->db->where('val_veh_no IS NOT NULL');
          $data = $this->db->select($selArray)
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
               ->join($this->tbl_users . ' evaluatedBy', 'evaluatedBy.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
               ->join($this->tbl_statuses . ' val_book_sts', 'val_book_sts.sts_value = ' . $this->tbl_valuation . '.val_booking_status', 'LEFT')
               ->join($this->tbl_statuses . ' val_sts', 'val_sts.sts_value = ' . $this->tbl_valuation . '.val_status', 'LEFT')
               ->join($this->tbl_users . ' slsOfficer', 'slsOfficer.usr_id = ' . $this->tbl_valuation . '.val_sales_officer', 'left')
               ->join($this->tbl_purchase_check_list, $this->tbl_purchase_check_list . '.pcl_val_id = ' . $this->tbl_valuation . '.val_id', 'left')
               ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_valuation . '.val_color', 'left')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'LEFT')
               ->get($this->tbl_valuation)->result_array();
          //   if($this->uid == 100) {
          //        echo $this->db->last_query();
          //        debug($data);
          //   }
          //Data
          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;
     }

     function stock_ajax($postDatas, $filterDatas)
     {

          /*$draw = $postDatas['draw'];
            $row = $postDatas['start'];
            $rowperpage = $postDatas['length']; // Rows display per page
            $columnIndex = $postDatas['order'][0]['column']; // Column index
            $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
            $searchValue = $postDatas['search']['value']; // Search value*/

          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value
          $stsWhere = "(val_status = 39 OR val_status = 28 OR val_status = 13)";
          $totalRecords = $this->db->where($stsWhere)->where(array('val_booking_status' => 0))->count_all_results($this->tbl_valuation);

          //-----------------------------------------------------------------------------------------
          if (!empty($searchValue)) {
               $this->db->where("(val_veh_no LIKE '%" . $searchValue . "%' OR shr_location LIKE '%" . $searchValue . "%' OR "
                    . "brd_title LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%' OR enq_cus_name LIKE '%" .
                    $searchValue . "%' OR enq_cus_mobile LIKE '%" . $searchValue . "%')");
          }

          //   if (isset($filterDatas['status']) && ($filterDatas['status'] >= 0)) {
          //        $this->db->where(array($this->tbl_valuation . '.val_status' => $filterDatas['status']));
          //   }
          if (isset($filterDatas['vreg_division']) && ($filterDatas['vreg_division'] > 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_division' => $filterDatas['vreg_division']));
          }
          if (isset($filterDatas['showroom']) && ($filterDatas['showroom'] > 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_showroom' => $filterDatas['showroom']));
          }
          if (isset($filterDatas['type']) && !empty($filterDatas['type'])) {
               $this->db->where_in($this->tbl_valuation . '.val_type', explode(',', $filterDatas['type']));
          }
          if (isset($filterDatas['enqStatus']) && !empty($filterDatas['enqStatus'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', $filterDatas['enqStatus']);
          }
          if (isset($filterDatas['val_brand']) && !empty($filterDatas['val_brand'])) {
               $this->db->where_in($this->tbl_valuation . '.val_brand', $filterDatas['val_brand']);
          }
          if (isset($filterDatas['val_model']) && !empty($filterDatas['val_model'])) {
               $this->db->where_in($this->tbl_valuation . '.val_model', $filterDatas['val_model']);
          }
          if (isset($filterDatas['val_variant']) && !empty($filterDatas['val_variant'])) {
               $this->db->where_in($this->tbl_valuation . '.val_variant', $filterDatas['val_variant']);
          }
          if (isset($filterDatas['val_evaluator']) && !empty($filterDatas['val_evaluator'])) {
               $this->db->where('(' . $this->tbl_valuation . '.val_evaluator IN (' . implode($filterDatas['val_evaluator'], ',') . ') OR ' .
                    $this->tbl_users . '.usr_id IN (' . implode($filterDatas['val_evaluator'], ',') . '))');
          }
          if (isset($filterDatas['val_sales_officer']) && !empty($filterDatas['val_sales_officer'])) {
               $this->db->where('(' . $this->tbl_valuation . '.val_sales_officer IN (' . implode($filterDatas['val_sales_officer'], ',') . ') OR ' .
                    $this->tbl_users . '.usr_id IN (' . implode($filterDatas['val_sales_officer'], ',') . '))');
          }
          $val_valuation_date_from = (isset($filterDatas['val_valuation_date_from']) && !empty($filterDatas['val_valuation_date_from'])) ?
               date('Y-m-d', strtotime($filterDatas['val_valuation_date_from'])) : '';

          $val_valuation_date_to = (isset($filterDatas['val_valuation_date_to']) && !empty($filterDatas['val_valuation_date_to'])) ?
               date('Y-m-d', strtotime($filterDatas['val_valuation_date_to'])) : '';

          if (!empty($val_valuation_date_from)) {
               //$this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) >=', $val_valuation_date_to);
               $this->db->where("(DATE(" . $this->tbl_valuation . ".val_valuation_date) >= '" . $val_valuation_date_from .  "' OR DATE(" . $this->tbl_valuation . ".val_added_date) >= '" . $val_valuation_date_from . "')");
          }
          if (!empty($val_valuation_date_to)) {
               //$this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) <=', $val_valuation_date_to);
               $this->db->where("(DATE(" . $this->tbl_valuation . ".val_valuation_date) <= '" . $val_valuation_date_to .  "' OR DATE(" . $this->tbl_valuation . ".val_added_date) <= '" . $val_valuation_date_to . "')");
          }
          $this->db->where('val_veh_no IS NOT NULL');
          $this->db->where(array('val_booking_status' => 0));
          $this->db->where($stsWhere);
          $selArray = array(
               $this->tbl_valuation . '.val_id',
               $this->tbl_valuation . '.val_stock_num',
               $this->tbl_valuation . '.val_cust_name',
               $this->tbl_valuation . '.val_cust_phone',
               'UPPER(' . $this->tbl_valuation . '.val_prt_1) AS val_prt_1',
               'UPPER(' . $this->tbl_valuation . '.val_prt_2) AS val_prt_2',
               'UPPER(' . $this->tbl_valuation . '.val_prt_3) AS val_prt_3',
               'UPPER(' . $this->tbl_valuation . '.val_prt_4) AS val_prt_4',
               "val_veh_no",
               $this->tbl_valuation . '.val_status',
               $this->tbl_valuation . '.val_type',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_valuation . '.val_fuel',
               $this->tbl_valuation . '.val_eng_cc',
               "(CASE WHEN " . $this->tbl_valuation . ".val_fuel = 1 THEN 'Petrol'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 2 THEN 'Diesel'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 3 THEN 'Gas'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 4 THEN 'Hybrid'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 5 THEN 'Electric'
                    WHEN " . $this->tbl_valuation . ".val_fuel = 6 THEN 'CNG' END) AS fuel",
               "UPPER(DATE_FORMAT(" . $this->tbl_valuation . ".val_added_date, " . DATE_FORMAT_QRY_D . ")) AS val_added_date",
               "UPPER(DATE_FORMAT(" . $this->tbl_valuation . ".val_valuation_date, " . DATE_FORMAT_QRY_D . ")) AS val_valuation_date",
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_users . '.usr_id',
               $this->tbl_users . '.usr_username',
               $this->tbl_showroom . '.shr_id',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_enquiry . '.enq_id',
               "UPPER(DATE_FORMAT(" . $this->tbl_enquiry . ".enq_entry_date, " . DATE_FORMAT_QRY_D . ")) AS enq_entry_date",
               $this->tbl_enquiry . '.enq_cus_when_buy',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_cus_name',
               'evaluatedBy.usr_username AS evtr_usr_username',
               $this->tbl_valuation . '.val_booking_status',
               'val_book_sts.sts_title AS val_book_sts_title',
               'slsOfficer.usr_username AS so_usr_username, slsOfficer.usr_first_name AS so_usr_first_name',
               // "UPPER(DATE_FORMAT(" . $this->tbl_purchase_check_list . ".pcl_created_at, " . DATE_FORMAT_QRY_D . ")) AS pcl_created_at",
               $this->tbl_vehicle_colors . '.vc_color'
          );
          $totalRecordwithFilter = $this->db->select($selArray, false)
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
               ->join($this->tbl_users . ' evaluatedBy', 'evaluatedBy.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
               ->join($this->tbl_statuses . ' val_book_sts', 'val_book_sts.sts_value = ' . $this->tbl_valuation . '.val_booking_status', 'LEFT')
               ->join($this->tbl_users . ' slsOfficer', 'slsOfficer.usr_id = ' . $this->tbl_valuation . '.val_sales_officer', 'left')
               //->join($this->tbl_purchase_check_list, $this->tbl_purchase_check_list . '.pcl_val_id = ' . $this->tbl_valuation . '.val_id', 'left')
               ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_valuation . '.val_color', 'left')
               ->count_all_results($this->tbl_valuation);

          //----------------------------------------------------------------------------------------
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }

          if (!empty($searchValue)) {
               $this->db->where("(val_veh_no LIKE '%" . $searchValue . "%' OR shr_location LIKE '%" . $searchValue . "%' OR "
                    . "brd_title LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%' OR enq_cus_name LIKE '%" . $searchValue . "%' OR enq_cus_mobile LIKE '%" . $searchValue . "%')");
          }

          //   if (isset($filterDatas['status']) && ($filterDatas['status'] >= 0)) {
          //        $this->db->where(array($this->tbl_valuation . '.val_status' => $filterDatas['status']));
          //   }
          if (isset($filterDatas['vreg_division']) && ($filterDatas['vreg_division'] > 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_division' => $filterDatas['vreg_division']));
          }
          if (isset($filterDatas['showroom']) && ($filterDatas['showroom'] > 0)) {
               $this->db->where(array($this->tbl_valuation . '.val_showroom' => $filterDatas['showroom']));
          }
          if (isset($filterDatas['type']) && !empty($filterDatas['type'])) {
               $this->db->where_in($this->tbl_valuation . '.val_type', explode(',', $filterDatas['type']));
          }
          if (isset($filterDatas['enqStatus']) && !empty($filterDatas['enqStatus'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_when_buy', $filterDatas['enqStatus']);
          }
          if (isset($filterDatas['val_brand']) && !empty($filterDatas['val_brand'])) {
               $this->db->where_in($this->tbl_valuation . '.val_brand', $filterDatas['val_brand']);
          }
          if (isset($filterDatas['val_model']) && !empty($filterDatas['val_model'])) {
               $this->db->where_in($this->tbl_valuation . '.val_model', $filterDatas['val_model']);
          }
          if (isset($filterDatas['val_variant']) && !empty($filterDatas['val_variant'])) {
               $this->db->where_in($this->tbl_valuation . '.val_variant', $filterDatas['val_variant']);
          }
          if (isset($filterDatas['val_evaluator']) && !empty($filterDatas['val_evaluator'])) {
               //$this->db->where_in($this->tbl_valuation . '.val_evaluator', $filterDatas['val_evaluator']);
               $this->db->where('(' . $this->tbl_valuation . '.val_evaluator IN (' . implode($filterDatas['val_evaluator'], ',') . ') OR ' .
                    $this->tbl_users . '.usr_id IN (' . implode($filterDatas['val_evaluator'], ',') . '))');
          }
          if (isset($filterDatas['val_sales_officer']) && !empty($filterDatas['val_sales_officer'])) {
               $this->db->where('(' . $this->tbl_valuation . '.val_sales_officer IN (' . implode($filterDatas['val_sales_officer'], ',') . ') OR ' .
                    $this->tbl_users . '.usr_id IN (' . implode($filterDatas['val_sales_officer'], ',') . '))');
          }
          if (!empty($val_valuation_date_from)) {
               //$this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) >=', $val_valuation_date_from);
               $this->db->where("(DATE(" . $this->tbl_valuation . ".val_valuation_date) >= '" . $val_valuation_date_from .  "' OR DATE(" . $this->tbl_valuation . ".val_added_date) >= '" . $val_valuation_date_from . "')");
          }
          if (!empty($val_valuation_date_to)) {
               //$this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) <=', $val_valuation_date_to);
               $this->db->where("(DATE(" . $this->tbl_valuation . ".val_valuation_date) <= '" . $val_valuation_date_to .  "' OR DATE(" . $this->tbl_valuation . ".val_added_date) <= '" . $val_valuation_date_to . "')");
          }
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }

          $data = $this->db->select($selArray)
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
               ->join($this->tbl_users . ' evaluatedBy', 'evaluatedBy.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
               ->join($this->tbl_statuses . ' val_book_sts', 'val_book_sts.sts_value = ' . $this->tbl_valuation . '.val_status', 'LEFT')
               ->join($this->tbl_users . ' slsOfficer', 'slsOfficer.usr_id = ' . $this->tbl_valuation . '.val_sales_officer', 'left')
               //->join($this->tbl_purchase_check_list, $this->tbl_purchase_check_list . '.pcl_val_id = ' . $this->tbl_valuation . '.val_id', 'left')
               ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_valuation . '.val_color', 'left')
               ->where($stsWhere)->where(array('val_booking_status' => 0))->where('val_veh_no IS NOT NULL')->get($this->tbl_valuation)->result_array();
          // if ($this->uid == 100) {
          //      echo $this->db->last_query();
          //      debug($data);
          // }
          //Data
          ## Response
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecordwithFilter,
               "aaData" => $data
          );
          return $response;
     }

     function getEvaluationPrint($id = '', $status = '')
     {
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          if (!empty($id)) {
               $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
                    $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.usr_username,' .
                    $this->tbl_users . '.usr_first_name,' . $this->tbl_showroom . '.*,' . $this->tbl_divisions . '.div_name,' .
                    'slsOfficer.usr_username AS so_usr_username, slsOfficer.usr_first_name AS so_usr_first_name,' .
                    'evtr.usr_first_name AS evtr_first_name, evtr.usr_last_name AS evtr_last_name,' . $this->tbl_banks . '.*,' .
                    'mis.usr_first_name AS mis_first_name, mis.usr_last_name AS mis_last_name,' .
                    'delco.usr_first_name AS delco_first_name, delco.usr_last_name AS delco_last_name,' .
                    'sadmin.usr_first_name AS sadmin_first_name, sadmin.usr_last_name AS sadmin_last_name,' .
                    'padmin.usr_first_name AS padmin_first_name, padmin.usr_last_name AS padmin_last_name,' .
                    'telclr.usr_first_name AS telclr_first_name, telclr.usr_last_name AS telclr_last_name,' .
                    'apmasm.usr_first_name AS apmasm_first_name, apmasm.usr_last_name AS apmasm_last_name,' .
                    'tsc.usr_first_name AS tsc_first_name, tsc.usr_last_name AS tsc_last_name,' .
                    $this->tbl_statuses . '.sts_title, ' . $this->tbl_statuses . '.sts_des, ' .
                    $this->tbl_vehicle_colors . '.vc_color AS val_color')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                    ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_valuation . '.val_division', 'left')
                    ->join($this->tbl_users . ' slsOfficer', 'slsOfficer.usr_id = ' . $this->tbl_valuation . '.val_sales_officer', 'left')
                    ->join($this->tbl_banks, $this->tbl_banks . '.bnk_id = ' . $this->tbl_valuation . '.val_hypo_bank', 'left')
                    ->join($this->tbl_users . ' evtr', 'evtr.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                    ->join($this->tbl_users . ' mis', 'mis.usr_id = ' . $this->tbl_valuation . '.val_mis', 'left')
                    ->join($this->tbl_users . ' delco', 'delco.usr_id = ' . $this->tbl_valuation . '.val_delco', 'left')
                    ->join($this->tbl_users . ' sadmin', 'sadmin.usr_id = ' . $this->tbl_valuation . '.val_admin', 'left')
                    ->join($this->tbl_users . ' padmin', 'padmin.usr_id = ' . $this->tbl_valuation . '.val_purchase_admin', 'left')
                    ->join($this->tbl_users . ' telclr', 'telclr.usr_id = ' . $this->tbl_valuation . '.val_tele_caller', 'left')
                    ->join($this->tbl_users . ' apmasm', 'apmasm.usr_id = ' . $this->tbl_valuation . '.val_apm_asm', 'left')
                    ->join($this->tbl_users . ' tsc', 'tsc.usr_id = ' . $this->tbl_valuation . '.val_tsc', 'left')
                    ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_valuation . '.val_status', 'LEFT')
                    ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_valuation . '.val_color', 'left')
                    ->where(array('val_id' => $id))->get($this->tbl_valuation)->row_array();

               if (!empty($EvaluationVehicle)) {
                    $EvaluationVehicle['complaints'] = $this->db->get_where($this->tbl_valuation_complaint, array('comp_val_id' => $id))->result_array();
                    $EvaluationVehicle['documents'] = $this->db->order_by('vdoc_id', 'ASC')->get_where($this->tbl_valuation_documents, array('vdoc_val_id' => $id))->result_array();
                    $EvaluationVehicle['features'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                         ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                         ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 0))->result_array();

                    $EvaluationVehicle['featuresLoadings'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                         ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                         ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 1))->result_array();

                    $EvaluationVehicle['bdChkup'] = $this->db->select($this->tbl_valuation_ful_bd_chkup . '.*, ' . $this->tbl_valuation_ful_bd_chkup_master . '.*, ' .
                         $this->tbl_valuation_ful_bd_chkup_details . '.*')
                         ->join($this->tbl_valuation_ful_bd_chkup_master, $this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_master', 'LEFT')
                         ->join($this->tbl_valuation_ful_bd_chkup_details, $this->tbl_valuation_ful_bd_chkup_details . '.vfbcd_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_details', 'LEFT')
                         ->order_by($this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_order')->get_where($this->tbl_valuation_ful_bd_chkup, array('vfbc_valuation_master' => $id))->result_array();

                    $EvaluationVehicle['upgradeDetails'] = $this->db->select($this->tbl_valuation_upgrade_details . '.*,' . $this->tbl_vendors . '.ven_name')
                         ->join($this->tbl_vendors, $this->tbl_vendors . '.ven_id = ' . $this->tbl_valuation_upgrade_details . '.upgrd_service_location', 'LEFT')
                         ->where($this->tbl_valuation_upgrade_details . '.upgrd_master_id', $id)->get($this->tbl_valuation_upgrade_details)->result_array();

                    $EvaluationVehicle['valVehImages']['f1'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 1))->row_array();
                    $EvaluationVehicle['valVehImages']['f2'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 2))->row_array();
                    $EvaluationVehicle['valVehImages']['f3'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 3))->row_array();
                    $EvaluationVehicle['valVehImages']['f4'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 4))->row_array();
                    $EvaluationVehicle['valVehImages']['f5'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 5))->row_array();
                    $EvaluationVehicle['valVehImages']['f6'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 6))->row_array();
                    $EvaluationVehicle['valVehImages']['f7'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 7))->row_array();
                    $EvaluationVehicle['valVehImages']['f8'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 8))->row_array();
                    $EvaluationVehicle['valVehImages']['f9'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 9))->row_array();
                    $EvaluationVehicle['valVehImages']['f10'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 10))->row_array();
                    $EvaluationVehicle['valVehImages']['f11'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 11))->row_array();
                    $EvaluationVehicle['valVehImages']['f12'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 12))->row_array();
                    $EvaluationVehicle['valVehImages']['f13'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 13))->row_array();
               }
               return $EvaluationVehicle;
          }
     }

     function getEvaluation($id = '', $status = '')
     {
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          if (!empty($id)) {
               $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
                    $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                    ->where(array('val_id' => $id))
                    ->get($this->tbl_valuation)->row_array();
               if (!empty($EvaluationVehicle)) {
                    $EvaluationVehicle['complaints'] = $this->db->get_where($this->tbl_valuation_complaint, array('comp_val_id' => $id))->result_array();
                    $EvaluationVehicle['documents'] = $this->db->order_by('vdoc_id', 'ASC')->get_where($this->tbl_valuation_documents, array('vdoc_val_id' => $id))->result_array();
                    $EvaluationVehicle['features'] = $this->db->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id))->result_array();
                    $EvaluationVehicle['features'] = isset($EvaluationVehicle['features']) ? array_column($EvaluationVehicle['features'], 'vfet_feature') : array();
                    $EvaluationVehicle['bdChkup'] = $this->db->get_where($this->tbl_valuation_ful_bd_chkup, array('vfbc_valuation_master' => $id))->result_array();
                    $EvaluationVehicle['bdChkup'] = isset($EvaluationVehicle['bdChkup']) ? array_column($EvaluationVehicle['bdChkup'], 'vfbc_chkup_details') : array();
                    $EvaluationVehicle['upgradeDetails'] = $this->db->get_where($this->tbl_valuation_upgrade_details, array('upgrd_master_id' => $id))->result_array();

                    $EvaluationVehicle['valVehImages']['f1'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 1))->row_array();
                    $EvaluationVehicle['valVehImages']['f2'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 2))->row_array();
                    $EvaluationVehicle['valVehImages']['f3'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 3))->row_array();
                    $EvaluationVehicle['valVehImages']['f4'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 4))->row_array();
                    $EvaluationVehicle['valVehImages']['f5'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 5))->row_array();
                    $EvaluationVehicle['valVehImages']['f6'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 6))->row_array();
                    $EvaluationVehicle['valVehImages']['f7'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 7))->row_array();
                    $EvaluationVehicle['valVehImages']['f8'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 8))->row_array();
                    $EvaluationVehicle['valVehImages']['f9'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 9))->row_array();
                    $EvaluationVehicle['valVehImages']['f10'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 10))->row_array();
                    $EvaluationVehicle['valVehImages']['f11'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 11))->row_array();
                    $EvaluationVehicle['valVehImages']['f12'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 12))->row_array();
                    $EvaluationVehicle['valVehImages']['f13'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 13))->row_array();
               }
               return $EvaluationVehicle;
          } else {
               if ($status != '' && $status >= 0) {
                    $this->db->where(array($this->tbl_valuation . '.val_status' => $status));
               }
               if (isset($_GET['type']) && !empty($_GET['type'])) {
                    $this->db->where_in($this->tbl_valuation . '.val_type', explode(',', $_GET['type']));
               }
               $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*,' .
                    $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_enquiry . '.*,' .
                    'evtr.usr_first_name AS evtr_first_name, evtr.usr_last_name AS evtr_last_name')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
                    ->join($this->tbl_users . ' evtr', 'evtr.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                    ->get($this->tbl_valuation)->result_array();
               if (!empty($EvaluationVehicle)) {
                    foreach ($EvaluationVehicle as $key => $value) {
                         $EvaluationVehicle[$key]['complaints'] = $this->db->get_where($this->tbl_valuation_complaint, array('comp_val_id' => $value['val_id']))->result_array();
                    }
               }
               return $EvaluationVehicle;
          }
     }

     function newEvaluation($data)
     {
          if (!empty($data)) {
               $this->db->db_debug = false;
               foreach ($data as $key => $value) {
                    if (empty($data[$key])) {
                         unset($data[$key]);
                    }
               }
               $data['val_added_by'] = $this->uid;
               $data['val_showroom'] = (isset($data['val_showroom']) && !empty($data['val_showroom'])) ?
                    $data['val_showroom'] : get_logged_user('usr_showroom');

               $data['val_delv_date'] = (isset($data['val_delv_date']) && !empty($data['val_delv_date'])) ? date('Y-m-d', strtotime($data['val_delv_date'])) : NULL;
               $data['val_reg_date'] = (isset($data['val_reg_date']) && !empty($data['val_reg_date'])) ? date('Y-m-d', strtotime($data['val_reg_date'])) : NULL;
               $data['val_insurance_validity'] = (isset($data['val_insurance_validity']) && !empty($data['val_insurance_validity'])) ? date('Y-m-d', strtotime($data['val_insurance_validity'])) : NULL;
               $data['val_last_service'] = (isset($data['val_last_service']) && !empty($data['val_last_service'])) ? date('Y-m-d', strtotime($data['val_last_service'])) : NULL;
               $data['val_manf_date'] = (isset($data['val_manf_date']) && !empty($data['val_manf_date'])) ? date('Y-m-d', strtotime($data['val_manf_date'])) : NULL;
               $data['val_valuation_date'] = (isset($data['val_valuation_date']) && !empty($data['val_valuation_date'])) ? date('Y-m-d', strtotime($data['val_valuation_date'])) : NULL;
               $data['val_hypo_loan_date'] = (isset($data['val_hypo_loan_date']) && !empty($data['val_hypo_loan_date'])) ? date('Y-m-d', strtotime($data['val_hypo_loan_date'])) : NULL;
               $data['val_hypo_frclos_date'] = (isset($data['val_hypo_frclos_date']) && !empty($data['val_hypo_frclos_date'])) ? date('Y-m-d', strtotime($data['val_hypo_frclos_date'])) : NULL;
               $data['val_hypo_loan_end_date'] = (isset($data['val_hypo_loan_end_date']) && !empty($data['val_hypo_loan_end_date'])) ? date('Y-m-d', strtotime($data['val_hypo_loan_end_date'])) : NULL;
               $data['val_insurance_comp_date'] = (isset($data['val_insurance_comp_date']) && !empty($data['val_insurance_comp_date'])) ? date('Y-m-d', strtotime($data['val_insurance_comp_date'])) : NULL;
               $data['val_insurance_ll_date'] = (isset($data['val_insurance_ll_date']) && !empty($data['val_insurance_ll_date'])) ? date('Y-m-d', strtotime($data['val_insurance_ll_date'])) : NULL;
               $data['val_ex_wrnty_validity'] = (isset($data['val_ex_wrnty_validity']) && !empty($data['val_ex_wrnty_validity'])) ? date('Y-m-d', strtotime($data['val_ex_wrnty_validity'])) : NULL;
               $data['val_wrnty_nxt_ser_date'] = (isset($data['val_wrnty_nxt_ser_date']) && !empty($data['val_wrnty_nxt_ser_date'])) ? date('Y-m-d', strtotime($data['val_wrnty_nxt_ser_date'])) : NULL;
               $data['val_next_serv_date'] = (isset($data['val_next_serv_date']) && !empty($data['val_next_serv_date'])) ? date('Y-m-d', strtotime($data['val_next_serv_date'])) : NULL;
               $data['val_prt_3'] = !empty($data['val_prt_3']) ? $data['val_prt_3'] : '##';
               $data['val_veh_no'] = strtoupper($data['val_prt_1']) . $data['val_prt_2'] . strtoupper($data['val_prt_3']) . $data['val_prt_4'];
               $data['val_top_up_loan'] = isset($data['val_top_up_loan']) ? 1 : 0;
               $data['val_battery_warranty'] = isset($data['val_battery_warranty']) ? 1 : 0;
               $this->db->insert($this->tbl_valuation, array_filter($data));
               $insertId = $id = $this->db->insert_id();
               $data['val_id'] = $id;
               generate_log(array(
                    'log_title' => 'New Evaluation after insert',
                    'log_desc' => serialize($data),
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'C',
                    'log_ref_id' => $insertId,
                    'log_added_by' => $this->uid
               ));

               $already = $this->db->select('prd_id', true)->like('prd_regno_prt_1', strtoupper($data['val_prt_1']), 'BOTH')
                    ->where('CAST(prd_regno_prt_2 AS UNSIGNED) = ', $data['val_prt_2'])
                    ->like('prd_regno_prt_3', strtoupper($data['val_prt_3']), 'BOTH')
                    ->where('prd_regno_prt_4', $data['val_prt_4'])->order_by('prd_id', 'DESC')->get($this->tbl_products)->row_array();
               $already = isset($already['prd_id']) ? $already['prd_id'] : 0;

               if ($already > 0) {
                    $this->db->where('prd_id', $already)->update($this->tbl_products, array('prd_valuation_id' => $id));
               } else {
                    $product = array(
                         'prd_valuation_id' => $id,
                         'prd_number' => gen_random(),
                         'prd_regno_prt_1' => strtoupper($data['val_prt_1']),
                         'prd_regno_prt_2' => $data['val_prt_2'],
                         'prd_regno_prt_3' => strtoupper($data['val_prt_3']),
                         'prd_regno_prt_4' => $data['val_prt_4'],
                         'prd_km_run' => $data['val_km'],
                         'prd_variant' => $data['val_variant'],
                         'prd_model' => $data['val_model'],
                         'prd_brand' => $data['val_brand'],
                         'prd_insurance_validity' => $insDate,
                         'prd_insurance_idv' => $idv,
                         'prd_fual' => $data['val_fuel'],
                         'prd_year' => $data['val_model_year'],
                         'prd_color' => $data['val_color'],
                         'prd_owner' => $data['val_no_of_owner'],
                         'prd_engine_cc' => $data['val_eng_cc'],
                         'prd_date' => date('Y-m-d'),
                         'prd_status' => 0,
                    );
                    @$this->db->insert($this->tbl_products, array_filter($product));
                    //Add dummy product
               }

               return $id;
          } else {
               generate_log(array(
                    'log_title' => 'New Evaluation',
                    'log_desc' => serialize($data),
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'C',
                    'log_ref_id' => 0,
                    'log_added_by' => $this->uid
               ));
               return false;
          }
     }

     function updateEvaluation($id, $data)
     {

          if (!empty($data)) {

               //                 foreach ($data as $key => $value) {
               //                      if (empty($data[$key])) {
               //                           unset($data[$key]);
               //                      }
               //                 }
               $data['val_updated_by'] = $this->uid;
               //   if(isset($data['val_status'])) {
               //      $data['val_status'] = $data['val_status'];     
               //   }
               $data['val_status'] = (isset($data['val_status']) && !empty($data['val_status'])) ? $data['val_status'] : vehicle_evaluated; //un cmt by jk- stock status not updating 
               $data['val_delv_date'] = (isset($data['val_delv_date']) && !empty($data['val_delv_date'])) ? date('Y-m-d', strtotime($data['val_delv_date'])) : NULL;
               $data['val_reg_date'] = (isset($data['val_reg_date']) && !empty($data['val_reg_date'])) ?  date('Y-m-d', strtotime($data['val_reg_date'])) : NULL;
               $data['val_insurance_validity'] = (isset($data['val_insurance_validity']) && !empty($data['val_insurance_validity'])) ?  date('Y-m-d', strtotime($data['val_insurance_validity'])) : NULL;
               $data['val_last_service'] = (isset($data['val_last_service']) && !empty($data['val_last_service'])) ? date('Y-m-d', strtotime($data['val_last_service'])) : NULL;
               $data['val_manf_date'] = (isset($data['val_manf_date']) && !empty($data['val_manf_date'])) ? date('Y-m-d', strtotime($data['val_manf_date'])) : NULL;
               $data['val_valuation_date'] = (isset($data['val_valuation_date']) && !empty($data['val_valuation_date'])) ? date('Y-m-d', strtotime($data['val_valuation_date'])) : NULL;
               $data['val_hypo_loan_date'] = (isset($data['val_hypo_loan_date']) && !empty($data['val_hypo_loan_date'])) ? date('Y-m-d', strtotime($data['val_hypo_loan_date'])) : NULL;
               $data['val_hypo_frclos_date'] = (isset($data['val_hypo_frclos_date']) && !empty($data['val_hypo_frclos_date'])) ? date('Y-m-d', strtotime($data['val_hypo_frclos_date'])) : NULL;
               $data['val_hypo_loan_end_date'] = (isset($data['val_hypo_loan_end_date']) && !empty($data['val_hypo_loan_end_date'])) ? date('Y-m-d', strtotime($data['val_hypo_loan_end_date'])) : NULL;
               $data['val_insurance_comp_date'] = (isset($data['val_insurance_comp_date']) && !empty($data['val_insurance_comp_date'])) ? date('Y-m-d', strtotime($data['val_insurance_comp_date'])) : NULL;
               $data['val_insurance_ll_date'] = (isset($data['val_insurance_ll_date']) && !empty($data['val_insurance_ll_date'])) ? date('Y-m-d', strtotime($data['val_insurance_ll_date'])) : NULL;
               $data['val_ex_wrnty_validity'] = (isset($data['val_ex_wrnty_validity']) && !empty($data['val_ex_wrnty_validity'])) ? date('Y-m-d', strtotime($data['val_ex_wrnty_validity'])) : NULL;
               $data['val_wrnty_nxt_ser_date'] = (isset($data['val_wrnty_nxt_ser_date']) && !empty($data['val_wrnty_nxt_ser_date'])) ? date('Y-m-d', strtotime($data['val_wrnty_nxt_ser_date'])) : NULL;
               $data['val_next_serv_date'] = (isset($data['val_next_serv_date']) && !empty($data['val_next_serv_date'])) ? date('Y-m-d', strtotime($data['val_next_serv_date'])) : NULL;

               $data['val_top_up_loan'] = isset($data['val_top_up_loan']) ? 1 : 0;
               $data['val_battery_warranty'] = isset($data['val_battery_warranty']) ? 1 : 0;
               $data['val_prt_3'] = !empty($data['val_prt_3']) ? $data['val_prt_3'] : '##';
               $part_1 = isset($data['val_prt_1']) ? strtoupper(trim($data['val_prt_1'])) : '';
               $part_2 = isset($data['val_prt_2']) ? trim($data['val_prt_2']) : '';
               $part_3 = isset($data['val_prt_3']) ? strtoupper(trim($data['val_prt_3'])) : '';
               $part_4 = isset($data['val_prt_4']) ? trim($data['val_prt_4']) : '';
               $data['val_veh_no'] = $part_1 . $part_2 . $part_3 . $part_4;
               //$data['val_status'] = vehicle_evaluated; cmt by jk- stock status not updating 
               $this->db->where('val_id', $id);
               $this->db->update($this->tbl_valuation, array_filter($data));
               $er = $this->db->_error_message();
               if (!empty($er)) {
                    generate_log(array(
                         'log_title' => 'Update Evaluation error',
                         'log_desc' => serialize($er),
                         'log_controller' => 'eve-upd-error',
                         'log_action' => 'U',
                         'log_ref_id' => $id,
                         'log_added_by' => $this->uid
                    ));
               }
               generate_log(array(
                    'log_title' => 'Update Evaluation',
                    'log_desc' => serialize($data),
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'U',
                    'log_ref_id' => $id,
                    'log_added_by' => get_logged_user('usr_id')
               ));
               return $id;
          } else {
               generate_log(array(
                    'log_title' => 'Update Evaluation',
                    'log_desc' => 'Error while update Evaluation',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'U',
                    'log_ref_id' => $id,
                    'log_added_by' => get_logged_user('usr_id')
               ));
               return false;
          }
     }

     function newEvaluationComplaints($data)
     {
          if (!empty($data)) {
               $this->db->insert($this->tbl_valuation_complaint, array_filter($data));
               return true;
          } else {
               return false;
          }
     }

     function newEvaluationDocument($data)
     {
          if (!empty($data)) {
               $data['vdoc_added_by'] = $this->uid;
               $data['vdoc_added_on'] = date('Y-m-d H:i:s');
               $this->db->insert($this->tbl_valuation_documents, array_filter($data));
               return true;
          } else {
               return false;
          }
     }

     function delete($id)
     {
          if (!empty($id)) {
               $this->db->where('val_id', $id);
               $this->db->update($this->tbl_valuation, array('val_status' => 99));
               generate_log(array(
                    'log_title' => 'Evaluation deleted',
                    'log_desc' => 'Evaluation deleted',
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

     function deleteImage($id)
     {
          $image = $this->db->get_where($this->tbl_valuation_complaint, array('comp_id' => $id))->row_array();

          if (!empty($image)) {
               if (!empty($image['comp_pic'])) {
                    if (file_exists('./assets/uploads/evaluation/' . $image['comp_pic'])) {
                         //unlink('./assets/uploads/evaluation/' . $image['comp_pic']);
                    }
               }
               $this->db->where('comp_id', $id);
               $this->db->delete($this->tbl_valuation_complaint);
               return true;
          } else {
               return false;
          }
     }

     function autoComVehicleEvaluation($qry)
     {
          if (!empty($qry)) {
               $this->db->select('val_id AS data, val_veh_no AS value');
               $this->db->like('val_veh_no', $qry, 'after');
               $veh = $this->db->get($this->tbl_valuation)->result_array();
               foreach ((array) $veh as $key => $value) {
                    $veh[$key]['id_enc'] = encryptor($value['data']);
               }
               return $veh;
          }
     }

     function checkVehicleExists($data)
     {

          $veh_no = isset($data['valuation']['val_veh_no']) ? strtolower($data['valuation']['val_veh_no']) : '';
          $chassis_no = isset($data['valuation']['val_chasis_no']) ? $data['valuation']['val_chasis_no'] : '';
          $engine_no = isset($data['valuation']['val_engine_no']) ? $data['valuation']['val_engine_no'] : '';

          if (!empty($data)) {
               $where = '';
               if (isset($data['val_id']) && !empty($data['val_id'])) {
                    $where = 'val_id != ' . $data['val_id'] . ' AND';
               }
               $eveluation = $this->db->query('SELECT * FROM ' . $this->tbl_valuation . ' WHERE ' . $where . " (val_veh_no LIKE '" . $veh_no . "' OR val_chasis_no = '" . $chassis_no . "' OR val_engine_no = '" . $engine_no . "')", true)
                    ->result_array();

               if (!empty($eveluation)) {
                    return $eveluation;
               } else {
                    return false;
               }
          } else {
               return false;
          }
     }

     function getOwnParkAndSaleCars()
     {
          return $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*,' .
               $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_enquiry . '.*')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
               ->where_in($this->tbl_valuation . '.val_type', array(1, 2))
               ->get($this->tbl_valuation)->result_array();
     }

     function getAllStock()
     {
          return $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*,' .
               $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_enquiry . '.*')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
               ->get($this->tbl_valuation)->result_array();
     }

     function deleteDocument($id)
     {
          $doc = $this->db->get_where($this->tbl_valuation_documents, array('vdoc_id' => $id))->row_array();
          if (!empty($doc)) {
               if (!empty($doc['comp_pic'])) {
                    if (file_exists('./assets/uploads/evaluation/' . $image['vdoc_doc'])) {
                         //unlink('./assets/uploads/evaluation/' . $image['vdoc_doc']);
                    }
               }
               $this->db->where('vdoc_id', $id);
               $this->db->delete($this->tbl_valuation_documents);
               return true;
          } else {
               return false;
          }
     }

     function isVehicleSold($valuationId)
     {
          $salesInfo = $this->db->get_where($this->tbl_valuation_status, array('est_valuation_id' => $valuationId, 'est_status' => 11))->row_array();
          if (!empty($salesInfo)) {
               return true;
          }
          return false;
     }

     function updateAsSold($data)
     {
          if (isset($data['tmp']) && !empty($data)) {
               foreach ($data['tmp'] as $valId => $value) {
                    if (!empty($value['CS']) && !empty($value['SE'])) {
                         $tmpData = array(
                              'tvs_valuation' => $valId,
                              'tvs_customer' => isset($value['CS']) ? $value['CS'] : '',
                              'tvs_se' => isset($value['SE']) ? $value['SE'] : '',
                              'tvs_sales_date' => isset($value['DT']) ? date('Y-m-d', strtotime($value['DT'])) : '',
                              'tvs_added_on' => date('Y-m-d h:i:s'),
                              'tvs_added_by' => $this->uid,
                              'tvs_status' => isset($value['ST']) ? $value['ST'] : ''
                         );
                         $this->db->insert('cpnl_vehicle_status_tmp', array_filter($tmpData));
                    }
               }
          }

          if (isset($data['tmp']) && !empty($data['tmp'])) {
               foreach ($data['tmp'] as $key => $value) {
                    if (!empty($value)) {
                         if (!empty($value['DT']) && !empty($value['ST'])) {
                              $this->db->where('val_id', $key);
                              $this->db->update($this->tbl_valuation, array('val_is_sold' => 1, 'val_sold_date' => date('Y-m-d', strtotime($value['DT']))));
                         }
                    }
               }
          }
     }

     function autoComSE($qry)
     {
          if (!empty($qry)) {
               $this->db->select('usr_id AS data, usr_first_name AS value');
               $this->db->like('usr_first_name', $qry, 'after');
               $this->db->where('usr_active', 1);
               $this->db->where('usr_id != 1');
               return $this->db->get($this->tbl_users)->result_array();
          }
     }

     function autoComCustomer($qry)
     {
          if (!empty($qry)) {
               //$this->db->select('enq_id AS data, enq_cus_name AS value');
               $this->db->select("enq_id AS data, CONCAT(enq_cus_name, ' ', enq_cus_mobile) AS value", false);
               $this->db->like('enq_cus_name', $qry, 'after');
               $this->db->where('enq_current_status', 1);
               $this->db->where('enq_cus_status', 1);
               return $this->db->get($this->tbl_enquiry)->result_array();
          }
     }

     function getAllEvaluators()
     {
          //5
          $return = $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               ->where('(' . $this->tbl_groups . ".id IN (13,8,6,3,35) AND " . $this->tbl_users . ".usr_departments IN (7,8,1,2))")
               ->where(array($this->tbl_users . '.usr_active' => 1))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->order_by('usr_first_name')->get($this->tbl_users)->result_array();
          /*if($this->uid == 100) { echo $this->db->last_query(); debug($return);}*/
          return $return;
     }

     function getEnquiryHandingMembers()
     {
          return $this->db->where_not_in('usr_id', array(19, 38, 18, 100))->order_by('usr_first_name')->get_where($this->tbl_users, array(
               $this->tbl_users . '.usr_active' => 1,
               $this->tbl_users . '.usr_resigned' => 0
          ))->result_array();
     }

     function getAllManagers()
     {
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               ->where('(' . $this->tbl_groups . ".grp_slug = 'MG' OR " . $this->tbl_groups . ".grp_slug = 'TL')")
               ->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->get($this->tbl_users)->result_array();
     }

     function getAllAPMASM()
     {
          return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
               $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               ->where('((' . $this->tbl_groups . ".grp_slug = 'MG' OR " . $this->tbl_groups . ".grp_slug = 'TL') OR (" .
                    'usr_designation_new = 22 OR usr_designation_new = 23 OR usr_designation_new = 24 OR usr_designation_new = 40 OR usr_designation_new = 60' . "))")
               ->where(array($this->tbl_users . '.usr_active' => 1, 'usr_resigned' => 0))
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->order_by('usr_first_name')->get($this->tbl_users)->result_array();
     }

     function getAllVehicleFeatures()
     {
          return $this->db->order_by('vftr_order', 'ASC')->get_where($this->tbl_vehicle_features, array('vftr_status' => 1, 'vftr_features_add_on' => 0))->result_array();
     }

     function getVehicleAddOnFeatures()
     {
          return $this->db->order_by('vftr_order', 'ASC')->get_where($this->tbl_vehicle_features, array('vftr_status' => 1, 'vftr_features_add_on' => 1))->result_array();
     }

     function getFullBodyCheckupMaster()
     {
          return $this->db->order_by('vfbcm_order')->get_where($this->tbl_valuation_ful_bd_chkup_master, array('vfbcm_status' => 1))->result_array();
     }

     function getFullBodyCheckupDetailByMaster($masterId)
     {
          return $this->db->order_by('vfbcd_order')->get_where($this->tbl_valuation_ful_bd_chkup_details, array('vfbcd_master' => $masterId, 'vfbcd_status' => 1))->result_array();
     }

     function newFeatures($data)
     {
          if (!empty($data)) {
               $this->db->insert($this->tbl_valuation_features, array_filter($data));
               return true;
          }
          return false;
     }

     function fullBodyCheckup($data)
     {
          if (!empty($data)) {
               $this->db->insert($this->tbl_valuation_ful_bd_chkup, array_filter($data));
               return true;
          }
          return false;
     }

     function upgradeDetails($data, $evId)
     {
          if (!empty($data)) {
               $count = count($data['upgrd_key']);
               //Create master
               $masterData = array(
                    'vum_val_id' => $evId,
                    'vum_estimate_total' => array_sum($data['upgrd_value']),
                    'vum_added_by' => $this->uid,
                    'vum_added_on' => date('Y-m-d')
               );
               $this->db->insert($this->tbl_valuation_upgrade_master, $masterData);
               $upgradeMaster = $this->db->insert_id();
               for ($i = 0; $i < $count; $i++) {
                    $upgrKey = (isset($data['upgrd_key'][$i]) && !empty($data['upgrd_key'][$i])) ? $data['upgrd_key'][$i] : 0;
                    $upgrVal = (isset($data['upgrd_value'][$i]) && !empty($data['upgrd_value'][$i])) ? $data['upgrd_value'][$i] : 0;
                    $this->db->insert($this->tbl_valuation_upgrade_details, array(
                         'upgrd_master_id' => $evId,
                         'upgrd_key' => $upgrKey,
                         'upgrd_value' => $upgrVal,
                         'upgrd_added_by' => $this->uid,
                         'upgrd_added_on' => date('Y-m-d H:i:s'),
                         'upgrd_refurb_master' => $upgradeMaster
                    ));
               }
          }
     }

     function removeFeaturesByMaster($id)
     {
          if (!empty($id)) {
               $this->db->where('vfet_valuation', $id)->delete($this->tbl_valuation_features);
               return true;
          }
          return false;
     }

     function removeBodyCheckupByMaster($id)
     {
          if (!empty($id)) {
               $this->db->where('vfbc_valuation_master', $id)->delete($this->tbl_valuation_ful_bd_chkup);
               return true;
          }
          return false;
     }

     function removeUpgradeDetailsByMaster($id)
     {
          if (!empty($id)) {
               $this->db->where('upgrd_master_id', $id)->delete($this->tbl_valuation_upgrade_details);
               return true;
          }
          return false;
     }

     function uploadEvaluationVehicleImages($data)
     {
          if (!empty($data)) {
               $this->db->insert($this->tbl_valuation_veh_images, array_filter($data));
               return true;
          }
          return false;
     }

     function deleteValuationVehicleImage($id)
     {
          if ($this->db->where('vvi_id', $id)->delete($this->tbl_valuation_veh_images)) {
               return true;
          } else {
               return false;
          }
     }

     function updateDocumentType($valType, $valId)
     {
          if ($this->db->where('vdoc_id', $valType)->update($this->tbl_valuation_documents, array(
               'vdoc_doc_type' => $valId,
               'vdoc_update_by' => $this->uid,
               'vdoc_update_on' => date('Y-m-d H:i:s')
          ))) {
               return true;
          } else {
               return false;
          }
     }

     function updateRefurbActualCostMaster($valId)
     {

          $sum = $this->db->select('COALESCE(SUM(upgrd_refurb_actual_cost), 0) AS upgrd_refurb_actual_cost, 
                                    COALESCE(SUM(upgrd_value), 0) AS upgrd_value', false)
               ->where('upgrd_master_id', $valId)->get($this->tbl_valuation_upgrade_details)->row_array();
          $updateArray = array();

          if (isset($sum['upgrd_refurb_actual_cost']) && !empty($sum['upgrd_refurb_actual_cost'])) {
               $updateArray['val_refurb_act_cost'] = $sum['upgrd_refurb_actual_cost'];
          }
          if (isset($sum['upgrd_value']) && !empty($sum['upgrd_value'])) {
               $updateArray['val_refurb_cost'] = $sum['upgrd_value'];
          }
          if (!empty($updateArray)) {
               $this->db->where('val_id', $valId)->update($this->tbl_valuation, $updateArray);
          }
          return true;
     }

     function getVendors($id = 0)
     {
          if ($id) {
               return $this->db->get_where($this->tbl_vendors, array('ven_id' => $id))->row_array();
          }
          $this->db->where('ven_type', 2);
          return $this->db->order_by('ven_name', 'ASC')->get($this->tbl_vendors)->result_array();
     }

     function refurbisheReturn($datas)
     {
          generate_log(array(
               'log_title' => 'Refurbishment return',
               'log_desc' => serialize($datas),
               'log_controller' => 'refurbishe-return',
               'log_action' => 'U',
               'log_ref_id' => $datas['evaluationId'],
               'log_added_by' => $this->uid
          ));
          $val = $this->db->select('val_stock_num, val_veh_no, val_division')->get_where($this->tbl_valuation, array('val_id' => $datas['evaluationId']))->row_array();
          $vehNum = isset($val['val_veh_no']) ? str_replace('-', '', $val['val_veh_no']) : '';
          $stockNum = isset($val['val_stock_num']) ? $val['val_stock_num'] : '';

          $expType = $this->getExpenceType();
          $divId = isset($val['val_division']) ? $val['val_division'] : 0;
          $gcCode = $this->db->get_where($this->tbl_company, array('cmp_division' => $divId))->row()->cmp_finance_year_code;
          $rfMasterId = 0;

          $rfActTtl = 0;
          $rfActAddlExpTtl = 0;
          $rfActGstTtl = 0;
          $rfEstTtl = 0;

          $apiHead = array();
          $apiDetail = array();
          $index = 0;
          if (isset($datas['refrubishjob']) && !empty($datas['refrubishjob'])) {
               $vendor = $this->getVendors($datas['m']['vum_vendor']);
               $vendor = isset($vendor['ven_name']) ? $vendor['ven_name'] : '';
               foreach ($datas['refrubishjob'] as $key => $value) {

                    $rfMasterId = isset($value['upgrd_refurb_master']) ? $value['upgrd_refurb_master'] : 0;
                    $isDone = isset($value['upgrd_is_done']) ? $value['upgrd_is_done'] : 0;
                    if ($isDone == 1) {
                         $updatevalue['upgrd_expence_type'] = (isset($value['upgrd_expence_type']) && !empty($value['upgrd_expence_type'])) ? $value['upgrd_expence_type'] : 0;
                         $updatevalue['actual_job_description'] = $value['actual_job_desc'];
                         $updatevalue['upgrd_refurb_actual_cost'] = !empty($value['newcost']) ? $value['newcost'] : 0;
                         $updatevalue['upgrd_refurb_remarks'] = trim($value['desc']);
                         $updatevalue['upgrd_is_done'] = $isDone;
                         $updatevalue['upgrd_updated_on'] = date('Y-m-d H:i:s');
                         $updatevalue['upgrd_updated_by'] = $this->uid;
                         $updatevalue['upgrd_service_location'] = isset($datas['m']['vum_vendor']) ? $datas['m']['vum_vendor'] : 0;
                         $updatevalue['upgrd_sgstp'] = !empty($value['sgstp']) ? $value['sgstp'] : 0;
                         $updatevalue['upgrd_sgst'] = !empty($value['sgst']) ? $value['sgst'] : 0;
                         $updatevalue['upgrd_cgstp'] = !empty($value['cgstp']) ? $value['cgstp'] : 0;
                         $updatevalue['upgrd_cgst'] = !empty($value['cgst']) ? $value['cgst'] : 0;
                         $updatevalue['upgrd_igstp'] = !empty($value['igstp']) ? $value['igstp'] : 0;
                         $updatevalue['upgrd_igst'] = !empty($value['igst']) ? $value['igst'] : 0;
                         $updatevalue['upgrd_bill_no'] = isset($datas['m']['vum_bill_no']) ? $datas['m']['vum_bill_no'] : NULL;
                         $updatevalue['upgrd_bill_date'] = isset($datas['m']['vum_bill_date']) ? date('Y-m-d', strtotime($datas['m']['vum_bill_date'])) : NULL;
                         $updatevalue['upgrd_act_est'] = isset($value['upgrd_act_est']) ? $value['upgrd_act_est'] : 0;
                         $this->db->where('upgrd_id', $value['upgrd_id'])->update($this->tbl_valuation_upgrade_details, $updatevalue);

                         if ((float) $updatevalue['upgrd_refurb_actual_cost'] > 0) {

                              $expTypeVal = '';
                              if ((!empty($updatevalue['upgrd_expence_type']) && $updatevalue['upgrd_expence_type'] > 0)) {
                                   $expTypeKey = array_search($updatevalue['upgrd_expence_type'], array_column($expType, 'ven_id'));
                                   $expTypeVal = isset($expType[$expTypeKey]['ven_name']) ? $expType[$expTypeKey]['ven_name'] : '';
                              }
                              if ((isset($value['upgrd_act_est']) && !empty($value['upgrd_act_est'])) && (!empty($vendor) && !empty($expTypeVal))) {

                                   if ($value['upgrd_act_est'] == 1) { //RF Expense incurred
                                        $rfActTtl = $rfActTtl + (float) $updatevalue['upgrd_refurb_actual_cost'] +
                                             (float) $updatevalue['upgrd_sgst'] + (float) $updatevalue['upgrd_cgst'] + (float) $updatevalue['upgrd_igst'];;
                                   } else if ($value['upgrd_act_est'] == 2) { //RF Addl Expected
                                        $rfActAddlExpTtl = $rfActAddlExpTtl + (float) $updatevalue['upgrd_refurb_actual_cost'] +
                                             (float) $updatevalue['upgrd_sgst'] + (float) $updatevalue['upgrd_cgst'] + (float) $updatevalue['upgrd_igst'];;
                                   }
                                   $rfEstTtl = $rfEstTtl + (float) $value['upgrd_value'];
                                   $rfActGstTtl = $rfActGstTtl + ((float) $updatevalue['upgrd_refurb_actual_cost'] + (float) $updatevalue['upgrd_sgst'] + (float) $updatevalue['upgrd_cgst'] + (float) $updatevalue['upgrd_igst']);

                                   if ($value['upgrd_act_est'] == 1) { //RF Expense incurred
                                        //API Details
                                        $apiDetail[$index]['expType'] = (string) $expTypeVal;
                                        $apiDetail[$index]['esT_AMT'] = (float) $value['upgrd_value'];
                                        $apiDetail[$index]['expAmount'] = ($value['upgrd_act_est'] == 1) ? (float) $updatevalue['upgrd_refurb_actual_cost'] : 0;
                                        $apiDetail[$index]['add_Exp_Amt'] = ($value['upgrd_act_est'] == 2) ? (float) $updatevalue['upgrd_refurb_actual_cost'] : 0;
                                        $apiDetail[$index]['sgstPer'] = (float) $updatevalue['upgrd_sgstp'];
                                        $apiDetail[$index]['sgstAmount'] = (float) round($updatevalue['upgrd_sgst'], 2);
                                        $apiDetail[$index]['cgstPer'] = (float) $updatevalue['upgrd_cgstp'];
                                        $apiDetail[$index]['cgstAmount'] = (float) round($updatevalue['upgrd_cgst'], 2);
                                        $apiDetail[$index]['igstPer'] = (float) $updatevalue['upgrd_igstp'];
                                        $apiDetail[$index]['igstAmount'] = (float) round($updatevalue['upgrd_igst'], 2);
                                        $apiDetail[$index]['totalAmount'] = (float) round(($apiDetail[$index]['expAmount'] + (float) $updatevalue['upgrd_sgst'] + (float) $updatevalue['upgrd_cgst'] + (float) $updatevalue['upgrd_igst']), 2);
                                        $index++;
                                   }
                              }
                         }
                    }
               }

               //APIHead
               $apiHead[] = array(
                    'billNo' => (string) $datas['m']['vum_bill_no'],
                    'billDate' => date('Y-m-d', strtotime($datas['m']['vum_bill_date'])),
                    'partyName' => (string) $vendor,
                    'registrationNo' => (string) $vehNum,
                    'remarks' => (string) trim($datas['m']['vum_remarks']),
                    'bookingNo' => (string) $datas['m']['vum_bill_no'],
                    'stockID' => (string) $stockNum,
                    'gcCode' => (int) $gcCode,
                    'gstAplcble' => (int) $datas['m']['vum_gst_apbl'],
                    'Mode' => 'C',
                    'toT_EST_AMT' => (float) round(array_sum(array_column($apiDetail, 'esT_AMT')), 2),
                    'expTotAmount' => (float) round(array_sum(array_column($apiDetail, 'totalAmount')), 2),
                    'toT_Add_Exp_Amt' => (float) round($rfActAddlExpTtl, 2)
               );
               $apiData['head'] = $apiHead;
               $apiData['detail'] = $apiDetail;
               if (!empty($apiHead) && !empty($apiDetail)) {
                    $responce = $this->ihits->ihitsSaveExpense($apiData, 0, 0, $datas['evaluationId'], 0);
               }

               //Update refurbishment master
               $refMastr = array(
                    'vum_vendor' => $datas['m']['vum_vendor'],
                    'vum_bill_no' => $datas['m']['vum_bill_no'],
                    'vum_bill_date' => date('Y-m-d', strtotime($datas['m']['vum_bill_date'])),
                    'vum_updated_by' => $this->uid,
                    'vum_updated_on' => date('Y-m-d H:i:s'),
                    'vum_actual_total' => $rfActTtl,
                    'vum_addl_exp' => $rfActAddlExpTtl,
                    'vum_actual_total_with_gst' => $rfActGstTtl,
                    'vum_gst_apbl' => $datas['m']['vum_gst_apbl'],
                    'vum_remarks' => trim($datas['m']['vum_remarks'])
               );

               $this->db->where('vum_id', $rfMasterId)->update($this->tbl_valuation_upgrade_master, $refMastr);
          }

          if (isset($datas['newRefrubishjob']) && !empty($datas['newRefrubishjob'])) {

               //New refurbishment master
               $refMastr = array(
                    'vum_val_id' => $datas['evaluationId'],
                    'vum_added_by' => $this->uid,
                    'vum_added_on' => date('Y-m-d H:i:s'),
                    'vum_estimate_total' => array_sum($datas['newRefrubishjob']['refurb_job_cost'])
               );
               $this->db->insert($this->tbl_valuation_upgrade_master, $refMastr);
               $refMaster = $this->db->insert_id();

               $refurb = isset($datas['newRefrubishjob']['refurb_job']) ? count($datas['newRefrubishjob']['refurb_job_cost']) : 0;
               for ($i = 0; $i < $refurb; $i++) {
                    if (isset($datas['newRefrubishjob']['refurb_job'][$i])) {
                         $refArray = array(
                              'upgrd_refurb_master' => $refMaster,
                              'upgrd_expence_type' => (isset($datas['newRefrubishjob']['upgrd_expence_type'][$i]) && !empty(($datas['newRefrubishjob']['upgrd_expence_type'][$i]))) ? $datas['newRefrubishjob']['upgrd_expence_type'][$i] : 0,
                              'upgrd_master_id' => $datas['evaluationId'],
                              'upgrd_key' => (isset($datas['newRefrubishjob']['refurb_job'][$i]) && !empty(($datas['newRefrubishjob']['refurb_job'][$i]))) ? $datas['newRefrubishjob']['refurb_job'][$i] : 0,
                              'upgrd_value' => (isset($datas['newRefrubishjob']['refurb_job_cost'][$i]) && !empty($datas['newRefrubishjob']['refurb_job_cost'][$i])) ? $datas['newRefrubishjob']['refurb_job_cost'][$i] : 0,
                              'actual_job_description' => (isset($datas['newRefrubishjob']['actual_job_desc'][$i]) && !empty($datas['newRefrubishjob']['actual_job_desc'][$i])) ? $datas['newRefrubishjob']['actual_job_desc'][$i] : '',
                              'upgrd_refurb_actual_cost' => (isset($datas['newRefrubishjob']['newcost'][$i]) && !empty($datas['newRefrubishjob']['newcost'][$i])) ? $datas['newRefrubishjob']['newcost'][$i] : 0,
                              'upgrd_refurb_remarks' => (isset($datas['newRefrubishjob']['desc'][$i]) && !empty($datas['newRefrubishjob']['desc'][$i])) ? $datas['newRefrubishjob']['desc'][$i] : 0,
                              'upgrd_is_done' => 0,
                              'upgrd_added_by' => $this->uid,
                              'upgrd_added_on' => date('Y-m-d H:i:s'),
                              'upgrd_service_location' => (isset($datas['newRefrubishjob']['serviceat'][$i]) && !empty(($datas['newRefrubishjob']['serviceat'][$i]))) ? $datas['newRefrubishjob']['serviceat'][$i] : 0,
                              'upgrd_sgstp' => (isset($datas['newRefrubishjob']['sgstp'][$i]) && !empty(($datas['newRefrubishjob']['sgstp'][$i]))) ? $datas['newRefrubishjob']['sgstp'][$i] : 0,
                              'upgrd_sgst' => (isset($datas['newRefrubishjob']['sgst'][$i]) && !empty(($datas['newRefrubishjob']['sgst'][$i]))) ? $datas['newRefrubishjob']['sgst'][$i] : 0,
                              'upgrd_cgstp' => (isset($datas['newRefrubishjob']['cgstp'][$i]) && !empty(($datas['newRefrubishjob']['cgstp'][$i]))) ? $datas['newRefrubishjob']['cgstp'][$i] : 0,
                              'upgrd_cgst' => (isset($datas['newRefrubishjob']['cgst'][$i]) && !empty(($datas['newRefrubishjob']['cgst'][$i]))) ? $datas['newRefrubishjob']['cgst'][$i] : 0,
                              'upgrd_igstp' => (isset($datas['newRefrubishjob']['igstp'][$i]) && !empty(($datas['newRefrubishjob']['igstp'][$i]))) ? $datas['newRefrubishjob']['igstp'][$i] : 0,
                              'upgrd_igst' => (isset($datas['newRefrubishjob']['igst'][$i]) && !empty(($datas['newRefrubishjob']['igst'][$i]))) ? $datas['newRefrubishjob']['igst'][$i] : 0,
                              'upgrd_bill_no' => (isset($datas['newRefrubishjob']['billno'][$i]) && !empty(($datas['newRefrubishjob']['billno'][$i]))) ? $datas['newRefrubishjob']['billno'][$i] : '',
                              'upgrd_bill_date' => (isset($datas['newRefrubishjob']['billdt'][$i]) && !empty(($datas['newRefrubishjob']['billdt'][$i]))) ? date('Y-m-d', strtotime($datas['newRefrubishjob']['billdt'][$i])) : null,
                              'upgrd_act_est' => (isset($datas['newRefrubishjob']['upgrd_act_est'][$i])) ? $datas['newRefrubishjob']['upgrd_act_est'][$i] : 0
                         );
                         $this->db->insert($this->tbl_valuation_upgrade_details, $refArray);
                    }
               }
          }
          $this->updateRefurbActualCostMaster($datas['evaluationId']);
          return true;
     }

     function refurbisheReturnOld($datas)
     {
          generate_log(array(
               'log_title' => 'Refurbishment return',
               'log_desc' => serialize($datas),
               'log_controller' => 'refurbishe-return',
               'log_action' => 'U',
               'log_ref_id' => $datas['evaluationId'],
               'log_added_by' => $this->uid
          ));
          $val = $this->db->select('val_stock_num, val_veh_no, val_division')->get_where($this->tbl_valuation, array('val_id' => $datas['evaluationId']))->row_array();
          $vehNum = isset($val['val_veh_no']) ? str_replace('-', '', $val['val_veh_no']) : '';
          $stockNum = isset($val['val_stock_num']) ? $val['val_stock_num'] : '';

          $sstations = $this->getVendors();
          $expType = $this->getExpenceType();
          $divId = isset($val['val_division']) ? $val['val_division'] : 0;
          $gcCode = $this->db->get_where($this->tbl_company, array('cmp_division' => $divId))->row()->cmp_finance_year_code;

          if (isset($datas['refrubishjob']) && !empty($datas['refrubishjob'])) {
               foreach ($datas['refrubishjob'] as $key => $value) {
                    $isDone = isset($value['upgrd_is_done']) ? $value['upgrd_is_done'] : -1;

                    $billNoIndex = $key + 1;
                    $billNumberDefault = generate_inv_number($datas['evaluationId']);
                    $updatevalue['upgrd_expence_type'] = (isset($value['upgrd_expence_type']) && !empty($value['upgrd_expence_type'])) ? $value['upgrd_expence_type'] : 0;
                    $updatevalue['actual_job_description'] =  $value['actual_job_desc'];
                    $updatevalue['upgrd_refurb_actual_cost'] =  !empty($value['newcost']) ? $value['newcost'] : 0;
                    $updatevalue['upgrd_refurb_remarks'] =  $value['desc'];
                    $updatevalue['upgrd_is_done'] = 1;
                    $updatevalue['upgrd_updated_on'] = date('Y-m-d H:i:s');
                    $updatevalue['upgrd_updated_by'] = $this->uid;
                    $updatevalue['upgrd_service_location'] = !empty($value['serviceat']) ? $value['serviceat'] : 0;
                    $updatevalue['upgrd_sgstp'] = !empty($value['sgstp']) ? $value['sgstp'] : 0;
                    $updatevalue['upgrd_sgst'] = !empty($value['sgst']) ? $value['sgst'] : 0;
                    $updatevalue['upgrd_cgstp'] = !empty($value['cgstp']) ? $value['cgstp'] : 0;
                    $updatevalue['upgrd_cgst'] = !empty($value['cgst']) ? $value['cgst'] : 0;
                    $updatevalue['upgrd_igstp'] = !empty($value['igstp']) ? $value['igstp'] : 0;
                    $updatevalue['upgrd_igst'] = !empty($value['igst']) ? $value['igst'] : 0;
                    $updatevalue['upgrd_bill_no'] = !empty($value['billno']) ? $value['billno'] . '-' . $billNoIndex : $billNumberDefault . '-' . $billNoIndex;
                    $updatevalue['upgrd_bill_date'] = !empty($value['billdt']) ? date('Y-m-d', strtotime($value['billdt'])) : NULL;
                    $updatevalue['upgrd_act_est'] = isset($value['upgrd_act_est']) ? $value['upgrd_act_est'] : 0;

                    if (isset($value['upgrd_value']) && !empty($value['upgrd_value'])) {
                         $updatevalue['upgrd_value'] = $value['upgrd_value'];
                    } else if (isset($updatevalue['upgrd_value'])) {
                         unset($updatevalue['upgrd_value']);
                    }
                    $this->db->where('upgrd_id', $value['upgrd_id'])->update($this->tbl_valuation_upgrade_details, $updatevalue);

                    if ((float) $updatevalue['upgrd_refurb_actual_cost'] > 0) {
                         $GstAplcble = 0;
                         if (
                              !empty($updatevalue['upgrd_sgstp']) || !empty($updatevalue['upgrd_sgst']) || !empty($updatevalue['upgrd_cgstp']) || !empty($updatevalue['upgrd_cgst'])
                              || !empty($updatevalue['upgrd_igstp']) || !empty($updatevalue['upgrd_igst'])
                         ) {
                              $GstAplcble = 1;
                         }
                         $party = 'Unknown';
                         $expTypeVal = 'Unknown';
                         if (!empty($updatevalue['upgrd_service_location']) && ($updatevalue['upgrd_service_location'] > 0)) {
                              $foundKey = array_search($updatevalue['upgrd_service_location'], array_column($sstations, 'ven_id'));
                              $party = isset($sstations[$foundKey]['ven_name']) ? $sstations[$foundKey]['ven_name'] : 'Unknown';
                         }

                         if ((!empty($updatevalue['upgrd_expence_type']) && $updatevalue['upgrd_expence_type'] > 0)) {
                              $expTypeKey = array_search($updatevalue['upgrd_expence_type'], array_column($expType, 'ven_id'));
                              $expTypeVal = isset($expType[$expTypeKey]['ven_name']) ? $expType[$expTypeKey]['ven_name'] : 'Unknown';
                         }
                         //if ($isDone == 0 || $isDone == -1) { // upgrd_act_est
                         if (isset($value['upgrd_act_est']) && ($value['upgrd_act_est'] == 1)) {
                              $this->ihits->ihitsSaveExpense(array(
                                   'billNo' => $updatevalue['upgrd_bill_no'],
                                   'billDate' => $updatevalue['upgrd_bill_date'],
                                   'partyName' => $party,
                                   'registrationNo' => $vehNum,
                                   'expTotAmount' => (float) $updatevalue['upgrd_refurb_actual_cost'] + (float) $updatevalue['upgrd_sgst'] + (float) $updatevalue['upgrd_cgst'] + (float) $updatevalue['upgrd_igst'],
                                   'remarks' => $updatevalue['actual_job_description'] . ', ' . $updatevalue['upgrd_refurb_remarks'],
                                   'bookingNo' => $updatevalue['upgrd_bill_no'],
                                   'expType' => $expTypeVal,
                                   'expAmount' => (float) $updatevalue['upgrd_refurb_actual_cost'],
                                   'sgstPer' => (float) $updatevalue['upgrd_sgstp'],
                                   'sgstAmount' => (float) $updatevalue['upgrd_sgst'],
                                   'cgstPer' => (float) $updatevalue['upgrd_cgstp'],
                                   'cgstAmount' => (float) $updatevalue['upgrd_cgst'],
                                   'igstPer' => (float) $updatevalue['upgrd_igstp'],
                                   'igstAmount' => (float) $updatevalue['upgrd_igst'],
                                   'totalAmount' => (float) $updatevalue['upgrd_refurb_actual_cost'] + (float) $updatevalue['upgrd_sgst'] + (float) $updatevalue['upgrd_cgst'] + (float) $updatevalue['upgrd_igst'],
                                   'mode' => 'C',
                                   'stockID' => $stockNum,
                                   'gstAplcble' => (int)$GstAplcble,
                                   'gcCode' => (int)$gcCode
                              ), 0, 0, $datas['evaluationId'], $value['upgrd_id']);
                         }
                    }
                    //$refurbActCost = $refurbActCost + $updatevalue['upgrd_refurb_actual_cost'];
               }
          }

          if (isset($datas['newRefrubishjob']) && !empty($datas['newRefrubishjob'])) {

               $refurb = isset($datas['newRefrubishjob']['refurb_job']) ? count($datas['newRefrubishjob']['refurb_job']) : 0;
               for ($i = 0; $i < $refurb; $i++) {
                    $isDone = isset($datas['newRefrubishjob']['upgrd_is_done'][$i]) ? $datas['newRefrubishjob']['upgrd_is_done'][$i] : -1;
                    //foreach ($datas['newRefrubishjob'] as $key => $value) {
                    $billNumberDefault = generate_inv_number($datas['evaluationId']);
                    if (isset($datas['newRefrubishjob']['refurb_job'][$i])) {
                         $refArray = array(
                              'upgrd_expence_type' => (isset($datas['newRefrubishjob']['upgrd_expence_type'][$i]) && !empty(($datas['newRefrubishjob']['upgrd_expence_type'][$i]))) ? $datas['newRefrubishjob']['upgrd_expence_type'][$i] : 0,
                              'upgrd_master_id' => $datas['evaluationId'],
                              'upgrd_key' => (isset($datas['newRefrubishjob']['refurb_job'][$i]) && !empty(($datas['newRefrubishjob']['refurb_job'][$i]))) ? $datas['newRefrubishjob']['refurb_job'][$i] : 0,
                              'upgrd_value' => (isset($datas['newRefrubishjob']['refurb_job_cost'][$i]) && !empty($datas['newRefrubishjob']['refurb_job_cost'][$i])) ? $datas['newRefrubishjob']['refurb_job_cost'][$i] : 0,
                              'actual_job_description' => (isset($datas['newRefrubishjob']['actual_job_desc'][$i]) && !empty($datas['newRefrubishjob']['actual_job_desc'][$i])) ? $datas['newRefrubishjob']['actual_job_desc'][$i] : '',
                              'upgrd_refurb_actual_cost' => (isset($datas['newRefrubishjob']['newcost'][$i]) && !empty($datas['newRefrubishjob']['newcost'][$i])) ? $datas['newRefrubishjob']['newcost'][$i] : 0,
                              'upgrd_refurb_remarks' => (isset($datas['newRefrubishjob']['desc'][$i]) && !empty($datas['newRefrubishjob']['desc'][$i])) ? $datas['newRefrubishjob']['desc'][$i] : 0,
                              'upgrd_is_done' => 1,
                              'upgrd_added_by' => $this->uid,
                              'upgrd_added_on' => date('Y-m-d H:i:s'),
                              'upgrd_service_location' => (isset($datas['newRefrubishjob']['serviceat'][$i]) && !empty(($datas['newRefrubishjob']['serviceat'][$i]))) ? $datas['newRefrubishjob']['serviceat'][$i] : 0,
                              'upgrd_sgstp' => (isset($datas['newRefrubishjob']['sgstp'][$i]) && !empty(($datas['newRefrubishjob']['sgstp'][$i]))) ? $datas['newRefrubishjob']['sgstp'][$i] : 0,
                              'upgrd_sgst' => (isset($datas['newRefrubishjob']['sgst'][$i]) && !empty(($datas['newRefrubishjob']['sgst'][$i]))) ? $datas['newRefrubishjob']['sgst'][$i] : 0,
                              'upgrd_cgstp' => (isset($datas['newRefrubishjob']['cgstp'][$i]) && !empty(($datas['newRefrubishjob']['cgstp'][$i]))) ? $datas['newRefrubishjob']['cgstp'][$i] : 0,
                              'upgrd_cgst' => (isset($datas['newRefrubishjob']['cgst'][$i]) && !empty(($datas['newRefrubishjob']['cgst'][$i]))) ? $datas['newRefrubishjob']['cgst'][$i] : 0,
                              'upgrd_igstp' => (isset($datas['newRefrubishjob']['igstp'][$i]) && !empty(($datas['newRefrubishjob']['igstp'][$i]))) ? $datas['newRefrubishjob']['igstp'][$i] : 0,
                              'upgrd_igst' => (isset($datas['newRefrubishjob']['igst'][$i]) && !empty(($datas['newRefrubishjob']['igst'][$i]))) ? $datas['newRefrubishjob']['igst'][$i] : 0,
                              'upgrd_bill_no' => (isset($datas['newRefrubishjob']['billno'][$i]) && !empty(($datas['newRefrubishjob']['billno'][$i]))) ? $datas['newRefrubishjob']['billno'][$i] : $billNumberDefault,
                              'upgrd_bill_date' => (isset($datas['newRefrubishjob']['billdt'][$i]) && !empty(($datas['newRefrubishjob']['billdt'][$i]))) ? date('Y-m-d', strtotime($datas['newRefrubishjob']['billdt'][$i])) : null,
                              'upgrd_act_est' => (isset($datas['newRefrubishjob']['upgrd_act_est'][$i])) ? $datas['newRefrubishjob']['upgrd_act_est'][$i] : 0
                         );
                         $this->db->insert($this->tbl_valuation_upgrade_details, $refArray);
                         $rfId = $this->db->insert_id();
                         if ((float) $refArray['upgrd_refurb_actual_cost'] > 0) {
                              $GstAplcble = 0;
                              if (
                                   !empty($refArray['upgrd_sgstp']) || !empty($refArray['upgrd_sgst']) || !empty($refArray['upgrd_cgstp']) || !empty($refArray['upgrd_cgst'])
                                   || !empty($refArray['upgrd_igstp']) || !empty($refArray['upgrd_igst'])
                              ) {
                                   $GstAplcble = 1;
                              }
                              $party = 'Unknown';
                              $expTypeVal = 'Unknown';
                              if (!empty($refArray['upgrd_service_location']) && ($refArray['upgrd_service_location'] > 0)) {
                                   $foundKey = array_search($refArray['upgrd_service_location'], array_column($sstations, 'ven_id'));
                                   $party = isset($sstations[$foundKey]['ven_name']) ? $sstations[$foundKey]['ven_name'] : 'Unknown';
                              }
                              if (!empty($refArray['upgrd_expence_type']) && $refArray['upgrd_expence_type'] > 0) {
                                   $expTypeKey = array_search($refArray['upgrd_expence_type'], array_column($expType, 'ven_id'));
                                   $expTypeVal = isset($expType[$expTypeKey]['ven_name']) ? $expType[$expTypeKey]['ven_name'] : 'Unknown';
                              }
                              //if ($isDone == 0 || $isDone == -1) {

                              if (isset($datas['newRefrubishjob']['upgrd_act_est'][$i]) && ($datas['newRefrubishjob']['upgrd_act_est'][$i] == 1)) {
                                   $this->ihits->ihitsSaveExpense(array(
                                        'billNo' => $refArray['upgrd_bill_no'],
                                        'billDate' => $refArray['upgrd_bill_date'],
                                        'partyName' => $party,
                                        'registrationNo' => $vehNum,
                                        'expTotAmount' => $refArray['upgrd_refurb_actual_cost'] + (float) $refArray['upgrd_sgst'] + (float) $refArray['upgrd_cgst'] + (float) $refArray['upgrd_igst'],
                                        'remarks' => $refArray['actual_job_description'] . ', ' . $refArray['upgrd_refurb_remarks'],
                                        'bookingNo' => $refArray['upgrd_bill_no'],
                                        'expType' => $expTypeVal,
                                        'expAmount' => (float) $refArray['upgrd_refurb_actual_cost'],
                                        'sgstPer' => (float) $refArray['upgrd_sgstp'],
                                        'sgstAmount' => (float) $refArray['upgrd_sgst'],
                                        'cgstPer' => (float) $refArray['upgrd_cgstp'],
                                        'cgstAmount' => (float) $refArray['upgrd_cgst'],
                                        'igstPer' => (float) $refArray['upgrd_igstp'],
                                        'igstAmount' => (float) $refArray['upgrd_igst'],
                                        'totalAmount' => $refArray['upgrd_refurb_actual_cost'] + (float) $refArray['upgrd_sgst'] + (float) $refArray['upgrd_cgst'] + (float) $refArray['upgrd_igst'],
                                        'mode' => 'C',
                                        'stockID' => $stockNum,
                                        'gstAplcble' => $GstAplcble,
                                        'gcCode' => (int)$gcCode
                                   ), 0, 0, $datas['evaluationId'], $rfId);
                              }
                         }
                    }
                    //$newCost = (isset($datas['newRefrubishjob']['newcost'][$i]) && !empty($datas['newRefrubishjob']['newcost'][$i])) ? $datas['newRefrubishjob']['newcost'][$i] : 0;
                    //$refurbActCost = $refurbActCost + $newCost;
               }
          }
          $this->updateRefurbActualCostMaster($datas['evaluationId']);
     }

     function newvehiclefature($data)
     {
          $data['vftr_added_on'] = date('Y-m-d H:i:s');
          $data['vftr_abbed_by'] = $this->uid;
          $data['vftr_features_add_on'] = isset($data['vftr_features_add_on']) ? $data['vftr_features_add_on'] : 0;
          $data['vftr_order'] = $this->db->select_max('vftr_order')->get($this->tbl_vehicle_features)->row()->vftr_order + 1;
          $this->db->insert($this->tbl_vehicle_features, array_filter($data));
          $id = $this->db->insert_id();
          return array('id' => $id, 'name' => $data['vftr_feature'], 'isadon' => $data['vftr_features_add_on']);
     }

     //   jsk
     function getEvaluationDetails($id = '')
     {
          if (!empty($id)) {
               $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.val_id,' .
                    $this->tbl_valuation . '.val_stock_num,' . $this->tbl_valuation . '.val_stock_num_tmp,' .
                    $this->tbl_valuation . '.val_prt_1,' . $this->tbl_valuation . '.val_veh_no,' .
                    $this->tbl_valuation . '.val_cust_name,' . $this->tbl_valuation . '.val_rc_owner,' .
                    $this->tbl_valuation . '.val_chasis_no,' . $this->tbl_valuation . '.val_veh_no,' .
                    $this->tbl_valuation . '.val_valuation_date,' . $this->tbl_valuation . '.val_type,' .
                    $this->tbl_model . '.*,' .
                    $this->tbl_brand . '.brd_title,' . $this->tbl_brand . '.brd_id,' . $this->tbl_variant . '.var_variant_name,' .
                    $this->tbl_variant . '.var_id,' . $this->tbl_users . '.usr_username,' .
                    $this->tbl_users . '.usr_first_name,' . $this->tbl_showroom . '.*,' . $this->tbl_divisions . '.div_name,' .
                    $this->tbl_divisions . '.div_short_code,' .
                    'slsOfficer.usr_username AS so_usr_username, slsOfficer.usr_first_name AS so_usr_first_name,' .
                    'evtr.usr_first_name AS evtr_first_name, evtr.usr_last_name AS evtr_last_name,' . $this->tbl_banks . '.*')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                    ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_valuation . '.val_division', 'left')
                    ->join($this->tbl_users . ' slsOfficer', 'slsOfficer.usr_id = ' . $this->tbl_valuation . '.val_sales_officer', 'left')
                    ->join($this->tbl_banks, $this->tbl_banks . '.bnk_id = ' . $this->tbl_valuation . '.val_hypo_bank', 'left')
                    ->join($this->tbl_users . ' evtr', 'evtr.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                    ->where(array('val_id' => $id))->get($this->tbl_valuation)->row_array();

               if (!empty($EvaluationVehicle)) {
                    return $EvaluationVehicle;
               }
          }
     }

     function getCheck_listItemsByCategory($category_id = '')
     {
          if ($category_id) {
               $this->db->select('chitem_name, chitem_id');
               $this->db->where($this->tbl_chklist_cat_item . '.chitem_chcat_id', $category_id);
               $this->db->order_by("sort_order", "asc");
               $data['items'] = $this->db->from($this->tbl_chklist_cat_item)->get()->result();

               $this->db->where($this->tbl_chklist_category . '.chcat_id ', $category_id);
               $data['category'] = $this->db->from($this->tbl_chklist_category)->get()->row_array();
               return $data;
               //  $this->db->where($this->tbl_chklist_cat_item . '.chitem_chcat_id', $category_id);
               //  return $this->db->from($this->tbl_chklist_cat_item)->get()->result();
               // $this->db->where($this->table . '.chcat_id ', $category_id);
               //   return $this->db->select($this->tbl_chklist_cat_item . '.*,' . $this->table . '.*')->from($this->table)
               //                   ->join($this->tbl_chklist_cat_item, $this->table . '.chcat_id = ' . $this->tbl_chklist_cat_item . '.chitem_chcat_id','left')
               //                   ->get()->result();
          }
     }

     function insertPurchaseCheckListMaster($data)
     {
          if (!empty($data)) {
               if (isset($data['0'])) {
                    unset($data['0']);
               }
               $data['pcl_created_at'] = date('Y-m-d H:i:s');
               $data['pcl_added_by'] = $this->uid;
               $stkNum = isset($data['val_stock_num']) ? strtoupper($data['val_stock_num']) : '';
               unset($data['val_stock_num']);
               $data['pcl_stock_num'] = $stkNum;
               $this->db->insert($this->tbl_purchase_check_list, array_filter($data));
               $insert_id = $this->db->insert_id();
               $this->db->where('val_id', $data['pcl_val_id']); //update valuation cpnl_valuation val_status as 39
               $this->db->update($this->tbl_valuation, array('val_stock_num' => $stkNum, 'val_status' => add_stock, 'val_purchased_date' => date('Y-m-d H:i:s')));

               // add action details to cpnl_general_log table
               generate_log(array(
                    'log_title' => 'Insert purchase check list master and updated cpnl_valuation val_status as 39',
                    'log_desc' => serialize($data),
                    'log_controller' => 'insert-purchase-check-master',
                    'log_action' => 'C',
                    'log_ref_id' => $insert_id,
                    'log_added_by' => $this->uid
               ));
               return $insert_id;
          }
          return false;
     }

     function insertPurchaseCheckDetails($data)
     {
          if (!empty($data)) {
               $this->db->insert($this->tbl_purchase_check_list_details, array_filter($data));
               $insert_id = $this->db->insert_id();
               // add action details to cpnl_general_log table
               generate_log(array(
                    'log_title' => 'Insert purchase check list details',
                    'log_desc' => serialize($data),
                    'log_controller' => 'insert-purchase-check-details',
                    'log_action' => 'C',
                    'log_ref_id' => $insert_id,
                    'log_added_by' => $this->uid
               ));
               return $insert_id;
          }
          return false;
     }

     function updtPurchaseCheckDetails($data, $ChkDtl_id)
     {
          if (!empty($data)) {
               $this->db->where('pcld_id', $ChkDtl_id);
               $this->db->update($this->tbl_purchase_check_list_details, $data);
               $this->db->trans_complete();
               $res = $this->db->trans_status();

               // add action details to cpnl_general_log table
               generate_log(array(
                    'log_title' => 'Updated purchase check list details',
                    'log_desc' => serialize($data),
                    'log_controller' => 'updated-purchase-check-details',
                    'log_action' => 'C',
                    'log_ref_id' => $ChkDtl_id,
                    'log_added_by' => $this->uid
               ));

               return $res;
          }
          return false;
     }

     function getPurchase_check_list($masterId = '')
     {
          //For printing purpose
          if ($masterId) {
               $this->db->select($this->tbl_purchase_check_list . '.*,' . $this->tbl_valuation . '.val_stock_num,' .
                    $this->tbl_valuation . '.val_prt_1,' . $this->tbl_valuation . '.val_prt_2,' .
                    $this->tbl_valuation . '.val_prt_3,' . $this->tbl_valuation . '.val_prt_4,' . $this->tbl_valuation . '.val_status')
                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_purchase_check_list . '.pcl_val_id', 'LEFT')
                    ->where($this->tbl_purchase_check_list . '.pcl_check_list_id', $masterId);
               $data['masterData'] = $this->db->from($this->tbl_purchase_check_list)->get()->row_array();

               $this->db->select($this->tbl_purchase_check_list_details . '.*,' . $this->tbl_chklist_cat_item . '.chitem_name,' . $this->tbl_chklist_cat_item . '.chitem_id,' . $this->tbl_chklist_cat_item . '.sort_order,')
                    ->from($this->tbl_purchase_check_list_details)
                    ->where($this->tbl_purchase_check_list_details . '.pcld_check_list_master_id', $masterId)
                    ->join($this->tbl_chklist_cat_item, $this->tbl_chklist_cat_item . '.chitem_id  = ' . $this->tbl_purchase_check_list_details . '.pcld_check_list_item_id', 'LEFT');

               $this->db->order_by($this->tbl_chklist_cat_item . ".sort_order", "asc");
               $data['detailsData'] = $this->db->get()->result();
               return $data;
          } else {
               return false;
          }
     }

     function getPrchsChkMstrID($evalId = '')
     {
          if ($evalId) {
               $this->db->select($this->tbl_purchase_check_list . '.pcl_check_list_id,' . $this->tbl_purchase_check_list . '.pcl_created_at,')
                    ->where($this->tbl_purchase_check_list . '.pcl_val_id', $evalId);
               $prchsChkId = $this->db->from($this->tbl_purchase_check_list)->get()->row_array();
               return $prchsChkId;
          }
     }

     function getRefurbMaster($evalId = '')
     {
          return $this->db->select($this->tbl_valuation_upgrade_master . '.*,' . $this->tbl_users . '.usr_username AS usr_username_added_by,' .
               $this->tbl_vendors . '.ven_name')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation_upgrade_master . '.vum_added_by', 'LEFT')
               ->join($this->tbl_vendors, $this->tbl_vendors . '.ven_id = ' . $this->tbl_valuation_upgrade_master . '.vum_vendor', 'LEFT')
               ->where($this->tbl_valuation_upgrade_master . '.vum_val_id', $evalId)->get($this->tbl_valuation_upgrade_master)->result_array();
     }

     function getRefurbDetails($evalId = '', $refMaster = 0)
     {
          if ($evalId) {
               if (!empty($refMaster)) {
                    $this->db->where($this->tbl_valuation_upgrade_details . '.upgrd_refurb_master', $refMaster);
               }
               $this->db->select($this->tbl_valuation_upgrade_details . '.*,' . $this->tbl_users . '.usr_username AS usr_username_added_by,' .
                    $this->tbl_vendors . '.ven_name')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation_upgrade_details . '.upgrd_added_by', 'LEFT')
                    ->join($this->tbl_vendors, $this->tbl_vendors . '.ven_id = ' . $this->tbl_valuation_upgrade_details . '.upgrd_service_location', 'LEFT')
                    ->where($this->tbl_valuation_upgrade_details . '.upgrd_master_id', $evalId);
               $data['refrbData'] = $this->db->get($this->tbl_valuation_upgrade_details)->result();
               return $data['refrbData'];
          }
     }

     function getChkDtls($chitem_id = 0, $chkMstrId)
     {

          if ($chitem_id && $chkMstrId) {
               $row = $this->db->get_where(
                    $this->tbl_purchase_check_list_details,
                    array('pcld_check_list_item_id' => $chitem_id, 'pcld_check_list_master_id' => $chkMstrId)
               )->row();
               return $row;
          }
          return false;
     }
     function getEvaluationForRefurbRetn($id = '')
     {
          $EvaluationVehicle['upgradeDetails'] = $this->db->get_where(
               $this->tbl_valuation_upgrade_details,
               array('upgrd_master_id' => $id, 'upgrd_is_done' => 0)
          )->result_array();
          $EvaluationVehicle['val_id'] = $id;
          return $EvaluationVehicle;
     }
     function getChklstItemName($id)
     {
          if ($id) {
               return $this->db->select($this->tbl_chklist_cat_item . '.chitem_name')->get_where($this->tbl_chklist_cat_item, array('chitem_id' => $id))->row();
          }
          return false;
     }

     function getTypeByEvalId($id = '')
     {
          /* fetch type id from evaluation tbl to display Purchase type in Purchase_check_list_print and print_tab */
          if (!empty($id)) {
               $row = $this->db->select($this->tbl_valuation . '.val_type,')->get_where($this->tbl_valuation, array('val_id ' => $id))->row();
               return @$row->val_type;
          }
          return false;
     }
     // @jsk

     function forceDelete($id)
     {
          if (!empty($id)) {
               $this->db->where('val_id', $id)->delete($this->tbl_valuation);
               $this->db->where('comp_val_id', $id)->delete($this->tbl_valuation_complaint);
               $this->db->where('vdoc_val_id', $id)->delete($this->tbl_valuation_documents);
               $this->db->where('vfet_valuation', $id)->delete($this->tbl_valuation_features);
               $this->db->where('vfbc_valuation_master', $id)->delete($this->tbl_valuation_ful_bd_chkup);
               $this->db->where('upgrd_master_id', $id)->delete($this->tbl_valuation_upgrade_details);
               $this->db->where('vvi_val_id', $id)->delete($this->tbl_valuation_veh_images);

               generate_log(array(
                    'log_title' => 'Evaluation permenent deleted',
                    'log_desc' => 'Evaluation permenent deleted',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'D',
                    'log_ref_id' => $id,
                    'log_added_by' => $this->uid
               ));
               return true;
          } else {
               return false;
          }
     }


     //@jsk
     function getDelco()
     {
          //21 - Delivery Coordinator
          //15 - Dy Manager - Inventory
          //64 - Evaluator Sourcer
          //49 - 
          return $this->db->select('usr_id, usr_username, usr_first_name, usr_last_name, shr_location')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->where_in('usr_designation_new', array(21, 15, 64, 49))->or_where('usr_id', 949)->get($this->tbl_users)->result_array();
     }

     function getMISEvaluation()
     {
          //09 - Team Cooridnator
          //38 - MIS Coordinator
          //66 - MIS Coordinator-purchase
          //33 - Admin Executive-Purchase
          return $this->db->select('usr_id, usr_username, usr_first_name, usr_last_name, shr_location')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->where_in('usr_designation_new', array(9, 38, 66, 33))->get($this->tbl_users)->result_array();
     }

     function getAdmins()
     {
          //03 - Admin
          //36 - Admin Executive
          return $this->db->select('usr_id, usr_username, usr_first_name, usr_last_name, shr_location')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->where_in('usr_designation_new', array(3, 36))->get($this->tbl_users)->result_array();
     }

     function procurementStaff()
     {
          $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
               ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
               ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0));
          return $this->db->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
     }

     function getTelecaller()
     {
          //14 - Telecaller
          return $this->db->select('usr_id, usr_username, usr_first_name, usr_last_name, shr_location')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->where_in('usr_designation_new', array(14))->get($this->tbl_users)->result_array();
     }

     function getTelesalesCoordinator()
     {
          //43 - Tele Sales Coordinator
          return $this->db->select('usr_id, usr_username, usr_first_name, usr_last_name, shr_location')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->where_in('usr_designation_new', array(43))->get($this->tbl_users)->result_array();
     }

     function getTelePurchaseCoordinator()
     {
          //59 - Tele Purchase Coordinator
          return $this->db->select('usr_id, usr_username, usr_first_name, usr_last_name, shr_location')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->where_in('usr_designation_new', array(59))->get($this->tbl_users)->result_array();
     }

     function getStaffByGroup($tblfield)
     {
          return $this->db->select('usr_id, usr_username, usr_first_name, usr_last_name, shr_location')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->where($tblfield, 1)->get($this->tbl_users)->result_array();
     }

     function getDochistry($valId)
     {
          $selectArray = array(
               $this->tbl_valuation_doc_history . '.*',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_last_name',
               $this->tbl_users . '.usr_username',
               $this->tbl_users . '.usr_avatar',
               $this->tbl_showroom . '.shr_location'
          );
          return $this->db->select($selectArray)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation_doc_history . '.vdh_added_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation_doc_history . '.vdh_location', 'LEFT')
               ->order_by($this->tbl_valuation_doc_history . '.vdh_added_on', 'DESC')->where($this->tbl_valuation_doc_history . '.vdh_val_id', $valId)
               ->where('vdh_status', 1)->get($this->tbl_valuation_doc_history)->result_array();
     }

     function updateDocumentDetals($data)
     {
          $data['vdh_added_id'] = $this->uid;
          $data['vdh_location'] = $this->shrm;
          $data['vdh_added_on'] = date('Y-m-d H:i:s');
          $this->db->insert($this->tbl_valuation_doc_history, $data);
          $data['vdh_id'] = $this->db->insert_id();
          generate_log(array(
               'log_title' => 'New stock document updation',
               'log_desc' => 'stock-doc-update',
               'log_controller' => strtolower(__CLASS__),
               'log_action' => 'C',
               'log_ref_id' => $data['vdh_id'],
               'log_added_by' => $this->uid
          ));

          $selectArray = array(
               $this->tbl_valuation_doc_history . '.*',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_last_name',
               $this->tbl_users . '.usr_username',
               $this->tbl_users . '.usr_avatar',
               $this->tbl_showroom . '.shr_location'
          );
          return $this->db->select($selectArray)
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation_doc_history . '.vdh_added_id', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation_doc_history . '.vdh_location', 'LEFT')
               ->order_by($this->tbl_valuation_doc_history . '.vdh_added_on', 'DESC')
               ->where($this->tbl_valuation_doc_history . '.vdh_id', $data['vdh_id'])->get($this->tbl_valuation_doc_history)->row_array();
     }

     function changeEvaluationStatus($data)
     {
          $this->db->where('val_id', $data['val_id'])->update($this->tbl_valuation, array('val_status' => $data['val_status'], 'val_status_cmd' => $data['val_cmd']));
          generate_log(array(
               'log_title' => 'Valuation stock status changed',
               'log_desc' => serialize($data),
               'log_controller' => 'stock-sts-update',
               'log_action' => 'U',
               'log_ref_id' => $data['vdh_id'],
               'log_added_by' => $this->uid
          ));
          return true;
     }
     //JSK
     function isVehicleEvaluated($valuationId)
     {
          //check vehicle is evaluated or not 
          $result = $this->db->where("val_id", $valuationId)->where_in('val_status', [add_stock, vehicle_evaluated])->get($this->tbl_valuation)->num_rows();
          if ($result > 0) {
               return true;
          }
          return false;
     }
     function getRTO()
     {
          return $this->db->order_by('rto_place', 'ASC')->get_where($this->tbl_rto_office, array('rto_state' => 1))->result_array();
     }
     function getColors()
     {
          return $this->db->order_by('vc_color', 'ASC')->get_where($this->tbl_vehicle_colors, array('vc_status' => 1))->result_array();
     }
     function insuranceDetails($veh_id = '')
     { //any_top_up_loan
          // return 123456;
          // exit;
          if ($veh_id) {
               $data = $this->db->select('val_insurance_company as insurance_company,val_insurance_comp_date as valid_up_to,val_insurance_ll_date,val_insurance_comp_idv as idv,val_insurance_ll_idv as ncb_percentage ,val_insurance_need_ncb as ncb_req,val_insurance as insurance_type ,val_hypo_bank as bank,val_hypo_bank_branch as bank_branch,val_hypo_close_by_cust,val_hypo_loan_date as loan_starting_date,val_hypo_loan_end_date as loan_ending_date,val_hypo_daily_int as daily_interest,val_hypo_frclos_val as forclousure_value,val_hypo_frclos_date as forclousure_date,val_hypo_loan_amt as loan_amount,val_top_up_loan as any_top_up_loan,val_hypo_close_by_cust')
                    //   $data = $this->db->select('val_insurance_company')
                    ->where('val_vehicle_id', $veh_id)->get($this->tbl_valuation)->row_array();
               return $data;
          }
          return false;
     }

     function getTyre()
     {
          return $this->db->order_by('tyc_name')->get($this->tbl_tyres_comp)->result_array();
     }
     //@jsk

     function getVehicleForPush($id)
     {
          $this->load->model('enquiry/enquiry_model', 'enquiry');
          if (!empty($id)) {
               // $selectArray(
               //      $this->tbl_valuation . '.',
               // );
               $EvaluationVehicle = $this->db->select(
                    $this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
                         $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.usr_username,' .
                         $this->tbl_users . '.usr_first_name,' . $this->tbl_showroom . '.*,' . $this->tbl_divisions . '.div_name,' .
                         'slsOfficer.usr_username AS so_usr_username, slsOfficer.usr_first_name AS so_usr_first_name,' .
                         'evtr.usr_first_name AS evtr_first_name, evtr.usr_last_name AS evtr_last_name,' . $this->tbl_banks . '.*,' .
                         'mis.usr_first_name AS mis_first_name, mis.usr_last_name AS mis_last_name,' .
                         'delco.usr_first_name AS delco_first_name, delco.usr_last_name AS delco_last_name,' .
                         'sadmin.usr_first_name AS sadmin_first_name, sadmin.usr_last_name AS sadmin_last_name,' .
                         'padmin.usr_first_name AS padmin_first_name, padmin.usr_last_name AS padmin_last_name,' .
                         'telclr.usr_first_name AS telclr_first_name, telclr.usr_last_name AS telclr_last_name,' .
                         'apmasm.usr_first_name AS apmasm_first_name, apmasm.usr_last_name AS apmasm_last_name,' .
                         'tsc.usr_first_name AS tsc_first_name, tsc.usr_last_name AS tsc_last_name,' .
                         $this->tbl_statuses . '.sts_title, ' . $this->tbl_statuses . '.sts_des, ' .
                         $this->tbl_vehicle_colors . '.vc_color AS val_color'
               )
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                    ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_valuation . '.val_division', 'left')
                    ->join($this->tbl_users . ' slsOfficer', 'slsOfficer.usr_id = ' . $this->tbl_valuation . '.val_sales_officer', 'left')
                    ->join($this->tbl_banks, $this->tbl_banks . '.bnk_id = ' . $this->tbl_valuation . '.val_hypo_bank', 'left')
                    ->join($this->tbl_users . ' evtr', 'evtr.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                    ->join($this->tbl_users . ' mis', 'mis.usr_id = ' . $this->tbl_valuation . '.val_mis', 'left')
                    ->join($this->tbl_users . ' delco', 'delco.usr_id = ' . $this->tbl_valuation . '.val_delco', 'left')
                    ->join($this->tbl_users . ' sadmin', 'sadmin.usr_id = ' . $this->tbl_valuation . '.val_admin', 'left')
                    ->join($this->tbl_users . ' padmin', 'padmin.usr_id = ' . $this->tbl_valuation . '.val_purchase_admin', 'left')
                    ->join($this->tbl_users . ' telclr', 'telclr.usr_id = ' . $this->tbl_valuation . '.val_tele_caller', 'left')
                    ->join($this->tbl_users . ' apmasm', 'apmasm.usr_id = ' . $this->tbl_valuation . '.val_apm_asm', 'left')
                    ->join($this->tbl_users . ' tsc', 'tsc.usr_id = ' . $this->tbl_valuation . '.val_tsc', 'left')
                    ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_valuation . '.val_status', 'LEFT')
                    ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_valuation . '.val_color', 'left')
                    ->where(array('val_id' => $id))->get($this->tbl_valuation)->row_array();
               return $EvaluationVehicle;
          }
     }

     function refurbDetails($id)
     {
          return $this->db->select($this->tbl_valuation_upgrade_details . '.*,' . $this->tbl_vendors . '.ven_name')
               ->join($this->tbl_vendors, $this->tbl_vendors . '.ven_id = ' . $this->tbl_valuation_upgrade_details . '.upgrd_service_location', 'LEFT')
               ->where($this->tbl_valuation_upgrade_details . '.upgrd_master_id', $id)->get($this->tbl_valuation_upgrade_details)->result_array();
     }
}
