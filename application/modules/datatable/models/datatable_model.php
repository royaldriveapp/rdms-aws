<?php

if (!defined('BASEPATH'))
     exit('No direct script access allowed');

class datatable_model extends CI_Model {

     public function __construct() {
          parent::__construct();
          $this->load->database();
          $this->tbl_register_master = TABLE_PREFIX . 'register_master';
     }

     function getTableFields($table = '') {
          $table = empty($table) ? $this->tbl_register_master : $table;
          return $this->db->list_fields($table);
     }

     function fetchDBDetails($postDatas) {

          $draw = $postDatas['draw'];
          $row = $postDatas['start'];
          $rowperpage = $postDatas['length']; // Rows display per page
          $columnIndex = isset($postDatas['order'][0]['column']) ? $postDatas['order'][0]['column'] : ''; // Column index
          $columnName = isset($postDatas['columns'][$columnIndex]['data']) ? $postDatas['columns'][$columnIndex]['data'] : ''; // Column name 
          $columnSortOrder = isset($postDatas['order'][0]['dir']) ? $postDatas['order'][0]['dir'] : 'DESC'; // asc or desc
          ## Search 

          $totalRecords = $this->db->count_all_results($this->tbl_register_master);

          if (!empty($columnName) && !empty($columnSortOrder)) {
               $this->db->order_by($columnName, $columnSortOrder);
          }

          $data = $this->db->limit($rowperpage, $row)->get($this->tbl_register_master)->result_array();

          ## Response
          $response = array(
              "draw" => intval($draw),
              "iTotalRecords" => $totalRecords,
              "iTotalDisplayRecords" => $totalRecords,
              "aaData" => $data
          );
          //debug($response);
          return $response;
     }

     function export() {
          return $this->db->limit(100)->get($this->tbl_register_master)->result_array();
     }

}
