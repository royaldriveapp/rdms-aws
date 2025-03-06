<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class settings_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();

          $this->table = TABLE_PREFIX . 'settings';
          $this->tbl_users = TABLE_PREFIX . 'users';
          $this->tbl_model = TABLE_PREFIX_RANA . 'model';
          $this->tbl_brand = TABLE_PREFIX_RANA . 'brand';
          $this->tbl_valuation = TABLE_PREFIX . 'valuation';
          $this->tbl_variant = TABLE_PREFIX_RANA . 'variant';
          $this->tbl_callcenterbridging = TABLE_PREFIX . 'callcenterbridging';
          $this->tbl_vehicle_booking_master = TABLE_PREFIX . 'vehicle_booking_master';
     }

     function newSettings($values)
     {
          if (!empty($values)) {
               foreach ($values as $key => $value) {
                    $this->dropSettingsByKey($key);
                    $insert['set_key'] = trim($key);
                    $insert['set_value'] = trim($value);
                    $this->db->insert($this->table, $insert);
               }
               return true;
          } else {
               return false;
          }
     }

     function getSettings($key = '')
     {

          $this->db->select('*')->from($this->table);
          if (!empty($key)) {
               return $this->db->where('set_key', $key)->get()->row_array();
          } else {
               return $this->db->get()->result_array();
          }
     }

     function dropSettingsByKey($key)
     {
          if (!empty($key)) {
               $this->db->where('set_key', $key);
               $this->db->delete($this->table);
               return true;
          } else {
               return false;
          }
     }

     function getCallList()
     {
          $return = $this->db->select("ccb_id, CONCAT('https://pbx.voxbaysolutions.com/callrecordings/', ccb_recording_URL) AS ccb_recording_URL", false)
               ->order_by('ccb_id', 'DESC')->limit(100, 0)
               ->get_where($this->tbl_callcenterbridging, array('ccb_callStatus_id' => 18, 'ccb_is_download_voice' => 0, 'ccb_is_downloaded' => 0))->result_array();

          $this->db->where('ccb_is_downloaded', 0)->update($this->tbl_callcenterbridging, array('ccb_is_downloaded' => 1));
          return $return;
     }

     function getDownloadCallListPendning()
     {
          return $this->db->where(array('ccb_is_downloaded' => 0, 'ccb_callStatus_id' => 18))->count_all_results($this->tbl_callcenterbridging);
     }

     function wishesAlert()
     {
          //Message for Car Anniversary.
          $data['carAnniversary'] = $this->db->select(
               array(
                    'vbk_ref_no',
                    'vbk_cust_name',
                    'vbk_per_ph_no',
                    'vbk_per_ph_no',
                    'vbk_delivery_date',
                    'brd_title',
                    'mod_title',
                    'var_variant_name'
               )
          )
               ->join($this->tbl_valuation, $this->tbl_valuation . '.val_id = ' . $this->tbl_vehicle_booking_master . '.vbk_evaluation_veh_id', 'left')
               ->join($this->tbl_model, $this->tbl_model . '.mod_id = ' . $this->tbl_valuation . '.val_model', 'left')
               ->join($this->tbl_brand, $this->tbl_brand . '.brd_id = ' . $this->tbl_valuation . '.val_brand', 'left')
               ->join($this->tbl_variant, $this->tbl_variant . '.var_id = ' . $this->tbl_valuation . '.val_variant', 'left')
               ->where('vbk_status', 40)->like('vbk_delivery_date', date('m-d'), 'both')
               ->get($this->tbl_vehicle_booking_master)->result_array();

          //Birthday wishes of staff.
          $data['stafBirthday'] = $this->db->select('usr_username, usr_dob, usr_phone')
               ->where("DATE_FORMAT(usr_dob, '%m-%d') = '" . date('m-d') . "'")
               ->where(array('usr_active' => 1, 'usr_resigned' => 0))->where('usr_resigned_date IS NULL')
               ->get($this->tbl_users)->result_array();

          //Joining anniversary of staff.
          $data['stafWorkAnni'] = $this->db->select("usr_username, usr_doj, usr_phone")
               ->where("DATE_FORMAT(usr_doj, '%m-%d') = '" . date('m-d') . "'")
               ->where(array('usr_active' => 1, 'usr_resigned' => 0))->where('usr_resigned_date IS NULL')
               ->get($this->tbl_users)->result_array();

          //Marriage anniversary of staff.
          $data['stafMarAnni'] = $this->db->select('usr_username, usr_marriage_date, usr_phone')
               ->where("DATE_FORMAT(usr_marriage_date, '%m-%d') = '" . date('m-d') . "'")
               ->where(array('usr_active' => 1, 'usr_resigned' => 0))->where('usr_resigned_date IS NULL')
               ->get($this->tbl_users)->result_array();
          return $data;
     }
}
