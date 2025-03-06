<?php

  if (!defined('BASEPATH'))
       exit('No direct script access allowed');

  class evaluation_model extends CI_Model {

       public function __construct() {
            parent::__construct();
            $this->load->database();

            $this->tbl_banks = TABLE_PREFIX . 'banks';
            $this->tbl_users = TABLE_PREFIX . 'users';
            $this->tbl_groups = TABLE_PREFIX . 'groups';
            $this->tbl_enquiry = TABLE_PREFIX . 'enquiry_1';
            $this->tbl_variant = TABLE_PREFIX . 'variant';
            $this->tbl_model = TABLE_PREFIX_RANA . 'model';
            $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
            $this->tbl_showroom = TABLE_PREFIX . 'showroom';
            $this->tbl_insurers = TABLE_PREFIX . 'insurers';
            $this->tbl_valuation = TABLE_PREFIX . 'valuation_1';
            $this->tbl_divisions = TABLE_PREFIX . 'divisions';
            $this->tbl_statuses = TABLE_PREFIX . 'statuses';
            $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
            $this->tbl_valuation_status = TABLE_PREFIX . 'valuation_status_1';
            $this->tbl_vehicle_features = TABLE_PREFIX . 'vehicle_features_1';
            $this->tbl_valuation_features = TABLE_PREFIX . 'valuation_features_1';
            $this->tbl_valuation_complaint = TABLE_PREFIX . 'valuation_complaint_1';
            $this->tbl_valuation_documents = TABLE_PREFIX . 'valuation_documents_1';
            $this->tbl_valuation_veh_images = TABLE_PREFIX . 'valuation_veh_images_1';
            $this->tbl_valuation_ful_bd_chkup = TABLE_PREFIX . 'valuation_ful_bd_chkup_1';
            $this->tbl_valuation_upgrade_details = TABLE_PREFIX . 'valuation_upgrade_details_1';
            $this->tbl_valuation_ful_bd_chkup_master = TABLE_PREFIX . 'valuation_ful_bd_chkup_master_1';
            $this->tbl_valuation_ful_bd_chkup_details = TABLE_PREFIX . 'valuation_ful_bd_chkup_details_1';
            $this->tbl_chklist_cat_item = TABLE_PREFIX . 'chklist_cat_item';
            $this->tbl_chklist_category = TABLE_PREFIX . 'chklist_category';
            $this->tbl_purchase_check_list = TABLE_PREFIX . 'purchase_check_list';
            $this->tbl_purchase_check_list_details = TABLE_PREFIX . 'purchase_check_list_details';
            $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
            $this->tbl_rto_office = TABLE_PREFIX . 'rto_office';
            $this->tbl_products = TABLE_PREFIX_RANA . 'products';
            $this->tbl_vehicle = TABLE_PREFIX . 'vehicle_1';
                $this->tbl_register_master = TABLE_PREFIX . 'register_master_1';
                  $this->tbl_valuation_upgrade_details = TABLE_PREFIX . 'valuation_upgrade_details_1';
       }

       function getRTO() {
            return $this->db->order_by('rto_place', 'ASC')->get_where($this->tbl_rto_office, array('rto_state' => 1))->result_array();
       }

       function getColors() {
            return $this->db->order_by('vc_color', 'ASC')->get($this->tbl_vehicle_colors)->result_array();
       }

       function getAllBanks($id = '') {
            if ($id) {
                 return $this->db->order_by('bnk_name')->where('bnk_id', $id)->get($this->tbl_banks)->row_array();
            }
            return $this->db->order_by('bnk_name')->get($this->tbl_banks)->result_array();
       }

       function getInsurers() {
            return $this->db->order_by('ins_insurer')->get($this->tbl_insurers)->result_array();
       }

       function evaluation_ajax($postDatas, $filterDatas) {

            /* $draw = $postDatas['draw'];
              $row = $postDatas['start'];
              $rowperpage = $postDatas['length']; // Rows display per page
              $columnIndex = $postDatas['order'][0]['column']; // Column index
              $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
              $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
              $searchValue = $postDatas['search']['value']; // Search value */

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
                         . "brd_title LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%') ");
            }

            if (isset($filterDatas['status']) && ($filterDatas['status'] >= 0)) {
                 $this->db->where(array($this->tbl_valuation . '.val_status' => $filterDatas['status']));
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
                 $this->db->where('(' . $this->tbl_valuation . '.val_evaluator IN (' . implode($filterDatas['val_evaluator'], ')') . ') OR ' .
                         $this->tbl_users . '.usr_id IN (' . implode($filterDatas['val_evaluator'], ')') . '))');
            }
            $val_valuation_date_from = (isset($filterDatas['val_valuation_date_from']) && !empty($filterDatas['val_valuation_date_from'])) ?
                    date('Y-m-d', strtotime($filterDatas['val_valuation_date_from'])) : '';

            $val_valuation_date_to = (isset($filterDatas['val_valuation_date_to']) && !empty($filterDatas['val_valuation_date_to'])) ?
                    date('Y-m-d', strtotime($filterDatas['val_valuation_date_to'])) : '';

            if (!empty($val_valuation_date_from)) {
                 $this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) >=', $val_valuation_date_from);
            }
            if (!empty($val_valuation_date_to)) {
                 $this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) <=', $val_valuation_date_to);
            }
            $selArray = array(
                $this->tbl_valuation . '.val_id',
                'UPPER(' . $this->tbl_valuation . '.val_veh_no) AS val_veh_no',
                $this->tbl_valuation . '.val_status',
                $this->tbl_valuation . '.val_type',
                $this->tbl_valuation . '.val_prt_1',
                 $this->tbl_valuation . '.val_prt_2',
                 $this->tbl_valuation . '.val_prt_3',
                 $this->tbl_valuation . '.val_prt_4',
                $this->tbl_valuation . '.val_valuation_date',
                "DATE_FORMAT(" . $this->tbl_valuation . ".val_added_date, '%m-%d-%Y') AS val_added_date",
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
                $this->tbl_enquiry . '.enq_cus_when_buy',
                'evaluatedBy.usr_username AS evtr_usr_username',
                $this->tbl_valuation . '.val_booking_status',
                'val_book_sts.sts_title AS val_book_sts_title'
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
                    ->count_all_results($this->tbl_valuation);

            //----------------------------------------------------------------------------------------
            if (!empty($columnName) && !empty($columnSortOrder)) {
                 $this->db->order_by($columnName, $columnSortOrder);
            }

            if (!empty($searchValue)) {
                 $this->db->where("(val_veh_no LIKE '%" . $searchValue . "%' OR shr_location LIKE '%" . $searchValue . "%' OR "
                         . "brd_title LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%') ");
            }

            if (isset($filterDatas['status']) && ($filterDatas['status'] >= 0)) {
                 $this->db->where(array($this->tbl_valuation . '.val_status' => $filterDatas['status']));
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
                 $this->db->where_in($this->tbl_valuation . '.val_evaluator', $filterDatas['val_evaluator']);
            }
            if (!empty($val_valuation_date_from)) {
                 $this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) >=', $val_valuation_date_from);
            }
            if (!empty($val_valuation_date_to)) {
                 $this->db->where('DATE(' . $this->tbl_valuation . '.val_valuation_date) <=', $val_valuation_date_to);
            }
            $this->db->where($this->tbl_valuation . '.val_parent_id', 0);
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
                            ->join($this->tbl_statuses . ' val_book_sts', 'val_book_sts.sts_value = ' . $this->tbl_valuation . '.val_booking_status', 'LEFT')
                         ->group_by('val_veh_no','desc')
                     ->order_by('val_veh_no','desc')
                            ->get($this->tbl_valuation)->result_array();
            #Response
           // debug($data);
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            return $response;
       }

       function getEvaluation($id = '', $status = '') {
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            if (!empty($id)) {
                 $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
                                         $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' .
                                         'evtr.usr_first_name AS evtr_first_name, evtr.usr_last_name AS evtr_last_name,' . $this->tbl_enquiry . '.enq_se_id')
                                 ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                                 ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                                 ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                                 ->join($this->tbl_users . ' evtr', 'evtr.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                                 ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                                 ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
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

       function getEvaluationForRefurbRetn($id = '') {

            $EvaluationVehicle['upgradeDetails'] = $this->db->get_where($this->tbl_valuation_upgrade_details, array('upgrd_master_id' => $id))->result_array();
            $EvaluationVehicle['val_id'] = $id;
            return $EvaluationVehicle;
       }

       function getEvaluationPrint($id = '', $status = '', $is_re_evaluation = '') {
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            if (!empty($id)) {
                 if ($is_re_evaluation) {//get latest id
                      $this->db->select('val_id')->where(array('val_parent_id' => $id));
                      $this->db->from($this->tbl_valuation);
                      $this->db->order_by('val_id', 'DESC');
                      $latestID = @$this->db->get()->row()->val_id;
                      $latestID != '' ? $id = $latestID : $id = $id;
                 }
                 $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
                                         $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.usr_username,' .
                                         $this->tbl_users . '.usr_first_name,' . $this->tbl_showroom . '.*,' . $this->tbl_divisions . '.div_name,' .
                                         'slsOfficer.usr_username AS so_usr_username, slsOfficer.usr_first_name AS so_usr_first_name,' .
                                         'evtr.usr_first_name AS evtr_first_name, evtr.usr_last_name AS evtr_last_name,' . $this->tbl_banks . '.*,' .
                                         $this->tbl_enquiry . '.enq_cus_status, ' . $this->tbl_enquiry . '.enq_cus_status')
                                 ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                                 ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                                 ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                                 ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                                 ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_valuation . '.val_division', 'left')
                                 ->join($this->tbl_users . ' slsOfficer', 'slsOfficer.usr_id = ' . $this->tbl_valuation . '.val_sales_officer', 'left')
                                 ->join($this->tbl_banks, $this->tbl_banks . '.bnk_id = ' . $this->tbl_valuation . '.val_hypo_bank', 'left')
                                 ->join($this->tbl_users . ' evtr', 'evtr.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                                 ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
                                 ->where(array('val_id' => $id))->get($this->tbl_valuation)->row_array();
                 if (!empty($EvaluationVehicle)) {
                      $EvaluationVehicle['complaints'] = $this->db->get_where($this->tbl_valuation_complaint, array('comp_val_id' => $id))->result_array();
                      $EvaluationVehicle['documents'] = $this->db->order_by('vdoc_id', 'ASC')->get_where($this->tbl_valuation_documents, array('vdoc_val_id' => $id))->result_array();


                      if ($is_re_evaluation) {
                           $EvaluationVehicle['features'] = $this->db->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id))->result_array();
                           $EvaluationVehicle['features'] = isset($EvaluationVehicle['features']) ? array_column($EvaluationVehicle['features'], 'vfet_feature') : array();
                      } else {
                           $EvaluationVehicle['features'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                                           ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                                           ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 0))->result_array();
                      }


                      $EvaluationVehicle['featuresLoadings'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                                      ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                                      ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 1))->result_array();

                      $EvaluationVehicle['bdChkup'] = $this->db->select($this->tbl_valuation_ful_bd_chkup . '.*, ' . $this->tbl_valuation_ful_bd_chkup_master . '.*, ' .
                                              $this->tbl_valuation_ful_bd_chkup_details . '.*')
                                      ->join($this->tbl_valuation_ful_bd_chkup_master, $this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_master', 'LEFT')
                                      ->join($this->tbl_valuation_ful_bd_chkup_details, $this->tbl_valuation_ful_bd_chkup_details . '.vfbcd_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_details', 'LEFT')
                                      ->order_by($this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_order')->get_where($this->tbl_valuation_ful_bd_chkup, array('vfbc_valuation_master' => $id))->result_array();

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
            }
       }

       function newEvaluation($data) {
            if (!empty($data)) {
                 foreach ($data as $key => $value) {
                      if (empty($data[$key])) {
                           unset($data[$key]);
                      }
                 }
                 $data['val_added_by'] = $this->uid;
                 $data['val_showroom'] = (isset($data['val_showroom']) && !empty($data['val_showroom'])) ?
                         $data['val_showroom'] : get_logged_user('usr_showroom');
                 $insDate = $data['val_insurance_comp_date'];
                                  isset($data['val_delv_date']) ? $data['val_delv_date'] = date('Y-m-d', strtotime($data['val_delv_date'])) : '';
                 isset($data['val_reg_date']) ? $data['val_reg_date'] = date('Y-m-d', strtotime($data['val_reg_date'])) : '';
                 isset($data['val_insurance_validity']) ? $data['val_insurance_validity'] = date('Y-m-d', strtotime($data['val_insurance_validity'])) : '';
                 isset($data['val_last_service']) ? $data['val_last_service'] = date('Y-m-d', strtotime($data['val_last_service'])) : '';
                 isset($data['val_manf_date']) ? $data['val_manf_date'] = date('Y-m-d', strtotime($data['val_manf_date'])) : '';
                 isset($data['val_valuation_date']) ? $data['val_valuation_date'] = date('Y-m-d', strtotime($data['val_valuation_date'])) : '';
                 isset($data['val_hypo_loan_date']) ? $data['val_hypo_loan_date'] = date('Y-m-d', strtotime($data['val_hypo_loan_date'])) : '';
                 isset($data['val_hypo_frclos_date']) ? $data['val_hypo_frclos_date'] = date('Y-m-d', strtotime($data['val_hypo_frclos_date'])) : '';
                 isset($data['val_hypo_loan_end_date']) ? $data['val_hypo_loan_end_date'] = date('Y-m-d', strtotime($data['val_hypo_loan_end_date'])) : '';
                 isset($data['val_insurance_comp_date']) ? $data['val_insurance_comp_date'] = date('Y-m-d', strtotime($data['val_insurance_comp_date'])) : '';
                 isset($data['val_insurance_ll_date']) ? $data['val_insurance_ll_date'] = date('Y-m-d', strtotime($data['val_insurance_ll_date'])) : '';
                 isset($data['val_ex_wrnty_validity']) ? $data['val_ex_wrnty_validity'] = date('Y-m-d', strtotime($data['val_ex_wrnty_validity'])) : '';
                 isset($data['val_wrnty_nxt_ser_date']) ? $data['val_wrnty_nxt_ser_date'] = date('Y-m-d', strtotime($data['val_wrnty_nxt_ser_date'])) : '';

                 $data['val_veh_no'] = strtoupper($data['val_prt_1'] . '-' . $data['val_prt_2'] . '-' . $data['val_prt_3'] . '-' . $data['val_prt_4']);
                 $data['val_top_up_loan'] = isset($data['val_top_up_loan']) ? 1 : 0;
                 $data['val_battery_warranty'] = isset($data['val_battery_warranty']) ? 1 : 0;
                 $data['val_status'] = 12;
                 $this->db->insert($this->tbl_valuation, $data);
                 $id = $this->db->insert_id();

                 generate_log(array(
                     'log_title' => 'New Evaluation',
                     'log_desc' => 'New evaluation ',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'C',
                     'log_ref_id' => $id,
                     'log_added_by' => $this->uid
                 ));

                 //Add dummy product
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
                     'prd_insurance_idv' => $data['val_insurance_comp_idv'],
                     'prd_fual' => $data['val_fuel'],
                     'prd_year' => $data['val_model_year'],
                     'prd_color' => $data['val_color'],
                     'prd_owner' => $data['val_no_of_owner'],
                     'prd_engine_cc' => $data['val_eng_cc'],
                     'prd_date' => date('Y-m-d:H:i:s'),
                     'prd_status' => 0,
                 );
                 $this->db->insert($this->tbl_products, $product);
                 //Add dummy product
                 return $id;
            } else {
                 generate_log(array(
                     'log_title' => 'New Evaluation',
                     'log_desc' => 'Error while add new evaluation ',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'C',
                     'log_ref_id' => 0,
                     'log_added_by' => $this->uid
                 ));
                 return false;
            }
       }

       function updateEvaluation($id, $data) {
            if (!empty($data)) {
                 foreach ($data as $key => $value) {
                      if (empty($data[$key])) {
                           unset($data[$key]);
                      }
                 }
                 $data['val_updated_by'] = $this->uid;
                 $data['val_status'] = (isset($data['val_status']) && !empty($data['val_status'])) ? $data['val_status'] : 12;

                 isset($data['val_delv_date']) ? $data['val_delv_date'] = date('Y-m-d', strtotime($data['val_delv_date'])) : '';
                 isset($data['val_reg_date']) ? $data['val_reg_date'] = date('Y-m-d', strtotime($data['val_reg_date'])) : '';
                 isset($data['val_insurance_validity']) ? $data['val_insurance_validity'] = date('Y-m-d', strtotime($data['val_insurance_validity'])) : '';
                 isset($data['val_last_service']) ? $data['val_last_service'] = date('Y-m-d', strtotime($data['val_last_service'])) : '';
                 isset($data['val_manf_date']) ? $data['val_manf_date'] = date('Y-m-d', strtotime($data['val_manf_date'])) : '';
                 isset($data['val_valuation_date']) ? $data['val_valuation_date'] = date('Y-m-d', strtotime($data['val_valuation_date'])) : '';
                 isset($data['val_hypo_loan_date']) ? $data['val_hypo_loan_date'] = date('Y-m-d', strtotime($data['val_hypo_loan_date'])) : '';
                 isset($data['val_hypo_frclos_date']) ? $data['val_hypo_frclos_date'] = date('Y-m-d', strtotime($data['val_hypo_frclos_date'])) : '';
                 isset($data['val_hypo_loan_end_date']) ? $data['val_hypo_loan_end_date'] = date('Y-m-d', strtotime($data['val_hypo_loan_end_date'])) : '';
                 isset($data['val_insurance_comp_date']) ? $data['val_insurance_comp_date'] = date('Y-m-d', strtotime($data['val_insurance_comp_date'])) : '';
                 isset($data['val_insurance_ll_date']) ? $data['val_insurance_ll_date'] = date('Y-m-d', strtotime($data['val_insurance_ll_date'])) : '';
                 isset($data['val_ex_wrnty_validity']) ? $data['val_ex_wrnty_validity'] = date('Y-m-d', strtotime($data['val_ex_wrnty_validity'])) : '';
                 isset($data['val_wrnty_nxt_ser_date']) ? $data['val_wrnty_nxt_ser_date'] = date('Y-m-d', strtotime($data['val_wrnty_nxt_ser_date'])) : '';
                 $data['val_top_up_loan'] = isset($data['val_top_up_loan']) ? 1 : 0;
                 $data['val_battery_warranty'] = isset($data['val_battery_warranty']) ? 1 : 0;
                 $this->db->where('val_id', $id);
                 $this->db->update($this->tbl_valuation, $data);
                 generate_log(array(
                     'log_title' => 'Update Evaluation',
                     'log_desc' => 'Update Evaluation',
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

       function newEvaluationComplaints($data) {
            if (!empty($data)) {
                 $this->db->insert($this->tbl_valuation_complaint, $data);
                 return true;
            } else {
                 return false;
            }
       }

       function newEvaluationDocument($data) {
            if (!empty($data)) {
                 $this->db->insert($this->tbl_valuation_documents, $data);
                 return true;
            } else {
                 return false;
            }
       }

       function delete($id) {
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

       function forceDelete($id) {
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

       function deleteImage($id) {
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

       function autoComVehicleEvaluation($qry) {
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

       function checkVehicleExists($data) {

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

       function getOwnParkAndSaleCars() {
            return $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*,' .
                                    $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' . $this->tbl_enquiry . '.*')
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                            ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
                            ->where_in($this->tbl_valuation . '.val_type', array(1, 2, 3))
                            ->where($this->tbl_valuation . '.val_status', 39)/* Stock vehicle */
                            ->get($this->tbl_valuation)->result_array();
       }

       function deleteDocument($id) {
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

       function isVehicleSold($valuationId) {
            $salesInfo = $this->db->get_where($this->tbl_valuation_status, array('est_valuation_id' => $valuationId, 'est_status' => 11))->row_array();
            if (!empty($salesInfo)) {
                 return true;
            }
            return false;
       }

       function updateAsSold($data) {
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
                           $this->db->insert('cpnl_vehicle_status_tmp', $tmpData);
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

       function autoComSE($qry) {
            if (!empty($qry)) {
                 $this->db->select('usr_id AS data, usr_first_name AS value');
                 $this->db->like('usr_first_name', $qry, 'after');
                 $this->db->where('usr_active', 1);
                 $this->db->where('usr_id != 1');
                 return $this->db->get($this->tbl_users)->result_array();
            }
       }

       function autoComCustomer($qry) {
            if (!empty($qry)) {
                 //$this->db->select('enq_id AS data, enq_cus_name AS value');
                 $this->db->select("enq_id AS data, CONCAT(enq_cus_name, ' ', enq_cus_mobile) AS value", false);
                 $this->db->like('enq_cus_name', $qry, 'after');
                 $this->db->where('enq_current_status', 1);
                 $this->db->where('enq_cus_status', 1);
                 return $this->db->get($this->tbl_enquiry)->result_array();
            }
       }

       function getAllEvaluators() {
            return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
                                    $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
                            ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                            ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                            ->where(array($this->tbl_groups . '.grp_slug' => 'EV'))->where(array($this->tbl_users . '.usr_active' => 1))
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                            ->get($this->tbl_users)->result_array();
       }

       function getAllManagers() {
            return $this->db->select($this->tbl_users . '.usr_id AS col_id, ' . $this->tbl_users . '.usr_first_name AS col_title, ' .
                                    $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*,' . $this->tbl_showroom . '.shr_location')
                            ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                            ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                            ->where($this->tbl_groups . ".grp_slug = 'MG' OR " . $this->tbl_groups . ".grp_slug = 'TL'")
                            ->where(array($this->tbl_users . '.usr_active' => 1))
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
                            ->get($this->tbl_users)->result_array();
       }

       function getAllVehicleFeatures() {
            return $this->db->order_by('vftr_order', 'ASC')->get_where($this->tbl_vehicle_features, array('vftr_status' => 1, 'vftr_features_add_on' => 0))->result_array();
       }

       function getVehicleAddOnFeatures() {
            return $this->db->order_by('vftr_order', 'ASC')->get_where($this->tbl_vehicle_features, array('vftr_status' => 1, 'vftr_features_add_on' => 1))->result_array();
       }

       function getFullBodyCheckupMaster($oddOrEven = '') {


            if ($oddOrEven AND $oddOrEven == 'odd') {
                 $sql = "SELECT * FROM ( SELECT @row := @row +1 AS rownum,`vfbcm_order`,`vfbcm_id`,vfbcm_title,vfbcm_status FROM ( SELECT @row :=0) r, cpnl_valuation_ful_bd_chkup_master ) ranked WHERE rownum % 2 != 0 AND vfbcm_status=1 ORDER BY `vfbcm_order` asc";
                 $query = $this->db->query($sql);
                 $res = $query->result_array();
                 return $res;
            } elseif ($oddOrEven AND $oddOrEven == 'even') {
                 $sql = "SELECT * FROM ( SELECT @row := @row +1 AS rownum,`vfbcm_order`,`vfbcm_id`,vfbcm_title,vfbcm_status FROM ( SELECT @row :=0) r, cpnl_valuation_ful_bd_chkup_master ) ranked WHERE rownum % 2 = 0 AND vfbcm_status=1 ORDER BY `vfbcm_order` asc";
                 $query = $this->db->query($sql);
                 $res = $query->result_array();
                 return $res;
            } else {
                 $qry = $this->db->order_by('vfbcm_order');
                 $res = $qry->get_where($this->tbl_valuation_ful_bd_chkup_master, array('vfbcm_status' => 1))->result_array();
                 return $res;
            }
       }

       function getFullBodyCheckupDetailByMaster($masterId) {
            $qry = $this->db->order_by('vfbcd_order')->get_where($this->tbl_valuation_ful_bd_chkup_details, array('vfbcd_master' => $masterId, 'vfbcd_status' => 1));
            return $qry->result_array();
       }

       function newFeatures($data) {
            if (!empty($data)) {
                 $this->db->insert($this->tbl_valuation_features, $data);
                 return true;
            }
            return false;
       }

       function fullBodyCheckup($data) {
            if (!empty($data)) {
                 $this->db->insert($this->tbl_valuation_ful_bd_chkup, $data);
                 return true;
            }
            return false;
       }

       function upgradeDetails($data, $evId) {
            if (!empty($data)) {
                 $count = count($data['upgrd_key']);
                 for ($i = 0; $i < $count; $i++) {
                      $upgrKey = isset($data['upgrd_key'][$i]) ? $data['upgrd_key'][$i] : 0;
                      $upgrVal = isset($data['upgrd_value'][$i]) ? $data['upgrd_value'][$i] : 0;
                      $this->db->insert($this->tbl_valuation_upgrade_details, array(
                          'upgrd_master_id' => $evId, 'upgrd_key' => $upgrKey, 'upgrd_value' => $upgrVal,
                          'upgrd_added_by' =>$this->uid,
                                  'upgrd_created_at'=>date('Y-m-d H:i:s')
                      ));
                 }
            }
       }

       function removeFeaturesByMaster($id) {
            if (!empty($id)) {
                 $this->db->where('vfet_valuation', $id)->delete($this->tbl_valuation_features);
                 return true;
            }
            return false;
       }

       function removeBodyCheckupByMaster($id) {
            if (!empty($id)) {
                 $this->db->where('vfbc_valuation_master', $id)->delete($this->tbl_valuation_ful_bd_chkup);
                 return true;
            }
            return false;
       }

       function removeUpgradeDetailsByMaster($id) {
            if (!empty($id)) {
                 $this->db->where('upgrd_master_id', $id)->delete($this->tbl_valuation_upgrade_details);
                 return true;
            }
            return false;
       }

       function uploadEvaluationVehicleImages($data) {
            if (!empty($data)) {
                 $this->db->insert($this->tbl_valuation_veh_images, $data);
                 return true;
            }
            return false;
       }

       function deleteValuationVehicleImage($id) {
            if ($this->db->where('vvi_id', $id)->delete($this->tbl_valuation_veh_images)) {
                 return true;
            } else {
                 return false;
            }
       }

       function updateDocumentType($valType, $valId) {
            if ($this->db->where('vdoc_id', $valType)->update($this->tbl_valuation_documents, array('vdoc_doc_type' => $valId))) {
                 return true;
            } else {
                 return false;
            }
       }

       function refurbisheReturn($datas) {
            if (isset($datas['refrubishjob']) && !empty($datas['refrubishjob'])) {
                 foreach ($datas['refrubishjob'] as $key => $value) {
                      $isDone = !empty($value['newcost']) ? 1 : 0;
                      $this->db->where('upgrd_id', $value['upgrd_id'])->update(
                              $this->tbl_valuation_upgrade_details,
                              array('upgrd_refurb_actual_cost' => $value['newcost'],
                                  'actual_job_description' => $value['actual_job_desc'],
                                  'upgrd_refurb_remarks' => $value['desc'],
                                  'upgrd_is_done' => $isDone  ,
                                   'upgrd_added_by' =>$this->uid,
                                  'upgrd_created_at'=>date('Y-m-d H:i:s')
                                  )
                      );
                 }
            }

            if (isset($datas['newRefrubishjob']) && !empty($datas['newRefrubishjob'])) {
                 $refurb = isset($datas['newRefrubishjob']['refurb_job']) ? count($datas['newRefrubishjob']['refurb_job']) : 0;
                 for ($i = 0; $i < $refurb; $i++) {
                      //foreach ($datas['newRefrubishjob'] as $key => $value) {
                      $this->db->insert(
                              $this->tbl_valuation_upgrade_details,
                              array(
                                  'upgrd_master_id' => $datas['evaluationId'],
                                  'actual_job_description' => isset($datas['newRefrubishjob']['actual_job_desc'][$i]) ? $datas['newRefrubishjob']['actual_job_desc'][$i] : 0,
                                  'upgrd_key' => isset($datas['newRefrubishjob']['refurb_job'][$i]) ? $datas['newRefrubishjob']['refurb_job'][$i] : 0,
                                  'upgrd_value' => isset($datas['newRefrubishjob']['refurb_job_cost'][$i]) ? $datas['newRefrubishjob']['refurb_job_cost'][$i] : 0,
                                  'upgrd_refurb_actual_cost' => isset($datas['newRefrubishjob']['newcost'][$i]) ? $datas['newRefrubishjob']['newcost'][$i] : 0,
                                  'upgrd_refurb_remarks' => isset($datas['newRefrubishjob']['desc'][$i]) ? $datas['newRefrubishjob']['desc'][$i] : 0,
                                  'upgrd_is_done' => 1,
                                  'upgrd_added_by' =>$this->uid,
                                  'upgrd_created_at'=>date('Y-m-d H:i:s')
                              )
                      );
                 }
            }
       }

       function newvehiclefature($data) {
            $data['vftr_added_on'] = date('Y-m-d H:i:s');
            $data['vftr_abbed_by'] = $this->uid;
            $data['vftr_features_add_on'] = isset($data['vftr_features_add_on']) ? $data['vftr_features_add_on'] : 0;
            $data['vftr_order'] = $this->db->select_max('vftr_order')->get($this->tbl_vehicle_features)->row()->vftr_order + 1;
            $this->db->insert($this->tbl_vehicle_features, $data);
            $id = $this->db->insert_id();
            return array('id' => $id, 'name' => $data['vftr_feature'], 'isadon' => $data['vftr_features_add_on']);
       }

       //   jsk
       function getEvaluationDetails($id = '') {
            if (!empty($id)) {
                 $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.val_veh_no,' . $this->tbl_valuation . '.val_cust_name,' . $this->tbl_valuation . '.val_rc_owner,' . $this->tbl_valuation . '.val_chasis_no,' . $this->tbl_model . '.*,' .
                                         $this->tbl_brand . '.brd_title,' . $this->tbl_brand . '.brd_id,' . $this->tbl_variant . '.var_variant_name,' . $this->tbl_variant . '.var_id,' . $this->tbl_users . '.usr_username,' .
                                         $this->tbl_users . '.usr_first_name,' . $this->tbl_showroom . '.*,' . $this->tbl_divisions . '.div_name,' .
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

       function getCheck_listItemsByCategory($category_id = '') {
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

       function insertPurchaseCheckListMaster($data) {
            if (!empty($data)) {
                                $this->db->insert($this->tbl_purchase_check_list, $data);
                 $insert_id = $this->db->insert_id();
                 $this->db->where('val_id', $data['pcl_val_id']); //update valuation cpnl_valuation val_status as 39//tk out of this func
                 $this->db->update($this->tbl_valuation, array('val_status' => 39,'val_purchased_date' => $data['pcl_created_at']));

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

       function insertPurchaseCheckDetails($data) {
            if (!empty($data)) {
                 $this->db->insert($this->tbl_purchase_check_list_details, $data);
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

       function updtPurchaseCheckDetails($data, $ChkDtl_id) {
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

       function getPurchase_check_list($masterId = '') {
            //For printing purpose
            if ($masterId) {
                 $this->db->select($this->tbl_purchase_check_list . '.*,')
                         ->where($this->tbl_purchase_check_list . '.pcl_check_list_id  ', $masterId);
                 $data['masterData'] = $this->db->from($this->tbl_purchase_check_list)->get()->row_array();

                 $this->db->select($this->tbl_purchase_check_list_details . '.*,' . $this->tbl_chklist_cat_item . '.chitem_name,' . $this->tbl_chklist_cat_item . '.chitem_id,' . $this->tbl_chklist_cat_item . '.sort_order,')
                         ->from($this->tbl_purchase_check_list_details)
                         ->where($this->tbl_purchase_check_list_details . '.pcld_check_list_master_id  ', $masterId)
                         ->join($this->tbl_chklist_cat_item, $this->tbl_chklist_cat_item . '.chitem_id  = ' . $this->tbl_purchase_check_list_details . '.pcld_check_list_item_id', 'LEFT');

                 $this->db->order_by($this->tbl_chklist_cat_item . ".sort_order", "asc");
                 $data['detailsData'] = $this->db->get()->result();
                 return $data;
            } else {
                 return false;
            }
       }

       function getPrchsChkMstrID($evalId = '') {
            if ($evalId) {
                 $this->db->select('pcl_check_list_id,pcl_created_at')
                         ->where($this->tbl_purchase_check_list . '.pcl_val_id', $evalId);
                 $prchsChkId = $this->db->from($this->tbl_purchase_check_list)->get()->row_array();
                 return $prchsChkId;
            }
       }

       function getRefurbDetails($evalId = '') {
            if ($evalId) {
                 $this->db->select($this->tbl_valuation_upgrade_details . '.*,')
                         ->where($this->tbl_valuation_upgrade_details . '.upgrd_master_id  ', $evalId);
                 $data['refrbData'] = $this->db->from($this->tbl_valuation_upgrade_details)->get()->result();
                 return $data['refrbData'];
            }
       }

       function getChkDtls($chitem_id = 0, $chkMstrId) {

            if ($chitem_id && $chkMstrId) {
                 $row = $this->db->get_where($this->tbl_purchase_check_list_details,
                                 array('pcld_check_list_item_id' => $chitem_id, 'pcld_check_list_master_id' => $chkMstrId))->row();
                 return $row;
            }
            return false;
       }

       function isVehicleEvaluated($valuationId) {
            //check vehicle is evaluated or not 
            $result = $this->db->where("val_id", $valuationId)->where_in('val_status', ['39', '12'])->get($this->tbl_valuation)->num_rows();
            if ($result > 0) {
                 return true;
            }
            return false;
       }

       function getChklstItemName($id) {
            if ($id) {
                 return $this->db->select($this->tbl_chklist_cat_item . '.chitem_name')->get_where($this->tbl_chklist_cat_item, array('chitem_id' => $id))->row();
            }
            return false;
       }

       function getTypeByEvalId($id = '') {
            /* fetch type id from evaluation tbl to display Purchase type in Purchase_check_list_print and print_tab */
            if (!empty($id)) {
                 $row = $this->db->select($this->tbl_valuation . '.val_type,')->get_where($this->tbl_valuation, array('val_id ' => $id))->row();
                 return @$row->val_type;
            }
            return false;
       }

       function createReEvaluation($data, $val_id, $enquiry_id = '') {
            //  debug($data);
            // exit;
            if (!empty($data)) {
                 foreach ($data as $key => $value) {
                      if (empty($data[$key])) {
                           unset($data[$key]);
                      }
                 }
                 $data['val_added_by'] = $this->uid;
                 $data['val_parent_id'] = $val_id;
                 $data['val_enquiry_id'] = $enquiry_id;
                 $data['val_showroom'] = (isset($data['val_showroom']) && !empty($data['val_showroom'])) ?
                         $data['val_showroom'] : get_logged_user('usr_showroom');
                 isset($data['val_delv_date']) ? $data['val_delv_date'] = date('Y-m-d', strtotime($data['val_delv_date'])) : '';
                 isset($data['val_reg_date']) ? $data['val_reg_date'] = date('Y-m-d', strtotime($data['val_reg_date'])) : '';
                 isset($data['val_insurance_validity']) ? $data['val_insurance_validity'] = date('Y-m-d', strtotime($data['val_insurance_validity'])) : '';
                 isset($data['val_last_service']) ? $data['val_last_service'] = date('Y-m-d', strtotime($data['val_last_service'])) : '';
                 isset($data['val_manf_date']) ? $data['val_manf_date'] = date('Y-m-d', strtotime($data['val_manf_date'])) : '';
                 isset($data['val_valuation_date']) ? $data['val_valuation_date'] = date('Y-m-d', strtotime($data['val_valuation_date'])) : '';
                 isset($data['val_hypo_loan_date']) ? $data['val_hypo_loan_date'] = date('Y-m-d', strtotime($data['val_hypo_loan_date'])) : '';
                 isset($data['val_hypo_frclos_date']) ? $data['val_hypo_frclos_date'] = date('Y-m-d', strtotime($data['val_hypo_frclos_date'])) : '';
                 isset($data['val_hypo_loan_end_date']) ? $data['val_hypo_loan_end_date'] = date('Y-m-d', strtotime($data['val_hypo_loan_end_date'])) : '';
                 isset($data['val_insurance_comp_date']) ? $data['val_insurance_comp_date'] = date('Y-m-d', strtotime($data['val_insurance_comp_date'])) : '';
                 isset($data['val_insurance_ll_date']) ? $data['val_insurance_ll_date'] = date('Y-m-d', strtotime($data['val_insurance_ll_date'])) : '';
                 isset($data['val_ex_wrnty_validity']) ? $data['val_ex_wrnty_validity'] = date('Y-m-d', strtotime($data['val_ex_wrnty_validity'])) : '';
                 isset($data['val_wrnty_nxt_ser_date']) ? $data['val_wrnty_nxt_ser_date'] = date('Y-m-d', strtotime($data['val_wrnty_nxt_ser_date'])) : '';

                 $data['val_veh_no'] = $data['val_prt_1'] . '-' . $data['val_prt_2'] . '-' . $data['val_prt_3'] . '-' . $data['val_prt_4'];
                 $data['val_top_up_loan'] = isset($data['val_top_up_loan']) ? 1 : 0;
                 $data['val_battery_warranty'] = isset($data['val_battery_warranty']) ? 1 : 0;
                 $data['val_status'] = 12;
                 $this->db->insert($this->tbl_valuation, $data);
                 $id = $this->db->insert_id();

                 generate_log(array(
                     'log_title' => 'New Evaluation',
                     'log_desc' => 'New evaluation ',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'C',
                     'log_ref_id' => $id,
                     'log_added_by' => $this->uid
                 ));
                 return $id;
            } else {
                 generate_log(array(
                     'log_title' => 'New Evaluation',
                     'log_desc' => 'Error while add new evaluation ',
                     'log_controller' => strtolower(__CLASS__),
                     'log_action' => 'C',
                     'log_ref_id' => 0,
                     'log_added_by' => $this->uid
                 ));
                 return false;
            }
       }

       function re_evaluation_ajax($postDatas, $filterDatas) {
            ///debug($filterDatas['enqStatus']);
            $draw = $postDatas['draw'];
            $row = $postDatas['start'];
            $rowperpage = $postDatas['length']; // Rows display per page
            $columnIndex = $postDatas['order'][0]['column']; // Column index
            $columnName = $postDatas['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $postDatas['order'][0]['dir']; // asc or desc
            $searchValue = $postDatas['search']['value']; // Search value

            $totalRecords = $this->db->where($this->tbl_valuation . '.val_parent_id', $filterDatas['val_id'])->count_all_results($this->tbl_valuation);

            //-----------------------------------------------------------------------------------------
            if (!empty($searchValue)) {
                 $this->db->where("(val_veh_no LIKE '%" . $searchValue . "%' OR shr_location LIKE '%" . $searchValue . "%' OR "
                         . "brd_title LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%') ");
            }

            if (isset($filterDatas['status']) && ($filterDatas['status'] >= 0)) {
                 $this->db->where(array($this->tbl_valuation . '.val_status' => $filterDatas['status']));
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
                 $this->db->where_in($this->tbl_valuation . '.val_evaluator', $filterDatas['val_evaluator']);
            }

            $selArray = array(
                $this->tbl_valuation . '.val_id',
                $this->tbl_valuation . '.val_veh_no',
                $this->tbl_valuation . '.val_status',
                $this->tbl_valuation . '.val_type',
                "DATE_FORMAT(" . $this->tbl_valuation . ".val_added_date, '%m-%d-%Y') AS val_added_date",
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
                $this->tbl_enquiry . '.enq_cus_when_buy',
                'evaluatedBy.usr_username AS evtr_usr_username'
            );
            $totalRecordwithFilter = $this->db->select($selArray)
                    ->where($this->tbl_valuation . '.val_parent_id', $filterDatas['val_id'])
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                    ->join($this->tbl_users . ' evaluatedBy', 'evaluatedBy.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
                    ->count_all_results($this->tbl_valuation);

            //----------------------------------------------------------------------------------------
            if (!empty($columnName) && !empty($columnSortOrder)) {
                 $this->db->order_by($columnName, $columnSortOrder);
            }

            if (!empty($searchValue)) {
                 $this->db->where("(val_veh_no LIKE '%" . $searchValue . "%' OR shr_location LIKE '%" . $searchValue . "%' OR "
                         . "brd_title LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%') ");
            }

            if (isset($filterDatas['status']) && ($filterDatas['status'] >= 0)) {
                 $this->db->where(array($this->tbl_valuation . '.val_status' => $filterDatas['status']));
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
                 $this->db->where_in($this->tbl_valuation . '.val_evaluator', $filterDatas['val_evaluator']);
            }
            $this->db->where($this->tbl_valuation . '.val_parent_id', $filterDatas['val_id']);
            $this->db->limit($rowperpage, $row);
            $data = $this->db->select($selArray)
                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                            ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                            ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
                            ->join($this->tbl_users . ' evaluatedBy', 'evaluatedBy.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                            ->get($this->tbl_valuation)->result_array();
            ## Response
            $dataj['btn_purchs_chk_list'] = 'test demo';

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );
            return $response;
       }

       function getEvaluationCompareBk($id = '', $status = '', $is_re_evaluation = '') {
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            if (!empty($id)) {
                 if ($is_re_evaluation) {//get latest id
                      $this->db->select('val_id')->where(array('val_parent_id' => $id));
                      $this->db->from($this->tbl_valuation);
                      $this->db->order_by('val_id', 'DESC');
                      $latestID = @$this->db->get()->row()->val_id;
                      $latestID != '' ? $id = $latestID : $id = $id;
                 }
                 $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
                                         $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.usr_username,' .
                                         $this->tbl_users . '.usr_first_name,' . $this->tbl_showroom . '.*,' . $this->tbl_divisions . '.div_name,' .
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
                      $EvaluationVehicle['complaints'] = $this->db->get_where($this->tbl_valuation_complaint, array('comp_val_id' => $id))->result_array();
                      $EvaluationVehicle['documents'] = $this->db->order_by('vdoc_id', 'ASC')->get_where($this->tbl_valuation_documents, array('vdoc_val_id' => $id))->result_array();


                      if ($is_re_evaluation) {
                           $EvaluationVehicle['features'] = $this->db->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id))->result_array();
                           $EvaluationVehicle['features'] = isset($EvaluationVehicle['features']) ? array_column($EvaluationVehicle['features'], 'vfet_feature') : array();
                      } else {
                           $EvaluationVehicle['features'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                                           ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                                           ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 0))->result_array();
                      }


                      $EvaluationVehicle['featuresLoadings'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                                      ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                                      ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 1))->result_array();

                      $EvaluationVehicle['bdChkup'] = $this->db->select($this->tbl_valuation_ful_bd_chkup . '.*, ' . $this->tbl_valuation_ful_bd_chkup_master . '.*, ' .
                                              $this->tbl_valuation_ful_bd_chkup_details . '.*')
                                      ->join($this->tbl_valuation_ful_bd_chkup_master, $this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_master', 'LEFT')
                                      ->join($this->tbl_valuation_ful_bd_chkup_details, $this->tbl_valuation_ful_bd_chkup_details . '.vfbcd_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_details', 'LEFT')
                                      ->order_by($this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_order')->get_where($this->tbl_valuation_ful_bd_chkup, array('vfbc_valuation_master' => $id))->result_array();

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
            }
       }

       function getEvaluationComparej($id = '', $is_re_evaluation = '') {
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            if (!empty($id)) {
                 if ($is_re_evaluation) {//get latest id
                      $this->db->select('val_id')->where(array('val_parent_id' => $id));
                      $this->db->from($this->tbl_valuation);
                      $this->db->order_by('val_id', 'DESC');
                      $val_ID = @$this->db->get()->row()->val_id;
                      // $latestID != '' ? $id = $latestID : $id = $id;
                      //debug($latestID);
                 }
                 $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
                                         $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.usr_username,' .
                                         $this->tbl_users . '.usr_first_name,' . $this->tbl_showroom . '.*,' . $this->tbl_divisions . '.div_name,' .
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
                                 ->where(array('val_parent_id' => $id))->get($this->tbl_valuation)->result_array();
                 return $EvaluationVehicle;
                 //debug($EvaluationVehicle);
//               if (!empty($EvaluationVehicle)) {
//                    $EvaluationVehicle['complaints'] = $this->db->get_where($this->tbl_valuation_complaint, array('comp_val_id' => $id))->result_array();
//                    $EvaluationVehicle['documents'] = $this->db->order_by('vdoc_id', 'ASC')->get_where($this->tbl_valuation_documents, array('vdoc_val_id' => $id))->result_array();
//
//
//                    if ($is_re_evaluation) {
//                         $EvaluationVehicle['features'] = $this->db->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id))->result_array();
//                         $EvaluationVehicle['features'] = isset($EvaluationVehicle['features']) ? array_column($EvaluationVehicle['features'], 'vfet_feature') : array();
//                    } else {
//                         $EvaluationVehicle['features'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
//                                         ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
//                                         ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 0))->result_array();
//                    }
//
//
//                    $EvaluationVehicle['featuresLoadings'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
//                                    ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
//                                    ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 1))->result_array();
//
//                    $EvaluationVehicle['bdChkup'] = $this->db->select($this->tbl_valuation_ful_bd_chkup . '.*, ' . $this->tbl_valuation_ful_bd_chkup_master . '.*, ' .
//                                            $this->tbl_valuation_ful_bd_chkup_details . '.*')
//                                    ->join($this->tbl_valuation_ful_bd_chkup_master, $this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_master', 'LEFT')
//                                    ->join($this->tbl_valuation_ful_bd_chkup_details, $this->tbl_valuation_ful_bd_chkup_details . '.vfbcd_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_details', 'LEFT')
//                                    ->order_by($this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_order')->get_where($this->tbl_valuation_ful_bd_chkup, array('vfbc_valuation_master' => $id))->result_array();
//
//                    $EvaluationVehicle['upgradeDetails'] = $this->db->get_where($this->tbl_valuation_upgrade_details, array('upgrd_master_id' => $id))->result_array();
//
//                    $EvaluationVehicle['valVehImages']['f1'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 1))->row_array();
//                    $EvaluationVehicle['valVehImages']['f2'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 2))->row_array();
//                    $EvaluationVehicle['valVehImages']['f3'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 3))->row_array();
//                    $EvaluationVehicle['valVehImages']['f4'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 4))->row_array();
//                    $EvaluationVehicle['valVehImages']['f5'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 5))->row_array();
//                    $EvaluationVehicle['valVehImages']['f6'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 6))->row_array();
//                    $EvaluationVehicle['valVehImages']['f7'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 7))->row_array();
//                    $EvaluationVehicle['valVehImages']['f8'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 8))->row_array();
//                    $EvaluationVehicle['valVehImages']['f9'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 9))->row_array();
//                    $EvaluationVehicle['valVehImages']['f10'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 10))->row_array();
//                    $EvaluationVehicle['valVehImages']['f11'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 11))->row_array();
//                    $EvaluationVehicle['valVehImages']['f12'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 12))->row_array();
//                    $EvaluationVehicle['valVehImages']['f13'] = $this->db->get_where($this->tbl_valuation_veh_images, array('vvi_val_id' => $id, 'vvi_frame_id' => 13))->row_array();
//               }
            }
       }

       function getEvalCompareTabs($parent_id = '', $is_re_evaluation = '') {
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            if (!empty($parent_id)) {
                 /* if ($is_re_evaluation) {//get latest id
                   $this->db->select('val_id')->where(array('val_parent_id' => $parent_id));
                   $this->db->from($this->tbl_valuation);
                   $this->db->order_by('val_id', 'DESC');
                   $val_ID = @$this->db->get()->row()->val_id;
                   // $latestID != '' ? $id = $latestID : $id = $id;
                   } */
                 $Evaluation['tabs'] = $this->db->select($this->tbl_valuation . '.val_id ,' . $this->tbl_valuation . '.val_parent_id,' . $this->tbl_valuation . '.val_evaluator,' .
                                         'evtr.usr_first_name AS evtr_first_name, evtr.usr_last_name AS evtr_last_name,' . $this->tbl_users . '.usr_username,')
                                 ->join($this->tbl_users . ' evtr', 'evtr.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                                 ->where(array('val_parent_id' => $parent_id))->get($this->tbl_valuation)->result_array();
                 $id = $parent_id;
                 $Evaluation['parent'] = $this->db->select($this->tbl_valuation . '.val_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_model . '.mod_title,' .
                                         $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.var_variant_name,' . $this->tbl_users . '.usr_username,' .
                                         $this->tbl_users . '.usr_first_name,' .
                                         'evtr.usr_first_name AS evtr_first_name, evtr.usr_last_name AS evtr_last_name,')
                                 ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                                 ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                                 ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                                 ->join($this->tbl_users . ' evtr', 'evtr.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                                 ->where(array('val_id' => $id))->get($this->tbl_valuation)->row_array();
                 return $Evaluation;
            }
       }

       function getEvaluationCompare($id = '', $is_re_evaluation = '') {
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            if (!empty($id)) {
//               if ($is_re_evaluation) {//get latest id
//                    $this->db->select('val_id')->where(array('val_parent_id' => $parent_id));
//                    $this->db->from($this->tbl_valuation);
//                    $this->db->order_by('val_id', 'DESC');
//                    $id = @$this->db->get()->row()->val_id;
//                   // $latestID != '' ? $id = $latestID : $id = $id;
//                   //debug($latestID);
//               }
                 /* $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.val_id ,'  .$this->tbl_valuation . '.val_parent_id,'  .
                   $this->tbl_valuation . '.val_evaluator,'.$this->tbl_valuation . '.val_type,'.$this->tbl_valuation . '.val_cust_source,'.$this->tbl_valuation . '.val_refferer_name,'.$this->tbl_valuation . '.val_location,'.$this->tbl_valuation . '.val_in_time,'.$this->tbl_valuation . '.val_out_time,'.$this->tbl_valuation . '.val_cust_name,'.$this->tbl_valuation . '.val_cust_phone,'.$this->tbl_valuation . '.val_veh_no,'.$this->tbl_valuation . '.val_first_dlvry_location,'.$this->tbl_valuation . '.val_added_date,'.$this->tbl_valuation . '.val_refferal_type,'.$this->tbl_valuation . '.val_first_dlvry_state,'.$this->tbl_valuation . '.val_first_dlvry_dlrship,'.$this->tbl_valuation . '.val_no_of_owner,'.$this->tbl_valuation . '.val_veh_type,'
                   .$this->tbl_valuation . '.val_no_of_seats,'.$this->tbl_valuation . '.val_eng_cc,'.$this->tbl_valuation . '.val_color,'.$this->tbl_valuation . '.val_km,'.$this->tbl_valuation . '.val_model_year,'.$this->tbl_valuation . '.val_minif_year,'.$this->tbl_valuation . '.val_fuel,'.$this->tbl_valuation . '.val_transmission,'.$this->tbl_valuation . '.val_ac,'.$this->tbl_valuation . '.val_ac_zone,'.$this->tbl_valuation . '.val_engine_no,'.$this->tbl_valuation . '.val_chasis_no,'.$this->tbl_valuation . '.val_rc_owner,'.$this->tbl_valuation . '.val_insurance_company,'.$this->tbl_valuation . '.val_insurance_comp_idv,'.$this->tbl_valuation . '.val_insurance_ll_idv,'.$this->tbl_valuation . '.val_insurance_need_ncb,'
                   .$this->tbl_valuation . '.val_finance,'.$this->tbl_valuation . '.val_hypo_close_by_cust,'.$this->tbl_valuation . '.val_air_bags,'.$this->tbl_valuation . '.val_exhaust,'.$this->tbl_valuation . '.val_no_of_pw,'.$this->tbl_valuation . '.val_wrnty,'.$this->tbl_valuation . '.val_last_service_km,'.$this->tbl_valuation . '.val_wrnty_extra,'.$this->tbl_valuation . '.val_wrnty_service_req_aod,'.$this->tbl_valuation . '.val_wrnty_act_serv_aod,'.$this->tbl_valuation . '.val_wrnty_spl_ser_observ,'.$this->tbl_valuation . '.val_wrnty_spl_ser_observ,'
                   . $this->tbl_model . '.*,' .
                   $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.usr_username,' .
                   $this->tbl_users . '.usr_first_name,' . $this->tbl_showroom . '.*,' . $this->tbl_divisions . '.div_name,' .
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
                   ->where(array('val_id' => $id))->get($this->tbl_valuation)->row_array(); */

                 $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
                                         $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.usr_username,' .
                                         $this->tbl_users . '.usr_first_name,' . $this->tbl_showroom . '.*,' . $this->tbl_divisions . '.div_name,' .
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
                      $EvaluationVehicle['complaints'] = $this->db->get_where($this->tbl_valuation_complaint, array('comp_val_id' => $id))->result_array();
                      $EvaluationVehicle['documents'] = $this->db->order_by('vdoc_id', 'ASC')->get_where($this->tbl_valuation_documents, array('vdoc_val_id' => $id))->result_array();


                      if ($is_re_evaluation) {
                           $EvaluationVehicle['features'] = $this->db->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id))->result_array();
                           $EvaluationVehicle['features'] = isset($EvaluationVehicle['features']) ? array_column($EvaluationVehicle['features'], 'vfet_feature') : array();
                      } else {
                           $EvaluationVehicle['features'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                                           ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                                           ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 0))->result_array();
                      }


                      $EvaluationVehicle['featuresLoadings'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                                      ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                                      ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 1))->result_array();

                      $EvaluationVehicle['bdChkup'] = $this->db->select($this->tbl_valuation_ful_bd_chkup . '.*, ' . $this->tbl_valuation_ful_bd_chkup_master . '.*, ' .
                                              $this->tbl_valuation_ful_bd_chkup_details . '.*')
                                      ->join($this->tbl_valuation_ful_bd_chkup_master, $this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_master', 'LEFT')
                                      ->join($this->tbl_valuation_ful_bd_chkup_details, $this->tbl_valuation_ful_bd_chkup_details . '.vfbcd_id = ' . $this->tbl_valuation_ful_bd_chkup . '.vfbc_chkup_details', 'LEFT')
                                      ->order_by($this->tbl_valuation_ful_bd_chkup_master . '.vfbcm_order')->get_where($this->tbl_valuation_ful_bd_chkup, array('vfbc_valuation_master' => $id))->result_array();

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
            }
       }

       function getEvlFeatures($id = '') {
            if ($id) {
                 $EvaluationVehicle['features'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                                 ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                                 ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 0))->result_array();

                 $EvaluationVehicle['featuresLoadings'] = $this->db->select($this->tbl_valuation_features . '.*, ' . $this->tbl_vehicle_features . '.*')
                                 ->join($this->tbl_vehicle_features, $this->tbl_vehicle_features . '.vftr_id = ' . $this->tbl_valuation_features . '.vfet_feature', 'LEFT')
                                 ->order_by($this->tbl_vehicle_features . '.vftr_order')->get_where($this->tbl_valuation_features, array('vfet_valuation' => $id, 'vftr_features_add_on' => 1))->result_array();
                 return $EvaluationVehicle;
            }
       }

       function getofferPrices($id = '') {

            $data = $this->db->select($this->tbl_offer_prices . '.*,' . $this->tbl_valuation . '.val_showroom,' . $this->tbl_valuation . '.val_brand,' . $this->tbl_valuation . '.val_model,' . $this->tbl_valuation . '.val_variant,' . $this->tbl_valuation . '.val_cust_name,' . $this->tbl_valuation . '.val_cust_phone,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_users . '.usr_first_name AS salesExicutive')
                            ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_offer_prices . '.ofrp_val_id', 'left')
                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_offer_prices . '.ofrp_added_by', 'left')
                            ->where(array('ofrp_val_id' => $id))->get($this->tbl_offer_prices)->result_array();
            return $data;
       }

       function offerPriceData($shr_id = '', $brand_id = '', $model_id = '', $varnt_id = '') {
            $data['showrm'] = $this->db->select($this->tbl_showroom . '.shr_location,')
                            ->where(array('shr_id' => $shr_id))->get($this->tbl_showroom)->row_array();
            $data['brand'] = $this->db->select($this->tbl_brand . '.brd_title,')
                            ->where(array('brd_id' => $brand_id))->get($this->tbl_brand)->row_array();
            $data['model'] = $this->db->select($this->tbl_model . '.mod_title,')
                            ->where(array('mod_id' => $model_id))->get($this->tbl_model)->row_array();
            $data['tbl_variant'] = $this->db->select($this->tbl_variant . '.var_variant_name,')
                            ->where(array('var_id' => $varnt_id))->get($this->tbl_variant)->row_array();
            return $data;
       }

       function addOfferPrice($data) {
            $data['ofrp_added_by'] = $this->uid;
            $data['ofrp_added_on'] = date('Y-m-d H:i:s');
            $id = $this->db->insert($this->tbl_offer_prices, $data);
            return $id;
       }

       function getPitchedVeh($id = '', $status = '') {
            $this->load->model('enquiry/enquiry_model', 'enquiry');
            if (!empty($id)) {
                 $EvaluationVehicle = $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
                                         $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*,' .
                                         'evtr.usr_first_name AS evtr_first_name, evtr.usr_last_name AS evtr_last_name,' . $this->tbl_enquiry . '.enq_se_id')
                                 ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                                 ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                                 ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
                                 ->join($this->tbl_users . ' evtr', 'evtr.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left')
                                 ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
                                 ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_valuation . '.val_enquiry_id', 'left')
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
                                 ->get($this->tbl_valuation)->row_array();

                 return $EvaluationVehicle;
            }
       }

       function insuranceDetails($veh_id = '') {//any_top_up_loan
            if ($veh_id) {
                 $data = $this->db->select('val_insurance_company as insurance_company,val_insurance_comp_date as valid_up_to,val_insurance_ll_date,val_insurance_comp_idv as idv,val_insurance_ll_idv as ncb_percentage ,val_insurance_need_ncb as ncb_req,val_insurance as insurance_type ,val_hypo_bank as bank,val_hypo_bank_branch as bank_branch,val_hypo_close_by_cust,val_hypo_loan_date as loan_starting_date,val_hypo_loan_end_date as loan_ending_date,val_hypo_daily_int as daily_interest,val_hypo_frclos_val as forclousure_value,val_hypo_frclos_date as forclousure_date,val_hypo_loan_amt as loan_amount,val_top_up_loan as any_top_up_loan,val_hypo_close_by_cust')
                                 //   $data = $this->db->select('val_insurance_company')
                                 ->where('val_vehicle_id', $veh_id)->get($this->tbl_valuation)->row_array();
                 return $data;
            }
            return false;
       }  
       function getEnquiryByMobile($phoneNo) {
          if (!empty($phoneNo)) {
               $cusMobile = substr(trim($phoneNo), -10);
                 $whr = array($this->tbl_vehicle.'.veh_status' => 2, $this->tbl_vehicle.'.veh_type' => 0,$this->tbl_vehicle.'.veh_enq_type_old'=>NULL);
               return $this->db->select($this->tbl_enquiry . '.*,' . $this->tbl_users . '.*,'. $this->tbl_vehicle . '.*,'. $this->tbl_register_master . '.*,'.$this->tbl_valuation.'.*,')
                       ->join($this->tbl_register_master, $this->tbl_register_master . '.vreg_inquiry = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
                       ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_enq_id = ' . $this->tbl_enquiry . '.enq_id', 'LEFT')
                     //   ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle . '.veh_enq_id', 'LEFT')
                        //->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_valuation . '.tbl_valuation', 'LEFT')
                       ->join($this->tbl_valuation, $this->tbl_valuation . '.val_vehicle_id = ' . $this->tbl_vehicle . '.veh_id', 'LEFT')
                               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'LEFT')->where($whr)
                               ->like('enq_cus_mobile', $cusMobile, 'before')->get($this->tbl_enquiry)->row_array();
          }
          return false;
     }
     function getDivisionByShowRoom($show_room) {
          return $this->db->select($this->tbl_showroom . '.shr_division,')->get_where($this->tbl_showroom, array('shr_id ' => $show_room))->row_array();
     }
      function getShowRoomByDivision($division) {
           //return $division;
//          return $this->db->where($this->tbl_showroom, array('shr_division' => $division, 'shr_status' => 1))->result_array();
//           return $this->db->select($this->tbl_showroom . '.shr_location,')->where('shr_division',$division)->result_array();
            return $this->db->where('shr_division', $division)->get($this->tbl_showroom)->result_array();
     }
     
     function getRefurbStatus() {
          return $this->db->where('sts_category', 'refurb-sts')->get($this->tbl_statuses)->result_array(); 
     }
     function updateRefstatus($data) {
         // debug($data);
      $this->db->where('val_id', $data['ref_val_id']);
      unset($data['ref_val_id']);
                  $this->db->update($this->tbl_valuation, $data);    
                  return true;
     }
          //////
     function refurbReqsW($shrm='',$limit, $start) {//sp_detailed_walikin_report
         // debug($start);
            error_reporting(0);
           // $staffs = $this->db->query("CALL sp_get_sl_staffs_by_shrm($shrm)")->result_array();
           $refurbs= $this->db->query("CALL sp_refurb_reqs($shrm,$limit, $start)")->result_array();
           // debug($staffs);
            $this->db->reconnect();
            //$rg=$this->db->last_query();
                       foreach ($refurbs as $key => $value) {
                 $res['refurbInfo'] = $value;
               //  $res['yDayWalkin'] = $this->db->query("CALL sp_detailed_walikin_report($value[usr_id])")->row_array();
                   $res['refJobs'] = $this->db->query("CALL sp_refurb_jobs($value[upgrd_master_id])")->result_array();
                 $this->db->reconnect();
                 $return[] = $res;
            }
        debug($return);
            return $return;
       }
     
     //////////
     ////////////$$$/////
     function refurbReqs($shrj='',$limit, $start) {
         // $this->db->limit($limit, $start);
   $qry = $this->db->select($this->tbl_valuation . '.val_type,' .$this->tbl_valuation . '.val_purchased_date,'.$this->tbl_valuation . '.val_showroom,'.$this->tbl_valuation . '.val_veh_no,'.$this->tbl_valuation . '.val_model_year,'.$this->tbl_valuation . '.val_km,'. $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.brd_title,' .
                                         $this->tbl_variant . '.var_variant_name,' . $this->tbl_users . '.usr_id,' . $this->tbl_valuation_upgrade_details . '.upgrd_id,' . $this->tbl_valuation_upgrade_details . '.upgrd_master_id,'. $this->tbl_valuation_upgrade_details . '.upgrd_key,' . $this->tbl_valuation_upgrade_details . '.upgrd_value,' .$this->tbl_valuation_upgrade_details . '.upgrd_refurb_actual_cost,' .$this->tbl_valuation_upgrade_details . '.actual_job_description,' .
                         $this->tbl_valuation_upgrade_details . '.upgrd_refurb_remarks,' .$this->tbl_valuation_upgrade_details . '.upgrd_is_done,' .$this->tbl_valuation_upgrade_details . '.upgrd_is_approved')
                          ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_valuation_upgrade_details . '.upgrd_master_id', 'left')        
                         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                                 ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                                 ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left');
     if (check_permission('evaluation', 'fltr_evaluater_my_team')) {//
                                                                           
	$qry->where($this->tbl_users . '.usr_tl', $this->uid);
       
 } 
 $qry->where(array($this->tbl_valuation . '.val_re_evaluated' => 0, $this->tbl_valuation_upgrade_details . '.upgrd_is_approved' => 0));
 $qry->group_by($this->tbl_valuation_upgrade_details.'.upgrd_master_id');
 $this->db->limit($limit,$start);
                                $refurbs=$qry->get($this->tbl_valuation_upgrade_details)->result_array();
                               // $rg=$this->db->last_query();
            //debug($rg);
                              //  debug($refurbs);       
                                   foreach ($refurbs as $key => $value) {
                 $res['refurbInfo'] = $value;
               //  $res['yDayWalkin'] = $this->db->query("CALL sp_detailed_walikin_report($value[usr_id])")->row_array();
                   $res['refJobs'] = $this->db->query("CALL sp_refurb_jobs($value[upgrd_master_id])")->result_array();
                 $this->db->reconnect();
                 $return[] = $res;
            }
            //debug($return);
                                 return $return;
                 //debug($return);
     }
     
     
      function refurbReqsCount() {
         // $this->db->limit($limit, $start);
   $qry = $this->db->select($this->tbl_valuation . '.val_id,')
                          ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_valuation_upgrade_details . '.upgrd_master_id', 'left')        
                                                        ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left');
     if (check_permission('evaluation', 'fltr_evaluater_my_team')) {//
                                                                           
	$qry->where($this->tbl_users . '.usr_tl', $this->uid);
       
 } 
 $qry->where(array($this->tbl_valuation . '.val_re_evaluated' => 0, $this->tbl_valuation_upgrade_details . '.upgrd_is_approved' => 0));
 $qry->group_by($this->tbl_valuation_upgrade_details.'.upgrd_master_id');

                                $refurbs=$qry->get($this->tbl_valuation_upgrade_details)->result_array();
                               // $rg=$this->db->last_query();
            //debug($rg);
                              // debug(count($refurbs));       
           
            //debug($return);
                                 return count($refurbs);
                 //debug($return);
     }
       ///@@@////////////
      function updateRefurbJobApproval($is_approved,$upgrd_id,$remarks='') {
           error_reporting(0);
            $res = $this->db->query("CALL sp_update_refurb_approval_reqs($is_approved,$upgrd_id,'$remarks')");
            //  $res = $this->db->query("CALL sp_stock_status_report($limit, $start)")->result_array();
            $this->db->reconnect();
           // debug($this->db->last_query());
      return $res;    
     }
     
     //////newwqwq////////////////////////////
        function approvedRefurbReqs($shrj='',$limit, $start) {
         // $this->db->limit($limit, $start);
   $qry = $this->db->select($this->tbl_valuation . '.val_type,' .$this->tbl_valuation . '.val_purchased_date,'.$this->tbl_valuation . '.val_showroom,'.$this->tbl_valuation . '.val_veh_no,'.$this->tbl_valuation . '.val_model_year,'.$this->tbl_valuation . '.val_km,'. $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.brd_title,' .
                                         $this->tbl_variant . '.var_variant_name,' . $this->tbl_users . '.usr_id,' . $this->tbl_valuation_upgrade_details . '.upgrd_id,' . $this->tbl_valuation_upgrade_details . '.upgrd_master_id,'. $this->tbl_valuation_upgrade_details . '.upgrd_key,' . $this->tbl_valuation_upgrade_details . '.upgrd_value,' .$this->tbl_valuation_upgrade_details . '.upgrd_refurb_actual_cost,' .$this->tbl_valuation_upgrade_details . '.actual_job_description,' .
                         $this->tbl_valuation_upgrade_details . '.upgrd_refurb_remarks,' .$this->tbl_valuation_upgrade_details . '.upgrd_is_done,' .$this->tbl_valuation_upgrade_details . '.upgrd_is_approved,' .$this->tbl_valuation_upgrade_details . '.upgrd_created_at,'.$this->tbl_valuation_upgrade_details . '.upgrd_days_required,'.$this->tbl_valuation_upgrade_details . '.upgrd_service_given_date,'.$this->tbl_valuation_upgrade_details . '.upgrd_service_location,'
)
                          ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_valuation_upgrade_details . '.upgrd_master_id', 'left')        
                         ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                                 ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                                 ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                                 ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_evaluator', 'left');
     //if (check_permission('evaluation', 'fltr_evaluater_my_team')) {//
                                                                           
	//$qry->where($this->tbl_users . '.usr_tl', $this->uid);
       
 //} 
 $qry->where(array($this->tbl_valuation . '.val_re_evaluated' => 0, $this->tbl_valuation_upgrade_details . '.upgrd_is_approved' => 1));
 $qry->group_by($this->tbl_valuation_upgrade_details.'.upgrd_master_id');
 $this->db->limit($limit,$start);
                                $return=$qry->get($this->tbl_valuation_upgrade_details)->result_array();
                               // $rg=$this->db->last_query();
                
//                                   foreach ($refurbs as $key => $value) {
//                 $res['refurbInfo'] = $value;
//                                $res['refJobs'] = $this->db->query("CALL sp_refurb_jobs($value[upgrd_master_id])")->result_array();
//                 $this->db->reconnect();
//                 $return[] = $res;
//            }
            //debug($return);
                                 return $return;
                 //debug($return);
     }
     ///////////////////////////njnjnj//////////////
        function updateRefurbJobByStaff($job_id,$num_of_days,$service_given_date,$service_location) {
             $service_given_date = (isset($service_given_date) && !empty($service_given_date)) ?
                    date('Y-m-d', strtotime($service_given_date)) : '';
             $updatedBy=$this->uid;
           error_reporting(0);
            $res = $this->db->query("CALL sp_update_refurb_job_by_staff($job_id,$num_of_days,'$service_given_date','$service_location',$updatedBy)");
            $this->db->reconnect();
               return $res;    
     }
     
        // @jsk
  }
  ///
  
  
  //val_insurance_company as insurance_company,val_insurance_comp_date as valid_up_to,val_insurance_ll_date,val_insurance_comp_idv as idv,val_insurance_ll_idv as ncb_percentage ,val_insurance_need_ncb as ncb_req,val_insurance as insurance_type ,val_hypo_bank as bank,val_hypo_bank_branch as bank_branch,val_hypo_close_by_cust,val_hypo_loan_date as loan_starting_date,val_hypo_loan_end_date as loan_ending_date,val_hypo_daily_int as daily_interest,val_hypo_frclos_val as forclousure_value,val_hypo_frclos_date as forclousure_date,val_hypo_loan_amt as loan_amount,val_top_up_loan as any_top_up_loan,val_hypo_close_by_cust
        