<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class fixedassets_model extends CI_Model {

     public function __construct() {
          parent::__construct();
          $this->load->database();

          $this->tbl_fixed_assets_track = TABLE_PREFIX . 'fixed_assets_track';
          $this->tbl_fixed_assets_issue = TABLE_PREFIX . 'fixed_assets_issue';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_fixed_assets_category = TABLE_PREFIX . 'fixed_assets_category';
          $this->tbl_fixed_assets_company = TABLE_PREFIX . 'fixed_assets_company';
          $this->tbl_fixed_assets_products = TABLE_PREFIX . 'fixed_assets_products';
          $this->tbl_model = TABLE_PREFIX . 'model';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_statuses = TABLE_PREFIX . 'statuses';
          $this->tbl_clients = TABLE_PREFIX . 'clients';
          $this->tbl_sales_master = TABLE_PREFIX . 'sales_master';
          $this->tbt_prod_images = TABLE_PREFIX . 'prod_images';
          $this->tbl_sales_details = TABLE_PREFIX . 'sales_details';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_fixed_assets_products = TABLE_PREFIX . 'fixed_assets_products';
     }

     function getFxedAssetsCompany() {
          return $this->db->get($this->tbl_fixed_assets_company)->result_array();
     }

     public function addNewCategory($datas) {
          if ($this->db->insert($this->tbl_fixed_assets_category, $datas)) {
               return true;
          } else {
               return false;
          }
     }

     public function getCategoryChaild($parent, $idNotin = '') {

          $this->db->select("fac_id, fac_title");
          $this->db->where('fac_parent', $parent);
          if (!empty($idNotin)) {
               $this->db->where('fac_id !=', $idNotin);
          }
          $result = $this->db->get($this->tbl_fixed_assets_category)->result_array();
          return $result;
     }

     public function getCategories($id = '') {

          $this->db->select("gcat.*, gcat.fac_parent AS fac_parent, gcat.fac_desc AS category_desc, gcat.fac_title AS category_name, gcat.fac_id AS fac_id, gcat2.fac_title AS parent_category");
          $this->db->from($this->tbl_fixed_assets_category . ' gcat');
          $this->db->join($this->tbl_fixed_assets_category . ' gcat2', 'gcat.fac_parent = gcat2.fac_id', 'left');
          if (!empty($id)) {
               $this->db->where('gcat.fac_id', $id);
               return $this->db->get()->row_array();
          } else {
               return $this->db->get()->result_array();
          }
     }

     public function updateCategory($datas) {

          $this->db->where('fac_id', $datas['fac_id']);
          unset($datas['fac_id']);
          if ($this->db->update($this->tbl_fixed_assets_category, $datas)) {
               return true;
          } else {
               return false;
          }
     }

     public function deleteCategory($id) {

          $this->db->where('fac_id', $id);
          if ($this->db->delete($this->tbl_fixed_assets_category)) {
               $this->db->where('fac_parent', $id);
               $this->db->delete($this->tbl_fixed_assets_category);
               return true;
          } else {
               return false;
          }
     }

     public function categoryTree() {

          $this->db->select("cat.fac_id AS category_id, cat.fac_title AS category_name, cat2.fac_title AS parent_category_name, cat2.fac_id AS parent_category_id")
                  ->from($this->tbl_fixed_assets_category . ' cat')
                  ->join($this->tbl_fixed_assets_category . ' cat2', 'cat.fac_parent = cat2.fac_id', 'LEFT')
                  ->order_by('parent_category_name');
          $tree = $this->db->get()->result_array();
          return $tree;
     }

     function addNewProduct($data) {
          $cnt = isset($data['product']['prd_number']) ? count($data['product']['prd_number']) : 0;
          if ($cnt > 0) {
               for ($i = 0; $i < $cnt; $i++) {
                    $wrnty = (isset($data['product']['prd_warty_till'][$i]) && !empty($data['product']['prd_warty_till'][$i])) ?
                            date('Y-m-d', strtotime($data['product']['prd_warty_till'][$i])) : null;
                    $this->db->insert($this->tbl_fixed_assets_products, array(
                        'fap_cat_id' => isset($data['product']['prd_cat_id']) ? $data['product']['prd_cat_id'] : 0,
                        'fap_showroom' => isset($data['product']['fap_showroom']) ? $data['product']['fap_showroom'] : 0,
                        'fap_division' => isset($data['product']['fap_division']) ? $data['product']['fap_division'] : 0,
                        'fap_number' => isset($data['product']['prd_number'][$i]) ? $data['product']['prd_number'][$i] : '',
                        'fap_name' => isset($data['product']['prd_name'][$i]) ? $data['product']['prd_name'][$i] : '',
                        'fap_company' => isset($data['product']['prd_company'][$i]) ? $data['product']['prd_company'][$i] : 0,
                        'fap_slno' => isset($data['product']['prd_slno'][$i]) ? $data['product']['prd_slno'][$i] : '',
                        'fap_warty_till' => $wrnty,
                        'fap_invoice' => isset($data['product']['prd_name'][$i]) ? $data['product']['prd_name'][$i] : '',
                        'fap_warty_card' => isset($data['product']['prd_name'][$i]) ? $data['product']['prd_name'][$i] : '',
                        'fap_added_by' => $this->uid,
                        'fap_added_on' => date('Y-m-d H:i:s'),
                        'fap_vendor' => isset($data['product']['prd_vendor'][$i]) ? $data['product']['prd_vendor'][$i] : '',
                        'fap_desc' => isset($data['product']['prd_desc'][$i]) ? $data['product']['prd_desc'][$i] : '',
                        'fap_pur_date' => (!empty($data['product']['prd_pur_on'][$i])) ? date('Y-m-d', strtotime($data['product']['prd_pur_on'][$i])) : null
                    ));
                    //prd_pur_on
                    $assetId = $this->db->insert_id();
                    $asset = $this->getProduct($assetId);
                    $issuedBy = $this->session->userdata('usr_username');
                    $sysmd = 'Asset No: ' . $asset['fap_number'] . ', Asset name : ' . $asset['fap_name'] .
                            ', Serial No: ' . $asset['fap_slno'] . ', Company : ' . $asset['facm_title'] .
                            ', asset added by ' . $issuedBy .
                            ', asset added on ' . date('d-m-Y H:i:s');
                    $this->assetTrack($assetId, '', 61, $this->shrm, 0, $sysmd);
               }
          }
     }

     public function getProduct($id = '', $filter = array()) {

          $sel = array(
              $this->tbl_fixed_assets_products . '.*',
              $this->tbl_fixed_assets_category . '.fac_id AS sub_category',
              $this->tbl_fixed_assets_category . '.fac_title AS sub_category_name',
              'cat1.fac_id AS category_id', 'cat1.fac_title AS category_name',
              $this->tbl_users . '.usr_first_name AS addedby_first_name',
              $this->tbl_users . '.usr_last_name AS addedby_last_name',
              $this->tbl_users . '.usr_id AS addedby_user_id',
              'holder.usr_first_name AS owner_first_name',
              'holder.usr_last_name AS owner_last_name',
              'holder.usr_id AS owner_user_id',
              $this->tbl_fixed_assets_company . '.*',
              $this->tbl_statuses . '.*'
          );

          $this->db->select($sel)->from($this->tbl_fixed_assets_products);
          $this->db->join($this->tbl_fixed_assets_category, $this->tbl_fixed_assets_category . '.fac_id = ' . $this->tbl_fixed_assets_products . '.fap_cat_id ', 'left');
          $this->db->join($this->tbl_fixed_assets_category . ' cat1', 'cat1.fac_id = ' . $this->tbl_fixed_assets_category . '.fac_parent ', 'left');
          $this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_fixed_assets_products . '.fap_added_by ', 'left');
          $this->db->join($this->tbl_users . ' holder', 'holder.usr_id = ' . $this->tbl_fixed_assets_products . '.fap_holder ', 'left');
          $this->db->join($this->tbl_fixed_assets_company, $this->tbl_fixed_assets_company . '.facm_id = ' . $this->tbl_fixed_assets_products . '.fap_company', 'LEFT');
          $this->db->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_fixed_assets_products . '.fap_status', 'LEFT');

          if (isset($filter['who'])) {
               $this->db->where($this->tbl_fixed_assets_products . '.fap_added_by', $filter['who']);
          }

          if ($id) {
               $this->db->where($this->tbl_fixed_assets_products . '.fap_id', $id);
               return $this->db->get()->row_array();
          }
          //echo $this->db->last_query();
          return $this->db->get()->result_array();
     }

//     public function getCategoryOptionsByID($supCatID) {
//          return 0;
//          /* $this->db->select("sup_cat_id");
//            $this->db->where('usr_id', $supplierID);
//            $result = $this->db->get(TABLE_PREFIX . 'users')->result_array();
//            $supCatID = $result[0]['sup_cat_id']; */
//          if ($supCatID) {
//               $this->db->select("cat_opt_id, cat_opt_name");
//               $this->db->where('sup_cat_id', $supCatID);
//
//               $resultOptions = $this->db->get(TABLE_PREFIX . 'supplier_category_options')->result_array();
//               return $resultOptions;
//          } else {
//               return 0;
//          }
//     }

     function getAllUserGroups() {

          return $this->db->get($this->tbl_designation)->result_array();
     }

     function getUsers($grps) {
          // $this->db->where($this->tbl_users . '.usr_active', 1);
          $this->db->where($this->tbl_designation . ".desig_id", $grps);
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

     function getAssetsNotIssues() {
          $select = array(
              $this->tbl_fixed_assets_products . '.*',
              $this->tbl_fixed_assets_category . '.*',
              $this->tbl_fixed_assets_company . '.*'
          );
          return $this->db->select($select)
                          ->join($this->tbl_fixed_assets_category, $this->tbl_fixed_assets_category . '.fac_id = ' . $this->tbl_fixed_assets_products . '.fap_cat_id', 'LEFT')
                          ->join($this->tbl_fixed_assets_company, $this->tbl_fixed_assets_company . '.facm_id = ' . $this->tbl_fixed_assets_products . '.fap_company', 'LEFT')
                          ->where('fap_status', 61)->get($this->tbl_fixed_assets_products)->result_array();
     }

     function getAssetsIssues() {
          $select = array(
              $this->tbl_fixed_assets_products . '.*',
              $this->tbl_fixed_assets_category . '.*',
              $this->tbl_fixed_assets_company . '.*',
              $this->tbl_users . '.usr_username'
          );
          return $this->db->select($select)
                          ->join($this->tbl_fixed_assets_category, $this->tbl_fixed_assets_category . '.fac_id = ' . $this->tbl_fixed_assets_products . '.fap_cat_id', 'LEFT')
                          ->join($this->tbl_fixed_assets_company, $this->tbl_fixed_assets_company . '.facm_id = ' . $this->tbl_fixed_assets_products . '.fap_company', 'LEFT')
                          ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_fixed_assets_products . '.fap_holder', 'LEFT')
                          ->where('fap_status', 61)->get($this->tbl_fixed_assets_products)->result_array();
     }

     function issueAssets($data) {
          $faiIssueDate = (isset($data['fai_issue_date']) && !empty($data['fai_issue_date'])) ?
                  date('Y-m-d', strtotime($data['fai_issue_date'])) : '';
          if ((isset($data['asset']) && !empty($data['asset'])) && (isset($data['usr_id']) && !empty($data['usr_id']))) {
               foreach ($data['asset'] as $key => $value) {
                    $ins = array(
                        'fai_asset' => $key,
                        'fai_user' => $data['usr_id'],
                        'fai_added_date' => date('Y-m-d H:i:s'),
                        'fai_issue_by' => $this->uid,
                        'fai_issue_date' => $faiIssueDate
                    );
                    $this->db->insert($this->tbl_fixed_assets_issue, $ins);

                    $this->db->where('fap_id', $key)->update($this->tbl_fixed_assets_products,
                            array('fap_status' => 62, 'fap_holder' => $data['usr_id'], 'fap_issue_on' => $faiIssueDate));

                    $userDetails = $this->db->select('usr_first_name, usr_last_name')->get_where($this->tbl_users, array('usr_id' => $data['usr_id']))->row_array();
                    $asset = $this->getProduct($key);
                    $issuedBy = $this->session->userdata('usr_username');
                    $sysmd = '';
                    if (!empty($userDetails) && !empty($asset)) {
                         $sysmd = 'Asset No: ' . $asset['fap_number'] . ', Asset name : ' . $asset['fap_name'] .
                                 ', Serial No: ' . $asset['fap_slno'] . ', Company : ' . $asset['facm_title'] .
                                 '. Issued to ' . $userDetails['usr_first_name'] . ', issued by ' . $issuedBy .
                                 ', issued on ' . $faiIssueDate;
                    }
                    $this->assetTrack($key, '', 62, $this->shrm, $data['usr_id'], $sysmd);
               }
               return true;
          }
     }

     function assetTrack($asset, $comment = '', $sts, $loc = 0, $owner, $sysmd = '') {
          $ins = array(
              'fat_asset' => $asset,
              'fat_comment' => $comment,
              'fat_sys_comment' => $sysmd,
              'fat_cur_status' => $sts,
              'fat_location' => $loc,
              'fat_added_by' => $this->uid,
              'fat_added_on' => date('Y-m-d H:i:s'),
              'fat_owner' => $owner
          );
          $this->db->insert($this->tbl_fixed_assets_track, $ins);
     }

     function bindIssuedAssets($usrId) {

          $select = array(
              $this->tbl_fixed_assets_issue . '.*',
              $this->tbl_fixed_assets_products . '.*',
              $this->tbl_fixed_assets_category . '.*',
              $this->tbl_fixed_assets_company . '.*'
          );
          return $this->db->select($select)
                          ->join($this->tbl_fixed_assets_products, $this->tbl_fixed_assets_issue . '.fai_asset = ' . $this->tbl_fixed_assets_products . '.fap_id', 'LEFT')
                          ->join($this->tbl_fixed_assets_category, $this->tbl_fixed_assets_category . '.fac_id = ' . $this->tbl_fixed_assets_products . '.fap_cat_id', 'LEFT')
                          ->join($this->tbl_fixed_assets_company, $this->tbl_fixed_assets_company . '.facm_id = ' . $this->tbl_fixed_assets_products . '.fap_company', 'LEFT')
                          ->where(array($this->tbl_fixed_assets_issue . '.fai_user' => $usrId, $this->tbl_fixed_assets_issue . '.fai_is_returned' => 0))
                          ->get($this->tbl_fixed_assets_issue)->result_array();
     }

     function returnAssets($data) {
          if (isset($data['asset']['cmnts']) && !empty($data['asset']['cmnts'])) {
               foreach ($data['asset']['cmnts'] as $key => $value) {
                    $assetId = $this->db->get_where($this->tbl_fixed_assets_issue, array('fai_id' => $key))->row()->fai_asset;
                    $this->db->where('fai_id', $key)->update($this->tbl_fixed_assets_issue,
                            array(
                                'fai_cmt' => $value,
                                'fai_return_by' => $this->uid,
                                'fai_is_returned' => isset($data['asset']['issueId'][$key]) ? 1 : 0,
                                'fai_return_date' => date('Y-m-d', strtotime($data['fai_issue_date'])))
                    );

                    $this->db->where('fap_id', $assetId)->update($this->tbl_fixed_assets_products,
                            array(
                                'fap_issue_on' => NULL,
                                'fap_holder' => 0,
                                'fap_status' => 61
                            )
                    );

                    $this->db->insert($this->tbl_fixed_assets_track,
                            array(
                                'fat_asset' => $assetId,
                                'fat_comment' => $value,
                                'fat_sys_comment' => 'Asset return',
                                'fat_cur_status' => 61,
                                'fat_location' => $this->shrm,
                                'fat_added_by' => $this->uid,
                                'fat_added_on' => date('Y-m-d H:i:s'),
                                'fat_owner' => 0
                            )
                    );
               }
          }
          return true;
     }

     public function getProductPaginate($postDatas) {

          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
        if ($rowperpage > 0) {
          $this->db->limit($rowperpage, $row);
       }


          $sel = array(
              $this->tbl_fixed_assets_products . '.*',
              $this->tbl_fixed_assets_category . '.fac_id AS sub_category',
              $this->tbl_fixed_assets_category . '.fac_title AS sub_category_name',
              'cat1.fac_id AS category_id', 'cat1.fac_title AS category_name',
              $this->tbl_users . '.usr_first_name AS addedby_first_name',
              $this->tbl_users . '.usr_last_name AS addedby_last_name',
              $this->tbl_users . '.usr_id AS addedby_user_id',
              'holder.usr_first_name AS owner_first_name',
              'holder.usr_last_name AS owner_last_name',
              'holder.usr_id AS owner_user_id',
              $this->tbl_fixed_assets_company . '.*',
              $this->tbl_statuses . '.*'
          );

          $this->db->select($sel)->from($this->tbl_fixed_assets_products);
          $this->db->join($this->tbl_fixed_assets_category, $this->tbl_fixed_assets_category . '.fac_id = ' . $this->tbl_fixed_assets_products . '.fap_cat_id ', 'left');
          $this->db->join($this->tbl_fixed_assets_category . ' cat1', 'cat1.fac_id = ' . $this->tbl_fixed_assets_category . '.fac_parent ', 'left');
          $this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_fixed_assets_products . '.fap_added_by ', 'left');
          $this->db->join($this->tbl_users . ' holder', 'holder.usr_id = ' . $this->tbl_fixed_assets_products . '.fap_holder ', 'left');
          $this->db->join($this->tbl_fixed_assets_company, $this->tbl_fixed_assets_company . '.facm_id = ' . $this->tbl_fixed_assets_products . '.fap_company', 'LEFT');
          $this->db->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_fixed_assets_products . '.fap_status', 'LEFT');

          if (isset($filter['who'])) {
               $this->db->where($this->tbl_fixed_assets_products . '.fap_added_by', $filter['who']);
          }
          if ($searchValue != '') {
               $this->db->where("(fap_number LIKE '%" . $searchValue . "%' OR fap_name LIKE '%" . $searchValue . "%' OR "
                       . "facm_title LIKE '%" . $searchValue . "%' OR cat1.fac_title LIKE '%" . $searchValue . "%') ");
          }
         
          //echo $this->db->last_query();
          $data =$this->db->get()->result_array();
/// totlal

$this->db->select('COUNT(*) as total');
$this->db->from($this->tbl_fixed_assets_products);
$this->db->join($this->tbl_fixed_assets_category, $this->tbl_fixed_assets_category . '.fac_id = ' . $this->tbl_fixed_assets_products . '.fap_cat_id ', 'left');
$this->db->join($this->tbl_fixed_assets_category . ' cat1', 'cat1.fac_id = ' . $this->tbl_fixed_assets_category . '.fac_parent ', 'left');
$this->db->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_fixed_assets_products . '.fap_added_by ', 'left');
$this->db->join($this->tbl_users . ' holder', 'holder.usr_id = ' . $this->tbl_fixed_assets_products . '.fap_holder ', 'left');
$this->db->join($this->tbl_fixed_assets_company, $this->tbl_fixed_assets_company . '.facm_id = ' . $this->tbl_fixed_assets_products . '.fap_company', 'LEFT');
$this->db->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_fixed_assets_products . '.fap_status', 'LEFT');

if (isset($filter['who'])) {
    $this->db->where($this->tbl_fixed_assets_products . '.fap_added_by', $filter['who']);
}
if ($searchValue != '') {
    $this->db->where("(fap_number LIKE '%" . $searchValue . "%' OR fap_name LIKE '%" . $searchValue . "%' OR "
            . "facm_title LIKE '%" . $searchValue . "%' OR cat1.fac_title LIKE '%" . $searchValue . "%') ");
}

$totalQuery = $this->db->get();
$totalRecords = $totalQuery->row()->total;
///

           $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
           );
           return $response;
     }
}