<?php
if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class mou_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_states = TABLE_PREFIX . 'states';
          $this->tbl_mou_rf = TABLE_PREFIX . 'mou_rf';
          $this->tbl_company = TABLE_PREFIX . 'company';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_divisions = TABLE_PREFIX . 'divisions';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_mou_master = TABLE_PREFIX . 'mou_master';
          $this->tbl_accessories = TABLE_PREFIX . 'accessories';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
          $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->tbl_mou_identification = TABLE_PREFIX . 'mou_identification';
          $this->tbl_mou_service_package = TABLE_PREFIX . 'mou_service_package';
     }

     function getCompany()
     {
          return $this->db->select(
               array('cmp_name', 'cmp_finance_year_code', 'div_id')
          )->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_company . '.cmp_division', 'LEFT')
               ->get($this->tbl_company)->result_array();
     }

     function getMouById($id)
     {
          $return['master'] = $this->db->select($this->tbl_mou_master . '.*,' . $this->tbl_district_statewise . '.*,' .
               $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
               $this->tbl_users . '.usr_username,' . $this->tbl_designation . '.desig_title')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_mou_master . '.moum_dist', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_mou_master . '.moum_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_mou_master . '.moum_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_mou_master . '.moum_varient', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_mou_master . '.moum_pur_staff', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->get_where($this->tbl_mou_master, array('moum_id' => $id))->row_array();
          $id = isset($return['master']['moum_id']) ? $return['master']['moum_id'] : 0;
          $return['rf'] = $this->db->get_where($this->tbl_mou_rf, array('mour_master' => $id))->result_array();
          $return['service'] = $this->db->get_where($this->tbl_mou_service_package, array('mous_master' => $id))->result_array();
          $return['identification'] = $this->db->get_where($this->tbl_mou_identification, array('moui_master' => $id))->result_array();
          return $return;
     }

     function getMou($id)
     {
          $return['master'] = $this->db->select($this->tbl_mou_master . '.*,' . $this->tbl_district_statewise . '.*,' .
               $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
               $this->tbl_users . '.usr_username,' . $this->tbl_designation . '.desig_title')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_mou_master . '.moum_dist', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_mou_master . '.moum_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_mou_master . '.moum_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_mou_master . '.moum_varient', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_mou_master . '.moum_pur_staff', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->get_where($this->tbl_mou_master, array('moum_token' => $id))->row_array();
          $id = isset($return['master']['moum_id']) ? $return['master']['moum_id'] : 0;
          $return['rf'] = $this->db->get_where($this->tbl_mou_rf, array('mour_master' => $id))->result_array();
          $return['service'] = $this->db->get_where($this->tbl_mou_service_package, array('mous_master' => $id))->result_array();
          $return['identification'] = $this->db->get_where($this->tbl_mou_identification, array('moui_master' => $id))->result_array();
          return $return;
     }

     function getPurchaseTokenDetails($mouId)
     {
          $selectArray = array(
               $this->tbl_mou_master . '.moum_customer_name AS val_cust_name',
               $this->tbl_mou_master . '.moum_engine_number AS val_engine_no',
               $this->tbl_mou_master . '.moum_chassis_number AS val_chasis_no',
               $this->tbl_mou_master . '.moum_reg_num AS val_veh_no',
               $this->tbl_mou_master . '.moum_address AS enq_cus_address',
               $this->tbl_mou_master . '.moum_address AS enq_cus_ofc_address',
               $this->tbl_mou_master . '.moum_date AS enq_agreement_date',
               $this->tbl_mou_master . '.moum_date AS dueDate',
               $this->tbl_mou_master . '.moum_net_price AS enh_booking_amt',
               $this->tbl_mou_master . '.moum_adv_token AS enh_adv_amt',
               $this->tbl_mou_master . '.moum_stock_num AS stockID',
               // $this->tbl_mou_master . '.moum_purchase_type AS purchaseType',
               $this->tbl_mou_master . '.moum_fin_year_code AS gcCode',
               $this->tbl_mou_master . '.moum_purchase_type AS val_type_title',
               $this->tbl_mou_master . '.moum_model_year AS val_model_year',
               $this->tbl_mou_master . '.moum_bl_amt AS ec',
               $this->tbl_district_statewise . '.std_district_name AS enq_cus_dist',
               $this->tbl_states . '.sts_name AS enq_cus_state',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_users . '.usr_username AS val_sales_officer_name',
               $this->tbl_showroom . '.shr_location AS val_showroom',
               $this->tbl_vehicle_colors . '.vc_color',
          );
          $return = $this->db->select($selectArray)
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_mou_master . '.moum_dist', 'LEFT')
               ->join($this->tbl_states, $this->tbl_states . '.sts_id = ' . $this->tbl_district_statewise . '.std_state', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_mou_master . '.moum_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_mou_master . '.moum_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_mou_master . '.moum_varient', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_mou_master . '.moum_pur_staff', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_mou_master . '.moum_showroom', 'left')
               ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_mou_master . '.moum_color', 'left')
               ->get_where($this->tbl_mou_master, array('moum_id' => $mouId))->row_array();

          //$return['purchaseType'] = unserialize(SOURCING_TYPE)[$return['purchaseType']];
          $return['val_type_title'] = unserialize(SOURCING_TYPE)[$return['val_type_title']];
          // $return['val_type_title'] = unserialize(VAL_TYPE_TITLE)[$return['val_type_title']];
          $return['enq_agreement_date'] = date('Y-m-d', strtotime($return['enq_agreement_date']));
          $return['dueDate'] = date('Y-m-d', strtotime($return['dueDate']));
          return $return;
     }
     function getValData()
     {
          return $this->db->select('val_id, val_veh_no, val_stock_num')
               ->where("val_stock_num IS NOT NULL AND val_stock_num != ''")->get($this->tbl_valuation)->result_array();
     }
     function addNewMOU($datas)
     {
          generate_log(array(
               'log_title' => 'New mou',
               'log_desc' => serialize($datas),
               'log_controller' => 'new-mou',
               'log_action' => 'C',
               'log_ref_id' => 0,
               'log_added_by' => $this->uid
          ));
          //Master.
          $maxId = $this->db->select_max('moum_id')->get($this->tbl_mou_master)->row()->moum_id + 1;
          $numPart = sprintf("%04d", $maxId);

          $AA = isset($datas['AA']) ? $datas['AA'] : array();
          $AB = isset($datas['AB']) ? $datas['AB'] : array();
          $RF = isset($datas['RF']) ? $datas['RF'] : array();
          unset($datas['AA']);
          unset($datas['AB']);
          unset($datas['RF']);

          if ($datas['moum_division'] == 1) {
               $div = 'S';
          } else if ($datas['moum_division'] == 2) {
               $div = 'L';
          }

          $datas['moum_bl_amt'] = (isset($datas['moum_bl_amt']) && !empty($datas['moum_bl_amt'])) ? $datas['moum_bl_amt'] : 0;
          $datas['moum_purchase_type'] = (isset($datas['moum_purchase_type']) && !empty($datas['moum_purchase_type'])) ? $datas['moum_purchase_type'] : 0;
          $datas['moum_vehicle_category'] = (isset($datas['moum_vehicle_category']) && !empty($datas['moum_vehicle_category'])) ? $datas['moum_vehicle_category'] : 0;
          $datas['moum_dob'] = (isset($datas['moum_dob']) && !empty($datas['moum_dob'])) ? $datas['moum_dob'] : null;
          $datas['moum_age'] = (isset($datas['moum_age']) && !empty($datas['moum_age'])) ? $datas['moum_age'] : 0;
          $datas['moum_number'] = '';
          $datas['moum_added_by'] = $this->uid;
          $datas['moum_added_on'] = date('Y-m-d H:i:s');
          $datas['moum_number'] = 'RD/' . $div . '/' . date('Y') . '/' . $numPart;
          $datas['moum_token'] = md5($maxId);
          $datas['moum_engine_number'] = isset($AA['number']['0']) ? $AA['number']['0'] : '';
          $datas['moum_chassis_number'] = isset($AA['number']['1']) ? $AA['number']['1'] : '';
          $datas['moum_cust_ref_no'] = generate_vehicle_virtual_id($maxId);
          if (empty($datas['moum_stock_num'])) {
               $datas['moum_stock_num'] = $div . 'KL' . date('Ym') . $datas['moum_cust_ref_no'];
          }

          $this->db->insert($this->tbl_mou_master, $datas);
          $masterId = $this->db->insert_id();

          //Identification.
          if (!empty($AA) && isset($AA['component'])) {
               $count = count($AA['component']);
               for ($i = 0; $i < $count; $i++) {
                    $c = isset($AA['component'][$i]) ? $AA['component'][$i] : 0; //component
                    $n = isset($AA['number'][$i]) ? $AA['number'][$i] : 0; //number
                    $r = isset($AA['remarks'][$i]) ? $AA['remarks'][$i] : 0; //remarks
                    if (!empty($c) && !empty($n)) {
                         $this->db->insert($this->tbl_mou_identification, array(
                              'moui_master' => $masterId,
                              'moui_component' => $c,
                              'moui_id_num' => $n,
                              'moui_remarks' => $r
                         ));
                    }
               }
          }

          //service package.
          if (!empty($AB) && isset($AB['component'])) {
               $count = count($AB['component']);
               for ($i = 0; $i < $count; $i++) {
                    $c = isset($AB['component'][$i]) ? $AB['component'][$i] : 0; //component
                    $n = isset($AB['number'][$i]) ? $AB['number'][$i] : 0; //number
                    $r = isset($AB['remarks'][$i]) ? $AB['remarks'][$i] : 0; //remarks
                    if (!empty($c) && !empty($n)) {
                         $this->db->insert($this->tbl_mou_service_package, array(
                              'mous_master' => $masterId,
                              'mous_particulars' => $c,
                              'mous_id_num' => $n,
                              'mous_remaks' => $r
                         ));
                    }
               }
          }

          //Refurbishment.
          if (!empty($RF) && isset($RF['complaints'])) {
               $count = count($RF['complaints']);
               for ($i = 0; $i < $count; $i++) {
                    $c = isset($RF['complaints'][$i]) ? $RF['complaints'][$i] : 0; //complaints
                    $n = isset($RF['works'][$i]) ? $RF['works'][$i] : 0; //works
                    $r = isset($RF['remarks'][$i]) ? $RF['remarks'][$i] : 0; //remarks
                    if (!empty($c) && !empty($n)) {
                         $this->db->insert($this->tbl_mou_rf, array(
                              'mour_master' => $masterId,
                              'mour_complaints' => $c,
                              'mour_rf_to_done' => $n,
                              'mour_remarks' => $r
                         ));
                    }
               }
          }
     }

     function getPurchaseStaff()
     {
          //81 - Purchase Head - North Kerala
          //22 - Purchase Manager
          //24 - Assistant Manager Purchase
          //40 - Area Manager - Purchase
          //35 - Purchase Executive
          //69 - Sr. Purchase Executive
          //64 - Evaluator Sourcer
          //23 - Senior Evaluator
          //6  - ASM
          //11 - Area Manager - Sales
          //79 - Territory Sales Manager
          //18 - Sales Consultant
          return $this->db->select($this->tbl_users . '.usr_id,' .
               $this->tbl_users . '.usr_username,' .
               $this->tbl_showroom . '.shr_location,' .
               $this->tbl_designation . '.desig_title', false)
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_users . '.usr_showroom', 'left')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'left')
               ->where_in($this->tbl_users . '.usr_designation_new', array(81, 22, 24, 40, 35, 69, 64, 23, 6, 11, 79, 18))
               ->where(array($this->tbl_users . '.usr_active' => 1, $this->tbl_users . '.usr_resigned' => 0))
               ->order_by('usr_username')->get($this->tbl_users)->result_array();
     }

     function approval($id, $desc)
     {
          $data['moum_approved_on'] = date('Y-m-d H:i:s');
          $data['moum_approved_by'] = $this->uid;
          $data['moum_approved_desc'] = $desc;
          $this->db->where('moum_id', $id)->update($this->tbl_mou_master, $data);
          return true;
     }

     function getAllRecords()
     {
          if ($this->uid != 100) {
               if (check_permission('mou', 'mou_view_smart')) {
                    $this->db->where($this->tbl_mou_master . '.moum_division', 1);
               } else if (check_permission('mou', 'mou_view_luxury')) {
                    $this->db->where($this->tbl_mou_master . '.moum_division', 2);
               } else if (check_permission('mou', 'mou_view_self')) {
                    $this->db->where($this->tbl_mou_master . '.moum_added_by', $this->uid);
               } else if (check_permission('mou', 'mou_view_my_showroom')) {
                    $this->db->where($this->tbl_mou_master . '.moum_showroom', $this->shrm);
               } else if (check_permission('mou', 'mou_view_my_staff')) {
                    $mystaff = my_staff($this->uid);
                    $this->db->where_in($this->tbl_mou_master . '.moum_added_by', $mystaff);
               } else if (check_permission('mou', 'mou_view_all')) {
               }
          }
          $return = $this->db->select($this->tbl_mou_master . '.*,' . $this->tbl_district_statewise . '.*,' .
               $this->tbl_brand . '.brd_title,' . $this->tbl_model . '.mod_title,' . $this->tbl_variant . '.var_variant_name,' .
               $this->tbl_users . '.usr_username,' . $this->tbl_designation . '.desig_title,' .
               $this->tbl_showroom . '.shr_location,' . $this->tbl_divisions . '.div_name')
               ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_mou_master . '.moum_dist', 'LEFT')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_mou_master . '.moum_brand', 'LEFT')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_mou_master . '.moum_model', 'LEFT')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_mou_master . '.moum_varient', 'LEFT')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_mou_master . '.moum_pur_staff', 'LEFT')
               ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = ' . $this->tbl_users . '.usr_designation_new', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_mou_master . '.moum_showroom', 'LEFT')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_mou_master . '.moum_division', 'LEFT')
               ->get_where($this->tbl_mou_master)->result_array();
          return $return;
     }

     function approveMOU($data)
     {
          $mouId = $data['moum_id'];
          unset($data['moum_id']);
          $engineNo = '';
          $chassisNo = '';
          if (isset($data['AA']) && !empty($data['AA'])) {
               //New identification
               if (isset($data['AA']['new'])) {
                    if (!empty($data['AA']['new']) && isset($data['AA']['new']['component'])) {
                         $count = count($data['AA']['new']['component']);
                         for ($i = 0; $i < $count; $i++) {
                              $c = isset($data['AA']['new']['component'][$i]) ? $data['AA']['new']['component'][$i] : 0; //component
                              $n = isset($data['AA']['new']['number'][$i]) ? $data['AA']['new']['number'][$i] : 0; //number
                              $r = isset($data['AA']['new']['remarks'][$i]) ? $data['AA']['new']['remarks'][$i] : 0; //remarks
                              if (!empty($c) && !empty($n)) {
                                   $this->db->insert($this->tbl_mou_identification, array(
                                        'moui_master' => $mouId,
                                        'moui_component' => $c,
                                        'moui_id_num' => $n,
                                        'moui_remarks' => $r
                                   ));
                              }
                         }
                    }
                    unset($data['AA']['new']);
               }
               //Update existing identification
               foreach ($data['AA'] as $idk => $ids) {
                    if ($ids['component'] == 1) {
                         $engineNo = $ids['number'];
                    }
                    if ($ids['component'] == 2) {
                         $chassisNo = $ids['number'];
                    }
                    $this->db->where('moui_id', $ids['id'])->update($this->tbl_mou_identification, array(
                         'moui_master' => $mouId,
                         'moui_component' => $ids['component'],
                         'moui_id_num' => $ids['number'],
                         'moui_remarks' => $ids['remarks']
                    ));
               }
               unset($data['AA']);
          }

          if (isset($data['AB']) && !empty($data['AB'])) {
               if (isset($data['AB']['new'])) {
                    $count = count($data['AB']['new']['component']);
                    for ($i = 0; $i < $count; $i++) { //new services
                         $c = isset($data['AB']['new']['component'][$i]) ? $data['AB']['new']['component'][$i] : 0; //component
                         $n = isset($data['AB']['new']['number'][$i]) ? $data['AB']['new']['number'][$i] : 0; //number
                         $r = isset($data['AB']['new']['remarks'][$i]) ? $data['AB']['new']['remarks'][$i] : 0; //remarks
                         if (!empty($c) && !empty($n)) {
                              $this->db->insert($this->tbl_mou_service_package, array(
                                   'mous_master' => $mouId,
                                   'mous_particulars' => $c,
                                   'mous_id_num' => $n,
                                   'mous_remaks' => $r
                              ));
                         }
                    }
                    unset($data['AB']['new']);
               }
               //Update existing services
               foreach ($data['AB'] as $idk => $serp) {
                    $this->db->where('mous_id', $serp['id'])->update($this->tbl_mou_service_package, array(
                         'mous_master' => $mouId,
                         'mous_particulars' => $serp['component'],
                         'mous_id_num' => $serp['number'],
                         'mous_remaks' => $serp['remarks']
                    ));
               }
               unset($data['AB']);
          }
          if (isset($data['RF']) && !empty($data['RF'])) {
               if (isset($data['RF']['new'])) {
                    $count = count($data['RF']['new']);
                    for ($i = 0; $i < $count; $i++) {
                         $c = isset($data['RF']['new']['complaints'][$i]) ? $data['RF']['new']['complaints'][$i] : 0; //complaints
                         $n = isset($data['RF']['new']['works'][$i]) ? $data['RF']['new']['works'][$i] : 0; //works
                         $r = isset($data['RF']['new']['remarks'][$i]) ? $data['RF']['new']['remarks'][$i] : 0; //remarks
                         if (!empty($c) && !empty($n)) {
                              $this->db->insert($this->tbl_mou_rf, array(
                                   'mour_master' => $mouId,
                                   'mour_complaints' => $c,
                                   'mour_rf_to_done' => $n,
                                   'mour_remarks' => $r
                              ));
                         }
                    }
                    unset($data['RF']['new']);
               }
               foreach ($data['RF'] as $idk => $serp) {
                    $this->db->where('mour_id', $serp['id'])->update($this->tbl_mou_rf, array(
                         'mour_master' => $mouId,
                         'mour_complaints' => $serp['complaints'],
                         'mour_rf_to_done' => $serp['works'],
                         'mour_remarks' => $serp['remarks']
                    ));
               }
               unset($data['RF']);
          }
          $data['moum_bl_amt'] = (isset($data['moum_bl_amt']) && !empty($data['moum_bl_amt'])) ? $data['moum_bl_amt'] : 0;
          $data['moum_purchase_type'] = (isset($data['moum_purchase_type']) && !empty($data['moum_purchase_type'])) ? $data['moum_purchase_type'] : 0;
          $data['moum_dob'] = (isset($data['moum_dob']) && !empty($data['moum_dob'])) ? $data['moum_dob'] : null;
          $data['moum_vehicle_category'] = (isset($data['moum_vehicle_category']) && !empty($data['moum_vehicle_category'])) ? $data['moum_vehicle_category'] : 0;
          $data['moum_engine_number'] = $engineNo;
          $data['moum_chassis_number'] = $chassisNo;
          $data['moum_approved_on'] = date('Y-m-d H:i:s');
          $data['moum_approved_by'] = $this->uid;
          $this->db->where('moum_id', $mouId)->update($this->tbl_mou_master, $data); // Master
          return true;
     }

     function delete($id)
     {
          $this->db->where('moum_id', $id)->delete($this->tbl_mou_master);
          $this->db->where('moui_master', $id)->delete($this->tbl_mou_identification);
          $this->db->where('mous_master', $id)->delete($this->tbl_mou_service_package);
          $this->db->where('mour_master', $id)->delete($this->tbl_mou_rf);
          return true;
     }

     function alreadyExists($data)
     {
          error_reporting(E_ALL);
          $regNumber = isset($data['regNumber']) ? str_replace(' ', '', $data['regNumber']) : '';
          $phoneNumber = isset($data['phoneNumber']) ? str_replace(' ', '', $data['phoneNumber']) : '';
          if ($regNumber && $phoneNumber) {
               return $this->db->where(array('moum_reg_num' => $regNumber, 'moum_cust_phone' => $phoneNumber))->get($this->tbl_mou_master)->num_rows();
          }
     }
}
