<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class booking_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();

          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_banks = TABLE_PREFIX . 'banks';
          $this->tbl_states = TABLE_PREFIX . 'states';
          $this->tbl_groups = TABLE_PREFIX . 'groups';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_country = TABLE_PREFIX . 'country';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_company = TABLE_PREFIX . 'company';
          $this->tbl_statuses = TABLE_PREFIX . 'statuses';
          $this->tbl_followup = TABLE_PREFIX . 'followup';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_divisions = TABLE_PREFIX . 'divisions';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_rto_office = TABLE_PREFIX . 'rto_office';
          $this->tbl_users_groups = TABLE_PREFIX . 'users_groups';
          $this->tbl_address_proof = TABLE_PREFIX . 'address_proof';
          $this->tbl_vehicle_colors = TABLE_PREFIX . 'vehicle_colors';
          $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
          $this->tbl_vehicle_booking_master = TABLE_PREFIX . 'vehicle_booking_master';
          $this->tbl_vehicle_booking_followup = TABLE_PREFIX . 'vehicle_booking_followup';
          $this->tbl_valuation_upgrade_details = TABLE_PREFIX . 'valuation_upgrade_details';
          $this->tbl_vehicle_booking_documents = TABLE_PREFIX . 'vehicle_booking_documents';
          $this->tbl_vehicle_booking_rfi_history = TABLE_PREFIX . 'vehicle_booking_rfi_history';
          $this->tbl_vehicle_booking_accessories = TABLE_PREFIX . 'vehicle_booking_accessories';
          $this->tbl_vehicle_booking_refurbishment = TABLE_PREFIX . 'vehicle_booking_refurbishment';
          $this->tbl_vehicle_booking_confirmations = TABLE_PREFIX . 'vehicle_booking_confirmations';
     }

     function getCompany()
     {
          return $this->db->select(
               array('cmp_name', 'cmp_finance_year_code', 'div_id')
          )->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_company . '.cmp_division', 'LEFT')
               ->get($this->tbl_company)->result_array();
     }

     function salesExecutives()
     {
          if (check_permission('emp_details', 'showinnactivestaffs')) {
               $this->db->where($this->tbl_users . '.usr_active = 1 OR ' . $this->tbl_users . '.usr_active = 0');
          } else {
               $this->db->where($this->tbl_users . '.usr_active = 1');
          }
          if (check_permission('booking', 'mydivisionbking')) {
               $this->db->where($this->tbl_users . '.usr_division', $this->div);
          }
          if ($this->usr_grp == 'TL') {
               return  $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id', 'LEFT')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id', 'LEFT')
                    ->where(array($this->tbl_users . '.usr_can_auto_assign' => 1))
                    ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
          } else {
               return $this->db->select($this->tbl_users . '.*,' . $this->tbl_users_groups . '.*,' . $this->tbl_groups . '.*')
                    ->join($this->tbl_users_groups, $this->tbl_users_groups . '.user_id = ' . $this->tbl_users . '.usr_id')
                    ->join($this->tbl_groups, $this->tbl_groups . '.id = ' . $this->tbl_users_groups . '.group_id')
                    ->where(array($this->tbl_users . '.usr_can_auto_assign' => 1))
                    ->order_by($this->tbl_users . '.usr_first_name', 'ASC')->get($this->tbl_users)->result_array();
          }
     }

     function showroom()
     {
          return $this->db->select('shr_id, shr_location, div_name')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'LEFT')
               ->order_by('shr_location')->where('(shr_division = 1 OR shr_division = 2)')->get($this->tbl_showroom)->result_array();
     }

     function getDistricts()
     {
          return $this->db->order_by('std_district_name', 'ASC')->get($this->tbl_district_statewise)->result_array();
     }

     function permenentdeletebooking($id)
     {
          $this->db->where('vbk_id', $id)->delete($this->tbl_vehicle_booking_master);
          $this->db->where('vbd_master_id', $id)->delete($this->tbl_vehicle_booking_documents);
          $this->db->where('vba_master_id', $id)->delete($this->tbl_vehicle_booking_accessories);
          $this->db->where('vbr_master_id', $id)->delete($this->tbl_vehicle_booking_refurbishment);
          $this->db->where('vbc_book_master', $id)->delete($this->tbl_vehicle_booking_confirmations);
          $this->db->where('vbf_book_master', $id)->delete($this->tbl_vehicle_booking_followup);
          $this->db->where('vbr_master_id', $id)->delete($this->tbl_vehicle_booking_refurbishment);
          $this->db->where('vnh_booking_master', $id)->delete($this->tbl_vehicle_booking_rfi_history);
          //$this->db->query('UPDATE `' . $this->tbl_valuation . '` SET val_status = vehicle_evaluated, val_booking_status = 0 WHERE `val_status` = 13');
          //$this->db->query('UPDATE ' . $this->tbl_enquiry . ' SET enq_current_status = 1 WHERE enq_current_status = 13');
          //$this->db->query('DELETE FROM ' . $this->tbl_enquiry_history . ' WHERE cpnl_enquiry_history.enh_status IN(13,27)');
          return true;
     }

     function getAllBookings($filter = '')
     {
          if (check_permission('booking', 'showall')) {
          } else if (check_permission('booking', 'mybking')) {
               $this->db->where('vbk_added_by', $this->uid);
          } else if (check_permission('booking', 'mystaffbking')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          } else if (check_permission('booking', 'myshowroombking')) {
               $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $this->shrm);
          } else if (check_permission('booking', 'mydivisionbking')) {
               $this->db->where($this->tbl_divisions . '.div_id', $this->div);
          }

          if (isset($filter['status']) && !empty($filter['status'])) {
               $this->db->where_in($this->tbl_vehicle_booking_master . '.vbk_status', $filter['status']);
          } else {
               if ($this->uid != 100 && check_permission('booking', 'showonlyconfmbooking')) {
                    $this->db->where($this->tbl_vehicle_booking_master . '.vbk_status', confm_book);
               }
               if (check_permission('booking', 'showbookinganddeliverd')) {
                    $this->db->where('(' . $this->tbl_vehicle_booking_master . '.vbk_status = ' . confm_book . ' OR ' .
                         $this->tbl_vehicle_booking_master . '.vbk_status = ' . book_delvry . ')');
               }
          }
          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_number',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_on',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
               'salesstaff.usr_first_name AS salesstaff_first_name', 'salesstaff.usr_last_name AS salesstaff_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des',
               'rfi_rc_sts.sts_title AS rfi_rc_sts_title',
               'rfi_in_sts.sts_title AS rfi_in_sts_title',
               $this->tbl_divisions . '.div_name',
               $this->tbl_showroom . '.shr_location'
          );

          if (isset($filter['vbk_added_on_from']) && !empty($filter['vbk_added_on_from'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_from']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) >=', $date);
               $this->db->order_by($this->tbl_vehicle_booking_master . '.vbk_added_on', 'DESC');
          }
          if (isset($filter['vbk_added_on_to']) && !empty($filter['vbk_added_on_to'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_to']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) <=', $date);
          }

          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_users . ' salesstaff', 'salesstaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts', 'LEFT') //  AND vbk_rfi_rc_trans_sts > 0
               ->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts', 'LEFT') //  AND vbk_ins_trans_sts > 0
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->where_in($this->tbl_statuses . '.sts_value', array(vehicle_booked, confm_book, rfi_loan_approved, dc_ready_to_del, book_delvry))
               ->get($this->tbl_vehicle_booking_master)->result_array();
          return $bookedVehicle;
     }

     function getActiveAddressProof($cat = 0)
     {
          if ($cat > 0) {
               $this->db->where('adp_category', $cat);
          }
          $this->db->or_where('adp_category', 0);
          return $this->db->order_by('adp_proof_title')->get_where($this->tbl_address_proof, array('adp_status' => 1))->result_array();
     }

     function uploadDocuments($docs)
     {
          $this->db->insert($this->tbl_vehicle_booking_documents, $docs);
     }

     function reserveVehicle($data)
     {
          error_reporting(1);
          generate_log(array(
               'log_title' => 'Vehicle reserved',
               'log_desc' => serialize($data),
               'log_controller' => 'vehicle-reserved',
               'log_action' => 'C',
               'log_ref_id' => $data['bm']['vbk_enq_id'],
               'log_added_by' => $this->uid
          ));

          $enqId = isset($data['bm']['vbk_enq_id']) ? $data['bm']['vbk_enq_id'] : '';
          $data['bm']['vbk_fin_year_code'] = (isset($data['bm']['vbk_fin_year_code']) && !empty($data['bm']['vbk_fin_year_code'])) ? $data['bm']['vbk_fin_year_code'] : 0;
          $vehId = isset($data['bm']['vbk_evaluation_veh_id']) ? $data['bm']['vbk_evaluation_veh_id'] : '';
          $enqDetails = $this->db->get_where($this->tbl_enquiry, array('enq_id' => $enqId))->row_array();
          $salesStaff = isset($enqDetails['enq_se_id']) ? $enqDetails['enq_se_id'] : 0;
          $userDetails = $this->db->select('usr_first_name, usr_last_name')->get_where($this->tbl_users, array('usr_id' => $salesStaff))->row_array();
          $salesStaffName = isset($userDetails['usr_first_name']) ? $userDetails['usr_first_name'] : '';
          $salesStaffName = isset($userDetails['usr_last_name']) ? $salesStaffName . ' ' . $userDetails['usr_last_name'] : '';

          $showroom = $this->common_model->getShowroomDetails($this->shrm);

          if (!empty($showroom)) {
               $division = $this->common_model->getDivisionDetails($showroom['shr_division']);
               $shrCode = $showroom['shr_code'];
               $divCode = isset($division['div_code']) ? $division['div_code'] : '';
               $reserNo = $divCode . '-' . $shrCode . '-' . date('Y') . '-' . (time() + rand(0, 9999));

               $data['bm']['vbk_expect_delivery'] = !empty($data['bm']['vbk_expect_delivery']) ?
                    date('Y-m-d H:i:s', strtotime($data['bm']['vbk_expect_delivery'])) : '';
               $data['bm']['vbk_ref_no'] = $reserNo;
               $data['bm']['vbk_added_on'] = date('Y-m-d H:i:s');
               $data['bm']['vbk_added_by'] = $this->uid;
               $data['bm']['vbk_status'] = vehicle_booked; //TODO set status
               $data['bm']['vbk_showroom'] = $this->shrm;
               $data['bm']['vbk_sales_staff'] = $salesStaff;
               $data['bm']['vbk_dob'] = !empty($data['bm']['vbk_dob']) ? date('Y-m-d', strtotime($data['bm']['vbk_dob'])) : '';
               $data['bm']['vbk_chk_date'] = !empty($data['bm']['vbk_chk_date']) ? date('Y-m-d', strtotime($data['bm']['vbk_chk_date'])) : '';

               $this->db->insert($this->tbl_vehicle_booking_master, array_filter($data['bm']));
               $bmId = $this->db->insert_id();

               /* Accessories */
               if (isset($data['ac']) && !empty($data['ac'])) {
                    $count = isset($data['ac']['vba_accessories_desc']) ? count($data['ac']['vba_accessories_desc']) : 0;
                    if ($count > 0) {
                         for ($i = 0; $i < $count; $i++) {

                              $insData['vba_master_id'] = $bmId;
                              $insData['vba_accessories_desc'] = isset($data['ac']['vba_accessories_desc'][$i]) ? $data['ac']['vba_accessories_desc'][$i] : '';
                              $insData['vba_accessories_amt'] = isset($data['ac']['vba_accessories_amt'][$i]) ? $data['ac']['vba_accessories_amt'][$i] : 0;
                              $insData['vba_don_by'] = isset($data['ac']['vba_don_by'][$i]) ? $data['ac']['vba_don_by'][$i] : 0;
                              if (!empty($insData['vba_accessories_desc']) && !empty($insData['vba_accessories_amt'])) {
                                   $this->db->insert($this->tbl_vehicle_booking_accessories, array_filter($insData));
                              }
                         }
                    }
               }

               /* Refurbish */
               if (isset($data['rf']) && !empty($data['rf'])) {
                    $count = isset($data['rf']['vbr_refurb_desc']) ? count($data['rf']['vbr_refurb_desc']) : 0;
                    $insData = array();
                    if ($count > 0) {
                         for ($i = 0; $i < $count; $i++) {
                              $insData['vbr_master_id'] = $bmId;
                              $insData['vbr_refurb_desc'] = isset($data['rf']['vbr_refurb_desc'][$i]) ? $data['rf']['vbr_refurb_desc'][$i] : '';
                              $insData['vbr_refurb_amt'] = isset($data['rf']['vbr_refurb_amt'][$i]) ? $data['rf']['vbr_refurb_amt'][$i] : 0;
                              $insData['vbr_don_by'] = isset($data['rf']['vbr_don_by'][$i]) ? $data['rf']['vbr_don_by'][$i] : 0;
                              if (!empty($insData['vbr_refurb_desc']) && !empty($insData['vbr_refurb_amt'])) {
                                   $this->db->insert($this->tbl_vehicle_booking_refurbishment, array_filter($insData));
                              }
                         }
                    }
               }

               $history['enh_enq_id'] = $enqId;
               $history['enh_current_sales_executive'] = $this->uid;
               $history['enh_booked_vehicle'] = $vehId;
               $history['enh_status'] = vehicle_booked;
               $history['enh_remarks'] = $salesStaffName . ' take booking for ' . $data['add_info'];
               $history['enh_added_by'] = $this->uid;
               $history['enh_added_on'] = date('Y-m-d H:i:s');
               $history['enh_source'] = 2; // Related to reservation
               $this->db->insert($this->tbl_enquiry_history, $history);
               $hisId = $this->db->insert_id();

               /* Change inquiry */
               $this->db->where('enq_id', $enqId)->update(
                    $this->tbl_enquiry,
                    array(
                         'enq_current_status' => vehicle_booked,
                         'enq_current_status_history' => $hisId
                    )
               );

               /* Change vehicle status */
               $this->db->where('val_id', $vehId)->update(
                    $this->tbl_valuation,
                    array(
                         'val_status' => vehicle_booked
                    )
               );

               /* Add followup comment */
               $follCmd['foll_remarks'] = $salesStaffName . ' take booking for ' . $data['add_info'];
               $follCmd['foll_cus_id'] = $enqId;
               $follCmd['foll_parent'] = 0;
               $follCmd['foll_cus_vehicle_id'] = 0;
               $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
               $follCmd['foll_customer_feedback'] = '';
               $follCmd['foll_can_show_all'] = 1;
               $follCmd['foll_contact'] = 0;
               $follCmd['foll_action_plan'] = '';
               $follCmd['foll_added_by'] = $this->uid;
               $follCmd['foll_updated_by'] = $this->uid;
               $follCmd['foll_is_dar_submited'] = 0;
               $follCmd['foll_is_cmnt'] = 1;
               $this->db->insert($this->tbl_followup, $follCmd);
               $follCmdId = $this->db->insert_id();

               generate_log(array(
                    'log_title' => 'Followup comment',
                    'log_desc' => serialize($data),
                    'log_controller' => 'followup-comment-booking',
                    'log_action' => 'C',
                    'log_ref_id' => $follCmdId,
                    'log_added_by' => get_logged_user('usr_id')
               ));
               /* Add followup comment */
               /* Reservation SMS */
               $custName = isset($data['bm']['vbk_cust_name']) ? $data['bm']['vbk_cust_name'] : '';
               $custPhon = isset($data['bm']['vbk_rc_trans_phone']) ? $data['bm']['vbk_rc_trans_phone'] : '';

               $selArray = array(
                    $this->tbl_brand . '.brd_title',
                    $this->tbl_model . '.mod_title',
                    $this->tbl_variant . '.var_variant_name',
               );
               $vehicle = $this->db->select($selArray)
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->where('val_id', $vehId)->get($this->tbl_valuation)->row_array();

               $vehicleName = '';
               if (!empty($vehicle)) {
                    $vehicleName = implode(', ', array_filter($vehicle));
                    $showroom = isset($showroom['shr_location']) ? $showroom['shr_location'] : '';
                    $mymsg = "Dear " . $custName . ", Congratulation on " . $vehicleName . " booking @Royal Drive " . $showroom . " - Royal Drive South India's Largest Pre-Owned Luxury Car Showroom";
                    //send_sms($mymsg, $custPhon , 'new product launch to customer', '1607100000000042909');
               }
               return $bmId;
          }
     }

     function getBookedVehicle($bookid = 0, $stsId = 0)
     {
          $this->db->query('SET SQL_BIG_SELECTS=1');
          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name', 'bkdby.usr_username AS bkdby_username',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_minif_year',
               $this->tbl_valuation . '.val_engine_no',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_valuation . '.val_km',
               $this->tbl_valuation . '.val_no_of_owner',
               $this->tbl_valuation . '.val_insurance_company',
               $this->tbl_valuation . '.val_insurance_comp_date',
               $this->tbl_valuation . '.val_insurance_comp_idv',
               $this->tbl_valuation . '.val_insurance_ll_idv',
               $this->tbl_valuation . '.val_insurance_ll_date',
               $this->tbl_valuation . '.val_insurance',
               $this->tbl_valuation . '.val_insurance_need_ncb',
               $this->tbl_valuation . '.val_stock_num',
               $this->tbl_valuation . '.val_model_year',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_brand . '.brd_category',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_banks . '.*',
               $this->tbl_vehicle_colors . '.vc_color AS val_color',
               $this->tbl_district_statewise . '.std_district_name',
               $this->tbl_states . '.sts_name',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_divisions . '.div_id'
          );

          if ($bookid > 0) {
               $bookedVehicle = $this->db->select($selectArray, false)
                    ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'LEFT')
                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_banks, $this->tbl_banks . '.bnk_id = ' . $this->tbl_vehicle_booking_master . '.vbk_fin_bank_name', 'LEFT')
                    ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_valuation . '.val_color', 'left')
                    ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
                    ->join($this->tbl_states, $this->tbl_states . '.sts_id = ' . $this->tbl_district_statewise . '.std_state', 'left')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
                    ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'LEFT')
                    ->where($this->tbl_vehicle_booking_master . '.vbk_id', $bookid)->get($this->tbl_vehicle_booking_master)->row_array();

               $bookedVehicle['addressProof'] = $this->db->select($this->tbl_vehicle_booking_documents . '.*, ' . $this->tbl_address_proof . '.*')
                    ->join($this->tbl_address_proof, $this->tbl_vehicle_booking_documents . '.vbd_doc_type = ' . $this->tbl_address_proof . '.adp_id', 'LEFT')
                    ->where(array($this->tbl_vehicle_booking_documents . '.vbd_master_id' => $bookid, 'vbd_status' => 1))
                    ->get($this->tbl_vehicle_booking_documents)->result_array();

               $bookedVehicle['refurb'] = $this->db->select($this->tbl_vehicle_booking_refurbishment . '.*, ' .
                    'user_verify_by.usr_first_name AS uvb_first_name, user_verify_by.usr_last_name AS uvb_last_name,' .
                    'user_completed_by.usr_first_name AS ucb_first_name, user_completed_by.usr_last_name AS ucb_last_name')
                    ->join($this->tbl_users . ' user_verify_by', 'user_verify_by.usr_id = ' . $this->tbl_vehicle_booking_refurbishment . '.vbr_verify_by', 'LEFT')
                    ->join($this->tbl_users . ' user_completed_by', 'user_completed_by.usr_id = ' . $this->tbl_vehicle_booking_refurbishment . '.vbr_completed_by', 'LEFT')
                    ->get_where($this->tbl_vehicle_booking_refurbishment, array('vbr_master_id' => $bookid))->result_array();

               $bookedVehicle['access'] = $this->db->select($this->tbl_vehicle_booking_accessories . '.*, ' .
                    'user_verify_by.usr_first_name AS uvb_first_name, user_verify_by.usr_last_name AS uvb_last_name,' .
                    'user_completed_by.usr_first_name AS ucb_first_name, user_completed_by.usr_last_name AS ucb_last_name')
                    ->join($this->tbl_users . ' user_verify_by', 'user_verify_by.usr_id = ' . $this->tbl_vehicle_booking_accessories . '.vba_verify_by', 'LEFT')
                    ->join($this->tbl_users . ' user_completed_by', 'user_completed_by.usr_id = ' . $this->tbl_vehicle_booking_accessories . '.vba_completed_by', 'LEFT')
                    ->get_where($this->tbl_vehicle_booking_accessories, array('vba_master_id' => $bookid))->result_array();

               $hisArray = array(
                    $this->tbl_enquiry_history . '.*',
                    'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
                    'addby.usr_first_name AS addby_first_name', 'addby.usr_last_name AS addby_last_name',
                    'addby.usr_avatar AS addby_usr_avatar'
               );
               $bookedVehicle['histry'] = $this->db->select($hisArray)
                    ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_enquiry_history . '.enh_current_sales_executive', 'LEFT')
                    ->join($this->tbl_users . ' addby', 'addby.usr_id = ' . $this->tbl_enquiry_history . '.enh_added_by', 'LEFT')
                    ->order_by('enh_id', 'DESC')->get_where(
                         $this->tbl_enquiry_history,
                         array('enh_enq_id' => $bookedVehicle['vbk_enq_id'], 'enh_source' => 2)
                    )->result_array();

               $bookedVehicle['valuationRefurbDetails'] = $this->db->get_where(
                    $this->tbl_valuation_upgrade_details,
                    array('upgrd_master_id' => $bookedVehicle['vbk_evaluation_veh_id'])
               )->result_array();
               return $bookedVehicle;
          } else {

               if (check_permission('booking', 'showall')) {
               } else if (check_permission('booking', 'mybking')) {
                    $this->db->where('enq_se_id', $this->uid);
               } else if (check_permission('booking', 'mystaffbking')) {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                         ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               } else if (check_permission('booking', 'myshowroombking')) {
                    $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
               }

               $selectArray = array(
                    $this->tbl_vehicle_booking_master . '.*',
                    $this->tbl_vehicle_booking_confirmations . '.*',
                    $this->tbl_enquiry . '.enq_id',
                    $this->tbl_enquiry . '.enq_cus_name',
                    $this->tbl_enquiry . '.enq_cus_mobile',
                    $this->tbl_enquiry . '.enq_se_id',
                    'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
                    'salesstaff.usr_first_name AS salesstaff_first_name', 'salesstaff.usr_last_name AS salesstaff_last_name',
                    $this->tbl_valuation . '.val_veh_no',
                    $this->tbl_model . '.mod_title',
                    $this->tbl_model . '.mod_id',
                    $this->tbl_brand . '.brd_title',
                    $this->tbl_variant . '.var_id',
                    $this->tbl_variant . '.var_variant_name',
                    $this->tbl_statuses . '.sts_title',
                    $this->tbl_statuses . '.sts_des',
                    $this->tbl_statuses . '.sts_access',
                    'rfi_rc_sts.sts_title AS rfi_rc_sts_title',
                    'rfi_in_sts.sts_title AS rfi_in_sts_title',
                    'rfi_sts.sts_title AS rfi_sts_title',
                    $this->tbl_banks . '.*'
               );
               if ($stsId > 0) {
                    $this->db->where($this->tbl_vehicle_booking_master . '.vbk_status', $stsId);
               }
               $bookedVehicle = $this->db->select($selectArray, false)
                    ->join($this->tbl_vehicle_booking_confirmations, $this->tbl_vehicle_booking_confirmations . '.vbc_book_master = ' . $this->tbl_vehicle_booking_master . '.vbk_id AND ' . $this->tbl_vehicle_booking_confirmations . '.vbc_verify_by = ' . $this->uid, 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
                    ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
                    ->join($this->tbl_users . ' salesstaff', 'salesstaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
                    ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts AND vbk_rfi_rc_trans_sts > 0', 'LEFT')
                    ->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts AND vbk_ins_trans_sts > 0', 'LEFT')
                    ->join($this->tbl_statuses . ' rfi_sts', 'rfi_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_status', 'LEFT')
                    ->join($this->tbl_banks, $this->tbl_banks . '.bnk_id = ' . $this->tbl_vehicle_booking_master . '.vbk_fin_bank_name', 'LEFT')
                    ->where_in($this->tbl_statuses . '.sts_value', array(vehicle_booked, confm_book, rfi_loan_approved, dc_ready_to_del))
                    ->get($this->tbl_vehicle_booking_master)->result_array();
               //echo $this->db->last_query();
               //debug($bookedVehicle);
               return $bookedVehicle;
          }
     }

     function getDeliverdVehicle($bookid = 0, $stsId = 0, $filter = '')
     {
          $this->db->query('SET SQL_BIG_SELECTS=1');
          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_minif_year',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_valuation . '.val_km',
               $this->tbl_valuation . '.val_no_of_owner',
               $this->tbl_valuation . '.val_insurance_company',
               $this->tbl_valuation . '.val_insurance_comp_date',
               $this->tbl_valuation . '.val_insurance_comp_idv',
               $this->tbl_valuation . '.val_insurance_ll_idv',
               $this->tbl_valuation . '.val_insurance_ll_date',
               $this->tbl_valuation . '.val_insurance',
               $this->tbl_valuation . '.val_insurance_need_ncb',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_banks . '.*',
               $this->tbl_showroom . '.shr_location'
          );
          if ($this->uid != 100) {
               if (check_permission('booking', 'showall')) {
               } else if (check_permission('booking', 'mybking')) {
                    $this->db->where('enq_se_id', $this->uid);
               } else if (check_permission('booking', 'mystaffbking')) {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               } else if (check_permission('booking', 'myshowroombking')) {
                    $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
               }
               if (check_permission('booking', 'shownorthregion')) {
                    $this->db->where($this->tbl_showroom . '.shr_region', 1);
               } else if (check_permission('booking', 'showsouthregion')) {
                    $this->db->where($this->tbl_showroom . '.shr_region', 2);
               }
          }
          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_vehicle_booking_confirmations . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_on',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
               'salesstaff.usr_first_name AS salesstaff_first_name', 'salesstaff.usr_last_name AS salesstaff_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des',
               $this->tbl_statuses . '.sts_access',
               'rfi_rc_sts.sts_title AS rfi_rc_sts_title',
               'rfi_in_sts.sts_title AS rfi_in_sts_title',
               'rfi_sts.sts_title AS rfi_sts_title',
               $this->tbl_banks . '.*',
               $this->tbl_showroom . '.shr_location'
          );
          if ($stsId > 0) {
               $this->db->where($this->tbl_vehicle_booking_master . '.vbk_status', $stsId);
          }
          if (isset($filter['vbk_delivery_date_from']) && !empty($filter['vbk_delivery_date_from'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_delivery_date_from']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_delivery_date) >=', $date);
          }
          if (isset($filter['vbk_delivery_date_to']) && !empty($filter['vbk_delivery_date_to'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_delivery_date_to']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_delivery_date) <=', $date);
          }
          if (isset($filter['executive']) && !empty($filter['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $filter['executive']);
          }
          if (isset($filter['dist']) && !empty($filter['dist'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_cus_dist', $filter['dist']);
          }
          if (isset($filter['div']) && !empty($filter['div'])) {
               if ($filter['div'] == 1) {
                    $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', 1);
               } else if ($filter['div'] == 2) {
                    $this->db->where('(' . $this->tbl_vehicle_booking_master . '.vbk_showroom = 2 OR ' . $this->tbl_vehicle_booking_master . '.vbk_showroom = 4)');
               }
          }
          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_vehicle_booking_confirmations, $this->tbl_vehicle_booking_confirmations . '.vbc_book_master = ' . $this->tbl_vehicle_booking_master . '.vbk_id AND ' . $this->tbl_vehicle_booking_confirmations . '.vbc_verify_by = ' . $this->uid, 'LEFT')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_users . ' salesstaff', 'salesstaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts AND vbk_rfi_rc_trans_sts > 0', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts AND vbk_ins_trans_sts > 0', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_sts', 'rfi_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_status', 'LEFT')
               ->join($this->tbl_banks, $this->tbl_banks . '.bnk_id = ' . $this->tbl_vehicle_booking_master . '.vbk_fin_bank_name', 'LEFT')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->get($this->tbl_vehicle_booking_master)->result_array();

          return $bookedVehicle;
     }

     function decisionmaking($data)
     {
          if (!empty($data)) {
               $usrName = $this->session->userdata('usr_username');
               $curSalesOfficer = $this->db->select('enq_se_id')->get_where(
                    $this->tbl_enquiry,
                    array('enq_id' => $data['confim']['vbc_enq_id'])
               )->row()->enq_se_id;

               $bookVehicle = $this->db->select('vbk_evaluation_veh_id')->get_where(
                    $this->tbl_vehicle_booking_master,
                    array('vbk_id' => $data['confim']['vbc_book_master'])
               )->row()->vbk_evaluation_veh_id;

               if (!isset($data['confim']['vbc_verify_by_grp_slug']) && check_permission('booking', 'bookingdetailsforrfi')) { // RFI
                    $data['bm']['vbk_rfi_in_house'] = isset($data['bm']['vbk_rfi_in_house']) ? $data['bm']['vbk_rfi_in_house'] : 0;
                    $data['bm']['vbk_rfi_dsa'] = isset($data['bm']['vbk_rfi_dsa']) ? $data['bm']['vbk_rfi_dsa'] : 0;
                    $data['bm']['vbk_rfi_cust'] = isset($data['bm']['vbk_rfi_cust']) ? $data['bm']['vbk_rfi_cust'] : 0;

                    $bankName = @$this->db->select('bnk_name')->get_where($this->tbl_banks, array('bnk_id' => $data['bm']['vbk_rfi_bank']))->row()->bnk_name;

                    $RCTransStatus = $this->common_model->getStatus($data['bm']['vbk_rfi_rc_trans_sts'], array('sts_title'))->sts_title;
                    $INSTransStatus = $this->common_model->getStatus($data['bm']['vbk_ins_trans_sts'], array('sts_title'))->sts_title;
                    $RFIStatus = $this->common_model->getStatus($data['bm']['vbk_rfi_status'], array('sts_title'))->sts_title;

                    $RCTransExpDate = !empty($data['bm']['vbk_rc_trans_exp_date']) ? explode(' ', $data['bm']['vbk_rc_trans_exp_date']) : array();
                    $INSTransExpDate = !empty($data['bm']['vbk_ins_trans_exp_date']) ? explode(' ', $data['bm']['vbk_ins_trans_exp_date']) : array();

                    $RCTransExpDate = isset($RCTransExpDate['0']) ? 'RC transfer expected : ' . $RCTransExpDate['0'] : '';
                    $INSTransExpDate = isset($INSTransExpDate['0']) ? 'Insurance transfer expected : ' . $INSTransExpDate['0'] : '';

                    /* RTO details */
                    $rto = !empty($data['bm']['vbk_rto']) ? $data['bm']['vbk_rto'] : '';
                    $rtoDetails = $this->getRTO($rto);
                    $rto = $rtoDetails['rto_reg_num'] . ' - ' . $rtoDetails['rto_place'] . ' - ' . $rtoDetails['std_district_name'];
                    /* RTO details */

                    $rtoSubAgent = !empty($data['bm']['vbk_rto_agent']) ? $data['bm']['vbk_rto_agent'] : '';

                    $rtoAgentName = !empty($data['bm']['vbk_rto_name']) ? $data['bm']['vbk_rto_name'] : '';
                    $rtoAgentPhone = !empty($data['bm']['vbk_rto_phone']) ? $data['bm']['vbk_rto_phone'] : '';
                    $rtoDesc = !empty($data['bm']['vbk_rto_desc']) ? $data['bm']['vbk_rto_desc'] : '';

                    $data['bm']['vbk_delivery_date'] = (isset($data['confim']['vbk_delivery_date']) && !empty($data['confim']['vbk_delivery_date']))
                         ? date('Y-m-d', strtotime($data['confim']['vbk_delivery_date'])) : null;

                    if ($rtoSubAgent == 1) {
                         $rtoSubAgent = 'RTO Agent';
                    }
                    if ($rtoSubAgent == 2) {
                         $rtoSubAgent = 'Bank Agent';
                    }
                    if ($rtoSubAgent == 3) {
                         $rtoSubAgent = 'Direct Customer';
                    }

                    $enqHistoryRemark = 'Loan bank : ' . $bankName . ', RC status : ' . $RCTransStatus . ', RC transfer expected date : ' . $RCTransExpDate .
                         '<br>Insurance status : ' . $INSTransStatus . ', RC transfer expected date : ' . $INSTransExpDate . '<br> Expect delivery date : ' . $data['bm']['vbk_rfi_exp_del_date']
                         . '<br> RTO : ' . $rto . ', Agent : ' . $rtoSubAgent
                         . '<br> RTO Agent Name : ' . $rtoAgentName . ', RTO Agent Phone : ' . $rtoAgentPhone
                         . '<br><br>Status : ' . $RFIStatus . '<br><br>Description : ' . $rtoDesc . '<br><br><i>' . $data['confim']['vbc_verify_desc'] . '</i>';

                    $enqHistoryRemark = !empty($data['bm']['vbk_delivery_date']) ? $enqHistoryRemark . '<br>Delivered on : ' .
                         $data['bm']['vbk_delivery_date'] : $enqHistoryRemark;

                    $data['bm']['vbk_rc_trans_exp_date'] = !empty($data['bm']['vbk_rc_trans_exp_date']) ? date('Y-m-d', strtotime($data['bm']['vbk_rc_trans_exp_date'])) : null;
                    $data['bm']['vbk_ins_trans_exp_date'] = !empty($data['bm']['vbk_ins_trans_exp_date']) ? date('Y-m-d', strtotime($data['bm']['vbk_ins_trans_exp_date'])) : null;
                    $data['bm']['vbk_rfi_exp_del_date'] = !empty($data['bm']['vbk_rfi_exp_del_date']) ? date('Y-m-d', strtotime($data['bm']['vbk_rfi_exp_del_date'])) : null;
                    $data['bm']['vbk_rfi_rc_tranfd_date'] = !empty($data['bm']['vbk_rfi_rc_tranfd_date']) ? date('Y-m-d', strtotime($data['bm']['vbk_rfi_rc_tranfd_date'])) : null;
                    $data['bm']['vbk_rfi_ins_tranfd_date'] = !empty($data['bm']['vbk_rfi_ins_tranfd_date']) ? date('Y-m-d', strtotime($data['bm']['vbk_rfi_ins_tranfd_date'])) : null;

                    $data['bm']['vbk_status'] = isset($data['status']) ? $data['status'] : 0;
                    //debug($data['bm']);
                    $this->db->where('vbk_id', $data['confim']['vbc_book_master'])->update($this->tbl_vehicle_booking_master, $data['bm']);

                    /* Enquiry history */
                    $history['enh_enq_id'] = $data['confim']['vbc_enq_id'];
                    $history['enh_current_sales_executive'] = $curSalesOfficer;
                    $history['enh_booked_vehicle'] = $bookVehicle;
                    $history['enh_status'] = $data['status'];
                    $history['enh_remarks'] = $enqHistoryRemark;
                    $history['enh_source'] = 2; // Related to reservation
                    $history['enh_added_by'] = $this->uid;
                    $history['enh_added_on'] = date('Y-m-d H:i:s');
                    $this->db->insert($this->tbl_enquiry_history, $history);
                    $hisId = $this->db->insert_id();

                    /* Change inquiry */
                    $this->db->where('enq_id', $data['confim']['vbc_enq_id'])->update(
                         $this->tbl_enquiry,
                         array(
                              'enq_current_status' => $data['status'], 'enq_current_status_history' => $hisId
                         )
                    );

                    generate_log(array(
                         'log_title' => 'Vehicle reserved',
                         'log_desc' => serialize($data),
                         'log_controller' => 'vehicle-reserved-rfi',
                         'log_action' => 'C',
                         'log_ref_id' => $data['confim']['vbc_enq_id'],
                         'log_added_by' => $this->uid
                    ));

                    //RFI History
                    $data['bm']['vbk_rfi_rc_trans_sts'] = (isset($data['bm']['vbk_rfi_rc_trans_sts']) && !empty($data['bm']['vbk_rfi_rc_trans_sts'])) ?
                         $data['bm']['vbk_rfi_rc_trans_sts'] : 0;

                    $data['bm']['vbk_ins_trans_sts'] = (isset($data['bm']['vbk_ins_trans_sts']) && !empty($data['bm']['vbk_ins_trans_sts'])) ?
                         $data['bm']['vbk_ins_trans_sts'] : 0;

                    $this->db->insert($this->tbl_vehicle_booking_rfi_history, array(
                         'vnh_booking_master' => $data['confim']['vbc_book_master'],
                         'vnh_rfi_rc_trans_sts' => $data['bm']['vbk_rfi_rc_trans_sts'],
                         'vnh_rc_trans_exp_date' => $data['bm']['vbk_rc_trans_exp_date'],
                         'vnh_ins_trans_sts' => $data['bm']['vbk_ins_trans_sts'],
                         'vnh_ins_trans_exp_date' => $data['bm']['vbk_ins_trans_exp_date'],
                         'vnh_comments' => $enqHistoryRemark,
                         'vnh_added_by' => $this->uid,
                         'vnh_added_on' => date('Y-m-d H:i:s')
                    ));

                    /* Add followup comment */
                    $follCmd['foll_remarks'] = $enqHistoryRemark;
                    $follCmd['foll_cus_id'] = $data['confim']['vbc_enq_id'];
                    $follCmd['foll_parent'] = 0;
                    $follCmd['foll_cus_vehicle_id'] = 0;
                    $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                    $follCmd['foll_customer_feedback'] = '';
                    $follCmd['foll_can_show_all'] = 1;
                    $follCmd['foll_contact'] = 0;
                    $follCmd['foll_action_plan'] = '';
                    $follCmd['foll_added_by'] = $this->uid;
                    $follCmd['foll_updated_by'] = $this->uid;
                    $follCmd['foll_is_dar_submited'] = 0;
                    $follCmd['foll_is_cmnt'] = 1;
                    $this->db->insert($this->tbl_followup, $follCmd);
                    $follCmdId = $this->db->insert_id();

                    generate_log(array(
                         'log_title' => 'Followup comment',
                         'log_desc' => serialize($data),
                         'log_controller' => 'decision-making-booking',
                         'log_action' => 'C',
                         'log_ref_id' => $follCmdId,
                         'log_added_by' => $this->uid
                    ));
                    /* Add followup comment */
               } else if (!isset($data['confim']['vbc_verify_by_grp_slug']) && check_permission('booking', 'bookingdetailsfordc')) { // DC
                    if (isset($data['verifyRefurb']) && !empty($data['verifyRefurb'])) {
                         foreach ($data['verifyRefurb'] as $rkey => $rvalue) {
                              $this->db->where('vbr_id', $rvalue)->update(
                                   $this->tbl_vehicle_booking_refurbishment,
                                   array('vbr_completed_on' => date('Y-m-d H:i:s'), 'vbr_completed_by' => $this->uid)
                              );
                         }
                    }

                    if (isset($data['verifyAccess']) && !empty($data['verifyAccess'])) {
                         foreach ($data['verifyAccess'] as $akey => $avalue) {
                              $this->db->where('vba_id', $avalue)->update(
                                   $this->tbl_vehicle_booking_accessories,
                                   array('vba_completed_on' => date('Y-m-d H:i:s'), 'vba_completed_by' => $this->uid)
                              );
                         }
                    }

                    if (isset($data['evalUpgrade']) && !empty($data['evalUpgrade'])) {
                         foreach ($data['evalUpgrade'] as $ekey => $evalue) {
                              if (!empty(trim($evalue['evalUpgdDesc']))) {
                                   $this->db->where('upgrd_id', $evalue['evalUpgdId'])->update(
                                        $this->tbl_valuation_upgrade_details,
                                        array('upgrd_resn_pend_refurb' => $evalue['evalUpgdDesc'])
                                   );
                              }
                         }
                    }

                    $enqId = isset($data['confim']['vbc_enq_id']) ? $data['confim']['vbc_enq_id'] : 0;

                    if (isset($data['status']) && !empty($data['status'])) {
                         $enqCurrentStatus = $data['status'];
                         $this->db->where('vbk_id', $data['confim']['vbc_book_master'])
                              ->update($this->tbl_vehicle_booking_master, array('vbk_status' => $enqCurrentStatus));
                    } else {
                         $enqCurrentStatus = $this->db->select('enq_cus_status')->get_where(
                              $this->tbl_enquiry,
                              array('enq_id' => $enqId)
                         )->row()->enq_cus_status;
                    }

                    $enqHistoryRemark = isset($data['confim']['vbc_verify_desc']) ? $data['confim']['vbc_verify_desc'] : '';

                    if (isset($data['vbk_dc_exp_del_date']) && !empty($data['vbk_dc_exp_del_date'])) {
                         $dcexpdelDate = isset($data['vbk_dc_exp_del_date']) ? date('Y-m-d H:i:s', strtotime($data['vbk_dc_exp_del_date'])) : '';
                         $dcexpdelDesc = isset($data['exp_del_desc']) ? $data['exp_del_desc'] : '';

                         $this->db->where('vbk_id', $data['confim']['vbc_book_master'])->update(
                              $this->tbl_vehicle_booking_master,
                              array('vbk_dc_exp_del_date' => $dcexpdelDate, 'vbk_dc_exp_del_desc' => $dcexpdelDesc)
                         );

                         $enqHistoryRemark = $dcexpdelDesc . ', expect delivery date : ' . $data['vbk_dc_exp_del_date'];
                    }

                    /* Enquiry history */
                    $history['enh_enq_id'] = $data['confim']['vbc_enq_id'];
                    $history['enh_current_sales_executive'] = $curSalesOfficer;
                    $history['enh_booked_vehicle'] = $bookVehicle;
                    $history['enh_status'] = $enqCurrentStatus;
                    $history['enh_remarks'] = $enqHistoryRemark;
                    $history['enh_source'] = 2; // Related to reservation
                    $history['enh_added_by'] = $this->uid;
                    $history['enh_added_on'] = date('Y-m-d H:i:s');
                    $this->db->insert($this->tbl_enquiry_history, $history);
                    $hisId = $this->db->insert_id();

                    /* Change inquiry */
                    $this->db->where('enq_id', $data['confim']['vbc_enq_id'])->update(
                         $this->tbl_enquiry,
                         array(
                              'enq_current_status' => $enqCurrentStatus, 'enq_current_status_history' => $hisId
                         )
                    );

                    generate_log(array(
                         'log_title' => 'Vehicle reserved',
                         'log_desc' => serialize($data),
                         'log_controller' => 'vehicle-reserved-dc',
                         'log_action' => 'C',
                         'log_ref_id' => $data['confim']['vbc_enq_id'],
                         'log_added_by' => $this->uid
                    ));

                    //RFI History

                    /* Add followup comment */
                    $follCmd['foll_remarks'] = $enqHistoryRemark;
                    $follCmd['foll_cus_id'] = $data['confim']['vbc_enq_id'];
                    $follCmd['foll_parent'] = 0;
                    $follCmd['foll_cus_vehicle_id'] = 0;
                    $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                    $follCmd['foll_customer_feedback'] = '';
                    $follCmd['foll_can_show_all'] = 1;
                    $follCmd['foll_contact'] = 0;
                    $follCmd['foll_action_plan'] = '';
                    $follCmd['foll_added_by'] = $this->uid;
                    $follCmd['foll_updated_by'] = $this->uid;
                    $follCmd['foll_is_dar_submited'] = 0;
                    $follCmd['foll_is_cmnt'] = 1;
                    $this->db->insert($this->tbl_followup, $follCmd);
                    $follCmdId = $this->db->insert_id();

                    generate_log(array(
                         'log_title' => 'Followup comment',
                         'log_desc' => serialize($data),
                         'log_controller' => 'decision-making-booking',
                         'log_action' => 'C',
                         'log_ref_id' => $follCmdId,
                         'log_added_by' => $this->uid
                    ));
                    /* Add followup comment */
               } else {
                    // echo 'sssss';
                    // debug($data);
                    // echo $data['status'];
                    // exit;
                    $enqHistoryRemark = '';
                    generate_log(array(
                         'log_title' => 'Vehicle reserved',
                         'log_desc' => serialize($data),
                         'log_controller' => 'vehicle-reserved',
                         'log_action' => 'C',
                         'log_ref_id' => $data['confim']['vbc_enq_id'],
                         'log_added_by' => $this->uid
                    ));

                    $enqHistoryRemark = isset($data['confim']['vbc_verify_desc']) ? $data['confim']['vbc_verify_desc'] : '';
                    if (isset($data['status']) && $data['status'] == confm_book) {
                         //Update last confirm

                         if (isset($data['vbk_advance_amt']) && ((int) $data['vbk_advance_amt'] > 0)) {
                              $updateMstr['vbk_advance_amt'] = $data['vbk_advance_amt'];
                         }
                         if (isset($data['vbk_vehicle_amt']) && ((int) $data['vbk_vehicle_amt'] > 0)) {
                              $updateMstr['vbk_vehicle_amt'] = $data['vbk_vehicle_amt'];
                         }
                         $updateMstr['vbk_last_verified_by'] = $this->uid;
                         $updateMstr['vbk_last_verified_on'] = date('Y-m-d H:i:s');

                         $this->db->where('vbk_id', $data['confim']['vbc_book_master'])->update($this->tbl_vehicle_booking_master, $updateMstr);

                         //New booking confirmation row created.
                         $data['confim']['vbc_verify_on'] = date('Y-m-d H:i:s');
                         $this->db->insert($this->tbl_vehicle_booking_confirmations, $data['confim']);

                         $enqHistoryRemark = $usrName . ' confirm the booking. <br>' . $data['confim']['vbc_verify_desc'];
                    } else if (isset($data['status']) && $data['status'] == reject_book) {
                         $enqHistoryRemark = $usrName . ' rejected the booking. <br>' . $data['confim']['vbc_verify_desc'];
                    } else if (isset($data['status']) && $data['status'] == cancl_book) {
                         $enqHistoryRemark = $usrName . ' cancelled the booking. <br>' . $data['confim']['vbc_verify_desc'];
                    } else if (isset($data['status']) && $data['status'] == book_delvry) {

                         $vbk_delivery_date = (isset($data['confim']['vbk_delivery_date']) && !empty($data['confim']['vbk_delivery_date']))
                              ? date('Y-m-d', strtotime($data['confim']['vbk_delivery_date'])) : null;

                         $this->db->where('vbk_id', $data['confim']['vbc_book_master'])->update($this->tbl_vehicle_booking_master, array('vbk_delivery_date' => $vbk_delivery_date));

                         $enqHistoryRemark = $usrName . ' has been delivered the booked vehicle. <br>' . $data['confim']['vbc_verify_desc'];
                    } else if (isset($data['bm']['vbk_rfi_status']) && ($data['bm']['vbk_rfi_status'] == rfi_loan_approved)) {
                         $enqHistoryRemark = 'File approved . <br>' . $data['confim']['vbc_verify_desc'];
                    }

                    //Get last enquiry status
                    $currentId = $this->db->select('enq_current_status')->get_where(
                         $this->tbl_enquiry,
                         array('enq_id' => $data['confim']['vbc_enq_id'])
                    )->row()->enq_current_status;

                    $data['status'] = (isset($data['status']) && !empty($data['status'])) ? $data['status'] : $currentId;
                    if (isset($data['status']) && !empty($data['status'])) {
                         $newSts = ($data['status'] == cancl_book) ? 1 : $data['status'];
                         $newStockSts = ($data['status'] == cancl_book) ? add_stock : $data['status'];

                         /* Enquiry history */
                         $history['enh_enq_id'] = $data['confim']['vbc_enq_id'];
                         $history['enh_current_sales_executive'] = $curSalesOfficer;
                         $history['enh_booked_vehicle'] = $bookVehicle;
                         $history['enh_status'] = $newSts;
                         $history['enh_remarks'] = $enqHistoryRemark;
                         $history['enh_source'] = 2; // Related to reservation
                         $history['enh_added_by'] = $this->uid;
                         $history['enh_added_on'] = date('Y-m-d H:i:s');
                         $this->db->insert($this->tbl_enquiry_history, $history);
                         $hisId = $this->db->insert_id();

                         /* Change inquiry */
                         $this->db->where('enq_id', $data['confim']['vbc_enq_id'])->update(
                              $this->tbl_enquiry,
                              array(
                                   'enq_current_status' => $newSts, 'enq_current_status_history' => $hisId
                              )
                         );

                         /* Change vehicle status */
                         $this->db->where('val_id', $bookVehicle)->update($this->tbl_valuation, array('val_status' => $newStockSts, 'val_booking_status' => 0));

                         /* Update booking status */
                         $this->db->where('vbk_id', $data['confim']['vbc_book_master'])
                              ->update($this->tbl_vehicle_booking_master, array('vbk_status' => $data['status']));
                    }

                    /* verify Refurb */
                    if (!empty($data['verifyRefurb'])) {
                         foreach ($data['verifyRefurb'] as $key => $value) {
                              $this->db->where('vbr_id', $key)->update($this->tbl_vehicle_booking_refurbishment, array('vbr_verify_by' => $this->uid));
                         }
                    }

                    /* verify Access */
                    if (!empty($data['verifyAccess'])) {
                         foreach ($data['verifyAccess'] as $key => $value) {
                              $this->db->where('vba_id', $key)->update($this->tbl_vehicle_booking_accessories, array('vba_verify_by' => $this->uid));
                         }
                    }

                    /* Add followup comment */
                    $follCmd['foll_remarks'] = $enqHistoryRemark;
                    $follCmd['foll_cus_id'] = $data['confim']['vbc_enq_id'];
                    $follCmd['foll_parent'] = 0;
                    $follCmd['foll_cus_vehicle_id'] = 0;
                    $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                    $follCmd['foll_customer_feedback'] = '';
                    $follCmd['foll_can_show_all'] = 1;
                    $follCmd['foll_contact'] = 0;
                    $follCmd['foll_action_plan'] = '';
                    $follCmd['foll_added_by'] = $this->uid;
                    $follCmd['foll_updated_by'] = $this->uid;
                    $follCmd['foll_is_dar_submited'] = 0;
                    $follCmd['foll_is_cmnt'] = 1;
                    $this->db->insert($this->tbl_followup, $follCmd);
                    $follCmdId = $this->db->insert_id();

                    generate_log(array(
                         'log_title' => 'Followup comment',
                         'log_desc' => serialize($data),
                         'log_controller' => 'decision-making-booking',
                         'log_action' => 'C',
                         'log_ref_id' => $follCmdId,
                         'log_added_by' => $this->uid
                    ));
                    /* Add followup comment */
               }
               return true;
          }
     }

     function getRejectBooking()
     {
          if (check_permission('booking', 'showall')) {
          } else if (check_permission('booking', 'mybking')) {
               $this->db->where('enq_se_id', $this->uid);
          } else if (check_permission('booking', 'mystaffbking')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          } else if (check_permission('booking', 'myshowroombking')) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          }

          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des'
          );
          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               ->where($this->tbl_vehicle_booking_master . '.vbk_status', reject_book)->get($this->tbl_vehicle_booking_master)->result_array();
          return $bookedVehicle;
     }

     function getStockVehicles()
     {
          //add_stock, vehicle_evaluated, 13, 29
          $this->db->where_in($this->tbl_valuation . '.val_status', array(add_stock));
          //$this->db->where_in($this->tbl_valuation . '.val_booking_status', array(0, cancl_book, add_stock, vehicle_evaluated, 13, 29));
          $this->db->where($this->tbl_valuation . '.val_veh_no IS NOT NULL');
          $selArray = array(
               $this->tbl_valuation . '.val_id',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_model_year',
               $this->tbl_valuation . '.val_color',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_vehicle_colors . '.vc_color AS val_color'
          );
          return $this->db->select($selArray)
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_valuation . '.val_color', 'left')
               ->get($this->tbl_valuation)->result_array();
     }

     function removeDocuments($docId)
     {
          $this->db->where('vbd_id', $docId)->update($this->tbl_vehicle_booking_documents, array('vbd_status' => 99));
          return true;
     }

     function resubmitReserveVehicle($data)
     {

          if (!empty($data)) {
               $masterId = isset($data['bm']['vbk_id']) ? $data['bm']['vbk_id'] : 0;
               unset($data['bm']['vbk_id']);
               if ((isset($data['bm']) && !empty($data['bm'])) && $masterId > 0) {
                    $this->db->where('vbk_id', $masterId)->update($this->tbl_vehicle_booking_master, $data['bm']);
               }

               /* Documents */
               if (!empty($data['ap'])) {
                    $count = isset($data['ap']['vbd_doc_type']) ? count($data['ap']['vbd_doc_type']) : 0;
                    for ($i = 0; $i < $count; $i++) {
                         $pkid = isset($data['ap']['vbd_id'][$i]) ? $data['ap']['vbd_id'][$i] : 0;
                         $editArray['vbd_doc_type'] = isset($data['ap']['vbd_doc_type'][$i]) ? $data['ap']['vbd_doc_type'][$i] : 0;
                         $editArray['vbd_doc_number'] = isset($data['ap']['vbd_doc_number'][$i]) ? $data['ap']['vbd_doc_number'][$i] : 0;
                         if ($pkid > 0) { //Edit
                              $this->db->where('vbd_id', $pkid)->update($this->tbl_vehicle_booking_documents, $editArray);
                         }
                    }
               }

               /* Refurbish */
               if (!empty($data['rf'])) {
                    $editArray = array();
                    $count = isset($data['rf']['vbr_don_by']) ? count($data['rf']['vbr_don_by']) : 0;
                    for ($i = 0; $i < $count; $i++) {
                         $pkid = isset($data['rf']['vbr_id'][$i]) ? $data['rf']['vbr_id'][$i] : 0;
                         $editArray['vbr_refurb_desc'] = isset($data['rf']['vbr_refurb_desc'][$i]) ? $data['rf']['vbr_refurb_desc'][$i] : 0;
                         $editArray['vbr_refurb_amt'] = isset($data['rf']['vbr_refurb_amt'][$i]) ? $data['rf']['vbr_refurb_amt'][$i] : 0;
                         $editArray['vbr_don_by'] = isset($data['rf']['vbr_don_by'][$i]) ? $data['rf']['vbr_don_by'][$i] : 0;
                         if (!empty($editArray['vbr_refurb_desc'])) {
                              if ($pkid > 0) { //Edit
                                   $this->db->where('vbr_id', $pkid)->update($this->tbl_vehicle_booking_refurbishment, $editArray);
                              } else { //New row
                                   $editArray['vbr_master_id'] = $masterId;
                                   $this->db->insert($this->tbl_vehicle_booking_refurbishment, $editArray);
                              }
                         }
                    }
               }

               /* Accessories */
               if (!empty($data['ac'])) {
                    $editArray = array();
                    $count = isset($data['ac']['vba_don_by']) ? count($data['ac']['vba_don_by']) : 0;
                    for ($i = 0; $i < $count; $i++) {
                         $pkid = isset($data['ac']['vba_id'][$i]) ? $data['ac']['vba_id'][$i] : 0;
                         $editArray['vba_accessories_desc'] = isset($data['ac']['vba_accessories_desc'][$i]) ? $data['ac']['vba_accessories_desc'][$i] : 0;
                         $editArray['vba_accessories_amt'] = isset($data['ac']['vba_accessories_amt'][$i]) ? $data['ac']['vba_accessories_amt'][$i] : 0;
                         $editArray['vbr_don_by'] = isset($data['ac']['vba_don_by'][$i]) ? $data['ac']['vba_don_by'][$i] : 0;
                         if (!empty($editArray['vbr_refurb_desc'])) {
                              if ($pkid > 0) { //Edit
                                   $this->db->where('vba_id', $pkid)->update($this->tbl_vehicle_booking_accessories, $editArray);
                              } else { //New row
                                   $editArray['vba_master_id'] = $masterId;
                                   $this->db->insert($this->tbl_vehicle_booking_accessories, $editArray);
                              }
                         }
                    }
               }

               /* Change statuses */
               $enqId = isset($data['bm']['vbk_enq_id']) ? $data['bm']['vbk_enq_id'] : '';
               $vehId = isset($data['bm']['vbk_evaluation_veh_id']) ? $data['bm']['vbk_evaluation_veh_id'] : '';
               $cmd = 'Booked again rejected booking ,' . $data['narration'];
               $history['enh_enq_id'] = $enqId;
               $history['enh_current_sales_executive'] = $this->uid;
               $history['enh_booked_vehicle'] = $vehId;
               $history['enh_status'] = vehicle_booked;
               $history['enh_remarks'] = $cmd;
               $history['enh_added_by'] = $this->uid;
               $history['enh_added_on'] = date('Y-m-d H:i:s');
               $history['enh_source'] = 2; // Related to reservation
               $this->db->insert($this->tbl_enquiry_history, $history);
               $hisId = $this->db->insert_id();

               /* Change inquiry */
               $this->db->where('enq_id', $enqId)->update(
                    $this->tbl_enquiry,
                    array(
                         'enq_current_status' => vehicle_booked,
                         'enq_current_status_history' => $hisId
                    )
               );

               /* Change vehicle status */
               $this->db->where('val_id', $vehId)->update(
                    $this->tbl_valuation,
                    array(
                         'val_booking_status' => vehicle_booked
                    )
               );

               /* Update booking status */
               $this->db->where('vbk_id', $masterId)->update($this->tbl_vehicle_booking_master, array('vbk_status' => vehicle_booked));

               /* Add followup comment */
               $follCmd['foll_remarks'] = $cmd;
               $follCmd['foll_cus_id'] = $enqId;
               $follCmd['foll_parent'] = 0;
               $follCmd['foll_cus_vehicle_id'] = 0;
               $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
               $follCmd['foll_customer_feedback'] = '';
               $follCmd['foll_can_show_all'] = 1;
               $follCmd['foll_contact'] = 0;
               $follCmd['foll_action_plan'] = '';
               $follCmd['foll_added_by'] = $this->uid;
               $follCmd['foll_updated_by'] = $this->uid;
               $follCmd['foll_is_dar_submited'] = 0;
               $follCmd['foll_is_cmnt'] = 1;
               $this->db->insert($this->tbl_followup, $follCmd);
               $follCmdId = $this->db->insert_id();

               generate_log(array(
                    'log_title' => 'Followup comment',
                    'log_desc' => serialize($data),
                    'log_controller' => 'resubmit-reserve-vehicle',
                    'log_action' => 'C',
                    'log_ref_id' => $follCmdId,
                    'log_added_by' => get_logged_user('usr_id')
               ));
               /* Add followup comment */

               return true;
          }
          return false;
     }

     function bookingFollowup($data)
     {
          $data['vbf_followup_by'] = $this->uid;
          $data['vbf_followup_on'] = date('Y-m-d H:i:s', strtotime($data['vbf_followup_on']));
          $data['vbf_added_on'] = date('Y-m-d H:i:s');
          $data['vbf_followup_on'] = $data['vbf_followup_on'];
          $this->db->insert($this->tbl_vehicle_booking_followup, $data);
     }

     function getBookingFollowup($id = 0)
     {
          if ($id > 0) {
               $this->db->where('vbf_id', $id);
          }
          return $this->db->order_by('vbf_id', 'DESC')->get_where(
               $this->tbl_vehicle_booking_followup,
               array('vbf_followup_by' => $this->uid)
          )->result_array();
     }

     function pendingDocs($bookingId)
     {

          return $this->db->select($this->tbl_address_proof . '.*')
               ->where('adp_id NOT IN(SELECT vbd_doc_type FROM ' . $this->tbl_vehicle_booking_documents . ' WHERE vbd_master_id = ' . $bookingId . ')')
               ->where(array('adp_is_mandatory' => 1, 'adp_status' => 1))->where_in('adp_category', array(0, 2))
               ->get($this->tbl_address_proof)->result_array();
     }

     function cancelledBookings()
     {
          if (check_permission('booking', 'showall')) {
          } else if (check_permission('booking', 'mybking')) {
               //$this->db->where('enq_se_id', $this->uid);
          } else if (check_permission('booking', 'mystaffbking')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          } else if (check_permission('booking', 'myshowroombking')) {
               $this->db->where($this->tbl_enquiry . '.enq_showroom_id', $this->shrm);
          }

          $selectArray = array(
               $this->tbl_enquiry . '.enq_se_id',
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_vehicle_booking_confirmations . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des',
               $this->tbl_statuses . '.sts_access',
               'rfi_rc_sts.sts_title AS rfi_rc_sts_title',
               'rfi_in_sts.sts_title AS rfi_in_sts_title',
               $this->tbl_banks . '.*'
          );
          $this->db->where($this->tbl_vehicle_booking_master . '.vbk_status', cancl_book);
          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_vehicle_booking_confirmations, $this->tbl_vehicle_booking_confirmations . '.vbc_book_master = ' . $this->tbl_vehicle_booking_master . '.vbk_id AND ' . $this->tbl_vehicle_booking_confirmations . '.vbc_verify_by = ' . $this->uid, 'LEFT')
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts', 'LEFT')
               ->join($this->tbl_banks, $this->tbl_banks . '.bnk_id = ' . $this->tbl_vehicle_booking_master . '.vbk_fin_bank_name', 'LEFT')
               ->get($this->tbl_vehicle_booking_master)->result_array();
          //echo $this->db->last_query();
          //debug($bookedVehicle);
          return $bookedVehicle;
     }

     function getRTO($id = '')
     {
          if (!empty($id)) {
               $this->db->where($this->tbl_rto_office . '.rto_id', $id);
               return $this->db->select($this->tbl_rto_office . '.*, ' . $this->tbl_district_statewise . '.*')
                    ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_rto_office . '.rto_dist', 'LEFT')
                    ->get($this->tbl_rto_office)->row_array();
          } else {
               return $this->db->select($this->tbl_rto_office . '.*, ' . $this->tbl_district_statewise . '.*')
                    ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_rto_office . '.rto_dist', 'LEFT')
                    ->get($this->tbl_rto_office)->result_array();
          }
     }

     function editBooking($data)
     {
          if (isset($data['bm']) && !empty($data['bm'])) {
               $vbkId = $data['bm']['vbk_id'];
               $enqId = isset($data['bm']['vbk_enq_id']) ? $data['bm']['vbk_enq_id'] : '';
               $vehId = isset($data['bm']['vbk_evaluation_veh_id']) ? $data['bm']['vbk_evaluation_veh_id'] : '';
               $vehicle = isset($data['add_info']) ? $data['add_info'] : '';
               $status = isset($data['status']) ? $data['status'] : '';
               $narration = isset($data['bm']['vbc_verify_desc']) ? $data['bm']['vbc_verify_desc'] : '';
               $salesStff = isset($data['bm']['vbk_sales_staff']) ? $data['bm']['vbk_sales_staff'] : 0;

               unset($data['bm']['vbk_id']);
               unset($data['bm']['vbk_enq_id']);
               unset($data['bm']['vbc_verify_desc']);
               unset($data['bm']['vbk_sales_staff']);
               unset($data['bm']['vbk_evaluation_veh_id']);

               $data['bm']['vbk_delivery_date'] = (isset($data['bm']['vbk_delivery_date']) && !empty($data['bm']['vbk_delivery_date'])) ? date('Y-m-d H:i:s', strtotime($data['bm']['vbk_delivery_date'])) : NULL;
               $data['bm']['vbk_dob'] = (isset($data['bm']['vbk_dob']) && !empty($data['bm']['vbk_dob'])) ? date('Y-m-d', strtotime($data['bm']['vbk_dob'])) : NULL;
               $data['bm']['vbk_insurance_valid_upto'] = (isset($data['bm']['vbk_insurance_valid_upto']) && !empty($data['bm']['vbk_insurance_valid_upto'])) ?
                    date('Y-m-d', strtotime($data['bm']['vbk_insurance_valid_upto'])) : NULL;

               if (!empty($data['bm']['vbk_insurance_valid_upto'])) {
                    $valupd['val_insurance_company'] = $data['bm']['vbk_insurance_co'];
                    $valupd['val_insurance_validity'] = $data['bm']['vbk_insurance_valid_upto'];
                    $valupd['val_insurance_comp_idv'] = isset($data['bm']['vbk_insurance_idv']) ? $data['bm']['vbk_insurance_idv'] : 0;
                    $valupd['val_insurance_comp_date'] = $data['bm']['vbk_insurance_valid_upto'];
                    $this->db->where('val_id', $vehId)->update($this->tbl_valuation, $valupd);
               }

               if (!empty($data['bm']['vbk_delivery_date'])) {

                    $data['bm']['vbk_status'] = book_delvry;
                    $cmd = $vehicle . " has been delivered, updated by " . $this->session->userdata('usr_username') . '<br><br>' . $narration;

                    //Enquiry history
                    $history['enh_status'] = book_delvry;
                    $history['enh_enq_id'] = $enqId;
                    $history['enh_current_sales_executive'] = $this->uid;
                    $history['enh_booked_vehicle'] = $vehId;
                    $history['enh_remarks'] = $cmd;
                    $history['enh_added_by'] = $this->uid;
                    $history['enh_added_on'] = date('Y-m-d H:i:s');
                    $history['enh_source'] = 2; // Related to reservation
                    $this->db->insert($this->tbl_enquiry_history, $history);
                    $hisId = $this->db->insert_id();

                    //Change inquiry
                    $this->db->where('enq_id', $enqId)->update(
                         $this->tbl_enquiry,
                         array(
                              'enq_current_status' => book_delvry,
                              'enq_current_status_history' => $hisId
                         )
                    );

                    //Change vehicle status
                    $valArray = array();
                    $valArray['val_status'] = book_delvry;
                    $valArray['val_insurance_company'] = $data['bm']['vbk_insurance_co'];
                    $data['bm']['vbk_insurance_amt'] = (isset($data['bm']['vbk_insurance_amt']) && !empty($data['bm']['vbk_insurance_amt'])) ?
                         $data['bm']['vbk_insurance_amt'] : 0;
                    if (!empty($data['bm']['vbk_insurance_valid_upto'])) {
                         $valArray['val_insurance_validity'] = $data['bm']['vbk_insurance_valid_upto'];
                    }
                    $this->db->where('val_id', $vehId)->update($this->tbl_valuation, $valArray);

                    //Add followup comment
                    $follCmd['foll_remarks'] = $cmd;
                    $follCmd['foll_cus_id'] = $enqId;
                    $follCmd['foll_parent'] = 0;
                    $follCmd['foll_cus_vehicle_id'] = 0;
                    $follCmd['foll_entry_date'] = date('Y-m-d H:i:s');
                    $follCmd['foll_customer_feedback'] = '';
                    $follCmd['foll_can_show_all'] = 1;
                    $follCmd['foll_contact'] = 0;
                    $follCmd['foll_action_plan'] = '';
                    $follCmd['foll_added_by'] = $this->uid;
                    $follCmd['foll_updated_by'] = $this->uid;
                    $follCmd['foll_is_dar_submited'] = 0;
                    $follCmd['foll_is_cmnt'] = 1;
                    $this->db->insert($this->tbl_followup, $follCmd);
               }
               /* Enquiry history */
               $usrName = $this->session->userdata('usr_username');
               $history['enh_enq_id'] = $enqId;
               $history['enh_current_sales_executive'] = $salesStff;
               $history['enh_booked_vehicle'] = $vehId;
               $history['enh_status'] = $status;
               $history['enh_remarks'] = 'Booking updated by ' . $usrName;
               $history['enh_source'] = 2; // Related to reservation
               $history['enh_added_by'] = $this->uid;
               $history['enh_added_on'] = date('Y-m-d H:i:s');
               $this->db->insert($this->tbl_enquiry_history, $history);
               $hisId = $this->db->insert_id();

               //Change inquiry
               $this->db->where('enq_id', $enqId)->update($this->tbl_enquiry, array('enq_current_status_history' => $hisId));
               $this->db->where('vbk_id', $vbkId)->update($this->tbl_vehicle_booking_master, $data['bm']);

               generate_log(array(
                    'log_title' => 'Update booking',
                    'log_desc' => serialize($data),
                    'log_controller' => 'update-booking',
                    'log_action' => 'U',
                    'log_ref_id' => $vbkId,
                    'log_added_by' => $this->uid
               ));
               return true;
          }
          return false;
     }
     function getPanCard($bookid)
     {
          $res = $this->db->select($this->tbl_vehicle_booking_documents . '.*, ')
               ->where(array($this->tbl_vehicle_booking_documents . '.vbd_master_id' => $bookid, 'vbd_status' => 1, 'vbd_doc_type' => 2))
               ->get($this->tbl_vehicle_booking_documents)->row_array();
          return $res;
     }

     function getAllReservation($filter = '')
     {

          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_number',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_on',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
               'salesstaff.usr_first_name AS salesstaff_first_name', 'salesstaff.usr_last_name AS salesstaff_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des',
               'rfi_rc_sts.sts_title AS rfi_rc_sts_title',
               'rfi_in_sts.sts_title AS rfi_in_sts_title',
               $this->tbl_divisions . '.div_name'
          );

          if (isset($filter['vbk_added_on_from']) && !empty($filter['vbk_added_on_from'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_from']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) >=', $date);
               $this->db->order_by($this->tbl_vehicle_booking_master . '.vbk_added_on', 'DESC');
          }
          if (isset($filter['vbk_added_on_to']) && !empty($filter['vbk_added_on_to'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_to']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) <=', $date);
          }

          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_users . ' salesstaff', 'salesstaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts', 'LEFT') //  AND vbk_rfi_rc_trans_sts > 0
               ->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts', 'LEFT') //  AND vbk_ins_trans_sts > 0
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->get($this->tbl_vehicle_booking_master)->result_array();

          return $bookedVehicle;
     }



     function getAllBookingsPaginate($postDatas, $filter)
     {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'vbk_added_on'; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value

          // Get the total number of records without pagination
          //$totalRecords = $this->db->select('COUNT(*) as total')->get($this->tbl_vehicle_booking_master)->row()->total;
          $totalRecords = $this->getBookingsTotal($postDatas, $filter);

          // Apply the filters and pagination
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }

          if ($this->uid != 100) {
               if (check_permission('booking', 'showall')) {
               } else if (check_permission('booking', 'mybking')) {
                    $this->db->where('vbk_added_by', $this->uid);
               } else if (check_permission('booking', 'mystaffbking')) {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                         ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               } else if (check_permission('booking', 'myshowroombking')) {
                    $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $this->shrm);
               } else if (check_permission('booking', 'mydivisionbking')) {
                    $this->db->where($this->tbl_divisions . '.div_id', $this->div);
               }
               if (check_permission('booking', 'shownorthregion')) {
                    $this->db->where($this->tbl_showroom . '.shr_region', 1);
               } else if (check_permission('booking', 'showsouthregion')) {
                    $this->db->where($this->tbl_showroom . '.shr_region', 2);
               }
          }

          if (isset($filter['executive']) && !empty($filter['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $filter['executive']);
          }
          if (isset($filter['status']) && !empty($filter['status'])) {
               $this->db->where_in($this->tbl_vehicle_booking_master . '.vbk_status', $filter['status']);
          } else {
               if ($this->uid != 100 && check_permission('booking', 'showonlyconfmbooking')) {
                    $this->db->where($this->tbl_vehicle_booking_master . '.vbk_status', confm_book);
               }
               if (check_permission('booking', 'showbookinganddeliverd')) {
                    $this->db->where('(' . $this->tbl_vehicle_booking_master . '.vbk_status = ' . confm_book . ' OR ' .
                         $this->tbl_vehicle_booking_master . '.vbk_status = ' . book_delvry . ')');
               }
          }
          if (isset($filter['showroom']) && !empty($filter['showroom'])) {
               $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $filter['showroom']);
          }
          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_number',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_on',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
               'salesstaff.usr_first_name AS salesstaff_first_name', 'salesstaff.usr_last_name AS salesstaff_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des',
               'rfi_rc_sts.sts_title AS rfi_rc_sts_title',
               'rfi_in_sts.sts_title AS rfi_in_sts_title',
               $this->tbl_divisions . '.div_name',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_showroom . '.shr_region',
               'tknapdby.usr_username AS tknapdby_username',
               'slsapdby.usr_username AS slsapdby_username'
          );

          if (isset($filter['vbk_added_on_from']) && !empty($filter['vbk_added_on_from'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_from']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) >=', $date);
               $this->db->order_by($this->tbl_vehicle_booking_master . '.vbk_added_on', 'DESC');
          }
          if (isset($filter['vbk_added_on_to']) && !empty($filter['vbk_added_on_to'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_to']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) <=', $date);
          }

          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_vehicle_booking_master . ".vbk_ref_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_vehicle_booking_master . ".vbk_off_ph_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_vehicle_booking_master . ".vbk_per_ph_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_vehicle_booking_master . ".vbk_email LIKE '%" . $searchValue . "%' OR " . $this->tbl_valuation . ".val_veh_no LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $searchValue . "%') ");
          } else {
               $this->db->where_in($this->tbl_statuses . '.sts_value', array(vehicle_booked, confm_book, rfi_loan_approved, dc_ready_to_del, book_delvry));
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_users . ' salesstaff', 'salesstaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts', 'LEFT') //  AND vbk_rfi_rc_trans_sts > 0
               ->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts', 'LEFT') //  AND vbk_ins_trans_sts > 0
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->join($this->tbl_users . ' tknapdby', 'tknapdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_token_approve_by', 'left')
               ->join($this->tbl_users . ' slsapdby', 'slsapdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_sales_approve_by', 'left')
               ->get($this->tbl_vehicle_booking_master)->result_array();
          // echo $this->db->last_query();
          // exit;
          $response = array(
               "draw" => intval($postDatas['draw']),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" =>  $bookedVehicle
          );

          // if ($this->uid == 925) {
          // echo $this->db->last_query();
          // debug($response);
          // }

          return $response;
     }
     function getBookingsTotal($postDatas, $filter)
     {

          $searchValue = $postDatas['search']['value']; // Search value

          if (check_permission('booking', 'showall')) {
          } else if (check_permission('booking', 'mybking')) {
               $this->db->where('vbk_added_by', $this->uid);
          } else if (check_permission('booking', 'mystaffbking')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          } else if (check_permission('booking', 'myshowroombking')) {
               $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $this->shrm);
          } else if (check_permission('booking', 'mydivisionbking')) {
               $this->db->where($this->tbl_divisions . '.div_id', $this->div);
          }
          if (isset($filter['executive']) && !empty($filter['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $filter['executive']);
          }
          if (isset($filter['status']) && !empty($filter['status'])) {
               $this->db->where_in($this->tbl_vehicle_booking_master . '.vbk_status', $filter['status']);
          } else {
               if ($this->uid != 100 && check_permission('booking', 'showonlyconfmbooking')) {
                    $this->db->where($this->tbl_vehicle_booking_master . '.vbk_status', confm_book);
               }
               if (check_permission('booking', 'showbookinganddeliverd')) {
                    $this->db->where('(' . $this->tbl_vehicle_booking_master . '.vbk_status = ' . confm_book . ' OR ' .
                         $this->tbl_vehicle_booking_master . '.vbk_status = ' . book_delvry . ')');
               }
          }


          if (isset($filter['vbk_added_on_from']) && !empty($filter['vbk_added_on_from'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_from']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) >=', $date);
               $this->db->order_by($this->tbl_vehicle_booking_master . '.vbk_added_on', 'DESC');
          }
          if (isset($filter['vbk_added_on_to']) && !empty($filter['vbk_added_on_to'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_to']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) <=', $date);
          }

          // if (!empty($searchValue)) {
          //     $this->db->where("(" . $this->tbl_vehicle_booking_master . ".vbk_ref_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_valuation . ".val_veh_no LIKE '%" . $searchValue . "%' OR "
          //         . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $searchValue . "%') ");
          // }

          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_vehicle_booking_master . ".vbk_ref_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_vehicle_booking_master . ".vbk_off_ph_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_vehicle_booking_master . ".vbk_per_ph_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_vehicle_booking_master . ".vbk_email LIKE '%" . $searchValue . "%' OR " . $this->tbl_valuation . ".val_veh_no LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $searchValue . "%') ");
          }
          $this->db->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left');
          $this->db->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left');
          $this->db->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT');
          $this->db->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left');
          $this->db->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left');

          $this->db->where_in($this->tbl_statuses . '.sts_value', array(vehicle_booked, confm_book, rfi_loan_approved, dc_ready_to_del, book_delvry));
          $result = $this->db->get($this->tbl_vehicle_booking_master)->num_rows();
          return $result;
     }
     function todaysRetails()
     {
          /*if (check_permission('todays_retails', 'showall')) {
          }
          else if (check_permission('todays_retails', 'viewsmartretails')) {
               $this->db->where($this->tbl_divisions . '.div_id', 1);
          } 
          else if (check_permission('todays_retails', 'viewluxuryretails')) {
               $this->db->where($this->tbl_divisions . '.div_id', 2);
          } 
          else if (check_permission('todays_retails', 'myretails')) {
               $this->db->where('vbk_added_by', $this->uid);
          } else if (check_permission('todays_retails', 'mystaffretails')) {
               $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                    ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
          } else if (check_permission('todays_retails', 'myshowroomretails')) {
               $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $this->shrm);
          } else if (check_permission('todays_retails', 'mydivisionretails')) {
               $this->db->where($this->tbl_divisions . '.div_id', $this->div);
          }else{
               return false;
          }*/

          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.vbk_id',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS bkdby_last_name',
               'salesstaff.usr_first_name AS salesstaff_first_name', 'salesstaff.usr_last_name AS salesstaff_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_divisions . '.div_name',
               $this->tbl_showroom . '.shr_location'
          );

          $today = date('Y-m-d'); // Get current date
          $currentTime = date('Y-m-d H:i:s'); // Get current datetime
          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_users . ' salesstaff', 'salesstaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               // ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts', 'LEFT') //  AND vbk_rfi_rc_trans_sts > 0
               //->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts', 'LEFT') //  AND vbk_ins_trans_sts > 0
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->where('date(' . $this->tbl_vehicle_booking_master . '.vbk_added_on)', $today)
               ->where_in($this->tbl_statuses . '.sts_value', array(vehicle_booked, confm_book, rfi_loan_approved, dc_ready_to_del, book_delvry))
               ->order_by("vbk_added_on", "desc")
               ->get($this->tbl_vehicle_booking_master)->result_array();
          return $bookedVehicle;
     }

     function BookingDetailsPushsales($bookid)
     {
          $this->db->query('SET SQL_BIG_SELECTS=1');
          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.vbk_cust_name',
               $this->tbl_vehicle_booking_master . '.vbk_per_address',
               $this->tbl_vehicle_booking_master . '.vbk_rd_trans_address',
               $this->tbl_vehicle_booking_master . '.vbk_added_on',
               $this->tbl_vehicle_booking_master . '.vbk_vehicle_amt AS vbk_ttl_sale_amt',
               $this->tbl_vehicle_booking_master . '.vbk_advance_amt',
               $this->tbl_vehicle_booking_master . '.vbk_bl_amt AS vbk_discount',
               $this->tbl_vehicle_booking_master . '.vbk_ref_no',
               $this->tbl_vehicle_booking_master . '.vbk_fin_year_code',
               $this->tbl_vehicle_booking_master . '.vbk_tcs',
               $this->tbl_vehicle_booking_master . '.vbk_rto_charges',
               'sc.usr_username AS bkdby_username',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_minif_year',
               $this->tbl_valuation . '.val_stock_num',
               $this->tbl_valuation . '.val_model_year',
               $this->tbl_valuation . '.val_engine_no',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_vehicle_colors . '.vc_color AS val_color',
               $this->tbl_model . '.mod_title', $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title', $this->tbl_brand . '.brd_category',
               $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',
               $this->tbl_divisions . '.div_id',
               $this->tbl_district_statewise . '.std_district_name',
               $this->tbl_states . '.sts_name',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_company . '.cmp_name'
          );

          if ($bookid > 0) {
               $bookedVehicle = $this->db->select($selectArray, false)
                    ->join($this->tbl_users . ' sc', 'sc.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_sales_staff', 'LEFT')
                    ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'LEFT')
                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'LEFT')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
                    ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left')
                    ->join($this->tbl_vehicle_colors, $this->tbl_vehicle_colors . '.vc_id = ' . $this->tbl_valuation . '.val_color', 'left')
                    ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_enquiry . '.enq_cus_dist', 'left')
                    ->join($this->tbl_states, $this->tbl_states . '.sts_id = ' . $this->tbl_district_statewise . '.std_state', 'left')
                    ->join($this->tbl_company, $this->tbl_company . '.cmp_finance_year_code = ' . $this->tbl_vehicle_booking_master . '.vbk_fin_year_code', 'left')
                    ->where($this->tbl_vehicle_booking_master . '.vbk_id', $bookid)->get($this->tbl_vehicle_booking_master)->row_array();
               return $bookedVehicle;
          }
     }

     function updatedSaleApproval($saleData, $bkid)
     {
          $this->db->where('vbk_id', $bkid)->update($this->tbl_vehicle_booking_master, array(
               'vbk_pushed' => 1,
               'vbk_sales_approve_by' => $this->uid,
               'vbk_sales_approve_on' => date('Y-m-d H:i:s'),
               'vbk_vehicle_amt' => $saleData['postfields']['vbk_ttl_sale_amt'],
               'vbk_advance_amt' => $saleData['postfields']['vbk_advance_amt'],
               'vbk_bl_amt' => $saleData['postfields']['vbk_discount'],
               'vbk_tcs' => $saleData['postfields']['tcS_Amt']
          ));
          return true;
     }
     function updatedSaleTokenApproval($saleData, $bkid)
     {
          $this->db->where('vbk_id', $bkid)->update($this->tbl_vehicle_booking_master, array(
               'vbk_pushed' => 1,
               'vbk_token_approve_by' => $this->uid,
               'vbk_token_approve_on' => date('Y-m-d H:i:s'),
               'vbk_vehicle_amt' => $saleData['postfields']['vbk_ttl_sale_amt'],
               'vbk_advance_amt' => $saleData['postfields']['vbk_advance_amt'],
               'vbk_bl_amt' => $saleData['postfields']['dc']
          ));
          return true;
     }
     function getPurchaseVeh($enq_id)
     { //jsk

          $selectArray = array(

               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_valuation_date',
               $this->tbl_model . '.mod_title', $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id', $this->tbl_variant . '.var_variant_name',

          );

          $res = $this->db->select($selectArray, false)

               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->where(array($this->tbl_valuation . '.val_enquiry_id' => $enq_id))
               ->order_by($this->tbl_valuation . '.val_id', 'Desc')
               ->get($this->tbl_valuation)->row_array();
          return $res;
     }

     function tokenReceivedAjax($postDatas, $filter)
     {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'vbk_added_on'; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value

          // Get the total number of records without pagination
          $totalRecords = $this->db->select('COUNT(*) as total')->get($this->tbl_vehicle_booking_master)->row()->total;
          // $totalRecords = $this->getBookingsTotal($postDatas, $filter);

          // Apply the filters and pagination
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }

          if ($this->uid != 100) {
               if (check_permission('booking', 'showall')) {
               } else if (check_permission('booking', 'mybking')) {
                    $this->db->where('vbk_added_by', $this->uid);
               } else if (check_permission('booking', 'mystaffbking')) {
                    $mystaffs = explode(',', $this->db->select('GROUP_CONCAT(usr_id) AS usr_id')
                         ->where('usr_tl', $this->uid)->get($this->tbl_users)->row()->usr_id);
                    $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $mystaffs);
               } else if (check_permission('booking', 'myshowroombking')) {
                    $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $this->shrm);
               } else if (check_permission('booking', 'mydivisionbking')) {
                    $this->db->where($this->tbl_divisions . '.div_id', $this->div);
               }
               if (check_permission('booking', 'shownorthregion')) {
                    $this->db->where($this->tbl_showroom . '.shr_region', 1);
               } else if (check_permission('booking', 'showsouthregion')) {
                    $this->db->where($this->tbl_showroom . '.shr_region', 2);
               }
          }

          if (isset($filter['executive']) && !empty($filter['executive'])) {
               $this->db->where_in($this->tbl_enquiry . '.enq_se_id', $filter['executive']);
          }
          if (isset($filter['status']) && !empty($filter['status'])) {
               $this->db->where_in($this->tbl_vehicle_booking_master . '.vbk_status', $filter['status']);
          } else {
               if ($this->uid != 100 && check_permission('booking', 'showonlyconfmbooking')) {
                    $this->db->where($this->tbl_vehicle_booking_master . '.vbk_status', confm_book);
               }
               if (check_permission('booking', 'showbookinganddeliverd')) {
                    $this->db->where('(' . $this->tbl_vehicle_booking_master . '.vbk_status = ' . confm_book . ' OR ' .
                         $this->tbl_vehicle_booking_master . '.vbk_status = ' . book_delvry . ')');
               }
          }
          if (isset($filter['showroom']) && !empty($filter['showroom'])) {
               $this->db->where($this->tbl_vehicle_booking_master . '.vbk_showroom', $filter['showroom']);
          }
          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_number',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_on',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
               'salesstaff.usr_first_name AS salesstaff_first_name', 'salesstaff.usr_last_name AS salesstaff_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des',
               'rfi_rc_sts.sts_title AS rfi_rc_sts_title',
               'rfi_in_sts.sts_title AS rfi_in_sts_title',
               $this->tbl_divisions . '.div_name',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_showroom . '.shr_region'
          );

          if (isset($filter['vbk_added_on_from']) && !empty($filter['vbk_added_on_from'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_from']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) >=', $date);
               $this->db->order_by($this->tbl_vehicle_booking_master . '.vbk_added_on', 'DESC');
          }
          if (isset($filter['vbk_added_on_to']) && !empty($filter['vbk_added_on_to'])) {
               $date = date('Y-m-d', strtotime($filter['vbk_added_on_to']));
               $this->db->where('DATE(' . $this->tbl_vehicle_booking_master . '.vbk_added_on) <=', $date);
          }

          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_vehicle_booking_master . ".vbk_ref_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_vehicle_booking_master . ".vbk_off_ph_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_vehicle_booking_master . ".vbk_per_ph_no LIKE '%" . $searchValue . "%' OR " . $this->tbl_vehicle_booking_master . ".vbk_email LIKE '%" . $searchValue . "%' OR " . $this->tbl_valuation . ".val_veh_no LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $searchValue . "%') ");
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_users . ' salesstaff', 'salesstaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts', 'LEFT') //  AND vbk_rfi_rc_trans_sts > 0
               ->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts', 'LEFT') //  AND vbk_ins_trans_sts > 0
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->where('vbk_is_token_recvd', 1)->where_in($this->tbl_statuses . '.sts_value', array(vehicle_booked, confm_book, rfi_loan_approved, dc_ready_to_del, book_delvry))
               ->get($this->tbl_vehicle_booking_master)->result_array();

          $response = array(
               "draw" => intval($postDatas['draw']),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" =>  $bookedVehicle
          );

          // if ($this->uid == 925) {
          // echo $this->db->last_query();
          // debug($response);
          // }

          return $response;
     }

     function pendningbookingapprovalAjax($postDatas, $filter)
     {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'vbk_added_on'; // Column name
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
          if ($this->uid != 100) {
               $mystaffs = my_staff($this->uid);
               if (check_permission('booking', 'canapprovetokenforihits') && check_permission('booking', 'canapprovebookingforihits')) {
                    $this->db->where('(vbk_token_approve_by = 0 OR vbk_sales_approve_by = 0)');
               } else if (check_permission('booking', 'canapprovetokenforihits')) {
                    $this->db->where('vbk_token_approve_by', 0);
               } else if (check_permission('booking', 'canapprovebookingforihits')) {
                    $this->db->where('vbk_sales_approve_by', 0);
               }
               if (check_permission('booking', 'showall')) {
               } else if (check_permission('booking', 'mybking')) {
                    $this->db->where('vbk_sales_staff', $this->uid);
               } else if (check_permission('booking', 'mystaffbking')) {
                    $this->db->where_in('vbk_sales_staff', $mystaffs);
               } else if (check_permission('booking', 'myshowroombking')) {
                    $this->db->where('vbk_showroom', $this->shrm);
               }
          }

          $totalRecords = $this->db
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->count_all_results($this->tbl_vehicle_booking_master);

          // Apply the filters and pagination


          if ($this->uid != 100) {
               $mystaffs = my_staff($this->uid);
               if (check_permission('booking', 'canapprovetokenforihits') && check_permission('booking', 'canapprovebookingforihits')) {
                    $this->db->where('(vbk_token_approve_by = 0 OR vbk_sales_approve_by = 0)');
               } else if (check_permission('booking', 'canapprovetokenforihits')) {
                    $this->db->where('vbk_token_approve_by', 0);
               } else if (check_permission('booking', 'canapprovebookingforihits')) {
                    $this->db->where('vbk_sales_approve_by', 0);
               }
               if (check_permission('booking', 'showall')) {
               } else if (check_permission('booking', 'mybking')) {
                    $this->db->where('vbk_sales_staff', $this->uid);
               } else if (check_permission('booking', 'mystaffbking')) {
                    $this->db->where_in('vbk_sales_staff', $mystaffs);
               } else if (check_permission('booking', 'myshowroombking')) {
                    $this->db->where('vbk_showroom', $this->shrm);
               }
          }

          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.*',
               $this->tbl_enquiry . '.enq_id',
               $this->tbl_enquiry . '.enq_cus_name',
               $this->tbl_enquiry . '.enq_cus_mobile',
               $this->tbl_enquiry . '.enq_mode_enq',
               $this->tbl_enquiry . '.enq_number',
               $this->tbl_enquiry . '.enq_entry_date',
               $this->tbl_enquiry . '.enq_added_on',
               'bkdby.usr_first_name AS bkdby_first_name', 'bkdby.usr_last_name AS btdby_last_name',
               'salesstaff.usr_first_name AS salesstaff_first_name', 'salesstaff.usr_last_name AS salesstaff_last_name',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_chasis_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_model . '.mod_id',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_statuses . '.sts_title',
               $this->tbl_statuses . '.sts_des',
               'rfi_rc_sts.sts_title AS rfi_rc_sts_title',
               'rfi_in_sts.sts_title AS rfi_in_sts_title',
               $this->tbl_divisions . '.div_name',
               $this->tbl_showroom . '.shr_location',
               $this->tbl_showroom . '.shr_region'
          );

          if (!empty($searchValue)) {
               $this->db->where("(" . $this->tbl_vehicle_booking_master . ".vbk_ref_no LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_vehicle_booking_master . ".vbk_off_ph_no LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_vehicle_booking_master . ".vbk_per_ph_no LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_vehicle_booking_master . ".vbk_email LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_valuation . ".val_veh_no LIKE '%" . $searchValue . "%' OR "
                    . $this->tbl_enquiry . ".enq_cus_name LIKE '%" . $searchValue . "%') ");
          }
          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }
          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_enquiry, $this->tbl_enquiry . '.enq_id = ' . $this->tbl_vehicle_booking_master . '.vbk_enq_id', 'left')
               ->join($this->tbl_users . ' bkdby', 'bkdby.usr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_added_by', 'left')
               ->join($this->tbl_users . ' salesstaff', 'salesstaff.usr_id = ' . $this->tbl_enquiry . '.enq_se_id', 'left')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_statuses, $this->tbl_statuses . '.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_status', 'LEFT')
               ->join($this->tbl_statuses . ' rfi_rc_sts', 'rfi_rc_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_rfi_rc_trans_sts', 'LEFT') //  AND vbk_rfi_rc_trans_sts > 0
               ->join($this->tbl_statuses . ' rfi_in_sts', 'rfi_in_sts.sts_value = ' . $this->tbl_vehicle_booking_master . '.vbk_ins_trans_sts', 'LEFT') //  AND vbk_ins_trans_sts > 0
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->join($this->tbl_divisions, $this->tbl_divisions . '.div_id = ' . $this->tbl_showroom . '.shr_division', 'left')
               ->get($this->tbl_vehicle_booking_master)->result_array();

          $response = array(
               "draw" => intval($postDatas['draw']),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" =>  $bookedVehicle
          );
          return $response;
     }
}
