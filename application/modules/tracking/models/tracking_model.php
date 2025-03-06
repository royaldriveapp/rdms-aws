<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class tracking_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->db->query("SET time_zone = '+05:30'");

          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_enquiry = TABLE_PREFIX . 'enquiry';
          $this->tbl_vehicle = TABLE_PREFIX . 'vehicle';
          $this->tbl_tracking = TABLE_PREFIX . 'tracking';
          $this->tbl_showroom = TABLE_PREFIX . 'showroom';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_designation = TABLE_PREFIX . 'designation';
          $this->tbl_enquiry_history = TABLE_PREFIX . 'enquiry_history';
          $this->tbl_vehicle_booking_master = TABLE_PREFIX . 'vehicle_booking_master';
          $this->view_vehicle_vehicle_status = TABLE_PREFIX . 'view_vehicle_vehicle_status';
     }

     function getBookings()
     {
          $selectArray = array(
               $this->tbl_vehicle_booking_master . '.vbk_id',
               $this->tbl_vehicle_booking_master . '.vbk_enq_id',
               $this->tbl_vehicle_booking_master . '.vbk_ref_no',
               $this->tbl_vehicle_booking_master . '.vbk_off_ph_no',
               $this->tbl_vehicle_booking_master . '.vbk_per_ph_no',
               $this->tbl_vehicle_booking_master . '.vbk_delivery_date',
               $this->tbl_valuation . '.val_id',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_stock_num',
               $this->tbl_model . '.mod_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_id',
               $this->tbl_variant . '.var_variant_name'
          );
          $bookedVehicle = $this->db->select($selectArray, false)
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               //->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_vehicle_booking_master . '.vbk_showroom', 'left')
               ->get($this->tbl_vehicle_booking_master)->result_array();

          return $bookedVehicle;
     }

     function getVehicles()
     {
          return $this->db->select($this->tbl_valuation . '.val_veh_no,' . $this->tbl_model . '.mod_title,' . $this->tbl_brand . '.brd_title,' .
               $this->tbl_variant . '.var_variant_name')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->get($this->tbl_valuation)->result_array();
     }


     function getEvaluation()
     {
          $excludeId = $this->db->select('GROUP_CONCAT(trk_vehicle_no) AS trk_vehicle_no')->where('trk_check_in_date IS NULL')
               ->get($this->tbl_tracking)->row()->trk_vehicle_no;

          if (!empty($excludeId)) {
               $this->db->where_not_in($this->tbl_valuation . '.val_id', explode(',', $excludeId));
          }
          $select = array(
               $this->tbl_valuation . '.val_id',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_model . '.mod_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_variant_name'
          );
          return $this->db->select($select)
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->where($this->tbl_valuation . '.val_status >= 1')->get($this->tbl_valuation)->result_array();
          //, array(1, 39)
     }

     function getTracking($id = '')
     {
          $fields = array(
               $this->tbl_tracking . '.trk_number',
               $this->tbl_tracking . '.trk_vehicle_no',
               $this->tbl_tracking . '.trk_out_pass_time',
               $this->tbl_tracking . '.trk_out_pass_purpose',
               $this->tbl_tracking . '.trk_out_pass_other_driver',
               $this->tbl_tracking . '.trk_out_pass_to_place',
               $this->tbl_tracking . '.trk_out_pass_km',
               $this->tbl_tracking . '.trk_out_pass_est_return_time',
               $this->tbl_tracking . '.trk_id',
               $this->tbl_tracking . '.trk_out_pass_purpose',
               $this->tbl_tracking . '.trk_out_pass_rd_driver',
               $this->tbl_tracking . '.trk_check_in_rd_driver',
               $this->tbl_tracking . '.trk_check_in_other_driver',
               $this->tbl_tracking . '.trk_check_in_rd_showroom',
               $this->tbl_tracking . '.trk_check_in_date',
               $this->tbl_tracking . '.trk_check_in_km',
               $this->tbl_tracking . '.trk_check_in_remarks',
               $this->tbl_valuation . '.val_id',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_valuation . '.val_fuel',
               $this->tbl_users . '.usr_emp_code',
               $this->tbl_users . '.usr_username',
               'added_by.usr_id AS added_id, added_by.usr_first_name AS added_first_name',
               'checkin_by.usr_id AS checkin_by_id, checkin_by.usr_first_name AS checkin_by_first_name',
               'out_pass_to.shr_location AS out_pass_to_location, out_pass_to.shr_address AS out_pass_to_address',
               $this->tbl_model . '.mod_title',
               $this->tbl_brand . '.brd_title',
               $this->tbl_variant . '.var_variant_name',
               $this->tbl_designation . '.desig_title AS added_by_desig_title'
          );
          if (!empty($id)) {

               generate_log(array(
                    'log_title' => 'Read records',
                    'log_desc' => 'Read tracking pass issued',
                    'log_controller' => strtolower(__CLASS__),
                    'log_action' => 'R',
                    'log_ref_id' => $id,
                    'log_added_by' => get_logged_user('usr_id')
               ));

               return $this->db->select($fields)
                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_rd_driver', 'left')
                    ->join($this->tbl_users . ' added_by', 'added_by.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_added_by', 'left')
                    ->join($this->tbl_users . ' checkin_by', 'checkin_by.usr_id = ' . $this->tbl_tracking . '.trk_check_in_added_by', 'left')
                    ->join($this->tbl_showroom . ' out_pass_to', 'out_pass_to.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_to', 'left')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = added_by.usr_designation_new', 'left')
                    ->where($this->tbl_tracking . '.trk_id', $id)->get($this->tbl_tracking)->row_array();
          } else {
               return $this->db->select($this->tbl_tracking . '.*,' . $this->tbl_valuation . '.*,' . $this->tbl_users . '.*,' .
                    'added_by.usr_id AS added_id, added_by.usr_first_name AS added_first_name, '
                    . 'checkin_by.usr_id AS checkin_by_id, checkin_by.usr_first_name AS checkin_by_first_name,'
                    . 'out_pass_to.shr_location AS out_pass_to_location, out_pass_to.shr_address AS out_pass_to_address')
                    ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
                    ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_rd_driver', 'left')
                    ->join($this->tbl_users . ' added_by', 'added_by.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_added_by', 'left')
                    ->join($this->tbl_users . ' checkin_by', 'checkin_by.usr_id = ' . $this->tbl_tracking . '.trk_check_in_added_by', 'left')
                    ->join($this->tbl_showroom . ' out_pass_to', 'out_pass_to.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_to', 'left')
                    ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
                    ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
                    ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
                    ->join($this->tbl_designation, $this->tbl_designation . '.desig_id = added_by.usr_designation_new', 'left')
                    ->get($this->tbl_tracking)->result_array();
          }
     }

     function insert($data)
     {
          //           if($this->uid=100){trk_out_pass_to,trk_out_pass_to_place
          // debug($data);
          //           }
          $vehicleName = '';
          $toNumber = '';
          if (isset($data['txtVehicle'])) {
               $vehicleName = $data['txtVehicle'];
               unset($data['txtVehicle']);
          }
          if (isset($data['txtCustNumber'])) {
               $toNumber = $data['txtCustNumber'];
               unset($data['txtCustNumber']);
          }
          if (!empty($data)) {
               $valId = isset($data['vbk_evaluation_veh_id']) ? $data['vbk_evaluation_veh_id'] : 0;

               /*update as deliverd*/
               $txtDeliveryDate = '';
               if (isset($data['txtDeliveryDate'])) {
                    $txtDeliveryDate = $data['txtDeliveryDate'];
                    unset($data['txtDeliveryDate']);

                    if (empty($txtDeliveryDate) && (isset($data['trk_booking_no']) && !empty($data['trk_booking_no']))) {
                         $this->db->where('vbk_id', $data['trk_booking_no'])->update($this->tbl_vehicle_booking_master, array(
                              'vbk_delivery_date' => date('Y-m-d H:i:s'),
                              'vbk_status' => 40
                         ));

                         /**/

                         $this->load->model('purchase/purchase_model', 'purchase');
                         $cdo = $this->purchase->getCustomerDelightStaff();
                         $apiData = array(
                              "apiKey" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY1MDJmY2ZiOTQzM2U4MGJjZTQ5OGE4MyIsIm5hbWUiOiJST1lBTERSSVZFIFBSRSBPV05FRCBDQVJTIExMUCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2NTAyZmNmYjk0MzNlODBiY2U0OThhN2UiLCJhY3RpdmVQbGFuIjoiQkFTSUNfTU9OVEhMWSIsImlhdCI6MTY5NDY5NDY1MX0.EfRR_D4lFORcRC4rkGr9xglt21CP412EDVTRPOFxuYc",
                              "campaignName" => "vehicle_deliverd",
                              'destination' => $toNumber,
                              'userName' => 'royaldrive9090@gmail.com',
                              'templateParams' => array($vehicleName, '+' . $cdo['usr_did_number'], $cdo['usr_username'] . '\n' . $cdo['desig_title'])
                         );
                         $data_string = json_encode($apiData);
                         $ch = curl_init('https://backend.aisensy.com/campaign/t1/api/v2');
                         curl_setopt_array($ch, array(
                              CURLOPT_POST => true,
                              CURLOPT_POSTFIELDS => $data_string,
                              CURLOPT_HTTPHEADER => array('Content-Type:application/json', 'Content-Length: ' . strlen($data_string)),
                              CURLOPT_RETURNTRANSFER => true
                         ));
                         $result = curl_exec($ch);
                         /**/
                    }
               }
               if (isset($data['txtEnqId'])) {
                    $txtEnqId = $data['txtEnqId'];
                    unset($data['txtEnqId']);

                    $usrName = $this->session->userdata('usr_username');
                    $history['enh_enq_id'] = $txtEnqId;
                    $history['enh_current_sales_executive'] = 0;
                    $history['enh_booked_vehicle'] = $valId;
                    $history['enh_status'] = 40;
                    $history['enh_remarks'] = $usrName . ' issued gate pass, and make it deliverd status';
                    $history['enh_added_by'] = $this->uid;
                    $history['enh_added_on'] = date('Y-m-d H:i:s');
                    $history['enh_source'] = 2; // Related to reservation
                    $this->db->insert($this->tbl_enquiry_history, $history);
                    $hisId = $this->db->insert_id();

                    if (!empty($txtEnqId)) {
                         $this->db->where('enq_id', $txtEnqId)->update($this->tbl_enquiry, array(
                              'enq_current_status' => 40,
                              'enq_current_status_history' => $hisId
                         ));
                    }
               }
               if (!empty($valId)) {
                    $this->db->where('val_id', $valId)->update($this->tbl_valuation, array(
                         'val_status' => 40,
                         'val_is_sold' => 1,
                         'val_sold_date' => date('Y-m-d : H:i:s')
                    ));
               }
               /*update as deliverd*/

               $prefix = 'RD';
               $number = rand(0, 99999) + time();
               $data['trk_number'] = $prefix . '-' . $number;
               $data['trk_out_pass_added_by'] = $this->uid;
               $data['trk_out_pass_added_date'] = date('Y-m-d H:i:s');
               $data['trk_out_pass_showroom'] = isset($data['trk_out_pass_showroom']) ? $data['trk_out_pass_showroom'] :
                    get_logged_user('usr_showroom');

               if ($this->db->insert($this->tbl_tracking, array_filter($data))) {
                    $lastId = $this->db->insert_id();
                    generate_log(array(
                         'log_title' => 'Issue gate pass' . date('Y-m-d H:i:s'),
                         'log_desc' => serialize($data),
                         'log_controller' => 'issue-gate-pass',
                         'log_action' => 'C',
                         'log_ref_id' => $lastId,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    return $lastId;
               } else {
                    generate_log(array(
                         'log_title' => 'New records',
                         'log_desc' => 'Error while issue new tracking card',
                         'log_controller' => 'issue-gate-pass-error',
                         'log_action' => 'C',
                         'log_added_by' => get_logged_user('usr_id')
                    ));
               }
          } else {
               return false;
          }
     }

     function update($data)
     {
          if (!empty($data)) {
               $id = $data['trk_id'];
               unset($data['trk_id']);
               $data['trk_last_updated_by'] = $this->uid;
               $data['trk_last_updated_on'] = date('Y-m-d H:i:s');
               $this->db->where('trk_id', $id);

               if ($this->db->update($this->tbl_tracking, array_filter($data))) {
                    generate_log(array(
                         'log_title' => 'Update records ' . date('Y-m-d H:i:s'),
                         'log_desc' => serialize($data),
                         'log_controller' => 'update-gate-pass',
                         'log_action' => 'U',
                         'log_ref_id' => $id,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    return true;
               } else {
                    generate_log(array(
                         'log_title' => 'Update records',
                         'log_desc' => 'Error on update tracking pass',
                         'log_controller' => 'update-gate-pass-error',
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

     function checkinVehicle($data)
     {
          if (!empty($data)) {
               $trkId = $data['trk_id'];
               unset($data['trk_id']);
               $this->db->where('trk_id', $trkId);
               $data['trk_check_in_added_by'] = $this->uid;
               $data['trk_check_in_added_date'] = date('Y-m-d H:i:s');
               if ($this->db->update($this->tbl_tracking, $data)) {
                    generate_log(array(
                         'log_title' => 'Check in vehicle ' . date('Y-m-d H:i:s'),
                         'log_desc' => serialize($data),
                         'log_controller' => 'check-in',
                         'log_action' => 'U',
                         'log_ref_id' => $trkId,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    return true;
               } else {
                    generate_log(array(
                         'log_title' => 'Check in vehicle ' . date('Y-m-d H:i:s'),
                         'log_desc' => serialize($data),
                         'log_controller' => 'check-in-error',
                         'log_action' => 'U',
                         'log_ref_id' => $trkId,
                         'log_added_by' => get_logged_user('usr_id')
                    ));
                    return false;
               }
          } else {
               return false;
          }
     }

     /* function getTrackingByVehicleId($vehId) {
         return $this->db->select($this->tbl_tracking . '.*,' . $this->tbl_valuation . '.*,' . $this->tbl_users . '.*,' .
         'added_by.usr_id AS added_id, added_by.usr_first_name AS added_first_name, '
         . 'checkin_by.usr_id AS checkin_by_id, checkin_by.usr_first_name AS checkin_by_first_name, '
         . 'out_pass_to.shr_location AS out_pass_to_location, out_pass_to.shr_address AS out_pass_to_address, '
         . 'check_in.shr_location AS check_in_location, check_in.shr_address AS check_in_address, '
         . 'check_in.shr_location AS check_out_from_location, check_in.shr_address AS check_out_from_address, ' .
         $this->view_vehicle_vehicle_status . '.*')
         ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
         ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_rd_driver', 'left')
         ->join($this->tbl_users . ' added_by', 'added_by.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_added_by', 'left')
         ->join($this->tbl_users . ' checkin_by', 'checkin_by.usr_id = ' . $this->tbl_tracking . '.trk_check_in_added_by', 'left')
         ->join($this->tbl_showroom . ' out_pass_to', 'out_pass_to.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_to', 'left')
         ->join($this->tbl_showroom . ' check_in', 'check_in.shr_id = ' . $this->tbl_tracking . '.trk_check_in_rd_showroom', 'left')
         ->join($this->tbl_showroom . ' check_out_from', 'check_out_from.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_showroom', 'left')
         ->join($this->view_vehicle_vehicle_status, $this->view_vehicle_vehicle_status . '.veh_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
         ->where($this->tbl_tracking . '.trk_vehicle_no', $vehId)->get($this->tbl_tracking)->result_array();
         } */

     //       function getTrackingByVehicleId($vehId) {
     //            return $this->db->select($this->tbl_tracking . '.*,' . $this->tbl_valuation . '.*,' . $this->tbl_users . '.*,' .
     //                                    'added_by.usr_id AS added_id, added_by.usr_first_name AS added_first_name, '
     //                                    . 'checkin_by.usr_id AS checkin_by_id, checkin_by.usr_first_name AS checkin_by_first_name, '
     //                                    . 'out_pass_to.shr_location AS out_pass_to_location, out_pass_to.shr_address AS out_pass_to_address, '
     //                                    . 'check_in.shr_location AS check_in_location, check_in.shr_address AS check_in_address, '
     //                                    . 'check_in.shr_location AS check_out_from_location, check_in.shr_address AS check_out_from_address, ' .
     //                                    $this->tbl_vehicle . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_model . '.*,' . $this->tbl_brand . '.*')
     //                            ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
     //                            ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_rd_driver', 'left')
     //                            ->join($this->tbl_users . ' added_by', 'added_by.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_added_by', 'left')
     //                            ->join($this->tbl_users . ' checkin_by', 'checkin_by.usr_id = ' . $this->tbl_tracking . '.trk_check_in_added_by', 'left')
     //                            ->join($this->tbl_showroom . ' out_pass_to', 'out_pass_to.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_to', 'left')
     //                            ->join($this->tbl_showroom . ' check_in', 'check_in.shr_id = ' . $this->tbl_tracking . '.trk_check_in_rd_showroom', 'left')
     //                            ->join($this->tbl_showroom . ' check_out_from', 'check_out_from.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_showroom', 'left')
     //                            ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
     //                            ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
     //                            ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
     //                            ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
     //                            ->order_by($this->tbl_tracking . '.trk_check_in_date', 'DESC')
     //                            ->where($this->tbl_tracking . '.trk_vehicle_no', $vehId)->get($this->tbl_tracking)->result_array();
     //       }

     function getTrackingByVehicleId($vehId)
     {
          return $this->db->select($this->tbl_tracking . '.trk_check_in_date, trk_check_in_date, trk_number, trk_check_in_other_place, trk_check_in_other_driver,trk_check_in_km,' .
               'trk_out_pass_purpose,trk_out_pass_time, trk_out_pass_to_place, trk_out_pass_other_driver, trk_out_pass_km,' .
               $this->tbl_valuation . '.val_id,' . $this->tbl_users . '.usr_first_name,' .
               'added_by.usr_id AS added_id, added_by.usr_first_name AS added_first_name, added_by.usr_showroom AS added_show_room,'
               . 'checkin_by.usr_id AS checkin_by_id, checkin_by.usr_first_name AS checkin_by_first_name, checkin_by.usr_showroom AS checkin_show_room,'
               . 'out_pass_to.shr_location AS out_pass_to_location, out_pass_to.shr_address AS out_pass_to_address, '
               . 'check_in.shr_location AS check_in_location, check_in.shr_address AS check_in_address, '
               . 'check_in.shr_location AS check_out_from_location, check_in.shr_address AS check_out_from_address, ' .
               $this->tbl_vehicle . '.veh_id,' . $this->tbl_variant . '.var_variant_name,' . $this->tbl_model .
               '.mod_title,' . $this->tbl_brand . '.brd_title,' .
               'added_by_tmp.shr_location AS added_by_tmp_show, checkin_by_tmp.shr_location AS checkin_by_tmp_show,' .
               'check_out_from.shr_location AS checkout_from, checkin_driver.usr_first_name AS checkin_driver_first_name')
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_rd_driver', 'left')
               ->join($this->tbl_users . ' added_by', 'added_by.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_added_by', 'left')
               ->join($this->tbl_users . ' checkin_by', 'checkin_by.usr_id = ' . $this->tbl_tracking . '.trk_check_in_added_by', 'left')
               ->join($this->tbl_users . ' checkin_driver', 'checkin_driver.usr_id = ' . $this->tbl_tracking . '.trk_check_in_rd_driver', 'left')
               ->join($this->tbl_showroom . ' out_pass_to', 'out_pass_to.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_to', 'left')
               ->join($this->tbl_showroom . ' check_in', 'check_in.shr_id = ' . $this->tbl_tracking . '.trk_check_in_rd_showroom', 'left')
               ->join($this->tbl_showroom . ' check_out_from', 'check_out_from.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_showroom', 'left')
               ->join($this->tbl_vehicle, $this->tbl_vehicle . '.veh_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_showroom . ' added_by_tmp', 'added_by_tmp.shr_id = added_by.usr_showroom', 'LEFT')
               ->join($this->tbl_showroom . ' checkin_by_tmp', 'checkin_by_tmp.shr_id = checkin_by.usr_showroom', 'LEFT')
               ->order_by($this->tbl_tracking . '.trk_id', 'DESC')
               ->where($this->tbl_tracking . '.trk_vehicle_no', $vehId)->get($this->tbl_tracking)->result_array();
     }

     function getAllVehiclesForTracking()
     {
          return $this->db->select($this->tbl_valuation . '.*,' . $this->tbl_model . '.*,' .
               $this->tbl_brand . '.*,' . $this->tbl_variant . '.*,' . $this->tbl_users . '.*,' . $this->tbl_showroom . '.*')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->where_in($this->tbl_valuation . '.val_type', array(1, 2))->get($this->tbl_valuation)->result_array();
     }
     function getAllVehiclesForTrackingAjax($postDatas)
     { //jsk
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'ccb_id'; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value

          $totalRecords = $this->db->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->where_in($this->tbl_valuation . '.val_type', array(1, 2))->count_all_results($this->tbl_valuation);

          if ($rowperpage > 0) {
               $this->db->limit($rowperpage, $row);
          }
          if ($searchValue != '') {
               $this->db->where("(val_veh_no LIKE '%" . $searchValue . "%' OR brd_title LIKE '%" . $searchValue . "%' OR "
                    . "var_variant_name LIKE '%" . $searchValue . "%' OR mod_title LIKE '%" . $searchValue . "%') ");
          }
          $data = $this->db->select($this->tbl_valuation . '.val_id,' . $this->tbl_valuation . '.val_veh_no,' . $this->tbl_model . '.mod_id,' . $this->tbl_model . '.mod_title,' .
               $this->tbl_brand . '.brd_id,' . $this->tbl_brand . '.brd_title,' . $this->tbl_variant . '.var_id,' . $this->tbl_variant . '.var_variant_name,' . $this->tbl_users . '.usr_id,' . $this->tbl_showroom . '.shr_id')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_valuation . '.val_added_by', 'left')
               ->join($this->tbl_showroom, $this->tbl_showroom . '.shr_id = ' . $this->tbl_valuation . '.val_showroom', 'left')
               ->where_in($this->tbl_valuation . '.val_type', array(1, 2))->get($this->tbl_valuation)->result_array();

          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }
     function getTrackingPaginate($postDatas)
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
          if (!empty($searchValue)) {
               // try {
               //      $date = new DateTime($searchValue);
               //      $searchValue = $date->format('Y-m-d');
               // } catch (Exception $e) {
               //      $searchValue;
               // }
               $this->db->where("(trk_number LIKE '%" . $searchValue . "%' OR val_veh_no LIKE '%" . $searchValue . "%' OR vbk_ref_no LIKE '%" . $searchValue . "%')");
               //    $this->db->where("(trk_number LIKE '%" . $searchValue . "%' OR trk_vehicle_no LIKE '%" . $searchValue . "%' OR "
               //        . "trk_out_pass_time LIKE '%" . $searchValue . "%' OR trk_out_pass_other_driver LIKE '%" . $searchValue . "%' OR trk_out_pass_to_place LIKE '%" . $searchValue . "%' OR added_by.usr_first_name LIKE '%" . $searchValue . "%'OR val_veh_no LIKE '%" . $searchValue . "%'OR $this->tbl_valuation.val_prt_4 LIKE '%" . $searchValue . "%') ");
          }

          $fields = array(
               $this->tbl_tracking . '.trk_number',
               $this->tbl_tracking . '.trk_vehicle_no',
               $this->tbl_tracking . '.trk_out_pass_time',
               $this->tbl_tracking . '.trk_out_pass_purpose',
               $this->tbl_tracking . '.trk_out_pass_other_driver',
               $this->tbl_tracking . '.trk_out_pass_to_place',
               $this->tbl_tracking . '.trk_out_pass_km',
               $this->tbl_tracking . '.trk_out_pass_est_return_time',
               $this->tbl_tracking . '.trk_id',
               $this->tbl_tracking . '.trk_out_pass_purpose',
               $this->tbl_tracking . '.trk_out_pass_rd_driver',
               $this->tbl_tracking . '.trk_check_in_rd_driver',
               $this->tbl_tracking . '.trk_check_in_other_driver',
               $this->tbl_tracking . '.trk_check_in_rd_showroom',
               $this->tbl_tracking . '.trk_check_in_date',
               $this->tbl_tracking . '.trk_check_in_km',
               $this->tbl_tracking . '.trk_check_in_remarks',
               $this->tbl_valuation . '.val_id',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_users . '.usr_username',
               'added_by.usr_id AS added_id, added_by.usr_first_name AS added_first_name',
               'checkin_by.usr_id AS checkin_by_id, checkin_by.usr_first_name AS checkin_by_first_name',
               'out_pass_to.shr_location AS out_pass_to_location, out_pass_to.shr_address AS out_pass_to_address',
               $this->tbl_vehicle_booking_master . '.vbk_ref_no',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name'
          );
          if (check_permission('tracking', 'showcheckincreatedbyme')) {
               $this->db->where('added_by.usr_id = ' . $this->uid);
          }
          $data = $this->db->select($fields)
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_rd_driver', 'left')
               ->join($this->tbl_users . ' added_by', 'added_by.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_added_by', 'left')
               ->join($this->tbl_users . ' checkin_by', 'checkin_by.usr_id = ' . $this->tbl_tracking . '.trk_check_in_added_by', 'left')
               ->join($this->tbl_showroom . ' out_pass_to', 'out_pass_to.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_to', 'left')
               ->join($this->tbl_vehicle_booking_master, $this->tbl_vehicle_booking_master . '.vbk_id = ' . $this->tbl_tracking . '.trk_booking_no', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->order_by('trk_id', 'DESC')->get($this->tbl_tracking)->result_array();
          // Count total records
          $this->db->from($this->tbl_tracking);
          $totalRecords = $this->db->count_all_results();

          $response = array(
               "draw" => intval($draw),
               "iTotalRecords" => $totalRecords,
               "iTotalDisplayRecords" => $totalRecords,
               "aaData" => $data
          );
          return $response;
     }

     function getAlltracking($filter = '')
     {




          $fields = array(
               $this->tbl_tracking . '.trk_number',
               $this->tbl_tracking . '.trk_vehicle_no',
               $this->tbl_tracking . '.trk_out_pass_time',
               $this->tbl_tracking . '.trk_out_pass_purpose',
               $this->tbl_tracking . '.trk_out_pass_other_driver',
               $this->tbl_tracking . '.trk_out_pass_to_place',
               $this->tbl_tracking . '.trk_out_pass_km',
               $this->tbl_tracking . '.trk_out_pass_est_return_time',
               $this->tbl_tracking . '.trk_id',
               $this->tbl_tracking . '.trk_out_pass_purpose',
               $this->tbl_tracking . '.trk_out_pass_rd_driver',
               $this->tbl_tracking . '.trk_check_in_rd_driver',
               $this->tbl_tracking . '.trk_check_in_other_driver',
               $this->tbl_tracking . '.trk_check_in_rd_showroom',
               $this->tbl_tracking . '.trk_check_in_date',
               $this->tbl_tracking . '.trk_check_in_km',
               $this->tbl_tracking . '.trk_check_in_remarks',
               $this->tbl_tracking . '.trk_booking_no',
               $this->tbl_valuation . '.val_id',
               $this->tbl_valuation . '.val_veh_no',
               $this->tbl_users . '.usr_username',
               'added_by.usr_id AS added_id, added_by.usr_first_name AS added_first_name',
               'checkin_by.usr_id AS checkin_by_id, checkin_by.usr_first_name AS checkin_by_first_name',
               'out_pass_to.shr_location AS out_pass_to_location, out_pass_to.shr_address AS out_pass_to_address',
               $this->tbl_brand . '.brd_title',
               $this->tbl_model . '.mod_title',
               $this->tbl_variant . '.var_variant_name',
          );

          $data = $this->db->select($fields)
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_tracking . '.trk_vehicle_no', 'left')
               ->join($this->tbl_users, $this->tbl_users . '.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_rd_driver', 'left')
               ->join($this->tbl_users . ' added_by', 'added_by.usr_id = ' . $this->tbl_tracking . '.trk_out_pass_added_by', 'left')
               ->join($this->tbl_users . ' checkin_by', 'checkin_by.usr_id = ' . $this->tbl_tracking . '.trk_check_in_added_by', 'left')
               ->join($this->tbl_showroom . ' out_pass_to', 'out_pass_to.shr_id = ' . $this->tbl_tracking . '.trk_out_pass_to', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->order_by('trk_id', 'DESC')->get($this->tbl_tracking)->result_array();
          $this->db->from($this->tbl_tracking);

          return $data;
     }
}
