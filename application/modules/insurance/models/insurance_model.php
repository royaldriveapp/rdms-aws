<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class insurance_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_valuation_documents = TABLE_PREFIX . 'valuation_documents';
     }

     public function getData($id = 0)
     {
          $selArray = array(
               $this->tbl_valuation . '.val_id',
               $this->tbl_valuation . '.val_stock_num',
               'UPPER(' . $this->tbl_valuation . '.val_veh_no) AS val_veh_no',
               $this->tbl_valuation . '.val_status',
               $this->tbl_valuation . '.val_type',
               $this->tbl_valuation . '.val_prt_1',
               $this->tbl_valuation . '.val_prt_2',
               $this->tbl_valuation . '.val_prt_3',
               $this->tbl_valuation . '.val_prt_4',
               $this->tbl_valuation . '.val_valuation_date',
               $this->tbl_valuation . '.val_insurance_idv',
               $this->tbl_valuation . '.val_insurance_company',
               $this->tbl_valuation . '.val_insurance_validity',
               $this->tbl_valuation . '.val_cust_name',
               $this->tbl_valuation . '.val_cust_phone',
               $this->tbl_valuation . '.val_cust_email',
               $this->tbl_valuation . '.val_cust_place',
               $this->tbl_valuation . '.val_rc_owner',
               $this->tbl_valuation . '.val_no_of_owner',
               $this->tbl_valuation . '.val_no_of_seats',
               $this->tbl_valuation . '.val_eng_cc',
               $this->tbl_valuation . '.val_cust_adrs',
               $this->tbl_valuation . '.val_cust_age',
               $this->tbl_valuation . '.val_cust_pin',
               $this->tbl_valuation . '.val_hp',
               $this->tbl_valuation . '.val_insurance_comp_date',
               $this->tbl_valuation . '.val_insurance_comp_idv',
               $this->tbl_valuation . '.val_insurance_ll_date',
               $this->tbl_valuation . '.val_insurance_ll_idv',
               $this->tbl_valuation . '.val_insurance',
               $this->tbl_valuation . '.val_insurance_need_ncb',
               $this->tbl_valuation . '.val_ins_remarks',
               $this->tbl_model . '.mod_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_variant_name',
          );

          if ($id) {
               $EvaluationVehicle = $this->db->select($selArray, false)
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->where('val_id', $id)->get($this->tbl_valuation)->row_array();
               $EvaluationVehicle['documents'] = $this->db->order_by('vdoc_id', 'ASC')->get_where($this->tbl_valuation_documents, array('vdoc_val_id' => $id))->result_array();
               return $EvaluationVehicle;
          }
          return $this->db->select($selArray, false)
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->order_by('val_insurance_validity')->where('val_comp_stock', 1)->get($this->tbl_valuation)->result_array();
     }
     public function getUnsolvedReqData()
     {
          //debug($this->uid);
          error_reporting(0);
          $res = $this->db->query("CALL sp_get_bottleneck_unsolved_reqs($this->uid)")->result_array();
          $this->db->reconnect();
          return $res;
     }
     public function getSolvedReqData()
     {
          error_reporting(0);
          $res = $this->db->query("CALL sp_get_bottleneck_solved_reqs($this->uid)")->result_array();
          $this->db->reconnect();
          return $res;
     }

     public function edit($id)
     {
          error_reporting(0);
          $res = $this->db->query("CALL sp_edit_bottleneck($id)")->row_array();
          $this->db->reconnect();
          //  debug($res);
          return $res;
     }
     public function update($datas)
     {
          //  debug($datas);
          $datas['btnk_completion_date'] = date("Y-m-d H:i:s");
          $datas['btnk_solved_person'] = $this->uid;
          $this->db->where('btnk_id', $datas['btnk_id']);
          unset($datas['btnk_id']);
          if ($this->db->update($this->table, $datas)) {
               return true;
          } else {
               return false;
          }
     }

     public function delete($id)
     {
          $this->db->where('vc_id ', $id);
          if ($this->db->delete($this->table)) {
               return true;
          } else {
               return false;
          }
     }

     public function insert($data)
     {
          // debug($this->usr_tl);
          $data['btnk_staff'] = $this->uid;
          $data['btnk_shrm'] = $this->shrm;
          $data['btnk_created_at'] = date("Y-m-d H:i:s");
          $data['btnk_shrm'] = $this->shrm;
          $data['btnk_resnponsible_person'] = $this->usr_tl;
          //debug($data);
          if ($this->db->insert($this->table, $data)) {
               return true;
          } else {
               return false;
          }
     }

     function selectData($id = '')
     {
          if (!empty($id)) {
               $this->db->where($this->table . '.vc_id ', $id);
               return $this->db->select($this->table . '.*')->from($this->table, false)->get()->row_array();
          }
          return false;
     }

     function updateins($data)
     {
          $dataBack = $data;
          $valId = $data['val_id'];
          unset($data['val_id']);
          $data['val_insurance_validity'] = !empty($data['val_insurance_validity']) ? date('Y-m-d', strtotime($data['val_insurance_validity'])) : NULL;
          $data['val_insurance_ll_date'] = !empty($data['val_insurance_ll_date']) ? date('Y-m-d', strtotime($data['val_insurance_ll_date'])) : NULL;
          $data['val_insurance_comp_date'] = !empty($data['val_insurance_comp_date']) ? date('Y-m-d', strtotime($data['val_insurance_comp_date'])) : NULL;

          if (isset($data['val_ins_remarks']) && !empty($data['val_ins_remarks'])) {
               $data['val_ins_remarks'] = serialize(array($this->uid => $data['val_ins_remarks']));
          }

          $this->db->where('val_id', $valId)->update($this->tbl_valuation, $data);

          generate_log(array(
               'log_title' => $this->session->userdata('usr_username') . ' company vehicle insurance renewal',
               'log_desc' => serialize($dataBack),
               'log_controller' => 'com-own-vehle-ins-updation',
               'log_action' => 'U',
               'log_ref_id' => $valId,
               'log_added_by' => $this->uid
          ));
          return true;
     }

     function stockVehicle()
     {
          $selectArray = array(
               $this->tbl_valuation . '.val_id',
               'UPPER(' . $this->tbl_valuation . '.val_veh_no) AS val_veh_no',
               $this->tbl_valuation . '.val_status',
               $this->tbl_valuation . '.val_type',
               $this->tbl_valuation . '.val_prt_1',
               $this->tbl_valuation . '.val_prt_2',
               $this->tbl_valuation . '.val_prt_3',
               $this->tbl_valuation . '.val_prt_4',
               $this->tbl_valuation . '.val_valuation_date',
               $this->tbl_valuation . '.val_insurance_idv',
               $this->tbl_valuation . '.val_insurance_company',
               $this->tbl_valuation . '.val_insurance_validity',
               $this->tbl_valuation . '.val_cust_name',
               $this->tbl_valuation . '.val_cust_phone',
               $this->tbl_valuation . '.val_cust_email',
               $this->tbl_valuation . '.val_cust_place',
               $this->tbl_valuation . '.val_rc_owner',
               $this->tbl_valuation . '.val_no_of_owner',
               $this->tbl_valuation . '.val_no_of_seats',
               $this->tbl_valuation . '.val_eng_cc',
               $this->tbl_valuation . '.val_cust_adrs',
               $this->tbl_valuation . '.val_cust_age',
               $this->tbl_valuation . '.val_cust_pin',
               $this->tbl_valuation . '.val_hp',
               $this->tbl_valuation . '.val_insurance_comp_date',
               $this->tbl_valuation . '.val_insurance_comp_idv',
               $this->tbl_valuation . '.val_insurance_ll_date',
               $this->tbl_valuation . '.val_insurance_ll_idv',
               $this->tbl_valuation . '.val_insurance',
               $this->tbl_valuation . '.val_insurance_need_ncb',
               $this->tbl_model . '.mod_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_users . '.usr_first_name',
               $this->tbl_users . '.usr_last_name',
               $this->tbl_showroom . '.*',
               $this->tbl_enquiry . '.enq_id'
          );

          return $this->db->select($selectArray, false)
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
               ->get($this->tbl_valuation)->result_array();
          //  ->where_in($this->tbl_valuation . '.val_status', array(39, 40))

     }

     function insurancePending()
     {
          $this->tbl_model = 'rana_model';
          $this->tbl_brand = 'rana_brand';
          $this->tbl_variant = 'rana_variant';
          $selectArray = array(
               $this->tbl_valuation . '.val_id',
               'UPPER(' . $this->tbl_valuation . '.val_veh_no) AS val_veh_no',
               $this->tbl_valuation . '.val_status',
               $this->tbl_valuation . '.val_type',
               $this->tbl_valuation . '.val_prt_1',
               $this->tbl_valuation . '.val_prt_2',
               $this->tbl_valuation . '.val_prt_3',
               $this->tbl_valuation . '.val_prt_4',
               $this->tbl_valuation . '.val_valuation_date',
               $this->tbl_valuation . '.val_insurance_idv',
               $this->tbl_valuation . '.val_insurance_company',
               $this->tbl_valuation . '.val_insurance_validity',
               $this->tbl_valuation . '.val_cust_name',
               $this->tbl_valuation . '.val_cust_phone',
               $this->tbl_valuation . '.val_cust_email',
               $this->tbl_valuation . '.val_cust_place',
               $this->tbl_valuation . '.val_rc_owner',
               $this->tbl_valuation . '.val_no_of_owner',
               $this->tbl_valuation . '.val_no_of_seats',
               $this->tbl_valuation . '.val_eng_cc',
               $this->tbl_valuation . '.val_cust_adrs',
               $this->tbl_valuation . '.val_cust_age',
               $this->tbl_valuation . '.val_cust_pin',
               $this->tbl_valuation . '.val_hp',
               $this->tbl_valuation . '.val_insurance_comp_date',
               $this->tbl_valuation . '.val_insurance_comp_idv',
               $this->tbl_valuation . '.val_insurance_ll_date',
               $this->tbl_valuation . '.val_insurance_ll_idv',
               $this->tbl_valuation . '.val_insurance',
               $this->tbl_valuation . '.val_insurance_need_ncb',
               $this->tbl_model . '.mod_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_variant_name'
          );

          return $this->db->select($selectArray, false)
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               //  ->where_in($this->tbl_valuation . '.val_status', array(39, 40))
               ->where("(DATEDIFF(DATE(" . $this->tbl_valuation . ".val_insurance_comp_date), '" . date('Y-m-d') . "') <= 4) OR (DATEDIFF(DATE(" .
                    $this->tbl_valuation . ".val_insurance_ll_date), '" . date('Y-m-d') . "') <= 4)")
               ->get($this->tbl_valuation)->result_array();
     }
     public function stockVehiclePaginate($postDatas)
     {
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
          $this->db->select('val.val_id, UPPER(val.val_veh_no) AS val_veh_no, val.val_status, val.val_type, val.val_prt_1, val.val_prt_2, val.val_prt_3, val.val_prt_4, val.val_valuation_date, val.val_insurance_idv, val.val_insurance_company, val.val_insurance_validity, val.val_cust_name, val.val_cust_phone, val.val_cust_email, val.val_cust_place, val.val_rc_owner, val.val_no_of_owner, val.val_no_of_seats, val.val_eng_cc, val.val_cust_adrs, val.val_cust_age, val.val_cust_pin, val.val_hp, val.val_insurance_comp_date, val.val_insurance_comp_idv, val.val_insurance_ll_date, val.val_insurance_ll_idv, val.val_insurance, val.val_insurance_need_ncb, model.mod_title, brand.brd_title, variant.var_variant_name, users.usr_first_name, users.usr_last_name, showroom.*, enquiry.enq_id')
               ->from($this->tbl_valuation . ' val')
               ->join($this->tbl_model . ' model', 'model.mod_id = val.val_model', 'left')
               ->join($this->tbl_brand . ' brand', 'brand.brd_id = val.val_brand', 'left')
               ->join($this->tbl_variant . ' variant', 'variant.var_id = val.val_variant', 'left')
               ->join($this->tbl_users . ' users', 'users.usr_id = val.val_added_by', 'left')
               ->join($this->tbl_showroom . ' showroom', 'showroom.shr_id = val.val_showroom', 'left')
               ->join($this->tbl_enquiry . ' enquiry', 'enquiry.enq_id = val.val_enquiry_id', 'left');
          //->where_in('val.val_status', array(39, 40));
          if ($searchValue != '') {
               $this->db->where("(val_veh_no LIKE '%" . $searchValue . "%' OR brd_title LIKE '%" . $searchValue . "%' OR "
                    . "var_variant_name LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%') ");
          }
          $data = $this->db->get()->result_array();

          $this->db->select('COUNT(*) as total_records')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left');
          //->where_in($this->tbl_valuation . '.val_status', array(39, 40));         
          $totalRecords = $this->db->get($this->tbl_valuation)->row()->total_records;
          // $totalRecords=6450;
          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }
}
