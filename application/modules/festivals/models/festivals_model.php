<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class festivals_model extends CI_Model
{

     public function __construct()
     {
          parent::__construct();
          $this->load->database();
          $this->db->query("SET time_zone = '+05:30'");


          $this->tbl_events = TABLE_PREFIX . 'events';
          $this->tbl_event_enquires = TABLE_PREFIX . 'event_enquires';
          $this->tbl_district_statewise = TABLE_PREFIX . 'district_statewise';
     }



     public function getFestivalPaginate($postDatas) {
          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : 0; // Default to the first column
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : 'eve_id'; // Default column
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          $searchValue = $postDatas['search']['value']; // Search value
  //debug($columnName);
          // Build query
          if ($rowperpage > 0) {
              $this->db->limit($rowperpage, $row);
          }
          if (!empty($searchValue)) {
               $this->db->where("(eve_name LIKE '%" . $searchValue . "%' OR eve_mobile LIKE '%" . $searchValue . "%')");
          }
  
          $fields = array(
              $this->tbl_events . '.evnt_id',
              $this->tbl_events . '.evnt_title',
              $this->tbl_event_enquires . '.eve_id',
              $this->tbl_event_enquires . '.eve_ref_no',
              $this->tbl_event_enquires . '.eve_name',
              $this->tbl_event_enquires . '.eve_mobile',
              $this->tbl_event_enquires . '.eve_whatsapp',
              $this->tbl_event_enquires . '.eve_email',
              $this->tbl_event_enquires . '.eve_vehicle_string',
              $this->tbl_event_enquires . '.eve_district',
              $this->tbl_event_enquires . '.eve_purchase_period',
              $this->tbl_event_enquires . '.eve_interested_in_car', // if 1 Yes if 0 No 
              $this->tbl_event_enquires . '.eve_added_on', // convert day-Month-Year       
              $this->tbl_district_statewise . '.std_district_name as district_name'
          );
  
          $this->db->select($fields)
              ->from($this->tbl_events)
              ->join($this->tbl_event_enquires, $this->tbl_event_enquires . '.eve_event = ' . $this->tbl_events . '.evnt_id', 'left')
              ->join($this->tbl_district_statewise, $this->tbl_district_statewise . '.std_id = ' . $this->tbl_event_enquires . '.eve_district', 'left')
              ->where('eve_event', '54')
              ->order_by($columnName, $columnSortOrder) // Use the dynamic column sorting
              ->limit($rowperpage, $row); // Apply pagination
          $data = $this->db->get()->result_array();
  
          // Count total records
          $this->db->from($this->tbl_event_enquires); // Start with the event enquires table
          $this->db->where('eve_event', '54'); // Add the same condition
          $totalRecords = $this->db->count_all_results(); // Count the records
  
          $response = array(
              "draw" => intval($draw),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecords,
              "aaData" => $data
          );
          return $response;
      }

   
}
