<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class purchase_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->db->query("SET time_zone = '+05:30'");

          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_company = TABLE_PREFIX . 'company';
          $this->tbl_divisions = TABLE_PREFIX . 'divisions';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
          $this->tbl_mou_master = TABLE_PREFIX . 'mou_master';
          $this->tbl_purchase = TABLE_PREFIX . 'purchase';
          $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
          $this->tbl_state = TABLE_PREFIX . 'states';
          $this->tbl_district = TABLE_PREFIX . 'district_statewise';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
     }


     function getData($val_id)
     {
          $data['mou'] = $this->db->select(array(
               'moum_number', 'moum_reg_num', 'moum_adv_token', 'moum_stock_num', 'moum_net_price', 'moum_vehicle_category',
               'moum_purchase_type', 'moum_fin_year_code', 'moum_customer_name', 'std_district_name'
          ))->join($this->tbl_district, "{$this->tbl_district}.std_id = {$this->tbl_mou_master}.moum_dist", 'left')
               ->get($this->tbl_mou_master)->result_array();
          $this->db->where('val_id', $val_id);
          $data['valuation'] = $this->db->select("`{$this->tbl_valuation}`.`val_refurb_cost`, `{$this->tbl_valuation}`.`val_trade_in_price`") //
               ->get($this->tbl_valuation)
               ->row_array();
          return $data;
     }
     function getValData()
     {
          return $this->db->select($this->tbl_valuation . '.val_id,' . $this->tbl_valuation . '.val_veh_no, ' . $this->tbl_valuation . '.val_stock_num')
               ->where('(val_prt_1 IS NOT NULL AND val_prt_2 IS NOT NULL AND val_prt_4 IS NOT NULL)')
               ->where("(val_status != 77 AND val_veh_no IS NOT NULL AND val_veh_no != '')")
               ->where("(val_prt_1 != '' AND val_prt_2 != '' AND val_prt_4 != '')")
               ->get($this->tbl_valuation)->result_array();
     }
     function getMou()
     {
          $data = $this->db->select("`{$this->tbl_mou_master}`.`moum_number`, `{$this->tbl_mou_master}`.`moum_reg_num`, `{$this->tbl_mou_master}`.`moum_adv_token`") //
               ->get($this->tbl_mou_master)
               ->result_array();
          return $data;
     }

     function gePurchaseData($id)
     {
          $this->db->where('pr_id', $id);
          return $this->db->select($this->tbl_purchase . '.*')->get($this->tbl_purchase)->row_array();
     }

     function insert($data)
     {
          if (!empty($data)) {
               $this->db->where('val_id', $data['pr_val_id']);
               $valData = $this->db->select("`{$this->tbl_valuation}`.`val_stock_num`")
                    ->get($this->tbl_valuation)
                    ->row_array();
               if ($valData['val_stock_num'] == '') { //0TMP-KL202311208989
                    if (isset($data['pr_stocknum']) && !empty($data['pr_stocknum'])) {
                         $stockNumber = $data['pr_stocknum'];
                    } else {
                         $divCode = ($this->div == 1) ? 'S' : 'L';
                         $stockNumber = $divCode . 'KL' . date('Ym') . generate_vehicle_virtual_id($data['pr_val_id']);
                    }
                    $this->db->where('val_id', $data['pr_val_id']);
                    $this->db->update($this->tbl_valuation, array('val_stock_num_tmp' => $stockNumber)); //
               }

               $data['pr_added_by'] = $this->uid;
               $data['pr_added_date'] = date('Y-m-d H:i:s');
               $data['pr_brokerage_per'] = (isset($data['pr_brokerage_per']) && !empty($data['pr_brokerage_per'])) ? $data['pr_brokerage_per'] : 0;
               $data['pr_agreement_date'] = (isset($data['pr_agreement_date']) && !empty($data['pr_agreement_date'])) ? date('Y-m-d', strtotime($data['pr_agreement_date'])) : NULL;
               $data['pr_division'] = $this->div;
               $data['pr_showroom'] =  get_logged_user('usr_showroom');
               if ($this->db->insert($this->tbl_purchase, array_filter($data))) {
                    $lastId = $this->db->insert_id();
                    generate_log(array(
                         'log_title' => 'Create purchase' . date('Y-m-d H:i:s'),
                         'log_desc' => serialize($data),
                         'log_controller' => 'purchase',
                         'log_action' => 'C',
                         'log_ref_id' => $lastId,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    return $lastId;
               } else {
                    generate_log(array(
                         'log_title' => 'New records',
                         'log_desc' => 'Error while issue new purchase',
                         'log_controller' => 'purchase',
                         'log_action' => 'C',
                         'log_added_by' => get_logged_user('usr_id')
                    ));
               }
          } else {
               return false;
          }
     }

     function updateApproval($data)
     {
          if (!empty($data)) {
               $approved_by = $data['pr_approve'] != 0 ? $this->uid : 0;
               $id = $data['pr_id'];
               unset($data['pr_approve']);
               $data['pr_approved_by'] =  $approved_by;
               $data['pr_approved_on'] = date('Y-m-d H:i:s');
               //debug($data);
               $this->db->where('pr_id', $id);

               if ($this->db->update($this->tbl_purchase, $data)) {
                    generate_log(array(
                         'log_title' => 'Update purchase Approval ' . date('Y-m-d H:i:s'),
                         'log_desc' => serialize($data),
                         'log_controller' => 'update-purchase approval',
                         'log_action' => 'U',
                         'log_ref_id' => $id,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    return true;
               } else {
                    generate_log(array(
                         'log_title' => 'Update purchase approval',
                         'log_desc' => 'Error on update approval',
                         'log_controller' => 'update-purchase-approval',
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


     /* function getPurcasePaginate_bk($postDatas)
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

          if ($this->uid != 100 && check_permission('purchase', 'purchase_view_my_staff')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
          }
          $totalRecords = $this->getPurcaseTotal($searchValue);

          //  debug(21);
          $this->db->where($this->tbl_purchase . '.pr_approved_by', 0);
          if ($this->uid != 100) {
               $permissions = array();

               if (check_permission('purchase', 'purchase_view_smart')) {
                    $permissions[] = "cpnl_purchase.pr_division = 1";
               }
               if (check_permission('purchase', 'purchase_view_luxury')) {
                    $permissions[] = "cpnl_purchase.pr_division = 2";
               }
               if (check_permission('purchase', 'purchase_view_self')) {
                    $permissions[] = "cpnl_purchase.pr_added_by = " . $this->uid;
               }
               if (check_permission('purchase', 'purchase_view_my_showroom')) {
                    $permissions[] = "cpnl_purchase.pr_showroom = " . $this->shrm;
               }
               if (check_permission('purchase', 'purchase_view_my_staff')) {
                    $permissions[] = "cpnl_purchase.pr_added_by IN (" . implode(',', $mystaffs) . ")";
               }

               $permissionsSql = implode(' OR ', $permissions);

               if (!empty($permissionsSql)) {
                    $this->db->where("($permissionsSql)");
               }
          }

          $selArray = array(
               $this->tbl_purchase . '.pr_id',
               $this->tbl_purchase . '.pr_approved_by',
               $this->tbl_purchase . '.pr_enq_id',
               $this->tbl_purchase . '.pr_val_id',
               $this->tbl_purchase . '.pr_val_type',
               $this->tbl_purchase . '.pr_sourcing_type',
               $this->tbl_purchase . '.pr_mou_no',
               $this->tbl_purchase . '.pr_reg_no',
               $this->tbl_purchase . '.pr_total',
               $this->tbl_purchase . '.pr_refurb_total',
               $this->tbl_purchase . '.pr_advance',
               $this->tbl_purchase . '.pr_fine',
               $this->tbl_purchase . '.pr_brokerage',
               $this->tbl_purchase . '.pr_insurance',
               $this->tbl_purchase . '.pr_remarks',
               $this->tbl_purchase . '.pr_val_id',
               $this->tbl_purchase . '.pr_added_by',
               "DATE_FORMAT(" . $this->tbl_purchase . ".pr_added_date, '%d-%m-%Y') AS pr_added_date",
               'addeddBy.usr_username AS added_usr_username', $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile'
          );

          if (!empty($searchValue)) {
               $this->db->where("(pr_mou_no LIKE '%" . $searchValue . "%' OR pr_reg_no LIKE '%" . $searchValue . "%' OR addeddBy.usr_username LIKE '%" . $searchValue . "%') ");
          }

          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }

          $data = $this->db->select($selArray)
               ->join($this->tbl_users . ' addeddBy', 'addeddBy.usr_id = ' . $this->tbl_purchase . '.pr_added_by', 'left')
               //->join($this->tbl_mou_master, $this->tbl_mou_master . '.moum_number = ' . $this->tbl_purchase . '.pr_mou_no', 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_purchase . '.pr_enq_id', 'LEFT')
               ->get($this->tbl_purchase)->result_array();
          //  echo $this->db->last_query();
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }*/


     function getPurcasePaginate($postDatas)
     {

          // Initialize error reporting
          error_reporting(E_ALL);
          ini_set('display_errors', 1);

          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value

          if ($this->uid != 100 && check_permission('purchase', 'purchase_view_my_staff')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
          }
          $totalRecords = $this->getPurcaseTotal($searchValue);

          // Applying WHERE conditions
          // $this->db->where($this->tbl_purchase . '.pr_approved_by', 0);
          if ($this->uid != 100) {
               $permissions = array();

               if (check_permission('purchase', 'purchase_view_smart')) {
                    $permissions[] = "cpnl_purchase.pr_division = 1";
               }
               if (check_permission('purchase', 'purchase_view_luxury')) {
                    $permissions[] = "cpnl_purchase.pr_division = 2";
               }
               if (check_permission('purchase', 'purchase_view_self')) {
                    $permissions[] = "cpnl_purchase.pr_added_by = " . $this->uid;
               }
               if (check_permission('purchase', 'purchase_view_my_showroom')) {
                    $permissions[] = "cpnl_purchase.pr_showroom = " . $this->shrm;
               }
               if (check_permission('purchase', 'purchase_view_my_staff')) {
                    $permissions[] = "cpnl_purchase.pr_added_by IN (" . implode(',', $mystaffs) . ")";
               }

               $permissionsSql = implode(' OR ', $permissions);

               if (!empty($permissionsSql)) {
                    $this->db->where("($permissionsSql)");
               }
          }

          // Selecting columns
          $this->db->select([
               $this->tbl_purchase . '.pr_id',
               $this->tbl_purchase . '.pr_approved_by',
               $this->tbl_purchase . '.pr_enq_id',
               $this->tbl_purchase . '.pr_val_id',
               $this->tbl_purchase . '.pr_val_type',
               $this->tbl_purchase . '.pr_sourcing_type',
               $this->tbl_purchase . '.pr_mou_no',
               $this->tbl_purchase . '.pr_reg_no',
               $this->tbl_purchase . '.pr_total',
               $this->tbl_purchase . '.pr_refurb_total',
               $this->tbl_purchase . '.pr_advance',
               $this->tbl_purchase . '.pr_fine',
               $this->tbl_purchase . '.pr_brokerage',
               $this->tbl_purchase . '.pr_insurance',
               $this->tbl_purchase . '.pr_remarks',
               $this->tbl_purchase . '.pr_added_by',
               "DATE_FORMAT(" . $this->tbl_purchase . ".pr_added_date, '%d-%m-%Y') AS pr_added_date",
               'addeddBy.usr_username AS added_usr_username',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name'
          ]);

          // Applying search condition
          if (!empty($searchValue)) {
               $this->db->like('pr_mou_no', $searchValue);
               $this->db->or_like('pr_reg_no', $searchValue);
               $this->db->or_like('addeddBy.usr_username', $searchValue);
          }

          // Applying pagination
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }

          // Getting data
          $data = $this->db->from($this->tbl_purchase)
               ->join($this->tbl_users . ' addeddBy', 'addeddBy.usr_id = ' . $this->tbl_purchase . '.pr_added_by', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_purchase . '.pr_enq_id', 'LEFT')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_purchase . '.pr_val_id', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'LEFT')
               ->get()->result_array();

          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }

     function getPurcaseTotal($searchValue)
     {
          if ($this->uid != 100 && check_permission('purchase', 'purchase_view_my_staff')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
          }

          // $this->db->where($this->tbl_purchase . '.pr_approved_by', 0);
          if ($this->uid != 100) {
               $permissions = array();

               if (check_permission('purchase', 'purchase_view_smart')) {
                    $permissions[] = "cpnl_purchase.pr_division = 1";
               }
               if (check_permission('purchase', 'purchase_view_luxury')) {
                    $permissions[] = "cpnl_purchase.pr_division = 2";
               }
               if (check_permission('purchase', 'purchase_view_self')) {
                    $permissions[] = "cpnl_purchase.pr_added_by = " . $this->uid;
               }
               if (check_permission('purchase', 'purchase_view_my_showroom')) {
                    $permissions[] = "cpnl_purchase.pr_showroom = " . $this->shrm;
               }
               if (check_permission('purchase', 'purchase_view_my_staff')) {
                    $permissions[] = "cpnl_purchase.pr_added_by IN (" . implode(',', $mystaffs) . ")";
               }

               $permissionsSql = implode(' OR ', $permissions);
               if (!empty($permissionsSql)) {
                    $this->db->where("($permissionsSql)");
               }
          }

          $this->db->join($this->tbl_users . ' addeddBy', 'addeddBy.usr_id = ' . $this->tbl_purchase . '.pr_added_by', 'left');

          // $this->db->join($this->tbl_mou_master, $this->tbl_mou_master . '.moum_number = ' . $this->tbl_purchase . '.pr_mou_no', 'LEFT');

          // Apply any additional conditions here based on  searchValue

          $this->db->from($this->tbl_purchase);
          return $this->db->count_all_results();
     }



     function getPurcasePaginateTest($postDatas)
     {
          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $start = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $length = isset($postDatas['length']) ? $postDatas['length'] : 0;
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : '';

          // Initialize base query
          $this->db->select('p.*, u.usr_username, e.enq_cus_name, e.enq_cus_mobile, b.br_title');
          $this->db->from($this->tbl_purchase . ' p');
          $this->db->join($this->tbl_users . ' u', 'u.usr_id = p.pr_added_by', 'left');
          $this->db->join($this->tbl_enquiry . ' e', 'e.enq_id = p.pr_enq_id', 'left');
          $this->db->join($this->tbl_valuation . ' v', 'v.val_id = p.pr_val_id', 'left');
          $this->db->join($this->tbl_brand . ' b', 'b.brd_id = v.val_brand', 'left');

          // Apply search filter
          if (!empty($searchValue)) {
               $this->db->group_start();
               $this->db->like('p.pr_mou_no', $searchValue);
               $this->db->or_like('p.pr_reg_no', $searchValue);
               $this->db->or_like('u.usr_username', $searchValue);
               $this->db->group_end();
          }

          // Apply pagination
          if ($length > 0) {
               $this->db->limit($length, $start);
          }

          // Get total records count before pagination
          $totalRecords = $this->db->count_all_results();

          // Reset query builder for fetching actual data
          $this->db->select('p.*, u.usr_username, e.enq_cus_name, e.enq_cus_mobile, b.br_title');
          $this->db->from($this->tbl_purchase . ' p');
          $this->db->join($this->tbl_users . ' u', 'u.usr_id = p.pr_added_by', 'left');
          $this->db->join($this->tbl_enquiry . ' e', 'e.enq_id = p.pr_enq_id', 'left');
          $this->db->join($this->tbl_valuation . ' v', 'v.val_id = p.pr_val_id', 'left');
          $this->db->join($this->tbl_brand . ' b', 'b.brd_id = v.val_brand', 'left');


          // Apply search filter again for fetching data
          if (!empty($searchValue)) {
               $this->db->group_start();
               $this->db->like('p.pr_mou_no', $searchValue);
               $this->db->or_like('p.pr_reg_no', $searchValue);
               $this->db->or_like('u.usr_username', $searchValue);
               $this->db->group_end();
          }

          $data = $this->db->get()->result_array();

          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords, // Count without pagination
               "aaData" => $data
          );

          return $response;
     }

     function getApprovedPaginate($postDatas)
     {
          if ($this->uid != 100 && check_permission('purchase', 'purchase_view_my_staff')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
          }
          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value
          $totalRecords = $this->getApprovedTotal($searchValue);
          $selArray = array(
               $this->tbl_purchase . '.pr_id',
               $this->tbl_purchase . '.pr_enq_id',
               $this->tbl_purchase . '.pr_mou_no', //need to change pr_mou_id
               $this->tbl_purchase . '.pr_reg_no',
               $this->tbl_purchase . '.pr_total',
               $this->tbl_purchase . '.pr_refurb_total',
               $this->tbl_purchase . '.pr_advance',
               $this->tbl_purchase . '.pr_fine',
               $this->tbl_purchase . '.pr_brokerage',
               $this->tbl_purchase . '.pr_insurance',
               $this->tbl_purchase . '.pr_approve_remarks',
               $this->tbl_purchase . '.pr_val_id',
               $this->tbl_purchase . '.pr_added_by',
               "DATE_FORMAT(" . $this->tbl_purchase . ".pr_added_date, '%m-%d-%Y') AS pr_added_date",
               'addeddBy.usr_username AS added_usr_username',
               "DATE_FORMAT(" . $this->tbl_purchase . ".pr_approved_on, '%d-%m-%Y') AS pr_approved_on",
               'approvedBy.usr_username AS approvedBy'
          );
          if (!empty($searchValue)) {
               $this->db->where("(pr_mou_no LIKE '%" . $searchValue . "%' OR pr_reg_no LIKE '%" . $searchValue . "%' OR "
                    . "addeddBy.usr_username LIKE '%" . $searchValue . "%' OR approvedBy.usr_username LIKE '%" . $searchValue . "%') ");
          }
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }

          if ($this->uid != 100) {
               if (check_permission('purchase', 'purchase_view_smart')) {
                    // $this->db->where($this->tbl_mou_master . '.moum_division', 1);
                    $this->db->or_where($this->tbl_purchase . '.pr_division', 1);
               }
               if (check_permission('purchase', 'purchase_view_luxury')) {
                    // $this->db->where($this->tbl_mou_master . '.moum_division', 2);
                    $this->db->or_where($this->tbl_purchase . '.pr_division', 2);
               }
               if (check_permission('purchase', 'purchase_view_self')) {
                    $this->db->or_where($this->tbl_purchase . '.pr_added_by', $this->uid);
               }
               if (check_permission('purchase', 'purchase_view_my_showroom')) {
                    //$this->db->where($this->tbl_mou_master . '.moum_showroom', $this->shrm);
                    $this->db->or_where($this->tbl_purchase . '.pr_showroom', $this->shrm);
               }
               if (check_permission('purchase', 'purchase_view_my_staff')) {
                    $this->db->where_in($this->tbl_purchase . '.pr_added_by', $mystaffs);
               }
          }
          $this->db->where('pr_approved_by !=', 0);
          $data = $this->db->select($selArray)
               ->join($this->tbl_users . ' addeddBy', 'addeddBy.usr_id = ' . $this->tbl_purchase . '.pr_added_by', 'left')
               ->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_purchase . '.pr_approved_by', 'left')
               ->get($this->tbl_purchase)->result_array();
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }

     function allPurchaseAjax($postDatas)
     {
          $draw = isset($postDatas['draw']) ? $postDatas['draw'] : 0;
          $row = isset($postDatas['start']) ? $postDatas['start'] : 0;
          $rowperpage = isset($postDatas['length']) ? $postDatas['length'] : 0; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : ''; // asc or desc
          $searchValue = isset($postDatas['search']['value']) ? $postDatas['search']['value'] : ''; // Search value
          $totalRecords = $this->db->count_all_results($this->tbl_purchase);
          $selArray = array(
               $this->tbl_purchase . '.pr_id',
               $this->tbl_purchase . '.pr_enq_id',
               $this->tbl_purchase . '.pr_mou_no', //need to change pr_mou_id
               $this->tbl_purchase . '.pr_reg_no',
               $this->tbl_purchase . '.pr_total',
               $this->tbl_purchase . '.pr_refurb_total',
               $this->tbl_purchase . '.pr_advance',
               $this->tbl_purchase . '.pr_fine',
               $this->tbl_purchase . '.pr_brokerage',
               $this->tbl_purchase . '.pr_insurance',
               $this->tbl_purchase . '.pr_approve_remarks',
               $this->tbl_purchase . '.pr_val_id',
               $this->tbl_purchase . '.pr_added_by',
               "DATE_FORMAT(" . $this->tbl_purchase . ".pr_added_date, '%m-%d-%Y') AS pr_added_date",
               'addeddBy.usr_username AS added_usr_username',
               "DATE_FORMAT(" . $this->tbl_purchase . ".pr_approved_on, '%d-%m-%Y') AS pr_approved_on",
               'approvedBy.usr_username AS approvedBy'
          );
          if (!empty($searchValue)) {
               $this->db->where("(pr_mou_no LIKE '%" . $searchValue . "%' OR pr_reg_no LIKE '%" . $searchValue . "%' OR "
                    . "addeddBy.usr_username LIKE '%" . $searchValue . "%' OR approvedBy.usr_username LIKE '%" . $searchValue . "%') ");
          }
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }

          $data = $this->db->select($selArray)
               ->join($this->tbl_users . ' addeddBy', 'addeddBy.usr_id = ' . $this->tbl_purchase . '.pr_added_by', 'left')
               ->join($this->tbl_users . ' approvedBy', 'approvedBy.usr_id = ' . $this->tbl_purchase . '.pr_approved_by', 'left')
               ->get($this->tbl_purchase)->result_array();
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }

     function getApprovedTotal($searchValue)
     {
          $this->db->where('pr_approved_by !=', 0);
          $this->db->from($this->tbl_purchase);
          return $this->db->count_all_results();
     }

     function update($data)
     {
          if (!empty($data)) {

               $this->db->where('pr_id', $data['pr_id']);

               if ($this->db->update($this->tbl_purchase, $data)) {
                    generate_log(array(
                         'log_title' => 'Update purchase ' . date('Y-m-d H:i:s'),
                         'log_desc' => serialize($data),
                         'log_controller' => 'update-purchase ',
                         'log_action' => 'U',
                         'log_ref_id' => $id,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    return true;
               } else {
                    generate_log(array(
                         'log_title' => 'Update purchase ',
                         'log_desc' => 'Error on update ',
                         'log_controller' => 'update-purchase-',
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

     function getCompany()
     {
          return $this->db->select(
               array('cmp_name', 'cmp_finance_year_code', 'div_id')
          )->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_company . '.cmp_division', 'LEFT')
               ->get($this->tbl_company)->result_array();
     }

     public function purchaseApi($val_id, $pr_id, $pr_enq_id)
     {
          $this->db->where('val_id', $val_id); //8020///8038//8015//8047

          $this->db->select("
          {$this->tbl_brand}.brd_title,
          {$this->tbl_model}.mod_title,   
          {$this->tbl_variant}.var_variant_name,   
          {$this->tbl_vehicle_colors}.vc_color,
          {$this->tbl_valuation}.val_model_year,
          {$this->tbl_valuation}.val_cust_phone,
          UPPER({$this->tbl_valuation}.val_engine_no) AS val_engine_no,
          UPPER({$this->tbl_valuation}.val_chasis_no) AS val_chasis_no,
          UPPER(CONCAT({$this->tbl_valuation}.val_prt_1, {$this->tbl_valuation}.val_prt_2, {$this->tbl_valuation}.val_prt_3, {$this->tbl_valuation}.val_prt_4)) AS val_veh_no,
          {$this->tbl_valuation}.val_cust_name,
          {$this->tbl_valuation}.val_refurb_cost,
          addedby.usr_username AS val_sales_officer_name,
          {$this->tbl_showroom}.shr_location as val_showroom,
          {$this->tbl_valuation}.val_stock_num as stockID,
          {$this->tbl_valuation}.val_fuel as fuelType,
          {$this->tbl_valuation}.val_eng_cc as engine_CC,
          {$this->tbl_enquiry}.enq_cus_address,
          {$this->tbl_enquiry}.enq_cus_ofc_address,
          {$this->tbl_purchase}.pr_advance As enh_adv_amt,
          {$this->tbl_purchase}.pr_sourcing_type,
          {$this->tbl_purchase}.pr_total As enh_booking_amt, 
          {$this->tbl_purchase}.pr_dicount_amt  As enh_discount_amt, 
          {$this->tbl_purchase}.pr_tcs_amt  As tcS_Amt,
          {$this->tbl_purchase}.pr_agreement_date  As enq_agreement_date, 
          {$this->tbl_purchase}.pr_ref_no  As val_stock_num,
          {$this->tbl_district}.std_district_name as enq_cus_dist,
          {$this->tbl_state}.sts_name as enq_cus_state, 'C' as enq_trans_mode,
          {$this->tbl_purchase}.pr_val_type, 
          {$this->tbl_purchase}.pr_fin_year_code AS gcCode
      ", false);

          $this->db->from($this->tbl_valuation);
          //slsOfficer.usr_first_name AS val_sales_officer_name,
          $this->db->join($this->tbl_brand, "{$this->tbl_brand}.brd_id = {$this->tbl_valuation}.val_brand", 'left');
          $this->db->join($this->tbl_model, "{$this->tbl_model}.mod_id = {$this->tbl_valuation}.val_model", 'left');
          $this->db->join($this->tbl_variant, "{$this->tbl_variant}.var_id = {$this->tbl_valuation}.val_variant", 'left');
          $this->db->join($this->tbl_vehicle_colors, "{$this->tbl_vehicle_colors}.vc_id = {$this->tbl_valuation}.val_color", 'left');
          $this->db->join($this->tbl_showroom, "{$this->tbl_showroom}.shr_id = {$this->tbl_valuation}.val_showroom", 'left');
          $this->db->join($this->tbl_enquiry, "{$this->tbl_enquiry}.enq_id = {$this->tbl_valuation}.val_enquiry_id", 'left');
          $this->db->join($this->tbl_users . ' slsOfficer', "slsOfficer.usr_id = {$this->tbl_valuation}.val_sales_officer", 'left');
          $this->db->join($this->tbl_purchase, "{$this->tbl_purchase}.pr_val_id = {$this->tbl_valuation}.val_id", 'left');
          $this->db->join($this->tbl_district, "{$this->tbl_district}.std_id = {$this->tbl_purchase}.pr_district", 'left');
          $this->db->join($this->tbl_state, "{$this->tbl_state}.sts_id = {$this->tbl_purchase}.pr_state", 'left');
          $this->db->join($this->tbl_users . " addedby", "addedby.usr_id = {$this->tbl_purchase}.pr_proc_staff", 'left');

          $data = $this->db->get()->row_array();
          $data['val_type_title'] = unserialize(VAL_TYPE_TITLE)[$data['pr_val_type']];
          $data['PurchaseType'] = unserialize(SOURCING_TYPE)[$data['pr_sourcing_type']];
          $data['fuelType'] = unserialize(FUAL)[$data['fuelType']];
          $data['pr_val_id'] = $val_id;
          $data['pr_id'] = $pr_id;
          $data['pr_enq_id'] = $pr_enq_id;
          unset($data['pr_sourcing_type']);
          unset($data['pr_val_type']);
          return $data;
     }
     public function getValIdByEnq($enq_id)
     {
          $this->db->where('val_enquiry_id', $enq_id);
          $this->db->order_by('val_id', 'desc');
          $data = $this->db->select('val_id')
               ->get($this->tbl_valuation)
               ->row_array();
          return $data;
     }

     function getEnquiryDetails($enq_id)
     {
          $this->db->where('enq_id', $enq_id);
          $data = $this->db->select('enq_se_id')->get($this->tbl_enquiry)->row_array();
          return $data;
     }

     //new
     function getStates()
     {
          $this->db->where('sts_status', 1);
          $data = $this->db->select("`{$this->tbl_state}`.`sts_id`, `{$this->tbl_state}`.`sts_name`") //
               ->get($this->tbl_state)
               ->result_array();
          return $data;
     }
     function bindDistrictBystate($state)
     {
          $return['districts'] = $this->db->select($this->tbl_district . '.std_id, ' . $this->tbl_district . '.std_district_name')
               ->where(array('std_state' => $state))->get($this->tbl_district)->result_array();
          return $return;
     }

     public function insertDistricts()
     {
          $data = array();
          $district_names = array(
               "Central Delhi",
               "East Delhi",
               "New Delhi",
               "North Delhi",
               "North East Delhi",
               "North West Delhi",
               "Shahdara",
               "South Delhi",
               "South East Delhi",
               "South West Delhi",
               "West Delhi"
          );

          foreach ($district_names as $district_name) {
               $data[] = array(
                    'std_state' => 10,
                    'std_district_name' => $district_name
               );
          }

          $this->db->insert_batch('cpnl_district_statewise', $data);
     }
     public function updateStatus()
     {
          $this->load->database(); // Load the database library if it's not autoloaded.

          $this->db->set('sts_status', 1);
          $this->db->where('sts_id', 10);
          $this->db->update('cpnl_states');

          if ($this->db->affected_rows() > 0) {
               echo 'Update successful!';
          } else {
               echo 'No records updated.';
          }
     }
     //@new

     function delete($id)
     {
          if (!empty($id)) {
               $old = $this->db->get_where($this->tbl_purchase, array('pr_id' => $id))->row_array();
               $this->db->where('pr_id', $id)->delete($this->tbl_purchase);
               generate_log(array(
                    'log_title' => 'Delete purchase ',
                    'log_desc' => serialize($old),
                    'log_controller' => 'delete-purchase-',
                    'log_action' => 'D',
                    'log_ref_id' => $id,
                    'log_added_by' => $this->uid
               ));
               return true;
          }
     }
     
     function getCustomerDelightStaff() {
         return $this->db->select('usr_username, usr_did_number, '. $this->tbl_designation . '.desig_title')
                ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
                ->where('usr_designation_new', 90)->where('usr_active', 1)->where('usr_resigned', 0)->get($this->tbl_users)->row_array();
     }
}
